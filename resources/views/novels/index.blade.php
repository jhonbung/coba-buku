@extends('layouts.app')

@section('title', 'Katalog Novels — BIANCA VEANA')

@section('content')
<div style="background: var(--ocean-navy); color: var(--ivory); padding: 50px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container text-center" style="text-align: center;">
    <span class="hero-subtitle" style="justify-content: center;">OFFICIAL CATALOG</span>
    <h1 style="font-size: 2.8rem; margin: 10px 0;">NOVELS BIANCA VEANA</h1>
    <p style="color: #BAC7D7; max-width: 600px; margin: 0 auto;">
      Temukan karya-karya novel eksklusif The Seven Notonegoro Series, Standalone Novels, dan Royal Limited Edition Boxset.
    </p>
  </div>
</div>

<div class="container" style="padding: 50px 24px;">
  <!-- Filter & Search Toolbar -->
  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; background: var(--white); padding: 20px 28px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige); margin-bottom: 36px; box-shadow: var(--shadow-sm);">
    <!-- Category Tabs -->
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
      <a href="{{ route('novels.index') }}" class="btn {{ !request('category') ? 'btn-gold' : 'btn-outline-gold' }}" style="padding: 8px 18px; font-size: 0.78rem; {{ request('category') ? 'color: var(--ocean-navy); border-color: var(--soft-beige);' : '' }}">
        Semua Novel
      </a>
      <a href="{{ route('novels.index', ['category' => 'notonegoro']) }}" class="btn {{ request('category') === 'notonegoro' ? 'btn-gold' : 'btn-outline-gold' }}" style="padding: 8px 18px; font-size: 0.78rem; {{ request('category') !== 'notonegoro' ? 'color: var(--ocean-navy); border-color: var(--soft-beige);' : '' }}">
        The Seven Notonegoro
      </a>
      <a href="{{ route('novels.index', ['category' => 'standalone']) }}" class="btn {{ request('category') === 'standalone' ? 'btn-gold' : 'btn-outline-gold' }}" style="padding: 8px 18px; font-size: 0.78rem; {{ request('category') !== 'standalone' ? 'color: var(--ocean-navy); border-color: var(--soft-beige);' : '' }}">
        Standalone Novels
      </a>
      <a href="{{ route('novels.index', ['category' => 'limited']) }}" class="btn {{ request('category') === 'limited' ? 'btn-gold' : 'btn-outline-gold' }}" style="padding: 8px 18px; font-size: 0.78rem; {{ request('category') !== 'limited' ? 'color: var(--ocean-navy); border-color: var(--soft-beige);' : '' }}">
        Limited Editions
      </a>
    </div>

    <!-- Search & Sort -->
    <form action="{{ route('novels.index') }}" method="GET" style="display: flex; gap: 12px; align-items: center;">
      @if(request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
      @endif
      <div style="position: relative;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul novel..." style="padding: 10px 16px 10px 36px; border: 1px solid var(--soft-beige); border-radius: var(--radius-sm); font-size: 0.85rem; width: 220px;">
        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 12px; color: #8E9BAE; font-size: 0.85rem;"></i>
      </div>
      <select name="sort" onchange="this.form.submit()" style="padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: var(--radius-sm); font-size: 0.85rem; background: var(--white); color: var(--text-dark);">
        <option value="">Urutkan: Rekomendasi</option>
        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi</option>
      </select>
    </form>
  </div>

  <!-- Books Grid -->
  @if($novels->count() > 0)
    <div class="series-grid">
      @foreach($novels as $novel)
        <div class="product-card">
          <div class="card-image-wrap">
            <img src="{{ asset($novel->cover_image) }}" alt="Cover {{ $novel->title }}">
            <span class="badge-series">{{ $novel->subtitle }}</span>
            @if($novel->is_preorder)
              <span class="badge-preorder">PRE-ORDER</span>
            @endif
          </div>
          <div class="card-details">
            <span class="product-series">{{ $novel->series_name }}</span>
            <h3 class="product-title">{{ $novel->title }}</h3>
            <span class="product-author">Oleh {{ $novel->author }}</span>
            <div class="product-price-row">
              <span class="price-current">{{ $novel->formatted_price }}</span>
              @if($novel->original_price)
                <span class="price-original">{{ $novel->formatted_original_price }}</span>
              @endif
            </div>
            <div class="card-actions">
              <a href="{{ route('novels.show', $novel->slug) }}" class="btn-card btn-card-primary">
                View Book
              </a>
              <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $novel->id }}">
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
    
    <div style="margin-top: 40px;">
      {{ $novels->links() }}
    </div>
  @else
    <div style="text-align: center; padding: 60px 20px; background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige);">
      <i class="fa-solid fa-book-open" style="font-size: 3rem; color: var(--champagne-gold); margin-bottom: 16px;"></i>
      <h3 style="color: var(--ocean-navy);">Buku Tidak Ditemukan</h3>
      <p style="color: var(--text-muted); margin-top: 6px;">Silakan coba kata kunci lain atau pilih kategori yang berbeda.</p>
      <a href="{{ route('novels.index') }}" class="btn btn-gold" style="margin-top: 20px;">Lihat Semua Koleksi</a>
    </div>
  @endif
</div>
@endsection
