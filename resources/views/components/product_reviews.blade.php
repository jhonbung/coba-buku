@props([
  'product',
  'reviews' => collect(),
  'avgRating' => 5.0,
  'totalReviews' => 0,
  'starBreakdown' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
  'userCanReview' => false,
  'userExistingReview' => null,
])

<section class="product-reviews-section" id="reviews-section" style="margin-top: 60px; padding-top: 40px; border-top: 1px solid var(--soft-beige);">
  <div style="margin-bottom: 28px;">
    <span style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 2px; color: var(--champagne-gold); font-weight: 700; display: block; margin-bottom: 6px;">
      <i class="fa-solid fa-feather-pointed"></i> Pembaca & Komunitas
    </span>
    <h3 style="font-family: var(--font-serif); font-size: clamp(1.4rem, 3vw, 1.85rem); color: var(--ocean-navy); margin: 0;">
      Ulasan & Kesan Pembaca Terverifikasi
    </h3>
  </div>

  @if(session('success'))
    <div style="background: #DCFCE7; border: 1px solid #86EFAC; color: #166534; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem; display: flex; align-items: center; gap: 10px;">
      <i class="fa-solid fa-circle-check" style="font-size: 1.1rem; color: #16A34A;"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div style="background: #FEE2E2; border: 1px solid #FECACA; color: #991B1B; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem; display: flex; align-items: center; gap: 10px;">
      <i class="fa-solid fa-triangle-exclamation" style="font-size: 1.1rem; color: #DC2626;"></i>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  <!-- REVIEW SCOREBOARD & WRITE REVIEW CTA -->
  <div class="review-scoreboard-grid" style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 28px; background: #FFFFFF; border: 1px solid var(--soft-beige); border-radius: var(--radius-md); padding: 28px; box-shadow: 0 4px 18px rgba(0,0,0,0.03); margin-bottom: 32px;">
    
    <!-- Left: Score & Breakdown -->
    <div style="display: flex; gap: 32px; align-items: center; flex-wrap: wrap;">
      <div style="text-align: center; min-width: 130px;">
        <div style="font-family: var(--font-display); font-size: 3.5rem; font-weight: 800; color: var(--ocean-navy); line-height: 1;">
          {{ number_format($avgRating, 1) }}
        </div>
        <div style="color: #F59E0B; font-size: 1.15rem; margin: 8px 0 4px;">
          @for($i = 1; $i <= 5; $i++)
            @if($i <= round($avgRating))
              <i class="fa-solid fa-star"></i>
            @else
              <i class="fa-regular fa-star" style="color: #D1D5DB;"></i>
            @endif
          @endfor
        </div>
        <div style="font-size: 0.78rem; color: var(--text-muted);">
          Dari <strong>{{ $totalReviews }}</strong> ulasan
        </div>
        <div style="margin-top: 6px; font-size: 0.72rem; color: #16A34A; font-weight: 700; background: #DCFCE7; padding: 3px 8px; border-radius: 4px; display: inline-block;">
          <i class="fa-solid fa-shield-check"></i> 100% Pembeli Asli
        </div>
      </div>

      <!-- Star distribution bars -->
      <div style="flex: 1; min-width: 200px;">
        @foreach([5, 4, 3, 2, 1] as $star)
          @php
            $count = $starBreakdown[$star] ?? 0;
            $percent = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
          @endphp
          <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px; font-size: 0.78rem;">
            <span style="width: 45px; color: var(--text-muted); font-weight: 600;">{{ $star }} <i class="fa-solid fa-star" style="color: #F59E0B; font-size: 0.7rem;"></i></span>
            <div style="flex: 1; height: 8px; background: #F1F5F9; border-radius: 999px; overflow: hidden;">
              <div style="height: 100%; width: {{ $percent }}%; background: linear-gradient(90deg, #F59E0B 0%, var(--champagne-gold) 100%); border-radius: 999px;"></div>
            </div>
            <span style="width: 35px; text-align: right; color: var(--text-muted); font-size: 0.74rem;">{{ $count }}</span>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Right: Review Eligibility & Action Box -->
    <div style="background: #FAF7F2; border: 1px dashed var(--champagne-gold); border-radius: 10px; padding: 22px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
      @if($userCanReview)
        <i class="fa-solid fa-circle-check" style="font-size: 2rem; color: #16A34A; margin-bottom: 8px;"></i>
        <h4 style="font-family: var(--font-serif); font-size: 1.05rem; color: var(--ocean-navy); margin: 0 0 6px;">
          Anda Adalah Pembeli Terverifikasi!
        </h4>
        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 14px; max-width: 320px;">
          Bagikan pengalaman membaca Anda untuk membantu pembaca lain dalam semesta Bianca Veana.
        </p>
        <button type="button" onclick="toggleReviewForm()" class="btn btn-gold" style="padding: 10px 22px; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(198, 161, 107, 0.35);">
          <i class="fa-solid fa-pen-nib"></i> 
          <span>{{ $userExistingReview ? 'Ubah Ulasan Saya' : 'Tulis Ulasan Novel' }}</span>
        </button>
      @elseif(auth()->guard('web')->check())
        <i class="fa-solid fa-lock" style="font-size: 1.8rem; color: var(--champagne-gold); margin-bottom: 8px;"></i>
        <h4 style="font-family: var(--font-serif); font-size: 1.05rem; color: var(--ocean-navy); margin: 0 0 6px;">
          Ulasan Khusus Pembeli
        </h4>
        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 14px; max-width: 320px; line-height: 1.5;">
          Untuk menjaga kejujuran dan kredibilitas, ulasan hanya dapat diberikan oleh customer yang telah memesan & menyelesaikan pembayaran produk ini.
        </p>
        <a href="#buy-section" class="btn btn-outline-gold" style="padding: 8px 18px; font-size: 0.8rem; font-weight: 600;">
          <i class="fa-solid fa-bag-shopping"></i> Beli Produk Ini Dulu
        </a>
      @else
        <i class="fa-solid fa-shield-halved" style="font-size: 1.8rem; color: var(--champagne-gold); margin-bottom: 8px;"></i>
        <h4 style="font-family: var(--font-serif); font-size: 1.05rem; color: var(--ocean-navy); margin: 0 0 6px;">
          Ulasan Terverifikasi
        </h4>
        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 14px; max-width: 320px; line-height: 1.5;">
          Hanya pembeli yang sudah menyelesaikan pesanan yang dapat menuliskan ulasan. Silakan masuk ke akun Anda.
        </p>
        <a href="{{ route('login') }}" class="btn btn-outline-gold" style="padding: 8px 20px; font-size: 0.82rem; font-weight: 700;">
          <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk ke Akun
        </a>
      @endif
    </div>

  </div>

  <!-- WRITE REVIEW FORM (COLLAPSIBLE) -->
  @if($userCanReview)
    <div id="reviewFormContainer" style="display: {{ $errors->any() ? 'block' : 'none' }}; background: #FFFFFF; border: 2px solid var(--champagne-gold); border-radius: var(--radius-md); padding: 26px; margin-bottom: 34px; box-shadow: 0 8px 24px rgba(198, 161, 107, 0.15);">
      <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--soft-beige); padding-bottom: 14px; margin-bottom: 20px;">
        <h4 style="font-family: var(--font-serif); font-size: 1.18rem; color: var(--ocean-navy); margin: 0; display: flex; align-items: center; gap: 8px;">
          <i class="fa-solid fa-feather" style="color: var(--champagne-gold);"></i> 
          {{ $userExistingReview ? 'Perbarui Ulasan Anda' : 'Tulis Ulasan Pembeli Terverifikasi' }}
        </h4>
        <button type="button" onclick="toggleReviewForm()" style="background: none; border: none; font-size: 1.3rem; color: var(--text-muted); cursor: pointer;">&times;</button>
      </div>

      <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <!-- Star Rating Picker -->
        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 8px;">
            Penilaian Bintang Anda: <span style="color: #DC2626;">*</span>
          </label>
          <div class="star-rating-picker" style="display: inline-flex; flex-direction: row-reverse; gap: 6px;">
            @php $currentRating = old('rating', $userExistingReview->rating ?? 5); @endphp
            @for($s = 5; $s >= 1; $s--)
              <input type="radio" id="star-{{ $s }}" name="rating" value="{{ $s }}" {{ $currentRating == $s ? 'checked' : '' }} style="display: none;">
              <label for="star-{{ $s }}" class="star-label" style="font-size: 1.75rem; color: #D1D5DB; cursor: pointer; transition: color 0.15s;" title="{{ $s }} Bintang">
                <i class="fa-solid fa-star"></i>
              </label>
            @endfor
          </div>
          <span id="starRatingDesc" style="margin-left: 14px; font-size: 0.85rem; font-weight: 700; color: var(--champagne-gold);">Sangat Memuaskan!</span>
        </div>

        <!-- Title of Review -->
        <div style="margin-bottom: 18px;">
          <label for="review_title" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px;">
            Judul Ulasan / Intisari Kesan (Opsional):
          </label>
          <input type="text" id="review_title" name="review_title" value="{{ old('review_title', $userExistingReview->review_title ?? '') }}" placeholder="Contoh: Sangat Menguras Emosi & Kualitas Cetakan Bagus Banget!" style="width: 100%; padding: 11px 14px; border: 1px solid var(--soft-beige); border-radius: 6px; font-size: 0.88rem; font-family: inherit;">
        </div>

        <!-- Review Comment Textarea -->
        <div style="margin-bottom: 18px;">
          <label for="comment" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px;">
            Kesan & Pengalaman Membaca Anda: <span style="color: #DC2626;">*</span>
          </label>
          <textarea id="comment" name="comment" rows="5" required placeholder="Tuliskan pengalaman Anda membaca buku ini, karakter favorit, pengiriman paket, atau kualitas packaging..." style="width: 100%; padding: 12px 14px; border: 1px solid var(--soft-beige); border-radius: 6px; font-size: 0.88rem; font-family: inherit; line-height: 1.6; resize: vertical;">{{ old('comment', $userExistingReview->comment ?? '') }}</textarea>
        </div>

        <!-- Photo Upload -->
        <div style="margin-bottom: 22px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--ocean-navy); margin-bottom: 6px;">
            <i class="fa-solid fa-camera" style="color: var(--champagne-gold);"></i> Foto Unboxing / Buku Asli Anda (Opsional):
          </label>
          <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp" style="font-size: 0.82rem; color: var(--text-muted);">
          <small style="display: block; color: var(--text-muted); font-size: 0.72rem; margin-top: 4px;">
            Format JPG, PNG, atau WEBP. Maksimal 3MB.
          </small>
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 12px; justify-content: flex-end;">
          <button type="button" onclick="toggleReviewForm()" class="btn btn-outline-gold" style="padding: 10px 20px; font-size: 0.85rem;">
            Batal
          </button>
          <button type="submit" class="btn btn-gold" style="padding: 10px 24px; font-size: 0.85rem; font-weight: 700;">
            <i class="fa-solid fa-paper-plane"></i> Terbitkan Ulasan
          </button>
        </div>
      </form>
    </div>
  @endif

  <!-- LIST OF REVIEWS -->
  <div class="reviews-list-container">
    @if($reviews->count() > 0)
      <div style="display: flex; flex-direction: column; gap: 18px;">
        @foreach($reviews as $rev)
          <div class="review-card" style="background: #FFFFFF; border: 1px solid var(--soft-beige); border-radius: var(--radius-md); padding: 22px 26px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            
            <!-- Review Card Header -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
              <div style="display: flex; align-items: center; gap: 12px;">
                <!-- Avatar Circle -->
                <div style="width: 42px; height: 42px; border-radius: 50%; background: linear-gradient(135deg, #0B1526 0%, #1E293B 100%); color: var(--champagne-gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.95rem; border: 1.5px solid var(--champagne-gold);">
                  {{ strtoupper(substr($rev->reviewer_name, 0, 1)) }}
                </div>
                <div>
                  <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                    <strong style="color: var(--ocean-navy); font-size: 0.95rem;">{{ $rev->reviewer_name }}</strong>
                    @if($rev->is_verified_buyer)
                      <span style="background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; font-size: 0.68rem; font-weight: 700; padding: 2px 7px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="fa-solid fa-circle-check" style="color: #16A34A;"></i> Pembeli Terverifikasi
                      </span>
                    @endif
                  </div>
                  @if($rev->variant_name)
                    <span style="font-size: 0.74rem; color: var(--text-muted); display: block; margin-top: 2px;">
                      Pesanan: <span style="color: var(--champagne-gold); font-weight: 600;">{{ $rev->variant_name }}</span>
                    </span>
                  @endif
                </div>
              </div>

              <!-- Rating & Date -->
              <div style="text-align: right;">
                <div style="color: #F59E0B; font-size: 0.85rem; margin-bottom: 3px;">
                  @for($i = 1; $i <= 5; $i++)
                    @if($i <= $rev->rating)
                      <i class="fa-solid fa-star"></i>
                    @else
                      <i class="fa-regular fa-star" style="color: #D1D5DB;"></i>
                    @endif
                  @endfor
                </div>
                <span style="font-size: 0.72rem; color: var(--text-muted);">
                  {{ $rev->formatted_date }}
                </span>
              </div>
            </div>

            <!-- Review Title (if any) -->
            @if($rev->review_title)
              <h5 style="font-size: 0.98rem; font-weight: 700; color: var(--ocean-navy); margin: 0 0 8px; line-height: 1.35;">
                {{ $rev->review_title }}
              </h5>
            @endif

            <!-- Comment Body -->
            <p style="font-size: 0.88rem; color: #334155; line-height: 1.65; margin-bottom: 14px;">
              {!! nl2br(e($rev->comment)) !!}
            </p>

            <!-- Customer Photo (if uploaded) -->
            @if($rev->photo_url)
              <div style="margin-bottom: 16px;">
                <a href="{{ asset($rev->photo_url) }}" target="_blank" title="Lihat Foto Ukuran Penuh">
                  <img src="{{ asset($rev->photo_url) }}" alt="Foto Unboxing oleh {{ $rev->reviewer_name }}" style="max-height: 140px; max-width: 200px; border-radius: 8px; border: 1px solid var(--soft-beige); object-fit: cover; box-shadow: 0 2px 6px rgba(0,0,0,0.06); cursor: pointer;">
                </a>
              </div>
            @endif

            <!-- Author / Admin Reply Box (if any) -->
            @if($rev->admin_reply)
              <div style="background: #FAF7F2; border-left: 3.5px solid var(--champagne-gold); border-radius: 0 8px 8px 0; padding: 14px 18px; margin-bottom: 14px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                  <i class="fa-solid fa-feather-pointed" style="color: var(--champagne-gold); font-size: 0.85rem;"></i>
                  <strong style="font-size: 0.8rem; color: var(--ocean-navy); text-transform: uppercase; letter-spacing: 0.5px;">
                    Balasan Resmi Penulis (Bianca Veana)
                  </strong>
                  @if($rev->admin_replied_at)
                    <span style="font-size: 0.7rem; color: var(--text-muted);">• {{ $rev->admin_replied_at->diffForHumans() }}</span>
                  @endif
                </div>
                <p style="font-size: 0.84rem; color: #475569; line-height: 1.55; margin-bottom: 0; font-style: italic;">
                  "{{ $rev->admin_reply }}"
                </p>
              </div>
            @endif

            <!-- Review Card Footer: Helpful button -->
            <div style="display: flex; justify-content: flex-end; align-items: center; border-top: 1px solid #F1F5F9; padding-top: 10px;">
              <button type="button" onclick="voteHelpful({{ $rev->id }}, this)" style="background: none; border: 1px solid #E2E8F0; padding: 5px 12px; border-radius: 999px; font-size: 0.74rem; color: #64748B; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--champagne-gold)'; this.style.color='var(--ocean-navy)'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.color='#64748B'">
                <i class="fa-regular fa-thumbs-up"></i>
                <span>Membantu (<span class="helpful-count">{{ $rev->helpful_count }}</span>)</span>
              </button>
            </div>

          </div>
        @endforeach
      </div>
    @else
      <div style="background: #FFFFFF; border: 1.5px dashed var(--soft-beige); border-radius: var(--radius-md); padding: 36px 20px; text-align: center; color: var(--text-muted);">
        <i class="fa-regular fa-comment-dots" style="font-size: 2.2rem; color: var(--champagne-gold); margin-bottom: 12px;"></i>
        <h4 style="font-family: var(--font-serif); font-size: 1.1rem; color: var(--ocean-navy); margin-bottom: 6px;">
          Belum Ada Ulasan untuk Produk Ini
        </h4>
        <p style="font-size: 0.82rem; margin-bottom: 0; max-width: 400px; margin-left: auto; margin-right: auto;">
          Jadilah pembeli pertama yang memberikan ulasan & kesan membaca setelah pesanan Anda tiba!
        </p>
      </div>
    @endif
  </div>
