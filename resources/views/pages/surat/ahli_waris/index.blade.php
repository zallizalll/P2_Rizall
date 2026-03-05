@extends('layouts.app')

@section('title', 'Surat Ahli Waris')

@section('content')

{{-- PAGE HEADER --}}
<div class="aw-page-header mb-4">
    <div class="aw-header-left">
        <div class="aw-header-icon">
            <i class="bx bx-file-blank"></i>
        </div>
        <div>
            <h4 class="aw-title">Surat Keterangan Ahli Waris</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Surat</a></li>
                    <li class="breadcrumb-item active">Ahli Waris</li>
                </ol>
            </nav>
        </div>
    </div>
    <a href="{{ route('arsip.index', ['jenis' => 'AHLI_WARIS']) }}" class="btn aw-btn-arsip">
        <i class="bx bx-archive me-1"></i> Lihat Arsip
    </a>
</div>

<div class="row g-4">

    {{-- ============================================================
         KIRI: FORM INPUT
    ============================================================ --}}
    <div class="col-xl-5 col-lg-5">
        <div class="aw-card h-100">

            {{-- NOMOR SURAT --}}
            <div class="aw-section">
                <div class="aw-section-label">
                    <span class="aw-step">1</span>
                    <span>Nomor Surat</span>
                </div>
                <input type="text" class="aw-input" id="nomor_surat" value="{{ $nomorSurat }}">
                <div class="aw-hint"><i class="bx bx-info-circle me-1"></i>Format: 474/XXX/AW/BULAN/TAHUN</div>
            </div>

            <div class="aw-divider"></div>

            {{-- DATA ALMARHUM --}}
            <div class="aw-section">
                <div class="aw-section-label">
                    <span class="aw-step aw-step-red">2</span>
                    <span>Data Almarhum / Almarhumah</span>
                </div>

                <div class="aw-search-wrap mb-3">
                    <div class="aw-search-icon"><i class="bx bx-search"></i></div>
                    <input type="text" class="aw-input aw-search-input" id="searchAlmarhum"
                        placeholder="Cari NIK atau nama almarhum..." autocomplete="off">
                    <div id="searchResultsAlmarhum" class="aw-dropdown"></div>
                </div>
                <div class="aw-hint mb-3"><i class="bx bx-error-circle me-1 text-danger"></i>Hanya menampilkan warga berstatus <b>meninggal</b></div>

                <div class="row g-2">
                    <div class="col-12">
                        <label class="aw-label">Nama Almarhum</label>
                        <input type="text" class="aw-input aw-readonly" id="nama_almarhum" placeholder="Terisi otomatis" readonly>
                    </div>
                    <div class="col-12">
                        <label class="aw-label">NIK Almarhum</label>
                        <input type="text" class="aw-input aw-readonly" id="nik_almarhum" placeholder="Terisi otomatis" readonly>
                    </div>
                    <div class="col-7">
                        <label class="aw-label">Tempat Lahir</label>
                        <input type="text" class="aw-input aw-readonly" id="tempat_lahir" readonly>
                    </div>
                    <div class="col-5">
                        <label class="aw-label">Tanggal Lahir</label>
                        <input type="text" class="aw-input aw-readonly" id="tanggal_lahir" readonly>
                    </div>
                    <div class="col-12">
                        <label class="aw-label">Alamat</label>
                        <textarea class="aw-input aw-readonly" id="alamat" rows="2" readonly></textarea>
                    </div>
                    <div class="col-4">
                        <label class="aw-label">RT</label>
                        <input type="text" class="aw-input aw-readonly" id="rt" readonly>
                    </div>
                    <div class="col-4">
                        <label class="aw-label">RW</label>
                        <input type="text" class="aw-input aw-readonly" id="rw" readonly>
                    </div>
                    <div class="col-4">
                        <label class="aw-label">No. KK</label>
                        <input type="text" class="aw-input aw-readonly" id="no_kk" readonly>
                    </div>
                    <div class="col-12">
                        <label class="aw-label">Tanggal Wafat</label>
                        <input type="text" class="aw-input" id="tanggal_wafat" placeholder="contoh: 10 Januari 2026">
                    </div>
                </div>
            </div>

            <div class="aw-divider"></div>

            {{-- DAFTAR AHLI WARIS --}}
            <div class="aw-section">
                <div class="aw-section-label-row">
                    <div class="aw-section-label">
                        <span class="aw-step aw-step-green">3</span>
                        <span>Daftar Ahli Waris</span>
                    </div>
                    <button type="button" class="aw-btn-add" id="btnTambahWaris">
                        <i class="bx bx-plus"></i> Tambah
                    </button>
                </div>

                <div id="listAhliWaris" class="mt-2"></div>
                <div id="emptyWaris" class="aw-empty-state">
                    <i class="bx bx-group"></i>
                    <span>Belum ada ahli waris ditambahkan</span>
                </div>
            </div>

            <div class="aw-divider"></div>

            {{-- KEPERLUAN & TANGGAL --}}
            <div class="aw-section">
                <div class="aw-section-label">
                    <span class="aw-step aw-step-orange">4</span>
                    <span>Keperluan &amp; Tanggal Surat</span>
                </div>

                <div class="mb-3">
                    <label class="aw-label">Keperluan Surat</label>
                    <select class="aw-input aw-select" id="keperluan_select">
                        <option value="">-- Pilih keperluan --</option>
                        <option value="Pengurusan warisan">Pengurusan Warisan</option>
                        <option value="Klaim asuransi jiwa">Klaim Asuransi Jiwa</option>
                        <option value="Pengurusan rekening/aset almarhum">Pengurusan Rekening / Aset</option>
                        <option value="Pengurusan pensiun janda/duda">Pengurusan Pensiun Janda/Duda</option>
                        <option value="Keperluan administrasi lainnya">Administrasi Lainnya</option>
                        <option value="lainnya">Lainnya (ketik manual)</option>
                    </select>
                    <input type="text" class="aw-input mt-2 d-none" id="keperluan_manual" placeholder="Ketik keperluan...">
                </div>

                <div>
                    <label class="aw-label">Tanggal Surat</label>
                    <input type="text" class="aw-input aw-readonly" id="tanggal_surat" readonly>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="aw-actions">
                <button type="button" class="aw-btn-primary" id="btnSimpan">
                    <i class="bx bx-save"></i> Simpan Arsip
                </button>
                <button type="button" class="aw-btn-success" onclick="window.print()">
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
                            <img src="{{ asset($config->logo) }}" alt="Logo"
                                style="width:80px; height:80px; object-fit:contain;">
                            @else
                            <div style="width:80px; height:80px; border:2px dashed #ccc;
                                    display:flex; align-items:center; justify-content:center;
                                    color:#aaa; font-size:10px; text-align:center;">
                                Logo<br>Kelurahan
                            </div>
                            @endif
                        </div>
                        <div style="flex:1; text-align:center;">
                            <div style="font-size:11pt;">PEMERINTAH KOTA {{ strtoupper($config->city ?? 'BANDUNG') }}</div>
                            <div style="font-size:11pt;">KECAMATAN {{ strtoupper($config->district ?? '-') }}</div>
                            <div style="font-size:16pt; font-weight:bold; text-transform:uppercase;">
                                {{ $config->name ?? 'KELURAHAN' }}
                            </div>
                            <div style="font-size:9pt;">
                                @if($config && $config->address){{ $config->address }} &bull; @endif
                                Kode Pos {{ $config->pos_code ?? '' }}@if($config && $config->contact) &bull; Telp/Email: {{ $config->contact }}@endif
                            </div>
                        </div>
                    </div>

                    {{-- JUDUL --}}
                    <div style="text-align:center; margin:16px 0 20px;">
                        <div style="font-size:13pt; font-weight:bold; text-decoration:underline; text-transform:uppercase; letter-spacing:1px;">
                            Surat Keterangan Ahli Waris
                        </div>
                        <div style="font-size:11pt; margin-top:4px;">
                            Nomor: <span id="p-nomor-surat">{{ $nomorSurat }}</span>
                        </div>
                    </div>

                    {{-- PEMBUKA --}}
                    <p style="margin:0 0 14px 0; text-align:justify;">
                        Yang bertanda tangan di bawah ini, Lurah <b>{{ $config->name ?? 'Kelurahan' }}</b>,
                        Kecamatan <b>{{ $config->district ?? '-' }}</b>,
                        Kota <b>{{ $config->city ?? '-' }}</b>,
                        Provinsi <b>{{ $config->province ?? '-' }}</b>,
                        menerangkan dengan sesungguhnya bahwa:
                    </p>

                    {{-- DATA ALMARHUM --}}
                    <div style="margin-bottom:6px; font-weight:bold; font-size:10pt; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1px solid #ccc; padding-bottom:4px;">
                        Data Almarhum / Almarhumah
                    </div>
                    <table style="width:100%; border-collapse:collapse; margin:4px 0 16px 0;">
                        <tr>
                            <td style="width:37%; padding:2px 0;">Nama Lengkap</td>
                            <td style="width:3%;">:</td>
                            <td><b><span id="p-nama-almarhum">-</span></b></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">NIK</td>
                            <td>:</td>
                            <td><span id="p-nik-almarhum">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">Tempat / Tanggal Lahir</td>
                            <td>:</td>
                            <td><span id="p-ttl-almarhum">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0; vertical-align:top;">Alamat</td>
                            <td style="vertical-align:top;">:</td>
                            <td><span id="p-alamat-almarhum">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">RT / RW</td>
                            <td>:</td>
                            <td>RT <span id="p-rt">-</span> / RW <span id="p-rw">-</span></td>
                        </tr>
                        <tr>
                            <td style="padding:2px 0;">Tanggal Wafat</td>
                            <td>:</td>
                            <td><span id="p-tanggal-wafat">-</span></td>
                        </tr>
                    </table>

                    {{-- ISI SURAT --}}
                    <p style="margin:0 0 10px 0; text-align:justify;">
                        Telah meninggal dunia dan meninggalkan ahli waris yang sah sebagai berikut:
                    </p>

                    {{-- TABEL AHLI WARIS --}}
                    <div style="margin-bottom:6px; font-weight:bold; font-size:10pt; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1px solid #ccc; padding-bottom:4px;">
                        Daftar Ahli Waris
                    </div>
                    <table style="width:100%; border-collapse:collapse; margin:4px 0 16px 0; border:1px solid #000;">
                        <thead>
                            <tr style="background:#f0f0f0;">
                                <th style="border:1px solid #000; padding:4px 8px; text-align:center; font-size:10pt; width:8%;">No</th>
                                <th style="border:1px solid #000; padding:4px 8px; font-size:10pt;">Nama Lengkap</th>
                                <th style="border:1px solid #000; padding:4px 8px; font-size:10pt;">NIK</th>
                                <th style="border:1px solid #000; padding:4px 8px; font-size:10pt;">Tempat / Tgl Lahir</th>
                                <th style="border:1px solid #000; padding:4px 8px; font-size:10pt;">Hubungan</th>
                            </tr>
                        </thead>
                        <tbody id="p-tabel-waris">
                            <tr>
                                <td colspan="5" style="border:1px solid #000; padding:6px; text-align:center; color:#aaa; font-size:10pt;">
                                    Belum ada ahli waris
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- PENUTUP --}}
                    <p style="margin:0 0 10px 0; text-align:justify;">
                        Surat keterangan ini dibuat untuk keperluan
                        <b><span id="p-keperluan">........................</span></b>
                        dan dapat dipergunakan sebagaimana mestinya.
                    </p>
                    <p style="margin:0 0 20px 0; text-align:justify;">
                        Demikian surat keterangan ahli waris ini dibuat dengan sebenar-benarnya.
                    </p>

                    {{-- TTD --}}
                    <div style="display:flex; justify-content:flex-end; margin-top:28px;">
                        <div style="text-align:center; min-width:220px;">
                            <div>{{ $config->city ?? 'Bandung' }}, <span id="p-tanggal-surat">{{ now()->isoFormat('D MMMM Y') }}</span></div>
                            <div style="margin-top:4px;">Lurah {{ $config->name ?? '' }}</div>
                            <br><br><br><br>
                            <div style="border-bottom:1px solid #000; width:200px; margin:0 auto;"></div>
                            <div style="font-size:9pt; margin-top:4px;">NIP. ___________________________</div>
                        </div>
                    </div>

                </div>{{-- end surat-preview --}}
            </div>
        </div>
    </div>

