<?php

class Migrate extends CI_Controller
{

  public function index()
  {
    $this->load->library('migration');

    print_r($this->migration->current());

    if ($this->migration->current() === FALSE)
    {
      show_error($this->migration->error_string());
    }

  }

}