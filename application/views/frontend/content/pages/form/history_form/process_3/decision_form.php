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

</style>
<div class="container">

	<div class="grid">
	    <div id="form" class="row">
	
			<div class="logo_header">
				<img src="<?php echo base_url('img/logo_form_header.jpg'); ?>">
			</div>
	    
	        <div id="form-header" class="col-sm-12 col-md-12 col-lg-12">
	            <h2>APPLICATION STATUS : HISTORY</h2>
	        </div>
	        
	        <div class="profile-progress">
	            <h2>APPLICATION PROGRESS STATUS</h2>
	            <div id="appProgressHistory" class="stepper" data-role="stepper" data-steps="3" data-start="4"></div>
        	</div>
	        
			 <div id="form-frame">
            	<div class="grid">
	                <div class="row">
				
						<!-- PANEL  -->
						<div id="panel_criteria" class="panel span12" data-role="panel" style="min-height: 30px; margin-left: 20px; margin-bottom: 10px;">
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
                            <label class="span4">Application No</label>
                            <div class="span4"><input type="text" value="<?php echo !empty($results['data'][0]['ApplicationNo']) ? $results['data'][0]['ApplicationNo']:""; ?>" disabled="disabled"></div>
                        </div>
                    </div>
                    
                    <div class="span12">
                    	<label class="span4 text-blue">CA Name</label>
                        <div class="input-control text span3" >                         
                            <input style="margin-left: 20px; max-width: 195px;" type="text" value="<?php echo !empty($results['data'][0]['CAName']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['CAName']):""; ?>" disabled="disabled">
                        </div>
                        <div class="input-control text span2">
                        	<input id="careceived_date" name="careceived_date" type="text" value="<?php echo !empty($results['data'][0]['CA_ReceivedDocDate']) ? StandartDateRollback($results['data'][0]['CA_ReceivedDocDate']):""; ?>" class="size2" style="max-width: 100px;"  disabled="disabled">
                        </div>
                    </div>
                    
                    <div class="span12">
                        <div class="input-control textarea">
                            <label class="span4 text-blue">Comment</label>
                            <textarea type="text" rows="5" class="span4" disabled="disabled"><?php echo !empty($results['data'][0]['AppComment']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['AppComment']):""; ?></textarea>
                             <span id="objFixed" class="none" style="margin-left: 10px; font-size: 1.3em;" data-hint="ขยายข้อความ" data-hint-position="top">
                                <i class="icon-menu fg-lightBlue" style="margin-top: 2em;"></i>
                            </span>
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
                    
                    <div class="span12">
                        <div class="input-control text">
                        	<?php $status = !empty($results['data'][0]['Status']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Status']):""; ?>
                        	<?php 
                            		switch ($status) {
										
                            			case 'PENDING':
                            				$state = "P";
                            				break;
										case 'APPROVED':
											$state = "A";
											break;
										case 'PREAPPROVED':
											$state = "PA";
											break;
										case 'REJECT':
											$state = "R";
											break;
										case 'CANCEL':
										case 'CANCELBYRM':
										case 'CANCELBYCUS':
										case 'CANCELBYCA':
											$state = "C";
											break;
										default:
											$state = "";
											break;
				
									}
                            	
                            	?>
                            <label class="span4 text-blue">Status</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo !empty($state) ? $state:""; ?>" disabled="disabled" class="size1">
                            </div>
                        </div>
                    </div>
                    
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Status Date</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['StatusDate']) && ($results['data'][0]['StatusDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['StatusDate']):""; ?>" disabled="disabled">
                            </div>
                        </div>
                    </div>
                    
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Status Reason</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo!empty($results['data'][0]['StatusReason']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['StatusReason']):""; ?>" disabled="disabled">
                            </div>
                        </div>
                    </div>
                    
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Approved Loan</label>
                            <input type="text" value="<?php echo !empty($results['data'][0]['ApprovedLoan']) ? number_format(trim($results['data'][0]['ApprovedLoan']), 0):"0"; ?>" class="span4" disabled="disabled">
                            <div class="span1" style="color: #d2322d;"></div>
                            <div id="apploan_alert" class="span3 text-alert"></div>
                        </div>
                    </div>

                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Term </label>
                            <div id="vtermyear" class="span2">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['TermYear']) ? $results['data'][0]['TermYear']." Years":""; ?>" disabled="disabled">
                            	<input type="hidden" name="termyear" id="termyear" value="<?php echo !empty($results['data'][0]['TermYear']) ? $results['data'][0]['TermYear']:""; ?>">
                            </div>
                            <div id="termmonth" class="input-control span2" style="margin-top: 3px; margin-left: 4px;"></div>
                        </div>
                    </div>
                    
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4">Cancel Reason (After Approved)</label>
                            <div class="input-control text span4" style="margin-left: 20px;">
                                <input type="text" id="afcancel_other" name="afcancel_other" value="<?php echo !empty($results['data'][0]['AFCancelReason']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['AFCancelReason']):""; ?>" disabled="disabled">
                            </div>
                        </div>
                    </div>
                    
                    <?php 
                    
                   		$afother_note = !empty($results['data'][0]['AFCancelReasonOther']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['AFCancelReasonOther']):""; 
                    	if(!empty($afother_note)):
                    	
                    		echo '<div class="span12">
			                        <div class="input-control text">
			                            <label class="span4">Other Reason</label>
			                            <div class="input-control text span4" style="margin-left: 20px;">
			                                <input type="text" id="afcancel_other" name="afcancel_other" value="'.$afother_note.'" disabled="disabled">
			                            </div>
			                        </div>
			                      </div>';                    	
                    	endif;
                    	
                    
                     ?>
                    
          
                     <div class="span12">
                        <div class="input-control text">
                            <label class="span4">Drawdown Plan Date</label>
                            <div class="input-control text span4" style="margin-left: 20px;">
                                <input type="text" value="<?php echo !empty($results['data'][0]['PlanDrawdownDate']) && ($results['data'][0]['PlanDrawdownDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['PlanDrawdownDate']):""; ?>" disabled="disabled">
                            </div>
                        </div>
                    </div>

                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Drawdown Actual Date</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['DrawdownDate']) && ($results['data'][0]['DrawdownDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['DrawdownDate']):""; ?>" disabled="disabled">
							</div>
                        </div>
                    </div>

                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Drawdown Type</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['DrawdownType']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['DrawdownType']):""; ?>" disabled="disabled">
                            </div>
                        </div>
                    </div>

                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Drawdown (Baht)</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['DrawdownBaht']) ? number_format($results['data'][0]['DrawdownBaht'], 0):""; ?>" disabled="disabled">
                            </div>
                        </div>
                    </div>
                    
                     <div class="span12">
                        <div class="input-control text">
                            <label class="span4">Received Contract Date</label>
                            <div class="input-control text span4" id="objContractdate" style="margin-left: 20px;">
                                <input type="text" value="<?php echo !empty($results['data'][0]['ReceivedContactDate']) && ($results['data'][0]['ReceivedContactDate'] != '1900-01-01') ? trim(StandartDateRollback($results['data'][0]['ReceivedContactDate'])):""; ?>" disabled="disabled">
                            </div>
                            <span class="fg-amber">&nbsp;<small> (HQ)</small></span>
                        </div>                    
                    </div>                   
   
                    <div class="span12">
                        <div class="input-control textarea">
                            <label class="span4">Remark</label>
                            <textarea id="contact_comment" name="contact_comment" type="text" rows="5" class="span4" disabled="disabled"><?php echo !empty($results['data'][0]['ContactRemark']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['ContactRemark']):""; ?></textarea> 
                            <span class="fg-amber">&nbsp;<small> (HQ)</small></span>                          
                        </div>
                    </div>

                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Diff (DD Loan: Approved Loan)</label>
                            <div class="span4">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['Diff']) ? $results['data'][0]['Diff']:"0"; ?>" disabled="disabled">
                            </div>
                            <span class="fg-amber">&nbsp;<small> (Auto)</small></span>
                        </div>
                    </div>

                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Count Day (DD Date: Approved Date)</label>
                            <div class="span4" id="countday">
                            	<input type="text" value="<?php echo !empty($results['data'][0]['CountDay']) ? $results['data'][0]['CountDay']:"0"; ?>" disabled="disabled">
                            </div>
                            <span class="fg-amber">&nbsp;<small> (Auto)</small></span>
                        </div>
                    </div>

					</div>
				</div>
			</div>
	    
	    </div>
    </div>
    
</div>

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