<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
        return [
            'name'        => $this->faker->text(20),
            'quantity'    => $this->faker->randomNumber(3),
            'price'       => $this->faker->randomFloat(4),
            'description' => $this->faker->text(300),
            'image'       => "{$this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])}.jpg",
            'created_by'  => 1,
        ];
    }
}
