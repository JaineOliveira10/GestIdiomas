<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf',
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'phone',
        'whatsapp',
        'cep',
        'address',
        'address_number',
        'neighborhood',
        'state',
        'city',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
