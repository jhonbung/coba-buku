@extends('layouts.app')

@section('title', 'Profil Akun Saya — BIANCA VEANA')

@section('content')
<div style="background: radial-gradient(circle at 50% 50%, #1c365d 0%, #172B49 100%); color: var(--ivory); padding: 40px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container" style="text-align: center;">
    <span class="hero-subtitle" style="justify-content: center;"><i class="fa-solid fa-user-circle"></i> AREA PENGGUNA RESMI</span>
    <h1 style="font-size: 2.2rem; margin: 6px 0;">PROFIL AKUN SAYA</h1>
    <p style="color: #BAC7D7; font-size: 0.88rem; margin: 0;">Kelola data pribadi, nomor kontak WhatsApp, dan alamat pengiriman buku Anda.</p>
  </div>
</div>

<div class="container" style="padding: 50px 24px 80px; max-width: 900px; margin: 0 auto;">
  @if(session('success'))
    <div style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; padding: 14px 20px; border-radius: 6px; font-size: 0.88rem; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
      <i class="fa-solid fa-circle-check" style="font-size: 1.2rem; color: #10B981;"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <div style="display: grid; grid-template-columns: 0.8fr 1.2fr; gap: 36px; align-items: start;">
    
    <!-- User Card -->
    <div style="background: var(--white); border: 1.5px solid var(--soft-beige); border-radius: var(--radius-md); padding: 28px; text-align: center; box-shadow: var(--shadow-sm);">
      <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--ocean-navy); color: var(--champagne-gold); font-size: 2.2rem; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 2px solid var(--champagne-gold);">
        {{ strtoupper(substr($user->name, 0, 1)) }}
      </div>
      <h3 style="font-family: var(--font-serif); font-size: 1.35rem; color: var(--ocean-navy); margin: 0 0 4px;">{{ $user->name }}</h3>
      <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-bottom: 14px;">{{ $user->email }}</span>
      
      <span style="background: #EFF6FF; color: #1D4ED8; font-size: 0.72rem; font-weight: 700; padding: 4px 12px; border-radius: 20px; border: 1px solid #BFDBFE;">
        <i class="fa-solid fa-certificate"></i> Member Pembaca Setia
      </span>

      <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--soft-beige); text-align: left; font-size: 0.82rem; color: var(--text-dark); line-height: 1.8;">
        <div><i class="fa-brands fa-whatsapp" style="color: #16A34A; width: 18px;"></i> <strong>WhatsApp:</strong> {{ $user->phone ?? '-' }}</div>
        <div><i class="fa-solid fa-location-dot" style="color: #EF4444; width: 18px;"></i> <strong>Kota:</strong> {{ $user->city ?? '-' }}</div>
        <div><i class="fa-solid fa-calendar" style="color: var(--champagne-gold); width: 18px;"></i> <strong>Bergabung:</strong> {{ $user->created_at->format('d M Y') }}</div>
      </div>

      <div style="margin-top: 24px;">
        <a href="{{ route('account.orders') }}" class="btn btn-outline" style="width: 100%; font-size: 0.82rem; padding: 10px; border-radius: 6px; display: inline-flex; justify-content: center; align-items: center; gap: 8px;">
          <i class="fa-solid fa-bag-shopping"></i> Lihat Riwayat Pesanan
        </a>
      </div>
    </div>

    <!-- Edit Form -->
    <div style="background: var(--white); border: 1.5px solid var(--champagne-gold); border-radius: var(--radius-md); padding: 32px; box-shadow: var(--shadow-sm);">
      <h3 style="font-family: var(--font-serif); font-size: 1.3rem; color: var(--ocean-navy); margin: 0 0 20px; padding-bottom: 12px; border-bottom: 1px solid var(--soft-beige);">
        Perbarui Data Profil
      </h3>

      <form action="{{ route('account.profile.update') }}" method="POST">
        @csrf

        <div style="margin-bottom: 18px;">
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase;">
            Nama Lengkap *
          </label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 18px;">
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase;">
            Alamat Email (Akun)
          </label>
          <input type="email" value="{{ $user->email }}" disabled style="width: 100%; padding: 10px 14px; border: 1px solid #E2E8F0; background: #F8FAFC; color: #64748B; border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
          <span style="font-size: 0.7rem; color: var(--text-muted);">Email akun tidak dapat diubah sendiri. Hubungi admin jika perlu perubahan.</span>
        </div>

        <div style="margin-bottom: 18px;">
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase;">
            Nomor WhatsApp / HP *
          </label>
          <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 18px;">
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase;">
            Alamat Lengkap Pengiriman Buku Fisik
          </label>
          <textarea name="address" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.88rem; box-sizing: border-box;">{{ old('address', $user->address) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 24px;">
          <div>
            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase;">
              Kota / Kabupaten
            </label>
            <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="contoh: Jakarta Selatan" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.88rem; box-sizing: border-box;">
          </div>
          <div>
            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase;">
              Kode Pos
            </label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" placeholder="contoh: 12820" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.88rem; box-sizing: border-box;">
          </div>
        </div>

        <div style="background: var(--ivory); padding: 16px; border-radius: 6px; border: 1px solid var(--soft-beige); margin-bottom: 24px;">
          <strong style="font-size: 0.85rem; color: var(--ocean-navy); display: block; margin-bottom: 6px;">Ubah Kata Sandi (Kosongkan jika tidak ingin mengubah):</strong>
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <input type="password" name="password" placeholder="Kata sandi baru (min. 6 karakter)" style="width: 100%; padding: 8px 12px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.85rem; box-sizing: border-box;">
            <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" style="width: 100%; padding: 8px 12px; border: 1px solid var(--soft-beige); border-radius: 4px; font-size: 0.85rem; box-sizing: border-box;">
          </div>
        </div>

        <button type="submit" class="btn btn-gold" style="padding: 12px 28px; font-size: 0.88rem; font-weight: 700; border-radius: 6px;">
          <i class="fa-solid fa-floppy-disk"></i> SIMPAN PERUBAHAN
        </button>
      </form>
    </div>

  </div>
</div>
@endsection

