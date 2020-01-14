<?php
/**
 * 
 */
class Manage extends CI_Controller
{
	private $priv = null;
	function __construct()
	{
		parent::__construct();
		$this->priv = ($this->session->tempdata('priv')) ? $this->session->tempdata('priv') : null;
		if ($this->priv !== 'admin') {
			redirect(site_url('logout'));
		}
		$this->load->model([
			'praktikum/Praktikum_model' => 'm_praktikum',
			'penilaian/Detailpengerjaan_model' => 'm_detail',
			'penilaian/Pengerjaan_model' => 'm_pengerjaan',
			'user/Offering_model' => 'm_off',
			'user/User_model' => 'm_user',
			'user/Mahasiswa_model' => 'm_mhs',
			'assignment/Setsoal_model' => 'm_setso'
		]);
	}

	public function index()
	{
		show_404();
	}

	public function show($idprak)
	{
		$data['page'] = 'PENILAIAN';
		$data['sidebar_menu'] = $this->m_praktikum->getalljudul();
		$data['linkjs'] = base_url('assets/js/custom/manage_penilaian.js');
		$data['content_page'] = 'penilaian/Penilaian_view';
		$data['content_data'] = [
			'judul_prak' => $this->m_praktikum->get_judul($idprak),
			'idprak' => $idprak,
			'ujian1' => [
				'marked' => $this->m_detail->detail_nilai($idprak, '2', 'is not null', true),
				'unmarked' => $this->m_detail->detail_nilai($idprak, '2', 'is null', true),
			],
			'ujian2' => [
				'marked' => $this->m_detail->detail_nilai($idprak, '3', 'is not null', true),
				'unmarked' => $this->m_detail->detail_nilai($idprak, '3', 'is null', true),
			],
		];
		$data['off'] = $this->m_off->get_total();
		$data['sumdata'] = $this->m_pengerjaan->summary($idprak);
		foreach ($data['off'] as $k1 => $v1) {
			$ujian1 = 0;
			$ujian2 = 0;
			foreach ($data['sumdata'] as $k2 => $v2) {
				if ($v2['off'] == $v1->id) {
					if ($v2['idassess'] == 2) {
						$ujian1 = $v2['iduser'];
					} else if ($v2['idassess'] == 3) {
						$ujian2 = $v2['iduser'];
					}
					break;
				}
			}
			$data['off'][$k1]->jml = [
				'ujian1' => $ujian1,
				'ujian2' => $ujian2
			];
			$data['off'][$k1]->demografi_nilai = [
				'ujian1' => $this->m_detail->detail_nilaioff($idprak, '2', $v1->id, true),
				'ujian2' => $this->m_detail->detail_nilaioff($idprak, '3', $v1->id, true)
			];
		}
		$data['content_data']['summary'] = [
			'overview' => $data['off'],
			'tables' => $data['sumdata']
		];
		$data['linkjs'] = base_url('assets/js/custom/detailsoal.js');
		$this->load->view('template/admin/Admin_view', $data);
	}

	public function summary($idprak)
	{
		$total_mhs = $this->m_mhs->total();
		$data['ujian1'] = [
			'jml_mhs_taken' => 0,
			'jml_mhs' => $total_mhs
		];
		$data['ujian2'] = [
			'jml_mhs_taken' => 0,
			'jml_mhs' => $total_mhs
		];
		$result = $this->m_pengerjaan->summary($idprak, true);
		foreach ($result as $key => $value) {
			if ($value['idassess'] == '2') {
				$data['ujian1']['jml_mhs_taken'] = (int)$value['iduser'];
			} else if ($value['idassess'] == '3') {
				$data['ujian2']['jml_mhs_taken'] = (int)$value['iduser'];
			}
		}
		header('Content-type:application/json;charset=utf-8');
		print json_encode($data);
	}

	public function detail_off($idprak, $idassess, $idoff)
	{
		$result = $this->m_pengerjaan->table_offnilai($idprak, $idassess+1, $idoff);
		header('Content-type:application/json;charset=utf-8');
		print json_encode($result);
	}

	public function periksa($iddet)
	{
		$result = $this->m_pengerjaan->search('iddetail', $iddet);
		$infoprak = $this->m_setso->get_setsoal($result[0]['idsoal']);
		$content['detail'] = $iddet;
		$content['jenis_ujian'] = ($this->m_setso->search('id', $result[0]['idsoal'], 'idassess')[0] == 2) ? 'Ujian A' : 'Ujian B';
		$content['judul_prak'] = $infoprak[0]['judul'];
		$content['prk'] = $infoprak[0]['idprak'];
		foreach ($result as $key => $value) {
			$result[$key]['jabaran_soal'] = $this->m_setso->get_setsoal($value['idsoal'], true);
			unset($result[$key]['idsoal']);
			unset($result[$key]['iddetail']);
		}
		$content['isi'] = $result;
		$iduser = $this->m_detail->search('id', $iddet, 'iduser')[0];
		$data_user = $this->m_user->get_set($iduser);
		$content['user'] = [
			'nama' => $data_user[0]->nama,
			'offering' => $data_user[0]->offering
		];
		$content['nilai'] = (int)$this->m_detail->search('id', $iddet, 'nilai')[0];

		$data['page'] = 'PERIKSA';
		$data['sidebar_menu'] = $this->m_praktikum->getalljudul();
		$data['linkjs'] = base_url('assets/js/custom/periksa.js');
		$data['content_page'] = 'penilaian/Periksa_view';
		$data['content_data'] = $content;
		$this->load->view('template/admin/Admin_view', $data);
	}

	public function submit_nilai($iddet)
	{
		$nilai = $this->input->post('nilai');
		$submit = $this->m_detail->update_nilai($iddet, $nilai);
		header('Content-type:application/json;charset=utf-8');
		print json_encode($submit);
	}
}