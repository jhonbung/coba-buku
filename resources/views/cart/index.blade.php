@extends('layouts.app')

@section('title', 'Keranjang Belanja — BIANCA VEANA')

@section('content')
<div style="background: var(--ocean-navy); color: var(--ivory); padding: 40px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container text-center" style="text-align: center;">
    <h1 style="font-size: 2.4rem; margin: 0;">KERANJANG BELANJA ANDA</h1>
    <p style="color: #BAC7D7; margin-top: 8px;">Periksa kembali koleksi buku dan merchandise sebelum melanjutkan ke pembayaran.</p>
  </div>
</div>

<div class="container" style="padding: 60px 24px;">
  @if(!empty($cart) && count($cart) > 0)
    <div style="display: grid; grid-template-columns: 1.4fr 0.6fr; gap: 40px; align-items: start;">
      <!-- Left: Items Table -->
      <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); box-shadow: var(--shadow-sm); overflow: hidden;">
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
        <div style="padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; background: #FAF7F2;">
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
      <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--champagne-gold); padding: 30px; box-shadow: var(--shadow-sm); position: sticky; top: 100px;">
        <h3 style="font-family: var(--font-serif); font-size: 1.4rem; color: var(--ocean-navy); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--soft-beige);">
          Ringkasan Belanja
        </h3>

        <div style="display: flex; justify-content: space-between; margin-bottom: 14px; font-size: 0.95rem;">
          <span style="color: var(--text-muted);">Total Item:</span>
          <span style="font-weight: 600;">{{ array_sum(array_column($cart, 'quantity')) }} produk</span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 1.15rem; font-weight: 700; color: var(--ocean-navy); padding-top: 14px; border-top: 1px solid var(--soft-beige);">
          <span>Subtotal:</span>
          <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
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
