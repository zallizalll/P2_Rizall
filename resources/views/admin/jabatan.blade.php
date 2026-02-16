@extends('layouts.app')

@section('content')
<!-- Content Start -->
<div class="content">
    <!-- Navbar Start -->
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

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Jabatan Management Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Kelola Jabatan</h6>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addJabatanModal">
                    <i class="fa fa-briefcase"></i> Tambah Jabatan
                </button>
            </div>

            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th>No</th>
                            <th>Nama Jabatan</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Jumlah User</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jabatans as $index => $jabatan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $jabatan->name }}</td>
                            <td><span class="badge bg-info">{{ $jabatan->slug }}</span></td>
                            <td>{{ $jabatan->description ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $jabatan->users->count() }} user</span>
                            </td>
                            <td>
                                <!-- Edit -->
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editJabatanModal{{ $jabatan->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('admin.jabatan.destroy', $jabatan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus jabatan {{ $jabatan->name }}?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data jabatan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Jabatan Management End -->

    <!-- Add Jabatan Modal -->
    <div class="modal fade" id="addJabatanModal" tabindex="-1" aria-labelledby="addJabatanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.jabatan.store') }}" method="POST" class="modal-content bg-secondary">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addJabatanLabel">Tambah Jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Contoh: Manager" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Deskripsi jabatan (opsional)"></textarea>
                        <small class="text-muted">Slug akan dibuat otomatis dari nama jabatan</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Jabatan Modal End -->

    <!-- Footer Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded-top p-4">
            <div class="row">
                <div class="col-12 col-sm-6 text-center text-sm-start">
                    &copy; Kantor Desa, All Right Reserved.
                </div>
                <div class="col-12 col-sm-6 text-center text-sm-end">
                    Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
</div>
<!-- Content End -->

<!-- Semua Modal Edit Ditaruh di Luar -->
@foreach($jabatans as $jabatan)
<div class="modal fade" id="editJabatanModal{{ $jabatan->id }}" tabindex="-1" aria-labelledby="editJabatanLabel{{ $jabatan->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.jabatan.update', $jabatan->id) }}" method="POST" class="modal-content bg-secondary">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editJabatanLabel{{ $jabatan->id }}">Edit Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama Jabatan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ $jabatan->name }}" required>
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea class="form-control" name="description" rows="3">{{ $jabatan->description }}</textarea>
                    <small class="text-muted">Slug akan diupdate otomatis dari nama jabatan</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
    // Auto hide alert after 3 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
@endpush