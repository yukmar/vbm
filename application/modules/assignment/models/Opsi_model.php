<?php
/**
 * 
 */
class Opsi_model extends CI_Model
{
	private $table = 'opsi';
	private $table_kunci = 'kunci_jawab';
	private $id = null;
	private $idsoal = null;
	private $jabaran = null;
	private $fields = [
		'id' => 'id_opsi',
		'idsoal' => 'id_soal',
		'jabaran' => 'jabaran_opsi'
	];
	function __construct()
	{
		parent::__construct();
	}
	private function reconstruct($result_set, $field = null)
	{
		$newdata = [];
		foreach ($result_set as $key => $value) {
			if ($field) {
				if (is_array($field)) {
					reset($field);
					do {
						$newdata[$key][array_search(current($field), $this->fields)] = $value->{current($field)};
					} while (next($field));
				} else {
					$newdata[$key] = $value->{$field};
				}
			} else {
				reset($this->fields);
				do {
					$newdata[$key][key($this->fields)] = $value->{current($this->fields)};
				} while (next($this->fields));
			}
		}
		return $newdata;
	}
	public function get_kunci($idsoal)
	{
		$result_set = $this->db->get_where($this->table_kunci, ['id_soal' => $idsoal])->result();
		if ($result_set) {
			return $result_set[0]->id_opsi;
		} else {
			return null;
		}
	}
	public function search($field, $value = null, $return = null)
	{
		if (is_array($field)) {
			$field = array_flip(array_map(function($key)
			{
				if (array_key_exists($key, $this->fields)) {
					return $this->fields[$key];
				} else {
					return 'notfound';
				}
			}, array_flip($field)));
			if (array_key_exists('notfound', $field)) {
				return null;
			}
		} else {
			if (array_key_exists($field, $this->fields)) {
				$field = $this->fields[$field];
			} else {
				return null;
			}
		}
		$return = $return ? $this->fields[$return] : null;
		return $this->search_data($field, $value, $return);
	}
	public function update($newdata)
	{
		$this->idsoal = $newdata['idsoal'];
		return $this->update_data($newdata['list_opsi']);
	}
	public function update_kunci($data_update)
	{
		$data_prep = array_flip(array_map(function($key)
		{
			return ($key == 'idopsi') ? $this->fields['id'] : $this->fields[$key];
		}, array_flip($data_update)));
		return $this->db->update($this->table_kunci, $data_prep, [$this->fields['idsoal'] => $data_update['idsoal']]);
	}
	public function create_n_kunci($newdata)
	{
		$this->idsoal = $newdata['idsoal'];
		foreach ($newdata['list_opsi'] as $key => $jabaran) {
			$this->insert($jabaran);
			if ($key == $newdata['kunci']) {
				$this->insert_kunci($this->last_id());
			}
		}
		return true;
	}
	// ----------------------- private methods -----------------------
	private function insert($newval)
	{
		$data_prep = [
			$this->fields['idsoal'] => $this->idsoal,
			$this->fields['jabaran'] => $newval
		];
		$this->db->insert($this->table, $data_prep);
	}
	private function insert_kunci($id)
	{
		$data_prep = [
			$this->fields['id'] => $id,
			$this->fields['idsoal'] => $this->idsoal
		];
		$this->db->insert($this->table_kunci, $data_prep);
	}
	private function last_id()
	{
		return $this->db->order_by($this->fields['id'], 'DESC')->get($this->table)->result()[0]->{$this->fields['id']};
	}
	private function search_data($field, $value = null, $return = null)
	{
		$result_set = null;
		if (is_array($field)) {
			$result_set = $this->db->order_by($this->fields['id'], 'ASC')->get_where($this->table, $field);
		} else {
			if (!$value) {
				return null;
			} else {
				$result_set = $this->db->order_by($this->fields['id'], 'ASC')->get_where($this->table, [$field => $value]);
			}
		}
		return $this->reconstruct($result_set->result(), $return);
	}
	private function update_data($data_update)
	{
		$success = 1;
		foreach ($data_update as $id => $jabaran) {
			$data_prep = [
				$this->fields['idsoal'] => $this->idsoal,
				$this->fields['jabaran'] => $jabaran
			];
			$result = $this->db->update($this->table, $data_prep, [$this->fields['id'] => $id]);
			$success = ($result) ? $success * 1 : $success * 0;
		}
		return ($success == 1) ? true : false;
	}
}