<?php

class Migration_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('migration');
  }

  public function get_migrations()
  {
    return $this->migration->find_migrations();
  }

  public function get_version()
  {
    $this->db->from('migrations');
    return $this->db->get()->row()->version;
  }

  public function set_version($version = FALSE)
  {
    if ($this->migration->version($version) === FALSE)
    {
      show_error($this->migration->error_string());
    }
  }

  public function set_current()
  {
    if ($this->migration->current() === FALSE)
    {
      show_error($this->migration->error_string());
    }
  }

  public function set_latest()
  {
    if ($this->migration->latest() === FALSE)
    {
      show_error($this->migration->error_string());
    }
  }

}