<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
     public function index(Request $request)
    {
        $newsletters = Newsletter::when($request->search, fn($q) =>
                $q->where('email', 'like', "%{$request->search}%"))
            ->when(isset($request->is_active), fn($q) =>
                $q->where('is_active', $request->is_active))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.newsletters.index', compact('newsletters'));
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return back()->with('success', 'Subscriber berhasil dihapus.');
    }
}
