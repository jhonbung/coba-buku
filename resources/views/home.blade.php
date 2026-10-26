@extends('layouts.app')

@section('title', 'BIANCA VEANA — Official Author & Bookstore')

@section('content')
<!-- ==========================================================================
     HERO BANNER SECTION
     ========================================================================== -->
<section class="hero-section">
  <div class="hero-ornament-bg"></div>
  <div class="container hero-grid">
    <div class="hero-content">
      <div class="hero-subtitle">
        <i class="fa-solid fa-crown"></i> OFFICIAL AUTHOR WEBSITE & BOOKSTORE
      </div>
      <h1 class="hero-title">
        WELCOME TO THE UNIVERSE OF <span>BIANCA VEANA</span>
      </h1>
      <p class="hero-tagline">
        Stories that stay with you long after the final page. Masuki semesta keluarga Notonegoro, di mana cinta, takdir, dan rahasia darah biru berpadu dalam keanggunan abadi.
      </p>
      <div class="hero-cta-group">
        <a href="#notonegoro-series" class="btn btn-gold">
          <i class="fa-solid fa-compass"></i> EXPLORE THE UNIVERSE
        </a>
        <a href="{{ route('novels.index') }}" class="btn btn-outline-gold">
          <i class="fa-solid fa-book-open"></i> BROWSE NOVELS
        </a>
      </div>
    </div>

    <div class="hero-artwork-card">
      <div class="hero-artwork-frame">
        <img src="{{ asset('images/fate.svg') }}" alt="Artwork Pasangan Bianca Veana Universe">
        <div class="hero-floating-badge">
          <i class="fa-solid fa-feather-pointed" style="margin-right: 6px;"></i> ROYAL EDITION
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     BENEFIT BAR
     ========================================================================== -->
<section class="benefit-bar">
  <div class="container benefit-grid">
    <div class="benefit-item">
      <div class="benefit-icon">
        <i class="fa-solid fa-book-bookmark"></i>
      </div>
      <div>
        <div class="benefit-title">Original Books</div>
        <div class="benefit-desc">Karya asli bertandatangan & edisi resmi Bianca Veana.</div>
      </div>
    </div>

    <div class="benefit-item">
      <div class="benefit-icon">
        <i class="fa-solid fa-box-archive"></i>
      </div>
      <div>
        <div class="benefit-title">Secure Packaging</div>
        <div class="benefit-desc">Bubble wrap ekstra tebal & box khusus koleksi Anda.</div>
      </div>
    </div>

    <div class="benefit-item">
      <div class="benefit-icon">
        <i class="fa-solid fa-truck-fast"></i>
      </div>
      <div>
        <div class="benefit-title">Shipping Information</div>
        <div class="benefit-desc">Nomor resi real-time & kirim ke seluruh Indonesia.</div>
      </div>
    </div>

    <div class="benefit-item">
      <div class="benefit-icon">
        <i class="fa-solid fa-gem"></i>
      </div>
      <div>
        <div class="benefit-title">Exclusive Merchandise</div>
        <div class="benefit-desc">Aksesoris resmi terbatas bertema novel favorit Anda.</div>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     THE SEVEN NOTONEGORO SERIES
     ========================================================================== -->
