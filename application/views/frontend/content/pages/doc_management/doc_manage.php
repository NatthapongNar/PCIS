<div class="container" style="margin-top: 150px;">

	<div class="grid">
		<div class="row">
		
			<div class="span7">
			
				<header><h2 class="subheader animated fadeInUp">DOCUMENT MANAGEMENT</h2></header>
			
				<a href="<?php echo site_url('metro/fnReconcileNCB'); ?>">
				<div id="reconsile_ncb" class="tile double-vertical double bg-lime">
					<div id="sub_reconsile_ncb" class="tile-content image">
						<i class="icon-drawer-2" 
						   style="background: #666;
						   font-size: 7em;
						   color: white;
						   padding: 8px;
						   margin-top: 70px;
						   margin-left: 65px;
						   border-radius: 50%">
						</i>
					</div>
					<div class="brand">
						<span class="label fg-white" style="font-size: 0.9em;">NCB Consent</span>
						<!-- <span id="reconsile_ncb_badge" class="badge bg-orange">-</span> -->
					</div>
				</div>
				</a>
				
				<a href="<?php echo site_url('reconcile/vwAppManagement'); ?>">
				<div id="reconsile_doc" class="tile double-vertical double bg-amber">
					<div id="sub_reconsile_doc" class="tile-content image">
						<i class="icon-files" 
						   style="background: #666;
						   font-size: 7em;
						   color: white;
						   padding: 10px;
						   margin-top: 70px;
						   margin-left: 70px;
						   border-radius: 50%"></i>
					</div>
					<div class="brand">
						<span class="label fg-white" style="font-size: 0.9em;">Application Management</span>
						<!-- <span id="reconsile_doc_badge" class="badge bg-orange">-</span> -->
					</div>
				</div>
				</a>
				 
			</div>
			
			<div class="span7">
		
				<header><h2 class="subheader animated fadeInUp">DEFEND MANAGEMENT</h2></header>
								
				<a href="<?php echo site_url('reconcile/getDefendDashboard'); ?>">
				<div id="defend_management_viewer" class="tile double-vertical double bg-darkCyan">
					<div id="sub_defend_viewer" class="tile-content image">
						<i class="icon-diamond" 
						   style="background: #666;
						   font-size: 7em;
						   color: white;
						   padding: 8px;
						   margin-top: 70px;
						   margin-left: 65px;
						   border-radius: 50%">
						</i>
					</div>
					<div class="brand">
						<span class="label fg-white" style="font-size: 0.9em;">Defend Management</span>
						<!-- <span id="reconsile_ncb_badge" class="badge bg-orange">-</span> -->
					</div>
				</div>
				</a>
				
				
			</div>
			
		<?php 
		/*
		
		if(in_array('074001', $session_data['auth']) && $session_data['branchcode'] == '000' || in_array('074002', $session_data['auth']) || in_array('074003', $session_data['auth']) || in_array('074004', $session_data['auth']) ||
		   in_array('074005', $session_data['auth']) || in_array('074006', $session_data['auth']) || in_array('074007', $session_data['auth']) || in_array('074008', $session_data['auth'])) {

				$site	= site_url('reconcile/getDefendDashboard');
				
				echo '
				<div class="span7">
		
				<header><h2 class="subheader">DEFEND MANAGEMENT</h2></header>

				<a href="'.$site.'">
				<div id="defend_management" class="tile double-vertical double bg-darkCyan">
					<div id="sub_defend_management" class="tile-content image">
						<i class="icon-diamond" 
						   style="background: #666;
						   font-size: 7em;
						   color: white;
						   padding: 8px;
						   margin-top: 70px;
						   margin-left: 65px;
						   border-radius: 50%">
						</i>
					</div>
					<div class="brand">
						<span class="label fg-white" style="font-size: 0.9em;">Defend Dashboard</span>
						<!-- <span id="reconsile_ncb_badge" class="badge bg-orange">-</span> -->
					</div>
				</div>
				</a>
				
				</div>';
				
				
			}
		*/			
		?>

			
			
			
		</div> <!-- row -->
	</div>
	
</div>
