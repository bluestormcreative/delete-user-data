jQuery(document).ready(function($){

	$('#dud_delete_user_meta_form').submit(function() {

		$('.spinner').addClass('is-active');
		$('#dud_delete_user_meta_submit').attr('disabled', true);
		
		var dataString = $(this).serialize();

		data = {
			action: 'dud_success',
			dud_nonce: dud_vars.dud_nonce,
			entries: dataString
		};

		$.post(ajaxurl, data, function(response) {
			$('#submit-message').html(response);
			$('#dud_delete_user_meta_form').hide();
			$('.spinner').removeClass('is-active');
			$('#dud_delete_user_meta_submit').attr('disabled', false);
		});

		return false;
	});
});