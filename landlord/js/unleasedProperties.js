$(document).ready(function () {
	$('#unleasedProperties').dataTable({
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
		"order": [ 0, 'asc' ],
		"pageLength": 25
	});
	
	$('#unleasedProperties_wrapper').addClass('pb-20');
	$('#unleasedProperties').addClass('pb-10');
});