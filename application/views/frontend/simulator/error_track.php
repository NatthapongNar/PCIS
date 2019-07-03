<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $author; ?></title>
    <meta name="description" content="<?php echo $desc; ?>">
    <meta name="viewport" content="<?php echo $viewport; ?>">
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/logo.ico'); ?>">

    <link href="<?php echo base_url('css/jquery-ui/ui-lightness/jquery-ui-1.8.20.custom.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/metro/metro-bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/metro/metro-bootstrap-responsive.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/metro/iconFont.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/custom/app_progress.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/animate/animate.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/pikaday.css'); ?>" rel="stylesheet" >
    <link href="<?php echo base_url('css/vendor/jquery.multiselect.css'); ?>" rel="stylesheet" >

</head>
<body  class="metro">
<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

 <div class="listview" style="position: fixed; margin-top: 20px;">
 	   <div class="list" style="max-width: 150px;" onclick="javascript:window.open('','_self').close();">
        <div class="list-content">
           <i class="icon icon-exit" style=" -ms-transform: rotate(180deg); -webkit-transform: rotate(180deg); transform: rotate(180deg);"></i>
            <div class="data">
               <span class="list-title" style="margin-top: 20px; font-weight: 700;">CLOSE</span>
            </div>
        </div>
    </div>
    <div id="objSubmit" id="submitVerificationForm" class="list" style="max-width: 150px;">
        <div class="list-content">
           <i class="icon icon-floppy"></i>
            <div class="data">
               <span class="list-title" style="margin-top: 20px; font-weight: 700;">SUBMIT</span>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="grid">
        <div class="row">
        	
			<div class="panel" data-role="panel" style="width: 1250px; margin-bottom: 10px;">
				<div class="panel-header bg-lightBlue fg-white" style="font-size: 0.9em;"><i class="icon-address-book on-left"></i> INFORMATION</div>
				<div class="panel-content" style="display: none;">
					
					<div class="row" style="margin-top: -10px;">
					
						<div class="span6 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลลูกค้า</label></div>
						<div class="span6 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลพนักงาน</label></div>
						
						<div class="span6">
							<label class="label span2 text-left">ชื่อ - นามสกุล</label>							
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['BorrowerName']) ? $getCustInfo['BorrowerName']:"";  ?></div>
						</div>
						
						<div class="span6">
							<label class="label span2 text-left">ชื่อ - นามสกุล</label>							
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['RMName']) ? $getCustInfo['RMName']:""; ?></div>
						</div>
						
						<div class="span6">
							<label class="label span2 text-left">ประเภทผู้กู้</label>	
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['BorrowerDesc']) ? $getCustInfo['BorrowerDesc']:"";  ?></div>
						</div>
						
						<div class="span6">
							<label class="label span2 text-left">รหัสพนักงาน</label>								
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['RMCode']) ? $getCustInfo['RMCode']:""; ?></div>
						</div>
						
						<div class="span6">
							<label class="span2 text-left"></label>	
							<div class="span4 text-left"></div>
						</div>
						
						<div class="span6">
							<label class="label span2 text-left">รหัสสาขา</label>							
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['BranchCode']) ? $getCustInfo['BranchCode']:""; ?></div>
						</div>
						
						<div class="span6">
							<label class="span2 text-left"></label>	
							<div class="span4 text-left"></div>
						</div>
						<div class="span6">
							<label class="label span2 text-left">เบอร์โทรศัพท์</label>							
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['RMMobile']) ? $getCustInfo['RMMobile']:""; ?></div>
						</div>

						<div class="span6">
							<label class="span2 text-left"></label>	
							<div class="span4 text-left"></div>
						</div>
						
						<div class="span6">
							<label class="label span2 text-left">สาขา</label>								
							<div class="label span4 text-left"><?php echo !empty($getCustInfo['BranchName']) ? $getCustInfo['BranchName']:""; ?></div>
						</div>
					
						<div class="span6">
							<label class="span2 text-left"></label>													
							<div class="span4 text-left"></div>
						</div>
						<div class="span6">
							<label class="label span2 text-left">เบอร์ติดต่อสาขา</label>							
							<div class="label span4 text-left">&nbsp;</div>
						</div>
					
					</div>
					
				</div>
			</div>
			
			<div class="panel" data-role="panel" style="width: 1250px; margin-bottom: 10px;">
				<div class="panel-header bg-lightBlue fg-white" style="font-size: 0.9em;"><i class="icon-user-3 on-left"></i> LOGS</div>
				<div class="panel-content" style="display: block;">
					<div class="grid">
						<div class="row">
						
							<div class="span12" style="margin-left: 10%;"> 
								<div class="input-control text span2" style="margin-left: 20px;"> 
									<label>Branch : </label> 
									<input id="branch_code" name="branch_code" type="hidden" value="">
									<input value="" disabled="disabled"> 
								</div> 
								<div class="input-control text span2" style="margin-left: 20px;"> 
									<label>RM : </label> 
									<input id="rmname" name="rmname" type="hidden" value="">
									<input type="text" value="" disabled="disabled"> 
								</div> 	
								<div class="input-control text span2" style="margin-left: 20px;"> 
									<label>CUSTOMER : </label> 
									<input id="cust_name" name="cust_name" type="hidden" value="" disabled="disabled">
									<input type="text" value="" disabled="disabled"> 
								</div> 
								<div class="input-control text span3" style="margin-left: 20px;"> 
									<label>TRACK BY : </label> 
									<label>UPDATE DATE : </label> 
									<input type="hidden"  value="" disabled="disabled"> 
								</div> 
								<div class="input-control text span3"> 
									<label>POINT : </label> 
									<label>TOTAL : </label> 
									<input type="hidden"  value="" disabled="disabled"> 
								</div> 
							</div> 
		
						</div>
					</div>
				</div>
			</div>	
			
			<form action="<?php echo site_url(''); ?>" method="post">
			<div class="panel" data-role="panel" style="width: 1250px; margin-bottom: 10px;">
				<div class="panel-header bg-lightBlue fg-white" style="font-size: 0.9em;"><i class="fa fa-hdd-o on-left"></i> ERROR LIST</div>
				<div class="panel-content" style="display: block;">
					<center id="objErrorProgress"><img src="<?php echo base_url('img/loading.gif'); ?>" style="text-align:center"></center>
					<div id="parent_errorlist" style="border: 1px solid #D1D1D1; padding: 10px;"></div>	
				</div>
			</div>
			</form>
				
        </div>
    </div>
