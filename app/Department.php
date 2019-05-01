<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    public static function getDepartment($id)
    {
        $department = DB::table('departments')->where('id',$id)->first();
        return $department;
    }
}
