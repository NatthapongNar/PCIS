$(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    var rootFixed = window.location.protocol + "//" + window.location.host + '/pcis';
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
    var query  = getQueryParams(document.location.search);
    
    $('#btnAcceptSwitch').click(function() {
    	
    	if(confirm('กรุณายืนยันการปรับปรุงข้อมูล.')) {
    		
    		var sw_ncb_id		   = $('input[name$="SW_NCB_ID[]"]').map(function() {return $(this).val();}).get();
    		var sw_verify_id	   = $('input[name$="SW_NCBVerifyID[]"]').map(function() {return $(this).val();}).get();
    		var sw_ncb_idcard      = $('input[name$="NCBIDNo[]"]').map(function() {return $(this).val();}).get();
    		var sw_ncb_type        = $('input[name$="SW_NCBType[]"]').map(function() {return $(this).val();}).get();
    		var sw_ncb_name 	   = $('input[name$="SW_NCBName[]"]').map(function() {return $(this).val();}).get();
    		var sw_ncb_isref	   = $('input[name$="SW_NCBIsRef[]"]').map(function() {return $(this).val();}).get();	
    		
    		var sw_df_id   		   = $('input[name$="SW_RecID[]"]').map(function() {return $(this).val();}).get();
    		var sw_df_type         = $('input[name$="SW_DFType[]"]').map(function() {return $(this).val();}).get();
    	    var sw_df_name 		   = $('input[name$="SW_DFName[]"]').map(function() {return $(this).val();}).get();
    	    var sw_df_isref        = $('input[name$="SW_DFIsRef[]"]').map(function() {return $(this).val();}).get();
    	    
    	    var sw_ncb_newtype     = $('select[name$="SW_NCBChangeType[]"]').map(function() {return $(this).val();}).get();
    	    var sw_df_newtype      = $('input[name$="CH_DFType[]"]').map(function() {return $(this).val();}).get();  

    		var types	 = [];
    		var elements = $('input[name^="SW_NCB_ID"]').length;
			for(var i = 0; i < elements; i++) {
				
				var indexed = i + 1;
								
				if($("#SW_NCBChangeType_" + indexed).val() == "101") { types.push('true'); } 				
				if($("#SW_NCBChangeType_" + indexed).val() == "" || $("#SW_NCBChangeType_" + indexed).val() == undefined) {
    				
    				$("#SW_NCBChangeType_" + indexed).parent().removeClass('info-state').addClass('error-state');
    				var not = $.Notify({ content: "กรุณาระบุประเภทของผู้กู้ใหม่ และโปรดระบุให้ครบถ้วน.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
    				not.close(7000);
    				return false;
    				
    			} 
								
			}
			
			if(types.length <= 0) {
				var not = $.Notify({ content: "ขออภัย!! ไม่พบข้อมุลผู้กู้หลักในระบบ กรุณาระบุผู้กู้หลัก.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
								
	    		var elements = $('input[name^="SW_NCB_ID"]').length;
				for(var i = 0; i < elements; i++) {
					var indexed = i + 1;
					$("#SW_NCBChangeType_" + indexed).parent().removeClass('info-state').addClass('error-state');
				}
				
				not.close(7000);
				
				return false;
				
			}
			
			if(types.length >= 2) {
				var not = $.Notify({ content: "ขออภัย!! มีผู้กู้หลักมากกว่า 1 ราย กรุณาตรวจสอบข้อมูลใหม่อีกครั้ง.", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
								
	    		var elements = $('input[name^="SW_NCB_ID"]').length;
				for(var i = 0; i < elements; i++) {
					var indexed = i + 1;
					$("#SW_NCBChangeType_" + indexed).parent().removeClass('info-state').addClass('error-state');
				}
				
				not.close(7000);
				
				return false;
				
			} else {
				
				var elements = $('input[name^="SW_NCB_ID"]').length;
				for(var i = 0; i < elements; i++) {
					var indexed = i + 1;
					$("#SW_NCBChangeType_" + indexed).parent().removeClass('info-state').removeClass('error-state').addClass('success-state');
				}
				
			}
			
			// To-do change borrower and new id card.
						
			$.ajax({
            	url: pathFixed+'management/setNewBorrowerTypes?_=' + new Date().getTime(),
                type: 'POST',
				data: {
					relx: query['rel'],
					vefx: sw_verify_id,
					ncb_id: sw_ncb_id,
					id_card: sw_ncb_idcard,
		    		ncb_type: sw_ncb_type,
		    		ncb_name: sw_ncb_name,
		    		ncb_isref: sw_ncb_isref,
		    		df_id: sw_df_id,
		    		df_type: sw_df_type,
		    	    df_name: sw_df_name,
		    	    df_isref: sw_df_isref,
		    	    
		    	    ncb_renew_type: sw_ncb_newtype,
		    	    df_renew_type: sw_df_newtype
				},
                success:function(data) {
                	
                	var responsed = JSON.parse(data);
                	if(responsed['status'] == 'true') {
                		
                		var not = $.Notify({ content: 'ปรับปรุงข้อมูลสำเร็จ กรุณารอสักครู่...', style: { background: '#60a917 ', color: '#FFFFFF' }, timeout: 10000 });
					 	not.close(7000);
					 	
					 	$('#SwitchModal').modal('hide');					 	
					 	$('#retrieve_ground').append(
				 			'<div style=" width: 100%; height: 2000px; min-height: auto;background: gray; position: absolute; z-index: 9999; margin-top: -100px; opacity: 0.5;"></div>'+
				 			'<div style="font-size: 30px; z-index: 1000; margin-left: 45%; margin-top: 20%; position: fixed;">กรุณารอสักครู่ ...</div>'
				 		);
					 						 	    								 	
					 	setTimeout(function() {
                    		window.location.href = pathFixed + 'management/getDataVerifiedManagement?_=b6d767d2f8ed5d21a44b0e5886680cb9&state=false&rel=' + responsed['data'] + '&req=P2&live=2';
                    	}, 500);
                    	

                	} else {
                		var not = $.Notify({ content: 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาติดต่อผู้ดูแลระบบ', style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
					 	not.close(7000);
					 	
                	}
                	
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
			
			
			return true;
    		
    	}
    	
    	return false;
    	
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