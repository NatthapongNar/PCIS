/**
 * Created by Natthapong on 28/9/2557.
 */

$.extend(jQuery.fn.dataTableExt.oSort, {
	"date-eu-pre": function ( date ) {
	date = date.replace(" ", "");
	var eu_date, year;
		         
	if (date == '') { return 0; }
		 
	if (date.indexOf('.') > 0) { eu_date = date.split('.'); /*date a, format dd.mn.(yyyy) ; (year is optional)*/ } 
	else { eu_date = date.split('/');  /*date a, format dd/mn/(yyyy) ; (year is optional)*/ }
		 
	/*year (optional)*/
	if (eu_date[2]) { year = eu_date[2]; } 
	else { year = 0; }
		 
	/*month*/
	var month = eu_date[1];
	if (month.length == 1) { month = 0+month; }
		 
	/*day*/
	var day = eu_date[0];
	if (day.length == 1) { day = 0 + day; }
		return (year + month + day) * 1;
	},
	"date-eu-asc": function ( a, b ) { 
		return ((a < b) ? -1 : ((a > b) ? 1 : 0)); 
	},
	"date-eu-desc": function ( a, b ) { 
		return ((a < b) ? 1 : ((a > b) ? -1 : 0)); 
	}
});

$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

    // Object Element
	var tbl_progress = $('#tbl_content_progress');
	var objLoanFrom  = $('#requestload_start');
	var objLoanTo    = $('#requestload_end');


    var objFrom      = $('#datestarter');
    var objTo        = $('#dateendless');
    var footer		 = $('#fttab');
    

    footer.css('margin-left', '-13.4em');
    
    // Calendar
    objFrom.Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    objTo.Datepicker({ format: "dd/mm/yyyy", effect: "slide",  position: "bottom" });

    // Field Mask
    objLoanFrom.number(true, 0);
    objLoanTo.number(true, 0);
    $('#panel_criteria').addClass('animated fadeInDown');
    
    var table = tbl_progress.DataTable({
    	//"processing": true,
        //"serverSide": true,
       // "ajax": pathFixed + "dataloads/getappProgress",
        "columnDefs": [
       	            { "visible": true, "targets": 0, type: 'date-eu' },
       	            { "visible": true, "targets": 7, 'bSortable': false }
       	],
        "order": [[0, "desc" ]],
        "pagingType": "full_numbers",
        "lengthMenu": [[10, 25, 50, -1], [10, 50, 100, 150]]

    });
    

    
    // Animate
   


});