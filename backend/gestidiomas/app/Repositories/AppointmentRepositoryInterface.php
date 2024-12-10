<?php

namespace App\Repositories;

interface AppointmentRepositoryInterface
{
    public function create(array $data);
    public function findById($id);
    public function update($id, array $data);
    public function delete($id);
    public function findAll();
    public function findByStudent($studentId);
    public function isTeacherUnavailable($teacherId, $date);
}
