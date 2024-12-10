<?php

namespace App\Repositories;

use App\Models\Specialty;

class SpecialtyRepository implements SpecialtyRepositoryInterface
{
    public function create(array $data)
    {
        return Specialty::create($data);
    }

    public function findAll()
    {
        return Specialty::all();
    }

    public function findById($id)
    {
        return Specialty::find($id);
    }

    public function update($id, array $data)
    {
        $specialty = Specialty::find($id);
        $specialty->update($data);
        return $specialty;
    }

    public function delete($id)
    {
        $specialty = Specialty::find($id);
        return $specialty->delete();
    }
}
