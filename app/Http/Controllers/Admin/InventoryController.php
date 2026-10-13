<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\User;
use App\Notifications\GenericNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->stock_status === 'out') {
            $query->where('stock', 0);
        }

        if ($request->stock_status === 'low') {
            $query->where('stock', '>', 0)
                ->where('stock', '<=', 5);
        }

        $products = $query->latest()->paginate(5)->withQueryString();
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $lowStockProducts = Product::where('stock', '>', 0)->where('stock', '<=', 5)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();

        return view('admin.inventory.index', compact('products', 'totalProducts', 'totalStock', 'lowStockProducts', 'outOfStockProducts'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('admin.inventory.adjust', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:stock_in,stock_out,adjustment'],
            'quantity' => ['required', 'integer', 'min:0'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $productName = '';

        DB::transaction(function () use ($validated, &$productName) {

            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);
            $productName = $product->name;
            $stockBefore = (int) $product->stock;

            if ($validated['type'] === 'stock_in') {
                $quantityChange = (int) $validated['quantity'];
            } elseif ($validated['type'] === 'stock_out') {
                $quantityChange = - ((int) $validated['quantity']);
            } else {
                $newStock = (int) $validated['quantity'];
                $quantityChange = $newStock - $stockBefore;
            }

            $stockAfter = $stockBefore + $quantityChange;

            if ($stockAfter < 0) {
                abort(422, 'Stock cannot be less than zero.');
            }

            $product->update([
                'stock' => $stockAfter,
            ]);

            InventoryTransaction::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => $validated['type'],
                'quantity_change' => $quantityChange,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reason' => $validated['reason'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                if ($stockAfter === 0) {
                    $admin->notify(new GenericNotification(
                        title: 'Out of Stock Alert',
                        message: "Product \"{$product->name}\" is now completely out of stock!",
                        type: 'error',
                        url: route('admin.inventory.show', $product->id)
                    ));
                } elseif ($stockAfter <= 5) {
                    $admin->notify(new GenericNotification(
                        title: 'Low Stock Warning',
                        message: "Product \"{$product->name}\" has low inventory ({$stockAfter} left).",
                        type: 'warning',
                        url: route('admin.inventory.show', $product->id)
                    ));
                }
            }
        });

        if (Auth::check() && Auth::user()->role === 'admin') {
            Auth::user()->notify(new GenericNotification(
                title: 'Inventory Adjusted',
                message: "Stock levels for \"{$productName}\" were successfully updated.",
                type: 'success',
                url: route('admin.inventory.index')
            ));
        }

        return redirect()->route('admin.inventory.index')->with('success', 'Inventory updated successfully.');
    }

    public function show(Product $product)
    {
        $transactions = $product->inventoryTransactions()->with('user')->latest()->paginate(5);

        return view('admin.inventory.show', compact('product', 'transactions'));
    }
}
