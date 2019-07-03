<div class="listview small" style="position: fixed;  ">
   <a href="<?php echo site_url('metro/appProgress?_=').date('s').'&cache=false&secure='.md5(true).'&rel='.$_GET['rel']; ?>" class="list" style="max-width: 130px;">
       <div class="list-content">
           <i class="icon icon-home"></i>
            <div class="data">
               <span class="list-title" style="margin-top: 8px;">HOME</span>
            </div>
        </div>
    </a>
    <a href="<?php echo site_url('metro/routers?_=').date('s').'&cache=false&secure='.md5(true).'&rel='.$_GET['rel'].'&req=P2&live=1'; ?>" class="list" style="max-width: 130px;">
        <div class="list-content">
           <i class="icon icon-eye"></i>
            <div class="data">
               <span class="list-title" style="margin-top: 8px;">PREVIEW</span>
            </div>
        </div>
    </a>
    <a href="#" class="list selected" style="max-width: 130px;">
        <div class="list-content">
           <i class="icon icon-pencil"></i>
            <div class="data">
               <span class="list-title" style="margin-top: 8px;">EDIT DATA</span>
            </div>
        </div>
    </a>
    <a href="#" class="list" style="max-width: 130px;">
        <div class="list-content">
           <i class="icon icon-pencil"></i>
            <div class="data">
               <span class="list-title" style="margin-top: 8px;">SUBMIT</span>
            </div>
        </div>
    </a>
</div>

<div class="container">

