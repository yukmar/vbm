<?php
/**
 * 
 */
class Jenissoal_model extends CI_Model
{
	private $table = 'jenis_soal';
	private $id = null;
	private $nama = null;
	private $fields = [
		'id' => 'id_jenis_soal',
		'nama' => 'nama_jenis_soal'
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
				$newdata[$key] = $value->{$field};
			} else {
				reset($this->fields);
				do {
					$newdata[$key][key($this->fields)] = $value->{current($this->fields)};
				} while (next($this->fields));
			}
		}
		return $newdata;
	}
	public function getall()
	{
		return $this->all();
	}
	public function search($field, $value, $return = null)
	{
		if (!array_key_exists($field, $this->fields)) {
			return null;
		}
		$field = $this->fields[$field];
		$return = $return ? $this->fields[$return] : null;
		return $this->search_data($field, $value, $return);
	}
	private function search_data($field, $value, $return = null)
	{
		$result_set = $this->db->get_where($this->table, [$field => $value])->result();
		return $this->reconstruct($result_set, $return);
	}
	private function all()
	{
		return $this->reconstruct($this->db->get($this->table)->result());
	}
}