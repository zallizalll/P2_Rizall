@extends('layouts.app')

@section('title', 'Konfigurasi Kelurahan')

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

    .cfg-wrap {
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

    /* ── ALERT ── */
    .cfg-alert {
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

    .cfg-alert.success {
        background: rgba(45, 212, 191, .1);
        border: 1px solid rgba(45, 212, 191, .2);
        color: #2dd4bf;
    }

    .cfg-alert.danger {
        background: rgba(230, 57, 70, .1);
        border: 1px solid rgba(230, 57, 70, .2);
        color: var(--accent2);
    }

    .cfg-alert.info {
        background: rgba(99, 179, 237, .1);
        border: 1px solid rgba(99, 179, 237, .2);
        color: #63b3ed;
    }

    .cfg-alert ul {
        margin: 0;
        padding-left: 16px;
    }

    .cfg-alert .cls {
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

    .cfg-alert .cls:hover {
        opacity: 1;
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

    .btn-wp.warning {
        background: rgba(251, 191, 36, .12);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, .22);
    }

    .btn-wp.warning:hover {
        background: rgba(251, 191, 36, .22);
        color: #fbbf24;
    }

    /* ── CONTENT GRID ── */
    .cfg-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        animation: fadeUp .35s ease .08s both;
    }

    @media(max-width: 768px) {
        .cfg-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ── DETAIL CARD ── */
    .cfg-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .cfg-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .cfg-card-title {
        font-family: 'Syne', sans-serif;
        font-size: 14px;
        font-weight: 800;
        color: var(--text);
    }

    .cfg-card-body {
        padding: 20px;
    }

    /* info rows */
    .cfg-row {
        display: flex;
        align-items: flex-start;
        padding: 11px 0;
        border-bottom: 1px solid var(--border);
    }

    .cfg-row:last-child {
        border-bottom: none;
    }

    .cfg-row-label {
        width: 140px;
        flex-shrink: 0;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--text3);
        padding-top: 1px;
    }

    .cfg-row-value {
        font-size: 13.5px;
        font-weight: 500;
        color: var(--text);
    }

    /* logo card */
    .logo-area {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 32px 20px;
        min-height: 200px;
    }

    .logo-area img {
        max-height: 180px;
        max-width: 100%;
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 12px;
        background: var(--surface2);
        object-fit: contain;
    }

    .logo-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .logo-empty-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        background: var(--surface2);
        border: 1px solid var(--border);
        display: grid;
        place-items: center;
        font-size: 26px;
    }

    .logo-empty p {
        color: var(--text3);
        font-size: 13px;
    }

    /* empty state */
    .empty-state {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        text-align: center;
        padding: 56px 20px;
        animation: fadeUp .35s ease .08s both;
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        background: var(--surface2);
        border: 1px solid var(--border);
        display: grid;
        place-items: center;
        margin: 0 auto 16px;
        font-size: 26px;
    }

    .empty-state h4 {
        font-size: 16px;
        color: var(--text);
        font-weight: 700;
    }

    .empty-state p {
        color: var(--text3);
        font-size: 13px;
        margin-top: 6px 0 20px;
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

    .modal-body .form-control {
        background: var(--surface2) !important;
        border: 1px solid var(--border) !important;
        border-radius: var(--radius-sm) !important;
        color: var(--text) !important;
        font-family: inherit;
        font-size: 13.5px;
        padding: 9px 14px !important;
        transition: border-color .18s;
    }

    .modal-body .form-control:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px rgba(230, 57, 70, .12) !important;
        outline: none;
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
<div class="cfg-wrap">

    {{-- ── PAGE HEADER ── --}}
    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">Konfigurasi Kelurahan</div>
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard.admin') }}">Dashboard</a>
                <span class="sep">›</span>
                <span class="cur">Konfigurasi</span>
            </div>
        </div>
        @if(!$config)
        <button class="btn-wp primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa fa-plus"></i> Tambah Konfigurasi
        </button>
        @else
        <button class="btn-wp warning" data-bs-toggle="modal" data-bs-target="#editModal">
            <i class="fa fa-edit"></i> Edit Konfigurasi
        </button>
        @endif
    </div>

    {{-- ── ALERTS ── --}}
    @if(session('success'))
    <div class="cfg-alert success" id="alertOk">
        <i class="fa fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    @if($errors->any())
    <div class="cfg-alert danger" id="alertErr">
        <i class="fa fa-exclamation-circle" style="margin-top:2px;flex-shrink:0"></i>
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button class="cls" onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    {{-- ── CONTENT ── --}}
    @if($config)

    <div class="cfg-grid">

        {{-- Detail Info --}}
        <div class="cfg-card">
            <div class="cfg-card-header">
                <span class="cfg-card-title">Informasi Kelurahan</span>
            </div>
            <div class="cfg-card-body">
                <div class="cfg-row">
                    <span class="cfg-row-label">Nama</span>
                    <span class="cfg-row-value">{{ $config->name }}</span>
                </div>
                <div class="cfg-row">
                    <span class="cfg-row-label">Provinsi</span>
                    <span class="cfg-row-value">{{ $config->province }}</span>
                </div>
                <div class="cfg-row">
                    <span class="cfg-row-label">Kota</span>
                    <span class="cfg-row-value">{{ $config->city }}</span>
                </div>
                <div class="cfg-row">
                    <span class="cfg-row-label">Kecamatan</span>
                    <span class="cfg-row-value">{{ $config->district }}</span>
                </div>
                <div class="cfg-row">
                    <span class="cfg-row-label">Kode Pos</span>
                    <span class="cfg-row-value">{{ $config->pos_code }}</span>
                </div>
            </div>
        </div>

        {{-- Logo --}}
        <div class="cfg-card">
            <div class="cfg-card-header">
                <span class="cfg-card-title">Logo Kelurahan</span>
            </div>
            <div class="logo-area">
                @if($config->logo)
                <img src="{{ asset('uploads/logo/' . $config->logo) }}" alt="Logo Kelurahan">
                @else
                <div class="logo-empty">
                    <div class="logo-empty-icon">🏛️</div>
                    <p>Belum ada logo</p>
                </div>
                @endif
            </div>
        </div>

    </div>

    @else

    {{-- Empty State --}}
    <div class="empty-state">
        <div class="empty-icon">🏛️</div>
        <h4>Belum ada konfigurasi</h4>
        <p style="margin: 8px 0 20px">Silakan tambahkan konfigurasi kelurahan terlebih dahulu.</p>
        <button class="btn-wp primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa fa-plus"></i> Tambah Konfigurasi
        </button>
    </div>

    @endif


    <!-- {{-- ── ADD MODAL ── --}}
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            
                enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Konfigurasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Kelurahan <span class="req">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="cth: Kelurahan Sukamaju" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Provinsi <span class="req">*</span></label>
                            <input type="text" name="province" class="form-control" placeholder="cth: Jawa Barat" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kota <span class="req">*</span></label>
                            <input type="text" name="city" class="form-control" placeholder="cth: Bandung" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kecamatan <span class="req">*</span></label>
                            <input type="text" name="district" class="form-control" placeholder="cth: Coblong" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="pos_code" class="form-control" placeholder="cth: 40132" maxlength="5">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Logo Kelurahan</label>
                            <input type="file" name="logo" class="form-control" accept="image/*">
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

    {{-- ── EDIT MODAL ── --}}
    @if($config)
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            
                enctype="multipart/form-data" class="modal-content">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Konfigurasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Kelurahan <span class="req">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $config->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Provinsi <span class="req">*</span></label>
                            <input type="text" name="province" class="form-control" value="{{ $config->province }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kota <span class="req">*</span></label>
                            <input type="text" name="city" class="form-control" value="{{ $config->city }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kecamatan <span class="req">*</span></label>
                            <input type="text" name="district" class="form-control" value="{{ $config->district }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="pos_code" class="form-control" value="{{ $config->pos_code }}" maxlength="5">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Logo Kelurahan</label>
                            @if($config->logo)
                            <div style="margin-bottom:10px">
                                <img src="{{ asset('uploads/logo/' . $config->logo) }}"
                                    style="height:60px;border-radius:8px;border:1px solid var(--border);padding:6px;background:var(--surface2)">
                            </div>
                            @endif
                            <input type="file" name="logo" class="form-control" accept="image/*">
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
    </div> -->
    <!-- @endif -->

</div>{{-- /cfg-wrap --}}
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