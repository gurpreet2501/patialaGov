<?php $role=user_role()?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
<?php 
if(isset($css_files)){
    foreach($css_files as $file): ?>
    	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; 
 }
?>
 <link href="<?=base_url('css/sb-admin.css')?>" rel="stylesheet">
 <script src="<?=base_url('js/jquery-1.10.2.js');?>"></script>
 <script src="<?=base_url('js/bootstrap.min.js');?>"></script>

<?php if(isset($js_files)){ foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; 
}?>

<style type='text/css'>
body
{
	font-family: Arial;
	background: #fff;
	font-size: 14px;
	margin-top: 0px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}

.container-fluid{
  width:1000px;
  padding-right: 25px;
  padding-left: 25px;

}

a:hover
{
	text-decoration: underline;
}
.form-control {
  height: 36px !important;
}
</style>
</head>
<body>
	<div class="container-fluid">
<h3>Order #<?=make_order_id($order['id']); ?></h3> 
<div class="row order-row">
  <div class="col-md-3"><label>Plant</label></div>
  <div class="col-md-9"><?=$order['plant']['full_name']?></div>
</div>
<div class="row order-row">
  <div class="col-md-3"><label>Date</label></div>
  <div class="col-md-9"><?=$order['date']?></div>
</div>
<div class="row order-row">
  <div class="col-md-3"><label>Status</label></div>
  <div class="col-md-9"><?=$order['status']?></div>
</div>
<div class="row order-row">
  <div class="col-md-3"><label>Total Amount</label></div>
  <div class="col-md-9">Rs.<?=$order['total']?></div>
</div>
<div class="row order-row">
  <div class="col-md-3"><label>Booking</label></div>
  <div class="col-md-9">
    <? if($order['booking']): ?>
      <a href="<?=site_url("booking/{$order['booking']}")?>">
        #<?=$order['booking']?>
      </a>
    <? else: ?>
      -
    <? endif; ?>
  </div>
</div>
<?// $this->load->view('partials/order_details_payment_print_details',array('order'=>$order)) ?>
<hr />
<h3>Customer</h3>
<hr />
<div class="row order-row">
  <div class="col-md-9">
    <div class="row">
      <div class="col-md-3"><strong>Name</strong></div>
      <div class="col-md-9"><?=htmlentities($order['users']['full_name'])?></div>
    </div>
    <div class="row">
      <div class="col-md-3"><strong>Email</strong></div>
      <div class="col-md-9"><?=htmlentities($order['users']['email'])?></div>
    </div>
    <div class="row">
      <div class="col-md-3"><strong>Phone Number</strong></div>
      <div class="col-md-9"><?=htmlentities($order['users']['phone_number'])?></div>
    </div>
    <div class="row">
      <div class="col-md-3"><strong>Billing Address</strong></div>
      <div class="col-md-9"><?=nl2br(htmlentities($order['users']['address_line_1']))?></div>
    </div>
    <div class="row row-order">
      <div class="col-md-3"><strong>Shipping Address</strong></div>
      <div class="col-md-9"><?=nl2br(htmlentities($order['users']['address_line_2']))?></div>
    </div>
  </div>
</div>
<hr />
<h3>Items</h3>
<hr />
<div class="row order-row">
  <div class="col-md-12">
     <!-- Internal row division -->
    <? foreach($order['order_items'] as $item): ?>
      
      <?=htmlentities($item['product_name']) ?> 
      (Rs. <?=$item['price']?>) x <?=$item['qty'];?> = Rs. <?= $item['price']*$item['qty'] ?>
     
     <?php $sub_total_discount = 0; ?>  <!-- //Discount Calculatoin -->

       <div class="row">
       	 <div class="col-xs-2"></div>
       	 <div class="col-xs-2"><strong>Discount Title</strong></div>
       	 <div class="col-xs-2"><strong>Discount Type</strong></div>
       	 <div class="col-xs-2"><strong>Discount Amount</strong></div>
       </div>
       <?php foreach ($item['order_discounts'] as $key => $value) { ?>   <!-- taxes calculatuion -->
 
      	 	 <div class="col-xs-2"></div>
      	 	 <div class="col-xs-2"><?=$value['discount_title']?></div>
      	 	 <div class="col-xs-2"><?=$value['discount_type']?></div>
      	 	 <div class="col-xs-2"><?=$value['discount_amount']?></div>
      	 
      	 <br/>
     <?php   $sub_total_discount = $sub_total_discount + $value['discount_amount']; 
        }
      ?>
      <hr/>
     <div class="row">
     	 <div class="col-xs-2"></div>
     	 <div class="col-xs-2"></div>
     	 <div class="col-xs-2"><strong>Discount Sub Total:</strong></div>
     	 <div class="col-xs-2"><strong><?=$sub_total_discount?></strong></div>
     </div>
   <hr/><br/>
   <?php $sub_total_tax = 0; ?>  <!-- //Discount Calculatoin -->

       <div class="row">
       	 <div class="col-xs-2"></div>
       	 <div class="col-xs-2"><strong>Tax Title</strong></div>
       	 <div class="col-xs-2"><strong>Tax Type</strong></div>
       	 <div class="col-xs-2"><strong>Tax Amount</strong></div>
       </div>
       <?php foreach ($item['order_taxes'] as $key => $value) { ?>   <!-- taxes calculatuion -->
 
      	 	 <div class="col-xs-2"></div>
      	 	 <div class="col-xs-2"><?=$value['tax_title']?></div>
      	 	 <div class="col-xs-2"><?=$value['tax_type']?></div>
      	 	 <div class="col-xs-2"><?=$value['tax_amount']?></div>
      	 
      	 <br/>
     <?php   $sub_total_tax = $sub_total_tax + $value['tax_amount']; 
        }
      ?>
      <hr/>
     <div class="row">
     	 <div class="col-xs-2"></div>
     	 <div class="col-xs-2"></div>
     	 <div class="col-xs-2"><strong>Tax Sub Total:</strong></div>
     	 <div class="col-xs-2"><strong><?=$sub_total_tax?></strong></div>
     </div>
   <hr/><br/>
  <? endforeach; ?> 
  </div>
</div>
<hr />
<? if($order['users']['customer_type'] == 'Export'): ?>
  <? $this->load->view('partials/order_details_shipping_print_export', array('order'=>$order)); ?>
<? else: ?>
  <? $this->load->view('partials/order_details_shipping_print_domestic', array('order'=>$order)); ?>
<? endif; ?>
</div>
<script>
  jQuery(document).ready(function(){
    window.print();
  });
</script>
</body>

</html>