<?php
/**
 * 
 */
class Dashboard extends CI_Controller
{
	private $iduser;
	private $valid = null;
	private $priv = null;

	function __construct(){
		parent::__construct();
		$this->iduser = ($this->session->tempdata('iduser')) ? $this->session->tempdata('iduser') : null;
		$this->valid = ($this->session->tempdata('valid')) ? $this->session->tempdata('valid') : null;
		$this->priv = ($this->session->tempdata('priv')) ? $this->session->tempdata('priv') : null;
		$this->load->model([
			'dashboard/Login_model' => 'login_m',
			'praktikum/Praktikum_model' => 'm_praktikum',
			'assignment/Soal_model' => 'm_soal',
			'penilaian/Pengerjaan_model' => 'm_pengerjaan'
		]);
	}

// start frontpage
	public function index()
	{
		switch ($this->priv) {
			case 'admin':
				$this->admin();
				break;
			
			case 'mahasiswa':
				$this->user();
				break;

			default:
				$this->load->view('Landing_view');
				break;
		}
	}

	public function login()
	{
		$data_login['username'] = $this->input->post('txtuser');
		$data_login['password'] = $this->input->post('txtpass');

		$result = $this->login_m->validation($data_login);
		if ($result) {
			$this->session->set_tempdata([
				'iduser' => $result['id'],
				'priv' => $result['priv']
			], NULL, 1200);
			redirect(site_url());
		} else {
			$this->load->view('Landing_view', array('error_login' => '<div class="alert alert-danger" role="alert">Gagal Login!</div>'));
		}
	}
// end frontpage

// start User
	private function user()
	{
		if (!$this->valid) {
			redirect(site_url('pretest'));
		}
		$data['sidebar_list'] = $this->m_praktikum->get_list_id($this->valid);
		$data['page'] = 'DASHBOARD';
		$data['content_data']['data'] = $this->m_praktikum->get_all($this->valid);
		$data['content_page'] = 'dashboard/User_view';
		$this->load->view('template/user/User_view', $data);
	}
// end User

// start admin
	private function admin()
	{
		$data['page'] = 'DASHBOARD';
		$data['sidebar_menu'] = $this->m_praktikum->getalljudul();
		$data['content_page'] = 'dashboard/Admin_view';
		$content['list_prak'] = $data['sidebar_menu'];
		foreach ($content['list_prak'] as $key => $value) {
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
			$content['list_prak'][$key]['unchecked'] = [
				'ujian1' => $ujian1,
				'ujian2' => $ujian2
			];
		}
		$data['content_data'] = $content;
		$this->load->view('template/admin/Admin_view', $data);
	}
// end admin

// start universal functions
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url());
	}
// end universal functions
}