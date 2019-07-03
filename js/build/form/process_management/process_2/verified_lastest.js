$(function() {

	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
	var pathFixed = window.location.protocol + "//" + window.location.host;
	for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
	for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
	var query  = getQueryParams(document.location.search);

	// Service
	// var service_path = 'http://172.17.9.65/WsLendingBranchServices/PCISService.svc/';
	// var service_path = 'http://172.17.9.68/LendingBranchServices/PCISService.svc/';

	var service_path = 'http://172.17.9.94/newservices/LBServices.svc/pcis/borrower/';
	var service_path_v2 = 'http://172.17.9.208:80/TCFSApi/api/Application/pcis/';
	var service_new_app = 'http://172.17.9.208:80/TCFSApi/api/Application/pcis/filter/611055';

	// Set title
	$('title').html('AP-P2 : ' + $('#borrowername_title').val());

	// Object Date
	var str_date;
	var objDate = new Date();
	str_date = ("0" + objDate.getDate()).slice(-2) + '/' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '/' + objDate.getFullYear(); // Set Date format DD/MM/YYYY

	var defend_date           = $('#defend_date');

	/*
    var defend_reason         = $("#defend_reason");
    var parent_defend_mode    = $('#parent_defense_mode');
    var parent_defense_reason = $('#parent_defense_reason');
    var parent_defendbox	  = $('#objDefendbox');
	*/

	// Product Member
	var objProduct	 = $('#productprg');
	var objLoanType	 = $('#loantypes');
	var objBankList	 = $('#banklist');
	var prdc_hidden  = $("#productcode_hidden");
	var pro_progress = $('#pro_progress');

	// Re-Activate Member
	var objRevisit	 = $('#reactivate');
	var arv_progress = $('#arp_progress');


	$("#appProgress ul li:first-child").append('<div class="text-muted" style="min-width: 150px; margin-top: 2em; margin-left: -1em;">PROFILE</div>');
	$("#appProgress ul li:nth-child(2)").append('<div class="text-muted" style="min-width: 180px; margin-top: 2em; margin-left: -2.5em;">VERIFICATION</div>');
	$("#appProgress ul li:nth-child(3)").append('<div class="text-muted" style="min-width: 250px; margin-top: 2em; margin-left: -4.2em;">APPLICATION STATUS</div>');

	$("#appProgress ul li:first-child").on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P1&live=2&wrap=' + new Date().getTime(); });
	$("#appProgress ul li:nth-child(2)").on('click', function() { document.location.href = pathFixed + 'management/getDataVerifiedManagement?mod=1' + '&rel=' + query['rel'] + '&req=P2&live=2&wrap=' + new Date().getTime(); });
	$("#appProgress ul li:nth-child(3)").on('click', function() { document.location.href = pathFixed + 'metro/routers?mod=1' + '&rel=' + query['rel'] + '&req=P3&live=2&wrap=' + new Date().getTime(); });

	$('#defendLoadList').on('mouseover', function() { $(this).addClass('fa-spin'); }).on('mouseout', function() { $(this).removeClass('fa-spin'); });

	// Autoload: Product List 
	objProduct.empty()
	$.ajax({
		url: pathFixed + 'dataloads/productNewlist?_=' + new Date().getTime(),
		type: "GET",
		beforeSend:function() {
			pro_progress.show();
		},
		success:function(data) {

			objProduct.prepend('<optgroup class="newproduct" label="Clean Loan" data-core="Clean Loan"></optgroup>');	
			objProduct.prepend('<optgroup class="newproduct" label="Secure Loan" data-core="Secure Loan"></optgroup>');
			objProduct.prepend('<option value="">-- โปรดเลือก  --</option>');

			for(var indexed in data['data']) {
				objProduct.find('optgroup[data-core="' + data['data'][indexed]['ProductType'] + '"].newproduct').append("<option value='"+data['data'][indexed]['ProductCode']+"' data-type='"+data['data'][indexed]['ProductTypes']+"' data-toggle='tooltip' data-placement='right' title='"+data['data'][indexed]['ProductName']+"'>" + data['data'][indexed]['ProductTypes']+ '-' + data['data'][indexed]['ProductSub'] + ' ' + data['data'][indexed]['ProductName']+"</option>");		                                  	
			}           

			$('#productprg > .newproduct').find('option[value="' + prdc_hidden.val() + '"]').attr('selected', 'selected');

			var product  = $('select[name="productprg"] option:selected');
			var loantype = $('select[name="loantypes"] option:selected').val();
			if(product.closest('optgroup').attr('label') == "Secure Loan") {
				objLoanType.show();    	
				if(loantype == '1') objBankList.show();
			} else {
				objLoanType.hide();    	
				objBankList.hide();
				objLoanType.find('option[value=""]').prop('selected', false);
				objBankList.find('option[value=""]').prop('selected', false);
				$('#bank_bundle').val('');		    	
			}

			$('optgroup.newproduct').css({ 'color': 'red', 'font-weight': 'bold' });
			$('optgroup.newproduct > option').css({ 'color': 'black' });

			// Hidden product Field
			var product_group = $('#product_group').val()
			if(in_array(product_group, ['SB', 'MF', 'NN'])) {
				objProduct.find('option[data-type="E1"]').hide();
				objProduct.find('option[data-type="E2"]').hide();
				objProduct.find('option[data-type="E3"]').hide();
				objProduct.find('option[data-type="E4"]').hide();
				objProduct.find('option[data-type="E5"]').hide();
			} else {		
				objProduct.find('option').hide();
				objProduct.find('option[data-type="E1"]').show();
				objProduct.find('option[data-type="E2"]').show();
				objProduct.find('option[data-type="E3"]').show();
				objProduct.find('option[data-type="E4"]').show();
				objProduct.find('option[data-type="E5"]').show();
			}

		},
		cache: true,
		complete:function() {
			pro_progress.after(function() {
				$(this).hide();
			});
		},
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

	$.ajax({
		url: pathFixed + 'dataloads/productlist?_=' + new Date().getTime(),
		type: "GET",
		beforeSend:function() {
			pro_progress.show();
		},
		success:function(data) {
			objProduct.append('<optgroup class="oldproduct hide" label="Secure Loan" data-core="Secure Loan"></optgroup>');
			objProduct.append('<optgroup class="oldproduct hide" label="Clean Loan" data-core="Clean Loan"></optgroup>');			
			for(var indexed in data['data']) {
				objProduct.find('optgroup[data-core="' + data['data'][indexed]['ProductType'] + '"].oldproduct').append("<option class=\"fg-gray\" value='"+data['data'][indexed]['ProductCode']+"' data-type='"+data['data'][indexed]['ProductTypes']+"' data-toggle='tooltip' data-placement='right' title='"+data['data'][indexed]['ProductName']+"'>" + data['data'][indexed]['ProductTypes']+ '-' + data['data'][indexed]['ProductSub'] + ' ' + data['data'][indexed]['ProductName']+"</option>");		                                  	
			}           

			objProduct.find('option[value="'+prdc_hidden.val()+'"]').attr('selected', 'selected');

			var product  = $('select[name="productprg"] option:selected');
			var loantype = $('select[name="loantypes"] option:selected').val();
			if(product.closest('optgroup').attr('label') == "Secure Loan") {
				objLoanType.show();    	
				if(loantype == '1') objBankList.show();
			} else {
				objLoanType.hide();    	
				objBankList.hide();
				objLoanType.find('option[value=""]').prop('selected', false);
				objBankList.find('option[value=""]').prop('selected', false);
				$('#bank_bundle').val('');	
			}

		},
		cache: true,
		complete:function() {
			pro_progress.after(function() {
				$(this).hide();
			});
		},
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

	// Product change list
	objLoanType.hide();   
	objBankList.hide();
	objProduct.bind('change', function() {    	

		var selected = $(':selected', this);
		var loantype = $('select[name="loantypes"] option:selected').val();
		if(selected.closest('optgroup').attr('label') == "Secure Loan") {
			objLoanType.show();    	
			if(loantype == '1') objBankList.show();
		} else {
			objLoanType.find('option[value=""]').prop('selected', true);
			objBankList.find('option[value=""]').prop('selected', true);

			objLoanType.hide(); 
			objBankList.hide();
			objLoanType.find('option[value=""]').prop('selected', false);
			objBankList.find('option[value=""]').prop('selected', false);
			$('#bank_bundle').val('');	

		}

	});

	objLoanType.bind('change', function() {    	

		var loantype = $('select[name="loantypes"] option:selected').val();    
		if(loantype == '1') { objBankList.show(); }
		else {
			objBankList.find('option[value=""]').prop('selected', true);
			objBankList.hide();
			$('#bank_bundle').val('');	
		}

	});

	// Autoload: Re-Activate Reason
	var reactive_list = [];
	$.ajax({
		url: pathFixed+'dataloads/revisitListChecked?_=' + new Date().getTime(),
		type: "POST",
		data: {
			relx: query['rel']
		},
		beforeSend:function() {
			arv_progress.show();
		},
		success:function(data) {

			for(var indexed in data['data']) {
				reactive_list.push(data['data'][indexed]['RevisitID']);

			}

		},
		complete:function() {

			$.ajax({
				url: pathFixed+'dataloads/revisitList?_=' + new Date().getTime(),
				type: "GET",
				success:function(data) {

					for(var indexed in data['data']) {
						objRevisit.append("<option value='"+data['data'][indexed]['RevisitID']+"'>" + data['data'][indexed]['RevisitReason']+"</option>");
						//$('#reactivate').find('option[value="' + reactive_list[indexed] + '"]').attr('selected', 'selected');
					}

					//objRevisit.find('option[value="'+apv_hidden.val()+'"]').attr('selected', 'selected');
					$('#reactivate').change(function() {

					}).multipleSelect({
						width: '100%'        	 	        
					});

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

	objRevisit.change(function() {
		var reactivate = $('#reactivate').val();    	
		if(reactivate !== null) {
			$('#reactivate_plan').val(str_date);
		} else {
			$('#reactivate_plan').val('');
		}

	});    

	// Identity: Event Modal
	$('#btnCheckIdentity').on('click', function() {

		$('#identityListModal').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		}).draggable();		    	

	});

	var bpm_form 	= $('#bpm_information');
	var confirmName = $('#confirm_fieldCustname');
	var id_progress = $('#identity_progress');
	var btnVerify	= $('#btnIdentityVerify');

	bpm_form.hide();
	confirmName.hide();
	id_progress.hide(); // Progress    

	// Check Identities.
	$('#identity_verification').hide();
	$('#identity_custname').hide();
	$('#identity_custlastname').hide();

	var ncbData_info	= [];

	var is_idenable		= true;
	var is_validate 	= false;
	btnVerify.on('click', function() {

		var card_no	 	= $('#identity_cardno').val();
		var custname 	= $('#custname_identity').val();
		var lastname 	= $('#custlastname_identity').val();

		$('#msg_identityresponsed').empty();

		if(card_no == "") {
			$('#parent_identity_cardno').removeClass('success-state').addClass('error-state');
			$('#identity_verification').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
			$('#msg_identityresponsed').append('<span id="s1_identity"><i class="fa fa-exclamation-circle"></i> กรุณากรอกหมายเลขบัตรประชาชน และชื่อ-นามสกุล เพื่อทำการตรวจสอบข้อมูล.</span>');

		} else {
			if(card_no.length < 13) {
				$('#msg_identityresponsed').html('<i class="fa fa-exclamation-circle"></i> กรุณากรอกหมายเลขบัตรประชาชนให้ครบ 13 หลัก.');   		 
				$('#parent_identity_cardno').removeClass('success-state').addClass('error-state');
				$('#identity_verification').addClass('fa fa-remove fg-red marginLeft5').show();

			}

		}

		/*
    	if(custname == "" && lastname == "") {   		 
   		 	$('#parent_custname_identity').removeClass('success-state').addClass('error-state');
   		 	$('#parent_custlastname_identity').removeClass('success-state').addClass('error-state');

 			$('#identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
 			$('#identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();

    		$('#msg_identityresponsed').append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> กรุณากรอกข้อมูลชื่อ-นามสกุลลูกค้าให้ถูกต้อง.</div>');

     	} else {

     		if(custname == "") {   		 
       		 	$('#parent_custname_identity').removeClass('success-state').addClass('error-state');
     			$('#identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
        		$('#msg_identityresponsed').append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> กรุณากรอกข้อมูลชื่อลูกค้าให้ถูกต้อง.</div>');
     		}

     		if(lastname == "") {   		 
        		$('#parent_custlastname_identity').removeClass('success-state').addClass('error-state');
    	 		$('#identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
    	 		$('#msg_identityresponsed').append('<div id="cust_kp2" style="margin-left: -60px !important;"><i class="fa fa-exclamation-circle"></i> กรุณากรอกข้อมูลนามสกุลลูกค้าให้ถูกต้อง.</div>');

         	} 

     	}
		 */

		if(is_idenable) {
			if(card_no != "") { //  && custname != "" && lastname != ""
				
				// CHECK FROM WRAP
				onCheckNCBV2(card_no, custname, lastname);
				
				/* Modify On 15 July 2018
				$.ajax({
					url: service_path + card_no,
					type: "GET",
					beforeSend: function() {	 
						id_progress.show();
						$('#msg_identityresponsed').text('');  		
					},
					success: function(data) {	
						if(data && data.length > 0) {
							ncbData_info = data

							var tableData = [];
							_.forEach(data, function(v, i) {
								tableData.push({
									ApplicationNo: v.ApplicationNo,
									BorrowerType: getBorrowerType(v.PersonalType),
									IDCard: v.IDCard,
									BorrowerName: (v.THFirstName + ' ' + v.THLastName)
								});
							})

							var table_ncbinfo = $("#table_ncbinfo").tablecontrol({
								cls: 'table bordered',
								colModel: [
									{ field: 'ApplicationNo', caption: 'Application No', sortable: false, cls: 'text-center', hcls: 'bg-darkCyan fg-white' },
									{ field: 'BorrowerType', caption: 'Borrower Type', sortable: false, cls: 'text-center', hcls: 'bg-darkCyan fg-white' },
									{ field: 'IDCard', caption: 'ID Card', sortable: false, cls: 'text-center', hcls: 'bg-darkCyan fg-white' },
									{ field: 'BorrowerName', caption: 'Borrower Name', sortable: false, cls: 'text-left', hcls: 'bg-darkCyan fg-white' }
									],
									data: tableData
							});

							// Check has data in BPM Sytem
							btnVerify.hide();

							// Check date timing
							var check_apptime = $('#bpm_apptime').val();
							var appno_latest = $('#appno_latest').val();
							var appno_current = (tableData[0] && tableData[0].ApplicationNo) ? tableData[0].ApplicationNo : null;

							if(check_apptime > 60 && appno_current == appno_latest) {
								$('#confirmIdentity').prop('disabled', true);
								$('#identityListModal').find('.modal-body').append(
										'<div style="text-align: center; background-color: brown; color: white; font-size: 0.9em; padding: 3px 0; bottom: 0; position: absolute; width: 90%;">' +
										'ขออภัย, เนื่องจากหมายเลขแอพพลิเคชั่นที่ได้มีระยะเวลาเกินกว่ากำหนด (2 เดือน) กรุณาสร้างข้อมูลใหม่บนระบบ BPM' +
										'</div>'
								);
							} else {
								$('#confirmIdentity').prop('disabled', false);
							}

						} else {
							$('#parent_identity_cardno').removeClass('success-state').addClass('error-state');
							$('#identity_verification').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
							$('#msg_identityresponsed').append('<span id="s1_identity"><i class="fa fa-exclamation-circle"></i> ไม่พบข้อมูลหมายเลขนี้ในระบบ BPM กรุณาตรวจสอบข้อมูลหรือสร้างข้อมูลในระบบ BPM ก่อนเข้าใช้งานฟังก์ชั่นนี้.</span>');
						}

					},
					complete: function() {
						id_progress.after(function() { $(this).hide(); });	     	

					},
					timeout: 15000,
					statusCode: {
						404: function() { console.log( "page not found." ); },
						407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); },
						500: function() { console.log("internal server error."); }
					}
				});
				*/
				
				
//				$.ajax({
//				url: service_path + 'GetApplicationByCardNo',
//				data: { cardno: card_no },
//				type: "GET",
//				jsonpCallback: "identities_state",
//				dataType: "jsonp",
//				crossDomain: true,
//				beforeSend:function() {	 
//				id_progress.show();
//				$('#msg_identityresponsed').text(''); 

//				},
//				success:function(data) {	  

//				$('#err_responsed').remove();
//				if(data.Code == '200') {	  	        		 

//				if(data.Data[0] == "" || data.Data[0] == undefined) {

//				// Identities Card
//				$('#parent_identity_cardno').removeClass('success-state').addClass('error-state');
//				$('#identity_verification').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();

//				// Custname and Lastname
//				$('#parent_custname_identity').removeClass('success-state').addClass('error-state');
//				$('#parent_custlastname_identity').removeClass('success-state').addClass('error-state');

//				$('#identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
//				$('#identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();

//				$('#msg_identityresponsed').append('<span id="s1_identity"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณาตรวจสอบหมายเลขบัตรประชาชน และชื่อ-นามสกุลใหม่อีกครั้ง.</span>');

//				} else {

//				is_validate = true;
//				var objresponsed   = data.Data[0];  

//				// Check has data in BPM Sytem
//				bpm_form.show(); 
//				btnVerify.hide();

//				// Append Data to field
//				$('#appno_hideresponsed, #appno_responsed').val(objresponsed['APPLICATION_NO']);
//				$('#custname_hideresponsed, #custname_responsed').val(objresponsed['TH_FIRST_NAME']);
//				$('#custlastname_hideresponsed, #custlastname_responsed').val(objresponsed['TH_LAST_NAME']);


//				if(is_validate) {

//				var validation_form = [];
//				if(custname != objresponsed['TH_FIRST_NAME'] && lastname != objresponsed['TH_LAST_NAME']) {

//				$('#parent_custname_identity, #parent_custlastname_identity').removeClass('success-state').addClass('error-state');	  	        		   		 	
//				$('#parent_custname_responsed, #parent_custlastname_responsed').removeClass('success-state').addClass('error-state');

//				$('#identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
//				$('#identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();

//				$('#msg_identityresponsed').append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลชื่อ-นามสกุลลูกค้าให้ถูกต้อง.</div>');

//				} else {

//				if(custname != objresponsed['TH_FIRST_NAME']) {
//				$('#parent_custname_responsed').removeClass('success-state').addClass('error-state');
//				$('#parent_custname_identity').removeClass('success-state').addClass('error-state');		  	        					
//				$('#identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
//				$('#msg_identityresponsed').append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลชื่อลูกค้าให้ถูกต้อง.</div>');   	
//				validation_form.push('FALSE');

//				} else { validation_form.push('TRUE'); }

//				if(lastname != objresponsed['TH_LAST_NAME']) {   		 
//				$('#parent_custlastname_responsed').removeClass('success-state').addClass('error-state');
//				$('#parent_custlastname_identity').removeClass('success-state').addClass('error-state');
//				$('#identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
//				$('#msg_identityresponsed').append('<div id="cust_kp2" style="margin-left: -60px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลนามสกุลลูกค้าให้ถูกต้อง.</div>');
//				validation_form.push('FALSE');

//				} else { validation_form.push('TRUE'); }

//				if(in_array('TRUE', validation_form)) {

//				$('#parent_custname_identity, #parent_custname_responsed').removeClass('error-state').addClass('success-state');
//				$('#identity_custname').removeClass('fa fa-remove fg-red marginLeft5').addClass('fa fa-check fg-green marginLeft5').show();

//				$('#parent_custlastname_identity, #parent_custlastname_responsed').removeClass('error-state').addClass('success-state');
//				$('#identity_custlastname').removeClass('fa fa-remove fg-red marginLeft5').addClass('fa fa-check fg-green marginLeft5').show();

//				$('#confirmIdentity').prop('disabled', false);

//				}

//				}

//				} 


//				}	  	        		 

//				} else {
//				$('#msg_identityresponsed').append('<div id="err_responsed"><i class="fa fa-exclamation-circle"></i> เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง.</div>');

//				}

//				},
//				complete:function() {
//				id_progress.after(function() { $(this).hide(); });	     	        	

//				},
//				cache: true,
//				timeout: 5000,
//				statusCode: {
//				404: function() {
//				alert( "page not found." );
//				},
//				407: function() {
//				console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )");
//				},
//				500: function() {
//				console.log("internal server error.");
//				}
//				}

//				});

			}

		} else {
			var not = $.Notify({ content: "ขออภัย!! ไม่สามารถใช้งานฟังก์ชั่นนี้ได้ เนื่องจากอยู่ระหว่างปรับปรุงระบบ...", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
			not.close(7000);
		}

	});
	
	function onCheckNCBV1(card_no, custname, lastname) {
		$.ajax({
			url: service_path + card_no,
			type: "GET",
			beforeSend: function() {	 
				id_progress.show();
				$('#msg_identityresponsed').text('');  		
			},
			success: function(data) {	
				if(data && data.length > 0) {
					
					ncbData_info = _.map(data, function(o) { return o.NCBDate = null; });
	
					var tableData = [];
					var draftData = [];
					
					_.forEach(data, function(v, i) {
						
						tableData.push({
							ApplicationNo: v.ApplicationNo,
							BorrowerType: getBorrowerType(v.PersonalType),
							IDCard: v.IDCard,
							BorrowerName: (v.THFirstName + ' ' + v.THLastName)
						});
						
						draftData.push({
							ApplicationNo: v.ApplicationNo,
							ApplicationStatus:"Draft",
							IDCard: v.IDCard,
							PersonalType: v.PersonalType,
							THFirstName: v.THFirstName,
							THLastName: v.THLastName,
							THTitleName: v.THTitleName,
							NCBDate: null,
							seq: setBorrowerPriority(v.PersonalType)
						})
						
					});
					
					ncbData_info = _.sortBy(draftData, "seq");

					var table_ncbinfo = $("#table_ncbinfo").tablecontrol({
						cls: 'table bordered',
						colModel: [
							{ field: 'ApplicationNo', caption: 'Application No', sortable: false, cls: 'text-center', hcls: 'bg-darkCyan fg-white' },
							{ field: 'BorrowerType', caption: 'Borrower Type', sortable: false, cls: 'text-center', hcls: 'bg-darkCyan fg-white' },
							{ field: 'IDCard', caption: 'ID Card', sortable: false, cls: 'text-center', hcls: 'bg-darkCyan fg-white' },
							{ field: 'BorrowerName', caption: 'Borrower Name', sortable: false, cls: 'text-left', hcls: 'bg-darkCyan fg-white' }
							],
							data: tableData
					});

					// Check has data in BPM Sytem
					btnVerify.hide();

					// Check date timing
					var check_apptime = $('#bpm_apptime').val();
					var appno_latest = $('#appno_latest').val();
					var appno_current = (tableData[0] && tableData[0].ApplicationNo) ? tableData[0].ApplicationNo : null;

					if(check_apptime > 60 && appno_current == appno_latest) {
						$('#confirmIdentity').prop('disabled', true);
						$('#identityListModal').find('.modal-body').append(
							'<div style="text-align: center; background-color: brown; color: white; font-size: 0.9em; padding: 3px 0; bottom: 0; position: absolute; width: 90%;">' +
								'ขออภัย, เนื่องจากหมายเลขแอพพลิเคชั่นที่ได้มีระยะเวลาเกินกว่ากำหนด (2 เดือน) กรุณาสร้างข้อมูลใหม่บนระบบ BPM' +
							'</div>'
						);
					} else {
						$('#confirmIdentity').prop('disabled', false);
					}

				} else {
					$('#parent_identity_cardno').removeClass('success-state').addClass('error-state');
					$('#identity_verification').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
					$('#msg_identityresponsed').append('<span id="s1_identity"><i class="fa fa-exclamation-circle"></i> ไม่พบข้อมูลหมายเลขนี้ในระบบ BPM กรุณาตรวจสอบข้อมูลหรือสร้างข้อมูลในระบบ BPM ก่อนเข้าใช้งานฟังก์ชั่นนี้.</span>');
				}

			},
			complete: function() {
				id_progress.after(function() { $(this).hide(); });	     	

			},
			timeout: 15000,
			statusCode: {
				404: function() { console.log( "page not found." ); },
				407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); },
				500: function() { console.log("internal server error."); }
			}
		});
	}
	
	function onCheckNCBV2(card_no, custname, lastname) {
		
		var empcode = $('#Emp_ID').val()

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
				var lap_data = (data && data.length > 0) ? _.orderBy(data, ['CreateDate'], ['desc']) : [];
				var appno = (lap_data && lap_data.length > 0) ? lap_data[0].ApplicationNo : null;

				if(!_.isEmpty(appno)) {
					getFullApplication(empcode, appno);
				} else {
					var not = $.Notify({ content: "ไม่พบข้อมูลหมายเลขนี้ในระบบ LAP กรุณาตรวจสอบข้อมูลหรือสร้างข้อมูลในระบบ LAP ก่อนเข้าใช้งานฟังก์ชั่นนี้.", style: { background: 'red ', color: '#FFFFFF' }, timeout: 10000 });
					not.close(8000);
					id_progress.after(function() { $(this).hide(); });
				}

//				if(_.isEmpty(data)) {
//					onCheckNCBV1(card_no, custname, lastname);					
//				} else {
//					var appno = (data) ? data[0].ApplicationNo : null;
//					if(!_.isEmpty(appno)) {
//						getFullApplication(empcode, appno);
//					} 
//					else {
//						onCheckNCBV1(card_no, custname, lastname);
//					}
//				}
				
			},
			timeout: 15000,
			statusCode: {
				404: function() { console.log( "page not found." ); },
				407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); },
				500: function() { console.log("internal server error."); }
			}
		});
		
	}
	
	function getFullApplication(empcode, appno) {
		$.ajax({
			url: service_path_v2 + 'Get/' + empcode + '/' + appno,
			type: "POST",
			header: { 'Content-Type': 'application/json' },
			dataType : 'json',		
			data: { "ApplicationNo": appno },
			beforeSend: function() {	 
				id_progress.show();
				$('#msg_identityresponsed').text('');  		
			},
			success: function(data) {
				console.log(data);
				if(!_.isEmpty(data)) {
					
					var customer = data.Custmers;
					if(customer && customer.length > 0) {
						
						
						var tableData = [];
						var draftData = [];
						
						_.forEach(customer, function(v, i) {							
							
							var customer_check = (!_.isEmpty(v.CustomerRelationType)) ? _.filter(v.CustomerRelationType, { OwnerRelation: 'P' }):null;
							var customer_type = (!_.isEmpty(customer_check)) ? customer_check[0].OwnerRelation : v.CustomerRelationType[0].OwnerRelation;
							var check_ncbdate = (!_.isEmpty(v.NCBResponse)) ? moment(v.NCBResponse.RequestDate).format('DD/MM/YYYY'):null;
							
							tableData.push({
								ApplicationNo: v.ApplicationNo,
								BorrowerType: getBorrowerTypeV2(customer_type),
								IDCard: v.IDNumber,
								BorrowerName: v.FullNameTH
							});
							
							draftData.push({
								ApplicationNo: v.ApplicationNo,
								ApplicationStatus:"Draft",
								IDCard: v.IDNumber,
								PersonalType: setBorrowerDigitTypeV2(customer_type),
								THFirstName: v.NameTH,
								THLastName: v.SurnameTH,
								THTitleName: "",
								NCBDate: check_ncbdate,
								seq: setBorrowerPriority(customer_type)
							})
							
						});
						
						ncbData_info = _.sortBy(draftData, "seq");
						
						var table_ncbinfo = $("#table_ncbinfo").tablecontrol({
							cls: 'table bordered',
							colModel: [
								{ field: 'ApplicationNo', caption: 'Application No', sortable: false, cls: 'text-center', hcls: 'bg-darkCyan fg-white' },
								{ field: 'BorrowerType', caption: 'Borrower Type', sortable: false, cls: 'text-center', hcls: 'bg-darkCyan fg-white' },
								{ field: 'IDCard', caption: 'ID Card', sortable: false, cls: 'text-center', hcls: 'bg-darkCyan fg-white' },
								{ field: 'BorrowerName', caption: 'Borrower Name', sortable: false, cls: 'text-left', hcls: 'bg-darkCyan fg-white' }
							],
							data: tableData
						});
	
						// Check has data in BPM Sytem
						btnVerify.hide();
	
						// Check date timing
						var check_apptime = $('#bpm_apptime').val();
						var appno_latest = $('#appno_latest').val();
						var appno_current = (tableData[0] && tableData[0].ApplicationNo) ? tableData[0].ApplicationNo : null;
	
						if(check_apptime > 60 && appno_current == appno_latest) {
							$('#confirmIdentity').prop('disabled', true);
							$('#identityListModal').find('.modal-body').append(
								'<div style="text-align: center; background-color: brown; color: white; font-size: 0.9em; padding: 3px 0; bottom: 0; position: absolute; width: 90%;">' +
									'ขออภัย, เนื่องจากหมายเลขแอพพลิเคชั่นที่ได้มีระยะเวลาเกินกว่ากำหนด (2 เดือน) กรุณาสร้างข้อมูลใหม่บนระบบ BPM' +
								'</div>'
							);
						} else {
							$('#confirmIdentity').prop('disabled', false);
						}
						
						
					} else {
						$('#parent_identity_cardno').removeClass('success-state').addClass('error-state');
						$('#identity_verification').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
						$('#msg_identityresponsed').append('<span id="s1_identity"><i class="fa fa-exclamation-circle"></i> ไม่พบผู้กู้ กรุณาติดต่อผู้ดูแลระบบ.</span>');
					}
					
				} else {
					$('#parent_identity_cardno').removeClass('success-state').addClass('error-state');
					$('#identity_verification').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
					$('#msg_identityresponsed').append('<span id="s1_identity"><i class="fa fa-exclamation-circle"></i> ไม่พบข้อมูลหมายเลขนี้ในระบบ กรุณาติดต่อผู้ดูแลระบบ.</span>');
				}

			},
			complete: function() {
				id_progress.after(function() { $(this).hide(); });	     	

			},
			timeout: 15000,
			statusCode: {
				404: function() { console.log( "page not found." ); },
				407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); },
				500: function() { console.log("internal server error."); }
			}
		});
	}
	
	function getBorrowerType(data_type) {
		if(data_type) {
			switch (data_type) {
				case 'A':
					return 'ผู้กู้หลัก'
				break;
				case 'C':
					return 'ผู้กู้ร่วม'
				break;
				case 'G':
					return 'ผู้ค้ำ'
				break;
			}
		} else {
			return ''
		}
	}

	function setBorrowerType(data_type) {
		if(data_type) {
			switch (data_type) {
			case 'A':
				return '101'
				break;
			case 'C':
				return '102'
				break;
			case 'G':
				return '103'
				break;
			}
		} else {
			return ''
		}
	}
	
	function getBorrowerTypeV2(data_type) {
		if(data_type) {
			switch (data_type) {
				case 'P':
					return 'ผู้กู้หลัก'
				break;
				case 'JT':
					return 'ผู้กู้ร่วม'
				break;
				case 'GO':
					return 'ผู้ค้ำ'
				break;
				default:
					return 'อื่นๆ';
				break;
			}
		} else {
			return ''
		}
	}

	function setBorrowerTypeV2(data_type) {
		if(data_type) {
			switch (data_type) {
			case 'P':
				return '101'
				break;
			case 'JT':
				return '102'
				break;
			case 'GO':
				return '103'
				break;
			default:
				return '104';
				break;
			}
		} else {
			return ''
		}
	}
	
	function setBorrowerDigitTypeV2(data_type) {
		if(data_type) {
			switch (data_type) {
			case 'P':
				return 'A'
				break;
			case 'JT':
				return 'C'
				break;
			case 'GO':
				return 'G'
				break;
			default:
				return 'O';
				break;
			}
		} else {
			return ''
		}
	}
	
	function setBorrowerPriority(data_type) {
		if(data_type) {
			switch (data_type) {
			case 'P':
			case 'A':
				return '1'
				break;
			case 'JT':
			case 'C':
				return '2'
				break;
			case 'GO':
			case 'G':
				return '3'
				break;
			default:
				return '4';
				break;
			}
		} else {
			return ''
		}
	}
	
	// Block copy, cut, paste text
	//$('#identity_cardno').bind("cut copy paste",function(e) { e.preventDefault(); });

	$('#identity_cardno').keyup(function() {  

		if($(this).val().length == 0) {
			btnVerify.show();
		}

		if($(this).val() != "" && $(this).val().length >= 13) {   

			if(checkPersonID($(this).val())) {        		
				$('#parent_identity_cardno').removeClass('error-state warning-state').addClass('success-state');
				$('#identity_verification')
				.removeClass().removeClass('fa fa-remove fg-red marginLeft5')
				.addClass('fa fa-check fg-green marginLeft5')
				.show();

				$('#card_kp1').remove();

			} else {

				$('#parent_identity_cardno').removeClass('success-state error-state').addClass('warning-state');
				$('#identity_verification').removeClass().hide();
				$('#msg_identityresponsed').empty()
				.append(
						'<div id="card_kp1" class="text-warning"><i class="fa fa-info-circle"></i> กรุณตรวจสอบหมายเลขบัตรประชาชนใหม่อีกครั้ง. <br/>' +
						'<p style="font-size: 0.9em; margin-top: 10px; padding: 0 5px; text-align: left">' +
						'<span style="font-weight: bold;">หมายเหตุ</span> : หากท่านตรวจสอบหมายเลขบัตรประชาชนของลูกค้าถูกต้อง ท่านสามารถกดปุ่มตรวจสอบได้' +
						'เนื่องจากโปรแกรมทำการตรวจสอบความถูกต้องของหมายเลขบัตรประชาชน<span style="text-decoration: underline;">ตามหลักการคำนวณ</span>ในการสร้างหมายเลขบัตรประชาชน.<p></div>' 
				);

			}

		} else {

			$('#parent_identity_cardno').removeClass('success-state warning-state').addClass('error-state');
			$('#identity_verification').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
			$('#msg_identityresponsed').empty().append('<div id="card_kp1"><i class="fa fa-exclamation-circle"></i> กรุณากรอกหมายเลขบัตรประชาชนให้ครบ 13 หลัก.</div>');

		}

	});

	/*
    $('#custname_identity').keyup(function() {

    	if(is_validate) {

    		if($(this).val() != $('#custname_hideresponsed').val()) {
    			 $('#parent_custname_identity, #parent_custname_responsed').removeClass('success-state').addClass('error-state');
        		 $('#identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
    			 $('#msg_identityresponsed').empty().append('<div id="cust_kp1" style="margin-left: -73px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลชื่อลูกค้าให้ถูกต้อง.</div>');

    			 input_validation();

    		} else {
    			$('#parent_custname_identity, #parent_custname_responsed').removeClass('error-state').addClass('success-state');
     			$('#identity_custname').removeClass('fa fa-remove fg-red marginLeft5').addClass('fa fa-check fg-green marginLeft5').show();
     			$('#cust_kp1').remove();

     			input_validation();

    		}

    	} else {

    		if($(this).val() != "") {    		
        		$('#parent_custname_identity').removeClass('error-state');//.addClass('success-state');
     			$('#identity_custname').removeClass().hide();//.addClass('fa fa-check fg-green marginLeft5').show();
     			$('#cust_kp1').remove();

        	} else {    
        		 $('#parent_custname_identity').removeClass('success-state').addClass('error-state');
        		 $('#identity_custname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
        		 $('#msg_identityresponsed').empty().append('<div id="cust_kp1" style="margin-left: -70px !important;"><i class="fa fa-exclamation-circle"></i> กรุณากรอกข้อมูลชื่อลูกค้าให้ถูกต้อง.</div>');

        	}

    	}

    });

	$('#custlastname_identity').keyup(function() {

	 	if(is_validate) {

    		if($(this).val() != $('#custlastname_hideresponsed').val()) {
    			 $('#parent_custlastname_identity, #parent_custlastname_responsed').removeClass('success-state').addClass('error-state');
    	 		 $('#identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
    	 		 $('#msg_identityresponsed').empty().append('<div id="cust_kp2" style="margin-left: -60px !important;"><i class="fa fa-exclamation-circle"></i> ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลนามสกุลลูกค้าให้ถูกต้อง.</div>');

    	 		input_validation();

    		} else {
    			$('#parent_custlastname_identity, #parent_custlastname_responsed').removeClass('error-state').addClass('success-state');
    			$('#identity_custlastname').removeClass('fa fa-remove fg-red marginLeft5').addClass('fa fa-check fg-green marginLeft5').show();
    			$('#cust_kp2').remove();

    			input_validation();

    		}

    	} else {

    		if($(this).val() != "") {    		
    	 		$('#parent_custlastname_identity').removeClass('error-state');//.addClass('success-state');
    			$('#identity_custlastname').removeClass().hide();//.addClass('fa fa-check fg-green marginLeft5').show();
    			$('#cust_kp2').remove();


    	 	} else {    		 	
    	 		 $('#parent_custlastname_identity').removeClass('success-state').addClass('error-state');
    	 		 $('#identity_custlastname').removeClass().addClass('fa fa-remove fg-red marginLeft5').show();
    	 		 $('#msg_identityresponsed').empty().append('<div id="cust_kp2" style="margin-left: -70px !important;"><i class="fa fa-exclamation-circle"></i> กรุณากรอกข้อมูลนามสกุลลูกค้าให้ถูกต้อง.</div>');

    	 	}

    	}

	});
	 */

	$('#confirmIdentity').on('click', function() {
		if(confirm('กรุณายืนยันความถูกต้องของข้อมูล หากข้อมูลถูกต้องโปรดกด OK')) {

			var table = $('#expense_table_ncbrefer')
			if(ncbData_info && ncbData_info.length > 0) {
				var fieldNCBDate = $('#NCBChecked_1').val()
				
				if(!fieldNCBDate && fieldNCBDate == '') {
					table.find('tbody').empty();
					_.forEach(ncbData_info, function(v, i) {

						var borrower_type = setBorrowerType(v.PersonalType)
						var borrower_name = (v.THFirstName + ' ' + v.THLastName)
						var id_card = v.IDCard
						var ncb_date = (!_.isEmpty(v.NCBDate)) ? v.NCBDate : '';
						var ncb_ischeck = (!_.isEmpty(v.NCBDate)) ? 'checked="checked"' : '';

						var ncb_check 		= "'ncb_click_" + (i + 1) + "'";
						var ncb_input 		= "'NCBChecked_" + (i + 1) + "'";
						var lbsent_check	= "'lbsent_click_" + (i + 1) + "'";
						var lbsent_input	= "'LBSentToHQ_" + (i + 1) + "'";
						var hqget_check		= "'receivedlb_click_" + (i + 1) + "'";
						var hqget_input		= "'ReceivedFromLB_" + (i + 1) + "'";
						var hqtooper_check	= "'hqtooper_click_" + (i + 1) + "'";
						var hqtooper_input	= "'HQToOper_" + (i + 1) + "'";
						var oprt_check		= "'returntooper_click_" + (i + 1) + "'";
						var oprt_input		= "'OperReturn_" + (i + 1) + "'";
						var oprt_text		= "'rencb_" + (i + 1) + "'";

						var item = '<tr class="item_ncbrefer" data-attr="' + (i + 1) + '">' +
							'<td>' +
								'<div class="input-control select">' +
									'<select id="NCBRelation_' + (i + 1) + '" name="NCBRelation[]" style="height: 33px;">' +
										'<option value="" ' + (borrower_type == "" && 'selected="selected"') + '></option>' +
										'<option value="101" ' + (borrower_type == "101" && 'selected="selected"') + '>ผู้กู้หลัก</option>' +
										'<option value="102" ' + (borrower_type == "102" && 'selected="selected"') + '>ผู้กู้ร่วม</option>' +
										'<option value="103" ' + (borrower_type == "103" && 'selected="selected"') + '>อื่นๆ (Doc)</option>' +
										'<option value="104" ' + (borrower_type == "104" && 'selected="selected"') + '>อื่นๆ</option>' +
									'</select>' +
								'</div>' +
							'</td>' +
							'<td>' +
								'<div class="input-control text">' +
									'<input type="hidden" name="NCBIDNo[]" value="' + id_card + '">'+
									'<input type="hidden" name="NCBIsRef[]" value="">'+
									'<input type="text" id="NCBName_' + (i + 1) + '" name="NCBName[]" value="' + borrower_name + '">' +
								'</div>' +
							'</td>' +
							'<td>' +
								'<div class="input-control select">' +
									'<select id="NCBResult_' + (i + 1) + '" name="NCBResult[]" style="height: 33px;">' +
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
										'<input id="ncb_click_' + (i + 1) + '" type="checkbox" onclick="GenDateValidator('+ ncb_check + ', '+ ncb_input +')" ' + ncb_ischeck + '>' +
										'<span class="check"></span>' +
									'</label>' +
								'</div>' +
								'<div id="objNCBChecked_' + (i + 1) +'" class="input-control text" id="" style="width: 120px;">' +
									'<input type="text" id="NCBChecked_' + (i + 1) + '" name="NCBResultDate[]" value="' + ncb_date + '" style="padding-left: 30px;">' +
								'</div>' +
							'</td>' +
							'<td class="text-left">' +
								'<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">' +
									'<label>' +
										'<input id="lbsent_click_' + (i + 1) + '" type="checkbox" onclick="GenDateValidator(' + lbsent_check + ', '+ lbsent_input +');">' +
										'<span class="check"></span>' +
									'</label>' +
								'</div>' +
								'<div id="objLBSentToHQ_' + (i + 1) +'" class="input-control text" id="" style="width: 120px;">' +
									'<input type="text" id="LBSentToHQ_' + (i + 1) + '" name="LBSentToHQ[]" value="" style="padding-left: 30px;">' +
								'</div>' +
							'</td>' +
							'<td class="text-left">' +
								'<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">' +
									'<label>' +
										'<input id="receivedlb_click_' + (i + 1) + '" type="checkbox" value="1" onclick="GenDateValidator(' + hqget_check + ', '+ hqget_input +');" disabled="disabled">' +
										'<span class="check" style="border-color: #4390df;"></span>' +
									'</label>' +
								'</div>' +
								'<div id="_objReceivedFromLB_' + (i + 1) +'" class="input-control text" id="" style="width: 120px;">' +
									'<input type="text" id="ReceivedFromLB_' + (i + 1) + '" name="ReceivedFromLB[]" value="" style="padding-left: 30px; border-color: #4390df;" readonly>' +
								'</div>' +
							'</td>' +
							'<td class="text-left">' +
								'<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">' +
									'<label>' +
										'<input id="hqtooper_click_' + (i + 1) + '" type="checkbox" value="1" onclick="GenDateValidator(' + hqtooper_check + ', '+ hqtooper_input +');" disabled="disabled">' +
										'<span class="check" style="border-color: #4390df;"></span>' +
									'</label>' +
								'</div>' +
								'<div id="_objHQToOper_' + (i + 1) +'" class="input-control text" id="" style="width: 120px;">' +
									'<input type="text" id="HQToOper_' + (i + 1) + '" name="HQToOper[]" value="" style="padding-left: 30px; border-color: #4390df;" readonly>' +
								'</div>' +
							'</td>' +
							'<td class="text-left">' +		    
								'<div class="input-control cb-marginFixedChrome checkbox" style="position:absolute; margin-left: -15px; margin-top: 0px; z-index: 999;">' +
									'<label>' +
										'<input id="returntooper_click_' + (i + 1) + '" type="checkbox" value="1" onclick="GenDateValidator(' + oprt_check + ', '+ oprt_input +'); resetRelatedFields(' + (i + 1) + ', '+ oprt_input +'); setReturnDateByText(' + oprt_check +', ' + oprt_text + ');" disabled="disabled">' +
										'<span class="check"></span>' +
									'</label>' +
								'</div>' +
								'<div id="objOperReturn_' + (i + 1) +'" class="input-control text" id="" style="width: 120px;">' +
									'<p id="rencb_' + (i + 1) + '" style="margin-left: 25px; padding-top: 7px; padding-left: 10px; font-size: 1em;"></p>' +
									'<input type="hidden" id="OperReturn_' + (i + 1) + '" name="OperReturn[]" value="" style="padding-left: 30px;">' +
								'</div>' +
							'</td>' +
							'<td class="del">' +
								//'<i class="fa fa-minus-circle" style="font-size: 1.5em; color: red; margin-top: -20px;" onclick=\"removeAddNCBRecord();\"></i>' +
							'</td>' +
						'</tr>';

						table.append(item)

						$('#objNCBChecked_' + (i + 1)).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
						$('#objLBSentToHQ_' + (i + 1)).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
						$('#objReceivedFromLB_' + (i + 1)).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });
						$('#objHQToOper_' + (i + 1)).Datepicker({ format: "dd/mm/yyyy", effect: "slide", position: "bottom" });

					});

				}

				var main_info = _.filter(ncbData_info, { PersonalType: 'A' })[0]
				
				console.log(main_info);
				
				if(main_info) {
					setApplicationNo(main_info.ApplicationNo, main_info.IDCard)
					if(fieldNCBDate && fieldNCBDate !== '') {
						var not = $.Notify({ content: "Update application no successfully..", style: { background: '#60A917 ', color: '#FFFFFF' }, timeout: 10000 });
						not.close(8000);					
					}
				}

			}

			return true

		}

		return false

		/*
		if($('#custname_identity').val() == $('#custname_hideresponsed').val() && $('#custlastname_identity').val() == $('#custlastname_hideresponsed').val()) {

			$.ajax({
				  url: pathFixed + 'dataloads/setApplicationNoBundled?_=' + new Date().getTime(),
	  	    	  data: { 
	  	    		  appno: $('#appno_hideresponsed').val(),
	  	    		  docid: query['rel']
	  	    	  },
	  	          type: "POST",
	  	          beforeSend:function() { id_progress.show(); },
	  	          success:function(responsed) {	

	  	        	  if(responsed['status']) {
	  	        		 var borrowername = $('#custname_identity').val() + ' ' + $('#custlastname_identity').val();
		  	        	 $('#id_card, #id_card_dump').val($('#identity_cardno').val());
		  	        	 $('#NCBName_1').val(borrowername);

		  	        	 $('#identityListModal').modal('hide');  

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
		 */

	});

	var input_validation = function() {

		if($('#custname_identity').val() == $('#custname_hideresponsed').val() && $('#custlastname_identity').val() == $('#custlastname_hideresponsed').val()) {			
			$('#confirmIdentity').prop('disabled', false);			
		} else {			
			$('#confirmIdentity').prop('disabled', true);
		}

	}

	function checkPersonID (id) {
		if(id.length != 13) return false;

		for(i=0, sum=0; i < 12; i++) sum += parseFloat(id.charAt(i))*(13-i);

		if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false;

		return true;

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

	function createElement(element, attribute, inner) {
		if (typeof (element) === "undefined") { return false; }
		if (typeof (inner) === "undefined") { inner = ""; }

		var el = document.createElement(element);
		if (typeof (attribute) === 'object') {
			for (var key in attribute) {
				el.setAttribute(key, attribute[key]);
			}
		}

		if (!Array.isArray(inner)) { inner = [inner]; }
		for (var k = 0; k < inner.length; k++) {
			if (inner[k] && inner[k].tagName) { el.appendChild(inner[k]); }
			else { el.appendChild(document.createTextNode(inner[k])); }
		}
		return el;
	}

	$('#cancelIdentity').on('click', function() { $('#identityListModal').modal('hide'); });

	// check confirm field in indentify form
	$('#identity_cardno').bind('change', function() {
		bpm_form.hide(); 
		$('#appno_hideresponsed, appno_responsed').val('');
		$('#custname_hideresponsed, #custname_responsed, #custlastname_hideresponsed, #custlastname_responsed').val('');
	});


	function setApplicationNo(appno, id_card) {
		$.ajax({
			url: pathFixed + 'dataloads/setApplicationNoBundled?_=' + new Date().getTime(),
			data: { 
				appno: appno,
				docid: query['rel']
			},
			type: "POST",
			beforeSend:function() { id_progress.show(); },
			success:function(responsed) {		        	  
				if(responsed['status']) {
					$('#id_card, #id_card_dump').val(id_card);
					$('#identityListModal').modal('hide');  

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

	function fnGetDataIntoDropdown(path, elements, keys, progress) {

		var objProgresses = progress;

		$.ajax({
			url: path + '?_=' + new Date().getTime(),
			type: "GET",
			beforeSend:function() {
				objProgresses.show();
			},
			success:function(data) {

				elements.first().append('<option value="" selected>-- โปรดเลือก --</option>');
				for(var indexed in data['data']) {
					elements.append("<option value='" + data['data'][indexed][keys] + "'>" + data['data'][indexed][keys] + "</option>");
				}    

			},
			complete:function() {
				objProgresses.after(function() {
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

	}
	
	var rmlist_tooltip = $('#RmProcessReasonLogs');

	// DEFEND 
	/*
    parent_defend_mode.hide();    
    parent_defense_reason.hide(); 
    parent_defendbox.hide();
    if($('select[name="defend_process"] option:selected').val() != "") {
        parent_defend_mode.show();
        parent_defense_reason.show();
        parent_defendbox.show();

    }
	 */

	// DefendLogs
    /*
	var defend_reset   = $('#objDefend');
	var defend_tooltip = $('#DefendLogs');
	

	defend_reset.hide();
	defend_tooltip.hide();

	// Reset before defend, So will be next new transaction.
	defend_reset.on('click', function(e) {
		if(confirm('กรุณายืนยันการรีเซ็ตข้อมูล.')) {

			// set element
			$('#defend_trigger').val('Y');
			$('#defend_date').val('');
			$('#defend_date_disbled').val('');

			var defend_nums = parseInt($('#defend_no').val()) + 1;
			$('#defend_no').val(defend_nums);  

			// clear defend box
			$('#objDefendReason').html('');   

			// unlock element
			$('#defenseByRM').prop('checked', false);
			$('#defenseBySFE').prop('checked', false);

			$('#defenseByRM').removeAttr('disabled');
			//$('#defenseBySFE').removeAttr('disabled');
			$('#defend_process').removeAttr('disabled');

			$('#defend_process').find('option[value=""]').attr('selected', 'selected');
			$('#defend_process').css('background', '#FFF');

			return true;

		}
	});

    $('#cancelDefendList').bind('click', function() {
    	var trigger = $('#defend_trigger').val();
    	if(trigger == 'Y') {
        	var defend_nums = parseInt($('#defend_no').val()) - 1;
            $('#defend_no').val(defend_nums);      
            $('#defend_trigger').val('N');
    	}

    	var df_rm = $('#defenseByRM').data('value');
    	var df_sfe = $('#defenseBySFE').data('value');
    	var df_pro = $('#defend_process').data('value');
    	var df_date = $('#defend_date').data('value');

    	$('#defenseByRM, #defenseBySFE').prop('checked', false);

    	if(df_rm && df_rm !== '') {
    		$('#defenseByRM').prop('checked', true);
    	}

    	if(df_sfe && df_sfe !== '') {
    		$('#defenseBySFE').prop('checked', true);
    	}

    	if(df_pro && df_pro !== '') {
    		$('#defend_process').find('option[value="' + df_pro + '"]').attr('selected', 'selected');

    		$('#defenseByRM').prop('disabled', true);
     	    $('#defenseBySFE').prop('disabled', true);
     	    $('#defend_process').prop('disabled', true);
     	    $('#defend_process').css('background', '#EBEBE4');

    	}

    	if(df_date && df_date !== '') {
    		 $('#defend_date').val(df_date);
             $('#defend_date_disbled').val(df_date);
    	}

    	$('#defendListModal').modal('hide');

    });

	$('input[name="defend_proposer"]').on('click', function(e) {

		var proposerID  = $('#Emp_ID').val();
		var proposer 	= $('#Emp_Name').val();
		$('#proposer').val(proposerID);
		$('#proposer_name').val(proposer);

	});

	// Prop false
	$('#defenseByRM').click(function() {
		var rm_proposer = $(this).is(':checked');
		if(rm_proposer) {

			var defend_proposer = $('#defenseBySFE').is(':checked');
			if(defend_proposer) {
				$('#defenseBySFE').prop('checked', false);
			}

		} 

	});

	$('#defenseBySFE').click(function() {
		var defend_proposer = $(this).is(':checked');
		if(defend_proposer) {

			var rm_proposer = $('#defenseByRM').is(':checked');
			if(rm_proposer) {
				$('#defenseByRM').prop('checked', false);
			}

		} 

	});
	*/

	$('#ReActivatedReasonLogs').hover(function() {

		var listContent = $('#reactivate_parent_reason').html();	    	
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});

	});	 

	$('#PlanA2CAReasonLogs').hover(function() {

		var listContent = $('#plan_a2ca_area').html();	    	
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});

	});	   
	/*
	// Auto Increment List
	var max_fields      = 5; //maximum input boxes allowed
	var wrapper         = $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID

	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment

			$(wrapper).append(
					'<div class="input-control text">' +
					'<label class="label label-clear ">อื่นๆ : </label>' +
					' <input name="defend_topiclist[]" type="text" value="" class="size4">' +
					'<i class="fa fa-close fg-red marginTop5 remove_field" style="font-size: 1.5em !important; position: absolute; margin-top: 5px; margin-left: 10px;"></i>' +    
					'</div>'
			); 
		}
	});

	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})


	// defend_process
	$('#defend_progress').hide();
	$('#defense_OptionNote').hide();

	if(parseInt($('#defendCaseBadge').val()) >= 1) {    	
		defend_reset.show();
		$('#defense_OptionNote').show();
		defend_tooltip.show();
	}

	// defend reload
	$('#defendLoadList').click(function() { loadDefendReasonList(); });

	defend_tooltip.hover(function() {
		var listContent = $('#objDefendReason').html();												
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});
	});

	 */
	rmlist_tooltip.hover(function() {

		var listContent = $('#objRMProcessListBox').html();	    	
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});

	});

	// Defend Modal
	$('#defend_process').on('change', function() {

		var select_list = $('select[name="defend_process"] option:selected').val();

		// Date bundled
		if(select_list != '') { defend_date.val(str_date); $('#defend_date_disbled').val(str_date); }
		if(select_list == '') { defend_date.val(''); $('#defend_date_disbled').val(''); }  


		// Event Logic
		if(select_list != "") {

			if(select_list == 'Before Process' || select_list == 'On Process') {

				// Defend Process Bundled
				$('#defend_process_hidden').val(select_list);

				if($('input[name="defend_proposer"]').is(':checked')) {
					loadDefendReasonList(); 

				} else {    			
					var not = $.Notify({ content: 'กรุณาระบุฝ่ายงานสำหรับสร้างคำร้องขอ defend case.', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
					not.close(7000); 

				}

			} else {
				/*
    			// To-do when users are change dropdown be retrieve system will popup and force exception fill appno.
    			// append code retrieve to area here.
    			if(select_list == 'After Process') {

    				$('#defenseByRM').attr('disabled', 'disabled');
			   	    $('#defenseBySFE').attr('disabled', 'disabled');

    				if(confirm('คุณค้องการยืนยันการ "Retrieve" ข้อมูลหรือไม่.')) {

    					var actor_id 	= $('#Emp_ID').val();
    					var actor_name	= $('#Emp_Name').val();

    					$('#retrieve_actor_id').val(actor_id);
    					$('#retrieve_actor_name').val(actor_name);
    					$('#retrieve_date').val(str_date);

						var application_no = prompt("กรุณาใส่หมายเลข Application No.", '');

    					if (application_no != '' && application_no != null) {

    						if(application_no.length > 9) {
    							var doc_id 		= $('#DocID').val();
        		    			var actor_id 	= $('#retrieve_actor_id').val();
        		    			var actor_name  = $('#retrieve_actor_name').val();
        		    			var actor_date  = $('#retrieve_date').val();   

        		    			$.ajax({
        		    				url: pathFixed + 'metro/setRetrieveAllowByTransaction?_=' + new Date().getTime(),
        		                    type: "POST",
        		                    data: {
        		                       ref: doc_id,
        		                       xid: actor_id,
        		                       xnm: actor_name,
        		                       xdt: actor_date,
        		                       app: application_no        		       
        		                    },
        		                    success:function(data) {

        		                    	if(data['status']) {
        		                    		var not = $.Notify({ content: data['msg'], style: { background: '#60a917 ', color: '#FFFFFF' }, timeout: 10000 });
        								 	not.close(7000);

        								 	$('#retrieve_ground').append(
        							 			'<div style=" width: 100%; height: 2000px; min-height: auto;background: gray; position: absolute; z-index: 9999; margin-top: -100px; opacity: 0.5;"></div>'+
        							 			'<div style="font-size: 30px; z-index: 1000; margin-left: 45%; margin-top: 20%; position: fixed;">กรุณารอสักครู่ ...</div>'
        							 		);

        								 	setTimeout(function() {
        			                    		window.location.href = pathFixed + 'management/getDataVerifiedManagement?_=b6d767d2f8ed5d21a44b0e5886680cb9&state=false&rel=' + data['ref'] + '&req=P2&live=2';
        			                    	}, 2000);


        		                    	} else {
        		                    		var not = $.Notify({ content: data['msg'], style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
        								 	not.close(7000);

        		                    	}

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

    						} else {

    							alert('application no ควรมากกว่า 9 หลัก กรุณาตรวจสอบใหม่อีกครั้ง.');
        						reloadPages();  
        						return false;

    						}

    					} else {

    						alert('กรุณากรอกหมายเลข application no เพื่อยืนยันการรีเซ็ตข้อมูล.');
    						reloadPages();  
    						return false;
    					}

    					$('#retrieve_actor_id').val('');
    					$('#retrieve_actor_name, #retrieve_actor_name_show').val('');
    					$('#retrieve_date, #retrieve_date_show').val('');
    					$('#retrieve_check_span').removeAttr('style');
    					$('#defend_process').find('option[value="' + defense_mode + '"]').prop('selected', true);

    					reloadPages();
    					return false;

   				 	}

    				reloadPages();

    				return false;    				

    			}
				 */			
			}

		} else {
			$('#defendListModal').modal({ show: false });
		}

	});

	/*   
	// Check onload 
	if($('select[name="defend_process"] option:selected').val() != "") {

		$.ajax({
			url: pathFixed+'dataloads/getDefendList?_=' + new Date().getTime(),
			type: "POST",
			data: {
				relx: query['rel'],
				lnox: $('#defend_no').val()
			},
			success:function(data) {

				if(data['data'][0]['DocID'] == '') {
					$('#objDefendReason').append('<p>ไม่พบข้อมูล</p>');

				} else {

					var objects	= [];
					for(var indexed in data['header']) {
						objects.push({ 
							DocID: data['header'][indexed].DocID, 
							DefendRef: data['header'][indexed].DefendRef, 
							DefendBy: data['header'][indexed].DefendBy, 
							DefendDate: data['header'][indexed].DefendDate, 
							DataContent: '' 
						});

					}

					if(objects && objects.length > 0) {

						$.each(data['data'], function(index, value) {
							var pointer = getIndexByAttribute(objects, 'DefendRef', value.DefendRef);
							if(value['DefendOther'] && value['DefendOther'] != '') {
								objects[pointer].DataContent += value['DefendReason'] + ' เรื่อง' + value['DefendOther'] + ', ';
							} else {
								objects[pointer].DataContent += value['DefendReason'] + ', ';
							}
						});

						var runno = 1;
						var note_text = '';
						for(var indexed in objects) {
							var link_defened = pathFixed + 'defend_control/defenddashboard?_=2063c1608d6e0baf80249c42e2be5804&rel=' + objects[indexed].DocID + '&ref=' + objects[indexed].DefendRef + '&pop=true';
							var str = objects[indexed].data;
							note_text += 
								'<tr class="">' +
								'<td class="paddingBottom10">' + runno + '</td>' +            				 	
								'<td class="paddingBottom10">' + moment(objects[indexed].DefendDate).format('DD/MM/YYYY (HH:mm)') + '</td>' +
								'<td class="paddingBottom10">' + objects[indexed].DefendBy + '</td>' +
								'<td class="paddingBottom10 paddingLeft5" style="text-align: left;">รอบที่ ' + objects[indexed].DefendRef + ': ' + objects[indexed].DataContent.substring(0, objects[indexed].DataContent.length - 2) + '</td>' +
								'<td class="paddingBottom10">' +
								'<a href="' + link_defened + '" target="_blank, _self">' +	
								'<span class="icon-new-tab" style="cursor: pointer;"></span>' +
								'</a>' +
								'</td>' +
								'</tr>';

							runno++;
						}

						$('#objDefendReason').find('table > tbody').html(note_text);
						$('#objDefendReason').find('table > tbody').css({'font-size': '0.8em', 'text-align': 'left' });

					} else { note_text = '<tr><td rowspan="4">ไม่พบข้อมูล</td></tr>'; }

				}

				function getIndexByAttribute(array, attr, value) {
					for(var i = 0; i < array.length; i += 1) {
						if(array[i][attr] === value) {
							return i;
						}
					}            		 
					return -1;
				}

			},
			complete: function() {            	 
				$('#defenseByRM').attr('disabled', 'disabled');
				$('#defenseBySFE').attr('disabled', 'disabled');
				$('#defend_process').attr('disabled', 'disabled').css('background', '#eee'); 

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

	$('input[name="defend_proposer"]').click(function() {

		var select_list = $('select[name="defend_process"] option:selected').val();
		if($('input[name="defend_proposer"]').is(':checked') && select_list != "") {

			if(select_list == 'Before Process' || select_list == 'On Process') {
				loadDefendReasonList(); 
			}

		}


	});

   $('#confirmDefendList').on('click', function() {

		var defend_fieldlist    = $('input[name$="defend_fieldlist[]"]:checked').map(function() {return $(this).val();}).get();
		var defend_topiclist 	= $('input[name$="defend_topiclist[]"]').map(function() {return $(this).val();}).get();

		if(defend_fieldlist[0] == undefined && defend_topiclist == "") {
			var not = $.Notify({ content: 'กรุณาเลือกรายการอย่างน้อย 1 รายการ.', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
				not.close(7000); 

		} else {
			$('#defend_list_bundled').val(defend_fieldlist);
			$('#defend_otherlist_bundled').val(defend_topiclist);

			$('#defendListModal').modal('hide');			

		}

		//if(in_array("OT099", defend_fieldlist) && in_array("", defend_topiclist)) {		
		//	var not = $.Notify({ content: 'กรุณาใส่รายละเอียดให้ครบถ้วน.', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
		//	not.close(7000); 		
		//} 


   });
	 */

	// Link to notepad for defend management (minimize)
	$("#defense_OptionNote").on('click', function(){

		$.Dialog({
			overlay: true,
			shadow: true,
			flat: false,
			icon: '<i class="fa fa-comment"></a>',
			title: 'Defend Note',
			content: '',
			height: '600px',
			width: '95%',
			padding: 10,
			onShow: function(_dialog){
				//loadSFEOnDefendPages
				var html = '<iframe src="' + pathFixed + 'defend_control/getIssueReasonList?rel='+ query['rel'] +'&lnx='+ $('#defend_no').val() +'&whip=false&enable=false&editor=true" width="100%" style="height: 600px; border: 0px;"></iframe>';
				$.Dialog.content(html);

			}

		});

	});


	// Function
	// Load Try Again    
	function reloadPages() {
		$('#retrieve_ground').append(
				'<div style=" width: 100%; height: 2000px; min-height: auto;background: gray; position: absolute; z-index: 9999; margin-top: -100px; opacity: 0.5;"></div>'+
				'<div style="font-size: 30px; z-index: 1000; margin-left: 35%; margin-top: 10%; position: fixed; color: #000;">กรุณารอสักครู่  ระบบกำลังยกเลิกการ Retrieve...</div>'
		);

		setTimeout(function() {
			window.location.href = pathFixed + 'management/getDataVerifiedManagement?_=b6d767d2f8ed5d21a44b0e5886680cb9&state=false&rel=' + $('#DocID').val() + '&req=P2&live=2';
		}, 1000);
	}

	$('#loadProduct').bind('click', function() {

		$.ajax({
			url: pathFixed + 'dataloads/productlist?_=' + new Date().getTime(),
			type: "GET",
			beforeSend:function() {
				pro_progress.show();
			},
			success:function(data) {

				objProduct.empty();
				objProduct.append('<option value="">-- โปรดเลือก  --</option>');
				objProduct.append('<optgroup label="Secure Loan" data-core="Secure Loan"></optgroup>');
				objProduct.append('<optgroup label="Clean Loan" data-core="Clean Loan"></optgroup>');			
				for(var indexed in data['data']) {
					objProduct.find('optgroup[data-core="' + data['data'][indexed]['ProductType'] + '"]').append("<option value='"+data['data'][indexed]['ProductCode']+"' data-type='"+data['data'][indexed]['ProductTypes']+"' data-toggle='tooltip' data-placement='right' title='"+data['data'][indexed]['ProductName']+"'>" + data['data'][indexed]['ProductTypes']+ '-' + data['data'][indexed]['ProductSub'] + ' ' + data['data'][indexed]['ProductName']+"</option>");		                                  	
				}           

				objProduct.find('option[value="'+prdc_hidden.val()+'"]').attr('selected', 'selected');

				var product = $('select[name="productprg"] option:selected');
				var loantype = $('select[name="loantypes"] option:selected').val();
				if(product.closest('optgroup').attr('label') == "Secure Loan") {
					objLoanType.show();
					if(loantype == '1') objBankList.show();
				} else {
					objLoanType.hide();
					objBankList.hide();
					objLoanType.find('option[value=""]').prop('selected', false);
					objBankList.find('option[value=""]').prop('selected', false);
					$('#bank_bundle').val('');
				}

			},
			cache: true,
			complete:function() {
				pro_progress.after(function() {
					$(this).hide();
				});
			},
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

	});

	$('#loadActivateList').bind('click', function() {

		// Autoload: Re-Activate Reason
		objRevisit.empty();
		var reactive_list = [];
		$.ajax({
			url: pathFixed+'dataloads/revisitListChecked?_=' + new Date().getTime(),
			type: "POST",
			data: {
				relx: query['rel']
			},
			beforeSend:function() {
				arv_progress.show();
			},
			success:function(data) {

				for(var indexed in data['data']) {
					reactive_list.push(data['data'][indexed]['RevisitID']);

				}

			},
			complete:function() {

				$.ajax({
					url: pathFixed+'dataloads/revisitList?_=' + new Date().getTime(),
					type: "GET",
					success:function(data) {

						for(var indexed in data['data']) {
							objRevisit.append("<option value='"+data['data'][indexed]['RevisitID']+"'>" + data['data'][indexed]['RevisitReason']+"</option>");
							//$('#reactivate').find('option[value="' + reactive_list[indexed] + '"]').attr('selected', 'selected');
						}

						//objRevisit.find('option[value="'+apv_hidden.val()+'"]').attr('selected', 'selected');
						$('#reactivate').change(function() {}).multipleSelect({ width: '100%'});

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

	setBankList();
	function setBankList() {
		var path_custom = "http://172.17.9.94/newservices/LBServices.svc/";;
		$.ajax({
			url: path_custom + 'master/ddtemplate/bank',
			type: "GET",
			beforeSend:function() {},
			success:function(data) {
				if(data.length > 0) {
					for(var indexed in data) {
						$('#banklist').append("<option value='" + data[indexed]['Bank_Digit'] + "' title='" + data[indexed]['Bank_NameTh'] + "'>" +  data[indexed]['Bank_Digit'] + "</option>");
					}
				}

				var bank_check = $('#bank_bundle').val();
				if(bank_check !== '') {
					$('#banklist').find('option[value="' + bank_check + '"]').prop('selected', true);
				}

			},
			complete:function() {


			},
			cache: true,
			timeout: 5000,
			statusCode: {
				404: function() { console.log( "page not found." ); },
				407: function() { console.log("Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )"); },
				500: function() { console.log("internal server error.");}
			}

		});
	}


	$('#reactivate').change(function() { console.log($(this).val()); }).multipleSelect({ width: '100%' });
	/*
    $('#reactivate').change(function() {
    	if($(this).val() != '') {
    		$('#reactivate_plan').val(); 
    		$('#reactivate_plan').attr('data-state', 'error');
    	}
       	if($(this).val() == null) { 
       		$('#reactivate_plan').val(''); 
       	}  
   	});
	 */
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

	function fnDateCompared(dtmfrom, dtmto){
		return new Date(dtmfrom).getTime() > new Date(dtmto).getTime();    	
	}

	jQuery('.numbersOnly').keyup(function () { 
		this.value = this.value.replace(/[^0-9]/g,'');
		//this.value = this.value.replace(/[^0-9\.]/g,'');
	});

	function loadDefendReasonList() {

		var list_returnreason = [];
		$.ajax({
			url: pathFixed+'dataloads/getDefendType?_=' + new Date().getTime(),
			type: "POST",
			data: { dftype: '' },
			beforeSend:function() {

				$('#defendListModal').modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				}).draggable();		

				// Load Reason of credit return list.
				if($('#listReasonEnabeld').is(':checked')) {

					var documnet_id	  = $('#DocID').val();
					var defend_number = $('#defend_no').val();

					$.ajax({
						url: pathFixed + 'dataloads/getCreditReturnReason?_=' + new Date().getTime(),
						type: 'POST',
						data: {
							doc_ref: documnet_id,
							return_ref: defend_number,
							mode: 'list_load'
						},
						success:function(responsed) {

							if(responsed['status']) {  	                    		
								for(var index in responsed['data']) {
									list_returnreason.push(responsed['data'][index]);  	                    			
								}  	                    		
							} else {
								list_returnreason.push(0); 
							}

						},
						complete:function() {
							$('#defend_otherlist').hide();  	
						},
						cache: false,
						timeout: 5000,
						statusCode: {
							404: function() { alert('page not found.'); },
							407: function() {
								console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
							},
							500: function() { console.log('internal server error.'); }
						}

					});

				}

			},
			success:function(data) {

				$('div#defend_content').html('');  	        	 
				for(var indexed in data['data']) {

					var margin;
					if(indexed == 0) margin = 'style="min-width: 1150px; margin-top: -20px;"';

					$('div#defend_content').append(
							'<div class="panel" ' + margin + '>' +
							'<div class="panel-header panel-header-custom bg-lightBlue fg-white text-left" style="font-size: 1.2em; font-weight: bold; min-height: 37px !important; max-height: 37px !important; vetical-text: top; padding-bottom: 2px !important;">' +
							data['data'][indexed]['MDefendSubject'] +
							'</div>' +
							'<div class="row panel-content" data-core="' + data['data'][indexed]['MDefendCode'] + '" style="margin-top: 0px !important;"></div>' +
							'</div>'
					);

				}

			},
			complete:function() {

				$('div#defend_content').find('div.panel-header').truncate({
					width: '470',
					token: '…',
					side: 'right',
					addtitle: true
				});


				$.ajax({
					url: pathFixed+'dataloads/getDefendReason?_=' + new Date().getTime(),
					type: "POST",
					data: { dftype: '' },
					beforeSend:function() {

					},
					success:function(data) {

						var margin;
						if(indexed != 0) { 	            		 
							margin = 'style="margin-left: 10px !important; margin-top: -10px !important; margin-bottom: -5px !important; min-width: 350px !important;"';  		 	            		 
						}

						for(var indexed in data['data']) {

							$('div#defend_content')
							.find('div[data-core="' + data['data'][indexed]['DefendType'] + '"]')
							.append(
									'<div class="defend_sublist span3 text-left" ' + margin + '>' +
									'<div class="input-control checkbox">' +
									'<label>' +
									'<input id="defend_fieldlist_' + indexed + '" name="defend_fieldlist[]" type="checkbox" value="' + data['data'][indexed]['DefendCode'] + '">' +
									'<span class="check"></span>' +
									'<span class="defend_fieldtext" style="font-weight: normal;">' + data['data'][indexed]['DefendReason'] + '</span>' +
									'</label>' +
									'</div>' +
									'</div>'
							);

						}   

						$('input[name^="defend_fieldlist"]').on('click', function() {

							var other_field = $('input[name$="defend_fieldlist[]"]:checked').map(function() {return $(this).val();}).get();
							if(in_array("OT099", other_field)) {
								$('#defend_otherlist').show();
							} else {
								$('#defend_otherlist').hide();		   
							}

						});

					},
					complete:function() {

						$('div.defend_content').find('span.careturnlist_text').truncate({
							width: '400',
							token: '…',
							side: 'right',
							addtitle: true
						});	  

						if(list_returnreason[0]['DefendCode'] != "") {

							var defend_code = [];
							for(var index in list_returnreason) {
								$('input[name^="defend_fieldlist"][value="' + list_returnreason[index]['DefendCode'] + '"]').prop('checked', true);

								if(list_returnreason[index]['DefendCode'] == "OT099") {
									defend_code.push({ DefendCode: list_returnreason[index]['DefendCode'], DefendOther: list_returnreason[index]['DefendOther']});
								}

							}

							if(in_array('OT099', defend_code[0])) {

								$.each(defend_code, function(index, value) { 

									if(index == 0) {
										$('#defend_topicRootlist').val(defend_code[index].DefendOther);

									} else {

										$(".input_fields_wrap").append(
												'<div class="input-control text">' +
												'<label class="label label-clear ">อื่นๆ : </label>' +
												' <input name="defend_topiclist[]" type="text" value="' + defend_code[index].DefendOther + '" class="size4">' +
												' <i class="fa fa-close fg-red marginTop5 remove_field" style="font-size: 1.5em !important; position: absolute; margin-top: 5px; margin-left: 10px;"></i>' +    
												'</div>'
										);

									}

								});

								$('#defend_otherlist').show();

							} 

						}

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

	// Uncheck onload reason list
	$('#listReasonEnabeld').click(function() {


		if(!$('#listReasonEnabeld').is(':checked')) {

			$('input[name^="defend_fieldlist"]').prop('checked', false);
			$('.input_fields_wrap').html(
					'<div class="input-control text">' +
					'<label class="label label-clear">อื่นๆ :</label>' +
					'<input id="defend_topicRootlist" name="defend_topiclist[]" type="text" value="" class="size4"> ' +
					'<span class="tooltip-top marginLeft5" data-tooltip="Add new topic.">' +
					'<i class="fa fa-plus-circle fg-green marginTop5 add_field_button" style="font-size: 1.5em !important;"></i>' +
					'</span>' +									    	
					'</div>	'
			);

			$('#defend_otherlist').hide();

		} else {

			var list_returnreason = [];
			var defend_code   = [];
			var documnet_id	  = $('#DocID').val();
			var defend_number = $('#defend_no').val();


			$.ajax({
				url: pathFixed + 'dataloads/getCreditReturnReason?_=' + new Date().getTime(),
				type: 'POST',
				data: {
					doc_ref: documnet_id,
					return_ref: defend_number,
					mode: 'list_load'
				},
				success:function(responsed) {

					if(responsed['status']) {	              		
						for(var index in responsed['data']) {
							list_returnreason.push(responsed['data'][index]);  	                    			
						}	              		
					} else {
						list_returnreason.push(0); 
					}

				},
				complete:function() {

					if(list_returnreason[0]['DefendCode'] != "") {

						for(var index in list_returnreason) {
							$('input[name^="defend_fieldlist"][value="' + list_returnreason[index]['DefendCode'] + '"]').prop('checked', true);

							if(list_returnreason[index]['DefendCode'] == "OT099") {
								defend_code.push({ DefendCode: list_returnreason[index]['DefendCode'], DefendOther: list_returnreason[index]['DefendOther']});
							}

						}

						if(in_array('OT099', defend_code[0])) {

							$.each(defend_code, function(index, value) { 

								if(index == 0) {
									$('#defend_topicRootlist').val(defend_code[index].DefendOther);

								} else {

									$(".input_fields_wrap").append(
											'<div class="input-control text">' +
											'<label class="label label-clear ">อื่นๆ : </label>' +
											' <input name="defend_topiclist[]" type="text" value="' + defend_code[index].DefendOther + '" class="size4">' +
											' <i class="fa fa-close fg-red marginTop5 remove_field" style="font-size: 1.5em !important; position: absolute; margin-top: 5px; margin-left: 10px;"></i>' +    
											'</div>'
									);

								}

							});

							$('#defend_otherlist').show();

						} 

					}

				},
				cache: false,
				timeout: 5000,
				statusCode: {
					404: function() { alert('page not found.'); },
					407: function() {
						console.log('Proxy Authentication Required ( The ISA Server requires authorization to fulfill the request. Access to the Web Proxy service is denied. )');
					},
					500: function() { console.log('internal server error.'); }
				}

			});

		}    	

	});

});