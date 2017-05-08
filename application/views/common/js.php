<?php 
/*

<script src="<?=base_url('assets/admin/canvas/js/libs/jquery-ui-1.9.2.custom.min.js')?>"></script>
<script src="<?=base_url('assets/admin/canvas/js/plugins/icheck/jquery.icheck.min.js')?>"></script>

<script src="<?=base_url('assets/admin/canvas/js/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('assets/admin/canvas/js/plugins/datatables/DT_bootstrap.js')?>"></script>
<script src="<?=base_url('assets/admin/canvas/js/plugins/tableCheckable/jquery.tableCheckable.js')?>"></script>
<script src="<?=base_url('assets/admin/canvas/js/libs/jquery-1.9.1.min.js')?>"></script>
*/ ?>

<script src="<?=base_url('assets/grocery_crud/js/jquery-1.11.1.min.js')?>"></script>
<script src="<?=base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js')?>"></script>
<script src="<?=base_url('assets/js/init-fancybox.js')?>"></script>
<script src="<?=base_url('assets/js/get_technicians_of_pro.js')?>"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	
<?php
	if(!empty($js_files)):	
	 foreach($js_files as $file): ?>
    <?php if (strpos($file, 'jquery-1.11.1.min.js')) continue; ?>
  <script src="<?= $file; ?>"></script>
<?php endforeach; endif;?>

<script src="<?=base_url('assets/admin/canvas/js/libs/bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/admin/canvas/js/App.js')?>"></script>
 <script>
  $( function() {
    $( ".datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  } );
  </script>