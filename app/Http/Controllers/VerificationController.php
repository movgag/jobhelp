<?php

namespace App\Http\Controllers;


use App\Employee;
use App\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerificationController extends Controller
{

    public function Verification($verify_code){

        $emp = Employee::query()->where('verify_code',$verify_code)->first();
        if($emp){
            $this->verfy_func($emp);
            return redirect('/');
        } else{
            $comp = Company::query()->where('verify_code',$verify_code)->first();
            if($comp){
                $this->verfy_func($comp);
                return redirect('/');
            }
        }
        return redirect('/');
    }

    public function verfy_func($data){
        if($data->verify == 1){
            Session::flash('verify_text','Your account is already verified');
            Session::flash('type','success');
        }else{
            $data->status = 1;
            $data->verify = 1;
            $data->save();
            if($data){
                $text_part = '';
                if(get_class($data) == 'App\Company'){
                    $text_part = ', our admin will approve Your account during 24 hours';
                }
                Session::flash('verify_text','Congratulation ! Your profile has been verified'.$text_part);
                Session::flash('type','success');
            } else {
                Session::flash('verify_text','Something went wrong, connect to our support center!');
                Session::flash('type','danger');
            }

        }
    }



}
