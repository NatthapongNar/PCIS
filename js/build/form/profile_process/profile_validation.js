$(document).ready(function() {
	
	// Object Element

	// Field Focus
	
    var rmcode          = $('#rmcode');
    var owner           = $('#owner');
    var telephone       = $('#telephone');
    var mobile          = $('#mobile');
    var downtown        = $('#downtown');
    var province        = $('#province');
    var channels        = $('#channelmodule');

    // Dropdown
	var objSource		= $('#sourceofcustomer');
	var objDue			= $('#duedatestatus');

	// Optional Element
	var objcreatedate	= $('#objcreatedate');
	var DueClndr		= $('#dueclndr');
	var SourceOption	= $('#sourcetextoption');
	var DueOption		= $('#duetextoption')
	
	
	var str;
    var objDate = new Date();
    str = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear();
  
	
	// Hiden freetext
	SourceOption.hide();
	DueOption.hide();
	
	
	// Calendar Pop Up
	$('#createdate').val(str);
	objcreatedate.Datepicker({
		format: "dd/mm/yyyy", // set output format
		effect: "slide", // none, slide, fade
		position: "bottom" // top or bottom,
	});
	
	DueClndr.Datepicker({
		format: "dd/mm/yyyy", // set output format
		effect: "slide", // none, slide, fade
		position: "bottom" // top or bottom,
	});
	
	
	/*
    $('#duedate').mask('99/99/9999');
	new Pikaday({ field: document.getElementById('duedate'), format: 'DD/MM/YYYY' });
    */
	
	// Field Validation	
    rmcode.blur(function(e) {
        e.preventDefault();

        var element_alerted = $('#rmvalidate');
        if($(this).val() != "" && $(this).val() != undefined) {
            element_alerted.html('').parent().removeClass().addClass('input-control text span12 success-state');
        }
        //else { element_alerted.html('* กรุณาระบุรหัสพนักงาน').addClass('text-alert'); }

    });
    
    $("#sourceofcustomer").change(function() {
		var sourcechannel	= $('select[name="sourceofcustomer"] option:selected').val();
	    if(sourcechannel!= "" && sourcechannel != undefined) {
	    	$("#sourceofcustomer").parent().removeClass('error-state').addClass('input-control text span12 success-state');
	    }
	});

	owner.blur(function(e) {
        e.preventDefault();

        var element_alerted = $('#owner_alert');
        if($(this).val() != "" && $(this).val() != undefined) {
            element_alerted.html('*').parent().removeClass().addClass('input-control text span12 success-state');
        }
        else { element_alerted.html('* กรุณาระบุ ชื่อ-นามสกุล ของลูกค้า'); }

    });
	
	$("#businesstype").change(function() {
		var sourcechannel	= $('select[name="businesstype"] option:selected').val();
	    if(sourcechannel!= "" && sourcechannel != undefined) {
	    	$("#businesstype").parent().removeClass('error-state').addClass('input-control text span12 success-state');
	    }
	});

    downtown.blur(function(e) {
        e.preventDefault();

        var element_alerted = $('#downtown_alert');
        if($(this).val() != "" && $(this).val() != undefined) {
            element_alerted.html('*').parent().removeClass().addClass('input-control text span12 success-state');
        }
        else { element_alerted.html('* กรุณาระบุย่านธุรกิจของลูกค้า'); }

    });
    
    $('#postcode').blur(function(e) {
        e.preventDefault();

        var element_alerted = $('#postcode_alert');
        if($(this).val() != "" && $(this).val() != undefined) {
            element_alerted.html('*').parent().removeClass().addClass('input-control text span12 success-state');
        }
        else { 
        	var not = $.Notify({ content: "กรุณาระบุรหัสไปรษณีย์", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        	element_alerted.html('* กรุณาระบุรหัสไปรษณีย์');
			not.close(7000);
        }

    });

    telephone.blur(function(e) {
        e.preventDefault();

        var element_alerted = $('#tel_alert');
        if(mobile.val() != "" && mobile != undefined && mobile.val().length >= 9) {
            element_alerted.html('*').parent().removeClass().addClass('input-control text span12 success-state').css('margin-left', '20px');

        } else {

            if($(this).val() != "" && $(this).val() != undefined && $(this).val().length >= 9) {
                element_alerted.html('*').parent().removeClass().addClass('input-control text span12 success-state').css('margin-left', '20px');
                $('#mobile_alert').html('');
            }
            else { element_alerted.html('* กรุณาระบุเบอร์ติดต่อ'); }
        }

    });

    mobile.blur(function(e) {
        e.preventDefault();

        var element_alerted = $('#mobile_alert');
        if(telephone.val() != "" && telephone != undefined && telephone.val().length >= 9) {
            element_alerted.html('*').parent().removeClass().addClass('input-control text span12 success-state').css('margin-left', '20px');

        } else {
            if($(this).val() != "" && $(this).val() != undefined && $(this).val().length >= 9) {
                element_alerted.html('*').parent().removeClass().addClass('input-control text span12 success-state').css('margin-left', '20px');
                $('#tel_alert').html('*');
            }
            else { element_alerted.html('* กรุณาระบุเบอร์ติดต่อ 2'); }
    }


    });

	
	// Show, Hide Auto Toggle
	objSource.on('change', function() {
		var freetext = $('#sourcetextoption');
		var source	 = $('select[name="sourceofcustomer"] option:selected').val(); 
		if(source == 'อื่นๆ') freetext.show();
		else freetext.hide();
	});
	
	objDue.on('change', function() {
		var freetext = $('#duetextoption');
		var source	 = $('select[name="duedatestatus"] option:selected').val();
		if(source == 0)  { 
			freetext.show(); 
			//$('#duedate').val(str).fadeIn();
			
		} else {
			
			if(source == 'N/A') {
				freetext.hide();
				$('#duedate').val('');
			} else {
				freetext.hide(); 
				//$('#duedate').val(str).fadeIn();
			}
		}		
	});
	
	$('#criteria').on('click', function() {
		var objCriteria = $(this).is(':checked');
		if(objCriteria) {
			$('#criteria_parent').removeClass('input-control select span4 success-state').addClass('input-control select span4 error-state');
			
		} else {
			$('#criteria_parent').removeClass('input-control select span4 error-state').addClass('input-control select span4 success-state');
		}
		
	});
	
	$('#profiler').submit(function(e) {
		
		var rmcode			= $("#rmcode").val();
		var ownertype		= $('input[name="ownertype"]:checked').val();
		var loangroup		= $('input[name="loan_group"]:checked').val();
		var owner			= $("#owner").val();
		var tel				= $("#telephone").val();
		var business_type   = $('select[name="businesstype"] option:selected').val();
		var mobile			= $("#mobile").val();
		var downtown		= $("#downtown").val();
		var province		= $("#province").val();
		var channel_type	= $('select[name="channelmode"]').val();
		var channel			= $('select[name="channelmodule"]').val();
		var sourcechannel	= $('select[name="sourceofcustomer"] option:selected').val();
		var referralcode	= $('#referralcode').val();
		var criteria_reas	= $('select[name="criteria_reason"] option:selected').val();
		var sel_source	    = $('select[name="duedatestatus"] option:selected').val();
		var sel_source_date = $('#duedate').val();
		
		if(confirm('ยืนยันการบันทึกข้อมูล')) {

			if(rmcode == "" || rmcode == undefined) {
                var element_alerted = $('#rmvalidate')
				var not = $.Notify({ content: "กรุณาระบุรหัสพนักงาน (RM Code)", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				 
				$("#rmcode").focus().parent().addClass('error-state');
                //element_alerted.html('* กรุณาระบุรหัสพนักงาน');
				
				return false;
			}
			
			if(rmcode.length < 5) {
                var element_alerted = $('#rmvalidate')
				var not = $.Notify({ content: "กรุณาระบุรหัสพนักงานให้ครบถ้วน (RM Code)", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				 
				$("#rmcode").focus().parent().addClass('error-state');
                //element_alerted.html('* กรุณาระบุรหัสพนักงาน');
				
				return false;
			}
			
			if(sourcechannel == "" || sourcechannel == undefined) {
				var not = $.Notify({ content: "คุณเลือกแหล่งที่มาของลูกค้า", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);			
				
				$("#sourceofcustomer").focus().parent().addClass('error-state');				
				return false;
				
			} else {
				$("#sourceofcustomer").parent().removeClass('error-state');
			}
			
			if(loangroup == undefined || loangroup == "") {
                 var element_alerted = $('#loan_gruop_alert');
				 var not = $.Notify({ content: "กรุณาระบุประเภทสินเชื่อที่นำเสนอ", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				 not.close(7000);
				 
				 $('input[name="loan_group"]')[0].focus();
                 element_alerted.html('* กรุณาระบุประเภทสินเชื่อที่นำเสนอ');
				 
				 return false;
			}
			
			if(ownertype == undefined || ownertype == "") {
                 var element_alerted = $('#owner_alert');
				 var not = $.Notify({ content: "กรุณาระบุประเภทลูกค้า", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				 not.close(7000);
				 
				 $('input[name="ownertype"]')[0].focus();
                 element_alerted.html('* กรุณาระบุประเภทลูกค้า');
				 
				return false;
			}
			
			if(owner == "" || owner == undefined) {
                 var element_alerted = $('#owner_alert');
				 var not = $.Notify({ content: "กรุณาระบุชื่อลูกค้า", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				 not.close(7000);
				 
				 $("#owner").focus().parent().addClass('error-state');
                 element_alerted.html('* กรุณาระบุชื่อลูกค้า');
				
				return false;	
			}
			
			if(business_type == "" || business_type == "N/A" || business_type == undefined) {

                var element_alerted = $('#businesstype_alert');
				var not = $.Notify({ content: "กรุณาระบุประเภทธุรกิจ", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				
				$("#businesstype").focus().parent().addClass('error-state');
                element_alerted.html('กรุณาระบุประเภทธุรกิจ');

				return false;
			}
			
			if(tel == "" && mobile == "" || tel == undefined && mobile == undefined) {

				 var tel_not 	= $.Notify({ content: "กรุณาระบุเบอร์ติดต่อ", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				 tel_not.close(7000);
				 
				 var mobile_not = $.Notify({ content: "กรุณาระบุเบอร์ติดต่อ 2", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				 mobile_not.close(7000);
				 
				 $("#telephone").parent().addClass('error-state');
				 $("#mobile").focus().parent().addClass('error-state');
				
				return false;	
			}
			
			if(tel && tel !== "") {
				if(tel && tel.length < 9) {
					var tel_not 	= $.Notify({ content: "โปรดตรวจสอบเบอร์ติดต่อใหม่อีกคร้ง", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
					tel_not.close(7000);
					$("#telephone").parent().addClass('error-state');
					return false;
					
				}
			}
			
			if(mobile && mobile !== "") {
				if(mobile && mobile.length < 9) {
					var tel_not 	= $.Notify({ content: "โปรดตรวจสอบเบอร์ติดต่อใหม่อีกคร้ง", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
					tel_not.close(7000);
					$("#telephone").parent().addClass('error-state');
					return false;
					
				}
			}
			
			if(downtown == "" || downtown == undefined) {

                var element_alerted = $('#downtown_alert');
				var not = $.Notify({ content: "กรุณาระบุย่านธุรกิจของลูกค้า", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				
				$("#downtown").focus().parent().addClass('error-state');
                element_alerted.html('* กรุณาระบุย่านธุรกิจของลูกค้า');
				
				return false;	
			}
			
			if(province == "" || province == "N/A" || province == undefined) {

                var element_alerted = $('#province_alert');
				var not = $.Notify({ content: "กรุณาระบุจังหวัด", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				
				$("#province").focus().parent().addClass('error-state');
                element_alerted.html('กรุณาระบุจังหวัด');

				return false;
			}
			
			if(postcode == "" || postcode == undefined) {

                var element_alerted = $('#downtown_alert');
				var not = $.Notify({ content: "กรุณาระบุรหัสไปรษณีย์", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				
				$("#postcode").focus().parent().addClass('error-state');
                element_alerted.html('* กรุณาระบุรหัสไปรษณีย์');
				
				return false;	
			}
			
			
			if(channel_type == "" || channel_type == undefined) {

                var element_alerted = $('#channelmode_alert');
				var not = $.Notify({ content: "กรุณาระบุช่องทางข่าวสาร", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				
				$('select[name="channelmode"]').focus().parent().addClass('error-state');
                element_alerted.html('* กรุณาระบุช่องทางข่าวสาร');
				
				return false;
			}
			
			if(channel == "" || channel == "N/A" || channel == undefined) {

                var element_alerted = $('#channel_alert');
				var not = $.Notify({ content: "กรุณาระบุช่องทางข่าวสาร", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				
				$("#channelmodule").focus().parent().addClass('error-state');
                element_alerted.html('* กรุณาระบุช่องทางข่าวสาร');
				
				return false;
			}
			
			if($('#criteria').is(':checked') == true) {
				var criteria = $(this).is(':checked');
				if(criteria == true && criteria_reas == undefined || criteria_reas == '') {
					
					var element_alerted = $('#criteria_alert');
					var not = $.Notify({ content: "กรุณาเลือกเหตุผล", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
					not.close(7000);
					
					$("#criteria_alert").focus().parent().addClass('error-state');
	                element_alerted.html('* กรุณาเลือกเหตุผล');
					
					return false;
				}
			}
			
			if(sourcechannel == "Refer: Thai Life" && referralcode == '') {
				
				var element_alerted = $('#refer_alert');
				var not = $.Notify({ content: "คุณเลือกช่องทางตัวแทน กรุณาระบุหมายเลขตัวแทน", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				
				$("#refer_alert").focus().parent().addClass('error-state');
                element_alerted.html('* กรุณาระบุรหัสตัวแทน');
                /*
                $.Dialog({
                    shadow: true,
                    overlay: true,
                    draggable: true,
                    icon: '<i class="fa fa-edit"></i>',
                    title: 'TLA EDITOR',
                    height: 150,
                    width: 400,
                    padding: 10,
                    content: 'Please trying dialog reload.',
                    onShow: function() {
                    	
                   	 var content = 
                   		 '<div style="padding-left: 7%;">' +                   	
	                   	    '<div class="input-control text field_scale">' +
		                	    '<label class="label">TLA CODE</label>' +
		                	    '<input id="tla_code" name="tla_code" type="text" value="" class="size5" onkeypress="validate(event)" style="border-bottom-color: #16499A;"  maxlength="8">' +
		                	    '<i id="check_icon" class="fa fa-search" onclick="field_validation(\'#tla_code\');" style="font-size: 1.3em; cursor: pointer; margin-left: 5px; color: #666;"></i>' +
	                	    '</div>' +             	
                    	'</div>';
                   	
                        $.Dialog.content(content);
                 
                    }

                });
            	*/			
				return false;
			}
			
			if(sourcechannel == "Refer: Thai Life" && referralcode.length < 8) {
				
				var element_alerted = $('#refer_alert');
				var not = $.Notify({ content: "รหัสตัวแทนน้อยกว่า 8 หลัก กรุณาตรวจสอบใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
				not.close(7000);
				
				$("#refer_alert").focus().parent().addClass('error-state');
                element_alerted.html('* กรุณาตรวจสอบรหัสตัวแทน.');
                
                return false;
				
			}
				
			return true;
			
		}
		
		return false;
		
	});

    // Field Validation

	
	// Mask field
	function maskInputSpecified() {
        $('#rmcode').mask("9999999");
		$('#rmmobile').mask('9999999999');
		$("#telephone").mask('99999999999999');
		$("#mobile").mask("999999999999999");
		$("#loanrequest").number(true, 0);
		
	}
	
	maskInputSpecified();
	
});