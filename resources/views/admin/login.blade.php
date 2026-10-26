<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Administrator — BIANCA VEANA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    body {
      background: radial-gradient(circle at 50% 40%, #1c365d 0%, #172B49 50%, #0B1526 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      font-family: var(--font-sans);
    }
    .login-card {
      background: rgba(255, 255, 255, 0.98);
      border: 2px solid var(--champagne-gold);
      border-radius: var(--radius-lg);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.45);
      width: 100%;
      max-width: 460px;
      padding: 44px 36px;
      text-align: center;
      position: relative;
    }
    .login-brand {
      font-family: var(--font-serif);
      font-size: 1.8rem;
      font-weight: 700;
      letter-spacing: 4px;
      color: var(--ocean-navy);
      margin-bottom: 2px;
    }
    .login-subtitle {
      font-size: 0.72rem;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--champagne-gold);
      font-weight: 700;
      margin-bottom: 30px;
      display: block;
    }
    .form-group {
      text-align: left;
      margin-bottom: 20px;
    }
    .form-label {
      display: block;
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--ocean-navy);
      margin-bottom: 6px;
    }
    .input-wrap {
      position: relative;
    }
    .form-input {
      width: 100%;
      padding: 13px 16px 13px 42px;
      border: 1px solid var(--soft-beige);
      border-radius: var(--radius-sm);
      font-size: 0.92rem;
      transition: all 0.2s ease;
      background: #FAF7F2;
    }
    .form-input:focus {
      outline: none;
      border-color: var(--champagne-gold);
      background: #FFFFFF;
      box-shadow: 0 0 0 3px rgba(198, 161, 107, 0.2);
    }
    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--champagne-gold);
      font-size: 0.95rem;
    }
    .toggle-password {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #9CA3AF;
      cursor: pointer;
      font-size: 0.95rem;
      background: none;
      border: none;
    }
    .login-help-box {
      background: var(--ivory);
      border: 1px dashed var(--champagne-gold);
      border-radius: var(--radius-sm);
      padding: 14px;
      font-size: 0.78rem;
      color: var(--ocean-navy);
      text-align: left;
      margin-top: 24px;
      line-height: 1.6;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--ocean-navy); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 16px; border: 2px solid var(--champagne-gold);">
      <i class="fa-solid fa-crown"></i>
    </div>

    <h2 class="login-brand">BIANCA VEANA</h2>
    <span class="login-subtitle">BACKEND PORTAL CONTROL</span>

    @if(session('success'))
      <div style="background: #DCFCE7; color: #166534; padding: 10px; border-radius: 4px; font-size: 0.82rem; margin-bottom: 20px;">
        {{ session('success') }}
      </div>
    @endif

    @if(session('warning'))
      <div style="background: #FEF3C7; color: #92400E; padding: 10px; border-radius: 4px; font-size: 0.82rem; margin-bottom: 20px;">
        {{ session('warning') }}
      </div>
    @endif

    @if($errors->any())
      <div style="background: #FEE2E2; color: #991B1B; padding: 10px; border-radius: 4px; font-size: 0.82rem; margin-bottom: 20px; text-align: left;">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
      @csrf

      <div class="form-group">
        <label class="form-label">Username atau Email Admin</label>
        <div class="input-wrap">
          <i class="fa-solid fa-user-shield input-icon"></i>
          <input type="text" name="login" value="{{ old('login', 'bianca_admin') }}" class="form-input" required placeholder="Masukkan username atau email" autofocus>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Kata Sandi (Password)</label>
        <div class="input-wrap">
          <i class="fa-solid fa-key input-icon"></i>
          <input type="password" name="password" id="password-field" class="form-input" required placeholder="••••••••••••">
          <button type="button" class="toggle-password" onclick="togglePasswordVisibility()" title="Tampilkan sandi">
            <i class="fa-regular fa-eye" id="toggle-icon"></i>
          </button>
        </div>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 0.82rem;">
        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--text-dark);">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
          <span>Ingat sesi saya</span>
        </label>
        <a href="{{ route('home') }}" style="color: var(--ocean-navy); font-weight: 600;">
          &larr; Ke Toko Publik
        </a>
      </div>

      <button type="submit" class="btn btn-gold" style="width: 100%; padding: 14px; font-size: 0.9rem; font-weight: 700;">
        <i class="fa-solid fa-shield-halved"></i> MASUK KE PANEL KONTROL
      </button>
    </form>

    <!-- Secure Credentials Reference Box -->
    <div class="login-help-box">
      <div style="font-weight: 700; color: var(--ocean-navy); margin-bottom: 4px;">
        <i class="fa-solid fa-circle-info" style="color: var(--champagne-gold);"></i> Kredensial Administrator Resmi:
      </div>
      <div><strong>Username:</strong> <code>bianca_admin</code> (atau <code>admin@biancaveana.com</code>)</div>
      <div><strong>Password:</strong> <code>Notonegoro@2026!Royal</code></div>
      <div style="font-size: 0.72rem; color: #64748B; margin-top: 4px;">
        *Password dienkripsi kuat menggunakan algoritma Bcrypt (12 rounds) di database.
      </div>
    </div>
  </div>

  <script>
    function togglePasswordVisibility() {
      const field = document.getElementById('password-field');
      const icon = document.getElementById('toggle-icon');
      if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>
