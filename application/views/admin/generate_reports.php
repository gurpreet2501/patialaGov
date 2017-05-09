<div class="container">
	<h3 class="title">Select month to generate report</h3>
	<div class="row">
	 <div class="col-xs-3">Select Month</div>
	 <div class="col-xs-3">Select Year</div>
	</div>
	
	<div class="row">
	 <div class="col-xs-3"> 
	 	<form>
	 	<select class="form-control" name="month">
	 	<?php 
       
	 	   $months = array('01' => "Jan", '02' => "Feb", '03' => "Mar", '04' => "Apr", '05' => "May", '06' => "Jun", '07' => "Jul", '08' => "Aug", '09' => "Sep", '10' => "Oct", '11' => "Nov", '12' => "Dec");

          foreach ($months as $key => $value): ?>
           	<option value="<?=$key?>"><?=$value?></option>
      <?php endforeach  ?> 
    </select>
	 </div>
	 <div class="col-xs-3">
	 	<select class="form-control" name="year">
	 	<?php 
       for($i=date("Y"); $i > date("Y")-5; $i--): ?>
       	<option value="<?=$i?>"><?=$i?>
      <?php endfor; ?> 
    </select>
   
	 </div>
	 <div class="col-xs-3"><input type="submit" value="Generate Report" class="btn btn-default" /></div>
   </form>	
	</div>
	<div class="row">
		 <div class="col-xs-12">
 	  <?php 
 	     if(!empty($data)){
 	     	$summary =array();
 	      ?>
 	 	    <table>
 	 	    	<?php foreach($data as $key => $val): echo "<pre>";
 	 	    	 
 	 	    	foreach ($val['order_items'] as $key => $oitem):
 	 	    	

	    	  $summary[$val['users']['district']['district_name']] =  $val['users']['district']['district_name']; 
	    	  if(!empty($oitem['products']['district_target']))
	    	  {
	    	  	 
	          $summary[$val['users']['district']['district_name']]['cat'] = $oitem['products']['district_target']['category'];
	          
	          $summary[$val['users']['district']['district_name']] = $oitem['products']['district_target']['target'];
	         } 

 	 	    	  endforeach;  
 	 	    	
 	 	    
 	 	    	?>
 	 	              
 	 	    <?php endforeach;  ?>	 
 	 	    </table>  
 	  <?php  print_r($summary);
 	}   
      echo "<pre>";
      
      exit;
 	   ?>
		 </div>
	</div>
</div>  <!-- Container ends -->