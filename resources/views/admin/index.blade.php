@extends('layouts.admin')

@section('title', 'Admin Dashboard — BIANCA VEANA')

@section('content')
<div class="admin-container">
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 20px;">
    <div>
      <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold); display: block; margin-bottom: 4px;">
        OVERVIEW & ANALISIS PENJUALAN
      </span>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 6px; font-weight: 700;">
        Dashboard Ringkasan Toko
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Pantau performa penjualan novel cetak, e-book, merchandise, dan status pesanan hari ini.
      </p>
    </div>
    <div style="display: flex; gap: 12px;">
      <a href="{{ route('admin.orders') }}" class="btn btn-outline-gold" style="color: #0F172A; border-color: #CBD5E1; background: #FFF; font-size: 0.82rem; padding: 10px 18px;">
        <i class="fa-solid fa-boxes-packing"></i> Kelola Pesanan
      </a>
      <a href="{{ route('admin.products') }}" class="btn btn-gold" style="font-size: 0.82rem; padding: 10px 18px; font-weight: 700;">
        <i class="fa-solid fa-boxes-stacked"></i> Kontrol Stok & Harga
      </a>
    </div>
  </div>

  <!-- Stats Cards Grid -->
  <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 36px;">
    <!-- Stat 1 -->
    <div class="admin-card" style="padding: 24px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
        <span style="font-size: 0.78rem; color: #64748B; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Total Penjualan</span>
        <div style="width: 38px; height: 38px; border-radius: 8px; background: #ECFDF5; color: #059669; display: flex; align-items: center; justify-content: center;">
          <i class="fa-solid fa-rupiah-sign"></i>
        </div>
      </div>
      <div style="font-size: 1.7rem; font-weight: 700; color: #0F172A;">
        Rp {{ number_format($totalSales, 0, ',', '.') }}
      </div>
      <div style="font-size: 0.75rem; color: #059669; margin-top: 6px; font-weight: 600;">
        <i class="fa-solid fa-arrow-trend-up"></i> Terverifikasi Masuk
      </div>
    </div>

    <!-- Stat 2 -->
    <div class="admin-card" style="padding: 24px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
        <span style="font-size: 0.78rem; color: #64748B; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Total Pesanan</span>
        <div style="width: 38px; height: 38px; border-radius: 8px; background: #EEF2FF; color: #4F46E5; display: flex; align-items: center; justify-content: center;">
          <i class="fa-solid fa-cart-shopping"></i>
        </div>
      </div>
      <div style="font-size: 1.7rem; font-weight: 700; color: #0F172A;">
        {{ $totalOrders }} Pesanan
      </div>
      <div style="font-size: 0.75rem; color: #64748B; margin-top: 6px;">
        Novel & E-Book Masuk
      </div>
    </div>

    <!-- Stat 3 -->
    <div class="admin-card" style="padding: 24px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
        <span style="font-size: 0.78rem; color: #64748B; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Koleksi Buku & Item</span>
        <div style="width: 38px; height: 38px; border-radius: 8px; background: #FFFBEB; color: #D97706; display: flex; align-items: center; justify-content: center;">
          <i class="fa-solid fa-book"></i>
        </div>
      </div>
      <div style="font-size: 1.7rem; font-weight: 700; color: #0F172A;">
        {{ $totalProducts }} Judul
      </div>
      <div style="font-size: 0.75rem; color: #64748B; margin-top: 6px;">
        Aktif di Katalog Publik
      </div>
    </div>

    <!-- Stat 4 -->
    <div class="admin-card" style="padding: 24px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
        <span style="font-size: 0.78rem; color: #64748B; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Peringatan Stok</span>
        <div style="width: 38px; height: 38px; border-radius: 8px; background: #FEF2F2; color: #DC2626; display: flex; align-items: center; justify-content: center;">
          <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
      </div>
      <div style="font-size: 1.7rem; font-weight: 700; color: #0F172A;">
        {{ $lowStockCount }} Item Menipis
      </div>
      <div style="font-size: 0.75rem; color: #DC2626; margin-top: 6px; font-weight: 600;">
        Perlu restock cetak ulang
      </div>
    </div>
  </div>

  <!-- Quick Access Hub to Grouped E-Book Parts -->
  <!-- CATEGORY SALES BREAKDOWN (BUKU FISIK, SERIAL E-BOOK, MERCHANDISE) -->
  <div style="margin-bottom: 36px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
      <div>
        <h3 style="font-family: var(--font-display); font-size: 1.35rem; color: #0F172A; margin: 0 0 4px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-chart-pie" style="color: var(--admin-gold);"></i> Rincian Penjualan Berdasarkan Kategori Produk
        </h3>
        <p style="font-size: 0.82rem; color: #64748B; margin: 0;">
          Distribusi omzet dan kuantitas produk terverifikasi: Novel Fisik (Cetak), Serial E-Book Digital, dan Merchandise Resmi.
        </p>
      </div>
      <span style="font-size: 0.78rem; font-weight: 600; color: #059669; background: #ECFDF5; border: 1px solid #A7F3D0; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
        <i class="fa-solid fa-circle-check"></i> Status Terverifikasi Lunas
      </span>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
      @foreach(['novel', 'ebook', 'merchandise'] as $catKey)
        @php $cat = $categorySales[$catKey]; @endphp
        <div class="admin-card" style="padding: 24px; position: relative; border-top: 4px solid {{ $cat['bar_color'] }}; display: flex; flex-direction: column; justify-content: space-between;">
          <div>
            <!-- Top Badges & Icon -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
              <div>
                <span style="font-size: 0.68rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; padding: 4px 10px; border-radius: 4px; background: {{ $cat['bg'] }}; color: {{ $cat['color'] }}; border: 1px solid {{ $cat['border'] }};">
                  {{ $cat['badge'] }}
                </span>
                <h4 style="font-family: var(--font-display); font-size: 1.15rem; color: #0F172A; margin: 8px 0 0; font-weight: 700;">
                  {{ $cat['name'] }}
                </h4>
              </div>
              <div style="width: 44px; height: 44px; border-radius: 10px; background: {{ $cat['bg'] }}; color: {{ $cat['color'] }}; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; border: 1px solid {{ $cat['border'] }};">
                <i class="fa-solid {{ $cat['icon'] }}"></i>
              </div>
            </div>

            <!-- Revenue Figure -->
            <div style="margin-bottom: 14px;">
              <span style="font-size: 0.72rem; color: #64748B; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; display: block; margin-bottom: 2px;">
                Total Omzet Penjualan:
              </span>
              <div style="font-size: 1.65rem; font-weight: 800; color: #0F172A; line-height: 1.1;">
                Rp {{ number_format($cat['total'], 0, ',', '.') }}
              </div>
            </div>

            <!-- Progress Contribution Bar -->
            <div style="margin-bottom: 16px;">
              <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #64748B; margin-bottom: 6px; font-weight: 600;">
                <span>Kontribusi Penjualan</span>
                <strong style="color: {{ $cat['color'] }};">{{ $cat['percentage'] }}%</strong>
              </div>
              <div style="width: 100%; height: 8px; background: #F1F5F9; border-radius: 10px; overflow: hidden;">
                <div style="width: {{ $cat['percentage'] }}%; height: 100%; background: {{ $cat['bar_color'] }}; border-radius: 10px; transition: width 0.4s ease;"></div>
              </div>
            </div>
          </div>

          <!-- Quantity & Order Count Breakdown -->
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 12px 14px; display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; margin-top: 10px;">
            <div>
              <span style="color: #64748B; display: block; font-size: 0.7rem;">Kuantitas Terjual:</span>
              <strong style="color: #0F172A; font-size: 0.95rem;">{{ number_format($cat['qty'], 0, ',', '.') }} item</strong>
            </div>
            <div style="text-align: right;">
              <span style="color: #64748B; display: block; font-size: 0.7rem;">Frekuensi Pembelian:</span>
              <strong style="color: {{ $cat['color'] }}; font-size: 0.85rem;">{{ $cat['items_count'] }} transaksi</strong>
            </div>
          </div>

        </div>
      @endforeach
    </div>
  </div>

  <!-- Quick Access Hub to Serial E-Book -->
  <div style="background: linear-gradient(135deg, #172B49 0%, #203A5E 100%); color: #F4EBDD; border-radius: 10px; border: 1.5px solid var(--champagne-gold); padding: 22px 28px; margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; box-shadow: 0 4px 14px rgba(15,23,42,0.12);">
    <div style="display: flex; align-items: center; gap: 16px;">
      <div style="width: 48px; height: 48px; border-radius: 8px; background: rgba(198,161,107,0.2); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; border: 1px solid rgba(198,161,107,0.4);">
        <i class="fa-solid fa-book-bookmark"></i>
      </div>
      <div>
        <h4 style="font-family: var(--font-display); font-size: 1.2rem; margin: 0 0 3px; color: #FFFFFF;">
          Pusat Kontrol Serial E-Book
        </h4>
        <p style="margin: 0; font-size: 0.82rem; color: #BAC7D7;">
          Upload naskah Web Reader dan kelola part serial e-book berbayar untuk Mantra, Hierarchy, Fate, dan Serenity.
        </p>
      </div>
    </div>
    <a href="{{ route('admin.ebook_parts.hub') }}" class="btn btn-gold" style="font-size: 0.82rem; padding: 10px 20px; font-weight: 700;">
      <i class="fa-solid fa-gear"></i> Buka Serial E-Book
    </a>
  </div>

  <!-- Recent Orders Table -->
  <div class="admin-card">
    <div style="padding: 20px 24px; border-bottom: 1px solid var(--admin-border-subtle); display: flex; justify-content: space-between; align-items: center;">
      <h3 style="font-family: var(--font-display); font-size: 1.25rem; color: #0F172A; margin: 0; font-weight: 700;">
        Pesanan Terbaru & Siap Dikirim
      </h3>
      <a href="{{ route('admin.orders') }}" style="color: var(--admin-gold); font-size: 0.85rem; font-weight: 600; text-decoration: none;">
        Lihat Semua Pesanan &rarr;
      </a>
    </div>

    <table class="admin-table">
      <thead>
        <tr style="background: var(--ivory); color: var(--ocean-navy); border-bottom: 1px solid var(--soft-beige);">
          <th style="padding: 14px 20px; text-align: left;">No. Pesanan</th>
          <th style="padding: 14px 20px; text-align: left;">Pembeli</th>
          <th style="padding: 14px 20px; text-align: left;">Kurir</th>
          <th style="padding: 14px 20px; text-align: right;">Total</th>
          <th style="padding: 14px 20px; text-align: center;">Status</th>
          <th style="padding: 14px 20px; text-align: center;">Cetak Resi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recentOrders as $order)
          <tr style="border-bottom: 1px solid #F0EAE1;">
            <td style="padding: 16px 20px; font-weight: 700; color: var(--ocean-navy);">
              #{{ $order->order_number }}
              <div style="font-size: 0.75rem; color: #475569; font-weight: 500; margin-top: 3px;">
                <i class="fa-regular fa-clock" style="color: #94A3B8;"></i> {{ $order->created_at->format('d M Y, H:i') }} WIB
              </div>
              <div style="font-size: 0.68rem; color: #059669; font-weight: 600; margin-top: 1px;">
                {{ $order->created_at->diffForHumans() }}
              </div>
            </td>
            <td style="padding: 16px 20px;">
              <strong>{{ $order->customer_name }}</strong>
              <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $order->customer_email }}</div>
            </td>
            <td style="padding: 16px 20px;">
              <span style="font-size: 0.82rem; background: var(--ivory); padding: 4px 8px; border-radius: 4px; border: 1px solid var(--soft-beige);">
                {{ $order->courier }}
              </span>
            </td>
            <td style="padding: 16px 20px; text-align: right; font-weight: 700; color: var(--ocean-navy);">
              {{ $order->formatted_total }}
            </td>
            <td style="padding: 16px 20px; text-align: center;">
              <span style="background: #DCFCE7; color: #15803D; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                {{ $order->order_status }}
              </span>
            </td>
            <td style="padding: 16px 20px; text-align: center;">
              <a href="{{ route('admin.orders.resi', $order->order_number) }}" target="_blank" class="btn btn-gold" style="padding: 6px 14px; font-size: 0.75rem;">
                <i class="fa-solid fa-print"></i> Cetak Resi
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
