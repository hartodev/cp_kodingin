<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/CheckoutController

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // GET /dashboard/checkout/{order}
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.course', 'youtubeVerification']);

        $youtubeSetting = \App\Models\Setting::get('youtube_channel_url');

        return view('user.checkout', compact('order', 'youtubeSetting'));
    }

    // POST /dashboard/checkout
    public function store(Request $request)
    {
        $user  = auth()->user();
        $carts = Cart::with('course')
            ->where('user_id', $user->id)
            ->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kamu kosong. Tambahkan kursus terlebih dahulu.');
        }

        // Cek kalau ada kursus yang sudah dienroll
        foreach ($carts as $cart) {
            if ($user->isEnrolled($cart->course_id)) {
                return back()->with('error', 'Kamu sudah memiliki akses ke kursus "' . $cart->course->title . '".');
            }
        }

        // Buat order
        $order = Order::create([
            'invoice_id' => Order::generateInvoiceId(),
            'user_id'    => $user->id,
            'status'     => 'pending',
        ]);

        // Buat order items dari cart
        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id'     => $order->id,
                'course_id'    => $cart->course_id,
                'course_title' => $cart->course->title,
            ]);
        }

        // Kosongkan cart
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('user.checkout.show', $order)
            ->with('success', 'Order berhasil dibuat! Silakan lanjutkan verifikasi subscribe YouTube.');
    }
}
