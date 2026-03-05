@extends('layouts.app')

@section('title', 'Kelola User')

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

    .user-wrap {
        padding: 32px 28px;
    }

    /* ── PAGE HEADER ── */
    .page-hdr {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 24px;
        animation: fadeUp .3s ease both;
    }

    .page-hdr-title {
        font-family: 'Syne', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -.4px;
    }

    .breadcrumb-custom {
        display: flex;
        gap: 6px;
        align-items: center;
        margin-top: 4px;
    }

    .breadcrumb-custom a {
        color: var(--text3);
        font-size: 12px;
        text-decoration: none;
    }

    .breadcrumb-custom a:hover {
        color: var(--text2);
    }

    .breadcrumb-custom .sep {
        color: var(--text3);
        font-size: 11px;
    }

    .breadcrumb-custom .cur {
        color: var(--text2);
        font-size: 12px;
    }

    .hdr-actions {
        display: flex;
        gap: 10px;
    }

    /* ── ALERT ── */
    .user-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 18px;
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-weight: 500;
        margin-bottom: 20px;
        animation: slideDown .3s ease;
    }

    .user-alert.success {
        background: rgba(45, 212, 191, .1);
        border: 1px solid rgba(45, 212, 191, .2);
        color: #2dd4bf;
    }

    .user-alert.danger {
        background: rgba(230, 57, 70, .1);
        border: 1px solid rgba(230, 57, 70, .2);
        color: var(--accent2);
    }

    .user-alert ul {
        margin: 0;
        padding-left: 16px;
    }

    .user-alert .cls {
        margin-left: auto;
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        opacity: .6;
        font-size: 17px;
        line-height: 1;
        flex-shrink: 0;
    }

    .user-alert .cls:hover {
        opacity: 1;
    }

    /* ── CARD ── */
    .user-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        animation: fadeUp .35s ease .08s both;
    }

    /* ── BUTTONS ── */
    .btn-wp {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border-radius: var(--radius-sm);
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        border: none;
        transition: all .18s ease;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-wp.primary {
        background: var(--accent);
        color: #fff;
        box-shadow: 0 4px 16px rgba(230, 57, 70, .3);
    }

    .btn-wp.primary:hover {
        background: var(--accent2);
        color: #fff;
        box-shadow: 0 6px 22px rgba(230, 57, 70, .45);
        transform: translateY(-1px);
    }

    .btn-wp.info {
        background: rgba(99, 179, 237, .12);
        color: #63b3ed;
        border: 1px solid rgba(99, 179, 237, .2);
        padding: 5px 11px;
        font-size: 12px;
    }

    .btn-wp.info:hover {
        background: rgba(99, 179, 237, .22);
    }

    .btn-wp.danger {
        background: rgba(230, 57, 70, .1);
        color: var(--accent2);
        border: 1px solid rgba(230, 57, 70, .18);
        padding: 5px 11px;
        font-size: 12px;
    }

    .btn-wp.danger:hover {
        background: rgba(230, 57, 70, .2);
    }

    .btn-wp.ghost {
        background: var(--surface2);
        color: var(--text2);
        border: 1px solid var(--border);
        padding: 8px 16px;
    }

    .btn-wp.ghost:hover {
        color: var(--text);
        border-color: rgba(255, 255, 255, .14);
    }

    /* ── TABLE ── */
    .user-table-wrap {
        overflow-x: auto;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
    }

    .user-table thead tr {
        border-bottom: 1px solid var(--border);
    }

    .user-table thead th {
        padding: 11px 16px;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text3);
        white-space: nowrap;
        text-align: left;
    }

    .user-table thead th.tc {
        text-align: center;
    }

    .user-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .13s;
    }

    .user-table tbody tr:last-child {
        border-bottom: none;
    }

    .user-table tbody tr:hover {
        background: rgba(255, 255, 255, .025);
    }

    .user-table tbody td {
        padding: 12px 16px;
        font-size: 13px;
        color: var(--text2);
        vertical-align: middle;
    }

    .user-table tbody td.tc {
        text-align: center;
    }

    .user-table tbody td:first-child {
        color: var(--text3);
        font-size: 12px;
    }

    /* avatar + name */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--accent), #ff9f43);
        display: grid;
        place-items: center;
        font-family: 'Syne', sans-serif;
        font-size: 12px;
        font-weight: 800;
        color: #fff;
    }

    .user-name {
        font-weight: 600;
        color: var(--text);
        font-size: 13.5px;
    }

    .user-email {
        font-size: 12px;
        color: var(--text3);
    }

    /* phone */
    .phone-val {
        font-family: 'Syne', monospace;
        font-size: 12px;
        font-weight: 700;
        color: var(--text);
        letter-spacing: .3px;
    }

    /* jabatan badge */
    .jabatan-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(99, 179, 237, .1);
        color: #63b3ed;
        border: 1px solid rgba(99, 179, 237, .2);
        border-radius: 20px;
        padding: 3px 11px;
        font-size: 12px;
        font-weight: 600;
    }

    .jabatan-none {
        color: var(--text3);
        font-size: 12px;
    }

    /* date */
    .date-val {
        font-size: 12.5px;
        color: var(--text3);
    }

    /* self badge */
    .self-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .5px;
        background: rgba(230, 57, 70, .1);
        color: var(--accent2);
        border: 1px solid rgba(230, 57, 70, .2);
        margin-left: 6px;
        vertical-align: middle;
    }

    /* empty state */
    .empty-state {
        text-align: center;
        padding: 56px 20px;
    }

    .empty-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--surface2);
        border: 1px solid var(--border);
        display: grid;
        place-items: center;
        margin: 0 auto 14px;
        font-size: 24px;
    }

    .empty-state h4 {
        font-size: 15px;
        color: var(--text);
        font-weight: 600;
    }

    .empty-state p {
        color: var(--text3);
        font-size: 13px;
        margin-top: 5px;
    }

    /* ── MODAL ── */
    .modal-content {
        background: var(--surface) !important;
        border: 1px solid var(--border) !important;
        border-radius: var(--radius) !important;
    }

    .modal-header {
        border-bottom: 1px solid var(--border) !important;
        padding: 18px 22px !important;
    }

    .modal-header .modal-title {
        font-family: 'Syne', sans-serif;
        font-size: 16px;
        font-weight: 800;
        color: var(--text);
    }

    .modal-header .btn-close {
        filter: invert(1) opacity(.45);
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 22px !important;
    }

    .modal-footer {
        border-top: 1px solid var(--border) !important;
        padding: 14px 22px !important;
    }

    .modal-body .form-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--text3);
        margin-bottom: 6px;
        display: block;
    }

    .modal-body .req {
        color: var(--accent);
    }

    .modal-body .form-control,
    .modal-body .form-select {
        background: var(--surface2) !important;
        border: 1px solid var(--border) !important;
        border-radius: var(--radius-sm) !important;
        color: var(--text) !important;
        font-family: inherit;
        font-size: 13.5px;
        padding: 9px 14px !important;
        transition: border-color .18s;
    }

    .modal-body .form-control:focus,
    .modal-body .form-select:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px rgba(230, 57, 70, .12) !important;
        outline: none;
    }

    .modal-body .form-select option {
        background: var(--surface2);
        color: var(--text);
    }

    .modal-body .form-control::placeholder {
        color: var(--text3);
    }

    .modal-body .hint {
        font-size: 11px;
        color: var(--text3);
        margin-top: 5px;
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

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-8px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }
</style>
@endpush

