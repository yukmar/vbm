<?php
/**
 * 
 */
class Detailpengerjaan_model extends CI_Model
{
	private $table = 'detail_pengerjaan';
	// table view
	private $table_detnilai = 'detail_penilaian';
	private $id = null;
	private $iduser = null;
	private $fields = [
		'id' => 'id_detail_pengerjaan',
		'iduser' => 'id_user',
		'tgl' => 'tgl_pengerjaan',
		'nilai' => 'penilaian'
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

	public function create($iduser)
	{
		return $this->db->insert($this->table, [$this->fields['iduser'] => $iduser]);
	}

	public function nilai($id, $nilai)
	{
		if (!$this->search('id', $id)) {
			return null;
		}
		$data_prep = [$this->fields['nilai'] => $nilai];
		$index = [$this->fields['id'] => $id];
		return $this->db->update($this->table, $data_prep, $index);
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

	public function get_lastid()
	{
		return $this->db->order_by($this->fields['id'], 'DESC')->limit('1')->get($this->table)->result()[0]->{$this->fields['id']};
	}

	public function detail_nilai($idprak, $idassess, $nilai_stat, $group = null)
	{
		$q = "idset in (select idset from sets_assessment where idprak = $idprak and idassess = $idassess) and nilai $nilai_stat";
		$result = null;
		if ($group) {
			$result = $this->db->where($q)->group_by('iddet');
		} else {
			$result = $this->db->where($q);
		}
		return $result->get($this->table_detnilai)->result_array();
	}

	public function update_nilai($id, $nilai)
	{
		$this->db->update($this->table, [$this->fields['nilai'] => $nilai], [$this->fields['id'] => $id]);
		return $this->db->affected_rows();
	}

	public function detail_nilaioff($idprak, $idassess, $idoff, $total = null)
	{
		// select distinct iddet, iduser from detail_penilaian where idset in (select idset from sets_assessment where idprak = 2) and idoff = 3 and nilai is not null;
		$data = null;
		$q = "select distinct iddet, iduser, nilai from detail_penilaian where idset in (select idset from sets_assessment where idprak = $idprak and idassess = $idassess) and idoff = $idoff and ";
		$kkm = $q."nilai >= 80";
		$under_kkm = $q."nilai < 80";
		$unchecked = $q."nilai is null";
		if ($total) {
			$data['kkm'] = $this->db->query($kkm)->num_rows();
			$data['under_kkm'] = $this->db->query($under_kkm)->num_rows();
			$data['unchecked'] = $this->db->query($unchecked)->num_rows();
		} else {
			$data['kkm'] = $this->db->query($kkm)->result_array();
			$data['under_kkm'] = $this->db->query($under_kkm)->result_array();
			$data['unchecked'] = $this->db->query($unchecked)->result_array();
		}
		return $data;
	}
}