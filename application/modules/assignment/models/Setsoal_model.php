<?php
/**
 * 
 */
class Setsoal_model extends CI_Model
{
	private $table = 'set_soal';
	// table view
	private $table_sets = 'sets_assessment';
	private $id = null;
	private $idassess = null;
	private $idsoal = null;
	private $fields = [
		'id' => 'id_set_soal',
		'idassess' => 'id_assessment',
		'idsoal' => 'id_soal'
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
						$newdata[$key][array_search(current($field), $this->fields)] = $this->value{current($field)};
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

	public function get_allsoal($idassess = null)
	{
		if ($idassess) {
			return $this->db->get_where($this->table_sets, ['idassess' => $idassess])->result_array();
		} else {
			return $this->db->get($this->table_sets)->result_array();
		}
	}

	public function get_total($idassess)
	{
		$this->idassess = $idassess;
		return $this->soal_assess();
	}

	public function create($newdata)
	{
		$data_prep[$this->fields['idsoal']] = $newdata['idsoal'];
		$data_prep[$this->fields['idassess']] = $newdata['idassess'];

		return $this->db->insert($this->table, $data_prep);
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

	public function get_setsoal($id, $jabaran = null)
	{
		$result = $this->db->get_where($this->table_sets, array('idset' => $id))->result_array();
		if ($jabaran) {
			return $result[0]['jabaran'];
		} else {
			return $result;
		}
	}

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

	private function soal_assess()
	{
		$q = "select prak.id_praktikum as idprak, 
					prak.nama_praktikum as judul, 
					case
					when sum(setso.id_assessment = $this->idassess) is null
					then 0
					else sum(setso.id_assessment = $this->idassess)
					end
					as total 
					from praktikum prak 
					left join soal on prak.id_praktikum = soal.id_praktikum 
					left join set_soal as setso on soal.id_soal = setso.id_soal 
					group by prak.id_praktikum";
		$result = $this->db->query($q)->result_array();
		return $result;
	}

	public function delete($id)
	{
		return $this->db->delete($this->table, [$this->fields['id'] => $id]);
	}
	// end query
}