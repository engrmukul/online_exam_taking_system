<?php

namespace App\Providers;

use App\Contracts\ExamContract;
use App\Contracts\QuestionAssignContract;
use App\Contracts\QuestionContract;
use App\Contracts\QuestionPaperContract;
use App\Contracts\SubjectContract;
use App\Contracts\TestContract;
use App\Contracts\UserContract;
use App\Repositories\ExamRepository;
use App\Repositories\QuestionAssignRepository;
use App\Repositories\QuestionPaperRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TestRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        SubjectContract::class => SubjectRepository::class,
        QuestionContract::class => QuestionRepository::class,
        ExamContract::class => ExamRepository::class,
        QuestionPaperContract::class => QuestionPaperRepository::class,
        QuestionAssignContract::class => QuestionAssignRepository::class,
        TestContract::class => TestRepository::class,
        UserContract::class => UserRepository::class,
        RoleContract::class => RoleRepository::class,
        PermissionContract::class => PermissionRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