<section class="section" id="notonegoro-series">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">THE MASTERPIECE CHRONICLES</span>
      <h2 class="section-title">THE SEVEN NOTONEGORO SERIES</h2>
      <p class="section-subtitle">
        Silsilah kemegahan, kehormatan, dan cinta sejati tujuh keturunan trah Notonegoro.
      </p>
      <div class="section-divider"></div>
    </div>

    <div class="series-grid">
      @foreach($notonegoroSeries as $book)
        <div class="product-card">
          <div class="card-image-wrap">
            <img src="{{ asset($book->cover_image) }}" alt="Cover {{ $book->title }}">
            <span class="badge-series">{{ $book->subtitle }}</span>
            @if($book->is_preorder)
              <span class="badge-preorder">PRE-ORDER</span>
            @endif
          </div>
          <div class="card-details">
            <span class="product-series">{{ $book->series_name }}</span>
            <h3 class="product-title">{{ $book->title }}</h3>
            <span class="product-author">Oleh {{ $book->author }}</span>
            <div class="product-price-row">
              <span class="price-current">{{ $book->formatted_price }}</span>
              @if($book->original_price)
                <span class="price-original">{{ $book->formatted_original_price }}</span>
              @endif
            </div>
            <div class="card-actions">
              <a href="{{ route('novels.show', $book->slug) }}" class="btn-card btn-card-primary">
                View Book
              </a>
              <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $book->id }}">
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
</section>

<!-- ==========================================================================
     STANDALONE NOVEL HIGHLIGHT (Beauty in Madness)
     ========================================================================== -->
@if($standaloneNovel)
<section class="standalone-section">
  <div class="container standalone-grid">
    <div class="standalone-card-img">
      <img src="{{ asset($standaloneNovel->cover_image) }}" alt="{{ $standaloneNovel->title }}">
    </div>
    <div class="standalone-content">
      <span class="section-tag">A STANDALONE MASTERPIECE</span>
      <h2 class="standalone-title">{{ $standaloneNovel->title }}</h2>
      <p class="standalone-synopsis">
        {{ $standaloneNovel->synopsis }}
      </p>
      <div style="display: flex; align-items: baseline; gap: 16px; margin-bottom: 30px;">
        <span style="font-size: 1.8rem; font-weight: 700; color: var(--champagne-gold);">
          {{ $standaloneNovel->formatted_price }}
        </span>
        @if($standaloneNovel->original_price)
          <span style="font-size: 1.1rem; color: #9AA5B8; text-decoration: line-through;">
            {{ $standaloneNovel->formatted_original_price }}
          </span>
        @endif
      </div>
      <div style="display: flex; gap: 16px;">
        <a href="{{ route('novels.show', $standaloneNovel->slug) }}" class="btn btn-gold">
          <i class="fa-solid fa-eye"></i> DETAIL NOVEL
        </a>
        <form action="{{ route('cart.add') }}" method="POST">
          @csrf
          <input type="hidden" name="product_id" value="{{ $standaloneNovel->id }}">
          <input type="hidden" name="quantity" value="1">
          <button type="submit" class="btn btn-outline-gold">
            <i class="fa-solid fa-bag-shopping"></i> BELI SEKARANG
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
@endif

<!-- ==========================================================================
     3 KATEGORI PRODUK
     ========================================================================== -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">DISCOVER THE COLLECTIONS</span>
      <h2 class="section-title">KATEGORI PRODUK</h2>
      <div class="section-divider"></div>
    </div>

    <div class="category-grid">
      <!-- 1. PRINTED NOVELS -->
      <a href="{{ route('novels.index') }}" class="category-banner" style="background: linear-gradient(135deg, #172B49 0%, #203A5E 100%);">
        <div class="category-content">
          <div class="category-number">01.</div>
          <h3 class="category-name">PRINTED NOVELS</h3>
          <p class="category-desc">Physical books for your collection with luxury finishing.</p>
          <span class="category-arrow">Jelajahi Novel Cetak <i class="fa-solid fa-arrow-right"></i></span>
        </div>
      </a>

      <!-- 2. E-BOOKS -->
      <a href="{{ route('ebooks.index') }}" class="category-banner" style="background: linear-gradient(135deg, #1E2D44 0%, #2A4870 100%);">
        <div class="category-content">
          <div class="category-number">02.</div>
          <h3 class="category-name">E-BOOKS</h3>
          <p class="category-desc">Read anytime, anywhere. Instant access via email & Google Drive.</p>
          <span class="category-arrow">Akses E-Book Digital <i class="fa-solid fa-arrow-right"></i></span>
        </div>
      </a>

      <!-- 3. MERCHANDISE -->
      <a href="{{ route('merchandise.index') }}" class="category-banner" style="background: linear-gradient(135deg, #142033 0%, #30263B 100%);">
        <div class="category-content">
          <div class="category-number">03.</div>
          <h3 class="category-name">MERCHANDISE</h3>
          <p class="category-desc">Exclusive items for true readers of Bianca Veana Universe.</p>
          <span class="category-arrow">Koleksi Merchandise <i class="fa-solid fa-arrow-right"></i></span>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- ==========================================================================
     BRAND QUOTES CAROUSEL (Auto-Sliding)
     ========================================================================== -->
