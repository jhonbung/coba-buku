<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resi Pengiriman — #{{ $order->order_number }}</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Montserrat', sans-serif;
      color: #111827;
      background: #F3F4F6;
      padding: 24px;
    }
    .print-actions {
      max-width: 650px;
      margin: 0 auto 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .btn-print {
      background: #172B49;
      color: #F4EBDD;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      font-weight: 600;
      cursor: pointer;
      font-size: 0.9rem;
    }
    .resi-container {
      max-width: 650px;
      margin: 0 auto;
      background: #FFFFFF;
      border: 2px dashed #172B49;
      padding: 24px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .resi-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #172B49;
      padding-bottom: 14px;
      margin-bottom: 16px;
    }
    .resi-brand-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.4rem;
      font-weight: 700;
      color: #172B49;
      letter-spacing: 2px;
    }
    .resi-courier-badge {
      background: #172B49;
      color: #C6A16B;
      padding: 6px 14px;
      border-radius: 4px;
      font-weight: 700;
      font-size: 0.9rem;
      text-transform: uppercase;
    }
    .barcode-box {
      text-align: center;
      background: #FAFAFA;
      border: 1px solid #E5E7EB;
      padding: 12px;
      margin-bottom: 16px;
    }
    .barcode-lines {
      height: 48px;
      background: repeating-linear-gradient(90deg, #111 0, #111 3px, transparent 3px, transparent 6px, #111 6px, #111 10px, transparent 10px, transparent 13px);
      max-width: 380px;
      margin: 0 auto 6px;
    }
    .resi-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      border-bottom: 1px solid #E5E7EB;
      padding-bottom: 16px;
      margin-bottom: 16px;
    }
    .party-title {
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #6B7280;
      font-weight: 700;
      margin-bottom: 4px;
    }
    .party-name {
      font-size: 0.95rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 4px;
    }
    .party-desc {
      font-size: 0.82rem;
      color: #374151;
      line-height: 1.5;
    }
    .items-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.82rem;
      margin-bottom: 16px;
    }
    .items-table th, .items-table td {
      padding: 8px 10px;
      border: 1px solid #E5E7EB;
      text-align: left;
    }
    .items-table th {
      background: #F9FAFB;
      font-weight: 600;
    }
    .resi-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #F9FAFB;
      padding: 12px;
      border-radius: 4px;
      font-size: 0.78rem;
    }
    .fragile-badge {
      border: 2px solid #DC2626;
      color: #DC2626;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 3px;
      text-transform: uppercase;
      font-size: 0.75rem;
    }

    @media print {
      body {
        background: #FFF;
        padding: 0;
      }
      .print-actions {
        display: none;
      }
      .resi-container {
        border: 2px solid #000;
        box-shadow: none;
        max-width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="print-actions">
    <a href="{{ route('admin.orders') }}" style="color: #172B49; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
      &larr; Kembali ke Daftar Pesanan
    </a>
    <button onclick="window.print()" class="btn-print">
      &#128438; CETAK RESI PENGIRIMAN (AIRWAY BILL)
    </button>
  </div>

  <div class="resi-container">
    <div class="resi-header">
      <div style="display: flex; align-items: center; gap: 12px;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 48px; width: auto; object-fit: contain;">
        <div>
          <div class="resi-brand-title">BIANCA VEANA</div>
          <div style="font-size: 0.72rem; letter-spacing: 2px; color: #C6A16B; font-weight: 600;">OFFICIAL BOOKSTORE SHIPPING LABEL</div>
        </div>
      </div>
      <div class="resi-courier-badge">
        {{ $order->courier }}
      </div>
    </div>

    <div class="barcode-box">
      <div class="barcode-lines"></div>
      <div style="font-family: monospace; font-size: 0.95rem; font-weight: 700; letter-spacing: 3px;">
        {{ $order->tracking_number ?? $order->order_number }}
      </div>
      <div style="font-size: 0.72rem; color: #6B7280; margin-top: 2px;">
        No. Pesanan: #{{ $order->order_number }} · Tanggal: {{ $order->created_at->format('d M Y, H:i') }}
      </div>
    </div>

    <div class="resi-grid">
      <div>
        <div class="party-title">PENGIRIM (SENDER):</div>
        <div class="party-name">BIANCA VEANA BOOKSTORE OFFICIAL</div>
        <div class="party-desc">
          CS/Admin: 0817752901<br>
          Gudang Buku Utama Bianca Veana<br>
          Jakarta Selatan, DKI Jakarta 12190
        </div>
      </div>

      <div>
        <div class="party-title">PENERIMA (RECEIVER):</div>
        <div class="party-name">{{ strtoupper($order->customer_name) }}</div>
        <div class="party-desc">
          <strong>Telp/WA:</strong> {{ $order->customer_phone }}<br>
          @if(str_contains($order->shipping_address, 'Digital') || $order->courier === 'Digital Delivery (Email Langsung)')
            <strong>Email Akses:</strong> {{ $order->customer_email }}<br>
            <strong>Status Pengiriman:</strong> Akses Digital Instan (E-Book)
          @else
            <strong>Alamat:</strong> {{ $order->shipping_address }}<br>
            <strong>Kota/Pos:</strong> {{ $order->city }} {{ $order->postal_code }}
          @endif
        </div>
      </div>
    </div>

    <div style="font-size: 0.75rem; font-weight: 700; margin-bottom: 6px; text-transform: uppercase;">
      Daftar Isi Paket (Checklist Kemasan):
    </div>
    <table class="items-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Judul Buku / Merchandise</th>
          <th style="text-align: center; width: 60px;">Jumlah</th>
          <th style="text-align: center; width: 50px;">Check</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $idx => $item)
          <tr>
            <td>{{ $idx + 1 }}</td>
            <td><strong>{{ $item->product_title }}</strong></td>
            <td style="text-align: center; font-weight: 700;">{{ $item->quantity }} pcs</td>
            <td style="text-align: center;">[ &nbsp; ]</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    @if($order->notes)
      <div style="background: #FEF3C7; border: 1px solid #FCD34D; padding: 8px 12px; border-radius: 4px; font-size: 0.78rem; margin-bottom: 14px;">
        <strong>Catatan Khusus Pembeli:</strong> {{ $order->notes }}
      </div>
    @endif

    <div class="resi-footer">
      <div>
        <span class="fragile-badge">FRAGILE · JANGAN DIBANTING / BUKU ASLI</span>
      </div>
      <div style="text-align: right; font-weight: 600;">
        Status Pembayaran: <span style="color: #15803D;">LUNAS (PAID)</span>
      </div>
    </div>
  </div>

</body>
</html>
