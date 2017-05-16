$(document).ready(function() {

	$('input[name=choice]').click(function() {

		if ($(this).val() == 'delivery') {

			$('#delivery-form').removeClass('disabled');

			$('input[name=address]').each(function(key, value) {
				$(value).removeAttr('disabled');
			});
			
			if ($('#new-address').prop('checked')) {
				$('input[type=text]').each(function(key, value) {
					$(value).removeAttr('disabled');
				});
			}
		
		} else {

			$('#delivery-form').addClass('disabled');
			$('input[type=text]').each(function(key, value) {
				$(value).prop('disabled', true);
			});

			$('input[name=address]').each(function(key, value) {
				$(value).prop('disabled', true);
			});

		}

	});

	$('input[name=address]').click(function() {

		if ($(this).val() == 'new') {

			$('#address-form').removeClass('disabled');
			$('input[type=text]').each(function(key, value) {
				$(value).removeAttr('disabled');
			});

		} else {

			$('#address-form').addClass('disabled');
			$('input[type=text]').each(function(key, value) {
				$(value).prop('disabled', true);
			});

		}

	});

});
