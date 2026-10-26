@extends('layouts.admin')

@section('title', 'Kelola Pesanan & Resi — Admin BIANCA VEANA')

@section('content')
<div class="admin-container">
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 20px;">
    <div>
      <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold); display: block; margin-bottom: 4px;">
        PENGIRIMAN & PENJUALAN
      </span>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 6px; font-weight: 700;">
        Daftar Semua Pesanan & Cetak Resi
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Kelola pesanan masuk, verifikasi status pembayaran, dan cetak label resi ekspedisi (Airway Bill).
      </p>
    </div>
    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 10px 18px; border-radius: 8px; font-size: 0.82rem; color: #1E293B; display: flex; align-items: center; gap: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
      <i class="fa-solid fa-receipt" style="color: var(--admin-gold);"></i> Total: <strong>{{ $orders->total() }} Transaksi</strong>
    </div>
  </div>
  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr style="background: var(--ivory); color: var(--ocean-navy); border-bottom: 1px solid var(--soft-beige);">
          <th style="padding: 14px 20px; text-align: left;">Pesanan</th>
          <th style="padding: 14px 20px; text-align: left;">Data Penerima & Alamat</th>
          <th style="padding: 14px 20px; text-align: left;">Daftar Item</th>
          <th style="padding: 14px 20px; text-align: right;">Total Biaya</th>
          <th style="padding: 14px 20px; text-align: center;">Status & Resi</th>
          <th style="padding: 14px 20px; text-align: center;">Aksi Penjual</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
          <tr style="border-bottom: 1px solid #F0EAE1;">
            <td style="padding: 16px 20px; vertical-align: top;">
              <strong style="color: var(--ocean-navy); font-size: 0.95rem;">#{{ $order->order_number }}</strong>
              <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">
                {{ $order->created_at->format('d M Y, H:i') }}
              </div>
              <div style="font-size: 0.75rem; color: #15803D; font-weight: 600; margin-top: 6px;">
                <i class="fa-solid fa-check-double"></i> {{ $order->payment_method }}
              </div>
            </td>

            <td style="padding: 16px 20px; vertical-align: top; max-width: 250px;">
              <strong>{{ $order->customer_name }}</strong>
              <div style="font-size: 0.78rem; color: var(--text-muted);">{{ $order->customer_phone }}</div>
              <div style="font-size: 0.78rem; color: var(--text-dark); margin-top: 4px;">
                {{ $order->shipping_address }}, {{ $order->city }}
              </div>
              <div style="font-size: 0.75rem; background: var(--ivory); display: inline-block; padding: 2px 6px; border-radius: 4px; margin-top: 6px; font-weight: 600;">
                {{ $order->courier }}
              </div>
            </td>

            <td style="padding: 16px 20px; vertical-align: top;">
              <ul style="list-style: none; font-size: 0.82rem;">
                @foreach($order->items as $it)
                  <li style="margin-bottom: 4px;">
                    • <strong>{{ $it->product_title }}</strong> (×{{ $it->quantity }})
                  </li>
                @endforeach
              </ul>
            </td>

            <td style="padding: 16px 20px; text-align: right; vertical-align: top; font-weight: 700; color: var(--ocean-navy);">
              {{ $order->formatted_total }}
            </td>

            <td style="padding: 16px 20px; text-align: center; vertical-align: top;">
              <span style="background: #DCFCE7; color: #15803D; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                {{ $order->order_status }}
              </span>
              @if($order->tracking_number)
                <div style="font-size: 0.75rem; color: var(--ocean-navy); font-weight: 600; margin-top: 6px;">
                  Resi: {{ $order->tracking_number }}
                </div>
              @endif
            </td>

            <td style="padding: 16px 20px; text-align: center; vertical-align: top;">
              <a href="{{ route('admin.orders.resi', $order->order_number) }}" target="_blank" class="btn btn-gold" style="padding: 8px 14px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-print"></i> Cetak Resi
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div style="padding: 20px;">
      {{ $orders->links() }}
    </div>
  </div>
</div>
@endsection
