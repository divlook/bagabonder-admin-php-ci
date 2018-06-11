<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

  private $auth;

	public function __construct()
	{
		parent::__construct();
    $this->auth = $this->global_lib->authenticate();
    $this->load->model('detail_info_model');
  }

  public function detail_info_check()
  {
    $result = array('code' => 1);

    $category = $this->input->get('category');

    if (!$category) {
      $result['code'] = 2;
      $result['msg'] = 'category';
    }

    if ($result['code'] === 1) {
      $category_overlap = $this->detail_info_model->category_overlap_check(array('category' => $category)) > 0;
      if ($category_overlap) {
        $result['code'] = 4;
        $result['msg'] = 'category';
      }
    }

    $this->global_lib->result2json($result);
  }

  public function detail_info()
  {
    /*
    {
      category: '',
      input_use: 5,
      rows_use: 5,
      column: {},
      rowname: {},
      size: {{}},
      style: {}
    }
     */

    if ($this->input->method(TRUE) === 'GET') {
      show_404();
      return;
    } else if ($this->input->method(TRUE) === 'POST') {
      $this->_post_detail_info();
    }

  }

  public function _post_detail_info()
  {
    $result = array('code' => 1);

    $json = $this->global_lib->get_json();

    if (!isset($json->category) || !$json->category) {
      $result['code'] = 3;
      $result['msg'] = 'category';
    }
    if (!isset($json->input_use) || $json->input_use < 1 || $json->input_use > 10) {
      $result['code'] = 3;
      $result['msg'] = 'input_use';
    }
    if (!isset($json->rows_use) || $json->rows_use < 1 || $json->rows_use > 10) {
      $result['code'] = 3;
      $result['msg'] = 'rows_use';
    }
    if (!isset($json->column) || !is_object($json->column)) {
      $result['code'] = 3;
      $result['msg'] = 'column';
    }
    if (!isset($json->rowname) || !is_object($json->rowname)) {
      $result['code'] = 3;
      $result['msg'] = 'rowname';
    }
    if (!isset($json->size) || !is_object($json->size)) {
      $result['code'] = 3;
      $result['msg'] = 'size';
    }
    if (!isset($json->style) || !is_object($json->style)) {
      $result['code'] = 3;
      $result['msg'] = 'style';
    }
    if (!isset($json->image)) {
      $result['code'] = 3;
      $result['msg'] = 'image';
    }

    $category_overlap = $this->detail_info_model->category_overlap_check(array(
      'category' => $json->category,
    ));

    if ($category_overlap) {
      $result['code'] = 4;
      $result['msg'] = 'category';
    }

    // 이미지 생성
    $image_result = $this->_generate_image();
    if ($image_result['code'] !== 1) {
      $result['code'] = $image_result['code'];
      $result['msg'] = $image_result['msg'];
    }

    // detail_info_index 저장
    if ($result['code'] === 1) {
      $this->detail_info_model->post_index(array(
        'category' => $json->category,
        'input_use' => $json->input_use,
        'rows_use' => $json->rows_use,
        'image' => $image_result['output'],
      ));
    }

    // detail_info_column 저장
    if ($result['code'] === 1) {
      $param = array(
        'category' => $json->category,
      );
      for ($i = 1; $i <= $json->input_use; $i++) {
        $param['input'.$i] = $json->column->{'input'.$i};
      }
      $this->detail_info_model->post_column($param);
    }

    // detail_info_rowname 저장
    if ($result['code'] === 1) {
      $param = array(
        'category' => $json->category,
      );
      for ($i = 1; $i <= $json->rows_use; $i++) {
        $param['rows'.$i] = $json->rowname->{'rows'.$i};
      }
      $this->detail_info_model->post_rowname($param);
    }

    // detail_info_size 저장
    if ($result['code'] === 1) {
      $param = array(
        'category' => $json->category,
      );
      for ($i = 1; $i <= $json->rows_use; $i++) {
        $row_key = 'rows'.$i;
        $param['rowname'] = $json->rowname->{$row_key};
        $json->size->{$row_key};
        for ($j = 1; $j <= $json->input_use; $j++) {
          $input_key = 'input' . $j;
          $param[$input_key] = $json->size->{$row_key}->{$input_key};
        }
        $this->detail_info_model->post_size($param);
      }
    }

    // detail_info_style 저장
    if ($result['code'] === 1) {
      $param = array(
        'category' => $json->category,
      );
      for ($i = 1; $i <= $json->input_use; $i++) {
        $temp = $json->style->{'input'.$i};
        if (is_object($temp)) {
          $temp = json_encode($temp);
        }
        $param['input'.$i] = $temp;
      }
      $this->detail_info_model->post_style($param);
    }

    if ($result['code'] !== 1) {
      // 마지막에 $result['code'] === 1 이 아니면 이미지도 삭제하고, db도 삭제해야함.
    }

    $this->global_lib->result2json($result);
  }

  /**
   * 이미지 저장
   */
  public function _generate_image()
  {
    $json = $this->global_lib->get_json();
    $result = array();

    $result['code'] = 1;
    $result['msg'] = '';

    $result['dir'] = CDN_DIR . '/' . date('Ymd', now($_ENV['server']['timezone']));
    $result['file'] = $this->global_lib->base64_to_data($json->image);
    $result['name'] = $json->category . '_' . date('His', now($_ENV['server']['timezone']));
    $result['output'] = $result['dir'] . '/' . $result['name'] . '.' . $result['file']['ext'];

    if ($result['file']['type'] !== 'image' || !preg_match('/(jpe?g|png|gif)/', $result['file']['ext'])) {
      $result['code'] = 3;
      $result['msg'] = 'image';
    }

    if (!is_dir($result['dir'])) {
      mkdir($result['dir']);
    }

    if ($result['code'] === 1) {
      $this->global_lib->save_image_from_data($result['file']['data'], $result['output']);
    }

    $this->load->library('image_lib', array(
      'image_library' => 'gd2',
      'source_image' => $result['output'],
      'maintain_ratio' => TRUE,
      'width' => 400,
      'height' => 400,
    ));

    $this->image_lib->resize();

    return $result;
  }

}
