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
    
    .badge {
	  display: inline-block;
	  min-width: 10px;
	  padding: 3px 7px;
	  font-size: 12px;
	  font-weight: bold;
	  line-height: 1;
	  color: #fff;
	  text-align: center;
	  white-space: nowrap;
	  vertical-align: middle;
	  background-color: #777;
	  border-radius: 10px;
	}
	.badge:empty {
	  display: none;
	}
	
	.tooltip-top { text-align: center !important;}
	
	.text_float { 
		position: absolute;
		margin-top: 55%;
		margin-left: 80px;
		border: 1px solid #D1D1D1;
		padding: 5px 10px;
		-webkit-transform: rotate(270deg);
		-moz-transform: rotate(270deg);
		-o-transform: rotate(270deg);
		transform: rotate(270deg);
		writing-mode: lr-tb;
		font-weight: bold;
	}

</style>

<div class="text_float nonprint"><h2>Preview</h2></div>

<div class="container">

<p id="back-top" class="nonprint"><a href="#top"><i class="fa fa-arrow-up"></i> Back to Top</a></p>

<?php     	
    	$hide_attr= '';
    	$none_style= '';
		$disable_attr= '';
		if(in_array($session_data['role'], array('adminbr_role'))):
			$disable_attr = 'disabled="disabled"';
			$none_style = 'style="display: none;"';
			$hide_attr = 'display: none;';
			echo '<div id="check_denied_role" class="row" data-attr="denied" style="display: none;"><div class="label error span12" style="padding: 5px 3px;">ขออภัย, คุณไม่มีสิทธิ์ในการแก้ไขข้อมูล</div></div>';
		endif;
?>

