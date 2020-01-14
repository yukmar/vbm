  <section class="content-header">
    <?php if ($alert) { ?>
    <div class="alert alert-<?=$alert['status']?> alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <?=$alert['message']?>
    </div>
    <?php } ?>
    <ol class="breadcrumb">
      <li>Home</li>
      <li class="active">Kelola User</li>
    </ol>
    <div class="container">
      <h1>
        Kelola User
      </h1>
      <p>Halaman Pengelolaan Data User</p>
    </div>
  </section>


  <section class="content">
    <div class="row">
    <!-- coloum 1 -->
    <div class="col-lg-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar User</h3>
        </div>
        <div class="box-body">
          <table class="table table-hover" id="daftar-user">
            <thead>
              <tr>
                <th>#</th>
                <th>Username</th>
                <th>Nama Mahasiswa</th>
                <th>Offering</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($user_list as $key => $value) { ?>
              <tr>
                <td><?=$key+1?></td>
                <td><?=$value->username?></td>
                <td><?=$value->nama?></td>
                <td><?=$value->offering?></td>
                <td>
                  <?php if ($value->username !== 'admin1') { ?>
                  <div class="btn-group">
                    <button type="button" class="btn btn-social btn-outline-primary edit" data-toggle="modal-edit" data-edit="<?=$value->id?>"><i class="fa fa-fw fa-pencil"></i>Edit</button>
                    <a href="<?=site_url('manage-user/delete/?n='.$value->id)?>" class="btn btn-social btn-outline-danger"><i class="fa fa-fw fa-close"></i>Hapus</a>
                  </div>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
            Tambah User
          </button>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Offering</h3>
        </div>
        <div class="box-body">
          <table class="table" id="daftar-offering">
            <thead>
              <tr>
                <th>#</th>
                <th>Offering</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($total_offering as $key => $value) { ?>
              <tr>
                <td><?=$key+1?></td>
                <td><?=$value->nama?></td>
                <td><?=$value->total?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end coloum 1 -->
    <div class="modal fade" id="modal-tambah">
      <div class="modal-dialog">
        <div class="modal-content">
          <form role="form" class="form" action="<?=site_url('manage-user/add')?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Form Tambah User</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label>Peran</label>
                <select class="form-control select2" name="txtpriv" style="width: 100%">
                  <option value="1">Admin</option>
                  <option value="2">User</option>
                </select>
              </div>
              <div class="form-group">
                <label>Username</label>
                <input class="form-control" name="txtuser" placeholder="Masukan Username" />
              </div>
              <div class="form-group">
                <label>Nama Lengkap</label>
                <input class="form-control" name="txtnama" placeholder="Masukan Nama Lengkap" />
              </div>
              <div class="form-group">
                <label>Offering</label>
                <select class="form-control select2" name="txtoff" style="width: 100%">
                  <?php foreach ($total_offering as $key => $value) { ?>
                  <option value="<?=$value->id?>"><?=$value->nama?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="txtpass" placeholder="Masukan Password" />
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
            <h4 class="modal-title">Form Edit User</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <label>Peran</label>
              <select class="form-control select2" name="etxtpriv">
                <option value="1">Admin</option>
                <option value="2">User</option>
              </select>
              <div class="form-group">
                <label>Username</label>
                <input class="form-control" name="etxtuser" placeholder="Masukan Username" readonly="true" />
              </div>
              <div class="form-group">
                <label>Nama Lengkap</label>
                <input class="form-control" name="etxtnama" placeholder="Masukan Nama Lengkap" />
              </div>
              <div class="form-group">
                <label>Offering</label>
                <select class="form-control select2" name="etxtoff">
                  <?php foreach ($total_offering as $key => $value) { ?>
                  <option value="<?=$value->id?>"><?=$value->nama?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="etxtpass" placeholder="Masukan Password" />
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