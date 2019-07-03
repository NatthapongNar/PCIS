<style type="text/css">
	
	table tbody tr:hover { color: red !important; }
	table#tbl_reconsiledoc th, td { font-size: 12px; }	
	table#tbl_reconsiledoc tr td:first-child { text-align: left !important; display: none; }
	table#tbl_reconsiledoc tr td:nth-child(1) { text-align: left !important; }
	table#tbl_reconsiledoc tr td:nth-child(2) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(3) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(4) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(5) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(6) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(7) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(8) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(9) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(10) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(11) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(12) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(13) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(14) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(15) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(16) { text-align: center !important; }
	table#tbl_reconsiledoc tr td:nth-child(17) { text-align: left !important; }
	table#tbl_reconsiledoc tr td:nth-child(18) { text-align: left !important; }
	
	.errors { background-color: #F2DEDE !important; }
	.brands { background-color: #4390DF; color: #FFF; }
	/*.dataTables_length { display: none; }*/
	
	/* badge by boostrap 3.2.0 */
	.badge {
	  display: inline-block;
	  min-width: 10px;
	  padding: 3px 7px;
	  font-size: 12px;
	  font-weight: bold;
	  color: #ffffff;
	  line-height: 1;
	  vertical-align: baseline;
	  white-space: nowrap;
	  text-align: center;
	  background-color: #777777;
	  border-radius: 10px;
	}
	.badge:empty {
	  display: none;
	}
	
	.none-table {
		border-top: 0px;
		border-left: 0px;
		border-right: 0px;
		border-bottom: 0px;
	}
	
	#definded_status div, p { display: inline; }
	
	 .label-over { 
	 	display: inline-block;
	    padding: 3px 5px;
	    margin: 0;
	    font-size: 90%;
	    font-weight: normal !important;
	    line-height: 90%;
	    color: #555;
	    font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
     }
     
	 .label-clear { background-color: #FFF !important; }
	 input, select { 
		font-size: 0.9em;
		font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif;
	 }
	 
	 .metro .dropdown-toggle:after { visibility: hidden; }
	
	 @media screen and (-webkit-min-device-pixel-ratio:0) { 
		.cb-marginFixedChrome {
			margin-top: -1px !important;
		}
		
		.budgetFixed { 
			margin-left: 33px !important; 
			margin-top: -38px !important;
		}
		
		.budgetAmountFixed {
			margin-left: 45px !important; 
			margin-top: -47px !important;
		}
		
		.budgetWidth { min-width: 52px !important; }
		.budgetAmountClear {
			margin-left: -14px !important; 
			margin-top: -9px !important;
		}
		
	}
	
	.text-selectred { color: red; }
	
	/* PROGRESS ICON: MODIFY STYLE */
	div#tbl_reconsiledoc_processing {
	    background-color: transparent;
	    margin-top: 10px;
	    margin-left: -250px !important;
	    width: 500px;
	}
	.metro .dataTables_wrapper .dataTables_processing {  box-shadow: none !important; }
	
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
		
	.form_container table th { font-size: 1em !important; }	
	.form_container table tbody td { font-size: 1.2em !important; }	

</style>
</head>

<div id="contentation" style="margin-top: 70px;">

<input id="empprofile_identity" type="hidden" value="<?php echo $session_data["emp_id"]; ?>">
<header class="text-center">
	<h2><span id="objTextSpan"><?php echo (!empty($_GET['filter'])) ? switchTitle($_GET['filter']):'RECONCILE'; ?></span> DOCUMENT MANAGEMENT</h2>
	<div id="definded_status" class="row animated rubberBand">
	    <div><i class="fa fa-circle fg-yellow" style="font-size: 1.3em; cursor: pointer; margin-right: 5px;"></i></div> <p style="margin-left: 5px;">LB</p>
	    <div><i class="fa fa-circle" style="color: #1ba1e2; font-size: 1.3em; cursor: pointer; margin-left: 10px; margin-right: 5px;"></i></div> <p style="margin-left: 5px;">HQ</p>
	    <div><i class="fa fa-circle" style="color: #60a917; font-size: 1.3em; cursor: pointer; margin-left: 10px; margin-right: 5px;"></i></div> <p style="margin-left: 5px;">CA</p>
	    <div><i class="fa fa-circle fg-red" style="font-size: 1.3em; cursor: pointer;  margin-left: 10px;"></i></div> <p style="margin-left: 5px;">RETURN<p>
	</div>
</header>

<?php 

function switchTitle($label) {
	if(!empty($label)) {
		switch ($label) {
			case 'reconcile':
				return 'RECONCILE';
				break;
			case 'missingdoc':
				return 'MISSING';
				break;
			case 'returndoc':
				return 'RETURNDOC';
				break;
		}
	} else {
		return 'RECONCILE';
	}
	
}

?>

<div class="grid">
<div id="application" class="row">

	<div id="element_hidden">
	
		<input id="branchs_hidden" name="branchs_hidden" type="hidden" value="">
		<input id="rmname_hidden" name="rmname_hidden" type="hidden" value="">
		
		<input id="reconciledoc_start_hidden" name="reconciledoc_start_hidden" type="hidden" value="">
		<input id="reconciledoc_end_hidden" name="reconciledoc_end_hidden" type="hidden" value="">
		<input id="missing_start_hidden" name="missing_start_hidden" type="hidden" value="">
		<input id="missing_end_hidden" name="missing_end_hidden" type="hidden" value="">
		<input id="returndoc_start_hidden" name="returndoc_start_hidden" type="hidden" value="">
		<input id="returndoc_end_hidden" name="returndoc_end_hidden" type="hidden" value="">
		<input id="careturn_start_hidden" name="careturn_start_hidden" type="hidden" value="">
		<input id="careturn_end_hidden" name="careturn_end_hidden" type="hidden" value="">
		
	</div>
	
	<div id="panel_reconsiledoc" class="panel" data-role="panel" style="width: 70%; float: right; margin-bottom: 0px; padding-bottom: 13px; margin-right: 1.4%;">
		<div class="panel-header bg-lightBlue fg-white" style="font-size: 1.1em;"><i class="fa fa-search on-left"></i>FILTER CRITERIA</div>
		<div class="panel-content" style="display: none;">
				
			<div class="row" style="float: right; margin-right: 2%;">

				<span style="background-color: #D1D1D1; padding:  5px; border-radius: 5px;">		
			 	<div class="input-control radio" data-role="input-control">
			        <label>
			            <input type="radio" id="inlineCheckbox1" name="Activecheck" value="Active" checked="checked">
			            <span class="check"></span> 
			            <span class="label-over">ACTIVE</span>
			        </label>
			   	</div>
			   	<div class="input-control radio" data-role="input-control" style="margin-right: 5px;">
				        <label>
				            <input type="radio" id="inlineCheckbox2" name="Activecheck" value="InActive">
				            <span class="check"></span> 
				            <span class="label-over">INACTIVE</span>
				        </label>
	            </div>
				<div class="input-control radio" data-role="input-control" style="margin-right: 15px;">
			        <label>
			            <input type="radio" id="inlineCheckbox3" name="Activecheck" value="All"> 
			            <span class="check"></span> 
			            <span class="label-over">ALL</span>
			        </label>
			    </div>			
			    </span>
	
				<span style="margin-right: 10px;"></span>
				<span style="background-color: #D1D1D1; padding:  5px; border-radius: 5px;">
			   	<div class="input-control radio" data-role="input-control" style="margin-right: 5px;">
			        <label>
			            <input type="radio" id="objMode_1" name="inlineCheckbox" value="r2cx" <?php echo (!empty($_GET['filter']) && $_GET['filter'] == 'reconcile') ? 'checked':(empty($_GET['filter'])) ? 'checked':''; ?>>
			            <span class="check"></span> 
			            <span class="label-over">RECONCILE</span>
			        </label>
			     </div>
			     <div class="input-control radio" data-role="input-control">
			        <label>
			            <input type="radio" id="objMode_2" name="inlineCheckbox" value="m2cx" <?php echo (!empty($_GET['filter']) && $_GET['filter'] == 'missingdoc') ? 'checked':''; ?>> 
			            <span class="check"></span> 
			            <span class="label-over">MISSING</span>
			        </label>
			    </div>
			    <div class="input-control radio" data-role="input-control">
			        <label>
			            <input type="radio" id="objMode_3" name="inlineCheckbox" value="r2cl"  <?php echo (!empty($_GET['filter']) && $_GET['filter'] == 'returndoc') ? 'checked':''; ?>> 
			            <span class="check"></span> 
			            <span class="label-over">DOC. RETURN</span>
			        </label>
			    </div>
			    <div class="input-control radio" data-role="input-control">
			        <label>
			            <input type="radio" id="objMode_5" name="inlineCheckbox" value="d2cr"> 
			            <span class="check"></span>
			            <span class="label-over">CA RETURN</span>
			        </label>
			    </div>
			    <div class="input-control radio" data-role="input-control" style="margin-right: 5px;">
			        <label>
			            <input type="radio" id="objMode_4" name="inlineCheckbox" value="a2lx">
			            <span class="check"></span> 
			            <span class="label-over">All</span>
			        </label>
			   	</div>
			   	</span>
		   	
			</div>
			
			
			<div class="row" style="float: right; margin-right: 2%;">
			
			<div id="search_field" class="span3 marginRight5">
				<div class="input-control text span3" data-role="input-control" style="max-width: 210px; float: right;">
					<label class="label label-clear">RECONCILE DATE </label>
					<div class="input-control text">
					    <input id="reconcile_date" name="reconcile_date" type="text" value="">
					</div>
				</div>			
			</div>
			
			<?php
		    	
		    	if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' || 
		    	   in_array('074006', $session_data['auth']) && $session_data['branchcode'] == '000' ||
				   in_array('074007', $session_data['auth']) && $session_data['branchcode'] == '000' || 
				   in_array('074008', $session_data['auth'])) {
					echo '<div class="input-control select span2" data-role="input-control">
			                <label class="label label-clear">REGION</label>
			                	<select id="regions" name="regions" style="width: 130px; height: 34px;">
									<option value="" selected></option>';
		
										foreach($AreaRegion['data'] as $index => $values) {
											echo '<option value="'.$values['RegionID'].'">'.strtoupper($values['RegionNameEng']).'</option>';
										
										}
										
					echo	'</select>
						</div>';
				}

				if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' ||
				   in_array('074004', $session_data['auth']) || in_array('074005', $session_data['auth']) ||
 				   in_array('074006', $session_data['auth']) || in_array('074007', $session_data['auth']) ||
				   in_array('074008', $session_data['auth'])) {

					echo '<div id="parent_select_group" class="input-control select span2" style="margin-left: -5px; margin-right: 4px;">
    					  <div id="select_group" class="form-group">
		                  	<label class="label label-clear">BRANCH</label>
			              	<select id="branchs" name="branchs" multiple="multiple" style="width: 130px;  margin-right: 5px; height: 34px;" class="text-left">';
								
							foreach($AreaBoundary['data'] as $index => $values) { echo '<option value="'.$values['BranchDigit'].'">'.$values['BranchDigit'].' - '.$this->effective->get_chartypes($char_mode, $values['BranchName']).'</option>'; }
							
					echo	'</select>
						  </div>
						  </div>';
					
				}

			?>
			
			<div id="parent_select_rmlist" class="input-control select span2" data-role="input-control" style="height: 34px;">
				<div id="rmselect_group" class="form-group text-left">
					<label class="label label-clear">EMP. NAME</label>
					<select id="rmname" name="rmname" multiple="multiple"></select>
				</div>
			</div>
			
			<div class="input-control text span2" data-role="input-control" style="margin-left: 5px; height: 34px;">
				<label class="label label-clear">CUSTOMER</label>
				<input id="customer" name="customer" type="text" value="">
			</div>	
	
		</div>
		
	
		<div class="row" style="float: right; margin-right: 2%; margin-top: 1%; ">
		
			<div class="span12">
			
				<div id="parent_drawdown_flag" class="input-control checkbox span5 place-left" data-role="input-control" style="margin-left: 160px; height: 34px;">
					<label>
			            <input id="drawdown_flag" name="drawdown_flag" type="checkbox" value="Y"> 
			            <span class="check"></span>
			            <span class="label-over">Drawdown (Missing Doc Uncompleted After Approved)</span>
			        </label>
				</div>
		
				<div id="parent_submitform" class="input-control text span5 place-right" style="margin-left: 10px;">
					<button type="button" id="filterClear" class="bg-green fg-white" style="height: 33px; float: right;">CLEAR</button>
					<button type="button" id="filterSubmit" class="bg-lightBlue fg-white" style="height: 33px; float: right;">
						<i class="icon-search on-left"></i>SEARCH
					</button>
				</div>
				
			</div>
			
		</div>	
				
		</div>
		
	</div>
	
	<span data-role="input-control" style="margin-right: 10px; float: right; margin-top: 10px;" data-hint="กดเพื่อ refresh หน้า" data-hint-position="top" width="3%">
		<a id="refresh_pages" href="#" class="fg-lightBlue"><i class="fa fa-refresh on-left"></i> 
		<span>REFRESH</span></a>
	</span>
	
	<div id="showNumRecord" style="position: absolute; float: left; margin-top: 40px; margin-left: 1.5em; font-size: 0.9em;"></div>
	 
	<div id="tbl_content_reconsiledoc" class="table-responsive" style="padding: 0 20px;">
	<input type="hidden" name="actor" id="actor" value="<?php echo !empty($session_data['thname'])? $session_data['thname']:""; ?>">
    	<table id="tbl_reconsiledoc" class="table bordered hovered" style="width: 100%; margin: 10px auto 0;">
            <thead>
            	<tr class="brands">
            		<th rowspan="2" width="2%" style="display: none;">Doc ID</th>
            		<th colspan="4" width="18%">LOGISTIC</th>
            		<th colspan="4" width="18%">DOCUMENT COMPLETION</th>
            		<th colspan="4" width="18%">DOCUMENT RETURN</th>
            		<th colspan="5" width="38%">INFORMATION</th>
            		<th rowspan="2" width="2%">LINK</th>
            	</tr>
	            <tr class="brands">
	            	<th width="3%">
	            		<i class="fa fa-envelope-o" style="font-size: 1.1em;"></i>
	            		
	            	</th>
	            	<th width="8%;">DATE</th>
	            	<th data-hint="DAY|จำนวนวันที่ทั้งหมดที่ใช้ไประหว่างการดำเนินการ" data-hint-position="top">
	            		<i class="fa fa-flag-o" style="font-size: 1.1em;"></i>
	            		<!-- <img alt="" src="<?php echo base_url().'img/Date.png'; ?>" style="height: 20px; width: 20px; color: #FFF;"> -->
	            		
	            	</th>
	            	<th data-hint="STATUS" data-hint-position="top">
	            		<i class="fa fa-laptop"></i>
	            	</th>
	            	<th>DATE</th>
	            	<th data-hint="จำนวนเอกสารที่ขาด" data-hint-position="top"><i class="icon-copy"></i></th>
	            	<th data-hint="DAY|จำนวนวันที่ทั้งหมดที่ใช้ไประหว่างการดำเนินการ" data-hint-position="top" width="3%">
	            		<i class="fa fa-flag-o" style="font-size: 1.1em;"></i>
	            	</th>
	            	<th width="3%" data-hint="STATUS" data-hint-position="top">
	            		<i class="fa fa-laptop"></i>
	            	</th>
	            	<th>DATE</th>
	            	<th data-hint="จำนวนเอกสารขอคืน" data-hint-position="top" width="3%"><i class="icon-copy"></i></th>
	            	<th data-hint="DAY|จำนวนวันที่ทั้งหมดที่ใช้ไประหว่างการดำเนินการ" data-hint-position="top" width="3%">
	            		<i class="fa fa-flag-o" style="font-size: 1.1em;"></i>
	            	</th>
	            	<th width="3%" data-hint="STATUS" data-hint-position="top"><i class="fa fa-laptop"></i></th>
	            	<th width="6%">LB</th>
	            	<th width="5%">NCB</th>
	            	<th width="7%">TYPE</th>
	                <th width="15%">CUSTOMER</th>
	                <th width="15%">RM</th>
	            	
	            </tr>
            </thead>
            <tbody>
				
            </tbody>
      	</table>
      </div>
      