<div class="grid">
    <div id="form" class="row">
    
    	<div class="logo_header">
			<img src="<?php echo base_url('img/logo_form_header.jpg'); ?>">
		</div>
    
        <div id="form-header" class="col-sm-12 col-md-12 col-lg-12">
            <h2>APPLICATION STATUS</h2>
        </div>

        <div class="profile-progress nonprint">
            <h2>APPLICATION PROGRESS STATUS</h2>
            <div id="appprogress" class="stepper" data-role="stepper" data-steps="3" data-start="3"></div>
        </div>

        <div id="form-frame">
            <div class="grid">
                <div class="row">
     
					<?php $badge = $this->dbmodel->CIQuery("SELECT TOP 1 PostponeRef, CONVERT(nvarchar(10), OriginalPlan, 120) AS OrginalPlanDate  FROM PostponeHead WHERE DocID = '".$objPostpone['data'][0]['DocID']."' ORDER BY PostponeRef DESC"); ?>

                    <!-- PANEL  -->
					<div id="panel_criteria" class="panel span12 nonprint" data-role="panel" style="min-height: 30px; margin-left: 20px; margin-bottom: 10px;">
						<div class="panel-header bg-lightBlue fg-white" style="font-size: 1em;"><i class="icon-user-3 on-left"></i>View Information</div>
						<div class="panel-content" style="display: none;">
							
							<div class="row">
							
								<div class="span5 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลลูกค้า</label></div>
								<div class="span5 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลพนักงาน</label></div>
								
								<div class="span5">
									<label class="label size2 text-left">ชื่อ - นามสกุล</label>	
									<?php $prefix 	= !empty($getCustInfo['PrefixName']) ? $getCustInfo['PrefixName']:""; ?>
									<?php $custname = !empty($getCustInfo['OwnerName']) ? $getCustInfo['OwnerName']:""; ?>								
									<?php $borrower = !empty($getCustInfo['BorrowerName']) ? $getCustInfo['BorrowerName']:""; ?>								
									<span class="label size3 text-left" style="margin-left: 15px !important;"><?php echo $prefix. ' ' . !empty($borrower) ? $borrower:$custname;  ?></span>
									<input id="borrowername_title" type="hidden" value="<?php echo !empty($borrower) ? trim($borrower):trim($custname);  ?>">
								</div>
								
								<div class="span5">
									<label class="label span2 text-left">ชื่อ - นามสกุล</label>							
									<div class="label span3 text-left"><?php echo !empty($getCustInfo['RMName']) ? $getCustInfo['RMName']:""; ?></div>
								</div>
								
								<div class="span5" style="clear:left;">
									<label class="label span2 text-left">มาจากช่องทาง</label>	
									<div class="label span3 text-left"><?php echo !empty($getCustInfo['SourceOfCustomer']) ?$getCustInfo['SourceOfCustomer']:"";  ?></div>
								</div>
								<div class="span5">
									<label class="label span2 text-left">รหัสพนักงาน</label>								
									<div class="label span3 text-left"><?php echo !empty($getCustInfo['RMCode']) ? $getCustInfo['RMCode']:""; ?></div>
								</div>
								
								<div class="span5">
									<label class="label span2 text-left">ศักยภาพลูกค้า</label>	
									<div class="label span3 text-left"><?php echo !empty($getCustInfo['CSPotential']) ? $getCustInfo['CSPotential']:""; ?></div>
								</div>
								<div class="span5">
									<label class="label span2 text-left">รหัสสาขา</label>							
									<div class="label span3 text-left"><?php echo !empty($getCustInfo['BranchCode']) ? $getCustInfo['BranchCode']:""; ?></div>
								</div>
								
								<div class="span5">
									<label class="label span2 text-left">เบอร์ติดต่อ</label>	
									<div class="label span3 text-left"><?php echo !empty($getCustInfo['Mobile']) ? $getCustInfo['Mobile']:$getCustInfo['Telephone']; ?></div>
								</div>
								<div class="span5">
									<label class="label span2 text-left">สาขา</label>								
									<div class="label span3 text-left"><?php echo !empty($getCustInfo['Branch']) ? $getCustInfo['Branch']:""; ?></div>
								</div>
								
								<div class="span5">
									<label class="label span2 text-left">วงเงินที่ต้องการ</label>	
									<div class="label span3 text-left"><?php echo !empty($getCustInfo['RequestLoan']) ? number_format($getCustInfo['RequestLoan'], 0):""; ?></div>
								</div>
								<div class="span5">
									<label class="label span2 text-left">เบอร์ติดต่อ</label>							
									<div class="label span3 text-left"><?php echo !empty($getCustInfo['RMMobile']) ? $getCustInfo['RMMobile']:""; ?></div>
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

                    <div class="span12" style="margin-bottom: 5px; margin-top: 10px;"><h3>STATUS</h3></div>

                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Application No</label>
                            <div class="span4"><input id="appno" type="text" value="<?php echo !empty($results['data'][0]['ApplicationNo']) ? $results['data'][0]['ApplicationNo']:""; ?>" disabled="disabled"></div>
                        </div>
                    </div>
                    
                    <div class="span12">
                    	<label class="span4 text-blue">CA Name</label>
                        <div class="input-control text span3" >                         
                            <input style="margin-left: 20px; max-width: 195px;" type="text" value="<?php echo !empty($results['data'][0]['CAName']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['CAName']):""; ?>" disabled="disabled">
                        </div>
                        <div class="input-control text span2" style="max-width: 105px;">
                        	<input id="careceived_date" name="careceived_date" type="text" value="<?php echo !empty($results['data'][0]['CA_ReceivedDocDate']) ? StandartDateRollback($results['data'][0]['CA_ReceivedDocDate']):""; ?>" class="size2" style="max-width: 100px;"  disabled="disabled">
                        </div>
                        
                        <?php 
                        	
                        $objDoc_id = !empty($_GET['rel']) ? $_GET['rel']:'';
                        $result_cahistory = $this->dbmodel->CIQuery("
                        	SELECT DocID, CAName, CONVERT(nvarchar(10), CA_ReceivedDate , 120) AS CA_ReceivedDate
                        	FROM   Retrieve_CATransactionLog
                        	WHERE DocID = '$objDoc_id'
                        	ORDER BY CA_ReceivedDate DESC
                        ");
                        	
                        if(!empty($result_cahistory['data'][0]['CA_ReceivedDate'])) {
                        	
                        ?>
                        
                        <div class="toolbar fg-black nonprint" style="margin-top: 2px;">
                        	<span id="creditname_logs" class="tooltip-top show-pop-list" data-tooltip="CA Received History" data-placement="right">
                        		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
                        	</span>				         				    
				       	</div>     
				       	<?php } ?>  
                             
                    </div>
                    
                    <div id="parent_creditnamelog" style="display: none;">
                    <?php 
               
                   		$objDoc_id = !empty($_GET['rel']) ? $_GET['rel']:'';
                   		$result_cahistory = $this->dbmodel->CIQuery("
                   			SELECT DocID, CAName, CONVERT(nvarchar(10), CA_ReceivedDate , 120) AS CA_ReceivedDate
							FROM   Retrieve_CATransactionLog
							WHERE DocID = '$objDoc_id'
							ORDER BY CA_ReceivedDate DESC                   				
                   		");
                   		
                   		if(!empty($result_cahistory['data'][0]['CA_ReceivedDate'])) {                   			
                   			foreach($result_cahistory['data'] as $index => $value):
                   				echo '#'.$this->effective->StandartDateRollback($result_cahistory['data'][$index]['CA_ReceivedDate']).' '.$this->effective->get_chartypes($char_mode, $result_cahistory['data'][$index]['CAName']).'<br/>';
                   				//echo '#'.substr($this->effective->StandartDateRollback($result_cahistory['data'][$index]['CA_ReceivedDate']), 0, 5).' '.$this->effective->get_chartypes($char_mode, $result_cahistory['data'][$index]['CAName']).'<br/>';
                   			endforeach;
                   		                   			
                   		} else { echo 'ไม่พบข้อมูล'; }
                                   		
                    ?>
                    </div>
                    
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Approver Name</label>
                            <div class="input-control text span4">
                            	<input type="text" name="approvername" id="approvername" value="<?php echo !empty($results['data'][0]['ApproverName']) ? ltrim($this->effective->get_chartypes($char_mode, $results['data'][0]['ApproverName'])):""; ?>" class="marginLeft20" disabled="disabled">
                            </div>                            
                        </div>                       
                    </div>
                    
                    <div class="span12">
                        <div class="input-control textarea">
                            <label class="span4 text-blue">CA Comment</label>
                            <textarea id="cacomment" type="text" rows="5" class="span4" disabled="disabled"><?php echo !empty($results['data'][0]['AppComment']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['AppComment']):""; ?></textarea>
                           
                            <span id="objFixed" class="none nonprint" style="margin-left: 10px; font-size: 1.3em;" data-hint="ขยายข้อความ" data-hint-position="top">
                                <i class="icon-menu fg-lightBlue" style="margin-top: 2em;"></i>
                            </span>
                           
                        </div>
                    </div>
                    
                    <div class="span12">
                        <div class="input-control textarea">
                            <label class="span4 text-blue">CA Income Calculation</label>
                            <textarea id="caincome nonprint" name="caincome" type="text" rows="5" class="span4" disabled="disabled"></textarea>
                           
                            <span id="objFixed" class="none nonprint" style="margin-left: 10px; font-size: 1.3em;" data-hint="ขยายข้อความ" data-hint-position="top">
                                <i class="icon-menu fg-lightBlue" style="margin-top: 2em;"></i>
                            </span>
                            
                        </div>
                    </div>
                    
                    <!-- 
                    <div class="span12 marginTop15" style="clear: both;">
                        <div class="input-control text">
                            <label class="span4 text-blue">Status Date</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['StatusDate']) && ($results['data'][0]['StatusDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['StatusDate']):""; ?>" disabled="disabled">
                            </div>
                        </div>
                    </div>
				 	-->
				 	
                    <div class="span12">
                        <div class="input-control text">
                        	<?php $status = !empty($results['data'][0]['Status']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Status']):""; ?>
                        	<?php 
                            		switch ($status) {
										
                            			case 'PENDING':
                            			case 'AIP':
                            				$state = "PENDING";
                            				break;
										case 'APPROVED':
											$state = "APPROVED";
											break;
										case 'PREAPPROVED':
											$state = "PRE-APPROVED";
											break;
										case 'REJECT':
											$state = "REJECT";
											break;
										case 'CANCEL':
											$state = "CANCEL";
											break;
										case 'CANCELBYRM':
										case 'CANCELBYCUS':
										case 'CANCELBYCA':
											$state = $status;
											break;
										default:
											$state = "";
											break;
				
									}
                            	
                            	?>
                            <label class="span4 text-blue">Application Status</label>
                            <div class="span3" style="max-width: 190px;">
                            	<input type="text" value="<?php echo !empty($state) ? $state:""; ?>" disabled="disabled">
                            </div>
                            <div class="span2" style="max-width: 105px; margin-left: 5px;">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['StatusDate']) && ($results['data'][0]['StatusDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['StatusDate']):""; ?>" disabled="disabled">
                            </div>
                            <div class="toolbar fg-black span1 nonprint" style="margin-top: 2px; margin-left: 5px;">                            	
	                            <span id="status_callhistory" class="tooltip-top show-pop-list" data-tooltip="Status History" class="tooltip-top show-pop-list" data-tooltip="Translate Reason Code" data-placement="right">
	                            	<i class="fa icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
	                            </span>                
				        	</div>
                        </div>
                        
                    </div>
                    
                     <div id="parent_status_callhistory" style="display: none;">
                     	<table class="table borderd">
                     		<thead>
                     			<tr><th colspan="4">Decision Status</th></tr>
	                     		<tr>
	                     			<th>#</th>
	                     			<th>Date</th>
	                     			<th>Status</th>
	                     			<th>Reason</th>
	                     		</tr>
                     		</thead>
                     		<tbody></tbody>
                     	</table>
                     </div>

                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Decision Reason</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo!empty($results['data'][0]['StatusReason']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['StatusReason']):""; ?>" disabled="disabled">
                            </div>                         
                        </div>
                    </div>              
                    
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Deviate Reason</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['DiviateReason']) ? $results['data'][0]['DiviateReason']:""; ?>" disabled="disabled">
                            </div>
                            <?php if(!empty($results['data'][0]['DiviateReason'])) { ?>
                            <span id="TranslateCode" class="tooltip-top show-pop-list marginLeft5 nonprint" data-tooltip="Translate Reason Code" class="tooltip-top show-pop-list" data-tooltip="Translate Reason Code" data-placement="right">
                            	<i class="fa fa-language fg-lightBlue fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
                            </span>
                            <?php } ?>
                        </div>
                    </div>
    
                    <div class="span12">
                        <div id="parent_preapproved" class="input-control checkbox">
                            <?php $preapp = !empty($results['data'][0]['PreApproved']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['PreApproved']):""; ?>
                            <label class="span4">Pre Approved Loan</label>             
                            <div class="input-control text size4" style="margin-left: 20px;">
                                <input type="text" name="preapproved" id="preloan" value="<?php echo !empty($results['data'][0]['PreLoan']) ?  number_format($results['data'][0]['PreLoan'], 0):""; ?>" class="size4" disabled="disabled">
                            </div>
                            <div class="input-control text-right">
                                <div id="preapp_alert" class="span3 text-danger"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="parent_translatereason" style="display: none;">
                    <?php 
                    	
                    	if(!empty($results['data'][0]['DiviateReason'])):
                    	
                    		$list_code = $results['data'][0]['DiviateReason'];                    	
                    		$pieces = explode(',', $list_code);
                    		
                    		if(!empty($pieces[0])) :
                    			$translate_code	= "'".implode("','", $pieces)."'";
                    		else:
                    			$translate_code = "";
                    		endif;
                    		
                    		if(!empty($translate_code)):   
                    			
	                    		$i = 1;
	                    		$inquiry 		= $this->dbmodel->CIQuery("SELECT * FROM Master_TranslateReason WHERE LISTCODE IN ($translate_code)");
	                    		foreach ($inquiry['data'] as $index => $value) {
	                    			echo $i. '. ['. $inquiry['data'][$index]['LISTCODE'].'] '.$inquiry['data'][$index]['DESCRIPTION'].'<br/>';
	                    			$i++;
	                    		}
	                    		 
                    		
                    		endif;
             
                    	else:
                    		echo 'ไม่พบข้อมูล';
                    	endif;
                    	
                    ?>                    
                    </div>
                    
                    <?php $apprv_loan = !empty($results['data'][0]['ApprovedLoan']) && ($results['data'][0]['ApprovedLoan'] != "0") ? number_format(trim($results['data'][0]['ApprovedLoan']), 0):""; ?>
                    <div class="span12" <?php if(trim($apprv_loan) == "") echo 'style="display: none;"'; ?>>                    	
                        <div class="input-control text">
                            <label class="span4 text-blue">Approved Loan</label>
                            <input type="text" value="<?php echo $apprv_loan; ?>" class="span4" disabled="disabled">
                            <div class="span1" style="color: #d2322d;"></div>
                            <div id="apploan_alert" class="span3 text-alert"></div>
                        </div>
                    </div>

                    <div class="span12">
                        <div class="input-control textarea">
                            <label class="span4">Cancel Reason (After Approved)</label>
                            <div class="input-control textarea span4" style="margin-left: 20px; min-height: 34px; margin-right: 5px; padding: 5px; text-align: left; font-size: 0.8em; border: 1px solid #D9D9D9; background-color: #EBEBE4;">

                               	<?php 
				                    if(empty($nonListLive['data'][0]['ProcessCode'])) {
				                    	echo "";
				                    	
				                    } else {
				                    	                    
				                    	$i = 1;
				                    	foreach ($nonListLive['data'] as $index => $value) {
				                    
				                    		echo $i .'. '. $this->effective->get_chartypes($char_mode, $nonListLive['data'][$index]['ProcessReason']) ."<br/>";
				                    
				                    		$i++;
				                    	}
				                    	
				                    	echo "<br/>".'หมายเหตุ: ข้อมูลที่แสดงจะไม่รวมข้อมูลอื่นๆ โดยสามารถดูข้อมูลเพิ่มเติมได้จาก logs ในระบบแทน.';
				                    
				                    }                    	
			                    
			                    ?>
                          
                            </div>
                            
                            <div class="toolbar fg-black nonprint" style="margin-top: 2px;">
				         		<?php  if(!empty($objNonAccept['data'][0]['DocID'])) { ?>
					        	<span  id="nonoacept_logs"  class="tooltip-top show-pop-list" data-tooltip="Cancel List Reason History (After Approved)" data-placement="right">
					        		<i id="nonoacept_icon" class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
					        	</span>
					        	<?php } ?>					    
				       		</div>
                        </div>                        
                    </div>
                    
                    <div id="nonaccept_reasonarea" style="display: none; font-size: 0.8em !important;">
                    <?php 
                    	
	                    if(empty($objNonAccept['data'][0]['DocID'])) {
	                    	echo "<div>ไม่พบข้อมูล</div>";
	                    	
	                    } else {
	                    	                    
	                    	$i = 1;
	                    	foreach ($objNonAccept['data'] as $index => $value) {
	                    
	                    		if(!empty($objNonAccept['data'][$index]['OtherDetail'])):
	                    			$text_nonacceptreason = $objNonAccept['data'][$index]['MasterReason']. ' ' .$objNonAccept['data'][$index]['OtherDetail'];
	                    		else:
	                    			$text_nonacceptreason = $objNonAccept['data'][$index]['MasterReason'];
	                    		endif;
	                    
	                    		echo "<div>". $i .'. '. $text_nonacceptreason ."</div>";
	                    
	                    		$i++;
	                    	}
	                    
	                    }                    	
                    
                    ?>
                    </div>   
       
       				<?php $dd_reserv = ($results['data'][0]['DrawdownReservation'] == 'Y') ? $results['data'][0]['DrawdownReservation']:'N'; ?>
       				<?php $receiveEstimated = ($results['data'][0]['ReceivedEstimateDoc'] == 'Y') ? $results['data'][0]['ReceivedEstimateDoc']:'N'; ?>
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4">
                            	Drawdown Plan Date
                            	<span <?php if($dd_reserv == "Y") { echo 'style="display: none;'; } else { echo 'style="color: red; font-weight: bold;"'; }?>>
					        		<?php 
					        		if($receiveEstimated == 'Y' && in_array($session_data['role'], array('admin_role', 'hq_role', 'dev_role'))) {
					        				echo '(OPER รับเล่มแล้ว)';
					        			}
					        		?>
					        	</span>
                            </label>
                            <div class="input-control text span4" style="margin-left: 20px;">
                                <input type="text" value="<?php echo !empty($results['data'][0]['PlanDrawdownDate']) && ($results['data'][0]['PlanDrawdownDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['PlanDrawdownDate']):""; ?>" disabled="disabled">
                            </div>
                            <div class="input-control checkbox span2" style="max-width: 125px; margin-left: 10px;">
                                <label>
							    	<input id="drawdown_reserv" name="drawdown_reserv" type="checkbox" value="Y" <?php if($results['data'][0]['DrawdownReservation'] == "Y") echo 'checked="checked"'; ?> disabled="disabled">
							    	<span class="check"></span> จอง Drawdown
							    </label>
                            </div>
                            <div id="parent_unknowns" class="input-control checkbox span2" style="margin-left: 5px !important;">
						        <label>
						        	<input id="unknown_state" type="checkbox" value="Y" <?php if($results['data'][0]['PlanDateUnknown'] == "Y") echo 'checked="checked"'; ?> disabled="disabled">
						        	<span class="check"></span>
						        	<span>เลื่อนไม่มีกำหนด</span>
						        </label>
			        		</div>
                        </div>                       
                    </div>
                    
                    <div class="span12">
                    	<div class="input-control">
					    	<label class="span4">Postpone Drawdown Plan Reason</label>				
					        <div id="postpone_txtreason" class="input-control textarea span4" style="margin-left: 20px; min-height: 34px; margin-right: 5px; padding: 0 5px; text-align: left; font-size: 0.8em; border: 1px solid #D9D9D9; background-color: #EBEBE4;">
					        	<?php 
					       			
			                    	if(empty($objPostpone['data'][0]['DocID'])) {
			                    		echo "";
			                    		
			                    	} else {
			                    		
			                    		$iz = 1;
			                    		foreach ($objPostpone['data'] as $index => $value) {
			                    			echo $objPostpone['data'][$index]['PostponeCode'].'|';
			                    		}
			                    					                    	
			                    		
			                    	}
		                    	
	                    		?>
					        </div>
					        <div class="toolbar fg-black nonprint" style="margin-top: 2px;">				         		
				         		<?php if(!empty($objPostpone['data'][0]['DocID'])) { ?>
					        	<span id="postpone_logs" class="tooltip-top show-pop-list" data-tooltip="Postpone Drawdown Reason History" data-placement="right">
					        		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
					        	</span>
					        	<span class="badge bg-lightBlue" style="position: absolute; margin-left: -12px; margin-top: -5px;">
					         		<?php    
					         		 
					                	if(!empty($objPostpone['data'][0]['DocID'])) {				         		 		
					         		 		if(!empty($badge['data'][0]['PostponeRef'])) {
					         		 			echo $badge['data'][0]['PostponeRef'];
					         		 		}
					         		 		
					         		 	}
					                    	
					                ?>
					         	</span>	
					         	<?php } ?>		
				        	</div>
					    </div>
				    </div>
				    
				    <div id="postpone_reasonarea" style="display: none;">
                    	<?php 
                    	
                    		if(!empty($badge['data'][0]['OrginalPlanDate'])) {
                    			echo '<span class="text-muted marginBottom15">Previous Plan Date : ' . StandartDateRollback($badge['data'][0]['OrginalPlanDate']) . '</span>';
                    		}
                    	
	                    	if(empty($objPostpone['data'][0]['DocID'])) {
	                    		echo "<div>ไม่พบข้อมูล</div>";
	                    		
	                    	} else {
	                    		
	                    		$iz = 1;
	                    		foreach ($objPostpone['data'] as $index => $value) {
	                    	
	                    			if(!empty($objPostpone['data'][$index]['PostponeDesc'])):
	                    				$text_postponereason = $objPostpone['data'][$index]['PostponeReason']. ' ' .$objPostpone['data'][$index]['PostponeDesc'] . ' (ครั้งที่' . $objPostpone['data'][$index]['PostponeRef'] . ')';
	                    			else:
	                    				$text_postponereason = $objPostpone['data'][$index]['PostponeReason'] . ' (ครั้งที่ ' . $objPostpone['data'][$index]['PostponeRef'] . ')';
	                    			endif;
	                    	
	                    			echo "<div>". $iz .'. '. $text_postponereason ."</div>";
	                    	
	                    			$iz++;
	                    		}
	                    	
	                    	}
                    	
                    	?>
                    </div>
				    
                    <?php 
                    	$dd_loan = !empty($results['data'][0]['DrawdownBaht']) ? $results['data'][0]['DrawdownBaht']:""; 
                    	$dd_total = !empty($results['data'][0]['TotalDrawdown']) ? number_format($results['data'][0]['TotalDrawdown'], 0):"";
                    	$dd_date = !empty($results['data'][0]['DrawdownDate']) && ($results['data'][0]['DrawdownDate'] != '1900-01-01') ? trim(StandartDateRollback($results['data'][0]['DrawdownDate'])):"";
                    ?>
                    
                    <div class="span12" <?php if(trim($dd_loan) == "") echo 'style="display: none;"'; ?>>
                        <div class="input-control">
                            <label class="span4 text-blue">Drawdown Loan / Date (Latest)</label>
                            <div class="input-control text span3" style="margin-left: 20px; margin-right: 5px; max-width: 190px;">
                                <input type="text" value="<?php echo $dd_loan; ?>" disabled="disabled">
                            </div>
                             <div class="input-control text span2" style="max-width: 105px;">
                        		 <input type="text" value="<?php echo $dd_date; ?>" disabled="disabled">
                        	</div>
                        </div>
                    </div>
                    
                       <div class="span12" <?php echo empty($dd_history['data'][1]['ApplicationNo']) ? 'style="display: none;"':''; ?>>
                        <div class="input-control text">
                            <label class="span4 text-blue">Total Drawdown Loan</label>
                            <input  value="<?php echo $dd_total; ?>" class="span4" readonly="readonly" disabled="disabled">
                            <div class="toolbar fg-black nonprint" style="margin-top: 2px;">
	                        	<span id="drawdown_icon_history" class="tooltip-top show-pop-list" data-tooltip="Drawdown History" data-placement="right">
	                        		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-left: 5px; margin-top: 0px;"></i>
	                        	</span>
                        	</div>
                        </div>                     
                    </div>
                    
                    <div id="drawdown_area_history" class="drawdown_history" style="display: none;">
                    <?php 
                    	if(empty($dd_history['data'][0]['ApplicationNo'])) {
                    		echo "<div>ไม่พบข้อมูล</div>";
                    		 
                    	} else {
                    		 
                    		$listno = 1;
                    		foreach ($dd_history['data'] as $index => $value) {
                    			echo $listno. '. ' . StandartDateRollback($dd_history['data'][$index]['DrawdownDate']) . ' - ' . number_format($dd_history['data'][$index]['DrawdownLoan'], 0) . ' Baht <br/>';
                    			$listno++;
                    			
                    		}
                    	
                    	}
                    	
                    ?>
                    </div>
               
					<?php $dd_type = !empty($results['data'][0]['DrawdownType']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['DrawdownType']):""; ?>
                    <div class="span12" <?php if(trim($dd_type) == "") echo 'style="display: none;"'; ?>>
                        <div class="input-control text">                        	
                            <label class="span4 text-blue">Drawdown Type</label>
                            <div class="input-control text span4" style="margin-left: 20px;">
                            	<input type="text" value="<?php echo $dd_type; ?>" disabled="disabled">
                            </div>
                        </div>
                    </div>

					<?php $termyear = !empty($results['data'][0]['TermYear']) ? $results['data'][0]['TermYear']." Years":""; ?>
                    <div class="span12" <?php if(trim($termyear) == "") echo 'style="display: none;"'; ?>>
                        <div class="input-control text">
                            <label class="span4 text-blue">Term </label>
                            <div id="vtermyear" class="span2">
                            	<input type="text" value="" disabled="disabled">
                            	<input type="hidden" name="termyear" id="termyear" value="<?php echo $termyear; ?>">
                            </div>
                            <div id="termmonth" class="input-control span2" style="margin-top: 3px; margin-left: 4px;"></div>
                        </div>
                    </div>
                    
                     <div class="span12">
                        <div class="input-control text">
                            <label class="span4">Received Contract Date</label>
                            <div class="input-control text span4" id="objContractdate" style="margin-left: 20px;">
                                <input type="text" value="<?php echo !empty($results['data'][0]['ReceivedContactDate']) && ($results['data'][0]['ReceivedContactDate'] != '1900-01-01') ? trim(StandartDateRollback($results['data'][0]['ReceivedContactDate'])):""; ?>" disabled="disabled">
                            </div>
                            <span class="fg-amber nonprint">&nbsp;<small> (HQ)</small></span>
                        </div>                    
                    </div>                   
   
                    <div class="span12">
                        <div class="input-control textarea">
                            <label class="span4">Remark</label>
                            <textarea id="contact_comment" name="contact_comment" type="text" rows="5" class="span4" disabled="disabled"><?php echo !empty($results['data'][0]['ContactRemark']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['ContactRemark']):""; ?></textarea> 
                            <span class="fg-amber nonprint">&nbsp;<small> (HQ)</small></span>                          
                        </div>
                    </div>

                    <div class="span12" style="display: none;">
                        <div class="input-control text">
                            <label class="span4 text-blue">Diff (DD Loan: Approved Loan)</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['Diff']) ? $results['data'][0]['Diff']:"0"; ?>" disabled="disabled">
                            </div>
                            <span class="fg-amber nonprint">&nbsp;<small> (Auto)</small></span>
                        </div>
                    </div>

                    <div class="span12" style="display: none;">
                        <div class="input-control text">
                            <label class="span4 text-blue">Count Day (DD Date: Approved Date)</label>
                            <div class="span4" id="countday">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['CountDay']) ? $results['data'][0]['CountDay']:"0"; ?>" disabled="disabled">
                            </div>
                            <span class="fg-amber nonprint">&nbsp;<small> (Auto)</small></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
        <span class="span12" style="margin-top: 5px; margin-bottom: 20px; padding-left: 25px;"><small><u>หมายเหตุ :</u> ข้อมูลที่มีการอัพเดทอัตโนมัติจะมีตัวอักษรเป็นสีฟ้า</small></span>
        
        <div id="form_footer">
	    	<img src="<?php echo base_url('img/logo_form_footer.jpg'); ?>" style="margin-top: 5px;">
		</div>

    </div>
</div>
</div>
<?php

echo "
	<script>
		
	$(function() {
	
		var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + '//' + window.location.host;
	    var pathFixed = window.location.protocol + '//' + window.location.host;
	    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += '/'; }
	    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += '/'; }
	    var query  = getQueryParams(document.location.search);
	  
	    $('title').html('AP-P3 : ' + $('#borrowername_title').val());
	  
	    $('#appprogress ul li:first-child').append('<div class=\"text-muted\" style=\"min-width: 150px; margin-top: 2em; margin-left: -1em;\">PROFILE</div>');
	    $('#appprogress ul li:nth-child(2)').append('<div class=\"text-muted\" style=\"min-width: 180px; margin-top: 2em; margin-left: -2.5em;\">VERIFICATION</div>');
	    $('#appprogress ul li:nth-child(3)').append('<div class=\"text-muted\" style=\"min-width: 250px; margin-top: 2em; margin-left: -4.2em;\">APPLICATION STATUS</div>');
	  
	    $('#appprogress ul li:first-child').on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P1&live=2'; });
	    $('#appprogress ul li:nth-child(2)').on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P2&live=2'; });
	    $('#appprogress ul li:nth-child(3)').on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P3&live=2'; });

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

	});
		
	</script>
";

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