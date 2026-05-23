@extends('layouts.app')

@push('styles')
<style>
/* =============================================
   SUPPORT PAGE — Clean & High-Class
============================================= */

/* ── HERO ── */
.support-hero {
    position: relative;
    padding: 130px 48px 100px;
    text-align: center;
    overflow: hidden;
    background: var(--bg);
}
.support-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 55% at 50% -5%, rgba(212,168,67,0.12) 0%, transparent 65%),
        radial-gradient(ellipse 40% 60% at 10% 80%, rgba(212,168,67,0.04) 0%, transparent 50%),
        radial-gradient(ellipse 40% 60% at 90% 80%, rgba(160,114,26,0.04) 0%, transparent 50%);
    pointer-events: none;
}
.support-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 720px;
    margin: 0 auto;
    animation: sHeroIn 0.9s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes sHeroIn {
    from { opacity: 0; transform: translateY(32px); }
    to   { opacity: 1; transform: translateY(0); }
}

.support-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--gold);
    padding: 7px 18px;
    border: 1px solid rgba(212,168,67,0.3);
    border-radius: 100px;
    background: rgba(212,168,67,0.07);
    margin-bottom: 28px;
}
.support-eyebrow-dot {
    width: 6px; height: 6px;
    background: #10b981;
    border-radius: 50%;
    animation: sPulse 2s ease-in-out infinite;
}
@keyframes sPulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%     { opacity: 0.4; transform: scale(0.6); }
}

.support-hero-title {
    font-family: 'Manrope', sans-serif;
    font-size: clamp(2.8rem, 5.5vw, 4.8rem);
    font-weight: 900;
    line-height: 1.05;
    letter-spacing: -0.05em;
    color: var(--text);
    margin-bottom: 20px;
    transition: color 0.4s ease;
}
.support-hero-title .gold-grad {
    background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.support-hero-desc {
    font-size: 1.05rem;
    color: var(--text-muted);
    font-weight: 300;
    line-height: 1.75;
    max-width: 490px;
    margin: 0 auto 40px;
    transition: color 0.4s ease;
}

/* Hero search bar */
.support-search-wrap {
    max-width: 520px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 12px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px 20px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.4s ease;
    animation: sHeroIn 0.9s 0.1s cubic-bezier(0.16,1,0.3,1) both;
}
.support-search-wrap:focus-within {
    border-color: var(--gold);
    box-shadow: 0 0 0 4px rgba(212,168,67,0.1);
}
.support-search-wrap i { color: var(--text-muted); font-size: 1.1rem; }
.support-search-input {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.95rem;
}
.support-search-input::placeholder { color: var(--text-muted); }

/* ── QUICK HELP CARDS ── */
.support-quick {
    background: var(--bg-2);
    border-top: 1px solid var(--border);
    padding: 96px 48px;
    transition: background 0.4s ease;
}
.support-quick-inner {
    max-width: 1280px;
    margin: 0 auto;
}
.support-quick-header {
    text-align: center;
    margin-bottom: 56px;
}
.support-quick-header .section-desc {
    max-width: 460px;
    margin-left: auto;
    margin-right: auto;
}

.support-quick-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.quick-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 36px 30px;
    text-align: center;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.35s cubic-bezier(0.2,0.8,0.2,1), box-shadow 0.35s ease, border-color 0.3s ease;
    animation: sCardIn 0.55s cubic-bezier(0.2,0.8,0.2,1) both;
}
.quick-card:nth-child(1) { animation-delay: 0.04s; }
.quick-card:nth-child(2) { animation-delay: 0.08s; }
.quick-card:nth-child(3) { animation-delay: 0.12s; }
.quick-card:nth-child(4) { animation-delay: 0.16s; }
.quick-card:nth-child(5) { animation-delay: 0.20s; }
.quick-card:nth-child(6) { animation-delay: 0.24s; }

@keyframes sCardIn {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}

