<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Size>
 */
class SizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Size::class;

    public function definition(): array
    {

        //$this->faker->dateTimeThisDecade; // Generates a random timestamp from the current decade
        $created_at = Carbon::now()->setTimezone("Asia/Dhaka");
        $updated_at = Carbon::now()->setTimezone("Asia/Dhaka");
        //$this->faker->dateTimeBetween($created_at, 'now'); // Generates a random timestamp after the 'created_at' timestamp


        for ($i = 1; $i <= 1000; $i++) {
            $id = $this->generateUniqueId();

            // Check if the ID already exists in the database
            $existingRecord = Size::find($id);

            if ($existingRecord) {
                continue; // Skip this ID, it already exists
            }

            return [
                'id' => null,
                'name_en' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
                'name_bn' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
                'size' => $this->faker->randomFloat($nbMaxDecimals = 100.00, $min = 0.10, $max = 100.00),
                'description' => $this->faker->sentence(8),
                'logo' => 'brand_' . $this->faker->unique()->numberBetween(1, 10000000) . '.jpg',
                'status' => $this->faker->randomElement([0, 1]),
                'created_at' => date('Y-m-d H:i:s', strtotime($created_at)),
                'updated_at' => date('Y-m-d H:i:s', strtotime($updated_at)),
            ];
        }
    }
    private function generateUniqueId()
    {
        // Generate a unique ID (you can use your own logic)
        return rand(1, 10000); // Replace with your logic to generate unique IDs
    }
}
