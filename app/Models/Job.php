<?php

namespace App\Models;

use App\HelpModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Job extends Model
{
    protected $table = 'jobs_vacansies';

    public static function add_job($request){

        try{
            DB::beginTransaction();

            $obj = new self();
            $obj->title = $request->input('title');
            $obj->place = $request->input('place');
            $obj->salary = $request->input('salary');
            $obj->type_id = $request->input('type');
            $obj->category_id = $request->input('category');
            $obj->region_id = $request->input('region');
            $obj->description = $request->input('description');
            $obj->company_id = auth()->guard('company')->user()->id;
            $obj->closing_date = $request->input('closing_date');
            if((int)$request->input('status') == 0){
                $obj->status = 0;
            } else {
                $obj->status = 1;
            }
            $obj->save();

            $params = array('job_id'=>$obj->id);

            HelpModel::delete_job_2_skills_rows($params);

            foreach ($request->input('skills') as $skill_id){
                HelpModel::add_job_2_skills_row($skill_id,$obj->id);
            }

            DB::commit();

            return true;

        } catch (\Exception $e){

            DB::rollBack();

            return false;
        }
    }

    public static function edit_job($request,$job){

        try{
            DB::beginTransaction();

            $job->title = $request->input('title');
            $job->place = $request->input('place');
            $job->salary = $request->input('salary');
            $job->type_id = $request->input('type');
            $job->category_id = $request->input('category');
            $job->region_id = $request->input('region');
            $job->description = $request->input('description');
            $job->closing_date = $request->input('closing_date');
            if((int)$request->input('status') == 0){
                $job->status = 0;
            } else {
                $job->status = 1;
            }
            $job->update();

            $params = array('job_id'=>$job->id);

            HelpModel::delete_job_2_skills_rows($params);

            foreach ($request->input('skills') as $skill_id){
                HelpModel::add_job_2_skills_row($skill_id,$job->id);
            }

            DB::commit();

            return $job;

        } catch (\Exception $e){
            DB::rollBack();

            return false;
        }

    }

    public static function get_job($job_id,$company_id = false){
        return self::query()
                    ->where('company_id',$company_id)
                    ->where('id',$job_id)
                    ->first();
    }

    public static function get_jobByID($job_id){
        return self::query()->find((int)$job_id);
    }

    public static function get_jobs($limit = 1000,$field='created_at',$sort = 'asc')
    {
        return self::query()->orderBy($field,$sort)->limit($limit)->get();
    }

    public static function get_all_jobs($per_page = 10,$field = 'created_at', $sort = 'desc')
    {
        return self::query()->orderBy($field,$sort)->paginate($per_page);
    }

    public static function search_jobs($per_page = 10,$type = 0,$region = 0,$category = 0, $skill = 0)
    {
        $job_ids = array();
        if($skill){
            $job_ids = HelpModel::get_job_2_skills_BySkillID($skill);
        }
        return self::query()->where(function($q) use($type,$region,$category,$skill,$job_ids){
           if($type){
               $q->where('type_id','=',$type);
           }
           if($region){
               $q->where('region_id','=',$region);
           }
           if($category){
               $q->where('category_id','=',$category);
           }
           if($skill){
                $q->whereIn('id',$job_ids);
           }

       })->orderBy('closing_date','asc')
         ->paginate($per_page);
    }

    public static function get_jobs_count($params = array())
    {
        return self::query()->where($params)->count();
    }

    public static function get_jobs_by_companyID($company_id,$limit = 1000){
        return self::query()
            ->where('company_id','=',$company_id)
            ->orderBy('created_at','desc')
            ->limit($limit)
            ->get();
    }

    public static function get_jobs_joined_letters_ForEmployee($employee_id){

        return self::query()->select('jobs_vacansies.*','application_letters.status as letter_status',
            'application_letters.id as letter_id','application_notifications.id as ntf_id')
            ->join('employee_2_jobs', function($j_1) use ($employee_id){
                $j_1->on('jobs_vacansies.id','=','employee_2_jobs.job_id');
                $j_1->on(DB::raw($employee_id),'=','employee_2_jobs.employee_id');
            })
            ->join('application_letters',function($j_2) use ($employee_id){
                $j_2->on('jobs_vacansies.id','=','application_letters.job_id');
                $j_2->on(DB::raw($employee_id),'=','application_letters.employee_id');
            })
            ->leftJoin('application_notifications',function($j_3) use ($employee_id){
                $j_3->on('jobs_vacansies.id','=','application_notifications.job_id');
                $j_3->on(DB::raw($employee_id),'=','application_notifications.employee_id');
            })
            ->get();
    }


// relations ------------------------------------start

    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill','job_2_skills','job_id','skill_id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region','region_id','id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type','type_id','id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company','company_id','id');
    }

    public function employees()
    {
        return $this->belongsToMany('App\Employee','employee_2_jobs');
    }

    public function application_letters()
    {
        return $this->hasMany('App\Models\ApplicationLetter','job_id','id');
    }

    public function invitations()
    {
        return $this->hasMany('App\Models\InvitationLetter','job_id','id');
    }

    public function application_notification()
    {
        return $this->hasOne('App\Models\ApplicationNotification','job_id','id');
    }

    public function invitation_notification()
    {
        return $this->hasOne('App\Models\InvitationNotification','job_id','id');
    }


}
