<?php

namespace Tests\Feature;

use App\Models\Borrow;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowTest extends TestCase
{

    use RefreshDatabase;
    public $product ;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
    }

    public function test_create_borrow()
    {
        $user = $this->registerUser('staff');
        $borrow = Borrow::factory()->create();
        $this->actingAs($user, 'sanctum');
        $response = $response = $this->postJson(route('profile.borrows.store'), $borrow->toArray());
        $response->assertStatus(200);
    }

}
