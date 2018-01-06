$(document).ready(function () {
	$('#leasedProperties').dataTable({
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
		"order": [ 7, 'asc' ],
		"pageLength": 25
	});
	
	$('#leasedProperties_wrapper').addClass('pb-20');
	$('#leasedProperties').addClass('pb-10');
});