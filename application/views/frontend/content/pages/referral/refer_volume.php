<style>

	div#referral_volume_processing {
		background-color: transparent !important;
		margin-top: 10px;
		margin-left: -280px !important;
		width: 500px;
	}
	
	.metro .dataTables_wrapper .dataTables_processing {  box-shadow: none !important;  }
		
	.icon_set { cursor: pointer; }
	
	table th, td { font-size: 0.95em !important; }
	table tbody tr:hover { color: red !important; }	
	
	table#referral_volume {
		margin-top: 50px;
	}
	
	table#referral_volume thead th {
		color: #FFF;
		text-align: center;
		background-color: #4390DF; 
		border: 1px solid #D1D1D1;		
		max-height: 35px !important;
		font-size: 0.9em !important;
	}

	table#referral_volume tfoot th { font-size: 0.8em !important; }
	table#referral_volume tfoot tr:first-child {
		color: blue;
		background-color: #FFF; 
		border: 1px solid #D1D1D1;
		
	}
	
	table#referral_volume td:nth-child(1) { text-align: center; }
    table#referral_volume td:nth-child(2) { text-align: center; background: #EBF5FF; }
    table#referral_volume td:nth-child(3) { text-align: center; }
    table#referral_volume td:nth-child(4) { text-align: left; }
    table#referral_volume td:nth-child(5) { text-align: left; }
    table#referral_volume td:nth-child(6) { text-align: left; }
    table#referral_volume td:nth-child(7) { text-align: left; }
    table#referral_volume td:nth-child(8) { text-align: center; }
    table#referral_volume td:nth-child(9) { text-align: center; }
    table#referral_volume td:nth-child(10) { text-align: center; }
    table#referral_volume td:nth-child(11) { text-align: center; }
    table#referral_volume td:nth-child(12) { text-align: center; }
    table#referral_volume td:nth-child(13) { text-align: center; background: #EBF5FF; }
    table#referral_volume td:nth-child(14) { text-align: center; }
    table#referral_volume td:nth-child(15) { text-align: center; background: #EBF5FF; }
    table#referral_volume td:nth-child(16) { text-align: center; }
    table#referral_volume td:nth-child(17) { text-align: center; background: #EBF5FF; }
    table#referral_volume td:nth-child(18) { text-align: center; }
	
	th[class*="sort"]:after {
		content: "" !important;
	}
	
	.bgmod { background-color: #e8e8e8 !important; }
	.label { 
		width: 150px !important; 
		background-color: #FFF !important;
	}
	
</style>
<div class="grid">
    <div class="row">
    
    	<header class="text-center animated rubberBand ">
			<h2>TL SALE DASHBOARD</h2>
		</header>
		
		<div id="panel_criteria" class="panel" data-role="panel" style="width: 70%; float: right; margin-bottom: 13px; margin-top: 10px;">
			<div class="panel-header fg-white" style="font-size: 1.1em; background-color: #4390DF;"><i class="fa fa-search"></i> FILTER CRITERIA</div>
			<div class="panel-content" style="display: none;">
			
				<div class="grid">
					<div class="row" style="padding-left: 4%;">     
					
						<div class="input-control select span2"> 
	         				<label class="label">FILTER FIELD</label> 
	         			    <select id="filterField" name="filterField">
	         			    	<option value="JoinDate" style="color: black !important;">Join Date</option>
	         			    	<option value="DrawdownDate" style="color: red; font-weight: bold;">Drawdown Date</option>
	         			    </select>
	         			</div> 	
						<div class="input-control text span2" style="margin-left: 10px;">  
	         				<label class="label">FIELD DATE</label> 
	         				<input id="register_date" name="register_date" type="text" value="" class="size2">
	         				<input id="start_date" name="start_date" type="hidden" value="" class="size2">
	         				<input id="end_date" name="end_date" type="hidden" value="" class="size2">	         		
	         			</div> 	       	
		                <div class="input-control text span2" style="margin-left: 10px;"> 
		             	    <label class="label">REF CODE</label> 
		             	    <input id="tl_code" name="tl_code" type="text" value="" class="size2" onkeypress="validate(event)" maxlength="8"> 
		             	</div> 		                    		
		             	<div class="input-control text span2" style="margin-left: 10px;"> 
		             		<label class="label">TLA NAME</label> 
		             		<input id="tl_name" name="tl_name" type="text" value="" class="size2"> 
		             	</div> 
		             	<div class="input-control select span2" style="margin-left: 10px;"> 
		         			<label class="label">TLA POSITION</label> 
		         			<select id="tl_position" name="tl_position" multiple="multiple" class="size2" style="height: 34px;"></select> 
	         			</div> 	
	         			
	         			<div class="input-control select span2" style="margin-left: 10px;"> 
		         			<label class="label">TL BRANCH</label> 
		         			<select id="tl_branch" name="tl_branch" multiple="multiple" class="size2" style="height: 34px;"></select> 
	         			</div>
	         					             	             		   
	             	</div>         		
	            	<div class="row" style="padding-left: 4%;">      
	           
	            	    <div class="input-control select span2" style="margin-right: 10px;"> 
	             			<label class="label">SPECIAL STATUS</label> 
	             			<select id="tl_status" name="tl_status" multiple="multiple" class="size2" style="height: 34px;"> 
	             				<option value="New">New</option> 	             				
	             				<option value="Pending">Pending</option> 
	             				<option value="Cancel by TL">Cancel by TL</option> 
	             				<option value="Terminate">Terminate</option> 
	             			</select> 
	             		</div>  	    	
	            	 
	            	    <?php  
	            	    if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
	            	    		in_array('074006', $session_data['auth']) ||
	            	    		in_array('074007', $session_data['auth']) ||
	            	    		in_array('074008', $session_data['auth'])) {
	            		?>    	
		            	<div class="input-control select span2"> 
			     			<label class="label">LB REGION</label> 
			     			<select id="lb_region" name="lb_region" class="size2" style="height: 34px;"></select> 
			     		</div> 				     		
			     		<?php } ?>
			     	
			     		<?php 
			     		
			     		if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
			     		   in_array('074004', $session_data['auth']) ||
			     		   in_array('074005', $session_data['auth']) ||
			     		   in_array('074006', $session_data['auth']) ||
			     		   in_array('074007', $session_data['auth']) ||
			     		   in_array('074008', $session_data['auth'])) {
			     		
			     		?>
			       		<div class="input-control select span2" style="margin-left: 10px;"> 
			       			<label class="label">LENDING BRANCH</label> 
			       			<select id="lb_branch" name="lb_branch" multiple="multiple" class="size2" style="height: 34px;"></select> 
						</div> 	
		       					            	
		    			<div class="input-control select span2" style="margin-left: 10px;"> 
		        			<label class="label">EMP. NAME</label> 
		        			<select id="lb_emp" name="lb_emp" multiple="multiple" class="size2" style="height: 34px;"></select>
		    			</div>
		    			<?php } ?> 
		    				          		
		        	</div> 
		        	
		        	<div class="place-left" style="padding-left: 4%;">
		        	
		        		<div class="span3" style="min-width: 280px !important;">
		    				<div class="input-control checkbox">
		    					<label>
		    						<input id="status_main_1" name="status" type="checkbox" value="Active">
		    						<span class="check"></span> Active
		    					</label>
		    				</div>
		    				
		    				<div class="input-control checkbox marginLeft10">
		    					<label>
		    						<input id="status_main_3" name="status" type="checkbox" value="Active_DD">
		    						<span class="check"></span> Active (DD)
		    					</label>
		    				</div>
		    				<!-- 
		    				<div class="input-control checkbox marginLeft10">
		    					<label>
		    						<input id="status_main_2" name="status" type="checkbox" value="Inactive">
		    						<span class="check"></span> Inactive
		    					</label>
		    				</div> 
		    				-->
	    				</div>
	    		
	    				<div class="bgmod span4" style="max-width: 160px; max-height: 35px !important; margin-left: -80px !important;">
	    					<!-- 
		    				<div class="input-control checkbox marginLeft10">
		    					<label>
		    						<input id="drawdown_check" name="drawdown_check" type="checkbox" value="1">
		    						<span class="check"></span> Drawdown
		    					</label>
		    				</div>
		    				-->
		    				
		    				<div class="input-control checkbox marginLeft10">
		    					<label>
		    						<input id="a2ca_check" name="a2ca_check" type="checkbox" value="1">
		    						<span class="check"></span> A2CA
		    					</label>
		    				</div>
		    				<div class="input-control checkbox marginLeft10">
		    					<label>
		    						<input id="ncb_check" name="ncb_check" type="checkbox" value="1">
		    						<span class="check"></span> NCB
		    					</label>
		    				</div>
	    				</div>
	    					    				
	    			</div>
		    		
		    		<div class="place-right" style="margin-right: 4.5%; margin-bottom: 10px;"> 
		    			
			    		<button class="fg-white" style="padding: 7px; background: #4390DF;" onclick="reloadDataGrid();"> 
			    	    	<i class="fa fa-search on-left"></i> 
			    	    	SEARCH 
		    	    	</button> 	  
		    	    	<button type="button" id="filterClear" class="bg-green fg-white" style="height: 33px;">CLEAR</button>  		
		    		</div>
				
				</div> 

			</div>			
		</div>
		
		<div id="showNumRecord" style="position: absolute; float: left; margin-top: 40px; font-size: 0.9em;"></div>
		
		<section style="float: right; margin-top: 25px; margin-right: 10px;">	

			<span data-role="input-control" style="margin-right: 10px;" data-hint="Refresh Page" data-hint-position="top" width="3%">
				<a id="refresh_pages" href="#" class="fg-lightBlue"><i class="fa fa-refresh on-left"></i> 
				<span>REFRESH</span></a>
			</span>
		        
		</section>
    	
    	<div class="table-responsive">
    		<table id="referral_volume" class="table bordered hovered sthiped">
    			<thead>
    				<tr>
    					<th colspan="6" >THAI LIFE AGENT INFOMATION</th>
    					<th colspan="2">LENDING BRANCH</th>
    					<th rowspan="2" style="vertical-align: middle;">APR% <br/> (YTD)</th>
    					<th rowspan="2" width="5%" style="vertical-align: middle;">TICKET SIZE</th>
    					<th colspan="2">DD VOL</th>
    					<th colspan="2">DD APP</th>
    					<th colspan="2">A2CA</th>
    					<th colspan="2">NCB</th>
    				</tr>
    				<tr>    			
    					<th>JOIN DATE</th>
	    				<th>PERIOD</th>
	    				<th>STATUS</th>
	    				<th>NAME-SURNAME</th>
	    				<th>TITLE</th>
	    				<th>BRANCH</th>
	    				<th>ASSIGNMENT</th>
	    				<th>LB</th>	    				
	    				<!-- Summary -->	    				
	    				<th>TT</th>
	    				<th>CM</th>
	    				<th>TT</th>
	    				<th>CM</th>
	    				<th>TT</th>
	    				<th>CM</th>    		
	    				<th>TT</th>
	    				<th>CM</th>   
	    			</tr>
    			</thead>
    			<tbody></tbody>
    			<tfoot>
			    	<tr>
						<th colspan="10" class="text-left">TOTAL <span id="referral_volume_footer_total"></span> : </th>
						<th></th>
						<th></th>
						<th colspan="6"></th>						
			     	</tr>     	
			    </tfoot>
    		</table>
		</div>
		
		<div class="bottom-menu-wrapper marginTop20">
			<?php echo $footer; ?>
		</div>
	
    </div>
