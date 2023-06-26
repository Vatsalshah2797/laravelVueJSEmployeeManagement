<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'salary' => fake()->numerify('#####'),
            'department_id' => Department::pluck('id')->random()
        ];
    }
}
