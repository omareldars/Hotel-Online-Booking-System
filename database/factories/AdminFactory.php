<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'           => $this->faker->firstName(),
            'email'          => $this->faker->unique()->safeEmail,
            'national_id'    => $this->faker->ean13(),
            'password'       => bcrypt(123),
            'phone'          => $this->faker->phoneNumber(),
            'image'          => $this->faker->image(public_path('uploads/images/admins'), 150, 150, 'users', false),
            'remember_token' => Str::random(10),
            'created_by'     => 1,
        ];
    }
}
