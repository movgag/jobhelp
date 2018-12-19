<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HelpModel extends Model
{

    public static function get_employee_2_jobs_ByJobID($job_id)
    {
        return DB::table('employee_2_jobs')
            ->where('job_id',$job_id)
            ->pluck('employee_id')
            ->toArray();
    }

    public static function get_job_2_skills_BySkillID($skill_id){
        return DB::table('job_2_skills')
            ->where('skill_id',$skill_id)
            ->pluck('job_id')
            ->toArray();
    }

    public static function get_employee_2_skills_BySkillID($skill_id){
        return DB::table('employee_2_skills')
            ->where('skill_id',$skill_id)
            ->pluck('employee_id')
            ->toArray();
    }

    public static function get_employee_2_jobs_ByEmployeeID($employee_id){
        return DB::table('employee_2_jobs')
            ->where('employee_id',$employee_id)
            ->get();
    }

    public static function check_if_applied($job_id,$employee_id){
        return DB::table('employee_2_jobs')
            ->where('employee_id',$employee_id)
            ->where('job_id',$job_id)
            ->exists();
    }

    public static function add_employee_2_skills_row($skill_id,$employee_id){

        $data = array(
            array(
                'skill_id'=>$skill_id,
                'employee_id'=>$employee_id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            )
        );
        DB::table('employee_2_skills')->insert($data);
    }

    public static function add_job_2_skills_row($skill_id,$job_id){

        $data = array(
            array(
                'skill_id'=>$skill_id,
                'job_id'=>$job_id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            )
        );
        DB::table('job_2_skills')->insert($data);
    }

    public static function add_employee_2_languages_row($language_id,$employee_id){

        $data = array(
            array(
                'language_id'=>$language_id,
                'employee_id'=>$employee_id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            )
        );
        DB::table('employee_2_languages')->insert($data);
    }

    public static function add_employee_2_jobs_row($job_id,$employee_id){

        $data = array(
            array(
                'job_id'=>$job_id,
                'employee_id'=>$employee_id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            )
        );
        DB::table('employee_2_jobs')->insert($data);
    }


    public static function delete_employee_2_skills_rows($params){
        return DB::table('employee_2_skills')->where($params)->delete();
    }

    public static function delete_job_2_skills_rows($params){
        return DB::table('job_2_skills')->where($params)->delete();
    }

    public static function delete_employee_2_languages_rows($params){
        return DB::table('employee_2_languages')->where($params)->delete();
    }



}