<div class="grid">
	<div id="form" class="row">
	
	<div class="logo_header">
		<img src="<?php echo base_url('img/logo_form_header.jpg'); ?>">
	</div>
	
	<div id="form-header" class="col-sm-12 col-md-12 col-lg-12">
	    <h2>VERIFICATION PROCESS</h2>
	</div>
	
	<div class="profile-progress">
	    <h2>APPLICATION PROGRESS STATUS</h2>
	    <div id="appProgress" class="stepper" data-role="stepper" data-steps="3" data-start="2"></div>
	</div>
	
	<div id="form-frame">
	<div class="grid">
	<div class="row">
	<div class="span12" style="margin-bottom: 5px;"><h3>VERIFICATION</h3></div>

	<?php $this->load->library('effective'); ?>
	<div class="span12">

    <?php $this->load->helper('form'); ?>
    <?php $attributes = array('id' => 'verification_forms'); ?>
    <?php echo form_open('metro/verificationFormInitialyze', $attributes); ?>
	<fieldset>
	    <legend style="font-size: 1.2em;">ส่วนที่ 1: กระบวนการตรวจสอบ</legend>
	    
	    <div class="span12">
	        <label class="span4" data-hint="Identify Card|เลขบัตรประชาชน" data-hint-position="top">ID Card</label>
	        <div class="input-control text span4" style="margin-left: 20px;">
	            <input type="text" id="id_card" name="id_card" value="<?php echo !empty($results['data'][0]['ID_Card']) ? $results['data'][0]['ID_Card']:""; ?>" maxlength="13 ">
	        </div>
	        <div class="span1" style="color: #d2322d;"></div>
	        <div id="ncbdate_alert" class="span3 text-danger"></div>
	    </div>
	    
	    <div class="span12">
	        <div class="input-control select">
	            <label class="span4">Product Program</label>
	            <select name="productprg" id="productprg" class="span4"></select>
	            <div id="pro_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"> Loading...</div>
	            <input type="hidden" name="doc_id" id="doc_id" value="<?php echo !empty($results['data'][0]['DocID']) ? $results['data'][0]['DocID']:""; ?>">
	            <input type="hidden" name="productcode_hidden" id="productcode_hidden" value="<?php echo !empty($results['data'][0]['ProductCode']) ? $results['data'][0]['ProductCode']:""; ?>">
	        </div>
	    </div>
	
		<!-- Basic Criteria Holding
	    <div class="span12">
	        <div class="input-control radio">
	            <?php $criteria = !empty($results['data'][0]['BasicCriteria']) ? intval($results['data'][0]['BasicCriteria']):""; ?>
	            <label class="span4">Basic Criteria <span style="color: #d2322d;">*</span></label>
	            <div class="input-control radio" style="margin-left: 20px;">
	                <label>
	                    <input type="radio" name="criteria" value="1" <?php if(intval($criteria) == 1) echo "checked"; ?>>
	                    <span class="check"></span> ผ่าน
	                </label>
	            </div>
	            <div class="input-control radio" style="margin-left: 29px;">
	                <label>
	                    <input type="radio" name="criteria" value="0" <?php if(intval($criteria) == 0) echo "checked"; ?>>
	                    <span class="check"></span> ไม่ผ่าน
	                </label>
	            </div>
	        </div>
	        <div class="input-control radio">
	            <div id="criteria_alert" class="span3 text-danger"></div>
	        </div>
	    </div>
	    -->
	
	    <div class="span12" >
	        <div class="input-control select">
	            <?php $checkncb = !empty($results['data'][0]['CheckNCB']) ? intval($results['data'][0]['CheckNCB']):""; ?>
	            <label class="span4">Check NCB <span style="color: #d2322d;">*</span></label>
	            <div class="input-control radio" style="margin-left: 20px;">
	                <label>
	                    <input type="radio" name="checkncb" value="1" <?php if($checkncb == 1) echo "checked"; ?>>
	                    <span class="check"></span> ผ่าน
	                </label>
	            </div>
	            <div class="input-control radio" style="margin-left: 29px;">
	                <label>
	                    <input type="radio" name="checkncb" value="2" <?php if($checkncb == 2 && $checkncb != '') echo "checked"; ?>>
	                    <span class="check"></span> ไม่ผ่าน
	                </label>
	            </div>
	            <div class="input-control radio" style="margin-left: 29px;">
	                <label>
	                    <input type="radio" name="checkncb" value="3" <?php if($checkncb == 3) echo "checked"; ?>>
	                    <span class="check"></span> Deviate
	                </label>
	            </div>
	            <div class="input-control radio">
	                <div id="checkncb_alert" class="span3 text-danger"></div>
	            </div>
	            
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control">
	            <label class="span4">&nbsp;</label>
	        </div>
	        <?php $mainloan = !empty($results['data'][0]['MainLoan']) ? $results['data'][0]['MainLoan']:""; ?>
	        <div class="input-control checkbox span2" style="margin-left: 20px;">
	            <label>
	                <input type="checkbox" name="mainloan" id="mainloan" value="1" <?php if($mainloan == '1') echo "checked"; ?>>
	                <span class="check"></span> กู้หลัก
	            </label>
	        </div>
	        <div class="input-control text span3" style="margin-left: -50px; max-width: 210px;">
	            <input type="text" name="loanname" id="loanname"  value="<?php echo !empty($results['data'][0]['MainLoanName']) ? @iconv("TIS-620", "UTF-8", $results['data'][0]['MainLoanName']):@iconv("TIS-620", "UTF-8", $results['data'][0]['OwnerName']); ?>" placeholder="ชื่อ นามสกุล">
	        </div>
	        <div class="span1" style="color: #d2322d;">*</div>
	        <div id="loan_alert" class="span3 text-danger"></div>
	    </div>
	
	    <div class="span12">
	        <label class="span4">&nbsp;</label>
	        <?php
	        
	            $joinloan   = !empty($results['data'][0]['JoinLoan']) ? $results['data'][0]['JoinLoan']:"";
	            $joinloan2  = !empty($results['data'][0]['JoinLoan2']) ? $results['data'][0]['JoinLoan2']:"";
	            $joinloan3  = !empty($results['data'][0]['JoinLoan3']) ? $results['data'][0]['JoinLoan3']:"";
	            $joinloan4  = !empty($results['data'][0]['JoinLoan4']) ? $results['data'][0]['JoinLoan4']:"";
	            
	        ?>
	        <div class="input-control checkbox" style="margin-left: 20px;">
	            <label>
	                <input type="checkbox" name="joinloan" id="joinloan" value="1" <?php if($joinloan == '1') echo "checked"; ?>>
	                <span class="check"></span> กู้ร่วม
	            </label>
	        </div>
	        <div class="input-control checkbox" style="margin-left: 25px;">
	            <label>
	                <input type="checkbox" name="joinloan2" id="joinloan2" value="1" <?php if($joinloan2 == '1') echo "checked"; ?>>
	                <span class="check"></span> กู้ร่วม 2
	            </label>
	        </div>
	        <div class="input-control checkbox" style="margin-left: 25px;">
	            <label>
	                <input type="checkbox" name="joinloan3" id="joinloan3" value="1" <?php if($joinloan3 == '1') echo "checked"; ?>>
	                <span class="check"></span> กู้ร่วม 3
	            </label>
	        </div>
	    </div>
		
	    <div class="span12">
	        <label class="span4">&nbsp;</label>
	        <?php
	            $corporate  = !empty($results['data'][0]['Corporation']) ? $results['data'][0]['Corporation']:"";
	            $guarantor = !empty($results['data'][0]['Guarantor']) ? $results['data'][0]['Guarantor']:"";
	        ?>
	        <div class="input-control checkbox" style="margin-left: 20px;">
	            <label>
	                <input type="checkbox" name="joinloan4" id="joinloan4" value="1" <?php if($joinloan4 == '1') echo "checked"; ?>>
	                <span class="check"></span> กู้ร่วม 4
	            </label>
	        </div>
	         <div class="input-control checkbox" style="margin-left: 13px;">
	            <label>
	                <input type="checkbox" name="guarantor" id="guarantor" value="1" <?php if($guarantor == '1') echo "checked"; ?>>
	                <span class="check"></span> ผู้ค้ำ
	            </label>
	        </div>
	        <div class="input-control checkbox" style="margin-left: 44px;">
	            <label>
	                <input type="checkbox" name="corporate" id="corporate" value="1" <?php if($corporate == '1') echo "checked"; ?>>
	                <span class="check"></span> นิติบุคคล
	            </label>
	        </div>
	       
	    </div>
	
	    <div class="span12">
	        <?php $this->load->library('effective'); ?>
	        <label class="span4">Check NCB Date</label>
	        <div class="input-control text span4" id="ClndrNCBDate" style="margin-left: 20px;">
	            <input type="text" id="checkncbdate" name="checkncbdate" value="<?php echo !empty($results['data'][0]['CheckNCBDate']) ? StandartDateRollback($results['data'][0]['CheckNCBDate']):""; ?>" placeholder="วันที่ตรวจสอบ NCB">
	            <button class="btn-clear" tabindex="-1" type="button" onclick="$('#checkncbdate').val('');"></button>
	        </div>
	        <div class="span1" style="color: #d2322d;">*</div>
	        <div id="ncbdate_alert" class="span3 text-danger"></div>
	    </div>
	    
	    <div class="span12">
	        <label class="span4">Submit NCB to HO</label>
	        <div class="input-control checkbox span1" >
	        <label>
	        	<?php $checker = !empty($results['data'][0]['BrnSentNCBDate']) && ($results['data'][0]['BrnSentNCBDate'] != '1900-01-01') ? true:false; ?>
	        	<input type="checkbox" name="BrnNCBDateChecker" id="BrnNCBDateChecker" <?php if($checker) echo "checked"; ?> style="margin-top: 5px;">
	        	<span class="check"></span>
	        </label>
	        </div>
	        <div id="objBrnNCBDate" class="input-control text span4" style="margin-left: -30px; max-width: 270px;">
	            <input type="text" id="BrnNCBDate" name="BrnNCBDate" value="<?php echo !empty($results['data'][0]['BrnSentNCBDate']) && ($results['data'][0]['BrnSentNCBDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['BrnSentNCBDate']):""; ?>">
	            <span class="btn-date"></span>
	        </div>
	    </div>      
	    
	    <div class="span12">
	        <label class="span4 hq_label">Received NCB from LB</label>
	        <div class="input-control checkbox span1" >
	        <label>
	        	<?php $checker = !empty($results['data'][0]['HQGetNCBDate']) && ($results['data'][0]['HQGetNCBDate'] != '1900-01-01') ? true:false; ?>
	        	<input type="checkbox" name="HQNCBChecker" id="HQNCBChecker" <?php if($checker) echo "checked"; if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?> style="margin-top: 5px;" readonly>
	        	<span class="check"></span>
	        </label>
	        </div>
	        <div id="objHQNCBDatee" class="input-control text span4" style="margin-left: -30px; max-width: 270px;">
	            <input type="text" id="HQNCBDate" name="HQNCBDate" value="<?php echo !empty($results['data'][0]['HQGetNCBDate']) && ($results['data'][0]['HQGetNCBDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['HQGetNCBDate']):""; ?>" <?php if($session_data['branchcode'] <> '000') { echo ' readonly="readonly"'; } ?>>
	            <span class="btn-date"></span>
	        </div>
	    </div>     
	    
	    <div class="span12">
	        <label class="span4 hq_label">Submit NCB to Oper</label>
	        <div class="input-control checkbox span1" >
	        <label>
	        	<?php $checker = !empty($results['data'][0]['HQSentNCBToOperDate']) && ($results['data'][0]['HQSentNCBToOperDate'] != '1900-01-01') ? true:false; ?>
	        	<input type="checkbox" name="HQSentToOperDateChecker" id="HQSentToOperDateChecker" <?php if($checker) echo "checked"; if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?> style="margin-top: 5px;">
	        	<span class="check"></span>
	        </label>
	        </div>
	        <div id="objSentToOperDate" class="input-control text span4" style="margin-left: -30px; max-width: 270px;">
	            <input type="text" id="HQSentToOperDate" name="HQSentToOperDate" value="<?php echo !empty($results['data'][0]['HQSentNCBToOperDate']) && ($results['data'][0]['HQSentNCBToOperDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['HQSentNCBToOperDate']):""; ?>" <?php if($session_data['branchcode'] <> '000') { echo ' readonly="readonly"'; } ?>>
	            <span class="btn-date"></span>
	        </div>
	        <div id="comment_tools" class="span2 fg-green genPlus" data-hint="Add Comment" data-hint-position="top">
	        	<i class="fa fa-plus-circle" ></i>
	        </div>
	    </div>     	    

	    <?php $objComments = !empty($results['data'][0]['Comments']) ? @iconv("TIS-620", "UTF-8", $results['data'][0]['Comments']):""; ?>
	    <div id="comment_parent" class="span12">
	        <div class="input-control textarea">
	            <label class="span4">Comment</label>
	            <textarea name="Comment" id="Comment" rows="3" class="span4"><?php echo !empty($results['data'][0]['Comments']) ? @iconv("TIS-620", "UTF-8", $results['data'][0]['Comments']):""; ?></textarea>
	        </div>
	    </div>


	    <div class="span12">
	        <?php $rmprocess = !empty($results['data'][0]['RMProcess']) ? @iconv("TIS-620", "UTF-8", $results['data'][0]['RMProcess']):""; ?>
	        <div id="parent_rmprocess" class="input-control select">
	            <label class="span4">RM Process</label>
	            <select name="rmprocess" id="rmprocess" class="span2 size2" style="min-width: 180px; height: 34px;">
	                <option value="">-- โปรดเลือก --</option>
	                <optgroup label="RM Process">
	                <option value="ระหว่างติดตามเอกสาร" <?php if($rmprocess == "ระหว่างติดตามเอกสาร") echo "selected"; ?>>ระหว่างติดตามเอกสาร</option>
	                <option value="ระหว่างคีย์เอกสารการเงิน" <?php if($rmprocess == "ระหว่างคีย์เอกสารการเงิน") echo "selected"; ?>>ระหว่างคีย์เอกสารการเงิน</option>
	                <option value="ระหว่างคำนวน DSCR" <?php if($rmprocess == "ระหว่างคำนวน DSCR") echo "selected"; ?>>ระหว่างคำนวน DSCR</option>
	                <option value="ระหว่างคีย์ Call Report" <?php if($rmprocess == "ระหว่างคีย์ Call Report") echo "selected"; ?>>ระหว่างคีย์ Call Report</option>
	                <option value="ระหว่างคีย์ Tels" <?php if($rmprocess == "ระหว่างคีย์ Tels") echo "selected"; ?>>ระหว่างคีย์ Tels</option>
	                <option value="Completed" <?php if($rmprocess == "Completed") echo "selected"; ?>>Completed</option>
	                </optgroup>
	                <optgroup label="Cancel">
	                <option value="CANCELBYRM" <?php if($rmprocess == "CANCELBYRM" || $rmprocess == "ยกเลิก โดย RM") echo "selected"; ?>>ยกเลิก โดย RM</option>
	                <option value="CANCELBYCUS" <?php if($rmprocess == "CANCELBYCUS" || $rmprocess == "ยกเลิก โดย ลูกค้า") echo "selected"; ?>>ยกเลิก โดย ลูกค้า</option>
	                </optgroup>
	            </select>
	                <div id="ClndrRMPD" class="input-control text span1 size2" style="margin-left: 5px; max-width: 115px;">
	                    <input type="text" id="rmprocessdate"  name="rmprocessdate" value="<?php echo !empty($results['data'][0]['RMProcessDate']) && ($results['data'][0]['RMProcessDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['RMProcessDate']):""; ?>">
	                	<span class="btn-date"></span>
	            </div>
	            <div class="span1" style="color: #d2322d;">*</div>
	            <div id="rmprocess_alert" class="span3 text-danger"></div>
	        </div>
	    </div>

	    <div class="span12">
	    	<label class="span4">&nbsp;</label>
	    	<div class="span4">
	    		<div class="listview-outlook" data-role="listview">
					<div class="list-group collapsed">
						<a href="" class="group-title">RM process logs</a>
						<div class="group-content">
							<a href="#" class="list">
							
								<?php 
								
									if(empty($rmlogs['data'][0])) {
										echo "<div class=\"list-content\">ไม่พบข้อมูล</div>";									

									} else {

										$data_split = array();
										foreach($rmlogs['data'] as $index => $values) {
												array_push($data_split, array("Process" => explode('-', $rmlogs['data'][$index]['ProcessName']), "RMDate" => $rmlogs['data'][$index]['ProcessDate'], "Runno" => $rmlogs['data'][$index]['Runno']));
										}
										
										
										foreach ($data_split as $index => $values) {
											echo '
				    							<div class="list-content">
													<span class="list-title"> # '.($index + 1).' : '.iconv("TIS-620", "UTF-8", $data_split[$index]['Process'][0]).'</span>
													<span class="list-subtitle">RM Action Date : '.$data_split[$index]['RMDate'].'</span>
													<span class="list-remark">RM Action By : '.iconv("TIS-620", "UTF-8", $data_split[$index]['Process'][1]).'</span>
												</div>';
									
										}
										

									}
								
									
									
								?>
								
							</a>
						</div>
					</div>
				</div>
	    	</div>	    
	    </div>
	    
	    <div class="span12">
	    <div class="span4" style="margin-right: 20px;">
	            <div>Re-Activate Plan <abbr title="เหตุผลที่ RM/ลค. ยกเลิกและนัดวันพบอีกครั้ง">[?]</abbr></div>
	        </div>
	        <div id="objreactivate" class="input-control select span2" style="min-width: 180px;">
	        	<input type="hidden" name="apv_hidden" id="apv_hidden" value="<?php echo !empty($results['data'][0]['RevisitID']) ? $results['data'][0]['RevisitID']:""; ?>">
	            <select id="reactivate" name="reactivate" style="height: 34px;"></select>
	        </div>
	        <div class="input-control text span2" id="revplan" style="max-width: 115px; margin-left: 5px;">
	            <input type="text" id="reactivatePlan" name="reactivatePlan" value="<?php echo !empty($results['data'][0]['RevisitDate']) && ($results['data'][0]['RevisitDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['RevisitDate']):""; ?>">
	            <button class="btn-clear" tabindex="-1" type="button" onclick="$('#reactivatePlan').val('');"></button>
	        </div>
	        <div id="ARP_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"> Loading...</div>
	        <div id="revisitText" class="span2" style="margin-top: 4px; cursor: pointer;">
	        	<?php echo !empty($results['data'][0]['RevisitRef']) ? 'REF: '.$results['data'][0]['RevisitRef']:""; ?>
	        </div>
	    </div>
		
	    <div class="span12">
	        <div id="resource_parent" class="input-control textarea">
	            <label class="span4">Action Note</label>
	            <textarea name="actionnote" id="actionnote" rows="3" class="span4"><?php echo !empty($results['data'][0]['ActionNote']) ? @iconv("TIS-620", "UTF-8", $results['data'][0]['ActionNote']):""; ?></textarea>
	        </div>
	    </div>
		
	    <div class="span12">
	        <?php $mrta = !empty($results['data'][0]['MRTA']) ? intval($results['data'][0]['MRTA']):""; ?>
	        <div class="input-control">
	            <label class="span4">MRTA <span class="text-warning"><small>(กรุณีลูกค้าสมัคร คลิก)</small></span></label>
	            <div class="input-control checkbox" style="margin-left: 20px;">
	                <label>
	                    <input type="checkbox" name="mrta" value="1" <?php if($mrta == 1) echo "checked"; ?>>
	                    <span class="check"></span> สมัคร
	                </label>
	            </div>
	        </div>
	    </div>
		
	    <div class="span12">
	        <div id="parent_ems" class="input-control text">
	            <label class="span4">EMS No / Submit document to HO.</label>
	            <input id="ems" name="ems" class="span2" maxlength="13" style="min-width: 160px; height: 34px;" value="<?php echo !empty($results['data'][0]['EMSNo']) ? $results['data'][0]['EMSNo']:""; ?>" data-hint="EMS No|โปรดระบุหมายเลข EMS หรือหากฝากบุคคลในสาขาถือเข้ามาต้องใส่เลขที่สาขาและระบุวันที่จัดส่งเอกสาร ตัวอย่าง: EN66942463TH หรือ  201 เป็นต้น" data-hint-position="top">
	            <div class="input-control text span2" id="ClndrEMSDate" style="margin-left: 5px; max-width: 135px;">
	                <input type="text" id="EMSDate" name="EMSDate" value="<?php echo !empty($results['data'][0]['EMSDate']) ? StandartDateRollback($results['data'][0]['EMSDate']):""; ?>" placeholder="วันที่ส่ง EMS">
	                <button class="btn-clear" tabindex="-1" type="button" onclick="$('#EMSDate').val('');"></button>
	            </div>
	            <div class="span1" style="color: #d2322d;">*</div>
	            <div id="ems_alert" class="span3 text-danger"></div>
	        </div>
	    </div>
	    
	    <div class="span12">
	        <label class="span4 hq_label">Submit document from LB</label>
	        <div class="input-control checkbox span1" >
	        <label>
	        	<?php $checker = !empty($results['data'][0]['HQReceiveCADocDate']) && ($results['data'][0]['HQReceiveCADocDate'] != '1900-01-01') ? true:false; ?>
	        	<input type="checkbox" name="HQReceiveCADateChecker" id="HQReceiveCADateChecker" <?php if($checker) echo "checked"; if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?> style="margin-top: 5px;">
	        	<span class="check"></span>
	        </label>
	        </div>
	        <div id="HQReceiveCADate" class="input-control text span4" style="margin-left: -30px; max-width: 270px;">
	            <input type="text" id="objHQReceiveCADate" name="HQReceiveCADate" value="<?php echo !empty($results['data'][0]['HQReceiveCADocDate']) && ($results['data'][0]['HQReceiveCADocDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['HQReceiveCADocDate']):""; ?>" <?php if($session_data['branchcode'] <> '000') { echo ' readonly="readonly"'; } ?>>
	            <span class="btn-date"></span>
	        </div>
	    </div>       
	   		
   		<div class="span12">
	   		<label class="span4 hq_label">Missing document from LB</label>
	   		<?php $lack_completed = !empty($results['data'][0]['CompletionDoc']) ? (int)$results['data'][0]['CompletionDoc']:""; ?>
	   		<div class="input-control radio span1" style="min-width: 70px;">
                <label>
                    <input type="radio" id="lackdoc_notsend" name="lackdoc_notsend" value="0" checked="checked" <?php if($lack_completed == '0') echo 'checked'; ?> <?php if($session_data['branchcode'] <> '000') { echo ' readonly="readonly"'; } ?>>
                    <span class="check"></span>ไม่ครบ
                </label>
            </div>
            <div class="input-control radio span1">
                <label>
                    <input type="radio" id="lackdoc_send" name="lackdoc_notsend" value="1" <?php if($lack_completed == '1') echo 'checked'; ?> <?php if($session_data['branchcode'] <> '000') { echo ' readonly="readonly"'; } ?>>
                    <span class="check"></span> ครบ
                </label>
            </div>
            <div id="objLackdoc_sendDate" class="input-control text span2" style="margin-left: 10px; max-width: 270px;">
                <input type="text" id="lackdoc_sendDate" name="lackdoc_sendDate" value="<?php echo !empty($results['data'][0]['CompletionDocDate']) && ($results['data'][0]['CompletionDocDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['CompletionDocDate']):""; ?>" <?php if($session_data['branchcode'] <> '000') { echo ' readonly="readonly"'; } ?>>
                <span class="btn-date"></span>
            </div>
   		</div>
   		
   		<?php 
   		
	   		if(empty($lacklist['data'][0])) {
				
			} else {

				if($session_data['branchcode'] == '000'):

					echo "
					 <div class=\"span12\">
					 <div class=\"span4\">&nbsp;</div>
					 <div class=\"span4\">&nbsp;</div>
					 <div class=\"span2 input-control checkbox\" style=\"position: relative;\">
   						<label>
   							<input id=\"checkedAll\" type=\"checkbox\">
   						  	<span class=\"check\"></span> All
	                 	</label>
   					 </div>
					 </div>";
				
				endif;
				

				$i=1;
				$locked = ($session_data['branchcode'] <> '000') ? ' readonly="readonly"':false;
		   		foreach ($lacklist['data'] as $index => $values) {

					
					echo "<div class=\"span12\">
					 	  <div class=\"span4\">&nbsp;</div>
							  <div class=\"input-control text span4\" style=\"margin-left: 20px;\" data-hint='".iconv('TIS-620', 'UTF-8', $values['LackDoc'])."' data-hint-position=\"right\">
							  	<input type=\"text\" value='".iconv('TIS-620', 'UTF-8', $values['LackDoc'])."'  disabled=\"disabled\">
							  </div>
   		 					  <div class=\"span2 input-control checkbox\">
   								<label>
   									<input name=\"missing_doc[]\" type=\"checkbox\" value='".$values['RowID']."' $locked>
   								  	<span class=\"check\"></span>
	                			</label>
   							  </div>
					   	  </div>";		
					$i++;
					
				}   
	
			}
   		
   		?>
   
	    <div class="span12" id="parent_list">
	    	<div class="span4">&nbsp;</div>
	    	<div id="parent_list_content" class="input-control select span4" style="margin-left: 20px;">
	    		<input type="hidden" name="lackdoc_hidden" id="lackdoc_hidden_1" value="">
	    		<select id="lackdoc_1" name="lackdocument[]"></select>
	    	</div>
	    	<?php 
	    	
				echo "
					<div id=\"genPlus\" class=\"span1 fg-green genPlus\" data-hint=\"Add Missing Document\" data-hint-position=\"top\">
	    				<i class=\"fa fa-plus-circle\"></i>
	    			</div>";
		
	    	
	    	?>
	    	<div id="lack_progress" style="margin-top: 3px;"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: -20px;"> Loading...</div>
	    </div>
	    
        <div class="span12">
            <label class="span4 hq_label">Submit document to CA</label>
            <?php $SentDocToCA = !empty($results['data'][0]['SentDocToCA']) ? $results['data'][0]['SentDocToCA']:""; ?>
            <div class="input-control radio span1" style="min-width: 70px;">
                <label>
                    <input type="radio" id="notsendto" name="sendto" value="0" <?php if(empty($SentDocToCA) || $SentDocToCA == '0') echo 'checked'; ?> <?php if($session_data['branchcode'] <> '000') { echo ' readonly="readonly"'; } ?>>
                    <span class="check"></span> ไม่ส่ง
                </label>
            </div>
            <div class="input-control radio span1">
                <label>
                    <input type="radio" id="sendto" name="sendto" value="1" <?php if($SentDocToCA == '1') echo 'checked'; ?> <?php if($session_data['branchcode'] <> '000') { echo ' readonly="readonly"'; } ?>>
                    <span class="check"></span> ส่ง
                </label>
            </div>
            <div id="clndrCADate" class="input-control text span2" style="margin-left: 10px; max-width: 270px;">
                <input type="text" id="CADate" name="CADate" value="<?php echo !empty($results['data'][0]['SentToCADate']) && ($results['data'][0]['SentToCADate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['SentToCADate']):""; ?>" <?php if($session_data['branchcode'] <> '000') { echo ' readonly="readonly"';; } ?>>
                <span class="btn-date"></span>
            </div>
        </div>

	
	</fieldset>
	<div class="span12">&nbsp;</div>
	<div class="span12">
	    <div class="span6">
	        <div id="progresses" class="span1"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="visibility: hidden;"></div>
	        <div id="msg_alert"></div>
	    </div>
	
	    <div class="span6" style="padding-left: 58px;">
	        <button id="onprocess" style="padding: 10px 20px;">Submit</button>
	        <?php 
	        /*
	        if(!empty($_GET['tool']) && $_GET['tool'] == 'op' && !empty($_GET['cl']) && $_GET['cl'] == 'b1mods') {
	        	echo '<a href="'.site_url('metro/fnReconcileNCB').'"><div id="goto_reconsiledoc" class="button default" style="padding: 10px 20px;">Back to Reconcile NCB <i class="icon-exit on-right"></i></div></a>';
	        }
	        
	        if(!empty($_GET['tool']) && $_GET['tool'] == 'op' && !empty($_GET['cl']) && $_GET['cl'] == 'b2mods') {
				echo '<a href="'.site_url('metro/fnReconcileDoc').'"><div id="goto_reconsiledoc" class="button default" style="padding: 10px 20px;">Back to Reconcile Doc <i class="icon-exit on-right"></i></div></a>';
			}
			
			if(!empty($_GET['tool']) && $_GET['tool'] == 'op' && !empty($_GET['cl']) && $_GET['cl'] == 'b3mods') {
				echo '<a href="'.site_url('metro/fnCompletionDoc').'"><div id="goto_reconsiledoc" class="button default" style="padding: 10px 20px;">Back to Document Completion<i class="icon-exit on-right"></i></div></a>';
			}
			*/
	        ?>
	    </div>
	</div>

    <?php echo form_close(); ?>
	</div>
	
	<?php echo validation_errors('<div class="span12 text-warning" style="padding-left: 40px;">', '</div>'); ?>
	<?php 

	    	if(!empty($role_handled)) {

				if($role_handled['status'] === false && $role_handled['access'] == "permission") {
					echo '<div class="span12" style="margin-top: 10px;"><p class="important text-danger"><i class="fa fa-ban text-danger"></i> '.$role_handled['msg'].'<p></div>';
				
				}
 
			}
			
			if(!empty($databundled)) {
			
				if($databundled['status'] === false && $databundled['access'] == "databundle") {
					echo '<div class="span12" style="margin-top: 10px;"><p class="important text-danger"><i class="icon-warning on-left text-danger"></i> '.$databundled['msg'].'<p></div>';
			
				}
			
			}
			
			$forms = isset($_GET['forms']);
			if(!empty($forms) && $forms == 'success') {
				echo '<div class="span12" style="margin-top: 10px;"><p class="alert alert-success text-success" role="alert"><i class="icon-checkmark on-left text-success"></i> '."ปรับปรุงข้อมูลสำเร็จ.".'<p></div>';
			}
			
    ?>

    
    <h3>MISSING DOCUMENT</h3>
	<fieldset style="width: 100%;">
		<legend style="font-size: 1.2em;">ส่วนที่ 2: เอกสารขอคืน</legend>
		<div id="document_process"></div>
		<input type="hidden" name="actor" id="actor" value="<?php echo !empty($session_data['thname'])? $session_data['thname']:""; ?>">
	</fieldset>

    <?php $this->load->helper('form'); ?>
    <?php $attributes = array('id' => 'doc_refund'); ?>
    <?php echo form_open('metro/docmentRefunds', $attributes); ?>
	<div id="document_refund">
	<?php $get_return = !empty($_GET['cl']) && $_GET['cl'] == 'b4mods' ? 'style="border: 1px solid red;"':""; ?>
	<input type="hidden" name="doc_id" id="doc_id" value="<?php echo !empty($results['data'][0]['DocID']) ? $results['data'][0]['DocID']:""; ?>">
	<?php $branchcode = !empty($session_data['branchcode']) ? $session_data['branchcode']:""; ?>
	<table class="table bordered hovered" <?php echo $get_return; ?>>
	    <thead>
	    <tr style="background-color: #F5F5F5;">
	        <th width="7%">#</th>
	        <th width="20%">เอกสารขอคืน</th>
	        <th width="15%">วันที่สร้างข้อมูล</th>
	        <th width="15%" class="hq_label">สนญ.รับเอกสาร</th>
	        <th width="15%" class="hq_label">รับเอกสารจาก CA</th>
	        <th width="15%">รับเอกสารจาก สนญ</th>
	    </tr>
	    </thead>
	    <tbody style="background-color: #F5F5F5;">
	    <tr>
	        <td>
	            <div class="input-control text" style="max-height: 30px;">
	                <input type="text" id="docno_1" name="docno[]" size="1" value="<?php echo !empty($docrefund['data'][0]['DocNo']) ? $docrefund['data'][0]['DocNo']:"1"; ?>" style="text-align: center;">
	            </div>
	        </td>
	        <td>
	            <div class="input-control select" style="max-height: 30px;">
	                <select id="doctype_1" name="doctype[]" class="size4">
	                    <option value="N/A">-- เหตุผล --</option>
	                    <option value="บิลซื้อขาย/สมุดรายรับรายจ่าย" <?php if(!empty($docrefund['data'][0]['DocType']) && (@iconv("TIS-620", "UTF-8", $docrefund['data'][0]['DocType'])) == "บิลซื้อขาย/สมุดรายรับรายจ่าย") echo "selected"; ?>>บิลซื้อขาย/สมุดรายรับรายจ่าย</option>
	                    <option value="ใบกำกับภาษี" <?php if(!empty($docrefund['data'][0]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][0]['DocType']) == "ใบกำกับภาษี")) echo "selected"; ?>>ใบกำกับภาษี</option>
	                    <option value="รูปภาพถ่าย" <?php if(!empty($docrefund['data'][0]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][0]['DocType']) == "รูปภาพถ่าย")) echo "selected"; ?>>รูปภาพถ่าย</option>
	                    <option value="ใบแจ้งหนี้" <?php if(!empty($docrefund['data'][0]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][0]['DocType']) == "ใบแจ้งหนี้")) echo "selected"; ?>>ใบแจ้งหนี้</option>
	                    <option value="ใบสั่งซื้อ/ใบส่งสินค้า" <?php if(!empty($docrefund['data'][0]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][0]['DocType'])) == "ใบสั่งซื้อ/ใบส่งสินค้า") echo "selected"; ?>>ใบสั่งซื้อ/ใบส่งสินค้า</option>
	                    <option value="สัญญาเช่า" <?php if(!empty($docrefund['data'][0]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][0]['DocType'])) == "สัญญาเช่า") echo "selected"; ?>>สัญญาเช่า</option>
	                    <option value="ภพ.30" <?php if(!empty($docrefund['data'][0]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][0]['DocType'])) == "ภพ.30") echo "selected"; ?>>ภพ.30</option>
	                    <option value="อื่นๆ" <?php if(!empty($docrefund['data'][0]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][0]['DocType'])) == "อื่นๆ") echo "selected"; ?>>อื่นๆ</option>
	                </select>
	                <input type="hidden" name="hidden_doctype_1" id="hidden_doctype_1" value="<?php echo !empty($docrefund['data'][0]['DocType']) ? @iconv("TIS-620", "UTF-8",$docrefund['data'][0]['DocType']):""; ?>">
                    <textarea id="docoption_1" name="docoption[]" class="size4"><?php echo !empty($docrefund['data'][0]['DocNote']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][0]['DocNote']):""; ?></textarea>
	            </div>
	        </td>
	        <td>
	            <div class="input-control" style="max-height: 30px; text-align: center;">
	                <p id="doc_date_text_1" class="text-muted"><?php echo !empty($docrefund['data'][0]['CreateDate']) ? StandartDateRollback($docrefund['data'][0]['CreateDate']):""; ?></p>
	                <input type="hidden" id="doc_gendate_1" name="doc_gendate[]" value="<?php echo !empty($docrefund['data'][0]['CreateDate']) ? StandartDateRollback($docrefund['data'][0]['CreateDate']):""; ?>">
	                <input type="hidden" id="actor_gendate_1" name="actor_gendate[]" value="<?php echo !empty($docrefund['data'][0]['CreateBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][0]['CreateBy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_hqreceivedoc[]" id="conf_hqreceivedoc_1"
	                    <?php
	                        echo !empty($docrefund['data'][0]['HQGetDocDate']) && ($docrefund['data'][0]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][0]['HQGetDocDate'] != "1900-01-01") ? "checked":"";
	                        //if($branchcode != '000' || $branchcode != '105') echo " disabled ";
	                    ?> <?php if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_hqreceivedoc_1" class="text-muted">
	                    <?php echo !empty($docrefund['data'][0]['HQGetDocDate']) && ($docrefund['data'][0]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][0]['HQGetDocDate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][0]['HQGetDocDate']):""; ?>
	                </p>
	                <input type="hidden" id="hqreceivedoc_1" name="hqreceivedoc[]" value="<?php echo !empty($docrefund['data'][0]['HQGetDocDate']) ? StandartDateRollback($docrefund['data'][0]['HQGetDocDate']):""; ?>">
	                <input type="hidden" id="actor_hqreceivedoc_1" name="actor_hqreceivedoc[]" value="<?php echo !empty($docrefund['data'][0]['HQGetDocBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][0]['HQGetDocBy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1"  style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_docfromca[]" id="conf_docfromca_1"
	                    <?php
	                        echo !empty($docrefund['data'][0]['HQGetDocFromCADate']) && ($docrefund['data'][0]['HQGetDocFromCADate'] != "0000-00-00") && ($docrefund['data'][0]['HQGetDocFromCADate'] != "1900-01-01")  ? "checked":"";
	                        //if($branchcode != '000' || $branchcode != '105') echo " disabled ";
	                    ?> <?php if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_docfromca_1" class="text-muted">
	                    <?php echo !empty($docrefund['data'][0]['HQGetDocFromCADate']) && ($docrefund['data'][0]['HQGetDocFromCADate'] != "0000-00-00") && ($docrefund['data'][0]['HQGetDocFromCADate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][0]['HQGetDocFromCADate']):""; ?>
	                </p>
	                <input type="hidden" id="docfromca_1" name="docfromca[]" value="<?php echo !empty($docrefund['data'][0]['HQGetDocFromCADate']) ? StandartDateRollback($docrefund['data'][0]['HQGetDocFromCADate']):""; ?>">
	                <input type="hidden" id="actor_docfromca_1" name="actor_docfromca[]" value="<?php echo !empty($docrefund['data'][0]['HQGetDocFromCABy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][0]['HQGetDocFromCABy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_adminbranch[]" id="conf_adminbranch_1"
	                    <?php
	                        echo !empty($docrefund['data'][0]['BranchGetDocDate']) && ($docrefund['data'][0]['BranchGetDocDate'] != "0000-00-00") && ($docrefund['data'][0]['BranchGetDocDate'] != "1900-01-01") ? "checked":"";
	                    ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_adminbranch_1" class="text-muted">
	                    <?php 
							echo !empty($docrefund['data'][0]['BranchGetDocDate']) && ($docrefund['data'][0]['BranchGetDocDate'] != "0000-00-00") && ($docrefund['data'][0]['BranchGetDocDate'] != "1900-01-01")? StandartDateRollback($docrefund['data'][0]['BranchGetDocDate']):""; 
						?>
	                </p>
	                <input type="hidden" id="adminbranch_1" name="adminbranch[]" value="<?php echo !empty($docrefund['data'][0]['BranchGetDocDate']) ? StandartDateRollback($docrefund['data'][0]['BranchGetDocDate']):""; ?>">
	                <input type="hidden" id="actor_adminbranch_1" name="actor_adminbranch[]" value="<?php echo !empty($docrefund['data'][0]['BranchGetDocBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][0]['BranchGetDocBy']):""; ?>">
	            </div>
	        </td>
	    </tr>
	    <tr>
	        <td>
	            <div class="input-control text" style="max-height: 30px;">
	                <input type="text" id="docno_2" name="docno[]" size="1" value="<?php echo !empty($docrefund['data'][1]['DocNo']) ? $docrefund['data'][1]['DocNo']:"2"; ?>" style="text-align: center;">
	            </div>
	        </td>
	        <td>
	            <div class="input-control select" style="max-height: 30px;">
	                <select id="doctype_2" name="doctype[]" class="size4">
	                    <option value="N/A">-- เหตุผล --</option>
	                    <option value="บิลซื้อขาย/สมุดรายรับรายจ่าย" <?php if(!empty($docrefund['data'][1]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][1]['DocType'])) == "บิลซื้อขาย/สมุดรายรับรายจ่าย") echo "selected"; ?>>บิลซื้อขาย/สมุดรายรับรายจ่าย</option>
	                    <option value="ใบกำกับภาษี" <?php if(!empty($docrefund['data'][1]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][1]['DocType'])) == "ใบกำกับภาษี") echo "selected"; ?>>ใบกำกับภาษี</option>
	                    <option value="รูปภาพถ่าย" <?php if(!empty($docrefund['data'][1]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][1]['DocType'])) == "รูปภาพถ่าย") echo "selected"; ?>>รูปภาพถ่าย</option>
	                    <option value="ใบแจ้งหนี้" <?php if(!empty($docrefund['data'][1]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][1]['DocType'])) == "ใบแจ้งหนี้") echo "selected"; ?>>ใบแจ้งหนี้</option>
	                    <option value="ใบสั่งซื้อ/ใบส่งสินค้า" <?php if(!empty($docrefund['data'][1]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][1]['DocType'])) == "ใบสั่งซื้อ/ใบส่งสินค้า") echo "selected"; ?>>ใบสั่งซื้อ/ใบส่งสินค้า</option>
	                    <option value="สัญญาเช่า" <?php if(!empty($docrefund['data'][1]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][1]['DocType'])) == "สัญญาเช่า") echo "selected"; ?>>สัญญาเช่า</option>
	                    <option value="ภพ.30" <?php if(!empty($docrefund['data'][1]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][1]['DocType'])) == "ภพ.30") echo "selected"; ?>>ภพ.30</option>
	                    <option value="อื่นๆ" <?php if(!empty($docrefund['data'][1]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][1]['DocType'])) == "อื่นๆ") echo "selected"; ?>>อื่นๆ</option>
	                </select>
	                <input type="hidden" name="hidden_doctype_2" id="hidden_doctype_2" value="<?php echo !empty($docrefund['data'][1]['DocType']) ? @iconv("TIS-620", "UTF-8",$docrefund['data'][1]['DocType']):""; ?>">
                    <textarea id="docoption_2" name="docoption[]" class="size4"><?php echo !empty($docrefund['data'][1]['DocNote']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][1]['DocNote']):""; ?></textarea>
	            </div>
	        </td>
	        <td>
	            <div class="input-control" style="max-height: 30px; text-align: center;">
	                <p id="doc_date_text_2" class="text-muted">
	                    <?php echo !empty($docrefund['data'][1]['CreateDate']) ? StandartDateRollback($docrefund['data'][1]['CreateDate']):""; ?>
	                </p>
	                <input type="hidden" id="doc_gendate_2" name="doc_gendate[]" value="<?php echo !empty($docrefund['data'][1]['CreateDate']) ? StandartDateRollback($docrefund['data'][1]['CreateDate']):""; ?>">
	                <input type="hidden" id="actor_gendate_2" name="actor_gendate[]" value="<?php echo !empty($docrefund['data'][1]['CreateBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][1]['CreateBy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_hqreceivedoc[]" id="conf_hqreceivedoc_2"
	                    <?php
	                        //if($branchcode != '000' || $branchcode != '105') echo " disabled ";
	                        echo !empty($docrefund['data'][1]['HQGetDocDate']) && ($docrefund['data'][1]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][1]['HQGetDocDate'] != "1900-01-01") ? "checked":"";
	                    ?> <?php if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_hqreceivedoc_2" class="text-muted">
	                    <?php echo !empty($docrefund['data'][1]['HQGetDocDate']) && ($docrefund['data'][1]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][1]['HQGetDocDate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][1]['HQGetDocDate']):""; ?>
	                </p>
	                <input type="hidden" id="hqreceivedoc_2" name="hqreceivedoc[]" value="<?php echo !empty($docrefund['data'][1]['HQGetDocDate']) ? StandartDateRollback($docrefund['data'][1]['HQGetDocDate']):""; ?>">
	                <input type="hidden" id="actor_hqreceivedoc_2" name="actor_hqreceivedoc[]" value="<?php echo !empty($docrefund['data'][1]['HQGetDocBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][1]['HQGetDocBy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_docfromca[]" id="conf_docfromca_2"
	                    <?php
	                        //if($branchcode != '000' || $branchcode != '105') echo " disabled ";
	                        echo !empty($docrefund['data'][1]['HQGetDocFromCADate']) && ($docrefund['data'][1]['HQGetDocFromCADate'] != "0000-00-00") && ($docrefund['data'][1]['HQGetDocFromCADate'] != "1900-01-01")  ? "checked":"";
	                    ?> <?php if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_docfromca_2" class="text-muted">
	                    <?php echo !empty($docrefund['data'][1]['HQGetDocFromCADate']) && ($docrefund['data'][1]['HQGetDocFromCADate'] != "0000-00-00") && ($docrefund['data'][1]['HQGetDocFromCADate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][1]['HQGetDocFromCADate']):""; ?>
	                </p>
	                <input type="hidden" id="docfromca_2" name="docfromca[]" value="<?php echo !empty($docrefund['data'][1]['HQGetDocFromCADate']) ? StandartDateRollback($docrefund['data'][1]['HQGetDocFromCADate']):""; ?>">
	                <input type="hidden" id="actor_docfromca_2" name="actor_docfromca[]" value="<?php echo !empty($docrefund['data'][1]['HQGetDocFromCABy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][1]['HQGetDocFromCABy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_adminbranch[]" id="conf_adminbranch_2"
	                    <?php echo !empty($docrefund['data'][1]['BranchGetDocDate']) && ($docrefund['data'][1]['BranchGetDocDate'] != "0000-00-00") && ($docrefund['data'][1]['BranchGetDocDate'] != "1900-01-01") ? "checked":""; ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_adminbranch_2" class="text-muted">
	                    <?php echo !empty($docrefund['data'][1]['BranchGetDocDate']) && ($docrefund['data'][1]['BranchGetDocDate'] != "0000-00-00") && ($docrefund['data'][1]['BranchGetDocDate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][1]['BranchGetDocDate']):""; ?>
	                </p>
	                <input type="hidden" id="adminbranch_2" name="adminbranch[]" value="<?php echo !empty($docrefund['data'][1]['BranchGetDocDate']) ? StandartDateRollback($docrefund['data'][1]['BranchGetDocDate']):""; ?>">
	                <input type="hidden" id="actor_adminbranch_2" name="actor_adminbranch[]" value="<?php echo !empty($docrefund['data'][1]['BranchGetDocBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][1]['BranchGetDocBy']):""; ?>">
	            </div>
	        </td>
	    </tr>
	
	    <tr>
	        <td>
	            <div class="input-control text" style="max-height: 30px;">
	                <input type="text" id="docno_3" name="docno[]" size="1" value="<?php echo !empty($docrefund['data'][2]['DocNo']) ? $docrefund['data'][2]['DocNo']:"3"; ?>" style="text-align: center;" style="text-align: center;">
	            </div>
	        </td>
	        <td>
	            <div class="input-control select" style="max-height: 30px;">
	                <select id="doctype_3" name="doctype[]" class="size4">
	                    <option value="N/A">-- เหตุผล --</option>
	                    <option value="บิลซื้อขาย/สมุดรายรับรายจ่าย" <?php if(!empty($docrefund['data'][2]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][2]['DocType'])) == "บิลซื้อขาย/สมุดรายรับรายจ่าย") echo "selected"; ?>>บิลซื้อขาย/สมุดรายรับรายจ่าย</option>
	                    <option value="ใบกำกับภาษี" <?php if(!empty($docrefund['data'][2]['DocType']) &&(@iconv("TIS-620", "UTF-8",$docrefund['data'][2]['DocType'])) == "ใบกำกับภาษี") echo "selected"; ?>>ใบกำกับภาษี</option>
	                    <option value="รูปภาพถ่าย" <?php if(!empty($docrefund['data'][2]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][2]['DocType'])) == "รูปภาพถ่าย") echo "selected"; ?>>รูปภาพถ่าย</option>
	                    <option value="ใบแจ้งหนี้" <?php if(!empty($docrefund['data'][2]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][2]['DocType'])) == "ใบแจ้งหนี้") echo "selected"; ?>>ใบแจ้งหนี้</option>
	                    <option value="ใบสั่งซื้อ/ใบส่งสินค้า" <?php if(!empty($docrefund['data'][2]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][2]['DocType'])) == "ใบสั่งซื้อ/ใบส่งสินค้า") echo "selected"; ?>>ใบสั่งซื้อ/ใบส่งสินค้า</option>
	                    <option value="สัญญาเช่า" <?php if(!empty($docrefund['data'][2]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][2]['DocType'])) == "สัญญาเช่า") echo "selected"; ?>>สัญญาเช่า</option>
	                    <option value="ภพ.30" <?php if(!empty($docrefund['data'][2]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][2]['DocType'])) == "ภพ.30") echo "selected"; ?>>ภพ.30</option>
	                    <option value="อื่นๆ" <?php if(!empty($docrefund['data'][2]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][2]['DocType'])) == "อื่นๆ") echo "selected"; ?>>อื่นๆ</option>
	                </select>
	                <input type="hidden" name="hidden_doctype_3" id="hidden_doctype_3" value="<?php echo !empty($docrefund['data'][2]['DocType']) ? @iconv("TIS-620", "UTF-8",$docrefund['data'][2]['DocType']):""; ?>">
                    <textarea id="docoption_3" name="docoption[]" class="size4"><?php echo !empty($docrefund['data'][2]['DocNote']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][2]['DocNote']):""; ?></textarea>
	            </div>
	        </td>
	        <td>
	            <div class="input-control" style="max-height: 30px; text-align: center;">
	                <p id="doc_date_text_3" class="text-muted"><?php echo !empty($docrefund['data'][2]['CreateDate']) ? StandartDateRollback($docrefund['data'][2]['CreateDate']):""; ?></p>
	                <input type="hidden" id="doc_gendate_3" name="doc_gendate[]" value="<?php echo !empty($docrefund['data'][2]['CreateDate']) ? StandartDateRollback($docrefund['data'][2]['CreateDate']):""; ?>">
	                <input type="hidden" id="actor_gendate_3" name="actor_gendate[]" value="<?php echo !empty($docrefund['data'][2]['CreateBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][2]['CreateBy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_hqreceivedoc[]" id="conf_hqreceivedoc_3"
	                        <?php
	                            //if($branchcode != '000' || $branchcode != '105') echo " disabled ";
	                            echo !empty($docrefund['data'][2]['HQGetDocDate']) && ($docrefund['data'][2]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][2]['HQGetDocDate'] != "1900-01-01") ? "checked":"";
	                        ?> <?php if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_hqreceivedoc_3" class="text-muted">
	                    <?php echo !empty($docrefund['data'][2]['HQGetDocDate']) && ($docrefund['data'][2]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][2]['HQGetDocDate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][2]['HQGetDocDate']):""; ?>
	                </p>
	                <input type="hidden" id="hqreceivedoc_3" name="hqreceivedoc[]" value="<?php echo !empty($docrefund['data'][2]['HQGetDocDate']) ? StandartDateRollback($docrefund['data'][2]['HQGetDocDate']):""; ?>">
	                <input type="hidden" id="actor_hqreceivedoc_3" name="actor_hqreceivedoc[]" value="<?php echo !empty($docrefund['data'][2]['HQGetDocBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][2]['HQGetDocBy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_docfromca[]" id="conf_docfromca_3"
	                     <?php
	                        //if($branchcode != '000' || $branchcode != '105') echo " disabled ";
	                        echo !empty($docrefund['data'][2]['HQGetDocFromCADate']) && ($docrefund['data'][2]['HQGetDocFromCADate'] != "0000-00-00") && ($docrefund['data'][2]['HQGetDocFromCADate'] != "1900-01-01")  ? "checked":"";
	                     ?> <?php if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_docfromca_3" class="text-muted">
	                    <?php echo !empty($docrefund['data'][2]['HQGetDocFromCADate']) && ($docrefund['data'][2]['HQGetDocFromCADate'] != "0000-00-00") && ($docrefund['data'][2]['HQGetDocFromCADate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][2]['HQGetDocFromCADate']):""; ?>
	                </p>
	                <input type="hidden" id="docfromca_3" name="docfromca[]" value="<?php echo !empty($docrefund['data'][2]['HQGetDocFromCADate']) ? StandartDateRollback($docrefund['data'][2]['HQGetDocFromCADate']):""; ?>">
	                <input type="hidden" id="actor_docfromca_3" name="actor_docfromca[]" value="<?php echo !empty($docrefund['data'][2]['HQGetDocFromCABy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][2]['HQGetDocFromCABy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_adminbranch[]" id="conf_adminbranch_3" <?php echo !empty($docrefund['data'][2]['BranchGetDocDate']) && ($docrefund['data'][2]['BranchGetDocDate'] != "0000-00-00") && ($docrefund['data'][2]['BranchGetDocDate'] != "1900-01-01") ? "checked":""; ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_adminbranch_3" class="text-muted">
	                    <?php echo !empty($docrefund['data'][2]['BranchGetDocDate']) && ($docrefund['data'][2]['BranchGetDocDate'] != "0000-00-00") && ($docrefund['data'][2]['BranchGetDocDate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][2]['BranchGetDocDate']):""; ?>
	                </p>
	                <input type="hidden" id="adminbranch_3" name="adminbranch[]" value="<?php echo !empty($docrefund['data'][2]['BranchGetDocDate']) ? StandartDateRollback($docrefund['data'][2]['BranchGetDocDate']):""; ?>">
	                <input type="hidden" id="actor_adminbranch_3" name="actor_adminbranch[]" value="<?php echo !empty($docrefund['data'][2]['BranchGetDocBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][2]['BranchGetDocBy']):""; ?>">
	            </div>
	        </td>
	    </tr>
	
	    <tr>
	        <td>
	            <div class="input-control text" style="max-height: 30px;">
	                <input type="text" id="docno_4" name="docno[]" size="1" value="<?php echo !empty($docrefund['data'][3]['DocNo']) ? $docrefund['data'][3]['DocNo']:"4"; ?>" style="text-align: center;">
	            </div>
	        </td>
	        <td>
	            <div class="input-control select" style="max-height: 30px;">
	                <select id="doctype_4" name="doctype[]" class="size4">
	                    <option value="N/A">-- เหตุผล --</option>
	                    <option value="บิลซื้อขาย/สมุดรายรับรายจ่าย" <?php if(!empty($docrefund['data'][3]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][3]['DocType'])) == "บิลซื้อขาย/สมุดรายรับรายจ่าย") echo "selected"; ?>>บิลซื้อขาย/สมุดรายรับรายจ่าย</option>
	                    <option value="ใบกำกับภาษี" <?php if(!empty($docrefund['data'][3]['DocType']) &&(@iconv("TIS-620", "UTF-8",$docrefund['data'][3]['DocType']) == "ใบกำกับภาษี")) echo "selected"; ?>>ใบกำกับภาษี</option>
	                    <option value="รูปภาพถ่าย" <?php if(!empty($docrefund['data'][3]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][3]['DocType']) == "รูปภาพถ่าย")) echo "selected"; ?>>รูปภาพถ่าย</option>
	                    <option value="ใบแจ้งหนี้" <?php if(!empty($docrefund['data'][3]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][3]['DocType']) == "ใบแจ้งหนี้")) echo "selected"; ?>>ใบแจ้งหนี้</option>
	                    <option value="ใบสั่งซื้อ/ใบส่งสินค้า" <?php if(!empty($docrefund['data'][3]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][3]['DocType'])) == "ใบสั่งซื้อ/ใบส่งสินค้า") echo "selected"; ?>>ใบสั่งซื้อ/ใบส่งสินค้า</option>
	                    <option value="สัญญาเช่า" <?php if(!empty($docrefund['data'][3]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][3]['DocType']) == "สัญญาเช่า")) echo "selected"; ?>>สัญญาเช่า</option>
	                    <option value="ภพ.30" <?php if(!empty($docrefund['data'][3]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][3]['DocType']) == "ภพ.30")) echo "selected"; ?>>ภพ.30</option>
	                    <option value="อื่นๆ" <?php if(!empty($docrefund['data'][3]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][3]['DocType']) == "อื่นๆ")) echo "selected"; ?>>อื่นๆ</option>
	                </select>
	                <input type="hidden" name="hidden_doctype_4" id="hidden_doctype_4" value="<?php echo !empty($docrefund['data'][3]['DocType']) ? @iconv("TIS-620", "UTF-8",$docrefund['data'][3]['DocType']):""; ?>">
                    <textarea id="docoption_4" name="docoption[]" class="size4"><?php echo !empty($docrefund['data'][3]['DocNote']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][3]['DocNote']):""; ?></textarea>
	            </div>
	        </td>
	        <td>
	            <div class="input-control" style="max-height: 30px; text-align: center;">
	                <p id="doc_date_text_4" class="text-muted"><?php echo !empty($docrefund['data'][3]['CreateDate']) ?  StandartDateRollback($docrefund['data'][3]['CreateDate']):""; ?></p>
	                <input type="hidden" id="doc_gendate_4" name="doc_gendate[]" value="<?php echo !empty($docrefund['data'][3]['CreateDate']) ? StandartDateRollback($docrefund['data'][3]['CreateDate']):""; ?>" style="text-align: center;">
	                <input type="hidden" id="actor_gendate_4" name="actor_gendate[]" value="<?php echo !empty($docrefund['data'][3]['CreateBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][3]['CreateBy']):""; ?>" style="text-align: center;">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_hqreceivedoc[]" id="conf_hqreceivedoc_4"
	                    <?php
	                        //if($branchcode != '000' || $branchcode != '105') echo " disabled ";
	                        echo !empty($docrefund['data'][3]['HQGetDocDate']) && ($docrefund['data'][3]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][3]['HQGetDocDate'] != "1900-01-01") ? "checked":"";
	                    ?> <?php if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_hqreceivedoc_4" class="text-muted">
	                    <?php echo !empty($docrefund['data'][3]['HQGetDocDate']) && ($docrefund['data'][3]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][3]['HQGetDocDate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][3]['HQGetDocDate']):""; ?>
	                </p>
	                <input type="hidden" id="hqreceivedoc_4" name="hqreceivedoc[]" value="<?php echo !empty($docrefund['data'][3]['HQGetDocDate']) ? StandartDateRollback($docrefund['data'][3]['HQGetDocDate']):""; ?>">
	                <input type="hidden" id="actor_hqreceivedoc_4" name="actor_hqreceivedoc[]" value="<?php echo !empty($docrefund['data'][3]['HQGetDocBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][3]['HQGetDocBy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_docfromca[]" id="conf_docfromca_4"
	                    <?php
	                        //if($branchcode != '000' || $branchcode != '105') echo " disabled ";
	                        echo !empty($docrefund['data'][3]['HQGetDocFromCADate']) && ($docrefund['data'][3]['HQGetDocFromCADate'] != "0000-00-00") && ($docrefund['data'][3]['HQGetDocFromCADate'] != "1900-01-01")  ? "checked":"";
	                    ?> <?php if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_docfromca_4" class="text-muted">
	                    <?php echo !empty($docrefund['data'][3]['HQGetDocFromCADate']) && ($docrefund['data'][3]['HQGetDocFromCADate'] != "0000-00-00") && ($docrefund['data'][3]['HQGetDocFromCADate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][3]['HQGetDocFromCADate']):""; ?>
	                </p>
	                <input type="hidden" id="docfromca_4" name="docfromca[]" value="<?php echo !empty($docrefund['data'][3]['HQGetDocFromCADate']) ? StandartDateRollback($docrefund['data'][3]['HQGetDocFromCADate']):""; ?>">
	                <input type="hidden" id="actor_docfromca_4" name="actor_docfromca[]" value="<?php echo !empty($docrefund['data'][3]['HQGetDocFromCABy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][3]['HQGetDocFromCABy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_adminbranch[]" id="conf_adminbranch_4"
	                    <?php echo !empty($docrefund['data'][3]['BranchGetDocDate']) && ($docrefund['data'][3]['BranchGetDocDate'] != "0000-00-00") && ($docrefund['data'][3]['BranchGetDocDate'] != "1900-01-01") ? "checked":""; ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_adminbranch_4" class="text-muted">
	                    <?php echo !empty($docrefund['data'][3]['BranchGetDocDate']) && ($docrefund['data'][3]['BranchGetDocDate'] != "0000-00-00") && ($docrefund['data'][3]['BranchGetDocDate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][3]['BranchGetDocDate']):""; ?>
	                </p>
	                <input type="hidden" id="adminbranch_4" name="adminbranch[]" value="<?php echo !empty($docrefund['data'][3]['BranchGetDocDate']) ? StandartDateRollback($docrefund['data'][3]['BranchGetDocDate']):""; ?>">
	                <input type="hidden" id="actor_adminbranch_4" name="actor_adminbranch[]" value="<?php echo !empty($docrefund['data'][3]['BranchGetDocBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][3]['BranchGetDocBy']):""; ?>">
	            </div>
	        </td>
	    </tr>
	
	    <tr>
	        <td>
	            <div class="input-control text" style="max-height: 30px;">
	                <input type="text" id="docno_5" name="docno[]" size="1" value="<?php echo !empty($docrefund['data'][4]['DocNo']) ? $docrefund['data'][4]['DocNo']:"5"; ?>" style="text-align: center;">
	            </div>
	        </td>
	        <td>
	            <div class="input-control select" style="max-height: 30px;">
	                <select id="doctype_5" name="doctype[]" class="size4"> 
	                    <option value="N/A">-- เหตุผล --</option>
	                    <option value="บิลซื้อขาย/สมุดรายรับรายจ่าย" <?php if(!empty($docrefund['data'][4]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][4]['DocType'])) == "บิลซื้อขาย/สมุดรายรับรายจ่าย") echo "selected"; ?>>บิลซื้อขาย/สมุดรายรับรายจ่าย</option>
	                    <option value="ใบกำกับภาษี" <?php if(!empty($docrefund['data'][4]['DocType']) &&(@iconv("TIS-620", "UTF-8",$docrefund['data'][4]['DocType']) == "ใบกำกับภาษี")) echo "selected"; ?>>ใบกำกับภาษี</option>
	                    <option value="รูปภาพถ่าย" <?php if(!empty($docrefund['data'][4]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][4]['DocType']) == "รูปภาพถ่าย")) echo "selected"; ?>>รูปภาพถ่าย</option>
	                    <option value="ใบแจ้งหนี้" <?php if(!empty($docrefund['data'][4]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][4]['DocType']) == "ใบแจ้งหนี้")) echo "selected"; ?>>ใบแจ้งหนี้</option>
	                    <option value="ใบสั่งซื้อ/ใบส่งสินค้า" <?php if(!empty($docrefund['data'][4]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][4]['DocType'])) == "ใบสั่งซื้อ/ใบส่งสินค้า") echo "selected"; ?>>ใบสั่งซื้อ/ใบส่งสินค้า</option>
	                    <option value="สัญญาเช่า" <?php if(!empty($docrefund['data'][4]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][4]['DocType']) == "สัญญาเช่า")) echo "selected"; ?>>สัญญาเช่า</option>
	                    <option value="ภพ.30" <?php if(!empty($docrefund['data'][4]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][4]['DocType']) == "ภพ.30")) echo "selected"; ?>>ภพ.30</option>
	                    <option value="อื่นๆ" <?php if(!empty($docrefund['data'][4]['DocType']) && (@iconv("TIS-620", "UTF-8",$docrefund['data'][4]['DocType']) == "อื่นๆ")) echo "selected"; ?>>อื่นๆ</option>
	                </select>
	                <input type="hidden" name="hidden_doctype_5" id="hidden_doctype_5" value="<?php echo !empty($docrefund['data'][4]['DocType']) ? @iconv("TIS-620", "UTF-8",$docrefund['data'][4]['DocType']):""; ?>">
                    <textarea id="docoption_5" name="docoption[]" class="size4"><?php echo !empty($docrefund['data'][4]['DocNote']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][4]['DocNote']):""; ?></textarea>
	            </div>
	        </td>
	        <td>
	            <div class="input-control" style="max-height: 30px; text-align: center;">
	                <p id="doc_date_text_5" class="text-muted"><?php echo !empty($docrefund['data'][4]['CreateDate']) ? StandartDateRollback($docrefund['data'][4]['CreateDate']):""; ?></p>
	                <input type="hidden" id="doc_gendate_5" name="doc_gendate[]" value="<?php echo !empty($docrefund['data'][4]['CreateDate']) ? StandartDateRollback($docrefund['data'][4]['CreateDate']):""; ?>" style="text-align: center;">
	                <input type="hidden" id="actor_gendate_5" name="actor_gendate[]" value="<?php echo !empty($docrefund['data'][4]['CreateDate']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][4]['CreateDate']):""; ?>" style="text-align: center;">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_hqreceivedoc[]" id="conf_hqreceivedoc_5"
	                    <?php
	                        //if($branchcode != '000' || $branchcode != '105') echo " disabled ";
	                        echo !empty($docrefund['data'][4]['HQGetDocDate']) && ($docrefund['data'][3]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][3]['HQGetDocDate'] != "1900-01-01") ? "checked":"";
	                    ?> <?php if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_hqreceivedoc_5" class="text-muted">
	                    <?php echo !empty($docrefund['data'][4]['HQGetDocDate']) && ($docrefund['data'][4]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][4]['HQGetDocDate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][4]['HQGetDocDate']):""; ?>
	                </p>
	                <input type="hidden" id="hqreceivedoc_5" name="hqreceivedoc[]" value="<?php echo !empty($docrefund['data'][3]['HQGetDocDate']) ? StandartDateRollback($docrefund['data'][3]['HQGetDocDate']):""; ?>">
	                <input type="hidden" id="actor_hqreceivedoc_5" name="actor_hqreceivedoc[]" value="<?php echo !empty($docrefund['data'][3]['HQGetDocBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][3]['HQGetDocBy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_docfromca[]" id="conf_docfromca_5"
	                    <?php //if($branchcode != '000' || $branchcode != '105') echo " disabled ";
	                    echo !empty($docrefund['data'][4]['HQGetDocFromCADate']) && ($docrefund['data'][4]['HQGetDocDate'] != "0000-00-00") && ($docrefund['data'][4]['HQGetDocDate'] != "1900-01-01") ? "checked":"";
	                	?> <?php if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?>>
	                <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_docfromca_5" class="text-muted">
	                    <?php echo !empty($docrefund['data'][4]['HQGetDocFromCADate']) && ($docrefund['data'][4]['HQGetDocFromCADate'] != "0000-00-00") && ($docrefund['data'][4]['HQGetDocFromCADate'] != "1900-01-01") ? StandartDateRollback($docrefund['data'][4]['HQGetDocFromCADate']):""; ?>
	                </p>
	                <input type="hidden" id="docfromca_5" name="docfromca[]" value="<?php echo !empty($docrefund['data'][3]['HQGetDocFromCADate']) ? StandartDateRollback($docrefund['data'][3]['HQGetDocFromCADate']):""; ?>">
	                <input type="hidden" id="actor_docfromca_5" name="actor_docfromca[]" value="<?php echo !empty($docrefund['data'][3]['HQGetDocFromCABy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][3]['HQGetDocFromCABy']):""; ?>">
	            </div>
	        </td>
	        <td>
	            <div class="input-control checkbox span1" style="max-height: 30px;">
	                <label style="margin-left: 11px;">
	                    <input type="checkbox" name="conf_adminbranch[]" id="conf_adminbranch_5"
	                    <?php echo !empty($docrefund['data'][4]['BranchGetDocDate']) && ($docrefund['data'][4]['BranchGetDocDate'] != "0000-00-00") && ($docrefund['data'][4]['BranchGetDocDate'] != "1900-01-01") ? "checked":""; ?>>
	                    <span class="check"></span>
	                </label>
	            </div>
	            <div class="input-control span1" style="max-height: 30px; max-width: 80px; margin-top: 6px; margin-left: -10px; height: 30px;">
	                <p id="txt_adminbranch_5" class="text-muted">
	                    <?php echo !empty($docrefund['data'][4]['BranchGetDocDate']) && ($docrefund['data'][4]['BranchGetDocDate'] != "0000-00-00") && ($docrefund['data'][4]['BranchGetDocDate'] != "1900-01-01")  ? StandartDateRollback($docrefund['data'][4]['BranchGetDocDate']):""; ?>
	                </p>
	                <input type="hidden" id="adminbranch_5" name="adminbranch[]" value="<?php echo !empty($docrefund['data'][4]['BranchGetDocDate']) ? StandartDateRollback($docrefund['data'][4]['BranchGetDocDate']):""; ?>">
	                <input type="hidden" id="actor_adminbranch_5" name="actor_adminbranch[]" value="<?php echo !empty($docrefund['data'][4]['BranchGetDocBy']) ? @iconv("TIS-620", "UTF-8", $docrefund['data'][4]['BranchGetDocBy']):""; ?>">
	            </div>
	        </td>
	    </tr>
	
	    </tbody>
	</table>
	</div>
	
	
	<div class="span12">&nbsp;</div>
	<span>
		<div id="progresses_doc" class="span1" style="text-align: center;"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="visibility: hidden;"></div>
		<div id="msg_alert"></div>
	</span>
		
	<span style="float: right; margin-top: -5px;">
		<button id="documentsubmit" style="padding: 10px 20px; margin-left: -25px;">Accept</button>
		
		<?php 
		
		if(!empty($_GET['tool']) && $_GET['tool'] == 'op' && !empty($_GET['cl']) && $_GET['cl'] == 'b4mods') {
			echo '<a href="'.site_url('metro/fnReturnDoc').'"><div id="goto_reconsiledoc" class="button default" style="padding: 10px 20px;">Back to Return Doc <i class="icon-exit on-right"></i></div></a>';
		}
		 
		
		?>
	</span>

    <?php echo form_close(); ?>
	</div>
	
	<?php 

	    	if(!empty($role_handled_doc)) {

				if($role_handled_doc['status'] === false && $role_handled_doc['access'] == "permission") {
					echo '<div class="span12" style="margin-top: 10px;"><p class="important text-danger"><i class="fa fa-ban text-danger"></i> '.$role_handled_doc['msg'].'<p></div>';
				
				}
 
			}
			
			if(!empty($databundled_doc)) {
			
				if($databundled_doc['status'] === false && $databundled['access'] == "databundle") {
					echo '<div class="span12" style="margin-top: 10px;"><p class="important text-danger"><i class="icon-warning on-left text-danger"></i> '.$databundled_doc['msg'].'<p></div>';
			
				}
			
			}
			
			$forms = isset($_GET['forms_doc']);
			if(!empty($forms) && $forms == 'success') {
				echo '<div class="span12" style="margin-top: 10px;"><p class="alert alert-success text-success" role="alert"><i class="icon-checkmark on-left text-success"></i> '."ปรับปรุงข้อมูลสำเร็จ.".'<p></div>';
			}
			
			
    ?>
	
	</div>
	</div>
	
	<div id="form_footer">
	    <img src="<?php echo base_url('img/logo_form_footer.jpg'); ?>" style="margin-top: 5px;">
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