<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationNotification extends Model
{
    protected $table = 'invitation_notifications';

    public static function get_notificationsByEmployeeID($employee_id,$limit=1000){
        $query =  self::query()->where('employee_id',$employee_id)->orderBy('updated_at','desc');
        $data = array();
        $data['notifications'] = $query->limit($limit)->get();
        $data['count_of_notifications'] = $query->count();
        return $data;
    }

    public static function get_single_notificationForEmployee($id,$employee_id){
        return self::query()->where('id',$id)
            ->where('employee_id',$employee_id)
            ->first();
    }

    public static function add_or_update_row($info){
        $invitation = self::query()
            ->where('invitation_id',$info['invitation_id'])
            ->where('employee_id',$info['employee_id'])
            ->where('company_id',$info['company_id'])
            ->where('job_id',$info['job_id'])
            ->first();
        if($invitation && isset($invitation->id)){
            $obj = $invitation;
        } else {
            $obj = new self();
            $obj->invitation_id = $info['invitation_id'];
            $obj->employee_id = $info['employee_id'];
            $obj->company_id = $info['company_id'];
            $obj->job_id = $info['job_id'];
        }
        $obj->canceled = $info['canceled'];
        $obj->save();
    }


    //relations ------------------------------------start

    public function invitation()
    {
        return $this->belongsTo('App\Models\InvitationLetter','invitation_id','id');
    }

    public function job()
    {
        return $this->belongsTo('App\Models\Job','job_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company','company_id','id');
    }





}
