<style>
    :root {
        --bg: #0f1117;
        --surface: #181c27;
        --surface2: #1e2334;
        --border: rgba(255, 255, 255, 0.07);
        --accent: #e63946;
        --accent2: #ff6b6b;
        --text: #eef0f5;
        --text2: #8b90a0;
        --text3: #5a5f72;
        --radius: 14px;
        --radius-sm: 9px;
        --topbar-h: 58px;
        --sidebar-w: 240px;
    }

    /* ── TOPBAR ── */
    .topbar {
        position: fixed;
        top: 0;
        left: var(--sidebar-w);
        right: 0;
        height: var(--topbar-h);
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        padding: 0 24px;
        gap: 12px;
        z-index: 150;
    }

    /* sidebar toggle (mobile) */
    .topbar-toggle {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text2);
        font-size: 16px;
        padding: 6px;
        border-radius: 8px;
        transition: all .15s;
        display: none;
    }

    .topbar-toggle:hover {
        color: var(--text);
        background: var(--surface2);
    }

    @media(max-width:768px) {
        .topbar-toggle {
            display: flex;
        }
    }

    /* search */
    .topbar-search {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 7px 14px;
        width: 220px;
        transition: border-color .18s;
    }

    .topbar-search:focus-within {
        border-color: var(--accent);
    }

    .topbar-search input {
        background: none;
        border: none;
        outline: none;
        color: var(--text2);
        font-size: 13px;
        font-family: inherit;
        width: 100%;
    }

    .topbar-search input::placeholder {
        color: var(--text3);
    }

    .topbar-search svg {
        flex-shrink: 0;
    }

    /* right side */
    .topbar-right {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-left: auto;
    }

    /* icon button */
    .topbar-icon-btn {
        position: relative;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        width: 38px;
        height: 38px;
        display: grid;
        place-items: center;
        color: var(--text2);
        cursor: pointer;
        transition: all .15s;
        text-decoration: none;
        font-size: 15px;
    }

    .topbar-icon-btn:hover {
        color: var(--text);
        border-color: rgba(255, 255, 255, .14);
    }

    /* notification dot */
    .topbar-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--accent);
        border: 2px solid var(--surface);
        position: absolute;
        top: 6px;
        right: 6px;
    }

    /* dropdown */
    .tb-dropdown {
        position: relative;
    }

    .tb-dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        min-width: 260px;
        box-shadow: 0 12px 36px rgba(0, 0, 0, .45);
        opacity: 0;
        transform: translateY(-6px) scale(.98);
        pointer-events: none;
        transition: all .18s ease;
        z-index: 300;
        overflow: hidden;
    }

    .tb-dropdown.open .tb-dropdown-menu {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: all;
    }

    .tb-dropdown-header {
        padding: 12px 16px 8px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text3);
        border-bottom: 1px solid var(--border);
    }

    /* message item */
    .tb-msg-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 11px 16px;
        text-decoration: none;
        transition: background .13s;
        border-bottom: 1px solid var(--border);
    }

    .tb-msg-item:last-of-type {
        border-bottom: none;
    }

    .tb-msg-item:hover {
        background: rgba(255, 255, 255, .03);
    }

    .tb-msg-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        flex-shrink: 0;
        background: linear-gradient(135deg, #63b3ed, #818cf8);
        display: grid;
        place-items: center;
        font-family: 'Syne', sans-serif;
        font-size: 12px;
        font-weight: 800;
        color: #fff;
    }

    .tb-msg-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .tb-msg-text {
        font-size: 12px;
        color: var(--text2);
        margin-top: 1px;
    }

    .tb-msg-time {
        font-size: 11px;
        color: var(--text3);
        margin-left: auto;
        flex-shrink: 0;
    }

    /* notif item */
    .tb-notif-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 11px 16px;
        text-decoration: none;
        transition: background .13s;
        border-bottom: 1px solid var(--border);
    }

    .tb-notif-item:last-of-type {
        border-bottom: none;
    }

    .tb-notif-item:hover {
        background: rgba(255, 255, 255, .03);
    }

    .tb-notif-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        font-size: 13px;
    }

    .tb-notif-icon.green {
        background: rgba(45, 212, 191, .12);
        color: #2dd4bf;
    }

    .tb-notif-icon.blue {
        background: rgba(99, 179, 237, .12);
        color: #63b3ed;
    }

    .tb-notif-icon.yellow {
        background: rgba(251, 191, 36, .12);
        color: #fbbf24;
    }

    .tb-notif-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .tb-notif-time {
        font-size: 11px;
        color: var(--text3);
        margin-top: 2px;
    }

    /* see all link */
    .tb-see-all {
        display: block;
        text-align: center;
        padding: 10px;
        font-size: 12px;
        font-weight: 600;
        color: var(--accent2);
        text-decoration: none;
        border-top: 1px solid var(--border);
        transition: background .13s;
    }

    .tb-see-all:hover {
        background: rgba(230, 57, 70, .06);
        color: var(--accent2);
    }

    /* user dropdown */
    .tb-user-btn {
        display: flex;
        align-items: center;
        gap: 9px;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 5px 12px 5px 6px;
        cursor: pointer;
        transition: all .15s;
        font-family: inherit;
    }

    .tb-user-btn:hover {
        border-color: rgba(255, 255, 255, .14);
    }

    .tb-user-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), #ff9f43);
        display: grid;
        place-items: center;
        font-family: 'Syne', sans-serif;
        font-size: 11px;
        font-weight: 800;
        color: #fff;
    }

    .tb-user-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .tb-user-chevron {
        font-size: 10px;
        color: var(--text3);
    }

    .tb-profile-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 16px;
        text-decoration: none;
        color: var(--text2);
        font-size: 13px;
        transition: all .13s;
        border-bottom: 1px solid var(--border);
    }

    .tb-profile-item:last-of-type {
        border-bottom: none;
    }

    .tb-profile-item:hover {
        background: rgba(255, 255, 255, .03);
        color: var(--text);
    }

    .tb-profile-item i {
        width: 16px;
        text-align: center;
    }

    .tb-logout-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 16px;
        color: var(--accent2);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        background: none;
        border: none;
        width: 100%;
        font-family: inherit;
        transition: background .13s;
        border-top: 1px solid var(--border);
    }

    .tb-logout-item:hover {
        background: rgba(230, 57, 70, .08);
    }
