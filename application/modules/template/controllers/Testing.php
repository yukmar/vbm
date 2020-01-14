<?php
/**
 * 
 */
class Testing extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'assignment/Soal_model' => 'm_soal',
			'assignment/Jenissoal_model' => 'm_jenis',
			'assignment/Opsi_model' => 'm_opsi',
			'assignment/Setsoal_model' => 'm_setso',
			'assignment/Assessment_model' => 'm_assess',
			'assignment/Pretest_model' => 'm_pretest',
			'praktikum/Praktikum_model' => 'm_praktikum',
			'penilaian/Detailpengerjaan_model' => 'm_detail',
			'penilaian/Pengerjaan_model' => 'm_pengerjaan',
			'user/Offering_model' => 'm_off'
		]);
	}

	public function index()
	{
		$content['sumdata'] = $this->m_praktikum->getalljudul();
		foreach ($content['sumdata'] as $key => $value) {
			$result = $this->m_pengerjaan->summary($value['id'], true, 'unchecked');
			$ujian1 = 0;
			$ujian2 = 0;
			foreach ($result as $k2 => $v2) {
				if ($v2['idassess'] == 2) {
					$ujian1 = $v2['iduser'];
				}
				if ($v2['idassess'] == 3) {
					$ujian2 = $v2['iduser'];
				}
			}
			$content['sumdata'][$key]['unchecked'] = [
				'ujian1' => $ujian1,
				'ujian2' => $ujian2
			];
		}
		print json_encode($content);
	}
}