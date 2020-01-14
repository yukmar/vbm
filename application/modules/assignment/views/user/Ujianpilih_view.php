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
				<div class="box-header">
					<div class="box-title">
						Pilih Ujian
					</div>
				</div>
				<div class="box-body">
					<?php
					$link1 = ($ujian_stat[0]) ? '#' : (site_url('ujian/'.$noprak.'/1'));
					$disabled1 = ($ujian_stat[0]) ? 'disabled' : '';
					$link2 = ($ujian_stat[1]) ? '#' : (site_url('ujian/'.$noprak.'/2'));
					$disabled2 = ($ujian_stat[1]) ? 'disabled' : '';
					?>
					<a href="<?=$link1?>" class="btn btn-primary" <?=$disabled1?>>Ujian A</a>
					<a href="<?=$link2?>" class="btn btn-primary" <?=$disabled2?>>Ujian B</a>
				</div>
			</div>
		</div>
	</div>
</div>