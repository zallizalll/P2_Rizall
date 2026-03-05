<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\PindahKeluarRepository;

class PindahKeluarController extends Controller
{
    protected $repo;

    public function __construct(PindahKeluarRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $config     = $this->repo->getConfig();
        $nomorSurat = $this->repo->generateNomorSurat();

        return view('pages.surat.pindah_keluar.index', compact('config', 'nomorSurat'));
    }

    public function searchWarga(Request $request)
    {
        $keyword = $request->get('q', '');

        if (strlen($keyword) < 2) {
            return response()->json(['success' => false, 'data' => []]);
        }

        return response()->json([
            'success' => true,
            'data'    => $this->repo->searchWarga($keyword),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'    => 'required|string',
            'warga_id'       => 'required|integer|exists:warga,id',
            'nik'            => 'required|string|size:16',
            'nama'           => 'required|string|max:255',
            'alamat_tujuan'  => 'required|string|max:500',
            'alasan_pindah'  => 'required|string|max:500',
        ], [
            'warga_id.required'      => 'Pilih warga terlebih dahulu',
            'warga_id.exists'        => 'Data warga tidak ditemukan',
            'nik.size'               => 'NIK harus 16 digit',
            'alamat_tujuan.required' => 'Alamat tujuan wajib diisi',
            'alasan_pindah.required' => 'Alasan pindah wajib diisi',
        ]);

        try {
            $detail = [
                'nomor_surat'    => $request->nomor_surat,
                'warga_id'       => $request->warga_id,
                'nik'            => $request->nik,
                'nama'           => $request->nama,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'agama'          => $request->agama,
                'status_nikah'   => $request->status_nikah,
                'pekerjaan'      => $request->pekerjaan,
                'no_kk'          => $request->no_kk,
                'alamat_asal'    => $request->alamat_asal,
                'rt'             => $request->rt,
                'rw'             => $request->rw,
                'alamat_tujuan'  => $request->alamat_tujuan,
                'kelurahan_tujuan' => $request->kelurahan_tujuan,
                'kecamatan_tujuan' => $request->kecamatan_tujuan,
                'kota_tujuan'    => $request->kota_tujuan,
                'alasan_pindah'  => $request->alasan_pindah,
                'tanggal_surat'  => $request->tanggal_surat ?? now()->isoFormat('D MMMM Y'),
            ];

            // 1. Simpan surat
            $doc = $this->repo->save($detail);

            // 2. Update status warga jadi pindah
            $this->repo->updateStatusPindah((int) $request->warga_id);

            return response()->json([
                'success' => true,
                'message' => 'Surat Pindah Keluar berhasil disimpan. Status warga telah diubah menjadi pindah.',
                'data'    => ['id' => $doc->id, 'nomor_surat' => $detail['nomor_surat']],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Redirect ke arsip terpadu
    public function arsip()
    {
        return redirect()->route('arsip.index', ['jenis' => 'PINDAH_KELUAR']);
    }
}