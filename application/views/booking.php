<?php $this->load->view('partials/header');?>
<div class="container">
	<div class="row">
		<div class="col-xs-3">
			<?php $this->load->view('partials/leftSidebar'); ?>
		</div>
		<div class="col-xs-6">
				<h2>Book Your Appointment</h2>
						<form method="post" id="booking_form">
						 <!--  <div class="form-group">
						    <label for="exampleInputEmail1">Name</label>
						    <input type="text" class="form-control required" data-msg="Please fill name field"  id="name" name="name" placeholder="Enter your name">
						  </div> -->
						  <!-- <div class="form-group">
						    <label for="email">Email (optional)</label>
						    <input type="email" class="form-control required" data-msg="Please fill email field."  name="email" id="email" placeholder="Enter Email Address">
						  </div> -->
						  <!-- <div class="form-group">
						    <label for="phone">Phone</label>
						    <input type="text" class="form-control required" data-msg="Please fill phone field"  name="phone_no" id="phone" placeholder="Enter Phone No">
						  </div> -->
						  <!-- <div class="form-group">
						    <label for="age">Age</label>
						    <input type="text" class="form-control required" name="age" data-msg="Please fill age field"  id="age" placeholder="Enter Your age">
						  </div> -->
					<!-- 	  <div class="form-group">
						    <label for="gender">Sex</label>
						    <select name="sex" class="form-control required" id="gender" data-msg="Please select your gender.">
						    	<option value="Male">Male</option>
						    	<option value="Female">Female</option>
						    </select>	
						  </div> -->
						  <div class="form-group">
						    <input type="hidden" class="form-control" name="employee_id" value="<?=$empid?>" >
						  </div>
						  <div class="form-group">
						  <label for="datetimepicker1">Choose Date</label>
                <div class='input-group date'>
                    <input type='text' class="form-control required" data-msg="Please enter date" name="date"  id='datetimepicker1' placeholder="Click here to select date and time" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
              <div class="form-group">
						     <label for="timeSlot">Choose Time Slot</label>
                <div class='input-group date'>
                   <select class="form-control required" name="time_slot" id="timeSlot">
                   <?php foreach($tslots as $slot): ?>			
                   		<option value="<?=$slot['id']?>" <?=$slot['disabled'] ? 'disabled' : ''?>><?=$slot['name']?></option>
                   <?php endforeach; ?>		
                   </select>
                </div>
              </div>
              <div class="form-group">
              	<label for="MeetingPurpose">Subject</label>
              	<input type="text" name="subject"  data-msg="Please enter subject field" class="form-control required" />
              </div>
              <div class="form-group">
              	<label for="MeetingPurpose">Meeting Purpose</label>
              	<textarea name="meeting_purpose" class="form-control required" rows="4" id="MeetingPurpose"></textarea>
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