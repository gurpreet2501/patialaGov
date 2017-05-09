<?php $this->load->view('admin/partials/header');?>
<div id="page-wrapper">
<div class="container-fluid">
<div class="row">
  <div class="col-lg-12">
  <hr />
  <div class='filters'>
    <form class='form'>
    <div class='row'>
      <div class="col-sm-2">
        <input name='filters[from]' class='form-control col-sm-2 date-input' type='text' placeholder="From Date" 
          value="<?=av(isset($_GET['filters']['from'])?$_GET['filters']['from']:'')?>" />
      </div>
      <div class="col-sm-1 text-center">- TO -</div>
      <div class="col-sm-2">
        <input name='filters[to]' class='form-control col-sm-2 date-input' type='text' placeholder="To Date" 
          value="<?=av(isset($_GET['filters']['to'])?$_GET['filters']['to']:'')?>" />
      </div>
      
      <div class="col-sm-2">
        <input class="btn btn-primary" type='submit' value="Generate Report" />
      </div>
    </div>
    </form>
  </div>
  <hr />
  
  <? if(!isset($_GET['from'])): ?>
    <h1>Welcome! Please select your options from above to generate reports.</h1>
  <? elseif(empty($orders)): ?>
    <h1>No orders for selected time period.</h1>
  <? else: ?>
    <a href="<?=current_url()?>?download&from=<?=rawurlencode($_GET['from'])?>&to=<?=rawurlencode($_GET['to'])?>" class="btn btn-primary pull-right">
      Download CSV
    </a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>&nbsp;</th>
        <? foreach($cats as $cat): ?>
          <th colspan="3" class='text-center'><?=t($cat['category_name']) ?></th>
        <? endforeach; ?>
      </tr>
      <tr>
        <th>&nbsp;</th>
        <? foreach($cats as $cat): ?>
          <th class=''>Target</th>
          <th class=''>Sales</th>
          <th class=''>%</th>
        <? endforeach; ?>
      </tr>
      
    </thead>
    <tbody>
      <? foreach($report as $row): ?>
        <tr>
          <td><?=t($row['district_name'])?></td>
          <? foreach($row['categories'] as $category): ?>
            <? foreach($category as $num): ?>
              <td><?=t($num)?></td>
            <? endforeach; ?>
          <? endforeach; ?>
        </tr>
      <? endforeach; ?>
      <tr>
      </tr>
    </tbody>
  </table>
  <? endif; ?>
  
  
  
  
  </div>
</div>
</div>
</div>
    </div>
	<div style='height:20px;'></div>  

<?php 
if(isset($css_files)){
  foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo av($file); ?>" />
  <?php endforeach; 
}

?>

</body>
</html>
