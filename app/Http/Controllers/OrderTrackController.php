<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackController extends Controller
{
    public function index(Request $request)
    {
        $order = null;

        if ($request->filled('order_number')) {
            $order = Order::with('items')
                ->where('order_number', $request->order_number)
                ->first();
        }

        return view('pages.track', compact('order'));
    }
}
