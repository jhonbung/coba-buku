@extends('layouts.app')

@section('title', 'BIANCA VEANA — Official Author & Bookstore')

@section('content')
<!-- ==========================================================================
     HERO BANNER SECTION
     ========================================================================== -->
<!-- ==========================================================================
     HERO BANNER SLIDESHOW (CINEMATIC LUXURY SLIDER)
     ========================================================================== -->
<section class="hero-slider-section" id="hero-slider" aria-label="Bianca Veana Featured Showcase">
  <div class="hero-slides-wrapper">

    <!-- Slide 1: Official Universe & Notonegoro Chronicles -->
    <div class="hero-slide active" data-index="0">
      <div class="hero-slide-bg" style="background-image: url('{{ asset('images/hero-slide-1.jpg') }}');"></div>
      <div class="hero-slide-overlay"></div>
      <div class="container hero-slide-inner">
        <div class="hero-content">
          <div class="hero-badge" style="display: inline-flex; align-items: center; gap: 8px;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 18px; width: auto; object-fit: contain;"> OFFICIAL AUTHOR WEBSITE & BOOKSTORE
          </div>
          <h1 class="hero-title">
            WELCOME TO THE UNIVERSE OF <span class="gold-gradient-text">BIANCA VEANA</span>
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
          <div class="hero-micro-meta">
            <span><i class="fa-solid fa-feather-pointed"></i> Signature Series</span>
            <span class="meta-dot">•</span>
            <span><i class="fa-solid fa-gem"></i> Royal Collector's Edition</span>
            <span class="meta-dot">•</span>
            <span><i class="fa-solid fa-shield-halved"></i> 100% Original Book</span>
          </div>
        </div>

        <div class="hero-artwork-preview">
          <div class="hero-glass-card">
            <div class="glass-card-image">
              <img src="{{ asset('images/hero-slide-1.jpg') }}" alt="Bianca Veana Universe Showcase">
            </div>
            <div class="glass-card-caption">
              <div class="glass-tag">ROYAL MASTERPIECE</div>
              <div class="glass-title">The Notonegoro Dynasty</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide 2: Kastil Senja & Takdir Mahkota -->
    <div class="hero-slide" data-index="1">
      <div class="hero-slide-bg" style="background-image: url('{{ asset('images/hero-slide-2.jpg') }}');"></div>
      <div class="hero-slide-overlay"></div>
      <div class="container hero-slide-inner">
        <div class="hero-content">
          <div class="hero-badge">
            <i class="fa-solid fa-wand-magic-sparkles"></i> FAIRY TALE & ROYALTY SERIES
          </div>
          <h1 class="hero-title">
            KASTIL SENJA & <span class="gold-gradient-text">TAKDIR MAHKOTA</span>
          </h1>
          <p class="hero-tagline">
            Di balik megahnya dinding istana dan air terjun keabadian, tersimpan rahasia takdir cinta sang putri. Rasakan keajaiban kisah fantasi kerajaan paling memikat hati.
          </p>
          <div class="hero-cta-group">
            <a href="{{ route('novels.index') }}" class="btn btn-gold">
              <i class="fa-solid fa-book-sparkles"></i> BACA KISAH LENGKAP
            </a>
            <a href="{{ route('ebooks.index') }}" class="btn btn-outline-gold">
              <i class="fa-solid fa-download"></i> DIGITAL E-BOOK EDITION
            </a>
          </div>
          <div class="hero-micro-meta">
            <span><i class="fa-solid fa-star"></i> High Fantasy Romance</span>
            <span class="meta-dot">•</span>
            <span><i class="fa-solid fa-bolt"></i> Instant Digital Delivery</span>
            <span class="meta-dot">•</span>
            <span><i class="fa-solid fa-sparkles"></i> Special Artbook Inside</span>
          </div>
        </div>

        <div class="hero-artwork-preview">
          <div class="hero-glass-card">
            <div class="glass-card-image">
              <img src="{{ asset('images/hero-slide-2.jpg') }}" alt="Kastil Senja & Takdir Mahkota">
            </div>
            <div class="glass-card-caption">
              <div class="glass-tag">FAIRYTALE COLLECTION</div>
              <div class="glass-title">Senja di Tepi Danau Takdir</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide 3: Hangat Cinta & Lembaran Kisah -->
    <div class="hero-slide" data-index="2">
      <div class="hero-slide-bg" style="background-image: url('{{ asset('images/hero-slide-3.jpg') }}');"></div>
      <div class="hero-slide-overlay"></div>
      <div class="container hero-slide-inner">
        <div class="hero-content">
          <div class="hero-badge">
            <i class="fa-solid fa-heart"></i> INTIMATE ROMANCE & BEST SELLER
          </div>
          <h1 class="hero-title">
            HANGAT CINTA & <span class="gold-gradient-text">LEMBARAN KISAH</span>
          </h1>
          <p class="hero-tagline">
            Setiap helaan napas dan tatapan mata terukir dalam untaian kata memikat. Nikmati momen membaca yang menyentuh relung hati terdalam bersama edisi eksklusif bertandatangan.
          </p>
          <div class="hero-cta-group">
            <a href="{{ route('novels.index') }}" class="btn btn-gold">
              <i class="fa-solid fa-bag-shopping"></i> BELI BUKU CETAK
            </a>
            <a href="{{ route('merchandise.index') }}" class="btn btn-outline-gold">
              <i class="fa-solid fa-gem"></i> EKSKLUSIF MERCHANDISE
            </a>
          </div>
          <div class="hero-micro-meta">
            <span><i class="fa-solid fa-pen-fancy"></i> Bertandatangan Asli</span>
            <span class="meta-dot">•</span>
            <span><i class="fa-solid fa-box"></i> Hard Box & Bubble Wrap</span>
            <span class="meta-dot">•</span>
            <span><i class="fa-solid fa-truck"></i> Pengiriman Seluruh Indonesia</span>
          </div>
        </div>

        <div class="hero-artwork-preview">
          <div class="hero-glass-card">
            <div class="glass-card-image">
              <img src="{{ asset('images/hero-slide-3.jpg') }}" alt="Hangat Cinta & Lembaran Kisah">
            </div>
            <div class="glass-card-caption">
              <div class="glass-tag">ROMANCE BEST SELLER</div>
              <div class="glass-title">Edisi Lembaran Terindah</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Smooth Navigation Arrows -->
  <button type="button" class="hero-nav-btn prev" id="hero-prev-btn" aria-label="Slide Sebelumnya">
    <i class="fa-solid fa-chevron-left"></i>
  </button>
  <button type="button" class="hero-nav-btn next" id="hero-next-btn" aria-label="Slide Berikutnya">
    <i class="fa-solid fa-chevron-right"></i>
  </button>

  <!-- Minimalist Modern Dots Indicator (Tanpa Tulisan Teks) -->
  <div class="hero-minimal-dots" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 25; display: flex; align-items: center; gap: 8px;">
    @foreach([0, 1, 2] as $idx)
      <button type="button" class="hero-dot-btn {{ $idx === 0 ? 'active' : '' }}" data-target="{{ $idx }}" aria-label="Slide {{ $idx + 1 }}" style="width: {{ $idx === 0 ? '36px' : '14px' }}; height: 5px; border-radius: 4px; background: {{ $idx === 0 ? 'var(--champagne-gold, #C6A16B)' : 'rgba(255, 255, 255, 0.35)' }}; border: none; cursor: pointer; transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); padding: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"></button>
    @endforeach
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
     CINEMATIC TEASER TRAILER SECTION
     ========================================================================== -->
