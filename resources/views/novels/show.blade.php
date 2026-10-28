@extends('layouts.app')

@section('title', $novel->title . ' — Bianca Veana Official')

@section('content')
<!-- Breadcrumbs -->
<div style="background: var(--ivory); padding: 14px 0; border-bottom: 1px solid var(--soft-beige); font-size: 0.82rem;">
  <div class="container">
    <a href="{{ route('home') }}" style="color: var(--text-muted);">Home</a>
    <span style="margin: 0 8px; color: var(--champagne-gold);">/</span>
    <a href="{{ route('novels.index') }}" style="color: var(--text-muted);">Novels</a>
    <span style="margin: 0 8px; color: var(--champagne-gold);">/</span>
    <span style="color: var(--ocean-navy); font-weight: 600;">{{ $novel->title }}</span>
  </div>
</div>

<div class="container" style="padding: 60px 24px;">
  <div style="display: grid; grid-template-columns: 0.9fr 1.1fr; gap: 60px; align-items: start;">
    <!-- Left: Book Cover & Badges -->
    <div style="position: sticky; top: 100px;">
      <div style="background: var(--ocean-navy-deep); padding: 24px; border-radius: var(--radius-md); border: 2px solid var(--champagne-gold); box-shadow: var(--shadow-lg); text-align: center; position: relative;">
        <img id="mainBookImage" src="{{ asset($novel->cover_image) }}" alt="Cover {{ $novel->title }}" style="max-height: 520px; max-width: 100%; margin: 0 auto; border-radius: var(--radius-sm); box-shadow: 0 10px 25px rgba(0,0,0,0.5); display: block; transition: opacity 0.25s ease;">
      </div>

      <!-- Multiple Image Thumbnails (if 2 or 3 images available) -->
      @php
        $allImages = $novel->all_images;
      @endphp
      @if(count($allImages) > 1)
        <div style="display: flex; gap: 12px; margin-top: 14px; justify-content: center; align-items: center; flex-wrap: wrap;">
          @foreach($allImages as $idx => $img)
            @php
              $label = $idx === 0 ? 'Cover Depan' : ($idx === 1 ? 'Cover Belakang' : 'Detail / Bonus');
            @endphp
            <button type="button" class="book-thumb-btn {{ $idx === 0 ? 'active' : '' }}" onclick="changeBookImage('{{ asset($img) }}', this)" style="border: 2px solid {{ $idx === 0 ? 'var(--champagne-gold)' : 'var(--soft-beige)' }}; border-radius: 6px; padding: 3px; background: #FFFFFF; cursor: pointer; transition: all 0.2s ease; width: 74px; height: 100px; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: space-between; box-shadow: {{ $idx === 0 ? '0 0 10px rgba(198, 161, 107, 0.4)' : 'none' }};">
              <img src="{{ asset($img) }}" alt="{{ $label }}" style="width: 100%; height: 74px; object-fit: cover; border-radius: 3px;">
              <span style="font-size: 0.6rem; font-weight: 700; color: var(--ocean-navy); letter-spacing: 0.5px; white-space: nowrap;">{{ $label }}</span>
            </button>
          @endforeach
        </div>
      @endif

      <div style="display: flex; gap: 14px; margin-top: 20px; justify-content: center;">
        <span style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; color: var(--ocean-navy); background: var(--ivory); padding: 6px 14px; border-radius: var(--radius-sm); border: 1px solid var(--soft-beige); font-weight: 600;">
          <i class="fa-solid fa-shield-halved" style="color: var(--champagne-gold);"></i> 100% Original
        </span>
        <span style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; color: var(--ocean-navy); background: var(--ivory); padding: 6px 14px; border-radius: var(--radius-sm); border: 1px solid var(--soft-beige); font-weight: 600;">
          <i class="fa-solid fa-box" style="color: var(--champagne-gold);"></i> Box & Bubble Safe
        </span>
      </div>
    </div>

    <!-- Right: Book Details & Actions -->
    <div>
      <span style="font-size: 0.8rem; letter-spacing: 3px; color: var(--champagne-gold); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 8px;">
        {{ $novel->series_name }}
      </span>
      <h1 style="font-family: var(--font-serif); font-size: 2.8rem; color: var(--ocean-navy); margin-bottom: 10px; line-height: 1.2;">
        {{ $novel->title }}
      </h1>
      <div style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 24px;">
        Penulis: <strong style="color: var(--ocean-navy);">{{ $novel->author }}</strong> · Genre: <strong style="color: var(--ocean-navy);">{{ $novel->genre }}</strong>
      </div>

      <!-- Price Box -->
      <div style="background: var(--white); padding: 20px 28px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige); margin-bottom: 20px; display: flex; align-items: baseline; gap: 16px;">
        <span style="font-size: 2.2rem; font-weight: 700; color: var(--ocean-navy);">
          {{ $novel->formatted_price }}
        </span>
        @if($novel->original_price)
          <span style="font-size: 1.15rem; color: #9AA5B8; text-decoration: line-through;">
            {{ $novel->formatted_original_price }}
          </span>
          <span style="background: #FFE4E6; color: #E11D48; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">
            HEMAT {{ round((($novel->original_price - $novel->price) / $novel->original_price) * 100) }}%
          </span>
        @endif
      </div>


      <!-- Available E-Book Parts Section (Mantra Part 1, Part 2, Full E-Book, etc.) -->
      @php
        $bookParts = $novel->all_parts;
      @endphp
      @if($bookParts->count() > 0)
        <div style="background: #FFFFFF; border: 2px solid var(--champagne-gold); border-radius: var(--radius-md); padding: 24px; margin-bottom: 28px; box-shadow: var(--shadow-sm);">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
            <div>
              <span style="font-size: 0.72rem; letter-spacing: 1px; text-transform: uppercase; font-weight: 700; color: #1D4ED8; background: #EFF6FF; padding: 3px 10px; border-radius: 4px; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                <i class="fa-solid fa-tablet-screen-button"></i> PILIHAN PART & SERIAL DIGITAL BERBAYAR
              </span>
              <h3 style="font-family: var(--font-serif); font-size: 1.35rem; color: var(--ocean-navy); margin: 0 0 4px;">
                Beli Part E-Book "{{ $novel->base_title }}"
              </h3>
              <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">
                Mulai membaca dari bab awal atau beli edisi lengkap tanpa biaya ongkos kirim (Rp 0):
              </p>
            </div>
            <span style="font-size: 0.75rem; background: #DCFCE7; color: #15803D; padding: 4px 10px; border-radius: 4px; font-weight: 700;">
              <i class="fa-solid fa-bolt"></i> Bebas Ongkir (Digital)
            </span>
          </div>

          <div style="display: flex; flex-direction: column; gap: 10px;">
            @foreach($bookParts as $part)
              <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; border: 1px solid var(--soft-beige); border-radius: 6px; background: {{ $part->part_number ? '#FAFAFA' : '#FFFDF9' }}; transition: all 0.2s ease;">
                <div style="display: flex; align-items: center; gap: 12px;">
                  <div style="width: 34px; height: 34px; border-radius: 50%; background: {{ $part->part_number ? '#EFF6FF' : '#FEF3C7' }}; color: {{ $part->part_number ? '#1D4ED8' : '#B45309' }}; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; flex-shrink: 0;">
                    <i class="fa-solid {{ $part->part_number ? 'fa-file-lines' : 'fa-crown' }}"></i>
                  </div>
                  <div>
                    <strong style="color: var(--ocean-navy); font-size: 0.9rem; display: block;">
                      {{ $part->title }}
                    </strong>
                    <span style="font-size: 0.75rem; color: var(--text-muted);">
                      {{ $part->synopsis ?: ($part->part_number ? 'Serial Bab Digital' : 'Edisi Lengkap Semua Bab') }}
                    </span>
                  </div>
                </div>

                <div style="display: flex; align-items: center; gap: 14px;">
                  <div style="text-align: right;">
                    <span style="font-size: 1.05rem; font-weight: 700; color: #15803D;">
                      {{ $part->formatted_price }}
                    </span>
                  </div>
                  <form action="{{ route('cart.add') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $part->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-gold" style="padding: 8px 16px; font-size: 0.78rem; font-weight: 700; white-space: nowrap;">
                      <i class="fa-solid fa-cart-shopping"></i> Beli Part Ini
                    </button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Stock Status -->
      <div style="margin-bottom: 24px; font-size: 0.88rem;">
        @if($novel->is_preorder)
          <span style="color: #B45309; background: #FEF3C7; padding: 6px 14px; border-radius: 4px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-clock"></i> SISTEM PRE-ORDER (Estimasi pengiriman batch pertama)
          </span>
        @elseif($novel->stock > 0)
          <span style="color: #15803D; background: #DCFCE7; padding: 6px 14px; border-radius: 4px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-check-circle"></i> Stok Tersedia ({{ $novel->stock }} eksemplar siap kirim)
          </span>
        @else
          <span style="color: #B91C1C; background: #FEE2E2; padding: 6px 14px; border-radius: 4px; font-weight: 600;">
            <i class="fa-solid fa-circle-xmark"></i> Stok Habis
          </span>
        @endif
      </div>

      <!-- Synopsis -->
      <div style="margin-bottom: 32px;">
        <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin-bottom: 12px;">Sinopsis Buku</h3>
        <p style="font-size: 0.98rem; line-height: 1.9; color: var(--text-dark); background: var(--white); padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige);">
          {{ $novel->synopsis }}
        </p>
      </div>

      <!-- Collector's Edition Bonus Showcase -->
      @if($novel->collectors_items)
        <div style="background: linear-gradient(135deg, #FAF6F0 0%, #F4EBDD 100%); border: 1px solid var(--champagne-gold); border-radius: var(--radius-md); padding: 24px; margin-bottom: 32px;">
          <h4 style="font-family: var(--font-serif); font-size: 1.15rem; color: var(--ocean-navy); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-crown" style="color: var(--champagne-gold);"></i> Bonus Edisi Spesial & Collector’s Keepsake:
          </h4>
          <ul style="list-style: none; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            @foreach($novel->collectors_items as $item)
              <li style="display: flex; align-items: center; gap: 10px; font-size: 0.88rem; color: var(--ocean-navy);">
                <i class="fa-solid fa-check" style="color: var(--champagne-gold); font-size: 0.8rem; background: var(--white); width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-sm);"></i>
                <span>{{ $item }}</span>
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Add to Cart Form -->
      <form action="{{ route('cart.add') }}" method="POST" style="background: var(--white); padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--soft-beige); margin-bottom: 32px;">
        @csrf
        <input type="hidden" name="product_id" value="{{ $novel->id }}">
        <div style="display: flex; gap: 16px; align-items: center;">
          <div style="display: flex; align-items: center; border: 1px solid var(--soft-beige); border-radius: var(--radius-sm); overflow: hidden;">
            <button type="button" onclick="decrementQty()" style="background: var(--ivory); border: none; padding: 12px 18px; cursor: pointer; font-size: 1rem; color: var(--ocean-navy);">-</button>
            <input type="number" id="qty-input" name="quantity" value="1" min="1" max="{{ $novel->stock }}" style="width: 50px; text-align: center; border: none; font-size: 1rem; font-weight: 600; padding: 10px 0;">
            <button type="button" onclick="incrementQty()" style="background: var(--ivory); border: none; padding: 12px 18px; cursor: pointer; font-size: 1rem; color: var(--ocean-navy);">+</button>
          </div>
          <button type="submit" class="btn btn-gold" style="flex: 1; padding: 16px 24px;">
            <i class="fa-solid fa-cart-shopping"></i> TAMBAH KE KERANJANG
          </button>
        </div>
      </form>

      <!-- Physical Book Specifications Table -->
      <div style="background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--soft-beige); overflow: hidden;">
        <div style="background: var(--ivory); padding: 14px 20px; font-weight: 700; color: var(--ocean-navy); font-size: 0.95rem; border-bottom: 1px solid var(--soft-beige);">
          <i class="fa-solid fa-list-check" style="color: var(--champagne-gold); margin-right: 8px;"></i> Spesifikasi Fisik Buku
        </div>
        <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem;">
          <tbody>
            <tr style="border-bottom: 1px solid #F0EAE1;">
              <td style="padding: 12px 20px; color: var(--text-muted); width: 35%;">Jumlah Halaman</td>
              <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">{{ $novel->pages ?? 450 }} Halaman (Bookpaper Premium)</td>
            </tr>
            <tr style="border-bottom: 1px solid #F0EAE1;">
              <td style="padding: 12px 20px; color: var(--text-muted);">Berat Buku</td>
              <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">{{ $novel->weight_grams ?? 400 }} gram</td>
            </tr>
            <tr style="border-bottom: 1px solid #F0EAE1;">
              <td style="padding: 12px 20px; color: var(--text-muted);">Dimensi</td>
              <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">{{ $novel->dimensions ?? '14 x 20.5 cm' }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #F0EAE1;">
              <td style="padding: 12px 20px; color: var(--text-muted);">Penerbit</td>
              <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">{{ $novel->publisher }}</td>
            </tr>
            <tr>
              <td style="padding: 12px 20px; color: var(--text-muted);">Nomor ISBN</td>
              <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">{{ $novel->isbn ?? '978-623-99101' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Chronological Series Progression Shelf (The Seven Notonegoro Series or other multi-book series) -->
  @if(isset($seriesSiblings) && $seriesSiblings->count() > 0)
    <div style="margin-top: 70px; background: var(--white); border-radius: var(--radius-md); border: 1.5px solid var(--champagne-gold); padding: 36px 32px; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 26px; flex-wrap: wrap; gap: 14px;">
        <div>
          <span style="background: linear-gradient(135deg, #172B49, #203A5E); color: var(--champagne-gold); padding: 4px 12px; border-radius: 4px; font-size: 0.72rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">
            <i class="fa-solid fa-crown"></i> URUTAN LENGKAP SERIAL NOTONEGORO
          </span>
          <h3 style="font-family: var(--font-serif); font-size: 1.85rem; color: var(--ocean-navy); margin: 10px 0 6px;">
            The Seven Notonegoro Series (Kronologis Jilid 1 – 4)
          </h3>
          <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0; max-width: 700px; line-height: 1.6;">
            Kisah silsilah tujuh keturunan Notonegoro dapat Anda baca dan koleksi secara berurutan. Klik jilid di bawah untuk melihat atau langsung beli buku dalam seri ini:
          </p>
        </div>
        <a href="{{ route('novels.index', ['category' => 'notonegoro']) }}" class="btn btn-outline-gold" style="padding: 8px 16px; font-size: 0.78rem;">
          <i class="fa-solid fa-layer-group"></i> Katalog Seri Lengkap
        </a>
      </div>

      <div class="series-grid" style="grid-template-columns: repeat(4, 1fr); gap: 20px;">
        @foreach($seriesSiblings as $sib)
          @php
            $isCurrent = $sib->id === $novel->id;
          @endphp
          <div style="background: {{ $isCurrent ? '#FDFBF7' : '#FFFFFF' }}; border: {{ $isCurrent ? '2px solid var(--champagne-gold)' : '1px solid var(--soft-beige)' }}; border-radius: 8px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: {{ $isCurrent ? '0 4px 16px rgba(198,161,107,0.25)' : 'none' }};">
            <div>
              <div style="position: relative; margin-bottom: 12px; border-radius: 6px; overflow: hidden; aspect-ratio: 4/5;">
                <img src="{{ asset($sib->cover_image) }}" alt="Cover {{ $sib->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                <span style="position: absolute; top: 8px; left: 8px; background: rgba(23,43,73,0.92); color: var(--champagne-gold); padding: 3px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">
                  {{ $sib->series_number }}
                </span>
                @if($isCurrent)
                  <span style="position: absolute; bottom: 8px; right: 8px; background: #15803D; color: #FFF; padding: 3px 8px; border-radius: 4px; font-size: 0.68rem; font-weight: 700;">
                    <i class="fa-solid fa-check"></i> BUKU INI
                  </span>
                @endif
              </div>
              <span style="font-size: 0.72rem; color: var(--champagne-gold); font-weight: 700; display: block; margin-bottom: 2px;">
                {{ $sib->series_number }}
              </span>
              <h4 style="font-family: var(--font-serif); font-size: 1.15rem; color: var(--ocean-navy); margin: 0 0 4px; line-height: 1.2;">
                {{ $sib->title }}
              </h4>
              <span style="font-size: 0.75rem; color: var(--text-muted); display: block; line-height: 1.4;">{{ $sib->subtitle }}</span>
            </div>

            <div style="margin-top: 14px; padding-top: 12px; border-top: 1px dashed var(--soft-beige);">
              <div style="font-size: 1rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 10px;">
                {{ $sib->formatted_price }}
              </div>
              @if($isCurrent)
                <div style="width: 100%; padding: 9px; border-radius: 4px; background: #E2E8F0; color: #475569; font-size: 0.78rem; font-weight: 700; text-align: center;">
                  <i class="fa-solid fa-book-open"></i> Sedang Dibuka
                </div>
              @else
                <div style="display: flex; gap: 8px;">
                  <a href="{{ route('novels.show', $sib->slug) }}" class="btn btn-outline-gold" style="flex: 1; padding: 9px 8px; font-size: 0.75rem; text-align: center;">
                    Lihat Seri
                  </a>
                  <form action="{{ route('cart.add') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $sib->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-gold" style="padding: 9px 12px; font-size: 0.75rem;" title="Beli {{ $sib->title }}">
                      <i class="fa-solid fa-cart-plus"></i>
                    </button>
                  </form>
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <!-- Related Novels Section -->
  @if($relatedNovels->count() > 0)
    <div style="margin-top: 80px;">
      <div class="section-header" style="margin-bottom: 36px;">
        <span class="section-tag">REKOMENDASI KOLEKSI LAINNYA</span>
        <h2 class="section-title" style="font-size: 1.8rem;">KARYA TERKAIT DARI BIANCA VEANA</h2>
        <div class="section-divider"></div>
      </div>

      <div class="series-grid" style="grid-template-columns: repeat(3, 1fr);">
        @foreach($relatedNovels as $rel)
          <div class="product-card">
            <div class="card-image-wrap">
              <img src="{{ asset($rel->cover_image) }}" alt="Cover {{ $rel->title }}">
            </div>
            <div class="card-details">
              <span class="product-series">{{ $rel->series_name }}</span>
              <h3 class="product-title">{{ $rel->title }}</h3>
              <div class="product-price-row">
                <span class="price-current">{{ $rel->formatted_price }}</span>
              </div>
              <a href="{{ route('novels.show', $rel->slug) }}" class="btn-card btn-card-primary">View Book</a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
  function incrementQty() {
    const input = document.getElementById('qty-input');
    const max = parseInt(input.getAttribute('max')) || 99;
    if (parseInt(input.value) < max) {
      input.value = parseInt(input.value) + 1;
    }
  }

  function decrementQty() {
    const input = document.getElementById('qty-input');
    if (parseInt(input.value) > 1) {
      input.value = parseInt(input.value) - 1;
    }
  }

  function changeBookImage(src, btn) {
    const mainImg = document.getElementById('mainBookImage');
    if (!mainImg) return;
    mainImg.style.opacity = '0.3';
    setTimeout(() => {
      mainImg.src = src;
      mainImg.style.opacity = '1';
    }, 150);

    document.querySelectorAll('.book-thumb-btn').forEach(b => {
      b.style.borderColor = 'var(--soft-beige)';
      b.style.boxShadow = 'none';
      b.classList.remove('active');
    });

    btn.style.borderColor = 'var(--champagne-gold)';
    btn.style.boxShadow = '0 0 10px rgba(198, 161, 107, 0.4)';
    btn.classList.add('active');
  }
</script>
@endpush
