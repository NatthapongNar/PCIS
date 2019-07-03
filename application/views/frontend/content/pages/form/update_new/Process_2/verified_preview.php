<style>

	.ui-multiselect {
		height: 34px;
		border: 1px solid #D1D1D1;
		background: #FFF;
		max-width: 300px;
	}

    .no-margin-top { margin-top: -5px; }
    .padding3 { padding: 3px; }
    .padding5 { padding: 5px; }
    .padding10 { padding: 10px; }
    
    .metro .input-control.select, .metro .input-control.textarea {
	    display: inline-block;
	    cursor: pointer;
	    position: relative;
	    max-width: 90% !important;
	}
    
    .case_history { height: 32px; width: 150px; text-align: center; padding: 5px; color: white; }
     @media screen and (-webkit-min-device-pixel-ratio:0) { 
		.cb-marginFixedChrome {
			margin-top: 2px !important;
		}
		
		.cm-SelectFix { margin-left: -50px !important; }
		
		.budgetFixed { 
			margin-left: -38px !important; 
			margin-top: 5px !important;
		}
		
		.budgetAmountFixed {
			margin-left: -23px !important; 
			margin-top: -3px !important;
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
	
	.text-selectred { color: red; }
	.tooltip-top { text-align: center !important;}
	
	.form_container table td { padding-top: 8px !important;  }
	
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

<div class="text_float nonprint"><h2>Preview</h2></div>

<div class="container" data-region="<?php echo !empty($getCustInfo['Region']) ? trim($getCustInfo['Region']): ''; ?>">
	<?php 
		// Load Library
		$this->load->helper('form');
		$this->load->library('effective'); 
		
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
			</header>
			<section class="span12">
			
				<?php $attributes = array('id' => 'verification_forms'); ?>
    			<?php echo form_open('management/setVerificationInitialyzeForm', $attributes); ?>
				
				<fieldset style="min-width: 1050px;">

					<header class="span2 nonprint"><h6>Personal Information</h6></header>
		
					<!-- PANEL -->
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
								<div class="span6">
								
								</div>
							
							</div>
			
						</div>
					</div>
					<!-- /PANEL  -->
					
					<?php 
					
					$this->load->model('dbmodel');
					$loantypes	= $this->dbmodel->CIQuery("SELECT * FROM ProductLoanType WHERE IsActive = 'A'");
				
					$status_draft 	 	= $this->config->item('DecisionStutus');
					$cancel_onbefore 	= $this->config->item('CancelBefore');
					$full_cancelstatus	= $this->config->item('FullCancel');
					
					?>
   
					<input type="hidden" name="DocID" id="DocID" value="<?php echo !empty($getCustInfo['DocID']) ? $getCustInfo['DocID']:""; ?>">
					<input type="hidden" name="BranchCode" id="BranchCode" value="<?php echo $session_data['branchcode']; ?>">
					<div class="span12" >
				        <div class="input-control select">
				            <label id="label_onbehalf" class="span4">On Behalf Of</label>
				            <?php  $behalf = !empty($getVerify['OnBehalf']) ? $getVerify['OnBehalf']:0; ?>
				            <div class="input-control radio" style="margin-left: 0px;">
				                <label>
				                    <input type="radio" name="on_helf" value="1" <?php if($behalf == 1) echo 'checked="checked"'; ?> disabled="disabled">
				                    <span class="check"></span> บุคคล
				                </label>
				            </div>
				            <div class="input-control radio" style="margin-left: 29px;">
				                <label>
				                    <input type="radio" name="on_helf" value="2" <?php if($behalf == 2) echo 'checked="checked"'; ?> disabled="disabled">
				                    <span class="check"></span> นิติบุคคล
				                </label>
				            </div>
				        </div>
				        
				    </div>				
					<div id="parent_identify" class="span12">
				        <label id="label_idcard" class="span4"><?php if($behalf == 2) { echo "Business Registration Number"; } else { echo "ID Card"; } ?> <span class="text-warning"><small>(เฉพาะผู้กู้หลัก)</small></span></label>
				        <div class="input-control text span4" style="margin-left: 20px;">
				       		<input value="<?php echo !empty($getVerify['ID_Card']) ? $getVerify['ID_Card']:""; ?>" class="size5" disabled="disabled">
				        </div>
				    </div>
				      
				    <div class="span12" style="margin-top: 10px;">
				     	<?php $product_programs = !empty($getVerify['ProductCode']) ? $getVerify['ProductCode'] . '-' . $getVerify['ProductName']:""; ?>
				        <div class="input-control">
				            <label class="span4">Product Program</label>				          
				            <div class="input-control text span5" style="margin-left: 20px;" class="tooltip-top" data-tooltip="<?php echo !empty($product_programs) ? $product_programs:""; ?>">
				       			<input value="<?php echo !empty($product_programs) ? $product_programs:""; ?>" class="size5" disabled="disabled">
				        	</div>	
				        	<div class="input-control select span3">
					        	<?php $prd_loantype  = !empty($getVerify['ProductLoanTypeID']) ? $getVerify['ProductLoanTypeID']:""; ?>
					        	<?php $prd_banklist  = !empty($getVerify['Bank']) ? $getVerify['Bank']:""; ?>
				            	<input id="bank_bundle" name="bank_bundle" type="hidden" value="<?php echo !empty($prd_banklist) ? $prd_banklist:""; ?>">
					        	<?php $prd_style 	 = ''; 
					        	
					        		if(!empty($getVerify['ProductType'])) {
					        			if($getVerify['ProductType'] === 'Clean Loan'):
					        				$prd_style = ' display: none';
					        			else:
					        				$prd_style = '';
					        			endif;
					        		}
					        	
					        	?>
					            <select id="loantypes" name="loantypes" class="span2" style="margin-left: 5px; max-width: 125px; background: #EBEBE4; <?php echo $prd_style; ?>" disabled>
					            	<option value="" <?php if($prd_loantype == "") echo 'selected="selected"'; ?>></option>
					            	<?php 
					            	
					            	foreach($loantypes['data'] as $index => $value) {
					            	
					            		if($prd_loantype == $loantypes['data'][$index]['PrdLoanTypeID']) $selected = 'selected="selected"';
					            		else $selected = '';
					            		
					            		echo '<option value="'.$loantypes['data'][$index]['PrdLoanTypeID'].'" '.$selected.'>'.$loantypes['data'][$index]['prdLoanType'].'</option>';
					            	
					            	}
					            	
					            	
					            	?>
					            </select>
					            <select class="span1" style="margin-left: 5px; max-width: 80px; background: #EBEBE4; <?php echo empty($prd_banklist) ? 'display: none;':''; ?>" disabled>
					             	<option value="<?php echo $prd_banklist; ?>" selected="selected"><?php echo $prd_banklist; ?></option>
					            </select>
					        </div>			        	
				        </div>
				        
				    </div>
				    
				    <div class="span12">
				        <div class="input-control">
				            <label class="span4">Insurance <span class="text-warning"><small>(กรณีลูกค้าสมัคร คลิก)</small></span></label>
				            <?php $mrta  = !empty($getVerify['MRTA']) ? $getVerify['MRTA']:""; ?>
				            <?php $cashy = !empty($getVerify['Cashy']) ? $getVerify['Cashy']:""; ?>
				            <div class="input-control checkbox" style="margin-left: 0px;">
				                <label>
				                    <input type="checkbox" name="mrta" value="1" <?php if($mrta == 1) echo 'checked="checked"'; ?> disabled="disabled">
				                    <span class="check"></span> MRTA 
				                </label>
				            </div>
				             <div class="input-control checkbox" style="margin-left: 29px;">
				                <label>
				                    <input type="checkbox" name="cashy" value="1" <?php if($cashy == 1) echo 'checked="checked"'; ?> disabled="disabled">
				                    <span class="check"></span> Cashy
				                </label>
				            </div>
				        </div>
				    </div>

				    <header class="span12" style="margin-top: 10px;">
				    	<h6>NCB Verification</h6>
				    	<section style="position: absolute; min-width: 1045px; margin-top: -30px;">				    		
				    		<span id="NCBConsentLogs" class="tooltip-top nonprint" data-tooltip="Reconcile NCB History" style="float:right; margin-right: 3px; cursor: pointer; font-size: 1.5em;">
				    			<i class="icon-history on-right"></i>
				    		</span>				    	
				    	</section>	
				    </header>
				    
				    <section class="form_container span12" style="margin-top: -10px;">
				    	<input id="flagno" name="flagno" type="hidden" value="<?php echo $getFlag; ?>">
	                    <table id="expense_table_ncbrefer" style="min-width: 1050px;">
	                        <thead>
	                        	<tr>
		                            <th align="left" width="130px;">TYPE</th>
		                            <th align="left">NAME - SURNAME</th>
		                            <th align="left">NCB</th>
		                            <th align="left">CHECK NCB</th>
		                            <th align="left">LB <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
		                            <th align="left"><i class="fa fa-inbox on-left"></i> HO RECEIVED</th>
		                            <th align="left">HO <i class="fa fa-arrow-right on-right on-left"></i> OPER</th>
		                            <th align="left"><i class="fa fa-arrow-left on-left"></i> OPER RETURN</th>
		                            <th>&nbsp;&nbsp;&nbsp;</th>
		                        </tr>
	                        </thead>
	                        <tbody>
	                        	<?php 
	                        	                        	
	                        	$types 	    = $this->dbmodel->CIQuery("SELECT * FROM MasterBorrowerType WHERE IsActive = 'A'");	               
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
	                        		
	                        		switch ($result['data'][0]['CheckNCB']) {
	                        			case '1':
	                        				$ncbchecker = 'ผ่าน';
	                        				break;
	                        			case '3':
	                        				$ncbchecker = 'Deviate';
	                        				break;
	                        			case '2':
	                        			case '0':
	                        			case '9':
	                        				$ncbchecker = 'ไม่ผ่าน';
	                        				break;
	                        			
	                        		}
	                        		
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
			                            <td><div style=\"height: 30px;\">ผู้กู้หลัก</div></td>
			                            <td><div style=\"height: 30px;\">".$this->effective->get_chartypes($char_mode, $result['data'][0]['MainLoanName'])."</div></td>
			                            <td><div style=\"height: 30px;\">$ncbchecker</div></td>
			                            <td><div style=\"height: 30px;\">$NCBDate</div></td>
			                            <td><div style=\"height: 30px;\">$LBSentDate</div></td>
			                            <td><div style=\"height: 30px;\">$HQGetDate</div></td>
			                            <td><div style=\"height: 30px;\">$HQSentToOp</div></td>
			                            <td></td>
			                            <td class=\"del\" style=\"width: 1.5em;\">&nbsp;</td>
		                        	</tr>";
	                        			
	                        			
	                        		} else {
	                        			
	                        		echo "
									<tr class=\"item_ncbrefer\" table-attr=\"1\">
			                            <td colspan=\"9\" align=\"center\" style=\"color: gray;\">ไม่พบข้อมูล</td>                  
		                        	</tr>";
	                        			
	                        		}
	     
								} else {
									
									$i = 1;							
									foreach($NCBConsent as $index => $value) {

										$Doc_ID		  = $getCustInfo['DocID'];
										$BorrowerName = !empty($NCBConsent[$index]['BorrowerName']) ? $NCBConsent[$index]['BorrowerName']:"";
			
										$ncb_type 	= "";
										$ncb_type_1 = "";
										$ncb_type_2 = "";
										$ncb_type_3 = "";
										$ncb_type_4 = "";
										
									
										if($NCBConsent[$index]['BorrowerType'] === 101) { $ncb_type_1 = $this->effective->get_chartypes($char_mode, $types['data'][$index]['BorrowerDesc']); } 
										else if($NCBConsent[$index]['BorrowerType'] === 102) { $ncb_type_2 = $this->effective->get_chartypes($char_mode, $types['data'][$index]['BorrowerDesc']);} 
										else if($NCBConsent[$index]['BorrowerType'] === 103) { $ncb_type_3 = $this->effective->get_chartypes($char_mode, $types['data'][$index]['BorrowerDesc']); } 
										else if($NCBConsent[$index]['BorrowerType'] === 104) { $ncb_type_4 = $this->effective->get_chartypes($char_mode, $types['data'][$index]['BorrowerDesc']); } 
										else { $ncb_type   = ''; }
								
										foreach ($types['data'] as $indexed => $values) {
											
											if($NCBConsent[$index]['BorrowerType'] == $types['data'][$indexed]['BorrowerType']) {
												$ncb_type = $this->effective->get_chartypes($char_mode, $types['data'][$indexed]['BorrowerDesc']);
											}
												
										}

										
										
										$ncb   = '';
										$ncb_1 = '';
										$ncb_2 = '';
										$ncb_3 = '';
										
										switch ($NCBConsent[$index]['NCBCheck']) {
											case '1':
												$ncbchecker = 'ผ่าน';
												break;
											case '3':
												$ncbchecker = 'Deviate';
												break;
											case '2':
											case '0':
											case '9':
												$ncbchecker = 'ไม่ผ่าน';
												break;
										
										}
					
										
										$NCBIsRef	= !empty($NCBConsent[$index]['IsRef']) ? $NCBConsent[$index]['IsRef']:"";
										$NCBDate	= !empty($NCBConsent[$index]['NCBCheckDate']) ? $NCBConsent[$index]['NCBCheckDate']:"";
										$NCBSent	= !empty($NCBConsent[$index]['SubmitToHQ']) ? $NCBConsent[$index]['SubmitToHQ']:"";
										$NCBHQGet	= !empty($NCBConsent[$index]['HQReceivedFromLB']) ? $NCBConsent[$index]['HQReceivedFromLB']:"";
										$NCBTOOPER  = !empty($NCBConsent[$index]['HQSubmitToOper']) ? $NCBConsent[$index]['HQSubmitToOper']:"";
										$NCBReturn  = !empty($NCBConsent[$index]['OperReturnDate']) ? $NCBConsent[$index]['OperReturnDate']:"";
										$NCBReturnLog = !empty($NCBConsent[$index]['OperReturnDateLog']) ? $NCBConsent[$index]['OperReturnDateLog']:"";
										
										$NCBChecked = !empty($NCBDate) ? 'checked="checked"':"";
										$LBHChecked	= !empty($NCBSent) ? 'checked="checked"':"";
										$HQRChecked = !empty($NCBHQGet) ? 'checked="checked"':"";
										$HQOChecked = !empty($NCBTOOPER) ? 'checked="checked"':"";
										$ORTChecked = !empty($NCBReturn) ? 'checked="checked"':"";		
																									
										if(!$session_data['branchcode'] == '000') {
											$role_only 	= 'data-role="hqonly"';
											$role_block = 'disabled="disabled"';
										} else {
											$role_only  = '';
											$role_block = '';
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
										
										echo "
										<tr class=\"item_ncbrefer\" table-attr=\"$i\">
				                            <td><div class=\"input-control text\"><input value=\"$ncb_type\" disabled></div></td>
				                            <td><div class=\"input-control text\" class=\"tooltip-top\" data-tooltip=\"$BorrowerName\"><input value=\"$BorrowerName\" class=\"size3\" disabled></div></td>
				                            <td><div class=\"input-control text\"><input value=\"$ncbchecker\" disabled></div></td>
				                            <td><div class=\"input-control text\"><input value=\"$NCBDate\" disabled></div></td>
				                            <td><div class=\"input-control text\"><input value=\"$NCBSent\" disabled></div></td>
				                            <td><div class=\"input-control text\"><input value=\"$NCBHQGet\" disabled></div></td>
				                            <td><div class=\"input-control text\"><input value=\"$NCBTOOPER\" disabled></div></td>
				                            <td><div class=\"input-control text\"><input value=\"$NCBReturnLog\" disabled></div></td>
				                            <td><div class=\"input-control text\"></div></td>
			                        	</tr>";
										
										$i++;
										
									}
																
								}
								
	                        		
	                        ?>
	                        	
		                      
	                        </tbody>
	                    </table>
 						 
                	</section>
                	
                	<div class="span12" style="margin-top: 10px;">
				        <div id="resource_parent" class="input-control textarea">
				            <label class="span4">NCB Comment</label>
				            <div class="input-control textarea span4" style="margin-left: 20px;">
				            	<textarea rows="2" cols="2" class="size5" disabled><?php echo !empty($getVerify['Comments']) ? $getVerify['Comments']:""; ?></textarea>				            	
				            </div>	
				            <span id="objFixed" class="none nonprint" style="margin-left: 90px; font-size: 1.3em;" data-hint="ขยายข้อความ" data-hint-position="top">
                         		<i class="icon-menu fg-lightBlue" style="margin-top: 2em;"></i>
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
                	
                	<header class="span12" style="margin-top: 10px;"><h6>RM ON HAND</h6></header>
                	<div class="span12">
                	
                		<?php 
		            	
		            		$rmprocess = !empty($getVerify['RMProcess']) ? $getVerify['RMProcess']:"";
		            		if($rmprocess == "CANCELBYRM") { $process_selected = 'ยกเลิก โดย RM'; } 
		            		else if($rmprocess == "CANCELBYCUS") { $process_selected = 'ยกเลิก โดย ลูกค้า'; }
		            		else if($rmprocess == "CANCELBYCA") { $process_selected = 'ยกเลิก โดย CA'; } 
		            		else {
		            			$process_selected = $rmprocess;
		            		}
		            		
		            		$rmprocess_date = !empty($getVerify['RMProcessDate']) ? '#' . substr($getVerify['RMProcessDate'], 0, 5):""; 
		            	
		            	?>
                		
				        <div id="parent_rmprocess" class="input-control select">
				            <label id="label_rmprocess" class="span4">RM Process</label>
				            <div class="input-control text span4" style="margin-left: 20px;">
				            	<input value="<?php echo  $rmprocess_date . ' ' . $process_selected; ?>" class="size5" disabled>
				            </div>	
				            			            
				            <div class="toolbar fg-black nonprint" class="place-left">
					            <?php if(!empty($RmReason['data'][0]['DocID']) || !empty($CustReason['data'][0]['DocID'])) { ?>
				            	<span id="RmProcessReasonLogs" class="tooltip-top show-pop-list" data-tooltip="Cancel Reason History (Before & After Process)" data-placement="right" style="margin-left: 90px;">
				            		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: -5px;"></i>
				            	</span>	
				            	<?php } ?>	
				            </div>			            
				        </div>
				        
			    	</div>
			    	
			    	<div class="span12" style="margin-top: -28px;">
			    	<label class="span4">&nbsp;</label>
			    	<div class="span6 nonprint">
			    		<div class="listview-outlook size5" data-role="listview">
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
				   	 
				   	<div class="span12" style="display: none;">
				   		<?php $rmprocessreason = !empty($getVerify['RMProcessReason']) ? $getVerify['RMProcessReason']:""; ?>
				   		<div id="parent_rmprocess_reason" class="input-control select">
				   			<label id="label_rmprocess_reason" class="span4">Choose Reason</label>
				   							   			
				   			<div class="span6" style="border-bottom: 1px solid #D1D1D1; padding: 3px; height: 30px;">
				   				<?php echo !empty($getVerify['ProcessReason']) ? $getVerify['ProcessReason']:""; ?>
				            </div>	
				   		</div>
				   </div>
				   
				   <?php
				   	
					   $app2ca_history = $this->dbmodel->CIQuery("
							SELECT DocID, CONVERT(nvarchar(10), A2CA_PlanDate , 120) AS A2CA_PlanDate,
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
				   
				   <div class="span12">
		    			<label id="label_plan_a2ca" class="span4">A2CA Plan Date</label>
		    		 	<div class="input-control text span5" style="margin-left: 20px;">			             
			            	<input type="text" value="<?php echo !empty($getVerify['AppToCAPlanDate']) ? $getVerify['AppToCAPlanDate']:''; ?>" disabled="disabled" <?php echo $plan_a2ca_locked; ?>>	        
			            	<?php if(!empty($getVerify['AppToCAPlanDate'])) { ?>
			            	<span class="label">DIFF : <?php echo !empty($diff_date) ? $diff_date:'0'; ?> Day</span>	    
			         		<?php } ?>
			         		<?php if(!empty($app2ca_history['data'][0]['DocID'])) { ?>							
			            	<span id="PlanA2CAReasonLogs" class="tooltip-top show-pop-list" data-tooltip="Plan A2CA History" data-placement="right" style="margin-top: 0px;" <?php if(empty($app2ca_history['data'][0]['DocID'])) echo 'hide'; ?>>
			            		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
			            	</span>	
			            	<?php } ?>
			         	</div>			         	
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
				   
				   
				   <div class="span12" style="clear: both; margin-top: 0px;">
				    	<div class="span4" style="margin-right: 20px;">
				    		<label class="span4">
				    			Re-Activation
				    			<span class="nonprint" style="padding-left: 0.1em; font-size: 1em;"><i class="fa fa-question-circle fg-lightBlue" data-hint="Re-Activation|การนำเคสที่ยังไม่เข้าระบบกลับมาทำใหม่" data-hint-position="top"></i></span>
				    		</label>
				        </div>
				        <div id="objreactivate" class="input-control text span5" style="border: 1px solid #D1D1D1; background-color: #EBEBE4; padding: 5px 5px; height: 34px; min-height: 34px; display: block; height: auto;">
				        	
				        	<?php 
				
				        	if(empty($reactivate_list['data'][0]['DocID'])): 
				        		echo "&nbsp;";
				        	
				        	else:
				        	
				        		if(!empty($reactivate_list['data'][0]['ReActivatedReason'])):
				        		
					        		$reactivate_pieces = explode(',', $reactivate_list['data'][0]['ReActivatedReason']);
					        		if(!empty($reactivate_pieces[0])):
					        			$where_reactivate 	= "'".implode("','", $reactivate_pieces)."'";
					        		else:
					        			$where_reactivate   = "";
					        		endif;
					        		
					        		
					        		
					        		if(!empty($where_reactivate)):
					        		
					        			$reactivate_reason =  $this->dbmodel->CIQuery("SELECT * FROM MasterRevisitReason WHERE RevisitID in ($where_reactivate)");					        		
					        			foreach ($reactivate_reason['data'] as $index => $values) {
					        			
					        				$name	= !empty($reactivate_reason['data'][$index]['RevisitReason']) ? $this->effective->get_chartypes($char_mode, $reactivate_reason['data'][$index]['RevisitReason']):'';					        			
					        				echo $reactivat_num.'. '. substr($this->effective->StandartDateRollback($reactivate_list['data'][0]['ReActivateDateConv']), 0, 5).' '.$name.'<br/>';
					        								        			
					        			}
					        
					        		endif;
					        		
				        		else:
				        		
				        		endif;
								        	
				        	endif;
				        	
				        	
				        	?>
				        	
				        </div>
				       
						<div class="toolbar fg-black" class="place-left">
							<?php if(!empty($reactivate_list['data'][1]['DocID'])) {  ?>
			            	<span id="ReActivatedReasonLogs" class="tooltip-top show-pop-list" data-tooltip="Re-Activated Reason History" data-placement="right" style="margin-top: 0px; margin-left: 10px;">
			            		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: -5px;"></i>
			            	</span>	
			            	<?php } ?>			       
			            </div>		
				   </div>
				   
				   <div id="reactivate_parent_reason" style="display: none;">
				   		<?php 
				
				        	if(empty($reactivate_list['data'][0]['DocID'])): 
				        		echo "&nbsp;";
				        	
				        	else:
				        	
				        		
					        	foreach ($reactivate_list['data'] as $k => $v) {
					        		
					        		if($k == 0) {
					        			continue;
					        			
					        		} else {
					        					
					        			--$reactivat_num;
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
							        				echo $reactivat_num . '. ' . substr($this->effective->StandartDateRollback($reactivate_list['data'][$k]['ReActivateDateConv']), 0, 5).' ' . $name . '<br/>';
							        			
							        			}
							   
						        			endif;
					        			
					        			else:
					        			 
					        			endif;
					        			
					        		}
					     
					        	}
				        	        	
				        	endif;
				        	
				        	
				        ?>
				   </div>
				   	
				   <div class="span12">
				   		<div id="resource_parent" class="input-control textarea">
				            <label class="span4">Action Note</label>
				            <div class="input-control textarea span4" onselectstart="return false" style="margin-left: 20px;">
				            	<textarea rows="2" cols="2" class="size5" oncopy="return false;" onselectstart="return false;" disabled><?php echo !empty($ActionLogs[0]['ActionNote']) ? $this->effective->get_chartypes($char_mode, $ActionLogs[0]['ActionNote']):''; ?></textarea>
				            </div>	
				        </div>
				   </div>
   
				   <div class="span12">
				   <label class="span4">&nbsp;</label>
			       <div class="span6 nonprint" style="margin-top: -18px;">
			    		<div class="listview-outlook size5" data-role="listview">
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
													
													if($index == 0):
														continue;
														
													else:

														$name	= !empty($data_split[$index]['ActionName']) ? $this->effective->get_chartypes($char_mode, $data_split[$index]['ActionName']) : $data_split[$index]['ActionNoteBy'];
														
														echo '
	    													<a href="#" class="list" style="text-decoration: none;">
							    							<div class="list-content">
																<span class="list-title" style="font-size: 0.7em;"></span>
																<span class="list-subtitle">'.$data_split[$index]['ActionNoteDate'].' '.$data_split[$index]['ActionDateTime'].' <span style="font-weight: normal">Update By : '.$name.'</span></span>
																<span style="font-size: 0.8em; line-height: 15px;">Note : '.$this->effective->get_chartypes($char_mode, $data_split[$index]['ActionNote']).'</span>
															</div>
	               											</a>';
													
													endif;
											
												}
												
											}
									
										?>									
				   					
								</div>
							</div>
				    	</div>	    
				    </div>
				   </div>
				   
				   <?php 
				       	$def_progress = !empty($getDefend['data'][0]['ProgressNewLabel']) ? $getDefend['data'][0]['ProgressNewLabel']:'';
				    	$def_process = !empty($getDefend['data'][0]['DefendProcess']) ? $getDefend['data'][0]['DefendProcess']:'';
				    	$def_date 	 = !empty($getDefend['data'][0]['AssignmentDate']) ? $this->effective->StandartDateRollback(substr($getDefend['data'][0]['AssignmentDate'], 0, 10)):'';
				    	$def_status  = !empty($def_process) ? 'Completed':'';
						    	
				    ?>
				    
				    <div class="span12">				    	
		                <div class="input-control">
		                   <label class="span4">Defend</label>
		                   <div id="defend_enable" class="input-control checkbox">		                   	
		                    	<label>
 									<input type="checkbox" value="Y" <?php echo ($def_status == 'Completed') ? 'checked="checked"':''; ?> disabled="disabled"> 									
	            		    		<span class="check"></span>
	            		    	</label>
		                   </div>                
		                   <div id="parent_defend_date" class="input-control text marginLeft5" style="max-width: 305px;">
			                    <input id="defend_date_disbled" type="text" value="<?php echo $def_date . ' - ' . $def_progress; ?>" disabled="disabled">
		                   </div>		
		                   <span class="toolbar fg-black" style="position: absolute; margin-top: 14px; margin-left: 5px; min-width: 300px;">
		                   		<i id="defend_icon_history" class="icon-history on-right nonprint <?php echo ($def_status == 'Completed') ? '':'hide'; ?> " style="font-size: 1.2em; cursor: pointer;" data-hint-position="top" data-hint="Defend List|ดูประวัติรายการหัวข้อของปัญหาต่างๆ ที่เลือก เพื่อชี้แจ้งประเด็นปัญหาต่างที่เกิดขึ้นภายในเคส"></i>
		                   </span>             					           
		                </div>
		            </div>
		           
		           <?php $doc_id = !empty($getCustInfo['DocID']) ? $getCustInfo['DocID']:!empty($_GET['rel']) ? $_GET['rel']:''; ?>
               	   <?php $ref_verify = ($def_progress !== 'Draft') ? '?ref=' . $doc_id  : '';?>
			     <div id="objDefendbox" class="span12" style="margin-top: 20px; display: none; ">
	                  <label class="span4">&nbsp;</label>
	                  <div id="objDefendReasonPreview" class="span7" style="min-width: 500px; border: 1px solid #D1D1D1; margin-top: -15px; margin-left: 20px; padding: 5px; display: block;">
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
	
	             <?php 
		            
		            echo "
					<script>
		
						$(function() {
		
							var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + \"//\" + window.location.host;
						    var pathFixed = window.location.protocol + \"//\" + window.location.host;
						    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += \"/\"; }
						    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += \"/\"; }
						    var query  = getQueryParams(document.location.search);
					
							$.ajax({
					             url: pathFixed+'dataloads/getDefendList?_=' + new Date().getTime(),
					             type: \"POST\",
					             data: {
					                 relx: query['rel'],
					                 lnox: $('#defend_no').val()
					             },
					             success:function(data) {
					                        	
					            	 if(data['data'][0]['DocID'] == '') {
					            		 $('#objDefendReason').append('<p>ไม่พบข้อมูล</p>');
					            		 
					            	 } else {
					            
					            		 var objects	= [];
					            		 for(var indexed in data['header']) {
					            			 objects.push({ 
					            				 DocID: data['header'][indexed].DocID, 
					            				 DefendRef: data['header'][indexed].DefendRef, 
					            				 DefendBy: data['header'][indexed].DefendBy, 
					            				 DefendDate: data['header'][indexed].DefendDate, 
					            				 DataContent: '' 
					            			 });
					            	
					            		 }
					            		 
					            		 if(objects && objects.length > 0) {
					            			
					            			 $.each(data['data'], function(index, value) {
					            				 var pointer = getIndexByAttribute(objects, 'DefendRef', value.DefendRef);
					            				 if(value['DefendOther'] && value['DefendOther'] != '') {
					            					 objects[pointer].DataContent += value['DefendReason'] + ' เรื่อง' + value['DefendOther'] + ', ';
						            			 } else {
						            				 objects[pointer].DataContent += value['DefendReason'] + ', ';
						            			 }
					            			 });
					            			 
											 var runno = 1;
					            			 var note_text = '';
					            			 for(var indexed in objects) {
					            				 
					            				 var str = objects[indexed].DataContent;
					            				 note_text += 
					            				 '<tr>' +
					            				 	'<td class=\"paddingBottom10\">' + runno + '</td>' +            				 	
					            				 	'<td class=\"paddingBottom10\">' + moment(objects[indexed].DefendDate).format('DD/MM/YYYY (HH:mm)') + '</td>' +
					            				 	'<td class=\"paddingBottom10\">' + objects[indexed].DefendBy + '</td>' +
					            				 	'<td class=\"paddingBottom10 paddingLeft5\" style=\"text-align: left;\">รอบที่ ' + objects[indexed].DefendRef + ': ' + str.substring(0, str.length - 2) + '</td>' +
					            				 '</tr>';
					            	             runno++;
					                		 }
						        			 
						        			 $('#objDefendReason').find('table > tbody').html(note_text);
						        			 $('#objDefendReason').find('table > tbody').css({'font-size': '0.8em', 'text-align': 'left' });
					            				            		 
					            		 } else { note_text = '<tr><td rowspan=\"4\">ไม่พบข้อมูล</td></tr>'; }
					
					            	 }
					            						            	 
					            	 function getIndexByAttribute(array, attr, value) {
					            		 for(var i = 0; i < array.length; i += 1) {
						            		 if(array[i][attr] === value) {
						            			 return i;
						            		 }
					            		 }            		 
					            		 return -1;
					            	}
					            	 
					             },
					             complete: function() {            	 
					            	 $('#defenseByRM').attr('disabled', 'disabled');
					            	 $('#defenseBySFE').attr('disabled', 'disabled');
					            	 $('#defend_process').attr('disabled', 'disabled').css('background', '#eee'); 
					            	 
					             },
					             cache: true,
					             timeout: 5000					             
					         });
				
						});
		
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
		            
		            $objDoc_id = !empty($getCustInfo['DocID']) ? $getCustInfo['DocID']:'';
		            $result_setretrieve = $this->dbmodel->CIQuery("
	            		SELECT Retrieve_TransactionLog.EmployeeCode, FullNameTh,
						CONVERT(nvarchar(10), EventDate , 120) AS EventDate,
						SUBSTRING(CONVERT(nvarchar(19), EventTime, 120), 11, 10) AS EventTime, RetrieveReason
						FROM Retrieve_TransactionLog
						INNER JOIN MasterRetrieveReason
						ON Retrieve_TransactionLog.RetrieveCode = MasterRetrieveReason.RetrieveCode
						INNER JOIN LendingEmp
						ON LendingEmp.EmployeeCode = Retrieve_TransactionLog.EmployeeCode
	            		WHERE RetrieveToNewDoc = '$objDoc_id'
	            		ORDER BY EventDate DESC, EventTime DESC
	            	");
		             
		            
		            ?>
		            
		           <div class="span12 marginBottomEasing20 marginTop10">
                    	<label class="span4" >
                    		Retrieve
                    		<span class="nonprint" style="padding-left: 0.1em; font-size: 1em;"><i class="fa fa-question-circle fg-lightBlue" data-hint="Retrieve|การนำเคสกลับมาทำใหม่" data-hint-position="top"></i></span>
                    	</label>                      	  
                    	<div class="input-control text span4" style="margin-left: 20px;">
                    		<input value="<?php echo !empty($result_setretrieve['data'][0]['RetrieveReason']) ? $this->effective->get_chartypes($char_mode, $result_setretrieve['data'][0]['RetrieveReason']):""; ?>" class="size5" style=" max-width: 340px;" disabled>
                    		
                    	</div>        
                    	<div class="input-control text size2" style="margin-left: 44px;">
                    		<input value="<?php echo !empty($result_setretrieve['data'][0]['EventDate']) ? $this->effective->StandartDateRollback($result_setretrieve['data'][0]['EventDate']):"" ?>" style="max-width: 115px;" disabled>
                    	</div>
				        <span id="retrieve_tooltip" class="toolbar fg-black nonprint" class="place-left" style="position: absolute; margin-left: -20px;">
				        	<?php if(!empty($result_setretrieve['data'][1]['RetrieveReason'])) { ?>
				        	<span id="retrieve_tooltip" class="tooltip-top show-pop-list" data-tooltip="Retrieve Reason History" data-placement="top">
				        		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
				        	</span>				    
				       		<?php } ?>				    
				        </span>          	
                   </div>
                   
                   <div id="retrieve_contents" style="display: none;">
                   <?php 
               
                   		if(!empty($result_setretrieve['data'][0]['RetrieveReason'])) {
                   			
                   			foreach($result_setretrieve['data'] as $index => $value):
                   				if($index == 0):
                   					continue;
                   				else:
                   					$retrieve_actor	= $this->effective->get_chartypes($char_mode, $result_setretrieve['data'][$index]['RetrieveReason']) . ' (' . $this->effective->get_chartypes($char_mode, $result_setretrieve['data'][$index]['FullNameTh']) . ')';
                   					echo '#'.substr($this->effective->StandartDateRollback($result_setretrieve['data'][$index]['EventDate']), 0, 5).' '. $retrieve_actor .'<br/>';
                   				endif;                   				
                   			endforeach;
                   		                   			
                   		} else { echo 'ไม่พบข้อมูล'; }
                                   		
                   ?>
                   </div>

				   <header class="span12" style="margin-top: 10px;">
				    	<h6>Document Flow</h6>
				    	<section style="position: absolute; min-width: 1045px; margin-top: -30px;">				    		
				    		<span class="tooltip-top nonprint" data-tooltip="Reconcile Document History" style="float:right; margin-right: 3px; cursor: pointer; font-size: 1.5em;">
				    			<i id="RelationLogs" class="icon-history on-right" ></i>
				    		</span>				    						    		
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
											$CAReturnsLog = !empty($DocFlow[$index]['CAReturnDateLog']) ? $DocFlow[$index]['CAReturnDateLog']:"";
											$IsRef		  = $DocFlow[$index]['IsRef'];
											
											$LBSChecked = !empty($SubmitHQ) ? 'checked="checked"':"";
											$HQHChecked	= !empty($ReceivLB) ? 'checked="checked"':"";
											$HCAChecked = !empty($AppToCA) ? 'checked="checked"':"";
											$CARChecked = !empty($CAReturns) ? 'checked="checked"':"";		

											if(!$session_data['branchcode'] == '000') {
												$role_only 	= 'data-role="hqonly"';
												$role_block = 'disabled="disabled"';
											} else {
												$role_only  = '';
												$role_block = '';
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
											
											$TrackLink = site_url('management/gridErrorTrack').'?rel='.$DocID.'&dump='.md5(date('s')).'&rfx='.$IsRef.'&grid=op&hasType='.trim($behalf).'&enble=true&manage='.md5('false');
											
											$objError	= "
											<td style=\"border: 0px;\">
    											<a href=\"$TrackLink\" target=\"_blank, _top\" class=\"nonprint\">
    												<span class=\"tooltip-top\" data-tooltip=\"Error Tracking\" style=\"position: absolute; border-radius: 3px; padding: 5px; font-size: 1em; margin-top: -17px; border: 1px solid #FFF; margin-left: 5px; cursor: pointer;\" clear: both;\">
													<i class=\"fa fa-exclamation-triangle fg-red\"></i>
													</span>
												</a>
											</td>";
											
											echo "
											<tr class=\"item_relation\" table-attr=\"$i\" style=\"min-width: 220 !important;\">
				                        		<td><div class=\"input-control text tooltip-top\" data-tooltip=\"$BorrowerName\"><input value=\"$BorrowerName\" disabled></div></td>
												<td class=\"text-left\">";
											?>		
													<div style="margin-top: -6px; padding-bottom: 5px; padding-right: 2px;">
														<div class="input-control radio" style="margin-left: -8px;">
					                            		<label>
												         	<input id="logistic_env_<?php echo $i; ?>" name="Relation_Logistics[<?php echo $i; ?>]" type="radio" value="301" <?php if($DocFlow[$index]['LogisticCode'] == 301) echo 'checked="checked"'; ?> disabled="disabled">
												          	<span class="check"></span>
												          	<i class="fa fa-envelope fg-lightBlue" style="cursor: pointer; font-size: 1.2em;"></i>
												        </label>												        									
					                            	</div>
					                            	<div class="input-control radio" style="margin-left: 1px;">
					                            		<label>
												         	<input id="logistic_mot_<?php echo $i; ?>" name="Relation_Logistics[<?php echo $i; ?>]" type="radio" value="302" <?php if($DocFlow[$index]['LogisticCode'] == 302) echo 'checked="checked"'; ?> disabled="disabled">
												          	<span class="check"></span>
												          	<i class="fa fa-motorcycle fg-lightBlue" style="cursor: pointer; font-size: 1.2em;"></i>
												        </label>
					                            	</div>
					                            	<div class="input-control radio" style="margin-right: 1px;">
					                            		<label>
												         	<input id="logistic_peo_<?php echo $i; ?>" name="Relation_Logistics[<?php echo $i; ?>]" type="radio" value="303" <?php if($DocFlow[$index]['LogisticCode'] == 303) echo 'checked="checked"'; ?> disabled="disabled">
												          	<span class="check"></span>
												          	<i class="fa fa-users fg-lightBlue" style="cursor: pointer; font-size: 1.2em;"></i>
												        </label>
					                            	</div>	
													</div>
				                        							
					                            <?php
					                         
					                            echo "
			                        			</td>
												<td><div class=\"input-control text\"><input value=\"$SubmitHQ\" disabled style=\"max-width: 100px;\"></div></td>
												<td><div class=\"input-control text\"><input value=\"$ReceivLB\" disabled style=\"max-width: 100px;\"></div></td>
				                        		<td>
				                        			<div class=\"input-control select size2\">
						                            	<select id=\"Relation_Sel_$i\" name=\"Relation_ComplementionDoc[]\" data-attr=\"Sel$IsRef\" class=\"cm-SelectFix\" style=\"height: 33px; max-width: 80px; background: #EBEBE4; margin-left: -30px;\" disabled=\"disabled\">
						                        ";
												?>	
						                            		<option value="" <?php if($DocFlow[$index]['CompletionDoc'] == '') { echo 'selected="selected"'; } ?>></option>
						                            		<option value="N" <?php if($DocFlow[$index]['CompletionDoc'] == 'N') { echo 'selected="selected"'; } ?>>ไม่ครบ</option>
						                            		<option value="Y" <?php if($DocFlow[$index]['CompletionDoc'] == 'Y') { echo 'selected="selected"'; } ?>>ครบ</option>
						                        <?php 
						                        echo "
						                            	</select>
					                            	</div>
					                            	<input id=\"completiondoc_hidden_$i\" name=\"completion_hidden[]\" data-attr=\"M$IsRef\" type=\"hidden\" value=\"\">
					                            	<i class=\"icon-copy on-left budgetFixed fg-lightBlue\" onclick=\"openModalComponent($DocID, '$BorrowerName', '$IsRef', 'M');\" style=\"cursor: pointer; position:absolute; font-size: 1.5em; margin-top: 5px; margin-left: -40px;\"></i>
					                            	<span id=\"onBadge_$i\" data-attr=\"M$IsRef\" class=\"badge budgetAmountFixed bg-red\" style=\"position: absolute; margin-left: -30px; margin-top: -5px;\">0</span>
				                        		</td>
				                        		<td><div class=\"input-control text\"><input value=\"$AppToCA\" disabled style=\"max-width: 100px;\"></div></td>
				                        		<td>
				                        			<div id=\"remode_$i\" style=\"cursor: pointer; font-weight: bold;\" class=\"input-control text show-pop-list tooltipwebui\" data-placement=\"vertical\" onmouseover=\"popoverlogs('remode_$i' ,'listContent_$i', $RecID);\">
				                        				<input value=\"$CAReturnsLog\" disabled style=\"max-width: 100px;\">
				                        			</div>
				                        			
				                        			<input id=\"reconcile_id_bundled_$RecID\" name=\"reconcile_id_bundled[]\" type=\"hidden\" value=\"\">
											        <input id=\"creditreturn_list_bundled_$RecID\" name=\"creditreturn_list_bundled[]\" type=\"hidden\" value=\"\">
                									<input id=\"creditreturn_otherlist_bundled_$RecID\" name=\"creditreturn_otherlist_bundled[]\" type=\"hidden\" value=\"\">
											        
											        <div id=\"listContent_$i\" style=\"display: none;\"></div>
				                        			
				                        		</td>
				                        		<td class=\"budgetWidth\">
				                        			<input id=\"returndoc_hidden_$i\" name=\"returndoc_hidden[]\" data-attr=\"R$IsRef\" type=\"hidden\" value=\"\">
				                        			<i class=\"icon-copy on-left fg-lightBlue\" onclick=\"openModalComponent($DocID, '$BorrowerName', '$IsRef', 'R');\" style=\"cursor: pointer; font-size: 1.5em; margin-bottom: 9px;\"></i>
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

		

								  }
								  
								  echo "
								  <script>
								  
									  function popoverlogs(element, list_content, ref) {
										
										  var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + \"//\" + window.location.host;
										  var pathFixed = window.location.protocol + \"//\" + window.location.host;
										  for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += \"/\"; }
						         
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
										
															$('#' + list_content).append('<div>#' + responsed['data'][index]['ReturnDateSub'] + '. ' + reason_name + '</div>');
										
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
										
									  
											
								  </script>";

								  ?>
	                        </tbody>
	                    </table>

	                </section>
	                
		        	<!-- Progress for save and alert message  -->
		
				</fieldset>
				
				
				<?php echo form_close(); ?>
				
				<input id="doc_tmp" name="doc_tmp" type="hidden" value="">
                <input id="doc_tmpname" name="doc_tmpname" type="hidden" value="">
                <input id="doc_ref"	name="doc_ref" type="hidden" value=""> 
                				
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                    <div class="modal-dialog">
                        <!-- <form id="docmanage_forms" action="<?php echo site_url('management/setDocumentManagementForm'); ?>" method="post"> -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close hidden" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="label_RelationCompletion">Document Management</h4>
                                </div>
                                <div class="modal-body" style="padding-right: 50px;">
                                                                    
                                    <section class="form_container" style="clear: both;">
                                        <input id="LockDocTypes" name="LockDocTypes" type="hidden" value="">
                                        <table id="expense_table_docmanagement" style="width: 100%; min-width: 100%; margin-top: -10px;">
                                            <thead>
                                            <tr>
                                                <th align="center" style="width: 0.1em; visibility:hidden; border: 0;">TYPE</th>
                                                <th align="center" style="width: 5em;">TYPE</th>
                                                <th align="center" style="width: 31em;">DOCUMENT</th>
                                                <th align="center" style="width: 10em;">LB <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
                                                <th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> HQ RECEIVED</th>
                                                <th align="center" style="width: 10em;">HO <i class="fa fa-arrow-right on-right on-left"></i> CA</th>
                                                <th align="center" style="width: 10em;">CA <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
                                                <th align="center" style="width: 10em;">HO <i class="fa fa-arrow-right on-right on-left"></i> LB</th>
                                                <th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> LB RECEIVED</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                           

                                            </tbody>
                                        </table>
										<div id="load_progress" style="margin-left: 1%;"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"> Loading...</div>
										
                                        <?php
                                        echo "
										<script>
				
                                            function openModalComponent(bundled, name, ref, type) {
                                            
												var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + \"//\" + window.location.host;
											    var pathFixed = window.location.protocol + \"//\" + window.location.host;
											    var rootFixed = window.location.protocol + \"//\" + window.location.host + '/pcis';
											    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += \"/\"; }
    
												var load_progress = $('#load_progress');
				
                                                $('#myModal').modal({
													show: true,
										   			keyboard: false,
										   			backdrop: 'static'
												});
				
												load_progress.hide();
												$.ajax({
									   	    		url: pathFixed+'dataloads/getReconcileCompletionDocData?_=' + new Date().getTime(),
									   	    	  	type: \"POST\",
									   	          	data: {
									   	          		relx: bundled,
    													refx: name,
														ridx: ref,
 														type: type
									   	          	},
									   	          	beforeSend:function() {
									   	        	  	load_progress.show();
														$('#doc_tmp').val(bundled);
														$('#doc_tmpname').val(name);
														$('#doc_ref').val(ref);
				
														if(type == 'M') { $('#label_RelationCompletion').html('Missing Document (Readonly)'); }
 														else { $('#label_RelationCompletion').html('Return Document (Readonly)'); }
				
									   	          	},
									   	          	success:function(data) {
														console.log(data);
    													if(data['status'] == 'true') {
															
    														var i = 1;
															$('#LockDocTypes').val(type);
															$('#expense_table_docmanagement > tbody').empty();
															for(var indexed in data['data']) {
				
																var doc_id 		 = data['data'][indexed]['DocID'];
																var borrowername = data['data'][indexed]['DocOwner'];
																var doc_notreturn = data['data'][indexed]['DocIsLock'];
				
																var type_1 		 = '';
																var type_2 		 = '';
																var type_3 		 = '';
																var state_1		 = '';
																var state_2		 = '';
																var state_3		 = '';
									
																var doc_type	 = data['data'][indexed]['DocType'];
																if(doc_type == '') {
																	type_1  = 'selected=\"selected\"';
																} else if(doc_type == 'M') {
																	type_2  = 'selected=\"selected\"';
																}  else if(doc_type == 'R') {
																	type_3  = 'selected=\"selected\"';
																}
				
																var doc_state	= data['data'][indexed]['DocStatus'];
																if(doc_state == '') {
																	state_1  = 'selected=\"selected\"';
																} else if(doc_state == 'C') {
																	state_2  = 'selected=\"selected\"';
																}  else if(doc_state == 'O') {
																	state_3  = 'selected=\"selected\"';
																}
															
 		
 																var hq_element_lock = '';
 																if(doc_type == 'R') {
 																	hq_element_lock = ''; //'border-color: #4390df;';
 																}
 		
 																var role_only  = '';
			 													var role_block = '';
			 													var lbcode	   = $('#BranchCode').val();
 		
			 													if(lbcode != '000') {
																	role_only 	= 'data-role=\"hqonly\"';
																	role_block  = 'disabled=\"disabled\"';
																} else {
																	role_only   = '';
																	role_block  = '';
																}
 		
 																var ele_block   = (doc_type == 'M') ? 'disabled=\"disabled\"':'';
				
 																var objMissDoc	= data['data'][indexed]['MissID'];
																var LBSentToHQ	= data['data'][indexed]['LBSubmitDocDate'];
																var HQReceived	= data['data'][indexed]['HQReceivedDocFromLBDate'];
																var SentToCA	= data['data'][indexed]['SubmitDocToCADate'];
																var CAReturn	= data['data'][indexed]['CAReturnDate'];
																var HQSentToLB  = data['data'][indexed]['HQSentToLBDate'];
																var LBReceived  = data['data'][indexed]['BranchReceivedDate'];
 																//var CAReject	= data['data'][indexed]['CARejectDocDate'];
 																 		
																var LBChecked	= !(data['data'][indexed]['LBSubmitDocDate'] == '') ? 'checked=\"checked\"':'';
																var HQChecked	= !(data['data'][indexed]['HQReceivedDocFromLBDate'] == '') ? 'checked=\"checked\"':'';
																var LCChecked	= !(data['data'][indexed]['SubmitDocToCADate'] == '') ? 'checked=\"checked\"':'';
																var CAChecked	= !(data['data'][indexed]['CAReturnDate'] == '') ? 'checked=\"checked\"':'';
																var HLChecked	= !(data['data'][indexed]['HQSentToLBDate'] == '') ? 'checked=\"checked\"':'';
																var LRChecked   = !(data['data'][indexed]['BranchReceivedDate'] == '') ? 'checked=\"checked\"':'';

																// ADD NEW ON 25 FEB 2019
																var CreateByName  = data['data'][indexed]['CreateDocBy'];
																var CreateByDate  = (data['data'][indexed]['CreateDocDate']) ? moment(data['data'][indexed]['CreateDocDate']).format('DD/MM/YYYY HH:mm'):'';
											
																var tooltip_create = '';
																if(CreateByName && CreateByName !== '') {
																	tooltip_create = 'data-hint-position=\"top\" data-tooltip=\"' + CreateByDate + ' ' + CreateByName + '\"';
																}		 		

 																										
																var doc_detail	= data['data'][indexed]['DocDetail'];
																var doc_comment = data['data'][indexed]['DocOther'];
 																var special_doc = data['data'][indexed]['ImportantDoc'];
				
												            	if(special_doc == 'Y') var special_assing = 'color: red;';
																else var special_assing = 'color: black !important';
 		
																$('#expense_table_docmanagement').fadeIn(\"slow\", function() {
												   	        		$('#expense_table_docmanagement > tbody').append(
												   	        		
												   	        			'<tr class=\"item_docmange\">'+
			                                                            '<td style=\"visibility:hidden; border: 0; width: 0.1em;\">'+
			                                                                '<div class=\"input-control select\">'+
			                                                                '<select id=\"DocType_' + i +'\" name=\"DocTypes[]\" style=\"height: 33px;\">'+
			                                                                        '<option value=\"M\" '+type_2+'>M</option>'+
			                                                                        '<option value=\"R\" '+type_3+'>R</option>'+		                                                    
			                                                    			'</select>'+
 																			'<input id=\"MissID_' + i + '\" name=\"MissID[]\" type=\"hidden\" value=\"' + objMissDoc + '\">'+
			                                                                '</div>'+
			   	                                                         '</td>'+
																		 '<td valign=\"top\">' +
																			'<div class=\"input-control select\">'+
				                                                                '<select id=\"DocStatus_' + i +'\" name=\"DocStatus[]\" style=\"height: 33px;\" disabled>'+
																					'<option value=\"O\" ' + state_1 + ' ' + state_3 + '>O</option>'+
				                                                                    '<option value=\"C\" ' + state_2 + '>C</option>'+
				                                                                '</select>'+
				                                                            '</div>'+
																		'</td>' +
			                                                            '<td valign=\"top\" class=\"text-left\">'+
			                                                                '<div class=\"input-control select\" ' + tooltip_create + '>'+
			                                                                    '<input id=\"docList_hidden_' + i +'\" name=\"docList_hidden[]\" type=\"hidden\" value=\"'+ data['data'][indexed]['DocList'] +'\">'+
																				'<input name=\"DocID\" type=\"hidden\" value=\"' + bundled + '\">'+
                                                            					'<input name=\"DocBorrowerName\" type=\"hidden\" value=\"' + name + '\">'+
																				'<input name=\"DocIsRef\" type=\"hidden\" value=\"' + ref + '\">'+
			                                                                     '<div id=\"DoclistText_' + i + '\" style=\"height: 33px; padding-left: 10px; padding-top: 5px; border-top: 1px solid #D1D1D1; border-bottom: 1px solid #D1D1D1; ' + special_assing + '\">' +
												                                  	'<span>' + doc_detail + '</span>' + 
												                                '</div>' +
 																				'<div id=\"Label_DocListOther_' + i +'\" class=\"input-control text\" style=\"min-height: 34px; height: auto; padding-left: 10px; padding-top: 5px; border-top: 1px solid #D1D1D1; border-bottom: 1px solid #D1D1D1;\">'+
				 																	doc_comment +
				 																'</div>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\" class=\"text-left\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -14px; margin-top: 3px; z-index: 999;\">'+
			                                                                   '<label>'+
			                                                                        '<input id=\"DSubHQ_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'DSubHQ_click_'+ i +'\', \'Doc_SubmitToHQ_'+ i +'\');\" '+ LBChecked + ' disabled>'+
			                                                                        '<span class=\"check\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input type=\"text\" id=\"Doc_SubmitToHQ_' + i +'\" name=\"Doc_SubmitToHQ[]\" value=\"' + LBSentToHQ + '\" style=\"padding-left: 30px;\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\" class=\"text-left\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -14px; margin-top: 3px; z-index: 999;\">'+
			                                                                    '<label>'+
			                                                                        '<input ' + role_block + ' ' + role_only + '  id=\"DRVD_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'DRVD_click_'+ i +'\', \'Doc_RVD_'+ i +'\');\" ' + HQChecked + ' disabled>'+
			                                                                        '<span class=\"check\" style=\"' + hq_element_lock + ';\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input ' + role_only + ' type=\"text\" id=\"Doc_RVD_' + i +'\" name=\"Doc_HQReceived[]\" value=\"' + HQReceived + '\" style=\"padding-left: 30px; ' + hq_element_lock + '\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\" class=\"text-left\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -14px; margin-top: 3px; z-index: 999;\">'+
			                                                                    '<label>'+
			                                                                        '<input ' + role_block + ' ' + role_only + ' id=\"HQC_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'HQC_click_'+ i +'\', \'Doc_HQC_'+ i +'\');\" ' + LCChecked + ' disabled>'+
			                                                                        '<span class=\"check\" style=\"' + hq_element_lock + ';\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input ' + role_only + ' type=\"text\" id=\"Doc_HQC_' + i +'\" name=\"Doc_HQToCA[]\" value=\"' + SentToCA + '\" style=\"padding-left: 30px; ' + hq_element_lock + '\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\" class=\"text-left\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -14px; margin-top: 3px; z-index: 999;\">'+
			                                                                    '<label>'+
			                                                                        '<input ' + role_block + ' ' + role_only + ' id=\"CAH_click_' + i +'\" type=\"checkbox\" onclick=\"GenDateValidator(\'CAH_click_'+ i +'\', \'Doc_CAH_'+ i +'\');\" value=\"1\" ' + CAChecked + ' disabled>'+
			                                                                        '<span class=\"check\" style=\"' + hq_element_lock + '\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input ' + role_only + ' type=\"text\" id=\"Doc_CAH_' + i +'\" name=\"Doc_CAToHQ[]\" value=\"' + CAReturn + '\" style=\"padding-left: 30px; ' + hq_element_lock + '\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\" class=\"text-left\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -14px; margin-top: 3px; z-index: 999;\">'+
			                                                                    '<label>'+
			                                                                        '<input ' + role_block + ' ' + role_only + ' id=\"HQL_click_' + i +'\" type=\"checkbox\" onclick=\"GenDateValidator(\'HQL_click_'+ i +'\', \'Doc_HQL_'+ i +'\');\" value=\"1\" ' + HLChecked + ' disabled>'+
			                                                                        '<span class=\"check\" style=\"' + hq_element_lock + '\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input ' + role_only + ' type=\"text\" id=\"Doc_HQL_' + i +'\" name=\"Doc_HQToLB[]\" value=\"' + HQSentToLB + '\" style=\"padding-left: 30px; ' + hq_element_lock + '\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\" class=\"text-left\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -14px; margin-top: 3px; z-index: 999;\">'+
			                                                                    '<label>'+
			                                                                        '<input type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'LBR_click_'+ i +'\', \'Doc_LBR_'+ i +'\');\" ' + LRChecked + ' disabled>'+
			                                                                        '<span class=\"check\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input type=\"text\" id=\"Doc_LBR_' + i +'\" name=\"Doc_LBReceived[]\" value=\"' + LBReceived + '\" style=\"padding-left: 30px;\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                       '</tr>');																	
				
																	$('#objSubHQ_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
				
																	if(type == 'M') { $('#label_RelationCompletion').html('Missing Document (Readonly)'); }
 																	else { $('#objLBR_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" }); }
																	
 																	if($('#Doc_RVD_' + i).attr('data-role') != 'hqonly') {
 		
	 																	$('#objDRVD_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
				                                                        $('#objHQC_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
	 																	$('#objCAH_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
				                                                        $('#objHQL_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
																		//$('#objCA_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
 																	
																	}
 		
																	if($('#DocListOther_' + i).val() == '') $('#Label_DocListOther_' + i).hide(); 	
																	
																	/*
 																	var docList_hidden = $('#docList_hidden_' + i).val();
 																	var is_allow  = in_array(docList_hidden, [9, 28, 59, 60, 67, 96, 103]);
				
 																	if(is_allow) { $('#Label_DocListOther_' + i).show();  }
 																	else { $('#Label_DocListOther_' + i).hide(); }
 																	*/
				
 																	if(doc_type == 'M') { $('#DocType_' + i).find('option[value=\"R\"]').remove(); }
	 																if(doc_type == 'R') { $('#DocType_' + i).find('option[value=\"M\"]').remove(); }
 					
																	i++;
															
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
				
																	function in_array(needle, haystack, argStrict) {													
																	
																	  var key = '',
																	    strict = !! argStrict;
																	
																	  //we prevent the double check (strict && arr[key] === ndl) || (!strict && arr[key] == ndl)
																	  //in just one for, in order to improve the performance 
																	  //deciding wich type of comparation will do before walk array
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
				
												   	        	});
																
															}
				
															$.ajax({
	                                                            url: pathFixed+'dataloads/lackcategory?_=' + new Date().getTime(),
	                                                            type: 'POST',
	 															data: { typex: doc_type },															
	                                                            success:function(data) {
	
	                                                                for(var indexed in data['data']) {
	                                                                   $('select[name^=\"DocList[]\"]').append('<optgroup label=\"' + data['data'][indexed]['LackCategory'] + '\" data-core=\"OPT_' + i + '_L' + data['data'][indexed]['LackGroupID']+ '\"></optgroup>');
	                                                                }
	
	                                                            },
																complete:function() {
																	
																	$.ajax({
						                                                url: pathFixed+'dataloads/lackdoctype?_=' + new Date().getTime(),
						                                                type: 'POST',
				 														data: {
																		   	typex: type,
																		},
						                                                success:function(data) {
				 		
						                                                	for(var indexed in data['data']) {
																				
																				var lbcode	    = $('#BranchCode').val();
																				var special_doc = data['data'][indexed]['ImportantDoc'];
																				var data_attr	= (special_doc == 'Y') ? special_doc:'N';
				
																				if(special_doc == 'Y') var special_assing = 'color: red; ';
																				else var special_assing = 'color: black !important;';
				
																				var lock_item		= '';
																				var lock_itemstyle	= '';
																				if(data['data'][indexed]['LackID'] == '112') {
																					if(lbcode != '000') { 
																						lock_itemstyle = 'color: #7B7B7B !important; background: #EBEBE4;';
																						lock_item	   = 'disabled=\"disabled\"'; 
																					}
																				}
				
																				var style_item = 'style=\"' + special_assing + ' ' + lock_itemstyle + '\"';
						        												$('select[name^=\"DocList[]\"]').find('optgroup[data-core=\"OPT_' + i + '_L' + data['data'][indexed]['LackGroupID'] + '\"]').append('<option data-attr=\"' + data_attr + '\" value=\"' + data['data'][indexed]['LackID'] + '\" ' + style_item + ' ' + lock_item + '>' + data['data'][indexed]['LackDoc']+ '</option>');
				
																			}		
																																		
						                                                },
						                                                complete:function() {
																						
																			var n = parseInt(1);
																			var v = parseInt(0);
																			$('select[name^=\"DocList\"]').each(function() {			
																				$('#DocList_' + n).find('option[value=\"'+  parseInt(data['data'][v]['DocList']) + '\"]').attr('selected', 'selected');
																							
																				v++;
																				n++;
																			});	
																						
																			$('option[data-attr=\"Y\"]:selected').parent().parent().addClass('text-selectred');
				
						                                                 },
						                                                 cache: true,
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
	                                                            cache: true,
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
 		
 															
														} else {
 		
 															$('#LockDocTypes').val(type);
															$('#expense_table_docmanagement > tbody').empty();
						
														}
													    					
							    					},
									   	            complete:function() {
										   	        	load_progress.hide();
									   	            },				
									   	          	cache: true,
									   	          	timeout: 5000,
									   	          	statusCode: {
									   		  	        404: function() {
									   		  	            alert(\"page not found.\");
									   		  	        },
									   		  	        407: function() {
									   		  	        	console.log(\"Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )\");
									   		  	        },
									   		  	        500: function() {
									   		  	        	console.log(\"internal server error.\");
									   		  	        }
									   	          }
								   	         
								   				});
 											
	
                                            }
				
											function onFreeNoteSupplement(id) {
 												$('#Label_DocListOther_' + id).show(); 																							
 											}

 											function onSelectListDoc(id) {
												var doc_other = $('#DocList_' + id).val();
												var is_allow  = in_array(doc_other, [9, 28, 59, 60, 67, 96, 103]);
												
												if(is_allow) {
				 									$('#Label_DocListOther_' + id).show();
				 								} else {
				 									$('#Label_DocListOther_' + id).hide();
				 								}
				
 											}
				
											 
											function in_array(needle, haystack, argStrict) {
												
												  var key = '',
												    strict = !! argStrict;
												
												  //we prevent the double check (strict && arr[key] === ndl) || (!strict && arr[key] == ndl)
												  //in just one for, in order to improve the performance 
												  //deciding wich type of comparation will do before walk array
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
 		
 											function resetRelatedCompletionField(id, bundled) {
 		
			 									var element_return = $('#' + bundled).val();
			 									 
			 									if(element_return == '') {
			 		
			 		
			 									} else {
			 		
			 										if(confirm('ยืนยันการรีเซ็ทข้อมูลหรือไม่')) {
			 			
												 		$('#DRVD_click_' + id).prop('checked', false);	
												 		$('#HQC_click_' + id).prop('checked', false);
 														$('#CAH_click_' + id).prop('checked', false);	
												 		$('#HQL_click_' + id).prop('checked', false);
 														$('#LBR_click_' + id).prop('checked', false);	
			 												
			 											$('#Doc_RVD_' + id).val('');
			 											$('#Doc_HQC_' + id).val('');
 														$('#Doc_CAH_' + id).val('');
			 											$('#Doc_HQL_' + id).val('');
 														$('#Doc_LBR_' + id).val('');
			 					
			 		 									return true;
 		
			 									  	 }
			 		
			 									  	 return false;
 		
 												}
			 		
			 								}
 		
 											function delRecordRelations(bundled, ref, data) {
				                            	 		
			                            	  	if(confirm('ยืนยันกาลบข้อมูลหรือไม่')) {
			
													var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + \"//\" + window.location.host;
													var pathFixed = window.location.protocol + \"//\" + window.location.host;
													for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += \"/\"; }
																									
													$.ajax({
			                                        	url: pathFixed+'management/delRecordBorrowerLoan?_=' + new Date().getTime(),
			                                            type: 'POST',
														data: {
															relx: bundled,
															ltsx: data,
															modx: 'rcpx5',
															real: ref
														},
			                                            success:function(data) {
															var not = $.Notify({ content: \"ลบข้อมูลสำเร็จ\", style: { background: \"green\", color: \"#FFFFFF\" }, timeout: 10000 });
			    											not.close(7000);                                      														
														},
			                                            complete:function() {
 															
 															var doc_id		   = $('#DocID').val();
 															var is_ref		   = $('input[name=\"DocIsRef\"]').val();
 														    var doc_borrower   = $('input[name=\"DocBorrowerName\"]').val();
 														
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
																
					                                            	$('input[data-attr=\"'+ miss_ref +'\"]').val(data['data'][0]['NumMissingDoc']);
																	$('span[data-attr=\"'+ miss_ref +'\"]').text(data['data'][0]['NumMissingDoc']);
																	
																	$('input[data-attr=\"' + return_ref +'\"]').val(data['data'][0]['NumReturnDoc']);
														           	$('span[data-attr=\"' + return_ref +'\"]').text(data['data'][0]['NumReturnDoc']);
 		
 																	$('select[data-attr=\"'+ select_ref +'\"]').find('option[value=\"' + data['data'][0]['CompletionDoc'] +'\"]').attr('selected', 'selected');
														          
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
												            $('#expense_table_docmanagement').parent().after('<span class=\"docmange_error text-danger span5\">หากแถวที่ระบุน้อยกว่าที่กำหนดจะไม่สามารถลบแถวได้..</span>').fadeIn();
												            $('.docmange_error').fadeOut(5000);
												            
												        }
												    });
			
								                    return true;
			                            	 		
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

                                            

								           return false;
			                            	 		
			                            }

                                        </script>";
                                        ?>

                                    </section>

                                </div>
                                <div class="modal-footer">
                                	<span class="place-left" style="color: red; margin-left: 35px;">เอกสารสีแดง คือ เอกสารสำคัญที่ใช้ในการจดจำนอง,  &nbsp;</span>
                                	<span class="place-left fg-orange">O = เอกสารต้นฉบับ, C = สำเนาเอกสาร</span>  
                                	
                                	<button id="document_closeModal" type="button" class="btn btn-primary" style="margin-right: 35px;" onclick="$('#myModal').modal('hide'); ">Close</button>                  
                                </div>
                            </div>
                        <!-- </form> -->
                        
                    </div>
                </div>
				
			</section>
		
		</article>
	
		<div id="form_footer">
	    	<img src="<?php echo base_url('img/logo_form_footer.jpg'); ?>" style="margin-top: 5px; min-width: 1170px; height: 45px;">
		</div>

	</div>
	</div>
	
</div>