<!-- Menu -->
<div class="container">

<div class="tile-group no-margin no-padding1 clearfix" style="width: 100%;">
	
    <a href="#"><span class="tile-group-title fg-orange" style="font-size: 1.5em; margin-top: -0.2em; font-weight: 200;">Menu<span class="icon-arrow-right-5"></span></span></a>

    <a href="<?php echo site_url('metro/createprofile'); ?>">
        <div class="tile double double-vertical ol-transparent bg-darkGreen" id="applicationprocess">
            <div class="tile-content icon">
                <i class="icon-file" style="font-size: 7em; margin-left: -0.5em;"></i>
                <i class="icon-pencil" style="font-size: 4em;"></i>
            </div>
            <div class="brand">
                <span class="label fg-white">Application Process</span>
            </div>
        </div>
    </a>
    
    <a href="<?php echo site_url('metro/appProgress'); ?>" target="_blank">
        <div class="tile double double-vertical ol-transparent bg-amber" id="applicationprogress">
            <div class="tile-content icon">
                <i class="icon-file" style="font-size: 7em; margin-left: -0.5em;"></i>
                <i class="icon-checkmark" style="font-size: 0.8em; margin-top: -3.2em; margin-left: -4.8em;"></i>
                <i class="icon-list" style="margin-top: -0.5em; margin-left: -0.5em;"></i>
                <i class="icon-loading" style="font-size: 0.8em; margin-top: -1.7em; margin-left: -4.8em;"></i>
            </div>
            <div class="brand">
                <span class="label fg-white">Application Progress</span>
            </div>
        </div>
    </a>

  	<a href="<?php echo site_url('metro/vwDocManagement'); ?>" target="_blank">
        <div class="tile double ol-transparent bg-amber" id="docmanagement">
			<div class="tile-content icon">
				<i class="icon-tab" style="font-size: 3em; margin-top: -0.9em; margin-left: -1.2em;"></i>
        		<i class="icon-copy" style="font-size: 5em; margin-top: -0.5em; margin-left: 0.2em;"></i>
	        </div>
	        <div class="brand">
	        	<span class="label fg-white">Document Management</span>
	        </div>
        </div>
    </a>

   
    
    <!-- bg-darkCyan <i class="icon-download" style="font-size: 4em; margin-top: -0.6em; margin-left: -0.4em;"></i> -->
    <a href="#">
	    <div class="tile ol-transparent wp-bind">
	    	<div class="tile-content icon"></div>
            <div class="brand">
            	<span class="label fg-white"></span>
		    </div>
	    </div>
    </a>
    
    <!--   <?php echo site_url('metro/grid'); ?>  data-hint="MIS Mornitor (Unavailable)" data-hint-position="top"  -->
    <!-- bg-teal  <i class="icon-stats" style="font-size: 3.5em; margin-top: -0.5em; margin-left: -0.3em;"></i>  -->
     <a href="#">
	    <div class="tile ol-transparent wp-bind">
	    	<div class="tile-content icon"></div>
            <div class="tile-status">
                <span class="name"></span>
            </div>
	    </div>
    </a>
    
    <a href="<?php echo site_url('referral_control'); ?>" target="_blank">
        <div id="referral_activity" class="tile double ol-transparent" style="background-color: #0B4C9E;" target="_blank">
            <div class="tile-content icon">
        		<img src="<?php echo base_url('img/TLA.PNG');?>" style="height: 100px; width: 100px; position: absolute; margin-top: -50px; margin-left: 10px;">
	        </div>
	        <div class="brand">
	        	<span class="label fg-white">Referral</span>
	        </div>
        </div>
    </a>
    
    <!-- bg-darkCyan -->
    <a href="#">
        <div class="tile double ol-transparent wp-bind">
        	<div class="tile-content icon">
        		<!-- 
				<i class="icon-phone" style="font-size: 3em; margin-top: -0.9em; margin-left: -1.2em;"></i>
        		<i class="icon-book" style="font-size: 5em; margin-top: -0.5em; margin-left: 0.2em;"></i>
        		<i class="icon-list" style="font-size: 1.2em; margin-top: -2.4em; margin-left: 0.4em;"></i>
        		<i class="icon-list" style="font-size: 1.2em; margin-top: -2.4em; margin-left: 2.4em;"></i>
        		-->
	        </div>
	        <div class="brand">
	        	<span class="label fg-white"></span></span>
	        </div>
        </div>
    </a>

