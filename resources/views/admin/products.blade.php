@extends('layouts.admin')

@section('title', 'Manajemen Produk & Stok — Admin BIANCA VEANA')

@section('content')
<div class="admin-container">
  <!-- Top Action Bar -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 20px;">
    <div>
      <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
        <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold);">
          INVENTARIS & KATALOG RESMI
        </span>
      </div>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 6px; font-weight: 700; letter-spacing: 0.5px;">
        Kontrol Stok & Harga Produk
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Kelola persediaan novel cetak, e-book digital, serta merchandise resmi Bianca Veana secara langsung.
      </p>
    </div>

    <div style="display: flex; gap: 12px; align-items: center;">
      <a href="{{ route('admin.ebook_parts.hub') }}" class="btn btn-outline-gold" style="font-size: 0.82rem; padding: 10px 18px; font-weight: 700; background: #FFFFFF;">
        <i class="fa-solid fa-layer-group"></i> Pusat Kontrol Part E-Book
      </a>

      <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 10px 18px; border-radius: 8px; font-size: 0.82rem; color: #1E293B; display: flex; align-items: center; gap: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
        <i class="fa-solid fa-boxes-stacked" style="color: var(--admin-gold);"></i>
        <span>Total: <strong>{{ $products->count() }} Judul Aktif</strong></span>
      </div>
      
      <a href="{{ route('admin.products.create') }}" class="btn btn-gold" style="font-size: 0.82rem; padding: 11px 22px; font-weight: 700; box-shadow: 0 4px 12px rgba(198, 161, 107, 0.35);">
        <i class="fa-solid fa-plus-circle"></i> Tambah Produk Baru
      </a>
    </div>
  </div>

  <!-- Grouped Filter Pills & Search Bar -->
  <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #F1F5F9;">
      <!-- Series Universe Group Filters -->
      <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
        <span style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">
          <i class="fa-solid fa-crown" style="color: var(--admin-gold);"></i> Kelompok Seri:
        </span>
        <button type="button" onclick="filterBySeries('all')" class="series-filter-tab active" data-series="all">Semua Seri</button>
        <button type="button" onclick="filterBySeries('notonegoro')" class="series-filter-tab" data-series="notonegoro">👑 The Seven Notonegoro</button>
        <button type="button" onclick="filterBySeries('standalone')" class="series-filter-tab" data-series="standalone">🌙 Standalone Novels</button>
        <button type="button" onclick="filterBySeries('limited')" class="series-filter-tab" data-series="limited">💎 Limited Editions</button>
        <button type="button" onclick="filterBySeries('merch')" class="series-filter-tab" data-series="merch">🎁 Merchandise</button>
      </div>

      <!-- Live Search Box -->
      <div style="position: relative; min-width: 240px;">
        <input type="text" id="admin_table_search" onkeyup="searchAdminTable()" placeholder="Cari judul, ISBN, seri..." style="width: 100%; padding: 8px 14px 8px 34px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.82rem;">
        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 10px; color: #94A3B8; font-size: 0.8rem;"></i>
      </div>
    </div>

    <!-- Category Filter Pills Bar -->
    <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
      <span style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase;">
        <i class="fa-solid fa-shapes"></i> Kategori:
      </span>
      <button type="button" onclick="filterTable('all')" class="filter-tab active" data-filter="all">Semua Kategori ({{ $products->count() }})</button>
      <button type="button" onclick="filterTable('novel')" class="filter-tab" data-filter="novel">📖 Novel Cetak</button>
      <button type="button" onclick="filterTable('ebook')" class="filter-tab" data-filter="ebook">📱 E-Book Digital</button>
      <button type="button" onclick="filterTable('merchandise')" class="filter-tab" data-filter="merchandise">🎁 Merchandise</button>
    </div>
  </div>

  <!-- Main Table Card -->
  <div class="admin-card">
    <table class="admin-table" id="products-table">
      <thead>
        <tr>
          <th style="width: 320px;">Cover & Judul Produk</th>
          <th style="width: 130px;">Kategori</th>
          <th>Seri / Kelompok Universe</th>
          <th style="text-align: center; width: 220px;">Update Harga & Stok</th>
          <th style="text-align: center; width: 230px;">Kontrol & Tindakan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $prod)
          @php
            $subcat = $prod->subcategory ?? 'notonegoro';
            $seriesKey = (str_contains(strtolower($prod->series_name ?? ''), 'notonegoro') || $subcat === 'notonegoro') 
              ? 'notonegoro' 
              : ($subcat === 'standalone' ? 'standalone' : ($subcat === 'limited' ? 'limited' : 'merch'));
          @endphp
          <tr data-cat="{{ $prod->category }}" data-series="{{ $seriesKey }}" data-title="{{ strtolower($prod->title . ' ' . $prod->series_name . ' ' . $prod->isbn) }}">
            <td>
              <div style="display: flex; gap: 16px; align-items: center;">
                <div style="width: 48px; height: 68px; flex-shrink: 0; border-radius: 6px; overflow: hidden; background: #0E1A2B; border: 1px solid rgba(198, 161, 107, 0.4); box-shadow: 0 2px 6px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: center;">
                  <img src="{{ asset($prod->cover_image) }}" alt="{{ $prod->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='/images/mantra.svg';">
                </div>
                <div>
                  <strong style="color: #0F172A; font-size: 0.95rem; display: block; line-height: 1.3; margin-bottom: 2px;">{{ $prod->title }}</strong>
                  <div style="font-size: 0.75rem; color: #64748B;">{{ $prod->author }}</div>
                  @if($prod->is_preorder)
                    <span style="font-size: 0.65rem; background: #FEF3C7; color: #92400E; padding: 2px 6px; border-radius: 4px; font-weight: 700; display: inline-block; margin-top: 4px; border: 1px solid #FCD34D;">
                      <i class="fa-solid fa-clock"></i> PRE-ORDER
                    </span>
                  @endif
                </div>
              </div>
            </td>

            <td>
              @php
                $badgeBg = $prod->category === 'novel' ? '#EFF6FF' : ($prod->category === 'ebook' ? '#F0FDF4' : '#FAF5FF');
                $badgeColor = $prod->category === 'novel' ? '#1D4ED8' : ($prod->category === 'ebook' ? '#15803D' : '#7E22CE');
                $badgeBorder = $prod->category === 'novel' ? '#BFDBFE' : ($prod->category === 'ebook' ? '#BBF7D0' : '#E9D5FF');
              @endphp
              <span style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700; padding: 4px 10px; border-radius: 6px; background: {{ $badgeBg }}; color: {{ $badgeColor }}; border: 1px solid {{ $badgeBorder }};">
                {{ $prod->category }}
              </span>
            </td>

            <td style="color: #64748B; font-size: 0.82rem;">
              {{ $prod->series_name ?? $prod->subtitle }}
            </td>

            <td>
              <form action="{{ route('admin.products.stock', $prod->id) }}" method="POST" id="form-{{ $prod->id }}" style="display: flex; gap: 8px; align-items: center; justify-content: center;">
                @csrf
                <div>
                  <label style="font-size: 0.65rem; color: #64748B; font-weight: 600; display: block; margin-bottom: 2px;">Harga (Rp):</label>
                  <input type="number" name="price" value="{{ $prod->price }}" style="width: 105px; padding: 6px 10px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem; font-weight: 600; color: #0F172A;">
                </div>
                <div>
                  <label style="font-size: 0.65rem; color: #64748B; font-weight: 600; display: block; margin-bottom: 2px;">Stok:</label>
                  <input type="number" name="stock" value="{{ $prod->stock }}" style="width: 68px; padding: 6px 8px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem; font-weight: 600; color: #0F172A;">
                </div>
              </form>
            </td>

            <td>
              <div style="display: flex; gap: 6px; justify-content: center; align-items: center; flex-wrap: wrap;">
                <button type="submit" form="form-{{ $prod->id }}" class="btn-tool-save" title="Simpan Cepat Stok & Harga">
                  <i class="fa-solid fa-floppy-disk"></i>
                </button>
                @if($prod->category === 'novel')
                  <a href="{{ route('admin.products.parts', $prod->id) }}" class="btn-tool-edit" style="background: #EFF6FF; color: #1D4ED8; border-color: #BFDBFE; font-weight: 700;" title="Kelola Part E-Book untuk {{ $prod->title }}">
                    <i class="fa-solid fa-layer-group"></i> Part ({{ $prod->ebookParts->count() }})
                  </a>
                @endif
                <a href="{{ route('admin.products.edit', $prod->id) }}" class="btn-tool-edit" title="Edit Lengkap">
                  <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
                <form action="{{ route('admin.products.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $prod->title }}?')" style="display: inline; margin: 0;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-tool-delete" title="Hapus Produk">
                    <i class="fa-regular fa-trash-can"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('styles')
