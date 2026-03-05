<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\SktmRepository;

class SktmController extends Controller
{
    protected $repo;

    public function __construct(SktmRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $config     = $this->repo->getConfig();
        $nomorSurat = $this->repo->generateNomorSurat();

        return view('pages.surat.sktm.index', compact('config', 'nomorSurat'));
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
            'nomor_surat' => 'required|string',
            'nik'         => 'required|string|size:16',
            'nama'        => 'required|string|max:255',
            'keperluan'   => 'required|string|max:500',
        ]);

        try {
            $detail = [
                'nomor_surat'   => $request->nomor_surat,
                'nik'           => $request->nik,
                'nama'          => $request->nama,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama'         => $request->agama,
                'status_nikah'  => $request->status_nikah,
                'pekerjaan'     => $request->pekerjaan,
                'alamat'        => $request->alamat,
                'rt'            => $request->rt,
                'rw'            => $request->rw,
                'no_kk'         => $request->no_kk,
                'keperluan'     => $request->keperluan,
                'tanggal_surat' => $request->tanggal_surat ?? now()->isoFormat('D MMMM Y'),
            ];

            $doc = $this->repo->save($detail);

            return response()->json([
                'success' => true,
                'message' => 'SKTM berhasil disimpan ke arsip',
                'data'    => ['id' => $doc->id, 'nomor_surat' => $detail['nomor_surat']],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Redirect ke arsip terpadu, filter SKTM
    public function arsip()
    {
        return redirect()->route('surat.arsip', ['jenis' => 'SKTM']);
    }
}