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
    $param['column'] = array_values(array_diff($param['column'], array('password')));

    $param['total'] = $this->db->count_all_results($table);

    $this->db->select(implode(',', $param['column']));
    $this->db->limit($param['limit']);
    $this->db->offset($param['offset']);
    $this->db->order_by('idx', 'desc');
    $param['rows'] = $this->db->get($table)->result();

    return $param;
  }

  public function put_user_data($param = array())
  {
    $this->db->from('user');
    if (isset($param['username'])) $this->db->set('username', $param['username']);
    if (isset($param['password'])) $this->db->set('password', $param['password']);
    if (isset($param['level'])) $this->db->set('level', $param['level']);
    if (isset($param['ban']))
      $this->db->set('del_date', $param['ban'] ? $this->global_lib->get_datetime() : NULL);
    $this->db->set('up_date', $this->global_lib->get_datetime());
    $this->db->where('idx', $param['idx']);
    return $this->db->update();
  }

  public function delete_user_data($param = array())
  {
    $this->db->from('user');
    $this->db->where('idx', $param['idx']);
    return $this->db->delete();
  }
}