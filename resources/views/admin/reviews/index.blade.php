@extends('layouts.admin')

@section('title', 'Kelola Ulasan & Rating Pembaca — Bianca Veana Admin')

@section('content')
<div class="admin-page-header" style="margin-bottom: 28px;">
  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <div>
      <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: var(--admin-gold); font-weight: 700; display: block; margin-bottom: 4px;">
        <i class="fa-solid fa-star"></i> Komunitas & Ulasan Pembaca
      </span>
      <h2 style="font-family: var(--font-display); font-size: 1.8rem; color: #0F172A; margin: 0; font-weight: 700;">
        Ulasan & Rating Pembeli
      </h2>
      <p style="color: #64748B; font-size: 0.85rem; margin: 4px 0 0;">
        Kelola ulasan pembeli terverifikasi, balas kesan pembaca sebagai Penulis, dan moderasi visibilitas ulasan.
      </p>
    </div>

    <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 8px; padding: 10px 16px; font-size: 0.82rem; color: #1E40AF; display: flex; align-items: center; gap: 8px;">
      <i class="fa-solid fa-shield-check" style="font-size: 1.1rem; color: #2563EB;"></i>
      <span><strong>Proteksi Aktif:</strong> Hanya customer dengan order lunas yang berhak memberi ulasan di toko.</span>
    </div>
  </div>
</div>

@if(session('success'))
  <div style="background: #DCFCE7; border: 1px solid #86EFAC; color: #166534; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem; display: flex; align-items: center; gap: 10px;">
    <i class="fa-solid fa-circle-check" style="color: #16A34A; font-size: 1.1rem;"></i>
    <span>{{ session('success') }}</span>
  </div>
@endif

<!-- STATS CARDS -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 28px;">
  <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <span style="font-size: 0.75rem; color: #64748B; text-transform: uppercase; font-weight: 700;">Total Ulasan</span>
    <div style="font-family: var(--font-display); font-size: 1.9rem; font-weight: 800; color: #0F172A; margin-top: 4px;">
      {{ $stats['total'] }}
    </div>
  </div>

  <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <span style="font-size: 0.75rem; color: #64748B; text-transform: uppercase; font-weight: 700;">Rating Rata-Rata</span>
    <div style="font-family: var(--font-display); font-size: 1.9rem; font-weight: 800; color: #D97706; margin-top: 4px; display: flex; align-items: center; gap: 8px;">
      {{ $stats['avg_rating'] }} <span style="font-size: 1.2rem; color: #F59E0B;"><i class="fa-solid fa-star"></i></span>
    </div>
  </div>

  <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <span style="font-size: 0.75rem; color: #64748B; text-transform: uppercase; font-weight: 700;">Pembeli Terverifikasi</span>
    <div style="font-family: var(--font-display); font-size: 1.9rem; font-weight: 800; color: #16A34A; margin-top: 4px;">
      {{ $stats['verified'] }}
    </div>
  </div>

  <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <span style="font-size: 0.75rem; color: #64748B; text-transform: uppercase; font-weight: 700;">Sudah Dibalas Penulis</span>
    <div style="font-family: var(--font-display); font-size: 1.9rem; font-weight: 800; color: var(--admin-gold); margin-top: 4px;">
      {{ $stats['with_replies'] }}
    </div>
  </div>
</div>

<!-- FILTERS & SEARCH -->
<div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px;">
  <form method="GET" action="{{ route('admin.reviews.index') }}" style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 240px;">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pembeli, judul buku, atau isi ulasan..." style="width: 100%; padding: 9px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem;">
    </div>

    <div>
      <select name="rating" style="padding: 9px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem; color: #334155;">
        <option value="">Semua Rating Bintang</option>
        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Bintang ★★★★★</option>
        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Bintang ★★★★☆</option>
        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Bintang ★★★☆☆</option>
        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Bintang ★★☆☆☆</option>
        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Bintang ★☆☆☆☆</option>
      </select>
    </div>

    <div>
      <select name="status" style="padding: 9px 14px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.85rem; color: #334155;">
        <option value="">Semua Status</option>
        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Ditampilkan (Approved)</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Disembunyikan (Hidden)</option>
      </select>
    </div>

    <button type="submit" class="btn btn-gold" style="padding: 9px 18px; font-size: 0.82rem; font-weight: 700;">
      <i class="fa-solid fa-filter"></i> Filter
    </button>

    @if(request()->hasAny(['search', 'rating', 'status']))
      <a href="{{ route('admin.reviews.index') }}" class="btn" style="background: #F1F5F9; color: #475569; padding: 9px 14px; font-size: 0.82rem; text-decoration: none; border-radius: 6px;">
        Reset
      </a>
    @endif
  </form>
