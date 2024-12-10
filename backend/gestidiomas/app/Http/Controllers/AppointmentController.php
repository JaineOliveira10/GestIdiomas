<?php

namespace App\Http\Controllers;

use App\Services\AppointmentService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index()
    {
        $appointments = $this->appointmentService->getAllAppointments();
        return response()->json($appointments);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'required|exists:teachers,id',
            'scheduled_at' => 'required|date|after:'.now()->addHours(24),
            'lesson_content' => 'required|string',
        ]);

        try {
            $appointment = $this->appointmentService->create($data);
            return response()->json($appointment, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    // Editar agendamento
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'required|exists:teachers,id',
            'scheduled_at' => 'required|date|after:'.now()->addHours(24),
            'lesson_content' => 'required|string',
        ]);

        try {
            $appointment = $this->appointmentService->update($id, $data);
            return response()->json($appointment);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    // Cancelar agendamento
    public function cancel($id)
    {
        try {
            $this->appointmentService->cancel($id);
            return response()->json(['message' => 'Agendamento cancelado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400); 
        }
    }



    public function listByStudent($studentId)
    {
        try {
            $appointments = $this->appointmentService->listByStudent($studentId);
            return response()->json($appointments);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
