@extends('layouts.app')

@section('content')
<div class="content">

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <i class="fa fa-bars"></i>
        </a>
        <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-lg-2"
                        src="{{ asset('admin-temp/img/user.jpg') }}"
                        style="width:40px; height:40px;">
                    <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-bottom m-0">
                    <a href="#" class="dropdown-item">Profil</a>
                    <a href="#" class="dropdown-item">Pengaturan</a>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Keluar
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Alerts -->
    @if(session('success'))
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
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

    <!-- Lurah Config -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Konfigurasi Kelurahan</h6>

                @if(!$config)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fa fa-plus"></i> Tambah Konfigurasi
                </button>
                @endif
            </div>

            @if($config)
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-dark">
                        <div class="card-body">
                            <table class="table table-borderless text-white">
                                <tr>
                                    <td width="150"><strong>Nama Kelurahan</strong></td>
                                    <td>: {{ $config->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Provinsi</strong></td>
                                    <td>: {{ $config->province }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kota</strong></td>
                                    <td>: {{ $config->city }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kecamatan</strong></td>
                                    <td>: {{ $config->district }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kode Pos</strong></td>
                                    <td>: {{ $config->pos_code }}</td>
                                </tr>
                            </table>

                            <div class="mt-3">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fa fa-edit"></i> Edit
                                </button>

                                <form action="{{ route('admin.lurah-config.destroy', $config->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus konfigurasi ini?')">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-dark">
                        <div class="card-body text-center">
                            <strong class="text-white d-block mb-3">Logo Kelurahan</strong>
                            @if($config->logo)
                            <img src="{{ asset('uploads/logo/' . $config->logo) }}"
                                alt="Logo"
                                class="img-fluid rounded"
                                style="max-height: 200px;">
                            @else
                            <p class="text-muted">Belum ada logo</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal">
                <div class="modal-dialog">
                    <form action="{{ route('admin.lurah-config.update', $config->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="modal-content bg-secondary">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5>Edit Konfigurasi Kelurahan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <label>Nama Kelurahan</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ $config->name }}" required>

                            <label class="mt-2">Provinsi</label>
                            <input type="text" name="province" class="form-control"
                                value="{{ $config->province }}" required>

                            <label class="mt-2">Kota</label>
                            <input type="text" name="city" class="form-control"
                                value="{{ $config->city }}" required>

                            <label class="mt-2">Kecamatan</label>
                            <input type="text" name="district" class="form-control"
                                value="{{ $config->district }}" required>

                            <label class="mt-2">Kode Pos</label>
                            <input type="text" name="pos_code" class="form-control"
                                value="{{ $config->pos_code }}" required>

                            <label class="mt-2">Logo</label>
                            @if($config->logo)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/logo/' . $config->logo) }}"
                                    alt="Current Logo"
                                    class="img-thumbnail"
                                    style="max-height: 100px;">
                                <p class="text-muted small mb-0">Logo saat ini</p>
                            </div>
                            @endif
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah logo</small>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>

            @else
            <div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                Belum ada konfigurasi kelurahan. Silakan tambahkan terlebih dahulu.
            </div>
            @endif

        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <form action="{{ route('admin.lurah-config.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="modal-content bg-secondary">
                @csrf

                <div class="modal-header">
                    <h5>Tambah Konfigurasi Kelurahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label>Nama Kelurahan</label>
                    <input type="text" name="name" class="form-control" required>

                    <label class="mt-2">Provinsi</label>
                    <input type="text" name="province" class="form-control" required>

                    <label class="mt-2">Kota</label>
                    <input type="text" name="city" class="form-control" required>

                    <label class="mt-2">Kecamatan</label>
                    <input type="text" name="district" class="form-control" required>

                    <label class="mt-2">Kode Pos</label>
                    <input type="text" name="pos_code" class="form-control" required>

                    <label class="mt-2">Logo</label>
                    <input type="file" name="logo" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>

            </form>
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
    setTimeout(() => $('.alert').fadeOut('slow'), 3000);
</script>
@endpush