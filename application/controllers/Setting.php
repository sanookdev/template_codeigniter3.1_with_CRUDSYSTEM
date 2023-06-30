<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		if(isset($this->session->userdata['user_role'])){
			if($this->session->userdata['user_role'] == '1'){
				$this->load->model('Setting_model');
			}
		}else{
			redirect('member');
		}
	}
    
    public function index($response = null){

        $data['options'] = $this->get_options();

		if($response != null){
			$data['response'] = $response ;
		}
		
        $this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head');
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('setting',$data);
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
    }

    public function get_options(){
		$this->load->model('Setting_model');
		return $this->Setting_model->get_options();
	}

	public function update(){
		$data = $this->input->post();
		if($this->Setting_model->update($data)){
			$this->session->set_flashdata('err_message', 'This setting has been updated.');
			$this->session->set_flashdata('status', 1);
			$this->session->options = $this->get_options();
		}else{
			$this->session->set_flashdata('err_message', $this->Setting_model->update($data));
			$this->session->set_flashdata('status', 1);
		}
		redirect('setting','refresh');
    }

	public function upload_image()
    {
		$name_banner = '';
		foreach ($_FILES as $key => $value) {
			$name_banner = $key;
		}
		$file = $_FILES[$name_banner];

		$allowed = array('gif', 'png', 'jpg','JPG','PNG','GIF');
		$typeFile = $file['name'];
		$lastElement = explode('.', $typeFile);
		$lastElement = end($lastElement);
		if(in_array($lastElement,$allowed)){
			if ($file['error'] == UPLOAD_ERR_OK) {
				$folder = './uploads/banner/';
				if(!is_dir($folder)){
					mkdir($folder);
				}
		
				// $file_name = uniqid() . '_' . $file['name'];    If randomname use this
				$file_name = $name_banner.'.jpg';
		
				if (move_uploaded_file($file['tmp_name'], $folder . $file_name)) {
					$data = array(
						$name_banner => $file_name
					);
					if($this->Setting_model->save_file($data)){
						$this->session->set_flashdata('err_message', $file_name. ' saved successfully');
						$this->session->set_flashdata('err_status', 1);

						$response = array(
							'message' => 'This image has been uploaded.',
							'image_url' => base_url('uploads/banner/'.$file_name),
							'namefile' => $name_banner,
							'status' => 1
						);

						echo json_encode($response);
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
		// redirect('setting','refresh');

    }
}