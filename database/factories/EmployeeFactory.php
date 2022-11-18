<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id'    => $this->faker->randomElement(Company::pluck('id')),
            'name'          => $this->faker->name(),
            'phone'         => $this->faker->PhoneNumber(),
            'address'       => $this->faker->address(),
        ];
    }
}
