<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{

    public function SendMail($data){
        $view = 'mail.mail';
        $subject = 'Verificate your account';

        if(isset($data['from_contact'])){  // from contact case
            $view = 'mail.contact_mail';
            $subject = 'You have new message';
            $data['email'] = 'movsisyangag@gmail.com';
        }
        if(isset($data['from_decision'])){ // from company decision case
            $view = 'mail.company_decision';
            $subject = 'New message about Your application';
            $data['email'] = $data['employee_email'];
        }
        if(isset($data['from_apply'])){
            $view = 'mail.apply_mail';
            $subject = 'You have new application';
        }
        if(isset($data['name']) && isset($data['last_name'])){  // job status is changed
            $view = 'mail.employee_ntf';
            $subject = 'Job status, which You have appilied, is changed';
        }

        if(isset($data['from_new_invitation'])){
            $view = 'mail.new_invitation_mail';
            $subject = 'You have new invitation';
        }
        if(isset($data['from_canceled_invitation'])){
            $view = 'mail.canceled_invitation_mail';
            $subject = 'Your invitation is '.$data['canceled_text'];
        }
        if(isset($data['from_company_register'])){
            $view = 'mail.new_company_mail';
            $subject = 'New registered company';
        }

        try{
            Mail::send($view,['data'=>$data], function ($message) use ($data,$subject){
                $message->from(env('MAIL_USERNAME'), 'JobHelp Support');
                $message->subject($subject);
                $message->to($data['email']);
            });
            return true;
        } catch (\Exception $e){
            //var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * @param $verify_code
     * @return \Illuminate\Http\RedirectResponse
     */

}
