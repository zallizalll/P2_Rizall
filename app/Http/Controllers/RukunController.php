<?php

namespace App\Http\Controllers;

use App\Models\Rukun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RukunController extends Controller
{
    public function index()
    {
        $rukuns = Rukun::orderBy('type', 'asc')
            ->orderBy('no', 'asc')
            ->get();

        return view('pages.rukun.index', compact('rukuns'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:RT,RW',
            'no'   => 'required|string|max:10',
        ], [
            'type.required' => 'Type harus dipilih',
            'type.in'       => 'Type harus RT atau RW',
            'no.required'   => 'Nomor harus diisi',
            'no.max'        => 'Nomor maksimal 10 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->route('rukun.index')
                ->withErrors($validator)
                ->withInput();
        }

        $exists = Rukun::where('type', $request->type)
            ->where('no', $request->no)
            ->exists();

        if ($exists) {
            return redirect()->route('rukun.index')
                ->withErrors(['no' => 'Kombinasi Type dan Nomor ini sudah ada'])
                ->withInput();
        }

        try {
            $rukun = Rukun::create([
                'type' => $request->type,
                'no'   => $request->no,
            ]);

            return redirect()->route('rukun.index')
                ->with('success', 'Data ' . $rukun->type . ' nomor ' . $rukun->no . ' berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('rukun.index')
                ->withErrors(['system' => 'Terjadi kesalahan saat menyimpan data'])
                ->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $rukun = Rukun::find($id);

        if (!$rukun) {
            return redirect()->route('rukun.index')
                ->withErrors(['system' => 'Data tidak ditemukan']);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:RT,RW',
            'no'   => 'required|string|max:10',
        ], [
            'type.required' => 'Type harus dipilih',
            'type.in'       => 'Type harus RT atau RW',
            'no.required'   => 'Nomor harus diisi',
            'no.max'        => 'Nomor maksimal 10 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->route('rukun.index')
                ->withErrors($validator)
                ->withInput();
        }

        $exists = Rukun::where('type', $request->type)
            ->where('no', $request->no)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->route('rukun.index')
                ->withErrors(['no' => 'Kombinasi Type dan Nomor ini sudah ada'])
                ->withInput();
        }

        try {
            $rukun->update([
                'type' => $request->type,
                'no'   => $request->no,
            ]);

            return redirect()->route('rukun.index')
                ->with('success', 'Data ' . $rukun->type . ' nomor ' . $rukun->no . ' berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('rukun.index')
                ->withErrors(['system' => 'Terjadi kesalahan saat mengupdate data'])
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        $rukun = Rukun::find($id);

        if (!$rukun) {
            return redirect()->route('rukun.index')
                ->withErrors(['system' => 'Data tidak ditemukan']);
        }

        try {
            $rukunName = $rukun->type . ' ' . $rukun->no;
            $rukun->delete();

            return redirect()->route('rukun.index')
                ->with('success', 'Data ' . $rukunName . ' berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('rukun.index')
                ->withErrors(['system' => 'Gagal menghapus data']);
        }
    }
}
