<?php

namespace Database\Factories;

use DB;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
// composer require laravel/helpers
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameEnglish = $this->faker->sentence(3);
        $slug = Str::slug($nameEnglish, '-');

        // Retrieve user IDs from the User model
        $userIds = User::pluck('id');
        $parentcategoryIds = Category::pluck('id');

        $parent_id = null; // For root categories
        for ($i = 1; $i <= 100; $i++) {
            // Conditionally set the parent_id based on your criteria
            if ($i > 50) {
                $parent_id = $this->faker->randomElement($parentcategoryIds);
            }
        }

        return [

            'name_english' => $nameEnglish,
            'name_bangla' => $this->faker->sentence(3),
            'slug' => $slug, // Generate slug from name_english
            'parent_id' => $parent_id,
            'meta_title' => $this->faker->sentence(10),
            'meta_description' => $this->faker->sentence(10),
            'descriptions' => $this->faker->unique()->sentence(3),
            'home_status' => $this->faker->randomElement([0, 1]),
            'logo' => 'category_' . $this->faker->unique()->numberBetween(1, 100000) . '.jpg',
            'status' => $this->faker->randomElement([0, 1]),
            'created_by' => $this->faker->randomElement($userIds),
            'updated_by' => $this->faker->randomElement($userIds),
        ];
    }
}
