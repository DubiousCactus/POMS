$(document).ready(function() {
	
	$('#add-basket').click(function() {
		
		if ($(this).data('ispizza')) {
			
			var itemId = $(this).data('id');
			var htmlContent = '<strong>Size:</strong><br><br>'
				+ '<input type="radio" name="size" value="0" checked>Normal&nbsp;&nbsp;&nbsp;&nbsp;'
				+ '<input type="radio" name="size" value="1">Family<br><br><br>'
				+ '<strong>Toppings:</strong><br><br>';

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

				console.log(selectedToppings);

				$.ajax({
					method: 'POST',
					url: '/basket/',
					data: {
						_token: token,
						item: 21,
						size: $('input[type=radio]:checked').val(),
						toppings: selectedToppings
					},
					success: function(success) {
						console.log(success);
					}
				});

			});
		} else {
			//just ajax to basket and reload ?
		}

	});

});
