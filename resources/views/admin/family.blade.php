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


    <!-- Family Management -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Data Keluarga</h6>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fa fa-plus"></i> Tambah Keluarga
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-start mb-0">
                    <thead>
                        <tr class="text-white">
                            <th>No</th>
                            <th>No KK</th>
                            <th>RT</th>
                            <th>RW</th>
                            <th>Alamat</th>
                            <th>Kepala Keluarga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($family as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row->no_kk }}</td>
                            <td>{{ $row->rt?->no ?? '-' }}</td>
                            <td>{{ $row->rw?->no ?? '-' }}</td>
                            <td>{{ $row->address }}</td>
                            <td>
                                {{ $row->head?->name ?? '-' }}
                            </td>

                            <td>
                                <!-- Edit -->
                                <button class="btn btn-info btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $row->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('admin.family.destroy', $row->id) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus data ini?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>


    <!-- Edit Family Modals (DIPINDAH KE LUAR LOOP TABEL) -->
    @foreach($family as $row)
    <div class="modal fade" id="editModal{{ $row->id }}">
        <div class="modal-dialog">
            <form action="{{ route('admin.family.update', $row->id) }}" method="POST" class="modal-content bg-secondary">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5>Edit Keluarga</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label>No KK</label>
                    <input type="text" name="no_kk" class="form-control" value="{{ $row->no_kk }}" required>

                    <label class="mt-2">RT</label>
                    <select name="rt_id" class="form-select" required>
                        @foreach($rukun->where('type','RT') as $rt)
                        <option value="{{ $rt->id }}" {{ $row->rt_id == $rt->id ? 'selected' : '' }}>
                            {{ $rt->no }}
                        </option>
                        @endforeach
                    </select>

                    <label class="mt-2">RW</label>
                    <select name="rw_id" class="form-select" required>
                        @foreach($rukun->where('type','RW') as $rw)
                        <option value="{{ $rw->id }}" {{ $row->rw_id == $rw->id ? 'selected' : '' }}>
                            {{ $rw->no }}
                        </option>
                        @endforeach
                    </select>

                    <label class="mt-2">Alamat</label>
                    <textarea name="address" class="form-control" required>{{ $row->address }}</textarea>

                    <label class="mt-2">Kepala Keluarga</label>
                    <select name="family_head_id" class="form-select">
                        <option value="">-- Pilih Kepala Keluarga --</option>
                        @foreach($warga as $w)
                        <option value="{{ $w->id }}" {{ $row->family_head_id == $w->id ? 'selected' : '' }}>
                            {{ $w->name }} - {{ $w->nik }}
                        </option>
                        @endforeach
                    </select>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
    @endforeach


    <!-- Add Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <form action="{{ route('admin.family.store') }}"
                method="POST" class="modal-content bg-secondary">
                @csrf

                <div class="modal-header">
                    <h5>Tambah Keluarga</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label>No KK</label>
                    <input type="text" name="no_kk" class="form-control" required>

                    <label class="mt-2">RT</label>
                    <select class="form-select" name="rt_id" required>
                        <option value="">-- Pilih RT --</option>
                        @foreach($rukun->where('type', 'RT') as $rt)
                        <option value="{{ $rt->id }}">{{ $rt->no }}</option>
                        @endforeach
                    </select>

                    <label class="mt-2">RW</label>
                    <select class="form-select" name="rw_id" required>
                        <option value="">-- Pilih RW --</option>
                        @foreach($rukun->where('type', 'RW') as $rw)
                        <option value="{{ $rw->id }}">{{ $rw->no }}</option>
                        @endforeach
                    </select>

                    <label class="mt-2">Alamat</label>
                    <textarea name="address" class="form-control" required></textarea>

                    <label class="mt-2">Kepala Keluarga</label>
                    <select name="family_head_id" class="form-select">
                        <option value="">-- Pilih Kepala Keluarga --</option>
                        @foreach($warga as $w)
                        <option value="{{ $w->id }}">{{ $w->name }} - {{ $w->nik }}</option>
                        @endforeach
                    </select>

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