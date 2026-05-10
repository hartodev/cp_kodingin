<?php

namespace App\Http\Controllers\Frontend;

// php artisan make:controller Frontend/ContactController

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::where('status', true)->orderBy('order')->get();

        $faqs = Faq::where('status', true)->orderBy('order')->limit(6)->get();

        $contactInfo = [
            'email'   => Setting::get('site_email'),
            'phone'   => Setting::get('site_phone'),
            'address' => Setting::get('site_address'),
        ];

        return view('frontend.contact', compact('socialLinks', 'faqs', 'contactInfo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim! Kami akan menghubungi kamu segera.');
    }
}
