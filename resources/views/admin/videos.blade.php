@extends('layouts.admin')

@section('title', 'Manajemen Video Teaser — Admin BIANCA VEANA')

@section('content')
<div class="admin-container">
  
  <!-- Top Header Action Bar -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 20px;">
    <div>
      <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
        <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold);">
          KONTROL KONTEN WEBSITE
        </span>
      </div>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 6px; font-weight: 700; letter-spacing: 0.5px;">
        Manajemen Video Teaser & Trailer
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Kontrol video trailer semesta novel yang ditayangkan pada halaman utama website Bianca Veana.
      </p>
    </div>

    <div style="display: flex; gap: 12px; align-items: center;">
      <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 10px 18px; border-radius: 8px; font-size: 0.82rem; color: #1E293B; display: flex; align-items: center; gap: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
        <i class="fa-solid fa-film" style="color: var(--admin-gold);"></i>
        <span>Total: <strong>{{ $videos->count() }} Video</strong></span>
      </div>

      <a href="{{ route('admin.videos.create') }}" class="btn btn-gold" style="font-size: 0.82rem; padding: 11px 22px; font-weight: 700; box-shadow: 0 4px 12px rgba(198, 161, 107, 0.35);">
        <i class="fa-solid fa-plus-circle"></i> Tambah Video Baru
      </a>
    </div>
  </div>

  @if($videos->isEmpty())
    <!-- Empty State -->
    <div class="admin-card" style="text-align: center; padding: 60px 24px;">
      <div style="width: 72px; height: 72px; border-radius: 50%; background: #F1F5F9; color: var(--admin-gold); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 20px;">
        <i class="fa-solid fa-video"></i>
      </div>
      <h3 style="font-family: var(--font-display); font-size: 1.4rem; color: #0F172A; margin-bottom: 8px;">
        Belum Ada Video Teaser
      </h3>
      <p style="color: #64748B; font-size: 0.9rem; max-width: 500px; margin: 0 auto 24px; line-height: 1.6;">
        Anda belum menambahkan video ke panel admin. Klik tombol di bawah untuk mengunggah file video (.mp4) atau memasukkan link YouTube.
      </p>
      <a href="{{ route('admin.videos.create') }}" class="btn btn-gold" style="font-size: 0.85rem; padding: 12px 28px;">
        <i class="fa-solid fa-plus-circle"></i> Tambah Video Sekarang
      </a>
    </div>
  @else
    <!-- Video Grid Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(420px, 1fr)); gap: 24px;">
      @foreach($videos as $v)
        <div class="admin-card" style="padding: 0; overflow: hidden; border: {{ $v->is_active ? '2px solid var(--admin-gold)' : '1px solid #E2E8F0' }}; position: relative; display: flex; flex-direction: column;">
          
          <!-- Active Badge Ribbon -->
          @if($v->is_active)
            <div style="position: absolute; top: 12px; left: 12px; z-index: 10; background: #16A34A; color: #FFFFFF; font-size: 0.72rem; font-weight: 700; padding: 4px 12px; border-radius: 20px; display: flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
              <i class="fa-solid fa-circle-check"></i> AKTIF DI WEBSITE
            </div>
          @else
            <div style="position: absolute; top: 12px; left: 12px; z-index: 10; background: rgba(15, 23, 42, 0.75); color: #E2E8F0; font-size: 0.72rem; font-weight: 600; padding: 4px 12px; border-radius: 20px; backdrop-filter: blur(4px);">
              <i class="fa-solid fa-eye-slash"></i> Non-Aktif
            </div>
          @endif

          <!-- Video Type Tag -->
          <div style="position: absolute; top: 12px; right: 12px; z-index: 10; background: rgba(15, 23, 42, 0.85); color: var(--admin-gold); font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; border: 1px solid rgba(198, 161, 107, 0.3); backdrop-filter: blur(4px);">
            @if($v->video_type === 'youtube')
              <i class="fa-brands fa-youtube" style="color: #EF4444;"></i> YouTube
            @elseif($v->video_type === 'url')
              <i class="fa-solid fa-link"></i> External URL
            @else
              <i class="fa-solid fa-file-video"></i> File Lokal (.mp4)
            @endif
          </div>

          <!-- Video Player Preview -->
          <div style="background: #000; width: 100%; aspect-ratio: 16 / 9; position: relative; overflow: hidden;">
            @if($v->video_type === 'youtube' && $v->youtube_embed_url)
              <iframe src="{{ $v->youtube_embed_url }}" frameborder="0" allowfullscreen style="width: 100%; height: 100%; border: none;"></iframe>
            @elseif($v->video_path)
              <video controls playsinline preload="metadata" poster="{{ asset($v->thumbnail_path ?: 'images/hero-slide-1.jpg') }}" style="width: 100%; height: 100%; object-fit: contain;">
                <source src="{{ asset($v->video_path) }}" type="video/mp4">
              </video>
            @else
              <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #64748B;">
                <span>File video tidak ditemukan</span>
              </div>
            @endif
          </div>

          <!-- Content Details -->
          <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
              <span style="font-size: 0.7rem; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold);">
                {{ $v->tagline ?: 'OFFICIAL CINEMATIC TRAILER' }}
              </span>
              <h4 style="font-family: var(--font-display); font-size: 1.25rem; color: #0F172A; margin: 4px 0 8px; font-weight: 700;">
                {{ $v->title }}
              </h4>
              <p style="color: #64748B; font-size: 0.85rem; line-height: 1.5; margin-bottom: 16px;">
                {{ Str::limit($v->subtitle, 120, '...') }}
              </p>

              <!-- Badges Info -->
              <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px;">
                <span style="font-size: 0.75rem; background: #F1F5F9; color: #475569; padding: 4px 8px; border-radius: 4px;">
                  <i class="fa-solid fa-circle-check" style="color: var(--admin-gold);"></i> {{ $v->badge_1 ?: '1080p' }}
                </span>
                <span style="font-size: 0.75rem; background: #F1F5F9; color: #475569; padding: 4px 8px; border-radius: 4px;">
                  <i class="fa-solid fa-music" style="color: var(--admin-gold);"></i> {{ $v->badge_2 ?: 'Audio' }}
                </span>
                <span style="font-size: 0.75rem; background: #F1F5F9; color: #475569; padding: 4px 8px; border-radius: 4px;">
                  <i class="fa-solid fa-crown" style="color: var(--admin-gold);"></i> {{ $v->badge_3 ?: 'Universe' }}
                </span>
              </div>
            </div>

            <!-- Action Bar -->
            <div style="border-top: 1px solid #E2E8F0; padding-top: 16px; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
              <div>
                <form action="{{ route('admin.videos.activate', $v->id) }}" method="POST" style="display: inline;">
                  @csrf
                  @if($v->is_active)
                    <button type="submit" class="btn" style="background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; font-size: 0.76rem; padding: 7px 14px; font-weight: 600; cursor: pointer;" title="Klik untuk menonaktifkan video ini dari website">
                      <i class="fa-solid fa-circle-check" style="color: #16A34A;"></i> Aktif di Website
                    </button>
                  @else
                    <button type="submit" class="btn btn-gold" style="font-size: 0.76rem; padding: 7px 14px; font-weight: 600; cursor: pointer;" title="Klik untuk menayangkan video ini di website">
                      <i class="fa-solid fa-bullhorn"></i> Tayangkan di Website
                    </button>
                  @endif
                </form>
              </div>

              <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.videos.edit', $v->id) }}" class="btn" style="background: #F1F5F9; color: #0F172A; border: 1px solid #CBD5E1; font-size: 0.76rem; padding: 7px 12px; font-weight: 600;">
                  <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>

                <form action="{{ route('admin.videos.destroy', $v->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn" style="background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; font-size: 0.76rem; padding: 7px 12px; font-weight: 600;">
                    <i class="fa-solid fa-trash-can"></i> Hapus
                  </button>
                </form>
              </div>
            </div>

          </div>
        </div>
      @endforeach
    </div>
  @endif

</div>
@endsection

