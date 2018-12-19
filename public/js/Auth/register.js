$(document).ready(function() {
    $('.checkbox_term').change(function() {
        if($('.checkbox_term').is(":checked")){
            $('.sign_up_employee').attr('disabled',false);
        }else{
            $('.sign_up_employee').attr('disabled',true);
        }
    });

    $(".sign_up_employee").click(function(e){
        e.preventDefault();
        $('.form-control').css('border-color','#ccc');
        $('.help-block strong').html('');
        var _token = $("#employee_reg_form input[name='_token']").val();
        var name = $("#employee_reg_form input[name='name']").val();
        var last_name = $("#employee_reg_form input[name='last_name']").val();
        var email = $("#employee_reg_form input[name='email']").val();
        var term_of  = $("#employee_reg_form input[name='term_of ']").val();
        var phone = $("#employee_reg_form input[name='phone']").val();
        var employee_password = $("#employee_reg_form input[name='employee_password']").val();
        var retype_password = $("#employee_reg_form input[name='retype_password']").val();

        var submit_btn = $(this);
        var spinner = $('.employee_spinner');

        $.ajax({
            url: "/employee/register",
            type:'POST',
            data: {_token:_token, name:name, last_name:last_name, email:email, phone:phone, term_of:term_of, employee_password:employee_password, retype_password:retype_password},
            beforeSend: function () {
                $('.employee_failed_span').text('');
                submit_btn.prop('disabled',true);
            },
            success: function(data) {
                $('.employee_failed_span').text('');
                window.location.href = "/employee/home";
            },
            error:function (response) {
                $('.employee_failed_span').text('');
                $.each(response.responseJSON.errors, function (index, value) {
                    $('.'+ index).text(value[0]);
                    $('.'+ index+'_input').css('border-color','red');
                });
                if (response.responseJSON.error) {
                    $('.employee_failed_span').text(response.responseJSON.error);
                }
                submit_btn.prop('disabled',false);
                spinner.hide();
            }
        });

    });

});
$(document).ready(function() {
    $('.checkbox_terms_company').change(function() {
        if($('.checkbox_terms_company').is(":checked")){
            $('.sign_up_company').attr('disabled',false);
        }else{
            $('.sign_up_company').attr('disabled',true);
        }
    });
    $(".sign_up_company").click(function(e){
        e.preventDefault();
        $('.form-control').css('border-color','#ccc');
        $('.help-block strong').html('');
        var _token = $("#company_regitration input[name='_token']").val();
        var company_name = $("#company_regitration input[name='company_name']").val();
        var contact_person_name = $("#company_regitration input[name='contact_person_name']").val();
        var phone_number_company = $("#company_regitration input[name='phone_number_company']").val();
        var tax_number = $("#company_regitration input[name='tax_number']").val();
        var email_company = $("#company_regitration input[name='email_company']").val();
        var company_password = $("#company_regitration input[name='company_password']").val();
        var retype_password_company = $("#company_regitration input[name='retype_password_company']").val();

        var submit_btn = $(this);
        var spinner = $('.company_spinner');

        $.ajax({
            url: "/company/register",
            type:'POST',
            data: {_token:_token, company_name:company_name, contact_person_name:contact_person_name, email_company:email_company, tax_number:tax_number,phone_number_company:phone_number_company,company_password:company_password, retype_password_company:retype_password_company},
            beforeSend: function () {
                $('.company_failed_span').text('');
                submit_btn.prop('disabled',true);
                spinner.show();
            },
            success: function(data) {
                $('.company_failed_span').text('');
                window.location.href = "/company/home";
            },
            error:function (response) {
                $('.company_failed_span').text('');
                $.each(response.responseJSON.errors, function (index, value) {
                    $('.'+ index).text(value[0]);
                    $('.'+ index+'_input').css('border-color','red');
                });
                if (response.responseJSON.error) {
                    $('.company_failed_span').text(response.responseJSON.error);
                }
                submit_btn.prop('disabled',false);
                spinner.hide();
            }
        });
    });
});