<!-- ==========================================
     FLOATING LIVE CHAT WIDGET (BIANCA VEANA)
     ========================================== -->
<div id="bv-chat-widget" style="position: fixed; bottom: 28px; right: 28px; z-index: 9999; font-family: var(--font-sans, 'Plus Jakarta Sans', sans-serif);">
  
  <!-- 1. Floating Toggle Button -->
  <button id="bv-chat-toggle-btn" onclick="toggleBvChat()" style="width: 58px; height: 58px; border-radius: 50%; background: var(--ocean-navy, #172B49); color: var(--champagne-gold, #C6A16B); border: 2px solid var(--champagne-gold, #C6A16B); box-shadow: 0 8px 25px rgba(23, 43, 73, 0.45); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.45rem; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); position: relative;" title="Live Chat Customer Care">
    <i id="bv-chat-icon-open" class="fa-solid fa-comment-dots"></i>
    <i id="bv-chat-icon-close" class="fa-solid fa-xmark" style="display: none; font-size: 1.3rem;"></i>
    
    <!-- Unread Badge -->
    <span id="bv-chat-badge" style="display: none; position: absolute; top: -3px; right: -3px; background: #EF4444; color: #FFFFFF; font-size: 0.65rem; font-weight: 800; border-radius: 10px; padding: 2px 6px; border: 2px solid #FFFFFF;">
      0
    </span>
  </button>

  <!-- 2. Chat Window Frame -->
  <div id="bv-chat-window" style="display: none; position: absolute; bottom: 74px; right: 0; width: 360px; height: 500px; max-width: calc(100vw - 36px); background: #FFFFFF; border-radius: 16px; border: 1.5px solid var(--champagne-gold, #C6A16B); box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25); overflow: hidden; flex-direction: column;">
    
    <!-- Header -->
    <div style="background: radial-gradient(circle at 30% 30%, #1c365d 0%, #172B49 100%); color: #FFFFFF; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px solid var(--champagne-gold, #C6A16B); flex-shrink: 0; z-index: 5;">
      <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(198, 161, 107, 0.2); border: 1.5px solid var(--champagne-gold, #C6A16B); display: flex; align-items: center; justify-content: center; color: var(--champagne-gold, #C6A16B); font-size: 1.1rem;">
          <i class="fa-solid fa-headset"></i>
        </div>
        <div>
          <strong style="font-size: 0.92rem; color: #FFFFFF; display: block; letter-spacing: 0.5px;">Customer Care Bianca Veana</strong>
          <span style="font-size: 0.72rem; color: #86EFAC; display: flex; align-items: center; gap: 5px;">
            <span style="width: 7px; height: 7px; border-radius: 50%; background: #22C55E; display: inline-block;"></span>
            Online · Siap Membantu Anda
          </span>
        </div>
      </div>

      <button type="button" onclick="toggleBvChat()" style="background: none; border: none; color: #BAC7D7; font-size: 1.1rem; cursor: pointer; padding: 4px;" title="Tutup Chat">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- Body Area (Customer Guard 'web') -->
    @if(Auth::guard('web')->check())
      <!-- Authenticated Chat Stream -->
      <div id="bv-chat-stream" style="flex: 1 1 0%; min-height: 0; overflow-y: auto; padding: 16px; background: #FAF9F6; display: flex; flex-direction: column; gap: 12px; scrollbar-width: thin; scrollbar-color: #CBD5E1 #FAF9F6;">
        <!-- Welcome Prompt -->
        <div id="bv-welcome-prompt" style="background: #FFFDF9; border: 1px solid rgba(198,161,107,0.3); border-radius: 10px; padding: 12px 14px; font-size: 0.78rem; color: var(--ocean-navy, #172B49); line-height: 1.5; text-align: center; flex-shrink: 0;">
          <i class="fa-solid fa-crown" style="color: var(--champagne-gold, #C6A16B); margin-right: 4px;"></i>
          Halo <strong>{{ Auth::guard('web')->user()->name }}</strong>! Ada yang bisa kami bantu seputar pesanan buku, bab e-book, atau konfirmasi pembayaran?
        </div>
        <!-- Bubbles will be loaded via JS -->
      </div>

      <!-- Footer Input Form -->
      <div style="padding: 12px 14px; background: #FFFFFF; border-top: 1px solid #F0EAE1; flex-shrink: 0; z-index: 5;">
        <form id="bv-chat-form" onsubmit="sendCustomerChatMessage(event)" style="display: flex; gap: 8px; margin: 0; align-items: center;">
          <input type="text" id="bv-chat-input" placeholder="Ketik pesan Anda..." autocomplete="off" style="flex: 1; padding: 10px 14px; border: 1.5px solid #E2E8F0; border-radius: 20px; font-size: 0.85rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--champagne-gold, #C6A16B)';" onblur="this.style.borderColor='#E2E8F0';">
          <button type="submit" style="width: 38px; height: 38px; border-radius: 50%; background: var(--champagne-gold, #C6A16B); color: #FFFFFF; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; transition: transform 0.15s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fa-solid fa-paper-plane"></i>
          </button>
        </form>
      </div>

    @else
      <!-- Guest Locked Screen (Must Login to Chat) -->
      <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 30px 24px; text-align: center; background: #FAF9F6;">
        <div style="width: 58px; height: 58px; border-radius: 50%; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 14px; border: 1px solid #BFDBFE;">
          <i class="fa-solid fa-comments"></i>
        </div>
        <h4 style="font-family: var(--font-serif, serif); font-size: 1.15rem; color: var(--ocean-navy, #172B49); margin: 0 0 8px;">Masuk untuk Memulai Chat</h4>
        <p style="font-size: 0.82rem; color: #64748B; margin: 0 0 20px; line-height: 1.5;">
          Untuk kenyamanan dan menjaga riwayat konsultasi Anda, silakan login ke akun pembaca Anda terlebih dahulu.
        </p>
        <a href="{{ route('login') }}" class="btn btn-gold" style="width: 100%; padding: 10px; font-size: 0.85rem; font-weight: 700; border-radius: 8px; text-align: center; text-decoration: none; display: block; box-sizing: border-box;">
          <i class="fa-solid fa-right-to-bracket"></i> Masuk ke Akun Saya
        </a>
        <div style="margin-top: 14px; font-size: 0.78rem; color: #64748B;">
          Belum punya akun? <a href="{{ route('register') }}" style="color: var(--ocean-navy, #172B49); font-weight: 700; text-decoration: underline;">Daftar di sini</a>
        </div>
      </div>
    @endif

  </div>

</div>

<script>
  let bvChatOpen = false;
  let bvChatInterval = null;

  function toggleBvChat() {
    bvChatOpen = !bvChatOpen;
    const windowEl = document.getElementById('bv-chat-window');
    const iconOpen = document.getElementById('bv-chat-icon-open');
    const iconClose = document.getElementById('bv-chat-icon-close');
    const toggleBtn = document.getElementById('bv-chat-toggle-btn');

    if (bvChatOpen) {
      windowEl.style.display = 'flex';
      iconOpen.style.display = 'none';
      iconClose.style.display = 'block';
      toggleBtn.style.transform = 'scale(0.92)';
      
      @if(Auth::guard('web')->check())
        loadCustomerChatMessages();
        document.getElementById('bv-chat-input').focus();
        
        // Start polling when open
        if (!bvChatInterval) {
          bvChatInterval = setInterval(loadCustomerChatMessages, 3500);
        }
      @endif
    } else {
      windowEl.style.display = 'none';
      iconOpen.style.display = 'block';
      iconClose.style.display = 'none';
      toggleBtn.style.transform = 'scale(1)';
      
      if (bvChatInterval) {
        clearInterval(bvChatInterval);
        bvChatInterval = null;
      }
    }
  }

  @if(Auth::guard('web')->check())
    let lastCustomerMsgCount = 0;
    let lastCustomerMsgId = 0;

    // Check unread count on page load
    document.addEventListener('DOMContentLoaded', function () {
      checkUnreadCustomerCount();
      setInterval(checkUnreadCustomerCount, 8000);
    });

    function checkUnreadCustomerCount() {
      fetch("{{ route('chat.unread_count') }}")
        .then(res => res.json())
        .then(data => {
          const badgeEl = document.getElementById('bv-chat-badge');
          if (data.unread > 0) {
            badgeEl.textContent = data.unread;
            badgeEl.style.display = 'inline-block';
          } else {
            badgeEl.style.display = 'none';
          }
        })
        .catch(err => {});
    }

    function loadCustomerChatMessages(forceScroll = false) {
      fetch("{{ route('chat.messages') }}")
        .then(res => res.json())
        .then(data => {
          if (!data.authenticated) return;
          renderCustomerChatMessages(data.messages, forceScroll);
          checkUnreadCustomerCount();
        })
        .catch(err => console.error("Error loading chat:", err));
    }

    function renderCustomerChatMessages(messages, forceScroll = false) {
      const streamEl = document.getElementById('bv-chat-stream');
      
      // Jika tidak ada pesan baru pada background polling, jangan timpa DOM agar scroll user tidak terganggu
      const latestMsg = messages.length > 0 ? messages[messages.length - 1] : null;
      if (!forceScroll && messages.length === lastCustomerMsgCount && latestMsg && latestMsg.id === lastCustomerMsgId) {
        return;
      }

      lastCustomerMsgCount = messages.length;
      if (latestMsg) {
        lastCustomerMsgId = latestMsg.id;
      }

      const isScrolledToBottom = (streamEl.scrollHeight - streamEl.scrollTop - streamEl.clientHeight) < 60;

      // Preserve welcome notice
      const welcomeNotice = document.getElementById('bv-welcome-prompt');
      let html = welcomeNotice ? welcomeNotice.outerHTML : '';
      
      messages.forEach(m => {
        const isMe = m.sender_type === 'customer';
        
        if (isMe) {
          // Customer bubble on right
          html += `
            <div style="display: flex; justify-content: flex-end; margin-bottom: 4px;">
              <div style="max-width: 80%;">
                <div style="background: var(--ocean-navy, #172B49); color: #FFFFFF; padding: 10px 14px; border-radius: 14px 14px 2px 14px; font-size: 0.82rem; line-height: 1.4; box-shadow: 0 2px 6px rgba(23,43,73,0.15); word-break: break-word;">
                  ${m.message}
                </div>
                <div style="font-size: 0.65rem; color: #94A3B8; text-align: right; margin-top: 2px;">
                  ${m.time}
                </div>
              </div>
            </div>
          `;
        } else {
          // Admin bubble on left
          html += `
            <div style="display: flex; justify-content: flex-start; gap: 8px; margin-bottom: 4px; align-items: flex-end;">
              <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--champagne-gold, #C6A16B); color: #FFFFFF; font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                A
              </div>
              <div style="max-width: 80%;">
                <div style="background: #FFFFFF; color: #0F172A; padding: 10px 14px; border-radius: 14px 14px 14px 2px; font-size: 0.82rem; line-height: 1.4; border: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); word-break: break-word;">
                  ${m.message}
                </div>
                <div style="font-size: 0.65rem; color: #94A3B8; margin-top: 2px;">
                  ${m.time} · Customer Support
                </div>
              </div>
            </div>
          `;
        }
      });

      streamEl.innerHTML = html;
      
      if (forceScroll || isScrolledToBottom || !streamEl.dataset.scrolled) {
        setTimeout(() => {
          streamEl.scrollTop = streamEl.scrollHeight;
          streamEl.dataset.scrolled = '1';
        }, 40);
      }
    }

    function sendCustomerChatMessage(e) {
      e.preventDefault();
      const inputEl = document.getElementById('bv-chat-input');
      const msg = inputEl.value.trim();
      if (!msg) return;

      inputEl.value = '';

      fetch("{{ route('chat.send') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: msg })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          loadCustomerChatMessages(true);
        }
      })
      .catch(err => console.error("Error sending chat:", err));
    }
  @endif
</script>

