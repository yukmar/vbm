<?php
/**
 * 
 */
class Login_model extends CI_Model
{
	private $table = 'user';
	private $table_priv = 'user_priv';

	function __construct()
	{
		parent::__construct();
	}

	public function validation($data)
	{
		if (!isset($data['username'])) {
			return null;
		}

		$q = $this->db->get_where($this->table, array('username' => $data['username'], 'password' => $data['password']));
		$result = $q->result();
		if ($result) {
			$priv = $this->db->get_where($this->table_priv, array('id_priv' => $result[0]->id_priv))->result()[0]->name_priv;
			return [
				'id' => $result[0]->id_user,
				'priv' => $priv
			];
		} else {
			return NULL;
		}
	}
}