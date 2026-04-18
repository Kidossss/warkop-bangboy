<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('pages.cart', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session('cart', []);

        $variantId = $request->input('variant_id');
        $variant = null;
        $price = $product->price;
        $variantName = null;

        if ($variantId) {
            $variant = ProductVariant::find($variantId);
            if ($variant && $variant->product_id == $product->id) {
                $price = $variant->price;
                $variantName = $variant->name;
            }
        }

        $cartKey = $variantId ? $product->id . '-' . $variantId : (string) $product->id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += 1;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'variant_id' => $variantId,
                'name' => $product->name,
                'variant_name' => $variantName,
                'price' => $price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        session(['cart' => $cart]);

        // Return JSON jika request AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $product->name . ($variantName ? " ($variantName)" : '') . ' ditambahkan ke keranjang!',
                'cart_count' => count($cart),
            ]);
        }

        return redirect()->back()->with('success', $product->name . ($variantName ? " ($variantName)" : '') . ' ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int) $request->quantity);
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Keranjang dikosongkan.');
    }
}
