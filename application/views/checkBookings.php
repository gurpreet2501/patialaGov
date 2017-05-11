<?php $this->load->view('partials/header'); ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
				<h3>Bookings Details</h3>
				<?php 
			
				 if(count($bookings)): ?>
					<table class="table table-striped">
					  <tr>
					  	<th>Name</th>
					  	<th>Department</th>
					  	<th>Email</th>
					  	<th>Phone No</th>
					  	<th>Designation</th>
					  	<th>Time Slot</th>
					  	<th>Date</th>
					  	<th>Status</th>
					  </tr>
						<?php foreach($bookings as $book):
							$statusClass = 'label label-default';
							if($book['booking_status'] == 'Accepted')
								$statusClass = 'label label-success green';
							else if($book['booking_status'] == 'Canceled')
								$statusClass = 'label label-danger';
						?>	  
					  <tr>
					  	<td><?=$book['employee_details']['full_name']?></td>
					  	<td><?=$book['employee_details']['department']?></td>
					  	<td><?=$book['employee_details']['email']?></td>
					  	<td><?=$book['employee_details']['phone_number']?></td>
					  	<td><?=$book['employee_details']['designation']?></td>
					  	<td><?=$book['time_slot']?></td>
					  	<td><?=$book['date']?></td>
					  	<td><lable class="<?=$statusClass?>"><?=$book['booking_status']?></lable></td>
					  </tr>
						<?php endforeach; ?>  
					</table>
					<?php else: ?>  
							<h3 class="text-center">No Records Found.</h3>
				<?php endif;?>

		</div>
	</div>
</div>
<?php $this->load->view('partials/footer');?>