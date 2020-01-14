
  <section class="content-header">
        
    <ol class="breadcrumb">
      <li>Home</li>
      <li class="active">Praktikum</li>
    </ol>
    <h1><small>BAB:</small><br/> <?=$judul?></h1>
  </section>


  <section class="content">
    <div class="row">
    <!-- coloum 1 -->
    <div class="col-lg-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Tujuan</h3>
        </div>
        <div class="box-body prak-desc">
          <?=$desc?>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Dokumen</h3>
        </div>
        <div class="box-body">
          <div class="box-pdf">
            <iframe src="https://drive.google.com/file/d/<?=$pdf?>/preview" width="640" height="480"></iframe>
          </div>
        </div>
      </div>
    </div>
    <!-- end coloum 1 -->

    <!-- coloum 2 -->
    <div class="col-lg-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Video</h3>
        </div>
        <div class="box-body box-video">
          <div class="box-video">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$video?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
    <!-- end coloum 2 -->
  </section>
  </div>