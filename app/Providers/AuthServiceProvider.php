<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Memo;
use App\Models\Metameta;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\MemoPolicy;
use App\Policies\MetametaPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Comment::class => CommentPolicy::class,
        User::class => UserPolicy::class,
        Metameta::class => MetametaPolicy::class,
        Memo::class => MemoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
