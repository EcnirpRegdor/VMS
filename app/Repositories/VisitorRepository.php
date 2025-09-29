<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent;
use App\Models\Visitor;

class VisitorRepository implements VisitorRepositoryInterface
{
    public function showVisitors(){
        return Visitor::orderBy("id")->get();
    }

}