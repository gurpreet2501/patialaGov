
<html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/slider.css')?>">
	<!-- <link rel="stylesheet" type="text/css" href="<?php //base_url('css/date-picker.css') ?>"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php //base_url('css/jquery-ui.css')?>"> -->
	<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('css/style.css')?>">
	<title>Official Website Of District Patiala - Homepage</title>
	       

</head>
<body>
 <div class="container">
<!-- Header starts -->
	<div class="header">
		<div class="row">
			<div class="col-xs-6">
				<a href="<?=site_url()?>"><h1 class="site-title">Official Website Of District Patiala</h1></a>
			</div>
			<div class="col-xs-6">
			<?php if($this->tank_auth->get_user_id()): ?>
				<div class="login_link">
					<a class="btn-danger" href="<?=site_url('queries/submit')?>">Submit Query</a> &nbsp; | &nbsp;
					<a class="btn-danger" href="<?=site_url('queries/show')?>">Query Answers</a> &nbsp; | &nbsp;
					<a class="btn-danger" href="<?=site_url('booking/checkBookings')?>">Check Your Bookings</a>&nbsp; | &nbsp;
					<a class="btn-danger" href="<?=site_url('auth/logout')?>">Logout</a>
				</div>
		<?php else: ?>		
				<div class="login_link"><a class="btn-danger" href="<?=site_url('auth/login')?>">Login</a><a class="btn-danger" href="<?=site_url('auth/register')?>">Register</a></div>
		
		<?php endif; ?>		
				<img src="<?=base_url('images/banner5.jpg')?>"  class="header-img" /> 
				<div id="google_translate_element"></div>
				
				<div class="header-right-img">
					<!-- <img src="<?=base_url('images/pblogo.bmp')?>"  class="header-img-2" />  -->
					
				</div>
			</div>
		</div>
	</div> <!-- header ends -->
	<div class="row">
		<div class="col-xs-12">
		<nav class="navbar navbar-default">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">
			        <li><a href="<?=site_url()?>">Home</a></li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About Patiala <span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><li><a href="<?=site_url()?>/page/introduction">Introduction</a></li>
										<li><li><a href="<?=site_url()?>/page/area">Area</a></li>
										<li><li><a href="<?=site_url()?>/page/climate">Climate</a></li>
										<li><li><a href="<?=site_url()?>/page/sub-divisions">Sub-divisions</a></li>
			          </ul>
			        </li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">History <span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="<?=site_url()?>/page/history-introduction">Introduction</a></li>
										<li><a href="<?=site_url()?>/page/culture-and-tradition">Culture and Tradition</a></li>
										<li><a href="<?=site_url()?>/page/architecture">Architecture</a></li>
										<li><a href="<?=site_url()?>/page/gates-of-patiala">Gates of Patiala	</a></li>
			          </ul>
			        </li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Places to Visit <span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="<?=site_url('page/places-to-visit')?>">Tourist Attractions/Historical Places</a></li>
										<li><a href="<?=site_url('page/eateries')?>">Eateries/Entertainment/Sports</a></li>
										<li><a href="<?=site_url('page/address-of-guest-houses')?>">Address of Guest Houses etc</a></li>
			          </ul>
			        </li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">District Administration <span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="<?=site_url('page/dc-profile')?>">D.C. Profile</a></li>
										<li><a href="<?=site_url()?>/page/role-of-deputy-commissioner">Role of Deputy Commissioner</a></li>
										<li><a href="#">Role of ADC</a></li>
										<li><a href="#">Court Work of Branch Officers</a></li>
										<li><a href="<?=site_url()?>/page/list-of-deputy-commissioner">List of Deputy Commissioners</a></li>
			          </ul>
			        </li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">District Economy <span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="<?=site_url()?>/page/industry">Industry</a></li>
										<li><a href="<?=site_url()?>/page/industry">Agriculture</a></li>
			          </ul>
			        </li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">District At a Glance<span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="<?=site_url()?>/page/demographic-statistics">Demographic Statistics</a></li>
										<li><a href="<?=site_url()?>/page/educational-institutes">Educational Institutes</a></li>
										<li><a href="#">Village Directory</a></li>
			          </ul>
			        </li>

			       
			      </ul>
			     
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
		</div>
	</div>
   <?php if($msg = lako::get('flash')->get('global')):?>
      <div class="alert alert-<?=htmlspecialchars($msg['type'])?>" role="alert">
        <p><?=htmlentities($msg['msg']);?></p>
      </div>
    <?php endif; ?>
<body>
<!-- Header Ends-->