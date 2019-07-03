<style>

	.jqstooltip {
	    -webkit-box-sizing: content-box;
	    -moz-box-sizing: content-box;
	    box-sizing: content-box;
	}
	
	.col-container {
		display: inline;
		float: left;		
	}
	
	.col-header { 
		display: block; 
		text-align: center; 
		font-weight: bold;
	}	
	
	.col-subspan-xs {
		float: left;
		width: 110px;
		max-width: 110px;		
	}
	
	.col-subspan-md {
		float: left;
		width: 140px;
		max-width: 140px;		
	}
	
	.col-subspan {
		float: left;
		width: 125px;
		max-width: 125px;		
	}
	
	.col-subspan-minfix {
		float: left;
		min-width: 125px !important;
		max-width: 125px !important;
	} 

	.col-subspan.spanhalf { 
		float: left;
		width: 62px;
		max-width: 62px;
	}
	
	.col-subspan.spanmini { 
		float: left;
		width: 41.5px;
		max-width: 41.5px;
	}
	
	.col-subspan.spanxs { 
		float: left;
		width: 31px;
		max-width: 31px;
	}
	
	.col-subspan-height {
		height: 125px !important;
		max-height: 125px;	
	}
	
	.col-subspanhalf-height,
	.col-subspan-minfix.col-subspanhalf-height {
		height: 62px;
		max-height: 62px;	
	}
	
	.col-subspanhalf-heightmini {
		min-height: 42px;
		max-height: 42px;	
	}
	
	.col-divider {
		float: left;
		margin-top: 4px;
		padding: 7px 0;
	    line-height: 15px;
	    width: 1px !important;
	    border-left: 1px #FFF solid;
	    opacity: 1;
	    position: relative;
	}
	
	.col-hspan20 { height: 20px; max-height: 20px; }
	.col-hspan40 { height: 40px; max-height: 40px; }
	.col-hspan60 { height: 60px; max-height: 60px; }
	.col-hspan125 { min-height: 125px; max-height: 125px; }
	
	.col-span124 { max-width: 124px; min-width: 124px; }
	.col-span90 { width: 100% !important; }
	
	.label_subtitle {		
		max-height: 10px; 
		font-size: 0.7em !important; 
		font-weight: bold !important;
		color: rgba(0, 0, 0, .4);
		max-width: 19px !important;
	}
	
	.label {
		font-size: 0.85em !important;
		padding: 3px;
	    font-weight: bold;
	    line-height: 1;
	    white-space: nowrap;
	    vertical-align: baseline;
	}

	.text_bold { font-weight: bold !important; }

	.bg-pinkPastel { background-color: #ed8885 !important;  }
	.bg-greenPastel { background-color: #62d185 !important;  }
	.bg-yellowLight { background-color: #E4AC04 !important; } 
	.bg-pickLight { background-color: #F2465C; }
	.bg-redPinkLight { background-color: #8C4B4F; }
	.bg-mauveLight { background-color: #803F69; }
	.bg-blueDeep {  background-color: #0B4C9E; }
	.brand.brand-custom { position: static !important; bottom: inherit;}
	
	/* Overide */
	tspan {
		-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	    text-anchor: middle;
	    font-family: 'Segoe UI_','Open Sans',Verdana,Arial,Helvetica,sans-serif !important;
		font-weight: normal;
	    fill-opacity: 1;
	}
	
	text[y="29.0625"] > tspan,
	text[y="9.090909090909092"] > tspan {
		font-weight: bold;
		font-size: 10px;
	}
	
	text[y="85.58823529411765"] > tspan {
			font-size: 2.1rem;
		    line-height: 2.5rem;
		    letter-spacing: .01em;
	}
		
	text[x="12.25"][y="64.05405405405405"] > tspan,
	text[x="87.75"][y="64.05405405405405"] > tspan { display: none; }
	
	table#refer_subdetails { border: 2px solid rgba(255, 255, 255, 1) !important; }
	table#refer_subdetails > tbody td { 
		border: 2px solid rgba(255, 255, 255, 1) !important; 
		padding: 5px 0 0 0;
		font-size: 10px; 
		text-align: center;
	}
	
	span.fa { 
		font-family: FontAwesome !important; 
	}
	
	ti[class^="ti"] { 
		font-family: themify !important; 
	}
	
	body { margin:50px; }
	.metro .slider .marker { height: 7px; width: 7px; background-color: rgba(255, 255, 255, 0.3) }
	.metro .slider>.hint {
	    background: rgba(0, 0, 0, 0.7);
	    border: 1px solid #FFF;
	    color: #FFF;
	    min-width: 30px;
	    font-size: 0.8em;
	    margin-left: 10px;
	}
	
	#sb_slider > .icon-arrow-left-4:before,
	#a2ca_slider > .icon-arrow-left-4:before,
	#sb_slider_auth > .icon-arrow-left-4:before,
	#a2ca_slider_auth > .icon-arrow-left-4:before { position: absolute !important; margin-left: -7px; margin-top: -4px; }
	
	div.modal { z-index: 210500000 !important; }
	table#collectionclass_overview td { padding: 6px !important; font-size: 13px !important; }
	table#collect_flag td { padding: 5px !important; }
	
	.brand_ribber {
	    -ms-transform: rotate(45deg); /* IE 9 */
	    -webkit-transform: rotate(45deg); /* Chrome, Safari, Opera */
	    transform: rotate(-45deg);
	    color: #FFFFFF;
	    margin-top: 35%;
	    margin-left: 5px;
	    text-align: center;
	    border-top: 1px solid #FFFFFF;
	    border-bottom: 1px solid #FFFFFF;
	    padding-bottom: 5px;
	    opacity: 0.8;
	}
	
	.brand_ribber h3, .brand_ribber h5 { color: #FFFFFF; }
	table.fixed { table-layout:fixed; }
	table.fixed td { overflow: hidden; }
	
	.traffic_render { 
		font-size: 0.7em;
	    vertical-align: top;
	    padding-top: 1px;
	}
	#destribution_box > tbody td {
		line-height: 12px;
		padding: 1px !important;
		border-right: 1px solid white;
		background-color: #825a2c !important;
	}
	
	.border-top-none { border-top: 0 !important; }
	.border-left-none { border-left: 0 !important; }
	.border-right-none { border-right: 0 !important; }
	.border-bottom-none { border-right: 0 !important; }
	
	.border-top { border-top: 1px solid white !important; }
	.border-left { border-left: 1px solid white !important; }
	.border-right { border-right: 1px solid white !important; }
	.border-bottom { border-right: 1px solid white !important; }
	
	div.hint-title { font-size: 1em !important; }
	
	.btn_circle {
		padding: 5px;
		max-width: 30px;
		min-width: 30px;
		border-radius: 50%;
		background-color: #555;
		color: #FFF;
		text-align: center;
		float: left;
		cursor: pointer;
		-webkit-touch-callout: none;
	    -webkit-user-select: none; 
	    -khtml-user-select: none; 
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	    font-size: 0.8em;
	}
	
	.btn_circle.active {
		background-color: #1b6eae;
	}
	
	.btn_circle:hover {
		opacity: .8;
	}
	
</style>

<!-- Menu -->
<div class="container">

<div style="margin-left: 100px">
	<span><img src="<?php echo base_url('img/line_left.png');?>" style="height: 40px; position: absolute; left: 170px; top: -10px;"></span>
	<p style="font-weight: bold; text-align: center; padding-right: 106px; font-size: 1.3em; margin-top: 90px; " class="th_charmonman animated fadeIn">พระบรมราโชวาทของพระบาทสมเด็จพระปรมินทรมหาภูมิพลอดุลยเดชฯ</p>
	<p style="font-weight: bold; text-align: center; font-size: 0.95em; margin-top: 15px; margin-bottom: -35px; line-height: 2.5; margin-left: -120px; min-width: 1200px;" class="th_charmonman animated zoomIn"><?php echo $royalGuidance['data'][0]['RoyalGuidance']; ?></p>
	<span><img src="<?php echo base_url('img/line_right.png');?>" style="height: 40px; position: absolute; right: 180px; top: -10px;"></span>
</div>
	
<div class="tile-group no-margin no-padding1 clearfix" style="width: 100%; margin-left: -70px !important; margin-top: 10px !important">

    <div class="hide" style="position: absolute; min-height: 550px; right: -40px; border: 1px solid #D1D1D1; width: 140px; background: #bcb4b4;"></div>
    
    	<?php 
    	if(in_array($session_data['emp_id'], $this->config->item('Administrator'))) {	
    	?> 
    	<div id="tile_ctrl" style="position: absolute; top: 10px; left: 0; width: 140px; display: inline;">
    		<a href="<?php echo site_url('metro'); ?>">
    			<div id="tile_lb" class="btn_circle active" data-dapart="LB" style="margin-right: 5px;">LB</div>
    		</a>
    		<a href="<?php echo site_url('metro/bkk'); ?>" >
    			<div id="tile_bkk" class="btn_circle" data-dapart="BKK" style="margin-right: 5px;">BKK</div>
    		</a>
    	</div>
    	<?php } ?>

		<div id="app_progress_container" class="tile double animated fadeInDown">
			<div class="tile-content text-center fg-white">
	            <div class="col-subspan">
					<div class="col-subspan bg-darkCyan fg-white" style="border-right: 1px solid #FFF; min-height: 120px;">
						<?php 
							$pci_create_attr= '';
							if(in_array($session_data['role'], array('adminbr_role', 'admin_role'))):
								$pci_create_attr = 'href="#" class="fg-white"';
							else:
								$pci_create_attr = 'href="'.site_url('metro/createprofile').'" class="fg-white" target="_blank"';
							endif;
						?>
						<a <?php echo $pci_create_attr; ?>>
							<div class="col-subspan spanhalf bg-darkCyan text-center"style="min-height: 60px; max-height: 60px; border-bottom: 1px solid #FFF;">
								<div id="icon_pci" class="paddingTop10 hide"><span class="fa fa-id-card-o fa-2x" style="font-size: 1.5em; margin-top: 5px;"></span></div>
								<div id="pci_label" style="margin-top: 14px; font-size: 0.7em;">PCI INPUT</div>
							</div>
						</a>
						<a href="<?php echo site_url('metro/appProgress'); ?>" class="fg-white" target="_blank">
							<div class="col-subspan spanhalf bg-darkCyan text-center" style="max-width: 61px; min-height: 60px; max-height: 60px; border-bottom: 1px solid #FFF; border-left: 1px solid #FFF;">
								<div id="icon_apppro" class="paddingTop10 hide"><span class="fa fa-share-alt fa-2x" style="font-size: 1.5em; margin-top: 5px;"></span></div>
								<div id="apppro_label" style="margin-top: 14px; font-size: 0.7em;">PROGRESS</div>
							</div>
						</a>
						<div class="col-subspan bg-darkOrange fg-white" style="min-height: 65px; border-right: 1px solid #FFF;">
							<div id="field_mthlabel" style="position: absolute; left: 108px; font-size: 60%;">ALL</div>
						    <div id="field_total" class="col-subspan subheader marginTop5 text-center fg-white animated fadeIn" style="margin-top: 8px;"></div>
						    <div id="field_visit" class="col-subspan text-center" style="font-size: 0.7em; margin-top: 3px;"></div>
						    <div id="field_refer" class="col-subspan text-center " style="font-size: 0.7em; margin-top: -3px;"></div>
						</div>
					</div>	
				</div>	
				<div class="col-subspan">
					<div class="col-subspan spanhalf bg-darkCyan text-center" style="min-height: 60px; max-height: 60px; border-bottom: 1px solid #FFF;"> 
						<div class="interest_per subheader paddingTop10 fg-white" style="font-size: 1.3em; padding-top: 11px;"></div>
						<div class="text-center" style="font-size: 0.7em; margin-top: 2px;">INTERESTED</div>
					</div>
					<div class="col-subspan spanhalf bg-darkCyan text-center" style="min-height: 60px; max-height: 60px; border-bottom: 1px solid #FFF;  border-left: 1px solid #FFF;">
						<div class="hightpro_per subheader paddingTop10 fg-white" style="font-size: 1.3em; padding-top: 11px;"></div>
						<div class="text-center" style="font-size: 0.7em; margin-top: 2px;">HIGH POT.</div>
					</div>
					<div class="col-subspan bg-darkOrange" style="min-height: 65px; max-width: 124px;">				
						<div id="field_mthlabel" style="position: absolute; right: 3px; font-size: 60%;">MTH</div>
		             	<div id="field_actual" class="col-subspan subheader marginTop5 text-center fg-white animated fadeIn" style="margin-top: 8px;"></div>
	             		<div id="field_target" class="col-subspan text-center marginTop10" style="font-size: 0.7em; margin-top: 3px;"></div>
	             		<div id="field_achieve" class="col-subspan text-center" style="font-size: 0.7em; margin-top: -3px;"></div>
	             	</div>
				</div>          	             	        
	        </div>
		</div>
		
		<div class="tile bg-amber animated fadeInDown">
			<div class="tile-content fg-white">
	             <div class="col-subspan"  style="border-left: 1px solid #FFF;">
	             
	          	    <div class="brand brand-custom text-center padding_none" style="font-size: 0.8em; margin-top: -5px; padding-top: 10px; max-height: 20px !important; background-color: rgba(130, 90, 44, .7) !important; !important;">
	          	    	<a href="<?php echo site_url('metro/fnReconcileNCB'); ?>" class="fg-white" target="_blank">
	          	    		<div class="text-left paddingLeft5" style="width: 92px; max-width: 88px; min-height: 29px; padding-top: 8px;"><span class="fa fa-eye fg-white text-left" style="font-size: 1.2em;"></span> NCB Consent</div>
	          	    		<div id="ncbconsent_total" style="width: 32px; padding-top: 8px; min-height: 29px; float: right; margin-top: -29px; padding-right: 3px;"></div>
	          	    	</a>
	          	    </div>
	          	   
	          	    <div class="col-subspan" style="min-height: 91px; margin-top: 5px;">
	          	  		<div id="ncbconsent_incompleted" class="col-subspan animated fadeIn" style="font-size: 0.74em; padding-left: 5px; margin-top: -5px; margin-bottom: 5px;">Loading...</div>
	          	  		<div class="col-subspan text-center" style="margin-top: -2px;">
	          	  		 	<div id="ncb_consent_chart" class="col-subspan" style="min-width: 105px; max-width: 125px; margin-top: 15px; margin-left: 3px;"></div>
	          	  		</div>
	          	  	</div>
	          	  	
	          	  	<div class="col-subspan fg-white" style="margin-top: -15px; margin-left: -5px;">
						<div class="col-subspan spanxs ncb_labels hide" style="max-height: 13px; font-size: 0.8em; max-width: 18px !important; margin-left: 24px; color: rgba(255, 255, 255, 1);"><small>&le;3</small></div>
					    <div class="col-subspan spanxs ncb_labels hide" style="max-height: 13px; font-size: 0.8em; max-width: 18px !important; margin-left: 3px; color: rgba(255, 255, 255, 1);"><small>&le;5</small></div>
					    <div class="col-subspan spanxs ncb_labels hide" style="max-height: 13px; font-size: 0.8em; max-width: 18px !important; margin-left: 1px; color: rgba(255, 255, 255, 1);"><small>&le;7</small></div>
					    <div class="col-subspan spanxs ncb_labels hide" style="max-height: 13px; font-size: 0.8em; max-width: 18px !important; margin-left: 2px; color: rgba(255, 255, 255, 1);"><small>&le;9</small></div>
					    <div class="col-subspan spanxs ncb_labels hide" style="max-height: 13px; font-size: 0.8em; max-width: 18px !important; margin-left: 1px; color: rgba(255, 255, 255, 1);"><small>&ge;10</small></div>
					</div>	
	          	  	
	          	    <div class="col-subspan spanxs" style="position: absolute; margin-top: 42px; margin-left: -35px; min-width: 80px; color: rgba(255, 255, 255, 1); transform: rotate(270deg);">
	          	  		<small class="animated fadeIn ncb_labels hide" style="font-size: 70%;">NCB Aging 2OP</small>
	          	  	</div>
	          	  	
	        	</div>                
	        </div>
		</div>
		
		<div class="tile bg-amber animated fadeInDown">
			<div class="tile-content fg-white">
	            <div class="col-subspan" style="border-right: 1px solid #FFF;">   
		          	<div class="brand brand-custom text-center padding_none" style="font-size: 0.8em; margin-top: -5px; padding-top: 10px; max-height: 20px !important; background-color: rgba(130, 90, 44, .7) !important; !important;">
	          	    	<a href="<?php echo site_url('reconcile/vwAppManagement').'?filter=reconcile'; ?>" class="fg-white" target="_blank">
		          	    	<div class="text-left paddingLeft5" style="width: 92px; max-width: 88px; min-height: 29px; padding-top: 8px;">
		          	    		<ti class="ti-check-box text-left" style="font-size: 1.2em; color: #FFF;"></ti>
		          	    		<span style="font-size: 1.1em;">Reconcile</span>
		          	    	</div>
		          	    	<div id="reconcile_total" style="width: 32px; padding-top: 8px; min-height: 29px; float: right; margin-top: -29px; padding-right: 3px;"></div>
	          	    	</a>
	          	    </div>
	          	  	<div class="col-subspan" style="min-height: 91px; margin-top: 5px;">
	          	  		<div id="incompleted_perate" class="col-subspan animated fadeIn" style="font-size: 0.74em; padding-left: 5px; margin-top: -5px; margin-bottom: 5px;">Loading...</div>
	          	  		<div class="col-subspan" style="margin-left: -2px; padding: 2px 5px;">
	          	  		 	<canvas id="reconcile_consent_chart" class="col-subspan" style="min-height: 70px;"></canvas>
	          	  		 </div>
	          	  	</div>        
	          	 </div>          	   
	        </div>
		</div>
	
		<!-- Below front Zone -->
		<!-- data-role="live-tile" data-effect="slideRight" data-easing="easeInSine"  -->
		<div class="tile live double animated fadeInDown" data-role="live-tile" data-effect="slideUpDown" data-easing="easeInSine" style="position: absolute; margin-top: 130px;">
			<div class="tile-content text-center fg-white">	       
	            <div class="col-subspan">
					<div class="col-subspan fg-white bg-gray" style="border-right: 1px solid #FFF; min-height: 120px; ">
						<a href="<?php echo site_url('defend_control/defenddashboard_v2'); ?>" class="fg-white" target="_blank">
							<div class="col-subspan spanhalf bg-gray text-center"style="max-width: 61px; min-height: 60px; max-height: 60px; border-bottom: 1px solid #FFF;">
								<div class="paddingTop10"><span class="fa fa fa-shield fa-2x"></span></div>
								<div style="font-size: 0.7em;">DEFEND</div>
							</div>
						</a>
						<div class="col-subspan spanhalf text-center" style="min-height: 60px; max-height: 60px; border-bottom: 1px solid #FFF; border-left: 1px solid #FFF;">
							<div class="tile live col-subspan spanhalf bg-gray" style="min-height: 60px; max-height: 60px; border-bottom: 1px solid #FFF;">
								<div class="tile-content col-subspan spanhalf" style="min-height: 60px; max-height: 60px;">
									<div class="col-subspan spanhalf text-right def_newAch hide" style="font-size: 0.5em; margin-left: -3px; position: absolute;">&nbsp;</div>
									<div class="col-subspan spanhalf subheader def_newVal1 marginTop10 text-center fg-white animated fadeIn">0</div>
							    	<div class="col-subspan spanhalf text-center" style="font-size: 0.7em; margin-top: 5px;">DRAFT</div>
								</div>
							</div>					
						</div>
						<div class="col-subspan bg-mauveLight fg-white" style="min-height: 65px; border-left: 1px solid #FFF; border-right: 1px solid #FFF;">
							<div id="defend_completedActual" class="col-subspan subheader marginTop5 text-center fg-white animated fadeIn">0</div>
						    <div id="defend_completedPercent" class="col-subspan text-center" style="font-size: 0.7em; margin-top: 5px;">CA PROCESS 0%</div>
						</div>	
					</div>					
	            </div>    
	            <div class="col-subspan bg-mauveLight" style="min-height: 125px;">
					<div class="col-subspan">	        			 	
        			 	<div class="col-subspan text-left" style="font-size: 0.8em; margin-left: 5px;">
        			 		<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_label0 text-center" style="margin-top: 3px; margin-left: -5px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">(%)</span>
		          			<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_label1 text-center" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1);  font-size: 0.8em !important;">0</span>
					   		<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_label2" style="margin-top: 3px; margin-left: 5px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					   		<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_label3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					   		<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_label4" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					   		<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_label5" style="margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		          		</div>		          		
		          	  	<div class="col-subspan text-left" style="font-size: 0.8em; margin-left: 5px;">
		          	  		<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_accu_label1 text-center" style="margin-top: 3px; margin-left: 14px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_accu_label2" style="margin-top: 3px; margin-left: 5px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_accu_label3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_accu_label4" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown cmpt_accu_label5" style="margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		          	  	</div>		          	  	
		          	  	<div class="col-subspan padding_none" style="min-height: 75px; margin-top: 0px; margin-left: 5px;">
		          			<span id="defend_consent_chartline" class="col-subspan padding_none" style="margin-top: 14px;"></span>
		          		</div>		          		
		          		<div class="col-subspan fg-white" style="margin-top: 15px; margin-left: 0px; position: absolute; bottom: 10px;">
							<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 20px;"><small>E</small></div>
			          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 5px;"><small>C</small></div>
			          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 5px;"><small>N</small></div>
			          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 5px;"><small>S</small></div>
			          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 10px !important; margin-left: 7px;"><small>I</small></div>
						</div>				    
				    	<div class="col-subspan spanxs" style="position: absolute; margin-top: 65px; margin-left: -56px; min-width: 125px; transform: rotate(270deg);">
		          	  		<span class="defend_consent_label" style="font-size: 0.7em; min-width: 125px; color: rgba(255, 255, 255, 1);"></span>
			          	 </div>						
        			 </div>
	            </div>     
	        </div>
	        <div class="tile-content text-center fg-white">	       
	            <div class="col-subspan bg-green">
					<a href="<?php echo site_url('defend_control/defenddashboard_v2'); ?>" class="fg-white" target="_blank">
						<div class="col-subspan spanhalf bg-gray text-center"style="min-height: 60px; max-height: 60px; border-bottom: 1px solid #FFF;">
							<div class="paddingTop10"><span class="fa fa fa-shield fa-2x"></span></div>
							<div style="font-size: 0.7em;">DEFEND</div>
						</div>
					</a>
					<div class="col-subspan spanhalf text-center" style="min-height: 60px; max-height: 60px; border-bottom: 1px solid #FFF; border-left: 1px solid #FFF;">
						<div class="tile live col-subspan spanhalf bg-gray" style="min-height: 60px; max-height: 60px; border-bottom: 1px solid #FFF;  border-right: 1px solid #FFF;">
							<div class="tile-content col-subspan spanhalf" style="min-height: 60px; max-height: 60px;">
								<div class="col-subspan spanhalf def_newAch text-right hide" style="font-size: 0.5em; margin-left: -3px; position: absolute;">&nbsp;</div>
								<div class="col-subspan spanhalf subheader def_newVal2 marginTop10 text-center fg-white animated fadeIn">0</div>
						    	<div class="col-subspan spanhalf text-center" style="font-size: 0.7em; margin-top: 5px;">RETURN</div>
							</div>
						</div>					
					</div>	
					<div class="col-subspan bg-green fg-white" style="min-height: 65px; border-left: 1px solid #FFF; border-right: 1px solid #FFF;">
						<div id="defend_usageActual" class="col-subspan subheader marginTop5 text-center fg-white animated fadeIn">0</div>
						<div id="defend_usagedPercent" class="col-subspan text-center" style="font-size: 0.7em; margin-top: 5px;">RM PROCESS</div>
					</div>	
	            </div>  
	            
	            <div class="col-subspan bg-green"  style="min-height: 125px;">
					<div class="col-subspan">        		 	
        			 	<div class="col-subspan text-left" style="position: absolute; margin-top: 0px; font-size: 0.8em;">
        			 		<span class="col-subspan spanxs label_subtitle animated fadeInDown defendLabelAt_0 text-center" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1);; font-size: 0.8em !important;">(%)</span>
		          	  		<span class="col-subspan spanxs label_subtitle animated fadeInDown defendLabelAt_1 text-center" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown defendLabelAt_2" style="margin-top: 3px; margin-left: 3px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown defendLabelAt_3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown defendLabelAt_4" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown defendLabelAt_5" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		          	  	</div>          	  	
		          	  	<div class="col-subspan text-left" style="position: absolute; font-size: 0.8em; margin-top: 13px; margin-left: 0px;">
		          	  		<span class="col-subspan spanxs label_subtitle animated fadeInDown defendActualLabel0 text-center" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">&nbsp;</span>
		          	  		<span class="col-subspan spanxs label_subtitle animated fadeInDown defendActualLabel1 text-center" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown defendActualLabel2" style="margin-top: 3px; margin-left: 3px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown defendActualLabel3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown defendActualLabel4" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
					    	<span class="col-subspan spanxs label_subtitle animated fadeInDown defendActualLabel5" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		          	  	</div>
		          	  	<div class="col-subspan padding_none" style="margin-top: 10px; margin-left: 3px;">
		          	  		<span id="defend_countanda2ca_chart" class="col-subspan padding_none" style="margin-top: 30px;"></span>
		          		</div>
		          		<div class="col-subspan fg-white" style="margin-top: 15px; margin-left: 0px; position: absolute; bottom: 10px;">
							<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 20px;"><small>E</small></div>
			          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 3px;"><small>C</small></div>
			          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 5px;"><small>N</small></div>
			          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 5px;"><small>S</small></div>
			          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 10px !important; margin-left: 7px;"><small>I</small></div>
						</div>		
						<div class="col-subspan spanxs" style="position: absolute; margin-top: 65px; margin-left: -57px; min-width: 125px; transform: rotate(270deg);">
		          	  		<span class="defend_countanda2ca_label" style="font-size: 0.7em; letter-spacing: 0.5px; min-width: 125px; color: rgba(255, 255, 255, 1);"></span>
		          	  	</div>	
        			</div>
	            </div>     
	        </div>
		</div>
			
		<div class="tile bg-amber animated fadeInDown" style="position: absolute; margin-top: 130px; margin-left: 260px;">
			<div class="tile-content text-center fg-white">
	            <div class="col-subspan fg-white" style="min-height: 125px; border-right: 1px solid #FFF;">
	          	  	<div class="brand brand-custom text-center padding_none" style="font-size: 0.8em; margin-top: -5px; padding-top: 10px; max-height: 20px !important; background-color: rgba(130, 90, 44, .7) !important; !important;">
	          	    	<a href="<?php echo site_url('reconcile/vwAppManagement').'?filter=missingdoc'; ?>" class="fg-white" target="_blank">
		          	    	<div class="text-left paddingLeft5" style="width: 92px; max-width: 88px; min-height: 29px; padding-top: 8px;">
		          	    		<i class=" icon-copy fg-white text-left" style="font-size: 1.1em;"></i> DOC Missing
		          	    	</div>
		          	    	<div id="missing_total" style="width: 32px; padding-top: 8px; min-height: 29px; float: right; margin-top: -29px; padding-right: 3px;"></div>
		          	    </a>
	          	    </div>
	          	  	<div class="col-subspan">
	          	  		<div id="from_boxload" style="font-size: 0.7em; padding-left: 5px; margin-top: 0px; float: left;">Loading...</div>
	          	  		<div class="col-subspan text-center" style="height: 45.5px; position: relative;">
	          	  			<div id="fromrm_val" class="col-subspan hide" style="margin-top: -1px;"><h4 class="fg-white">0</h4></div>
	          	  			<div id="fromrm_ach" class="col-subspan hide" style="font-size: 0.8em; margin-top: 0px;">FROM RM (0%)</div>
	          	  			<div id="fromrm_mainborrower" class="col-subspan hide" style="font-size: 10px; bottom: 1px; position: absolute;">
	          	  				Borrower 0 (0%)
	          	  			</div>
	          	  		</div>
	          	  		<div id="fromca_container" class="col-subspan text-center" style="height: 45.5px; position: relative;">
	          	  			<div id="fromca_val" class="col-subspan hide" style="margin-top: 2px;"><h4 class="fg-white">0</h4></div>
	          	  			<div id="fromca_ach" class="col-subspan hide" style="font-size: 0.8em; margin-top: 0px;">FROM CA (0%)</div>
	          	  			<div id="fromca_mainborrower" class="col-subspan hide" style="font-size: 10px; bottom: -4px; position: absolute;">
	          	  				Borrower 0 (0%)
	          	  			</div>
	          	  		</div>
	          	  	</div>
				</div>                    
	        </div>
		</div>
		
		<div class="tile bg-amber animated fadeInDown" style="position: absolute; margin-top: 130px; margin-left: 390px;">
			<div class="tile-content text-center fg-white">
	            <div class="col-subspan fg-white" style="min-height: 125px; border-left: 1px solid #FFF;">
						<div class="brand brand-custom text-center padding_none" style="font-size: 0.8em; margin-top: -5px; padding-top: 10px; max-height: 20px !important; background-color: rgba(130, 90, 44, .7) !important; !important;">
		          	    <a href="<?php echo site_url('reconcile/vwAppManagement').'?filter=returndoc'; ?>" class="fg-white" target="_blank">
		          	    	<div class="text-left paddingLeft5" style="width: 92px; max-width: 88px; min-height: 29px; padding-top: 8px;">
		          	    		<ti class="ti-back-left fg-white text-left" style="font-size: 1.2em;"></ti> DOC Return
		          	    	</div>
		          	    	<div id="return_total" style="width: 32px; padding-top: 8px; min-height: 29px; float: right; margin-top: -29px; padding-right: 3px;"></div>
		          	    </a>
	          	    </div>
	          	  	<div class="col-subspan text-center">
	          	  		<div id="return_boxload" style="font-size: 0.7em; padding-left: 5px; margin-top: 0px; float: left;">Loading...</div>
		          		<div id="ho2lb_label" class="col-subspan text-left hide" style="font-size: 0.74em; padding-left: 5px; margin-top: 0px; margin-bottom: 5px;">Mth HO2LB 0 (0%)</div>
	
		          		<div id="returndoc_consent_chart" class="col-subspan marginTop5" style="margin-left: -3px;"></div>
		          		
		          		<div class="col-subspan fg-white" style="margin-top: -1px; margin-left: -8px;">
							<div class="col-subspan spanxs returndoc_mth hide" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 20px;"><small>1M</small></div>
			          		<div class="col-subspan spanxs returndoc_mth hide" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 5px;"><small>2M</small></div>
			          		<div class="col-subspan spanxs returndoc_mth hide" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 5px;"><small>3M</small></div>
			          		<div class="col-subspan spanxs returndoc_mth hide" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 5px;"><small>4M</small></div>
			          		<div class="col-subspan spanxs returndoc_mth hide" style="max-height: 10px; font-size: 0.7em; max-width: 10px !important; margin-left: 6px;"><small>5M</small></div>
						</div>	
						
	          		</div>
				</div>        
	        </div>
		</div>

    <a href="<?php echo site_url('referral_control'); ?>" target="_blank">
	    <div id="referal_parent" class="tile">  
		    <div class="col-subspan subspanhalf-height bg-blueDeep text-center" style="position: absolute; ">        			
	        	<div class="col-subspan paddingBottom10 fg-white">
	        		<div class="fg-white">
	        			<img src="<?php echo base_url('img/TLA.PNG'); ?>" class="col-subspan spanhalf" style="position: absolute; margin-left: -55px; margin-top: 13px; width: 35px; height: 35px;">       					
	        			<div class="col-subspan spanhalf marginTop10 marginLeft45 text-left">
	        				<strong>Referral</strong> <br/> 
	        				<span>Dashboard</span>
	        			</div>
	        		</div>
	        	</div>    
	        	<div class="col-subspan">  	        	
	        	    <div class="tile live" data-role="live-tile" data-effect="slideLeft">
	        	    	<div class="tile-content col-subspan col-subspanhalf-height bg-green fg-white">
	        	    		<div class="col-subspan text-right paddingRight5" style="max-height: 20px; font-size: 0.8em; position: absolute;"><small class="marginRight5">MTH</small></div>
	        	    		<div id="tl_brannerMTD" class="subheader fg-white" style="margin-top: 8px;"></div>  
		        			<header id="tl_subbrannerMTD" class="col-subspan fg-white animated fadeInUp marginTop10">
		        				<small></small>
		        			</header>  
	        	    	</div>
	        	    	<div class="tile-content col-subspan col-subspanhalf-height bg-brown fg-white">
	        	    		<div class="col-subspan text-right paddingRight5" style="max-height: 20px; font-size: 0.8em; position: absolute;"><small class="marginRight5">YTD</small></div>
	        	    		<div id="tl_brannerYTD" class="subheader fg-white" style="margin-top: 8px;"></div>  
		        			<header id="tl_subbrannerYTD"  class="col-subspan fg-white animated fadeInUp marginTop10">
		        				<small>YTD VOL.</small>
		        			</header>          	    	
	        	    	</div>
	        	    </div>	        	
        		</div>    		
	        </div>    	
	    </div>
	</a>
		
    <div class="tile">    	
    	<div class="col-subspan bg-mauve" style="max-height: 29px;">
	    	<div class="tile live" data-role="live-tile" data-effect="slideDown" style="max-height: 29px;">
    			<div class="tile-content col-subspan animated fadeIn">
    				<div class="brand brand-custom bg-blueDeep text-center" style="padding-top: 3px;">
                    	<span id="tl_totalAgentYTD" class="text-bold" style="font-size: 0.9em !important;">Loading...</span>
                    </div>    				
    			</div>
    			<div class="tile-content col-subspan" style="max-height: 29px;">
    				<div class="brand brand-custom bg-blueDeep text-center" style="padding-top: 3px;">
                    	<span id="tl_activePercentage" class="text-bold" style="font-size: 0.9em !important;"></span>
                    </div>    				
    			</div>
    		</div>    	
    	</div>
    	<div id="referral_details" class="col-subspan bg-mauve" style="height: 91px; max-height: 91px; min-width: 125px;">
    		<table id="refer_subdetails" class="table bordered fg-white" style="height: 91px; min-width: 125px; margin-left: -3px;">
    			<tbody class="bg-mauve">    			
    				<tr>
    					<td class="tlagent_cell1 bg-green">P0 (0%)</td>
    					<td class="tlagent_cell2 bg-green">N0 (0%)</td>
    				</tr>
    				<tr>
    					<td class="tlagent_cell3 bg-orange">A0 (0%)</td>
    					<td class="tlagent_cell4 bg-orange">DD0 (0%)</td>
    				</tr>
    				<tr>
    					<td class="tlagent_cell5 bg-red">I0 (0)</td>
    					<td class="tlagent_cell6 bg-red">E0 (0%)</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
    </div>
    
    <div class="tile" style="position: absolute; margin-left: 520px; margin-top: 130px;">
    	<div class="col-subspan col-subspan-height paddingLeft10 bg-crimson">
        	<div class="col-subspan fg-white">
        		<div class="col-subspan spanxs" title="SB Volume" style="position: absolute; min-width: 100px; margin-top: 52px; margin-left: -52px; transform: rotate(270deg);">
        			<small style="font-size: 0.7em;">YTD SB Vol. (Mb)</small>
        		</div>
        		<span id="tlvol_header1" class="col-subspan spanxs label_subtitle animated fadeInDown" style="margin-top: 3px; margin-left: 9px; color: rgba(255, 255, 255, .7);"></span>
        		<span id="tlvol_header2" class="col-subspan spanxs label_subtitle animated fadeInDown" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, .7);"></span>
        		<span id="tlvol_header3" class="col-subspan spanxs label_subtitle animated fadeInDown" style="margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, .7);"></span>
        		<span id="tlvol_header4" class="col-subspan spanxs label_subtitle animated fadeInDown" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, .7);"></span>
        		<span id="tlvol_header5" class="col-subspan spanxs label_subtitle animated fadeInDown" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, .7);"></span>
        	</div>
        	
        	<span id="ytd_sb_tlvolume" class="col-subspan marginLeft10" style="margin-top: 18px;"></span>
        	
        	<div id="ytdlabel_sb_tlvolume" class="col-subspan fg-white hide" style="margin-top: 0px; margin-left: -15px;">
				<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 18px !important; margin-left: 30px;"><small>E</small></div>
          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 20px !important; margin-left: 1px;"><small>C</small></div>
          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 19px !important; margin-left: 0px;"><small>N</small></div>
          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 19px !important; margin-left: 2px;"><small>S</small></div>
          		<div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 10px !important; margin-left: 1px;"><small>I</small></div>
			</div>	
				
        </div>
    </div>
    
    <div class="tile" style="position: absolute; margin-left: 650px; margin-top: 130px;">
   		<div class="col-subspan col-subspan-height bg-crimson" style="border-left: 1px solid #FFF;">
   		   			
        	<div class="col-subspan" style="display: inline;">	
        		<div class="col-subspan fg-white" style="font-size: 0.8em; display: inline; float: left;">
        			<div id="tlagent_label" class="marginLeft5" style="min-width: 20px; float: left;"><small></small></div>
	        		<div id="tlagent_newagent" class="text-center" style="min-width: 20px; float: left;"><small></small></div>
	        		<div id="tlagent_achieve" style="min-width: 30px; float: left;"><small></small></div>
	        		<div id="tlagent_option" style="min-width: 25px; float: left; margin-left: 15px;"><small></small></div>
        		</div>
        		
        		<div id="tlagent_atlabels" class="col-subspan-height" style="position: absolute; margin-top: 5px; margin-left: -15px;">
	        		<ul class="fg-white" style="list-style: none; font-size: 0.7em;">
	        			<li class="tlagent_atlabel1" style="padding-top: 3px;"><small></small></li>
	        			<li class="tlagent_atlabel2" style="margin-top: -6px;"><small></small></li>
	        			<li class="tlagent_atlabel3" style="margin-top: -7px;"><small></small></li>
	        			<li class="tlagent_atlabel4" style="margin-top: -8px;"><small></small></li>
	        			<li class="tlagent_atlabel5" style="margin-top: -7px; padding-left: 1px"><small></small></li>
	        		</ul>
	        	</div>	
	        
	        	<div class="col-subspan-height text-right" style="width: 15px; float: right; margin-right: 5px; margin-top: 5px;">
	        		<ul class="fg-white" style="list-style: none; font-size: 0.7em; margin-top: -2px; margin-left: -30px; padding-right: 5px;">
	        			<li class="tlagent_atPercent1" style="padding-top: 2px;"></li>
	        			<li class="tlagent_atPercent2" style="margin-top: -6px;"></li>
	        			<li class="tlagent_atPercent3" style="margin-top: -6px;"></li>
	        			<li class="tlagent_atPercent4" style="margin-top: -6px;"></li>
	        			<li class="tlagent_atPercent5" style="margin-top: -6px;"></li>
	        		</ul>
	        	</div>	        	

        		<div class="col-subspan-height" style="width: 90px; margin-left: 14px;">
	        		<canvas id="agent_accu" height="235" style="margin-top:8px;"></canvas>				
	        	</div>	
	   	
	    		<div class="brand text-center animated fadeInLeft" style="min-height: 20px; max-height: 20px; background-color: rgba(0, 0, 0, .2);">
                	<span class="text" style="line-height: 12px;">Number of TLA</span>
                </div>    	
	        	 
	    	</div>			
   		</div>
    </div>

		<div class="tile double double-vertical ">
		        <div class="col-container animated fadeInRight text-center fg-white bg-green" style="border-bottom: 2px solid white;">
		        <div class="col-subspan col-subspanhalf-height" style="border-right: 2px solid white;">
		            <div class="padding_none marginTop10 text_bold fg-white">Nano / Micro</div>
		            <div class="padding_none fg-white">Dashboard</div>
		        </div>
		        <div class="col-subspan col-subspanhalf-height">		               
					<div id="nanomicro_appr_rate" class="col-subspan text-center fg-white marginTop5" style="font-size: 1.5em;">0%</div>
		            <div class="col-subspan text-center marginTopEasing5"><small>Approved Rate</small></div>
		        </div>
		    </div>
		    <div class="col-container animated fadeInLeft text-center bg-green fg-white">		          
		        <div class="col-subspan col-subspanhalf-height" style="border-right: 2px solid white;">
		                <div class="col-subspan text-right paddingRight5" style="max-height: 20px; font-size: 0.8em; position: absolute; margin-left: 0;"><small>MTH</small></div>
		                <div id="nanomicro_actual_mtd" class="col-subspan subheader text-center fg-white marginTop10">0</div>
		                <div id="nanomicro_datainfo_mtd" class="col-subspan text-center"><small>0Mb (Ach. 0%)</small></div>
		        </div>
				<div class="tile live col-subspan col-subspanhalf-height margin_none bg-green" data-role="live-tile" data-effect="slideLeft" style="min-width: 125px;">
		            <div class="tile-content col-subspan col-subspanhalf-height">
		                <div class="col-subspan text-right" style="max-height: 20px; font-size: 0.8em; position: absolute; right: 4px;"><small>NANO</small></div>
		                <div id="nano_actual" class="col-subspan text-center fg-white" style="font-size: 1.7em; margin-top: 8px;">0</div>
		                <div id="nano_datainfo" class="col-subspan text-center" style="margin-top: -5px;"><small>0Mb (Ach. 0%)</small></div>
		            </div>
		            <div class="tile-content col-subspan col-subspanhalf-height">
		                    <span class="col-subspan text-right" style="max-height: 20px; font-size: 0.8em; position: absolute; right: 4px;"><small>MICRO</small></span>
			                <div id="micro_actual" class="col-subspan text-center fg-white" style="font-size: 1.7em;  margin-top: 8px;">0</div>
			                <div id="micro_datainfo" class="col-subspan text-center" style="margin-top: -5px;"><small>0Mb (Ach. 0%)</small></div>
		            </div>
		        </div>
		    </div>
		
		    <div class="col-container fg-white">
		        <div class="col-subspan col-subspan-height bg-brown" style="border-top: 2px solid white; border-right: 2px solid white;">
		
		            <div class="col-subspan spanxs" style="position: absolute; min-width: 100px; margin-top: 55px; margin-left: -45px; transform: rotate(270deg);">
		                <small style="font-size: 0.7em;">Nano / Micro Vol.</small>
		            </div>
		
		            <div class="col-subspan text-left" style="font-size: 0.8em; margin-left: 0px;">
		                <span class="col-subspan spanxs label_subtitle nanomicro_ach_vol0" style="margin-top: 3px; margin-left: 3px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">(%)</span>
		                <span class="col-subspan spanxs label_subtitle nanomicro_ach_vol1" style="margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle nanomicro_ach_vol2" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle nanomicro_ach_vol3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle nanomicro_ach_vol4" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle nanomicro_ach_vol5" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            </div>
		
		            <div class="col-subspan text-left" style="font-size: 0.8em; margin-left: -3px;">
		                <span class="col-subspan spanxs label_subtitle nanomicro_vol0" style="margin-top: 3px; margin-left: 3px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">&nbsp;</span>
		                <span class="col-subspan spanxs label_subtitle nanomicro_vol1" style="margin-top: 3px; margin-left: 4px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle nanomicro_vol2" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle nanomicro_vol3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle nanomicro_vol4" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle nanomicro_vol5" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            </div>
		
		            <div id="nanomicro_chart" class="col-subspan marginTop10" style="max-width: 110px; margin-left: 22px;"></div>
		
		            <div class="col-subspan fg-white" style="margin-top: -1px; margin-left: 8px; max-width: 110px;">
		                <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 20px;"><small>E</small></div>
		                <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>C</small></div>
		                <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>N</small></div>
		                <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>S</small></div>
		                <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 10px !important; margin-left: 5px;"><small>I</small></div>
		            </div>
		
		        </div>
		        <div class="col-subspan col-subspan-height bg-brown" style="border-top: 2px solid white;">
		
		            <div class="col-subspan spanxs" style="position: absolute; min-width: 100px; margin-top: 55px; margin-left: -45px; transform: rotate(270deg);">
		                <small style="font-size: 0.7em;">Nano / Micro App-in</small>
		            </div>
		
		            <div class="col-subspan text-left" style="font-size: 0.8em; margin-left: 0px;">
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_ach_vol0" style="margin-top: 3px; margin-left: 3px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">(%)</span>
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_ach_vol1" style="margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_ach_vol2" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_ach_vol3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_ach_vol4" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_ach_vol5" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            </div>
		
		            <div class="col-subspan text-left" style="font-size: 0.8em; margin-left: -3px;">
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_vol0" style="margin-top: 3px; margin-left: 6px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">&nbsp;</span>
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_vol1" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_vol2" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_vol3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_vol4" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		                <span class="col-subspan spanxs label_subtitle appin_nanomicro_vol5" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            </div>
		
		            <div id="appin_nanomicro_chart" class="col-subspan marginTop10" style="max-width: 110px; margin-left: 22px;"></div>
		
		            <div class="col-subspan fg-white" style="margin-top: -1px; margin-left: 8px; max-width: 110px;">
		                <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 20px;"><small>E</small></div>
		                <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>C</small></div>
		                <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>N</small></div>
		                <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>S</small></div>
		                <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 10px !important; margin-left: 5px;"><small>I</small></div>
		            </div>
		
		        </div>
		    </div>
		</div>

		<div class="tile animated fadeInDown" style="position: absolute; right: -30px; min-height: 128px !important;">
			<div class="tile live" data-role="live-tile" data-effect="slideLeftRight" col-subspan col-subspan-height margin_none" style="border-bottom: 1px solid white; border-right: 1px solid white; min-width: 125px; min-height: 128px;">	
       			<div class="tile-content col-subspan-minfix col-subspan-height bg-brown">
		            <div class="brand brand-custom animated fadeInLeft col-subspan-minfix text_bold text-center" style="min-height: 0px; background-color: #60A917; margin-top: -2px;">
		                <small style="margin-top: -2px;">Nano / Micro</small>
		            </div>
		            <div class="col-subspan-minfix paddingTop15 text-center" style="min-height: 96px; max-height: 96px;">
		                    
						<div class="col-subspan text-center" style="position: absolute; min-width: 100px; margin-top: -15px; font-size: 0.8em;">Payment Distribution</div>

						<div class="col-subspan spanxs" style="position: absolute; min-width: 100px; margin-top: 30px; margin-left: -46px; font-size: 0.7em; transform: rotate(270deg);"></div>
							
		                <table id="destribution_box" class="table bg-transparent"  style="width: 100px; margin: 5px auto 0 auto">
		                    <tbody>
		                    <tr data-attr-day="Mon" class="text-center">
		                        <td data-attr="East" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="Central" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="North" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="South" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="Northeast" class="padding_none border-right-none">
		                            <span class="traffic_render fa fa-circle fg-white"></span>
		                        </td>
		                    </tr>
		                    <tr data-attr-day="Tue" class="text-center">
		                        <td data-attr="East" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="Central" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="North" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="South" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="Northeast" class="padding_none border-right-none">
		                            <span class="traffic_render fa fa-circle fg-white"></span>
		                        </td>
		                    </tr>
		                    <tr data-attr-day="Wed" class="text-center">
		                        <td data-attr="East" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="Central" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="North" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="South" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="Northeast" class="padding_none border-right-none">
		                            <span class="traffic_render fa fa-circle fg-white"></span>
		                        </td>
		                    </tr>
		                    <tr data-attr-day="Thu" class="text-center">
		                        <td data-attr="East" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="Central" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="North" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="South" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="Northeast" class="padding_none border-right-none">
		                            <span class="traffic_render fa fa-circle fg-white"></span>
		                        </td>
		                    </tr>
		                    <tr data-attr-day="Fri" class="text-center">
		                        <td data-attr="East" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="Central" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="North" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="South" class="padding_none"><span class="traffic_render fa fa-circle fg-white"></span></td>
		                        <td data-attr="Northeast" class="padding_none border-right-none">
		                            <span class="traffic_render fa fa-circle fg-white"></span>
		                        </td>
		                    </tr>
		
		                    </tbody>
		                </table>
		
		                <div id="" class="col-subspan-height" style="position: absolute; top: 25px; left: -18px; ">
		                    <ul class="fg-white" style="list-style: none; font-size: 0.7em;">
		                        <li class="" style=""><small style="font-size: 0.9em;">E</small></li>
		                        <li class="" style="margin-top: -5px;"><small style="font-size: 0.9em;">C</small></li>
		                        <li class="" style="margin-top: -4px;"><small style="font-size: 0.9em;">N</small></li>
		                        <li class="" style="margin-top: -5px;"><small style="font-size: 0.9em;">S</small></li>
		                        <li class="" style="margin-top: -4px;"><small style="font-size: 0.9em;">I</small></li>
		                    </ul>
		                </div>
		
		                <div class="col-subspan fg-white" style="margin-top: -3px; margin-left: 8px; max-width: 110px;">
		                    <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 7px;"><small>M</small></div>
		                    <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>T</small></div>
		                    <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 5px;"><small>W</small></div>
		                    <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 5px;"><small>T</small></div>
		                    <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 10px !important; margin-left: 9px;"><small>F</small></div>
		                </div>
		
		            </div>
		        </div>
				<div class="tile-content col-subspan-minfix col-subspan-height bg-darkCyan">
				    <div class="col-subspan" style="display: inline;">	

			        	<div class="col-subspan fg-white" style="font-size: 0.8em; display: inline; float: left; margin-top: 3px;">
			        		<div class="marginLeft5" style="min-width: 20px; float: left;"><small>แผงตลาด</small> </div>
				        	<div class="text-center" style="min-width: 55px; float: left; padding-left: 5px; text-align: left;"><small id="MarketShop">0</small></div>			  
				        	<div style="min-width: 25px; float: left; margin-left: -2px;;"><small id="MKTPenRate">0%</small></div>
			        	</div>
			        		
			        	<div id="tlagent_atlabels" class="col-subspan-height" style="position: absolute; margin-top:10px; margin-left: -15px;">
				        	<ul class="fg-white" style="list-style: none; font-size: 0.7em;">
				        		<li class="nano_atlabel1" style="padding-top: 3px;"><small></small></li>
				        		<li class="nano_atlabel2" style="margin-top: -6px;"><small></small></li>
				        		<li class="nano_atlabel3" style="margin-top: -7px;"><small></small></li>
				        		<li class="nano_atlabel4" style="margin-top: -8px;"><small></small></li>
				        		<li class="nano_atlabel5" style="margin-top: -7px; padding-left: 3px"><small></small></li>
				        	</ul>
				        </div>	
				        
				        <div class="col-subspan-height text-right" style="width: 15px; float: right; margin-right: 5px; margin-top: 5px;">
				        	<ul class="fg-white" style="list-style: none; font-size: 0.7em; margin-top: -2px; margin-left: -30px; padding-right: 5px;">
				        		<li class="nano_atPercent1" style="padding-top: 2px;"></li>
				        		<li class="nano_atPercent2" style="margin-top: -6px;"></li>
				        		<li class="nano_atPercent3" style="margin-top: -6px;"></li>
				        		<li class="nano_atPercent4" style="margin-top: -6px;"></li>
				        		<li class="nano_atPercent5" style="margin-top: -6px;"></li>
				        	</ul>
				        </div>	        	
			
			        	<div class="col-subspan-height" style="width: 90px; margin-left: 14px;">
				        	<canvas id="nano_market_penetrationchart"  height="235" style="margin-top: 10px;"></canvas>				
				        </div>	
				   	
				    	<div class="brand text-center animated fadeInLeft" style="min-height: 20px; max-height: 20px; background-color: rgba(0, 0, 0, .2);">
			                <span class="text" style="line-height: 12px;">Nano MKT Penetration</span>
			            </div> 	

			    	</div>
				</div>	
			</div>
		</div>
		    
		<div class="tile animated fadeInDown" style="position: absolute; right: -165px; background: rgb(255, 118, 21); min-height: 125px; min-width: 125px;">				
		    <div class="col-subspan text-center border-bottom">
			    <div class="col-subspan spanhalf col-subspanhalf-height paddingTop10 fg-white" style="max-height: 60px;">
						
					<span class="col-subspan spanhalf" style="font-size: 1.5em !important; padding-top: 5px;">H4C</span>
				</div>
			    <div class="col-subspan spanhalf col-subspanhalf-height paddingTop10 fg-white border-left animated fadeInDown" style="max-height: 60px;">
					<span id="h4c_rate" class="animated fadeIn" style="font-size: 1.5em;"></span>
					<span class="col-subspan spanhalf" style="font-size: 0.6em !important;">APPROVED</span>
				</div>
			</div>
			<div class="tile live col-subspan-minfix col-subspanhalf-height margin_none text-center animated fadeInLeft" data-role="live-tile" data-effect="slideLeftRight" style="background: rgb(255, 118, 21); min-height: 70px !important;">
			    <div class="tile-content col-subspan">
			        <div class="col-subspan text-right paddingRight5" style="max-height: 20px; font-size: 0.8em; position: absolute; margin-left: 0;"><small>MTH</small></div>
			        <div id="h4c_actual_mtd" class="col-subspan subheader text-center fg-white marginTop10">0Mb</div>
			        <div id="h4c_actual_mtddetails" class="col-subspan text-center"><small>0Mb (Ach. 0%)</small></div>
			    </div>
			    <div class="tile-content col-subspan">
			        <div class="col-subspan text-right paddingRight5" style="max-height: 20px; font-size: 0.8em; position: absolute; margin-left: 0;"><small>YTD</small></div>
			        <div id="h4c_actual_ytd" class="col-subspan subheader text-center fg-white marginTop10">0Mb</div>
			        <div id="h4c_actual_ytddetails" class="col-subspan text-center"><small>0Mb (Ach. 0%)</small></div>
			    </div>
			</div>
		</div>
			
		<div class="tile live bg-darkCyan animated fadeInDown" data-role="live-tile" data-effect="slideUpDown" style="position: absolute; right: -30px; margin-top: 128px; min-height: 123px !important;">
				
			<div class="tile-content col-subspan-minfix col-subspan-height bg-darkCyan" style="max-height: 123px !important; font-size: 0.7em; min-height: 123px !important;"">
			    <div class="col-subspan-minfix">
			        <div class="col-subspan spanmini col-subspanhalf-height bg-lime">
			            <div class="brand brand-custom col-subspan spanmini text_bold text-center animated fadeInLeft" style="min-height: 0px; background-color: rgba(0, 0, 0, .5);"><small>W1</small></div>
			            <div class="col-subspan spanmini col-subspanhalf-heightmini text_bold text-center animated zoomIn" data-hint-position="top" data-hint="">
							<div id="nplacc_week1" class="col-subspan spanmini paddingBottom5" style="min-height: 25px; max-height: 25px; padding-top: 4px; border-bottom: 1px solid white; font-size:1em;">0</div>
							<div id="nplrate_week1" class="col-subspan spanmini" style="max-height: 20.5px; padding-top: 3px; font-size: 1em;">0%</div>
						</div>
			        </div>
			        <div class="col-subspan spanmini col-subspanhalf-height bg-green">
			            <div class="brand brand-custom col-subspan spanmini text_bold text-center animated fadeInLeft" style="min-height: 0px; background-color: rgba(0, 0, 0, .5);"><small>W2</small></div>
			            <div class="col-subspan spanmini col-subspanhalf-heightmini text_bold text-center animated zoomIn" data-hint-position="top" data-hint="">
							<div id="nplacc_week2" class="col-subspan spanmini paddingBottom5" style="min-height: 25px; max-height: 25px; padding-top: 4px; border-bottom: 1px solid white; font-size:1em;">0</div>
							<div id="nplrate_week2" class="col-subspan spanmini" style="max-height: 20.5px; padding-top: 3px; font-size: 1em;">0%</div>
						</div>
			        </div>
			        <div class="col-subspan spanmini col-subspanhalf-height bg-emerald">
			            <div class="brand brand-custom col-subspan spanmini text_bold text-center animated fadeInLeft" style="min-height: 0px; background-color: rgba(0, 0, 0, .5);"><small>W3-4</small></div>
			            <div class="col-subspan spanmini col-subspanhalf-heightmini text_bold text-center animated zoomIn" data-hint-position="top" data-hint="">
							<div id="nplacc_week3" class="col-subspan spanmini paddingBottom5" style="min-height: 25px; max-height: 25px; padding-top: 4px; border-bottom: 1px solid white; font-size: 1em;">0</div>
							<div id="nplrate_week3" class="col-subspan spanmini" style="max-height: 20.5px; padding-top: 3px; font-size:1em;">0%</div>
						</div>
			        </div>
			    </div>
			    <div class="col-subspan-minfix">
			        <div class="col-subspan spanmini col-subspanhalf-height bg-pickLight">
			            <div class="brand brand-custom col-subspan spanmini text_bold text-center animated fadeInLeft" style="min-height: 0px; background-color: rgba(0, 0, 0, .5);"><small>X</small></div>
			            <div class="col-subspan spanmini col-subspanhalf-heightmini text_bold text-center animated zoomIn" data-hint-position="top" data-hint="">
							<div id="nplacc_xclass" class="col-subspan spanmini paddingBottom5" style="min-height: 25px; max-height: 25px; padding-top: 4px; border-bottom: 1px solid white; font-size: 1em;">0</div>
							<div id="nplrate_xclass" class="col-subspan spanmini" style="min-height: 25px; max-height: 25px; padding-top: 3px; font-size: 1em;">0%</div>
						</div>
			        </div>
			        <div class="col-subspan spanmini col-subspanhalf-height bg-red">
			            <div class="brand brand-custom col-subspan spanmini text_bold text-center animated fadeInLeft" style="min-height: 0px; background-color: rgba(0, 0, 0, .5);"><small>M</small></div>
			            <div class="col-subspan spanmini col-subspanhalf-heightmini text_bold text-center animated zoomIn" data-hint-position="top" data-hint="">
							<div id="nplacc_mclass" class="col-subspan spanmini paddingBottom5" style="min-height: 25px; max-height: 25px; padding-top: 4px; border-bottom: 1px solid white; font-size: 1em;">0</div>
							<div id="nplrate_mclass" class="col-subspan spanmini" style="min-height: 25px; max-height: 25px; padding-top: 3px; font-size: 1em;">0%</div>
						</div>
			        </div>
			        <div class="col-subspan spanmini col-subspanhalf-height bg-crimson">
			            <div class="brand brand-custom col-subspan spanmini text_bold text-center animated fadeInLeft" style="min-height: 0px; background-color: rgba(0, 0, 0, .5);"><small>NPL</small></div>
			            <div class="col-subspan spanmini col-subspanhalf-heightmini text_bold text-center animated zoomIn" data-hint-position="top" data-hint="">
							<div id="nplacc_class" class="col-subspan spanmini paddingBottom5" style="min-height: 25px; max-height: 25px; padding-top: 4px; border-bottom: 1px solid white; font-size: 1em;">0</div>
							<div id="nplrate_class" class="col-subspan spanmini" style="min-height: 25px; max-height: 25px; padding-top: 3px; font-size: 1em;">0%</div>
						</div>
			        </div>
			    </div>
			</div>

			<div class="tile-content col-subspan-minfix col-subspan-height bg-darkCyan" style="max-height: 120px !important;">
			    <div class="col-subspan spanxs" style="position: absolute; min-width: 125px; margin-top: 45px; margin-left: -58px; transform: rotate(270deg);">
			        <small style="font-size: 0.7em;">Daily Collection Succ.</small>
			    </div>
			
			    <div class="col-subspan text-left" style="font-size: 0.8em; margin-left: 0px; margin-top: 0px; margin-bottom: 5px;">
			        <span class="col-subspan spanxs label_subtitle nplos_label0" style="margin-top: 3px; margin-left: 3px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">(%)</span>
			        <span class="col-subspan spanxs label_subtitle nplos_label1" style="margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
			        <span class="col-subspan spanxs label_subtitle nplos_label2" style="margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
			        <span class="col-subspan spanxs label_subtitle nplos_label3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
			        <span class="col-subspan spanxs label_subtitle nplos_label4" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
			        <span class="col-subspan spanxs label_subtitle nplos_label5" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
			    </div>
			
			    <div id="npldata_chart" class="col-subspan marginTop20" style="max-width: 110px; margin-left: 22px;"></div>
			
			    <div class="col-subspan fg-white" style="margin-top: -2px; margin-left: 6px; max-width: 110px;">
			        <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 20px;"><small>E</small></div>
			        <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>C</small></div>
			        <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>N</small></div>
			        <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>S</small></div>
			        <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 10px !important; margin-left: 5px;"><small>I</small></div>
			    </div>
			</div>

		</div>
		    
		<div class="tile live animated fadeInDown" data-role="live-tile" data-effect="slideUpDown" style="position: absolute; right: -165px; margin-top: 128px; min-height: 124px; min-width: 125px;"">				
			<div class="tile-content col-subspan-minfix col-subspan-height margin_none bg-orange" style="min-height: 128px; min-width: 125px;"">
		        <div class="col-subspan spanxs" style="position: absolute; min-width: 100px; margin-top: 58px; margin-left: -45px; transform: rotate(270deg);">
		            <small class="animated zoomIn" style="font-size: 0.7em;">YTD H4C Vol.(Mb)</small>
		        </div>
		
		        <div id="h4c_ytdlabel" class="col-subspan text-left hide" style="font-size: 0.8em; margin-left: 0px;">
		            <span class="col-subspan spanxs label_subtitle h4c_ytdchart_ach0" style="margin-top: 3px; margin-left: 3px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">&nbsp;</span>
		            <span class="col-subspan spanxs label_subtitle h4c_ytdchart_ach1" style="margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            <span class="col-subspan spanxs label_subtitle h4c_ytdchart_ach2" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            <span class="col-subspan spanxs label_subtitle h4c_ytdchart_ach3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            <span class="col-subspan spanxs label_subtitle h4c_ytdchart_ach4" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            <span class="col-subspan spanxs label_subtitle h4c_ytdchart_ach5" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		        </div>
		
		        <div id="h4c_ytdchart" class="col-subspan marginTop10" style="max-width: 110px; margin-left: 22px; margin-top: 25px;"></div>
		
		        <div id="h4c_ytdfooter" class="col-subspan fg-white hide" style="margin-top: -1px; margin-left: 6px; max-width: 110px;">
		            <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 20px;"><small>E</small></div>
		            <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>C</small></div>
		            <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>N</small></div>
		            <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>S</small></div>
		            <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 10px !important; margin-left: 5px;"><small>I</small></div>
		        </div>
			</div>
			<div class="tile-content col-subspan-minfix col-subspan-height margin_none bg-orange">
		        <div class="col-subspan spanxs" style="position: absolute; min-width: 100px; margin-top: 58px; margin-left: -45px; transform: rotate(270deg);">
		            <small class="animated zoomIn" style="font-size: 0.7em;">YTD H4C App-in</small>
		        </div>
		
		        <div id="h4c_mtdlabel" class="col-subspan text-left hide" style="font-size: 0.8em; margin-left: 0px;">
		            <span class="col-subspan spanxs label_subtitle h4c_mtdchart_ach0" style="margin-top: 3px; margin-left: 3px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">&nbsp;</span>
		            <span class="col-subspan spanxs label_subtitle h4c_mtdchart_ach1" style="margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            <span class="col-subspan spanxs label_subtitle h4c_mtdchart_ach2" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            <span class="col-subspan spanxs label_subtitle h4c_mtdchart_ach3" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            <span class="col-subspan spanxs label_subtitle h4c_mtdchart_ach4" style="margin-top: 3px; margin-left: 0px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		            <span class="col-subspan spanxs label_subtitle h4c_mtdchart_ach5" style="margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, 1); font-size: 0.8em !important;">0</span>
		        </div>
		
		        <div id="h4c_mtdchart" class="col-subspan marginTop10" style="max-width: 110px; margin-left: 22px; margin-top: 25px;"></div>
		
		        <div id="h4c_mtdfooter" class="col-subspan fg-white hide" style="margin-top: -1px; margin-left: 6px; max-width: 110px;">
		            <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 20px;"><small>E</small></div>
		            <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>C</small></div>
		            <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>N</small></div>
		            <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 15px !important; margin-left: 4px;"><small>S</small></div>
		            <div class="col-subspan spanxs" style="max-height: 10px; font-size: 0.7em; max-width: 10px !important; margin-left: 5px;"><small>I</small></div>
		        </div>

			</div>
		</div>

</div>

<?php 

	
if(!in_array($session_data['emp_id'], $this->config->item('Administrator')) || !in_array($user_role, array('rd_role', 'am_role', 'hq_role', 'bm_role')) || 
	   ($user_role == 'admin_role' && $session_data['branchcode'] === '000')) {
		$filter_usage = 'style="display: none; margin-top: 1px;"'; 
	} else {
		$filter_usage = 'style="display: block; margin-top: 1px;"'; 
	}
	
?>

<!-- Report -->
<div class="tile-group no-margin no-padding1 clearfix" style="width: 100%; margin-left: -70px !important;">
    <span class="tile-group-title span12" style="font-size: 1.5em; margin-top: -0.7em; font-weight: 200; min-width: 1340px;">
    	<!-- Dashboard Menu<span class="icon-arrow-right-5"></span>-->
    	
    	<span id="filter_connect" style="position: absolute; margin-left: 10px; font-size: 0.9em; margin-top: 8px; z-index: 9988;">
    		<i class="fa fa-bar-chart fg-green fg-red"></i>
    	</span>
    	<div class="input-control select span4 fg-black" <?php echo $filter_usage; ?>>
	    	<select id="empoption_list" name="empoption_list" style="max-width: 250px;"></select>
	    </div>
	    <div style="max-height: 37px;position: absolute; right: 0; margin-top: -42px;">
		    <span id="filter_connect_collection" style="position: absolute; margin-left: 10px; font-size: 0.9em; margin-top: 8px; z-index: 999;"><i class="fa fa-user fg-red"></i></span>
	    	<div class="input-control select span4 fg-black" <?php echo $filter_usage; ?>>
		    	<select id="collection_filter" name="collection_filter" style="max-width: 250px; max-height: 37px;"></select>
		    </div>
	    </div>
    </span>

  	<!-- live data-role="live-tile" data-effect="slideLeft" data-easing="easeInSine" , 'dev_role'-->
	<div id="Whiteboard" class="tile double double-vertical ol-transparent live" <?php if(in_array($session_data['emp_id'], $this->config->item('Administrator')) || in_array($user_role, array('rd_role', 'am_role', 'bm_role', 'hq_role')) || ($user_role == 'admin_role' && $session_data['branchcode'] === '000')) echo 'data-role="live-tile" data-effect="slideUpDown" data-easing="easeInBack"'; ?> style="margin-top: -10px;">
		  		  
		<!-- PART 1 -->
		<div class="tile-content">	     		     			
			<div class="grid fg-white marginTopEasing15">
				<div class="row">
					<div class="span6 marginTopEasing5">
						<a href="<?php echo site_url('report/whiteboard');?>" target="_blank">
							<div class="span3 bg-cyan fg-white animated fadeInLeft" style="max-width: 125px; margin-left: 0 !important; min-height: 60px;">
								<div class="span3" style="max-width: 30px; max-height: 52px; margin-left: 10px !important;">
									<i class="icon-laptop" style="font-size: 2.5em; margin-left: -5px; margin-top: .38em;"></i>
		                			<i class="icon-bars" style="position: absolute; font-size: 1.3em; margin-left: .19em; margin-top: -1.57em;"></i>
								</div>
								<div class="span3 paddingLeft5 margin_none" style="max-width: 80px; padding-top: 10px;">
									<strong>SALE</strong> 
									<span style="position: absolute; margin-top: 20px; margin-left: -30px;">Whiteboard</span>
								</div>
							</div>	
						</a>
						<div class="col-subspan bg-orange animated fadeInRight text-center" style="border-left: 2px solid #FFF; max-width: 125px; min-height: 60px; max-height: 60px !important; margin-left: 0 !important;">
							<div class="col-subspan marginTop5 text-center">
								<div class="col-subspan margin_none padding_none">
									<span id="pending_dd_amt" class="label bg-orange fg-white" style="font-weight: bold; font-size: 1.5em !important;"></span>
								</div>
								<div class="col-subspan padding_none margin_none text-center" style="margin-top: -2px !important;">
									<small class="marginTopEasing5">PENDING DD</small>
								</div>
							</div>
						</div>
					</div>
				</div>		
			</div>
		
			<div class="col-container bg-darkCyan fg-white" style="margin-top: -18px;">
				<span id="sb_progress" style="width: 40px; position: absolute; margin-top: 35px; margin-left: 40px; display: none;">
					<img src="<?php echo base_url('img/hourglass.gif'); ?>">
				</span>				
					
				<div class="col-subspan" style="min-height: 110px; height: 110px; vertical-align: baseline; border-bottom: 1px solid white; border-top: 1px solid white;">
				
					<div class="col-subspan marginTop5">
						<div id="label_sb_name" class="col-subspan spanxs" title="SB Volume" style="position: absolute; margin-top: 43px; margin-left: -33px; min-width: 80px; color: rgba(255, 255, 255, .7); font-weight: bold; transform: rotate(270deg);"><small></small></div>
						<div class="col-subspan spanxs label_subtitle sb_volspan_1" style="margin-left: 28px; color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle sb_volspan_2" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle sb_volspan_3" style="color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle sb_volspan_4" style="color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle sb_volspan_5" style="margin-left: 0px; color: rgba(255, 255, 255, .7);"><small></small></div>
					</div>
			
					<span id="balanace_values" class="col-subspan marginTop10 marginLeft25"></span>
						
					<div id="legend_sb_bar" class="col-subspan" style="margin-top: -2px; visibility: hidden;">
						<div class="col-subspan spanxs label_subtitle" style="margin-left: 27px; color: rgba(255, 255, 255, .7);"><small>E</small></div>
          				<div class="col-subspan spanxs label_subtitle" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"><small>C</small></div>
          				<div class="col-subspan spanxs label_subtitle" style="color: rgba(255, 255, 255, .7);"><small>N</small></div>
          				<div class="col-subspan spanxs label_subtitle" style="margin-left: 1px; color: rgba(255, 255, 255, .7);"><small>S</small></div>
          				<div class="col-subspan spanxs label_subtitle" style="margin-left: 1px; max-width: 15px !important; padding-left: 2px; color: rgba(255, 255, 255, .7);"><small>I</small></div>
					</div>	
											
				</div>
				<div class="col-subspan" style="min-height: 110px; height: 110px; vertical-align: baseline; border: 1px solid white; border-left: 2px solid white;">
					<span id="a2ca_progress" style="width: 40px; position: absolute; margin-top: 35px; margin-left: 40px; display: none;">
						<img src="<?php echo base_url('img/hourglass.gif'); ?>">
					</span>	
												
					<div class="col-subspan marginTop5">
						<div id="label_a2ca_name" class="col-subspan spanxs" title="A2CA" style="position: absolute; font-size: 1em; margin-top: 43px; margin-left: -33px; min-width: 80px; color: rgba(255, 255, 255, .7); font-weight: bold; transform: rotate(270deg);"><small></small></div>
						<div class="col-subspan spanxs label_subtitle a2ca_volspan_1" style="margin-left: 23px; color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle a2ca_volspan_2" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle a2ca_volspan_3" style="color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle a2ca_volspan_4" style="color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle a2ca_volspan_5" style="margin-left: 0px; color: rgba(255, 255, 255, .7);"><small></small></div>
					</div>
		
					<span id="a2ca_values" class="col-subspan marginTop10 marginLeft20" style="margin-left: 22px;"></span>
						
					<div id="legend_a2ca_bar" class="col-subspan" style="margin-top: -2px; visibility: hidden;">
						<div class="col-subspan spanxs label_subtitle" style="margin-left: 24px; color: rgba(255, 255, 255, .7);"><small>E</small></div>
          				<div class="col-subspan spanxs label_subtitle" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"><small>C</small></div>
          				<div class="col-subspan spanxs label_subtitle" style="color: rgba(255, 255, 255, .7);"><small>N</small></div>
          				<div class="col-subspan spanxs label_subtitle" style="margin-left: 1px; color: rgba(255, 255, 255, .7);"><small>S</small></div>
          				<div class="col-subspan spanxs label_subtitle" style="margin-left: 1px; max-width: 15px !important; padding-left: 2px; color: rgba(255, 255, 255, .7);"><small>I</small></div>
					</div>
						
				</div>
			</div>
				
			<div class="col-container animated fadeInUp text-center fg-white" style="margin-top: 2px;">
				<div class="col-subspan bg-teal text-center paddingTop5" style="height: 85px;">
				
					<div id="sb_slider" class="slider" data-colors="#01ABA9" style="position: absolute; width: 125px; bottom: -10px; height: 7px; background: #1B6EAE;"></div>
					
					<div id="sb_volume" class="subheader marginTop10 fg-white animated rubberBand" style="font-size: 2.4em; letter-spacing: 0px;"></div> 
					<div class="title col-subspan marginTop5">
						<small id="sb_tartget"></small>
					</div>
					<div class="title col-subspan marginTop5">
						<small id="sb_vol_topic">SB VOL.</small>
					</div>
					
				</div>
				<div class="col-subspan animated fadeInUp paddingTop5 bg-amber" style="height: 85px; border-left: 1px solid #FFF; border-left: 2px solid #FFF; max-width: 124px;">
	        		<div id="a2ca_slider" class="slider" data-colors="#F0A30A" style="position: absolute; width: 123px; bottom: -10px; height: 7px; background: #1B6EAE"></div>
	        		
	        		<div id="a2ca_volume" class="subheader fg-white marginTop10 animated rubberBand" style="font-size: 2.4em; letter-spacing: 0px;"></div> 
					<div class="title col-subspan marginTop5">
						<small id="a2ca_tartget"></small>
					</div>
					<div class="title col-subspan marginTop5">
						<small id="a2ca_tartget_topic">A2CA</small>
					</div>
					
				</div>       
			</div>	
		</div>

		<!-- PART 2 -->
		<div class="tile-content">
           	  
			<div class="grid fg-white marginTopEasing15">
				<div class="row">
				
					<div class="span6 marginTopEasing5">
						<a href="<?php echo site_url('report/whiteboard');?>" target="_blank">
							<div id="approved_auth" class="col-subspan bg-orange fg-white animated fadeInRight text-center" style="border-left: 2px solid #FFF; min-width: 127px; max-width: 127px; min-height: 60px; max-height: 60px !important; margin-left: -2px !important;">
								<div class="col-subspan col-hspan20 text-center marginLeft_none" style="background-color: rgba(0, 0, 0, .2)">
									<span style="font-size: 70%;">APPROVED</span>
								</div>
								<div class="col-subspan spanhalf bg-orange col-hspan40 marginLeft_none" style="max-width: 61px; border-right: 1px solid #e0e0e0;">
									<div class="col-subspan spanhalf padding_none" style="margin-top: 8px;">
										<span class="app label bg-orange fg-white" style="font-weight: bold; font-size: 1.3em !important;"></span>
									</div>
								</div>
								<div class="col-subspan spanhalf bg-orange col-hspan40 marginLeft_none place-right" style="max-width: 61px; border-left: 1px solid #e0e0e0;">
									<div class="col-subspan spanhalf padding_none" style="margin-top: 8px;">
										<span class="rate label bg-orange fg-white" style="font-weight: bold; font-size: 1.3em !important;"></span>
									</div>							
								</div>									
							</div>
						</a>
						<div id="pendd_auth" class="col-subspan bg-cyan text-center animated fadeInLeft" style="max-width: 125px; margin-left: 2px !important; min-height: 60px;">
							<div class="col-subspan text-center" style="margin-top: 8px;">
								<div class="col-subspan margin_none padding_none">
									<span id="pending_dd_auth" class="label bg-cyan fg-white" style="font-weight: bold; font-size: 1.5em !important;"></span>
								</div>
								<div class="col-subspan padding_none margin_none text-center" style="margin-top: -2px !important;">
									<small class="marginTopEasing5">PENDING DD</small>
								</div>
							</div>
						</div>	
							
					</div>
				</div>		
			</div>
		
			<div class="col-container bg-darkCyan fg-white" style="margin-top: -18px;">			
				<div class="col-subspan" style="min-height: 110px; height: 110px; vertical-align: baseline; border-bottom: 1px solid white; border-top: 1px solid white;">
					<span id="sb_progress_auth" style="width: 40px; position: absolute; margin-top: 35px; margin-left: 40px;">
						<img src="<?php echo base_url('img/hourglass.gif'); ?>">
					</span>
						
					<div class="col-subspan" style="min-height: 110px; height: 110px; vertical-align: baseline; border-bottom: 1px solid white; ">
				
						<div class="col-subspan marginTop5">
							<div id="label_sb_name_auth" class="col-subspan spanxs" title="SB Volume" style="position: absolute; margin-top: 43px; margin-left: -33px; min-width: 80px; color: rgba(255, 255, 255, .7); font-weight: bold; transform: rotate(270deg);"><small></small></div>
							<div class="col-subspan spanxs label_subtitle sb_volspanauth_1" style="margin-left: 28px; color: rgba(255, 255, 255, .7);"><small></small></div>
	          				<div class="col-subspan spanxs label_subtitle sb_volspanauth_2" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"><small></small></div>
	          				<div class="col-subspan spanxs label_subtitle sb_volspanauth_3" style="color: rgba(255, 255, 255, .7);"><small></small></div>
	          				<div class="col-subspan spanxs label_subtitle sb_volspanauth_4" style="color: rgba(255, 255, 255, .7);"><small></small></div>
	          				<div class="col-subspan spanxs label_subtitle sb_volspanauth_5" style="margin-left: 0px; color: rgba(255, 255, 255, .7);"><small></small></div>
	          				<div class="col-subspan spanxs label_subtitle sb_volspanauth_6" style="margin-left: 0px; color: rgba(255, 255, 255, .7);"><small></small></div>
						</div>
				
						<span id="balanace_values_auth" class="col-subspan marginTop10 marginLeft25"></span>
							
						<div id="legend_sb_bar_auth" class="col-subspan" style="margin-top: -2px; visibility: hidden;">
							<div class="col-subspan spanxs label_subtitle sb_vollabel_auth_1" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; margin-left: 27px; color: rgba(255, 255, 255, .7);">E</div>
	          				<div class="col-subspan spanxs label_subtitle sb_vollabel_auth_2" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, .7);">C</div>
	          				<div class="col-subspan spanxs label_subtitle sb_vollabel_auth_3" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; color: rgba(255, 255, 255, .7);">N</div>
	          				<div class="col-subspan spanxs label_subtitle sb_vollabel_auth_4" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, .7);">S</div>
	          				<div class="col-subspan spanxs label_subtitle sb_vollabel_auth_5" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; margin-left: 1px; max-width: 15px !important; padding-left: 2px; color: rgba(255, 255, 255, .7);">I</div>
	          				<div class="col-subspan spanxs label_subtitle sb_vollabel_auth_6" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; margin-left: 1px; max-width: 15px !important; padding-left: 2px; color: rgba(255, 255, 255, .7);"></div>
						</div>	
												
					</div>
											
				</div>
				<div class="col-subspan" style="min-height: 110px; height: 110px; vertical-align: baseline; border: 1px solid white; border-left: 2px solid white;">
					<span id="a2ca_progress_auth" style="width: 40px; position: absolute; margin-top: 35px; margin-left: 40px;">
						<img src="<?php echo base_url('img/hourglass.gif'); ?>">
					</span>	
						
					<div class="col-subspan marginTop5">
						<div id="label_a2ca_name_auth" class="col-subspan spanxs" title="A2CA" style="position: absolute; font-size: 1em; margin-top: 43px; margin-left: -33px; min-width: 80px; color: rgba(255, 255, 255, .7); font-weight: bold; transform: rotate(270deg);"><small></small></div>
						<div class="col-subspan spanxs label_subtitle a2ca_volspanauth_1" style="margin-left: 23px; color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle a2ca_volspanauth_2" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle a2ca_volspanauth_3" style="color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle a2ca_volspanauth_4" style="color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle a2ca_volspanauth_5" style="margin-left: 0px; color: rgba(255, 255, 255, .7);"><small></small></div>
          				<div class="col-subspan spanxs label_subtitle a2ca_volspanauth_6" style="margin-left: 0px; color: rgba(255, 255, 255, .7);"><small></small></div>
					</div>
		
					<span id="a2ca_values_auth" class="col-subspan marginTop10 marginLeft20" style="margin-left: 22px;"></span>
						
					<div id="legend_a2ca_bar_auth" class="col-subspan" style="margin-top: -2px; visibility: hidden;">
						<div class="col-subspan spanxs label_subtitle a2ca_labelauth_1" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; margin-left: 24px; color: rgba(255, 255, 255, .7);">E</div>
          				<div class="col-subspan spanxs label_subtitle a2ca_labelauth_2" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; margin-left: 2px; color: rgba(255, 255, 255, .7);">C</div>
          				<div class="col-subspan spanxs label_subtitle a2ca_labelauth_3" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; color: rgba(255, 255, 255, .7);">N</div>
          				<div class="col-subspan spanxs label_subtitle a2ca_labelauth_4" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; margin-left: 1px; color: rgba(255, 255, 255, .7);">S</div>
          				<div class="col-subspan spanxs label_subtitle a2ca_labelauth_5" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; margin-left: 1px; max-width: 15px !important; padding-left: 2px; color: rgba(255, 255, 255, .7);">I</div>
          				<div class="col-subspan spanxs label_subtitle a2ca_labelauth_6" style="letter-spacing: 1px; font-size: 0.5em !important; margin-top: 3px; margin-left: 1px; max-width: 15px !important; padding-left: 2px; color: rgba(255, 255, 255, .7);"></div>
					</div>
					
				</div>
			</div>
				
			<div class="col-container animated fadeInUp text-center fg-white" style="margin-top: 2px;">
				<div class="col-subspan bg-teal text-center paddingTop5" style="height: 85px;">
					<div class="col-subspan bg-teal text-center paddingTop5" style="height: 85px;">
					
						<div id="sb_slider_auth" class="slider" data-colors="#01ABA9" style="position: absolute; width: 125px; bottom: -10px; height: 7px; background: #1B6EAE;"></div>
						
						<div id="sb_volume_auth" class="subheader marginTop5 fg-white animated rubberBand" style="font-size: 2.4em; max-height:25px !important; letter-spacing: 0px;"></div> 
						<div class="title col-subspan marginTop5">
							<small id="sb_tartget_auth"></small>
						</div>
						<div class="title col-subspan marginTop5">
							<small id="sb_vol_topic_auth">SB VOL.</small>
						</div>
						
					</div>
				</div>
				<div class="col-subspan animated fadeInUp paddingTop5 bg-amber" style="height: 85px; border-left: 2px solid #FFF;">
	        		<div class="col-subspan animated fadeInUp paddingTop5 bg-amber" style="height: 85px;">
	        		
		        		<div id="a2ca_slider_auth" class="slider" data-colors="#F0A30A" style="position: absolute; width: 123px; bottom: -10px; height: 7px; background: #1B6EAE;"></div>
		        		
		        		<div id="a2ca_volume_auth" class="subheader fg-white marginTop5 animated rubberBand" style="font-size: 2.4em; letter-spacing: 0px;"></div> 
						<div class="title col-subspan marginTop5">
							<small id="a2ca_tartget_auth"></small>
						</div>
						<div class="title col-subspan marginTop5">
							<small id="a2ca_tartget_topic_auth">A2CA</small>
						</div>
						
					</div>       
				</div>       
			</div>	
		</div>           
	</div>

	<a href="#">
		<div class="tile bg-lightOlive animated fadeInDown" style="margin-top: -10px;">
			<div class="tile-content text-center fg-white">
                <div class="col-subspan">
                	<div id="rm_onhand_app" class="subheader fg-white paddingTop20 animated rubberBand" style="font-size: 2.7em; letter-spacing: 1px;"></div>
                	<div id="rm_onhand_today"><small></small></div> 
                	<div class="item-title-secondary fg-white marginTop25">
                		<small id="rm_onhand_loan"></small>                		
                	</div>                	
	            	<div class="fg-white"><small>RM ON HAND</small></div>
                </div>
          
            </div>
		</div>
	</a>
	
	<a href="#">
		<div class="tile bg-lightOlive animated fadeInDown" style="margin-top: -10px;">
			<div class="tile-content text-center fg-white">
				<div class="paddingTop20 text-custom">
					<div id="ca_decision_app" class="subheader fg-white animated rubberBand" style="font-size: 2.7em; letter-spacing: 1px;"></div>        
	            	<div id="ca_pending_today"><small></small></div> 
	            	<div class="item-title-secondary fg-white marginTop25">
	            		<small id="ca_pending_loan"></small>
	            	</div>
	            	<div class="fg-white"><small>CA PENDING</small></div>
				</div>	  			      	
            </div>
		</div>
	</a>
	
	<a href="#">
		<div class="tile live bg-darkPink animated fadeInUp" data-role="live-tile" data-effect="slideLeft" data-easing="easeInSine" style="margin-top: -10px;">
			 <div class="tile-content text-center  fg-white">
	            <div id="ApprovedRate_App" style="width: 120px; height: 120px;">
	            	<div class="title col-subspan paddingTop45">
						<small id="approved_topic">APPROVED</small>
					</div>
	            </div>           	               
            </div>
			<div class="tile-content text-center fg-white">
	            <div id="ApprovedRate_Per" style="width: 120px; height: 120px;">
	            	<div class="title col-subspan paddingTop45">
						<small id="approvedrate_topic">APPROVED RATE</small>
					</div>
	            </div>           	               
            </div>           
		</div>
	</a>
	
	<a href="#">
		<div class="tile live bg-darkPink animated fadeInUp" data-role="live-tile" data-effect="slideRight" data-easing="easeInSine" style="margin-top: -10px;">
			<div class="tile-content text-center fg-white">		
	            <div id="ticket_size" style="width: 120px; height: 120px;">
	            	<div class="title col-subspan paddingTop45">
						<small id="ticksetsize_topic">TICKET SIZE</small>
					</div>
	            </div>             	          
             </div>
             <div class="tile-content text-center fg-white">   
	            <div id="ticket_size_ach" class="marginTop20 marginLeft10" style="width: 100px; height: 100px;">
	            	<div class="title col-subspan paddingTop45">
						<small id="ticksetsize_ach_topic">TICKET SIZE</small>
					</div>
	            </div>             	          
             </div>
		</div>
	</a>
	

	
   <div class="tile double double-vertical bg-white" style="margin-top: -10px;">
        	<a href="<?php echo site_url('module/drawdownTemplate'); ?>" target="_blank" class="fg-white">
        	<div class="row">
	        	<div class="col-subspan col-hspan60 animated fadeInLeft col-span124 padding5 bg-orange" style="margin-right: 2px; padding-top: 7px;">
        		<div style="position: absolute; max-width: 30px; max-height: 52px; margin-left: 10px !important;">
					<i class="icon-calendar" style="font-size: 2em; margin-left: -10px; margin-top: .32em;"></i>
				</div>
				<span class="place-right text-bold" style="margin-top: 3px; margin-right: 17px;">Last 5 Day</span>
				<span class="place-right">DD Template</span>
        	</div>
        	<div class="col-subspan col-hspan60 animated fadeInRight col-span124">
        		<div class="tile live" data-role="live-tile" data-effect="slideRight" data-easing="easeInSine" style="min-width: 124px;">
        			<div class="tile-content col-subspan col-hspan60 bg-green">
        				<div class="col-subspan text-center" style="margin-top: 7px;">
							<div class="col-subspan margin_none padding_none">
								<span id="ddt_amt" class="label bg-green fg-white animated fadeInDown" style="font-weight: bold; font-size: 1.5em !important;">0Mb</span>
							</div>
							<div class="col-subspan padding_none margin_none text-center" style="margin-top: -2px !important;">
								<small class="marginTopEasing5">SUCCESS TODAY</small>
							</div>
						</div>
        			</div>
        			<div class="tile-content col-subspan col-hspan60 bg-brown">
        				<div class="col-subspan text-center" style="margin-top: 7px;">
							<div class="col-subspan margin_none padding_none">
								<span id="ddt_Remaining" class="label bg-brown fg-white animated fadeInDown" style="font-weight: bold; font-size: 1.5em !important;">0Mb</span>
							</div>
							<div class="col-subspan padding_none margin_none text-center" style="margin-top: -2px !important;">
									<small class="marginTopEasing5">DDP Remaining</small>
								</div>
							</div>
	        			</div>
	        		</div>	        	
	        	</div>
        	</div>
        	</a>
        	<div class="row">
        		<div class="tile double live" data-role="live-tile" data-effect="slideRight" data-easing="easeInSine"  style="margin-top: 3px !important;">
	  
        	    	<div class="tile-content col-hspan125 bg-white fg-white">
			        	<div class="col-subspan col-hspan125 col-span124 padding5 bg-mauveLight" style="margin-right: 2px;">
		        		
		        		<div class="col-subspan spanxs" style="position: absolute; font-size: 1em; margin-top: 36px; margin-left: -58px; min-width: 120px; color: rgba(255, 255, 255, .7); font-weight: bold; transform: rotate(270deg);">
		        			<small class="animated fadeIn" style="font-size: 70%; color: rgba(255, 255, 255, .7)">DDP Count Down</small>
		        		</div>
		        		
		        		<div class="col-subspan" style="margin-top: 0px;">	
							<div class="col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 0px; color: rgba(255, 255, 255, .7);">(%)</div>
							<div class="ddp_per5 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 1px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_per4 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 0px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_per3 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_per2 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_per1 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"></div>
						</div>
		        		
		        		<div class="col-subspan" style="margin-top: 3px;">
							<div class="col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 0px; color: rgba(255, 255, 255, .7);">&nbsp;</div>
							<div class="ddp_amt5 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 1px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_amt4 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 0px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_amt3 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_amt2 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_amt1 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"></div>
						</div>
						
						<div id="ddt_sb_bar" class="col-subspan animated fadeIn" style="position: absolute; margin-top: 100px;">
							<div class="col-subspan spanxs label_subtitle countdown_label1" style="margin-left: 18px; color: rgba(255, 255, 255, 1);"><small>D5</small></div>
          					<div class="col-subspan spanxs label_subtitle countdown_label2" style="margin-left: 2px; color: rgba(255, 255, 255, 1);"><small>D4</small></div>
          					<div class="col-subspan spanxs label_subtitle countdown_label3" style="margin-left: 2px; color: rgba(255, 255, 255, 1);"><small>D3</small></div>
          					<div class="col-subspan spanxs label_subtitle countdown_label4" style="margin-left: 1px; color: rgba(255, 255, 255, 1);"><small>D2</small></div>
          					<div class="col-subspan spanxs label_subtitle countdown_label5" style="margin-left: 0px; max-width: 15px !important; padding-left: 2px; color: rgba(255, 255, 255, 1);"><small>D1</small></div>
						</div>
						
		        		<canvas id="myLineChart" width="80" height="55" style="margin-top: 10px; margin-left: 7px;"></canvas>

		        	</div>
		        	<div class="col-subspan col-hspan125 col-span124 paddingTop5 bg-mauveLight">
		        	
		        		<div class="col-subspan text-center" style="margin-top: -5px;">
		        			<small class="animated fadeIn" style="font-size: 80%; color: rgba(255, 255, 255, 1)">Operation Status</small>
		        		</div>
		        					        		
		        		<div class="col-subspan spanxs label_subtitle animated fadeInDown" style="position: absolute; margin-top: 19px; margin-left: 9px; color: rgba(255, 255, 255, .7);">Mb</div>
		        		<div class="col-subspan spanxs label_subtitle animated fadeInDown" style="position: absolute; float:right; right: 0; margin-top: 19px; margin-right: 5px; color: rgba(255, 255, 255, .7);">App</div>
		        	
		        		<div style="position: absolute; border-left: 1px solid rgba(0, 0, 0, .2); margin-top: 30px; margin-left: 66px; width: 1px; height: 75px;"></div>
		        			<canvas id="myBubbleChart" width="124" height="100" style="margin-top: 20px;"></canvas>	
			        	</div>
        	    	</div>
        	  		
        	    	<div class="tile-content col-hspan125 padding5 bg-mauveLight">
        	    	
        	    		<div style="postion: absolute; margin-top: 2px; margin-left: 5px;">	
						<div class="col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 0px; color: rgba(255, 255, 255, .7);">&nbsp;</div>
						<div class="ddp_group5 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_group4 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 28px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_group3 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 28px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_group2 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 27px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_group1 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 27px; color: rgba(255, 255, 255, .7);"></div>
					</div>
	        		
	        		<div style="postion: absolute; margin-top: 15px; margin-left: 5px;">
						<div class="col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 0px; color: rgba(255, 255, 255, .7);">&nbsp;</div>
						<div class="ddp_groupamt5 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 2px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_groupamt4 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 28px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_groupamt3 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 28px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_groupamt2 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 28px; color: rgba(255, 255, 255, .7);"></div>
          					<div class="ddp_groupamt1 col-subspan spanxs label_subtitle animated fadeInDown" style="margin-left: 28px; color: rgba(255, 255, 255, .7);"></div>
					</div>
					
					<div class="animated fadeIn" style="position: absolute; margin-top: 85px; margin-left: 15px;">
						<div class="col-subspan spanxs label_subtitle" style="margin-left: 18px; color: rgba(255, 255, 255, 1);"><small>E</small></div>
          					<div class="col-subspan spanxs label_subtitle" style="margin-left: 30px; color: rgba(255, 255, 255, 1);"><small>C</small></div>
          					<div class="col-subspan spanxs label_subtitle" style="margin-left: 29px; color: rgba(255, 255, 255, 1);"><small>N</small></div>
          					<div class="col-subspan spanxs label_subtitle" style="margin-left: 29px; color: rgba(255, 255, 255, 1);"><small>S</small></div>
          					<div class="col-subspan spanxs label_subtitle" style="margin-left: 29px; color: rgba(255, 255, 255, 1);"><small>I</small></div>
						</div>
						
        	    		<div class="col-subspan spanxs" style="position: absolute; font-size: 1em; margin-top: 20px; margin-left: -55px; min-width: 120px; color: rgba(255, 255, 255, .7); font-weight: bold; transform: rotate(270deg);">
		        		<small class="animated fadeIn" style="font-size: 70%; color: rgba(255, 255, 255, .7)">DDP Type & Score</small>
			        	</div>
			        	
        	    		<canvas id="myGroupChart" width="50" height="15" style="margin-top: 10px; margin-left: 5px;"></canvas>	    
        	    
        	    	</div>
        	    	 
        	    </div>
        	</div>
        	<div class="row">
	        	<div class="col-subspan col-hspan60 col-span124 padding5 bg-darkCyan padding_none text-center" style="min-height: 64px; margin-right: 2px; margin-top: -7px;">
				<div id="ddp_apprValume" class="subheader marginTop10 fg-white hide" style="letter-spacing: 0px;"></div> 
				<div class="title col-subspan">
					<small id="ddp_apprDetails" class="hide"></small>
				</div>
				<div class="title col-subspan marginTop25">
					<small id="ddpt_apprFooter">APPROVED</small>
				</div>
        	</div>
        	<div class="col-subspan col-hspan60 col-span124 padding5 bg-pickLight padding_none text-center" style="min-height: 64px; margin-top: -7px;">
        		<div id="ddt_cancelvolume" class="subheader marginTop10 fg-white hide" style="letter-spacing: 0px;"></div> 
					<div class="title col-subspan">
						<small id="ddp_canceldetails" class="hide"></small>
					</div>
					<div class="title col-subspan marginTop25">
						<small id="cancel_ddpfooter">CANCEL</small>
					</div>
	        	</div>
        	</div>
    </div>
   
	<a href="#">
		<div class="tile double double bg-emerald" style="position: absolute; margin-top: 120px; margin-left: 260px;">
			<div class="tile-content">
                  <div class="col-subspan-xs">
                  		<div id="rm_productity_chart" class="marginTop5 marginLeft5" style="width: 110px; height: 110px;"></div>
                  </div>
                  <div class="col-subspan-md" style="min-width: 140px;">
                  		<header class="col-subspan-md text-right fg-white paddingRight5 animated fadeInDown">
                  			<small style="font-weight: bold;">RM PRODUCTIVITY</small>
                  			<span></span>
                  		</header>
                  		<div class="col-subspan-md text-right paddingRight5">
                  			<div class="padding_none" style="margin-top: -2px;">
                  				<span id="rm_productive_vol" class="subheader fg-white"></span>
                  				<span id="rm_productive_compare" style="font-size: 1.8em;">&nbsp;</span>
                  			</div>        
	            			<div id="rm_productive_target" class="fg-white marginRight15"><small></small></div>
	            			<div id="rm_productive_avg" class="fg-white marginRight15 marginTopEasing5 padding_none"><small></small></div>
                  		</div>
                  		<div class="col-subspan-md marginTop5 paddingRight5 text-right" style="position: absolute; bottom: 2px;">       
                  			<span id="rm_trend" style="min-height: 40px; max-height: 40px;"></span>                  		                 			
                  		</div>
                  </div>
             </div>
		</div>
	</a>
	
	<a href="#">
		<div class="tile double double bg-darkMagenta" style="position: absolute; margin-top: 120px; margin-left: 520px;">
			<div class="tile-content">
                  <div class="col-subspan-xs">
                  		<div id="lb_productity_chart" class="marginTop5 marginLeft5" style="width: 110px; height: 110px;"></div>
                  </div>
                  <div class="col-subspan-md" style="min-width: 140px;">
                  		<header class="col-subspan-md text-right fg-white paddingRight5 animated fadeInDown">
                  			<small style="font-weight: bold;">LB PRODUCTIVITY</small>
                  		</header>
                  		<div class="col-subspan-md text-right paddingRight5">
                  			<div class="padding_none" style="margin-top: -2px;">
                  				<span id="lb_productive_vol" class="subheader fg-white"></span>
                  				<span id="lb_productive_compare" style="font-size: 1.8em;">&nbsp;</span>
                  			</div>        
	            			<div id="lb_productive_target" class="fg-white marginRight15"><small></small></div>
	            			<div id="lb_productive_avg" class="fg-white marginRight15 marginTopEasing5 padding_none"><small></small></div>
                  		</div>
                  		<div class="col-subspan-md marginTop5 paddingRight5 text-right" style="position: absolute; bottom: 2px;">
                  			<span id="lb_trend" style="min-height: 40px; max-height: 40px;"></span>
                  		</div>
                  </div>
             </div>
		</div>
	</a>
	
	<a href="<?php echo site_url('collection_control/getCollectionList');?>" target="_blank">
		
		<div class="tile double double-vertical bg-darkCyan" style="position: absolute; right: -160px; margin-top: -10px;">
			<div class="tile-content">
			
				<div class="grid fg-white marginTopEasing15">
					<div class="row">
						<div class="span6" style="height: 45px; padding-top: 5px;">
							<div class="span3" style="max-width: 120px; margin-left: 0 !important; ">
								<div class="span3"  style="max-width: 30px; max-height: 40px; margin-left: 10px !important;">
									<span class="fa fa-volume-control-phone fg-white" aria-hidden="true" style="width: 30px !important; margin-top: 2px; font-size: 2.5em !important; transform: rotate(-30deg)"></span>
								</div>
								<div class="span3" style="max-width: 75px; padding-left: 5px; margin-left: 0 !important;">
									<strong>Collection</strong> Dashboard
								</div>
							</div>
							<div class="span3" style="max-width: 130px; min-height: 40px; max-height: 40px !important; margin-left: 0 !important; text-align: right;">
								<span id="collection_chart_pass" class="hide" style="width: 39px !important; margin-left: 0px;"></span>
								<span id="collection_chart" style="width: 125px; margin-right: 5px;"></span>
							</div>
						</div>
					</div>		
				</div>  
				
				<div class="table-responsive marginTopEasing10 animated fadeIn"> 	
					<table id="collectionclass_overview" class="table" style="background-color: #1b6eae !important; font-weight: bold; font-size: 12px !important;">
						<thead style="display: none;">
							<th>LM</th>
							<th>AMT.</th>
							<th>ACC.</th>
							<th>%</th>
							<th>&nbsp;</th>
						</thead>
						<tbody>
	 						<tr> 
								<td>NPL</td>
								<td>0Mb</td>
								<td>0</td>
								<td>0%</td>
								<td><span class="fa fa-smile-o fg-gray" aria-hidden="true" style="font-size: 1.3em;"></span></td>
							</tr>
							<tr>
								<td>M</td>
								<td>0Mb</td>
								<td>0</td>
								<td>0%</td>
								<td><span class="fa fa-frown-o fg-gray" aria-hidden="true" style="font-size: 1.3em;"></span></td>
							</tr>	
							<tr>
								<td>X > 7</td>
								<td>0Mb</td>
								<td>0</td>
								<td>0%</td>
								<td><span class="fa fa-frown-o fg-gray" aria-hidden="true" style="font-size: 1.3em;"></span></td>
							</tr>						
						</tbody>
					</table>				
				</div>
				
				<div class="table-responsive animated fadeIn" style="margin-top: -18.5px; border-top: 1px soild #D1D1D1 !important; background-color: #FFFFFF;">		
					<table id="collect_flag" class="table striped">						
						<tbody style="font-size: 0.9em; font-weight: bold;">
							<tr style="border-top: 1px solid #D1D1D1;">
								<td style="min-width: 57px !important; max-width: 68px !important;">FLAG</td>
								<td style="min-width: 51px !important; max-width: 61px !important; text-align: left;">0Mb</td>
								<td style="min-width: 35px !important; max-width: 35px !important; text-align: left;">0</td>						
								<td colspan="2" style="min-width: 61px; max-width: 81px; text-align: right; padding-right: 17px !important;">
									<span class="badge bg-gray">0</span>							
								</td>	
											
							</tr>						
						</tbody>
					</table>			
				</div>
				
				<div class="text-center marginTopEasing20">
					<div class="fg-white" style="display: inline; float: left; font-weight: bold;">
		        		<div class="place-left" style="min-width: 123px; padding: 9px;">		        		
		        			<div id="yesterday_span" class="subheader fg-white animated rubberBand" style="margin-top: 2px;">0</div>   
		        			<header class="animated fadeIn"><small>YESTERDAY</small></header>		
		        		</div>
		        		<div class="place-left" style="min-width: 123px; border-left: 2px solid #D1D1D1; padding: 9px;">
		        			<div id="today_span" class="subheader fg-white animated rubberBand" style="margin-top: 2px;">0</div>
		        			<header class="animated fadeIn"><small>TODAY</small></header>
		        		</div>
		        	</div>
				</div>		
		
            </div>
		</div>
	</a>

</div>

</div>


<script type="text/javascript">

$(function() {
	$('a[data-attr="denied"]').on('click', function(){
	    var not = $.Notify({
	    	caption: "Authority denied",
	        content: "ขออภัย, คุณไม่มีสิทธิในการเข้าใช้งานฟังก์ชั่นนี้ กรณีมีข้อสงสัยโปรดติดต่อ PCIS Hotline",
	        timeout: 10000,
	        style: { background: 'red', color: '#FFF' }
	    });
	});
});
	
</script>



