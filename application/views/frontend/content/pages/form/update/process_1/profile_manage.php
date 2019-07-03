 <style>

    .case_history { 
    	height: 32px; 
    	width: 150px; 
    	text-align: center; 
    	padding: 5px; 
    	color: white; 
    	position: absolute;
    	margin-top: 50px;
    	margin-left: -200px;
    }
    
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
	
	a.ui-button.ui-widget.ui-state-default.ui-button-icon-only.custom-combobox-toggle.ui-corner-right {
	    margin-top: 0px !important;
	    position: absolute;
	}
	

</style>

<div class="text_float"><h2>Edit Form</h2></div>

<div class="container">

	<p id="back-top"><a href="#top"><i class="fa fa-arrow-up"></i> Back to Top</a></p>

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
		<div id="appProgress" class="stepper" data-role="stepper" data-steps="3" data-start="1"></div>
	</div>
	
	
	<div id="form-frame">
	
	<?php     	
    	$hide_attr= '';
    	$none_style= '';
		$disable_attr= '';
		if(in_array($session_data['role'], array('adminbr_role'))):
			$disable_attr = 'disabled="disabled"';
			$none_style = 'style="display: none;"';
			$hide_attr = 'display: none;';
			echo '<div id="check_denied_role" class="row" data-attr="denied"><div class="label error span12" style="padding: 5px 3px;">ขออภัย, คุณไม่มีสิทธิ์ในการแก้ไขข้อมูล</div></div>';
		endif;
	?>
	
	<article class="row">		
	    <div class="span12" style="margin-bottom: 5px;">
	    	<h2 class="span12">PROFILE</h2>
		</div>
	</article>

    <?php $this->load->helper('form'); ?>
    <?php $this->load->library('form_validation'); ?>

    <?php $attributes = array('id' => 'profiler'); ?>
    <?php echo form_open('metro/profileupdateFormInitial', $attributes); ?>
    
    <input id="fill_branchcode" type="hidden" value="" />
	<input id="fill_source_field_id" name="fill_source_field_id" type="hidden" value="" />
	<input id="fill_source_field" name="fill_source_field" type="hidden" value="" />

	<article class="span12">
	    <fieldset>
	        <legend class="span12">Branch Information</legend>
			<?php 
				
				$check_role = $user_role;
				$auth_edit  = array('57251', '56225', '58106', '56679', '57568', '59440');
				$authBMEdit = array('adminbr_role', 'bm_role', 'dev_role');
				if(in_array($session_data['emp_id'], $auth_edit)) {
					$data_fieldlock = '';
					$field = 'select';
					$bm_lock_field	= '';
					$bm_edit_rm		= '';
					
				} else {
				
					if(in_array($check_role, $authBMEdit)) { 
						if(!empty($results['data'][0]['IsAssignCase']) && $results['data'][0]['IsAssignCase'] == 'Y') {
							$bm_edit_rm = '';
						} else {
							$bm_edit_rm = 'readonly="readonly" style="background: #EBEBE4;"';
						}
					}
				
					$data_fieldlock = 'readonly="readonly" style="background: #EBEBE4;"';
					$field = 'text';
					$bm_lock_field = (!empty($results['data'][0]['IsAssignCase']) && $results['data'][0]['IsAssignCase'] == 'Y') ? 'disabled':'';
				}
			
			?>

	        <article class="span12">
                <section class="span3">
	                <div class="input-control <?php echo $field; ?> size3" data-role="input-control">
	                    <div>Branch Code</div>
                        <!-- <input type="text" name="branchcode" id="branchcode" value="<?php echo !empty($results['data'][0]['BranchCode']) ? $results['data'][0]['BranchCode']:"000"; ?>" readonly> -->
                        <?php 
                        
                        	if(in_array($session_data['emp_id'], $auth_edit)):
                        	
                        		echo '<select name="branchcode" id="branchcode" '.$disable_attr.'>
    								  <option value="N/A"></option>';
                        	
		                        		$IsBranch = !empty($session_data['branchcode'])?$session_data['branchcode']:"";
		                        		
		                        		if(empty($branchs['data'])) {
		                        			echo '<option value="'.$IsBranch.'">'.$IsBranch.'</option>';
		                        		
		                        		} else {
		                        		
		                        			foreach ($branchs['data'] as $index) {
		                        		
		                        				//if($index['BranchCode'] == $IsBranch) { $select = "selected"; } else { $select = ''; }
		                        				if($index['BranchCode'] == $results['data'][0]['BranchCode']) { $select = "selected"; } else { $select = ''; }
		                        				echo '<option value="'.$index['BranchCode'].'" '.$select.'>'.$index['BranchCode']. ' - ' . $index['BranchDigit'] .'</option>';
		                        					
		                        					
		                        			}
		                        		
		                        		}
                        	
                        		echo '</select>';
                        	
                        	else:
                        	
                        		$branch_lock = !empty($results['data'][0]['BranchCode']) ? $results['data'][0]['BranchCode']:"000";
                        		echo '<input type="text" name="branchcode" id="branchcode" value="'.$branch_lock.'" '.$data_fieldlock.' '.$disable_attr.'>';                        	                        	
                        	
                        	endif;
                        
                        ?>
                        <!-- 
                        <select name="branchcode" id="branchcode">
	                    	<option value="N/A"></option>
	                    	<?php 
	                    	
	                    	$IsBranch = !empty($session_data['branchcode'])?$session_data['branchcode']:"";

	                    	if(empty($branchs['data'])) {
								echo '<option value="'.$IsBranch.'">'.$IsBranch.'</option>';

							} else {

								foreach ($branchs['data'] as $index) {

									//if($index['BranchCode'] == $IsBranch) { $select = "selected"; } else { $select = ''; }
									if($index['BranchCode'] == $results['data'][0]['BranchCode']) { $select = "selected"; } else { $select = ''; }
									echo '<option value="'.$index['BranchCode'].'" '.$select.'>'.$index['BranchCode']. ' - ' . $index['BranchDigit'] .'</option>';
									
							
								}
								
							}
	                    	
	                    	?>	
	                    </select>
	                    -->
	                    <div id="bn_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"> Loading...</div>
	                </div>
	            </section>

                <section class="span3" data-hint="Branch|ฟิลด์นี้ไม่สามารถคีย์ข้อมูลหรือแก้ไขข้อมูลได้ " data-hint-position="top">
	                <div class="input-control text size3">
	                    <div>Branch</div>
	                    <input type="text" name="branch" id="branch" value="<?php echo !empty($results['data'][0]['Branch']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Branch']):""; ?>" readonly>
	                </div>
	            </section>

                <section class="span3" data-hint="Branch|ฟิลด์นี้ไม่สามารถคีย์ข้อมูลหรือแก้ไขข้อมูลได้ " data-hint-position="top">
	                <div class="input-control text size3">
	                    <div>Region</div>
                        <input type="text" name="region" id="region" value="<?php echo !empty($results['data'][0]['Region'])?$results['data'][0]['Region']:""; ?>" readonly>
	                </div>
	            </section>
	        </article>
	        
			<!-- 
            <article class="span12" style="margin-top: 15px;">
                <section class="input-control text span12">
                    <div class="span3">RM Code <span style="color: #d2322d;">*</span></div>
                    <input type="text" name="rmcode" id="rmcode" value="<?php echo !empty($results['data'][0]['RMCode'])?$results['data'][0]['RMCode']:""; ?>" class="span3" <?php echo (in_array($check_role, $authBMEdit)) ? $bm_edit_rm:$data_fieldlock; ?>>
                    <div class="span1">
                        <button id="findEmp" type="button" class="fg-active-grayLight" style="height: 33px; border: 1px solid #D1D1D1;"><i class="fa fa-search"></i></button>
                        
                    </div>
                    
                    <div id="rmcode-progress">
                        <img src="<?php echo base_url('img/progress-loader.gif'); ?>" style="margin-left: 20px;">
                    </div>
                    <div id="rmvalidate" class="span4" style="margin-left: -15px;"></div>
                </section>
            </article>
            -->
             
            <article class="span12" style="margin-top: 30px;">
	            <section class="input-control text span12">
	                <div class="span3">RM Code 
	                	<span style="color: #d2322d;">*</span>
	                	<div id="rmcode-progress" style="position: absolute; margin-top: -22px; margin-left: 60px;">
		                    <img src="<?php echo base_url('img/progress-loader.gif'); ?>" style=" margin-left: 20px;"> 
		                </div>
	                </div>
	                <div class="input-control text span3" style="margin-left: 20px;">
					    <input name="rmcode" id="rmcode" type="text" value="<?php echo !empty($results['data'][0]['RMCode']) ? $results['data'][0]['RMCode']:""; ?>" <?php echo (in_array($session_data['emp_id'], $auth_edit) || (in_array($check_role, $authBMEdit) && empty($results['data'][0]['BorrowerName']))) ? '':'readonly="readonly" style="background: #EBEBE4;"'; ?>>
					    <button id="findEmp" type="button" class="btn-search" style="background: #999999; color: #FFFFFF; border-radius: 5px;"></button>
					</div>
					
					<div class="input-control text span3" style="margin-left: 20px;">
					 
					 <div class="input-control checkbox span1">
					 	<div class="span3" style="position: absolute; margin-top: -22px;">Refer By BM</div>
				        <label>
				        	<input id="assign_case" name="assign_case" type="checkbox" value="Y" <?php echo (!empty($results['data'][0]['IsAssignCase']) && $results['data'][0]['IsAssignCase'] == 'Y') ? 'checked="checked"':""; echo $bm_lock_field; ?> >
				        	<span class="check"></span>
				        </label>
				        </div>
				        <div id="assign_parent" class="input-control text span4" style="margin-left: -30px; max-width: 190px;">
				            <input id="assignname" name="assignname" type="text" value="<?php echo !empty($results['data'][0]['AssignByID']) ? $results['data'][0]['AssignByID']:""; ?>" <?php echo $data_fieldlock; ?>>				            
				        </div>					       		 
					</div>
					
					<span id="assignname_label" class="span3" style="margin-left: 10px; margin-top: 6px;"></span>		
	
	                <div id="rmvalidate" class="span4" style="margin-left: -15px;"></div>
	            </section>
	        </article>
       
	        <article class="span12 marginTop5">
	            <section class="span3">
	                <div class="input-control text size3">
	                    <div>RM Name</div>
                        <input type="text" name="empname" id="empname" value="<?php echo !empty($results['data'][0]['RMName']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['RMName']):""; ?>">
	                </div>
	            </section>
	
	            <section class="span3">
	                <div class="input-control text size">
	                    <div>RM Mobile</div>
	                    <input type="text" name="rmmobile" id="rmmobile" value="<?php echo !empty($results['data'][0]['RMMobile']) ? $results['data'][0]['RMMobile']:""; ?>">
	                </div>
	            </section>

                <section class="span3 ui-widget">
                    <div class="input-control text size3">
                        <div>BM Name</div>
                        <input type="text" name="bm" id="bm" value="<?php echo !empty($results['data'][0]['BMName']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['BMName']):""; ?>">
                    </div>
	                <span id="bm_progress" style="position: absolute; margin-top: -22px; margin-left: 200px; display: none;">
	                    <img src="<?php echo base_url('img/ajax-loader.gif'); ?>">
	                </span>
                </section>
                  
	        </article>
	        
	         <small class="span12 text-warning marginTop10">(ในกรณีต้องการเปลี่ยนแปลงข้อมูล RM/Branch กรุณาติดต่อผู้ดูแลระบบ.)</small>
	
	    </fieldset>
	</article>
	
	
	<article class="span12" style="margin-top: 15px;">
	<fieldset>
	<legend>Customer Information</legend>
	
	<div class="span12"><input type="hidden" name="docid" id="docid" value="<?php echo !empty($_GET['rel']) ? $_GET['rel']:""; ?>"></div>
	

	<div class="span12">
        <div class="input-control">
        	<label class="span4">Create Date</label>
        		<?php 
				
				$auth_adminis 	= $this->config->item('Administrator');
				$create_date	= !empty($results['data'][0]['CreateDate']) ? StandartDateRollback($results['data'][0]['CreateDate']):"";
				if(in_array($session_data['emp_id'], $auth_adminis)) {
								
					echo "
					<div class=\"input-control text span4\" id=\"objcreatedate\" style=\"margin-left: 20px;\">
						<input type=\"text\" id=\"createdate\" name=\"createdate\" value=\"$create_date\">
						<div class=\"btn-date\"></div>
					</div>";
					
				} else {
					echo "
					<div class=\"input-control text span4\" style=\"margin-left: 20px;\">
						<input type=\"text\" name=\"createdate\" value=\"$create_date\" style=\"background-color: #EBEBE4;\" readonly>
					</div>";					
					
				}
				
				?>
	
           
    	</div>
    </div>
        
	<div class="span12">
	
		<div class="span12">
	    <?php $customer = !empty($results['data'][0]['SourceOfCustomer']) ? $results['data'][0]['SourceOfCustomer']:""; ?>
	    <div class="input-control select">
	        <label class="span4">Source of customer</label>
	        <select id="sourceofcustomer" name="sourceofcustomer" class="span4">
	        	<option value="" <?php if($customer == "") echo "selected"; ?>>-- แหล่งที่มา --</option>
                <optgroup label="Core Source">
                	<option value="Field visit" <?php if($customer == "Field visit") echo "selected"; ?>>Field visit</option>
                	<option value="Refer: Thai Life" <?php if($customer == "Refer: Thai Life") echo "selected"; ?>>Refer by Thai Life</option>
                	<option value="Refer: RM" <?php if($customer == "Refer: RM") echo "selected"; ?>>Refer by RM</option>
                	<option value="Refer: Customer" <?php if($customer == "Refer: Customer") echo "selected"; ?>>Refer by Cust-Suplier</option>                	
                </optgroup>
                <optgroup label="Non-Core Source">
                	<option value="Call in" <?php if($customer == "Call in") echo 'selected="selected"'; ?>>Call in</option>
	                <option value="Walk in" <?php if($customer == "Walk in") echo 'selected="selected"'; ?>>Walk in</option>
	                <option value="Direct mail" <?php if($customer == "Direct mail") echo "selected"; ?>>Direct mail</option>
	                <option value="Telelist" <?php if($customer == "Telelist") echo "selected"; ?>>Telelist</option>
                </optgroup>
                <optgroup label="Referrel List">
                	<option value="Refer: Full Branch" <?php if($customer == "Refer: Full Branch") echo "selected"; ?>>Refer by Full Branch</option>
	                <option value="Refer: Call Center" <?php if($customer == "Refer: Call Center") echo "selected"; ?>>Refer by Call Center</option>
	                <option value="Tcrb: Facebook" <?php if($customer == "Tcrb: Facebook") echo "selected"; ?>>Refer by TCRB FB</option>                 	
                 	<option value="Rabbit" <?php if($customer == "Rabbit") echo "selected"; ?> disabled="disabled">Refer by Rabbit</option>
                 	<option value="Fintech" <?php if($customer == "Fintech") echo "selected"; ?> disabled="disabled">Refer by Fintech</option>
                 	<option value="Livechat" <?php if($customer == "Livechat") echo "selected"; ?> disabled="disabled">Refer by Livechat</option>                 	
                 	<option value="Refer: BM" <?php if($customer == "Refer: BM") echo "selected"; ?> disabled="disabled">Refer by BM</option>
                 	<option value="Loan Top Up" <?php if($customer == "Loan Top Up") echo "selected"; ?>>Loan Top Up</option>
                 	<option value="Import File" <?php if($customer == "Import File") echo "selected"; ?> disabled="disabled">Import File</option>
                	<option value="TVC" <?php if($customer == "TVC") echo "selected"; ?> disabled="disabled">TVC (โฆษณาทางโทรทัศน์)</option>
                </optgroup>        
	        </select>
	        <div id="sourceofcustomer_alert" class="span4 text-alert" style="margin-left: 0px; padding-left: 20px">*</div>
	    </div>
		</div>
	
	    <?php
	
	    $sourceoption = !empty($results['data'][0]['sourceoption']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['sourceoption']):"";
	    if($customer == "อื่นๆ") {
	
	        echo "
	        <div class=\"span12\">
	            <div class=\"input-control textarea\">
	                <div class=\"span4\">โปรดระบุ:</div>
	                <textarea name=\"sourceoption\" id=\"sourceoption\" class=\"span4\" cols=\"35\" rows=\"3\" style=\"font-size: 0.8em; font-weight: normal;\">".$sourceoption."</textarea>
	            </div>
	        </div>";
	    } else {
	    ?>
	        <div id="sourcetextoption" class="span12">
	            <div class="input-control textarea">
	                <div class="span4">โปรดระบุ:</div>
	                <textarea name="sourceoption" id="sourceoption" class="span4" cols="35" rows="3" style="font-size: 0.8em; font-weight: normal;"><?php echo $sourceoption; ?></textarea>
	            </div>
	         </div>
	
	    <?php } ?>
	
	    <?php $interest = (int)!empty($results['data'][0]['Interest']) ? $results['data'][0]['Interest']:""; ?>
	    <div class="input-control select">
	        <label class="span4">สนใจใช้บริการสินเชื่อ</label>
	        <div class="input-control radio" style="margin-left: 20px;">
	            <label>
	                <input type="radio" name="interest" value="0" <?php if($interest == 0) echo "checked"; ?>>
	                <span class="check"></span> สนใจ
	            </label>
	        </div>
	        <div class="input-control radio" style="margin-left: 5px;">
	            <label>
	                <input type="radio" name="interest" value="1" <?php if($interest == 1) echo "checked"; ?>>
	                <span class="check"></span> ไม่สนใจ
	            </label>
	        </div>
	        <div class="input-control radio hide" style="margin-left: 5px;">
	            <label>
	                <input type="radio" name="interest" value="2" <?php if($interest == 2) echo "checked"; ?>>
	                <span class="check"></span> กลับมาสนใจ
	            </label>
	        </div>
	    </div>
	</div>
    
    <div class="span12">
    		<?php $potential = !empty($results['data'][0]['CSPotential']) ? (int)$results['data'][0]['CSPotential']:""; ?>		
	        <div class="input-control radio" data-hint="Customer Potential|ส่วนประเมินลูกค้าว่าอยู่ในเกณฑ์ใด ซึ่งการประเมินนี้ เป็นการประเมินศักยภาพในการทำสินเชื่อของลูกค้าในอนาคต." data-hint-position="right">
	            <label class="span4">โอกาสการเป็นลูกค้า</label>
	            <div class="input-control radio" style="margin-left: 20px;">
	                <label>
	                    <input type="radio" name="potential" value="0" <?php if($potential == 0) echo "checked"; ?>>
	                    <span class="check"></span> H
	                </label>
	            </div>
	            <div class="input-control radio" style="margin-left: 27px;">
	                <label>
	                    <input type="radio" name="potential" value="1" <?php if($potential == 1) echo "checked"; ?>>
	                    <span class="check"></span> M
	                </label>
	            </div>
	            <div class="input-control radio" style="margin-left: 40px;">
	                <label>
	                    <input type="radio" name="potential" value="2" <?php if($potential == 2) echo "checked"; ?>>
	                    <span class="check"></span> L
	                </label>
	            </div>
	        </div>
 	</div>
 	
 	<div class="span12">
 		<?php $load_group = !empty($results['data'][0]['LoanGroup']) ? $results['data'][0]['LoanGroup']:""; ?>		
        <div class="input-control radio">
            <label class="span4">ประเภทสินเชื่อที่นำเสนอ</label>
            <div class="input-control radio" style="margin-left: 20px;" data-hint="Nano Finance" data-hint-position="right">
                <label>
                    <input type="radio" name="loan_group" value="NN" <?php if($load_group == 'NN') echo "checked"; ?>>
                    <span class="check"></span> NN
                </label>
            </div>
            <div class="input-control radio" style="margin-left: 17px;" data-hint="Micro Finance" data-hint-position="right">
                <label>
                    <input type="radio" name="loan_group" value="MF" <?php if($load_group == 'MF') echo "checked"; ?>>
                    <span class="check"></span> MF
                </label>
            </div>	    
			<div class="input-control radio" style="margin-left: 33px;" data-hint="Small Business Loan" data-hint-position="right">
                <label>
                    <input type="radio" name="loan_group" value="SB" <?php if($load_group == 'SB') echo "checked"; ?>>
                    <span class="check"></span> SB
                </label>
            </div>
            <div class="input-control radio" style="margin-left: 33px;" data-hint="Micro SME" data-hint-position="right">
                <label>
                    <input type="radio" name="loan_group" value="MF SME" <?php if($load_group == 'MF SME') echo "checked"; ?>>
                    <span class="check"></span> MF SME
                </label>
            </div>   
            <span id="loan_gruop_alert" class="marginLeft20 text-alert"></span>
        </div>
    </div>
	
	<div class="span12">
	    <?php $ownertype = (int)!empty($results['data'][0]['OwnerType']) ? $results['data'][0]['OwnerType']:""; ?>
	    <div class="input-control text" style="margin: 10px 0;">
	        <div class="span4">
	            <div class="span4">
	                <div class="input-control radio" style="margin-top: -20px;">
	                    <label class="span4 text">
	                        <input name="ownertype" type="radio" value="0" <?php if($ownertype == 0) echo "checked"; ?>>
	                        <span class="check"></span> ชื่อเจ้าของกิจการ
	                    </label>
	                    <label class="span4 text" style="margin-left: 1px;">
	                        <input name="ownertype" type="radio" value="1" <?php if($ownertype == 1) echo "checked"; ?>>
	                        <span class="check"></span> ชื่อผู้ติดต่อ
	                    </label>
	                </div>
	            </div>
	        </div>
	        <div class="input-control select span1" style="margin-left: 20px; min-width: 65px;">
	        <?php $prefixName = !empty($results['data'][0]['PrefixName']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['PrefixName']):""; ?>
	            <select name="prefixname" id="prefixname" class="input-control select" style="height: 34px;">
                        <option value="" <?php if($prefixName == "") echo "selected"; ?>></option>
                        <option value="นาย" <?php if($prefixName == "นาย") echo "selected"; ?>>นาย</option>
                        <option value="นาง" <?php if($prefixName == "นาง") echo "selected"; ?>>นาง</option>
                        <option value="นางสาว" <?php if($prefixName == "นางสาว") echo "selected"; ?>>น.ส</option>
                </select>
                </div>
	        	<input type="text" name="owner" id="owner" class="span3" value="<?php echo !empty($results['data'][0]['OwnerName']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['OwnerName']):""; ?>" style="margin-left: 3px; min-width: 230px;">
	        <div id="owner_alert" class="span4 text-alert">*</div>
	    </div>
	</div>
	
	<div class="span12" style="margin-top: 3px;">
	    <div class="input-control text">
	        <div class="span4">ชื่อสถานที่ประกอบการ</div>
	        <div class="input-control select span1" style="margin-left: 20px; min-width: 65px;">
	        	<?php $prefixCorp = !empty($results['data'][0]['PrefixCorp']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['PrefixCorp']):""; ?>
	            <select name="prefixcorp" id="prefixcorp" class="input-control select" style="height: 34px;">
                        <option value="" <?php if($prefixCorp == "") echo "selected"; ?>></option>
                        <option value="ร้าน" <?php if($prefixCorp == "ร้าน") echo "selected"; ?>>ร้าน</option>
                        <option value="บจก" <?php if($prefixCorp == "บจก") echo "selected"; ?>>บจก</option>
                        <option value="หจก" <?php if($prefixCorp == "หจก") echo "selected"; ?>>หจก</option>
                        <option value="หสม" <?php if($prefixCorp == "หสม") echo "selected"; ?>>หสม</option>
                        <option value="บมจ" <?php if($prefixCorp == "บมจ") echo "selected"; ?>>บมจ</option>
                </select>
                </div>
	        <input type="text" name="company" id="company" class="span4" value="<?php echo !empty($results['data'][0]['Company']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Company']):""; ?>" style="margin-left: 3px; max-width: 230px;">
	    </div>
	</div>
	
	<div class="span12">
	    <?php $businesstype = !empty($results['data'][0]['BusinessType']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['BusinessType']):""; ?>
	    <div class="input-control select">
	        <div class="span4">ประเภทธุรกิจ</div>
	        <select id="businesstype" name="businesstype" class="span4">
	            <option value="" <?php if($businesstype == "") echo "selected"; ?>></option>
	            <option value="Professional/Freelance" <?php if($businesstype == "Professional/Freelance") echo "selected"; ?>>Professional/Freelance</option>
	            <option value="การเกษตร" <?php if($businesstype == "การเกษตร") echo "selected"; ?>>การเกษตร</option>
	            <option value="การบริการ" <?php if($businesstype == "การบริการ") echo "selected"; ?>>การบริการ</option>
	            <option value="การผลิต" <?php if($businesstype == "การผลิต") echo "selected"; ?>>การผลิต</option>
	            <option value="ค้าปลีก" <?php if($businesstype == "ค้าปลีก") echo "selected"; ?>>ค้าปลีก</option>
	            <option value="ค้าส่ง" <?php if($businesstype == "ค้าส่ง") echo "selected"; ?>>ค้าส่ง</option>
	            <option value="ทนายความ" <?php if($businesstype == "ทนายความ") echo "selected"; ?>>ทนายความ</option>
	            <option value="ที่ปรึกษา" <?php if($businesstype == "ที่ปรึกษา") echo "selected"; ?>>ที่ปรึกษา</option>
	            <option value="ปั๊มน้ำมัน" <?php if($businesstype == "ปั๊มน้ำมัน") echo "selected"; ?>>ปั๊มน้ำมัน</option>
	            <option value="เภสัชกร" <?php if($businesstype == "เภสัชกร") echo "selected"; ?>>เภสัชกร</option>
	            <option value="ร้านตัดผม" <?php if($businesstype == "ร้านตัดผม") echo "selected"; ?>>ร้านตัดผม</option>
	            <option value="ร้านทอง (ค้าปลีก)" <?php if($businesstype == "ร้านทอง (ค้าปลีก)") echo "selected"; ?>>ร้านทอง (ค้าปลีก)</option>
	            <option value="โรงแรม" <?php if($businesstype == "โรงแรม") echo "selected"; ?>>โรงแรม</option>
	            <option value="วิศวกร" <?php if($businesstype == "วิศวกร") echo "selected"; ?>>วิศวกร</option>
	            <option value="สถาปนิก" <?php if($businesstype == "สถาปนิก") echo "selected"; ?>>สถาปนิก</option>
	            <option value="สปา/Health Club" <?php if($businesstype == "สปา/Health Club") echo "selected"; ?>>สปา/Health Club</option>
	            <option value="เหล้า เบียร์ บุหรี่" <?php if($businesstype == "เหล้า เบียร์ บุหรี่") echo "selected"; ?>>เหล้า เบียร์ บุหรี่</option>
	            <option value="อพาร์ทเม้นท์" <?php if($businesstype == "อพาร์ทเม้นท์") echo "selected"; ?>>อพาร์ทเม้นท</option>
	            <option value="อื่นๆ" <?php if($businesstype == "อื่นๆ") echo "selected"; ?>>อื่นๆ</option>
	        </select>
	        <div id="businesstype_alert" class="span3 text-alert" style="margin-left: 20px;">*</div>
	    </div>
	</div>
	
	<div id="business-free" class="span12">
	    <div class="input-control textarea">
	        <div class="span4">ธุรกิจ / กิจการเกี่ยวกับ</div>
	        <textarea id="business"  name="business" cols="35" rows="3" class="span4" ><?php echo !empty($results['data'][0]['Business']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['Business']):""; ?></textarea>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	    	<!-- <span class="text-warning"><small>(กรุณาใส่เบอร์ติดต่ออย่างน้อย 1 เบอร์)</small></span> -->
	        <div class="span4">เบอร์ติดต่อ (สำนักงาน)</div>
	        <input type="text" name="telephone" id="telephone" class="span4" value="<?php echo !empty($results['data'][0]['Telephone']) ? $results['data'][0]['Telephone']:""; ?>">
	        <div id="tel_alert" class="span4 text-alert" style="margin-left: 20px;">*</div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">เบอร์ติดต่อ 2</div>
	        <input type="text" name="mobile" id="mobile" class="span4" value="<?php echo !empty($results['data'][0]['Mobile']) ? $results['data'][0]['Mobile']:""; ?>">
	        <div id="mobile_alert" class="span3 text-alert">*</div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">ย่านธุรกิจ</div>
	        <input type="text" name="downtown" id="downtown" class="span4" value="<?php echo !empty($results['data'][0]['Downtown']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['Downtown']):""; ?>">
            <div id="dt_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"></div>
            <div id="downtown_alert" class="span3 text-alert">*</div>
	    </div>
	</div>
	
	<div class="span12">
	    <div id="textarea_add" class="input-control textarea">
	        <div class="span4">ที่อยู่</div>
	        <textarea id="address"  name="address" cols="35" rows="3" class="span4" ><?php echo !empty($results['data'][0]['Address']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['Address']):""; ?></textarea>
	    </div>
	</div>

    <div class="span12">
    	<?php $province = !empty($results['data'][0]['Province']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['Province']):""; ?>
        <div id="parent_province" class="input-control text">
            <div class="span4">จังหวัด</div>
            <select id="province" name="province" class="span2 ui-widget">
                <option value="N/A" <?php if($province == '') { echo 'selected'; } ?>></option>
                <option value="กรุงเทพมหานคร" <?php if($province == 'กรุงเทพมหานคร') { echo 'selected'; } ?>>กรุงเทพมหานคร</option>
                <option value="กระบี่" <?php if($province == 'กระบี่') { echo 'selected'; } ?>>กระบี่</option>
                <option value="กาญจนบุรี" <?php if($province == 'กาญจนบุรี') { echo 'selected'; } ?>>กาญจนบุรี</option>
                <option value="กาฬสินธุ์" <?php if($province == 'กาฬสินธุ์') { echo 'selected'; } ?>>กาฬสินธุ์</option>
                <option value="กำแพงเพชร" <?php if($province == 'กำแพงเพชร') { echo 'selected'; } ?>>กำแพงเพชร</option>
                <option value="ขอนแก่น" <?php if($province == 'ขอนแก่น') { echo 'selected'; } ?>>ขอนแก่น</option>
                <option value="จันทบุรี" <?php if($province == 'จันทบุรี') { echo 'selected'; } ?>>จันทบุรี</option>
                <option value="ฉะเชิงเทรา" <?php if($province == 'ฉะเชิงเทรา') { echo 'selected'; } ?>>ฉะเชิงเทรา</option>
                <option value="ชัยนาท" <?php if($province == 'ชัยนาท') { echo 'selected'; } ?>>ชัยนาท</option>
                <option value="ชัยภูมิ" <?php if($province == 'ชัยภูมิ') { echo 'selected'; } ?>>ชัยภูมิ</option>
                <option value="ชุมพร" <?php if($province == 'ชุมพร') { echo 'selected'; } ?>>ชุมพร</option>
                <option value="ชลบุรี" <?php if($province == 'ชลบุรี') { echo 'selected'; } ?>>ชลบุรี</option>
                <option value="เชียงใหม่" <?php if($province == 'เชียงใหม่') { echo 'selected'; } ?>>เชียงใหม่</option>
                <option value="เชียงราย" <?php if($province == 'เชียงราย') { echo 'selected'; } ?>>เชียงราย</option>
                <option value="ตรัง" <?php if($province == 'ตรัง') { echo 'selected'; } ?>>ตรัง</option>
                <option value="ตราด" <?php if($province == 'ตราด') { echo 'selected'; } ?>>ตราด</option>
                <option value="ตาก" <?php if($province == 'ตาก') { echo 'selected'; } ?>>ตาก</option>
                <option value="นครนายก" <?php if($province == 'นครนายก') { echo 'selected'; } ?>>นครนายก</option>
                <option value="นครปฐม" <?php if($province == 'นครปฐม') { echo 'selected'; } ?>>นครปฐม</option>
                <option value="นครพนม" <?php if($province == 'นครพนม') { echo 'selected'; } ?>>นครพนม</option>
                <option value="นครราชสีมา" <?php if($province == 'นครราชสีมา') { echo 'selected'; } ?>>นครราชสีมา</option>
                <option value="นครศรีธรรมราช" <?php if($province == 'นครศรีธรรมราช') { echo 'selected'; } ?>>นครศรีธรรมราช</option>
                <option value="นครสวรรค์" <?php if($province == 'นครสวรรค์') { echo 'selected'; } ?>>นครสวรรค์</option>
                <option value="นราธิวาส" <?php if($province == 'นราธิวาส') { echo 'selected'; } ?>>นราธิวาส</option>
                <option value="น่าน" <?php if($province == 'น่าน') { echo 'selected'; } ?>>น่าน</option>
                <option value="นนทบุรี" <?php if($province == 'นนทบุรี') { echo 'selected'; } ?>>นนทบุรี</option>
                <option value="บึงกาฬ" <?php if($province == 'บึงกาฬ') { echo 'selected'; } ?>>บึงกาฬ</option>
                <option value="บุรีรัมย์" <?php if($province == 'บุรีรัมย์') { echo 'selected'; } ?>>บุรีรัมย์</option>
                <option value="ประจวบคีรีขันธ์" <?php if($province == 'ประจวบคีรีขันธ์') { echo 'selected'; } ?>>ประจวบคีรีขันธ์</option>
                <option value="ปทุมธานี" <?php if($province == 'ปทุมธานี') { echo 'selected'; } ?>>ปทุมธานี</option>
                <option value="ปราจีนบุรี" <?php if($province == 'ปราจีนบุรี') { echo 'selected'; } ?>>ปราจีนบุรี</option>
                <option value="ปัตตานี" <?php if($province == 'ปัตตานี') { echo 'selected'; } ?>>ปัตตานี</option>
                <option value="พะเยา" <?php if($province == 'พะเยา') { echo 'selected'; } ?>>พะเยา</option>
                <option value="อยุธยา" <?php if($province == 'พระนครศรีอยุธยา' || $province == 'อยุธยา') { echo 'selected'; } ?>>อยุธยา</option>
                <option value="พังงา" <?php if($province == 'พังงา') { echo 'selected'; } ?>>พังงา</option>
                <option value="พิจิตร" <?php if($province == 'พิจิตร') { echo 'selected'; } ?>>พิจิตร</option>
                <option value="พิษณุโลก" <?php if($province == 'พิษณุโลก') { echo 'selected'; } ?>>พิษณุโลก</option>
                <option value="เพชรบุรี" <?php if($province == 'เพชรบุรี') { echo 'selected'; } ?>>เพชรบุรี</option>
                <option value="เพชรบูรณ์" <?php if($province == 'เพชรบูรณ์') { echo 'selected'; } ?>>เพชรบูรณ์</option>
                <option value="แพร่" <?php if($province == 'แพร่') { echo 'selected'; } ?>>แพร่</option>
                <option value="พัทลุง" <?php if($province == 'พัทลุง') { echo 'selected'; } ?>>พัทลุง</option>
                <option value="ภูเก็ต" <?php if($province == 'ภูเก็ต') { echo 'selected'; } ?>>ภูเก็ต</option>
                <option value="มหาสารคาม" <?php if($province == 'มหาสารคาม') { echo 'selected'; } ?>>มหาสารคาม</option>
                <option value="มุกดาหาร" <?php if($province == 'มุกดาหาร') { echo 'selected'; } ?>>มุกดาหาร</option>
                <option value="แม่ฮ่องสอน" <?php if($province == 'แม่ฮ่องสอน') { echo 'selected'; } ?>>แม่ฮ่องสอน</option>
                <option value="ยโสธร" <?php if($province == 'ยโสธร') { echo 'selected'; } ?>>ยโสธร</option>
                <option value="ยะลา" <?php if($province == 'ยะลา') { echo 'selected'; } ?>>ยะลา</option>
                <option value="ร้อยเอ็ด" <?php if($province == 'ร้อยเอ็ด') { echo 'selected'; } ?>>ร้อยเอ็ด</option>
                <option value="ระนอง" <?php if($province == 'ระนอง') { echo 'selected'; } ?>>ระนอง</option>
                <option value="ระยอง" <?php if($province == 'ระยอง') { echo 'selected'; } ?>>ระยอง</option>
                <option value="ราชบุรี" <?php if($province == 'ราชบุรี') { echo 'selected'; } ?>>ราชบุรี</option>
                <option value="ลพบุรี" <?php if($province == 'ลพบุรี') { echo 'selected'; } ?>>ลพบุรี</option>
                <option value="ลำปาง" <?php if($province == 'ลำปาง') { echo 'selected'; } ?>>ลำปาง</option>
                <option value="ลำพูน" <?php if($province == 'ลำพูน') { echo 'selected'; } ?>>ลำพูน</option>
                <option value="เลย" <?php if($province == 'เลย') { echo 'selected'; } ?>>เลย</option>
                <option value="ศรีสะเกษ" <?php if($province == 'ศรีสะเกษ') { echo 'selected'; } ?>>ศรีสะเกษ</option>
                <option value="สกลนคร" <?php if($province == 'สกลนคร') { echo 'selected'; } ?>>สกลนคร</option>
                <option value="สงขลา" <?php if($province == 'สงขลา') { echo 'selected'; } ?>>สงขลา</option>
                <option value="สมุทรสาคร" <?php if($province == 'สมุทรสาคร') { echo 'selected'; } ?>>สมุทรสาคร</option>
                <option value="สมุทรปราการ" <?php if($province == 'สมุทรปราการ') { echo 'selected'; } ?>>สมุทรปราการ</option>
                <option value="สมุทรสงคราม" <?php if($province == 'สมุทรสงคราม') { echo 'selected'; } ?>>สมุทรสงคราม</option>
                <option value="สระแก้ว" <?php if($province == 'สระแก้ว') { echo 'selected'; } ?>>สระแก้ว</option>
                <option value="สระบุรี" <?php if($province == 'สระบุรี') { echo 'selected'; } ?>>สระบุรี</option>
                <option value="สิงห์บุรี" <?php if($province == 'สิงห์บุรี') { echo 'selected'; } ?>>สิงห์บุรี</option>
                <option value="สุโขทัย" <?php if($province == 'สุโขทัย') { echo 'selected'; } ?>>สุโขทัย</option>
                <option value="สุพรรณบุรี" <?php if($province == 'สุพรรณบุรี') { echo 'selected'; } ?>>สุพรรณบุรี</option>
                <option value="สุราษฎร์ธานี" <?php if($province == 'สุราษฎร์ธานี') { echo 'selected'; } ?>>สุราษฎร์ธานี</option>
                <option value="สุรินทร์" <?php if($province == 'สุรินทร์') { echo 'selected'; } ?>>สุรินทร์</option>
                <option value="สตูล" <?php if($province == 'สตูล') { echo 'selected'; } ?>>สตูล</option>
                <option value="หนองคาย" <?php if($province == 'หนองคาย') { echo 'selected'; } ?>>หนองคาย</option>
                <option value="หนองบัวลำภู" <?php if($province == 'หนองบัวลำภู') { echo 'selected'; } ?>>หนองบัวลำภู</option>
                <option value="อำนาจเจริญ" <?php if($province == 'อำนาจเจริญ') { echo 'selected'; } ?>>อำนาจเจริญ</option>
                <option value="อุดรธานี" <?php if($province == 'อุดรธานี') { echo 'selected'; } ?>>อุดรธานี</option>
                <option value="อุตรดิตถ์" <?php if($province == 'อุตรดิตถ์') { echo 'selected'; } ?>>อุตรดิตถ์</option>
                <option value="อุทัยธานี" <?php if($province == 'อุทัยธานี') { echo 'selected'; } ?>>อุทัยธานี</option>
                <option value="อุบลราชธานี" <?php if($province == 'อุบลราชธานี') { echo 'selected'; } ?>>อุบลราชธานี</option>
                <option value="อ่างทอง" <?php if($province == 'อ่างทอง') { echo 'selected'; } ?>>อ่างทอง</option>
            </select>
            <span id="pv_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>
            <span id="province_alert" class="text-alert" style="margin-left: 35px;">*</span>
        </div>
    </div>
	
	<div class="span12">
		<?php $district = !empty($results['data'][0]['District']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['District']):""; ?>
	    <div class="input-control select">
	        <div class="span4">อำเภอ</div>
	        <select name="district" id="district" class="span4">
	        	<option value="<?php echo $district; ?>" selected="selected"><?php echo $district; ?></option>
	        </select>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">รหัสไปรษณีย์</div>
	        <input type="text" name="postcode" id="postcode" class="span4" value="<?php echo !empty($results['data'][0]['Postcode']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['Postcode']):""; ?>">
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control select">
	         <div class="span4">ประเภทช่องทางสื่อ</div>
	        <!-- <input id="channel" name="channel" class="span4" value="<?php echo !empty($results['data'][0]['Channel']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['Channel']):""; ?>" data-hint="ประเภทช่องทาง|ฟิลด์ประเภทช่องทางไม่สามารถคีย์ข้อมูลหรือแก้ไขข้อมูลได้ ข้อมูลจะเกิดขึ้นเมื่อเลือกช่องทางข่าวสาร." data-hint-position="right" readonly> -->
	        <input id="chanel_group" type="hidden" value="<?php echo !empty($results['data'][0]['Channel']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['Channel']):""; ?>">
	        <select id="channelmode" name="channelmode" class="span4"></select>
            <div id="ch_header_progress"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="margin-left: 6px;"></div>
            <div id="channelmode_alert" class="span3 text-alert">*</div>
	    </div>
	</div>
	
	<div class="span12">
		<?php $channel = !empty($results['data'][0]['SubChannel']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['SubChannel']):""; ?>
	    <div class="input-control select">
	        <div class="span4">รับทราบจากช่องทางสื่อ</div>
	        <select id="channelmodule" name="channelmodule" class="span4">
	        	<option value="<?php echo $channel; ?>" selected="selected"><?php echo $channel; ?></option>
	        </select>
	        <input id="chanel_sublist" type="hidden" value="<?php echo $channel; ?>">
	        <div id="channel_alert" class="span3 text-alert">*</div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">วงเงินที่ต้องการ (บาท)</div>
	        <input name="loanrequest" id="loanrequest" class="span4" value="<?php echo !empty($results['data'][0]['RequestLoan']) ? $results['data'][0]['RequestLoan']:""; ?>">
	    </div>
	</div>
	
	<?php
	 
		$dueID 	    = !empty($results['data'][0]['DueID']) ? $results['data'][0]['DueID']:"";
		$duereason  = !empty($results['data'][0]['Subject']) ? $results['data'][0]['Subject']:"";
	    $dueoption  = !empty($results['data'][0]['Description']) ? $results['data'][0]['Description']:"";
	    
    ?>
	<div class="span12" style="display: none;">
	    <div class="span4" style="margin-right: 20px;">
	        <div>วันนัดพบครั้งถัดไป</div>
	        <input type="hidden" name="hide_reasonid" id="hide_reasonid" value="<?php echo trim($dueID); ?>">
	        <input type="hidden" name="hide_reason" id="hide_reason" value="<?php echo $this->effective->get_chartypes($char_mode, $duereason); ?>">
	    </div>
	    <div class="input-control select span2" style="min-width: 180px;">
	         <select id="duedatestatus" name="duedatestatus" style="height: 34px;"></select>
	    </div>
	    <div id="dueclndr" class="input-control text span2" style="max-width: 115px; margin-left: 5px;">
	    	<input type="text" id="duedate" name="duedate" value="<?php echo !empty($results['data'][0]['DueDate']) ? StandartDateRollback($results['data'][0]['DueDate']):""; ?>">
	        <button class="btn-clear" tabindex="-1" type="button" onclick="$('#duedate').val('');"></button>
	    </div>
        <?php $endEvent = (int)!empty($results['data'][0]['IsRepeat']) ? $results['data'][0]['IsRepeat']:""; ?>
	    <div class="input-control checkbox">
			<label style="margin-left: 5px;">
			<input type="checkbox" name="endevent" id="endevent" value="1" <?php if($endEvent == 1) echo "checked"; ?>>
			<span class="check"></span> <i class="fa fa-bell-slash-o"></i> End Event
		    </label>
		</div>
	</div>
    <?php

   
    if($duereason == 'อื่นๆ') {

        echo "
            <div id=\"duetextoption\" class=\"span12\">
                <div class=\"input-control textarea\">
                    <div class=\"span4\">โปรดระบุ:</div>
                    <textarea name=\"dueoption\" id=\"dueoption\" class=\"span4\" cols=\"35\" rows=\"3\" style=\"font-size: 0.8em; font-weight: normal;\">".$dueoption."</textarea>
                </div>
            </div>
        ";

    } else {

    ?>
    
    <div id="duetextoption" class="span12">
	        <div class="input-control textarea">
	            <div class="span4">โปรดระบุ:</div>
	            <textarea name="dueoption" id="dueoption" class="span4" cols="35" rows="3" style="font-size: 0.8em; font-weight: normal;"><?php echo set_value('dueoption'); ?></textarea>
	        </div>
    </div>
    
    <?php } ?>
    
    <div class="span12">
    	 <?php $criteria = !empty($results['data'][0]['BasicCriteria']) ? intval($results['data'][0]['BasicCriteria']):""; ?>
    	<label class="span4">Basic Criteria <span class="text-warning"><small>(กรุณีลูกค้าไม่ผ่านเกณฑ์เบื้องต้นคลิก)</small></span></label>
       	<div class="input-control checkbox span1" >
        <label>
        	<input type="checkbox" id="criteria" name="criteria" value="1" <?php if(intval($criteria) == 0) echo "checked"; ?>>
        	<span class="check"></span>
        </label>
        </div>
        <div class="input-control select span4" style="margin-left: -30px; max-width: 270px;">
            <select id="criteria_reason" name="criteria_reason"></select>
            <input type="hidden" name="criteriareas_hidden" id="criteriareas_hidden" value="<?php echo !empty($results['data'][0]['CriteriaReasonID']) ? @$this->effective->get_chartypes($char_mode,  $results['data'][0]['CriteriaReasonID']):""; ?>">
        </div>
        <div id="criteriareason_progress" class="span1"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></div>
        <span id="criteria_alert"  class="span3 text-alert"></span>
	</div>

	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">Refer by TL Agent</div>
	        <input id="referralcode" name="referralcode" type="text" class="span4" value="<?php echo !empty($results['data'][0]['ReferralCode']) ? trim($results['data'][0]['ReferralCode']):trim(""); ?>" onkeypress="validate(event)" maxlength="8">
	        <span id="parent-pop-async" class="span1"><i id="show-pop-async" class="ti-id-badge fg-darkCyan" style="font-size: 1.4em; cursor: pointer;"></i></span>
	        <span id="refer_alert" class="span3 text-alert" style="margin-left: -20px;"></span>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control textarea">
	        <div class="span4">Remark</div>
	        <textarea name="remark" id="remark" class="span4" cols="35" rows="3"><?php echo !empty($results['data'][0]['Remark']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['Remark']):""; ?></textarea>
	    </div>
	</div>

    <div class="span12">&nbsp;</div>
    <div class="span12">
        <div class="span6">
            <div id="progresses" class="span1"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="visibility: hidden;"></div>
            <div id="msg_alert"></div>
        </div>

        <div class="span6" style="padding-left: 60px; <?php echo $hide_attr; ?>">
            <button id="btnProfileSubmit" type="submit" name="submit" style="min-width: 80px; height: 34px;" class="bg-lightBlue fg-white">
            <i class="fa fa-save on-left"></i>Submit</button>
        </div>
    </div>
	
	</fieldset>
    </article>
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
	
	<div id="form_footer">
	    <img src="<?php echo base_url('img/logo_form_footer.jpg'); ?>" style="margin-top: 50px;">
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
			url: pathFixed + 'dataloads/getTLADataDetail?_='  + new Date().getTime() + '&tl_ref=' + tl_agent_code + '&getdesc=true',	
			type:'async',
			content: function(data) {
				console.log(data);
				
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
									'<th class="text-center">BRANCH</th>' +
									'<th class="text-center">POSITION</th>' +
									'<th class="text-center">MOBILE</th>' +
								'</tr>' +
							'</thead>' +
							'<tbody>' +
								'<td>' + data['data'][0]['TLA_Code'] + '</td>' +
								'<td>' + data['data'][0]['TLA_Name'] + '</td>' +
								'<td>' + data['data'][0]['TLA_Position'] + '</td>' +
								'<td>' + data['data'][0]['TLA_BranchName'] + '</td>' +
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
