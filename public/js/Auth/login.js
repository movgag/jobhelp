$(document).ready(function() {

    $(".login_employee_button").click(function(e){
        e.preventDefault();
        $('.form-control').css('border-color','#ccc');
        $('.help-block strong').html('');
        var _token = $("input[name='_token']").val();
        var email = $("input#emp_email").val();
        var password = $("input#emp_password").val();
        var remember = $("input[name='emp_remember']").length;

        var submit_btn = $(this);
        var spinner = $('.employee_login_spinner');

        $.ajax({
            url: "/employee/login",
            type:'POST',
            data: {_token:_token, email:email, password:password, remember:remember},
            beforeSend: function () {
                submit_btn.prop('disabled',true);
                spinner.show();
            },
            success: function(data) {
                window.location.href = "/employee/home";
            },
            error:function (response) {
                $('.emp_login_err strong').html('These credentials do not match our records');
                $('#emp_email').css('border-color','red');
                $('#emp_password').css('border-color','red');
                submit_btn.prop('disabled',false);
                spinner.hide();
            }
        });

    });
    $(".login_company_button").click(function(e){
        e.preventDefault();
        $('.form-control').css('border-color','#ccc');
        $('.help-block strong').html('');
        var _token = $("input[name='_token']").val();
        var email = $("input[name='email_comp']").val();
        var password = $("input[name='password_comp']").val();
        var remember = $("input[name='comp_remember']").length;

        var submit_btn = $(this);
        var spinner = $('.company_login_spinner');

        $.ajax({
            url: "/company/login",
            type:'POST',
            data: {_token:_token, email:email, password:password, remember:remember},
            beforeSend: function () {
                submit_btn.prop('disabled',true);
                spinner.show();
            },
            success: function(data) {
                window.location.href = "/company/home";
            },
            error:function (response) {
                $('.comp_login_err strong').html('These credentials do not match our records');
                $('#comp_email').css('border-color','red');
                $('#comp_password').css('border-color','red');
                submit_btn.prop('disabled',false);
                spinner.hide();
            }
        });

    });

});