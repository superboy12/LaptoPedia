@extends('layouts.admin')

@section('page_title', 'Customer Chat')
@section('page_desc', 'Balas pesan langsung dari pelanggan Anda')

@push('styles')
<style>
.chat-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 20px;
    height: calc(100vh - 180px);
    min-height: 500px;
}

/* ── CONVERSATION LIST ── */
.conv-list {
    background: rgba(26,26,26,0.5);
    border: 1px solid var(--border);
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.conv-list-header {
    padding: 18px 16px 14px;
    border-bottom: 1px solid var(--border);
    font-family: 'Manrope', sans-serif;
    font-size: 0.85rem;
    font-weight: 800;
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}
.conv-list-body { overflow-y: auto; flex: 1; }

.conv-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    cursor: pointer;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    transition: background 0.2s;
}
.conv-item:hover { background: rgba(255,255,255,0.04); }
.conv-item.active { background: var(--gold-dim); border-left: 3px solid var(--gold); }

.conv-avatar {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: var(--surface-2);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Manrope', sans-serif;
    font-weight: 800; font-size: 0.9rem;
    color: var(--gold);
    flex-shrink: 0;
    border: 1px solid var(--border);
}
.conv-info { flex: 1; min-width: 0; }
.conv-name {
    font-size: 0.84rem; font-weight: 700;
    color: var(--white); margin-bottom: 2px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.conv-preview {
    font-size: 0.74rem; color: var(--muted);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.conv-badge {
    background: var(--gold);
    color: #000;
    font-size: 0.65rem; font-weight: 800;
    min-width: 18px; height: 18px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    padding: 0 5px; flex-shrink: 0;
}

/* ── CHAT PANEL ── */
.chat-panel {
    background: rgba(26,26,26,0.5);
    border: 1px solid var(--border);
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.chat-panel-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
    background: rgba(255,255,255,0.02);
}
.chat-panel-header .conv-avatar { width: 36px; height: 36px; }
.chat-header-name {
    font-family: 'Manrope', sans-serif;
    font-size: 0.9rem; font-weight: 800; color: var(--white);
}
.chat-header-status { font-size: 0.72rem; color: var(--muted); }
.online-dot { width: 6px; height: 6px; background: #4ade80; border-radius: 50%; display: inline-block; margin-right: 4px; }

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.chat-empty {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--muted);
    font-size: 0.85rem;
    gap: 12px;
}
.chat-empty i { font-size: 3rem; opacity: 0.2; }

.msg-bubble {
    max-width: 72%;
    padding: 10px 14px;
    border-radius: 14px;
    font-size: 0.84rem;
    line-height: 1.55;
    word-wrap: break-word;
}
.msg-bubble.from-user {
    align-self: flex-start;
    background: var(--surface-2);
    color: var(--white);
    border-bottom-left-radius: 4px;
}
.msg-bubble.from-ai {
    align-self: flex-start;
    background: rgba(59,130,246,0.12);
    color: #93c5fd;
    border: 1px solid rgba(59,130,246,0.2);
    border-bottom-left-radius: 4px;
}
.msg-bubble.from-admin {
    align-self: flex-end;
    background: linear-gradient(135deg, #d4a843, #b8870e);
    color: #000;
    font-weight: 600;
    border-bottom-right-radius: 4px;
}
.msg-meta {
    font-size: 0.68rem;
    color: var(--muted);
    margin-top: 4px;
    display: block;
}
.msg-meta.right { text-align: right; }
.msg-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 4px;
    opacity: 0.6;
}

/* ── INPUT AREA ── */
.chat-input-area {
    padding: 14px 16px;
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
    background: rgba(0,0,0,0.15);
}
.admin-chat-input {
    flex: 1;
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--white);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem;
    padding: 11px 16px;
    border-radius: 100px;
    outline: none;
    transition: border-color 0.2s;
}
.admin-chat-input:focus { border-color: var(--gold); }
.admin-chat-input::placeholder { color: var(--muted); }
.btn-admin-send {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #d4a843, #b8870e);
    border: none; cursor: pointer; color: #000;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
    transition: transform 0.2s, opacity 0.2s;
    flex-shrink: 0;
}
.btn-admin-send:hover { transform: scale(1.1); }
.btn-admin-send:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

/* No conversation selected */
.no-conv-selected {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--muted);
    gap: 14px;
}
.no-conv-selected i { font-size: 4rem; opacity: 0.15; }
.no-conv-selected p { font-size: 0.88rem; }

@media (max-width: 900px) {
    .chat-layout { grid-template-columns: 1fr; height: auto; }
    .conv-list { height: 300px; }
    .chat-panel { height: 500px; }
}
</style>
@endpush

@section('content')

