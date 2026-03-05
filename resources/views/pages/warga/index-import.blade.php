@extends('layouts.app')

@section('content')
<div class="content">

    <!-- Navbar -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <i class="fa fa-bars"></i>
        </a>
        <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-lg-2" src="{{ asset('admin-temp/img/user.jpg') }}" style="width:40px; height:40px;">
                    <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-bottom m-0">
                    <a href="#" class="dropdown-item">Profil</a>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    @if(session('success'))
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('warning'))
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="fa fa-exclamation-triangle me-2"></i> {{ session('warning') }}
            <ul class="mt-2 mb-0">
                @foreach(session('import_errors', []) as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa fa-times-circle me-2"></i> {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Import Form -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded p-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Import Data Warga</h6>
                <a href="{{ route('admin.pages.warga') }}" class="btn btn-sm btn-dark">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.pages.warga.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-white">Pilih File Excel (.xlsx / .xls)</label>
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls">
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-upload me-1"></i> Import
                    </button>
                    <a href="{{ asset('template_import_warga_v2.xlsx') }}" download class="btn btn-outline-light">
                        <i class="fa fa-download me-1"></i> Download Template
                    </a>
                </div>
            </form>

            <!-- Panduan Kolom -->
            <div class="mt-4">
                <h6 class="text-white mb-3">Panduan Kolom Excel:</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-white align-middle">
                        <thead>
                            <tr class="text-white">
                                <th>Kolom</th>
                                <th>Keterangan</th>
                                <th>Contoh</th>
                                <th>Wajib</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>nik</td><td>Nomor Induk Kependudukan</td><td>3201010202020001</td><td>✅</td></tr>
                            <tr><td>nama</td><td>Nama lengkap warga</td><td>Andi Wijaya</td><td>✅</td></tr>
                            <tr><td>jenis_kelamin</td><td>L = Laki-laki, P = Perempuan</td><td>L</td><td>✅</td></tr>
                            <tr><td>tempat_lahir</td><td>Kota tempat lahir</td><td>Bandung</td><td>✅</td></tr>
                            <tr><td>tanggal_lahir</td><td>Format YYYY-MM-DD</td><td>1982-05-10</td><td>✅</td></tr>
                            <tr><td>agama</td><td>Islam, Kristen, dst</td><td>Islam</td><td>❌</td></tr>
                            <tr><td>pendidikan</td><td>SD, SMP, SMA, S1, dst</td><td>S1</td><td>❌</td></tr>
                            <tr><td>status_pernikahan</td><td>Kawin / Belum Kawin / Cerai Hidup</td><td>Kawin</td><td>❌</td></tr>
                            <tr><td>pekerjaan</td><td>Pekerjaan warga</td><td>Pengusaha</td><td>❌</td></tr>
                            <tr><td>golongan_darah</td><td>A, B, AB, O</td><td>A</td><td>❌</td></tr>
                            <tr><td>status_kehidupan</td><td>hidup / meninggal</td><td>hidup</td><td>❌</td></tr>
                            <tr><td>no_kk</td><td>Nomor Kartu Keluarga</td><td>9876543210000001</td><td>❌</td></tr>
                            <tr><td>buat_kk_baru</td><td>ya = otomatis buat KK baru jika belum ada</td><td>ya</td><td>❌</td></tr>
                            <tr><td>rt</td><td>Nomor RT (jika buat KK baru)</td><td>1</td><td>❌</td></tr>
                            <tr><td>rw</td><td>Nomor RW (jika buat KK baru)</td><td>1</td><td>❌</td></tr>
                            <tr><td>alamat_kk</td><td>Alamat KK (jika buat KK baru)</td><td>Jl. Merdeka No. 10</td><td>❌</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded-top p-4 text-center">
            &copy; Kantor Desa — All Rights Reserved.
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    setTimeout(() => $('.alert').fadeOut('slow'), 4000);
</script>
@endpush
