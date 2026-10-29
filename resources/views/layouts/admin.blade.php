<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Portal — BIANCA VEANA')</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    :root {
      --admin-navy-deep: #0B1424;
      --admin-navy-surface: #111E33;
      --admin-navy-border: rgba(198, 161, 107, 0.25);
      --admin-gold: #C6A16B;
      --admin-gold-light: #EBD4B2;
      --admin-bg: #F8F9FC;
      --admin-text-main: #0F172A;
      --admin-text-muted: #64748B;
      --admin-border-subtle: #E2E8F0;
      --font-body: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      --font-display: 'Playfair Display', Georgia, serif;
      --sidebar-width: 255px;
    }

    * {
      box-sizing: border-box;
    }

    body {
      background-color: var(--admin-bg);
      color: var(--admin-text-main);
      font-family: var(--font-body);
      min-height: 100vh;
      margin: 0;
      -webkit-font-smoothing: antialiased;
    }

    .admin-layout {
      display: flex;
      min-height: 100vh;
      width: 100%;
    }

    /* LEFT SIDEBAR */
    .admin-sidebar {
      width: var(--sidebar-width);
      min-width: var(--sidebar-width);
      background: var(--admin-navy-deep);
      border-right: 1px solid var(--admin-navy-border);
      color: #F8FAFC;
      display: flex;
      flex-direction: column;
      position: sticky;
      top: 0;
      height: 100vh;
      z-index: 1000;
      box-shadow: 4px 0 24px rgba(5, 11, 20, 0.35);
      transition: transform 0.25s ease;
    }

    /* Sidebar Brand */
    .admin-sidebar-brand {
      padding: 22px 20px 18px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      text-decoration: none;
      background: rgba(0, 0, 0, 0.15);
    }

    .admin-logo-mark {
      width: 38px;
      height: 38px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .admin-logo-mark img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      filter: drop-shadow(0 2px 6px rgba(198, 161, 107, 0.4));
    }

    .admin-brand-name {
      font-family: var(--font-display);
      font-size: 1.15rem;
      font-weight: 700;
      letter-spacing: 2.5px;
      color: #FFFFFF;
      line-height: 1.1;
      margin: 0;
    }

    .admin-scope-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 0.62rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      font-weight: 700;
      color: var(--admin-gold);
      margin-top: 3px;
    }

    /* Sidebar Nav Links */
    .admin-sidebar-nav {
      flex: 1;
      padding: 16px 12px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .admin-nav-section-title {
      font-size: 0.68rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      font-weight: 700;
      color: #64748B;
      padding: 12px 14px 4px;
    }

    .admin-nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 16px;
      border-radius: 8px;
      font-size: 0.86rem;
      font-weight: 600;
      color: #94A3B8;
      text-decoration: none;
      transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
      border: 1px solid transparent;
    }

    .admin-nav-link i {
      font-size: 0.95rem;
      width: 20px;
      text-align: center;
      color: #64748B;
      transition: color 0.2s ease;
    }

    .admin-nav-link:hover {
      color: #FFFFFF;
      background: rgba(255, 255, 255, 0.06);
    }

    .admin-nav-link:hover i {
      color: var(--admin-gold);
    }

    .admin-nav-link.active {
      color: #FFFFFF;
      background: var(--admin-navy-surface);
      border-color: var(--admin-navy-border);
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
      border-left: 3.5px solid var(--admin-gold);
    }

    .admin-nav-link.active i {
      color: var(--admin-gold);
    }

    /* Sidebar Footer / User section */
    .admin-sidebar-footer {
      padding: 16px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      background: rgba(0, 0, 0, 0.2);
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .admin-user-card {
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
      padding: 8px 12px;
      border-radius: 8px;
      font-size: 0.8rem;
    }

    .admin-user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: var(--admin-gold);
      color: var(--admin-navy-deep);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      font-weight: 700;
      flex-shrink: 0;
    }

    .admin-user-name {
      font-weight: 600;
      color: #F1F5F9;
      display: block;
      line-height: 1.2;
    }

    .admin-user-role {
      font-size: 0.68rem;
      color: var(--admin-gold);
    }

    .btn-logout-styled {
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.25);
      color: #FCA5A5;
      padding: 8px 14px;
      border-radius: 6px;
      font-size: 0.78rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      transition: all 0.2s ease;
      width: 100%;
    }

    .btn-logout-styled:hover {
      background: #EF4444;
      color: #FFFFFF;
      border-color: #EF4444;
    }

    /* MAIN AREA */
    .admin-main-area {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
      background-color: var(--admin-bg);
    }

    /* TOPBAR */
    .admin-topbar {
      height: 64px;
      background: #FFFFFF;
      border-bottom: 1px solid var(--admin-border-subtle);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 36px;
      position: sticky;
      top: 0;
      z-index: 900;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .btn-sidebar-toggle {
      display: none;
      background: none;
      border: 1px solid #CBD5E1;
      padding: 6px 10px;
      border-radius: 6px;
      color: #334155;
      cursor: pointer;
      font-size: 1rem;
    }

    .btn-view-store {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 0.78rem;
      font-weight: 600;
      color: #1E40AF;
      padding: 7px 14px;
      border-radius: 6px;
      background: #EFF6FF;
      border: 1px solid #BFDBFE;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .btn-view-store:hover {
      background: #DBEAFE;
      color: #1D4ED8;
      transform: translateY(-1px);
    }

    /* Content Area */
    .admin-workspace {
      flex: 1;
      padding: 32px 0 60px;
    }

    .admin-container {
      max-width: 1440px;
      margin: 0 auto;
      padding: 0 36px;
      box-sizing: border-box;
    }

    /* Enhanced Card & Table Styles */
    .admin-card {
      background: #FFFFFF;
      border: 1px solid var(--admin-border-subtle);
      border-radius: 12px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(15, 23, 42, 0.03);
      overflow: hidden;
    }

    .admin-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.88rem;
      text-align: left;
    }

    .admin-table th {
      background: #F8FAFC;
      color: #475569;
      font-weight: 600;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      padding: 14px 20px;
      border-bottom: 1px solid var(--admin-border-subtle);
    }

    .admin-table td {
      padding: 16px 20px;
      border-bottom: 1px solid #F1F5F9;
      vertical-align: middle;
      color: #1E293B;
    }

    .admin-table tr:last-child td {
      border-bottom: none;
    }

    .admin-table tr:hover td {
      background-color: #FAFBFD;
    }

    .admin-footer-bar {
      background: #FFFFFF;
      border-top: 1px solid var(--admin-border-subtle);
      color: #64748B;
      font-size: 0.78rem;
      padding: 18px 36px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .btn-sidebar-toggle {
        display: inline-flex;
        align-items: center;
      }
      .admin-sidebar {
        position: fixed;
        left: -260px;
        top: 0;
        bottom: 0;
      }
      .admin-sidebar.show {
        left: 0;
      }
      .admin-container {
        padding: 0 20px;
      }
      .admin-topbar {
        padding: 0 20px;
      }
    }
  </style>
  @stack('styles')
