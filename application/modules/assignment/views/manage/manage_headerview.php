  <section class="content-header">
    <?php if ($alert) { ?>
    <div class="alert alert-<?=$alert['status']?> alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <?=$alert['message']?>
    </div>
    <?php } ?>
    <ol class="breadcrumb">
      <li>Home</li>
      <li class="active">Bank Soal</li>
    </ol>
    <div class="container">
      <h1>
        Kelola Soal
      </h1>
      <p>Halaman Pengelolaan Data Soal, mulai kumpulan soal (bank soal), pengelompokan soal pretest dan ujian</p>
    </div>
  </section>