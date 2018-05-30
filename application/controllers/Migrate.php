<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller
{

  public function index()
  {
    $this->load->library('migration');

    // print_r($this->migration->find_migrations());
    // print_r($this->migration->version(20180531041111));

    if ($this->migration->current() === FALSE)
    {
      show_error($this->migration->error_string());
    }
  }

}