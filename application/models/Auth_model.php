<?php

class Auth_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * @param array $param
   * @return mixed
   */
  public function get_auth($param = array())
  {
    $this->db->where('user_idx', $param['user_idx']);
    $this->db->where('access_token', $param['access_token']);
    $this->db->order_by('idx', 'desc');
    $this->db->limit(1);
    $this->db->from('auth');
    $query = $this->db->get();
    $result = $query->row();

    if ($result) {
      $this->update_auth(array(
        'user_idx' => $param['user_idx'],
        'access_token' => $param['access_token'],
      ));
    }

    return $result;
  }

  /**
   * @param array $param
   * @return bool
   */
  public function set_auth($param = array())
  {
    $this->db->set('user_idx', $param['user_idx']);
    $this->db->set('access_token', $param['access_token']);
    $this->db->set('reg_date', $this->global_lib->get_datetime());
    return $this->db->insert('auth');
  }

  public function del_auth($param = array())
  {
    if (!isset($param['user_idx']) && !isset($param['access_token'])) {
      return false;
    }
    if (isset($param['user_idx'])) $this->db->where('user_idx', $param['user_idx']);
    if (isset($param['access_token'])) $this->db->where('access_token', $param['access_token']);
    return $this->db->delete('auth');
  }

  /**
   * @param array $param
   * @return bool
   */
  public function update_auth($param = array())
  {
    $this->db->where('user_idx', $param['user_idx']);
    $this->db->where('access_token', $param['access_token']);
    $this->db->set('up_date', $this->global_lib->get_datetime());
    return $this->db->update('auth');
  }

}