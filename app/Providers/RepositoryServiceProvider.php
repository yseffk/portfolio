<?php

namespace App\Providers;

use App\Repository\Eloquent\UserProfileRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\UserProfileRepositoryInterface;
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

use App\Repository\Eloquent\ShopOrderRepository;
use App\Repository\Eloquent\ShopOrderProductRepository;
use App\Repository\Eloquent\ShopProductRepository;
use App\Repository\Eloquent\ShopDiscountRepository;
use App\Repository\Eloquent\ShopCarrierRepository;
use App\Repository\ShopOrderRepositoryInterface;
use App\Repository\ShopOrderProductRepositoryInterface;
use App\Repository\ShopProductRepositoryInterface;
use App\Repository\ShopDiscountRepositoryInterface;
use App\Repository\ShopCarrierRepositoryInterface;

use App\Repository\Eloquent\UserAddressRepository;
use App\Repository\UserAddressRepositoryInterface;


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

        $this->app->bind(ShopOrderRepositoryInterface::class, ShopOrderRepository::class);
        $this->app->bind(ShopOrderProductRepositoryInterface::class, ShopOrderProductRepository::class);
        $this->app->bind(ShopProductRepositoryInterface::class, ShopProductRepository::class);
        $this->app->bind(ShopDiscountRepositoryInterface::class, ShopDiscountRepository::class);
        $this->app->bind(ShopCarrierRepositoryInterface::class, ShopCarrierRepository::class);

        $this->app->bind(UserAddressRepositoryInterface::class, UserAddressRepository::class);
        $this->app->bind(UserProfileRepositoryInterface::class, UserProfileRepository::class);
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
