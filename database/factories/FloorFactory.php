<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Floor;
use Illuminate\Database\Eloquent\Factories\Factory;

class FloorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Floor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->name(),
            'number'        => $this->faker->unique()->numberBetween(1, 100),
            'admin_id'      => Admin::whereRoleIs(['manager', 'receptionist'])->inRandomOrder()->first()->id,
        ];
    }
}
