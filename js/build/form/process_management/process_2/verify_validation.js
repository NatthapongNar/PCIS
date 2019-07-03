$(function() {
		
	//objElement
    var objcriteria    = $("#criteria");
    var objcheckncb    = $('input[name="checkncb"]');
    var objncbdate	   = $("#checkncbdate");
    var objmainloan    = $("#mainloan");
    var objloanname    = $("#loanname");
    var objrmprocess   = $("#rmprocess");
    var objrmprocdate  = $("#rmprocessdate");
    var objems         = $("#ems");
    var objemsdate	   = $('#EMSDate');
    var objrevisit	   = $('#reactivate');
    var objrevisitdate = $('#reactivatePlan');
    
	 /** Document Follow UP  **/
    var progresses_doc = $("#progresses_doc");
    var docno          = $('input[name="docno"]');
    var doctype        = $('select[name^="doctype"]');
    var docdate        = $('input[name="doc_gendate"]');
    var hqreceive      = $('input[name="hqreceivedoc"]');
    var docfromca      = $('input[name="docfromca"]');
    var adminbranch    = $('input[name="adminbranch"]');
    var actors         = $("#actor").val();
    
    /** Object DocOption  **/
    var docoption_1	   = $('#docoption_1');
    var docoption_2	   = $('#docoption_2');
    var docoption_3	   = $('#docoption_3');
    var docoption_4	   = $('#docoption_4');
    var docoption_5	   = $('#docoption_5');
    
    docoption_1.hide();
    docoption_2.hide();
    docoption_3.hide();
    docoption_4.hide();
    docoption_5.hide();
    

    var str_date;
    var objDate = new Date();
    
    str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
    
    // Generate Automate
    objcheckncb.on('click', function() { 
    	objncbdate.val(str_date); 
    	objncbdate.attr('data-state', 'success');
	});
    
    objrmprocess.on('blur', function() {
        var responded = $("#rmprocess_alert");
        var process = $('select[name="rmprocess"] option:selected');
        if(process.val() == '' || process.val() == undefined) {
        	
            $("#parent_rmprocess").removeClass().addClass("input-control select error-state");
            responded.css('color', '#d2322d').css('margin-left', '-2em').html('กรุณาระบุกระบวนการทำงานของ RM');
            
        } else {
        	
            $("#parent_rmprocess").removeClass().addClass("input-control select success-state");
            responded.html('');
        }

    });
    
    objrmprocess.on('change', function() {
        var process = $('select[name="rmprocess"] option:selected');
        if(process.val() == '' || process.val() == undefined){ objrmprocdate.val(''); } 
        else { objrmprocdate.val(str_date); }
    });
    
    objems.on('change', function() {
		var responded = $("#ems_alert");
		objemsdate.val(str_date);
	});
    
    objrevisit.on('change', function() {
    	var revisit		= $('select[name="reactivate"] option:selected').val();
    	if(revisit == '' || revisit == undefined) {
    		
    		$(this).parent().removeClass().addClass("input-control select span2 error-state")
    		
    	} else {
    		
    		$('#revplan').removeClass().addClass("input-control text span2 error-state");
    	}
    	
    });
    
    objrevisitdate.on('blur', function() {
    	var revisitdate	= $(this).val();
    	if(revisitdate == '' || revisitdate == undefined) {
    		$('#revplan').removeClass().addClass("input-control text span2 error-state")
    		
    	} else {
    		$('#revplan').removeClass().addClass("input-control text span2 success-state");
    		
    	}
	});
    
    $('#HQReceiveCADateChecker').on('click', function() { 
		var checker = $('input[name="HQReceiveCADateChecker"]:checked').val();
		if(checker == "on" && checker != "" || checker != undefined) {
			$('input[name="HQReceiveCADate"]').val(str_date)
		} else {
			$('input[name="HQReceiveCADate"]').val("");
		}		
	});
    
    $('#notsendto').on('click', function() { $('input[name="CADate"]').val(""); });
    $('#sendto').on('click', function() { 
		var checker = $('input[name="sendto"]:checked').val();
		if(checker == "1" && checker != "" || checker != undefined) {
			$('input[name="CADate"]').val(str_date)
		} else {
			$('input[name="CADate"]').val("");
		}		
	});
    
    $('#lackdoc_notsend').on('click', function() { $('input[name="lackdoc_sendDate"]').val(""); });
    $('#lackdoc_send').on('click', function() { 
		var checker = $('input[name="lackdoc_notsend"]:checked').val();
		if(checker == "1" && checker != "" || checker != undefined) {
			$('input[name="lackdoc_sendDate"]').val(str_date)
		} else {
			$('input[name="lackdoc_sendDate"]').val("");
		}		
	});
    
    $('#BrnNCBDateChecker').on('click', function() { 
		var checker = $('input[name="BrnNCBDateChecker"]:checked').val();
		if(checker == "on" && checker != "" || checker != undefined) {
			$('input[name="BrnNCBDate"]').val(str_date)
		} else {
			$('input[name="BrnNCBDate"]').val("");
		}		
	});
    
    $('#HQNCBChecker').on('click', function() { 
		var checker = $('input[name="HQNCBChecker"]:checked').val();
		if(checker == "on" && checker != "" || checker != undefined) {
			$('input[name="HQNCBDate"]').val(str_date)
		} else {
			$('input[name="HQNCBDate"]').val("");
		}		
	});
    
    $('#HQSentToOperDateChecker').on('click', function() { 
		var checker = $('input[name="HQSentToOperDateChecker"]:checked').val();
		if(checker == "on" && checker != "" || checker != undefined) {
			$('input[name="HQSentToOperDate"]').val(str_date)
		} else {
			$('input[name="HQSentToOperDate"]').val("");
		}		
	});
    
   
    $('#verification_forms').submit(function(e) {
    	
    	var criteria       = $('input[name="criteria"]:checked').val();
    	var ncbchecked     = $('input[name="checkncb"]:checked').val();
    	var mainloan       = $('input[name="mainloan"]:checked').val();
        var loanname       = $('#loanname').val();
        var rmprocess	   = $('select[name="rmprocess"] option:selected').val();
        var ems			   = $('#ems').val();
        
    	if(confirm('ยืนยันการบันทึกข้อมูล')) {
    		/*
    		if(criteria == "" || criteria == undefined) {
				var not = $.Notify({ content: "กรุณาระบุเกณฑ์การตรวจสอบ (Basic Criteria)", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				 not.close(7000);
				
				return false;
			
    		} else {
    		*/
    			if(ncbchecked != undefined && ncbchecked == 1 || ncbchecked == '1') {
    				
    				if(mainloan == "" || mainloan == undefined) {
        				var not = $.Notify({ content: "กรุณาระบุผู้กู้หลัก", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        				 not.close(7000);
        				
        				return false;
        			}
            		
            		if(loanname == "" || loanname == undefined) {
        				var not = $.Notify({ content: "กรุณาระบุชื่อผู้กู้หลัก", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        				 not.close(7000);
        				
        				return false;
        			}

    			}
    			
    			if(rmprocess == "Completed") {
    				
    				if(ems == "" || ems == undefined) {
        				var not = $.Notify({ content: "กรุณาระบุเลข ems หากไม่มีกรุณาใส่เลขที่สาขา", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        				 not.close(7000);
        				
        				return false;
        			}

    				
    			}
    			
    			$('#lackdoc_notsend, #lackdoc_send').prop('disabled', false);  
    			$('#sendto, #notsendto').prop('disabled', false);  


    		//}
    		
    		return true;
    	}
    	
    	return false;
    	
    });
    
    // HardCore Manual - Element Fixed
    $("#doctype_1").on('change', function() {GenDateListValidator(['doctype_1', 'doc_gendate_1'], 'actor_gendate_1', 'doc_date_text_1');});
    $("#doctype_2").on('change', function() {GenDateListValidator(['doctype_2', 'doc_gendate_2'], 'actor_gendate_2', 'doc_date_text_2');});
    $("#doctype_3").on('change', function() {GenDateListValidator(['doctype_3', 'doc_gendate_3'], 'actor_gendate_3', 'doc_date_text_3');});
    $("#doctype_4").on('change', function() {GenDateListValidator(['doctype_4', 'doc_gendate_4'], 'actor_gendate_4', 'doc_date_text_4');});
    $("#doctype_5").on('change', function() {GenDateListValidator(['doctype_5', 'doc_gendate_5'], 'actor_gendate_5', 'doc_date_text_5');});

    $("#conf_hqreceivedoc_1").on('change', function() {GenDateValidator([this, "hqreceivedoc_1"], 'actor_hqreceivedoc_1',"txt_hqreceivedoc_1");});
    $("#conf_hqreceivedoc_2").on('change', function() {GenDateValidator([this, "hqreceivedoc_2"], 'actor_hqreceivedoc_2',"txt_hqreceivedoc_2");});
    $("#conf_hqreceivedoc_3").on('change', function() {GenDateValidator([this, "hqreceivedoc_3"], 'actor_hqreceivedoc_3',"txt_hqreceivedoc_3");});
    $("#conf_hqreceivedoc_4").on('change', function() {GenDateValidator([this, "hqreceivedoc_4"], 'actor_hqreceivedoc_4',"txt_hqreceivedoc_4");});
    $("#conf_hqreceivedoc_5").on('change', function() {GenDateValidator([this, "hqreceivedoc_5"], 'actor_hqreceivedoc_5',"txt_hqreceivedoc_5");});

    $("#conf_docfromca_1").on('change', function() {GenDateValidator([this, "docfromca_1"], 'actor_docfromca_1',"txt_docfromca_1");});
    $("#conf_docfromca_2").on('change', function() {GenDateValidator([this, "docfromca_2"], 'actor_docfromca_2',"txt_docfromca_2");});
    $("#conf_docfromca_3").on('change', function() {GenDateValidator([this, "docfromca_3"], 'actor_docfromca_3',"txt_docfromca_3");});
    $("#conf_docfromca_4").on('change', function() {GenDateValidator([this, "docfromca_4"], 'actor_docfromca_4',"txt_docfromca_4");});
    $("#conf_docfromca_5").on('change', function() {GenDateValidator([this, "docfromca_5"], 'actor_docfromca_5',"txt_docfromca_5");});

    $("#conf_adminbranch_1").on('change', function() {GenDateValidator([this, "adminbranch_1"], 'actor_adminbranch_1',"txt_adminbranch_1");});
    $("#conf_adminbranch_2").on('change', function() {GenDateValidator([this, "adminbranch_2"], 'actor_adminbranch_2',"txt_adminbranch_2");});
    $("#conf_adminbranch_3").on('change', function() {GenDateValidator([this, "adminbranch_3"], 'actor_adminbranch_3',"txt_adminbranch_3");});
    $("#conf_adminbranch_4").on('change', function() {GenDateValidator([this, "adminbranch_4"], 'actor_adminbranch_4',"txt_adminbranch_4");});
    $("#conf_adminbranch_5").on('change', function() {GenDateValidator([this, "adminbranch_5"], 'actor_adminbranch_5',"txt_adminbranch_5");});
    
    
    $("#doctype_1").on('change', function() {
    	var doctype_1 	= $(this).val();
    	if(doctype_1 == "อื่นๆ") {
    		docoption_1.show();
    	
    	} else {
    		docoption_1.hide();
    	}
    	
    });
    
    $("#doctype_2").on('change', function() {
    	var doctype_2 	= $(this).val();
    	if(doctype_2 == "อื่นๆ") {
    		docoption_2.show();
    	
    	} else {
    		docoption_2.hide();
    	}
    	
    });

	$("#doctype_3").on('change', function() {
		var doctype_3 	= $(this).val();
    	if(doctype_3 == "อื่นๆ") {
    		docoption_3.show();
    	
    	} else {
    		docoption_3.hide();
    	}
		
	});
	
	$("#doctype_4").on('change', function() {
		var doctype_4 	= $(this).val();
    	if(doctype_4 == "อื่นๆ") {
    		docoption_4.show();
    	
    	} else {
    		docoption_4.hide();
    	}
		
	});
	
	$("#doctype_5").on('change', function() {
		var doctype_5 	= $(this).val();
    	if(doctype_5 == "อื่นๆ") {
    		docoption_5.show();
    	
    	} else {
    		docoption_5.hide();
    	}
		
	});
	
	if($("#doctype_1").val() == 'อื่นๆ') { docoption_1.show(); }
	if($("#doctype_2").val() == 'อื่นๆ') { docoption_2.show(); }
	if($("#doctype_3").val() == 'อื่นๆ') { docoption_3.show(); }
	if($("#doctype_4").val() == 'อื่นๆ') { docoption_4.show(); }
	if($("#doctype_5").val() == 'อื่นๆ') { docoption_5.show(); }
    
    $('#doc_refund').submit(function(e) {
    	
    	var doctypes  = $('select[name$="doctype[]"]').map(function() { return $(this).val(); }).get();
    	
    	if(confirm('ยืนยันการบันทึกข้อมูล')) {
    		
    		if(doctypes[0] == "N/A" && doctypes[1] == "N/A" && doctypes[2] == "N/A" && doctypes[3] == "N/A" && doctypes[4] == "N/A") {
				var not = $.Notify({ content: "กรุณาระบุรายเอกสารขอคืน อย่างน้อย 1 รายกาาร", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				 not.close(7000);
				
				return false;
			}

    		return true;
    	}
    	
    	return false;
    	
    });
    
    // For Checkbox, Radio
    function GenDateValidator(id, bundled, response) {
        var elements =  $(id[0]).is(':checked');
        if(elements) {
            $("#" + id[1]).val(str_date);
            $("#" + bundled).val(actors);
            $("#" + response).text(str_date);
        } else {
            $("#" + id[1]).val("");
            $("#" + bundled).val("");
            $("#" + response).text("");
        }
    }
    
    // For Dropdown
    function GenDateListValidator(id, bundled, response) {
        var doc_gendate =  $("#" + id[0] + " option:selected").val();
        if(doc_gendate != "" && doc_gendate != "N/A") {
            $("#" + id[1]).val(str_date);
            $("#" + response).text(str_date);
            $("#" + bundled).val(actors);
        } else {
            $("#" + id[1]).val("");
            $("#" + response).text("");
            $("#" + bundled).val("");
        }
    }
    
    
    // New Implement
    if($('#Comment').val() == "") { $('#comment_parent').hide(); } else { $('#comment_parent').show(); }
    $('#comment_tools').click(function() { $('#comment_parent').toggle(); });
    $('#checkedAll').click(function () {    
        $('input[name^="missing_doc"]').prop('checked', this.checked);    
    });
	
});