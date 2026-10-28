@extends('layouts.admin')

@section('title', 'Edit Akun Customer: ' . $customer->name . ' — Admin BIANCA VEANA')

@section('content')
<div class="admin-container" style="max-width: 900px;">
  
  <div style="margin-bottom: 24px;">
    <a href="{{ route('admin.customers.index') }}" style="color: #64748B; font-size: 0.82rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 12px;">
      <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Customer
    </a>
    <h2 style="font-family: var(--font-display); font-size: 1.8rem; color: #0F172A; margin: 0 0 6px; font-weight: 700;">
      Edit Profil Customer: {{ $customer->name }}
    </h2>
    <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
      Perbarui data kontak, alamat, atau atur ulang kata sandi akun pembaca ini.
    </p>
  </div>

  @if($errors->any())
    <div style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B; padding: 14px 18px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 24px;">
      <ul style="margin: 0; padding-left: 18px;">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="admin-card" style="padding: 32px;">
    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #0F172A; margin-bottom: 6px; text-transform: uppercase;">
            Nama Customer *
          </label>
          <input type="text" name="name" value="{{ old('name', $customer->name) }}" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border-subtle); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
        </div>

        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #0F172A; margin-bottom: 6px; text-transform: uppercase;">
            Alamat Email *
          </label>
          <input type="email" name="email" value="{{ old('email', $customer->email) }}" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border-subtle); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #0F172A; margin-bottom: 6px; text-transform: uppercase;">
            Nomor WhatsApp / Telepon
          </label>
          <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" placeholder="contoh: 08123456789" style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border-subtle); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
        </div>

        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #0F172A; margin-bottom: 6px; text-transform: uppercase;">
            Kota / Kabupaten
          </label>
          <input type="text" name="city" value="{{ old('city', $customer->city) }}" placeholder="contoh: Jakarta Selatan" style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border-subtle); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px;">
        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #0F172A; margin-bottom: 6px; text-transform: uppercase;">
            Alamat Lengkap Pengiriman
          </label>
          <textarea name="address" rows="3" placeholder="Alamat jalan, nomor rumah, RT/RW, kelurahan" style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border-subtle); border-radius: 6px; font-size: 0.88rem; box-sizing: border-box;">{{ old('address', $customer->address) }}</textarea>
        </div>

        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #0F172A; margin-bottom: 6px; text-transform: uppercase;">
            Kode Pos
          </label>
          <input type="text" name="postal_code" value="{{ old('postal_code', $customer->postal_code) }}" placeholder="contoh: 12820" style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border-subtle); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
        </div>
      </div>

      <!-- Password Reset Box -->
      <div style="background: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 8px; padding: 20px; margin-bottom: 28px;">
        <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #0F172A; margin-bottom: 6px; text-transform: uppercase;">
          <i class="fa-solid fa-key" style="color: var(--admin-gold);"></i> Atur Ulang Kata Sandi Customer (Opsional)
        </label>
        <span style="font-size: 0.78rem; color: #64748B; display: block; margin-bottom: 10px;">
          Kosongkan jika tidak ingin mengganti password customer ini.
        </span>
        <input type="password" name="new_password" placeholder="Masukkan kata sandi baru (min. 6 karakter)" style="width: 100%; max-width: 400px; padding: 10px 14px; border: 1px solid var(--admin-border-subtle); border-radius: 6px; font-size: 0.88rem; box-sizing: border-box; background: #FFF;">
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--admin-border-subtle); padding-top: 20px;">
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-gold" style="background: #FFF; border-color: #CBD5E1; color: #475569; padding: 10px 20px; font-size: 0.85rem;">
          Batal
        </a>

        <div style="display: flex; gap: 10px;">
          <a href="{{ route('admin.chat.index', ['user_id' => $customer->id]) }}" class="btn" style="background: #EEF2FF; color: #4F46E5; padding: 10px 18px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; text-decoration: none;">
            <i class="fa-solid fa-comments"></i> Buka Chat
          </a>

          <button type="submit" class="btn btn-gold" style="padding: 10px 24px; font-size: 0.88rem; font-weight: 700;">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
          </button>
        </div>
      </div>

    </form>
  </div>

</div>
@endsection

