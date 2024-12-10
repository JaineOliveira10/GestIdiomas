<?php

namespace App\Services;

use App\Repositories\SpecialtyRepositoryInterface;

class SpecialtyService
{
    protected $specialtyRepository;

    public function __construct(SpecialtyRepositoryInterface $specialtyRepository)
    {
        $this->specialtyRepository = $specialtyRepository;
    }

    public function createSpecialty(array $data)
    {
        return $this->specialtyRepository->create($data);
    }

    public function getAllSpecialties()
    {
        return $this->specialtyRepository->findAll();
    }

    public function getSpecialtyById($id)
    {
        return $this->specialtyRepository->findById($id);
    }

    public function updateSpecialty($id, array $data)
    {
        return $this->specialtyRepository->update($id, $data);
    }

    public function deleteSpecialty($id)
    {
        return $this->specialtyRepository->delete($id);
    }
}