</div>


<script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>
<script src="<?php echo base_url('js/metro/metro.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/src/jquery.multiselect.min.js'); ?>"></script>
<script>

$(function() {

	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

	var progress 		= $('#objErrorProgress');
	var parent_errlist	= $('parent_errorlist');

	progress.hide();
	/*
	
	$.ajax({
   	  url: pathFixed+'dataloads/getMasterErrorCategory?_=' + new Date().getTime(),
   	  type: "GET",
      beforeSend:function() {
    	  progress.show();
      },
      success:function(data) {

          	for(var indexed in data) {
          		$('#parent_errorlist').append(
          		'<div class="grid">'+
				'<div class="row">'+
				'<div class="span12">' +
					'<h4>' + data[indexed]['Category'] + '</h4>' +
					'<div id="obj' + data[indexed]['Cat_ID'] + '"></div>' +
          	    '</div>' +
				'</div>' +
				'</div>');
          	} 
       		
      },
      complete:function() {
		  
    	  $.ajax({
    	   	  url: pathFixed+'dataloads/getMasterErrorList?_=' + new Date().getTime(),
    	   	  type: "GET",
    	      beforeSend:function() {
    	    	  progress.show();
    	      },
    	      success:function(data) {

    	          	for(var indexed in data) {
						
    	          		$('#obj' + data[indexed]['Cat_ID']).append(
    					'<div class="input-control checkbox span8" style="margin-left: 25px; margin-top: 10px; clear: both;">' +
	    					'<label>'+
		    					'<input name="ErrorList[]" type="checkbox" value="' + data[indexed]['Sub_Code'] + '" />'+
		    					'<span class="check"></span>'+ data[indexed]['Sub_Cat'] +
	    					'</label>'+
    	          	    '</div>');
    	          	    
    	          	} 
    	       		
    	      },
    	      complete:function() {
    	    	  progress.after(function() { $(this).hide(); });

    	      },
    	      cache: true,
    	      timeout: 5000,
    	      statusCode: {
    		  	 404: function() {
    		  		 alert( "page not found." );
    		  	 },
    		  	 407: function() {
    		  		 console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
    		  	 },
    		  	 500: function() {
    		  	 	 console.log("internal server error.");
    		     }
    	      }
    	     
    	  });
          
      },
      cache: true,
      timeout: 5000,
      statusCode: {
	  	 404: function() {
	  		 alert( "page not found." );
	  	 },
	  	 407: function() {
	  		 console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
	  	 },
	  	 500: function() {
	  	 	 console.log("internal server error.");
	     }
      }
     
  });
  */

  $('#objSubmit').bind('click', function() {
	  var error_list_checkbox    = $('input[name^="ErrorList"]:checked').map(function() {return $(this).val();}).get();
	  console.log(JSON.stringify(error_list_checkbox));

  });


  function closeWindow() {
  	  window.open('','_top','');
      window.close();
  }
	  

	  
	
});


</script>

</body>
</html>