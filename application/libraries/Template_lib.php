<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Template_lib
 *
 * @author uihyeon
 * 2018-06-01
 */
class Template_lib {

  protected $CI;

  public function __construct()
  {
    $this->CI =& get_instance();
  }

  public function layout_validation($layout = array())
  {
    if (!isset($layout['use_nav']))
      $layout['use_nav'] = true;

    if (!isset($layout['use_sidebar']))
      $layout['use_sidebar'] = true;

    if (!isset($layout['use_full']))
      $layout['use_full'] = false;

    if (!isset($layout['use_icon']))
      $layout['use_icon'] = true;

    foreach (['css', 'js'] as $asset) {
      $matches = null;
      $has_asset = 'has_' . $asset;
      $has_asset_pattern = $has_asset . '_pattern';
      $asset_name = $asset . '_name';

      $reg = $_ENV['layout'][$has_asset_pattern];
      if ($reg != null) {
        preg_match($reg, uri_string(), $matches);
      }

      $layout[$has_asset] = $matches != null;
      $layout[$asset_name] = $layout[$has_asset] ? str_replace('/\//g','_',$matches[0]) : null;
    }

    return $layout;
  }

  public function layout_parse($layout = array())
  {
    $data = array('layout' => $this->layout_validation($layout));
    return array(
      'head' => $this->CI->load->view('template/head', $data, true),
      'main' => $this->main_parse(),
      'foot' => $this->CI->load->view('template/foot', $data, true),
    );
  }

  public function header_validation($header = array())
  {
    if (!isset($header['title']))
      $header['title'] = 'No title';
    return $header;
  }

  public function header_parse($header = array())
  {
    $data = array('header' => $this->header_validation($header));
    return $this->CI->load->view('template/main/header', $data, true);
  }

  public function main_parse()
  {
    return array(
      'open' => '<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">',
      'close' => '</main>',
    );
  }

  public function table_validation($param = array())
  {
    if (!isset($param['page']))
      $param['page'] = $this->CI->input->get('page') ? $this->CI->input->get('page') : 1;
    if (!isset($param['use_pagination']))
      $param['use_pagination'] = true;
    if (!isset($param['limit']))
      $param['limit'] = 20;
    if (!isset($param['column']))
      $param['column'] = array();
    if (!isset($param['rows']))
      $param['rows'] = array();
    if (!isset($param['total']))
      $param['total'] = count($param['rows']);
    if(!isset($param['offset']))
      $param['offset'] = ($param['page'] - 1) * $param['limit'];
    if(!isset($param['col_option']))
      $param['col_option'] = array();
    if(!isset($param['add_column']))
      $param['add_column'] = array();
    return $param;
  }

  public function table_parse($param = array(), $add_column = array())
  {
    $data = $this->table_validation($param);
    $data['add_column'] = array_merge($data['add_column'], $add_column);
    return $this->CI->load->view('template/main/table', $data, true);
  }

  public function pagination_link($param = array())
  {
    $query_string = array_merge($_GET, $param);
    return current_url() . $this->CI->global_lib->make_query_string($query_string);
  }

  public function pagination_validation($param = array())
  {
    if (!isset($param['pagination_align']))
      $param['pagination_align'] = 'left';
    if (!isset($param['page']))
      $param['page'] = $this->CI->input->get('page') ? $this->CI->input->get('page') : 1;
    if (!isset($param['limit']))
      $param['limit'] = 20;
    if (!isset($param['total']))
      $param['total'] = 0;

    $param['page_max'] = ceil($param['total'] / $param['limit']);
    $param['align'] = '';

    /**
     * align
     * -left = justify-content-start
     * -center = justify-content-center
     * -right = justify-content-end
     */
    switch ($param['pagination_align']) {
      case 'center': $param['align'] = 'justify-content-center'; break;
      case 'right': $param['align'] = 'justify-content-end'; break;
      default: $param['align'] = 'justify-content-start'; break;
    }
    return $param;
  }

  public function pagination_parse($param = array())
  {
    $data = $this->pagination_validation($param);
    return $this->CI->load->view('template/main/pagination', $data, true);
  }

}