<?php $this->load->view('partials/header');
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>
<div class="container">
 <div class="row">
   <div class="col-md-4"></div>
	 <div class="col-md-4">
     <h2>Forgot Password</h2>
   </div>
 </div>
 <div class="row"> 
   <div class="col-md-4"></div>
   <div class="col-md-4">
     <?php echo form_open($this->uri->uri_string()); ?>
       <div class="form-group">
          <label for="<?echo $login['id']?>">Email address</label>
          <input type="text" class="form-control" id="login" name="login" value="<?echo set_value('login')?>" maxlength="80" placeholder="Enter Email">
      </div>
      
     <?/* <?php echo form_submit('reset', 'Get a new password'); ?>*/?>
       <input type="submit" name="reset" value="Get a new password" class="form-control btn bootstrap_button btn btn-orange square-btn-adjust" />
     <?php echo form_close(); ?>  
   </div>
 </div>
</div>
