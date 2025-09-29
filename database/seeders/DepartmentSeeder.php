<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = ['IT','HR','Finance', 'Marketing'];

        foreach ($departments as $dept){
            Department::create(['dept_name' => $dept]);
        };

    }
}
