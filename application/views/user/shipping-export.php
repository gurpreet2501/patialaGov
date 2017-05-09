<?php
  function filter_bools($val){
      if($val == '1')
        return 'Yes';
      else if($val == '0')
        return 'No';
      else
        return $val;
   } 
 $shipments = $orderModel->shipmentExport()
                         ->with('shippedItems','shippedItems.orderItem')
                         ->orderBy('date','ASC')
                         ->get();
         

?>

<h3 id='shipment-progress'>Export Shipping Progress</h3>
<? foreach($shipments as $shipment):?>
  <div class="row order-row">
    <div class="col-xs-6">
    <br/>
 <hr class="black-line" />
      <h3>
       Shipment Date: <?=htmlentities(date('M d, Y', strtotime($shipment->date)));?>
      </h3>


     <table class='striped table-hover' width="100%" border="1px solid #000" cellpadding="13px">
        <?   
        $shipment_details = $shipment->toarray();
        unset($shipment_details['shipped_items']);
        unset($shipment_details['date']);
        unset($shipment_details['plant_id']);
        unset($shipment_details['created_at']);
        unset($shipment_details['updated_at']);

        foreach($shipment_details as $key => $field): ?>
          <tr>
            <td align='right'>
              <?=ucwords(str_replace('_', ' ', $key)) ?> 
            </td>
            <td align='left'>
            <?=filter_bools($field)?>
            </td>
          </tr>
        <? endforeach; ?>
      </table>

     
      <table class='striped table-hover' style="width:100%;" border="1px solid #000" cellpadding="13px">
        <thead>
          <tr>
            <td align='center'>
                Item
            </td>
            <td align='center'>
                Shipped Qty
            </td>
          </tr>
        </thead>
        <? foreach($shipment->shippedItems as $shippedItem): ?>
          <tr>
            <td align='right'>
              <?= htmlentities($shippedItem->orderItem->product_name) ?> 
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
