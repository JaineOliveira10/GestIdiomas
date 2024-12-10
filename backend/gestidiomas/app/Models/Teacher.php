<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf',
        'first_name',
        'last_name',
        'birth_date',
        'status',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'teacher_specialty');
    }
}
