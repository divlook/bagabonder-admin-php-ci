<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		 $this->load->model('user_model');
	}

  /**
   * 회원가입
   */
  public function join()
  {
    if ($this->input->method(TRUE) === 'GET') {
      show_404();
      return;
    }
    $json = $this->global_lib->get_json();

    $result = array(
      'code' => 4,
      'msg' => 'username'
    );
    $username_overlap = $this->user_model->username_check($json->username) > 0;

    if ($username_overlap === false) {
      $post_result = $this->user_model->user_post(array(
        'username' => $json->username,
        'password' => $this->global_lib->generate_password($json->password),
        'level' => $json->level,
      ));
      if ($post_result) {
        $result['code'] = 1;
        $result['msg'] = '';
      } else {
        $result['code'] = 0;
        $result['msg'] = 'DB 오류';
      }
    }

    $this->global_lib->result2json($result);
  }

  public function login()
  {
    if ($this->input->method(TRUE) === 'GET') {
      show_404();
      return;
    }
    $json = $this->global_lib->get_json();

    $result = array('code' => 1);

    $access_token = $this->global_lib->generate_access_token();

    $user_data = $this->user_model->get_user_data(array(
      'username' => $json->username,
    ));

    if (!$user_data) {
      $result['code'] = 5;
      $result['msg'] = 'username';
    }

    if ($json->password !== $this->global_lib->generate_password($json->password)) {
      $result['code'] = 3;
      $result['msg'] = 'password';
    }

    $this->input->set_cookie('user_idx', $user_data->idx, 0);

    $this->auth_model->set_auth(array(
      'user_idx' => $user_data->idx,
      'access_token' => $access_token,
    ));

    $this->global_lib->result2json($result);
  }

  public function logout()
  {
    $access_token =$this->global_lib->generate_access_token();

    $this->auth_model->del_auth(array(
      'access_token' => $access_token,
      'user_idx' => $this->input->cookie('user_idx'),
    ));

    $this->input->set_cookie('app_session', '');
    $this->input->set_cookie('user_idx', '');
  }

  public function _private_method()
  {
    echo 'hidden';
  }

}
