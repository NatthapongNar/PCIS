<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title><?php echo $author.' - Document Management'; ?></title>
    <meta name="description" content="<?php echo $desc; ?>">
    <meta name="viewport" content="<?php echo $viewport; ?>">
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">
 	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/logo.ico'); ?>">
    <!-- Power by Metro UI -->
	<link href="<?php echo base_url('css/metro/metro-bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/metro/metro-bootstrap-responsive.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/metro/iconFont.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/custom/app_progress.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('css/animate/animate.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('css/pikaday.css'); ?>" rel="stylesheet" >  
	<style type="text/css">
		
		table tbody tr:hover { color: red !important; }
		table#tbl_reconsiledoc th, td { font-size: 12px; }	
		table#tbl_reconsiledoc tr td:first-child { text-align: left !important; display: none; }
		table#tbl_reconsiledoc tr td:nth-child(1) { text-align: left !important; }
		table#tbl_reconsiledoc tr td:nth-child(2) { text-align: left !important; }
		table#tbl_reconsiledoc tr td:nth-child(3) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(4) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(5) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(6) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(7) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(8) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(9) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(10) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(11) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(12) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(13) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(14) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(15) { text-align: center !important; }
		table#tbl_reconsiledoc tr td:nth-child(16) { text-align: left !important; }
		table#tbl_reconsiledoc tr td:nth-child(17) { text-align: left !important; }
		table#tbl_reconsiledoc tr td:nth-child(18) { text-align: left !important; }
		
		.successes { background-color: #DFF0D8 !important; }
		.errors { background-color: #F2DEDE !important; }
		.waiting { background-color: #F2DEDE !important; }
		.brands { background-color: #4390DF; color: #FFF; }
		/*.dataTables_length { display: none; }*/
		
	</style>
</head>
<body  class="metro">
<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div id="navigation">
	<?php echo $this->load->view('frontend/implement/nav'); ?>
</div>

<div id="contentation" style="margin-top: 70px;">

<header class="text-center">
	<h2>RECONCILE DOCUMENT MANAGEMENT</h2>
	<h4 id="timestemps" class="text-center text-muted"><?php echo date('d M Y'); ?></h4>
</header>



<div class="grid">
<div id="application" class="row">

	<!-- SEARCH TOOLBAR -->
	<div id="panel_reconsiledoc" class="panel" data-role="panel" style="width: 60%; float: right; margin-bottom: 0px; padding-bottom: 13px; margin-right: 2%;">
		<div class="panel-header bg-lightBlue fg-white" style="font-size: 1.1em;"><i class="fa fa-search on-left"></i>FILTER CRITERIA</div>
		<div class="panel-content" style="display: none;">
		
			<div class="row" style="float: right; margin-right: 2%;">
			<span data-role="input-control" style="margin-right: 10px;" data-hint="กดเพื่อ refresh หน้า" data-hint-position="top" width="3%">
				<a id="refresh_pages" href="#" class="fg-lightBlue"><i class="fa fa-refresh on-left"></i> 
				<span>REFRESH</span></a>
			</span>
		    <div class="input-control radio" data-role="input-control" style="margin-right: 5px;">
		        <label>
		            <input type="radio" id="inlineCheckbox1" name="inlineCheckbox" value="a2lx">
		            <span class="check"></span> All
		        </label>
		   	 </div>
		   	 <div class="input-control radio" data-role="input-control" style="margin-right: 5px;">
		        <label>
		            <input type="radio" id="inlineCheckbox2" name="inlineCheckbox" value="r2cx" checked="checked">
		            <span class="check"></span> RECONCILE
		        </label>
		     </div>
		     <div class="input-control radio" data-role="input-control">
		        <label>
		            <input type="radio" id="inlineCheckbox3" name="inlineCheckbox" value="m2cx"> 
		            <span class="check"></span> MISSING
		        </label>
		    </div>
		    <div class="input-control radio" data-role="input-control">
		        <label>
		            <input type="radio" id="inlineCheckbox4" name="inlineCheckbox" value="r2cl"> 
		            <span class="check"></span> RETURN
		        </label>
		    </div>
			</div>
			
			<div class="row" style="float: right; margin-right: 2%;">
			<?php
		    	
		    	if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' || 
				   in_array('074007', $session_data['auth']) && $session_data['branchcode'] == '000' || 
				   in_array('074008', $session_data['auth'])) {
					echo '<div class="input-control select span2" data-role="input-control">
			                <label>Region</label>
			                	<select id="regions" name="regions" style="width: 130px;">
									<option value="" selected>All</option>';
		
										foreach($AreaRegion['data'] as $index => $values) {
											echo '<option value="'.$values['RegionID'].'">'.strtoupper($values['RegionNameEng']).'</option>';
										
										}
										
					echo	'</select>
					</div>';
				}

				if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
				   in_array('074004', $session_data['auth']) ||
				   in_array('074005', $session_data['auth']) ||
			       in_array('074006', $session_data['auth']) ||
				   in_array('074007', $session_data['auth']) ||
				   in_array('074008', $session_data['auth'])) {
				
					echo '<div class="input-control select span2" data-role="input-control" style="margin-right: -6px;">
			                 <label>Branch</label>
							 <select id="branchs" name="branchs" style="width: 130px;">
								<option value="" selected>All</option>';

								foreach($AreaBoundary['data'] as $index => $values) {
									echo '<option value="'.$values['BranchDigit'].'">'.$values['BranchDigit'].'</option>';
								
								}
	 		
					echo '</select>
        			</div>';
				}

			?>
			<div class="input-control text span2" data-role="input-control" style="height: 33px;">
				<label>LOGISTIC CODE</label>
				<input id="logistic_code" name="logistic_code" type="text" value="">
			</div>
			<div class="input-control text span2" data-role="input-control" style="height: 33px;">
				<label>CUSTOMER</label>
				<input id="customer" name="customer" type="text" value="">
			</div>
			<div class="input-control text span2" data-role="input-control" style="height: 33px; margin-left: 3px;">
				<label>RM NAME</label>
				<input id="rmname" name="rmname" type="text" value="">
			</div>
			
		</div>
		
		<div class="row" style="float: right; margin-right: 2%;">
			
			<div class="input-control text size2" id="objEmsdateFrom">
				<label><i class="fa fa-calendar"></i> EMS FROM :</label>
				<input type="text" name="emsdate_from" id="emsdate_from" value="">
			</div>
			
			<div class="input-control text size2" id="objEmsdateTo">
				<label><i class="fa fa-calendar"></i> EMS TO :</label>
				<input type="text" name="emsdate_to" id="emsdate_to" value="">
			</div>
			
			<div class="input-control text size2" id="objMissdateFrom">
				<label><i class="fa fa-calendar"></i> MISSING FROM :</label>
				<input type="text" name="missdate_from" id="missdate_from" value="">
			</div>
			<div class="input-control text size2" id="objMissdateTo">
				<label><i class="fa fa-calendar"></i> MISSING TO :</label>
				<input type="text" name="missdate_to" id="missdate_to" value="">
			</div>
			
			<!-- 
			<div class="input-control text size2" id="objReturndateFrom">
				<label><i class="fa fa-calendar"></i> RETURN FROM :</label>
				<input type="text" name="returndate_from" id="returndate_from" value="">
			</div>
			<div class="input-control text size2" id="objReturndateTo">
				<label><i class="fa fa-calendar"></i> RETURN TO :</label>
				<input type="text" name="returndate_to" id="returndate_to" value="">
			</div>
			-->
			
			<div class="input-control text size2">
				<button type="button" id="filterSubmit" class="bg-lightBlue fg-white" style="height: 33px;">
					<i class="icon-search on-left"></i>SEARCH
				</button>
				<button type="button" id="filterClear" class="bg-green fg-white" style="height: 33px;">
					<i class="fa fa-trash on-left"></i>
				</button>
			</div>
		</div>		
			
		</div>
	</div>
	
	<div id="showNumRecord" style="position: absolute; float: left; margin-top: 40px; margin-left: 1.5em; font-size: 0.9em;"></div>
	 
	<div id="tbl_content_reconsiledoc" class="table-responsive" style="padding: 0 20px;">
	<input type="hidden" name="actor" id="actor" value="<?php echo !empty($session_data['thname'])? $session_data['thname']:""; ?>">
    <table id="tbl_reconsiledoc" class="table bordered hovered" style="width: 100%; margin: 10px auto 0;">
            <thead>
            	<tr class="brands">
            		<th rowspan="2" width="2%" style="display: none;">Doc ID</th>
            		<th colspan="4" width="20%">EMS / MESSENGER</th>
            		<th colspan="4" width="20%">DOCUMENT COMPLETION</th>
            		<th colspan="4" width="20%">DOCUMENT RETURN</th>
            		<th colspan="5" width="36%">INFORMATION</th>
            	</tr>
	            <tr class="brands">
	            	<th>LOGISTIC</th>
	            	<th>DATE</th>
	            	<th data-hint="DAY|จำนวนวันที่ทั้งหมดที่ใช้ไประหว่างการดำเนินการ" data-hint-position="top" width="3%">
	            		<i class="fa fa-asterisk"></i>
	            	</th>
	            	<th width="3%" data-hint="STATUS" data-hint-position="top">
	            		<i class="fa fa-laptop"></i>
	            	</th>
	            	<th>DATE</th>
	            	<th data-hint="#|จำนวนเอกสารที่ขาด" data-hint-position="top" width="3%"><i class="fa fa-exchange"></i></th>
	            	<th data-hint="DAY|จำนวนวันที่ทั้งหมดที่ใช้ไประหว่างการดำเนินการ" data-hint-position="top" width="3%">
	            		<i class="fa fa-asterisk"></i>
	            	</th>
	            	<th width="3%" data-hint="STATUS" data-hint-position="top">
	            		<i class="fa fa-laptop"></i>
	            	</th>
	            	<th>DATE</th>
	            	<th data-hint="#|จำนวนเอกสารขอคืน" data-hint-position="top" width="3%"><i class="fa fa-retweet"></i></th>
	            	<th data-hint="DAY|จำนวนวันที่ทั้งหมดที่ใช้ไประหว่างการดำเนินการ" data-hint-position="top" width="3%">
	            		<i class="fa fa-asterisk"></i>
	            	</th>
	            	<th width="3%" data-hint="STATUS" data-hint-position="top"><i class="fa fa-laptop"></i></th>
	            	<th width="6%">BRN</th>
	            	<th width="5%">NCB</th>
	            	<th width="5%">TYPE</th>
	                <th width="12%">CUSTOMER</th>
	                <th width="12%">RM</th>
	            	
	            </tr>
            </thead>
            <tbody>
				
            </tbody>
      </table>
      </div>
	  
	  
</div>
</div>
</div>

<div class="container" style="margin-top: 30px; margin-left: 20px;">
	<?php $this->load->view('frontend/implement/footer'); ?>
</div>

<script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>
<script src="<?php echo base_url('js/metro/metro.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
<script src="<?php echo base_url('js/dataTables/media/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.truncate.min.js'); ?>"></script> 
<script src="<?php echo base_url('js/vendor/jquery.number.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.mask.min.js'); ?>"></script>
<script src="<?php echo base_url('js/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('js/pikaday.js'); ?>"></script>
<script type="text/javascript">

$(function() {

	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

    var objrecon	= $('input[name="inlineCheckbox"]:checked').val();
    var objFrom     = $('#emsstartdate');
    var objTo       = $('#emsenddate');

    //new Pikaday({ field: document.getElementById('emsstartdate'), format: 'DD/MM/YYYY' });
    //new Pikaday({ field: document.getElementById('emsenddate'), format: 'DD/MM/YYYY' });
    
    var objstate;		
    
    switch(objrecon) {
    	case 'r2cl':
    		objstate = '2';
        	break;
    	case 'm2cx':
    		objstate = '5';
        	break;
    	case 'r2cx':
    	case 'a2lx':
        default:
        	objstate = '2';
        	break;
    }

    var table = $('#tbl_reconsiledoc').dataTable({
    	"processing": true,
	    "serverSide": true,
	    "bFilter": false,
	    "oLanguage": {
            "sProcessing": '<img src="' + window.location.protocol + "//" + window.location.host + '/pcis/img/progress-loader.gif"' + '> Loading...</div>'
        },
	    "ajax": {
	    	 "url": pathFixed + 'metro/getDocManagementResults',
	    	 "type": "POST",
	         "data": function(d) {
				d.slmode 		  = $('input[name="inlineCheckbox"]:checked').val();
				d.logistic_code	  = $('#logistic_code').val();
				d.regionid		  = $('select[name="regions"] option:selected').val();
			    d.branchdigit	  = $('select[name="branchs"] option:selected').val();
				d.rmname		  = $('#rmname').val();
		        d.ownerName 	  = $('#customer').val();
		        d.emsdate_from	  = $('#emsdate_from').val();
		        d.emsdate_to	  = $('#emsdate_to').val();
		        d.missdate_from	  = $('#missdate_from').val();
		        d.missdate_to	  = $('#missdate_to').val();
		        d.returndate_from = $('#returndate_from').val();
		        d.returndate_to   = $('#returndate_to').val();
	         },
	         "complete":function(data, callback) {

	        	 table.find('td:nth-child(17), td:nth-child(18)').truncate({
	                width: '130',
	                token: '…',
	                side: 'right',
	            	addtitle: true
	             });

	        	 $('#tbl_reconsiledoc tbody tr').each(function(e) {
		        	    var active_record = $('input[name="inlineCheckbox"]:checked').val();
	                	var objRow = $(this).find('td:nth-child(12), td:nth-child(13)');
	                	
						if(objRow[0].innerHTML == "A"  && objRow[1].innerHTML != '' && objRow[1].innerHTML != '01/01/1900') {
							$(this).addClass('successes');

						}
						
	             }); 

	        	 $('#showNumRecord').text($('#tbl_reconsiledoc_info').text()); //.toLowerCase()
	             $('#tbl_reconsiledoc_info').css('visibility', 'hidden');

	         }
	         
	    },
	    "columns": [
	        	    
			{ "data": "DocID" },
			{ "data": "EMSNo" },
			{ "data": "EMSDate" },
			{ "data": "EMSDay" },
			{ "data": "EMSStatus" },
			
	        { "data": "SentToCADate" },
	        { "data": "CompletionNum" },
	        { "data": "CompletionDay" },
	        { "data": "CompletionState" },
	        
	        { "data": "ReturnDate" },
	        { "data": "ReturnNum" },
	        { "data": "ReturnDay" },
	        { "data": "ReturnState" },

	        { "data": "BranchDigit" },
	        { "data": "NCBState" },
	        { "data": "PeopleLoanTypes" },
			{ "data": "OwnerName" },
			{ "data": "RMName" }
            
	     ],       
	     "columnDefs": [
	        { "visible": true, "targets": 0},
	        { "visible": true, "targets": 2, type: 'date-eu'},
	        { "visible": true, "targets": 3, 'bSortable': false},
	        { "visible": true, "targets": 4, 'bSortable': false},
	        { "visible": true, "targets": 5, type: 'date-eu'},
	        { "visible": true, "targets": 6, 'bSortable': false},
	        { "visible": true, "targets": 7, 'bSortable': false},
	        { "visible": true, "targets": 8, type: 'date-eu', 'bSortable': false},
	        { "visible": true, "targets": 9, 'bSortable': false},
	        { "visible": true, "targets": 10, 'bSortable': false},
	        { "visible": true, "targets": 11, 'bSortable': false},
	        { "visible": true, "targets": 12, 'bSortable': false},
	        { "visible": true, "targets": 13, 'bSortable': true},
	        { "visible": true, "targets": 14, 'bSortable': false},
	        { "visible": true, "targets": 15, 'bSortable': false},
	        { "visible": true, "targets": 16}
	    ],
		
		"lengthMenu": [10, 25, 50, 100],
        "aaSorting": [[objstate,'asc']],
        "pagingType": "full_numbers"
    });

    // Re-Load
    $('input[id^="inlineCheckbox"]').click(function () { table.fnFilter($(this).val()); });
    $('#regions').on('change', function () { 
 	   table.fnFilter($(this).val()); 
    });
    
    $('#regions').on('change', function () { 

 	   var rgnidx	= $("select[name='regions'] option:selected").val();
 	   if(rgnidx != undefined || rgnidx != '') {

 		   $.ajax({
 				url: pathFixed+'dataloads/branchBoundary?_=' + new Date().getTime(),
 				type: "POST",
 				data: { rgnidx:rgnidx },
 				success:function(responsed) {
 					
 					$('#branchs').empty().first().append('<option value=""> All</option>');
 					for(var indexed in responsed['data']) {
 						$('#branchs').append("<option value='"+responsed['data'][indexed]['BranchDigit']+"'>"+responsed['data'][indexed]['BranchDigit']+"</option>");
 					}
 					
 				},
 				cache: false,
 				timeout: 5000,
 				statusCode: {
 					404: function() {
 						alert( "page not found" );
 					},
 			        407: function() {
 			        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
 			        }
 				}
 				
 			});

 	   }	

    });
    
    $('#branchs').on('change', function () { table.fnFilter($(this).val()); });
    $('#customer').on('change', function () { table.fnFilter($(this).val()); });
    $('#rmname').on('change', function () { table.fnFilter($(this).val()); });
    $('#filterSubmit').click(function () { table.fnFilter($(this).val()); });
    
    $(function(){
        $("#createWindow").on('click', function(){
            $.Dialog({
                flat: false,
                shadow: true,
                title: 'Test window',
                content: 'Test window content',
                sysButtons: {
                    btnMin: true,
                    btnMax: true,
                    btnClose: true
                },
                width: 500
            });
        });
    });

    $('#refresh_pages').on('mouseover', function() { $('#refresh_pages i').addClass('fa-spin'); });
    $('#refresh_pages').on('mouseout', function() { $('#refresh_pages i').removeClass('fa-spin'); });
    $('#refresh_pages').click(function() { table.fnFilter($(this).val()); });

    $('#emsdate_from').mask('99/99/9999');
    $('#emsdate_to').mask('99/99/9999');
    $('#missdate_from').mask('99/99/9999');
    $('#missdate_to').mask('99/99/9999');
    //$('#returndate_from').mask('99/99/9999');
    //$('#returndate_to').mask('99/99/9999');
    
    new Pikaday({ field: document.getElementById('emsdate_from'), format: 'DD/MM/YYYY' });
    new Pikaday({ field: document.getElementById('emsdate_to'), format: 'DD/MM/YYYY' });
    new Pikaday({ field: document.getElementById('missdate_from'), format: 'DD/MM/YYYY' });
    new Pikaday({ field: document.getElementById('missdate_to'), format: 'DD/MM/YYYY' });
    //new Pikaday({ field: document.getElementById('returndate_from'), format: 'DD/MM/YYYY' });
    //new Pikaday({ field: document.getElementById('returndate_to'), format: 'DD/MM/YYYY' });

    $('#filterClear').click(function() { 
		$('#branchs').val('');
		$('#regions').val('');
		$('#logistic_code').val('');
		$('#rmname').val('');
		$('#customer').val('');

		$('#inlineCheckbox2').prop( "checked", true );;
		$('input[name="inlineCheckbox"]:checked').val('r2cx');
		
		$('#emsdate_from, emsdate_to').val('');
		$('#missdate_from, #missdate_to').val('');
		//$('#returndate_from, #returndate_to').val('');	

		table.fnFilter($(this).val());
		
	});

    $('#tbl_reconsiledoc tbody').on('dblclick', 'tr', function (e) {
	    var objRow = $(this).find('td:first-child');
	   	var url	   = pathFixed+'metro/routers?mod=1&cache=false&secure=c4ca4238a0b923820dcc509a6f75849b&rel='+objRow[0].innerHTML+'&req=P2&live=2&t=53';
	   	e.preventDefault();
	
	   	window.open(url, '_blank');   	 	 
   		 
    });
	
});


</script>

</body>
</html>