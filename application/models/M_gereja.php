<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_gereja extends CI_Model {
	public function select_all() {
		$this->db->select('*');
		$this->db->from('gereja');

		$data = $this->db->get();

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT * FROM gereja WHERE id = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_by_ruangan($id) {
		$sql = " SELECT ruangan.id AS id, ruangan.nama AS ruangan, gereja.nama AS gereja, category.nama AS category FROM ruangan, gereja, category WHERE ruangan.id_category = category.id AND ruangan.id_gereja = gereja.id AND ruangan.id_gereja={$id}";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function insert($data) {
		$sql = "INSERT INTO gereja VALUES('','" .$data['gereja'] ."')";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		$this->db->insert_batch('gereja', $data);
		
		return $this->db->affected_rows();
	}

	public function update($data) {
		$sql = "UPDATE gereja SET nama='" .$data['gereja'] ."' WHERE id='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM gereja WHERE id='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function check_nama($nama) {
		$this->db->where('nama', $nama);
		$data = $this->db->get('gereja');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('gereja');

		return $data->num_rows();
	}
}

/* End of file M_gereja.php */
/* Location: ./application/models/M_gereja.php */