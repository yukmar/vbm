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
			'user/User_model' => 'm_user',
			'user/Offering_model' => 'm_off',
			'user/Mahasiswa_model' => 'm_mhs',
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
		$data['page'] = 'KELOLA USER';
		$data['sidebar_menu'] = $this->m_praktikum->getalljudul();
		$data['content_page'] = 'user/Manage_view';
		$data['content_data']['user_list'] = $this->m_user->getall();
		$data['content_data']['total_offering'] = $this->m_off->get_total();
		$data['content_data']['alert'] = $this->alert;
		$data['linkjs'] = base_url('assets/js/custom/manage_user.js');
		$this->load->view('template/admin/Admin_view', $data);
	}

	// start CRUD
	public function create()
	{
		// ------------------ data mahasiswa -------------------
		$newmhs['nama'] = $this->input->post('txtnama');
		$newmhs['idoff'] = $this->input->post('txtoff');
		// -----------------------------------------------------
		// --------------------- data user ---------------------
		$newuser['username'] = $this->input->post('txtuser');
		$newuser['pass'] = $this->input->post('txtpass');
		$newuser['idpriv'] = $this->input->post('txtpriv');
		// -----------------------------------------------------
		// --------------------- create data mahasiswa ---------------------
		$result = $this->m_mhs->create($newmhs);
		if ($result) {
			$newuser['idmhs'] = $this->m_mhs->search('nama', $newmhs['nama'], 'id')[0];
		} else {
			echo 'error '.$result;
		}
		// -----------------------------------------------------------------
		// ----------------------- create data user ------------------------
		$result = $this->m_user->create($newuser);
		// -----------------------------------------------------------------
		if ($result) {
			$this->alert = [
				'status' => 'success',
				'message' => "Berhasil Tambah User: <b>$newdata[user]</b>!"
			];
		} else {
			$this->alert = [
				'status' => 'danger',
				'message' => "Gagal Tambah User: <b>$newdata[user]</b>!"
			];
		}
		$this->session->set_flashdata('alert', $this->alert);
		redirect(site_url('manage-user'));
	}

	public function update()
	{
		$data_user['idpriv'] = $this->input->post('etxtpriv');
		$data_user['username'] = $this->input->post('etxtuser');
		$data_mhs['nama'] = $this->input->post('etxtnama');
		$data_mhs['idoff'] = $this->input->post('etxtoff');
		if ($this->input->post('etxtpass')) {
			$data_user['pass'] = $this->input->post('etxtpass');
		}
		// update data mahasiswa
		$data_mhs['idmhs'] = $this->m_user->search('username', $data_user['username'], 'idmhs')[0];
		$this->m_mhs->update($data_mhs);
		// update data user
		$result = $this->m_user->update($data_user);
		if ($result) {
			$this->alert = [
				'status' => 'success',
				'message' => "Berhasil Edit User: <b>$data_user[username]</b>!"
			];
		} else {
			$this->alert = [
				'status' => 'danger',
				'message' => "Gagal Edit User: <b>$data_user[username]</b>!"
			];
		}
		$this->session->set_flashdata('alert', $this->alert);
		redirect(site_url('manage-user'));
	}

	public function delete()
	{
		$id = $this->input->get('n');
		$user_set = $this->m_user->search('id', $id)[0];
		$result = $this->m_mhs->delete($user_set['idmhs']);
		if ($result) {
			$this->alert = [
				'status' => 'success',
				'message' => "Berhasil Hapus User: <b>$user_set[username]</b>!"
			];
		} else {
			$this->alert = [
				'status' => 'danger',
				'message' => "Gagal Hapus User: <b>$user_set[username]</b>!"
			];
		}
		$this->session->set_flashdata('alert', $this->alert);
		redirect(site_url('manage-user'));
	}
	// end CRUD
	
	public function user_set()
	{
		$id = $this->input->get('n');
		$result = $this->m_user->get_set($id);
		header('Content-type:application/json;charset=utf-8');
		if ($result) {
			$return_data = [
				'priv' => $result[0]->idpriv,
				'user' => $result[0]->username,
				'nama' => $result[0]->nama,
				'off' => $result[0]->idoff
			];
			print json_encode($return_data);
		} else {
			print null;
		}
	}
}