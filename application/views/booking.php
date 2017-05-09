<?php $this->load->view('partials/header');?>
<div class="container">
	<div class="row">
		<div class="col-xs-3">
		<?php $this->load->view('partials/leftSidebar'); ?>
		</div>
		<div class="col-xs-6">
				<h2>Book Your Appointment</h2>
						<form method="post">
						  <div class="form-group">
						    <label for="exampleInputEmail1">Name</label>
						    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">Email (optional)</label>
						    <input type="email" class="form-control" name="email" id="exampleInputPassword1" placeholder="Enter Email Address">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">Phone</label>
						    <input type="text" class="form-control" name="phone_no" id="exampleInputPassword1" placeholder="Enter Phone No">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">Age</label>
						    <input type="text" class="form-control" name="age" id="exampleInputPassword1" placeholder="Enter Your age">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">Sex</label>
						    <select name="sex" class="form-control">
						    	<option value="Male">Male</option>
						    	<option value="Female">Female</option>
						    </select>	
						  </div>
						  <div class="form-group">
						    <input type="hidden" class="form-control" name="employee_id" value="<?=$empid?>" id="exampleInputPassword1">
						  </div>
						  <div class="form-group">
						  <label for="exampleInputPassword1">Choose Date</label>
                <div class='input-group date'>
                    <input type='text' class="form-control" name="date"  id='datetimepicker1' placeholder="Click here to select date and time" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
              <div class="form-group">
						     <label for="exampleInputPassword1">Choose Time Slot</label>
                <div class='input-group date'>
                   <select class="form-control" name="time_slot">
                   <option >--Select--</option>
                   <?php foreach($tslots as $slot): ?>			
                   		<option value="<?=$slot->id?>"><?=$slot->name?></option>
                   <?php endforeach; ?>		
                   </select>
                </div>
              </div>
              <div class="form-group">
              	<label for="exampleInputPassword1">Meeting Purpose</label>
              	<textarea name="meeting_purpose" class="form-control" rows="4"></textarea>
              </div>
						  <button type="submit" class="btn btn-danger">Submit</button>
						</form>	
		</div>
		<div class="col-xs-3">
			<?php $this->load->view('partials/rightSidebar'); ?>
		</div>
	</div>
</div>
<?php $this->load->view('partials/footer');?>