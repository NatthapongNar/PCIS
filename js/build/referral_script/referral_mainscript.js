$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }	
    
    var str_date;
    var objDate = new Date();
    str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear(); // Set Date format DD/MM/YYYY
  
	$('title').text('TL Management');	
	$('#fttab').parent().remove();

	
	// Adding Employee
	$('#add_employee').click(function() {
		
		$.Dialog({
            shadow: true,
            overlay: true,
            draggable: true,
            icon: '<i class="fa fa-edit"></i>',
            title: 'CREATE TL DATA',
            height: 780,
            width:  750,
            padding: 10,
            onShow: function(){
            	
            	var border  = '#16499A;';
                var content = 
            	'<div style="padding-left: 7%; width: 750px; height: 700px; overflow-x: hidden; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">' +
            	
            		'<div class="size12 field_scale check_fields" style="font-size: 1.2em; margin-top: -5px;">' +
            			'<small style="background: gray; color: #FFF; padding: 2px 7px 5px 7px; height: 28px;">Thai Life Agent Information</small>' +
            		'</div>' +
            		
	            	'<div class="input-control text field_scale check_fields">' +
						'<label class="label size3">JOIN / EXP DATE</label>' +
						'<div id="parent_register" class="input-control text field_scale size5" style="max-width: 365px;">' +
							'<input id="add_register" name="add_register" type="text" value="" placeholder="JOIN DATE" style="border-bottom-color: ' + border + ';">' +        
							'<button onclick="$(\'#add_register\').val(\'\');" class="btn-clear"></button>' +
						'</div>' +						
					'</div>' +	
					
					'<div class="input-control text field_scale check_fields" style="margin-top: 20px; margin-bottom: -10px;">' +
	            		'<label class="label size3">STATUS</label>' +
	            		'<input id="add_tl_status" name="add_tl_status" type="text" value="Pending" class="size2" style="background: #EBEBE7; border-bottom-color: ' + border + ';" readonly>' +
	            		/*
	            		'<label class="input-control checkbox size2" style="max-width: 85px; margin-left: 10px;">' +
	                        '<input id="add_id_card" name="add_id_card" type="checkbox" value="Y"  />' + 
	                        '<span class="check"></span>' +
	                        'ID CARD' +
	                    '</label>' +
	                    '<label class="input-control checkbox size2" style="max-width: 140px;">' +
	                        '<input id="add_tl_card" name="add_tl_card" type="checkbox" value="Y" />' + 
	                        '<span class="check"></span>' +
	                        'TL License Card' +
	                    '</label>' +
	                    */
	            	'</div>' +
	            	
                    '<div class="input-control text field_scale">' +
                	    '<label id="label_refname" class="label size3">REF CODE</label>' +
                	    '<div class="input-control text field_scale size5">' +
                	    	'<input id="add_tl_code" name="add_tl_code" type="text" value="" placeholder="REF CODE" onkeypress="validate(event)" style="border-bottom-color: ' + border + ';"  maxlength="8">' +
                	    '</div>' +	
                	    '<div class="input-control text field_scale size3 marginLeft5 hidden">' +
	     					'<input id="add_tl_name" name="add_tl_name" type="text" value="" placeholder="NAME-SURNAME" style="border-bottom-color: ' + border + ';">' +
	     				'</div>' +	
                	    '<i id="check_icon" class="fa fa-search" onclick="field_validation(\'#add_tl_code\');" style="font-size: 1.3em; cursor: pointer; margin-left: 5px; color: #666;"></i>' +
                	'</div>' +	
                	
                	'<div class="input-control text field_scale check_fields">' +
	            		'<label class="label size3">POSITION</label>' +
	            		'<div class="input-control select span2">' +
	            		    '<select id="add_tl_position_short" name="add_tl_position_short" style="height: 34px;">' +
	            		        '<option value=""></option>' +
	            		        '<option value="ฝ่าย">ฝ่าย</option>' +
	            		        '<option value="ภาค">ภาค</option>' +
	            		        '<option value="ศูนย์">ศูนย์</option>' +
	            		        '<option value="หน่วย">หน่วย</option>' +
	            		        '<option value="ตัวแทน">ตัวแทน</option>' +
	            		        '<option value="อื่นๆ">อื่นๆ</option>' +
	            		    '</select>' +
	            		'</div>' +
	            		'<div class="input-control text size3">' +
	            			'<input id="add_tl_position" name="add_tl_position" type="text" value="" placeholder="FULL POSITION" class="marginLeft5">' +
	            		'</div>' +
	            	'</div>' +	
                           	
                	'<div class="input-control text field_scale check_fields">' +
	            		'<label class="label size3">MOBILE</label>' +
	            		'<div class="input-control text size2">' +
	            			'<input id="add_tl_mobile_1" name="add_tl_mobile_1" type="text" value="" placeholder="MOBILE 1" onkeypress="validate(event)" style="border-bottom-color: ' + border + ';" maxlength="13">' +
	            		'</div>' +
	            		'<div class="input-control text size2">' +
	            			'<input id="add_tl_mobile_2" name="add_tl_mobile_2" type="text" value="" placeholder="MOBILE 2" onkeypress="validate(event)" style="margin-left: 5px;" maxlength="13">' +
	            		'</div>' +
            		'</div>' +		
           		
                	'<div class="input-control text field_scale check_fields">' +
                		'<label class="label size3">TL BRANCH / TEL.</label>' +
                		'<div class="input-control text size3">' +
                			'<input id="add_tl_branch" name="add_tl_code" type="text" value="" style="border-bottom-color: ' + border + ';">' +
                		'</div>' +
                		'<div class="input-control text size2 marginLeft5">' +
                			'<input id="add_tl_branchtel" name="add_tl_branchtel" type="text" value="" onkeypress="validate(event)" style="max-width: 365px;" maxlength="15">' +
                		'</div>' +
                	'</div>' +	
                	
                	'<div class="input-control select field_scale check_fields">' +
	            		'<label class="label size3">CHANNEL</label>' +
	            		'<select id="add_tl_channel" name="add_tl_channel" class="size5" style="max-width: 365px;"></select>' +
	            	'</div>' +		            
                	
                	'<div class="input-control text field_scale check_fields">' +
	         			'<label class="label size3">ADDRESS</label>' +
	         			'<textarea id="add_tl_address" name="add_tl_address" rows="2" cols="50" class="size5" style="max-width: 365px; border: 1px solid #D1D1D1;"></textarea>' +
	         		'</div>' +
	         		
	         		'<div class="input-control field_scale check_fields" style="margin-top: 10px; min-width: 664.5px;">' +
	         			'<label class="label size3">&nbsp;</label>' +
	         			'<div class="input-control checkbox size5" style="max-width: 365px;">' + 
		         			'<label>' +
								'<input id="add_tl_sentenvelope" name="add_tl_sentenvelope" type="checkbox" value="Y">' +
								'<span class="check"></span>' + 
								'<small class="label" style="min-width: 180px;">จัดส่งเอกสารไปยังตัวแทนแล้ว</small>' +
							'</label>' +	
	         			'</div>' +	         			
	         		'</div>' +
	         		/*
	         		'<div class="size12 field_scale check_fields" style="font-size: 1.2em; margin-top: -20px;">' +
	        			'<small style="background: #6BADF6; color: #FFF; padding: 2px 7px 5px 7px; height: 28px;">Lending Branch Information</small>' +
	        		'</div>' +
	         		 */
                	'<div class="input-control select field_scale check_fields" style="margin-top: -15px;">' +
                		'<div class="grid">' +
                			'<div class="row">' +
                				'<div class="span3"><label class="label size3">REGION / BRANCH (LB)</label></div>' +
		                		'<div class="span2 marginLeft_none">' +
		                			'<select id="add_lb_region" name="add_lb_region" class="size2"></select>' +
		                		'</div>' +
		                		'<div class="span2 marginLeft_none ">' +
		                			'<select id="add_lb_branch" name="add_lb_branch" class="size2 marginLeft5"></select>' +
		                		'</div>' +  		                			                		
	                		'</div>' +
                		'</div>' +
                	'</div>' +	
                	
                	'<div class="input-control select field_scale check_fields" style="margin-top: -10px;">' +
                		'<label class="label size3">ASSIGNMENT NAME (LB)</label>' +
                		'<select id="add_tl_ref1_selected" name="add_tl_ref1_selected" class="size5"></select>' +
            			'<input id="add_tl_ref1_code" name="add_tl_ref1_code" type="hidden" value="">' +
                		'<input id="add_tl_ref1" name="add_tl_ref1" type="hidden" value="">' +
                	'</div>' +	
                
                	'<div class="input-control text field_scale check_fields" style="margin-top: -5px;">' +
						'<label class="label size3">IDENTITY CARD / EXP DATE</label>' +
				   		'<label class="input-control checkbox size2">' +
	                        '<input id="add_id_card" name="add_id_card" type="checkbox" value="Y"  />' + 
	                        '<span class="check"></span>' + 'ID CARD' +
	                    '</label>' +	                  
						'<div id="parent_idcardexpired" class="input-control text field_scale size2 marginLeft5">' +
							'<input id="add_id_cardno_expired" name="add_id_cardno_expired" type="text" value="" placeholder="EXP DATE">' +   
							'<button onclick="$(\'#add_id_cardno_expired\').val(\'\');" class="btn-clear"></button>' +
						'</div>' +
					'</div>' +	
					
					'<div class="input-control text field_scale check_fields">' +
						'<label class="label size3">TL LICENSE / EXP DATE</label>' +
						'<label class="input-control checkbox size2" style="max-width: 140px;">' +
	                        '<input id="add_tl_card" name="add_tl_card" type="checkbox" value="Y">' + 
	                        '<span class="check"></span>' + 'TL LICENSE' +
	                    '</label>' +
						'<div id="parent_expired" class="input-control text field_scale size2 marginLeft5">' +
							'<input id="add_expired" name="add_expired" type="text" value="" placeholder="EXP DATE">' +   
							'<button onclick="$(\'#add_expired\').val(\'\');" class="btn-clear"></button>' +
						'</div>' +
					'</div>' +	
	        		
	        	  	'<div class="input-control select field_scale check_fields" style="margin-top: 20px;">' +
	            		'<label class="label size3">BANK / ACCOUNT NO.</label>' +
	            		'<div class="input-control select size2">' +
	            			'<select id="add_bank" name="add_bank"></select>' +	  
	            		'</div>'+
	            		'<div class="input-control text size3 marginLeft5">' +
	            			'<input id="bank_acct" name="bank_acct" type="text" value="" onkeypress="validate(event)" maxlength="25">' +
	            		'</div>'+
	            		'<i id="check_icon" class="icon-backspace-2 fg-lightRed" title="ล้างข้อมูลในฟิลด์แบงค์" onclick="reChoose();" style="position: absolute; margin-left: 5px; margin-top: 8px; font-size: 1.2em; cursor: pointer;"></i>' +	            		
	            	'</div>' +		
                	
                	/*
                	'<div class="input-control field_scale check_fields span12">' +
                		'<label class="label">DOCUMENT</label>' +
	            	    '<label class="input-control checkbox size2">' +
	                        '<input type="checkbox" />' + 
	                        '<span class="check"></span>' +
	                        'ID CARD' +
	                    '</label>' +
	                    '<label class="input-control checkbox size2">' +
	                        '<input type="checkbox" value="Y" />' + 
	                        '<span class="check"></span>' +
	                        'TL License Card' +
	                    '</label>' +
	                '</div>' +
                	*/
                	
            		'<div class="input-control text field_scale check_fields" style="margin-top: -10px">' +
	         			'<label class="label size3">REMARK</label>' +
	         			'<textarea id="add_tl_remark" name="add_tl_remark" rows="2" cols="50" class="size5" style="max-width: 365px; border: 1px solid #D1D1D1;"></textarea>' +
	         		'</div>' +
         		                                     		
                	'<div class="place-right check_fields" style="margin-right: 12%; margin-top: 10px;">' +
                		'<button type="button" class="primary" onclick="InitialForm();">CREATE</button>' +
                	'</div>' +
                	
                	'<div class="check_fields" style="margin-top: 50px;"><p style="color: #646464;"><span style="font-weight: bold;">หมายเหตุ: </span><span style="color: ' + border + '; text-decoration: underline;">ฟิลด์เส้นใต้สีฟ้า</span> คือ ฟิลด์ประเภทบังคับกรอก..</p></div>';
                	
                '</div>';
                
                // # Load List          
	        	getMasterRegion('#add_lb_region', '');
	        	getBranchList('#add_lb_branch', '', false);
	        	getTLABranchAutoComplete('#add_tl_branch');
	        	getTLList('#add_tl_channel', '', false);
	        		        		        		        	        	
                $.Dialog.content(content);
        
                // # Event Handled
                event_change('#add_lb_branch', '#add_lb_region', false, '');
	        	//event_change('#add_lb_branch', '#add_lb_region', false, '#add_tl_ref2');
	        	region_change('#add_lb_region', '#add_lb_branch');
	        	
	        	//setAgentStatus('#bank_acct', '#add_tl_status', 'add')
	        	$('#add_id_card, #add_tl_card, #bank_acct').change(function() { checkAgentStatus('add') });
	        	
	        	changeAssignment('#add_tl_ref1_selected', '#add_tl_ref1_code', '#add_tl_ref1');
          
	        	// Default Field Hidden
                $('.check_fields').css('display', 'none'); 
                $('#parent_register').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
               
                
                var check_idcard = $('#add_id_card').is(':checked');
                var check_tlcard = $('#add_tl_card').is(':checked');
                if(!check_idcard) {
                	$('#add_id_cardno_expired').prop('disabled', true);
                } else {
                	 $('#parent_idcardexpired').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                }
             
                if(!check_tlcard) {
                	$('#add_expired').prop('disabled', true);
                } else {
                	$('#parent_expired').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                }
                
                $('#add_id_card').change(function() {
                	 var checked = $(this).is(':checked');
                	 if(!checked) {
                		 $('#parent_idcardexpired').Datepicker({ showOn: "off" });
                     	 $('#add_id_cardno_expired').prop('disabled', true).parent().removeClass('error-state');
                     	 $('#add_id_cardno_expired').val('');
                     } else {
                    	 $('#add_id_cardno_expired').prop('disabled', false).parent().addClass('error-state');
                     	 $('#parent_idcardexpired').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                     }
                });
                
                $('#add_tl_card').change(function() {
               	 var checked = $(this).is(':checked');
               	 	if(!checked) {
               	 		$('#parent_expired').Datepicker({ showOn: "off" });
                    	$('#add_expired').prop('disabled', true).parent().removeClass('error-state');
                    	$('#add_expired').val('');
                    } else {
                   	 	$('#add_expired').prop('disabled', false).parent().addClass('error-state');
                    	$('#parent_expired').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
                    }
               });
 
            }

       }).css('top', '7.5px;');
		
	});
		
	// Initialyze Data Editor
	$('#referral_management tbody').on('click', '.editor', function () {	
		
		 var ref_id = $(this).attr('data-value');		 
		 if(ref_id != "" || ref_id != undefined) {
		 
			 $.ajax({
			        url: pathFixed + 'dataloads/getTLADataDetail?_=' + new Date().getTime(),
			        type: "POST",
			        data: {
			        	tl_ref: ref_id
			        },
			        beforeSend:function() {},
			        success:function(data) {
			   
			        	var row_id			= data['data'][0]['TL_ID'];
			        	var tl_code			= data['data'][0]['TLA_Code'];
			        	var tl_name			= data['data'][0]['TLA_Name'];
			        	var tl_position		= data['data'][0]['TLA_Position'];
			        	var tl_po_short		= data['data'][0]['TLA_PositionShort'];
			        	var tl_branch		= data['data'][0]['TLA_BranchName'];	 
			        	var tl_branchtel	= data['data'][0]['TLA_BranchTel'];	 
			        	var tl_mobile_1		= data['data'][0]['TLA_Mobile'];
			        	var tl_mobile_2		= data['data'][0]['TLA_Mobile_2'];
			        	var bank_code		= data['data'][0]['Bank_Code'];
			        	var acct_no			= data['data'][0]['AcctNo'];
			        	var region_id		= data['data'][0]['LB_RegionID'];    
			        	var region_name		= data['data'][0]['RegionNameEng'];
			        	var branch_code		= data['data'][0]['LB_BranchCode'];
			        	var branch_name		= data['data'][0]['LB_BranchName'];
			        	var branchdigit 	= data['data'][0]['BranchDigit'];
			        	var branc_tel		= data['data'][0]['BranchTel'];	
			        	var emp_code		= data['data'][0]['LB_EmpCode'];
			        	var emp_name		= data['data'][0]['LB_EmpName'];
			        	var po_title		= data['data'][0]['PositionTitle'];
			        	var emp_ref_1_c		= data['data'][0]['LB_Ref01_Code'];			        	
			        	var emp_ref_1		= data['data'][0]['LB_Ref01'];
			        	var emp_ref_2_c		= data['data'][0]['LB_Ref02_Code']; 
			        	var emp_ref_2		= data['data'][0]['LB_Ref02']; 
			        	var tl_status		= data['data'][0]['TLA_Status'];
			        	var join_date		= data['data'][0]['JoinDate'];
			        	var expired_date    = data['data'][0]['ExpDate'];
			        	var expired_idcard  = data['data'][0]['IDCard_ExpDate'];
			        	var create_name		= data['data'][0]['CreateBy'];
			        	var create_date		= data['data'][0]['CreateDate'];
			        	var update_name		= data['data'][0]['UpdateBy'];
			        	var update_date		= data['data'][0]['UpdateDate'];
			        	var remark_text		= data['data'][0]['Remark'];
			        	
			        	var id_card			= data['data'][0]['IDCard'];
			        	var tl_card			= data['data'][0]['TLCard'];
			        	var tl_channel		= data['data'][0]['TL_Channel'];
			        	
			        	var tl_address		= (data['data'][0]['TLA_Address']) ? data['data'][0]['TLA_Address']:'';
			        	var sentenvelope	= (data['data'][0]['SentEnvelope'] == 'Y') ? data['data'][0]['SentEnvelope']:'';
			           
			        	$.Dialog({
                             shadow: true,
                             overlay: true,
                             draggable: true,
                             icon: '<i class="fa fa-edit"></i>',
                             title: 'UPDATE TL DATA',
                             height: 900,
                             width: 700,                
                             padding: 10,
                             content: 'Please trying dialog reload.',
                             onShow: function() {
                          
                            	var border  = '#16499A;';
                            	var field_read = '';
                            	if(tl_code !== '99999999') {
                            		 field_read = 'readonly="readonly" style="background-color: #EBEBE7; border-bottom-color: ' + border + ';"';
                            	} 
                            	
                            	var idcard_checked 	 = '';
                            	var tlcard_checked 	 = '';
                            	var envelope_checked = '';
                            	if(id_card == 'Y') idcard_checked = 'checked';
                            	if(tl_card == 'Y') tlcard_checked = 'checked';
                            	if(sentenvelope == 'Y') envelope_checked = 'checked';
                                                    	
                            	var content = 
                            	'<div style="padding-left: 7%;">' +
                            	
                            		'<div class="size12 field_scale check_fields" style="font-size: 1.2em; margin-top: -5px;">' +
	                            		'<small style="background: gray; color: #FFF; padding: 2px 7px 5px 7px; height: 28px;">Thai Life Agent Information</small>' +
	                            	'</div>' +
                            	
	                            	'<div class="input-control text field_scale" style="margin-top: -10px;">' +
		        						'<label class="label size3" style="max-width: 180px;">JOIN DATE</label>' +
		        						'<div id="parent_register" class="input-control text field_scale size5" style="max-width: 365px;">' +
		        							'<input id="edit_register" name="edit_register" type="text" placeholder="JOIN DATE" value="' + join_date + '" style="border-bottom-color: ' + border + ';">' +        
		        							'<button onclick="$(\'#edit_register\').val(\'\');" class="btn-clear"></button>' +
		        						'</div>' +		        						
		        					'</div>' +
		        					
		        					'<div class="input-control select field_scale" style="margin-top: 10px; margin-bottom: -15px;">' +
		                     			'<label class="label size3" style="max-width: 180px;">STATUS</label>' +
		                     			'<select id="edit_tl_status" name="edit_tl_status" class="size2">' +
		                     				'<option value="New">New</option>' +
		                     				'<option value="Pending">Pending</option>' +
		                     				'<option value="Active_DD">Active (DD)</option>' +
		                     				'<option value="Active">Active</option>' +		                     				
		                     				'<option value="Inactive">Inactive</option>' +		                     				
		                     				'<option value="Cancel by TL">Cancel by TL</option>' +
		                     				'<option value="Terminate">Terminate</option>' +
		                     			'</select>' +		            
		                     		'</div>' +
	                            
		                     		'<div class="input-control text field_scale" style="padding: 0px;">' +
		                     			'<label class="label size3" style="max-width: 180px;">REF CODE / TLA NAME</label>' +
		                     			'<div class="input-control text field_scale size2">' +
		                     				'<input id="edit_tl_id" name="edit_tl_id" type="hidden" value="" class="size5">' +
		                     				'<input id="edit_tl_code" name="edit_tl_code" type="text" value="" placeholder="REF CODE" style="border-bottom-color: ' + border + ';">' +
		                     			'</div>' +
		                     			'<div class="input-control text field_scale size3 marginLeft5">' +
		                     				'<input id="edit_tl_name" name="edit_tl_name" type="text" value="" placeholder="NAME-SURNAME" style="border-bottom-color: ' + border + ';">' +
		                     			'</div>' +		                     			
		                     		'</div>' +	
		                     		
		                     		'<div class="input-control text field_scale" style="padding: 0px; margin-top: 3px;">' +
		                     			'<label class="label size3" style="max-width: 180px;">POSITION</label>' +
		                     			'<div class="input-control select size2">' +
		                     				'<select id="edit_tl_position_short" name="edit_tl_position_short" style="height: 34px;">' +
		                     					'<option value=""></option>' +
		                     					'<option value="ฝ่าย">ฝ่าย</option>' +
		                     					'<option value="ภาค">ภาค</option>' +
		                     					'<option value="ศูนย์">ศูนย์</option>' +
		                     					'<option value="หน่วย">หน่วย</option>' +
		                     					'<option value="ตัวแทน">ตัวแทน</option>' +
		                     					'<option value="อื่นๆ">อื่นๆ</option>' +
		                     				'</select>' +
		                     			'</div>' +
		                     			'<div class="input-control text field_scale size3 marginLeft5">' +
		                     				'<input id="edit_tl_position" name="edit_tl_position" type="text" placeholder="FULL POSITION" value="">' +
		                     			'</div>' +		           
		                     		'</div>' +	
		                     		
		                     		'<div class="input-control text field_scale" style="padding: 0px; margin-top: 3px;">' +
		                     			'<label class="label size3" style="max-width: 180px;">MOBILE</label>' +
		                     			'<div class="input-control text field_scale size2">' +
		                     				'<input id="edit_tl_mobile_1" name="edit_tl_mobile_1" type="text" value="" placeholder="MOBILE 1" onkeypress="validate(event)" class="size2" style="border-bottom-color: ' + border + '; maxlength="13">' +
		                     			'</div>' +
		                     			'<div class="input-control text field_scale size2 marginLeft5">' +
		                     				'<input id="edit_tl_mobile_2" name="edit_tl_mobile_2" type="text" value="" placeholder="MOBILE 2" onkeypress="validate(event)" class="size2" maxlength="13">' +
		        	            		'</div>' +
	                     			'</div>' +		
	                     			/*
		                     		'<div class="input-control text field_scale">' +
		                     			'<label class="label size3" style="max-width: 180px;">TL BRANCH</label>' +
		                     			'<input id="edit_tl_branch" name="edit_tl_code" type="text" value="" class="size5" style="border-bottom-color: ' + border + '; max-width: 365px;">' +
		                     		'</div>' +
		                     		
		                     		'<div class="input-control text field_scale">' +
	                     				'<label class="label size3" style="max-width: 180px;">TL BRANCH TEL.</label>' +
	                     				'<input id="edit_tl_branchtel" name="edit_tl_branchtel" type="text" onkeypress="validate(event)" value="" class="size5" style="border-bottom-color: ' + border + ';  max-width: 365px;" maxlength="15">' +
	                     			'</div>' +
	                     			*/
	                     			

	                     			'<div class="input-control text field_scale check_fields">' +
     			                		'<label class="label size3" style="max-width: 180px;">TL BRANCH / TEL.</label>' +
     			                		'<div class="input-control text size3">' +
     			                			'<input id="edit_tl_branch" name="edit_tl_branch" type="text" value="" style="border-bottom-color: ' + border + ';">' +
     			                		'</div>' +
     			                		'<div class="input-control text size2 marginLeft5">' +
     			                			'<input id="edit_tl_branchtel" name="edit_tl_branchtel" type="text" value="" onkeypress="validate(event)" style="max-width: 365px;" maxlength="15">' +
     			                		'</div>' +
     			                	'</div>' +	
     			                	 
     			               	
     			                	'<div class="input-control select field_scale check_fields">' +
     				            		'<label class="label size3">CHANNEL</label>' +
     				            		'<select id="edit_tl_channel" name="edit_tl_channel" class="size5" style="max-width: 365px; margin-left: -40px;"></select>' +
     				            	'</div>' +	
         			                	
         			                '<div class="input-control text field_scale check_fields" style="margin-top: -3px;">' +
         				         		'<label class="label size3" style="max-width: 180px;">ADDRESS</label>' +
         				         		'<textarea id="add_tl_address" name="add_tl_address" rows="2" cols="50" class="size5" style="max-width: 365px; border: 1px solid #D1D1D1;">' + tl_address + '</textarea>' +
         				         	'</div>' +
         				         	
         				         	'<div class="input-control field_scale check_fields" style="margin-top: 0px; min-width: 664.5px; margin-bottom: 0px; padding: 0px;">' +
	         		         			'<label class="label size3" style="max-width: 180px;">&nbsp;</label>' +
	         		         			'<div class="input-control checkbox size5" style="min-width: 365px;">' + 
	         			         			'<label>' +
	         									'<input id="edit_tl_sentenvelope" name="edit_tl_sentenvelope" type="checkbox" value="Y" ' + envelope_checked + '>' +
	         									'<span class="check"></span>' + 
	         									'<small class="label" style="min-width: 180px;">จัดส่งเอกสารไปยังตัวแทนแล้ว</small>' +
	         								'</label>' +	
	         		         			'</div>' +	         			
	         		         		'</div>' +
	         		         		
	         		         		'<div class="input-control select field_scale check_fields" style="margin-top: -20px; margin-bottom: -10px;">' +
		                        		'<div class="grid">' +
		                        			'<div class="row">' +
			                        			'<div class="span3" style="max-width: 180px;">' +
		                        					'<label class="label size3">REGION / BRANCH (LB)</label>' +
		                        				'</div>' +
		        		                		'<div class="span2 marginLeft_none">' +
		        		                			'<select id="edit_lb_region" name="edit_lb_region" class="size2"></select>' +
		        		                		'</div>' +
		        		                		'<div class="span2 marginLeft_none ">' +
		        		                			'<select id="edit_lb_branch" name="edit_lb_branch" class="size2 marginLeft5"></select>' +
		        		                		'</div>' +  		                			                		
		        	                		'</div>' +
		                        		'</div>' +
		                        	'</div>' +	
		                        	
		                        	'<div class="input-control select field_scale check_fields" style="margin-top: -10px; margin-bottom: -30px; margin-bottom: 0px;">' +
		                        		'<label class="label size3" style="max-width: 180px;">ASSIGNMENT NAME (LB)</label>' +
		                        		'<select id="edit_tl_ref1_selected" name="edit_tl_ref1_selected" class="size5"></select>' +
		                    			'<input id="edit_tl_ref1_code" name="edit_tl_ref1_code" type="hidden" value="">' +
		                        		'<input id="edit_tl_ref1" name="edit_tl_ref1" type="hidden" value="">' +
		                        	'</div>' +	
	         		         		
	                     			/*
		                     		'<div class="input-control select field_scale" style="margin-top: -10px;">' +
		                     			'<label class="label size3" style="max-width: 180px;">REGION</label>' +
		                     			'<select id="edit_lb_region" name="edit_lb_region" class="size5" style="max-width: 365px;"></select>' +
		                     		'</div>' +	
		                     		
		                       		'<div class="input-control select field_scale" style="margin-top: 0px;">' +
		                       			'<label class="label size3" style="max-width: 180px;">LENDING BRANCH</label>' +
		                       			'<select id="edit_lb_branch" name="edit_lb_branch" class="size5" style="max-width: 365px;"></select>' +
                     				'</div>' +	
                     			
		                     		'<div class="input-control select field_scale" style="margin-top: 0px;">' +
		                     			'<label class="label size3" style="max-width: 180px;">ASSIGNMENT NAME</label>' +
		                     			'<select id="edit_tl_ref1_selected" name="edit_tl_ref1_selected" class="size5" style="max-width: 365px;"></select>' +
		                     			'<input id="edit_tl_ref1_code" name="edit_tl_ref1_code" type="hidden" value="">' +
		                     			'<input id="edit_tl_ref1" name="edit_tl_ref1" type="hidden" value="" class="size5">' +
		                     		'</div>' +	
		                     		
		                     		/*
		                     		'<div class="input-control select field_scale">' +
		                     			'<label class="label">RM (Special Assign)</label>' +		                     	
		                     			'<select id="edit_tl_ref2" name="edit_tl_ref2" multiple="multiple" class="size5"></select>' +
		                     		'</div>	' +	
		                     		*/
		                     		                     		
		                     		'<div class="input-control text field_scale check_fields" style="margin-top: 0px;">' +
			    						'<label class="label size3" style="max-width: 180px;">IDENTITY CARD / EXP DATE</label>' +
			    				   		'<label class="input-control checkbox size2" style="max-width: 140px;">' +
			    				   			'<input id="edit_id_card" name="edit_id_card" type="checkbox" value="Y" ' + idcard_checked + '>' + 
	            	                        '<span class="check"></span>' + 'ID CARD' +
	            	                    '</label>' +
			    						'<div id="parent_idcardexpired" class="input-control text field_scale size2 marginLeft5">' +
			    							'<input id="edit_id_cardno_expired" name="edit_id_cardno_expired" type="text" value="' + expired_idcard + '" placeholder="EXP DATE">' +   
			    							'<button onclick="$(\'#edit_id_cardno_expired\').val(\'\');" class="btn-clear"></button>' +
			    						'</div>' +
			    					'</div>' +	
			    					
			    					'<div class="input-control text field_scale check_fields" style="margin-top: 5px;">' +
			    						'<label class="label size3" style="max-width: 180px;">TL LICENSE / EXP DATE</label>' +
			    						'<label class="input-control checkbox size2" style="max-width: 140px;">' +
	            	                        '<input id="edit_tl_card" name="edit_tl_card" type="checkbox" value="Y" ' + tlcard_checked + '>' + 
	            	                        '<span class="check"></span>' + 'TL License Card' +
	            	                    '</label>' +
			    	                    '<div id="parent_expired" class="input-control text field_scale size2 marginLeft5">' +
			    	                    	'<input id="edit_expired" name="edit_expired" type="text" placeholder="EXP DATE" value="' + expired_date + '">' +        
			    	                        '<button onclick="$(\'#edit_expired\').val(\'\');" class="btn-clear"></button>' +
			    	                    '</div>' +
			    					'</div>' +	
			    					
			    					'<div class="input-control select field_scale" style="max-width: 620px; max-height: 34px;">' +
		        	            		'<label class="label size3" style="max-width: 180px;">BANK / ACCOUNT NO.</label>' +
		        	            		'<div class="input-control select size2">' +
		        	            			'<select id="edit_bank" name="edit_bank"></select>' +	  
		        	            		'</div>'+
		        	            		'<div class="input-control text size3 marginLeft5">' +
		        	            			'<input id="edit_bank_acct" name="edit_bank_acct" type="text" value="' + acct_no + '" onkeypress="validate(event)" maxlength="15">' +
		        	            		'</div>'+
		        	            		'<i id="check_icon" class="icon-backspace-2 fg-lightRed" title="ล้างข้อมูลในฟิลด์แบงค์" onclick="reChoose();" style="position: absolute; margin-left: 5px; margin-top: 8px; font-size: 1.2em; cursor: pointer;"></i>' +
		        	            	'</div>' +	
		                     		
		                     		'<div class="input-control text field_scale" style="margin-top: -5px;">' +
		                     			'<label class="label size3" style="max-width: 180px;">REMARK</label>' +
		                     			'<textarea id="edit_tl_remark" name="edit_tl_remark" rows="2" cols="50" class="size5" style="max-width: 365px; border: 1px solid #D1D1D1;">' + remark_text + '</textarea>' +
		                     		'</div>' +
		                     		
		                     		'<div class="place-right marginTop10" style="margin-right: 12%;">' +
		                     			'<button type="button" class="primary" onclick="InitialUpdateForm()">UPDATE</button>' +
		                     		'</div>' +
		                     		
		                     	'</div>';
                            	
                                 $.Dialog.content(content);
                                 
                             }

                        });
			        		
			        	
			        	// Preload
			        	getBankList('edit_bank', bank_code, true, true);
			        	getTLABranchAutoComplete('#edit_tl_branch');
			        	getMasterRegion('#edit_lb_region', region_id);			        
			        	getBranchList('#edit_lb_branch', branch_code, false);
			        	getMasterTLAStatusList('#edit_tl_status', false, false, tl_status);		
			        	getTLList('#edit_tl_channel', tl_channel, false);
			       
			        	if(data['status']) {
			        		
			        		 $('#edit_tl_id').val(row_id);
	                   		 $('#edit_tl_code').val(tl_code);
	                   		 $('#edit_tl_name').val(tl_name);
	                   		 $('#edit_tl_position_short').find('option[value="' + tl_po_short + '"]').prop('selected', true);
	                   		 $('#edit_tl_position').val(tl_position);
	                   		 $('#edit_tl_branch').val(tl_branch);
	                   		 $('#edit_tl_branchtel').val(tl_branchtel);	                   		
	                   		 $('#edit_tl_mobile_1').val(tl_mobile_1);
	                   		 $('#edit_tl_mobile_2').val(tl_mobile_2);
	                   		 $('#edit_tl_ref1').val(emp_name);
	                   		 $('#edit_tl_ref1_code').val(emp_code);
	                   			                   		 
	                   		 /*	                   		 
	                   		 // ref 2: special temp
	                   		 $('#edit_tl_ref2_code_hide').val(emp_ref_2);	                   		
	                   		 $('#edit_tl_ref2_code').val(emp_ref_2);
	                   		 $('#edit_tl_ref2_hide').val(emp_ref_2_c);
	      					 */ 
	                   		 
	                   		 /*
				        	 if(branch_code != '') {
				        		 
				        		 var object_merge = [];
				        		 if(emp_ref_2_c[0] != '') {				        			 
				        			 for(var index in emp_ref_2_c) { object_merge.push(emp_ref_2_c[index] + '|' + emp_ref_2[index]); }
				        			 
				        		 }
				        	
				        		 getRMListBoundary('#edit_tl_ref2', branch_code, object_merge, true);
				        		 
				        	 }	
	                   		 */
	                   		 
	                   		$('#edit_tl_ref1_selected').queue(function() { fnLoadRMList('#edit_tl_ref1_selected', branch_code, true, true); })
	                   		.delay(800)
	                   		.queue(function() { getAssignmentInfomation('', emp_ref_1_c); }).dequeue();			
	                   		 
                  	 	}        	
			        				        
			        	region_change('#edit_lb_region', '#edit_lb_branch');
			        	event_editChange('#edit_lb_branch', '#edit_lb_region', true, '');
			        	changeAssignment('#edit_tl_ref1_selected', '#edit_tl_ref1_code', '#edit_tl_ref1');
			        	//setAgentStatus('#edit_bank_acct', '#edit_tl_status', 'edit');
			        	$('#edit_id_card, #edit_tl_card, #edit_bank_acct').change(function() { checkAgentStatus('edit') });
			        	$('#parent_register').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
			        	
			        	var check_idcard = $('#edit_id_card').is(':checked');
		                var check_tlcard = $('#edit_tl_card').is(':checked');
		                if(!check_idcard) {
		                	$('#edit_id_cardno_expired').prop('disabled', true);
		                } else {
		                	 $('#parent_idcardexpired').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
		                }
		             
		                if(!check_tlcard) {
		                	$('#edit_expired').prop('disabled', true);
		                } else {
		                	$('#parent_expired').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
		                }
		                
		                $('#edit_id_card').change(function() {
		                	 var checked = $(this).is(':checked');
		                	 if(!checked) {
		                		 $('#parent_idcardexpired').Datepicker({ showOn: "off" });
		                     	 $('#edit_id_cardno_expired').prop('disabled', true).parent().removeClass('error-state');
		                     	 $('#edit_id_cardno_expired').val('');
		                     } else {
		                    	 $('#edit_id_cardno_expired').prop('disabled', false).parent().addClass('error-state');
		                     	 $('#parent_idcardexpired').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
		                     }
		                });
		                
		                $('#edit_tl_card').change(function() {
		               	 var checked = $(this).is(':checked');
		               	 	if(!checked) {
		               	 		$('#parent_expired').Datepicker({ showOn: "off" });
		                    	$('#edit_expired').prop('disabled', true).parent().removeClass('error-state');
		                    	$('#edit_expired').val('');
		                    } else {
		                   	 	$('#edit_expired').prop('disabled', false).parent().addClass('error-state');
		                    	$('#parent_expired').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
		                    }
		               });
			        				        	
			        },
			        complete:function() {
		
			        },
			        cache: true,
			        timeout: 5000,
			        statusCode: {
				        404: function() { alert( "page not found." ); },
				        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied.)"); },
				        500: function() { console.log("internal server error."); }
			        }
			    })
		 
	 	 }
		 
	});
	
	// DEFAULT LOANDER	
	getMasterRegion('#lb_region', '');
	getBranchList('#lb_branch', '', true);
	getTLABelongToBranch('#tl_branch', true);
	getTLAPositionTitle('#tl_position', true);
	getMasterTLAStatusList('#tl_status', 'Active,Active_DD', true);
	
	// ############# FUNCTION ##################
	function getTLList(element, select_code, multi) {

		 $.ajax({
	        url: pathFixed + 'dataloads/getTLChannel?_=' + new Date().getTime(),
	        type: "GET",
	        dataType: 'json',
	        contentType: "application/json",
	        success:function(responsed) {
	        	
	        	$(element).empty().prepend('<option value=""></option>');
	        	for(var indexed in responsed['data']) {
	        		$(element).append('<option value="' + responsed['data'][indexed]['RowID'] + '" >' + responsed['data'][indexed]['SourceChannel'] + '</option>');
	        		if(select_code != '') {
	        			 $(element).find('option[value="' + select_code + '"]').prop('selected', true);
	        		}
	        	}
	        	
	        	if(multi == true) {
	        		$(element).find('option[value=""]').remove();
	        		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
	        	}
	        	    
	        },
	        cache: true,
	        timeout: 5000,
	        statusCode: {
		        404: function() { alert( "page not found." ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied.)"); },
		        500: function() { console.log("internal server error."); }
	        }
	    });
		
	}
	
	function setAgentStatus(element, to_element, mode) {		
		$(element).keyup(function() {
			var values = $(element).val();
			
			if(mode == 'add') {
				if(values.length >= 9) $(to_element).val('New');
				else $(to_element).val('Pending');	
			} else {
				$(to_element).find('option[value="' + values.trim() + '"]').click();	   
			}
			
					
		});
	}
	
	function checkAgentStatus(mode) {
		if(mode == 'add') {
			var bankcode = $('#bank_acct').val();
			var id_card	 = $('#' + mode + '_id_card:checked').val();
			var tl_card	 = $('#' + mode + '_tl_card:checked').val();
			if(bankcode.length >= 9 && id_card == 'Y' && tl_card == 'Y') {
				$('#add_tl_status').val('New');
			} else {
				$('#add_tl_status').val('Pending');	
			}
			
		} else {
			var bankcode = $('#' + mode + '_bank_acct').val();
			var id_card	 = $('#' + mode + '_id_card:checked').val();
			var tl_card	 = $('#' + mode + '_tl_card:checked').val();
			if(bankcode.length >= 9 && id_card == 'Y' && tl_card == 'Y') {
				$('#edit_tl_status').find('option[value="New"]').prop('selected', true);	 
			} else {
				$('#edit_tl_status').find('option[value="Pending"]').prop('selected', true);	 	
			}
		}

	}
	
	function getMasterRegion(element, select_code) {
		
		 $.ajax({
	        url: pathFixed + 'dataloads/regionInfo?_=' + new Date().getTime(),
	        type: "GET",
	        success:function(responsed) {
	  
	        	var selected = '';
	        	$(element).empty().prepend('<option value=""></option>');
	        	for(var indexed in responsed['data']) {	        	
	        		$(element).append('<option value="' + responsed['data'][indexed]['RegionID'].trim() + '" ' + selected + '>' + responsed['data'][indexed]['RegionNameEng'] + '</option>');
	        	
	        	}
	          
	        },	
	        complete:function() {
	        	
	        	if(select_code != '') {
	        		var regional = select_code.trim();
        			$(element).find('option[value="' + regional + '"]').prop('selected', true);	        		
        		}
	        },
	        cache: true,
	        timeout: 5000,
	        statusCode: {
		        404: function() { alert( "page not found." ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied.)"); },
		        500: function() { console.log("internal server error."); }
	        }
	    })
		
	}

	function getBranchList(element, select_code, multi) {

		 $.ajax({
	        url: pathFixed + 'dataloads/getBranchListAll?_=' + new Date().getTime(),
	        type: "GET",
	        success:function(responsed) {
	    
	        	$(element).empty().prepend('<option value=""></option>');
	        	for(var indexed in responsed['data']) {
	        		$(element).append('<option value="' + responsed['data'][indexed]['BranchCode'].trim() + '" data-attr="' + responsed['data'][indexed]['RegionID'].trim() + '">' + responsed['data'][indexed]['BranchName'] + '</option>');
	        		if(select_code != '') {
	        			 $(element).find('option[value="' + select_code + '"]').prop('selected', true);
	        		}
	        	}
	        	
	        	if(multi == true) {
	        		$(element).find('option[value=""]').remove();
	        		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
	        	}
	        		       
	        },
	        cache: true,
	        timeout: 5000,
	        statusCode: {
		        404: function() { alert( "page not found." ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied.)"); },
		        500: function() { console.log("internal server error."); }
	        }
	    });
		
	}
	
	function getRMListBoundary(element, branch_code, selected, multi) {
		
		 $.ajax({
	        url: pathFixed + 'dataloads/getRMListBoundaryByCode?_=' + new Date().getTime(),
	        type: "POST",
			data: {
				branchcode: [branch_code],
				section: 'false',
				xr: new Date().getTime()
			},
	        success:function(responsed) {
	        	
	        	//$(element).empty().prepend('<option value=""></option>');
				for(var indexed in responsed['data']) {
					var user_role = '(' + responsed['data'][indexed]['User_Role'] + ') ';
					var opt_value = responsed['data'][indexed]['EmployeeCode'] + '|' + responsed['data'][indexed]['FullNameTh'].trim();
					//$(element).append('<option value="' + responsed['data'][indexed]['FullNameTh'].trim() + '" data-attr="' + responsed['data'][indexed]['EmployeeCode'] + '">' + user_role + responsed['data'][indexed]['FullNameTh'] + '</option>');
					
					var list_selected = '';
					if(selected[0] != '') {						
						for(var index in selected) {
							
							if(opt_value == selected[index]) {
								list_selected = 'selected="selected"';
							} 
						
						}
						 
					}
					
					$(element).append('<option value="' + opt_value + '" ' + list_selected + '>' + user_role + responsed['data'][indexed]['FullNameTh'] + '</option>');
				
				}
				
				
				
				if(multi) {
					$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
				}
	
	        },
	        cache: true,
	        timeout: 5000,
	        statusCode: {
		        404: function() { alert( "page not found." ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied.)"); },
		        500: function() { console.log("internal server error."); }
	        }
	        
	    });

	}
	
	function getBankList(element, bank_code, multi, option = false) {
		
		 $.ajax({
	        url: pathFixed + 'dataloads/getBankList?_=' + new Date().getTime(),
	        type: "GET",
	        success:function(responsed) {
	    
	        	$('#' + element).empty().prepend('<option value=""></option>');
	        	for(var indexed in responsed['data']) {	        		
	        		$('#' + element).append('<option value="' + responsed['data'][indexed]['Bank_Code'] + '" title="' + responsed['data'][indexed]['Bank_NameTh']  + '">' + responsed['data'][indexed]['Bank_Digit'] + '</option>');
	        			        		
	        	}
	        	
	        	if(multi == true) {
	        		$('#' + element).find('option[value=""]').remove();
	        		$('#' + element).change(function() { }).multipleSelect({ width: '140px', filter: true, position: 'top', single: option });
	        	}
	        
	        	if(bank_code != '') {	     
       			 	$('input[name="selectItem' + element + '"][value="' + bank_code + '"]').click();
       			 	console.log($('input[name="selectItem' + element + '"][value="' + bank_code + '"]').click());
	        	}
	        		       
	        },
	        cache: true,
	        timeout: 5000,
	        statusCode: {
		        404: function() { alert( "page not found." ); },
		        407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied.)"); },
		        500: function() { console.log("internal server error."); }
	        }
	    });
		 
	}
	
	// ############# EVENT ##################
	
	function region_change(element, to_element) {
		
		$(element).change(function() {
		
			 var select_region = $(element + ' option:selected').val();			
			 if(select_region == "") {
				 getBranchList(to_element, '');
				 
			 } else {
				 
				 $.ajax({
					url: pathFixed+'dataloads/branchBoundary?_=' + new Date().getTime(),
					type: "POST",
					data: { rgnidx:select_region },
					success:function(responsed) {
					
						$(to_element).empty().prepend('<option value=""></option>');
						for(var indexed in responsed['data']) {
							$(to_element).append('<option value="' + responsed['data'][indexed]['BranchCode'].trim() + '" data-attr="' + responsed['data'][indexed]['RegionID'].trim() + '">' + responsed['data'][indexed]['BranchName'] + '</option>');
						}
		
					},
					cache: false,
					timeout: 5000,
					statusCode: {
						404: function() {
							alert( "page not found" );
						},
				        407: function() {
				        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
				        }
					}
					
				});
			 
			 }
			
		});
		
	}
	
	function event_change(element, to_element, multi, boundary) {
		
		$(element).change(function() {
			var data_attr  = $(element + ' option:selected').attr('data-attr');
			var data_value = $(element + ' option:selected').val();
			$(to_element).find('option[value="'+ data_attr.trim() +'"]').prop('selected', true);
			
			if(multi == false) {
				getBMInfomation(data_value);
			}
			
			if(boundary != '') {
				$.queue(getRMListBoundary(boundary, data_value, '', true));
			}
				
		});
		
	}
	
	function event_editChange(element, to_element, loadList) {
		
		$(element).change(function() {
			var data_attr  = $(element + ' option:selected').attr('data-attr');
			var data_value = $(element + ' option:selected').val();
			$(to_element).find('option[value="'+ data_attr.trim() +'"]').prop('selected', true);
			
			if(loadList == true) {
				fnLoadRMList('#edit_tl_ref1_selected', data_value, true, true);	     		
			}
				
		})
		
	}
	
	function changeAssignment(element, to_elementcode, to_elementname) {		
		$(element).change(function() { setEmpReference(element, to_elementcode, to_elementname); });
	}
	
	function setEmpReference(element, to_elementcode, to_elementname) {
		
		$.ajax({
            url: pathFixed + 'dataloads/empInfoInitialyze?_=' + new Date().getTime(),
            type: 'POST',
            data: {
            	eidx: $(element).val(),
                chc: true
            },
            success:function(responsed) {
            	console.log(responsed);       	
                if(responsed['status']) {
                	
                	$(to_elementname).val(responsed['data'][0].FullnameTh);
                	$(to_elementcode).val(responsed['data'][0].EmployeeCode);
                	
                	console.log([$(to_elementcode).val(), $(to_elementname).val()]);
                	
            	} else {
            		$(to_elementname).val('');
            		$(to_elementcode).val('');
            	}
 
            },
            cache: true,
            timeout:5000,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                407: function() {
    	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
    	        }
            }
        });
		
	}
	
	function getBMInfomation(branch_code) {
	
		$.ajax({
            url: pathFixed + 'dataloads/empInfoInitialyze?_=' + new Date().getTime(),
            type: 'POST',
            data: {
                brnx: branch_code,
                chc: true
            },
            success:function(responsed) {
            	            	
                if(responsed['status']) {
                	
                	$('#add_tl_ref1, #edit_tl_ref1').val(responsed['data'].FullnameTh);
                	$('#add_tl_ref1_code, #edit_tl_ref1_code').val(responsed['data'].EmployeeCode);
                	
                	$('input[name^="selectItemadd_tl_ref1_selected"][value="' + responsed['data'].EmployeeCode + '"]').click();
                	$('input[name^="selectItemedit_tl_ref1_selected"][value="' + responsed['data'].EmployeeCode + '"]').click();
                	
                	console.log($('#add_tl_ref1_code, #edit_tl_ref1_code').val());
                	
                	console.log($('input[name^="selectItemadd_tl_ref1_selected"][value="' + responsed['data'].EmployeeCode + '"]').click());
                	console.log($('input[name^="selectItemedit_tl_ref1_selected"][value="' + responsed['data'].EmployeeCode + '"]').click());
                	
            	} else {
            		$('#add_tl_ref1, #edit_tl_ref1').val('');
                	$('#add_tl_ref1_code, #edit_tl_ref1_code').val('');
                	
                	$('input[name^="selectItemadd_tl_ref1_selected"][value=""]').find('option[value=""]').click();
                	$('input[name^="selectItemedit_tl_ref1_selected"][value=""]').find('option[value=""]').click();
                	
            	}
 
            },
            cache: true,
            timeout:5000,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                407: function() {
    	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
    	        }
            }
        });
		
	}
	
	function getAssignmentInfomation(branch_code, empcode = '') {
		
		$.ajax({
            url: pathFixed + 'dataloads/empInfoInitialyze?_=' + new Date().getTime(),
            type: 'POST',
            data: {
                brnx: branch_code,
                eidx: empcode,
                chc: true
            },
            success:function(responsed) {
            	            	
                if(responsed['status']) {
                	
                	$('#add_tl_ref1, #edit_tl_ref1').val(responsed['data'][0].FullnameTh);
                	$('#add_tl_ref1_code, #edit_tl_ref1_code').val(responsed['data'][0].EmployeeCode);
                	
                	$('input[name^="selectItemadd_tl_ref1_selected"][value="' + responsed['data'][0].EmployeeCode + '"]').click();
                	$('input[name^="selectItemedit_tl_ref1_selected"][value="' + responsed['data'][0].EmployeeCode + '"]').click();
                	
                	console.log($('#add_tl_ref1_code, #edit_tl_ref1_code').val());
                	
                	console.log($('input[name^="selectItemadd_tl_ref1_selected"][value="' + responsed['data'][0].EmployeeCode + '"]').click());
                	console.log($('input[name^="selectItemedit_tl_ref1_selected"][value="' + responsed['data'][0].EmployeeCode + '"]').click());
                	
            	} else {
            		$('#add_tl_ref1, #edit_tl_ref1').val('');
                	$('#add_tl_ref1_code, #edit_tl_ref1_code').val('');
                	
                	$('input[name^="selectItemadd_tl_ref1_selected"][value=""]').find('option[value=""]').click();
                	$('input[name^="selectItemedit_tl_ref1_selected"][value=""]').find('option[value=""]').click();
                	
            	}
 
            },
            cache: true,
            timeout:5000,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                407: function() {
    	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
    	        }
            }
        });
		
	}
	
	function getTLABelongToBranch(element, multi) {
		$.ajax({
            url: pathFixed + 'dataloads/getTLABelongToBranch?_=' + new Date().getTime(),
            type: 'GET',
            success:function(responsed) {
            	
            	if(responsed['status']) {
            		
            		for(var indexed in responsed['data']) {
    					$(element).append('<option value="' + responsed['data'][indexed]['TLA_BranchName'].trim() + '">' + responsed['data'][indexed]['TLA_BranchName'] + '</option>');
    				}
            		
            		if(multi == true) {
    	        		$(element).find('option[value=""]').remove();
    	        		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
    	        	}            		
            		
            	}
	
            },
            cache: true,
            timeout:5000,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                407: function() {
    	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
    	        }
            }
            
        });
	}
	
	function fnLoadRMList(element, elemValue, multi, option = false) {
	
		$.ajax({
			url: pathFixed+'dataloads/getEmpListSpecify?_=' + new Date().getTime(),
			type: "POST",
			data: { branchcode: [elemValue] },
			success:function(responsed) {								
				console.log(responsed);
				$(element).empty();
		        for(var indexed in responsed['data']) {
			        if(responsed['data'][indexed]['FullNameTh'] == '') { continue; } 
			        else { 
				        $(element).append('<option value="' + responsed['data'][indexed]['EmployeeCode'] + '">' + ' (' + responsed['data'][indexed]['User_Role'] + ') ' + responsed['data'][indexed]['FullNameTh'] + ' (' + responsed['data'][indexed]['BranchDigit'] + ')' + '</option>');	    				
			        }
		        }
		        
				if(multi == true) {
					$(element).change(function() { }).multipleSelect({ width: '100%', filter: true, single: option });
				}
			
			},
			cache: false,
			timeout: 5000,
			statusCode: {
				404: function() {
					alert( "page not found" );
				},
				407: function() {
				    console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
				}
			}
					
		});  
	}
	
	function getTLABranchAutoComplete(element) {
		$.ajax({
            url: pathFixed + 'dataloads/getTLABelongToBranch?_=' + new Date().getTime(),
            type: 'GET',
            success:function(responsed) {
            	
            	if(responsed['status']) {
            		
            		 var objData = [];
                     for(var indexed in responsed['data']) {                     
                         objData.push({ 'label': responsed['data'][indexed]['TLA_BranchName'].trim(), 'value': responsed['data'][indexed]['TLA_BranchName'] });
                     }

                     $(element).autocomplete({ source: objData });          		
            		
            	}
	
            },
            cache: true,
            timeout:5000,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                407: function() {
    	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
    	        }
            }
            
        });
	}
	
	function getTLAPositionTitle(element, multi) {
		$.ajax({
            url: pathFixed + 'dataloads/getTLAPositionTitle?_=' + new Date().getTime(),
            type: 'GET',
            success:function(responsed) {
            	
            	if(responsed['status']) {
            		
            		for(var indexed in responsed['data']) {
    					$(element).append('<option value="' + responsed['data'][indexed]['TLA_Position'].trim() + '">' + responsed['data'][indexed]['TLA_Position'] + '</option>');
    				}
            		
            		if(multi == true) {
    	        		$(element).find('option[value=""]').remove();
    	        		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
    	        	}
            		
            		
            	}
	
            },
            cache: true,
            timeout:5000,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                407: function() {
    	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
    	        }
            }
            
        });
	}
	
	function getMasterTLAStatusList(element, data, multi, value = '') {
		$.ajax({
            url: pathFixed + 'dataloads/getMasterTLAStatusList?_=' + new Date().getTime(),
            type: 'POST',
            data: {
            	unstatus: (data !== '') ? data:''
            },
            success:function(responsed) {
            	
            	if(responsed['status']) {
            		
            		$(element).empty();
            		for(var indexed in responsed['data']) {
    					$(element).append('<option value="' + responsed['data'][indexed]['TL_Status'].trim() + '">' + responsed['data'][indexed]['TL_Status'] + '</option>');
    					
    				}
            		
            		if(value !== '') $(element).find('option[value="' + value + '"]').prop('selected', true);
            		
            		if(multi == true) {
    	        		$(element).find('option[value=""]').remove();
    	        		$(element).change(function() { }).multipleSelect({ width: '100%', filter: true });
    	        	}
            		
            		
            	}
	
            },
            cache: true,
            timeout:5000,
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                407: function() {
    	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
    	        }
            }
            
        });
	}
	
});