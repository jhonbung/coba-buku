@extends('layouts.app')

@section('title', 'Checkout Pembayaran — BIANCA VEANA')

@section('content')
<div style="background: var(--ocean-navy); color: var(--ivory); padding: 40px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container text-center" style="text-align: center;">
    <h1 style="font-size: 2.4rem; margin: 0;">CHECKOUT PEMBAYARAN</h1>
    <p style="color: #BAC7D7; margin-top: 8px;">Lengkapi data pengiriman dan pilih metode pembayaran resmi Anda.</p>
  </div>
</div>

<div class="container" style="padding: 60px 24px;">
  @if(isset($errors) && $errors->any())
    <div style="background: #FEE2E2; border: 1px solid #F87171; color: #B91C1C; padding: 16px 20px; border-radius: 6px; margin-bottom: 24px;">
      <strong style="display: block; margin-bottom: 6px;"><i class="fa-solid fa-triangle-exclamation"></i> Mohon lengkapi data berikut:</strong>
      <ul style="margin-left: 20px; font-size: 0.88rem;">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <div style="display: grid; grid-template-columns: 1.25fr 0.75fr; gap: 40px; align-items: start;">
      
      <!-- Left: Checkout Forms -->
      <div>
        @if(!$hasPhysicalItems)
          <!-- E-BOOK NOTICE BANNER -->
          <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-left: 5px solid #2563EB; border-radius: 8px; padding: 18px 22px; margin-bottom: 28px; display: flex; align-items: flex-start; gap: 14px; box-shadow: var(--shadow-sm);">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: #DBEAFE; color: #1D4ED8; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
              <i class="fa-solid fa-bolt"></i>
            </div>
            <div>
              <strong style="color: #1E40AF; font-size: 0.98rem; display: block; margin-bottom: 4px;">
                Checkout Pesanan Digital (E-Book Instan)
              </strong>
              <p style="color: #3B82F6; font-size: 0.85rem; line-height: 1.6; margin: 0;">
                Karena Anda membeli format <strong>E-Book Digital</strong>, alamat rumah fisik <strong>tidak diperlukan</strong>. File PDF resolusi tinggi dan tautan Google Drive resmi akan otomatis dikirimkan ke <strong>Email & WhatsApp</strong> Anda secara instan begitu pembayaran terkonfirmasi.
              </p>
            </div>
          </div>

          <!-- 1. Digital Recipient Contact -->
          <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 32px; margin-bottom: 28px; box-shadow: var(--shadow-sm);">
            <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
              <i class="fa-solid fa-user-check" style="color: var(--champagne-gold);"></i> 1. Data Penerima Akses E-Book
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Nama Lengkap Pembeli *</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="Contoh: Clara Maharani" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              </div>
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Nomor WhatsApp Aktif *</label>
                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required placeholder="Contoh: 08123456789" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
                <span style="font-size: 0.72rem; color: var(--text-muted); margin-top: 4px; display: block;">Untuk konfirmasi instan & pengiriman tautan cadangan via WA.</span>
              </div>
            </div>
            <div style="margin-bottom: 18px;">
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">
                Alamat Email Aktif (Penerima File & Tautan E-Book) *
              </label>
              <input type="email" name="customer_email" value="{{ old('customer_email') }}" required placeholder="email.anda@gmail.com" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--champagne-gold); border-radius: 4px; font-size: 0.95rem; background: #FFFDF9;">
              <span style="font-size: 0.75rem; color: #B45309; margin-top: 4px; display: block; font-weight: 500;">
                <i class="fa-solid fa-circle-exclamation"></i> Sangat penting: Pastikan alamat email benar untuk menerima akses unduhan e-book.
              </span>
            </div>
            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Catatan Khusus (Opsional)</label>
              <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Contoh: Kirimkan salinan file ke email kedua saya" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
            </div>
          </div>

          <!-- 2. Digital Delivery Method Info -->
          <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 28px 32px; margin-bottom: 28px; box-shadow: var(--shadow-sm);">
            <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
              <i class="fa-solid fa-paper-plane" style="color: var(--champagne-gold);"></i> 2. Metode Pengiriman Digital
            </h3>
            <div style="background: #F0FDF4; border: 1px solid #86EFAC; border-radius: 6px; padding: 16px 20px; color: #166534; display: flex; justify-content: space-between; align-items: center;">
              <div style="display: flex; align-items: center; gap: 14px;">
                <i class="fa-solid fa-bolt" style="font-size: 1.4rem; color: #16A34A;"></i>
                <div>
                  <strong style="font-size: 0.95rem;">Pengiriman Digital Instan (Email & WhatsApp)</strong>
                  <div style="font-size: 0.78rem; color: #15803D; margin-top: 2px;">Akses unduhan PDF resolusi tinggi & tautan Google Drive langsung aktif otomatis.</div>
                </div>
              </div>
              <span style="background: #DCFCE7; color: #15803D; padding: 6px 14px; border-radius: 4px; font-weight: 700; font-size: 0.82rem; border: 1px solid #86EFAC;">
                GRATIS (Rp 0)
              </span>
            </div>
            <input type="hidden" name="courier" value="Digital Delivery (Email Langsung)">
          </div>

        @else
          <!-- PHYSICAL / MIXED ORDER FLOW -->
          <!-- 1. Customer Information -->
          <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 32px; margin-bottom: 28px; box-shadow: var(--shadow-sm);">
            <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
              <i class="fa-solid fa-user-circle" style="color: var(--champagne-gold);"></i> 1. Informasi Kontak Pembeli
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Nama Lengkap *</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="Contoh: Clara Maharani" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              </div>
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Nomor WhatsApp / Telepon *</label>
                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required placeholder="Contoh: 08123456789" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              </div>
            </div>
            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Alamat Email (Untuk Konfirmasi Pesanan & Resi) *</label>
              <input type="email" name="customer_email" value="{{ old('customer_email') }}" required placeholder="email.anda@gmail.com" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              <span style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; display: block;">Pastikan email aktif untuk menerima nomor resi pengiriman dan bukti transaksi.</span>
            </div>
          </div>

          <!-- 2. Shipping Address -->
          <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 32px; margin-bottom: 28px; box-shadow: var(--shadow-sm);">
            <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
              <i class="fa-solid fa-location-dot" style="color: var(--champagne-gold);"></i> 2. Alamat Pengiriman Buku
            </h3>
            <div style="margin-bottom: 18px;">
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Alamat Lengkap / Jalan / No. Rumah / RT RW *</label>
              <textarea name="shipping_address" required rows="3" placeholder="Jl. Anggrek No. 12, Kelurahan, Kecamatan..." style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">{{ old('shipping_address') }}</textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 18px; margin-bottom: 18px;">
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Kota / Kabupaten *</label>
                <input type="text" name="city" value="{{ old('city') }}" required placeholder="Jakarta Selatan" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              </div>
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Kode Pos *</label>
                <input type="text" name="postal_code" value="{{ old('postal_code') }}" required placeholder="12190" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              </div>
            </div>
            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Catatan Khusus untuk Penjual (Opsional)</label>
              <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Contoh: Mohon bubble wrap ganda, paket hadiah ulang tahun" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
            </div>
          </div>

          <!-- 3. Courier Selection -->
          <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 32px; margin-bottom: 28px; box-shadow: var(--shadow-sm);">
            <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
              <i class="fa-solid fa-truck" style="color: var(--champagne-gold);"></i> 3. Jasa Pengiriman
            </h3>
            <div style="display: flex; flex-direction: column; gap: 12px;">
              <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border: 1px solid var(--soft-beige); border-radius: 6px; cursor: pointer;">
                <div style="display: flex; align-items: center; gap: 12px;">
                  <input type="radio" name="courier" value="JNE Regular (1-2 hari kerja)" checked onchange="updateShipping(18000)">
                  <div>
                    <strong>JNE Regular</strong>
                    <div style="font-size: 0.78rem; color: var(--text-muted);">Estimasi tiba 1 - 2 hari kerja</div>
                  </div>
                </div>
                <div style="font-weight: 700; color: var(--ocean-navy);">Rp 18.000</div>
              </label>

              <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border: 1px solid var(--soft-beige); border-radius: 6px; cursor: pointer;">
                <div style="display: flex; align-items: center; gap: 12px;">
                  <input type="radio" name="courier" value="SiCepat BEST (1 hari)" onchange="updateShipping(22000)">
                  <div>
                    <strong>SiCepat BEST (Besok Sampai Tujuan)</strong>
                    <div style="font-size: 0.78rem; color: var(--text-muted);">Estimasi tiba 1 hari</div>
                  </div>
                </div>
                <div style="font-weight: 700; color: var(--ocean-navy);">Rp 22.000</div>
              </label>

              <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border: 1px solid var(--soft-beige); border-radius: 6px; cursor: pointer;">
                <div style="display: flex; align-items: center; gap: 12px;">
                  <input type="radio" name="courier" value="J&T Express (1-3 hari)" onchange="updateShipping(17000)">
                  <div>
                    <strong>J&T Express</strong>
                    <div style="font-size: 0.78rem; color: var(--text-muted);">Estimasi tiba 1 - 3 hari kerja</div>
                  </div>
                </div>
                <div style="font-weight: 700; color: var(--ocean-navy);">Rp 17.000</div>
              </label>
            </div>
          </div>
        @endif

        <!-- Payment Method Section -->
        <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 32px; box-shadow: var(--shadow-sm);">
          <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-credit-card" style="color: var(--champagne-gold);"></i> 
            {{ $hasPhysicalItems ? '4. Metode Pembayaran Resmi Indonesia' : '3. Metode Pembayaran Resmi Indonesia' }}
          </h3>
          <div style="display: flex; flex-direction: column; gap: 12px;">
            <label style="display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border: 2px solid var(--champagne-gold); border-radius: 6px; cursor: pointer; background: var(--ivory);">
              <div style="display: flex; align-items: center; gap: 12px;">
                <input type="radio" name="payment_method" value="Midtrans QRIS / GoPay / ShopeePay / BCA" checked>
                <div>
                  <strong>QRIS (Midtrans Payment Gateway)</strong>
                  <div style="font-size: 0.78rem; color: var(--text-muted);">Semua Bank & Dompet Digital (BCA, Mandiri, GoPay, OVO, ShopeePay)</div>
                </div>
              </div>
              <span style="font-size: 0.75rem; background: var(--champagne-gold); color: var(--ocean-navy-deep); padding: 4px 10px; border-radius: 4px; font-weight: 700;">INSTAN</span>
            </label>

            <label style="display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border: 1px solid var(--soft-beige); border-radius: 6px; cursor: pointer;">
              <div style="display: flex; align-items: center; gap: 12px;">
                <input type="radio" name="payment_method" value="BCA Virtual Account">
                <div>
                  <strong>BCA Virtual Account</strong>
                  <div style="font-size: 0.78rem; color: var(--text-muted);">Verifikasi otomatis 24 Jam</div>
                </div>
              </div>
              <i class="fa-solid fa-building-columns" style="color: var(--champagne-gold);"></i>
            </label>

            <label style="display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border: 1px solid var(--soft-beige); border-radius: 6px; cursor: pointer;">
              <div style="display: flex; align-items: center; gap: 12px;">
                <input type="radio" name="payment_method" value="Bank Mandiri Virtual Account">
                <div>
                  <strong>Mandiri Virtual Account</strong>
                  <div style="font-size: 0.78rem; color: var(--text-muted);">Verifikasi otomatis melalui Livin' by Mandiri</div>
                </div>
              </div>
              <i class="fa-solid fa-building-columns" style="color: var(--champagne-gold);"></i>
            </label>
          </div>
        </div>
      </div>

      <!-- Right: Sticky Order Summary -->
      <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--champagne-gold); padding: 30px; box-shadow: var(--shadow-md); position: sticky; top: 100px;">
        <h3 style="font-family: var(--font-serif); font-size: 1.4rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--soft-beige);">
          Rincian Pesanan
        </h3>

        <div style="max-height: 240px; overflow-y: auto; margin-bottom: 20px; border-bottom: 1px solid var(--soft-beige); padding-bottom: 14px;">
          @foreach($cart as $item)
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.88rem;">
              <div>
                <strong>{{ $item['title'] }}</strong>
                <div style="font-size: 0.75rem; color: var(--text-muted);">Qty: {{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
              </div>
              <div style="font-weight: 600; color: var(--ocean-navy);">
                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
              </div>
            </div>
          @endforeach
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.92rem; color: var(--text-dark);">
          <span>Subtotal Produk:</span>
          <span style="font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 0.92rem; color: var(--text-dark);">
          <span>Ongkos Kirim:</span>
          <span id="shipping-display" style="font-weight: 600; {{ !$hasPhysicalItems ? 'color: #16A34A;' : '' }}">
            {{ $hasPhysicalItems ? 'Rp 18.000' : 'Gratis (E-Book)' }}
          </span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 1.25rem; font-weight: 700; color: var(--ocean-navy); padding-top: 14px; border-top: 1px solid var(--soft-beige);">
          <span>Total Pembayaran:</span>
          <span id="total-display" style="color: var(--champagne-gold);">
            Rp {{ number_format($subtotal + ($hasPhysicalItems ? 18000 : 0), 0, ',', '.') }}
          </span>
        </div>

        @if($hasPhysicalItems)
          <button type="submit" class="btn btn-gold" style="width: 100%; text-align: center; padding: 18px; font-size: 0.92rem;">
            <i class="fa-solid fa-lock"></i> BAYAR PESANAN SEKARANG
          </button>
        @else
          <button type="submit" class="btn btn-gold" style="width: 100%; text-align: center; padding: 18px; font-size: 0.95rem; font-weight: 700; letter-spacing: 0.5px;">
            <i class="fa-solid fa-bolt"></i> BAYAR E-BOOK SEKARANG
          </button>
        @endif

        <div style="font-size: 0.75rem; color: var(--text-muted); text-align: center; margin-top: 16px; line-height: 1.5;">
          <i class="fa-solid fa-shield-halved" style="color: var(--champagne-gold);"></i> Transaksi dijamin 100% aman melalui enkripsi SSL resmi Bianca Veana Bookstore.
        </div>
      </div>

    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  const baseSubtotal = {{ $subtotal }};
  function updateShipping(cost) {
    document.getElementById('shipping-display').innerText = 'Rp ' + cost.toLocaleString('id-ID');
    const total = baseSubtotal + cost;
    document.getElementById('total-display').innerText = 'Rp ' + total.toLocaleString('id-ID');
  }
</script>
@endpush
