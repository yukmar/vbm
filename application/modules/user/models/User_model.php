<?php
/**
 * table: user, user_priv
 * view: mhs_off
 */
class User_model extends CI_Model
{
	private $table = 'user';
	private $table_priv = 'user_priv';
	//  ------------ table view ------------
	private $table_mhsoff = 'mhs_off';
	// -------------------------------------
	//  ------------ variable atribut table user ------------
	private $id = null;
	private $idmhs = null;
	private $username = null;
	private $pass = null;
	// -------------------------------------
	//  ------------ variable table user & user_priv ------------
	private $idpriv = null;
	// -------------------------------------
	//  ------------ variable table user_priv ------------
	private $namepriv = null;
	// fields
	private $user_fields = [
		'id' => 'id_user',
		'idmhs' => 'id_mahasiswa',
		'username' => 'username',
		'pass' => 'password',
		'idpriv' => 'id_priv'
	];
	
	private $priv_fields = [
		'namepriv' => 'name_priv',
		'idpriv' => 'id_priv'
	];

	private $merge_fields = null;

	function __construct()
	{
		parent::__construct();
		$this->merge_fields = array_merge($this->user_fields, $this->priv_fields);
	}

	/**
	 * [reconstruct description]
	 * @param  object $result_set hasil dari query
	 * @param  string $field       field asli
	 * @return array/string              [description]
	 */
	public function reconstruct($result_set, $field = null)
	{
		$newdata = [];
		foreach ($result_set as $index => $value) {
			if ($field) {
				if (is_array($field)) {
					reset($field);
					do {
						$newdata[$key][array_search(current($field), $this->merge_fields)] = $value->{current($field)};
					} while (next($field));
				} else {					
					$newdata[$key] = $value->{$field};
				}
			} else {
				reset($this->merge_fields);
				do {
					if (isset($value->{current($this->merge_fields)})) {
						$newdata[$index][key($this->merge_fields)] = $value->{current($this->merge_fields)};
					}
				} while (next($this->merge_fields));
			}
		}
		return $newdata;
	}

	public function getall()
	{
		return $this->all();
	}

	public function get_set($id)
	{
		return $this->db->get_where($this->table_mhsoff, ['id' => $id])->result();
	}

	public function search($field, $value, $return = null)
	{
		if ((!array_key_exists($field, $this->merge_fields)) || ($return && (!array_key_exists($return, $this->merge_fields)))) {
			return null;
		}
		$prep_data['field'] = $this->merge_fields[$field];
		$prep_data['value'] = $value;
		$prep_data['return'] = $return ? $this->merge_fields[$return] : null;
		return $this->search_data($prep_data);
	}

	public function create($newdata)
	{
		$user_fields = array_keys($this->user_fields);
		array_shift($user_fields);
		foreach ($newdata as $key => $value) {
			if (in_array($key, $user_fields)) {
				$this->{$key} = $value;
			} else {
				return null;
			}
		}
		return $this->insert();
	}

	public function update($data_update)
	{
		if (!array_key_exists('username', $data_update)) {
			return null;
		} else {
			$this->username = $data_update['username'];
		}
		$prep_data[$this->user_fields['idpriv']] = $data_update['idpriv'];
		if (array_key_exists('pass', $data_update)) {
			$prep_data[$this->user_fields['password']] = $data_update['pass'];
		}
		return $this->update_data($prep_data);
	}

	private function update_data($prep_data)
	{
		return $this->db->update($this->table, $prep_data, [$this->user_fields['username'] => $this->username]);
	}

	private function insert()
	{
		$prep_data = [
			$this->user_fields['idmhs'] => $this->idmhs,
			$this->user_fields['username'] => $this->username,
			$this->user_fields['pass'] => $this->pass,
			$this->user_fields['idpriv'] => $this->idpriv
		];
		return $this->db->insert($this->table, $prep_data);
	}

	private function all()
	{
		$result = $this->db->get($this->table_mhsoff)->result();
		if ($result) {
			return $result;
		} else {
			return null;
		}
	}

	private function search_data($data_search)
	{
		$result = $this->db->get_where($this->table, [$data_search['field'] => $data_search['value']])->result();
		if ($result) {
			return $this->reconstruct($result, $data_search['return']);
		} else {
			return null;
		}
	}
}