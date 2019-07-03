<?php if(!empty($css)):
foreach($css as $stylesheet): ?>
<?php $str_type = strstr($stylesheet, ".css"); ?>
<?php $lib_type = ($str_type != '') ? '':'.css'; ?>
<link href="<?php echo base_url('css/'.$stylesheet) . $lib_type; ?>" rel="stylesheet">
<?php endforeach; ?>
<?php endif; ?>
