<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';

    public static function get_regions(){
        return self::query()->get();
    }


// relations --------------------------------- start
    public function jobs()
    {
        $this->hasMany('App\Models\Job','region_id','id');
    }

}
