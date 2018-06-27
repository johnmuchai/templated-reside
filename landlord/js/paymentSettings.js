$(document).ready(function() {
	// Set the Currency Code Select Option
	var currCodeVal	= $("#currCodeVal").val();
	$("select#currencyCode option").each(function() { this.selected = (this.text == currCodeVal); });

	// Image Slider System options
	$("#enablePayments").change(function() {
		if ($('#enablePayments').val() !== '1') {
			// Hide if Disabled
			$('#paymentSystem').slideUp('slow');
		} else {
			// Show if Enabled
			$('#notes').html('Save the Payment Settings to view more options.');
		}
	});

	// Hide Image Slider options on Page Load if not Enabled
	if ($("#enablePayments").val() !== '1') {
		$('#paymentSystem').hide();
	}
	
	// PayPal/Payment System options
	$("#enablePaypal").change(function() {
		if ($('#enablePaypal').val() !== '1') {
			// Hide if Disabled
			$('#paypalSystem').slideUp('slow');
		} else {
			// Show if Enabled
			$('#paypalSystem').slideDown('slow');
		}
	});

	// Hide PayPal options on Page Load if not Enabled
	if ($("#enablePaypal").val() !== '1') {
		$('#paypalSystem').hide();
	}
});