<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'BIANCA VEANA — Official Author & Luxury Bookstore')</title>
  <meta name="description" content="Website resmi Bianca Veana Bookstore. Pusat penjualan novel cetak, e-book eksklusif, dan merchandise resmi The Seven Notonegoro Series.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @stack('styles')
</head>
<body>

  <!-- ANNOUNCEMENT & REVIEW TICKER BAR -->
  <div class="announcement-bar">
    <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
      <div style="flex-shrink: 0; font-weight: 700; color: var(--champagne-gold); margin-right: 20px;">
        <i class="fa-solid fa-crown"></i> BIANCA VEANA UNIVERSE
      </div>
      <div class="ticker-wrap">
        <div class="ticker">
          <span class="ticker-item"><i class="fa-solid fa-star" style="color: #C6A16B;"></i> PRE-ORDER NOVEL FATE TELAH DIBUKA! AMANKAN EDISI SPESIAL ANDA</span>
          <span class="ticker-item"><i class="fa-solid fa-star" style="color: #C6A16B;"></i> "Novel Mantra luar biasa menguras emosi! Sadewa benar-benar standar pria fiksi tertinggi." — Alika P. (5★)</span>
          <span class="ticker-item"><i class="fa-solid fa-star" style="color: #C6A16B;"></i> "Packaging sangat mewah, aman berlipat bubble wrap tebal." — Vania S. (5★)</span>
          <span class="ticker-item"><i class="fa-solid fa-star" style="color: #C6A16B;"></i> PENGIRIMAN DIGITAL E-BOOK OTOMATIS AKTIF 24/7 LANGSUNG KE EMAIL</span>
        </div>
      </div>
      <div style="flex-shrink: 0; margin-left: 20px; font-size: 0.75rem;">
        <span style="color: var(--champagne-gold);"><i class="fa-solid fa-gem"></i> Butik Buku Resmi</span>
      </div>
    </div>
  </div>

  <!-- SITE HEADER & NAVIGATION -->
  <header class="site-header">
    <div class="container header-inner">
      <nav>
        <ul class="nav-menu">
          <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
          <li><a href="{{ route('novels.index') }}" class="nav-link {{ request()->routeIs('novels.*') ? 'active' : '' }}">Novels</a></li>
          <li><a href="{{ route('ebooks.index') }}" class="nav-link {{ request()->routeIs('ebooks.*') ? 'active' : '' }}">E-Books</a></li>
          <li><a href="{{ route('merchandise.index') }}" class="nav-link {{ request()->routeIs('merchandise.*') ? 'active' : '' }}">Merchandise</a></li>
          <li><a href="{{ route('author.index') }}" class="nav-link {{ request()->routeIs('author.*') ? 'active' : '' }}">About the Author</a></li>
        </ul>
      </nav>

      <div class="brand-logo">
        <a href="{{ route('home') }}">
          <h1 class="brand-name">BIANCA VEANA</h1>
          <div class="brand-tagline">OFFICIAL BOOKSTORE</div>
        </a>
      </div>

      <div class="header-actions">
        <a href="{{ route('novels.index') }}" class="icon-btn" title="Cari Buku" id="nav-search-btn">
          <i class="fa-solid fa-magnifying-glass"></i>
        </a>
        <a href="{{ route('novels.index') }}" class="icon-btn" title="Wishlist" id="nav-wishlist-btn">
          <i class="fa-regular fa-heart"></i>
        </a>
        <a href="{{ route('cart.index') }}" class="icon-btn" title="Keranjang Belanja" id="nav-cart-btn">
          <i class="fa-solid fa-bag-shopping"></i>
          @php
            $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
          @endphp
          @if($cartCount > 0)
            <span class="cart-badge">{{ $cartCount }}</span>
          @endif
        </a>
      </div>
    </div>
  </header>

  <!-- ALERTS / FLASH MESSAGES -->
  @if(session('success'))
    <div style="background: #E8F5E9; border-bottom: 1px solid #A5D6A7; color: #1B5E20; padding: 14px 0; text-align: center; font-size: 0.92rem;">
      <div class="container">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
      </div>
    </div>
  @endif

  @if(session('warning'))
    <div style="background: #FFF8E1; border-bottom: 1px solid #FFE082; color: #F57F17; padding: 14px 0; text-align: center; font-size: 0.92rem;">
      <div class="container">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ session('warning') }}
      </div>
    </div>
  @endif

  <!-- MAIN CONTENT -->
  <main>
    @yield('content')
  </main>

  <!-- SITE FOOTER -->
  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <!-- Col 1: About -->
        <div class="footer-brand">
          <h3 class="brand-name">BIANCA VEANA</h3>
          <div class="brand-tagline" style="color: var(--champagne-gold);">BIANCA VEANA UNIVERSE</div>
          <p class="footer-about-text">
            Bianca Veana is a literary brand that brings stories of love, passion, ambition, and the complexities of the human heart to life. Through compelling characters and interconnected worlds, Bianca Veana creates stories that invite readers to feel deeply, dream freely, and discover a piece of themselves in every chapter.
          </p>
          <div class="social-links">
            <a href="https://instagram.com/Biancaveana" target="_blank" class="social-btn" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://tiktok.com/@Biancaveana" target="_blank" class="social-btn" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
            <a href="https://wa.me/62817752901" target="_blank" class="social-btn" title="WhatsApp Admin"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="mailto:contact@biancaveana.com" class="social-btn" title="Email Kami"><i class="fa-regular fa-envelope"></i></a>
          </div>
        </div>

        <!-- Col 2: Navigation -->
        <div>
          <h4 class="footer-title">Katalog Karya</h4>
          <ul class="footer-links">
            <li><a href="{{ route('novels.index', ['category' => 'notonegoro']) }}"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> The Seven Notonegoro</a></li>
            <li><a href="{{ route('novels.index', ['category' => 'standalone']) }}"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> Standalone Novels</a></li>
            <li><a href="{{ route('novels.index', ['category' => 'limited']) }}"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> Royal Limited Editions</a></li>
            <li><a href="{{ route('ebooks.index') }}"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> E-Books & Bab Digital</a></li>
            <li><a href="{{ route('merchandise.index') }}"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> Official Merchandise</a></li>
          </ul>
        </div>

        <!-- Col 3: Customer Care & Info -->
        <div>
          <h4 class="footer-title">Bantuan & Info</h4>
          <ul class="footer-links">
            <li><a href="{{ route('author.index') }}"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> Profil Penulis</a></li>
            <li><a href="javascript:void(0)" onclick="openModal('modal-shipping')"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> Shipping & Returns</a></li>
            <li><a href="javascript:void(0)" onclick="openModal('modal-terms')"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> Syarat & Ketentuan</a></li>
            <li><a href="javascript:void(0)" onclick="openModal('modal-privacy')"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> Kebijakan Privasi</a></li>
            <li><a href="javascript:void(0)" onclick="openModal('modal-copyright')"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> Hak Cipta & Karya</a></li>
            <li><a href="https://wa.me/62817752901" target="_blank"><i class="fa-solid fa-headset" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> CS: 0817752901</a></li>
          </ul>
        </div>

        <!-- Col 4: Newsletter -->
        <div>
          <h4 class="footer-title">Peluncuran Novel</h4>
          <p style="font-size: 0.85rem; line-height: 1.6; color: #BAC7D7;">
            <strong>FATE — Kisah Baru dari Bianca Veana</strong><br>
            Sebuah kisah baru akan hadir di Bianca Veana Universe ketika cinta, pilihan, dan takdir saling terhubung.
          </p>
          <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form">
            @csrf
            <input type="email" name="email" class="newsletter-input" placeholder="Masukkan alamat email Anda..." required>
            <button type="submit" class="btn btn-gold" style="padding: 12px 18px; font-size: 0.75rem;">GABUNG</button>
          </form>
          <div style="font-size: 0.72rem; color: #8E9BAE; margin-top: 8px;">
            Segera Hadir · Bianca Veana Universe
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <div>
          © 2026 <strong>BIANCA VEANA BOOKSTORE</strong>. All Rights Reserved. Hak Cipta Dilindungi Undang-Undang.
        </div>
        <div class="legal-links">
          <a href="javascript:void(0)" onclick="openModal('modal-terms')">Terms & Conditions</a>
          <a href="javascript:void(0)" onclick="openModal('modal-privacy')">Privacy Policy</a>
          <a href="javascript:void(0)" onclick="openModal('modal-shipping')">Shipping & Returns</a>
          <a href="javascript:void(0)" onclick="openModal('modal-copyright')">Copyright</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- ==========================================================================
       MODALS: LEGALITAS & KEBIJAKAN RESMI
       ========================================================================== -->

  <!-- Modal: Terms & Conditions -->
  <div class="modal-overlay" id="modal-terms">
    <div class="modal-dialog">
      <div class="modal-header">
        <h3 class="modal-title">SYARAT DAN KETENTUAN</h3>
        <button class="modal-close" onclick="closeModal('modal-terms')">&times;</button>
      </div>
      <div class="modal-body">
        <h4>Bianca Veana Universe (Terakhir diperbarui: Oktober 2026)</h4>
        <p>Selamat datang di Bianca Veana Universe, situs web resmi Bianca Veana. Dengan mengakses dan menggunakan situs web ini, Anda dianggap telah membaca, memahami, dan menyetujui Syarat dan Ketentuan berikut.</p>
        <br>
        <h5>1. Penggunaan Situs Web</h5>
        <p>Situs web ini menyediakan informasi mengenai Bianca Veana, karya-karya novelnya, peluncuran buku, proyek, dan konten terkait lainnya. Pengunjung wajib menggunakan situs web ini secara bertanggung jawab.</p>
        <br>
        <h5>2. Kekayaan Intelektual</h5>
        <p>Seluruh novel, cerita, karakter, konten tertulis, ilustrasi, karya seni, logo, desain, dan materi lainnya yang diterbitkan di situs web ini dilindungi oleh hukum kekayaan intelektual yang berlaku. Tidak ada konten yang boleh diperbanyak, didistribusikan, atau diterjemahkan tanpa izin tertulis sebelumnya.</p>
        <br>
        <h5>3. Pembelian dan Merchandise</h5>
        <p>Pelanggan bertanggung jawab untuk memeriksa deskripsi produk, harga, ketentuan pembayaran, informasi pengiriman, serta kebijakan pengembalian atau pengembalian dana sebelum menyelesaikan pembelian.</p>
      </div>
    </div>
  </div>

  <!-- Modal: Privacy Policy -->
  <div class="modal-overlay" id="modal-privacy">
    <div class="modal-dialog">
      <div class="modal-header">
        <h3 class="modal-title">KEBIJAKAN PRIVASI</h3>
        <button class="modal-close" onclick="closeModal('modal-privacy')">&times;</button>
      </div>
      <div class="modal-body">
        <h4>Bianca Veana Universe (Terakhir diperbarui: Oktober 2026)</h4>
        <p>Di Bianca Veana Universe, kami menghormati privasi setiap pengunjung dan berkomitmen untuk melindungi informasi pribadi yang dibagikan melalui situs web kami.</p>
        <br>
        <h5>1. Informasi yang Kami Kumpulkan</h5>
        <p>Kami dapat mengumpulkan nama, alamat pengiriman, email, dan nomor telepon saat Anda melakukan pemesanan buku atau pendaftaran newsletter.</p>
        <br>
        <h5>2. Bagaimana Kami Menggunakan Informasi Anda</h5>
        <p>Informasi yang dikumpulkan digunakan semata-mata untuk memproses pengiriman buku, mengirimkan akses file e-book, serta membagikan informasi peluncuran novel terbaru.</p>
        <br>
        <h5>3. Keamanan Data</h5>
        <p>Kami tidak menjual atau membagikan data pribadi pelanggan kepada pihak manapun kecuali mitra ekspedisi dan payment gateway tepercaya untuk kelancaran transaksi.</p>
      </div>
    </div>
  </div>

  <!-- Modal: Shipping & Returns -->
  <div class="modal-overlay" id="modal-shipping">
    <div class="modal-dialog">
      <div class="modal-header">
        <h3 class="modal-title">SHIPPING & RETURNS</h3>
        <button class="modal-close" onclick="closeModal('modal-shipping')">&times;</button>
      </div>
      <div class="modal-body">
        <h4>Kebijakan Pengiriman dan Penukaran — Bianca Veana Universe</h4>
        <br>
        <h5>1. Kebijakan Pengiriman</h5>
        <p>Setiap pesanan buku fisik dikemas dengan bubble wrap tebal dan box khusus untuk melindungi koleksi Anda. Estimasi waktu pengiriman mengikuti jasa ekspedisi resmi (JNE, SiCepat, J&T).</p>
        <br>
        <h5>2. Ketentuan Penukaran Produk</h5>
        <p>Penukaran buku hanya berlaku untuk cacat pabrik signifikan (seperti kertas robek akibat proses produksi). Pembeli wajib:</p>
        <ul>
          <li>Menyertakan video unboxing utuh tanpa terputus sejak paket tersegel.</li>
          <li>Mengajukan klaim maksimal 3 × 24 jam setelah paket diterima.</li>
          <li>Menghubungi admin via WhatsApp di <strong>0817752901</strong>.</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Modal: Copyright & Permissions -->
  <div class="modal-overlay" id="modal-copyright">
    <div class="modal-dialog">
      <div class="modal-header">
        <h3 class="modal-title">COPYRIGHT & PERMISSIONS</h3>
        <button class="modal-close" onclick="closeModal('modal-copyright')">&times;</button>
      </div>
      <div class="modal-body">
        <h4>Bianca Veana Universe</h4>
        <p>Seluruh karya yang diterbitkan dalam Bianca Veana Universe, termasuk novel Mantra, Hierarchy, Fate, Serenity, Beauty in Madness, karakter orisinal keluarga Notonegoro, naskah, ilustrasi, desain sampul, dan logo dilindungi oleh ketentuan hak cipta.</p>
        <br>
        <p>Pembelian buku cetak maupun digital tidak memindahkan hak kepemilikan cipta karya tersebut kepada pembeli. Dilarang keras melakukan penggandaan, pembajakan file digital, maupun pencetakan ulang tanpa izin tertulis dari pemegang hak cipta.</p>
      </div>
    </div>
  </div>

  <script>
    function openModal(id) {
      document.getElementById(id).classList.add('active');
    }
    function closeModal(id) {
      document.getElementById(id).classList.remove('active');
    }
    window.addEventListener('click', function(e) {
      if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('active');
      }
    });
  </script>
  @stack('scripts')
</body>
</html>
