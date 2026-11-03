@extends('layouts.app')

@section('title', 'Keranjang Belanja — BIANCA VEANA')

@section('content')
<div style="background: var(--ocean-navy); color: var(--ivory); padding: 40px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container text-center" style="text-align: center;">
    <h1 class="page-banner-title" style="margin: 0;">KERANJANG BELANJA ANDA</h1>
    <p style="color: #BAC7D7; margin-top: 8px;">Periksa kembali koleksi buku dan merchandise sebelum melanjutkan ke pembayaran.</p>
  </div>
</div>

<div class="container" style="padding: 60px 24px;">
  @if(!empty($cart) && count($cart) > 0)
    <div class="cart-grid-layout">
      <!-- Left: Items Table -->
      <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); box-shadow: var(--shadow-sm); overflow: hidden;">
        <div class="cart-table-wrapper">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.92rem;">
          <thead>
            <tr style="background: var(--ivory); border-bottom: 1px solid var(--soft-beige); color: var(--ocean-navy);">
              <th style="padding: 16px 20px; text-align: left;">Produk</th>
              <th style="padding: 16px 20px; text-align: center;">Harga</th>
              <th style="padding: 16px 20px; text-align: center;">Jumlah</th>
              <th style="padding: 16px 20px; text-align: right;">Subtotal</th>
              <th style="padding: 16px 20px; text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($cart as $item)
              <tr style="border-bottom: 1px solid #F0EAE1;">
                <td style="padding: 18px 20px;">
                  <div style="display: flex; gap: 16px; align-items: center;">
                    <img src="{{ asset($item['cover_image']) }}" alt="{{ $item['title'] }}" style="width: 55px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid var(--soft-beige);">
                    <div>
                      <span style="font-size: 0.75rem; color: var(--champagne-gold); text-transform: uppercase; font-weight: 600;">{{ $item['series_name'] ?? 'BIANCA VEANA' }}</span>
                      <h4 style="font-family: var(--font-serif); font-size: 1.05rem; color: var(--ocean-navy);">{{ $item['title'] }}</h4>
                      <div>
                        @if(($item['category'] ?? '') === 'ebook')
                          <span style="background: #EFF6FF; color: #1D4ED8; font-size: 0.72rem; font-weight: 700; padding: 2px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-tablet-screen-button"></i> DIGITAL E-BOOK (Rp 0 ONGKIR)
                          </span>
                        @else
                          <span style="background: #FDF2F8; color: #9D174D; font-size: 0.72rem; font-weight: 700; padding: 2px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-box"></i> NOVEL CETAK FISIK
                          </span>
                        @endif
                        @if(!empty($item['is_preorder']))
                          <div style="margin-top: 4px;">
                            <span style="background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; font-size: 0.72rem; font-weight: 700; padding: 2px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                              <i class="fa-solid fa-clock-rotate-left"></i> PRE-ORDER (Estimasi 45 - 60 Hari)
                            </span>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </td>
                <td style="padding: 18px 20px; text-align: center; font-weight: 600; color: var(--text-dark);">
                  Rp {{ number_format($item['price'], 0, ',', '.') }}
                </td>
                <td style="padding: 18px 20px; text-align: center;">
                  <form action="{{ route('cart.update') }}" method="POST" style="display: inline-flex; align-items: center; border: 1px solid var(--soft-beige); border-radius: 4px; overflow: hidden;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                    <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" style="background: var(--ivory); border: none; padding: 6px 10px; cursor: pointer;">-</button>
                    <span style="padding: 6px 12px; font-weight: 600; font-size: 0.9rem;">{{ $item['quantity'] }}</span>
                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" style="background: var(--ivory); border: none; padding: 6px 10px; cursor: pointer;">+</button>
                  </form>
                </td>
                <td style="padding: 18px 20px; text-align: right; font-weight: 700; color: var(--ocean-navy);">
                  Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                </td>
                <td style="padding: 18px 20px; text-align: center;">
                  <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: none; border: none; color: #E11D48; cursor: pointer; font-size: 1rem;" title="Hapus Item">
                      <i class="fa-regular fa-trash-can"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        <div style="padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; background: #FAF7F2; flex-wrap: wrap; gap: 10px;">
          <a href="{{ route('novels.index') }}" style="color: var(--ocean-navy); font-size: 0.85rem; font-weight: 600;">
            <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja Koleksi Lain
          </a>
          <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            <button type="submit" style="background: none; border: none; color: var(--text-muted); font-size: 0.82rem; cursor: pointer;">
              Kosongkan Keranjang
            </button>
          </form>
        </div>
      </div>

      <!-- Right: Summary Box -->
      <div class="cart-summary-box" style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--champagne-gold); padding: 30px; box-shadow: var(--shadow-sm);">
        <h3 style="font-family: var(--font-serif); font-size: 1.4rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--soft-beige);">
          Ringkasan Belanja
        </h3>

        <!-- PANEL VOUCHER & DISKON DI KERANJANG -->
        <div style="background: #FDFBF7; border: 1.5px dashed var(--champagne-gold); border-radius: 8px; padding: 14px; margin-bottom: 20px;">
          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
            <span style="font-size: 0.85rem; font-weight: 700; color: var(--ocean-navy); display: flex; align-items: center; gap: 7px;">
              <i class="fa-solid fa-ticket" style="color: var(--champagne-gold);"></i> Voucher & Promo
            </span>
            @if(isset($availableCoupons) && count($availableCoupons) > 0)
              <button type="button" onclick="toggleCartVouchers()" id="btn-toggle-cart-vouchers" style="background: none; border: none; font-size: 0.76rem; font-weight: 600; color: #B45309; cursor: pointer; text-decoration: underline; padding: 0;">
                Lihat Voucher ({{ count($availableCoupons) }})
              </button>
            @endif
          </div>

          <!-- Banner Kupon Aktif -->
          <div id="cart-applied-banner" style="display: {{ $appliedCoupon ? 'flex' : 'none' }}; align-items: center; justify-content: space-between; background: #ECFDF5; border: 1px solid #A7F3D0; padding: 8px 12px; border-radius: 6px; margin-bottom: 10px;">
            <div style="display: flex; align-items: center; gap: 8px;">
              <i class="fa-solid fa-circle-check" style="color: #10B981; font-size: 0.95rem;"></i>
              <div>
                <strong id="cart-coupon-code" style="font-family: monospace; font-size: 0.85rem; color: #065F46;">{{ $appliedCoupon['code'] ?? '' }}</strong>
                <span id="cart-coupon-desc" style="display: block; font-size: 0.7rem; color: #047857;">{{ $appliedCoupon['name'] ?? 'Voucher aktif' }}</span>
              </div>
            </div>
            <button type="button" onclick="removeCartCoupon()" style="background: #FEE2E2; border: 1px solid #FECACA; color: #DC2626; font-size: 0.72rem; font-weight: 700; cursor: pointer; padding: 3px 8px; border-radius: 4px;">
              <i class="fa-solid fa-xmark"></i> Hapus
            </button>
          </div>

          <!-- Input Kupon -->
          <div id="cart-input-group" style="display: {{ $appliedCoupon ? 'none' : 'flex' }}; gap: 6px;">
            <input type="text" id="cart_coupon_input" placeholder="Masukkan kode promo..." style="flex: 1; padding: 8px 10px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.82rem; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; background: #FFF;">
            <button type="button" onclick="applyCartCoupon()" id="btn-apply-cart-coupon" class="btn btn-gold" style="padding: 8px 14px; font-size: 0.8rem; font-weight: 700; white-space: nowrap;">
              Gunakan
            </button>
          </div>

          <div id="cart-coupon-feedback" style="display: none; font-size: 0.76rem; margin-top: 8px; padding: 6px 10px; border-radius: 4px;"></div>

          <!-- List Voucher Tersedia -->
          @if(isset($availableCoupons) && count($availableCoupons) > 0)
            <div id="cart-vouchers-drawer" style="display: none; margin-top: 12px; border-top: 1px dashed #E2D9CC; padding-top: 10px;">
              <div style="font-size: 0.72rem; color: #64748B; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                Voucher Tersedia:
              </div>
              <div style="display: flex; flex-direction: column; gap: 8px; max-height: 200px; overflow-y: auto;">
                @foreach($availableCoupons as $avCoupon)
                  <div style="display: flex; align-items: center; justify-content: space-between; background: #FFFFFF; border: 1px solid #E2D9CC; border-left: 3.5px solid var(--champagne-gold); border-radius: 6px; padding: 8px 10px; gap: 8px;">
                    <div style="flex: 1; min-width: 0;">
                      <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                        <span style="font-family: monospace; font-size: 0.8rem; font-weight: 700; color: var(--ocean-navy); background: #FAF7F2; padding: 2px 6px; border-radius: 4px;">{{ $avCoupon->code }}</span>
                        <span style="font-size: 0.68rem; font-weight: 700; color: #166534; background: #DCFCE7; padding: 2px 6px; border-radius: 4px;">{{ $avCoupon->formatted_value }}</span>
                      </div>
                      <div style="font-size: 0.73rem; color: #1E293B; margin-top: 2px; font-weight: 600;">{{ $avCoupon->name }}</div>
                      <div style="font-size: 0.68rem; color: #64748B;">{{ $avCoupon->formatted_min_spend }}</div>
                    </div>
                    <button type="button" onclick="selectQuickCartCoupon('{{ $avCoupon->code }}')" class="btn" style="background: var(--champagne-gold); color: #0E1A2B; font-weight: 700; font-size: 0.72rem; padding: 5px 10px; border-radius: 4px; border: none; cursor: pointer; white-space: nowrap;">
                      Pakai
                    </button>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 14px; font-size: 0.95rem;">
          <span style="color: var(--text-muted);">Total Item:</span>
          <span style="font-weight: 600;">{{ array_sum(array_column($cart, 'quantity')) }} produk</span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: var(--text-dark);">
          <span>Subtotal:</span>
          <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <!-- Diskon Keranjang Row -->
        <div id="cart-discount-row" style="display: {{ $discountAmount > 0 ? 'flex' : 'none' }}; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: #059669; font-weight: 600;">
          <span>Potongan Diskon:</span>
          <span id="cart-discount-val">-Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 1.15rem; font-weight: 700; color: var(--ocean-navy); padding-top: 14px; border-top: 1px solid var(--soft-beige);">
          <span>Estimasi Total:</span>
          <span id="cart-total-val" style="color: var(--champagne-gold);">Rp {{ number_format(max(0, $subtotal - $discountAmount), 0, ',', '.') }}</span>
        </div>

        @php
          $hasPhysical = collect($cart)->contains(fn($i) => ($i['category'] ?? '') !== 'ebook');
        @endphp
        @if($hasPhysical)
          <div style="font-size: 0.8rem; color: var(--text-muted); background: var(--ivory); padding: 12px; border-radius: 4px; margin-bottom: 24px; line-height: 1.5; border: 1px solid var(--soft-beige);">
            <i class="fa-solid fa-truck" style="color: var(--champagne-gold);"></i> Ongkos kirim dan pilihan ekspedisi (JNE, SiCepat, J&T) akan dikalkulasi otomatis pada langkah checkout berikutnya.
          </div>
        @else
          <div style="font-size: 0.8rem; color: #166534; background: #DCFCE7; padding: 12px; border-radius: 4px; margin-bottom: 24px; line-height: 1.5; border: 1px solid #86EFAC;">
            <i class="fa-solid fa-bolt-lightning" style="color: #15803D;"></i> <strong>Pesanan 100% Digital:</strong> Bebas biaya kirim (Rp 0). Tautan Google Drive & file PDF akan langsung dikirimkan ke email Anda.
          </div>
        @endif

        <a href="{{ route('checkout.index') }}" class="btn btn-gold" style="width: 100%; text-align: center; padding: 16px;">
          LANJUT KE CHECKOUT <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
    </div>
  @else
    <div style="text-align: center; padding: 80px 20px; background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige);">
      <i class="fa-solid fa-bag-shopping" style="font-size: 3.5rem; color: var(--champagne-gold); margin-bottom: 20px;"></i>
      <h2 style="font-family: var(--font-serif); color: var(--ocean-navy); font-size: 1.8rem; margin-bottom: 10px;">Keranjang Belanja Masih Kosong</h2>
      <p style="color: var(--text-muted); max-width: 480px; margin: 0 auto 28px;">
        Anda belum menambahkan novel cetak, e-book, atau merchandise ke keranjang belanja Anda.
      </p>
      <a href="{{ route('novels.index') }}" class="btn btn-gold">
        <i class="fa-solid fa-book"></i> JELAJAHI BUKU BIANCA VEANA
      </a>
    </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
  const cartSubtotal = {{ $subtotal }};

  function toggleCartVouchers() {
    const drawer = document.getElementById('cart-vouchers-drawer');
    const btn = document.getElementById('btn-toggle-cart-vouchers');
    if (!drawer) return;

    if (drawer.style.display === 'none' || drawer.style.display === '') {
      drawer.style.display = 'block';
      if (btn) btn.innerText = 'Tutup Daftar Voucher';
    } else {
      drawer.style.display = 'none';
      if (btn) btn.innerText = 'Lihat Voucher ({{ count($availableCoupons ?? []) }})';
    }
  }

  function selectQuickCartCoupon(code) {
    const input = document.getElementById('cart_coupon_input');
    if (input) input.value = code;
    applyCartCoupon(code);
  }

  async function applyCartCoupon(codeToApply = null) {
    const input = document.getElementById('cart_coupon_input');
    const code = (codeToApply || (input ? input.value : '')).trim().toUpperCase();
    const feedback = document.getElementById('cart-coupon-feedback');
    const btn = document.getElementById('btn-apply-cart-coupon');

    if (!code) {
      if (feedback) {
        feedback.style.display = 'block';
        feedback.style.background = '#FEF2F2';
        feedback.style.color = '#991B1B';
        feedback.style.border = '1px solid #FECACA';
        feedback.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Masukkan kode voucher terlebih dahulu.';
      }
      return;
    }

    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
    }

    try {
      const res = await fetch('/coupons/apply', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code: code, shipping_cost: 0 })
      });

      const data = await res.json();

      if (res.ok && data.success) {
        const discountRow = document.getElementById('cart-discount-row');
        const discountVal = document.getElementById('cart-discount-val');
        const totalVal = document.getElementById('cart-total-val');
        const banner = document.getElementById('cart-applied-banner');
        const bannerCode = document.getElementById('cart-coupon-code');
        const bannerDesc = document.getElementById('cart-coupon-desc');
        const inputGroup = document.getElementById('cart-input-group');

        if (discountRow) discountRow.style.display = 'flex';
        if (discountVal) discountVal.innerText = data.discount_formatted;
        if (totalVal) totalVal.innerText = data.total_formatted;

        if (banner) banner.style.display = 'flex';
        if (bannerCode) bannerCode.innerText = data.coupon.code;
        if (bannerDesc) bannerDesc.innerText = data.coupon.name + ' (' + data.coupon.value_formatted + ')';
        if (inputGroup) inputGroup.style.display = 'none';

        if (feedback) {
          feedback.style.display = 'block';
          feedback.style.background = '#ECFDF5';
          feedback.style.color = '#065F46';
          feedback.style.border = '1px solid #A7F3D0';
          feedback.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + data.message;
        }
      } else {
        if (feedback) {
          feedback.style.display = 'block';
          feedback.style.background = '#FEF2F2';
          feedback.style.color = '#991B1B';
          feedback.style.border = '1px solid #FECACA';
          feedback.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> ' + (data.message || 'Kupon tidak valid.');
        }
      }
    } catch (e) {
      console.error(e);
    } finally {
      if (btn) {
        btn.disabled = false;
        btn.innerText = 'Gunakan';
      }
    }
  }

  async function removeCartCoupon() {
    const feedback = document.getElementById('cart-coupon-feedback');

    try {
      const res = await fetch('/coupons/remove', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ shipping_cost: 0 })
      });

      const data = await res.json();

      const discountRow = document.getElementById('cart-discount-row');
      const totalVal = document.getElementById('cart-total-val');
      const banner = document.getElementById('cart-applied-banner');
      const inputGroup = document.getElementById('cart-input-group');
      const input = document.getElementById('cart_coupon_input');

      if (discountRow) discountRow.style.display = 'none';
      if (totalVal) totalVal.innerText = 'Rp ' + cartSubtotal.toLocaleString('id-ID');
      if (banner) banner.style.display = 'none';
      if (inputGroup) inputGroup.style.display = 'flex';
      if (input) input.value = '';

      if (feedback) {
        feedback.style.display = 'block';
        feedback.style.background = '#F8FAFC';
        feedback.style.color = '#475569';
        feedback.style.border = '1px solid #E2E8F0';
        feedback.innerHTML = '<i class="fa-solid fa-info-circle"></i> Kupon dihapus.';
      }
    } catch (e) {
      console.error(e);
    }
  }
</script>
@endpush
