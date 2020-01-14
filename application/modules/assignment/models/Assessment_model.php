<?php
/**
 * 
 */
class Assessment_model extends CI_Model
{
	// var table name
	private $table = 'jenis_assessment';

	// variable value
	private $id = null;
	private $nama = null;
	private $fields = [
		'id' => 'id_assessment',
		'nama' => 'nama_assessment'
	];

	function __construct()
	{
		parent::__construct();
	}

	private function reconstruct($return_set, $field = null)
	{
		$newdata = [];
		foreach ($return_set as $key => $value) {
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

	// start represent
	public function get_all()
	{
		return $this->all();
	}
	public function search($field, $value, $return = null)
	{
		$field = array_key_exists($field, $this->fields)? $this->fields[$field] : null;
		if (!$field) {
			return null;
		}
		$return = $return ? $this->fields[$return] : null;
		return $this->query_search($field, $value, $return);
	}
	public function get_set($idprak, $idassess, $return = null)
	{
		$q = "select soal.id_soal as idsoal, soal.jabaran_soal as jabaran from soal where soal.id_praktikum = $idprak and soal.id_soal in (select set_soal.id_soal from set_soal where set_soal.id_assessment = (select jenis_assessment.id_assessment from jenis_assessment where jenis_assessment.id_assessment = $idassess))";
		if ($return) {
			$newdata = [];
			foreach ($this->db->query($q)->result_array() as $key => $value) {
				$newdata[$key] = $value[$return];
			}
			return $newdata;
		} else {
			return $this->db->query($q)->result_array();
		}
	}
	// end represent

	// start query
	private function all()
	{
		$result_set = $this->db->get($this->table)->result();
		if ($result_set) {
			return $this->reconstruct($result_set);
		} else {
			return null;
		}
	}

	private function query_search($field, $value, $return = null)
	{
		$result_set = $this->db->get_where($this->table, array($field => $value))->result();
		if ($result_set) {
			return $this->reconstruct($result_set, $return);
		} else {
			return null;
		}
	}
	// end query
}