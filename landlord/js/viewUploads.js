$(document).ready(function () {
	$('#uploads').dataTable({
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
		"order": [ 3, 'desc' ],
		"pageLength": 10
	});
	
	$('#uploads_wrapper').addClass('pb-20');
	$('#uploads').addClass('pb-10');
});