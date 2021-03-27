<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'name'           => 'super_admin',
            'email'          => 'super_admin@app.com',
            'national_id'    => '10000000000000',
            'password'       => bcrypt(123),
            'phone'          => '01286680617',
            'image'          => 'default.jpg',
            'remember_token' => Str::random(10),
        ]);

        $admin->attachRole('admin');

        $manager = Admin::create([
            'name'           => 'manager',
            'email'          => 'manager@app.com',
            'national_id'    => '11111111111111',
            'password'       => bcrypt(123),
            'phone'          => '01286620617',
            'image'          => 'default.jpg',
            'remember_token' => Str::random(10),
        ]);

        $manager->attachRole('manager');

        $receptionist = Admin::create([
            'name'           => 'user',
            'email'          => 'user@app.com',
            'national_id'    => '22222222222222',
            'password'       => bcrypt(123),
            'phone'          => '01286680637',
            'image'          => 'default.jpg',
            'remember_token' => Str::random(10),
        ]);

        $receptionist->attachRole('receptionist');

        $role = ['manager', 'receptionist'];
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $admin = Admin::create([
                'name'           => $faker->unique()->firstName(),
                'email'          => $faker->unique()->safeEmail,
                'national_id'    => $faker->ean13() . rand(0,9),
                'password'       => bcrypt(123),
                'phone'          => $faker->unique()->phoneNumber(),
                'image'          => $faker->image(public_path('uploads/images/admins'), 150, 150, 'users', false),
                'remember_token' => Str::random(10),
                'created_by'     => 1,
            ]);

            $admin->attachRole($role[rand(0,1)]);
        }

        User::create([
            'name'              => 'user',
            'email'             => 'user@app.com',
            'email_verified_at' => now(),
            'password'          => bcrypt(123),
            'phone'             => $faker->unique()->phoneNumber(),
            'image'             => 'default.jpg',
            'remember_token'    => Str::random(10),
            'approve'           => 1,
            'approved_by'       => 1
        ]);
    }
}
