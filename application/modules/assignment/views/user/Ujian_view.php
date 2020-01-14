<div class="content-header">
	<ol class="breadcrumb">
	    <li><a href="#" title="">Home</a></li>
	    <li><a href="#" title="">Praktikum</a></li>
	    <li class="active">Ujian</li>
	  </ol>
	  <h1>
	   <small>BAB:</small><br/>
	   <?=$judul?>
	  </h1>
</div>
<div class="content">
	<div class="row">
		<div class="col-lg-12">

			<div class="box box-warning container">
				<?php if (isset($uraian_soal)) { ?>
				<form action="<?=site_url('ujian/submit/').$noprak?>" method="post">
				<div class="box-header">
					<div class="box-title">
						Soal Ujian
					</div>
				</div>
				<div class="box-body">
				<?php foreach ($uraian_soal as $key => $value) { ?>
					<div class="item pretest">
						<div class="pretest-no">
							<?=$key+1?>.
						</div>
						<div class="pretest-content">
							<p><?=$value['jabaran']?></p>
							<textarea rows="7" name="jwb[<?=$value['id']?>]"></textarea>
						</div>
					</div>
				<?php } ?>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">Selesai</button>
				</div>
				</form>
				<?php } else { ?>
					<div class="box-header">
					<div class="box-title">
						Ujian Belum Tersedia
					</div>
				</div>
				<?php } ?>
			</div>
			
		</div>
	</div>
</div>