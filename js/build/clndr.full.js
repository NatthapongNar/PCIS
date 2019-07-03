$(document).ready(function() {
	
	var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
    var pathFixed = window.location.protocol + "//" + window.location.host;
    for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
    for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }
	
	var str;
    var objDate = new Date();
    str = objDate.getFullYear()+"-"+("0" + (objDate.getMonth() + 1)).slice(-2) + "-" + ("0" + objDate.getDate()).slice(-2);
		
	$("#calendar").fullCalendar({
		header: {
			left: "prev,next today",
			center: "title",
			right: "month,agendaWeek,agendaDay"
		},
		defaultDate: str,
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: [
			{
				title: "Appointment",
				url: pathFixed+"metro/notificationManagement",
				start: str
			},
			{
				title: "Re-Activate Plan",
				url: pathFixed+"metro/notificationManagement",
				start: "2014-10-07",
				end: "2014-10-10"
			},
			{
				id: 999,
				title: "Appointment",
				url: pathFixed+"metro/notificationManagement",
				start: "2014-10-09T16:00:00"
			},
			{
				id: 999,
				title: "Appointment",
				url: pathFixed+"metro/notificationManagement",
				start: "2014-10-16T16:00:00"
			},
			{
				title: "Re-Activate Plan",
				url: pathFixed+"metro/notificationManagement",
				start: "2014-10-11",
				end: "2014-10-13"
			},
			{
				title: "Appointment",
				url: pathFixed+"metro/notificationManagement",
				start: objDate.getFullYear()+"-"+("0" + (objDate.getMonth() + 1)).slice(-2)+"-"+("0" + (objDate.getDate()-1)).slice(-2),
				end: str
			},
			{
				title: "Appointment",
				url: pathFixed+"metro/notificationManagement",
				start: "2014-10-12T12:00:00"
			},
			{
				title: "Meeting",
				url: pathFixed+"metro/notificationManagement",
				start: str
			},
			{
				title: "Appointment",
				url: pathFixed+"metro/notificationManagement",
				start: "2014-10-12"
			},
			{
				title: "Call Out: Appointment",
				url: pathFixed+"metro/notificationManagement",
				start: "2014-10-12",
				end	 : "2014-10-15"
			},
			{
				title: "Appointment",
				url: pathFixed+"metro/notificationManagement",
				start: "2014-10-13T07:00:00"
			},
			{
				title: "Appointment",
				url: pathFixed+"metro/notificationManagement",
				start: "2014-10-28"
			}
		]
	});
	
});