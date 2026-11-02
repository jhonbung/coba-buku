<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>@yield('title', 'BIANCA VEANA — Official Author & Luxury Bookstore')</title>
  <meta name="description" content="Website resmi Bianca Veana Bookstore. Pusat penjualan novel cetak, e-book eksklusif, dan merchandise resmi The Seven Notonegoro Series.">
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ file_exists(public_path('css/style.css')) ? filemtime(public_path('css/style.css')) : time() }}">
  <style>
    /* Critical Mobile Header & Drawer CSS (Guaranteed cache-proof on all phones) */
    .mobile-menu-btn {
      display: none;
      background: var(--ivory, #FAF7F2);
      border: 1px solid var(--soft-beige, #EBD4B2);
      color: var(--ocean-navy, #172B49);
      width: 40px;
      height: 40px;
      border-radius: 8px;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
      cursor: pointer;
      transition: all 0.2s ease;
      flex-shrink: 0;
    }
    .mobile-menu-btn:active {
      background: var(--champagne-gold, #C6A16B);
      color: #FFFFFF;
    }

    .mobile-nav-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(11, 20, 36, 0.68);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      z-index: 9998;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .mobile-nav-backdrop.show {
      display: block !important;
      opacity: 1 !important;
    }

    .mobile-nav-drawer {
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      width: 84%;
      max-width: 320px;
      background: #FFFFFF;
      z-index: 9999;
      transform: translateX(-100%);
      transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1);
      display: flex;
      flex-direction: column;
      box-shadow: 4px 0 30px rgba(0, 0, 0, 0.28);
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
    }
    .mobile-nav-drawer.show {
      transform: translateX(0) !important;
    }

    .mobile-drawer-header {
      padding: 18px 20px;
      background: radial-gradient(circle at 30% 30%, #1c365d 0%, #172B49 100%);
      color: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 2px solid var(--champagne-gold, #C6A16B);
      flex-shrink: 0;
    }
    .mobile-drawer-brand {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .mobile-drawer-logo {
      width: 38px !important;
      height: 38px !important;
      object-fit: contain !important;
      filter: drop-shadow(0 2px 6px rgba(198, 161, 107, 0.4));
    }
    .mobile-drawer-title {
      font-family: var(--font-serif, 'Playfair Display', serif);
      font-size: 1.05rem;
      font-weight: 700;
      letter-spacing: 2px;
      color: #FFFFFF;
      display: block;
    }
    .mobile-drawer-subtitle {
      font-size: 0.6rem;
      letter-spacing: 2px;
      color: var(--champagne-gold, #C6A16B);
      text-transform: uppercase;
      font-weight: 600;
      display: block;
    }
    .mobile-drawer-close {
      background: rgba(255, 255, 255, 0.12);
      border: 1px solid rgba(255, 255, 255, 0.25);
      color: #FFFFFF;
      width: 34px;
      height: 34px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      cursor: pointer;
    }
    .mobile-drawer-close:active {
      background: rgba(255, 255, 255, 0.3);
    }

    .mobile-drawer-nav {
      flex: 1;
      padding: 16px 14px;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    .mobile-drawer-link {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 12px 16px;
      border-radius: 8px;
      font-size: 0.92rem;
      font-weight: 600;
      color: var(--ocean-navy, #172B49);
      text-decoration: none;
      transition: all 0.2s ease;
    }
    .mobile-drawer-link i {
      width: 20px;
      text-align: center;
      font-size: 1rem;
      color: var(--champagne-gold, #C6A16B);
    }
    .mobile-drawer-link:active,
    .mobile-drawer-link.active {
      background: var(--ivory, #FAF7F2);
      color: var(--champagne-gold, #C6A16B);
      border-left: 3px solid var(--champagne-gold, #C6A16B);
      padding-left: 13px;
    }

    .mobile-drawer-footer {
      padding: 18px 16px;
      border-top: 1px solid var(--soft-beige, #EBD4B2);
      background: var(--ivory, #FAF7F2);
      flex-shrink: 0;
    }

    @media (max-width: 992px) {
      .mobile-menu-btn {
        display: inline-flex !important;
      }
      .nav-desktop {
        display: none !important;
      }
      .header-inner {
        padding: 10px 16px !important;
        gap: 10px !important;
        flex-wrap: nowrap !important;
        justify-content: space-between !important;
        align-items: center !important;
      }
      .brand-logo {
        flex: 1 !important;
        text-align: center !important;
      }
      .brand-crest-img {
        height: 38px !important;
      }
      .brand-name {
        font-size: 1.25rem !important;
        letter-spacing: 2px !important;
        margin-bottom: 0 !important;
      }
      .brand-tagline {
        font-size: 0.52rem !important;
        letter-spacing: 1.5px !important;
      }
    }

    @media (max-width: 600px) {
      .header-inner {
        padding: 8px 12px !important;
        gap: 8px !important;
      }
      .brand-crest-img {
        height: 32px !important;
      }
      .brand-name {
        font-size: 1.05rem !important;
        letter-spacing: 1.5px !important;
      }
      .brand-tagline {
        font-size: 0.44rem !important;
        letter-spacing: 1px !important;
      }
      .header-actions {
        gap: 8px !important;
      }
      .header-actions .btn-user-text {
        display: none !important;
      }
      .header-actions .btn-user-auth {
        padding: 6px 10px !important;
      }
    }

    /* Novel Horizontal Slider / Track Base Styles */
    .novel-slider-container {
      position: relative;
      width: 100%;
    }
    .novel-slider-track {
      display: flex;
      gap: 24px;
      overflow-x: auto;
      scroll-behavior: smooth;
      scroll-snap-type: x mandatory;
      padding: 10px 4px 18px;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    .novel-slider-track::-webkit-scrollbar {
      display: none;
    }
    .novel-slide-card {
      flex: 0 0 calc(25% - 18px);
      min-width: 250px;
      max-width: 290px;
      scroll-snap-align: start;
    }
    .slider-arrow-btn {
      position: absolute;
      top: 45%;
      transform: translateY(-50%);
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: #FFFFFF;
      border: 2px solid var(--champagne-gold, #C6A16B);
      color: var(--ocean-navy, #172B49);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
      cursor: pointer;
      z-index: 10;
      box-shadow: 0 4px 16px rgba(10, 25, 47, 0.22);
      transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .slider-arrow-btn:hover {
      background: var(--champagne-gold, #C6A16B);
      color: #FFFFFF;
      transform: translateY(-50%) scale(1.08);
      box-shadow: 0 6px 20px rgba(198, 161, 107, 0.5);
    }
    .slider-arrow-btn:active {
      transform: translateY(-50%) scale(0.95);
    }
    .slider-arrow-btn.prev {
      left: -20px;
    }
    .slider-arrow-btn.next {
      right: -20px;
    }

    @media (max-width: 992px) {
      .novel-group-container {
        padding: 28px 20px;
      }
      .novel-slide-card {
        flex: 0 0 calc(50% - 12px);
        min-width: 240px;
      }
      .slider-arrow-btn {
        width: 40px;
        height: 40px;
        font-size: 1rem;
      }
      .slider-arrow-btn.prev {
        left: -10px;
      }
      .slider-arrow-btn.next {
        right: -10px;
      }
      .hero-nav-btn {
        display: flex !important;
        width: 44px !important;
        height: 44px !important;
        font-size: 1.1rem !important;
        z-index: 25 !important;
      }
      .hero-nav-btn.prev {
        left: 12px !important;
      }
      .hero-nav-btn.next {
        right: 12px !important;
      }
    }

    @media (max-width: 600px) {
      .hero-slider-section, .hero-slides-wrapper {
        min-height: 590px !important;
      }
      .hero-slide-inner {
        padding: 85px 14px 80px !important;
      }
      .hero-badge {
        margin: 8px auto 14px !important;
        font-size: 0.68rem !important;
        padding: 4px 10px !important;
      }
      .hero-title {
        font-size: 1.65rem !important;
        line-height: 1.25 !important;
        margin-bottom: 12px !important;
      }
      .hero-tagline {
        font-size: 0.85rem !important;
        line-height: 1.55 !important;
        margin-bottom: 18px !important;
      }
      .hero-cta-group {
        flex-direction: column !important;
        width: 100% !important;
        max-width: 280px !important;
        margin: 0 auto 16px !important;
        gap: 10px !important;
      }
      .hero-cta-group .btn {
        width: 100% !important;
        text-align: center !important;
        justify-content: center !important;
        padding: 12px 18px !important;
        font-size: 0.8rem !important;
      }
      .hero-micro-meta {
        flex-direction: column !important;
        gap: 5px !important;
        font-size: 0.74rem !important;
        margin-top: 8px !important;
        margin-bottom: 34px !important;
      }
      .hero-nav-btn {
        display: flex !important;
        width: 38px !important;
        height: 38px !important;
        font-size: 0.95rem !important;
        background: rgba(11, 20, 36, 0.75) !important;
        backdrop-filter: blur(6px) !important;
        -webkit-backdrop-filter: blur(6px) !important;
        border: 1.5px solid var(--champagne-gold) !important;
        color: var(--champagne-gold) !important;
        top: 42% !important;
        z-index: 25 !important;
        border-radius: 50% !important;
      }
      .hero-nav-btn.prev {
        left: 8px !important;
      }
      .hero-nav-btn.next {
        right: 8px !important;
      }
      .hero-minimal-dots {
        bottom: 14px !important;
        z-index: 25 !important;
      }

      /* Novel Horizontal Slider Mobile */
      .novel-group-container {
        padding: 22px 12px !important;
        margin-bottom: 32px !important;
        border-radius: 12px !important;
      }
      .novel-slider-track {
        gap: 14px !important;
        padding: 6px 4px 18px !important;
        scroll-snap-type: x mandatory !important;
      }
      .novel-slide-card {
        flex: 0 0 270px !important;
        min-width: 270px !important;
        max-width: 82vw !important;
        scroll-snap-align: center !important;
      }
      .slider-arrow-btn {
        width: 38px !important;
        height: 38px !important;
        font-size: 0.92rem !important;
        top: 42% !important;
        background: rgba(255, 255, 255, 0.96) !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.25) !important;
      }
      .slider-arrow-btn.prev {
        left: 2px !important;
      }
      .slider-arrow-btn.next {
        right: 2px !important;
      }
      .novel-slider-container.dark-theme .slider-arrow-btn {
        background: rgba(23, 43, 73, 0.92) !important;
        color: var(--champagne-gold) !important;
        border-color: var(--champagne-gold) !important;
      }

      /* Video Teaser Mobile */
      .teaser-badge-bar {
        flex-direction: column !important;
        gap: 14px !important;
        padding: 16px 14px !important;
        text-align: center !important;
      }
      .teaser-features {
        display: flex !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
        gap: 10px 16px !important;
        font-size: 0.76rem !important;
      }
      .teaser-cta-wrap,
      #teaser-cta-btn {
        width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        text-align: center !important;
        padding: 12px 18px !important;
        font-size: 0.85rem !important;
        box-sizing: border-box !important;
      }

      /* E-Book Page Mobile */
      .ebook-steps-grid {
        grid-template-columns: 1fr !important;
        gap: 24px !important;
      }
      .ebook-switch-banner {
        flex-direction: column !important;
        text-align: center !important;
        gap: 16px !important;
      }
      .ebook-switch-banner > div {
        flex-direction: column !important;
        text-align: center !important;
      }
      .ebook-switch-btn {
        width: 100% !important;
        text-align: center !important;
        justify-content: center !important;
      }

      /* E-Book Chapter Parts Mobile */
      .ebook-part-card {
        padding: 16px 14px !important;
        gap: 12px !important;
      }
      .part-header-row {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 8px !important;
      }
      .part-title-wrap {
        width: 100% !important;
        min-width: 0 !important;
        gap: 8px !important;
      }
      .part-title {
        font-size: 1.1rem !important;
      }
      .part-price-wrap {
        width: 100% !important;
        justify-content: space-between !important;
        border-bottom: 1px dashed #E2E8F0 !important;
        padding-bottom: 8px !important;
      }
      .part-price {
        font-size: 1.25rem !important;
      }
      .part-synopsis-box {
        padding: 10px 12px !important;
      }
      .part-synopsis-text {
        font-size: 0.82rem !important;
        line-height: 1.55 !important;
      }
      .part-actions-row {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 10px !important;
        padding-top: 10px !important;
      }
      .part-access-info {
        justify-content: center !important;
        font-size: 0.72rem !important;
        text-align: center !important;
      }
      .part-buttons-group {
        width: 100% !important;
        display: flex !important;
        gap: 8px !important;
      }
      .btn-part-read {
        flex: 0 0 85px !important;
        justify-content: center !important;
        padding: 10px 8px !important;
        font-size: 0.8rem !important;
      }
      .part-buy-form {
        flex: 1 !important;
      }
      .btn-part-buy {
        width: 100% !important;
        justify-content: center !important;
        text-align: center !important;
        padding: 10px 12px !important;
        font-size: 0.82rem !important;
        background: var(--champagne-gold) !important;
        color: #FFFFFF !important;
      }
      .chapter-parts-header {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 8px !important;
      }
      .chapter-parts-title {
        font-size: 1.25rem !important;
      }
      .chapter-parts-badge {
        align-self: flex-start !important;
      }
      .faq-2col-grid {
        grid-template-columns: 1fr !important;
        gap: 16px !important;
      }
    }

    .ebook-steps-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }

    .ebook-switch-banner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
    }

    /* E-Book Chapter Parts Base */
    .ebook-part-card {
      background: var(--white);
      border: 1.5px solid var(--soft-beige);
      border-radius: var(--radius-md);
      padding: 22px 26px;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
      display: flex;
      flex-direction: column;
      gap: 14px;
      width: 100%;
      box-sizing: border-box;
    }
    .ebook-part-card:hover {
      border-color: var(--champagne-gold);
      box-shadow: 0 8px 24px rgba(198, 161, 107, 0.16);
      transform: translateY(-2px);
    }
    .part-header-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
    }
    .part-title-wrap {
      display: flex;
      align-items: center;
      gap: 10px;
      flex: 1;
      min-width: 200px;
    }
    .part-badge {
      font-size: 0.74rem;
      font-weight: 800;
      background: linear-gradient(135deg, #172B49 0%, #1c365d 100%);
      color: var(--champagne-gold);
      border: 1px solid var(--champagne-gold);
      padding: 4px 10px;
      border-radius: 6px;
      letter-spacing: 0.5px;
      flex-shrink: 0;
      white-space: nowrap;
    }
    .part-title {
      font-family: var(--font-serif);
      font-size: 1.25rem;
      color: var(--ocean-navy);
      margin: 0;
      font-weight: 700;
      line-height: 1.3;
    }
    .part-price-wrap {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }
    .part-price {
      font-size: 1.35rem;
      font-weight: 800;
      color: #15803D;
      line-height: 1;
    }
    .part-delivery-tag {
      font-size: 0.68rem;
      font-weight: 700;
      color: #15803D;
      background: #DCFCE7;
      padding: 3px 8px;
      border-radius: 4px;
      white-space: nowrap;
    }
    .part-synopsis-box {
      background: #FAF8F5;
      border: 1px solid #F0EAE1;
      border-left: 3.5px solid var(--champagne-gold);
      border-radius: 0 8px 8px 0;
      padding: 12px 18px;
    }
    .part-synopsis-label {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 4px;
      font-size: 0.72rem;
      font-weight: 800;
      color: var(--ocean-navy);
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .part-synopsis-label i {
      color: var(--champagne-gold);
    }
    .part-synopsis-text {
      font-size: 0.88rem;
      color: #334155;
      margin: 0;
      line-height: 1.65;
    }
    .part-info-text {
      font-size: 0.8rem;
      color: var(--text-muted);
      font-style: italic;
      padding: 6px 0;
    }
    .part-actions-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid #F1F5F9;
      padding-top: 14px;
      gap: 12px;
      flex-wrap: wrap;
    }
    .part-access-info {
      font-size: 0.76rem;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .part-access-info i {
      color: var(--champagne-gold);
    }
    .part-buttons-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .btn-part-read {
      padding: 9px 16px;
      font-size: 0.82rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      border-radius: 6px;
      background: #F8FAFC;
      border: 1px solid #CBD5E1;
      color: #334155;
      text-decoration: none;
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    .btn-part-read:hover {
      background: #E2E8F0;
      color: #0F172A;
    }
    .part-buy-form {
      margin: 0;
    }
    .btn-part-buy {
      padding: 9px 20px;
      font-size: 0.85rem;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border-radius: 6px;
      border: 1.5px solid var(--champagne-gold);
      color: var(--ocean-navy);
      background: #FFFFFF;
      cursor: pointer;
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    .btn-part-buy:hover {
      background: var(--champagne-gold);
      color: #FFFFFF;
    }
    .chapter-parts-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 18px;
      border-bottom: 2px solid var(--soft-beige);
      padding-bottom: 12px;
      gap: 12px;
      flex-wrap: wrap;
    }
    .chapter-parts-title {
      font-family: var(--font-serif);
      font-size: 1.45rem;
      color: var(--ocean-navy);
      margin: 0 0 4px;
    }
    .chapter-parts-subtitle {
      font-size: 0.82rem;
      color: var(--text-muted);
    }
    .chapter-parts-badge {
      font-size: 0.78rem;
      font-weight: 700;
      color: #15803D;
      background: #DCFCE7;
      padding: 4px 12px;
      border-radius: 20px;
      white-space: nowrap;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .faq-2col-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      font-size: 0.8rem;
      color: var(--text-muted);
      line-height: 1.6;
    }
  </style>
  @stack('styles')
</head>
<body>


  <!-- SITE HEADER & NAVIGATION -->
  <header class="site-header">
    <div class="container header-inner">
      <!-- Mobile Menu Toggle Button (Visible on mobile/tablet <= 992px) -->
      <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileNav()" aria-label="Buka Menu Navigasi" title="Menu Navigasi">
        <i class="fa-solid fa-bars"></i>
      </button>

      <!-- Desktop Nav Menu (Hidden on mobile <= 992px) -->
      <nav class="nav-desktop">
        <ul class="nav-menu">
          <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
          <li><a href="{{ route('novels.index') }}" class="nav-link {{ request()->routeIs('novels.*') ? 'active' : '' }}">Novels</a></li>
          <li><a href="{{ route('ebooks.index') }}" class="nav-link {{ request()->routeIs('ebooks.*') ? 'active' : '' }}">E-Books</a></li>
          <li><a href="{{ route('merchandise.index') }}" class="nav-link {{ request()->routeIs('merchandise.*') ? 'active' : '' }}">Merchandise</a></li>
          <li><a href="{{ route('author.index') }}" class="nav-link {{ request()->routeIs('author.*') ? 'active' : '' }}">About the Author</a></li>
        </ul>
      </nav>

      <!-- Brand Logo -->
      <div class="brand-logo">
        <a href="{{ route('home') }}" class="brand-link">
          <img src="{{ asset('images/logo.png') }}" alt="Bianca Veana Logo" class="brand-crest-img">
          <div class="brand-text-wrap">
            <h1 class="brand-name">BIANCA VEANA</h1>
            <div class="brand-tagline">OFFICIAL BOOKSTORE</div>
          </div>
        </a>
      </div>

      <!-- Header Actions -->
      <div class="header-actions">
        <a href="{{ route('cart.index') }}" class="icon-btn" title="Keranjang Belanja" id="nav-cart-btn">
          <i class="fa-solid fa-bag-shopping"></i>
          @php
            try {
                if (Auth::guard('web')->check()) {
                    $cartCount = Auth::guard('web')->user()->cartItems()->sum('quantity');
                } else {
                    $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
                }
            } catch (\Throwable $e) {
                $cartCount = 0;
            }
          @endphp
          @if($cartCount > 0)
            <span class="cart-badge">{{ $cartCount }}</span>
          @endif
        </a>

        <!-- User Authentication & Account Menu (Customer Guard 'web') -->
        @if(Auth::guard('web')->check())
          @php
            $currentUser = Auth::guard('web')->user();
          @endphp
          <div style="position: relative; display: inline-block;" id="userMenuDropdown">
            <button type="button" onclick="toggleUserDropdown()" style="display: flex; align-items: center; gap: 8px; background: var(--ivory); border: 1.5px solid var(--champagne-gold); padding: 5px 12px 5px 6px; border-radius: 20px; cursor: pointer; color: var(--ocean-navy); font-size: 0.82rem; font-weight: 700;">
              <span style="width: 28px; height: 28px; border-radius: 50%; background: var(--ocean-navy); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 0.78rem;">
                {{ strtoupper(substr($currentUser->name, 0, 1)) }}
              </span>
              <span style="max-width: 90px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                {{ explode(' ', $currentUser->name)[0] }}
              </span>
              <i class="fa-solid fa-chevron-down" style="font-size: 0.65rem; color: var(--champagne-gold);"></i>
            </button>

            <div id="userDropdownContent" style="display: none; position: absolute; right: 0; top: 115%; width: 200px; background: #FFFFFF; border-radius: 8px; border: 1px solid var(--soft-beige); box-shadow: var(--shadow-md); z-index: 1000; overflow: hidden;">
              <div style="padding: 12px 16px; border-bottom: 1px solid #F1F5F9; background: #FAF9F6;">
                <strong style="font-size: 0.85rem; color: var(--ocean-navy); display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $currentUser->name }}</strong>
                <span style="font-size: 0.72rem; color: var(--text-muted); display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $currentUser->email }}</span>
              </div>
              <a href="{{ route('account.profile') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 0.82rem; color: var(--ocean-navy); text-decoration: none; transition: background 0.15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                <i class="fa-solid fa-user-circle" style="color: var(--champagne-gold); width: 16px;"></i> Profil Saya
              </a>
              <a href="{{ route('account.orders') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 0.82rem; color: var(--ocean-navy); text-decoration: none; transition: background 0.15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                <i class="fa-solid fa-boxes-packing" style="color: var(--champagne-gold); width: 16px;"></i> Riwayat Pesanan
              </a>
              <div style="border-top: 1px solid #F1F5F9;">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                  @csrf
                  <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 0.82rem; color: #DC2626; background: none; border: none; cursor: pointer; text-align: left; transition: background 0.15s;" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'">
                    <i class="fa-solid fa-right-from-bracket" style="width: 16px;"></i> Keluar (Logout)
                  </button>
                </form>
              </div>
            </div>
          </div>
          <script>
            function toggleUserDropdown() {
              const el = document.getElementById('userDropdownContent');
              el.style.display = el.style.display === 'block' ? 'none' : 'block';
            }
            window.addEventListener('click', function(e) {
              const menu = document.getElementById('userMenuDropdown');
              const dropdown = document.getElementById('userDropdownContent');
              if (menu && dropdown && !menu.contains(e.target)) {
                dropdown.style.display = 'none';
              }
            });
          </script>
        @else
          <a href="{{ route('login') }}" class="btn-user-auth" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 6px; background: var(--ivory); border: 1.5px solid var(--champagne-gold); color: var(--ocean-navy); font-size: 0.82rem; font-weight: 700; text-decoration: none; transition: all 0.2s; box-shadow: var(--shadow-sm);" onmouseover="this.style.background='var(--champagne-gold)'; this.style.color='#FFF';" onmouseout="this.style.background='var(--ivory)'; this.style.color='var(--ocean-navy)';">
            <i class="fa-solid fa-user"></i> <span class="btn-user-text">Masuk / Daftar</span>
          </a>
        @endif
      </div>
    </div>
  </header>

  <!-- MOBILE NAVIGATION DRAWER & BACKDROP -->
  <div class="mobile-nav-backdrop" id="mobileNavBackdrop" style="display: none; position: fixed; inset: 0; z-index: 9998;" onclick="closeMobileNav()"></div>
  <aside class="mobile-nav-drawer" id="mobileNavDrawer" style="position: fixed; top: 0; left: 0; bottom: 0; width: 84%; max-width: 320px; z-index: 9999; transform: translateX(-100%);" aria-label="Navigasi Seluler">
    <div class="mobile-drawer-header">
      <div class="mobile-drawer-brand">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mobile-drawer-logo" style="width: 38px; height: 38px; object-fit: contain;">
        <div>
          <span class="mobile-drawer-title">BIANCA VEANA</span>
          <span class="mobile-drawer-subtitle">OFFICIAL BOOKSTORE</span>
        </div>
      </div>
      <button type="button" class="mobile-drawer-close" onclick="closeMobileNav()" aria-label="Tutup Menu">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <nav class="mobile-drawer-nav">
      <a href="{{ route('home') }}" class="mobile-drawer-link {{ request()->routeIs('home') ? 'active' : '' }}" onclick="closeMobileNav()">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
      </a>
      <a href="{{ route('novels.index') }}" class="mobile-drawer-link {{ request()->routeIs('novels.*') ? 'active' : '' }}" onclick="closeMobileNav()">
        <i class="fa-solid fa-book-open"></i>
        <span>Novels (Buku Fisik)</span>
      </a>
      <a href="{{ route('ebooks.index') }}" class="mobile-drawer-link {{ request()->routeIs('ebooks.*') ? 'active' : '' }}" onclick="closeMobileNav()">
        <i class="fa-solid fa-tablet-screen-button"></i>
        <span>E-Books (Serial Digital)</span>
      </a>
      <a href="{{ route('merchandise.index') }}" class="mobile-drawer-link {{ request()->routeIs('merchandise.*') ? 'active' : '' }}" onclick="closeMobileNav()">
        <i class="fa-solid fa-crown"></i>
        <span>Merchandise Resmi</span>
      </a>
      <a href="{{ route('author.index') }}" class="mobile-drawer-link {{ request()->routeIs('author.*') ? 'active' : '' }}" onclick="closeMobileNav()">
        <i class="fa-solid fa-feather-pointed"></i>
        <span>About the Author</span>
      </a>
    </nav>

    <div class="mobile-drawer-footer">
      @if(Auth::guard('web')->check())
        @php $currentUser = Auth::guard('web')->user(); @endphp
        <div class="mobile-user-card">
          <div class="mobile-user-avatar">
            {{ strtoupper(substr($currentUser->name, 0, 1)) }}
          </div>
          <div style="overflow: hidden;">
            <strong class="mobile-user-name">{{ $currentUser->name }}</strong>
            <span class="mobile-user-email">{{ $currentUser->email }}</span>
          </div>
        </div>
        <div class="mobile-user-actions">
          <a href="{{ route('account.profile') }}" class="mobile-user-btn" onclick="closeMobileNav()">
            <i class="fa-solid fa-user-circle"></i> Profil Saya
          </a>
          <a href="{{ route('account.orders') }}" class="mobile-user-btn" onclick="closeMobileNav()">
            <i class="fa-solid fa-boxes-packing"></i> Riwayat Pesanan
          </a>
          <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="mobile-user-btn logout" style="width: 100%; border: none; cursor: pointer; text-align: left;">
              <i class="fa-solid fa-right-from-bracket"></i> Keluar (Logout)
            </button>
          </form>
        </div>
      @else
        <a href="{{ route('login') }}" class="btn btn-gold mobile-login-btn" style="width: 100%; text-align: center; justify-content: center; padding: 12px; font-weight: 700; font-size: 0.88rem; display: flex; align-items: center; gap: 8px;" onclick="closeMobileNav()">
          <i class="fa-solid fa-user"></i> Masuk / Daftar Akun
        </a>
      @endif
    </div>
  </aside>

  <script>
    function toggleMobileNav() {
      const drawer = document.getElementById('mobileNavDrawer');
      const backdrop = document.getElementById('mobileNavBackdrop');
      if (!drawer || !backdrop) return;
      const isOpen = drawer.classList.contains('show');
      if (isOpen) {
        closeMobileNav();
      } else {
        drawer.classList.add('show');
        backdrop.classList.add('show');
        document.body.style.overflow = 'hidden';
      }
    }

    function closeMobileNav() {
      const drawer = document.getElementById('mobileNavDrawer');
      const backdrop = document.getElementById('mobileNavBackdrop');
      if (drawer) drawer.classList.remove('show');
      if (backdrop) backdrop.classList.remove('show');
      document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') closeMobileNav();
    });
  </script>

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
          <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 14px;">
            <img src="{{ asset('images/logo.png') }}" alt="Bianca Veana Logo" style="height: 52px; width: auto; object-fit: contain; filter: drop-shadow(0 2px 8px rgba(0,0,0,0.35));">
            <div>
              <h3 class="brand-name" style="margin-bottom: 0;">BIANCA VEANA</h3>
              <div class="brand-tagline" style="color: var(--champagne-gold);">BIANCA VEANA UNIVERSE</div>
            </div>
          </div>
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
            <li><a href="{{ route('author.index') }}"><i class="fa-solid fa-angle-right" style="color: var(--champagne-gold); font-size: 0.75rem;"></i> About the Author</a></li>
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

    // Global Novel Track Horizontal Slider Controller
    function slideNovelTrack(trackId, direction) {
      const track = document.getElementById(trackId);
      if (!track) return;
      const card = track.querySelector('.novel-slide-card') || track.querySelector('.product-card');
      const scrollAmount = card ? (card.offsetWidth + 20) : 285;
      track.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    }
  </script>
  <!-- FLOATING LIVE CHAT CUSTOMER SUPPORT -->
  @include('partials.chat_widget')

  @stack('scripts')
</body>
</html>
