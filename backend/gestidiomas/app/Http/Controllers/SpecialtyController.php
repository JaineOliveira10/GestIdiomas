<?php

namespace App\Http\Controllers;

use App\Services\SpecialtyService; // Certifique-se de importar o serviço corretamente
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    protected $specialtyService;

    public function __construct(SpecialtyService $specialtyService)
    {
        $this->specialtyService = $specialtyService;
    }

    public function index()
    {
        $specialties = $this->specialtyService->getAllSpecialties();
        return response()->json($specialties);
    }

    public function show($id)
    {
        $specialty = $this->specialtyService->getSpecialtyById($id);
        if (!$specialty) {
            return response()->json(['message' => 'Especialidade Não Encontrada!'], 404);
        }
        return response()->json($specialty);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $specialty = $this->specialtyService->createSpecialty($data);
        return response()->json($specialty, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $specialty = $this->specialtyService->updateSpecialty($id, $data);
        return response()->json($specialty);
    }

    public function destroy($id)
    {
        $specialty = $this->specialtyService->getSpecialtyById($id);
        if (!$specialty) {
            return response()->json(['message' => 'Especialidade Não Encontrada!'], 404);
        }

        $this->specialtyService->deleteSpecialty($id);
        return response()->json(['message' => 'Especialidade Excluída Com Sucesso!']);
    }
}
