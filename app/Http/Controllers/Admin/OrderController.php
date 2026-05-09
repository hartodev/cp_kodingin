<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/OrderController

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'items.course'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where(function ($q) use ($request) {
                $q->where('invoice_id', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    // Route: orders/{order}
    public function show(Order $order)
    {
        $order->load(['user', 'items.course', 'youtubeVerification.verifiedBy']);

        return view('admin.orders.show', compact('order'));
    }
}