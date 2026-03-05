@extends('layouts.app')

@section('title', 'Surat Keterangan Domisili')

@section('content')

{{-- PAGE HEADER --}}
<div class="aw-page-header mb-4">
    <div class="aw-header-left">
        <div class="aw-header-icon" style="background: linear-gradient(135deg, #10b981, #065f46);">
            <i class="bx bx-map"></i>
        </div>
        <div>
            <h4 class="aw-title">Surat Keterangan Domisili</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Surat</a></li>
                    <li class="breadcrumb-item active">Domisili</li>
                </ol>
            </nav>
        </div>
    </div>
    <a href="{{ route('arsip.index') }}" class="btn aw-btn-arsip">
        <i class="bx bx-archive me-1"></i> Lihat Arsip
    </a>
</div>

<div class="row g-4">

    {{-- ============================================================
         KIRI: FORM INPUT
    ============================================================ --}}
    <div class="col-xl-5 col-lg-5">
        <div class="aw-card">

            {{-- NOMOR SURAT --}}
            <div class="aw-section">
                <div class="aw-section-label">
                    <span class="aw-step">1</span>
                    <span>Nomor Surat</span>
                </div>
                <input type="text" class="aw-input" id="nomor_surat" value="{{ $nomorSurat }}" placeholder="Auto-generate">
                <div class="aw-hint"><i class="bx bx-info-circle me-1"></i>Format: 474/XXX/DOM/BULAN/TAHUN</div>
            </div>

            <div class="aw-divider"></div>

            {{-- DATA WARGA --}}
            <div class="aw-section">
                <div class="aw-section-label">
                    <span class="aw-step aw-step-red">2</span>
                    <span>Data Warga</span>
                </div>

                <div class="aw-search-wrap mb-2">
                    <div class="aw-search-icon"><i class="bx bx-search"></i></div>
                    <input type="text" class="aw-input aw-search-input" id="searchWarga"
                        placeholder="Cari NIK atau nama warga..." autocomplete="off">
                    <div id="searchResults" class="aw-dropdown"></div>
                </div>
                <div class="aw-hint mb-3"><i class="bx bx-info-circle me-1"></i>Minimal 2 karakter. Data akan auto-fill.</div>

                <div class="row g-2">
                    <div class="col-12">
                        <label class="aw-label">NIK</label>
                        <input type="text" class="aw-input" id="nik" placeholder="16 digit NIK" maxlength="16">
                    </div>
                    <div class="col-12">
                        <label class="aw-label">Nama Lengkap</label>
                        <input type="text" class="aw-input" id="nama" placeholder="Nama lengkap warga">
                    </div>
                    <div class="col-7">
                        <label class="aw-label">Tempat Lahir</label>
                        <input type="text" class="aw-input aw-readonly" id="tempat_lahir" readonly>
                    </div>
                    <div class="col-5">
                        <label class="aw-label">Tanggal Lahir</label>
                        <input type="text" class="aw-input aw-readonly" id="tanggal_lahir" readonly>
                    </div>
                    <div class="col-6">
                        <label class="aw-label">Jenis Kelamin</label>
                        <input type="text" class="aw-input aw-readonly" id="jenis_kelamin" readonly>
                    </div>
                    <div class="col-6">
                        <label class="aw-label">Agama</label>
                        <input type="text" class="aw-input aw-readonly" id="agama" readonly>
                    </div>
                    <div class="col-6">
                        <label class="aw-label">Status Pernikahan</label>
                        <input type="text" class="aw-input aw-readonly" id="status_nikah" readonly>
                    </div>
                    <div class="col-6">
                        <label class="aw-label">Pekerjaan</label>
                        <input type="text" class="aw-input aw-readonly" id="pekerjaan" readonly>
                    </div>
                    <div class="col-12">
                        <label class="aw-label">Alamat</label>
                        <textarea class="aw-input aw-readonly" id="alamat" rows="2" readonly></textarea>
                    </div>
                    <div class="col-6">
                        <label class="aw-label">RT</label>
                        <input type="text" class="aw-input aw-readonly" id="rt" readonly>
                    </div>
                    <div class="col-6">
                        <label class="aw-label">RW</label>
                        <input type="text" class="aw-input aw-readonly" id="rw" readonly>
                    </div>
                    <div class="col-12">
                        <label class="aw-label">No. KK</label>
                        <input type="text" class="aw-input aw-readonly" id="no_kk" readonly>
                    </div>
                </div>
            </div>

            <div class="aw-divider"></div>

            {{-- KEPERLUAN --}}
            <div class="aw-section">
                <div class="aw-section-label">
                    <span class="aw-step aw-step-orange">3</span>
                    <span>Keperluan &amp; Keterangan</span>
                </div>

                <div class="row g-2">
                    <div class="col-12">
                        <label class="aw-label">Lama Tinggal</label>
                        <input type="text" class="aw-input" id="lama_tinggal" placeholder="contoh: 5 tahun, sejak 2019">
                    </div>
                    <div class="col-12">
                        <label class="aw-label">Keperluan Surat <span class="text-danger">*</span></label>
                        <select class="aw-input aw-select" id="keperluan_select">
                            <option value="">-- Pilih keperluan --</option>
                            <option value="Pembuatan KTP / KK">Pembuatan KTP / KK</option>
                            <option value="Pendaftaran sekolah">Pendaftaran Sekolah</option>
                            <option value="Keperluan kerja / melamar pekerjaan">Melamar Pekerjaan</option>
                            <option value="Pembuatan rekening bank">Pembuatan Rekening Bank</option>
                            <option value="Keperluan BPJS / asuransi">BPJS / Asuransi</option>
                            <option value="Keperluan administrasi lainnya">Administrasi Lainnya</option>
                            <option value="lainnya">Lainnya (ketik manual)</option>
                        </select>
                        <input type="text" class="aw-input mt-2 d-none" id="keperluan_manual" placeholder="Ketik keperluan...">
                    </div>
                </div>
            </div>

            <div class="aw-divider"></div>

            {{-- TANGGAL SURAT --}}
            <div class="aw-section">
                <div class="aw-section-label">
                    <span class="aw-step" style="background:#6366f1;">4</span>
                    <span>Tanggal Surat</span>
                </div>
                <input type="text" class="aw-input aw-readonly" id="tanggal_surat" readonly>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="aw-actions">
                <button type="button" class="aw-btn-primary flex-fill" id="btnSimpan">
                    <i class="bx bx-save"></i> Simpan Arsip
                </button>
                <button type="button" class="aw-btn-success flex-fill" onclick="window.print()">
                    <i class="bx bx-printer"></i> Cetak PDF
                </button>
                <button type="button" class="aw-btn-icon-danger" id="btnReset" title="Reset Form">
                    <i class="bx bx-refresh"></i>
                </button>
            </div>

        </div>
    </div>

    {{-- ============================================================
         KANAN: PREVIEW SURAT
    ============================================================ --}}
    <div class="col-xl-7 col-lg-7">
        <div class="aw-preview-card">
            <div class="aw-preview-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-show" style="color:#10b981;"></i>
                    <span>Preview Surat</span>
                </div>
                <span class="aw-live-badge">
                    <span class="aw-live-dot"></span> Live Preview
                </span>
            </div>
            <div class="aw-preview-body">

                <div id="surat-preview" style="
                    background:white; padding:40px 50px; min-height:700px;
                    font-family:'Times New Roman',serif; font-size:12pt;
                    color:#000; line-height:1.6;">

                    {{-- KOP SURAT --}}
                    <div style="display:flex; align-items:center; border-bottom:3px solid #000; padding-bottom:10px; margin-bottom:16px;">
                        <div style="flex-shrink:0; margin-right:16px;">
                            @if($config && $config->logo)
                            <img src="{{ asset($config->logo) }}" alt="Logo" style="width:80px; height:80px; object-fit:contain;">
                            @else
                            <div style="width:80px; height:80px; border:2px dashed #ccc; display:flex; align-items:center; justify-content:center; color:#aaa; font-size:10px; text-align:center;">Logo<br>Kelurahan</div>
                            @endif
                        </div>
                        <div style="flex:1; text-align:center;">
                            <div style="font-size:11pt;">PEMERINTAH KOTA {{ strtoupper($config->city ?? 'BANDUNG') }}</div>
                            <div style="font-size:11pt;">KECAMATAN {{ strtoupper($config->district ?? '-') }}</div>
                            <div style="font-size:16pt; font-weight:bold; text-transform:uppercase;">{{ $config->name ?? 'KELURAHAN' }}</div>
                            <div style="font-size:9pt;">
                                @if($config && $config->address){{ $config->address }} &bull; @endif
                                Kode Pos {{ $config->pos_code ?? '' }}@if($config && $config->contact) &bull; Telp/Email: {{ $config->contact }}@endif
                            </div>
                        </div>
                    </div>

                    {{-- JUDUL --}}
                    <div style="text-align:center; margin:16px 0 20px;">
                        <div style="font-size:13pt; font-weight:bold; text-decoration:underline; text-transform:uppercase; letter-spacing:1px;">
                            Surat Keterangan Domisili
                        </div>
                        <div style="font-size:11pt; margin-top:4px;">
                            Nomor: <span id="p-nomor-surat">{{ $nomorSurat }}</span>
                        </div>
                    </div>

                    {{-- PEMBUKA --}}
                    <p style="margin:0 0 12px 0; text-align:justify;">
                        Yang bertanda tangan di bawah ini, Lurah <b>{{ $config->name ?? 'Kelurahan' }}</b>,
                        Kecamatan <b>{{ $config->district ?? '-' }}</b>,
                        Kota <b>{{ $config->city ?? '-' }}</b>,
                        Provinsi <b>{{ $config->province ?? '-' }}</b>,
                        dengan ini menerangkan bahwa:
                    </p>

                    {{-- DATA WARGA --}}
                    <table style="width:100%; border-collapse:collapse; margin:4px 0 16px 0;">
                        <tr>
                            <td style="width:37%; padding:2px 0;">Nama Lengkap</td>
                            <td style="width:3%;">:</td>
                            <td><b><span id="p-nama">-</span></b></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">NIK</td>
                            <td>:</td>
                            <td><span id="p-nik">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">Tempat / Tanggal Lahir</td>
                            <td>:</td>
                            <td><span id="p-ttl">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">Jenis Kelamin</td>
                            <td>:</td>
                            <td><span id="p-jk">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">Agama</td>
                            <td>:</td>
                            <td><span id="p-agama">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">Status Pernikahan</td>
                            <td>:</td>
                            <td><span id="p-status-nikah">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">Pekerjaan</td>
                            <td>:</td>
                            <td><span id="p-pekerjaan">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">No. KK</td>
                            <td>:</td>
                            <td><span id="p-no-kk">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0; vertical-align:top;">Alamat</td>
                            <td style="vertical-align:top;">:</td>
                            <td><span id="p-alamat">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">RT / RW</td>
                            <td>:</td>
                            <td>RT <span id="p-rt">-</span> / RW <span id="p-rw">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">Lama Tinggal</td>
                            <td>:</td>
                            <td><span id="p-lama-tinggal">-</span></td>
                        </tr>
                    </table>

                    {{-- ISI --}}
                    <p style="margin:0 0 10px 0; text-align:justify;">
                        Adalah benar bahwa yang bersangkutan <b>berdomisili / bertempat tinggal</b>
                        di wilayah <b>{{ $config->name ?? 'Kelurahan' }}</b>,
                        Kecamatan <b>{{ $config->district ?? '-' }}</b>,
                        Kota <b>{{ $config->city ?? '-' }}</b>.
                    </p>
                    <p style="margin:0 0 10px 0; text-align:justify;">
                        Surat keterangan ini dibuat untuk keperluan
                        <b><span id="p-keperluan">........................</span></b>
                        dan dapat dipergunakan sebagaimana mestinya.
                    </p>
                    <p style="margin:0 0 20px 0; text-align:justify;">
                        Demikian surat keterangan ini dibuat dengan sebenar-benarnya.
                    </p>

                    {{-- TTD --}}
                    <div style="display:flex; justify-content:flex-end; margin-top:24px;">
                        <div style="text-align:center; min-width:220px;">
                            <div>{{ $config->city ?? 'Bandung' }}, <span id="p-tanggal-surat">{{ now()->isoFormat('D MMMM Y') }}</span></div>
                            <div style="margin-top:4px;">Lurah {{ $config->name ?? '' }}</div>
                            <br><br><br><br>
                            <div style="border-bottom:1px solid #000; width:200px; margin:0 auto;"></div>
                            <div style="font-size:9pt; margin-top:4px;">NIP. ___________________________</div>
                        </div>
                    </div>

                </div>{{-- end #surat-preview --}}
            </div>
        </div>
    </div>

</div>

@endsection

@push('styles')
<style>
    /* =============================================
   AW - SHARED STYLES
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
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
        transition: all .2s;
        white-space: nowrap;
    }

    .aw-btn-arsip:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #334155;
    }

    .aw-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .aw-section {
        padding: 20px 22px;
    }

    .aw-section-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 14px;
    }

    .aw-step {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #3b82f6;
        color: white;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .aw-step-red {
        background: #ef4444;
    }

    .aw-step-green {
        background: #10b981;
    }

    .aw-step-orange {
        background: #f59e0b;
    }

    .aw-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 0 22px;
    }

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

    .aw-readonly {
        background: #f8fafc !important;
        color: #64748b !important;
        cursor: default;
    }

    .aw-select {
        appearance: auto;
    }

    textarea.aw-input {
        resize: none;
    }

    .aw-search-wrap {
        position: relative;
    }

    .aw-search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
        z-index: 1;
    }

    .aw-search-input {
        padding-left: 34px !important;
    }

    .aw-dropdown {
        position: absolute;
        left: 0;
        right: 0;
        top: calc(100% + 4px);
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .10);
        z-index: 1050;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }

    .aw-hint {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 5px;
    }

    .search-item {
        padding: 9px 14px;
        cursor: pointer;
        border-bottom: 1px solid #f1f5f9;
        transition: background .15s;
    }

    .search-item:last-child {
        border-bottom: none;
    }

    .search-item:hover {
        background: #eff6ff;
    }

    .search-item .item-name {
        font-weight: 600;
        font-size: 13px;
        color: #1e293b;
    }

    .search-item .item-nik {
        font-size: 11px;
        color: #94a3b8;
    }

    .aw-actions {
        padding: 16px 22px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: 8px;
        background: #fafafa;
    }

    .aw-btn-primary {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 14px;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }

    .aw-btn-primary:hover {
        background: #2563eb;
    }

    .aw-btn-success {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 14px;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }

    .aw-btn-success:hover {
        background: #059669;
    }

    .aw-btn-icon-danger {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff4f4;
        color: #ef4444;
        border: 1.5px solid #fecaca;
        border-radius: 9px;
        font-size: 18px;
        cursor: pointer;
        transition: all .15s;
        flex-shrink: 0;
    }

    .aw-btn-icon-danger:hover {
        background: #fee2e2;
        border-color: #ef4444;
    }

    .aw-preview-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        position: sticky;
        top: 16px;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 120px);
    }

    .aw-preview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        flex-shrink: 0;
    }

    .aw-live-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: #dcfce7;
        color: #15803d;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .aw-live-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #22c55e;
        animation: pulse-dot 1.5s ease-in-out infinite;
    }

    @keyframes pulse-dot {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: .5;
            transform: scale(.75);
        }
    }

    .aw-preview-body {
        overflow-y: auto;
        flex: 1;
    }

    #surat-preview {
        border: none;
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 0;
        }

        body * {
            visibility: hidden !important;
        }

        #surat-preview,
        #surat-preview * {
            visibility: visible !important;
        }

        #surat-preview {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            padding: 1.5cm 2cm !important;
            margin: 0 !important;
            border: none !important;
            background: white !important;
            min-height: auto !important;
            font-size: 11pt !important;
            box-sizing: border-box !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        const today = new Date();
        document.getElementById('tanggal_surat').value =
            `${today.getDate()} ${bulanIndo[today.getMonth()]} ${today.getFullYear()}`;

        const setF = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.value = val || '';
        };
        const setP = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.textContent = val || '-';
        };

        document.getElementById('nomor_surat').addEventListener('input', function() {
            setP('p-nomor-surat', this.value);
        });
        document.getElementById('lama_tinggal').addEventListener('input', function() {
            setP('p-lama-tinggal', this.value);
        });
        document.getElementById('keperluan_select').addEventListener('change', function() {
            const manual = document.getElementById('keperluan_manual');
            if (this.value === 'lainnya') {
                manual.classList.remove('d-none');
                manual.focus();
            } else {
                manual.classList.add('d-none');
                setP('p-keperluan', this.value || '........................');
            }
        });
        document.getElementById('keperluan_manual').addEventListener('input', function() {
            setP('p-keperluan', this.value || '........................');
        });

        // SEARCH WARGA
        let searchTimeout;
        const searchInput = document.getElementById('searchWarga');
        const searchResults = document.getElementById('searchResults');

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const q = this.value.trim();
            if (q.length < 2) {
                searchResults.style.display = 'none';
                return;
            }
            searchTimeout = setTimeout(() => {
                fetch(`{{ route('domisili.search_warga') }}?q=${encodeURIComponent(q)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        if (!data.success || !data.data.length) {
                            searchResults.innerHTML = '<div class="search-item text-muted">Warga tidak ditemukan</div>';
                        } else {
                            data.data.forEach(w => {
                                const item = document.createElement('div');
                                item.className = 'search-item';
                                item.innerHTML = `<div class="item-name">${w.name}</div>
                            <div class="item-nik">NIK: ${w.nik} &bull; RT ${w.rt}/RW ${w.rw}</div>`;
                                item.addEventListener('click', () => fillWarga(w));
                                searchResults.appendChild(item);
                            });
                        }
                        searchResults.style.display = 'block';
                    })
                    .catch(() => {
                        searchResults.style.display = 'none';
                    });
            }, 350);
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target))
                searchResults.style.display = 'none';
        });

        function fillWarga(w) {
            searchResults.style.display = 'none';
            searchInput.value = w.name;
            setF('nik', w.nik);
            setF('nama', w.name);
            setF('tempat_lahir', w.birth_place);
            setF('tanggal_lahir', w.birth_date_fmt);
            setF('jenis_kelamin', w.gender === 'L' ? 'Laki-laki' : 'Perempuan');
            setF('agama', w.religious);
            setF('status_nikah', w.married_status);
            setF('pekerjaan', w.occupation);
            setF('alamat', w.address);
            setF('rt', w.rt);
            setF('rw', w.rw);
            setF('no_kk', w.no_kk);
            setP('p-nik', w.nik);
            setP('p-nama', w.name);
            setP('p-ttl', `${w.birth_place}, ${w.birth_date_fmt}`);
            setP('p-jk', w.gender === 'L' ? 'Laki-laki' : 'Perempuan');
            setP('p-agama', w.religious);
            setP('p-status-nikah', w.married_status);
            setP('p-pekerjaan', w.occupation);
            setP('p-alamat', w.address);
            setP('p-rt', w.rt);
            setP('p-rw', w.rw);
            setP('p-no-kk', w.no_kk);
        }

        function resetForm() {
            ['nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
                'agama', 'status_nikah', 'pekerjaan', 'alamat', 'rt', 'rw', 'no_kk', 'lama_tinggal'
            ]
            .forEach(id => setF(id, ''));
            searchInput.value = '';
            document.getElementById('keperluan_select').value = '';
            document.getElementById('keperluan_manual').value = '';
            document.getElementById('keperluan_manual').classList.add('d-none');
            ['p-nik', 'p-nama', 'p-ttl', 'p-jk', 'p-agama', 'p-status-nikah',
                'p-pekerjaan', 'p-alamat', 'p-rt', 'p-rw', 'p-no-kk', 'p-lama-tinggal'
            ]
            .forEach(id => setP(id, '-'));
            setP('p-keperluan', '........................');
        }

        document.getElementById('btnReset').addEventListener('click', function() {
            if (!confirm('Reset semua data form?')) return;
            resetForm();
        });

        document.getElementById('btnSimpan').addEventListener('click', async function() {
            const btn = this;
            const keperluanVal = document.getElementById('keperluan_select').value === 'lainnya' ?
                document.getElementById('keperluan_manual').value :
                document.getElementById('keperluan_select').value;

            const payload = {
                nomor_surat: document.getElementById('nomor_surat').value,
                nik: document.getElementById('nik').value,
                nama: document.getElementById('nama').value,
                tempat_lahir: document.getElementById('tempat_lahir').value,
                tanggal_lahir: document.getElementById('tanggal_lahir').value,
                jenis_kelamin: document.getElementById('jenis_kelamin').value,
                agama: document.getElementById('agama').value,
                status_nikah: document.getElementById('status_nikah').value,
                pekerjaan: document.getElementById('pekerjaan').value,
                alamat: document.getElementById('alamat').value,
                rt: document.getElementById('rt').value,
                rw: document.getElementById('rw').value,
                no_kk: document.getElementById('no_kk').value,
                lama_tinggal: document.getElementById('lama_tinggal').value,
                tanggal_surat: document.getElementById('tanggal_surat').value,
                keperluan: keperluanVal,
            };

            if (!payload.nik || payload.nik.length !== 16) {
                alert('NIK harus 16 digit. Pilih warga terlebih dahulu.');
                return;
            }
            if (!payload.keperluan) {
                alert('Keperluan surat wajib diisi.');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            try {
                const res = await fetch('{{ route("domisili.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if (data.success) {
                    alert(`✅ ${data.message}\nNomor: ${data.data.nomor_surat}`);
                    resetForm();
                    window.location.reload();
                } else {
                    alert('❌ Gagal: ' + (data.message || 'Terjadi kesalahan'));
                }
            } catch (e) {
                alert('❌ Koneksi gagal. Silakan coba lagi.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="bx bx-save me-1"></i> Simpan Arsip';
            }
        });

    });
</script>
@endpush