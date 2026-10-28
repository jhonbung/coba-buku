@extends('layouts.app')

@section('title', 'Daftar Akun Baru — BIANCA VEANA')

@section('content')
<div style="background: radial-gradient(circle at 50% 50%, #1c365d 0%, #172B49 100%); color: var(--ivory); padding: 50px 0; border-bottom: 2px solid var(--champagne-gold);">
  <div class="container" style="text-align: center;">
    <span class="hero-subtitle" style="justify-content: center;"><i class="fa-solid fa-crown"></i> MEMBERSHIP BIANCA VEANA</span>
    <h1 style="font-size: 2.4rem; margin: 8px 0;">REGISTRASI AKUN PEMBACA</h1>
    <p style="color: #BAC7D7; max-width: 600px; margin: 0 auto; font-size: 0.92rem;">
      Daftarkan diri Anda untuk menyimpan keranjang belanja di berbagai perangkat, riwayat pesanan otomatis, dan konsultasi via live chat dengan admin.
    </p>
  </div>
</div>

<div class="container" style="padding: 60px 24px 90px; max-width: 560px; margin: 0 auto;">
  <div style="background: var(--white); border: 1.5px solid var(--champagne-gold); border-radius: var(--radius-md); padding: 36px 32px; box-shadow: var(--shadow-md);">
    
    <div style="text-align: center; margin-bottom: 28px;">
      <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--ivory); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin: 0 auto 12px; border: 1px solid var(--soft-beige);">
        <i class="fa-solid fa-user-plus"></i>
      </div>
      <h2 style="font-family: var(--font-serif); font-size: 1.6rem; color: var(--ocean-navy); margin: 0 0 4px;">Buat Akun Pembaca Baru</h2>
      <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">Lengkapi formulir di bawah ini dengan data asli Anda.</p>
    </div>

    @if($errors->any())
      <div style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 6px; font-size: 0.82rem; margin-bottom: 22px;">
        <ul style="margin: 0; padding-left: 18px;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST">
      @csrf

      <div style="margin-bottom: 18px;">
        <label for="name" style="display: block; font-size: 0.82rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
          Nama Lengkap *
        </label>
        <div style="position: relative;">
          <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="contoh: Natasha Kahiyang" style="width: 100%; padding: 12px 14px 12px 40px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)';" onblur="this.style.borderColor='var(--soft-beige)';">
          <i class="fa-solid fa-user" style="position: absolute; left: 14px; top: 15px; color: #94A3B8; font-size: 0.95rem;"></i>
        </div>
      </div>

      <div style="margin-bottom: 18px;">
        <label for="email" style="display: block; font-size: 0.82rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
          Alamat Email Aktif *
        </label>
        <div style="position: relative;">
          <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="contoh: pembaca@gmail.com" style="width: 100%; padding: 12px 14px 12px 40px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)';" onblur="this.style.borderColor='var(--soft-beige)';">
          <i class="fa-solid fa-envelope" style="position: absolute; left: 14px; top: 15px; color: #94A3B8; font-size: 0.95rem;"></i>
        </div>
        <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 4px;">Tautan e-book digital dan konfirmasi invoice dikirim ke email ini.</span>
      </div>

      <div style="margin-bottom: 18px;">
        <label for="phone" style="display: block; font-size: 0.82rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
          Nomor WhatsApp / Telepon *
        </label>
        <div style="position: relative;">
          <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="contoh: 081234567890" style="width: 100%; padding: 12px 14px 12px 40px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)';" onblur="this.style.borderColor='var(--soft-beige)';">
          <i class="fa-brands fa-whatsapp" style="position: absolute; left: 14px; top: 15px; color: #16A34A; font-size: 1.05rem;"></i>
        </div>
        <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 4px;">Digunakan kurir pengiriman novel fisik & notifikasi resi.</span>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div>
          <label for="password" style="display: block; font-size: 0.82rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
            Kata Sandi *
          </label>
          <div style="position: relative;">
            <input type="password" id="password" name="password" required placeholder="Min. 6 karakter" style="width: 100%; padding: 12px 12px 12px 36px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.88rem; box-sizing: border-box;" onfocus="this.style.borderColor='var(--champagne-gold)';" onblur="this.style.borderColor='var(--soft-beige)';">
            <i class="fa-solid fa-lock" style="position: absolute; left: 12px; top: 15px; color: #94A3B8; font-size: 0.9rem;"></i>
          </div>
        </div>
        <div>
          <label for="password_confirmation" style="display: block; font-size: 0.82rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
            Konfirmasi Sandi *
          </label>
          <div style="position: relative;">
            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi kata sandi" style="width: 100%; padding: 12px 12px 12px 36px; border: 1.5px solid var(--soft-beige); border-radius: 6px; font-size: 0.88rem; box-sizing: border-box;" onfocus="this.style.borderColor='var(--champagne-gold)';" onblur="this.style.borderColor='var(--soft-beige)';">
            <i class="fa-solid fa-circle-check" style="position: absolute; left: 12px; top: 15px; color: #94A3B8; font-size: 0.9rem;"></i>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-gold" style="width: 100%; padding: 14px; font-size: 0.95rem; font-weight: 700; letter-spacing: 0.5px; border-radius: 6px; box-shadow: 0 4px 14px rgba(198, 161, 107, 0.35);">
        <i class="fa-solid fa-check"></i> DAFTAR AKUN SEKARANG
      </button>
    </form>

    <div style="margin-top: 26px; padding-top: 22px; border-top: 1px solid var(--soft-beige); text-align: center; font-size: 0.85rem; color: var(--text-muted);">
      Sudah memiliki akun terdaftar? 
      <a href="{{ route('login') }}" style="color: var(--ocean-navy); font-weight: 700; text-decoration: underline;">
        Masuk di Sini
      </a>
    </div>

  </div>
</div>
@endsection

