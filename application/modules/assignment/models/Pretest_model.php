<?php
/**
 * Menampilkan dan ngolola data-data pretest
 */
class Pretest_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_soal($total = null)
	{
		// $q = select s.id_soal as idsoal, s.jabaran_soal as jabaran, op.id_opsi as idopsi, op.jabaran_opsi as jabops, s.id_praktikum as idprak 
// from soal s 
// left join set_soal st on s.id_soal = st.id_soal 
// left join opsi op on s.id_soal = op.id_soal
// where st.id_assessment = 1
		$q = $this->db->select("s.id_soal as idsoal, 
													s.jabaran_soal as jabaran,
													s.id_praktikum as idprak")
									->from('soal s')
									->join('set_soal st', 's.id_soal = st.id_soal', 'left')
									->where('st.id_assessment', '1');
		if ($total) {
			$result = $q->count_all_results();
			return $result;
		}
		$result = $q->get()->result();
		if ($result) {
			foreach ($result as $key => $value) {
				$result[$key]->opsi = $this->get_opsi($value->idsoal);
			}
			return $result;
		} else {
			return null;
		}
	}

	public function get_opsi($idsoal)
	{
		$q = $this->db->select('id_opsi as idopsi, jabaran_opsi as jabops')
									->from('opsi')
									->where('id_soal', $idsoal);
		$result = $q->get()->result();
		if ($result) {
			return $result;
		} else {
			return null;
		}
	}

	public function cek_jawaban($jawaban)
	{
		$q = $this->db->get_where('kunci_jawab', array('id_opsi' => $jawaban));
		$result = $q->result();
		if ($result) {
			return $result;
		} else {
			return null;
		}
	}
}