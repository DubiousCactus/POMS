$(document).ready(function() {
	
	$('.add-basket').click(function() {
		
		var itemId = $(this).data('id');
		
		if ($(this).data('ispizza')) {
			
			var firstIsChecked = false;
			var htmlContent = '<strong>Size:</strong><br><br>';

			JSON.parse(sizes).forEach(function(value) {
				htmlContent += '<input type="radio" class="sizeChoice" name="sizeChoice" value="' + value.id + '"';
				
				if (!firstIsChecked) {
					htmlContent += ' checked';
					firstIsChecked = true;
				}
					
				htmlContent += '>' + value.name + '<br>';
			});

			htmlContent += '<br><br><strong>Toppings:</strong><br><br>';

			JSON.parse(toppings).forEach(function(value) {
				htmlContent += '<input type="checkbox" name="toppings" value="' + value.id + '">' + value.name + ' <strong>(' + value.price + ' Kr.)</strong><br>';
			});

			swal({
				title: 'Add toppings',
				html: htmlContent,
				customClass: 'add-basket-modal',
				showCloseButton: true,
				showCancelButton: true,
				confirmButtonText: 'Add to basket'
			}).then(function () {
				var selectedToppings = [];
		
				$('input[type=checkbox]:checked').each(function(key, value) {
					selectedToppings.push($(value).val());
				});

				$.ajax({
					method: 'POST',
					url: '/basket/',
					data: {
						_token: token,
						item: itemId,
						size: $('.sizeChoice:checked').val(),
						toppings: selectedToppings
					},
					success: function(success) {
						if (success == 'success') {
							location.reload();
						} else {
							swal('Error', 'Sorry, something went wrong :(');
						}
					}
				});

			});
		} else {
			$.ajax({
				method: 'POST',
				url: '/basket/',
				data: {
					_token: token,
					item: itemId
				},
				success: function(success) {
					if (success == 'success') {
						location.reload();
					} else {
						swal('Error', 'Sorry, something went wrong :(');
					}
				}
			});

		}

	});

});
