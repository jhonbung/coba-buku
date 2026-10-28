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
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
      <button type="button" onclick="location.reload()" class="btn" style="background: #FFFFFF; border: 1px solid #CBD5E1; color: #334155; padding: 9px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.03);" title="Muat Ulang Pesanan Terbaru">
        <i class="fa-solid fa-arrows-rotate" style="color: #64748B;"></i> Refresh Realtime
      </button>

      <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 9px 16px; border-radius: 8px; font-size: 0.82rem; color: #1E293B; display: flex; align-items: center; gap: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
        <i class="fa-solid fa-receipt" style="color: var(--admin-gold);"></i> Total: <strong>{{ $orders->total() }} Transaksi</strong>
      </div>
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
          @php
            $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
            if (str_starts_with($cleanPhone, '0')) {
                $cleanPhone = '62' . substr($cleanPhone, 1);
            }
            $itemsList = $order->items->map(fn($i) => $i->product_title . " (x{$i->quantity})")->implode(', ');
            $trackingUrl = "https://cekresi.com/?noresi=" . urlencode($order->tracking_number);

            $waText = "Halo Kak {$order->customer_name}! 👋\n\n"
                . "Kabar baik dari *Bianca Veana Official Bookstore* ✨\n"
                . "Pesanan buku Anda dengan invoice *#{$order->order_number}* telah diserahkan ke kurir dan *SEDANG DALAM PERJALANAN* 🚚\n\n"
                . "📦 *Daftar Buku:* {$itemsList}\n"
                . "🚚 *Ekspedisi:* {$order->courier}\n"
                . "🏷️ *Nomor Resi Resmi:* {$order->tracking_number}\n"
                . "📍 *Alamat Tujuan:* {$order->shipping_address}, {$order->city}\n\n"
                . "🔍 Lacak perjalanan paket Anda secara real-time di:\n{$trackingUrl}\n\n"
                . "Terima kasih banyak telah mengoleksi karya resmi Bianca Veana Universe! Selamat membaca! 📖";
            $waUrl = "https://wa.me/{$cleanPhone}?text=" . rawurlencode($waText);
          @endphp
          <tr style="border-bottom: 1px solid #F0EAE1;">
            <td style="padding: 16px 20px; vertical-align: top;">
              <strong style="color: var(--ocean-navy); font-size: 0.95rem;">#{{ $order->order_number }}</strong>
              <div style="font-size: 0.78rem; color: #1E293B; margin-top: 4px; font-weight: 600; display: flex; align-items: center; gap: 5px;">
                <i class="fa-regular fa-clock" style="color: #64748B;"></i> {{ $order->created_at->format('d M Y, H:i') }} WIB
              </div>
              <div style="font-size: 0.7rem; color: #059669; font-weight: 600; margin-top: 2px; display: flex; align-items: center; gap: 4px;">
                <i class="fa-solid fa-stopwatch" style="font-size: 0.68rem;"></i> {{ $order->created_at->diffForHumans() }}
              </div>
              <div style="font-size: 0.75rem; color: #15803D; font-weight: 600; margin-top: 6px;">
                <i class="fa-solid fa-check-double"></i> {{ $order->payment_method }}
              </div>
            </td>

            <td style="padding: 16px 20px; vertical-align: top; max-width: 250px;">
              <strong>{{ $order->customer_name }}</strong>
              <div style="font-size: 0.78rem; color: var(--text-muted);"><i class="fa-brands fa-whatsapp" style="color: #16A34A;"></i> {{ $order->customer_phone }}</div>
              @if(str_contains($order->shipping_address, 'Digital') || $order->courier === 'Digital Delivery (Email Langsung)')
                <div style="font-size: 0.78rem; color: #1E40AF; margin-top: 4px; font-weight: 600;">
                  <i class="fa-solid fa-envelope"></i> {{ $order->customer_email }}
                </div>
                <div style="font-size: 0.75rem; background: #DBEAFE; color: #1E40AF; display: inline-block; padding: 2px 8px; border-radius: 4px; margin-top: 6px; font-weight: 700;">
                  <i class="fa-solid fa-bolt"></i> Akses Digital Instan
                </div>
              @else
                <div style="font-size: 0.78rem; color: var(--text-dark); margin-top: 4px; line-height: 1.4;">
                  {{ $order->shipping_address }}, {{ $order->city }}
                </div>
                <div style="font-size: 0.75rem; background: var(--ivory); border: 1px solid #E2E8F0; display: inline-block; padding: 2px 8px; border-radius: 4px; margin-top: 6px; font-weight: 600; color: var(--ocean-navy);">
                  <i class="fa-solid fa-truck"></i> {{ $order->courier }}
                </div>
              @endif
            </td>

            <td style="padding: 16px 20px; vertical-align: top;">
              <ul style="list-style: none; font-size: 0.82rem; padding: 0; margin: 0;">
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
              @php
                $statusColors = [
                    'pending' => ['bg' => '#FEF3C7', 'color' => '#B45309', 'label' => 'Menunggu Bayar'],
                    'processing' => ['bg' => '#DBEAFE', 'color' => '#1E40AF', 'label' => 'Sedang Dikemas'],
                    'shipped' => ['bg' => '#F3E8FF', 'color' => '#7E22CE', 'label' => 'Sedang Dikirim'],
                    'delivered' => ['bg' => '#DCFCE7', 'color' => '#15803D', 'label' => 'Selesai / Tiba'],
                    'cancelled' => ['bg' => '#FEE2E2', 'color' => '#B91C1C', 'label' => 'Dibatalkan'],
                ];
                $st = $statusColors[strtolower($order->order_status)] ?? ['bg' => '#F1F5F9', 'color' => '#334155', 'label' => ucfirst($order->order_status)];
              @endphp

              <span style="background: {{ $st['bg'] }}; color: {{ $st['color'] }}; padding: 4px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; display: inline-block;">
                {{ $st['label'] }}
              </span>

              @if($order->tracking_number && $order->tracking_number !== 'DIGITAL-ACCESS')
                <div style="font-size: 0.78rem; background: #FFFFFF; border: 1.5px solid #CBD5E1; padding: 5px 8px; border-radius: 6px; margin-top: 8px; font-weight: 700; color: var(--ocean-navy); display: flex; align-items: center; justify-content: space-between; gap: 4px;">
                  <span style="letter-spacing: 0.5px;">{{ $order->tracking_number }}</span>
                  <button type="button" onclick="navigator.clipboard.writeText('{{ $order->tracking_number }}'); alert('Resi disalin: {{ $order->tracking_number }}')" style="background: none; border: none; cursor: pointer; color: #64748B; padding: 2px;" title="Salin Nomor Resi">
                    <i class="fa-regular fa-copy"></i>
                  </button>
                </div>
                <div style="margin-top: 4px;">
                  <a href="{{ $trackingUrl }}" target="_blank" style="font-size: 0.7rem; color: #2563EB; text-decoration: underline; font-weight: 600;">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Cek di CekResi.com
                  </a>
                </div>
              @endif
            </td>

            <td style="padding: 16px 20px; text-align: center; vertical-align: top;">
              <div style="display: flex; flex-direction: column; gap: 6px; align-items: stretch; max-width: 170px; margin: 0 auto;">
                <!-- Tombol Update Resi & Status -->
                <button type="button" onclick="openResiModal('{{ $order->order_number }}', '{{ addslashes($order->customer_name) }}', '{{ $order->order_status }}', '{{ $order->tracking_number }}', '{{ addslashes($order->courier) }}')" class="btn" style="background: #EEF2FF; color: #4338CA; border: 1px solid #C7D2FE; padding: 6px 10px; font-size: 0.75rem; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                  <i class="fa-solid fa-truck-fast"></i> Input / Ganti Resi
                </button>

                <!-- Tombol Kirim WhatsApp Resi -->
                @if($order->customer_phone && $order->tracking_number && $order->tracking_number !== 'DIGITAL-ACCESS')
                  <a href="{{ $waUrl }}" target="_blank" class="btn" style="background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; padding: 6px 10px; font-size: 0.75rem; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none;" title="Kirim otomatis rincian nomor resi ke WhatsApp Customer">
                    <i class="fa-brands fa-whatsapp" style="font-size: 0.9rem;"></i> Kirim Resi via WA
                  </a>
                @endif

                <!-- Tombol Cetak Resi -->
                <a href="{{ route('admin.orders.resi', $order->order_number) }}" target="_blank" class="btn btn-gold" style="padding: 6px 10px; font-size: 0.75rem; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                  <i class="fa-solid fa-print"></i> Cetak Label Resi
                </a>
              </div>
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

