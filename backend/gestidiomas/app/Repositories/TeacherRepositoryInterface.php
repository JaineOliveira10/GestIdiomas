<?php

namespace App\Repositories;

interface TeacherRepositoryInterface
{
    public function create(array $data);
    public function findAll();
    public function findById($id);
    public function update($id, array $data);
    public function delete($id);
}