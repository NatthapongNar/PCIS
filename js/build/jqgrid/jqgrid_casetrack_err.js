$(function() {

	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    
    var grid 	= $('#table_case_track');
    
    grid.jqGrid({
		url: '',
		datatype: 'json',
		height: '430',
		width: '1250',
		rownumbers: true,
		colNames: ['ErrorType','Description', 'Branch', 'RM'],
    	colModel: [
   			{ name: 'ErrorType', index: 'errortype_id', align:'center', width:150, sortable:false, editable: true },
   			{ name: 'Description', index: 'description_id', align:'center', width:200, sortable:false, editable: true },
   			{ name: 'Branch', index: 'branch_id', align:'center', width:100, sortable:true, editable: true },
   			{ name: 'RM', index: 'rm_id', align:'center', width:150, sortable:true, editable: true }
   		],
   		pager: '#paging',
   		rowNum: 50,
		rowList: [50, 100, 500],
		gridview: true,
		viewrecords: true, 
		sortable: true,
		sortorder: "desc",
		toppager: true,
		caption: 'List Tracking'
			
    });
    
    grid.jqGrid('navGrid', '#paging', {
   		edit: false,
		add: true,
		del: false,
		view: true,
		search: false,
		refresh: true,
		viewtext: "View",
		closeOnEscape: true,
		edittext: "Edit",
		refreshtext: "Refresh",
		addtext: "Add",
		deltext: "Delete",
		searchtext: "Search",
		cloneToTop: true
	}, {}, {}, {}, { multipleSearch: true }, { width: 800, height: 'auto'});
    
  
    
    // Remove paging on top	
	var topPagerDiv = $('#table_case_track_toppager')[0];         // "#list_toppager"
	$("#table_case_track_toppager_center", topPagerDiv).remove(); // "#list_toppager_center"
	$(".ui-paging-info", topPagerDiv).remove(); 
	
	// Remove Bottom Menu
	$('#add_table_case_track').remove();
	$('#view_table_case_track').remove();
	$('#refresh_table_case_track').remove();
    
    function reload(rowid, result) {
  		grid.trigger("reloadGrid"); 
	}
	
});