.quick-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 20px 20px 0 0;
    background: linear-gradient(90deg, #d4a843, #f0d080, #a0721a);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.quick-card { position: relative; overflow: hidden; }
.quick-card:hover::before { opacity: 1; }
.quick-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(0,0,0,0.15);
    border-color: rgba(212,168,67,0.3);
}

.quick-icon-wrap {
    width: 60px; height: 60px;
    border-radius: 16px;
    background: var(--gold-dim);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 20px;
    transition: transform 0.3s ease;
}
.quick-card:hover .quick-icon-wrap { transform: scale(1.08); }
.quick-icon-wrap i {
    font-size: 1.5rem;
    color: var(--gold);
}

.quick-title {
    font-family: 'Manrope', sans-serif;
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.02em;
    margin-bottom: 8px;
    transition: color 0.4s ease;
}
.quick-desc {
    font-size: 0.82rem;
    color: var(--text-muted);
    line-height: 1.65;
    font-weight: 300;
    transition: color 0.4s ease;
}

/* ── FAQ SECTION ── */
.support-faq {
    background: var(--bg);
    padding: 96px 48px;
    transition: background 0.4s ease;
}
.support-faq-inner {
    max-width: 800px;
    margin: 0 auto;
}
.support-faq-header {
    text-align: center;
    margin-bottom: 48px;
}
.support-faq-header .section-desc {
    max-width: 420px;
    margin-left: auto;
    margin-right: auto;
}

/* Accordion */
.faq-item {
    border: 1px solid var(--border);
    border-radius: 16px;
    margin-bottom: 12px;
    background: var(--surface);
    overflow: hidden;
    transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.4s ease;
}
.faq-item:hover {
    border-color: rgba(212,168,67,0.2);
}
.faq-item.active {
    border-color: rgba(212,168,67,0.3);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}

.faq-question {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 22px 28px;
    background: none;
    border: none;
    cursor: pointer;
    text-align: left;
    font-family: 'Manrope', sans-serif;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.02em;
    transition: color 0.3s ease;
}
.faq-question:hover { color: var(--gold); }
.faq-item.active .faq-question { color: var(--gold); }

.faq-chevron {
    flex-shrink: 0;
    width: 28px; height: 28px;
    border-radius: 50%;
    background: var(--bg);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    transition: transform 0.35s ease, background 0.3s ease, border-color 0.3s ease;
}
.faq-chevron i {
    font-size: 0.7rem;
    color: var(--text-muted);
    transition: color 0.3s ease;
}
.faq-item.active .faq-chevron {
    transform: rotate(180deg);
    background: var(--gold-dim);
    border-color: rgba(212,168,67,0.3);
}
.faq-item.active .faq-chevron i { color: var(--gold); }

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.16,1,0.3,1), padding 0.3s ease;
}
.faq-answer-inner {
    padding: 0 28px 24px;
    font-size: 0.88rem;
    color: var(--text-muted);
    line-height: 1.75;
    font-weight: 300;
    transition: color 0.4s ease;
}

/* ── CONTACT CHANNELS ── */
.support-contact {
    background: var(--bg-2);
    border-top: 1px solid var(--border);
    padding: 96px 48px;
    transition: background 0.4s ease;
}
.support-contact-inner {
    max-width: 1280px;
    margin: 0 auto;
}
.support-contact-header {
    text-align: center;
    margin-bottom: 56px;
}
.support-contact-header .section-desc {
    max-width: 440px;
    margin-left: auto;
    margin-right: auto;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.contact-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 40px 32px;
    text-align: center;
    transition: transform 0.35s cubic-bezier(0.2,0.8,0.2,1), box-shadow 0.35s, border-color 0.3s;
}
.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 48px rgba(0,0,0,0.12);
    border-color: rgba(212,168,67,0.3);
}

.contact-icon-circle {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: var(--gold-dim);
    border: 1px solid rgba(212,168,67,0.15);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    transition: transform 0.3s ease;
}
.contact-card:hover .contact-icon-circle { transform: scale(1.08); }
.contact-icon-circle i {
    font-size: 1.5rem;
    color: var(--gold);
}

