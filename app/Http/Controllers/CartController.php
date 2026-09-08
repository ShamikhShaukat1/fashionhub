<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
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

        $shipping = $subtotal > 0 ? 10 : 0;
        $total = $subtotal + $shipping;

        return view('cart.index', compact( 'cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        if (!$product->status) {
            return back()->with('error', 'This product is currently unavailable.');
        }

        if ($product->stock <= 0) {
            return back()->with('error', 'This product is out of stock.');
        }

        $quantity = (int) $request->input('quantity', 1);

        if ($quantity < 1) {
            $quantity = 1;
        }

        if ($quantity > $product->stock) {
            return back()->with( 'error',"Only {$product->stock} item(s) are available.");
        }

        $cart = session()->get('cart', []);
        $currentQuantity = $cart[$product->id] ?? 0;
        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $product->stock) {
            return back()->with( 'error', "Only {$product->stock} item(s) are available."
            );
        }

        $cart[$product->id] = $newQuantity;
        session()->put('cart', $cart);
        return back()->with('success','Product added to cart successfully.'
        );
    }
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $quantity = $validated['quantity'];

        if (!$product->status) {
            return back()->with( 'error', 'This product is currently unavailable.');
        }

        if ($quantity > $product->stock) {
            return back()->with( 'error', "Only {$product->stock} item(s) are available.");
        }

        $cart = session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            return back()->with( 'error', 'Product is not in your cart.');
        }

        $cart[$product->id] = $quantity;
        session()->put('cart', $cart);

        return back()->with( 'success', 'Cart updated successfully.');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
        }

        session()->put('cart', $cart);

        return back()->with( 'success', 'Product removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }
}
