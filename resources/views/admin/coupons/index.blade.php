@extends('layouts.admin')

@section('title', 'Kelola Kupon & Diskon — Admin BIANCA VEANA')

@section('content')
<div class="admin-container">
  
  <!-- Header Bar -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 20px;">
    <div>
      <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold); display: block; margin-bottom: 4px;">
        PROMOSI & LOYALITAS PELANGGAN
      </span>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 6px; font-weight: 700;">
        Kupon & Kode Promo ({{ $totalCoupons }})
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Kelola voucher diskon pembaca, promo ongkos kirim, dan potongan eksklusif semesta Bianca Veana.
      </p>
    </div>

    <div>
      <button type="button" onclick="openCreateModal()" class="btn btn-gold" style="padding: 12px 20px; font-size: 0.88rem; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(198, 161, 107, 0.35);">
        <i class="fa-solid fa-plus"></i> Tambah Kupon Baru
      </button>
    </div>
  </div>

  @if(session('success'))
    <div style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; padding: 14px 20px; border-radius: 8px; font-size: 0.88rem; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
      <i class="fa-solid fa-circle-check" style="font-size: 1.2rem; color: #10B981;"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div style="background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; padding: 14px 20px; border-radius: 8px; font-size: 0.88rem; margin-bottom: 24px;">
      <strong><i class="fa-solid fa-triangle-exclamation"></i> Terjadi kesalahan pengisian form:</strong>
      <ul style="margin: 6px 0 0 18px; padding: 0;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Stats Grid -->
  <div class="admin-stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 28px;">
    <div class="admin-card" style="padding: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <span style="font-size: 0.75rem; color: #64748B; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Kupon Terdaftar</span>
          <div style="font-size: 1.8rem; font-weight: 700; color: #0F172A; margin-top: 4px;">{{ $totalCoupons }}</div>
        </div>
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #EEF2F6; display: flex; align-items: center; justify-content: center; color: var(--admin-navy);">
          <i class="fa-solid fa-ticket" style="font-size: 1.2rem;"></i>
        </div>
      </div>
    </div>

    <div class="admin-card" style="padding: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <span style="font-size: 0.75rem; color: #64748B; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Kupon Sedang Aktif</span>
          <div style="font-size: 1.8rem; font-weight: 700; color: #10B981; margin-top: 4px;">{{ $activeCoupons }}</div>
        </div>
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #ECFDF5; display: flex; align-items: center; justify-content: center; color: #10B981;">
          <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
        </div>
      </div>
    </div>

    <div class="admin-card" style="padding: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <span style="font-size: 0.75rem; color: #64748B; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Kuota Terpakai</span>
          <div style="font-size: 1.8rem; font-weight: 700; color: var(--admin-gold); margin-top: 4px;">{{ $totalUsage }} kali</div>
        </div>
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #FFFBEB; display: flex; align-items: center; justify-content: center; color: #D97706;">
          <i class="fa-solid fa-tags" style="font-size: 1.2rem;"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Coupons Table Card -->
  <div class="admin-card">
    <div style="overflow-x: auto;">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Kode Kupon</th>
            <th>Nama & Deskripsi Promo</th>
            <th>Tipe & Nilai Diskon</th>
            <th>Syarat Belanja</th>
            <th style="text-align: center;">Pemakaian</th>
            <th>Masa Berlaku</th>
            <th style="text-align: center;">Tampil Publik</th>
            <th style="text-align: center;">Status</th>
            <th style="text-align: center;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($coupons as $coupon)
            <tr>
              <td>
                <div style="display: flex; align-items: center; gap: 8px;">
                  <span style="font-family: monospace; font-size: 1.05rem; font-weight: 700; background: #F1F5F9; border: 1px dashed #CBD5E1; color: var(--admin-navy-deep); padding: 4px 10px; border-radius: 6px; letter-spacing: 1px;">
                    {{ $coupon->code }}
                  </span>
                </div>
              </td>
              <td>
                <strong style="color: #0F172A; font-size: 0.92rem; display: block;">{{ $coupon->name }}</strong>
                @if($coupon->description)
                  <span style="color: #64748B; font-size: 0.78rem; display: block; margin-top: 2px;">{{ $coupon->description }}</span>
                @endif
              </td>
              <td>
                @if($coupon->type === 'percent')
                  <span style="background: #EFF6FF; color: #1D4ED8; font-weight: 700; font-size: 0.8rem; padding: 3px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-percent"></i> {{ (int)$coupon->value }}%
                  </span>
                  @if($coupon->max_discount)
                    <div style="font-size: 0.72rem; color: #64748B; margin-top: 3px;">
                      Maks. Rp {{ number_format($coupon->max_discount, 0, ',', '.') }}
                    </div>
                  @endif
                @elseif($coupon->type === 'fixed')
                  <span style="background: #ECFDF5; color: #047857; font-weight: 700; font-size: 0.8rem; padding: 3px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-rupiah-sign"></i> Rp {{ number_format($coupon->value, 0, ',', '.') }}
                  </span>
                @else
                  <span style="background: #FFFBEB; color: #B45309; font-weight: 700; font-size: 0.8rem; padding: 3px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-truck-fast"></i> Ongkir Rp {{ number_format($coupon->value, 0, ',', '.') }}
                  </span>
                @endif
              </td>
              <td>
                <span style="font-size: 0.82rem; color: #334155;">
                  {{ $coupon->formatted_min_spend }}
                </span>
              </td>
              <td style="text-align: center;">
                <span style="font-weight: 700; color: #0F172A; font-size: 0.9rem;">
                  {{ $coupon->usage_count }}
                </span>
                <span style="color: #94A3B8; font-size: 0.8rem;">
                  / {{ $coupon->usage_limit !== null ? $coupon->usage_limit : '∞' }}
                </span>
              </td>
              <td>
                @if($coupon->expires_at)
                  <span style="font-size: 0.82rem; color: {{ $coupon->expires_at->isPast() ? '#DC2626' : '#334155' }};">
                    {{ $coupon->expires_at->translatedFormat('d M Y') }}
                    @if($coupon->expires_at->isPast())
                      <span style="display: block; font-size: 0.7rem; color: #DC2626; font-weight: 600;">(Kedaluwarsa)</span>
                    @endif
                  </span>
                @else
                  <span style="font-size: 0.8rem; color: #64748B;">Tanpa Batas</span>
                @endif
              </td>
              <td style="text-align: center;">
                @if($coupon->is_public)
                  <span style="background: #F0FDF4; color: #166534; font-size: 0.72rem; font-weight: 600; padding: 2px 8px; border-radius: 12px; border: 1px solid #BBF7D0;">
                    Tampil
                  </span>
                @else
                  <span style="background: #F8FAFC; color: #64748B; font-size: 0.72rem; font-weight: 600; padding: 2px 8px; border-radius: 12px; border: 1px solid #E2E8F0;">
                    Rahasia
                  </span>
                @endif
              </td>
              <td style="text-align: center;">
                @if($coupon->is_active)
                  <span style="background: #ECFDF5; color: #059669; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 5px;">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #10B981;"></span> Aktif
                  </span>
                @else
                  <span style="background: #FEF2F2; color: #DC2626; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 5px;">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #EF4444;"></span> Nonaktif
                  </span>
                @endif
              </td>
              <td style="text-align: center;">
                <div style="display: inline-flex; align-items: center; gap: 6px;">
                  <!-- Toggle Active Status -->
                  <form action="{{ route('admin.coupons.toggle', $coupon->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn" style="padding: 6px 10px; font-size: 0.78rem; background: #F1F5F9; color: #334155; border: 1px solid #CBD5E1; border-radius: 6px;" title="{{ $coupon->is_active ? 'Nonaktifkan Kupon' : 'Aktifkan Kupon' }}">
                      <i class="fa-solid {{ $coupon->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                    </button>
                  </form>

                  <!-- Edit Button -->
                  <button type="button" onclick="openEditModal({{ json_encode($coupon) }})" class="btn" style="padding: 6px 10px; font-size: 0.78rem; background: #FFFBEB; color: #B45309; border: 1px solid #FDE68A; border-radius: 6px;" title="Edit Kupon">
                    <i class="fa-regular fa-pen-to-square"></i>
                  </button>

                  <!-- Delete Button -->
                  <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kupon promo [{{ $coupon->code }}]?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="padding: 6px 10px; font-size: 0.78rem; background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; border-radius: 6px;" title="Hapus Kupon">
                      <i class="fa-regular fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" style="text-align: center; padding: 48px 20px; color: #64748B;">
                <i class="fa-solid fa-ticket" style="font-size: 2.5rem; color: #CBD5E1; margin-bottom: 12px; display: block;"></i>
                <div style="font-weight: 600; font-size: 1rem; color: #334155;">Belum ada kupon diskon dibuat</div>
                <p style="font-size: 0.85rem; margin: 4px 0 16px;">Klik tombol "Tambah Kupon Baru" untuk mulai memberikan potongan harga kepada pembaca.</p>
                <button type="button" onclick="openCreateModal()" class="btn btn-gold" style="padding: 10px 18px; font-size: 0.85rem;">
                  <i class="fa-solid fa-plus"></i> Buat Kupon Pertama
                </button>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($coupons->hasPages())
      <div style="padding: 16px 20px; border-top: 1px solid var(--admin-border-subtle);">
        {{ $coupons->links() }}
      </div>
    @endif
  </div>

