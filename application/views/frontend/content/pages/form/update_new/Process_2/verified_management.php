<style>

	.ui-multiselect {
		height: 34px;
		border: 1px solid #D1D1D1;
		background: #FFF;
		min-width: 395px;
		/* max-width: 300px; */
	}
	
    .no-margin-top { margin-top: -5px; }
    .padding3 { padding: 3px; }
    .padding5 { padding: 5px; }
    .padding10 { padding: 10px; }
    
    .cb-marginFixedIE { 
    	position:absolute; 
    	margin-left: -15px; 
    	margin-top: 0px; 
    	z-index: 999; 
    }
    
    @media screen and (-webkit-min-device-pixel-ratio:0) { 
		.cb-marginFixedChrome {
			margin-top: 2px !important;
			margin-left: 5px !important;
		}
		
		.budgetFixed { 
			margin-left: 33px !important; 
			margin-top: -38px !important;
		}
		
		.budgetAmountFixed {
			margin-left: 45px !important; 
			margin-top: -47px !important;
		}
		
		.budgetWidth { min-width: 58px !important; }
		.budgetAmountClear {
			margin-left: -14px !important; 
			margin-top: -9px !important;
		}
		
		.budgetDefendFixed {
			margin-top: -35px !important;
			margin-left: 1px !important;
		}
		
		.btnDefend {
			height: 27px !important;
			padding-top: 8px;
		}
		
	 }
	
    
    .case_history { height: 32px; width: 150px; text-align: center; padding: 5px; color: white; }
    .returnBox { max-width: 790px; border: 1px solid gray; background: #fcfff4; }
    .label-clear { background-color: #FFF !important; }
    .ms-parent { background: #EBEBE4; }
    
    #defend_content, #careturn_content, #rmprocess_content  { 
    	padding: 20px;
    	font-size: 0.9em;
    	font-weight: normal;

    }
    
    #defend_content .panel-content,    
    #rmprocess_content .panel-content { padding: 20px; }
    
    #careturn_content .panel-content { margin-top: 5px; padding-bottom: 20px; }
    
    div#msg_identityresponsed, div#retrieve_msg_identityresponsed {
	    text-align: center;
	    color: red;
	}
	
	#bpm_information {		
		padding: 15px 0;
		margin-top: 10px; 
		background: #EFECEC; 		
	}
	
	.bs-list-group {
		padding-left: 0 !important;
		margin-bottom: 20px !important;
		font-size: 1em !important;
		font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
	    font-weight: normal;
	    font-style: normal;
	}
	
	.text_float { 
		position: absolute;
		margin-top: 55%;
		margin-left: 25px;
		border: 1px solid #D1D1D1;
		padding: 5px 10px;
		-webkit-transform: rotate(270deg);
		-moz-transform: rotate(270deg);
		-o-transform: rotate(270deg);
		transform: rotate(270deg);
		writing-mode: lr-tb;
		font-weight: bold;		
	}
	
	.text-selectred { color: red; }
	.tooltip-top { text-align: center !important;}
	
	.modal-dialog:not(.modal-lg) {
		width: 90%;
		height: 100%;
  		margin: 0 auto;
		padding: 0;
	}
	
	.modal-content {
	  height: auto;
	  min-height: auto;
	  border-radius: 0;
	}
	
	.document_list {
	    width: 100%;
	    height: auto;
	    min-height: auto;
	    z-index: 150000;
	    position: absolute;
	    left: 0;
	    top: 0;
	    margin-left: 0px;
	    display: none;
	    min-height: 300px;
	    background-color: #FFF;
	    border: 1px solid #D1D1D1;
	    transition: 0.5s;
	}
	
	.calendar.calendar-dropdown {
		z-index: 100000 !important;
	}
	
	.icon_blink_slow { animation: blink 2s ease-in infinite; }
	@keyframes blink {
	  from, to { opacity: 1 }
	  50% { opacity: .4 }
	}
	
	table#defend_logs th {
		padding: .3em !important;
	}
	table#defend_logs td {
		padding: 0 .3em !important;
	}
	
	table#defend_logs th,
	table#defend_logs td {
		font-size: 0.8em;
	}
		

</style>

<div class="text_float nonprint"><h2>Edit Form</h2></div>

