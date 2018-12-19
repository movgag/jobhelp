<?php

namespace App;

use App\Notifications\CompanyResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\File;

class Company extends Authenticatable
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

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CompanyResetPassword($token));
    }

    public static function get_companyByID($id)
    {
        return self::query()->find($id);
    }

    public static function add_company($data)
    {
        $verify_code = str_random(10);
        $add = new self();
        $add->company_name = $data['company_name'];
        $add->contact_person_name = $data['contact_person_name'];
        $add->email = $data['email_company'];
        $add->verify_code = $verify_code;
        $add->contact_person_phone = $data['phone_number_company'];
        $add->tax_number = $data['tax_number'];
        $add->password = bcrypt($data['company_password']);
        $add->save();
        if($add && isset($add->verify_code) && $add->verify_code){
            return $add;
        }else{
            return false;
        }
    }

    public static function update_company($request){

        $company = self::find(auth()->guard('company')->user()->id);
        $company->company_name = $request->input('company_name');
        $company->contact_person_name = $request->input('contact_person_name');
        $company->contact_person_phone = $request->input('contact_person_phone');
        $company->tax_number = $request->input('tax_number');
        $company->title = $request->input('title');
        $company->address = $request->input('address');
        $company->room = $request->input('room');
        $company->web_site = $request->input('web_site');
        $company->category_id = $request->input('category');
        $company->region_id = $request->input('region');
        $company->description = $request->input('description');

        if($request->hasFile('image')){

            if($request->input('old_image') != '' && $request->input('old_image') == auth()->guard('company')->user()->image ){
                File::delete('images/company-logo/'.$request->input('old_image'));
            }
            $file_name = "";
            $generated_string = time();
            $extension = $request->file('image')->getClientOriginalExtension();
            $file_name = $generated_string.".".$extension;
            //$new_file = "images/company-logo/".$file_name;

            $request->file('image')->move(public_path('images/company-logo'), $file_name);

            //File::move($request->file('image'),$new_file);
            $company->image = $file_name;
        }

        $company->update();
        if($company && isset($company->id)){
            return true;
        } else {
            return false;
        }
    }

    public static function get_companies_count($params=array())
    {
        return self::query()->where($params)->count();
    }

    public static function get_random_companies($limit)
    {
        return self::query()->inRandomOrder()->limit($limit)->get();
    }

    public static function get_all_companies($per_page = 10, $field = 'created_at', $sort = 'desc')
    {
        return self::query()->orderBy($field,$sort)->paginate($per_page);
    }

    public static function search_companies($per_page = 10, $region = null,$category = null)
    {
        return self::query()->where(function($q) use($region,$category){
            if($region){
                $q->where('region_id','=',$region);
            }
            if($category){
                $q->where('category_id','=',$category);
            }
        })->orderBy('id','desc')
          ->paginate($per_page);
    }


// relations --------------------------------- start
    public function jobs()
    {
        return $this->hasMany('App\Models\Job','company_id','id');
    }

    public function region()
    {
        return $this->hasOne('App\Models\Region','id','region_id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category','id','category_id');
    }

    public function invitations()
    {
        return $this->hasMany('App\Models\InvitationLetter','company_id','id');
    }

    public function application_letters()
    {
        return $this->hasMany('App\Models\ApplicationLetter','company_id','id');
    }

    public function invitation_notifications()
    {
        return $this->hasMany('App\Models\InvitationNotification','company_id','id');
    }

    public function application_notifications()
    {
        return $this->hasMany('App\Models\ApplicationNotification','company_id','id');
    }

}
