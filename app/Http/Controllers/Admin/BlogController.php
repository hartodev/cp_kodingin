<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with(['category', 'user'])
            ->withCount('comments')
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->category, fn($q) => $q->where('blog_category_id', $request->category))
            ->when($request->has('status'), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = BlogCategory::active()->get();

        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->get();

        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        $this->assertHasText($request);

        DB::transaction(function () use ($request) {
            $data                = $request->only(['title', 'blog_category_id', 'seo_description', 'status']);
            $data['slug']        = Str::slug($request->title);
            $data['user_id']     = auth()->id();
            $data['description'] = $this->buildDescription($request->input('blocks', []));

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('blogs', 'public');
            }

            $blog = Blog::create($data);
            $this->syncBlocks($blog, $request);
        });

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog berhasil dipublikasikan.');
    }

    // Route: blogs/{blog}
    public function show(Blog $blog)
    {
        $blog->load(['category', 'blocks', 'comments.user']);

        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::active()->get();
        $blog->load('blocks');

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate($this->rules());
        $this->assertHasText($request);

        DB::transaction(function () use ($request, $blog) {
            $data                = $request->only(['title', 'blog_category_id', 'seo_description', 'status']);
            $data['slug']        = Str::slug($request->title);
            $data['description'] = $this->buildDescription($request->input('blocks', []));

            if ($request->hasFile('image')) {
                if ($blog->image) {
                    Storage::disk('public')->delete($blog->image);
                }
                $data['image'] = $request->file('image')->store('blogs', 'public');
            }

            $blog->update($data);
            $this->syncBlocks($blog, $request);
        });

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog berhasil diperbarui.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog berhasil dihapus.');
    }

    // ------------------------------------------------------------------
    // Helper
    // ------------------------------------------------------------------

    private function rules(): array
    {
        return [
            'title'              => 'required|string|max:255',
            'blog_category_id'   => 'required|exists:blog_categories,id',
            'seo_description'    => 'nullable|string|max:255',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'             => 'boolean',

            'blocks'             => 'required|array|min:1',
            'blocks.*.id'        => 'nullable|integer',
            'blocks.*.type'      => 'required|in:text,image',
            'blocks.*.content'   => 'nullable|string',
            'blocks.*.caption'   => 'nullable|string|max:255',
            'blocks.*.image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    /** Minimal harus ada 1 blok teks yang terisi. */
    private function assertHasText(Request $request): void
    {
        $hasText = collect($request->input('blocks', []))
            ->contains(fn($b) => ($b['type'] ?? null) === 'text' && trim($b['content'] ?? '') !== '');

        if (! $hasText) {
            throw ValidationException::withMessages([
                'blocks' => 'Isi blog minimal harus punya satu blok teks.',
            ]);
        }
    }

    /** Gabungan semua teks -> disimpan di kolom description (dipakai pencarian & SEO). */
    private function buildDescription(array $blocks): string
    {
        return collect($blocks)
            ->filter(fn($b) => ($b['type'] ?? null) === 'text' && trim($b['content'] ?? '') !== '')
            ->map(fn($b) => trim($b['content']))
            ->implode("\n\n");
    }

    /**
     * Sinkronkan blok: urutan mengikuti urutan form,
     * blok lama yang tidak dikirim lagi akan dihapus (beserta file gambarnya).
     */
    private function syncBlocks(Blog $blog, Request $request): void
    {
        $existing = $blog->blocks()->get()->keyBy('id');
        $keep     = [];
        $order    = 0;

        foreach ($request->input('blocks', []) as $key => $row) {
            $type  = $row['type'];
            $block = ! empty($row['id']) ? $existing->get((int) $row['id']) : null;

            $payload = ['type' => $type, 'sort_order' => $order];

            if ($type === 'text') {
                $content = trim($row['content'] ?? '');
                if ($content === '') {
                    continue; // blok teks kosong dilewati
                }
                $payload['content'] = $content;
            } else {
                $payload['caption'] = $row['caption'] ?? null;
                $file = $request->file("blocks.$key.image");

                if ($file) {
                    if ($block && $block->image) {
                        Storage::disk('public')->delete($block->image);
                    }
                    $payload['image'] = $file->store('blog-blocks', 'public');
                } elseif (! $block) {
                    continue; // blok gambar baru tanpa file dilewati
                }
            }

            $block = $block ? tap($block)->update($payload) : $blog->blocks()->create($payload);

            $keep[] = $block->id;
            $order++;
        }

        foreach ($existing->except($keep) as $old) {
            if ($old->image) {
                Storage::disk('public')->delete($old->image);
            }
            $old->delete();
        }
    }
}