.contact-title {
    font-family: 'Manrope', sans-serif;
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.02em;
    margin-bottom: 6px;
    transition: color 0.4s ease;
}
.contact-detail {
    font-size: 0.85rem;
    color: var(--text-muted);
    font-weight: 300;
    line-height: 1.65;
    margin-bottom: 18px;
    transition: color 0.4s ease;
}
.contact-value {
    font-family: 'Manrope', sans-serif;
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--gold);
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* ── OPERATION HOURS STRIP ── */
.support-hours {
    background: var(--bg);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 0 48px;
    transition: background 0.4s ease;
}
.support-hours-inner {
    max-width: 1280px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}
.hours-item {
    padding: 40px 24px;
    text-align: center;
    border-right: 1px solid var(--border);
    transition: background 0.3s;
}
.hours-item:last-child { border-right: none; }
.hours-item:hover { background: var(--search-bg); }

.hours-icon {
    font-size: 1.3rem;
    color: var(--gold);
    margin-bottom: 10px;
    display: block;
}
.hours-label {
    font-family: 'Manrope', sans-serif;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 4px;
    letter-spacing: -0.02em;
    transition: color 0.4s ease;
}
.hours-value {
    font-size: 0.78rem;
    color: var(--text-muted);
    line-height: 1.55;
    font-weight: 300;
    transition: color 0.4s ease;
}

/* ── CTA BANNER ── */
.support-cta {
    background: var(--bg);
    padding: 96px 48px;
}
.support-cta-banner {
    max-width: 1280px;
    margin: 0 auto;
    background: linear-gradient(135deg, rgba(212,168,67,0.08), rgba(160,114,26,0.03));
    border: 1px solid rgba(212,168,67,0.2);
    border-radius: 24px;
    padding: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    position: relative;
    overflow: hidden;
    transition: border-color 0.3s ease;
}
.support-cta-banner::after {
    content: '';
    position: absolute;
    top: -60%; right: -10%;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(212,168,67,0.07) 0%, transparent 70%);
    pointer-events: none;
}
.support-cta-banner:hover { border-color: rgba(212,168,67,0.4); }

