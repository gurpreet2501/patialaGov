<?php $this->load->view('partials/header');?>
<div class="container">
	<div class="row">
		<div class="col-xs-3">
		<?php $this->load->view('partials/leftSidebar'); ?>
		</div>
		<div class="col-xs-6">
				<h3>Select Employee To Book By Searching In Records</h3>
				<form class="form-inline" method="post">
				  <div class="form-group">
				    <input type="text" class="form-control" id="exampleInputName2" name="emp_name" placeholder="Enter Name to Search">
				  </div>
				  <div class="form-group">
				    <!-- <label for="exampleInputEmail2">Email</label> -->
				    <select name="department" class="form-control">
				    	 <option value=''>--Select--</option>
				    	<?php foreach($this->config->item('departments') as $dep): ?>
				    	 <option value="<?=$dep?>"><?=$dep?></option>
				    	<?php endforeach; ?>

				    </select>	
				  </div>
				  <button type="submit" class="btn btn-danger">Search</button>
				</form>
				<?php if(count($results)): ?>
					<table class="table table-striped">
					  <tr>
					  	<th>Name</th>
					  	<th>Department</th>
					  	<th>Phone</th>
					  	<th>Select</th>
					  </tr>
						<?php foreach($results as $emp):?>	  
					  <tr>
					  	<td><?=$emp->full_name?></td>
					  	<td><?=$emp->department?></td>
					  	<td><?=$emp->phone_number?></td>
					  	<td><a href="<?=site_url("booking/index/{$emp->id}")?>"><button class="btn btn-danger">Select</button></a></td>
					  </tr>
						<?php endforeach; ?>  
					</table>
					<?php else: ?>  
							<h3 class="text-center">No Records Found.</h3>
				<?php endif;?>

		</div>

		<div class="col-xs-3">
			<?php $this->load->view('partials/rightSidebar'); ?>
		</div>
	</div>
</div>
<?php $this->load->view('partials/footer');?>