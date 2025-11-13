<?php

namespace Database\Factories;

use App\Models\MCategory;
use App\Models\MHouse;
use App\Models\MUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class MCategoryFactory extends Factory
{
    protected $model = MCategory::class;

    public function definition(): array
    {
        return [
            'house_id' => MHouse::factory(),
            'name' => $this->faker->word(),
            'created_user_id' => MUser::factory(),
            'updated_user_id' => MUser::factory(),
            'program_code' => 'CAT_'.$this->faker->unique()->randomNumber(3, true),
        ];
    }
}
