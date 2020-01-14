<?php
/**
 * 
 */
class Frontpage extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model', 'm_user');
	}

	public function index()
	{
		$result = $this->m_user->auth('Purwadi64', 'Purwad64');
		var_dump($result);
	}
}