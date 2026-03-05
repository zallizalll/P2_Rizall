<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\AkteKematianRepository;

class AkteKematianController extends Controller
{
    protected $repo;

    public function __construct(AkteKematianRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $config     = $this->repo->getConfig();
        $nomorSurat = $this->repo->generateNomorSurat();

        return view('pages.surat.akte_kematian.index', compact('config', 'nomorSurat'));
    }

    public function searchWarga(Request $request)
    {
        $keyword = $request->get('q', '');

        if (strlen($keyword) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Masukkan minimal 2 karakter',
                'data'    => [],
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => $this->repo->searchWarga($keyword),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'       => 'required|string',
            'warga_id'          => 'required|integer|exists:warga,id',
            'nik'               => 'required|string|size:16',
            'nama'              => 'required|string|max:255',
            'tanggal_meninggal' => 'required|string',
            'tempat_meninggal'  => 'required|string|max:255',
            'sebab_meninggal'   => 'required|string|max:500',
            'nama_pelapor'      => 'required|string|max:255',
            'hubungan_pelapor'  => 'required|string|max:100',
        ]);

        try {
            $detail = [
                'nomor_surat'       => $request->nomor_surat,
                'warga_id'          => $request->warga_id,
                'nik'               => $request->nik,
                'nama'              => $request->nama,
                'tempat_lahir'      => $request->tempat_lahir,
                'tanggal_lahir'     => $request->tanggal_lahir,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'agama'             => $request->agama,
                'pekerjaan'         => $request->pekerjaan,
                'alamat'            => $request->alamat,
                'rt'                => $request->rt,
                'rw'                => $request->rw,
                'no_kk'             => $request->no_kk,
                'umur'              => $request->umur,
                'tanggal_meninggal' => $request->tanggal_meninggal,
                'tempat_meninggal'  => $request->tempat_meninggal,
                'sebab_meninggal'   => $request->sebab_meninggal,
                'nama_pelapor'      => $request->nama_pelapor,
                'nik_pelapor'       => $request->nik_pelapor,
                'hubungan_pelapor'  => $request->hubungan_pelapor,
                'tanggal_surat'     => $request->tanggal_surat ?? now()->isoFormat('D MMMM Y'),
            ];

            // 1. Simpan surat
            $doc = $this->repo->save($detail);

            // 2. Ubah status warga jadi meninggal
            $this->repo->updateStatusMeninggal((int) $request->warga_id);

            return response()->json([
                'success' => true,
                'message' => 'Akte Kematian berhasil disimpan. Status warga telah diubah menjadi meninggal.',
                'data'    => ['id' => $doc->id, 'nomor_surat' => $detail['nomor_surat']],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Redirect ke arsip terpadu, filter Akte Kematian
    public function arsip()
    {
        return redirect()->route('surat.arsip', ['jenis' => 'AKTE_KEMATIAN']);
    }
}