</head>
<body>

  <div class="admin-layout">

    <!-- LEFT SIDEBAR -->
    <aside class="admin-sidebar" id="adminSidebar">
      
      <!-- Brand Header -->
      <a href="{{ route('admin.index') }}" class="admin-sidebar-brand">
        <div class="admin-logo-mark">
          <img src="{{ asset('images/logo.png') }}" alt="Bianca Veana Logo">
        </div>
        <div class="admin-title-wrap">
          <h1 class="admin-brand-name">BIANCA VEANA</h1>
          <span class="admin-scope-badge">
            <i class="fa-solid fa-shield-halved"></i> CONTROL CENTER
          </span>
        </div>
      </a>

      <!-- Vertical Sidebar Nav Menu -->
      <nav class="admin-sidebar-nav">
        <div class="admin-nav-section-title">Menu Utama</div>

        <a href="{{ route('admin.index') }}" class="admin-nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
          <i class="fa-solid fa-chart-line"></i>
          <span>Ringkasan Toko</span>
        </a>

        <a href="{{ route('admin.products') }}" class="admin-nav-link {{ (request()->routeIs('admin.products') || request()->routeIs('admin.products.edit') || request()->routeIs('admin.products.create')) ? 'active' : '' }}">
          <i class="fa-solid fa-boxes-stacked"></i>
          <span>Stok & Produk</span>
        </a>

        <a href="{{ route('admin.ebook_parts.hub') }}" class="admin-nav-link {{ request()->routeIs('admin.ebook_parts*') || request()->routeIs('admin.products.parts*') ? 'active' : '' }}">
          <i class="fa-solid fa-book-bookmark"></i>
          <span>Serial E-Book</span>
        </a>

        <a href="{{ route('admin.orders') }}" class="admin-nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
          <i class="fa-solid fa-receipt"></i>
          <span>Pesanan</span>
        </a>

        <a href="{{ route('admin.customers.index') }}" class="admin-nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
          <i class="fa-solid fa-users"></i>
          <span>Customer</span>
        </a>

        <a href="{{ route('admin.chat.index') }}" class="admin-nav-link {{ request()->routeIs('admin.chat*') ? 'active' : '' }}">
          <i class="fa-solid fa-comments"></i>
          <span>Live Chat</span>
        </a>

        <a href="{{ route('admin.videos') }}" class="admin-nav-link {{ request()->routeIs('admin.videos*') ? 'active' : '' }}">
          <i class="fa-solid fa-film"></i>
          <span>Video Teaser</span>
        </a>

        <div class="admin-nav-section-title" style="margin-top: 10px;">Akses Toko</div>

        <a href="{{ route('home') }}" target="_blank" class="admin-nav-link" style="color: #93C5FD;">
          <i class="fa-solid fa-arrow-up-right-from-square" style="color: #60A5FA;"></i>
          <span>Lihat Website Toko</span>
        </a>
      </nav>

      <!-- Sidebar User Profile & Logout -->
      @if(Auth::guard('admin')->check())
        <div class="admin-sidebar-footer">
          <div class="admin-user-card">
            <div class="admin-user-avatar">
              {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
            </div>
            <div style="overflow: hidden;">
              <span class="admin-user-name">{{ Auth::guard('admin')->user()->name }}</span>
              <span class="admin-user-role"><i class="fa-solid fa-circle-check"></i> Admin Resmi</span>
            </div>
          </div>

          <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-logout-styled" title="Keluar dari Panel Admin">
              <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
            </button>
          </form>
        </div>
      @endif

    </aside>

    <!-- MAIN AREA (Header + Content + Footer) -->
    <div class="admin-main-area">

      <!-- TOPBAR -->
      <header class="admin-topbar">
        <div style="display: flex; align-items: center; gap: 14px;">
          <button type="button" class="btn-sidebar-toggle" onclick="toggleAdminSidebar()" title="Toggle Menu">
            <i class="fa-solid fa-bars"></i>
          </button>
          <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #475569;">
            <i class="fa-solid fa-house" style="color: var(--admin-gold); font-size: 0.8rem;"></i>
            <span>Control Center</span>
            <span style="color: #CBD5E1;">/</span>
            <strong style="color: #0F172A;">@yield('title', 'Dashboard')</strong>
          </div>
        </div>

        <div style="display: flex; align-items: center; gap: 14px;">
          <!-- Live Real-Time Clock WIB -->
          <div class="admin-live-clock" style="display: flex; align-items: center; gap: 8px; background: #F1F5F9; border: 1px solid #CBD5E1; padding: 6px 14px; border-radius: 20px; font-size: 0.78rem; color: #1E293B;" title="Waktu Sinkron Server Indonesia (WIB)">
            <span style="width: 7px; height: 7px; border-radius: 50%; background: #10B981; box-shadow: 0 0 8px #10B981; display: inline-block;"></span>
            <i class="fa-regular fa-clock" style="color: var(--admin-gold);"></i>
            <span id="globalAdminWibClock" style="font-family: monospace; font-size: 0.82rem; font-weight: 700; color: #0F172A;">--:--:-- WIB</span>
          </div>

          <a href="{{ route('home') }}" target="_blank" class="btn-view-store" title="Buka Toko Customer">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Toko Customer
          </a>
        </div>
      </header>

      <!-- FLASH MESSAGES -->
      @if(session('success'))
        <div style="background: #ECFDF5; border-bottom: 1px solid #A7F3D0; color: #065F46; padding: 12px 36px; font-size: 0.88rem; display: flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
      @endif

      @if(session('warning'))
        <div style="background: #FFFBEB; border-bottom: 1px solid #FDE68A; color: #92400E; padding: 12px 36px; font-size: 0.88rem; display: flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-triangle-exclamation"></i> {{ session('warning') }}
        </div>
      @endif

      <!-- MAIN WORKSPACE -->
      <main class="admin-workspace">
        @yield('content')
      </main>

      <footer class="admin-footer-bar">
        <div>
          &copy; 2026 <strong>Bianca Veana Universe</strong> — Official Bookstore Management System.
        </div>
        <div style="display: flex; gap: 18px; color: #94A3B8;">
          <span>Versi: 2.5 Sidebar Edition</span>
          <span>Database: Terhubung</span>
        </div>
      </footer>

    </div>

  </div>

  <script>
    function updateGlobalAdminClock() {
      const el = document.getElementById('globalAdminWibClock');
      if (!el) return;
      const now = new Date();
      const timeStr = now.toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour12: false });
      el.textContent = timeStr + ' WIB';
    }
    setInterval(updateGlobalAdminClock, 1000);
    updateGlobalAdminClock();

    function toggleAdminSidebar() {
      const s = document.getElementById('adminSidebar');
      if (s) s.classList.toggle('show');
    }
  </script>
  @stack('scripts')
</body>
</html>
