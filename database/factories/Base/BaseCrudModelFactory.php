<?php

namespace Database\Factories\Base;

use App\Models\Base\BaseCrudModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class BaseCrudModelFactory extends Factory
{
    protected $model = BaseCrudModel::class;

    public function definition()
    {
        return [
            'column_integer' => $this->faker->numberBetween(1, 100),
            'column_smallint' => $this->faker->numberBetween(1, 10),
            'column_string' => $this->faker->word,
            'column_boolean' => $this->faker->boolean,
            'column_float' => $this->faker->randomFloat(2, 1, 100),
            'column_date' => $this->faker->date,
            'column_time' => $this->faker->time,
            'column_datetime' => $this->faker->dateTime,
            'column_text' => $this->faker->text,
            'column_binary' => $this->faker->randomElement(['binary_data_1', 'binary_data_2']),

        ];
    }
}