</div>

<!-- MODAL TAMBAH KUPON -->
<div id="createCouponModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
  <div style="background: #FFFFFF; border-radius: 12px; max-width: 620px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 40px rgba(0,0,0,0.25); border: 1px solid #E2E8F0;">
    <div style="padding: 20px 24px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; background: #FAFBFD; border-radius: 12px 12px 0 0;">
      <h3 style="margin: 0; font-family: var(--font-display); font-size: 1.25rem; color: #0F172A; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-ticket" style="color: var(--admin-gold);"></i> Tambah Kupon / Voucher Baru
      </h3>
      <button type="button" onclick="closeCreateModal()" style="background: none; border: none; font-size: 1.2rem; color: #94A3B8; cursor: pointer;">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <form action="{{ route('admin.coupons.store') }}" method="POST" style="padding: 24px;">
      @csrf
      
      <div class="form-row-2col">
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Kode Kupon (Huruf Kapital) *
          </label>
          <input type="text" name="code" required placeholder="Contoh: NOTONEGORO10" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-weight: 700; text-transform: uppercase; font-family: monospace;">
        </div>
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Nama / Judul Promo *
          </label>
          <input type="text" name="name" required placeholder="Contoh: Diskon 10% Spesial Pembaca" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
      </div>

      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
          Deskripsi Promo (Opsional)
        </label>
        <input type="text" name="description" placeholder="Contoh: Potongan belanja untuk semua novel cetak & e-book" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
      </div>

      <div class="form-row-2col">
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Tipe Diskon *
          </label>
          <select name="type" id="create_type" onchange="updateValuePlaceholder('create')" required style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem; background: #FFF;">
            <option value="percent">Diskon Persen (%)</option>
            <option value="fixed">Potongan Langsung (Rp)</option>
            <option value="shipping">Subsidi / Potongan Ongkir (Rp)</option>
          </select>
        </div>
        <div>
          <label id="create_value_label" style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Nilai Diskon *
          </label>
          <input type="number" step="any" min="0.01" name="value" id="create_value" required placeholder="Contoh: 10 untuk 10%" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
      </div>

      <div class="form-row-2col">
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Minimal Belanja (Rp)
          </label>
          <input type="number" name="min_spend" value="0" min="0" placeholder="0 jika tanpa syarat" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Maks. Potongan Diskon (Rp, Khusus %)
          </label>
          <input type="number" name="max_discount" min="0" placeholder="Kosongkan jika tidak dibatasi" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
      </div>

      <div class="form-row-2col">
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Batas Kuota Pemakaian
          </label>
          <input type="number" name="usage_limit" min="1" placeholder="Kosongkan jika tak terbatas (unlimited)" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Tanggal Kedaluwarsa
          </label>
          <input type="datetime-local" name="expires_at" style="width: 100%; padding: 9px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem;">
        </div>
      </div>

      <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 14px 18px; border-radius: 8px; margin: 20px 0;">
        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.85rem; font-weight: 600; color: #1E293B; margin-bottom: 10px;">
          <input type="checkbox" name="is_public" value="1" checked style="width: 16px; height: 16px; accent-color: var(--admin-gold);">
          <span>Tampilkan di panel pilihan kupon customer (Bisa langsung diklaim pembaca)</span>
        </label>
        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.85rem; font-weight: 600; color: #1E293B;">
          <input type="checkbox" name="is_active" value="1" checked style="width: 16px; height: 16px; accent-color: #10B981;">
          <span>Aktifkan kupon ini sekarang</span>
        </label>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px;">
        <button type="button" onclick="closeCreateModal()" class="btn" style="padding: 10px 18px; font-size: 0.88rem; background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; border-radius: 6px;">
          Batal
        </button>
        <button type="submit" class="btn btn-gold" style="padding: 10px 22px; font-size: 0.88rem; font-weight: 600; border-radius: 6px;">
          <i class="fa-solid fa-check"></i> Simpan Kupon Baru
        </button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDIT KUPON -->
