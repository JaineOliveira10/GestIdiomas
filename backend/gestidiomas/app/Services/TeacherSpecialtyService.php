<?php

namespace App\Services;

use App\Repositories\TeacherSpecialtyRepositoryInterface;

class TeacherSpecialtyService
{
    protected $teacherSpecialtyRepository;

    public function __construct(TeacherSpecialtyRepositoryInterface $teacherSpecialtyRepository)
    {
        $this->teacherSpecialtyRepository = $teacherSpecialtyRepository;
    }

    public function assignSpecialtyToTeacher($teacherId, $specialtyId)
    {
        return $this->teacherSpecialtyRepository->attachSpecialty($teacherId, $specialtyId);
    }

    public function removeSpecialtyFromTeacher($teacherId, $specialtyId)
    {
        return $this->teacherSpecialtyRepository->detachSpecialty($teacherId, $specialtyId);
    }

    public function listSpecialtiesByTeacher($teacherId)
    {
        return $this->teacherSpecialtyRepository->getSpecialtiesByTeacher($teacherId);
    }
}
