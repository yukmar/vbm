<?php
/**
 * 
 */
class Manage extends CI_Controller
{
	private $priv = null;
	protected $alert = null;
	function __construct()
	{
		parent::__construct();
		$this->priv = ($this->session->tempdata('priv')) ? $this->session->tempdata('priv') : null;
		if ($this->priv !== 'admin') {
			redirect(site_url('logout'));
		}
		$this->load->model([
			'praktikum/Praktikum_model' => 'm_praktikum'
		]);
		$this->alert = $this->session->flashdata('alert');
	}

	public function index()
	{
		show_404();
	}

	public function show()
	{
		$data['page'] = 'KELOLA PRAKTIKUM';
		$data['sidebar_menu'] = $this->m_praktikum->getalljudul();
		$data['linkjs'] = base_url('assets/js/custom/manage_praktikum.js');
		$data['content_page'] = 'praktikum/Manage_view';
		$data['content_data']['list_praktikum'] = $data['sidebar_menu'];
		$data['content_data']['alert'] = $this->alert;

		$this->load->view('template/admin/Admin_view', $data);
	}

	//start CRUD
	public function create()
	{
		$data_alert = NULL;
		$newdata['judul'] = $this->input->post('txtjudul');
		$newdata['desc'] = $this->input->post('txtdesc');
		$newdata['pdf'] = $this->input->post('txtpdf');
		$newdata['video'] = $this->input->post('txtvideo');

		$result = $this->m_praktikum->create($newdata);
		if ($result) {
			$data_alert = [
				'status' => 'success',
				'message' => "Berhasil Tambah Data Praktikum: <b>$newdata[judul]</b>!"
			];
		} else {
			$data_alert = [
				'status' => 'danger',
				'message' => "Gagal Tambah Data Praktikum: <b>$newdata[judul]</b>!"
			];
		}
		$this->session->set_flashdata('alert', $data_alert);
		redirect(site_url('manage-praktikum'));
	}

	public function update()
	{
		$data_alert = null;
		$newdata['id'] = $this->input->get('n');
		$newdata['judul'] = $this->input->post('etxtjudul');
		$newdata['desc'] = $this->input->post('etxtdesc');
		$newdata['pdf'] = $this->input->post('etxtpdf');
		$newdata['video'] = $this->input->post('etxtvideo');

		$result = $this->m_praktikum->update($newdata);
		if ($result) {
			$data_alert = [
				'status' => 'success',
				'message' => "Berhasil Edit Data Praktikum: <b>$newdata[judul]</b>!"
			];
		} else {
			$data_alert = [
				'status' => 'danger',
				'message' => "Gagal Edit Data Praktikum: <b>$newdata[judul]</b>!"
			];
		}

		$this->session->set_flashdata('alert', $data_alert);
		redirect(site_url('manage-praktikum'));
	}

	public function delete()
	{
		$data_alert = null;
		$no = $this->input->get('n');
		$judul = $this->m_praktikum->get_judul($no);
		$result = $this->m_praktikum->delete($no);
		if ($result) {
			$data_alert = [
				'status' => 'success',
				'message' => "Berhasil Hapus Data Praktikum: <b>$judul</b>!"
			];
		} else {
			$data_alert = [
				'status' => 'danger',
				'message' => "Gagal Hapus Data Praktikum: <b>$judul</b>!"
			];
		}
		$this->session->set_flashdata('alert', $data_alert);
		redirect(site_url('manage-praktikum'));
	}
	// end CRUD
	
	// start get data
	public function praktikum_set()
	{
		$id = $this->input->get('no');
		$result = $this->m_praktikum->get_set($id);
		header('Content-type:application/json;charset=utf-8');
		if ($result) {
			print json_encode($result);
		} else {
			print null;
		}
	}
	// end get data

}