<style>
  .filter-tab {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 0.78rem;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .filter-tab:hover {
    background: #F1F5F9;
    color: #0F172A;
  }
  .filter-tab.active {
    background: #0B1424;
    color: #F8FAFC;
    border-color: #0B1424;
  }

  .series-filter-tab {
    background: #F8FAFC;
    border: 1px solid #CBD5E1;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 0.78rem;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .series-filter-tab:hover {
    background: #EFF6FF;
    color: #1D4ED8;
    border-color: #93C5FD;
  }
  .series-filter-tab.active {
    background: #1E293B;
    color: var(--champagne-gold);
    border-color: #0F172A;
  }
  .btn-tool-save {
    background: linear-gradient(135deg, #DFBA7D 0%, #C6A16B 100%);
    border: none;
    color: #0B1424;
    padding: 7px 11px;
    border-radius: 6px;
    font-size: 0.78rem;
    cursor: pointer;
    font-weight: 700;
    transition: all 0.2s ease;
  }
  .btn-tool-save:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
  }
  .btn-tool-edit {
    background: #FFFFFF;
    border: 1px solid #CBD5E1;
    color: #1E293B;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
  }
  .btn-tool-edit:hover {
    border-color: #94A3B8;
    background: #F8FAFC;
    color: #0F172A;
  }
  .btn-tool-delete {
    background: #FFF1F2;
    border: 1px solid #FECDD3;
    color: #E11D48;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .btn-tool-delete:hover {
    background: #E11D48;
    color: #FFFFFF;
    border-color: #E11D48;
  }
</style>
@endpush

@push('scripts')
<script>
  let activeCat = 'all';
  let activeSeries = 'all';

  function filterTable(cat) {
    activeCat = cat;
    document.querySelectorAll('.filter-tab').forEach(b => {
      b.classList.toggle('active', b.getAttribute('data-filter') === cat);
    });
    applyFilters();
  }

  function filterBySeries(seriesKey) {
    activeSeries = seriesKey;
    document.querySelectorAll('.series-filter-tab').forEach(b => {
      b.classList.toggle('active', b.getAttribute('data-series') === seriesKey);
    });
    applyFilters();
  }

  function searchAdminTable() {
    applyFilters();
  }

  function applyFilters() {
    const q = (document.getElementById('admin_table_search').value || '').toLowerCase().trim();
    const rows = document.querySelectorAll('#products-table tbody tr');

    rows.forEach(r => {
      const matchCat = (activeCat === 'all' || r.getAttribute('data-cat') === activeCat);
      const matchSeries = (activeSeries === 'all' || r.getAttribute('data-series') === activeSeries);
      const titleData = r.getAttribute('data-title') || '';
      const matchQuery = !q || titleData.includes(q);

      if (matchCat && matchSeries && matchQuery) {
        r.style.display = '';
      } else {
        r.style.display = 'none';
      }
    });
  }
</script>
@endpush
