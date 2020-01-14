<?php
/**
 * 
 */
class Manage extends CI_Controller
{
	private $priv = null;
	protected $alert = null;
	protected $list_soal = null;
	protected $judul_daftar = null;
	protected $jenis = null;
	protected $list_ujian = null;
	protected $bank = null;
	protected $idprak = null;
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'praktikum/Praktikum_model' => 'm_praktikum',
			'assignment/Jenissoal_model' => 'm_jenis',
			'assignment/Soal_model' => 'm_soal',
			'assignment/Opsi_model' => 'm_opsi',
			'assignment/Setsoal_model' => 'm_setso',
			'assignment/Assessment_model' => 'm_assess'
		]);
		$this->priv = ($this->session->tempdata('priv')) ? $this->session->tempdata('priv') : null;
		if ($this->priv !== 'admin') {
			redirect(site_url('logout'));
		}
		$this->alert = $this->session->flashdata('alert');
		$this->list_soal = $this->session->flashdata('list');
		$this->judul_daftar = $this->session->flashdata('judul_daftar');
		$this->jenis = $this->session->flashdata('jenis');
		$this->list_ujian = $this->session->flashdata('list_ujian');
		$this->bank = $this->session->flashdata('bank');
		$this->idprak = $this->session->flashdata('idprak');
	}

	public function index()
	{
		show_404();
	}

	public function show()
	{
		$data['page'] = 'BANK SOAL';
		$data['sidebar_menu'] = $this->m_praktikum->getalljudul();
		$data['linkjs'] = base_url('assets/js/custom/manage_soal.js');
		$data['content_page'] = 'assignment/manage/Soal_view';
		$data['content_data'] = [
			'list_praktikum' => $data['sidebar_menu'],
			'alert' => $this->alert,
			'opsi_prak' => $data['sidebar_menu'],
			'opsi_jenis' => $this->m_jenis->getall(),
			'total_prak' => $this->m_soal->get_total_perprak(),
			'list_soal' => $this->list_soal,
			'judul_daftar' => $this->judul_daftar,
			'jenis' => $this->jenis
		];
		$this->load->view('template/admin/Admin_view', $data);
	}

	public function list_soal()
	{
		$idprak = $this->input->get('opsi-prak');
		$idjenis = $this->input->get('opsi-jenis');
		$list_search = $this->m_soal->search(['idprak' => $idprak, 'idjenis' => $idjenis]);
		$judulprak = $this->m_praktikum->get_judul($idprak);
		$jenis = $this->m_jenis->search('id', $idjenis, 'nama')[0];
		$list = array_map(function($data) use (&$jenis)
		{
			return [
				'id' => $data['id'],
				'jabaran' => $data['jabaran'],
				'jenis' => $jenis
			];
		}, $list_search);
		$this->session->set_flashdata('list', $list);
		$this->session->set_flashdata('judul_daftar', $judulprak);
		$this->session->set_flashdata('jenis', $jenis);
		redirect(site_url('manage-soal'));
	}

	public function get_pilihan()
	{
		$idsoal = $this->input->get('no');
		$pilihan = $this->m_opsi->search('idsoal', $idsoal);
		$kunci = $pilihan ? $this->m_opsi->get_kunci($idsoal) : null;
		$jabaran_soal = $this->m_soal->search('id', $idsoal)[0];
		header('Content-type:application/json;charset=utf-8');
		if ($jabaran_soal) {
			print json_encode([
				'id' => $idsoal,
				'detail' => $jabaran_soal,
				'prak' => $jabaran_soal['idprak'],
				'soal' => $jabaran_soal['jabaran'],
				'pilihan' => $pilihan,
				'kunci' => $kunci
			]);
		} else {
			print null;
		}
	}

	public function create()
	{
		$data_alert = null;
		$newsoal['idprak'] = $this->input->post('txtprak');
		$newsoal['jabaran'] = $this->input->post('txtjab');
		$newsoal['idjenis'] = $this->input->post('jenis');
		$newopsi['kunci'] = $this->input->post('opsi');
		$newopsi['list_opsi'] = $this->input->post('txtopsi[]');
		
		$result_soal = $this->m_soal->create($newsoal);
		if ($result_soal) {
			$newopsi['idsoal'] = $this->m_soal->getlastid();
		}
		$result_opsi = null;
		if (is_null($newopsi['kunci'])) {
			$result_opsi = true;
		} else {
			$result_opsi = $this->m_opsi->create_n_kunci($newopsi);
		}
		
		if ($result_soal && $result_opsi) {
			$data_alert = [
				'status' => 'success',
				'message' => "Berhasil Tambah Data Soal!"
			];
		} else {
			$data_alert = [
				'status' => 'danger',
				'message' => "Gagal Tambah Data Soal!"
			];
		}

		$this->session->set_flashdata('alert', $data_alert);
		redirect(site_url('manage-soal'));
	}
	
	public function update()
	{
		$data_alert = null;
		$newdata['idsoal'] = $this->input->get('no');
		$newdata['idprak'] = $this->input->post('etxtprak');
		$newdata['jabaran'] = $this->input->post('etxtjab');
		$newdata['kunci'] = $this->input->post('eopsi');
		$newdata['list_opsi'] = $this->input->post('etxtopsi[]');
		$newdata['list_opsiasli'] = $this->m_opsi->search('idsoal',$newdata['idsoal'], 'id');
		$newdata['list_combine'] = array_combine($newdata['list_opsiasli'], $newdata['list_opsi']);

		$prep_updateopsi = [
			'idsoal' => $newdata['idsoal'],
			'list_opsi' => $newdata['list_combine']
		];
		$prep_updatesoal = [
			'id' => $newdata['idsoal'],
			'idprak' => $newdata['idprak'],
			'jabaran' => $newdata['jabaran']
		];
		$prep_kunci = [
			'idsoal' => $newdata['idsoal'],
			'idopsi' => $newdata['kunci']
		];

		$update_opsi = $this->m_opsi->update($prep_updateopsi);
		$update_soal = $this->m_soal->update($prep_updatesoal);
		$update_kunci = $this->m_opsi->update_kunci($prep_kunci);
		$result_all = $update_opsi * $update_soal * $update_kunci;

		if ($result_all) {
			$data_alert = [
				'status' => 'success',
				'message' => "Berhasil Edit Data Soal!"
			];
		} else {
			$data_alert = [
				'status' => 'danger',
				'message' => "Gagal Edit Data Soal!"
			];
		}

		$this->session->set_flashdata('alert', $data_alert);
		redirect(site_url('manage-soal'));
	}
	
	public function delete()
	{
		$data_alert = null;
		$idsoal = $this->input->get('n');
		$result = $this->m_soal->delete($idsoal);
		if ($result) {
			$data_alert = [
				'status' => 'success',
				'message' => "Berhasil Hapus Data Soal!"
			];
		} else {
			$data_alert = [
				'status' => 'danger',
				'message' => "Gagal Hapus Data Soal!"
			];
		}

		$this->session->set_flashdata('alert', $data_alert);
		redirect(site_url('manage-soal'));
	}
	
	// ----------------------- Pretest -------------------------
	public function show_pretest()
	{
		$data['page'] = 'PRETEST';
		$data['sidebar_menu'] = $this->m_praktikum->getalljudul();
		$data['linkjs'] = base_url('assets/js/custom/manage_pretest.js');
		$data['content_page'] = 'assignment/manage/Pretest_view';
		$data['content_data'] = [
			'alert' => $this->alert,
			'opsi_prak' => $data['sidebar_menu'],
			'list_pretest' => $this->m_setso->get_allsoal('1'),
			'list_pretestid' => null,
			'list_soal' => $this->list_soal,
			'list_total' => $this->m_setso->get_total('1')
		];
		foreach ($data['content_data']['list_pretest'] as $key => $value) {
			$data['content_data']['list_pretestid'][$key] = $value['idsoal'];
		}
		$this->load->view('template/admin/Admin_view', $data);
	}
	public function set_pretest()
	{
		$idprak = $this->input->get('opsi-prak');
		$this->list_soal = $this->m_soal->search(['idjenis' => '1', 'idprak' => $idprak]);
		$this->session->set_flashdata('list', $this->list_soal);
		redirect(site_url('manage-soal/pretest'));
	}
	public function edit_pretest()
	{
		$newdata['idsoal'] = $this->input->post('txtsoal[]');
		$newdata['oldid'] = $this->input->post('current[]');
		$list_discarded = null;
		if (count($newdata['idsoal']) > 0) {
			$list_discarded = array_diff($newdata['idsoal'], $newdata['oldid']);
		} else {
			$list_discarded = $newdata['oldid'];
		}
		$error_counter = 0;
		// hapus idsoal yang tidak terpilih dari setsoal
		if (count($list_discarded) > 0) {
			$list_idsoal = [];
			foreach ($list_discarded as $key => $value) {
				$data_prep = $this->m_setso->search(['idsoal' => $value, 'idassess' => '1'], null, 'id');
				if ($data_prep) {
					$list_idsoal[$key] = $data_prep[0];
				}
			}
			if (count($list_idsoal) > 0) {
				foreach ($list_idsoal as $key => $value) {
					$result = $this->m_setso->delete($value);
					if (!$result) {
						$error_counter++;
					}
				}
			}
		}
		// daftarkan idsoal terpilih di setsoal
		if (count($newdata['idsoal']) > 0) {
			$new_idsoal = [];
			foreach ($newdata['idsoal'] as $key => $value) {
				echo $value;
				echo "<br/>";
				$data_prep = $this->m_setso->search(['idsoal' => $value, 'idassess' => '1'], null, 'id');
				if (!$data_prep) {
					$new_idsoal[] = $value;
				}
			}
			if (count($new_idsoal) > 0) {
				foreach ($new_idsoal as $key => $value) {
					$result = $this->m_setso->create(['idsoal' => $value, 'idassess' => '1']);
					if (!$result) {
						$error_counter++;
					}
				}
			}
		}
		
		if ($error_counter == 0) {
			$data_alert = [
				'status' => 'success',
				'message' => "Berhasil Ubah Data Pretest!"
			];
		} else {
			$data_alert = [
				'status' => 'danger',
				'message' => "Gagal Ubah Data Pretest!"
			];
		}

		$this->session->set_flashdata('alert', $data_alert);
		redirect(site_url('manage-soal/pretest'));
	}

	// ------------------------- Ujian --------------------------
	public function show_ujian()
	{
		$data['page'] = 'UJIAN';
		$data['sidebar_menu'] = $this->m_praktikum->getalljudul();
		$data['linkjs'] = base_url('assets/js/custom/manage_ujian.js');
		$data['content_page'] = 'assignment/manage/Ujian_view';
		$data['content_data'] = [
			'alert' => $this->alert,
			'list_ujian' => $this->list_ujian,
			'total_ujian1' => $this->m_setso->get_total('2'),
			'total_ujian2' => $this->m_setso->get_total('3'),
			'opsi_prak' => $data['sidebar_menu'],
			'judul_daftar' => $this->judul_daftar,
			'bank' => $this->bank,
			'prak' => $this->idprak
		];
		$this->load->view('template/admin/Admin_view', $data);
	}

	public function set_ujian()
	{
		$idprak = $this->input->get('opsi-prak');
		$list_soal1 = $this->m_assess->get_set($idprak, '2');
		$list_soal2 = $this->m_assess->get_set($idprak, '3');
		$judul_daftar = $this->m_praktikum->get_judul($idprak);
		$this->bank = $this->m_soal->search(['idprak' => $idprak,'idjenis' => '2']);
		$this->session->set_flashdata('judul_daftar', $judul_daftar);
		$this->session->set_flashdata('idprak', $idprak);
		$this->session->set_flashdata('bank', $this->bank);
		$this->session->set_flashdata('list_ujian', ['ujian1' => $list_soal1, 'ujian2' => $list_soal2]);
		redirect('manage-soal/ujian');
	}

	public function list_ujian()
	{
		$idprak = $this->input->get('n');
		$idujian = $this->input->get('u');
		$list = $this->m_assess->get_set($idprak, $idujian, 'idsoal');
		$bank = $this->m_soal->search(['idprak' => $idprak, 'idjenis' => 2], null, 'id');
		header('Content-type:application/json;charset=utf-8');
		print json_encode(['list' => $list, 'bank' => $bank]);
	}

	public function edit_ujian()
	{
		$error_counter = 0;
		$idprak = $this->input->post('n');
		$idassess = $this->input->post('j');
		$idsoal_terpilih = $this->input->post('txtsoal[]');
		// mengambil dari model assessment karena diambil berdasarkan praktikum
		$old_idsoal_assess = $this->m_assess->get_set($idprak, $idassess, 'idsoal');
		$idsoal_prepdelete = null;
		$new_idsoal_assess = null;
		// hapus soal yang tidak terpilih
		if (count($idsoal_terpilih) > 0) {
			// bila idsoal dari praktikum belum sama sekali terdaftar di set soal
			if (count($old_idsoal_assess) > 0) {
				$idsoal_prepdelete = array_diff($old_idsoal_assess, $idsoal_terpilih);
			} else {
				$new_idsoal_assess = $idsoal_terpilih;
			}
		} else {
			$idsoal_prepdelete = $old_idsoal_assess;
		}

		$idsoal_prepdelete = array_map(function($idsoal) use ($idassess)
		{
			$result = $this->m_setso->search(['idsoal' => $idsoal, 'idassess' => $idassess], null, 'id');
			return ($result) ? $result[0] : null;
		}, $idsoal_prepdelete);

		if (count($idsoal_prepdelete) > 0) {
			foreach ($idsoal_prepdelete as $key => $value) {
				$result = $this->m_setso->delete($value);
				if (!$result) {
					$error_counter++;
				}
			}
		}
		if (count($new_idsoal_assess) > 0) {
			foreach ($new_idsoal_assess as $key => $value) {
				$result = $this->m_setso->create(['idsoal' => $value, 'idassess' => $idassess]);
				if (!$result) {
					$error_counter++;
				}
			}
		}
		// print json_encode([$idsoal_prepdelete, $new_idsoal_assess, $old_idsoal_assess]);

		$data_alert = null;
		if ($error_counter == 0) {
			$data_alert = [
				'status' => 'success',
				'message' => "Berhasil Ubah Data Ujian!"
			];
		} else {
			$data_alert = [
				'status' => 'danger',
				'message' => "Gagal Ubah Data Ujian!"
			];
		}

		$this->session->set_flashdata('alert', $data_alert);
		redirect(site_url('manage-soal/ujian'));
	}
}