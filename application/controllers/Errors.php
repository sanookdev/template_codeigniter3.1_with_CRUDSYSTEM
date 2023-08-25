<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Errors extends CI_Controller
{

	public function error404()
	{
		show_404();
	}
}