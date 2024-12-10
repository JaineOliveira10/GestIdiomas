<?php

namespace App\Services;

use App\Repositories\AppointmentRepositoryInterface;
use Carbon\Carbon;

class AppointmentService
{
    protected $appointmentRepository;

    public function __construct(AppointmentRepositoryInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function create(array $data)
    {
        $scheduledAt = Carbon::parse($data['scheduled_at']);
        if ($scheduledAt->diffInHours(Carbon::now()) < 24) {
            throw new \Exception('O agendamento deve ser feito com pelo menos 24 horas de antecedência.');
        }

        if ($this->appointmentRepository->isTeacherUnavailable($data['teacher_id'], $data['scheduled_at'])) {
            throw new \Exception('O professor não está disponível para a data e hora selecionadas.');
        }

        return $this->appointmentRepository->create($data);
    }

    public function update($id, array $data)
    {
        $appointment = $this->appointmentRepository->findById($id);

        if (!$appointment) {
            throw new \Exception('Agendamento não encontrado.');
        }

        if (Carbon::now()->diffInHours(Carbon::parse($appointment->scheduled_at)) < 24) {
            throw new \Exception('Prazo para edição expirado.');
        }

        if ($appointment->scheduled_at != $data['scheduled_at']) {
            if ($this->appointmentRepository->isTeacherUnavailable($data['teacher_id'], $data['scheduled_at'])) {
                throw new \Exception('O professor não está disponível para a nova data e hora.');
            }
        }

        return $this->appointmentRepository->update($id, $data);
    }

    public function cancel($id)
    {
        $appointment = $this->appointmentRepository->findById($id);

        if (!$appointment) {
            throw new \Exception('Agendamento não encontrado.');
        }

        return $this->appointmentRepository->delete($id);
    }

    public function getAllAppointments()
    {
        return $this->appointmentRepository->findAll();
    }

    public function listByStudent($studentId)
    {
        return $this->appointmentRepository->findByStudent($studentId);
    }
}
