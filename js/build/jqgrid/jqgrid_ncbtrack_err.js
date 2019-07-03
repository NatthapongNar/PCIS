$(function() {

	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    
    var grid 	= $('#table_ncb_track');
    
    grid.jqGrid({
		url: '',
		datatype: 'json',
		height: '430',
		width: '1250',
		rownumbers: true,
		colNames: ['Error Type','Rate', 'Amount', 'Update By', 'Update Date'],
    	colModel: [
   			{ name: 'ErrorType', index: 'errortype_id', align:'center', width:150, sortable:false, editable: true,
   			  edittype:"select", type:'select', editoptions: {
   				 dataUrl:  pathFixed + 'dataloads/getDocumentErrorlist?_=' + new Date().getTime(),
                 buildSelect: function(jsonArray) {
                	 
                	 var s = '<select>';
                	 var responsed = $.parseJSON(jsonArray);
                	 for(var indexed in responsed['data']) {
                		 s += '<option value="' + responsed['data'][indexed]['Cat_Code'] + '">' + ' [' + responsed['data'][indexed]['Category'] + '] - ' + responsed['data'][indexed]['Sub_Cat'] + '</option>';
                	 }
                	 
                	 return s + "</select>";
                
                 }
   			  }
   			},
   			{ name: 'Rate', index: 'rate_id', align:'center', width:200, sortable:false, editable: true },
   			{ name: 'Amount', index: 'amount_id', align:'center', width:200, sortable:false, editable: true },
   			{ name: 'UpdateBy', index: 'updateby_id', align:'center', width:100, sortable:true, editable: true },
   			{ name: 'UpdateDate', index: 'updatedate_id', width:100, align:'center' }
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
	}, {}, { width: 600, height: 'auto' }, {}, { multipleSearch: true }, { width: 800, height: 'auto'});
    
    grid.jqGrid('navButtonAdd', '#table_ncb_track_toppager_left', { // "#list_toppager_left"
    	caption: "Export",
    	title: "Export",
    	buttonicon:'ui-icon-newwin',
        onClickButton: function() {
        	
        	
        }
    
    });
  
    grid.jqGrid('navButtonAdd', '#table_ncb_track_toppager_left', { // "#list_toppager_left"
    	caption: "Report",
    	title: "Report",
    	buttonicon:'ui-icon-image',
        onClickButton: function() {
        	
        	
        }
    
    });
    
    // Remove paging on top	
	var topPagerDiv = $('#table_ncb_track_toppager')[0];         // "#list_toppager"
	$("#table_ncb_track_toppager_center", topPagerDiv).remove(); // "#list_toppager_center"
	$(".ui-paging-info", topPagerDiv).remove(); 
	
	// Remove Bottom Menu
	$('#add_table_ncb_track').remove();
	$('#view_table_ncb_track').remove();
	$('#refresh_table_ncb_track').remove();
	
	// Functional
    
    function reload(rowid, result) {
  		grid.trigger("reloadGrid"); 
	}
    
   
	
});