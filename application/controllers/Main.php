<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

  private $auth;

	public function __construct()
	{
		parent::__construct();
    $this->auth = $this->global_lib->authenticate();
	}

	public function index()
	{
    if ($this->auth['code'] === 1) {
      redirect('dashboard');
    } else {
      redirect('logout?code='. $this->auth['code']);
    }
	}

  public function dashboard()
  {
    if ($this->auth['code'] !== 1) {
      redirect('logout?code='. $this->auth['code']);
    }

    $data = array(
      'header' => array(
        'title' => 'Dashboard',
      ),
    );
    $this->load->view('dashboard', $data);
  }

  public function login()
  {
    $data = array();
    $data['layout'] = array(
      'use_nav' => false,
      'use_full' => true,
      'use_sidebar' => false,
      'use_icon' => false,
    );
    $this->load->view('login', $data);
  }

  public function logout()
  {
    $code = $this->input->get('code');
    $redirect_url = 'login';
    $query_string = '';
    $access_token =$this->global_lib->generate_access_token();

    $this->auth_model->del_auth(array(
      'access_token' => $access_token,
      'user_idx' => $this->input->cookie('user_idx'),
    ));

    $this->input->set_cookie('app_session', '');
    $this->input->set_cookie('user_idx', '');

    if ($code) {
      if ($query_string) $query_string .= '&';
      $query_string .= 'code='. $code;
    }

    if ($query_string) {
      $redirect_url .= '?' . $query_string ;
    }

    redirect($redirect_url);
  }

  public function join()
  {
    $data = array();
    $data['layout'] = array(
      'use_nav' => false,
      'use_full' => true,
      'use_sidebar' => false,
      'use_icon' => false,
    );
    $this->load->view('join', $data);
  }

}