<!-- Modal Update Resi & Status -->
<div id="modalUpdateResi" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
  <div style="background: #FFFFFF; border-radius: 14px; width: 100%; max-width: 500px; padding: 28px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid #E2E8F0; position: relative;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #F1F5F9; padding-bottom: 14px;">
      <h3 style="margin: 0; font-size: 1.15rem; color: #0F172A; font-family: var(--font-serif); display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-truck-fast" style="color: #D4AF37;"></i> Input / Ganti Resi & Status
      </h3>
      <button type="button" onclick="closeResiModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; cursor: pointer; color: #94A3B8; padding: 0 4px;" title="Tutup">&times;</button>
    </div>

    <form id="formUpdateResi" method="POST" action="">
      @csrf
      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Invoice & Penerima</label>
        <div id="modalOrderInfo" style="background: #F8FAFC; border: 1.5px solid #E2E8F0; padding: 10px 14px; border-radius: 8px; font-size: 0.88rem; color: #0F172A; font-weight: 600;"></div>
      </div>

      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Status Pengiriman</label>
        <select name="order_status" id="modalOrderStatus" style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; background: #FFF; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#CBD5E1'">
          <option value="pending">Menunggu Pembayaran (Pending)</option>
          <option value="processing">Sedang Dikemas (Processing)</option>
          <option value="shipped">Sedang Dikirim (Shipped)</option>
          <option value="delivered">Selesai / Terkirim (Delivered)</option>
          <option value="cancelled">Dibatalkan (Cancelled)</option>
        </select>
      </div>

      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
          Nomor Resi Asli Ekspedisi (JNE / SiCepat / J&T / Anteraja)
        </label>
        <input type="text" name="tracking_number" id="modalTrackingNumber" placeholder="Contoh: 004218991234 atau JNE1092837482" style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#CBD5E1'">
        <div style="font-size: 0.72rem; color: #64748B; margin-top: 4px;">
          *Masukkan nomor barcode/resi yang tercetak saat Anda menyerahkan paket ke agen kurir.
        </div>
      </div>

      <div style="margin-bottom: 22px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Nama Kurir / Layanan</label>
        <input type="text" name="courier" id="modalCourier" placeholder="Contoh: SiCepat Express (HALU) atau JNE REG" style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#CBD5E1'">
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" onclick="closeResiModal()" class="btn" style="background: #F1F5F9; color: #475569; padding: 10px 18px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; border: none;">Batal</button>
        <button type="submit" class="btn btn-gold" style="padding: 10px 22px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; cursor: pointer;">
          <i class="fa-solid fa-save"></i> Simpan & Update Resi
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openResiModal(orderNumber, customerName, currentStatus, currentTracking, currentCourier) {
  document.getElementById('formUpdateResi').action = '/admin/orders/' + orderNumber + '/status';
  document.getElementById('modalOrderInfo').textContent = '#' + orderNumber + ' — ' + customerName;
  document.getElementById('modalOrderStatus').value = currentStatus || 'processing';
  
  // Jangan isi jika resi masih dummy / default BV-
  let cleanTracking = currentTracking || '';
  if (cleanTracking === 'DIGITAL-ACCESS' || cleanTracking.startsWith('BV-')) {
    cleanTracking = '';
  }
  document.getElementById('modalTrackingNumber').value = cleanTracking;
  document.getElementById('modalCourier').value = currentCourier || '';
  
  const modal = document.getElementById('modalUpdateResi');
  modal.style.display = 'flex';
}

function closeResiModal() {
  document.getElementById('modalUpdateResi').style.display = 'none';
}

// Tutup modal jika klik di luar area box
window.addEventListener('click', function(e) {
  const modal = document.getElementById('modalUpdateResi');
  if (e.target === modal) {
    closeResiModal();
  }
});
</script>
@endsection
