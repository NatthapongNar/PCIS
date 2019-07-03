<div id="bg_firstload" style="position: absolute; background: #000; opacity: 0.5; width: 100%; height: 6000px; z-index: 777; display: none;">
	<div id="progress_loadData" style="position: absolute; top:10%; margin-left: 45%;">
		<img src="<?php echo base_url('img/loading.gif'); ?>">
	</div>
</div>
<style>

	div.ui-dialog {position:fixed;}
	
	a.ui-button.ui-widget.ui-state-default.ui-button-icon-only.custom-combobox-toggle.ui-corner-right {
	    margin-top: 0px !important;
	    position: absolute;
	}
	

</style>

<div class="container">

	<p id="back-top"><a href="#top"><i class="fa fa-arrow-up"></i> Back to Top</a></p>
	<div id="dialog" title="Profile Validation">
        <div class="grid">
            <div class="row">
				<h6 style="margin-top: -10px;">กรุณาระบุรายละเอียดสำหรับการค้นหาข้อมูล โดยกรอกรายชื่อและเบอร์โทร อย่างน้อย 1 รายชื่อ และ 1 เบอร์ติดต่อ.</h6>
            	<div class="input-control text size5" style="margin-top: 10px;">
                    <label class="label">ชื่อสถานที่ประกอบการ <span style="font-size: 0.8em;" class="fg-green">(recommend)</span></label>
                    <input id="company_valid" name="company_valid" type="text" value="">
                </div>
                
                <div class="input-control text size5" style="margin-top: 10px;">
                    <label class="label">ชื่อ - นามสกุล</label>
                    <input id="name_valid" name="name_valid" type="text" value="">                    
                </div>

                <div class="input-control text size5" style="margin-top: 10px;">
                    <label class="label">เบอร์โทรศัพท์ <span style="font-size: 0.8em;" class="fg-green">(recommend)</span></label>
                    <input id="tel_valid" name="tel_valid" type="text" value="">
                </div>
                
                 <div class="input-control text size5" style="margin-top: 10px;">
                    <label class="label">เบอร์มือถือ</label>
                    <input id="mobile_valid" name="mobile_valid" type="text" value="">
                </div>

                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                <div style="margin-top: 20px; height: 60px;">
                    <button id="objCheckInfo" type="button" class="primary">CHECK</button>
                    <span id="progress_valid" class="place-right" style="margin-right: 12%;"><img src="<?php echo base_url().'img/progress-loader.gif'; ; ?>"></span>
                </div>

                <div id="msg_alert_valid" class="text-alert">

                </div>
                
                <?php 
                
                echo "
				<script>
					function closeDialogBox() {
                    	$('#dialog').dialog('close');
                    }	
				</script>";
                
                
                ?>

            </div>
        </div>
    </div>
	
	<div class="grid">
	<div id="form" class="row">
	
		<div class="logo_header">
			<img src="<?php echo base_url('img/logo_form_header.jpg'); ?>">
		</div>
	
	    <div id="form-header">
	        <h2>CUSTOMER PROFILE</h2>
	    </div>
	
	    <div class="profile-progress">
	        <h2>APPLICATION PROGRESS STATUS</h2>
	        <div class="stepper" data-role="stepper" data-steps="3" data-start="1"></div>
	    </div>
	
		
	    <div id="form-frame">
	    <article class="row">
	        <div class="span12" style="margin-bottom: 5px;">
	            <h2 class="span12">PROFILE</h2>
	        </div>
	    </article>
	
		<?php $this->load->helper('form'); ?>
		<?php $attributes = array('id' => 'profiler'); ?>
		<?php echo form_open('metro/profileFormIntial', $attributes); ?>
		
		<input id="fill_branchcode" type="hidden" value="" />
		<input id="fill_source_field_id" name="fill_source_field_id" type="hidden" value="" />
		<input id="fill_source_field" name="fill_source_field" type="hidden" value="" />
	    
	    <fieldset>
	        <legend class="span12 readable-text">Branch Information</legend>
	
	        <article class="span12">
                <section class="span3">
	                <div class="input-control select size3" data-role="input-control">
	                    <div>Branch Code</div>
	                    <!-- <input type="text" name="branchcode" id="branchcode" value="<?php echo !empty($session_data['branchcode'])?$session_data['branchcode']:""; ?>" readonly="readonly"> -->
	                    <select name="branchcode" id="branchcode">
	                    	<option value="N/A"></option>
	                    	<?php 
	                    	
	                    	$IsBranch = !empty($session_data['branchcode']) ? $session_data['branchcode']:"";
				
	                    	if(empty($branchs['data'])) {
								echo '<option value="'.$IsBranch.'">'.$IsBranch.'</option>';

							} else {

								foreach ($branchs['data'] as $index) {

									if($index['BranchCode'] == $IsBranch) { $select = "selected"; } else { $select = ''; }
// 									if($index['BranchCode'] == $IsBranch) { $disable = ""; } else { $disable = 'disabled="disabled"'; }
// 									if(in_array($session_data['emp_id'], array('57251'))) {
// 										$disable = '';
// 									}
									echo '<option value="'.$index['BranchCode'].'" '.$select.'>'.$index['BranchCode'] . ' - ' . $index['BranchDigit'] .'</option>';
									
							
								}
								
							}
	                    	
	                    	?>	
	                    </select>
	                    <div id="bn_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"> Loading...</div>
	                </div>
	            </section>
	
	            <section class="span3" data-hint="Branch|ฟิลด์นี้ไม่สามารถคีย์ข้อมูลหรือแก้ไขข้อมูลได้ " data-hint-position="top">
	                <div class="input-control text size3">
	                    <div>Branch</div>
	                    <input type="text" name="branch" id="branch" value="<?php echo !empty($session_data['branch'])?$session_data['branch']:""; ?>" readonly>
	                </div>
	            </section>
	
	            <section class="span3" data-hint="Region|ฟิลด์นี้ไม่สามารถคีย์ข้อมูลหรือแก้ไขข้อมูลได้ " data-hint-position="top">
	                <div id="parent_region" class="input-control text size3">
	                    <div>Region</div>
	                    <input type="text" name="region" id="region" value="<?php echo !empty($session_data['region'])? strtoupper($session_data['region']):""; ?>" readonly>
	                </div>
	            </section>

	        </article>
	
	        <article class="span12" style="margin-top: 30px;">
	            <section class="input-control text span12">
	                <div class="span3">RM Code 
	                	<span style="color: #d2322d;">*</span>
	                	<div id="rmcode-progress" style="position: absolute; margin-top: -22px; margin-left: 60px;">
		                    <img src="<?php echo base_url('img/progress-loader.gif'); ?>" style=" margin-left: 20px;"> 
		                </div>
	                </div>
	                <div class="input-control text span3" style="margin-left: 20px;">
					    <input name="rmcode" id="rmcode" type="text" value="<?php echo set_value('rmcode'); ?>">
					    <button id="findEmp" type="button" class="btn-search" style="background: #999999; color: #FFFFFF; border-radius: 5px;"></button>
					</div>
					
					<div class="input-control text span3" style="margin-left: 20px;">
					 
					 <div class="input-control checkbox span1">
					 	<div class="span3" style="position: absolute; margin-top: -22px;">Refer By BM</div>
				        <label>
				        	<input id="assign_case" name="assign_case" type="checkbox" value="Y">
				        	<span class="check"></span>
				        </label>
				        </div>
				        <div id="assign_parent" class="input-control text span4" style="margin-left: -30px; max-width: 190px;">
				            <input id="assignname" name="assignname" type="text" disabled="disabled">				            
				        </div>					       		 
					</div>
					
					 <span id="assignname_label" class="span3" style="margin-left: 10px; margin-top: 6px;"></span>		
					
					<!-- 
	                <div class="input-control text">
						<input type="text" name="rmcode" id="rmcode" value="<?php echo set_value('rmcode'); ?>" class="span3">
						<button id="findEmp" type="button" class="btn-search fg-active-grayLight" style="height: 33px; border: 1px solid #D1D1D1;"><i class="fa fa-search"></i></button>
					</div>
				
                    <div class="span1">
                        <button id="findEmp" type="button" class="fg-active-grayLight" style="height: 33px; border: 1px solid #D1D1D1;"><i class="fa fa-search"></i></button>
                    </div>
                    -->
	                
	                <div id="rmvalidate" class="span4" style="margin-left: -15px;"></div>
	            </section>
	        </article>
	
	        <article class="span12">
	            <section class="span3">
	                <div class="input-control text size3">
	                    <div>RM Name</div>
	                    <input type="text" name="empname" id="empname" value="<?php echo set_value('empname'); ?>" data-role="input-control">
	                </div>
	            </section>
	
	            <section class="span3">
	                <div class="input-control text size">
	                    <div>RM Mobile</div>
	                    <input type="text" name="rmmobile" id="rmmobile" value="<?php echo set_value('rmmobile'); ?>">
	                </div>
	            </section>
	
	            <section class="span3 ui-widget">
	                <div class="input-control text size3">
	                    <div>BM Name</div>
	                    <input type="text" name="bm" id="bm" value="<?php echo !empty($session_data['bmname'])?$session_data['bmname']:""; ?>">
	                </div>
	                <span id="bm_progress" style="position: absolute; margin-top: 1.5em;">
	                    <img src="<?php echo base_url('img/ajax-loader.gif'); ?>">
	                </span>
	            </section>
	        </article>
	
	    </fieldset>

	
	    <article class="span12" style="margin-top: 40px;">
	    <fieldset>
	    <legend class="readable-text">Customer Information</legend>
	 	
	 	   
	    <div class="span12" >
	   		<label class="span4">Customer Type</label>
	        <div class="input-control radio" style="margin-left: 20px;">
	            <div class="input-control radio">
	                <label>
	                    <input type="radio" name="register" value="N" checked="checked">
	                    <span class="check"></span> ลูกค้าใหม่
	                </label>
	            </div>
	            <div class="input-control radio" style="margin-left: 29px;">
	                <label>
	                    <input type="radio" name="register" value="A">
	                    <span class="check"></span> ลูกค้าเก่า
	                </label>
	            </div>
	        </div>
	    </div>
	    
	 	<?php 
	 	
	 	if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' || in_array('074008', $session_data['auth'])) :
	 		
	 		echo '
				<div class="span12">
		        	<div class="input-control">
		        	<label class="span4">Create Date</label>
		            	<div class="input-control text span4" id="objcreatedate" style="margin-left: 20px;">
		                	<input type="text" id="createdate" name="createdate" value="">
		                    <div class="btn-date"></div>
						</div>
		        	</div>
		        </div>';
	 		
	 	else:
	 		echo '<input type="hidden" id="createdate" name="createdate" value="">';
	 	endif;
	 		
	 	
	 	?>
	    
	    <div class="span12">
	        <div id="objSource" class="input-control select">
	            <label class="span4">Source of customer</label>
	            <select id="sourceofcustomer" name="sourceofcustomer" class="span4">
	                <option value="" <?php echo set_select('sourceofcustomer', '', TRUE); ?>>-- แหล่งที่มา --</option>
	                <optgroup label="Core Source">
	                	<option value="Field visit">Field visit</option>
	                	<option value="Refer: Thai Life">Refer by Thai Life</option>
	                	<option value="Refer: RM">Refer by RM</option>
	                	<option value="Refer: Customer">Refer by Cust-Suplier</option>
	                </optgroup>
	                <optgroup label="Non-Core Source">
	                	 <option value="Call in">Call in</option>
		                <option value="Walk in">Walk in</option>
		                <option value="Direct mail">Direct mail</option>
		                <option value="Telelist">Telelist</option>		                
	                </optgroup>
	                <optgroup label="Referrel List">
	                	<option value="Refer: BM" style="display: none;">Refer by BM</option>		                
		                <option value="Refer: Full Branch">Refer by Full Branch</option>
		                <option value="Refer: Call Center">Refer by Call Center</option>
		                <option value="Tcrb: Facebook">Refer by TCRB FB</option>
	                 	<option value="Loan Top Up">Loan Top Up</option>
	                 	<option value="Rabbit" disabled="disabled">Refer by Rabbit</option>
	                 	<option value="Fintech" disabled="disabled">Refer by Fintech</option>
	                 	<option value="Livechat" disabled="disabled">Refer by Livechat</option>
	                 	<option value="Import File" style="display: none;">Import File</option>
	                	<option value="TVC" style="display: none;">TVC (โฆษณาทางโทรทัศน์)</option>
	                </optgroup>
	            </select>
	            <div id="sourceofcustomer_alert" class="span4 text-alert" style="margin-left: 0px; padding-left: 35px">*</div>
	        </div>
	    </div>
	    
	    <div id="sourcetextoption" class="span12">
	        <div class="input-control textarea">
	            <div class="span4">โปรดระบุ:</div>
	            <textarea name="sourceoption" id="sourceoption" class="span4" cols="35" rows="3"><?php echo set_value('sourceoption'); ?></textarea>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control select">
	            <label class="span4">สนใจใช้บริการสินเชื่อ</label>
	            <div class="input-control radio" style="margin-left: 20px;">
	                <label>
	                    <input type="radio" name="interest" value="0">
	                    <span class="check"></span> สนใจ
	                </label>
	            </div>
	            <div class="input-control radio" style="margin-left: 5px;">
	                <label>
	                    <input type="radio" name="interest" value="1">
	                    <span class="check"></span> ไม่สนใจ
	                </label>
	            </div>
	            <div class="input-control radio hide" style="margin-left: 5px;">
	                <label>
	                    <input type="radio" name="interest" value="2">
	                    <span class="check"></span> กลับมาสนใจ
	                </label>
	            </div>
	        </div>
	    </div>
	    
	    <div class="span12">
	        <div class="input-control radio" data-hint="Customer Potential|ส่วนประเมินลูกค้าว่าอยู่ในเกณฑ์ใด ซึ่งการประเมินนี้ เป็นการประเมินศักยภาพในการทำสินเชื่อของลูกค้าในอนาคต." data-hint-position="right">
	            <label class="span4">โอกาสการเป็นลูกค้า</label>
	            <div class="input-control radio" style="margin-left: 20px;">
	                <label>
	                    <input type="radio" name="potential" value="0">
	                    <span class="check"></span> H
	                </label>
	            </div>
	            <div class="input-control radio" style="margin-left: 27px;">
	                <label>
	                    <input type="radio" name="potential" value="1">
	                    <span class="check"></span> M
	                </label>
	            </div>
	            <div class="input-control radio" style="margin-left: 40px;">
	                <label>
	                    <input type="radio" name="potential" value="2">
	                    <span class="check"></span> L
	                </label>
	            </div>
	        </div>
	    </div>
	    
	    <div class="span12">
	        <div class="input-control radio">
	            <label class="span4">ประเภทสินเชื่อที่นำเสนอ</label>
	            <div class="input-control radio" style="margin-left: 20px;" data-hint="Nano Finance" data-hint-position="right">
	                <label>
	                    <input type="radio" name="loan_group" value="NN">
	                    <span class="check"></span> NN
	                </label>
	            </div>
	            <div class="input-control radio" style="margin-left: 17px;" data-hint="Micro Finance" data-hint-position="right">
	                <label>
	                    <input type="radio" name="loan_group" value="MF">
	                    <span class="check"></span> MF
	                </label>
	            </div>	    
				<div class="input-control radio" style="margin-left: 33px;" data-hint="Small Business Loan" data-hint-position="right">
	                <label>
	                    <input type="radio" name="loan_group" value="SB">
	                    <span class="check"></span> SB
	                </label>
	            </div>  
	            <div class="input-control radio" style="margin-left: 33px;" data-hint="Micro SME" data-hint-position="right">
	                <label>
	                    <input type="radio" name="loan_group" value="MF SME">
	                    <span class="check"></span> MF SME
	                </label>
	            </div>      
	            <span id="loan_gruop_alert" class="marginLeft20 text-alert"></span>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control text" style="margin: 10px 0;">
	            <div class="span4">
	                <div class="span4">
	                    <div class="input-control radio" style="margin-top: -20px;">
	                        <label class="span4 text">
	                            <input name="ownertype" type="radio" value="0">
	                            <span class="check"></span> ชื่อเจ้าของกิจการ
	                        </label>
	                        <label class="span4 text" style="margin-left: 1px;">
	                            <input name="ownertype" type="radio" value="1">
	                            <span class="check"></span> ชื่อผู้ติดต่อ
	                        </label>
	                    </div>
	                </div>
	            </div>
	            <div class="input-control select span1" style="margin-left: 20px; min-width: 65px;">
	            <select name="prefixname" id="prefixname" class="input-control select" style="height: 34px;">
                        <option value=""></option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">น.ส</option>
                </select>
                </div>
                <div class="input-control text span3">
					<input type="text" name="owner" id="owner" value="<?php echo set_value('owner'); ?>" placeholder="ชื่อ-นามสกุล" style="margin-left: 3px; min-width: 230px;">
					<button class="btn-clear"></button>
				</div>
	            <div id="owner_alert" class="span4 text-alert" style="margin-left: 0px; padding-left: 35px">*</div>
	        </div>
	    </div>
	
	    <div class="span12" style="margin-top: 3px;">
	        <div class="input-control text">
	            <div class="span4">ชื่อสถานที่ประกอบการ</div>
	            <div class="input-control select span1" style="margin-left: 20px; min-width: 65px;">
	            <select name="prefixcorp" id="prefixcorp" class="input-control select" style="height: 34px;">
                        <option value=""></option>
                        <option value="ร้าน">ร้าน</option>
                        <option value="บจก">บจก</option>
                        <option value="หจก">หจก</option>
                        <option value="หสม">หสม</option>
                        <option value="บมจ">บมจ</option>
                </select>
                </div>
                <div class="input-control text span3">
					<input type="text" name="company" id="company" value="<?php echo set_value('company'); ?>" style="margin-left: 3px; min-width: 230px;">
					<button class="btn-clear"></button>
			   </div>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control select">
	            <div class="span4">ประเภทธุรกิจ</div>
	            <select id="businesstype" name="businesstype" class="span4">
	                <option value="" <?php echo set_select('businesstype', '', TRUE); ?>>-- ประเภทธุรกิจ --</option>
	                <option value="Professional/Freelance">Professional/Freelance</option>
	                <option value="การเกษตร">การเกษตร</option>
	                <option value="การบริการ">การบริการ</option>
	                <option value="การผลิต">การผลิต</option>
	                <option value="ค้าปลีก">ค้าปลีก</option>
	                <option value="ค้าส่ง">ค้าส่ง</option>
	                <option value="ทนายความ">ทนายความ</option>
	                <option value="ที่ปรึกษา">ที่ปรึกษา</option>
	                <option value="ปั๊มน้ำมัน">ปั๊มน้ำมัน</option>
	                <option value="เภสัชกร">เภสัชกร</option>
	                <option value="ร้านตัดผม">ร้านตัดผม</option>
	                <option value="ร้านทอง (ค้าปลีก)">ร้านทอง (ค้าปลีก)</option>
	                <option value="โรงแรม">โรงแรม</option>
	                <option value="วิศวกร">วิศวกร</option>
	                <option value="สถาปนิก">สถาปนิก</option>
	                <option value="สปา/Health Club">สปา/Health Club</option>
	                <option value="เหล้า เบียร์ บุหรี่">เหล้า เบียร์ บุหรี่</option>
	                <option value="อพาร์ทเม้นท์">อพาร์ทเม้นท</option>
	                <option value="อื่นๆ">อื่นๆ</option>
	            </select>				
	            <div id="businesstype_alert" class="span3 text-alert" style="margin-left: 20px;">*</div>
	        </div>
	       
	    </div>
	
	    <div id="business-free" class="span12">
	        <div class="input-control textarea">
	            <div class="span4">ธุรกิจ / กิจการเกี่ยวกับ</div>
	            <textarea id="business"  name="business" cols="35" rows="3" class="span4"><?php echo set_value('business'); ?></textarea>
	            <div class="span3 text-alert"></div>
	        </div>
	    </div>
	
	    <div id="parent_tel" class="span12">
	        <div class="input-control span8 text tooltip-right" data-tooltip="คำแนะนำ: ควรเป็นเบอร์ที่ใช้ในธุรกิจ เบอร์ร้าน หรือ เบอร์ สนง. เป็นต้น">
	            <div class="span4">เบอร์ติดต่อ (สำนักงาน)</div>
	            <input type="text" name="telephone" id="telephone" class="span4" value="<?php echo set_value('telephone'); ?>">
	        </div>
	        <div id="tel_alert" class="span3 text-alert" style="margin-left: 20px;">*</div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control text span8 text tooltip-right" data-tooltip="คำแนะนำ: ควรเป็นเบอร์ที่ใช้ส่วนตัวขอลูกค้า เช่น เบอร์มือถือ เป็นต้น">
	            <div class="span4">เบอร์ติดต่อ 2 </div>
	            <input type="text" name="mobile" id="mobile" class="span4" value="<?php echo set_value('mobile'); ?>" class="span4">
	        </div>
	         <div id="mobile_alert" class="span3 text-alert">*</div>
	    </div>
	
	    <div class="span12 ui-widget">
	        <div class="input-control text">
	            <div class="span4 ui-widget">ย่านธุรกิจ</div>
	            <input type="text" name="downtown" id="downtown" class="span4" value="<?php echo set_value('downtown'); ?>">
	            <div id="dt_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"></div>
	            <div id="downtown_alert" class="span3 text-alert">*</div>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div id="textarea_add" class="input-control textarea">
	            <div class="span4">ที่อยู่</div>
	            <textarea id="address"  name="address" cols="35" rows="3" class="span4" style="font-size: 0.8em; font-weight: normal;"><?php echo set_value('address'); ?></textarea>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div id="parent_province" class="input-control select">
	            <div class="span4">จังหวัด</div>
	            <select id="province" name="province" class="span2 ui-widget">
                    <option value="N/A" selected></option>
                    <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
                    <option value="กระบี่">กระบี่</option>
                    <option value="กาญจนบุรี">กาญจนบุรี</option>
                    <option value="กาฬสินธุ์">กาฬสินธุ์</option>
                    <option value="กำแพงเพชร">กำแพงเพชร</option>
                    <option value="ขอนแก่น">ขอนแก่น</option>
                    <option value="จันทบุรี">จันทบุรี</option>
                    <option value="ฉะเชิงเทรา">ฉะเชิงเทรา</option>
                    <option value="ชัยนาท">ชัยนาท</option>
                    <option value="ชัยภูมิ">ชัยภูมิ</option>
                    <option value="ชุมพร">ชุมพร</option>
                    <option value="ชลบุรี">ชลบุรี</option>
                    <option value="เชียงใหม่">เชียงใหม่</option>
                    <option value="เชียงราย">เชียงราย</option>
                    <option value="ตรัง">ตรัง</option>
                    <option value="ตราด">ตราด</option>
                    <option value="ตาก">ตาก</option>
                    <option value="นครนายก">นครนายก</option>
                    <option value="นครปฐม">นครปฐม</option>
                    <option value="นครพนม">นครพนม</option>
                    <option value="นครราชสีมา">นครราชสีมา</option>
                    <option value="นครศรีธรรมราช">นครศรีธรรมราช</option>
                    <option value="นครสวรรค์">นครสวรรค์</option>
                    <option value="นราธิวาส">นราธิวาส</option>
                    <option value="น่าน">น่าน</option>
                    <option value="นนทบุรี">นนทบุรี</option>
                    <option value="บึงกาฬ">บึงกาฬ</option>
                    <option value="บุรีรัมย์">บุรีรัมย์</option>
                    <option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์</option>
                    <option value="ปทุมธานี">ปทุมธานี</option>
                    <option value="ปราจีนบุรี">ปราจีนบุรี</option>
                    <option value="ปัตตานี">ปัตตานี</option>
                    <option value="พะเยา">พะเยา</option>
                    <option value="อยุธยา">อยุธยา</option>
                    <option value="พังงา">พังงา</option>
                    <option value="พิจิตร">พิจิตร</option>
                    <option value="พิษณุโลก">พิษณุโลก</option>
                    <option value="เพชรบุรี">เพชรบุรี</option>
                    <option value="เพชรบูรณ์">เพชรบูรณ์</option>
                    <option value="แพร่">แพร่</option>
                    <option value="พัทลุง">พัทลุง</option>
                    <option value="ภูเก็ต">ภูเก็ต</option>
                    <option value="มหาสารคาม">มหาสารคาม</option>
                    <option value="มุกดาหาร">มุกดาหาร</option>
                    <option value="แม่ฮ่องสอน">แม่ฮ่องสอน</option>
                    <option value="ยโสธร">ยโสธร</option>
                    <option value="ยะลา">ยะลา</option>
                    <option value="ร้อยเอ็ด">ร้อยเอ็ด</option>
                    <option value="ระนอง">ระนอง</option>
                    <option value="ระยอง">ระยอง</option>
                    <option value="ราชบุรี">ราชบุรี</option>
                    <option value="ลพบุรี">ลพบุรี</option>
                    <option value="ลำปาง">ลำปาง</option>
                    <option value="ลำพูน">ลำพูน</option>
                    <option value="เลย">เลย</option>
                    <option value="ศรีสะเกษ">ศรีสะเกษ</option>
                    <option value="สกลนคร">สกลนคร</option>
                    <option value="สงขลา">สงขลา</option>
                    <option value="สมุทรสาคร">สมุทรสาคร</option>
                    <option value="สมุทรปราการ">สมุทรปราการ</option>
                    <option value="สมุทรสงคราม">สมุทรสงคราม</option>
                    <option value="สระแก้ว">สระแก้ว</option>
                    <option value="สระบุรี">สระบุรี</option>
                    <option value="สิงห์บุรี">สิงห์บุรี</option>
                    <option value="สุโขทัย">สุโขทัย</option>
                    <option value="สุพรรณบุรี">สุพรรณบุรี</option>
                    <option value="สุราษฎร์ธานี">สุราษฎร์ธานี</option>
                    <option value="สุรินทร์">สุรินทร์</option>
                    <option value="สตูล">สตูล</option>
                    <option value="หนองคาย">หนองคาย</option>
                    <option value="หนองบัวลำภู">หนองบัวลำภู</option>
                    <option value="อำนาจเจริญ">อำนาจเจริญ</option>
                    <option value="อุดรธานี">อุดรธานี</option>
                    <option value="อุตรดิตถ์">อุตรดิตถ์</option>
                    <option value="อุทัยธานี">อุทัยธานี</option>
                    <option value="อุบลราชธานี">อุบลราชธานี</option>
                    <option value="อ่างทอง">อ่างทอง</option>
	            </select>
	            <span id="pv_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>
	            <span id="province_alert" class="text-alert" style="margin-left: 35px;">*</span>
	            <!-- <button type="button" id="clear_province" style=""><i class="icon-remove on-left"></i></button> -->
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control select">
	            <div class="span4">
	            	อำเภอ  
	            	<span id="loadDistrict" style="padding-left: 0.1em; font-size: 0.7em;">
	            		<i class="fa fa-refresh fg-lightBlue" data-hint="List not found|หากรายการข้อมูลไม่แสดง (คลิก เพื่อโหลดใหม่)" data-hint-position="top"></i>
	            	</span>
	            </div>
	            <select name="district" id="district" class="span4 ui-widget"></select>	           
	            <div id="ds_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"></div>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control text">
	            <div class="span4">
	            	รหัสไปรษณีย์  
	            	<span id="loadPostCode" style="padding-left: 0.1em; font-size: 0.7em;">
	            		<i class="fa fa-refresh fg-lightBlue" data-hint="List not found|หากรายการข้อมูลไม่แสดง (คลิก เพื่อโหลดใหม่)" data-hint-position="top"></i>
	            	</span>
	            </div>
	            <input type="text" name="postcode" id="postcode" class="span4" value="<?php echo set_value('postcode'); ?>">
	            <div id="postcode_alert" class="span3 text-alert">*</div>
	        </div>
	    </div>
	    
	   <div class="span12">
	        <div class="input-control select">
	            <div class="span4">
	            	ประเภทช่องทางสื่อ  
	            	<span id="loadChannel" style="padding-left: 0.1em; font-size: 0.7em;">
	            		<i class="fa fa-refresh fg-lightBlue" data-hint="List not found|หากรายการข้อมูลไม่แสดง (คลิก เพื่อโหลดใหม่)" data-hint-position="top"></i>
	            	</span>
	            </div>
	            <select id="channelmode" name="channelmode" class="span4"></select>
	            <div id="ch_header_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"></div>
	            <div id="channelmode_alert" class="span3 text-alert">*</div>
	            <!-- <input id="channelmode" name="channelmode" value="<?php echo set_value('channelmode'); ?>" class="span4" data-hint="ประเภทช่องทาง|ฟิลด์ประเภทช่องทางไม่สามารถคีย์ข้อมูลหรือแก้ไขข้อมูลได้ ข้อมูลจะเกิดขึ้นเมื่อเลือกช่องทางข่าวสาร." data-hint-position="right" readonly>  -->
	        </div>
	    </div>
	
	    <div class="span12">
	        <div id="parent_channel" class="input-control select">
	            <div class="span4">
	            	รับทราบจากช่องทางสื่อ 
	            	<span id="loadSubChannel" style="padding-left: 0.1em; font-size: 0.7em;">
	            		<i class="fa fa-refresh fg-lightBlue" data-hint="List not found|หากรายการข้อมูลไม่แสดง (คลิก เพื่อโหลดใหม่)" data-hint-position="top"></i>
	            	</span>
	            </div>
	            <select id="channelmodule" name="channelmodule" class="span4" disabled="disabled" style="background-color: #EBEBE4; cursor: no-drop;"></select>
	            <div id="ch_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"></div>
	            <div id="channel_alert" class="span3 text-alert">*</div>
	        </div>
	    </div>
	
	    <div class="span12">
	        <div class="input-control text">
	            <div class="span4">วงเงินที่ต้องการ (บาท)</div>
	            <input name="loanrequest" id="loanrequest" class="span4" value="<?php echo set_value('loanrequest'); ?>">
	        </div>
	    </div>
	
	    <div class="span12" style="display: none;">
	        <div class="span4" style="margin-right: 20px;">
	            <div id="loadAppointment">
	            	วันนัดพบครั้งถัดไป
	            	<span style="padding-left: 0.1em; font-size: 0.7em; cursor: pointer;">
	            		<i class="fa fa-refresh fg-lightBlue" data-hint="List not found|หากรายการข้อมูลไม่แสดง (คลิก เพื่อโหลดใหม่)" data-hint-position="top"></i>
	            	</span>
	            </div>
	        </div>
	        <div id="duedatestatus" class="input-control select span2" style="min-width: 180px;">
	            <select id="" name="duedatestatus" style="height: 34px;"></select>
	        </div>
	        <div id="dueclndr" class="input-control text span2" style="max-width: 115px; margin-left: 5px;">
	            <input type="text" id="duedate" name="duedate" value="<?php echo set_value('duedate'); ?>">
	            <button class="btn-clear" tabindex="-1" type="button" onclick="$('#duedate').val('');"></button>
	        </div>
	        <div class="input-control checkbox" data-hint="End Event|เมื่อทำการติ๊กระบบจะปิดการแจ้งเตือนการนัดหมาย." data-hint-position="right" style="display: none;">
				<label style="margin-left: 5px;">
					<input type="checkbox" name="endevent" id="endevent" value="1">
					<span class="check"></span> <i class="fa fa-bell-slash-o"></i> End Event
				</label>
			</div>
	    </div>
	    
	    <div id="duetextoption" class="span12">
	        <div class="input-control textarea">
	            <div class="span4">โปรดระบุ:</div>
	            <textarea name="dueoption" id="dueoption" class="span4" cols="35" rows="3" style="font-size: 0.8em; font-weight: normal;"><?php echo set_value('dueoption'); ?></textarea>
	        </div>
	    </div>
	   
	    <div class="span12">
	    	<label class="span4">Basic Criteria <span class="text-warning"><small>(กรุณีลูกค้าไม่ผ่านเกณฑ์เบื้องต้นคลิก)</small></span></label>
	        <div class="input-control checkbox span1" data-hint="Basic Criteria|เมื่อทำการคลิกเลือกหมายความว่าลูกค้าคนนี้  ไม่ผ่านเกณฑ์เบื้องต้น ในกรณีผ่านเกณฑ์ไม่ต้องคลิกเลือก." data-hint-position="top">
	        <label>
	        	<input type="checkbox" id="criteria" name="criteria" value="1">
	        	<span class="check"></span>
	        </label>
	        </div>
	        <div id="criteria_parent" class="input-control select span4" style="margin-left: -30px; max-width: 270px;">
	            <select id="criteria_reason" name="criteria_reason"></select>
	        </div>
	        <div id="criteriareason_progress" class="span1"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></div>
	        <span id="criteria_alert"  class="span3 text-alert"></span>
	    </div>
	    
	    <div id="refertl_element" class="span12">
	        <div class="input-control text">
	            <div class="span4">Refer by TL Agent</div>
	            <input id="referralcode" name="referralcode" type="text" class="span4" value="<?php echo set_value('referralcode'); ?>" maxlength="8" readonly="readonly" style="background-color: #EBEBE4;">
	            <span id="parent-pop-async" class="span1"><i id="show-pop-async" class="ti-id-badge fg-darkCyan" style="font-size: 1.4em; cursor: pointer;"></i></span>
	            <span id="refer_alert" class="span3 text-alert" style="margin-left: -20px;"></span>
	        </div>
	    </div>
	    
	    <!-- 
	    <div id="referbm_element" class="span12 hide">
	    	<label id="refer_emp" class="span4">Refer by BM </label>
	    	<div class="input-control checkbox span1" style="display: none;">
		        <label>
		        	<input id="refer_bm_criteria" name="refer_bm_criteria" type="checkbox" value="1">
		        	<span class="check"></span>
		        </label>
	        </div>	        
	        <div id="refer_bm_parent" class="input-control text span4" style="margin-left: 20px; max-width: 300px;">
	            <input id="refer_bm" name="refer_bm" type="text" value="">
	            <input id="refer_bmcode" name="refer_bmcode" type="hidden" value="">
	        </div>
	        <div id="refer_bm_progress" class="span1 hide"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></div>
	        <span id="refer_bm_alert" class="text-alert" style="margin-top: 5px;"></span>
	    </div>
	     -->
	     
	    <div class="span12">
	        <div class="input-control textarea">
	            <div class="span4">Remark</div>
	            <textarea name="remark" id="remark" class="span4" cols="35" rows="3" style="font-size: 0.8em; font-weight: normal;"><?php echo set_value('remark'); ?></textarea>
	        </div>
	    </div>
	
	    <div class="span12">&nbsp;</div>
	    <div class="span12">
	        <div class="span6">
	            <div id="progresses" class="span1"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="visibility: hidden;"></div>
	            
	        </div>
	
	        <div class="span6" style="padding-left: 60px;">	        	
	            <button id="submit" name="submit" type="submit" style="min-width: 80px; height: 34px;" class="bg-lightBlue fg-white"><i class="fa fa-save on-left"></i>Submit</button>
	        </div>
	    </div>
	
		
	    </fieldset>
	    </article>
	    </form>
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
			
			if(!empty($succesess)) {
					
				if($succesess['status'] === true && $succesess['access'] == "success") {
					echo '<div class="span12" style="margin-top: 10px;"><p class="alert alert-success text-success" role="alert"><i class="icon-checkmark on-left text-success"></i> '.$succesess['msg'].'<p></div>';
						
				}
					
			}
			
			$forms = isset($_GET['forms']);
			if(!empty($forms) && $forms == 'success') {
				echo '<div class="span12" style="margin-top: 10px;"><p class="alert alert-success text-success" role="alert"><i class="icon-checkmark on-left text-success"></i> '."บันทึกข้อมูลสำเร็จ. สามารถดูข้อมูลลูกค้าได้ที่ <a href='".site_url('metro/routers?_=').md5(date('s'))."&cache=".true."&req=P1&live=1&rel=".$_GET['rel']."' target='_BLANK'>ดูข้อมูลลูกค้า</a>".'<p></div>';
			}
	    
	    ?>
	    
	    <div id="form_footer">
	    	<img src="<?php echo base_url('img/logo_form_footer.jpg'); ?>" style="margin-top: 50px;">
	    </div>
	      
	    
	</div>
	</div>