.support-cta-text { position: relative; z-index: 1; }
.support-cta-eyebrow {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 10px;
    display: flex; align-items: center; gap: 6px;
}
.support-cta-title {
    font-family: 'Manrope', sans-serif;
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 900;
    color: var(--text);
    letter-spacing: -0.04em;
    line-height: 1.15;
    margin-bottom: 10px;
    transition: color 0.4s ease;
}
.support-cta-desc {
    font-size: 0.9rem;
    color: var(--text-muted);
    font-weight: 300;
    line-height: 1.65;
    max-width: 460px;
    transition: color 0.4s ease;
}
.support-cta-btn {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #f0d080 0%, #d4a843 40%, #a0721a 100%);
    color: #000;
    font-family: 'Manrope', sans-serif;
    font-weight: 800;
    font-size: 0.9rem;
    padding: 16px 36px;
    border-radius: 100px;
    border: none;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    letter-spacing: -0.01em;
    box-shadow: 0 4px 14px rgba(212,168,67,0.2);
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
}
.support-cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(212,168,67,0.35);
    color: #000;
}

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
    .support-quick-grid { grid-template-columns: repeat(2, 1fr); }
    .contact-grid { grid-template-columns: repeat(2, 1fr); }
    .support-hours-inner { grid-template-columns: repeat(2, 1fr); }
    .hours-item:nth-child(2) { border-right: none; }
}
@media (max-width: 860px) {
    .support-hero { padding: 110px 24px 72px; }
    .support-quick { padding: 64px 24px; }
    .support-faq { padding: 64px 24px; }
    .support-contact { padding: 64px 24px; }
    .support-cta { padding: 64px 24px; }
    .support-hours { padding: 0 24px; }
    .support-cta-banner {
        flex-direction: column;
        text-align: center;
        padding: 48px 28px;
    }
    .support-cta-desc { margin: 0 auto; }
}
@media (max-width: 600px) {
    .support-quick-grid { grid-template-columns: 1fr; }
    .contact-grid { grid-template-columns: 1fr; }
    .support-hours-inner { grid-template-columns: 1fr; }
    .hours-item { border-right: none; border-bottom: 1px solid var(--border); }
    .hours-item:last-child { border-bottom: none; }
    .support-hero-title { font-size: 2.6rem; }
    .support-search-wrap { margin: 0 auto; }
}
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════ --}}
<section class="support-hero">
    <div class="support-hero-inner">

        <div class="support-eyebrow">
            <span class="support-eyebrow-dot"></span>
            Pusat Bantuan Online
        </div>

        <h1 class="support-hero-title">
            Ada yang Bisa<br><span class="gold-grad">Kami Bantu?</span>
        </h1>

        <p class="support-hero-desc">
            Tim support LaptoPedia siap membantu Anda 24/7. Temukan jawaban cepat atau hubungi kami secara langsung.
        </p>

        <div class="support-search-wrap">
            <i class="bi bi-search"></i>
            <input
                type="text"
                class="support-search-input"
                placeholder="Cari topik bantuan, FAQ, atau panduan..."
                autocomplete="off"
                id="supportSearchInput"
            >
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     QUICK HELP CATEGORIES
═══════════════════════════════════════════════ --}}
<section class="support-quick">
    <div class="support-quick-inner">

        <div class="support-quick-header">
            <span class="section-label">Bantuan Cepat</span>
            <h2 class="section-h2">Topik Populer</h2>
            <p class="section-desc">Temukan jawaban instan untuk pertanyaan yang paling sering diajukan.</p>
        </div>

        <div class="support-quick-grid">

            <div class="quick-card">
                <div class="quick-icon-wrap">
                    <i class="bi bi-bag-check"></i>
                </div>
                <div class="quick-title">Pemesanan & Pembayaran</div>
                <p class="quick-desc">Cara memesan, metode pembayaran yang tersedia, konfirmasi transaksi, dan status pesanan Anda.</p>
            </div>

            <div class="quick-card">
                <div class="quick-icon-wrap">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="quick-title">Pengiriman & Tracking</div>
                <p class="quick-desc">Estimasi waktu pengiriman, lacak paket Anda secara real-time, dan area jangkauan kurir kami.</p>
            </div>

            <div class="quick-card">
                <div class="quick-icon-wrap">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </div>
                <div class="quick-title">Pengembalian & Refund</div>
                <p class="quick-desc">Kebijakan retur 30 hari, prosedur pengembalian barang, dan proses pencairan dana refund.</p>
            </div>

            <div class="quick-card">
                <div class="quick-icon-wrap">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="quick-title">Garansi Produk</div>
                <p class="quick-desc">Informasi garansi resmi, klaim kerusakan, perpanjangan garansi, dan pusat servis terdekat.</p>
            </div>

            <div class="quick-card">
                <div class="quick-icon-wrap">
                    <i class="bi bi-person-gear"></i>
                </div>
                <div class="quick-title">Akun & Keamanan</div>
                <p class="quick-desc">Kelola profil, ubah kata sandi, keamanan akun, dan pengaturan notifikasi Anda.</p>
            </div>

            <div class="quick-card">
                <div class="quick-icon-wrap">
                    <i class="bi bi-cpu"></i>
                </div>
                <div class="quick-title">Spesifikasi & Konsultasi</div>
                <p class="quick-desc">Butuh bantuan memilih laptop? Tim ahli kami siap memberikan rekomendasi sesuai kebutuhan.</p>
            </div>

        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     FAQ ACCORDION
