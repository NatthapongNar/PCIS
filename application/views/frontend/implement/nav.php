<style>

	/* Overide Tooltip */
	.tooltip:after, [data-tooltip]:after {
		  z-index: 1000;
		  padding: 8px;
		  display: block;
		  min-width: 100%;
    	  white-space:nowrap;
		  background-color: #000;
		  background-color: hsla(0, 0%, 20%, 0.9);
		  color: #fff;
		  content: attr(data-tooltip);
		  font-size: 14px;
		  line-height: 1.2;
	}
	
	/* Overide Metro */
	.navigation-bar.fixed-top {
		max-height: 55px;
    	background-color: #4390DF !important;
	}
	.navigation-bar-content { 
		font-size: 14px;
		max-height: 57px;
		border-color: #e7e7e7;
		background-color: #4390DF !important;
		font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;	
	}
	
	#Profiles { 
		font-size: 12px !important; 
		font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
	}
	
	#img_profile {
		background-color: #4390DF;
		margin-top: 3.5px; 
		margin-left: -13px; 
		width: 55px; 
		height: 55px; 
		border-radius: 50%;
	}
	
	.element { 
		min-height: 57px; 		
		max-height: 57px; 		
	}
	
	.element-divider { 
		max-height: 25px;
		margin-top: 12px;
		margin-left: 0px;	
		margin-right: 3px;		
		position: absolute;
		border: 1px solid #F2F2F2;
		opacity: 0.6 !important;
	
	}
	
	.element_custom:hover {
		background-color: #4390DF !important;
	}
	
	
</style>
<div class="navigation-bar fixed-top">
    <div class="navigation-bar-content">
        <div class="element" style="text-align: center; cursor: pointer;">
            <img src="<?php echo base_url('img/PCIS_log_icon.png'); ?>" style="height: 57px; margin-top: -15px;" class="animated fadeInDown">
        </div>
        <span class="element-divider"></span>

        <a class="pull-menu" href="#"></a>
        
        <!-- <span class="element-divider place-right"></span> -->
        <?php 
            $authoriy_tester = $this->config->item('Tester');
            if(in_array($session_data['emp_id'], $authoriy_tester)) $class_hide = '';
            else $class_hide = 'hide';
        ?>
        <div class="element-menu">
            <div class="element">
                <a href="<?php echo site_url("authen/loggedPass"); ?>" style="color: white;" class="link_jumper">
                	<i class="icon-home on-left animated fadeIn" style="font-size: 1.6em !important; margin-top: 0px; margin-top: 0px;"></i>
                </a>       
            </div> 
        </div>
        
        
        
         <div class="element-menu">
         	<div class="element">
	            <a class="dropdown-toggle" href="#">
	                <i class="icofont-library" style="font-size: 1.8em !important; margin-top: 0px; margin-top: 0px;"></i>
	            </a>
	            <ul class="dropdown-menu place-right" data-role="dropdown">
	                <li><a href="#">Products</a></li>
	                <li><a href="#">Download</a></li>
	                <li><a href="#">Support</a></li>
	                <li><a href="#">Buy Now</a></li>
            	</ul>
            </div>
        </div>
        
        
                		
		<div class="element-menu place-right animated fadeInRight" style="margin-right: 5px;">
		 	<a href="<?php echo site_url("authen/logout"); ?>">
		 		<i class="icon-switch on-left" style="font-size: 1.8em !important; color: #FFF; margin-top: 15px; margin-left: 5px;"></i>
		 	</a>
		</div>
		 
		<span class="element-divider place-right"></span>
		
        <div class="element-menu place-right">
            <div class="element">
                <div class="grid fluid">
                    <div class="row">
                   
                        <button id="Profiles" class="element dropdown-toggle image-button image-left" style="margin-top: -38px; margin-right: -8px; text-align: left;">                        
                            <span style="margin-left: 3px;"><b class="tooltip-bottom" data-tooltip="xxxxxxxxxx"><?php echo !empty($session_data['engname']) ? strtoupper($session_data['engname']):""; ?></b> (Staff)</span> <br/>
	        				<span style="margin-left: 3px; font-size: 13px !important;"><?php echo !empty($session_data['branch']) ? $session_data['branch']:""; ?> (Period x.x.xx)</span>
	        				<img id="img_profile" src="<?php echo base_url('img/spring.jpg'); ?>">                                                       
                        </button>
                        
                        <ul id="Profiles-Child" class="dropdown-menu place-right" data-role="dropdown" style="min-width: 420px; font-size: 0.9em;">
                            <li class="menu-title">ข้อมูลพนักงาน</li>
                            <li style="padding-left: 8px;">
                                <div class="span6">รหัสพนักงาน</div>
                                <div class="span6"><?php echo !empty($session_data['emp_id']) ? $session_data['emp_id']:""; ?></div>
                            </li>
                            <li style="padding-left: 8px;">
                                <div class="span6">ชื่อ นามสกุล</div>
                                <div class="span6"><?php echo !empty($session_data['thname']) ? $session_data['thname']:""; ?></div>
                            </li>
                            <li style="padding-left: 8px;">
                                <div class="span6">อีเมลล์</div>
                                <div class="span6"><?php echo !empty($session_data['email']) ? $session_data['email']:""; ?></div>
                            </li>
                            <li style="padding-left: 8px;">
                                <div class="span6">ตำแหน่งงาน</div>
                                <div class="span6"><?php echo !empty($session_data['position']) ? $session_data['position']:""; ?></div>
                            </li>
                            <?php 
                            
                            if(in_array('074004', $session_data['auth']) || in_array('074005', $session_data['auth'])) {
							   echo "
            						<li style=\"padding-left: 8px;\">
		                                <div class=\"span6\">ภาค</div>
		                                <div class=\"span6\">".$session_data['region_th']."</div>
		                            </li>";

							}
							
							$branchs = !empty($session_data['branch']) ? $session_data['branch']:"ไม่ระบุ";
							if(in_array('074001', $session_data['auth']) || in_array('074002', $session_data['auth']) || in_array('074003', $session_data['auth']) ||
							   in_array('074006', $session_data['auth']) || in_array('074007', $session_data['auth']) || in_array('074008', $session_data['auth'])) {
								echo "
                   					<li style=\"padding-left: 8px;\">
		                                <div class=\"span6\">ภาค</div>
		                                <div class=\"span6\">".$session_data['region_th']."</div>
		                            </li>
            						<li style=\"padding-left: 8px;\">
		                                <div class=\"span6\">สาขา</div>
		                                <div class=\"span6\">".$branchs."</div>
		                            </li>";
							
								 
							}
							
                            ?>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url("authen/logout"); ?>"><i class="icon-exit on-left"></i></a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        
        <span class="element-divider place-right"></span>
     
     	<!-- Plugin Tool -->
		<div class="element-menu m-t-5 animated fadeIn">			
        	<div ui-chat-client="<?php echo $session_data['emp_id']; ?>" direct-chat-click="Profiles" direct-chat-to="<?php echo $session_data['emp_id']; ?>" chat-dialog-position="right" chat-status="chat_state"></div>        	
		</div>
		
    </div>
</div>