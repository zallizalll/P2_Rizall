<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\FamilyRepository;

class FamilyController extends Controller
{
    protected $familyRepository;

    public function __construct(FamilyRepository $familyRepository)
    {
        $this->familyRepository = $familyRepository;
    }

    public function index()
    {
        $families  = $this->familyRepository->getAll();
        $rtList    = $this->familyRepository->getAllRt();
        $rwList    = $this->familyRepository->getAllRw();
        $wargaList = $this->familyRepository->getAvailableHeads();

        return view('pages.family.index', compact('families', 'rtList', 'rwList', 'wargaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk'          => 'required|string|size:16|unique:family,no_kk',
            'rt_id'          => 'required|exists:rukun,id',
            'rw_id'          => 'required|exists:rukun,id',
            'address'        => 'required|string|max:500',
            'family_head_id' => 'nullable|exists:warga,id',
        ]);

        try {
            $family = $this->familyRepository->create($validated);

            if (!empty($validated['family_head_id'])) {
                $this->familyRepository->assignWargaToFamily(
                    $family->no_kk,
                    [$validated['family_head_id']]
                );
            }

            return redirect()->route('family.index')->with('success', 'Data keluarga berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        try {
            $family = $this->familyRepository->findById($id);
            $availableHeads = $this->familyRepository->getAvailableHeads($id);

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'               => $family->id,
                    'no_kk'            => $family->no_kk,
                    'rt_id'            => $family->rt_id,
                    'rw_id'            => $family->rw_id,
                    'rt_no'            => $family->rt ? $family->rt->no : '-',
                    'rw_no'            => $family->rw ? $family->rw->no : '-',
                    'address'          => $family->address,
                    'family_head_id'   => $family->family_head_id,
                    'family_head_name' => $family->familyHead ? $family->familyHead->name : '-',
                    'members_count'    => $family->members->count(),
                    'members'          => $family->members->map(fn($w) => [
                        'id'   => $w->id,
                        'name' => $w->name,
                        'nik'  => $w->nik,
                    ]),
                    'available_heads'  => $availableHeads->map(fn($w) => [
                        'id'   => $w->id,
                        'name' => $w->name,
                        'nik'  => $w->nik,
                    ]),
                    'created_at'       => $family->created_at?->format('d M Y, H:i'),
                    'updated_at'       => $family->updated_at?->format('d M Y, H:i'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no_kk'          => 'required|string|size:16|unique:family,no_kk,' . $id,
            'rt_id'          => 'required|exists:rukun,id',
            'rw_id'          => 'required|exists:rukun,id',
            'address'        => 'required|string|max:500',
            'family_head_id' => 'nullable|exists:warga,id',
        ]);

        try {
            $family = $this->familyRepository->update($id, $validated);

            if (!empty($validated['family_head_id'])) {
                $this->familyRepository->assignWargaToFamily(
                    $family->no_kk,
                    [$validated['family_head_id']]
                );
            }

            return redirect()->route('family.index')->with('success', 'Data keluarga berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal mengupdate data: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $family = $this->familyRepository->findById($id);

            $memberIds = $family->members->pluck('id')->toArray();
            if (!empty($memberIds)) {
                $this->familyRepository->unassignWargaFromFamily($memberIds);
            }

            $this->familyRepository->delete($id);

            return redirect()->route('family.index')->with('success', 'Data keluarga berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
