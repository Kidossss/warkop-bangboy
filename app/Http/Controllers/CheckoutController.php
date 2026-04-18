<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index');

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('pages.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:191',
            'customer_phone' => 'required|string|max:191',
            'customer_address' => 'required|string|max:191',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index');

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'order_number' => 'WB' . now()->format('Ymd') . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_address' => $request->customer_address,
            'notes' => $request->notes,
            'payment_method' => 'cash',
            'status' => 'pending',
            'subtotal' => $subtotal,
            'delivery_fee' => 0,
            'total' => $subtotal,
        ]);

        foreach ($cart as $item) {
            $productName = $item['name'];
            if (!empty($item['variant_name'])) {
                $productName .= ' (' . $item['variant_name'] . ')';
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $productName,
                'product_price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('order.success', $order->order_number);
    }

    public function success($orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        return view('pages.order-success', compact('order'));
    }
}
