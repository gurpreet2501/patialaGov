<html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/slider.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
		<title>Official Website Of District Patiala - Booking</title>
	</head>
</head>
<body>
 <div class="container">
<!-- Header starts -->
	<div class="header">
		<div class="row">
			<div class="col-xs-8">
				<a href="index.html"><h1 class="site-title">Official Website Of District Patiala</h1></a>
			</div>
		
			<div class="col-xs-4">
				<div class="header-right-img">
					<img src="images/pblogo.bmp"  class="header-img-2" /> 
					<img src="images/banner5.jpg"  class="header-img" /> 
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
			        <li><a href="index.html">Home</a></li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About Patiala <span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="#">Introduction</a></li>
										<li><a href="#">Area</a></li>
										<li><a href="#">Climate</a></li>
										<li><a href="#">Sub-divisions</a></li>
			          </ul>
			        </li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">History <span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="#">Introduction</a></li>
										<li><a href="#">Culture and Tradition</a></li>
										<li><a href="#">Architecture</a></li>
										<li><a href="#">Gates of Patiala	</a></li>
			          </ul>
			        </li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Places to Visit <span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="#">Tourist Attractions/Historical Places</a></li>
										<li><a href="#">Eateries/Entertainment/Sports</a></li>
										<li><a href="#">Address of Guest Houses etc</a></li>
			          </ul>
			        </li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">District Administration <span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="#">D.C. Profile</a></li>
										<li><a href="#">Role of Deputy Commissioner</a></li>
										<li><a href="#">Role of ADC</a></li>
										<li><a href="#">Court Work of Branch Officers</a></li>
			          </ul>
			        </li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">District Economy <span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="#">Industry</a></li>
										<li><a href="#">Agriculture</a></li>
			          </ul>
			        </li>
			        <li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">District At a Glance<span class="caret"></span></a>
			          <ul class="dropdown-menu">
										<li><a href="#">Demographic Statistics</a></li>
										<li><a href="#">Educational Institutes</a></li>
										<li><a href="#">Village Directory</a></li>
			          </ul>
			        </li>
			       </ul>
			     
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
		</div>
	</div>

