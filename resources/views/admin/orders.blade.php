@extends('layouts.admin')

@section('title', 'Kelola Pesanan & Monitoring Pendapatan — Admin BIANCA VEANA')

@section('content')
<div class="admin-container" style="max-width: 1400px; margin: 0 auto; padding-bottom: 60px;">

  <!-- Header Halaman -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 20px;">
    <div>
      <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold); display: block; margin-bottom: 4px;">
        MONITORING & PENGIRIMAN
      </span>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 6px; font-weight: 700;">
        Pesanan & Pendapatan Penjualan
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Monitoring omzet novel cetak, serial e-book digital, dan merchandise resmi dengan filter rentang tanggal.
      </p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
      <button type="button" onclick="location.reload()" class="btn" style="background: #FFFFFF; border: 1px solid #CBD5E1; color: #334155; padding: 9px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.03);" title="Muat Ulang Pesanan Terbaru">
        <i class="fa-solid fa-arrows-rotate" style="color: #64748B;"></i> Refresh
      </button>

      <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 9px 16px; border-radius: 8px; font-size: 0.82rem; color: #1E293B; display: flex; align-items: center; gap: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
        <i class="fa-solid fa-receipt" style="color: var(--admin-gold);"></i> Total: <strong>{{ $orders->total() }} Pesanan</strong>
      </div>
    </div>
  </div>

  @php
    $todayStr = now()->toDateString();
    $sevenDaysAgo = now()->subDays(6)->toDateString();
    $startOfMonth = now()->startOfMonth()->toDateString();

    $isToday = ($startDate === $todayStr && $endDate === $todayStr);
    $is7Days = ($startDate === $sevenDaysAgo && $endDate === $todayStr);
    $isMonth = ($startDate === $startOfMonth && $endDate === $todayStr);
    $isAllTime = empty($startDate) && empty($endDate);

    $totalRev = $totalPeriodRevenue > 0 ? $totalPeriodRevenue : 1;
    $novelPct = round(($categoryBreakdown['novel']['revenue'] / $totalRev) * 100, 1);
    $ebookPct = round(($categoryBreakdown['ebook']['revenue'] / $totalRev) * 100, 1);
    $merchPct = round(($categoryBreakdown['merchandise']['revenue'] / $totalRev) * 100, 1);
  @endphp

  <!-- BAR FILTER TANGGAL & QUICK PRESETS -->
  <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; padding: 18px 22px; margin-bottom: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
    <form method="GET" action="{{ route('admin.orders') }}" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px;">
      <input type="hidden" name="category" value="{{ $selectedCategory }}">
      <input type="hidden" name="status" value="{{ $statusFilter }}">
      @if($search)
        <input type="hidden" name="search" value="{{ $search }}">
      @endif

      <!-- Left: Date Inputs & Submit -->
      <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #0F172A; font-size: 0.85rem;">
          <i class="fa-regular fa-calendar-days" style="color: var(--admin-gold); font-size: 1.1rem;"></i>
          <span>Rentang Tanggal:</span>
        </div>

        <div style="display: flex; align-items: center; gap: 6px;">
          <input type="date" name="start_date" value="{{ $startDate }}" style="padding: 7px 12px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.82rem; color: #1E293B; background: #F8FAFC; outline: none;" title="Tanggal Mulai">
          <span style="color: #94A3B8; font-size: 0.8rem; font-weight: 600;">s/d</span>
          <input type="date" name="end_date" value="{{ $endDate }}" style="padding: 7px 12px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.82rem; color: #1E293B; background: #F8FAFC; outline: none;" title="Tanggal Akhir">
        </div>

        <button type="submit" class="btn btn-gold" style="padding: 8px 16px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px;">
          <i class="fa-solid fa-filter"></i> Filter
        </button>

        @if($startDate || $endDate)
          <a href="{{ route('admin.orders', array_merge(request()->except(['start_date', 'end_date', 'page']))) }}" style="color: #EF4444; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 4px; padding: 6px 10px; border-radius: 6px; background: #FEF2F2;" title="Hapus Filter Tanggal">
            <i class="fa-solid fa-xmark"></i> Reset Tanggal
          </a>
        @endif
      </div>

      <!-- Right: Presets -->
      <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
        <span style="font-size: 0.75rem; color: #64748B; font-weight: 600; margin-right: 4px;">Pilihan Cepat:</span>
        
        <a href="{{ route('admin.orders', array_merge(request()->query(), ['start_date' => $todayStr, 'end_date' => $todayStr, 'page' => 1])) }}"
           style="padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-decoration: none; transition: all 0.2s; {{ $isToday ? 'background: #0F172A; color: #FFFFFF; font-weight: 700; box-shadow: 0 2px 4px rgba(15,23,42,0.15);' : 'background: #F1F5F9; color: #475569; border: 1px solid #E2E8F0;' }}">
          Hari Ini
        </a>

        <a href="{{ route('admin.orders', array_merge(request()->query(), ['start_date' => $sevenDaysAgo, 'end_date' => $todayStr, 'page' => 1])) }}"
           style="padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-decoration: none; transition: all 0.2s; {{ $is7Days ? 'background: #0F172A; color: #FFFFFF; font-weight: 700; box-shadow: 0 2px 4px rgba(15,23,42,0.15);' : 'background: #F1F5F9; color: #475569; border: 1px solid #E2E8F0;' }}">
          7 Hari Terakhir
        </a>

        <a href="{{ route('admin.orders', array_merge(request()->query(), ['start_date' => $startOfMonth, 'end_date' => $todayStr, 'page' => 1])) }}"
           style="padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-decoration: none; transition: all 0.2s; {{ $isMonth ? 'background: #0F172A; color: #FFFFFF; font-weight: 700; box-shadow: 0 2px 4px rgba(15,23,42,0.15);' : 'background: #F1F5F9; color: #475569; border: 1px solid #E2E8F0;' }}">
          Bulan Ini
        </a>

        <a href="{{ route('admin.orders', array_merge(request()->except(['start_date', 'end_date', 'page']))) }}"
           style="padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-decoration: none; transition: all 0.2s; {{ $isAllTime ? 'background: #0F172A; color: #FFFFFF; font-weight: 700; box-shadow: 0 2px 4px rgba(15,23,42,0.15);' : 'background: #F1F5F9; color: #475569; border: 1px solid #E2E8F0;' }}">
          Semua Waktu
        </a>
      </div>
    </form>

    <!-- Keterangan Periode Aktif -->
    <div style="margin-top: 12px; padding-top: 10px; border-top: 1px dashed #E2E8F0; font-size: 0.76rem; color: #64748B; display: flex; align-items: center; gap: 6px;">
      <i class="fa-solid fa-chart-line" style="color: var(--admin-gold);"></i>
      <span>Status Monitoring: 
        <strong style="color: #0F172A;">
          @if($isToday)
            Penjualan Hari Ini ({{ \Carbon\Carbon::parse($todayStr)->format('d F Y') }})
          @elseif($is7Days)
            7 Hari Terakhir ({{ \Carbon\Carbon::parse($sevenDaysAgo)->format('d M') }} – {{ \Carbon\Carbon::parse($todayStr)->format('d M Y') }})
          @elseif($isMonth)
            Bulan Ini ({{ \Carbon\Carbon::parse($startOfMonth)->format('d M') }} – {{ \Carbon\Carbon::parse($todayStr)->format('d M Y') }})
          @elseif($startDate && $endDate)
            Periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
          @elseif($startDate)
            Sejak {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
          @elseif($endDate)
            Sampai {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
          @else
            Akumulasi Seluruh Waktu Transaksi (All-Time)
          @endif
        </strong>
        (Hanya menghitung transaksi lunas/terverifikasi)
      </span>
    </div>
  </div>

  <!-- 4 KARTU MONITORING PENDAPATAN & KATEGORI -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 24px;">

    <!-- KARTU 1: TOTAL PENDAPATAN TERVERIFIKASI -->
    <div style="background: linear-gradient(135deg, #0B1424 0%, #15233C 100%); border: 1px solid rgba(198, 161, 107, 0.4); border-radius: 12px; padding: 20px 22px; color: #FFF; position: relative; overflow: hidden; box-shadow: 0 4px 12px rgba(11, 20, 36, 0.15);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
        <div>
          <span style="font-size: 0.72rem; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 700; color: #EBD4B2;">TOTAL PENDAPATAN</span>
          <div style="font-size: 1.65rem; font-weight: 800; color: #FFFFFF; font-family: var(--font-display); margin-top: 4px; letter-spacing: -0.5px;">
            Rp {{ number_format($totalPeriodRevenue, 0, ',', '.') }}
          </div>
        </div>
        <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(198, 161, 107, 0.2); border: 1px solid rgba(198, 161, 107, 0.35); display: flex; align-items: center; justify-content: center; color: var(--admin-gold); font-size: 1.15rem;">
          <i class="fa-solid fa-sack-dollar"></i>
        </div>
      </div>
      <div style="display: flex; align-items: center; gap: 8px; font-size: 0.78rem; color: #CBD5E1; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
        <span style="background: rgba(16, 185, 129, 0.2); color: #34D399; font-weight: 700; padding: 2px 7px; border-radius: 4px; font-size: 0.7rem;">
          <i class="fa-solid fa-circle-check"></i> Lunas
        </span>
        <span><strong>{{ $totalPeriodOrdersCount }}</strong> Pesanan Terverifikasi Masuk</span>
      </div>
    </div>

    <!-- KARTU 2: BUKU FISIK (NOVEL) -->
    <div style="background: #FFFFFF; border: 1px solid #BFDBFE; border-top: 4px solid #2563EB; border-radius: 12px; padding: 18px 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
        <div>
          <div style="display: flex; align-items: center; gap: 6px;">
            <span style="font-size: 0.7rem; letter-spacing: 1.2px; text-transform: uppercase; font-weight: 700; color: #1D4ED8;">NOVEL CETAK</span>
            <span style="font-size: 0.68rem; background: #DBEAFE; color: #1E40AF; padding: 1px 6px; border-radius: 4px; font-weight: 700;">{{ $novelPct }}%</span>
          </div>
          <div style="font-size: 1.45rem; font-weight: 800; color: #0F172A; margin-top: 4px;">
            Rp {{ number_format($categoryBreakdown['novel']['revenue'], 0, ',', '.') }}
          </div>
        </div>
        <div style="width: 38px; height: 38px; border-radius: 8px; background: #EFF6FF; border: 1px solid #BFDBFE; display: flex; align-items: center; justify-content: center; color: #1D4ED8; font-size: 1rem;">
          <i class="fa-solid fa-book-open"></i>
        </div>
      </div>
      <div style="font-size: 0.78rem; color: #64748B; border-top: 1px solid #F1F5F9; padding-top: 8px; display: flex; justify-content: space-between;">
        <span><strong style="color: #0F172A;">{{ $categoryBreakdown['novel']['items_sold'] }}</strong> Buku Terjual</span>
        <span><strong style="color: #0F172A;">{{ $categoryBreakdown['novel']['orders_count'] }}</strong> Pesanan</span>
      </div>
    </div>

    <!-- KARTU 3: SERIAL E-BOOK (DIGITAL) -->
    <div style="background: #FFFFFF; border: 1px solid #BBF7D0; border-top: 4px solid #16A34A; border-radius: 12px; padding: 18px 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
        <div>
          <div style="display: flex; align-items: center; gap: 6px;">
            <span style="font-size: 0.7rem; letter-spacing: 1.2px; text-transform: uppercase; font-weight: 700; color: #15803D;">SERIAL E-BOOK</span>
            <span style="font-size: 0.68rem; background: #DCFCE7; color: #15803D; padding: 1px 6px; border-radius: 4px; font-weight: 700;">{{ $ebookPct }}%</span>
          </div>
          <div style="font-size: 1.45rem; font-weight: 800; color: #0F172A; margin-top: 4px;">
            Rp {{ number_format($categoryBreakdown['ebook']['revenue'], 0, ',', '.') }}
          </div>
        </div>
        <div style="width: 38px; height: 38px; border-radius: 8px; background: #F0FDF4; border: 1px solid #BBF7D0; display: flex; align-items: center; justify-content: center; color: #16A34A; font-size: 1rem;">
          <i class="fa-solid fa-book-bookmark"></i>
        </div>
      </div>
      <div style="font-size: 0.78rem; color: #64748B; border-top: 1px solid #F1F5F9; padding-top: 8px; display: flex; justify-content: space-between;">
        <span><strong style="color: #0F172A;">{{ $categoryBreakdown['ebook']['items_sold'] }}</strong> Bab/Akses Terjual</span>
        <span><strong style="color: #0F172A;">{{ $categoryBreakdown['ebook']['orders_count'] }}</strong> Pesanan</span>
      </div>
    </div>

    <!-- KARTU 4: MERCHANDISE RESMI -->
    <div style="background: #FFFFFF; border: 1px solid #E9D5FF; border-top: 4px solid #9333EA; border-radius: 12px; padding: 18px 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
        <div>
          <div style="display: flex; align-items: center; gap: 6px;">
            <span style="font-size: 0.7rem; letter-spacing: 1.2px; text-transform: uppercase; font-weight: 700; color: #7E22CE;">MERCHANDISE</span>
            <span style="font-size: 0.68rem; background: #F3E8FF; color: #7E22CE; padding: 1px 6px; border-radius: 4px; font-weight: 700;">{{ $merchPct }}%</span>
          </div>
          <div style="font-size: 1.45rem; font-weight: 800; color: #0F172A; margin-top: 4px;">
            Rp {{ number_format($categoryBreakdown['merchandise']['revenue'], 0, ',', '.') }}
          </div>
        </div>
        <div style="width: 38px; height: 38px; border-radius: 8px; background: #FAF5FF; border: 1px solid #E9D5FF; display: flex; align-items: center; justify-content: center; color: #9333EA; font-size: 1rem;">
          <i class="fa-solid fa-crown"></i>
        </div>
      </div>
      <div style="font-size: 0.78rem; color: #64748B; border-top: 1px solid #F1F5F9; padding-top: 8px; display: flex; justify-content: space-between;">
        <span><strong style="color: #0F172A;">{{ $categoryBreakdown['merchandise']['items_sold'] }}</strong> Item Terjual</span>
        <span><strong style="color: #0F172A;">{{ $categoryBreakdown['merchandise']['orders_count'] }}</strong> Pesanan</span>
      </div>
    </div>

  </div>

  <!-- KONTROL TAB KATEGORI & PENCARIAN PESANAN -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 14px;">
    
    <!-- Tab Filter Kategori -->
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
      <a href="{{ route('admin.orders', array_merge(request()->query(), ['category' => 'all', 'page' => 1])) }}"
         style="padding: 8px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; {{ $selectedCategory === 'all' ? 'background: #0F172A; color: #FFF; box-shadow: 0 2px 4px rgba(0,0,0,0.1);' : 'background: #FFF; color: #475569; border: 1px solid #CBD5E1;' }}">
        <i class="fa-solid fa-shapes"></i> Semua Kategori
      </a>
      <a href="{{ route('admin.orders', array_merge(request()->query(), ['category' => 'novel', 'page' => 1])) }}"
         style="padding: 8px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; {{ $selectedCategory === 'novel' ? 'background: #1D4ED8; color: #FFF; box-shadow: 0 2px 4px rgba(29,78,216,0.25);' : 'background: #FFF; color: #1D4ED8; border: 1px solid #BFDBFE;' }}">
        <i class="fa-solid fa-book-open"></i> Novel Cetak
      </a>
      <a href="{{ route('admin.orders', array_merge(request()->query(), ['category' => 'ebook', 'page' => 1])) }}"
         style="padding: 8px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; {{ $selectedCategory === 'ebook' ? 'background: #15803D; color: #FFF; box-shadow: 0 2px 4px rgba(21,128,61,0.25);' : 'background: #FFF; color: #15803D; border: 1px solid #BBF7D0;' }}">
        <i class="fa-solid fa-book-bookmark"></i> Serial E-Book
      </a>
      <a href="{{ route('admin.orders', array_merge(request()->query(), ['category' => 'merchandise', 'page' => 1])) }}"
         style="padding: 8px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; {{ $selectedCategory === 'merchandise' ? 'background: #7E22CE; color: #FFF; box-shadow: 0 2px 4px rgba(126,34,206,0.25);' : 'background: #FFF; color: #7E22CE; border: 1px solid #E9D5FF;' }}">
        <i class="fa-solid fa-crown"></i> Merchandise
      </a>
    </div>

    <!-- Filter Status & Form Pencarian -->
    <form method="GET" action="{{ route('admin.orders') }}" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
      @if($startDate) <input type="hidden" name="start_date" value="{{ $startDate }}"> @endif
      @if($endDate) <input type="hidden" name="end_date" value="{{ $endDate }}"> @endif
      <input type="hidden" name="category" value="{{ $selectedCategory }}">

      <!-- Dropdown Filter Status -->
      <select name="status" onchange="this.form.submit()" style="padding: 8px 12px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.8rem; background: #FFF; color: #1E293B; font-weight: 600; outline: none; cursor: pointer;">
        <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>Semua Status</option>
        <option value="paid" {{ $statusFilter === 'paid' ? 'selected' : '' }}>✓ Lunas (Paid)</option>
        <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>⏳ Menunggu Bayar</option>
        <option value="processing" {{ $statusFilter === 'processing' ? 'selected' : '' }}>📦 Sedang Dikemas</option>
        <option value="shipped" {{ $statusFilter === 'shipped' ? 'selected' : '' }}>🚚 Sedang Dikirim</option>
        <option value="delivered" {{ $statusFilter === 'delivered' ? 'selected' : '' }}>✅ Selesai</option>
        <option value="cancelled" {{ $statusFilter === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
      </select>

      <!-- Input Pencarian Teks -->
      <div style="position: relative;">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari invoice, nama, no hp, resi..." style="padding: 8px 12px 8px 32px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.8rem; width: 220px; outline: none; background: #FFF;">
        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94A3B8; font-size: 0.8rem;"></i>
      </div>

      <button type="submit" class="btn" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #334155; padding: 8px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
        Cari
      </button>

      @if($search || $statusFilter !== 'all')
        <a href="{{ route('admin.orders', array_merge(request()->except(['search', 'status', 'page']))) }}" style="color: #64748B; font-size: 0.78rem; text-decoration: underline; margin-left: 4px;" title="Reset Pencarian & Status">
          Reset
        </a>
      @endif
    </form>
  </div>

  <!-- TABEL PESANAN -->
  <div class="admin-card" style="box-shadow: 0 1px 3px rgba(0,0,0,0.05); border-radius: 12px; overflow: hidden; background: #FFFFFF; border: 1px solid #E2E8F0;">
    <div style="overflow-x: auto;">
      <table class="admin-table" style="width: 100%; border-collapse: collapse;">
        <thead>
          <tr style="background: var(--ivory); color: var(--ocean-navy); border-bottom: 1px solid var(--soft-beige);">
            <th style="padding: 14px 20px; text-align: left; font-size: 0.82rem;">Pesanan</th>
            <th style="padding: 14px 20px; text-align: left; font-size: 0.82rem;">Data Penerima & Alamat</th>
            <th style="padding: 14px 20px; text-align: left; font-size: 0.82rem;">Daftar Item & Kategori</th>
            <th style="padding: 14px 20px; text-align: right; font-size: 0.82rem;">Total Biaya</th>
            <th style="padding: 14px 20px; text-align: center; font-size: 0.82rem;">Status & Resi</th>
            <th style="padding: 14px 20px; text-align: center; font-size: 0.82rem;">Aksi Penjual</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
            @php
              $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
              if (str_starts_with($cleanPhone, '0')) {
                  $cleanPhone = '62' . substr($cleanPhone, 1);
              }
              $itemsList = $order->items->map(fn($i) => $i->product_title . " (x{$i->quantity})")->implode(', ');
              $trackingUrl = "https://cekresi.com/?noresi=" . urlencode($order->tracking_number);

              $waText = "Halo Kak {$order->customer_name}! 👋\n\n"
                  . "Kabar baik dari *Bianca Veana Official Bookstore* ✨\n"
                  . "Pesanan buku Anda dengan invoice *#{$order->order_number}* telah diserahkan ke kurir dan *SEDANG DALAM PERJALANAN* 🚚\n\n"
                  . "📦 *Daftar Buku:* {$itemsList}\n"
                  . "🚚 *Ekspedisi:* {$order->courier}\n"
                  . "🏷️ *Nomor Resi Resmi:* {$order->tracking_number}\n"
                  . "📍 *Alamat Tujuan:* {$order->shipping_address}, {$order->city}\n\n"
                  . "🔍 Lacak perjalanan paket Anda secara real-time di:\n{$trackingUrl}\n\n"
                  . "Terima kasih banyak telah mengoleksi karya resmi Bianca Veana Universe! Selamat membaca! 📖";
              $waUrl = "https://wa.me/{$cleanPhone}?text=" . rawurlencode($waText);
            @endphp
            <tr style="border-bottom: 1px solid #F1F5F9;">
              <td style="padding: 16px 20px; vertical-align: top;">
                <strong style="color: var(--ocean-navy); font-size: 0.95rem;">#{{ $order->order_number }}</strong>
                <div style="font-size: 0.78rem; color: #1E293B; margin-top: 4px; font-weight: 600; display: flex; align-items: center; gap: 5px;">
                  <i class="fa-regular fa-clock" style="color: #64748B;"></i> {{ $order->created_at->format('d M Y, H:i') }} WIB
                </div>
                <div style="font-size: 0.7rem; color: #059669; font-weight: 600; margin-top: 2px; display: flex; align-items: center; gap: 4px;">
                  <i class="fa-solid fa-stopwatch" style="font-size: 0.68rem;"></i> {{ $order->created_at->diffForHumans() }}
                </div>
                <div style="font-size: 0.75rem; color: #15803D; font-weight: 600; margin-top: 6px;">
                  <i class="fa-solid fa-check-double"></i> {{ $order->payment_method }}
                  @if($order->payment_status === 'paid')
                    <span style="background: #DCFCE7; color: #15803D; font-size: 0.68rem; font-weight: 700; padding: 1px 6px; border-radius: 4px; margin-left: 4px;">Lunas</span>
                  @else
                    <span style="background: #FEF3C7; color: #B45309; font-size: 0.68rem; font-weight: 700; padding: 1px 6px; border-radius: 4px; margin-left: 4px;">{{ ucfirst($order->payment_status) }}</span>
                  @endif
                </div>
              </td>

              <td style="padding: 16px 20px; vertical-align: top; max-width: 250px;">
                <strong style="color: #0F172A; font-size: 0.9rem;">{{ $order->customer_name }}</strong>
                <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 2px;">
                  <i class="fa-brands fa-whatsapp" style="color: #16A34A;"></i> {{ $order->customer_phone }}
                </div>
                @if(str_contains($order->shipping_address, 'Digital') || $order->courier === 'Digital Delivery (Email Langsung)')
                  <div style="font-size: 0.78rem; color: #1E40AF; margin-top: 4px; font-weight: 600;">
                    <i class="fa-solid fa-envelope"></i> {{ $order->customer_email }}
                  </div>
                  <div style="font-size: 0.72rem; background: #DBEAFE; color: #1E40AF; display: inline-block; padding: 2px 8px; border-radius: 4px; margin-top: 6px; font-weight: 700;">
                    <i class="fa-solid fa-bolt"></i> Akses Digital Instan
                  </div>
                @else
                  <div style="font-size: 0.78rem; color: var(--text-dark); margin-top: 4px; line-height: 1.4;">
                    {{ $order->shipping_address }}, {{ $order->city }}
                  </div>
                  <div style="font-size: 0.72rem; background: var(--ivory); border: 1px solid #E2E8F0; display: inline-block; padding: 2px 8px; border-radius: 4px; margin-top: 6px; font-weight: 600; color: var(--ocean-navy);">
                    <i class="fa-solid fa-truck"></i> {{ $order->courier }}
                  </div>
                @endif
              </td>

              <!-- Kolom Daftar Item & Label Kategori -->
              <td style="padding: 16px 20px; vertical-align: top;">
                <ul style="list-style: none; font-size: 0.82rem; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                  @foreach($order->items as $it)
                    @php
                      $itemCat = $it->product ? $it->product->category : 'novel';
                      $catBadge = match($itemCat) {
                        'ebook' => ['bg' => '#ECFDF5', 'border' => '#A7F3D0', 'color' => '#065F46', 'label' => 'E-BOOK', 'icon' => 'fa-book-bookmark'],
                        'merchandise' => ['bg' => '#FAF5FF', 'border' => '#E9D5FF', 'color' => '#6B21A8', 'label' => 'MERCH', 'icon' => 'fa-crown'],
                        default => ['bg' => '#EFF6FF', 'border' => '#BFDBFE', 'color' => '#1E40AF', 'label' => 'NOVEL', 'icon' => 'fa-book-open'],
                      };
                    @endphp
                    <li style="display: flex; align-items: flex-start; gap: 6px;">
                      <span style="background: {{ $catBadge['bg'] }}; border: 1px solid {{ $catBadge['border'] }}; color: {{ $catBadge['color'] }}; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; letter-spacing: 0.5px; white-space: nowrap; margin-top: 1px;">
                        <i class="fa-solid {{ $catBadge['icon'] }}" style="font-size: 0.6rem; margin-right: 2px;"></i>{{ $catBadge['label'] }}
                      </span>
                      <div style="line-height: 1.35;">
                        <strong style="color: #1E293B;">{{ $it->product_title }}</strong>
                        <span style="color: #64748B; font-size: 0.76rem;"> (×{{ $it->quantity }}) — Rp {{ number_format($it->subtotal, 0, ',', '.') }}</span>
                      </div>
                    </li>
                  @endforeach
                </ul>
              </td>

              <td style="padding: 16px 20px; text-align: right; vertical-align: top; font-weight: 700; color: var(--ocean-navy); font-size: 0.95rem;">
                {{ $order->formatted_total }}
              </td>

              <td style="padding: 16px 20px; text-align: center; vertical-align: top;">
                @php
                  $statusColors = [
                      'pending' => ['bg' => '#FEF3C7', 'color' => '#B45309', 'label' => 'Menunggu Bayar'],
                      'processing' => ['bg' => '#DBEAFE', 'color' => '#1E40AF', 'label' => 'Sedang Dikemas'],
                      'shipped' => ['bg' => '#F3E8FF', 'color' => '#7E22CE', 'label' => 'Sedang Dikirim'],
                      'delivered' => ['bg' => '#DCFCE7', 'color' => '#15803D', 'label' => 'Selesai / Tiba'],
                      'cancelled' => ['bg' => '#FEE2E2', 'color' => '#B91C1C', 'label' => 'Dibatalkan'],
                  ];
                  $st = $statusColors[strtolower($order->order_status)] ?? ['bg' => '#F1F5F9', 'color' => '#334155', 'label' => ucfirst($order->order_status)];
                  $hasRealCourierResi = $order->tracking_number && $order->tracking_number !== 'DIGITAL-ACCESS' && $order->tracking_number !== $order->order_number && !str_starts_with($order->tracking_number, 'BV-');
                @endphp

                <span style="background: {{ $st['bg'] }}; color: {{ $st['color'] }}; padding: 4px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; display: inline-block;">
                  {{ $st['label'] }}
                </span>

                @if($hasRealCourierResi)
                  <div style="font-size: 0.78rem; background: #FFFFFF; border: 1.5px solid #CBD5E1; padding: 5px 8px; border-radius: 6px; margin-top: 8px; font-weight: 700; color: var(--ocean-navy); display: flex; align-items: center; justify-content: space-between; gap: 4px;">
                    <span style="letter-spacing: 0.5px;">{{ $order->tracking_number }}</span>
                    <button type="button" onclick="navigator.clipboard.writeText('{{ $order->tracking_number }}'); alert('Resi disalin: {{ $order->tracking_number }}')" style="background: none; border: none; cursor: pointer; color: #64748B; padding: 2px;" title="Salin Nomor Resi">
                      <i class="fa-regular fa-copy"></i>
                    </button>
                  </div>
                  <div style="margin-top: 4px;">
                    <a href="{{ $trackingUrl }}" target="_blank" style="font-size: 0.7rem; color: #2563EB; text-decoration: underline; font-weight: 600;">
                      <i class="fa-solid fa-arrow-up-right-from-square"></i> Cek di CekResi.com
                    </a>
                  </div>
                @elseif(!str_contains($order->shipping_address, 'Digital') && $order->courier !== 'Digital Delivery (Email Langsung)')
                  <div style="font-size: 0.72rem; color: #94A3B8; margin-top: 6px;">
                    Resi: <em>Belum Diinput</em>
                  </div>
                @endif
              </td>

              <td style="padding: 16px 20px; text-align: center; vertical-align: top;">
                <div style="display: flex; flex-direction: column; gap: 6px; align-items: stretch; max-width: 170px; margin: 0 auto;">
                  <!-- Tombol Update Resi & Status -->
                  <button type="button" onclick="openResiModal('{{ $order->order_number }}', '{{ addslashes($order->customer_name) }}', '{{ $order->order_status }}', '{{ $order->tracking_number }}', '{{ addslashes($order->courier) }}')" class="btn" style="background: #EEF2FF; color: #4338CA; border: 1px solid #C7D2FE; padding: 6px 10px; font-size: 0.75rem; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 6px; cursor: pointer;">
                    <i class="fa-solid fa-truck-fast"></i> Input / Ganti Resi
                  </button>

                  <!-- Tombol Kirim WhatsApp Resi -->
                  @if($order->customer_phone && $hasRealCourierResi)
                    <a href="{{ $waUrl }}" target="_blank" class="btn" style="background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; padding: 6px 10px; font-size: 0.75rem; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none;" title="Kirim otomatis rincian nomor resi ke WhatsApp Customer">
                      <i class="fa-brands fa-whatsapp" style="font-size: 0.9rem;"></i> Kirim Resi via WA
                    </a>
                  @endif

                  <!-- Tombol Cetak Resi -->
                  <a href="{{ route('admin.orders.resi', $order->order_number) }}" target="_blank" class="btn btn-gold" style="padding: 6px 10px; font-size: 0.75rem; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none;">
                    <i class="fa-solid fa-print"></i> Cetak Label Resi
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="padding: 60px 20px; text-align: center; color: #64748B;">
                <div style="font-size: 2.8rem; color: #CBD5E1; margin-bottom: 12px;">
                  <i class="fa-regular fa-folder-open"></i>
                </div>
                <h4 style="margin: 0 0 6px; color: #1E293B; font-size: 1.1rem; font-weight: 700;">Tidak Ada Pesanan Ditemukan</h4>
                <p style="margin: 0; font-size: 0.85rem; color: #64748B;">
                  Tidak ada data yang cocok dengan rentang tanggal, kategori, atau kata kunci pencarian yang dipilih.
                </p>
                <div style="margin-top: 16px;">
                  <a href="{{ route('admin.orders') }}" class="btn" style="background: #0F172A; color: #FFF; padding: 8px 18px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-rotate-left"></i> Tampilkan Semua Pesanan
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div style="padding: 20px; border-top: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
      <div style="font-size: 0.8rem; color: #64748B;">
        Menampilkan <strong>{{ $orders->firstItem() ?? 0 }}</strong> - <strong>{{ $orders->lastItem() ?? 0 }}</strong> dari total <strong>{{ $orders->total() }}</strong> pesanan
      </div>
      <div>
        {{ $orders->links() }}
      </div>
    </div>
  </div>
</div>

<!-- Modal Update Resi & Status -->
<div id="modalUpdateResi" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
  <div style="background: #FFFFFF; border-radius: 14px; width: 100%; max-width: 500px; padding: 28px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid #E2E8F0; position: relative;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #F1F5F9; padding-bottom: 14px;">
      <h3 style="margin: 0; font-size: 1.15rem; color: #0F172A; font-family: var(--font-serif); display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-truck-fast" style="color: #D4AF37;"></i> Input / Ganti Resi & Status
      </h3>
      <button type="button" onclick="closeResiModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; cursor: pointer; color: #94A3B8; padding: 0 4px;" title="Tutup">&times;</button>
    </div>

    <form id="formUpdateResi" method="POST" action="">
      @csrf
      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Invoice & Penerima</label>
        <div id="modalOrderInfo" style="background: #F8FAFC; border: 1.5px solid #E2E8F0; padding: 10px 14px; border-radius: 8px; font-size: 0.88rem; color: #0F172A; font-weight: 600;"></div>
      </div>

      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Status Pengiriman</label>
        <select name="order_status" id="modalOrderStatus" style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; background: #FFF; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#CBD5E1'">
          <option value="pending">Menunggu Pembayaran (Pending)</option>
          <option value="processing">Sedang Dikemas (Processing)</option>
          <option value="shipped">Sedang Dikirim (Shipped)</option>
          <option value="delivered">Selesai / Terkirim (Delivered)</option>
          <option value="cancelled">Dibatalkan (Cancelled)</option>
        </select>
      </div>

      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
          Nomor Resi Asli Ekspedisi (JNE / SiCepat / J&T / Anteraja)
        </label>
        <input type="text" name="tracking_number" id="modalTrackingNumber" placeholder="Contoh: 004218991234 atau JNE1092837482" style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#CBD5E1'">
        <div style="font-size: 0.72rem; color: #64748B; margin-top: 4px;">
          *Masukkan nomor barcode/resi yang tercetak saat Anda menyerahkan paket ke agen kurir.
        </div>
      </div>

      <div style="margin-bottom: 22px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Nama Kurir / Layanan</label>
        <input type="text" name="courier" id="modalCourier" placeholder="Contoh: SiCepat Express (HALU) atau JNE REG" style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#CBD5E1'">
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" onclick="closeResiModal()" class="btn" style="background: #F1F5F9; color: #475569; padding: 10px 18px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; border: none;">Batal</button>
        <button type="submit" class="btn btn-gold" style="padding: 10px 22px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; cursor: pointer;">
          <i class="fa-solid fa-save"></i> Simpan & Update Resi
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openResiModal(orderNumber, customerName, currentStatus, currentTracking, currentCourier) {
  document.getElementById('formUpdateResi').action = '/admin/orders/' + orderNumber + '/status';
  document.getElementById('modalOrderInfo').textContent = '#' + orderNumber + ' — ' + customerName;
  document.getElementById('modalOrderStatus').value = currentStatus || 'processing';
  
  // Jangan isi jika resi masih dummy / default BV-
  let cleanTracking = currentTracking || '';
  if (cleanTracking === 'DIGITAL-ACCESS' || cleanTracking.startsWith('BV-')) {
    cleanTracking = '';
  }
  document.getElementById('modalTrackingNumber').value = cleanTracking;
  document.getElementById('modalCourier').value = currentCourier || '';
  
  const modal = document.getElementById('modalUpdateResi');
  modal.style.display = 'flex';
}

function closeResiModal() {
  document.getElementById('modalUpdateResi').style.display = 'none';
}

// Tutup modal jika klik di luar area box
window.addEventListener('click', function(e) {
  const modal = document.getElementById('modalUpdateResi');
  if (e.target === modal) {
    closeResiModal();
  }
});
</script>
@endsection
