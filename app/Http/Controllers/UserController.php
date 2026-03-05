<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAll()->load(['userDetail', 'jabatan']);
        $jabatans = Jabatan::all();

        return view('pages.users.index', compact('users', 'jabatans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'jabatan_id' => 'required|exists:jabatan,id',
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'nik' => 'nullable|string|max:16',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $userData = [
                'email' => $request->email,
                'password' => $request->password,
                'jabatan_id' => $request->jabatan_id,
            ];

            $detailData = [
                'nip' => $request->nip,
                'name' => $request->name,
                'no_hp' => $request->no_hp,
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'nik' => $request->nik,
                'status' => $request->status ?? 'active',
            ];

            $this->userRepository->create($userData, $detailData);

            Log::info('User created successfully', ['email' => $request->email]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil ditambahkan'
                ]);
            }

            return redirect()->route('users.index')
                ->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error creating user', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userRepository->find($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'email' => $user->email,
                    'jabatan' => $user->jabatan ? $user->jabatan->name : '-',
                    'jabatan_id' => $user->jabatan_id,
                    'name' => $user->userDetail ? $user->userDetail->name : '-',
                    'nip' => $user->userDetail && $user->userDetail->nip ? $user->userDetail->nip : '-',
                    'nik' => $user->userDetail && $user->userDetail->nik ? $user->userDetail->nik : '-',
                    'no_hp' => $user->userDetail && $user->userDetail->no_hp ? $user->userDetail->no_hp : '-',
                    'address' => $user->userDetail && $user->userDetail->address ? $user->userDetail->address : '-',
                    'birth_date' => $user->userDetail && $user->userDetail->birth_date ? $user->userDetail->birth_date->format('Y-m-d') : '-',
                    'status' => $user->userDetail && $user->userDetail->status ? $user->userDetail->status : '-',
                    'created_at' => $user->created_at->format('d M Y H:i'),
                    'updated_at' => $user->updated_at->format('d M Y H:i'),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error showing user', [
                'id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan: ' . $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'jabatan_id' => 'required|exists:jabatan,id',
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'nik' => 'nullable|string|max:16',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $userData = [
                'email' => $request->email,
                'password' => $request->password,
                'jabatan_id' => $request->jabatan_id,
            ];

            $detailData = [
                'nip' => $request->nip,
                'name' => $request->name,
                'no_hp' => $request->no_hp,
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'nik' => $request->nik,
                'status' => $request->status ?? 'active',
            ];

            $this->userRepository->updateUser($id, $userData, $detailData);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil diupdate'
                ]);
            }

            return redirect()->route('users.index')
                ->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error updating user', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->userRepository->delete($id);

            return redirect()->route('users.index')
                ->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting user', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return redirect()->route('users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