</div>
<script>

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }	

var tla_progress = $('#referral_volume');
var table = tla_progress.dataTable({
	"processing": true, 
    "serverSide": true,
    "oLanguage": {
    	"sProcessing": '<div><img src="' + window.location.protocol + "//" + window.location.host + '/pcis/img/378_1.gif"' + '></div>'
    },
    "bFilter": false,
    "ajax": {
        "url": pathFixed + 'referral_control/getTLAVolumeList',
        "type": "POST",
        "data": function(d) {
            d.filter_type		= $('#filterField option:selected').val();
        	d.start_date  		= $('#start_date').val();
        	d.end_date    		= $('#end_date').val();        	
        	d.tl_code 	  		= $('#tl_code').val();
        	d.tl_name 	  		= $('#tl_name').val();
        	d.tl_branch   		= $('#tl_branch').val();         	
        	d.tl_status   		= $('#tl_status').val();         	
        	d.tl_position 		= $('#tl_position').val();
        	d.lb_region   		= $('#lb_region').val(); 
        	d.lb_branch   		= $('#lb_branch').val();
			d.lb_emp	  		= $('#lb_emp').val();
			d.tl_state_main		= $('input[name^="status"]:checked').map(function(){ return this.value; }).get();
			d.drawdown_check	= $('input[name="drawdown_check"]:checked').val();
			d.a2ca_check		= $('input[name="a2ca_check"]:checked').val();
			d.ncb_check			= $('input[name="ncb_check"]:checked').val();
        },
        "complete":function(data, callback) {

        	$('#showNumRecord').text($('#referral_volume_info').text());
        	$('#referral_volume_info').css('visibility', 'hidden');

        	// UI Hidden
        	$('#panel_criteria > .panel-content').hide(500, function() {
        	    $(this).css('display', 'none');
        	});

        	var select = $('#filterField option:selected').val();
        	if(select == 'DrawdownDate' && $('#start_date').val() != '') {
        		$('table#referral_volume').find('td:nth-child(11)').addClass('fg-red');
        	} else {
        		$('table#referral_volume').find('td:nth-child(11)').removeClass('fg-red');
        	}

        	getSummaryLoanInDashboard();

        },
        'timeout': 150000,
	},
    "columns": [
        { "data": "JoinDate" },
        { "data": "SLA" },
        { "data": "Seq" },
        { "data": "TLA_Name" },
        { "data": "TLA_Position" },
        { "data": "TLA_BranchName" },    	
        { "data": "Assignment" }, 
        { "data": "BranchCode" },     	    	
        { "data": "ApprovedRate" },
        { "data": "TicketSize" },
        { "data": "DD_Total" },
        { "data": "DD_CM" },
        { "data": "DD_YAPP" },
        { "data": "DD_MAPP" },
        { "data": "A2CA_Total" },
        { "data": "A2CA_CM" },
        { "data": "NCB_Total" },
        { "data": "NCB_CM" }
     ],         
    "columnDefs": [
		{ "visible": true, "targets": 8, 'bSortable': false },
        { "visible": true, "targets": 9, 'bSortable': false }                 	  
   	],
    "lengthMenu": [20, 50, 100, 150],
    "aaSorting": [[2, 'asc']],
    "pagingType": "full_numbers",
    "footerCallback": function ( row, data, start, end, display ) {

    	var api = this.api(), data;
        var intVal = function ( i ) {

            return typeof i === 'string' ?

                i.replace(/[\$,]/g, '')*1 :

                typeof i === 'number' ?

                    i : 0;

        };

        // Total over this page
        drawdown_total = api
            .column(10, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
        }, 0);

        drawdown_current = api
	        .column(11, { page: 'current'} )
	        .data()
	        .reduce( function (a, b) {
	            return intVal(a) + intVal(b);
   		}, 0);

        $(api.column(10).footer()).html(number_format(drawdown_total));
        $(api.column(11).footer()).html(number_format(drawdown_current));

    }
	
}); 

