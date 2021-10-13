<?php

namespace Tests\Feature;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_only_admin_can_create_brand()
    {
        $brand = Brand::factory()->create()->toArray();

        $admin = $this->registerUser('admin');

        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson(route('admin.brands.store'),
            [
                $brand
            ]
        );

        $response->assertSee(200);

    }

    public function test_user_can_not_create_brand()
    {
        $admin = $this->registerUser('user');
        $this->actingAs($admin, 'sanctum');

        $brand = Brand::factory()->create();

        $this->postJson(route('admin.brands.store'),
            [
                'name' => $brand->name,
            ]
        )->assertStatus(403);

    }

    public function test_column_name_is_required()
    {
        $admin = $this->registerUser('admin');

        $this->actingAs($admin, 'sanctum');
        $this->postJson(
            route('admin.brands.store'),
            [
                'name' => "",
            ]
        )->assertStatus(401)
            ->assertSee('text');


    }

    public function test_a_admin_user_can_see_brands()
    {
        $admin = $this->registerUser('admin');
        $this->actingAs($admin, 'sanctum');

        $brands = Brand::factory()->count(5)->create();

        $response = $this->getJson(route('admin.brands.index'))
            ->assertJsonStructure(['code',
                'data' => [
                    [
                        'id',
                        'name'
                    ]
                ]
            ]);
        $this->assertDatabaseCount('brands', 5);
        $response->assertStatus(200);
        $response->assertSee($brands[0]->name);
        $response->assertSee($brands[1]->name);
        $response->assertSee($brands[2]->name);
        $response->assertSee($brands[3]->name);
        $response->assertSee($brands[4]->name);

        $this->assertDatabaseHas('brands', [
            'name' => $brands[0]->name,
        ]);

        $this->assertDatabaseHas('brands', [
            'name' => $brands[1]->name,
        ]);
    }

    public function test_get_one_brand_by_admin()
    {
        $admin = $this->registerUser('admin');
        $this->actingAs($admin, 'sanctum');

        $brand = Brand::factory()->create();
        $response = $this->getJson(route('admin.brands.show', 1));
        $response->assertStatus(200);
        $response->assertSee($brand->name);

    }

    public function test_user_can_not_see_brands()
    {
        $brands = Brand::factory()->count(5)->create();
        $user = $this->registerUser('user');
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson(route('admin.brands.index'));
        $response->assertStatus(403);
        $response->assertSee('unauthorized');
        $this->assertDatabaseHas('brands', [
            'name' => $brands[0],
            'name' => $brands[1]->name,
            'name' => $brands[2]->name,
            'name' => $brands[3]->name,
        ]);
    }

    public function test_update_brand_by_admin()
    {
        $admin = $this->registerUser('admin');
        $this->actingAs($admin, 'sanctum');


        $brand = Brand::factory()->create([
            'name' => 'electronic'
        ]);

        $this->patchJson(route('admin.brands.update', ['brand' => $brand->id]), [
            'name' => "sport"
        ]);

        $this->assertDatabaseMissing('brands', [
            'name' => 'electronic'
        ]);

    }

}
