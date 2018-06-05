<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

  private $auth;

	public function __construct()
	{
		parent::__construct();
    $this->auth = $this->global_lib->authenticate();
    if ($this->auth['code'] !== 1) {
      redirect('logout?code='. $this->auth['code']);
    }
	}

	public function index()
	{
    redirect('admin/users');
	}

  public function users()
  {
    $data = array(
      'header' => array(
        'title' => '관리자 관리'
      )
    );
    $this->load->view('admin/users', $data);
  }

}