</div>

<!-- Report -->
<div class="tile-group no-margin no-padding1 clearfix" style="width: 100%;">
    <a href="#"><span class="tile-group-title fg-orange" style="font-size: 1.5em; margin-top: -0.2em; font-weight: 200;">Report<span class="icon-arrow-right-5"></span></span></a>

    <a href="<?php echo site_url('metro/dashboard_frame');?>" target="_blank">
        <div class="tile double double-vertical ol-transparent bg-yellow" id="Whiteboard">
            <div class="tile-content icon">
                <i class="icon-laptop" style="font-size:9em; margin-left: -0.5em;"></i>
                <i class="icon-bars" style="font-size:4em; margin-top: -0.5em; margin-left: -0.5em;"></i>
            </div>
            <div class="brand">
            	<span class="label fg-white" style="font-size: 1em;">Whiteboard <small>(Table of branch)</small></span>
		    </div>
        </div>
    </a>
    
    <?php 
    	
   		$authoriy_mangement = $this->config->item('Administrator');
    	if($session_data['position'] === 'Branch Admin') {
    		echo '
			 <a href="#">
		        <div id="kpi_report" class="tile double double-vertical ol-transparent bg-darkCyan wp-bind">
		        	<div class="tile-content icon">
		        		<i class="icon-laptop" style="font-size:9em; margin-left: -0.5em;"></i>
		                <i class="icon-stats-up" style="font-size:4em; margin-top: -0.5em; margin-left: -0.5em;"></i>
		        	</div>
		        	<div class="brand">
		        		<span class="label fg-white" style="font-size: 1em;">KPI</span>
					</div>
		        </div>
		    </a>';
    		
    	} else {
    		
    		if(in_array($session_data['emp_id'], $authoriy_mangement)):
    			$set_editor = '&editor='.md5('true').'&permission='.md5('true');
    		else:
    			$set_editor = '&editor='.md5('false').'&permission='.md5('false');
    		endif;
    		
    		echo '
			 <a href="'.site_url('report/gridDataList').'?_='.md5(date('s')).'&rel='.$session_data["emp_id"].$set_editor.'" target="_blank, _self">
		        <div id="kpi_report" class="tile double double-vertical ol-transparent bg-darkCyan">
		        	<div class="tile-content icon">
		        		<i class="icon-laptop" style="font-size:9em; margin-left: -0.5em;"></i>
		                <i class="icon-stats-up" style="font-size:4em; margin-top: -0.5em; margin-left: -0.5em;"></i>
		        	</div>
		        	<div class="brand">
		        		<span class="label fg-white" style="font-size: 1em;">KPI</span>
					</div>
		        </div>
		    </a>';
   
    	}
    
    ?>

    <a href="#">
    	<div class="tile double ol-transparent bg-darkOrange wp-bind" id="dailyreport">
    		<div class="tile-content icon">         	
                <i class="icon-dashboard" style="font-size: 5em; margin-left: 0.3em;"></i>
            </div>
              <div class="brand">
            	<span class="label fg-white">Daily Report</span>
		    </div>
    	</div>    
    </a>    
    
    <a href="#" id="referral">
    <div class="tile ol-transparent bg-orange wp-bind" id="Referral">
    	<div class="tile-content icon">
        	<i class="icon-accessibility" style="font-size: 5em; margin-top: -0.5em; margin-left: -0.5em;"></i>
        </div>
        <div class="brand">
        	<span class="label fg-white">CRM</span>
        </div> 
    </div>
    </a>

    <a href="#">
	    <div class="tile ol-transparent bg-gray wp-bind" data-hint="REPORT|Evalute staff (During 90 Day)" data-hint-position="top" id="evs">
	    	<div class="tile-content icon">
        		<i class="icon-user-3" style="font-size: 5em; margin-top: -0.5em; margin-left: -0.5em;"></i>
	        </div>
	        <div class="brand">
	        	<span class="label fg-white">EVS</span>
	        </div>
	    </div>
    </a>

	<a href="#">
	    <div class="tile double ol-transparent bg-lime wp-bind" id="monthlyreport">
	    	<div class="tile-content icon">         	
                <i class="icon-stats-up" style="font-size: 5em; margin-left: 0.3em;"></i>
            </div>
              <div class="brand">
            	<span class="label fg-white">Monthly Report</span>
		    </div>
	    </div>
    </a>
    
    <!-- bg-cyan -->
    
    <a href="#" id="customersource">
    <div class="tile ol-transparent bg-darkCyan wp-bind" data-hint="REPORT|Source of Customer" data-hint-position="top" id="SOC">
    	<div class="tile-content icon">
        	<i class="icon-pie" style="font-size: 5em; margin-top: -0.5em; margin-left: -0.5em;"></i>
        </div>
        <div class="brand">
        	<span class="label fg-white">SOC</span>
        </div>
    </div>
    </a>
    
    <a href="#" id="atoca">
    <div class="tile ol-transparent bg-teal wp-bind" id="a2ca">
    	<div class="tile-content icon">
        	<i class="icon-bars" style="font-size: 5em; margin-top: -0.6em; margin-left: -0.5em;"></i>
        </div>
        <div class="tile-status">
        	<span class="name">A2CA</span>
        </div>
    </div>
    </a>
     
   
