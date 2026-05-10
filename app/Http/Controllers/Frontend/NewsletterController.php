<?php

namespace App\Http\Controllers\Frontend;

// php artisan make:controller Frontend/NewsletterController

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email|max:100']);

        Newsletter::firstOrCreate(
            ['email' => $request->email],
            ['is_active' => true]
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil subscribe newsletter! Terima kasih.',
            ]);
        }

        return back()->with('success', 'Berhasil subscribe newsletter! Terima kasih.');
    }
}
