$(document).ready(function () {
	$('#sitealerts').dataTable({
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
		"order": [ 4, 'desc' ],
		"pageLength": 10
	});
	
	$('#sitealerts_wrapper').addClass('pb-20');
	$('#sitealerts').addClass('pb-10');
	
	var weekStart = $('#weekStart').val();
	var a = 0;

	$('#alertStart').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	$('#alertExpires').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	
	$('[name="alertStart"]').each(function() {
		$('#alertStart_'+a+'').datetimepicker({
			format: 'yyyy-mm-dd',
			todayBtn:  0,
			autoclose: 1,
			todayHighlight: 1,
			minView: 2,
			forceParse: 0,
			weekStart: weekStart
		});
		$('#alertExpires_'+a+'').datetimepicker({
			format: 'yyyy-mm-dd',
			todayBtn:  0,
			autoclose: 1,
			todayHighlight: 1,
			minView: 2,
			forceParse: 0,
			weekStart: weekStart
		});
		a++;
	});
});