</div>
</div>
</div>


<!-- Start Modal -->
<div id="myModal" class="modal fade nonprint" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: none;"><span aria-hidden="true">&times;</span></button>
                <h4 id="docModalLabel" class="modal-title">Document Management</h4>
            </div>
            <div class="modal-body">
                            	
                <div class="document_list">
                    <div class="modal-header text-right" style="height: 25px; border-bottom: 0; margin-right: 10px;">
                        <span id="documentLack_Note" class="item-title place-left text-warning marginLeft5"></span>
		              	<button id="documentLack_closeModal_head" type="button" class="btn btn-primary" style="margin-top: -20px;" onclick="$('.document_list').hide();"><i class="fa fa-close"></i> Cancel</button>                        	
			            <button id="documentLack_AcceptModal_head" type="button" class="btn bg-lightBlue fg-white" onclick="getListDocumentToRender($('#doc_tmp').val(), $('#doc_tmpname').val(), $('#doc_ref').val(), $('#LockDocTypes').val());" style="margin-top: -20px;"><i class="fa fa-check fg-lime"></i> Accept</button>
		            </div>     
		            <div class="grid"> 
	       				<div id="lackdoc_content" class="row" style="padding: 10px 20px; margin-top: -7px;">
	       						    	
	       				</div>   
	       			</div>
       				<div class="modal-footer">
		              	<button id="documentLack_closeModal_foot" type="button" class="btn btn-primary" onclick="$('.document_list').hide();"><i class="fa fa-close"></i> Cancel</button>                        	
			            <button id="documentLack_AcceptModal_foot" type="button" class="btn bg-lightBlue fg-white" onclick="getListDocumentToRender($('#doc_tmp').val(), $('#doc_tmpname').val(), $('#doc_ref').val(), $('#LockDocTypes').val());" style="margin-right: 30px;"><i class="fa fa-check fg-lime"></i> Accept</button>
		            </div>        	
                </div>
                
                <input id="BranchCode" name="BranchCode" type="hidden"  value="<?php echo $session_data['branchcode']; ?>">            	
                <input id="LockDocTypes" name="LockDocTypes" type="hidden" value="">
                <input id="RecordNo" name="RecordNo" type="hidden"  value="">
                                
                <section class="form_container" style="clear: both; padding-right: 30px;">
                    <i id="RelationCompletionLogs" class="icon-history  on-right" style="display: none; float:right; margin-top: -5px; margin-right: 3%; cursor: pointer; font-size: 1.5em;" data-hint="History Logs" data-hint-position="top"></i>                                   
                    <table id="expense_table_docmanagement" style="width: 100%; min-width: 100%; margin-top: -10px;">
                        <thead>
                            <tr>
                                <th align="center" style="width: 0.1em; visibility:hidden; border: 0;">TYPE</th>
                                <th align="center" style="width: 5em;">TYPE</th>
                                <th align="center" style="width: 35em;">DOCUMENT</th>
                                <th align="center" style="width: 10em;">LB <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
                                <th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> HO RECEIVED</th>
                                <th align="center" style="width: 10em;">HO <i class="fa fa-arrow-right on-right on-left"></i> CA</th>
                                <th align="center" style="width: 10em;">CA <i class="fa fa-arrow-right on-right on-left"></i> HO</th>
                                <th align="center" style="width: 10em;">HO <i class="fa fa-arrow-right on-right on-left"></i> LB</th>
                                <th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> LB RECEIVED</th>
                                <th style="width: 1.5em;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>                                        
               </section>             		                             
            </div>
            <div class="modal-footer">
                <span class="place-left" style="color: red; margin-left: 30px;">เอกสารสีแดง คือ เอกสารสำคัญที่ใช้ในการจดจำนอง,  &nbsp;</span>
                <span class="place-left fg-orange">O = เอกสารต้นฉบับ, C = สำเนาเอกสาร</span>
                            	
              	<button id="document_closeModal" type="button" class="btn btn-primary" onclick="$('#myModal').modal('hide'); ">CLOSE</button>                        	
	            <button id="document_AcceptModal" type="button" class="btn bg-lightBlue fg-white" style="margin-right: 30px;">SAVE</button>
            </div>
		</div>
	</div>
