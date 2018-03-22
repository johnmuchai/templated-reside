$(document).ready(function () {

	/** ******************************
    * Data Tables
    ****************************** **/
	$('#servPriority').dataTable({
		"order": [ 1, 'desc' ],
		"paging": false,		// Disable Pagination
		"searching": false,		// Disable Search
		"bInfo": false			// Disable "Showing x to x of x entries"
	});
	
	$('#servPriority_wrapper').addClass('pt-0 pb-20');
	
	$('#servStatus').dataTable({
		"order": [ 1, 'desc' ],
		"paging": false,		// Disable Pagination
		"searching": false,		// Disable Search
		"bInfo": false			// Disable "Showing x to x of x entries"
	});
	
	$('#servStatus_wrapper').addClass('pt-0 pb-20');

});