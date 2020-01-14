<?php
/**
 * 
 */
class Pengerjaan_model extends CI_Model
{
	private $table = 'pengerjaan';
	private $idsoal = null;
	private $iddetail = null;
	private $jawaban = null;

	private $fields = [
		'iddetail' => 'id_detail_pengerjaan',
		'idsoal' => 'id_set_soal',
		'jawaban' => 'jawaban'
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

	public function create($idsoal, $iddetail, $jawaban = null)
	{
		$this->idsoal = $idsoal;
		$this->iddetail = $iddetail;
		$this->jawaban = $jawaban;
		if ($this->search(['idsoal' => $idsoal, 'iddetail' => $iddetail])) {
			return $this->update();
		} else {
			$data_prep = [
				$this->fields['idsoal'] => $idsoal,
				$this->fields['iddetail'] => $iddetail,
				$this->fields['jawaban'] => $jawaban
			];
			return $this->db->insert($this->table, $data_prep);
		}
	}

	public function update()
	{
		$data_prep = [
			$this->fields['idsoal'] => $this->idsoal,
			$this->fields['iddetail'] => $this->iddetail
		];
		return $this->db->update($this->table, [$this->fields['jawaban'] => $this->jawaban], $data_prep);
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

	public function cek_pengerjaan($iduser, $idprak, $idassess)
	{
		$q = "select * from pengerjaan where id_detail_pengerjaan in (select id_detail_pengerjaan from detail_pengerjaan where id_user = $iduser) and id_set_soal in (select idset as id_set_soal from sets_assessment where idprak = $idprak and idassess = $idassess)";
		$result = $this->db->query($q)->result();
		if ($result) {
			return $this->reconstruct($result);
		} else {
			return null;
		}
	}

	public function summary($idprak, $optional = null, $nilai = null)
	{
		// iduser = total user
		$q = "select  ase.id_assessment as idassess, prak.id_praktikum as idprak, count(distinct det.id_user) as iduser, off.id_offering as off from praktikum prak  left join soal on prak.id_praktikum = soal.id_praktikum  left join set_soal sets on soal.id_soal = sets.id_soal  right join jenis_assessment as ase on ase.id_assessment = sets.id_assessment  left join pengerjaan p on sets.id_set_soal = p.id_set_soal  left join detail_pengerjaan det on det.id_detail_pengerjaan = p.id_detail_pengerjaan  left join user on det.id_user = user.id_user left join mahasiswa mhs on user.id_mahasiswa = mhs.id_mahasiswa left join offering off on mhs.id_offering = off.id_offering where prak.id_praktikum = $idprak";
		if ($optional) {
			$tail = " group by idassess, idprak";
			if ($nilai == 'unchecked') {
				$q = $q . " and det.penilaian is null" . $tail;
			} else if ($nilai == 'checked') {
				$q = $q . " and det.penilaian is not null" . $tail;
			} else {
				$q = $q . $tail;
			}
		} else {
			$tail = " group by idassess, idprak, off";
			if ($nilai == 'unchecked') {
				$q = $q . " and det.penilaian is null" . $tail;
			} else if ($nilai == 'checked') {
				$q = $q . " and det.penilaian is not null" . $tail;
			} else {
				$q = $q . $tail;
			}
		}
		return $this->db->query($q)->result_array();
	}

	public function table_offnilai($idprak, $idassess, $idoff)
	{
		// select moff.id, moff.username, moff.nama,det.iddet, det.nilai from mhs_off moff left join (select distinct detpen.iddet, detpen.iduser, detpen.nama, detpen.idoff, detpen.nama_off, detpen.nilai, sets.idprak, sets.idassess from detail_penilaian detpen left join sets_assessment sets on detpen.idset = sets.idset where idprak = 2 and idassess = 2) det on moff.id = det.iduser where moff.idoff = 3 order by nilai desc, iddet desc;
		$q = "select moff.id, moff.username, moff.nama,det.iddet, det.nilai from mhs_off moff left join (select distinct detpen.iddet, detpen.iduser, detpen.nama, detpen.idoff, detpen.nama_off, detpen.nilai, sets.idprak, sets.idassess from detail_penilaian detpen left join sets_assessment sets on detpen.idset = sets.idset where idprak = $idprak and idassess = $idassess) det on moff.id = det.iduser where moff.idoff = $idoff order by nilai desc, iddet desc";
		return $this->db->query($q)->result_array();
	}
}