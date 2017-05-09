<?php $this->load->view('partials/header');
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
?>
<div class="container">
 <div class="row">
   <div class="col-md-4"></div>
   <div class="col-md-4"><h4>Send Activation Link Again<h4></div>
 </div>
 <div class="row">
   <div class="col-md-4"></div>
   <div class="col-md-4">
     <?php echo form_open($this->uri->uri_string()); ?>
      <div class="form-group">
          <label for="<?echo $email['id']?>">Email address</label>
          <input type="text" class="form-control" id="email" name="email" value="<?echo set_value('email')?>" maxlength="80" placeholder="Enter Email">
        </div>
       <?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
     <input type="submit" name="submit" value="Send" class="form-control btn bootstrap_button" />   
     <?php echo form_close(); ?>   
    </div>
 </div>

</div>
