$(document).ready(function() {
	// Image Slider System options
	$("#enableSlider").change(function() {
		if ($('#enableSlider').val() !== '1') {
			// Hide if Disabled
			$('#sliderSystem').slideUp('slow');
		} else {
			// Show if Enabled
			$('#sliderNote').html('Save the Slider Carousel Settings to view more options.');
		}
	});

	// Hide Image Slider options on Page Load if not Enabled
	if ($("#enableSlider").val() !== '1') {
		$('#sliderSystem').hide();
	}
});