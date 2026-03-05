@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
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
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
    }

    .dash-wrap {
        padding: 32px 28px;
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    /* ── PAGE HEADER ── */
    .page-hdr {
        animation: fadeUp .25s ease both;
    }

    .page-hdr-title {
        font-family: 'Syne', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -.4px;
    }

    .page-hdr-sub {
        color: var(--text3);
        font-size: 13px;
        margin-top: 3px;
    }

    /* ── STAT CARDS ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        animation: fadeUp .3s ease .05s both;
    }

    @media(max-width:1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width:600px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        overflow: hidden;
        transition: border-color .2s, transform .2s;
    }

    .stat-card:hover {
        border-color: rgba(255, 255, 255, .13);
        transform: translateY(-2px);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--card-color, var(--accent));
        border-radius: var(--radius) var(--radius) 0 0;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        font-size: 20px;
        background: color-mix(in srgb, var(--card-color, var(--accent)) 12%, transparent);
        color: var(--card-color, var(--accent));
        border: 1px solid color-mix(in srgb, var(--card-color, var(--accent)) 20%, transparent);
    }

    .stat-label {
        font-size: 12px;
        color: var(--text2);
        font-weight: 500;
    }

    .stat-value {
        font-family: 'Syne', sans-serif;
        font-size: 26px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -.5px;
        margin-top: 2px;
        line-height: 1;
    }

    /* ── WIDGETS GRID ── */
    .widgets-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        animation: fadeUp .35s ease .12s both;
    }

    @media(max-width:1100px) {
        .widgets-grid {
            grid-template-columns: 1fr;
        }
    }

    .widget-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .widget-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
    }

    .widget-title {
        font-family: 'Syne', sans-serif;
        font-size: 14px;
        font-weight: 800;
        color: var(--text);
    }

    .widget-link {
        font-size: 12px;
        color: var(--accent2);
        text-decoration: none;
        font-weight: 600;
    }

    .widget-link:hover {
        color: var(--accent);
    }

    .widget-body {
        padding: 8px 0;
    }

    /* ── MESSAGES ── */
    .msg-item {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding: 11px 20px;
        border-bottom: 1px solid var(--border);
        transition: background .13s;
    }

    .msg-item:last-child {
        border-bottom: none;
    }

    .msg-item:hover {
        background: rgba(255, 255, 255, .025);
    }

    .msg-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        flex-shrink: 0;
        background: linear-gradient(135deg, #63b3ed, #818cf8);
        display: grid;
        place-items: center;
        font-family: 'Syne', sans-serif;
        font-size: 13px;
        font-weight: 800;
        color: #fff;
    }

    .msg-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .msg-time {
        font-size: 11px;
        color: var(--text3);
    }

    .msg-text {
        font-size: 12.5px;
        color: var(--text2);
        margin-top: 2px;
    }

    /* ── CALENDAR ── */
    .calendar-wrap {
        padding: 16px 20px;
    }

    /* tinyish calendar */
    .cal-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .cal-month {
        font-family: 'Syne', sans-serif;
        font-size: 14px;
        font-weight: 800;
        color: var(--text);
    }

    .cal-nav {
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 7px;
        width: 28px;
        height: 28px;
        display: grid;
        place-items: center;
        cursor: pointer;
        color: var(--text2);
        font-size: 12px;
        transition: all .15s;
    }

    .cal-nav:hover {
        color: var(--text);
        border-color: rgba(255, 255, 255, .14);
    }

    .cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 3px;
    }

    .cal-day-name {
        text-align: center;
        font-size: 10px;
        font-weight: 700;
        color: var(--text3);
        text-transform: uppercase;
        padding: 4px 0;
    }

    .cal-day {
        text-align: center;
        font-size: 12.5px;
        padding: 5px 2px;
        border-radius: 7px;
        cursor: pointer;
        color: var(--text2);
        transition: background .13s;
    }

    .cal-day:hover {
        background: var(--surface2);
        color: var(--text);
    }

    .cal-day.today {
        background: var(--accent);
        color: #fff;
        font-weight: 700;
    }

    .cal-day.other {
        color: var(--text3);
    }

    .cal-day.empty {
        pointer-events: none;
    }

    /* ── TODO ── */
    .todo-input-row {
        display: flex;
        gap: 8px;
        padding: 12px 20px;
        border-bottom: 1px solid var(--border);
    }

    .todo-input {
        flex: 1;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 8px 12px;
        color: var(--text);
        font-size: 13px;
        font-family: inherit;
        transition: border-color .18s;
        outline: none;
    }

    .todo-input:focus {
        border-color: var(--accent);
    }

    .todo-input::placeholder {
        color: var(--text3);
    }

    .todo-add-btn {
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background .18s;
        white-space: nowrap;
    }

    .todo-add-btn:hover {
        background: var(--accent2);
    }

    .todo-list {
        padding: 4px 0;
    }

    .todo-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        border-bottom: 1px solid var(--border);
        transition: background .13s;
    }

    .todo-item:last-child {
        border-bottom: none;
    }

    .todo-item:hover {
        background: rgba(255, 255, 255, .02);
    }

    .todo-check {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        flex-shrink: 0;
        appearance: none;
        -webkit-appearance: none;
        background: var(--surface2);
        border: 1px solid var(--border);
        cursor: pointer;
        position: relative;
        transition: all .15s;
    }

    .todo-check:checked {
        background: var(--accent);
        border-color: var(--accent);
    }

    .todo-check:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-size: 10px;
    }

    .todo-text {
        flex: 1;
        font-size: 13px;
        color: var(--text2);
    }

    .todo-text.done {
        text-decoration: line-through;
        color: var(--text3);
    }

    .todo-del {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text3);
        font-size: 13px;
        padding: 2px 6px;
        border-radius: 5px;
        transition: all .13s;
    }

    .todo-del:hover {
        background: rgba(230, 57, 70, .1);
        color: var(--accent2);
    }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(12px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }
