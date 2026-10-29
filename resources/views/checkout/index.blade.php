@extends('layouts.app')

@section('title', 'Pembayaran & Checkout — BIANCA VEANA')

@section('content')
<div class="container" style="padding: 60px 20px;">
  
  <div style="text-align: center; margin-bottom: 40px;">
    <span class="section-label">PROSES AMAN & RESMI</span>
    <h1 style="font-family: var(--font-serif); font-size: 2.4rem; color: var(--ocean-navy); margin: 6px 0 10px;">
      {{ $hasPhysicalItems ? 'Checkout Pesanan Buku' : 'Checkout & Akses E-Book Digital' }}
    </h1>
    <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 600px; margin: 0 auto;">
      @if($hasPhysicalItems)
        Pesanan buku fisik Anda dikemas eksklusif dengan bubble wrap tebal dan asuransi pengiriman langsung dari butik resmi kami di Tebet, Jakarta Selatan.
      @else
        Pembelian e-book digital diproses instan 24/7. Tautan unduhan dan lisensi membaca resmi akan langsung dikirimkan ke alamat email dan WhatsApp Anda.
      @endif
    </p>
  </div>

  @if(isset($errors) && $errors->any())
    <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 16px 20px; border-radius: 6px; margin-bottom: 30px;">
      <strong style="display: block; margin-bottom: 6px;"><i class="fa-solid fa-triangle-exclamation"></i> Mohon lengkapi data berikut:</strong>
      <ul style="margin: 0; padding-left: 20px; font-size: 0.88rem;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 40px; align-items: start;">
      
      <!-- Left Column: Checkout Forms -->
      <div>

        @if(!$hasPhysicalItems)
          <!-- ==========================================
               DIGITAL ONLY CHECKOUT (NO SHIPPING ADDRESS)
               ========================================== -->
          <div style="background: linear-gradient(135deg, #172B49 0%, #203A5E 100%); color: #F4EBDD; border-radius: var(--radius-md); padding: 22px 26px; margin-bottom: 24px; border: 1.5px solid var(--champagne-gold); display: flex; align-items: center; justify-content: space-between; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
              <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(198, 161, 107, 0.2); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                <i class="fa-solid fa-bolt"></i>
              </div>
              <div>
                <strong style="color: #FFF; font-size: 1rem; display: block;">Format Digital Instan (Bebas Ongkir)</strong>
                <span style="font-size: 0.8rem; color: #D1D5DB;">Pesanan e-book murni tidak memerlukan kurir pengiriman fisik. Bebas biaya kirim (Rp 0).</span>
              </div>
            </div>
            <span style="background: var(--champagne-gold); color: #0F172A; padding: 4px 12px; border-radius: 4px; font-weight: 700; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
              Rp 0 Ongkir
            </span>
          </div>

          <!-- 1. Customer Information for Digital Delivery -->
          <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 32px; margin-bottom: 28px; box-shadow: var(--shadow-sm);">
            <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
              <i class="fa-solid fa-envelope-open-text" style="color: var(--champagne-gold);"></i> 1. Informasi Kontak & Tujuan File Digital
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Nama Lengkap Pembeli *</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="Contoh: Clara Maharani" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              </div>
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Nomor WhatsApp Aktif *</label>
                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required placeholder="Contoh: 081234567890" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
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
            <input type="hidden" name="shipping_cost" id="input_shipping_cost" value="0">
          </div>

        @else
          <!-- ==========================================
               PHYSICAL ORDER FLOW (CUSTOMER CHOOSES ADDRESS)
               ========================================== -->

          <!-- Store Origin & Weight Info Banner -->
          <div style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 16px 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 12px;">
              <div style="width: 38px; height: 38px; border-radius: 6px; background: #EEF2FF; color: #4338CA; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                <i class="fa-solid fa-store"></i>
              </div>
              <div>
                <div style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700; color: #64748B; letter-spacing: 0.5px;">Lokasi Gudang Asal Toko</div>
                <div style="font-size: 0.85rem; font-weight: 700; color: #0F172A;">
                  Tebet Timur, Tebet, Jakarta Selatan (12820)
                </div>
              </div>
            </div>

            <div style="display: flex; gap: 14px; align-items: center;">
              <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 6px 14px; border-radius: 6px; font-size: 0.8rem; color: #334155;">
                <i class="fa-solid fa-weight-hanging" style="color: var(--champagne-gold);"></i> Berat Total: <strong>{{ number_format($totalWeight) }} gram ({{ $weightInKg }} kg)</strong>
              </div>
            </div>
          </div>

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
                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required placeholder="Contoh: 081234567890" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              </div>
            </div>
            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Alamat Email (Untuk Konfirmasi Pesanan & Resi) *</label>
              <input type="email" name="customer_email" value="{{ old('customer_email') }}" required placeholder="email.anda@gmail.com" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              <span style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; display: block;">Nomor resi ekspedisi dan nota resmi akan otomatis dikirimkan ke email ini.</span>
            </div>
          </div>

          <!-- 2. Shipping Destination Address (Step-by-Step Selection) -->
          <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 32px; margin-bottom: 28px; box-shadow: var(--shadow-sm);">
            <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
              <i class="fa-solid fa-location-dot" style="color: var(--champagne-gold);"></i> 2. Alamat Tujuan Pengiriman Buku
            </h3>

            <!-- 2.1 Dropdown Provinsi & Kota/Kabupaten -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">
                  Provinsi Tujuan *
                </label>
                <select id="shipping_province" name="province" required onchange="onProvinceChanged(this.value)" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem; background: #FFF;">
                  <option value="">-- Pilih Provinsi --</option>
                  @foreach($provincesAndCities as $provName => $cities)
                    <option value="{{ $provName }}" {{ $provName === 'DKI Jakarta' ? 'selected' : '' }}>
                      {{ $provName }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">
                  Kota / Kabupaten Tujuan *
                </label>
                <select id="shipping_city" name="city" required onchange="onCityChanged(this.value)" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--champagne-gold); border-radius: 4px; font-size: 0.9rem; background: #FFFDF9;">
                  <!-- Populated by JavaScript -->
                </select>
              </div>
            </div>

            <!-- 2.2 Kecamatan & Kode Pos -->
            <div style="display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 18px; margin-bottom: 18px;">
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">
                  Kecamatan (Opsional / Pelengkap)
                </label>
                <input type="text" name="district" id="shipping_district" value="{{ old('district') }}" placeholder="Contoh: Tebet / Gubeng / Coblong / Sukajadi..." style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              </div>

              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">
                  Kode Pos *
                </label>
                <input type="text" id="shipping_postal_code" name="postal_code" value="{{ old('postal_code', '12820') }}" required placeholder="Contoh: 12820" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
              </div>
            </div>

            <!-- 2.3 Alamat Lengkap & Catatan -->
            <div style="margin-bottom: 18px;">
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">
                Alamat Lengkap / Jalan / No. Rumah / RT RW / Patokan *
              </label>
              <textarea name="shipping_address" required rows="3" placeholder="Contoh: Jl. Anggrek No. 12, RT 02 / RW 05, Blok C, Patokan depan gerbang masjid..." style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">{{ old('shipping_address') }}</textarea>
            </div>

            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">
                Catatan Khusus untuk Kurir (Opsional)
              </label>
              <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Contoh: Titipkan ke satpam jika sedang keluar rumah" style="width: 100%; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.9rem;">
            </div>

            <!-- Hidden field for destination ID used by RajaOngkir -->
            <input type="hidden" id="selected_destination_id" name="destination_id" value="17589">
          </div>

          <!-- 3. Dynamic Courier Selection & Real-Time Rates from RajaOngkir -->
          <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 32px; margin-bottom: 28px; box-shadow: var(--shadow-sm);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
              <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-truck" style="color: var(--champagne-gold);"></i> 3. Pilihan Ekspedisi Terpercaya (J&T, SiCepat, JNE)
              </h3>
              <span id="rate_status_badge" style="font-size: 0.75rem; background: #ECFDF5; color: #047857; padding: 4px 10px; border-radius: 4px; font-weight: 600;">
                <i class="fa-solid fa-check"></i> Tarif resmi terhitung
              </span>
            </div>

            <!-- Courier Options Container -->
            <div id="courier_options_container" style="display: flex; flex-direction: column; gap: 12px;">
              @foreach($initialCourierRates as $index => $rate)
                <label class="courier-card" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border: 1.5px solid {{ $index === 0 ? 'var(--champagne-gold)' : 'var(--soft-beige)' }}; border-radius: 6px; cursor: pointer; background: {{ $index === 0 ? 'var(--ivory)' : '#FFFFFF' }}; transition: all 0.2s ease;">
                  <div style="display: flex; align-items: center; gap: 14px;">
                    <input type="radio" name="courier" value="{{ $rate['name'] }}" {{ $index === 0 ? 'checked' : '' }} onchange="selectCourierRate('{{ $rate['name'] }}', {{ $rate['cost'] }})">
                    <div>
                      <strong style="color: var(--ocean-navy); font-size: 0.95rem;">{{ $rate['label'] }}</strong>
                      <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 2px;">
                        <i class="fa-solid fa-clock"></i> Estimasi tiba {{ $rate['etd'] }} ({{ $rate['description'] }})
                      </div>
                    </div>
                  </div>
                  <div style="font-weight: 700; color: var(--ocean-navy); font-size: 1.05rem;">
                    {{ $rate['formatted_cost'] }}
                  </div>
                </label>
              @endforeach
            </div>

            <!-- Hidden field for actual shipping cost submitted to server -->
            <input type="hidden" name="shipping_cost" id="input_shipping_cost" value="{{ $initialCourierRates[0]['cost'] ?? 10000 }}">
          </div>
        @endif

        <!-- Payment Method Section -->
        <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); padding: 32px; box-shadow: var(--shadow-sm);">
          <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-credit-card" style="color: var(--champagne-gold);"></i> 
            {{ $hasPhysicalItems ? '4. Metode Pembayaran Resmi Indonesia' : '3. Metode Pembayaran Resmi Indonesia' }}
          </h3>
          <div style="display: flex; flex-direction: column; gap: 12px;">
            <label style="display: flex; align-items: center; justify-content: space-between; padding: 18px 20px; border: 2px solid var(--champagne-gold); border-radius: 8px; cursor: pointer; background: var(--ivory);">
              <div style="display: flex; align-items: center; gap: 14px;">
                <input type="radio" name="payment_method" value="Midtrans Snap (QRIS, VA BCA/Mandiri/BRI, E-Wallet)" checked>
                <div>
                  <strong style="font-size: 0.98rem; color: var(--ocean-navy);">Midtrans Payment Gateway (QRIS & Virtual Account)</strong>
                  <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 3px;">
                    Scan QRIS instan dari semua m-Banking (BCA, Mandiri, BRI, BNI) & E-Wallet (GoPay, OVO, ShopeePay, DANA). Verifikasi otomatis 24/7.
                  </div>
                </div>
              </div>
              <span style="font-size: 0.72rem; background: var(--champagne-gold); color: var(--ocean-navy-deep); padding: 5px 10px; border-radius: 4px; font-weight: 700; white-space: nowrap;">
                OTOMATIS & INSTAN
              </span>
            </label>
          </div>
        </div>
      </div>

      <!-- Right Column: Sticky Order Summary -->
      <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--champagne-gold); padding: 30px; box-shadow: var(--shadow-md); position: sticky; top: 100px;">
        <h3 style="font-family: var(--font-serif); font-size: 1.4rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--soft-beige);">
          Rincian Pesanan
        </h3>

        <div style="max-height: 240px; overflow-y: auto; margin-bottom: 20px; border-bottom: 1px solid var(--soft-beige); padding-bottom: 14px;">
          @foreach($cart as $item)
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.88rem;">
              <div>
                <strong>{{ $item['title'] }}</strong>
                @if(!empty($item['is_preorder']))
                  <span style="display: block; font-size: 0.72rem; color: #92400E; font-weight: 700; margin: 2px 0;">
                    <i class="fa-solid fa-clock-rotate-left"></i> Pre-Order: Estimasi 45 - 60 Hari
                  </span>
                @endif
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
            {{ $hasPhysicalItems ? ('Rp ' . number_format($initialCourierRates[0]['cost'] ?? 10000, 0, ',', '.')) : 'Gratis (E-Book)' }}
          </span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 1.25rem; font-weight: 700; color: var(--ocean-navy); padding-top: 14px; border-top: 1px solid var(--soft-beige);">
          <span>Total Pembayaran:</span>
          <span id="total-display" style="color: var(--champagne-gold);">
            Rp {{ number_format($subtotal + ($hasPhysicalItems ? ($initialCourierRates[0]['cost'] ?? 10000) : 0), 0, ',', '.') }}
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
  let currentShippingCost = {{ $hasPhysicalItems ? ($initialCourierRates[0]['cost'] ?? 10000) : 0 }};

  // Provinces and Cities JSON dataset
  const provincesData = @json($provincesAndCities ?? []);

  function selectCourierRate(courierName, cost) {
    currentShippingCost = cost;
    document.getElementById('input_shipping_cost').value = cost;
    document.getElementById('shipping-display').innerText = 'Rp ' + cost.toLocaleString('id-ID');
    const total = baseSubtotal + cost;
    document.getElementById('total-display').innerText = 'Rp ' + total.toLocaleString('id-ID');

    document.querySelectorAll('.courier-card').forEach(card => {
      const radio = card.querySelector('input[type="radio"]');
      if (radio && radio.checked) {
        card.style.borderColor = 'var(--champagne-gold)';
        card.style.background = 'var(--ivory)';
      } else {
        card.style.borderColor = 'var(--soft-beige)';
        card.style.background = '#FFFFFF';
      }
    });
  }

  function onProvinceChanged(provName) {
    const citySelect = document.getElementById('shipping_city');
    citySelect.innerHTML = '';

    if (!provName || !provincesData[provName]) {
      citySelect.innerHTML = '<option value="">-- Pilih Provinsi Dahulu --</option>';
      return;
    }

    const cities = provincesData[provName];
    let html = '<option value="">-- Pilih Kota / Kabupaten --</option>';
    cities.forEach((c, idx) => {
      const val = `${c.id}|${c.name}|${c.postal || ''}`;
      html += `<option value="${val}" ${idx === 0 ? 'selected' : ''}>${c.name}</option>`;
    });
    citySelect.innerHTML = html;

    // Trigger calculation for the first city
    if (cities.length > 0) {
      onCityChanged(citySelect.value);
    }
  }

  async function onCityChanged(cityVal) {
    if (!cityVal) return;
    const parts = cityVal.split('|');
    const destinationId = parseInt(parts[0]);
    const cityName = parts[1] || '';
    const postalCode = parts[2] || '';

    // Update destination ID and postal code
    document.getElementById('selected_destination_id').value = destinationId;
    if (postalCode) {
      document.getElementById('shipping_postal_code').value = postalCode;
    }

    const container = document.getElementById('courier_options_container');
    const statusBadge = document.getElementById('rate_status_badge');
    statusBadge.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menghitung ongkir ke ' + cityName + '...';
    statusBadge.style.background = '#FEF3C7';
    statusBadge.style.color = '#92400E';

    try {
      const res = await fetch('/shipping/calculate', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ destination_id: destinationId })
      });

      const data = await res.json();
      const rates = data.rates || [];

      if (rates.length === 0) {
        container.innerHTML = '<div style="padding: 16px; background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 6px; font-size: 0.88rem; color: #B45309;">Layanan kurir reguler tidak tersedia untuk lokasi ini. Silakan hubungi admin.</div>';
        return;
      }

      let html = '';
      rates.forEach((rate, idx) => {
        const isChecked = idx === 0;
        html += `
          <label class="courier-card" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border: 1.5px solid ${isChecked ? 'var(--champagne-gold)' : 'var(--soft-beige)'}; border-radius: 6px; cursor: pointer; background: ${isChecked ? 'var(--ivory)' : '#FFFFFF'}; transition: all 0.2s ease;">
            <div style="display: flex; align-items: center; gap: 14px;">
              <input type="radio" name="courier" value="${rate.name}" ${isChecked ? 'checked' : ''} onchange="selectCourierRate('${rate.name}', ${rate.cost})">
              <div>
                <strong style="color: var(--ocean-navy); font-size: 0.95rem;">${rate.label}</strong>
                <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 2px;">
                  <i class="fa-solid fa-clock"></i> Estimasi tiba ${rate.etd} (${rate.description})
                </div>
              </div>
            </div>
            <div style="font-weight: 700; color: var(--ocean-navy); font-size: 1.05rem;">
              ${rate.formatted_cost}
            </div>
          </label>
        `;
      });
      container.innerHTML = html;

      if (rates.length > 0) {
        selectCourierRate(rates[0].name, rates[0].cost);
      }

      statusBadge.innerHTML = '<i class="fa-solid fa-check"></i> Tarif terhitung untuk ' + cityName;
      statusBadge.style.background = '#ECFDF5';
      statusBadge.style.color = '#047857';

    } catch (e) {
      console.error(e);
      statusBadge.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Gagal menghitung tarif';
    }
  }

  // Initialize cities for default selected province on page load
  document.addEventListener('DOMContentLoaded', function() {
    const provSelect = document.getElementById('shipping_province');
    if (provSelect && provSelect.value) {
      const currentProv = provSelect.value;
      const citySelect = document.getElementById('shipping_city');
      const cities = provincesData[currentProv] || [];
      let html = '<option value="">-- Pilih Kota / Kabupaten --</option>';
      cities.forEach((c, idx) => {
        const val = `${c.id}|${c.name}|${c.postal || ''}`;
        html += `<option value="${val}" ${idx === 0 ? 'selected' : ''}>${c.name}</option>`;
      });
      citySelect.innerHTML = html;
    }
  });
</script>
@endpush
