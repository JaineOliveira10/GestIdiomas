<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AppointmentService;
use App\Repositories\AppointmentRepositoryInterface;
use Carbon\Carbon;
use Mockery;
use App\Models\Appointment;


class AppointmentServiceTest extends TestCase
{
    protected $appointmentRepositoryMock;
    protected $appointmentService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->appointmentRepositoryMock = Mockery::mock(AppointmentRepositoryInterface::class);
        $this->appointmentService = new AppointmentService($this->appointmentRepositoryMock);
    }

    public function testCreateThrowsExceptionIfScheduledWithin24Hours()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('O agendamento deve ser feito com pelo menos 24 horas de antecedência.');

        $data = [
            'scheduled_at' => Carbon::now()->addHours(23)->toDateTimeString(),
            'teacher_id' => 1
        ];

        $this->appointmentService->create($data);
    }

    public function testCreateThrowsExceptionIfTeacherUnavailable()
    {
        $data = [
            'scheduled_at' => Carbon::now()->addDays(2)->toDateTimeString(),
            'teacher_id' => 1
        ];

        $this->appointmentRepositoryMock
            ->shouldReceive('isTeacherUnavailable')
            ->with($data['teacher_id'], $data['scheduled_at'])
            ->andReturn(true);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('O professor não está disponível para a data e hora selecionadas.');

        $this->appointmentService->create($data);
    }

    public function testCreateSuccess()
    {
        $data = [
            'scheduled_at' => Carbon::now()->addDays(2)->toDateTimeString(),
            'teacher_id' => 1
        ];

        $this->appointmentRepositoryMock
            ->shouldReceive('isTeacherUnavailable')
            ->with($data['teacher_id'], $data['scheduled_at'])
            ->andReturn(false);

        $this->appointmentRepositoryMock
            ->shouldReceive('create')
            ->with($data)
            ->andReturn((object)$data);

        $appointment = $this->appointmentService->create($data);

        $this->assertEquals($data['scheduled_at'], $appointment->scheduled_at);
        $this->assertEquals($data['teacher_id'], $appointment->teacher_id);
    }
}
