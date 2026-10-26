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
              <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 400;">
                {{ $order->created_at->format('d M Y, H:i') }}
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
