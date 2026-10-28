@extends('layouts.app')

@section('title', 'Menunggu Pembayaran — ' . $order->order_number . ' — BIANCA VEANA')

@section('content')
<div class="container" style="padding: 60px 20px; max-width: 860px;">
  
  <div style="text-align: center; margin-bottom: 36px;">
    <span class="section-label">GERBANG PEMBAYARAN RESMI</span>
    <h1 style="font-family: var(--font-serif); font-size: 2.2rem; color: var(--ocean-navy); margin: 6px 0 10px;">
      Selesaikan Pembayaran Anda
    </h1>
    <p style="color: var(--text-muted); font-size: 0.95rem;">
      Pesanan <strong style="color: var(--ocean-navy);">#{{ $order->order_number }}</strong> siap diproses secara otomatis melalui Midtrans Payment Gateway.
    </p>
  </div>

  <div style="background: var(--white); border-radius: var(--radius-lg); border: 1.5px solid var(--champagne-gold); padding: 40px; box-shadow: var(--shadow-md); margin-bottom: 30px;">
    
    <!-- Total Amount Spotlight -->
    <div style="background: linear-gradient(135deg, #0F1E36 0%, #1A3258 100%); color: #FDFBF7; border-radius: 8px; padding: 26px 30px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
      <div>
        <span style="font-size: 0.78rem; letter-spacing: 1.5px; color: var(--champagne-gold); text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 4px;">
          TOTAL TAGIHAN PEMBAYARAN
        </span>
        <div style="font-size: 2.1rem; font-weight: 700; color: #FFFFFF; font-family: var(--font-serif);">
          {{ $order->formatted_total }}
        </div>
        <div style="font-size: 0.8rem; color: #CBD5E1; margin-top: 4px;">
          Nomor Pesanan: <strong>#{{ $order->order_number }}</strong>
        </div>
      </div>

      <div style="text-align: right;">
        <span style="background: rgba(198, 161, 107, 0.2); color: var(--champagne-gold); border: 1px solid var(--champagne-gold); padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa-solid fa-clock"></i> MENUNGGU PEMBAYARAN
        </span>
        <div style="font-size: 0.72rem; color: #94A3B8; margin-top: 6px;">
          Verifikasi otomatis 24/7 instan
        </div>
      </div>
    </div>

    <!-- Order Item Summary -->
    <div style="background: var(--ivory); border-radius: 6px; border: 1px solid var(--soft-beige); padding: 20px; margin-bottom: 30px;">
      <h4 style="font-family: var(--font-serif); font-size: 1.1rem; color: var(--ocean-navy); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-receipt" style="color: var(--champagne-gold);"></i> Rincian Pesanan
      </h4>
      <div style="display: flex; flex-direction: column; gap: 10px; font-size: 0.88rem;">
        @foreach($order->items as $item)
          <div style="display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px dashed var(--soft-beige);">
            <div>
              <strong>{{ $item->product_title }}</strong>
              <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</div>
            </div>
            <div style="font-weight: 600; color: var(--ocean-navy);">
              Rp {{ number_format($item->subtotal, 0, ',', '.') }}
            </div>
          </div>
        @endforeach

        @if($order->shipping_cost > 0)
          <div style="display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px dashed var(--soft-beige);">
            <div>
              <strong>Ongkos Kirim</strong>
              <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $order->courier }}</div>
            </div>
            <div style="font-weight: 600; color: var(--ocean-navy);">
              Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
            </div>
          </div>
        @endif

        <div style="display: flex; justify-content: space-between; font-size: 0.82rem; color: var(--text-muted); padding-top: 6px;">
          <span>Penerima / Pemesan:</span>
          <strong>{{ $order->customer_name }} ({{ $order->customer_email }})</strong>
        </div>
      </div>
    </div>

    <!-- Supported Payment Badges -->
    <div style="text-align: center; margin-bottom: 30px;">
      <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 12px;">
        METODE PEMBAYARAN TERSEDIA DI MIDTRANS SNAP:
      </span>
      <div style="display: flex; justify-content: center; align-items: center; gap: 14px; flex-wrap: wrap;">
        <span style="background: #FFFFFF; border: 1px solid #CBD5E1; padding: 6px 14px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; color: #0F172A; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa-solid fa-qrcode" style="color: #DC2626;"></i> QRIS (Semua E-Wallet)
        </span>
        <span style="background: #FFFFFF; border: 1px solid #CBD5E1; padding: 6px 14px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; color: #0F172A; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa-solid fa-building-columns" style="color: #2563EB;"></i> BCA Virtual Account
        </span>
        <span style="background: #FFFFFF; border: 1px solid #CBD5E1; padding: 6px 14px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; color: #0F172A; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa-solid fa-building-columns" style="color: #D97706;"></i> Mandiri Livin' VA
        </span>
        <span style="background: #FFFFFF; border: 1px solid #CBD5E1; padding: 6px 14px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; color: #0F172A; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa-solid fa-building-columns" style="color: #059669;"></i> BNI / BRI VA
        </span>
        <span style="background: #FFFFFF; border: 1px solid #CBD5E1; padding: 6px 14px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; color: #0F172A; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fa-solid fa-wallet" style="color: #0284C7;"></i> GoPay / ShopeePay
        </span>
      </div>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; flex-direction: column; gap: 14px; align-items: center;">
      <button id="pay-button" type="button" class="btn btn-gold" style="width: 100%; max-width: 440px; padding: 18px 24px; font-size: 1.05rem; font-weight: 700; letter-spacing: 0.5px; box-shadow: 0 4px 15px rgba(198, 161, 107, 0.4);">
        <i class="fa-solid fa-lock"></i> BAYAR SEKARANG VIA MIDTRANS
      </button>

      <!-- Testing Simulator (Only when Midtrans key is not set or in Sandbox) -->
      @if(!$isConfigured)
        <div style="margin-top: 16px; background: #FEF3C7; border: 1px dashed #F59E0B; border-radius: 8px; padding: 18px 24px; max-width: 540px; text-align: center; width: 100%;">
          <div style="font-size: 0.85rem; font-weight: 700; color: #92400E; margin-bottom: 6px;">
            <i class="fa-solid fa-circle-info"></i> Mode Pengujian Midtrans (Demo Simulation)
          </div>
          <p style="font-size: 0.78rem; color: #78350F; margin: 0 0 12px; line-height: 1.5;">
            API Key Midtrans belum diisi di file <code>.env</code>. Anda dapat menguji seluruh alur hingga halaman pesanan sukses dengan tombol simulasi di bawah:
          </p>
          <form action="{{ route('checkout.finish', $order->order_number) }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" style="background: #15803D; color: #FFFFFF; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 700; font-size: 0.82rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
              <i class="fa-solid fa-circle-check"></i> Simulasi Bayar Berhasil (Instant Test)
            </button>
          </form>
        </div>
      @endif

      <a href="{{ route('home') }}" style="color: var(--text-muted); font-size: 0.82rem; text-decoration: underline; margin-top: 8px;">
        Kembali ke Beranda (Pembayaran dapat diselesaikan nanti)
      </a>
    </div>

  </div>

  <div style="text-align: center; font-size: 0.78rem; color: var(--text-muted); line-height: 1.6;">
    <i class="fa-solid fa-shield-halved" style="color: var(--champagne-gold);"></i> 
    Transaksi dilindungi enkripsi 256-bit SSL resmi Midtrans (Bank Indonesia Licensed Payment Gateway).
  </div>

