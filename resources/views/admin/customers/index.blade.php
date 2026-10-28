@extends('layouts.admin')

@section('title', 'Daftar Akun Customer — Admin BIANCA VEANA')

@section('content')
<div class="admin-container">
  
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 20px;">
    <div>
      <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold); display: block; margin-bottom: 4px;">
        MANAJEMEN PENGGUNA TOKO
      </span>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 6px; font-weight: 700;">
        Daftar Akun Customer ({{ $totalCustomers }})
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Kelola informasi akun pembaca, nomor kontak WhatsApp, dan pantau aktivitas belanja mereka.
      </p>
    </div>

    <!-- Search Form -->
    <form action="{{ route('admin.customers.index') }}" method="GET" style="display: flex; gap: 8px;">
      <div style="position: relative;">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, email, nomor HP..." style="padding: 10px 14px 10px 36px; border: 1px solid var(--admin-border-subtle); border-radius: 8px; font-size: 0.85rem; width: 280px; box-sizing: border-box;">
        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 13px; color: #94A3B8; font-size: 0.85rem;"></i>
      </div>
      <button type="submit" class="btn btn-gold" style="padding: 10px 16px; font-size: 0.85rem; font-weight: 600;">
        Cari
      </button>
      @if($search)
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-gold" style="padding: 10px 14px; font-size: 0.85rem; background: #FFF; border-color: #CBD5E1; color: #475569;">
          Reset
        </a>
      @endif
    </form>
  </div>

  @if(session('success'))
    <div style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; padding: 14px 20px; border-radius: 8px; font-size: 0.88rem; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
      <i class="fa-solid fa-circle-check" style="font-size: 1.2rem; color: #10B981;"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Customers Table Card -->
  <div class="admin-card">
    <div style="overflow-x: auto;">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Customer</th>
            <th>Kontak & WhatsApp</th>
            <th>Alamat & Kota</th>
            <th style="text-align: center;">Pesanan</th>
            <th style="text-align: right;">Total Belanja</th>
            <th>Bergabung</th>
            <th style="text-align: center;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($customers as $c)
            <tr>
              <td>
                <div style="display: flex; align-items: center; gap: 12px;">
                  <div style="width: 40px; height: 40px; border-radius: 50%; background: #0B1424; color: var(--admin-gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem; border: 1.5px solid var(--admin-gold);">
                    {{ strtoupper(substr($c->name, 0, 1)) }}
                  </div>
                  <div>
                    <strong style="color: #0F172A; font-size: 0.92rem; display: block;">{{ $c->name }}</strong>
                    <span style="font-size: 0.78rem; color: #64748B;">{{ $c->email }}</span>
                  </div>
                </div>
              </td>
              <td>
                @if($c->phone)
                  <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c->phone) }}" target="_blank" style="color: #16A34A; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-brands fa-whatsapp"></i> {{ $c->phone }}
                  </a>
                @else
                  <span style="color: #94A3B8; font-size: 0.82rem;">-</span>
                @endif
              </td>
              <td>
                <span style="font-size: 0.82rem; color: #334155; display: block; max-width: 220px; line-height: 1.4;">
                  {{ $c->city ? $c->city : ($c->address ? Str::limit($c->address, 35) : 'Belum diisi') }}
                </span>
              </td>
              <td style="text-align: center;">
                <span style="background: #EEF2FF; color: #4338CA; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.78rem;">
                  {{ $c->orders_count }} Pesanan
                </span>
              </td>
              <td style="text-align: right; font-weight: 700; color: #0F172A; font-size: 0.9rem;">
                Rp {{ number_format($c->total_spent, 0, ',', '.') }}
              </td>
              <td style="font-size: 0.82rem; color: #64748B;">
                {{ $c->created_at->format('d/m/Y') }}
              </td>
              <td style="text-align: center;">
                <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                  <!-- Live Chat Shortcut -->
                  <a href="{{ route('admin.chat.index', ['user_id' => $c->id]) }}" class="btn" style="padding: 6px 10px; background: #EEF2FF; color: #4F46E5; border-radius: 6px; font-size: 0.78rem;" title="Mulai Live Chat">
                    <i class="fa-solid fa-comment-dots"></i>
                  </a>

                  <!-- Edit Button -->
                  <a href="{{ route('admin.customers.edit', $c->id) }}" class="btn" style="padding: 6px 10px; background: #F8FAFC; border: 1px solid #CBD5E1; color: #0F172A; border-radius: 6px; font-size: 0.78rem;" title="Edit Akun">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>

                  <!-- Delete Button -->
                  <form action="{{ route('admin.customers.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun customer {{ $c->name }}? Data keranjang dan chat juga akan terhapus.');" style="display: inline-block; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="padding: 6px 10px; background: #FEF2F2; border: 1px solid #FCA5A5; color: #DC2626; border-radius: 6px; font-size: 0.78rem; cursor: pointer;" title="Hapus Akun">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" style="text-align: center; padding: 40px; color: #64748B;">
                <i class="fa-solid fa-users" style="font-size: 2rem; color: #CBD5E1; margin-bottom: 10px; display: block;"></i>
                Tidak ditemukan akun customer{{ $search ? ' dengan kata kunci "' . $search . '"' : '' }}.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($customers->hasPages())
      <div style="padding: 16px 24px; border-top: 1px solid var(--admin-border-subtle);">
        {{ $customers->links() }}
      </div>
    @endif
  </div>

</div>
@endsection

