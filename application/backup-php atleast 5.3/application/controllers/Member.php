<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Member_model');
	}
	public function index()
	{
		$this->load->model('Member_model');

		if(isset($this->session->userdata['userRole'])){
			if($this->session->userdata['userRole'] == '1'){
				redirect('users');
			}
		}else{
			$this->signin();
		}
	}

	public function signin(){
		$this->load->view('myCss');
		$this->load->view('auth/login');
		$this->load->view('myJs');
	}
	
	public function check()
	{
			if($this->input->post('username') == '' || $this->input->post('password') == ''){
				$this->load->view('auth/login');
			}else{
				$username = strtoupper($this->input->post('username'));
				$password = $this->input->post('password');
				$jsonurl = 'http://172.18.1.17/_authen/_authen.php?user_login=' . $username;
				$json = file_get_contents($jsonurl);
				$returnInfo = json_decode($json, true);
				if($returnInfo['chkData'] == md5($password)){
					if(substr($username,1,2) == "ET"){
						$sess = array(
							'userName' => $username,
							'userRole' => '1'
						);
					}
					$this->session->set_userdata($sess);
					redirect('member');
				}else{
					$this->load->library('session');
					$this->session->set_flashdata('err_message', 'Username or Password is invalid');
					$this->session->unset_userdata(array('userName','userRole'));
					redirect('member');
					}
			}
	
	}

	public function logout(){
		$this->session->sess_destroy();
		// print_r($this->session);
		redirect('member');
	}
}