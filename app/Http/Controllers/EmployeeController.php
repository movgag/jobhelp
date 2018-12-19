<?php

namespace App\Http\Controllers;

use App\Employee;
use App\HelpModel;
use App\Models\ApplicationLetter;
use App\Models\ApplicationNotification;
use App\Models\Category;
use App\Models\InvitationLetter;
use App\Models\InvitationNotification;
use App\Models\Job;
use App\Models\Language;
use App\Models\PortfoliosEmployee;
use App\Models\Region;
use App\Models\Resume;
use App\Models\ResumeJobDetail;
use App\Models\Skill;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Validator;

class EmployeeController extends Controller
{
    protected $see_all_notifications = false;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $application_notifications = ApplicationNotification::get_notificationsByEmployeeID(auth()->guard('employee')->user()->id,5);
            $invitation_notifications = InvitationNotification::get_notificationsByEmployeeID(auth()->guard('employee')->user()->id,5);

            $allItems = new \Illuminate\Database\Eloquent\Collection;
            $allItems = $allItems->merge($application_notifications['notifications']);
            $allItems = $allItems->toBase()->merge($invitation_notifications['notifications']);

            $general_count  = (int)$application_notifications['count_of_notifications'] + (int)$invitation_notifications['count_of_notifications'];

            view()->share('all_items',$allItems->sortByDesc('updated_at'));
            view()->share('all_items_count',$general_count);

            if( ($invitation_notifications['count_of_notifications'] > $invitation_notifications['notifications']->count())
                || ($application_notifications['count_of_notifications'] > $application_notifications['notifications']->count()) )
            {
                view()->share('see_all_notifications',1);
                $this->see_all_notifications = true;
            }

            view()->share('auth_user_exists',true);

