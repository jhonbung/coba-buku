@extends('layouts.app')

@section('title', 'Koleksi Merchandise Resmi — BIANCA VEANA')

@section('content')
<div style="background: linear-gradient(135deg, #172B49 0%, #203A5E 100%); color: var(--ivory); padding: 50px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container text-center" style="text-align: center;">
    <span class="hero-subtitle" style="justify-content: center;"><i class="fa-solid fa-gem"></i> EXCLUSIVE MERCHANDISE</span>
    <h1 style="font-size: 2.8rem; margin: 10px 0;">MERCHANDISE BIANCA VEANA</h1>
    <p style="color: #BAC7D7; max-width: 650px; margin: 0 auto;">
      Aksesoris dan cinderamata eksklusif terinspirasi dari dunia The Seven Notonegoro Series: Mantra, Hierarchy, dan Fate.
    </p>
  </div>
</div>

<div class="container" style="padding: 60px 24px;">
  <div class="series-grid" style="grid-template-columns: repeat(3, 1fr);">
    @foreach($merchandise as $item)
      <div class="product-card" style="background: var(--white);">
        <div class="card-image-wrap" style="aspect-ratio: 1/1;">
          <img src="{{ asset($item->cover_image) }}" alt="{{ $item->title }}">
          <span class="badge-series">{{ $item->series_name }}</span>
        </div>
        <div class="card-details">
          <span class="product-series">{{ $item->series_name }}</span>
          <h3 class="product-title">{{ $item->title }}</h3>
          <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 14px; line-height: 1.6;">
            {{ $item->synopsis }}
          </p>
          <div style="font-size: 0.8rem; color: #15803D; margin-bottom: 12px;">
            <i class="fa-solid fa-check"></i> Stok Tersedia ({{ $item->stock }} item)
          </div>
          <div class="product-price-row">
            <span class="price-current">{{ $item->formatted_price }}</span>
          </div>
          <div class="card-actions">
            <a href="{{ route('merchandise.show', $item->slug) }}" class="btn-card btn-card-primary">
              Lihat Detail
            </a>
            <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
              @csrf
              <input type="hidden" name="product_id" value="{{ $item->id }}">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="btn-wishlist" title="Tambah ke Keranjang">
                <i class="fa-solid fa-cart-plus"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
