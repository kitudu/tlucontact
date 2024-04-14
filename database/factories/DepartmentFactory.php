<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "DepartmentName" => $this->faker->sentence,
            "Address" => $this->faker->address,
            "Email" => $this->faker->email,
            "Phone" => $this->faker->phoneNumber,
            "Avatar" => null,
            "ParentDepartmentID" => null,
        ];
    }
}