</div>

<!-- REVIEWS LIST -->
<div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
  @if($reviews->count() > 0)
    <div style="display: flex; flex-direction: column;">
      @foreach($reviews as $r)
        <div style="padding: 22px 24px; border-bottom: 1px solid #F1F5F9; display: flex; flex-direction: column; gap: 14px; transition: background 0.15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='#FFFFFF'">
          
          <!-- Top Row: User info, Product info, Rating & Status -->
          <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
            <div>
              <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <strong style="color: #0F172A; font-size: 0.95rem;">{{ $r->reviewer_name }}</strong>
                @if($r->reviewer_email)
                  <span style="font-size: 0.78rem; color: #64748B;">({{ $r->reviewer_email }})</span>
                @endif
                @if($r->is_verified_buyer)
                  <span style="background: #DCFCE7; color: #166534; font-size: 0.68rem; font-weight: 700; padding: 2px 7px; border-radius: 4px; border: 1px solid #BBF7D0;">
                    <i class="fa-solid fa-circle-check"></i> Pembeli Terverifikasi
                  </span>
                @endif
              </div>

              <div style="font-size: 0.78rem; color: #475569; margin-top: 3px;">
                Produk: <strong style="color: #0369A1;">{{ $r->product ? $r->product->title : ($r->book_title ?: 'Buku') }}</strong>
                @if($r->variant_name)
                  <span style="color: #94A3B8;">|</span> Varian: <span style="color: #B45309; font-weight: 600;">{{ $r->variant_name }}</span>
                @endif
                <span style="color: #94A3B8;">|</span> Tanggal: <span>{{ $r->created_at ? $r->created_at->format('d M Y, H:i') : '-' }}</span>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 12px;">
              <!-- Rating Stars -->
              <div style="color: #F59E0B; font-size: 0.88rem; font-weight: 700; background: #FFFBEB; border: 1px solid #FDE68A; padding: 4px 10px; border-radius: 6px;">
                {{ $r->rating }} <i class="fa-solid fa-star"></i>
              </div>

              <!-- Status Badge -->
              @if($r->is_approved)
                <span style="background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 4px;">
                  <i class="fa-solid fa-eye"></i> Tampil Publik
                </span>
              @else
                <span style="background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 4px;">
                  <i class="fa-solid fa-eye-slash"></i> Disembunyikan
                </span>
              @endif
            </div>
          </div>

          <!-- Review Content -->
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 14px 18px;">
            @if($r->review_title)
              <h5 style="margin: 0 0 6px; font-size: 0.92rem; font-weight: 700; color: #0F172A;">
                {{ $r->review_title }}
              </h5>
            @endif
            <p style="margin: 0; font-size: 0.86rem; color: #334155; line-height: 1.6;">
              {!! nl2br(e($r->comment)) !!}
            </p>

            @if($r->photo_url)
              <div style="margin-top: 10px;">
                <a href="{{ asset($r->photo_url) }}" target="_blank">
                  <img src="{{ asset($r->photo_url) }}" alt="Foto Ulasan" style="height: 70px; border-radius: 6px; border: 1px solid #CBD5E1; object-fit: cover;">
                </a>
              </div>
            @endif
          </div>

          <!-- Author Reply Display & Form -->
          @if($r->admin_reply)
            <div style="background: #FFFDF9; border-left: 3.5px solid var(--admin-gold); border-radius: 0 6px 6px 0; padding: 12px 16px;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                <span style="font-size: 0.75rem; font-weight: 700; color: var(--ocean-navy); text-transform: uppercase; letter-spacing: 0.5px;">
                  <i class="fa-solid fa-feather-pointed" style="color: var(--admin-gold);"></i> Balasan Resmi Penulis:
                </span>
                <button type="button" onclick="document.getElementById('reply-form-{{ $r->id }}').style.display='block'" style="background: none; border: none; font-size: 0.72rem; color: #2563EB; cursor: pointer; text-decoration: underline;">
                  Edit Balasan
                </button>
              </div>
              <p style="margin: 0; font-size: 0.82rem; color: #475569; font-style: italic;">
                "{{ $r->admin_reply }}"
              </p>
            </div>
          @endif

          <!-- Hidden / Toggleable Reply Form -->
          <div id="reply-form-{{ $r->id }}" style="display: {{ $r->admin_reply ? 'none' : 'none' }}; background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 8px; padding: 14px 18px;">
            <form action="{{ route('admin.reviews.reply', $r->id) }}" method="POST">
              @csrf
              <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #92400E; margin-bottom: 6px;">
                <i class="fa-solid fa-reply"></i> Tulis Balasan Resmi Penulis (Bianca Veana) untuk {{ $r->reviewer_name }}:
              </label>
              <textarea name="admin_reply" rows="3" required placeholder="Ketik balasan hangat Anda di sini..." style="width: 100%; padding: 10px 12px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.82rem; font-family: inherit; margin-bottom: 8px;">{{ $r->admin_reply }}</textarea>
              <div style="display: flex; justify-content: flex-end; gap: 8px;">
                <button type="button" onclick="document.getElementById('reply-form-{{ $r->id }}').style.display='none'" class="btn" style="background: #F1F5F9; color: #475569; padding: 6px 14px; font-size: 0.75rem; border-radius: 4px;">
                  Batal
                </button>
                <button type="submit" class="btn btn-gold" style="padding: 6px 16px; font-size: 0.75rem; font-weight: 700;">
                  <i class="fa-solid fa-paper-plane"></i> Kirim Balasan
                </button>
              </div>
            </form>
          </div>

          <!-- Bottom Action Buttons -->
          <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 8px;">
            <div style="font-size: 0.75rem; color: #64748B;">
              <i class="fa-regular fa-thumbs-up"></i> {{ $r->helpful_count }} orang terbantu dengan ulasan ini
            </div>

            <div style="display: flex; gap: 8px; align-items: center;">
              @if(!$r->admin_reply)
                <button type="button" onclick="document.getElementById('reply-form-{{ $r->id }}').style.display='block'" class="btn btn-outline-gold" style="padding: 5px 12px; font-size: 0.75rem;">
                  <i class="fa-solid fa-reply"></i> Balas Ulasan
                </button>
              @endif

              <form action="{{ route('admin.reviews.toggle', $r->id) }}" method="POST" style="margin: 0;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn" style="background: {{ $r->is_approved ? '#F1F5F9' : '#DCFCE7' }}; color: {{ $r->is_approved ? '#475569' : '#166534' }}; border: 1px solid {{ $r->is_approved ? '#CBD5E1' : '#86EFAC' }}; padding: 5px 12px; font-size: 0.75rem; border-radius: 6px;">
                  <i class="fa-solid {{ $r->is_approved ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                  {{ $r->is_approved ? 'Sembunyikan' : 'Tampilkan' }}
                </button>
              </form>

              <form action="{{ route('admin.reviews.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan dari {{ $r->reviewer_name }}?');" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #FEE2E2; border: 1px solid #FECACA; color: #DC2626; cursor: pointer; padding: 6px 10px; border-radius: 6px; font-size: 0.75rem;" title="Hapus Ulasan">
                  <i class="fa-regular fa-trash-can"></i>
                </button>
              </form>
            </div>
          </div>

        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div style="padding: 18px 24px;">
      {{ $reviews->links() }}
    </div>
  @else
    <div style="padding: 48px 20px; text-align: center; color: #64748B;">
      <i class="fa-regular fa-star" style="font-size: 2.5rem; color: #CBD5E1; margin-bottom: 12px;"></i>
      <h4 style="margin: 0 0 6px; color: #0F172A; font-size: 1.1rem;">Belum Ada Ulasan Pembaca</h4>
      <p style="margin: 0; font-size: 0.85rem;">
        Ketika pembeli yang telah melunasi pesanan memberikan ulasan, ulasannya akan otomatis muncul di sini.
      </p>
    </div>
  @endif
</div>
@endsection
