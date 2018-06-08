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
	}

  public function index()
  {
    redirect('shop/detail-info','auto', 301);
  }

  public function detail_info()
  {
    // fake option
    $page = $this->input->get('page') ? $this->input->get('page') : 1;
    $limit = 20;
    $offset = ($page - 1) * $limit;
    $total = 231;

    $data = array(
      'header' => array(
        'title' => 'Detail Info'
      ),
      'data' => array(
        'column' => array('A', 'B', 'C'),
        'rows' => array(),
        'total' => $total,
        'limit' => $limit,
        'use_pagination' => true,
        'pagination_align' => 'center',
      ),
    );

    // fake rows
    for ($i=0;$i<$limit;$i++) {
      $idx = $total - $offset - $i;
      if ($idx === 0) continue;
      $data['data']['rows'][] = (object) array(
        'A' => 'a' . $idx,
        'B' => 'b' . $idx,
        'C' => 'c' . $idx,
      );
    }

    $this->load->view('shop/detail-info-list', $data);
  }

}
