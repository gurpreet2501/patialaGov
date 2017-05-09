<?php $this->load->view('partials/header'); ?>
 <div class="row">
 	<div class="col-xs-3"></div>
 	<div class="col-xs-6">
 		 <?php $update_msg = lako::get('flash')->get('details_updated');
			     if(!is_null($update_msg)):?>
			        <div class="alert alert-success" role="alert"><p><?=htmlentities($update_msg);?></p></div>
			    <?endif;?> 
		<h2>Update Your Billing Details</h2>
		<hr/>
		<? if(!empty($user_data)){?>
		<div class="profile_form">
			 <form action="<?=site_url(site_lang().'/user_details/account')?>" method="post" class="validate">
		    <div class="form-group">
			   <label for="exampleInputFile">Street Address</label>
			   <input type="text" name="street_address" class="form-control required" placeholder="<?=$user_data['street_address']?>" />
		    </div>
		    <div class="form-group">
			   <label for="exampleInputFile">City</label>
			    <input type="text" name="city" class="form-control required"  placeholder="<?=$user_data['city']?>" />
		    </div>
		    <div class="form-group">
			   <label for="exampleInputFile">Postal Code</label>
			    <input type="text" name="post_code" class="form-control required" placeholder="<?=$user_data['post_code']?>" />
		    </div>
		    <div class="form-group">
			   <label for="exampleInputFile">Country</label>
			    <input type="text" name="country" class="form-control required" placeholder="<?=$user_data['country']?>" />
		    </div>
		    <div class="update_buttons clearfix">
	         <div class="smit_btn">
	            <button type="submit" class="btn btn-default">Update</button>
	         </div>
		    	 <div class="continue">
	            <a href='<?=site_url(site_lang().'/')?>'><button type="button" class="btn btn-default">Continue</button></a>
	         </div>
		     </div>
		  	</form>
		  </div>
   
	 <? }else{?>
        <div class="nothing_found"><h3 class="text-center">No Billing Information Found</h3></div>
	 	<?}?>
			<br/>
    </div> 
    
    <div class="col-xs-3"></div> 
 </div>
<?php $this->load->view('partials/footer');?>