<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TeacherService;
use App\Repositories\TeacherRepositoryInterface;
use Mockery;
use App\Models\Teacher;

class TeacherServiceTest extends TestCase
{
    protected $teacherService;
    protected $teacherRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacherRepositoryMock = Mockery::mock(TeacherRepositoryInterface::class);
        $this->teacherService = new TeacherService($this->teacherRepositoryMock);
    }

    /** @test */
    public function it_can_create_teacher()
    {
        $teacherData = [
            'cpf' => '12345678901',
            'first_name' => 'Jaine',
            'last_name' => 'Oliveira',
            'birth_date' => '2002-04-10',
            'status' => 'active',
        ];

        $this->teacherRepositoryMock
            ->shouldReceive('create')
            ->with($teacherData)
            ->once()
            ->andReturn(new Teacher($teacherData)); 


        $teacher = $this->teacherService->createTeacher($teacherData);

        $this->assertInstanceOf(Teacher::class, $teacher);  
        $this->assertEquals($teacherData['cpf'], $teacher->cpf);  
    }

    /** @test */
    public function it_can_get_all_teachers()
    {
        $teachersMock = collect([
            new Teacher(['cpf' => '12345678901', 'first_name' => 'Jaine', 'last_name' => 'Oliveira', 'status' => 'active']),
            new Teacher(['cpf' => '98765432100', 'first_name' => 'Jaqueline', 'last_name' => 'Oliveira', 'status' => 'inactive']),
        ]);

        $this->teacherRepositoryMock
            ->shouldReceive('findAll')
            ->once()
            ->andReturn($teachersMock);


        $teachers = $this->teacherService->getAllTeachers();

        $this->assertCount(2, $teachers);  
        $this->assertEquals('Jaine', $teachers[0]->first_name);  
    }

    /** @test */
    public function it_can_get_teacher_by_id()
    {
        $teacherMock = new Teacher([
            'cpf' => '12345678901',
            'first_name' => 'Jaine',
            'last_name' => 'Oliveira',
            'status' => 'active',
        ]);

        $this->teacherRepositoryMock
            ->shouldReceive('findById')
            ->with(1)
            ->once()
            ->andReturn($teacherMock);


        $teacher = $this->teacherService->getTeacherById(1);

        $this->assertInstanceOf(Teacher::class, $teacher); 
        $this->assertEquals('Jaine', $teacher->first_name); 
    }

    /** @test */
    public function it_can_update_teacher()
    {
        $teacherData = [
            'cpf' => '12345678901',
            'first_name' => 'Jaine',
            'last_name' => 'Oliveira',
            'birth_date' => '2002-04-10',
            'status' => 'active',
        ];

        $teacherMock = new Teacher($teacherData);

        $this->teacherRepositoryMock
            ->shouldReceive('update')
            ->with(1, $teacherData)
            ->once()
            ->andReturn($teacherMock);

        $teacher = $this->teacherService->updateTeacher(1, $teacherData);

        $this->assertInstanceOf(Teacher::class, $teacher); 
        $this->assertEquals('Jaine', $teacher->first_name); 
    }

    /** @test */
    public function it_can_delete_teacher()
    {
        $teacherMock = new Teacher([
            'cpf' => '12345678901',
            'first_name' => 'Jaine',
            'last_name' => 'Oliveira',
            'status' => 'active',
        ]);

        $this->teacherRepositoryMock
            ->shouldReceive('delete')
            ->with(1)
            ->once()
            ->andReturn(true);

        $result = $this->teacherService->deleteTeacher(1);

        $this->assertTrue($result);  
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
