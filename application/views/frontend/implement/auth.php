<script>	

	<?php 
	if(in_array($session_data['emp_id'], $this->config->item('Administrator'))):
		$set_uri = site_url('report/gridDataList').'?_='.md5(date('s')).'&rel='.$session_data["emp_id"].'&editor='.md5('true').'&permission='.md5('true');
	else:
		$set_uri = site_url('report/gridDataList').'?_='.md5(date('s')).'&rel='.$session_data["emp_id"].'&editor='.md5('false').'&permission='.md5('false');
	endif;
	?>
	var objAuth = '<?php echo $set_uri; ?>';

</script>	