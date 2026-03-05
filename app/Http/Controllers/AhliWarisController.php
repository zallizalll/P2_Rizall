<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\AhliWarisRepository;

class AhliWarisController extends Controller
{
    protected $repo;

    public function __construct(AhliWarisRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $config     = $this->repo->getConfig();
        $nomorSurat = $this->repo->generateNomorSurat();

        return view('pages.surat.ahli_waris.index', compact('config', 'nomorSurat'));
    }

    // Search almarhum (warga meninggal)
    public function searchAlmarhum(Request $request)
    {
        $keyword = $request->get('q', '');

        if (strlen($keyword) < 2) {
            return response()->json(['success' => false, 'data' => []]);
        }

        return response()->json([
            'success' => true,
            'data'    => $this->repo->searchAlmarhum($keyword),
        ]);
    }

    // Search warga hidup untuk ahli waris
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
            'nomor_surat'   => 'required|string',
            'nama_almarhum' => 'required|string',
            'nik_almarhum'  => 'required|string|size:16',
            'ahli_waris'    => 'required|array|min:1',
            'ahli_waris.*.nama'     => 'required|string',
            'ahli_waris.*.nik'      => 'required|string|size:16',
            'ahli_waris.*.hubungan' => 'required|string',
        ], [
            'ahli_waris.required'           => 'Minimal 1 ahli waris harus ditambahkan',
            'ahli_waris.min'                => 'Minimal 1 ahli waris harus ditambahkan',
            'ahli_waris.*.nama.required'    => 'Nama ahli waris wajib diisi',
            'ahli_waris.*.nik.required'     => 'NIK ahli waris wajib diisi',
            'ahli_waris.*.nik.size'         => 'NIK ahli waris harus 16 digit',
            'ahli_waris.*.hubungan.required'=> 'Hubungan ahli waris wajib diisi',
        ]);

        try {
            $detail = [
                'nomor_surat'    => $request->nomor_surat,
                'nama_almarhum'  => $request->nama_almarhum,
                'nik_almarhum'   => $request->nik_almarhum,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'alamat'         => $request->alamat,
                'rt'             => $request->rt,
                'rw'             => $request->rw,
                'no_kk'          => $request->no_kk,
                'tanggal_wafat'  => $request->tanggal_wafat,
                'ahli_waris'     => $request->ahli_waris, // array of {nama, nik, hubungan, ttl}
                'keperluan'      => $request->keperluan,
                'tanggal_surat'  => $request->tanggal_surat ?? now()->isoFormat('D MMMM Y'),
            ];

            $doc = $this->repo->save($detail);

            return response()->json([
                'success' => true,
                'message' => 'Surat Ahli Waris berhasil disimpan ke arsip',
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
        return redirect()->route('surat.arsip', ['jenis' => 'AHLI_WARIS']);
    }
}