@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya — BIANCA VEANA')

@section('content')
<div style="background: radial-gradient(circle at 50% 50%, #1c365d 0%, #172B49 100%); color: var(--ivory); padding: 40px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container" style="text-align: center;">
    <span class="hero-subtitle" style="justify-content: center;"><i class="fa-solid fa-boxes-packing"></i> DAFTAR TRANSAKSI RESMI</span>
    <h1 style="font-size: 2.2rem; margin: 6px 0;">RIWAYAT PESANAN SAYA</h1>
    <p style="color: #BAC7D7; font-size: 0.88rem; margin: 0;">Pantau nomor resi pengiriman novel fisik dan unduh kembali berkas e-book digital Anda.</p>
  </div>
</div>

<div class="container" style="padding: 50px 24px 80px; max-width: 1000px; margin: 0 auto;">
  @if($orders->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 24px;">
      @foreach($orders as $order)
        <div style="background: var(--white); border: 1.5px solid var(--soft-beige); border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-sm); transition: border-color 0.2s;" onmouseover="this.style.borderColor='var(--champagne-gold)';" onmouseout="this.style.borderColor='var(--soft-beige)';">
          
          <!-- Order Card Header -->
          <div style="background: var(--ivory); padding: 16px 24px; border-bottom: 1px solid var(--soft-beige); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 14px;">
              <span style="font-family: var(--font-serif); font-size: 1.15rem; font-weight: 700; color: var(--ocean-navy);">
                {{ $order->order_number }}
              </span>
              <span style="font-size: 0.78rem; color: var(--text-muted);">
                {{ $order->created_at->format('d M Y, H:i') }} WIB
              </span>
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
              <!-- Status Pembayaran -->
              @if($order->payment_status === 'paid')
                <span style="background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 4px;">
                  <i class="fa-solid fa-circle-check"></i> Pembayaran Lunas
                </span>
              @else
                <span style="background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 4px;">
                  <i class="fa-solid fa-clock"></i> Menunggu Bayar
                </span>
              @endif

              <!-- Status Pengiriman -->
              @if($order->order_status === 'shipped')
                <span style="background: #EEF2FF; color: #3730A3; border: 1px solid #C7D2FE; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 4px;">
                  <i class="fa-solid fa-truck-fast"></i> Dalam Pengiriman
                </span>
              @elseif($order->order_status === 'completed')
                <span style="background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 4px;">
                  <i class="fa-solid fa-box-open"></i> Selesai
                </span>
              @else
                <span style="background: #F1F5F9; color: #475569; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 4px;">
                  Diproses
                </span>
              @endif
            </div>
          </div>

          <!-- Items list -->
          <div style="padding: 20px 24px;">
            <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 18px;">
              @foreach($order->items as $item)
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #F1F5F9; padding-bottom: 12px;">
                  <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 34px; height: 34px; border-radius: 6px; background: var(--ivory); color: var(--ocean-navy); display: flex; align-items: center; justify-content: center; font-size: 0.95rem;">
                      <i class="fa-solid fa-book"></i>
                    </div>
                    <div>
                      <strong style="font-size: 0.9rem; color: var(--ocean-navy); display: block;">{{ $item->product_title }}</strong>
                      <span style="font-size: 0.78rem; color: var(--text-muted);">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    </div>
                  </div>

                  <div style="display: flex; align-items: center; gap: 14px;">
                    @if($item->digital_access_url && $order->payment_status === 'paid')
                      <a href="{{ $item->digital_access_url }}" target="_blank" class="btn btn-outline" style="padding: 4px 12px; font-size: 0.75rem; border-radius: 4px; color: #16A34A; border-color: #86EFAC;">
                        <i class="fa-solid fa-download"></i> Unduh E-Book
                      </a>
                    @endif
                    <span style="font-weight: 700; color: var(--ocean-navy); font-size: 0.9rem;">
                      Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </span>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- Footer summary -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; padding-top: 10px; font-size: 0.85rem;">
              <div>
                @if($order->tracking_number && $order->tracking_number !== 'DIGITAL-ACCESS')
                  <span style="color: var(--text-muted);">Kurir: <strong>{{ $order->courier }}</strong> · No. Resi: <strong style="color: var(--ocean-navy); letter-spacing: 0.5px;">{{ $order->tracking_number }}</strong></span>
                @else
                  <span style="color: var(--text-muted);"><i class="fa-solid fa-bolt" style="color: #10B981;"></i> Pengiriman Otomatis Digital via Email</span>
                @endif
              </div>

              <div style="display: flex; align-items: baseline; gap: 8px;">
                <span style="color: var(--text-muted);">Total Tagihan:</span>
                <span style="font-size: 1.25rem; font-weight: 800; color: var(--ocean-navy);">
                  {{ $order->formatted_total }}
                </span>
              </div>
            </div>

          </div>

          <!-- Bottom Action Buttons -->
          <div style="background: #FAF7F2; padding: 12px 24px; border-top: 1px solid var(--soft-beige); display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
            @if($order->payment_status === 'pending')
              <a href="{{ route('checkout.payment', $order->order_number) }}" class="btn btn-gold" style="font-size: 0.8rem; padding: 6px 16px;">
                <i class="fa-solid fa-credit-card"></i> Lanjutkan Pembayaran
              </a>
            @endif
            <a href="{{ route('checkout.success', $order->order_number) }}" class="btn btn-outline" style="font-size: 0.8rem; padding: 6px 14px;">
              <i class="fa-solid fa-file-invoice"></i> Lihat Bukti Invoice
            </a>
          </div>

        </div>
      @endforeach
    </div>

    <div style="margin-top: 30px;">
      {{ $orders->links() }}
    </div>
  @else
    <div style="background: var(--white); border: 1px solid var(--soft-beige); border-radius: var(--radius-md); padding: 60px 24px; text-align: center; box-shadow: var(--shadow-sm);">
      <div style="width: 70px; height: 70px; border-radius: 50%; background: var(--ivory); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 18px;">
        <i class="fa-solid fa-receipt"></i>
      </div>
      <h3 style="font-family: var(--font-serif); font-size: 1.5rem; color: var(--ocean-navy); margin-bottom: 8px;">Belum Ada Riwayat Pesanan</h3>
      <p style="color: var(--text-muted); font-size: 0.88rem; max-width: 480px; margin: 0 auto 24px;">
        Anda belum melakukan transaksi pemesanan novel maupun e-book di Bianca Veana Official.
      </p>
      <a href="{{ route('novels.index') }}" class="btn btn-gold" style="padding: 12px 24px; font-size: 0.85rem; font-weight: 700;">
        <i class="fa-solid fa-book"></i> Mulai Menjelajahi Buku
      </a>
    </div>
  @endif
</div>
@endsection

