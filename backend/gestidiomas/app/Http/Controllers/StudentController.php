<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        $students = $this->studentService->getAllStudents();
        return response()->json($students);
    }

    public function show($id)
    {
        $student = $this->studentService->getStudentById($id);
        if (!$student) {
            return response()->json(['message' => 'Aluno Não Encontrado!'], 404);
        }
        return response()->json($student);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cpf' => 'required|unique:students',
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'date',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'whatsapp' => 'required',
            'cep' => 'required',
            'address' => 'required',
            'address_number' => 'required',
            'neighborhood' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);

        $student = $this->studentService->createStudent($data);
        return response()->json($student, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cpf' => 'required|unique:students,cpf,' . $id,
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
            'email' => 'nullable|email',
            'whatsapp' => 'required',
            'cep' => 'required',
            'address' => 'required',
            'neighborhood' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);

        $student = $this->studentService->updateStudent($id, $data);
        return response()->json($student);
    }

    public function destroy($id)
    {
        $student = $this->studentService->getStudentById($id);
        if (!$student) {
            return response()->json(['message' => 'Aluno Não Encontrado!'], 404);
        }
        
        $this->studentService->deleteStudent($id);
        return response()->json(['message' => 'Aluno Excluído Com Sucesso!']);
    }
}
