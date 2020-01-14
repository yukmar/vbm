<?php $this->load->view('assignment/manage/manage_headerview', ['alert', $alert]);?>

  <section class="content">
    <div class="row">
      <!-- coloum 1 -->
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">BANK SOAL</h3>
          </div>
          <div class="box-body">
            <ul class="nav nav-tabs">
              <li role="presentation" class="active"><a href="<?=site_url('manage-soal')?>">Bank Soal</a></li>
              <li role="presentation"><a href="<?=site_url('manage-soal/pretest')?>">Soal Pretest</a></li>
              <li role="presentation"><a href="<?=site_url('manage-soal/ujian')?>">Soal Ujian</a></li>
            </ul>
            <div class="row row1">
              <br/>
              <div class="col-lg-6">
                <h3>Kategori Soal</h3>
                <div class="form-inside-box">
                  <form class="form-horizontal" id="opsi-form" action="<?=site_url('manage-soal/list')?>" method="get">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Judul Praktikum</label>
                      <div class="col-sm-9">
                        <select class="form-control select2" name="opsi-prak" style="width: 100%">
                          <?php foreach ($opsi_prak as $key => $value) { ?>
                          <option value="<?=$value['id']?>"><?=$value['judul']?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Jenis Soal</label>
                      <div class="col-sm-9">
                        <select class="form-control select2" name="opsi-jenis" style="width: 100%">
                          <?php foreach ($opsi_jenis as $key => $value) { ?>
                          <option value="<?=$value['id']?>"><?=ucwords($value['nama'])?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-primary">Cari</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-lg-6 table-soal">
                <h3>Total Soal per Praktikum</h3>
                <table class="table table-hover" id="table-totalprak">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Judul Praktikum</th>
                      <th>Jumlah Soal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($total_prak as $key => $value) { ?>
                    <tr>
                      <td><?=$key+1?></td>
                      <td><?=$value['judul']?></td>
                      <td><?=$value['total']?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Daftar Soal: <?=$judul_daftar?></h3>
          </div>
          <!-- form start -->
              <div class="box-body">
                <table class="table table-hover" id="table-daftarsoal">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Jabaran Soal</th>
                      <th>Jenis Soal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (!$list_soal) { ?>
                    <tr>
                      <td>data</td>
                      <td>data</td>
                      <td>data</td>
                      <td>data</td>
                    </tr>
                    <?php } else {
                      foreach ($list_soal as $key => $value) { ?>
                    <tr>
                      <td><?=$key+1?></td>
                      <td><?=$value['jabaran']?></td>
                      <td><?=$value['jenis']?></td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-social btn-outline-primary edit" data-toggle="modal-edit" data-edit="<?=$value['id']?>"><i class="fa fa-fw fa-pencil"></i>Edit</button>
                          <a href="<?=site_url('manage-soal/delete/?n='.$value['id'])?>" class="btn btn-social btn-outline-danger"><i class="fa fa-fw fa-close"></i>Hapus</a>
                        </div>
                      </td>
                    </tr>
                    <?php }
                    }
                    ?>
                  </tbody>
                </table>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                  Tambah Soal
                </button>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
              </div>
              <!-- /.box-footer -->
        </div>
      </div>
    </div>
    
    <!-- end coloum 1 -->
    <div class="modal fade" id="modal-tambah">
      <div class="modal-dialog">
        <div class="modal-content">
          <form role="form" class="form" id="form-tambahsoal" action="<?=site_url('manage-soal/add')?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Form Tambah Soal</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label class="control-label">Judul Praktikum</label>
                    <select class="form-control select2" name="txtprak" style="width: 100%">
                      <?php foreach ($opsi_prak as $key => $value) { ?>
                      <option value="<?=$value['id']?>"><?=$value['judul']?></option>
                      <?php } ?>
                  </select>
              </div>
              <div class="form-group">
                <label>Jabaran</label>
                <textarea class="form-control" rows="3" name="txtjab"></textarea>
              </div>
              <hr/>
              <div class="form-group" id="jenis-soal">
                <label>Pilihan Jawaban</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="jenis" value="1">
                    Pilihan
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="jenis" value="2">
                    Uraian
                  </label>
                </div>
              </div>
              <div class="form-group" id="tambah-pilihan">
                <label>Butir-Butir Jawaban</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="opsi" value="0">
                    <textarea name="txtopsi[]" cols="70"></textarea>
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="opsi" value="1">
                    <textarea name="txtopsi[]" cols="70"></textarea>
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="opsi" value="2">
                    <textarea name="txtopsi[]" cols="70"></textarea>
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="opsi" value="3">
                    <textarea name="txtopsi[]" cols="70"></textarea>
                  </label>
                </div>
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" disabled>Tambah</button>
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
                <label class="control-label">Judul Praktikum</label>
                    <select class="form-control select2" name="etxtprak" style="width: 100%">
                      <?php foreach ($opsi_prak as $key => $value) { ?>
                      <option value="<?=$value['id']?>"><?=$value['judul']?></option>
                      <?php } ?>
                  </select>
              </div>
              <div class="form-group">
                <label>Jabaran</label>
                <textarea class="form-control" rows="3" name="etxtjab"></textarea>
              </div>
              <div class="form-group form-pilihan" hidden="true">
                <label>Pilihan Jawaban</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="eopsi">
                    <textarea name="etxtopsi[]" cols="70"></textarea>
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="eopsi">
                    <textarea name="etxtopsi[]" cols="70"></textarea>
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="eopsi">
                    <textarea name="etxtopsi[]" cols="70"></textarea>
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="eopsi">
                    <textarea name="etxtopsi[]" cols="70"></textarea>
                  </label>
                </div>
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