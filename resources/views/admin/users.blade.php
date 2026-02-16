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
                    <img class="rounded-circle me-lg-2" src="{{ asset('admin-temp/img/user.jpg') }}"
                        style="width: 40px; height: 40px;">
                    <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-bottom m-0">
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

    <!-- Alerts -->
    @if(session('success'))
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="container-fluid pt-4 px-4">
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- User Management -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded p-4">
            <div class="d-flex justify-content-between mb-4">
                <h6 class="mb-0">Kelola User</h6>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fa fa-user-plus"></i> Tambah User
                </button>
            </div>

            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover">
                    <thead>
                        <tr class="text-white">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Jabatan</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                    <span class="badge bg-success ms-2">You</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>

                            <!-- FIXED NO HP -->
                            <td>{{ $user->detail->no_hp ?? '-' }}</td>

                            <td>
                                @if($user->jabatan)
                                <span class="badge bg-info">{{ $user->jabatan->name }}</span>
                                @else
                                <span class="badge bg-secondary">-</span>
                                @endif
                            </td>

                            <td>{{ $user->created_at->format('d M Y') }}</td>

                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal{{ $user->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>

                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus user {{ $user->name }}?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data user</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="addUserModal">
        <div class="modal-dialog">
            <form action="{{ route('admin.users.store') }}" method="POST" class="modal-content bg-secondary">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label>Email *</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label>Password *</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <!-- FIX: no_hp -->
                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" class="form-control" name="no_hp" placeholder="08xxxxxxxxx">
                    </div>

                    <div class="mb-3">
                        <label>Jabatan</label>
                        <select name="jabatan_id" class="form-select">
                            <option value="">- Pilih Jabatan -</option>
                            @foreach($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}">{{ $jabatan->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
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

    <!-- Edit User Modal -->
    @foreach($users as $user)
    <div class="modal fade" id="editUserModal{{ $user->id }}">
        <div class="modal-dialog">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="modal-content bg-secondary">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama *</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Email *</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password"
                            placeholder="Kosongkan jika tidak diubah">
                    </div>

                    <!-- FIX: no_hp pakai relasi -->
                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" class="form-control" name="no_hp"
                            value="{{ $user->detail->no_hp ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label>Jabatan</label>
                        <select name="jabatan_id" class="form-select">
                            <option value="">- Pilih Jabatan -</option>
                            @foreach($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}"
                                {{ $jabatan->id == $user->jabatan_id ? 'selected' : '' }}>
                                {{ $jabatan->name }}
                            </option>
                            @endforeach
                        </select>
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

</div>

@push('scripts')
<script>
    setTimeout(() => {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
@endpush

@endsection