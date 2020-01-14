  <section class="content-header">
    <?php if ($alert) { ?>
    <div class="alert alert-<?=$alert['status']?> alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <?=$alert['message']?>
    </div>
    <?php } ?>
    <ol class="breadcrumb">
      <li>Home</li>
      <li class="active">Kelola Praktikum</li>
    </ol>
    <div class="container">
      <h1>
        Kelola Praktikum
      </h1>
      <p>Halaman Pengelolaan Data Praktikum</p>
    </div>
  </section>


  <section class="content">
    <div class="row">
    <!-- coloum 1 -->
    <div class="col-lg-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Praktikum</h3>
        </div>
        <div class="box-body">
          <table class="table table-hover" id="daftar-praktikum">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Praktikum</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($list_praktikum as $key => $value) { ?>
              <tr>
                <td><?=$key+1?></td>
                <td><?=$value['judul']?></td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-social btn-outline-primary edit" data-toggle="modal-edit" data-edit="<?=$value['id']?>"><i class="fa fa-fw fa-pencil"></i>Edit</button>
                    <a href="<?=site_url('manage-praktikum/delete/?n='.$value['id'])?>" class="btn btn-social btn-outline-danger"><i class="fa fa-fw fa-close"></i>Hapus</a>
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
            Tambah Praktikum
          </button>
        </div>
      </div>
    </div>
    <!-- end coloum 1 -->
    <div class="modal fade" id="modal-tambah">
      <div class="modal-dialog">
        <div class="modal-content">
          <form role="form" class="form" action="<?=site_url('manage-praktikum/add')?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Form Tambah Praktikum</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label>Judul</label>
                <input class="form-control" name="txtjudul" placeholder="Masukan Judul" />
              </div>
              <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" rows="3" name="txtdesc"></textarea>
              </div>
              <div class="form-group">
                <label>PDF</label>
                <input class="form-control" name="txtpdf" placeholder="ID PDF dari google drive. contoh: 1e7csIyfRf-f2f9GPahOVkfEJxJ0u7gta" />
                <small class="text-muted">contoh url file: "https://drive.google.com/file/d/<b>1e7csIyfRf-f2f9GPahOVkfEJxJ0u7gta</b>/view"</small><br/>
                <small class="text-danger">pastikan url merujuk ke file, bukan ke folder</small>
              </div>
              <div class="form-group">
                <label>Video</label>
                <input class="form-control" name="txtvideo" placeholder="ID Video dari youtube. contoh: BxuckbYLWvM" />
                <small class="text-muted">contoh url video youtube: "https://www.youtube.com/watch?v=<b>BxuckbYLWvM</b>"</small>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Tambah</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog">
        <div class="modal-content">
          <form role="form" id="form-edit" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Form Edit Praktikum</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label>Judul</label>
                <input class="form-control" name="etxtjudul" placeholder="Masukan Judul" />
              </div>
              <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" rows="3" name="etxtdesc"></textarea>
              </div>
              <div class="form-group">
                <label>PDF</label>
                <input class="form-control" name="etxtpdf" placeholder="ID PDF dari google drive" />
              </div>
              <div class="form-group">
                <label>Video</label>
                <input class="form-control" name="etxtvideo" placeholder="ID Video dari google drive / youtube" />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Edit</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  </section>