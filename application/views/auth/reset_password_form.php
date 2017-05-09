<?php $this->load->view('partials/header');
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
);
$this->load->view('partials/header');
?>
<div class="container">
 <div class="row">
   <div class="col-md-4"></div>
	 <div class="col-md-4">
     <h2>Reset Password</h2>
   </div>
 </div>
 <div class="row">
  <div class="col-md-4"></div>
   <div class="col-md-4">
    <?php echo form_open($this->uri->uri_string()); ?>
      <div class="form-group">
         <label for="<?echo $new_password['id']?>">Password</label>
         <input type="password" class="form-control" id="new_password" name="new_password" maxlength="30" placeholder="Enter Password">
       </div>
       <div class="form-errors"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></div>
       <div class="form-group">
         <label for="<?echo $confirm_new_password['id']?>">Re-type Password</label>
         <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" maxlength="30" placeholder="Enter Password">
       </div>
       <div class="form-errors"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></div>
    <input type="submit" name="change" value="Change Password" class="form-control btn bootstrap_button" />
    <?php echo form_close(); ?>
  </div>
 </div> 
</div>
