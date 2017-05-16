$(document).ready(function() {
	
	$('.changeQuantity').change(function() {
		$.ajax({
			method: 'POST',
			url: '/basket/' + $(this).data('hash'),
			data: {
				_token: $(this).data('token'),
				_method: 'PATCH',
				quantity: $(this).val()
			},
			success: function(data) {
				if (data == 'success')
					location.reload();
				else
					swal('Error', 'Oops ! Something went wrong :(');
			}
		});
	});
});
