<?php
use App\Models;
use App\Libs\Bootstrap;

$shipments = $orderModel->shipmentDomestic()
                        ->with('shippedItems','shippedItems.orderItem')
                        ->orderBy('date','ASC')
                        ->get();

$shipmentFields = ['handed_over_to_transporter',
                   'dispatched_vehicle_number',
                   'challan_number',
                   'invoice_number'];

?>
<h3 id='shipment-progress'>Domestic Shipping Progress</h3>
<hr />
<?php
 /*
 if(user_role() == 'plant_manager'): ?>
  <div class="text-right desktop-only">
    <a  href="<?=site_url("manage/shipment/domestic/create/{$order['id']}")?>"
        class='btn btn-sm btn-success'>Add new Shipment</a>
  </div>
<? endif; */?>

<? foreach($shipments as $shipment): ?>
  <div class="row order-row">
    <div class="col-xs-6">
    <br/>
  <div class="progress">
    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%; height: 50%">
    </div>
  </div>
      <h3>
        Shipping Date : <?=htmlentities(date('M d, Y', strtotime($shipment->date)))?>
      </h3>
    
      <table class='striped table-hover' border="2px" cellpadding="13px" width="100%">
        <? foreach($shipmentFields as $field): ?>
          <tr>
            <td align='right'>
              <?= htmlentities(str_replace('_',' ',ucwords($field))) ?> :
            </td>
            <td align='left'>
            <?php if($field == 'handed_over_to_transporter'): ?>
                <?=htmlentities($shipment->{$field}) ? 'Yes' : 'No'?>      
            <?php else: ?>  
              <?=htmlentities($shipment->{$field})?>
            <?php endif;?>  
            </td>
          </tr>
        <? endforeach; ?>
      </table>
      <br/>
      <table class='striped table-hover' border="2px" cellpadding="13px" width="100%" align="center">
        <thead>
          <tr>
            <td align='right'>
                <strong>Item</strong>
            </td>
            <td align='left'>
                <strong>Shipped Qty</strong>
            </td>
          </tr>
        </thead>
        <? foreach($shipment->shippedItems as $shippedItem): ?>
          <tr>
            <td align='right'>
              <?= htmlentities($shippedItem->orderItem->product_name) ?> :
            </td>
            <td align='left'>
              <b><?= htmlentities($shippedItem->qty) ?></b>
            </td>
          </tr>
        <? endforeach; ?>
      </table>

    </div>
    <div class="col-xs-8">
    </div>
  </div>
<? endforeach; ?>


<?
  //in case someone else it using it
  unset($orderModel);
?>