</style>
@endpush

@section('content')
<div class="dash-wrap">

    {{-- ── PAGE HEADER ── --}}
    <div class="page-hdr">
        <div class="page-hdr-title">Dashboard</div>
        <div class="page-hdr-sub">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }} 👋</div>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="stats-grid">

        <div class="stat-card" style="--card-color:#63b3ed">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
            <div>
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ \App\Models\User::count() }}</div>
            </div>
        </div>

        <div class="stat-card" style="--card-color:#a78bfa">
            <div class="stat-icon"><i class="fa fa-id-badge"></i></div>
            <div>
                <div class="stat-label">Total Jabatan</div>
                <div class="stat-value">{{ \App\Models\Jabatan::count() }}</div>
            </div>
        </div>

        <div class="stat-card" style="--card-color:#fbbf24">
            <div class="stat-icon"><i class="fa fa-home"></i></div>
            <div>
                <div class="stat-label">Total RT</div>
                <div class="stat-value">{{ \App\Models\Rukun::where('type','RT')->count() }}</div>
            </div>
        </div>

        <div class="stat-card" style="--card-color:#818cf8">
            <div class="stat-icon"><i class="fa fa-building"></i></div>
            <div>
                <div class="stat-label">Total RW</div>
                <div class="stat-value">{{ \App\Models\Rukun::where('type','RW')->count() }}</div>
            </div>
        </div>

        <div class="stat-card" style="--card-color:#e63946">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
            <div>
                <div class="stat-label">Total Keluarga</div>
                <div class="stat-value">{{ \App\Models\Family::count() }}</div>
            </div>
        </div>

        <div class="stat-card" style="--card-color:#2dd4bf">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
            <div>
                <div class="stat-label">Total Warga</div>
                <div class="stat-value">{{ \App\Models\Warga::count() }}</div>
            </div>
        </div>

        <div class="stat-card" style="--card-color:#60a5fa">
            <div class="stat-icon"><i class="fa fa-male"></i></div>
            <div>
                <div class="stat-label">Laki-laki</div>
                <div class="stat-value">{{ \App\Models\Warga::where('gender','L')->count() }}</div>
            </div>
        </div>

        <div class="stat-card" style="--card-color:#f472b6">
            <div class="stat-icon"><i class="fa fa-female"></i></div>
            <div>
                <div class="stat-label">Perempuan</div>
                <div class="stat-value">{{ \App\Models\Warga::where('gender','P')->count() }}</div>
            </div>
        </div>

    </div>

    {{-- ── WIDGETS ── --}}
    <div class="widgets-grid">

        {{-- Messages --}}
        <div class="widget-card">
            <div class="widget-header">
                <span class="widget-title">Messages</span>
                <a href="#" class="widget-link">Lihat Semua</a>
            </div>
            <div class="widget-body">
                @php
                $msgs = [
                ['name'=>'Budi Santoso', 'time'=>'5 menit lalu', 'text'=>'Ada pembaruan data warga RT 03...'],
                ['name'=>'Siti Rahayu', 'time'=>'22 menit lalu', 'text'=>'Mohon konfirmasi surat keterangan...'],
                ['name'=>'Andi Wijaya', 'time'=>'1 jam lalu', 'text'=>'Pengajuan pindah domisili sudah masuk.'],
                ['name'=>'Dewi Lestari', 'time'=>'3 jam lalu', 'text'=>'Data keluarga belum lengkap...'],
                ];
                @endphp
                @foreach($msgs as $m)
                <div class="msg-item">
                    <div class="msg-avatar">{{ strtoupper(substr($m['name'],0,1)) }}</div>
                    <div style="min-width:0">
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:8px">
                            <span class="msg-name">{{ $m['name'] }}</span>
                            <span class="msg-time">{{ $m['time'] }}</span>
                        </div>
                        <div class="msg-text">{{ $m['text'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Calendar --}}
        <div class="widget-card">
            <div class="widget-header">
                <span class="widget-title">Kalender</span>
            </div>
            <div class="calendar-wrap">
                <div class="cal-head">
                    <button class="cal-nav" id="calPrev">‹</button>
                    <span class="cal-month" id="calMonth"></span>
                    <button class="cal-nav" id="calNext">›</button>
                </div>
                <div class="cal-grid" id="calGrid"></div>
            </div>
        </div>

        {{-- To Do --}}
        <div class="widget-card">
            <div class="widget-header">
                <span class="widget-title">To Do List</span>
            </div>
            <div class="todo-input-row">
                <input class="todo-input" type="text" id="todoInput" placeholder="Tambah tugas baru...">
                <button class="todo-add-btn" id="todoAdd">Tambah</button>
            </div>
            <div class="todo-list" id="todoList">
                <div class="todo-item">
                    <input class="todo-check" type="checkbox">
                    <span class="todo-text">Verifikasi data warga baru</span>
                    <button class="todo-del">×</button>
                </div>
                <div class="todo-item">
                    <input class="todo-check" type="checkbox">
                    <span class="todo-text">Update data RT 05</span>
                    <button class="todo-del">×</button>
                </div>
                <div class="todo-item">
                    <input class="todo-check" type="checkbox" checked>
                    <span class="todo-text done">Cetak surat keterangan</span>
                    <button class="todo-del">×</button>
                </div>
                <div class="todo-item">
                    <input class="todo-check" type="checkbox">
                    <span class="todo-text">Rapat koordinasi RT/RW</span>
                    <button class="todo-del">×</button>
                </div>
            </div>
        </div>

    </div>

</div>{{-- /dash-wrap --}}
@endsection

@push('scripts')
<script>
    // ── CALENDAR ──
    (function() {
        const DAYS = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        let cur = new Date();
        const today = new Date();

        function render() {
            const y = cur.getFullYear(),
                m = cur.getMonth();
            document.getElementById('calMonth').textContent = MONTHS[m] + ' ' + y;

            const first = new Date(y, m, 1).getDay();
            const days = new Date(y, m + 1, 0).getDate();
            const prevD = new Date(y, m, 0).getDate();

            let html = DAYS.map(d => `<div class="cal-day-name">${d}</div>`).join('');

            for (let i = 0; i < first; i++) {
                html += `<div class="cal-day other">${prevD - first + i + 1}</div>`;
            }
            for (let d = 1; d <= days; d++) {
                const isToday = d === today.getDate() && m === today.getMonth() && y === today.getFullYear();
                html += `<div class="cal-day${isToday ? ' today' : ''}">${d}</div>`;
            }
            const remaining = 42 - first - days;
            for (let i = 1; i <= remaining; i++) {
                html += `<div class="cal-day other">${i}</div>`;
            }
            document.getElementById('calGrid').innerHTML = html;
        }

        document.getElementById('calPrev').addEventListener('click', () => {
            cur.setMonth(cur.getMonth() - 1);
            render();
        });
        document.getElementById('calNext').addEventListener('click', () => {
            cur.setMonth(cur.getMonth() + 1);
            render();
        });
        render();
    })();

    // ── TODO ──
    (function() {
        const input = document.getElementById('todoInput');
        const list = document.getElementById('todoList');

        function addItem(text) {
            if (!text.trim()) return;
            const item = document.createElement('div');
            item.className = 'todo-item';
            item.innerHTML = `
            <input class="todo-check" type="checkbox">
            <span class="todo-text">${text.trim()}</span>
            <button class="todo-del">×</button>`;
            list.appendChild(item);
            bindItem(item);
            input.value = '';
        }

        function bindItem(item) {
            item.querySelector('.todo-check').addEventListener('change', function() {
                item.querySelector('.todo-text').classList.toggle('done', this.checked);
            });
            item.querySelector('.todo-del').addEventListener('click', () => item.remove());
        }

        document.getElementById('todoAdd').addEventListener('click', () => addItem(input.value));
        input.addEventListener('keydown', e => {
            if (e.key === 'Enter') addItem(input.value);
        });

        // bind existing items
        document.querySelectorAll('.todo-item').forEach(bindItem);
    })();
</script>
@endpush