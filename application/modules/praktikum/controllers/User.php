<?php
/**
 * 
 */
class User extends CI_Controller
{
	private $iduser = null;
	private $valid = null;
	function __construct()
	{
		parent::__construct();
		$this->load->model('praktikum/Praktikum_model', 'm_praktikum');
		$this->valid = $this->session->tempdata('valid');
		$this->iduser = $this->session->tempdata('iduser');
		if (!$this->iduser) {
			redirect(site_url());
		}
		if (!$this->valid) {
			redirect(site_url('pretest'));
		}
	}

	public function index()
	{
		show_404();
	}

	public function show($nomer_praktikum)
	{
		
		$data = array();
		$data['content_page'] = 'praktikum/User_view';
		$data['content_data'] = $this->m_praktikum->get_set($nomer_praktikum);
		$data['page'] = 'Praktikum';
		$data['sidebar_list'] = $this->m_praktikum->get_list_id($this->valid);


		$this->load->view('template/user/User_view', $data);
	}
}