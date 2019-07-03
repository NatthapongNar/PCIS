<style>
	.ui-multiselect {
		height: 34px;
		border: 1px solid #D1D1D1;
		background: #FFF;
		min-width: 395px;
	}
	
    .no-margin-top { margin-top: -5px; }
    .padding3 { padding: 3px; }
    .padding5 { padding: 5px; }
    .padding10 { padding: 10px; }
    
    .cb-marginFixedIE { 
    	position:absolute; 
    	margin-left: -15px; 
    	margin-top: 0px; 
    	z-index: 999; 
    }
    
    @media screen and (-webkit-min-device-pixel-ratio:0) { 
		.cb-marginFixedChrome {
			margin-top: 2px !important;
			margin-left: 5px !important;
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
		
		.btnDefend {
			height: 27px !important;
			padding-top: 8px;
		}
		
	 }
	
    .case_history { height: 32px; width: 150px; text-align: center; padding: 5px; color: white; }
    .returnBox { max-width: 790px; border: 1px solid gray; background: #fcfff4; }
    .label-clear { background-color: #FFF !important; }
    .ms-parent { background: #EBEBE4; }
    
    #defend_content, #careturn_content, #rmprocess_content  { 
    	padding: 20px;
    	font-size: 0.9em;
    	font-weight: normal;

    }
    
    #defend_content .panel-content,    
    #rmprocess_content .panel-content { padding: 20px; }
    
    #careturn_content .panel-content { margin-top: 5px; padding-bottom: 20px; }
    
    div#msg_identityresponsed, div#retrieve_msg_identityresponsed {
	    text-align: center;
	    color: red;
	}
	
	#bpm_information {		
		padding: 15px 0;
		margin-top: 10px; 
		background: #EFECEC; 		
	}
	
	.bs-list-group {
		padding-left: 0 !important;
		margin-bottom: 20px !important;
		font-size: 1em !important;
		font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
	    font-weight: normal;
	    font-style: normal;
	}
	
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
	
	.text-selectred { color: red; }
	.tooltip-top { text-align: center !important;}
	
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
	
	.calendar.calendar-dropdown {
		z-index: 100000 !important;
	}
	
	.icon_blink_slow { animation: blink 2s ease-in infinite; }
	@keyframes blink {
	  from, to { opacity: 1 }
	  50% { opacity: .4 }
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
	
	.maxWidth {  width: -webkit-fill-available !important; }
	.logo_header img { min-width: 1170px; width: -webkit-fill-available; }
	.marginLeft0 { margin-left: 0px !important; }
	.marginLeft5 { margin-left: 5px !important; }
	.marginLeft20 { margin-left: 20px !important; }
	
	.paddingLeft0 { padding-left: 0px !important; }
	.paddingLeft5 { padding-left: 5px !important; }
	
	.container {
		width: 1235px !important;
	}
	
	.label_info {
	    color: #FFF;
	    padding: 7px 10px !important;
	    font-size: 1em !important;
	    border: 1px solid #FFF;
	}
				
</style>


<div class="container" ng-controller="verify_ctrl">
	
	<div class="grid" style="margin-left: -65px;">
		<div id="form" class="row">
			<div class="logo_header">
				<img src="<?php echo base_url('img/logo_form_header.jpg'); ?>">
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
				
				<section class="span12 marginLeft0">

					<!-- PANEL  -->
					<div id="panel_criteria" class="panel maxWidth nonprint" data-role="panel" style="min-height: 30px; margin-bottom: 10px; width: 1130px !important;">
						<div class="panel-header bg-lightBlue fg-white" style="font-size: 1em;"><i class="icon-user-3 on-left"></i>Basic Information</div>
						<div class="panel-content" style="display: none;">
							
							<div class="row">
							
								<div class="span6 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลลูกค้า</label></div>
								<div class="span6 text-left"><label class="span2" style="margin-left: 22px; text-decoration: underline;">ข้อมูลพนักงาน</label></div>
								
								<div class="span6">
									<label class="label span2 text-left">ชื่อ - นามสกุล</label>	
									<?php $prefix 	= !empty($getCustInfo['PrefixName']) ? $getCustInfo['PrefixName']:""; ?>
									<?php $custname = !empty($getCustInfo['OwnerName']) ? $getCustInfo['OwnerName']:""; ?>	
									<?php $borrower = !empty($getCustInfo['BorrowerName']) ? $getCustInfo['BorrowerName']:""; ?>								
									<div class="label span4 text-left"><?php echo !empty($borrower) ? $borrower : $custname;  ?></div>
									<input id="borrowername_title" type="hidden" value="<?php echo !empty($borrower) ? $borrower : $custname;  ?>">
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
								<div class="span6"></div>
							
							</div>
			
						</div>
					</div>
					<!-- /PANEL  -->
					
					<!-- START FORM -->
					<div class="span12">
				        <div class="input-control select">
				            <label id="label_onbehalf" class="span4">On Registration Of</label>

				            <div class="input-control radio marginLeft20">
				                <label>
				                    <input type="radio" name="on_helf" value="1" >
				                    <span class="check"></span> บุคคล 
				                </label>
				            </div>				            
				            <div class="input-control radio" style="margin-left: 29px;">
				                <label>
				                    <input type="radio" name="on_helf" value="2">
				                    <span class="check"></span> นิติบุคคล
				                </label>
				            </div>
				        </div>			        
				    </div>
				    
				    <!--  ID Card / Business Registration Number -->
				    <div id="parent_identify" class="span12">
				        <label id="label_idcard" class="span4">ID Card</label>
				        <div class="input-control text span4" style="margin-left: 20px;">
				            <input id="id_card_dump" type="text" value="" maxlength="13" disabled="disabled">
				            <button class="btn-clear" tabindex="-1" type="button"></button>
				            <small class="fg-amber" style="white-space: nowrap;"></small>
				        </div>			       
				        <button id="btnCheckIdentity" type="button" style="margin-left: 5px; height: 33px; width: 85px;">Check ID</button> 
				    </div>
				    
				    <div class="span12">
				        <div class="input-control select">
				            <label class="span4">Product Program</label>
				            <select id="productprg" name="productprg" class="span4">
				            	<option value="">กรุณาเลือกโปรแกรม</option>
				            </select>
				            <select id="loantypes" name="loantypes" class="span2 marginLeft5">
				            	<option value="">กรุณาเลือกหลักทรัพย์</option>				            	
				            </select>
				            <select id="banklist" name="banklist" class="span2" style="margin-left: 5px; max-width: 150px !important;">
				            	<option value="">กรุณาเลือกแบงค์</option>
				            </select>
				        </div>
				    </div>	
				    
				     <div class="span12">
				        <div class="input-control">
				            <label class="span4">Insurance</label>
				            <div class="input-control checkbox marginLeft20">
				                <label>
				                    <input type="checkbox" name="mrta" value="1">
				                    <span class="check"></span> MRTA 
				                </label>
				            </div>
				             <div class="input-control checkbox" style="margin-left: 29px;">
				                <label>
				                    <input type="checkbox" name="cashy" value="1" >
				                    <span class="check"></span> Cashy
				                </label>
				            </div>
				        </div>
				    </div>
				    
				    <header class="span12 marginLeft0" style="width: 1130px !important;">
				    	<span class="label label_info"">NCB Consent</span>
				    </header>
				    <div class="span12 form_container marginLeft0" style="width: 1130px !important; margin-top: -10px; ">			
				    	<table class="maxWidth">
	                        <thead>
	                        	<tr>
		                            <th align="left" width="110px;">TYPE</th>
		                            <th align="left">NAME - SURNAME</th>
		                            <th align="left">NCB</th>
		                            <th align="left">CHECK NCB</th>
		                            <th align="left">LB <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
		                            <th align="left"><i class="fa fa-inbox on-left"></i> HO RECEIVED</th>
		                            <th align="left">HO <i class="fa fa-arrow-right on-right on-left"></i> OPER</th>
		                            <th align="left"><i class="fa fa-arrow-left on-left"></i>RETURN / RE-CHECK</th>
		                        </tr>
	                        </thead>
	                        <tbody></tbody>
	                    </table>
				    </div>
				    
				    <div class="span12" style="margin-top: 10px;">
				        <div id="resource_parent" class="input-control textarea">
				            <label class="span4">NCB Comment</label>
				            <textarea id="ncb_comment"  name="ncb_comment" rows="3" class="span4"></textarea>
				        </div>				        
				   	</div>
				   	
				   	<div class="span12">   
				        <div id="parent_rmprocess" class="input-control select">
				            <label id="label_rmprocess" class="span4">RM Process</label>				           
				            <select id="rmprocess" name="rmprocess" class="span4" style="min-width: 180px; height: 34px;">
				                <option value="">-- โปรดเลือก --</option>
				                <optgroup label="On Process">
					                <option value="ระหว่างติดตามเอกสาร">ระหว่างติดตามเอกสาร</option>
					                <option value="ระหว่างคีย์เอกสารการเงิน">ระหว่างคีย์เอกสารการเงิน</option>
					                <option value="ระหว่างคำนวน DSCR">ระหว่างคำนวน DSCR</option>
					                <option value="ระหว่างคีย์ Call Report">ระหว่างคีย์ Call Report</option>
					                <option value="ระหว่างคีย์ BPM">ระหว่างคีย์ BPM</option>
					                <option value="Completed">Completed</option>
				                </optgroup>
				                <optgroup label="Cancel Before Process">
					                <option value="CANCELBYRM">ยกเลิก โดย RM</option>
	                				<option value="CANCELBYCUS">ยกเลิก โดย ลูกค้า</option>
	                				<option value="CANCELBYCA">ยกเลิก โดย CA</option>
				                </optgroup>
				            </select>
				            <div id="ClndrRMPD" class="input-control text span1 size2 marginRight5" style="margin-left: 5px; max-width: 115px;">
			                    <input id="rmprocessdate"  name="rmprocessdate" type="text" value="" disabled="disabled">
				            </div>	
				            				           
				            <div class="toolbar fg-black nonprint" class="place-left">				            	
				            	<span id="RmProcessReasonLogs" class="tooltip-top show-pop-list" data-tooltip="Cancel Reason History (Before & After Process)" data-placement="right">
				            		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
				            	</span>		    
				            </div>  
				        </div>
			    	</div>
			    	
			    	<div id="root_plan_a2ca" class="span12">
		    			<label id="label_plan_a2ca" class="span4">A2CA Plan Date</label>
		    		 	<div class="input-control text span4" style="margin-left: 20px;">			             
			            	<input id="plan_a2ca" name="plan_a2ca" type="text" value="" readonly="readonly">			            	
			         	</div>
			         	<span class="label nonprint">DIFF : 0 Day</span>						
		            	<span id="PlanA2CAReasonLogs" class="tooltip-top show-pop-list nonprint" data-tooltip="Plan A2CA History" data-placement="right">
		            		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
		            	</span>	
			    	</div>
			    	
			    	<div class="span12">
				    	<div class="span4" style="margin-right: 20px;">
				    		<label class="span4">
				    			Re-Activation
				    			<span id="loadActivateList" class="nonprint" style="padding-left: 0.1em; font-size: 1em;"><i class="fa fa-question-circle fg-lightBlue" data-hint="Re-Activation|การนำเคสที่ยังไม่เข้าระบบกลับมาทำใหม่" data-hint-position="top"></i></span>
				    		</label>
				        </div>
				        
				        <div id="objreactivate" class="input-control select span4">
				            <select id="reactivate" name="reactivate"></select>
				     	</div>
				     	
				     	<div class="input-control text span2" class="input-control text span2" style="max-width: 115px; margin-left: 5px;">
				     		<input id="reactivate_plan" name="reactivate_plan" type="text" value="" readonly="readonly" style="background-color: #EBEBE4;">				     	
				     	</div>
				    
				   		<div class="toolbar fg-black nonprint" class="place-left">			
			            	<span id="ReActivatedReasonLogs" class="tooltip-top show-pop-list" data-tooltip="Re-Activated Reason History" data-placement="right" style="margin-top: 0px; margin-left: 10px;">
			            		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
			            	</span>			            		       
			            </div>					        
				   </div>
				   
				   <div class="span12">
				   		<label class="span4">Action Note</label>
				   		<div id="resource_parent" class="input-control textarea span4 marginLeft20">
				            <textarea id="actionnote"  name="actionnote" rows="6" class="span4"></textarea>					          
				            <button id="ActionOnCancel" class="nonprint" type="button" style="position: absolute; margin-left: 5px; margin-top: 0.1em; font-size: 1em;">
				            	<i class="icon-remove on-left" class="tooltip-top" data-tooltip="Clear field for enter new contents."> CLEAR </i>
				            </button>		
				        </div>
				   </div>
				   
				   <div class="span12">
		                <div class="input-control">
		                   <label class="span4">Defend</label>
		                   <div id="defend_enable" class="input-control checkbox marginLeft20" style="float: left;">		                   	
		                    	<label>
 									<input id="defend_creation" name="defend_creation" type="checkbox" value="Y"> 									
	            		    		<span class="check"></span>
	            		    	</label>
		                   </div>                
		                   <div id="parent_defend_date" class="input-control text span4" style="max-width: 275px;">
		                   		<input id="defend_date" name="defend_date" type="text" value="" disabled="disabled">
		                   </div>		
		                   <span class="toolbar fg-black" style="position: absolute; margin-top: 9px; margin-left: 5px; min-width: 300px;">
		                   		<i id="defend_icon_remove" class="icon-remove on-right nonprint hide" style="font-size: 1.5em; cursor: pointer;" data-hint-position="top" data-hint="Defend Clear|ในกรณีหัวข้อที่เลือกไม่ตรงตามความต้องการ กดคลิกเพื่อล้างรายการเดิม (เฉพาะการสร้างข้อมูลครั้งแรกเท่านั้น)"></i> 
		                   		<i id="defend_icon_history" class="icon-history on-right nonprint" style="font-size: 1.5em; cursor: pointer;" data-hint-position="top" data-hint="Defend List|ดูประวัติรายการหัวข้อของปัญหาต่างๆ ที่เลือก เพื่อชี้แจ้งประเด็นปัญหาต่างที่เกิดขึ้นภายในเคส"></i>
		                   </span>             					           
		                </div>
		            </div>
		            
		           <div class="span12">    
                    	<label class="span4">
                    		Retrieve
                    		<span class="nonprint" style="padding-left: 0.1em; font-size: 1em;">
                    			<i class="fa fa-question-circle fg-lightBlue" data-hint="Retrieve|การนำเคสกลับมาทำใหม่ โดยเคสที่จะนำกลับมาทำใหม่จะต้องเป็นเคสที่เข้าระบบและมีผลพิจารณาเป็น Cancel หรือ Reject เป็นต้น" data-hint-position="top"></i>
                    		</span>
                    	</label>                      	  
                    	<div class="input-control select span4" style="min-height: 34px;">                           		   		
                    		<select id="retrieve_reason" name="retrieve_reason" class="marginLeft20" style="height: 34px; min-height: 34px;">
                    			<option value=""></option>
                    		
                    		</select>                    		
                    	</div>    
                    	<div class="input-control text" style="max-width: 115px; margin-left: 25px;">
				            <input id="retrieveDate" name="retrieveDate" type="hidden" value="">
				            <input id="objRetrieveDate" type="text" value="" disabled="disabled">
				        </div>        
				        <span class="toolbar fg-black nonprint" class="place-left" style="position: absolute; margin-left: 5px;">
				        	<span id="retrieve_tooltip" class="tooltip-top show-pop-list" data-tooltip="Retrieve Reason History" data-placement="top">
				        		<i class="icon-history fg-gray btnDefend padding3 no-margin-top" style="font-size: 1.5em; margin-top: 0px;"></i>
				        	</span>				    
				        </span>     	
                   </div>
                   
				   <header class="span12 marginLeft0" style="width: 1130px !important;">
				    	<span class="label label_info">Document Flow</span>
				   </header>	        	
		           <section class="form_container span12 marginLeft0" style="margin-top: -10px; margin-bottom: 10px;">
	                    <table id="expense_table_relation" style="width: 1130px !important;">
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
	                        <tbody></tbody>
	                    </table>
	               </section>
							
				</section>
				
			</article>
			
		</div>
	</div>

</div>
