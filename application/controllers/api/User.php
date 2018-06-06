<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  private $auth;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->auth = $this->global_lib->authenticate();
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
        'password' => $this->global_lib->generate_password(array('password' => $json->password)),
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

    if ($user_data->password !== $this->global_lib->generate_password(array('password' => $json->password))) {
      $result['code'] = 3;
      $result['msg'] = 'password';
    }

    if ($result['code'] === 1) {
      $this->input->set_cookie('user_idx', $user_data->idx, 0);
      $this->auth_model->set_auth(array(
        'user_idx' => $user_data->idx,
        'access_token' => $access_token,
      ));
      $this->user_model->put_user_data(array(
        'idx' => $user_data->idx,
      ));
    }

    $this->global_lib->result2json($result);
  }

  public function info()
  {
    if ($this->input->method(TRUE) === 'GET') {
      show_404();
      return;
    }
    $json = $this->global_lib->get_json();
    $result = array('code' => 1);
    $put_param = array('idx' => $json->idx);
    $auth_data = $this->user_model->get_user_data(array(
      'idx' => $this->auth['data']->user_idx,
    ));
    $user_data = (object) array();

    if (!isset($json->idx)) {
      $result['code'] = 2;
      $result['msg'] = 'idx';
    }

    if ($result['code'] === 1) {
      if ($auth_data->idx == $json->idx) {
        $user_data = $auth_data;
      } else {
        $user_data = $this->user_model->get_user_data(array(
          'idx' => $json->idx,
        ));
        if (!$user_data) {
          $result['code'] = 5;
          $result['msg'] = 'user';
        }
      }
    }

    if ($result['code'] === 1 && $auth_data->password !== $this->global_lib->generate_password(array('password' => $json->password))) {
      $result['code'] = 3;
      $result['msg'] = 'password';
    }

    if ($result['code'] === 1 && ($user_data->username != $json->username)) {
      $username_overlap = $this->user_model->username_check($json->username) > 0;
      if ($username_overlap) {
        $result['code'] = 4;
        $result['msg'] = 'username';
      }
      $put_param['username'] = $user_data->username;
    }

    if ($result['code'] === 1 && isset($json->new_password)) {
      $put_param['password'] = $this->global_lib->generate_password(array('password' => $json->new_password));
    }

    if (
      $result['code'] === 1 &&
      isset($json->level) &&
      isset($json->auth_idx) &&
      $json->auth_idx == $auth_data->idx &&
      $json->idx != $auth_data->idx &&
      $auth_data->level == 1
    ) {
      switch ($json->level) {
        case 1: $put_param['level'] = 1; break;
        default: $put_param['level'] = 2; break;
      }
    }

    if ($result['code'] === 1) {
      $put_result = $this->user_model->put_user_data($put_param);
      if (!$put_result) {
        $result['code'] = 0;
        $result['msg'] = 'DB 오류';
      }
    }

    $this->global_lib->result2json($result);
  }

  public function check()
  {
    $result = array('code' => 1);

    $username = $this->input->get('username');

    if (!$username) {
      $result['code'] = 2;
      $result['msg'] = 'username';
    }

    if ($result['code'] === 1) {
      $username_overlap = $this->user_model->username_check($username) > 0;
      if ($username_overlap) {
        $result['code'] = 4;
        $result['msg'] = 'username';
      }
    }

    $this->global_lib->result2json($result);
  }

  public function _private_method()
  {
    echo 'hidden';
  }

}
