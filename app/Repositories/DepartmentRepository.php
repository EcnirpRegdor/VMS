<?php

namespace App\Repositories;


use App\Models\Department;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function showDepartments(){
        return Department::orderBy("dept_name")->get();
    }

}