</div>
@endsection

@push('scripts')
@if($isConfigured)
  <script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
  <script>
    const payButton = document.getElementById('pay-button');
    const snapToken = "{{ $snapToken }}";

    function triggerSnap() {
      if (!snapToken || snapToken.startsWith('demo-')) {
        alert('Midtrans Client Key belum aktif. Mengalihkan ke halaman simulasi.');
        return;
      }

      window.snap.pay(snapToken, {
        onSuccess: function(result) {
          console.log('Payment success:', result);
          fetch("{{ route('checkout.finish', $order->order_number) }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(result)
          }).then(() => {
            window.location.href = "{{ route('checkout.success', $order->order_number) }}";
          });
        },
        onPending: function(result) {
          console.log('Payment pending:', result);
          alert('Menunggu pembayaran Anda. Silakan selesaikan pembayaran sesuai petunjuk pada layar.');
        },
        onError: function(result) {
          console.log('Payment error:', result);
          alert('Pembayaran gagal atau dibatalkan.');
        },
        onClose: function() {
          console.log('Customer closed popup without finishing payment.');
        }
      });
    }

    payButton.addEventListener('click', triggerSnap);

    // Automatically open snap popup on page load for immediate payment
    window.addEventListener('load', function() {
      setTimeout(triggerSnap, 600);
    });
  </script>
@else
  <script>
    document.getElementById('pay-button').addEventListener('click', function() {
      alert('Mode Simulasi: Klik tombol hijau "Simulasi Bayar Berhasil" di bawah untuk mencoba alur pembayaran selesai.');
    });
  </script>
@endif
@endpush

