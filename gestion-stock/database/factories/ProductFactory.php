<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(), 
            'quantity_in_stock' => $this->faker->numberBetween(1, 100), 
            'min_threshold' => $this->faker->numberBetween(1, 10),
            'user_id' => User::factory(),
        ];
    }
}
