@extends('layouts.admin')

@section('title', 'Live Chat Support — Admin BIANCA VEANA')

@push('styles')
<style>
  #messagesStream, #conversationsList {
    scrollbar-width: thin;
    scrollbar-color: #CBD5E1 #F8FAFC;
  }
  #messagesStream::-webkit-scrollbar, #conversationsList::-webkit-scrollbar {
    width: 7px;
  }
  #messagesStream::-webkit-scrollbar-track, #conversationsList::-webkit-scrollbar-track {
    background: #F1F5F9;
  }
  #messagesStream::-webkit-scrollbar-thumb, #conversationsList::-webkit-scrollbar-thumb {
    background: #CBD5E1;
    border-radius: 6px;
  }
  #messagesStream::-webkit-scrollbar-thumb:hover, #conversationsList::-webkit-scrollbar-thumb:hover {
    background: #94A3B8;
  }
</style>
@endpush

@section('content')
<div class="admin-container" style="max-width: 1440px;">
  
  <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
    <div>
      <span style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; color: var(--admin-gold); display: block; margin-bottom: 4px;">
        REAL-TIME CUSTOMER CARE
      </span>
      <h2 style="font-family: var(--font-display); font-size: 1.8rem; color: #0F172A; margin: 0; font-weight: 700;">
        Pusat Pesan & Live Chat Pembaca
      </h2>
    </div>
    <span style="background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; font-size: 0.78rem; font-weight: 700; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
      <span style="width: 8px; height: 8px; border-radius: 50%; background: #10B981; display: inline-block;"></span>
      Status Layanan: Live & Siap Membalas
    </span>
  </div>

  <!-- Live Chat Layout Frame (Split Screen with Fixed Height and Contained Overflow) -->
  <div class="admin-card" style="height: 680px; max-height: calc(100vh - 180px); min-height: 520px; display: grid; grid-template-columns: 340px 1fr; overflow: hidden;">
    
    <!-- LEFT PANEL: Conversation List -->
    <div style="border-right: 1px solid var(--admin-border-subtle); display: flex; flex-direction: column; background: #FFFFFF; height: 100%; min-height: 0; overflow: hidden;">
      
      <!-- Search Customer in Chat -->
      <div style="padding: 16px; border-bottom: 1px solid var(--admin-border-subtle); background: #FAFBFD; flex-shrink: 0;">
        <div style="position: relative;">
          <input type="text" id="chatSearchInput" placeholder="Cari nama atau email..." style="width: 100%; padding: 8px 12px 8px 34px; border: 1px solid var(--admin-border-subtle); border-radius: 6px; font-size: 0.82rem; box-sizing: border-box;" onkeyup="filterConversations()">
          <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 11px; color: #94A3B8; font-size: 0.8rem;"></i>
        </div>
      </div>

      <!-- Conversations Scrollable List -->
      <div id="conversationsList" style="flex: 1 1 0%; min-height: 0; overflow-y: auto;">
        <div style="padding: 30px 20px; text-align: center; color: #94A3B8; font-size: 0.82rem;">
          <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 1.2rem; margin-bottom: 8px;"></i>
          <div>Memuat percakapan...</div>
        </div>
      </div>

    </div>

    <!-- RIGHT PANEL: Active Chat Room -->
    <div id="chatRoomArea" style="display: flex; flex-direction: column; background: #F8FAFC; height: 100%; min-height: 0; overflow: hidden;">
      
      <!-- Empty State (No Chat Selected) -->
      <div id="noChatSelected" style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 40px; color: #64748B;">
        <div style="width: 70px; height: 70px; border-radius: 50%; background: #EEF2FF; color: #4F46E5; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 16px;">
          <i class="fa-solid fa-comments"></i>
        </div>
        <h3 style="font-family: var(--font-display); font-size: 1.4rem; color: #0F172A; margin: 0 0 6px;">Pilih Percakapan Customer</h3>
        <p style="font-size: 0.85rem; max-width: 400px; margin: 0;">
          Klik salah satu customer pada daftar di sisi kiri untuk membaca riwayat obrolan dan mengirim balasan pesan secara instan.
        </p>
      </div>

      <!-- Active Chat Room Content (Contained inside grid item) -->
      <div id="activeChatContainer" style="display: none; flex-direction: column; height: 100%; min-height: 0; overflow: hidden;">
        
        <!-- Chat Header (Fixed at top of room) -->
        <div style="padding: 14px 24px; border-bottom: 1px solid var(--admin-border-subtle); background: #FFFFFF; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; z-index: 5;">
          <div style="display: flex; align-items: center; gap: 14px;">
            <div id="activeUserAvatar" style="width: 44px; height: 44px; border-radius: 50%; background: #0B1424; color: var(--admin-gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem; border: 1.5px solid var(--admin-gold);">
              U
            </div>
            <div>
              <h4 id="activeUserName" style="margin: 0; font-size: 1.05rem; color: #0F172A; font-weight: 700;">Nama Customer</h4>
              <div style="display: flex; gap: 10px; font-size: 0.78rem; color: #64748B; margin-top: 2px;">
                <span id="activeUserEmail">email@example.com</span>
                <span>•</span>
                <span id="activeUserPhone">08123456789</span>
              </div>
            </div>
          </div>

          <!-- Customer Quick Info Badges -->
          <div style="display: flex; align-items: center; gap: 10px;">
            <span id="activeUserOrders" style="background: #EEF2FF; color: #4338CA; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">
              0 Pesanan
            </span>
            <span id="activeUserSpent" style="background: #ECFDF5; color: #047857; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">
              Rp 0
            </span>
            <a id="activeUserWaBtn" href="#" target="_blank" class="btn" style="padding: 6px 12px; font-size: 0.78rem; background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; border-radius: 6px; text-decoration: none; font-weight: 600;" title="Buka WhatsApp">
              <i class="fa-brands fa-whatsapp"></i> Chat WA
            </a>
          </div>
        </div>

        <!-- Chat Message Bubbles Stream (Properly Scrollable with min-height: 0) -->
        <div id="messagesStream" style="flex: 1 1 0%; min-height: 0; overflow-y: auto; padding: 24px; display: flex; flex-direction: column; gap: 14px;">
          <!-- Bubbles injected by JS -->
        </div>

        <!-- Chat Reply Input Box (Fixed at bottom of room) -->
        <div style="padding: 16px 24px; border-top: 1px solid var(--admin-border-subtle); background: #FFFFFF; flex-shrink: 0; z-index: 5;">
          <form id="adminReplyForm" onsubmit="sendAdminMessage(event)" style="display: flex; gap: 12px; align-items: center; margin: 0;">
            <input type="hidden" id="activeChatUserId" value="">
            <input type="text" id="adminReplyInput" placeholder="Ketik balasan pesan untuk customer ini... (Tekan Enter untuk kirim)" autocomplete="off" style="flex: 1; padding: 12px 16px; border: 1.5px solid var(--admin-border-subtle); border-radius: 8px; font-size: 0.9rem; box-sizing: border-box; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--admin-gold)';" onblur="this.style.borderColor='var(--admin-border-subtle)';">
            <button type="submit" class="btn btn-gold" style="padding: 12px 22px; font-size: 0.9rem; font-weight: 700; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px;">
              <span>Kirim</span>
              <i class="fa-solid fa-paper-plane"></i>
            </button>
          </form>
        </div>

      </div>

    </div>

  </div>

