<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang kosong!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $deliveryFee = 0;
        $total = $subtotal;

        return view('pages.checkout', compact('cart', 'subtotal', 'deliveryFee', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'customer_address' => 'required|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cash',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang kosong!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $deliveryFee = 0;
        $total = $subtotal;

        DB::beginTransaction();

        try {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'customer_address' => $request->customer_address,
                'notes' => $request->notes,
                'payment_method' => 'cash',
                'status' => 'pending',
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
            ]);

            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('order.success', $order->order_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function success($orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        return view('pages.order-success', compact('order'));
    }
}
