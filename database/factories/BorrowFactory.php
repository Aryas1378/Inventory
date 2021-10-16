<?php

namespace Database\Factories;

use App\Models\Borrow;
use App\Models\Product;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BorrowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Borrow::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::factory()->create();

        return [
            'product_id' => $product->id,
            'from_date' => Carbon::now(),
            'to_date' => Carbon::tomorrow()
        ];
    }
}
