<?php

namespace App\Models;

use App\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Resume extends Model
{
    protected $table = 'resumes';

    public static function get_resumes_count($params=array())
    {
        return self::query()->where($params)->count();
    }

    public static function update_resume($request)
    {
        $employee_id = (int)auth()->guard('employee')->user()->id;

        $resume = self::query()->where('employee_id',$employee_id)->first();

        if($resume && isset($resume->id)){
            $obj = $resume;
        } else {
            $obj = new self();
            $obj->employee_id = $employee_id;
        }

        $obj->country = $request->input('country');
        $obj->city = $request->input('city');
        $obj->address = $request->input('address');
        $obj->phone = $request->input('phone');
        $obj->email = $request->input('email');
        $obj->web_site = $request->input('web_site');
        $obj->self_description = $request->input('self_description');
        $obj->university_name = $request->input('university_name');
        $obj->degree = $request->input('degree');
        $obj->education_description = $request->input('education_description');
//        $obj->job_title = $request->input('job_title');
//        $obj->job_description = $request->input('job_description');
//        $obj->date_from = $request->input('date_from');
//        $obj->date_to = $request->input('date_to');

        if($request->hasFile('image')){

            if($request->input('old_image') != '' && auth()->guard('employee')->user()->resume()->first()
                && isset(auth()->guard('employee')->user()->resume()->first()->image)
                && $request->input('old_image') == auth()->guard('employee')->user()->resume()->first()->image ){
                File::delete('images/resume_images/'.$request->input('old_image'));
            }
            $file_name = "";
            $generated_string = time();
            $extension = $request->file('image')->getClientOriginalExtension();
            $file_name = $generated_string.".".$extension;

            //$new_file = "images/resume_images/".$file_name;

            $request->file('image')->move(public_path('images/resume_images'), $file_name);

            //File::move($request->file('image'),$new_file);
            $obj->image = $file_name;
        }
        $obj->save();

        if($obj && isset($obj->id)){
           return true;
        } else {
            return false;
        }
    }

    public static function get_resumeByEmployeeID($employee_id){
        return self::query()->where('employee_id',$employee_id)->first();
    }


// relations -----------------------------------start
    public function employee()
    {
        return $this->hasOne('App\Employee','id','employee_id');
    }

    public function job_details()
    {
        return $this->hasMany('App\Models\ResumeJobDetail','resume_id','id');
    }


}
