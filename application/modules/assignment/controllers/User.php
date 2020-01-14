<?php
/**
 * 
 */
class User extends CI_Controller
{
	private $valid = null;
	private $iduser = null;
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'praktikum/Praktikum_model' => 'm_praktikum',
			'assignment/Soal_model' => 'm_soal',
			'assignment/Assessment_model' => 'm_assess',
			'assignment/Pretest_model' => 'm_pretest',
			'assignment/Setsoal_model' => 'm_setso',
			'penilaian/Detailpengerjaan_model' => 'm_detail',
			'penilaian/Pengerjaan_model' => 'm_pengerjaan'
		));
		$this->valid = $this->session->tempdata('valid');
		$this->iduser = $this->session->tempdata('iduser');
		if (!$this->iduser) {
			redirect(site_url());
		}
		if (!$this->valid) {
			redirect(site_url('pretest'));
		}
	}

// start pretest
	public function pretest()
	{
		// $data['uraian_soal'] = $this->m_soal->get_set($no_praktikum, $this->jenis_soal);
		$data['soal'] = $this->m_pretest->get_soal();
		$data['page'] = 'Pretest';

		$this->load->view('assignment/user/Pretest_view', $data);
	}

	public function submit()
	{
		$jawaban = $this->input->post('opsi');
		$correct_answers = 0;
		foreach ($jawaban as $value) {
			$cek = $this->m_pretest->cek_jawaban($value);
			if ($cek) {
				$correct_answers++;
			}
		}
		$valid = 0;
		$total_soal = $this->m_pretest->get_soal(true);
		$valid_percentage = $correct_answers / $total_soal * 100;
		$total_prak = $this->m_praktikum->total();
		$valid = round($valid_percentage/100 * $total_prak);
		$this->session->set_tempdata(array('valid' => $valid));
		redirect(site_url());
	}
// end pretest

// start ujian
	public function ujian($no_praktikum, $tipe = null)
	{
		$cek_prak = $this->m_praktikum->get_judul($no_praktikum);
		if (count($cek_prak) == 0) {
			show_404();
		}
		$ujian1_done = $this->m_pengerjaan->cek_pengerjaan($this->iduser, $no_praktikum, '2');
		$ujian2_done = $this->m_pengerjaan->cek_pengerjaan($this->iduser, $no_praktikum, '3');
		$ujian_stat = [boolval($ujian1_done), boolval($ujian2_done)];

		if ($tipe && array_key_exists($tipe-1, $ujian_stat) && (!$ujian_stat[$tipe-1])) {
			$idassess = ($tipe == 1) ? 2 : (($tipe == 2) ? 3 : null);
			$list_idsoal = $this->m_soal->get_set($no_praktikum, $idassess);
			$list_set = null;
			if ($list_idsoal) {
				$list_set = array_map(function($val) use (&$idassess)
				{
					$result = $this->m_setso->search(['idsoal' => $val['id'], 'idassess' => $idassess], null, 'id');
					if ($result) {
						return ['id' => $result[0], 'jabaran' => $val['jabaran']];
					} else {
						return null;
					}
				}, $list_idsoal);
			}
			$data['content_data']['uraian_soal'] = $list_set;
			$data['content_page'] = 'assignment/user/Ujian_view';
		} else {
			$data['content_data']['ujian_stat'] = $ujian_stat;
			$data['content_page'] = 'assignment/user/Ujianpilih_view';
		}
		$data['page'] = 'UJIAN';
		$data['sidebar_list'] = $this->m_praktikum->get_list_id($this->valid);
		$data['content_data']['noprak'] = $no_praktikum;
		$data['content_data']['judul'] = $this->m_praktikum->get_judul($no_praktikum);
		
		$this->load->view('template/user/User_view', $data);
	}

	public function submit_ujian($idprak)
	{
		$jawaban = $this->input->post('jwb');
		$new_detail = $this->m_detail->create($this->iduser);
		$new_detail_id = $this->m_detail->get_lastid();
		foreach ($jawaban as $key => $value) {
			$this->m_pengerjaan->create($key, $new_detail_id, $value);
		}
		redirect(site_url('ujian/'.$idprak));
	}
// end ujian

// start nilai
	public function nilai($no_praktikum)
	{
		$data['page'] = 'Nilai';
		$data['sidebar_list'] = $this->m_praktikum->get_list_id($this->valid);
		$data['content_page'] = 'assignment/user/Nilai_view';
		$data['content_data']['judul'] = $this->m_praktikum->get_judul($no_praktikum);

		$this->load->view('template/user/User_view', $data);
	}
	// end nilai
}