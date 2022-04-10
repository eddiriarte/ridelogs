<?php

namespace Database\Factories;

use App\Models\InsuranceInstitute;
use Illuminate\Database\Eloquent\Factories\Factory;

class InsuranceInstituteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InsuranceInstitute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->company(),
            'short_name' => strtoupper($this->faker->unique->bothify('????')),
        ];
    }
}
