<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected  $table = 'types';

    public static function get_types(){
        return self::query()->get();
    }


// relations --------------------------------- start
    public function jobs(){

        $this->hasMany('App\Models\Job','type_id','id');
    }
}
