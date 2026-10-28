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
    }

    body {
      background-color: var(--admin-bg);
      color: var(--admin-text-main);
      font-family: var(--font-body);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      margin: 0;
      -webkit-font-smoothing: antialiased;
    }

    /* Fluid Modern Navbar */
    .admin-navbar {
      background: var(--admin-navy-deep);
      border-bottom: 1px solid var(--admin-navy-border);
      color: #F8FAFC;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 24px rgba(5, 11, 20, 0.35);
    }

    .admin-header-fluid {
      width: 100%;
      padding: 0 36px;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-sizing: border-box;
      gap: 24px;
    }

    /* Left: Brand & Scope */
    .admin-brand-group {
      display: flex;
      align-items: center;
      gap: 16px;
      flex-shrink: 0;
    }

    .admin-logo-mark {
      width: 42px;
      height: 42px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .admin-logo-mark img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      filter: drop-shadow(0 2px 6px rgba(198, 161, 107, 0.4));
    }

    .admin-title-wrap {
      display: flex;
      flex-direction: column;
    }

    .admin-brand-name {
      font-family: var(--font-display);
      font-size: 1.22rem;
      font-weight: 700;
      letter-spacing: 3px;
      color: #FFFFFF;
      line-height: 1.1;
      margin: 0;
    }

    .admin-scope-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 0.65rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      font-weight: 700;
      color: var(--admin-gold);
      margin-top: 3px;
    }

    /* Center: Segmented Navigation */
    .admin-nav-segmented {
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 10px;
      padding: 4px;
      gap: 4px;
    }

    .admin-nav-tab {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 18px;
      border-radius: 7px;
      font-size: 0.82rem;
      font-weight: 600;
      color: #94A3B8;
      text-decoration: none;
      transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .admin-nav-tab i {
      font-size: 0.88rem;
    }

    .admin-nav-tab:hover {
      color: #FFFFFF;
      background: rgba(255, 255, 255, 0.07);
    }

    .admin-nav-tab.active {
      color: #FFFFFF;
      background: var(--admin-navy-surface);
      border: 1px solid var(--admin-navy-border);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    }

    .admin-nav-tab.active i {
      color: var(--admin-gold);
    }

    /* Right: Utilities & User Profile */
    .admin-right-tools {
      display: flex;
      align-items: center;
      gap: 18px;
      flex-shrink: 0;
    }

    .btn-view-store {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 0.78rem;
      font-weight: 600;
      color: #93C5FD;
      padding: 7px 14px;
      border-radius: 6px;
      background: rgba(59, 130, 246, 0.1);
      border: 1px solid rgba(59, 130, 246, 0.25);
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .btn-view-store:hover {
      background: rgba(59, 130, 246, 0.2);
      color: #BFDBFE;
      transform: translateY(-1px);
    }

    .admin-user-card {
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.1);
      padding: 6px 14px 6px 8px;
      border-radius: 30px;
      font-size: 0.8rem;
    }

    .admin-user-avatar {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: var(--admin-gold);
      color: var(--admin-navy-deep);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      font-weight: 700;
    }

    .admin-user-name {
      font-weight: 600;
      color: #F1F5F9;
    }

    .admin-user-role {
      font-size: 0.68rem;
      color: var(--admin-gold);
      margin-left: 4px;
    }

    .btn-logout-styled {
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.25);
      color: #FCA5A5;
      padding: 7px 14px;
      border-radius: 6px;
      font-size: 0.78rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s ease;
    }

    .btn-logout-styled:hover {
      background: #EF4444;
      color: #FFFFFF;
      border-color: #EF4444;
      transform: translateY(-1px);
    }

    /* Content Area */
    .admin-workspace {
      flex: 1;
      padding: 36px 0 60px;
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
      background: #09101C;
      border-top: 1px solid rgba(255, 255, 255, 0.07);
      color: #64748B;
      font-size: 0.78rem;
      padding: 18px 36px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
  </style>
  @stack('styles')
</head>
<body>

  <!-- ADMIN FLUID TOPBAR -->
  <header class="admin-navbar">
    <div class="admin-header-fluid">
      
      <!-- Brand & Scope Identity -->
      <div class="admin-brand-group">
        <div class="admin-logo-mark">
          <img src="{{ asset('images/logo.png') }}" alt="Bianca Veana Logo">
        </div>
        <div class="admin-title-wrap">
          <a href="{{ route('admin.index') }}" style="text-decoration: none;">
            <h1 class="admin-brand-name">BIANCA VEANA</h1>
          </a>
          <span class="admin-scope-badge">
            <i class="fa-solid fa-shield-halved"></i> CONTROL CENTER
          </span>
        </div>
      </div>

      <!-- Segmented Navigation (Center) -->
      <nav class="admin-nav-segmented">
        <a href="{{ route('admin.index') }}" class="admin-nav-tab {{ request()->routeIs('admin.index') ? 'active' : '' }}">
          <i class="fa-solid fa-chart-line"></i> Ringkasan Toko
        </a>
        <a href="{{ route('admin.products') }}" class="admin-nav-tab {{ (request()->routeIs('admin.products') || request()->routeIs('admin.products.edit') || request()->routeIs('admin.products.create')) ? 'active' : '' }}">
          <i class="fa-solid fa-boxes-stacked"></i> Stok & Produk
        </a>
        <a href="{{ route('admin.ebook_parts.hub') }}" class="admin-nav-tab {{ request()->routeIs('admin.ebook_parts*') || request()->routeIs('admin.products.parts*') ? 'active' : '' }}">
          <i class="fa-solid fa-layer-group"></i> Serial & Part
        </a>
        <a href="{{ route('admin.orders') }}" class="admin-nav-tab {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
          <i class="fa-solid fa-receipt"></i> Pesanan
        </a>
        <a href="{{ route('admin.customers.index') }}" class="admin-nav-tab {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
          <i class="fa-solid fa-users"></i> Customer
        </a>
        <a href="{{ route('admin.chat.index') }}" class="admin-nav-tab {{ request()->routeIs('admin.chat*') ? 'active' : '' }}">
          <i class="fa-solid fa-comments"></i> Live Chat
        </a>
        <a href="{{ route('admin.videos') }}" class="admin-nav-tab {{ request()->routeIs('admin.videos*') ? 'active' : '' }}">
          <i class="fa-solid fa-film"></i> Video
        </a>
      </nav>

      <!-- Right Actions: View Store & Profile -->
      <div class="admin-right-tools">
        <a href="{{ route('home') }}" target="_blank" class="btn-view-store" title="Buka Toko Customer">
          <i class="fa-solid fa-arrow-up-right-from-square"></i> Toko Customer
        </a>

        @if(Auth::guard('admin')->check())
          <div class="admin-user-card">
            <div class="admin-user-avatar">
              {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
            </div>
            <div>
              <span class="admin-user-name">{{ Auth::guard('admin')->user()->name }}</span>
              <span class="admin-user-role">· Admin</span>
            </div>
          </div>

          <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-logout-styled" title="Keluar">
              <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
            </button>
          </form>
        @endif
      </div>

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
      <span>Versi: 2.4 Luxury Pro</span>
      <span>Enkripsi: Bcrypt 12R</span>
      <span>Database: Aktif</span>
    </div>
  </footer>

  @stack('scripts')
</body>
</html>
