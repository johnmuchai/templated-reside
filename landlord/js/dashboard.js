$(document).ready(function () {

	/** ******************************
    * Data Tables
    ****************************** **/
		$('#lateRent').dataTable({
			"paging": true,		// Disable Pagination
			"searching": true,		// Disable Search
			"bInfo": true			// Disable "Showing x to x of x entries"
		});

		$('#overdueRent').dataTable({
			"paging": true,		// Disable Pagination
			"searching": true,		// Disable Search
			"bInfo": true			// Disable "Showing x to x of x entries"
		});

		$('#lateRent_wrapper').addClass('pt-0 pb-20');

		$('#availProp').dataTable({
			"paging": true,		// Disable Pagination
			"searching": true,		// Disable Search
			"bInfo": true			// Disable "Showing x to x of x entries"
		});

		$('#availProp_wrapper').addClass('pt-0 pb-20');

		$('#rentReceived').dataTable({
			"columnDefs": [{
				"orderable": false, "targets": 7
			}],
			"paging": true,		// Disable Pagination
			"searching": true,		// Disable Search
			"bInfo": true			// Disable "Showing x to x of x entries"
		});

		$('#rentReceived_wrapper').addClass('pt-0 pb-20');

});
