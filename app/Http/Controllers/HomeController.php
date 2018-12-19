<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use App\HelpModel;
use App\Models\ApplicationLetter;
use App\Models\Category;
use App\Models\InvitationLetter;
use App\Models\Job;
use App\Models\PortfoliosEmployee;
use App\Models\Region;
use App\Models\Resume;
use App\Models\Skill;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $auth_user_exists = true;
            if(!auth()->guard('company')->user() && !auth()->guard('employee')->user() && !auth()->guard('admin')->user()){
                $auth_user_exists = false;
            }
            view()->share('auth_user_exists',$auth_user_exists);

            return $next($request);
        });
    }
    public function test()
    {
       return view('test');
    }

    public function home()
    {
        $data = array();
        $data['title'] = 'Home || JobHelp';
        $data['jobs'] = Job::get_jobs(5,'closing_date','asc');

        $data['jobs_count'] = Job::get_jobs_count();
        $data['employees_count'] = Employee::get_employees_count();
        $data['companies_count'] = Company::get_companies_count();
        $data['resumes_count'] = Resume::get_resumes_count();

        return view('home',compact('data'));
    }

    public function allJobs()
    {
        $data = array();
        $data['title'] = 'All Jobs';

        $data['jobs'] = Job::get_all_jobs(4,'closing_date','asc');

        return view('all_jobs',compact('data'));
    }

    public function allCandidates()
    {
        $data = array();
        $data['title'] = 'All Candidates';

        $data['employees'] = Employee::get_all_candidates(4,'created_at','desc');

        return view('all_candidates',compact('data'));
    }

    public function allCompanies()
    {
        $data = array();
        $data['title'] = 'All Comapnies';

        $data['companies'] = Company::get_all_companies(4,'created_at','desc');

        return view('all_companies',compact('data'));
    }

    public function contact(Request $request)
    {
        if($request->isMethod('post')){
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required|min:6|max:300',
            ];
            $validator = Validator::make($request->all(),$rules);

            if($validator->fails()){
                return \Response::json(array(
                    'errors' => $validator->messages()
                ), 422);
            }
            $data = array();
            $data['name'] = $request->input('name');
            $data['sender_email'] = $request->input('email');
            $data['message'] = $request->input('message');
            $data['from_contact'] = 'yes';

            $obj = new MailController();
            $res = $obj->SendMail($data);
            if($res){
                return response()->json(['message'=>'Your message is successfuly sent!']);
            } else {
                return \Response::json(array('error'=>'Something went wrong, try later!'),422);
            }
        } elseif($request->isMethod('get')) {
            $data = array();
            $data['title'] = 'Contact';
            $data['nav_active'] = 'contact';
            return view('contact',compact('data'));
        }

    }

    public function jobBoard(Request $request)
    {
        $data = array();
        $data['title'] = 'Job Board';
        $data['nav_active'] = 'job_board';

        $data['types'] = Type::get_types();
        $data['regions'] = Region::get_regions();
        $data['categories'] = Category::get_categories();
        $data['skills'] = Skill::get_skills();

        $data['jobs'] = Job::get_jobs(10,'closing_date','asc');

        $data['active_type'] = 0;
        $data['active_region'] = 0;
        $data['active_category'] = 0;
        $data['active_skill'] = 0;

        if($request->has('type') || $request->has('region') || $request->has('category') || $request->has('skill')){
            $data['from_search'] = 'yes';
            $data['active_type'] = (int)$request->input('type');
            $data['active_region'] = (int)$request->input('region');
            $data['active_category'] = (int)$request->input('category');
            $data['active_skill'] = (int)$request->input('skill');
            $data['jobs'] = Job::search_jobs(1,$data['active_type'],$data['active_region'],$data['active_category'],$data['active_skill']);
        }

        return view('job_board',compact('data'));
    }

    public function candidates(Request $request)
    {
        $data = array();
        $data['title'] = 'Candidates';
        $data['nav_active'] = 'candidates';

        $data['types'] = Type::get_types();
        $data['regions'] = Region::get_regions();
        $data['categories'] = Category::get_categories();
        $data['skills'] = Skill::get_skills();

        $data['employees'] = Employee::get_random_employees(10);

        $data['active_type'] = 0;
        $data['active_region'] = 0;
        $data['active_category'] = 0;
        $data['active_skill'] = 0;

        if($request->has('type') || $request->has('region') || $request->has('category') || $request->has('skill')){
            $data['from_search'] = 'yes';
            $data['active_type'] = (int)$request->input('type');
            $data['active_region'] = (int)$request->input('region');
            $data['active_category'] = (int)$request->input('category');
            $data['active_skill'] = (int)$request->input('skill');

            $data['employees'] = Employee::search_employees(1, $data['active_type'],$data['active_region'], $data['active_category'], $data['active_skill'] );
        }

        return view('candidates',compact('data'));
    }

    public function singleCandidate($id)
    {
        $data = array();
        $data['title'] = 'Candidate';
        $data['nav_active'] = 'candidates';

        $data['employee'] = Employee::get_employeeByID((int)$id);

        if($data['employee'] && isset($data['employee']->id)){

            $data['portfolios'] = PortfoliosEmployee::get_portfoliosByEmployeeID($id,2);

            if(auth()->guard('company')->user() && isset(auth()->guard('company')->user()->id) && (int)auth()->guard('company')->user()->id > 0){
                $data['auth_company'] = true;
                $data['jobs'] = Job::get_jobs_by_companyID(auth()->guard('company')->user()->id);
                $data['invited_job_ids'] = InvitationLetter::get_invited_job_ids_ForEmployee($id,auth()->guard('company')->user()->id);
            }

            return view('single_candidate',compact('data'));
        } else {
            return redirect()->back();
        }
    }

    public function singlePortfolio($id)
    {
        $data = array();
        $data['title'] = 'Portfolio';
        $data['portfolio'] = PortfoliosEmployee::get_portfolioByID((int)$id);

        if($data['portfolio'] && isset($data['portfolio']->id)){

            $data['portfolios'] = PortfoliosEmployee::get_random_portfolios(8);

            return view('single_portfolio',compact('data'));

        } else {
            return redirect()->back();
        }
    }

    public function singleCompany($id)
    {
        $data = array();
        $data['title'] = 'Company';
        $data['nav_active'] = 'companies';

        $data['company'] = Company::get_companyByID((int)$id);
        $data['jobs'] = Job::get_jobs_by_companyID((int)$id,3);

        if($data['company'] && isset($data['company']->id)){
            return view('single_company',compact('data'));
        } else {
            return redirect()->back();
        }
    }

    public function singleJob($id)
    {
        $data = array();
        $data['title'] = 'Job';
        $data['nav_active'] = 'job_board';

        $data['job'] = Job::get_jobByID($id);
        if($data['job'] && isset($data['job']->id)){

            if(auth()->guard('employee')->user()){
                if(HelpModel::check_if_applied($id,auth()->guard('employee')->user()->id)){
                    $letter = ApplicationLetter::get_application(auth()->guard('employee')->user()->id,$id,$data['job']->company()->first()->id);
                    if($letter && isset($letter->id)){
                        $data['letter'] = $letter;
                    }
                }
            }
            return view('single_job',compact('data'));
        } else {
            return redirect()->back();
        }

    }

    public function companies(Request $request)
    {
        $data = array();
        $data['title'] = 'Companies';
        $data['nav_active'] = 'companies';

        $data['types'] = Type::get_types();
        $data['regions'] = Region::get_regions();
        $data['categories'] = Category::get_categories();

        $data['companies'] = Company::get_random_companies(10);

        $data['active_region'] = 0;
        $data['active_category'] = 0;

        if($request->has('region') || $request->has('category')){
            $data['from_search'] = 'yes';
            $data['active_region'] = (int)$request->input('region');
            $data['active_category'] = (int)$request->input('category');
            $data['companies'] = Company::search_companies(1, $request->input('region'), $request->input('category'));
        }

        return view('companies',compact('data'));
    }

    public function terms()
    {
        $data = array();
        $data['title'] = 'Terms';
        return view('term_of_use',compact('data'));
    }

    public function privacy()
    {
        $data = array();
        $data['title'] = 'Privacy';
        return view('privacy',compact('data'));
    }




// paypal test functions ------------ start
    public function paypalTest()
    {
        die;
        require public_path('/PayPal-PHP-SDK/autoload.php');

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'ASp7iG0CxNifVAhrfETKSJcZhRHjPRAiWhqwmOz73mjKCoG00uXqE-QT_r9kd705PT-8nzyH0F8p5s0a',     // ClientID
                'ENa1Ky4k4YdeyTd1xXjE11aKQhb-wvyVv5d0ItVzvqbMzW_HjNysZ7Q9toqeefm72QOhLMJSjSJO9SLP'      // ClientSecret
            )
        );
        dd($apiContext);
    }
// paypal test functions ------------ start




}