</div>
</div>

<!--
<div id="feedback" class="row">
	
	<div class="span5">
	<span class="color color_tab"></span>
    <div class="section">
    
        <h2 style="font-size: 1.2em;"><span class="arrow up"></span>Feedback</h2>
        
        <p class="message">Please include your information.</p>
        
            <div class="tab-control" data-role="tab-control" data-effect="fade[slide]">
			    <ul class="tabs">
				    <li class="active"><a href="#_page_1"><i class="fa fa-lightbulb-o on-left"></i> Idea</a></li>
				    <li><a href="#_page_2"><i class="fa fa-exclamation-circle on-left"></i> Problem</a></li>
				    <li><a href="#_page_3"><i class="fa fa-question-circle on-left"></i> Question</a></li>
			    </ul>
			     
			    <div class="frames">
				    <div class="frame" id="_page_1">
				    	<div class="input-control select">
					    	<label>Topic</label>
					    	<select name="">
					    		<option value=""></option>
					    		<option value=""></option>
					    		<option value=""></option>
					    		<option value=""></option>
					    	</select>
				    	</div>
				    	<div class="input-control textarea">
					    	<label>Information</label>
					    	<textarea rows="3" cols="30"></textarea>
				    	</div>
				    	<button class="button">Submit</button>
				    </div>
				    <div class="frame" id="_page_2">
				    	<div class="input-control select">
					    	<label>Topic</label>
					    	<select name="">
					    		<option value=""></option>
					    		<option value=""></option>
					    		<option value=""></option>
					    		<option value=""></option>
					    	</select>
				    	</div>
				    	<div class="input-control textarea">
					    	<label>Comments</label>
					    	<textarea rows="2"></textarea>
				    	</div>
				    	<button class="button">Submit</button>
				    </div>
				    <div class="frame" id="_page_3">
				    	<div class="input-control textarea">
					    	<label>Question</label>
					    	<textarea rows="8" cols="30"></textarea>
				    	</div>
				    	<button class="button">Submit</button>
				    </div>
			    </div>
			</div>
        
        
       		
    </div>
    </div>
   
</div>
-->
<script>

function check_referAuthority() {
	var not = $.Notify({ content: "ท่านไม่มีสิทธิ์ในการใช้งานส่วนนี้", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
	not.close(7000);
}

</script>
