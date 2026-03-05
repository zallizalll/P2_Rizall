@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')

{{-- PAGE HEADER --}}
<div class="aw-page-header mb-4">
    <div class="aw-header-left">
        <div class="aw-header-icon" style="background: linear-gradient(135deg, #64748b, #334155);">
            <i class="bx bx-archive"></i>
        </div>
        <div>
            <h4 class="aw-title">Arsip Surat</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Arsip Surat</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="dropdown">
        <button class="aw-btn-new dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="bx bx-plus"></i> Buat Surat Baru
        </button>
        <ul class="dropdown-menu dropdown-menu-end aw-dropdown-menu">
            <li>
                <a class="dropdown-item aw-dropdown-item" href="{{ route('sktm.index') }}">
                    <span class="aw-menu-icon" style="background:#ede9fe; color:#6d28d9;"><i class="bx bx-shield"></i></span>
                    <div>
                        <div class="aw-menu-title">SKTM</div>
                        <div class="aw-menu-sub">Surat Keterangan Tidak Mampu</div>
                    </div>
                </a>
            </li>
            <li>
                <a class="dropdown-item aw-dropdown-item" href="{{ route('domisili.index') }}">
                    <span class="aw-menu-icon" style="background:#dcfce7; color:#15803d;"><i class="bx bx-map"></i></span>
                    <div>
                        <div class="aw-menu-title">Domisili</div>
                        <div class="aw-menu-sub">Surat Keterangan Domisili</div>
                    </div>
                </a>
            </li>
            <li>
                <a class="dropdown-item aw-dropdown-item" href="{{ route('akte_kematian.index') }}">
                    <span class="aw-menu-icon" style="background:#fee2e2; color:#b91c1c;"><i class="bx bx-file-blank"></i></span>
                    <div>
                        <div class="aw-menu-title">Akte Kematian</div>
                        <div class="aw-menu-sub">Surat Keterangan Kematian</div>
                    </div>
                </a>
            </li>
            <li>
                <a class="dropdown-item aw-dropdown-item" href="{{ route('ahli_waris.index') }}">
                    <span class="aw-menu-icon" style="background:#dbeafe; color:#1d4ed8;"><i class="bx bx-group"></i></span>
                    <div>
                        <div class="aw-menu-title">Ahli Waris</div>
                        <div class="aw-menu-sub">Surat Keterangan Ahli Waris</div>
                    </div>
                </a>
            </li>
            <li>
                <a class="dropdown-item aw-dropdown-item" href="{{ route('pindah_keluar.index') }}">
                    <span class="aw-menu-icon" style="background:#fef3c7; color:#b45309;"><i class="bx bx-transfer"></i></span>
                    <div>
                        <div class="aw-menu-title">Pindah Keluar</div>
                        <div class="aw-menu-sub">Surat Keterangan Pindah</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>

