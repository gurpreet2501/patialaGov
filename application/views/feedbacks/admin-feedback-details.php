<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
  <div class="col-xs-12">
    <a href="<?=site_url('admin/feedbacks')?>"><button class="btn btn-danger">Back</button></a>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
<?php foreach ($feedbacks as $key => $feedback): ?>    
  <h3>Feedback</h3>
    <div class="feedback-box">
      <div class="alert alert-success"><?=$feedback->feedback?></div>
    </div>
    <div class="details">
        <h3>Employee Details</h3>
        <ul class="list-group">
          <li class="list-group-item">Emp Name: <?=$feedback->employee->full_name?></li>
          <li class="list-group-item">Phone No.: <?=$feedback->employee->phone_number?></li>
          <li class="list-group-item">Designation: <?=$feedback->employee->designation?></li>
          <li class="list-group-item">Block: <?=$feedback->employee->block?></li>
          <li class="list-group-item">Room No.: <?=$feedback->employee->room?></li>
          <li class="list-group-item">Department: <?=$feedback->employee->department?></li>
          </ul>
        </div>
  <div class="details">
    <h3>User Details</h3>
      <ul class="list-group">
        <li class="list-group-item">Person Name: <?=$feedback->booking->name?></li>
        <li class="list-group-item">Email: <?=$feedback->booking->email?></li>
        <li class="list-group-item">Subject: <?=$feedback->booking->subject?></li>
        <li class="list-group-item">Meeting Purpose: <?=$feedback->booking->meeting_purpose?></li>
        <li class="list-group-item">Booking Status: <?=$feedback->booking->booking_status?></li>
        <li class="list-group-item">Date: <?=$feedback->booking->date?></li>
        <li class="list-group-item">Timeslot: <?=getTimeSlotName($feedback->booking->time_slot)?></li>
        </ul>
    </div>    
       
<?php endforeach; ?>

  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>