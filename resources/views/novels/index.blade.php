@extends('layouts.app')

@section('title', 'Katalog Novels & E-Books — BIANCA VEANA')

@section('content')
<div style="background: radial-gradient(circle at 50% 50%, #1c365d 0%, #172B49 100%); color: var(--ivory); padding: 54px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container text-center" style="text-align: center;">
    <span class="hero-subtitle" style="justify-content: center;"><i class="fa-solid fa-layer-group"></i> OFFICIAL UNIVERSE CATALOG</span>
    <h1 style="font-size: 2.8rem; margin: 10px 0;">KATALOG BUKU & SERIAL BIANCA VEANA</h1>
    <p style="color: #BAC7D7; max-width: 650px; margin: 0 auto; line-height: 1.8;">
      Jelajahi seluruh karya berdasarkan <strong>Seri & Semesta Cerita</strong>. Tersedia lengkap dalam edisi <strong>Novel Cetak Fisik</strong> bertandatangan dan <strong>E-Book Digital</strong> instan.
    </p>
  </div>
</div>

<div class="container" style="padding: 50px 24px;">
  <!-- Filter & Search Toolbar -->
  <div style="background: var(--white); padding: 22px 28px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige); margin-bottom: 40px; box-shadow: var(--shadow-sm);">
    
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--soft-beige);">
      <!-- Series Group Tabs -->
      <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
        <span style="font-size: 0.78rem; font-weight: 700; color: var(--ocean-navy); text-transform: uppercase; margin-right: 4px;">
          <i class="fa-solid fa-crown" style="color: var(--champagne-gold);"></i> Seri:
        </span>
        <a href="{{ route('novels.index', array_merge(request()->except('category', 'page'))) }}" 
           class="btn {{ !request('category') ? 'btn-gold' : 'btn-outline-gold' }}" 
           style="padding: 6px 14px; font-size: 0.76rem; {{ request('category') ? 'color: var(--ocean-navy); border-color: var(--soft-beige);' : '' }}">
          Semua Seri (Tampilan Grup)
        </a>
        <a href="{{ route('novels.index', array_merge(request()->except('page'), ['category' => 'notonegoro'])) }}" 
           class="btn {{ request('category') === 'notonegoro' ? 'btn-gold' : 'btn-outline-gold' }}" 
           style="padding: 6px 14px; font-size: 0.76rem; {{ request('category') !== 'notonegoro' ? 'color: var(--ocean-navy); border-color: var(--soft-beige);' : '' }}">
          The Seven Notonegoro Series
        </a>
        <a href="{{ route('novels.index', array_merge(request()->except('page'), ['category' => 'standalone'])) }}" 
           class="btn {{ request('category') === 'standalone' ? 'btn-gold' : 'btn-outline-gold' }}" 
           style="padding: 6px 14px; font-size: 0.76rem; {{ request('category') !== 'standalone' ? 'color: var(--ocean-navy); border-color: var(--soft-beige);' : '' }}">
          Standalone Novels
        </a>
        <a href="{{ route('novels.index', array_merge(request()->except('page'), ['category' => 'limited'])) }}" 
           class="btn {{ request('category') === 'limited' ? 'btn-gold' : 'btn-outline-gold' }}" 
           style="padding: 6px 14px; font-size: 0.76rem; {{ request('category') !== 'limited' ? 'color: var(--ocean-navy); border-color: var(--soft-beige);' : '' }}">
          Limited Edition Boxset
        </a>
      </div>

      <!-- Format Filter Tabs (All / Novel / Ebook) -->
      <div style="display: flex; gap: 6px; align-items: center; background: var(--ivory); padding: 4px; border-radius: 6px; border: 1px solid var(--soft-beige);">
        <span style="font-size: 0.74rem; font-weight: 700; color: var(--text-muted); margin: 0 6px;">Format:</span>
        <a href="{{ route('novels.index', array_merge(request()->except('format', 'page'), ['format' => 'all'])) }}" 
           style="padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; text-decoration: none; {{ ($format ?? 'all') === 'all' ? 'background: var(--ocean-navy); color: #FFF;' : 'color: var(--ocean-navy);' }}">
          Semua
        </a>
        <a href="{{ route('novels.index', array_merge(request()->except('format', 'page'), ['format' => 'novel'])) }}" 
           style="padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; text-decoration: none; {{ ($format ?? '') === 'novel' ? 'background: #065F46; color: #FFF;' : 'color: var(--ocean-navy);' }}">
          <i class="fa-solid fa-book-open"></i> Cetak
        </a>
        <a href="{{ route('novels.index', array_merge(request()->except('format', 'page'), ['format' => 'ebook'])) }}" 
           style="padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; text-decoration: none; {{ ($format ?? '') === 'ebook' ? 'background: #1D4ED8; color: #FFF;' : 'color: var(--ocean-navy);' }}">
          <i class="fa-solid fa-tablet-screen-button"></i> E-Book
        </a>
      </div>
    </div>

    <!-- Search & Sort Row -->
    <form action="{{ route('novels.index') }}" method="GET" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
      @if(request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
      @endif
      @if(request('format') && request('format') !== 'all')
        <input type="hidden" name="format" value="{{ request('format') }}">
      @endif

      <div style="position: relative; flex: 1; max-width: 380px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul novel, e-book, atau tokoh..." style="width: 100%; padding: 10px 16px 10px 38px; border: 1px solid var(--soft-beige); border-radius: var(--radius-sm); font-size: 0.85rem;">
        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 12px; color: #8E9BAE; font-size: 0.85rem;"></i>
      </div>

      <div style="display: flex; gap: 10px; align-items: center;">
        <select name="sort" onchange="this.form.submit()" style="padding: 10px 14px; border: 1px solid var(--soft-beige); border-radius: var(--radius-sm); font-size: 0.85rem; background: var(--white); color: var(--text-dark);">
          <option value="">Urutkan: Sesuai Urutan Seri</option>
          <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
          <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi</option>
        </select>
        @if(request('search') || request('category') || request('sort') || request('format'))
          <a href="{{ route('novels.index') }}" style="font-size: 0.8rem; color: #B91C1C; text-decoration: underline;">
            <i class="fa-solid fa-rotate-left"></i> Reset Filter
          </a>
        @endif
      </div>
    </form>
  </div>

  @if($isGroupedView)
    <!-- =========================================================================
         GROUPED BY SERIES DISPLAY (Default View: Structured & Grouped)
         ========================================================================= -->

    <!-- GROUP 1: THE SEVEN NOTONEGORO SERIES -->
    @if(isset($notonegoroNovels) && $notonegoroNovels->count() > 0)
      <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--champagne-gold); padding: 36px 32px; margin-bottom: 50px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
          <div>
            <span style="background: linear-gradient(135deg, #172B49, #203A5E); color: var(--champagne-gold); padding: 4px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 6px;">
              <i class="fa-solid fa-crown"></i> SERIAL UTAMA TRAH NOTONEGORO (KRONOLOGIS SERI 1 – 7)
            </span>
            <h2 style="font-family: var(--font-serif); font-size: 2.1rem; color: var(--ocean-navy); margin: 10px 0 6px;">
              The Seven Notonegoro Series
            </h2>
            <p style="color: var(--text-muted); font-size: 0.92rem; margin: 0; max-width: 720px; line-height: 1.6;">
              Kisah kemegahan dinasti, intrik kekuasaan, dan pengorbanan cinta sejati tujuh keturunan trah Notonegoro. Tersedia dalam format buku cetak fisik maupun e-book digital.
            </p>
          </div>
          <span style="font-size: 0.82rem; background: var(--ivory); color: var(--ocean-navy); padding: 8px 14px; border-radius: 6px; border: 1px solid var(--soft-beige); font-weight: 600;">
            <i class="fa-solid fa-layer-group" style="color: var(--champagne-gold);"></i> {{ $notonegoroNovels->count() }} Koleksi Tersedia
          </span>
        </div>

        <div class="series-grid" style="grid-template-columns: repeat(4, 1fr); gap: 24px;">
          @foreach($notonegoroNovels as $book)
            <div class="product-card" style="border: 1px solid var(--soft-beige); display: flex; flex-direction: column; justify-content: space-between;">
              <div class="card-image-wrap" style="aspect-ratio: 4/5;">
                <img src="{{ asset($book->cover_image) }}" alt="Cover {{ $book->title }}">
                <span class="badge-series" style="background: var(--ocean-navy); color: var(--champagne-gold); font-weight: 700;">
                  {{ $book->series_number ?? $book->subtitle }}
                </span>
                @if($book->is_preorder)
                  <span class="badge-preorder">PRE-ORDER</span>
                @endif
              </div>
              <div class="card-details" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <span class="product-series" style="font-size: 0.75rem; color: var(--champagne-gold); font-weight: 700;">
                      {{ $book->series_number }}
                    </span>
                    @if($book->category === 'ebook')
                      <span style="background: #EFF6FF; color: #1E40AF; padding: 2px 6px; border-radius: 3px; font-size: 0.68rem; font-weight: 700;">
                        <i class="fa-solid fa-tablet-screen-button"></i> E-Book
                      </span>
                    @else
                      <span style="background: #ECFDF5; color: #065F46; padding: 2px 6px; border-radius: 3px; font-size: 0.68rem; font-weight: 700;">
                        <i class="fa-solid fa-book-open"></i> Cetak Fisik
                      </span>
                    @endif
                  </div>
                  <h3 class="product-title" style="font-size: 1.05rem; line-height: 1.3;">{{ $book->title }}</h3>
                  <span class="product-author" style="font-size: 0.75rem;">Oleh {{ $book->author }}</span>
                </div>

                <div style="margin-top: 14px;">
                  <div class="product-price-row">
                    <span class="price-current" style="font-size: 1.15rem;">{{ $book->formatted_price }}</span>
                    @if($book->original_price)
                      <span class="price-original" style="font-size: 0.85rem;">{{ $book->formatted_original_price }}</span>
                    @endif
                  </div>
                  <div class="card-actions" style="margin-top: 10px;">
                    <a href="{{ route('novels.show', $book->slug) }}" class="btn-card btn-card-primary" style="flex: 1; text-align: center; padding: 10px 8px; font-size: 0.78rem;">
                      <i class="fa-solid fa-eye"></i> Detail & Format
                    </a>
                    <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $book->id }}">
                      <input type="hidden" name="quantity" value="1">
                      <button type="submit" class="btn-wishlist" title="Beli Buku Ini">
                        <i class="fa-solid fa-cart-plus"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <!-- GROUP 2: STANDALONE NOVELS -->
    @if(isset($standaloneNovels) && $standaloneNovels->count() > 0)
      <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 36px 32px; margin-bottom: 50px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
          <div>
            <span style="background: #F1F5F9; color: #334155; padding: 4px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 6px;">
              <i class="fa-solid fa-bookmark" style="color: var(--champagne-gold);"></i> KARYA MANDIRI / CERITA TUNGGAL
            </span>
            <h2 style="font-family: var(--font-serif); font-size: 2.1rem; color: var(--ocean-navy); margin: 10px 0 6px;">
              Standalone Novels
            </h2>
            <p style="color: var(--text-muted); font-size: 0.92rem; margin: 0; max-width: 720px; line-height: 1.6;">
              Karya novel yang berdiri sendiri dan dapat dinikmati secara utuh tanpa terikat dengan rangkaian seri Notonegoro.
            </p>
          </div>
          <span style="font-size: 0.82rem; background: var(--ivory); color: var(--ocean-navy); padding: 8px 14px; border-radius: 6px; border: 1px solid var(--soft-beige); font-weight: 600;">
            {{ $standaloneNovels->count() }} Judul Standalone
          </span>
        </div>

        <div class="series-grid" style="grid-template-columns: repeat(4, 1fr); gap: 24px;">
          @foreach($standaloneNovels as $book)
            <div class="product-card" style="border: 1px solid var(--soft-beige); display: flex; flex-direction: column; justify-content: space-between;">
              <div class="card-image-wrap" style="aspect-ratio: 4/5;">
                <img src="{{ asset($book->cover_image) }}" alt="Cover {{ $book->title }}">
                <span class="badge-series">STANDALONE NOVEL</span>
              </div>
              <div class="card-details" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                  <h3 class="product-title" style="font-size: 1.1rem; line-height: 1.3;">{{ $book->title }}</h3>
                  <span class="product-author" style="font-size: 0.75rem;">Oleh {{ $book->author }}</span>
                  <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 6px; line-height: 1.5;">
                    {{ Str::limit($book->synopsis, 95) }}
                  </p>
                </div>

                <div style="margin-top: 14px;">
                  <div class="product-price-row">
                    <span class="price-current" style="font-size: 1.15rem;">{{ $book->formatted_price }}</span>
                    @if($book->original_price)
                      <span class="price-original" style="font-size: 0.85rem;">{{ $book->formatted_original_price }}</span>
                    @endif
                  </div>
                  <div class="card-actions" style="margin-top: 10px;">
                    <a href="{{ route('novels.show', $book->slug) }}" class="btn-card btn-card-primary" style="flex: 1; text-align: center; padding: 10px 8px; font-size: 0.78rem;">
                      <i class="fa-solid fa-eye"></i> Detail Novel
                    </a>
                    <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $book->id }}">
                      <input type="hidden" name="quantity" value="1">
                      <button type="submit" class="btn-wishlist" title="Beli Buku Ini">
                        <i class="fa-solid fa-cart-plus"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <!-- GROUP 3: LIMITED EDITION BOXSETS -->
    @if(isset($limitedNovels) && $limitedNovels->count() > 0)
      <div style="background: linear-gradient(135deg, #172B49 0%, #203A5E 100%); color: var(--ivory); border-radius: var(--radius-md); border: 2px solid var(--champagne-gold); padding: 36px 32px; box-shadow: var(--shadow-md);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
          <div>
            <span style="background: var(--champagne-gold); color: #0F172A; padding: 4px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 6px;">
              <i class="fa-solid fa-gem"></i> EDISI KOLEKTOR TERBATAS (LUXURY BOXSET)
            </span>
            <h2 style="font-family: var(--font-serif); font-size: 2.1rem; color: var(--ivory); margin: 10px 0 6px;">
              Royal Collector's Editions & Hardcover Boxsets
            </h2>
            <p style="color: #BAC7D7; font-size: 0.92rem; margin: 0; max-width: 720px; line-height: 1.6;">
              Dicetak dengan sampul beludru hardcover, tepian emas (gilded edges), bertandatangan asli penulis, dan disertai sertifikat keaslian bernomor seri.
            </p>
          </div>
          <span style="font-size: 0.82rem; background: rgba(255,255,255,0.1); color: var(--champagne-gold); padding: 8px 14px; border-radius: 6px; border: 1px solid rgba(198,161,107,0.4); font-weight: 600;">
            {{ $limitedNovels->count() }} Edisi Mewah
          </span>
        </div>

        <div class="series-grid" style="grid-template-columns: repeat(3, 1fr); gap: 24px;">
          @foreach($limitedNovels as $book)
            <div class="product-card" style="background: #FFFFFF; border: 1px solid var(--champagne-gold); display: flex; flex-direction: column; justify-content: space-between;">
              <div class="card-image-wrap" style="aspect-ratio: 4/5;">
                <img src="{{ asset($book->cover_image) }}" alt="Cover {{ $book->title }}">
                <span class="badge-series" style="background: #B45309; color: #FFF;">LIMITED LUXURY BOXSET</span>
              </div>
              <div class="card-details" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                  <h3 class="product-title" style="font-size: 1.1rem; line-height: 1.3;">{{ $book->title }}</h3>
                  <span class="product-author" style="font-size: 0.75rem;">Oleh {{ $book->author }}</span>
                  <div style="background: #FEF3C7; color: #92400E; padding: 6px 10px; border-radius: 4px; font-size: 0.75rem; margin-top: 8px; font-weight: 600;">
                    <i class="fa-solid fa-certificate"></i> Termasuk Box Beludru & Gilded Edges
                  </div>
                </div>

                <div style="margin-top: 14px;">
                  <div class="product-price-row">
                    <span class="price-current" style="font-size: 1.25rem;">{{ $book->formatted_price }}</span>
                    @if($book->original_price)
                      <span class="price-original" style="font-size: 0.85rem;">{{ $book->formatted_original_price }}</span>
                    @endif
                  </div>
                  <div class="card-actions" style="margin-top: 10px;">
                    <a href="{{ route('novels.show', $book->slug) }}" class="btn-card btn-card-primary" style="flex: 1; text-align: center; padding: 10px 8px; font-size: 0.78rem;">
                      <i class="fa-solid fa-eye"></i> Detail Edisi Boxset
                    </a>
                    <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $book->id }}">
                      <input type="hidden" name="quantity" value="1">
                      <button type="submit" class="btn-wishlist" title="Beli Boxset Ini">
                        <i class="fa-solid fa-cart-plus"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

  @else
    <!-- =========================================================================
         FILTERED / SEARCH VIEW (When User Selects a Filter Tab or Searches)
         ========================================================================= -->
    <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
      <h3 style="font-family: var(--font-serif); font-size: 1.35rem; color: var(--ocean-navy); margin: 0;">
        Hasil Pencarian / Filter: <span style="color: var(--champagne-gold);">{{ $novels->total() }} Produk Ditemukan</span>
      </h3>
      <a href="{{ route('novels.index') }}" class="btn btn-outline-gold" style="padding: 6px 14px; font-size: 0.78rem;">
        <i class="fa-solid fa-layer-group"></i> Kembali ke Tampilan Pengelompokan Seri
      </a>
    </div>

    @if($novels->count() > 0)
      <div class="series-grid">
        @foreach($novels as $novel)
          <div class="product-card" style="border: 1px solid var(--soft-beige); display: flex; flex-direction: column; justify-content: space-between;">
            <div class="card-image-wrap">
              <img src="{{ asset($novel->cover_image) }}" alt="Cover {{ $novel->title }}">
              <span class="badge-series">{{ $novel->series_number ?? $novel->subtitle }}</span>
              @if($novel->is_preorder)
                <span class="badge-preorder">PRE-ORDER</span>
              @endif
            </div>
            <div class="card-details" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
              <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                  <span class="product-series" style="font-size: 0.72rem; color: var(--champagne-gold); font-weight: 700;">
                    {{ $novel->series_name }}
                  </span>
                  @if($novel->category === 'ebook')
                    <span style="background: #EFF6FF; color: #1E40AF; padding: 2px 6px; border-radius: 3px; font-size: 0.68rem; font-weight: 700;">
                      <i class="fa-solid fa-tablet-screen-button"></i> E-Book
                    </span>
                  @else
                    <span style="background: #ECFDF5; color: #065F46; padding: 2px 6px; border-radius: 3px; font-size: 0.68rem; font-weight: 700;">
                      <i class="fa-solid fa-book-open"></i> Cetak Fisik
                    </span>
                  @endif
                </div>
                <h3 class="product-title" style="font-size: 1.05rem;">{{ $novel->title }}</h3>
                <span class="product-author" style="font-size: 0.75rem;">Oleh {{ $novel->author }}</span>
              </div>

              <div style="margin-top: 14px;">
                <div class="product-price-row">
                  <span class="price-current">{{ $novel->formatted_price }}</span>
                  @if($novel->original_price)
                    <span class="price-original">{{ $novel->formatted_original_price }}</span>
                  @endif
                </div>
                <div class="card-actions" style="margin-top: 10px;">
                  <a href="{{ route('novels.show', $novel->slug) }}" class="btn-card btn-card-primary" style="flex: 1; text-align: center; font-size: 0.78rem;">
                    Detail & Format
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
        <p style="color: var(--text-muted); margin-top: 6px;">Silakan coba kata kunci lain atau pilih seri yang berbeda.</p>
        <a href="{{ route('novels.index') }}" class="btn btn-gold" style="margin-top: 20px;">Lihat Semua Koleksi</a>
      </div>
    @endif
  @endif
</div>
@endsection