{{-- MAIN CARD --}}
<div class="arsip-card">

    {{-- FILTER BAR --}}
    <div class="arsip-filter">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="aw-label">
                    <i class="bx bx-search me-1"></i>Cari Nama / NIK / Nomor Surat
                </label>
                <div class="arsip-search-wrap">
                    <i class="bx bx-search arsip-search-icon"></i>
                    <input type="text" class="aw-input arsip-search-input" id="filterSearch"
                        placeholder="Ketik untuk mencari...">
                </div>
            </div>
            <div class="col-md-3">
                <label class="aw-label"><i class="bx bx-filter me-1"></i>Jenis Surat</label>
                <select class="aw-input aw-select" id="filterJenis">
                    <option value="">Semua Jenis</option>
                    <option value="SKTM">SKTM</option>
                    <option value="DOMISILI">Domisili</option>
                    <option value="AKTE_KEMATIAN">Akte Kematian</option>
                    <option value="AHLI_WARIS">Ahli Waris</option>
                    <option value="PINDAH_KELUAR">Pindah Keluar</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="aw-label"><i class="bx bx-calendar me-1"></i>Bulan</label>
                <select class="aw-input aw-select" id="filterBulan">
                    <option value="">Semua Bulan</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="aw-label">Tahun</label>
                <select class="aw-input aw-select" id="filterTahun">
                    <option value="">Semua Tahun</option>
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-1">
                <label class="aw-label">&nbsp;</label>
                <button class="aw-btn-icon-secondary w-100" id="btnResetFilter" title="Reset filter" style="height:38px;">
                    <i class="bx bx-reset"></i>
                </button>
            </div>
        </div>
        <div class="arsip-filter-info">
            Menampilkan <span id="jumlahTampil" class="arsip-count">{{ count($logs) }}</span>
            dari <span class="arsip-count">{{ count($logs) }}</span> arsip
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="arsip-table" id="tabelArsip">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Nomor Surat</th>
                    <th>Jenis Surat</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Tanggal Dibuat</th>
                    <th style="width:70px;"></th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($logs as $i => $log)
                @php
                $badges = [
                'SKTM' => ['badge-purple', 'Tidak Mampu'],
                'DOMISILI' => ['badge-green', 'Domisili'],
                'AKTE_KEMATIAN' => ['badge-red', 'Akte Kematian'],
                'AHLI_WARIS' => ['badge-blue', 'Ahli Waris'],
                'PINDAH_KELUAR' => ['badge-orange', 'Pindah Keluar'],
                ];
                $badge = $badges[$log->doc_type] ?? ['badge-gray', $log->doc_type];
                @endphp
                <tr class="arsip-row"
                    data-jenis="{{ $log->doc_type }}"
                    data-nama="{{ strtolower($log->detail['nama'] ?? '') }}"
                    data-nik="{{ $log->detail['nik'] ?? '' }}"
                    data-nomor="{{ strtolower($log->detail['nomor_surat'] ?? '') }}"
                    data-bulan="{{ $log->created_at?->format('m') }}"
                    data-tahun="{{ $log->created_at?->format('Y') }}">
                    <td class="row-num text-muted" style="font-size:13px;">{{ $i + 1 }}</td>
                    <td>
                        <code class="arsip-nomor">{{ $log->detail['nomor_surat'] ?? '-' }}</code>
                    </td>
                    <td>
                        <span class="arsip-badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                    </td>
                    <td style="font-size:13px; font-weight:500;">{{ $log->detail['nama'] ?? '-' }}</td>
                    <td class="text-muted" style="font-size:12px; font-family:monospace;">{{ $log->detail['nik'] ?? '-' }}</td>
                    <td class="text-muted" style="font-size:12px;">
                        {{ $log->created_at?->format('d M Y, H:i') }}
                    </td>
                    <td>
                        <button class="arsip-btn-detail"
                            onclick='lihatDetail({{ json_encode($log->detail) }}, "{{ $log->doc_type }}")'
                            title="Lihat detail">
                            <i class="bx bx-show"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="arsip-empty">
                        <i class="bx bx-folder-open"></i>
                        <div>Belum ada arsip surat</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Empty filter state --}}
        <div id="emptyFilter" class="arsip-empty d-none">
            <i class="bx bx-search-alt"></i>
            <div>Tidak ada arsip yang sesuai filter</div>
            <button class="aw-btn-arsip mt-3" id="btnResetFilter2">
                <i class="bx bx-reset me-1"></i> Reset Filter
            </button>
        </div>
    </div>

</div>

