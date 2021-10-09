<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'image'       => 'https://source.unsplash.com/random',
            'created_by'  => 1,
        ];
    }
}
