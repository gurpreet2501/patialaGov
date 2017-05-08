<div id="content">
	<div class="container top-margins">
	    <div class="row">
	    	<div class="col-md-12">
	    		<form class="form-inline">
		        <div class="form-group">
		          <label class="sr-only" for="from">From Date</label>
		          <input type='text' name='start_date' class="form-control datepicker" placeholder="From Date" value='' />
		        </div>
		        <div class="form-group">
		          - to -
		        </div>
		        <div class="form-group">
		          <label class="sr-only" for="to">To Date</label>
		          <input type='text' name='end_date' class="form-control datepicker" placeholder='To date'
		          value='' />
		        </div>
		        <button type="submit" class="btn btn-success">Generate Report</button>
      		</form>
	    	</div>
	    </div>
	    <br/>
			<div class="row">
					<div class="col-xs-12">
					<h1>Stock Report</h1>
					<table class="table table-condensed">
						<tr>
							<th>Chamber</th>
							<th>Potato Name</th>
							<th>Total Bags</th>
							<th>Dispatch</th>
							<th>Stacker</th>
							<th>Owner</th>
							<th>Contact</th>
							<th>Condition</th>
							<th>Date</th>
						</tr>
				  <?php $total_bags = 0; foreach ($data as $key => $record): 
				   	$total_bags = $total_bags + $record['bags'];
				  ?>
				  	<tr class="<?=$record['dispatch'] ? 'danger' : '' ?>">
				  		<td width="10%"><?=$record['chamber']?></td>
				  		<td><?=$record['name']?></td>
				  		<td><?=$record['bags']?></td>
				  		<td><?=$record['dispatch'] ? $record['dispatch'] : 0?></td>
				  		<td><?=$record['Stacker']?></td>
				  		<td><?=$record['owner']?></td>
				  		<td><?=$record['customer_no']?></td>
				  		<td><?=$record['condition']?></td>
				  		<td><?=$record['date']?></td>
				  	</tr>
					<?php endforeach; ?>
					</table>
					<h2>Total Bags  = <span class="label label-danger"><?=$total_bags?></span></h2>
					
					</div>
				</div> <!-- row ends -->	
	</div>
</div>
