<? $this->load->view('admin/partials/header') ?>
<div class="row">
  <div class="col-lg-12">
    <div>
      <a href="<?=site_url('admin/bookings')?>">Back</a>
    </div>
    <h2>Booking #<?=t($this->uri->segment(3))?></h2>
    <?php echo $output;  ?>
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>