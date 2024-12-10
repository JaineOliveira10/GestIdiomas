<?php

namespace App\Repositories;

use App\Models\Appointment;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function findById($id)
    {
        return Appointment::find($id);
    }

    public function update($id, array $data)
    {
        $appointment = Appointment::find($id);
        $appointment->update($data);
        return $appointment;
    }

    public function delete($id)
    {
        $appointment = Appointment::find($id);
        return $appointment->delete();
    }

    public function findAll()
    {
        return Appointment::with('student')->get();
    }

    public function findByStudent($studentId)
    {
        return Appointment::where('student_id', $studentId)->get();
    }

    public function isTeacherUnavailable($teacherId, $scheduledAt)
    {
        return Appointment::where('teacher_id', $teacherId)
            ->where('scheduled_at', $scheduledAt)
            ->exists();
    }
}
