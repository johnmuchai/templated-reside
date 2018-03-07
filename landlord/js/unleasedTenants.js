$(document).ready(function () {

	/** ******************************
    * Data Tables
    ****************************** **/
	$('#unleasedTenants').dataTable({
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
		"columnDefs": [{
			"orderable": false, "targets": 6
		}],
		"order": [[ 4, 'asc' ]],
		"pageLength": 25
	});
	
	$('#unleasedTenants_wrapper').addClass('pb-20');
	$('#unleasedTenants').addClass('pb-10');

});