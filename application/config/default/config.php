<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['sidemenu'] = array(
  array(
    'name' => 'Dashboard',
    'icon' => 'home',
    'path' => 'dashboard',
  ),
  array(
    'name' => '관리자',
    'path' => 'admin',
    'child' => array(
      array(
        'name' => '관리자 정보',
        'icon' => 'user',
        'path' => 'info',
      ),
      array(
        'name' => '관리자 관리',
        'icon' => 'users',
        'path' => 'users',
      ),
    ),
  ),
  array(
    'name' => 'etc',
    'path' => 'etc',
    'child' => array(
      array(
        'name' => 'Example Page',
        'icon' => 'file',
        'path' => 'example',
      ),
    ),
  ),
  array(
    'name' => 'Shop',
    'icon' => 'layers',
    'path' => 'shop',
    'child' => array(
      array(
        'name' => 'Detail Info',
        'icon' => 'layers',
        'path' => 'detail-info',
      ),
    ),
  ),
);
