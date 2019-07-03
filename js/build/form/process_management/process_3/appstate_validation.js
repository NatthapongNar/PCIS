$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    var query  = getQueryParams(document.location.search);
   
    if(query && query['ddflag'] == 'Y') {
		var socket = io.connect("http://tc001pcis1p", {path: '/node/pcischat/socket.io', "forceNew": true});
		socket.emit("register:ddtemplate_chanel", {});
		socket.emit("reservations:dd",{ reload:true });	
    }
    
    var str;
    var objDate = new Date();
    	str = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
    
    // Object
    var objapp            = $('#appno');
    var objpreapp         = $('input[name="preapproved"]:checked');
    var objstatus         = $('#status');
    var objreject         = $('#rjreason');
    var objcan            = $('#ccreason');
    var objapploan        = $('#approvedamount');
    var termyear		  = $('#termyear');
    var ddloan			  = $('#drawdownamount');
    var diffloan		  = $('#diff');

    // Reason
    var parent_pending    = $('#parent_pending');
    var parent_reject	  = $('#parent_reject');
    var parent_cancel	  = $('#parent_cancel');
    var pendingreason     = $('#pendingreason');
    
    var rjreason		  = $('#rjreason');
    var ccreason		  = $('#ccreason');
    
    // Mask Money
    var preloan			  = $('#preloan');
    var approvedamount	  = $('#approvedamount');
    var drawdownamount	  = $('#drawdownamount');
    
    
    // Object Calendar
    var approveddate	  = $('#approveddate');
    var appstatus		  = $('#statusdate');
    
    var plandrawdowndate  = $('#plandrawdowndate'); 
    var objcontractdate	  = $('#objContactdate');
    var contact_check	  = $('#contact_check');
    
    var jqDateConfig = { 
		changeYear: true,
		dateFormat: "dd/mm/yy", 
		minDate: moment().format('DD/MM/YYYY'),
		maxDate: moment(new Date(new Date().getFullYear() + 1, 11, 31)).format('DD/MM/YYYY'),
		beforeShowDay: disabled,
		onSelect: function(date, model) {			
			var plandd_store = $('#plan_drawdown').val();
			if(date !== moment(plandd_store).format('DD/MM/YYYY')) {
				$('#tmp_drawdown_reserv').prop('disabled', true);
			} else {
				var allow_reserved = $('#allowDDReserv').val();
				if(allow_reserved == 'Y') {
					$('#tmp_drawdown_reserv').prop('disabled', false);
				}	
			}
			
			
			if(date && date !== '') {
				var app_no = $('#appno').val();
				var plandd = $('#objplandrawdowndate').val();
				
				$.ajax({
                	url: pathFixed+'dataloads/getUserPlanDrawdownDate?_=' + new Date().getTime(),
                    type: 'POST',
					data: {
						docid: query['rel'],
						appno: (app_no != '') ? app_no:'',
						pdate: (plandd != '') ? plandd:''
					},
                    success:function(data) {},
                    complete:function() {},
                    cache: false,
                    timeout: 5000,
                    statusCode: {
                    	404: function() { console.log('page not found.'); }
                    }
				});	
			}
			
			
			/*
			if(currentDay >= 1 && currentDay <= 31) {
	
				if(moment(date, 'DD/MM/YYYY').format('MM') !== moment().format('MM')) {
					$('#tmp_drawdown_reserv').prop('disabled', true);
					$('#postpone_checker').prop('disabled', false);
					$('#postpone_planreason').multipleSelect("enable");
					   
					if($('#tmp_drawdown_reserv').is(':checked')) {
					   $('#drawdown_reserv').val('N');
					   $('#tmp_drawdown_reserv').prop('checked', false);
					}
					
					var not = $.Notify({ content: "Reminder: Plan Drawdown ไม่อยู่ในช่วงเวลาที่กำหนด (ยกเว้นเป็นความจำนงการวางแผนข้ามเดื่อน)", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
					
				} else {
					
					$('#tmp_drawdown_reserv').prop('disabled', false);
					
					$('#postpone_checker').prop('disabled', true);
					$('#postpone_planreason').multipleSelect("disable");
					
					/* Modify 17/10/2016
					if(in_array(moment(date, 'DD/MM/YYYY').format('DD'), OfficialHoliday)) {
						$('#tmp_drawdown_reserv').prop('disabled', false);
					
						$('#postpone_checker').prop('disabled', true);
						$('#postpone_planreason').multipleSelect("disable");
						
					} else {
						
						$('#tmp_drawdown_reserv').prop('disabled', true);
						$('#postpone_checker').prop('disabled', false);
						$('#postpone_planreason').multipleSelect("enable");
						
						if($('#tmp_drawdown_reserv').is(':checked')) {
						   $('#drawdown_reserv').val('N');
						   $('#tmp_drawdown_reserv').prop('checked', false);
						}
						
					}
					*/
			/*
				}

			}
			
			/* Not Use
			if(in_array(currentDay, OfficialHoliday)) {
	
				if(moment(date, 'DD/MM/YYYY').format('MM') !== moment().format('MM')) {
					$('#tmp_drawdown_reserv').prop('disabled', true);
					$('#postpone_checker').prop('disabled', false);
					$('#postpone_planreason').multipleSelect("enable");
					   
					if($('#tmp_drawdown_reserv').is(':checked')) {
					   $('#drawdown_reserv').val('N');
					   $('#tmp_drawdown_reserv').prop('checked', false);
					}
					
					var not = $.Notify({ content: "Plan Drawdown ไม่อยู่ในช่วงเวลาที่กำหนด", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
					
				} else {
				
					if(in_array(moment(date, 'DD/MM/YYYY').format('DD'), OfficialHoliday)) {
						$('#tmp_drawdown_reserv').prop('disabled', false);
					
						$('#postpone_checker').prop('disabled', true);
						$('#postpone_planreason').multipleSelect("disable");
						
					} else {
						
						$('#tmp_drawdown_reserv').prop('disabled', true);
						$('#postpone_checker').prop('disabled', false);
						$('#postpone_planreason').multipleSelect("enable");
						
						if($('#tmp_drawdown_reserv').is(':checked')) {
						   $('#drawdown_reserv').val('N');
						   $('#tmp_drawdown_reserv').prop('checked', false);
						}
						
					}

				}
				
			}
			*/
			
		}
	};
    
    // Calendar 
    approveddate.Datepicker({
		format: "dd/mm/yyyy",
		effect: "slide", 
		position: "bottom"
	});
    
    appstatus.Datepicker({
		format: "dd/mm/yyyy",
		effect: "slide",
		position: "bottom"
	});
   
    objcontractdate.Datepicker({
		format: "dd/mm/yyyy",
		effect: "slide",
		position: "bottom"
	});

    objapp.blur(function(e) {
        e.preventDefault();

        var element_alerted = $('#app_alert');
        if($(this).val() != "" && $(this).val() != undefined) {
        	objapp.removeAttr('data-state').attr('data-state', 'success');
            element_alerted.html('*').parent().removeClass().addClass('input-control text span12 success-state');
        }
        else { element_alerted.html('* กรุณาระบุ  Application No').addClass('text-alert'); objapp.attr('data-state', 'error').focus(); }

    });
    
    // Term Loan
    $("#termyear").on('blur', function() {
        var tm  = (parseInt($(this).val()) * 12);
        if(!isNaN(tm)) {
            $("#termmonth").text(tm + ' Months');

        } else {
            $("#termmonth").text('');
        }

    });

    $("#termmonth").append(function() {
        var tm  = (parseInt($("#termyear").val()) * 12);
        if(!isNaN(tm)) {
            $(this).text(tm + ' Months');

        } else {
            $(this).text('');
        }

    });
    
    $('input[name="preapproved"]').on('click', function() {
        var preapproved = $('input[name="preapproved"]:checked').val();
        var responded = $("#preapp_alert");
      
        	responded.html('');
            $('input[name="approveddate"]').val(str).attr('data-state', 'success');
            
    });
    
    // Diff Loan  ddlaon
    objapploan.on('blur', function() {
    	var diff 			= 0; 
    	var approveloan		= parseInt($(this).val());
    	var drawdownloan	= parseInt(ddloan.val());
    	
    	if(approveloan == 0 || drawdownloan == 0) {
    		diffloan.val(0);
    	
    	} else {
    		diff			= diff + (approveloan - drawdownloan);
    		diffloan.val(diff);
    	}
    		
    });
    
    ddloan.on('blur', function() {
    	var diff 			= 0; 
    	var approveloan		= parseInt(objapploan.val());
    	var drawdownloan	= parseInt($(this).val());
    	
    	if(approveloan == 0 || drawdownloan == 0) {
    		diffloan.val(0);
    	
    	} else {
    		diff			= diff + (approveloan - drawdownloan);
    		diffloan.val(diff);
    		
    	}
    		
    });
    
    contact_check.on('click', function() {
		var contact_checked = $(this).is(':checked');
		if(contact_checked) {
			$('#contactdate').val(str);
		} else {
			$('#contactdate').val('');
		}
		
	});
    
    
	$('#cancel_reason_progress').hide();
    $('#cancel_reason').change(function() {
    
    	if($(this).val() != null) $('#cancel_checker').prop('checked', true);
    	else $('#cancel_checker').prop('checked', false);    	
    	
    	var cancel_select = $(this).val(); 
    	if(in_array('CM999', cancel_select)) {
    		$('#parent_afcancel_reason').show();
    	} else {
    		$('#parent_afcancel_reason').hide();
    	}
    	
    });
    
    $('#cancel_checker').click(function() {
    	
    	if(!$(this).is(':checked')) {    		
    		$('#ms_spancancel_reason > span').text('');    		
    		$('input[name^="selectAllcancel_reason"], input[name^="selectItemcancel_reason"]').prop('checked', false);

    	}
 
    });
    
    $('#postpone_checker').click(function() {

    	if(!$(this).is(':checked')) {
    		
    		$('#ms_spanpostpone_planreason > span').text('');    		
    		$('input[name^="selectAllpostpone_planreason"], input[name^="selectItempostpone_planreason"]').prop('checked', false);
    		    
    		var plandate_draft = $('#plandrawdowndate_temp').val();
    		$('#objplandrawdowndate').removeAttr('disabled').val(plandate_draft);
    		$('#unknown_state').prop('checked', false)
    		
    		$('#parent_unknowns').hide();
    		
    	}
 
    });
    
    $('#tmp_drawdown_reserv').click(function() {
    	
    	if($(this).is(':checked')) {
    		
    		if(confirm('กรุณายืนยันการจดจำนอง')) {
    			
        		if($(this).is(':checked')) {
            		$('#drawdown_reserv').val($(this).val()); 
            		
            		$('#postpone_checker').prop('disabled', true);
					$('#postpone_planreason').multipleSelect("disable");
					
					var dateSelect = $('#objplandrawdowndate').val();
					$('#objplandrawdowndate').datepicker('destroy').datepicker({
						dateFormat: "dd/mm/yy", 
						minDate: dateSelect,
						maxDate: dateSelect
					});
					
        		} else {
            		$('#drawdown_reserv').val('N');
            		
            		$('#postpone_checker').prop('enable', true);
					$('#postpone_planreason').multipleSelect("enable");
        		}
        		
        	   	return true;
        	   	
        	}
        	
        	return false;
        	
    	} else {
    		$('#drawdown_reserv').val('N');
    		$('#objplandrawdowndate').datepicker('destroy').datepicker(jqDateConfig);
    	}

    });

    $('#tmp_drawdown_reserv').click(function() { console.log($('#drawdown_reserv').val()); });

	$('#parent_unknowns').hide();
	var drawdown_reserv = $('#drawdown_reserv_draft').val();
    $('#postpone_planreason').bind('change', function() {
  
    
    	if($(this).val() != null) {
    
    		$('#postpone_checker').prop('checked', true);
    		$('#objplandrawdowndate').val('');
    		$('#parent_unknowns').show();
    		
    		$('#tmp_drawdown_reserv').prop('checked', false);
    		$('#drawdown_reserv').val('N');
    		    		
    	} else {    		
    		
    		var plandate_draft = $('#plandrawdowndate_temp').val();
     		$('#objplandrawdowndate').removeAttr('disabled').val(plandate_draft);
    		$('#unknown_state').prop('checked', false)
    		$('#postpone_checker').prop('checked', false);   
    		$('#parent_unknowns').hide();
    		
    		$('#drawdown_reserv').val(drawdown_reserv);
    		if(drawdown_reserv == 'Y') $('#tmp_drawdown_reserv').prop('checked', true);
    		else $('#tmp_drawdown_reserv').prop('checked', false);
    		
    	}
    	
    	var postponelist = $('#postpone_planreason').val();   
    	if(in_array("PO999", postponelist)) {
    		$('#root_postpone_plandate').show();
    	} else {
    		$('#root_postpone_plandate').hide()
    	}

    });
    
    $('#unknown_state').click(function() {
    	
    	if($(this).is(':checked')) {
    		$('#objplandrawdowndate').prop('disabled', true);
    	} else {
    		$('#objplandrawdowndate').prop('disabled', false);  
    		
    	}
	
    });
    
    if($('#unknown_state').is(':checked')) {
    	$('#parent_unknowns').show();
		$('#objplandrawdowndate').prop('disabled', true);
	} else {
		$('#objplandrawdowndate').prop('disabled', false);    		
	}
    
    // Tooltip
    $('#status_callhistory').hover(function() {
    	var listContent = $('#parent_status_callhistory').html();												
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false,
			height: 300
		});
    });
    
    $('#TranslateCode').hover(function() {
    	var listContent = $('#parent_translatereason').html();												
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});
    });
    
    $('#postpone_logs').hover(function() {
    	var listContent = $('#postpone_reasonarea').html();												
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});
    });
    
    $('#nonoacept_logs').hover(function() {
    	var listContent = $('#nonaccept_reasonarea').html();												
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});
    });
    
    $('#creditname_logs').hover(function() {
    	
    	var listContent = $('#parent_creditnamelog').html();	    	
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});
		
    });
    
    $('#drawdown_icon_history').hover(function() {
    	
    	var listContent = $('#drawdown_area_history').html();	    	
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});
		
    });
    
    // Other Reason
    if(in_array('CM999', $('#cancel_reason').val())) { $('#parent_afcancel_reason').show(); }
	else { $('#parent_afcancel_reason').hide(); }
  
    if(in_array('PO999', $('#postpone_planreason').val())) { $('#root_postpone_plandate').show(); }
	else { $('#root_postpone_plandate').hide(); }	
    
    FnDiffloan = function() {
    	var diff 			= 0; 
    	var approveloan		= parseInt(objapploan.val());
    	var drawdownloan	= parseInt(ddloan.val());
    	
    	if(approveloan == 0 || drawdownloan == 0) {
    		diffloan.val(0);
    	
    	} else {
    		diff			= diff + (approveloan - drawdownloan);
    		diffloan.attr('value', diff);
    		
    	}
    }

    FnDiffloan();
    
    var currentDay   = '';
    var emp_identity = $('#empprofile_identity').val();
    if(in_array(emp_identity, ['57251', '56225'])) {
    	currentDay = 01;
    } else {
    	currentDay = moment().format('DD');
    }

    $('#submitApplicationStatusForm').on('click', function() { $('#btnApplicationStatusSubmit').click(); });
    $('#appstate').submit(function(e) {
    	var appno  			= $('#appno').val();
    	//var status 			= $('select[name="status"] option:selected').val();
    	//var objrj  			= $('select[name="rjreason"] option:selected').val();
		//var objcan 			= $('select[name="ccreason"] option:selected').val();
		var approvedamount  = $('#approvedamount').val();
		var preapproved		= $('#preloan').val();
		var cancel_reason	= $('select[name="cancel_reason"] option:selected').val();
		
		// NEW 23 FEB 2019
	    var pending_cancel_check 	= $('#pending_cancel_check');
	    var pending_cancel_input 	= $('#pending_cancel');
	      	
    	if(confirm('ยืนยันการบันทึกข้อมูล')) {
 
    		if(appno == "" || appno == undefined) {
                var element_alerted = $('#app_alert')
				var not = $.Notify({ content: "กรุณาระบุ  Application No.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				  
				objapp.focus().parent().addClass('error-state');
                element_alerted.html('* กรุณาระบุ  Application No').addClass('text-alert');
				
				return false;
			}
    		
    		if($('#cancel_checker').is(':checked') == true) {
				var after_cancelreason = $(this).is(':checked');
				if(after_cancelreason == true && cancel_reason == undefined || cancel_reason == '') {
					var not = $.Notify({ content: "กรุณาเลือกเหตุผลที่ยกเลิก", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
					not.close(7000);
				
					return false;					
				}
			}
    	
    		if($('#drawdown_reserv').val() == 'Y' && $('#objplandrawdowndate').val() === "") {
    			var not = $.Notify({ content: "กรุณาระบุ Plan Drawdown", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				return false;	
    		}
    		
    		var finalWeekendWorking = $('#official_holiday').val(); 
    		var nextYear   = moment().add(2, 'year').format('YYYY');
    		var threeMonth = moment().add(3, 'month').format('YYYY-MM-') + '01';
    		var plandate_year  = moment($('#objplandrawdowndate').val(), 'DD/MM/YYYY').format('YYYY');
    		
    		if($('#objplandrawdowndate').val() !== '' && plandate_year >= nextYear) {
				var not = $.Notify({ content: "กรุณาตรวจสอบ Plan Drawdown เนื่องจากปีเกินกว่าที่กำหนด ", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				return false;	
				
			}
    		
    		if($('#objplandrawdowndate').val() !== '' && moment($('#objplandrawdowndate').val(), 'DD/MM/YYYY').format('YYYY-MM-DD') > threeMonth) {
				var not = $.Notify({ content: "กรุณาตรวจสอบ Plan Drawdown เนื่องจากเดื่อนเกินกว่าที่กำหนด  (ไม่เกิน 3 เดือน)", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				return false;	
				
			}    		
    		  
    		// NEW STATEMENT ON 23 FEB 2019
    		var is_check = pending_cancel_check.is(':checked');
    		var pending_cancel_val = $('#pending_cancel').val();
    		

    	    if(is_check && !pending_cancel_val && !pending_cancel_val[0]) {
    	    	var not = $.Notify({ content: "กรุณาระบุเหตุผลในการขอยกเลิก", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				return false;	
    	    }
    		       	   
    	    // END NEW STATEMENT ON 23 FEB 2019
    		
    		/*
    		if(finalWeekendWorking !== '') {
    			
    			var official_holiday = finalWeekendWorking.split(',');
    		
    			if($('#drawdown_reserv').val() == 'Y' && $('#objplandrawdowndate').val() !== "") {
    				var drawdownDates  = $('#drawdowndate').val();
    				var plandate_month = moment($('#objplandrawdowndate').val(), 'DD/MM/YYYY').format('MM');
    				var plandate_field = moment($('#objplandrawdowndate').val(), 'DD/MM/YYYY').format('DD');
    				var current_month  = moment().format('MM');
    				
    				// Check logic by branch code.
    				if(plandate_month !== current_month && drawdownDates == '') {
    					var not = $.Notify({ content: "กรุณาตรวจสอบ Plan Drawdown เนื่องจากข้อมูลไม่อยู่ในเดือนที่กำหนด ", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        				not.close(7000);
        			
        				return false;	
    				}
    				
    				if(!in_array(plandate_field, official_holiday) && drawdownDates == '') {
        				var not = $.Notify({ content: "กรุณาตรวจสอบ Plan Drawdown เนื่องจากวันที่ไม่อยู่ในวันที่กำหนด ", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        				not.close(7000);
        			
        				return false;	
        				
        			}
    			}
    		}
    		*/

    		if($('#postpone_planreason').val() !== null) {    	
    			    			
    			if($('#objplandrawdowndate').val() == "" && $('#unknown_state').is(':checked') != true) {
    				var not = $.Notify({ content: "กรุณาระบุวันทีที่ต้องการจะเลือน หรือระบุ unknown หากไม่ทราบวันที่แน่นอน", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
    			
    				return false;	
    			}
    			
    		}
    		
    		
    		return true;
    		
    	}
    	
    	return false;
    	
    });
    
    var DrawdownReserv		= $('#drawdown_reserv').val();
    var PlanDrawdownField 	= $('#objplandrawdowndate').val();
    var FinalWeekendWorking = $('#official_holiday').val(); 
 
    var OfficialHoliday		= null;
    if(FinalWeekendWorking) {
    	OfficialHoliday 	= FinalWeekendWorking.split(',');
    }

    if(PlanDrawdownField === '') {
    	$('#tmp_drawdown_reserv').prop('disabled', true);
    }
    
    if(PlanDrawdownField !== '') {
    	
    	var product_type = $('#product_type').val();
    	var is_aip = $('#is_aip').val();
    	var receive_estimate = $('#received_estimatedoc').val();
    	var status = $('#status').val();
    	var allow_reserved = $('#allowDDReserv').val();
    
    	let block_reserved = true;
    	if(allow_reserved == 'Y') {
    		block_reserved = false;
    		/*
    		if(product_type == 'Secure' && is_aip == 'AIP' && receive_estimate == 'Y') {
        		block_reserved = false;
        	}
        	
        	if(product_type == 'Clean' && is_aip == 'AIP') {
        		block_reserved = false;
        	}
        	
        	if(status == 'APPROVED') {
        		block_reserved = false;
        	}
        	*/
    	} 
    	
    	if(!block_reserved) {
    		// Diff Month in Field Plan Date
        	if(currentDay >= 1 && currentDay <= 31) {
        		
    			if(moment($('#objplandrawdowndate').val(), 'DD/MM/YYYY').format('MM') !== moment().format('MM')) {
    				/*
    				$('#tmp_drawdown_reserv').prop('disabled', true);
    				$('#postpone_checker').prop('disabled', false);
    				$('#postpone_planreason').multipleSelect("enable");
    				   
    				if($('#tmp_drawdown_reserv').is(':checked')) {
    				   $('#drawdown_reserv').val('N');
    				   $('#tmp_drawdown_reserv').prop('checked', false);
    				}
    				
    				var not = $.Notify({ content: "Plan Drawdown ไม่อยู่ในช่วงเวลาที่กำหนด", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
    				*/
    			} else {
    				
    				var check_reservdd = $('#drawdown_reserv').val();
    				if(check_reservdd == 'Y') {
    					$('#tmp_drawdown_reserv').prop('disabled', false);					
    					$('#postpone_checker').prop('disabled', true);
    					$('#postpone_planreason').multipleSelect("disable");
    				}
    					
    				/* Modify 17/10/2016
    				if(in_array(moment(PlanDrawdownField, 'DD/MM/YYYY').format('DD'), OfficialHoliday)) {
    					$('#tmp_drawdown_reserv').prop('disabled', false);
    				
    					$('#postpone_checker').prop('disabled', true);
    					$('#postpone_planreason').multipleSelect("disable");
    					
    				} else {
    					
    					$('#tmp_drawdown_reserv').prop('disabled', true);
    					$('#postpone_checker').prop('disabled', false);
    					$('#postpone_planreason').multipleSelect("enable");
    					
    					if($('#tmp_drawdown_reserv').is(':checked')) {
    					   $('#drawdown_reserv').val('N');
    					   $('#tmp_drawdown_reserv').prop('checked', false);
    					}
    					
    				}
    				*/
    				
    			}

    		}
    	} else {
    		$('#tmp_drawdown_reserv').prop('disabled', true);
    	}
    
    	
    	/* NOt use
    	if(moment(PlanDrawdownField, 'DD/MM/YYYY').format('MM') !== moment().format('MM')) {
    		$('#tmp_drawdown_reserv').prop('disabled', true);
    		
    	} else {
    		
    		// Hiden Postpone Reason
    		if(in_array(currentDay, OfficialHoliday)) {
    			 if(in_array(moment(PlanDrawdownField, 'DD/MM/YYYY').format('DD'), OfficialHoliday)) { 
    				 $('#tmp_drawdown_reserv').prop('disabled', false);
    				 
    			 }  else { $('#tmp_drawdown_reserv').prop('disabled', true); }
    			 
    		} else { $('#tmp_drawdown_reserv').prop('disabled', true); }
 
    	}
		*/
    }
    
    $('#objplandrawdowndate').change(function() {
    	console.log('test');
    })
  
	function disabled(data) {
		if(data.getDay() == 6 || data.getDay() == 0)
			return [false, ''];
		else
			return [true, ''];
	}
	
	$('#objplandrawdowndate').datepicker(jqDateConfig);
	
	
	var application_number = $('#appno').val();
	getDataFromDDTemplate(application_number);
	getStatusHistory(application_number);
	//getDataFromDDTemplate('02-59-008716');

	/*
    plandrawdowndate.Datepicker({
		format: "dd/mm/yyyy",
		effect: "slide",
		position: "bottom",
		selected: function(date) {
		
			if(in_array(currentDay, OfficialHoliday)) {
				
				if(moment(date, 'DD/MM/YYYY').format('MM') !== moment().format('MM')) {
					$('#tmp_drawdown_reserv').prop('disabled', true);
					$('#postpone_checker').prop('disabled', false);
					$('#postpone_planreason').multipleSelect("enable");
					   
					if($('#tmp_drawdown_reserv').is(':checked')) {
					   $('#drawdown_reserv').val('N');
					   $('#tmp_drawdown_reserv').prop('checked', false);
					}
					
					var not = $.Notify({ content: "Plan Drawdown ไม่อยู่ในช่วงเวลาที่กำหนด", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
					
				} else {
				
					if(in_array(moment(date, 'DD/MM/YYYY').format('DD'), OfficialHoliday)) {
						$('#tmp_drawdown_reserv').prop('disabled', false);
					
						$('#postpone_checker').prop('disabled', true);
						$('#postpone_planreason').multipleSelect("disable");
						
					} else {
						
						$('#tmp_drawdown_reserv').prop('disabled', true);
						$('#postpone_checker').prop('disabled', false);
						$('#postpone_planreason').multipleSelect("enable");
						
						if($('#tmp_drawdown_reserv').is(':checked')) {
						   $('#drawdown_reserv').val('N');
						   $('#tmp_drawdown_reserv').prop('checked', false);
						}
						
					}
					
				}
				
			}

		}
	});
	*/
	
    // Lock Postpone, When Drawdown template is checked already.
    if(DrawdownReserv === 'Y') {
    	$('#postpone_checker').prop('disabled', true);
    	$('#postpone_planreason').multipleSelect("disable");
    	$('#tmp_drawdown_reserv').prop('disabled', true);
    	
    	$('#plandrawdowndate').html('<input id="objplandrawdowndate" name="plandrawdowndate" type="text" value="' + PlanDrawdownField + '" readonly="readonly" style="background: #E6E6E6;">');
    	
    }
        
    // Contact progress
    $('#contact_reason_progress').hide();
    
    
    $('#objAppSearch').click(function() {
        var applications = $('#appno').val();
        if(applications == '') {

        } else {

            $.ajax({
                url: pathFixed + 'dataloads/applicationchecked?_=' + new Date().getTime(),
                type: "POST",
                data: {
                    appno: applications

                },
                success:function(data) {

                    if(data['status'] == false && data['valid'] == 'T01') {
                        $('#app_alert').text('กรุณาระบุหมายเลข Application No');

                    } else {

                        if(data['status'] == true && data['valid'] == 'T02') {
                            $('#app_alert').text('ขออภัย!! มีหมายเลข Application นี้อยู่แล้วในระบบ กรุณาตรวจสอบใหม่อีกครั้ง.');
                        } else {
                            $('#app_alert').text('ไม่พบหมายเลข Application นี้ในระบบ (สามารถใช้ได้).');
                        }

                    }

                },
                complete:function() {

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

        }

    });
	
    $('#objFixed').bind('click', function() {
    	
    	var fixed = $('#objFixed').attr('class');
    	if(fixed == 'none') {
    		
    		$('#objFixed').removeClass('none').addClass('expend');
            $('textarea').animate({
            	'overflow-y':'hidden',
            	'height': '450px'            	
            }, 500);
            
    	} else {
    		
    		$('#objFixed').removeClass('expend').addClass('none');
            $('textarea').animate({
            	'overflow-y':'hidden',
            	'height': '130px'
            	
            }, 500);
    		
    	}

    });
    
    $('#unlockedDDReserv').click(function() {
    	if(confirm('กรุณายืนยันการรีเซ็ตข้อมูล')) {
    		$(this).fadeOut();
    		unlockplandate();
    		$('#drawdown_reserv').val('N');
    		$('#tmp_drawdown_reserv').prop('checked', false);
    		    		    		
    		$('#plandrawdowndate').css({'display': 'block'});
    		$('#pandrawdownlabel').hide();
    		$('#objplandrawdowndate').datepicker(jqDateConfig).css({'background': '#fff'});
    		
    		$('#drawdownamount').val('0.00');
    		$('#drawdowndate').val('');
    		$('#drawdowntype').val('');
    	}    	
    });
       
    function unlockplandate() {
    	var app_no = $('#appno').val();
    	var plandd = $('#objplandrawdowndate').val();
		$.ajax({
        	url: pathFixed+'dataloads/unlockPlanDrawdownDate?_=' + new Date().getTime(),
            type: 'POST',
			data: {
				docid: query['rel'],
				appno: (app_no != '') ? app_no:'',
				pdate: (plandd != '') ? plandd:''
			},
            success:function(data) {},
            complete:function() {},
            cache: false,
            timeout: 5000,
            statusCode: {
            	404: function() { console.log('page not found.'); }
            }
		});	    	
    }
    
    $('#change_application').click(function(e) {
    	var offsets = $(e.target).offset();
    	offsets.left = parseInt(offsets.left) + 21;
    	$('#change_application_tools').addClass('open');   
    	$('#application_request').focus();
    });
        
    $('#change_application_close').click(function() { $('#change_application_tools').removeClass('open'); })
    
    $('#application_request').on('keypress keydown', function(event) {
	    if (event.which >= 65 && event.which <= 90) {
	       return false;
	    }
	});
    
    $('#application_check').click(function() {
    	var cur_appno = $('#appno').val();
    	var app_no = $('#application_request').val();    	
    	if(app_no && app_no !== "") {
    		if(cur_appno === app_no) {
    			var not = $.Notify({ content: "หมายเลขแอพพลิเคชั่นที่ระบุเป็นหมายเลขที่ใช้อยู่ในปัจจุบัน กรณีระบุหมายเลขอื่น", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    			not.close(7000);
    			return false;
    		} else {
    			if(confirm('ท่านต้องการเปลี่ยนหมายเลแอพพลิเคชั่น\n\rจากหมายเลข ' + cur_appno + ' เป็นหมายเลข ' + app_no + ' ใช่หรือไม่ \n\rโปรดยืนยันการตรวจสอบ')) {
        			appverify(app_no);
        			return true;
            	}
    			return false;
    		}
    	} else {
    		var not = $.Notify({ content: "กรุณาระบุหมายเลขแอพพลิเคชั่นที่ต้องการจะเปลี่ยน เพื่อทำการตรวจสอบหาในระบบ", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);
			return false;
    	}
    	
    });
    
    function appverify(app_no) {
    	var cur_appno = $('#appno').val();
		$.ajax({
        	url: pathFixed+'dataloads/application_verify?_=' + new Date().getTime(),
            type: 'POST',
			data: {
				doc_id: query['rel'],
				app_no: app_no
			},
            success:function(data) {
            	if(data.status) {
            		if(confirm('พบประวัติข้อมูลเก่าในระบบ โปรดกดยืนยันอีกครั้งหากต้องการเปลี่ยนหมายเลขแอพพลิเคชั่น')) {
            			changeAppBundle(cur_appno, app_no);
            			return true;
                	}
            		return false;
            	} else {
            		var not = $.Notify({ content: "ไม่พบประวัติข้อมูลหมายเลข " + app_no + ' ในระบบ กรุณาตรวสอบความถูกต้องใหม่อีกครั้งหรือติดต่อผู้ดูแลระบบ (3615/3618)', style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        			not.close(7000);
            	}
            },
            complete:function() {},
            cache: false,
            timeout: 15000,
            statusCode: {}
		});	    	
    }
    
    function changeAppBundle(oApp, nApp) {
    	$.ajax({
        	url: pathFixed+'dataloads/application_update?_=' + new Date().getTime(),
            type: 'POST',
			data: {
				doc_id: query['rel'],
				oApp: (oApp != '') ? oApp:'',
				nApp: (nApp != '') ? nApp:''
			},
            success:function(data) {
            	if(data.status) {
            		
            		var not = $.Notify({ content: "ระบบอัพเดทหมายเลขแอพพลิเคชั่นใหม่สำเร็จ", style: { background: '#63ad14', color: '#FFFFFF' }, timeout: 10000 });
        			not.close(7000);
        			
        			$('#appno').val(nApp);
        			$('#fake_appno').val(nApp); 
        			$('#change_application_tools').removeClass('open'); 
        			
            	} else {
            		var not = $.Notify({ content: 'เกิดข้อผิดพลาดในการอัพเดทข้อมูลในระบบ กรุณาตรวสอบความถูกต้องใหม่อีกครั้งหรือติดต่อผู้ดูแลระบบ (3615/3618)', style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        			not.close(7000);
            	}
            },
            complete:function() {},
            cache: false,
            timeout: 15000,
            statusCode: {}
		});	    	
    }
    
    //#cacomment
    $('#contact_comment').each(function () {
        h(this);
    }).on('input', function () {
    	h(this);
    });

    function h(e) {
        $(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight);
    }
    
    function getDataFromDDTemplate(ApplicationNo) {
    	var links = "http://172.17.9.94/newservices/LBServices.svc/";
    	if(ApplicationNo !== '') {
    		
    		$.ajax({
                url: links + 'ddtemplate',
                type: "POST",
                contentType: "application/json", 
                dataType: 'json',
                data: JSON.stringify({ AppNo: ApplicationNo }),
                success:function( resp ) {
                	
                	if(resp[0]) {
                		var data 	 = resp[0];
                		var lastdate = $('#lastDayOfMonth').val();
                		
                		if(data.AppraisalStatus == "Cancel") {
                			jqDateConfig.minDate = moment().format('DD/MM/YYYY');
                			jqDateConfig.maxDate = lastdate;
                			$('#objplandrawdowndate').datepicker('destroy').datepicker(jqDateConfig);
                		}
                		
                	}

                },
                cache: false,
                timeout: 25000,
                crossDomain: false,
                statusCode: {
                    404: function() { console.log( "page not found." ); },
                    407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); },
                    500: function() { console.log("internal server error."); }
                }, 
                error: function(msg) { console.log(msg); }
            });   
            
    	}	
    }
    
    function getStatusHistory(ApplicationNo) {
    	var links = "http://172.17.9.94/newservices/LBServices.svc/";
    	if(ApplicationNo !== '') {
    		
    		$.ajax({
                url: links + 'collection/status/history/' + ApplicationNo,
                type: "GET",
                success:function( resp ) {
                	if(resp && resp.length > 0) {
                		
                		var runno   = 1;
                		var content = '';
                		$.each(resp, function(index, value) {
                			content +=
                			'<tr>' +
                				'<td>' + runno + '</td>' +
                				'<td>' + moment(value.StatusDate).format('DD/MM/YYYY') + '</td>' +
                				'<td style="text-align: center;">' + convStatus(value.Status) + '</td>' +
                				'<td>' + value.StatusReason + '</td>' +
                			'</tr>';
                			runno++;
                		});
                		
                		$('#parent_status_callhistory > table').find('tbody').html(content);                		
                		
                	} else { $('#status_callhistory > i').addClass('hide') }
                	
                	
                	function convStatus(state) {
                		if(state && state !== '') {
                			switch(state) {
                				case 'APPROVED':
                					return 'A';	
                					break;
                				case 'PENDING':
                					return 'P';
                					break;
								case 'CANCEL':
									return 'C';
									break;
								case 'REJECT':
									return 'R';
									break;
								default: 
									return '';
									break;
                			}
                		}
                	}

                },
                complete: function() {},
                statusCode: {
                    404: function() { console.log( "page not found." ); },
                    407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); },
                    500: function() { console.log("internal server error."); }
                }, 
                error: function(msg) { console.log(msg); }
            });   
    		
    	}
    }
    
    function in_array(needle, haystack, argStrict) {
    	
 	   var key = '', strict = !! argStrict;
 	   if (strict) {
 		    for (key in haystack) {
 		      if (haystack[key] === needle) { return true; }
 		    }
 		    
 	   } else {
 		    for (key in haystack) {
 		      if (haystack[key] == needle) { return true; }
 		      
 		    }
 	   }

 	   return false;
 	   
 	}

    // Mask field
	function maskInputSpecified() {
		termyear.mask("9999");
		preloan.number(true, 0);
		approvedamount.number(true, 2);
		drawdownamount.number(true, 2);
		diffloan.number(true, 0);
		$('#application_request').mask("99-99-99999999");
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
    
	
	maskInputSpecified();
	
	if(!in_array($('#status').val(), ["", 'SCORE-PASS', 'PENDING', 'APPROVED'])) {
		$('#tmp_drawdown_reserv').prop('disabled', true);
	}
	
	// NEW 23 FEB 2019
//    var pending_cancel_check 	= $('#pending_cancel_check');
//    var pending_cancel_input 	= $('#pending_cancel');
//    
//    pending_cancel_check.on('click', function() {
//    	var is_check = pending_cancel_check.is(':checked');
//    	if(is_check) {
//    		pending_cancel_input.removeAttr('disabled');
//    		//pending_cancel_input.removeAttr('style');
//    	} else {
//    		pending_cancel_input.attr('disabled', 'disabled');
//    		//pending_cancel_input.css({ 'background-color': '#F5F5F5' });
//    	}
//    });
    
    $('#clear_pending_cancel').click(function() {
        var applications = $('#appno').val();
        
        if(confirm('กรุณายืนยันการขอยกเลิก Pending Cancel (เฉพาะกรณี CA ยังไม่ยืนยันสถานะ Cancel ในระบบเท่านั้น)')) {        	
        	var doc_id = $('#docid').val();
        	var usr_id = $('#actor_id').val();
        	var usr_name = $('#actor_name').val();
        
        	$.ajax({
                url: pathFixed + 'dataloads/requestClearPendingCancel?_=' + new Date().getTime(),
                type: "POST",
                data: {
                	DocID: doc_id,
                    CreateID: usr_id,
                    CreateBy: usr_name
                },
                success:function(data) {
                	if(data.status) {
                		var not = $.Notify({ content: "ระบบดำเนินการล้างสถานะการขอยกเลิก Pending Cancel สำเร็จ... กรุณารอสักครู่ระบบจะรีเซ็ตหน้าจอใหม่....", style: { background: '#63ad14', color: '#FFFFFF' }, timeout: 10000 });
            			not.close(7000);
            		
            			_.delay(function() {
            				document.location.reload();
            			}, 2000)
            			
                	} else {
                		var not = $.Notify({ content: 'เกิดข้อผิดพลาดในการอัพเดทข้อมูลในระบบ กรุณาตรวสอบความถูกต้องใหม่อีกครั้งหรือติดต่อผู้ดูแลระบบ (3615/3618)', style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
            			not.close(7000);
                	}

                },
                complete:function() {},
                cache: true,
                timeout: 5000,
                statusCode: {
                    404: function() {console.log( "page not found."); },
                    407: function() {console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");},
                    500: function() {console.log("internal server error.");}
                }
            });
        	
        	return true;
        }
        
        return false;

    });
	    

});