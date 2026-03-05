@php
$jabatan = session('user') ? session('user')->jabatan->slug : null;

$dashboardRoute = match($jabatan) {
'administrator' => route('dashboard.admin'),
'kepala_lurah' => route('dashboard.lurah'),
'sekre_lurah' => route('dashboard.sekre'),
'staff_pelayanan' => route('dashboard.staff'),
default => route('login')
};

$currentRoute = request()->route()?->getName();

function isActive(string|array $routes): string {
$current = request()->route()?->getName();
$routes = is_array($routes) ? $routes : [$routes];
foreach ($routes as $r) {
if (str_starts_with($current ?? '', $r)) return ' active';
}
return '';
}
@endphp

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
        --sidebar-w: 240px;
    }

    /* ── SIDEBAR SHELL ── */
    .sidebar {
        width: var(--sidebar-w);
        background: var(--surface);
        border-right: 1px solid var(--border);
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 200;
        scrollbar-width: thin;
        scrollbar-color: var(--border) transparent;
    }

    .sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 4px;
    }

    /* ── LOGO ── */
    .sb-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 22px 20px 18px;
        border-bottom: 1px solid var(--border);
        text-decoration: none;
        flex-shrink: 0;
    }

    .sb-logo-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--accent);
        display: grid;
        place-items: center;
        font-size: 17px;
        color: #fff;
        box-shadow: 0 0 18px rgba(230, 57, 70, .35);
        flex-shrink: 0;
    }

    .sb-logo-text {
        font-family: 'Syne', sans-serif;
        font-size: 16px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -.3px;
    }

    /* ── USER INFO ── */
    .sb-user {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        flex-shrink: 0;
    }

    .sb-user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--accent), #ff9f43);
        display: grid;
        place-items: center;
        font-family: 'Syne', sans-serif;
        font-size: 13px;
        font-weight: 800;
        color: #fff;
        position: relative;
    }

    .sb-user-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #2dd4bf;
        border: 2px solid var(--surface);
        position: absolute;
        bottom: 0;
        right: 0;
    }

    .sb-user-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .sb-user-role {
        font-size: 11px;
        color: var(--text3);
        margin-top: 1px;
    }

    /* ── NAV ── */
    .sb-nav {
        flex: 1;
        padding: 12px 0 20px;
    }

    .sb-section-label {
        font-size: 9.5px;
        font-weight: 700;
        letter-spacing: 1.3px;
        text-transform: uppercase;
        color: var(--text3);
        padding: 14px 20px 5px;
    }

    /* single link */
    .sb-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 20px;
        color: var(--text2);
        font-size: 13.5px;
        font-weight: 500;
        text-decoration: none;
        border-left: 3px solid transparent;
        transition: all .15s ease;
        cursor: pointer;
    }

    .sb-link:hover {
        color: var(--text);
        background: rgba(255, 255, 255, .04);
    }

    .sb-link.active {
        color: var(--accent2);
        border-left-color: var(--accent);
        background: rgba(230, 57, 70, .07);
        font-weight: 600;
    }

    .sb-link svg,
    .sb-link i {
        flex-shrink: 0;
        width: 16px;
        text-align: center;
        opacity: .75;
    }

    .sb-link.active svg,
    .sb-link.active i {
        opacity: 1;
    }

    /* dropdown group */
    .sb-group {}

    .sb-group-toggle {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 20px;
        color: var(--text2);
        font-size: 13.5px;
        font-weight: 500;
        border-left: 3px solid transparent;
        cursor: pointer;
        user-select: none;
        transition: all .15s ease;
        list-style: none;
    }

    .sb-group-toggle:hover {
        color: var(--text);
        background: rgba(255, 255, 255, .04);
    }

    .sb-group-toggle.open,
    .sb-group-toggle.child-active {
        color: var(--text);
    }

    .sb-group-toggle.child-active {
        border-left-color: var(--accent);
        background: rgba(230, 57, 70, .05);
    }

    .sb-group-toggle i,
    .sb-group-toggle svg {
        flex-shrink: 0;
        width: 16px;
        text-align: center;
        opacity: .75;
    }

    .sb-group-toggle.child-active i,
    .sb-group-toggle.child-active svg {
        opacity: 1;
    }

    .sb-chevron {
        margin-left: auto;
        font-size: 10px;
        color: var(--text3);
        transition: transform .2s ease;
    }

    .sb-group-toggle.open .sb-chevron {
        transform: rotate(90deg);
    }

    .sb-children {
        overflow: hidden;
        max-height: 0;
        transition: max-height .25s ease;
    }

    .sb-children.open {
        max-height: 400px;
    }

    .sb-child {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 7px 20px 7px 46px;
        color: var(--text3);
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all .13s;
        border-left: 3px solid transparent;
        position: relative;
    }

    .sb-child::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--text3);
        flex-shrink: 0;
        transition: background .13s;
    }

    .sb-child:hover {
        color: var(--text2);
    }

    .sb-child:hover::before {
        background: var(--text2);
    }

    .sb-child.active {
        color: var(--accent2);
        font-weight: 600;
        border-left-color: var(--accent);
        background: rgba(230, 57, 70, .06);
    }

    .sb-child.active::before {
        background: var(--accent);
    }

    /* ── LOGOUT ── */
    .sb-logout {
        margin: 8px 14px 0;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px 14px;
        background: rgba(230, 57, 70, .08);
        border: 1px solid rgba(230, 57, 70, .15);
        border-radius: var(--radius-sm);
        color: var(--accent2);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all .18s;
        font-family: inherit;
    }

    .sb-logout:hover {
        background: rgba(230, 57, 70, .16);
        color: var(--accent2);
    }
