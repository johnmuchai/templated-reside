$(document).ready(function () {
	$('#logs').dataTable({
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
		"order": [ 0, 'desc' ],
		"pageLength": 100
	});
	
	$('#logs_wrapper').addClass('pb-20');
	$('#logs').addClass('pb-10');
});