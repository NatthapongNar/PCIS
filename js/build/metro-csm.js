$(function() {

	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
	var pathFixed = window.location.protocol + "//" + window.location.host;
	for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
	for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

	// Buff engine
	engine = null;
	if (window.navigator.appName == "Microsoft Internet Explorer") {
		// This is an IE browser. What mode is the engine in?
		if (document.documentMode)
			engine = document.documentMode;

		else {  
			engine = 7; 

			if (document.compatMode) {
				if (document.compatMode == "CSS1Compat")
					engine = 9; // standards mode
			}

		}

	}
	
	/*
	var to_list = [
		'supa.m@tcrbank.com',
		'numpueng.p@tcrbank.com',
		'Khajit.k@tcrbank.com',
		'Apichaya.o@tcrbank.com',
		'Chadaporn.r@tcrbank.com',
		'mananya.b@tcrbank.com',
		'somchat.r@tcrbank.com',
		'Defend Team'
	];
 
	var name_list = [
		'สุภา มุติโคตร',
		'น้ำผึ้ง เผือกพูล ',
		'ขจิตร กันยาวรารักษ์',
		'อภิชญา มีทรัพย์หลาก',
		'ชฎาพร รัตนถาวร',
		'มนัญญา บุญศิริมงคล ',
		'สมชาติ ฤทธิ์คำรพ',
		'Defend Team'
	];

	_.delay(function() {
		
		var url = pathFixed + "dataloads/checkSendEmail?_=" + new Date().getTime();
		$.ajax({
			url: url,
			type: "GET",
			success: function (responsed) {
				if(responsed.status) {	
					
					var table_body = '';				
					if(responsed.data && responsed.data.length > 0) {
						
						if(checkTime()) {
							_.forEach(responsed.data, function(v, i) {
								var create_date = (v.CreateDate) ? moment(v.CreateDate).format('DD/MM/YYYY'):moment().format('DD/MM/YYYY');
								table_body += '<tr>' +
									'<td style="color: #666;">' + v.ApplicationNo + '</td>' +
									'<td style="color: #666;">' + v.IDCard + '</th>' +
									'<td style="color: #666;">' + v.BorrowerName + '</td>' +									
									'<td style="color: #666;">' + v.RegionName + '</td>' +
									'<td style="color: #666;">' + v.BranchDigit + '</td>' +
									'<td style="color: #666;">' + v.BranchName + '</td>' +
									'<td style="color: #666;">' + v.RMName + '</td>' +
									'<td style="color: #666;">' + v.RMMobile + '</td>' +									
									'<td style="color: #666;">' + create_date + '</td>' +
						        '</tr>';
							});
							
											
							if(table_body && table_body !== '') {								
								_.forEach(to_list, function(data, i) {
									var template = getTemplate(table_body, name_list[i]);
									Email.send(
										"nartnorakij@gmail.com",
										data,
										"PCIS: Request Defend List",
										template,
										"smtp.elasticemail.com",
										"nartnorakij@gmail.com",
										"f4f71626-7fa8-40b2-84f0-556c918e39c0"
									);

								});
										
								updateSentInfo(responsed.data);
				
							}
							
						}
		
					}				
				}

			},
			complete: function() { updateReSentFile(); },
			error: function (error) {}
		});
		
	}, 10000);
	*/

	function getTemplate(content, header) {
		if(content) {			
			moment.locale('th');
			
			var today = moment().format('ll')
			var html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' +
			'<html xmlns="http://www.w3.org/1999/xhtml">' +
			  '<head>' +
			    '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' +
			    '<style>' +
			      'html,body,table,th,td,p,div,span {font-family: Gill Sans,sans-serif;font-variant: normal;font-style: normal;}' +
			      'table {border: 1px solid #D1D1D1;}' +
			      'th, td {padding: 5px;font-size: 100%;}' +
			    '</style>' +
			  '</head>' +
			  '<body>' +	
			  '<p>เรียน คุณ' + header + '</p>' +
			    '<p> ขออนุญาตแจ้งรายชื่อลูกค้าที่ขอ Defend ประจำวันที่ ' + today + ' ' + checkRountTime() + '</p>' +
			    '<h3 style="font-style: oblique;">Request Defend Report</h3>' +
			    '<table id="grid_table" border="1" cellpadding="0" cellspacing="0" height="100%" width="auto">' +
			      '<thead style="background-color: #286090;">' +
			        '<tr>' +
			          '<th style="color: #FFF;">Application No</th>' +
			          '<th style="color: #FFF;">ID Card</th>' +
			          '<th style="color: #FFF;">Borrower Name</th>' +			          
			          '<th style="color: #FFF;">Region Name</th>' +
			          '<th style="color: #FFF;">Branch Digit</th>' +
			          '<th style="color: #FFF;">Branch Name</th>' +
			          '<th style="color: #FFF;">RM Name</th>' +
			          '<th style="color: #FFF;">RM Mobile</th>' +			          
			          '<th style="color: #FFF;">Defend Date</th>' +
			        '</tr>' +
			      '</thead>' +
			      '<tbody id="grid_table_body">' + content + '</tbody>' +
			    '</table>' +
			    '<p style="font-size: 0.8em;">' + 'หมายเหตุ: กรณีใช้ไฟล์ PDF เสร็จสิ้น รบกวนทางทีมผู้ใช้งานปิดตัวเอกสาร เนื่องจากในกรณีมีข้อมูลเพิ่มเติมและต้องการจะอัพเดทข้อมูลจะไม่สามารถทำได้ เนื่องจากไฟล์ถูกล็อคทำให้ระบบไม่สามารถอัพเดทได้ครับ' + '</p>' +
			    '<p style="font-size: 0.8em;">' + 'จึงเรียนมาเพื่อทราบ' + '</p>' +
			    '<p style="font-size: 0.8em;">' + 'ขอบคุณครับ' + '</p>' +
			    '<p style="margin-top: 10px; color: gray; font-size: 0.8em;">' + 'PCIS' + '</p>' +
			  '</body>' +
			'</html>';
			
			return html;
			
		} else {
			return content;
		}		
	}
	
	function updateSentInfo(data){
		if(data && data.length > 0) {
			$.ajax({
				url: pathFixed + "index.php/dataloads/updateSendEmail?_=" + new Date().getTime(),
				type: "POST",
		        data: { items: data },
				success: function (responsed) {},
				error: function (error) {}
			});
		}
	}
	
	function updateReSentFile() {
		var start_time = moment().format('YYYY-MM-DD ' + '08:00:00');
		var end_period = moment().format('YYYY-MM-DD ' + '09:30:00');
		var currentTime = moment().format('YYYY-MM-DD HH:mm:ss');
		
		if(moment(currentTime).isBetween(moment(start_time), moment(end_period))) {
			$.ajax({
				url: pathFixed + "index.php/defend_control/reupdatefile?_=" + new Date().getTime(),
				type: "GET",
				cache: false,
				success: function (responsed) {},
				error: function (error) {console.log(error);}
			});
		} else { console.log('Out of period, re-send new files (The period is time 08:00:00 - 09:30:00)'); }
	}
	
	function checkTime() {		
		var currentTime = moment().format('YYYY-MM-DD HH:mm:ss');	
		var period = { 
			'R1': [moment().format('YYYY-MM-DD ' + '10:00:00'), moment().format('YYYY-MM-DD ' + '11:00:00')], 
			'R2': [moment().format('YYYY-MM-DD ' + '13:00:00'), moment().format('YYYY-MM-DD ' + '15:00:00')], 
			'R3': [moment().format('YYYY-MM-DD ' + '16:00:00'), moment().format('YYYY-MM-DD ' + '20:00:00')]
		}
		
		if(moment(currentTime).isBetween(moment(period.R1[0]), moment(period.R1[1]))) {
			return true;
		}
		else if(moment(currentTime).isBetween(moment(period.R2[0]), moment(period.R2[1]))) {
			return true;
		}
		else if(moment(currentTime).isBetween(moment(period.R3[0]), moment(period.R3[1]))) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function checkRountTime() {		
		var currentTime = moment().format('YYYY-MM-DD HH:mm:ss');	
		var period = { 
			'R1': [moment().format('YYYY-MM-DD ' + '10:00:00'), moment().format('YYYY-MM-DD ' + '11:00:00')], 
			'R2': [moment().format('YYYY-MM-DD ' + '14:00:00'), moment().format('YYYY-MM-DD ' + '15:00:00')], 
			'R3': [moment().format('YYYY-MM-DD ' + '16:00:00'), moment().format('YYYY-MM-DD ' + '20:00:00')]
		}
		
		if(moment(currentTime).isBetween(moment(period.R1[0]), moment(period.R1[1]))) {
			return 'รอบที่ 1 (10.00 น.)';
		}
		else if(moment(currentTime).isBetween(moment(period.R2[0]), moment(period.R2[1]))) {
			return 'รอบที่ 2 (14.00 น.)';
		}
		else if(moment(currentTime).isBetween(moment(period.R3[0]), moment(period.R3[1]))) {
			return 'รอบที่3 (16.00 น.)';
		}
		else {
			return '';
		}
	}

	// Add effect
	$('#applicationprocess').addClass('animated flipInX');
	$('#applicationprogress').addClass('animated flipInX');
	$('#docmanagement').addClass('animated flipInX');
	$('#referral_activity').addClass('animated flipInX');
	$('#MIS').addClass('animated flipInX');
	//$('#Whiteboard').addClass('animated flipInX');
	$('#dailyreport').addClass('animated flipInX');
	$('#Prospectcustomer').addClass('animated flipInX');
	$('#a2ca').addClass('animated flipInX');
	$('#monthlyreport').addClass('animated flipInX');
	$('#evs').addClass('animated flipInX');
	$('#SOC').addClass('animated flipInX');
	//$('#Referral').addClass('animated flipInX');
	//$('#kpi_report').addClass('animated flipInX');



	// Calendar
	var clndr_load  = pathFixed + "index.php/metro/calendarEvent?_=" + new Date().getTime();
	$("#clndr-frame").remove('src').attr('src', clndr_load);

	$("#container-calendar").hide();
	$("#calendar-control").click(function() {
		$("#container-calendar").slideToggle('slow');
	});

	// Implement statement 03/02/2015
	var feedback = $('#feedback');

	$('#feedback h2').click(function(){

		// We are storing the values of the animated
		// properties in a separate object:

		var anim	= {		
				mb : 0,			// Margin Bottom
				pt : 25			// Padding Top
		};

		var el = $(this).find('.arrow');

		if(el.hasClass('down')){
			anim = {
					mb : -380,
					pt : 10
			};
		}

		// The first animation moves the form up or down, and the second one 
		// moves the "Feedback heading" so it fits in the minimized version

		feedback.stop().animate({marginBottom: anim.mb});

		feedback.find('.section').stop().animate({paddingTop:anim.pt},function(){
			el.toggleClass('down up');
		});
	});

});