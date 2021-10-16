<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
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
        return [
            'name' => $this->faker->name,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'code' => "1010",
            'status_id' => Product::available,
            'is_public' => "yes",
        ];
    }
}