</style>

<div class="sidebar">

    {{-- LOGO --}}
    <a href="{{ $dashboardRoute }}" class="sb-logo">
        <div class="sb-logo-icon">📋</div>
        <span class="sb-logo-text">Surat Desa</span>
    </a>

    {{-- USER --}}
    <div class="sb-user">
        <div class="sb-user-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            <span class="sb-user-dot"></span>
        </div>
        <div style="min-width:0">
            <div class="sb-user-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                {{ Auth::user()->name }}
            </div>
            <div class="sb-user-role" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                {{ Auth::user()->email }}
            </div>
        </div>
    </div>

    {{-- NAV --}}
    <nav class="sb-nav">

        <div class="sb-section-label">Menu Utama</div>

        <a href="{{ route('dashboard.admin') }}"
            class="sb-link{{ isActive('dashboard') }}">
            <i class="fa fa-tachometer-alt"></i>
            Dashboard
        </a>

        <div class="sb-section-label">Manajemen</div>

        {{-- User --}}
        <div class="sb-group">
            <div class="sb-group-toggle{{ isActive('users') }}"
                onclick="toggleGroup(this)">
                <i class="fa fa-users"></i>
                <span>User</span>
                <i class="fa fa-chevron-right sb-chevron"></i>
            </div>
            <div class="sb-children{{ isActive('users') ? ' open' : '' }}">
                <a href="{{ route('users.index') }}"
                    class="sb-child{{ isActive('users.index') }}">
                    User Management
                </a>
            </div>
        </div>

        {{-- Warga --}}
        <div class="sb-group">
            <div class="sb-group-toggle{{ isActive(['rukun','family','warga']) }}"
                onclick="toggleGroup(this)">
                <i class="fa fa-city"></i>
                <span>Warga</span>
                <i class="fa fa-chevron-right sb-chevron"></i>
            </div>
            <div class="sb-children{{ isActive(['rukun','family','warga']) ? ' open' : '' }}">
                <a href="{{ route('rukun.index') }}"
                    class="sb-child{{ isActive('rukun') }}">
                    Rukun (RT/RW)
                </a>
                <a href="{{ route('family.index') }}"
                    class="sb-child{{ isActive('family') }}">
                    Keluarga
                </a>
                <a href="{{ route('warga.index') }}"
                    class="sb-child{{ isActive('warga') }}">
                    Data Warga
                </a>
            </div>
        </div>

        {{-- Surat --}}
        <div class="sb-group">
            <div class="sb-group-toggle{{ isActive(['ahli_waris','akte_kematian','domisili','pindah_keluar','sktm','arsip']) }}"
                onclick="toggleGroup(this)">
                <i class="fa fa-file-alt"></i>
                <span>Surat</span>
                <i class="fa fa-chevron-right sb-chevron"></i>
            </div>
            <div class="sb-children{{ isActive(['ahli_waris','akte_kematian','domisili','pindah_keluar','sktm','arsip']) ? ' open' : '' }}">
                <a href="{{ route('ahli_waris.index') }}"
                    class="sb-child{{ isActive('ahli_waris') }}">
                    Ahli Waris
                </a>
                <a href="{{ route('akte_kematian.index') }}"
                    class="sb-child{{ isActive('akte_kematian') }}">
                    Kematian
                </a>
                <a href="{{ route('domisili.index') }}"
                    class="sb-child{{ isActive('domisili') }}">
                    Domisili
                </a>
                <a href="{{ route('pindah_keluar.index') }}"
                    class="sb-child{{ isActive('pindah_keluar') }}">
                    Pindah Keluar
                </a>
                <a href="{{ route('sktm.index') }}"
                    class="sb-child{{ isActive('sktm') }}">
                    Tidak Mampu (SKTM)
                </a>
                <a href="{{ route('arsip.index') }}"
                    class="sb-child{{ isActive('arsip') }}">
                    Arsip Surat
                </a>
            </div>
        </div>

        <div class="sb-section-label">Lainnya</div>

        <a href="{{ route('lurah_config.index') }}"
            class="sb-link{{ isActive('lurah_config.index') }}">
            <i class="fa fa-keyboard"></i>
            Luragh Config
        </a>

    </nav>

    {{-- LOGOUT --}}
    <form action="{{ route('logout') }}" method="POST" style="padding: 0 0 16px;">
        @csrf
        <button type="submit" class="sb-logout">
            <i class="fa fa-sign-out-alt"></i>
            Keluar
        </button>
    </form>

</div>

<script>
    function toggleGroup(el) {
        const children = el.nextElementSibling;
        const isOpen = children.classList.contains('open');
        // close all
        document.querySelectorAll('.sb-children.open').forEach(c => {
            c.classList.remove('open');
            c.previousElementSibling.classList.remove('open');
        });
        // open clicked if it was closed
        if (!isOpen) {
            children.classList.add('open');
            el.classList.add('open');
        }
    }
</script>