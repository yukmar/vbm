<?php
/**
 * 
 */
class User_model extends CI_Model
{
	private $table = 'user';

	private $id = null;
	private $idmhs = null;
	private $username = null;
	private $pass = null;
	private $idpriv = null;

	private $field_id = "id_user";
	private $field_idmhs = "id_mahasiswa";
	private $field_username = "username";
	private $field_pass = "password";
	private $field_idpriv = "id_priv";

	private $newfield_id = "id";
	private $newfield_idmhs = "idmhs";
	private $newfield_username = "username";
	private $newfield_pass = "pass";
	private $newfield_idpriv = "idpriv";

	function __construct()
	{
		parent::__construct();
	}

	private function reconstruct($field = null)
	{
		switch ($field) {
			case $this->field_id:
				return $this->id;
				break;
			case $this->field_idmhs:
				return $this->idmhs;
				break;
			case $this->field_username:
				return $this->username;
				break;
			case $this->field_pass:
				return $this->pass;
				break;
			case $this->field_idpriv:
				return $this->idpriv;
				break;
			
			default:
				return array(
					$this->newfield_id => $this->id,
					$this->newfield_idmhs => $this->idmhs,
					$this->newfield_username => $this->username,
					$this->newfield_pass => $this->pass,
					$this->newfield_idpriv => $this->idpriv
				);
				break;
		}
	}

	public function auth($username, $password)
	{
		$this->username = $username;
		$this->pass = $password;
		$result_set = $this->db->get_where($this->table, array($this->field_username => $this->username, $this->field_pass => $this->pass))->result();
		if ($result_set) {
			$data = array();
			foreach ($result_set as $key => $value) {
				$this->id = $value->{$this->field_id};
				$this->idmhs = $value->{$this->field_idmhs};
				$this->username = $value->{$this->field_username};
				$this->pass = $value->{$this->field_pass};
				$this->idpriv = $value->{$this->field_idpriv};
				$data[] = $this->reconstruct();
			}
			return $data;
		} else {
			return null;
		}
	}
}