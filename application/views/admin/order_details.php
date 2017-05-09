<? $this->load->view('admin/partials/header') ?>
<div class="row">
  <div class="col-lg-12">
  <?php 
  
  		if($order['type'] == 'Export'):
  			$this->load->view('partials/export_order_details', array('order'=> $order)); 
  		else:
  			$this->load->view('partials/order_details', array('order'=> $order)); 
  		endif;
  ?>
  </div>
</div>

<? $this->load->view('admin/partials/footer') ?>
