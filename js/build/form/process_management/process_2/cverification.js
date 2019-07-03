$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    var query  = getQueryParams(document.location.search);
    
    $("#appProgress ul li:first-child").append('<div class="text-muted" style="min-width: 150px; margin-top: 2em; margin-left: -1em;">PROFILE</div>');
    $("#appProgress ul li:nth-child(2)").append('<div class="text-muted" style="min-width: 180px; margin-top: 2em; margin-left: -2.5em;">VERIFICATION</div>');
    $("#appProgress ul li:nth-child(3)").append('<div class="text-muted" style="min-width: 250px; margin-top: 2em; margin-left: -4.2em;">APPLICATION STATUS</div>');
    
    $("#appProgress ul li:first-child").on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P1&live=2'; });
    $("#appProgress ul li:nth-child(2)").on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P2&live=2'; });
    $("#appProgress ul li:nth-child(3)").on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P3&live=2'; });
    
 // Document Refund
    $("#docRefund ul li:first-child").append('<div class="text-muted" style="min-width: 170px; margin-top: 2em; margin-left: -2em;">สร้างรายการเอกสาร</div>');
    $("#docRefund ul li:nth-child(2)").append('<div class="text-muted" style="min-width: 180px; margin-top: 2em; margin-left: -4em;">สำนักงานใหญ่รับเอกสาร</div>');
    $("#docRefund ul li:nth-child(3)").append('<div class="text-muted" style="min-width: 250px; margin-top: 2em; margin-left: -4em;">CA ตรวจสอบเอกสาร</div>');
    $("#docRefund ul li:nth-child(4)").append('<div class="text-muted" style="min-width: 180px; margin-top: 2em; margin-left: -4em;">รับเอกสารคืนจาก CA</div>');
    $("#docRefund ul li:nth-child(5)").append('<div class="text-muted" style="min-width: 250px; margin-top: 2em; margin-left: -6.5em;">สาขารับเอกสารจาก สนญ</div>');
    
    
    // Object Element
	var genPlus		 = $('#genPlus');
    var objProduct   = $('#productprg');
    var objReActive	 = $('#reactivate');
    var objRevisit	 = $('#reactivate');
    var objLackdoc	 = $('#lackdoc_1');
    var lackHidden	 = $('#lackdoc_hidden_1');
    
    // Calendar
    var ncbdate		 = $('#ClndrNCBDate');
    var rmprocessdate= $('#ClndrRMPD');
    var revplan		 = $('#revplan');
    var ems		     = $('#ClndrEMSDate');
    var hqreceivedate= $('#HQReceiveCADate');
    var sendCADate	 = $('#clndrCADate');	
    var ncbsenddate  = $('#objBrnNCBDate');
    var ncbHQGetDate = $('#objHQNCBDatee');
    var objLackDate  = $('#objLackdoc_sendDate');
    var HQsend2Date  = $('#objSentToOperDate');
    
    // object Match
    var prdc_hidden  = $("#productcode_hidden");
    var apv_hidden   = $('#apv_hidden');
    
    var pro_progress = $('#pro_progress');
    var arv_progress = $('#ARP_progress');
    var lack_progress= $('#lack_progress');
    
    pro_progress.hide();
    arv_progress.hide();
    lack_progress.hide();
    
    ncbdate.datepicker({
        format: "dd/mm/yyyy",
        effect: "slide", 
        position: "bottom"
    });

    rmprocessdate.datepicker({
        format: "dd/mm/yyyy",
        effect: "slide", 
        position: "bottom"
    });
	
    revplan.datepicker({
        format: "dd/mm/yyyy",
        effect: "slide", 
        position: "bottom"
    });
    
    ems.datepicker({
        format: "dd/mm/yyyy",
        effect: "slide", 
        position: "bottom"
    });
    
    // Branch Sent NCB 
    ncbsenddate.datepicker({
        format: "dd/mm/yyyy",
        effect: "slide", 
        position: "bottom"
    });
    
   
    
    $('#HQNCBDate').on('click', function() {
    	var calendars = $(this).attr('readonly');	
    	if(calendars != 'readonly') {
    		ncbHQGetDate.datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
   	
    	} else { console.log('ขออภัยคุณไม่ได้สังกัดอยู่สำนักงานใหญ่.'); }
    	
    	
    });
    
    
    $('#HQSentToOperDate').on('click', function() {
    	var calendars = $(this).attr('readonly');	
    	if(calendars != 'readonly') {
    		 HQsend2Date.datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    		
    	} else { console.log('ขออภัยคุณไม่ได้สังกัดอยู่สำนักงานใหญ่.'); }
    	
    });
    
    $('#objHQReceiveCADate').on('click', function() {
    	var calendars = $(this).attr('readonly');	
    	if(calendars == undefined && calendars != 'readonly') {
    		hqreceivedate.datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom"});
    		
    	} else { console.log('ขออภัยคุณไม่ได้สังกัดอยู่สำนักงานใหญ่.'); }
    	
    });
    
    // Missing Date
    $('#lackdoc_sendDate').on('click', function() {
    	var calendars = $(this).attr('readonly');	
    	if(calendars != 'readonly') {
    		objLackDate.datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    		
    	}  else { console.log('ขออภัยคุณไม่ได้สังกัดอยู่สำนักงานใหญ่.'); }
		
	});
    
    $('#CADate').on('click', function() {
    	var calendars = $(this).attr('readonly');	
    	if(calendars != 'readonly') {
    		sendCADate.datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
    		
    	} else { console.log('ขออภัยคุณไม่ได้สังกัดอยู่สำนักงานใหญ่.'); }
    	
    });
    
    // Redio
    var objmissing = $('input[name="lackdoc_notsend"]').attr('readonly');	
	if(objmissing == undefined && objmissing != 'readonly') {
		$('#lackdoc_notsend, #lackdoc_send').prop('disabled', false);  
	} else { 
		$('#lackdoc_notsend, #lackdoc_send').prop('disabled', true);
  
	}
	
    var objSentTO = $('input[name="sendto"]').attr('readonly');	
	if(objSentTO == undefined && objSentTO != 'readonly') {
		$('#sendto, #notsendto').prop('disabled', false);  
	} else { 
		$('#sendto, #notsendto').prop('disabled', true);
  
	}
    	
   
    
   
    
    /*
    $('#checkncbdate').mask('99/99/9999');
    $('#rmprocessdate').mask('99/99/9999');
    $('#reactivatePlan').mask('99/99/9999');
    $('#EMSDate').mask('99/99/9999');
    $('#objHQReceiveCADate').mask('99/99/2999');
    $('#CADate').mask('99/99/9999');
    
    new Pikaday({ field: document.getElementById('checkncbdate'), format: 'DD/MM/YYYY' });
    new Pikaday({ field: document.getElementById('rmprocessdate'), format: 'DD/MM/YYYY' });
    new Pikaday({ field: document.getElementById('reactivatePlan'), format: 'DD/MM/YYYY' });
    new Pikaday({ field: document.getElementById('EMSDate'), format: 'DD/MM/YYYY' });
    new Pikaday({ field: document.getElementById('objHQReceiveCADate'), format: 'DD/MM/YYYY' });
    new Pikaday({ field: document.getElementById('CADate'), format: 'DD/MM/YYYY' });   
    */
    
    if(query['cl'] != '' && query['cl'] == 'b1mods') {
    	$('#HQNCBDate').focus();
    	$('#BrnNCBDate').parent().addClass('warning-state');
    	$('#HQNCBDate').parent().addClass('warning-state');
    	
    }
    
    if(query['cl'] != '' && query['cl'] == 'b2mods') {
    	$('#objHQReceiveCADate').focus();
    	$('#objHQReceiveCADate').parent().addClass('warning-state');
    	
    }
    
    if(query['cl'] != '' && query['cl'] == 'b3mods') {
    	$('#lackdoc_sendDate').focus();
    	$('#lackdoc_sendDate').parent().addClass('warning-state');
    	$('#CADate').parent().addClass('warning-state');
    	$('#parent_list_content').css('border', '1px solid red');
    	
    }
    
    if(query['cl'] != '' && query['cl'] == 'b4mods') {
    	$('#doctype_5').focus();    	
    }
    
    // Autoload: Product List
    $.ajax({
        url: pathFixed+'dataloads/productlist?_=' + new Date().getTime(),
        type: "GET",
        beforeSend:function() {
        	pro_progress.show();
        },
        success:function(data) {

        	 objProduct.first().append('<option value="" selected>-- โปรดเลือก --</option>');
             for(var indexed in data['data']) {
            	 objProduct.append("<option value='"+data['data'][indexed]['ProductCode']+"'>" + data['data'][indexed]['ProductTypes']+ ' ' + data['data'][indexed]['ProductName']+"</option>");
             }

             objProduct.find('option[value="'+prdc_hidden.val()+'"]').attr('selected', 'selected');
            
        },
        complete:function() {
        	pro_progress.after(function() {
            	$(this).hide();
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
    
    // Re Activate Plan
    $.ajax({
        url: pathFixed+'dataloads/revisitList?_=' + new Date().getTime(),
        type: "GET",
        beforeSend:function() {
        	arv_progress.show();
        },
        success:function(data) {

        	objRevisit.first().append('<option value="" selected>-- โปรดเลือก --</option>');
             for(var indexed in data['data']) {
            	 objRevisit.append("<option value='"+data['data'][indexed]['RevisitID']+"'>" + data['data'][indexed]['RevisitReason']+"</option>");
             }

             objRevisit.find('option[value="'+apv_hidden.val()+'"]').attr('selected', 'selected');
            
        },
        complete:function() {
        	arv_progress.after(function() {
            	$(this).hide();
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
    
    // Re Activate Plan
    $.ajax({
        url: pathFixed+'dataloads/lackdoc?_=' + new Date().getTime(),
        type: "GET",
        beforeSend:function() {
        	lack_progress.show();
        },
        success:function(data) {

        	$('select[id^="lackdoc"]').first().append('<option value="" selected>-- โปรดเลือก --</option>');
             for(var indexed in data['data']) {
            	 $('select[id^="lackdoc"]').append("<option value='"+data['data'][indexed]['LackID']+"'>" + data['data'][indexed]['LackDoc']+"</option>");
             }

             objLackdoc.find('option[value="'+lackHidden.val()+'"]').attr('selected', 'selected');
            
        },
        complete:function() {
        	lack_progress.after(function() {
            	$(this).hide();
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
        
    var i = 1;
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $('#parent_list'); //Fields wrapper
    genPlus.on('click', function() {
    	++i;
    	if(i <= max_fields) {
    		wrapper.append(
		    	'<div class="span12">'+
		    		'<div class="span4" style="margin-left: -20px;">&nbsp;</div>'+
		    		'<div class="input-control select span4" style="margin-left: 20px;">'+
		    			'<input type="hidden" name="lackdoc_hidden[]" id="lackdoc_hidden_'+i+'" value="">'+
		    			'<select id="lackdoc_'+i+'" name="lackdocument[]"></select>'+
		    			'</div>'+
		    			'<div id="genPlus_'+i+'" class="span1 fg-red genPlus remove_field">'+
		    				'<i class="fa fa-minus-circle"></i>'+
		    			'</div>'+
		    		'</div>'+
		    	'</div>'
    		 );
    		
    	}
    	
    	// Re Activate Plan
        $.ajax({
            url: pathFixed+'dataloads/lackdoc?_=' + new Date().getTime(),
            type: "GET",
            beforeSend:function() {
            	lack_progress.show();
            },
            success:function(data) {

            	 $('#lackdoc_'+i).first().append('<option value="" selected>-- โปรดเลือก --</option>');
                 for(var indexed in data['data']) {
                	 $('#lackdoc_'+i).append("<option value='"+data['data'][indexed]['LackID']+"'>" + data['data'][indexed]['LackDoc']+"</option>");
                 }

                 $('#lackdoc_'+i).find('option[value="'+lackHidden.val()+'"]').attr('selected', 'selected');
                
            },
            complete:function() {
            	lack_progress.after(function() {
                	$(this).hide();
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
    });

    wrapper.on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove();  max_fields++;
    })
    
    // hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('#back-top').fadeIn();
		} else {
			$('#back-top').fadeOut();
		}
	});

	// scroll body to 0px on click
	$('#back-top a').click(function () {
		$('body, html').animate({
			scrollTop: 0
		}, 800);
		return true;
	});
   
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
    
    
});