<?php

namespace App\Http\Controllers\EmployeeAuth;

use App\Employee;
use App\Http\Controllers\MailController;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/employee/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('employee.guest');
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
            'email' => 'required|email|max:255|unique:employees',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Employee
     */

    public function register_employee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'email|unique:employees,email|unique:companies,email',
            'phone' => 'required|numeric|digits_between:8,11',
            'employee_password' => 'required|min:6',
            'retype_password' => 'required|min:6|same:employee_password',
        ]);
        if ($validator->passes()) {

            $newemployee = Employee::add_employee($request->all());
            if($newemployee){
                $verify_url = url('/').'/Account-Verification/'.$newemployee->verify_code;
                $data = array();
                $data['verify_url'] = $verify_url;
                $data['email'] = $newemployee->email;
                $data['name'] = $newemployee->name.' '.$newemployee->last_name;
                $obj = new MailController();
                $res = $obj->SendMail($data);

                if(Auth::guard('employee')->loginUsingId($newemployee->id)){

                    return 'true';
                }

//                if($res){
//
//                } else{
//                    return \Response::json(array(
//                        'error' => 'Something went wrong, contact our support center!'
//                    ), 422);
//                }
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


    protected function create(array $data)
    {
        return Employee::create([
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
        return view('employee.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('employee');
    }
}