@section('content')
<div class="user-wrap">

    {{-- ── PAGE HEADER ── --}}
    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">Kelola User</div>
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard.admin') }}">Dashboard</a>
                <span class="sep">›</span>
                <span class="cur">User</span>
            </div>
        </div>
        <div class="hdr-actions">
            <button class="btn-wp primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fa fa-user-plus"></i> Tambah User
            </button>
        </div>
    </div>

    {{-- ── ALERTS ── --}}
    @if(session('success'))
    <div class="user-alert success" id="alertOk">
        <i class="fa fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    @if(session('error'))
    <div class="user-alert danger" id="alertSessionErr">
        <i class="fa fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
        <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    @if($errors->any())
    <div class="user-alert danger" id="alertErr">
        <i class="fa fa-exclamation-circle" style="margin-top:2px;flex-shrink:0"></i>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    {{-- ── TABLE CARD ── --}}
    <div class="user-card">
        <div class="user-table-wrap">
            <table class="user-table">
                <thead>
                    <tr>
                        <th class="tc" style="width:46px">#</th>
                        <th>User</th>
                        <th>No. HP</th>
                        <th>Jabatan</th>
                        <th>Dibuat</th>
                        <th class="tc" style="width:110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td class="tc">{{ $index + 1 }}</td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="user-name">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                        <span class="self-badge">Anda</span>
                                        @endif
                                    </div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->detail?->no_hp)
                            <span class="phone-val">{{ $user->detail->no_hp }}</span>
                            @else
                            <span style="color:var(--text3)">—</span>
                            @endif
                        </td>
                        <td>
                            @if($user->jabatan)
                            <span class="jabatan-badge">{{ $user->jabatan->name }}</span>
                            @else
                            <span class="jabatan-none">—</span>
                            @endif
                        </td>
                        <td><span class="date-val">{{ $user->created_at->format('d M Y') }}</span></td>
                        <td class="tc" style="white-space:nowrap">
                            <button class="btn-wp info"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal{{ $user->id }}"
                                title="Edit">
                                <i class="fa fa-edit"></i>
                            </button>

                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline ms-1">
                                @csrf @method('DELETE')
                                <button class="btn-wp danger" title="Hapus"
                                    onclick="return confirm('Hapus user {{ $user->name }}?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">👤</div>
                                <h4>Belum ada data user</h4>
                                <p>Tambahkan user untuk memberikan akses ke sistem.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- ── ADD MODAL ── --}}
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('users.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama <span class="req">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Nama lengkap" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email <span class="req">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="email@example.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Password <span class="req">*</span></label>
                            <input type="password" class="form-control" name="password" placeholder="Min. 8 karakter" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">No HP</label>
                            <input type="text" class="form-control" name="no_hp" placeholder="08xxxxxxxxx">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Jabatan</label>
                            <select name="jabatan_id" class="form-select">
                                <option value="">— Pilih Jabatan —</option>
                                @foreach($jabatans as $jabatan)
                                <option value="{{ $jabatan->id }}">{{ $jabatan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-wp ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-wp primary">
                        <i class="fa fa-user-plus"></i> Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ── EDIT MODALS ── --}}
    @foreach($users as $user)
    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="modal-content">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit User — <span style="color:var(--accent2)">{{ $user->name }}</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama <span class="req">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email <span class="req">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password"
                                placeholder="Kosongkan jika tidak diubah">
                            <div class="hint">Biarkan kosong jika tidak ingin mengganti password.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">No HP</label>
                            <input type="text" class="form-control" name="no_hp"
                                value="{{ $user->detail->no_hp ?? '' }}" placeholder="08xxxxxxxxx">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Jabatan</label>
                            <select name="jabatan_id" class="form-select">
                                <option value="">— Pilih Jabatan —</option>
                                @foreach($jabatans as $jabatan)
                                <option value="{{ $jabatan->id }}"
                                    {{ $jabatan->id == $user->jabatan_id ? 'selected' : '' }}>
                                    {{ $jabatan->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-wp ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-wp primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

</div>{{-- /user-wrap --}}
@endsection

@push('scripts')
<script>
    setTimeout(() => {
        ['alertOk', 'alertSessionErr', 'alertErr'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.style.transition = 'opacity .5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }
        });
    }, 3000);
</script>
@endpush