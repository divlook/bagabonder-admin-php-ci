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
    6 => 'forbidden',
    100 => 'authentication error',
    101 => 'authentication expired',
  );

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->generate_session();
  }

  public function authenticate()
  {
    try {
      $this->generate_session();

      $result = array(
        'code' => 1,
        'msg' => '',
        'data' => (object) array(),
      );

      $user_idx = $this->CI->input->cookie('user_idx');

      if (!$user_idx) {
        throw new Exception('user_idx', 5);
      }

      $access_token = $this->generate_access_token();

      $auth_data = $this->CI->auth_model->get_auth(array(
        'user_idx' => $user_idx,
        'access_token' => $access_token,
      ));

      if (!$auth_data) {
        // 이상한 방법으로 로그인 시도한 경우임.
        throw new Exception('', 100);
      }

      $result['data'] = $auth_data;

      $expire_date = $auth_data->up_date;
      if (!$expire_date) {
        $expire_date = $auth_data->reg_date;
      }

      if (strtotime($this->get_datetime()) - strtotime($expire_date) >= $_ENV['config']['session_expire']) {
        // 세션이 만료되었음.
        throw new Exception($this->result_code[101], 101);
      }

      return $result;
    } catch (Exception $e) {
      return array(
        'code' => $e->getCode(),
        'msg' => $e->getMessage(),
        'data' => (object) array(),
      );
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

  public function generate_random_string($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public function generate_session()
  {
    if ($this->CI->input->cookie('app_session') == false) {
      $this->CI->input->set_cookie('app_session', $this->generate_random_string(), 0);
    }
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

  public function result2json($param = array())
  {
    if ($_SERVER['HTTP_ORIGIN']) {
      $allow = '';
      $urls = $_ENV['server']['ALLOW_URLS'];
      foreach ($urls as $url) {
        if ($_SERVER['HTTP_ORIGIN'] == $url) {
          $allow = $url;
          break;
        }
      }
      if ($allow) {
        $this->CI->output->set_header('Access-Control-Allow-Origin: ' . $allow);
      }
    }

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

  public function make_query_string($param = array())
  {
    $result = '';
    foreach ($param as $key => $val) {
      if ($result) $result .= '&';
      $result .= $key . '=' . $val;
    }
    if ($result) $result = '?' . $result;
    return $result;
  }

  public function get_list_param($param = array())
  {
    $result = array();
    $result['page'] = isset($param['page']) ? $param['page'] : $this->CI->input->get('page') ? $this->CI->input->get('page') : 1;
    $result['limit'] = isset($param['limit']) ? $param['limit'] : 20;
    $result['offset'] = ($result['page'] - 1) * $result['limit'];
    return $result;
  }

  public function base64_to_data($base64_string)
  {
    $result = array(
      'data' => '',
      'type' => '',
      'ext' => '',
    );

    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    preg_match('/^data:(.+)\/(.+);base64$/', $data[0], $matches);

    $result['data'] = base64_decode($data[ 1 ]);
    $result['type'] = $matches[1];
    $result['ext'] = $matches[2];

    return $result;
  }

  public function save_image_from_data($data, $output_file)
  {
    $ifp = fopen( $output_file, 'wb' );
    fwrite( $ifp, $data );
    fclose( $ifp );
  }

}