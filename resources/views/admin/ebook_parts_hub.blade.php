@extends('layouts.admin')

@section('title', 'Pusat Kontrol Part E-Book — Admin BIANCA VEANA')

@section('content')
<div class="admin-container">
  <!-- Top Header Bar -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 20px;">
    <div>
      <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
        <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold);">
          SERIALISASI & BAB DIGITAL
        </span>
      </div>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 6px; font-weight: 700;">
        Pusat Kontrol Part E-Book Berkelompok
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Kelola, upload, dan atur harga part e-book berbayar (Part 1, Part 2, Part 3, dst.) yang dikelompokkan secara terstruktur per judul buku.
      </p>
    </div>

    <div style="display: flex; gap: 12px; align-items: center;">
      <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 10px 18px; border-radius: 8px; font-size: 0.82rem; color: #1E293B; display: flex; align-items: center; gap: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
        <i class="fa-solid fa-layer-group" style="color: var(--admin-gold);"></i>
        <span>Total: <strong>{{ $totalParts }} Part E-Book Aktif</strong></span>
      </div>
      
      <button type="button" onclick="openQuickUploadModal()" class="btn btn-gold" style="font-size: 0.82rem; padding: 11px 22px; font-weight: 700; box-shadow: 0 4px 12px rgba(198, 161, 107, 0.35); cursor: pointer;">
        <i class="fa-solid fa-cloud-arrow-up"></i> + Upload Part E-Book Baru
      </button>
    </div>
  </div>

  @if(session('success'))
    <div style="background: #DCFCE7; border: 1px solid #86EFAC; color: #15803D; padding: 14px 18px; border-radius: 6px; margin-bottom: 24px; font-size: 0.88rem;">
      <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
  @endif

  <!-- =========================================================================
       GROUP 1: THE SEVEN NOTONEGORO SERIES (SERIAL DINASTI)
       ========================================================================= -->
  <div style="margin-bottom: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #E2E8F0;">
      <div>
        <h3 style="font-family: var(--font-display); font-size: 1.35rem; color: #0F172A; margin: 0; display: flex; align-items: center; gap: 10px;">
          <i class="fa-solid fa-crown" style="color: var(--champagne-gold);"></i> The Seven Notonegoro Series (Serial Utama)
        </h3>
        <span style="font-size: 0.8rem; color: #64748B;">
          Struktur buku induk kronologis Trah Notonegoro. Setiap judul dapat memiliki beberapa part bab berbayar.
        </span>
      </div>
      <span style="font-size: 0.8rem; background: #EFF6FF; color: #1D4ED8; padding: 4px 12px; border-radius: 6px; font-weight: 700; border: 1px solid #BFDBFE;">
        {{ $notonegoroTitles->count() }} Judul Utama
      </span>
    </div>

    <!-- 4 Structured Title Cards -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
      @foreach($notonegoroTitles as $title)
        @php
          $parts = $title->ebookParts;
        @endphp
        <div class="admin-card" style="padding: 24px; border: 1.5px solid var(--soft-beige); display: flex; flex-direction: column; justify-content: space-between;">
          <div>
            <!-- Card Header: Title & Cover -->
            <div style="display: flex; gap: 16px; align-items: flex-start; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #F1F5F9;">
              <div style="width: 54px; height: 76px; border-radius: 6px; overflow: hidden; background: #0E1A2B; border: 1px solid rgba(198, 161, 107, 0.4); flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <img src="{{ asset($title->cover_image) }}" alt="{{ $title->title }}" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
              <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                  <span style="font-size: 0.72rem; color: var(--champagne-gold); font-weight: 700;">
                    {{ $title->series_number }}
                  </span>
                  <span style="font-size: 0.74rem; background: #EFF6FF; color: #1D4ED8; padding: 2px 8px; border-radius: 4px; font-weight: 700;">
                    {{ $parts->count() }} Part Aktif
                  </span>
                </div>
                <h4 style="font-family: var(--font-display); font-size: 1.25rem; color: #0F172A; margin: 0 0 2px; font-weight: 700;">
                  {{ $title->title }}
                </h4>
                <span style="font-size: 0.78rem; color: #64748B;">{{ $title->series_name }}</span>
              </div>
            </div>

            <!-- List of Parts for this Title -->
            <div style="margin-bottom: 18px;">
              <span style="font-size: 0.72rem; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">
                Daftar Part E-Book (Siap Dibeli Pembeli):
              </span>

              @if($parts->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 8px;">
                  @foreach($parts as $part)
                    <div style="background: #FAF8F5; border: 1px solid var(--soft-beige); border-radius: 6px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center; font-size: 0.82rem;">
                      <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="width: 24px; height: 24px; border-radius: 50%; background: {{ $part->part_number ? '#DBEAFE' : '#FEF3C7' }}; color: {{ $part->part_number ? '#1D4ED8' : '#B45309' }}; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; flex-shrink: 0;">
                          {{ $part->part_number ?: 'F' }}
                        </span>
                        <div>
                          <strong style="color: #0F172A; display: block; line-height: 1.2;">{{ $part->title }}</strong>
                          <span style="font-size: 0.7rem; color: #64748B;">
                            @if($part->digital_file_url)
                              <i class="fa-brands fa-google-drive" style="color: #16A34A;"></i> Terhubung Drive/File
                            @else
                              <i class="fa-solid fa-triangle-exclamation" style="color: #EF4444;"></i> Belum ada link file
                            @endif
                          </span>
                        </div>
                      </div>

                      <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-weight: 700; color: #15803D;">{{ $part->formatted_price }}</span>
                        <form action="{{ route('admin.products.parts.destroy', $part->id) }}" method="POST" onsubmit="return confirm('Hapus part {{ $part->title }}?');" style="margin: 0;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" style="background: none; border: none; color: #DC2626; cursor: pointer; padding: 4px; font-size: 0.75rem;" title="Hapus Part">
                            <i class="fa-regular fa-trash-can"></i>
                          </button>
                        </form>
                      </div>
                    </div>
                  @endforeach
                </div>
              @else
                <div style="background: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 6px; padding: 16px; text-align: center; color: #64748B; font-size: 0.82rem;">
                  Belum ada part untuk judul ini. Klik tombol di bawah untuk menambah Part 1.
                </div>
              @endif
            </div>
          </div>

          <!-- Bottom Action Buttons -->
          <div style="display: flex; gap: 10px; padding-top: 14px; border-top: 1px solid #F1F5F9;">
            <a href="{{ route('admin.products.parts', $title->id) }}" class="btn btn-outline-gold" style="flex: 1; text-align: center; padding: 8px 12px; font-size: 0.78rem;">
              <i class="fa-solid fa-gear"></i> Kelola & Upload Part
            </a>
            <button type="button" onclick="openQuickUploadForTitle({{ $title->id }}, '{{ addslashes($title->title) }}')" class="btn btn-gold" style="padding: 8px 14px; font-size: 0.78rem;">
              <i class="fa-solid fa-plus"></i> + Tambah Part
            </button>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  @if($standaloneTitles->count() > 0)
    <!-- GROUP 2: STANDALONE NOVELS -->
    <div style="margin-bottom: 40px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #E2E8F0;">
        <div>
          <h3 style="font-family: var(--font-display); font-size: 1.35rem; color: #0F172A; margin: 0; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-bookmark" style="color: var(--champagne-gold);"></i> Standalone Novels (Karya Mandiri)
          </h3>
          <span style="font-size: 0.8rem; color: #64748B;">Novel tunggal yang berdiri sendiri di luar semesta Notonegoro.</span>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
        @foreach($standaloneTitles as $title)
          <div class="admin-card" style="padding: 24px;">
            <div style="display: flex; gap: 16px; align-items: center; justify-content: space-between;">
              <div style="display: flex; gap: 14px; align-items: center;">
                <div style="width: 48px; height: 68px; border-radius: 6px; overflow: hidden; background: #0E1A2B;">
                  <img src="{{ asset($title->cover_image) }}" alt="{{ $title->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div>
                  <h4 style="font-family: var(--font-display); font-size: 1.15rem; color: #0F172A; margin: 0 0 2px;">{{ $title->title }}</h4>
                  <span style="font-size: 0.78rem; color: #64748B;">{{ $title->ebookParts->count() }} Part Aktif</span>
                </div>
              </div>
              <a href="{{ route('admin.products.parts', $title->id) }}" class="btn btn-outline-gold" style="padding: 8px 14px; font-size: 0.78rem;">
                <i class="fa-solid fa-gear"></i> Kelola Part E-Book
              </a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif
</div>

<!-- QUICK UPLOAD MODAL -->
<div id="quickUploadModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
  <div style="background: #FFFFFF; border-radius: 10px; max-width: 520px; width: 100%; padding: 28px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3); border: 1px solid var(--champagne-gold);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #E2E8F0;">
      <h3 style="font-family: var(--font-display); font-size: 1.3rem; color: #0F172A; margin: 0; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-cloud-arrow-up" style="color: var(--champagne-gold);"></i> Upload Part E-Book Baru
      </h3>
      <button type="button" onclick="closeQuickUploadModal()" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #64748B;">&times;</button>
    </div>

    <form id="quickUploadForm" action="" method="POST" enctype="multipart/form-data">
      @csrf
      <div style="margin-bottom: 14px;">
        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">Pilih Judul Buku Induk *</label>
        <select id="modal_parent_select" onchange="updateModalTarget(this.value)" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem; background: #FFF;">
          @foreach($allParentTitles as $pt)
            <option value="{{ $pt->id }}" data-title="{{ $pt->title }}">{{ $pt->title }} ({{ $pt->series_name }})</option>
          @endforeach
        </select>
      </div>

      <div style="margin-bottom: 14px;">
        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">Judul Part *</label>
        <input type="text" name="title" id="modal_part_title" required placeholder="Contoh: Mantra — Part 4 (Bab 16 s/d 20)" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">Nomor Part</label>
          <input type="number" name="part_number" id="modal_part_number" placeholder="4" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
        <div>
          <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">Harga Part (Rp) *</label>
          <input type="number" name="price" value="15000" required placeholder="15000" style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
        </div>
      </div>

      <div style="margin-bottom: 14px;">
        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">Upload File PDF Part</label>
        <input type="file" name="ebook_file" accept=".pdf,.epub,.zip" style="width: 100%; padding: 8px; border: 1px dashed #CBD5E1; border-radius: 6px; font-size: 0.82rem; background: #FAF8F5;">
      </div>

      <div style="margin-bottom: 18px;">
        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #1E293B; margin-bottom: 4px;">Atau Tautan Google Drive</label>
        <input type="url" name="digital_file_url" placeholder="https://drive.google.com/file/d/..." style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.88rem;">
      </div>

      <div style="display: flex; gap: 10px;">
        <button type="button" onclick="closeQuickUploadModal()" style="flex: 1; padding: 12px; border: 1px solid #CBD5E1; background: #FFF; border-radius: 6px; font-size: 0.88rem; font-weight: 600; cursor: pointer; color: #475569;">
          Batal
        </button>
        <button type="submit" class="btn btn-gold" style="flex: 2; padding: 12px; font-size: 0.88rem; font-weight: 700; border-radius: 6px;">
          <i class="fa-solid fa-check"></i> Simpan & Publikasikan Part
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  function updateModalTarget(parentId) {
    const form = document.getElementById('quickUploadForm');
    form.action = '/admin/products/' + parentId + '/parts';
    const select = document.getElementById('modal_parent_select');
    const selectedOption = select.options[select.selectedIndex];
    const bookTitle = selectedOption.getAttribute('data-title');
    document.getElementById('modal_part_title').placeholder = 'Contoh: ' + bookTitle + ' — Part 4 (Bab 16 s/d 20)';
  }

  function openQuickUploadModal() {
    const modal = document.getElementById('quickUploadModal');
    modal.style.display = 'flex';
    const firstId = document.getElementById('modal_parent_select').value;
    updateModalTarget(firstId);
  }

  function openQuickUploadForTitle(parentId, title) {
    const modal = document.getElementById('quickUploadModal');
    modal.style.display = 'flex';
    document.getElementById('modal_parent_select').value = parentId;
    updateModalTarget(parentId);
    document.getElementById('modal_part_title').value = title + ' — Part ';
  }

  function closeQuickUploadModal() {
    document.getElementById('quickUploadModal').style.display = 'none';
  }
</script>
@endpush
@endsection