═══════════════════════════════════════════════ --}}
<section class="support-faq">
    <div class="support-faq-inner">

        <div class="support-faq-header">
            <span class="section-label">FAQ</span>
            <h2 class="section-h2">Pertanyaan Umum</h2>
            <p class="section-desc">Jawaban untuk pertanyaan yang paling sering kami terima.</p>
        </div>

        <div class="faq-list" id="faqList">

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    Bagaimana cara melakukan pemesanan?
                    <span class="faq-chevron"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Pilih laptop yang Anda inginkan dari katalog kami, klik tombol <strong>"Beli"</strong> atau <strong>"Tambah ke Keranjang"</strong>, lalu lanjutkan ke halaman checkout. Anda bisa membayar dengan transfer bank, e-wallet, atau kartu kredit. Setelah pembayaran dikonfirmasi, pesanan akan segera diproses.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    Berapa lama waktu pengiriman?
                    <span class="faq-chevron"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Pengiriman dalam kota membutuhkan <strong>1–2 hari kerja</strong>, antar-pulau <strong>3–5 hari kerja</strong>, dan ke daerah terpencil <strong>5–7 hari kerja</strong>. Anda akan menerima nomor resi untuk melacak paket secara real-time setelah barang dikirim.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    Apakah produk yang dijual bergaransi resmi?
                    <span class="faq-chevron"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Ya, <strong>100% produk kami bergaransi resmi</strong> dari distributor Indonesia. Setiap laptop dilengkapi kartu garansi, sertifikat keaslian, dan akses ke service center resmi di seluruh Indonesia. Kami juga menyediakan opsi perpanjangan garansi.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    Bagaimana kebijakan pengembalian barang?
                    <span class="faq-chevron"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Kami memberikan <strong>garansi 30 hari pengembalian</strong> tanpa syarat. Jika produk tidak sesuai ekspektasi, rusak saat diterima, atau terdapat cacat produksi, hubungi tim support kami dan kami akan mengatur proses pengembalian serta pencairan dana dalam 3–5 hari kerja.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    Metode pembayaran apa saja yang tersedia?
                    <span class="faq-chevron"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Kami mendukung berbagai metode pembayaran: <strong>Transfer Bank</strong> (BCA, Mandiri, BNI, BRI), <strong>E-Wallet</strong> (GoPay, OVO, Dana, ShopeePay), <strong>Kartu Kredit/Debit</strong> (Visa, Mastercard), serta <strong>cicilan 0%</strong> hingga 12 bulan untuk kartu kredit tertentu.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    Apakah bisa cicilan tanpa kartu kredit?
                    <span class="faq-chevron"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Ya! Kami bekerja sama dengan <strong>Kredivo</strong> dan <strong>Akulaku</strong> untuk menyediakan opsi cicilan tanpa kartu kredit. Anda bisa memilih tenor <strong>3, 6, atau 12 bulan</strong> dengan proses persetujuan instan langsung di halaman checkout.
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     CONTACT CHANNELS
═══════════════════════════════════════════════ --}}
<section class="support-contact">
    <div class="support-contact-inner">

        <div class="support-contact-header">
            <span class="section-label">Hubungi Kami</span>
            <h2 class="section-h2">Cara Menghubungi Kami</h2>
            <p class="section-desc">Pilih channel komunikasi yang paling nyaman untuk Anda.</p>
        </div>

        <div class="contact-grid">

            <div class="contact-card">
                <div class="contact-icon-circle">
                    <i class="bi bi-chat-dots-fill"></i>
                </div>
                <div class="contact-title">Live Chat</div>
                <p class="contact-detail">Respon instan dari AI assistant dan tim customer service kami melalui fitur chat bawaan.</p>
                <div class="contact-value">
                    <i class="bi bi-circle-fill" style="font-size:0.45rem;color:#10b981;"></i> Online Sekarang
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-icon-circle">
                    <i class="bi bi-envelope-fill"></i>
                </div>
                <div class="contact-title">Email</div>
                <p class="contact-detail">Kirimkan pertanyaan detail atau dokumen pendukung, dan kami akan merespons dalam 24 jam.</p>
                <div class="contact-value">
                    support@laptopedia.id
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-icon-circle">
                    <i class="bi bi-whatsapp"></i>
                </div>
                <div class="contact-title">WhatsApp</div>
                <p class="contact-detail">Chat langsung dengan tim kami melalui WhatsApp untuk respons cepat dan konsultasi produk.</p>
                <div class="contact-value">
                    +62 812-3456-7890
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     OPERATION HOURS STRIP
═══════════════════════════════════════════════ --}}
<div class="support-hours">
    <div class="support-hours-inner">
        <div class="hours-item">
            <i class="bi bi-chat-dots hours-icon"></i>
            <div class="hours-label">Live Chat</div>
            <div class="hours-value">24 Jam / 7 Hari</div>
        </div>
        <div class="hours-item">
            <i class="bi bi-telephone hours-icon"></i>
            <div class="hours-label">Telepon</div>
            <div class="hours-value">Sen–Jum: 08.00 – 20.00<br>Sab: 09.00 – 15.00</div>
        </div>
        <div class="hours-item">
            <i class="bi bi-envelope hours-icon"></i>
            <div class="hours-label">Email</div>
            <div class="hours-value">Respon maks. 24 jam<br>di hari kerja</div>
        </div>
        <div class="hours-item">
            <i class="bi bi-shop hours-icon"></i>
            <div class="hours-label">Toko Offline</div>
            <div class="hours-value">Sen–Sab: 10.00 – 21.00<br>Minggu: 11.00 – 18.00</div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     CTA BANNER
