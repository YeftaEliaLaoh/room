<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_category');
	}

	public function index() {
		$data['userdata'] 	= $this->userdata;
		$data['dataCategory'] = $this->M_category->select_all();

		$data['page'] 		= "category";
		$data['judul'] 		= "Data Category";
		$data['deskripsi'] 	= "Manage Data Category";

		$data['modal_tambah_category'] = show_my_modal('modals/modal_tambah_category', 'tambah-category', $data);

		$this->template->views('category/home', $data);
	}

	public function tampil() {
		$data['dataCategory'] = $this->M_category->select_all();
		$this->load->view('category/list_data', $data);
	}

	public function prosesTambah() {
		$this->form_validation->set_rules('category', 'category', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_category->insert($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Category Berhasil ditambahkan', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Data Category Gagal ditambahkan', '20px');
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
		$data['dataCategory'] = $this->M_category->select_by_id($id);

		echo show_my_modal('modals/modal_update_category', 'update-category', $data);
	}

	public function prosesUpdate() {
		$this->form_validation->set_rules('category', 'category', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_category->update($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Category Berhasil diupdate', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Category Gagal diupdate', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function delete() {
		$id = $_POST['id'];
		$result = $this->M_category->delete($id);
		
		if ($result > 0) {
			echo show_succ_msg('Data Category Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Category Gagal dihapus', '20px');
		}
	}

	public function detail() {
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['category'] = $this->M_category->select_by_id($id);
		$data['dataCategory'] = $this->M_category->select_by_ruangan($id);

		echo show_my_modal('modals/modal_detail_category', 'detail-category', $data, 'lg');
	}

	public function export() {
		error_reporting(E_ALL);
    
		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_category->select_all();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 
		$rowCount = 1; 

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Nama Category");
		$rowCount++;

		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama); 
		    $rowCount++; 
		} 

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/Data Category.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/Data Category.xlsx', NULL);
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
						$check = $this->M_category->check_nama($value['B']);

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
						$this->session->set_flashdata('msg', show_succ_msg('Data Category Berhasil diimport ke database'));
						redirect('Category');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Data Category Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
					redirect('Category');
				}

			}
		}
	}
}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */