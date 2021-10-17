<?php

namespace Tests\Feature;

use App\Models\Borrow;
use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use App\Models\UserProduct;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_see_borrows()
    {

        $borrows = Borrow::factory()->count(5)->create();

        $user = $this->registerUser('staff');
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson(route('profile.borrows.index'));

        $response->assertSee($borrows[0]->product_id);
        $response->assertStatus(200);

    }

    public function test_staff_can_see_one_specific_borrow()
    {

        $borrows = Borrow::factory()->count(5)->create();
        $user = $this->registerUser('staff');
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson(route('profile.borrows.show', ['borrow' => $borrows[1]->id]));

        $response->assertSee($borrows[1]->product_id);
        $response->assertStatus(200);

    }

    public function test_product_id_verification()
    {
        $product = Product::factory()->create();

        $user = $this->registerUser('staff');

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson(route('profile.borrows.store'), [

            'to_date' => Carbon::tomorrow(),
            'is_public' => 'yes',
        ]);

        $response->assertStatus(401);
        $response->assertSee("not valid request");
    }

    public function test_staff_create_not_public_borrow()
    {
        $product = Product::factory()->create();

        $user = $this->registerUser('staff');

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson(route('profile.borrows.store'), [

            'product_id' => $product->id,
            'to_date' => Carbon::tomorrow(),
            'is_public' => 'no',
        ]);
        $response->assertSee("This product is not available for you");
        $response->assertStatus(400);
    }

    public function test_staff_create_borrow()
    {
        $product = Product::factory()->create();

        $user = $this->registerUser('staff');

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson(route('profile.borrows.store'), [

            'product_id' => $product->id,
            'to_date' => Carbon::tomorrow(),
            'is_public' => 'yes',
        ]);

        $response->assertStatus(200);
        $response->assertSee("data");

    }

    public function test_staff_can_create_user_product()
    {

        $staff = $this->registerUser('staff');

        $product = Product::factory()->create([
            'is_publish' => "no",
        ]);

        $status = Status::factory()->create();

        $user_product = UserProduct::query()->create([

            'user_id' => $staff->id,
            'product_id' => $product->id,
            'code' => "10",
            'from_date' => Carbon::now(),
            'status_id' => $status->id,

        ]);

        $response = $this->postJson(route('profile.borrows.store'), [

            'product_id' => $product->id,
            'to_date' => Carbon::tomorrow(),
            'is_public' => 'no',
        ]);

        $response->assertSee(200);

    }

    public function test_admin_can_not_create_borrow()
    {

        $product = Product::factory()->create();

        $user = $this->registerUser('admin');

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson(route('profile.borrows.store'), [

            'product_id' => $product->id,
            'to_date' => Carbon::tomorrow(),
            'is_public' => 'yes',
        ]);

        $response->assertSee("unauthorized");
    }


}
