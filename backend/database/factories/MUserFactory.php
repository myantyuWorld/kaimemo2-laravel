<?php

namespace Database\Factories;

use App\Models\MUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class MUserFactory extends Factory
{
    protected $model = MUser::class;

    public function definition(): array
    {
        return [
            'line_user_id' => $this->faker->unique()->uuid(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'created_user_id' => 1,
            'updated_user_id' => 1,
            'program_code' => 'USER_'.$this->faker->unique()->randomNumber(3, true),
        ];
    }
}
