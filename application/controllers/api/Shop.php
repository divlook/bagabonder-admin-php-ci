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

  public function detail_info($idx = NULL)
  {
    /*
    {
      category: '',
      input_use: 5,
      rows_use: 5,
      image: '',
      column: {},
      rowname: {},
      size: {{}},
      style: {}
    }
     */

    switch ($this->input->method(TRUE)) {
      case 'GET': $this->_get_detail_info($idx); break;
      case 'POST': $this->_post_detail_info(); break;
      case 'DELETE': $this->_delete_detail_info($idx); break;
      case 'PUT': $this->_put_detail_info($idx); break;
      default: show_404(); break;
    }
  }

  public function _get_detail_info($idx = NULL)
  {
    $result = array('code' => 1);
    $index_result = NULL;
    $column_result = NULL;
    $rowname_result = NULL;
    $size_result = NULL;
    $style_result = NULL;

    if (!$idx) {
      $result['code'] = 3;
      $result['msg'] = 'idx';
    }

    if ($result['code'] === 1) {
      $index_result = $this->detail_info_model->get_index(array('idx' => $idx));
      if (!$index_result) {
        $result['code'] = 5;
      }
    }

    if ($result['code'] === 1) {
      $column_result = $this->detail_info_model->get_column(array('category' => $index_result->category));
      $rowname_result = $this->detail_info_model->get_rowname(array('category' => $index_result->category));
      $size_result = $this->detail_info_model->get_size(array('category' => $index_result->category));
      $style_result = $this->detail_info_model->get_style(array('category' => $index_result->category));
    }

    $result['data'] = $index_result;
    $result['data']->column = (object) array();
    $result['data']->rowname = (object) array();
    $result['data']->size = (object) array();
    $result['data']->style = (object) array();

    for ($i = 1; $i <= 10; $i++) {
      $result['data']->column->{'input' . $i} = $column_result->{'input' . $i};
      $result['data']->rowname->{'rows' . $i} = $rowname_result->{'rows' . $i};
      $result['data']->size->{'rows' . $i} = (object) array();
      for ($j = 1; $j <= 10; $j++) {
        $result['data']->size->{'rows' . $i}->{'input' . $j} = $index_result->input_use >= $i ? $size_result[$i - 1]->{'input' . $j} : NULL;
      }
      $result['data']->style->{'input' . $i} = $style_result->{'input' . $i};
    }

    $this->global_lib->result2json($result);
  }

  public function _delete_detail_info($idx = NULL)
  {
    $result = array('code' => 1);

    if (!$idx) {
      $result['code'] = 2;
      $result['msg'] = 'idx';
    }

    if ($result['code'] === 1) {
      $this->_fn_delete_detail_info(array('idx' => $idx));
    }

    $this->global_lib->result2json($result);
  }

  public function _post_detail_info()
  {
    $result = array('code' => 1);

    $json = $this->global_lib->get_json();

    if ($result['code'] === 1 && !isset($json->category) || !$json->category) {
      $result['code'] = 3;
      $result['msg'] = 'category';
    }
    if ($result['code'] === 1 && !isset($json->input_use) || $json->input_use < 1 || $json->input_use > 10) {
      $result['code'] = 3;
      $result['msg'] = 'input_use';
    }
    if ($result['code'] === 1 && !isset($json->rows_use) || $json->rows_use < 1 || $json->rows_use > 10) {
      $result['code'] = 3;
      $result['msg'] = 'rows_use';
    }
    if ($result['code'] === 1 && !isset($json->column) || !is_object($json->column)) {
      $result['code'] = 3;
      $result['msg'] = 'column';
    }
    if ($result['code'] === 1 && !isset($json->rowname) || !is_object($json->rowname)) {
      $result['code'] = 3;
      $result['msg'] = 'rowname';
    }
    if ($result['code'] === 1 && !isset($json->size) || !is_object($json->size)) {
      $result['code'] = 3;
      $result['msg'] = 'size';
    }
    if ($result['code'] === 1 && !isset($json->style) || !is_object($json->style)) {
      $result['code'] = 3;
      $result['msg'] = 'style';
    }
    if ($result['code'] === 1 && !isset($json->image)) {
      $result['code'] = 3;
      $result['msg'] = 'image';
    }

    if ($result['code'] === 1) {
      $category_overlap = $this->detail_info_model->category_overlap_check(array(
        'category' => $json->category,
      ));

      if ($category_overlap) {
        $result['code'] = 4;
        $result['msg'] = 'category';
      }
    }

    if ($result['code'] === 1) {
      // 이미지 생성
      $image_result = $this->_fn_generate_image();
      if ($image_result['code'] !== 1) {
        $result['code'] = $image_result['code'];
        $result['msg'] = $image_result['msg'];
      }
    }

    if ($result['code'] === 1) {
      // detail_info_index 저장
      $this->detail_info_model->post_index(array(
        'category' => $json->category,
        'input_use' => $json->input_use,
        'rows_use' => $json->rows_use,
        'image' => $image_result['output'],
      ));

      // detail_info_column 저장
      $param = array(
        'category' => $json->category,
      );
      for ($i = 1; $i <= $json->input_use; $i++) {
        $param['input'.$i] = $json->column->{'input'.$i};
      }
      $this->detail_info_model->post_column($param);

      // detail_info_rowname 저장
      $param = array(
        'category' => $json->category,
      );
      for ($i = 1; $i <= $json->rows_use; $i++) {
        $param['rows'.$i] = $json->rowname->{'rows'.$i};
      }
      $this->detail_info_model->post_rowname($param);

      // detail_info_size 저장
      $param = array(
        'category' => $json->category,
      );
      for ($i = 1; $i <= $json->rows_use; $i++) {
        $param['row_key'] = $i;
        $row_key = 'rows'.$i;
        for ($j = 1; $j <= $json->input_use; $j++) {
          $input_key = 'input' . $j;
          $param[$input_key] = $json->size->{$row_key}->{$input_key};
        }
        $this->detail_info_model->post_size($param);
      }

      // detail_info_style 저장
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

    // 결과가 실패하면 다 삭제 함.
    if ($result['code'] !== 1) {
      $this->_fn_delete_detail_info(array(
        'category' => $json->category,
        'image' => $image_result['output'],
      ));
    }

    $this->global_lib->result2json($result);
  }

  /**
   * 이미지 저장
   */
  public function _fn_generate_image()
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

  public function _fn_delete_detail_info($param = array())
  {
    if (!isset($param['category']) && !isset($param['image'])) {
      $index_result = $this->detail_info_model->get_index(array('idx' => $param['idx']));
      $param['category'] = $index_result->category;
      $param['image'] = $index_result->image;
      unset($index_result);
    }
    $this->detail_info_model->delete_category(array('category' => $param['category']));
    unlink($param['image']);
    unset($param);
    return true;
  }

}
