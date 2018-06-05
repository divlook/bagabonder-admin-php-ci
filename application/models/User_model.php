<?php

class User_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * username 중복확인
   *
   * @param string $param
   * @return int
   */
  public function username_check($param)
  {
    $this->db->where('username', $param);
    $this->db->from('user');
    $query = $this->db->get();
    return $query->num_rows();
  }

  /**
   * User 추가
   *
   * @param array $param
   * @return boolean
   */
  public function user_post($param = array())
  {
    $data = array(
      'username' => $param['username'],
      'password' => $param['password'],
      'level' => $param['level'],
      'reg_date' => $this->global_lib->get_datetime(),
    );
    return $this->db->insert('user', $data);
  }

  /**
   * @param array $param
   * @return mixed
   */
  public function get_user_data($param = array())
  {
    $this->db->from('user');
    if (isset($param['idx'])) $this->db->where('idx', $param['idx']);
    if (isset($param['username'])) $this->db->where('username', $param['username']);
    $query = $this->db->get();
    return $query->row();
  }

  public function get_user_data_list($param = array())
  {
    $table = 'user';
    $param['column'] = $this->db->list_fields($table);
    $param['column'] = array_values(array_diff($param['column'], array('password', 'del_date')));

    $this->db->where('del_date', NULL);
    $param['total'] = $this->db->count_all_results($table);

    $this->db->select(implode(',', $param['column']));
    $this->db->where('del_date', NULL);
    $this->db->limit($param['limit']);
    $this->db->offset($param['offset']);
    $this->db->order_by('idx', 'desc');
    $param['rows'] = $this->db->get($table)->result();

    return $param;
  }
}