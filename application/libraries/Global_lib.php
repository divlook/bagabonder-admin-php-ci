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
    100 => 'authentication error',
    101 => 'authentication expired',
  );

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->authenticate();
  }

  public function authenticate()
  {
    try {
      $session = $this->CI->input->cookie('app_session');

      if ($session === false) $this->CI->input->set_cookie('app_session', 'session', 0);

      $user_idx = $this->CI->input->cookie('user_idx');

      if (!$user_idx) {
        return false;
      }

      $access_token = $this->generate_access_token();

      $auth_data = $this->CI->auth_model->get_auth(array(
        'user_idx' => $user_idx,
        'access_token' => $access_token,
      ));


      if (!$auth_data) {
        // 이상한 방법으로 로그인 시도한 경우임.
        throw new Exception($this->result_code[100], 100);
      }

      $expire_date = $auth_data->up_date;
      if (!$expire_date) {
        $expire_date = $auth_data->reg_date;
      }

      if (strtotime($this->get_datetime()) - strtotime($expire_date) >= $_ENV['config']['session_expire']) {
        throw new Exception($this->result_code[101], 101);
      }
    } catch (Exception $e) {
      // 인증오류가 발생하면 클라에서 로그아웃하도록 해야함.
      $this->result2json(array('code' => $e->getCode()));
      return false;
    }
  }

  public function generate_access_token()
  {
    $session = $this->CI->input->cookie('app_session');
    return $session ? hash('sha256', $session . $_ENV['security']['salt']) : false;
  }

  public function generate_password($param = array())
  {
    return hash('sha256', $param['password'] . $_ENV['security']['salt']);
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
    return date($_ENV['config']['date_format'], now($_ENV['server']['timezone']));
  }

  public function result2json($param = array()) {
    $result = array(
      'code' => 0,
      'msg' => '',
      'data' => (object) array(),
    );

    if (isset($param['code'])) $result['code'] = $param['code'];
    $result['msg'] = $this->result_code[$result['code']];
    if (isset($param['msg']) && strlen($param['msg']) > 0) $result['msg'] = $result['msg'] . ' (' . $param['msg'] . ')';
    if (isset($param['data'])) $result['data'] = $param['data'];
    $result['response_time'] = (time() - RESPONSE_TIME) . 'ms';
    $this->CI->output
      ->set_content_type('application/json')
      ->set_output(json_encode($result));
  }

}