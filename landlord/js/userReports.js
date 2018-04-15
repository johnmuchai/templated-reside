$(document).ready(function() {

	$("[name='accType1']").change(function () {
        if ($('#allUsrAcc1').is(':checked')) {
            $('.allUsrAccOpt1 i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.allUsrAccOpt1 i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#actUsrAcc1').is(':checked')) {
            $('.actUsrAccOpt1 i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.actUsrAccOpt1 i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#inactUsrAcc1').is(':checked')) {
            $('.inactUsrAccOpt1 i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.inactUsrAccOpt1 i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
    });
	
	$("[name='accType2']").change(function () {
        if ($('#allUsrAcc2').is(':checked')) {
            $('.allUsrAccOpt2 i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.allUsrAccOpt2 i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#arcUsrAcc2').is(':checked')) {
            $('.arcUsrAccOpt2 i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.arcUsrAccOpt2 i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#dsbUserAcc2').is(':checked')) {
            $('.dsbUserAccOpt2 i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.dsbUserAccOpt2 i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
    });
	
	$("[name='admAccType']").change(function () {
		if ($('#allAdm').is(':checked')) {
            $('.allAdmOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.allAdmOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#actAdm').is(':checked')) {
            $('.actAdmOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.actAdmOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#inactAdm').is(':checked')) {
            $('.inactAdmOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.inactAdmOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
		 if ($('#dsbAdm').is(':checked')) {
            $('.dsbAdmOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.dsbAdmOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
    });
	
	$("#adminRpt2").click(function() {
		var adminsId = $("#adminsId").val();
		if (adminsId != '...') {
			return true;
		} else {
			$('#errNote').html('<div class="alertMsg warning"><div class="msgIcon pull-left"><i class="fa fa-warning"></i></div>Please select an Administrator.</div>');
			$('.alertMsg').delay(6000).fadeOut("slow", function() {
				$(this).addClass('hidden');
			});
			return false;
		}
	});

});