@extends('layouts.app')

@section('title', 'Surat Lamaran')

@section('content')
<div class="content">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
        <a href="{{ route('dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
            <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
        </a>
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <i class="fa fa-bars"></i>
        </a>
        <div class="navbar-nav align-items-center ms-auto">
            @auth
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-lg-2" src="{{ asset('assets/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                    <span class="d-none d-lg-inline-flex">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                    <a href="#" class="dropdown-item">My Profile</a>
                    <a href="#" class="dropdown-item">Settings</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Main Content -->
    <div class="container-fluid pt-4 px-4">
        <div class="row">
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4 class="mb-4 text-primary">
                        <i class="fa fa-envelope me-2"></i>Generator Surat Lamaran
                    </h4>

                    <div class="row g-4">
                        <!-- Left Form Section -->
                        <div class="col-lg-6">
                            <div class="bg-dark rounded p-4">
                                <h5 class="mb-4">A. Data Surat Lamaran</h5>

                                <form id="formLamaran">
                                    <div class="mb-3">
                                        <label class="form-label">Kota & Tanggal</label>
                                        <input type="text" class="form-control bg-secondary border-0" id="tanggal" placeholder="Bandung, 30 Januari 2026">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Subjek Surat</label>
                                        <input type="text" class="form-control bg-secondary border-0" id="subject" placeholder="Job Application">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Penerima & Alamat</label>
                                        <textarea class="form-control bg-secondary border-0" id="penerima" rows="3" placeholder="HRD Manager&#10;PT. Example Company"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Paragraf 1 (Pembuka)</label>
                                        <textarea class="form-control bg-secondary border-0" id="p1" rows="3" placeholder="Dengan hormat bapak/ibu, melalui surat ini saya ingin mengajukan lamaran pekerjaan..."></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Paragraf 2 (Isi)</label>
                                        <textarea class="form-control bg-secondary border-0" id="p2" rows="3" placeholder="Saya tertarik untuk melamar posisi..."></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Paragraf 3 (Penutup)</label>
                                        <textarea class="form-control bg-secondary border-0" id="p3" rows="3" placeholder="Demikian surat lamaran ini saya buat. Besar harapan saya untuk dapat diterima..."></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nama Penyusun</label>
                                        <input type="text" class="form-control bg-secondary border-0" id="nama_penyusun" placeholder="Nama Lengkap Anda">
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-primary" id="btnSave">
                                            <i class="fa fa-save me-2"></i>Simpan Data
                                        </button>
                                        <button type="button" class="btn btn-success" id="btnPrint">
                                            <i class="fa fa-print me-2"></i>Cetak PDF
                                        </button>
                                        <button type="button" class="btn btn-danger" id="btnClear">
                                            <i class="fa fa-trash me-2"></i>Clear
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Right Preview Section -->
                        <div class="col-lg-6">
                            <div class="rounded p-4" style="min-height: 600px; background-color: white; color: black;">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold" style="color: #000000;">JOB APPLICATION LETTER</h3>
                                    <hr style="border: 2px solid #ff0000;">
                                    <p class="text-end mb-0"><span id="p-tanggal">Bandung, 30 Januari 2026</span></p>
                                </div>

                                <div class="letter-content">
                                    <p class="mb-3"><strong>Subject:</strong> <span id="p-subject">Job Application</span></p>

                                    <p class="mb-2">Dear,</p>
                                    <p class="mb-4"><span id="p-penerima">HRD Manager</span></p>

                                    <p class="mb-2">Dear,</p>
                                    <p class="mb-4 text-justify"><span id="p-p1">Dengan hormat bapak/ibu, melalui surat ini saya ingin mengajukan lamaran pekerjaan.</span></p>

                                    <p class="mb-4 text-justify"><span id="p-p2">Saya tertarik untuk melamar posisi yang tersedia di perusahaan Bapak/Ibu pimpin.</span></p>

                                    <p class="mb-4 text-justify"><span id="p-p3">Demikian surat lamaran ini saya buat. Besar harapan saya untuk dapat diterima.</span></p>

                                    <p class="mb-5">Dengan Hormat,</p>

                                    <p class="fw-bold"><span id="p-nama_penyusun">-</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded-top p-4">
            <div class="row">
                <div class="col-12 text-center">
                    &copy; <a href="#">Surat Desa</a>, All Right Reserved.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Default values untuk preview
        const defaultValues = {
            'tanggal': 'Bandung, 30 Januari 2026',
            'subject': 'Job Application',
            'penerima': 'HRD Manager',
            'p1': 'Dengan hormat bapak/ibu, melalui surat ini saya ingin mengajukan lamaran pekerjaan.',
            'p2': 'Saya tertarik untuk melamar posisi yang tersedia di perusahaan Bapak/Ibu pimpin.',
            'p3': 'Demikian surat lamaran ini saya buat. Besar harapan saya untuk dapat diterima.',
            'nama_penyusun': '-'
        };

        const fields = ['tanggal', 'subject', 'penerima', 'p1', 'p2', 'p3', 'nama_penyusun'];

        // Auto update preview saat user mengetik
        fields.forEach(field => {
            const input = document.getElementById(field);
            const preview = document.getElementById('p-' + field);

            if (input && preview) {
                input.addEventListener('input', function() {
                    preview.textContent = this.value || defaultValues[field];
                });
            }
        });

        // Simpan Data
        document.getElementById('btnSave').addEventListener('click', function() {
            const data = {};
            fields.forEach(field => {
                data[field] = document.getElementById(field).value;
            });
            localStorage.setItem('suratLamaran', JSON.stringify(data));
            alert('Data berhasil disimpan!');
        });

        // Clear Form
        document.getElementById('btnClear').addEventListener('click', function() {
            if (confirm('Yakin ingin menghapus semua data?')) {
                fields.forEach(field => {
                    // Clear input
                    document.getElementById(field).value = '';

                    // Reset preview ke default
                    const preview = document.getElementById('p-' + field);
                    preview.textContent = defaultValues[field];
                });
                localStorage.removeItem('suratLamaran');
                alert('Data berhasil dihapus!');
            }
        });

        // Cetak PDF
        document.getElementById('btnPrint').addEventListener('click', function() {
            window.print();
        });

        // Load saved data
        const savedData = localStorage.getItem('suratLamaran');
        if (savedData) {
            const data = JSON.parse(savedData);
            fields.forEach(field => {
                if (data[field]) {
                    const input = document.getElementById(field);
                    const preview = document.getElementById('p-' + field);
                    input.value = data[field];
                    preview.textContent = data[field];
                }
            });
        }
    });

    // Print styles
    const style = document.createElement('style');
    style.textContent = `
    @media print {
        .sidebar, .navbar, .bg-secondary, button, .btn {
            display: none !important;
        }
        .content {
            margin: 0 !important;
            padding: 0 !important;
        }
        .col-lg-6:first-child {
            display: none !important;
        }
        .col-lg-6:last-child {
            width: 100% !important;
            max-width: 100% !important;
        }
    }
`;
    document.head.appendChild(style);
</script>
@endsection