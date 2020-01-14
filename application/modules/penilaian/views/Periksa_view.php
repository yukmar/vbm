	<section class="content-header">
		<ol class="breadcrumb">
      <li><a href="<?=site_url('penilaian/').$prk?>">Penilaian</a></li>
      <li class="active"><?=$page?></li>
    </ol>
    <h1> 
      <small>Periksa Assessment</small> <br/>
      [<?=$jenis_ujian?>] Praktikum: <?=$judul_prak?>
    </h1>
    <br />
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-4 col-md-push-8">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"><b>Data Mahasiswa</b></h3>
					</div>
					<div class="box-body">
						<div class="item">
								<table class="table info-user">
									<tr>
										<td>Nama </td>
										<td>:</td>
										<td><?=$user['nama']?></td>
									</tr>
									<tr>
										<td>Offering </td>
										<td>:</td>
										<td><?=$user['offering']?></td>
									</tr>
								</table>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-8 col-md-pull-4">
				<div class="box box-primary container">
					<div class="box-header">
						<div class="box-title">
							<b>Jabaran</b>
						</div>
					</div>
					
					<div class="box-body">
						<?php
								foreach ($isi as $key => $value) { ?>
								<div class="item pretest">
									<div class="pretest-no">
										<?=$key+1?>.
									</div>
									<div class="pretest-content">
										<p><?=$value['jabaran_soal']?></p>
										<textarea rows="7" disabled><?=$value['jawaban']?></textarea>

										<!-- <span>Nilai: </span><input type="textbox" class="txtnilai" value="0"> <i></i> -->
									</div>
									
								</div>
							<?php } ?>
					</div>
					<div class="box-footer">
						<div class="item">
						<form class="form-inline">
						  <div class="form-group">
						    <label>Name</label>
						    <input type="text" class="form-control" name="txtnilai" id="txtnilai" value="<?=$nilai?>" />
						  </div>
						  <button type="submit" class="btn btn-primary" id="btnPeriksa" data-act="<?=site_url('penilaian/submit/').$detail?>" data-prak="<?=$prk?>">Selesai</button>
						</form>
						</div>
					</div>
				</div>


			</div>

			
		</div>
		
	</section>