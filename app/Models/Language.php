<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';

    public static function get_languages()
    {
        return self::query()->get();
    }


//relations --------------------------------------start
    public function employees()
    {
        return $this->belongsToMany('App\Employee','employee_2_languages');
    }

}
