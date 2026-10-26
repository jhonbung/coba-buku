@extends('layouts.app')

@section('title', 'Katalog E-Books & Bab Digital — BIANCA VEANA')

@section('content')
<div style="background: radial-gradient(circle at 50% 50%, #1c365d 0%, #172B49 100%); color: var(--ivory); padding: 60px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container" style="text-align: center;">
    <span class="hero-subtitle" style="justify-content: center;"><i class="fa-solid fa-tablet-screen-button"></i> DIGITAL BOOKSTORE</span>
    <h1 style="font-size: 2.8rem; margin: 10px 0;">E-BOOKS BIANCA VEANA UNIVERSE</h1>
    <p style="color: #BAC7D7; max-width: 680px; margin: 0 auto; line-height: 1.8;">
      Nikmati kemudahan membaca kisah-kisah Notonegoro kapan saja dan di mana saja. Pembeli akan menerima link Google Drive dan file PDF resmi secara instan ke email setelah pembayaran terkonfirmasi.
    </p>
  </div>
</div>

<div class="container" style="padding: 60px 24px;">
  <!-- Section 1: Full E-Books -->
  <div class="section-header" style="text-align: left; margin-bottom: 30px;">
    <span class="section-tag">COMPLETE DIGITAL EDITIONS</span>
    <h2 class="section-title" style="font-size: 2rem;">E-BOOK NOVEL LENGKAP</h2>
    <p style="color: var(--text-muted);">Format PDF Resolusi Tinggi & Akses Google Drive Permanen.</p>
  </div>

  <div class="series-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 60px;">
    @foreach($fullEbooks as $ebook)
      <div class="product-card" style="border: 1px solid var(--champagne-gold); background: var(--white);">
        <div class="card-image-wrap" style="aspect-ratio: 4/5;">
          <img src="{{ asset($ebook->cover_image) }}" alt="{{ $ebook->title }}">
          <span class="badge-series"><i class="fa-solid fa-file-pdf"></i> FORMAT PDF & DRIVE</span>
        </div>
        <div class="card-details">
          <span class="product-series">{{ $ebook->series_name }}</span>
          <h3 class="product-title">{{ $ebook->title }}</h3>
          <p style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 14px; line-height: 1.6;">
            {{ Str::limit($ebook->synopsis, 110) }}
          </p>
          <div style="background: var(--ivory); padding: 8px 12px; border-radius: 4px; font-size: 0.78rem; color: var(--ocean-navy); margin-bottom: 16px;">
            <i class="fa-solid fa-paper-plane" style="color: var(--champagne-gold);"></i> Pengiriman otomatis via email pelanggan
          </div>
          <div class="product-price-row">
            <span class="price-current">{{ $ebook->formatted_price }}</span>
            @if($ebook->original_price)
              <span class="price-original">{{ $ebook->formatted_original_price }}</span>
            @endif
          </div>
          <div class="card-actions">
            <form action="{{ route('cart.add') }}" method="POST" style="flex: 1;">
              @csrf
              <input type="hidden" name="product_id" value="{{ $ebook->id }}">
              <button type="submit" class="btn-card btn-card-primary" style="width: 100%;">
                <i class="fa-solid fa-bag-shopping"></i> Beli E-Book
              </button>
            </form>
            <a href="{{ route('ebooks.download', $ebook->id) }}" target="_blank" class="btn-wishlist" title="Preview Akses Link G-Drive">
              <i class="fa-brands fa-google-drive"></i>
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Section 2: Chapter-based serials (Mantra Bab 1-5, dst) -->
  <div class="section-header" style="text-align: left; margin-bottom: 30px;">
    <span class="section-tag">SERIAL BAB TERPISAH (LYKN STYLE)</span>
    <h2 class="section-title" style="font-size: 2rem;">SERIAL BAB DIGITAL</h2>
    <p style="color: var(--text-muted);">Akses per bab atau bagian cerita untuk membaca secara bertahap.</p>
  </div>

  <div class="series-grid" style="grid-template-columns: repeat(3, 1fr);">
    @foreach($chapterEbooks as $ch)
      <div class="product-card" style="background: var(--white);">
        <div class="card-image-wrap" style="aspect-ratio: 16/9; max-height: 180px;">
          <img src="{{ asset($ch->cover_image) }}" alt="{{ $ch->title }}">
          <span class="badge-series">BAB DIGITAL</span>
        </div>
        <div class="card-details">
          <span class="product-series">{{ $ch->series_name }}</span>
          <h3 class="product-title" style="font-size: 1.1rem;">{{ $ch->title }}</h3>
          <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 12px;">
            {{ $ch->synopsis }}
          </p>
          <div class="product-price-row">
            <span class="price-current">{{ $ch->formatted_price }}</span>
          </div>
          <div class="card-actions">
            <form action="{{ route('cart.add') }}" method="POST" style="flex: 1;">
              @csrf
              <input type="hidden" name="product_id" value="{{ $ch->id }}">
              <button type="submit" class="btn-card btn-card-primary" style="width: 100%;">
                Beli Bab Ini
              </button>
            </form>
            <a href="{{ route('ebooks.download', $ch->id) }}" target="_blank" class="btn-wishlist" title="Lihat Contoh Link Drive">
              <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- How E-Book Works Guide -->
  <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 40px; margin-top: 60px; box-shadow: var(--shadow-sm);">
    <h3 style="font-family: var(--font-serif); font-size: 1.5rem; color: var(--ocean-navy); margin-bottom: 20px; text-align: center;">
      <i class="fa-solid fa-circle-question" style="color: var(--champagne-gold);"></i> Bagaimana Cara Kerja Pembelian E-Book?
    </h3>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 30px;">
      <div style="text-align: center;">
        <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--ivory); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; margin: 0 auto 16px;">1</div>
        <h4 style="color: var(--ocean-navy); margin-bottom: 8px;">Pilih & Checkout</h4>
        <p style="font-size: 0.85rem; color: var(--text-muted);">Pilih judul e-book atau bab, masukkan email aktif Anda pada saat pembayaran.</p>
      </div>

      <div style="text-align: center;">
        <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--ivory); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; margin: 0 auto 16px;">2</div>
        <h4 style="color: var(--ocean-navy); margin-bottom: 8px;">Bayar via QRIS / VA</h4>
        <p style="font-size: 0.85rem; color: var(--text-muted);">Sistem kami memverifikasi pembayaran Anda secara instan dan tanpa biaya kirim.</p>
      </div>

      <div style="text-align: center;">
        <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--ivory); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; margin: 0 auto 16px;">3</div>
        <h4 style="color: var(--ocean-navy); margin-bottom: 8px;">Akses File Otomatis</h4>
        <p style="font-size: 0.85rem; color: var(--text-muted);">File PDF resolusi tinggi dan tautan Google Drive langsung terbuka di layar & dikirim ke email Anda.</p>
      </div>
    </div>
  </div>
</div>
@endsection
