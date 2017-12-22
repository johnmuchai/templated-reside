$(document).ready(function() {
	
	/** ******************************
    * Data Tables
    ****************************** **/
	$('#rpt').dataTable({
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
		"order": [[ 3, 'desc' ], [ 1, 'asc' ], [ 6, 'desc' ]],
		"pageLength": 50
	});
	
	$('#rpt_wrapper').addClass('pb-20');
	$('#rpt').addClass('pb-10');

});