═══════════════════════════════════════════════ --}}
<section class="support-cta">
    <div class="support-cta-banner">
        <div class="support-cta-text">
            <div class="support-cta-eyebrow">
                <i class="bi bi-robot"></i> Bantuan Berbasis AI
            </div>
            <h3 class="support-cta-title">
                Butuh Bantuan Sekarang?
            </h3>
            <p class="support-cta-desc">
                Klik tombol chat di pojok kanan bawah untuk langsung terhubung dengan asisten AI kami. Tersedia 24/7, siap menjawab semua pertanyaan Anda.
            </p>
        </div>
        <button class="support-cta-btn" onclick="if(typeof toggleChat==='function'){toggleChat();}">
            Mulai Chat <i class="bi bi-chat-dots-fill"></i>
        </button>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ── FAQ ACCORDION ─────────────────────────────────
function toggleFaq(btn) {
    const item = btn.closest('.faq-item');
    const answer = item.querySelector('.faq-answer');
    const isActive = item.classList.contains('active');

    // Close all open items
    document.querySelectorAll('.faq-item.active').forEach(openItem => {
        if (openItem !== item) {
            openItem.classList.remove('active');
            openItem.querySelector('.faq-answer').style.maxHeight = '0';
        }
    });

    // Toggle current
    if (isActive) {
        item.classList.remove('active');
        answer.style.maxHeight = '0';
    } else {
        item.classList.add('active');
        answer.style.maxHeight = answer.scrollHeight + 'px';
    }
}

// ── SEARCH FILTER (filter FAQ items live) ──────────
document.getElementById('supportSearchInput').addEventListener('input', function() {
    const query = this.value.toLowerCase().trim();
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question').textContent.toLowerCase();
        const answer = item.querySelector('.faq-answer-inner').textContent.toLowerCase();
        const matches = !query || question.includes(query) || answer.includes(query);

        item.style.display = matches ? '' : 'none';

        // Auto-expand matching items when searching
        if (matches && query.length > 2) {
            item.classList.add('active');
            item.querySelector('.faq-answer').style.maxHeight = item.querySelector('.faq-answer').scrollHeight + 'px';
        } else if (!query) {
            item.classList.remove('active');
            item.querySelector('.faq-answer').style.maxHeight = '0';
        }
    });
});
</script>
@endpush
