<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'scheduled_at',
        'lesson_content',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
