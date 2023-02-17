<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat('2', 20, 9999999),
            'status' => $this->faker->randomElement(['available' ,'out_of_stoke']),
            'type' => $this->faker->randomElement(['item' ,'service']),
        ];
    }
}
