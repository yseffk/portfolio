<?php

namespace App\Providers;


use App\Repository\Eloquent\UserRepository;

use App\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\BlogPostRepositoryInterface;
use App\Repository\BlogItemRepositoryInterface;
use App\Repository\BlogItemAttachmentRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\BlogPostRepository;
use App\Repository\Eloquent\BlogItemRepository;
use App\Repository\Eloquent\BlogItemAttachmentRepository;



class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(BlogPostRepositoryInterface::class, BlogPostRepository::class);
        $this->app->bind(BlogItemRepositoryInterface::class, BlogItemRepository::class);
        $this->app->bind(BlogItemAttachmentRepositoryInterface::class, BlogItemAttachmentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
