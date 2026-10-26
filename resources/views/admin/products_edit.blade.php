@extends('layouts.admin')

@section('title', 'Edit Produk: ' . $product->title . ' — Admin BIANCA VEANA')

@section('content')
<div class="admin-container" style="max-width: 980px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
    <div>
      <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold); display: block; margin-bottom: 4px;">
        EDIT PRODUK
      </span>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 4px; font-weight: 700;">
        Edit: {{ $product->title }}
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Perbarui detail informasi, cover, harga, stok, atau bonus edisi spesial untuk produk ini.
      </p>
    </div>
    <div>
      <a href="{{ route('admin.products') }}" class="btn btn-outline-gold" style="color: #0F172A; border-color: #CBD5E1; background: #FFF; font-size: 0.82rem; padding: 10px 18px;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Produk
      </a>
    </div>
  </div>

  @if($errors->any())
    <div style="background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; padding: 14px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
      <strong>Mohon periksa kesalahan berikut:</strong>
      <ul style="margin-top: 6px; margin-left: 20px;">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="admin-card" style="padding: 36px;">
    @csrf
    @method('PUT')

    <!-- SECTION 1: INFORMASI UTAMA -->
    <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 8px; border-bottom: 1px solid var(--soft-beige); display: flex; align-items: center; gap: 10px;">
      <i class="fa-solid fa-book" style="color: var(--champagne-gold);"></i> 1. Informasi Utama Produk
    </h3>

    <div style="margin-bottom: 18px;">
      <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Judul Produk / Novel *</label>
      <input type="text" name="title" value="{{ old('title', $product->title) }}" required placeholder="Contoh: Mantra" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Kategori Produk *</label>
        <select name="category" required style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem; background: #FFF;">
          <option value="novel" {{ old('category', $product->category) === 'novel' ? 'selected' : '' }}>Novel Cetak (Physical Book)</option>
          <option value="ebook" {{ old('category', $product->category) === 'ebook' ? 'selected' : '' }}>E-Book Digital (PDF / GDrive)</option>
          <option value="merchandise" {{ old('category', $product->category) === 'merchandise' ? 'selected' : '' }}>Merchandise Resmi</option>
        </select>
      </div>

      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Subkategori / Seri</label>
        <select name="subcategory" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem; background: #FFF;">
          <option value="notonegoro" {{ old('subcategory', $product->subcategory) === 'notonegoro' ? 'selected' : '' }}>The Seven Notonegoro Series</option>
          <option value="standalone" {{ old('subcategory', $product->subcategory) === 'standalone' ? 'selected' : '' }}>Standalone Novel</option>
          <option value="limited" {{ old('subcategory', $product->subcategory) === 'limited' ? 'selected' : '' }}>Royal Limited Edition</option>
          <option value="ebook" {{ old('subcategory', $product->subcategory) === 'ebook' ? 'selected' : '' }}>E-Book Novel Lengkap</option>
          <option value="chapter" {{ old('subcategory', $product->subcategory) === 'chapter' ? 'selected' : '' }}>Serial Bab Digital</option>
          <option value="merch" {{ old('subcategory', $product->subcategory) === 'merch' ? 'selected' : '' }}>Merchandise / Aksesoris</option>
        </select>
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Nama Seri Lengkap (Label Tampilan)</label>
        <input type="text" name="series_name" value="{{ old('series_name', $product->series_name) }}" placeholder="Contoh: The Seven Notonegoro Series I" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>

      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Subtitle / Tagline Buku</label>
        <input type="text" name="subtitle" value="{{ old('subtitle', $product->subtitle) }}" placeholder="Contoh: Special Collector's Edition" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 24px;">
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Harga Jual (Rp) *</label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" placeholder="129000" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>

      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Harga Coret / Asli (Rp)</label>
        <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}" min="0" placeholder="149000" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>

      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Jumlah Stok *</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" placeholder="50" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>
    </div>

    <!-- SECTION 2: GAMBAR COVER -->
    <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 8px; border-bottom: 1px solid var(--soft-beige); display: flex; align-items: center; gap: 10px;">
      <i class="fa-solid fa-image" style="color: var(--champagne-gold);"></i> 2. Gambar Cover Produk
    </h3>

    <div style="display: flex; gap: 24px; align-items: start; margin-bottom: 24px;">
      <!-- Current Cover Preview -->
      <div style="text-align: center;">
        <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-bottom: 6px;">Cover Saat Ini:</span>
        <div style="width: 80px; height: 115px; border-radius: 4px; overflow: hidden; background: #0E1A2B; border: 1px solid var(--champagne-gold); box-shadow: var(--shadow-sm);">
          <img src="{{ asset($product->cover_image) }}" alt="{{ $product->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='/images/mantra.svg';">
        </div>
      </div>

      <div style="flex: 1;">
        <div style="margin-bottom: 14px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Ganti File Gambar Baru (Opsional)</label>
          <input type="file" name="cover_image_file" accept="image/*" style="width: 100%; padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.85rem; background: #FAF7F2;">
          <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 4px;">Biarkan kosong jika tetap menggunakan gambar saat ini.</span>
        </div>

        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Atau Perbarui Path / URL Gambar</label>
          <input type="text" name="cover_image_url" value="{{ old('cover_image_url', $product->cover_image) }}" style="width: 100%; padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.88rem;">
        </div>
      </div>
    </div>

    <!-- SECTION 3: SINOPSIS & SPESIFIKASI -->
    <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 8px; border-bottom: 1px solid var(--soft-beige); display: flex; align-items: center; gap: 10px;">
      <i class="fa-solid fa-align-left" style="color: var(--champagne-gold);"></i> 3. Sinopsis & Spesifikasi Fisik
    </h3>

    <div style="margin-bottom: 18px;">
      <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Sinopsis / Deskripsi Lengkap</label>
      <textarea name="synopsis" rows="4" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">{{ old('synopsis', $product->synopsis) }}</textarea>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 18px;">
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Genre</label>
        <input type="text" name="genre" value="{{ old('genre', $product->genre) }}" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>

      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Jumlah Halaman</label>
        <input type="number" name="pages" value="{{ old('pages', $product->pages) }}" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>

      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Berat Paket (Gram)</label>
        <input type="number" name="weight_grams" value="{{ old('weight_grams', $product->weight_grams) }}" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 24px;">
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Dimensi Ukuran</label>
        <input type="text" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>

      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Nomor ISBN</label>
        <input type="text" name="isbn" value="{{ old('isbn', $product->isbn) }}" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>

      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Penerbit</label>
        <input type="text" name="publisher" value="{{ old('publisher', $product->publisher) }}" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>
    </div>

    <!-- SECTION 4: BONUS COLLECTOR & DIGITAL E-BOOK -->
    <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 8px; border-bottom: 1px solid var(--soft-beige); display: flex; align-items: center; gap: 10px;">
      <i class="fa-solid fa-crown" style="color: var(--champagne-gold);"></i> 4. Bonus Edisi Spesial & Akses Digital
    </h3>

    @php
      $collectorsText = is_array($product->collectors_items) ? implode("\n", $product->collectors_items) : '';
    @endphp

    <div style="margin-bottom: 18px;">
      <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Item Bonus Edisi Spesial (Pisahkan per baris)</label>
      <textarea name="collectors_items_text" rows="3" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">{{ old('collectors_items_text', $collectorsText) }}</textarea>
    </div>

    <div style="background: var(--ivory); padding: 18px; border-radius: 6px; border: 1px solid var(--soft-beige); margin-bottom: 24px;">
      <h4 style="font-size: 0.95rem; color: var(--ocean-navy); margin-bottom: 12px; font-weight: 700;">
        <i class="fa-brands fa-google-drive"></i> Khusus E-Book: Tautan Akses File Digital
      </h4>
      <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px;">
        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Tipe File</label>
          <select name="digital_file_type" style="width: 100%; padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.85rem; background: #FFF;">
            <option value="pdf" {{ old('digital_file_type', $product->digital_file_type) === 'pdf' ? 'selected' : '' }}>File PDF Langsung</option>
            <option value="gdrive" {{ old('digital_file_type', $product->digital_file_type) === 'gdrive' ? 'selected' : '' }}>Tautan Google Drive</option>
          </select>
        </div>
        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">URL / Link Google Drive untuk Pembeli</label>
          <input type="text" name="digital_file_url" value="{{ old('digital_file_url', $product->digital_file_url) }}" placeholder="https://drive.google.com/file/d/..." style="width: 100%; padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.85rem;">
        </div>
      </div>
    </div>

    <!-- Checkboxes -->
    <div style="display: flex; gap: 30px; margin-bottom: 30px; padding: 14px; background: #FAF7F2; border-radius: 6px; border: 1px solid var(--soft-beige);">
      <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.88rem; font-weight: 600; color: var(--ocean-navy);">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} style="width: 18px; height: 18px;">
        <span>Tampilkan di Homepage (Featured)</span>
      </label>

      <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.88rem; font-weight: 600; color: #B45309;">
        <input type="checkbox" name="is_preorder" value="1" {{ old('is_preorder', $product->is_preorder) ? 'checked' : '' }} style="width: 18px; height: 18px;">
        <span>Status Pre-Order (PO)</span>
      </label>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; justify-content: flex-end; gap: 16px; padding-top: 20px; border-top: 1px solid var(--soft-beige);">
      <a href="{{ route('admin.products') }}" class="btn btn-outline-gold" style="color: var(--ocean-navy); border-color: var(--soft-beige);">
        Batal
      </a>
      <button type="submit" class="btn btn-gold" style="padding: 14px 32px;">
        <i class="fa-solid fa-floppy-disk"></i> SIMPAN PERUBAHAN PRODUK
      </button>
    </div>
  </form>
</div>
@endsection
