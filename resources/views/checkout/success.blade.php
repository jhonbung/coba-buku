@extends('layouts.app')

@section('title', 'Pesanan Berhasil — BIANCA VEANA')

@section('content')
<div class="container" style="padding: 60px 24px; max-width: 860px;">
  <div style="background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--champagne-gold); padding: 48px; box-shadow: var(--shadow-lg); text-align: center;">
    
    <div style="width: 72px; height: 72px; border-radius: 50%; background: #DCFCE7; color: #15803D; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 20px;">
      <i class="fa-solid fa-check"></i>
    </div>

    <span style="font-size: 0.8rem; letter-spacing: 3px; color: var(--champagne-gold); text-transform: uppercase; font-weight: 700;">
      TRANSAKSI RESMI BERHASIL
    </span>
    <h1 style="font-family: var(--font-serif); font-size: 2.4rem; color: var(--ocean-navy); margin: 8px 0 16px;">
      Terima Kasih atas Pesanan Anda!
    </h1>
    <p style="color: var(--text-muted); font-size: 1rem; max-width: 600px; margin: 0 auto 30px; line-height: 1.7;">
      Pesanan nomor <strong style="color: var(--ocean-navy);">#{{ $order->order_number }}</strong> telah berhasil diverifikasi. Bukti transaksi dan detail pesanan telah dikirimkan ke <strong>{{ $order->customer_email }}</strong>.
    </p>

    <!-- Digital E-Book Access Vault (If digital items exist) -->
    @php
      $digitalItems = $order->items->filter(function($item) {
        return $item->product && $item->product->category === 'ebook';
      });
    @endphp

    @if($digitalItems->count() > 0)
      <div style="background: linear-gradient(135deg, #172B49 0%, #203A5E 100%); color: var(--ivory); border-radius: var(--radius-md); padding: 28px; margin-bottom: 36px; text-align: left; border: 1px solid var(--champagne-gold);">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
          <i class="fa-solid fa-cloud-arrow-down" style="color: var(--champagne-gold); font-size: 1.5rem;"></i>
          <h3 style="font-family: var(--font-serif); font-size: 1.3rem; margin: 0; color: var(--ivory);">
            Akses Unduhan Digital (E-Book Vault)
          </h3>
        </div>
        <p style="font-size: 0.85rem; color: #BAC7D7; margin-bottom: 20px;">
          File PDF dan tautan Google Drive resmi siap Anda baca sekarang:
        </p>

        <div style="display: flex; flex-direction: column; gap: 12px;">
          @foreach($digitalItems as $dItem)
            <div style="background: rgba(255, 255, 255, 0.08); padding: 16px 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(198, 161, 107, 0.35); flex-wrap: wrap; gap: 14px;">
              <div>
                <strong style="color: var(--ivory); font-size: 1.02rem; display: block; margin-bottom: 4px;">{{ $dItem->product_title }}</strong>
                <div style="font-size: 0.78rem; color: var(--champagne-gold); display: flex; align-items: center; gap: 6px;">
                  <i class="fa-solid fa-circle-check" style="color: #4ADE80;"></i> Akses Baca Web Novel & Unduhan PDF Aktif
                </div>
              </div>
              <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                @if($dItem->product)
                  <a href="{{ route('reader.show', ['slug' => $dItem->product->slug, 'order' => $order->order_number]) }}" class="btn btn-gold" style="padding: 10px 20px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(198, 161, 107, 0.45);">
                    <i class="fa-solid fa-book-open-reader"></i> BACA SEKARANG DI WEB
                  </a>
                @endif
                @if($dItem->product && $dItem->product->digital_file_url)
                  <a href="{{ $dItem->product->digital_file_url }}" target="_blank" class="btn" style="background: rgba(255, 255, 255, 0.12); color: #FFF; border: 1px solid rgba(255, 255, 255, 0.25); padding: 9px 16px; font-size: 0.78rem; text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-download"></i> Unduh PDF
                  </a>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <!-- Invoice Details Card -->
    <div style="background: var(--ivory); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 24px; text-align: left; margin-bottom: 36px;">
      <h3 style="font-family: var(--font-serif); font-size: 1.2rem; color: var(--ocean-navy); margin-bottom: 16px; border-bottom: 1px solid var(--soft-beige); padding-bottom: 8px;">
        Rincian Pesanan #{{ $order->order_number }}
      </h3>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; font-size: 0.88rem; margin-bottom: 18px;">
        <div>
          <span style="color: var(--text-muted); display: block;">Penerima:</span>
          <strong>{{ $order->customer_name }} ({{ $order->customer_phone }})</strong>
        </div>
        <div>
          <span style="color: var(--text-muted); display: block;">Jasa Kurir:</span>
          <strong>{{ $order->courier }}</strong>
        </div>
        @php
          $isDigital = str_contains($order->shipping_address, 'Digital') || $order->courier === 'Digital Delivery (Email Langsung)';
        @endphp
        <div>
          <span style="color: var(--text-muted); display: block;">{{ $isDigital ? 'Tujuan Pengiriman Akses E-Book:' : 'Alamat Pengiriman:' }}</span>
          @if($isDigital)
            <strong style="color: #1D4ED8;"><i class="fa-solid fa-envelope"></i> {{ $order->customer_email }}</strong>
            <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 2px;">Notifikasi WhatsApp: {{ $order->customer_phone }}</div>
          @else
            <strong>{{ $order->shipping_address }}, {{ $order->city }} {{ $order->postal_code }}</strong>
          @endif
        </div>
        <div>
          <span style="color: var(--text-muted); display: block;">Metode Pembayaran:</span>
          <strong style="color: var(--champagne-gold);"><i class="fa-solid fa-circle-check" style="color: #15803D;"></i> {{ $order->payment_method }} (LUNAS)</strong>
        </div>
      </div>

      <!-- Itemized list -->
      <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; border-top: 1px solid var(--soft-beige);">
        <tbody>
          @foreach($order->items as $item)
            <tr style="border-bottom: 1px solid var(--soft-beige);">
              <td style="padding: 10px 0;">{{ $item->product_title }} (×{{ $item->quantity }})</td>
              <td style="padding: 10px 0; text-align: right; font-weight: 600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
          @endforeach
          <tr>
            <td style="padding: 10px 0; color: var(--text-muted);">Ongkos Kirim</td>
            <td style="padding: 10px 0; text-align: right; font-weight: 600;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
          </tr>
          <tr style="font-size: 1.05rem; font-weight: 700; color: var(--ocean-navy);">
            <td style="padding: 12px 0;">Total Pembayaran</td>
            <td style="padding: 12px 0; text-align: right; color: var(--champagne-gold);">{{ $order->formatted_total }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Actions -->
    <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
      <a href="{{ route('home') }}" class="btn btn-gold" style="padding: 12px 28px; font-weight: 700;">
        <i class="fa-solid fa-house"></i> KEMBALI KE HOMEPAGE
      </a>
    </div>

  </div>
</div>
@endsection
