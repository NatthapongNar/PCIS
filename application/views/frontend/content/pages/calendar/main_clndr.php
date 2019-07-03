<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $author; ?></title>
    <meta name="description" content="<?php echo $desc; ?>">
    <meta name="viewport" content="<?php echo $viewport; ?>">
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <meta name="author" content="<?php echo $author; ?>">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/logo.ico'); ?>">
    
	
	<link href="<?php echo base_url('css/responsive/responsive.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('css/responsive/bootstrap-checkboxcolor.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('css/awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('css/fullcalendar/fullcalendar.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('css/fullcalendar/fullcalendar.print.css'); ?>" rel="stylesheet" media="print">
	<link href="<?php echo base_url('css/custom/wp.custom.css'); ?>" rel="stylesheet">
	
	<script src="<?php echo base_url('js/fullcalendar/lib/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/vendor/jquery.widget.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/fullcalendar/lib/moment.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/fullcalendar/fullcalendar.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/build/clndr.full.js'); ?>"></script>
	<script>

		$("#objColor_1").css("background-color", "rgb(58, 135, 173)");
		
	</script>
	<style>
	
		body {
			margin: 40px 10px;
			padding: 0;
			font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
			font-size: 14px;			
		}
	
		#calendar {
			max-width: 900px;
			margin: 0 auto;			
		}
		
		.modal .modal-dialog {
		  width: 70%;
		}
		.modal .modal-body {
		  overflow-y: auto;
		}
	
		.styled { width: 20px; height: 20px; }
		.labelField_limit { max-width: 390px; }
		.label_limit { max-width: 110px !important; }
		
	</style>
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="objClndr" tabindex="-1" role="dialog" aria-labelledby="objClndrLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="objClndrLabel">CREATE ACTIVITIES</h4>
      </div>
      <div class="modal-body">
      
   			<!-- Subject -->
	      	<div class="form-group">
	      		<div class="col-md-10">
					<div class="col-sm-8">
						 <input id="formGroupInputSmall" name="" type="text" class="form-control" placeholder="Subject.." style="max-width: 500px;">
					</div>
				</div>
			</div>
			
			<!--  Date And Notification Repeat -->
			<div class="form-group">
				<div class="col-md-12 marginTop10">
					
					<div class="col-sm-3">
						 <div class="input-group">
					      	<div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
					      	<input id="" name="" type="text" class="form-control" placeholder="">
					    </div>						
					</div>		
					<label class="col-sm-1 marginTop5" style="margin-left: -10px; margin-right: -45px;">TO</label>			
					<div class="col-sm-3">
						<div class="input-group">
					      	<div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
					      	<input id="" name="" type="text" class="form-control" placeholder="">
					    </div>						 
					</div>
					
				 	<div class="checkbox">
					  	<label class="marginLeft15">
					  		<input type="checkbox"> All Day
					  	</label>
					  
					   	<label class="marginLeft25">
					  		<input type="checkbox"> Repeat
					  	</label>
				  	</div>

				</div>
			</div>
			
			<div class="form-group">
	      		<div class="col-md-12 marginTop10">
	      			<label for="Where" class="col-sm-2 label_limit marginTop5">Calendar</label>	      			
					<div class="col-sm-6">
						 <input id="formGroupInputSmall" name="" type="text" class="form-control labelField_limit" placeholder="">
					</div>
				</div>
			</div>
			
			<div class="form-group">
	      		<div class="col-md-12 marginTop10">
	      			<label for="Where" class="col-sm-2 label_limit marginTop5">Where</label>	      			
					<div class="col-sm-6">
						 <input id="formGroupInputSmall" name="" type="text" class="form-control labelField_limit" placeholder="">
					</div>
				</div>
			</div>
			
			<div class="form-group">
	      		<div class="col-md-12 marginTop10">
	      			<label for="Where" class="col-sm-2 label_limit marginTop5">Description</label>	      			
					<div class="col-sm-6">
						 <textarea class="form-control labelField_limit" rows="3"></textarea>
					</div>
				</div>
			</div>
      	
      		<div class="col-sm-12"><hr class="marginTop20" /></div>
      		
      		
      		<div class="form-group">
      			<div class="col-md-12">
      				<label for="Where" class="col-sm-2 label_limit marginTop5">Event Color</label>	      		
      				<div class="col-sm-8 marginTop5">
      				
      					<div class="checkbox checkbox-inline marginRightEasing15 checkbox-primary" style="margin-top: 0px;">
							<input id="objcolor_1" name="event_color" type="checkbox" value="#337ab7" class="styled">
						  	<label></label>
						</div>
										  		  
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-info">
					  		<input id="objColor_2" name="event_color" type="checkbox" value="#5bc0de" class="styled">
					  		<label></label>
					  	</div>
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-danger">
					  		<input id="objColor_3" name="event_color" type="checkbox" value="#d9534f" class="styled">
					  		<label></label>
					  	</div>					  
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-warning">
					  		<input id="objColor_4" name="event_color" type="checkbox" value="#f0ad4e" class="styled">
					  		<label></label>
					  	</div>
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-success">
					  		<input id="objColor_4" name="event_color" type="checkbox" value="#5cb85c" class="styled">
					  		<label></label>
					  	</div>	
      		
      					<!-- General -->
						<div class="checkbox checkbox-inline marginRightEasing15 checkbox-lightBlue" style="margin-top: 0px;">
							<input id="objcolor_1" name="event_color" type="checkbox" value="#9fc6e7" class="styled">
						  	<label></label>
						</div>
										  		  
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-darkCyan">
					  		<input id="objColor_2" name="event_color" type="checkbox" value="#5484ed" class="styled">
					  		<label></label>
					  	</div>
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-manuve">
					  		<input id="objColor_3" name="event_color" type="checkbox" value="#a4bdfc" class="styled">
					  		<label></label>
					  	</div>					  
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-teal">
					  		<input id="objColor_4" name="event_color" type="checkbox" value="#46d6db" class="styled">
					  		<label></label>
					  	</div>	
					 	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-olive">
					 		<input id="objColor_5" name="event_color" type="checkbox" value="#7ae7bf" class="styled">
							<label></label>
					  	</div>							  
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-lime">
					  		<input id="objColor_6" name="event_color" type="checkbox" value="#51b749" class="styled">
					  		<label></label>
					  	</div>	
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-yellow">
					  		<input id="objColor_7" name="event_color" type="checkbox" value="#fbd75b" class="styled"></label>		
					  		<label></label>
					  	</div>					  
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-crimson">
					  		<input id="objColor_8" name="event_color" type="checkbox" value="#ffb878" class="styled"></label>
					  		<label></label>
					  	</div>	
					  	<div class="checkbox checkbox-inline marginRightEasing15 checkbox-red">
					  		<input id="objColor_9" name="event_color" type="checkbox" value="#dc2127" class="styled"></label>				
					  		<label></label>
					  	</div>					   
						<div class="checkbox checkbox-inline marginRightEasing15 checkbox-pink">
					  		<input id="objColor_10" name="event_color" type="checkbox" value="#dbadff" class="styled"></label>				
					  		<label></label>
					  	</div>	
						<div class="checkbox checkbox-inline marginRightEasing15 checkbox-gray">
					  		<input id="objColor_11" name="event_color" type="checkbox" value="#e1e1e1" class="styled"></label>				
					  		<label></label>
					  	</div>		
					</div>
      			</div>
      		</div>
      		
      		<div class="form-group">
      			<div class="col-md-12 marginTop10">
      				<label for="Where" class="col-sm-2 label_limit marginTop5">Notifications</label>
      				<div class="col-sm-8" style="margin-left: -15px;">
      					
      					<div class="col-sm-3">
      						<select class="form-control">>
      							<option value="1">Email</option>
      							<option value="3">Pop Up</option>
      						</select>
      					</div>
      					<div class="col-sm-2" style="margin-left: -25px; margin-right: -30px;">
      						<input id="" name="" type="" value="" class="form-control" style="max-width: 70px;">
      					</div>
      					<div class="col-sm-3">
      						<select class="form-control">>
      							<option value="60">minutes</option>
      							<option value="3600">hours</option>
      							<option value="86400">days</option>
      							<option value="604800">weeks</option>
      						</select>
      					</div>
      				</div>
      			</div>
      		</div>
     
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
        <button type="button" class="btn btn-primary">SAVE</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-2 col-md-2">
  	<div class="col-xs-2">
  	
  		<!-- Button trigger modal -->
		<button type="button" class="btn btn-warning btn-sm marginTop55" data-toggle="modal" data-target="#objClndr">CREATE</button>

  	</div>
  	
  </div>
  <div id="calendar" class="col-xs-8 col-md-8"></div>
  <div class="col-xs-2 col-md-2"></div>
</div>

</body>
</html>
