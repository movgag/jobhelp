<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeJobDetail extends Model
{

    protected $table = 'resume_job_details';

    public static function get_detail($id, $employee_id){
        return self::query()->where('id',$id)->where('employee_id',$employee_id)->first();
    }

    public static function add_row($request){

        $obj = new self();
        $obj->resume_id = auth()->guard('employee')->user()->resume()->first()->id;
        $obj->employee_id = auth()->guard('employee')->user()->id;
        $obj->job_title = $request->input('job_title');
        $obj->job_description = $request->input('job_description');
        $obj->date_from = $request->input('date_from');
        $obj->date_to = $request->input('date_to');
        $obj->save();

        return $obj;
    }

    public static function update_row($request,$job_detail){

        $job_detail->job_title = $request->input('job_title');
        $job_detail->job_description = $request->input('job_description');
        $job_detail->date_from = $request->input('date_from');
        $job_detail->date_to = $request->input('date_to');
        $job_detail->update();
        return $job_detail;

    }


    public static function delete_row($job_detail){

        return $job_detail->delete();

    }





//relations -------------------------start

    public function resume() {
        return $this->belongsTo('App\Models\Resume','resume_id','id');
    }

}
