<?php

namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository implements TeacherRepositoryInterface
{
    public function create(array $data)
    {
        return Teacher::create($data);
    }

    public function findAll()
    {
        return Teacher::all();
    }

    public function findById($id)
    {
        return Teacher::find($id);
    }

    public function update($id, array $data)
    {
        $teacher = Teacher::find($id);
        $teacher->update($data);
        return $teacher;
    }

    public function delete($id)
    {
        $teacher = Teacher::find($id);
        return $teacher->delete();
    }
}
