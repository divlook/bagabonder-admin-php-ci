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
        'password' => hash('sha256', $json->password . $_ENV['security']['salt']),
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

  public function _private_method()
  {
    echo 'hidden';
  }

}
