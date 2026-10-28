@extends('layouts.app')

@section('title', $product->title . ' — Merchandise Resmi Bianca Veana')

@section('content')
<!-- Breadcrumbs -->
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
  <div style="display: grid; grid-template-columns: 0.95fr 1.05fr; gap: 60px; align-items: start;">
    
    <!-- LEFT: MULTI-IMAGE MERCHANDISE GALLERY -->
    <div style="position: sticky; top: 100px;">
      <div style="background: var(--ocean-navy-deep); padding: 24px; border-radius: var(--radius-md); border: 2px solid var(--champagne-gold); box-shadow: var(--shadow-lg); text-align: center; position: relative;">
        <img id="mainMerchImage" src="{{ asset($product->cover_image) }}" alt="{{ $product->title }}" style="max-height: 480px; max-width: 100%; margin: 0 auto; border-radius: var(--radius-sm); box-shadow: 0 10px 25px rgba(0,0,0,0.4); display: block; transition: opacity 0.25s ease;">
      </div>

      <!-- Thumbnail Gallery Strip -->
      @php
        $allImages = $product->all_images;
      @endphp
      @if(count($allImages) > 1)
        <div style="display: flex; gap: 12px; margin-top: 14px; justify-content: center; align-items: center; flex-wrap: wrap;">
          @foreach($allImages as $idx => $img)
            @php
              $label = $idx === 0 ? 'Foto Utama' : ($idx === 1 ? 'Detail Bahan' : 'Kemasan Box');
            @endphp
            <button type="button" class="merch-thumb-btn {{ $idx === 0 ? 'active' : '' }}" onclick="changeMerchImage('{{ asset($img) }}', this)" style="border: 2px solid {{ $idx === 0 ? 'var(--champagne-gold)' : 'var(--soft-beige)' }}; border-radius: 6px; padding: 3px; background: #FFFFFF; cursor: pointer; transition: all 0.2s ease; width: 76px; height: 96px; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: space-between; box-shadow: {{ $idx === 0 ? '0 0 10px rgba(198, 161, 107, 0.4)' : 'none' }};">
              <img src="{{ asset($img) }}" alt="{{ $label }}" style="width: 100%; height: 72px; object-fit: contain; border-radius: 3px;">
              <span style="font-size: 0.6rem; font-weight: 700; color: var(--ocean-navy); letter-spacing: 0.5px; white-space: nowrap;">{{ $label }}</span>
            </button>
          @endforeach
        </div>
      @endif

      <div style="display: flex; gap: 14px; margin-top: 20px; justify-content: center; flex-wrap: wrap;">
        <span style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; color: var(--ocean-navy); background: var(--ivory); padding: 6px 14px; border-radius: var(--radius-sm); border: 1px solid var(--soft-beige); font-weight: 600;">
          <i class="fa-solid fa-crown" style="color: var(--champagne-gold);"></i> Official Merchandise
        </span>
        <span style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; color: var(--ocean-navy); background: var(--ivory); padding: 6px 14px; border-radius: var(--radius-sm); border: 1px solid var(--soft-beige); font-weight: 600;">
          <i class="fa-solid fa-box-open" style="color: var(--champagne-gold);"></i> Exclusive Packaging
        </span>
        <span style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; color: var(--ocean-navy); background: var(--ivory); padding: 6px 14px; border-radius: var(--radius-sm); border: 1px solid var(--soft-beige); font-weight: 600;">
          <i class="fa-solid fa-shield-halved" style="color: var(--champagne-gold);"></i> 100% Authentic
        </span>
      </div>
    </div>

    <!-- RIGHT: PRODUCT DETAILS & PURCHASE -->
    <div>
      <span style="font-size: 0.8rem; letter-spacing: 3px; color: var(--champagne-gold); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 8px;">
        {{ $product->series_name ?: 'BIANCA VEANA OFFICIAL MERCHANDISE' }}
      </span>

      <h1 style="font-family: var(--font-serif); font-size: 2.6rem; color: var(--ocean-navy); margin-bottom: 12px; line-height: 1.2;">
        {{ $product->title }}
      </h1>

      @if($product->subtitle)
        <div style="font-size: 1rem; color: var(--champagne-gold); font-weight: 600; margin-bottom: 18px;">
          {{ $product->subtitle }}
        </div>
      @endif

      <!-- Price Box -->
      <div style="background: var(--white); padding: 20px 28px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige); margin-bottom: 24px; display: flex; align-items: baseline; gap: 16px;">
        <span style="font-size: 2.2rem; font-weight: 700; color: var(--ocean-navy);">
          {{ $product->formatted_price }}
        </span>
        @if($product->original_price)
          <span style="font-size: 1.15rem; color: #9AA5B8; text-decoration: line-through;">
            {{ $product->formatted_original_price }}
          </span>
          <span style="background: #FFE4E6; color: #E11D48; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">
            HEMAT {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
          </span>
        @endif
      </div>

      <!-- Description Box -->
      <div style="margin-bottom: 24px;">
        <h3 style="font-family: var(--font-serif); font-size: 1.2rem; color: var(--ocean-navy); margin-bottom: 10px;">Deskripsi Merchandise</h3>
        <div style="font-size: 0.95rem; line-height: 1.8; color: var(--text-dark); background: var(--white); padding: 20px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige);">
          {{ $product->synopsis }}
        </div>
      </div>

      <!-- MERCHANDISE SPECIFICATIONS TABLE -->
      <div style="background: #FAF8F5; border: 1px solid var(--champagne-gold); border-radius: var(--radius-md); padding: 20px 24px; margin-bottom: 24px;">
        <h4 style="font-family: var(--font-serif); font-size: 1.1rem; color: var(--ocean-navy); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-list-check" style="color: var(--champagne-gold);"></i> Spesifikasi Detail Merchandise:
        </h4>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 0.88rem;">
          @if($product->publisher && !str_contains(strtolower($product->publisher), 'publishing'))
            <div>
              <span style="color: var(--text-muted); font-size: 0.78rem; display: block;">Material / Bahan:</span>
              <strong style="color: var(--ocean-navy);">{{ $product->publisher }}</strong>
            </div>
          @endif

          @if($product->genre)
            <div>
              <span style="color: var(--text-muted); font-size: 0.78rem; display: block;">Varian / Tipe:</span>
              <strong style="color: var(--ocean-navy);">{{ $product->genre }}</strong>
            </div>
          @endif

          @if($product->dimensions)
            <div>
              <span style="color: var(--text-muted); font-size: 0.78rem; display: block;">Dimensi Ukuran:</span>
              <strong style="color: var(--ocean-navy);">{{ $product->dimensions }}</strong>
            </div>
          @endif

          <div>
            <span style="color: var(--text-muted); font-size: 0.78rem; display: block;">Berat Pengiriman:</span>
            <strong style="color: var(--ocean-navy);">{{ $product->weight_grams ?: 120 }} Gram</strong>
          </div>
        </div>

        @if($product->collectors_items && count($product->collectors_items) > 0)
          <div style="margin-top: 14px; padding-top: 12px; border-top: 1px dashed rgba(198, 161, 107, 0.4);">
            <span style="color: var(--text-muted); font-size: 0.78rem; display: block; margin-bottom: 6px;">Kelengkapan Kemasan / Isi Paket:</span>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 4px;">
              @foreach($product->collectors_items as $item)
                <li style="font-size: 0.85rem; color: var(--ocean-navy); display: flex; align-items: center; gap: 8px;">
                  <i class="fa-solid fa-check" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> {{ $item }}
                </li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>

      <!-- Stock Status -->
      <div style="margin-bottom: 24px; font-size: 0.88rem; color: #15803D;">
        <i class="fa-solid fa-circle-check"></i> Stok Tersedia: <strong>{{ $product->stock }} buah</strong> siap dikirim
      </div>

      <!-- Add to Cart Form -->
      <form action="{{ route('cart.add') }}" method="POST" style="background: var(--white); padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige);">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div style="display: flex; gap: 16px;">
          <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 70px; text-align: center; border: 1px solid var(--soft-beige); border-radius: var(--radius-sm); font-size: 1rem; font-weight: 600;">
          <button type="submit" class="btn btn-gold" style="flex: 1; padding: 14px 24px; font-weight: 700;">
            <i class="fa-solid fa-cart-shopping"></i> TAMBAH KE KERANJANG
          </button>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function changeMerchImage(src, btn) {
    const mainImg = document.getElementById('mainMerchImage');
    if (!mainImg) return;
    mainImg.style.opacity = '0.3';
    setTimeout(() => {
      mainImg.src = src;
      mainImg.style.opacity = '1';
    }, 150);

    document.querySelectorAll('.merch-thumb-btn').forEach(b => {
      b.style.borderColor = 'var(--soft-beige)';
      b.style.boxShadow = 'none';
      b.classList.remove('active');
    });

    btn.style.borderColor = 'var(--champagne-gold)';
    btn.style.boxShadow = '0 0 10px rgba(198, 161, 107, 0.4)';
    btn.classList.add('active');
  }
</script>
@endpush
