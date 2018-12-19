<?php

/*Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('company')->user();

    //dd($users);

    return view('company.home');
})->name('home');*/
Route::get('/verify-company-account','CompanyController@unverify_company');

Route::post('/send-repeat-mail','CompanyController@sendRepeatEmail');

Route::post('/change-email-address','CompanyController@changeEmailAddress');

Route::middleware(['unverifycompany'])->group(function (){

    Route::get('/home', 'CompanyController@CompanyAcountRedirect');

    Route::get('/jobs', 'CompanyController@getJobs');

    Route::get('/invitations', 'CompanyController@getInvitations');

    Route::get('/applicants/{job_id}', 'CompanyController@getApplicants')->where('job_id', '[0-9]+');

    Route::match(['get','post'],'/profile','CompanyController@profile');


    Route::middleware(['verify_from_admin'])->group(function (){

        Route::match(['get','post'],'/add-job','CompanyController@addJob');

        Route::match(['get','post'],'/edit-job/{id}','CompanyController@editJob')->where('id', '[0-9]+');

        Route::match(['get','post'],'/edit-invitation/{id}','CompanyController@editInvitation')->where('id', '[0-9]+');

        Route::match(['get','post'],'/application-letter/{employee_id}/{job_id}','CompanyController@applicationLetter')
            ->where('employee_id', '[0-9]+')
            ->where('job_id', '[0-9]+');

        Route::post('/download-cv','CompanyController@downloadCv');

        Route::post('/send-invitation','CompanyController@sendInvitation');

        Route::get('/look-resume/{employee_id}','CompanyController@lookResume')->where('employee_id', '[0-9]+');

    });


});




