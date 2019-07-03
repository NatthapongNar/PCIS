$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    var rootFixed = window.location.protocol + "//" + window.location.host + '/pcis';
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    var query  = getQueryParams(document.location.search);
    
    // Object Date
    var str_date;
    var objDate = new Date();
    str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();   // Set Date format DD/MM/YYYY
    
    // Object 
    var objrmprocess   = $("#rmprocess");
    var objrmprocdate  = $("#rmprocessdate");
    		
    // Calendar Component By Metro UI
    //var objrmprocsdate  = $("#ClndrRMPD");
    var objemsdate	   = $('#ClndrEMSDate');
    var objrevisitdate = $('#ClndrRevPlan');
    
    // NCB - RES 1
    var objcheckncb	   = $('#objNCBChecked_1');
    var objlbsenttohq  = $('#objLBSentToHQ_1');
    var objreceivedlb  = $('#objReceivedFromLB_1');
    var objhqtooper	   = $('#objHQToOper_1');
    var objoperreturn  = $('#objOperReturn_1');
    var plan_apptoca   = $('#parent_plan_a2ca');
    
    plan_apptoca.Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    
    /*
    var defense_date   = $('#objdefense_date');
    defense_date.Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    */
    //objrmprocsdate.Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    //objrevisitdate.Datepicker({ format: "dd/mm/yyyy", effect: "slide",  position: "bottom" });
    //objoperreturn.Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    objemsdate.Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    objcheckncb.Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    objlbsenttohq.Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });  
    if($('#ReceivedFromLB_1').attr('data-role') != 'hqonly') {
    	 objreceivedlb.Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    	 objhqtooper.Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    }
   
    
    
    var table_ncb_refer = $('#expense_table_ncbrefer > tbody tr.item_ncbrefer').length;
    var i = 1;
    if(table_ncb_refer > 0) {
    	
    	$('#expense_table_ncbrefer > tbody tr.item_ncbrefer').each(function() {
    		
    	   $('#objNCBChecked_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	       $('#objLBSentToHQ_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	       //$('#objOperReturn_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	      
	       if($('#ReceivedFromLB_' + i).attr('data-role') != 'hqonly') {
	    	   $('#objReceivedFromLB_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	    	   $('#objHQToOper_' + i).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	   	
	       }
		   
	       i++;
	       
    	});
    }
    
    var table_relation = $('#expense_table_relation > tbody tr.item_relation').length;
    var n = 1;
    if(table_relation > 0) {
    	
    	$('#expense_table_relation > tbody tr.item_relation').each(function() {
    	   $('#objSTBH_' + n).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	      
	       //$('#objCAR_' + n).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	       if($('#Relation_RVD_' + n).attr('data-role') != 'hqonly') {
	    	   $('#objRVD_' + n).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
		       $('#objHCA_' + n).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	    	   	
	       }
		   	       
	       n++;
    	});
    }
    
    var table_docmanage = $('#expense_table_docmanagement > tbody tr.item_docmange').length;
    var m = 1;
    var v = 0;
    if(table_docmanage > 0) {
    	
 	   $('#expense_table_docmanagement > tbody tr.item_docmange').each(function() {
 		   
 		   var list_hidden = $('input[name^="docList_hidden"]').map(function() { return $(this).val(); });
 		   
 		   $('select[name^="DocList"]').each(function() {
 			   $(this).find('option[value="'+list_hidden[v]+'"]').attr('selected', 'selected');
 		   });

 		   
 		   $('#objSubHQ_' + m).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
 		   
 		   if($('#objDRVD_' + m).attr('data-role') != 'hqonly') {
 			   $('#objDRVD_' + m).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
 		       $('#objHQC_' + m).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
 		       $('#objCAH_' + m).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
 		       $('#objHQL_' + m).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
 		       $('#objLBR_' + m).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
 		       //$('#objCA_' + m).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
	    	   	
	       }

	       m++;
	       v++;
	 	});
    }
    
    var ncb_check = $('#NCBResult_1 option:selected').val();
	var cust_type = $('#NCBRelation_1 option:selected').val();
	if(cust_type == '101') {		
	
		if(in_array(ncb_check, [2, 0])) {
			
//			var str_date;
//    		var objDate = new Date();
//    		str_date = ('0' + objDate.getDate()).slice(-2) + '/' + ('0' + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();

    		$('#rmprocess').css('background', '#EBEBE7').prop('disabled', true);
    		$('#rmprocess').find('option[value=""]').prop('selected', true);
    		$('#rmprocessdate, #rmprocessdate_fake, #rmprocessdate_draft').val();
			$('#plan_a2ca').val('').prop('disabled', true);

			$('#defenseByRM').prop('checked', false).prop('disabled', true).css('background', '#EBEBE7');
			$('#defenseBySFE').prop('checked', false).prop('disabled', true).css('background', '#EBEBE7');		
			$('#defend_process').prop('disabled', true).css('background', '#EBEBE7');
			$('#defend_process').find('option[value=""]').prop('selected', true);	
			$('#defend_date, #defend_date_disbled').val('');
			
			$('#reactivate').find('option[value=""]').prop('selected', true);	
			$('#reactivate').css('background', '#EBEBE7').prop('disabled', true);
			$('#reactivate_plan').val('');												
			$('#retrieve_reason').find('option[value=""]').prop('selected', true);	
			$('#retrieve_reason').css('background', '#EBEBE7').prop('disabled', true);
			$('#retrieveDate, #objRetrieveDate').val('');
			$('#actionnote').prop('disabled', true);

			$('#parent_plan_a2ca').unbind('click');
			$('#expense_table_relation .item_relation').addClass('hide');
			
			setTimeout(function() {
				$('#rmprocess').css('background', '#EBEBE7').prop('disabled', true);
	    		$('#rmprocess').find('option[value=""]').prop('selected', true);
	    		$('#rmprocessdate, #rmprocessdate_fake, #rmprocessdate_draft').val();
	    		$('#actionnote').prop('disabled', true);
				console.log($('#defend_process').find('option[value=""]').prop('selected', true));
			}, 4000)
			
		
		} else {

			var rmprocess = $('#rmprocess').val();
			var rmondate  = $('#rmprocessdate_draft').val();
			if(rmprocess == '' && rmondate == '') {
				$('#rmprocess').css('background', '#FFFFFF').prop('disabled', false);
				$('#rmprocess').find('option[value=""]').prop('selected', true);
				$('#rmprocessdate, #rmprocessdate_fake, #rmprocessdate_draft').val('');
				
				$('#plan_a2ca').val('').prop('disabled', false);
				
				$('#defenseByRM').prop('disabled', false).css('background', '#FFFFFF');
				$('#defenseBySFE').prop('disabled', false).css('background', '#FFFFFF');
				$('#defend_process').prop('disabled', false).css('background', '#FFFFFF');
				$('#defend_process').find('option[value=""]').prop('selected', true);	
				$('#defend_process').css('background', '#FFFFFF').prop('disabled', false);
				$('#defend_date, #defend_date_disbled').val('');	
				
				if(in_array(rmprocess, ['CANCELBYRM', 'CANCELBYCUS', 'CANCELBYCA'])) {
					$('#reactivate').find('option[value=""]').prop('selected', true);	
					$('#reactivate').css('background', '#FFFFFF').prop('disabled', false);
					$('#reactivate_plan').val('');												
					$('#retrieve_reason').find('option[value=""]').prop('selected', true);	
					$('#retrieve_reason').css('background', '#FFFFFF').prop('disabled', false);
					$('#retrieveDate, #objRetrieveDate').val('');
				} else {
					$('#reactivate').css('background', '#EBEBE7').prop('disabled', true);
					$('#retrieve_reason').css('background', '#EBEBE7').prop('disabled', true);
				}
							
				$('#actionnote').prop('disabled', false);

				$('#root_plan_a2ca').html('<label id="label_plan_a2ca" class="span4">A2CA Plan Date</label><div id="parent_plan_a2ca" class="input-control text span6" style="margin-left: 20px;"><input id="plan_a2ca" name="plan_a2ca" type="text" value="" readonly="readonly" style="max-width: 180px;"></div>');
				$('#parent_plan_a2ca').Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
				$('#expense_table_relation .item_relation').removeClass('hide');
				
			}			
	
		}
	}
    
    // Reconcile Document

    
    
    // Field Validation
    $('#id_card').change(function() { CheckLengthValidator('id_card', 'id_card_alert', '13'); });
    

    // NEXT STEP VALIDATION
    var identify_card = $('#id_card').val();
	if(identify_card != '') { $('#flagno').val('2'); } 
	
	$('input[name="on_helf"]').on('click', function() {
		var on_behalf = $('input[name="on_helf"]:checked').val();
		if(on_behalf == 1) { $('#label_idcard').text('ID Card'); } 
		else if(on_behalf == 2) { $('#label_idcard').text('Business Registration'); }
		
		
	});
   
    $('#submitVerificationForm').on('click', function() {
    	 //$('#verification_forms').submit();
    	$('#onprocess').click();
    });	
    	
    var rmprocess	   = $('select[name="rmprocess"] option:selected').val();
	var rmreason	   = $('select[name="rmprocess_reason"] option:selected').val();
	
	$('#rmprocess').change(function() {
		 var select_rmprocess  = $('select[name="rmprocess"] option:selected').val();
		 $('#rmprocess_draft').val(select_rmprocess);
		
	});
	
	var branchCode = $('#BranchCode').val();
	$('#verification_forms').submit(function() {
		
		var re_activate 		= $('select[name="reactivate"] option:selected').val();
		var re_activate_plan	= $('#reactivate_plan').val();
		
    	var on_half		   = $('input[name="on_helf"]:checked').val();
    	var id_card		   = $('#id_card').val();
    	var flag_checked   = $('#flagno').val();
    	var rmprocess	   = $('select[name="rmprocess"] option:selected').val();
    	var rmreason	   = $('select[name="rmprocess_reason"] option:selected').val();
    	
		if(confirm('กรุณายืนยันการบันทึกข้อมูล')) {
			
			if(on_half == "" || on_half == undefined) {
    			$('#label_onbehalf').addClass('text-danger');
	    		var not = $.Notify({ content: "กรุณาระบุประเภทของผู้กู้ว่ากู้เข้ามาในนามของ บุคคล หรือ นิติบุคคล.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	    		$('input[name="on_helf"]').parent().addClass('text-danger');
				not.close(7000);
				
				return false;
    		}
			
			if($('#reactivate').val() != null && re_activate_plan == "") {
				
	    		var not = $.Notify({ content: "กรุณาระบุวันที่จะติดต่อลูกค้าใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	    		$('#reactivate_plan').addClass('error-state');
				not.close(7000);
				
				return false;
			}
	    	
			var product_pmg  = $('select[name="productprg"] option:selected').val();
			var product_grp  = $('select[name="productprg"] option:selected').parent().attr('label');
			var loan_type 	 = $('select[name="loantypes"] option:selected').val();

			if(branchCode !== '000') {
				
				if(product_pmg !== "" && product_grp === 'Secure Loan') {
					if(loan_type === '') {
						var not = $.Notify({ content: "กรุณาระบุว่าหลักทรัพย์ Refinance หรือไม่", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
						not.close(7000);
			    		$('#loantypes').parent().addClass('error-state');
			    		
						return false;
					}				
				}
				
			}
					
			var elements = $('input[name^="NCBName"]').length;
			for(var i = 0; i < elements; i++) {
				
				var indexed = i + 1;
				if($("#NCBRelation_" + indexed).val() == "" || $("#NCBRelation_" + indexed).val() == undefined) {
    				
    				$("#NCBRelation_" + indexed).parent().addClass('error-state');
    				var not = $.Notify({ content: "กรุณาระบุประเภทของผู้กู้ให้ครบ.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
    				return false;
    				
    			} 
				
				if($("#NCBName_" + indexed).val() == "" || $("#NCBName_" + indexed).val() == undefined) {
    				
    				$("#NCBName_" + indexed).attr('data-state', 'error');
					var not = $.Notify({ content: "กรุณาระบุชื่อผู้กู้ให้ครบ.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
    				
    				return false;
				
				}
				
				if($("#NCBResult_" + indexed).val() == "" || $("#NCBResult_" + indexed).val() == undefined) {
    				
    				$("#NCBResult_" + indexed).parent().addClass('error-state');
					var not = $.Notify({ content: "กรุณาระบุผลการตรวจสอบ NCB.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
    				
    				return false;
				
				}
				
				if($("#NCBChecked_" + indexed).val() == "" || $("#NCBChecked_" + indexed).val() == undefined) {
    				
    				$("#NCBChecked_" + indexed).attr('data-state', 'error');
					var not = $.Notify({ content: "กรุณาระบุวันที่ตรวจสอบ NCB.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
    				
    				return false;
				
				}
				
				if($("#NCBChecked_" + indexed).val() == "" || $("#NCBChecked_" + indexed).val() == undefined) {
    				
    				$("#NCBChecked_" + indexed).attr('data-state', 'error');
					var not = $.Notify({ content: "กรุณาระบุวันที่ตรวจสอบ NCB.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
    				
    				return false;
				
				}
				
				// Modifier Request Loan on date 24/11/2015				
				if(branchCode != '000') {
					
					if($('#RequestLoan').val() == '' || $('#RequestLoan').val() == undefined || $('#RequestLoan').val() == 0) {
						//var not = $.Notify({ content: "ยังไม่มีการวงเงินที่ลุกค้าต้องการในระบบ กรุณาระบุวงเงินที่ลูกค้าต้องการ", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	    				//not.close(7000);
						
						$.Dialog({
	    		        	shadow: true,
	    		        	overlay: true,
	    		        	draggable: true,
	    			        icon: '<i class="fa fa-info"></i>',
	    			        title: 'Request Loan',
	    			        content: '',
	    			        padding: 10,
	    			        width: 350,
	    			        onShow: function(_dialog){
	    			           			        	
	    			        	var content = 
	    				        '<label class="label">กรุณาระบุยอดเงินที่ลูกค้าต้องการ เนื่องจากไม่มีการระบุวงเงินในกระบวนการก่อนหน้านี้.</label>' +
	    				        '<div class="input-control text">' +
	    					        '<input type="text" id="requestloan_p1" name="requestloan_p1">' +
	    					        '<button class="btn-clear"></button>' +
	    				        '</div>' +
	    				        '<div class="form-actions">' +
	    					        '<button class="button primary" id="requestLoan_submit">Submit</button> '+
	    					        '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
	    				        '</div>';
	    			        	
	    			        	
	    				        $.Dialog.content(content);
	    			        }
	    		        });
						
						$('#requestloan_p1').number(true, 0);
						
						$('#requestLoan_submit').on('click', function() { 
		    				
	    					var request_loan = $('#requestloan_p1').val();
	    					if (request_loan != '') {      					
	        	        		document.getElementById("RequestLoan").value = request_loan;
	        					$.Dialog.close();
	        				    
	        				} else {
	        					$('#requestloan_p1').attr('data-state', 'error');
	    	    	    		var not = $.Notify({ content: "กรุณาระบุวงเงินที่ลุกค้าต้องการ.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	    	    				not.close(7000);        					
	        				}
	    					
	    					    					
	    				});
				         					
						return false;			

					}
					
				} 	

				if(id_card.length <  13) {
					
					$('#identityListModal').modal({
			  			 show: true,
			   			 keyboard: false,
			   			 backdrop: 'static'
					}).draggable();		    	
			    	
    				
    				/* 				
    				$.Dialog({
    		        	shadow: true,
    		        	overlay: true,
    		        	draggable: true,
    			        icon: '<i class="icon-credit-card"></i>',
    			        title: '',
    			        content: '',
    			        padding: 10,
    			        width: 350,
    			        onShow: function(_dialog){
    			        	
    			        	var label_lock = $('input[name="on_helf"]:checked').val();
    			        	if(label_lock == '1') {
    			        		var label_th 	= 'กรุณาระบุเลขบัตรประชาชนของผู้กู้หลัก.';
    			        		var label_field = 'ID Card';
    			        	} else {
    			        		var label_th = 'กรุณาระบุเลขทะเบียนการค้าของผู้กู้หลัก.';
    			        		var label_field = 'Business Registration Number';
    			        	}
    			        	
    			        	var content = 
    			        	'<p>' + label_th + '</p>'+
    				        '<label class="label">' + label_field + '</label>' +
    				        '<div class="input-control text">' +
    					        '<input type="text" id="cardno" name="cardno" maxlength="13">' +
    					        '<button class="btn-clear"></button>' +
    				        '</div>' +
    				        '<div class="form-actions">' +
    					        '<button class="button primary" id="people_submit">Submit</button> '+
    					        '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
    				        '</div>';
    				         
    				        $.Dialog.content(content);
    			        }
    		        });

    				
    				$('#people_submit').on('click', function() { 
    				
    					var card_no = $('#cardno').val();
    					if (card_no != null) {
        					
        					if(card_no.length < 13) {
        						
        						$('#id_card_alert').text('กรุณาระบุเลขบัตรประชาชนให้ครบ 13  หลัก.');
        	    	    		var not = $.Notify({ content: "กรุณาระบุเลขบัตรประชาชนให้ครบ 13  หลัก.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        	    				not.close(7000);
        	    				
        					} else {
        						if(card_no.length > 13) {
        							
        							$('#id_card_alert').text('ท่านระบุเลขบัตรประชาชนเกิด 13  หลัก กรุณาตรวจสอบอีกครั้ง.');
            	    	    		var not = $.Notify({ content: "ท่านระบุเลขบัตรประชาชนเกิด 13  หลัก กรุณาตรวจสอบอีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            	    				not.close(7000);
            	    				
        						} else {
        							$('#id_card').attr('data-state', 'success');
        							document.getElementById("id_card").value = card_no;
        							$.Dialog.close();
        						}
        						
        					}
        				    
        				}
    					
    					    					
    				});
    				
    				var cardno = $('#id_card').val();
    				if (cardno != null) {
    					
    					if(cardno.length < 13) {
    						
    						$('#id_card_alert').text('กรุณาระบุเลขบัตรประชาชนให้ครบ 13  หลัก.');
    	    	    		var not = $.Notify({ content: "กรุณาระบุเลขบัตรประชาชนให้ครบ 13  หลัก.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    	    				not.close(7000);
    	    				
    					} else {
    						if(cardno.length > 13) {
    							
    							$('#id_card_alert').text('ท่านระบุเลขบัตรประชาชนเกิด 13  หลัก กรุณาตรวจสอบอีกครั้ง.');
        	    	    		var not = $.Notify({ content: "ท่านระบุเลขบัตรประชาชนเกิด 13  หลัก กรุณาตรวจสอบอีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        	    				not.close(7000);
        	    				
    						} else {
    							$('#id_card').attr('data-state', 'success');
    							document.getElementById("id_card").value = cardno;
    						}
    						
    					}
    				    
    				}
    				*/
					
    				return false;
    	    	}
	    		
			}
			
    		if(flag_checked == 1) {
    			
    			if(id_card.length <  13) {
    				
    				$('#identityListModal').modal({
			  			 show: true,
			   			 keyboard: false,
			   			 backdrop: 'static'
					}).draggable();	
    				
    				/*
    				$.Dialog({
    		        	shadow: true,
    		        	overlay: true,
    		        	draggable: true,
    			        icon: '<i class="icon-credit-card"></i>',
    			        title: '',
    			        content: '',
    			        padding: 10,
    			        width: 350,
    			        onShow: function(_dialog){
    			        	var label_lock = $('input[name="on_helf"]:checked').val();
    			        	if(label_lock == '1') {
    			        		var label_th 	= 'กรุณาระบุเลขบัตรประชาชนของผู้กู้หลัก.';
    			        		var label_field = 'ID Card';
    			        	} else {
    			        		var label_th = 'กรุณาระบุเลขทะเบียนการค้าของผู้กู้หลัก.';
    			        		var label_field = 'Business Registration Number';
    			        	}
    			        	
    			        	var content = 
    			        	'<p>' + label_th + '</p>'+
    				        '<label class="label">' + label_field + '</label>' +
    				        '<div class="input-control text">' +
    					        '<input type="text" id="cardno" name="cardno" maxlength="13">' +
    					        '<button class="btn-clear"></button>' +
    				        '</div>' +
    				        '<div class="form-actions">' +
    					        '<button class="button primary" id="people_submit">Submit</button> '+
    					        '<button class="button" type="button" onclick="$.Dialog.close()">Cancel</button> '+
    				        '</div>';
    				         
    				        $.Dialog.content(content);
    			        }
    		        });

    				
    				$('#people_submit').on('click', function() { 
    				
    					var card_no = $('#cardno').val();
    					if (card_no != null) {
        					
        					if(card_no.length < 13) {
        						
        						$('#id_card_alert').text('กรุณาระบุเลขบัตรประชาชนให้ครบ 13  หลัก.');
        	    	    		var not = $.Notify({ content: "กรุณาระบุเลขบัตรประชาชนให้ครบ 13  หลัก.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        	    				not.close(7000);
        	    				
        					} else {
        						if(card_no.length > 13) {
        							
        							$('#id_card_alert').text('ท่านระบุเลขบัตรประชาชนเกิด 13  หลัก กรุณาตรวจสอบอีกครั้ง.');
            	    	    		var not = $.Notify({ content: "ท่านระบุเลขบัตรประชาชนเกิด 13  หลัก กรุณาตรวจสอบอีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            	    				not.close(7000);
            	    				
        						} else {
        							$('#id_card').attr('data-state', 'success');
        							document.getElementById("id_card").value = card_no;
        							$.Dialog.close();
        						}
        						
        					}
        				    
        				}
    					
    					    					
    				});
    				
    				var cardno = $('#id_card').val();
    				if (cardno != null) {
    					
    					if(cardno.length < 13) {
    						
    						$('#id_card_alert').text('กรุณาระบุเลขบัตรประชาชนให้ครบ 13  หลัก.');
    	    	    		var not = $.Notify({ content: "กรุณาระบุเลขบัตรประชาชนให้ครบ 13  หลัก.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    	    				not.close(7000);
    	    				
    					} else {
    						if(cardno.length > 13) {
    							
    							$('#id_card_alert').text('ท่านระบุเลขบัตรประชาชนเกิด 13  หลัก กรุณาตรวจสอบอีกครั้ง.');
        	    	    		var not = $.Notify({ content: "ท่านระบุเลขบัตรประชาชนเกิด 13  หลัก กรุณาตรวจสอบอีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        	    				not.close(7000);
        	    				
    						} else {
    							$('#id_card').attr('data-state', 'success');
    							document.getElementById("id_card").value = cardno;
    						}
    						
    					}
    				    
    				}
    				*/
    				
    				return false;
    	    	}

    			return true;
    			
    		} else {
    			    			
    			if(flag_checked == 2) {
    				
    		
    				var c = 1;
    				var objNCBValid = [];
    				var objNCBFieldValid = [];
    				$('input[name^="NCBResultDate"]').each(function() {
    				
    					var date_checker   = ($('#NCBChecked_' + c).val()).split("/").reverse().join("-");
    					var date_lbsent    = ($('#LBSentToHQ_' + c).val()).split("/").reverse().join("-");
    					var date_received  = ($('#ReceivedFromLB_' + c).val()).split("/").reverse().join("-");
    					var date_hqtooper  = ($('#HQToOper_' + c).val()).split("/").reverse().join("-");
  
    					// Check By Sequen
        		    	if( fnDateCompared(date_checker, date_lbsent) ) {
        		    		$('#NCBChecked_' + c).attr('data-state', 'error');
        		    		$('#LBSentToHQ_' + c).attr('data-state', 'error');
        		    		
        		    		$('#ReceivedFromLB_' + c).css('border-color', '#60a917');
        		    		$('#HQToOper_' + c).css('border-color', '#60a917');
        		    		
            				var not = $.Notify({ content: "ขออภัย! ในส่วน NCB Verification ท่านระบุรูปแบบวันที่ผิด [ ระหว่างวันที่ตรวจสอบ NCB กับ วันที่ส่งเอกสารเข้า สนญ. ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            				not.close(7000);
            				objNCBValid.push('FALSE');
           
            				return false;
            				
        		    	} else { objNCBValid.push('TRUE'); }
        		    	        		    
        		    	if( fnDateCompared(date_lbsent, date_received) ) {
        		    		$('#LBSentToHQ_' + c).attr('data-state', 'error');
        		    		$('#ReceivedFromLB_' + c).css('border-color', '#e51400');
        		    		
        		    		$('#NCBChecked_' + c).attr('data-state', 'success');
        		    		$('#HQToOper_' + c).css('border-color', '#60a917');
        		    		
            				var not = $.Notify({ content: "ขออภัย! ในส่วน NCB Verification ท่านระบุรูปแบบวันที่ผิด  [ ระหว่างวันที่ส่งเอกสารเข้า สนญ กับ วันที่ สนญ. รับเอกสาร  ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            				not.close(8000);
            				objNCBValid.push('FALSE');
           
            				return false;
            				
        		    	} else { objNCBValid.push('TRUE'); }
        		    	
        		    	if( fnDateCompared(date_received, date_hqtooper) ) {
        		    		$('#ReceivedFromLB_' + c).css('border-color', '#e51400');
        		    		$('#HQToOper_' + c).css('border-color', '#e51400');
        		    		
        		    		$('#NCBChecked_' + c).attr('data-state', 'success');
        		    		$('#LBSentToHQ_' + c).attr('data-state', 'success');
        		    		
            				var not = $.Notify({ content: "ขออภัย! ในส่วน NCB Verification ท่านระบุรูปแบบวันที่ผิด  [ ระหว่าง วันที่ สนญ. รับเอกสาร   กับ  วันที่ สนญ ส่งเอกสารไปยังทีม Operation ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            				not.close(8000);
            				objNCBValid.push('FALSE');
           
            				return false;
            				
        		    	} else { objNCBValid.push('TRUE'); }
    					
        		    	// Check NCB and Other Validation Next Sequen
        		    	if( fnDateCompared(date_checker, date_received) ) {
        		    		$('#NCBChecked_' + c).attr('data-state', 'error');
        		    		$('#ReceivedFromLB_' + c).css('border-color', '#e51400');
        		    		
        		    		$('#LBSentToHQ_' + c).attr('data-state', 'success');
        		    		$('#HQToOper_' + c).css('border-color', '#60a917');
        		    		
            				var not = $.Notify({ content: "ขออภัย! ในส่วน NCB Verification ท่านระบุรูปแบบวันที่ผิด [ ระหว่างวันที่ตรวจสอบ NCB กับ วันที่รับ สนญ เอกสาร. ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            				not.close(8000);
            				objNCBValid.push('FALSE');
           
            				return false;
            				
        		    	} else { objNCBValid.push('TRUE'); }
        		    	
        		    	if( fnDateCompared(date_checker, date_hqtooper) ) {
        		    		$('#NCBChecked_' + c).attr('data-state', 'error');
        		    		$('#ReceivedFromLB_' + c).css('border-color', '#60a917');
        		    		
        		    		$('#LBSentToHQ_' + c).attr('data-state', 'success');
        		    		$('#HQToOper_' + c).css('border-color', '#e51400');
        		    		
            				var not = $.Notify({ content: "ขออภัย! ในส่วน NCB Verification ท่านระบุรูปแบบวันที่ผิด [ ระหว่างวันที่ตรวจสอบ NCB กับ วันที่ สนญ ส่งเอกสารไปยังทีม Operation ] กรุณาตรวจสอบใหม่อีกครั้ง .", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            				not.close(8000);
            				objNCBValid.push('FALSE');
           
            				return false;
            				
        		    	} else { objNCBValid.push('TRUE'); }
        		    	
        		    	// LB and Other by Validation Next Sequen
        		    	if( fnDateCompared(date_lbsent, date_hqtooper) ) {
        		    		$('#LBSentToHQ_' + c).attr('data-state', 'error');
        		    		$('#HQToOper_' + c).css('border-color', '#e51400');
        		    		        		    		
        		    		$('#NCBChecked_' + c).attr('data-state', 'success');
        		    		$('#ReceivedFromLB_' + c).css('border-color', '#60a917');
        		    		
            				var not = $.Notify({ content: "ขออภัย! ในส่วน NCB Verification ท่านระบุรูปแบบวันที่ผิด [ ระหว่างวันที่ส่งเอกสารเข้า สนญ. กับ วันที่ สนญ ส่งเอกสารไปยังทีม Operation ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            				not.close(8000);
            				objNCBValid.push('FALSE');
           
            				return false;
            				
        		    	} else { objNCBValid.push('TRUE'); }
        		    	        		    	
        		    	
        		    	// Check field equal null  
        		    	        		          		    	        		    	
        		    	if( fnDateValidation(date_lbsent, date_received) ) {
        		    		$('#LBSentToHQ_' + c).attr('data-state', 'error');
        		    		$('#ReceivedFromLB_' + c).css('border-color', '#e51400');
        		    		
        		    		$('#NCBChecked_' + c).attr('data-state', 'success');
        		    		$('#HQToOper_' + c).css('border-color', '#60a917');
        		    		
            				var not = $.Notify({ content: "กรุณาตรวจสอบวันที่มีการรับเอกสารก่อนหน้านี้ครบถ้วนแล้วหรือไม่.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            				not.close(8000);
            				objNCBFieldValid.push('FALSE');
           
            				return false;
            				
        		    	} else { objNCBFieldValid.push('TRUE'); }
        		    	
        		    	if( fnDateValidation(date_received, date_hqtooper) ) {
        		    		$('#ReceivedFromLB_' + c).css('border-color', '#e51400');
        		    		$('#HQToOper_' + c).css('border-color', '#e51400');
        		    		
        		    		$('#NCBChecked_' + c).attr('data-state', 'success');
        		    		$('#LBSentToHQ_' + c).attr('data-state', 'success');
        		    		
            				var not = $.Notify({ content: "กรุณาตรวจสอบวันที่มีการรับเอกสารก่อนหน้านี้ครบถ้วนแล้วหรือไม่.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            				not.close(8000);
            				objNCBFieldValid.push('FALSE');
           
            				return false;
            				
        		    	} else { objNCBFieldValid.push('TRUE'); }
        		    	
        		    	if( fnDateValidation(date_lbsent, date_hqtooper) ) {
        		    		$('#LBSentToHQ_' + c).attr('data-state', 'error');
        		    		$('#HQToOper_' + c).css('border-color', '#e51400');
        		    		        		    		
        		    		$('#NCBChecked_' + c).attr('data-state', 'success');
        		    		$('#ReceivedFromLB_' + c).css('border-color', '#60a917');
        		    		
            				var not = $.Notify({ content: "กรุณาตรวจสอบวันที่มีการรับเอกสารก่อนหน้านี้ครบถ้วนแล้วหรือไม่.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            				not.close(8000);
            				objNCBFieldValid.push('FALSE');
           
            				return false;
            				
        		    	} else { objNCBFieldValid.push('TRUE'); }
    					c++;
    	
    					
    				});
    				
    				if(in_array('FALSE', objNCBFieldValid)) {
    					return false;
    				}
 				
    				if(in_array('FALSE', objNCBValid)) {
    					return false
    					
    				} else {
    					
	    				var n = 1;
	    				var objValid = [];
	    				var objReconcileValid = []
	    				$('select[name^="Relation_ComplementionDoc"]').each(function() {
	    					
	    					var doc_avaliable = parseInt($('#completiondoc_hidden_' + n).val());
	    					if($('#Relation_Sel_' + n).val() == 'N' && parseInt($('#completiondoc_hidden_' + n).val()) == 0) {
	    						
	    						$('#CompletionDoc_' + n).css('border', '3px solid red').css('padding', '1px');
	    						var not = $.Notify({ content: "กรุณาเลือกรายการเอกสารทีขาด.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	    	    				not.close(8000);
	    	    				objValid.push('FALSE');
	    	    				return false;
	    						
	    					} else {
	    						objValid.push('TRUE');
	    					}
	    					
	    					var date_hqtooper   = ($('#HQToOper_' + n).val()).split("/").reverse().join("-");
	    					
	    					var doc_flow_stbh   = ($('#Relation_STBH_' + n).val()).split("/").reverse().join("-");
	    					var doc_flow_hqre   = ($('#Relation_RVD_' + n).val()).split("/").reverse().join("-");
	    					var doc_flow_hqca   = ($('#Relation_SubmitToCA_' + n).val()).split("/").reverse().join("-");
	    					
	    					var select_complete = $('#Relation_Sel_' + n + ' option:selected').val();
	    					
	    				
	        		    	if( fnDateCompared(doc_flow_stbh, doc_flow_hqre) ) {
	        		    		$('#Relation_STBH_' + n).attr('data-state', 'error');
	        		    		$('#Relation_RVD_' + n).css('border-color', '#e51400');
	 	        		    		
	            				var not = $.Notify({ content: "ขออภัย! ในส่วน Document Flow ท่านระบุรูปแบบวันที่ผิด [ ระหว่างวันที่ส่งเอกสารเข้า สนญ. กับ วันที่ สนญ รับเอกสาร. ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	            				not.close(8000);
	            				objValid.push('FALSE');
	           
	            				return false;
	            				
	        		    	} else { objValid.push('TRUE'); }
	        		    	
	        		    	if( fnDateCompared(doc_flow_stbh, doc_flow_hqca) ) {
	        		    		$('#Relation_STBH_' + n).attr('data-state', 'error');
	        		    		$('#Relation_SubmitToCA_' + n).css('border-color', '#e51400');
	 	        		    		
	            				var not = $.Notify({ content: "ขออภัย! ในส่วน Document Flow ท่านระบุรูปแบบวันที่ผิด  [ ระหว่างวันที่ส่งเอกสารเข้า สนญ. กับ วันที่ ส่งเอกสารเข้าทีม CA ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	            				not.close(8000);
	            				objValid.push('FALSE');
	           
	            				return false;
	            				
	        		    	} else { objValid.push('TRUE'); }
	        		    	
	        		    	if( fnDateCompared(doc_flow_hqre, doc_flow_hqca) ) {
	        		    		$('#Relation_RVD_' + n).css('border-color', '#e51400');
	        		    		$('#Relation_SubmitToCA_' + n).css('border-color', '#e51400');
	 	        		    		
	            				var not = $.Notify({ content: "ขออภัย! ในส่วน Document Flow ท่านระบุรูปแบบวันที่ผิด  [ ระหว่างวันที่ สนญ รับเอกสาร กับ  วันที่ สนญ. ส่งเอกสารเข้าทีม CA ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	            				not.close(8000);
	            				objValid.push('FALSE');
	           
	            				return false;
	            				
	        		    	} else { objValid.push('TRUE'); }
	        		    	
	        		    	
	        		    	// Check field equal null    	

	        		    	// Part: Reconcile Only	        		    		        		    	
	        		    	if( fnDateValidation(doc_flow_stbh, doc_flow_hqre) ) {
	        		    		$('#Relation_STBH_' + n).attr('data-state', 'error');
	        		    		$('#Relation_RVD_' + n).css('border-color', '#e51400');        
	 	        		    		
	            				var not = $.Notify({ content: "กรุณาตรวจสอบวันที่มีการรับเอกสาร ก่อนหน้านี้ครบถ้วนแล้วหรือไม่.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	            				not.close(8000);
	            				objReconcileValid.push('FALSE');
	           
	            				return false;
	            				
	        		    	} else { objReconcileValid.push('TRUE'); }
	        		    	
	        		    	if( fnDateValidation(doc_flow_stbh, doc_flow_hqca) ) {
	        		    		$('#Relation_STBH_' + n).attr('data-state', 'error');
	        		    		$('#Relation_SubmitToCA_' + n).css('border-color', '#e51400');
	 	        		    		
	            				var not = $.Notify({ content: "กรุณาตรวจสอบวันที่มีการรับเอกสารก่อนหน้านี้ครบถ้วนแล้วหรือไม่.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	            				not.close(8000);
	            				objReconcileValid.push('FALSE');
	           
	            				return false;
	            				
	        		    	} else { objReconcileValid.push('TRUE'); }
	        		    	
	        		    	
	        		    	if( fnDateValidation(select_complete, doc_flow_hqca) ) {
	        		    		$('#Relation_Sel_' + n).css('border-color', '#e51400');
	        		    		$('#Relation_SubmitToCA_' + n).css('border-color', '#e51400');
	 	        		    		
	            				var not = $.Notify({ content: "กรุณาตรวจสอบข้อมูลก่อนหน้านี้ว่าครบถ้วนแล้วหรือไม่.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	            				not.close(8000);
	            				objReconcileValid.push('FALSE');
	           
	            				return false;
	            				
	        		    	} else { objReconcileValid.push('TRUE'); }
	        		    	
	        		    	if( fnDateValidation(doc_flow_hqre, doc_flow_hqca) ) {
	        		    		$('#Relation_RVD_' + n).css('border-color', '#e51400');
	        		    		$('#Relation_SubmitToCA_' + n).css('border-color', '#e51400');
	 	        		    		
	            				var not = $.Notify({ content: "กรุณาตรวจสอบวันที่มีการรับเอกสารก่อนหน้านี้ครบถ้วนแล้วหรือไม่.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	            				not.close(8000);
	            				objReconcileValid.push('FALSE');
	           
	            				return false;
	            				
	        		    	} else { objReconcileValid.push('TRUE'); }
	        		    	
	    					n++;
	    					
	    				});	    				
	    				
	    				if(in_array('FALSE', objReconcileValid)) {
	    					return false;
	    				}
	 					   				
	    				if(in_array('FALSE', objValid)) {
	    					return false
	    				
	    				} else {
	    					//return true;
	    					
	    					var x = 1;
	        				var objValid_Plus = [];
	        				$('select[name^="Relation_ComplementionDoc"]').each(function() {
	        					/*
	        					var doc_avaliable = parseInt($('#completiondoc_hidden_' + x).val());
	        					if($('#Relation_Sel_' + x).val() == 'Y' && $('#completiondoc_hidden_' + x).val() >= 1) {
	        						
	        						$('#CompletionDoc_' + x).css('border', '3px solid red').css('padding', '1px');
	        						var not = $.Notify({ content: "ขออภัย! คุณยังมีเอกสารรายการที่ขาดค้างอยู่ในระบบ กรุณาตรวจสอบอีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	        	    				not.close(8000);
	        	    				objValid_Plus.push('FALSE');
	        	    				return false;
	        						
	        					} else {
	        						objValid_Plus.push('TRUE');
	        					}
	        					*/
	        				
		    					var doc_flow_stbh   = ($('#Relation_STBH_' + x).val()).split("/").reverse().join("-");
		    					var doc_flow_hqre   = ($('#Relation_RVD_' + x).val()).split("/").reverse().join("-");
		    					var doc_flow_hqca   = ($('#Relation_SubmitToCA_' + x).val()).split("/").reverse().join("-");
	        					
	        					if( fnDateCompared(doc_flow_stbh, doc_flow_hqre) ) {
		        		    		$('#Relation_STBH_' + n).attr('data-state', 'error');
		        		    		$('#Relation_RVD_' + n).css('border-color', '#e51400');
		 	        		    		
		            				var not = $.Notify({ content: "ขออภัย! ในส่วน Document Flow ท่านระบุรูปแบบวันที่ผิด [ ระหว่างวันที่ส่งเอกสารเข้า สนญ. กับ วันที่ สนญ รับเอกสาร. ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
		            				not.close(8000);
		            				objValid.push('FALSE');
		           
		            				return false;
		            				
		        		    	} else { objValid.push('TRUE'); }
		        		    	
		        		    	if( fnDateCompared(doc_flow_stbh, doc_flow_hqca) ) {
		        		    		$('#Relation_STBH_' + n).attr('data-state', 'error');
		        		    		$('#Relation_SubmitToCA_' + n).css('border-color', '#e51400');
		 	        		    		
		            				var not = $.Notify({ content: "ขออภัย! ในส่วน Document Flow ท่านระบุรูปแบบวันที่ผิด  [ ระหว่างวันที่ส่งเอกสารเข้า สนญ. กับ วันที่ ส่งเอกสารเข้าทีม CA ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
		            				not.close(8000);
		            				objValid.push('FALSE');
		           
		            				return false;
		            				
		        		    	} else { objValid.push('TRUE'); }
		        		    	
		        		    	if( fnDateCompared(doc_flow_hqre, doc_flow_hqca) ) {
		        		    		$('#Relation_RVD_' + n).css('border-color', '#e51400');
		        		    		$('#Relation_SubmitToCA_' + n).css('border-color', '#e51400');
		 	        		    		
		            				var not = $.Notify({ content: "ขออภัย! ในส่วน Document Flow ท่านระบุรูปแบบวันที่ผิด  [ ระหว่างวันที่ สนญ รับเอกสาร กับ  วันที่ สนญ. ส่งเอกสารเข้าทีม CA ] กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
		            				not.close(8000);
		            				objValid.push('FALSE');
		           
		            				return false;
		            				
		        		    	} else { objValid.push('TRUE'); }
	
	        					x++;
	        					
	        				});
	        				
	        				if(in_array('FALSE', objValid_Plus)) {
	        					return false
	        				
	        				} else {
	        					return true;
	        				}
	        				
	    				}
	    				
    				}
    				
    				return false;
    				
    			} else {
    				
    				// Validation Step 1 : First and last element
            		var max_element = $('input[name^="NCBName"]').length;
            		if($("#NCBRelation_" + max_element).val() != "" && $("#NCBName_" + max_element).val() != "" && $("#NCBResult_" + max_element).val() != "" && $("#NCBChecked_" + max_element).val() != "") {
            			return true;
            			
            		}
    							
    			}
    			
    			
    		}
    		
    	}
		
		return false;
	
    });
	
	$('#actionnote').on('focus', function() {
		var str_note = $(this).val();
		var date_default = '#' + moment().format('DDMM') + ' ';
		if(!str_note.includes(date_default)) {
			$(this).val(date_default);
		}
	});
	
	
	$('#actionnote').on('blur', function() {
		var str_note = $('#actionnote').val();
		var date_default = '#' + moment().format('DDMM') + ' ';
		if(str_note == date_default) {
			$(this).val('');
		}
	});
	
    
	// CLEAR ACTION NOTE
	$('#ActionOnCancel').on('click', function() { 
		
		if(confirm('กรุณายืนยันการล้างข้อมูลในฟิลด์ ')) {
//		if(confirm('กรุณายืนยันการลบข้อมูลในฟิลด์ ')) {
			
//			var check_disabled = $('#actionnote').attr('readonly');
//			if(typeof check_disabled !== typeof undefined && check_disabled !== false) {
//				 $('#actionnote').removeAttr('readonly').removeAttr('readonly').removeAttr('style');
//			}
//			
//			$('#action_flag').val('1');
			$('#actionnote').val('');
			
			return true;
			
		}
		
		return false;
		
	});
	
	/*
    //Action Note
    $('#actionnote').click(function() {
    	var check_disabled = $(this).attr('readonly');
    	if(typeof check_disabled !== typeof undefined && check_disabled !== false) {
    		var not = $.Notify({ content: 'กรุณากดปุ่มเคลีย์ข้อมูล เพื่อคีย์ข้อมูลใหม่.', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
			not.close(7000); 			
    	}    	
    });
	*/
	
	// SUBMIT ACTION NOTE
	var action_progress = $('#Action_Progresslogs');
	action_progress.hide(); // Hidden
	$('#ActionOnSubmit').on('click', function() {
		
		if(confirm('กรุณายืนยันการบันทึกข้อมูล ')) {

			$.ajax({
	   	    	  url: pathFixed + 'management/setActionOnBundled?_=' + new Date().getTime(),
	   	    	  type: "POST",
	   	          data: {
	   	          	 relx: query['rel'],
	   	          	 action_mode: $('#action_flag').val(),
	   	          	 actionnote: $('#actionnote').val(),
	   	          	 actiondate: $('#action_hidden_date').val()	   	          	 
	   	          },
	   	          beforeSend:function() {
	   	        	action_progress.show();
	   	        	
	   	          },
	   	          success:function(data) {
	   	        	  	   	      
	   	        	if(data['status'] == 'true') {
	   	        		var note = $.Notify({ content: data['msg'], style: { background: "green", color: "#FFFFFF" }, timeout: 10000 });
	   	    			note.close(7000);
	   	        		
	   	        	  	$('#actionnote_group').prepend(
	   	        	  		'<a href="#" class="list" style="text-decoration: none;">'+
	   	 	   	        	'<div class="list-content">'+
	   	 						'<span class="list-title" style="font-size: 0.8em;"></span>'+
	   	 						'<span class="list-subtitle">' + data['data']['ActionNoteDate'] + 'Update By : ' + data['data']['ActionName'] + '</span>'+
	   	 						'<span style="font-size: 0.8em; line-height:12px">Note :' + data['data']['ActionNote'] + '</span>'+
	   	        	  		'</div>'+
	   	        	  		'</a>'
	   	 				);
	   	        		
	   	        	} else {
	   	        		var note = $.Notify({ content: data['msg'], style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
		   	    		note.close(7000);
	   	        	}
	   	        	
	   	          },
	   	          complete:function() {
	   	        	action_progress.hide();
	   	        		   	        	
	   	          },
	   	          cache: true,
	   	          timeout: 5000,
	   	          statusCode: {
	   		  	        404: function() {
	   		  	            alert( "page not found." );
	   		  	        },
	   		  	        407: function() {
	   		  	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
	   		  	        },
	   		  	        500: function() {
	   		  	        	console.log("internal server error.");
	   		  	        }
	   	          }
	         
			});
						
			return true;
			
		}
		
		return false;
		
	});
	
    // VIEWER LOGGER
    $('#NCBConsentLogs').on('click', function() {
    	 $.Dialog({
    		 overlay: true,
    		 shadow: true,
    		 draggable: true,
    		 icon: '<i class="fa fa-tablet"></i>',
    		 content: '',
    		 padding: 10,
    		 width: 1300,
    		 height: 570,
    		 onShow: function(_dialog){
    			 
    			 var content = '<header class="span12" style="margin-top: 10px;"><h6>NCB Consent Logs</h6></header>';
    			 content += '<div id="ncb_progress_logs"><img src="' + rootFixed + '/img/ajax-loader.gif"> Loading...</div>';
    			 content += '<section class="form_container span12 text-center" style="height: 500px; min-width: 1300px; margin-top: -10px; font-size: 0.9em; display: block; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">'+
                 '<table id="NCBConsentLogs_Modal" style="min-width: 1260px;">'+
	                 '<thead>'+
	                     '<tr>'+
	                     	 '<th align="center">TYPE</th>'+
		                     '<th align="center">NAME - SURNAME</th>'+
	                         '<th align="center">NCB</th>'+
	                         '<th align="center">NCB DATE</th>'+
	                         '<th align="center">LB <i class="fa fa-arrow-right on-right on-left"></i> HQ</th>'+
	                         '<th align="center"><i class="fa fa-inbox on-left"></i> HQ RECEIVED</th>'+
	                         '<th align="center" colspan="2">HQ <i class="fa fa-arrow-right on-right on-left"></i> OPER</th>'+
	                         '<th align="center" colspan="2"><i class="fa fa-arrow-left on-left"></i>OPER RETURN</th>'+
	                         '<th align="center">RESET REASON</th>'+	
	                     '</tr>'+
	                 '</thead>'+
	                 '<tbody></tbody>'+
	              '</table>'+
	             '</section>';
    			
    			 
    			 $('#ncb_progress_logs').show();
    			 $.ajax({
		   	    	  url: pathFixed+'dataloads/getNCBConsentLogs?_=' + new Date().getTime(),
		   	    	  type: "POST",
		   	          data: {
		   	          	 relx: query['rel']
		   	          },
		   	          beforeSend:function() {
		   	        	  $('#ncb_progress_logs').show();
		   	          },
		   	          success:function(data) {

		   	        	for(var indexed in data['data']) {
		   	        	
		   	        		$('#NCBConsentLogs_Modal').fadeIn("slow", function() {
			   	        		$('#NCBConsentLogs_Modal > tbody').append(
			   	        			'<tr '+ data['data'][indexed]['BDR'] +'>' + 
			   	        				'<td>'+ data['data'][indexed]['BRT'] +'</td>'+
			   	        				'<td>'+ data['data'][indexed]['BRN']  +'</td>'+
			   	        				'<td>'+ data['data'][indexed]['NCK'] +'</td>'+
			   	        				'<td>'+ data['data'][indexed]['NCD'] +'</td>'+
			   	        				'<td>'+ data['data'][indexed]['SHQ'] +'</td>'+
			   	        				'<td>'+ data['data'][indexed]['RLB'] +'</td>'+
			   	        				'<td>'+ data['data'][indexed]['STO'] +'</td>'+
			   	        				'<td style="text-align: left;">'+ '-' +'</td>'+		
			   	        				'<td>'+ data['data'][indexed]['ORD'] +'</td>'+
			   	        				'<td style="text-align: left;">'+ data['data'][indexed]['CRB']  +'</td>'+
			   	        				'<td style="text-align: left;">'+ data['data'][indexed]['DES']  +'</td>'+
			   	        			'</tr>'	
			   	        		);
			   	        	});
		   	        		
		   	            }
		   	        	  
		   	        	
		   	        	  
		   	          },
		   	          complete:function() {
		   	        	$('#ncb_progress_logs').hide();
		   	        	$('#NCBConsentLogs_Modal > tbody td').css('padding-left', '3px').css('padding-bottom', '7px');
		   	        	
		   	          },
		   	          cache: true,
		   	          timeout: 5000,
		   	          statusCode: {
		   		  	        404: function() {
		   		  	            alert( "page not found." );
		   		  	        },
		   		  	        407: function() {
		   		  	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
		   		  	        },
		   		  	        500: function() {
		   		  	        	console.log("internal server error.");
		   		  	        }
		   	          }
	   	         
	   			});
    					
    			$.Dialog.title("NCB CONSENT LOGS");
    			$.Dialog.content(content);
    			
    		 }
    	 });
    });
    
    $('#RelationLogs').on('click', function() {
   	 $.Dialog({
   		 overlay: true,
   		 shadow: true,
   		 draggable: true,
   		 icon: '<i class="fa fa-tablet"></i>',
   		 content: '',
   		 padding: 10,
   		 width: 1300,
   		 height: 570,
   		 onShow: function(_dialog){
   			 
   			 var content = '<header class="span12" style="margin-top: 10px;"><h6>Document Flow Logs</h6></header>';
   			 content += '<div id="relation_progress_logs"><img src="' + rootFixed + '/img/ajax-loader.gif"> Loading...</div>'; 
   			 content += '<section class="form_container span12" style="height: 500px; min-width: 1300px; margin-top: -10px; font-size: 0.9em; display: block; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">'+
             '<table id="Reconcile_Modal" style="min-width: 1260px;" data-spy="scroll" data-target=".ncb_tbody">'+
                 '<thead>'+
                     '<tr>'+
                         '<th align="left" style="width: 20em;">NAME - SURNAME</th>'+
                         '<th align="center">TYPE</th>'+
                         '<th align="left" style="width: 5em;">LOGISTICS</th>'+
                         '<th>LB <i class="fa fa-arrow-right on-right on-left"></i> HQ</th>'+
                         '<th align="left"><i class="fa fa-inbox on-left"></i> HQ RECEIVED</th>'+
                         '<th align="left">COMPLETION</th>'+
                         '<th align="left" colspan="2">HQ <i class="fa fa-arrow-right on-right on-left"></i> CA</th>'+
                         '<th align="left" colspan="2"><i class="fa fa-arrow-left on-left"></i> CA RETRUN</th>'+
                     '</tr>'+
                 '</thead>'+
                 '<tbody class="ncb_tbody"></tbody>'+
             '</table>'+
             '</section>';
   			 
   			$('#relation_progress_logs').show();
   			$.ajax({
	   	    	  url: pathFixed+'dataloads/getReconcileDocLogs?_=' + new Date().getTime(),
	   	    	  type: "POST",
	   	          data: {
	   	          	 relx: query['rel']
	   	          },
	   	          beforeSend:function() {
	   	        	  $('#relation_progress_logs').show();
	   	          },
	   	          success:function(data) {

	   	        	for(var indexed in data['data']) {
	   	        	
	   	        		$('#Reconcile_Modal').fadeIn("slow", function() {
		   	        		$('#Reconcile_Modal > tbody').append(
		   	        			'<tr '+ data['data'][indexed]['BDR'] +'>' + 
		   	        				'<td style="text-align: left;">'+ data['data'][indexed]['BRN'] +'</td>'+
		   	        				'<td>'+ data['data'][indexed]['BRT'] +'</td>'+
		   	        				'<td>'+ data['data'][indexed]['LGC'] +'</td>'+
		   	        				'<td>'+ data['data'][indexed]['STH'] +'</td>'+
		   	        				'<td>'+ data['data'][indexed]['RFB'] +'</td>'+
		   	        				'<td>'+ data['data'][indexed]['CPL'] +'</td>'+
		   	        				'<td>'+ data['data'][indexed]['ATA'] +'</td>'+
		   	        				'<td style="text-align: left;">'+ ' - ' +'</td>'+
		   	        				'<td>'+ data['data'][indexed]['CAD'] +'</td>'+
		   	        				'<td style="text-align: left;">'+ data['data'][indexed]['CRB']  +'</td>'+		   	        				
		   	        			'</tr>'	
		   	        		);
		   	        	});
	   	        		
	   	            }
	   	        	  
	   	        	
	   	        	  
	   	          },
	   	          complete:function() {
	   	        	$('#relation_progress_logs').hide();
	   	        	$('#Reconcile_Modal > tbody td').css('padding-left', '3px').css('padding-bottom', '7px');
	   	        	
	   	          },
	   	          cache: true,
	   	          timeout: 5000,
	   	          statusCode: {
	   		  	        404: function() {
	   		  	            alert( "page not found." );
	   		  	        },
	   		  	        407: function() {
	   		  	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
	   		  	        },
	   		  	        500: function() {
	   		  	        	console.log("internal server error.");
	   		  	        }
	   	          }
  	         
  			});
   			 
   			 $.Dialog.title("DOCUMENT FLOW LOGS");
   			 $.Dialog.content(content);
   		 }
   	 });
    });
    
    $('#RelationCompletionLogs').on('click', function() {
    	
      	 $.Dialog({
       		 overlay: true,
       		 shadow: true,
       		 icon: '<i class="fa fa-tablet"></i>',
       		 content: '',
       		 padding: 10,
       		 width: 1300,
       		 height: 570,
       		 onShow: function(_dialog) {
       			 
       			$('#myModal').modal('hide');	
       			 
       			var content = '<header class="span12" style="margin-top: 10px;"><h6>Document Completion Logs</h6></header>';
        		content += '<div id="completiondoc_progress_logs"><img src="' + rootFixed + '/img/ajax-loader.gif"> Loading...</div>'; 
    			content += '<section class="form_container span12" style="height: 500px; min-width: 1300px; margin-top: -10px; font-size: 0.9em; display: block; overflow-y: scroll; -ms-overflow-y: scroll; -ms-scrollbar-face-color: rgb(231, 231, 231); -ms-scrollbar-3dlight-color: rgb(160, 160, 160); -ms-scrollbar-darkshadow-color: rgb(136, 136, 136); -ms-scrollbar-arrow-color: black;">'+
	            '<table id="CompletionLogs_Modal" style="min-width: 1260px;" data-spy="scroll" data-target=".ncb_tbody">'+
	                '<thead>'+
	                    '<tr>'+
	                        '<th>NAME - SURNAME</th>'+
	                        '<th>TYPE</th>'+
	                        '<th>LIST</th>'+
	                        '<th>Other</th>'+
	                        '<th align="center" style="width: 10em;">LB <i class="fa fa-arrow-right on-right on-left"></i> HQ</th>'+
                            '<th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> HQ RECEIVED</th>'+
                            '<th align="center" style="width: 10em;">HQ <i class="fa fa-arrow-right on-right on-left"></i> CA</th>'+
                            '<th align="center" style="width: 10em;">CA <i class="fa fa-arrow-right on-right on-left"></i> HQ</th>'+
                            '<th align="center" style="width: 10em;">HQ <i class="fa fa-arrow-right on-right on-left"></i> LB</th>'+
                            '<th align="center" style="width: 10em;"><i class="fa fa-inbox on-left"></i> LB RECEIVED</th>'+
                            '<th align="center" style="width: 10em;"><i class="fa fa-arrow-left on-left"></i> CA RETRUN</th>'+
	                        '<th align="center">CREATE BY</th>'+
	                        '<th align="center">CREATE DATE</th>'+
	                        '<th align="center">LATEST BY</th>'+
	                        '<th align="center">LATEST DATE</th>'+
	                    '</tr>'+
	                '</thead>'+
	                '<tbody class="ncb_tbody"></tbody>'+
	            '</table>'+
	            '</section>';
    			
    			$('#completiondoc_progress_logs').show();
       			$.ajax({
    	   	    	  url: pathFixed+'dataloads/getReconcileCompletionLogs?_=' + new Date().getTime(),
    	   	    	  type: "POST",
    	   	          data: {
    	   	          	 relx: query['rel'],
    	   	          	 rtype: $('#LockDocTypes').val()
    	   	          },
    	   	          beforeSend:function() {
    	   	        	  $('#completiondoc_progress_logs').show();
    	   	        	  
    	   	          },
    	   	          success:function(data) {
    	   	        	 
    	   	        	for(var indexed in data['data']) {
    	   	 
    	   	        		
    	   	        		var doc_other  = (data['data'][indexed]['DocOther'] != undefined) ? data['data'][indexed]['DocOther']:'';
    	   	        		var latestUpBy = (data['data'][indexed]['ChangeDocBy'] != undefined) ? data['data'][indexed]['ChangeDocBy']:'';

	    	   	        	$('#CompletionLogs_Modal').fadeIn("slow", function() {
	    	   	        		
	    	   	        		$('#CompletionLogs_Modal > tbody').append(
	    	   	        			'<tr>' + 
	    	   	        				'<td style="text-align: left;">'+ data['data'][indexed]['DocOwner'] +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['DocType'] +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['DocList'] + '</td>'+
	    	   	        				'<td style="text-align: center;">' + doc_other +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['LBSubmitDocDate'] +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['HQReceivedDocFromLBDate'] +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['SubmitDocToCADate'] +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['CAReturnDate'] +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['HQSentToLBDate'] +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['BranchReceivedDate'] +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['CARejectDocDate'] +'</td>'+
	    	   	        				'<td style="text-align: left;">'+ data['data'][indexed]['CreateDocBy']  +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['CreateDocDate'] +'</td>'+
	    	   	        				'<td style="text-align: left;">'+ data['data'][indexed]['ChangeDocBy'] +'</td>'+
	    	   	        				'<td style="text-align: center;">'+ data['data'][indexed]['ChangeDocDate'] +'</td>'+
	    	   	        			'</tr>'	
	    	   	        		);
	    	   	        		
	    	   	        	 });
	    	   	        	
    	   	        	 }

    	   	          },
    	   	          complete:function() {
    		   	        	$('#completiondoc_progress_logs').hide();
    		   	        	$('#CompletionLogs_Modal > tbody td').css('padding-left', '3px').css('padding-bottom', '7px');
    		   	        	
    		   	        	$('#CompletionLogs_Modal > tbody').find('td:nth-child(1), td:nth-child(4), td:nth-child(12), td:nth-child(14)').truncate({
    		                    width: '80',
    		                    token: '…',
    		                    side: 'right',
    		                    addtitle: true
    		               });
    		   	        	
		   	          },
		   	          cache: true,
		   	          timeout: 5000,
		   	          statusCode: {
		   		  	        404: function() {
		   		  	            alert( "page not found." );
		   		  	        },
		   		  	        407: function() {
		   		  	        	console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
		   		  	        },
		   		  	        500: function() {
		   		  	        	console.log("internal server error.");
		   		  	        }
		   	          }
    	  	         
       			 });
       			 
       			 $.Dialog.title("DOCUMENT MANAGEMENT COMPLETION LOGS");
       			 $.Dialog.content(content);
       		 }
      	 
       	 }).css('z-index', '999');
      	 
    });
    
	$("#Defense_OptionNote").on('click', function(){
		$.Dialog({
			overlay: true,
			shadow: true,
			flat: false,
			icon: '<i class="fa fa-comment"></a>',
			title: 'Defend Note',
			content: '',
			height: '80%',
			width: '95%',
			padding: 10,
			onShow: function(_dialog){
				
				var html = '<iframe src="' + pathFixed + 'management/loadSFEOnDefendPages" width="100%" style="height: 700px; border: 0px;"></iframe>';
				$.Dialog.content(html);
				
			}
			
		});
	});
	

    // Table Component
    var inc_ncb = parseInt($('#expense_table_ncbrefer > tbody tr.item_ncbrefer').length) ;	
    $('#expense_table_ncbrefer > tbody').find('tr:first-child td.del').removeClass('del').find('i.fa').remove(); 
    $('#AddNCBRefer').click(function() {
    	
    	++inc_ncb;
    	
    	var ncb_check 		= "'ncb_click_" + inc_ncb + "'";
    	var ncb_input 		= "'NCBChecked_" + inc_ncb + "'";
    	var lbsent_check	= "'lbsent_click_" + inc_ncb + "'";
    	var lbsent_input	= "'LBSentToHQ_" + inc_ncb + "'";
    	var hqget_check		= "'receivedlb_click_" + inc_ncb + "'";
    	var hqget_input		= "'ReceivedFromLB_" + inc_ncb + "'";
    	var hqtooper_check	= "'hqtooper_click_" + inc_ncb + "'";
    	var hqtooper_input	= "'HQToOper_" + inc_ncb + "'";
    	var oprt_check		= "'returntooper_click_" + inc_ncb + "'";
    	var oprt_input		= "'OperReturn_" + inc_ncb + "'";
    	var oprt_text		= "'rencb_" + inc_ncb + "'";
    	
    	//var ncb_result		= "'NCBResult_" + inc_ncb + "'";
    	//var ncb_relation    = "'NCBRelation_" + inc_ncb + "'";
    	//onchange="checkPassNCBFunction(' + ncb_result + ', ' + ncb_relation + ')"

        var item = '<tr class="item_ncbrefer" data-attr=\"' + inc_ncb + '\">' +
            '<td>' +
	        	'<div class="input-control select">' +
			    	'<select id="NCBRelation_' + inc_ncb + '" name="NCBRelation[]" style="height: 33px;">' +
			    		'<option value=""></option>' +
			    		'<option value="102" selected>ผู้กู้ร่วม</option>' +
			    		'<option value="103" selected>อื่นๆ (Doc)</option>' +
			    		'<option value="104">อื่นๆ</option>' +
			    	'</select>' +
		    	'</div>' +
		    '</td>' +
		    '<td>' +
		    	'<div class="input-control text">' +
		    		'<input type=\"hidden\" name=\"NCBIsRef[]\" value=\"\">'+
		    		'<input type="text" id="NCBName_' + inc_ncb + '" name="NCBName[]">' +
		    	'</div>' +
		    '</td>' +
		    '<td>' +
		    	'<div class="input-control select">' +
		    	'<select id="NCBResult_' + inc_ncb + '" name="NCBResult[]" style="height: 33px;">' +
		    		'<option value=""></option>' +
		    		'<option value="1">ผ่าน</option>' +
		    		'<option value="2">ไม่ผ่าน</option>' +
		    		'<option value="3">Deviate</option>'+
		    	'</select>' +
		    	'</div>' +
		    '</td>' +
		    '<td class="text-left">' +
				'<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">' +
		            '<label>' +
		                '<input id="ncb_click_' + inc_ncb + '" type="checkbox" onclick="GenDateValidator('+ ncb_check + ', '+ ncb_input +');">' +
		                '<span class="check"></span>' +
		            '</label>' +
		        '</div>' +
		        '<div id="objNCBChecked_' + inc_ncb +'" class="input-control text" id="" style="width: 120px;">' +
		            '<input type="text" id="NCBChecked_' + inc_ncb + '" name="NCBResultDate[]" value="" style="padding-left: 30px;">' +
		        '</div>' +
		    '</td>' +
		    '<td class="text-left">' +
			    '<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">' +
		            '<label>' +
		                '<input id="lbsent_click_' + inc_ncb + '" type="checkbox" onclick="GenDateValidator(' + lbsent_check + ', '+ lbsent_input +');">' +
		                '<span class="check"></span>' +
		            '</label>' +
	            '</div>' +
		    	 '<div id="objLBSentToHQ_' + i +'" class="input-control text" id="" style="width: 120px;">' +
		            '<input type="text" id="LBSentToHQ_' + inc_ncb + '" name="LBSentToHQ[]" value="" style="padding-left: 30px;">' +
		        '</div>' +
		    '</td>' +
		    '<td class="text-left">' +
			    '<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">' +
		            '<label>' +
		                '<input id="receivedlb_click_' + inc_ncb + '" type="checkbox" value="1" onclick="GenDateValidator(' + hqget_check + ', '+ hqget_input +');" disabled="disabled">' +
		                '<span class="check" style="border-color: #4390df;"></span>' +
		            '</label>' +
	            '</div>' +
		    	 '<div id="_objReceivedFromLB_' + inc_ncb +'" class="input-control text" id="" style="width: 120px;">' +
		            '<input type="text" id="ReceivedFromLB_' + inc_ncb + '" name="ReceivedFromLB[]" value="" style="padding-left: 30px; border-color: #4390df;">' +
		        '</div>' +
		    '</td>' +
		    '<td class="text-left">' +
			    '<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">' +
		            '<label>' +
		                '<input id="hqtooper_click_' + inc_ncb + '" type="checkbox" value="1" onclick="GenDateValidator(' + hqtooper_check + ', '+ hqtooper_input +');" disabled="disabled">' +
		                '<span class="check" style="border-color: #4390df;"></span>' +
		            '</label>' +
		        '</div>' +
		    	 '<div id="_objHQToOper_' + i +'" class="input-control text" id="" style="width: 120px;">' +
		            '<input type="text" id="HQToOper_' + inc_ncb + '" name="HQToOper[]" value="" style="padding-left: 30px; border-color: #4390df;">' +
		        '</div>' +
		    '</td>' +
		    '<td class="text-left">' +		    
			    '<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">' +
		            '<label>' +
		                '<input id="returntooper_click_' + inc_ncb + '" type="checkbox" value="1" onclick="GenDateValidator(' + oprt_check + ', '+ oprt_input +'); resetRelatedFields(' + inc_ncb + ', '+ oprt_input +'); setReturnDateByText(' + oprt_check +', ' + oprt_text + ');" disabled="disabled">' +
		                '<span class="check"></span>' +
		            '</label>' +
	            '</div>' +
		    	'<div id="objOperReturn_' + i +'" class="input-control text" id="" style="width: 120px;">' +
		    		'<p id="rencb_' + inc_ncb + '" style="margin-left: 25px; padding-top: 7px; padding-left: 10px; font-size: 1em;"></p>' +
	            	'<input type="hidden" id="OperReturn_' + inc_ncb + '" name="OperReturn[]" value="" style="padding-left: 30px;">' +
		        '</div>' +
		    '</td>' +
		    '<td class="del">' +
		    	'<i class="fa fa-minus-circle" style="font-size: 1.5em; color: red; margin-top: -20px;" onclick=\"removeAddNCBRecord();\"></i>' +
		    '</td>' +
		'</tr>';
        
       $('#expense_table_ncbrefer > tbody').last().after(item);
        
       $('#objNCBChecked_' + inc_ncb).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
       $('#objLBSentToHQ_' + inc_ncb).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
       $('#objReceivedFromLB_' + inc_ncb).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
       $('#objHQToOper_' + inc_ncb).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
       //$('#objOperReturn_' + inc_ncb).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
       
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
       
                     
    });

    // Function
    function CheckLengthValidator(fields, atDisplay, char_len) {
    	var elements = $('#' + fields).val();
    	if(elements.length < char_len) {
    		$('#' + atDisplay).text('กรุณาระบุให้ครบ ' + char_len + ' หลัก.');
    		var not = $.Notify({ content: "กรุณาระบุให้ครบ" + char_len + ' หลัก.', style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);
			
    	} else {
    		$('#' + atDisplay).text('');
    	}

    }
        
    function getQueryParams(qs) {
        qs = qs.split("+").join(" ");

        var params = {}, tokens,
            re = /[?&]?([^=]+)=([^&]*)/g;

        while (tokens = re.exec(qs)) {
            params[decodeURIComponent(tokens[1])]
                = decodeURIComponent(tokens[2]);
        }

        return params;
    }
    
 
    
    function input_isempty(data) {
	  if(data != '') { return 'true'; } 
	  else { return 'false'; }   
    }

    
    function in_array(needle, haystack, argStrict) {

	  var key = '',
	    strict = !! argStrict;

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

	function fnDateCompared(dtmfrom, dtmto){
    	return new Date(dtmfrom).getTime() > new Date(dtmto).getTime();    	
	}

	function fnDateValidation(date_1, date_2) {
		if(date_2 != '' && date_1 == '') {
			return true;
			
		} else {
			return false;
		}
    	 	
	}
    
});