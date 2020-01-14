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
  <link rel="stylesheet" href="<?=base_url('assets/packages/datatables/datatables.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/packages/datatables/DataTables-1.10.18/css/')?>jquery.dataTables.min.css"/>
  <link rel="stylesheet" href="<?=base_url('assets/css/')?>skins/skin-green.min.css" />
  <link rel="stylesheet" href="<?=base_url('assets/css/')?>index.css" />
  <link rel="stylesheet" href="<?=base_url('assets/css/font/')?>font.css">
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
      <ul class="sidebar-menu" data-widget="tree">
        <li><a href="<?=site_url()?>"><i class="fa fa-circle-o"></i> <span>Dashboard</span></a></li>
        <?php foreach ($sidebar_list as $key => $value) { ?>
        <li class="treeview">
          <a href="<?=site_url('praktikum/'.$value)?>"><i class="fa fa-circle-o"></i> <span>Praktikum <?=$key+1?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=site_url('praktikum/').$value?>"><i class="fa fa-angle-right"></i>Materi</a></li>
            <li><a href="<?=site_url('ujian/').$value?>"><i class="fa fa-angle-right"></i>Ujian</a></li>
            <li><a href="<?=site_url('nilai/').$value?>"><i class="fa fa-angle-right"></i>Nilai</a></li>
          </ul>
        </li>

        <?php } ?>

      </ul>
    </section>
  </aside>

  <!-- start content -->
  <div class="content-wrapper">
  <?php
    $this->load->view($content_page, $content_data);
  ?>
  </div>
  <!-- end content -->

  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <!-- Anything you want -->
    </div>
    <!-- Default to the left -->
    <strong>Universitas Negeri Malang</strong>
  </footer>


</div>

<script src="<?=base_url('assets/packages/jquery/dist/')?>jquery.js"></script>
<script src="<?=base_url('assets/packages/datatables/')?>datatables.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url('assets/packages/')?>bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets/js/')?>adminlte.min.js"></script>
<script src="<?=base_url('assets/packages/')?>toastrjs/build/toastr.min.js"></script>
<script src="<?=base_url('assets/js/')?>Chart.min.js" type="text/javascript"></script>
<script src="<?=base_url('assets/js/')?>webfont.js"></script>

<?php
if (isset($linkjs)) { ?>
  <script src="<?=$linkjs?>"></script>
<?php }?>

</body>
</html>