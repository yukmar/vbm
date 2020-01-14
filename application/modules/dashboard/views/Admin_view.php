<?php
if (isset($alert)) {
  $alert;
}
?>
<section class="content-header">
        
  <ol class="breadcrumb">
    <li class="active">Home</li>
  </ol>
  <h1>OVERVIEW <br/>
    <small>Selamat datang Admin!</small>
  </h1>
  <br />
</section>

<section class="content">
  <!-- list praktikum -->
  <div class="row">

    <?php 
    foreach ($list_prak as $key => $val) { ?>
    <div class="col-lg-3">
      <a href="<?=site_url('penilaian/').$val['id']?>" title="">
      <div class="box box-primary">
        <div class="box-header">
          <i class="fa fa-bookmark"></i>
          <small class="box-type">Praktikum #<?=$key+1?></small><br/>
          <h3 class="box-title"><?=$val['judul']?></h3>
        </div>
        <div class="line-shape"></div>
        <div class="box-body">
          <div class="item-notif">
            <div class="item-number">
              <?=$val['unchecked']['ujian1']?>
            </div>
            <div class="item-desc">
              <span>Ujian A <br />Belum Dinilai</span>
            </div>
          </div>
          <div class="item-notif">
            <div class="item-number">
              <?=$val['unchecked']['ujian2']?>
            </div>
            <div class="item-desc">
              <span>Ujian B<br />Belum Dinilai</span>
            </div>
          </div>
        </div>
      </div>
      </a>
    </div>
    <?php } ?>        
  </div>
</section>