@extends('layouts.app')

@php
  $isCancelled = $order->order_status === 'cancelled' || in_array($order->payment_status, ['cancelled', 'expired', 'failed']);
  $isExpired = $order->payment_status === 'expired' || ($isCancelled && str_contains(strtolower($order->notes ?? ''), 'kedaluwarsa'));
@endphp

@section('title', ($isCancelled ? ($isExpired ? 'Pesanan Kedaluwarsa' : 'Pesanan Dibatalkan') : 'Pesanan Berhasil') . ' — BIANCA VEANA')

@section('content')
<div class="container" style="padding: 60px 24px; max-width: 860px;">
  <div style="background: var(--white); border-radius: var(--radius-lg); border: 1px solid {{ $isCancelled ? '#FECACA' : 'var(--champagne-gold)' }}; padding: 48px; box-shadow: var(--shadow-lg); text-align: center;">
    
    @if($isCancelled)
      <!-- Icon & Status Batal / Kedaluwarsa -->
      <div style="width: 76px; height: 76px; border-radius: 50%; background: #FEE2E2; color: #DC2626; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 20px; box-shadow: 0 4px 16px rgba(220, 38, 38, 0.15);">
        <i class="fa-solid fa-ban"></i>
      </div>

      <span style="font-size: 0.8rem; letter-spacing: 2px; color: #DC2626; text-transform: uppercase; font-weight: 700; background: #FEF2F2; padding: 6px 16px; border-radius: 20px; border: 1px solid #FECACA; display: inline-block;">
        <i class="fa-solid fa-circle-xmark"></i> {{ $isExpired ? 'STATUS: WAKTU PEMBAYARAN KEDALUWARSA' : 'STATUS: PESANAN TELAH DIBATALKAN' }}
      </span>
      <h1 style="font-family: var(--font-serif); font-size: 2.3rem; color: var(--ocean-navy); margin: 12px 0 16px;">
        {{ $isExpired ? 'Waktu Pembayaran Telah Habis' : 'Pesanan Ini Telah Dibatalkan' }}
      </h1>
      <p style="color: var(--text-muted); font-size: 0.98rem; max-width: 600px; margin: 0 auto 28px; line-height: 1.7;">
        Pesanan nomor <strong style="color: var(--ocean-navy);">#{{ $order->order_number }}</strong> berstatus <strong>{{ $isExpired ? 'kedaluwarsa' : 'dibatalkan' }}</strong>. Tidak ada dana yang ditarik dari akun Anda dan stok barang telah dikembalikan ke toko.
      </p>
    @else
      <!-- Icon & Status Berhasil (Lunas) -->
      <div style="width: 76px; height: 76px; border-radius: 50%; background: #DCFCE7; color: #15803D; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 20px; box-shadow: 0 4px 16px rgba(21, 128, 61, 0.15);">
        <i class="fa-solid fa-check"></i>
      </div>

      <span style="font-size: 0.8rem; letter-spacing: 3px; color: var(--champagne-gold); text-transform: uppercase; font-weight: 700;">
        TRANSAKSI RESMI BERHASIL
      </span>
      <h1 style="font-family: var(--font-serif); font-size: 2.4rem; color: var(--ocean-navy); margin: 8px 0 16px;">
        Terima Kasih atas Pesanan Anda!
      </h1>
      <p style="color: var(--text-muted); font-size: 1rem; max-width: 600px; margin: 0 auto 30px; line-height: 1.7;">
        Pesanan nomor <strong style="color: var(--ocean-navy);">#{{ $order->order_number }}</strong> telah berhasil diverifikasi.
      </p>
    @endif

    <!-- Digital E-Book Access Vault (HANYA MUNCUL JIKA SUDAH LUNAS / PAID) -->
    @php
      $digitalItems = $order->items->filter(function($item) {
        return $item->product && $item->product->category === 'ebook';
      });
    @endphp

    @if(!$isCancelled && $order->payment_status === 'paid' && $digitalItems->count() > 0)
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
                  <i class="fa-solid fa-circle-check" style="color: #4ADE80;"></i> Akses Baca Web Novel & Tautan Google Drive Aktif
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
                    <i class="fa-brands fa-google-drive" style="color: #60A5FA;"></i> Buka Google Drive
                  </a>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @elseif($isCancelled && $digitalItems->count() > 0)
      <!-- Catatan Akses Berkas Terkunci untuk Pesanan Batal -->
      <div style="background: #FEF2F2; color: #991B1B; border-radius: var(--radius-md); padding: 18px 24px; margin-bottom: 32px; text-align: left; border: 1px solid #FECACA; font-size: 0.88rem; display: flex; align-items: center; gap: 14px;">
        <div style="width: 42px; height: 42px; border-radius: 50%; background: #FEE2E2; color: #DC2626; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
          <i class="fa-solid fa-lock"></i>
        </div>
        <div>
          <strong style="display: block; font-size: 0.95rem; margin-bottom: 2px;">Akses Berkas Digital E-Book Terkunci</strong>
          <span style="font-size: 0.83rem; color: #B91C1C; line-height: 1.5; display: block;">
            Tautan baca online dan berkas Google Drive ditutup karena pesanan ini berstatus dibatalkan / tidak dibayar. Silakan lakukan pemesanan baru untuk mengaktifkan akses kembali.
          </span>
        </div>
      </div>
    @endif

    <!-- Invoice Details Card -->
    <div style="background: var(--ivory); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 24px; text-align: left; margin-bottom: 36px;">
      <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--soft-beige); padding-bottom: 10px; margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
        <h3 style="font-family: var(--font-serif); font-size: 1.2rem; color: var(--ocean-navy); margin: 0;">
          Rincian Pesanan #{{ $order->order_number }}
        </h3>
        @if($isCancelled)
          <span style="font-size: 0.75rem; background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; padding: 4px 10px; border-radius: 4px; font-weight: 700; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px;">
            <i class="fa-solid fa-ban"></i> {{ $isExpired ? 'KEDALUWARSA' : 'DIBATALKAN' }}
          </span>
        @elseif($order->payment_status === 'paid')
          <span style="font-size: 0.75rem; background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; padding: 4px 10px; border-radius: 4px; font-weight: 700; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px;">
            <i class="fa-solid fa-check"></i> LUNAS (PAID)
          </span>
        @else
          <span style="font-size: 0.75rem; background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; padding: 4px 10px; border-radius: 4px; font-weight: 700; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px;">
            <i class="fa-solid fa-clock"></i> MENUNGGU PEMBAYARAN
          </span>
        @endif
      </div>

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
          <span style="color: var(--text-muted); display: block;">Metode & Status Pembayaran:</span>
          @if($isCancelled)
            <strong style="color: #DC2626;"><i class="fa-solid fa-ban"></i> {{ $order->payment_method ?? 'Midtrans' }} (DIBATALKAN / TIDAK DIBAYAR)</strong>
          @elseif($order->payment_status === 'paid')
            <strong style="color: #15803D;"><i class="fa-solid fa-circle-check"></i> {{ $order->payment_method }} (LUNAS)</strong>
          @else
            <strong style="color: #D97706;"><i class="fa-solid fa-clock"></i> {{ $order->payment_method }} (MENUNGGU PEMBAYARAN)</strong>
          @endif
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
            <td style="padding: 12px 0;">Total {{ $isCancelled ? 'Tagihan (Batal)' : 'Pembayaran' }}</td>
            <td style="padding: 12px 0; text-align: right; color: {{ $isCancelled ? '#9CA3AF; text-decoration: line-through;' : 'var(--champagne-gold);' }}">
              {{ $order->formatted_total }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Actions -->
    @if($isCancelled)
      <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
        <a href="{{ route('novels.index') }}" class="btn btn-gold" style="padding: 12px 28px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-cart-shopping"></i> PESAN ULANG SEKARANG
        </a>
        @auth
          <a href="{{ route('account.orders') }}" class="btn btn-outline" style="padding: 12px 24px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-list-check"></i> RIWAYAT PESANAN SAYA
          </a>
        @else
          <a href="{{ route('home') }}" class="btn btn-outline" style="padding: 12px 24px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-house"></i> KEMBALI KE BERANDA
          </a>
        @endauth
      </div>
    @else
      <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
        @auth
          <a href="{{ route('account.orders') }}" class="btn btn-gold" style="padding: 12px 28px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-receipt"></i> LIHAT SEMUA PESANAN SAYA
          </a>
        @endauth
        <a href="{{ route('home') }}" class="btn btn-outline" style="padding: 12px 24px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-house"></i> KEMBALI KE HOMEPAGE
        </a>
      </div>
    @endif

  </div>
</div>
@endsection
