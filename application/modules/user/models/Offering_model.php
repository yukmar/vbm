<?php
/**
 * 
 */
class Offering_model extends CI_Model
{
	private $table = 'offering';
	// table view
	private $total_off = 'total_offering';
	// variable dari table offering
	private $id = null;
	private $nama = null;
	// daftar field alias => asli
	private $fields = [
		'id' => 'id_offering',
		'nama' => 'nama_offering'
	];

	function __construct()
	{
		parent::__construct();
	}
	/**
	 * [reconstruct description]
	 * @param  object array $result_set hasil dari query
	 * @param  string $field      field asli
	 * @return [type]             [description]
	 */
	public function reconstruct($result_set, $field = null)
	{
		$newdata = [];
		foreach ($result_set as $key => $value) {
			reset($this->fields);
			if ($field) {
				$newdata[$key] = $value->{$field};
			} else {
				do {
					if (isset($value->{current($this->fields)})) {
						$newdata[$key][key($this->fields)] = $value->{current($this->fields)};
					}
				} while (next($this->fields));
			}
		}
		return $newdata;
	}

	public function getall()
	{
		return $this->all();
	}

	public function get_total()
	{
		return $this->db->get($this->total_off)->result();
	}

	private function all()
	{
		$result = $this->db->get($this->table)->result();
		return $this->reconstruct($result);
	}
}