$('select[name="referral_volume_length"]').prepend('<option value="10">10</option>');

$('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
$('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });
$('#refresh_pages').click(function() { table.fnFilter($(this).val()); });

function reloadDataGrid() {

	var pattern 	   	   = new RegExp("-");
	var register_date	   = $('#register_date').val();
	var object_date 	   = pattern.test(register_date);

	var start_draftdate    = '',
	    end_draftdate 	   = '';

	if(object_date) {
	   var item   	      = register_date.split("-");
	   start_draftdate    = item[0].trim();
	   end_draftdate	  = item[1].trim();

   } else { start_draftdate	= register_date }

	$('#start_date').val(start_draftdate);
	$('#end_date').val(end_draftdate);

	table.fnFilter();
	
}


function getSummaryLoanInDashboard() {

	$.ajax({
        url: pathFixed + 'referral_control/getTLAVolumeListSummmary?_=' + new Date().getTime(),
        type: "POST",
        data: { 
            filter_type		: $('#filterField option:selected').val(),
        	start_date		: $('#start_date').val(),
        	end_date		: $('#end_date').val(),        	
        	tl_code			: $('#tl_code').val(),
        	tl_name			: $('#tl_name').val(),
        	tl_branch		: $('#tl_branch').val(),         	        	
        	tl_position		: $('#tl_position').val(),
        	lb_region		: $('#lb_region').val(), 
        	lb_branch		: $('#lb_branch').val(),
			lb_emp			: $('#lb_emp').val(),
			tl_status   	: $('#tl_status').val(),
			tl_state_main	: $('input[name^="status"]:checked').map(function(){ return this.value; }).get(),
			drawdown_check	: $('input[name="drawdown_check"]:checked').val(),
			a2ca_check		: $('input[name="a2ca_check"]:checked').val(),
			ncb_check		: $('input[name="ncb_check"]:checked').val()
        },
        success:function(data) {	     
			
        	var records  = data['data'][0]['RowRecord'];
			var drawdown_total_load   = data['data'][0]['DD_Total'];
            var drawdown_current_load = data['data'][0]['DD_CM'];   
								
        	var row_records = $('#referral_volume tbody tr').length;
            var grand_total = $('#referral_volume').find('tfoot tr').length;

            if(grand_total > 1) {
       			$('#referral_volume').find('tfoot tr:last-child').remove();
       		}
   
			var pages_length = $('#referral_volume_length option:selected').val();

			var total_pages  = records / pages_length;

        	$('#referral_volume').find('tfoot tr:last-child').after(
        		'<tr class="brands">'+
        	    	'<th colspan="10" class="text-left">GRAND TOTAL <span>( ' + Math.ceil(total_pages) + ' PAGE / ' + records + ' RECORDS ) : </span></th>' +
        			'<th>' + number_format(drawdown_total_load, 0) + '</th>' +
        			'<th>' + number_format(drawdown_current_load, 0) + '</th>' +
        			'<th colspan="6"></th>' +
        	    '</tr>' 
        	);
         
            var pages_tfoot = $('#referral_volume_paginate > span > .current').text();
    		$('#referral_volume_footer_total').text('( PAGE ' + pages_tfoot + ' / ' + row_records + ' RECORDS )');

        },
        cache: true,
        timeout: 25000,
        statusCode: {
            404: function() {
                alert( "page not found" );
            }
        }
    });
	
}

function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9\-]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
    
}

function number_format (number, decimals, dec_point, thousands_sep) {
    var n = number, prec = decimals;

    var toFixedFix = function (n,prec) {
        var k = Math.pow(10,prec);
        return (Math.round(n*k)/k).toString();
    };

    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
    var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

    var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); 
    //fix for IE parseFloat(0.55).toFixed(0) = 0;

    var abs = toFixedFix(Math.abs(n), prec);
    var _, i;

    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0,i + (n < 0)) +
               _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }

    var decPos = s.indexOf(dec);
    if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
        s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
    }
    else if (prec >= 1 && decPos === -1) {
        s += dec+new Array(prec).join(0)+'0';
    }
    return s; 
}

</script>