@extends('layouts.admin')

@section('title', 'Kelola Part E-Book — ' . $product->title)

@section('content')
<div class="admin-container" style="max-width: 1080px;">
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
    <div>
      <a href="{{ route('admin.products') }}" style="font-size: 0.82rem; color: var(--admin-gold); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Stok & Produk
      </a>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 6px; font-weight: 700;">
        Kelola Part E-Book: <span style="color: var(--champagne-gold);">{{ $product->title }}</span>
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Tambahkan part/bab e-book berbayar untuk judul ini agar pembeli dapat membeli secara bertahap (Part 1, Part 2, dst.) atau novel lengkap.
      </p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
      <span style="background: #EFF6FF; color: #1D4ED8; border: 1px solid #BFDBFE; padding: 6px 14px; border-radius: 6px; font-size: 0.82rem; font-weight: 700;">
        <i class="fa-solid fa-layer-group"></i> Total {{ $parts->count() }} Part Aktif
      </span>
    </div>
  </div>

  @if(session('success'))
    <div style="background: #DCFCE7; border: 1px solid #86EFAC; color: #15803D; padding: 14px 18px; border-radius: 6px; margin-bottom: 24px; font-size: 0.88rem;">
      <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
  @endif

  @if(isset($errors) && $errors->any())
    <div style="background: #FEE2E2; border: 1px solid #F87171; color: #B91C1C; padding: 14px 18px; border-radius: 6px; margin-bottom: 24px; font-size: 0.88rem;">
      <strong><i class="fa-solid fa-triangle-exclamation"></i> Gagal menyimpan part:</strong>
      <ul style="margin-left: 20px; margin-top: 6px;">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div style="display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 32px; align-items: start;">
    <!-- LEFT: List of Existing Parts -->
    <div>
      <div class="admin-card" style="padding: 24px;">
        <h3 style="font-family: var(--font-display); font-size: 1.25rem; color: #0F172A; margin: 0 0 18px; display: flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-list-ol" style="color: var(--champagne-gold);"></i> Daftar Part E-Book Saat Ini
        </h3>

        @if($parts->count() > 0)
          <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($parts as $part)
              <div style="background: #FAF8F5; border: 1px solid var(--soft-beige); border-radius: 8px; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                  <div style="width: 38px; height: 38px; border-radius: 50%; background: {{ $part->part_number ? '#EFF6FF' : '#FEF3C7' }}; color: {{ $part->part_number ? '#1D4ED8' : '#B45309' }}; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.88rem; flex-shrink: 0;">
                    {{ $part->part_number ? 'P' . $part->part_number : 'FULL' }}
                  </div>
                  <div>
                    <strong style="color: var(--ocean-navy); font-size: 0.95rem; display: block;">
                      {{ $part->title }}
                    </strong>
                    @if($part->synopsis)
                      <div style="font-size: 0.78rem; color: #475569; margin: 4px 0 6px; line-height: 1.4; background: #F8FAFC; border-left: 3px solid var(--champagne-gold); padding: 4px 8px; border-radius: 0 4px 4px 0;">
                        <span style="font-weight: 600; color: #0284C7; font-size: 0.7rem; text-transform: uppercase;"><i class="fa-solid fa-feather-pointed"></i> Sinopsis:</span> {{ $part->synopsis }}
                      </div>
                    @endif
                    <span style="font-size: 0.78rem; color: #64748B;">
                      {{ $part->part_number ? "Nomor Part: {$part->part_number}" : 'Edisi Lengkap Full Novel' }}
                      • Akses: 
                      @if($part->digital_file_url)
                        <a href="{{ $part->digital_file_url }}" target="_blank" style="color: var(--champagne-gold); text-decoration: underline;">
                          {{ str_starts_with($part->digital_file_url, 'http') ? 'Tautan Google Drive' : 'File PDF Tersimpan' }}
                        </a>
                      @else
                        <span style="color: #EF4444;">Belum ada file</span>
                      @endif
                    </span>
                  </div>
                </div>

                <div style="display: flex; align-items: center; gap: 8px;">
                  <span style="font-size: 1.05rem; font-weight: 700; color: #15803D;">
                    {{ $part->formatted_price }}
                  </span>
                  <a href="{{ route('reader.show', $part->slug) }}" target="_blank" style="background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; padding: 6px 10px; border-radius: 4px; font-size: 0.75rem; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;" title="Preview Web Novel Reader">
                    <i class="fa-solid fa-book-open"></i> Baca
                  </a>
                  <a href="{{ route('admin.products.edit', $part->id) }}" style="background: #EEF2FF; color: #4338CA; border: 1px solid #C7D2FE; padding: 6px 10px; border-radius: 4px; font-size: 0.75rem; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;" title="Edit Sinopsis & Harga Part">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                  </a>
                  <form action="{{ route('admin.products.parts.destroy', $part->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus part {{ $part->title }} ini?');" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #FEE2E2; color: #DC2626; border: none; padding: 8px 12px; border-radius: 4px; font-size: 0.78rem; cursor: pointer; font-weight: 600;" title="Hapus Part">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div style="text-align: center; padding: 40px 20px; color: #64748B;">
            <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; color: var(--soft-beige); margin-bottom: 12px;"></i>
            <p>Belum ada part e-book untuk judul ini. Silakan tambahkan part pertama melalui formulir di samping.</p>
          </div>
        @endif
      </div>
    </div>

    <!-- RIGHT: Form Add New Part -->
    <div>
      <div class="admin-card" style="padding: 24px; position: sticky; top: 90px;">
        <h3 style="font-family: var(--font-display); font-size: 1.25rem; color: #0F172A; margin: 0 0 16px; display: flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-cloud-arrow-up" style="color: var(--champagne-gold);"></i> Tambah Part Baru
        </h3>

        <form action="{{ route('admin.products.parts.store', $product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div style="margin-bottom: 14px;">
            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">
              Judul Part *
            </label>
            <input type="text" name="title" required placeholder="Contoh: {{ $product->title }} — Part 4 (Bab 16 s/d 20)" style="width: 100%; padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.88rem;">
          </div>

          <div style="margin-bottom: 14px;">
            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">
              Sinopsis Part / Ringkasan Bab
            </label>
            <textarea name="synopsis" rows="3" placeholder="Tuliskan sinopsis singkat cerita pada part bab ini agar terbaca oleh customer..." style="width: 100%; padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.88rem; box-sizing: border-box; font-family: inherit; resize: vertical; line-height: 1.5;"></textarea>
            <span style="font-size: 0.72rem; color: #64748B;">*Sinopsis ini akan langsung ditampilkan kepada pembeli di halaman e-book customer.</span>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
            <div>
              <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">
                Nomor Part (Angka)
              </label>
              <input type="number" name="part_number" placeholder="4" style="width: 100%; padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.88rem;">
              <span style="font-size: 0.7rem; color: #64748B;">Kosongkan jika edisi Full.</span>
            </div>
            <div>
              <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">
                Harga Part (Rp) *
              </label>
              <input type="number" name="price" required placeholder="15000" style="width: 100%; padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.88rem;">
            </div>
          </div>

          <div style="margin-bottom: 14px;">
            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">
              Upload File PDF / E-Book Part
            </label>
            <input type="file" name="ebook_file" accept=".pdf,.epub,.zip" style="width: 100%; padding: 8px; border: 1px dashed var(--soft-beige); border-radius: 4px; font-size: 0.82rem; background: #FAF8F5;">
          </div>

          <div style="margin-bottom: 18px;">
            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">
              Atau Tautan Akses Google Drive
            </label>
            <input type="url" name="digital_file_url" placeholder="https://drive.google.com/file/d/..." style="width: 100%; padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.88rem;">
          </div>

          <div style="margin-bottom: 20px;">
            <label style="display: flex; justify-content: space-between; align-items: center; font-size: 0.82rem; font-weight: 700; color: #1E293B; margin-bottom: 4px;">
              <span><i class="fa-solid fa-book-open-reader" style="color: var(--champagne-gold);"></i> Isi Naskah Bab (Web Reader)</span>
              <span style="font-size: 0.72rem; color: #2563EB; font-weight: normal;">Bisa Dibaca Langsung di Web</span>
            </label>
            <textarea name="content" rows="6" placeholder="Ketik atau tempel teks cerita bab ini di sini. Pembeli yang sudah bayar akan dapat membacanya langsung di web..." style="width: 100%; padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.88rem; box-sizing: border-box; font-family: inherit; resize: vertical; line-height: 1.6;"></textarea>
            <span style="font-size: 0.72rem; color: #64748B;">*Mendukung pemisahan paragraf & dialog otomatis untuk pengalaman membaca yang nyaman.</span>
          </div>

          <button type="submit" class="btn btn-gold" style="width: 100%; padding: 12px; font-size: 0.88rem; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="fa-solid fa-plus"></i> Simpan & Publikasikan Part
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

