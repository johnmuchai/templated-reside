$(document).ready(function() {

	$("[name='propType']").change(function () {
        if ($('#allProp').is(':checked')) {
            $('.allPropOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.allPropOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#leasedProp').is(':checked')) {
            $('.leasedPropOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.leasedPropOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#availProp').is(':checked')) {
            $('.availPropOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.availPropOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
    });
	
	$("[name='leaseType']").change(function () {
        if ($('#allLeases').is(':checked')) {
            $('.allLeasesOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.allLeasesOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#actLeases').is(':checked')) {
            $('.actLeasesOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.actLeasesOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
        if ($('#inacLeases').is(':checked')) {
            $('.inacLeasesOpt i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
        } else {
            $('.inacLeasesOpt i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
        }
    });

});