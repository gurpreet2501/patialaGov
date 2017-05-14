<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
  <div class="col-lg-12">
  <?php if(count($bookings)): ?>
    <table class="table table-stripped">
    <tr>
      <th>Person Name</th>
      <th>Email</th>
      <th>Subject</th>
      <th>Meeting Purpose</th>
      <th>Booking Status</th>
      <th>Date</th>
      <th>Timeslot</th>
      <th>Timeslot</th>
    </tr>

<?php foreach ($bookings as $key => $booking):  ?>    
    <tr>
      <td><?=$booking->name?></td>
      <td><?=$booking->email?></td>
      <td><?=$booking->subject?></td>
      <td><?=$booking->meeting_purpose?></td>
      <td><?=$booking->booking_status?></td>
      <td><?=$booking->date?></td>
      <td><?=getTimeSlotName($booking->time_slot)?></td>
      <td width="40%" height="100px">
      <form method="post" id="<?=$key?>">
      <textarea class="form-control feed-back" rows="10" cols="5" name="feedback"></textarea>
      <input type="hidden" name="booking_id" value="<?=$booking->id?>" />
      <input type="hidden" name="user_id" value="<?=user_id()?>" />
      <button type="submit" class="button-danger">Submit Feedback</button>
      </form> 
      </td>
    </tr>
    
<?php endforeach; ?>
    </table>
  <?php else:?>
    <div class="text-center"><h3>No Accepted Bookings Exits</h3></div>
  <?php endif;?>
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>