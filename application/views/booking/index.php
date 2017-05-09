<?php  $this->load->view('partials/header'); ?>

	 <section>

		<div class="container">

			<div class="row">

				<div class="col-sm-2">

					<div class="left-sidebar">
						<?php $this->load->view('partials/bookings') ?>

					</div>

				</div>

				<div class="col-sm-10">
        
	  			<div class="features_items"><!--features_items-->
    
            <h2 class="title text-center">Booking #<?=$booking_id?></h2>
            <div class="alert alert-danger" role="alert">
               You have <strong>
                <?php 
                 if(isset($days)){
                    if($days > 0)
                       echo $days;
                    else
                     echo 0;	  
                 }
               ?> 
            </strong> days left to  Complete your Order.

             
            </div> 
            <?php $this->load->view('partials/items-grid',array('data'=>$data,
                                                                'allow_booking'=>$allow_booking,
                                                                'source'=>'booking',
                                                                'disable_buy'=> ($days <= 0))); ?>
          </div>

				</div>

		</div>

		</div>

	</section>

	

	<?php $this->load->view('partials/footer'); ?>



</body>

</html>