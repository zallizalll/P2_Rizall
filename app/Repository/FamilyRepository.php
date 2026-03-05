<?php


namespace App\Repository;

use App\Models\Family;
use App\Models\Rukun;
use App\Models\Warga;

class FamilyRepository
{
    public function getAll()
    {
        return Family::with(['rt', 'rw', 'familyHead', 'members'])
            ->orderBy('no_kk')
            ->get();
    }

    public function findById($id)
    {
        return Family::with(['rt', 'rw', 'familyHead', 'members'])
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        return Family::create($data);
    }

    public function update($id, array $data)
    {
        $family = $this->findById($id);
        $family->update($data);
        return $family->fresh(['rt', 'rw', 'familyHead']);
    }

    public function delete($id)
    {
        $family = $this->findById($id);
        return $family->delete();
    }

    public function getAllRt()
    {
        return Rukun::where('type', 'RT')->orderBy('no')->get();
    }

    public function getAllRw()
    {
        return Rukun::where('type', 'RW')->orderBy('no')->get();
    }

    public function getAvailableHeads($excludeFamilyId = null)
    {
        $usedHeadIds = Family::whereNotNull('family_head_id')
            ->when($excludeFamilyId, function ($query) use ($excludeFamilyId) {
                $query->where('id', '!=', $excludeFamilyId);
            })
            ->pluck('family_head_id')
            ->toArray();

        return Warga::where('living_status', 'hidup')
            ->whereNotIn('id', $usedHeadIds)
            ->orderBy('name')
            ->get();
    }

    public function getUnassignedWarga()
    {
        return Warga::whereNull('no_kk')->orderBy('name')->get();
    }

    public function assignWargaToFamily(string $noKk, array $wargaIds)
    {
        Warga::whereIn('id', $wargaIds)->update(['no_kk' => $noKk]);
    }

    public function unassignWargaFromFamily(array $wargaIds)
    {
        Warga::whereIn('id', $wargaIds)->update(['no_kk' => null]);
    }
}