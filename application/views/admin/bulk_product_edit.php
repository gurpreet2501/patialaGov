<? $this->load->view('admin/partials/header'); ?>
<div class="row">
  <div class="col-lg-12">
    <form method='post'>
    <? if($flag): ?>
      <div class='alert alert-success'>Products were saved!</div>
    <? endif; ?>
    <div>
    <table class='table table-striped'>
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Stock</th>
        </tr>
      </thead>
      <tbody>
        <? foreach($products as $product): ?>
          <tr>
            <td><?=t($product['product_name']." ({$product['weight']} {$product['weight_unit']})")?></td>
            <td>
              <div class='customer_cat'>Default Price:</div>
              <input  name='products[<?=av($product['id'])?>][price]' 
                        type='text' 
                        class='form-control' 
                        value="<?=av($product['price'])?>" />
                     
            <?php
            
             foreach ($customer_categories as $key => $value):
                echo  "<div class='customer_cat'>". $value['name'] ." Price:</div>";
            ?>
                 
                  <input name='cat_prod_price[<?=av($product['id'])?>][<?=$key?>][price]' 
                          type='text' 
                          class='form-control' 
                          value="<?=!empty($product['customer_category_price'][$key]['price']) ? $product['customer_category_price'][$key]['price'] : '' ?>" /> 
                  <input name='cat_prod_price[<?=av($product['id'])?>][<?=$key?>][customer_category_id]' 
                        type='hidden' 
                        class='form-control' 
                        value="<?=$value['id']?>" /> 
            <?  endforeach;
            ?>  
                        
            </td>
                        
            <td><input  name='products[<?=av($product['id'])?>][stock]'
                        type='text' 
                        class='form-control' 
                        value="<?=av($product['stock'])?>" /></td>
          </tr>
        <? endforeach; ?>
      </tbody>
    </table>
    <div class='text-center'>
      <input type='submit' class='btn btn-lg btn-success' name='__save' value='Save'/>
    </div>
    </form>
    
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>