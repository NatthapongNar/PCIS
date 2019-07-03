<?php if(!empty($option[0])): ?>
<?php foreach($option as $javascript): ?>
	<?php $str_type = strstr($javascript, ".js"); ?>
	<?php $lib_type = ($str_type != '') ? '':'.js'; ?>
	<script src="<?php echo base_url('js/' . $javascript) . $lib_type; ?>"></script>
<?php endforeach; ?>
<?php endif; ?>

