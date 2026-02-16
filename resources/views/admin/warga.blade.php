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
    <!-- End Navbar -->

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

    <!-- Warga Table -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Data Warga</h6>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fa fa-plus"></i> Tambah Warga
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-start mb-0">
                    <thead>
                        <tr class="text-white">
                            <th>No</th>
                            <th>NIK</th>
                            <th>No KK</th>
                            <th>Nama</th>
                            <th>Gender</th>
                            <th>TTL</th>
                            <th>Status Hidup</th>
                            <th>Pendidikan</th>
                            <th>Status Kawin</th>
                            <th>Pekerjaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($warga as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row->nik }}</td>
                            <td>{{ $row->no_kk }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->gender }}</td>
                            <td>{{ $row->birth_place }}, {{ $row->birth_date }}</td>
                            <td>{{ $row->living_status }}</td>
                            <td>{{ $row->education }}</td>
                            <td>{{ $row->married_status }}</td>
                            <td>{{ $row->occupation }}</td>

                            <td>
                                <!-- Edit -->
                                <button class="btn btn-info btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $row->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('admin.warga.delete', $row->id) }}"
                                      method="POST" class="d-inline">
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
                            <td colspan="11" class="text-center">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <form action="{{ route('admin.warga.store') }}" method="POST" class="modal-content bg-secondary">
                @csrf

                <div class="modal-header">
                    <h5>Tambah Warga</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control">

                    <label>No KK</label>
                    <input type="text" name="no_kk" class="form-control">

                    <label>Nama</label>
                    <input type="text" name="name" class="form-control">

                    <label>Gender</label>
                    <select name="gender" class="form-select">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>

                    <label>Tempat Lahir</label>
                    <input type="text" name="birth_place" class="form-control">

                    <label>Tanggal Lahir</label>
                    <input type="date" name="birth_date" class="form-control" max="{{ date('Y-m-d') }}">

                    <label>Agama</label>
                    <input type="text" name="religious" class="form-control">

                    <label>Pendidikan</label>
                    <input type="text" name="education" class="form-control">

                    <label>Status Hidup</label>
                    <select name="living_status" class="form-select">
                        <option value="hidup">Hidup</option>
                        <option value="meninggal">Meninggal</option>
                        <option value="pindah">Pindah</option>
                        <option value="tidak_diketahui">Tidak Diketahui</option>
                    </select>

                    <label>Status Kawin</label>
                    <input type="text" name="married_status" class="form-control">

                    <label>Pekerjaan</label>
                    <input type="text" name="occupation" class="form-control">

                    <label>Golongan Darah</label>
                    <input type="text" name="blood_type" class="form-control">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Tambah</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Edit Modals -->
    @foreach($warga as $row)
    <div class="modal fade" id="editModal{{ $row->id }}">
        <div class="modal-dialog">
            <form action="{{ route('admin.warga.update', $row->id) }}" method="POST" class="modal-content bg-secondary">
                @csrf
                @method('POST')

                <div class="modal-header">
                    <h5>Edit Warga</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ $row->nik }}">

                    <label>No KK</label>
                    <input type="text" name="no_kk" class="form-control" value="{{ $row->no_kk }}">

                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ $row->name }}">

                    <label>Gender</label>
                    <select name="gender" class="form-select">
                        <option value="L" {{ $row->gender=='L'?'selected':'' }}>Laki-laki</option>
                        <option value="P" {{ $row->gender=='P'?'selected':'' }}>Perempuan</option>
                    </select>

                    <label>Tempat Lahir</label>
                    <input type="text" name="birth_place" class="form-control" value="{{ $row->birth_place }}">

                    <label>Tanggal Lahir</label>
                    <input type="date" name="birth_date" class="form-control" value="{{ $row->birth_date }}" max="{{ date('Y-m-d') }}">

                    <label>Agama</label>
                    <input type="text" name="religious" class="form-control" value="{{ $row->religious }}">

                    <label>Pendidikan</label>
                    <input type="text" name="education" class="form-control" value="{{ $row->education }}">

                    <label>Status Hidup</label>
                    <select name="living_status" class="form-select">
                        <option value="hidup" {{ $row->living_status=='hidup'?'selected':'' }}>Hidup</option>
                        <option value="meninggal" {{ $row->living_status=='meninggal'?'selected':'' }}>Meninggal</option>
                        <option value="pindah" {{ $row->living_status=='pindah'?'selected':'' }}>Pindah</option>
                        <option value="tidak_diketahui" {{ $row->living_status=='tidak_diketahui'?'selected':'' }}>
                            Tidak Diketahui
                        </option>
                    </select>

                    <label>Status Kawin</label>
                    <input type="text" name="married_status" class="form-control" value="{{ $row->married_status }}">

                    <label>Pekerjaan</label>
                    <input type="text" name="occupation" class="form-control" value="{{ $row->occupation }}">

                    <label>Golongan Darah</label>
                    <input type="text" name="blood_type" class="form-control" value="{{ $row->blood_type }}">

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
