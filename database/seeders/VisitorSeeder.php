<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visitor;
use App\Models\User;
use Faker\Factory as Faker;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $userIds = User::pluck('id')->toArray();

        for ($i = 0; $i < 30; $i++) {
            Visitor::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'contact' => $faker->phoneNumber,
                'address' => $faker->address,
                'profile_image' => $faker->optional()->imageUrl(200, 200, 'people'),
                'affiliation' => $faker->optional()->company,
                'user_id' => $faker->optional()->randomElement($userIds),
            ]);
        }
    }
}
