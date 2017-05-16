<?php $this->load->view('partials/header');?>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
				<h3>Search Employees</h3>
				<form class="form-inline" method="post">
				  <div class="form-group">
				    <!-- <label for="exampleInputEmail2">Email</label> -->
				    <input type="text" class="form-control" name="name" placeholder="Enter name"/>
				  </div>
				  <div class="form-group">
				    <!-- <label for="exampleInputEmail2">Email</label> -->
				    <select name="block" class="form-control">
				    	 <option value=''>--Select Block--</option>
				    	<?php foreach(range('A','Z') as $block): ?>
				    	 <option value="<?=$block?>">Block <?=$block?></option>
				    	<?php endforeach; ?>
				    </select>
				  </div>
				  <div class="form-group">
				    <!-- <label for="exampleInputEmail2">Email</label> -->
				    <select name="room_no" class="form-control">
				    	 <option value=''>--Select Room--</option>
				    	<?php foreach(range(1,20) as $room): ?>
				    	 <option value="<?=$room?>">Room <?=$room?></option>
				    	<?php endforeach; ?>
				    </select>	
				  </div>
				  <div class="form-group">
				    <!-- <label for="exampleInputEmail2">Email</label> -->
				    <select name="department" class="form-control">
				    	 <option value=''>--Select Dept--</option>
				    	<?php foreach($this->config->item('departments') as $dep): ?>
				    	 <option value="<?=$dep?>"><?=$dep?></option>
				    	<?php endforeach; ?>
				    </select>	
				  </div>
				  <button type="submit" class="btn btn-danger">Search</button>
				</form>
				<?php if(count($results)):?>
					<table class="table table-striped">
					  <tr>
					  	<th>Pic</th>
					  	<th>Name</th>
					  	<th>Department</th>
					  	<th>Phone</th>
					  	<th>Block</th>
					  	<th>Room</th>
					  	<th>Select</th>
					  </tr>
						<?php foreach($results as $emp):
						$profilePic = 'avatar.png';
						if(!empty($emp->profile_pic))
							$profilePic = $emp->profile_pic;

						?>	  
					  <tr>
					  	<td  width="10%"><div class="emp-profile-pic text-center"><img src="<?=base_url('images\\').$profilePic?>" width="150px" height="150px"  /></div></td>
					  	<td><?=$emp->full_name?></td>
					  	<td><?=$emp->department?></td>
					  	<td><?=$emp->phone_number?></td>
					  	<td>Block <?=$emp->block?></td>
					  	<td>Room No. <?=$emp->room_no?></td>
					  	<td><a href="<?=site_url("queries/showForm/{$emp->id}")?>"><button class="btn btn-danger">Select</button></a></td>
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