</div>
<!-- End Modal -->

<div class="container" style="margin-top: 30px; margin-left: 20px;">
	<?php echo $footer; ?>
</div>

<script type="text/javascript">

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
var rootFixed = window.location.protocol + "//" + window.location.host + '/pcis';
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

var note_notify		= 0;
var checkbox_notify	= 0;
var chooselist_lackdoc = [];

function openModalComponent(bundled, name, ref, type, rowno) {

	$.ajax({
	   	url: pathFixed+'dataloads/getReconcileCompletionDocData?_=' + new Date().getTime(),
	   	type: "POST",
	   	data: {
	   	    relx: bundled,
	   		refx: name,
	   		ridx: ref,
	   		type: type
	   	},
	   	beforeSend:function() {

	   		$('#RecordNo').val(rowno);
	   	    $('#LockDocTypes').val(type);
		   	$('#doc_tmp').val(bundled);
		   	$('#doc_tmpname').val(name);
		   	$('#doc_ref').val(ref);
		
		   	$('#myModal').modal({
		   		show: true,
		   		keyboard: false,
		   		backdrop: 'static'		                        		
		   	});

		   	$('.document_list').hide();
		   	$('#expense_table_docmanagement > tbody').empty();

		   	// Set Defalut: data list
		   	chooselist_lackdoc = [];

	   	},
	   	success:function(data) {
	   	   	    
		   	if(data['status'] == 'true') {
			
		   	   	var i = 1;
			   	for(var indexed in data['data']) {
				   	  
				   	var doc_id 		  = data['data'][indexed]['DocID'];
					var borrowername  = data['data'][indexed]['DocOwner'];
					var doc_notreturn = data['data'][indexed]['DocIsLock'];
					var doc_type	  = data['data'][indexed]['DocType'];
					var doc_state	  = data['data'][indexed]['DocStatus'];
					var doc_detail	  = data['data'][indexed]['DocDetail'];
					var doc_comment   = data['data'][indexed]['DocOther'];

					var type_1 		  = '',
						type_2 		  = '',
						type_3 		  = '';

					var state_1		  = '',
						state_2		  = '',
						state_3		  = '';

					// Document Type : Missing Doc., Return Doc.
					if(doc_type == '') type_1  = 'selected="selected"';										
					else if(doc_type == 'M') type_2  = 'selected="selected"';
					else if(doc_type == 'R') type_3  = 'selected="selected"';

					// Document Status: Orginal Paper, Copy Paper
					if(doc_state == '') state_1  = 'selected="selected"';
					else if(doc_state == 'C') state_2  = 'selected="selected"';
					else if(doc_state == 'O') state_3  = 'selected="selected"';

					// Field Authority
					var hq_element_lock  = '',
						none_return		 = 'style="display: none"',					
						none_returnField = '';
						
					if(doc_type == 'R') {
						hq_element_lock  = 'border-color: #4390df;';
						none_return		 = '';
						none_returnField = 'style="min-width: 330px; max-width: 330px;"';
					}

					var ele_block   	 = (doc_type == 'M') ? 'disabled="disabled"':'';

					// Set Document not return.
					var doc_control_check  = '';
					var doc_control_field  = '';
					var doc_control_shadow = '';													

					var doc_control_dvbox  = '';
					var doc_control_ccbox  = '';
					var doc_switch_field   = '';

					if(doc_notreturn == 'Y') {	
							
						doc_control_check  = 'checked';
						doc_control_field  = 'text';
						doc_control_shadow = 'text';
							
						doc_control_dvbox  = '';
						doc_control_ccbox  = 'display: none;';
				
						doc_switch_field   = '<input value="(ไม่คืนเอกสาร) '+ doc_comment +'"><input id="DocListOther_' + i +'" name="DocListOther[]" type="hidden" value="'+ doc_comment +'" placeholder="อธิบายเพิ่มเติม">';
							
					} else {	
						doc_control_check  = '';
						doc_control_field  = 'text';
						doc_control_shadow = 'hidden';

						doc_control_dvbox  = 'display: none;';
						doc_control_ccbox  = '';

						doc_switch_field   = '<input id="DocListOther_' + i +'" name="DocListOther[]" value="'+ doc_comment +'" placeholder="อธิบายเพิ่มเติม">';
							
					}

					var objMissDoc	= data['data'][indexed]['MissID'];
					var LBSentToHQ	= data['data'][indexed]['LBSubmitDocDate'];
					var HQReceived	= data['data'][indexed]['HQReceivedDocFromLBDate'];
					var SentToCA	= data['data'][indexed]['SubmitDocToCADate'];
					var CAReturn	= data['data'][indexed]['CAReturnDate'];
					var HQSentToLB  = data['data'][indexed]['HQSentToLBDate'];
					var LBReceived  = data['data'][indexed]['BranchReceivedDate'];
			 		
					var LBChecked	= !(data['data'][indexed]['LBSubmitDocDate'] == '') ? 'checked="checked"':'';
					var HQChecked	= !(data['data'][indexed]['HQReceivedDocFromLBDate'] == '') ? 'checked="checked"':'';
					var LCChecked	= !(data['data'][indexed]['SubmitDocToCADate'] == '') ? 'checked="checked"':'';
					var CAChecked	= !(data['data'][indexed]['CAReturnDate'] == '') ? 'checked="checked"':'';
					var HLChecked	= !(data['data'][indexed]['HQSentToLBDate'] == '') ? 'checked="checked"':'';
					var LRChecked   = !(data['data'][indexed]['BranchReceivedDate'] == '') ? 'checked="checked"':'';

					var role_only   = '',					
						role_block  = '',
						hidden_del  = '',
						change_list = '',
						lbcode	    = $('#BranchCode').val();

					// Set Authority field for head quarter
					if(lbcode != '000') {
						role_only  = 'data-role="hqonly"';
						role_block = 'disabled="disabled"';						
					} else {
						role_only  = '';
						role_block = '';						
					}

					// Set hidden buttom remove
					if(HQReceived != '') {
						if(lbcode == '000') hidden_del = '';
						else hidden_del = ' display: none;';
					}

					if(HQReceived !== '') {
						change_list = ' display: none;'
					}

					var special_doc = data['data'][indexed]['ImportantDoc'];
		            if(special_doc == 'Y') var special_assing = 'color: red; ';
					else var special_assing = 'color: black !important';
		            	
					$('#expense_table_docmanagement > tbody').append(
						'<tr class=\"item_docmange\">'+
	                        '<td style=\"visibility:hidden; border: 0; width: 0.1em;\">'+
	                            '<div class=\"input-control select\">'+
	                                
		                            '<select id=\"DocType_' + i +'\" name=\"DocTypes[]\" style=\"height: 33px;\">'+
		                                    '<option value=\"M\" '+type_2+'>M</option>'+
		                                    '<option value=\"R\" '+type_3+'>R</option>'+		                                                    
		                        	'</select>'+
		                        			
									'<input id=\"MissID_' + i + '\" name=\"MissID[]\" type=\"hidden\" value=\"' + objMissDoc + '\">'+
									'<input id=\"docList_hidden_' + i +'\" name=\"docList_hidden[]\" type=\"hidden\" value=\"'+ parseInt(data['data'][indexed]['DocList']) +'\">'+
									'<input id="DocID" name=\"DocID\" type=\"hidden\" value=\"' + bundled + '\">'+
			                		'<input id=\"DocBorrowerName\" name=\"DocBorrowerName\" type=\"hidden\" value=\"' + name + '\">'+
									'<input id=\"DocIsRef\" name=\"DocIsRef\" type=\"hidden\" value=\"' + ref + '\">'+
											
	                            '</div>'+
	                            '</td>'+
								'<td valign=\"top\">' +
								'<div class=\"input-control select\">'+
	                                '<select id=\"DocStatus_' + i +'\" name=\"DocStatus[]\" style=\"height: 33px;\">'+
										'<option value=\"O\" ' + state_1 + ' ' + state_3 + '>O</option>'+
	                                    '<option value=\"C\" ' + state_2 + '>C</option>'+
	                                '</select>'+
	                            '</div>'+
							'</td>' +
							'<td class=\"text-left\" valign=\"top\">'+
	                        '<div class=\"input-control select\">'+                                   
	                            '<div id="DoclistText_' + i + '" style=\"height: 33px; padding-left: 10px; padding-top: 5px; border-top: 1px solid #D1D1D1; border-bottom: 1px solid #D1D1D1; ' + special_assing + '\">' +
	                                '<span>' + doc_detail + '</span>' + 
	                                '<i class="fa fa-edit fg-gray" style="position: absolute; right: 0; margin-top: 3px; ' + change_list + '" onclick="fnDocListChange(\'' + type + '\', ' +  parseInt(data['data'][indexed]['DocList']) + ', ' + i + ');"></i>' +
	                            '</div>' +
								'<div class=\"input-control checkbox tooltip-top\" data-tooltip=\"คลิกเลือก เมื่อไม่คืนเอกสาร\" ' + none_return + ' style=\"margin-left: 3px;\">' +
									'<label class=\"text-left\">' +
										'<input id=\"Doc_NoneReturn_' + i +'\" name=\"Doc_NoneReturn[]\" type=\"checkbox\" value=\"Y\" onclick=\"setNotReturnDoc(\'Doc_NoneReturn_\', ' + i + '); setNotReturnBundled(\'Doc_NoneReturn_\', \'DocNotReturn_\', ' + i + ');\" ' + doc_control_check + ' ' + role_block + '>' +
										'<span class=\"check\"></span>' +
									'</label>' +
								'</div>' +
								'<div id=\"Label_DocListOther_' + i +'\" class=\"input-control text\"  ' + none_returnField + '>' +
									doc_switch_field +
								'</div>'+								
								'<input id=\"DocList_' + i +'\" name=\"DocList[]\" type=\"hidden\" value=\"'+  parseInt(data['data'][indexed]['DocList']) + '\">' +
								'<input id=\"DocNotReturn_' + i +'\" name=\"DocNotReturn[]\" type=\"hidden\" value=\"' + doc_notreturn + '\">' +
	                        '</div>'+
	                    '</td>'+
	                    '<td class=\"text-left\" valign=\"top\">'+
	                        '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: 5px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
	                            '<label>'+
	                                '<input id=\"DSubHQ_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'DSubHQ_click_'+ i +'\', \'Doc_SubmitToHQ_'+ i +'\');\" '+ LBChecked + ' >'+
	                                '<span class=\"check\"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id=\"objSubHQ_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
	                            '<input type=\"'+ doc_control_field + '\" id=\"Doc_SubmitToHQ_' + i +'\" name=\"Doc_SubmitToHQ[]\" value=\"' + LBSentToHQ + '\" style=\"padding-left: 30px;\" readonly>'+
	                        '</div>'+
							'<div id=\"Doc_SubmitToHQ_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
	                            '<input type=\"' + doc_control_shadow + '\" value=\"' + LBSentToHQ + '\" disabled>'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class=\"text-left\" valign=\"top\">'+
	                        '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: 5px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
	                            '<label>'+
	                                '<input ' + role_block + ' ' + role_only + '  id=\"DRVD_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'DRVD_click_'+ i +'\', \'Doc_RVD_'+ i +'\');\" ' + HQChecked + '>'+
	                                '<span class=\"check\" style=\"border-color: #4390df;\"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id=\"objDRVD_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
	                            '<input ' + role_only + ' type=\"'+ doc_control_field + '\" id=\"Doc_RVD_' + i +'\" name=\"Doc_HQReceived[]\" value=\"' + HQReceived + '\" style=\"padding-left: 30px; border-color: #4390df;\" readonly>'+
	                        '</div>'+
							'<div id=\"Doc_RVD_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
	                            '<input type=\"' + doc_control_shadow + '\" value=\"' + HQReceived + '\" disabled>'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class=\"text-left\" valign=\"top\">'+
	                        '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: 5px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
	                            '<label>'+
	                                '<input ' + role_block + ' ' + role_only + ' id=\"HQC_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'HQC_click_'+ i +'\', \'Doc_HQC_'+ i +'\');\" ' + LCChecked + '>'+
	                                '<span class=\"check\" style=\"border-color: #4390df;\"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id=\"objHQC_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
	                            '<input ' + role_only + ' type=\"'+ doc_control_field + '\" id=\"Doc_HQC_' + i +'\" name=\"Doc_HQToCA[]\" value=\"' + SentToCA + '\" style=\"padding-left: 30px; border-color: #4390df;\" readonly>'+
	                        '</div>'+
							'<div id=\"Doc_HQC_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
	                            '<input type=\"' + doc_control_shadow + '\" value=\"' + SentToCA + '\" disabled>'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class=\"text-left\" valign=\"top\">'+
	                        '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: 5px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
	                            '<label>'+
	                                '<input ' + role_block + ' ' + role_only + ' id=\"CAH_click_' + i +'\" type=\"checkbox\" onclick=\"GenDateValidator(\'CAH_click_'+ i +'\', \'Doc_CAH_'+ i +'\');\" value=\"1\" ' + CAChecked + ' ' + ele_block + '>'+
	                                '<span class=\"check\" style=\"' + hq_element_lock + '\"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id=\"objCAH_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
	                            '<input ' + role_only + ' type=\"'+ doc_control_field + '\" id=\"Doc_CAH_' + i +'\" name=\"Doc_CAToHQ[]\" value=\"' + CAReturn + '\" style=\"padding-left: 30px; ' + hq_element_lock + '\" ' + ele_block + ' readonly>'+
	                        '</div>'+
							'<div id=\"Doc_CAH_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
	                            '<input type=\"' + doc_control_shadow + '\" value=\"' + CAReturn + '\" disabled>'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class=\"text-left\" valign=\"top\">'+
	                        '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: 5px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
	                            '<label>'+
	                                '<input ' + role_block + ' ' + role_only + ' id=\"HQL_click_' + i +'\" type=\"checkbox\" onclick=\"GenDateValidator(\'HQL_click_'+ i +'\', \'Doc_HQL_'+ i +'\');\" value=\"1\" ' + HLChecked + ' ' + ele_block + '>'+
	                                '<span class=\"check\" style=\"' + hq_element_lock + '\"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id=\"objHQL_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
	                            '<input ' + role_only + ' type=\"'+ doc_control_field + '\" id=\"Doc_HQL_' + i +'\" name=\"Doc_HQToLB[]\" value=\"' + HQSentToLB + '\" style=\"padding-left: 30px; ' + hq_element_lock + '\" ' + ele_block + ' readonly>'+
	                        '</div>'+
							'<div id=\"Doc_HQL_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
	                            '<input type=\"' + doc_control_shadow + '\" value=\"' + HQSentToLB + '\" disabled>'+
	                        '</div>'+
	                    '</td>'+
	                    '<td class=\"text-left\" valign=\"top\">'+
	                        '<div class=\"input-control cb-marginFixedChrome checkbox\" style=\"position:absolute; margin-left: 5px; margin-top: 0px; z-index: 999; ' + doc_control_ccbox + '\">'+
	                            '<label>'+
	                                '<input id=\"LBR_click_' + i +'\" type=\"checkbox\" value=\"1\" onclick=\"GenDateValidator(\'LBR_click_'+ i +'\', \'Doc_LBR_'+ i +'\');\" ' + LRChecked + ' ' + ele_block + '>'+
	                                '<span class=\"check\"></span>'+
	                            '</label>'+
	                        '</div>'+
	                        '<div id=\"objLBR_' + i +'\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_ccbox + '\">'+
	                            '<input type=\"'+ doc_control_field + '\" id=\"Doc_LBR_' + i +'\" name=\"Doc_LBReceived[]\" value=\"' + LBReceived + '\" style=\"padding-left: 30px;\" ' + ele_block + '>'+
	                        '</div>'+
							'<div id=\"Doc_LBR_' + i +'_hidden\" class=\"input-control text\" style=\"width: 120px; ' + doc_control_dvbox + '\">'+
	                            '<input type=\"' + doc_control_shadow + '\" value=\"' + LBReceived + '\" disabled>'+
	                        '</div>'+
	                    '</td>'+ 																		
	                    '<td class=\"del\">'+
	                        '<i class=\"fa fa-minus-circle\" style=\"cursor: pointer; font-size: 1.5em; color: red; margin-top: -20px; ' + hidden_del + '\" onclick=\"delRecordRelations(' + doc_id + ',\'' + ref + '\', '+  parseInt(data['data'][indexed]['DocList']) + ');\"></i>'+
	                    '</td>'+
					'</tr>'
					);

					$('#objSubHQ_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
					if(doc_type == 'M') {
	                	$('#objDRVD_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	                    $('#objHQC_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	                } else {
	                	$('#objDRVD_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	                    $('#objHQC_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	    				$('#objCAH_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	                    $('#objHQL_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	    				$('#objLBR_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	                }
	                   
					i++;
				
			   	}
			   	   	
		   	   	
		   	} else {
		   	   	renderErr();
		   	}

	   	},
	   	complete:function() {
	   	   		
	   		if(type == 'M') { $('#docModalLabel').text('Missing Document').addClass('animated fadeIn'); }
	   		else { $('#docModalLabel').text('Return Document').addClass('animated fadeIn'); }
	   			
	   	},				
	   	cache: true,
	   	timeout: 10000,
	   	statusCode: {
	   		404: function() { console.log("page not found."); },
	   		407: function() {
	   			console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
	   		},
	   		500: function() { console.log("internal server error."); }
	   	}
	   	        
	});

	var renderErr = function() {
		$('#expense_table_docmanagement > tbody')
		.empty()
		.append(
			'<tr class="row_empty">' +
				'<td style="width: 0.1em; visibility:hidden; border: 0; padding: 0;"></td>' +						
				'<td colspan="8" style="padding: 0;">ไม่พบข้อมูล</td>' +
				'<td style="padding: 0;"></td>' +
			'</tr>'
		);
			
	}
			
}

function getNewDoctoChangeLackList(id) {
	
	if(confirm('ยืนยันการเปลี่ยนแปลงบันทึกข้อมูล')) {

		var missing_getdoc    = $('input[name$="lackdoc_fieldcode[]"]:checked').map(function() {return $(this).val();}).get();
		var missing_getdoctxt = $('input[name$="lackdoc_fieldcode[]"]:checked').map(function() {return $(this).attr('data-attr');}).get();
		
		if(missing_getdoc.length >= 1) {
			$('#DocList_' + id).val(missing_getdoc[0]);
			$('#DoclistText_' + id + ' > span').text(missing_getdoctxt[0]).css('color', '#008A00 !important').addClass('animated fadeIn');
		}

		$('.document_list').removeClass('animated fadeInDown').hide()

	}
	
}


$('#document_AcceptModal').on('click', function() {

	if(confirm('ยืนยันการบันทึกข้อมูล')) {

		var doc_id		   = $('#DocID').val();
		var is_ref		   = $('input[name="DocIsRef"]').val();
		var doc_borrower   = $('input[name="DocBorrowerName"]').val();

		var non_returndoc  = $('input[name$="DocNotReturn[]"]').map(function() {return $(this).val();}).get();
		var miss_id		   = $('input[name$="MissID[]"]').map(function() {return $(this).val();}).get();
		var doctype        = $('select[name$="DocTypes[]"]').map(function() {return $(this).val();}).get();
		var docstatus 	   = $('select[name$="DocStatus[]"]').map(function() {return $(this).val();}).get();
		var doc_list	   = $('input[name$="DocList[]"]').map(function() {return $(this).val();}).get();
		var doc_other      = $('input[name$="DocListOther[]"]').map(function() {return $(this).val();}).get();

		var doc_submithq   = $('input[name$="Doc_SubmitToHQ[]"]').map(function() {return $(this).val();}).get();
        var doc_hqreceived = $('input[name$="Doc_HQReceived[]"]').map(function() {return $(this).val();}).get();
        var doc_hqtoca     = $('input[name$="Doc_HQToCA[]"]').map(function() {return $(this).val();}).get();

        var doc_catohq     = $('input[name$="Doc_CAToHQ[]"]').map(function() {return $(this).val();}).get();
        var doc_hqtolb     = $('input[name$="Doc_HQToLB[]"]').map(function() {return $(this).val();}).get();

        var doc_lbreceived = $('input[name$="Doc_LBReceived[]"]').map(function() {return $(this).val();}).get();
				
		$.ajax({
        	url: pathFixed + 'management/setDocumentManagementForm?_=' + new Date().getTime(),
            type: 'POST',
			data: {
				MissID: miss_id,
				DocID: doc_id,
				DocBorrowerName: doc_borrower,
				DocIsRef: is_ref,
				DocTypes: doctype,
			    DocStatus: docstatus,
				NonReturn: non_returndoc,
				DocList: doc_list,
				DocOther: doc_other,
				Doc_SubmitToHQ: doc_submithq,
				Doc_HQReceived: doc_hqreceived,
				Doc_HQToCA: doc_hqtoca,
				Doc_CAToHQ: doc_catohq,
				Doc_HQToLB: doc_hqtolb,
				Doc_LBReceived: doc_lbreceived,   
				Doc_Mode: $('#LockDocTypes').val()
			},
            success:function(data) {
				
				var responsed = JSON.parse(data);				
				if(responsed['status'] == 'true') {
					var not = $.Notify({ content: 'บันทึกข้อมูลสำเร็จ', style: { background: "green", color: "#FFFFFF" }, timeout: 10000 });
					not.close(7000);  
					} else {
						var not = $.Notify({ content: data['msg'], style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
					not.close(7000);  
				}
				
			},
            complete:function() {
                
            	var row_number = $('#RecordNo').val();
				var row_types  = $('#LockDocTypes').val();
				
				$.ajax({
                	url: pathFixed + 'dataloads/getNumBadgeByDashboard?_=' + new Date().getTime(),
                    type: 'POST',
					data: {
						relx: doc_id,
						refx: is_ref
					},
                    success:function(data) {
						console.log(data['data'][0]['NumMissingDoc']);
						if(row_types == 'M') {
							$('#onBadge_' + row_number).text(data['data'][0]['NumMissingDoc']);
							$('#Z2_App_' + row_number).fadeIn(data['data'][0]['AppStatus']);
						}

						if(row_types == 'R') $('#returndoc_onBadge_' + row_number).text(data['data'][0]['NumReturnDoc']);

					},
                    complete:function() {
							
						if(row_types == 'R') {

							$.ajax({
                            	url: pathFixed+'dataloads/fnLeepLighterChange?_=' + new Date().getTime(),
                                type: 'POST',
								data: {
									relx: doc_id,
									refx: is_ref,
									type: doctype
								},
                                success:function(data) {
                                    
									var objStat = jQuery.parseJSON(data);
									$('#R' + objStat['IsRef']).html(objStat['State']);

								},
                                complete:function() {
									$('#myModal').modal('hide');
                                },
                                cache: false,
                                timeout: 5000,
                                statusCode: {
                                	404: function() {
                                    	alert('page not found.');
                                    },
                                    407: function() {
                                    	console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
                                    },
                                    500: function() {
                                      	console.log('internal server error.');
                                    }
								}
		
							});

						}

						$('#myModal').modal('hide');
						
                    },
                    cache: false,
                    timeout: 5000,
                    statusCode: {
                    	404: function() {
                        	alert('page not found.');
                        },
                        407: function() {
                        	console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
                        },
                        500: function() {
                          	console.log('internal server error.');
                        }
					}

				});
            },
            cache: false,
            timeout: 5000,
            statusCode: {
            	404: function() {
                	alert('page not found.');
                },
                407: function() {
                	console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
                },
                500: function() {
                  	console.log('internal server error.');
                }
			}
		});	
        
	}
	
});

function delRecordRelations(bundled, ref, data) {
	
  	if(confirm('ยืนยันการลบข้อมูลหรือไม่')) {
										
		$.ajax({
        	url: pathFixed + 'management/delRecordBorrowerLoan?_=' + new Date().getTime(),
            type: 'POST',
			data: {
				relx: bundled,
				ltsx: data,
				modx: 'rcpx5',
				real: ref
			},
            success:function(data) {
				var not = $.Notify({ content: "ลบข้อมูลสำเร็จ", style: { background: "green", color: "#FFFFFF" }, timeout: 10000 });
				not.close(7000);                                      														
			},
            complete:function() {
        		
				var doc_id		   = $('#DocID').val();
				var row_number 	   = $('#RecordNo').val();
				var is_ref		   = $('input[name="DocIsRef"]').val();
				var doc_borrower   = $('input[name="DocBorrowerName"]').val();
														
				$.ajax({
                url: pathFixed+'dataloads/getNumBadgeByType?_=' + new Date().getTime(),
                type: 'POST',
				data: {
					relx: doc_id,
					refx: is_ref
				},
                success:function(data) {
                    	
                	$('#onBadge_' + row_number).text(data['data'][0]['NumMissingDoc']);
		           	$('#returndoc_onBadge_' + row_number).text(data['data'][0]['NumReturnDoc']);
			          
				},
                complete:function() {
						
                },
                cache: false,
                timeout: 5000,
                statusCode: {
                    404: function() {
                        alert('page not found.');
                    },
                    407: function() {
                        console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
                    },
                    500: function() {
                        console.log('internal server error.');
                    }
				}

			});
				
        },
        cache: false,
        timeout: 5000,
        statusCode: {
            404: function() {
                alert('page not found.');
            },
            407: function() {
                console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
            },
            500: function() {
                console.log('internal server error.');
            }
		}
	});										
		
	$('body').on('click', '#expense_table_docmanagement .del', function() {
	    var tr_length = $('#expense_table_docmanagement tr.item_docmange').length;											
	    if(parseInt(tr_length) > 1) {
	        $(this).parent().remove();	
	
	            
	    } else {
	        $('#expense_table_docmanagement').parent().after('<span class="docmange_error text-danger span5">หากแถวที่ระบุน้อยกว่าที่กำหนดจะไม่สามารถลบแถวได้..</span>').fadeIn();
	        $('.docmange_error').fadeOut(5000);
	            
	    }
	});

    return true;
 		
	}

}

function fnDocListChange(doc_type, value, id) {
	
	$('.document_list').show().addClass('animated fadeInDown').after(function() {
		getLackDocList(doc_type, value, 'single');
		$('#documentLack_AcceptModal_head, #documentLack_AcceptModal_foot')
		.attr('onclick', 'getNewDoctoChangeLackList(' + id + ')')
		
	});
	
}

function getLackDocList(doc_type, values = false, mode = 'multi') {

	var field_type;
	if(mode === 'single')
		field_type = 'radio';
	else
		field_type = 'checkbox';

	$.ajax({
    	  url: pathFixed + 'dataloads/lackcategory?_=' + new Date().getTime(),
    	  type: "POST",
    	  data: { typex: doc_type },
          beforeSend:function() {
        	  $('div#lackdoc_content').html('');  
          },
          success:function(data) {
		       	 
	          for(var indexed in data['data']) {
	        	 
	        	  var margin;
				  if(indexed == 0) margin = 'style="min-width: 95%;"';
				  
	        	  $('div#lackdoc_content').append(
        			 '<div class="panel" ' + margin + '>' +
					   '<div class="panel-header panel-header-custom bg-lightBlue fg-white text-left" style="font-size: 1.2em; font-weight: bold; min-height: 37px !important; max-height: 37px !important; vetical-text: top; padding-bottom: 2px !important;">' +
					  		data['data'][indexed]['LackCategory'] +
					    '</div>' +
					    '<div class="row panel-content" data-core="PanelLackAt_' + data['data'][indexed]['LackGroupID'] + '"></div>' +
					'</div>'
	        	  );
	        	  
	          }
			 
          },
          complete:function() {

        		$.ajax({
	   	    	  url: pathFixed+'dataloads/lackdoctype?_=' + new Date().getTime(),
	   	    	  type: "POST",
	   	          data: { typex: doc_type },
	   	          beforeSend:function() {
		   	          	   
	   	        	  if(mode !== 'single') {
		   	        	  if(note_notify == 0) {
		   	        		  var notify  = $.Notify({ content: 'ระบบ: รายการเอกสารสีแดง คือ รายการเอกสารสำคัญที่ต้องใช้ในการจดจำนอง', style: { background: "#F0A30A", color: "#FFFFFF" }, timeout: 10000 }); 
		   	        		  note_notify = 1;
		   	        		  notify.close(9000); 
		   	        	  }
	   	        	  }
		   	          
	   	          },
	   	          success:function(data) {
		   	        	  
		   	          var margin;
		 	          if(indexed != 0) { 	            		 
		 	          	  margin = 'style="margin-left: 10px !important; margin-top: -15px !important; min-width: 380px !important;"';  		 	            		 
		 	          } 
				 	    
		              for(var indexed in data['data']) {

		            	  var special_doc = data['data'][indexed]['ImportantDoc'];
		            	  if(special_doc == 'Y') var special_assing = 'color: red; ';
						  else var special_assing = 'color: black !important';
		            	  
		            	  $('div#lackdoc_content')
		            	  .find('div[data-core="PanelLackAt_' + data['data'][indexed]['LackGroupID'] + '"]')
		            	  .append(
		            			'<div class="lackdoc_sublist span3 text-left" ' + margin + '>' +
		            				'<div class="input-control ' + field_type + '">' +
		            					'<label>' +
		            						'<input id="lackdoc_fieldcode_' + indexed + '" name="lackdoc_fieldcode[]" type="' + field_type + '" value="' + data['data'][indexed]['LackID'] + '" data-attr="' + data['data'][indexed]['LackDoc'] + '">' +
		            						'<span class="check"></span>' +
		            						'<span class="lackdoc_code_text" style="font-weight: normal; ' + special_assing + '">' + data['data'][indexed]['LackDoc'] + '</span>' +
		            					'</label>' +
		            				'</div>' +
		            			'</div>'
		            	  );
		            	  
		              }	
		                
		                
	   	          },
	   	          complete:function() {

	   	        	if(values !== false) {
	   	        		var element_num = $('input[name$="lackdoc_fieldcode[]"][value="' +  parseInt(values) + '"]').length;
	   	        		if(element_num >= 1) {							
							$('input[name$="lackdoc_fieldcode[]"][value="' +  parseInt(values) + '"]').prop('checked', true);
	   	        		} else {
	   	        			$('#documentLack_Note').text('กรุณาเปลี่ยนหัวข้อใหม่ เนื่องจากหัวข้อเดิมเป็นหัวข้อที่ยกเลิกการใช้งาน').delay(800).addClass('animated rubberBand');
	   	        			var not = $.Notify({ content: 'กรุณาเปลี่ยนหัวข้อใหม่', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
	   						not.close(7000);  
	   	        		} 		            	
		            }

	   	        	if(mode !== 'single') {
			            if(chooselist_lackdoc.length >= 1) {	  
			            	if(checkbox_notify === 0) {
			            		var msg_notify  = $.Notify({ content: 'Checkbox กรอบสีเขียว คือ หัวข้อที่เลือกใช้งานไปแล้วในการสร้างรายการครั้งล่าสุด', style: { background: "#1B6EAE", color: "#FFFFFF" }, timeout: 10000 });
			            		checkbox_notify = 1;
			            	}
				                      	
				            $.each(chooselist_lackdoc, function(index) {
				            	$('input[name$="lackdoc_fieldcode[]"][value="' + chooselist_lackdoc[index] + '"]').parent().find('span.check').css('border', '2px solid #008A00');
				            })		            	
			            }
	   	        	}
	   	        	
	   	        	$('div.careturn_sublist').find('span.careturnlist_text').truncate({
	                     width: '400',
	                     token: '…',
	                     side: 'right',
	                     addtitle: true
	              	});
	  	        	
	   	        	
	   	          },
	   	          cache: true,
	   	          timeout: 5000,
	   	          statusCode: {
	   		  	   
	   	          }
	   	     
             });
        	
          },
          cache: true,
          timeout: 5000,
          statusCode: {
	  	       
          }
	     
	});
	
}

function GenDateValidator(id, bundled) {
	var str_date;
    var objDate = new Date();
    str_date = ('0' + objDate.getDate()).slice(-2) + '/' + ('0' + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
    var elements =  $('#' + id).is(':checked');
    if(elements) {
        $('#' + bundled).val(str_date);
    } else {
        $('#' + bundled).val('');
    }
}

function in_array(needle, haystack, argStrict) {
	
	  var key = '', strict = !! argStrict;

	  if (strict) {
	     for (key in haystack) {
		     if (haystack[key] === needle) {
		         return true;
		     }
		 }
	  } else {
		 for (key in haystack) {
			  if (haystack[key] == needle) {
			  	 return true;
			  }
		  }
	  }
	
	  return false;

}

</script>
