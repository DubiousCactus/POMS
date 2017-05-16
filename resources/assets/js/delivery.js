$(document).ready(function() {

	$('input[name=choice]').click(function() {

		if ($(this).val() == 'delivery') {

			$('#delivery-form').removeClass('disabled');
			$('input[type=text]').each(function(key, value) {
				$(value).removeAttr('disabled');
			});
		
		} else {

			$('#delivery-form').addClass('disabled');
			$('input[type=text]').each(function(key, value) {
				$(value).prop('disabled', true);
			});

		}

	});

});
