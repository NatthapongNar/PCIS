<!DOCTYPE html>
<html>
<head ng-app>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Defend List</title>
    <meta name="description" content="<?php echo $desc; ?>">    
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes">

    <link rel="icon" href="<?php echo base_url('img/tcrbank.ico'); ?>" type="image/x-icon"> 
   
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/responsive.css'); ?>">  
 	<link rel="stylesheet" href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/themify-icons.css'); ?>">  
 	<link rel="stylesheet" href="<?php echo base_url('css/flaticon/flaticon.css'); ?>"> 	    
 	<link rel="stylesheet" href="<?php echo base_url('css/custom/wp.custom.css'); ?>">	
 	<link rel="stylesheet" href="<?php echo base_url('css/notifIt/notifIt.css'); ?>">
 	<link rel="stylesheet" href="<?php echo base_url('css/webui-popover/jquery.webui-popover.css'); ?>">  		
 	<link rel="stylesheet" href="<?php echo base_url('css/summernote/summernote.css'); ?>"> 
 	<link rel="stylesheet" href="<?php echo base_url('js/plugin/filer/css/jquery.filer.css'); ?>"> 
 	<link rel="stylesheet" href="<?php echo base_url('css/notify/notify-effect/animate.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/notify/notify-effect/animated-notifications.css'); ?>">	
	<link rel="stylesheet" href="<?php echo base_url('css/metro/metro-bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/metro/iconFont.min.css'); ?>">
	
 	<style type="text/css">
 		
 		textarea {
 			min-height: 200px;
 		}
 		
 		.pre_text { 			
		    padding: 9.5px;
		    margin: 0 0 10px;
		    font-size: 13px;
		    line-height: 1.42857143;
		    color: #333;
		    display: block;
		    word-break: break-all;
		    word-wrap: break-word;
		    background-color: #f5f5f5;
		    border: 2px dotted #ccc;
		    border-radius: 4px;
 		}
 		
 		.easePadding { padding: 0; }
 		.fontNornmal { font-weight: normal !important; } 
 		.panel-heading { font-weight: bold; }
 		
 		.actorTriggers { display: none; }
 		div#notifications-full { z-index: 999; }
 		#overlay {
			  position:absolute;
			  margin:auto;
			  top:0; 
			  left:0;
			  width:100%; 
			  height:100%;
			  z-index: 500;			
			  background-color:black;			  
			  filter:alpha(opacity="70");
			  MozOpacity:0.7;
			  KhtmlOpacity:0.7;
			  opacity:0.7;			  
			  visibility:hidden;
		}
		
		.img_fixed {			
			height: 80px; 
			width: 80px; 
			margin-left: 10px;  
			cursor: pointer;
		}
		
		.onbinder { opacity: 0.5; }
		
		.panel, .panel-heading { border-radius: 0; }
		
		.menu_default:hover {
		   -webkit-transform: scale(1.1, 1.1);
		   -moz-transform: scale(1.1, 1.1);
		   -ms-transform: scale(1.1, 1.1);
		   -o-transform: scale(1.1, 1.1);
		   transform: scale(1.1, 1.1);
		}
		
		.link_no:hover { 
		   -webkit-transform: scale(1.3, 1.3);
		   -moz-transform: scale(1.3, 1.3);
		   -ms-transform: scale(1.3, 1.3);
		   -o-transform: scale(1.3, 1.3);
		   transform: scale(1.3, 1.3);
		   text-decoration: none;
		}		
		
		/* webui-popover */
		.webui-popover { 
			padding: 0px !important;
			border-radius: 0px !important;  
		}
		
		.webui-popover .webui-popover-content {
			padding: 0px 14px !important;
		}
		
		/* Hack metro design for other icon */
		.metro .titlecustom {
			position: relative;
		    overflow: hidden;
		    display: block;
		    float: left;
		    margin-right: 10px;
		}
		
		.titlecustom.custom_half { width: 55px; height: 55px; }
		
		.metro .titlecustom .tile-contents {
		    width: 100%;
		    height: 100%;
		    padding: 0;
		    margin: 0;
		    display: block;
		    position: absolute;
		    left: 0;
		    top: 0;
		    overflow: hidden;
		}
		
		.metro .titlecustom .tile-contents:first-child {
		    display: block;
		    padding-top: 7px;
		}
		
		.iconcustom {
			line-height: 37.33333333px;
		    height: 37.33333333px;
		    width: 37.33333333px;
		    font-size: 32px;
		    color: #fff;
		    text-align: center;
		    position: absolute;
		    left: 50%;
		    top: 50%;
		   
		}
		
		.iconcustom [class*="ti-"] {
			speak: none;
		    font-style: normal;
		    font-weight: normal !important;
		    font-variant: normal;
		    text-transform: none;
		    text-decoration: inherit;
		    line-height: 1;
		    display: inline-block;
		    vertical-align: -8%;
		    -webkit-font-smoothing: antialiased;
		}
		
		.titlecustom:hover {
		   	outline: #999999 solid 3px;
		}
		
		.jFiler-theme-default .jFiler-input { width: 565px !important;  }
		 .filereader { background: #EAEAEA !important; }

 	</style>
 	<style type="text/css" media="print">	
 	
		.nonprint { display: none; }
		.btn { 
			display: none !important;
			height: auto;
			min-height: 100%;
			overflow-y: hidden;
			margin-top: -20px;
		}
		
		.note-toolbar { display: none !important; }
	
		@media print {
		
			body { font-size: 12px; }
		
			.panel-primary > .panel-heading {
			    background-color: #3070a9 !important;
			    color: #FFF;
			    -webkit-print-color-adjust: exact; 
			}
			
			.panel-success > .panel-heading {
			    background-color: #D7ECCE !important;
			    color: #FFF;
			    -webkit-print-color-adjust: exact; 
			}
			
			.panel-danger > .panel-heading {
			    background-color: #EED5D5 !important;
			    color: #FFF;
			    -webkit-print-color-adjust: exact; 
			}
			
			.actorTriggers { 
				display: block; 
				font-size: 0.9em;
				font-weight: normal;
			}
			
		}
		
		.panel-primary .panel-body { 
			padding: 5px 0; !important;
			font-size: 0.8em !important; 
		}
		
		
		.panel-body { padding-bottom: 30px; }
		
	</style>	
<script src="<?php echo base_url('js/vendor/jquery.2.1.4.min.js'); ?>"></script>
<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugin/summernote/summernote.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugin/webui-popover/jquery.webui-popover.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugin/notifIt/notifIt.js'); ?>"></script>
<script src="<?php echo base_url('js/plugin/filer/js/jquery.filer.min.js'); ?>"></script>
<script src="<?php echo base_url('js/build/doc_management/defend_trash.js'); ?>"></script>
<script>

$(document).ready(function() {

	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
	var query  = getQueryParams(document.location.search);

	 // Object Date
    var str_date;
    var objDate = new Date();
    str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
    

	var borrower_name = $('#borrower_nametext').text();
	$('title').text('Defend - ' + borrower_name);

	$("#print_area").click(function() { 
		var application_status = $('#app_status').val();
		$('title').text('Defend: ' + borrower_name + ' (' + application_status + ')');
		window.print();
	});

    $('#objrefresh').bind('click', function() { document.location.reload(true); });
    $('#fa_refresh').mouseover(function() { $(this).addClass('fa-spin'); });
    $('#fa_refresh').mouseout(function() { $(this).removeClass('fa-spin'); });

    var check_branch = $('#branch_code').val();
    /*
 	if(check_branch == '228') {
 		 $('#label_bm').text('ชัยนันท์ สิทธิวงศ์');
 		 $('#bmmobile').text('0935141459');
 	}
	*/
	
 	$('#defend_supplement_template').summernote('destroy');

 	var ilock = 1;
 	$('.textarea').each(function() {
 		$('#template_reason_' + ilock).summernote('destroy');
 		ilock++;
 	});
 	
 	$('#btn_Save').on('click', function() {
 		if(confirm('ยืนยันการบันทึกข้อมูลหรือไม่')) { return true; }
 		return false;
 	});

 	var branch_code = $('#actor_branch').val();
 	var center = 
 	 	'<div id="notifications-full">' +
	 	 	'<div id="notifications-full-close" class="close" onclick=\"$(\'#overlay\').css({ visibility:\'hidden\' });\">' +
	 	 		'<i class="fa fa-close" style=\"color: #000;\"></i>' +
	 	 	'</div>' +
	 	 	'<div id="notifications-full-icon">' +
	 	 		'<i id="notification-icons" class="fa fa-bell animated swing" style="color: #FFD119;"></i></div>' +
	 	 	'<div id="notifications-full-text">' +
	 	 		'<div class="form-group text-center">' + 
	 	 			'<h4 class="marginLeft5 marginTopEasing5">DEFEND ALERT</h4>' +
		 	 		'<label class="control-label text-info">กรุณาเลือกข้อมูลของผู้ดูแลเคส.</label>' +
			 	 	'<select id="select_defendname" name="select_defendname" class="form-control" style="width: 300px; margin-left: 15%;">' +
						'<option value=""></option>' +
						<?php 
						
							if(!empty($getSFEDataList[0]['EmployeeCode'])) {
								
								$pass = $this->config->item('Administrator');
								foreach ($getSFEDataList as $index => $values) {
									
									if(in_array($getSFEDataList[$index]['EmployeeCode'], $pass)) {
										continue;
									} else {
										
										$select_list  = '';
										$defend_owner = !empty($getSFEActor['data'][0]['DefendEmpID']) ? $getSFEActor['data'][0]['DefendEmpID']:"";
										if($defend_owner == $getSFEDataList[$index]['EmployeeCode']):
											$select_list = 'selected="selected"';
										else:
											$select_list = '';
										endif;
										
										echo '\'<option value="'.$getSFEDataList[$index]['EmployeeCode'].'" '.$select_list.'>'.$getSFEDataList[$index]['FullNameTh'].'</option>\' +';
									}
				
								}												
							
							}
						
						?>
					'</select>' +
					'<span id="msg_warning" class="text-danger col-md-12" style="font-size: 0.9em;"></span>' +
					'<button id="btnAccept" type="button" class="btn btn-primary marginTop5">Accept</button>' +
				'</div>' +
	 	 	'</div>' +
		'</div>';

 	if(branch_code === "000" || branch_code === "999") {
		var defend_name = $('#defendEmpID').val();
		if(defend_name === "") {
			$("body").append(center);
			$("#notifications-full").addClass('animated bounceIn');
			showOverlay();
			refresh_close();
		} 	 	

 	}
 
 	$('#btnAccept').click(function() {
 	 	var actor_name		  = $('#actor_name').val();
		var select_defend_id  = $('select[name="select_defendname"] option:selected').val();
		var select_defendname = $('select[name="select_defendname"] option:selected').text();
		if(select_defend_id == "" && select_defendname == "") {
			$('#msg_warning').text('ขออภัย!! กรุณาเลือกข้อมูลผู้ดูแลเคส.');
		} else {

			$('#defendEmpID').val(select_defend_id);
			$('#defendEmpName').val(select_defendname);
			$('#assignmentBy').val(actor_name);	
			$('#assignmentDate').val(str_date);			
			$('#defendname_area').text(select_defendname);

			$('#msg_warning').text('');

			$('#overlay').css({ visibility:'hidden' });
			$('#notifications-full').fadeOut(200);
			
		}
 	});

 	function refresh_close(){
 		$('.close').click(function(){$(this).parent().fadeOut(200);});
 		
 	}
 	refresh_close();
 	
 	function showOverlay() {
 		  var body = document.getElementsByTagName('body')[0]
 		  var overlay = document.getElementById('overlay')
 		  overlay.style.height=body.offsetHeight+"px"
 		  overlay.style.width=body.offsetWidth+"px"
 		  overlay.style.visibility="visible"
 	}

	function getQueryParams(qs) {
        qs = qs.split("+").join(" ");

        var params = {}, tokens,
            re = /[?&]?([^=]+)=([^&]*)/g;

        while (tokens = re.exec(qs)) {
            params[decodeURIComponent(tokens[1])]
                = decodeURIComponent(tokens[2]);
        }

        return params;
    }
	
	$('[data-toggle="tooltip"]').tooltip(); 
	 
});



</script>
</head>
<body>

<div id="overlay"></div>
<div class="container">
	<div class="row">
	
		<?php $this->load->helper('form'); ?>
		<?php $attributes = array('id' => 'defend_form'); ?>
	    <?php echo form_open('defend_control/setDefendInitialyzeForm', $attributes); ?>
		<?php $DocID = !empty($getDefendList[0]['DocID']) ? $getDefendList[0]['DocID']:$_GET['rel']; ?>
		
		<div class="btn-group marginTop20 marginBottom10" role="group" style="width: 100%;">
				    
		
		    <div class="metro nonprint">	
	
				<?php if($_GET['whip'] == 'true' && $_GET['enable'] == 'true'): ?>		
		    	<div id="menu_p2" class="tile half bg-darkCyan menu_default" data-toggle="tooltip" data-placement="bottom" title="Go to Process 2" onclick="javascript:window.open('<?php echo site_url('management/getDataVerifiedPreview').'?_='.date('s').'&rel='.$DocID.'&req=P2&live=1'; ?>', '_blank');">
				    <div class="tile-content icon">
				       <div class="text-right ntp">
	                        <h5 class="fg-white no-margin">P2</h5>
                    	</div>
                    	<i class="icon-enter"></i>
				    </div>
				</div>			
		   
		    	<div id="print_area" data-toggle="tooltip" data-placement="bottom" title="Print" class="titlecustom custom_half bg-darkPink menu_default">
				    <div class="tile-contents iconcustom">
				        <i class="ti-printer"></i>
				    </div>
				</div>	
	   			
				<div class="tile half bg-amber onbinder">					
				    <div class="tile-content icon">		    	
				        <i class="icon-mail-2"></i>
				    </div>
				</div>
				
				<div class="tile half bg-darkRed onbinder">
				    <div class="tile-content icon">
				        <i class="icon-file-pdf"></i>
				    </div>
				</div>	
				
				<?php 
				
				if(in_array($session_data['emp_id'], $getSFEList)) {
								
					echo '
    				<div style="height: 55px; width: 5px; background: #999999; float: left; opacity: .4;"></div>
 
					<div id="defend_remove" class="titlecustom custom_half bg-teal menu_default marginLeft10" data-toggle="tooltip" data-placement="bottom" title="Remove">
					    <div class="tile-contents iconcustom">
					        <i class="ti-trash"></i>
					    </div>
					</div>';
					
				}
								
				?>
				
				<?php endif; ?>
				
		    </div>
		   
		    
		    <?php 
		    		    	
		     	if(empty($getDefendHelper['data'][0]['DocID'])) :
		     	
		     	else:
		     	
			     	if($_GET['whip'] == 'true' && $_GET['enable'] == 'true'):
			     		$height_fix = ' marginTop30';
			     	else:
			     		$height_fix = ' marginBottom10';
			     	endif;
		     		
		     		
		     		$down_grade = (int)count($getDefendHelper['data']);		     		
		     		for($i = count($getDefendHelper['data']) -1; $i >= 0; $i--) {
		     			
		     			if((int)$getDefendHelper['data'][$i]['DefendRef'] == $_GET['lnx']):
		     				$active = '#2f659c';
		     			else:
		     				$active = '#999';
		     			endif;
		     			
		     			echo '<a class="link_no nonprint pull-right '.$height_fix.'" href="'.site_url('defend_control/getIssueReasonList').'?rel='.$getDefendHelper['data'][$i]['DocID'].'&lnx='.$getDefendHelper['data'][$i]['DefendRef'].'&whip='.$_GET['whip'].'&enable='.$_GET['enable'].'&editor='.$_GET['editor'].'&clw=false">
		     				  <span style="padding: 5px 10px; background: '.$active.'; color: #FFF; border-radius: 50%; margin-left: 10px; font-weight: bold;">
		     				  '.$down_grade.'
    						  </span>
		     				  </a>';
		     			
		     			$down_grade--;
		     			
		     		}
		     		
		     		echo '<span class="nonprint pull-right '.$height_fix.'" style="font-weight: bold; font-size: 1.1em;">ครั้งที่ : </span>';
	     			
		     	endif;		     	

		    ?>
		    
		</div>
		
		
		<div class="panel panel-primary marginTopEasing10">
			<div class="panel-heading">DEFEND INFORMATION</div>
			<div class="panel-body">
			
				<div class="col-md-12 marginBottom5">
					<div class="col-xs-3 col-md-3 text-left easePadding">
						<label class="col-xs-12 col-md-12">LB :
							<span class="fontNornmal"><?php echo $getCustInfo['Branch']; ?></span>
						</label> 
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i>  
							<input id="branch_code" name="branch_code" type="hidden" value="<?php echo !empty($getCustInfo['BranchCode']) ? $getCustInfo['BranchCode']:""; ?>">
							<span class="fontNornmal"><?php echo !empty($getCustInfo['BranchTel']) ? $getCustInfo['BranchTel']:""; ?></span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left easePadding">
						<label class="col-xs-12 col-md-12">CUS : 
							<span id="borrower_nametext" class="fontNornmal"><?php echo !empty($getBorrower['BorrowerName']) ? $getBorrower['BorrowerName']:""; ?></span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i> 
							<span class="fontNornmal"><?php echo !empty($getBorrower['CustMobile']) ? $getBorrower['CustMobile']:""; ?></span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left easePadding">
						<label class="col-xs-12 col-md-12">DEF :
							<span id="defendname_area" class="fontNornmal">
								<?php echo !empty($getSFEActor['data'][0]['DefendEmpName']) ? $getSFEActor['data'][0]['DefendEmpName']:""; ?>								
							</span>
							<span>
								<?php 
				
									if(in_array($session_data['emp_id'], array('56365', '58360', '57251', '56225', '59389', '58360'))) {
										if(!empty($getSFEActor['data'][0]['DefendEmpName'])) {
											echo '<i class="fa fa-edit" style="cursor: pointer; margin-left: 5px;" onclick="getDefendMaintenace();"></i>';
											
										}
										
									}
									
								?>
							</span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i> 
							<span class="fontNornmal"><?php echo !empty($getSFEActor['data'][0]['Mobile']) ? $getSFEActor['data'][0]['Mobile']:""; ?></span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left easePadding">
						<label class="col-xs-12 col-md-12">CA : 
							<span class="fontNornmal"><?php echo !empty($getCustInfo['CAName']) ? $getCustInfo['CAName']:""; ?></span>
						</label> 
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i>  
							<span class="fontNornmal"><?php echo !empty($ca_info['data'][0]['Telephone']) ? $ca_info['data'][0]['Telephone']:""; ?></span>
						</label>
					</div>
				</div>
				
				<hr style="width: 100%;"></hr>
				
				<div class="col-md-12 marginTopEasing10">
					<div class="col-xs-3 col-md-3 text-left easePadding">
						<label class="col-xs-12 col-md-12"">RM : 
							<span class="fontNornmal"><?php echo !empty($getCustInfo['RMName']) ? $getCustInfo['RMName']:""; ?></span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i>  
							<span class="fontNornmal"><?php echo !empty($getCustInfo['RMMobile']) ? $getCustInfo['RMMobile']:""; ?></span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left easePadding">
						<label class="col-xs-12 col-md-12">BM : 
							<span id="label_bm" class="fontNornmal"><?php echo !empty($getBMInfo[0]['FullNameTh']) ? $this->effective->get_chartypes($char_mode, $getBMInfo[0]['FullNameTh']):""; ?></span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i> 
							<span id="bmmobile" class="fontNornmal"><?php echo !empty($getBMInfo[0]['Mobile']) ? $getBMInfo[0]['Mobile']:""; ?></span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left easePadding">
						<label class="col-xs-12 col-md-12">AM : 
							<span class="fontNornmal"><?php echo !empty($getAMInfo[0]['FullNameTh']) ? $this->effective->get_chartypes($char_mode, $getAMInfo[0]['FullNameTh']):""; ?></span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i> 
							<span class="fontNornmal"><?php echo !empty($getAMInfo[0]['Mobile']) ? $getAMInfo[0]['Mobile']:""; ?></span>
						</label>
					</div>
					<div class="col-xs-3 col-md-3 text-left easePadding">
						<label class="col-xs-12 col-md-12">RD : 
							<span class="fontNornmal"><?php echo !empty($getRDInfo[0]['FullNameTh']) ? $this->effective->get_chartypes($char_mode, $getRDInfo[0]['FullNameTh']):""; ?></span>
						</label>
						<label class="col-xs-12 col-md-12"><i class="flaticon flaticon-phone21" style="margin-left: -18px;"></i>  
							<span class="fontNornmal"><?php echo !empty($getRDInfo[0]['Mobile']) ? $getRDInfo[0]['Mobile']:""; ?></span>
						</label>
					</div>
				</div>
				
			</div>
			  
		</div>
		
		<div id="actor_information">
			<?php 
				$document_identity = !empty($getDefendList[0]['DocID']) ? $getDefendList[0]['DocID']:$_GET['rel']; 
				$document_ref	   = !empty($getDefendList[0]['DefendRef']) ? $getBMInfo[0]['DefendRef']:$_GET['lnx'];
				
				$action_today	= date('d/m/Y H:i:s');
				$editname 		= !empty($session_data['thname']) ? $session_data['thname']:"";
				
				$table_app		= $this->dbmodel->CIQuery("SELECT [Status] FROM ApplicationStatus WHERE DocID = '". $document_identity ."'");
				$app_status		= !empty($table_app['data'][0]['Status']) ? $table_app['data'][0]['Status']:'';
				
			?>			            	
            <input id="doc_id" name="doc_id" type="hidden" value="<?php echo $document_identity; ?>">
            <input id="defendref" name="defendref" type="hidden" value="<?php echo $document_ref; ?>">
            	
            <input id="whip" name="whip" type="hidden" value="<?php echo !empty($_GET['whip']) ? $_GET['whip']:'true'; ?>">
            <input id="enable" name="enable" type="hidden" value="<?php echo !empty($_GET['enable']) ? $_GET['enable']:'true'; ?>">
            <input id="editor" name="editor" type="hidden" value="<?php echo !empty($_GET['editor']) ? $_GET['editor']:'true'; ?>">

            <input id="actor_empid" name="emp_id" type="hidden" value="<?php echo !empty($session_data['emp_id']) ? $session_data['emp_id']:""; ?>">
            <input id="actor_name" name="act_name" type="hidden" value="<?php echo !empty($session_data['thname']) ? $session_data['thname']:""; ?>">
            <input id="actor_branch" name="actor_branch" type="hidden" value="<?php echo !empty($session_data['branchcode']) ? $session_data['branchcode']:""; ?>">	            	
		
			<input id="defendEmpID" name="defendEmpID" type="hidden" value="<?php echo !empty($getSFEActor['data'][0]['DefendEmpID']) ? $getSFEActor['data'][0]['DefendEmpID']:""; ?>">
			<input id="defendEmpName" name="defendEmpName" type="hidden" value="<?php echo !empty($getSFEActor['data'][0]['DefendEmpName']) ? $getSFEActor['data'][0]['DefendEmpName']:""; ?>">
			
			<input id="assignmentBy" name="assignmentBy" type="hidden" value="<?php echo !empty($getSFEActor['data'][0]['AssignmentBy']) ? $getSFEActor['data'][0]['AssignmentBy']:""; ?>">
			<input id="assignmentDate" name="assignmentDate" type="hidden" value="<?php echo !empty($getSFEActor['data'][0]['AssignmentDate']) ? $getSFEActor['data'][0]['AssignmentDate']:""; ?>">
			<input id="app_status" name="app_status" type="hidden" value="<?php echo $app_status; ?>">
			
		</div>
		
		<!-- Boostrap Modal -->
		<div id="uploads_def" class="modal fade" tabindex="-1" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title">UPLOAD FILES</h4>
		      </div>
		      <div class="modal-body text-center">
				    <input id="filer_input_defend" name="files[]" type="file" multiple="multiple">				   
		      </div>
		      <div class="modal-footer" style="text-align: left;"><small class="text-muted">Upload By: Defend Team</small></div>
		    </div>
		  </div>
		</div>
		
		<!-- <span class="label label-danger text-warning nonprint marginTopEasing5" style="font-size: 1em !important;">คำแนะนำ: การอัพเดทข้อมูลใน Defend Note ควรเริ่มจากทำใส่ notepad ก่อน จากนั้นจึงคัดลอกข้อมูลมาเพื่ออัพเดทข้อมูลใน Defend Note เพื่อป้องกันข้อมูลศูนย์หาย.</span> -->
		<div class="panel panel-success marginTop5">
			<div class="panel-heading">
				ความเห็นจากทีม Defend/CA
				<span class="pull-right actorTriggers"></span>
				
				<div class="btn-group pull-right" role="group" style="margin-top: -7px !important;">
					<?php 
					
						$result_def_pdf = $this->dbmodel->CIQuery("
							SELECT RowID, DocID, NumRef, DefendRef, DefendCode, Files, File_Reference, [File_Name], Extension, CreateBy,
							CONVERT(NVARCHAR(10), CreateDate, 120) AS CreateDate,
			        		RIGHT(CONVERT(NVARCHAR(20), CreateDate, 113), 8) AS CreateTime, FileState
							FROM   DefendUploads
							WHERE DocID = '".$document_identity."'
							AND DefendRef = '".$document_ref."'
							AND DefendCode = 'SPE99'
							AND IsActive = 'A'
			        		ORDER BY CONVERT(NVARCHAR(20), CreateDate, 113) DESC");
						 
						if(!empty($result_def_pdf['data'][0]['DocID'])):
						
							$def_icon_identity = 'id="def_open_folder"';	
						
							$hq_amt = $this->dbmodel->CIQuery("
								SELECT COUNT(DocID) AS File_Amt FROM DefendUploads
								WHERE DocID = '".$document_identity."'
								AND DefendRef = '".$document_ref."'
								AND DefendCode = 'SPE99'
								AND IsActive = 'A'");
							
						else:
							$def_icon_identity = '';
						endif;
										
					?>
				
					<?php if($_GET['editor'] == 'true'): ?>	
					<button id="def_add_file" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Attach Files" onclick="def_enabledUpload();"><i class="fa fa-plus"></i></button>
					<?php endif; ?>	
					<button <?php echo $def_icon_identity; ?> type="button" class="btn btn-default show-pop def_elemental" data-toggle="tooltip" data-placement="top" title="All File">						
						<i class="fa fa-folder-open-o"></i>
						<span id="hq_amt" class="badge" style="position: absolute; margin-left: -10px; margin-top: -7px;"><?php echo !empty($hq_amt['data'][0]['File_Amt']) ? $hq_amt['data'][0]['File_Amt']:''; ?></span>
					</button>
							
				    <button id="btnSupplyHistory" type="button" class="btn btn-default show-pop" data-toggle="tooltip" data-placement="left" title="History" style="display: none;"><i class="fa fa-history"></i></button>
				    <?php if($_GET['editor'] == 'true'): ?>	
				    <?php if($session_data['branchcode'] == '000'): ?>
				    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="fnUnlockFieldOther()"><i class="fa fa-edit"></i></button>
				    <?php endif; ?>	
				    <?php endif; ?>	
				    			  
				</div>	
			</div>
			<div class="panel-body">

				<?php 				
					$doc_option		= '<div class="setDefText_'.date('Ymd').' pre_text" style="display: none;"><div>'. $action_today .' '. $editname .' :</div><br></div>';
					$doc_supplement = !empty($getDefendOther['data'][0]['DefendSupplement']) ? $this->effective->get_chartypes($char_mode, $getDefendOther['data'][0]['DefendSupplement']):""; 
				?>
		    	
		    	<div id="defend_supplement_template" style="width: 100%;"><?php echo $doc_option . $doc_supplement; ?></div>		    	
		    	<textarea id="defend_supplement_content" name="defend_supplement_content" style="width: 100%; display: none;" onchange="countChar(, $('#defend_supplement_template'))"><?php echo $doc_option . $doc_supplement; ?></textarea>
		    			    	
		    	<input id="editor_otherid" name="editor_otherid" type="hidden" value="">
		        <input id="editor_othername" name="editor_othername" type="hidden" value="">
		   		        
		        <div id="parent_supplementnote" style="display: none;">
		        <div style="padding: 10px 0; height: 500px; min-width:1050px; max-width:1050px; margin-top: -10px; font-size: 0.9em; display: block; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">
		    		<table class="table table-bordered">
						<thead>
							<tr style="background-color: #3175AF; color: #FFF;">
								<th width="5%" class="text-center">#</th>
								<th width="80%" class="text-center">DEFEND CONTENT</th>
								<th width="15%" class="text-center">DEFEND BY/DATE</th>
							</tr>
						</thead>
						<tbody>
							
							<?php 
								
								$supply_logs   = $this->dbmodel->CIQuery("
									SELECT 
									DocID, DefendRef, DefendLog.DefendCode, DefendReason, DefendOther,
									DefendNote, ActorBy, ActorName, DefendLog.IsActive, 
									CONVERT(NVARCHAR(10), ActorDate, 120) AS EventDate,
									SUBSTRING(CONVERT(VARCHAR(24), ActorDate, 120), 12, 5) AS EventTime
									FROM DefendSubscriptionLogs AS DefendLog
									LEFT OUTER JOIN MasterDefendReason AS DefendReason
									ON DefendLog.DefendCode = DefendReason.DefendCode
									WHERE DocID   = '".$document_identity."'
									AND DefendRef = '".$document_ref."'
									AND DefendLog.DefendCode = 'SPE99'
									ORDER BY ActorDate DESC	
								");
						
								if(!empty($supply_logs['data'][0]['DocID'])) {
									
									$i = 1;
									foreach ($supply_logs['data'] as $index => $values):
									
										if($supply_logs['data'][$index]['DefendCode'] == "OT999"):
											$option_reas = !empty($supply_logs['data'][$index]['DefendReason']) ? $this->effective->get_chartypes($char_mode, $supply_logs['data'][$index]['DefendReason']):'ความเห็นจากทีม DEF/CA';
											$reason_note = $option_reas. ' ' .$this->effective->get_chartypes($char_mode, $supply_logs['data'][$index]['DefendOther']);
										else:									
											$reason_note = !empty($supply_logs['data'][$index]['DefendReason']) ? $this->effective->get_chartypes($char_mode, $supply_logs['data'][$index]['DefendReason']):'ความเห็นจากทีม DEF/CA';
										endif;
										
										$data_note  = !empty($supply_logs['data'][$index]['DefendNote']) ? $this->effective->get_chartypes($char_mode, $supply_logs['data'][$index]['DefendNote']):'';
										$actor_by   = !empty($supply_logs['data'][$index]['ActorName']) ? $this->effective->get_chartypes($char_mode, $supply_logs['data'][$index]['ActorName']):'';
										$actor_date = !empty($supply_logs['data'][$index]['EventDate']) ? StandartDateRollback($supply_logs['data'][$index]['EventDate']). ' ' .$supply_logs['data'][$index]['EventTime']:'';
								
										echo "
			 							<tr>
			 								<td class=\"text-center\">$i</td>
								 			<td><b style=\"text-decoration: underline;\">$reason_note :</b> $data_note</td>
								 			<td class=\"text-center\">$actor_by <br/> ($actor_date)</td>
			 							</tr>";
									
										$i++;
										
									endforeach;
									
								} else {
									echo '<tr><td colspan="3" class="text-center">ไม่พบข้อมูล</td></tr>';
								}
							
							
							?>	
						
						</tbody>
					</table>
					</div>	
		        </div>
		       		       
		        <div id="parent_defend_upload" style="display: none; padding: 10px;">
		        	<div class="row" style="padding: 10px 0; height: 270px; margin-top: -10px; font-size: 0.9em; display: block; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">
		        	<ul id="defend_root_list" class="list-group">
		       		<?php 
			        	
			        	if(empty($result_def_pdf['data'][0]['DocID'])) {
			        	
			        		
			        	} else {

			        		$def_fileno = 1;
			        		foreach ($result_def_pdf['data'] as $index => $value):
			        		
			        			$file_ref	= $result_def_pdf['data'][$index]['RowID'];
			        			$re_file 	= $result_def_pdf['data'][$index]['File_Reference'];
				        		$filename 	= $this->effective->get_chartypes($char_mode, $result_def_pdf['data'][$index]['File_Name']);
				        		$uploaddate = !empty($result_def_pdf['data'][$index]['CreateDate']) ? 'Upload on : ' . $this->effective->StandartDateRollback($result_def_pdf['data'][$index]['CreateDate']):'';
				        		$uploadtime	= !empty($result_def_pdf['data'][$index]['CreateTime']) ? $result_def_pdf['data'][$index]['CreateTime']:'';
				        		$file_state = $result_def_pdf['data'][$index]['FileState'];
				        		
				        		$check_file = ($file_state == 'Y') ? 'filereader':'';
				        		
				        		echo " 							
								  <li id=\"file_listAt_$def_fileno\" class=\"list-group-item $check_file\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"Attach Files\">
    								
								  	<a href=\"".urldecode(base_url().'upload/'.$re_file)."\" target=\"_blank\" style=\"text-decoration: none; color: #000;\" onclick=\"defBindFile($file_ref, $def_fileno)\">
								  		<span style=\" margin-right: 5px;\"><i class=\"fa fa-file-pdf-o\" style=\"color: #BE0808; font-size: 2.6em;\"></i></span>
								  		<span style=\"float: right;\">							  		
								  		$filename <br/>
								  		$uploaddate $uploadtime
								  		</span>								  		
								  	</a>
								  	<span onclick=\"delete_fileInDef($file_ref, 'file_listAt_$def_fileno');\" style=\"z-index: 999; cursor: pointer; color: red; font-size: 1.5em; position: absolute; margin-top: -40px; margin-left: 82%;\">
								  		<i class=\"fa fa-minus-circle\"></i>
								  	</span>
								  	
								  </li>";
								
								  $def_fileno++;
								  		
			        		endforeach;

			        	}
			  	        
			        ?>		
			        </ul>
			        </div>
		        </div>
		        		 
		    	<?php 
		    	
		    		echo "
					<script>
					
						var pathRoot  = window.location.protocol + \"//\" + window.location.host;
						var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + \"//\" + window.location.host;
					    var pathFixed = window.location.protocol + \"//\" + window.location.host;
					    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += \"/\"; }
					    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += \"/\"; }	
					    var query  = getQueryParams(document.location.search);

					    var cache_time = new Date().getTime();
					    
						$('#def_open_folder').hover(function() {
							var html = $('#parent_defend_upload').html();
					    	$(this).webuiPopover({
					    		trigger:'click',	
					    		content: html,
					    		backdrop: false
					    	});
				
				   		}); 
		
						$('#btnSupplyHistory').hover(function() {
							var html = $('#parent_supplementnote').html()
					    	$(this).webuiPopover({
					    		trigger:'click',	
					    		content: html,
					    		backdrop: false,
					    		cache: false
					    	});
				
				   		}); 
				   		
				   		function TriggeredKey(e) {
							console.log(e);
						    var keycode;
						    if (window.event.keyCode = 13 ) return false;
						}
			   				
				   		function defBindFile(id, record_no) {
				  			
				   			$.ajax({
								  url: pathFixed + 'file_upload/fileReadState?_=' + new Date().getTime(),
					  	    	  data: { refx: id },
					  	          type: \"POST\",
					  	          beforeSend:function() { },
					  	          success:function(responsed) {				
					  	          
					  	          	 if(responsed['status'] == true) {				  	          		
						        		var list_item = 'file_listAt_' + record_no;
						        		$('.webui-popover').find('li[id=\"' + list_item + '\"]').addClass('filereader');						        
						        		
					  	          	 }
					  	          	
					  	          },
					  	          cache: false,
					  	          timeout: 5000,
					  	          statusCode: {
					  		  	        404: function() { alert( \"page not found.\" ); },
					  		  	        407: function() { console.log(\"Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )\"); },
					  		  	        500: function() { console.log(\"internal server error.\"); }
					  	          }				  		     
				  			});
				  			
				   		}
				   		
				   		function delete_fileInDef(ref_code, element_no) {
				   			
				   			if(confirm('ยันยันการลบไฟล์หรือไม่')) {
				   				
				   				$.ajax({
									  url: pathFixed + 'file_upload/fnDelete_files?_=' + new Date().getTime(),
						  	    	  data: { refx: ref_code },
						  	          type: \"POST\",
						  	          beforeSend:function() { },
						  	          success:function(responsed) {	
	  
						  	        	 if(responsed['status']) {
						        			$('#' + element_no).remove();
						        			console.log($('#' + element_no).remove());
						        			console.log($('#defend_root_list').parent());
						        			$('.webui-popover').removeClass('in').addClass('out');
						        			
							        		notif({
								 		    	msg: \"Delete Successfully.\",
								 		    	type: \"success\",
								 		    	position: \"right\",
								 		    	opacity: 1,
								 		    	width: 300,
								 		    	height: 50,
								 		    	autohide: true
								 			}); 
								 			
								 			
								 			var hq_amt  = $('#hq_amt').text();
								 			var cal_amt = parseInt(hq_amt) - 1;
								 			$('#hq_amt').text(cal_amt)
								 							 			
								 		 } else {
						        	
							        		notif({
								 		    	msg: \"Delete Failed. Please try again.\",
								 		    	type: \"error\",
								 		    	position: \"right\",
								 		    	opacity: 1,
								 		    	width: 300,
								 		    	height: 50,
								 		    	autohide: true
								 			}); 
	
							        	 }
	  	        	   	      
						  	          },
						  	          cache: false,
						  	          timeout: 5000,
						  	          statusCode: {
						  		  	        404: function() { alert( \"page not found.\" ); },
						  		  	        407: function() { console.log(\"Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )\"); },
						  		  	        500: function() { console.log(\"internal server error.\"); }
						  	          }
					  		     
					  			});
				   				
				   			
				   				return true;
				   			
				   			}
				   			
				   			return false;
				   			
				   		}
		
						$('#filer_input_defend').filer(
						{	
						    extensions: ['pdf', 'pptx', 'xlsx', 'docx'],
						    showThumbs: true,
							uploadFile: {
						        url: pathFixed + 'file_upload/setFileUploader?_=' + cache_time,
						        data: {
									rel: $document_identity,
									ref: $document_ref,
									cox: 'SPE99',
									pri: ''
								},
						        type: 'POST',
						        enctype: 'multipart/form-data',
						        beforeSend: function() {},
						        success: function(data, el) {
						
						        	if(data['status']) {
						        	
						        		notif({
							 		    	msg: \"Upload Successfully.\",
							 		    	type: \"success\",
							 		    	position: \"right\",
							 		    	opacity: 1,
							 		    	width: 300,
							 		    	height: 50,
							 		    	autohide: true
							 			}); 
							 			
							 			var id_defattribute = $('.def_elemental').attr('id');
							 			if(id_defattribute == undefined) {
							 				$('.def_elemental').attr('id', 'def_open_folder');
							 				
							 				$('#def_open_folder').hover(function() {
												var html = $('#parent_defend_upload').html();
										    	$(this).webuiPopover('destroy').webuiPopover({
										    		trigger:'click',	
										    		content: html,
										    		backdrop: false
										    	});
									
									   		}); 
									   		
							 			}
							 			
							 			var def_filename = data['files'];
							 			var def_re_name	 = data['re_name'];
							 			var def_uploadon = data['uploadon'];
							 		
							 			//def_getReloadFileList($document_identity, $document_ref, 'SPE99');
							 			setListGenerationForDef(def_filename, def_uploadon, def_re_name);
							 			
							 			$('#hq_amt').text(data['amt'])
							 										 			
						        	} else {
						        	
						        		notif({
							 		    	msg: \"Upload Failed.\",
							 		    	type: \"error\",
							 		    	position: \"right\",
							 		    	opacity: 1,
							 		    	width: 300,
							 		    	height: 50,
							 		    	autohide: true
							 			}); 
							 			
							 			console.log(data);
							 			
						        	}
						        
						        },
						        cache: false,
						        error: function(el) {
						          
						        },
						        statusCode: null,
						        onProgress: null,
						        onComplete: null		
							}
						});
										
						function def_enabledUpload() { $('#uploads_def').modal('show'); }						
						function setListGenerationForDef(def_filename, def_uploadon, def_file_ref) {
						
							$(function() {
							
									$('#defend_root_list').append(
						 			 '<li class=\"list-group-item\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"Attach Files\">' +
									  	'<a href=\"' + pathRoot + '/pcis/upload/' + def_file_ref + '\" target=\"_blank\" style=\"text-decoration: none; color: #000;\">' +
									  		'<span style=\" margin-right: 5px;\"><i class=\"fa fa-file-pdf-o\" style=\"color: #BE0808; font-size: 2.6em;\"></i></span>' +
									  		'<span style=\"float: right;\">' +					  		
									  		def_filename + ' <br/>'+
									  		'Upload on : ' + def_uploadon +
									  		'</span>' +
									  	'</a>' +
									  '</li>' 
						 			);
							
							});
						
						}
																
						function fnUnlockFieldOther() {
				
							var str_date, strClass;
						    var objDate  = new Date();
						    	str_date = (\"0\" + objDate.getDate()).slice(-2) + '/' + (\"0\" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear() + ' ' + objDate.getHours() + ':' + objDate.getMinutes() + ':' + objDate.getSeconds();
						    	strClass = objDate.getFullYear() + (\"0\" + (objDate.getMonth() + 1)).slice(-2) + (\"0\" + objDate.getDate()).slice(-2);
					
						   	var actor_empid	= $('#actor_empid').val();
						    var actor_names = $('#actor_name').val();
		
							$('#editor_otherid').val(actor_empid);
							$('#editor_othername').val(actor_names);	
							
							$('.setDefText_' + strClass).removeAttr('style');
																
							$('#defend_supplement_template').summernote({								
								toolbar: [
						 	 		['style', ['bold', 'italic', 'underline', 'clear']],							 	 	
							 	 	['para', ['ul', 'ol', 'paragraph']],							 
							 	    ['view', ['fullscreen']]
							 	    //'codeview', 'help'
							 	    //['fontsize', ['fontsize']],
							 	 	//['color', ['color']],
							 	    //['height', ['height']],
						 	 	],
								callbacks: {
						 	 	  	onBlur: function() { $('#defend_supplement_content').val($(this).summernote('code')); },
						 			onEnter: function() { $('#defend_supplement_content').val($(this).summernote('code')); },
						 	 	  	onKeyup: function() { $('#defend_supplement_content').val($(this).summernote('code')); },
						 			onPaste: function(e) { 	
						 			
										var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
									
	        							e.preventDefault();
	        						
	    								setTimeout( function(){
									        var note = document.execCommand('insertText', false, bufferText);
	    									console.log(note);
	    									if(note) {
	    										$('#defend_supplement_content').val($('#defend_supplement_template').summernote('code')); 
	    									}
		
									    }, 10 );
									}
						 	 	},
								focus: true
							});
					
						}	
		
						function getQueryParams(qs) {
						    qs = qs.split(\"+\").join(\" \");
						
						    var params = {}, tokens,
						        re = /[?&]?([^=]+)=([^&]*)/g;
						
						    while (tokens = re.exec(qs)) {
						        params[decodeURIComponent(tokens[1])]
						            = decodeURIComponent(tokens[2]);
						    }
						
						    return params;
						}
								
		
					</script>";
		    	
		    	?>
		  	</div>	
	  	  
		</div>
		<span class="text-muted" style="position: absolute; margin-top: -20px;"><small style="font-size: 0.8em;">Max Length : 8000 Character</small></span>
		
		<!-- Boostrap Modal -->
		<div id="uploads_lb" class="modal fade" tabindex="-1" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title">UPLOAD FILES</h4>
		      </div>
		      <div class="modal-body text-center">
				   <input id="filer_input_lendingBranch" name="files[]" type="file" multiple="multiple">				   
		      </div>
		      <div class="modal-footer" style="text-align: left;"><small class="text-muted">Upload By: Lending Branchs</small></div>
		    </div>
		  </div>
		</div>
		
		<div class="panel panel-success marginTop35">
			<div class="panel-heading">
				ความเห็นจาก RM/BM
				<span class="pull-right actorTriggers"></span>
				<div class="btn-group pull-right" role="group" style="margin-top: -7px !important;">
					<?php 
					
						$result_lb_pdf = $this->dbmodel->CIQuery("
				        	SELECT RowID, DocID, NumRef, DefendRef, DefendCode, Files, File_Reference, [File_Name], Extension, CreateBy,
							CONVERT(NVARCHAR(10), CreateDate, 120) AS CreateDate,
			        		RIGHT(CONVERT(NVARCHAR(20), CreateDate, 113), 8) AS CreateTime, FileState
							FROM   DefendUploads
							WHERE DocID = '".$document_identity."'
							AND DefendRef = '".$document_ref."'
							AND DefendCode = 'SLB99'
							AND IsActive = 'A'
			        		ORDER BY CONVERT(NVARCHAR(20), CreateDate, 113) DESC");
					

						if(!empty($result_lb_pdf['data'][0]['DocID'])):
						
							$lb_icon_identity = 'id="lb_open_folder"';
						
							$lb_amt = $this->dbmodel->CIQuery("
								SELECT COUNT(DocID) AS File_Amt FROM DefendUploads
								WHERE DocID = '".$document_identity."'
								AND DefendRef = '".$document_ref."'
								AND DefendCode = 'SLB99'
								AND IsActive = 'A'");
							
						else:
							$lb_icon_identity = '';
						endif;
					
					?>
					<?php if($_GET['editor'] == 'true'): ?>	
					<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Attach Files" onclick="lb_enabledUpload();"><i class="fa fa-plus"></i></button>
					 <?php endif; ?>
					<button <?php echo $lb_icon_identity; ?> type="button" class="btn btn-default show-pop lb_elemental" data-toggle="tooltip" data-placement="top" title="All Files">
						<i class="fa fa-folder-open-o"></i>
						<span id="lb_amt" class="badge" style="position: absolute; margin-left: -10px; margin-top: -7px;"><?php echo !empty($lb_amt['data'][0]['File_Amt']) ? $lb_amt['data'][0]['File_Amt']:''; ?></span>
					</button>

				    <button id="btnLendingHistory" type="button" class="btn btn-default show-pop" data-toggle="tooltip" data-placement="left" title="History" style="display: none;" style="display: none;"><i class="fa fa-history"></i></button>
				    <?php if($_GET['editor'] == 'true'): ?>	
				    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit" onclick="fnUnlockFieldLB()"><i class="fa fa-edit"></i></button>
				    <?php endif; ?>					  
				</div>	
			</div>
			<div class="panel-body">
			
				<?php 				
					$lbnote_option	= '<div class="setLBText_'.date('Ymd').' pre_text" style="display: none; "><div>'. $action_today .' '. $editname .' :</div>&nbsp;</div>';
					$LBRemark 		= !empty($getDefendOther['data'][0]['LBRemark']) ? $this->effective->get_chartypes($char_mode, $getDefendOther['data'][0]['LBRemark']):"";					
				?>
				
				<div id="defend_lending_template" style="width: 100%;"><?php echo $LBRemark . $lbnote_option; ?></div>		    	
		    	<textarea id="defend_lending_content" name="defend_lending_content" style="width: 100%; display: none;"><?php echo $LBRemark . $lbnote_option; ?></textarea>
		    	
		    	<input id="editor_lendingid" name="editor_lendingid" type="hidden" value="">
		        <input id="editor_lendingname" name="editor_lendingname" type="hidden" value="">
		        
		        <div id="parent_lendingnote" style="display: none;">
		        	<div style="padding: 10px 0; height: 500px; min-width:1050px; max-width:1050px; margin-top: -10px; font-size: 0.9em; display: block; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">
		    		<table class="table table-bordered">
						<thead>
							<tr style="background-color: #3175AF; color: #FFF;">
								<th width="5%" class="text-center">#</th>
								<th width="80%" class="text-center">DEFEND CONTENT</th>
								<th width="15%" class="text-center">DEFEND BY/DATE</th>
							</tr>
						</thead>
						<tbody>
							
							<?php 
								
								$lending_logs   = $this->dbmodel->CIQuery("
									SELECT 
									DocID, DefendRef, DefendLog.DefendCode, DefendReason, DefendOther,
									DefendNote, ActorBy, ActorName, DefendLog.IsActive, 
									CONVERT(NVARCHAR(10), ActorDate, 120) AS EventDate,
									SUBSTRING(CONVERT(VARCHAR(24), ActorDate, 120), 12, 5) AS EventTime
									FROM DefendSubscriptionLogs AS DefendLog
									LEFT OUTER JOIN MasterDefendReason AS DefendReason
									ON DefendLog.DefendCode = DefendReason.DefendCode
									WHERE DocID   = '".$document_identity."'
									AND DefendRef = '".$document_ref."'
									AND DefendLog.DefendCode = 'SLB99'
									ORDER BY ActorDate DESC	
								");
						
								if(!empty($lending_logs['data'][0]['DocID'])) {
									
									$i = 1;
									foreach ($lending_logs['data'] as $index => $values):
									
										if($lending_logs['data'][$index]['DefendCode'] == "OT999"):
											$option_reas = !empty($lending_logs['data'][$index]['DefendReason']) ? $this->effective->get_chartypes($char_mode, $lending_logs['data'][$index]['DefendReason']):'ความเห็นจากทีม RM/BM';
											$reason_note = $option_reas. ' ' .$this->effective->get_chartypes($char_mode, $lending_logs['data'][$index]['DefendOther']);
										else:									
											$reason_note = !empty($supply_logs['data'][$index]['DefendReason']) ? $this->effective->get_chartypes($char_mode, $lending_logs['data'][$index]['DefendReason']):'ความเห็นจากทีม RM/BM';
										endif;
										
										$data_note  = !empty($lending_logs['data'][$index]['DefendNote']) ? $this->effective->get_chartypes($char_mode, $lending_logs['data'][$index]['DefendNote']):'';
										$actor_by   = !empty($lending_logs['data'][$index]['ActorName']) ? $this->effective->get_chartypes($char_mode, $lending_logs['data'][$index]['ActorName']):'';
										$actor_date = !empty($lending_logs['data'][$index]['EventDate']) ? StandartDateRollback($lending_logs['data'][$index]['EventDate']). ' ' .$lending_logs['data'][$index]['EventTime']:'';
								
										echo "
			 							<tr>
			 								<td class=\"text-center\">$i</td>
								 			<td><b style=\"text-decoration: underline;\">$reason_note :</b> $data_note</td>
								 			<td class=\"text-center\">$actor_by <br/> ($actor_date)</td>
			 							</tr>";
									
										$i++;
										
									endforeach;
									
								} else {
									echo '<tr><td colspan="3" class="text-center">ไม่พบข้อมูล</td></tr>';
								}
							
							
							?>	
						
						</tbody>
					</table>
					</div>	
		        </div>
		        
		        <div id="parent_lb_upload" style="display: none; padding: 10px;">
		        	<div class="row"  style="padding: 10px 0; height: 270px; margin-top: -10px; font-size: 0.9em; display: block; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">
		        	<ul id="lb_root_list" class="list-group">
		       		<?php 
			      			        				    
			        	if(empty($result_lb_pdf['data'][0]['DocID'])) {
			        		
			        	} else {
			        	
			        		$rm_fileno = 1;
			        		foreach ($result_lb_pdf['data'] as $index => $value):
			        			
			        			$file_rmref	   = $result_lb_pdf['data'][$index]['RowID'];
			        			$re_file_lb    = $result_lb_pdf['data'][$index]['File_Reference'];
				        		$filename_lb   = $this->effective->get_chartypes($char_mode, $result_lb_pdf['data'][$index]['File_Name']);
				        		$uploaddate_lb = !empty($result_lb_pdf['data'][$index]['CreateDate']) ? 'Upload on : ' . $this->effective->StandartDateRollback($result_lb_pdf['data'][$index]['CreateDate']):'';
				        		$uploadtime_lb = !empty($result_lb_pdf['data'][$index]['CreateTime']) ? $result_lb_pdf['data'][$index]['CreateTime']:'';
				        		$file_state_lb = $result_lb_pdf['data'][$index]['FileState'];
				        		
				        		$check_file_lb = ($file_state_lb == 'Y') ? 'filereader':'';
				        		
				        		echo "
								  <li id=\"file_listRMAt_$rm_fileno\" class=\"list-group-item $check_file_lb\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"Attach Files\">
								  	<a href=\"".urldecode(base_url().'upload/'.$re_file_lb)."\" target=\"_blank\" style=\"text-decoration: none; color: #000;\" onclick=\"lbBindFile($file_rmref, $rm_fileno)\">
        								<span style=\" margin-right: 5px;\"><i class=\"fa fa-file-pdf-o\" style=\"color: #BE0808; font-size: 2.6em;\"></i></span>
        								<span style=\"float: right;\">
        								$filename_lb <br/>
        								$uploaddate_lb $uploadtime_lb
        								</span>
        							</a>
        							<span onclick=\"delete_fileInRM($file_rmref, 'file_listRMAt_$rm_fileno');\" style=\"z-index: 999; cursor: pointer; color: red; font-size: 1.5em; position: absolute; margin-top: -40px; margin-left: 82%;\">
								  		<i class=\"fa fa-minus-circle\"></i>
								  	</span>
        						</li>";
				        		
        						$rm_fileno++;
        								
			        		endforeach;
			        		
			        	}
			  	        
			        ?>		
			        </ul>
			        </div>
		        </div>
		 
		     
		    	<?php 
		    	
		    		echo "
					<script>
		
						$('#btnLendingHistory').hover(function() {
							var html = $('#parent_lendingnote').html()
					    	$(this).webuiPopover({
					    		trigger:'click',	
					    		content: html,
					    		backdrop: false
					    	});
				
				   		}); 
				   		
				   		$('#lb_open_folder').hover(function() {
							var html = $('#parent_lb_upload').html();
					    	$(this).webuiPopover({
					    		trigger:'click',	
					    		content: html,
					    		backdrop: false
					    	});
				
				   		});
				   				   		
				   		function delete_fileInRM(ref_code, element_no) {
				   			
				   			if(confirm('ยันยันการลบไฟล์หรือไม่')) {
				   				
				   				$.ajax({
									  url: pathFixed + 'file_upload/fnDelete_files?_=' + new Date().getTime(),
						  	    	  data: { refx: ref_code },
						  	          type: \"POST\",
						  	          beforeSend:function() { },
						  	          success:function(responsed) {	
	  
						  	        	 if(responsed['status']) {
						        			$('#' + element_no).remove();
						        			console.log($('#' + element_no).remove());
						        			console.log($('#defend_root_list').parent());
						        			$('.webui-popover').removeClass('in').addClass('out');
						        			
							        		notif({
								 		    	msg: \"Delete Successfully.\",
								 		    	type: \"success\",
								 		    	position: \"right\",
								 		    	opacity: 1,
								 		    	width: 300,
								 		    	height: 50,
								 		    	autohide: true
								 			}); 
								 											 			
								 			var lb_amt  = $('#lb_amt').text();
								 			var cal_amt = parseInt(lb_amt) - 1;
								 			$('#lb_amt').text(cal_amt)
								 											 							 			
								 		 } else {
						        	
							        		notif({
								 		    	msg: \"Delete Failed. Please try again.\",
								 		    	type: \"error\",
								 		    	position: \"right\",
								 		    	opacity: 1,
								 		    	width: 300,
								 		    	height: 50,
								 		    	autohide: true
								 			}); 
	
							        	 }
	  	        	   	      
						  	          },
						  	          complete:function() {
						  	        	  	        	   	        	
						  	        	  
						  	          },
						  	          cache: false,
						  	          timeout: 5000,
						  	          statusCode: {
						  		  	        404: function() { alert( \"page not found.\" ); },
						  		  	        407: function() { console.log(\"Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )\"); },
						  		  	        500: function() { console.log(\"internal server error.\"); }
						  	          }
					  		     
					  			});
				   				
				   			
				   				return true;
				   			
				   			}
				   			
				   			return false;
				   			
				   		}
				   		
				   		function lbBindFile(id, record_no) {
				  			
				   			$.ajax({
								  url: pathFixed + 'file_upload/fileReadState?_=' + new Date().getTime(),
					  	    	  data: { refx: id },
					  	          type: \"POST\",
					  	          beforeSend:function() { },
					  	          success:function(responsed) {				
					  	          
					  	          	 if(responsed['status'] == true) {				  	          		
						        		var list_item = 'file_listRMAt_' + record_no;
						        		$('.webui-popover').find('li[id=\"' + list_item + '\"]').addClass('filereader');						        
						        		
					  	          	 }
					  	          	
					  	          },
					  	          complete:function() {
					  
					  	          },
					  	          cache: false,
					  	          timeout: 5000,
					  	          statusCode: {
					  		  	        404: function() { alert( \"page not found.\" ); },
					  		  	        407: function() { console.log(\"Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )\"); },
					  		  	        500: function() { console.log(\"internal server error.\"); }
					  	          }				  		     
				  			});
				  			
				   		}
		
						$('#filer_input_lendingBranch').filer(
						{	
						    extensions: ['pdf', 'pptx', 'xlsx', 'docx'],
						    showThumbs: true,
							uploadFile: {
						        url: pathFixed + 'file_upload/setFileUploader',
						        data: {
									rel: $document_identity,
									ref: $document_ref,
									cox: 'SLB99',
									pri: ''
								},
						        type: 'POST',
						        enctype: 'multipart/form-data',
						        beforeSend: function() {},
						        success: function(data, el) {
						        
						           if(data['status']) {
						        	
						        		notif({
							 		    	msg: \"Upload Successfully.\",
							 		    	type: \"success\",
							 		    	position: \"right\",
							 		    	opacity: 1,
							 		    	width: 300,
							 		    	height: 50,
							 		    	autohide: true
							 			}); 
							 			
							 			var id_defattribute = $('.lb_elemental').attr('id');
							 			if(id_defattribute == undefined) {
							 				$('.lb_elemental').attr('id', 'lb_open_folder');
							 				
							 				$('#lb_open_folder').hover(function() {
												var html = $('#parent_lb_upload').html();
										    	$(this).webuiPopover('destroy').webuiPopover({
										    		trigger:'click',	
										    		content: html,
										    		backdrop: false
										    	});
									
									   		}); 
									   		
							 			}
							 	
							 			var lb_filename = data['files'];
							 			var lb_re_name	= data['re_name'];
							 			var lb_uploadon = data['uploadon'];
							 		
							 			$('#lb_root_list').prepend(
							 			 '<li class=\"list-group-item\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"Attach Files\">' +
										  	'<a href=\"' + pathRoot + '/pcis/upload/' + lb_re_name + '\" target=\"_blank\" style=\"text-decoration: none; color: #000;\">' +
										  		'<span style=\" margin-right: 5px;\"><i class=\"fa fa-file-pdf-o\" style=\"color: #BE0808; font-size: 2.6em;\"></i></span>' +
										  		'<span style=\"float: right;\">' +					  		
										  		lb_filename + ' <br/>'+
										  		'Upload on : ' + lb_uploadon +
										  		'</span>' +
										  	'</a>' +
										  '</li>' 
							 			);
							 			
							 			$('#lb_amt').text(data['amt'])
							 			
						        	} else {
						        	
						        		notif({
							 		    	msg: \"Upload Failed.\",
							 		    	type: \"error\",
							 		    	position: \"right\",
							 		    	opacity: 1,
							 		    	width: 300,
							 		    	height: 50,
							 		    	autohide: true
							 			}); 
							 			
							 			console.log(data);
							 			
						        	}
						        	
						        },
						        error: function(el) {
						          
						        },
						        statusCode: null,
						        onProgress: null,
						        onComplete: null		
							}
						});
					
						function lb_enabledUpload() { $('#uploads_lb').modal('show'); }
		
						function fnUnlockFieldLB() {
							var str_date, strClass;
						    var objDate = new Date();
						    	str_date = (\"0\" + objDate.getDate()).slice(-2) + '/' + (\"0\" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear() + ' ' + objDate.getHours() + ':' + objDate.getMinutes() + ':' + objDate.getSeconds();
						    	strClass = objDate.getFullYear() + (\"0\" + (objDate.getMonth() + 1)).slice(-2) + (\"0\" + objDate.getDate()).slice(-2);
					
						   	var actor_empid	= $('#actor_empid').val();
						    var actor_names = $('#actor_name').val();
		
							$('#editor_lendingid').val(actor_empid);
							$('#editor_lendingname').val(actor_names);
							
							$('.setLBText_' + strClass).removeAttr('style');
		
							$('#defend_lending_template').summernote({
								toolbar: [
						 	 		['style', ['bold', 'italic', 'underline', 'clear']],							 	 	
							 	 	['para', ['ul', 'ol', 'paragraph']],							 
							 	    ['view', ['fullscreen']]
							 	    //'codeview', 'help'
							 	    //['fontsize', ['fontsize']],
							 	 	//['color', ['color']],
							 	    //['height', ['height']],
						 	 	],
								callbacks: {
						 	 	  	onBlur: function() { $('#defend_lending_content').val($(this).summernote('code')); },
						 			onEnter: function() { $('#defend_lending_content').val($(this).summernote('code')); },
						 	 	  	onKeyup: function() { $('#defend_lending_content').val($(this).summernote('code')); },
						 			onPaste: function(e) { 										
										var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

	        							e.preventDefault();
	
	    								setTimeout( function(){
									        var note = document.execCommand('insertText', false, bufferText );
	    									console.log(note);
	    									if(note) {
	    										$('#defend_lending_content').val($('#defend_lending_template').summernote('code')); 
	    									}
		
									    }, 10 );
									}
						 	 	},
								focus: true
							});
					
						}	
		
					</script>";
		    	
		    	?>
		  	</div>			  	
		</div>
		<span class="text-muted" style="position: absolute; margin-top: -20px;"><small style="font-size: 0.8em;">Max Length : 8000 Character</small></span>
		
		<!-- Part: Defend List -->
		<?php 
            	
           if(empty($getDefendList['data'][0]['DefendCode'])) {							
		   		echo '<div class="text-center"><h4>ไม่พบข้อมูล</h4></div>';
					
		   } else {
		   	
		   		echo "
				<script>
    				    				    		
					function fnUnlockField(id) {
						var str_date, strClass;
					    var objDate = new Date();
					    	str_date = (\"0\" + objDate.getDate()).slice(-2) + '/' + (\"0\" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear() + ' ' + objDate.getHours() + ':' + objDate.getMinutes() + ':' + objDate.getSeconds();
							strClass = objDate.getFullYear() + (\"0\" + (objDate.getMonth() + 1)).slice(-2) + (\"0\" + objDate.getDate()).slice(-2);
    		
					   	var actor_empid	= $('#actor_empid').val();
					    var actor_names = $('#actor_name').val();
	   	
						$('#editor_id_' + id).val(actor_empid);
						$('#editor_name_' + id).val(actor_names);
    		
    					var concat_ref = strClass + '_' + id;
    					$('.setTopicText_' + concat_ref).removeAttr('style');
    		
    					$('#template_reason_' + id).summernote({
    						toolbar: [
					 	 		['style', ['bold', 'italic', 'underline', 'clear']],							 	 	
						 	 	['para', ['ul', 'ol', 'paragraph']],							 
						 	    ['view', ['fullscreen']]
						 	    //'codeview', 'help'
						 	    //['fontsize', ['fontsize']],
						 	 	//['color', ['color']],
						 	    //['height', ['height']],
					 	 	],
    						callbacks: {
					 			onBlur: function() { $('#defend_reason_' + id).val($('#template_reason_' + id).summernote('code')); },
					 			onEnter: function() { $('#defend_reason_' + id).val($('#template_reason_' + id).summernote('code')); },
					 	 	  	onKeyup: function() { $('#defend_reason_' + id).val($('#template_reason_' + id).summernote('code')); },
					 			onPaste: function(e) { 
    								var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

        							e.preventDefault();

    								setTimeout( function(){
								        var note = document.execCommand('insertText', false, bufferText );
    									console.log(note);
    									if(note) {
    										$('#defend_reason_' + id).val($('#template_reason_' + id).summernote('code')); 
    									}        							
								    }, 10 );
    		
		   						}
					 		},
    						focus: true
		  				});
		
					}
    		
				</script>";
					
				$i = 1;
				foreach($getDefendList['data'] as $index => $value) {
						
					$defend_rid    = $getDefendList['data'][$index]['DFS_ID'];
					$dedend_code   = $getDefendList['data'][$index]['DefendCode'];
					$defend_reason = $getDefendList['data'][$index]['DefendReason'];
					
					$topicTxtOption = '<div class="setTopicText_'.date('Ymd').'_'.$i.' pre_text" style="display: none; "><div>'. $action_today .' '. $editname .' :</div>&nbsp;</div>';
					
					$defend_other  = !empty($getDefendList['data'][$index]['DefendOther']) ? $getDefendList['data'][$index]['DefendOther']:'';
					$defend_note   = !empty($getDefendList['data'][$index]['DefendNote']) ? htmlspecialchars_decode($getDefendList['data'][$index]['DefendNote']):"";
							
					$result_main   = $this->dbmodel->CIQuery("
						SELECT
						DocID, DefendRef, DefendLog.DefendCode, DefendReason, DefendOther,
						DefendNote, ActorBy, ActorName, DefendLog.IsActive,
						CONVERT(NVARCHAR(10), ActorDate, 120) AS EventDate,
						SUBSTRING(CONVERT(VARCHAR(24), ActorDate, 120), 12, 5) AS EventTime
						FROM DefendSubscriptionLogs AS DefendLog
						LEFT OUTER JOIN MasterDefendReason AS DefendReason
						ON DefendLog.DefendCode = DefendReason.DefendCode
						WHERE DocID   = '".$document_identity."'
						AND DefendRef = '".$document_ref."'
						AND DefendLog.DefendCode = '".$getDefendList['data'][$index]['DefendCode']."'
						ORDER BY ActorDate DESC
					");
					
					$result_topic_pdf = $this->dbmodel->CIQuery("
				        SELECT RowID, DocID, NumRef, DefendRef, DefendCode, Files, File_Reference, [File_Name], Extension, CreateBy,
						CONVERT(NVARCHAR(10), CreateDate, 120) AS CreateDate,
	        			RIGHT(CONVERT(NVARCHAR(20), CreateDate, 113), 8) AS CreateTime, FileState
						FROM   DefendUploads
						WHERE DocID = '".$document_identity."'
						AND DefendRef = '".$document_ref."'
						AND NumRef = '".$defend_rid."'
						AND IsActive = 'A'
			        	ORDER BY CONVERT(NVARCHAR(20), CreateDate, 113) DESC");
					
					if(!empty($result_topic_pdf['data'][0]['DocID'])):					
						$topic_icon_identity = 'id="topic_open_folder_'.$i.'"';			
					else:
						$topic_icon_identity = '';
					endif;
					
					$topic_amt = $this->dbmodel->CIQuery("
							SELECT COUNT(DocID) AS File_Amt FROM DefendUploads
							WHERE DocID = '".$document_identity."'
							AND DefendRef = '".$document_ref."'
							AND NumRef = '".$defend_rid."'
							AND IsActive = 'A'");
						
					echo "
		    		<!-- Boostrap Modal -->
					<div id=\"uploads_toppic_$i\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\">
					  <div class=\"modal-dialog\">
					    <div class=\"modal-content\">
					      <div class=\"modal-header\">
					        	<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
					        	<h4 class=\"modal-title\">UPLOAD FILES</h4>
					      </div>
					      <div class=\"modal-body text-center\">
							    <input id=\"filer_input_topic_$i\" name=\"files[]\" type=\"file\" multiple=\"multiple\">				   
					      </div>
					      <div class=\"modal-footer\" style=\"text-align: left;\"><small class=\"text-muted\">Upload in topic: $defend_reason $defend_other</small></div>
					    </div>
					  </div>
					</div>
					
			    	<div class=\"panel panel-danger marginTop35\" style=\"clear: both;\">
						<div class=\"panel-heading\">
							$document_ref.$i) $defend_reason $defend_other :
							<span class=\"pull-right actorTriggers\">";
					
							if(!empty($result_main['data'][$index]['CreateName'])):
								echo $this->effective->get_chartypes($char_mode, $result_main['data'][$index]['CreateName']). ' (update: '. StandartDateRollback($result_main['data'][$index]['EventDate']) . ' ' . $result_main['data'][$index]['EventTime'] .')'.'<br/>';
							endif;
							
							$topic_amtchecked = !empty($topic_amt['data'][0]['File_Amt']) ? $topic_amt['data'][0]['File_Amt']:'';
							
					echo	"</span>
							<div class=\"btn-group pull-right\" role=\"group\"  style=\"margin-top: -7px !important;\">";
							
								if($_GET['editor'] == 'true'):
								echo "<button type=\"button\" class=\"btn btn-default\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete Topic\" onclick=\"\"><i class=\"ti-trash\"></i></button>";
								echo "<button type=\"button\" class=\"btn btn-default\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Attach Files\" onclick=\"topic_enabledUpload($i);\"><i class=\"fa fa-plus\"></i></button>";
								endif;
								
					echo	"<button $topic_icon_identity type=\"button\" class=\"btn btn-default show-pop topic_elemental_$i\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"All Files\">
									<i class=\"fa fa-folder-open-o\"></i>
									<span id=\"topic_amt_$i\" class=\"badge\" style=\"position: absolute; margin-left: -10px; margin-top: -7px;\">$topic_amtchecked</span>
								</button>
							
													
							    <button id=\"btnLoadContent_$i\" type=\"button\" class=\"btn btn-default show-pop\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"History\" style=\"display: none;\">
							    	<i class=\"fa fa-history\"></i>
							    </button>";
					
							    if($_GET['editor'] == 'true'):							   
							    echo "<button type=\"button\" class=\"btn btn-default\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\" onclick=\"fnUnlockField($i)\"><i class=\"fa fa-edit\"></i></button>";
							    endif;
							    
					echo 	"</div>	
						</div>
						<div class=\"panel-body\">	
						
			    			<input id=\"record_id\" name=\"record_id[]\" type=\"hidden\" value=\"".$getDefendList['data'][$index]['DFS_ID']."\">
							<input id=\"defend_id\" name=\"defend_id[]\" type=\"hidden\" value=\"$dedend_code\">
							<input id=\"defend_subject\" name=\"defend_subject[]\" type=\"hidden\" value=\"$defend_other\">
							<input id=\"editor_id_$i\" name=\"editor_id[]\" type=\"hidden\" value=\"\">
		        			<input id=\"editor_name_$i\" name=\"editor_name[]\" type=\"hidden\" value=\"\">
							<textarea id=\"defend_reason_$i\" name=\"defend_reason[]\" style=\"width: 100%; display: none;\">$defend_note $topicTxtOption</textarea>
							
							<div id=\"template_reason_$i\" class=\"textarea\" style=\"width: 100%;\">$defend_note $topicTxtOption</div>
				
					  	</div>				  	
					</div>
					
					<div id=\"editor_area_$i\" style=\"display: none;\">
						<div style=\"padding: 10px 0; height: 500px; min-width:1050px; max-width:1050px; margin-top: -10px; font-size: 0.9em; display: block; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;\">
						<table class=\"table table-bordered\">
							<thead>
								<tr style=\"background-color: #3175AF; color: #FFF;\">
									<th width=\"5%\" class=\"text-center\">#</th>
									<th width=\"80%\" class=\"text-center\">DEFEND CONTENT</th>
									<th width=\"15%\" class=\"text-center\">DEFEND BY/DATE</th>
								</tr>
							</thead>
							<tbody>";

							if(!empty($result_main['data'][0]['DocID'])) {
				
								$row_id = 1;
								foreach ($result_main['data'] as $pointer => $content) {
									
									if($result_main['data'][$pointer]['DefendCode'] == "OT999"):
									$option_reas = !empty($result_main['data'][$pointer]['DefendReason']) ? $this->effective->get_chartypes($char_mode, $result_main['data'][$pointer]['DefendReason']):'อื่นๆ';
									$reason_note = $option_reas. ' ' .$this->effective->get_chartypes($char_mode, $result_main['data'][$pointer]['DefendOther']);
									else:
									$reason_note = !empty($result_main['data'][$pointer]['DefendReason']) ? $this->effective->get_chartypes($char_mode, $result_main['data'][$pointer]['DefendReason']):'อื่นๆ';
									endif;
										
									$data_note  = !empty($result_main['data'][$pointer]['DefendNote']) ? $this->effective->get_chartypes($char_mode, $result_main['data'][$pointer]['DefendNote']):'';
									$actor_by   = !empty($result_main['data'][$pointer]['ActorName']) ? $this->effective->get_chartypes($char_mode, $result_main['data'][$pointer]['ActorName']):'';
									$actor_date = !empty($result_main['data'][$pointer]['EventDate']) ? StandartDateRollback($result_main['data'][$pointer]['EventDate']). ' ' .$result_main['data'][$pointer]['EventTime']:'';
									
									echo "
									<tr>
										<td class=\"text-center\">$row_id</td>
										<td><b style=\"text-decoration: underline;\">$reason_note :</b> $data_note</td>
										<td class=\"text-center\">$actor_by <br/> ($actor_date)</td>
									</tr>";
									
									$row_id++;
									
								}
									
							
							} else {
								echo '<tr><td colspan="3" class="text-center">ไม่พบข้อมูล</td></tr>';
							}
						
										
					echo 
					"		</tbody>
						</table>
						</div>	 	 				
	 	 			</div>
	 	 			<span class=\"text-muted\" style=\"position: absolute; margin-top: -20px;\"><small style=\"font-size: 0.8em;\">Max Length : 8000 Character</small></span>
					
	 	 			<div id=\"parent_topic_upload_$i\" style=\"display: none; padding: 10px;\">
			        	<div class=\"row\" style=\"padding: 10px 0; height: 270px; margin-top: -10px; font-size: 0.9em; display: block; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;\">
			        	<ul id=\"topic_root_list_$i\" class=\"list-group\">";
						
							if(empty($result_topic_pdf['data'][0]['DocID'])) {
								 
							} else {
				
								foreach ($result_topic_pdf['data'] as $index => $value):
								 
									$file_topicref		= $result_topic_pdf['data'][$index]['RowID'];
									$re_file_topic      = $result_topic_pdf['data'][$index]['File_Reference'];
									$filename_topic 	= $this->effective->get_chartypes($char_mode, $result_topic_pdf['data'][$index]['File_Name']);
									$uploaddate_topic 	= !empty($result_topic_pdf['data'][$index]['CreateDate']) ? 'Upload on : ' . $this->effective->StandartDateRollback($result_topic_pdf['data'][$index]['CreateDate']):'';
									$uploadtime_topic	= !empty($result_topic_pdf['data'][$index]['CreateTime']) ? $result_topic_pdf['data'][$index]['CreateTime']:'';
									
									$file_state_topic 	= $result_topic_pdf['data'][$index]['FileState'];
									$check_file_topic	= ($file_state_topic == 'Y') ? 'filereader':'';
										
									
									echo "<li id=\"file_topicListAt_$file_topicref\" class=\"list-group-item $check_file_topic\">
									  	 <a href=\"".urldecode(base_url().'upload/'.$re_file_topic)."\" target=\"_blank\" style=\"text-decoration: none; color: #000;\">
									  	 	<span style=\" margin-right: 5px;\"><i class=\"fa fa-file-pdf-o\" style=\"color: #BE0808; font-size: 2.6em;\"></i></span>
											<span style=\"float: right;\">
												$filename_topic <br/>
												$uploaddate_topic $uploadtime_topic
											</span>
									  	 </a>
									  	 <span onclick=\"delete_fileInTopic($file_topicref, 'file_topicListAt_$file_topicref');\" style=\"z-index: 999; cursor: pointer; color: red; font-size: 1.5em; position: absolute; margin-top: -40px; margin-left: 82%;\">
									  		<i class=\"fa fa-minus-circle\"></i>
									  	</span>
								  	  </li>";
			
									  
								 
								endforeach;
								 
							}
			
							
				  	echo "
 						</ul>
				        </div>
			        </div>
					
					<script>
    				    				    		
						$('#btnLoadContent_$i').hover(function() {
							var html = $('#editor_area_$i').html()
					    	$(this).webuiPopover({
					    		trigger:'click',
					    		content: html,
					    		backdrop: false
					    	});
				
				   		}); 
				   		
				   		$('#topic_open_folder_$i').hover(function() {
							var html = $('#parent_topic_upload_$i').html();
					    	$(this).webuiPopover({
					    		trigger:'click',	
					    		content: html,
					    		backdrop: false
					    	});
				
				   		}); 
				   		
				   		function topicBindFile_$i(id, record_no) {
				  			
				   			$.ajax({
								  url: pathFixed + 'file_upload/fileReadState?_=' + new Date().getTime(),
					  	    	  data: { refx: id },
					  	          type: \"POST\",
					  	          beforeSend:function() { },
					  	          success:function(responsed) {				
					  	          	 if(responsed['status'] == true) {				  	          		
						        		var list_item = 'file_listAt_' + record_no;
						        	    $('.webui-popover').find('li[id=\"' + list_item + '\"]').addClass('filereader');						        
						        		
					  	          	 }
					  	          	
					  	          },
					  	          cache: false,
					  	          timeout: 5000,
					  	          statusCode: {
					  		  	        404: function() { alert( \"page not found.\" ); },
					  		  	        407: function() { console.log(\"Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )\"); },
					  		  	        500: function() { console.log(\"internal server error.\"); }
					  	          }				  		     
				  			});
				  			
				   		}
				   		
				   		function delete_fileInTopic(ref_code, element_no) {
				   			
				   			if(confirm('ยันยันการลบไฟล์หรือไม่')) {
				   				
				   				$.ajax({
									  url: pathFixed + 'file_upload/fnDelete_files?_=' + new Date().getTime(),
						  	    	  data: { refx: ref_code },
						  	          type: \"POST\",
						  	          beforeSend:function() { },
						  	          success:function(responsed) {	
	  
						  	        	 if(responsed['status']) {
						        			$('#' + element_no).remove();
						        			console.log($('#' + element_no).remove());
						        			console.log($('#defend_root_list').parent());
						        			$('.webui-popover').removeClass('in').addClass('out');
						        			
							        		notif({
								 		    	msg: \"Delete Successfully.\",
								 		    	type: \"success\",
								 		    	position: \"right\",
								 		    	opacity: 1,
								 		    	width: 300,
								 		    	height: 50,
								 		    	autohide: true
								 			}); 
								 											 			
								 			var topic_amt = $('#topic_amt_$i').text();
								 			var cal_amt   = parseInt(topic_amt) - 1;
								 			$('#topic_amt_$i').text(cal_amt)
								 							 			
								 		 } else {
						        	
							        		notif({
								 		    	msg: \"Delete Failed. Please try again.\",
								 		    	type: \"error\",
								 		    	position: \"right\",
								 		    	opacity: 1,
								 		    	width: 300,
								 		    	height: 50,
								 		    	autohide: true
								 			}); 
	
							        	 }
	  	        	   	      
						  	          },
						  	          cache: false,
						  	          timeout: 5000,
						  	          statusCode: {
						  		  	        404: function() { alert( \"page not found.\" ); },
						  		  	        407: function() { console.log(\"Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )\"); },
						  		  	        500: function() { console.log(\"internal server error.\"); }
						  	          }
					  		     
					  			});
				   				
				   			
				   				return true;
				   			
				   			}
				   			
				   			return false;
				   			
				   		}
				   		
				   		$('#filer_input_topic_$i').filer(
						{	
						    extensions: ['pdf', 'pptx', 'xlsx', 'docx'],
						    showThumbs: true,
							uploadFile: {
						        url: pathFixed + 'file_upload/setFileUploader',
						        data: {
									rel: $document_identity,
									ref: $document_ref,
									cox: '$dedend_code',
									pri: '$defend_rid'
								},
						        type: 'POST',
						        enctype: 'multipart/form-data',
						        beforeSend: function() {},
						        success: function(data, el) {
						        
						           if(data['status']) {
						        	
						        		notif({
							 		    	msg: \"Upload Successfully.\",
							 		    	type: \"success\",
							 		    	position: \"right\",
							 		    	opacity: 1,
							 		    	width: 300,
							 		    	height: 50,
							 		    	autohide: true
							 			}); 
							 			
							 			var id_defattribute = $('.topic_elemental_$i').attr('id');
							 			if(id_defattribute == undefined) {
							 				$('.topic_elemental_$i').attr('id', 'topic_open_folder_$i');
							 				
							 				$('#topic_open_folder_$i').hover(function() {
												var html = $('#parent_topic_upload_$i').html();
										    	$(this).webuiPopover('destroy').webuiPopover({
										    		trigger:'click',	
										    		content: html,
										    		backdrop: false
										    	});
									
									   		}); 
									   		
							 			}
							 					
							 			var topic_filename = data['files'];
							 			var topic_re_name  = data['re_name'];
							 			var topic_uploadon = data['uploadon'];
							 		
							 			$('#topic_root_list_$i').prepend(
							 			 '<li class=\"list-group-item\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"Attach Files\">' +
										  	'<a href=\"' + pathRoot + '/pcis/upload/' + topic_re_name + '\" target=\"_blank\" style=\"text-decoration: none; color: #000;\">' +
										  		'<span style=\" margin-right: 5px;\"><i class=\"fa fa-file-pdf-o\" style=\"color: #BE0808; font-size: 2.6em;\"></i></span>' +
										  		'<span style=\"float: right;\">' +					  		
										  		topic_filename + ' <br/>'+
										  		'Upload on : ' + topic_uploadon +
										  		'</span>' +
										  	'</a>' +
										  '</li>' 
							 			);
							 			
							 			$('#topic_amt_$i').text(data['amt'])
							 			
						        	} else {
						        	
						        		notif({
							 		    	msg: \"Upload Failed.\",
							 		    	type: \"error\",
							 		    	position: \"right\",
							 		    	opacity: 1,
							 		    	width: 300,
							 		    	height: 50,
							 		    	autohide: true
							 			}); 
							 			
							 			console.log(data);
							 			
						        	}
						        	
						        },
						        error: function(el) {
						          
						        },
						        statusCode: null,
						        onProgress: null,
						        onComplete: null		
							}
						});
					
						function topic_enabledUpload(id) {
							$('#uploads_toppic_' + id).modal('show');							
							
						}
				   	
					</script>";
					
					$i++;
						
				}
					
				
		  }
					
		?>
		
		
		</div>

		<div class="col-md-12 text-right marginBottom30">
			<?php 
			
				if($_GET['whip'] == 'true' && $_GET['enable'] == 'true'):
					$btnClose = "<button type=\"button\" class=\"btn btn-default\" onclick=\"javascript:window.open('','_self').close();\"><i class=\"icon icon-exit\"></i> CLOSE</button>";
				else:
					$btnClose = '';
				endif;
				
				if($_GET['editor'] == 'true'):
				echo '<div class="place-right nonprint" style="margin-top: 10px;">
			         	'.$btnClose.'
		             	<button id="btn_Save" type="submit" class="btn btn-primary fg-white large"><i class="fa fa-floppy-o"></i> SUBMIT</button>
		             </div>';
				endif;
							
			?>
		</div>
		
		<?php echo form_close(); ?>		
		<?php 
			
			function StandartDateRollback($date) {
				if($date == "") {
					return "";
						
				} else {
						
					$spl = explode("-", $date);
						
					$y = $spl[0];
					$m = $spl[1];
					$d = $spl[2];
						
					return "$d/$m/$y";
						
				}
					
			}
		
		?>
	
	</div>
</div>

<script type="text/javascript">

function getDefendMaintenace() {

	var str_date;
	var objDate = new Date();
	str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();

	var center = 
 	 	'<div id="notifications-full">' +
	 	 	'<div id="notifications-full-close" class="close" onclick=\"$(\'#overlay\').css({ visibility:\'hidden\' });\">' +
	 	 		'<i class="fa fa-close" style=\"color: #000;\"></i>' +
	 	 	'</div>' +
	 	 	'<div id="notifications-full-icon">' +
	 	 		'<i id="notification-icons" class="fa fa-bell animated swing" style="color: #FFD119;"></i></div>' +
	 	 	'<div id="notifications-full-text">' +
	 	 		'<div class="form-group text-center">' + 
	 	 			'<h4 class="marginLeft5 marginTopEasing5">DEFEND ALERT</h4>' +
		 	 		'<label class="control-label text-info">กรุณาเลือกข้อมูลของผู้ดูแลเคส.</label>' +
			 	 	'<select id="select_defendname" name="select_defendname" class="form-control" style="width: 300px; margin-left: 15%;">' +
						'<option value=""></option>' +
						<?php 
					
						if(!empty($getSFEDataList[0]['EmployeeCode'])) {
							
							$pass = $this->config->item('Administrator');
							foreach ($getSFEDataList as $index => $values) {
								
								if(in_array($getSFEDataList[$index]['EmployeeCode'], $pass)) {
									continue;
								} else {
									
									$select_list  = '';
									$defend_owner = !empty($getSFEActor['data'][0]['DefendEmpID']) ? $getSFEActor['data'][0]['DefendEmpID']:"";
									if($defend_owner == $getSFEDataList[$index]['EmployeeCode']):
										$select_list = 'selected="selected"';
									else:
										$select_list = '';
									endif;
									
									echo '\'<option value="'.$getSFEDataList[$index]['EmployeeCode'].'" '.$select_list.'>'.$getSFEDataList[$index]['FullNameTh'].'</option>\' +';
								}
			
							}												
						
						}
					
					?>
				'</select>' +
				'<span id="msg_warning" class="text-danger col-md-12" style="font-size: 0.9em;"></span>' +
				'<button id="btnAccept_Edit" type="button" class="btn btn-primary marginTop5">Accept</button>' +
			'</div>' +
 	 	'</div>' +
	'</div>';
	
	$("body").append(center);
	$("#notifications-full").addClass('animated bounceIn');

	$('#btnAccept_Edit').click(function() {
 	 	var actor_name		  = $('#actor_name').val();
		var select_defend_id  = $('select[name="select_defendname"] option:selected').val();
		var select_defendname = $('select[name="select_defendname"] option:selected').text();
		if(select_defend_id == "" && select_defendname == "") {
			$('#msg_warning').text('ขออภัย!! กรุณาเลือกข้อมูลผู้ดูแลเคส.');
			
		} else {

			$('#defendEmpID').val(select_defend_id);
			$('#defendEmpName').val(select_defendname);
			$('#assignmentBy').val(actor_name);	
			$('#assignmentDate').val(str_date);			
			$('#defendname_area').text(select_defendname);

			$('#msg_warning').text('');

			$('#overlay').css({ visibility:'hidden' });
			$('#notifications-full').fadeOut(200);
			
		}
 	});

 	function refresh_close(){
 		$('.close').click(function(){$(this).parent().fadeOut(200);});
 		
 	}
 	refresh_close();
 	
 	function showOverlay() {
 		  var body = document.getElementsByTagName('body')[0]
 		  var overlay = document.getElementById('overlay')
 		  overlay.style.height=body.offsetHeight+"px"
 		  overlay.style.width=body.offsetWidth+"px"
 		  overlay.style.visibility="visible"
 	}
	
	showOverlay();
	refresh_close();
	

	
}

function countChar(element, val) {
    var len = val.value.length;
    if (len >= 8000) {
      val.value = val.value.substring(0, 8000);
    } else {
      $(this).text(8000 - len);
    }
}

(function() {
	
	/*
    var beforePrint = function() {
        console.log('Functionality to run before printing.');
    };
    var afterPrint = function() {
        console.log('Functionality to run after printing');
    };

    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            console.log(mql);
            if (mql.matches) {
                beforePrint();
            } else {
                afterPrint();
            }
        });
    }

    window.onbeforeprint = beforePrint;
    window.onafterprint  = afterPrint;
	*/
	
    var afterPrint = function() {
        // Here you would send an AJAX request to the server to track that a page
        // has been printed.  You could additionally pass the URL if you wanted to
        // track printing across an entire site or application.
    	 console.log('Functionality to run after printing');
    };

    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (!mql.matches) {
                afterPrint();
            }
        });
    }

    window.onafterprint = afterPrint;
    
}());


</script>

</body>
</html>