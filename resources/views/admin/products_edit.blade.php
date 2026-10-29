@extends('layouts.admin')

@section('title', 'Edit Produk — Admin BIANCA VEANA')

@section('content')
<div class="admin-container" style="max-width: 960px;">

  <!-- Header Breadcrumb & Actions -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div>
      <a href="{{ route('admin.products') }}" style="color: #64748B; text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Produk
      </a>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0; font-weight: 700;">
        Edit Produk: <span style="color: var(--admin-gold);">{{ $product->title }}</span>
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

  <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- SECTION 1: INFORMASI UTAMA -->
    <div class="admin-card" style="margin-bottom: 24px;">
      <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 8px; border-bottom: 1px solid var(--soft-beige); display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-sliders" style="color: var(--champagne-gold);"></i> 1. Informasi Utama Produk
      </h3>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Kategori Produk *</label>
          <select name="category" id="product_category" required onchange="updateCategoryForm()" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem; background: #FFF; font-weight: 600;">
            <option value="novel" {{ old('category', $product->category) === 'novel' ? 'selected' : '' }}>📖 Novel Cetak (Physical Book)</option>
            <option value="ebook" {{ old('category', $product->category) === 'ebook' ? 'selected' : '' }}>📱 E-Book Digital (PDF / GDrive)</option>
            <option value="merchandise" {{ old('category', $product->category) === 'merchandise' ? 'selected' : '' }}>👑 Merchandise Resmi</option>
          </select>
        </div>

        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Subkategori / Seri</label>
          <select name="subcategory" id="product_subcategory" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem; background: #FFF;">
            <option value="notonegoro" {{ old('subcategory', $product->subcategory) === 'notonegoro' ? 'selected' : '' }}>The Seven Notonegoro Series</option>
            <option value="standalone" {{ old('subcategory', $product->subcategory) === 'standalone' ? 'selected' : '' }}>Standalone Novel</option>
            <option value="limited" {{ old('subcategory', $product->subcategory) === 'limited' ? 'selected' : '' }}>Royal Limited Edition</option>
            <option value="ebook" {{ old('subcategory', $product->subcategory) === 'ebook' ? 'selected' : '' }}>E-Book Novel Lengkap</option>
            <option value="chapter" {{ old('subcategory', $product->subcategory) === 'chapter' ? 'selected' : '' }}>Serial Bab Digital</option>
            <option value="merch" {{ old('subcategory', $product->subcategory) === 'merch' ? 'selected' : '' }}>Aksesoris & Merchandise Koleksi</option>
          </select>
        </div>
      </div>

      <div style="margin-bottom: 18px;">
        <label id="lbl-title" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
          Judul Produk *
        </label>
        <input type="text" name="title" id="input_title" value="{{ old('title', $product->title) }}" required placeholder="Contoh: Pembatas Buku Logam Kuningan Notonegoro" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
        <div>
          <label id="lbl-series" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Seri Terkait / Tema Koleksi</label>
          <input type="text" name="series_name" value="{{ old('series_name', $product->series_name) }}" placeholder="Contoh: The Seven Notonegoro Official Merchandise" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
        </div>

        <div>
          <label id="lbl-subtitle" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Subtitle / Varian Edisi</label>
          <input type="text" name="subtitle" value="{{ old('subtitle', $product->subtitle) }}" placeholder="Contoh: Royal Swan 18K Gold Plated Edition" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px;">
        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Harga Jual (Rp) *</label>
          <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" placeholder="129000" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
        </div>

        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Harga Coret / Asli (Rp)</label>
          <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}" min="0" placeholder="149000" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
        </div>

        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Jumlah Stok Tersedia *</label>
          <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" placeholder="50" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
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

      @php
        $gallery = is_array($product->gallery_images) ? $product->gallery_images : [];
        $img2 = $gallery[0] ?? null;
        $img3 = $gallery[1] ?? null;
      @endphp

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px;">
        <!-- Foto 1: Foto Utama -->
        <div style="background: #FAFAF7; border: 1px solid var(--soft-beige); border-radius: 6px; padding: 16px;">
          <div id="lbl-slot-1" style="font-size: 0.84rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
            <span style="background: var(--champagne-gold); color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">1</span>
            Foto Utama (Tampak Depan) *
          </div>
          
          <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
            <div style="width: 60px; height: 80px; border-radius: 4px; overflow: hidden; background: #0E1A2B; border: 1px solid var(--champagne-gold); flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
              <img src="{{ asset($product->cover_image) }}" alt="Foto 1" style="width: 100%; height: 100%; object-fit: contain;" onerror="this.onerror=null; this.src='/images/mantra.svg';">
            </div>
            <div style="font-size: 0.72rem; color: #16A34A; font-weight: 600;">
              <i class="fa-solid fa-circle-check"></i> Foto Utama Aktif
            </div>
          </div>

          <label style="display: block; font-size: 0.76rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 4px;">Ganti File Foto:</label>
          <input type="file" name="cover_image_file" accept="image/*" style="width: 100%; font-size: 0.8rem; margin-bottom: 8px;">
          <input type="text" name="cover_image_url" value="{{ old('cover_image_url', $product->cover_image) }}" placeholder="Atau URL: /images/photo.jpg" style="width: 100%; padding: 6px 10px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.78rem;">
        </div>

        <!-- Foto 2: Sudut Samping / Detail Bahan -->
        <div id="box-slot-2" style="background: #FAFAF7; border: 1px solid var(--soft-beige); border-radius: 6px; padding: 16px;">
          <div id="lbl-slot-2" style="font-size: 0.84rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
            <span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">2</span>
            Foto Sudut Samping / Detail Bahan
          </div>

          @if($img2)
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
              <div style="width: 60px; height: 80px; border-radius: 4px; overflow: hidden; background: #0E1A2B; border: 1px solid #CBD5E1; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset($img2) }}" alt="Foto 2" style="width: 100%; height: 100%; object-fit: contain;">
              </div>
              <label style="font-size: 0.72rem; color: #DC2626; cursor: pointer; display: flex; align-items: center; gap: 4px; font-weight: 600;">
                <input type="checkbox" name="remove_gallery_2" value="1"> Hapus foto ini
              </label>
            </div>
          @endif

          <label style="display: block; font-size: 0.76rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 4px;">Pilih File Baru:</label>
          <input type="file" name="gallery_image_2" accept="image/*" style="width: 100%; font-size: 0.8rem; margin-bottom: 8px;">
          <input type="text" name="gallery_url_2" value="{{ old('gallery_url_2', $img2) }}" placeholder="Atau URL foto kedua" style="width: 100%; padding: 6px 10px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.78rem;">
        </div>

        <!-- Foto 3: Kemasan Box / Packaging / Detail Tambahan -->
        <div id="box-slot-3" style="background: #FAFAF7; border: 1px solid var(--soft-beige); border-radius: 6px; padding: 16px;">
          <div id="lbl-slot-3" style="font-size: 0.84rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
            <span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">3</span>
            Foto Kemasan / Box / Detail Unboxing
          </div>

          @if($img3)
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
              <div style="width: 60px; height: 80px; border-radius: 4px; overflow: hidden; background: #0E1A2B; border: 1px solid #CBD5E1; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset($img3) }}" alt="Foto 3" style="width: 100%; height: 100%; object-fit: contain;">
              </div>
              <label style="font-size: 0.72rem; color: #DC2626; cursor: pointer; display: flex; align-items: center; gap: 4px; font-weight: 600;">
                <input type="checkbox" name="remove_gallery_3" value="1"> Hapus foto ini
              </label>
            </div>
          @endif

          <label style="display: block; font-size: 0.76rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 4px;">Pilih File Baru:</label>
          <input type="file" name="gallery_image_3" accept="image/*" style="width: 100%; font-size: 0.8rem; margin-bottom: 8px;">
          <input type="text" name="gallery_url_3" value="{{ old('gallery_url_3', $img3) }}" placeholder="Atau URL foto ketiga" style="width: 100%; padding: 6px 10px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.78rem;">
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
        <textarea name="synopsis" rows="4" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem; line-height: 1.6;">{{ old('synopsis', $product->synopsis) }}</textarea>
      </div>

      <!-- MERCHANDISE SPECIFICATIONS -->
      <div id="section-specs-merch">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
              <i class="fa-solid fa-cube" style="color: var(--champagne-gold);"></i> Material / Bahan Pembuatan
            </label>
            <input type="text" name="publisher" id="input_merch_material" value="{{ old('publisher', $product->publisher) }}" placeholder="Contoh: Logam Kuningan Gold Plated 18K / Katun Organik / Lilin Kedelai" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
              <i class="fa-solid fa-palette" style="color: var(--champagne-gold);"></i> Varian / Warna / Tipe
            </label>
            <input type="text" name="genre" id="input_merch_variant" value="{{ old('genre', $product->genre) }}" placeholder="Contoh: Champagne Gold / Midnight Navy Edition" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 18px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
              <i class="fa-solid fa-ruler-combined" style="color: var(--champagne-gold);"></i> Dimensi Ukuran Barang
            </label>
            <input type="text" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="Contoh: 14 cm x 4.5 cm / All Size" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
              <i class="fa-solid fa-weight-scale" style="color: var(--champagne-gold);"></i> Berat Paket Pengiriman (Gram) *
            </label>
            <input type="number" name="weight_grams" value="{{ old('weight_grams', $product->weight_grams ?: 150) }}" placeholder="150" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
            <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 4px;">Penting untuk kalkulasi otomatis ongkir ekspedisi.</span>
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
              <i class="fa-solid fa-barcode" style="color: var(--champagne-gold);"></i> Kode Produk / SKU
            </label>
            <input type="text" name="isbn" value="{{ old('isbn', $product->isbn) }}" placeholder="Contoh: BV-MRCH-001" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>
        </div>
      </div>

      <!-- NOVEL / BOOK SPECIFICATIONS (Shown only for Novel & E-Book) -->
      <div id="section-specs-book">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 18px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Genre Buku</label>
            <input type="text" name="book_genre" id="input_book_genre" value="{{ old('genre', $product->genre) }}" placeholder="Royal Romance, Drama" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Jumlah Halaman</label>
            <input type="number" name="pages" value="{{ old('pages', $product->pages) }}" placeholder="456" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div id="box-book-weight">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Berat Paket (Gram)</label>
            <input type="number" name="book_weight_grams" id="input_book_weight" value="{{ old('weight_grams', $product->weight_grams ?: 350) }}" placeholder="350" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 18px;">
          <div id="box-book-dimensions">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Dimensi Ukuran Buku</label>
            <input type="text" name="book_dimensions" id="input_book_dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="14 x 20.5 cm" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Nomor ISBN</label>
            <input type="text" name="book_isbn" id="input_book_isbn" value="{{ old('isbn', $product->isbn) }}" placeholder="978-623-XXXX-XX-X" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
          </div>

          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">Penerbit</label>
            <input type="text" name="book_publisher" id="input_book_publisher" value="{{ old('publisher', $product->publisher ?: 'Bianca Veana Publishing') }}" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">
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

      @php
        $collectorsText = is_array($product->collectors_items) ? implode("\n", $product->collectors_items) : '';
      @endphp

      <!-- Collectors Items / Kelengkapan Box -->
      <div id="box-collectors-items" style="margin-bottom: 18px;">
        <label id="lbl-collectors-items" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--ocean-navy); margin-bottom: 6px;">
          Kelengkapan Paket / Bonus (Pisahkan per baris)
        </label>
        <textarea name="collectors_items_text" id="input_collectors_text" rows="3" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.92rem;">{{ old('collectors_items_text', $collectorsText) }}</textarea>
      </div>

      <!-- KHUSUS E-BOOK DIGITAL -->
      <div id="box-ebook-digital" style="background: var(--ivory); padding: 18px; border-radius: 6px; border: 1px solid var(--soft-beige); margin-bottom: 10px;">
        <h4 style="font-size: 0.95rem; color: var(--ocean-navy); margin-bottom: 12px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
          <i class="fa-brands fa-google-drive" style="color: #2563EB;"></i> Khusus E-Book: Tautan Akses File Digital Pembeli
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

        <!-- Isi Naskah Bab (Web Novel Reader) -->
        <div style="margin-top: 18px; padding-top: 16px; border-top: 1px dashed var(--soft-beige);">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
            <label style="font-size: 0.85rem; font-weight: 700; color: var(--ocean-navy); display: flex; align-items: center; gap: 6px;">
              <i class="fa-solid fa-book-open-reader" style="color: var(--champagne-gold);"></i> Isi Naskah Cerita Bab (Web Novel Reader)
            </label>
            @if($product->slug)
              <a href="{{ route('reader.show', $product->slug) }}" target="_blank" style="font-size: 0.75rem; color: #166534; background: #DCFCE7; padding: 3px 10px; border-radius: 4px; border: 1px solid #BBF7D0; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Reader
              </a>
            @endif
          </div>
          <p style="font-size: 0.78rem; color: var(--text-muted); margin-bottom: 8px;">
            Teks naskah yang dimasukkan di sini dapat langsung dibaca oleh pembeli di web setelah pesanan mereka lunas (lengkap dengan mode malam, ubah ukuran huruf, dan proteksi salin teks).
          </p>
          <textarea name="content" rows="12" placeholder="Tempel atau ketik naskah cerita bab ini di sini..." style="width: 100%; padding: 14px 16px; border: 1px solid var(--soft-beige); border-radius: 6px; font-size: 0.92rem; line-height: 1.7; font-family: inherit; resize: vertical;">{{ old('content', $product->content) }}</textarea>
        </div>
      </div>
    </div>

    <!-- Checkboxes -->
    <div style="display: flex; gap: 30px; margin-bottom: 30px; padding: 16px 20px; background: #FAF7F2; border-radius: 6px; border: 1px solid var(--soft-beige); flex-wrap: wrap;">
      <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.88rem; font-weight: 600; color: var(--ocean-navy);">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--admin-gold);">
        <span>Tampilkan di Halaman Utama (Featured)</span>
      </label>

      <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.88rem; font-weight: 600; color: #B45309;">
        <input type="checkbox" name="is_preorder" value="1" {{ old('is_preorder', $product->is_preorder) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #B45309;">
        <span>Status Pre-Order (PO)</span>
      </label>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; justify-content: flex-end; gap: 16px; padding-top: 20px; border-top: 1px solid var(--soft-beige);">
      <a href="{{ route('admin.products') }}" class="btn btn-outline-gold" style="color: var(--ocean-navy); border-color: var(--soft-beige); padding: 12px 24px;">
        Batal
      </a>
      <button type="submit" class="btn btn-gold" style="padding: 14px 34px; font-weight: 700;">
        <i class="fa-solid fa-floppy-disk"></i> SIMPAN PERUBAHAN
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
      // Badge indicator
      badge.innerHTML = '<i class="fa-solid fa-crown"></i> Mode Merchandise Resmi';
      badge.style.background = '#FEF3C7';
      badge.style.color = '#92400E';
      badge.style.border = '1px solid #FDE68A';

      // Section 1 Labels
      document.getElementById('lbl-title').innerText = 'Nama Produk Merchandise *';
      document.getElementById('input_title').placeholder = 'Contoh: Pembatas Buku Logam Kuningan Notonegoro';
      document.getElementById('lbl-series').innerText = 'Seri / Tema Novel Terkait';
      document.getElementById('lbl-subtitle').innerText = 'Varian / Warna / Edisi';

      // Section 2 (Foto)
      document.getElementById('title-section-2').innerHTML = '<i class="fa-solid fa-gift" style="color: var(--champagne-gold);"></i> 2. Foto & Galeri Produk Merchandise';
      document.getElementById('desc-section-2').innerHTML = 'Unggah hingga <strong>3 foto merchandise</strong> (foto produk tampak depan, detail material / bahan saat digunakan, dan foto kemasan / packaging eksklusif).';
      document.getElementById('lbl-slot-1').innerHTML = '<span style="background: var(--champagne-gold); color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">1</span> Foto Utama Produk (Tampak Depan) *';
      document.getElementById('lbl-slot-2').innerHTML = '<span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">2</span> Foto Sudut Samping / Detail Bahan';
      document.getElementById('lbl-slot-3').innerHTML = '<span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">3</span> Foto Kemasan Box / Packaging Eksklusif';
      boxSlot2.style.display = 'block';
      boxSlot3.style.display = 'block';

      // Section 3 (Spesifikasi)
      document.getElementById('title-section-3').innerText = '3. Deskripsi & Spesifikasi Merchandise';
      document.getElementById('lbl-synopsis').innerText = 'Deskripsi Lengkap Produk Merchandise';
      secMerch.style.display = 'block';
      secBook.style.display = 'none';

      // Section 4 (Kelengkapan)
      document.getElementById('title-section-4').innerText = '4. Kelengkapan Kemasan & Isi Box';
      boxCollectors.style.display = 'block';
      document.getElementById('lbl-collectors-items').innerText = 'Item Kelengkapan dalam Paket (Pisahkan per baris)';
      document.getElementById('input_collectors_text').placeholder = 'Contoh:\nHardbox Beludru Eksklusif\nPouch Kain Satin Bianca Veana\nKartu Sertifikat Keaslian Notonegoro';
      boxEbook.style.display = 'none';

    } else if (cat === 'ebook') {
      // Badge indicator
      badge.innerHTML = '<i class="fa-solid fa-tablet-screen-button"></i> Mode E-Book Digital';
      badge.style.background = '#EFF6FF';
      badge.style.color = '#1E40AF';
      badge.style.border = '1px solid #BFDBFE';

      // Section 1 Labels
      document.getElementById('lbl-title').innerText = 'Judul E-Book / Bab Digital *';
      document.getElementById('input_title').placeholder = 'Contoh: E-Book Novel Mantra (Full Chapter)';
      document.getElementById('lbl-series').innerText = 'Nama Seri Novel';
      document.getElementById('lbl-subtitle').innerText = 'Subtitle / Keterangan Edisi Digital';

      // Section 2 (Foto)
      document.getElementById('title-section-2').innerHTML = '<i class="fa-solid fa-tablet-screen-button" style="color: var(--champagne-gold);"></i> 2. Cover E-Book Digital';
      document.getElementById('desc-section-2').innerHTML = 'Unggah gambar digital cover art beresolusi tinggi.';
      document.getElementById('lbl-slot-1').innerHTML = '<span style="background: var(--champagne-gold); color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">1</span> Cover Digital E-Book (Utama) *';
      boxSlot2.style.display = 'none';
      boxSlot3.style.display = 'none';

      // Section 3 (Spesifikasi)
      document.getElementById('title-section-3').innerText = '3. Sinopsis & Spesifikasi E-Book';
      document.getElementById('lbl-synopsis').innerText = 'Sinopsis / Ringkasan Cerita';
      secMerch.style.display = 'none';
      secBook.style.display = 'block';
      document.getElementById('box-book-weight').style.display = 'none';
      document.getElementById('box-book-dimensions').style.display = 'none';

      // Section 4 (Akses Digital)
      document.getElementById('title-section-4').innerText = '4. Tautan Akses File Digital Pembeli';
      boxCollectors.style.display = 'none';
      boxEbook.style.display = 'block';

    } else {
      // NOVEL FISIK
      badge.innerHTML = '<i class="fa-solid fa-book-open"></i> Mode Novel Cetak Fisik';
      badge.style.background = '#ECFDF5';
      badge.style.color = '#065F46';
      badge.style.border = '1px solid #A7F3D0';

      // Section 1 Labels
      document.getElementById('lbl-title').innerText = 'Judul Novel Cetak *';
      document.getElementById('input_title').placeholder = 'Contoh: Mantra';
      document.getElementById('lbl-series').innerText = 'Nama Seri Lengkap (Label Tampilan)';
      document.getElementById('lbl-subtitle').innerText = 'Subtitle / Tagline Buku';

      // Section 2 (Foto)
      document.getElementById('title-section-2').innerHTML = '<i class="fa-solid fa-book-open" style="color: var(--champagne-gold);"></i> 2. Foto & Galeri Buku Fisik';
      document.getElementById('desc-section-2').innerHTML = 'Untuk pembelian buku fisik, Anda dapat mengunggah hingga <strong>3 foto</strong> (cover depan, cover belakang / punggung buku, dan detail isi buku / bonus).';
      document.getElementById('lbl-slot-1').innerHTML = '<span style="background: var(--champagne-gold); color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">1</span> Foto Cover Depan (Utama) *';
      document.getElementById('lbl-slot-2').innerHTML = '<span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">2</span> Foto Cover Belakang / Sisi Punggung Buku';
      document.getElementById('lbl-slot-3').innerHTML = '<span style="background: #94A3B8; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">3</span> Foto Detail Isi / Bonus Fisik';
      boxSlot2.style.display = 'block';
      boxSlot3.style.display = 'block';

      // Section 3 (Spesifikasi)
      document.getElementById('title-section-3').innerText = '3. Sinopsis & Spesifikasi Buku Fisik';
      document.getElementById('lbl-synopsis').innerText = 'Sinopsis Novel';
      secMerch.style.display = 'none';
      secBook.style.display = 'block';
      document.getElementById('box-book-weight').style.display = 'block';
      document.getElementById('box-book-dimensions').style.display = 'block';

      // Section 4 (Bonus)
      document.getElementById('title-section-4').innerText = '4. Bonus Edisi Spesial (Collector\'s Keepsake)';
      boxCollectors.style.display = 'block';
      document.getElementById('lbl-collectors-items').innerText = 'Item Bonus Edisi Spesial (Pisahkan per baris)';
      document.getElementById('input_collectors_text').placeholder = 'Special Dust Jacket with Gold Foil\nExclusive Photocard Couple\nGold Foil Bookmark';
      boxEbook.style.display = 'none';
    }
  }

  // Synchronize inputs before submit so data saves to correct columns
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

  // Run on page load
  document.addEventListener('DOMContentLoaded', updateCategoryForm);
  updateCategoryForm();
</script>
@endsection
