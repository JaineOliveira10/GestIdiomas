<?php

namespace App\Repositories;

use App\Models\Teacher;
use App\Models\Specialty;

class TeacherSpecialtyRepository implements TeacherSpecialtyRepositoryInterface
{
    public function attachSpecialty($teacherId, $specialtyId)
    {
        $teacher = Teacher::find($teacherId);
        return $teacher->specialties()->attach($specialtyId);
    }

    public function detachSpecialty($teacherId, $specialtyId)
    {
        $teacher = Teacher::find($teacherId);
        return $teacher->specialties()->detach($specialtyId);
    }

    public function getSpecialtiesByTeacher($teacherId)
    {
        $teacher = Teacher::find($teacherId);
        return $teacher->specialties;
    }
}
