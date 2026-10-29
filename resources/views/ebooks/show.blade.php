@extends('layouts.app')

@section('title', 'E-Book & Bab Digital ' . $book->title . ' — Bianca Veana Official')

@section('content')
<!-- Breadcrumbs -->
<div style="background: var(--ivory); padding: 14px 0; border-bottom: 1px solid var(--soft-beige); font-size: 0.82rem;">
  <div class="container">
    <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none;">Home</a>
    <span style="margin: 0 8px; color: var(--champagne-gold);">/</span>
    <a href="{{ route('ebooks.index') }}" style="color: var(--text-muted); text-decoration: none;">E-Books & Bab Digital</a>
    <span style="margin: 0 8px; color: var(--champagne-gold);">/</span>
    <span style="color: var(--ocean-navy); font-weight: 600;">{{ $book->title }}</span>
  </div>
</div>

<div class="container" style="padding: 50px 24px 80px;">
  <!-- Alert Banner Digital -->
  <div style="background: linear-gradient(135deg, #172B49 0%, #1c365d 100%); color: var(--ivory); border-radius: var(--radius-md); padding: 16px 24px; margin-bottom: 40px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; border: 1.5px solid var(--champagne-gold); box-shadow: var(--shadow-sm);">
    <div style="display: flex; align-items: center; gap: 14px;">
      <div style="width: 42px; height: 42px; border-radius: 50%; background: rgba(198, 161, 107, 0.2); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
        <i class="fa-solid fa-bolt-lightning"></i>
      </div>
      <div>
        <strong style="color: var(--champagne-gold); font-size: 0.95rem; display: block; letter-spacing: 0.5px;">EDISI DIGITAL BIASANYA SIAP BACA INSTAN</strong>
        <span style="font-size: 0.82rem; color: #BAC7D7;">Pembelian E-Book atau Bab Digital otomatis Bebas Ongkir (Rp 0). Tautan Google Drive & file PDF resolusi tinggi dikirim langsung ke email Anda.</span>
      </div>
    </div>
    <span style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10B981; color: #34D399; font-size: 0.75rem; font-weight: 700; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
      <i class="fa-solid fa-check"></i> 100% BEBAS ONGKOS KIRIM
    </span>
  </div>

  <div style="display: grid; grid-template-columns: 0.85fr 1.15fr; gap: 50px; align-items: start;">
    
    <!-- LEFT COLUMN: Book Cover & Digital Features -->
    <div style="position: sticky; top: 100px;">
      <div style="background: var(--ocean-navy-deep); padding: 24px; border-radius: var(--radius-md); border: 2px solid var(--champagne-gold); box-shadow: var(--shadow-lg); text-align: center; position: relative;">
        <img src="{{ asset($book->cover_image) }}" alt="Cover E-Book {{ $book->title }}" style="max-height: 480px; max-width: 100%; margin: 0 auto; border-radius: var(--radius-sm); box-shadow: 0 10px 25px rgba(0,0,0,0.5); display: block;">
        
        <div style="position: absolute; top: 18px; left: 18px; background: rgba(23, 43, 73, 0.9); border: 1px solid var(--champagne-gold); color: var(--champagne-gold); padding: 4px 12px; border-radius: 4px; font-size: 0.72rem; font-weight: 700; letter-spacing: 1px;">
          <i class="fa-solid fa-tablet-screen-button"></i> EDISI DIGITAL
        </div>
      </div>

      <!-- Digital Features List -->
      <div style="background: var(--white); border: 1px solid var(--soft-beige); border-radius: var(--radius-md); padding: 20px; margin-top: 20px; box-shadow: var(--shadow-sm);">
        <h4 style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1.5px; color: var(--ocean-navy); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-circle-info" style="color: var(--champagne-gold);"></i> Spesifikasi Format Digital:
        </h4>
        <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.82rem; color: var(--text-dark); line-height: 1.8;">
          <li style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
            <i class="fa-solid fa-file-pdf" style="color: #E11D48; font-size: 1rem; width: 18px;"></i>
            <span><strong>Format Berkas:</strong> PDF High Quality (Aman & Jernih)</span>
          </li>
          <li style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
            <i class="fa-brands fa-google-drive" style="color: #16A34A; font-size: 1rem; width: 18px;"></i>
            <span><strong>Akses Mirror:</strong> Google Drive Tautan Permanen</span>
          </li>
          <li style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
            <i class="fa-solid fa-mobile-screen" style="color: var(--champagne-gold); font-size: 1rem; width: 18px;"></i>
            <span><strong>Kompatibilitas:</strong> HP Android, iPhone/iPad, PC, Kindle</span>
          </li>
          <li style="display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-envelope-circle-check" style="color: #2563EB; font-size: 1rem; width: 18px;"></i>
            <span><strong>Pengiriman:</strong> Otomatis ke Email (Instan setelah bayar)</span>
          </li>
        </ul>
      </div>

      <!-- Switch to Physical Book Banner -->
      <div style="background: #FFFDF9; border: 1.5px dashed var(--champagne-gold); border-radius: var(--radius-md); padding: 18px 20px; margin-top: 20px; text-align: center;">
        <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--champagne-gold); font-weight: 700; display: block; margin-bottom: 4px;">
          Ingin Edisi Buku Cetak Fisik?
        </span>
        <p style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 12px; line-height: 1.4;">
          Tersedia novel cetak hardcover/softcover bertandatangan penulis & bonus eksklusif.
        </p>
        <a href="{{ route('novels.show', $book->slug) }}" style="display: inline-flex; align-items: center; gap: 8px; font-size: 0.82rem; font-weight: 700; color: var(--ocean-navy); text-decoration: none; background: var(--ivory); padding: 8px 16px; border-radius: 6px; border: 1px solid var(--soft-beige); transition: all 0.2s;" onmouseover="this.style.background='var(--champagne-gold)'; this.style.color='var(--white)';" onmouseout="this.style.background='var(--ivory)'; this.style.color='var(--ocean-navy)';">
          <i class="fa-solid fa-book"></i> Buka Halaman Novel Fisik
        </a>
      </div>
    </div>

    <!-- RIGHT COLUMN: Book Details & Buying Options -->
    <div>
      <span style="font-size: 0.8rem; letter-spacing: 3px; color: var(--champagne-gold); text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">
        {{ $book->series_name ?? 'THE SEVEN NOTONEGORO SERIES' }}
      </span>

      <h1 style="font-family: var(--font-serif); font-size: 2.8rem; color: var(--ocean-navy); margin-bottom: 8px; line-height: 1.15;">
        {{ $book->title }}
      </h1>

      <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
        <span style="font-size: 0.9rem; color: var(--text-muted);">
          Penulis: <strong style="color: var(--ocean-navy);">{{ $book->author ?? 'Bianca Veana' }}</strong>
        </span>
        <span style="color: var(--soft-beige);">•</span>
        <span style="font-size: 0.9rem; color: var(--text-muted);">
          Genre: <strong style="color: var(--ocean-navy);">{{ $book->genre ?? 'Royal Romance' }}</strong>
        </span>
        <span style="background: #EFF6FF; color: #1D4ED8; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 4px; border: 1px solid #BFDBFE;">
          <i class="fa-solid fa-shield-check"></i> E-Book Resmi
        </span>
      </div>

      <!-- Synopsis excerpt -->
      <div style="background: var(--ivory); padding: 18px 22px; border-radius: var(--radius-sm); border-left: 4px solid var(--champagne-gold); margin-bottom: 30px; font-size: 0.88rem; color: var(--text-dark); line-height: 1.7;">
        {{ $book->synopsis }}
      </div>

      <!-- SECTION 1: FULL E-BOOK OPTION (COMPLETE EDITION) -->
      @if($fullEdition)
        <div style="background: #FFFFFF; border: 2px solid var(--champagne-gold); border-radius: var(--radius-md); padding: 24px; margin-bottom: 32px; box-shadow: 0 4px 15px rgba(198, 161, 107, 0.15); position: relative;">
          <div style="position: absolute; top: -12px; left: 24px; background: var(--champagne-gold); color: var(--white); font-size: 0.72rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; padding: 4px 14px; border-radius: 20px; box-shadow: var(--shadow-sm);">
            <i class="fa-solid fa-crown"></i> PILIHAN TERLENGKAP & PALING HEMAT
          </div>

          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 6px; margin-bottom: 14px; flex-wrap: wrap; gap: 12px;">
            <div>
              <h3 style="font-family: var(--font-serif); font-size: 1.4rem; color: var(--ocean-navy); margin-bottom: 4px;">
                {{ $fullEdition->title }}
              </h3>
              <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0; max-width: 500px; line-height: 1.5;">
                {{ $fullEdition->synopsis }}
              </p>
            </div>
            
            <div style="text-align: right;">
              <span style="font-size: 1.7rem; font-weight: 800; color: #15803D; display: block; line-height: 1;">
                {{ $fullEdition->formatted_price }}
              </span>
              @if($fullEdition->original_price)
                <div style="display: flex; align-items: center; gap: 6px; justify-content: flex-end; margin-top: 4px;">
                  <span style="font-size: 0.85rem; color: #9AA5B8; text-decoration: line-through;">
                    {{ $fullEdition->formatted_original_price }}
                  </span>
                  <span style="background: #FFE4E6; color: #E11D48; font-size: 0.7rem; font-weight: 700; padding: 2px 6px; border-radius: 3px;">
                    HEMAT {{ round((($fullEdition->original_price - $fullEdition->price) / $fullEdition->original_price) * 100) }}%
                  </span>
                </div>
              @endif
            </div>
          </div>

          <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--soft-beige); padding-top: 16px; margin-top: 16px; flex-wrap: wrap; gap: 14px;">
            <div style="font-size: 0.78rem; color: var(--text-muted); display: flex; align-items: center; gap: 8px;">
              <i class="fa-solid fa-check-double" style="color: #10B981;"></i> Seluruh Bab Lengkap (Awal s/d Tamat) + Bonus Epilog Digital
            </div>

            <form action="{{ route('cart.add') }}" method="POST" style="margin: 0;">
              @csrf
              <input type="hidden" name="product_id" value="{{ $fullEdition->id }}">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 0.9rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; border-radius: 6px; box-shadow: 0 4px 10px rgba(198, 161, 107, 0.3);">
                <i class="fa-solid fa-cart-shopping"></i> Beli E-Book Lengkap Sekarang
              </button>
            </form>
          </div>
        </div>
      @endif

      <!-- SECTION 2: CHAPTER PARTS (BACA BERTAHAP PER BAB) -->
      <div style="margin-top: 36px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; border-bottom: 2px solid var(--soft-beige); padding-bottom: 12px;">
          <div>
            <h3 style="font-family: var(--font-serif); font-size: 1.45rem; color: var(--ocean-navy); margin: 0;">
              Serial Part Digital (Baca Bertahap Per Bab)
            </h3>
            <span style="font-size: 0.8rem; color: var(--text-muted);">
              Mulai membaca dari bab awal atau bab tertentu yang ingin Anda nikmati lebih dulu:
            </span>
          </div>
          <span style="font-size: 0.78rem; font-weight: 700; color: #15803D; background: #DCFCE7; padding: 4px 12px; border-radius: 20px;">
            Rp 15.000 / part
          </span>
        </div>

        @if($chapterParts->count() > 0)
          <div style="display: flex; flex-direction: column; gap: 18px;">
            @foreach($chapterParts as $part)
              <div style="background: var(--white); border: 1.5px solid var(--soft-beige); border-radius: var(--radius-md); padding: 22px 26px; transition: all 0.25s ease; box-shadow: 0 2px 6px rgba(0,0,0,0.02);" onmouseover="this.style.borderColor='var(--champagne-gold)'; this.style.boxShadow='0 8px 24px rgba(198, 161, 107, 0.15)';" onmouseout="this.style.borderColor='var(--soft-beige)'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.02)';">
                
                <!-- Row 1: Header (Badge, Title, Price, Buy Button) -->
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 12px;">
                  <div style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 260px;">
                    <span style="font-size: 0.75rem; font-weight: 800; background: linear-gradient(135deg, #172B49 0%, #1c365d 100%); color: var(--champagne-gold); border: 1px solid var(--champagne-gold); padding: 4px 10px; border-radius: 6px; letter-spacing: 0.5px; flex-shrink: 0;">
                      PART {{ $part->part_number ?? $loop->iteration }}
                    </span>
                    <h4 style="font-family: var(--font-serif); font-size: 1.25rem; color: var(--ocean-navy); margin: 0; font-weight: 700; line-height: 1.3;">
                      {{ $part->title }}
                    </h4>
                  </div>

                  <div style="display: flex; align-items: center; gap: 16px; flex-shrink: 0;">
                    <div style="text-align: right;">
                      <span style="font-size: 1.35rem; font-weight: 800; color: #15803D; display: block; line-height: 1;">
                        {{ $part->formatted_price }}
                      </span>
                      <span style="font-size: 0.68rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Bebas Ongkir · PDF Instan</span>
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST" style="margin: 0;">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $part->id }}">
                      <input type="hidden" name="quantity" value="1">
                      <button type="submit" class="btn btn-outline" style="padding: 10px 22px; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; border-radius: 6px; border: 1.5px solid var(--champagne-gold); color: var(--ocean-navy); background: #FFFFFF; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='var(--champagne-gold)'; this.style.color='#FFFFFF';" onmouseout="this.style.background='#FFFFFF'; this.style.color='var(--ocean-navy)';">
                        <i class="fa-solid fa-cart-plus"></i> Beli Part Ini
                      </button>
                    </form>
                  </div>
                </div>

                <!-- Row 2: Synopsis Box -->
                @if($part->synopsis)
                  <div style="background: #FAF8F5; border: 1px solid #F0EAE1; border-left: 3.5px solid var(--champagne-gold); border-radius: 0 8px 8px 0; padding: 12px 18px; margin-top: 10px;">
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                      <i class="fa-solid fa-feather-pointed" style="color: var(--champagne-gold); font-size: 0.8rem;"></i>
                      <span style="font-size: 0.72rem; font-weight: 800; color: var(--ocean-navy); text-transform: uppercase; letter-spacing: 1px;">
                        Sinopsis Cerita Part:
                      </span>
                    </div>
                    <p style="font-size: 0.88rem; color: #334155; margin: 0; line-height: 1.65;">
                      {{ $part->synopsis }}
                    </p>
                  </div>
                @else
                  <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 6px; font-style: italic;">
                    <i class="fa-solid fa-circle-info" style="color: var(--champagne-gold); margin-right: 4px;"></i> Akses digital bab e-book resmi karya Bianca Veana Universe. Berkas siap baca dikirim instan via email.
                  </div>
                @endif

              </div>
            @endforeach

              </div>
            @endforeach
          </div>
        @else
          <div style="background: var(--ivory); padding: 20px; border-radius: var(--radius-sm); text-align: center; color: var(--text-muted); font-size: 0.88rem;">
            Saat ini seluruh bab langsung tersedia dalam E-Book Full Novel di atas.
          </div>
        @endif
      </div>

      <!-- FAQ & Keamanan Transaksi Digital -->
      <div style="background: #FAF7F2; border: 1px solid var(--soft-beige); border-radius: var(--radius-md); padding: 22px 26px; margin-top: 40px;">
        <h4 style="font-family: var(--font-serif); font-size: 1.05rem; color: var(--ocean-navy); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-circle-question" style="color: var(--champagne-gold);"></i> Cara Membaca & Menerima E-Book:
        </h4>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; font-size: 0.8rem; color: var(--text-muted); line-height: 1.6;">
          <div>
            <strong style="color: var(--ocean-navy); display: block; margin-bottom: 4px;">1. Pembayaran Otomatis Midtrans</strong>
            Bayar dengan mudah via QRIS (Gopay/OVO/ShopeePay/Dana) atau Virtual Account BCA, Mandiri, BNI, BRI. Verifikasi berjalan real-time detik itu juga.
          </div>
          <div>
            <strong style="color: var(--ocean-navy); display: block; margin-bottom: 4px;">2. Pengiriman Instan ke Email</strong>
            Setelah bayar, Anda langsung mendapatkan email konfirmasi berisi link Google Drive pribadi dan tombol unduh PDF resmi siap simpan selamanya.
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- OTHER NOTONEGORO E-BOOKS CAROUSEL/GRID -->
  @if($otherEbooks->count() > 0)
    <div style="margin-top: 80px; border-top: 2px solid var(--soft-beige); padding-top: 50px;">
      <div style="text-align: center; margin-bottom: 36px;">
        <span style="font-size: 0.75rem; letter-spacing: 2px; text-transform: uppercase; color: var(--champagne-gold); font-weight: 700;">
          SEMESTA NOTONEGORO LAINNYA
        </span>
        <h2 style="font-family: var(--font-serif); font-size: 2.2rem; color: var(--ocean-navy); margin: 6px 0;">
          E-Book Seri Notonegoro Lainnya
        </h2>
        <p style="color: var(--text-muted); font-size: 0.88rem; max-width: 600px; margin: 0 auto;">
          Jelajahi kisah intrik trah Notonegoro lainnya dalam format digital instan tanpa ongkos kirim.
        </p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
        @foreach($otherEbooks as $other)
          <div class="product-card" style="border: 1.5px solid var(--soft-beige); background: var(--white); display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s ease;" onmouseover="this.style.borderColor='var(--champagne-gold)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='var(--soft-beige)'; this.style.transform='none';">
            <div class="card-image-wrap" style="aspect-ratio: 4/5;">
              <img src="{{ asset($other->cover_image) }}" alt="Cover {{ $other->title }}">
              <span class="badge-series" style="background: var(--ocean-navy); color: var(--champagne-gold); font-weight: 700;">
                {{ $other->series_number ?? 'SERI' }}
              </span>
            </div>

            <div class="card-details" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
              <div>
                <span class="product-series" style="color: var(--champagne-gold); font-weight: 700; font-size: 0.74rem;">
                  {{ $other->series_name }}
                </span>
                <h3 class="product-title" style="font-size: 1.2rem; line-height: 1.2; margin: 6px 0 8px;">
                  {{ $other->title }}
                </h3>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 14px; line-height: 1.5;">
                  {{ Str::limit($other->synopsis, 80) }}
                </p>
              </div>

              <div>
                <div style="font-size: 0.72rem; color: #15803D; font-weight: 700; margin-bottom: 10px;">
                  <i class="fa-solid fa-check"></i> Tersedia Bab Digital & Full E-Book
                </div>
                <a href="{{ route('ebooks.show', $other->slug) }}" class="btn-card btn-card-primary" style="width: 100%; text-align: center; padding: 10px; font-size: 0.82rem; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none;">
                  <span>Lihat E-Book {{ $other->title }}</span>
                  <i class="fa-solid fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

</div>
@endsection

