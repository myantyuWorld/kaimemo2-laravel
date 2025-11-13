<?php

namespace Database\Factories;

use App\Models\MHouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class MHouseFactory extends Factory
{
    protected $model = MHouse::class;

    public function definition(): array
    {
        return [
            'created_user_id' => 1,
            'updated_user_id' => 1,
            'program_code' => 'HOUSE_'.$this->faker->unique()->randomNumber(3, true),
        ];
    }
}
