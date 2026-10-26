@extends('layouts.app')

@section('title', $product->title . ' — Merchandise Bianca Veana')

@section('content')
<div style="background: var(--ivory); padding: 14px 0; border-bottom: 1px solid var(--soft-beige); font-size: 0.82rem;">
  <div class="container">
    <a href="{{ route('home') }}" style="color: var(--text-muted);">Home</a>
    <span style="margin: 0 8px; color: var(--champagne-gold);">/</span>
    <a href="{{ route('merchandise.index') }}" style="color: var(--text-muted);">Merchandise</a>
    <span style="margin: 0 8px; color: var(--champagne-gold);">/</span>
    <span style="color: var(--ocean-navy); font-weight: 600;">{{ $product->title }}</span>
  </div>
</div>

<div class="container" style="padding: 60px 24px;">
  <div style="display: grid; grid-template-columns: 0.9fr 1.1fr; gap: 60px; align-items: start;">
    <div style="background: var(--ocean-navy-deep); padding: 24px; border-radius: var(--radius-md); border: 2px solid var(--champagne-gold); box-shadow: var(--shadow-lg); text-align: center;">
      <img src="{{ asset($product->cover_image) }}" alt="{{ $product->title }}" style="max-height: 480px; margin: 0 auto; border-radius: var(--radius-sm);">
    </div>

    <div>
      <span style="font-size: 0.8rem; letter-spacing: 3px; color: var(--champagne-gold); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 8px;">
        {{ $product->series_name }}
      </span>
      <h1 style="font-family: var(--font-serif); font-size: 2.6rem; color: var(--ocean-navy); margin-bottom: 14px; line-height: 1.2;">
        {{ $product->title }}
      </h1>

      <div style="background: var(--white); padding: 20px 28px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige); margin-bottom: 24px;">
        <span style="font-size: 2.2rem; font-weight: 700; color: var(--ocean-navy);">
          {{ $product->formatted_price }}
        </span>
      </div>

      <div style="margin-bottom: 24px;">
        <h3 style="font-family: var(--font-serif); font-size: 1.2rem; color: var(--ocean-navy); margin-bottom: 10px;">Deskripsi Merchandise</h3>
        <p style="font-size: 0.95rem; line-height: 1.8; color: var(--text-dark); background: var(--white); padding: 20px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige);">
          {{ $product->synopsis }}
        </p>
      </div>

      <div style="margin-bottom: 24px; font-size: 0.88rem; color: #15803D;">
        <i class="fa-solid fa-circle-check"></i> Stok Tersedia: <strong>{{ $product->stock }} buah</strong> siap dikirim
      </div>

      <form action="{{ route('cart.add') }}" method="POST" style="background: var(--white); padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige);">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div style="display: flex; gap: 16px;">
          <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 70px; text-align: center; border: 1px solid var(--soft-beige); border-radius: var(--radius-sm); font-size: 1rem; font-weight: 600;">
          <button type="submit" class="btn btn-gold" style="flex: 1; padding: 14px 24px;">
            <i class="fa-solid fa-cart-shopping"></i> TAMBAH KE KERANJANG
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
