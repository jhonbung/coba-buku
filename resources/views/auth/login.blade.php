@extends('layouts.app')

@section('title', 'Masuk Akun Pembaca — BIANCA VEANA')

@section('content')
<div style="background: radial-gradient(circle at 50% 50%, #1c365d 0%, #172B49 100%); color: var(--ivory); padding: 50px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container" style="text-align: center;">
    <span class="hero-subtitle" style="justify-content: center;"><i class="fa-solid fa-crown"></i> OFFICIAL READER ACCOUNT</span>
    <h1 style="font-size: 2.4rem; margin: 8px 0;">MASUK KE AKUN ANDA</h1>
    <p style="color: #BAC7D7; max-width: 580px; margin: 0 auto; font-size: 0.92rem;">
      Nikmati kemudahan berbelanja novel cetak, part e-book digital, serta akses percakapan langsung dengan customer care resmi.
    </p>
  </div>
</div>

<div class="container" style="padding: 60px 24px 90px; max-width: 520px; margin: 0 auto;">
  <div style="background: var(--white); border: 1.5px solid var(--champagne-gold); border-radius: var(--radius-md); padding: 36px 32px; box-shadow: var(--shadow-md);">
    
    <div style="text-align: center; margin-bottom: 28px;">
      <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--ivory); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin: 0 auto 12px; border: 1px solid var(--soft-beige);">
        <i class="fa-solid fa-user-lock"></i>
      </div>
      <h2 style="font-family: var(--font-serif); font-size: 1.6rem; color: var(--ocean-navy); margin: 0 0 4px;">Selamat Datang Kembali</h2>
      <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">Silakan masukkan alamat email dan kata sandi akun Anda.</p>
    </div>

    @if(session('warning'))
      <div style="background: #FFFBEB; border: 1px solid #FDE68A; color: #92400E; padding: 12px 16px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 22px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-exclamation" style="font-size: 1.1rem; color: #D97706;"></i>
        <span>{{ session('warning') }}</span>
      </div>
    @endif

    @if(session('success'))
      <div style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; padding: 12px 16px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 22px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check" style="font-size: 1.1rem; color: #10B981;"></i>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    @if($errors->any())
      <div style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 6px; font-size: 0.82rem; margin-bottom: 22px;">
        <ul style="margin: 0; padding-left: 18px;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
      @csrf

      <div style="margin-bottom: 20px;">
        <label for="email" style="display: block; font-size: 0.82rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
          Alamat Email *
        </label>
        <div style="position: relative;">
          <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh: pembaca@gmail.com" style="width: 100%; padding: 12px 14px 12px 40px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)';" onblur="this.style.borderColor='var(--soft-beige)';">
          <i class="fa-solid fa-envelope" style="position: absolute; left: 14px; top: 15px; color: #94A3B8; font-size: 0.95rem;"></i>
        </div>
      </div>

      <div style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
          <label for="password" style="font-size: 0.82rem; font-weight: 700; color: var(--ocean-navy); text-transform: uppercase; letter-spacing: 0.5px;">
            Kata Sandi *
          </label>
        </div>
        <div style="position: relative;">
          <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi Anda" style="width: 100%; padding: 12px 14px 12px 40px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)';" onblur="this.style.borderColor='var(--soft-beige)';">
          <i class="fa-solid fa-lock" style="position: absolute; left: 14px; top: 15px; color: #94A3B8; font-size: 0.95rem;"></i>
        </div>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 0.82rem;">
        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--text-dark);">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} style="accent-color: var(--champagne-gold);">
          Ingat Saya di Perangkat Ini
        </label>
      </div>

      <button type="submit" class="btn btn-gold" style="width: 100%; padding: 14px; font-size: 0.95rem; font-weight: 700; letter-spacing: 0.5px; border-radius: 6px; box-shadow: 0 4px 14px rgba(198, 161, 107, 0.35);">
        <i class="fa-solid fa-right-to-bracket"></i> MASUK SEKARANG
      </button>
    </form>

    <div style="margin-top: 26px; padding-top: 22px; border-top: 1px solid var(--soft-beige); text-align: center; font-size: 0.85rem; color: var(--text-muted);">
      Belum memiliki akun pembaca? 
      <a href="{{ route('register') }}" style="color: var(--ocean-navy); font-weight: 700; text-decoration: underline;">
        Daftar Akun Baru di Sini
      </a>
    </div>

    <!-- Pembeda Jalur Admin Login -->
    <div style="margin-top: 18px; padding: 12px; background: #FAF9F6; border-radius: 6px; text-align: center; font-size: 0.78rem; color: var(--text-muted); border: 1px dashed var(--soft-beige);">
      <i class="fa-solid fa-shield-halved" style="color: var(--champagne-gold);"></i> Khusus Tim Pengelola Toko:
      <a href="{{ route('admin.login') }}" style="color: var(--ocean-navy); font-weight: 700; text-decoration: none; margin-left: 4px;">
        Masuk ke Portal Admin Control Center &rarr;
      </a>
    </div>

  </div>
</div>
@endsection

