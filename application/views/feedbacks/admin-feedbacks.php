<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
  <div class="col-lg-12">
    <table class="table table-stripped">
    <tr>
      <th>Person Name</th>
      <th>Email</th>
      <th>Subject</th>
      <th>Meeting Purpose</th>
      <th>Booking Status</th>
      <th>Date</th>
      <th>Timeslot</th>
      <th>Feedback</th>
    </tr>

<?php foreach ($feedbacks as $key => $feedback):
    if(!isset($feedback->booking)){
      continue;
    }
 ?>    
    <tr>
      <td><?=$feedback->booking->name?></td>
      <td><?=$feedback->booking->email?></td>
      <td><?=$feedback->booking->subject?></td>
      <td><?=$feedback->booking->meeting_purpose?></td>
      <td><?=$feedback->booking->booking_status?></td>
      <td><?=$feedback->booking->date?></td>
      <td><?=getTimeSlotName($feedback->booking->time_slot)?></td>
      <td>
        <a href="<?=site_url('admin/feedbackDetails/'.$feedback->id)?>"><button class="alert alert-success">Details</button></a>
      </td>
    </tr>
  
    <div class="spacer"></div>
<?php endforeach; ?>
    </table>
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>