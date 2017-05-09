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
        <input  name='filters[from]' class='form-control col-sm-2 date-input' type='text' placeholder="From Date" 
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
  
  <? if(!$district_report): ?>
    <h1>Welcome! Please select your options from above to generate reports.</h1>
  <? else: ?>
  
    <? foreach($district_report as $district => $report): ?>
      <? if(empty($report)) continue; ?>
      <h2><?=t($district)?></h2>
      <? foreach($report as $category => $cat_report): ?>
        <div class="row">
          <div class="col-md-2"><strong><?=t($category);?></strong></div>
          <div class="col-md-6">
            <table class="table">
              <tr>
                <th>Target</th>
                <th>Sales</th>
                <th>%</th>
              </tr>
              <? foreach($cat_report as $unit => $results): ?>            
                <tr>
                  <td><?=t($results['target'])?> <?=$unit?></td>
                  <td><?=t($results['measures'])?> <?=$unit?></td>
                  <td><?=number_format((floatval($results['measures'])/floatval($results['target'])) * 100,2)?>%</td>
                </tr>
              <? endforeach; ?>
            </table>
          </div>
        </div>
      <? endforeach; ?>
    <? endforeach; ?>
  <? endif; ?>
  <?/*<a href="<?=current_url()?>?download&from=<?=rawurlencode($_GET['from'])?>&to=<?=rawurlencode($_GET['to'])?>" class="btn btn-primary pull-right">
    Download CSV
  */?>
    

  </div>
</div>
</div>
</div>
    </div>
	<div style='height:20px;'></div>  

<?php $this->load->view('admin/partials/footer');?>
</body>
</html>