</div>

{{-- ============================================================
     MODAL TAMBAH AHLI WARIS
============================================================ --}}
<div class="modal fade" id="modalTambahWaris" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content aw-modal">
            <div class="modal-header aw-modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="aw-modal-icon">
                        <i class="bx bx-user-plus"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0">Tambah Ahli Waris</h5>
                        <small class="text-muted">Cari dari data warga atau isi manual</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="aw-search-wrap mb-2">
                    <div class="aw-search-icon"><i class="bx bx-search"></i></div>
                    <input type="text" class="aw-input aw-search-input" id="searchWarisInput"
                        placeholder="Cari NIK atau nama warga..." autocomplete="off">
                    <div id="searchResultsWaris" class="aw-dropdown"></div>
                </div>
                <div class="aw-hint mb-4"><i class="bx bx-info-circle me-1"></i>Data akan otomatis terisi ke form di bawah</div>

                <div class="aw-modal-divider">
                    <span>atau isi manual</span>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="aw-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="aw-input" id="w-nama" placeholder="Nama ahli waris">
                    </div>
                    <div class="col-md-6">
                        <label class="aw-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" class="aw-input" id="w-nik" placeholder="16 digit NIK" maxlength="16">
                    </div>
                    <div class="col-md-6">
                        <label class="aw-label">Tempat Lahir</label>
                        <input type="text" class="aw-input" id="w-tempat-lahir" placeholder="Kota lahir">
                    </div>
                    <div class="col-md-6">
                        <label class="aw-label">Tanggal Lahir</label>
                        <input type="text" class="aw-input" id="w-tanggal-lahir" placeholder="contoh: 15 Maret 1990">
                    </div>
                    <div class="col-12">
                        <label class="aw-label">Hubungan dengan Almarhum <span class="text-danger">*</span></label>
                        <select class="aw-input aw-select" id="w-hubungan">
                            <option value="">-- Pilih hubungan --</option>
                            <option value="Istri">Istri</option>
                            <option value="Suami">Suami</option>
                            <option value="Anak Kandung">Anak Kandung</option>
                            <option value="Anak Angkat">Anak Angkat</option>
                            <option value="Orang Tua">Orang Tua</option>
                            <option value="Saudara Kandung">Saudara Kandung</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer aw-modal-footer">
                <button type="button" class="aw-btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="aw-btn-primary" id="btnKonfirmasiWaris">
                    <i class="bx bx-check me-1"></i> Tambahkan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* =============================================
   AW - AHLI WARIS - CUSTOM STYLES
   ============================================= */

    /* Page Header */
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

    /* Buttons */
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

    /* Card */
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

    /* Sections */
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

    .aw-section-label-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0;
    }

    .aw-section-label-row .aw-section-label {
        margin-bottom: 0;
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

    /* Divider */
    .aw-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 0 22px;
    }

    /* Inputs */
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

    /* Search */
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

    /* Hint text */
    .aw-hint {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 5px;
    }

    /* Search items */
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

    /* Empty waris */
    .aw-empty-state {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
        padding: 16px;
        border: 1.5px dashed #e2e8f0;
        border-radius: 10px;
        color: #94a3b8;
        font-size: 13px;
        margin-top: 10px;
    }

    .aw-empty-state i {
        font-size: 18px;
    }

    /* Waris items */
    .waris-item {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 11px 13px;
        margin-bottom: 8px;
        transition: border-color .15s;
    }

    .waris-item:hover {
        border-color: #cbd5e1;
    }

    .waris-nama {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }

    .waris-detail {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    .waris-hubungan {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 20px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 600;
        margin-top: 4px;
    }

    /* Action buttons */
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
        transition: background .15s, transform .1s;
    }

    .aw-btn-primary:hover {
        background: #2563eb;
    }

    .aw-btn-primary:active {
        transform: scale(.98);
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

    .aw-btn-add {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        background: #eff6ff;
        color: #3b82f6;
        border: 1.5px solid #bfdbfe;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all .15s;
    }

    .aw-btn-add:hover {
        background: #dbeafe;
        border-color: #93c5fd;
    }

    /* Preview card */
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

    .aw-modal-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #94a3b8;
        font-size: 12px;
        margin: 4px 0;
    }

    .aw-modal-divider::before,
    .aw-modal-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .aw-modal-footer {
        border-top: 1px solid #f1f5f9;
        background: #fafafa;
        padding: 14px 22px;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
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

    /* Trash button in waris */
    .btn-hapus-waris {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff4f4;
        color: #ef4444;
        border: 1.5px solid #fecaca;
        border-radius: 7px;
        font-size: 15px;
        cursor: pointer;
        transition: all .15s;
        flex-shrink: 0;
    }

    .btn-hapus-waris:hover {
        background: #fee2e2;
    }

    /* Print */
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

    #surat-preview {
        border: none;
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

        document.getElementById('tanggal_wafat').addEventListener('input', function() {
            setP('p-tanggal-wafat', this.value);
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

        // SEARCH ALMARHUM
        let timeoutAlmarhum;
        const searchAlmarhumEl = document.getElementById('searchAlmarhum');
        const resultsAlmarhum = document.getElementById('searchResultsAlmarhum');

        searchAlmarhumEl.addEventListener('input', function() {
            clearTimeout(timeoutAlmarhum);
            const q = this.value.trim();
            if (q.length < 2) {
                resultsAlmarhum.style.display = 'none';
                return;
            }
            timeoutAlmarhum = setTimeout(() => {
                fetch(`{{ route('ahli_waris.search_almarhum') }}?q=${encodeURIComponent(q)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        resultsAlmarhum.innerHTML = '';
                        if (!data.success || !data.data.length) {
                            resultsAlmarhum.innerHTML = '<div class="search-item text-muted">Almarhum tidak ditemukan</div>';
                        } else {
                            data.data.forEach(w => {
                                const item = document.createElement('div');
                                item.className = 'search-item';
                                item.innerHTML = `<div class="item-name">${w.name} <span class="badge bg-danger ms-1" style="font-size:9px;">Meninggal</span></div>
                                    <div class="item-nik">NIK: ${w.nik}</div>`;
                                item.addEventListener('click', () => fillAlmarhum(w));
                                resultsAlmarhum.appendChild(item);
                            });
                        }
                        resultsAlmarhum.style.display = 'block';
                    });
            }, 350);
        });

        function fillAlmarhum(w) {
            resultsAlmarhum.style.display = 'none';
            searchAlmarhumEl.value = w.name;
            setF('nama_almarhum', w.name);
            setF('nik_almarhum', w.nik);
            setF('tempat_lahir', w.birth_place);
            setF('tanggal_lahir', w.birth_date_fmt);
            setF('alamat', w.address);
            setF('rt', w.rt);
            setF('rw', w.rw);
            setF('no_kk', w.no_kk);
            setP('p-nama-almarhum', w.name);
            setP('p-nik-almarhum', w.nik);
            setP('p-ttl-almarhum', `${w.birth_place}, ${w.birth_date_fmt}`);
            setP('p-alamat-almarhum', w.address);
            setP('p-rt', w.rt);
            setP('p-rw', w.rw);
        }

        // SEARCH WARIS
        let timeoutWaris;
        const searchWarisEl = document.getElementById('searchWarisInput');
        const resultsWaris = document.getElementById('searchResultsWaris');

        searchWarisEl.addEventListener('input', function() {
            clearTimeout(timeoutWaris);
            const q = this.value.trim();
            if (q.length < 2) {
                resultsWaris.style.display = 'none';
                return;
            }
            timeoutWaris = setTimeout(() => {
                fetch(`{{ route('ahli_waris.search_warga') }}?q=${encodeURIComponent(q)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        resultsWaris.innerHTML = '';
                        if (!data.success || !data.data.length) {
                            resultsWaris.innerHTML = '<div class="search-item text-muted">Warga tidak ditemukan</div>';
                        } else {
                            data.data.forEach(w => {
                                const item = document.createElement('div');
                                item.className = 'search-item';
                                item.innerHTML = `<div class="item-name">${w.name}</div>
                                    <div class="item-nik">NIK: ${w.nik}</div>`;
                                item.addEventListener('click', () => {
                                    resultsWaris.style.display = 'none';
                                    searchWarisEl.value = w.name;
                                    document.getElementById('w-nama').value = w.name;
                                    document.getElementById('w-nik').value = w.nik;
                                    document.getElementById('w-tempat-lahir').value = w.birth_place || '';
                                    document.getElementById('w-tanggal-lahir').value = w.birth_date_fmt || '';
                                });
                                resultsWaris.appendChild(item);
                            });
                        }
                        resultsWaris.style.display = 'block';
                    });
            }, 350);
        });

        document.addEventListener('click', function(e) {
            if (!searchAlmarhumEl.contains(e.target) && !resultsAlmarhum.contains(e.target))
                resultsAlmarhum.style.display = 'none';
            if (!searchWarisEl.contains(e.target) && !resultsWaris.contains(e.target))
                resultsWaris.style.display = 'none';
        });

        // DAFTAR AHLI WARIS
        let daftarWaris = [];

        const hubunganColors = {
            'Istri': ['#fce7f3', '#be185d'],
            'Suami': ['#ede9fe', '#6d28d9'],
            'Anak Kandung': ['#dcfce7', '#15803d'],
            'Anak Angkat': ['#d1fae5', '#065f46'],
            'Orang Tua': ['#fef3c7', '#b45309'],
            'Saudara Kandung': ['#dbeafe', '#1d4ed8'],
        };

        function renderDaftarWaris() {
            const container = document.getElementById('listAhliWaris');
            const emptyEl = document.getElementById('emptyWaris');
            container.innerHTML = '';
            if (daftarWaris.length === 0) {
                emptyEl.style.display = 'flex';
                renderPreviewWaris();
                return;
            }
            emptyEl.style.display = 'none';
            daftarWaris.forEach((w, idx) => {
                const [bg, color] = hubunganColors[w.hubungan] || ['#f1f5f9', '#475569'];
                const div = document.createElement('div');
                div.className = 'waris-item';
                div.innerHTML = `
                <div style="flex:1; min-width:0;">
                    <div class="waris-nama">${idx + 1}. ${w.nama}</div>
                    <div class="waris-detail">NIK: ${w.nik}</div>
                    ${w.tanggal_lahir ? `<div class="waris-detail">${w.tempat_lahir}, ${w.tanggal_lahir}</div>` : ''}
                    <span class="waris-hubungan" style="background:${bg}; color:${color};">${w.hubungan}</span>
                </div>
                <button class="btn-hapus-waris" onclick="hapusWaris(${idx})" title="Hapus">
                    <i class="bx bx-trash"></i>
                </button>`;
                container.appendChild(div);
            });
            renderPreviewWaris();
        }

        function renderPreviewWaris() {
            const tbody = document.getElementById('p-tabel-waris');
            if (daftarWaris.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" style="border:1px solid #000; padding:6px; text-align:center; color:#aaa; font-size:10pt;">Belum ada ahli waris</td></tr>`;
                return;
            }
            tbody.innerHTML = daftarWaris.map((w, i) => `
            <tr>
                <td style="border:1px solid #000; padding:4px 8px; text-align:center;">${i + 1}</td>
                <td style="border:1px solid #000; padding:4px 8px;">${w.nama}</td>
                <td style="border:1px solid #000; padding:4px 8px;">${w.nik}</td>
                <td style="border:1px solid #000; padding:4px 8px;">${w.tempat_lahir ? w.tempat_lahir + ', ' + w.tanggal_lahir : '-'}</td>
                <td style="border:1px solid #000; padding:4px 8px;">${w.hubungan}</td>
            </tr>`).join('');
        }

        window.hapusWaris = function(idx) {
            daftarWaris.splice(idx, 1);
            renderDaftarWaris();
        };

        document.getElementById('btnTambahWaris').addEventListener('click', function() {
            ['w-nama', 'w-nik', 'w-tempat-lahir', 'w-tanggal-lahir'].forEach(id => document.getElementById(id).value = '');
            document.getElementById('w-hubungan').value = '';
            document.getElementById('searchWarisInput').value = '';
            new bootstrap.Modal(document.getElementById('modalTambahWaris')).show();
        });

        document.getElementById('btnKonfirmasiWaris').addEventListener('click', function() {
            const nama = document.getElementById('w-nama').value.trim();
            const nik = document.getElementById('w-nik').value.trim();
            const hubungan = document.getElementById('w-hubungan').value;
            if (!nama || !nik || nik.length !== 16) {
                alert('Nama dan NIK (16 digit) wajib diisi.');
                return;
            }
            if (!hubungan) {
                alert('Pilih hubungan dengan almarhum.');
                return;
            }
            daftarWaris.push({
                nama,
                nik,
                hubungan,
                tempat_lahir: document.getElementById('w-tempat-lahir').value.trim(),
                tanggal_lahir: document.getElementById('w-tanggal-lahir').value.trim(),
            });
            bootstrap.Modal.getInstance(document.getElementById('modalTambahWaris')).hide();
            renderDaftarWaris();
        });

        renderDaftarWaris();

        // RESET
        function resetForm() {
            ['nama_almarhum', 'nik_almarhum', 'tempat_lahir', 'tanggal_lahir',
                'alamat', 'rt', 'rw', 'no_kk', 'tanggal_wafat'
            ].forEach(id => setF(id, ''));
            searchAlmarhumEl.value = '';
            document.getElementById('keperluan_select').value = '';
            document.getElementById('keperluan_manual').value = '';
            document.getElementById('keperluan_manual').classList.add('d-none');
            daftarWaris = [];
            renderDaftarWaris();
            ['p-nama-almarhum', 'p-nik-almarhum', 'p-ttl-almarhum',
                'p-alamat-almarhum', 'p-rt', 'p-rw', 'p-tanggal-wafat'
            ].forEach(id => setP(id, '-'));
            setP('p-keperluan', '........................');
        }

        document.getElementById('btnReset').addEventListener('click', function() {
            if (!confirm('Reset semua data form?')) return;
            resetForm();
        });

        // SIMPAN
        document.getElementById('btnSimpan').addEventListener('click', async function() {
            const btn = this;
            const nik_almarhum = document.getElementById('nik_almarhum').value;
            if (!nik_almarhum || nik_almarhum.length !== 16) {
                alert('Pilih data almarhum terlebih dahulu.');
                return;
            }
            if (daftarWaris.length === 0) {
                alert('Minimal 1 ahli waris harus ditambahkan.');
                return;
            }

            const keperluanVal = document.getElementById('keperluan_select').value === 'lainnya' ?
                document.getElementById('keperluan_manual').value :
                document.getElementById('keperluan_select').value;

            const payload = {
                nomor_surat: document.getElementById('nomor_surat').value,
                nama_almarhum: document.getElementById('nama_almarhum').value,
                nik_almarhum,
                tempat_lahir: document.getElementById('tempat_lahir').value,
                tanggal_lahir: document.getElementById('tanggal_lahir').value,
                alamat: document.getElementById('alamat').value,
                rt: document.getElementById('rt').value,
                rw: document.getElementById('rw').value,
                no_kk: document.getElementById('no_kk').value,
                tanggal_wafat: document.getElementById('tanggal_wafat').value,
                ahli_waris: daftarWaris,
                keperluan: keperluanVal,
                tanggal_surat: document.getElementById('tanggal_surat').value,
            };

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            try {
                const res = await fetch('{{ route("ahli_waris.store") }}', {
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