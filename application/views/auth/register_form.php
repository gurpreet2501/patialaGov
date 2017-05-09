<?php $this->load->view('partials/header');
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>

<div class="auth__forms_container">
  <div class="auth_forms">
   <div class="row">
     <div class="col-md-1">
     </div>
     <div class="col-md-10">
      <h2>Register</h2>
     </div>
     <div class="col-md-1"></div>
   </div>
   <div class="row">
     <div class="col-md-1"></div>
     <div class="col-md-10">
       <!--Registration Form-->
      <?php echo form_open($this->uri->uri_string()); ?>
        <?php if ($use_username) { ?>
          <div class="form-group">
            <label for="<?=$username['id']?>">Username</label>
            <input type="text" name="username" class="form-control required" id="username" value="<?=set_value('username');?>" placeholder="Enter username">
            <?php if(isset($errors[$username['name']])):?>
            <div class="form-errors">
              <?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?>
            </div>
           <?php endif; ?> 
          </div>
        <?php } ?>
         <div class="form-group">
            <label for="<?=$email['id']?>">Email</label>
            <input type="text" name="email" class="form-control required" id="email" value="<?=set_value('email');?>" placeholder="Enter Email">
        <?php if(isset($errors[$email['name']])):?>
            <div class="form-errors">
             <?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
            </div>
          <?php endif;?>  

          </div>
          <div class="form-group">
            <label for="<?=$password['id']?>">Password</label>
            <input type="password" name="password" class="form-control required" maxlength="<?=$this->config->item('password_max_length', 'tank_auth')?>" id="password" value="<?=set_value('password');?>" placeholder="Enter Password">
           <div class="form-errors password">
              <?php echo form_error($password['name']); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="<?=$password['id']?>">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control required" id="confirm_password" value="<?=set_value('confirm_password');?>" placeholder="Re-type Password">
            <div class="form-errors password">
              <?php echo form_error($confirm_password['name']); ?>
            </div>
          </div>
         <div class="form-group">
            <label for="name">Customer Full Name</label>
            <input type="text" name="full_name" class="form-control required" id="fulname" value="<?=isset($_POST['full_name'])? $_POST['full_name'] : ''?>" placeholder="Enter Your Name">
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" name="phone_number" class="required form-control" id="phone" value="<?=isset($_POST['phone_number'])? $_POST['phone_number'] : ''?>" placeholder="Enter Your Contact No">
          </div>
          <div class="form-group">
            <label for="add">Address Line 1</label>
            <input type="text" name="address_line_1" class="required form-control" id="bili_add" value="<?=isset($_POST['address_line_1'])? $_POST['address_line_1'] : ''?>" placeholder="Enter Your Billing Address">
          </div>
          <div class="form-group">
            <label for="address">Address Line 2</label>
            <input type="text" name="address_line_2" class="required form-control" id="ship_add" value="<?=isset($_POST['address_line_2'])? $_POST['address_line_2'] : ''?>" placeholder="Enter Your Shipping Address">
          </div>
          <?php $this->load->helper('get_data'); ?>
          <div class="form-group">
            <label for="District">Country</label>
            <select name="country" class="form-control"> 
               <?php foreach(get_countries() as $val): ?>
            	 <option value="<?=$val['id']?>"><?=$val['country']?></option>
            	 <?php endforeach;  ?> 
            </select>
          </div>
          <div class="form-group">
            <label for="District">State</label>
            <select name="state" class="form-control"> 
               <?php foreach(get_states() as $val): ?>
            	 <option value="<?=$val['id']?>"><?=$val['state_name']?></option>
            	 <?php endforeach;  ?> 
            </select>
          </div>
          <div class="form-group">
            <label for="address">City</label>
            <input type="text" name="city" class="required form-control" id="ship_add" value="<?=isset($_POST['city'])? $_POST['city'] : ''?>" placeholder="Enter Your Shipping Address">
          </div>
          <div class="form-group">
            <label for="District">District</label>
            <select name="district" class="form-control"> 
               <?php foreach(get_districts() as $val): ?>
               <option value="<?=$val['id']?>"><?=$val['district_name']?></option>
               <?php endforeach;  ?> 
            </select>
          </div>
          
          <div class="form-group">
            <label for="District">Select Type</label>
            <select name="customer_type" class="form-control"> 
            	 <option value="Domestic">Domestic</option>
               <option value="Export">Export</option>
            </select>
          </div>

          
          <!-- <select type="hidden" name="customer_type" value='Domestic' /> -->

				<input type="submit" name="register" value="Register" class=" register-btn  form-control btn bootstrap_button btn btn-orange square-btn-adjust" />
       <?php echo form_close(); ?>
     </div>  
     <div class="col-md-1"></div>
  </div>
 </div> 
</div>
<?php $this->load->view('partials/auth_footer');?>