$(function() {

	var form =  $('#contact-form');
	// Get the messages div.
	var formMessages = $('.form-messege');

	var submit_btn = form.find('button');
	var spinner = $('.contact_spinner');

	// Set up an event listener for the contact form.
   form.submit(function(e) {
		// Stop the browser from submitting the form.
		e.preventDefault();

		var name = $('#contact-form input[name="name"]').val();
		var email = $('#contact-form input[name="email"]').val();
		var message = $('#contact-form textarea[name="message"]').val();
		var token = $('#contact-form input[name="_token"]').val();

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			//url: $(form).attr('action'),
			url: '/contact',
			data: {name: name, email: email, message: message, _token : token},
            beforeSend: function () {
                $('#contact-form .name').text('');
                $('#contact-form .email').text('');
                $('#contact-form .message').text('');
                submit_btn.prop('disabled',true);
                spinner.show();
            },
			success: function(response) {
                // Make sure that the formMessages div has the 'success' class.
                $(formMessages).removeClass('val_error');
                $(formMessages).addClass('val_success');

                // Set the message text.
                $(formMessages).text(response.message);

                // Clear the form.
                $('#contact-form input,#contact-form textarea').not('#contact-form input[name="_token"]').val('');
                $('#contact-form .val_error').text('');
                submit_btn.prop('disabled',false);
                spinner.hide();
            },
			error: function(data) {
				if(data.responseJSON != undefined){
                    $('#contact-form .name').text('');
                    $('#contact-form .email').text('');
                    $('#contact-form .message').text('');

					$.each(data.responseJSON.errors, function (index, value) {
                        $('#contact-form' + ' ' + '.'+ index).text(value[0]);
                    });
                    submit_btn.prop('disabled',false);
                    spinner.hide();
				}
                // Make sure that the formMessages div has the 'error' class.
                $(formMessages).removeClass('val_success');
                $(formMessages).addClass('val_error');
                $(formMessages).text('');

                // Set the message text.
                if (data.responseJSON.error) {
                    $(formMessages).text(data.responseJSON.error);
                }
                submit_btn.prop('disabled',false);
            }
		})

	});

});
