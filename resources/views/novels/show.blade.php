@extends('layouts.app')

@section('title', $novel->title . ' — Bianca Veana Official')

@section('content')
<!-- Breadcrumbs -->
<div style="background: var(--ivory); padding: 14px 0; border-bottom: 1px solid var(--soft-beige); font-size: 0.82rem;">
  <div class="container">
    <a href="{{ route('home') }}" style="color: var(--text-muted);">Home</a>
    <span style="margin: 0 8px; color: var(--champagne-gold);">/</span>
    <a href="{{ route('novels.index') }}" style="color: var(--text-muted);">Novels</a>
    <span style="margin: 0 8px; color: var(--champagne-gold);">/</span>
    <span style="color: var(--ocean-navy); font-weight: 600;">{{ $novel->title }}</span>
  </div>
</div>

<div class="container" style="padding: 60px 24px;">
  <div style="display: grid; grid-template-columns: 0.9fr 1.1fr; gap: 60px; align-items: start;">
    <!-- Left: Book Cover & Badges -->
    <div style="position: sticky; top: 100px;">
      <div style="background: var(--ocean-navy-deep); padding: 24px; border-radius: var(--radius-md); border: 2px solid var(--champagne-gold); box-shadow: var(--shadow-lg); text-align: center;">
        <img src="{{ asset($novel->cover_image) }}" alt="Cover {{ $novel->title }}" style="max-height: 540px; margin: 0 auto; border-radius: var(--radius-sm); box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
      </div>
      <div style="display: flex; gap: 14px; margin-top: 20px; justify-content: center;">
        <span style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; color: var(--ocean-navy); background: var(--ivory); padding: 6px 14px; border-radius: var(--radius-sm); border: 1px solid var(--soft-beige); font-weight: 600;">
          <i class="fa-solid fa-shield-halved" style="color: var(--champagne-gold);"></i> 100% Original
        </span>
        <span style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; color: var(--ocean-navy); background: var(--ivory); padding: 6px 14px; border-radius: var(--radius-sm); border: 1px solid var(--soft-beige); font-weight: 600;">
          <i class="fa-solid fa-box" style="color: var(--champagne-gold);"></i> Box & Bubble Safe
        </span>
      </div>
    </div>

    <!-- Right: Book Details & Actions -->
    <div>
      <span style="font-size: 0.8rem; letter-spacing: 3px; color: var(--champagne-gold); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 8px;">
        {{ $novel->series_name }}
      </span>
      <h1 style="font-family: var(--font-serif); font-size: 2.8rem; color: var(--ocean-navy); margin-bottom: 10px; line-height: 1.2;">
        {{ $novel->title }}
      </h1>
      <div style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 24px;">
        Penulis: <strong style="color: var(--ocean-navy);">{{ $novel->author }}</strong> · Genre: <strong style="color: var(--ocean-navy);">{{ $novel->genre }}</strong>
      </div>

      <!-- Price Box -->
      <div style="background: var(--white); padding: 20px 28px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige); margin-bottom: 28px; display: flex; align-items: baseline; gap: 16px;">
        <span style="font-size: 2.2rem; font-weight: 700; color: var(--ocean-navy);">
          {{ $novel->formatted_price }}
        </span>
        @if($novel->original_price)
          <span style="font-size: 1.15rem; color: #9AA5B8; text-decoration: line-through;">
            {{ $novel->formatted_original_price }}
          </span>
          <span style="background: #FFE4E6; color: #E11D48; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">
            HEMAT {{ round((($novel->original_price - $novel->price) / $novel->original_price) * 100) }}%
          </span>
        @endif
      </div>

      <!-- Stock Status -->
      <div style="margin-bottom: 24px; font-size: 0.88rem;">
        @if($novel->is_preorder)
          <span style="color: #B45309; background: #FEF3C7; padding: 6px 14px; border-radius: 4px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-clock"></i> SISTEM PRE-ORDER (Estimasi pengiriman batch pertama)
          </span>
        @elseif($novel->stock > 0)
          <span style="color: #15803D; background: #DCFCE7; padding: 6px 14px; border-radius: 4px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-check-circle"></i> Stok Tersedia ({{ $novel->stock }} eksemplar siap kirim)
          </span>
        @else
          <span style="color: #B91C1C; background: #FEE2E2; padding: 6px 14px; border-radius: 4px; font-weight: 600;">
            <i class="fa-solid fa-circle-xmark"></i> Stok Habis
          </span>
        @endif
      </div>

      <!-- Synopsis -->
      <div style="margin-bottom: 32px;">
        <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 12px;">Sinopsis Buku</h3>
        <p style="font-size: 0.98rem; line-height: 1.9; color: var(--text-dark); background: var(--white); padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige);">
          {{ $novel->synopsis }}
        </p>
      </div>

      <!-- Collector's Edition Bonus Showcase -->
      @if($novel->collectors_items)
        <div style="background: linear-gradient(135deg, #FAF6F0 0%, #F4EBDD 100%); border: 1px solid var(--champagne-gold); border-radius: var(--radius-md); padding: 24px; margin-bottom: 32px;">
          <h4 style="font-family: var(--font-serif); font-size: 1.15rem; color: var(--ocean-navy); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-crown" style="color: var(--champagne-gold);"></i> Bonus Edisi Spesial & Collector’s Keepsake:
          </h4>
          <ul style="list-style: none; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            @foreach($novel->collectors_items as $item)
              <li style="display: flex; align-items: center; gap: 10px; font-size: 0.88rem; color: var(--ocean-navy);">
                <i class="fa-solid fa-check" style="color: var(--champagne-gold); font-size: 0.8rem; background: var(--white); width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-sm);"></i>
                <span>{{ $item }}</span>
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Add to Cart Form -->
      <form action="{{ route('cart.add') }}" method="POST" style="background: var(--white); padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige); margin-bottom: 32px;">
        @csrf
        <input type="hidden" name="product_id" value="{{ $novel->id }}">
        <div style="display: flex; gap: 16px; align-items: center;">
          <div style="display: flex; align-items: center; border: 1px solid var(--soft-beige); border-radius: var(--radius-sm); overflow: hidden;">
            <button type="button" onclick="decrementQty()" style="background: var(--ivory); border: none; padding: 12px 18px; cursor: pointer; font-size: 1rem; color: var(--ocean-navy);">-</button>
            <input type="number" id="qty-input" name="quantity" value="1" min="1" max="{{ $novel->stock }}" style="width: 50px; text-align: center; border: none; font-size: 1rem; font-weight: 600; padding: 10px 0;">
            <button type="button" onclick="incrementQty()" style="background: var(--ivory); border: none; padding: 12px 18px; cursor: pointer; font-size: 1rem; color: var(--ocean-navy);">+</button>
          </div>
          <button type="submit" class="btn btn-gold" style="flex: 1; padding: 16px 24px;">
            <i class="fa-solid fa-cart-shopping"></i> TAMBAH KE KERANJANG
          </button>
        </div>
      </form>

      <!-- Physical Book Specifications Table -->
      <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); overflow: hidden;">
        <div style="background: var(--ivory); padding: 14px 20px; font-weight: 700; color: var(--ocean-navy); font-size: 0.95rem; border-bottom: 1px solid var(--soft-beige);">
          <i class="fa-solid fa-list-check" style="color: var(--champagne-gold); margin-right: 8px;"></i> Spesifikasi Fisik Buku
        </div>
        <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem;">
          <tbody>
            <tr style="border-bottom: 1px solid #F0EAE1;">
              <td style="padding: 12px 20px; color: var(--text-muted); width: 35%;">Jumlah Halaman</td>
              <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">{{ $novel->pages ?? 450 }} Halaman (Bookpaper Premium)</td>
            </tr>
            <tr style="border-bottom: 1px solid #F0EAE1;">
              <td style="padding: 12px 20px; color: var(--text-muted);">Berat Buku</td>
              <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">{{ $novel->weight_grams ?? 400 }} gram</td>
            </tr>
            <tr style="border-bottom: 1px solid #F0EAE1;">
              <td style="padding: 12px 20px; color: var(--text-muted);">Dimensi</td>
              <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">{{ $novel->dimensions ?? '14 x 20.5 cm' }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #F0EAE1;">
              <td style="padding: 12px 20px; color: var(--text-muted);">Penerbit</td>
              <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">{{ $novel->publisher }}</td>
            </tr>
            <tr>
              <td style="padding: 12px 20px; color: var(--text-muted);">Nomor ISBN</td>
              <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">{{ $novel->isbn ?? '978-623-99101' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Related Novels Section -->
  @if($relatedNovels->count() > 0)
    <div style="margin-top: 80px;">
      <div class="section-header" style="margin-bottom: 36px;">
        <span class="section-tag">REKOMENDASI KOLEKSI LAINNYA</span>
        <h2 class="section-title" style="font-size: 1.8rem;">KARYA TERKAIT DARI BIANCA VEANA</h2>
        <div class="section-divider"></div>
      </div>

      <div class="series-grid" style="grid-template-columns: repeat(3, 1fr);">
        @foreach($relatedNovels as $rel)
          <div class="product-card">
            <div class="card-image-wrap">
              <img src="{{ asset($rel->cover_image) }}" alt="Cover {{ $rel->title }}">
            </div>
            <div class="card-details">
              <span class="product-series">{{ $rel->series_name }}</span>
              <h3 class="product-title">{{ $rel->title }}</h3>
              <div class="product-price-row">
                <span class="price-current">{{ $rel->formatted_price }}</span>
              </div>
              <a href="{{ route('novels.show', $rel->slug) }}" class="btn-card btn-card-primary">View Book</a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
  function incrementQty() {
    const input = document.getElementById('qty-input');
    const max = parseInt(input.getAttribute('max')) || 99;
    if (parseInt(input.value) < max) {
      input.value = parseInt(input.value) + 1;
    }
  }

  function decrementQty() {
    const input = document.getElementById('qty-input');
    if (parseInt(input.value) > 1) {
      input.value = parseInt(input.value) - 1;
    }
  }
</script>
@endpush
