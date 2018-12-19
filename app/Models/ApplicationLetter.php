<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationLetter extends Model
{
    protected $table = 'application_letters';

    public static function get_applicationsByEmployeeID($employee_id){
        return self::query()->where('employee_id',$employee_id)->get();
    }

    public static function get_new_applications_count($company_id)
    {
        return self::query()
            ->where('company_id',$company_id)
            ->where('viewed',0)
            ->count();
    }

    public static function set_viewed($application_letter){
        $application_letter->viewed = 1;
        $application_letter->save();
    }

    public static function apply_job($job_id,$employee_id,$company_id,$request){
        $obj = new self();
        $obj->job_id = $job_id;
        $obj->employee_id = $employee_id;
        $obj->company_id = $company_id;
        $obj->apply_letter = $request->input('apply_letter');
        $obj->excepted_salary = $request->input('excepted_salary');

        if($request->hasFile('uploaded_cv')){
            $path = $request->file('uploaded_cv')->store('cvs');
            $obj->uploaded_cv = $path;
        }
        $obj->save();
        if($obj && isset($obj->id)){
            return true;
        } else {
            return false;
        }
    }

    public static function get_application($employee_id,$job_id,$company_id){
        return self::query()->where('job_id',$job_id)
            ->where('employee_id',$employee_id)
            ->where('company_id',$company_id)
            ->first();
    }

    public static function get_applicationByID($application_id,$field,$user_id){
        return self::query()
            ->where('id',$application_id)
            ->where($field,$user_id)
            ->first();
    }

    public static function employee_to_status_asKeyValue($job_id,$company_id){
        return self::query()->where('job_id',$job_id)
            ->where('company_id',$company_id)
            ->pluck('status','employee_id')->toArray();
    }

    public static function employee_to_viewed_asKeyValue($job_id,$company_id){
        return self::query()->where('job_id',$job_id)
            ->where('company_id',$company_id)
            ->where('viewed',0)
            ->pluck('viewed','employee_id')->toArray();
    }

    public static function edit_application($application,$request){
        $application->excepted_salary = $request->input('excepted_salary');
        $application->apply_letter = $request->input('apply_letter');
        $application->update();
        if($application && isset($application->id)){
            return true;
        } else {
            return false;
        }
    }

// relations --------------------------------------------start
    public function employee() {
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    public function company() {
        return $this->belongsTo('App\Company','company_id','id');
    }

    public function job() {
        return $this->belongsTo('App\Models\Job','job_id','id');
    }

    public function application_notification()
    {
        return $this->hasOne('App\Models\ApplicationNotification','application_id','id');
    }


}
