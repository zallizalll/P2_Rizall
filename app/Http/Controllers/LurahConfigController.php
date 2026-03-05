<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\LurahConfigRepository;

class LurahConfigController extends Controller
{
    protected $repo;

    public function __construct(LurahConfigRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $config = $this->repo->get();
        return view('pages.lurah_config.index', compact('config'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city'     => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'pos_code' => 'required|string|max:10',
            'address'  => 'nullable|string|max:500',
            'contact'  => 'nullable|string|max:255',
            'logo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required'     => 'Nama kelurahan wajib diisi',
            'province.required' => 'Provinsi wajib diisi',
            'city.required'     => 'Kota/Kabupaten wajib diisi',
            'district.required' => 'Kecamatan wajib diisi',
            'pos_code.required' => 'Kode pos wajib diisi',
            'logo.image'        => 'Logo harus berupa gambar',
            'logo.mimes'        => 'Logo harus format jpg, jpeg, atau png',
            'logo.max'          => 'Ukuran logo maksimal 2MB',
        ]);

        try {
            $data     = $request->only(['name', 'province', 'city', 'district', 'pos_code', 'address', 'contact']);
            $existing = $this->repo->get();

            if ($request->hasFile('logo')) {
                $logoDir = public_path('assets/images/logo');

                if (!file_exists($logoDir)) {
                    mkdir($logoDir, 0755, true);
                }

                if ($existing && $existing->logo) {
                    $oldPath = public_path($existing->logo);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $file     = $request->file('logo');
                $filename = 'logo_kelurahan_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($logoDir, $filename);

                $data['logo'] = 'assets/images/logo/' . $filename;
            }

            if ($existing) {
                $config  = $this->repo->update($data);
                $message = 'Profil kelurahan berhasil diupdate';
            } else {
                $config  = $this->repo->create($data);
                $message = 'Profil kelurahan berhasil disimpan';
            }

            return response()->json([
                'success'  => true,
                'message'  => $message,
                'is_new'   => !$existing,
                'logo_url' => $config->logo ? asset($config->logo) : null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage(),
            ], 500);
        }
    }
}