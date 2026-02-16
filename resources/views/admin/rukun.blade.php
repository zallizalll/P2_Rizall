@extends('layouts.app')

@section('content')

<!-- Content Start -->
<div class="content">

    <!-- Navbar -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <i class="fa fa-bars"></i>
        </a>
        <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-lg-2" src="{{ asset('admin-temp/img/user.jpg') }}" alt=""
                        style="width: 40px; height: 40px;">
                    <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                    <a href="#" class="dropdown-item">Profil</a>
                    <a href="#" class="dropdown-item">Pengaturan</a>

                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
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
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Card Table -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded p-4">

            <div class="d-flex justify-content-between mb-4">
                <h6 class="mb-0">Kelola Rukun (RT / RW)</h6>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRukunModal">
                    <i class="fa fa-plus"></i> Tambah
                </button>
            </div>

            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th>No</th>
                            <th>Type</th>
                            <th>Nomor</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rukun as $index => $r)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $r->type }}</td>
                            <td>{{ $r->no }}</td>
                            <td>{{ $r->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editRukunModal{{ $r->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.rukun.destroy', $r->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus data ini?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addRukunModal">
        <div class="modal-dialog">
            <form action="{{ route('admin.rukun.store') }}" method="POST" class="modal-content bg-secondary">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Rukun</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Type *</label>
                        <select class="form-select" name="type" required>
                            <option value="RT">RT</option>
                            <option value="RW">RW</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nomor *</label>
                        <input type="text" name="no" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Tambah</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Semua Modal Edit -->
    @foreach($rukun as $r)
    <div class="modal fade" id="editRukunModal{{ $r->id }}">
        <div class="modal-dialog">
            <form action="{{ route('admin.rukun.update', $r->id) }}" method="POST" class="modal-content bg-secondary">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Rukun</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Type *</label>
                        <select name="type" class="form-select">
                            <option value="RT" {{ $r->type == 'RT' ? 'selected' : '' }}>RT</option>
                            <option value="RW" {{ $r->type == 'RW' ? 'selected' : '' }}>RW</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nomor *</label>
                        <input type="text" name="no" class="form-control" value="{{ $r->no }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
    @endforeach

    <!-- Footer -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded-top p-4">
            <div class="row">
                <div class="col-12 col-sm-6 text-center text-sm-start">
                    &copy; Kantor Desa, All Right Reserved.
                </div>
                <div class="col-12 col-sm-6 text-center text-sm-end">
                    Designed by <a href="https://htmlcodex.com">HTML Codex</a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Content End -->

@endsection