<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

  private $auth;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
  {
    $this->_init();
    if ($this->auth['code'] === 1) {
      redirect('dashboard');
    } else {
      redirect('logout?code='. $this->auth['code'] . '&return_url=' . uri_string());
    }
	}

  public function dashboard()
  {
    $this->auth = $this->global_lib->authenticate();
    if ($this->auth['code'] !== 1) {
      redirect('logout?code='. $this->auth['code'] . '&return_url=' . uri_string());
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
    $data['return_url'] = $this->input->get('return_url');
    $this->load->view('login', $data);
  }

  public function logout()
  {
    $return_url = $this->input->get('return_url');
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

    if ($return_url) {
      if ($query_string) $query_string .= '&';
      $query_string .= 'return_url='.$return_url;
    }

    if ($query_string) {
      $redirect_url .= '?' . $query_string ;
    }

    redirect($redirect_url);
  }

  public function join()
  {
    $this->auth = $this->global_lib->authenticate();
    $access_token = $this->input->get('access_token');

    if ($this->auth['code'] !== 1 && !$access_token) {
      redirect('logout?code=100');
    }

    $data = array();
    $data['layout'] = array(
      'use_nav' => false,
      'use_full' => true,
      'use_sidebar' => false,
      'use_icon' => false,
    );
    $this->load->view('join', $data);
  }

  public function _init()
  {
    // database 존재 확인
    // - 없으면 생성 후 마이그레이션
    if ($_ENV['database']['use']) {
      $this->load->model('migration_model');
      $version = $this->migration_model->get_version();
      $migrations = $this->migration_model->get_migrations();
      $migrations_count = count($migrations);
      if ($migrations_count > 0) {
        $migrations_keys = array_keys($migrations);
        unset($migrations);
        for (; 0 < $migrations_count; $migrations_count--) {
          if ($version < $migrations_keys[$migrations_count - 1]) {
            $this->migration_model->set_latest();
          }
        }
      } else {
        $this->migration_model->set_latest();
      }
    }
    // user table 확인
    // - 비어있으면 join으로 전송 ($this->token 생성 후 함께 전송)
    $this->load->model('user_model');
    if ($this->user_model->get_user_data() == FALSE) {
      $access_token = $this->global_lib->generate_access_token();
      $this->auth_model->set_auth(array(
        'user_idx' => 1,
        'access_token' => $access_token,
      ));
      redirect('join?access_token=' . $access_token);
    }
  }
}
