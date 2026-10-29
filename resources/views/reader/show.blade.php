<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <title>{{ $part->title }} — Web Novel Reader | BIANCA VEANA</title>
  <link rel="icon" type="image/x-icon" href="/favicon.ico">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
  
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    :root {
      --champagne-gold: #C6A16B;
      --gold-dark: #9A7B4F;
      --reader-font-size: 18px;
      --reader-max-width: 760px;
      --reader-line-height: 1.95;
    }

    /* THEME 1: IVORY PAPER (Default) */
    body.theme-ivory {
      --bg-body: #FAF7F2;
      --bg-header: rgba(250, 247, 242, 0.92);
      --bg-card: #FFFFFF;
      --text-main: #24292F;
      --text-muted: #6B7280;
      --border-color: #E7DFD5;
      --reader-accent: #C6A16B;
    }

    /* THEME 2: SEPIA WARM */
    body.theme-sepia {
      --bg-body: #F4ECD8;
      --bg-header: rgba(244, 236, 216, 0.94);
      --bg-card: #EFE4CA;
      --text-main: #3F3125;
      --text-muted: #7A6957;
      --border-color: #DFD3BA;
      --reader-accent: #B38645;
    }

    /* THEME 3: MIDNIGHT / DARK */
    body.theme-midnight {
      --bg-body: #111622;
      --bg-header: rgba(17, 22, 34, 0.92);
      --bg-card: #182030;
      --text-main: #CBD5E1;
      --text-muted: #8492A6;
      --border-color: #273349;
      --reader-accent: #E6CA85;
    }

    /* THEME 4: CLEAN WHITE */
    body.theme-white {
      --bg-body: #FFFFFF;
      --bg-header: rgba(255, 255, 255, 0.94);
      --bg-card: #F9FAFB;
      --text-main: #111827;
      --text-muted: #6B7280;
      --border-color: #E5E7EB;
      --reader-accent: #C6A16B;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background-color: var(--bg-body);
      color: var(--text-main);
      font-family: 'Lora', 'Georgia', serif;
      transition: background-color 0.25s ease, color 0.25s ease;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      user-select: none;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
    }

    /* Top Reading Progress Bar */
    #readingProgressBar {
      position: fixed;
      top: 0;
      left: 0;
      height: 3.5px;
      width: 0%;
      background: linear-gradient(90deg, var(--champagne-gold), #F4D068, var(--champagne-gold));
      z-index: 9999;
      transition: width 0.1s ease-out;
      box-shadow: 0 1px 6px rgba(198, 161, 107, 0.6);
    }

    /* Sticky Header Control Bar */
    .reader-header {
      position: sticky;
      top: 0;
      background: var(--bg-header);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-bottom: 1px solid var(--border-color);
      z-index: 1000;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: background-color 0.25s ease, border-color 0.25s ease;
    }

    .reader-header-left {
      display: flex;
      align-items: center;
      gap: 14px;
      min-width: 0;
    }

    .btn-back-book {
      background: none;
      border: 1px solid var(--border-color);
      color: var(--text-main);
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 0.8rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
      flex-shrink: 0;
    }

    .btn-back-book:hover {
      border-color: var(--champagne-gold);
      color: var(--champagne-gold);
    }

    .reader-title-info {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .reader-book-name {
      font-size: 0.76rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--reader-accent);
      font-weight: 700;
      display: block;
    }

    .reader-chapter-name {
      font-size: 0.9rem;
      font-weight: 700;
      color: var(--text-main);
      overflow: hidden;
      text-overflow: ellipsis;
      display: block;
    }

    .reader-controls {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }

    /* Control Pills */
    .control-group {
      display: flex;
      align-items: center;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: 8px;
      padding: 2px 4px;
    }

    .control-btn {
      background: none;
      border: none;
      color: var(--text-main);
      padding: 6px 10px;
      font-size: 0.82rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 600;
      cursor: pointer;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.15s;
    }

    .control-btn:hover {
      color: var(--champagne-gold);
    }

    .control-btn.active {
      background: var(--reader-accent);
      color: #FFFFFF;
    }

    /* Theme color dots */
    .theme-dot {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      border: 2px solid transparent;
      cursor: pointer;
      margin: 0 3px;
      transition: transform 0.15s, border-color 0.15s;
    }

    .theme-dot:hover {
      transform: scale(1.15);
    }

    .theme-dot.active {
      border-color: var(--champagne-gold);
      box-shadow: 0 0 0 2px var(--bg-card);
    }

    .theme-dot.ivory { background-color: #FAF7F2; border: 1px solid #D5C8B8; }
    .theme-dot.sepia { background-color: #F4ECD8; border: 1px solid #C4B090; }
    .theme-dot.midnight { background-color: #111622; border: 1px solid #374661; }
    .theme-dot.white { background-color: #FFFFFF; border: 1px solid #CBD5E1; }

    /* Chapter Drawer Overlay */
    #chapterDrawer {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.65);
      backdrop-filter: blur(4px);
      z-index: 2000;
      display: none;
      align-items: flex-end;
      justify-content: flex-end;
    }

    .drawer-panel {
      background: var(--bg-card);
      color: var(--text-main);
      width: 100%;
      max-width: 420px;
      height: 100%;
      box-shadow: -5px 0 25px rgba(0,0,0,0.3);
      display: flex;
      flex-direction: column;
      animation: slideInRight 0.25s ease-out;
    }

    @keyframes slideInRight {
      from { transform: translateX(100%); }
      to { transform: translateX(0); }
    }

    .drawer-header {
      padding: 18px 22px;
      border-bottom: 1px solid var(--border-color);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .drawer-header h3 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.1rem;
      font-weight: 700;
    }

    .drawer-close {
      background: none;
      border: none;
      color: var(--text-muted);
      font-size: 1.4rem;
      cursor: pointer;
    }

    .drawer-list {
      flex: 1;
      overflow-y: auto;
      padding: 12px 16px;
    }

    .drawer-item {
      padding: 12px 14px;
      border-radius: 8px;
      margin-bottom: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      text-decoration: none;
      color: var(--text-main);
      border: 1px solid transparent;
      transition: all 0.15s;
    }

    .drawer-item:hover {
      background: var(--bg-body);
      border-color: var(--border-color);
    }

    .drawer-item.active {
      background: var(--bg-body);
      border-color: var(--champagne-gold);
    }

    .drawer-item.active strong {
      color: var(--champagne-gold);
    }

    /* Main Reader Canvas */
    .reader-container {
      max-width: var(--reader-max-width);
      width: 100%;
      margin: 0 auto;
      padding: 40px 24px 80px;
      flex: 1;
    }

    /* Chapter Header Banner */
    .chapter-heading-box {
      text-align: center;
      padding-bottom: 36px;
      margin-bottom: 36px;
      border-bottom: 1px solid var(--border-color);
      position: relative;
    }

    .chapter-series-badge {
      display: inline-block;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--reader-accent);
      background: rgba(198, 161, 107, 0.12);
      border: 1px solid rgba(198, 161, 107, 0.35);
      padding: 4px 14px;
      border-radius: 20px;
      margin-bottom: 14px;
    }

    .chapter-novel-title {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      color: var(--text-main);
      margin-bottom: 8px;
      font-weight: 700;
      line-height: 1.25;
    }

    .chapter-part-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.15rem;
      color: var(--reader-accent);
      font-weight: 600;
      margin-bottom: 14px;
    }

    .chapter-meta-row {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 16px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.78rem;
      color: var(--text-muted);
    }

    /* Content Typography */
    .reader-body {
      font-size: var(--reader-font-size);
      line-height: var(--reader-line-height);
      color: var(--text-main);
      transition: font-size 0.15s ease;
      letter-spacing: 0.2px;
    }

    .reader-body p {
      margin-bottom: 1.6em;
      text-align: justify;
      text-justify: inter-word;
    }

    /* Novel Indent Mode */
    .reader-body.indent-paragraphs p {
      text-indent: 1.8em;
      margin-bottom: 0.8em;
    }
    .reader-body.indent-paragraphs p:first-of-type {
      text-indent: 0;
    }

    /* Font Family Modes */
    body.font-sans, body.font-sans .reader-body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }

    body.font-serif, body.font-serif .reader-body {
      font-family: 'Lora', 'Georgia', serif !important;
    }

    /* Chapter Divider Ornament */
    .scene-break {
      text-align: center;
      margin: 2.5em 0;
      color: var(--reader-accent);
      font-size: 1.1rem;
      letter-spacing: 8px;
      opacity: 0.8;
    }

    /* Paywall / Locked Card */
    .paywall-wrapper {
      position: relative;
      margin-top: -60px;
      padding-top: 80px;
      background: linear-gradient(to bottom, transparent 0%, var(--bg-body) 30%, var(--bg-body) 100%);
      z-index: 10;
    }

    .paywall-card {
      background: var(--bg-card);
      border: 1.5px solid var(--champagne-gold);
      border-radius: 16px;
      padding: 36px 30px;
      text-align: center;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
      max-width: 580px;
      margin: 0 auto;
    }

    .paywall-icon {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background: rgba(198, 161, 107, 0.15);
      color: var(--champagne-gold);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.7rem;
      margin: 0 auto 16px;
    }

    .paywall-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.6rem;
      color: var(--text-main);
      margin-bottom: 8px;
    }

    .paywall-desc {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.9rem;
      color: var(--text-muted);
      line-height: 1.6;
      margin-bottom: 22px;
    }

    .paywall-price {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.8rem;
      font-weight: 800;
      color: #15803D;
      margin-bottom: 20px;
    }

    .btn-buy-part {
      background: linear-gradient(135deg, #C6A16B 0%, #A8834C 100%);
      color: #FFFFFF;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700;
      font-size: 0.95rem;
      padding: 14px 28px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      box-shadow: 0 6px 18px rgba(198, 161, 107, 0.4);
      transition: all 0.2s;
      width: 100%;
      justify-content: center;
    }

    .btn-buy-part:hover {
      box-shadow: 0 8px 24px rgba(198, 161, 107, 0.6);
      transform: translateY(-2px);
    }

    /* Bottom Navigation Between Chapters */
    .chapter-nav-bar {
      margin-top: 60px;
      padding-top: 28px;
      border-top: 1px solid var(--border-color);
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 14px;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .nav-chapter-btn {
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      color: var(--text-main);
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 0.85rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
    }

    .nav-chapter-btn:hover:not(.disabled) {
      border-color: var(--champagne-gold);
      color: var(--champagne-gold);
    }

    .nav-chapter-btn.disabled {
      opacity: 0.4;
      pointer-events: none;
      cursor: not-allowed;
    }

    /* Watermark / Copyright Protection Footer */
    .reader-copyright-watermark {
      text-align: center;
      padding: 30px 20px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.75rem;
      color: var(--text-muted);
      border-top: 1px dashed var(--border-color);
      margin-top: 40px;
      letter-spacing: 0.5px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .reader-header {
        padding: 8px 12px;
      }
      .reader-title-info {
        display: none;
      }
      .chapter-novel-title {
        font-size: 1.7rem;
      }
      .chapter-part-title {
        font-size: 1rem;
      }
      .reader-container {
        padding: 24px 16px 60px;
      }
      .chapter-nav-bar {
        flex-direction: column;
        gap: 10px;
      }
      .nav-chapter-btn {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>
<body class="theme-ivory font-serif">

  <!-- Top Real-time Reading Progress Bar -->
  <div id="readingProgressBar"></div>

  <!-- Sticky Header Controls -->
  <header class="reader-header">
    <div class="reader-header-left">
      <a href="{{ route('ebooks.show', $parent->slug) }}" class="btn-back-book" title="Kembali ke Ringkasan Buku">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Buku</span>
      </a>

      <div class="reader-title-info">
        <span class="reader-book-name">{{ $parent->title }}</span>
        <span class="reader-chapter-name">{{ $part->title }}</span>
      </div>
    </div>

    <!-- Right Controls: Font, Theme, Chapter List -->
    <div class="reader-controls">
      <!-- Font Family Toggle (Serif vs Sans) -->
      <div class="control-group" title="Ganti Jenis Huruf (Serif / Sans)">
        <button type="button" class="control-btn" id="btnFontToggle" onclick="toggleFontFamily()">
          <span style="font-family: serif; font-weight: bold; margin-right: 2px;">S</span>/<span style="font-family: sans-serif; font-size: 0.75rem;">S</span>
        </button>
      </div>

      <!-- Font Size Adjusters -->
      <div class="control-group" title="Atur Ukuran Huruf">
        <button type="button" class="control-btn" onclick="adjustFontSize(-1)" title="Perkecil Huruf">A-</button>
        <button type="button" class="control-btn" onclick="resetFontSize()" title="Reset Ukuran" style="font-size: 0.72rem;">100%</button>
        <button type="button" class="control-btn" onclick="adjustFontSize(1)" title="Perbesar Huruf">A+</button>
      </div>

      <!-- Theme Color Selector -->
      <div class="control-group" style="padding: 4px 6px;">
        <div class="theme-dot ivory active" onclick="setTheme('ivory')" title="Tema Kertas Ivory (Nyaman di Mata)"></div>
        <div class="theme-dot sepia" onclick="setTheme('sepia')" title="Tema Sepia Klasik"></div>
        <div class="theme-dot midnight" onclick="setTheme('midnight')" title="Tema Malam / Midnight (OLED Dark)"></div>
        <div class="theme-dot white" onclick="setTheme('white')" title="Tema Putih Bersih"></div>
      </div>

      <!-- Chapter Drawer Trigger -->
      <button type="button" class="control-btn" style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 6px 12px;" onclick="openChapterDrawer()" title="Daftar Bab">
        <i class="fa-solid fa-list-ul"></i>
      </button>
    </div>
  </header>

  <!-- Chapter Drawer Modal -->
  <div id="chapterDrawer" onclick="closeChapterDrawer(event)">
    <div class="drawer-panel" onclick="event.stopPropagation()">
      <div class="drawer-header">
        <div>
          <h3>Daftar Bab / Part</h3>
          <span style="font-size: 0.78rem; color: var(--text-muted); font-family: 'Plus Jakarta Sans', sans-serif;">{{ $parent->title }}</span>
        </div>
        <button class="drawer-close" onclick="closeChapterDrawer()">&times;</button>
      </div>
      <div class="drawer-list">
        @foreach($allParts as $p)
          <a href="{{ route('reader.show', ['slug' => $p->slug, 'order' => request('order')]) }}" class="drawer-item {{ $p->id === $part->id ? 'active' : '' }}">
            <div style="font-family: 'Plus Jakarta Sans', sans-serif;">
              <strong style="display: block; font-size: 0.88rem; margin-bottom: 2px;">
                {{ $p->title }}
              </strong>
              <span style="font-size: 0.74rem; color: var(--text-muted);">
                @if($p->part_number) Part {{ $p->part_number }} @else Edisi Lengkap @endif
              </span>
            </div>
            <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.82rem; font-weight: 700; color: #15803D;">
              {{ $p->formatted_price }}
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Main Reader Canvas -->
  <main class="reader-container">

    <!-- Chapter Heading Box -->
    <div class="chapter-heading-box">
      <span class="chapter-series-badge">
        {{ $parent->series_name ?: 'BIANCA VEANA DIGITAL NOVEL' }}
      </span>
      <h1 class="chapter-novel-title">{{ $parent->title }}</h1>
      <h2 class="chapter-part-title">{{ $part->title }}</h2>

      <div class="chapter-meta-row">
        <span><i class="fa-solid fa-feather" style="color: var(--champagne-gold);"></i> Bianca Veana</span>
        <span>•</span>
        @php
          $wordCount = str_word_count(strip_tags($part->content ?? $part->synopsis ?? ''));
          $readingMinutes = max(2, ceil($wordCount / 180));
        @endphp
        <span><i class="fa-regular fa-clock" style="color: var(--champagne-gold);"></i> ~{{ $readingMinutes }} menit membaca</span>
        @if(auth()->guard('admin')->check())
          <span>•</span>
          <span style="background: #FEF3C7; color: #92400E; padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 0.72rem;">
            <i class="fa-solid fa-shield-halved"></i> Mode Pratinjau Admin
          </span>
        @elseif($hasAccess)
          <span>•</span>
          <span style="background: #DCFCE7; color: #166534; padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 0.72rem;">
            <i class="fa-solid fa-check"></i> Akses Terkonfirmasi
          </span>
        @endif
      </div>
    </div>

    <!-- Chapter Content Body -->
    @if($hasAccess)
      <!-- FULL READING ACCESS GRANTED -->
      <article class="reader-body" id="readerBodyText">
        @if($part->content)
          @php
            // Format naskah ke paragraf HTML rapi
            $paragraphs = preg_split('/\r\n\r\n|\n\n/', trim($part->content));
          @endphp

          @foreach($paragraphs as $p)
            @php $p = trim($p); @endphp
            @if(!empty($p))
              @if(in_array($p, ['***', '* * *', '---', '•••', '• • •']))
                <div class="scene-break">❖ ❖ ❖</div>
              @else
                <p>{!! nl2br(e($p)) !!}</p>
              @endif
            @endif
          @endforeach

        @elseif($part->synopsis)
          <!-- Fallback jika content naskah bab belum diinput admin -->
          <div style="background: var(--bg-card); border: 1.5px solid var(--border-color); border-radius: 12px; padding: 24px 28px; margin-bottom: 28px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; color: var(--reader-accent);">
              <i class="fa-solid fa-bookmark"></i>
              <strong style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                Ringkasan & Intisari Part:
              </strong>
            </div>
            <p style="margin-bottom: 0; font-style: italic;">{!! nl2br(e($part->synopsis)) !!}</p>
          </div>

          <div style="background: rgba(198, 161, 107, 0.1); border: 1px dashed var(--champagne-gold); border-radius: 12px; padding: 24px; text-align: center; margin-top: 24px;">
            <i class="fa-solid fa-file-pdf" style="font-size: 2.2rem; color: var(--champagne-gold); margin-bottom: 12px;"></i>
            <h4 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.05rem; margin-bottom: 6px; color: var(--text-main);">
              Naskah Lengkap Siap Dibaca via PDF
            </h4>
            <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 18px; max-width: 480px; margin-left: auto; margin-right: auto;">
              Naskah digital lengkap untuk bab ini telah tersedia dalam format PDF resolusi tinggi atau tautan Google Drive resmi Anda.
            </p>
            @if($part->digital_file_url)
              <a href="{{ $part->digital_file_url }}" target="_blank" class="btn-buy-part" style="max-width: 260px; margin: 0 auto; padding: 10px 20px; font-size: 0.85rem;">
                <i class="fa-solid fa-download"></i> Buka / Unduh File PDF
              </a>
            @endif
          </div>
        @else
          <p style="text-align: center; color: var(--text-muted); padding: 40px 0;">
            Naskah cerita untuk bab ini sedang dalam proses pembaruan oleh penulis.
          </p>
        @endif
      </article>

    @else
      <!-- PAYWALL / LOCKED PREVIEW MODE -->
      <article class="reader-body" style="position: relative; max-height: 480px; overflow: hidden;">
        @if($part->synopsis)
          <div style="background: var(--bg-card); border-left: 4px solid var(--champagne-gold); padding: 18px 22px; border-radius: 0 8px 8px 0; margin-bottom: 24px;">
            <strong style="display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.78rem; text-transform: uppercase; color: var(--reader-accent); margin-bottom: 6px; letter-spacing: 1px;">
              Pratinjau Cerita Bab:
            </strong>
            <p style="margin-bottom: 0;">{{ $part->synopsis }}</p>
          </div>
        @endif

        @if($part->content)
          @php
            $previewText = Str::limit(trim($part->content), 750, '...');
            $paragraphs = preg_split('/\r\n\r\n|\n\n/', $previewText);
          @endphp
          @foreach($paragraphs as $p)
            <p>{!! nl2br(e($p)) !!}</p>
          @endforeach
        @else
          <p>
            Kelanjutan kisah <em>{{ $parent->title }}</em> pada {{ $part->title }} membawa kita masuk lebih dalam ke dalam intrik, dinamika hubungan, dan rahasia yang tersembunyi di balik keluarga besar Notonegoro...
          </p>
          <p>
            Hawa dingin malam menyelimuti koridor panjang paviliun utama. Suara langkah pelan itu terdengar jelas di antara hening, mendekat ke arah ruangan kerja yang berpintu ganda...
          </p>
        @endif
      </article>

      <!-- Paywall Lock Box -->
      <div class="paywall-wrapper">
        <div class="paywall-card">
          <div class="paywall-icon">
            <i class="fa-solid fa-lock"></i>
          </div>
          <h3 class="paywall-title">Bab Ini Terkunci</h3>
          <p class="paywall-desc">
            Selesaikan pembelian part <strong>{{ $part->title }}</strong> untuk melanjutkan membaca keseluruhan naskah bab lengkap secara instan di Web Reader ini.
          </p>

          <div class="paywall-price">
            {{ $part->formatted_price }}
          </div>

          <form action="{{ route('cart.add') }}" method="POST" style="margin-bottom: 14px;">
            @csrf
            <input type="hidden" name="product_id" value="{{ $part->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn-buy-part">
              <i class="fa-solid fa-cart-shopping"></i> Beli Part Ini Sekarang
            </button>
          </form>

          <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.8rem; color: var(--text-muted); display: flex; justify-content: center; gap: 14px; align-items: center; margin-top: 14px;">
            <span><i class="fa-solid fa-bolt" style="color: var(--champagne-gold);"></i> Akses Instan</span>
            <span>•</span>
            <span><i class="fa-solid fa-mobile-screen" style="color: var(--champagne-gold);"></i> Nyaman di Semua Perangkat</span>
          </div>

          @guest
            <div style="margin-top: 18px; padding-top: 14px; border-top: 1px dashed var(--border-color); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.78rem; color: var(--text-muted);">
              Sudah pernah membeli part ini? <a href="{{ route('login') }}" style="color: var(--champagne-gold); font-weight: 700; text-decoration: underline;">Masuk ke Akun Anda</a>
            </div>
          @endguest
        </div>
      </div>
    @endif

    <!-- Chapter Navigation Footer -->
    <nav class="chapter-nav-bar">
      @if($prevPart)
        <a href="{{ route('reader.show', ['slug' => $prevPart->slug, 'order' => request('order')]) }}" class="nav-chapter-btn">
          <i class="fa-solid fa-arrow-left"></i>
          <span>Bab Sebelumnya</span>
        </a>
      @else
        <span class="nav-chapter-btn disabled">
          <i class="fa-solid fa-arrow-left"></i>
          <span>Bab Pertama</span>
        </span>
      @endif

      <button type="button" class="nav-chapter-btn" onclick="openChapterDrawer()" style="background: none; border-color: var(--champagne-gold); color: var(--reader-accent); font-weight: 700;">
        <i class="fa-solid fa-book-open"></i> Daftar Bab
      </button>

      @if($nextPart)
        <a href="{{ route('reader.show', ['slug' => $nextPart->slug, 'order' => request('order')]) }}" class="nav-chapter-btn">
          <span>Bab Selanjutnya</span>
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      @else
        <span class="nav-chapter-btn disabled">
          <span>Bab Terakhir</span>
          <i class="fa-solid fa-check"></i>
        </span>
      @endif
    </nav>

    <!-- Discreet Watermark Protection -->
    <div class="reader-copyright-watermark">
      <i class="fa-solid fa-shield-halved" style="color: var(--champagne-gold); margin-right: 4px;"></i>
      Naskah Resmi BIANCA VEANA UNIVERSE • Hak Cipta Dilindungi Undang-Undang Republik Indonesia No. 28 Tahun 2014.
    </div>

  </main>

  <!-- Reader JavaScript Interactions -->
  <script>
    // 1. Reading Progress Bar on Scroll
    window.addEventListener('scroll', function() {
      const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
      const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const scrolled = height > 0 ? (winScroll / height) * 100 : 0;
      const bar = document.getElementById('readingProgressBar');
      if (bar) bar.style.width = scrolled + '%';
    });

    // 2. Reading Themes (ivory, sepia, midnight, white)
    function setTheme(themeName) {
      document.body.classList.remove('theme-ivory', 'theme-sepia', 'theme-midnight', 'theme-white');
      document.body.classList.add('theme-' + themeName);

      document.querySelectorAll('.theme-dot').forEach(el => el.classList.remove('active'));
      const activeDot = document.querySelector('.theme-dot.' + themeName);
      if (activeDot) activeDot.classList.add('active');

      try {
        localStorage.setItem('bv_reader_theme', themeName);
      } catch (e) {}
    }

    // 3. Font Size Controls (15px to 24px)
    let currentFontSize = 18;
    function adjustFontSize(delta) {
      currentFontSize = Math.min(24, Math.max(15, currentFontSize + delta));
      applyFontSize();
    }
    function resetFontSize() {
      currentFontSize = 18;
      applyFontSize();
    }
    function applyFontSize() {
      document.documentElement.style.setProperty('--reader-font-size', currentFontSize + 'px');
      try {
        localStorage.setItem('bv_reader_fontsize', currentFontSize);
      } catch (e) {}
    }

    // 4. Font Family Toggle (Serif vs Sans)
    function toggleFontFamily() {
      if (document.body.classList.contains('font-serif')) {
        document.body.classList.remove('font-serif');
        document.body.classList.add('font-sans');
        try { localStorage.setItem('bv_reader_fontfamily', 'sans'); } catch (e) {}
      } else {
        document.body.classList.remove('font-sans');
        document.body.classList.add('font-serif');
        try { localStorage.setItem('bv_reader_fontfamily', 'serif'); } catch (e) {}
      }
    }

    // 5. Chapter Drawer Controls
    function openChapterDrawer() {
      const drawer = document.getElementById('chapterDrawer');
      if (drawer) drawer.style.display = 'flex';
    }
    function closeChapterDrawer(event) {
      const drawer = document.getElementById('chapterDrawer');
      if (drawer) drawer.style.display = 'none';
    }

    // 6. Anti-Plagiarism & Content Protection
    // Block context menu
    document.addEventListener('contextmenu', function(e) {
      e.preventDefault();
      return false;
    });

    // Block keyboard shortcuts (Ctrl+C, Ctrl+U, Ctrl+S, F12)
    document.addEventListener('keydown', function(e) {
      if ((e.ctrlKey || e.metaKey) && (e.key === 'c' || e.key === 'u' || e.key === 's' || e.key === 'p' || e.key === 'a')) {
        e.preventDefault();
        return false;
      }
      if (e.key === 'F12') {
        e.preventDefault();
        return false;
      }
    });

    // 7. Load User Preferences on Start
    document.addEventListener('DOMContentLoaded', function() {
      try {
        const savedTheme = localStorage.getItem('bv_reader_theme');
        if (savedTheme) setTheme(savedTheme);

        const savedFontSize = localStorage.getItem('bv_reader_fontsize');
        if (savedFontSize) {
          currentFontSize = parseInt(savedFontSize);
          applyFontSize();
        }

        const savedFontFamily = localStorage.getItem('bv_reader_fontfamily');
        if (savedFontFamily === 'sans') {
          document.body.classList.remove('font-serif');
          document.body.classList.add('font-sans');
        }
      } catch (e) {}
    });
  </script>
</body>
</html>
