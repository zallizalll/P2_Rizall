<?php

namespace App\Repository;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getAll()
    {
        return $this->model->with(['jabatan', 'userDetail'])->get();
    }

    public function find($id)
    {
        return $this->model->with(['jabatan', 'userDetail'])->findOrFail($id);
    }

    public function create(array $userData, array $detailData)
    {
        DB::beginTransaction();

        try {
            // Create user (email, password, jabatan_id masuk ke tabel users)
            $user = $this->model->create([
                'email' => $userData['email'],
                'password' => bcrypt($userData['password']),
                'jabatan_id' => $userData['jabatan_id'],
            ]);

            // Create user detail (name, nip, nik, dll masuk ke tabel user_detail)
            UserDetail::create([
                'user_id' => $user->id,
                'nip' => $detailData['nip'] ?? null,
                'name' => $detailData['name'],
                'no_hp' => $detailData['no_hp'] ?? null,
                'address' => $detailData['address'] ?? null,
                'birth_date' => $detailData['birth_date'] ?? null,
                'nik' => $detailData['nik'] ?? null,
                'status' => $detailData['status'] ?? 'active',
            ]);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateUser($id, array $userData, array $detailData)
    {
        DB::beginTransaction();

        try {
            $user = $this->model->findOrFail($id);

            // Update user (email, password jika diisi, jabatan_id)
            $updateData = [
                'email' => $userData['email'],
                'jabatan_id' => $userData['jabatan_id'],
            ];

            // Hanya update password kalau diisi
            if (!empty($userData['password'])) {
                $updateData['password'] = bcrypt($userData['password']);
            }

            $user->update($updateData);

            // Update user detail
            if ($user->userDetail) {
                $user->userDetail->update([
                    'nip' => $detailData['nip'] ?? null,
                    'name' => $detailData['name'],
                    'no_hp' => $detailData['no_hp'] ?? null,
                    'address' => $detailData['address'] ?? null,
                    'birth_date' => $detailData['birth_date'] ?? null,
                    'nik' => $detailData['nik'] ?? null,
                    'status' => $detailData['status'] ?? 'active',
                ]);
            } else {
                // Kalau user_detail belum ada, buat baru
                UserDetail::create([
                    'user_id' => $user->id,
                    'nip' => $detailData['nip'] ?? null,
                    'name' => $detailData['name'],
                    'no_hp' => $detailData['no_hp'] ?? null,
                    'address' => $detailData['address'] ?? null,
                    'birth_date' => $detailData['birth_date'] ?? null,
                    'nik' => $detailData['nik'] ?? null,
                    'status' => $detailData['status'] ?? 'active',
                ]);
            }

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $user = $this->model->findOrFail($id);

            Log::info('Attempting to delete user', ['id' => $id, 'email' => $user->email]);

            // Hapus user detail dulu (kalau ada)
            if ($user->userDetail) {
                $user->userDetail()->delete();
                Log::info('User detail deleted', ['user_id' => $id]);
            }

            // Hapus user
            $user->delete();
            Log::info('User deleted successfully', ['id' => $id]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting user', [
                'id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
