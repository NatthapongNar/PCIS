<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PCIS</title>
    <meta name="description" content="">
    <meta name="viewport" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="icon" href="<?php echo base_url('img/logo.ico'); ?>">
    
    <link rel="stylesheet" href="<?php echo base_url('css/responsive/responsive.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/animate/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/custom/auth.css'); ?>">
    
    <script src="<?php echo base_url('js/vendor/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/responsive/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/plugins.js'); ?>"></script>
	<script type="text/javascript">
	            
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
	
	    document.getElementById("uneinit").value = '';
	
	    
	    $(function() { 
	        
	    	 $('#ProjectName').addClass('animated pulse');
	    	 $('#icon-login').addClass('animated rotateIn');
			
	    });
	  
	</script>

</head>
<body>
<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<div class="container">

 	<header style="margin: 200px auto -160px auto; text-align:center;">
    		<section style="color: #666" id="ProjectName"><h2>Prospect Customer Information System</h2></section>
   	</header>
	
    <article id="login_form">
    
        <section id="content_form">
            <header>Login to your window domain account.</header>
            <div class="row">
            
            <?php echo $this->load->library("form_validation"); ?>
			<form method="post" action="<?php echo site_url('auth/logged'); ?>" class="form-signin">

                <div id="user_bundled" class="input-group" style="margin: 5px 0;">
                    <span class="input-group-addon" style="background-color: #FFF; border-left: 2px solid #60a917;"><span class="glyphicon glyphicon-user"></span></span>
                    <input id="uneinit" name="username" type="text" value="<?php echo set_value('username'); ?>" class="form-control" placeholder="Username" autocomplete="off">
                </div>

                <div id="pass_bundled" class="input-group" style="margin: 5px 0;">
                    <span class="input-group-addon" style="background-color: #FFF; border-left: 2px solid #60a917;"><span class="glyphicon glyphicon-lock"></span></span>
                    <input id="pswinit" name="password" type="password" class="form-control" placeholder="Password" autocomplete="off">
                </div>

                <div class="input-group checkbox col-md-12">
                	<!--  
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
					-->
					
                    <button type="submit" class="btn btn-default btn-sm place-left" style="float: right;">
                        LOGIN <span id="icon-login" class="glyphicon glyphicon-log-in"></span>
                    </button>

                </div>
                
			</form>
            <?php echo form_error('username', '<div class="text-warning"><span class="glyphicon glyphicon-exclamation-sign"></span> ', '</div>'); ?>
            <?php echo form_error('password', '<div class="text-warning"><span class="glyphicon glyphicon-exclamation-sign"></span> ', '</div>'); ?>
            <?php
            
            if(!empty($is_errors['status']) == 'false') {
	            switch ($is_errors['types']) {
					case "danger":
						echo '<div class="text-danger" style="width:600px; margin-left: -150px;">
								<span class="glyphicon glyphicon-remove-sign"></span> '.$is_errors['msg'].
							 '</div>';
						break;
					case "incorrect":
					default:
						echo '<div class="text-warning"><span class="glyphicon glyphicon-warning-sign"></span> '.$is_errors['msg'].'</div>';
						break;
				}
			}

            ?>

            </div>

        </section>

        <footer>
            <section id="copyright"><small>2014 &copy; Tcrbank Lending</small></section>
        </footer>

    </article>
    
</div>

</body>
</html>