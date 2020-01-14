<?php
/**
 * 
 */
class Soal_model extends CI_Model
{
	// var table name
	private $table = 'soal';
	// table view
	private $table_totalprak = 'total_soalprak';
	// variable value
	private $id = null;
	private $jabaran = null;
	private $idprak = null;
	private $idjenis = null;
	private $idassess = null;
	private $fields = [
		'id' => 'id_soal',
		'jabaran' => 'jabaran_soal',
		'idprak' => 'id_praktikum',
		'idjenis' => 'id_jenis_soal',
	];

	function __construct()
	{
		parent::__construct();
		$this->load->model('assignment/Assessment_model', 'm_assess');
		$this->load->model('assignment/Setsoal_model', 'm_setsoal');
	}

	public function reconstruct($result_set, $field = null)
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
	// start represent methods
	public function get_all($field = null)
	{
		return $this->all($field);
	}

	public function get_set($no_praktikum, $idassess)
	{
		$this->idprak = $no_praktikum;
		$this->idassess = $idassess;
		return $this->selected_set();
	}

	public function get_total_perprak()
	{
		return $this->db->get($this->table_totalprak)->result_array();
	}

	public function search($field, $value = null, $return = null)
	{
		$newfield = [];
		if (is_array($field)) {
			foreach ($field as $key => $value) {
				$newfield[$this->fields[$key]] = $value;
			}
		} else {
			if (array_key_exists($field, $this->fields)) {
				$newfield = $this->fields[$field];
			} else {
				return null;
			}
		}
		$return = $return ? $this->fields[$return] : null;
		return $this->search_data($newfield, $value, $return);
	}
	public function create($newdata)
	{
		$data_prep = null;
		foreach ($newdata as $key => $value) {
			$data_prep[$this->fields[$key]] = $value;
		}
		return $this->insert($data_prep);
	}
	public function update($data_update)
	{
		$this->id = $data_update['id'];
		$data_prep = array_flip(array_map(function($key)
		{
			return $this->fields[$key];
		}, array_flip($data_update)));
		return $this->update_data($data_prep);
	}
	public function getlastid()
	{
		return $this->db->order_by($this->fields['id'], 'DESC')->limit('1')->get($this->table)->result()[0]->{$this->fields['id']};
	}
	public function delete($id)
	{
		return $this->db->delete($this->table, [$this->fields['id'] => $id]);
	}
	// end represent methods
	
	// start query
	private function search_data($field, $value = null, $return = null)
	{
		$result_set = null;
		if (is_array($field)) {
			$result_set = $this->db->get_where($this->table, $field);
		} else {
			if (!$value) {
				return null;
			} else {
				$result_set = $this->db->get_where($this->table, [$field => $value]);
			}
		}
		return $this->reconstruct($result_set->result(), $return);
	}
	private function all($field = null)
	{
		$result_set = null;
		if ($field) {
			if (is_array($field)) {
				$field = array_map(function($data)
				{
					return $this->fields[$data];
				}, $field);
				$result_set = $this->db->select($field)->get($this->table);
			} else {
				if (array_key_exists($field, $this->fields)) {
					$result_set = $this->db->select($field)->get($this->table);
				} else {
					return null;
				}
			}
		} else {
			$result_set = $this->db->get($this->table);
		}
		return $this->reconstruct($result_set->result(), $field);
	}

	private function selected_set()
	{
		// query: select soal.id_soal as idsoal, soal.jabaran_soal as jabaran from soal where soal.id_praktikum = 2 and soal.id_soal in (select set_soal.id_soal from set_soal where set_soal.id_assessment = (select jenis_assessment.id_assessment from jenis_assessment where jenis_assessment.nama_assessment = 'ujian'));
		$setsoal_idsoal = $this->m_setsoal->search('idassess', $this->idassess, 'idsoal');
		$result_set = $this->db->select("$this->table.{$this->fields['id']} as {$this->fields['id']}, 
															$this->table.{$this->fields['jabaran']} as {$this->fields['jabaran']},
															$this->table.{$this->fields['idprak']} as {$this->fields['idprak']},
															$this->table.{$this->fields['idjenis']} as {$this->fields['idjenis']}")
										->from($this->table)
										->where("$this->table.{$this->fields['idprak']} = $this->idprak")
										->where_in("$this->table.{$this->fields['id']}", $setsoal_idsoal)->get()->result();
		if ($result_set) {
			return $this->reconstruct($result_set);
		} else {
			return null;
		}
	}
	private function update_data($data_update)
	{
		return $this->db->update($this->table, $data_update, [$this->fields['id'] => $this->id]);
	}
	public function insert($newdata)
	{
		return $this->db->insert($this->table, $newdata);
	}
	// end query
}