<section class="quotes-section">
  <div class="container">
    <div class="section-header" style="margin-bottom: 30px;">
      <span class="section-tag">WORDS FROM THE CHARACTERS</span>
      <h2 class="section-title">KUTIPAN KARYA BIANCA VEANA</h2>
      <div class="section-divider"></div>
    </div>

    <div class="quotes-carousel-wrapper">
      @foreach($quotes as $index => $q)
        <div class="quote-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
          <div class="quote-mark">“</div>
          <p class="quote-text">
            {{ $q->quote }}
          </p>
          <div class="quote-author">{{ $q->character_name }}</div>
          <div class="quote-book">{{ $q->book_title }} — Bianca Veana</div>
        </div>
      @endforeach

      <div class="quotes-indicators">
        @foreach($quotes as $index => $q)
          <button class="quote-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToQuote({{ $index }})" aria-label="Quote {{ $index + 1 }}"></button>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     NEW ARRIVALS / PRE-ORDER HIGHLIGHT
     ========================================================================== -->
<section class="section" style="background: #FFFFFF;">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">EXCLUSIVE PRE-ORDER & ARRIVALS</span>
      <h2 class="section-title">PELUNCURAN NOVEL FATE</h2>
      <p class="section-subtitle">
        Babak baru dalam semesta Bianca Veana. Pre-Order sekarang untuk mendapatkan bonus photocard hologram & pembatas buku logam royal swan.
      </p>
      <div class="section-divider"></div>
    </div>

    <div class="series-grid">
      @foreach($newArrivals as $item)
        <div class="product-card">
          <div class="card-image-wrap">
            <img src="{{ asset($item->cover_image) }}" alt="Cover {{ $item->title }}">
            <span class="badge-series">{{ $item->subtitle ?? $item->series_name }}</span>
            @if($item->is_preorder)
              <span class="badge-preorder">PRE-ORDER</span>
            @endif
          </div>
          <div class="card-details">
            <span class="product-series">{{ $item->series_name }}</span>
            <h3 class="product-title">{{ $item->title }}</h3>
            <span class="product-author">Oleh {{ $item->author }}</span>
            <div class="product-price-row">
              <span class="price-current">{{ $item->formatted_price }}</span>
              @if($item->original_price)
                <span class="price-original">{{ $item->formatted_original_price }}</span>
              @endif
            </div>
            <div class="card-actions">
              <a href="{{ $item->category === 'novel' ? route('novels.show', $item->slug) : ($item->category === 'ebook' ? route('ebooks.index') : route('merchandise.show', $item->slug)) }}" class="btn-card btn-card-primary">
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
</section>
@endsection

@push('scripts')
<script>
  // Auto-sliding Brand Quotes Carousel
  let currentQuote = 0;
  const quoteSlides = document.querySelectorAll('.quote-slide');
  const quoteDots = document.querySelectorAll('.quote-dot');

  function showQuote(index) {
    quoteSlides.forEach((slide, i) => {
      slide.classList.toggle('active', i === index);
    });
    quoteDots.forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });
    currentQuote = index;
  }

  function goToQuote(index) {
    showQuote(index);
  }

  setInterval(() => {
    let next = (currentQuote + 1) % quoteSlides.length;
    showQuote(next);
  }, 6000);
</script>
@endpush
