$(function() {

	var defend_element 	= $('#defend_enable');
	var defend_create  	= $('#defend_creation');
	var defend_state   	= $('#defend_creation_state');
	var defend_date    	= $('#defend_date');
	var defend_fake	   	= $('#defend_date_disbled')
	var parent_defdate 	= $('#parent_defend_date');
	
	var idefend_remove 	= $('#defend_icon_remove');
	var idefend_hist   	= $('#defend_icon_history');	
	
	defend_create.click(function() {
		if(defend_create.is(':checked')) {			
			defend_date.val(moment().format('DD/MM/YYYY'));
			defend_fake.val(moment().format('DD/MM/YYYY'));
			
			parent_defdate.css('width', '238px');
			idefend_remove.removeClass('hide');
			idefend_hist.removeClass('hide');
						
			loadDefendReasonList();
		} else {
			defend_state.val('')
			defend_date.val('');
			defend_fake.val('');
			
			parent_defdate.css('width', '268px');
			idefend_remove.addClass('hide');
			idefend_hist.addClass('hide');
			
		}
	});
	
	_.delay(function() {
		loadDefendCreateHistory();
		
	}, 1000)

	$('#cancelDefendList').bind('click', function() {

		defend_create.prop('checked', false);
		defend_date.val('');
		defend_fake.val('');

		$('#defendListModal').modal('hide');

	});

	$('#confirmDefendList').on('click', function() {
		if(confirm('กรุณายืนยันความถูกต้องของข้อมูล กรณีข้อมูลถูกต้อง โปรดกด OK')) {
			
			var defend_fieldlist    = $('input[name$="defend_fieldlist[]"]:checked').map(function() {return $(this).val();}).get();
			var defend_fieldname    = $('input[name$="defend_fieldlist[]"]:checked').map(function() {return $(this).data('attr');}).get();
			var defend_topiclist 	= $('input[name$="defend_topiclist[]"]').map(function() {return $(this).val();}).get();

			if(defend_fieldlist[0] == undefined && defend_topiclist == "") {
				var not = $.Notify({ content: 'กรุณาเลือกรายการอย่างน้อย 1 รายการ.', style: { background: "red", color: "#FFFFFF" }, timeout: 10000 });
				not.close(7000); 

			} else {
				defend_create.prop('disabled', true);
				
				defend_state.val('Draft');
				$('#defend_list_bundled').val(defend_fieldlist);
				$('#defend_otherlist_bundled').val(defend_topiclist);
				
				generateListLog($('#Emp_Name').val(), moment().format('DD/MM/YYYY'), defend_fieldname)

				$('#defendListModal').modal('hide');	
				
				$.Notify({ 
					caption: '<h5 class="fg-white">Defend: สร้างรายการข้อมูล</h5>', 
					content: (
						'<p class="fg-white" style="font-size: 0.9em;">รายการหัวข้อที่ต้องการถูกเลือกแล้ว</p>' +
						'<p class="fg-white" style="font-size: 0.9em;">รายละเอียดข้อมูลปัจจุบันอยู่ในสถานะข้อมูลชั่วคราว<br/>โปรดบันทึกข้อมูลเพื่อสร้างรายการ</p>'+
						'<p class="fg-white" style="font-size: 0.9em;">กรุณาบันทึกข้อมูลเพื่อยืนยันการสร้างรายการ</p>'
					), 
					style: { background: "#008A00" }, 
					timeout: 15000 
				});
				
				$('#onprocess').removeClass('bg-lightBlue').addClass('bg-red icon_blink_slow');

			}
			
			return true;
			
		}
		
		return false;

	});
	
	// Defend Clear 
	idefend_remove.click(function() {
		if(confirm('โปรดตรวจสอบความถูกต้อง ก่อนยืนยันการล้างข้อมูล กรณีต้องการล้างข้อมูลคลิก OK')) {
			
			defend_date.val('');
			defend_fake.val('');
			
			parent_defdate.css('width', '268px');
			idefend_remove.addClass('hide');
			idefend_hist.addClass('hide');
			
			defend_create.prop('checked', false);
			defend_create.prop('disabled', false);

			return true;
		}
		
		return false;
	});
	
	// Tooltip
	idefend_hist.hover(function() {
		var listContent = $('#objDefendReason').html();												
		$(this).webuiPopover({
			trigger:'click',	
			padding: true,
			content: listContent,
			backdrop: false
		});
	});
	
	function generateListLog(str_actor, str_date, list) {
		if(list && list.length > 0) {			
			var topic_name = '';
			$.each(list, function(index, str) { topic_name += (index + 1) + '. ' + str + '<br />' });

			if(topic_name && topic_name !== '') {
				$('#defend_logs > tbody').append(
					'<tr>' + 
						'<td>' + str_date + '</td>' +
						'<td style="text-align: left;">' + str_actor + '</td>' +
						'<td style="text-align: left;">' + topic_name + '</td>' +
					'</tr>'
				);
			}

		}
		
	}
	
	function generateDefaultListLog(list) {
		if(list && list.length > 0) {					
			_.each(list, function(data) { 
				var create_date = data.CreateDate;
				
				var listData = '';
				var nameData = '';
				if(data.List && data.List.length > 0) {
					listData = _.map(data.List, function(objData) { return (objData.DefendReason) ? objData.DefendReason:''; });
					nameData = _.map(data.List, function(objData) { return (objData.CreateName) ? objData.CreateName:''; })
				}
				
				if(listData && listData.length > 0) {
					var actor_name = (nameData && nameData.length > 0) ? _.uniq(nameData).toString():'-';
					var topic_reason = '';
					_.map(listData, function(str, index) { topic_reason += (index + 1) + '. ' + str + '<br/>' });
	
					if(topic_reason && topic_reason !== '') {
						$('#defend_logs > tbody').append(
							'<tr>' + 
								'<td>' + create_date + '</td>' +
								'<td style="text-align: left;">' + actor_name + '</td>' +
								'<td style="text-align: left;">' + topic_reason + '</td>' +
							'</tr>'
						);
					}
					
				}

			});
			
		}
	}
	
	function loadDefendCreateHistory() {
		var documnet_id	  = $('#DocID').val();
		$.ajax({
			url: pathFixed + 'dataloads/loadDefendList?_=' + new Date().getTime(),
			type: 'POST',
			data: { doc_id: documnet_id },
			success:function(resp) {				
				if(resp['status']) {  	  
					var responsed = resp.data;
			
					var date_list = [];
					_.each(responsed, function(data) { date_list.push(data.CreateDate); });
						
					var data_list = [];
					if(date_list && date_list.length > 0) {
						var uniq_content = _.uniq(date_list);	
						_.each(uniq_content,  function(data) {
							var findData = _.filter(responsed, { CreateDate: data });
							data_list.push({ CreateDate: data, List: findData });							
						});						
					}
					
					if(data_list && data_list.length > 0) {
						generateDefaultListLog(data_list);
					}					
						                    		
				}				
			},
			complete:function() {
				$('#defend_otherlist').hide();  	
			},
			cache: false,
			timeout: 5000,
			statusCode: {}
		});
	}
	
	function loadDefendReasonList() {
		var reason = [];
		$.ajax({
			url: pathFixed + 'dataloads/getDefendTopicNewList',
			type: 'GET',
			beforeSend: function() {
				$('#defendListModal').modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				}).draggable();	
				
				$('div#defend_content').empty();
			},
			success:function(responsed) {	
				if(responsed['status']) {  	          
					var data = responsed.data;
					var dataList = responsed.dataList;
					if(data && data.length > 0) {		
				
						var data_rows = 1;
						_.each(data, function(data, index) {	
						
							var tooltip_text = '';
							var data_reasons = _.filter(dataList, { MainCode: data.MainCode });
							
							if(data_reasons && data_reasons.length > 0) {
								var _underline = '';
								if(data_reasons.length > 1) {
									_underline = '<hr class="margin_none" />';
								}
								_.each(data_reasons, function(data) {
									var remark = (data.Remark && data.Remark !== '' && data.Remark !== '-') ? ' (' + data.Remark + ')':'';
									tooltip_text += data.DeviateCode + ' - ' + data.DeviateReason + remark + _underline;
								});
							}
							
							var items = (
								'<div class="defend_sublist span4 marginLeft_none text-left">' +
									'<div class="input-control checkbox">' +
										'<label>' +
											'<input id="defend_fieldlist_' + index + '" name="defend_fieldlist[]" type="checkbox" data-attr="' + data.MainReason + '" value="' + data.MainCode + '">' +
											'<span class="check"></span>' +
											'<span id="defend_translate_' + data_rows + '" data-attr="' + data.MainCode + '"  class="defend_fieldtext" style="font-weight: normal;">' + data_rows + '. ' + data.MainReason + '</span>' +
										'</label>' +
									'</div>' +
									'<span id="defendList_' + data_rows + '" class="hide">' + tooltip_text + '</span>' +									
								'</div>'
							);					
							
							$('div#defend_content').append(items).after(function() { getTopicList(data_rows); });
							
							data_rows++;							
							
						});
						
					}
					
				}
				
			},
			complete:function() {},
			cache: true,
			timeout: 15000,
			statusCode: {}
		});
		
		function getTopicList(index) {
			var listContent = $('#defendList_' + index).html();			
			$('#defend_translate_' + index).hover(function() {
				$(this).webuiPopover({
					trigger:'hover',	
					padding: true,
					content: listContent,
					placement: 'right',
					backdrop: false
				});				
			});	 
		}
		
	}
});