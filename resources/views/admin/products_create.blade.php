@extends('layouts.admin')

@section('title', 'Tambah Produk Baru — Admin BIANCA VEANA')

@section('content')
<div class="admin-container" style="max-width: 960px;">

  <!-- Header Breadcrumb & Actions -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div>
      <a href="{{ route('admin.products') }}" style="color: #64748B; text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Produk
      </a>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0; font-weight: 700;">
        Tambah Produk Baru
      </h2>
    </div>

    <!-- Category Type Badge -->
    <div id="badge-category-indicator" style="padding: 8px 16px; border-radius: 20px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
      <!-- Populated by JS -->
    </div>
  </div>

  @if(isset($errors) && $errors->any())
    <div style="background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; padding: 14px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
      <strong>Mohon periksa kesalahan berikut:</strong>
      <ul style="margin-top: 6px; margin-left: 20px;">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- SECTION 1: INFORMASI UTAMA -->
    <div class="admin-card" style="margin-bottom: 24px;">
      <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 8px; border-bottom: 1px solid var(--soft-beige); display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-sliders" style="color: var(--champagne-gold);"></i> 1. Informasi Utama Produk
      </h3>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Pilih Kategori Produk *</label>
          <select name="category" id="product_category" required onchange="updateCategoryForm()" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem; background: #FFF; font-weight: 600;">
            <option value="novel" {{ old('category') === 'novel' ? 'selected' : '' }}>📖 Novel Cetak (Physical Book)</option>
            <option value="ebook" {{ old('category') === 'ebook' ? 'selected' : '' }}>📱 E-Book Digital (PDF / GDrive)</option>
            <option value="merchandise" {{ old('category') === 'merchandise' ? 'selected' : '' }}>👑 Merchandise Resmi</option>
          </select>
        </div>

        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Subkategori / Koleksi</label>
          <select name="subcategory" id="product_subcategory" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem; background: #FFF;">
            <option value="notonegoro" {{ old('subcategory') === 'notonegoro' ? 'selected' : '' }}>The Seven Notonegoro Series</option>
            <option value="standalone" {{ old('subcategory') === 'standalone' ? 'selected' : '' }}>Standalone Novel</option>
            <option value="limited" {{ old('subcategory') === 'limited' ? 'selected' : '' }}>Royal Limited Edition</option>
            <option value="ebook" {{ old('subcategory') === 'ebook' ? 'selected' : '' }}>E-Book Novel Lengkap</option>
            <option value="chapter" {{ old('subcategory') === 'chapter' ? 'selected' : '' }}>Serial Bab Digital</option>
            <option value="merch" {{ old('subcategory') === 'merch' ? 'selected' : '' }}>Aksesoris & Merchandise Koleksi</option>
          </select>
        </div>
      </div>

      <div style="margin-bottom: 18px;">
        <label id="lbl-title" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
          Judul Produk *
        </label>
        <input type="text" name="title" id="input_title" value="{{ old('title') }}" required placeholder="Contoh: Pembatas Buku Logam Kuningan Notonegoro" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
        <div>
          <label id="lbl-series" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Seri Terkait / Tema Koleksi</label>
          <input type="text" name="series_name" value="{{ old('series_name') }}" placeholder="Contoh: The Seven Notonegoro Official Merchandise" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
        </div>

        <div>
          <label id="lbl-subtitle" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Subtitle / Varian Edisi</label>
          <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="Contoh: Royal Swan 18K Gold Plated Edition" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px;">
        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Harga Jual (Rp) *</label>
          <input type="number" name="price" value="{{ old('price') }}" required min="0" placeholder="129000" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
        </div>

        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Harga Coret / Asli (Rp)</label>
          <input type="number" name="original_price" value="{{ old('original_price') }}" min="0" placeholder="149000" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
        </div>

        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Jumlah Stok Awal *</label>
          <input type="number" name="stock" value="{{ old('stock', 50) }}" required min="0" placeholder="50" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
        </div>
      </div>
    </div>

    <!-- SECTION 2: FOTO & GALERI PRODUK (MULTI-ANGLE) -->
    <div class="admin-card" style="margin-bottom: 24px;">
      <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--ocean-navy); margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid var(--soft-beige); display: flex; align-items: center; justify-content: space-between;">
        <span id="title-section-2" style="display: flex; align-items: center; gap: 10px;">
          <i class="fa-solid fa-images" style="color: var(--champagne-gold);"></i> 2. Foto & Galeri Produk
        </span>
        <span style="font-size: 0.75rem; color: var(--champagne-gold); font-family: var(--font-sans); font-weight: 600;">Multi-Angle Photo Showcase</span>
      </h3>

      <p id="desc-section-2" style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 18px; line-height: 1.6;">
        <!-- Populated by JS -->
      </p>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px;">
        <!-- Foto 1: Foto Utama -->
        <div style="background: #FAFAF7; border: 1px solid var(--soft-beige); border-radius: 6px; padding: 16px;">
          <div id="lbl-slot-1" style="font-size: 0.84rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
            <span style="background: var(--champagne-gold); color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">1</span>
            Foto Utama (Tampak Depan) *
          </div>
          <input type="file" name="cover_image_file" accept="image/*" style="width: 100%; font-size: 0.8rem; margin-bottom: 8px;">
          <input type="text" name="cover_image_url" value="{{ old('cover_image_url') }}" placeholder="Atau URL: /images/photo.jpg" style="width: 100%; padding: 6px 10px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.78rem;">
        </div>

        <!-- Foto 2: Sudut Samping / Detail Bahan -->
        <div id="box-slot-2" style="background: #FAFAF7; border: 1px solid var(--soft-beige); border-radius: 6px; padding: 16px;">
          <div id="lbl-slot-2" style="font-size: 0.84rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
            <span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">2</span>
            Foto Sudut Samping / Detail Bahan
          </div>
          <input type="file" name="gallery_image_2" accept="image/*" style="width: 100%; font-size: 0.8rem; margin-bottom: 8px;">
          <input type="text" name="gallery_url_2" value="{{ old('gallery_url_2') }}" placeholder="Atau URL foto kedua" style="width: 100%; padding: 6px 10px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.78rem;">
        </div>

        <!-- Foto 3: Kemasan Box / Packaging / Detail Tambahan -->
        <div id="box-slot-3" style="background: #FAFAF7; border: 1px solid var(--soft-beige); border-radius: 6px; padding: 16px;">
          <div id="lbl-slot-3" style="font-size: 0.84rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
            <span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">3</span>
            Foto Kemasan / Box / Detail Unboxing
          </div>
          <input type="file" name="gallery_image_3" accept="image/*" style="width: 100%; font-size: 0.8rem; margin-bottom: 8px;">
          <input type="text" name="gallery_url_3" value="{{ old('gallery_url_3') }}" placeholder="Atau URL foto ketiga" style="width: 100%; padding: 6px 10px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.78rem;">
        </div>
      </div>
    </div>

    <!-- SECTION 3: SPESIFIKASI & DESKRIPSI -->
    <div class="admin-card" style="margin-bottom: 24px;">
      <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 8px; border-bottom: 1px solid var(--soft-beige); display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-clipboard-list" style="color: var(--champagne-gold);"></i> 
        <span id="title-section-3">3. Deskripsi & Spesifikasi Produk</span>
      </h3>

      <div style="margin-bottom: 18px;">
        <label id="lbl-synopsis" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
          Deskripsi Lengkap Produk
        </label>
        <textarea name="synopsis" rows="4" placeholder="Tuliskan deskripsi lengkap produk di sini..." style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem; line-height: 1.6;">{{ old('synopsis') }}</textarea>
      </div>

      <!-- MERCHANDISE SPECIFICATIONS -->
      <div id="section-specs-merch">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
              <i class="fa-solid fa-cube" style="color: var(--champagne-gold);"></i> Material / Bahan Pembuatan
            </label>
            <input type="text" name="publisher" id="input_merch_material" value="{{ old('publisher') }}" placeholder="Contoh: Logam Kuningan Gold Plated 18K / Katun Organik / Lilin Kedelai" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
              <i class="fa-solid fa-palette" style="color: var(--champagne-gold);"></i> Varian / Warna / Tipe
            </label>
            <input type="text" name="genre" id="input_merch_variant" value="{{ old('genre') }}" placeholder="Contoh: Champagne Gold / Midnight Navy Edition" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 18px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
              <i class="fa-solid fa-ruler-combined" style="color: var(--champagne-gold);"></i> Dimensi Ukuran Barang
            </label>
            <input type="text" name="dimensions" value="{{ old('dimensions') }}" placeholder="Contoh: 14 cm x 4.5 cm / All Size" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
              <i class="fa-solid fa-weight-scale" style="color: var(--champagne-gold);"></i> Berat Paket Pengiriman (Gram) *
            </label>
            <input type="number" name="weight_grams" value="{{ old('weight_grams', 150) }}" placeholder="150" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
            <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 4px;">Penting untuk kalkulasi otomatis ongkir ekspedisi.</span>
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
              <i class="fa-solid fa-barcode" style="color: var(--champagne-gold);"></i> Kode Produk / SKU
            </label>
            <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="Contoh: BV-MRCH-001" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>
        </div>
      </div>

      <!-- NOVEL / BOOK SPECIFICATIONS (Shown only for Novel & E-Book) -->
      <div id="section-specs-book">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 18px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Genre Buku</label>
            <input type="text" name="book_genre" id="input_book_genre" value="{{ old('genre', 'Royal Romance, Drama') }}" placeholder="Royal Romance, Drama" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Jumlah Halaman</label>
            <input type="number" name="pages" value="{{ old('pages') }}" placeholder="456" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div id="box-book-weight">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Berat Paket (Gram)</label>
            <input type="number" name="book_weight_grams" id="input_book_weight" value="{{ old('weight_grams', 350) }}" placeholder="350" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 18px;">
          <div id="box-book-dimensions">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Dimensi Ukuran Buku</label>
            <input type="text" name="book_dimensions" id="input_book_dimensions" value="{{ old('dimensions') }}" placeholder="14 x 20.5 cm" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Nomor ISBN</label>
            <input type="text" name="book_isbn" id="input_book_isbn" value="{{ old('isbn') }}" placeholder="978-623-XXXX-XX-X" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Penerbit</label>
            <input type="text" name="book_publisher" id="input_book_publisher" value="{{ old('publisher', 'Bianca Veana Publishing') }}" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>
        </div>
      </div>
    </div>

    <!-- SECTION 4: KELENGKAPAN / BONUS / DIGITAL ACCESS -->
    <div class="admin-card" style="margin-bottom: 24px;">
      <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 8px; border-bottom: 1px solid var(--soft-beige); display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-crown" style="color: var(--champagne-gold);"></i> 
        <span id="title-section-4">4. Kelengkapan Kemasan & Akses</span>
      </h3>

      <!-- Collectors Items / Kelengkapan Box -->
      <div id="box-collectors-items" style="margin-bottom: 18px;">
        <label id="lbl-collectors-items" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
          Kelengkapan Paket / Bonus (Pisahkan per baris)
        </label>
        <textarea name="collectors_items_text" id="input_collectors_text" rows="3" placeholder="Special Dust Jacket with Gold Foil&#10;Exclusive Photocard Couple&#10;Gold Foil Bookmark" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">{{ old('collectors_items_text') }}</textarea>
      </div>

      <!-- KHUSUS E-BOOK DIGITAL -->
      <div id="box-ebook-digital" style="background: var(--ivory); padding: 18px; border-radius: 6px; border: 1px solid var(--soft-beige); margin-bottom: 10px; display: none;">
        <h4 style="font-size: 0.95rem; color: var(--ocean-navy); margin-bottom: 12px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
          <i class="fa-brands fa-google-drive" style="color: #2563EB;"></i> Khusus E-Book: Tautan Akses Google Drive untuk Pembeli
        </h4>
        <input type="hidden" name="digital_file_type" value="gdrive">
        <div style="margin-bottom: 16px;">
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
            URL / Tautan Google Drive Resmi (Pembeli Otomatis Menerima Link Ini)
          </label>
          <div style="position: relative;">
            <i class="fa-brands fa-google-drive" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #2563EB; font-size: 1rem;"></i>
            <input type="url" name="digital_file_url" value="{{ old('digital_file_url') }}" placeholder="https://drive.google.com/file/d/... atau https://drive.google.com/drive/folders/..." style="width: 100%; padding: 11px 16px 11px 40px; border: 1px solid var(--soft-beige); border-radius: 6px; font-size: 0.88rem; box-sizing: border-box; background: #FFFFFF;">
          </div>
          <span style="font-size: 0.74rem; color: var(--text-muted); margin-top: 5px; display: block;">
            *Pastikan izin akses tautan Google Drive disetel ke <em>"Siapa saja yang memiliki link dapat melihat"</em>.
          </span>
        </div>

        <!-- Isi Naskah Bab (Web Novel Reader) -->
        <div style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--soft-beige);">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px;">
            <i class="fa-solid fa-book-open-reader" style="color: var(--champagne-gold);"></i> Isi Naskah Cerita Bab (Web Novel Reader)
          </label>
          <textarea name="content" rows="8" placeholder="Tempel atau ketik teks naskah cerita bab ini di sini untuk dibaca langsung di browser web oleh pembeli..." style="width: 100%; padding: 12px 14px; border: 1px solid var(--soft-beige); border-radius: 6px; font-size: 0.9rem; line-height: 1.6; font-family: inherit;">{{ old('content') }}</textarea>
        </div>
      </div>
    </div>

    <!-- Checkboxes -->
    <div style="display: flex; gap: 30px; margin-bottom: 30px; padding: 16px 20px; background: #FAF7F2; border-radius: 6px; border: 1px solid var(--soft-beige); flex-wrap: wrap;">
      <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.88rem; font-weight: 600; color: var(--ocean-navy);">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--admin-gold);">
        <span>Tampilkan di Halaman Utama (Featured)</span>
      </label>

      <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.88rem; font-weight: 600; color: #B45309;">
        <input type="checkbox" name="is_preorder" value="1" {{ old('is_preorder') ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #B45309;">
        <span>Status Pre-Order (PO)</span>
      </label>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; justify-content: flex-end; gap: 16px; padding-top: 20px; border-top: 1px solid var(--soft-beige);">
      <a href="{{ route('admin.products') }}" class="btn btn-outline-gold" style="color: var(--ocean-navy); border-color: var(--soft-beige); padding: 12px 24px;">
        Batal
      </a>
      <button type="submit" class="btn btn-gold" style="padding: 14px 34px; font-weight: 700;">
        <i class="fa-solid fa-plus-circle"></i> SIMPAN PRODUK KE KATALOG
      </button>
    </div>
  </form>
</div>

<script>
  function updateCategoryForm() {
    const cat = document.getElementById('product_category').value;
    const badge = document.getElementById('badge-category-indicator');
    
    const secMerch = document.getElementById('section-specs-merch');
    const secBook = document.getElementById('section-specs-book');
    const boxEbook = document.getElementById('box-ebook-digital');
    const boxCollectors = document.getElementById('box-collectors-items');
    const boxSlot2 = document.getElementById('box-slot-2');
    const boxSlot3 = document.getElementById('box-slot-3');

    if (cat === 'merchandise') {
      badge.innerHTML = '<i class="fa-solid fa-crown"></i> Mode Merchandise Resmi';
      badge.style.background = '#FEF3C7';
      badge.style.color = '#92400E';
      badge.style.border = '1px solid #FDE68A';

      document.getElementById('lbl-title').innerText = 'Nama Produk Merchandise *';
      document.getElementById('input_title').placeholder = 'Contoh: Pembatas Buku Logam Kuningan Notonegoro';
      document.getElementById('lbl-series').innerText = 'Seri / Tema Novel Terkait';
      document.getElementById('lbl-subtitle').innerText = 'Varian / Warna / Edisi';

      document.getElementById('title-section-2').innerHTML = '<i class="fa-solid fa-gift" style="color: var(--champagne-gold);"></i> 2. Foto & Galeri Produk Merchandise';
      document.getElementById('desc-section-2').innerHTML = 'Unggah hingga <strong>3 foto merchandise</strong> (foto produk tampak depan, detail material / bahan saat digunakan, dan foto kemasan / packaging eksklusif).';
      document.getElementById('lbl-slot-1').innerHTML = '<span style="background: var(--champagne-gold); color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">1</span> Foto Utama Produk (Tampak Depan) *';
      document.getElementById('lbl-slot-2').innerHTML = '<span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">2</span> Foto Sudut Samping / Detail Bahan';
      document.getElementById('lbl-slot-3').innerHTML = '<span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">3</span> Foto Kemasan Box / Packaging Eksklusif';
      boxSlot2.style.display = 'block';
      boxSlot3.style.display = 'block';

      document.getElementById('title-section-3').innerText = '3. Deskripsi & Spesifikasi Merchandise';
      document.getElementById('lbl-synopsis').innerText = 'Deskripsi Lengkap Produk Merchandise';
      secMerch.style.display = 'block';
      secBook.style.display = 'none';

      document.getElementById('title-section-4').innerText = '4. Kelengkapan Kemasan & Isi Box';
      boxCollectors.style.display = 'block';
      document.getElementById('lbl-collectors-items').innerText = 'Item Kelengkapan dalam Paket (Pisahkan per baris)';
      document.getElementById('input_collectors_text').placeholder = 'Contoh:\nHardbox Beludru Eksklusif\nPouch Kain Satin Bianca Veana\nKartu Sertifikat Keaslian Notonegoro';
      boxEbook.style.display = 'none';

    } else if (cat === 'ebook') {
      badge.innerHTML = '<i class="fa-solid fa-tablet-screen-button"></i> Mode E-Book Digital';
      badge.style.background = '#EFF6FF';
      badge.style.color = '#1E40AF';
      badge.style.border = '1px solid #BFDBFE';

      document.getElementById('lbl-title').innerText = 'Judul E-Book / Bab Digital *';
      document.getElementById('input_title').placeholder = 'Contoh: E-Book Novel Mantra (Full Chapter)';
      document.getElementById('lbl-series').innerText = 'Nama Seri Novel';
      document.getElementById('lbl-subtitle').innerText = 'Subtitle / Keterangan Edisi Digital';

      document.getElementById('title-section-2').innerHTML = '<i class="fa-solid fa-tablet-screen-button" style="color: var(--champagne-gold);"></i> 2. Cover E-Book Digital';
      document.getElementById('desc-section-2').innerHTML = 'Unggah gambar digital cover art beresolusi tinggi.';
      document.getElementById('lbl-slot-1').innerHTML = '<span style="background: var(--champagne-gold); color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">1</span> Cover Digital E-Book (Utama) *';
      boxSlot2.style.display = 'none';
      boxSlot3.style.display = 'none';

      document.getElementById('title-section-3').innerText = '3. Sinopsis & Spesifikasi E-Book';
      document.getElementById('lbl-synopsis').innerText = 'Sinopsis / Ringkasan Cerita';
      secMerch.style.display = 'none';
      secBook.style.display = 'block';
      document.getElementById('box-book-weight').style.display = 'none';
      document.getElementById('box-book-dimensions').style.display = 'none';

      document.getElementById('title-section-4').innerText = '4. Tautan Akses File Digital Pembeli';
      boxCollectors.style.display = 'none';
      boxEbook.style.display = 'block';

    } else {
      // NOVEL FISIK
      badge.innerHTML = '<i class="fa-solid fa-book-open"></i> Mode Novel Cetak Fisik';
      badge.style.background = '#ECFDF5';
      badge.style.color = '#065F46';
      badge.style.border = '1px solid #A7F3D0';

      document.getElementById('lbl-title').innerText = 'Judul Novel Cetak *';
      document.getElementById('input_title').placeholder = 'Contoh: Mantra';
      document.getElementById('lbl-series').innerText = 'Nama Seri Lengkap (Label Tampilan)';
      document.getElementById('lbl-subtitle').innerText = 'Subtitle / Tagline Buku';

      document.getElementById('title-section-2').innerHTML = '<i class="fa-solid fa-book-open" style="color: var(--champagne-gold);"></i> 2. Foto & Galeri Buku Fisik';
      document.getElementById('desc-section-2').innerHTML = 'Untuk pembelian buku fisik, Anda dapat mengunggah hingga <strong>3 foto</strong> (cover depan, cover belakang / punggung buku, dan detail isi buku / bonus).';
      document.getElementById('lbl-slot-1').innerHTML = '<span style="background: var(--champagne-gold); color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">1</span> Foto Cover Depan (Utama) *';
      document.getElementById('lbl-slot-2').innerHTML = '<span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">2</span> Foto Cover Belakang / Sisi Punggung Buku';
      document.getElementById('lbl-slot-3').innerHTML = '<span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">3</span> Foto Detail Isi / Bonus Fisik';
      boxSlot2.style.display = 'block';
      boxSlot3.style.display = 'block';

      document.getElementById('title-section-3').innerText = '3. Sinopsis & Spesifikasi Buku Fisik';
      document.getElementById('lbl-synopsis').innerText = 'Sinopsis Novel';
      secMerch.style.display = 'none';
      secBook.style.display = 'block';
      document.getElementById('box-book-weight').style.display = 'block';
      document.getElementById('box-book-dimensions').style.display = 'block';

      document.getElementById('title-section-4').innerText = '4. Bonus Edisi Spesial (Collector\'s Keepsake)';
      boxCollectors.style.display = 'block';
      document.getElementById('lbl-collectors-items').innerText = 'Item Bonus Edisi Spesial (Pisahkan per baris)';
      document.getElementById('input_collectors_text').placeholder = 'Special Dust Jacket with Gold Foil\nExclusive Photocard Couple\nGold Foil Bookmark';
      boxEbook.style.display = 'none';
    }
  }

  // Synchronize inputs before submit
  document.querySelector('form').addEventListener('submit', function() {
    const cat = document.getElementById('product_category').value;
    if (cat === 'novel' || cat === 'ebook') {
      const bookGenre = document.getElementById('input_book_genre');
      const bookWeight = document.getElementById('input_book_weight');
      const bookDimensions = document.getElementById('input_book_dimensions');
      const bookIsbn = document.getElementById('input_book_isbn');
      const bookPublisher = document.getElementById('input_book_publisher');

      if (bookGenre) document.getElementById('input_merch_variant').value = bookGenre.value;
      if (bookPublisher) document.getElementById('input_merch_material').value = bookPublisher.value;
      if (bookWeight && cat === 'novel') document.querySelector('input[name="weight_grams"]').value = bookWeight.value;
      if (bookDimensions && cat === 'novel') document.querySelector('input[name="dimensions"]').value = bookDimensions.value;
      if (bookIsbn) document.querySelector('input[name="isbn"]').value = bookIsbn.value;
    }
  });

  document.addEventListener('DOMContentLoaded', updateCategoryForm);
  updateCategoryForm();
</script>
@endsection
