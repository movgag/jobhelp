<?php

/*Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('employee')->user();

    //dd($users);

    return view('employee.home');
})->name('home');*/
Route::get('/verify-account','EmployeeController@unverify_employee');

Route::post('/send-repeat-mail','EmployeeController@sendRepeatEmail');

Route::post('/change-email-address','EmployeeController@changeEmailAddress');

Route::middleware(['unverify'])->group(function (){

    Route::get('/home', 'EmployeeController@EmployeeAcountRedirect');

    Route::get('/applied-jobs', 'EmployeeController@appliedJobs');

    Route::get('/portfolios', 'EmployeeController@portfolios');

    Route::get('/notifications', 'EmployeeController@getNotifications');

    Route::get('/invitations', 'EmployeeController@getInvitations');

    Route::get('/look-invitation/{id}', 'EmployeeController@lookInvitation')->where('id', '[0-9]+');

    Route::match(['get','post'],'/apply-job/{id}','EmployeeController@applyJob')->where('id', '[0-9]+');

    Route::match(['get','post'],'/profile','EmployeeController@profile');

    Route::match(['get','post'],'/resume','EmployeeController@resume');

    Route::match(['get','post'],'/add-portfolio','EmployeeController@addPortfolio');

    Route::match(['get','post'],'/edit-portfolio/{portfolio_id}','EmployeeController@editPortfolio')->where('portfolio_id','[0-9]+');

    Route::post('/delete-portfolio','EmployeeController@deletePortfolio');

    Route::match(['get','post'],'/edit-application/{letter_id}','EmployeeController@editApplication')->where('letter_id','[0-9]+');

    Route::post('/download-cv','EmployeeController@downloadCv');

    Route::get('/remove-app-notification/{ntf_id}','EmployeeController@removeApplicationNotification')->where('ntf_id','[0-9]+');

    Route::get('/remove-inv-notification/{ntf_id}','EmployeeController@removeInvitationNotification')->where('ntf_id','[0-9]+');


    Route::post('/add-job-detail','EmployeeController@addJobDetail');
    Route::post('/edit-job-detail','EmployeeController@editJobDetail');
    Route::post('/delete-job-detail','EmployeeController@deleteJobDetail');


});

