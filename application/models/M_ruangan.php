<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ruangan extends CI_Model {
	public function select_all_ruangan() {
		$sql = "SELECT * FROM ruangan";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_all() {
		$sql = " SELECT ruangan.id AS id, ruangan.nama AS ruangan, gereja.nama AS gereja,  category.nama AS category FROM ruangan, gereja, category WHERE ruangan.id_category = category.id AND ruangan.id_gereja = gereja.id";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT ruangan.id AS id_ruangan, ruangan.nama AS nama_ruangan, ruangan.id_gereja, ruangan.id_category, gereja.nama AS gereja, category.nama AS category FROM ruangan, gereja, category WHERE ruangan.id_gereja = gereja.id AND ruangan.id_category = category.id AND ruangan.id = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_by_category($id) {
		$sql = "SELECT COUNT(*) AS jml FROM ruangan WHERE id_category = {$id}";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_by_gereja($id) {
		$sql = "SELECT COUNT(*) AS jml FROM ruangan WHERE id_gereja = {$id}";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function update($data) {
		$sql = "UPDATE ruangan SET nama='" .$data['nama'] ."', id_gereja=" .$data['gereja'] .", id_category=" .$data['category'] ." WHERE id='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM ruangan WHERE id='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert($data) {
		$id = md5(DATE('ymdhms').rand());
		$sql = "INSERT INTO ruangan VALUES('{$id}','" .$data['nama'] ."'," .$data['gereja'] ."," .$data['jk'] ."," .$data['category'] .",1)";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		$this->db->insert_batch('ruangan', $data);
		
		return $this->db->affected_rows();
	}

	public function check_nama($nama) {
		$this->db->where('nama', $nama);
		$data = $this->db->get('ruangan');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('ruangan');

		return $data->num_rows();
	}
}

/* End of file M_ruangan.php */
/* Location: ./application/models/M_ruangan.php */