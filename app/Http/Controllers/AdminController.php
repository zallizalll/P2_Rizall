<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jabatan;
use App\Models\Rukun;
use App\Models\Family;
use App\Models\LurahConfig;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ====================================================
    //                    USER METHODS
    // ====================================================

    public function users()
    {
        $users = User::with('jabatan')->get();
        $jabatans = Jabatan::all();

        return view('admin.users', compact('users', 'jabatans'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8',
            'jabatan_id' => 'nullable|exists:jabatan,id',
            'no_hp'      => 'nullable|string|max:15',
        ]);

        // 1. Simpan user utama
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'jabatan_id' => $request->jabatan_id,
        ]);

        // 2. Simpan detail user
        $user->detail()->create([
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'jabatan_id' => 'nullable|exists:jabatan,id',
            'no_hp'      => 'nullable|string|max:15',
        ]);

        // 1. Update tabel users
        $user = User::findOrFail($id);
        $user->update([
            'name'       => $request->name,
            'jabatan_id' => $request->jabatan_id,
        ]);

        // 2. Update atau create tabel user_detail
        $user->detail()->updateOrCreate(
            [], // otomatis cari user_detail berdasarkan user_id
            [
                'no_hp' => $request->no_hp,
            ]
        );

        return redirect()->back()->with('success', 'User berhasil diperbarui!');
    }


    public function userDestroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah hapus user yang sedang login
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                ->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil dihapus!');
    }

    // ====================================================
    //                  JABATAN METHODS
    // ====================================================

    public function jabatan()
    {
        $jabatans = Jabatan::with('users')->get();
        return view('admin.jabatan', compact('jabatans'));
    }

    public function jabatanStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            Jabatan::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Jabatan berhasil ditambahkan!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangkap error duplicate entry
            if ($e->getCode() == 23000) {
                return redirect()->back()
                    ->with('error', 'Jabatan dengan nama tersebut sudah ada!')
                    ->withInput();
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function jabatanUpdate(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $jabatan = Jabatan::findOrFail($id);

        $jabatan->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.jabatan')
            ->with('success', 'Jabatan berhasil diupdate!');
    }

    public function jabatanDestroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        if ($jabatan->users()->count() > 0) {
            return redirect()->route('admin.jabatan')
                ->with('error', 'Tidak bisa menghapus jabatan yang masih digunakan user!');
        }

        $jabatan->delete();

        return redirect()->route('admin.jabatan')
            ->with('success', 'Jabatan berhasil dihapus!');
    }

    // ====================================================
    //                  RUKUN METHODS
    // ====================================================
    public function rukun()
    {
        $rukun = Rukun::orderBy('type')->orderBy('no')->get();

        return view('admin.rukun', compact('rukun'));
    }

    public function rukun_store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:RT,RW',
            'no'   => 'required|max:255'
        ]);

        Rukun::create([
            'type' => $request->type,
            'no'   => $request->no
        ]);

        return back()->with('success', 'Data Rukun berhasil ditambahkan.');
    }

    public function rukun_update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:RT,RW',
            'no'   => 'required|max:255'
        ]);

        $rukun = Rukun::findOrFail($id);

        $rukun->update([
            'type' => $request->type,
            'no'   => $request->no
        ]);

        return back()->with('success', 'Data Rukun berhasil diperbarui.');
    }

    public function rukun_destroy($id)
    {
        $rukun = Rukun::findOrFail($id);
        $rukun->delete();

        return back()->with('success', 'Data Rukun berhasil dihapus.');
    }

    // ====================================================
    //                  FAMILY METHODS
    // ====================================================
    public function family()
    {
        $family = Family::with(['rt', 'rw', 'head'])->get();
        $rukun  = Rukun::orderBy('type')->orderBy('no')->get();
        $warga = Warga::orderBy('name')->get();

        return view('admin.family', compact('family', 'rukun', 'warga'));
    }


    public function family_store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required',
            'rt_id'  => 'required',
            'rw_id' => 'required',
            'address' => 'required',
            'family_head_id' => 'nullable'
        ]);

        Family::create($request->all());

        return redirect()->route('admin.family')->with('success', 'Data keluarga berhasil ditambahkan');
    }

    public function family_update(Request $request, $id)
    {
        $request->validate([
            'no_kk' => 'required',
            'rt_id'  => 'required',
            'rw_id' => 'required',
            'address' => 'required',
            'family_head_id' => 'nullable'
        ]);

        $family = Family::findOrFail($id);
        $family->update($request->all());

        return redirect()->route('admin.family')->with('success', 'Data keluarga berhasil diperbarui');
    }

    public function family_destroy($id)
    {
        Family::findOrFail($id)->delete();
        return redirect()->route('admin.family')->with('success', 'Data keluarga berhasil dihapus');
    }

    // ====================================================
    //                     WARGA METHODS
    // ====================================================

    public function warga()
    {
        $warga = Warga::orderBy('name')->get();
        return view('admin.warga', compact('warga'));
    }

    public function warga_store(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'no_kk' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'religious' => 'nullable',
            'education' => 'nullable',
            'living_status' => 'nullable',
            'married_status' => 'nullable',
            'occupation' => 'nullable',
            'blood_type' => 'nullable',
        ]);

        Warga::create($request->all());

        return redirect()->route('admin.warga')
            ->with('success', 'Data warga berhasil ditambahkan');
    }

    public function warga_update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required',
            'no_kk' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
        ]);

        $warga = Warga::findOrFail($id);
        $warga->update($request->all());

        return redirect()->route('admin.warga')
            ->with('success', 'Data warga berhasil diperbarui');
    }

    public function warga_destroy($id)
    {
        Warga::findOrFail($id)->delete();

        return redirect()->route('admin.warga')
            ->with('success', 'Data warga berhasil dihapus');
    }

    // ====================================================
    //                  LURAH CONFIG METHODS
    // ====================================================
    public function lurahConfig()
    {
        $config = LurahConfig::first();
        return view('admin.lurah-config', compact('config'));
    }

    public function lurahConfigStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'pos_code' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'province', 'city', 'district', 'pos_code']);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/logo'), $filename);
            $data['logo'] = $filename;
        }

        LurahConfig::create($data);

        return redirect()->route('admin.lurah-config')
            ->with('success', 'Konfigurasi kelurahan berhasil ditambahkan');
    }

    // Update method untuk LurahConfig
    public function lurahConfigUpdate(Request $request, $id)
    {
        $config = LurahConfig::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'pos_code' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'province', 'city', 'district', 'pos_code']);

        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($config->logo && file_exists(public_path('uploads/logo/' . $config->logo))) {
                unlink(public_path('uploads/logo/' . $config->logo));
            }

            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/logo'), $filename);
            $data['logo'] = $filename;
        }

        $config->update($data);

        return redirect()->route('admin.lurah-config')
            ->with('success', 'Konfigurasi kelurahan berhasil diperbarui');
    }

    public function lurahConfigDestroy($id)
    {
        $config = LurahConfig::findOrFail($id);

        // Hapus logo jika ada
        if ($config->logo && file_exists(public_path('uploads/logo/' . $config->logo))) {
            unlink(public_path('uploads/logo/' . $config->logo));
        }

        $config->delete();

        return redirect()->route('admin.lurah-config')
            ->with('success', 'Konfigurasi kelurahan berhasil dihapus');
    }
}