</div>

@push('scripts')
<script>
  let currentUserId = {{ $selectedUserId ? (int)$selectedUserId : 'null' }};
  let conversationsData = [];
  let pollInterval = null;
  let lastLoadedMessageCount = 0;
  let lastLoadedMessageId = 0;

  // Initial Load
  document.addEventListener('DOMContentLoaded', function () {
    loadConversations();
    // Poll conversations and active messages every 3.5s
    pollInterval = setInterval(function () {
      loadConversations(true);
      if (currentUserId) {
        loadMessages(currentUserId, true);
      }
    }, 3500);
  });

  // Load conversation list from server
  function loadConversations(isBackground = false) {
    fetch("{{ route('admin.chat.conversations') }}")
      .then(res => res.json())
      .then(data => {
        conversationsData = data.conversations;
        renderConversationsList();
        
        // Auto open selected user if requested via query param
        if (currentUserId && !isBackground) {
          selectConversation(currentUserId);
        }
      })
      .catch(err => console.error("Error loading chat conversations:", err));
  }

  // Render conversations list in left panel
  function renderConversationsList() {
    const listEl = document.getElementById('conversationsList');
    const searchVal = document.getElementById('chatSearchInput').value.toLowerCase().trim();

    const filtered = conversationsData.filter(c => {
      return c.name.toLowerCase().includes(searchVal) || c.email.toLowerCase().includes(searchVal) || c.phone.includes(searchVal);
    });

    if (filtered.length === 0) {
      listEl.innerHTML = `
        <div style="padding: 40px 20px; text-align: center; color: #94A3B8; font-size: 0.82rem;">
          <i class="fa-regular fa-comment-dots" style="font-size: 1.8rem; margin-bottom: 8px; display: block;"></i>
          Belum ada pesan obrolan masuk.
        </div>
      `;
      return;
    }

    let html = '';
    filtered.forEach(c => {
      const isSelected = currentUserId === c.user_id;
      const initial = c.name.charAt(0).toUpperCase();
      const unreadBadge = c.unread_count > 0 ? `
        <span style="background: #EF4444; color: #FFF; font-size: 0.68rem; font-weight: 700; padding: 2px 7px; border-radius: 10px; margin-left: 6px;">
          ${c.unread_count} baru
        </span>
      ` : '';

      html += `
        <div onclick="selectConversation(${c.user_id})" style="padding: 14px 18px; border-bottom: 1px solid #F1F5F9; cursor: pointer; transition: background 0.15s; background: ${isSelected ? '#EFF6FF' : '#FFFFFF'}; border-left: 3px solid ${isSelected ? 'var(--admin-gold)' : 'transparent'};" onmouseover="if(!${isSelected}) this.style.background='#F8FAFC';" onmouseout="if(!${isSelected}) this.style.background='#FFFFFF';">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <div style="width: 34px; height: 34px; border-radius: 50%; background: #0B1424; color: var(--admin-gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.95rem; flex-shrink: 0;">
                ${initial}
              </div>
              <div>
                <strong style="font-size: 0.88rem; color: #0F172A; display: block; line-height: 1.2;">${c.name}</strong>
                <span style="font-size: 0.72rem; color: #64748B;">${c.email}</span>
              </div>
            </div>
            <span style="font-size: 0.68rem; color: #94A3B8;">${c.last_time}</span>
          </div>

          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 6px; padding-left: 44px;">
            <span style="font-size: 0.78rem; color: ${isSelected ? '#1E293B' : '#64748B'}; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 190px;">
              ${c.last_message ? c.last_message : '<em>Mulai obrolan...</em>'}
            </span>
            ${unreadBadge}
          </div>
        </div>
      `;
    });

    listEl.innerHTML = html;
  }

  function filterConversations() {
    renderConversationsList();
  }

  // Select customer conversation
  function selectConversation(userId) {
    if (currentUserId !== userId) {
      lastLoadedMessageCount = 0;
      lastLoadedMessageId = 0;
    }

    currentUserId = userId;
    document.getElementById('noChatSelected').style.display = 'none';
    const chatContainer = document.getElementById('activeChatContainer');
    chatContainer.style.display = 'flex';
    document.getElementById('activeChatUserId').value = userId;

    renderConversationsList();
    loadMessages(userId, false, true);
  }

  // Load message thread with customer
  function loadMessages(userId, isBackground = false, forceScrollToBottom = false) {
    fetch(`/admin/chat/messages/${userId}`)
      .then(res => res.json())
      .then(data => {
        if (!isBackground) {
          // Update customer header info
          document.getElementById('activeUserName').textContent = data.customer.name;
          document.getElementById('activeUserEmail').textContent = data.customer.email;
          document.getElementById('activeUserPhone').textContent = data.customer.phone;
          document.getElementById('activeUserAvatar').textContent = data.customer.name.charAt(0).toUpperCase();
          document.getElementById('activeUserOrders').textContent = `${data.customer.orders_count} Pesanan`;
          document.getElementById('activeUserSpent').textContent = data.customer.total_spent;
          
          const cleanPhone = (data.customer.phone || '').replace(/[^0-9]/g, '');
          document.getElementById('activeUserWaBtn').href = `https://wa.me/${cleanPhone}`;
        }

        renderMessages(data.messages, isBackground, forceScrollToBottom);
      })
      .catch(err => console.error("Error loading chat messages:", err));
  }

  // Render message bubbles in chat stream
  function renderMessages(messages, isBackground = false, forceScrollToBottom = false) {
    const streamEl = document.getElementById('messagesStream');
    
    if (messages.length === 0) {
      streamEl.innerHTML = `
        <div style="margin: auto; text-align: center; color: #94A3B8; font-size: 0.85rem;">
          <i class="fa-solid fa-hand-sparkles" style="font-size: 1.8rem; color: var(--admin-gold); margin-bottom: 8px; display: block;"></i>
          Belum ada riwayat pesan dengan customer ini. Kirim pesan sapaan pertama!
        </div>
      `;
      lastLoadedMessageCount = 0;
      lastLoadedMessageId = 0;
      return;
    }

    // Jika background polling dan tidak ada pesan baru, jangan re-render agar scroll user tidak terganggu
    const latestMsg = messages[messages.length - 1];
    if (isBackground && messages.length === lastLoadedMessageCount && latestMsg.id === lastLoadedMessageId) {
      return;
    }

    lastLoadedMessageCount = messages.length;
    lastLoadedMessageId = latestMsg.id;

    // Cek apakah posisi scroll user saat ini sedang di paling bawah (toleransi 80px)
    const isAtBottom = (streamEl.scrollHeight - streamEl.scrollTop - streamEl.clientHeight) < 80;

    let html = '';
    messages.forEach(m => {
      const isAdmin = m.sender_type === 'admin';
      
      if (isAdmin) {
        // Admin bubble on right
        html += `
          <div style="display: flex; justify-content: flex-end; align-items: flex-end; gap: 8px; margin-bottom: 4px;">
            <div style="max-width: 65%;">
              <div style="background: #0B1424; color: #FFFFFF; padding: 12px 18px; border-radius: 14px 14px 2px 14px; font-size: 0.88rem; line-height: 1.5; box-shadow: 0 2px 8px rgba(11,20,36,0.15); border: 1px solid rgba(198,161,107,0.3); word-break: break-word;">
                ${m.message}
              </div>
              <div style="font-size: 0.68rem; color: #94A3B8; text-align: right; margin-top: 4px;">
                ${m.time} · Admin Toko
              </div>
            </div>
            <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--admin-gold); color: #0B1424; font-size: 0.72rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              A
            </div>
          </div>
        `;
      } else {
        // Customer bubble on left
        html += `
          <div style="display: flex; justify-content: flex-start; align-items: flex-end; gap: 8px; margin-bottom: 4px;">
            <div style="width: 28px; height: 28px; border-radius: 50%; background: #E2E8F0; color: #334155; font-size: 0.72rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              C
            </div>
            <div style="max-width: 65%;">
              <div style="background: #FFFFFF; color: #0F172A; padding: 12px 18px; border-radius: 14px 14px 14px 2px; font-size: 0.88rem; line-height: 1.5; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid var(--admin-border-subtle); word-break: break-word;">
                ${m.message}
              </div>
              <div style="font-size: 0.68rem; color: #94A3B8; margin-top: 4px;">
                ${m.time} · Customer
              </div>
            </div>
          </div>
        `;
      }
    });

    streamEl.innerHTML = html;

    // Auto-scroll ke bawah saat pertama kali buka chat, setelah mengirim pesan, atau jika user memang sedang berada di paling bawah
    if (forceScrollToBottom || !isBackground || isAtBottom) {
      setTimeout(() => {
        streamEl.scrollTop = streamEl.scrollHeight;
      }, 50);
    }
  }

  // Admin Send Message
  function sendAdminMessage(e) {
    e.preventDefault();
    const inputEl = document.getElementById('adminReplyInput');
    const msg = inputEl.value.trim();
    if (!msg || !currentUserId) return;

    inputEl.value = '';

    fetch("{{ route('admin.chat.send') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        user_id: currentUserId,
        message: msg
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        loadMessages(currentUserId, false, true);
        loadConversations(true);
      }
    })
    .catch(err => console.error("Error sending admin chat:", err));
  }
</script>
@endpush
@endsection