</section>

<style>
  /* Star Rating Picker Reverse CSS */
  .star-rating-picker input:checked ~ label,
  .star-rating-picker label:hover,
  .star-rating-picker label:hover ~ label {
    color: #F59E0B !important;
  }
  @media (max-width: 768px) {
    .review-scoreboard-grid {
      grid-template-columns: 1fr !important;
      gap: 20px !important;
      padding: 18px !important;
    }
  }
</style>

<script>
  function toggleReviewForm() {
    const el = document.getElementById('reviewFormContainer');
    if (!el) return;
    if (el.style.display === 'none' || el.style.display === '') {
      el.style.display = 'block';
      el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
      el.style.display = 'none';
    }
  }

  // Interactive description under star picker
  document.addEventListener('DOMContentLoaded', function() {
    const starInputs = document.querySelectorAll('.star-rating-picker input');
    const descEl = document.getElementById('starRatingDesc');
    const descs = {
      '5': '★★★★★ Sangat Memuaskan!',
      '4': '★★★★☆ Bagus & Menarik',
      '3': '★★★☆☆ Cukup Baik',
      '2': '★★☆☆☆ Kurang Memuaskan',
      '1': '★☆☆☆☆ Kecewa'
    };
    starInputs.forEach(input => {
      input.addEventListener('change', function() {
        if (descEl && descs[this.value]) {
          descEl.textContent = descs[this.value];
        }
      });
    });
  });

  function voteHelpful(reviewId, btn) {
    fetch('{{ url("/reviews") }}/' + reviewId + '/helpful', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const countSpan = btn.querySelector('.helpful-count');
        if (countSpan) countSpan.textContent = data.count;
        btn.style.background = '#DCFCE7';
        btn.style.color = '#166534';
        btn.style.borderColor = '#86EFAC';
        btn.disabled = true;
      }
    })
    .catch(err => console.error(err));
  }
</script>

