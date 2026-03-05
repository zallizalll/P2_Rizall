@extends('layouts.app')

@section('title', 'Data Keluarga')

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

    .fam-wrap {
        padding: 32px 28px;
    }

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

    .fam-alert {
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

    .fam-alert.success {
        background: rgba(45, 212, 191, .1);
        border: 1px solid rgba(45, 212, 191, .2);
        color: #2dd4bf;
    }

    .fam-alert.danger {
        background: rgba(230, 57, 70, .1);
        border: 1px solid rgba(230, 57, 70, .2);
        color: var(--accent2);
    }

    .fam-alert ul {
        margin: 0;
        padding-left: 16px;
    }

    .fam-alert .cls {
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

    .fam-alert .cls:hover {
        opacity: 1;
    }

    .fam-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        animation: fadeUp .35s ease .08s both;
    }

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

    .fam-table-wrap {
        overflow-x: auto;
    }

    .fam-table {
        width: 100%;
        border-collapse: collapse;
    }

    .fam-table thead tr {
        border-bottom: 1px solid var(--border);
    }

    .fam-table thead th {
        padding: 11px 16px;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text3);
        white-space: nowrap;
        text-align: left;
    }

    .fam-table thead th.tc {
        text-align: center;
    }

    .fam-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .13s;
    }

    .fam-table tbody tr:last-child {
        border-bottom: none;
    }

    .fam-table tbody tr:hover {
        background: rgba(255, 255, 255, .025);
    }

    .fam-table tbody td {
        padding: 12px 16px;
        font-size: 13px;
        color: var(--text2);
        vertical-align: middle;
    }

    .fam-table tbody td.tc {
        text-align: center;
    }

    .fam-table tbody td:first-child {
        color: var(--text3);
        font-size: 12px;
    }

    .code-val {
        font-family: 'Syne', monospace;
        font-size: 11.5px;
        font-weight: 700;
        color: var(--text);
        letter-spacing: .4px;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 5px;
        padding: 2px 8px;
    }

    .pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .pill-rt {
        background: rgba(251, 191, 36, .1);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, .2);
    }

    .pill-rw {
        background: rgba(129, 140, 248, .1);
        color: #818cf8;
        border: 1px solid rgba(129, 140, 248, .2);
    }

    .kk-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 4px 11px;
        font-size: 12.5px;
        color: var(--text);
        font-weight: 500;
    }

    .kk-chip-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--accent);
        flex-shrink: 0;
    }

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

    .modal-body textarea.form-control {
        min-height: 80px;
        resize: vertical;
    }

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
<div class="fam-wrap">

    {{-- PAGE HEADER --}}
    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">Data Keluarga</div>
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard.admin') }}">Dashboard</a>
                <span class="sep">›</span>
                <span class="cur">Keluarga</span>
            </div>
        </div>
        <div class="hdr-actions">
            <button class="btn-wp primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fa fa-plus"></i> Tambah Keluarga
            </button>
        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
    <div class="fam-alert success" id="alertOk">
        <i class="fa fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    @if($errors->any())
    <div class="fam-alert danger" id="alertErr">
        <i class="fa fa-exclamation-circle" style="margin-top:2px;flex-shrink:0"></i>
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="fam-card">
        <div class="fam-table-wrap">
            <table class="fam-table">
                <thead>
                    <tr>
                        <th class="tc" style="width:46px">#</th>
                        <th>No KK</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Alamat</th>
                        <th>Kepala Keluarga</th>
                        <th class="tc" style="width:110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($families as $i => $row)
                    <tr>
                        <td class="tc">{{ $i + 1 }}</td>
                        <td><span class="code-val">{{ $row->no_kk }}</span></td>
                        <td><span class="pill pill-rt">{{ $row->rt?->no ?? '—' }}</span></td>
                        <td><span class="pill pill-rw">{{ $row->rw?->no ?? '—' }}</span></td>
                        <td>{{ $row->address }}</td>
                        <td>
                            @if($row->familyHead)
                            <span class="kk-chip">
                                <span class="kk-chip-dot"></span>
                                {{ $row->familyHead->name }}
                            </span>
                            @else
                            <span style="color:var(--text3)">—</span>
                            @endif
                        </td>
                        <td class="tc" style="white-space:nowrap">
                            <button class="btn-wp info"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $row->id }}"
                                title="Edit">
                                <i class="fa fa-edit"></i>
                            </button>
                            <form action="{{ route('family.destroy', $row->id) }}"
                                method="POST" class="d-inline ms-1">
                                @csrf @method('DELETE')
                                <button class="btn-wp danger" title="Hapus"
                                    onclick="return confirm('Hapus data ini?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">🏠</div>
                                <h4>Belum ada data keluarga</h4>
                                <p>Tambahkan data keluarga untuk mulai mengelola data warga.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- EDIT MODALS --}}
    @foreach($families as $row)
    <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('family.update', $row->id) }}" method="POST" class="modal-content">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Keluarga — <span style="color:var(--accent2)">{{ $row->no_kk }}</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">No KK <span class="req">*</span></label>
                            <input type="text" name="no_kk" class="form-control"
                                value="{{ $row->no_kk }}"
                                maxlength="16" minlength="16"
                                pattern="\d{16}"
                                title="No KK harus 16 digit angka"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">RT <span class="req">*</span></label>
                            <select name="rt_id" class="form-select" required>
                                @foreach($rtList as $rt)
                                <option value="{{ $rt->id }}" {{ $row->rt_id == $rt->id ? 'selected' : '' }}>
                                    RT {{ $rt->no }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">RW <span class="req">*</span></label>
                            <select name="rw_id" class="form-select" required>
                                @foreach($rwList as $rw)
                                <option value="{{ $rw->id }}" {{ $row->rw_id == $rw->id ? 'selected' : '' }}>
                                    RW {{ $rw->no }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat <span class="req">*</span></label>
                            <textarea name="address" class="form-control" required>{{ $row->address }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Kepala Keluarga</label>
                            <select name="family_head_id" class="form-select">
                                <option value="">— Pilih Kepala Keluarga —</option>
                                @foreach($wargaList as $w)
                                <option value="{{ $w->id }}" {{ $row->family_head_id == $w->id ? 'selected' : '' }}>
                                    {{ $w->name }} — {{ $w->nik }}
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

    {{-- ADD MODAL --}}
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('family.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Keluarga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">No KK <span class="req">*</span></label>
                            <input type="text" name="no_kk" class="form-control"
                                maxlength="16" minlength="16"
                                pattern="\d{16}"
                                title="No KK harus 16 digit angka"
                                placeholder="Nomor Kartu Keluarga (16 digit)"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">RT <span class="req">*</span></label>
                            <select class="form-select" name="rt_id" required>
                                <option value="">— Pilih RT —</option>
                                @foreach($rtList->where('type', 'RT') as $rt)
                                <option value="{{ $rt->id }}">RT {{ $rt->no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">RW <span class="req">*</span></label>
                            <select class="form-select" name="rw_id" required>
                                <option value="">— Pilih RW —</option>
                                @foreach($rwList as $rw)
                                <option value="{{ $rw->id }}">RW {{ $rw->no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat <span class="req">*</span></label>
                            <textarea name="address" class="form-control" placeholder="Alamat lengkap" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Kepala Keluarga</label>
                            <select name="family_head_id" class="form-select">
                                <option value="">— Pilih Kepala Keluarga —</option>
                                @foreach($wargaList as $w)
                                <option value="{{ $w->id }}">{{ $w->name }} — {{ $w->nik }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-wp ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-wp primary">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Auto-hide alerts after 3 seconds
    setTimeout(() => {
        ['alertOk', 'alertErr'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.style.transition = 'opacity .5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }
        });
    }, 3000);

    // Only allow numbers in No KK input
    document.querySelectorAll('input[name="no_kk"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    });
</script>
@endpush