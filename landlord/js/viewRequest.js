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
	
	$('#servExpense').dataTable({
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
			"orderable": false, "targets": 4
		}],
		"order": [ 2, 'desc' ],
		"pageLength": 10
	});
	
	$('#servExpense_wrapper').addClass('pb-20');
	$('#servExpense').addClass('pb-10');
	
	// Set the Request Priority & Status Options
	var priTitle		= $("#priTitle").val();
	var staTitle		= $("#staTitle").val();
	$("select#requestPriority option").each(function() { this.selected = (this.text == priTitle); });
	$("select#requestStatus option").each(function() { this.selected = (this.text == staTitle); });
	
	// Populate the hidden Admin Name field
	$("#adminId").change(function() {
		var adminsName	= $("#adminId option:selected").text();
		$("#admName").val(adminsName);
	});
	
	// Set the Assigned Admin Select Option
	var assignedAdm		= $("#assignedAdm").val();
	$("select#adminId option").each(function() { this.selected = (this.text == assignedAdm); });
	
	// Set the Follow Up Select Option
	var fllwUp		= $("#followUp").val();
	$("select#edit_needsFollowUp option").each(function() { this.selected = (this.text == fllwUp); });
	
	var weekStart 		= $('#weekStart').val();
	var a = 0;

	$('#edit_resolutionDate').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	$('#resolutionDate').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	$('#dateOfExpense').datetimepicker({
		format: 'yyyy-mm-dd',
		todayBtn:  0,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2,
		forceParse: 0,
		weekStart: weekStart
	});
	
	$('[name="dateOfExpense"]').each(function() {
		$('#dateOfExpense_'+a+'').datetimepicker({
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