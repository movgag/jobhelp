<?php

namespace App;

use App\Models\Skill;
use App\Notifications\EmployeeResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Employee extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // protected $table = 'employees';

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmployeeResetPassword($token));
    }

    public static function add_employee($data)
    {
        $verify_code = str_random(10);
        $add = new self();
        $add->name = $data['name'];
        $add->last_name = $data['last_name'];
        $add->email = $data['email'];
        $add->verify_code = $verify_code;
        $add->phone = $data['phone'];
        $add->password = bcrypt($data['employee_password']);
        $add->save();
        if($add && $add->verify_code){
            return $add;
        }else{
            return false;
        }
    }

    public static function update_employee($request){
        $employee = self::find(auth()->guard('employee')->user()->id);

        if($employee && isset($employee->id)){

            try{
                DB::beginTransaction();

                $employee->name = $request->input('name');
                $employee->last_name = $request->input('last_name');
                $employee->date_of_birth = $request->input('date_of_birth');
                $employee->title = $request->input('title');
                $employee->address = $request->input('address');
                $employee->phone = $request->input('phone');
                $employee->category_id = $request->input('category');
                $employee->region_id = $request->input('region');
                $employee->type_id = $request->input('type');
                $employee->description = $request->input('description');

                if($request->hasFile('image')){

                    if($request->input('old_image') != '' && $request->input('old_image') == auth()->guard('employee')->user()->image ){
                        File::delete('images/candidates/'.$request->input('old_image'));
                    }
                    $file_name = "";
                    $generated_string = time();
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $file_name = $generated_string.".".$extension;

                    //$new_file = "images/candidates/".$file_name;

                    $request->file('image')->move(public_path('images/candidates'), $file_name);
                    //File::move($request->file('image'),$new_file);
                    $employee->image = $file_name;
                }

                $employee->update();

                $params = array('employee_id'=>auth()->guard('employee')->user()->id);

                HelpModel::delete_employee_2_skills_rows($params);
                HelpModel::delete_employee_2_languages_rows($params);

                foreach ($request->input('skills') as $skill_id){
                    HelpModel::add_employee_2_skills_row($skill_id,auth()->guard('employee')->user()->id);
                }
                foreach ($request->input('languages') as $language_id){
                    HelpModel::add_employee_2_languages_row($language_id,auth()->guard('employee')->user()->id);
                }

                DB::commit();

                return true;

            } catch (\Exception $e){

                DB::rollBack();
                return false;
            }

        } else {
            return false;
        }
    }

    public static function get_employeeByID($id){
        return self::query()->find($id);
    }

    public static function get_job_applicants($employee_ids)
    {
        return self::query()->whereIn('id',$employee_ids)->get();
    }

    public static function get_employees_count($params = array())
    {
        return self::query()->where($params)->count();
    }

    public static function get_all_candidates($per_page = 10,$field = 'created_at', $sort = 'desc')
    {
        return self::query()->orderBy($field,$sort)->paginate($per_page);
    }

    public static function get_random_employees($limit)
    {
        return self::query()->inRandomOrder()->limit($limit)->get();
    }

    public static function search_employees($per_page = 10, $type = 0,$region = 0,$category = 0, $skill = 0)
    {
        $employee_ids = array();
        if($skill){
            $employee_ids = HelpModel::get_employee_2_skills_BySkillID($skill);
        }

        return self::query()->where(function($q) use($type,$region,$category,$skill,$employee_ids){
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
                $q->whereIn('id',$employee_ids);
            }
        })->orderBy('id','desc')
          ->paginate($per_page);
    }


// relations --------------------------------------start
    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill','employee_2_skills','employee_id','skill_id');
    }

    public function languages()
    {
        return $this->belongsToMany('App\Models\Language','employee_2_languages','employee_id','language_id');
    }

    public function jobs()
    {
        return $this->belongsToMany('App\Models\Job','employee_2_jobs','employee_id','job_id');
    }

    public function region()
    {
        return $this->hasOne('App\Models\Region','id','region_id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category','id','category_id');
    }

    public function type()
    {
        return $this->hasOne('App\Models\Type','id','type_id');
    }

    public function resume()
    {
        return $this->hasOne('App\Models\Resume','employee_id','id');
    }

    public function application_letters()
    {
        return $this->hasMany('App\Models\ApplicationLetter','employee_id','id');
    }

    public function portfolios()
    {
        return $this->hasMany('App\Models\PortfoliosEmployee','employee_id','id');
    }

    public function invitations()
    {
        return $this->hasMany('App\Models\InvitationLetter','employee_id','id');
    }

    public function job_details()
    {
        return $this->hasMany('App\Models\ResumeJobDetail','employee_id','id');
    }

}
