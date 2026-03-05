@extends('layouts.app')

@section('title', 'Data Warga')

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

    /* ── WRAP ── */
    .warga-wrap {
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

    .page-hdr-title span {
        display: block;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 400;
        color: var(--text3);
        margin-top: 3px;
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
    .warga-alert {
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

    .warga-alert.success {
        background: rgba(45, 212, 191, .1);
        border: 1px solid rgba(45, 212, 191, .2);
        color: #2dd4bf;
    }

    .warga-alert.danger {
        background: rgba(230, 57, 70, .1);
        border: 1px solid rgba(230, 57, 70, .2);
        color: var(--accent2);
    }

    .warga-alert ul {
        margin: 0;
        padding-left: 16px;
    }

    .warga-alert .cls {
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

    .warga-alert .cls:hover {
        opacity: 1;
    }

    /* ── CARD ── */
    .warga-card {
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
        box-shadow: 0 6px 22px rgba(230, 57, 70, .45);
        transform: translateY(-1px);
        color: #fff;
    }

    .btn-wp.success {
        background: rgba(45, 212, 191, .12);
        color: #2dd4bf;
        border: 1px solid rgba(45, 212, 191, .22);
    }

    .btn-wp.success:hover {
        background: rgba(45, 212, 191, .22);
        color: #2dd4bf;
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
    .warga-table-wrap {
        overflow-x: auto;
    }

    .warga-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .warga-table thead tr {
        border-bottom: 1px solid var(--border);
    }

    .warga-table thead th {
        padding: 11px 16px;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text3);
        white-space: nowrap;
        text-align: left;
    }

    .warga-table thead th.tc {
        text-align: center;
    }

    .warga-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .13s;
    }

    .warga-table tbody tr:last-child {
        border-bottom: none;
    }

    .warga-table tbody tr:hover {
        background: rgba(255, 255, 255, .025);
    }

    .warga-table tbody td {
        padding: 12px 16px;
        font-size: 13px;
        color: var(--text2);
        vertical-align: middle;
    }

    .warga-table tbody td.tc {
        text-align: center;
    }

    .warga-table tbody td:first-child {
        color: var(--text3);
        font-size: 12px;
    }

    /* code-like NIK/KK */
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

    /* name */
    .name-val {
        font-weight: 600;
        color: var(--text);
        font-size: 13.5px;
    }

    /* badge */
    .badge-wp {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-L {
        background: rgba(99, 179, 237, .12);
        color: #63b3ed;
        border: 1px solid rgba(99, 179, 237, .2);
    }

    .badge-P {
        background: rgba(233, 30, 140, .12);
        color: #f472b6;
        border: 1px solid rgba(233, 30, 140, .2);
    }

    .badge-hidup {
        background: rgba(45, 212, 191, .1);
        color: #2dd4bf;
        border: 1px solid rgba(45, 212, 191, .2);
    }

    .badge-meninggal {
        background: rgba(230, 57, 70, .1);
        color: #ff6b6b;
        border: 1px solid rgba(230, 57, 70, .2);
    }

    .badge-pindah {
        background: rgba(251, 191, 36, .1);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, .2);
    }

    .badge-default {
        background: rgba(139, 144, 160, .1);
        color: var(--text2);
        border: 1px solid var(--border);
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
<div class="warga-wrap">

    {{-- ── PAGE HEADER ── --}}
    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">
                Data Warga
            </div>
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard.admin') }}">Dashboard</a>
                <span class="sep">›</span>
                <span class="cur">Warga</span>
            </div>
        </div>
        <div class="hdr-actions">
            <a href="{{ route('warga.import') }}" class="btn-wp success">
                <i class="fa fa-file-excel"></i> Import Excel
            </a>
            <button class="btn-wp primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fa fa-plus"></i> Tambah Warga
            </button>
        </div>
    </div>

    {{-- ── ALERTS ── --}}
    @if(session('success'))
    <div class="warga-alert success" id="alertOk">
        <i class="fa fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    @if($errors->any())
    <div class="warga-alert danger" id="alertErr">
        <i class="fa fa-exclamation-circle" style="margin-top:2px;flex-shrink:0"></i>
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    {{-- ── TABLE CARD ── --}}
    <div class="warga-card">
        <div class="warga-table-wrap">
            <table class="warga-table">
                <thead>
                    <tr>
                        <th class="tc" style="width:46px">#</th>
                        <th>NIK</th>
                        <th>No KK</th>
                        <th>Nama</th>
                        <th class="tc">Gender</th>
                        <th>TTL</th>
                        <th>Status Hidup</th>
                        <th>Pendidikan</th>
                        <th>Status Kawin</th>
                        <th>Pekerjaan</th>
                        <th class="tc" style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wargas as $i => $row)
                    <tr>
                        <td class="tc">{{ $i + 1 }}</td>
                        <td><span class="code-val">{{ $row->nik }}</span></td>
                        <td><span class="code-val">{{ $row->no_kk }}</span></td>
                        <td><span class="name-val">{{ $row->name }}</span></td>
                        <td class="tc">
                            @if($row->gender == 'L')
                            <span class="badge-wp badge-L">Laki-laki</span>
                            @else
                            <span class="badge-wp badge-P">Perempuan</span>
                            @endif
                        </td>
                        <td>{{ $row->birth_place }}, {{ \Carbon\Carbon::parse($row->birth_date)->isoFormat('D MMM Y') }}</td>
                        <td>
                            @php
                            $sc = match($row->living_status) {
                            'hidup' => 'hidup',
                            'meninggal'=> 'meninggal',
                            'pindah' => 'pindah',
                            default => 'default'
                            };
                            @endphp
                            <span class="badge-wp badge-{{ $sc }}">{{ ucfirst(str_replace('_', ' ', $row->living_status)) }}</span>
                        </td>
                        <td>{{ $row->education ?? '—' }}</td>
                        <td>{{ $row->married_status ?? '—' }}</td>
                        <td>{{ $row->occupation ?? '—' }}</td>
                        <td class="tc" style="white-space:nowrap">
                            <button class="btn-wp info"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $row->id }}"
                                title="Edit">
                                <i class="fa fa-edit"></i>
                            </button>
                            <form action="{{ route('warga.destroy', $row->id) }}"
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
                        <td colspan="11">
                            <div class="empty-state">
                                <div class="empty-icon">👥</div>
                                <h4>Belum ada data warga</h4>
                                <p>Tambahkan data warga atau import dari file Excel.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- ── ADD MODAL ── --}}
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('warga.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Warga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIK <span class="req">*</span></label>
                            <input type="text" name="nik" class="form-control" maxlength="16" placeholder="16 digit NIK">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No KK</label>
                            <select name="no_kk" class="form-select">
                                <option value="">— Tanpa KK —</option>
                                @foreach($familyList as $fam)
                                <option value="{{ $fam->no_kk }}">{{ $fam->no_kk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Nama lengkap">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="birth_place" class="form-control" placeholder="Kota kelahiran">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Agama</label>
                            <input type="text" name="religious" class="form-control" placeholder="Agama">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan</label>
                            <input type="text" name="education" class="form-control" placeholder="Pendidikan terakhir">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Hidup</label>
                            <select name="living_status" class="form-select">
                                <option value="hidup">Hidup</option>
                                <option value="meninggal">Meninggal</option>
                                <option value="pindah">Pindah</option>
                                <option value="tidak_diketahui">Tidak Diketahui</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Kawin</label>
                            <input type="text" name="married_status" class="form-control" placeholder="Status perkawinan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="occupation" class="form-control" placeholder="Pekerjaan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Golongan Darah</label>
                            <input type="text" name="blood_type" class="form-control" placeholder="A / B / AB / O">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-wp ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-wp primary">
                        <i class="fa fa-save"></i> Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ── EDIT MODALS ── --}}
    @foreach($wargas as $row)
    <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('warga.update', $row->id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Warga — <span style="color:var(--accent2)">{{ $row->name }}</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIK <span class="req">*</span></label>
                            <input type="text" name="nik" class="form-control" value="{{ $row->nik }}" maxlength="16" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No KK</label>
                            <select name="no_kk" class="form-select">
                                <option value="">— Pilih No KK —</option>
                                @foreach($familyList as $fam)
                                <option value="{{ $fam->no_kk }}" {{ $row->no_kk === $fam->no_kk ? 'selected' : '' }}>
                                    {{ $fam->no_kk }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $row->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender <span class="req">*</span></label>
                            <select name="gender" class="form-select" required>
                                <option value="L" {{ $row->gender=='L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $row->gender=='P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="birth_place" class="form-control" value="{{ $row->birth_place }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control" value="{{ $row->birth_date?->format('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Agama</label>
                            <input type="text" name="religious" class="form-control" value="{{ $row->religious }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan</label>
                            <input type="text" name="education" class="form-control" value="{{ $row->education }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Hidup</label>
                            <select name="living_status" class="form-select">
                                <option value="hidup" {{ $row->living_status=='hidup' ? 'selected' : '' }}>Hidup</option>
                                <option value="meninggal" {{ $row->living_status=='meninggal' ? 'selected' : '' }}>Meninggal</option>
                                <option value="pindah" {{ $row->living_status=='pindah' ? 'selected' : '' }}>Pindah</option>
                                <option value="tidak_diketahui" {{ $row->living_status=='tidak_diketahui' ? 'selected' : '' }}>Tidak Diketahui</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Kawin</label>
                            <input type="text" name="married_status" class="form-control" value="{{ $row->married_status }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="occupation" class="form-control" value="{{ $row->occupation }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Golongan Darah</label>
                            <input type="text" name="blood_type" class="form-control" value="{{ $row->blood_type }}">
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

</div>{{-- /warga-wrap --}}
@endsection

@push('scripts')
<script>
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
</script>
@endpush