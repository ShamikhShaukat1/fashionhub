<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'items'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {

                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('shipping_name', 'like', "%{$search}%")
                    ->orWhere('shipping_email', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {

                        $customerQuery->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");

                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['customer','items.product',]);

        return view('admin.orders.show',compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,shipped,delivered,cancelled',],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.orders.show', $order)->with('success','Order status updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success','Order deleted successfully.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error','Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $quantity) {
            if (!isset($products[$productId])) {
                continue;
            }

            $product = $products[$productId];
            $price = $product->sale_price !== null && $product->sale_price < $product->price ? $product->sale_price : $product->price;
            $itemSubtotal = $price * $quantity;

            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $itemSubtotal,
            ];
            $subtotal += $itemSubtotal;
        }

        if (empty($cartItems)) {
            session()->forget('cart');

            return redirect()->route('cart.index')->with('error','Your cart is no longer available.');
        }

        $shipping = 200;
        $total = $subtotal + $shipping;

        return view('checkout.index',compact('cartItems','subtotal','shipping','total'));
    }

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_email' => ['required','email', 'max:255'],
            'shipping_phone' => ['required', 'string','max:30'],
            'shipping_address' => ['required','string','max:500'],
            'shipping_city' => ['required','string','max:100'],
            'shipping_postal_code' => ['nullable','string','max:20'],
            'payment_method' => ['required','in:cash_on_delivery'],
            'notes' => ['nullable','string','max:1000'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error','Your cart is empty.');
        }

        try {

            $order = DB::transaction(function () use ($cart,$validated,$request) {
                $subtotal = 0;
                $orderItems = [];

                foreach ($cart as $productId => $quantity) {
                    $product = Product::where('id', $productId)->lockForUpdate()->first();

                    if (!$product) {
                        throw new \Exception(
                            'One of the products in your cart no longer exists.'
                        );
                    }

                    if (!$product->status) {
                        throw new \Exception(
                            "{$product->name} is currently unavailable."
                        );
                    }

                    if ($product->stock < $quantity) {
                        throw new \Exception(
                            "Only {$product->stock} item(s) of {$product->name} are available."
                        );
                    }

                    $price = $product->sale_price !== null && $product->sale_price < $product->price ? $product->sale_price : $product->price;
                    $itemSubtotal = $price * $quantity;
                    $subtotal += $itemSubtotal;

                    $orderItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $itemSubtotal,
                    ];
                }

                $shipping = 200;
                $total = $subtotal + $shipping;

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'order_number' => 'FH-' . strtoupper(Str::random(10)),
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'payment_method' => $validated['payment_method'],
                    'subtotal' => $subtotal,
                    'shipping_amount' => $shipping,
                    'total' => $total,
                    'shipping_name' => $validated['shipping_name'],
                    'shipping_email' => $validated['shipping_email'],
                    'shipping_phone' => $validated['shipping_phone'],
                    'shipping_address' => $validated['shipping_address'],
                    'shipping_city' => $validated['shipping_city'],
                    'shipping_postal_code' => $validated['shipping_postal_code'] ?? null,
                    'notes' => $validated['notes'] ?? null,
                ]);

                foreach ($orderItems as $item) {
                    $product = $item['product'];
                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    $product->decrement('stock',$item['quantity']);
                }

                return $order;
            });

        } catch (\Exception $e) {
            return back()->withInput()->with('error',$e->getMessage());
        }
        session()->forget('cart');

        return redirect()->route('orders.confirmation',$order)->with('success','Your order has been placed successfully.');
    }

    public function confirmation(Order $order)
    {
        abort_unless($order->user_id === Auth::id(),403);
        $order->load(['items.product']);

        return view('orders.confirmation',compact('order'));
    }

    public function customerOrders()
    {
        $orders = Order::where('user_id',Auth::id())->latest()->paginate(10);

        return view('orders.index',compact('orders'));
    }

    public function customerShow(Order $order)
    {
        abort_unless($order->user_id === Auth::id(),403);
        $order->load(['items.product']);

        return view('orders.show',compact('order'));
    }
}
