<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->model('Detail_info_model');
	}

	public function index()
	{
		// echo $this->Detail_info_model->get_test();
    redirect('dashboard');
	}

  public function dashboard()
  {
    $data = array();
    $this->load->view('dashboard', $data);
  }

  public function login()
  {
    $data['layout'] = array(
      'use_nav' => false,
      'use_full' => true,
      'use_sidebar' => false,
      'use_icon' => false,
    );
    $this->load->view('login', $data);
  }

}
