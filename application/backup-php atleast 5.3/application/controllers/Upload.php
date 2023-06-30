<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Bangkok');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Upload extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		// Load Model
		$this->ip_address    = $_SERVER['REMOTE_ADDR'];
		$this->datetime 	    = date("Y-m-d H:i:s");
		if($this->session->userdata('userRole') != '1'){
            redirect('user','refresh');
        }else{
			$this->load->model('User_model');
		}
	}
	
	public function index() {
        $this->load->view('admin/admin_css');
        $this->load->view('admin/admin_js');
		$this->load->view('Layouts/header');
        $this->load->view('Layouts/navbar');
        $this->load->view('Layouts/sidebar');
	    $this->load->view('formupload_view');
		$this->load->view('Layouts/footer');
	}
	
	public function display() {
    	$data 	= [];
    	$data ["result"] = $this->upload->get_all();
    	$this->load->view("formupload_view");
    }

	public function date_customFormat($date){
		$old = explode('/',$date);
		$new = $old[2] . "-" . (($old[0] < 10) ? '0'. $old[0] : $old[0]) . "-" . $old[1];
		return $new;
	}


	// Save file function
	public function save_file($projectId, $fileType , $type) {
		$file = $_FILES[$type];
		$allowed = array('gif', 'png', 'jpg','docx','JPG','PNG','DOCX','GIF');
		$file = $_FILES[$type];
		$typeFile = $file['name'];
		$lastElement = explode('.', $typeFile);
		$lastElement = end($lastElement);
		if(in_array($lastElement,$allowed)){
			if ($file['error'] == UPLOAD_ERR_OK) {
				$folder = './uploads/'.$projectId . '/';
				if(!is_dir($folder)){
					mkdir($folder);
				}
		
				$file_name = uniqid() . '_' . $file['name'];
		
				if (move_uploaded_file($file['tmp_name'], $folder . $file_name)) {
					$data = array(
						'documentNameFile' => $file_name,
						'documentType' => $fileType,
						'projects_projectId' => $projectId
					);
					
					if($this->upload_model->save_file($data)){
						$this->session->set_flashdata('err_message', $file['name']. ' saved successfully');
						$this->session->set_flashdata('err_status', 1);
					}
				} else {
					$this->session->set_flashdata('err_message', 'There was an error saving the file');
					$this->session->set_flashdata('err_status', 0);
				}
			} else {
				$this->session->set_flashdata('err_message', 'There was an error saving the file');
				$this->session->set_flashdata('err_status', 0);
			}
		}else{
			// echo "1";
			$this->session->set_flashdata('err_message', 'Type of file is invalid ! <br>You can use only<br>"jpg,png,gif and docx"');
			$this->session->set_flashdata('err_status', 0);
			// exit();
		}
				
		redirect('edit/'.$projectId);
	}
  
	  

	public function import() {
		$path 		= 'documents/users/';
		$json 		= [];
		$this->upload_config($path);
		if (!$this->upload->do_upload('file')) {
			$json = [
				'error_message' => $this->upload->display_errors(),
			];
		} else {
			$file_data 	= $this->upload->data();
			$file_name 	= $path.$file_data['file_name'];
			$arr_file 	= explode('.', $file_name);
			$extension 	= end($arr_file);
			if('csv' == $extension) {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet 	= $reader->load($file_name);
			$sheet_data 	= $spreadsheet->getActiveSheet()->toArray();

			foreach($sheet_data as $key => $val) {

				if($key != null && $val[0] != null) {
					// $list[] = $val;
                    $list[] = array(
                        'username' => strtoupper($val[1]),
                        'password' => md5(md5($val[2])),
                        'fname' => $val[3],
                        'lname' => $val[4],
						'auth_status' => '1'
                    );
				}
			}
			$checkDuplicate = array();
			$result = array();

			if(count($list) > 0){
				for($i = 0 ; $i < count($list) ; $i++){
					if($this->User_model->checkDuplicate($list[$i]['username'])){
						$checkDuplicate[] = $list[$i]['username'];
					}else{
						if($this->db->insert('user',$list[$i])){
							$result['success']['user'][] = $list[$i]['username'];
						}

					}
				}
				$result['fails']['user'] = $checkDuplicate;
				$result['status'] = 1;
			}else{
				$result['status'] = 0;
			}
			
			if(file_exists($file_name)){
				unlink($file_name);
				
			}else{
				echo "cannot remove file.";
				exit();
			}
		}
		echo json_encode($result);
	}

	public function upload_config($path) {
		if (!is_dir($path)) 
			mkdir($path, 0777, TRUE);		
		$config['upload_path'] 		= './'.$path;		
		$config['allowed_types'] 	= 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename']	 	= '255';
		$config['encrypt_name'] 	= TRUE;
		$config['max_size'] 		= 4096; 
		$this->load->library('upload', $config);
	}
}