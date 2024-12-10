<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\StudentService;
use App\Repositories\StudentRepositoryInterface;
use Mockery;
use App\Models\Student;

class StudentServiceTest extends TestCase
{
    protected $studentService;
    protected $studentRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentRepositoryMock = Mockery::mock(StudentRepositoryInterface::class);
        $this->studentService = new StudentService($this->studentRepositoryMock);
    }

    /** @test */
    public function it_can_create_student()
    {
        $studentData = [
            'cpf' => '12345678901',
            'first_name' => 'Jaine',
            'last_name' => 'Oliveira',
            'birth_date' => '2002-04-10',
            'email' => 'jaine.ojuacy@gmail.com',
            'phone' => '18998222766',
            'whatsapp' => '18998222766',
            'cep' => '16200146',
            'address' => 'Rua Manuel Vieira da Silva',
            'address_number' => 'S/N',
            'neighborhood' => 'Jd. São Cristóvão',
            'state' => 'SP',
            'city' => 'Birigui'
        ];

        $this->studentRepositoryMock
            ->shouldReceive('create')
            ->with($studentData)
            ->once()
            ->andReturn(new Student($studentData)); 


        $student = $this->studentService->createStudent($studentData);

        $this->assertInstanceOf(Student::class, $student);  
        $this->assertEquals($studentData['cpf'], $student->cpf);  
    }

    /** @test */
    public function it_can_get_all_students()
    {
        $teachersMock = collect([
            new Student([
                'cpf' => '12345678901',
                'first_name' => 'Jaine',
                'last_name' => 'Oliveira',
                'birth_date' => '2002-04-10',
                'email' => 'jaine.ojuacy@gmail.com',
                'phone' => '18998222766',
                'whatsapp' => '18998222766',
                'cep' => '16200146',
                'address' => 'Rua Manuel Vieira da Silva',
                'address_number' => 'S/N',
                'neighborhood' => 'Jd. São Cristóvão',
                'state' => 'SP',
                'city' => 'Birigui'
            ]),
            new Student([
                'cpf' => '12345678901',
                'first_name' => 'Jaqueline',
                'last_name' => 'Juacy',
                'birth_date' => '2002-04-10',
                'email' => 'jaquejuacy@gmail.com',
                'phone' => '18996695601',
                'whatsapp' => '18996695601',
                'cep' => '16203150',
                'address' => 'Rua Tamoio',
                'address_number' => 'S/N',
                'neighborhood' => 'Vila Xavier',
                'state' => 'SP',
                'city' => 'Birigui'
            ]),
        ]);

        $this->studentRepositoryMock
            ->shouldReceive('findAll')
            ->once()
            ->andReturn($teachersMock);


        $students = $this->studentService->getAllStudents();

        $this->assertCount(2, $students);  
        $this->assertEquals('Jaine', $students[0]->first_name);  
    }

    /** @test */
    public function it_can_get_student_by_id()
    {
        $studentMock = new Student([
            'cpf' => '12345678901',
            'first_name' => 'Jaine',
            'last_name' => 'Oliveira',
            'birth_date' => '2002-04-10',
            'email' => 'jaine.ojuacy@gmail.com',
            'phone' => '18998222766',
            'whatsapp' => '18998222766',
            'cep' => '16200146',
            'address' => 'Rua Manuel Vieira da Silva',
            'address_number' => 'S/N',
            'neighborhood' => 'Jd. São Cristóvão',
            'state' => 'SP',
            'city' => 'Birigui'
        ]);

        $this->studentRepositoryMock
            ->shouldReceive('findById')
            ->with(1)
            ->once()
            ->andReturn($studentMock);


        $student = $this->studentService->getStudentById(1);

        $this->assertInstanceOf(Student::class, $student); 
        $this->assertEquals('Jaine', $student->first_name); 
    }

    /** @test */
    public function it_can_update_student()
    {
        $studentData = [
            'cpf' => '12345678901',
            'first_name' => 'Jaine',
            'last_name' => 'Oliveira',
            'birth_date' => '2002-04-10',
            'email' => 'jaine.ojuacy@gmail.com',
            'phone' => '18998222766',
            'whatsapp' => '18998222766',
            'cep' => '16200146',
            'address' => 'Rua Manuel Vieira da Silva',
            'address_number' => 'S/N',
            'neighborhood' => 'Jd. São Cristóvão',
            'state' => 'SP',
            'city' => 'Birigui'
        ];

        $studentMock = new Student($studentData);

        $this->studentRepositoryMock
            ->shouldReceive('update')
            ->with(1, $studentData)
            ->once()
            ->andReturn($studentMock);

        $student = $this->studentService->updateStudent(1, $studentData);

        $this->assertInstanceOf(Student::class, $student); 
        $this->assertEquals('Jaine', $student->first_name); 
    }

    /** @test */
    public function it_can_delete_student()
    {
        $studentMock = new Student([
            'cpf' => '12345678901',
            'first_name' => 'Jaine',
            'last_name' => 'Oliveira',
            'birth_date' => '2002-04-10',
            'email' => 'jaine.ojuacy@gmail.com',
            'phone' => '18998222766',
            'whatsapp' => '18998222766',
            'cep' => '16200146',
            'address' => 'Rua Manuel Vieira da Silva',
            'address_number' => 'S/N',
            'neighborhood' => 'Jd. São Cristóvão',
            'state' => 'SP',
            'city' => 'Birigui'
        ]);

        $this->studentRepositoryMock
            ->shouldReceive('delete')
            ->with(1)
            ->once()
            ->andReturn(true);

        $result = $this->studentService->deleteStudent(1);

        $this->assertTrue($result);  
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

}
