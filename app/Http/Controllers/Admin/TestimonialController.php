<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
     public function index()
    {
        $testimonials = Testimonial::orderBy('order')->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'title'  => 'nullable|string|max:100',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'boolean',
        ]);

        $data          = $request->except(['image', '_token']);
        $data['order'] = Testimonial::max('order') + 1;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'title'  => 'nullable|string|max:100',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'boolean',
        ]);

        $data = $request->except(['image', '_token', '_method']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('success', 'Testimoni berhasil dihapus.');
    }
}
