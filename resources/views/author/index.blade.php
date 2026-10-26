@extends('layouts.app')

@section('title', 'About the Author — BIANCA VEANA')

@section('content')
<div style="background: radial-gradient(circle at 60% 40%, #1c365d 0%, #172B49 100%); color: var(--ivory); padding: 70px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container text-center" style="text-align: center;">
    <span class="hero-subtitle" style="justify-content: center;"><i class="fa-solid fa-feather"></i> LITERARY CREATOR</span>
    <h1 style="font-size: 3.2rem; margin: 12px 0;">BIANCA VEANA</h1>
    <p style="color: #BAC7D7; max-width: 680px; margin: 0 auto; font-size: 1.1rem; font-style: italic;">
      "Where every story finds its reader, and every heart has a story of its own."
    </p>
  </div>
</div>

<div class="container" style="padding: 70px 24px;">
  <!-- Bio Grid -->
  <div style="display: grid; grid-template-columns: 0.85fr 1.15fr; gap: 60px; align-items: center; margin-bottom: 70px;">
    <div>
      <div style="background: var(--ocean-navy-deep); padding: 24px; border-radius: var(--radius-md); border: 2px solid var(--champagne-gold); box-shadow: var(--shadow-lg); text-align: center;">
        <img src="{{ asset('images/mantra_boxset.svg') }}" alt="Bianca Veana Universe" style="max-height: 480px; margin: 0 auto; border-radius: var(--radius-sm);">
      </div>
      <div style="display: flex; justify-content: center; gap: 14px; margin-top: 24px;">
        <a href="https://instagram.com/Biancaveana" target="_blank" class="btn btn-gold" style="padding: 10px 20px; font-size: 0.78rem;">
          <i class="fa-brands fa-instagram"></i> @Biancaveana
        </a>
        <a href="https://tiktok.com/@Biancaveana" target="_blank" class="btn btn-outline-gold" style="color: var(--ocean-navy); border-color: var(--ocean-navy); padding: 10px 20px; font-size: 0.78rem;">
          <i class="fa-brands fa-tiktok"></i> @Biancaveana
        </a>
      </div>
    </div>

    <div>
      <span class="section-tag">BIOGRAFI & PROFIL</span>
      <h2 style="font-family: var(--font-serif); font-size: 2.4rem; color: var(--ocean-navy); margin-bottom: 20px;">
        Menghidupkan Kompleksitas Hati & Keagungan Royalti
      </h2>
      <div style="font-size: 1rem; line-height: 1.9; color: var(--text-dark);">
        <p style="margin-bottom: 18px;">
          <strong>Bianca Veana</strong> adalah jenama literatur dan penulis novel fiksi yang berfokus pada eksplorasi cinta mendalam, ambisi kekuasaan, luka masa lalu, dan dinamika keluarga berdarah biru. Karya-karyanya dikenal berkat kedalaman psikologis karakter, dialog puitis yang membekas, serta latar belakang tradisi bangsawan yang megah dan autentik.
        </p>
        <p style="margin-bottom: 18px;">
          Melalui semesta cerita <em>The Seven Notonegoro Series</em>, Bianca Veana mengajak para pembaca menyelami kehidupan tujuh penerus trah Notonegoro. Setiap seri mengupas sudut pandang yang berbeda—mulai dari pengorbanan Sadewa dalam <em>Mantra</em>, pergulatan batin Renata dan Samudra dalam <em>Hierarchy</em>, hingga perlindungan tanpa syarat Raka Satya dalam <em>Fate</em>.
        </p>
        <p>
          Selamat datang di Bianca Veana Universe — tempat di mana setiap kata dirajut dengan ketulusan emosi, mengundang Anda untuk bermimpi, terlena, dan menemukan bagian dari diri Anda di setiap lembarnya.
        </p>
      </div>
    </div>
  </div>

  <!-- Bibliography / List of Works -->
  <div class="section-header">
    <span class="section-tag">BIBLIOGRAPHY & WORKS</span>
    <h2 class="section-title">DAFTAR KARYA BIANCA VEANA</h2>
    <div class="section-divider"></div>
  </div>

  <div class="series-grid" style="grid-template-columns: repeat(4, 1fr);">
    @foreach($books as $book)
      <div class="product-card" style="background: var(--white);">
        <div class="card-image-wrap">
          <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}">
        </div>
        <div class="card-details">
          <span class="product-series">{{ $book->series_name }}</span>
          <h3 class="product-title">{{ $book->title }}</h3>
          <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 12px;">{{ $book->genre }}</p>
          <a href="{{ route('novels.show', $book->slug) }}" class="btn-card btn-card-primary" style="margin-top: auto;">
            Lihat Koleksi
          </a>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
