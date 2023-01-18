<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_category extends CI_Model {
	public function select_all() {
		$data = $this->db->get('category');

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT * FROM category WHERE id = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_by_ruangan($id) {
		$sql = " SELECT ruangan.id AS id, ruangan.nama AS ruangan, gereja.nama AS gereja, category.nama AS category FROM ruangan, gereja, category WHERE ruangan.id_category = category.id AND ruangan.id_gereja = gereja.id AND ruangan.id_category={$id}";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function insert($data) {
		$sql = "INSERT INTO category VALUES('','" .$data['category'] ."')";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		$this->db->insert_batch('category', $data);
		
		return $this->db->affected_rows();
	}

	public function update($data) {
		$sql = "UPDATE category SET nama='" .$data['category'] ."' WHERE id='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM category WHERE id='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function check_nama($nama) {
		$this->db->where('nama', $nama);
		$data = $this->db->get('category');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('category');

		return $data->num_rows();
	}
}

/* End of file M_category.php */
/* Location: ./application/models/M_category.php */