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
  <!-- Section Title & Explanation -->
  <div class="section-header" style="text-align: left; margin-bottom: 36px;">
    <span class="section-tag"><i class="fa-solid fa-tablet-screen-button"></i> DIGITAL UNIVERSE BOOKSTORE</span>
    <h2 class="section-title" style="font-size: 2.3rem;">KATALOG E-BOOKS & SERIAL BAB</h2>
    <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 720px; line-height: 1.7;">
      Pilih judul buku favorit Anda di bawah ini untuk melihat dan membeli <strong>Part E-Book</strong> (baca bertahap per bab hemat) atau <strong>E-Book Lengkap</strong>. Akses PDF & tautan Google Drive langsung dikirim instan tanpa biaya ongkir.
    </p>
  </div>

  <!-- Outer 1-Title-Per-Book Grid: Mantra, Hierarchy, Fate, Serenity -->
  <div class="series-grid" style="grid-template-columns: repeat(4, 1fr); gap: 26px; margin-bottom: 70px;">
    @foreach($ebookTitles as $book)
      @php
        $parts = $book->ebookParts;
        $chapterCount = $parts->whereNotNull('part_number')->count();
        $hasFull = $parts->whereNull('part_number')->count() > 0;
      @endphp
      <div class="product-card" style="border: 1.5px solid var(--soft-beige); background: var(--white); display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s ease;" onmouseover="this.style.borderColor='var(--champagne-gold)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='var(--soft-beige)'; this.style.transform='none';">
        <div class="card-image-wrap" style="aspect-ratio: 4/5;">
          <img src="{{ asset($book->cover_image) }}" alt="Cover {{ $book->title }}">
          <span class="badge-series" style="background: var(--ocean-navy); color: var(--champagne-gold); font-weight: 700;">
            {{ $book->series_number ?? 'SERI NOTONEGORO' }}
          </span>
          @if($book->is_preorder)
            <span class="badge-preorder">DIGITAL PRE-ORDER</span>
          @endif
        </div>

        <div class="card-details" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
          <div>
            <span class="product-series" style="color: var(--champagne-gold); font-weight: 700; font-size: 0.74rem;">
              {{ $book->series_name }}
            </span>
            <h3 class="product-title" style="font-size: 1.25rem; line-height: 1.2; margin: 6px 0 8px;">
              {{ $book->title }}
            </h3>
            
            <p style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 14px; line-height: 1.5;">
              {{ Str::limit($book->synopsis, 85) }}
            </p>

            <!-- Parts Summary Badge -->
            <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 6px; padding: 10px 12px; margin-bottom: 16px;">
              <div style="font-size: 0.75rem; font-weight: 700; color: #1E40AF; display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                <i class="fa-solid fa-layer-group" style="color: #2563EB;"></i> Tersedia Pilihan E-Book:
              </div>
              <div style="font-size: 0.74rem; color: #3B82F6; line-height: 1.4;">
                • {{ $chapterCount > 0 ? $chapterCount . ' Part Serial Digital (Bab)' : 'Serial Bab' }}<br>
                • {{ $hasFull ? '1 Edisi Lengkap Full Novel' : 'Edisi Lengkap' }}
              </div>
            </div>
          </div>

          <div>
            <div class="product-price-row" style="margin-bottom: 12px;">
              <div>
                <span style="font-size: 0.72rem; color: var(--text-muted); display: block;">Mulai dari:</span>
                <span class="price-current" style="font-size: 1.15rem; color: #15803D;">Rp 15.000 <span style="font-size: 0.74rem; font-weight: 500; color: var(--text-muted);">/ part</span></span>
              </div>
            </div>

            <a href="{{ route('novels.show', $book->slug) }}" class="btn-card btn-card-primary" style="width: 100%; text-align: center; padding: 12px 10px; font-size: 0.85rem; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px;">
              <span>Buka & Pilih Part</span>
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Notice switch to physical -->
  <div style="background: #FFFDF9; border: 1px solid var(--champagne-gold); border-radius: var(--radius-md); padding: 22px 28px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; box-shadow: var(--shadow-sm); margin-bottom: 60px;">
    <div style="display: flex; align-items: center; gap: 16px;">
      <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--ivory); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
        <i class="fa-solid fa-book-open"></i>
      </div>
      <div>
        <strong style="color: var(--ocean-navy); font-size: 1rem; display: block; margin-bottom: 2px;">Lebih Suka Membaca Buku Cetak Fisik?</strong>
        <span style="font-size: 0.85rem; color: var(--text-muted);">
          Judul-judul di atas juga tersedia dalam bentuk novel cetak resmi bertandatangan dengan dust jacket & photocard eksklusif.
        </span>
      </div>
    </div>
    <a href="{{ route('novels.index') }}" class="btn btn-gold" style="padding: 12px 22px; font-size: 0.82rem;">
      <i class="fa-solid fa-layer-group"></i> Katalog Novel Cetak Fisik
    </a>
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
