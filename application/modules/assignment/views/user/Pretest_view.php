<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>.:Virtual Lab Teknik Mesin:.</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
	<link rel="stylesheet" href="<?=base_url('assets/packages/')?>bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?=base_url('assets/packages/')?>font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?=base_url('assets/packages/')?>Ionicons/css/ionicons.min.css" />
  <link rel="stylesheet" href="<?=base_url('assets/packages/')?>toastrjs/build/toastr.min.css" />
  <link rel="stylesheet" href="<?=base_url('assets/css/')?>AdminLTE.min.css" />
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/packages/datatables/datatables.min.css')?>">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
  <link rel="stylesheet" href="<?=base_url('assets/css/')?>skins/skin-green.min.css" />
  <link rel="stylesheet" href="<?=base_url('assets/css/')?>index.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-green sidebar-collapse sidebar-mini">
<div class="wrapper">

	<header id="header" class="main-header">
	  <a href="<?=site_url()?>" class="logo">
	    <span class="logo-mini"><b>VLAB</b></span>
	    <span class="logo-lg"><strong>VIRTUAL LAB</strong><br/>Teknik Mesin</span>
	  </a>

	  <nav class="navbar navbar-static-top" role="navigation">
	    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
	      <span class="sr-only">Toggle navigation</span>
	    </a>
	    <span class="navbar-brand"><?=$page?></span>

	    <div class="navbar-custom-menu">
	      <ul class="nav navbar-nav">
	        <li>
	          <a href="<?=site_url('logout')?>">
	            <i class="fa fa-power-off"></i>
	          </a>
	        </li>
	      </ul>
	    </div>
	  </nav>
	</header>

	<aside class="main-sidebar">
	  <section class="sidebar">
	    
	  </section>
	</aside>

	<div class="content-wrapper">
		<div class="content-header">
			<ol class="breadcrumb">
	      <li><a href="#" title="">Pretest</a></li>
	    </ol>
	    <h1>
	    	<small>Pretest</small><br/>
	    </h1>
		</div>
		<div class="content">
			<div class="row">
				<div class="col-lg-12">

					<div class="box box-warning container">
						<form action="<?=site_url('pretest/submit')?>" method="post" accept-charset="utf-8">
						<div class="box-header">
							<div class="box-title">
								Soal Pretest
							</div>
						</div>
						<div class="box-body">
								
							<?php foreach ($soal as $key => $value) { ?>
										
							<div class="item pretest">
								<div class="pretest-no">
									<?=$key+1?>
								</div>
								<div class="pretest-content">
									<p><?=$value->jabaran?></p>
								
									<?php foreach ($value->opsi as $k => $val) { ?>
									<div class="form-group">
										<div class="radio">
											<label>
												<input type="radio" name="opsi[<?=$key?>]" value="<?=$val->idopsi?>">
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$val->jabops?>
											</label>
										</div>
									</div>
									<?php } ?>

								</div>
							</div>
							<?php } ?>

						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary">Selesai</button>
						</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>

	<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <!-- Anything you want -->
    </div>
    <!-- Default to the left -->
    <strong>Universitas Negeri Malang</strong>
  </footer>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- <script src="<?=base_url('assets/packages/datatables/datatables.min.js')?>"></script> -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url('assets/packages/')?>bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets/js/')?>adminlte.min.js"></script>
<script src="<?=base_url('assets/packages/')?>toastrjs/build/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>

<?php
if (isset($linkjs)) { ?>
  <script src="<?=$linkjs?>"></script>
<?php }?>

</body>
</html>