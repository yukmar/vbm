<?php
/**
 * 
 */
class Praktikum_model extends CI_Model
{
	// table name
	private $table = "praktikum";

	// variable value
	private $id = null;
	private $idmatkul = 1;
	private $judul = null;
	private $desc = null;
	private $pdf = null;
	private $video = null;
	private $fields = [
		'id' => 'id_praktikum',
		'idmatkul' => 'id_matkul',
		'judul' => 'nama_praktikum',
		'desc' => 'desc_praktikum',
		'pdf' => 'pdf',
		'video' => 'video'
	];

	// start reconstruct result with alter name field
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
	// end reconstruct

	// start represent methods
	public function index()
	{
		show_404();
	}
	
	public function get_all($limit = null)
	{
		return $this->all($limit);
	}

	public function get_set($id)
	{
		$this->id = $id;
		return $this->selected_set();
	}

	public function get_list_id($limit = null)
	{
		return $this->list_id($limit);
	}

	public function get_judul($id)
	{
		$this->id = $id;
		return $this->selected_set()['judul'];
	}

	public function getalljudul()
	{
		return $this->reconstruct($this->db->get($this->table)->result(), [$this->fields['id'], $this->fields['judul']]);
	}

	public function create($newdata)
	{
		$arr_field = ['judul','desc','pdf','video'];
		for ($i=0; $i < count($arr_field); $i++) { 
			if (!isset($newdata[$arr_field[$i]]) || !$newdata[$arr_field[$i]]) {
				return null;
			} else {
				$this->{$arr_field[$i]} = $newdata[$arr_field[$i]];
			}
		}
		return $this->insert();
	}

	public function update($newdata)
	{
		$arr_field = ['id','judul','desc','pdf','video'];
		for ($i=0; $i < count($arr_field); $i++) { 
			if(!isset($newdata[$arr_field[$i]]) || !$newdata[$arr_field[$i]]){
				return null;
			} else {
				$this->{$arr_field[$i]} = $newdata[$arr_field[$i]];
			}
		}
		return $this->update_data();
	}

	public function delete($id)
	{
		$this->id = $id;
		return $this->del();
	}

	public function total()
	{
		return $this->db->count_all_results($this->table);
	}
	// end represent methods

	// start query
	private function selected_set()
	{
		$result_set = $this->db->get_where($this->table, array($this->fields['id'] => $this->id))->result();
		if ($result_set) {
			return $this->reconstruct($result_set)[0];
		} else {
			return null;
		}
	}

	private function all($limit = null)
	{
		$result_set = null;
		if ($limit) {
			$result_set = $this->db->limit($limit)->get($this->table)->result();
		} else {
			$result_set = $this->db->get($this->table)->result();
		}
		return $this->reconstruct($result_set);
	}

	private function list_id($limit = null)
	{
		$result_set = null;
		if ($limit) {
			$result_set = $this->db->limit($limit)->get($this->table)->result();
		} else {
			$result_set = $this->db->get($this->table)->result();
		}
		return $this->reconstruct($result_set, $this->fields['id']);
	}

	private function insert()
	{
		$prepdata = [
			$this->fields['idmatkul'] => $this->idmatkul,
			$this->fields['judul'] => $this->judul,
			$this->fields['desc'] => $this->desc,
			$this->fields['pdf'] => $this->pdf,
			$this->fields['video'] => $this->video
		];
		return $this->db->insert($this->table, $prepdata);
	}

	private function update_data()
	{
		$prepdata = [
			$this->fields['judul'] => $this->judul,
			$this->fields['desc'] => $this->desc,
			$this->fields['pdf'] => $this->pdf,
			$this->fields['video'] => $this->video
		];
		return $this->db->update($this->table, $prepdata, [$this->fields['id'] => $this->id]);
	}

	private function del()
	{
		return $this->db->delete($this->table, [$this->fields['id'] => $this->id]);
	}
	// end query

}