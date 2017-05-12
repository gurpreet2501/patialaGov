<?php $this->load->view('partials/header');?>
<div class="container">
	<div class="row">
		<div class="col-xs-3">
		<?php $this->load->view('partials/leftSidebar'); ?>
		</div>
		<div class="col-xs-6">
				<h4>Please enter your otp to complete your registration verification</h4>
				<form class="form-inline" method="post">
				  <div class="form-group">
				    <input type="text" class="form-control" id="ds" name="otp" placeholder="Enter 7 Digit Otp">
				  </div>
				  <button type="submit" class="btn btn-danger">Submit</button>
				</form>
				<a href="<?=site_url('otp/resend/'.$user_id)?>">Click here to resend otp</a>
		</div>

		<div class="col-xs-3">
			<?php $this->load->view('partials/rightSidebar'); ?>
		</div>
	</div>
</div>
<?php $this->load->view('partials/footer');?>