<!-- Header Ends-->
 
		<div class="row">
		<!-- Left Column -->
			<div class="col-xs-3">
				<h3>Website Seach</h3>
					<div class="search-box clearfix">
						 <form class="navbar-form navbar-left">
				        <div class="form-group">
				          <input type="text" class="form-control" placeholder="Search">
				        </div>
			      	</form>
					</div>
					<div class="sp-20"></div>
					<ul class="list-group">
						<li class="list-group-item"><a href="http://patiala.gov.in/4135.pdf">Credibility of Electronic Voting Machines </a><span class="label label-danger">PDF</span></li>
						<li class="list-group-item">Patiala Polling Stations</li>
						<li class="list-group-item">Vidhan Sabha Election 2012 Result</li>
						<li class="list-group-item">Right To Information ACT</li>
						<li class="list-group-item">National Voter's Service Portal (NVSP)</li>
						<li class="list-group-item">District Survey Report</li>
					</ul>
				
				<h3>Important Links</h3>
				<ul class="list-group">
					  <li class="list-group-item">DevelopmentStories</li>
					  <li class="list-group-item">Picture Gallery</li>
					  <li class="list-group-item">PbGovtWebsites</li>
					  <li class="list-group-item">Punjab Districts</li>
					  <li class="list-group-item">Patiala offices</li>
					  <li class="list-group-item">GOI Offices</li>
					  <li class="list-group-item">News Channels</li>
					  <li class="list-group-item">Maps</li>
					  <li class="list-group-item">Contact Numbers</li>
				    <li class="list-group-item">Child Line Patiala</li>
				</ul>
				<!-- ---------------------- -->
			</div>
		<!-- Left Column ends-->
		<!-- Content Area -->
			<div class="col-xs-6">
					<div class="main">
					<br/>
					<h2>Book Your Appointment</h2>
						<?php 
							if(!empty($_POST)):
									$fp = fopen('bookings.csv', 'a');
									fputcsv($fp, $_POST);
									fclose($fp);
							endif;	
						?>
						<?php if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['date_time'])):?>
							<div class="alert alert-success" role="alert">Your booking saved successfully.</div>
						<?php endif;?>	
							
						<form method="post">
						  <div class="form-group">
						    <label for="exampleInputEmail1">Name</label>
						    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">Email (optional)</label>
						    <input type="email" class="form-control" name="email" id="exampleInputPassword1" placeholder="Enter Email Address">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">Phone</label>
						    <input type="text" class="form-control" name="phone" id="exampleInputPassword1" placeholder="Enter Phone No">
						  </div>
						  <div class="form-group">
						  <label for="exampleInputPassword1">Choose Date and Time</label>
                <div class='input-group date'>
                    <input type='text' class="form-control" name="date_time"  id='datetimepicker1' placeholder="Click here to select date and time" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
						  <button type="submit" class="btn btn-danger">Submit</button>
						</form>	
					</div> <!-- main block ends -->			
			</div>
		<!-- Content Area Ends-->
		<!-- Right Column -->
			<div class="col-xs-3 text-center">
					
			<div class="panel-group" role="tablist">
		    <div class="panel panel-default">
		        <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
		            <h4 class="panel-title"> <a href="#collapseListGroup1" class="" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseListGroup1">District Health</a> </h4> </div>
		         <div class="panel-collapse collapse in" role="tabpanel" id="collapseListGroup1" aria-labelledby="collapseListGroupHeading1" aria-expanded="true">
		            <ul class="list-group">
										<li class="list-group-item">Health Profile</li>
										<li class="list-group-item">Distt Blindness Control Society</li>
										<li class="list-group-item">Revised National TB Control Programme</li>
										<li class="list-group-item">Blood Donors of the District</li>
		            </ul>
		        </div>
		    </div>
		    <div class="panel panel-default">
		        <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
		            <h4 class="panel-title"> <a href="#collapseListGroup1" class="" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseListGroup1">Public Utility Services </a> </h4> </div>
		         <div class="panel-collapse collapse in" role="tabpanel" id="collapseListGroup1" aria-labelledby="collapseListGroupHeading1" aria-expanded="true">
		            <ul class="list-group">
											<li class="list-group-item">About Suwidha</li>
											<li class="list-group-item">Public Utility Forms</li>
											<li class="list-group-item">Passport Status</li>
											<li class="list-group-item">BPL Data</li>
											<li class="list-group-item">Social Security Pensioner's Status</li>
											<li class="list-group-item">ICDS Schemes Data</li>
											<li class="list-group-item">Service Area Plan (Bank)</li>
											<li class="list-group-item">E-Governance at Patiala</li>
		            </ul>
		            
		        </div>
		    </div>
			</div>

					
			</div>
		<!-- Right Column Ends-->
	</div>
<div class="row">
	<div class="col-xs-12">
		<div class="col-xs-2"><a href="#"><img src="images/cashless.jpg" class="zoom-in" /></div></a>
		<div class="col-xs-2"><a href="#"><img src="images/ceo.jpg" class="zoom-in" /></div></a>
		<div class="col-xs-2"><a href="#"><img src="images/sideabar-ad.jpg" class="zoom-in" /></div></a>
		<div class="col-xs-2"><a href="#"><img src="images/di.jpg" class="zoom-in" /></div></a>
		<div class="col-xs-2"><a href="#"><img src="images/fardimage.jpg" class="zoom-in" /></div></a>
		<div class="col-xs-2"><a href="#"><img src="images/download.jpg" class="zoom-in" /></div></a>
	</div>
</div>	
<div class="row">
	<div class="col-xs-12">
		<div class="footer">
			Copyright &copy; 2017
		</div>
	</div>
</div>
</div> <!-- container ends -->

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/slider.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
	<script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">
	$('.carousel').carousel({
  interval: 2000
	});
  $(function () {
	    $('#datetimepicker1').datetimepicker();
	});
  
</script>
</body>
</html
				