<div id="editCouponModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
  <div style="background: #FFFFFF; border-radius: 12px; max-width: 620px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 40px rgba(0,0,0,0.25); border: 1px solid #E2E8F0;">
    <div style="padding: 20px 24px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; background: #FAFBFD; border-radius: 12px 12px 0 0;">
      <h3 style="margin: 0; font-family: var(--font-display); font-size: 1.25rem; color: #0F172A; display: flex; align-items: center; gap: 8px;">
        <i class="fa-regular fa-pen-to-square" style="color: var(--admin-gold);"></i> Edit Kupon Promo
      </h3>
      <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 1.2rem; color: #94A3B8; cursor: pointer;">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <form id="editCouponForm" method="POST" style="padding: 24px;">
      @csrf
      @method('PUT')
      
      <div class="form-row-2col">
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Kode Kupon (Huruf Kapital) *
          </label>
          <input type="text" name="code" id="edit_code" required style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-weight: 700; text-transform: uppercase; font-family: monospace;">
        </div>
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Nama / Judul Promo *
          </label>
          <input type="text" name="name" id="edit_name" required style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
      </div>

      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
          Deskripsi Promo (Opsional)
        </label>
        <input type="text" name="description" id="edit_description" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
      </div>

      <div class="form-row-2col">
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Tipe Diskon *
          </label>
          <select name="type" id="edit_type" onchange="updateValuePlaceholder('edit')" required style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem; background: #FFF;">
            <option value="percent">Diskon Persen (%)</option>
            <option value="fixed">Potongan Langsung (Rp)</option>
            <option value="shipping">Subsidi / Potongan Ongkir (Rp)</option>
          </select>
        </div>
        <div>
          <label id="edit_value_label" style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Nilai Diskon *
          </label>
          <input type="number" step="any" min="0.01" name="value" id="edit_value" required style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
      </div>

      <div class="form-row-2col">
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Minimal Belanja (Rp)
          </label>
          <input type="number" name="min_spend" id="edit_min_spend" min="0" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Maks. Potongan Diskon (Rp, Khusus %)
          </label>
          <input type="number" name="max_discount" id="edit_max_discount" min="0" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
      </div>

      <div class="form-row-2col">
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Batas Kuota Pemakaian
          </label>
          <input type="number" name="usage_limit" id="edit_usage_limit" min="1" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px;">
            Tanggal Kedaluwarsa
          </label>
          <input type="datetime-local" name="expires_at" id="edit_expires_at" style="width: 100%; padding: 9px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem;">
        </div>
      </div>

      <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 14px 18px; border-radius: 8px; margin: 20px 0;">
        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.85rem; font-weight: 600; color: #1E293B; margin-bottom: 10px;">
          <input type="checkbox" name="is_public" id="edit_is_public" value="1" style="width: 16px; height: 16px; accent-color: var(--admin-gold);">
          <span>Tampilkan di panel pilihan kupon customer (Bisa langsung diklaim pembaca)</span>
        </label>
        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.85rem; font-weight: 600; color: #1E293B;">
          <input type="checkbox" name="is_active" id="edit_is_active" value="1" style="width: 16px; height: 16px; accent-color: #10B981;">
          <span>Aktifkan kupon ini sekarang</span>
        </label>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px;">
        <button type="button" onclick="closeEditModal()" class="btn" style="padding: 10px 18px; font-size: 0.88rem; background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; border-radius: 6px;">
          Batal
        </button>
        <button type="submit" class="btn btn-gold" style="padding: 10px 22px; font-size: 0.88rem; font-weight: 600; border-radius: 6px;">
          <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function openCreateModal() {
    document.getElementById('createCouponModal').style.display = 'flex';
  }

  function closeCreateModal() {
    document.getElementById('createCouponModal').style.display = 'none';
  }

  function updateValuePlaceholder(prefix) {
    const typeSelect = document.getElementById(prefix + '_type');
    const valInput = document.getElementById(prefix + '_value');
    const label = document.getElementById(prefix + '_value_label');

    if (typeSelect.value === 'percent') {
      label.textContent = 'Nilai Diskon (% Persen) *';
      valInput.placeholder = 'Contoh: 10 untuk 10%';
    } else if (typeSelect.value === 'fixed') {
      label.textContent = 'Nominal Potongan (Rp) *';
      valInput.placeholder = 'Contoh: 20000 untuk Rp 20.000';
    } else {
      label.textContent = 'Nominal Subsidi Ongkir (Rp) *';
      valInput.placeholder = 'Contoh: 15000 untuk subsidi Rp 15.000';
    }
  }

  function openEditModal(coupon) {
    const form = document.getElementById('editCouponForm');
    form.action = `/admin/coupons/${coupon.id}`;

    document.getElementById('edit_code').value = coupon.code || '';
    document.getElementById('edit_name').value = coupon.name || '';
    document.getElementById('edit_description').value = coupon.description || '';
    document.getElementById('edit_type').value = coupon.type || 'percent';
    document.getElementById('edit_value').value = coupon.value || '';
    document.getElementById('edit_min_spend').value = coupon.min_spend || 0;
    document.getElementById('edit_max_discount').value = coupon.max_discount || '';
    document.getElementById('edit_usage_limit').value = coupon.usage_limit || '';
    
    if (coupon.expires_at) {
      const dt = new Date(coupon.expires_at);
      const isoStr = dt.toISOString().slice(0, 16);
      document.getElementById('edit_expires_at').value = isoStr;
    } else {
      document.getElementById('edit_expires_at').value = '';
    }

    document.getElementById('edit_is_public').checked = !!coupon.is_public;
    document.getElementById('edit_is_active').checked = !!coupon.is_active;

    updateValuePlaceholder('edit');
    document.getElementById('editCouponModal').style.display = 'flex';
  }

  function closeEditModal() {
    document.getElementById('editCouponModal').style.display = 'none';
  }

  // Close modals on clicking backdrop
  window.addEventListener('click', function(e) {
    const cModal = document.getElementById('createCouponModal');
    const eModal = document.getElementById('editCouponModal');
    if (e.target === cModal) closeCreateModal();
    if (e.target === eModal) closeEditModal();
  });
</script>
@endsection

