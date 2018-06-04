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
    'icon' => 'settings',
    'path' => 'admin',
    'child' => array(
      array(
        'name' => '관리자 목록',
        'icon' => 'users',
        'path' => 'users',
      ),
    ),
  ),
  array(
    'name' => 'etc',
    'icon' => 'layers',
    'path' => 'etc',
  ),
);