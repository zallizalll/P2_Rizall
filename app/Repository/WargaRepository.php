<?php

namespace App\Repository;

use App\Models\Warga;

class WargaRepository
{
    public function getAll()
    {
        return Warga::orderBy('created_at', 'asc')->get();
    }

    public function findById($id)
    {
        return Warga::findOrFail($id);
    }

    public function create(array $data)
    {
        return Warga::create($data);
    }

    public function update($id, array $data)
    {
        $warga = $this->findById($id);
        $warga->update($data);
        return $warga;
    }

    public function delete($id)
    {
        $warga = $this->findById($id);
        return $warga->delete();
    }

    public function getUnassigned()
    {
        return Warga::whereNull('no_kk')->orderBy('name')->get();
    }
}