{{-- ============================================================
     MODAL DETAIL
============================================================ --}}
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content aw-modal">
            <div class="modal-header aw-modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="aw-modal-icon"><i class="bx bx-file"></i></div>
                    <div>
                        <h5 class="modal-title mb-0" id="detailModalTitle">Detail Surat</h5>
                        <small class="text-muted">Informasi lengkap arsip</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="detailContent"></div>
            <div class="modal-footer aw-modal-footer">
                <button type="button" class="aw-btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* =============================================
   AW - PAGE HEADER (shared)
   ============================================= */
    .aw-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-top: 32px;
    }

    .aw-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .aw-header-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        flex-shrink: 0;
    }

    .aw-title {
        font-size: 17px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 3px;
    }

    .breadcrumb {
        font-size: 12px;
    }

    /* Buat Surat button */
    .aw-btn-new {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        background: #3b82f6;
        color: white;
        border: none;
        cursor: pointer;
        transition: background .15s;
        white-space: nowrap;
    }

    .aw-btn-new:hover {
        background: #2563eb;
        color: white;
    }

    .aw-btn-new::after {
        margin-left: 2px;
    }

    /* Dropdown menu */
    .aw-dropdown-menu {
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 12px !important;
        box-shadow: 0 12px 32px rgba(0, 0, 0, .12) !important;
        padding: 6px !important;
        min-width: 240px !important;
    }

    .aw-dropdown-item {
        display: flex !important;
        align-items: center;
        gap: 12px;
        padding: 10px 12px !important;
        border-radius: 8px !important;
        transition: background .15s !important;
    }

    .aw-dropdown-item:hover {
        background: #f8fafc !important;
    }

    .aw-menu-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .aw-menu-title {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }

    .aw-menu-sub {
        font-size: 11px;
        color: #94a3b8;
    }

    /* =============================================
   ARSIP CARD
   ============================================= */
    .arsip-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
    }

    /* Filter bar */
    .arsip-filter {
        padding: 20px 22px;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
    }

    .arsip-filter-info {
        margin-top: 10px;
        font-size: 12px;
        color: #94a3b8;
    }

    .arsip-count {
        font-weight: 700;
        color: #374151;
    }

    /* Search in filter */
    .arsip-search-wrap {
        position: relative;
    }

    .arsip-search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
        z-index: 1;
    }

    .arsip-search-input {
        padding-left: 34px !important;
    }

    /* Table */
    .arsip-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .arsip-table thead tr {
        background: #f8fafc;
        border-bottom: 1.5px solid #e2e8f0;
    }

    .arsip-table thead th {
        padding: 12px 16px;
        font-size: 11.5px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }

    .arsip-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background .1s;
    }

    .arsip-table tbody tr:last-child {
        border-bottom: none;
    }

    .arsip-table tbody tr:hover {
        background: #f8fafc;
    }

    .arsip-table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
    }

    /* Nomor surat */
    .arsip-nomor {
        font-family: 'SFMono-Regular', Consolas, monospace;
        font-size: 11.5px;
        background: #f1f5f9;
        color: #334155;
        padding: 3px 8px;
        border-radius: 5px;
        border: 1px solid #e2e8f0;
    }

    /* Badges */
    .arsip-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-purple {
        background: #ede9fe;
        color: #6d28d9;
    }

    .badge-green {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-red {
        background: #fee2e2;
        color: #b91c1c;
    }

    .badge-blue {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-orange {
        background: #fef3c7;
        color: #b45309;
    }

    .badge-gray {
        background: #f1f5f9;
        color: #475569;
    }

    /* Detail button */
    .arsip-btn-detail {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #3b82f6;
        border: 1.5px solid #bfdbfe;
        border-radius: 7px;
        font-size: 16px;
        cursor: pointer;
        transition: all .15s;
    }

    .arsip-btn-detail:hover {
        background: #dbeafe;
        border-color: #93c5fd;
    }

    /* Empty state */
    .arsip-empty {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .arsip-empty i {
        font-size: 3rem;
        display: block;
        margin-bottom: 10px;
    }

    .arsip-empty div {
        font-size: 14px;
    }

    /* =============================================
   SHARED HELPERS
   ============================================= */
    .aw-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .aw-input {
        width: 100%;
        padding: 9px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        color: #1e293b;
        background: #fff;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        font-family: inherit;
    }

    .aw-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .aw-select {
        appearance: auto;
    }

    .aw-btn-icon-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 18px;
        cursor: pointer;
        transition: all .15s;
        padding: 0;
    }

    .aw-btn-icon-secondary:hover {
        background: #e2e8f0;
    }

    .aw-btn-arsip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        border: 1.5px solid #cbd5e1;
        color: #475569;
        background: #f8fafc;
        cursor: pointer;
        transition: all .2s;
    }

    .aw-btn-arsip:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    /* Modal */
    .aw-modal {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, .18);
    }

    .aw-modal-header {
        background: #fafafa;
        border-bottom: 1px solid #f1f5f9;
        padding: 18px 22px;
    }

    .aw-modal-icon {
        width: 36px;
        height: 36px;
        background: #eff6ff;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3b82f6;
        font-size: 18px;
    }

    .aw-modal-footer {
        border-top: 1px solid #f1f5f9;
        background: #fafafa;
        padding: 14px 22px;
        display: flex;
        justify-content: flex-end;
    }

    .aw-btn-secondary {
        padding: 9px 18px;
        background: #f1f5f9;
        color: #475569;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all .15s;
    }

    .aw-btn-secondary:hover {
        background: #e2e8f0;
    }

    /* Detail modal table */
    #detailContent .detail-section-title {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1.5px solid #f1f5f9;
        padding-bottom: 6px;
        margin: 20px 0 10px;
    }

    #detailContent .detail-section-title:first-child {
        margin-top: 0;
    }

    #detailContent table {
        width: 100%;
        border-collapse: collapse;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        font-size: 13px;
    }

    #detailContent table tr {
        border-bottom: 1px solid #f1f5f9;
    }

    #detailContent table tr:last-child {
        border-bottom: none;
    }

    #detailContent table td {
        padding: 9px 14px;
    }

    #detailContent table td:first-child {
        width: 40%;
        font-weight: 600;
        color: #64748b;
        background: #f8fafc;
        font-size: 12px;
    }
