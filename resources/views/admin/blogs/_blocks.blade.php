{{-- Editor blok konten: teks & gambar berurutan. Dipakai di create & edit. --}}
@php
    $existingBlocks = isset($blog) ? $blog->blocks->keyBy('id') : collect();

    $source = old('blocks');
    if ($source === null) {
        $source =
            isset($blog) && $blog->blocks->count()
                ? $blog->blocks
                    ->map(
                        fn($b) => [
                            'id' => $b->id,
                            'type' => $b->type,
                            'content' => $b->content,
                            'caption' => $b->caption,
                        ],
                    )
                    ->all()
                : [['type' => 'text', 'content' => '']];
    }

    $initialBlocks = collect($source)
        ->values()
        ->map(function ($b) use ($existingBlocks) {
            $id = $b['id'] ?? null;
            $img = $id ? $existingBlocks[$id]->image ?? null : null;

            return [
                'id' => $id,
                'type' => $b['type'] ?? 'text',
                'content' => $b['content'] ?? '',
                'caption' => $b['caption'] ?? '',
                'image_url' => $img ? asset('storage/' . $img) : null,
            ];
        })
        ->values();
@endphp

<div class="card" style="margin-top:1.5rem;">
    <div class="card-header"><i class="fas fa-layer-group"></i> Isi Blog (Teks &amp; Gambar)</div>

    <div style="font-size:0.8rem;color:var(--text-muted);margin-bottom:1rem;">
        Susun isi blog berurutan, misalnya: teks &rarr; gambar &rarr; teks &rarr; gambar. Gunakan tombol panah untuk
        mengubah urutan.
    </div>

    @error('blocks')
        <div class="invalid-feedback" style="display:block;margin-bottom:0.8rem;">{{ $message }}</div>
    @enderror
    @foreach (collect($errors->get('blocks.*'))->flatten()->unique() as $msg)
        <div class="invalid-feedback" style="display:block;margin-bottom:0.4rem;">{{ $msg }}</div>
    @endforeach

    <div id="blocksWrap" style="display:flex;flex-direction:column;gap:1rem;"></div>

    <div style="display:flex;gap:0.6rem;margin-top:1rem;flex-wrap:wrap;">
        <button type="button" class="btn-secondary" id="addTextBlock"><i class="fas fa-font"></i> Tambah Teks</button>
        <button type="button" class="btn-secondary" id="addImageBlock"><i class="fas fa-image"></i> Tambah
            Gambar</button>
    </div>
</div>

@push('scripts')
    <script>
        (function() {
            const initial = @json($initialBlocks);
            const wrap = document.getElementById('blocksWrap');

            function makeEl(html) {
                const t = document.createElement('template');
                t.innerHTML = html.trim();
                return t.content.firstChild;
            }

            function reindex() {
                wrap.querySelectorAll('.blk').forEach((d, i) => {
                    d.querySelector('.f-id').name = `blocks[${i}][id]`;
                    d.querySelector('.f-type').name = `blocks[${i}][type]`;
                    const c = d.querySelector('.f-content');
                    if (c) c.name = `blocks[${i}][content]`;
                    const f = d.querySelector('.f-image');
                    if (f) f.name = `blocks[${i}][image]`;
                    const p = d.querySelector('.f-caption');
                    if (p) p.name = `blocks[${i}][caption]`;
                    d.querySelector('.blk-label').textContent =
                        (i + 1) + '. ' + (d.dataset.type === 'text' ? 'Teks' : 'Gambar');
                });
            }

            function addBlock(b) {
                const isText = b.type === 'text';

                const body = isText ?
                    `<textarea class="form-control f-content" rows="6" placeholder="Tulis teks di sini..."></textarea>` :
                    `<input type="file" class="form-control f-image" accept="image/*">
               <img class="blk-preview" alt="" style="display:none;width:100%;max-height:320px;object-fit:contain;border-radius:10px;margin-top:0.8rem;border:1px solid rgba(244,196,48,0.15);">
               <input type="text" class="form-control f-caption" maxlength="255" placeholder="Keterangan gambar (opsional)" style="margin-top:0.8rem;">`;

                const div = makeEl(`
            <div class="blk" data-type="${b.type}" style="border:1px solid rgba(244,196,48,0.15);border-radius:12px;padding:1rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.7rem;">
                    <span class="blk-label" style="font-size:0.82rem;font-weight:600;color:var(--gold-pure);"></span>
                    <div style="display:flex;gap:0.4rem;">
                        <button type="button" class="btn-secondary blk-up" title="Naik" style="padding:0.3rem 0.7rem;"><i class="fas fa-arrow-up"></i></button>
                        <button type="button" class="btn-secondary blk-down" title="Turun" style="padding:0.3rem 0.7rem;"><i class="fas fa-arrow-down"></i></button>
                        <button type="button" class="btn-danger blk-del" title="Hapus blok" style="padding:0.3rem 0.7rem;"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <input type="hidden" class="f-id">
                <input type="hidden" class="f-type">
                ${body}
            </div>`);

                div.querySelector('.f-id').value = b.id ?? '';
                div.querySelector('.f-type').value = b.type;

                if (isText) {
                    div.querySelector('.f-content').value = b.content || '';
                } else {
                    const preview = div.querySelector('.blk-preview');
                    const file = div.querySelector('.f-image');
                    div.querySelector('.f-caption').value = b.caption || '';

                    if (b.image_url) {
                        preview.src = b.image_url;
                        preview.style.display = 'block';
                    }
                    file.addEventListener('change', () => {
                        if (file.files && file.files[0]) {
                            const r = new FileReader();
                            r.onload = e => {
                                preview.src = e.target.result;
                                preview.style.display = 'block';
                            };
                            r.readAsDataURL(file.files[0]);
                        }
                    });
                }

                div.querySelector('.blk-up').addEventListener('click', () => {
                    if (div.previousElementSibling) {
                        wrap.insertBefore(div, div.previousElementSibling);
                        reindex();
                    }
                });
                div.querySelector('.blk-down').addEventListener('click', () => {
                    if (div.nextElementSibling) {
                        wrap.insertBefore(div.nextElementSibling, div);
                        reindex();
                    }
                });
                div.querySelector('.blk-del').addEventListener('click', () => {
                    if (confirm('Hapus blok ini?')) {
                        div.remove();
                        reindex();
                    }
                });

                wrap.appendChild(div);
                reindex();
            }

            document.getElementById('addTextBlock').addEventListener('click', () => addBlock({
                type: 'text'
            }));
            document.getElementById('addImageBlock').addEventListener('click', () => addBlock({
                type: 'image'
            }));

            initial.forEach(addBlock);
        })();
    </script>
@endpush
