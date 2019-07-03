<div class="listview small" style="position: fixed;  ">
   <a href="<?php echo site_url('metro/appProgress?_=').date('s').'&cache=false&secure='.md5(true).'&rel='.$_GET['rel']; ?>" class="list" style="max-width: 130px;">
       <div class="list-content">
           <i class="icon icon-home"></i>
            <div class="data">
               <span class="list-title" style="margin-top: 8px;">HOME</span>
            </div>
        </div>
    </a>
    <a href="#" class="list selected" style="max-width: 130px;">
        <div class="list-content">
           <i class="icon icon-eye"></i>
            <div class="data">
               <span class="list-title" style="margin-top: 8px;">PREVIEW</span>
            </div>
        </div>
    	</a>
    	<a href="<?php echo site_url('metro/routers?_=').date('s').'&cache=false&secure='.md5(true).'&rel='.$_GET['rel'].'&req=P2&live=2'; ?>" class="list" style="max-width: 130px;">
        <div class="list-content">
           <i class="icon icon-pencil"></i>
            <div class="data">
               <span class="list-title" style="margin-top: 8px;">EDIT DATA</span>
            </div>
        </div>
    </a>
</div>

<div class="container">

	<p id="back-top"><a href="#top"><i class="fa fa-arrow-up"></i> Back to Top</a></p>
    <div class="toolbar transparent" style="margin-left: 58px; padding: 5px; border: 1px solid #D1D1D1; max-width: 300px;">
        <a href="<?php echo site_url('metro/appProgress?_=').date('s').'&cache=false&secure='.md5(true).'&rel='.$_GET['rel']; ?>"><button><i class="fa fa-sign-out on-left"></i>Home</button></a>
        <a href="#"><button><i class="fa fa-eye-slash on-left"></i>Preview</button></a>
        <a href="<?php echo site_url('metro/routers?_=').date('s').'&cache=false&secure='.md5(true).'&rel='.$_GET['rel'].'&req=P2&live=2'; ?>"><button><i class="fa fa-pencil-square-o on-left"></i>Edit</button></a>
    </div>


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
	
	<div class="12"></div>
	<div class="span12">
	    <fieldset>
	        <legend class="span12">Information</legend>
	        <div class="span12">
	            <div class="input-control text span5">
	                    <div class="span2">ชื่อสถานที</div>
	                <div class="span3"><?php echo !empty($results['data'][0]['Company']) ? @iconv("TIS-620", "UTF-8",$results['data'][0]['Company']):""; ?></div>
	            </div>
	            <div class="input-control text span7" style="margin-left: -80px;">
	                <?php $ownertype = !empty($results['data'][0]['OwnerType']) ? $results['data'][0]['OwnerType']:""; ?>
	                <div class="span2" style="min-width: 105px;">
	                    <?php if($ownertype == 0) echo "ชื่อเจ้าของกิจการ"; ?>
	                    <?php if($ownertype == 1) echo "ชื่อผู้ติดต่อ"; ?>
	                </div>
	                <div class="span5" style="margin-left: -20px;">
	                    <?php echo !empty($results['data'][0]['OwnerName']) ? @iconv("TIS-620", "UTF-8",$results['data'][0]['OwnerName']):""; ?>
	                </div>
	            </div>
	        </div>
	
	        <div class="span12">
	            <div class="input-control text span4">
	                <div class="span2">Branch Code</div>
	                <div class="span2"><?php echo !empty($results['data'][0]['BranchCode']) ? $results['data'][0]['BranchCode']:"000"; ?></div>
	            </div>
	            <div class="input-control text span4">
	                <div class="span1" style="min-width: 85px;">Branch</div>
	                <div class="span2">
	                	<?php $branchName = !empty($results['data'][0]['Branch']) ? @iconv("TIS-620", "UTF-8", $results['data'][0]['Branch']):""; ?>
	                	<?php 
                           	if($branchName == 'สนับสนุนสาขาสินเชื่อเพื่อรายย่อย') echo 'สินเชื่อเพื่อรายย่อย'; 
                          	else echo $branchName;
                        ?>
	                </div>
	            </div>
	            <div class="input-control text span4">
	                <div class="span1" style="min-width: 90px;">Region</div>
	                <div class="span2"><?php echo !empty($results['data'][0]['Region']) ? @iconv("TIS-620", "UTF-8", $results['data'][0]['Region']):"-"; ?></div>
	            </div>
	        </div>
	
	        <div class="span12">
	            <div class="input-control text span4">
	                <div class="span2">RM Code</div>
	                <div class="span2"><?php echo !empty($results['data'][0]['RMCode']) ? $results['data'][0]['RMCode']:""; ?></div>
	            </div>
	            <div class="input-control text span4">
	                <div class="span1" style="min-width: 85px;">RM Name</div>
	                <p class="span2" style="min-width: 180px;"><?php echo !empty($results['data'][0]['RMName']) ? @iconv("TIS-620", "UTF-8", $results['data'][0]['RMName']):""; ?></p>
	            </div>
	            <div class="input-control text span4">
	                <div class="span1" style="min-width: 95px;">RM Mobile</div>
	                <p class="span2"><?php echo !empty($results['data'][0]['RMMobile']) ? $results['data'][0]['RMMobile']:""; ?></p>
	            </div>
	        </div>
	
	    </fieldset>
	</div>
	
	<div class="span12" style="margin-bottom: 5px;"><h3>VERIFICATION</h3></div>
	
	<div class="span12">
	<fieldset>
		<legend style="font-size: 1.2em;">ส่วนที่ 1: กระบวนการตรวจสอบ</legend>
		
		<div class="span12">
	        <label class="span4" data-hint="Identify Card|เลขบัตรประชาชน" data-hint-position="top">ID Card</label>
	        <div class="input-control text span4" style="margin-left: 20px;">
	            <input type="text" id="id_card" name="id_card" value="<?php echo !empty($results['data'][0]['ID_Card']) ? $results['data'][0]['ID_Card']:""; ?>" maxlength="13 " disabled="disabled">
	        </div>
	        <div class="span1" style="color: #d2322d;"></div>
	        <div id="ncbdate_alert" class="span3 text-danger"></div>
	    </div>
		
	    <div class="span12">
	        <div class="input-control text">
	            <label class="span4">Product Program</label>
	            <?php $productcode  = 'รหัสสินเชื่อ '.$product['data'][0]['ProductCode']; ?>
	            <?php $productnames = !empty($product['data'][0]['ProductName']) ? $product['data'][0]['ProductTypes'].@iconv("TIS-620", "UTF-8", $product['data'][0]['ProductName']):"ไม่ระบุ"; ?>
	            <div class="span4" data-hint="<?php echo $productcode."|".$productnames; ?>" data-hint-position="right">
	            	<input type="text" value="<?php echo !empty($product['data'][0]['ProductName']) ? $product['data'][0]['ProductTypes'].@iconv("TIS-620", "UTF-8", $product['data'][0]['ProductName']):"ไม่ระบุ"; ?>" disabled="disabled">
	            </div>
	        </div>
	    </div>
	
		<!-- Basic Criteria Holding
	    <div class="span12">
	        <div class="input-control text">
	            <?php $criteria = !empty($results['data'][0]['BasicCriteria']) ? intval($results['data'][0]['BasicCriteria']):""; ?>
	            <label class="span4">Basic Criteria</label>
	            <div class="input-control radio">
	                <label class="span1" style="margin-left: 20px; min-width: 90px;">
	                    <input type="radio" <?php if(intval($criteria) == 1) echo "checked"; ?> disabled>
	                    <span class="check"></span> ผ่าน
	                </label>
	                <label class="span2">
	                    <input type="radio" <?php if(intval($criteria) == 0) echo "checked"; ?> disabled>
	                    <span class="check"></span> ไม่ผ่าน
	                </label>
	            </div>
	        </div>
	    </div>
	    -->
	
	    <div class="span12">
	        <div class="input-control text">
	        	
	            <?php $checkncb = !empty($results['data'][0]['CheckNCB']) ? intval($results['data'][0]['CheckNCB']):""; ?>
	            <label class="span4">Check NCB</label>
	            <div class="input-control radio">
	                <label class="span1" style="margin-left: 20px; min-width: 90px;">
	                    <input type="radio" <?php if($checkncb == 1) echo "checked"; ?> disabled>
	                    <span class="check"></span> ผ่าน
	                </label>
	                <label class="span2">
	                    <input type="radio" <?php if($checkncb == 2 || $checkncb == 0) echo "checked"; ?> disabled>
	                    <span class="check"></span> ไม่ผ่าน
	                </label>
	                <label class="span2" style="margin-left: -30px; margin-top: 4px;">
	                    <input type="radio" <?php if($checkncb == 3) echo "checked"; ?> disabled>
	                    <span class="check"></span> Deviate 
	                </label>
	            </div>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control checkbox">
	            <div class="span4">&nbsp;</div>
	            <label class="span1" style="min-width: 80px;">
	                <?php $mainloan = !empty($results['data'][0]['MainLoan']) ? $results['data'][0]['MainLoan']:""; ?>
	                <input type="checkbox" <?php if($mainloan == '1') echo "checked"; ?> disabled>
	                <span class="check"></span> กู้หลัก
	            </label>
	            <div class="span3" style="margin-top: 5px; margin-left: 30px;">ชื่อ นามสกุล : <?php echo !empty($results['data'][0]['MainLoanName']) ? @iconv("TIS-620", "UTF-8",$results['data'][0]['MainLoanName']):""; ?></div>
	        </div>
	        <div class="input-control checkbox">
	            <div class="span4">&nbsp;</div>
	            <label class="span1" style="min-width: 90px;">
	                <?php
	                
	                    $joinloan  = !empty($results['data'][0]['JoinLoan']) ? $results['data'][0]['JoinLoan']:"";
	                    $joinloan2 = !empty($results['data'][0]['JoinLoan2']) ? $results['data'][0]['JoinLoan2']:"";
	                    $joinloan3 = !empty($results['data'][0]['JoinLoan3']) ? $results['data'][0]['JoinLoan3']:"";
	                    $joinloan4 = !empty($results['data'][0]['JoinLoan4']) ? $results['data'][0]['JoinLoan4']:"";
	                    
	                ?>
	                <input type="checkbox" <?php if($joinloan == '1') echo "checked"; ?> disabled>
	                <span class="check"></span> กู้ร่วม
	            </label>
	            <label class="span2" style="min-width: -90px;">
	                <input type="checkbox" name="joinloan2" id="joinloan2" value="1" <?php if($joinloan2 == '1') echo "checked"; ?> disabled>
	                <span class="check"></span> กู้ร่วม 2
	            </label>
	            <label class="span2" style="margin-left: -30px;">
	                <input type="checkbox" name="joinloan3" id="joinloan3" value="1" <?php if($joinloan3 == '1') echo "checked"; ?> disabled>
	                <span class="check"></span> กู้ร่วม 3
	            </label>
	        </div>
	
	        <div class="input-control checkbox">
	            <div class="span4">&nbsp;</div>
	            <?php
	                $corporate = !empty($results['data'][0]['Corporation']) ? $results['data'][0]['Corporation']:"";
	            	$guarantor = !empty($results['data'][0]['Guarantor']) ? $results['data'][0]['Guarantor']:"";
	            ?>
	            <label class="span1" style="min-width: 90px;">
	                <input type="checkbox" name="joinloan4" id="joinloan4" value="1" <?php if($joinloan4 == '1') echo "checked"; ?> disabled>
	                <span class="check"></span> กู้ร่วม 4
	            </label>
	            <label class="span1" style="min-width: 91px;">
	               
	                <input type="checkbox" <?php if($corporate == '1') echo "checked"; ?> disabled>
	                <span class="check"></span> นิติบุคคล
	            </label>
	            <label class="span2">
	                <input type="checkbox" name="corporate2" id="corporate2" value="1" <?php if($guarantor == '1') echo "checked"; ?> disabled>
	                <span class="check"></span> ผู้ค้ำ
	            </label>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control text">
	            <label class="span4">Check NCB Date</label>
	            <div class="span4">
	            	<input type="text" value="<?php echo !empty($results['data'][0]['CheckNCBDate']) ? StandartDateRollback($results['data'][0]['CheckNCBDate']):""; ?>" disabled="disabled">
	            </div>
	        </div>
	    </div>
	    
	     <div class="span12">
	        <label class="span4">Submit NCB to HO</label>
	        <div class="input-control checkbox span1" >
	        <label>
	        	<?php $checker = !empty($results['data'][0]['BrnSentNCBDate']) && ($results['data'][0]['BrnSentNCBDate'] != '1900-01-01') ? true:false; ?>
	        	<input type="checkbox" name="BrnNCBDateChecker" id="BrnNCBDateChecker" <?php if($checker) echo "checked"; ?> style="margin-top: 5px;" disabled="disabled">
	        	<span class="check"></span>
	        </label>
	        </div>
	        <div id="objBrnNCBDate" class="input-control text span4" style="margin-left: -30px; max-width: 270px;" disabled="disabled">
	            <input type="text" id="BrnNCBDate" name="BrnNCBDate" value="<?php echo !empty($results['data'][0]['BrnSentNCBDate']) && ($results['data'][0]['BrnSentNCBDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['BrnSentNCBDate']):""; ?>" disabled="disabled">
	            <span class="btn-date"></span>
	        </div>
	    </div>      
	    
	     <div class="span12">
	        <label class="span4 hq_label">Received NCB from LB</label>
	        <div class="input-control checkbox span1" >
	        <label>
	        	<?php $checker = !empty($results['data'][0]['HQGetNCBDate']) && ($results['data'][0]['HQGetNCBDate'] != '1900-01-01') ? true:false; ?>
	        	<input type="checkbox" name="HQNCBChecker" id="HQNCBChecker" <?php if($checker) echo "checked"; if($session_data['branchcode'] <> '000') { echo ' disabled="disabled"'; } ?> style="margin-top: 5px;" disabled="disabled">
	        	<span class="check"></span>
	        </label>
	        </div>
	        <div id="objHQNCBDatee" class="input-control text span4" style="margin-left: -30px; max-width: 270px;">
	            <input type="text" id="HQNCBDate" name="HQNCBDate" value="<?php echo !empty($results['data'][0]['HQGetNCBDate']) && ($results['data'][0]['HQGetNCBDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['HQGetNCBDate']):""; ?>" disabled="disabled">
	            <span class="btn-date"></span>
	        </div>
	    </div>      
	        
	    <div class="span12">
	        <label class="span4 hq_label">Submit NCB to Oper</label>
	        <div class="input-control checkbox span1" >
	        <label>
	        	<?php $checker = !empty($results['data'][0]['HQSentNCBToOperDate']) && ($results['data'][0]['HQSentNCBToOperDate'] != '1900-01-01') ? true:false; ?>
	        	<input type="checkbox" name="HQSentToOperDateChecker" id="HQSentToOperDateChecker" disabled="disabled" style="margin-top: 5px;">
	        	<span class="check"></span>
	        </label>
	        </div>
	        <div id="objSentToOperDate" class="input-control text span4" style="margin-left: -30px; max-width: 270px;">
	            <input type="text" id="HQSentToOperDate" name="HQSentToOperDate" value="<?php echo !empty($results['data'][0]['HQSentNCBToOperDate']) && ($results['data'][0]['HQSentNCBToOperDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['HQGetNCBDate']):""; ?>" disabled="disabled">
	            <span class="btn-date"></span>
	        </div>
	    </div>      
	             
	    <div class="span12">
	        <div id="comment_parent" class="input-control textarea">
	            <label class="span4">Comment</label>
	            <textarea name="comment" id="comment" rows="3" class="span4" disabled="disabled"><?php echo !empty($results['data'][0]['Comment']) ? @iconv("TIS-620", "UTF-8", $results['data'][0]['Comment']):""; ?></textarea>
	        </div>
	    </div>
	    
	
	    <div class="span12">
	        <div class="input-control text">
	            <label class="span4">RM Process</label>
	            <div class="span3" style="max-width: 160px;">
	            	<input type="text" value="<?php echo !empty($results['data'][0]['RMProcess']) ? @iconv("TIS-620", "UTF-8", $results['data'][0]['RMProcess']):"ไม่ระบุ"; ?>" disabled="disabled">
	            </div>
	            <div class="input-control text span2" style="height: 31px;">
		            <input type="text" value="<?php echo !empty($results['data'][0]['RMProcessDate']) && ($results['data'][0]['RMProcessDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['RMProcessDate']):""; ?>" disabled="disabled">
		            <span class="btn-date"></span>
	        	</div>
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
	        <div id="objreactivate" class="input-control text span2" style="min-width: 180px;">
	            <input id="reactivate" name="reactivate" value="<?php echo !empty($results['data'][0]['RevisitID']) ? $results['data'][0]['RevisitID']:""; ?>" disabled="disabled">
	        </div>
	        <div class="input-control text span2" id="revplan" style="max-width: 115px; margin-left: 5px;">
	            <input type="text" id="reactivatePlan" name="reactivatePlan" value="<?php echo !empty($results['data'][0]['RevisitDate']) && ($results['data'][0]['RevisitDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['RevisitDate']):""; ?>" disabled="disabled">
	            <span class="btn-date"></span>
	        </div>
	        <div id="ARP_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"> Loading...</div>
	        <div id="revisitText" class="span2" style="margin-top: 4px; cursor: pointer;">
	        	<?php echo !empty($results['data'][0]['RevisitRef']) ? 'REF: '.$results['data'][0]['RevisitRef']:""; ?>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control text">
	            <label class="span4">Action Note</label>
	            <div class="span4">
	            	<input type="text" value="<?php echo !empty($results['data'][0]['ActionNote']) ? @iconv("TIS-620", "UTF-8",$results['data'][0]['ActionNote']):"ไม่ระบุ"; ?>" disabled="disabled">
	            </div>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control text">
	            <?php $mrta = !empty($results['data'][0]['MRTA']) ? intval($results['data'][0]['MRTA']):""; ?>
	            <label class="span4">MRTA <span class="text-warning"><small>(กรุณีลูกค้าสมัคร คลิก)</small></span></label>
	            <div class="input-control checkbox">
	                <label class="span1" style="margin-left: 20px; min-width: 90px;">
	                    <input type="checkbox" <?php if($mrta == '1') echo "checked"; ?> disabled>
	                    <span class="check"></span> สมัคร
	                </label>
	            </div>
	        </div>
	    </div>

	    <div class="span12">
	        <div class="input-control text">
	            <label class="span4">EMS No</label>
	            <div class="span3" style="max-width: 160px;">
	            	<input type="text" value="<?php echo !empty($results['data'][0]['EMSNo']) ? $results['data'][0]['EMSNo']:"ไม่ระบุ"; ?>" disabled="disabled">
	            </div>
	            <div class="input-control text span2" style="height: 31px;">
		            <input type="text" value="<?php echo !empty($results['data'][0]['EMSNo']) ? StandartDateRollback($results['data'][0]['EMSDate']):""; ?>" disabled="disabled">
		            <span class="btn-date"></span>
	        	</div>
	        </div>
	    </div>
	    
	    <div class="span12">
	    	<label class="span4 hq_label">Submit document to HO</label>
	        <div class="input-control checkbox span1" >
	        <label>
	        	<?php $checker = !empty($results['data'][0]['HQReceiveCADocDate']) && ($results['data'][0]['HQReceiveCADocDate'] != '1900-01-01') ? true:false; ?>
	        	<input type="checkbox" name="HQReceiveCADateChecker" id="HQReceiveCADateChecker" <?php if($checker) echo "checked"; ?> disabled>
	        	<span class="check"></span>
	        </label>
	        </div>
	         <!-- id="HQReceiveDiv" --> 
	        <div class="input-control text span4" style="margin-left: -30px; max-width: 200px; margin-top: 5px;">
	            <div class="span4" style="max-width: 270px;">
	            	<input type="text" value="<?php echo !empty($results['data'][0]['HQReceiveCADocDate']) && ($results['data'][0]['HQReceiveCADocDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['HQReceiveCADocDate']):""; ?>" disabled="disabled">
	            </div>
	        </div>
	    </div>
	    
	    <div class="span12">
	   		<label class="span4 hq_label">Missing document from LB</label>
	   		<?php $lack_completed = !empty($results['data'][0]['CompletionDoc']) ? (int)$results['data'][0]['CompletionDoc']:""; ?>
	   		<div class="input-control radio span1" style="min-width: 70px;">
                <label>
                    <input type="radio" id="lackdoc_notsend" name="lackdoc_notsend" value="0" disabled="disabled" <?php if(empty($lack_completed) || $lack_completed == '0') echo 'checked'; ?>>
                    <span class="check"></span>ไม่ครบ
                </label>
            </div>
            <div class="input-control radio span1">
                <label>
                    <input type="radio" id="lackdoc_send" name="lackdoc_notsend" value="1" disabled="disabled"  <?php if(empty($lack_completed) || $lack_completed == '1') echo 'checked'; ?>>
                    <span class="check"></span> ครบ
                </label>
            </div>
            <div id="objLackdoc_sendDate" class="input-control text span2" style="margin-left: 10px; max-width: 270px;">
                <input type="text" id="lackdoc_sendDate" name="lackdoc_sendDate" value="<?php echo !empty($results['data'][0]['CompletionDocDate']) && ($results['data'][0]['CompletionDocDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['CompletionDocDate']):""; ?>" disabled="disabled">
                <span class="btn-date"></span>
            </div>
   		</div>
	    
	    <?php 
   		
	   		if(empty($lacklist['data'][0])) {
					echo  '<div class="span12">
						   <div class="span4">&nbsp;</div>
								 <div class="input-control text span4 text-muted" style="margin-left: 20px;">ไม่พบเอกสารขอคืน</div>
						   </div>';
	
			} else {
		   		foreach ($lacklist['data'] as $index => $values) {
					echo '<div class="span12">
						  <div class="span4">&nbsp;</div>
							  <div class="input-control text span4" style="margin-left: 20px;" data-hint="'.iconv('TIS-620', 'UTF-8', $values['LackDoc']).'" data-hint-position="right">
							  	<input type="text" value="'.iconv('TIS-620', 'UTF-8', $values['LackDoc']).'" disabled="disabled">
							  </div>
					   	  </div>';
		
				}   
	
			}
   		
   		?>
   		
        <div class="span12">
            <label class="span4 hq_label">Submit document to CA</label>
            <?php $SentDocToCA = !empty($results['data'][0]['SentDocToCA']) ? $results['data'][0]['SentDocToCA']:""; ?>
            <div class="input-control radio span1" style="min-width: 70px;">
                <label>
                    <input type="radio" id="notsendto" name="sendto" value="1" <?php if(empty($SentDocToCA) || $SentDocToCA == '0') echo 'checked'; ?> disabled="disabled">
                    <span class="check"></span> ไม่ส่ง
                </label>
            </div>
            <div class="input-control radio span1">
                <label>
                    <input type="radio" id="sendto" name="sendto" value="1" <?php if($SentDocToCA == '1') echo 'checked'; ?> disabled="disabled">
                    <span class="check"></span> ส่ง
                </label>
            </div>
            <div id="clndrCADate" class="input-control text span2" style="margin-left: 10px; max-width: 270px;">
                <input type="text" id="CADate" name="CADate" value="<?php echo !empty($results['data'][0]['SentToCADate']) && ($results['data'][0]['SentToCADate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['SentToCADate']):""; ?>" disabled="disabled">
                <span class="btn-date"></span>
            </div>
        </div>

        
	
	</fieldset>
	

	<fieldset style="width: 100%; margin: 40px 0 0;">
		<legend style="font-size: 1.2em;">ส่วนที่ 2: เอกสารขอคืน</legend>
		<div id="document_process"></div>
		<input type="hidden" name="actor" id="actor" value="<?php echo !empty($session_data['thname'])? $session_data['thname']:""; ?>">
	</fieldset>

	<div id="docrefund_article" style="margin: -20px 0 10px;">
	    <div id="docRefund" class="stepper rounded" data-steps="5" data-role="stepper" data-start="0"></div>
	</div>
	
	<div style="width: 100%;">
	    <table class="table bordered hovered" style="background-color: #F5F5F5;">
	    <thead>
	        <tr>
		        <th>#</th>
		        <th>เอกสารขอคืน</th>
		        <th>วันที่สร้างข้อมูล</th>
		        <th class="hq_label">สนญ.รับเอกสาร</th>
		        <th class="hq_label">รับเอกสารจาก CA</th>
		        <th>รับเอกสารจาก สนญ</th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php
	
	        if(empty($docrefund['data'][0])) {
	            echo "<tr>
	                    <td colspan=\"6\" style='text-align: center;'>ไม่พบข้อมูล</td>
	                 </tr>";
	
	        } else {
	
	            foreach($docrefund['data'] as $index => $value) {
	               echo "<tr>
	                        <td class=\"text-center\">".$docrefund['data'][$index]['DocNo']."</td>
	                        <td>".@iconv("TIS-620", "UTF-8", $docrefund['data'][$index]['DocType']).' '.@iconv("TIS-620", "UTF-8", $docrefund['data'][$index]['DocNote'])."</td>
	                        <td class=\"text-center\">".notification(@iconv("TIS-620", "UTF-8", $docrefund['data'][$index]['CreateBy']),$docrefund['data'][$index]['CreateDate'], 'ผู้ร้องขอเอกสาร')."</td>
	                        <td class=\"text-center\">".notification(@iconv("TIS-620", "UTF-8", $docrefund['data'][$index]['HQGetDocBy']), $docrefund['data'][$index]['HQGetDocDate'], 'ผู้รับเอกสาร')."</td>
	                        <td class=\"text-center\">".notification(@iconv("TIS-620", "UTF-8", $docrefund['data'][$index]['HQGetDocFromCABy']), $docrefund['data'][$index]['HQGetDocFromCADate'], 'ผู้รับเอกสาร')."</td>
	                        <td class=\"text-center\">".notification(@iconv("TIS-620", "UTF-8", $docrefund['data'][$index]['BranchGetDocBy']), $docrefund['data'][$index]['BranchGetDocDate'], 'ผู้รับเอกสาร')."</td>
	                     </tr>
	               ";
	            }
	
	        }
	
	    ?>
	    </tbody>
	    </table>
	</div>
	</div>
	
	</div>
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
    if($date == "" || $date == "0000-00-00" || $date == "1900-01-01") {
        return "";

    } else {

        $spl = explode("-", $date);

        $y = $spl[0];
        $m = $spl[1];
        $d = $spl[2];

        return "$d/$m/$y";

    }

}

function notification($notify, $option, $msg) {
    if(!empty($notify)) {
        return "<p data-hint=\"$msg|".$notify."\" data-hint-position=\"top\">".StandartDateRollback($option)."</p></td>";

    } else {
        return;
    }
}

?>