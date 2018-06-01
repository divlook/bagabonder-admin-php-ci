<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Global_lib
 *
 * @author uihyeon
 * 2018-06-01
 */
class Global_lib {

  protected $CI;

  public $result_code = array(
    0 => 'fail',
    1 => 'success',
    2 => 'required',
    3 => 'bad parameter',
    4 => 'overlap',
    5 => 'empty',
  );

  public function __construct()
  {
    $this->CI =& get_instance();
  }

  public function authenticate()
  {
    echo 'access_token 체크';
    // 진입시 가장먼저 실행된다.

    // 세션을 확인한다.
    $session = $this->input->cookie('app_session');

    // 세션을 생성한다.
    if ($session === false) $this->input->set_cookie('app_session', 'session');

    // access_token을 확인한다.
    // auth_model

    // 없다면 access_token을 생성한다.
    // auth_model

    // access_token이 만료됐다면 로그아웃처리.
    // auth_model : access_token 삭제
    // $session 삭제

    // auth와 user의 user_idx를 비교
    // user_model
    // auth_model
  }

  public function get_json()
  {
    $json = file_get_contents("php://input");
    $json = stripslashes($json);
    $json = json_decode($json);
    return $json;
  }

  public function get_datetime()
  {
    return date('Y-m-d H:i:s', now($_ENV['server']['timezone']));
  }

  public function result2json($param = array()) {
    $result = array(
      'code' => 0,
      'msg' => '',
      'data' => (object) array(),
    );

    if (isset($param['code'])) $result['code'] = $param['code'];
    $result['msg'] = $this->result_code[$result['code']];
    if (isset($param['msg'])) $result['msg'] = $result['msg'] . ' (' . $param['msg'] . ')';
    if (isset($param['data'])) $result['data'] = $param['data'];
    $result['response_time'] = (time() - RESPONSE_TIME) . 'ms';
    $this->CI->output
      ->set_content_type('application/json')
      ->set_output(json_encode($result));
  }

}