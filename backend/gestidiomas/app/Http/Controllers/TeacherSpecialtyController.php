<?php

namespace App\Http\Controllers;

use App\Services\TeacherSpecialtyService;
use Illuminate\Http\Request;

class TeacherSpecialtyController extends Controller
{
    protected $teacherSpecialtyService;

    public function __construct(TeacherSpecialtyService $teacherSpecialtyService)
    {
        $this->teacherSpecialtyService = $teacherSpecialtyService;
    }

    public function assignSpecialty(Request $request, $teacherId)
    {
        $data = $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
        ]);

        $this->teacherSpecialtyService->assignSpecialtyToTeacher($teacherId, $data['specialty_id']);
        return response()->json(['message' => 'Especialidade atribuída com sucesso!']);
    }

    public function removeSpecialty($teacherId, $specialtyId)
    {
        $this->teacherSpecialtyService->removeSpecialtyFromTeacher($teacherId, $specialtyId);
        return response()->json(['message' => 'Especialidade removida com sucesso!']);
    }

    public function listSpecialties($teacherId)
    {
        $specialties = $this->teacherSpecialtyService->listSpecialtiesByTeacher($teacherId);
        return response()->json($specialties);
    }
}
