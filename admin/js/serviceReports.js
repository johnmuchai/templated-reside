$(document).ready(function() {

	var weekStart = $('#weekStart').val();
	
	$(".selectall").change(function(e) {
		var ct = e.currentTarget;

		var o = ct.options[0];
		var t = ct.options[0].text;
		var s = ct.options[0].selected;

		if(s && (t == "All Properties")) {
			for(var i = 1; i < ct.options.length; i++) {
				ct.options[i].selected = false;
			}
		}
	});
	
	$("[name='srvType']").change(function () {
        if ($('#allSrv').is(':checked')) {
            $('.allSrvOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.allSrvOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#openSrv').is(':checked')) {
            $('.openSrvOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.openSrvOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#closedSrv').is(':checked')) {
            $('.closedSrvOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.closedSrvOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
    });
	
	$("#servReqRpt").click(function() {
		if ($('#properties1 :selected').size() == 0) {
			$('#errNote1').html('<div class="alertMsg warning"><div class="msgIcon pull-left"><i class="fa fa-warning"></i></div>Please select at least one Property.</div>');
			$('.alertMsg').delay(6000).fadeOut("slow", function() {
				$(this).addClass('hidden');
			});
			return false;
		} else {
			return true;
		}
	});
	
	$("#servCostRpt").click(function() {
		if ($('#properties2 :selected').size() == 0) {
			$('#errNote2').html('<div class="alertMsg warning"><div class="msgIcon pull-left"><i class="fa fa-warning"></i></div>Please select at least one Property.</div>');
			$('.alertMsg').delay(6000).fadeOut("slow", function() {
				$(this).addClass('hidden');
			});
			return false;
		} else {
			return true;
		}
	});
	
	$('#reqFromDate').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	$('#reqToDate').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	
	$('#costFromDate').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	$('#costToDate').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});

});