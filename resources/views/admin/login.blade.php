<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Control Center Administrator — BIANCA VEANA</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    :root {
      --admin-deep-bg: #070D18;
      --admin-surface: #0E1A2D;
      --admin-gold: #C6A16B;
      --admin-gold-hover: #D8B784;
      --admin-border: rgba(198, 161, 107, 0.35);
      --font-body: 'Plus Jakarta Sans', sans-serif;
      --font-display: 'Playfair Display', serif;
    }
    body {
      background-color: var(--admin-deep-bg);
      background-image: 
        radial-gradient(circle at 50% 20%, rgba(28, 54, 93, 0.45) 0%, transparent 70%),
        linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
      background-size: 100% 100%, 36px 36px, 36px 36px;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 20px;
      font-family: var(--font-body);
      margin: 0;
      box-sizing: border-box;
    }
    .admin-login-wrapper {
      width: 100%;
      max-width: 480px;
    }
    .admin-login-card {
      background: var(--admin-surface);
      border: 1.5px solid var(--admin-border);
      border-radius: 16px;
      box-shadow: 0 25px 70px rgba(0, 0, 0, 0.65), 0 0 40px rgba(198, 161, 107, 0.12);
      padding: 44px 38px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .admin-security-stripe {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #1E3A8A, var(--admin-gold), #1E3A8A);
    }
    .admin-logo-mark {
      width: 72px;
      height: 72px;
      margin: 0 auto 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(198, 161, 107, 0.1);
      border: 1.5px solid var(--admin-border);
      border-radius: 50%;
      padding: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    }
    .admin-logo-mark img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
    .admin-badge-restricted {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.35);
      color: #FCA5A5;
      font-size: 0.68rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      padding: 4px 12px;
      border-radius: 20px;
      margin-bottom: 12px;
    }
    .admin-title {
      font-family: var(--font-display);
      font-size: 1.75rem;
      font-weight: 700;
      letter-spacing: 2px;
      color: #FFFFFF;
      margin: 0 0 4px;
    }
    .admin-subtitle {
      font-size: 0.75rem;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--admin-gold);
      font-weight: 700;
      display: block;
      margin-bottom: 26px;
    }
    .form-group {
      text-align: left;
      margin-bottom: 20px;
    }
    .form-label {
      display: block;
      font-size: 0.8rem;
      font-weight: 700;
      color: #E2E8F0;
      margin-bottom: 7px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }
    .input-wrap {
      position: relative;
    }
    .form-input {
      width: 100%;
      padding: 13px 16px 13px 44px;
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 8px;
      font-size: 0.92rem;
      color: #FFFFFF;
      background: rgba(7, 13, 24, 0.7);
      box-sizing: border-box;
      transition: all 0.25s ease;
    }
    .form-input:focus {
      outline: none;
      border-color: var(--admin-gold);
      background: rgba(7, 13, 24, 0.95);
      box-shadow: 0 0 0 3px rgba(198, 161, 107, 0.25);
    }
    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--admin-gold);
      font-size: 1rem;
    }
    .toggle-password {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #64748B;
      cursor: pointer;
      font-size: 0.95rem;
      background: none;
      border: none;
      padding: 0;
    }
    .toggle-password:hover {
      color: #CBD5E1;
    }
    .btn-admin-submit {
      width: 100%;
      padding: 14px;
      background: var(--admin-gold);
      color: #070D18;
      border: none;
      border-radius: 8px;
      font-size: 0.92rem;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 4px 18px rgba(198, 161, 107, 0.35);
    }
    .btn-admin-submit:hover {
      background: var(--admin-gold-hover);
      transform: translateY(-1px);
      box-shadow: 0 6px 22px rgba(198, 161, 107, 0.45);
    }
    .admin-credentials-box {
      background: rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(198, 161, 107, 0.2);
      border-radius: 8px;
      padding: 14px 16px;
      font-size: 0.78rem;
      color: #CBD5E1;
      text-align: left;
      margin-top: 24px;
      line-height: 1.6;
    }
    .admin-switch-banner {
      margin-top: 22px;
      padding-top: 18px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      text-align: center;
      font-size: 0.82rem;
      color: #94A3B8;
    }
    .admin-switch-link {
      color: #93C5FD;
      font-weight: 700;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-top: 6px;
      transition: color 0.2s;
    }
    .admin-switch-link:hover {
      color: #BFDBFE;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="admin-login-wrapper">
    <div class="admin-login-card">
      <div class="admin-security-stripe"></div>

      <!-- Admin Logo Mark -->
      <div class="admin-logo-mark">
        <img src="{{ asset('images/logo.png') }}" alt="Bianca Veana Logo">
      </div>

      <div class="admin-badge-restricted">
        <i class="fa-solid fa-lock"></i> RESTRICTED AREA · KHUSUS STAFF & ADMIN
      </div>

      <h1 class="admin-title">CONTROL CENTER</h1>
      <span class="admin-subtitle">BIANCA VEANA OFFICIAL BOOKSTORE</span>

      @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #34D399; padding: 12px; border-radius: 6px; font-size: 0.82rem; margin-bottom: 20px; text-align: left;">
          <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
      @endif

      @if(session('warning'))
        <div style="background: rgba(245, 158, 11, 0.15); border: 1px solid #F59E0B; color: #FCD34D; padding: 12px; border-radius: 6px; font-size: 0.82rem; margin-bottom: 20px; text-align: left;">
          <i class="fa-solid fa-circle-exclamation"></i> {{ session('warning') }}
        </div>
      @endif

      @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #EF4444; color: #FCA5A5; padding: 12px; border-radius: 6px; font-size: 0.82rem; margin-bottom: 20px; text-align: left;">
          <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('admin.login.submit') }}" method="POST">
        @csrf

        <div class="form-group">
          <label class="form-label">Username / Email Administrator</label>
          <div class="input-wrap">
            <i class="fa-solid fa-user-shield input-icon"></i>
            <input type="text" name="login" value="{{ old('login', 'bianca_admin') }}" class="form-input" required placeholder="Masukkan username/email admin" autofocus>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Kata Sandi Administrator</label>
          <div class="input-wrap">
            <i class="fa-solid fa-key input-icon"></i>
            <input type="password" name="password" id="admin-password-field" class="form-input" required placeholder="••••••••••••">
            <button type="button" class="toggle-password" onclick="togglePasswordVisibility()" title="Tampilkan sandi">
              <i class="fa-regular fa-eye" id="admin-toggle-icon"></i>
            </button>
          </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 0.82rem; color: #94A3B8;">
          <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} style="accent-color: var(--admin-gold);">
            <span>Ingat sesi di komputer ini</span>
          </label>
        </div>

        <button type="submit" class="btn-admin-submit">
          <i class="fa-solid fa-shield-halved"></i> MASUK KE CONTROL CENTER
        </button>
      </form>

      <!-- Default Credentials Helper Box -->
      <div class="admin-credentials-box">
        <div style="font-weight: 700; color: var(--admin-gold); margin-bottom: 4px;">
          <i class="fa-solid fa-circle-info"></i> Kredensial Akses Administrator:
        </div>
        <div><strong>Username:</strong> <code>bianca_admin</code> (atau <code>admin@biancaveana.com</code>)</div>
        <div><strong>Password:</strong> <code>Notonegoro@2026!Royal</code></div>
      </div>

      <!-- Separation Switch: Ke Portal Customer -->
      <div class="admin-switch-banner">
        <span>Bukan pengelola toko? Ingin membeli novel atau e-book?</span><br>
        <a href="{{ route('login') }}" class="admin-switch-link">
          <i class="fa-solid fa-bag-shopping"></i> Menuju ke Halaman Login Pembaca / Customer &rarr;
        </a>
      </div>

    </div>
  </div>

  <script>
    function togglePasswordVisibility() {
      const field = document.getElementById('admin-password-field');
      const icon = document.getElementById('admin-toggle-icon');
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
