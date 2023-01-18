<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gereja extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_gereja');
	}

	public function index() {
		$data['userdata'] 	= $this->userdata;
		$data['dataGereja'] 	= $this->M_gereja->select_all();

		$data['page'] 		= "gereja";
		$data['judul'] 		= "Data Gereja";
		$data['deskripsi'] 	= "Manage Data Gereja";

		$data['modal_tambah_gereja'] = show_my_modal('modals/modal_tambah_gereja', 'tambah-gereja', $data);

		$this->template->views('gereja/home', $data);
	}

	public function tampil() {
		$data['dataGereja'] = $this->M_gereja->select_all();
		$this->load->view('gereja/list_data', $data);
	}

	public function prosesTambah() {
		$this->form_validation->set_rules('gereja', 'Gereja', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_gereja->insert($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Gereja Berhasil ditambahkan', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Data Gereja Gagal ditambahkan', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function update() {
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['dataGereja'] 	= $this->M_gereja->select_by_id($id);

		echo show_my_modal('modals/modal_update_gereja', 'update-gereja', $data);
	}

	public function prosesUpdate() {
		$this->form_validation->set_rules('gereja', 'Gereja', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_gereja->update($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Gereja Berhasil diupdate', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Gereja Gagal diupdate', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function delete() {
		$id = $_POST['id'];
		$result = $this->M_gereja->delete($id);
		
		if ($result > 0) {
			echo show_succ_msg('Data Gereja Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Gereja Gagal dihapus', '20px');
		}
	}

	public function detail() {
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['gereja'] = $this->M_gereja->select_by_id($id);
		$data['jumlahGereja'] = $this->M_gereja->total_rows();
		$data['dataGereja'] = $this->M_gereja->select_by_ruangan($id);

		echo show_my_modal('modals/modal_detail_gereja', 'detail-gereja', $data, 'lg');
	}

	public function export() {
		error_reporting(E_ALL);
    
		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_gereja->select_all();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "ID"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', "Nama Gereja");

		$rowCount = 2;
		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama); 
		    $rowCount++; 
		} 

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/Data Gereja.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/Data Gereja.xlsx', NULL);
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
						$check = $this->M_gereja->check_nama($value['B']);

						if ($check != 1) {
							$resultData[$index]['nama'] = ucwords($value['B']);
						}
					}
					$index++;
				}

				unlink('./assets/excel/' .$data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_gereja->insert_batch($resultData);
					if ($result > 0) {
						$this->session->set_flashdata('msg', show_succ_msg('Data Gereja Berhasil diimport ke database'));
						redirect('Gereja');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Data Gereja Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
					redirect('Gereja');
				}

			}
		}
	}
}

/* End of file Gereja.php */
/* Location: ./application/controllers/Gereja.php */