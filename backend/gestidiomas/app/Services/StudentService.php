<?php

namespace App\Services;

use App\Repositories\StudentRepositoryInterface;

class StudentService
{
    protected $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function createStudent(array $data)
    {
        return $this->studentRepository->create($data);
    }

    public function getAllStudents()
    {
        return $this->studentRepository->findAll();
    }

    public function getStudentById($id)
    {
        return $this->studentRepository->findById($id);
    }

    public function updateStudent($id, array $data)
    {
        return $this->studentRepository->update($id, $data);
    }

    public function deleteStudent($id)
    {
        return $this->studentRepository->delete($id);
    }
}