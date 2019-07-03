<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PCIS - ERR TRACKING</title>
    <meta name="description" content="<?php echo !empty($desc) ? $desc:''; ?>">
    <meta name="viewport" content="<?php echo !empty($viewport) ? $viewport:''; ?>">
    <meta name="keywords" content="<?php echo !empty($keyword) ? $keyword:''; ?>">
    <meta name="author" content="<?php echo !empty($author) ? $author:''; ?>">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/tcrbank.ico'); ?>" type="image/x-icon">

    <link href="<?php echo base_url('css/jquery-ui/ui-lightness/jquery-ui-1.8.20.custom.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/metro/metro-bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/metro/metro-bootstrap-responsive.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/metro/iconFont.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/custom/app_progress.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/animate/animate.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/pikaday.css'); ?>" rel="stylesheet" >
    <link href="<?php echo base_url('css/vendor/jquery.multiselect.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/floatmenu/contact-buttons.css'); ?>" rel="stylesheet">
    <style>

        .line_horizon {
            display: inline;
        }

    </style>
</head>
<body  class="metro">
<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<?php 

$auth_manage = $_GET['manage'];
if($auth_manage == md5('true')) {
	$auth_viewer = 'display: block;';	
	$lock_auth	 = '';
} else if($auth_manage == md5('false')) {
	$auth_viewer = 'display: none;';
	$lock_auth	 = 'disabled="disabled"';
}

$lock_field = !empty($auth_viewer) ? $auth_viewer:'';

?>

 <div class="listview" style="position: fixed; margin-top: 20px;">
 	   <div class="list" style="max-width: 145px;" onclick="javascript:window.open('','_self').close();">
        <div class="list-content">
           <i class="icon icon-exit" style=" -ms-transform: rotate(180deg); -webkit-transform: rotate(180deg); transform: rotate(180deg);"></i>
            <div class="data">
               <span class="list-title" style="margin-top: 20px; font-weight: 700;">CLOSE</span>
            </div>
        </div>
    </div>
    <?php 
    
    //if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' || in_array('074008', $session_data['auth'])) {
    
    	$auth_defend = $this->config->item('DefendTeam');
    	$authority_emp = array('60424', '50072', '56680', '56465', '57171', '56650', '58051', '57251', '58080', '56225', '57301', '601015');
    	if(in_array($session_data['emp_id'], $authority_emp) || in_array($session_data['emp_id'], $auth_defend)) {
    		
    		$option_menu = '';
    		if(in_array($session_data['emp_id'], $auth_defend) || in_array($session_data['emp_id'], array('57251'))) {
    			if($getTrackerList['Completed'] == 'Y' || (int)$getTrackerList['Point'] > 0) {
    				$option_menu = '
					<div id="objRecreate" class="list" style="max-width: 145px; '.$lock_field.'">
				        <div class="list-content">
				           <i class="icon icon-loop"></i>
				            <div class="data">
				               <span class="list-title" style="margin-top: 20px; font-weight: 700;">RESET</span>
				            </div>
				        </div>
				     </div>';
    			}
    			
    		}
    		
    		echo '<div id="objEdit" class="list" style="max-width: 145px; '.$lock_field.'">
		         <div class="list-content">
		             <i class="icon icon-pencil"></i>
		             <div class="data">
		                 <span class="list-title" style="margin-top: 20px; font-weight: 700;">EDIT</span>
		             </div>
		         </div>
		     </div>
		     <div id="objSubmit" class="list" style="max-width: 145px; '.$lock_field.'">
		        <div class="list-content">
		           <i class="icon icon-floppy"></i>
		            <div class="data">
		               <span class="list-title" style="margin-top: 20px; font-weight: 700;">SUBMIT</span>
		            </div>
		        </div>
		     </div>' . $option_menu;
    		
    	}
    
    //}
    
    if($getTrackerList['Completed'] == 'Y') {
    	    	
   		$authCheck = array('57251', '56225');
    	if(in_array($session_data['emp_id'], $authCheck)) {
    		$check_locked = '';
    	} else {
    		$check_locked = 'disabled="disabled"';
    	}    	
    	
    }
    
    if($auth_manage == md5('false')) {
    	
    	$lock_authority = !empty($lock_auth) ? $lock_auth:'';
    	$check_box		= !empty($getTrackerList['Completed']) ? 'checked="checked"':''; 
    	$visible_filed	= !empty($check_locked) ? $check_locked:'';
    	
    	echo '
    	<div id="approved_list" class="list" style="max-width: 145px;">
    	<label class="input-control checkbox" style="margin-left: 7px;">
			<input id="field_approved" name="field_approved" type="checkbox" value="Y" '.$lock_authority.' '.$visible_filed.' '.$check_box.'>
			<span class="check"></span><small style="color: blue; font-weight: bold;">ไม่พบข้อผิดพลาด</small>
		</label>
    	</div>	
    	';
    	
    }
    
    ?>
    
   
   
