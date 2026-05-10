<?php

namespace App\Http\Controllers\User;

// php artisan make:controller User/CartController

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Course;

class CartController extends Controller
{
    // GET /dashboard/cart
    public function index()
    {
        $carts = Cart::with(['course.category', 'course.level'])
            ->where('user_id', auth()->id())
            ->get();

        return view('user.cart', compact('carts'));
    }

    // POST /dashboard/cart/add/{course}
    public function store(Course $course)
    {
        $user = auth()->user();

        if ($user->isEnrolled($course->id)) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kamu sudah memiliki akses ke kursus ini.'], 422);
            }
            return back()->with('error', 'Kamu sudah memiliki akses ke kursus ini.');
        }

        if ($user->isInCart($course->id)) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kursus sudah ada di keranjang.'], 422);
            }
            return back()->with('error', 'Kursus sudah ada di keranjang.');
        }

        Cart::create(['user_id' => $user->id, 'course_id' => $course->id]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Kursus ditambahkan ke keranjang.']);
        }

        return back()->with('success', 'Kursus berhasil ditambahkan ke keranjang!');
    }

    // DELETE /dashboard/cart/{cart}
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Kursus dihapus dari keranjang.');
    }
}
