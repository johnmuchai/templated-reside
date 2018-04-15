(function ($) {
    var d = document.documentElement; d.className = d.className.replace(/no\-js/g,'');  
    
    var ie = document.all && !window.opera;
    $.fn.tabs = function () {
        this.each(function () {
            var tabs = $(this);
            var tabsContents = tabs.find('> .tabsBody');
            var tabsItems = tabsContents.find('> li');

            tabsContents.on('click keyup', '> li > .tabHeader', function (e) {
                e.preventDefault();
                if(e.type=='keyup' && e.which!=13) return;
                var index = tabsItems.index($(this).parents('li:first'));
                changeTabs(index);
            });
            
            function changeTabs(index) {
                tabsItems.removeClass('active').delay(ie ? 1 : 0).eq(index).addClass('active');
            }
        });
        return this;
    };
})(jQuery);

$(document).ready(function() {
    $('div.tabs').tabs();
	
	/** ******************************
    * Data Tables
    ****************************** **/
	$('#actLeases').dataTable({
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
			"orderable": false, "targets": 7
		}],
		"order": [ 6, 'asc' ],
		"pageLength": 10
	});
	
	$('#actLeases_wrapper').addClass('pb-20');
	$('#actLeases').addClass('pb-10');
	
	$('#inactLeases').dataTable({
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
			"orderable": false, "targets": 5
		}],
		"order": [ 5, 'asc' ],
		"pageLength": 25
	});
	
	$('#inactLeases_wrapper').addClass('pb-20');
	$('#inactLeases').addClass('pb-10');
});