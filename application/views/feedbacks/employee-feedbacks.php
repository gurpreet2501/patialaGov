<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
  <div class="col-lg-12">
  <?php if(count($feedbacks)): ?>
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
      <td width="30%"><div class="alert alert-success"><?=$feedback->feedback?></div></td>
    </tr>
    
<?php endforeach; ?>
    </table>
  <?php else: ?>
    <div class="text-center">No Records Found.</div>
  <?php endif; ?>
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>