</div>



<nav class="vertical-menu compact" style="position: fixed; margin-top: 400px; z-index: 999;">
    <nav class="horizontal-menu button">
        <ul>
            <li>
                <a class="dropdown-toggle" href="#" style="text-decoration: none;">Find Category</a>
                <ul id="jump_category" style="display: none;" class="dropdown-menu text-left" data-show="hover" data-role="dropdown">
                    <li class="line_horizon">


                    </li>

                </ul>
            </li>
        </ul>
    </nav>
</nav>

<?php


echo "
    <script>	
		
        function scrollToElement(id) {
            $('html, body').animate({
                scrollTop: $('#' + id).offset().top
            }, 2000);
        }
		

		function getKPIPoint(element, ListID) {

		   var element_total = parseInt($('input[name^=\"ErrorList\"]').length);

		   if($('#' + element).is(':checked')) {
		
				var field_point  = $('#objPoint').val();
				var point_list   = $('#WB_List_' + ListID).val();
		
				var total		 = parseInt(field_point) + parseInt(point_list);
				var avg_total	 = ((total / element_total) * 100);
		
				$('#objPoint').val(total);
				$('#point_score').html(total);
				$('#total_avg').text(avg_total.toFixed(2));
		
		   } else {
				
				var field_point  = $('#objPoint').val();
				var point_list   = $('#WB_List_' + ListID).val();
		
				var total		 = parseInt(field_point) - parseInt(point_list);
				var avg_total	 = ((total / element_total) * 100);	
		
				$('#objPoint').val(total);
				$('#point_score, #point_score_template').html(total);
				$('#total_avg, #total_avg_template').text(avg_total.toFixed(2));
				

		   }

			
	    }
		
		
		
    </script>";

?>

