<?php

namespace App\Repositories;

interface TeacherSpecialtyRepositoryInterface
{
    public function attachSpecialty($teacherId, $specialtyId);
    public function detachSpecialty($teacherId, $specialtyId);
    public function getSpecialtiesByTeacher($teacherId);
}