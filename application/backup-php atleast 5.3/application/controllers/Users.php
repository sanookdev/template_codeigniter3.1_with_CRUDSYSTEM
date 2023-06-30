<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		if(isset($this->session->userdata['userRole'])){
			if($this->session->userdata['userRole'] == '1'){
				$this->load->model('User_model');
				$this->load->view('myCss');
				$this->load->view('myJs');
			}
		}else{
			redirect('member');
		}
	}
	public function index()
	{
        $data['users'] = $this->User_model->fetchAll();
		$this->load->view('template' , $data);
	}
	public function add()
	{
		$this->load->view('_partials/head');
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('user/add');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}

	public function uploadPage()
	{
		$this->load->view('user/import');
	}

	public function create()
	{
		if($this->User_model->create($this->input->post())){
            $this->session->set_flashdata('err_message', 'User Created');
            $this->session->set_flashdata('err_status', 1);
        }else{
            $this->session->set_flashdata('err_message', 'Fails');
            $this->session->set_flashdata('err_status', 0);
        }
        redirect('users');
	}

	public function updateStatus(){
		$data = $this->input->post('data');
		$username = $data['username'];
		$dataUpdate = array(
			$data['column'] => $data[$data['column']]
		);
		unset($data['column']);
		if($this->User_model->updateStatus($username,$dataUpdate)){
			echo "1";
        }else{
			echo "0";
		}
    }

	public function updatePassword(){
		$data = $this->input->post('data');
		$username = $data['username'];
		$dataUpdate = array(
			'password' => md5(md5($data['password']))
		);
		if($this->User_model->updatePassword($username,$dataUpdate)){
			$this->session->set_flashdata('err_message', 'Success ' . $username);
            $this->session->set_flashdata('err_status', 1);
			echo "1";
        }else{
			$this->session->set_flashdata('err_message', $this->User_model->updatePassword($username,$dataUpdate));
            $this->session->set_flashdata('err_status', 0);
			echo "0";
		}
    }
	
	public function deleteUser(){

		$data = $this->input->post('data');
		$username = $data['username'];
		$dataDelete = array(
			'username' => $data['username']
		);
		if($this->User_model->deleteUser($username)){
			$this->session->set_flashdata('err_message', 'Deleted accout ' . $username);
            $this->session->set_flashdata('err_status', 1);
			echo "1";
		}else{
			$this->session->set_flashdata('err_message', $this->User_model->deleteUser($username));
            $this->session->set_flashdata('err_status', 0);
		}
        redirect('users');
	}
}