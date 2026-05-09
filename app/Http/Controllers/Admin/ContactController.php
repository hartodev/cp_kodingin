<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/ContactController

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::when($request->search, fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('subject', 'like', "%{$request->search}%"))
            ->when($request->has('is_read'), fn($q) => $q->where('is_read', $request->is_read))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $unreadCount = Contact::where('is_read', false)->count();

        return view('admin.contacts.index', compact('contacts', 'unreadCount'));
    }

    // Route: contacts/{contact}
    public function show(Contact $contact)
    {
        if (! $contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function markRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);

        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}