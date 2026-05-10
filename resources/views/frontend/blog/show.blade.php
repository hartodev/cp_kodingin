@extends('frontend.layouts.app')

@section('title', $blog->title)
@section('meta_description', $blog->seo_description ?? Str::limit(strip_tags($blog->description), 155))

@section('content')

    <section style="padding:5rem 3rem 8rem;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">
            <div style="display:grid;grid-template-columns:1fr 320px;gap:3rem;align-items:start;">

                {{-- Konten Blog --}}
                <article>
                    {{-- Breadcrumb --}}
                    <div style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;">
                        <a href="{{ url('/blog') }}" style="color:var(--gold-primary);text-decoration:none;">Blog</a>
                        <span style="margin:0 0.5rem;">/</span>
                        @if ($blog->category)
                            <a href="{{ url('/blog?category=' . $blog->category->slug) }}"
                                style="color:var(--gold-primary);text-decoration:none;">{{ $blog->category->name }}</a>
                            <span style="margin:0 0.5rem;">/</span>
                        @endif
                        <span>{{ Str::limit($blog->title, 40) }}</span>
                    </div>

                    {{-- Category & Meta --}}
                    <span class="blog-card-category" style="font-size:0.72rem;">{{ $blog->category->name ?? 'Blog' }}</span>

                    <h1
                        style="font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;line-height:1.2;margin:1rem 0;background:linear-gradient(135deg,#fff,var(--gold-primary));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                        {{ $blog->title }}
                    </h1>

                    <div
                        style="display:flex;gap:1.5rem;flex-wrap:wrap;font-size:0.85rem;color:var(--text-secondary);margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:1px solid rgba(255,255,255,0.06);">
                        <span><i class="fas fa-user"
                                style="color:var(--gold-primary);margin-right:4px;"></i>{{ $blog->user->name ?? '-' }}</span>
                        <span><i class="fas fa-calendar"
                                style="color:var(--gold-primary);margin-right:4px;"></i>{{ $blog->created_at->format('d M Y') }}</span>
                        <span><i class="fas fa-comments"
                                style="color:var(--gold-primary);margin-right:4px;"></i>{{ $blog->comments->count() }}
                            komentar</span>
                    </div>

                    {{-- Cover Image --}}
                    @if ($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}"
                            style="width:100%;border-radius:20px;margin-bottom:2rem;max-height:400px;object-fit:cover;border:1px solid rgba(244,196,48,0.1);">
                    @endif

                    {{-- Konten --}}
                    <div
                        style="font-size:0.95rem;color:var(--text-secondary);line-height:1.9;white-space:pre-line;margin-bottom:3rem;">
                        {{ $blog->description }}
                    </div>

                    {{-- Komentar --}}
                    <div id="comments" style="margin-bottom:3rem;">
                        <h3 style="font-size:1.2rem;font-weight:800;margin-bottom:1.5rem;">
                            Komentar ({{ $blog->comments->count() }})
                        </h3>

                        @forelse($blog->comments as $comment)
                            <div
                                style="display:flex;gap:1rem;padding:1.2rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.08);border-radius:14px;margin-bottom:0.8rem;">
                                <div
                                    style="width:40px;height:40px;background:linear-gradient(135deg,var(--gold-primary),var(--gold-light));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--dark-1);font-size:0.85rem;flex-shrink:0;">
                                    {{ strtoupper(substr($comment->user->name ?? 'U', 0, 2)) }}
                                </div>
                                <div style="flex:1;">
                                    <div style="display:flex;justify-content:space-between;margin-bottom:0.4rem;">
                                        <span
                                            style="font-weight:600;font-size:0.9rem;">{{ $comment->user->name ?? '-' }}</span>
                                        <span
                                            style="font-size:0.78rem;color:var(--text-secondary);">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p style="font-size:0.88rem;color:var(--text-secondary);line-height:1.6;">
                                        {{ $comment->comment }}</p>

                                    {{-- Hapus komentar milik sendiri --}}
                                    @auth
                                        @if ($comment->user_id === auth()->id())
                                            <form method="POST" action="{{ route('user.blog.comments.destroy', $comment) }}"
                                                style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    style="background:none;border:none;color:rgba(239,68,68,0.6);font-size:0.75rem;cursor:pointer;margin-top:0.4rem;font-family:'Inter',sans-serif;"
                                                    onclick="return confirm('Hapus komentar ini?')">
                                                    <i class="fas fa-trash" style="margin-right:3px;"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <div style="text-align:center;padding:2rem;color:var(--text-secondary);font-size:0.9rem;">
                                Belum ada komentar. Jadilah yang pertama!
                            </div>
                        @endforelse
                    </div>

                    {{-- Form Komentar --}}
                    @auth
                        <div
                            style="padding:1.5rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.1);border-radius:16px;">
                            <h4 style="font-size:1rem;font-weight:700;margin-bottom:1rem;">Tulis Komentar</h4>
                            <form method="POST" action="{{ route('user.blog.comments.store', $blog) }}">
                                @csrf
                                <div class="form-group">
                                    <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" rows="4"
                                        placeholder="Tulis komentar kamu..."></textarea>
                                    @error('comment')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn-gold" style="padding:0.7rem 1.5rem;font-size:0.9rem;">
                                    <i class="fas fa-paper-plane"></i> Kirim Komentar
                                </button>
                            </form>
                        </div>
                    @else
                        <div
                            style="text-align:center;padding:1.5rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.1);border-radius:16px;">
                            <p style="color:var(--text-secondary);margin-bottom:1rem;">Login untuk meninggalkan komentar.</p>
                            <a href="{{ route('auth.login') }}" class="btn-gold"
                                style="padding:0.7rem 1.5rem;font-size:0.9rem;">Masuk</a>
                        </div>
                    @endauth
                </article>

                {{-- Sidebar --}}
                <aside style="position:sticky;top:90px;">
                    {{-- Artikel Terkait --}}
                    @if ($relatedBlogs->count())
                        <div style="margin-bottom:2rem;">
                            <h3
                                style="font-size:1rem;font-weight:800;margin-bottom:1rem;color:var(--gold-primary);text-transform:uppercase;letter-spacing:1px;font-size:0.75rem;">
                                Artikel Terkait</h3>
                            @foreach ($relatedBlogs as $related)
                                <a href="{{ url('/blog/' . $related->slug) }}"
                                    style="display:flex;gap:0.8rem;padding:0.8rem;margin-bottom:0.5rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.08);border-radius:12px;text-decoration:none;color:inherit;transition:border-color 0.3s;"
                                    onmouseover="this.style.borderColor='rgba(244,196,48,0.3)'"
                                    onmouseout="this.style.borderColor='rgba(244,196,48,0.08)'">
                                    <div
                                        style="width:60px;height:60px;border-radius:8px;flex-shrink:0;overflow:hidden;background:rgba(244,196,48,0.08);display:flex;align-items:center;justify-content:center;">
                                        @if ($related->image)
                                            <img src="{{ asset('storage/' . $related->image) }}"
                                                style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            <span style="font-size:1.5rem;">📝</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div
                                            style="font-size:0.85rem;font-weight:600;line-height:1.4;margin-bottom:0.3rem;">
                                            {{ Str::limit($related->title, 50) }}</div>
                                        <div style="font-size:0.75rem;color:var(--text-secondary);">
                                            {{ $related->created_at->format('d M Y') }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    {{-- Artikel Terbaru --}}
                    @if ($recentBlogs->count())
                        <div>
                            <h3
                                style="font-weight:800;margin-bottom:1rem;color:var(--gold-primary);text-transform:uppercase;letter-spacing:1px;font-size:0.75rem;">
                                Artikel Terbaru</h3>
                            @foreach ($recentBlogs as $recent)
                                <a href="{{ url('/blog/' . $recent->slug) }}"
                                    style="display:block;padding:0.7rem 0;border-bottom:1px solid rgba(255,255,255,0.05);text-decoration:none;color:var(--text-secondary);font-size:0.88rem;transition:color 0.2s;"
                                    onmouseover="this.style.color='var(--gold-primary)'"
                                    onmouseout="this.style.color='var(--text-secondary)'">
                                    <i class="fas fa-angle-right"
                                        style="color:var(--gold-primary);margin-right:0.4rem;"></i>
                                    {{ Str::limit($recent->title, 45) }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </aside>

            </div>
        </div>
    </section>

@endsection
