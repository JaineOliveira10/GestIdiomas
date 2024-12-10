<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface
{
    public function create(array $data)
    {
        return Student::create($data);
    }

    public function findAll()
    {
        return Student::orderBy('first_name', 'asc')->get();
    }

    public function findById($id)
    {
        return Student::find($id);
    }

    public function update($id, array $data)
    {
        $student = Student::find($id);
        $student->update($data);
        return $student;
    }

    public function delete($id)
    {
        $student = Student::find($id);
        return $student->delete();
    }
}
