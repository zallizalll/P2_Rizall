<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rizall - Lamaran Application Letter</title>
    <link rel="stylesheet" href="{{ asset('css/preview.css') }}">
</head>

<body>

    <h3 class="title">Data Surat Lamaran</h3>

    <div class="container">

        <!-- ================= LEFT FORM ================= -->
        <div class="left">

            <!-- ================= SECTION A ================= -->
            <div id="step-a" class="step">
                <h4>A. Data Surat Lamaran</h4>

                <div class="form-group">
                    <label>Kota & Tanggal</label>
                    <input type="text" id="tanggal">
                </div>

                <div class="form-group">
                    <label>Subjek Surat</label>
                    <input type="text" id="subject">
                </div>

                <div class="form-group">
                    <label>Penerima & Alamat</label>
                    <textarea id="penerima"></textarea>
                </div>

                <div class="form-group">
                    <label>Parapraf 1 (Pembuka)</label>
                    <textarea id="p1"></textarea>
                </div>

                <div class="form-group">
                    <label>Paragraf 2 (Isi)</label>
                    <textarea id="p2"></textarea>
                </div>

                <div class="form-group">
                    <label>Paragraf 3 (Penutup)</label>
                    <textarea id="p3"></textarea>
                </div>


                <div class="form-group">
                    <label>Nama Penyusun</label>
                    <input type="text" id="nama_penyusun">
                </div>

                <div class="button-row">
                    <button type="button" id="btnSave">Simpan Data</button>
                    <button type="button" id="btnPrint">Cetak PDF</button>
                    <button type="button" id="btnClear">Clear</button>
                </div>

            </div>
        </div>

        <!-- ================= RIGHT PREVIEW ================= -->
        <div class="right">

            <div class="info-header">
                <img id="p-logo" class="logo" style="display:none;">

                <div class="info-text">
                    <h2><span id="p-fase">JOB APPLICATION LETTER</span></h2>
                    <hr>
                    <p class="tanggal-preview"><span id="p-tanggal">Bandung, 30 Januari 2026</span></p>
                </div>
            </div>

            <!-- A -->
            <h5>
                <p>Subject : <span id="p-subject">Job Application</span></p>
            </h5>
            <p>Dear,</p>
            <p><span id="p-penerima"></span></p>
            <br>
            <p>Dear,</p>
            <p><span id="p-p1">dengan hormat bapak ini saya membuat surat lamaran ini</span></p>
            <br>
            <p><span id="p-p2">dengan surat ini saya ingin melamar di divisi </span></p>
            <br>
            <p><span id="p-p3">semoga saya bisa di terima disini</span></p>
            <br>
            <p>Dengan Hormat, <span id="p-sincerely"></span></p>
            <br>
            <br>
            <br>
            <span id="p-nama_penyusun">-</span>

            <hr>
        </div>
    </div>
    <script src="{{ asset('js/preview.js') }}"></script>
</body>

</html>