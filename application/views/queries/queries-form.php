<?php $this->load->view('partials/header');?>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
				<h3>Post Your Query</h3>
				<form  method="post" id="booking_form">
				  <div class="form-group">
				    <input type="hidden" name="employee_id" value="<?=$emp_id?>" >
				    <input type="hidden" class="form-control" name="user_id" value="<?=user_id()?>" >
				    <textarea rows="10" name="question" placeholder="Ask Your Question...." class="form-control required"></textarea>
				  </div>
				  <button type="submit" class="btn btn-danger">Submit</button>
		</div> <!-- col-xs-12 -->
	</div>
</div>
<?php $this->load->view('partials/footer');?>