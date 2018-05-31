<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->model('Detail_info_model');
	}

	public function index()
	{
		// echo $this->Detail_info_model->get_test();
		$this->load->view('dashboard');
	}
}
