<?php

namespace App\Providers;

use App\Models\Borrow;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\Status;
use App\Models\TechnicalManager;
use App\Models\User;
use App\Models\UserProduct;
use App\Policies\BorrowPolicy;
use App\Policies\BrandPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\StatusPolicy;
use App\Policies\TechnicalManagerPolicy;
use App\Policies\UserPolicy;
use App\Policies\UserProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Category::class => CategoryPolicy::class,
        Brand::class => BrandPolicy::class,
        Status::class => StatusPolicy::class,
        Product::class => ProductPolicy::class,
        Role::class => RolePolicy::class,
        UserProduct::class => UserProductPolicy::class,
        Borrow::class => BorrowPolicy::class,
        User::class => UserPolicy::class,
        TechnicalManager::class => TechnicalManagerPolicy::class,
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
