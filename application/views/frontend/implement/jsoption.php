<?php if(!empty($js)): ?>
<?php foreach($js as $javascript): ?>
<?php $str_type = strstr($javascript, ".js"); ?>
<?php $lib_type = ($str_type != '') ? '':'.js'; ?>
<script src="<?php echo base_url('js/' . $javascript) . $lib_type; ?>"></script>
<?php endforeach; ?>
<?php endif; ?>

