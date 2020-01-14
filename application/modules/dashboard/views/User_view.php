      <!-- Content Header (Page header) -->
    <section class="content-header">
        
      <ol class="breadcrumb">
        <li class="active">Dashboard</li>
      </ol>

      <div class="container">
          <h1>
            Virtual Lab Teknik Mesin
          </h1>
          <p>Sebuah laboratorium visual untuk membantu kegiatan praktikum matakuliah Mesin Listrik<br/>
            Silahkan memilih praktikum yang tersedia pada sidebar</p>
      </div>
    </section>

    <section class="content">
      
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-lg-12">

          <div class="row">
          <?php
          $nos = 0; ?>
          <?php foreach ($data as $prop => $value) {
            if ($nos == 3) {
          ?>
              </div>
              <div class="row">
          <?php
              $nos = 0;
            }
          ?>
            <div class="col-lg-4 col-md-4 col-sm-7">
              <div class="box box-success">
                <div class="box-header">
                  <i class="fa fa-bookmark"></i>
                  <small class="box-type">Praktikum #<?=$prop+1?></small><br/>
                  <h3 class="box-title"><?=$value['judul']?></h3>
                </div>
                  <div class="line-shape"></div>
                <div class="box-body">
                  <div class="item container">
                    <div class="row">
                      <a href="<?=site_url('praktikum/').$value['id']?>"><img src="<?=base_url('assets/img/')?>materi.svg" alt=""></a>
                      <a href="<?=site_url('praktikum/').$value['id']?>"><img src="<?=base_url('assets/img/')?>video.svg" alt=""></a>
                    </div>
                    <div class="row">
                      <a href="<?=site_url('ujian/'.$value['id'])?>"><img src="<?=base_url('assets/img/')?>ujian.svg" alt=""></a>
                      <a href="<?=site_url('nilai/'.$value['id'])?>"><img src="<?=base_url('assets/img/')?>nilai.svg" alt=""></a>
                    </div>
                  </div>                  
                </div>
              </div>
            </div>
          <?php
            $nos++; 
          }
          ?>
          </div>

         
        </div>        
        <!-- /.Left col -->
      </div>
      <!-- /.row (main row) -->

    </section>