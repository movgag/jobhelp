<?php

namespace App\Http\Controllers\CompanyAuth;

use App\Company;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/company/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('company.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:companies',
            'password' => 'required|min:6|confirmed',
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function register_company(Request $request)
    {
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'company_name' => 'required',
                'contact_person_name' => 'required',
                'email_company' => 'required|email|unique:employees,email|unique:companies,email',
                'phone_number_company' => 'required|numeric|digits_between:8,11',
                'tax_number' => 'required|numeric|digits_between:6,11',
                'company_password' => 'required|min:6',
                'retype_password_company' => 'required|min:6|same:company_password',
            ]);
            if ($validator->passes()) {
                $newcompany = Company::add_company($request->all());
                if($newcompany){
                    // send verification email to company
                    $verify_url = url('/').'/Account-Verification/'.$newcompany->verify_code;
                    $data = array();
                    $data['verify_url'] = $verify_url;
                    $data['email'] = $newcompany->email;
                    $data['name'] = $newcompany->contact_person_name.'('.$newcompany->company_name.')';
                    $obj = new MailController();
                    $res = $obj->SendMail($data);

                    // notify admin about new registered company
                    $arr = array();
                    $arr['email'] = 'movsisyangag@gmail.com';
                    $arr['from_company_register'] = true;
                    $arr['company_name'] = $newcompany->company_name;
                    $obj->SendMail($arr);

                    if(Auth::guard('company')->loginUsingId($newcompany->id)){
                        return 'true';
                    }
                } else{
                    return \Response::json(array(
                        'error' => 'Something went wrong, try later!'
                    ), 422);
                }
                return response()->json(['success'=>'Added new records.']);
            }
            return \Response::json(array(
                'errors' => $validator->messages()
            ), 422);
        }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Company
     */
    protected function create(array $data)
    {
        return Company::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('company.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('company');
    }
}
