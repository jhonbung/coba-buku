@extends('layouts.admin')

@section('title', 'Edit Video Teaser — Admin BIANCA VEANA')

@section('content')
<div class="admin-container" style="max-width: 900px;">

  <!-- Header Breadcrumb & Actions -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
      <a href="{{ route('admin.videos') }}" style="color: #64748B; text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Video
      </a>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0; font-weight: 700;">
        Edit Video Teaser
      </h2>
    </div>
  </div>

  @if(isset($errors) && $errors->any())
    <div style="background: #FEE2E2; border: 1px solid #FECACA; color: #991B1B; padding: 14px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
      <ul style="margin: 0; padding-left: 20px;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- PREVIEW VIDEO SAAT INI -->
    <div class="admin-card" style="margin-bottom: 24px; padding: 0; overflow: hidden;">
      <div style="padding: 16px 20px; background: #F8FAFC; border-bottom: 1px solid #E2E8F0; font-weight: 700; font-size: 0.9rem; color: #1E293B; display: flex; align-items: center; justify-content: space-between;">
        <span><i class="fa-solid fa-eye" style="color: var(--admin-gold);"></i> Preview Video Saat Ini</span>
        <span style="font-size: 0.75rem; background: rgba(198, 161, 107, 0.2); color: var(--admin-gold); padding: 3px 8px; border-radius: 4px; font-weight: 700;">
          Tipe: {{ strtoupper($video->video_type) }}
        </span>
      </div>
      <div style="background: #000; width: 100%; aspect-ratio: 16 / 9; max-height: 380px;">
        @if($video->video_type === 'youtube' && $video->youtube_embed_url)
          <iframe src="{{ $video->youtube_embed_url }}" frameborder="0" allowfullscreen style="width: 100%; height: 100%; border: none;"></iframe>
        @elseif($video->video_path)
          <video controls playsinline preload="metadata" poster="{{ asset($video->thumbnail_path ?: 'images/hero-slide-1.jpg') }}" style="width: 100%; height: 100%; object-fit: contain;">
            <source src="{{ asset($video->video_path) }}" type="video/mp4">
          </video>
        @else
          <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #94A3B8;">
            Belum ada media video terpasang
          </div>
        @endif
      </div>
    </div>

    <!-- SECTION 1: INFORMASI VIDEO -->
    <div class="admin-card" style="margin-bottom: 24px;">
      <h3 style="font-family: var(--font-display); font-size: 1.25rem; color: #0F172A; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-info-circle" style="color: var(--admin-gold);"></i> 1. Informasi Judul & Teks Video
      </h3>

      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #1E293B; margin-bottom: 6px;">Judul Video <span style="color: #DC2626;">*</span></label>
        <input type="text" name="title" value="{{ old('title', $video->title) }}" required style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.92rem;">
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #1E293B; margin-bottom: 6px;">Tagline / Label Atas</label>
          <input type="text" name="tagline" value="{{ old('tagline', $video->tagline) }}" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.92rem;">
        </div>
        <div>
          <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #1E293B; margin-bottom: 6px;">Teks Tombol Aksi (CTA)</label>
          <input type="text" name="cta_text" value="{{ old('cta_text', $video->cta_text) }}" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.92rem;">
        </div>
      </div>

      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #1E293B; margin-bottom: 6px;">Deskripsi / Subtitle</label>
        <textarea name="subtitle" rows="3" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.92rem; font-family: inherit;">{{ old('subtitle', $video->subtitle) }}</textarea>
      </div>

      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #1E293B; margin-bottom: 6px;">Link Tujuan Tombol Aksi</label>
        <input type="text" name="cta_link" value="{{ old('cta_link', $video->cta_link) }}" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.92rem;">
      </div>
    </div>

    <!-- SECTION 2: SUMBER VIDEO -->
    <div class="admin-card" style="margin-bottom: 24px;">
      <h3 style="font-family: var(--font-display); font-size: 1.25rem; color: #0F172A; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-play" style="color: var(--admin-gold);"></i> 2. Ganti / Perbarui Sumber Video
      </h3>

      <div style="display: flex; gap: 16px; margin-bottom: 20px; flex-wrap: wrap;">
        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 10px 18px; border: 2px solid #E2E8F0; border-radius: 8px; font-weight: 600; font-size: 0.88rem;" class="type-selector" id="lbl-file">
          <input type="radio" name="video_type" value="file" {{ $video->video_type === 'file' ? 'checked' : '' }} onchange="toggleVideoSource('file')">
          <i class="fa-solid fa-file-video" style="color: var(--admin-gold);"></i> Upload File Video (.mp4)
        </label>

        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 10px 18px; border: 2px solid #E2E8F0; border-radius: 8px; font-weight: 600; font-size: 0.88rem;" class="type-selector" id="lbl-youtube">
          <input type="radio" name="video_type" value="youtube" {{ $video->video_type === 'youtube' ? 'checked' : '' }} onchange="toggleVideoSource('youtube')">
          <i class="fa-brands fa-youtube" style="color: #EF4444;"></i> Link YouTube
        </label>

        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 10px 18px; border: 2px solid #E2E8F0; border-radius: 8px; font-weight: 600; font-size: 0.88rem;" class="type-selector" id="lbl-url">
          <input type="radio" name="video_type" value="url" {{ $video->video_type === 'url' ? 'checked' : '' }} onchange="toggleVideoSource('url')">
          <i class="fa-solid fa-link" style="color: #3B82F6;"></i> Link Video External (URL)
        </label>
      </div>

      <!-- Option 1: File Upload -->
      <div id="box-file" style="background: #F8FAFC; border: 2px dashed #CBD5E1; border-radius: 8px; padding: 24px; text-align: center; margin-bottom: 16px;">
        <div style="font-size: 2.2rem; color: var(--admin-gold); margin-bottom: 10px;">
          <i class="fa-solid fa-cloud-arrow-up"></i>
        </div>
        <h4 style="font-size: 1rem; color: #1E293B; margin-bottom: 6px;">Ganti File Video (.mp4, .webm, .mov)</h4>
        <p style="color: #64748B; font-size: 0.82rem; margin-bottom: 14px;">Kosongkan jika tidak ingin mengubah file video yang sudah ada.</p>
        <input type="file" name="video_file" id="video_file" accept="video/mp4,video/webm,video/ogg,video/quicktime" style="display: none;" onchange="showFileName(this)">
        <button type="button" class="btn btn-gold" onclick="document.getElementById('video_file').click()" style="font-size: 0.85rem; padding: 9px 20px;">
          <i class="fa-solid fa-folder-open"></i> Pilih File Video Baru
        </button>
        <div id="file-name-display" style="margin-top: 10px; font-weight: 600; font-size: 0.85rem; color: #16A34A;"></div>
        @if($video->video_path)
          <div style="margin-top: 10px; font-size: 0.78rem; color: #64748B;">
            Path file saat ini: <code>{{ $video->video_path }}</code>
          </div>
        @endif
      </div>

      <!-- Option 2: YouTube URL -->
      <div id="box-youtube" style="display: none; margin-bottom: 16px;">
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #1E293B; margin-bottom: 6px;">URL / Link Video YouTube</label>
        <input type="url" name="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/..." style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.92rem;">
      </div>

      <!-- Option 3: External URL -->
      <div id="box-url" style="display: none; margin-bottom: 16px;">
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #1E293B; margin-bottom: 6px;">Direct Video URL (MP4)</label>
        <input type="url" name="video_url" value="{{ old('video_url', $video->video_type === 'url' ? $video->video_path : '') }}" placeholder="https://example.com/videos/trailer.mp4" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.92rem;">
      </div>
    </div>

    <!-- SECTION 3: THUMBNAIL & BADGES -->
    <div class="admin-card" style="margin-bottom: 24px;">
      <h3 style="font-family: var(--font-display); font-size: 1.25rem; color: #0F172A; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-image" style="color: var(--admin-gold);"></i> 3. Poster Thumbnail & Badge Keunggulan
      </h3>

      <div style="margin-bottom: 18px;">
        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #1E293B; margin-bottom: 6px;">Gambar Poster / Thumbnail</label>
        <input type="file" name="thumbnail_file" accept="image/*" style="width: 100%; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem; background: #FFFFFF;">
        @if($video->thumbnail_path)
          <div style="margin-top: 6px; font-size: 0.78rem; color: #64748B;">
            Poster saat ini: <code>{{ $video->thumbnail_path }}</code>
          </div>
        @endif
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px;">
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">Badge 1</label>
          <input type="text" name="badge_1" value="{{ old('badge_1', $video->badge_1) }}" style="width: 100%; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem;">
        </div>
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">Badge 2</label>
          <input type="text" name="badge_2" value="{{ old('badge_2', $video->badge_2) }}" style="width: 100%; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem;">
        </div>
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">Badge 3</label>
          <input type="text" name="badge_3" value="{{ old('badge_3', $video->badge_3) }}" style="width: 100%; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem;">
        </div>
      </div>
    </div>

    <!-- SECTION 4: STATUS & SUBMIT -->
    <div class="admin-card" style="margin-bottom: 30px;">
      <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
          <input type="checkbox" name="is_active" value="1" {{ $video->is_active ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--admin-gold);">
          <div>
            <span style="font-weight: 700; font-size: 0.92rem; color: #0F172A;">Jadikan video aktif di halaman utama</span>
            <p style="color: #64748B; font-size: 0.78rem; margin: 0;">Video ini akan langsung menggantikan video sebelumnya dan tayang di website.</p>
          </div>
        </label>

        <div style="display: flex; gap: 10px;">
          <a href="{{ route('admin.videos') }}" class="btn" style="background: #F1F5F9; color: #0F172A; border: 1px solid #CBD5E1; padding: 10px 20px; font-size: 0.85rem; font-weight: 600;">
            Batal
          </a>
          <button type="submit" class="btn btn-gold" style="padding: 10px 28px; font-size: 0.88rem; font-weight: 700;">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
          </button>
        </div>
      </div>
    </div>

  </form>
</div>

<script>
  function toggleVideoSource(type) {
    document.getElementById('box-file').style.display = (type === 'file') ? 'block' : 'none';
    document.getElementById('box-youtube').style.display = (type === 'youtube') ? 'block' : 'none';
    document.getElementById('box-url').style.display = (type === 'url') ? 'block' : 'none';

    document.querySelectorAll('.type-selector').forEach(el => el.style.borderColor = '#E2E8F0');
    if (type === 'file') document.getElementById('lbl-file').style.borderColor = 'var(--admin-gold)';
    if (type === 'youtube') document.getElementById('lbl-youtube').style.borderColor = 'var(--admin-gold)';
    if (type === 'url') document.getElementById('lbl-url').style.borderColor = 'var(--admin-gold)';
  }

  function showFileName(input) {
    const display = document.getElementById('file-name-display');
    if (input.files && input.files[0]) {
      display.innerHTML = '<i class="fa-solid fa-circle-check"></i> File terpilih: ' + input.files[0].name + ' (' + (input.files[0].size / (1024*1024)).toFixed(2) + ' MB)';
    } else {
      display.innerHTML = '';
    }
  }

  // Initial call with current type
  toggleVideoSource('{{ $video->video_type }}');

  document.querySelector('form').addEventListener('submit', function() {
    const btn = this.querySelector('button[type="submit"]');
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan & Mengunggah... Harap Tunggu';
    }
  });
</script>
@endsection
