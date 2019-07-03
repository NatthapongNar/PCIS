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
    
    .case_history { height: 32px; width: 150px; text-align: center; padding: 5px; color: white; }
     @media screen and (-webkit-min-device-pixel-ratio:0) { 
		.cb-marginFixedChrome {
			margin-top: 2px !important;
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
		
	}

</style>

<?php $this->load->helper('form'); ?>
<?php $this->load->library('effective'); ?>
<div class="container">	
	<div class="grid" style="width: 1300px; margin-left: -90px;">
		<div id="form" class="row">
			
			<div class="logo_header">
				<img src="<?php echo base_url('img/logo_form_header.jpg'); ?>" style="min-width: 1170px;">
			</div>
			
			<header id="form-header"><h2>VERIFICATION PROCESS : HISTORY</h2></header>	
			<article class="profile-progress">
			    <h2>APPLICATION PROGRESS STATUS</h2>
			    <div id="appProgressHistory" class="stepper" data-role="stepper" data-steps="3" data-start="4"></div>
			</article>			
			<div id="form-frame">
				<header class="span12 marginBottom5"><p class="subheader-secondary">VERIFICATION</p></header>
				<div class="span12">
				
					<!-- PANEL -->
					<div id="panel_criteria" class="panel span12" data-role="panel" style="min-height: 30px; min-width: 1080px; margin-bottom: 10px; margin-left: 15px;">
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
				        <div class="span8" style="border-bottom: 1px solid #D1D1D1; padding: 3px; height: 30px;">
				           <?php echo !empty($getVerify['ID_Card']) ? $getVerify['ID_Card']:""; ?>
				        </div>
				    </div>
				    				    
				    <div class="span12" style="margin-top: 10px;">
				        <div class="input-control select">
				            <label class="span4">Product Program</label>
				            <div class="span8" style="border-bottom: 1px solid #D1D1D1; padding: 3px; height: 30px;">
				            <?php echo !empty($getVerify['ProductCode']) ? $getVerify['ProductCode'] . '-' . $getVerify['ProductName']:""; ?>
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
				    	<section style="position: absolute; min-width: 1080px; margin-top: -30px;">				    		
				    		<i id="NCBConsentLogs" class="fa fa-tablet on-right" style="float:right; margin-right: 3px; cursor: pointer; font-size: 1.5em;" data-hint="History Logs" data-hint-position="top"></i>				    	
				    	</section>	
				    </header>
				    
				    <section class="form_container span12" style="margin-top: -10px;">
				    	<input id="flagno" name="flagno" type="hidden" value="<?php echo $getFlag; ?>">
	                    <table id="expense_table_ncbrefer" style="min-width: 1080px;">
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
	                        	
	                        	$this->load->model('dbmodel');
	                        	$types = $this->dbmodel->CIQuery("SELECT * FROM MasterBorrowerType WHERE IsActive = 'A'");
	          	
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
										
										if($NCBConsent[$index]['BorrowerType'] == 101) { $ncb_type_1 = $this->effective->get_chartypes($char_mode, $types['data'][$index]['BorrowerDesc']); } 
										else if($NCBConsent[$index]['BorrowerType'] == 102) { $ncb_type_2 = $this->effective->get_chartypes($char_mode, $types['data'][$index]['BorrowerDesc']);} 
										else if($NCBConsent[$index]['BorrowerType'] == 103) { $ncb_type_3 = $this->effective->get_chartypes($char_mode, $types['data'][$index]['BorrowerDesc']); } 
										else if($NCBConsent[$index]['BorrowerType'] == 104) { $ncb_type_4 = $this->effective->get_chartypes($char_mode, $types['data'][$index]['BorrowerDesc']); } 
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
				                            <td><div style=\"height: 30px;\">$ncb_type</div></td>
				                            <td><div style=\"height: 30px;\">$BorrowerName</div></td>
				                            <td><div style=\"height: 30px;\">$ncbchecker</div></td>
				                            <td><div style=\"height: 30px;\">$NCBDate</div></td>
				                            <td><div style=\"height: 30px;\">$NCBSent</div></td>
				                            <td><div style=\"height: 30px;\">$NCBHQGet</div></td>
				                            <td><div style=\"height: 30px;\">$NCBTOOPER</div></td>
				                            <td><div style=\"height: 30px;\">$NCBReturnLog</div></td>
				                            <td><div style=\"height: 30px;\"></div></td>
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
				            <div class="span6" style="border-bottom: 1px solid #D1D1D1; padding: 3px; height: 60px;"><?php echo !empty($getVerify['Comments']) ? $getVerify['Comments']:""; ?></div>
				        </div>
				   	</div>
				   	
				   	<header class="span12" style="margin-top: 10px;"><h6>RM On Processes</h6></header>
                	<div class="span12">
                		
				        <div id="parent_rmprocess" class="input-control select">
				            <label id="label_rmprocess" class="span4">RM Process</label>
				            <div class="span6" style="border-bottom: 1px solid #D1D1D1; padding: 3px; height: 30px;">
				            	<?php 
				            	
				            		$rmprocess = !empty($getVerify['RMProcess']) ? $getVerify['RMProcess']:"";
				            		if($rmprocess == "CANCELBYRM") { echo 'ยกเลิก โดย RM'; } 
				            		else if($rmprocess == "CANCELBYCUS") { echo 'ยกเลิก โดย ลูกค้า'; }
				            		else if($rmprocess == "CANCELBYCA") { echo 'ยกเลิก โดย CA'; } 
				            		else {
				            			echo $rmprocess;
				            		}
				            	
				            	?>
				            </div>				            
				        </div>
			    	</div>
			    	
			    	<div class="span12" style="margin-top: -10px;">
			    	<label class="span4">&nbsp;</label>
			    	<div class="span6">
			    		<div class="listview-outlook" data-role="listview">
							<div class="list-group collapsed">
								<a href="" class="group-title" style="text-decoration: none;">RM process logs</a>
								<div class="group-content" style="height: 250px; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">
								
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
				
					<div class="span12">
				   		<?php $rmprocessreason = !empty($getVerify['RMProcessReason']) ? $getVerify['RMProcessReason']:""; ?>
				   		<div id="parent_rmprocess_reason" class="input-control select">
				   			<label id="label_rmprocess_reason" class="span4">Choose Reason</label>
				   			<div class="span6" style="border-bottom: 1px solid #D1D1D1; padding: 3px; height: 30px;">
				   				<?php echo !empty($getVerify['ProcessReason']) ? $getVerify['ProcessReason']:""; ?>
				            </div>	
				   		</div>
				   </div>
				   	
				   <div class="span12">
				   		<div id="resource_parent" class="input-control textarea">
				            <label class="span4">Action Note <!-- <span style="padding-left: 3.5em; font-size: 1em;"><i class="fa fa-plus-square fg-green" data-hint="ต้องการเพิ่ม  action note" data-hint-position="top"></i></span> --></label>
							<div class="span6" style="border-bottom: 1px solid #D1D1D1; min-height: 60px;">
								<?php echo !empty($ActionLogs[0]['ActionNote']) ? $this->effective->get_chartypes($char_mode, $ActionLogs[0]['ActionNote']):""; ?>
				            </div>
				        </div>
				   </div>
   
				   <div class="span12">
				   <label class="span4">&nbsp;</label>
			       <div class="span6" style="margin-top: -8px;">
			    		<div class="listview-outlook" data-role="listview">
							<div class="list-group collapsed">
								<a href="" class="group-title" style="text-decoration: none;">History Logs <span style="font-size: 0.8em;">( For Action Note )</span></a>
								<div id="actionnote_group" class="group-content" style="-ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">
										
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
																<span style="line-height:12px; font-size: 0.8em;">Note : '.$this->effective->get_chartypes($char_mode, $data_split[$index]['ActionNote']).'</span>
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
				   
				    <!-- Defender Part -->
				    <input id="defend_no" name="defend_no" type="hidden" value="<?php echo !empty($getDefend['data'][0]['DefendRef']) ? $getDefend['data'][0]['DefendRef']:'1'; ?>">
				    <input id="defendCaseBadge" name="defendCaseBadge" type="hidden" value="<?php echo !empty($getDefendNum[0]['DefendNum']) ? $getDefendNum[0]['DefendNum']:'0'; ?>">
				    <?php 				    

				    $defend_proposer  = !empty($getDefend['data'][0]['ProposerType']) ? $getDefend['data'][0]['ProposerType']:'';
				    $def_process 	  = !empty($getDefend['data'][0]['DefendProcess']) ? $getDefend['data'][0]['DefendProcess']:'';
				
				    ?>
				    
				    <div class="span12">
		                <div class="input-control">
		                   <label class="span4">Defend</label>
		                   <div class="input-control checkbox">
		                    	<label>
 									<input id="defenseByRM" name="defend_proposer" type="checkbox" value="RM" <?php if($defend_proposer == 'RM') echo 'checked="checked"'; ?> disabled="disabled"> 									
		            		    	<span class="check"></span> LB
		                        </label>
		                   </div>  
		                   <div class="input-control checkbox">
		                         <label>
 									<input id="defenseBySFE" name="defend_proposer" type="checkbox" value="DF" <?php if($defend_proposer == 'DF') echo 'checked="checked"'; ?> disabled="disabled"> 								
		            		    	<span class="check"></span> HO
		                        </label>		                        
		                  </div>     
		                  <div class="input-control select size2 marginLeft10">                       
 								<select id="defend_process" name="defend_process" disabled="disabled" style="width: 210px; height: 34px !important;"> 	
 									 															
 									<?php
 									
 										$process_select	= '';
 										$before_process = '';
 										$on_process		= '';
 										$after_process	= '';
 										
 										$defend_process = !empty($getDefend['data'][0]['DefendProcess']) ? $getDefend['data'][0]['DefendProcess']:''; 										
 										if($defend_process == 'Before Process') {
 											$before_process = 'selected="selected"';
 											
 										} else if($defend_process == 'On Process') {
 											$on_process 	= 'selected="selected"';
 											
 										} else if($defend_process == 'After Process') {
 											$after_process 	= 'selected="selected"';
 											
 										} else if($defend_process == '') {
 											$process_select = 'selected="selected"';
 										}

 										$status_draft = array('REJECT', 'CANCEL', 'CANCELBYCA', 'CANCELBYRM','CANCELBYCUS');
 										if($DefProcess['Status'] != '' && in_array($DefProcess['Status'], $status_draft) || $DefProcess['CC_AfterAppr'] != '') {
 											$defend_process = 'AFTER_PROCESS';
 										
 										} else if($DefProcess['CA_ReceivedDocDate'] != '') {
 											$defend_process = 'ON_PROCESS';
 											 
 										} else if($DefProcess['RMProcess'] != '' && $DefProcess['AppToCA'] != '' && $DefProcess['CAReturnDateLog'] == '' ||
 											$DefProcess['RMProcess'] != '' && $DefProcess['AppToCA'] == '' && $DefProcess['CAReturnDateLog'] != '' ) {
 											$defend_process = 'BEFORE_PROCESS';
 													 
 										} else {
 											$defend_process = 'BEFORE_PROCESS';
 										}
 	
 										echo '<option value="" '.$process_select.'></option>
 											  <option value="Before Process" '.$before_process.'>Before Process</option>
 											  <option value="On Process" '.$on_process.'>On Process</option>
 											  <option value="After Process" '.$after_process.'>Retrieve Process</option>';
 											 
 										
 										
 									?> 										
 										
 								</select>		                        
							</div>
							<div class="input-control text size2 " style="max-width: 115px;  margin-left: 70px;">	                 
				            	<input id="defend_date_disbled" type="text" value="<?php echo !empty($getDefend['data'][0]['DefendDate']) ? $this->effective->StandartDateRollback($getDefend['data'][0]['DefendDate']):''; ?>" disabled="disabled">
				            	<button class="btn-clear" type="button" onclick="$('#defend_date').val('');"></button>		       	       
					        </div>
		                </div>
		           </div>

				   <div id="objDefendbox" class="span12" style="margin-top: 20px;">
		                <label class="span4">&nbsp;</label>
		                <div id="objDefendReason" class="span6" style="min-width: 327px; border: 1px solid #D1D1D1; margin-top: -15px; margin-left: 20px; padding: 5px; display: block;"></div>
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
									
				   	            	 if(data['data'][0]['DocID'] == '' || data['data'][0]['DocID'] == null) {
				   	            		 
				   	            	 } else {
				   	            		
				   	            		 for(var indexed in data['data']) {
											
											 var etc;
				   	            			 if(data['data'][indexed]['DefendOther'] != '') {
				   	            				 etc = data['data'][indexed]['DefendOther'];
				   	            			 } else {
				   	            				 etc = '';
				   	            			 }
				   	            			 
		
					   	                     $('#objDefendReason').append('<div>' + (parseInt(indexed) + 1) + '. ' + data['data'][indexed]['DefendReason'] + ' ' + etc + '</div>');
		
					   	                 }
		
				   	            		 
				   	            	 }
			
				   	                
				   	             }, 		   	      
				   	             cache: true,
				   	             timeout: 5000,
				   	             statusCode: {
				   	                 404: function() {
				   	                     alert( 'page not found.' );
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
	
				   <div class="span12" style="clear: both; margin-top: 30px;">
				    	<div class="span4" style="margin-right: 20px;">
				    		<label class="span4">Re-Activate Reason <span style="padding-left: 0.1em; font-size: 1em;"><i class="fa fa-question-circle fg-lightBlue" data-hint="Re-Activate Plan| ในกรณีที่ลูกค้ามีคุณสมบัติไม่เพียงพอ อาจจะด้วยไม่ผ่านเงือนไขอย่างใดอย่างหนึ่ง เช่น ประสบการณ์ไม่ถึง 3 ปี หรือ คำนวน DSCR แล้วไม่เป็นไปตามเกณฑ์  ฟิลด์นี้มีไว้เพื่อเป็นแผนการบริหารลูกค้ากลับเข้ามาทำสินเชื่อใหม่ในอนาคต..." data-hint-position="top"></i></span></label>
				        </div>
				        <div id="objreactivate" class="input-control select span4" style="min-width: 180px; border-bottom: 1px solid #D1D1D1; height: 30px; display: block; height: auto;">
				        	<?php 
				
				        	if(empty($RevisitList[0]['VerifyID'])): 
				        		echo "&nbsp;";
				        	
				        	else:
					
				        		$i = 1;
				        		foreach ($RevisitList as $index => $values) {
				        				
				        			$name	= !empty($RevisitList[$index]['RevisitReason']) ? $RevisitList[$index]['RevisitReason']:'';
				        				
				        			echo $i. '. ' .$name.'<br/>';
				        			
				        			$i++;
				        				
				        		}
				        	
				        	
				        	endif;
				        	
				        	
				        	?>
				        </div>
				        <div id="ClndrRevPlan" class="input-control text span2" style="max-width: 115px; margin-left: 5px;  border-bottom: 1px solid #D1D1D1; height: 30px">
				            <?php echo !empty($getVerify['RevisitDate']) ? $getVerify['RevisitDate']:"&nbsp;"; ?>
				        </div>
				        <div id="revisitText" class="span2" style="margin-top: 4px; cursor: pointer;"><?php echo !empty($getVerify['RevisitRef']) ? 'REF : ' . $getVerify['RevisitRef']:""; ?></div>
				   </div>

				   <header class="span12" style="margin-top: 10px;">
				    	<h6>Document Flow</h6>
				    	<section style="position: absolute; min-width: 1045px; margin-top: -30px;">				    		
				    		<i id="RelationLogs" class="fa fa-tablet  on-right" style="float:right; margin-right: 3px; cursor: pointer; font-size: 1.5em;" data-hint="History Logs" data-hint-position="top"></i>				    		
				    	</section>	
				    </header>		        	
		        	<section class="form_container span12" style="margin-top: -10px; margin-bottom: 20px;">
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
											$objError	= "<td style=\"border: 0px;\"><a href=\"$TrackLink\" target=\"_blank, _top\"><i class=\"icon-cc-share fg-yellow\" data-hint=\"Error Tracking\" data-hint-position=\"right\" style=\"position: absolute; font-size: 1.5em; margin-top: -15px; margin-left: 10px; cursor: pointer;\"></i></a></td>";
											
											echo "
											<tr class=\"item_relation\" table-attr=\"$i\">
				                        		<td><div style=\"height: 30px;\">$BorrowerName</div></td>
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
												<td><div style=\"height: 30px;\">$SubmitHQ</div></td>
												<td><div style=\"height: 30px;\">$ReceivLB</div></td>
				                        		<td>
				                        			<div class=\"input-control select size2\">
						                            	<select id=\"Relation_Sel_$i\" name=\"Relation_ComplementionDoc[]\" data-attr=\"Sel$IsRef\" style=\"height: 33px; max-width: 80px;	margin-left: -30px;\" disabled=\"disabled\">
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
					                            	<span id=\"onBadge_$i\" data-attr=\"M$IsRef\" class=\"badge budgetAmountFixed bg-red\" style=\"position: absolute; margin-left: -28px; margin-top: -5px;\">0</span>
				                        		</td>
				                        		<td><div style=\"height: 30px;\">$AppToCA</div></td>
				                        		<td><div style=\"height: 30px;\">$CAReturnsLog</div></td>
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
						                       
						                       var not = $.Notify({ content: \"คุณกำลังอยู่ใน Preview Mode. หากต้องการปรับปรุงข้อมูล กรุณาเลือก Edit.\", style: { background: '#666666', color: '#FFFFFF' }, timeout: 10000 });
        	    							   not.close(7000);
						                       
						                     </script>";
						
											$i++;
										}

		

								  }


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
                				
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left: 100px;">
                    <div class="modal-dialog">
                        <!-- <form id="docmanage_forms" action="<?php echo site_url('management/setDocumentManagementForm'); ?>" method="post"> -->
                            <div class="modal-content" style="min-width: 1200px; margin-left: 10%;">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Document Management</h4>
                                </div>
                                <div class="modal-body">
                                                                    
                                    <section class="form_container" style="clear: both; margin-top: 30px">
                                    	<span id="label_RelationCompletion" style="position: absolute; margin-left: 20px; font-size: 1.2em; margin-top: -30px; font-weight: 700;"></span>
                                   <!-- <i id="RelationCompletionLogs" class="fa fa-tablet  on-right" style="float:right; margin-right: 3%; cursor: pointer; font-size: 1.5em;" data-hint="History Logs" data-hint-position="top"></i> -->
                                        <input id="LockDocTypes" name="LockDocTypes" type="hidden" value="">
                                        <table id="expense_table_docmanagement" style="min-width: 1150px; margin-left: -10px;">
                                            <thead>
                                            <tr>
                                                <th align="center" style="width: 0.1em; visibility:hidden; border: 0;">TYPE</th>
                                                <th align="center" style="width: 5em;">TYPE</th>
                                                <th align="center" style="width: 25em;">DOCUMENT</th>
                                                <th align="center" style="width: 10em;">LB <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
                                                <th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> HQ RECEIVED</th>
                                                <th align="center" style="width: 10em;">HO <i class="fa fa-arrow-right on-right on-left"></i> CA</th>
                                                <th align="center" style="width: 10em;">CA <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
                                                <th align="center" style="width: 10em;">HO <i class="fa fa-arrow-right on-right on-left"></i> LB</th>
                                                <th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> LB RECEIVED</th>
                                                <!-- <th align="center" style="width: 10em;"><i class="fa fa-arrow-left on-left"></i> CA RETRUN</th> -->
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
                                                $('#myModal').modal('show').draggable();
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
				
														if(type == 'M') { $('#label_RelationCompletion').html('Missing Document'); }
 														else { $('#label_RelationCompletion').html('Return Document'); }
				
									   	          	},
									   	          	success:function(data) {
				
    													if(data['status'] == 'true') {
															
    														var i = 1;
															$('#LockDocTypes').val(type);
															$('#expense_table_docmanagement > tbody').empty();
															for(var indexed in data['data']) {
				
																var doc_id 		 = data['data'][indexed]['DocID'];
																var borrowername = data['data'][indexed]['DocOwner'];
				
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
 		
 																var doc_comment = data['data'][indexed]['DocOther'];
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
 																//var CARChecked	= !(data['data'][indexed]['CARejectDocDate'] == '') ? 'checked=\"checked\"':'';
										
 																//'<option value=\"\"  '+type_1+'></option>'+
 		
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
			                                                            '<td valign=\"top\">'+
			                                                                '<div class=\"input-control select\">'+
			                                                                    '<input id=\"docList_hidden_' + i +'\" name=\"docList_hidden[]\" type=\"hidden\" value=\"'+ data['data'][indexed]['DocList'] +'\">'+
																				'<input name=\"DocID\" type=\"hidden\" value=\"' + bundled + '\">'+
                                                            					'<input name=\"DocBorrowerName\" type=\"hidden\" value=\"' + name + '\">'+
																				'<input name=\"DocIsRef\" type=\"hidden\" value=\"' + ref + '\">'+
			                                                                    '<select id=\"DocList_' + i +'\" name=\"DocList[]\" style=\"height: 33px;\" onchange=\"onSelectListDoc(\'' + i + '\');\" disabled>'+
			                                                                        '<option value=\"\"></option>'+
			                                                                    '</select>'+
 																				'<div id=\"Label_DocListOther_' + i +'\" class=\"input-control text\">'+
				 																'<input id=\"DocListOther_' + i +'\" name=\"DocListOther[]\" value=\"'+ doc_comment +'\">'+
				 																'</div>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -10px; margin-top: -1px; z-index: 999;\">'+
			                                                                   '<label>'+
			                                                                        '<input id=\"DSubHQ_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'DSubHQ_click_'+ i +'\', \'Doc_SubmitToHQ_'+ i +'\');\" '+ LBChecked + ' disabled>'+
			                                                                        '<span class=\"check\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input type=\"text\" id=\"Doc_SubmitToHQ_' + i +'\" name=\"Doc_SubmitToHQ[]\" value=\"' + LBSentToHQ + '\" style=\"padding-left: 30px;\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -10px; margin-top: -1px; z-index: 999;\">'+
			                                                                    '<label>'+
			                                                                        '<input ' + role_block + ' ' + role_only + '  id=\"DRVD_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'DRVD_click_'+ i +'\', \'Doc_RVD_'+ i +'\');\" ' + HQChecked + ' disabled>'+
			                                                                        '<span class=\"check\" style=\"' + hq_element_lock + ';\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input ' + role_only + ' type=\"text\" id=\"Doc_RVD_' + i +'\" name=\"Doc_HQReceived[]\" value=\"' + HQReceived + '\" style=\"padding-left: 30px; ' + hq_element_lock + '\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -10px; margin-top: -1px; z-index: 999;\">'+
			                                                                    '<label>'+
			                                                                        '<input ' + role_block + ' ' + role_only + ' id=\"HQC_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'HQC_click_'+ i +'\', \'Doc_HQC_'+ i +'\');\" ' + LCChecked + ' disabled>'+
			                                                                        '<span class=\"check\" style=\"' + hq_element_lock + ';\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input ' + role_only + ' type=\"text\" id=\"Doc_HQC_' + i +'\" name=\"Doc_HQToCA[]\" value=\"' + SentToCA + '\" style=\"padding-left: 30px; ' + hq_element_lock + '\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -10px; margin-top: -1px; z-index: 999;\">'+
			                                                                    '<label>'+
			                                                                        '<input ' + role_block + ' ' + role_only + ' id=\"CAH_click_' + i +'\" type=\"checkbox\" onclick=\"GenDateValidator(\'CAH_click_'+ i +'\', \'Doc_CAH_'+ i +'\');\" value=\"1\" ' + CAChecked + ' disabled>'+
			                                                                        '<span class=\"check\" style=\"' + hq_element_lock + '\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input ' + role_only + ' type=\"text\" id=\"Doc_CAH_' + i +'\" name=\"Doc_CAToHQ[]\" value=\"' + CAReturn + '\" style=\"padding-left: 30px; ' + hq_element_lock + '\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -10px; margin-top: -1px; z-index: 999;\">'+
			                                                                    '<label>'+
			                                                                        '<input ' + role_block + ' ' + role_only + ' id=\"HQL_click_' + i +'\" type=\"checkbox\" onclick=\"GenDateValidator(\'HQL_click_'+ i +'\', \'Doc_HQL_'+ i +'\');\" value=\"1\" ' + HLChecked + ' disabled>'+
			                                                                        '<span class=\"check\" style=\"' + hq_element_lock + '\"></span>'+
			                                                                    '</label>'+
			                                                                '</div>'+
			                                                                '<div class=\"input-control text\" style=\"width: 120px;\">'+
			                                                                    '<input ' + role_only + ' type=\"text\" id=\"Doc_HQL_' + i +'\" name=\"Doc_HQToLB[]\" value=\"' + HQSentToLB + '\" style=\"padding-left: 30px; ' + hq_element_lock + '\" disabled>'+
			                                                                '</div>'+
			                                                            '</td>'+
			                                                            '<td valign=\"top\">'+
			                                                                '<div class=\"input-control checkbox\" style=\"position:absolute; margin-left: -10px; margin-top: -1px; z-index: 999;\">'+
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
				
																	if(type == 'M') { $('#label_RelationCompletion').html('Missing Document'); }
 																	else { $('#objLBR_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" }); }
																	
 																	if($('#Doc_RVD_' + i).attr('data-role') != 'hqonly') {
 		
	 																	$('#objDRVD_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
				                                                        $('#objHQC_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
	 																	$('#objCAH_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
				                                                        $('#objHQL_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
																		//$('#objCA_' + i).datepicker({ format: \"dd/mm/yyyy\", effect: \"slide\", position: \"bottom\" });
 																	
																	}
 		
 																	$('#Label_DocListOther_' + i).hide(); 	

 																	var docList_hidden = $('#docList_hidden_' + i).val();
 																	var is_allow  = in_array(docList_hidden, [9, 28, 59, 60, 67, 96, 103]);
				
 																	if(is_allow) { $('#Label_DocListOther_' + i).show();  }
 																	else { $('#Label_DocListOther_' + i).hide(); }
 		
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
						                                                    	$('select[name^=\"DocList[]\"]').find('optgroup[data-core=\"OPT_' + i + '_L' + data['data'][indexed]['LackGroupID']+ '\"]').append('<option value=\"' + data['data'][indexed]['LackID'] + '\">' + data['data'][indexed]['LackDoc']+ '</option>');
						        	
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
 		
 		
 										$(document).ready(function() {

                                             $('.modal').css({
                                             	width: 'auto',
                                                'margin-left': function () {
                                                	return -($(this).width() / 2);
                                                }
                                        	}); 		
	
                                        });
										                    	

                                        </script>";
                                        ?>

                                    </section>

                                </div>
                                <div class="modal-footer">
                                	<span class="place-left fg-orange" style="margin-left: 25px;">O = เอกสารต้นฉบับ, C = สำเนาเอกสาร</span>                           
                                </div>
                            </div>
				
				</div>
			</div>
		
		</div>
	</div>
</div>