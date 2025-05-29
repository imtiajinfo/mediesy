<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Brand::class;
    public function definition(): array
    {
        return [
            'name_english' => $this->faker->unique()->company(),
            'name_bangla' => $this->faker->unique()->company(),
            'description' => $this->faker->sentence(10),
            'logo' => 'brand_' . $this->faker->unique()->numberBetween(1, 100000) . '.jpg',
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
