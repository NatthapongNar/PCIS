<!DOCTYPE html>
<html ng-app="pcis-authen">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PCIS</title>
    <meta name="description" content="">
    <meta name="viewport" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/tcrbank.ico'); ?>" type="image/x-icon">
    
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/responsive.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/animate/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/notifIt/notifIt.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/custom/auth.css'); ?>">
    
    <script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugin/notifIt/notifIt.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
	
	<!-- START INCLUDE CHAT SCRIPT -->
	<script src="<?php echo base_url('js/angular/angular.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-animate.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-sanitize.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/angular-filter.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular/ui-bootstrap-tpls-1.1.2.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/build/collection/collection_script.js'); ?>"></script>	
	<script src="<?php echo base_url('js/build/login.js?v=002'); ?>"></script>	
	<!-- END INCLUDE CHAT SCRIPT -->
	<script>engine=null,"Microsoft Internet Explorer"==window.navigator.appName&&(document.documentMode?engine=document.documentMode:(engine=7,document.compatMode&&"CSS1Compat"==document.compatMode&&(engine=9))),$(function(){$("#ProjectName").addClass("animated pulse"),$("#icon-login").addClass("animated rotateIn")});</script>
</head>
<body>
<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<div ng-controller="ctrlHandled" class="container">

    <article id="login_form">   
	
        <section id="content_form">    
        	<header style="text-align: center;">
		    	<section id="ProjectName">
		    		<h2>Prospect Customer Information System</h2>
		    	</section>
		    	<p style="margin-top: 50px;">Login to your window domain account.</p>
		   	</header>    

            <div id="login_item" class="row">            	
     			<div class="form-signin">
	                <div id="user_bundled" class="input-group" style="margin: 5px auto;">
	                    <span class="input-group-addon" style="background-color: #FFF; border-left: 2px solid #60a917;"><span class="glyphicon glyphicon-user"></span></span>
	                    <input name="username" type="text" ng-model="username" class="form-control" placeholder="Username" autocomplete="off">
	                </div>
	
	                <div id="pass_bundled" class="input-group" style="margin: 5px auto;">
	                    <span class="input-group-addon" style="background-color: #FFF; border-left: 2px solid #60a917;"><span class="glyphicon glyphicon-lock"></span></span>
	                    <input name="password" type="password" ng-model="password" class="form-control" placeholder="Password" autocomplete="off">
	                </div>
	
	                <div ng-click="loginHandled()" class="input-group checkbox col-md-12" style="margin: 5px auto;">
	                    <button id="btnLogin" type="submit" class="btn btn-default btn-sm place-left" style="float: right;">
							LOGIN <span id="icon-login" class="glyphicon glyphicon-log-in"></span>
						</button>
	                </div>
    			</div>
            </div>							
        </section>

		<footer class="footer">
	        <section id="copyright"><small>PCIS<sup>©</sup> 2017 TCRB Lending Branch</small></section>
	    </footer>
        
    </article>
    
</div>

</body>
</html>