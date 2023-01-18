<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_ruangan');
		$this->load->model('M_category');
		$this->load->model('M_gereja');
	}

	public function index() {
		$data['jml_ruangan'] 	= $this->M_ruangan->total_rows();
		$data['jml_category'] 	= $this->M_category->total_rows();
		$data['jml_gereja'] 		= $this->M_gereja->total_rows();
		$data['userdata'] 		= $this->userdata;

		$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
		
		$category 				= $this->M_category->select_all();
		$index = 0;
		foreach ($category as $value) {
		    $color = '#' .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)];

			$ruangan_by_category = $this->M_ruangan->select_by_category($value->id);

			$data_category[$index]['value'] = $ruangan_by_category->jml;
			$data_category[$index]['color'] = $color;
			$data_category[$index]['highlight'] = $color;
			$data_category[$index]['label'] = $value->nama;
			
			$index++;
		}

		$gereja 				= $this->M_gereja->select_all();
		$index = 0;
		foreach ($gereja as $value) {
		    $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];

			$ruangan_by_gereja = $this->M_ruangan->select_by_gereja($value->id);

			$data_gereja[$index]['value'] = $ruangan_by_gereja->jml;
			$data_gereja[$index]['color'] = $color;
			$data_gereja[$index]['highlight'] = $color;
			$data_gereja[$index]['label'] = $value->nama;
			
			$index++;
		}

		$data['data_category'] = json_encode($data_category);
		$data['data_gereja'] = json_encode($data_gereja);

		$data['page'] 			= "home";
		$data['judul'] 			= "Beranda";
		$data['deskripsi'] 		= "Manage Data CRUD";
		$this->template->views('home', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */