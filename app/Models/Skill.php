<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';

    public static function get_skills()
    {
        return self::query()->get();
    }


// relations --------------------------------start
    public function employees()
    {
        return $this->belongsToMany('App\Employee','employee_2_skills');
    }

    public function jobs()
    {
        return $this->belongsToMany('App\Models\Job','job_2_skills');
    }
}
