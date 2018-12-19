<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    \Illuminate\Support\Facades\Auth::routes();

    Route::get('/test','HomeController@test'); // for testing

    Route::get('/','HomeController@home')->name('home');

    Route::get('/companies','HomeController@companies')->name('comp');

    Route::get('/termOfUse','HomeController@terms')->name('terms');

    Route::get('/privacy','HomeController@privacy')->name('privacy');

    Route::match(['get','post'],'/contact','HomeController@contact')->name('contact');

    Route::get('/job-board','HomeController@jobBoard')->name('board');
    Route::get('/all-jobs','HomeController@allJobs')->name('all.jobs');
    Route::get('/all-candidates','HomeController@allCandidates')->name('all.candidates');
    Route::get('/all-companies','HomeController@allCompanies')->name('all.companies');
    Route::get('/candidates', 'HomeController@candidates')->name('candidates');

    Route::get('/candidate/{id}','HomeController@singleCandidate')->where('id', '[0-9]+')->name('single.candidate');
    Route::get('/company/{id}','HomeController@singleCompany')->where('id', '[0-9]+')->name('single.company');
    Route::get('/job/{id}','HomeController@singleJob')->where('id', '[0-9]+')->name('single.job');
    Route::get('/portfolio/{id}','HomeController@singlePortfolio')->where('id', '[0-9]+')->name('single.portfolio');

    Route::get('/Account-Verification/{verify}', 'VerificationController@Verification');


Route::group(['prefix' => 'employee'], function () {

    Route::post('/login', 'EmployeeAuth\LoginController@login');
    Route::post('/logout', 'EmployeeAuth\LoginController@logout')->name('logout');
    Route::post('/register', 'EmployeeAuth\RegisterController@register_employee');
    Route::post('/password/email', 'EmployeeAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'EmployeeAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'EmployeeAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'EmployeeAuth\ResetPasswordController@showResetForm');

});

Route::group(['prefix' => 'company'], function () {

    Route::post('/login', 'CompanyAuth\LoginController@login');
    Route::post('/logout', 'CompanyAuth\LoginController@logout')->name('logout');
    Route::post('/register', 'CompanyAuth\RegisterController@register_company');
    Route::post('/password/email', 'CompanyAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'CompanyAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'CompanyAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'CompanyAuth\ResetPasswordController@showResetForm');
});

Route::get('/pd-admin', 'AdminAuth\LoginController@showLoginForm');

Route::group(['prefix' => 'admin'], function () {

    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

    /*  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
      Route::post('/register', 'AdminAuth\RegisterController@register');*/

//    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
//    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
//    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
//    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});


// rewriting login, logout and register routes for get request and logout post route -------start
Route::get('/login',function (){
    if(auth()->guard('employee')->user()){
        return redirect('/employee/home');
    } elseif(auth()->guard('company')->user()) {
        return redirect('/company/home');
    } elseif (auth()->guard('admin')->user()){
        return redirect('/admin/home');
    } else {
        \Illuminate\Support\Facades\Session::flash('message','Please sign in to use our services!');
        \Illuminate\Support\Facades\Session::flash('type','info');
        return redirect('/');
    }
})->name('login');

Route::get('/register',function (){
    if(auth()->guard('employee')->user()){
        return redirect('/employee/home');
    } elseif(auth()->guard('company')->user()) {
        return redirect('/company/home');
    } elseif (auth()->guard('admin')->user()){
        return redirect('/admin/home');
    } else {
        return redirect('/');
    }
});

Route::post('/logout', function (){
    if(auth()->guard('employee')->user()){
        auth()->guard('employee')->logout();
    } elseif(auth()->guard('company')->user()) {
        auth()->guard('company')->logout();
    } elseif (auth()->guard('admin')->user()){
        auth()->guard('admin')->logout();
    } else {
        return redirect('/');
    }
    return redirect('/');
});
// rewriting login and register routes for get request -------end

// testing paypal ------------------------------start

Route::get('/paypal', function (){
    die;
    return view('test');
});

Route::get('/single_payment',function (\Illuminate\Http\Request $request){
    die;
    dd($request->all());
});

Route::get('/paypal-test','HomeController@paypalTest');

// testing paypal -------------------------------end