<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

  private $auth;

	public function __construct()
	{
		parent::__construct();
    $this->auth = $this->global_lib->authenticate();
    if ($this->auth['code'] !== 1) {
      redirect('logout?code='. $this->auth['code'] . '&return_url=' . uri_string());
    }
    $this->load->model('user_model');
	}

	public function index()
	{
    redirect('admin/users');
	}

  public function users()
  {
    $list_param = $this->global_lib->get_list_param(array(
      'page' => $this->input->get('page'),
    ));

    $user_data = $this->user_model->get_user_data(array(
      'idx' => $this->auth['data']->user_idx,
    ));
    unset($user_data->password);

    $table_data = $this->user_model->get_user_data_list($list_param);
    $table_data['col_option'] = array(
      'idx' => array(
        'hidden' => TRUE,
      ),
      'reg_date' => array(
        'name' => '가입일',
      ),
      'up_date' => array(
        'name' => '최근 접속일',
      ),
    );

    $data = array(
      'header' => array(
        'title' => '관리자 관리'
      ),
      'user' => $user_data,
      'users' => $table_data,
    );

    $this->load->view('admin/users', $data);
  }

  public function info()
  {
    $idx = $this->input->get('idx');
    $auth_data = $this->user_model->get_user_data(array(
      'idx' => $this->auth['data']->user_idx,
    ));
    unset($auth_data->password);
    $user_data = $auth_data;

    if ($idx) {
      if ($auth_data->level != 1) {
        redirect('logout?code=100');
        return;
      }
      $user_data = $this->user_model->get_user_data(array(
        'idx' => $idx,
      ));
      unset($user_data->password);
    }

    $data = array(
      'header' => array(
        'title' => '관리자 정보',
      ),
      'auth_idx' => $auth_data->level == 1 ? $auth_data->idx : '',
      'user' => $user_data,
    );

    $this->load->view('admin/info', $data);
  }

}
