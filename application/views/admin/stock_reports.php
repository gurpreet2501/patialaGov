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
  </div> <!-- col-lg-12 -->
  </div> <!-- row -->
  <hr />
  <div class="row">
    <div class='col-lg-12'>
      <table class="table table-striped">
        <tr>
          <th>Id</th>
          <th>Product Name</th>
          <th>Stock</th>
          <th>Ordered Quantity</th>
          <th>Shipped Quantity</th>
          <th>Pending Shipping</th>
        </tr>
        <?php foreach ($output as $key => $value) :?>
            <tr>
              <td><?=$value['id']?></td>
              <td><?=$value['product_name']?></td>
              <td><?=$value['stock']?></td>
              <td><?=$value['ordered_qty'] ? $value['ordered_qty'] : 0?></td>
              <td><?=$value['shipped_qty'] ? $value['shipped_qty'] : 0?></td>
              <td><?=$value['pending_shipping'] ? $value['pending_shipping'] : 0?></td>
            </tr>
        <?php  endforeach;?>
      </table>
    </div>
  </div>
</div> <!-- container-fluid -->  

</body>
</html>
