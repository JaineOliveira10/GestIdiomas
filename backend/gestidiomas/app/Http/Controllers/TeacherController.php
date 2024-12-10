<?php

namespace App\Http\Controllers;

use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        $teachers = $this->teacherService->getAllTeachers();
        return response()->json($teachers);
    }

    public function show($id)
    {
        $teacher = $this->teacherService->getTeacherById($id);
        if (!$teacher) {
            return response()->json(['message' => 'Professor Não Encontrado!'], 404);
        }
        return response()->json($teacher);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cpf' => 'required|unique:teachers',
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'date',
            'status' => 'required|in:active,inactive',
        ]);

        $teacher = $this->teacherService->createTeacher($data);

        return response()->json($teacher, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([

            'cpf' => 'required|unique:teachers,cpf,' . $id,
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'date',
            'status' => 'required|in:active,inactive',
        ]);

        $teacher = $this->teacherService->updateTeacher($id, $data);
        return response()->json($teacher);
    }

    public function destroy($id)
    {
        $teacher = $this->teacherService->getTeacherById($id);
        if (!$teacher) {
            return response()->json(['message' => 'Professor Não Encontrado!'], 404);
        }

        $this->teacherService->deleteTeacher($id);
        return response()->json(['message' => 'Professor Excluído Com Sucesso!']);
    }
}
