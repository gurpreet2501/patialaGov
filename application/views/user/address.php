<?php $this->load->view('partials/header'); ?>
<div class="container">
 <div class="row">
 	<div class="col-xs-3"></div>
 	<div class="col-xs-6">
		<h2>Billing Details</h2>
		<hr/>
		<div class="profile_form">
			 <form action="<?=site_url(site_lang().'/user_details/address')?>" method="post" class="validate">
			  <div class="form-group">
			    <label for="exampleInputEmail1">Name</label>
			    <input type="text" class="form-control required" name="usr_name" placeholder="Name">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputFile">Phone</label>
			    <input type="datetime" class="form-control required" placeholder="Contact No " name="phone">
		    </div>
		    <div class="form-group">
			   <label for="exampleInputFile">Street Address</label>
			   <input type="text" name="street_address" class="form-control required" placeholder="Apartment, Suite, Unit etc" />
		    </div>
		    <div class="form-group">
			   <label for="exampleInputFile">City</label>
			    <input type="text" name="city" class="form-control required"  placeholder="Town/City" />
		    </div>
		    <div class="form-group">
			   <label for="exampleInputFile">Postal Code</label>
			    <input type="text" name="post_code" class="form-control required" placeholder="Post Code / ZIP" />
		    </div>
		    <div class="form-group">
			   <label for="exampleInputFile">Country</label>
			    <input type="text" name="country" class="form-control required" placeholder="Country" />
		    </div>
		    <button type="submit" class="btn btn-default">Pay Now</button>
			</form>
		</div>	
			<br/>

    </div>
    <div class="col-xs-3"></div> 
 </div>
</div>
<?php $this->load->view('partials/footer');?>