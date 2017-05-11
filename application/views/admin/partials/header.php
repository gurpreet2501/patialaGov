<?php $role=user_role()?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
 <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/chosen.css')?>">
  <link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
 <link href="<?=base_url('assets/css/print.css').'?244313124234'?>" rel="stylesheet">
<?php 
if(isset($css_files)){
    foreach($css_files as $file): ?>
    	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; 
 }
?>
 <link href="<?=base_url('css/sb-admin.css').'?124234'?>" rel="stylesheet">
 <script src="<?=base_url('js/jquery-1.10.2.js');?>"></script>
 <script src="<?=base_url('js/bootstrap.min.js');?>"></script>

<?php if(isset($js_files)){ foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; 
}?>

<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
.form-control {
  height: 36px !important;
}

.cancel-reason.form-control {
  height: auto !important;
}
</style>
</head>
<body>
	 <div id="wrapper">
     
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?=site_url('admin')?>">Logged in as <em><strong><?=$this->tank_auth->get_username()?></strong></em></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
              <li>
                <a href="<?=site_url('/auth/logout')?>"><i class="fa fa-fw fa-power-off"></i>Logout</a>
              </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <?php
                  if(is_role('user'))
                    $this->load->view('admin/partials/menu-user');
                  elseif(is_role('employee'))
                    $this->load->view('admin/partials/menu-employee');
                  elseif(is_role('admin'))
                    $this->load->view('admin/partials/menu-admin');
                ?>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                  <div class="col-lg-12">
                    <ol class="breadcrumb">
                      <li class="active">
                        <i class="fa fa-dashboard"></i> <?=ucwords($this->uri->segment(2)) ?>
                      </li>
                    </ol>
                  </div>
                </div>
                <!-- /.row -->
                     <?php if($msg = lako::get('flash')->get('global')):?>
      <div class="alert alert-<?=htmlspecialchars($msg['type'])?>" role="alert">
        <p><?=htmlentities($msg['msg']);?></p>
      </div>
    <?php endif; ?>