</style>
@endpush

@push('scripts')
<script>
    const suratConfig = {
        SKTM: {
            label: 'Surat Keterangan Tidak Mampu',
            sections: [{
                    title: 'Data Surat',
                    fields: [
                        ['Nomor Surat', 'nomor_surat'],
                        ['Tanggal Surat', 'tanggal_surat']
                    ]
                },
                {
                    title: 'Data Pemohon',
                    fields: [
                        ['Nama', 'nama'],
                        ['NIK', 'nik'],
                        ['No. KK', 'no_kk'],
                        ['Tempat / Tgl Lahir', null, d => `${d.tempat_lahir}, ${d.tanggal_lahir}`],
                        ['Jenis Kelamin', 'jenis_kelamin'],
                        ['Agama', 'agama'],
                        ['Status Nikah', 'status_nikah'],
                        ['Pekerjaan', 'pekerjaan'],
                        ['Alamat', 'alamat'],
                        ['RT / RW', null, d => `RT ${d.rt} / RW ${d.rw}`],
                    ]
                },
                {
                    title: 'Keperluan',
                    fields: [
                        ['Keperluan', 'keperluan']
                    ]
                }
            ]
        },
        DOMISILI: {
            label: 'Surat Keterangan Domisili',
            sections: [{
                    title: 'Data Surat',
                    fields: [
                        ['Nomor Surat', 'nomor_surat'],
                        ['Tanggal Surat', 'tanggal_surat']
                    ]
                },
                {
                    title: 'Data Pemohon',
                    fields: [
                        ['Nama', 'nama'],
                        ['NIK', 'nik'],
                        ['No. KK', 'no_kk'],
                        ['Tempat / Tgl Lahir', null, d => `${d.tempat_lahir}, ${d.tanggal_lahir}`],
                        ['Jenis Kelamin', 'jenis_kelamin'],
                        ['Agama', 'agama'],
                        ['Status Nikah', 'status_nikah'],
                        ['Pekerjaan', 'pekerjaan'],
                        ['Alamat', 'alamat'],
                        ['RT / RW', null, d => `RT ${d.rt} / RW ${d.rw}`],
                        ['Lama Tinggal', 'lama_tinggal'],
                    ]
                },
                {
                    title: 'Keperluan',
                    fields: [
                        ['Keperluan', 'keperluan']
                    ]
                }
            ]
        },
        AKTE_KEMATIAN: {
            label: 'Surat Keterangan Kematian',
            sections: [{
                    title: 'Data Surat',
                    fields: [
                        ['Nomor Surat', 'nomor_surat'],
                        ['Tanggal Surat', 'tanggal_surat']
                    ]
                },
                {
                    title: 'Data Almarhum',
                    fields: [
                        ['Nama', 'nama'],
                        ['NIK', 'nik'],
                        ['No. KK', 'no_kk'],
                        ['Tempat / Tgl Lahir', null, d => `${d.tempat_lahir}, ${d.tanggal_lahir}`],
                        ['Jenis Kelamin', 'jenis_kelamin'],
                        ['Umur', null, d => `${d.umur} tahun`],
                        ['Agama', 'agama'],
                        ['Pekerjaan', 'pekerjaan'],
                        ['Alamat', 'alamat'],
                        ['RT / RW', null, d => `RT ${d.rt} / RW ${d.rw}`],
                    ]
                },
                {
                    title: 'Keterangan Kematian',
                    fields: [
                        ['Tanggal Meninggal', 'tanggal_meninggal'],
                        ['Tempat Meninggal', 'tempat_meninggal'],
                        ['Sebab Meninggal', 'sebab_meninggal'],
                    ]
                },
                {
                    title: 'Data Pelapor',
                    fields: [
                        ['Nama Pelapor', 'nama_pelapor'],
                        ['NIK Pelapor', 'nik_pelapor'],
                        ['Hubungan', 'hubungan_pelapor'],
                    ]
                }
            ]
        },
        AHLI_WARIS: {
            label: 'Surat Ahli Waris',
            sections: [{
                    title: 'Data Surat',
                    fields: [
                        ['Nomor Surat', 'nomor_surat'],
                        ['Tanggal Surat', 'tanggal_surat']
                    ]
                },
                {
                    title: 'Data Almarhum',
                    fields: [
                        ['Nama Almarhum', 'nama_almarhum'],
                        ['NIK', 'nik_almarhum']
                    ]
                },
                {
                    title: 'Daftar Ahli Waris',
                    custom: d => {
                        if (!d.ahli_waris?.length) return '<p class="text-muted small">Tidak ada data</p>';
                        let html = '<table><thead><tr><td style="text-align:center;width:40px;">#</td><td>Nama</td><td>NIK</td><td>Hubungan</td></tr></thead><tbody>';
                        d.ahli_waris.forEach((w, i) => {
                            html += `<tr><td style="text-align:center;">${i+1}</td><td>${w.nama}</td><td style="font-family:monospace;font-size:12px;">${w.nik}</td><td>${w.hubungan}</td></tr>`;
                        });
                        return html + '</tbody></table>';
                    }
                }
            ]
        },
        PINDAH_KELUAR: {
            label: 'Surat Pindah Keluar',
            sections: [{
                    title: 'Data Surat',
                    fields: [
                        ['Nomor Surat', 'nomor_surat'],
                        ['Tanggal Surat', 'tanggal_surat']
                    ]
                },
                {
                    title: 'Data Pemohon',
                    fields: [
                        ['Nama', 'nama'],
                        ['NIK', 'nik'],
                        ['Alamat Asal', 'alamat_asal'],
                        ['Alamat Tujuan', 'alamat_tujuan'],
                        ['Alasan Pindah', 'alasan'],
                    ]
                }
            ]
        },
    };

    function lihatDetail(detail, docType) {
        const config = suratConfig[docType] || {
            label: docType,
            sections: []
        };
        document.getElementById('detailModalTitle').textContent = config.label;

        let html = '';
        config.sections.forEach(section => {
            html += `<div class="detail-section-title">${section.title}</div>`;
            if (section.custom) {
                html += section.custom(detail);
            } else {
                html += '<table>';
                section.fields.forEach(([label, key, fn]) => {
                    const val = fn ? fn(detail) : (detail[key] || '-');
                    html += `<tr><td>${label}</td><td>${val}</td></tr>`;
                });
                html += '</table>';
            }
        });

        document.getElementById('detailContent').innerHTML = html;
        new bootstrap.Modal(document.getElementById('detailModal')).show();
    }

    // FILTER
    const rows = document.querySelectorAll('.arsip-row');
    const emptyFilter = document.getElementById('emptyFilter');
    const jumlahEl = document.getElementById('jumlahTampil');

    function applyFilter() {
        const search = document.getElementById('filterSearch').value.toLowerCase().trim();
        const jenis = document.getElementById('filterJenis').value;
        const bulan = document.getElementById('filterBulan').value;
        const tahun = document.getElementById('filterTahun').value;

        let tampil = 0,
            nomor = 1;
        rows.forEach(row => {
            const match =
                (!search || row.dataset.nama.includes(search) || row.dataset.nik.includes(search) || row.dataset.nomor.includes(search)) &&
                (!jenis || row.dataset.jenis === jenis) &&
                (!bulan || row.dataset.bulan === bulan) &&
                (!tahun || row.dataset.tahun === tahun);

            row.style.display = match ? '' : 'none';
            if (match) {
                row.querySelector('.row-num').textContent = nomor++;
                tampil++;
            }
        });

        jumlahEl.textContent = tampil;
        emptyFilter.classList.toggle('d-none', tampil > 0 || rows.length === 0);
    }

    ['filterSearch', 'filterJenis', 'filterBulan', 'filterTahun'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', applyFilter);
        document.getElementById(id)?.addEventListener('change', applyFilter);
    });

    function resetFilter() {
        ['filterSearch', 'filterJenis', 'filterBulan', 'filterTahun'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        applyFilter();
    }

    document.getElementById('btnResetFilter')?.addEventListener('click', resetFilter);
    document.getElementById('btnResetFilter2')?.addEventListener('click', resetFilter);

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('jenis')) {
        document.getElementById('filterJenis').value = urlParams.get('jenis');
        applyFilter();
    }
</script>
@endpush