<div class="chat-layout fade-up">

    {{-- ── LEFT: CONVERSATION LIST ── --}}
    <div class="conv-list">
        <div class="conv-list-header">
            <span>Percakapan</span>
            @if($totalUnread > 0)
                <span style="background:var(--gold);color:#000;font-size:0.68rem;font-weight:800;padding:2px 8px;border-radius:100px;">
                    {{ $totalUnread }} baru
                </span>
            @endif
        </div>

        <div class="conv-list-body" id="convList">
            @forelse($conversations as $conv)
            <div class="conv-item {{ request('user') == $conv->id_user ? 'active' : '' }}"
                 onclick="selectUser({{ $conv->id_user }}, '{{ addslashes($conv->nama_lengkap) }}')"
                 id="conv-{{ $conv->id_user }}">
                <div class="conv-avatar">{{ strtoupper(substr($conv->nama_lengkap, 0, 2)) }}</div>
                <div class="conv-info">
                    <div class="conv-name">{{ $conv->nama_lengkap }}</div>
                    <div class="conv-preview">
                        {{ $conv->chatMessages->first()?->message ?? 'Belum ada pesan' }}
                    </div>
                </div>
                @if($conv->unread_count > 0)
                    <span class="conv-badge" id="badge-{{ $conv->id_user }}">{{ $conv->unread_count }}</span>
                @endif
            </div>
            @empty
            <div style="padding:40px 20px;text-align:center;color:var(--muted);font-size:0.84rem;">
                <i class="bi bi-chat-dots" style="font-size:2.5rem;opacity:0.2;display:block;margin-bottom:12px;"></i>
                Belum ada percakapan masuk.
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── RIGHT: CHAT PANEL ── --}}
    <div class="chat-panel" id="chatPanel">

        {{-- Header --}}
        <div class="chat-panel-header" id="chatHeader" style="{{ request('user') ? '' : 'display:none;' }}">
            <div class="conv-avatar" id="chatAvatar">??</div>
            <div>
                <div class="chat-header-name" id="chatUserName">—</div>
                <div class="chat-header-status">
                    <span class="online-dot"></span> Customer
                </div>
            </div>
        </div>

        {{-- Empty state: no user selected --}}
        <div class="no-conv-selected" id="noChatSelected" style="{{ request('user') ? 'display:none;' : '' }}">
            <i class="bi bi-chat-square-text"></i>
            <p>Pilih percakapan dari daftar kiri untuk mulai membalas.</p>
        </div>

        {{-- Messages --}}
        <div class="chat-messages" id="chatMessages" style="{{ request('user') ? '' : 'display:none;' }}"></div>

        {{-- Input --}}
        <div class="chat-input-area" id="chatInputArea" style="{{ request('user') ? '' : 'display:none;' }}">
            <input type="text" class="admin-chat-input" id="adminInput"
                   placeholder="Tulis balasan ke pelanggan..."
                   autocomplete="off">
            <button class="btn-admin-send" id="adminSendBtn" onclick="adminSend()">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let activeUserId   = null;
let activeUserName = '';
let lastMsgId      = 0;
let pollTimer      = null;

// ─── Select User Conversation ───────────────────────
function selectUser(userId, userName) {
    activeUserId   = userId;
    activeUserName = userName;
    lastMsgId      = 0;

    // Update UI
    document.querySelectorAll('.conv-item').forEach(el => el.classList.remove('active'));
    const convEl = document.getElementById('conv-' + userId);
    if (convEl) convEl.classList.add('active');

    // Remove badge
    const badge = document.getElementById('badge-' + userId);
    if (badge) badge.remove();

    // Show chat panel
    document.getElementById('noChatSelected').style.display = 'none';
    document.getElementById('chatHeader').style.display     = 'flex';
    document.getElementById('chatMessages').style.display   = 'flex';
    document.getElementById('chatInputArea').style.display  = 'flex';

    // Update header
    document.getElementById('chatUserName').textContent = userName;
    document.getElementById('chatAvatar').textContent   = userName.substring(0, 2).toUpperCase();

    // Clear & load messages
    document.getElementById('chatMessages').innerHTML = '';
    loadMessages();

    // Start polling
    clearInterval(pollTimer);
    pollTimer = setInterval(loadMessages, 3000);

    document.getElementById('adminInput').focus();
}

// ─── Load Messages from Server ──────────────────────
async function loadMessages() {
    if (!activeUserId) return;
    try {
        const res  = await fetch(`/admin/chat/${activeUserId}/messages?last_id=${lastMsgId}`, {
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const msgs = await res.json();

        msgs.forEach(msg => {
            appendMsg(msg.sender, msg.message, msg.created_at);
            if (msg.id > lastMsgId) lastMsgId = msg.id;
        });
    } catch(e) { console.error('Poll error', e); }
}

// ─── Append Message Bubble ──────────────────────────
function appendMsg(sender, text, createdAt) {
    const box  = document.getElementById('chatMessages');
    const wrap = document.createElement('div');
    wrap.style.display = 'flex';
    wrap.style.flexDirection = 'column';
    wrap.style.alignItems = sender === 'admin' ? 'flex-end' : 'flex-start';

    const senderLabel = sender === 'user' ? activeUserName
                      : sender === 'ai'   ? '🤖 AI'
                      : '✉️ Anda';

    const timeStr = createdAt ? new Date(createdAt).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : '';

    wrap.innerHTML = `
        <div class="msg-label">${senderLabel}</div>
        <div class="msg-bubble from-${sender}">${escHtml(text)}</div>
        <span class="msg-meta ${sender === 'admin' ? 'right' : ''}">${timeStr}</span>
    `;
    box.appendChild(wrap);
    box.scrollTop = box.scrollHeight;
}

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
}

// ─── Admin Send Reply ────────────────────────────────
async function adminSend() {
    if (!activeUserId) return;
    const input = document.getElementById('adminInput');
    const btn   = document.getElementById('adminSendBtn');
    const text  = input.value.trim();
    if (!text) return;

    input.value   = '';
    btn.disabled  = true;

    try {
        const res  = await fetch(`/admin/chat/${activeUserId}/reply`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: text })
        });
        const data = await res.json();
        if (data.status === 'ok') {
            appendMsg('admin', text, data.message.created_at);
            if (data.message.id > lastMsgId) lastMsgId = data.message.id;
        }
    } catch(e) { console.error('Send error', e); }

    btn.disabled = false;
    input.focus();
}

// Enter key untuk kirim
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('adminInput').addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); adminSend(); }
    });

    // Auto-select if ?user= param
    const params = new URLSearchParams(window.location.search);
    if (params.get('user')) {
        const item = document.getElementById('conv-' + params.get('user'));
        if (item) item.click();
    }
});
</script>
@endpush
