$(document).ready(function () {
	var weekStart = $('#weekStart').val();
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
	$('#refundDate').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	$('#refundDate_edit').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	
	// Set the Rent Month Option
	var theMonth		= $("#theMonth").val();
	$("select#rentMonth option").each(function() { this.selected = (this.text == theMonth); });

});