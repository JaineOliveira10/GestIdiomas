<?php

namespace App\Services;

use App\Repositories\TeacherRepositoryInterface;

class TeacherService
{
    protected $teacherRepository;

    public function __construct(TeacherRepositoryInterface $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function createTeacher(array $data)
    {
        return $this->teacherRepository->create($data);
    }

    public function getAllTeachers()
    {
        return $this->teacherRepository->findAll();
    }

    public function getTeacherById($id)
    {
        return $this->teacherRepository->findById($id);
    }

    public function updateTeacher($id, array $data)
    {
        return $this->teacherRepository->update($id, $data);
    }

    public function deleteTeacher($id)
    {
        return $this->teacherRepository->delete($id);
    }
}