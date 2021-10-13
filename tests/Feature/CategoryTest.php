<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
//        Artisan::call("db:seed --class ")
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_create_category_by_only_admin()
    {

        $role = Role::factory()->create([
            'name' => 'admin',
        ]);

        $category = Category::factory()->create();

        /** @var User $admin */
        $admin = User::factory()->create();
        $admin->roles()->attach($role->id);
        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson(
            route('admin.categories.store'),
            [
                'name' => $category->name,
            ]
        );

        $response->assertStatus(200);
        $response->assertSee($category->name);

    }

    public function test_user_can_not_create_category()
    {
        $role = Role::factory()->create([
            'name' => 'user',
        ]);

        $category = Category::factory()->create();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->attach($role->id);
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson(
            route('admin.categories.store'),
            [
                'name' => $category->name,
        ]);
        $response->assertSee('unauthorized');

    }

}
