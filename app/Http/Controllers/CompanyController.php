<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use App\HelpModel;
use App\Jobs\NotifyEmployees;
use App\Mail\NotifyEmail;
use App\Models\ApplicationLetter;
use App\Models\ApplicationNotification;
use App\Models\Category;
use App\Models\InvitationLetter;
use App\Models\InvitationNotification;
use App\Models\Job;
use App\Models\Region;
use App\Models\Resume;
use App\Models\Skill;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $new_applications_count = ApplicationLetter::get_new_applications_count(auth()->guard('company')->user()->id);

            view()->share('new_applications', $new_applications_count);
            view()->share('auth_user_exists',true);

            return $next($request);
        });
    }

    public function CompanyAcountRedirect(){
        $data = array();
        $data['title'] = 'Home';

        $data['jobs_count'] = auth()->guard('company')->user()->jobs->count();
        $data['applications_count'] = auth()->guard('company')->user()->application_letters->count();
        $data['invitations_count'] = auth()->guard('company')->user()->invitations->count();

        return view('company.home',compact('data'));
    }

    public function lookResume($employee_id,Request $request)
    {
        $data = array();
        $data['title'] = 'Resume';

        $data['resume'] = Resume::get_resumeByEmployeeID($employee_id);

        if($data['resume'] && isset($data['resume']->id)){
            $data['employee_name'] = $data['resume']->employee()->first()->name;
            $data['employee_last_name'] = $data['resume']->employee()->first()->last_name;
            return view('single_resume',compact('data'));
        } else {
            $request->session()->flash('message', 'This candidate has not added resume yet!');
            $request->session()->flash('type', 'info');
            return redirect()->back();
        }
    }

    public function downloadCv(Request $request)
    {
        if($request->isMethod('post')){
            if((int)$request->input('application_id') > 0){
                $application = ApplicationLetter::get_applicationByID($request->input('application_id'),'company_id',auth()->guard('company')->user()->id);

                if($application && isset($application->uploaded_cv) && $application->uploaded_cv){
                    try{
                        return Response::download(storage_path('app/').$application->uploaded_cv,'cv.pdf');
                    } catch (\Exception $e){
                        $request->session()->flash('message', 'Something went wrong, try later');
                        $request->session()->flash('type', 'danger');
                        return redirect()->back();
                    }
                }
            }
        }
    }

    public function addJob(Request $request)
    {
        if($request->isMethod('post')){
            $rules = $this->jobRules();
            $this->validate($request,$rules);

            $result = Job::add_job($request);

            if($result){
                $request->session()->flash('message', 'Job is added');
                $request->session()->flash('type', 'success');
                return redirect('/company/jobs');
            } else {
                $request->session()->flash('message', 'Something went wrong, try later');
                $request->session()->flash('type', 'danger');
                return redirect('/company/jobs');
            }

        } elseif ($request->isMethod('get')){
            $data = array();
            $data['title'] = 'Add Job';
            $data['types'] = Type::get_types();
            $data['regions'] = Region::get_regions();
            $data['categories'] = Category::get_categories();
            $data['skills'] = Skill::get_skills();

            return view('company.add_job',compact('data'));
        }
    }

    public function editJob($id,Request $request)
    {
        $data = array();
        $data['title'] = 'Edit Job';
        $data['job'] = Job::get_job($id,auth()->guard('company')->user()->id);

        if($data['job'] && isset($data['job']->id)){
            if($request->isMethod('post')){

                $rules = $this->jobRules();
                $this->validate($request,$rules);

                $old_status = $data['job']->status;

                $result = Job::edit_job($request,$data['job']);

                if($result){
                    $new_status = $result->status;

                    if($old_status != $new_status){
                        if($result->employees){
                            $view = 'mail.employee_ntf';
                            $subject = 'Job status, which You have appilied, is changed';
                            $arr = array();
                            $arr['view'] = $view;
                            $arr['subject'] = $subject;
                            $arr['job_title'] = $result->title;
                            $arr['new_status'] = $new_status;
                            try {
                                $mails_array = $result->employees->pluck('email')->toArray();
                                //array_push($mails_array,'movsisyangag@gmail.com');
                                Mail::to($mails_array)->queue(new NotifyEmail($arr));
                            }
                            catch (\Exception $e){
                               // dd($e->getMessage());
                            }
                        }
                    }

                    $request->session()->flash('message', 'Job is updated');
                    $request->session()->flash('type', 'success');
                    return redirect('/company/edit-job/'.$id);
                } else {
                    $request->session()->flash('message', 'Something went wrong, try later');
                    $request->session()->flash('type', 'danger');
                    return redirect('/company/edit-job/'.$id);
                }

            } elseif($request->isMethod('get')){

                $data['types'] = Type::get_types();
                $data['regions'] = Region::get_regions();
                $data['categories'] = Category::get_categories();
                $data['skills'] = Skill::get_skills();

                $data['job_skills'] = $data['job']->skills->pluck('id')->toArray();

                return view('company.edit_job',compact('data'));
            }
        } else {
            return redirect()->back();
        }
    }

    public function sendInvitation(Request $request)
    {
        if($request->isMethod('post')){

            $rules = $this->invitationRules();
            $messages = array('job_id.required'=>'The job field is required.');
            $this->validate($request,$rules,$messages);

            $employee = Employee::get_employeeByID((int)$request->input('employee_id'));

            if($employee && isset($employee->id)){
                $job = Job::get_job((int)$request->input('job_id'),auth()->guard('company')->user()->id);

                if($job && isset($job->id)){
                    $invited = InvitationLetter::check_if_invited(auth()->guard('company')->user()->id,$employee->id,$job->id);
                    if(!$invited){
                        $result = InvitationLetter::invite_employee_to_job(auth()->guard('company')->user()->id,$request);
                        if($result){
                            try{
                                $info = [
                                    'invitation_id' => $result->id,
                                    'employee_id' => $result->employee_id,
                                    'company_id' => auth()->guard('company')->user()->id,
                                    'job_id' => $result->job_id,
                                    'canceled' => $result->canceled
                                ];
                                InvitationNotification::add_or_update_row($info);

                            } catch (\Exception $e){
                                //dd($e->getMessage());
                            }

                            try{
                                $arr = array();
                                $arr['from_new_invitation'] = true;
                                $arr['email'] = $employee->email;
                                $arr['job_title'] = $job->title;
                                $obj = new MailController();
                                $obj->SendMail($arr);

                            } catch (\Exception $e1){
                                //dd($e1->getMessage());
                            }

                            $message = 'You have successfuly invited this employee to job: '.$job->title;
                            $type = 'success';
                        } else {
                            $message = 'Something went wrong, try later!';
                            $type = 'danger';
                        }
                    } else {
                        $message = 'You have already invited this employee to job: '.$job->title;
                        $type = 'info';
                    }
                    if($message && $type){
                        $request->session()->flash('message', $message);
                        $request->session()->flash('type', $type);
                    }
                    return redirect()->route('single.candidate',['id'=>$request->input('employee_id')]);
                } else {
                    return redirect()->back();
                }
            } else {
                return redirect()->back();
            }
        }
    }

    public function editInvitation($id,Request $request)
    {
        $data = array();
        $data['title'] = 'Edit Invitation';
        $data['invitation'] = InvitationLetter::get_invitation($id,'company_id',auth()->guard('company')->user()->id);
        if($data['invitation'] && isset($data['invitation']->id)){
            if($request->isMethod('post')){

                $rules = $this->invitationRules(true);
                $this->validate($request,$rules);

                $canceled = $data['invitation']->canceled;

                $result = InvitationLetter::edit_invitation($data['invitation'],$request);
                if($result){
                    $new_canceled = $result->canceled;
                    if($canceled != $new_canceled){

                        if($new_canceled == 1){
                           $canceled_text = 'canceled';
                        } else {
                            $canceled_text = 'activated';
                        }
                        try{
                            $info = [
                                'invitation_id'=>$result->id,
                                'employee_id'=>$result->employee_id,
                                'company_id'=>auth()->guard('company')->user()->id,
                                'job_id'=>$result->job_id,
                                'canceled'=>$new_canceled,
                            ];
                            InvitationNotification::add_or_update_row($info);
                        } catch (\Exception $e){
                            //dd($e->getMessage());
                        }

                        try{
                            $arr = array();
                            $arr['from_canceled_invitation'] = true;
                            $arr['email'] = $result->employee()->first()->email;
                            $arr['job_title'] = $result->job()->first()->title;
                            $arr['canceled_text'] = $canceled_text;
                            $obj = new MailController();
                            $obj->SendMail($arr);

                        } catch (\Exception $e1){
                            //dd($e1->getMessage());
                        }
                    }
                    $request->session()->flash('message', 'Invitation is successfuly updated!');
                    $request->session()->flash('type', 'success');
                } else {
                    $request->session()->flash('message', 'Something went wrong, try later!');
                    $request->session()->flash('type', 'danger');
                }
                return redirect('/company/edit-invitation/'.$id);

            } elseif ($request->isMethod('get')){

                return view('company.edit_invitation',compact('data'));
            }
        } else {
            return redirect()->back();
        }
    }

    public function profile(Request $request)
    {
        if($request->isMethod('post')){
            $rules = $this->profileRules();
            $messages = array(
                'image.dimensions' => 'Image dimensions should be: min width 260px, min height 300px '
            );
            $this->validate($request,$rules,$messages);

            if (!File::exists('images/company-logo')) {
                File::makeDirectory('images/company-logo', 0777, true);
                File::put('images/company-logo/index.php', '<?php echo "404"; ?>');
            }
            $result = Company::update_company($request);
            if($result){
                $request->session()->flash('message', 'Information is updated!');
                $request->session()->flash('type', 'success');
                return redirect('/company/profile');
            } else {
                $request->session()->flash('message', 'Something went wrong, try later!');
                $request->session()->flash('danger', 'success');
                return redirect('/company/profile');
            }
        } elseif($request->isMethod('get')){
            $data = array();
            $data['title'] = 'Profile';
            $data['regions'] = Region::get_regions();
            $data['categories'] = Category::get_categories();
            $data['company'] = Company::get_companyByID(auth()->guard('company')->user()->id);
            return view('company.profile',compact('data'));
        }

    }

    public function getJobs()
    {
        $data = array();
        $data['title'] = 'Jobs';

        $data['jobs'] = Job::get_jobs_by_companyID(auth()->guard('company')->user()->id);

        return view('company.jobs',compact('data'));
    }

    public function getInvitations()
    {
        $data = array();
        $data['title'] = 'Invitations';

        $data['invitations'] = InvitationLetter::get_invitations_ForCompany(auth()->guard('company')->user()->id);

        return view('company.invitations',compact('data'));
    }

    public function getApplicants($job_id)
    {
        if((int)$job_id > 0){
            $job = Job::get_job($job_id,auth()->guard('company')->user()->id);
            if($job && isset($job->id)){
                $employee_ids = HelpModel::get_employee_2_jobs_ByJobID($job_id);
                $data = array();
                $data['title'] = 'Applicants';
                $data['job_title'] = $job->title;
                $data['job_id'] = $job_id;
                $data['employees'] = array();
                $data['employee_id_and_status'] = array();
                if($employee_ids){
                    $data['employee_id_and_status'] = ApplicationLetter::employee_to_status_asKeyValue($job_id,auth()->guard('company')->user()->id);
                    $data['employees'] = Employee::get_job_applicants($employee_ids);
                }
                $data['employee_id_and_viewed'] = ApplicationLetter::employee_to_viewed_asKeyValue($job_id,auth()->guard('company')->user()->id);
                // on progress

                return view('company.job_applicants',compact('data'));

            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }

    }

    public function applicationLetter($employee_id,$job_id,Request $request)
    {
        $data = array();
        $data['letter'] = ApplicationLetter::get_application($employee_id,$job_id,auth()->guard('company')->user()->id);

        if($data['letter'] && isset($data['letter']->id)){

            if($request->isMethod('post')){

                if($request->input('val') == 'accepted' || $request->input('val') == 'declined'){
                    $data['letter']->status = $request->input('val');
                    $data['letter']->update();
                    if($data['letter'] && isset($data['letter']->id)){

                        // notify employee about letter status changing
                        try{
                            $info = [
                                'application_id' => $data['letter']->id,
                                'employee_id' => $employee_id,
                                'company_id' => auth()->guard('company')->user()->id,
                                'job_id' => $job_id,
                                'status' => $request->input('val')
                            ];

                            ApplicationNotification::add_or_update_row($info);

                        } catch (\Exception $e2){
                            //
                        }

                        $message_part = '!';
                        $type = 'info';

                        if($request->input('decision')){
                            try{
                                $arr = array();
                                $arr['from_decision'] = true;
                                $arr['employee_email'] = $data['letter']->employee->email;
                                $arr['employee_full_name'] = $data['letter']->employee->name.' '.$data['letter']->employee->last_name;
                                $arr['company_name'] = auth()->guard('company')->user()->company_name;
                                $arr['company_decision'] = $request->input('val');
                                $arr['company_decision_text'] = $request->input('decision');
                                $arr['job_title'] = $data['letter']->job->title;

                                $obj = new MailController();
                                $res = $obj->SendMail($arr);
                                if($res){
                                    $message_part = ', and email is successfuly sent to employee!';
                                    $type = 'success';
                                }

                            } catch (\Exception $e){
                                //
                            }
                        }

                        $request->session()->flash('message', 'You have '.$request->input('val').' this letter'.$message_part);
                        $request->session()->flash('type', $type);
                        return redirect('/company/application-letter/'.$employee_id.'/'.$job_id);
                    }
                } else {
                    return redirect()->back();
                }

            } elseif ($request->isMethod('get')){
                $data['title'] = 'Application';
                if(!$data['letter']->viewed){
                    ApplicationLetter::set_viewed($data['letter']);
                    return redirect('/company/application-letter/'.$employee_id.'/'.$job_id);
                }
                return view('company.application_letter',compact('data'));
            }
        } else {
            return redirect()->back();
        }

    }

    public function unverify_company()
    {
        if(auth()->guard('company')->user()['verify'] == 1){
            return redirect('company/home');
        }
        $data = array();
        $data['title'] = 'Verification';
        Session::flash('verify_text','We have send You a verification email to '.(auth()->guard('company')->user()['email']).' ! <br> Please check it and verify Your account!');
        Session::flash('resend_text','If you do not recieve the email, Please click ');
        Session::flash('type','success');

        return view('verification',compact('data'));
    }

    public function sendRepeatEmail(Request $request)
    {
        if($request->isMethod('post')){

            $verify_code = auth()->guard('company')->user()->verify_code;
            $verify_url = url('/').'/Account-Verification/'.$verify_code;

            $data = array();
            $data['verify_url'] = $verify_url;
            $data['email'] = auth()->guard('company')->user()->email;
            $data['name'] = auth()->guard('company')->user()->contact_person_name.' ('.auth()->guard('company')->user()->company_name.')';
            $obj = new MailController();
            $res = $obj->SendMail($data);

            if($res){
                $request->session()->flash('message', 'Verification email is successfuly sent!');
                $request->session()->flash('typeV', 'success');
            } else {
                $request->session()->flash('message', 'Something went wrong, try later!');
                $request->session()->flash('typeV', 'danger');
            }

            return redirect('/company/verify-company-account');

        }
    }

    public function changeEmailAddress(Request $request)
    {
        if($request->isMethod('post')){
            $company_id = auth()->guard('company')->user()->id;

            $rules = array('new_email'=>'required|email|unique:companies,email');
            $this->validate($request,$rules);

                try {
                    DB::beginTransaction();
                    Company::query()->where('id',$company_id)->update(['email'=>$request->input('new_email')]);

                    $obj = new MailController();
                    $arr = array();

                    $verify_code = auth()->guard('company')->user()->verify_code;
                    $verify_url = url('/').'/Account-Verification/'.$verify_code;

                    $arr['verify_url'] = $verify_url;
                    $arr['name'] = auth()->guard('company')->user()->contact_person_name.' ('.auth()->guard('company')->user()->company_name.')';
                    $arr['email'] = $request->input('new_email');

                    $res = $obj->SendMail($arr);

                    if($res){
                        DB::commit();
                        $request->session()->flash('message', 'Your email address is successfuly changed and email is sent to this address!');
                        $request->session()->flash('typeV', 'success');
                        return redirect('/company/verify-company-account');
                    } else {
                        DB::rollBack();
                    }

                } catch (\Exception $e) {

                    DB::rollBack();
                }
                $request->session()->flash('message', 'Something went wrong, try later!');
                $request->session()->flash('typeV', 'danger');
                return redirect('/company/verify-company-account');


        }
    }


// validation rules functions -------------------------start
    public function profileRules()
    {
        return array(
            'company_name' => 'required|min:3|max:30',
            'contact_person_name' => 'required|min:3|max:30',
            'contact_person_phone' => 'required|min:3|max:20',
            'tax_number' => 'required|min:3|max:20',
            'title' => 'required|min:3|max:40',
            'address' => 'required|min:3|max:40',
            'room' => 'required|min:1|max:40',
            'web_site' => 'required|min:3|max:40',
            'category' => 'required|numeric|exists:categories,id',
            'region' => 'required|numeric|exists:regions,id',
            'description' => 'required|min:3|max:1200',
            'image' => 'required_without:old_image|image|max:10240|dimensions:min_width=260,min_height=300',
        );
    }

    public function jobRules()
    {
        return array(
            'title' => 'required|min:3|max:40',
            //'place' => 'required|min:3|max:40',
            'salary' => 'required|numeric|digits_between:1,10',
            'status' => 'required|numeric',
            'closing_date' => 'date|date_format:"Y-m-d"|required|after:'.Carbon::now()->addDay(-1)->format('Y-m-d'),
            'category' => 'required|numeric|exists:categories,id',
            'region' => 'required|numeric|exists:regions,id',
            'type' => 'required|numeric|exists:types,id',
            'skills' => 'required|array',
            'skills.*' => 'required|numeric|distinct|exists:skills,id',
            'description' => 'required|min:3|max:2500',
        );
    }

    public function invitationRules($from_edit = false)
    {
        if(!$from_edit){
            $rules =  array(
                'message' => 'max:400',
                'job_id' => 'required'
            );
        } else {
            $rules =  array(
                'message' => 'max:400',
                'canceled' => 'in:0,1'
            );
        }
        return $rules;
    }
// validation rules functions -------------------------end




}
