<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_ruangan');
		$this->load->model('M_category');
		$this->load->model('M_gereja');
	}

	public function index() {
		$data['userdata'] = $this->userdata;
		$data['dataRuangan'] = $this->M_ruangan->select_all();
		$data['dataCategory'] = $this->M_category->select_all();
		$data['dataGereja'] = $this->M_gereja->select_all();

		$data['page'] = "ruangan";
		$data['judul'] = "Data Ruangan";
		$data['deskripsi'] = "Manage Data Ruangan";

		$data['modal_tambah_ruangan'] = show_my_modal('modals/modal_tambah_ruangan', 'tambah-ruangan', $data);

		$this->template->views('ruangan/home', $data);
	}

	public function tampil() {
		$data['dataRuangan'] = $this->M_ruangan->select_all();
		$this->load->view('ruangan/list_data', $data);
	}

	public function prosesTambah() {
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('gereja', 'Gereja', 'trim|required');
		$this->form_validation->set_rules('category', 'Category', 'trim|required');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_ruangan->insert($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Ruangan Berhasil ditambahkan', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Data Ruangan Gagal ditambahkan', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function update() {
		$id = trim($_POST['id']);

		$data['dataRuangan'] = $this->M_ruangan->select_by_id($id);
		$data['dataCategory'] = $this->M_category->select_all();
		$data['dataGereja'] = $this->M_gereja->select_all();
		$data['userdata'] = $this->userdata;

		echo show_my_modal('modals/modal_update_ruangan', 'update-ruangan', $data);
	}

	public function prosesUpdate() {
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('gereja', 'Gereja', 'trim|required');
		$this->form_validation->set_rules('category', 'Category', 'trim|required');

		$data = $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_ruangan->update($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Ruangan Berhasil diupdate', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Ruangan Gagal diupdate', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function delete() {
		$id = $_POST['id'];
		$result = $this->M_ruangan->delete($id);

		if ($result > 0) {
			echo show_succ_msg('Data Ruangan Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Ruangan Gagal dihapus', '20px');
		}
	}

	public function export() {
		error_reporting(E_ALL);
    
		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_ruangan->select_all_ruangan();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 
		$rowCount = 1; 

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID");
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Nama");
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Nomor Telepon");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "ID Gereja");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "ID Category");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Status");
		$rowCount++;

		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->id_gereja); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->id_category); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->status); 
		    $rowCount++; 
		} 

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/Data Ruangan.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/Data Ruangan.xlsx', NULL);
	}

	public function import() {
		$this->form_validation->set_rules('excel', 'File', 'trim|required');

		if ($_FILES['excel']['name'] == '') {
			$this->session->set_flashdata('msg', 'File harus diisi');
		} else {
			$config['upload_path'] = './assets/excel/';
			$config['allowed_types'] = 'xls|xlsx';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('excel')){
				$error = array('error' => $this->upload->display_errors());
			}
			else{
				$data = $this->upload->data();
				
				error_reporting(E_ALL);
				date_default_timezone_set('Asia/Jakarta');

				include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';

				$inputFileName = './assets/excel/' .$data['file_name'];
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

				$index = 0;
				foreach ($sheetData as $key => $value) {
					if ($key != 1) {
						$id = md5(DATE('ymdhms').rand());
						$check = $this->M_ruangan->check_nama($value['B']);

						if ($check != 1) {
							$resultData[$index]['id'] = $id;
							$resultData[$index]['nama'] = ucwords($value['B']);
							$resultData[$index]['id_gereja'] = $value['C'];
							$resultData[$index]['id_category'] = $value['D'];
							$resultData[$index]['status'] = $value['E'];
						}
					}
					$index++;
				}

				unlink('./assets/excel/' .$data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_ruangan->insert_batch($resultData);
					if ($result > 0) {
						$this->session->set_flashdata('msg', show_succ_msg('Data Ruangan Berhasil diimport ke database'));
						redirect('Ruangan');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Data Ruangan Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
					redirect('Ruangan');
				}

			}
		}
	}
}

/* End of file Ruangan.php */
/* Location: ./application/controllers/Ruangan.php */