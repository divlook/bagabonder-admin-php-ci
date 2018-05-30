<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->model('Size_info_model');
	}

	public function index()
	{
		// echo $this->Size_info_model->get_test();
		$this->load->view('welcome_message');
	}
}
