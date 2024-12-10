<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthServiceInterface;
use App\Services\AuthService;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepositoryInterface;
use App\Repositories\TeacherRepository;
use App\Repositories\SpecialtyRepositoryInterface;
use App\Repositories\SpecialtyRepository;
use App\Repositories\TeacherSpecialtyRepositoryInterface;
use App\Repositories\TeacherSpecialtyRepository;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\AppointmentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(TeacherRepositoryInterface::class, TeacherRepository::class);
        $this->app->bind(SpecialtyRepositoryInterface::class, SpecialtyRepository::class);
        $this->app->bind(TeacherSpecialtyRepositoryInterface::class, TeacherSpecialtyRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
