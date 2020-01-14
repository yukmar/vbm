<?php
/**
 * 
 */
class Mahasiswa_model extends CI_Model
{
	private $table = 'mahasiswa';

	private $id = null;
	private $nama = null;
	private $idoff = null;

	private $fields = [
		'id' => 'id_mahasiswa',
		'nama' => 'nama_mahasiswa',
		'idoff' => 'id_offering'
	];

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [reconstruct description]
	 * @param  [array] $result_data [hasil dari query]
	 * @param  [string] $field       [nama return field asli]
	 * @return [array/string]        [array bila null, string bila terdapat return field]
	 */
	private function reconstruct($result_set, $field = null)
	{
		$newdata = [];
		foreach ($result_set as $index => $value) {
			reset($this->fields);
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
				do {
					if (isset($value->{current($this->fields)})) {
						$newdata[$index][key($this->fields)] = $value->{current($this->fields)};
					}
				} while (next($this->fields));
			}
		}
		return $newdata;		
	}

	// param: [field, value, return]
	public function search($field, $value, $return = null)
	{
		if (!array_key_exists($field, $this->fields)) {
			return null;
		}
		$prep_data['field'] = $this->fields[$field];
		$prep_data['value'] = $value;
		$prep_data['return'] = $return ? $this->fields[$return] : null;
		return $this->search_data($prep_data);
	}
	
	public function create($newdata)
	{
		// tampung keys array fields (merupakan alias dari fields)
		$arr_field = array_keys($this->fields);
		// menghilangkan elemen 1 (id) dari $arr_field
		array_shift($arr_field);
		for ($i=0; $i < count($arr_field); $i++) { 
			if (!isset($newdata[$arr_field[$i]]) || !$newdata[$arr_field[$i]]) {
				return null;
			} else {
				$this->{$arr_field[$i]} = $newdata[$arr_field[$i]];
			}
		}

		return $this->insert();
	}
	public function update($data_update)
	{
		if (!array_key_exists('idmhs', $data_update)) {
			return null;
		} else {
			$this->id = $data_update['idmhs'];
		}
		$prep_data = [
			$this->fields['nama'] => $data_update['nama'],
			$this->fields['idoff'] => $data_update['idoff']
		];
		var_dump($data_update);
		return $this->update_data($prep_data);
	}

	public function total()
	{
		return $this->db->count_all($this->table);
	}

	public function delete($id)
	{
		$this->id = $id;
		return $this->delete_data();
	}

	private function delete_data()
	{
		return $this->db->delete($this->table, [$this->fields['id'] => $this->id]);
	}

	private function update_data($prep_data)
	{
		return $this->db->update($this->table, $prep_data, [$this->fields['id'] => $this->id]);
	}

	private function search_data($search_data)
	{
		$result = $this->db->get_where($this->table, [$search_data['field'] => $search_data['value']])->result();
		if ($result) {
			return $this->reconstruct($result, $search_data['return']);
		} else {
			return null;
		}
	}

	private function insert()
	{
		$prep_data = [
			$this->fields['nama'] => $this->nama,
			$this->fields['idoff'] => $this->idoff
		];
		return $this->db->insert($this->table, $prep_data);
	}
}