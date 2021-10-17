<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use function Livewire\str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $category = Category::factory()->create();
        $brand    = Brand::factory()->create();
        $status   = Status::factory()->create();
        return [

            'name' => $this->faker->name,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'status_id' => $status->id,
            'code' => 10,
            'is_public' => "yes",

        ];

    }
}
