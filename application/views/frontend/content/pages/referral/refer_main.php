<style>
span.fa { font-family: FontAwesome !important; }
</style>
<div class="container" style="margin-top: 150px; margin-left: 20%; max-height: 700px;">

	<div class="grid">
		<div class="row">
					
			<?php $session_id = $session_data['emp_id']; ?>
		
			<div <?php if(in_array($session_id, $this->config->item('TLAgentTeam'))) echo 'class="span4"'; else echo 'class="span7"'; ?>>						
				<header><h2 class="subheader animated fadeInUp">MANAGEMENT</h2></header>	
				<a href="<?php echo site_url('referral_control/getTLAMangement'); ?>">
					<div id="reconsile_ncb" class="tile double-vertical double bg-darkCyan">
						<div id="sub_reconsile_ncb" class="tile-content image">
							<i class="icon-accessibility" 
							   style="background: #E3C800;
							   font-size: 7em;
							   color: white;
							   padding: 8px;
							   margin-top: 55px;
							   margin-left: 50px;
							   border-radius: 50%;
							   padding: 20px;">
							</i>
							<div class="brand">
								<span class="label fg-white" style="font-size: 0.9em;">TL MANAGEMENT</span>
							</div>
						</div>					
					</div>
				</a>
			</div>
			
			<div class="span7">						
				<header><h2 class="subheader animated fadeInUp">CROP MANAGEMENT</h2></header>	
				<a href="<?php echo site_url('referral_control/cropSimulator'); ?>" target="_blank">
					<div id="reconsile_ncb" class="tile double-vertical double bg-darkCyan">
						<div id="sub_reconsile_ncb" class="tile-content image">
							<span class="fa fa-crop" 
							   style="background: #E3C800;
							   font-size: 7em;
							   color: white;
							   padding: 8px;
							   margin-top: 55px;
							   margin-left: 50px;
							   border-radius: 50%;
							   padding: 20px;">
							</span>
							<div class="brand">
								<span class="label fg-white" style="font-size: 0.9em;">TL CROP MANAGEMENT</span>
							</div>
						</div>					
					</div>
				</a>
			</div>

			<div <?php if(in_array($session_id, $this->config->item('TLAgentTeam'))) echo 'class="span4"'; else echo 'class="span7"'; ?>>		
				<header><h2 class="subheader animated fadeInUp">REPORT</h2></header>								
				<a href="<?php echo site_url('referral_control/getReferVolume'); ?>">
				<div id="reconsile_doc" class="tile double-vertical double bg-darkCyan">
					<div id="sub_reconsile_doc" class="tile-content image">
						<i class="icon-bars" 
						   style="background: #E3C800;
						   font-size: 7em;
						   color: white;
						   padding: 10px;
						   margin-top: 55px;
						   margin-left: 50px;
						   border-radius: 50%;
						   padding: 20px;"></i>
						<div class="brand">
							<span class="label fg-white" style="font-size: 0.9em;">TL SALES DASHBOARD</span>
						</div>
					</div>					
				</div>
				</a>
			</div>
				
		</div> <!-- row -->
	</div>
	
	<div class="container" style="margin-top: 30px;">
	<?php echo $footer; ?>
	</div>
	
</div>



<script type="text/javascript">

$(function() {

	$('title').text('Referrel Mangement');

	$('#sub_reconsile_ncb').addClass('animated flipInX');
	$('#sub_reconsile_doc').addClass('animated flipInX');
	$('#sub_doc_completion').addClass('animated flipInX');
	$('#sub_doc_return').addClass('animated flipInX');
	$('#sub_defend_management').addClass('animated flipInX');
	$('#sub_defend_viewer').addClass('animated flipInX');

	$('#fttab').remove();

});

</script>
