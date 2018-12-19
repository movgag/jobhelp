<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationLetter extends Model
{
    protected $table = 'invitation_letters';

    public static function edit_invitation($invitation,$request){
        $invitation->invitation_letter = $request->input('message');
        $invitation->canceled = (int)$request->input('canceled');
        $invitation->update();
        if($invitation && isset($invitation->id)){
            return $invitation;
        } else {
            return false;
        }
    }

    public static function get_invitation($invitation_id,$field,$user_id){
        return self::query()->where($field,$user_id)
            ->where('id',$invitation_id)
            ->first();
    }

    public static function get_invitations_ForCompany($company_id){
        return self::query()->where('company_id',$company_id)->get();
    }

    public static function get_invitations_ForEmployee($employee_id){
        return self::query()->where('employee_id',$employee_id)->get();
    }

    public static function get_invited_job_ids_ForEmployee($employee_id,$company_id){
        return self::query()->where('employee_id',$employee_id)
            ->where('company_id',$company_id)
            ->pluck('job_id')
            ->toArray();
    }

    public static function check_if_invited($company_id,$employee_id,$job_id){
        return self::query()
            ->where('company_id',$company_id)
            ->where('employee_id',$employee_id)
            ->where('job_id',$job_id)
            ->exists();
    }

    public static function invite_employee_to_job($company_id,$request)
    {
        $obj = new self();
        $obj->job_id = $request->input('job_id');
        $obj->employee_id = $request->input('employee_id');
        $obj->company_id = $company_id;
        $obj->invitation_letter = $request->input('message');
        $obj->canceled = 0;
        $obj->save();
        if($obj && isset($obj->id)){
            return $obj;
        } else {
            return false;
        }
    }


//relations ------------------------------------------start
    public function employee() {
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    public function company() {
        return $this->belongsTo('App\Company','company_id','id');
    }

    public function job() {
        return $this->belongsTo('App\Models\Job','job_id','id');
    }

    public function invitation_notification()
    {
        return $this->hasOne('App\Models\InvitationNotification','invitation_id','id');
    }

}