<div class="container">
    <div class="grid">
        <div class="row bg-white">

            <!-- Document Reference -->
            <input id="doc_id" name="doc_id" type="hidden" value="<?php echo !empty($getCustInfo[0]['DocID']) ? $getCustInfo[0]['DocID']:$_GET['rel']; ?>">
            <input id="doc_ref" name="doc_ref" type="hidden" value="<?php echo !empty($getCustInfo[0]['IsRef']) ? $getCustInfo[0]['IsRef']:$_GET['rfx']; ?>">

            <!-- ACTOR USER -->
            <input id="actor_empid" name="actor_empid" type="hidden" value="<?php echo !empty($session_data['emp_id']) ? $session_data['emp_id']:""; ?>">
            <input id="actor_name" name="actor_name" type="hidden" value="<?php echo !empty($session_data['thname']) ? $session_data['thname']:""; ?>">
            
            <!-- KPI Point -->
        	
			<div class="panel" data-role="panel" style="width: 1250px; margin-bottom: 10px; margin-left: 10px;">
				<div class="panel-header bg-lightBlue fg-white" style="font-size: 0.9em;"><i class="icon-address-book on-left"></i> INFORMATION</div>
				<div class="panel-content" style="margin-bottom: 10px;">


                    <div class="input-control text size3">
                        <label>Branch : <?php echo !empty($getCustInfo['BranchName']) ? $getCustInfo['BranchName']:""; ?></label>
                        <input id="branch_by_fake" name="branch_by_fake" type="text" value="<?php echo !empty($getCustInfo['BranchTel']) ? $getCustInfo['BranchTel']:""; ?>" disabled="disabled">
                        <input id="branch_by" name="branch_by" type="hidden" value="<?php echo !empty($getCustInfo['BranchCode']) ? $getCustInfo['BranchCode']:""; ?>">
                    </div>
              
                    <div class="input-control text size3">
                        <label>Cust : <span id="custNameTruncate"><?php echo !empty($getCustInfo['BorrowerName']) ? $getCustInfo['BorrowerName']:"";  ?></span></label>
                        <input id="customer_by_fake" name="customer_by_fake" type="text" value="<?php echo !empty($getCustInfo['Mobile']) ? $getCustInfo['Mobile']:"";  ?>" disabled="disabled">
                        <input id="customer_by" name="customer_by" type="hidden" value="<?php echo !empty($getCustInfo['BorrowerName']) ? $getCustInfo['BorrowerName']:"";  ?>">
                        <input id="customer_type" name="customer_type" type="hidden" value="<?php echo !empty($getCustInfo['BorrowerType']) ? $getCustInfo['BorrowerType']:''; ?>">
                    </div>
					
                    <div class="input-control text size3">
                        <label>RM : <span id="rmnameTruncate"><?php echo !empty($getCustInfo['RMName']) ? $getCustInfo['RMName']:""; ?></span></label>
                        <input id="rm_by_fake" name="rm_by_fake" type="text" value="<?php echo !empty($getCustInfo['RMMobile']) ? $getCustInfo['RMMobile']:""; ?>" disabled="disabled">
                        <input id="rm_by" name="rm_by" type="hidden" value="<?php echo !empty($getCustInfo['RMCode']) ? $getCustInfo['RMCode']:""; ?>">
                    </div>

                    <div class="place-right" style="margin-top: 5px;">

                        <div class="input-control text size4">
                            <label><span class="size1 label fg-info" style="min-width: 90px;">Checker By </span>  <span id="track_actor"><?php echo !empty($getTrackerList['UpdateByName']) ? $getTrackerList['UpdateByName']:!empty($getTrackerList['CreateByName']) ? $getTrackerList['CreateByName']:""; ?></span></label>
                            <label><span class="size1 label fg-info" style="min-width: 90px;">Update Date </span>  <span id="track_date"><?php echo !empty($getTrackerList['UpdateDate']) ? $getTrackerList['UpdateDate']:!empty($getTrackerList['CreateDate']) ? $getTrackerList['CreateDate']:""; ?></span></label>
                            <input id="track_id" name="track_id" type="hidden" value="<?php echo !empty($getTrackerList['UpdateByID']) ? $getTrackerList['UpdateByID']:!empty($getTrackerList['CreateByID']) ? $getTrackerList['CreateByID']:""; ?>">
                            <input id="track_by" name="track_by" type="hidden" value="<?php echo !empty($getTrackerList['UpdateByName']) ? $getTrackerList['UpdateByName']:!empty($getTrackerList['CreateByName']) ? $getTrackerList['CreateByName']:""; ?>">
                            <input id="update_date" name="update_date" type="hidden" value="<?php echo !empty($getTrackerList['UpdateDate']) ? $getTrackerList['UpdateDate']:!empty($getTrackerList['CreateDate']) ? $getTrackerList['CreateDate']:""; ?>">
                        </div>
						
                        <div class="input-control text size3">
                            <label>
                            	<span class="size1 label fg-info" style="min-width: 130px;">Score Point</span> 
                            	<span id="point_score"><?php echo !empty($getTrackerList['Point']) ? $getTrackerList['Point']:0; ?></span>
                            	<input id="objPoint" name="objPoint" type="hidden" value="<?php echo !empty($getTrackerList['Point']) ? $getTrackerList['Point']:0; ?>">
                            </label>
                            <label>
                            	<?php 
                            		
                            		$score = !empty($getTrackerList['Point']) ? (int)$getTrackerList['Point']:0;
                            		if($score != 0):
                            			$total = (($score / (int)$getListRows) * 100);
                            		else:
                            			$total = 0;
                            		endif;
                            		
                            	
                            	?>
                            	<span class="size1 label fg-info" style="min-width: 130px;">KPI (น้อยกว่า 3%)</span> 
                            	<span id="total_avg"><?php echo !empty($total) ? number_format($total, 2):0; ?></span><span>%</span>
                            </label>
                        </div>
                    </div>


				</div>
			</div>
			
			<form action="<?php echo site_url(''); ?>" method="post">
			<div class="panel" data-role="panel" style="width: 1250px; margin-bottom: 10px; margin-left: 10px;">
				<div class="panel-header bg-lightBlue fg-white" style="font-size: 0.9em;"><i class="fa fa-hdd-o on-left"></i> ERROR LIST</div>
				<div class="panel-content" style="display: block;">
					<center id="objErrorProgress"><img src="<?php echo base_url('img/loading.gif'); ?>" style="text-align:center"></center>
					<div class="grid">
						<div class="row">
							<div id="parent_errorlist" style="border: 1px solid #D1D1D1; padding: 10px;">
		
		
							</div>
							<?php 
							
							if($auth_manage == md5('true')) {
								$lock_authority = !empty($lock_auth) ? $lock_auth:'';
								$check_box		= !empty($getTrackerList['Completed']) ? 'checked="checked"':'';
								$visible_filed	= !empty($check_locked) ? $check_locked:'';
								
								echo '
    							<div style="border: 1px solid #D1D1D1; padding: 10px;">
							    <label class="input-control checkbox" style="margin-left: 7px;">
									<input id="field_approved" name="field_approved" type="checkbox" value="Y" '.$lock_authority.' '.$visible_filed.' '.$check_box.'>
									<span class="check"></span><small style="color: blue; font-weight: bold;"> กรุณาคลิกเพื่อยืนยันข้อมูล กรณีตรวจสอบแล้วไม่พบข้อผิดพลาด.</small>
								</label>							
								</div>
    							';
								
							}
							
							?>
							
						</div>
						<div class="row place-right">
						<div class="input-control text size3" style="margin-top: 10px;">
							<h5 style="min-width: 130px; color: blue; text-decoration: underline; font-weight: bold;">Total Scroe</h5> 
			            	<label>
			                	<span style="min-width: 130px; font-weight: bold;">Score Point : </span> 
			                    <span id="point_score_template"><?php echo !empty($getTrackerList['Point']) ? $getTrackerList['Point']:0; ?></span>
							</label>
			                <label>       
			                	<?php 
                            		
                            		$score = !empty($getTrackerList['Point']) ? (int)$getTrackerList['Point']:0;
                            		if($score != 0):
                            			$total = (($score / (int)$getListRows) * 100);
                            		else:
                            			$total = 0;
                            		endif;
                            		
                            	
                            	?>               
			                    <span style="min-width: 130px; font-weight: bold;">KPI (น้อยกว่า 3%) : </span> 
			                  	<span id="total_avg_template"><?php echo !empty($total) ? number_format($total, 2):0; ?></span><span>%</span>
			                </label>
		            	</div>
		            	</div>
					</div>
				</div>
				
			</div>		
			</form>
			
			<article style="margin-left: 25px; margin-top: -10px;">
				<dl>
					<dt class="item-title">ความหมายของระดับความสำคัญ</dt>
					<dd><span class="label info">4</span>	เคสเข้าระบบไม่ได้</dd>
					<dd><span class="label info">3</span>	มีผลให้ DD ไม่ได้ หรือแฟ้มลงจาก CA ไม่ได้</dd>
					<dd><span class="label info">2</span>	ต้องส่งเอกสารตามหลังมา เช่น ส่งไปรษณีย์ ส่งอีเมลล์</dd>
					<dd><span class="label info">1</span>	สนญ.ช่วยเติมให้ได้</dd>
				</dl>				
			</article>
				
        </div>
    </div>