</div>

<script type="text/javascript">

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

// ######## HANDLED #######
function field_validation(element) {

	 var tl_code = $(element).val();
	 if(tl_code == '') {
		
		 var not = $.Notify({ content: "กรุณากรอกรหัส Referral Code..", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
			 not.close(7000);	
	 		
	 } else {

		 if(tl_code.length < 8) {
			
			 var not = $.Notify({ content: "Referral Code น้อยกว่า 8 หลัก กรุณาตรวจสอบใหม่อีกครั้ง", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				 not.close(7000);	
				 
		 } else {

			 $.ajax({
				url: pathFixed + 'dataloads/checkTLAUnique?_=' + new Date().getTime(),
				type: "POST",
				data: { cox: $(element).val() },
				success:function(responsed) {
		
					if(responsed['status']) {
					
						 var not = $.Notify({ content: "ไม่พบหมายเลข Referral Code นี้ในระบบ.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
						 not.close(7000);	
		  	  			
					} else {

						$('#referralcode').val(tl_code);
						$('#refer_alert').text('');
						$.Dialog.close();
						
					}
					
				},
				cache: false,
				timeout: 5000,
				statusCode: {
					404: function() { alert( "page not found" ); },
			        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); }
				}
				
			});
			
		 } 

	 }

}

$('#parent-pop-async').click(function() {

	var tl_agent_code = $('#referralcode').val();
	if(tl_agent_code == '') {
		var not = $.Notify({ content: "กรุณากรอกรหัส Referral Code", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
		not.close(7000);
	}
	 
});

$('#parent-pop-async').hover(function() {
	
	var tl_agent_code = $('#referralcode').val();
	if(tl_agent_code != '') {
		
		var settings = {
				trigger:'click',
				width: 'auto',						
				multi:true,						
				closeable: false,
				style:'',
				delay:300,
				padding: true,
				backdrop:false
		};

		
		var asyncSettings = {	
			width:'auto',
			height:'auto',
			closeable: false,
			padding:false,
			cache:false,
			url: pathFixed + 'dataloads/getTLADataDetail?_='  + new Date().getTime() + '&getdesc=true&tl_ref=' + tl_agent_code,	
			type:'async',
			content: function(data) {

				if(data['status']) {
					var html = 
						'<table class="table table-bordered">' +
							'<thead>' +
								'<tr>' +
									'<th colspan="4">THAI LIFE AGENT</th>' +
								'</tr>' +
								'<tr style="background-color: #3175AF; color: #FFF;">' +
									'<th class="text-center">CODE</th>' +
									'<th class="text-center">NAME</th>' +
									'<th class="text-center">TL BRANCH</th>' +
									'<th class="text-center">POSITION</th>' +
									'<th class="text-center">MOBILE</th>' +
								'</tr>' +
							'</thead>' +
							'<tbody>' +
								'<td>' + data['data'][0]['TLA_Code'] + '</td>' +
								'<td>' + data['data'][0]['TLA_Name'] + '</td>' +
								'<td>' + data['data'][0]['TLA_BranchName'] + '</td>' +
								'<td>' + data['data'][0]['TLA_Position'] + '</td>' +								
								'<td>' + data['data'][0]['TLA_Mobile'] + '</td>' +
							'</tbody>' +
						'</table>';

						return html;
				} else {
					return 'ไม่พบข้อมูล';
				}

			}
		};
				
		$('#show-pop-async').webuiPopover('destroy').webuiPopover($.extend({}, settings, asyncSettings));
		
	} 
	
}); 

function check_refercode() {
	var element_alerted = $('#refer_alert');
	 if(referralcode == '999999999') {
							 
	 } else {
		 
		 $.ajax({
			url: pathFixed + 'dataloads/checkTLAUnique?_=' + new Date().getTime(),
			type: "POST",
			data: { cox: referralcode },
			success:function(responsed) {
				
				if(responsed['status'] == true) {
				
					var not = $.Notify({ content: "กรุณาตรวจสอบรหัสตัวแทนใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
					not.close(7000);
					
					$("#refer_alert").focus().parent().addClass('error-state');
	                element_alerted.html('* กรุณาตรวจสอบรหัสตัวแทน.');
					 
					return false;
					
				} else {
					return true;
				}
				
			},
			cache: false,
			timeout: 5000,
			statusCode: {
				404: function() { alert( "page not found" ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); }
			}
			
		});
		 
	 }
}

$('#referralcode').blur(function() {
	var refercode = $(this).val();
	if($(this).val() == '99999999') {
		$('#submit').removeAttr('disabled');
		
	} else {
		
		$.ajax({
			url: pathFixed + 'dataloads/checkTLAUnique?_=' + new Date().getTime(),
			type: "POST",
			data: { cox: $(this).val() },
			success:function(responsed) {
				if(refercode !== "") {					
					if(responsed['status'] == true) {
						
						var not = $.Notify({ content: "ไม่พบรหัสตัวแทน กรุณาตรวจสอบรหัสตัวแทนใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });

						$('#submit').attr('disabled', 'disabled');
						$("#refer_alert").focus().parent().addClass('error-state');
		            
						
					} else {

						var not = $.Notify({ content: "รหัสตัวแทนถูกต้อง.", style: { background: '#60A917 ', color: '#FFFFFF' }, timeout: 10000 });
						
						$("#refer_alert").focus().parent().removeClass('error-state').addClass('success-state');
						$('#submit').removeAttr('disabled');
					}
				} 				
			},
			cache: false,
			timeout: 5000,
			statusCode: {
				404: function() { alert( "page not found" ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); }
			}
			
		});
		
	}

});


// ##### FUNCTION ####
function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9\-]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

</script>