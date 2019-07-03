<style>

	table th, td { font-size: 0.9em !important; }
	table th { 
		color: #FFF;
		background: #4390DF;
	}
	
	table tbody tr:hover { color: red !important; }
	table#grid_container th { vertical-align: middle; }
	
	table#grid_container td:nth-child(1) { text-align: center; }
    table#grid_container td:nth-child(2) { text-align: center; }
    table#grid_container td:nth-child(3) { text-align: center; }
    
    ::-webkit-scrollbar {
	    width: 0px;
	    background: transparent; 
	}
    
    table#grid_container td:nth-child(4) { position: relative; text-align: left; }    
    table#grid_container td:nth-child(4) div {
    	width: 118px;
        max-width: 118px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    
    table#grid_container td:nth-child(5) { text-align: right; }
    table#grid_container td:nth-child(6) { text-align: center;  }
    table#grid_container td:nth-child(7) { text-align: right; }
    table#grid_container td:nth-child(8) { text-align: center; }
    table#grid_container td:nth-child(9) { text-align: right; }
    table#grid_container td:nth-child(10) { text-align: center; }
    table#grid_container td:nth-child(11) { text-align: center; }
    table#grid_container td:nth-child(12) { text-align: center; }
    table#grid_container td:nth-child(13) { text-align: center; }
    table#grid_container td:nth-child(14) { text-align: left; position: relative; }
    
    table#grid_container td:nth-child(14) div:nth-child(2) { 
   		width: 114px;
        max-width: 118px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
   
    table#grid_container td:nth-child(15) { text-align: center; }
    table#grid_container td:nth-child(16) { text-align: left; }
    table#grid_container td:nth-child(17) { text-align: left; }
    table#grid_container td:nth-child(18) { text-align: center; }
    
    table#collection_history td:nth-child(1) { text-align: center; }
    table#collection_history td:nth-child(2) { text-align: left; }
    table#collection_history td:nth-child(3) { text-align: left; }
    table#collection_history td:nth-child(4) { text-align: left; }
    table#collection_history td:nth-child(5) { text-align: left; }
    table#collection_history td:nth-child(6) { text-align: center;  }
    table#collection_history td:nth-child(7) { text-align: right; }
    table#collection_history td:nth-child(8) { text-align: center; }
    table#collection_history td:nth-child(9) { text-align: right; }
    table#collection_history td:nth-child(10) { text-align: left; }
	
	th[class*="sort"]:after { content: "" !important; }
	
	.ms-drop ul > li label:not(.optgroup) input[data-group^='group'] {
	    margin-left: 15px !important;
	}
	
	#ui_notifIt { margin-top: 30px; }
	#ui_notifIt > p { color: #FFF !important; }
	.table_icon {
		cursor: pointer;
		font-size: 1.2em;
	}
	
	.dataTables_wrapper .dataTables_length select {  height: 4% !important;  }
		
	.noMargin { padding: 0px !important; }
	.metro .input-control.select textarea, .metro .input-control.textarea textarea { min-height: 34px; }
	.metro .input-control.select select { min-height: 34px; }

	.label { padding: 4px 2px !important; }
	.label.lclear { background-color: #FFF !important; }	
	.panel-header { padding: 4px; margin: 2px; }
	.bgmod { background-color: #e8e8e8 !important; }
	
	.number_length {
		position: absolute; 
		float: left; 
		margin-top: 40px; 
		font-size: 0.9em;
	}
	
	/* .modal-fullscreen size: we use Bootstrap media query breakpoints */	
	.modal-content {
	   margin: 0;
	   margin-right: auto;
	   margin-left: auto;
	   width: 100%;
	}
	
	@media (min-width: 768px) {
	  .modal-fullscreen .modal-dialog {
	     width: 95%;
	     /*width: 750px;*/
	  }
	}
	
	@media (min-width: 992px) {
	  .modal-fullscreen .modal-dialog {
	     width: 95%;
	     /*width: 970px;*/
	  }
	}
	@media (min-width: 1200px) {
	  .modal-fullscreen .modal-dialog {
	    width: 95%;
	  	/*width: 1170px;*/
	  }
	}
	
	.label-bgclear { background: #FFF !important; }
	.dataBorder {
		cursor: pointer;
		padding: 0 5px;
		border: 1px dotted red;
		background: #c2c2c2;
	}	
	
	.triangle-up-right {
	    width: 0;
	    height: 0;
	    border-top: 10px solid rgba(39,38,38,.78);
	    border-left: 10px solid transparent;
	    top: 0;
	    right: 0;
	    position: absolute;
	}
	
	

</style>

<style type="text/css" media="print">	
 	
	.nonprint { display: none; }
	.btn { 
		display: none !important;
		height: auto;
		min-height: 100%;
		overflow-y: hidden;
		margin-top: -20px;
	}
			
	.note-toolbar { display: none !important; }
	
	@media print {
	
		body { font-size: 12px; }
		.print_margin { 
			text-align: left;
			margin-left: -5px !important; 
		}
		
		#grid_container_length, .dataTables_paginate, .number_length { display: none; }

		.navigation-bar .navigation-bar-content .element-divider, .metro .navbar .navigation-bar-content .element-divider, .link_jumper, .navigation-bar img,
		.metro .navigation-bar .navbar-content .element-divider, .metro .navbar .navbar-content .element-divider { display: none !important; }
		
	}			
		
</style>	

<div class="InProgress animated fadeIn" style="position: absolute; margin-top: 25%; margin-left: 45%;  z-index: 2147483647;"><img src="<?php echo base_url('img/378_1.gif'); ?>"></div>
<div class="InProgress" style="position: absolute; background: #000; opacity: 0.2; width: 100%; height: 1400px; margin-top: -100px; z-index: 2147483647;"></div>

<div ng-controller="collection_ctrl" class="grid" style="padding: 2px;">
	<div class="row">	
	
		<header class="text-center nonprint">
			<h2>COLLECTION DASHBOARD</h2>
		</header>

		<div id="panel_criteria" class="panel nonprint marginTop10" data-role="panel" style="width: 47%; float: right; margin-bottom: 5px;">
			<div class="panel-header bg-lightBlue fg-white" style="font-size: 1.1em; font-weight: 500;"><i class="fa fa-search"></i> FILTER CRITERIA</div>
			<div class="panel-content" style="display: none; padding-bottom: 10px;">
			
				<div class="row" style="padding-left: 4%;">
					<div class="span6 bgmod" style="max-width: 440px;">  
	
					    <div class="input-control select span2"> 
		             		<label class="label bgmod">FILTER TYPE</label>              	
		             		<select id="filterType" name="filterType">
		             			<option value=""></option>
		             			<option value="Date">Date</option>
		             			<option value="Amount">Amount</option>
		             		</select>		             	             		
		             	</div>  
		          	      	
		             	 <div class="input-control select span2" style="margin-left: 10px;"> 
		             		<label class="label bgmod">FILTER FIELD</label> 
		             		<select id="filterField" name="filterField" class="size2">
		             			<option value=""></option>
		             			<option value="lstContact">Contact Date</option>
		             			<option value="Npdt">Due Date</option>
		             			<option value="Lpdt">Last Payment</option>
		             		</select>
			      		</div>
		      		
		      			<div class="input-control text span2 bgmod" style="margin-left: 10px;"> 
	         				<label class="label bgmod">FILTER RANGE</label> 
	         				<div id="Parent_filterRange" class="input-control text">
	         					<input id="filterRange" name="filterRange" type="text" value="" class="size2">    
	         				</div>         				     		
	         			</div>  
	         		   
	             	</div> 
	             	
	             	<div class="input-control span2" style="margin-left: 10px;"> 
	             		<label class="label label-bgclear span2">ACC. NO / ID CARD</label>        
	             		<div class="input-control text">      		
	             			<input id="cust_code" name="cust_code" type="text" value="" ng-model="txtIdentity" onkeypress="priceValidate(event)" class="size2"> 
	             		</div>
	             	</div> 

             	</div>	      
             	 
             	<div class="row" style="padding-left: 4%; margin-top: 20px;">             	
             		<?php  	             		
	            	    if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
	            	       in_array('074006', $session_data['auth']) || in_array('074007', $session_data['auth']) || in_array('074008', $session_data['auth'])) {
	            	        $region_disable = '';
	            	    } else {
	            	    	$region_disable = 'disabled="disabled"';
	            	    }
            		?>   
             		<div class="input-control select span2"> 
		     			<label class="label label-bgclear">REGION</label> 
		     			<select id="region" name="region" class="size2" style="height: 34px;" <?php echo $region_disable; ?>></select> 
			     	</div> 	

			     	<?php 
			     		
		     		if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
		     		   in_array('074004', $session_data['auth']) ||
		     		   in_array('074005', $session_data['auth']) ||
		     		   in_array('074006', $session_data['auth']) ||
		     		   in_array('074007', $session_data['auth']) ||
		     		   in_array('074008', $session_data['auth'])) {
		     		
		     		?>
			     	<div class="input-control select span2" style="margin-left: 10px;"> 
		       			<label class="label label-bgclear">LENDING BRANCH</label> 
		       			<select id="branch" name="branch" multiple="multiple" class="size2" style="height: 34px;"></select> 
					</div> 	
	       			<?php } ?> 
	       					            	
	    			<div class="input-control select span2" style="margin-left: 10px;"> 
	        			<label class="label label-bgclear">EMP. NAME</label> 
	        			<select id="emplist" name="emplist" multiple="multiple" class="size2" style="height: 34px;"></select>
	    			</div>	
	    		
	    			<div class="input-control text span2" style="margin-left: 10px;"> 
	             		<label class="label label-bgclear">CUST. NAME</label> 
	             		<input id="custname" name="custname" type="text" value="" ng-model="txtCustName" class="size2"> 
	             	</div>
	                	
             	</div>     
	
				<div style="margin-bottom: 80px; padding: 0 4%;">
				
					<div class="row place-left" style="position: absolute; margin-top: 0px;">	
						<div class="input-control select size2 text-left">
				            <label class="label label-bgclear">SOURCE OF CUST.</label>
				            <select id="sourceofcustomer" name="sourceofcustomer" multiple="multiple">
				                <optgroup label="Core Source">
				                	<option value="Field visit">Field visit</option>
				                	<option value="Refer: RM">Refer by RM</option>
				                	<option value="Refer: Customer">Refer by Cust-Suplier</option>
				                </optgroup>
				                <optgroup label="Non-Core Source">
				                	 <option value="Call in">Call in</option>
					                <option value="Walk in">Walk in</option>
					                <option value="Direct mail">Direct mail</option>
					                <option value="Telelist">Telelist</option>
					                <option value="Refer: Thai Life">Refer by Thai Life</option>
					                <option value="Refer: Full Branch">Refer by Full Branch</option>
					                <option value="Refer: Call Center">Refer by Call Center</option>
					                <option value="Tcrb: Facebook">Refer by TCRB FB</option>
				                </optgroup>
				            </select>
			        	</div>					
	    				<div class="input-control select size2">
	    					<label class="label label-bgclear">FILTER GROUP :</label>
	    					<select id="action_status" name="action_status" multiple="multiple" class="size2">
	    						<optgroup label="Bucket DPD">
		    						<option value="X">X Day</option>
		    						<option value="31_60">30+ DPD</option>
		    						<option value="61_90">60+ DPD</option>	    						
		    						<option value="90+DPD">NPL</option>
	    						</optgroup>
		    					<optgroup label="Acc. Status">
		    						<option value="TDR">TDR</option>
		    						<option value="RR2">Relief</option>
	    						</optgroup>
	    					</select>
	    				</div>
	    				
	    				<div class="input-control checkbox size2 tooltip-top" data-tooltip="รายการที่ทาง collection ขอความร่วมมือจาก RM" style="min-width: 80px; margin-left: 5px;">
	    					<label class="label label-bgclear">
	    						<input id="list_flag" name="list_flag" type="checkbox" value="Y">
	    						<span class="check"></span> FLAG (RM Help!)
	    					</label>
	    				</div>
	    				
					</div>						
								
					<div class="place-right marginTop20">
			    		<button class="fg-white" style="padding: 7px; background: #4390DF;" ng-click="reloadGrid()"><i class="fa fa-search on-left"></i> SEARCH </button> 	  
		    	    	<button type="button" id="filterClear" class="bg-green fg-white" style="height: 33px;">CLEAR</button>  	
		    		</div>
				</div>
			
		    		
			</div>
		</div>
		
		<div class="number_length"></div>

		<div class="element_fieldhide">
			<input id="emp_id" name="emp_id" type="hidden" value="<?php echo !empty($session_data['emp_id']) ? $session_data['emp_id']:''; ?>">
			<input id="emp_name" name="emp_name" type="hidden" value="<?php echo !empty($session_data['thname']) ? $session_data['thname']:''; ?>">
			<input id="finalnet" name="finalnet" type="hidden" value="<?php echo !empty($os_balance['FinalNetActual']) ? $os_balance['FinalNetActual']:''; ?>">
		</div>
		
		<nav class="read_tool nonprint" style="margin-top: -3px;">
			<ul class="clearfix">
				<li class="collaspe"><a href="#" class="btn"><i class="icon-book" style="font-size: 1.4em;"></i></span></a>	
					<ul>
						<li>
							<a href="<?php echo base_url('PCIS Handbook/PCIS Collection.pdf'); ?>" target="_blank">
								<i class="icon-book" style="font-size: 1.4em;"></i>
							</a>
						</li>
						<li>
							<a href="#">								
								<span class="fa-stack fa-lg">
								  <i class="fa fa-video-camera" aria-hidden="true"></i>
								  <i class="fa fa-ban fa-stack-2x text-danger" style="color: #fd6252;"></i>
								</span>
							</a>
						</li>
					</ul>	
				</li>	
			</ul>
		</nav>	
		
		<section class="nonprint" style="float: right; margin-top: 25px; margin-right: 0px;">	

			<span data-role="input-control" ng-click="btnReload()" style="margin-right: 10px;" data-hint="Refresh Page" data-hint-position="top" width="3%">
				<a id="refresh_pages" href="#" class="fg-lightBlue"><i class="fa fa-refresh on-left"></i> 
				<span>REFRESH</span></a>
			</span>
		        
		</section>
	
		<!-- <table-collection ng-model="DataList" table-options="tableOpt"> -->
			<table id="grid_container" class="table bordered hovered">
				<thead>
					<tr>
						<th width="7%" rowspan="2">DUE DATE</th>	
						<th width="2%" rowspan="2"><i class="fa fa-bullhorn"></i></th>
						<th width="2%" rowspan="2">PG</th>			
						<th width="10%" rowspan="2">CUSTOMER</th>
						<th width="6%" rowspan="2">O/S</th>	
					
						<th width="12%" colspan="2">LAST PAYMENT</th>
						<th width="9%" colspan="2">OVERDUE (OD)</th>	
						
						<th width="7%" rowspan="2">OD / PAID <br/> TERM (Mth)</th>
						<th width="9%" colspan="2">PROMISE TO PAY</th>			
						
						<th width="5%" rowspan="2">LB</th>
						<th width="11%" rowspan="2">RM</th>						
						<th width="23%" colspan="3">FOLLOW UP ( Latest )</th>						
						<th class="nonprint" width="1%" rowspan="2">LINK</th>
															
					</tr>
					<tr>	
						<th width="5%">DATE</th>		
						<th width="6%">AMT.</th>
						<th width="2%">DAY</th>					
						<th width="6%">AMT.</th>
						<th width="5%">DATE</th>
						<th width="2%"><i class="fa fa-flag-o"></i></th>
						<th width="5%">CONTACT</th>
						<th width="10%">ACTION</th>
						<th width="8%">RE-ACTION</th>						
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in DataList | orderBy: ['-_Npdt']" on-last-repeat="bindData">
						<td>{{item._Npdt}}</td>
						<td>{{item.SourceChannel}}</td>
						<td>{{item.Prodtype}}</td>
						<td>
							<div title="{{ item.Custname + ' (' + item.BranchName + ')' }}">{{ item.Custname || '&nbsp;' }}</div>							
						</td>
						<td>{{item.CBal | number:0 }}</td>
						<td>{{item._Lpdt | date:"dd/MM/yyyy" }}</td>
						<td>{{item.lspamt | number:0 }}</td>
						<td>{{item.DPD}}</td>
						<td>{{item.odv | number:0 }}</td>
						<td>{{item.payacc}}</td>
						<td>{{item.lst_ptpdt | date:"dd/MM/yyyy"}}</td>
						<td>{{item.pdp_timing}}</td>
						<td><div class="tooltip-right" data-tooltip="{{item.BranchName}}">{{item.BranchDigit}}</div></td>
						<td> 
							<div ng-show="{{item.offcr_name_orgin !== ''}}" class="triangle-up-right tooltip-right" data-tooltip="โอนย้ายข้อมูลจาก {{item.offcr_name_orgin}}"></div>
							<div ng-class="{'fg-cobalt' : item.is_flag}" title="{{item.offcr_name}}">
								{{item.offcr_name || '&nbsp;' }}
							</div>						
						</td>
						<td><div ng-class="{'dataBorder' : item.rm_log}">{{item._lst_contact | date:"dd/MM/yyyy" }}</div></td>
						<td>{{item.lst_actn}}</td>
						<td>{{item.lst_reactn}}</td>
						<td class="nonprint">
							<i ng-click="enabled_model(item)" class="ti-id-badge table_icon"></i>
						</td>
					</tr>
				</tbody>
				<tfoot class="nonprint">
					<tr>
						<td colspan="2" style="text-align: left !important;">TOTAL <span id="collection_footer_total"></span> :</td>					
						<td colspan="3" style="text-align: right !important;"></td>
						<td></td>
						<td style="text-align: right !important;"></td>
						<td></td>
						<td style="text-align: right !important;"></td>
						<td colspan="9"></td>
					</tr>
				</tfoot>
				
			</table>
		<!-- </table-collection> -->

		<div class="container nonprint" style="margin-top: 30px; margin-left: -1px;">
			<?php echo $footer; ?>
		</div>

	</div>
</div>

<script type="text/ng-template" id="modalCollection.html">
      <div class="modal-header">
        <button type="button" class="close fg-red" data-dismiss="modal" ng-click="dismiss_modal()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Collection Daily Monitoring</h4>
      </div>
      <div class="modal-body">
      	 <div class="container">
      	 <div class="grid">
      	 
      	 	<!-- overflow-y: scroll; -->      	 	
      	 	<div id="basic_information" class="row" style="margin-top: -10px;">
      	 		<div class="animated fadeIn print_margin"> 
		 			<header class="panel-header item-title-secondary bg-lightBlue fg-white">Basic Information</header> 
  	 				<div class="span7"> 
  	 					<label class="label span3">Customer ID</label> 
  	 					<div class="span4">{{modalItemSelect.Custid || '&nbsp;'}}</div> 
  	 				</div> 
  	 				<div class="span7"> 
  	 					<label class="label span3">LB Name</label> 
  	 					<div class="span4">{{modalItemSelect.Brnname || '&nbsp;'}}</div> 
  	 				</div> 
  	 				<div class="span7"> 
  	 					<label class="label span3">Name-Surname</label> 
  	 					<div class="span4">{{modalItemSelect.Custname || '&nbsp;'}}</div> 
  	 				</div> 
  	 				<div class="span7"> 
  	 					<label class="label span3">RM (Current)</label> 
  	 					<div class="span4">{{ modalItemSelect.offcr_name || '&nbsp;'}} ({{modalItemSelect.office_mobile || '&nbsp;'}})</div>
  	 				</div> 
  	 				<div class="span7"> 
  	 					<label class="label span3">Phone 1</label> 
  	 					<div class="span4">{{modalItemSelect.Wkphone || '&nbsp;'}}</div>  
  	 				</div> 
  	 				<div class="span7"> 
  	 					<label class="label span3">RM (Original)</label> 
  	 					<div class="span4">{{modalItemSelect.or_offcname || '&nbsp;'}} {{modalItemSelect.or_office_mobile || '&nbsp;'}}</div> 
  	 				</div>   	 	
  	 				<div class="span7"> 
  	 					<label class="label span3">Phone 2</label> 
  	 					<div class="span4">{{modalItemSelect.Hmphone || '&nbsp;'}}</div> 
  	 				</div> 
  	 				<div class="span7"> 
  	 					<label class="label span3">Collector</label> 
  	 					<div class="span4">{{modalItemSelect.ColName || '&nbsp;'}} ( <span class="tooltip-top" data-tooltip="ต่อ: คุณทัศนียา" style="text-decoration: underline;">1956</span> / <span class="tooltip-top" data-tooltip="ต่อ: คุณสุดใจ" style="text-decoration: underline;">1945</span> )</div>
  	 				</div> 	  	 		
  	 				<div class="span7"> 
  	 					<label class="label span3">Product Type</label> 
  	 					<div class="span4">{{modalItemSelect.Prodtype || '&nbsp;'}}</div> 
  	 				</div> 
  	 				<div class="span7"><label class="span2"></label><span class="span4"></span></div> 	  	 			
	  	 		</div>
      	 	</div>   
	  	 	
      	 	<div id="payment_information" class="row">				
      	 		<div class="animated fadeIn print_margin"> 	      	 		
       	 			<header class="panel-header item-title-secondary bg-lightBlue fg-white print_margin">Payment Information</header>      
      	 			<article class="span7"> 
      	 				<header class="label lclear item-title-secondary">Loan Inquiry</header> 	
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">Decisions Date</label> 
	      	 				<div class="span3">{{modalItemSelect.StatusDate | date:"dd/MM/yyyy" || '&nbsp;' }}&nbsp;</div> 
	      	 			</section> 
						<section class="sapn12"> 
	      	 				<label class="label span3">Draw Down (Date)</label> 
	      	 				<div class="span3">{{modalItemSelect.Reldat | date:"dd/MM/yyyy" || '&nbsp;' }}&nbsp;</div> 
	      	 			</section> 
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">Draw Down (Amt.)</label> 
	      	 				<div class="span3">{{modalItemSelect.Relamt || '&nbsp;'}}</div> 
	      	 			</section> 
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">Installment (Month/Baht) / Term</label> 
	      	 				<div class="span3">{{modalItemSelect.Pmtamt || '&nbsp;'}} / {{modalItemSelect.Term || '&nbsp;'}} Month</div> 
	      	 			</section> 	      	 		
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">Due Date</label> 
	      	 				<div class="span3">{{modalItemSelect.Npdt | date:"dd/MM/yyyy" || '&nbsp;'}}</div> 
	      	 			</section> 
						<section class="sapn12"> 
	      	 				<label class="label span3">SB O/S (Baht)</label> 
	      	 				<div class="span3" style="color: red;">{{ modalItemSelect.Cbal | number: 0 || '&nbsp;'}}</div> 
	      	 			</section>    
	      	 			<section class="sapn12">
	      	 				<label class="label span3">Product Hold <span id="prdHold_hint" ng-mouseover="promPrdDetail('prdHold_hint');" style="position: absolute; float: right; margin-left: 10px;" data-placement="top-right"><i class="fa fa-info-circle fg-lightBlue"></i></span></label> 
	      	 				<div class="span3">{{modalItemSelect.alltype || '&nbsp;'}}</div> 
	      	 			</section> 
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">CIF (Total bank loan.)</label> 
	      	 				<div class="span3">{{modalItemSelect.totcbal || '&nbsp;'}}</div> 
	      	 			</section>   
						 	 	
	      	 		</article> 	      	 	

	      	 		<article class="span7"> 
	      	 			<header class="label lclear item-title-secondary">Loan Behaviors</header> 
						<section class="sapn12"> 
	      	 				<label class="label span3">Acc. Status</label> 
	      	 				<div class="span3" style="text-decoration: underline;">
								<span class="tooltip-top" data-tooltip="{{ translationAcctState(modalItemSelect.AccSts) }}">{{modalItemSelect.AccSts || '&nbsp;'}}</span>
							</div> 
	      	 			</section> 
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">Bucket DPD</label> 
	      	 				<div class="span3">{{modalItemSelect.Bucket || '&nbsp;'}}</div> 
	      	 			</section>	      	 
						<section class="sapn12"> 
	      	 				<label class="label span3">Day Overdue</label> 
	      	 				<div class="span3 fg-red">{{modalItemSelect.DPD || '&nbsp;'}} Days</div> 
	      	 			</section> 	 		
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">Month Overdue/Month Paid</label> 
	      	 				<div class="span3">{{modalItemSelect.AccPmtNo || '&nbsp;'}}/{{modalItemSelect.Paymno || '&nbsp;'}}</div> 
	      	 			</section> 
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">Amt. Overdue (Baht)</label> 
	      	 				<div class="span3 fg-red">{{modalItemSelect.TotPmtamt | number: 0 || '&nbsp;'}}</div> 
	      	 			</section> 	      	 			
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">Last Payment Amt.</label> 
	      	 				<div  class="span3">{{modalItemSelect.lspamt | number: 0 || '&nbsp;'}}</div> 
	      	 			</section>     	 			
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">Last Payment</label> 
	      	 				<div class="span3">{{modalItemSelect.Lpdt | date:"dd/MM/yyyy" || '&nbsp;'}}&nbsp;</div> 
	      	 			</section> 
	      	 			<section class="sapn12"> 
	      	 				<label class="label span3">Promise to pay (PTP)</label> 
	      	 				<div class="span3">{{modalItemSelect.lst_ptpdt | date:"dd/MM/yyyy" || '&nbsp;'}}</div> 
	      	 			</section> 
	      	 		</article> 	      	 		
	      	
	      	 	</div>
			</div>
      	 	
      	 	<div class="row">
      	 		<div class="animated fadeIn nonprint">
      	 		<header class="label item-title-secondary" style="background-color: #FFF;">Customer Tracking</header>   
	      	 		<table id="customer_tracker" class="table bordered">
	      	 			<thead>
	      	 				<tr>
	      	 					<th colspan="2" width="18%">Contactor</th>
	      	 					<th colspan="3" width="36%">Follow Up</th>
	      	 					<th colspan="2">Promise To Pay</th>
	      	 					<th rowspan="2" width="19%">Note</th>
	      	 					<th rowspan="2" width="1%"><i class="fa fa-plus-circle fg-lightGreen" style="cursor: pointer; font-size: 1.6em;" ng-click="addTableRecord(this)"></i></th>
	      	 				</tr>
	      	 				<tr>	
	      	 					<th width="8%">Date</th>      	 			
	      	 					<th width="11%">Name</th> 
	      	 					<th width="11%">Action</th>
	      	 					<th width="11%">Re-Action</th>
	      	 					<th width="13%">Reason</th>	
	      	 					<th>Date</th>      	 			
	      	 					<th>Amt.</th>	      	 					      	 				
	      	 				</tr>
	      	 			</thead>
	      	 			<tbody>	      	 	
	      	 				<tr ng-repeat="item in addToCollection">
	      	 					<td><span ng-if="item._ContactDate != ''" compile-html="item._ContactDate"></span></td>
	      	 					<td><span ng-if="item.ContactName != ''" compile-html="item.ContactName"></span></td>
	      	 					<td><span ng-if="item.Action != ''" compile-html="item.Action"></span></td>
	      	 					<td><span ng-if="item.ReAction != ''" compile-html="item.ReAction"></span></td>
	      	 					<td><span ng-if="item.ActionReason != ''" compile-html="item.ActionReason"></span></td>
								<td><span ng-if="item._PTP_Date != ''" compile-html="item._PTP_Date"></span></td>
	      	 					<td><span ng-if="item.PTP_Amt != '0.00'" compile-html="item.PTP_Amt"></span></td>
								<td><span ng-if="item.Memo != ''" compile-html="item.Memo"></span></td>
								<td><span></span></td>
	      	 				</tr>
	      	 			</tbody>
	      	 		</table>	
      	 		</div> 
      	 		<div class="place-right clear"><button data-show="false" type="button" class="info hidden" ng-click="getDataListBundled();">Send</button></div>     	 		
      	 	</div>

      	 	<div class="row" style="z-index: 1;">
				<hr>
      	 		<div class="animated fadeIn nonprint">
      	 		<header class="label item-title-secondary" style="background-color: #FFF;">Customer Arrears History</header>      	 	
      	 		<table id="collection_history" class="table bordered striped">
      	 			<thead>
      	 				<tr>
      	 					<th colspan="2" width="17%">Contactor</th>
      	 					<th colspan="3" width="30%">Follow Up</th>
      	 					<th colspan="2" width="12%">PTP</th>
      	 					<th colspan="3" width="14%">PTP Result</th>      	 				
      	 					<th rowspan="2" width="20%">Note (Memo)</th>
      	 				</tr> 
      	 				<tr>
      	 					<th width="8%">Date</th>
      	 					<th width="9%">Name</th>
      	 					<th width="12%">Action</th>
      	 					<th width="11%">Re-Action</th>
      	 					<th width="9%">Reason</th>
      	 					<th width="5%">Date</th>
      	 					<th width="7%">Amt.</th>
      	 					<th width="2%" align="center">ST</th>
							<th width="5%">Date</th>
      	 					<th width="7%">Amt.</th>
      	 				</tr>
      	 			</thead>
      	 			<tbody>
      	 				<tr ng-repeat="item in collection_history | orderBy: 'Seq'">
							<td><span ng-if="item.lstContact != ''">{{ item.lstContact | date:"dd/MM/yyyy" || '&nbsp;'}}</span></td>
	      	 				<td><span>{{ item.Collector_Name }}</span></td>
	      	 				<td><span ng-if="item.lstActn != ''">{{item.lstActn || '&nbsp;'}}</td>
	      	 				<td><span ng-if="item.lstReactn != ''">{{item.lstReactn || '&nbsp;'}}</span></td>
	      	 				<td><span ng-if="item.lstReason != ''">{{item.lstReason || '&nbsp;'}}</span></td>
							<td><span ng-if="item.lstPtpdt != ''">{{item.lstPtpdt.substring(0, 10) | date:"dd/MM/yyyy" || '&nbsp;'}}</span></td>
	      	 				<td><span ng-if="item.lstPtpamt != '0'">{{item.lstPtpamt | number:2 || '&nbsp;'}}</span></td>
							<td><span ng-if="item.lstPtpfg != ''">{{swicthStatus(item.lstBrkfg, item.lstPmtdte) || '&nbsp;'}}</span></td>
							<td><span ng-if="item.lstPmtdte != ''">{{item.lstPmtdte.substring(0, 10) | date:"dd/MM/yyyy" || '&nbsp;'}}</span></td>
							<td><span ng-if="item.lstPmtamt != '0'">{{item.lstPmtamt | number:2 || '&nbsp;'}}</span></td>
							<td><span ng-if="item.lstMmdes != ''">{{item.lstMmdes || '&nbsp;'}}</span></td>
						</tr>
      	 			</tbody>
      	 		</table>      	 
      	 		</div>
      	 	</div>
      	 	
      	 </div>
      	 </div>
      </div>
      <div class="modal-footer"></div>

	  <div id="parent_prdHoldDetail" style="display: none;">อยู่ระหว่างรวบรวมข้อมูล...</div>
</script>
<script type="text/javascript">

	function priceValidate(evt) {
	    var theEvent = evt || window.event;
	    var key = theEvent.keyCode || theEvent.which;
	    key = String.fromCharCode( key );
	    var regex = /[\d\-]/;
	    if( !regex.test(key) ) {
	        theEvent.returnValue = false;
	        if(theEvent.preventDefault) theEvent.preventDefault();
	    }
	}

	$('nav.read_tool .collaspe').on('click', function() {
		var el_target = $(this).find('ul')
		var getClass = el_target.attr('class');
		if(!getClass) {
			el_target.addClass('open');
		} else {
			el_target.removeClass('open');
		}
	});
    
</script>