</style>

{{-- ── TOPBAR ── --}}
<nav class="topbar">

    {{-- Mobile toggle --}}
    <button class="topbar-toggle" onclick="document.querySelector('.sidebar').classList.toggle('open')">
        <i class="fa fa-bars"></i>
    </button>

    {{-- Search --}}
    <div class="topbar-search">
        <svg width="13" height="13" fill="none" stroke="#5a5f72" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8" />
            <line x1="21" y1="21" x2="16.65" y2="16.65" />
        </svg>
        <input type="text" placeholder="Cari sesuatu...">
    </div>

    <div class="topbar-right">

        {{-- Messages --}}
        <div class="tb-dropdown" id="ddMsg">
            <button class="topbar-icon-btn" onclick="toggleDD('ddMsg')">
                <i class="fa fa-envelope"></i>
                <span class="topbar-dot"></span>
            </button>
            <div class="tb-dropdown-menu">
                <div class="tb-dropdown-header">Pesan Masuk</div>
                @php
                $msgs = [
                ['name'=>'Budi Santoso', 'text'=>'Ada pembaruan data warga RT 03...', 'time'=>'5 mnt'],
                ['name'=>'Siti Rahayu', 'text'=>'Mohon konfirmasi surat keterangan...', 'time'=>'22 mnt'],
                ['name'=>'Andi Wijaya', 'text'=>'Pengajuan pindah domisili masuk.', 'time'=>'1 jam'],
                ];
                @endphp
                @foreach($msgs as $m)
                <a href="#" class="tb-msg-item">
                    <div class="tb-msg-avatar">{{ strtoupper(substr($m['name'],0,1)) }}</div>
                    <div style="min-width:0">
                        <div class="tb-msg-name">{{ $m['name'] }}</div>
                        <div class="tb-msg-text">{{ $m['text'] }}</div>
                    </div>
                    <span class="tb-msg-time">{{ $m['time'] }}</span>
                </a>
                @endforeach
                <a href="#" class="tb-see-all">Lihat semua pesan</a>
            </div>
        </div>

        {{-- Notifications --}}
        <div class="tb-dropdown" id="ddNotif">
            <button class="topbar-icon-btn" onclick="toggleDD('ddNotif')">
                <i class="fa fa-bell"></i>
                <span class="topbar-dot"></span>
            </button>
            <div class="tb-dropdown-menu">
                <div class="tb-dropdown-header">Notifikasi</div>
                <a href="#" class="tb-notif-item">
                    <div class="tb-notif-icon green"><i class="fa fa-user-check"></i></div>
                    <div>
                        <div class="tb-notif-title">Profil berhasil diperbarui</div>
                        <div class="tb-notif-time">15 menit lalu</div>
                    </div>
                </a>
                <a href="#" class="tb-notif-item">
                    <div class="tb-notif-icon blue"><i class="fa fa-user-plus"></i></div>
                    <div>
                        <div class="tb-notif-title">User baru ditambahkan</div>
                        <div class="tb-notif-time">1 jam lalu</div>
                    </div>
                </a>
                <a href="#" class="tb-notif-item">
                    <div class="tb-notif-icon yellow"><i class="fa fa-key"></i></div>
                    <div>
                        <div class="tb-notif-title">Password berhasil diubah</div>
                        <div class="tb-notif-time">3 jam lalu</div>
                    </div>
                </a>
                <a href="#" class="tb-see-all">Lihat semua notifikasi</a>
            </div>
        </div>

        {{-- User --}}
        <div class="tb-dropdown" id="ddUser">
            <button class="tb-user-btn" onclick="toggleDD('ddUser')">
                <div class="tb-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="tb-user-name">{{ Auth::user()->name }}</span>
                <i class="fa fa-chevron-down tb-user-chevron"></i>
            </button>
            <div class="tb-dropdown-menu" style="min-width:200px">
                <a href="#" class="tb-profile-item">
                    <i class="fa fa-user"></i> My Profile
                </a>
                <a href="#" class="tb-profile-item">
                    <i class="fa fa-cog"></i> Pengaturan
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="tb-logout-item">
                        <i class="fa fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>

<script>
    function toggleDD(id) {
        const all = document.querySelectorAll('.tb-dropdown');
        all.forEach(d => {
            if (d.id !== id) d.classList.remove('open');
        });
        document.getElementById(id).classList.toggle('open');
    }
    // close on outside click
    document.addEventListener('click', e => {
        if (!e.target.closest('.tb-dropdown')) {
            document.querySelectorAll('.tb-dropdown').forEach(d => d.classList.remove('open'));
        }
    });
</script>