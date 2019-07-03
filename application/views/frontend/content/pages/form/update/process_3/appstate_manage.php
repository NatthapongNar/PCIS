<style>

	.ui-multiselect {
		height: 34px;
		border: 1px solid #D1D1D1;
		background: #FFF;
		max-width: 300px;
	}

	.ms-drop {
		width: auto !important; 
		min-width: 150% !important;
	}
	
	.ms-drop li:not(.group) {
		margin-left: 15px;
	}
		
	.metro button.ms-choice {
		border: 1px #d9d9d9 solid;
	    height: 34px;
	    line-height: 34px;
		background-color: #FFF;
	}
	
	.ms-choice>div {
		top: 4px !important;
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
	
	.tools-container {
	    position: absolute;
	    min-width: 250px;
	    max-width: 250px;
	    display: none;
	    border: 1px solid #D1D1D1;
	    background: #FFF;
	    z-index: 1010;
	    padding: 0 0 10px 0;
	    margin-top: -23px;
	    margin-left: 650px;
    }
    
    .tools-container.open {
	    display: block;
	}
        
    .tools-header {
        font-size: 12px;
        font-weight: bold;
        padding: 5px;
        background-color: #1b6eae;
        color: #FFF;
        width: 100%;
    }
    
    .tools-header > .clsoe_icon {
    	float: right;
   		cursor: pointer;
    }

    .tools-content, .tools-footer {
        width: 100%;
        padding: 0px 7px;
        position: relative;
    }

	.icon_blink {  animation: blink .9s ease-in infinite; }
	
	.list_node {
		margin-bottom: 0px;
	    background-color: tan;
    	color: #FFF !important;
    	padding: 0px !important;
    }
    
    .list_node:hover, .list_node.active {
    	background-color: tan !important; /*lightcoral*/
    	color: #FFF !important;
    }
    	
	@keyframes blink {
	    from, to { opacity: 1 }
	    50% { opacity: .4 }
	}
	

</style>

<div class="text_float nonprint"><h2>Edit Form</h2></div>

<div class="container">

<p id="back-top" class="nonprint"><a href="#top"><i class="fa fa-arrow-up"></i> Back to Top</a></p>

<div class="grid">
    <div id="form" class="row" style="height: 1400px;">
    
    	<div class="logo_header">
			<img src="<?php echo base_url('img/logo_form_header.jpg'); ?>">
		</div>
		
		<?php     	

		    $hide_attr= '';
		    $none_style= '';
			$disable_attr= '';
			if(in_array($session_data['role'], array('adminbr_role')) || in_array($getCustInfo['BranchCode'], $session_data['pilot'])):
				$disable_attr = 'disabled="disabled"';
				$none_style = 'style="display: none;"';
				$hide_attr = 'display: none;';
				echo '<div id="check_denied_role" class="col-sm-12 col-md-12 col-lg-12" data-attr="denied"><div class="label error col-sm-12 col-md-12 col-lg-12" style="padding: 5px 3px;">ขออภัย, คุณไม่มีสิทธิ์ในการแก้ไขข้อมูล</div></div>';
			endif;
		?>
    
        <div id="form-header" class="col-sm-12 col-md-12 col-lg-12">
            <h2>APPLICATION STATUS</h2>
        </div>

        <div class="profile-progress nonprint">
            <h2>APPLICATION PROGRESS STATUS</h2>
            <div id="appProgress" class="stepper" data-role="stepper" data-steps="3" data-start="3"></div>

        </div>
        
        <input id="product_type" type="hidden" value="<?php echo (!empty($results['data'][0]['ShortProductType'])) ? $results['data'][0]['ShortProductType']:''; ?>" />
        <input id="is_aip" type="hidden" value="<?php echo (!empty($results['data'][0]['IsAIP'])) ? $results['data'][0]['IsAIP']:''; ?>" />
        <input id="received_estimatedoc" type="hidden" value="<?php echo (!empty($results['data'][0]['ReceivedEstimateDoc'])) ? $results['data'][0]['ReceivedEstimateDoc']:''; ?>" />
        <input id="plan_drawdown" type="hidden" value="<?php echo (!empty($results['data'][0]['PlanDrawdownDate'])) ? $results['data'][0]['PlanDrawdownDate']:''; ?>" />
        
        <?php 
			/*
	        function single_array($arr){
	        	foreach($arr as $key){
	        		if(is_array($key)){
	        			$arr1=single_array($key);
	        			foreach($arr1 as $k){
	        				$new_arr[]=$k;
	        			}
	        		}
	        		else{
	        			$new_arr[]=$key;
	        		}
	        	}
	        	return $new_arr;
	        }

        	$prd_type  = !empty($results['data'][0]['ShortProductType']) ? $results['data'][0]['ShortProductType']:''; 
        	$plan_dd   = (!empty($results['data'][0]['PlanDDSubmit']) && ($results['data'][0]['PlanDDSubmit'] != '1900-01-01')) ? $results['data'][0]['PlanDDSubmit'] : '';

        	$allow_tmp = single_array($allow_reserved['data']);
        	$allow_day = (count($allow_tmp) > 0) ? $allow_tmp : date_in_period("Y-m-d", $plan_dd, date('Y-m-d', strtotime(date('Y-m-t') . '+1 month')), array("Sat", "Sun"));

        	$delay_day = 0;
        	
        	if(!empty($prd_type) && $prd_type == 'Secure') {
        		$delay_day = 3;
        	}
        	
        	if(!empty($prd_type) && $prd_type == 'Clean') {
        		$delay_day = 2;
        	}
        	
        	$test = !empty($plan_dd) ? $allow_day[$delay_day] . ' 19:00:00': '';
			*/ 
        ?>
        
        <input id="allowDDReserv" name="allowDDReserv" type="hidden" value="<?php echo (!empty($allow_reserved['data'][0]['AllowReserved'])) ? $allow_reserved['data'][0]['AllowReserved']:''; ?>">

        <?php $this->load->helper('form'); ?>
        <?php $this->load->library('form_validation'); ?>
        <?php $this->load->library('effective'); ?>

        <?php $attributes = array('id' => 'appstate'); ?>
        <?php echo form_open('metro/applicationStatusFormInitialyze', $attributes); ?>
                
        <div id="form-frame">
            <div class="grid">
                <div class="row">
                
                	
           
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
                
                    <div class="span12" style="margin-bottom: 5px;"><h3>STATUS</h3></div>
        
                    <div id="ref_data" class="span12">
                    	<input id="docid" name="docid" type="hidden" value="<?php echo !empty($_GET['rel']) ? $_GET['rel']:""; ?>">
                    	<input id="actor_name" name="actor_name" type="hidden" value="<?php echo !empty($session_data['thname']) ? $session_data['thname']:""; ?>">
                    	<input id="actor_id" name="actor_id" type="hidden" value="<?php echo !empty($session_data['emp_id']) ? $session_data['emp_id']:""; ?>">
                    </div>
                    
                    <?php $objDoc_id = !empty($_GET['rel']) ? $_GET['rel']:''; ?>
                    <?php 
                    	$result_app_hist = $this->dbmodel->CIQuery("
                    		SELECT DocID, ApplicationNo
                    		FROM PCISEventLogs
                    		WHERE DocID = '$objDoc_id'
                    		AND ApplicationNo IS NOT NULL
							AND NOT EventProcess = 'CHANGE APPLICATION'
                    		GROUP BY DocID, ApplicationNo
                    	");
                    ?>
                    
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Application No</label>
                            <div class="input-control text span4" style="margin-left: 0px; margin-right: 18px;">
                                <input type="hidden" name="appno" id="appno" value="<?php echo !empty($results['data'][0]['ApplicationNo']) ? trim($results['data'][0]['ApplicationNo']):""; ?>" class="span4" maxlength="15">
                                <input type="text" id="fake_appno" placeholder="Application No auto update" value="<?php echo !empty($results['data'][0]['ApplicationNo']) ? trim($results['data'][0]['ApplicationNo']):""; ?>" class="span4" maxlength="15" disabled="disabled">
                            </div>
                            <span class="marginLeft5" style="padding-top: 3px;" data-tooltip="Change Application no" class="tooltip-top show-pop-list" data-placement="right">
                            	 <?php $dd_flag = ($results['data'][0]['DrawdownReservation'] == 'Y') ? $results['data'][0]['DrawdownReservation']:'N'; ?>
                            	<i id="change_application" class="fa fa-pencil-square-o fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 4px; margin-left: 5px; <?php echo ($dd_flag == 'Y' || $result_app_hist['status'] == 'false' || count($result_app_hist['data']) == 1) ? 'display: none;':''?>"></i>
                            	<div id="change_application_tools" class="tools-container">
                            		<div class="tools-header">
                            			Change Application
                            			<i id="change_application_close" class="fa fa-close fg-white clsoe_icon"></i>
                            		</div>
                            		<ul class="treeview" data-role="treeview"> 
                            			<li class="node">        
                            				 <a href="#" class="list_node"><span class="node-toggle"></span>Application History (คลิกเพื่อเลือก)</a>
                            				 <ul>              			
		                            		<?php 
		                        	
		                            			if($result_app_hist['status'] == 'true') {
		                            				foreach ($result_app_hist['data'] as $i => $v) {
		                            					$app_no = !empty($results['data'][0]['ApplicationNo']) ? trim($results['data'][0]['ApplicationNo']):"";
		                            					$active = '';
		                            					$active_str = '';
		                            					
		                            					if($app_no == $v['ApplicationNo']) {
		                            						$active = 'active';
		                            						$active_str = '(Used)';
		                            					}
		                            					
		                            					echo '<li>
															<a href="#" onclick="$(\'#application_request\').val(\''.$v['ApplicationNo'].'\');" class="'.$active.'">' . 
															($i+1) . '. ' . $v['ApplicationNo'] . ' ' . $active_str . 
		                            						'</a>
														</li>';
		                            				}
					                        	}
					                        			                        	
				                        	?>
				                        	</ul>
				                        </li>
                            		</ul>
                            		<div class="tools-content">
                            			<div class="input-control text marginTop10">
										    <input id="application_request" type="text" placeholder="Enter application no" maxlength="15" />										    
										</div>
										<button id="application_check" type="button" class="place-right">Check</button>
                            		</div>                            	
                            	</div>
                            </span>
                        </div>
                    </div>
                    
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">CA Name</label>
                            <div class="input-control text span3">
                            	<input type="text" name="caname" id="caname" value="<?php echo !empty($results['data'][0]['CAName']) ? ltrim($this->effective->get_chartypes($char_mode, $results['data'][0]['CAName'])):""; ?>" class="marginLeft20 size3" style="max-width: 195px;" readonly="readonly" <?php echo $disable_attr; ?>>
                            </div>
                            <div class="input-control text span2" style="max-width: 105px;">
                        		<input id="careceived_date" name="careceived_date" type="text" value="<?php echo !empty($results['data'][0]['CA_ReceivedDocDate']) ? StandartDateRollback($results['data'][0]['CA_ReceivedDocDate']):""; ?>" class="size2" style="max-width: 100px;" readonly="readonly" <?php echo $disable_attr; ?>>
                        	</div>   
                        	<?php 
                        	
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
                    </div>
                    
                    <div id="parent_creditnamelog" style="display: none;">
                    <?php 
               
                   		if(!empty($result_cahistory['data'][0]['CA_ReceivedDate'])) {                   			
                   			foreach($result_cahistory['data'] as $index => $value):
                   				//echo '#'.substr($this->effective->StandartDateRollback($result_cahistory['data'][$index]['CA_ReceivedDate']), 0, 5).' '.$this->effective->get_chartypes($char_mode, $result_cahistory['data'][$index]['CAName']).'<br/>';
                   				echo '#'.$this->effective->StandartDateRollback($result_cahistory['data'][$index]['CA_ReceivedDate']).' '.$this->effective->get_chartypes($char_mode, $result_cahistory['data'][$index]['CAName']).'<br/>';
                   			endforeach;
                   		                   			
                   		} else { echo 'ไม่พบข้อมูล'; }
                                   		
                    ?>
                    </div>
                    
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Approver Name</label>
                            <div class="input-control text span4">
                            	<input type="text" name="approvername" id="approvername" value="<?php echo !empty($results['data'][0]['ApproverName']) ? ltrim($this->effective->get_chartypes($char_mode, $results['data'][0]['ApproverName'])):""; ?>" class="marginLeft20" readonly="readonly" <?php echo $disable_attr; ?>>
                            </div>                            
                        </div>                       
                    </div>
 
                    <div class="span12">
                        <div class="input-control textarea">
                            <label class="span4 text-blue">CA Comment</label>
                            <textarea id="comment nonprint" name="comment" type="text" rows="5" class="span4" readonly="readonly" <?php echo $disable_attr; ?>><?php echo !empty($results['data'][0]['AppComment']) ? ltrim($this->effective->get_chartypes($char_mode, $results['data'][0]['AppComment'])):""; ?></textarea>
                           
                            <span id="objFixed" class="none nonprint" style="margin-left: 10px; font-size: 1.3em;" data-hint="ขยายข้อความ" data-hint-position="top">
                                <i class="icon-menu fg-lightBlue" style="margin-top: 2em;"></i>
                            </span>
                            
                        </div>
                    </div>
                    
                   <div class="span12">
                        <div class="input-control textarea">
                            <label class="span4 text-blue">CA Income Calculation</label>
                            <textarea id="caincome nonprint" name="caincome" type="text" rows="5" class="span4" readonly="readonly"></textarea>
                           
                            <span id="objFixed" class="none nonprint" style="margin-left: 10px; font-size: 1.3em;" data-hint="ขยายข้อความ" data-hint-position="top">
                                <i class="icon-menu fg-lightBlue" style="margin-top: 2em;"></i>
                            </span>
                            
                        </div>
                    </div>
                    
					<!-- 
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Status Date</label>
                            <div class="input-control text span4" style="margin-left: 20px;">
                                <input id="statusdate" name="statusdate" type="text" value="<?php echo !empty($results['data'][0]['StatusDate']) && ($results['data'][0]['StatusDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['StatusDate']):""; ?>" readonly="readonly">
                            </div>
                        </div>
                    </div>            
                    -->
                    <div class="span12">
                        <div id="appstatus" class="input-control select">
                            <label class="span4 text-blue">Application Status</label>
                            <div class="input-control text span3" style="margin-left: 20px; margin-right: 5px; max-width: 190px;">
                                <input id="status" name="status" type="text" value="<?php echo !empty($results['data'][0]['Status']) ? $results['data'][0]['Status']:""; ?>" readonly="readonly" <?php echo $disable_attr; ?>>
                            </div>
                             <div class="input-control text span2" style="max-width: 105px;">
                        		 <input id="statusdate" name="statusdate" type="text" value="<?php echo !empty($results['data'][0]['StatusDate']) && ($results['data'][0]['StatusDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['StatusDate']):""; ?>" readonly="readonly" <?php echo $disable_attr; ?>>
                        	</div>
                        	<div class="toolbar fg-black span1 nonprint" style="margin-top: 2px; margin-left: 5px;">
                            	<span id="status_callhistory" class="tooltip-top show-pop-list" data-tooltip="Status History" class="tooltip-top show-pop-list" data-placement="right">
                            		<i class="fa icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
                            	</span>                
				        	</div>
                        </div>
                    </div>
                                       
                    <div id="parent_status_callhistory" style="display: none; max-height: 300px;">
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
                            <div class="input-control text span4" style="margin-left: 20px;">
                                <input id="objreason" name="objreason" type="text" value="<?php echo !empty($results['data'][0]['StatusReason']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['StatusReason']):""; ?>" readonly="readonly" <?php echo $disable_attr; ?>>
                            </div>
                        </div>
                    </div>
                    
                    <div class="span12">
                        <div class="input-control text">
                            <label class="span4 text-blue">Deviate Reason</label>
                            <div class="span4">
                            	<input id="deviate_code" name="deviate_code" type="text" value="<?php echo !empty($results['data'][0]['DiviateReason']) ? $results['data'][0]['DiviateReason']:""; ?>" readonly="readonly" <?php echo $disable_attr; ?>>
                            </div>
                            <div class="toolbar fg-black span1 nonprint" style="margin-top: 2px; margin-left: 5px;">
                            	<?php if(!empty($results['data'][0]['DiviateReason'])) { ?>
                            	<span id="TranslateCode" class="tooltip-top show-pop-list" data-tooltip="Translate Reason Code" class="tooltip-top show-pop-list" data-tooltip="Translate Reason Code" data-placement="right" <?php echo $disable_attr; ?>>
                            		<i class="fa fa-language fg-lightBlue fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
                            	</span>
                            	<?php } ?>
				        	</div>
                        </div>
                    </div>
                    
                    <div id="parent_translatereason" style="display: none;">
                    <?php 
                    	
                    	if(!empty($results['data'][0]['DiviateReason'])) {
                    	
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
	                    			echo $i. '. ['. $inquiry['data'][$index]['LISTCODE'].'] ' . $inquiry['data'][$index]['DESCRIPTION'] . '<br/>';
	                    			$i++;
	                    		}
                    		
                    		endif;
             
                    	} else { echo 'ไม่พบข้อมูล'; }
                    	
                    ?>                    
                    </div>
                    
                    <div class="span12">
                        <div id="parent_preapproved" class="input-control">
                            <?php $preapp = !empty($results['data'][0]['PreApproved']) ? intval($results['data'][0]['PreApproved']):""; ?>
                            <label class="span4">Pre Approved Loan</label>                        
                            <div class="input-control text span4" style="margin-left: 20px;">
                            	<input type="text" name="preloan" id="preloan" value="<?php echo !empty($results['data'][0]['PreLoan']) ? intVal($results['data'][0]['PreLoan']):"0"; ?>" <?php echo $disable_attr; ?>>
                            </div>
                          	<div id="preloan_alert" class="span4 text-alert"></div>
                        </div>
                    </div>
			
					<?php $approved_loan = !empty($results['data'][0]['ApprovedLoan']) ? intval($results['data'][0]['ApprovedLoan']):""; ?>
					<?php 
                    	$dd_loan  = !empty($results['data'][0]['DrawdownBaht']) ? $results['data'][0]['DrawdownBaht']:""; 
                    	$dd_total = !empty($results['data'][0]['TotalDrawdown']) ? number_format($results['data'][0]['TotalDrawdown'], 0):""; 
                    	$dd_date  = !empty($results['data'][0]['DrawdownDate']) && ($results['data'][0]['DrawdownDate'] != '1900-01-01') ? trim(StandartDateRollback($results['data'][0]['DrawdownDate'])):"";
                    	
                    	$dd_diff  = $approved_loan - $dd_loan;
                    ?>
                    <div class="span12" <?php if(trim($approved_loan) == "") echo 'style="display: none;"'; ?>>
                        <div class="input-control text">
                            <label class="span4 text-blue">Approved Loan</label>
                            <input type="text" name="approvedamount" id="approvedamount" value="<?php echo $approved_loan; ?>" class="span4" readonly="readonly" <?php echo $disable_attr; ?>>
                            <div class="span1" style="color: #d2322d;"></div>
                            <div id="apploan_alert" class="span3 text-alert"></div>
                        </div>
                    </div>
                    
                    <?php 
                     	$pending_cancel_state = (!empty($results['data'][0]['Status']) && $results['data'][0]['Status'] == 'PENDING') ? '':'disabled="disabled"';
                     	$has_pendingcancel_log = !empty($pending_cancel_logs['data'][0]['PendingCancelStatus']) ? $pending_cancel_logs['data'][0]['PendingCancelStatus']:0; 
//                     	$pendingcancel_reason = !empty($pending_cancel_logs['data'][0]['PendingCancelReason']) ? $pending_cancel_logs['data'][0]['PendingCancelReason']:""; 
//                     	$show_pending_cancel = (!empty($has_pendingcancel_log) && $has_pendingcancel_log == 'Y') ? '' : 'style="display: none;"';
//                     	$hide_pending_cancel = (!empty($has_pendingcancel_log) && $has_pendingcancel_log == 'Y') ? 'style="display: none;"' : '';
//                     	$hide_pending_cancel_attr = (!empty($has_pendingcancel_log) && $has_pendingcancel_log == 'Y') ? 'display: none;' : '';
                     	
                    ?>
                    
                    <div class="span12" style="margin-left: 20px;">
	                	<label class="span4">Cancel Reason (After A2CA)</label>
	                	<!-- 
	                	<div class="input-control checkbox span1" data-role="input-control" style="margin-left: 20px;">
	                		<?php if($has_pendingcancel_log == 1): ?>
		                		<label>			
		                			<input type="checkbox" <?php echo (!empty($has_pendingcancel_log) && $has_pendingcancel_log == 'Y') ? 'checked="checked"':''; ?> disabled="disabled">
		                			<span class="check"></span>
		                		</label>
	                		<?php else: ?>                		
					        <label>					        	
					        	<input id="pending_cancel_check" name="pending_cancel_check" type="checkbox" value="Y" <?php echo $pending_cancel_state; ?>>					        	
					        	<span class="check"></span>
					        </label>
					    
					       	<?php endif; ?>
					    </div>   
					    -->
					    <div class="input-control checkbox span1">
					    	<?php if($has_pendingcancel_log == 1 || $has_pendingcancel_log == 'Y'): ?>
		                		<label>			
		                			<input type="checkbox" <?php echo ($has_pendingcancel_log == 1 || $has_pendingcancel_log == 'Y')? 'checked="checked"':''; ?> disabled="disabled">
		                			<span class="check"></span>
		                		</label>
	                		<?php else: ?>                		
					        <label>
					        	<input type="checkbox" id="pending_cancel_check" name="pending_cancel_check" value="Y" <?php echo $pending_cancel_state; ?>>
					        	<span class="check"></span>
					        </label>
					        <?php endif; ?>
				        </div>             
						<div id="objPendingCancel" class="input-control select span4 marginRight5" style="margin-left: -30px; max-width: 270px;">
							<select id="pending_cancel" name="pending_cancel[]" multiple="multiple" disabled="disabled"></select>
		                </div>
		                 <span class="fg-amber nonprint">
		                 	<i id="clear_pending_cancel" class="fa fa-trash fg-lightBlue fg-gray padding3 no-margin-top" 
		                 	   style="font-size: 1.5em; margin-top: 0px; margin-left: 5px; cursor: pointer; "
					       	<?php echo ($has_pendingcancel_log == 1 || $has_pendingcancel_log == 'Y') ? '':'display: none;'; ?>
		                 	></i>
		                 </span>
	                </div>

					<?php $appr_status = !empty($results['data'][0]['Status']) ? $results['data'][0]['Status']:""; ?>
                    <div class="span12">
				    	<label class="span4">Cancel Reason (After Approved)</label>
				        <div class="input-control checkbox span1">
					        <label>
					        	<input type="checkbox" id="cancel_checker" name="cancel_checker" value="1" <?php if(!empty($afapproved)) echo 'checked="checked"'; ?> <?php echo $disable_attr; ?> <?php if($appr_status != 'APPROVED' || in_array($user_role, array('admin_role', 'adminbr_role', 'rm_role'))) { echo 'disabled="disabled"'; } ?>>
					        	<span class="check"></span>
					        </label>
				        </div>
				        <div id="cancel_reason_parent"  class="input-control select span4 marginRight5" style="margin-left: -30px; max-width: 270px;">
				            <select id="cancel_reason" name="cancel_reason[]" multiple="multiple"  <?php echo $disable_attr; ?> <?php if($appr_status != 'APPROVED' || in_array($user_role, array('admin_role', 'adminbr_role', 'rm_role'))) { echo 'disabled="disabled"'; } ?>></select>
				        </div>					         
				        <div class="toolbar fg-black nonprint" style="margin-top: 2px;">
				        	<?php  if(!empty($objNonAccept['data'][0]['DocID'])) { ?>
				        	<span  id="nonoacept_logs"  class="tooltip-top show-pop-list" data-tooltip="Cancel List Reason History (After Approved)" data-placement="right">
				        		<i id="nonoacept_icon" class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
				        	</span>
				        	<?php } ?>				        	
				        	<span  id="afterRefun" class="tooltip-top" data-tooltip="Reload List Reason (Click)">
				        		<i class="fa fa-refresh fg-lightBlue fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
				        	</span>				         					    
				        </div>
				    </div>
				    
                    <div id="parent_afcancel_reason" class="span12">
                        <div class="input-control text">
                            <label class="span4">Other Reason (CC - After Approved)</label>
                            <div class="input-control text span4" style="margin-left: 20px;">
                                <input type="text" id="afcancel_other" name="afcancel_other" value="" <?php echo $disable_attr; ?>>
                                <button class="btn-clear" tabindex="-1" type="button" onclick="$('#afcancel_other').val('');"></button>
                            </div>
                        </div>
                    </div>                    
                     
                    <!-- <?php echo !empty($results['data'][0]['AFCancelReasonOther']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['AFCancelReasonOther']):""; ?> --> 
                    
                    <div id="nonaccept_reasonarea" style="display: none; font-size: 0.8em !important;">
                    <?php                     

	                    if(empty($objNonAccept['data'][0]['DocID'])) {
	                    	echo "<div>ไม่พบข้อมูล</div>";
	                    	
	                    } else {
	                    	                    
	                    	$i = 1;
	                    	foreach ($objNonAccept['data'] as $index => $value) {
	                    
	                    		if(!empty($objNonAccept['data'][$index]['OtherDetail'])):
	                    		$text_nonacceptreason = $objNonAccept['data'][$index]['MasterReason']. ' ' .$objNonAccept['data'][$index]['OtherDetail'] . ' (Date: ' . substr($objNonAccept['data'][$index]['CancelDate'], 0, 5) . ')';
	                    		else:
	                    			$text_nonacceptreason = $objNonAccept['data'][$index]['MasterReason'] . ' (Date: ' . substr($objNonAccept['data'][$index]['CancelDate'], 0, 5) . ')';
	                    		endif;
	                    
	                    		echo "<div>". $i .'. '. $text_nonacceptreason ."</div>";
	                    
	                    		$i++;
	                    	}
	                    
	                    }                    	
                    
                    ?>
                    </div>      
                    
                    <?php $dd_reserv = ($results['data'][0]['DrawdownReservation'] == 'Y') ? $results['data'][0]['DrawdownReservation']:'N'; ?>
                    <?php $receiveEstimated = ($results['data'][0]['ReceivedEstimateDoc'] == 'Y') ? $results['data'][0]['ReceivedEstimateDoc']:'N'; ?>

                    <?php sort($official_holiday); ?>
                    <input id="lastDayOfMonth" name="lastDayOfMonth" type="hidden" value="<?php echo date('Y-m-d',strtotime(date('Y-m-t') . "+1 days")); ?>">
                    
                    <div class="span12">
                    	<input id="plandrawdowndate_temp" name="plandrawdowndate_temp" type="hidden" value="<?php echo !empty($results['data'][0]['PlanDrawdownDate']) && ($results['data'][0]['PlanDrawdownDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['PlanDrawdownDate']):""; ?>">
                        <div class="input-control text">
                            <label class="span4">
                            	Drawdown Plan Date
                            	<span <?php if($dd_reserv == "Y") { echo 'style="display: none;"'; } else { echo 'style="color: red; font-weight: bold;"'; }?>>
					        		<?php 
					        			if($receiveEstimated == 'Y' && in_array($session_data['role'], array('admin_role', 'hq_role', 'dev_role'))) {
					        				echo '(OPER รับเล่มแล้ว)';
					        			}
					        		?>
					        	</span>
                            </label>

                            <div id="plandrawdowndate" class="input-control text span3" style="margin-left: 20px; margin-right: -10px; max-width: 190px; <?php if($dd_reserv == "Y") echo ' display:none;'; ?>  <?php echo $hide_attr; ?> ">                            	
                                <input id="objplandrawdowndate" name="plandrawdowndate" type="text" value="<?php echo !empty($results['data'][0]['PlanDrawdownDate']) && ($results['data'][0]['PlanDrawdownDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['PlanDrawdownDate']):""; ?>" <?php  if($dd_reserv == "Y") echo ' readonly="readonly" style="background: #E6E6E6;"'; ?>  readonly="readonly">
                            </div>
                            
                            <div id="pandrawdownlabel" class="input-control text span3" style="margin-left: 20px; margin-right: -10px; max-width: 190px; border: 1px solid #D1D1D1; <?php if($dd_reserv == "Y") echo ' display="block" '; else  echo ' display:none;'; ?>">                            	
                                <div style="padding: 5px; background: #eee; min-width: 185px; min-height: 32px;"><?php echo !empty($results['data'][0]['PlanDrawdownDate']) && ($results['data'][0]['PlanDrawdownDate'] != '1900-01-01') ? StandartDateRollback($results['data'][0]['PlanDrawdownDate']):""; ?></div>
                            </div>
                            
                            <div class="input-control checkbox span2" style="max-width: 125px;">
                                <label>
							    	<input id="tmp_drawdown_reserv" name="tmp_drawdown_reserv" type="checkbox" value="Y" <?php if($dd_reserv == "Y") echo ' checked="checked" disabled="disabled"'; ?>>
							    	<span class="check"></span> จอง Drawdown
							    </label>
							    <input id="drawdown_reserv_draft" name="drawdown_reserv_draft" type="hidden" value="<?php echo $dd_reserv; ?>">
							    <input id="drawdown_reserv" name="drawdown_reserv" type="hidden" value="<?php echo $dd_reserv; ?>">
							    <input id="official_holiday" name="official_holiday" type="hidden" value="<?php echo implode(',', $official_holiday); ?>">
                            </div>
                            <div id="parent_unknowns" class="input-control checkbox span2">
						        <label>
						        	<input id="unknown_state" name="unknown_state" type="checkbox" value="Y" <?php if($results['data'][0]['PlanDateUnknown'] == "Y") echo 'checked="checked"'; ?>>
						        	<span class="check"></span>
						        	<span>เลื่อนไม่มีกำหนด</span>
						        </label>
				        	</div>
				        	<div class="input-control checkbox span2 icon_blink tooltip-top <?php if(!empty($dd_loan) && $dd_loan <= 0) echo 'hide'; ?> " data-tooltip="ปลดล๊อคเพื่อจอง Drawdown (เฉพาะเบิกงวดงาน)" <?php echo ((!empty($dd_loan) && $dd_diff > 100000) || (!empty($dd_history['data'][1]['ApplicationNo']) && $dd_reserv == "Y")) ? 'style="display: block; margin-left: -45px !important;"':'style="display: none;"'; ?>>
				        	 	<i id="unlockedDDReserv" class="fa fa-unlock" style="font-size: 1.7em; cursor: pointer; margin-top: 2px; color: lightslategray;"></i>
				        	</div>
                        </div>                       
                    </div>                       
                   
                    <div class="span12">
				    	<label class="span4">Postpone Drawdown Plan Reason</label>
				        <div class="input-control checkbox span1">
					        <label>
					        	<input id="postpone_checker" name="postpone_checker" type="checkbox" value="1" <?php echo $disable_attr; ?>>
					        	<span class="check"></span>
					        </label>
				        </div>
				        <div id="postpone_reason_parent" class="input-control select span4 marginRight5" style="margin-left: -30px; max-width: 270px;">
				        	<input id="postpone_planreasonlist" name="postpone_planreasonlist" type="hidden" value="">
				            <select id="postpone_planreason" name="postpone_planreason[]" multiple="multiple" <?php echo $disable_attr; ?>></select>
				        </div>
				        <div class="toolbar fg-black nonprint" style="margin-top: 2px;">
				        	<?php if(!empty($objPostpone['data'][0]['DocID'])) { ?>
				        	<span id="postpone_logs" class="tooltip-top show-pop-list" data-tooltip="Postpone Drawdown Reason History" data-placement="right">
				        		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
				        	</span>
				        	<span class="badge bg-lightBlue" style="position: absolute; margin-left: -18px; margin-top: -6px;">
				         		<?php    
				         		 
			                    	$badge = $this->dbmodel->CIQuery("SELECT TOP 1 PostponeRef, CONVERT(nvarchar(10), OriginalPlan, 120) AS OrginalPlanDate  FROM PostponeHead WHERE DocID = '".$results['data'][0]['DocID']."' ORDER BY PostponeRef DESC");
			                    	if(!empty($badge['data'][0]['PostponeRef'])):
			                    		echo $badge['data'][0]['PostponeRef'];
			                    	else:
			                    		echo 0;
			                    	endif;
				                    	
				                ?>
				         	</span>	
				         	<?php } ?>
				         	<span id="postponeload" class="tooltip-top" data-tooltip="Reload List Reason (Click)">
				        		<i class="fa fa-refresh fg-lightBlue fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
				        	</span>						        	    
				        </div>
				    </div>
				    
				    <div id="root_postpone_plandate" class="span12" style="display: none;">
                        <div class="input-control text">
                            <label class="span4">Other Reason (Postpone)</label>
                            <div id="parent_postpone_plandate" class="input-control text span4" style="margin-left: 20px;">
                               	<input id="postpone_otherdesc" name="postpone_otherdesc" type="text" value="" <?php echo $disable_attr; ?>>
                                <button class="btn-clear" tabindex="-1" type="button" onclick="$('#postpone_plandate').val('');"></button>
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
          
                    <div class="span12" <?php if(trim($dd_loan) == "") echo 'style="display: none;"'; ?>>
                        <div class="input-control">
                            <label class="span4 text-blue">Drawdown Loan / Date (Latest)</label>
                            <div class="input-control text span3" style="margin-left: 20px; margin-right: 5px; max-width: 190px;">
                                <input id="drawdownamount" name="drawdownamount" type="text" value="<?php echo $dd_loan; ?>" readonly="readonly" <?php echo $disable_attr; ?>>
                            </div>
                             <div class="input-control text span2" style="max-width: 105px;">
                        		 <input id="drawdowndate" name="drawdowndate" type="text" value="<?php echo $dd_date; ?>" readonly="readonly" <?php echo $disable_attr; ?>>
                        	</div>
                        </div>
                    </div>
              
                    <div class="span12" <?php echo empty($dd_history['data'][1]['ApplicationNo']) ? 'style="display: none;"':''; ?>>
                        <div class="input-control text">
                            <label class="span4 text-blue">Total Drawdown Loan</label>
                            <input id="total_drawdown" name="total_drawdown" value="<?php echo $dd_total; ?>" class="span4" readonly="readonly" <?php echo $disable_attr; ?>>
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
                            <input id="drawdowntype" name="drawdowntype" value="<?php echo $dd_type; ?>" class="span4" readonly="readonly">
                        </div>
                    </div>
 
 					<?php $term_year = !empty($results['data'][0]['TermYear']) ? $results['data'][0]['TermYear']:""; ?>
                    <div class="span12" <?php if(trim($term_year) == "") echo 'style="display: none;"'; ?>>
                        <div class="input-control text">
                            <label class="span4 text-blue">Term (Year)</label>
                            <input type="text" name="termyear" id="termyear" value="<?php echo $term_year; ?>" class="span1" readonly="readonly">
                            <div id="termmonth" class="input-control span2" style="margin-top: 6px; margin-left: 4px;"></div>
                        </div>
                    </div>              
                    
	                <div class="span12" style="margin-left: 20px;">
	                	<?php $contact_date = !empty($results['data'][0]['ReceivedContactDate']) && ($results['data'][0]['ReceivedContactDate'] != '1900-01-01') ? trim(StandartDateRollback($results['data'][0]['ReceivedContactDate'])):""; ?>
	                	<label class="span4">Received Contract Date</label>
	                	<div class="input-control checkbox span1" data-role="input-control" style="margin-left: 20px;">
					        <label>
					        	<input id="contact_check" name="contact_check" type="checkbox" <?php if(!empty($contact_date)) echo ' checked="checked"'; ?> <?php echo $disable_attr; ?>>
					        	<span class="check"></span>
					        </label>
					    </div>                
						<div id="objContactdate" class="input-control text span4" data-role="input-control" style="margin-left: -30px; max-width: 270px;">
		                	<input id="contactdate" name="contactdate" type="text" value="<?php echo $contact_date; ?>" <?php echo $disable_attr; ?>>
		                    <button class="btn-clear" tabindex="-1" type="button" onclick="$('#contactdate').val(''); $('#contact_check').prop('checked', false);"></button>
		                </div>
		                 <span class="fg-amber nonprint">&nbsp;<small> (HQ)</small></span>
	                </div>
	                
                    <div class="span12" style="margin-left: 20px;">
                        <div class="input-control textarea">
                            <label class="span4">Remark</label>
                            <textarea id="contact_comment" name="contact_comment" type="text" class="span4" <?php echo $disable_attr; ?>><?php echo !empty($results['data'][0]['ContactRemark']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['ContactRemark']):""; ?></textarea>   
                             <span class="fg-amber nonprint">&nbsp;<small> (HQ)</small></span>                        
                        </div>
                    </div>

                    <div class="span12" style="display: none;">
                        <div class="input-control text">
                            <label class="span4 text-blue">Diff (DD Loan: Approved Loan)</label>
                            <input name="diff" id="diff" class="span4" value="<?php echo !empty($results['data'][0]['Diff']) ? $results['data'][0]['Diff']:"0"; ?>" readonly="readonly">
                        	<span class="fg-amber nonprint">&nbsp;<small> (Auto)</small></span>
                        </div>
                    </div>

                    <div class="span12" style="display: none;">
                        <div class="input-control text">
                            <label class="span4 text-blue">Count Day (DD Date: Approved Date)</label>
                            <input name="countday" id="countday" value="<?php echo !empty($results['data'][0]['CountDay']) ? $results['data'][0]['CountDay']:"0"; ?>" class="span4" readonly="readonly">
                            <span class="fg-amber nonprint">&nbsp;<small> (Auto)</small></span>
                        </div>
                    </div>
                    
                    <div class="span12">&nbsp;</div>
                    <div class="span12 nonprint">
                        <div class="span5">
                            <div id="progresses" class="span1"><img src="<?php echo base_url('img/ajax-loader.gif'); ?>" style="visibility: hidden;"></div>
                            <div id="msg_alert"></div>
                        </div>

                        <div class="span6" style="position: absolute; margin-left: 540px; <?php echo $hide_attr; ?>" >
                            <button id="btnApplicationStatusSubmit" type="submit" name="submit" style="min-width: 80px; height: 34px;" class="bg-lightBlue fg-white"><i class="fa fa-save on-left"></i>Submit</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
        
        <?php
        
        if(!empty($role_handled)) {
        
        	if($role_handled['status'] === false && $role_handled['access'] == "permission") {
        		echo '<div class="span12" style="margin-top: 10px;"><p class="important text-alert"><i class="fa fa-ban text-alert"></i> '.$role_handled['msg'].'<p></div>';
        
        	}
        
        }
        	
        if(!empty($databundled)) {
        		
        	if($databundled['status'] === false && $databundled['access'] == "databundle") {
        		echo '<div class="span12" style="margin-top: 10px;"><p class="important text-alert"><i class="icon-warning on-left text-alert"></i> '.$databundled['msg'].'<p></div>';
        			
        	}
        		
        }
        	
        $forms = isset($_GET['forms']);
        $checks = isset($_GET['checked']);
        
        if(!empty($forms) && !empty($checks)) {
        	
        	if($_GET['forms'] == 'success' && $_GET['checked'] == 'false') {
        		echo '<div class="span12" style="margin-top: 10px;"><p class="alert alert-success text-success" role="alert"><i class="icon-checkmark on-left text-success"></i> '."ปรับปรุงข้อมูลสำเร็จ.".'<p></div>';
        	}
        	
        	if($_GET['checked'] == 'unique') {
        		echo '<div class="span12" style="margin-top: 10px;"><p class="alert alert-success text-alert" role="alert"><i class="icon-cancel-2 on-left text-alert"></i> '."Application No นี้ มีในระบบแล้ว กรุณาตรวจสอบใหม่อีกครั้ง.".'<p></div>';
        	}
        	
        	
        }
        
        ?>
        
        <span class="span12" style="margin-top: 15px; margin-bottom: 10px; padding-left: 25px;"><small><u>หมายเหตุ :</u> ข้อมูลที่มีการอัพเดทอัตโนมัติจะมีตัวอักษรเป็นสีฟ้า</small></span>
        
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