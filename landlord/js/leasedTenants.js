$(document).ready(function () {

	/** ******************************
    * Data Tables
    ****************************** **/
	$('#leasedTenants').dataTable({
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": {
			"sSwfPath": "js/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				"copy",
				"csv",
				"pdf",
				"print"
			]
		},
		"order": [[ 5, 'asc' ], [ 2, 'desc' ]],
		"pageLength": 25
	});
	
	$('#leasedTenants_wrapper').addClass('pb-20');
	$('#leasedTenants').addClass('pb-10');

});