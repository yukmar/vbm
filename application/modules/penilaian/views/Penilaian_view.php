<section class="content-header">
		<ol class="breadcrumb">
      <li class="active"><?=$page?></li>
    </ol>
    <h1> 
      <small>Detail</small> <br/>
      PRAKTIKUM: <?=$judul_prak?>
    </h1>
    <br />
	</section>
	<section class="content">
		<div class="row">
			<div class="col-lg-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Ujian A</h3>
					</div>
					<div class="box-body">
						<div class="item">
							<div class="row">
								<div class="col-lg-6">
									<div class="donut-chart">										
										<canvas id="donut-cujian1"></canvas>							
									</div>
								</div>
								<div class="col-lg-6">
									<h5 class="bar-title">Progress Pengerjaan Praktikum Per Offering</h5>
									<div class="bars">
										<?php	foreach ($summary['overview'] as $key => $value) { ?>
										<div class="clearfix">
											<span class="pull-left">Offering <?=$value->nama?></span>
											<span class="pull-right"><?=$value->jml['ujian1']?> / <?=$value->total?></span>
										</div>
										<div class="progress prodet" data-toggle="modal" data-target="#myModal" data-off="<?=$idprak?>/1/<?=$value->id?>" name-off="<?=$value->nama?>">
										  <div class="progress-bar progress-bar-striped progress-bar-kkm" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?=round($value->demografi_nilai['ujian1']['kkm'] / $value->total * 100)?>%">
										    <?=$value->demografi_nilai['ujian1']['kkm']?>
										  </div>
										  <div class="progress-bar progress-bar-striped progress-bar-underkkm" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?=round($value->demografi_nilai['ujian1']['under_kkm'] / $value->total * 100)?>%">
										  	<?=$value->demografi_nilai['ujian1']['under_kkm']?>
										  </div>
										  <div class="progress-bar progress-bar-striped progress-bar-unchecked" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?=round($value->demografi_nilai['ujian1']['unchecked'] / $value->total * 100)?>%">
										  	<?=$value->demografi_nilai['ujian1']['unchecked']?>
										  </div>
										</div>
										</a>
										<?php }?>
									</div>
									<b>Keterangan:</b>
									<div class="bar-ket">
										<div class="ketbar-success">
											<span>Memenuhi KKM</span>
											<span>Dibawah KKM</span>
											<span>Belum dicek</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Ujian B</h3>
					</div>
					<div class="box-body">
						<div class="item">
							<div class="row">
								
								
								<div class="col-lg-6">
									<div class="donut-chart">										
										<canvas id="donut-cujian2"></canvas>		
									</div>
								</div>
								<div class="col-lg-6">
									<h5 class="bar-title">Progress Pengerjaan Praktikum Per Offering</h5>
									<div class="bars">

										<?php	foreach ($summary['overview'] as $key => $value) { ?>
										<div class="clearfix">
											<span class="pull-left">Offering <?=$value->nama?></span>
											<span class="pull-right"><?=$value->jml['ujian2']?> / <?=$value->total?></span>
										</div>
										<div class="progress prodet" data-toggle="modal" data-target="#myModal" data-off="<?=$idprak?>/2/<?=$value->id?>" name-off="<?=$value->nama?>">
										  <div class="progress-bar progress-bar-striped progress-bar-kkm" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?=round($value->demografi_nilai['ujian2']['kkm'] / $value->total * 100)?>%">
										    <?=$value->demografi_nilai['ujian2']['kkm']?>
										  </div>
										  <div class="progress-bar progress-bar-striped progress-bar-underkkm" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?=round($value->demografi_nilai['ujian2']['under_kkm'] / $value->total * 100)?>%">
										  	<?=$value->demografi_nilai['ujian2']['under_kkm']?>
										  </div>
										  <div class="progress-bar progress-bar-striped progress-bar-unchecked" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?=round($value->demografi_nilai['ujian2']['unchecked'] / $value->total * 100)?>%">
										  	<?=$value->demografi_nilai['ujian2']['unchecked']?>
										  </div>
										</div>
										<?php }?>

									</div>
									<b>Keterangan:</b>
									<div class="bar-ket">
										<div class="ketbar-success">
											<span>Memenuhi KKM</span>
											<span>Dibawah KKM</span>
											<span>Belum dicek</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
			<!-- unmarked -->
				<div class="box box-danger">
					<div class="box-header">
						<i class="fa fa-exclamation"></i>
						<h3 class="box-title">Ujian yang belum dinilai</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-hover" id="unmarked">
								<thead>
									<tr>
										<th>#</th>
										<!-- <th>Jenis Soal</th> -->
										<th>User</th>
										<th>Offering</th>
										<th>Waktu Submit</th>
										<th>Nilai</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($ujian1['unmarked'] as $key => $value) { ?>
									<tr class="det-soal" data-href="<?=site_url('rincian/periksa/').$value['iddet']?>">
										<td></td>
										<!-- <td><?=$value->jenis?></td> -->
										<td><?=$value['nama']?></td>
										<td><?=$value['nama_off']?></td>
										<td><?=$value['tgl']?></td>
										<td><?=$value['nilai']?></td>
									</tr>
									<?php }?>
								</tbody>
							</table>	
						</div>						
					</div>
				</div>
			<!-- end unmarked -->
			<!-- marked -->
				<div class="box box-primary">
					<div class="box-header">
						<i class="fa fa-check"></i>
						<h3 class="box-title">Ujian yang telah dinilai</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-hover" id="marked">
								<thead>
									<tr>
										<th>#</th>
										<!-- <th>Jenis Soal</th> -->
										<th>User</th>
										<th>Offering</th>
										<th>Waktu Submit</th>
										<th>Nilai</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($ujian1['marked'] as $key => $value) { ?>
									<tr class="det-soal" data-href="<?=site_url('rincian/periksa/').$value['iddet']?>">
										<td><?=$key+1?></td>
										<!-- <td><?=$value->jenis?></td> -->
										<td><?=$value['nama']?></td>
										<td><?=$value['nama_off']?></td>
										<td><?=$value['tgl']?></td>
										<td><?=$value['nilai']?></td>
									</tr>
									<?php }?>
								</tbody>

							</table>	
						</div>
					</div>
				</div>
			<!-- end marked -->
			</div>
			<div class="col-lg-6">
			<!-- unmarked -->
				<div class="box box-danger">
					<div class="box-header">
						<i class="fa fa-exclamation"></i>
						<h3 class="box-title">Ujian yang belum dinilai</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-hover" id="unmarked2">
								<thead>
									<tr>
										<th>#</th>
										<!-- <th>Jenis Soal</th> -->
										<th>User</th>
										<th>Offering</th>
										<th>Waktu Submit</th>
										<th>Nilai</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($ujian2['unmarked'] as $key => $value) { ?>
									<tr class="det-soal" data-href="<?=site_url('rincian/periksa/').$value['iddet']?>">
										<td></td>
										<!-- <td><?=$value->jenis?></td> -->
										<td><?=$value['nama']?></td>
										<td><?=$value['nama_off']?></td>
										<td><?=$value['tgl']?></td>
										<td><?=$value['nilai']?></td>
									</tr>
									<?php }?>
								</tbody>
							</table>	
						</div>						
					</div>
				</div>
			<!-- end unmarked -->
			<!-- marked -->
				<div class="box box-primary">
					<div class="box-header">
						<i class="fa fa-check"></i>
						<h3 class="box-title">Ujian yang telah dinilai</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-hover" id="marked2">
								<thead>
									<tr>
										<th>#</th>
										<!-- <th>Jenis Soal</th> -->
										<th>User</th>
										<th>Offering</th>
										<th>Waktu Submit</th>
										<th>Nilai</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($ujian2['marked'] as $key => $value) { ?>
									<tr class="det-soal" data-href="<?=site_url('rincian/periksa/').$value['iddet']?>">
										<td><?=$key+1?></td>
										<!-- <td><?=$value->jenis?></td> -->
										<td><?=$value['nama']?></td>
										<td><?=$value['nama_off']?></td>
										<td><?=$value['tgl']?></td>
										<td><?=$value['nilai']?></td>
									</tr>
									<?php }?>
								</tbody>
							</table>	
						</div>
					</div>
				</div>
			<!-- end marked -->
			</div>
		</div>
	</section>
<!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mtitle"></h4>
      </div>
      <div class="modal-body" id="prakoff-context">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>