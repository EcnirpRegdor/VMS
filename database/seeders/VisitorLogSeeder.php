<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Department;
use App\Models\VisitorLog;
use Faker\Factory as Faker;

class VisitorLogSeeder extends Seeder
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
        $visitorIds = Visitor::pluck('id')->toArray();
        $deptIds = Department::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            VisitorLog::create([
                'purpose' => $faker->sentence(5),
                'user_id' => $faker->randomElement($userIds),
                'visitor_id' => $faker->randomElement($visitorIds),
                'visited_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'dept_id' => $faker->randomElement($deptIds),
            ]);
        }
    }
}
