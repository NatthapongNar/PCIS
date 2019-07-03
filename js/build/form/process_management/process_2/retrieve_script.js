$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    var query  = getQueryParams(document.location.search);
    
    // Object Date
    var str_date;
    var objDate = new Date();
    	str_date	= ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear(); // Set Date format DD/MM/YYYY
    
    
    // Service
    var service_path = 'http://172.17.9.65/WsLendingBranchServices/PCISService.svc/';
    var service_path_v2 = 'http://172.17.9.208:80/TCFSApi/api/Application/pcis/';
    
    // Identity: Event Modal
    $('#retrieve_reason').on('change', function() {
    
    	$('#RetrieveModal').modal({
  			 show: true,
   			 keyboard: false,
   			 backdrop: 'static'
		}).draggable();	
    	
    	$('#retrieveDate, #objRetrieveDate').val(str_date);
    	
    });
    
    var bpm_form 	= $('#retrieve_bpm_information');
    var confirmName = $('#retrieve_confirm_fieldCustname');
    var id_progress = $('#retrieve_identity_progress');
    var btnVerify	= $('#retrieve_btnIdentityVerify');
    
    bpm_form.hide();
    confirmName.hide();
    id_progress.hide(); // Progress    
    
    // Check Identities.
    
    $('#retrieve_identity_verification').hide();
    $('#retrieve_identity_custname').hide();
    $('#retrieve_identity_custlastname').hide();

    var is_idenable		= true;
	var is_validate 	= false;
	$('#retrieve_btnRetrieveIdentityVerify').on('click', function() {

    	var card_no	 	= $('#retrieve_identity_cardno').val();
    	var custname 	= $('#retrieve_custname_identity').val();
    	var lastname 	= $('#retrieve_custlastname_identity').val();
    	
    	$('#retrieve_msg_identityresponsed').empty();
    	if(card_no == "") {    
    		
    		$('#parent_retrieve_identity_cardno').removeClass('success-state').addClass('error-state');
    		$('#retrieve_identity_verification').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
    		$('#retrieve_msg_identityresponsed').append('<span id="s1_identity"><i class="fa fa-exclamation-circle"></i> กรุณากรอกหมายเลขบัตรประชาชน และชื่อ-นามสกุล เพื่อทำการตรวจสอบข้อมูล.</span>');
    	
    	} else { 
    		
    		if(card_no.length < 13) {
       		 	$('#retrieve_msg_identityresponsed').html('<i class="fa fa-exclamation-circle"></i> กรุณากรอกหมายเลขบัตรประชาชนให้ครบ 13 หลัก.');   		 
       		 	$('#parent_retrieve_identity_cardno').removeClass('success-state').addClass('error-state');
     			$('#retrieve_identity_verification').addClass('fa fa-remove fg-red marginLeft5').show();
        	}
    		
    	}
    	
    	if(custname == "" && lastname == "") {   		 
   		 	$('#parent_retrieve_custname_identity').removeClass('success-state').addClass('error-state');
   		 	$('#parent_retrieve_custlastname_identity').removeClass('success-state').addClass('error-state');
   		 	
 			$('#retrieve_identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
 			$('#retrieve_identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
 			
    		$('#retrieve_msg_identityresponsed').append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> กรุณากรอกข้อมูลชื่อ-นามสกุลลูกค้าให้ถูกต้อง.</div>');
    	
     	} else {
     		
     		if(custname == "") {   		 
       		 	$('#parent_retrieve_custname_identity').removeClass('success-state').addClass('error-state');
     			$('#retrieve_identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
        		$('#retrieve_msg_identityresponsed').append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> กรุณากรอกข้อมูลชื่อลูกค้าให้ถูกต้อง.</div>');
     		}
     		
     		if(lastname == "") {   		 
        		$('#parent_retrieve_custlastname_identity').removeClass('success-state').addClass('error-state');
    	 		$('#retrieve_identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
    	 		$('#retrieve_msg_identityresponsed').append('<div id="cust_kp2" style="margin-left: -60px !important;"><i class="fa fa-exclamation-circle"></i> กรุณากรอกข้อมูลนามสกุลลูกค้าให้ถูกต้อง.</div>');
        	
         	} 
     		
     	}

    	if(is_idenable) {
	    	if(card_no != "" && custname != "" && lastname != "") {
	    		checkNCBV2(card_no, custname, lastname);
	    	}
	    	
    	} else {
    		var not = $.Notify({ content: "ขออภัย!! ไม่สามารถใช้งานฟังก์ชั่นนี้ได้ เนื่องจากอยู่ระหว่างปรับปรุงระบบ...", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    		not.close(7000);
    	}
    	
     
    });
	
	function checkNCBV2(card_no, custname, lastname) {		
		var empcode = $('#Emp_ID').val();
		$.ajax({
			url: service_path_v2 + 'filter/' + empcode,
			type: "POST",
			header: { 'Content-Type': 'application/json' },
			dataType : 'json',
			data: {
				"IDNumber": card_no
			},			
			beforeSend: function() {	 
				id_progress.show();
				$('#msg_identityresponsed').text('');  		
			},
			success: function(data) {
				if(_.isEmpty(data)) {
					checkNCBV1(card_no, custname, lastname);					
				} else {
					id_progress.after(function() { $(this).hide(); });

					var data_sort = _.orderBy(data, ['CreateDate'], ['desc']);

					var appno_draft = (data) ? data[0].ApplicationNo : null;
					var appno = (data_sort && data_sort[0]) ? data_sort[0].ApplicationNo : appno_draft;

					if(!_.isEmpty(appno)) {
						
						is_validate = true;
						var objresponsed   = data[0];  
						var customer = (objresponsed && objresponsed !== '') ? objresponsed['FullNameTH'].split(' ') : null;
						var firstname = (!_.isEmpty(customer) && customer !== '') ? customer[0]:'';
						var surname = (!_.isEmpty(customer) && customer !== '') ? customer[1]:'';
	        			
	        			// Check has data in BPM Sytem
	        			bpm_form.show(); 
	        			btnVerify.hide();
	        			
	        			// Append Data to field
	        			$('#retrieve_appno_hideresponsed, #appno_responsed').val(appno);
	        			$('#retrieve_custname_hideresponsed, #custname_responsed').val(firstname);
	        			$('#retrieve_custlastname_hideresponsed, #custlastname_responsed').val(surname);
	        				  	        			
	        			if(is_validate) {	  	        					  	    
	        				
	        				var validation_form = [];
	        				if(custname != firstname && lastname != surname) {
  							
	        					$('#parent_retrieve_custname_identity, #parent_custlastname_identity').removeClass('success-state').addClass('error-state');	  	        		   		 	
	        		   		 	$('#parent_retrieve_custname_responsed, #parent_custlastname_responsed').removeClass('success-state').addClass('error-state');
	        		   		 	
	        		 			$('#retrieve_identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	        		 			$('#retrieve_identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	        		 			
	        		    		$('#retrieve_msg_identityresponsed').append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลชื่อ-นามสกุลลูกค้าให้ถูกต้อง.</div>');
  							
	  	        			} else {
	  	        				
	  	        				if(custname != firstname) {
	  	        					$('#parent_retrieve_custname_responsed').removeClass('success-state').addClass('error-state');
	  	        					$('#parent_retrieve_custname_identity').removeClass('success-state').addClass('error-state');		  	        					
	  	        	     			$('#retrieve_identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	  	        	        		$('#retrieve_msg_identityresponsed').append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลชื่อลูกค้าให้ถูกต้อง.</div>');   	
	  	        	        		validation_form.push('FALSE');
	  	        	        		
		  	        			} else { validation_form.push('TRUE'); }
	  	        				
	  	        	     		if(lastname != surname) {   		 
	  	        	     			$('#parent_retrieve_custlastname_responsed').removeClass('success-state').addClass('error-state');
	  	        	        		$('#parent_retrieve_custlastname_identity').removeClass('success-state').addClass('error-state');
	  	        	    	 		$('#retrieve_identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	  	        	    	 		$('#retrieve_msg_identityresponsed').append('<div id="cust_kp2" style="margin-left: -60px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลนามสกุลลูกค้าให้ถูกต้อง.</div>');
	  	        	    	 		validation_form.push('FALSE');
	  	        	    	 		
	  	        	     		} else { validation_form.push('TRUE'); }
	  	        	     		
	  	        	     		if(in_array('TRUE', validation_form)) {
	  	        	     			
	  	        	     			$('#parent_retrieve_custname_identity, #parent_custname_responsed').removeClass('error-state').addClass('success-state');
	  	        	     			$('#retrieve_identity_custname').removeClass('fa fa-remove fg-red marginLeft5').addClass('fa fa-check fg-green marginLeft5').show();
	  	        	     			
	  	        	     			$('#parent_retrieve_custlastname_identity, #parent_custlastname_responsed').removeClass('error-state').addClass('success-state');
	  	        	    			$('#retrieve_identity_custlastname').removeClass('fa fa-remove fg-red marginLeft5').addClass('fa fa-check fg-green marginLeft5').show();
	  	        	    			
	  	        	    			$('#retrieve_confirmIdentity').prop('disabled', false);
	  	        	    			
	  	        	     		}	  	        				
	  	        			}	        				
	        			} 

					} else {
						checkNCBV1(card_no, custname, lastname);
					}
				}				
			},
			timeout: 15000,
			statusCode: {
				404: function() { console.log( "page not found." ); },
				407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); },
				500: function() { console.log("internal server error."); }
			}
		});
		
	}
	
	
	function checkNCBV1(card_no, custname, lastname) {
		$.ajax({
	    	  url: service_path + 'GetApplicationByCardNo',
	    	  data: { cardno: card_no },
	          type: "GET",
	          jsonpCallback: "retrieve_identities_state",
	          dataType: "jsonp",
	          crossDomain: true,
	          beforeSend:function() {	 
	        	  id_progress.show();
	        	  $('#retrieve_msg_identityresponsed').text(''); 
	        		
	          },
	          success:function(data) {
	        	 $('#err_responsed').remove();
	        	 if(data.Code == '200') {
	        		if(data.Data[0] == "" || data.Data[0] == undefined) {
	        			
	        			// Identities Card
	        			$('#parent_retrieve_identity_cardno').removeClass('success-state').addClass('error-state');
	        			$('#retrieve_identity_verification').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	          	
	        			// Custname and Lastname
	        			$('#parent_retrieve_custname_identity').removeClass('success-state').addClass('error-state');
	         		 	$('#parent_retrieve_custlastname_identity').removeClass('success-state').addClass('error-state');
	         		 	
	  	       			$('#retrieve_identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	  	       			$('#retrieve_identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	  	       			
	  	       			$('#retrieve_msg_identityresponsed').append('<span id="s1_identity"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณาตรวจสอบหมายเลขบัตรประชาชน และชื่อ-นามสกุลใหม่อีกครั้ง.</span>');
	        			 
	        		 } else {
	        			 
	        			is_validate = true;
	        			var objresponsed   = data.Data[0];  
	        			
	        			// Check has data in BPM Sytem
	        			bpm_form.show(); 
	        			btnVerify.hide();
	        			
	        			// Append Data to field
	        			$('#retrieve_appno_hideresponsed, #appno_responsed').val(objresponsed['APPLICATION_NO']);
	        			$('#retrieve_custname_hideresponsed, #custname_responsed').val(objresponsed['TH_FIRST_NAME']);
	        			$('#retrieve_custlastname_hideresponsed, #custlastname_responsed').val(objresponsed['TH_LAST_NAME']);
	        				  	        			
	        			if(is_validate) {	  	        					  	    
	        				
	        				var validation_form = [];
	        				if(custname != objresponsed['TH_FIRST_NAME'] && lastname != objresponsed['TH_LAST_NAME']) {
  							
	        					$('#parent_retrieve_custname_identity, #parent_custlastname_identity').removeClass('success-state').addClass('error-state');	  	        		   		 	
	        		   		 	$('#parent_retrieve_custname_responsed, #parent_custlastname_responsed').removeClass('success-state').addClass('error-state');
	        		   		 	
	        		 			$('#retrieve_identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	        		 			$('#retrieve_identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	        		 			
	        		    		$('#retrieve_msg_identityresponsed').append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลชื่อ-นามสกุลลูกค้าให้ถูกต้อง.</div>');
  							
	  	        			} else {
	  	        				
	  	        				if(custname != objresponsed['TH_FIRST_NAME']) {
	  	        					$('#parent_retrieve_custname_responsed').removeClass('success-state').addClass('error-state');
	  	        					$('#parent_retrieve_custname_identity').removeClass('success-state').addClass('error-state');		  	        					
	  	        	     			$('#retrieve_identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	  	        	        		$('#retrieve_msg_identityresponsed').append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลชื่อลูกค้าให้ถูกต้อง.</div>');   	
	  	        	        		validation_form.push('FALSE');
	  	        	        		
		  	        			} else { validation_form.push('TRUE'); }
	  	        				
	  	        	     		if(lastname != objresponsed['TH_LAST_NAME']) {   		 
	  	        	     			$('#parent_retrieve_custlastname_responsed').removeClass('success-state').addClass('error-state');
	  	        	        		$('#parent_retrieve_custlastname_identity').removeClass('success-state').addClass('error-state');
	  	        	    	 		$('#retrieve_identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
	  	        	    	 		$('#retrieve_msg_identityresponsed').append('<div id="cust_kp2" style="margin-left: -60px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลนามสกุลลูกค้าให้ถูกต้อง.</div>');
	  	        	    	 		validation_form.push('FALSE');
	  	        	    	 		
	  	        	     		} else { validation_form.push('TRUE'); }
	  	        	     		
	  	        	     		if(in_array('TRUE', validation_form)) {
	  	        	     			
	  	        	     			$('#parent_retrieve_custname_identity, #parent_custname_responsed').removeClass('error-state').addClass('success-state');
	  	        	     			$('#retrieve_identity_custname').removeClass('fa fa-remove fg-red marginLeft5').addClass('fa fa-check fg-green marginLeft5').show();
	  	        	     			
	  	        	     			$('#parent_retrieve_custlastname_identity, #parent_custlastname_responsed').removeClass('error-state').addClass('success-state');
	  	        	    			$('#retrieve_identity_custlastname').removeClass('fa fa-remove fg-red marginLeft5').addClass('fa fa-check fg-green marginLeft5').show();
	  	        	    			
	  	        	    			$('#retrieve_confirmIdentity').prop('disabled', false);
	  	        	    			
	  	        	     		}
	  	        				
	  	        			}
	        			
	        			} 

	        		 }	  	        		 
	        		 
	        	 } else {
	        		$('#retrieve_msg_identityresponsed').append('<div id="err_responsed"><i class="fa fa-exclamation-circle"></i> เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง.</div>');
	        		 
	        	 }
		  	        	  
	          },
	          complete:function() {
	        	  id_progress.after(function() { $(this).hide(); });	     	        	
	        	  
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
	
	// Block copy, cut, paste text
	//$('#retrieve_identity_cardno').bind("cut copy paste",function(e) { e.preventDefault(); });
	
    $('#retrieve_identity_cardno').keyup(function() {  
    	
    	if($(this).val().length == 0) {
    		btnVerify.show();
    	}
    	
    	if($(this).val() != "" && $(this).val().length >= 13) {   
    		
    		if(checkPersonID($(this).val())) {        		
        		$('#parent_retrieve_identity_cardno').removeClass('error-state warning-state').addClass('success-state');
     			$('#retrieve_identity_verification')
     				.removeClass().removeClass('fa fa-remove fg-red marginLeft5')
     				.addClass('fa fa-check fg-green marginLeft5')
     				.show();
     			
     			$('#card_kp1').remove();
     			
    		} else {
    			
    			$('#parent_retrieve_identity_cardno').removeClass('success-state error-state').addClass('warning-state');
        		$('#retrieve_identity_verification').removeClass().hide();
        		$('#retrieve_msg_identityresponsed').empty()
        		.append(
        			'<div id="card_kp1" class="text-warning"><i class="fa fa-info-circle"></i> กรุณตรวจสอบหมายเลขบัตรประชาชนใหม่อีกครั้ง. <br/>' +
        			'<p style="font-size: 0.9em; margin-top: 10px; padding: 0 5px; text-align: left">' +
        			'<span style="font-weight: bold;">หมายเหตุ</span> : หากท่านตรวจสอบหมายเลขบัตรประชาชนของลูกค้าถูกต้อง ท่านสามารถกดปุ่มตรวจสอบได้' +
        			'เนื่องจากโปรแกรมทำการตรวจสอบความถูกต้องของหมายเลขบัตรประชาชน<span style="text-decoration: underline;">ตามหลักการคำนวณ</span>ในการสร้างหมายเลขบัตรประชาชน.<p></div>' 
        		);
        		
    		}
    		
	
    	} else {
    		    		
    		$('#parent_retrieve_identity_cardno').removeClass('success-state warning-state').addClass('error-state');
    		$('#retrieve_identity_verification').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
    		$('#retrieve_msg_identityresponsed').empty().append('<div id="card_kp1"><i class="fa fa-exclamation-circle"></i> กรุณากรอกหมายเลขบัตรประชาชนให้ครบ 13 หลัก.</div>');
    		
    	}
    	
    });
    
    $('#retrieve_custname_identity').keyup(function() {

    	if(is_validate) {
    		
    		if($(this).val() != $('#retrieve_custname_hideresponsed').val()) {
    			 $('#parent_retrieve_custname_identity, #parent_retrieve_custname_responsed').removeClass('success-state').addClass('error-state');
        		 $('#retrieve_identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
    			 $('#retrieve_msg_identityresponsed').empty().append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลชื่อลูกค้าให้ถูกต้อง.</div>');
    			 
    			 input_validation();
    			
    		} else {
    			$('#parent_retrieve_custname_identity, #parent_retrieve_custname_responsed').removeClass('error-state').addClass('success-state');
     			$('#retrieve_identity_custname').removeClass('fa fa-remove fg-red marginLeft5').addClass('fa fa-check fg-green marginLeft5').show();
     			$('#cust_kp1').remove();
     			
     			input_validation();
     		
    		}
    		
    	} else {
    		
    		if($(this).val() != "") {    		
        		$('#parent_retrieve_custname_identity').removeClass('error-state');//.addClass('success-state');
     			$('#retrieve_identity_custname').removeClass().hide();//.addClass('fa fa-check fg-green marginLeft5').show();
     			$('#cust_kp1').remove();
     		
        	} else {    
  
        		 $('#parent_retrieve_custname_identity').removeClass('success-state').addClass('error-state');
        		 $('#retrieve_identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
        		 $('#retrieve_msg_identityresponsed').empty().append('<div id="cust_kp1" style="margin-left: -70px !important;"><i class="fa fa-exclamation-circle"></i> กรุณากรอกข้อมูลชื่อลูกค้าให้ถูกต้อง.</div>');
        		 
        	}
    		
    	}
    	
    });
 
	$('#retrieve_custlastname_identity').keyup(function() {
			
	 	if(is_validate) {
    		
    		if($(this).val() != $('#retrieve_custlastname_hideresponsed').val()) {
    			 $('#parent_retrieve_custlastname_identity, #parent_retrieve_custlastname_responsed').removeClass('success-state').addClass('error-state');
    	 		 $('#retrieve_identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
    	 		 $('#retrieve_msg_identityresponsed').empty().append('<div id="cust_kp2" style="margin-left: -60px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลนามสกุลลูกค้าให้ถูกต้อง.</div>');
    	 		 
    	 		input_validation();
    			
    		} else {
    			$('#parent_retrieve_custlastname_identity, #parent_custlastname_responsed').removeClass('error-state').addClass('success-state');
    			$('#retrieve_identity_custlastname').removeClass('fa fa-remove fg-red marginLeft5').addClass('fa fa-check fg-green marginLeft5').show();
    			$('#cust_kp2').remove();
    			
    			input_validation();
    			
    		}
    		
    	} else {
    		
    		if($(this).val() != "") {    		
    	 		$('#parent_retrieve_custlastname_identity').removeClass('error-state');//.addClass('success-state');
    			$('#retrieve_identity_custlastname').removeClass().hide();//.addClass('fa fa-check fg-green marginLeft5').show();
    			$('#cust_kp2').remove();
    				
    				
    	 	} else {    		 	
    	 		 $('#parent_retrieve_custlastname_identity').removeClass('success-state').addClass('error-state');
    	 		 $('#retrieve_identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
    	 		 $('retrieve_#msg_identityresponsed').empty().append('<div id="cust_kp2" style="margin-left: -70px !important;"><i class="fa fa-exclamation-circle"></i> กรุณากรอกข้อมูลนามสกุลลูกค้าให้ถูกต้อง.</div>');
    	 		 
    	 	}
    		
    	}
	 	
	});
	
	var input_validation = function() {
		
		if($('#retrieve_custname_identity').val() == $('#retrieve_custname_hideresponsed').val() && $('#retrieve_custlastname_identity').val() == $('#retrieve_custlastname_hideresponsed').val()) {			
			$('#retrieve_confirmIdentity').prop('disabled', false);			
		} else {			
			$('#retrieve_confirmIdentity').prop('disabled', true);
		}

	}

	function checkPersonID (id) {
		if(id.length != 13) return false;
 
		for(i=0, sum=0; i < 12; i++) sum += parseFloat(id.charAt(i))*(13-i);
 
		if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false;
 
		return true;
		
	}
	
	$('#retrieve_confirmIdentity').on('click', function() {
		
		if($('#retrieve_custname_identity').val() == $('#retrieve_custname_hideresponsed').val() && $('#retrieve_custlastname_identity').val() == $('#retrieve_custlastname_hideresponsed').val()) {
			
			var doc_id	 = query['rel'];
			var app_no 	 = $('#retrieve_appno_hideresponsed').val();
			var retrieve = $('select[name="retrieve_reason"] option:selected').val();
			var redate	 = $('#retrieveDate').val();
		
			$.ajax({
				  url: pathFixed + 'defend_control/setRetrieveOnbundled?_=' + new Date().getTime(),
	  	    	  data: { 
	  	    		  docix: doc_id,
	  	    		  appnx: app_no,	  	    		  
	  	    		  reasx: retrieve,
	  	    		  rdate: redate
	  	    	  },
	  	          type: "POST",
	  	          beforeSend:function() { id_progress.show(); },
	  	          success:function(responsed) {	
	  	        	  
	  	        	  var parser = JSON.parse(responsed);	  	        	
	  	        	  if(parser['status']) {
	  	        		  
	  	        		  var borrowername  = $('#retrieve_custname_identity').val() + ' ' + $('#retrieve_custlastname_identity').val();
		  				  $('#id_card, #id_card_dump').val($('#retrieve_identity_cardno').val());
		  				  var main_borrower = $('#NCBName_1').val();
		  				  $('#NCBName_1').val(main_borrower + '(RET)');
		  				
		  				  $('#RetrieveModal').modal('hide');  
		  				  
		  				  $('#rmprocess').find('option[value="ระหว่างติดตามเอกสาร"]').prop('selected', true);
		  	        	  $('#rmprocessdate').val(moment().format('DD/MM/YYYY'))
		  	        	  $('#rmprocessdate_fake, #rmprocessdate_draft').val(moment().format('DD/MM/YYYY'));
		  				  
		  				var not = $.Notify({ content: "โปรดบันทึกข้อมูลเพื่อทำการ Retrieved.", style: { background: 'green', color: '#FFFFFF' }, timeout: 10000 });
  	        				not.close(8000);
		  				  
	  	        	  } else {
	  	        		var not = $.Notify({ content: "ขออภัย! เกิดข้อผิดพลาดในระบบ กรุณายืนยันใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	  	        			not.close(8000);
	  	        	  }
	  	        	  	  	        	   	      
	  	          },
	  	          complete:function() {
	  	        	  id_progress.after(function() { $(this).hide(); });	  	        	   	        	
	  	        	  
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
	 

    $('#retrieve_cancelIdentity').on('click', function() { 
    	$('#RetrieveModal').modal('hide');     	
    	$('#retrieveDate, #objRetrieveDate').val('');
    	$('#retrieve_reason').find('option[value=""]').prop('selected', true);
    	
    });
    
    // check confirm field in identify form
    $('#retrieve_identity_cardno').bind('change', function() {
    	bpm_form.hide(); 
    	$('#retrieve_appno_hideresponsed, #retrieve_appno_responsed').val('');
    	$('#retrieve_custname_hideresponsed, #retrieve_custname_responsed, #retrieve_custlastname_hideresponsed, #retrieve_custlastname_responsed').val('');
    });
    
    
    $('#retrieve_tooltip').hover(function() {
    	
    	var listContent = $('#retrieve_contents').html();	    	
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});
		
    });
	
});