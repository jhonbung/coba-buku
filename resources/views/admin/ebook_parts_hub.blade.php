@extends('layouts.admin')

@section('title', 'Serial E-Book — Admin BIANCA VEANA')

@section('content')
<div class="admin-container">
  <!-- Top Header Bar -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 20px;">
    <div>
      <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
        <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold);">
          SERIAL E-BOOK & BAB DIGITAL
        </span>
      </div>
      <h2 style="font-family: var(--font-display); font-size: 1.85rem; color: #0F172A; margin: 0 0 6px; font-weight: 700;">
        Manajemen Serial E-Book Berkelompok
      </h2>
      <p style="color: #64748B; font-size: 0.88rem; margin: 0;">
        Kelola, upload naskah Web Reader, serta atur harga part serial e-book berbayar yang dikelompokkan secara terstruktur per judul novel.
      </p>
    </div>

    <div style="display: flex; gap: 12px; align-items: center;">
      <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 10px 18px; border-radius: 8px; font-size: 0.82rem; color: #1E293B; display: flex; align-items: center; gap: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
        <i class="fa-solid fa-book-bookmark" style="color: var(--admin-gold);"></i>
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
                <div style="display: flex; flex-direction: column; gap: 10px;">
                  @foreach($parts as $part)
                    <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 8px; padding: 12px 14px; display: flex; justify-content: space-between; align-items: flex-start; gap: 14px; transition: border-color 0.2s;" onmouseover="this.style.borderColor='var(--champagne-gold)'" onmouseout="this.style.borderColor='#E2E8F0'">
                      <div style="display: flex; align-items: flex-start; gap: 12px; flex: 1; min-width: 0;">
                        <span style="width: 28px; height: 28px; border-radius: 6px; background: {{ $part->part_number ? '#EFF6FF' : '#FEF3C7' }}; color: {{ $part->part_number ? '#1D4ED8' : '#B45309' }}; border: 1px solid {{ $part->part_number ? '#BFDBFE' : '#FDE68A' }}; display: flex; align-items: center; justify-content: center; font-size: 0.72rem; font-weight: 800; flex-shrink: 0; margin-top: 1px;">
                          {{ $part->part_number ? 'P' . $part->part_number : 'FULL' }}
                        </span>
                        <div style="flex: 1; min-width: 0;">
                          <div style="display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap;">
                            <strong style="color: #0F172A; font-size: 0.88rem; font-weight: 700; line-height: 1.2;">{{ $part->title }}</strong>
                            <span style="font-size: 0.7rem;">
                              @if($part->digital_file_url)
                                <span style="color: #16A34A; font-weight: 600;"><i class="fa-brands fa-google-drive"></i> File Siap</span>
                              @else
                                <span style="color: #DC2626; font-weight: 600;"><i class="fa-solid fa-triangle-exclamation"></i> Tanpa File</span>
                              @endif
                            </span>
                          </div>

                          @if($part->synopsis)
                            <div style="font-size: 0.75rem; color: #475569; margin-top: 5px; line-height: 1.45; background: #F8FAFC; border-left: 2.5px solid var(--champagne-gold); padding: 5px 9px; border-radius: 0 4px 4px 0;">
                              <span style="color: #0369A1; font-weight: 700; font-size: 0.68rem; text-transform: uppercase;"><i class="fa-solid fa-feather-pointed"></i> Sinopsis:</span>
                              {{ Str::limit($part->synopsis, 95) }}
                            </div>
                          @endif
                        </div>
                      </div>

                      <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0;">
                        <span style="font-weight: 800; color: #15803D; font-size: 0.88rem;">{{ $part->formatted_price }}</span>
                        <div style="display: flex; align-items: center; gap: 5px;">
                          <a href="{{ route('reader.show', $part->slug) }}" target="_blank" style="background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 3px;" title="Preview Web Novel Reader">
                            <i class="fa-solid fa-book-open"></i> Baca
                          </a>
                          <a href="{{ route('admin.products.edit', $part->id) }}" style="background: #EEF2FF; color: #4338CA; border: 1px solid #C7D2FE; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 3px;" title="Edit Sinopsis, Teks Cerita & Detail Part">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                          </a>
                          <form action="{{ route('admin.products.parts.destroy', $part->id) }}" method="POST" onsubmit="return confirm('Hapus part {{ $part->title }}?');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #FEE2E2; border: 1px solid #FECACA; color: #DC2626; cursor: pointer; padding: 3px 6px; border-radius: 4px; font-size: 0.7rem;" title="Hapus Part">
                              <i class="fa-regular fa-trash-can"></i>
                            </button>
                          </form>
                        </div>
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
<div id="quickUploadModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(5px); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
  <div style="background: #FFFFFF; border-radius: 14px; max-width: 560px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 28px 32px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1px solid #E2E8F0; position: relative;">
    
    <!-- Modal Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid #F1F5F9;">
      <h3 style="font-family: var(--font-display); font-size: 1.35rem; color: #0F172A; margin: 0; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-cloud-arrow-up" style="color: var(--champagne-gold);"></i> Upload Part E-Book Baru
      </h3>
      <button type="button" onclick="closeQuickUploadModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; cursor: pointer; color: #94A3B8; padding: 0 4px;" title="Tutup">&times;</button>
    </div>

    <form id="quickUploadForm" action="" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Field 1: Pilih Judul Buku Induk -->
      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
          Pilih Judul Buku Induk *
        </label>
        <select id="modal_parent_select" onchange="updateModalTarget(this.value)" style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; background: #FFF; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)'" onblur="this.style.borderColor='#CBD5E1'">
          @foreach($allParentTitles as $pt)
            <option value="{{ $pt->id }}" data-title="{{ $pt->title }}">{{ $pt->title }} ({{ $pt->series_name }})</option>
          @endforeach
        </select>
      </div>

      <!-- Field 2: Judul Part -->
      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
          Judul Part *
        </label>
        <input type="text" name="title" id="modal_part_title" required placeholder="Contoh: Mantra — Part 4 (Bab 16 s/d 20)" style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)'" onblur="this.style.borderColor='#CBD5E1'">
      </div>

      <!-- Field 3: Sinopsis Part (Tepat di bawah Judul) -->
      <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
          <i class="fa-solid fa-feather-pointed" style="color: var(--champagne-gold);"></i> Sinopsis Part / Ringkasan Bab
        </label>
        <textarea name="synopsis" id="modal_part_synopsis" rows="3" placeholder="Tuliskan sinopsis singkat atau ringkasan cerita pada part bab ini agar terbaca oleh customer..." style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box; line-height: 1.55; font-family: inherit; resize: vertical; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)'" onblur="this.style.borderColor='#CBD5E1'"></textarea>
        <span style="font-size: 0.72rem; color: #64748B; margin-top: 4px; display: block;">
          *Sinopsis ini akan langsung ditampilkan kepada pembeli di halaman e-book customer.
        </span>
      </div>

      <!-- Field 4: Nomor Part & Harga Part (2 Kolom) -->
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
            Nomor Part (Angka)
          </label>
          <input type="number" name="part_number" id="modal_part_number" placeholder="4" style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)'" onblur="this.style.borderColor='#CBD5E1'">
          <span style="font-size: 0.7rem; color: #94A3B8; margin-top: 2px; display: block;">Kosongkan jika edisi Full Novel.</span>
        </div>
        <div>
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
            Harga Part (Rp) *
          </label>
          <input type="number" name="price" value="15000" required placeholder="15000" style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)'" onblur="this.style.borderColor='#CBD5E1'">
        </div>
      </div>

      <!-- Field 5: Tautan Google Drive Resmi -->
      <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 10px; padding: 16px; margin-bottom: 16px;">
        <label style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
          <i class="fa-brands fa-google-drive" style="color: #2563EB; font-size: 1rem;"></i> Tautan Google Drive Resmi Part E-Book
        </label>
        <div style="position: relative;">
          <input type="url" name="digital_file_url" placeholder="https://drive.google.com/file/d/... atau https://drive.google.com/drive/folders/..." style="width: 100%; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 6px; font-size: 0.86rem; box-sizing: border-box; background: #FFFFFF; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)'" onblur="this.style.borderColor='#CBD5E1'">
        </div>
        <span style="font-size: 0.72rem; color: #64748B; margin-top: 5px; display: block;">
          *Tautan Google Drive ini akan otomatis diberikan kepada pembeli setelah pembayaran pesanan terkonfirmasi lunas.
        </span>
      </div>

      <!-- Field 6: Isi Naskah Cerita Bab (Untuk Pembaca Web Novel / Online Reader) -->
      <div style="margin-bottom: 22px;">
        <label style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; font-weight: 700; color: #1E293B; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">
          <span style="display: flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-book-open-reader" style="color: var(--champagne-gold);"></i> Isi Naskah Cerita Bab (Web Reader)
          </span>
          <span style="font-size: 0.72rem; color: #2563EB; font-weight: 600; text-transform: none;">
            ✨ Pembeli Dapat Membaca Langsung di Web
          </span>
        </label>
        <textarea name="content" id="modal_part_content" rows="6" placeholder="Ketik atau tempel teks naskah cerita bab ini di sini... Pembeli yang telah terkonfirmasi pembayarannya akan dapat langsung membaca bab ini di halaman Web Reader yang nyaman layaknya membaca novel sungguhan." style="width: 100%; padding: 12px 14px; border: 1.5px solid #CBD5E1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box; font-family: inherit; resize: vertical; line-height: 1.6; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold)'" onblur="this.style.borderColor='#CBD5E1'"></textarea>
        <span style="font-size: 0.72rem; color: #64748B; margin-top: 4px; display: block;">
          *Mendukung paragraf dan dialog. Format teks akan ditata rapi secara otomatis di Web Novel Reader dengan proteksi anti copy-paste.
        </span>
      </div>

      <!-- Modal Action Buttons -->
      <div style="display: flex; gap: 10px; justify-content: flex-end;">
        <button type="button" onclick="closeQuickUploadModal()" style="padding: 10px 18px; border: 1px solid #CBD5E1; background: #F1F5F9; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; color: #475569;">
          Batal
        </button>
        <button type="submit" class="btn btn-gold" style="padding: 10px 24px; font-size: 0.85rem; font-weight: 700; border-radius: 8px; cursor: pointer; box-shadow: 0 4px 12px rgba(198, 161, 107, 0.35);">
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
    document.getElementById('modal_part_synopsis').value = '';
    const contentEl = document.getElementById('modal_part_content');
    if (contentEl) contentEl.value = '';
  }

  function openQuickUploadForTitle(parentId, title) {
    const modal = document.getElementById('quickUploadModal');
    modal.style.display = 'flex';
    document.getElementById('modal_parent_select').value = parentId;
    updateModalTarget(parentId);
    document.getElementById('modal_part_title').value = title + ' — Part ';
    document.getElementById('modal_part_synopsis').value = '';
  }

  function closeQuickUploadModal() {
    document.getElementById('quickUploadModal').style.display = 'none';
  }
</script>
@endpush
@endsection