<div class="container" data-region="<?php echo !empty($getCustInfo['Region']) ? trim($getCustInfo['Region']) : ''; ?>">
	<?php 
		// Load Library
		$this->load->helper('form');
		$this->load->library('effective'); 
	?>
	
	<?php     	
		$useable = 'true';
		$hide_attr = '';
		$none_style = '';
		$disable_attr = '';
		$readonly = '';
		$bgreadonly = '';
		$onclick = '';
		if(in_array($session_data['role'], array('adminbr_role')) || in_array($getCustInfo['BranchCode'], $session_data['pilot'])):
			$disable_attr = 'disabled="disabled"';
			$none_style = 'style="display: none;"';
			$hide_attr = 'display: none;';
			$readonly = 'readonly="readonly"';
			$bgreadonly = 'background-color: #EBEBE4;';
			$onclick = 'return false';
			$useable = 'false';
		endif;
		
	?>
	
	<div class="grid" style="width: 1300px; margin-left: -90px;">
	<div id="form" class="row">
		
		<div class="logo_header">
			<img src="<?php echo base_url('img/logo_form_header.jpg'); ?>" style="min-width: 1170px;">
		</div>
	
		<header id="form-header">
	    	<h2>VERIFICATION PROCESS</h2>
		</header>
		
		<article class="profile-progress nonprint">
		    <h2>APPLICATION PROGRESS STATUS</h2>
		    <div id="appProgress" class="stepper" data-role="stepper" data-steps="3" data-start="2"></div>
		</article>
		
		<article id="form-frame">
			<header class="span12 nonprint" style="margin-bottom: 5px;">
				<p class="subheader-secondary">VERIFICATION</p>			
				<?php print_r($getCustInfo['Region']); ?>	
			</header>
			
			<section class="span12">
			
				<?php $attributes = array('id' => 'verification_forms'); ?>
    			<?php echo form_open('management/setVerificationInitialyzeForm', $attributes); ?>
				
				<fieldset style="min-width: 1050px;">

					<header class="span12 nonprint"><h6>Personal Information</h6></header>
				
					<!-- PANEL  -->
					<div id="panel_criteria" class="panel span12 nonprint" data-role="panel" style="min-height: 30px; min-width: 1050px; margin-bottom: 10px;">
						<div class="panel-header bg-lightBlue fg-white" style="font-size: 1em;"><i class="icon-user-3 on-left"></i>View Information</div>
						<div class="panel-content" style="display: none;">
							
							<div class="row">
							
								<div class="span6 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลลูกค้า</label></div>
								<div class="span6 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลพนักงาน</label></div>
								
								<div class="span6">
									<label class="label span2 text-left">ชื่อ - นามสกุล</label>	
									<?php $prefix 	= !empty($getCustInfo['PrefixName']) ? $getCustInfo['PrefixName']:""; ?>
									<?php $custname = !empty($getCustInfo['OwnerName']) ? $getCustInfo['OwnerName']:""; ?>	
									<?php $borrower = !empty($getCustInfo['BorrowerName']) ? $getCustInfo['BorrowerName']:""; ?>								
									<div class="label span4 text-left"><?php echo $prefix. ' ' . !empty($borrower) ? $borrower:$custname;  ?></div>
									<input id="borrowername_title" type="hidden" value="<?php echo !empty($borrower) ? $borrower:$custname;  ?>">
								</div>
								<div class="span6">
									<label class="label span2 text-left">ชื่อ - นามสกุล</label>							
									<div class="label span4 text-left"><?php echo !empty($getCustInfo['RMName']) ? $getCustInfo['RMName']:""; ?></div>
								</div>
								
								<div class="span6">
									<label class="label span2 text-left">มาจากช่องทาง</label>	
									<div class="label span4 text-left"><?php echo !empty($getCustInfo['SourceOfCustomer']) ?$getCustInfo['SourceOfCustomer']:"";  ?></div>
								</div>
								<div class="span6">
									<label class="label span2 text-left">รหัสพนักงาน</label>								
									<div class="label span4 text-left"><?php echo !empty($getCustInfo['RMCode']) ? $getCustInfo['RMCode']:""; ?></div>
								</div>
								
								<div class="span6">
									<label class="label span2 text-left">ศักยภาพลูกค้า</label>	
									<div class="label span4 text-left"><?php echo !empty($getCustInfo['CSPotential']) ? $getCustInfo['CSPotential']:""; ?></div>
								</div>
								<div class="span6">
									<label class="label span2 text-left">รหัสสาขา</label>							
									<div class="label span4 text-left"><?php echo !empty($getCustInfo['BranchCode']) ? $getCustInfo['BranchCode']:""; ?></div>
								</div>
								
								<div class="span6">
									<label class="label span2 text-left">เบอร์ติดต่อ</label>	
									<div class="label span4 text-left"><?php echo !empty($getCustInfo['Mobile']) ? $getCustInfo['Mobile']:$getCustInfo['Telephone']; ?></div>
								</div>
								<div class="span6">
									<label class="label span2 text-left">สาขา</label>								
									<div class="label span4 text-left"><?php echo !empty($getCustInfo['Branch']) ? $getCustInfo['Branch']:""; ?></div>
								</div>
								
								<div class="span6">
									<label class="label span2 text-left">วงเงินที่ต้องการ</label>	
									<div class="label span4 text-left"><?php echo !empty($getCustInfo['RequestLoan']) ? number_format($getCustInfo['RequestLoan'], 0):""; ?></div>
								</div>
								<div class="span6">
									<label class="label span2 text-left">เบอร์ติดต่อ</label>							
									<div class="label span4 text-left"><?php echo !empty($getCustInfo['RMMobile']) ? $getCustInfo['RMMobile']:""; ?></div>
								</div>
							
								<div class="span6">
									<label class="label span2 text-left">ประกอบธุรกิจ</label>	
									<?php $businesstype = !empty($getCustInfo['BusinessType']) ? $getCustInfo['BusinessType']:""; ?>
									<?php $business 	= !empty($getCustInfo['Business']) ? $getCustInfo['Business']:""; ?>								
									<div class="label span4 text-left"><?php echo $businesstype. ': ' .$business;  ?></div>
								</div>
								<div class="span6"></div>
							
							</div>
			
						</div>
					</div>
					<!-- /PANEL  -->
					
					<input id="DocID" name="DocID" type="hidden" value="<?php echo !empty($getCustInfo['DocID']) ? $getCustInfo['DocID']:!empty($_GET['rel']) ? $_GET['rel']:''; ?>">
					<input id="BranchCode" name="BranchCode" type="hidden" value="<?php echo $session_data['branchcode']; ?>">
					<input id="Emp_ID" name="Emp_ID" type="hidden" value="<?php echo $session_data['emp_id']; ?>">
					<input id="Emp_Name" name="Emp_Name" type="hidden" value="<?php echo $session_data['thname']; ?>">
					<input id="RequestLoan" name="RequestLoan" type="hidden" value="<?php echo !empty($getCustInfo['RequestLoan']) ? number_format($getCustInfo['RequestLoan'], 0):""; ?>">
					<input id="Department" name="Department" type="hidden" value="<?php echo !empty($getCustInfo['Region']) ? trim($getCustInfo['Region']): '';?>">
					
					<input id="app2ca_latest" name="app2ca_latest" type="hidden" value="<?php echo !empty($AppStatus['data'][0]['CA_ReceivedDocDate']) ? $AppStatus['data'][0]['CA_ReceivedDocDate']:""; ?>">	
					<input id="appno_latest" name="appno_latest" type="hidden" value="<?php echo !empty($AppStatus['data'][0]['ApplicationNo']) ? $AppStatus['data'][0]['ApplicationNo']:""; ?>">		
					<input id="appno_responsed" name="appno_responsed" type="hidden" value="">			
				   	<input id="id_card" name="id_card" type="hidden" value="<?php echo !empty($getVerify['ID_Card']) ? $getVerify['ID_Card']:""; ?>" maxlength="13">
				   	<input id="product_group" name="product_group" type="hidden" value="<?php echo !empty($getCustInfo['LoanGroup']) ? $getCustInfo['LoanGroup']:""; ?>">
				   	<input id="bpm_apptime" name="bpm_apptime" type="hidden" value="<?php echo !empty($BPMAppTime['data'][0]['A2CA_TIME']) ? $BPMAppTime['data'][0]['A2CA_TIME']:"0"; ?>">
					
					<?php 
					
					$this->load->model('dbmodel');
					$this->db_env		= $this->config->item('database_env');
					
					$types 		= $this->dbmodel->CIQuery("SELECT * FROM MasterBorrowerType WHERE IsActive = 'A'");
					$loantypes	= $this->dbmodel->CIQuery("SELECT * FROM ProductLoanType WHERE IsActive = 'A'");
					
					$auth_administrator = $this->config->item('Role_Enabled');
					
					$status_draft 	 	= $this->config->item('DecisionStutus');
					$cancel_onbefore 	= $this->config->item('CancelBefore');
					$full_cancelstatus	= $this->config->item('FullCancel');
					
					$doc_idx = !empty($getCustInfo['DocID']) ? $getCustInfo['DocID']:!empty($_GET['rel']) ? $_GET['rel']:'';
					
					if($this->db_env == 'production') {
						$special_checkDD = $this->dbmodel->CIQuery("
	                    			SELECT [PCIS_DrawdownTemplateInfo].[ApplicationNo], [ApplicationStatus].[Status], [StatusDate],
									[dbo].[DateOnlyFormat]([ApplicationStatus].[PlanDrawdownDate]) [PlanDrawdownDate], [DrawdownReservation], [AppraisalStatus]
									FROM [dbo].[ApplicationStatus]
									INNER JOIN [dbo].[PCIS_DrawdownTemplateInfo]
									ON [dbo].[ApplicationStatus].[ApplicationNo] = [dbo].[PCIS_DrawdownTemplateInfo].[ApplicationNo]
									WHERE [dbo].[ApplicationStatus].[DocID] = '".$doc_idx."'
	                    ");
					} else {
						$special_checkDD = array(
								"data"   => array(0),
								"status" => "false",
								"msg"    => "Not found data."
						);
					}
					
					$blockcheck_idcard  = '';
					$blockcheck_text  = '';
					
					$retrievefield_lock = '';
					$retrievefield_text = '';
					$retrievefield_stat = 'FALSE';
					if(!empty($special_checkDD['data'][0]['ApplicationNo'])) {
						
						if($special_checkDD['data'][0]['DrawdownReservation'] == 'Y' && strtoupper($special_checkDD['data'][0]['AppraisalStatus']) !== 'CANCEL') {
							if(in_array($special_checkDD['data'][0]['Status'], $full_cancelstatus)) {
								$retrievefield_text = 'กรุณาทำการยกเลิกการจอง Drawdown ในระบบ Drawdown Template ก่อนทำ Retrieve';
							}
							
							$retrievefield_stat = 'TRUE';
							if(in_array($session_data['emp_id'], $auth_administrator)):
								$retrievefield_lock = '';
		
							else:
								$retrievefield_lock = 'disabled="disabled" style="background-color: #EBEBE4;"';
							endif;
							
						}
						
						if($special_checkDD['data'][0]['DrawdownReservation'] == 'Y') {
							if(in_array($session_data['emp_id'], $auth_administrator)):
								$blockcheck_idcard  = '';
								$blockcheck_text = '';
							else:
								$blockcheck_idcard = 'disabled="disabled"';
								$blockcheck_text = 'หากต้องการเช็ค ID Card ใหม่ โปรดทำการยกเลิกการจอง  Drawdown ในระบบ Drawdown Templat';
							endif;
						}
		
					}
					
					?>

					<div class="span12">
				        <div class="input-control select">
				            <label id="label_onbehalf" class="span4">On Behalf Of</label>
				            <?php  $behalf = !empty($getVerify['OnBehalf']) ? $getVerify['OnBehalf']:0; ?>
				    
				            <!-- Person -->
				            <div class="input-control radio marginLeft20" <?php echo $none_style; ?>>
				                <label>
				                    <input type="radio" name="on_helf" value="1" <?php if($behalf == 1) echo 'checked="checked"'; ?>>
				                    <span class="check"></span> บุคคล 
				                </label>
				            </div>				            
				            <div class="input-control radio marginLeft20" style="<?php if($useable == "true") echo 'display: none;'; ?>">
				                <label>
				                    <input type="radio" <?php if($behalf == 1) echo 'checked="checked"'; ?> disabled="disabled">
				                    <span class="check"></span> บุคคล 
				                </label>
				            </div>
				            
				            <!-- Corperate -->
				            <div class="input-control radio" style="margin-left: 29px; <?php echo $hide_attr; ?>">
				                <label>
				                    <input type="radio" name="on_helf" value="2" <?php if($behalf == 2) echo 'checked="checked"'; ?>>
				                    <span class="check"></span> นิติบุคคล
				                </label>
				            </div>				            
				            <div class="input-control radio marginLeft20" style="<?php if($useable == "true") echo 'display: none;'; ?>">
				                <label>
				                    <input type="radio" <?php if($behalf == 2) echo 'checked="checked"'; ?> disabled="disabled">
				                    <span class="check"></span> นิติบุคคล 
				                </label>
				            </div>				            
				            
				        </div>				        
				    </div>
				    
				    <!-- Identity Modal -->
	            	<div id="identityListModal" class="modal fade" role="dialog" aria-labelledby="identityListModalLabel" aria-hidden="true">
	                    <div class="modal-dialog" style="max-width: 800px; margin: 0 auto;">
	                    	<div class="modal-content" style="height: auto !important; min-height: auto !important;">
	                        	<div class="modal-header">
	                            	<button type="button" class="close" data-dismiss="modal" style="display: none;"><span aria-hidden="true">&times;</span></button>
	                                <h4 class="modal-title" id="identityListModalLabel">Check Identity Card</h4>
	                            </div>
	                            <div class="modal-body" style="height: 400px; padding: 0 5%;">
	                            
	                            	<div class="grid">
	                            		<div id="identity_content" class="row text-left">
	                           
	                            			<div class="input-control padding5">
	                            				<label class="span3 text-center">ID Card</label>
	                            				<div id="parent_identity_cardno" class="input-control text size3">
	                            					<input id="identity_cardno" name="identity_cardno" type="text" maxlength="13" value="" class="numbersOnly">
	                            					<button class="btn-clear"></button>
	                            				</div>	 
	                            				<button id="btnIdentityVerify" type="button" style="height: 34px; font-weight: bold;">
	                            					<i class="fa fa-search"></i> VERIFY
	                            				</button>  
	                            				<i id="identity_verification" class="fa fa-check fg-green marginLeft5" style="font-size: 1.2em;"></i>	                      				
	                            			</div>
	                            			
	                            			<div class="row text-center" style="width: 80% !important; margin: 0 auto;">
	                            				<table id="table_ncbinfo" ></table>
	                            			</div>
	                       
	                            			<!-- Progress & Response Message  -->
	                            			<div id="identity_progress" style="margin-left: 85px;"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"> Loading...</div> 
	                            			<div id="msg_identityresponsed"></div>                
	                            		
	                            		</div>
	                            	</div>
	                               
	                            </div>
	                            <div class="modal-footer"> 
	                            	<button id="cancelIdentity" type="button" class="btn btn-primary">Close</button>                        	
	                                <button id="confirmIdentity" type="button" disabled="disabled" class="btn bg-lightBlue fg-white" style="margin-right: 30px;"><i class="fa fa-check fg-white on-left"></i>Accept</button>
	                            </div>
	                         </div>
	                    </div>
	                </div>   
					
					<?php $app_status = !empty($AppStatus['data'][0]['Status']) ? $AppStatus['data'][0]['Status']:""; ?> 
					<div id="parent_identify" class="span12">
				        <label id="label_idcard" class="span4"><?php if($behalf == 2) { echo "Business Registration Number"; } else { echo "ID Card"; } ?> <span class="text-warning"><small>(เฉพาะผู้กู้หลัก)</small></span></label>
				        <div class="input-control text span4" style="margin-left: 20px;">
				            <input id="id_card_dump" type="text" value="<?php echo !empty($getVerify['ID_Card']) ? $getVerify['ID_Card']:""; ?>" maxlength="13" disabled="disabled">
				            <button class="btn-clear" tabindex="-1" type="button"></button>
				            <small class="fg-amber" style="white-space: nowrap;"><?php echo($app_status == 'APPROVED') ? 'หมายเหตุ: ระบบไม่อนุญาตให้ตรวจสอบเลขแอพพลิเคชั่นใหม่ กรณีเคสมีผลพิจารณาเป็นอนุมัติ (Approved)':''; ?></small>
				        </div>				       
				        <button id="btnCheckIdentity" type="button" style="margin-left: 5px; height: 33px; width: 85px; <?php echo($app_status == 'APPROVED') ? 'display: none;':''; ?> <?php echo $hide_attr; ?>" <?php echo !empty($blockcheck_idcard) ? $blockcheck_idcard:''; ?>>Check ID</button>
				        <span class="fg-red text-left span12">
				        	<label id="label_idcard" class="span4"></label>
				        	<small class="span8 marginLeft_none marginBottom5"><?php echo $blockcheck_text; ?></small>
				        </span>
				    </div>
				    				    				    
				    <div class="span12">
				    
				    	<?php if($useable === 'false') { echo '<div class="span12" style="position: absolute; background-color: transparent; z-index: 1000; height: 34px;">&nbsp;</div>'; } ?>
				        
				        <div class="input-control select">
				            <label class="span4">Product Program <span id="loadProduct" style="padding-left: 0.1em; font-size: 0.8em;"><i class="fa fa-circle fg-lightBlue" data-hint="กรณีไม่ทำการโหลดข้อมูล คลิก" data-hint-position="top"></i></span></label>
				            <select id="productprg" name="productprg" class="span4" style="<?php echo $bgreadonly; ?>"></select>
				            <?php $prd_loantype  = !empty($getVerify['ProductLoanTypeID']) ? $getVerify['ProductLoanTypeID']:""; ?>
				            <?php $prd_banklist  = !empty($getVerify['Bank']) ? $getVerify['Bank']:""; ?>
				            <input id="bank_bundle" name="bank_bundle" type="hidden" value="<?php echo !empty($prd_banklist) ? $prd_banklist:""; ?>">
				            <select id="loantypes" name="loantypes" class="span3" style="margin-left: 5px; max-width: 160px !important; <?php echo $bgreadonly; ?>">
				            	<option value="" <?php if($prd_loantype == "") echo 'selected="selected"'; ?>>กรุณาเลือกหลักทรัพย์</option>
				            	<?php 
				            	
				            	foreach($loantypes['data'] as $index => $value) {
				            	
				            		if($prd_loantype == $loantypes['data'][$index]['PrdLoanTypeID']) $selected = 'selected="selected"';
				            		else $selected = '';
				            		
				            		echo '<option value="'.$loantypes['data'][$index]['PrdLoanTypeID'].'" '.$selected.'>'.$loantypes['data'][$index]['prdLoanType'].'</option>';
				            	
				            	}
				            	
				            	
				            	?>
				            </select>
				            <select id="banklist" name="banklist" class="span3" style="margin-left: 5px; max-width: 150px !important; <?php echo $bgreadonly; ?>">
				            	<option value="">กรุณาเลือกแบงค์</option>
				            </select>				            
				            <div id="pro_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"> Loading...</div>
				            <input type="hidden" name="productcode_hidden" id="productcode_hidden" value="<?php echo !empty($getVerify['ProductCode']) ? $getVerify['ProductCode']:""; ?>">
				        </div>	
				 		     
				    </div>				    

				    <div class="span12">
				    
				    	<?php if($useable === 'false') { echo '<div class="span12" style="position: absolute; background-color: transparent; z-index: 1000; height: 34px;">&nbsp;</div>'; } ?>
				    	
				        <div class="input-control">
				            <label class="span4">Insurance <span class="text-warning"><small>(กรณีลูกค้าสมัคร คลิก)</small></span></label>
				            <?php $mrta  = !empty($getVerify['MRTA']) ? $getVerify['MRTA']:""; ?>
				            <?php $cashy = !empty($getVerify['Cashy']) ? $getVerify['Cashy']:""; ?>
				            <div class="input-control checkbox marginLeft20">
				                <label>
				                    <input type="checkbox" name="mrta" value="1" <?php if($mrta == 1) echo 'checked="checked"'; ?>>
				                    <span class="check" style="<?php echo $bgreadonly; ?>"></span> MRTA 
				                </label>
				            </div>
				             <div class="input-control checkbox" style="margin-left: 29px;">
				                <label>
				                    <input type="checkbox" name="cashy" value="1" <?php if($cashy == 1) echo 'checked="checked"'; ?>>
				                    <span class="check" style="<?php echo $bgreadonly; ?>"></span> Cashy
				                </label>
				            </div>
				        </div>
				    </div>
				    
				    <!-- Modal -->
					<div class="modal fade nonprint" id="SwitchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog" role="document" style="min-width: 1200px; margin: 0 auto;">
					    <div class="modal-content" style="height: auto !important; min-height: auto !important;">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel">Set New Borrower</h4>
					      </div>
					      <div class="modal-body">
					        <div class="row">
					     		
					     		<div class="span12 form_container" style="margin-left: 10%;">
					     			<table class="table">
					     				<thead style="border: 1px solid #D1D1D1;">
			                        	<tr>
				                            <th align="left" width="110px;">TYPE</th>
				                            <th align="left">NAME - SURNAME</th>
				                            <th class="text-center" colspan="2"> CHANGE</th>
				                            <th class="text-center"> TYPE</th>
				                        </tr>
				                        </thead>
				                        <tbody style="border: 1px solid #D1D1D1;">				   
				                        
				                        	<?php 
								        	
								        	if(empty($NCBConsent[0]['BorrowerName'])) {								        		
								        		echo '<tr><td colspan="6">ท่านยังไม่สามารถปรับปรุงข้อมูลผู้กู้ใดๆได้ในตอนนี้.</td></tr>';
								        		
								        	} else {
								        		
								        		if(count($NCBConsent) >= 2) {
								        			
								        			$i = 1;
								        			foreach($NCBConsent as $index => $value) {
								        				 
								        				$Doc_ID		  = $NCBConsent[$index]['DocID'];
								        				$VerifyID	  = $NCBConsent[$index]['VerifyID'];
								        				$NCB_ID		  = !empty($NCBConsent[$index]['NCS_ID']) ? $NCBConsent[$index]['NCS_ID']:'';
								        				$NCBType	  = !empty($NCBConsent[$index]['BorrowerType']) ? $NCBConsent[$index]['BorrowerType']:'';
								        				$BorrowerName = !empty($NCBConsent[$index]['BorrowerName']) ? $NCBConsent[$index]['BorrowerName']:"";
								        				$NCBIsRef	  = !empty($NCBConsent[$index]['IsRef']) ? $NCBConsent[$index]['IsRef']:"";
								        				 
								        				$ncb_type 	= "";
								        				$ncb_type_1 = "";
								        				$ncb_type_2 = "";
								        				$ncb_type_3 = "";
								        				 
								        				if($NCBConsent[$index]['BorrowerType'] == 101) { $ncb_type_1 = 'selected="selected"'; }
								        				else if($NCBConsent[$index]['BorrowerType'] == 102) { $ncb_type_2 = 'selected="selected"';}
								        				else if($NCBConsent[$index]['BorrowerType'] == 103) { $ncb_type_3 = 'selected="selected"'; }
								        				else if($NCBConsent[$index]['BorrowerType'] == 104) { $ncb_type_4 = 'selected="selected"'; }
								        				else { $ncb_type   = 'selected="selected"'; }
								        					
								        				echo "
								        				<tr>
								        				<td>
								        				<div class=\"input-control select\">									        				
									        				<select style=\"height: 33px;\" disabled=\"disabled\">";
									        			
									        				foreach ($types['data'] as $indexed => $values) {
									        			
									        					if ($NCBConsent[$index]['BorrowerType'] == $types['data'][$indexed]['BorrowerType']):
									        					$selected = 'selected="selected"';
									        					else:
									        					$selected = '';
									        					endif;
									        			
									        					echo '<option value="'.$types['data'][$indexed]['BorrowerType'].'" '.$selected.'>'.$this->effective->get_chartypes($char_mode, $types['data'][$indexed]['BorrowerDesc']).'</option>';
									        			
									        				}
									        			
									        				echo "
									        				</select>
									        				<input id=\"SW_NCB_ID_$i\" name=\"SW_NCB_ID[]\" type=\"hidden\" value=\"$NCB_ID\">
									        				<input id=\"SW_NCBType_$i\" name=\"SW_NCBType[]\" type=\"hidden\" value=\"$NCBType\">
								        				</div>
								        				</td>
								        				<td>
								        				<div class=\"input-control text\">
								        				<input value=\"$BorrowerName\" disabled=\"disabled\">
								        				<input id=\"SW_NCBName_$i\" name=\"SW_NCBName[]\" type=\"hidden\" value=\"$BorrowerName\" disabled=\"disabled\">
								        				<input id=\"SW_NCBVerifyID_$i\" name=\"SW_NCBVerifyID[]\" type=\"hidden\" value=\"$VerifyID\">
								        				<input id=\"SW_NCBIsRef_$i\" name=\"SW_NCBIsRef[]\" type=\"hidden\" value=\"$NCBIsRef\">
								        				</div>
								        				</td>
								        				<td colspan=\"2\" valign=\"middle\" class=\"text-center\"><i class=\"fa fa-long-arrow-right fg-lightBlue fa-2x\"></i></td>
								        				<td>
									        				<div class=\"input-control select info-state\">
									        			
									        					<select id=\"SW_NCBChangeType_$i\" name=\"SW_NCBChangeType[]\" style=\"height: 33px;\" onchange=\"keepDataBundled($i, 'SW_NCBChangeType_$i', 'CH_DFType_$i');\">
										        				<option value=\"\" selected=\"selected\"></option>";
										        				foreach ($types['data'] as $indexed => $values) {
										        					echo '<option value="'.$types['data'][$indexed]['BorrowerType'].'">'.$this->effective->get_chartypes($char_mode, $types['data'][$indexed]['BorrowerDesc']).'</option>';
										        			
										        				}
										        												        			
									        				echo "
											        			</select>
										        			</div>
									        			</td>
										        		</tr>";
									        				
									        			$i++;
								        				 
								        				 
								        			}
								        			
								        		} else {
								        			echo '<tr><td colspan="6">การปรับปรุงข้อมูลผู้กู้ จะต้องมีจำนวนผู้กู้มากกว่า 1 ราย.</td></tr>';
								        		}								        									        		
								        										        		
								        	}
								        	
								        	if(empty($DocFlow[0]['BorrowerName']) ) {
								        		
								        	
								        	} else {
								        	
								        		$i = 1;
								        		foreach($DocFlow as $index => $value) {
								        				
								        			$DocID		  = $DocFlow[$index]['DocID'];
								        			$Rec_ID		  = $DocFlow[$index]['Rec_ID'];
								        			$BorrowerName = !empty($DocFlow[$index]['BorrowerName']) ? $DocFlow[$index]['BorrowerName']:"";
								        			$BorrowerType = !empty($DocFlow[$index]['BorrowerType']) ? $DocFlow[$index]['BorrowerType']:"";
								        			$IsRef		  = $DocFlow[$index]['IsRef'];
			
								        			echo "
														<input id=\"SW_DFRecID_$i\" name=\"SW_RecID[]\" type=\"hidden\" value=\"$Rec_ID\">
										        		<input id=\"SW_DFName_$i\" name=\"SW_DFName[]\" type=\"hidden\" value=\"$BorrowerName\">
										        		<input id=\"SW_DFType_$i\" name=\"SW_DFType[]\" type=\"hidden\" value=\"$BorrowerType\">
										        		<input id=\"SW_DFIsRef_$i\" name=\"SW_DFIsRef[]\" type=\"hidden\" value=\"$IsRef\">
								        											        			
								        				<input id=\"CH_DFType_$i\" name=\"CH_DFType[]\" type=\"hidden\" value=\"\">";

								        			$i++;
								        			
								        		}
								        		
								        		
								        		
								        	}
								        	
								        	echo "
												<script>
											
												 function keepDataBundled(id, parent_field, element_bundled) {													
													 var data_type = $('#' + parent_field + ' option:selected').val();
													 $('#' + element_bundled).val(data_type);
												 }
											
												</script>";
								        	
								        	?>
				                        
				                        </tbody>
					     			</table>
					     		</div>
					        	
					        
					      	</div>
					      </div>
					      <div class="modal-footer">
					      	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>					      	
					        <button id="btnAcceptSwitch" type="button" class="btn btn-primary">Save Changes</button>
					      </div>
					    </div>
					  </div>
					</div>
					
					<!-- NCB Reset Modal -->
	                <div class="modal fade nonprint" id="ncbResetReasonModal" role="dialog" aria-labelledby="ncbResetReasonModalLabel" aria-hidden="true">
	                    <div class="modal-dialog" style="width: 800px !important; margin: 0 auto;">
	                    	<div class="modal-content" style="height: auto !important; min-height: auto !important;">
	                        	<div class="modal-header">
	                            	<button type="button" class="close" data-dismiss="modal" style="display: none;"><span aria-hidden="true">&times;</span></button>
	                                <h4 class="modal-title" id="ncbResetReasonModalLabel">
	                                	<span style="font-size: 1.2em; margin-left: 63px; font-weight: bold;">NCB RESET REASON</span>
	                                	<i id="ca_refresh" class="fa fa-refresh place-right fg-lightBlue marginRight20" style="float: right; cursor: pointer;"></i>	                                	
	                                </h4>                                
	                            </div>
	                            <div class="modal-body">
	                            
									<!-- Rollback value when cancel modal -->
		                            <input id="NCBResetBundledID" name="NCBResetBundledID" type="hidden" value="">
		                            <input id="rollbackNCBResetElement" name="rollbackNCBResetElement" type="hidden" value="">
	                                
	                            	<div class="container">
		                            	<div class="grid">
			                            	<div id="ncbreset_content" class="row"> 
			                            		
			                            		<div class="span6" style="padding-left: 100px;">
			                            			<div class="input-control radio">
				                     					<label class="checked">
				                     						<input id="ncb_reset_1" name="ncb_resetreason" type="radio" value="1">
				                     						<span class="check"></span>
				                     						<span class="label label-clear">Operation ตีคืนเอกสาร NCB</span>
				                     					</label>
			                     					</div>
			                            		</div>		
			                            		<div class="span6 place-left">	                            		
			                     					<div class="input-control radio">
				                     					<label>
				                     						<input id="ncb_reset_2" name="ncb_resetreason" type="radio" value="2">
				                     						<span class="check"></span>
				                     						<span class="label label-clear">ตรวจสอบ NCB ใหม่ เนื่องจากหมดอายุ</span>
				                     					</label>
			                     					</div>			                     				
			                     				</div>	
			                     				
			                            	</div>	                            	
		                                </div>		                                 
	                            	</div>
	                            
	                            </div>
	                            <div class="modal-footer"> 
	                            	<button type="button" class="btn btn-primary" onclick="recoveryNCBData();">Close</button>                           	
	                                <button type="button" class="btn bg-lightBlue fg-white" style="margin-right: 30px;" onclick="submitRecheckNCBReason();">Accept</button>
	                            </div>
	                         </div>
	                    </div>
	                </div>
				    				    
				    <header class="span12" style="margin-top: 10px;">
				    	<h6>NCB Verification</h6>
				    	<section style="position: absolute; min-width: 1045px; margin-top: -30px;">						      		
				    		<span class="tooltip-top nonprint" data-tooltip="Reconcile NCB History" style="float:right; margin-right: 3px; cursor: pointer; font-size: 1.5em;"><i id="NCBConsentLogs" class="icon-history on-right"></i></span>
				    		
				    		<?php 
				    		
				    		if(in_array('074001', $session_data['auth']) || in_array('074003', $session_data['auth']) || in_array('074006', $session_data['auth']) || in_array('074007', $session_data['auth']) || in_array('074008', $session_data['auth'])) {
				    			echo '<span class="tooltip-top nonprint" data-tooltip="Switch Borrower Types" style="float:right; margin-right: 3px; cursor: pointer; font-size: 1.5em;"><i id="NCBConsentSwitch" class="fa fa-random on-right" data-toggle="modal" data-target="#SwitchModal"></i></span>';				    		
				    		}
				    		
				    		?>
				    		
				    		<i id="ErrorTrack" class="fa fa-file-text fg-amber nonprint" style="float:right; margin-right: 3px; cursor: pointer; font-size: 1.3em; display: none;" class="tooltip-right" data-tooltip="Error Tracking"></i>
				    		
				    	</section>	
				    </header>
				    
				    <section class="form_container span12" style="margin-top: -10px;">
				    	<input id="flagno" name="flagno" type="hidden" value="<?php echo $getFlag; ?>">
	                    <table id="expense_table_ncbrefer" data-auth="<?php echo $useable; ?>" style="min-width: 1050px;">
	                        <thead>
	                        	<tr>
		                            <th align="left" width="110px;">TYPE</th>
		                            <th align="left">NAME - SURNAME</th>
		                            <th align="left">NCB</th>
		                            <th align="left">CHECK NCB</th>
		                            <th align="left">LB <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
		                            <th align="left"><i class="fa fa-inbox on-left"></i> HO RECEIVED</th>
		                            <th align="left">HO <i class="fa fa-arrow-right on-right on-left"></i> OPER</th>
		                            <th align="left"><i class="fa fa-arrow-left on-left"></i>RETURN / RE-CHECK</th>
		                            <th><i id="AddNCBRefer" class="fa fa-plus-circle fg-lightGreen nonprint" style="cursor: pointer; font-size: 1.8em; <?php echo $hide_attr; ?>"></i></th>
		                        </tr>
	                        </thead>
	                        <tbody style="<?php echo $hide_attr; ?>">
	                        	<?php 	                        	
	                        	
	                        	if(empty($NCBConsent[0]['BorrowerName'])) {
	                        		
	                        		$this->load->model('dbmodel');
	                        		$result = $this->dbmodel->loadData('NCB', "MainLoanName, CheckNCB, 
																				CASE CheckNCBDate
																					WHEN '1900-01-01' THEN ''
																					WHEN '' THEN ''
																					ELSE CONVERT(nvarchar(10), CheckNCBDate, 120)
																				END AS CheckNCBDate,
																				CASE BrnSentNCBDate
																					WHEN '1900-01-01' THEN ''
																					WHEN '' THEN ''
																					ELSE CONVERT(nvarchar(10), BrnSentNCBDate, 120)
																				END AS BrnSentNCBDate,
																				CASE HQGetNCBDate
																					WHEN '1900-01-01' THEN ''
																					WHEN '' THEN ''
																					ELSE CONVERT(nvarchar(10), HQGetNCBDate, 120)
																				END AS HQGetNCBDate,
																				CASE HQSentNCBToOperDate
																					WHEN '1900-01-01' THEN ''
																					WHEN '' THEN ''
																					ELSE CONVERT(nvarchar(10), HQSentNCBToOperDate, 120)
																				END AS HQSentNCBToOperDate", array("VerifyID" => $getVerify['VerifyID']));
																					                        		
	                        		if($result['status'] == 'true') {
	                        			
	                        		$ncb   = '';
	                        		$ncb_1 = '';
	                        		$ncb_2 = '';
	                        		$ncb_3 = '';
	                        			
	                        		if($result['data'][0]['CheckNCB'] == 2) { $ncb_1 = 'selected="selected"'; }
	                        		else if($result['data'][0]['CheckNCB'] == 1) { $ncb_2 = 'selected="selected"'; }
	                        		else if($result['data'][0]['CheckNCB'] == 3) { $ncb_3 = 'selected="selected"'; }
	                        		else { $ncb = 'selected="selected"'; }
	              	                        		
	                        		$NCBDate	= !empty($result['data'][0]['CheckNCBDate']) ? $this->effective->StandartDateRollback($result['data'][0]['CheckNCBDate']):"";
	                        		$LBSentDate	= !empty($result['data'][0]['BrnSentNCBDate']) ? $this->effective->StandartDateRollback($result['data'][0]['BrnSentNCBDate']):"";
	                        		$HQGetDate	= !empty($result['data'][0]['HQGetNCBDate']) ? $this->effective->StandartDateRollback($result['data'][0]['HQGetNCBDate']):"";
	                        		$HQSentToOp	= !empty($result['data'][0]['HQSentNCBToOperDate']) ? $this->effective->StandartDateRollback($result['data'][0]['HQSentNCBToOperDate']):"";
	                        		
	                        		$NCBChecked = !empty($NCBDate) ? 'checked="checked"':"";
	                        		$LBChecked = !empty($LBSentDate) ? 'checked="checked"':"";
	                        		$HQChecked = !empty($HQGetDate) ? 'checked="checked"':"";
	                        		$OperChecked = !empty($HQSentToOp) ? 'checked="checked"':"";
	                        		
	          
	                        		echo "
									<tr class=\"item_ncbrefer\" table-attr=\"1\">
		                            <td>
		                            	<div class=\"input-control select\">
		                            	<select id=\"NCBRelation_1\" name=\"NCBRelation[]\" style=\"height: 33px;\">
		                            		<option value=\"\"></option>
		                            		<option value=\"101\" selected=\"selected\">ผู้กู้หลัก</option>
		                            	</select>
		                            	</div>
		                            </td>
		                            <td>
		                            	<div class=\"input-control text\">
											<input type=\"hidden\" name=\"NCBIsRef[]\" value=\"\">
		                            		<input type=\"text\" id=\"NCBName_1\" name=\"NCBName[]\" value=".$this->effective->get_chartypes($char_mode, $result['data'][0]['MainLoanName'])." readonly=\"readonly\">
		                            	</div>
		                            </td>
		                            <td>
		                            	<div class=\"input-control select\">
		                            	<select id=\"NCBResult_1\" name=\"NCBResult[]\" style=\"height: 33px;\" onchange=\"checkPassNCBFunction('NCBResult_$i', 'NCBRelation_$i')\">
		                            		<option value=\"\" $ncb></option>
		                            		<option value=\"1\" $ncb_2>ผ่าน</option>
		                            		<option value=\"2\" $ncb_1>ไม่ผ่าน</option>
		                            		<option value=\"3\" $ncb_3>Deviate</option>
		                            	</select>
		                            	</div>
		                            </td>
		                            <td class=\"text-left\">
		                            	<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
							                <label>
							                    <input id=\"ncb_click_1\" type=\"checkbox\" onclick=\"GenDateValidator('ncb_click_1', 'NCBChecked_1');\" $NCBChecked>
							                    <span class=\"check\"></span>
							                </label>
	                        			
							            </div>
								        <div id=\"objNCBChecked_1\" class=\"input-control text\" style=\"width: 120px;\">
								            <input type=\"text\" id=\"NCBChecked_1\" name=\"NCBResultDate[]\" value=\"$NCBDate\" style=\"padding-left: 30px;\">
								        </div>
		                            </td>
		                            <td class=\"text-left\">
		                            	<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
							                <label>
							                    <input id=\"lbsent_click_1\" type=\"checkbox\" onclick=\"GenDateValidator('lbsent_click_1', 'LBSentToHQ_1');\" $LBChecked>
							                    <span class=\"check\"></span>
							                </label>
							            </div>
		                            	 <div id=\"objLBSentToHQ_1\" class=\"input-control text\" style=\"width: 120px;\">
								            <input type=\"text\" id=\"LBSentToHQ_1\" name=\"LBSentToHQ[]\" value=\"$LBSentDate\" style=\"padding-left: 30px;\">
								        </div>
		                            </td>
		                            <td class=\"text-left\">
		                            	<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
							                <label>
							                    <input id=\"receivedlb_click_1\" type=\"checkbox\" onclick=\"GenDateValidator('receivedlb_click_1', 'ReceivedFromLB_1');\" style=\"border-color: #4390df;\" $HQChecked>
							                    <span class=\"check\" style=\"border-color: #4390df;\"></span>
							                </label>
							            </div>
		                            	 <div id=\"objReceivedFromLB_1\" class=\"input-control text\" style=\"width: 120px;\">
								            <input type=\"text\" id=\"ReceivedFromLB_1\" name=\"ReceivedFromLB[]\" value=\"$HQGetDate\" style=\"padding-left: 30px; border-color: #4390df;\">
								        </div>
		                            </td>
		                            <td class=\"text-left\">
		                            	<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
							                <label>
							                    <input id=\"hqtooper_click_1\" type=\"checkbox\" onclick=\"GenDateValidator('hqtooper_click_1', 'HQToOper_1');\" style=\"border-color: #4390df;\" $OperChecked>
							                    <span class=\"check\" style=\"border-color: #4390df;\"></span>
							                </label>
							            </div>
		                            	 <div id=\"objHQToOper_1\" class=\"input-control text\" style=\"width: 120px;\">
								            <input type=\"text\" id=\"HQToOper_1\" name=\"HQToOper[]\" value=\"$HQSentToOp\" style=\"padding-left: 30px; border-color: #4390df;\">
								        </div>
		                            </td>
		                            <td class=\"text-left\">
		                            	<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
							                <label>
							                    <input id=\"returntooper_click_1\" type=\"checkbox\" onclick=\"GenDateValidator('returntooper_click_1', 'OperReturn_1');\">
							                    <span class=\"check\"></span>
							                </label>
							            </div>
		                            	<div id=\"objOperReturn_1\" class=\"input-control text\" style=\"width: 120px;\">
								            <input type=\"text\" id=\"OperReturn_1\" name=\"OperReturn[]\" value=\"\" style=\"padding-left: 30px;\">
								        </div>
		                            </td>
		                            <td class=\"del\" style=\"width: 1.5em;\">&nbsp;</td>
		                        	</tr>";
	                        			
	                        			
	                        		} else {
	                        			
	                        		echo "
									<tr class=\"item_ncbrefer\" table-attr=\"1\">
		                            <td>
		                            	<div class=\"input-control select\">
		                            	<select id=\"NCBRelation_1\" name=\"NCBRelation[]\" style=\"height: 33px;\">
		                               		<option value=\"\"></option>
		                            		<option value=\"101\" selected=\"selected\">ผู้กู้หลัก</option>
		                            	</select>
		                            	</div>
		                            </td>
		                            <td>
		                            	<div class=\"input-control text\">
											<input type=\"hidden\" name=\"NCBIDNo[]\" value=\"\">
											<input type=\"hidden\" name=\"NCBIsRef[]\" value=\"\">
		                            		<input type=\"text\" id=\"NCBName_1\" name=\"NCBName[]\" value=\"\">
		                            	</div>
		                            </td>
		                            <td>
		                            	<div class=\"input-control select\">
		                            	<select id=\"NCBResult_1\" name=\"NCBResult[]\" style=\"height: 33px;\" onchange=\"checkPassNCBFunction('NCBResult_1', 'NCBRelation_1')\">
		                            		<option value=\"\" selected></option>
		                            		<option value=\"1\" >ผ่าน</option>
		                            		<option value=\"2\">ไม่ผ่าน</option>
		                            		<option value=\"3\">Deviate</option>
		                            	</select>
		                            	</div>
		                            </td>
		                            <td class=\"text-left\">
		                            	<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
							                <label>
							                    <input id=\"ncb_click_1\" type=\"checkbox\" onclick=\"GenDateValidator('ncb_click_1', 'NCBChecked_1');\">
							                    <span class=\"check\"></span>
							                </label>
	                        			
							            </div>
								        <div id=\"objNCBChecked_1\" class=\"input-control text\" style=\"width: 120px;\">
								            <input type=\"text\" id=\"NCBChecked_1\" name=\"NCBResultDate[]\" value=\"\" style=\"padding-left: 30px;\">
								        </div>
		                            </td>
		                            <td class=\"text-left\">
		                            	<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
							                <label>
							                    <input id=\"lbsent_click_1\" type=\"checkbox\" onclick=\"GenDateValidator('lbsent_click_1', 'LBSentToHQ_1');\">
							                    <span class=\"check\"></span>
							                </label>
							            </div>
		                            	 <div id=\"objLBSentToHQ_1\" class=\"input-control text\" style=\"width: 120px;\">
								            <input type=\"text\" id=\"LBSentToHQ_1\" name=\"LBSentToHQ[]\" value=\"\" style=\"padding-left: 30px;\">
								        </div>
		                            </td>
		                            <td class=\"text-left\">
		                            	<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
							                <label>
							                    <input id=\"receivedlb_click_1\" type=\"checkbox\" onclick=\"GenDateValidator('receivedlb_click_1', 'ReceivedFromLB_1');\" style=\"border-color: #4390df;\">
							                    <span class=\"check\" style=\"border-color: #4390df;\"></span>
							                </label>
							            </div>
		                            	 <div id=\"objReceivedFromLB_1\" class=\"input-control text\" style=\"width: 120px;\">
								            <input type=\"text\" id=\"ReceivedFromLB_1\" name=\"ReceivedFromLB[]\" value=\"\" style=\"padding-left: 30px; border-color: #4390df;\">
								        </div>
		                            </td>
		                            <td class=\"text-left\">
		                            	<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
							                <label>
							                    <input id=\"hqtooper_click_1\" type=\"checkbox\" onclick=\"GenDateValidator('hqtooper_click_1', 'HQToOper_1');\" style=\"border-color: #4390df;\">
							                    <span class=\"check\" style=\"border-color: #4390df;\"></span>
							                </label>
							            </div>
		                            	 <div id=\"objHQToOper_1\" class=\"input-control text\" style=\"width: 120px;\">
								            <input type=\"text\" id=\"HQToOper_1\" name=\"HQToOper[]\" value=\"\" style=\"padding-left: 30px; border-color: #4390df;\">
								        </div>
		                            </td>
		                            <td class=\"text-left\">
		                            	<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
							                <label>
							                    <input id=\"returntooper_click_1\" type=\"checkbox\" onclick=\"GenDateValidator('returntooper_click_1', 'OperReturn_1');\">
							                    <span class=\"check\"></span>
							                </label>
							            </div>
		                            	<div id=\"objOperReturn_1\" class=\"input-control text\" style=\"width: 120px;\">
								            <input type=\"text\" id=\"OperReturn_1\" name=\"OperReturn[]\" value=\"\" style=\"padding-left: 30px;\">
								        </div>
		                            </td>
		                            <td class=\"del\" style=\"width: 1.5em;\">&nbsp;</td>
		                        	</tr>";
	                        			
	                        		}
	     
								} else {
									
									// NEW UPDATE 24 MAY 1988
									$bypass_auth = !empty($getCustInfo['Region']) ? trim($getCustInfo['Region']): '';

									$i = 1;							
									foreach($NCBConsent as $index => $value) {

										$Doc_ID		  = $getCustInfo['DocID'];
										$BorrowerName = !empty($NCBConsent[$index]['BorrowerName']) ? $NCBConsent[$index]['BorrowerName']:"";
										
										$ncb_type 	= "";
										$ncb_type_1 = "";
										$ncb_type_2 = "";
										$ncb_type_3 = "";
										//$ncb_type_4 = "";
										
										if($NCBConsent[$index]['BorrowerType'] == 101) { $ncb_type_1 = 'selected="selected"'; } 
										else if($NCBConsent[$index]['BorrowerType'] == 102) { $ncb_type_2 = 'selected="selected"';} 
										else if($NCBConsent[$index]['BorrowerType'] == 103) { $ncb_type_3 = 'selected="selected"'; } 
										else if($NCBConsent[$index]['BorrowerType'] == 104) { $ncb_type_4 = 'selected="selected"'; } 
										else { $ncb_type   = 'selected="selected"'; }
										
										$ncb   = '';
										$ncb_1 = '';
										$ncb_2 = '';
										$ncb_3 = '';
										
										//$NCBConsent[$index]['NCBCheck'] == 0 || 
										if($NCBConsent[$index]['NCBCheck'] == 2) { $ncb_1 = 'selected="selected"'; }
										else if($NCBConsent[$index]['NCBCheck'] == 1) { $ncb_2 = 'selected="selected"'; }
										else if($NCBConsent[$index]['NCBCheck'] == 3) { $ncb_3 = 'selected="selected"'; }
										else { $ncb = 'selected="selected"'; }
		
										$NCB_ID		= !empty($NCBConsent[$index]['NCS_ID']) ? $NCBConsent[$index]['NCS_ID']:'';
										$NCBIDCard	= !empty($NCBConsent[$index]['IDNO']) ? $NCBConsent[$index]['IDNO']:'';
										$NCBType	= !empty($NCBConsent[$index]['BorrowerType']) ? $NCBConsent[$index]['BorrowerType']:'';
										$NCBIsRef	= !empty($NCBConsent[$index]['IsRef']) ? $NCBConsent[$index]['IsRef']:"";
										$NCBDate	= !empty($NCBConsent[$index]['NCBCheckDate']) ? $NCBConsent[$index]['NCBCheckDate']:"";
										$NCBSent	= !empty($NCBConsent[$index]['SubmitToHQ']) ? $NCBConsent[$index]['SubmitToHQ']:"";
										$NCBHQGet	= !empty($NCBConsent[$index]['HQReceivedFromLB']) ? $NCBConsent[$index]['HQReceivedFromLB']:"";
										$NCBTOOPER  = !empty($NCBConsent[$index]['HQSubmitToOper']) ? $NCBConsent[$index]['HQSubmitToOper']:"";
										$NCBReturn  = !empty($NCBConsent[$index]['OperReturnDate']) ? $NCBConsent[$index]['OperReturnDate']:"";
										$NCBReturnLog = !empty($NCBConsent[$index]['OperReturnDateLog']) ? substr($NCBConsent[$index]['OperReturnDateLog'], 0, 5):"&nbsp;";
										
										$NCBChecked = !empty($NCBDate) ? 'checked="checked"':"";
										$LBHChecked	= !empty($NCBSent) ? 'checked="checked"':"";
										$HQRChecked = !empty($NCBHQGet) ? 'checked="checked"':"";
										$HQOChecked = !empty($NCBTOOPER) ? 'checked="checked"':"";
										$ORTChecked = !empty($NCBReturn) ? 'checked="checked"':"";	

										if(in_array($bypass_auth, array('SB', 'DRM'))) {
											$role_only  = '';
											$role_block = '';
										} else {
											if($session_data['branchcode'] != '000') {
												$role_only 	= 'data-role="hqonly"';
												$role_block = 'disabled="disabled"';
											} else {
												$role_only  = '';
												$role_block = '';
											}
										}
																				
										
										$oper_date = date('Y-m-d', strtotime($this->effective->StandartDateSorter($NCBReturn)));
										
										if($oper_date != '1970-01-01') {
											$conv_operdate = $oper_date;
											
										} else {
											$conv_operdate = '';
										}
										
										if($conv_operdate == date('Y-m-d')) {
											$oper_returndate = $NCBReturn;
											
										} else {
											$oper_returndate = '';
											
										}
										
										
										if($session_data['branchcode'] != '000') {
										
											if($NCBHQGet != "" || $NCBTOOPER != ""):
											$objDel 	= "<td style=\"width: 1.5em;\">&nbsp;</td>";
											else:
											$objDel 	= "<td class=\"del\" style=\"width: 1.5em;\"><i class=\"fa fa-minus-circle nonprint\" style=\"font-size: 1.5em; color: red; margin-top: -20px;\" onclick=\"delRecordRelation($Doc_ID, '$NCBIsRef', $i)\"></i></td>";
											endif;
												
										} else {
											$objDel 	= "<td class=\"del\" style=\"width: 1.5em;\"><i class=\"fa fa-minus-circle nonprint\" style=\"font-size: 1.5em; color: red; margin-top: -20px;\" onclick=\"delRecordRelation($Doc_ID, '$NCBIsRef', $i)\"></i></td>";
										}
										
										
										if($index == 0):
											$br_fieldonly = 'readonly="readonly"';
										else:
											$br_fieldonly = ''; 
										endif;
																	
										echo "
										<tr class=\"item_ncbrefer\" table-attr=\"$i\">
				                            <td>
				                            	<div class=\"element_hidden\">
				                            	
				                            		<input id=\"bt_hidden_$i\" name=\"BorrowerType_hidden[]\" type=\"hidden\" value=\"\">
				                            		<input id=\"bn_hidden_$i\" name=\"BorrowerName_hidden[]\" type=\"hidden\" value=\"\">
				                            		<input id=\"bc_hidden_$i\" name=\"NCBCheck_hidden[]\" type=\"hidden\" value=\"\">
				                            		<input id=\"bl_hidden_$i\" name=\"SubmitToHQ_hidden[]\" type=\"hidden\" value=\"\">
				                            		<input id=\"bh_hidden_$i\" name=\"HQReceived_hidden[]\" type=\"hidden\" value=\"\">
				                            		<input id=\"bo_hidden_$i\" name=\"SubmitTOOper_hidden[]\" type=\"hidden\" value=\"\">
				                            		<input id=\"br_hidden_$i\" name=\"ReChecked_hidden[]\" type=\"hidden\" value=\"\">
				                            		
				                            		<input id=\"rr_hidden_$i\" name=\"RecheckReason_hidden[]\" type=\"hidden\" value=\"\">
				                            		
				                            		<input id=\"bp_hidden_$i\" name=\"NCBPass_hidden[]\" type=\"hidden\" value=\"\">
				                            		<input id=\"rf_hidden_$i\" name=\"IsRef_hidden[]\" type=\"hidden\" value=\"\">
				                            	</div>
				                            	<div class=\"input-control select\">
				                            	<input id=\"NCBRef_ID\" name=\"NCBRef_ID\" type=\"hidden\" value=\"$NCB_ID\">
				                            	<select id=\"NCBRelation_$i\" name=\"NCBRelation[]\" style=\"height: 33px;\">
				                         ";
												
												foreach ($types['data'] as $indexed => $values) {
													
													if ($NCBConsent[$index]['BorrowerType'] == $types['data'][$indexed]['BorrowerType']):
														$selected = 'selected="selected"';
													else:
														$selected = '';
													endif;
													
													echo '<option value="'.$types['data'][$indexed]['BorrowerType'].'" '.$selected.'>'.$this->effective->get_chartypes($char_mode, $types['data'][$indexed]['BorrowerDesc']).'</option>';
													
												}

				                        echo "    		
				                            	</select>
				                            	<input id=\"BorrowerType_Hidden_$i\" name=\"borrowertype_hidden_field[]\" type=\"hidden\" value=\"$NCBType\">
				                            	</div>
				                            </td>
				                            <td>
				                            	<div class=\"input-control text\">
													<input type=\"hidden\" id=\"NCBIDNo_$i\" name=\"NCBIDNo[]\" value=\"$NCBIDCard\">
				                            		<input type=\"hidden\" id=\"OBJRef_$i\" name=\"NCBIsRef[]\" value=\"$NCBIsRef\">
				                            		<input type=\"text\" id=\"NCBName_$i\" name=\"NCBName[]\" value=\"$BorrowerName\" $br_fieldonly>
				                            	</div>
				                            </td>
				                            <td>
				                            	<div class=\"input-control select\">
				                            	<select id=\"NCBResult_$i\" name=\"NCBResult[]\" style=\"height: 33px;\" onchange=\"checkPassNCBFunction('NCBResult_$i', 'NCBRelation_$i')\">
				                            		<option value=\"\" $ncb></option>
				                            		<option value=\"1\" $ncb_2>ผ่าน</option>
				                            		<option value=\"2\" $ncb_1>ไม่ผ่าน</option>
				                            		<option value=\"3\" $ncb_3>Deviate</option>
				                            	</select>
				                            	</div>
				                            </td>
				                            <td class=\"text-left\">				                            	
									            <div class=\"input-control cb-marginFixedChrome checkbox nonprint\" data-role=\"input-control\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
											        <label>
											            <input id=\"ncb_click_$i\" type=\"checkbox\" onclick=\"GenDateValidator('ncb_click_$i', 'NCBChecked_$i');\" $NCBChecked class=\"cb-marginFixed\">
											            <span class=\"check\"></span>
											        </label>
										   	 	</div>									            
										        <div id=\"objNCBChecked_$i\" class=\"input-control text\" style=\"width: 120px;\">
										            <input type=\"text\" id=\"NCBChecked_$i\" name=\"NCBResultDate[]\" value=\"$NCBDate\" style=\"padding-left: 30px;\">
										        </div>
				                            </td>
				                            <td class=\"text-left\">
				                            	<div class=\"input-control cb-marginFixedChrome checkbox nonprint\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
									                <label>
									                    <input id=\"lbsent_click_$i\" type=\"checkbox\" onclick=\"GenDateValidator('lbsent_click_$i', 'LBSentToHQ_$i');\" $LBHChecked>
									                    <span class=\"check\"></span>
									                </label>
									            </div>
				                            	<div id=\"objLBSentToHQ_$i\" class=\"input-control text\" style=\"width: 120px;\">
										            <input type=\"text\" id=\"LBSentToHQ_$i\" name=\"LBSentToHQ[]\" value=\"$NCBSent\" style=\"padding-left: 30px;\">
										        </div>
				                            </td>
				                            <td class=\"text-left\">
				                            	<div class=\"input-control cb-marginFixedChrome checkbox nonprint\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
									                <label>
									                    <input $role_block $role_only id=\"receivedlb_click_$i\" type=\"checkbox\" onclick=\"GenDateValidator('receivedlb_click_$i', 'ReceivedFromLB_$i');\" $HQRChecked>
									                    <span class=\"check\" style=\"border-color: #4390df;\"></span>
									                </label>
									            </div>
				                            	 <div id=\"objReceivedFromLB_$i\" class=\"input-control text\" style=\"width: 120px;\">
										            <input $role_only type=\"text\" id=\"ReceivedFromLB_$i\" name=\"ReceivedFromLB[]\" value=\"$NCBHQGet\" style=\"padding-left: 30px; border-color: #4390df;\" maxlength=\"10\">
										        </div>
				                            </td>
				                            <td class=\"text-left\">
				                            	<div class=\"input-control cb-marginFixedChrome checkbox nonprint\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
									                <label>
									                    <input $role_block $role_only id=\"hqtooper_click_$i\" type=\"checkbox\" onclick=\"GenDateValidator('hqtooper_click_$i', 'HQToOper_$i');\" $HQOChecked>
									                    <span class=\"check\" style=\"border-color: #4390df;\"></span>
									                </label>
									            </div>
				                            	 <div id=\"objHQToOper_$i\" class=\"input-control text\" style=\"width: 120px;\">
										            <input $role_only type=\"text\" id=\"HQToOper_$i\" name=\"HQToOper[]\" value=\"$NCBTOOPER\" style=\"padding-left: 30px; border-color: #4390df;\" maxlength=\"10\">
										        </div>
				                            </td>
				                            <td class=\"text-left\">
				                            	<div class=\"input-control cb-marginFixedChrome checkbox nonprint\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
									                <label>
									                    <input id=\"returntooper_click_$i\" type=\"checkbox\" onclick=\"GenDateValidator('returntooper_click_$i', 'OperReturn_$i'); resetRelatedFields($i, 'OperReturn_$i'); setReturnDateByText('returntooper_click_$i', 'rencb_$i');\">
									                    <span class=\"check\"></span>
									                </label>
									            </div>
				                            	<div id=\"objOperReturn_$i\" class=\"input-control text\" style=\"width: 120px;\">
				                            		<p id=\"rencb_$i\" style=\"margin-left: 25px; padding-top: 7px; padding-left: 10px; font-size: 1em;\">$NCBReturnLog</p>
										            <input type=\"hidden\" id=\"OperReturn_$i\" name=\"OperReturn[]\" value=\"\" style=\"padding-left: 30px;\">
										        </div>
				                            </td>
				                            $objDel				                           
			                        	</tr>";
										
										$i++;
										
									}
																		
								}
								
	                        		
	                        ?>
	                        	
		                      
	                        </tbody>
	                    </table>
 						 <?php
		                	echo "<script>
 		
								  function GenDateValidator(id, bundled) {
										var str_date;
									    var objDate = new Date();
									    str_date = ('0' + objDate.getDate()).slice(-2) + '/' + ('0' + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
								        var elements =  $('#' + id).is(':checked');
								        if(elements) {
								            $('#' + bundled).val(str_date);
								        } else {
								            $('#' + bundled).val('');
								        }
								  }
 		
 								 
 		 						  function resetRelatedFields(id, bundled) {
 		
 									  var element_return = $('#' + bundled).val();
 									  if(element_return == '') {
 											
 		
 									  } else {
 		
 										 if(confirm('ยืนยันการรีเซ็ทข้อมูลหรือไม่')) {
											// Hidden Bundled
			
											var borrower_type	= $('#BorrowerType_Hidden_' + id).val();
											var borrower_name	= $('#NCBName_' + id).val();
											var ncb_pass		= $('#NCBResult_' + id).val();
			 								var ncb_checked		= $('#NCBChecked_' + id).val();
 											var submitToHQDate	= $('#LBSentToHQ_' + id).val();
 											var hqReceivedDate	= $('#ReceivedFromLB_' + id).val();
 											var hqToOperation	= $('#HQToOper_' + id).val();
											var reCheckedDate	= $('#OperReturn_' + id).val();
											var is_ref			= $('#OBJRef_' + id).val();
			
			
											$('#bt_hidden_' + id).val(borrower_type);
				                            $('#bn_hidden_' + id).val(borrower_name);
				                            $('#bc_hidden_' + id).val(ncb_checked);
				                            $('#bl_hidden_' + id).val(submitToHQDate);
				                            $('#bh_hidden_' + id).val(hqReceivedDate);
				                            $('#bo_hidden_' + id).val(hqToOperation);
				                            $('#br_hidden_' + id).val(reCheckedDate);
			
											$('#bp_hidden_' + id).val(ncb_pass);
											$('#rf_hidden_' + id).val(is_ref);
													
			
 											// Clear Field		
											$('#NCBResult_' + id).find('option[value=\"\"]').attr('selected', 'selected');
			
											$('#ncb_click_' + id).prop('checked', false);
 											$('#lbsent_click_' + id).prop('checked', false);
									 		$('#receivedlb_click_' + id).prop('checked', false);	
									 		$('#hqtooper_click_' + id).prop('checked', false);
 												
										    $('#NCBChecked_' + id).val('');
 											$('#LBSentToHQ_' + id).val('');
 											$('#ReceivedFromLB_' + id).val('');
 											$('#HQToOper_' + id).val('');
			
											// Rechecked Bundled with Show modal
											$('#ncbResetReasonModal').modal({
		                        				show: true,
            									keyboard: false,
												backdrop: 'static'
		                        			}).draggable();
			
											var re_ncb = $('#rencb_' + id).text();
			
											$('#NCBResetBundledID').val(id);											
											$('#rollbackNCBResetElement').val(re_ncb);
											
 		 									return true;
 									  	 }
 		
 										 $('#returntooper_click_' + id).prop('checked', false);
 									     $('#' + bundled).val('');
			
 									  	 return false;
 		
 									  }
 							
 								  }
			
								  function submitRecheckNCBReason() {
			
									  if(confirm('ยืนยันการเลือกเหตุผลในการรีเซ็จข้อมูล NCB หรือไม่')) {
			
										  var row_id	 = $('#NCBResetBundledID').val();
										  var ncb_reason = $('input[name=\"ncb_resetreason\"]:checked').val();
			
										  $('#rr_hidden_' + row_id).val(ncb_reason);
										  $('#ncbResetReasonModal').modal('hide');
										  
										  $('input[name=\"ncb_resetreason\"]').prop('checked', false);
			
									      return true;							  
			
									  }	
			
									  return false;
			
								  }
			
								  function recoveryNCBData() {
									  // Element Reference
									  var id	 = $('#NCBResetBundledID').val();
									 
			 						  // Object Bundled
									  var borrower_type		= $('#bt_hidden_' + id).val();
				                      var borrower_name		= $('#bn_hidden_' + id).val();
				                      var ncb_pass			= $('#bp_hidden_' + id).val();
									  var ncb_checked		= $('#bc_hidden_' + id).val();
				                      var submitToHQDate	= $('#bl_hidden_' + id).val();
				                      var hqReceivedDate	= $('#bh_hidden_' + id).val();
				                      var hqToOperation		= $('#bo_hidden_' + id).val();
				                      var recheckedDate		= $('#br_hidden_' + id).val();
									  var rencb_text		= $('#rollbackNCBResetElement').val();
								
									  if(ncb_pass !== \"\") {
										  $('#NCBResult_' + id).find('option[value=\"'+ ncb_pass +'\"]').attr('selected', 'selected');
								      }
			
									  $('#NCBChecked_' + id).val(ncb_checked);
 									  $('#LBSentToHQ_' + id).val(submitToHQDate);
 									  $('#ReceivedFromLB_' + id).val(hqReceivedDate);
 									  $('#HQToOper_' + id).val(hqToOperation);
									  $('#OperReturn_' + id).val('')
			
									  if(ncb_checked !== \"\") { $('#ncb_click_' + id).prop('checked', true); }
									  if(submitToHQDate !== \"\") { $('#lbsent_click_' + id).prop('checked', true); }
									  if(hqReceivedDate !== \"\") { $('#receivedlb_click_' + id).prop('checked', true); }
									  if(hqToOperation !== \"\") { $('#hqtooper_click_' + id).prop('checked', true); }
			
									  $('#returntooper_click_' + id).prop('checked', false);
 									  $('#OperReturn_' + id).val('');
									  $('#rencb_' + id).text(rencb_text);
			
									  $('#ncbResetReasonModal').modal('hide');
						
								  }

 								  function removeAddNCBRecord() {
								   		$('body').on('click', '#expense_table_ncbrefer .del', function() {
									        var tr_length = $('#expense_table_ncbrefer tr.item_ncbrefer').length;											
									        if(parseInt(tr_length) > 1) {
									            $(this).parent().remove();	
									            
									        } else {
									            $('#expense_table_ncbrefer').parent().after('<span class=\"ncb_error text-danger span5\">หากแถวที่ระบุน้อยกว่าที่กำหนดจะไม่สามารถลบแถวได้..</span>').fadeIn();
									            $('.ncb_error').fadeOut(5000);
									            
									        }
									    });
								  }
 								 			
								  function delRecordRelation(bundled, name, rows) {
				                            	 		
                            	  	if(confirm('ยืนยันการลบข้อมูลหรือไม่')) {

										var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + \"//\" + window.location.host;
										var pathFixed = window.location.protocol + \"//\" + window.location.host;
										for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += \"/\"; }
			
										$.ajax({
                                        	url: pathFixed+'management/delRecordBorrowerLoan?_=' + new Date().getTime(),
                                            type: 'POST',
											data: {
												relx: bundled,
												refx: name,
												modx: 'rclx7'
											},
                                            success:function(data) {
												var not = $.Notify({ content: \"ลบข้อมูลสำเร็จ\", style: { background: \"green\", color: \"#FFFFFF\" }, timeout: 10000 });
    											not.close(7000);                                      														
											},
                                            complete:function() {
												
                                            },
                                            cache: false,
                                            timeout: 5000,
                                            statusCode: {
                                            	404: function() {
                                                	alert('page not found.');
                                                },
                                                407: function() {
                                                	console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
                                                },
                                                500: function() {
                                                  	console.log('internal server error.');
                                                }
											}
										});										
										
										$('body').on('click', '#expense_table_ncbrefer .del', function() {
									        var tr_length = $('#expense_table_ncbrefer tr.item_ncbrefer').length;											
									        if(parseInt(tr_length) > 1) {
									            $(this).parent().remove();	
												$('#expense_table_relation tbody').find('tr[table-attr=\"'+parseInt(rows)+'\"]').remove();								
									            
									        } else {
									            $('#expense_table_ncbrefer').parent().after('<span class=\"ncb_error text-danger span5\">หากแถวที่ระบุน้อยกว่าที่กำหนดจะไม่สามารถลบแถวได้..</span>').fadeIn();
									            $('.ncb_error').fadeOut(5000);
									            
									        }
									    });

					                    return true;
                            	 		
                            	 	}
					                  
					              	return false;
                            	 		
                            	  }
			
								  function checkPassNCBFunction(ncb_check, type) {
										var ncb_check = $('#' + ncb_check + ' option:selected').val();
										var cust_type = $('#' + type + ' option:selected').val();
										console.log(ncb_check, cust_type);
										if(cust_type == '101') {		
										
											if(in_array(ncb_check, [2, 0])) {
												
												//var str_date;
									    		//var objDate = new Date();
									    		//str_date = ('0' + objDate.getDate()).slice(-2) + '/' + ('0' + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
			
												$('#rmprocess').css('background', '#EBEBE7').prop('disabled', true);
												$('#rmprocess').find('option[value=\"\"]').prop('selected', true);
												$('#rmprocessdate, #rmprocessdate_fake, #rmprocessdate_draft').val();
												$('#plan_a2ca').val('').prop('disabled', true);
				        		
												$('#defenseByRM').prop('checked', false).prop('disabled', true).css('background', '#EBEBE7');
				        						$('#defenseBySFE').prop('checked', false).prop('disabled', true).css('background', '#EBEBE7');		
				        						$('#defend_process').prop('disabled', true).css('background', '#EBEBE7');
												$('#defend_process').find('option[value=\"\"]').prop('selected', true);
				        						$('#defend_date, #defend_date_disbled').val('');			
												$('#reactivate').find('option[value=\"\"]').prop('selected', true);	
				        						$('#reactivate').css('background', '#EBEBE7').prop('disabled', true);
												$('#reactivate_plan').val('');												
												$('#retrieve_reason').find('option[value=\"\"]').prop('selected', true);	
				        						$('#retrieve_reason').css('background', '#EBEBE7').prop('disabled', true);
												$('#retrieveDate, #objRetrieveDate').val('');
												$('#actionnote').prop('disabled', true);
			
												$('#parent_plan_a2ca').unbind('click');
												$('#expense_table_relation .item_relation').addClass('hide');
							        		
											} else {
			
												var rmprocess = $('#rmprocess').val();
												var rmondate  = $('#rmprocessdate_draft').val();
												if(rmprocess == '' && rmondate == '') {
													$('#rmprocess').css('background', '#FFFFFF').prop('disabled', false);
													$('#rmprocess').find('option[value=\"\"]').prop('selected', true);
													$('#rmprocessdate, #rmprocessdate_fake, #rmprocessdate_draft').val('');
													$('#plan_a2ca').val('').prop('disabled', false);
					        					
					        						$('#defenseByRM').prop('disabled', false).css('background', '#FFFFFF');
					        						$('#defenseBySFE').prop('disabled', false).css('background', '#FFFFFF');
					        						$('#defend_process').prop('disabled', false).css('background', '#FFFFFF');
													$('#defend_process').find('option[value=\"\"]').prop('selected', true);	
													$('#defend_process').css('background', '#FFFFFF').prop('disabled', false);
													$('#defend_date, #defend_date_disbled').val('');	
					        							
													if(in_array(rmprocess, ['CANCELBYRM', 'CANCELBYCUS', 'CANCELBYCA'])) {
														$('#reactivate').find('option[value=\"\"]').prop('selected', true);	
						        						$('#reactivate').css('background', '#FFFFFF').prop('disabled', false);
														$('#reactivate_plan').val('');												
														$('#retrieve_reason').find('option[value=\"\"]').prop('selected', true);	
						        						$('#retrieve_reason').css('background', '#FFFFFF').prop('disabled', false);
														$('#retrieveDate, #objRetrieveDate').val('');
														$('#actionnote').prop('disabled', false);
													} else {
														$('#reactivate').css('background', '#EBEBE7').prop('disabled', true);
														$('#retrieve_reason').css('background', '#EBEBE7').prop('disabled', true);
													}
				
													$('#root_plan_a2ca').html('<label id=\"label_plan_a2ca\" class=\"span4\">A2CA Plan Date</label><div id=\"parent_plan_a2ca\" class=\"input-control text span6\" style=\"margin-left: 20px;\"><input id=\"plan_a2ca\" name=\"plan_a2ca\" type=\"text\" value=\"\" readonly=\"readonly\" style=\"max-width: 180px;\"></div>');
													$('#parent_plan_a2ca').Datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
													$('#expense_table_relation .item_relation').removeClass('hide');
												}
												
											}
										}

								  }

								  </script>";
		                ?>
		                
                	</section>
                	
                	<div class="span12" style="<?php echo (!empty($hide_attr)) ? '' : 'margin-top: 10px'; ?> <?php echo $hide_attr; ?>">
				        <div id="resource_parent" class="input-control textarea">
				            <label class="span4">NCB Comment</label>
				            <textarea id="ncb_comment"  name="ncb_comment" rows="3" class="span4"><?php echo !empty($getVerify['Comments']) ? $getVerify['Comments']:""; ?></textarea>
				            <span id="objFixed" class="none nonprint" style="margin-left: 10px; font-size: 1.3em;" data-hint="ขยายข้อความ" data-hint-position="top">
                         		<i class="icon-menu fg-lightBlue" style="margin-top: 1.2em;"></i>
                        	</span>
				        </div>				        
				   	</div>
				   	
				   	<?php
				   	
				   	echo "
					<script>
				
						$('#objFixed').bind('click', function() {
    	
					    	var fixed = $('#objFixed').attr('class');
					    	if(fixed == 'none') {
					    		
					    		$('#objFixed').removeClass('none').addClass('expend');
					            $('textarea').animate({
					            	'overflow-y':'hidden',
					            	'height': '300px'            	
					            }, 500);
					            
					    	} else {
					    		
					    		$('#objFixed').removeClass('expend').addClass('none');
					            $('textarea').animate({
					            	'overflow-y':'hidden',
					            	'height': '72px'
					            	
					            }, 500);
					    		
					    	}
					
					    });
			
					</script>";
				   	
				   	?>
				   	
				   	<div class="span12" style="margin-top: 10px;">
					<?php 
				
					$rmprocess = !empty($getVerify['RMProcess']) ? $getVerify['RMProcess']:"";
										
					if($DefProcess['AppToCA'] == ''):
						$ca_lockfiled = 'disabled="disabled"';
					else:
						$rm_lockfiled = 'disabled="disabled"';			
					endif;
					
					if(in_array($session_data['emp_id'], $auth_administrator)):
						$lock_onbefore = '';
						$lock_afterpro = '';
					else:
						$lock_onbefore = !empty($ca_lockfiled) ? $ca_lockfiled:'';
						$lock_afterpro = !empty($rm_lockfiled) ? $rm_lockfiled:'';					
					endif;	
	
					//if($DefProcess['Status'] != '' && in_array($DefProcess['Status'], $status_draft)):	
					if(!empty($DefProcess['CA_ReceivedDocDate']) || in_array($DefProcess['Status'], $status_draft)):
						if(in_array($session_data['emp_id'], $auth_administrator)) {
							$field_rmlock = '';
						} else {
							$field_rmlock = 'disabled="disabled"';
						}						
					else:
						$field_rmlock = '';
					endif;
			
					if(in_array($rmprocess, $cancel_onbefore)):
						$lock_obeforezone = 'disabled="disabled"';
					endif;
					
					$zone_locked = !empty($lock_obeforezone) ? $lock_obeforezone:'';
					
					// ReActivate
					if(in_array($DefProcess['Status'], $cancel_onbefore) && empty($DefProcess['CA_ReceivedDocDate'])):
						$reactivate_locked = '';						
					else:
						$reactivate_locked = 'disabled="disabled" style="background: #EBEBE4;"';					
					endif;
					
					$caprocess_locked = !empty($field_rmlock) ? $field_rmlock:$lock_onbefore;
					if(!empty($DocExpired['data'][0]['ActionNote'])):
						$docexpired_lock = true;
					else:
						$docexpired_lock = false;	
					endif;
												
					?>
				
					</div>
	
                	<header class="span12" style="margin-top: 10px;"><h6>RM ON HAND</h6></header>               
                	<div class="span12">
                	
                		<?php if($useable === 'false') { echo '<div class="span12" style="position: absolute; background-color: transparent; z-index: 1000; height: 34px;">&nbsp;</div>'; } ?>
				       
				        <div id="parent_rmprocess" class="input-control select">
				            <label id="label_rmprocess" class="span4">RM Process</label>
				            <input id="rmprocess_rollback" name="rmprocess_rollback" type="hidden" value="<?php echo $rmprocess; ?>">
				            <input id="rmprocess_draft" name="rmprocess_draft" type="hidden" value="<?php echo $rmprocess; ?>">
				            <select id="rmprocess" name="rmprocess" class="span2 size2" style="min-width: 180px; height: 34px; <?php echo $bgreadonly; ?>">
				                <option value="" <?php echo $zone_locked; ?>>-- โปรดเลือก --</option>
				                <optgroup label="On Process">
					                <option value="ระหว่างติดตามเอกสาร" <?php if($rmprocess == "ระหว่างติดตามเอกสาร") echo "selected"; ?> <?php echo !empty($field_rmlock) ? $field_rmlock:''; echo $zone_locked; ?>>ระหว่างติดตามเอกสาร</option>
					                <option value="ระหว่างคีย์เอกสารการเงิน" <?php if($rmprocess == "ระหว่างคีย์เอกสารการเงิน") echo "selected"; ?> <?php echo !empty($field_rmlock) ? $field_rmlock:''; echo $zone_locked; ?>>ระหว่างคีย์เอกสารการเงิน</option>
					                <option value="ระหว่างคำนวน DSCR" <?php if($rmprocess == "ระหว่างคำนวน DSCR") echo "selected"; ?> <?php echo !empty($field_rmlock) ? $field_rmlock:''; echo $zone_locked; ?>>ระหว่างคำนวน DSCR</option>
					                <option value="ระหว่างคีย์ Call Report" <?php if($rmprocess == "ระหว่างคีย์ Call Report") echo "selected"; ?> <?php echo !empty($field_rmlock) ? $field_rmlock:''; echo $zone_locked; ?>>ระหว่างคีย์ Call Report</option>
					                <option value="ระหว่างคีย์ BPM" <?php if($rmprocess == "ระหว่างคีย์ Tels" || $rmprocess == "ระหว่างคีย์ BPM") echo "selected"; ?> <?php echo !empty($field_rmlock) ? $field_rmlock:''; echo $zone_locked; ?>>ระหว่างคีย์ BPM</option>
					                <option value="Completed" <?php if($rmprocess == "Completed") echo "selected"; ?> <?php echo !empty($field_rmlock) ? $field_rmlock:''; echo $zone_locked; ?>>Completed</option>
				                </optgroup>
				                <optgroup label="Cancel Before Process">
					                <option value="CANCELBYRM" <?php if($rmprocess == "CANCELBYRM" || $rmprocess == "ยกเลิก โดย RM") echo "selected"; ?> <?php echo !empty($field_rmlock) ? $field_rmlock:$lock_afterpro; echo $zone_locked; ?>>ยกเลิก โดย RM</option>
	                				<option value="CANCELBYCUS" <?php if($rmprocess == "CANCELBYCUS" || $rmprocess == "ยกเลิก โดย ลูกค้า") echo "selected"; ?> <?php echo !empty($field_rmlock) ? $field_rmlock:$lock_afterpro; echo $zone_locked; ?>>ยกเลิก โดย ลูกค้า</option>
	                				<option value="CANCELBYCA" <?php if($rmprocess == "CANCELBYCA") echo "selected"; ?> <?php if($docexpired_lock == false) echo $caprocess_locked; if($docexpired_lock == false) echo $zone_locked; ?>>ยกเลิก โดย CA</option>
				                </optgroup>
				            </select>
				            <div id="ClndrRMPD" class="input-control text span1 size2 marginRight5" style="margin-left: 5px; max-width: 115px;">
			                    <input id="rmprocessdate"  name="rmprocessdate" type="hidden" value="<?php echo !empty($getVerify['RMProcessDate']) ? $getVerify['RMProcessDate']:""; ?>"> 
			                    <input id="rmprocessdate_fake" value="<?php echo !empty($getVerify['RMProcessDate']) ? $getVerify['RMProcessDate']:""; ?>" disabled="disabled"> 
			                    <input id="rmprocessdate_draft" type="hidden" value="<?php echo !empty($getVerify['RMProcessDate']) ? $getVerify['RMProcessDate']:""; ?>">
			                	<button class="btn-clear" type="button" onclick="$('#rmprocessdate').val('');"></button>
				            </div>	
				            
				           
				            <div class="toolbar fg-black nonprint" class="place-left">
				            	<?php if(!empty($RmReason['data'][0]['DocID']) || !empty($CustReason['data'][0]['DocID'])) { ?>
				            	<span id="RmProcessReasonLogs" class="tooltip-top show-pop-list" data-tooltip="Cancel Reason History (Before & After Process)" data-placement="right">
				            		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
				            	</span>	
				            	<?php } ?>			    
				            </div>   
				          
				             
				            <div id="rmprocess_alert" class="span3 text-danger"></div>
				        </div>
			    	</div>
		    	
			    	<div id="objRMProcessListBox" style="display: none;">
			    		<?php 
			    		
				    		if(empty($RmReason['data'][0]['DocID'])) {
				    			
				    			if(empty($CustReason['data'][0]['DocID'])) {
				    				echo "<div>ไม่พบข้อมูล</div>";
				    			}
				    			
				    		
				    		} else {
				    			
				    			echo "<h5>เหตุผลการยกเลิก (RM/CA)</h5>";
				    			
				    			$iz = 1;
				    			foreach ($RmReason['data'] as $index => $value) {
				    				
				    				if(!empty($RmReason['data'][$index]['OtherReason'])):
				    					$text_cancelreason = $RmReason['data'][$index]['MasterReason']. ' ' .$RmReason['data'][$index]['OtherReason'];
				    				else:
				    					$text_cancelreason = $RmReason['data'][$index]['MasterReason'];
				    				endif;
				    		
				    				echo "<div>". $iz .'. '. $text_cancelreason ."</div>";
    		
    								$iz++;
				    			}
				    			
				    		}
			    		
				    		if(empty($CustReason['data'][0]['DocID'])) {
							    		
				    		} else {
				    			 
				    			echo "<h5>เหตุผลการยกเลิกจากลูกค้า</h5>";
				    			 
				    			$iz = 1;
				    			foreach ($CustReason['data'] as $index => $value) {
				    		
				    				if(!empty($CustReason['data'][$index]['OtherReason'])):
				    					$text_custcancelreason = $CustReason['data'][$index]['MasterReason']. ' ' .$CustReason['data'][$index]['OtherReason'];
				    				else:
				    					$text_custcancelreason = $CustReason['data'][$index]['MasterReason'];
				    				endif;
				    		
				    				echo "<div>". $iz .'. '. $text_custcancelreason ."</div>";
				    		
				    				$iz++;
				    			}
				    			 
				    		}
				    		 
			    		
			    		?>
			    	</div>
			
			    	<div class="span12" style="margin-top: -25px;">
			    	<label class="span4">&nbsp;</label>
			    	<div class="span4 nonprint">
			    		<div class="listview-outlook" data-role="listview">
							<div class="list-group collapsed">
								<a href="" class="group-title" style="text-decoration: none;">RM process logs</a>
								<div class="group-content" style="height: 250px; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;"> 
									
										
										<?php 
								
											if(empty($rmlogs[0])) {
												echo "<div class=\"list-content\">ไม่พบข้อมูล</div>";									
		
											} else {
											
												foreach ($rmlogs as $index => $values) {
												
													$emp = !empty($rmlogs[$index]['EmployeeName']) ? $this->effective->get_chartypes($char_mode, $rmlogs[$index]['EmployeeName']):$rmlogs[$index]['EmployeeCode'];
													echo '
    												<a href="#" class="list" style="text-decoration: none;">
						    						<div class="list-content">
														<span class="list-title" style="font-size: 0.8em;"></span>
														<span class="list-subtitle">'.$rmlogs[$index]['ProcessDate'].' '.$rmlogs[$index]['ProcessTime'].' <span style="font-weight: normal">Update By : '.$emp.'</span></span>
														<span style="font-size: 0.8em;">'.$this->effective->get_chartypes($char_mode, $rmlogs[$index]['ProcessType']).'</span>
													</div>
            										</a>';
													
													
											
												}
												
											
												
		
											}
									
										?>
									
										
									</div>
								</div>
					    	</div>	    
					    </div>
				   	</div>
				   	
				    <?php
				   	
					   $app2ca_history = $this->dbmodel->CIQuery("
							SELECT DocID, CONVERT(nvarchar(10), A2CA_PlanDate, 120) AS A2CA_PlanDate,
							SUBSTRING(CONVERT(nvarchar(19), A2CA_PlanDate, 120), 11, 10) ASA2CA_PlanTime, IsActive, CreateBy, 
							CONVERT(nvarchar(10), CreateDate, 120) AS CreateDate
							FROM AppToCA_History
				   			WHERE DocID = '".$getCustInfo['DocID']."'
				   			ORDER BY A2CA_PlanDate DESC
				   	   ");	
					   
					   $plan2ca_inquiry = $this->dbmodel->CIQuery("
					   SELECT ApplicationStatus.DocID, BorrowerName, CONVERT(nvarchar(10), ReconcileDoc.ReceivedDocFormLB, 120) AS HQReceivedDocDate, 
					   CONVERT(nvarchar(10), ReconcileDoc.AppToCA, 120) AS HQSendDocToCA,
					   CONVERT(nvarchar(10), ApplicationStatus.CA_ReceivedDocDate, 120) AS CA_ReceivedDocDate,					   		 
					   ApplicationStatus.[Status], 
					   CONVERT(nvarchar(10), ApplicationStatus.StatusDate, 120) AS StatusDate					   		
					   FROM ApplicationStatus
					   LEFT OUTER JOIN ReconcileDoc
					   ON ApplicationStatus.DocID = ReconcileDoc.DocID AND BorrowerType = '101'
					   WHERE ApplicationStatus.DocID = '".$getCustInfo['DocID']."'");
				
					   $plan_a2ca_locked = '';					   
					   if(empty($getVerify['AppToCAPlanDate'])) {
					   	$diff_date	= 0;
					   
					   } else {
					   	
					   	if(!empty($plan2ca_inquiry['data'][0]['HQReceivedDocDate'])):
					   						   
					   		$is_true = $this->effective->compare_checkdate($plan2ca_inquiry['data'][0]['HQReceivedDocDate'], $this->effective->StandartDateSorter($getVerify['AppToCAPlanDate']));
					   		if($is_true == 'FALSE') {
								
								/*
				   				if(!empty($plan2ca_inquiry['data'][0]['HQSendDocToCA'])):
					   				$compare_hqtoca  = $this->effective->compare_checkdate($plan2ca_inquiry['data'][0]['HQSendDocToCA'], $this->effective->StandartDateSorter($getVerify['AppToCAPlanDate']));
					   			else:
					   				$compare_hqtoca  = 'FALSE';	
					   			endif;						   			
					   								   			
					   			if($compare_hqtoca == 'TRUE') {
					   				$diff_date = $this->effective->compare_date(array('begin'=> $plan2ca_inquiry['data'][0]['HQSendDocToCA'], 'end'=> $this->effective->StandartDateSorter($getVerify['AppToCAPlanDate'])));
					   			} else {
					   				$diff_date = $this->effective->compare_date(array('begin'=> date('Y-m-d'), 'end'=> $this->effective->StandartDateSorter($getVerify['AppToCAPlanDate'])));
					   			}					   			
					   			*/
					   			
					  		} else {					  
					   			$diff_date = $this->effective->compare_date(array('begin'=> $plan2ca_inquiry['data'][0]['HQReceivedDocDate'], 'end'=> $this->effective->StandartDateSorter($getVerify['AppToCAPlanDate'])));
					   		}
				
					   	else:
					   		$diff_date = $this->effective->compare_date(array('begin'=> date('Y-m-d'), 'end'=> $this->effective->StandartDateSorter($getVerify['AppToCAPlanDate'])));
					   	endif;
					   
					   }		
					   
					   if(!empty($plan2ca_inquiry['data'][0]['HQReceivedDocDate'])):
					   		$plan_a2ca_locked = 'style="max-width: 180px; background: #EBEBE4;"';
					   else:
					   		$plan_a2ca_locked = 'style="max-width: 180px;"';
					   endif;
								    
				    ?>
		
			   		<div id="root_plan_a2ca" class="span12">
		    			<label id="label_plan_a2ca" class="span4">A2CA Plan Date</label>
		    		 	<div <?php if(empty($plan2ca_inquiry['data'][0]['HQReceivedDocDate'])) echo 'id="parent_plan_a2ca"';  ?>  class="input-control text span6" style="margin-left: 20px;">			             
			            	<input id="plan_a2ca" name="plan_a2ca" type="text" value="<?php echo !empty($getVerify['AppToCAPlanDate']) ? $getVerify['AppToCAPlanDate']:''; ?>" readonly="readonly" <?php echo $plan_a2ca_locked; ?>>
			            	<?php if(!empty($getVerify['AppToCAPlanDate'])) { ?>
			            	<span class="label nonprint">DIFF : <?php echo !empty($diff_date) ? $diff_date:'0'; ?> Day</span>	
			            	<?php } ?>
			            	<?php if(!empty($app2ca_history['data'][0]['DocID'])) { ?>							
			            	<span id="PlanA2CAReasonLogs" class="tooltip-top show-pop-list nonprint" data-tooltip="Plan A2CA History" data-placement="right">
			            		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
			            	</span>	
			            	<?php } ?>
			         	</div>			         	
			         	<input id="plan_a2ca_log" name="plan_a2ca_log" type="hidden" value="<?php echo !empty($getVerify['AppToCAPlanDate']) ? $getVerify['AppToCAPlanDate']:''; ?>" class="nonprint" <?php if(empty($app2ca_history['data'][0]['DocID'])) echo 'hide'; ?>>
			    	</div>
			    
			    	<div id="plan_a2ca_area" style="display: none;">
			    	<?php 
				
		    			$planapp_no = 1;
			        	if(empty($app2ca_history['data'][0]['DocID'])) {
			  		        	
			        	} else {
			        	
				        	foreach ($app2ca_history['data'] as $k => $v) {
				        		echo $planapp_no . '. A2CA Plan Date : ' . $this->effective->StandartDateRollback($app2ca_history['data'][$k]['A2CA_PlanDate']) . '<br/>';					        			
				        		$planapp_no++;
			        		}
			 				
			        	}
	
				    ?>
			    	</div>
				   	
				   	<!-- RMProcess Data Bundled -->
				   	<input id="rmprocess_list_bundled" name="rmprocess_list_bundled" type="hidden" value="">
                    <input id="rmprocess_otherlist_bundled" name="rmprocess_otherlist_bundled" type="hidden" value="">
				   	
				   	<!-- RMProcess Modal -->
	                <div class="modal fade" id="RMProcessListModal" role="dialog" aria-labelledby="RMProcessdListModalLabel" aria-hidden="true">
	                    <div class="modal-dialog">
	                    	<div class="modal-content">
	                        	<div class="modal-header">
	                            	<button type="button" class="close" data-dismiss="modal" style="display: none;"><span aria-hidden="true">&times;</span></button>
	                                <h4 class="modal-title" id="RMProcessListModalLabel">
	                                	<span style="font-size: 1.2em; margin-left: 63px; font-weight: bold;">RM PROCESS</span>	                                	                         
	                                	<i id="RMProcessLoadList" class="fa fa-refresh place-right fg-lightBlue marginRight10" style="float: right; cursor: pointer;"></i>	                                	
	                                </h4>	                     
	                            </div>
	                            <div class="modal-body" style="padding-right: 5% !important;">
	  
	                            	<div class="container">
	                            		                  
	                            		<!-- RMProcess Reason List -->
		                            	<div class="grid" style="clear: both; margin-bottom: -20px;">		                            		
		                            		<div id="rmprocess_content"></div>
		                            	</div>
		                            	
		                            	<!-- RMProcess Other Field -->
		                            	<div id="rmprocess_otherlist" class="marginBottom20" style="display: none; clear: both;">
		                            		<h5 style="margin-left: 20px;">กรุณาระบบหัวข้อเพิ่ม :</h5>
		                            		<div class="input_rmfields_wrap" style="margin-left: 20px;">											   
											    <div class="input-control text">
											    	<label class="label label-clear">อื่นๆ :</label>
											    	<input id="rmprocess_topicRootlist" name="rmprocess_topiclist[]" type="text" value="" class="size4"> 
											    	<span class="tooltip-top marginLeft5" data-tooltip="Add new topic.">
											    		<i class="fa fa-plus-circle fg-green marginTop5 add_rmfield_button" style="font-size: 1.5em !important;"></i>
											    	</span>											    	
											    </div>											   
											</div>	                            	
	                            		</div>
		                           
	                            	</div>
			
	                            </div>
	                            <div class="modal-footer"> 
	                            	<button id="cancelRMProcessList" type="button" class="btn btn-primary">Close</button>                           	
	                                <button id="confirmRMProcessList" type="button" class="btn bg-lightBlue fg-white" style="margin-right: 30px;">Accept</button>
	                            </div>
	                         </div>
	                    </div>
	                </div>   
				   	 
				   	<div class="span12">
				   		<?php $rmprocessreason = !empty($getVerify['RMProcessReason']) ? $getVerify['RMProcessReason']:""; ?>
				   		<div id="parent_rmprocess_reason" class="input-control select">
				   			<label id="label_rmprocess_reason" class="span4">Choose Reason</label>
				   			<div id="objrmprocess_reason" class="input-control select span4" style="margin-left: 20px;">
				   				<input id="rmprocess_reason_hidden" name="rmprocess_reason_hidden" type="hidden" value="<?php echo $getVerify['RMProcessReason']; ?>">
				            	<select id="rmprocess_reason" name="rmprocess_reason[]" multiple="multiple" style="height: 34px;"></select>
				            </div>
				            <div id="rmprocess_progress"><img src="<?php echo base_url().'img/ajax-loader.gif'; ?>" style="margin-left: 5px;"></div>
				   		</div>
				   </div>
				   
				   <div id="parent_rmprocess_otherreason" class="span12">
				   		<label id="label_rmprocess_reason" class="span4">กรุณาใส่เหตุผลเพิ่มเติม :</label>
				   	 	<div class="input-control text span4" style="margin-left: 20px;">
				   			<input id="rmprocess_otherreason" name="rmprocess_otherreason" type="text" value="">				            	
				        </div>	
				   </div>
				   
				   <?php
				   	
				   $reactivate_list = $this->dbmodel->CIQuery("
						SELECT DocID, EmployeeCode, ReActivatedReason, CONVERT(NVARCHAR(10), ReActivateDate, 120) AS ReActivateDateConv,
						CONVERT(NVARCHAR(21), ReActivateDate, 120) AS ReActivateDate, IsActive
						FROM  Reactivate_TransactionLog
			   			WHERE DocID = '".$getCustInfo['DocID']."'
			   			ORDER BY ReActivateDate DESC
			   		");
				   
				   $reactivat_num = count($reactivate_list['data']);
				    
				   ?>
				  
				   <div class="span12">
				   
				   		<?php if($useable === 'false') { echo '<div class="span12" style="position: absolute; background-color: transparent; z-index: 1000; height: 34px;">&nbsp;</div>'; } ?>
				   		
				    	<div class="span4" style="margin-right: 20px; <?php echo ($useable === 'false') ? 'margin-left: 0px;':''; ?>">
				    		<label class="span4">
				    			Re-Activation
				    			<span id="loadActivateList" class="nonprint" style="padding-left: 0.1em; font-size: 1em;"><i class="fa fa-question-circle fg-lightBlue" data-hint="Re-Activation|การนำเคสที่ยังไม่เข้าระบบกลับมาทำใหม่" data-hint-position="top"></i></span>
				    		</label>
				        </div>
				        
				        <div id="objreactivate" class="input-control select span4">
				            <select id="reactivate" name="reactivate[]" multiple="multiple" <?php echo !empty($reactivate_locked) ? $reactivate_locked:''; ?> style="<?php echo $hide_attr; ?>"></select>
				     	</div>
				     	
				     	<div class="input-control text span2" class="input-control text span2" style="max-width: 115px; margin-left: 5px;">
				     		<input id="reactivate_plan" name="reactivate_plan" type="text" value="" readonly="readonly" style="background-color: #EBEBE4;">				     	
				     	</div>
				    
				   		<div class="toolbar fg-black nonprint" class="place-left">	
				   			<?php if(!empty($reactivate_list['data'][0]['DocID'])) { ?>					
			            	<span id="ReActivatedReasonLogs" class="tooltip-top show-pop-list" data-tooltip="Re-Activated Reason History" data-placement="right" style="margin-top: 0px; margin-left: 10px;">
			            		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
			            	</span>	
			            	<?php } ?>			            		       
			            </div>	
				        
				       	<div id="arp_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"> Loading...</div>
				        <!-- <div id="revisitText" class="span2" style="margin-top: 4px; cursor: pointer;"><?php echo !empty($getVerify['RevisitRef']) ? 'REF : ' . $getVerify['RevisitRef']:""; ?></div> -->
				   </div>
				   
				   <!-- <input id="tmp_reactivation" type="hidden" value="<?php echo !empty($reactivate_list['data'][0]['ReActivatedReason']) ? $this->effective->get_chartypes($char_mode, $reactivate_list['data'][0]['ReActivatedReason']):''; ?>"> -->
				   <div id="reactivate_parent_reason" style="display: none;">
				   		<?php 
				
				        	if(empty($reactivate_list['data'][0]['DocID'])): 
				        		echo "&nbsp;";
				        	
				        	else:
				        	
					        	foreach ($reactivate_list['data'] as $k => $v) {
					        		/*
 					        		if($k == 0) {
 					        			continue;
					        			
 					        		} else {
					        		*/	
					        			if(!empty($reactivate_list['data'][$k]['ReActivatedReason'])):
				        			 
						        			$reactivate_pieces = explode(',', $reactivate_list['data'][$k]['ReActivatedReason']);
						        			if(!empty($reactivate_pieces[0])):
						        				$where_reactivate 	= "'".implode("','", $reactivate_pieces)."'";
						        			else:
						        				$where_reactivate   = "";
						        			endif;
						        
						        			if(!empty($where_reactivate)):
						        			 
							        			$reactivate_reason =  $this->dbmodel->CIQuery("SELECT * FROM MasterRevisitReason WHERE RevisitID in ($where_reactivate)");
							        			foreach ($reactivate_reason['data'] as $index => $values) {						        			
							        				$name	= !empty($reactivate_reason['data'][$index]['RevisitReason']) ? $this->effective->get_chartypes($char_mode, $reactivate_reason['data'][$index]['RevisitReason']):'';
							        				echo $reactivat_num.'. '. $this->effective->StandartDateRollback($reactivate_list['data'][0]['ReActivateDateConv']).' '.$name.'<br/>';
							        				//echo $reactivat_num.'. '. substr($this->effective->StandartDateRollback($reactivate_list['data'][0]['ReActivateDateConv']), 0, 5).' '.$name.'<br/>';
							        			}
	
						        			endif;
						        			
						        			$reactivat_num--;
					        			
					        			else:
					        			 
					        			endif;
					        			
 					        		//}
					        					        			
				        			
							        			
				        		}
				 	
				        	endif;
				        	
				        	
				        ?>
				   </div>
				   				   
				   <?php 
				   
					   if(in_array($DefProcess['Status'], $full_cancelstatus)):
					   		$actionnote_binding = 'readonly="readonly" style="background: #EBEBE4;"';
					   endif;
					   
					   if(!empty($getVerify['ActionNameLog'])) {
					   		
						   	if($getVerify['ActionNameLog'] === "System") {
						   		$actionnote_checkbinding = 'readonly="readonly" style="background: #EBEBE4;"';
						   		
						   	} else if($session_data['thname'] !== $getVerify['ActionNameLog']) {
						   		$actionnote_checkbinding = 'readonly="readonly" style="background: #EBEBE4;"';
						   		
						   	} else { $actionnote_checkbinding = ''; }
					
					   } else { $actionnote_checkbinding = ''; }

				   ?>
				
				   <div class="span12">
				   		<div id="resource_parent" class="input-control textarea">
				            <label class="span4">Action Note</label>
							<div id="parent_action" onselectstart="return false">
							
								<input id="action_flag" name="action_flag" type="hidden" value="0">
								
								<input id="action_hidden_event" name="action_hidden_event" type="hidden" value="InsertLogs">
								<input id="action_hidden_date" name="action_hidden_date" type="hidden" value="<?php echo date('Y-m-d'); ?>">
					           
					            <input id="actionnote_datelatest" name="actionnote_datelatest" type="hidden" value=""> <!-- <?php  echo !empty($getVerify['ActionNoteDate']) ? $getVerify['ActionNoteDate']:""; ?> -->
					            <input id="actionnote_actorlatest" name="actionnote_actorlatest" type="hidden" value=""> <!-- <?php  echo !empty($getVerify['ActionNameLog']) ? $getVerify['ActionNameLog']:""; ?> -->
					            <textarea id="actionnote"  name="actionnote" rows="6" class="span4"></textarea>  
					            <!-- <textarea id="actionnote"  name="actionnote" rows="6" class="span4 unselectable" oncopy="return false;" onselectstart="return false;" <?php echo $readonly; ?> <?php echo !empty($actionnote_binding) ? $actionnote_binding:$actionnote_checkbinding; ?>><?php  echo !empty($getVerify['ActionNote']) ? $getVerify['ActionNote']:""; ?></textarea> -->
					          
					            <button id="ActionOnCancel" class="nonprint" type="button" style="position: absolute; margin-left: 5px; margin-top: 0.1em; font-size: 1em; <?php echo $hide_attr; ?>">
					            	<i class="icon-remove on-left" class="tooltip-top" data-tooltip="Clear field for enter new contents."> CLEAR </i>
					            </button>
					            
					            <!-- <i id="ActionOnSubmit" class="fa fa-save on-left" style="position: absolute; margin-left: 10px; margin-top: 2.5em; font-size: 1em;" data-hint="บันทึกข้อมูล  (Action Note)" data-hint-position="top"> SUBMIT <span style="font-size: 0.7em;">( FOR ACTION NOTE )</span></i> -->
					            <i id="Action_Progresslogs" style="position: absolute; margin-left: 10px; margin-top: 3.5em; font-size: 1em;"><img src="<?php echo base_url().'img/ajax-loader.gif'; ?>"> waiting...</i>
					            
				            </div>
				        </div>
				   </div>
   
				   <div class="span12">
				   <label class="span4">&nbsp;</label>
			       <div class="span4 nonprint" style="margin-top: -8px;">
			    		<div class="listview-outlook" data-role="listview">
							<div class="list-group collapsed">
								<a href="" class="group-title" style="text-decoration: none;">History Logs <span style="font-size: 0.8em;">( For Action Note )</span></a>
								<div id="actionnote_group" class="group-content" style="width: 500px; height: 350px; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">
									
										<?php 
									
											if(empty($ActionLogs[0])) {
												echo "<div class=\"list-content\">ไม่พบข้อมูล</div>";									
		
											} else {
		
												$data_split = array();
												foreach($ActionLogs as $index => $values) {
													array_push($data_split, array("ActionName" => $ActionLogs[$index]['ActionName'], "ActionNoteBy" => $ActionLogs[$index]['ActionNoteBy'], "ActionNote" => $ActionLogs[$index]['ActionNote'], "ActionNoteDate" => $ActionLogs[$index]['ActionNoteDate'], "ActionDateTime" => $ActionLogs[$index]['ActionDateTime']));
												}
											
												foreach ($data_split as $index => $values) {
													/*
													if($index == 0):
														continue;      
													else:
													*/
														$name	= !empty($data_split[$index]['ActionName']) ? $this->effective->get_chartypes($char_mode, $data_split[$index]['ActionName']) : $data_split[$index]['ActionNoteBy'];
														echo '
	    													<a href="#" class="list" style="text-decoration: none;">
							    							<div class="list-content">
																<span class="list-title" style="font-size: 0.7em;"></span>
																<span class="list-subtitle">'.$data_split[$index]['ActionNoteDate'].' '.$data_split[$index]['ActionDateTime'].' <span style="font-weight: normal">Update By : '.$name.'</span></span>
																<span style="font-size: 0.8em; line-height: 15px;">Note : '.$this->effective->get_chartypes($char_mode, $data_split[$index]['ActionNote']).'</span>
															</div>
	               											</a>';
													
													//endif;
											
												}
												
		
											}
									
										?>										
				   					
								</div>
							</div>
				    	</div>	    
				    </div>
				    </div>
				   
				    <!-- Defender Part -->
				    
				    <?php 				    
				    	$def_progress = !empty($getDefend['data'][0]['ProgressNewLabel']) ? $getDefend['data'][0]['ProgressNewLabel']:'';
				    	$def_process  = !empty($getDefend['data'][0]['DefendProcess']) ? $getDefend['data'][0]['DefendProcess']:'';
				    	$def_date 	  = !empty($getDefend['data'][0]['AssignmentDate']) ? $this->effective->StandartDateRollback(substr($getDefend['data'][0]['AssignmentDate'], 0, 10)):'';
				    	$def_status   = !empty($def_process) ? 'Completed':''; 	
				    ?>
				    
				    <div class="span12">
		                <div class="input-control">
		                   <label class="span4">Defend</label>
		                   <div id="defend_enable" class="input-control checkbox marginLeft20">		                   	
		                    	<label style="<?php if(empty($rmprocess)) echo 'display: none'; ?>;">
 									<input id="defend_creation" name="defend_creation" type="checkbox" value="Y" <?php echo ($def_status == 'Completed') ? 'checked="checked" disabled="disabled"':''; ?>> 									
	            		    		<span class="check"></span>
	            		    	</label>
		                   </div>                
		                   <div id="parent_defend_date" class="input-control text <?php echo !empty($rmprocess) ? 'marginLeft5':''; ?>" style="max-width: <?php echo ($def_status == 'Completed') ? '238px':'268px'; ?>;">
		                   		<input id="defend_date" name="defend_date" type="hidden" value="<?php echo $def_date; ?>">
			                    <input id="defend_date_disbled" type="text" value="<?php echo $def_date . ' - ' . $def_progress; ?>" disabled="disabled">
		                   </div>		
		                   <span class="toolbar fg-black" style="position: absolute; margin-top: 9px; margin-left: 5px; min-width: 300px;">
		                   		<i id="defend_icon_remove" class="icon-remove on-right nonprint hide" style="font-size: 1.2em; cursor: pointer;" data-hint-position="top" data-hint="Defend Clear|ในกรณีหัวข้อที่เลือกไม่ตรงตามความต้องการ กดคลิกเพื่อล้างรายการเดิม (เฉพาะการสร้างข้อมูลครั้งแรกเท่านั้น)"></i> 
		                   		<i id="defend_icon_history" class="icon-history on-right nonprint <?php echo ($def_status == 'Completed') ? '':'hide'; ?> " style="font-size: 1.2em; cursor: pointer;" data-hint-position="top" data-hint="Defend List|ดูประวัติรายการหัวข้อของปัญหาต่างๆ ที่เลือก เพื่อชี้แจ้งประเด็นปัญหาต่างที่เกิดขึ้นภายในเคส"></i>
		                   </span>             					           
		                </div>
		            </div>
		            
		            <!-- Defend Data Bundled -->
		            <input id="defend_creation_state" name="defend_creation_state" type="hidden" value="<?php echo $def_status; ?>">
                    <input id="defend_list_bundled" name="defend_list_bundled" type="hidden" value="">
                    <input id="defend_otherlist_bundled" name="defend_otherlist_bundled" type="hidden" value="">
                    
                    <input id="defend_owner_id" name="defend_owner_id" type="hidden" value="<?php echo !empty($getCustInfo['RMCode']) ? $getCustInfo['RMCode']:""; ?>">
                    <input id="defend_owner_name" name="defend_owner_name" type="hidden" value="<?php echo !empty($getCustInfo['RMName']) ? $getCustInfo['RMName']:""; ?>">
                 
                 	<?php $doc_id = !empty($getCustInfo['DocID'] && $def_progress !== 'Draft') ? $getCustInfo['DocID']:!empty($_GET['rel']) ? $_GET['rel']:''; ?>
                 	<?php $ref_verify = ($def_progress !== 'Draft') ? '?ref=' . $doc_id  : '';?>
                    
                    <div id="objDefendbox" class="span12" style="display: none; clear: both;">
		                <label class="span4">&nbsp;</label>		                
		                <div id="objDefendReason" class="span8" style="min-width: 500px; border: 1px solid #D1D1D1; margin-top: -5px; margin-left: 20px; padding: 5px;">
		                	<a href="<?php echo site_url('defend_control/defenddashboard_v2') . $ref_verify; ?>" target="_blank" class="place-right">
		                		<i class="icon-screen on-right nonprint" style="font-size: 1.2em; cursor: pointer; margin-bottom: 10px;"></i> 
		                		<span style="font-size: 0.9em;">DEFEND FORM</span>
		                	</a>
		                	<section class="form_container">
			                	<table id="defend_logs" style="min-width: 500px;">
			                		<thead>
			                			<tr>
			                				<th>CREATE DATE</th>
			                				<th>NAME</th>
			                				<th>TOPIC</th>
			                			</tr>
			                		</thead>
			                		<tbody></tbody>
			                	</table>
		                	</section>
		                </div>		                
		            </div>		            
		            
		            <div id="retrive_field_hidden" style="display: none;">
		            	<input id="retrieve_actor_id" name="retrieve_actor_id" type="hidden" value="">
			            <input id="retrieve_actor_name" name="retrieve_actor_name" type="hidden" value="">
			            <input id="retrieve_date" name="retrieve_date" type="hidden" value="">
		            </div>		            
		          
		            <!-- Defend Modal -->
	            	<div id="defendListModal" class="modal fade nonprint" role="dialog" aria-labelledby="DefendListModalLabel" aria-hidden="true">
	                    <div class="modal-dialog">
	                    	<div class="modal-content">
	                        	<div class="modal-header bg-darkCyan" style="padding: 0px;">
	                            	<button type="button" class="close" data-dismiss="modal" style="display: none;"><span aria-hidden="true">&times;</span></button>
	                                <h4 id="DefendListModalLabel" class="modal-title">
	                                	<span class="fg-white" style="font-size: 1em; margin-left: 10px; font-weight: bold;">DEFEND REASON</span>                      	
	                                </h4>	                
	                            </div>
	                            <div class="modal-body" style="overflow: hidden; min-height: 280px;">
	  
	                            	<div class="container">	                            		                  
	                            		<!-- Defend Reason List -->
		                            	<div class="grid" class="padding_none" style="clear: both;">
		                            		<div id="defend_content">
		                            			
		                            		</div>
		                            	</div>
		                            	
		                            	<!-- Defend Other Field -->
		                            	<div id="defend_otherlist" class="span12 marginTopEasing50 marginBottom20 marginLeftEasing20" style="display: none; clear: both;">
		                            		<h5 style="margin-left: 30px;">กรุณาระบบหัวข้อเพิ่ม :</h5>
		                            		<div class="input_fields_wrap" style="margin-left: 30px;">											   
											    <div class="input-control text">
											    	<label class="label label-clear">อื่นๆ :</label>
											    	<input id="defend_topicRootlist" name="defend_topiclist[]" type="text" value="" class="size4"> 
											    	<span class="tooltip-top marginLeft5" data-tooltip="Add new topic.">
											    		<i class="fa fa-plus-circle fg-green marginTop5 add_field_button" style="font-size: 1.5em !important;"></i>
											    	</span>											    	
											    </div>											   
											</div>	                            	
	                            		</div>
		                            	
	                            	</div>
	                            									
	                            </div>
	                            <div class="modal-footer" style="padding: 10px 0px; position: relative;"> 
	                            	<div class="fg-gray" style="font-size: 0.9em; position: absolute; left: 25px; top: 15px;">
								    	หมายเหตุ: ท่านสามารถทราบความหมายของหัวข้อที่จะ Defend โดยการนำ<b><u>เมาส์วางบนหัวข้อนั้นๆ</u></b> (กรณีรายการไม่แสดงให้นำเมาส์ออกและวางใหม่อีกครั้ง)
								    </div>
	                            	<button id="cancelDefendList" type="button" class="btn btn-primary">Close</button>                           	
	                                <button id="confirmDefendList" type="button" class="btn bg-lightBlue fg-white" style="margin-right: 30px;">Accept</button>
	                            </div>
	                         </div>
	                    </div>
	                </div>

                    <!-- End Defends -->
                    
                    <?php 
                      
                    	if(empty($DefProcess['Status'])) {
                    		$set_lockretrieve = 'disabled="disabled" style="background-color: #EBEBE4; min-height: 34px;"';
                    		
                    	} else {
                    		if(in_array($DefProcess['Status'], $full_cancelstatus) && !empty($DefProcess['CA_ReceivedDocDate'])) {
                    			$set_lockretrieve = '';
                    		} else {
                    			$set_lockretrieve = 'disabled="disabled" style="background-color: #EBEBE4; min-height: 34px;"';
                    		}
                    	}
                                      	
                    	$objDoc_id = !empty($getCustInfo['DocID']) ? $getCustInfo['DocID']:'';
                    	$result_setretrieve = $this->dbmodel->CIQuery("
                    		SELECT
                    		CONVERT(nvarchar(10), EventDate , 120) AS EventDate,
                    		SUBSTRING(CONVERT(nvarchar(19), EventTime, 120), 11, 10) AS EventTime, RetrieveReason
                    		FROM Retrieve_TransactionLog
                    		INNER JOIN MasterRetrieveReason
                    		ON Retrieve_TransactionLog.RetrieveCode = MasterRetrieveReason.RetrieveCode
                    		WHERE RetrieveToNewDoc = '$objDoc_id'
                    		ORDER BY EventDate DESC, EventTime DESC
                    	");
                    	
                    	$log_reactivation = $this->dbmodel->CIQuery("
                    		SELECT RowID, DocID, EmployeeCode, ReActivatedReason, CONVERT(nvarchar(10), ReActivateDate, 120) AS ReActivateDate,
							SUBSTRING(CONVERT(nvarchar(19), ReActivateDate, 120), 11, 10) AS ReActivateTime, IsActive
							FROM Reactivate_TransactionLog
							WHERE DocID = '$objDoc_id'
							ORDER BY ReActivateDate DESC
                    	");                    	
                    
                    	$second_lock = !empty($set_lockretrieve) ? $set_lockretrieve:'';
                    	                    
                    ?>
                                        
                    <div class="span12 marginBottomEasing20">
                    
                    	<?php if($useable === 'false') { echo '<div class="span12" style="position: absolute; background-color: transparent; z-index: 1000; height: 34px;">&nbsp;</div>'; } ?>
				    	
                    	<label class="span4" style="<?php echo ($useable === 'false') ? 'margin-left: 0px;':''; ?>">
                    		Retrieve
                    		<span class="nonprint" style="padding-left: 0.1em; font-size: 1em;">
                    			<i class="fa fa-question-circle fg-lightBlue" data-hint="Retrieve|การนำเคสกลับมาทำใหม่ โดยเคสที่จะนำกลับมาทำใหม่จะต้องเป็นเคสที่เข้าระบบและมีผลพิจารณาเป็น Cancel หรือ Reject เป็นต้น" data-hint-position="top"></i>
                    		</span>
                    	</label>                      	  
                    	<div class="input-control select span4" style="min-height: 34px;">                           		   		
                    		<select id="retrieve_reason" name="retrieve_reason" class="marginLeft20" <?php echo !empty($retrievefield_lock) ? $retrievefield_lock:$second_lock; ?> style="height: 34px; min-height: 34px; <?php echo $bgreadonly; ?>">
                    			<option value=""></option>
                    			<?php                   
                    		
                    				foreach($ListRetrieve['data'] as $index => $value) {
                    					echo '<option value="'.$ListRetrieve['data'][$index]['RetrieveCode'].'">'.$ListRetrieve['data'][$index]['RetrieveReason'].'</option>';
                    					
                    				}      
                    				
                    			?>
                    		</select>
                    		
                    	</div>    
                    	<div class="input-control text" style="max-width: 115px; margin-left: 25px;">
				            <input id="retrieveDate" name="retrieveDate" type="hidden" value="">
				            <input id="objRetrieveDate" type="text" value="" disabled="disabled">
				        </div>        
				        <span class="toolbar fg-black nonprint" class="place-left" style="position: absolute; margin-left: 5px;">
				        	<?php if(!empty($result_setretrieve['data'][0]['RetrieveReason'])) { ?>
				        	<span id="retrieve_tooltip" class="tooltip-top show-pop-list" data-tooltip="Retrieve Reason History" data-placement="top">
				        		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
				        	</span>				    
				       		<?php } ?>
				        </span>
				        <div class="span12" <?php echo ($retrievefield_stat == 'TRUE') ? '':'style="display: none"'; ?>>
				        	<label class="span4"></label>
				        	<div class="input-control select span8">   
				        		<small class="fg-red"><?php echo $retrievefield_text; ?></small>
				        	</div>
				        </div>	       	
                   </div>
                   
                   <div id="retrieve_contents" style="display: none;">
                   <?php 
               
                   		if(!empty($result_setretrieve['data'][0]['RetrieveReason'])) {
                   			
                   			foreach($result_setretrieve['data'] as $index => $value):
                   			echo '#'.$this->effective->StandartDateRollback($result_setretrieve['data'][$index]['EventDate']).' '.$this->effective->get_chartypes($char_mode, $result_setretrieve['data'][$index]['RetrieveReason']).'<br/>';
                   				//echo '#'.substr($this->effective->StandartDateRollback($result_setretrieve['data'][$index]['EventDate']), 0, 5).' '.$this->effective->get_chartypes($char_mode, $result_setretrieve['data'][$index]['RetrieveReason']).'<br/>';
                   			endforeach;
                   		                   			
                   		} else { echo 'ไม่พบข้อมูล'; }
                                   		
                   ?>
                   </div>
                    
                    <!-- Identity Modal -->
	            	<div id="RetrieveModal" class="modal fade nonprint" role="dialog" aria-labelledby="RetrieveModalLabel" aria-hidden="true">
	                    <div class="modal-dialog" style="max-width: 800px;">
	                    	<div class="modal-content" style="height: auto !important; min-height: auto !important;">
	                        	<div class="modal-header">
	                            	<button type="button" class="close" data-dismiss="modal" style="display: none;"><span aria-hidden="true">&times;</span></button>
	                                <h4 class="modal-title" id="RetrieveModalLabel">Retrieve: Check Identity Card</h4>
	                            </div>
	                            <div class="modal-body" style="height: 400px; padding: 0 5%;">
	                            
	                            	<div class="grid">
	                            		<div id="retrieve_content" class="row text-left" style="border-radius: 0px !important;">
	                            		
	                            			<div id="retrieve_bpm_information" style="border: 1px dotted #D1D1D1; background-color: #fcfcea;">
		                            			<div style="margin-left: 65px;"><h5><i class="icon-info fg-lightBlue"></i> รายละเอียดข้อมูล : ข้อมูลจากระบบ BPM</h5></div>
		                            			<div class="input-control padding5" style="clear: both;">
		                            				<label class="span3 text-center">Application No</label>
		                            				<div class="input-control text size3">
		                            					<input id="88  " type="text" value="" disabled="disabled">		                            					
		                            				</div>		                            			
		                            			</div>
		                            			<div class="input-control padding5">
		                            				<label class="span3 text-center">Borrower Name</label>
		                            				<div id="parent_retrieve_custname_responsed" class="input-control text size3">
		                            					<input id="retrieve_custname_hideresponsed" type="text" value="" disabled="disabled">	                            					
		                            					<input id="retrieve_custname_responsed" name="retrieve_custname_hideresponsed" type="hidden" value="">		               
		                            				</div>	  
		                            				<div id="parent_retrieve_custlastname_responsed" class="input-control text size3">
		                            					<input id="retrieve_custlastname_hideresponsed" type="text" value="" disabled="disabled">
		                            					<input id="retrieve_custlastname_responsed" name="retrieve_custlast_hideresponsed" type="hidden" value="">
		                            				</div>                          				
		                            			</div>				                            		                            					                            				                            			
	                            			</div>
        									
	                            			<div class="input-control padding5">
	                            				<label class="span3 text-center">ID Card</label>
	                            				<div id="parent_retrieve_identity_cardno" class="input-control text size3">
	                            					<input id="retrieve_identity_cardno" name="identity_cardno" type="text" maxlength="13" value="" class="numbersOnly">
	                            					<button class="btn-clear"></button>
	                            				</div>	 
	                            				<button id="retrieve_btnRetrieveIdentityVerify" type="button" style="height: 34px; font-weight: bold;">
	                            					<i class="fa fa-search"></i>
	                            					Verify
	                            				</button>  
	                            				<i id="retrieve_identity_verification" class="fa fa-check fg-green marginLeft5" style="font-size: 1.2em;"></i>	                      				
	                            			</div>
	                            			
	                            			<div class="input-control padding5">
	                            				<label class="span3 text-center">Borrower Name (ผู้กู้หลัก)</label>
	                            				<div id="parent_retrieve_custname_identity" class="input-control text size3">                            					
	                            					<input id="retrieve_custname_identity" name="retrieve_custname_responsed" type="text" value="" placeholder="Name">
	                            					<button class="btn-clear"></button>	               
	                            				</div>           
	                            				<i id="retrieve_identity_custname" class="fa fa-check fg-green marginLeft5" style="font-size: 1.2em;"></i>              				
	                            			</div>		
	                            			
	                            			<div class="input-control padding5">
	                            				<label class="span3 text-center">&nbsp;</label>  
	                            				<div id="parent_retrieve_custlastname_identity" class="input-control text size3">
	                            					<input id="retrieve_custlastname_identity" name="retrieve_custlast_responsed" type="text" value="" placeholder="Surname">
	                            					<button class="btn-clear"></button>
	                            				</div>    
	                            				<i id="retrieve_identity_custlastname" class="fa fa-check fg-green marginLeft5" style="font-size: 1.2em;"></i>                      				
	                            			</div>		
	                            			
	                            			<!-- Progress & Response Message  -->
	                            			<div id="retrieve_identity_progress" style="margin-left: 85px;"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"> Loading...</div> 
	                            			<div id="retrieve_msg_identityresponsed"></div>                
	                            		
	                            		</div>
	                            	</div>
	                               
	                            </div>
	                            <div class="modal-footer"> 
	                            	<button id="retrieve_cancelIdentity" type="button" class="btn btn-primary">Close</button>                        	
	                                <button id="retrieve_confirmIdentity" type="button" disabled="disabled" class="btn bg-lightBlue fg-white" style="margin-right: 30px;"><i class="fa fa-check fg-white on-left"></i>Accept</button>
	                            </div>
	                         </div>
	                    </div>
	                </div>    

                	<input id="checkCreditReturn" name="checkCreditReturn" type="hidden" value="N">
	                <!-- CAReturn Modal -->
	                <div class="modal fade" id="careturnReasonModal" role="dialog" aria-labelledby="careturnReasonModalLabel" aria-hidden="true">
	                    <div class="modal-dialog">
	                    	<div class="modal-content">
	                        	<div class="modal-header">
	                            	<button type="button" class="close" data-dismiss="modal" style="display: none;">
	                            		<span aria-hidden="true">&times;</span>
	                            	</button>
	                                <h4 class="modal-title" id="careturnReasonModalLabel">
	                                	<span style="font-size: 1.2em; margin-left: 63px; font-weight: bold;">CREDIT RETURN REASON</span>	                                	
	                                	<i id="ca_refresh" class="fa fa-refresh place-right fg-lightBlue marginRight50" style="float: right; cursor: pointer;"></i>	    
	                                    <div class="input-control switch marginRight50" style="position:relative; margin-top: -5px; font-size: 0.8em; float: right; margin-right: 20px;">										   
										    <label>
										        <input id="listReturnReason" name="listReasonEnabeld" type="checkbox" onclick="setRetrieveOnCAReturnReason('#listReturnReason', '<?php echo $getCustInfo['DocID']; ?>', <?php echo !empty($getDefendNum[0]['DefendNum']) ? $getDefendNum[0]['DefendNum']:0; ?>);">
										        <span class="check"></span>
										        <span class="labl label-clear place-left marginRight10">Latest CR Reason</span>
										    </label>
										</div>
	                                                        
	                                </h4>                                
	                            </div>
	                            <div class="modal-body" style="overflow-y: scroll; padding-right: 5%;">
	
		                            <input id="reconcileBundledID" name="reconcileBundledID" type="hidden" value="">
		                            
		                            <!-- Rollback value when cancel modal -->
		                            <input id="rollbackBundledID" name="rollbackBundledID" type="hidden" value="">
		                            <input id="rollbackElement" name="rollbackElement" type="hidden" value="">
	                            
	                            	<div class="container">
		                            	<div class="grid">
			                            	<div id="careturn_content"> 
			                     	
			                            	</div>	                            	
		                                </div>
		                                
		                                <!-- CA Return Other Field -->
		                            	<div id="careturn_otherarea" class="span12 marginTopEasing30 marginBottom20" style="display: none; clear: both;">
	                            			<h5 style="margin-left: 20px;">กรุณาระบบหัวข้อเพิ่ม :</h5>
		                            		<div class="input_cafields_wrap" style="margin-left: 20px;">											   
										    <div class="input-control text">
										    	<label class="label label-clear">อื่นๆ :</label>
										    	<input name="careturn_topiclist[]" type="text" value="" class="size4"> 
										    	<span class="tooltip-top marginLeft5" data-tooltip="Add new topic.">
										    		<i class="fa fa-plus-circle fg-green marginTop5 add_cafield_button" style="font-size: 1.5em !important;"></i>
												</span>											    	
											</div>										   
											</div>	                            	
	                            		</div>
		                                
	                            	</div>
	                            
	                            </div>
	                            <div class="modal-footer"> 
	                            	<button id="cancelReturnReason" type="button" class="btn btn-primary">Close</button>                           	
	                                <button id="confirmReturnReason" type="button" class="btn bg-lightBlue fg-white" style="margin-right: 30px;">Accept</button>
	                            </div>
	                         </div>
	                    </div>
	               </div>
					
				   <header class="span12" style="margin-top: 10px;">
				    	<h6>Document Flow</h6>
				    	<section style="position: absolute; min-width: 1045px; margin-top: -30px;">				    		
				    		<span class="tooltip-top nonprint" data-tooltip="Reconcile Document History" style="float:right; margin-right: 3px; cursor: pointer; font-size: 1.5em;">
				    		<i id="RelationLogs" class="icon-history on-right nonprint"></i>
				    		</span>
				    		<i id="ErrorTrack" class="fa fa-file-text fg-amber nonprint" style="float:right; margin-right: 3px; cursor: pointer; font-size: 1.3em; display: none;" data-hint="Error Tracking" data-hint-position="top"></i>				    		
				    	</section>	
				    </header>		        	
		        	<section class="form_container span12" style="margin-top: -10px;">
	                    <table id="expense_table_relation" style="min-width: 1050px;">
	                        <thead>
		                        <tr>
		                            <th align="left" style="width: 15em;">NAME - SURNAME</th>
		                            <th align="left" style="width: 20em;">LOGISTICS</th>
		                            <th>LB <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
		                            <th align="left"><i class="fa fa-inbox on-left"></i> HO RECEIVED</th>
		                            <th align="left" style="width: 5em;">COMPLETION</th>
		                            <th align="left">HO <i class="fa fa-arrow-right on-right on-left"></i> CA</th>
		                            <th align="left"><i class="fa fa-arrow-left on-left"></i> CA RETURN</th>
		                            <th align="left" data-hint="Document Return|เป็นส่วนที่แสดงข้อมูลเอกสารขอคืนของลูกค้า" data-hint-position="top">DOC . RT</th>
		                        </tr>
	                        </thead>
	                        <tbody>
	                        
	                        	<?php 
	      							
		                        	if(empty($DocFlow[0]['BorrowerName']) ) {
		                        		echo "<tr><td colspan=\"8\"><span class=\"text-muted\">ไม่พบข้อมูล</span></td></tr>";
		                        		
		                        	} else {
		                        		
		                        		// NEW UPDATE 24 MAY 1988
		                        		$docbypass_auth = !empty($getCustInfo['Region']) ? trim($getCustInfo['Region']): '';

										$i = 1;
										foreach($DocFlow as $index => $value) {	
									
											$DocID		  = $DocFlow[$index]['DocID'];
											$RecID		  = $DocFlow[$index]['Rec_ID'];
											$BorrowerName = !empty($DocFlow[$index]['BorrowerName']) ? $DocFlow[$index]['BorrowerName']:"";
											$BorrowerType = !empty($DocFlow[$index]['BorrowerType']) ? $DocFlow[$index]['BorrowerType']:"";
											$SubmitHQ	  = !empty($DocFlow[$index]['SubmitDocToHQ']) ? $DocFlow[$index]['SubmitDocToHQ']:"";
											$ReceivLB	  = !empty($DocFlow[$index]['ReceivedDocFormLB']) ? $DocFlow[$index]['ReceivedDocFormLB']:"";
											$CompleteDoc  = !empty($DocFlow[$index]['CompletionDoc']) ? $DocFlow[$index]['CompletionDoc']:"";
											$AppToCA	  = !empty($DocFlow[$index]['AppToCA']) ? $DocFlow[$index]['AppToCA']:"";
											$CAReturns	  = !empty($DocFlow[$index]['CAReturnDate']) ? $DocFlow[$index]['CAReturnDate']:"";
											$CAReturnlog  = !empty($DocFlow[$index]['CAReturnDateLog']) ? substr($DocFlow[$index]['CAReturnDateLog'], 0, 5):"&nbsp;";
											$IsRef		  = $DocFlow[$index]['IsRef'];
											
											$LBSChecked = !empty($SubmitHQ) ? 'checked="checked"':"";
											$HQHChecked	= !empty($ReceivLB) ? 'checked="checked"':"";
											$HCAChecked = !empty($AppToCA) ? 'checked="checked"':"";
											$CARChecked = !empty($CAReturns) ? 'checked="checked"':"";		

											$hide_edoc = '';
											
											if(in_array($docbypass_auth, array('SB', 'DRM'))) {
												$role_only  = '';
												$role_block = '';
												$hide_edoc  = '';
											} else {
												if($session_data['branchcode'] != '000') {
													$role_only 	= 'data-role="hqonly"';
													$role_block = 'disabled="disabled"';
													$hide_edoc  = 'display: none;';
												} else {
													$role_only  = '';
													$role_block = '';
													$hide_edoc  = '';
												}
											}
											
											$ca_date = date('Y-m-d', strtotime($this->effective->StandartDateSorter($CAReturns)));
											
											if($ca_date != '1970-01-01') {
												$conv_cadate = $ca_date;
													
											} else {
												$conv_cadate = '';
											}
											
											if($conv_cadate == date('Y-m-d')) {
												$ca_returndate = $CAReturns;
													
											} else {
												$ca_returndate = '';
													
											}
											
											$TrackLink = site_url('management/gridErrorTrack').'?rel='.$DocID.'&dump='.md5(date('s')).'&rfx='.$IsRef.'&grid=op&hasType='.trim($behalf).'&enble=true&manage='.md5('true');
											
											if(!empty($log_reactivation['data'][0]['ReActivateDate']) || !empty($result_setretrieve['data'][0]['RetrieveReason'])) {
												$btn_resetDoc = "
													<span class=\"tooltip-top nonprint\" data-tooltip=\"Reset document flow\" style=\"position: absolute; border-radius: 3px; padding: 5px; font-size: 1em; margin-top: -30px; border: 1px solid #FFF; margin-left: 5px; cursor: pointer;\">
														<i id=\"clearDocRecord_$i\" class=\"icon-remove\" onclick=\"resetDocumentFlow('clearDocRecord_$i', $i);\"></i>
													</span>";
													
												if(empty($hide_edoc)) $margin_resetfix = 'margin-top: -4px;';
												else $margin_resetfix = 'margin-top: -17px;';
												
											} else {
											
												if(in_array($session_data['emp_id'], $auth_administrator)) {
													$btn_resetDoc = "
														<span class=\"tooltip-top nonprint\" data-tooltip=\"Reset document flow\" style=\"position: absolute; border-radius: 3px; padding: 5px; font-size: 1em; margin-top: -30px; border: 1px solid #FFF; margin-left: 5px; cursor: pointer;\">
															<i id=\"clearDocRecord_$i\" class=\"icon-remove\" onclick=\"resetDocumentFlow('clearDocRecord_$i', $i);\"></i>
														</span>";
													
													$margin_resetfix = 'margin-top: -4px;';
													
												} else {
													$btn_resetDoc 	 = "";
													$margin_resetfix = 'margin-top: -17px;';
												}
											}
											
											if(empty($AppToCA)) {
												if($session_data['branchcode'] != '000'):
													$lock_returnfield = ' disabled="disabled"';
												else:
													$lock_returnfield = '';
												endif;												
											} else { 
												$lock_returnfield = '';
											}
											
											$objError	= "
											<td style=\"border: 0px;\">
												$btn_resetDoc
    											<a href=\"$TrackLink\" target=\"_blank, _top\" class=\"nonprint\">
    												<span class=\"tooltip-top\" data-tooltip=\"Error Tracking\" style=\"position: absolute; border-radius: 3px; padding: 5px; font-size: 1em; $margin_resetfix border: 1px solid #FFF; margin-left: 5px; cursor: pointer;\" clear: both;\">
														<i class=\"fa fa-exclamation-triangle fg-red\"></i>
													</span>
												</a>
											</td>";
											
											echo "    										
											<tr class=\"item_relation\" table-attr=\"$i\">
				                        		<td>
				                        			<div class=\"element_hidden\">
    										
														<input id=\"RELLogistic_hidden_$i\" name=\"RELLogistic_hidden[]\" type=\"hidden\" value=\"\">
														<input id=\"RELBorrowerType_hidden_$i\" name=\"RELBorrowerType_hidden[]\" type=\"hidden\" value=\"\">
														<input id=\"RELBorrowerName_hidden_$i\" name=\"RELBorrowerName_hidden[]\" type=\"hidden\" value=\"\">
					                            		<input id=\"RELLBToHQ_hidden_$i\" name=\"RELLBToHQ_hidden_[]\" type=\"hidden\" value=\"\">
					                            		<input id=\"RELHQReceived_hidden_$i\" name=\"RELHQReceived_hidden[]\" type=\"hidden\" value=\"\">
					                            		<input id=\"RELCompletion_hidden_$i\" name=\"RELCompletion_hidden[]\" type=\"hidden\" value=\"\">
					                            		<input id=\"RELHQToCA_hidden_$i\" name=\"RELHQToCA_hidden[]\" type=\"hidden\" value=\"\">
					                            		<input id=\"RELRETurn_hidden_$i\" name=\"RELRETurn_hidden[]\" type=\"hidden\" value=\"\">
					                            		<input id=\"RELEventLog_hidden_$i\" name=\"RELEventLog_hidden[]\" type=\"hidden\" value=\"\">
				                                										
    												</div>
				                        			<div class=\"input-control text\">
					                            		<input id=\"ITLRelation_Name_$i\" name=\"Relation_name[]\" type=\"text\" value=\"$BorrowerName\" readonly=\"readonly\">
					                            		<input id=\"ITRelation_RecID_$i\" name=\"Relation_RecID[]\" type=\"hidden\" value=\"$RecID\" readonly=\"readonly\">
					                            		<input id=\"ITRelation_Type_$i\" name=\"Relation_type[]\" type=\"hidden\" value=\"$BorrowerType\" readonly=\"readonly\">
					                            		<input id=\"ITRelation_Ref_$i\" name=\"Relation_ref[]\" type=\"hidden\" value=\"$IsRef\" readonly=\"readonly\">
					                            	</div>
				                        		</td>
												<td class=\"text-left\" style=\"min-width: 220px !important;\">";
											?>	
											
											<?php  if($rmprocess == 'Completed') { ?>	
													<div class="marginLeft25" style="margin-top: 0px; padding-bottom: 5px; padding-right: 2px;">
														<div class="input-control radio" style="margin-left: -8px;">
					                            		<label>
												         	<input id="logistic_env_<?php echo $i; ?>" name="Relation_Logistics[<?php echo $i; ?>]" type="radio" value="301" <?php if($DocFlow[$index]['LogisticCode'] == 301) echo 'checked="checked"'; ?>>
												          	<span class="check"></span>
												          	<i class="fa fa-envelope fg-lightBlue" style="cursor: pointer; font-size: 1.2em;"></i>
												        </label>												        									
					                            	</div>
					                            	<div class="input-control radio marginLeft10">
					                            		<label>
												         	<input id="logistic_mot_<?php echo $i; ?>" name="Relation_Logistics[<?php echo $i; ?>]" type="radio" value="302" <?php if($DocFlow[$index]['LogisticCode'] == 302) echo 'checked="checked"'; ?>>
												          	<span class="check"></span>
												          	<i class="fa fa-motorcycle fg-lightBlue" style="cursor: pointer; font-size: 1.2em;"></i>
												        </label>
					                            	</div>
					                            	<div class="input-control radio marginLeft10">
					                            		<label>
												         	<input id="logistic_peo_<?php echo $i; ?>" name="Relation_Logistics[<?php echo $i; ?>]" type="radio" value="303" <?php if($DocFlow[$index]['LogisticCode'] == 303) echo 'checked="checked"'; ?>>
												          	<span class="check"></span>
												          	<i class="fa fa-users fg-lightBlue" style="cursor: pointer; font-size: 1.2em;"></i>
												        </label>
					                            	</div>	
													</div>
											<?php } else { ?>
													<div class="marginLeft25" style="margin-top: 0px; padding-bottom: 5px; padding-right: 2px;">
														<div class="input-control radio" style="margin-left: -8px;">
					                            		<label>
												         	<input type="radio" value="301" disabled>
												          	<span class="check"></span>
												          	<i class="fa fa-envelope fg-lightBlue" style="cursor: pointer; font-size: 1.2em;"></i>
												        </label>												        									
					                            	</div>
					                            	<div class="input-control radio marginLeft10">
					                            		<labe>
												         	<input type="radio" value="302" disabled>
												          	<span class="check"></span>
												          	<i class="fa fa-motorcycle fg-lightBlue" style="cursor: pointer; font-size: 1.2em;"></i>
												        </label>
					                            	</div>
					                            	<div class="input-control radio marginLeft10">
					                            		<label>
												         	<input type="radio"  value="303" disabled>
												          	<span class="check"></span>
												          	<i class="fa fa-users fg-lightBlue" style="cursor: pointer; font-size: 1.2em;"></i>
												        </label>
					                            	</div>	
													</div>
											<?php } ?>
				                        							
					                        <?php
					                        
					                        	$STYLE_HIDE = "";
					                        	$FIELD_HIDE = "";
					                        	$FIELD_FAKE = "";
						                        if($rmprocess !== 'Completed') {
						                        	$STYLE_HIDE	= ' display: none;';
						                        	$FIELD_HIDE = ' style="display: none;"';
						                        	$FIELD_FAKE = "
														<td class=\"text-left\">
															<div class=\"input-control cb-marginFixedChrome checkbox nonprint\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
												                <label>
												                    <input type=\"checkbox\" disabled>
												                    <span class=\"check\"></span>
												                </label>
												            </div>
							                            	 <div class=\"input-control text\" style=\"width: 120px;\">
													            <input type=\"text\" disabled>
													        </div>
														</td>
													";
						                        }
					                        
					                        	echo "
			                        			</td>
												$FIELD_FAKE
												<td class=\"text-left\" $FIELD_HIDE>
													<div class=\"input-control cb-marginFixedChrome checkbox nonprint\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
										                <label>
										                    <input id=\"STBH_click_$i\" type=\"checkbox\" value=\"1\" onclick=\"onChecker('Relation_STBH_$i', 'STBH_click_$i', 'LB2HO', $i); GenDateValidator('STBH_click_$i', 'Relation_STBH_$i');\" $LBSChecked>
										                    <span class=\"check\"></span>
										                </label>
										            </div>
					                            	 <div id=\"objSTBH_$i\" class=\"input-control text\" style=\"width: 120px;\">
											            <input type=\"text\" id=\"Relation_STBH_$i\" name=\"Relation_SubmitToHQ[]\" value=\"$SubmitHQ\" onblur=\"onChangeDate('Relation_STBH_$i', 'LB2HO', $i)\" style=\"padding-left: 30px;\">
											        </div>
				                        		</td>
												<td class=\"text-left\">
				                        			<div class=\"input-control cb-marginFixedChrome checkbox nonprint\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
										                <label>
										                    <input $role_block $role_only id=\"RVD_click_$i\" type=\"checkbox\" value=\"1\" onclick=\"onChecker('Relation_RVD_$i', 'RVD_click_$i', 'HQRECEIVED', $i); GenDateValidator('RVD_click_$i', 'Relation_RVD_$i');\" $HQHChecked>
										                    <span class=\"check\" style=\"border-color: #4390df;\"></span>
										                </label>
										            </div>
					                            	 <div id=\"objRVD_$i\" class=\"input-control text\" style=\"width: 120px;\">
											            <input $role_only type=\"text\" id=\"Relation_RVD_$i\" name=\"Relation_HQReceived[]\" value=\"$ReceivLB\" onblur=\"onChangeDate('Relation_RVD_$i', 'HQRECEIVED', $i)\" readonly=\"readonly\" style=\"padding-left: 30px; border-color: #4390df;\" maxlength=\"10\">
											        </div>
				                        		</td>
				                        		<td style=\"min-width: 141px;\">
				                        			<div class=\"input-control select size2\">
						                            	<select id=\"Relation_Sel_$i\" name=\"Relation_ComplementionDoc[]\" data-attr=\"Sel$IsRef\" onchange=\"fnStempCheckDate('Relation_Sel_$i', 'Relation_Checked_$i', $i);\" style=\"height: 33px; max-width: 80px;	margin-left: -30px;\">";
												?>	
						                            		<option value="" <?php if($DocFlow[$index]['CompletionDoc'] == '') { echo 'selected="selected"'; } ?>></option>
						                            		<option value="N" <?php if($DocFlow[$index]['CompletionDoc'] == 'N') { echo 'selected="selected"'; } ?> style="<?php echo $hide_edoc; ?>">ไม่ครบ</option>
						                            		<option value="Y" <?php if($DocFlow[$index]['CompletionDoc'] == 'Y') { echo 'selected="selected"'; } ?> style="<?php echo $hide_edoc; ?>">ครบ</option>
						                        <?php 
						                        
						                        $completion_datecheck = !empty($DocFlow[$index]['CompletionDate']) ? $DocFlow[$index]['CompletionDate']:'';
						                        echo "
						                            	</select>
						                            	<input id=\"Relation_Checked_$i\" name=\"Relation_DocCheckDate[]\" data-attr=\"Sel$IsRef\" type=\"hidden\" value=\"$completion_datecheck\">
					                            	</div>
					                            	<input id=\"completiondoc_hidden_$i\" name=\"completion_hidden[]\" data-attr=\"M$IsRef\" type=\"hidden\" value=\"\">
					                            	<i id=\"CompletionDoc_$i\" onclick=\"openModalComponent($DocID, '$BorrowerName', '$IsRef', 'M');\" class=\"icon-copy on-left budgetFixed fg-lightBlue nonprint\" style=\"cursor: pointer; position:absolute; font-size: 1.5em; margin-top: 5px; margin-left: -40px;\"></i>
					                            	<span id=\"onBadge_$i\" data-attr=\"M$IsRef\" class=\"badge budgetAmountFixed bg-red nonprint\" style=\"position: absolute; margin-left: -28px; margin-top: -5px;\">0</span>
				                        		</td>
				                        		<td class=\"text-left\">
				                        			<div class=\"input-control cb-marginFixedChrome checkbox nonprint\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
										                <label>
										                    <input $role_block $role_only id=\"HCA_click_$i\" type=\"checkbox\" value=\"1\" onclick=\"onChecker('Relation_SubmitToCA_$i', 'HCA_click_$i', 'HO2CA', $i); GenDateValidator('HCA_click_$i', 'Relation_SubmitToCA_$i');\" $HCAChecked>
										                    <span class=\"check\" style=\"border-color: #4390df;\"></span>
										                </label>
										            </div>
					                            	 <div id=\"objHCA_$i\" class=\"input-control text\" style=\"width: 120px;\">
											            <input $role_only type=\"text\" id=\"Relation_SubmitToCA_$i\" name=\"Relation_SubmitToCA[]\" value=\"$AppToCA\" onblur=\"onChangeDate('Relation_SubmitToCA_$i', 'HO2CA', $i)\" readonly=\"readonly\" style=\"padding-left: 30px; border-color: #4390df;\" maxlength=\"10\">
											            <input type=\"hidden\" id=\"Relation_SubmitToCAHide_$i\" name=\"Relation_SubmitToCAHide[]\" value=\"$AppToCA\">
											        </div>
				                        		</td>
				                        		<td  class=\"text-left\">
				                        			<div class=\"input-control cb-marginFixedChrome checkbox nonprint\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;\">
										                <label>
										                    <input $role_block $role_only id=\"CAR_click_$i\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator('CAR_click_$i', 'Relation_CAReturn_$i'); resetRelatedField($i, 'Relation_CAReturn_$i', $RecID); setReturnDateByText('CAR_click_$i', 'remode_$i'); returnDateRecovery($i);\" $lock_returnfield>
										                    <span class=\"check\"></span>
										                </label>
										            </div>
					                            	 <div id=\"objCAR_$i\" class=\"input-control text\" style=\"width: 100px;\">					                         
					                            	 	<p id=\"remode_$i\" class=\"show-pop-list tooltipwebui fg-darkBlue\" data-placement=\"vertical\" onmouseover=\"popoverlogs('remode_$i' ,'listContent_$i', $RecID);\" style=\"margin-left: 25px; padding-top: 7px; padding-left: 10px; font-size: 1em; font-weight: bold;\">$CAReturnlog</p>					                            	 	
											            <input id=\"Relation_CAReturnOrgin_$i\" name=\"Relation_CAReturnOrgin[]\"  type=\"hidden\" value=\"$CAReturnlog\" style=\"padding-left: 30px;\">
											            <input id=\"Relation_CAReturn_$i\" name=\"Relation_CAReturn[]\" type=\"hidden\"  value=\"\" style=\"padding-left: 30px;\">
											        </div>
											        
											        <input id=\"reconcile_id_bundled_$RecID\" name=\"reconcile_id_bundled[]\" type=\"hidden\" value=\"\">
											        <input id=\"creditreturn_list_bundled_$RecID\" name=\"creditreturn_list_bundled[]\" type=\"hidden\" value=\"\">
                									<input id=\"creditreturn_otherlist_bundled_$RecID\" name=\"creditreturn_otherlist_bundled[]\" type=\"hidden\" value=\"\">
											        
											        <div id=\"listContent_$i\" style=\"display: none;\"></div>
											        
				                        		</td>
				                        		<td class=\"budgetWidth\">
				                        			<input id=\"returndoc_hidden_$i\" name=\"returndoc_hidden[]\" data-attr=\"R$IsRef\" type=\"hidden\" value=\"\">
				                        			<i id=\"ReturnsDoc_$i\" onclick=\"openModalComponent($DocID, '$BorrowerName', '$IsRef', 'R');\" class=\"icon-copy on-left fg-lightBlue nonprint\" style=\"cursor: pointer; font-size: 1.5em; margin-bottom: 9px;\"></i>
				                        			<span id=\"returndoc_onBadge_$i\" data-attr=\"R$IsRef\" class=\"badge budgetAmountClear bg-amber\" style=\"position: absolute; margin-left: -20px; margin-top: -11px;\">0</span>				                        			
				                        		</td>
				                        		$objError				                        	
											</tr>
						                        
						                    <script>
						                    
												$(function() {
												
													var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + \"//\" + window.location.host;
													var pathFixed = window.location.protocol + \"//\" + window.location.host;
													for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += \"/\"; }

						                       		$.ajax({
			                                        	url: pathFixed+'dataloads/getNumBadgeByType?_=' + new Date().getTime(),
			                                            type: 'POST',
														data: {
															relx: '$DocID',
															refx: '$IsRef'
														},
			                                            success:function(data) {
			                                            
			                                            	$('#completiondoc_hidden_$i').val(data['data'][0]['NumMissingDoc']);
															$('#onBadge_$i').text(data['data'][0]['NumMissingDoc']);
															
															$('#returndoc_hidden_$i').val(data['data'][0]['NumReturnDoc']);
												           	$('#returndoc_onBadge_$i').text(data['data'][0]['NumReturnDoc']);
												          
														},
			                                            complete:function() {
															
			                                            },
			                                            cache: false,
			                                            timeout: 5000,
			                                            statusCode: {
			                                            	404: function() {
			                                                	alert('page not found.');
			                                                },
			                                                407: function() {
			                                                	console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
			                                                },
			                                                500: function() {
			                                                  	console.log('internal server error.');
			                                                }
														}
								
													});
			
						                       });
						                       
						                     </script>";
						
											$i++;
										}

										
										echo "
										<script>
											
											function onChecker(element, checker, field, id) {
												var old_date = $('#' + element).val();
												setTimeout(function(){ 
													var new_date = $('#' + element).val();
													var custname = $('#ITLRelation_Name_' + id).val();
													var checked	 = $('#' + checker).is(':checked');
													$.ajax({
			                                        	url: pathFixed + 'dataloads/getReconcileChecker?_=' + new Date().getTime(),
			                                            type: 'POST',
														data: {
															relx: '$DocID',
															odate: old_date,
															ndate: new_date,
															xname: custname,
															field: field,
															event: (checked) ? 'CHECKED':'UNCHECKED'
														},
			                                            success:function(data) {},
			                                            cache: false,
			                                            timeout: 15000
		                        					});
													
		                        				}, 500);
											}
											
											function onChangeDate(element, field, id) {
												var old_date = $('#' + element).val();
												setTimeout(function(){ 
													var new_date = $('#' + element).val();
													var custname = $('#ITLRelation_Name_' + id).val();
												
													$.ajax({
			                                        	url: pathFixed + 'dataloads/getReconcileChecker?_=' + new Date().getTime(),
			                                            type: 'POST',
														data: {
															relx: '$DocID',
															odate: old_date,
															ndate: new_date,
															xname: custname,
															field: field,
															event: 'SELECTED'
														},
			                                            success:function(data) {},
			                                            cache: false,
			                                            timeout: 15000
		                        					});
		                        					
													
		                        				}, 500);
												
											}
							
											function resetDocumentFlow(element, id) {
												
												var borrower_names = $('#ITLRelation_Name_' + id).val();
							
												if(confirm('กรุณายืนยันการรีเซ็ตข้อมูลใน Document Flow ของลูกค้า ' + borrower_names)) {
							
													// document mangement
													var doc_id	 	 = $('#DocID').val();
													var rec_docid	 = $('#ITRelation_RecID_' + id).val();
													var logistic 	 = $('input[name=\"Relation_Logistics[' + id + ']\"]:checked').val();
													var borrowertype = $('#ITRelation_Type_' + id).val();
													var borrowername = $('#ITLRelation_Name_' + id).val();
													var submitTohq 	 = $('#Relation_STBH_' + id).val();
													var hqreceived	 = $('#Relation_RVD_' + id).val();
			 										var completion	 = $('#Relation_Sel_' + id).val();
			 										var appToca		 = $('#Relation_SubmitToCA_' + id).val();
													var careturn	 = $('#Relation_CAReturn_' + id).val();
													var cust_ref	 = $('#ITRelation_Ref_' + id).val();
			 												
 													$('#RELLogistic_hidden_' + id).val(logistic);
													$('#RELBorrowerType_hidden_' + id).val(borrowertype);
													$('#RELBorrowerName_hidden_' + id).val(borrowername);
				                            		$('#RELLBToHQ_hidden_' + id).val(submitTohq);
				                            		$('#RELHQReceived_hidden_' + id).val(hqreceived);
				                            		$('#RELCompletion_hidden_' + id).val(completion);
				                            		$('#RELHQToCA_hidden_' + id).val(appToca);
				                            		$('#RELRETurn_hidden_' + id).val(careturn);	
													$('#RELEventLog_hidden_' + id).val('CLEAR');
							
													$('input[name=\"Relation_Logistics[' + id + ']\"]').prop('checked', false);
													$('#STBH_click_' + id).prop('checked', false);
							 						$('#Relation_STBH_' + id).val('');
													$('#RVD_click_' + id).prop('checked', false);
													$('#Relation_RVD_' + id).val('');
													$('#Relation_Sel_' + id).val('');
													$('#HCA_click_' + id).prop('checked', false);							
													$('#Relation_SubmitToCA_' + id).val('');
													$('#Relation_CAReturn_' + id).val('');

													$.ajax({
	                                                    url: pathFixed + 'dataloads/onResetEventDocumentFlow?_=' + new Date().getTime(),
	                                                    type: 'POST',
	 													data: {
															doc_id: doc_id,
															recx_id: rec_docid,
															logistic: logistic,
															custtype: borrowertype,
															custname: borrowername,
															lb2ho: submitTohq,
															hq_received: hqreceived,
															completeddoc: completion,
															ho2ca: appToca,
															isref: cust_ref
														},
	                                                    success:function(resp) {
															if(resp['status']) {
																var not = $.Notify({ content: '[Document Flow] : Reset successfully', style: { background: \"green\", color: \"#FFFFFF\" }, timeout: 10000 });
																not.close(7000);  
															} else {
																var not = $.Notify({ content: '[Document Flow] : Reset failed', style: { background: \"red\", color: \"#FFFFFF\" }, timeout: 10000 });
																not.close(7000);  
															}											
	
	                                                    },
	                                                    complete:function() {},
	                                                    cache: false,
	                                                    timeout: 5000,
	                                                    statusCode: {}
	                                                });		
														
													return true;
																		
												}
							
												return false;
							
											}
																					
											function popoverlogs(element, list_content, ref) {
														
												$.ajax({
                                                    url: pathFixed + 'dataloads/getCreditReturnReason?_=' + new Date().getTime(),
                                                    type: 'POST',
 													data: { rec_ref: ref, mode: 'popover' },
                                                    success:function(responsed) {
														
														$('#' + list_content).html('');
														if(responsed['status']) {
										
															var i = 1;
															for(var index in responsed['data']) {
		
																var reason_name = '';
																if(responsed['data'][index]['DefendCode'] == 'OT099') {
																	reason_name = responsed['data'][index]['DefendReason'] + ' : ' + responsed['data'][index]['DefendOther'];
																} else {
																	reason_name = responsed['data'][index]['DefendReason'];
																}
											
																$('#' + list_content).append('<div>#' + responsed['data'][index]['ReturnDateSub'] + ' ' + reason_name + '</div>');
											
																i++;
										
															}
										
														} else {
															$('#' + list_content).html('ไม่พบข้อมูล');
														}

                                                    },
                                                    complete:function() {
										
 														var listContent = $('#' + list_content).html();												
														$('#' + element).webuiPopover({
															trigger:'click',	
															padding: true,
															content: listContent,
															backdrop: false
														});

                                                    },
                                                    cache: true,
                                                    timeout: 5000,
                                                    statusCode: {
                                                         404: function() { alert('page not found.'); },
                                                         407: function() {
                                                         	console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
                                                         },
                                                         500: function() { console.log('internal server error.'); }
                                                    }
                                                });											
																																
											}
							
											function resetRelatedField(id, bundled, rec_id) {
 		
			 									  var element_return = $('#' + bundled).val();
			 									 
			 									  if(element_return == '') {
			 													 		
			 									  } else {
			 		
			 										if(confirm('ยืนยันการรีเซ็ทข้อมูลหรือไม่')) {
														
														// credit return
														$('#careturnReasonModal').modal({
		                        							 show: true,
            												 keyboard: false,
															 backdrop: 'static'
		                        						}).draggable();
												
														getCAReturnReasonList(); 
														$('#reconcileBundledID').val(rec_id);	
														$('#checkCreditReturn').val('Y');
										
														$('#rollbackBundledID').val(id);
														$('#rollbackElement').val(bundled);
														
														// document mangement
														var logistic 	 = $('input[name=\"Relation_Logistics[' + id + ']\"]:checked').val();
														var borrowertype = $('#ITRelation_Type_' + id).val();
														var borrowername = $('#ITLRelation_Name_' + id).val();
														var submitTohq 	 = $('#Relation_STBH_' + id).val();
														var hqreceived	 = $('#Relation_RVD_' + id).val();
			 											var completion	 = $('#Relation_Sel_' + id).val();
			 											var appToca		 = $('#Relation_SubmitToCA_' + id).val();
														var careturn	 = $('#Relation_CAReturn_' + id).val();
			 													
 														$('#RELLogistic_hidden_' + id).val(logistic);
														$('#RELBorrowerType_hidden_' + id).val(borrowertype);
														$('#RELBorrowerName_hidden_' + id).val(borrowername);
				                            			$('#RELLBToHQ_hidden_' + id).val(submitTohq);
				                            			$('#RELHQReceived_hidden_' + id).val(hqreceived);
				                            			$('#RELCompletion_hidden_' + id).val(completion);
				                            			$('#RELHQToCA_hidden_' + id).val(appToca);
				                            			$('#RELRETurn_hidden_' + id).val(careturn);	
														$('#RELEventLog_hidden_' + id).val('RETURN');	
							
														// Hidden Field
														//$('#RVD_click_' + id).prop('checked', false);	
												 		$('#HCA_click_' + id).prop('checked', false);
			 												
			 											//$('#Relation_RVD_' + id).val('');
			 											//$('#Relation_Sel_' + id).find('option[value=\"\"]').attr('selected', 'selected');
			 											$('#Relation_SubmitToCA_' + id).val('');
																				
			 		 									return true;
													
			 									  	} 
											
													$('#CAR_click_' + id).prop('checked', false);
													$('#Relation_CAReturn_' + id).val('');
											
			 									  	return false;
			 										 
													
										
			 									  }
			 							
			 								  }
											
											  function returnDateRecovery(id) {
												  var is_reset  = $('#Relation_CAReturn_' + id).val();
												  var temp_text = $('#Relation_CAReturnOrgin_' + id).val();
												  console.log([id, is_reset, temp_text, (is_reset === undefined)]);
											  	  if(is_reset === '') $('#remode_' + id).text(temp_text);
											
											  }
							
										      function setReturnDateByText(id, bundled) {
													var str_date;
												    var objDate = new Date();
												    str_date = ('0' + objDate.getDate()).slice(-2) + '/' + ('0' + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
											        var elements =  $('#' + id).is(':checked');
											        if(elements) {
											            $('#' + bundled).text(str_date.substr(0, 5));
											        } else {
											            $('#' + bundled).text('');
											        }
													
											  }
											
											  function fnFieldOnValidation(id, bundled, rows) {
											       var elements = $('#' + id).is(':checked');
												   var amount	= $('#completiondoc_hidden_' + rows).val();
												   var type		= $('#Relation_Sel_' + rows).val();
												   if(elements && type == 'N' && amount == 0) {
														$('#' + id).prop('checked', false)
														$('#' + bundled).val('');
											
														alert('ขออภัย! กรุณาเคลียร์ข้อมูลเอกสารให้ครบถ้วน ก่อนส่งเข้าทีม CA');
														
												   } 
													
											  }
											
											  function fnStempCheckDate(id, bundled, row_id) {
											      	var str_date;
												    var objDate = new Date();
												    str_date = ('0' + objDate.getDate()).slice(-2) + '/' + ('0' + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();

													var getData = $('#' + id + ' option:selected').val();
													if(getData != '') {
														$('#' + bundled).val(str_date);
											
													} else {
														$('#' + bundled).val('');
											
													}
											
											  }
										
											  function getCAReturnReasonList() {
		
													$.ajax({
												    	  url: pathFixed+'dataloads/getDefendType?_=' + new Date().getTime(),
												    	  type: \"POST\",
												    	  data: { dftype: '' },
												          beforeSend:function() {
												        	
												          },
												          success:function(data) {
				
													          $('div#careturn_content').html('');  	        	 
													          for(var indexed in data['data']) {
													        	  
													        	  var margin;
	  	        	  											  if(indexed == 0) margin = 'style=\"min-width: 1150px; margin-top: -20px !important;\"';
													        	  
													        	  $('div#careturn_content').append(
													        			 '<div class=\"panel\" ' + margin + '>' +
																		   '<div class=\"panel-header panel-header-custom bg-lightBlue fg-white text-left\" style=\"font-size: 1.2em; font-weight: bold; min-height: 37px !important; max-height: 37px !important; vetical-text: top; padding-bottom: 2px !important;\">' +
																		   		data['data'][indexed]['MDefendSubject'] +
																		    '</div>' +
																		    '<div class=\"row panel-content\" data-core=\"' + data['data'][indexed]['MDefendCode'] + '\"></div>' +
																		'</div>'
													        	  );
													        	  
													          }
							 
												          },
												          complete:function() {
												        	  
												        	$('div#careturn_content').find('div.panel-header').truncate({
												                width: '470',
												                token: '…',
												                side: 'right',
												                addtitle: true
												         	});
												        	
												        	
												        	$.ajax({
													   	    	  url: pathFixed+'dataloads/getDefendReason?_=' + new Date().getTime(),
													   	    	  type: \"POST\",
													   	          data: { dftype: '' },
													   	          beforeSend:function() {
													   	        
													   	          },
													   	          success:function(data) {
														   	        	  
														   	          var margin;
											 		 	              if(indexed != 0) { 	            		 
											 		 	            	  margin = 'style=\"margin-left: 10px !important; margin-top: -10px !important; min-width: 350px !important;\"';  		 	            		 
											 		 	              } 
																 	    
														              for(var indexed in data['data']) {
														            	  
														            	  $('div#careturn_content')
														            	  .find('div[data-core=\"' + data['data'][indexed]['DefendType'] + '\"]')
														            	  .append(
														            			'<div class=\"careturn_sublist span3 text-left marginTopEasing20\" ' + margin + '>' +
														            				'<div class=\"input-control checkbox\">' +
														            					'<label>' +
														            						'<input id=\"careturn_code_' + indexed + '\" name=\"careturn_fieldcode[]\" type=\"checkbox\" value=\"' + data['data'][indexed]['DefendCode'] + '\">' +
														            						'<span class=\"check\"></span>' +
														            						'<span class=\"careturnlist_text\" style=\"font-weight: normal;\">' + data['data'][indexed]['DefendReason'] + '</span>' +
														            					'</label>' +
														            				'</div>' +
														            			'</div>'
														            	  );
														            	  
														              }   
														              
														              $('input[name^=\"careturn_fieldcode\"]').on('click', function() {
															            	
													  			       	   var other_field = $('input[name$=\"careturn_fieldcode[]\"]:checked').map(function() {return $(this).val();}).get();
													  			       	   if(in_array(\"OT099\", other_field)) {
													  			       		   $('#careturn_otherarea').show();
													  			       	   } else {
													  			       		   $('#careturn_otherarea').hide();		   
													  			       	   }
												 			       	   
												 			          });
															                
														                
													   	          },
													   	          complete:function() {
													   	        	
													   	        	$('div.careturn_sublist').find('span.careturnlist_text').truncate({
													                     width: '400',
													                     token: '…',
													                     side: 'right',
													                     addtitle: true
													              	});
													  	        														   	        	
													   	          },
													   	          cache: true,
													   	          timeout: 5000,
													   	          statusCode: {
													   		  	   
													   	          }
													   	     
												             });
												        	  
												          },
												          cache: true,
												          timeout: 5000,
												          statusCode: {
													  	       
												          }
													     
													});
													
												}

												function setRetrieveOnCAReturnReason(elem_id, documnet_id, defend_number) {
													// Load Reason of credit return list.	
													var check_sel = $(elem_id).is(':checked');
													if(check_sel) {
														
														var list_returnreason = [];
	    												var defend_code   = [];     		
									  	        		$.ajax({
									  	                	url: pathFixed + 'dataloads/getCreditReturnReason?_=' + new Date().getTime(),
									  	                    type: 'POST',
									  						data: {
									  							doc_ref: documnet_id,
									  							return_ref: defend_number,
									  							mode: 'list_load'
									  						},
									  	                    success:function(responsed) {
									  	                    
									  	                    	if(responsed['status']) {  	                    		
									  	                    		for(var index in responsed['data']) {
									  	                    			list_returnreason.push(responsed['data'][index]);  	                    			
									  	                    		}  	                    		
									  	                    	} else {
									  	                    		list_returnreason.push(0); 
									  	                    	}
									  	                    
									  						},
									  	                    complete:function() {
									  	                    	
																if(list_returnreason[0]['DefendCode'] != '') {
		   	        		
												   	        		for(var index in list_returnreason) {
												   	        			$('input[name^=\"careturn_fieldcode\"][value=\"' + list_returnreason[index]['DefendCode'] + '\"]').prop('checked', true);
												   	        			    		   	        			
												   	        			if(list_returnreason[index]['DefendCode'] == \"OT099\") {
												   	        				defend_code.push({ DefendCode: list_returnreason[index]['DefendCode'], DefendOther: list_returnreason[index]['DefendOther']});
												   	        			}
												   	        			
												   	        		}
											   	        				
												   	        		if(in_array('OT099', defend_code[0])) {
												   	        			
												   	        		   $.each(defend_code, function(index, value) { 
												   	        			   
													   	        			if(index == 0) {
													   	        				$('input[name^=\"careturn_topiclist\"]').val(defend_code[index].DefendOther);
													   	        			  
													   	        			} else {
													   	        				
													   	        				$('.input_fields_wrap').append(
													    		   	               	'<div class=\"input-control text\">' +
													    		   	               		'<label class=\"label label-clear\">อื่นๆ : </label>' +
													    		   	   					' <input name=\"careturn_topiclist[]\" type=\"text\" value=\"' + defend_code[index].DefendOther + '\" class=\"size4\">' +
													    		   	               		' <i class=\"fa fa-close fg-red marginTop5 remove_field\" style=\"font-size: 1.5em !important; position: absolute; margin-top: 5px; margin-left: 10px;\"></i>' +    
													    		   	               	'</div>'
												    		   	                );
													   	        				
													   	        			}
												   	        			   	    		   	        			
												   	        		   });
													   	        
												   	        		   $('#careturn_otherarea').show();
												   	        			
												   	        		} 
												   	        		   	        		
												   	        	}
	
									  	                    },
									  	                    cache: false,
									  	                    timeout: 5000,
									  	                    statusCode: {
									  	                    	404: function() { alert('page not found.'); },
									  	                        407: function() {
									  	                        	console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
									  	                        },
									  	                        500: function() { console.log('internal server error.'); }
									  						}
									
									  					});	
													} else {
														
														$('input[name^=\"careturn_fieldcode\"]').prop('checked', false);
											    		$('.input_fields_wrap').html(
											    			'<div class=\"input-control text\">' +
											    		    	'<label class=\"label label-clear\">อื่นๆ :</label>' +
											    		    	'<input id=\"careturn_topiclist\" name=\"careturn_topiclist[]\" type=\"text\" value=\"\" class=\"size4\"> ' +
											    		    	'<span class=\"tooltip-top marginLeft5\" data-tooltip=\"Add new topic.\">' +
											    		    		'<i class=\"fa fa-plus-circle fg-green marginTop5 add_field_button\" style=\"font-size: 1.5em !important;\"></i>' +
											    		    	'</span>' +									    	
											    	    	'</div>	'
											    		);
											    		
											    		 $('#defend_otherlist').hide();
													}

												}
																					
										</script>";
					
								  }


								  ?>
	                        </tbody>
	                    </table>

	                </section>
	         
		        	<!-- Progress for save and alert message  -->
		
				</fieldset>
				
				<div class="span12 nonprint" style="min-width: 1050px; <?php echo $hide_attr; ?>">
                    <div style="float: right; margin-top: 20px; margin-bottom: 20px;">
                        <button id="onprocess" style="padding: 10px 20px;" class="bg-lightBlue fg-white">
                            <i class="fa fa-save on-left"></i> Submit
                        </button>
                    </div>
	        	</div>
				<?php echo form_close(); ?>
				
                <input id="doc_tmp" name="doc_tmp" type="hidden" value="">
                <input id="doc_tmpname" name="doc_tmpname" type="hidden" value="">
                <input id="doc_ref"	name="doc_ref" type="hidden" value=""> 
                
              
                <!-- Start Modal -->
                <div id="myModal" class="modal fade nonprint" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: none;"><span aria-hidden="true">&times;</span></button>
                            	<h4 id="docModalLabel" class="modal-title">Document Management</h4>
                            </div>
                            <div class="modal-body">
                            	
                            	<div class="document_list">
                            		<div class="modal-header text-right" style="height: 25px; border-bottom: 0; margin-right: 10px;">
                            			<span id="documentLack_Note" class="item-title place-left text-warning marginLeft5"></span>
		              					<button id="documentLack_closeModal_head" type="button" class="btn btn-primary" style="margin-top: -20px;" onclick="$('.document_list').hide();"><i class="fa fa-close"></i> Cancel</button>                        	
			                            <button id="documentLack_AcceptModal_head" type="button" class="btn bg-lightBlue fg-white" onclick="getListDocumentToRender($('#doc_tmp').val(), $('#doc_tmpname').val(), $('#doc_ref').val(), $('#LockDocTypes').val());" style="margin-top: -20px;"><i class="fa fa-check fg-lime"></i> Accept</button>
		                            </div>      
       						    	<div id="lackdoc_content" style="padding: 10px 20px; margin-top: -7px;">
       						    	
       						    	</div>   
       						    	<div class="modal-footer">
		              					<button id="documentLack_closeModal_foot" type="button" class="btn btn-primary" onclick="$('.document_list').hide();"><i class="fa fa-close"></i> Cancel</button>                        	
			                            <button id="documentLack_AcceptModal_foot" type="button" class="btn bg-lightBlue fg-white" onclick="getListDocumentToRender($('#doc_tmp').val(), $('#doc_tmpname').val(), $('#doc_ref').val(), $('#LockDocTypes').val());" style="margin-right: 30px;"><i class="fa fa-check fg-lime"></i> Accept</button>
		                            </div>        	
                            	</div>
                            	
                            	<input id="LockDocTypes" name="LockDocTypes" type="hidden" value="">
                            	<section class="form_container" style="clear: both; padding-right: 30px;">
                                    <i id="RelationCompletionLogs" class="icon-history  on-right" style="display: none; float:right; margin-top: -5px; margin-right: 3%; cursor: pointer; font-size: 1.5em;" data-hint="History Logs" data-hint-position="top"></i>                                   
                                    <table id="expense_table_docmanagement" style="width: 100%; min-width: 100%; margin-top: -10px;">
                                    	<thead>
                                            <tr>
                                                <th align="center" style="width: 0.1em; visibility:hidden; border: 0;">TYPE</th>
                                                <th align="center" style="width: 5em;">TYPE</th>
                                                <th align="center" style="width: 31em;">DOCUMENT</th>
                                                <th align="center" style="width: 10em;">LB <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
                                                <th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> HO RECEIVED</th>
                                                <th align="center" style="width: 10em;">HO <i class="fa fa-arrow-right on-right on-left"></i> CA</th>
                                                <th align="center" style="width: 10em;">CA <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
                                                <th align="center" style="width: 10em;">HO <i class="fa fa-arrow-right on-right on-left"></i> LB</th>
                                                <th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> LB RECEIVED</th>
                                                <th style="width: 1.5em;">
                                                	<i onclick="genDocListRecord($('#LockDocTypes').val());" class="fa fa-plus-circle fg-green" style="cursor: pointer; font-size: 1.8em;"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                		<tbody></tbody>
                                     </table>                                        
                                 </section>
             		                             
                            </div>
                            <div class="modal-footer">
                            	<span class="place-left" style="color: red; margin-left: 30px;">เอกสารสีแดง คือ เอกสารสำคัญที่ใช้ในการจดจำนอง,  &nbsp;</span>
                            	<span class="place-left fg-orange">O = เอกสารต้นฉบับ, C = สำเนาเอกสาร</span>
                            	
              					<button id="document_closeModal" type="button" class="btn btn-primary" onclick="$('#myModal').modal('hide'); ">Close</button>                        	
	                            <button id="document_AcceptModal" type="button" class="btn bg-lightBlue fg-white" style="margin-right: 30px;">SAVE</button>
                            </div>
						</div>
					</div>
				</div>
				<!-- End Modal -->
				 
			</section>
		
		</article>

		<div id="form_footer">
	    	<img src="<?php echo base_url('img/logo_form_footer.jpg'); ?>" style="margin-top: 5px; min-width: 1170px; height: 45px;">
		</div>

	</div>
	</div>
	
</div>

<script type="text/javascript">

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
var rootFixed = window.location.protocol + "//" + window.location.host + '/pcis';
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

var note_notify		= 0;
var checkbox_notify	= 0;
var chooselist_lackdoc = [];

function openModalComponent(bundled, name, ref, type) {

	$.ajax({
   		url: pathFixed+'dataloads/getReconcileCompletionDocData?_=' + new Date().getTime(),
   	  	type: "POST",
   	    data: {
   	        relx: bundled,
   			refx: name,
   			ridx: ref,
   			type: type
   	    },
   	    beforeSend:function() {

   	    	$('#LockDocTypes').val(type);
	   		$('#doc_tmp').val(bundled);
	   		$('#doc_tmpname').val(name);
	   		$('#doc_ref').val(ref);
	
	   		$('#myModal').modal({
	   			show: true,
	   			keyboard: false,
	   			backdrop: 'static'		                        		
	   		});

	   		$('.document_list').hide();
	   		$('#expense_table_docmanagement > tbody').empty();

	   		// Set Defalut: data list
	   		chooselist_lackdoc = [];

   	    },
   	    success:function(data) {
   	   	    
	   	   	if(data['status'] == 'true') {
		
	   	   		var i = 1;
		   	   	for(var indexed in data['data']) {
			   	  
			   	   	var doc_id 		  = data['data'][indexed]['DocID'];
					var borrowername  = data['data'][indexed]['DocOwner'];
					var doc_notreturn = data['data'][indexed]['DocIsLock'];
					var doc_type	  = data['data'][indexed]['DocType'];
					var doc_state	  = data['data'][indexed]['DocStatus'];
					var doc_detail	  = data['data'][indexed]['DocDetail'];
					var doc_comment   = data['data'][indexed]['DocOther'];

					var type_1 		  = '',
						type_2 		  = '',
						type_3 		  = '';

					var state_1		  = '',
						state_2		  = '',
						state_3		  = '';

					// Document Type : Missing Doc., Return Doc.
					if(doc_type == '') type_1  = 'selected="selected"';										
					else if(doc_type == 'M') type_2  = 'selected="selected"';
					else if(doc_type == 'R') type_3  = 'selected="selected"';

					// Document Status: Orginal Paper, Copy Paper
					if(doc_state == '') state_1  = 'selected="selected"';
					else if(doc_state == 'C') state_2  = 'selected="selected"';
					else if(doc_state == 'O') state_3  = 'selected="selected"';

					// Field Authority
					var hq_element_lock  = '',
						none_return		 = 'style="display: none"',					
						none_returnField = '';
					
					if(doc_type == 'R') {
						hq_element_lock  = 'border-color: #4390df;';
						none_return		 = '';
						none_returnField = 'style="min-width: 330px; max-width: 330px;"';
					}

					var ele_block   	 = (doc_type == 'M') ? 'disabled="disabled"':'';

					// Set Document not return.
					var doc_control_check  = '';
					var doc_control_field  = '';
					var doc_control_shadow = '';													

					var doc_control_dvbox  = '';
					var doc_control_ccbox  = '';
					var doc_switch_field   = '';

					if(doc_notreturn == 'Y') {	
						
						doc_control_check  = 'checked';
						doc_control_field  = 'text';
					    doc_control_shadow = 'text';
						
						doc_control_dvbox  = '';
						doc_control_ccbox  = 'display: none;';
			
						doc_switch_field   = '<input value="(ไม่คืนเอกสาร) '+ doc_comment +'"><input id="DocListOther_' + i +'" name="DocListOther[]" type="hidden" value="'+ doc_comment +'" placeholder="อธิบายเพิ่มเติม">';
						
					} else {	
						doc_control_check  = '';
						doc_control_field  = 'text';
					    doc_control_shadow = 'hidden';

						doc_control_dvbox  = 'display: none;';
						doc_control_ccbox  = '';

						doc_switch_field   = '<input id="DocListOther_' + i +'" name="DocListOther[]" value="'+ doc_comment +'" placeholder="อธิบายเพิ่มเติม">';
						
					}

					var tooltip_comment = '';
					if(doc_comment !== '') {
						tooltip_comment = 'data-hint-position=\"top\" data-tooltip=\"ข้อความ: ' + doc_comment + '\"';
					}

					var objMissDoc	= data['data'][indexed]['MissID'];
					var LBSentToHQ	= data['data'][indexed]['LBSubmitDocDate'];
					var HQReceived	= data['data'][indexed]['HQReceivedDocFromLBDate'];
					var SentToCA	= data['data'][indexed]['SubmitDocToCADate'];
					var CAReturn	= data['data'][indexed]['CAReturnDate'];
					var HQSentToLB  = data['data'][indexed]['HQSentToLBDate'];
					var LBReceived  = data['data'][indexed]['BranchReceivedDate'];

					var LBChecked	= !(data['data'][indexed]['LBSubmitDocDate'] == '') ? 'checked="checked"':'';
					var HQChecked	= !(data['data'][indexed]['HQReceivedDocFromLBDate'] == '') ? 'checked="checked"':'';
					var LCChecked	= !(data['data'][indexed]['SubmitDocToCADate'] == '') ? 'checked="checked"':'';
					var CAChecked	= !(data['data'][indexed]['CAReturnDate'] == '') ? 'checked="checked"':'';
					var HLChecked	= !(data['data'][indexed]['HQSentToLBDate'] == '') ? 'checked="checked"':'';
					var LRChecked   = !(data['data'][indexed]['BranchReceivedDate'] == '') ? 'checked="checked"':'';

					// ADD NEW ON 25 FEB 2019
					var CreateByName  = data['data'][indexed]['CreateDocBy'];
					var CreateByDate  = (data['data'][indexed]['CreateDocDate']) ? moment(data['data'][indexed]['CreateDocDate']).format('DD/MM/YYYY HH:mm'):'';

					var tooltip_create = '';
					if(CreateByName && CreateByName !== '') {
						tooltip_create = 'data-hint-position=\"top\" data-tooltip=\"' + CreateByDate + ' ' + CreateByName + '\"';
					}		 		

					var role_only   = '',					
						role_block  = '',
						hidden_del  = '',
						change_list = '',
						lbcode	    = $('#BranchCode').val();

					// Set Authority field for head quarter
					if(lbcode != '000') {
						role_only  = 'data-role="hqonly"';
						role_block = 'disabled="disabled"';						
					} else {
						role_only  = '';
						role_block = '';						
					}

					// Set hidden buttom remove
					if(HQReceived != '') {
						if(lbcode == '000') hidden_del = '';
						else hidden_del = ' display: none;';
					}

					if(HQReceived !== '') {
						change_list = ' display: none;'
					}

					var special_doc = data['data'][indexed]['ImportantDoc'];
	            	if(special_doc == 'Y') var special_assing = 'color: red; ';
					else var special_assing = 'color: black !important';

	            	var show_field_sel = '';
	            	var user_id = $('#empprofile_identity').val();
					if(in_array(user_id, ['57251', '59440', '57568'])) {
						show_field_sel = 'visibility:visible;';
					} else {
						show_field_sel = 'visibility:hidden;';
					}
	            	
					$('#expense_table_docmanagement > tbody').append(
						'<tr class=\"item_docmange\">'+
                            '<td style=\"visibility:visible; border: 0; width: 0.1em;">'+
                                '<div class=\"input-control select\">'+
                            	                        			
									'<input id=\"MissID_' + i + '\" name=\"MissID[]\" type=\"hidden\" value=\"' + objMissDoc + '\">'+
									'<input id=\"docList_hidden_' + i +'\" name=\"docList_hidden[]\" type=\"hidden\" value=\"'+ data['data'][indexed]['DocList'] +'\">'+
									'<input name=\"DocID\" type=\"hidden\" value=\"' + bundled + '\">'+
		                			'<input name=\"DocBorrowerName\" type=\"hidden\" value=\"' + name + '\">'+
									'<input name=\"DocIsRef\" type=\"hidden\" value=\"' + ref + '\">'+										
                                '</div>'+
                                '</td>'+
								'<td valign=\"top\">' +
								'<div class=\"input-control select\">'+
                                    '<select id=\"DocStatus_' + i +'\" name=\"DocStatus[]\" style=\"height: 33px;\">'+
										'<option value=\"O\" ' + state_1 + ' ' + state_3 + '>O</option>'+
                                        '<option value=\"C\" ' + state_2 + '>C</option>'+
                                    '</select>'+
                                    '<select id=\"DocType_' + i +'\" name=\"DocTypes[]\" style=\"height: 33px; ' + show_field_sel + '\">'+
	                                    '<option value=\"M\" '+type_2+'>M</option>'+
	                                    '<option value=\"R\" '+type_3+'>R</option>'+		                                                    
	                    			'</select>'+
                                '</div>'+
							'</td>' +
							'<td class=\"text-left\" valign=\"top\">'+
                            '<div class=\"input-control select\" ' + tooltip_create + '>'+                                   
                                '<div id="DoclistText_' + i + '" style=\"height: 33px; padding-left: 10px; padding-top: 5px; border-top: 1px solid #D1D1D1; border-bottom: 1px solid #D1D1D1; ' + special_assing + '\">' +
                                  	'<span>' + doc_detail + '</span>' + 
                                  	'<i class="fa fa-edit fg-gray" style="position: absolute; right: 0; margin-top: 3px; ' + change_list + '" onclick="fnDocListChange(\'' + type + '\', ' +  parseInt(data['data'][indexed]['DocList']) + ', ' + i + ');"></i>' +
                                '</div>' +
								'<div class=\"input-control checkbox tooltip-top\" data-tooltip=\"คลิกเลือก เมื่อไม่คืนเอกสาร\" ' + none_return + ' style=\"margin-left: 3px;\">' +
									'<label class=\"text-left\">' +
										'<input id=\"Doc_NoneReturn_' + i +'\" name=\"Doc_NoneReturn[]\" type=\"checkbox\" value=\"Y\" onclick=\"setNotReturnDoc(\'Doc_NoneReturn_\', ' + i + '); setNotReturnBundled(\'Doc_NoneReturn_\', \'DocNotReturn_\', ' + i + ');\" ' + doc_control_check + ' ' + role_block + '>' +
										'<span class=\"check\"></span>' +
									'</label>' +
								'</div>' +
								'<div id=\"Label_DocListOther_' + i +'\" class=\"input-control text\" ' + tooltip_comment + ' ' + none_returnField + '>' +
									doc_switch_field +
								'</div>'+								
								'<input id=\"DocList_' + i +'\" name=\"DocList[]\" type=\"hidden\" value=\"'+  parseInt(data['data'][indexed]['DocList']) + '\">' +
								'<input id=\"DocNotReturn_' + i +'\" name=\"DocNotReturn[]\" type=\"hidden\" value=\"' + doc_notreturn + '\">' +
                            '</div>'+
                        '</td>'+
                        '<td class=\"text-left\" valign=\"top\">'+
                            '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
                                '<label>'+
                                    '<input id=\"DSubHQ_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"onDocChecker(\'Doc_SubmitToHQ_' + i + '\', \'DSubHQ_click_' + i + '\', \'LB2HO\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + '); GenDateValidator(\'DSubHQ_click_'+ i +'\', \'Doc_SubmitToHQ_'+ i +'\');\" '+ LBChecked + ' >'+
                                    '<span class=\"check\"></span>'+
                                '</label>'+
                            '</div>'+
                            '<div id=\"objSubHQ_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
                                '<input type=\"'+ doc_control_field + '\" id=\"Doc_SubmitToHQ_' + i +'\" name=\"Doc_SubmitToHQ[]\" value=\"' + LBSentToHQ + '\" onblur=\"onDocChangeDate(\'Doc_SubmitToHQ_' + i + '\', \'LB2HO\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + ');\"  style=\"padding-left: 30px;\" readonly>'+
                            '</div>'+
							'<div id=\"Doc_SubmitToHQ_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
                                '<input type=\"' + doc_control_shadow + '\" value=\"' + LBSentToHQ + '\" disabled>'+
                            '</div>'+
                        '</td>'+
                        '<td class=\"text-left\" valign=\"top\">'+
                            '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
                                '<label>'+
                                    '<input ' + role_block + ' ' + role_only + '  id=\"DRVD_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"onDocChecker(\'Doc_RVD_' + i + '\', \'DRVD_click_' + i + '\', \'HOReceived\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + '); GenDateValidator(\'DRVD_click_'+ i +'\', \'Doc_RVD_'+ i +'\');\" ' + HQChecked + '>'+
                                    '<span class=\"check\" style=\"border-color: #4390df;\"></span>'+
                                '</label>'+
                            '</div>'+
                            '<div id=\"objDRVD_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
                                '<input ' + role_only + ' type=\"'+ doc_control_field + '\" id=\"Doc_RVD_' + i +'\" name=\"Doc_HQReceived[]\" value=\"' + HQReceived + '\" onblur=\"onDocChangeDate(\'Doc_RVD_' + i + '\', \'HOReceived\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + ');\" style=\"padding-left: 30px; border-color: #4390df;\" readonly>'+
                            '</div>'+
							'<div id=\"Doc_RVD_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
                                '<input type=\"' + doc_control_shadow + '\" value=\"' + HQReceived + '\" disabled>'+
                            '</div>'+
                        '</td>'+
                        '<td class=\"text-left\" valign=\"top\">'+
                            '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
                                '<label>'+
                                    '<input ' + role_block + ' ' + role_only + ' id=\"HQC_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"onDocChecker(\'Doc_HQC_' + i + '\', \'HQC_click_' + i + '\', \'HO2CA\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + '); GenDateValidator(\'HQC_click_'+ i +'\', \'Doc_HQC_'+ i +'\');\" ' + LCChecked + '>'+
                                    '<span class=\"check\" style=\"border-color: #4390df;\"></span>'+
                                '</label>'+
                            '</div>'+
                            '<div id=\"objHQC_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
                                '<input ' + role_only + ' type=\"'+ doc_control_field + '\" id=\"Doc_HQC_' + i +'\" name=\"Doc_HQToCA[]\" value=\"' + SentToCA + '\" onblur=\"onDocChangeDate(\'Doc_HQC_' + i + '\', \'HO2CA\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + ');\" style=\"padding-left: 30px; border-color: #4390df;\" readonly>'+
                            '</div>'+
							'<div id=\"Doc_HQC_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
                                '<input type=\"' + doc_control_shadow + '\" value=\"' + SentToCA + '\" disabled>'+
                            '</div>'+
                        '</td>'+
                        '<td class=\"text-left\" valign=\"top\">'+
                            '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
                                '<label>'+
                                    '<input ' + role_block + ' ' + role_only + ' id=\"CAH_click_' + i +'\" type=\"checkbox\" onclick=\"onDocChecker(\'Doc_CAH_' + i + '\', \'CAH_click_' + i + '\', \'CA2HO\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + '); GenDateValidator(\'CAH_click_'+ i +'\', \'Doc_CAH_'+ i +'\');\" value=\"1\" ' + CAChecked + ' ' + ele_block + '>'+
                                    '<span class=\"check\" style=\"' + hq_element_lock + '\"></span>'+
                                '</label>'+
                            '</div>'+
                            '<div id=\"objCAH_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
                                '<input ' + role_only + ' type=\"'+ doc_control_field + '\" id=\"Doc_CAH_' + i +'\" name=\"Doc_CAToHQ[]\" value=\"' + CAReturn + '\" onblur=\"onDocChangeDate(\'Doc_CAH_' + i + '\', \'CA2HO\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + ');\" style=\"padding-left: 30px; ' + hq_element_lock + '\" ' + ele_block + ' readonly>'+
                            '</div>'+
							'<div id=\"Doc_CAH_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
                                '<input type=\"' + doc_control_shadow + '\" value=\"' + CAReturn + '\" disabled>'+
                            '</div>'+
                        '</td>'+
                        '<td class=\"text-left\" valign=\"top\">'+
                            '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
                                '<label>'+
                                    '<input ' + role_block + ' ' + role_only + ' id=\"HQL_click_' + i +'\" type=\"checkbox\" onclick=\"onDocChecker(\'Doc_HQL_' + i + '\', \'HQL_click_' + i + '\', \'HO2LB\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + '); GenDateValidator(\'HQL_click_'+ i +'\', \'Doc_HQL_'+ i +'\');\" value=\"1\" ' + HLChecked + ' ' + ele_block + '>'+
                                    '<span class=\"check\" style=\"' + hq_element_lock + '\"></span>'+
                                '</label>'+
                            '</div>'+
                            '<div id=\"objHQL_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
                                '<input ' + role_only + ' type=\"'+ doc_control_field + '\" id=\"Doc_HQL_' + i +'\" name=\"Doc_HQToLB[]\" value=\"' + HQSentToLB + '\" onblur=\"onDocChangeDate(\'Doc_HQL_' + i + '\', \'HO2LB\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + ');\" style=\"padding-left: 30px; ' + hq_element_lock + '\" ' + ele_block + ' readonly>'+
                            '</div>'+
							'<div id=\"Doc_HQL_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
                                '<input type=\"' + doc_control_shadow + '\" value=\"' + HQSentToLB + '\" disabled>'+
                            '</div>'+
                        '</td>'+
                        '<td class=\"text-left\" valign=\"top\">'+
                            '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
                                '<label>'+
                                    '<input id=\"LBR_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"onDocChecker(\'Doc_LBR_' + i + '\', \'LBR_click_' + i + '\', \'LBFinish\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + '); GenDateValidator(\'LBR_click_'+ i +'\', \'Doc_LBR_'+ i +'\');\" ' + LRChecked + ' ' + ele_block + '>'+
                                    '<span class=\"check\"></span>'+
                                '</label>'+
                            '</div>'+
                            '<div id=\"objLBR_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
                                '<input type=\"'+ doc_control_field + '\" id=\"Doc_LBR_' + i +'\" name=\"Doc_LBReceived[]\" value=\"' + LBReceived + '\" onblur=\"onDocChangeDate(\'Doc_LBR_' + i + '\', \'LBFinish\', \'' + doc_type + '\', \'' + bundled + '\', ' + i + ');\" style=\"padding-left: 30px;\" ' + ele_block + '>'+
                            '</div>'+
							'<div id=\"Doc_LBR_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
                                '<input type=\"' + doc_control_shadow + '\" value=\"' + LBReceived + '\" disabled>'+
                            '</div>'+
                        '</td>'+ 																		
                        '<td class=\"del\">'+
                            '<i class=\"fa fa-minus-circle\" style=\"cursor: pointer; font-size: 1.5em; color: red; margin-top: -20px; ' + hidden_del + '\" onclick=\"delRecordRelations(' + doc_id + ',\'' + ref + '\', '+  parseInt(data['data'][indexed]['DocList']) + ');\"></i>'+
                        '</td>'+
					'</tr>'
					);

					$('#objSubHQ_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
					if(doc_type == 'M') {
                		$('#objDRVD_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                        $('#objHQC_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                	} else {
                		$('#objDRVD_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                        $('#objHQC_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    					$('#objCAH_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                        $('#objHQL_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    					$('#objLBR_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                	}
                   
					i++;
			
		   	   	}
		   	   	
	   	   	} else {
	   	   		renderErr();
	   	   	}

   	    },
   		complete:function() {
   	   		
   			if(type == 'M') { $('#docModalLabel').text('Missing Document').addClass('animated fadeIn'); }
   			else { $('#docModalLabel').text('Return Document').addClass('animated fadeIn'); }
   			
   		},				
   		cache: true,
   		timeout: 10000,
   		statusCode: {
   			404: function() { console.log("page not found."); },
   			407: function() {
   			  	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
   			},
   			500: function() { console.log("internal server error."); }
   		}
   	        
   	});

	var renderErr = function() {
	   	$('#expense_table_docmanagement > tbody')
		.empty()
		.append(
			'<tr class="row_empty">' +
				'<td style="width: 0.1em; visibility:hidden; border: 0; padding: 0;"></td>' +						
				'<td colspan="8" style="padding: 0;">ไม่พบข้อมูล</td>' +
				'<td style="padding: 0;"></td>' +
			'</tr>'
		);
		
    }
		
}

function genDocListRecord(doc_type) {
	$('.document_list').show().addClass('animated fadeInDown').after(function() {
		getLackDocList(doc_type);
		$('#documentLack_AcceptModal_head, #documentLack_AcceptModal_foot')
		.attr('onclick', "getListDocumentToRender($('#doc_tmp').val(), $('#doc_tmpname').val(), $('#doc_ref').val(), $('#LockDocTypes').val())");
				
	});
	
}

function fnDocListChange(doc_type, value, id) {
	
	$('.document_list').show().addClass('animated fadeInDown').after(function() {
		getLackDocList(doc_type, value, 'single');
		$('#documentLack_AcceptModal_head, #documentLack_AcceptModal_foot')
		.attr('onclick', 'getNewDoctoChangeLackList(' + id + ')');
		
	});
	
}

function onDocChecker(element, checker, field, type, rel, id) {
	var old_date = $('#' + element).val();
	setTimeout(function(){ 
		var new_date = $('#' + element).val();
		var custname = $('#doc_tmpname').val();
		var checked	 = $('#' + checker).is(':checked');
		$.ajax({
			url: pathFixed + 'dataloads/getReconcileCompletionChecker?_=' + new Date().getTime(),
			type: 'POST',
			data: {
				relx: rel,
				odate: old_date,
				ndate: new_date,
				xname: custname,
				dtype: type,
				field: field,
				event: (checked) ? 'CHECKED':'UNCHECKED'
			},
			success:function(data) {},
			cache: false,
			timeout: 15000
		});
		
	}, 500);
}

function onDocChangeDate(element, field, type, rel, id) {
	var old_date = $('#' + element).val();
	setTimeout(function(){ 
		var new_date = $('#' + element).val();
		var custname = $('#doc_tmpname').val();
	
		$.ajax({
			url: pathFixed + 'dataloads/getReconcileCompletionChecker?_=' + new Date().getTime(),
			type: 'POST',
			data: {
				relx: rel,
				odate: old_date,
				ndate: new_date,
				xname: custname,
				dtype: type,
				field: field,
				event: 'SELECTED'
			},
			success:function(data) {},
			cache: false,
			timeout: 15000
		});
		
		
	}, 500);
	
}

function getLackDocList(doc_type, values = false, mode = 'multi') {

	var field_type;
	if(mode === 'single')
		field_type = 'radio';
	else
		field_type = 'checkbox';

	$.ajax({
    	  url: pathFixed + 'dataloads/lackcategory?_=' + new Date().getTime(),
    	  type: "POST",
    	  data: { typex: doc_type },
          beforeSend:function() {
        	  $('div#lackdoc_content').html('');  
          },
          success:function(data) {
		       	 
	          for(var indexed in data['data']) {
	        	 
	        	  var margin;
				  if(indexed == 0) margin = 'style="min-width: 95%;"';
				  
	        	  $('div#lackdoc_content').append(
        			 '<div class="panel" ' + margin + '>' +
					   '<div class="panel-header panel-header-custom bg-lightBlue fg-white text-left" style="font-size: 1.2em; font-weight: bold; min-height: 37px !important; max-height: 37px !important; vetical-text: top; padding-bottom: 2px !important;">' +
					  		data['data'][indexed]['LackCategory'] +
					    '</div>' +
					    '<div class="row panel-content" data-core="PanelLackAt_' + data['data'][indexed]['LackGroupID'] + '"></div>' +
					'</div>'
	        	  );
	        	  
	          }
			 
          },
          complete:function() {

        		$.ajax({
	   	    	  url: pathFixed+'dataloads/lackdoctype?_=' + new Date().getTime(),
	   	    	  type: "POST",
	   	          data: { typex: doc_type },
	   	          beforeSend:function() {
		   	          	   
	   	        	  if(mode !== 'single') {
		   	        	  if(note_notify == 0) {
		   	        		  var notify  = $.Notify({ content: 'ระบบ: รายการเอกสารสีแดง คือ รายการเอกสารสำคัญที่ต้องใช้ในการจดจำนอง', style: { background: "#F0A30A", color: "#FFFFFF" }, timeout: 10000 }); 
		   	        		  note_notify = 1;
		   	        		  notify.close(9000); 
		   	        	  }
	   	        	  }
		   	          
	   	          },
	   	          success:function(data) {
		   	        	  
		   	          var margin;
		 	          if(indexed != 0) { 	            		 
		 	          	  margin = 'style="margin-left: 10px !important; margin-top: -15px !important; min-width: 380px !important;"';  		 	            		 
		 	          } 
				 	    
		              for(var indexed in data['data']) {

		            	  var special_doc = data['data'][indexed]['ImportantDoc'];
		            	  if(special_doc == 'Y') var special_assing = 'color: red; ';
						  else var special_assing = 'color: black !important';
		            	  
		            	  $('div#lackdoc_content')
		            	  .find('div[data-core="PanelLackAt_' + data['data'][indexed]['LackGroupID'] + '"]')
		            	  .append(
		            			'<div class="lackdoc_sublist span3 text-left" ' + margin + '>' +
		            				'<div class="input-control ' + field_type + '">' +
		            					'<label>' +
		            						'<input id="lackdoc_fieldcode_' + indexed + '" name="lackdoc_fieldcode[]" type="' + field_type + '" value="' + data['data'][indexed]['LackID'] + '" data-attr="' + data['data'][indexed]['LackDoc'] + '">' +
		            						'<span class="check"></span>' +
		            						'<span class="lackdoc_code_text" style="font-weight: normal; ' + special_assing + '">' + data['data'][indexed]['LackDoc'] + '</span>' +
		            					'</label>' +
		            				'</div>' +
		            			'</div>'
		            	  );
		            	  
		              }	
		            
	   	          },
	   	          complete:function() {

	   	        	if(values !== false) {
	   	        		var element_num = $('input[name$="lackdoc_fieldcode[]"][value="' +  parseInt(values) + '"]').length;
	   	        		if(element_num >= 1) {							
							$('input[name$="lackdoc_fieldcode[]"][value="' +  parseInt(values) + '"]').prop('checked', true);
	   	        		} else {
	   	        			$('#documentLack_Note').text('กรุณาเปลี่ยนหัวข้อใหม่ เนื่องจากหัวข้อเดิมเป็นหัวข้อที่ยกเลิกการใช้งาน').delay(800).addClass('animated rubberBand');
	   	        			var not = $.Notify({ content: 'กรุณาเปลี่ยนหัวข้อใหม่', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
	   						not.close(7000);  
	   	        		} 		            	
		            }

	   	        	if(mode !== 'single') {
			            if(chooselist_lackdoc.length >= 1) {	  
			            	if(checkbox_notify === 0) {
			            		var msg_notify  = $.Notify({ content: 'Checkbox กรอบสีเขียว คือ หัวข้อที่เลือกใช้งานไปแล้วในการสร้างรายการครั้งล่าสุด', style: { background: "#1B6EAE", color: "#FFFFFF" }, timeout: 10000 });
			            		checkbox_notify = 1;
			            	}
				                      	
				            $.each(chooselist_lackdoc, function(index) {
				            	$('input[name$="lackdoc_fieldcode[]"][value="' + chooselist_lackdoc[index] + '"]').parent().find('span.check').css('border', '2px solid #008A00');
				            })		            	
			            }
	   	        	}
	   	        	
	   	        	$('div.careturn_sublist').find('span.careturnlist_text').truncate({
	                     width: '400',
	                     token: '…',
	                     side: 'right',
	                     addtitle: true
	              	});
	  	        	
	   	        	
	   	          },
	   	          cache: true,
	   	          timeout: 5000,
	   	          statusCode: {
	   		  	   
	   	          }
	   	     
             });
        	
          },
          cache: true,
          timeout: 5000,
          statusCode: {
	  	       
          }
	     
	});
	
}

function setNotReturnBundled(element, to_element, id) {
	var elements = $('#' + element + id).is(':checked');
	if(elements) $('#' + to_element + id).val('Y');
	else $('#' + to_element + id).val('');				
}

function setNotReturnDoc(element, id) {															
	var doc_comment = ($('#DocListOther_' + id).val() != undefined) ? $('#DocListOther_' + id).val():'';
	var elements 	= $('#' + element + id).is(':checked');
	if(elements) {

		$('#DSubHQ_click_' + id).parent().parent().css('display', 'none');
		$('#DRVD_click_' + id).parent().parent().css('display', 'none');
		$('#HQC_click_' + id).parent().parent().css('display', 'none');
		$('#CAH_click_' + id).parent().parent().css('display', 'none');	
		$('#HQL_click_' + id).parent().parent().css('display', 'none');
		$('#LBR_click_' + id).parent().parent().css('display', 'none');
								
		$('#Doc_SubmitToHQ_' + id).parent().css('display', 'none');
		$('#Doc_RVD_' + id).parent().css('display', 'none');
		$('#Doc_HQC_' + id).parent().css('display', 'none');
		$('#Doc_CAH_' + id).parent().css('display', 'none');
		$('#Doc_HQL_' + id).parent().css('display', 'none');
		$('#Doc_LBR_' + id).parent().css('display', 'none');

		$('#Doc_SubmitToHQ_' + id + '_hidden > input').attr('type', 'text').removeAttr('style').parent().removeAttr('style');
		$('#Doc_RVD_' + id + '_hidden > input').attr('type', 'text').removeAttr('style').parent().removeAttr('style');
		$('#Doc_HQC_' + id + '_hidden > input').attr('type', 'text').removeAttr('style').parent().removeAttr('style');
		$('#Doc_CAH_' + id + '_hidden > input').attr('type', 'text').removeAttr('style').parent().removeAttr('style');
		$('#Doc_HQL_' + id + '_hidden > input').attr('type', 'text').removeAttr('style').parent().removeAttr('style');
		$('#Doc_LBR_' + id + '_hidden > input').attr('type', 'text').removeAttr('style').parent().removeAttr('style');
													
		$('#Label_DocListOther_' + id).html('<input value="(ไม่คืนเอกสาร) '+ doc_comment +'"><input id="DocListOther_' + i +'" name="DocListOther[]" type="hidden" value="'+ doc_comment +'">');
	} else {

		$('#DSubHQ_click_' + id).parent().parent().css('display', 'block');
		$('#DRVD_click_' + id).parent().parent().css('display', 'block');
		$('#HQC_click_' + id).parent().parent().css('display', 'block');
		$('#CAH_click_' + id).parent().parent().css('display', 'block');	
		$('#HQL_click_' + id).parent().parent().css('display', 'block');
		$('#LBR_click_' + id).parent().parent().css('display', 'block');
								
		$('#Doc_SubmitToHQ_' + id).parent().css('display', 'block');
		$('#Doc_RVD_' + id).parent().css('display', 'block');
		$('#Doc_HQC_' + id).parent().css('display', 'block');
		$('#Doc_CAH_' + id).parent().css('display', 'block');
		$('#Doc_HQL_' + id).parent().css('display', 'block');
		$('#Doc_LBR_' + id).parent().css('display', 'block');

		$('#Doc_SubmitToHQ_' + id + '_hidden > input').attr('type', 'hidden').removeAttr('style').parent().attr('display', 'none');
		$('#Doc_RVD_' + id + '_hidden > input').attr('type', 'hidden').removeAttr('style').parent().attr('display', 'none');
		$('#Doc_HQC_' + id + '_hidden > input').attr('type', 'hidden').removeAttr('style').parent().attr('display', 'none');
		$('#Doc_CAH_' + id + '_hidden > input').attr('type', 'hidden').removeAttr('style').parent().attr('display', 'none');
		$('#Doc_HQL_' + id + '_hidden > input').attr('type', 'hidden').removeAttr('style').parent().attr('display', 'none');
		$('#Doc_LBR_' + id + '_hidden > input').attr('type', 'hidden').removeAttr('style').parent().attr('display', 'none');
		
		$('#Label_DocListOther_' + id).html('<input id="DocListOther_' + i +'" name="DocListOther[]" value="'+ doc_comment +'">');

	}

}

function delRecordRelations(bundled, ref, data) {
		
  	if(confirm('ยืนยันการลบข้อมูลหรือไม่')) {
										
		$.ajax({
        	url: pathFixed + 'management/delRecordBorrowerLoan?_=' + new Date().getTime(),
            type: 'POST',
			data: {
				relx: bundled,
				ltsx: data,
				modx: 'rcpx5',
				real: ref
			},
            success:function(data) {
				var not = $.Notify({ content: "ลบข้อมูลสำเร็จ", style: { background: "green", color: "#FFFFFF" }, timeout: 10000 });
				not.close(7000);                                      														
			},
            complete:function() {
        		
				var doc_id		   = $('#DocID').val();
				var is_ref		   = $('input[name="DocIsRef"]').val();
				var doc_borrower   = $('input[name="DocBorrowerName"]').val();
														
				$.ajax({
                url: pathFixed+'dataloads/getNumBadgeByType?_=' + new Date().getTime(),
                type: 'POST',
				data: {
					relx: doc_id,
					refx: is_ref
				},
                success:function(data) {
                    	
					var miss_ref 	= 'M' + is_ref;
					var return_ref	= 'R' + is_ref;
					var select_ref	= 'Sel' + is_ref;
					
                    $('input[data-attr="'+ miss_ref +'"]').val(data['data'][0]['NumMissingDoc']);
					$('span[data-attr="'+ miss_ref +'"]').text(data['data'][0]['NumMissingDoc']);
						
					$('input[data-attr="' + return_ref +'"]').val(data['data'][0]['NumReturnDoc']);
			        $('span[data-attr="' + return_ref +'"]').text(data['data'][0]['NumReturnDoc']);

					$('select[data-attr="'+ select_ref +'"]').find('option[value="' + data['data'][0]['CompletionDoc'] +'"]').attr('selected', 'selected');
			          
				},
                complete:function() {
						
                },
                cache: false,
                timeout: 5000,
                statusCode: {
                    404: function() {
                        alert('page not found.');
                    },
                    407: function() {
                        console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
                    },
                    500: function() {
                        console.log('internal server error.');
                    }
				}

			});
				
        },
        cache: false,
        timeout: 5000,
        statusCode: {
            404: function() {
                alert('page not found.');
            },
            407: function() {
                console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
            },
            500: function() {
                console.log('internal server error.');
            }
		}
	});										
		
	$('body').on('click', '#expense_table_docmanagement .del', function() {
	    var tr_length = $('#expense_table_docmanagement tr.item_docmange').length;											
	    if(parseInt(tr_length) > 1) {
	        $(this).parent().remove();	
    
	    } else {
	        $('#expense_table_docmanagement').parent().after('<span class="docmange_error text-danger span5">หากแถวที่ระบุน้อยกว่าที่กำหนดจะไม่สามารถลบแถวได้..</span>').fadeIn();
	        $('.docmange_error').fadeOut(5000);
	            
	    }
	});

    return true;
 		
	}

}

function getListDocumentToRender(bundled, name, ref, doc_type) {
	
	var missing_getdoc    = $('input[name$="lackdoc_fieldcode[]"]:checked').map(function() {return $(this).val();}).get();
	var missing_getdoctxt = $('input[name$="lackdoc_fieldcode[]"]:checked').map(function() {return $(this).attr('data-attr');}).get();

	if(missing_getdoc[0] === undefined) {		
		var not = $.Notify({ content: 'กรุณาเลือกรายการอย่างน้อย 1 รายการ', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
		not.close(7000); 
		
	} else {

		if(confirm('กรุณายืนยันการเลือกข้อมูล')) {
			
			var row_num = $('#expense_table_docmanagement tbody > tr').length;

			$.each(missing_getdoc, function(index, value) {

				var doc_type_list_1,
					doc_type_list_2;
				
				if(doc_type == 'M') doc_type_list_1 = 'selected="selected"'; 
				else doc_type_list_1 = '';

				if(doc_type == 'R') doc_type_list_2 = 'selected="selected"'; 
				else doc_type_list_2 = '';

				var hq_element_lock = '';
				if(doc_type == 'R') hq_element_lock = 'border-color: #4390df;';

				var role_only   = '';
				var role_block  = '';
				var lbcode	    = $('#BranchCode').val();

				if(lbcode != '000') {
					role_only 	= 'data-role="hqonly"';
					role_block  = 'disabled="disabled"';
				} else {
					role_only   = '';
					role_block  = '';
				}

				var ele_block   = (doc_type == 'M') ? 'disabled="disabled"':'';

				var i = ++row_num;
				// animated fadeIn
				$('#expense_table_docmanagement > tbody').append(
					'<tr class="item_docmange">'+
	                    '<td style="visibility:hidden; border: 0; width: 0.1em;">'+
	                        '<input name="DocID" type="hidden" value="' + bundled + '">'+
	                        '<input name="DocBorrowerName" type="hidden" value="' + name + '">'+
							'<input name="DocIsRef" type="hidden" value="' + ref + '">'+
	                        '<div class="input-control select">'+
	                            '<select id="DocType_' + i +'" name="DocTypes[]" style="height: 33px;">'+
	                                '<option value="M" ' + doc_type_list_1 +'>M</option>'+
	                                '<option value="R" ' + doc_type_list_2 +'>R</option>'+
	                            '</select>'+
								'<input id="MissID_' + i + '" name="MissID[]" type="hidden" value="0">'+
	                        '</div>'+
	                    '</td>'+
						'<td valign="top">' +
							'<div class="input-control select">'+
	                            '<select id="DocStatus_' + i +'" name="DocStatus[]" style="height: 33px;">'+
									'<option value="O" selected="selected">O</option>'+
	                                '<option value="C">C</option>'+
	                            '</select>'+ 																
	                        '</div>'+
						'</td>' +
	                    '<td class="text-left" valign="top">'+
	                    	'<div style=\"height: 33px; padding-left: 10px; padding-top: 5px; border-top: 1px solid #D1D1D1; border-bottom: 1px solid #D1D1D1;\">' + missing_getdoctxt[index] + '</div>' +	
	                   		'<div class="input-control text">'+   
			                    '<div id="Label_DocListOther_' + i +'" class="input-control text">'+
									'<input id="DocListOther_' + i +'" name="DocListOther[]" value="" placeholder="อธิบายเพิ่มเติม">'+
								'</div>'+
							'</div>'+															
							'<input id=\"DocList_' + i +'\" name=\"DocList[]\" type=\"hidden\" value=\"'+  parseInt(missing_getdoc[index]) + '\">' +
	                    '</td>'+
	                    '<td class="text-left" valign="top">'+
	                        '<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">'+
	                            '<label>'+
	                                '<input id="DSubHQ_click_'+ i +'" type="checkbox" value="1" onclick="GenDateValidator(\'DSubHQ_click_' + i + '\', \'Doc_SubmitToHQ_' + i + '\');">'+
	                                '<span class="check"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id="objSubHQ_'+ i +'" class="input-control text" style="width: 120px;">'+
	                            '<input type="text" id="Doc_SubmitToHQ_'+ i +'" name="Doc_SubmitToHQ[]" value="" style="padding-left: 30px;">'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class="text-left" valign="top">'+
	                        '<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">'+
	                            '<label>'+
	                                '<input ' + role_block + ' ' + role_only + ' id="DRVD_click_'+ i +'" type="checkbox" value="1" onclick="GenDateValidator(\'DRVD_click_' + i + '\', \'Doc_RVD_' + i + '\');">'+
	                                '<span class="check" style="border-color: #4390df;"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id="objDRVD_'+ i +'" class="input-control text" style="width: 120px;">'+
	                            '<input ' + role_only + ' type="text" id="Doc_RVD_'+ i +'" name="Doc_HQReceived[]" value="" style="padding-left: 30px; border-color: #4390df;">'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class="text-left" valign="top">'+
	                        '<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">'+
	                            '<label>'+
	                                '<input ' + role_block + ' ' + role_only + ' id="HQC_click_'+ i +'" type="checkbox" value="1" onclick="GenDateValidator(\'HQC_click_' + i + '\', \'Doc_HQC_' + i + '\');">'+
	                                '<span class="check" style="border-color: #4390df;"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id="objHQC_'+ i +'" class="input-control text" style="width: 120px;">'+
	                            '<input ' + role_only + ' type="text" id="Doc_HQC_'+ i +'" name="Doc_HQToCA[]" value="" style="padding-left: 30px; border-color: #4390df;">'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class="text-left" valign="top">'+
	                        '<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">'+
	                            '<label>'+
	                                '<input ' + role_block + ' ' + role_only + ' id="CAH_click_'+ i +'" type="checkbox" value="1" onclick="GenDateValidator(\'CAH_click_' + i + '\', \'Doc_CAH_' + i + '\');" ' + ele_block + '>'+
	                                '<span class="check" style="' + hq_element_lock + '"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id="objCAH_'+ i +'" class="input-control text" style="width: 120px;">'+
	                            '<input ' + role_only + ' type="text" id="Doc_CAH_'+ i +'" name="Doc_CAToHQ[]" value="" style="padding-left: 30px; ' + hq_element_lock + '" ' + ele_block + '>'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class="text-left" valign="top">'+
	                        '<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">'+
	                            '<label>'+
	                                '<input ' + role_block + ' ' + role_only + ' id="HQL_click_'+ i +'" type="checkbox" value="1" onclick="GenDateValidator(\'HQL_click_' + i + '\', \'Doc_HQL_' + i + '\');" ' + ele_block + '>'+
	                                '<span class="check" style="' + hq_element_lock + ': #4390df;"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id="objHQL_'+ i +'" class="input-control text" style="width: 120px;">'+
	                            '<input ' + role_only + ' type="text" id="Doc_HQL_'+ i +'" name="Doc_HQToLB[]" value="" style="padding-left: 30px; ' + hq_element_lock + '" ' + ele_block + '>'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class="text-left" valign="top">'+
	                        '<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">'+
	                            '<label>'+
	                                '<input id="LBR_click_'+ i +'" type="checkbox" value="1" onclick="GenDateValidator(\'LBR_click_' + i + '\', \'Doc_LBR_' + i + '\');" ' + ele_block + '>'+
	                                '<span class="check"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id="objLBR_'+ i +'" class="input-control text" style="width: 120px;">'+
	                            '<input type="text" id="Doc_LBR_'+ i +'" name="Doc_LBReceived[]" value="" style="padding-left: 30px;" ' + ele_block + '>'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class="reconcile_del">'+
	                        '<i class="fa fa-minus-circle" onclick="removeReconcileCompleted();" style="cursor: pointer; font-size: 1.5em; color: red; margin-top: -10px;"></i>' +
	                    '</td>'+
	                '</tr>'
				);

				$('#objSubHQ_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                if($('#Doc_RVD_' + i).attr('data-role') != 'hqonly') {

                	if(doc_type == 'M') {
                		$('#objDRVD_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                        $('#objHQC_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                	} else {
                		$('#objDRVD_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                        $('#objHQC_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    					$('#objCAH_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                        $('#objHQL_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    					$('#objLBR_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                	}
		
				}

				if(doc_type == 'M') { $('#DocType_' + i).find('option[value="R"]').remove(); }
				if(doc_type == 'R') { $('#DocType_' + i).find('option[value="M"]').remove(); }

				// list push
				chooselist_lackdoc.push(parseInt(missing_getdoc[index]));					
			
				i++;
				
			});

			$('#expense_table_docmanagement tbody > tr').after(function() {
				$('.document_list').removeClass('animated fadeInDown').hide();
				
				if($('#expense_table_docmanagement tbody > tr').hasClass('row_empty'))
				   $('#expense_table_docmanagement tbody > tr.row_empty').remove();
				
			});	

			return true;
			
		}

		return false;
		
	}
	
}

function getNewDoctoChangeLackList(id) {
		
	if(confirm('ยืนยันการเปลี่ยนแปลงบันทึกข้อมูล')) {

		var missing_getdoc    = $('input[name$="lackdoc_fieldcode[]"]:checked').map(function() {return $(this).val();}).get();
		var missing_getdoctxt = $('input[name$="lackdoc_fieldcode[]"]:checked').map(function() {return $(this).attr('data-attr');}).get();
		
		if(missing_getdoc.length >= 1) {
			$('#DocList_' + id).val(missing_getdoc[0]);
			$('#DoclistText_' + id + ' > span').text(missing_getdoctxt[0]).css('color', '#008A00 !important').addClass('animated fadeIn');
		}

		$('.document_list').removeClass('animated fadeInDown').hide()

	}
	
}

$('#document_AcceptModal').on('click', function() {

	if(confirm('ยืนยันการบันทึกข้อมูล')) {

		var doc_id		   = $('#DocID').val();
		var is_ref		   = $('input[name="DocIsRef"]').val();
		var doc_borrower   = $('input[name="DocBorrowerName"]').val();

		var non_returndoc  = $('input[name$="DocNotReturn[]"]').map(function() {return $(this).val();}).get();
		var miss_id		   = $('input[name$="MissID[]"]').map(function() {return $(this).val();}).get();
		var doctype        = $('select[name$="DocTypes[]"]').map(function() {return $(this).val();}).get();
		var docstatus 	   = $('select[name$="DocStatus[]"]').map(function() {return $(this).val();}).get();
		var doc_list	   = $('input[name$="DocList[]"]').map(function() {return $(this).val();}).get();
		var doc_other      = $('input[name$="DocListOther[]"]').map(function() {return $(this).val();}).get();

		var doc_submithq   = $('input[name$="Doc_SubmitToHQ[]"]').map(function() {return $(this).val();}).get();
        var doc_hqreceived = $('input[name$="Doc_HQReceived[]"]').map(function() {return $(this).val();}).get();
        var doc_hqtoca     = $('input[name$="Doc_HQToCA[]"]').map(function() {return $(this).val();}).get();

        var doc_catohq     = $('input[name$="Doc_CAToHQ[]"]').map(function() {return $(this).val();}).get();
        var doc_hqtolb     = $('input[name$="Doc_HQToLB[]"]').map(function() {return $(this).val();}).get();

        var doc_lbreceived = $('input[name$="Doc_LBReceived[]"]').map(function() {return $(this).val();}).get();
		/*
        console.log([
			{
				'doc_id': doc_id,
     			'is_ref': is_ref,
     			'doc_borrower': doc_borrower,
     			'non_returndoc': non_returndoc,
     			'miss_id': miss_id,
     			'doctype': doctype,
     			'docstatus': docstatus,
     			'doc_list': doc_list,
     			'doc_other': doc_other,
     			'doc_submithq': doc_submithq,
     			'doc_hqreceived': doc_hqreceived,
     			'doc_hqtoca': doc_hqtoca,
     			'doc_catohq': doc_catohq,
     			'doc_hqtolb': doc_hqtolb,
     			'doc_lbreceived': doc_lbreceived		
			}			
        ]);
        */
				
		$.ajax({
        	url: pathFixed + 'management/setDocumentManagementForm?_=' + new Date().getTime(),
            type: 'POST',
			data: {
				MissID: miss_id,
				DocID: doc_id,
				DocBorrowerName: doc_borrower,
				DocIsRef: is_ref,
				DocTypes: doctype,
			    DocStatus: docstatus,
				NonReturn: non_returndoc,
				DocList: doc_list,
				DocOther: doc_other,
				Doc_SubmitToHQ: doc_submithq,
				Doc_HQReceived: doc_hqreceived,
				Doc_HQToCA: doc_hqtoca,
				Doc_CAToHQ: doc_catohq,
				Doc_HQToLB: doc_hqtolb,
				Doc_LBReceived: doc_lbreceived,   
				Doc_Mode: $('#LockDocTypes').val()
			},
            success:function(data) {
				
				var responsed = JSON.parse(data);
				
				if(responsed['status'] == 'true') {
					var not = $.Notify({ content: 'บันทึกข้อมูลสำเร็จ', style: { background: "green", color: "#FFFFFF" }, timeout: 10000 });
					not.close(7000);  
					} else {
						var not = $.Notify({ content: data['msg'], style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
					not.close(7000);  
				}
				
			},
            complete:function() {
					
					$.ajax({
                	url: pathFixed+'dataloads/getNumBadgeByType?_=' + new Date().getTime(),
                    type: 'POST',
					data: {
						relx: doc_id,
						refx: is_ref
					},
                    success:function(data) {
                    	
						var miss_ref 	= 'M' + is_ref;
						var return_ref	= 'R' + is_ref;
						var select_ref	= 'Sel' + is_ref;
					
                    	$('input[data-attr="'+ miss_ref +'"]').val(data['data'][0]['NumMissingDoc']);
						$('span[data-attr="'+ miss_ref +'"]').text(data['data'][0]['NumMissingDoc']);
						
						$('input[data-attr="' + return_ref +'"]').val(data['data'][0]['NumReturnDoc']);
			           	$('span[data-attr="' + return_ref +'"]').text(data['data'][0]['NumReturnDoc']);

						$('select[data-attr="'+ select_ref +'"]').find('option[value="' + data['data'][0]['CompletionDoc'] +'"]').prop('selected', true);
			          
					},
                    complete:function() {
						 $('#myModal').modal('hide');
                    },
                    cache: false,
                    timeout: 5000,
                    statusCode: {
                    	404: function() {
                        	alert('page not found.');
                        },
                        407: function() {
                        	console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
                        },
                        500: function() {
                          	console.log('internal server error.');
                        }
					}

				});
			
            },
            cache: false,
            timeout: 5000,
            statusCode: {
            	404: function() {
                	alert('page not found.');
                },
                407: function() {
                	console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
                },
                500: function() {
                  	console.log('internal server error.');
                }
			}
		});	
        
	}
	
});

function removeReconcileCompleted() {
	$('body').on('click', '#expense_table_docmanagement .reconcile_del', function() {
        var tr_length = $('#expense_table_docmanagement tr.item_docmange').length;											
        if(parseInt(tr_length) > 0) {
            $(this).parent().remove();
        } else {
         											            
        }
    });
}

function GenDateValidator(id, bundled) {
	var str_date;
    var objDate = new Date();
    str_date = ('0' + objDate.getDate()).slice(-2) + '/' + ('0' + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
    var elements =  $('#' + id).is(':checked');
    if(elements) {
        $('#' + bundled).val(str_date);
    } else {
        $('#' + bundled).val('');
    }
}

function setModalCAReturnDateByText(id, bundled) {
	var str_date;
	var objDate = new Date();
	str_date = ('0' + objDate.getDate()).slice(-2) + '/' + ('0' + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
	var elements =  $('#' + id).is(':checked');
	if(elements) {
		$('#' + bundled).text(str_date.substr(0, 5));
	} else {
		$('#' + bundled).text('');
	}
								
}

function in_array(needle, haystack, argStrict) {
	
	  var key = '', strict = !! argStrict;

	  if (strict) {
	     for (key in haystack) {
		     if (haystack[key] === needle) {
		         return true;
		     }
		 }
	  } else {
		 for (key in haystack) {
			  if (haystack[key] == needle) {
			  	 return true;
			  }
		  }
	  }
	
	  return false;

}

</script>