<section class="teaser-section" id="teaser-trailer">
  <div class="container teaser-wrapper">
    <div class="teaser-header">
      <span class="section-tag" id="teaser-tagline">
        <i class="fa-solid fa-film"></i> {{ $teaserVideo->tagline ?? 'OFFICIAL CINEMATIC TRAILER' }}
      </span>
      <h2 class="section-title" id="teaser-title">{{ $teaserVideo->title ?? 'EKSPLORASI SEMESTA BIANCA VEANA' }}</h2>
      <p class="section-subtitle" id="teaser-subtitle">
        {{ $teaserVideo->subtitle ?? 'Saksikan cuplikan kisah kemegahan, intrik keluarga, dan cinta abadi dalam semesta The Seven Notonegoro Series.' }}
      </p>
    </div>

    @if(isset($teaserVideos) && $teaserVideos->count() > 1)
      <!-- Playlist Tabs Bar -->
      <div style="display: flex; gap: 12px; margin-bottom: 24px; overflow-x: auto; padding-bottom: 6px; justify-content: center; flex-wrap: wrap;">
        @foreach($teaserVideos as $idx => $tv)
          <button type="button" class="teaser-tab-btn {{ $idx === 0 ? 'active' : '' }}" onclick="switchTeaserVideo({{ $idx }})" id="teaser-tab-{{ $idx }}" style="background: {{ $idx === 0 ? 'rgba(198, 161, 107, 0.15)' : 'rgba(255, 255, 255, 0.05)' }}; border: 1px solid {{ $idx === 0 ? 'var(--champagne-gold)' : 'rgba(255, 255, 255, 0.15)' }}; border-radius: 8px; padding: 10px 18px; color: {{ $idx === 0 ? 'var(--champagne-gold)' : '#CBD5E1' }}; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.3s ease;">
            <div style="width: 26px; height: 26px; border-radius: 50%; background: {{ $idx === 0 ? 'var(--champagne-gold)' : 'rgba(255, 255, 255, 0.12)' }}; color: {{ $idx === 0 ? '#0B1526' : '#FFFFFF' }}; display: flex; align-items: center; justify-content: center; font-size: 0.72rem;">
              <i class="fa-solid fa-play"></i>
            </div>
            <div style="text-align: left;">
              <div style="font-size: 0.68rem; letter-spacing: 1.5px; text-transform: uppercase; opacity: 0.75;">{{ $tv->video_type === 'youtube' ? 'YouTube Trailer' : 'Official Video' }}</div>
              <div style="font-size: 0.86rem; font-weight: 700; max-width: 240px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $tv->title }}</div>
            </div>
          </button>
        @endforeach
      </div>
    @endif

    <div class="teaser-video-card" id="teaser-player-container">
      @if(isset($teaserVideo) && $teaserVideo->video_type === 'youtube' && $teaserVideo->youtube_embed_url)
        <iframe id="teaserIframe" src="{{ $teaserVideo->youtube_embed_url }}" title="{{ $teaserVideo->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="width: 100%; height: 100%; min-height: 480px; border: none; display: block;"></iframe>
      @elseif(isset($teaserVideo) && in_array($teaserVideo->video_type, ['file', 'url']) && $teaserVideo->video_path)
        <video id="teaserVideo" controls playsinline preload="metadata" poster="{{ asset($teaserVideo->thumbnail_path ?: 'images/hero-slide-1.jpg') }}" style="width: 100%; height: 100%; object-fit: contain; background: #000;">
          <source src="{{ asset($teaserVideo->video_path) }}" type="video/mp4">
          Browser Anda tidak mendukung pemutaran video langsung.
        </video>
      @elseif(file_exists(public_path('videos/teaser.mp4')))
        <video id="teaserVideo" controls playsinline preload="metadata" poster="{{ asset('images/hero-slide-1.jpg') }}" style="width: 100%; height: 100%; object-fit: contain; background: #000;">
          <source src="{{ asset('videos/teaser.mp4') }}" type="video/mp4">
          Browser Anda tidak mendukung pemutaran video langsung.
        </video>
      @else
        <div style="width: 100%; height: 100%; min-height: 400px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: radial-gradient(circle, #1a2f4d 0%, #0A192F 100%); text-align: center; padding: 30px;">
          <div style="width: 72px; height: 72px; border-radius: 50%; background: rgba(198, 161, 107, 0.2); border: 2px solid var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: var(--champagne-gold); margin-bottom: 16px; box-shadow: 0 0 24px rgba(198, 161, 107, 0.35);">
            <i class="fa-solid fa-play" style="margin-left: 4px;"></i>
          </div>
          <h3 style="font-family: var(--font-serif); color: var(--ivory); font-size: 1.4rem; margin-bottom: 8px;">
            BIANCA VEANA OFFICIAL TEASER
          </h3>
          <p style="color: #A0AEC0; font-size: 0.9rem; max-width: 480px; margin-bottom: 16px;">
            Video teaser belum diunggah. Anda dapat menambah atau mengupload video langsung melalui menu <strong><a href="{{ route('admin.videos') }}" style="color: var(--champagne-gold); text-decoration: underline;">Panel Admin > Video Teaser</a></strong>.
          </p>
        </div>
      @endif
    </div>

    <div class="teaser-badge-bar">
      <div class="teaser-features">
        <span id="teaser-badge-1"><i class="fa-solid fa-circle-check"></i> {{ $teaserVideo->badge_1 ?? '1080p Full HD' }}</span>
        <span id="teaser-badge-2"><i class="fa-solid fa-music"></i> {{ $teaserVideo->badge_2 ?? 'Original Soundtrack' }}</span>
        <span id="teaser-badge-3"><i class="fa-solid fa-crown"></i> {{ $teaserVideo->badge_3 ?? 'Official Universe' }}</span>
      </div>
      <div>
        <a id="teaser-cta-btn" href="{{ $teaserVideo->cta_link ?? '#notonegoro-series' }}" class="btn btn-gold" style="padding: 10px 22px; font-size: 0.82rem;">
          <i class="fa-solid fa-book"></i> <span id="teaser-cta-text">{{ $teaserVideo->cta_text ?? 'Beli Seri Novel' }}</span>
        </a>
      </div>
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
  // ==========================================================================
  // HERO BANNER CINEMATIC SLIDESHOW ENGINE
  // ==========================================================================
  (function initHeroSlider() {
    const slider = document.getElementById('hero-slider');
    if (!slider) return;

    const slides = slider.querySelectorAll('.hero-slide');
    const dotBtns = slider.querySelectorAll('.hero-dot-btn');
    const prevBtn = document.getElementById('hero-prev-btn');
    const nextBtn = document.getElementById('hero-next-btn');
    const totalSlides = slides.length;
    
    if (totalSlides === 0) return;

    let currentSlide = 0;
    let autoplayTimer = null;
    const SLIDE_DURATION = 4500; // 4.5 detik per slide secara otomatis

    function updateDots(index) {
      dotBtns.forEach((dot, i) => {
        if (i === index) {
          dot.classList.add('active');
          dot.style.width = '36px';
          dot.style.background = 'var(--champagne-gold, #C6A16B)';
          dot.style.opacity = '1';
        } else {
          dot.classList.remove('active');
          dot.style.width = '14px';
          dot.style.background = 'rgba(255, 255, 255, 0.35)';
          dot.style.opacity = '0.7';
        }
      });
    }

    function goToSlide(targetIndex) {
      if (targetIndex === currentSlide && slides[currentSlide].classList.contains('active')) {
        return;
      }

      // Deactivate current slide
      slides.forEach((s) => s.classList.remove('active'));

      // Normalize index
      currentSlide = (targetIndex + totalSlides) % totalSlides;

      // Activate new slide & dot
      slides[currentSlide].classList.add('active');
      updateDots(currentSlide);

      // Reset autoplay timer
      resetAutoplay();
    }

    function nextSlide() {
      goToSlide(currentSlide + 1);
    }

    function prevSlide() {
      goToSlide(currentSlide - 1);
    }

    function startAutoplay() {
      stopAutoplay();
      autoplayTimer = setInterval(() => {
        nextSlide();
      }, SLIDE_DURATION);
    }

    function stopAutoplay() {
      if (autoplayTimer) {
        clearInterval(autoplayTimer);
        autoplayTimer = null;
      }
    }

    function resetAutoplay() {
      stopAutoplay();
      startAutoplay();
    }

    // Button event listeners
    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        nextSlide();
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        prevSlide();
      });
    }

    // Dot click events (Interaktif tanpa teks)
    dotBtns.forEach((dot) => {
      dot.addEventListener('click', function(e) {
        e.preventDefault();
        const target = parseInt(this.getAttribute('data-target'), 10);
        if (!isNaN(target)) {
          goToSlide(target);
        }
      });
    });

    // Keyboard navigation
    window.addEventListener('keydown', (e) => {
      const rect = slider.getBoundingClientRect();
      const inView = rect.top < window.innerHeight && rect.bottom > 0;
      if (!inView) return;

      if (e.key === 'ArrowRight') {
        nextSlide();
      } else if (e.key === 'ArrowLeft') {
        prevSlide();
      }
    });

    // Touch swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    slider.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    slider.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      const swipeDistance = touchEndX - touchStartX;
      if (Math.abs(swipeDistance) > 45) {
        if (swipeDistance < 0) {
          nextSlide(); // Swiped left -> next
        } else {
          prevSlide(); // Swiped right -> prev
        }
      }
    }, { passive: true });

    // Mulai autoplay saat pertama kali halaman terbuka
    updateDots(0);
    startAutoplay();
  })();

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

  // Multi-Video Teaser Switcher
  @if(isset($teaserVideos) && $teaserVideos->count() > 1)
    @php
      $videoMapData = $teaserVideos->map(function($v) {
        return [
          'id' => $v->id,
          'title' => $v->title,
          'tagline' => $v->tagline ?: 'OFFICIAL CINEMATIC TRAILER',
          'subtitle' => $v->subtitle,
          'type' => $v->video_type,
          'video_path' => $v->video_path ? asset($v->video_path) : '',
          'youtube_url' => $v->youtube_embed_url,
          'poster' => asset($v->thumbnail_path ?: 'images/hero-slide-1.jpg'),
          'badge_1' => $v->badge_1 ?: '1080p Full HD',
          'badge_2' => $v->badge_2 ?: 'Original Soundtrack',
          'badge_3' => $v->badge_3 ?: 'Official Universe',
          'cta_text' => $v->cta_text ?: 'Beli Seri Novel',
          'cta_link' => $v->cta_link ?: '#notonegoro-series',
        ];
      });
    @endphp
    const teaserVideoList = @json($videoMapData);

    function switchTeaserVideo(index) {
      const vid = teaserVideoList[index];
      if (!vid) return;

      // Update text
      document.getElementById('teaser-tagline').innerHTML = '<i class="fa-solid fa-film"></i> ' + vid.tagline;
      document.getElementById('teaser-title').innerText = vid.title;
      document.getElementById('teaser-subtitle').innerText = vid.subtitle || '';
      document.getElementById('teaser-badge-1').innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + vid.badge_1;
      document.getElementById('teaser-badge-2').innerHTML = '<i class="fa-solid fa-music"></i> ' + vid.badge_2;
      document.getElementById('teaser-badge-3').innerHTML = '<i class="fa-solid fa-crown"></i> ' + vid.badge_3;
      document.getElementById('teaser-cta-text').innerText = vid.cta_text;
      document.getElementById('teaser-cta-btn').setAttribute('href', vid.cta_link);

      // Update player container
      const container = document.getElementById('teaser-player-container');
      if (vid.type === 'youtube' && vid.youtube_url) {
        container.innerHTML = '<iframe src="' + vid.youtube_url + '" title="' + vid.title + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="width: 100%; height: 100%; min-height: 480px; border: none; display: block;"></iframe>';
      } else if (vid.video_path) {
        container.innerHTML = '<video controls autoplay playsinline preload="auto" poster="' + vid.poster + '" style="width: 100%; height: 100%; object-fit: contain; background: #000;"><source src="' + vid.video_path + '" type="video/mp4"></video>';
      }

      // Update active button
      document.querySelectorAll('.teaser-tab-btn').forEach((btn, i) => {
        if (i === index) {
          btn.style.background = 'rgba(198, 161, 107, 0.15)';
          btn.style.borderColor = 'var(--champagne-gold)';
          btn.style.color = 'var(--champagne-gold)';
          btn.querySelector('div').style.background = 'var(--champagne-gold)';
          btn.querySelector('div').style.color = '#0B1526';
        } else {
          btn.style.background = 'rgba(255, 255, 255, 0.05)';
          btn.style.borderColor = 'rgba(255, 255, 255, 0.15)';
          btn.style.color = '#CBD5E1';
          btn.querySelector('div').style.background = 'rgba(255, 255, 255, 0.12)';
          btn.querySelector('div').style.color = '#FFFFFF';
        }
      });
    }
  @endif
</script>
@endpush
