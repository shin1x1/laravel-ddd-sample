<?php

namespace App\Providers;

use Acme\Shop\Domain\Models\Cart\CartRepository;
use Acme\Shop\Domain\Models\Item\ItemRepository;
use Acme\Shop\Infrastructure\Repositories\Application\HttpSession\HttpSessionCartRepository;
use Acme\Shop\Infrastructure\Repositories\Domain\Eloquent\EloquentItemRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->registerApplicationRepository();
        $this->registerDomainRepository();
    }

    private function registerApplicationRepository()
    {
        $this->app->bind(CartRepository::class, HttpSessionCartRepository::class);
    }

    private function registerDomainRepository()
    {
        $this->app->bind(ItemRepository::class, EloquentItemRepository::class);
    }
}
