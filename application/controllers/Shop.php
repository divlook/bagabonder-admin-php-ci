<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

  private $auth;

	public function __construct()
	{
		parent::__construct();
    $this->auth = $this->global_lib->authenticate();
    if ($this->auth['code'] !== 1) {
      redirect('logout?code='. $this->auth['code'] . '&return_url=' . uri_string());
    }
    $this->load->model('detail_info_model');
	}

  public function index()
  {
    redirect('shop/detail-info','auto', 301);
  }

  public function detail_info($mode = '', $idx = NULL)
  {
    if ($mode === 'add' || $mode === 'view') {
      $this->_detail_info_view($mode, $idx);
      return;
    }

    $list_param = $this->global_lib->get_list_param(array(
      'page' => $this->input->get('page'),
    ));

    $table_data = $this->detail_info_model->get_detail_info_list($list_param);
    $table_data['col_option'] = array(
      'idx' => array(
        'hidden' => TRUE,
      ),
      'category' => array(
        'name' => '옷의 분류',
      ),
      'input_use' => array(
        'name' => '명칭 수',
      ),
      'rows_use' => array(
        'name' => '사이즈 수',
      ),
      'reg_date' => array(
        'name' => '등록한 날짜',
      ),
      'up_date' => array(
        'name' => '수정한 날짜',
      ),
      'del_date' => array(
        'hidden' => true,
      ),
    );

    $data = array(
      'header' => array(
        'title' => '상품 분류 관리'
      ),
      'data' => $table_data,
    );

    $this->load->view('shop/detail-info-list', $data);
  }


  public function _detail_info_view($mode = '', $idx = NULL)
  {
    $data = array(
      'header' => array(
        'title' => '상품 분류' . ($mode === 'add' ? ' 추가' : ' 수정'),
      ),
      'layout' => array(
        'use_vue' => true,
      ),
      'data' => (object) array(
        'mode' => $mode,
      ),
    );

    $this->load->view('shop/detail-info-view', $data);
  }

}
