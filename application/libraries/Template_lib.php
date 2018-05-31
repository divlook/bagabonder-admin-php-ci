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
      'foot' => $this->CI->load->view('template/foot', $data, true),
    );
  }

}