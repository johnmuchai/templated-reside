$(document).ready(function () {
	$('#payments').dataTable({
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
		"order": [ 0, 'asc' ],
		"pageLength": 10
	});
	
	$('#payments_wrapper').addClass('pb-20');
	$('#payments').addClass('pb-10');
	
	$('#refunds').dataTable({
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
			"orderable": false, "targets": 3
		}],
		"order": [ 0, 'asc' ],
		"pageLength": 10
	});
	
	$('#refunds_wrapper').addClass('pb-20');
	$('#refunds').addClass('pb-10');
	
	var weekStart = $('#weekStart').val();
	var a = 0;

	$('#paymentDate').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	$('#rentYear').datetimepicker({
		format: 'yyyy',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 4,
		startView: 4
	});
	
	$('[name="refundDate"]').each(function() {
		$('#refundDate_'+a+'').datetimepicker({
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