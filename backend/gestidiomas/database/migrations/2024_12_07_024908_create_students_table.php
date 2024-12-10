<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('cpf')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp');
            $table->string('cep');
            $table->string('address');
            $table->string('address_number')->nullable();
            $table->string('neighborhood');
            $table->string('state');
            $table->string('city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
