<?php $this->load->view('partials/header') ?>
<div class="container">
	<div class="row">
		<div class="col-xs-3">
			<?php $this->load->view('partials/leftSidebar') ?>
		</div>
		<div class="col-xs-6">
				<?php $this->load->view('pages/'.$page_name);?>
		</div>
		<div class="col-xs-3">
			<?php $this->load->view('partials/rightSidebar') ?>
		</div>
	</div>
</div>
<?php $this->load->view('partials/footer') ?>