</div>


<script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.mousewheel.js'); ?>"></script>
<script src="<?php echo base_url('js/metro/metro.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
<script src="<?php echo base_url('js/vendor/jquery.truncate.min.js'); ?>"></script> 
<script src="<?php echo base_url('js/vendor/src/jquery.multiselect.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugin/floatmenu/jquery.contact-buttons.js'); ?>"></script>
<script>

$(function() {

	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    

    // Object Date
    var str_date;
    var objDate = new Date();
    str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear(); // Set Date format DD/MM/YYYY

	var progress 		= $('#objErrorProgress');
	var parent_errlist	= $('parent_errorlist');
	
	progress.hide();
	$.ajax({
   	  url: pathFixed+'dataloads/getDocumentCategoryList?_=' + new Date().getTime(),
   	  type: "GET",
      beforeSend:function() {
    	  progress.show();
      },
      success:function(data) {
		 
          for(var indexed in data) {
              $('#parent_errorlist').append(
                  '<div style="border: 1px solid #D1D1D1;">' +
                      '<button type="button" class="button large">' + data[indexed]['Doc_Category'] + '</button>' +
                      '<div id="TP_' + data[indexed]['Doc_CatID'] + '"></div>' +
                      '</div>'
              );

             // $('#jump_category').append('<li onclick="scrollToElement(\'TP_' + data[indexed]['Doc_CatID']+ '\');"><a href="#">' + data[indexed]['Doc_Category'] + '</div>');
             $('#jump_category > li').append('<div class="line_horizon" ><button onclick="scrollToElement(\'TP_' + data[indexed]['Doc_CatID']+ '\');" type="button" class="button" style="margin: 3px;">' + data[indexed]['Doc_Category'] + '</button></div>');


          }

      },
      complete:function() {

    	  $.ajax({
    	   	  url: pathFixed+'dataloads/getDocumentTrackList?_=' + new Date().getTime(),
    	   	  type: "GET",
    	      beforeSend:function() {
    	    	  progress.show();
    	      },
    	      success:function(data) {

    	          	for(var indexed in data) {
						
    	          		$('#TP_' + data[indexed]['Doc_CatID']).append(
    					'<div class="input-control checkbox size7" style="margin-left: 25px; margin-top: 10px; clear: both;">' +
	    					'<label>'+
		    					'<input id="CB_List_' + data[indexed]['ItemList'] + '" name="ErrorList[]" type="checkbox" value="' + data[indexed]['ItemList'] + '" onclick="getKPIPoint(\'CB_List_' + data[indexed]['ItemList'] + '\',' + data[indexed]['ItemList'] + ');" disabled="disabled">'+
		    					'<input id="WB_List_' + data[indexed]['ItemList'] + '" name="PointList[]" type="hidden" value="' + data[indexed]['Point'] + '">'+
		    					'<span class="check"></span>'+ data[indexed]['Document_List'] + ' (' + data[indexed]['Weight'] + ')' +
	    					'</label>'+
    	          	    '</div>');
    	          	    
    	          	}
    	       		
    	      },
    	      complete:function() {
    	    	  progress.after(function() { $(this).hide(); });  

    	    	  $.ajax({
    	    	        url: pathFixed+'dataloads/getActiveErrorList?_=' + new Date().getTime(),
    	    	        type: "POST",
    	    	        data: {
    	    				DocID: $('#doc_id').val(),
    	    				DocRef: $('#doc_ref').val()             	
    	    	        },
    	    	        beforeSend:function() {
    	    	            progress.show();
    	    	        },
    	    	        success:function(data) {
    	    	            
    	    	         	 if(data['data'][0]['DocID'] == '') {
    	    	             		 
    	    	             } else {
    	    	             	
    	    	             	  for(var indexed in data['data']) {
    	    	    	        	  $('input[name^="ErrorList"][value="' + data['data'][indexed]['ItemList_Error'] + '"]').prop('checked', true);
    	    	                  }
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

  $('#objRecreate').bind('click', function() {
	  if(confirm('กรุณายืนยันการรีเซ็ตข้อมูล')) {
		  var doc_id		= $('#doc_id').val();
		  var doc_ref		= $('#doc_ref').val();

		  $.ajax({
              url: pathFixed+'management/setResetErrorTracking?_=' + new Date().getTime(),
              type: "POST",
              data: {
					DocID: doc_id,
					DocRef: doc_ref                    	
              },
              beforeSend:function() {
                  progress.show();
              },
              success:function(data) {

              	var responsed = JSON.parse(data);                        	
					if(responsed['status'] == 'true') {
						var not = $.Notify({ content: 'บันทึกข้อมูลสำเร็จ กรุณารอสักครู่', style: { background: "green", color: "#FFFFFF" }, timeout: 10000 });
						not.close(7000);

						setTimeout(function() { 
							window.location.reload(false)
						}, 1000)  
						
					} else {
						var not = $.Notify({ content: 'ขออภัย!! เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่่.', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
						not.close(7000);  
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
		  
	  }
  });

  $('#objSubmit').bind('click', function() {
	  
     if(confirm('กรุณายืนยันการบันทึกข้อมูล')) {
          
           	var doc_id		= $('#doc_id').val();
           	var doc_ref		= $('#doc_ref').val();
           	var branch_code	= $('#branch_by').val();
           	var custname	= $('#customer_by').val();
           	var cust_type	= $('#customer_type').val();
           	var rm_code		= $('#rm_by').val();
           	var kpi_point	= $('#objPoint').val();
           	var tracker_id	= $('#track_id').val();
           	var tracker		= $('#track_by').val();
           	var updatedate	= $('#update_date').val();
           	var error_list  = $('input[name^="ErrorList"]:checked').map(function() {return $(this).val();}).get();

           	var field_checked = $('#field_approved:checked').val();

            if(error_list == "") {

                if(field_checked == 'Y') {

                	$.ajax({
                        url: pathFixed+'management/setErrorTrackList?_=' + new Date().getTime(),
                        type: "POST",
                        data: {
    						DocID: doc_id,
    						DocRef: doc_ref,
    						BranchCode: branch_code,
    						CustName: custname,
    						CustType: cust_type,
    						RMCode: rm_code,
    						KPIPoint: kpi_point,
    						Tracker_ID: tracker_id,
    						Tracker: tracker,
    						UpdateDate: updatedate,    						       
    						completed: field_checked,
    						ItemList: error_list                     	
                        },
                        beforeSend:function() {
                            progress.show();
                        },
                        success:function(data) {

                        	var responsed = JSON.parse(data);                        	
    						if(responsed['status'] == 'true') {
    							var not = $.Notify({ content: 'บันทึกข้อมูลสำเร็จ', style: { background: "green", color: "#FFFFFF" }, timeout: 10000 });
    							not.close(7000);  
    						} else {
    							var not = $.Notify({ content: 'ขออภัย!! เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่่.', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
    							not.close(7000);  
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
            

                } else {

                	 var not = $.Notify({ content: "กรุณาเลือกรายการที่เกิดข้อผิดพลาด อย่างน้อย 1 รายการ หรือ ยืนยันกรณีไม่พบข้อผิดพลาด.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
                     not.close(8000);

                }
				
            } else {

            	 if(field_checked == 'Y') {

            		 var not = $.Notify({ content: "ขออภัย, ท่านเลือกรายการข้อผิดพลาดและเลือกยืนยันรายการไม่พบข้อผิดพลาด กรุณาตรวจสอบข้อมูลใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 15000 });
                     not.close(12000);

                 } else {

                	 $.ajax({
                         url: pathFixed+'management/setErrorTrackList?_=' + new Date().getTime(),
                         type: "POST",
                         data: {
     						DocID: doc_id,
     						DocRef: doc_ref,
     						BranchCode: branch_code,
     						CustName: custname,
     						CustType: cust_type,
     						RMCode: rm_code,
     						KPIPoint: kpi_point,
     						Tracker_ID: tracker_id,
     						Tracker: tracker,
     						UpdateDate: updatedate,
     						completed: field_checked,
     						ItemList: error_list                   	
                         },
                         beforeSend:function() {
                             progress.show();
                         },
                         success:function(data) {
                        	
                         	var responsed = JSON.parse(data);
     						if(responsed['status'] == 'true') {
     							var not = $.Notify({ content: 'บันทึกข้อมูลสำเร็จ', style: { background: "green", color: "#FFFFFF" }, timeout: 10000 });
     							not.close(7000);  
     						} else {
     							var not = $.Notify({ content: 'ขออภัย!! เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่่.', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
     							not.close(7000);  
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
                 	 

                 }

            }

           return true;
	
      }

	  return false;
	
  });

  $('#objEdit').bind('click', function() {

     var actor_name = $('#actor_name').val();
     var actor_id   = $('#actor_empid').val();
     $('input[name^="ErrorList"]').removeAttr('disabled');
     //$('#field_approved').removeAttr('disabled');

     $('#track_actor').text(actor_name);
     $('#track_date').text(str_date);

     $('#track_id').val(actor_id);
     $('#track_by').val(actor_name);
     $('#update_date').val(str_date);
   
  });

  $('#custNameTruncate, rmnameTruncate').truncate({
      width: '140',
      token: '…',
      side: 'right',
      addtitle: true
  });

  $('#field_approved').click(function() {

	  var actor_name = $('#actor_name').val();
	  var actor_id   = $('#actor_empid').val();
	  var elements 	 =  $('#field_approved').is(':checked');
	
	  if(elements) {
		  	$('#track_id').val(actor_id);
		    $('#track_by').val(actor_name);
		    $('#update_date').val(str_date);

		    $('#track_actor').text(actor_name);
		    $('#track_date').text(str_date);
		    
	  } else {
		  $('#track_id').val('');
		  $('#track_by').val('');
		  $('#update_date').val('');

		  $('#track_actor').text('');
		  $('#track_date').text('');
	  		
	  }

  });

  function closeWindow() {
  	  window.open('','_top','');
      window.close();
  }

	
});


</script>

</body>
</html>