            return $next($request);
        });
    }

    public function getNotifications()
    {
        if($this->see_all_notifications){
            $data = array();
            $data['title'] = 'Notifications';

            $application_notifications = ApplicationNotification::get_notificationsByEmployeeID(auth()->guard('employee')->user()->id);
            $invitation_notifications = InvitationNotification::get_notificationsByEmployeeID(auth()->guard('employee')->user()->id);

            $allItems = new \Illuminate\Database\Eloquent\Collection;
            $allItems = $allItems->merge($application_notifications['notifications']);
            $allItems = $allItems->toBase()->merge($invitation_notifications['notifications']);

            $data['results'] = $allItems->sortByDesc('updated_at');
            $data['results_count'] = $allItems->count();

            return view('employee.notifications',compact('data'));
        } else {
            return redirect('/employee/home');
        }
    }

    public function EmployeeAcountRedirect(){
        $data = array();
        $data['title'] = 'Home';

        $data['invitations_count'] = auth()->guard('employee')->user()->invitations->count();
        $data['applied_jobs_count'] = auth()->guard('employee')->user()->jobs->count();
        $data['portfolios_count'] = auth()->guard('employee')->user()->portfolios->count();

        return view('employee.home',compact('data'));
    }

    public function removeApplicationNotification($id)
    {
        $notification = ApplicationNotification::get_single_notificationForEmployee($id,auth()->guard('employee')->user()->id);

        if($notification && isset($notification->id)){

            $notification->delete();
            return redirect()->route('single.job',['id'=>$notification->job_id]);
        } else {
            return redirect()->back();
        }
    }

    public function removeInvitationNotification($id)
    {
        $notification = InvitationNotification::get_single_notificationForEmployee($id,auth()->guard('employee')->user()->id);

        if($notification && isset($notification->id)){

            $notification->delete();
            return redirect('/employee/look-invitation/'.$notification->invitation_id);
        } else {
            return redirect()->back();
        }
    }

    public function portfolios()
    {
        $data = array();
        $data['title'] = 'Portfolios';

        $data['portfolios'] = auth()->guard('employee')->user()->portfolios;

        return view('employee.portfolios',compact('data'));
    }

    public function addPortfolio(Request $request)
    {
        if($request->isMethod('post')){

            $rules = $this->portfolioRules();
            $messages = array(
                'image.dimensions' => 'Image dimensions should be: min width 370px, min height 250px '
            );
            $this->validate($request,$rules,$messages);

            if (!File::exists('images/emp-portfolios')) {
                File::makeDirectory('images/emp-portfolios', 0777, true);
                File::put('images/emp-portfolios/index.php', '<?php echo "404"; ?>');
            }
            $result = PortfoliosEmployee::add_portfolio($request);

            if($result){
                $request->session()->flash('message', 'Portfolio is added!');
                $request->session()->flash('type', 'success');
                return redirect('/employee/portfolios');
            } else {
                $request->session()->flash('message', 'Something went wrong, try later!');
                $request->session()->flash('danger', 'success');
                return redirect('/employee/portfolios');
            }
            
        } elseif($request->isMethod('get')){
            $data = array();
            $data['title'] = 'Add Portfolio';

            return view('employee.add_portfolio',compact('data'));
        }
    }

    public function editPortfolio($portfolio_id,Request $request)
    {
        $data = array();
        $data['portfolio'] = PortfoliosEmployee::get_portfolio($portfolio_id,auth()->guard('employee')->user()->id);

        if($data['portfolio'] && isset($data['portfolio']->id)){
            if($request->isMethod('post')){

                $rules = $this->portfolioRules(true);
                $messages = array(
                    'image.dimensions' => 'Image dimensions should be: min width 370px, min height 250px '
                );
                $this->validate($request,$rules,$messages);

                $result = PortfoliosEmployee::edit_portfolio($data['portfolio'],$request);

                if($result){
                    $request->session()->flash('message', 'Portfolio is updated!');
                    $request->session()->flash('type', 'success');
                    return redirect('/employee/edit-portfolio/'.$data['portfolio']->id);
                } else {
                    $request->session()->flash('message', 'Something went wrong, try later!');
                    $request->session()->flash('danger', 'success');
                    return redirect('/employee/edit-portfolio/'.$data['portfolio']->id);
                }

            } elseif ($request->isMethod('get')){
                $data['title'] = 'Edit Portfolio';

                return view('employee.edit_portfolio',compact('data'));
            }
        } else {
            return redirect()->back();
        }
    }

    public function deletePortfolio(Request $request)
    {
         if($request->isMethod('post')){
             $portfolio = PortfoliosEmployee::get_portfolio((int)$request->input('portfolio_id'),auth()->guard('employee')->user()->id);
             if($portfolio && isset($portfolio->id)){
                 $image_name = $portfolio->image;

                 $result = PortfoliosEmployee::delete_portfolio($portfolio);

                 File::delete('images/emp-portfolios/'.$image_name);

                 if($result){
                     $request->session()->flash('message', 'Portfolio is deleted!');
                     $request->session()->flash('type', 'success');
                     return redirect('/employee/portfolios');
                 } else {
                     $request->session()->flash('message', 'Something went wrong, try later!');
                     $request->session()->flash('type', 'danger');
                     return redirect('/employee/portfolios');
                 }
             } else {
                 $request->session()->flash('message', 'No such portfolio');
                 $request->session()->flash('type', 'danger');
                 return redirect('/employee/portfolios');
             }
         }
    }

    public function editApplication($letter_id,Request $request)
    {
        $data = array();
        $data['letter'] = ApplicationLetter::get_applicationByID($letter_id,'employee_id',auth()->guard('employee')->user()->id);

        if($data['letter'] && isset($data['letter']->id)){
            if($data['letter']->status != 'unanswered'){
                $request->session()->flash('message', 'Your application status is '.$data['letter']->status.', You can not edit it!');
                $request->session()->flash('type', 'info');
                return redirect('/employee/applied-jobs');
            }
            if($request->isMethod('post')){

                $rules = $this->applyRules(true);
                $this->validate($request,$rules);

                $result = ApplicationLetter::edit_application($data['letter'],$request);

                if($result){
                    $request->session()->flash('message', 'You have successfuly updated Your application!');
                    $request->session()->flash('type', 'success');
                    return redirect('employee/edit-application/'.$letter_id);
                } else {
                    $request->session()->flash('message', 'Something went wrong, try later!');
                    $request->session()->flash('type', 'danger');
                    return redirect('employee/edit-application/'.$letter_id);
                }

            } elseif($request->isMethod('get')){

                $data['title'] = 'Edit Application';

                return view('employee.application_letter',compact('data'));
            }
        }else {
            return redirect()->back();
        }
    }

    public function downloadCv(Request $request)
    {
        if($request->isMethod('post')){
            if((int)$request->input('application_id') > 0){
                $application = ApplicationLetter::get_applicationByID($request->input('application_id'),'employee_id',auth()->guard('employee')->user()->id);

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

    public function unverify_employee()
    {
        if(auth()->guard('employee')->user()['verify'] == 1){
            return redirect('employee/home');
        }
        Session::flash('verify_text','We have send You a verification email to '.(auth()->guard('employee')->user()['email']).' ! <br>  Please check it and verify Your account!');
        Session::flash('resend_text','If you do not recieve the email, Please click ');
        Session::flash('type','success');
        return view('verification');
    }

    public function sendRepeatEmail(Request $request)
    {
        if($request->isMethod('post')){

            $verify_code = auth()->guard('employee')->user()->verify_code;
            $verify_url = url('/').'/Account-Verification/'.$verify_code;

            $data = array();
            $data['verify_url'] = $verify_url;
            $data['email'] = auth()->guard('employee')->user()->email;
            $data['name'] = auth()->guard('employee')->user()->name.' '.auth()->guard('employee')->user()->last_name;
            $obj = new MailController();
            $res = $obj->SendMail($data);

            if($res){
                $request->session()->flash('message', 'Verification email is successfuly sent!');
                $request->session()->flash('typeV', 'success');
            } else {
                $request->session()->flash('message', 'Something went wrong, try later!');
                $request->session()->flash('typeV', 'danger');
            }

            return redirect('/employee/verify-account');

        }
    }

    public function changeEmailAddress(Request $request)
    {
        if($request->isMethod('post')){
            $employee_id = auth()->guard('employee')->user()->id;

            $rules = array('new_email'=>'required|email|unique:employees,email');
            $this->validate($request,$rules);

            try {
                DB::beginTransaction();
                Employee::query()->where('id',$employee_id)->update(['email'=>$request->input('new_email')]);

                $obj = new MailController();
                $arr = array();

                $verify_code = auth()->guard('employee')->user()->verify_code;
                $verify_url = url('/').'/Account-Verification/'.$verify_code;

                $arr['verify_url'] = $verify_url;
                $arr['name'] = auth()->guard('employee')->user()->name.' '.auth()->guard('employee')->user()->last_name;
                $arr['email'] = $request->input('new_email');

                $res = $obj->SendMail($arr);

                if($res){
                    DB::commit();
                    $request->session()->flash('message', 'Your email address is successfuly changed and email is sent to this address!');
                    $request->session()->flash('typeV', 'success');
                    return redirect('/employee/verify-account');
                } else {
                    DB::rollBack();
                }

            } catch (\Exception $e) {

                DB::rollBack();
            }
            $request->session()->flash('message', 'Something went wrong, try later!');
            $request->session()->flash('typeV', 'danger');
            return redirect('/employee/verify-account');


        }
    }

    public function appliedJobs()
    {
        $data = array();
        $data['title'] = 'Applied Jobs';

        //$data['jobs'] = Job::get_jobs_joined_letters_ForEmployee(auth()->guard('employee')->user()->id);

        //$data['relations'] = HelpModel::get_employee_2_jobs_ByEmployeeID(auth()->guard('employee')->user()->id);

        //$data['job_and_applied_dates'] = array();
//        foreach ($data['relations'] as $item){
//            $data['job_and_applied_dates'][$item->job_id] = substr($item->created_at, 0, -8);
//        }
        $data['applications'] = ApplicationLetter::get_applicationsByEmployeeID(auth()->guard('employee')->user()->id);

        return view('employee.applied_jobs',compact('data'));
    }

    public function applyJob($job_id, Request $request)
    {
        if((int)$job_id > 0){

            $data = array();
            $data['job'] = Job::get_jobByID($job_id);

            if($data['job'] && isset($data['job']->id)){

                $employee_id = auth()->guard('employee')->user()->id;
                $if_applied = HelpModel::check_if_applied($job_id,$employee_id);

                if(!$if_applied){

                    if($request->isMethod('post')){
                        $rules = $this->applyRules();
                        $this->validate($request,$rules);

                        if (!Storage::exists('cvs')) {
                            Storage::makeDirectory('cvs', 0777, true);
                            Storage::put('cvs/index.php', '<?php echo "404"; ?>');
                        }
                        try{
                            DB::beginTransaction();

                            HelpModel::add_employee_2_jobs_row($job_id,auth()->guard('employee')->user()->id);
                            ApplicationLetter::apply_job($job_id,auth()->guard('employee')->user()->id,$data['job']->company_id,$request);

                            DB::commit();

                        } catch (\Exception $e){
                            DB::rollBack();

                            $request->session()->flash('message', 'Something went wrong,try later!');
                            $request->session()->flash('type', 'danger');
                            return redirect('/apply-job/'.$job_id);
                        }

                        try{
                            $obj = new MailController();
                            $arr = array();
                            $arr['from_apply'] = true;
                            $arr['email'] = $data['job']->company()->first()->email;
                            $arr['job_title'] = $data['job']->title;
                            $obj->SendMail($arr);

                        } catch (\Exception $e2){
                            //
                        }
                        $request->session()->flash('message', 'You have successfuly applied to this job!');
                        $request->session()->flash('type', 'success');
                        return redirect('/job/'.$job_id);

                    } elseif($request->isMethod('get')){

                        $data['title'] = 'Apply';
                        return view('employee.apply_to_job',compact('data'));

                    } else {
                        return redirect()->back();
                    }
                } else {
                    $request->session()->flash('message', 'You have already applied to this job!');
                    $request->session()->flash('type', 'info');
                    return redirect('/job/'.$job_id);
                }
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function addJobDetail(Request $request)
    {
        if($request->ajax()){

            $resume = Resume::get_resumeByEmployeeID(auth()->guard('employee')->user()->id);

            if(!$resume){
                return \Response::json(array(
                    'error' => 'Firstly You should add Your resume main details!'
                ), 422);
            }

            if($resume->job_details->count() > 4){
                return \Response::json(array(
                    'error' => 'Your job details limit is expired (max 5)!'
                ), 422);
            }

            $rules = $this->jobDetailRules();
            $validator = Validator::make($request->all(), $rules);

            if ($validator->passes()) {

                $result = ResumeJobDetail::add_row($request);

                if($result && isset($result->id)){
                    return response()->json(['id'=>$result->id,'job_title'=>$result->job_title,'date_from'=>$result->date_from,'date_to'=>$result->date_to,'job_description'=>$result->job_description]);
                } else {
                    return \Response::json(array(
                        'error' => 'Something went wrong, try later!'
                    ), 422);
                }

            } else {
                return \Response::json(array(
                    'errors' => $validator->messages()
                ), 422);
            }
        }
    }

    public function editJobDetail(Request $request)
    {
        if($request->ajax()){

            $resume = Resume::get_resumeByEmployeeID(auth()->guard('employee')->user()->id);

            if(!$resume){
                return \Response::json(array(
                    'error' => 'Firstly You should add Your resume main details!'
                ), 422);
            }

            $job_detail = ResumeJobDetail::get_detail((int)$request->input('job_detail_id'),(int)auth()->guard('employee')->user()->id);

            if(!$job_detail){
                return \Response::json(array(
                    'error' => 'Something went wrong, try later!'
                ), 422);
            }

            $rules = $this->jobDetailRules();
            $validator = Validator::make($request->all(), $rules);

            if ($validator->passes()) {

                $result = ResumeJobDetail::update_row($request,$job_detail);

                if($result && isset($result->id)){
                    return response()->json(['id'=>$result->id,'job_title'=>$result->job_title,'date_from'=>$result->date_from,'date_to'=>$result->date_to,'job_description'=>$result->job_description]);
                } else {
                    return \Response::json(array(
                        'error' => 'Something went wrong, try later!'
                    ), 422);
                }
            } else {
                return \Response::json(array(
                    'errors' => $validator->messages()
                ), 422);
            }
        }
    }

    public function deleteJobDetail(Request $request)
    {
        if($request->ajax()){

            $resume = Resume::get_resumeByEmployeeID(auth()->guard('employee')->user()->id);

            if(!$resume){
                return \Response::json(array(
                    'error' => 'Firstly You should add Your resume main details!'
                ), 422);
            }

            $rules = ['job_detail_id' => 'required|numeric|exists:resume_job_details,id'];
            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return \Response::json(array(
                    'errors' => $validator->messages()
                ), 422);
            }

            $job_detail = ResumeJobDetail::get_detail((int)$request->input('job_detail_id'),(int)auth()->guard('employee')->user()->id);

            if(!$job_detail){
                return \Response::json(array(
                    'error' => 'Something went wrong, try later!'
                ), 422);
            }

            $result = ResumeJobDetail::delete_row($job_detail);

            if($result){
                return response()->json(['id'=>$request->input('job_detail_id')]);
            } else {
                return \Response::json(array(
                    'error' => 'Something went wrong, try later!'
                ), 422);
            }
        }
    }


    public function resumeRules()
    {
        return array(
            'country' => 'required|min:2|max:30',
            'city' => 'required|min:2|max:30',
            'address' => 'required|min:2|max:30',
            'phone' => 'required|min:2|max:30',
            'email' => 'required|email|min:2|max:30',
            'web_site' => 'required|min:2|max:30',
            'self_description' => 'required|min:20|max:2000',
            'education_description' => 'required|min:20|max:2000',
            'university_name' => 'required|min:3|max:30',
            'degree' => 'required|min:3|max:30|in:master,bachelor,academic',
//            'job_title' => 'required|min:3|max:30',
//            'job_description' => 'required|min:20|max:2000',
//            'date_from' => 'date|date_format:"Y-m-d"|required',
//            'date_to' => 'date|date_format:"Y-m-d"|required',
            'image' => 'required_without:old_image|image|max:10240|dimensions:min_width=260,min_height=300',
        );
    }

    public function jobDetailRules()
    {
        return array(
            'job_title' => 'required|min:3|max:30',
            'job_description' => 'required|min:20|max:2000',
            'date_from' => 'date|date_format:"Y-m-d"|required',
            'date_to' => 'date|date_format:"Y-m-d"|required',
        );
    }

    public function resume(Request $request)
    {
        if($request->isMethod('post')){
            $rules = $this->resumeRules();
            $messages = array(
                'image.dimensions' => 'Image dimensions should be: min width 260px, min height 300px '
            );
            $this->validate($request,$rules,$messages);

            if (!File::exists('images/resume_images')) {
                File::makeDirectory('images/resume_images', 0777, true);
                File::put('images/resume_images/index.php', '<?php echo "404"; ?>');
            }

            $result = Resume::update_resume($request);
            if($result){
                $request->session()->flash('message', 'Information is updated!');
                $request->session()->flash('type', 'success');

                return redirect('/employee/resume');
            } else {
                $request->session()->flash('message', 'Something went wrong, try later!');
                $request->session()->flash('danger', 'success');
                return redirect('/employee/resume');
            }
        } elseif ($request->isMethod('get')){
            $data = array();
            $data['title'] = 'Resume';
            $data['resume'] = auth()->guard('employee')->user()->resume()->first();

            return view('employee.resume',compact('data'));
        }
    }

    public function profile(Request $request)
    {
        if($request->isMethod('post')){

           // dd($request->all());

            $rules = $this->profileRules();
            $messages = array(
                'image.dimensions' => 'Image dimensions should be: min width 260px, min height 300px '
            );
            $this->validate($request,$rules,$messages);

            if (!File::exists('images/candidates')) {
                File::makeDirectory('images/candidates', 0777, true);
                File::put('images/candidates/index.php', '<?php echo "404"; ?>');
            }
            $result = Employee::update_employee($request);
            if($result){
                $request->session()->flash('message', 'Information is updated!');
                $request->session()->flash('type', 'success');
                return redirect('/employee/profile');
            } else {
                $request->session()->flash('message', 'Something went wrong, try later!');
                $request->session()->flash('danger', 'success');
                return redirect('/employee/profile');
            }

        } elseif ($request->isMethod('get')){
            $data = array();
            $data['title'] = 'Profile';
            $data['regions'] = Region::get_regions();
            $data['categories'] = Category::get_categories();
            $data['types'] = Type::get_types();
            $data['skills'] = Skill::get_skills();
            $data['languages'] = Language::get_languages();
            $data['employee'] = Employee::get_employeeByID(auth()->guard('employee')->user()->id);

            $data['employee_skills'] = $data['employee']->skills->pluck('id')->toArray();
            $data['employee_languages'] = $data['employee']->languages()->get()->pluck('id')->toArray();

            return view('employee.profile',compact('data'));
        }
    }

    public function getInvitations()
    {
        $data = array();
        $data['title'] = 'Invitations';

        $data['invitations'] = InvitationLetter::get_invitations_ForEmployee(auth()->guard('employee')->user()->id);

        return view('employee.invitations',compact('data'));
    }

    public function lookInvitation($id)
    {
        $data = array();
        $data['title'] = 'Look Invitation';
        $data['invitation'] = InvitationLetter::get_invitation($id,'employee_id',auth()->guard('employee')->user()->id);
        if($data['invitation'] && isset($data['invitation']->id)){

            return view('employee.look_invitation',compact('data'));
        } else {
            return redirect()->back();
        }
    }


// validation rules functions -------------------------start
    public function profileRules()
    {
        return array(
            'name' => 'required|min:3|max:30',
            'last_name' => 'required|min:3|max:30',
            'date_of_birth' => 'date|date_format:"Y-m-d"|required',
            'title' => 'required|min:3|max:30',
            'address' => 'required|min:3|max:40',
            'phone' => 'required|min:3|max:20',
            'category' => 'required|numeric|exists:categories,id',
            'region' => 'required|numeric|exists:regions,id',
            'type' => 'required|numeric|exists:types,id',
            'image' => 'required_without:old_image|image|max:10240|dimensions:min_width=260,min_height=300',
            'description' => 'required|min:3|max:1200',
            "skills" => 'required|array',
            "skills.*" => 'required|numeric|distinct|exists:skills,id',
            "languages" => 'required|array',
            "languages.*" => 'required|numeric|distinct|exists:languages,id',
        );
    }

    public function applyRules($from_edit = false)
    {
        $rules = array(
            'apply_letter' => 'required|min:3|max:1200',
            'excepted_salary' => 'required|numeric'
        );
        if(!$from_edit){
            $rules['uploaded_cv'] = 'file|max:10000|mimes:pdf';
        }
        return $rules;
//        return array(
//            'apply_letter' => 'required|min:3|max:1200',
//            'excepted_salary' => 'required|numeric',
//            'uploaded_cv'=> 'file|max:10000|mimes:pdf'
//        );
    }



    public function portfolioRules($from_edit = false)
    {
        $req = 'required';
        if($from_edit){
            $req = 'required_without:old_image';
        }
        return array(
            'title' => 'required|min:4|max:30',
            'description' => 'required|min:10|max:1200',
            'image' => $req.'|image|max:10240|dimensions:min_width=370,min_height=250',
        );
    }
// validation rules functions -------------------------end



}
