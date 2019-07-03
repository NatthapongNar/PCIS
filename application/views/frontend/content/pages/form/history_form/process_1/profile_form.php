<style>

   .panel-header-custom { 
   		font-size: 1.1em !important;
   		font-weight: bold;
    }
    
    .panel-content {
    	min-height: 300px;
    	max-height: 300px;
    	max-width: 1000px;
    	overflow-y: scroll; 
    }

</style>

<div class="container">
	<div class="grid">
		<div id="form" class="row">
		
			<div id="form-header" class="col-sm-12 col-md-12 col-lg-12">
		   	 <h2>CUSTOMER PROFILE : HISTORY</h2>
			</div>
			
			<div class="profile-progress">
			    <h2>APPLICATION PROGRESS STATUS</h2>
			    <div id="appProgressHistory" class="stepper" data-role="stepper" data-steps="3" data-start="4"></div>
			</div>
			
			<article class="span12">
			
				<fieldset>
					<legend>Customer Information</legend>
					
					<!-- PANEL  -->
				<div id="panel_criteria" class="panel span12" data-role="panel" style="min-height: 30px; min-width: 950px; margin-bottom: 10px;">
					<div class="panel-header bg-lightBlue fg-white" style="font-size: 1em;"><i class="icon-user-3 on-left"></i>View Information</div>
					<div class="panel-content" style="display: none;">
						
						<div class="row" style="width: 1000px;">
						
							<div class="span6 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลลูกค้า</label></div>
							<div class="span6 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลพนักงาน</label></div>
							
							<div class="span6">
								<label class="label span2 text-left">ชื่อ - นามสกุล</label>	
								<?php $prefix 	= !empty($getCustInfo['PrefixName']) ? $getCustInfo['PrefixName']:""; ?>
								<?php $custname = !empty($getCustInfo['OwnerName']) ? $getCustInfo['OwnerName']:""; ?>								
								<div class="label span4 text-left"><?php echo $prefix. ' ' .$custname;  ?></div>
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
					
					<div class="span12">
				        <div class="input-control">
				        <label class="span4">Create Date</label>
				            <div class="input-control text span3" id="objcreatedate" style="margin-left: 20px;">
				               	<input type="text" id="createdate" name="createdate" value="<?php echo !empty($results['data'][0]['CreateDate']) ? StandartDateRollback($results['data'][0]['CreateDate']):""; ?>" disabled="disabled">
				                <div class="btn-date"></div>
								</div>
				        </div>
				    </div>
					
					<?php $customer = !empty($results['data'][0]['SourceOfCustomer']) ? $results['data'][0]['SourceOfCustomer']:""; ?>
					<div class="span12">
					    <div class="input-control text">
					        <label class="span4">Source of customer</label>
					        <div class="span3"><input type="text" value="<?php echo $customer; ?>" disabled="disabled"></div>
					    </div>
					</div>
					
					<?php 
					
					$sourceoption = !empty($results['data'][0]['sourceoption']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['sourceoption']):"";
				    if($customer == "อื่นๆ") {
				
				        echo "
				        <div class=\"span12\">
				            <div class=\"input-control textarea\">
				                <div class=\"span4\">โปรดระบุ:</div>
				                <textarea name=\"sourceoption\" id=\"sourceoption\" class=\"span4\" cols=\"35\" rows=\"3\" style=\"font-size: 0.8em; font-weight: normal;\">".$sourceoption."</textarea>
				            </div>
				        </div>";
				        
				    }
					
				    ?>
					
					<div class="span12">
				        <?php $interest = !empty($results['data'][0]['Interest']) ? $results['data'][0]['Interest']:""; ?>
				            <label class="span4">สนใจใช้บริการสินเชื่อ</label>
				            <div class="input-control radio" style="margin-left: 20px;">
				                <label>
				                    <input type="radio" name="interest" value="สนใจ" <?php if($interest == 0) echo "checked"; ?> disabled>
				                    <span class="check"></span> สนใจ
				                </label>
				            </div>
				            <div class="input-control radio" style="margin-left: 5px;">
				                <label>
				                    <input type="radio" name="interest" value="ไม่สนใจ" <?php if($interest == 1) echo "checked"; ?> disabled>
				                    <span class="check"></span> ไม่สนใจ
				                </label>
				            </div>
				            <div class="input-control radio" style="margin-left: 5px;">
				                <label>
				                    <input type="radio" name="interest" value="กลับมาสนใจ" <?php if($interest == 2) echo "checked"; ?> disabled>
				                    <span class="check"></span> กลับมาสนใจ
				                </label>
				            </div>
					</div>
					
					<div class="span12">
				    		<?php $potential = !empty($results['data'][0]['CSPotential']) ? (int)$results['data'][0]['CSPotential']:""; ?>		
					        <div class="input-control radio" data-hint="Customer Potential|ส่วนประเมินลูกค้าว่าอยู่ในเกณฑ์ใด ซึ่งการประเมินนี้ เป็นการประเมินศักยภาพในการทำสินเชื่อของลูกค้าในอนาคต." data-hint-position="right">
					            <label class="span4">โอกาสการเป็นลูกค้า</label>
					            <div class="input-control radio" style="margin-left: 20px;">
					                <label>
					                    <input type="radio" name="potential" value="0" <?php if($potential == 0) echo "checked"; ?> disabled="disabled">
					                    <span class="check"></span> H
					                </label>
					            </div>
					            <div class="input-control radio" style="margin-left: 30px;">
					                <label>
					                    <input type="radio" name="potential" value="1" <?php if($potential == 1) echo "checked"; ?> disabled="disabled">
					                    <span class="check"></span> M
					                </label>
					            </div>
					            <div class="input-control radio" style="margin-left: 42px;">
					                <label>
					                    <input type="radio" name="potential" value="2" <?php if($potential == 2) echo "checked"; ?> disabled="disabled">
					                    <span class="check"></span> L
					                </label>
					            </div>
					        </div>
				 	</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <?php $ownertype = !empty($results['data'][0]['OwnerType']) ? $results['data'][0]['OwnerType']:""; ?>
					        <div class="input-control text" style="margin: 10px 0;">
					            <div class="span4">
					                <div class="span4">
					                    <div class="input-control radio" style="margin-top: -20px;">
					                        <label class="span4">
					                            <input name="ownertype" type="radio" value="ชื่อเจ้าของกิจการ" <?php if($ownertype == 0) echo "checked"; ?> disabled>
					                            <span class="check"></span> ชื่อเจ้าของกิจการ
					                        </label>
					                        <label class="span4" style="margin-left: 1px;">
					                            <input name="ownertype" type="radio" value="ชื่อผู้ติดต่อ" <?php if($ownertype == 1) echo "checked"; ?> disabled>
					                            <span class="check"></span> ชื่อผู้ติดต่อ
					                        </label>
					                    </div>
					                </div>
					            </div>
					            <div class="span3">
					            	<?php $prefixname = !empty($results['data'][0]['PrefixName']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['PrefixName']):""; ?>
					            	<?php $ownername = !empty($results['data'][0]['OwnerName']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['OwnerName']):""; ?>
					            	<input type="text" value="<?php echo $prefixname.' '.$ownername;  ?>" disabled="disabled">
					            	<input id="owner" type="hidden" value="<?php echo $ownername; ?>">
					            </div>
					        </div>
					    </div>
					</div>
					
					<div class="span12" style="margin-top: 3px;">
					    <div class="input-control text">
					        <div class="span4">ชื่อสถานที่ประกอบการ</div>
					        <div class="span3">
					        	<?php $prefixcorp = !empty($results['data'][0]['PrefixCorp']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['PrefixCorp']):""; ?>
					        	<?php $company 	  = !empty($results['data'][0]['Company']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Company']):""; ?>
					        	<input type="text" value="<?php echo $prefixcorp.' '.$company; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">ประเภทธุรกิจ</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['BusinessType']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['BusinessType']):""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">ธุรกิจ / กิจการเกี่ยวกับ</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['Business']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Business']):""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">เบอร์ติดต่อ</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['Telephone']) ? $results['data'][0]['Telephone']:""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">เบอร์มือถือ</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['Mobile']) ? $results['data'][0]['Mobile']:""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">ย่านธุรกิจ</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['Downtown']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Downtown']):""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div id="textarea_add" class="input-control text">
					        <div class="span4">ที่อยู่</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['Address']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Address']):""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">จังหวัด</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['Province']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Province']):""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">อำเภอ</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['District']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['District']):""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">รหัสไปรษณีย์</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['Postcode']) ? $results['data'][0]['Postcode']:""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">รับทราบจากช่องทางสื่อ</div>
					        <div class="span3" data-hint="<?php echo !empty($results['data'][0]['SubChannel']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['SubChannel']):""; ?>" data-hint-position="right">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['SubChannel']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['SubChannel']):""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					
					<div class="span12">
					    <div class="input-control text">
					         <div class="span4">ประเภทช่องทางสื่อ</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['Channel']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Channel']):""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">วงเงินที่ต้องการ (บาท)</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['RequestLoan']) ? number_format($results['data'][0]['RequestLoan'], 0):""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">วันนัดพบครั้งถัดไป</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['Subject']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Subject']):""; ?>" disabled="disabled">
					        </div>
					        <div class="span2">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['DueDate']) ? StandartDateRollback($results['data'][0]['DueDate']):""; ?>" disabled="disabled">
					        </div>
					        <div class="input-control checkbox">
					        	<?php $endEvent = (int)!empty($results['data'][0]['IsRepeat']) ? $results['data'][0]['IsRepeat']:""; ?>
								<label style="margin-left: 5px; margin-top: 2px;">
									<input type="checkbox" name="endevent" id="endevent" value="1" <?php if($endEvent == 1) echo "checked"; ?> disabled>
									<span class="check"></span> <i class="fa fa-bell-slash-o"></i> End Event
								</label>
							</div>
					    </div>
					</div>
					
					<div class="span12">
						 <?php $criteria = !empty($results['data'][0]['BasicCriteria']) ? intval($results['data'][0]['BasicCriteria']):""; ?>
				    	<label class="span4">Basic Criteria <span class="text-warning"><small>(กรุณีลูกค้าไม่ผ่านเกณฑ์เบื้องต้นคลิก)</small></span></label>
				       	<div class="input-control checkbox span1" >
				        <label>
				        	<input type="checkbox" id="criteria" name="criteria" value="1" <?php if(intval($criteria) == 0) echo "checked"; ?> disabled="disabled">
				        	<span class="check"></span>
				        </label>
				        </div>
				        <div class="input-control text span4" style="margin-left: -30px; max-width: 190px;">
				            <input type="text" value="<?php echo !empty($results['data'][0]['CriteriaReason']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['CriteriaReason']):""; ?>" disabled="disabled">
				        </div>
					</div>
					
					<div class="span12">
					    <div class="input-control text">
					        <div class="span4">Referral Code</div>
					        <div class="span3">
					        	<input type="text" value="<?php echo !empty($results['data'][0]['ReferralCode']) ? $results['data'][0]['ReferralCode']:""; ?>" disabled="disabled">
					        </div>
					    </div>
					</div>
					
					<div class="span12">
					    <div class="input-control textarea">
					        <div class="span4">Remark</div>
					        <div class="span3">
					        	<textarea disabled="disabled"><?php echo !empty($results['data'][0]['Remark']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Remark']):""; ?></textarea>
					        </div>
					    </div>
					</div>
				
				
				</fieldset>
			
			</article>
			
			
		
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