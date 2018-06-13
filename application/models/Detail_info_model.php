<?php

class Detail_info_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function get_detail_info_list($param = array())
  {
    $table = 'detail_info_index';
    $param['column'] = $this->db->list_fields($table);

    $param['total'] = $this->db->count_all_results($table);

    $this->db->limit($param['limit']);
    $this->db->offset($param['offset']);
    $this->db->order_by('idx', 'desc');
    $param['rows'] = $this->db->get($table)->result();

    return $param;
  }

  public function category_overlap_check($param = array())
  {
    $this->db->where('category', $param['category']);
    $query = $this->db->get('detail_info_index');
    return $query->num_rows() > 0;

  }

  public function post_index($param = array())
  {
    $data = array(
      'category' => $param['category'],
      'input_use' => $param['input_use'],
      'rows_use' => $param['rows_use'],
      'image' => $param['image'],
      'reg_date' => $this->global_lib->get_datetime(),
    );

    return $this->db->insert('detail_info_index', $data);
  }

  public function post_column($param = array())
  {
    $param['reg_date'] = $this->global_lib->get_datetime();
    return $this->db->insert('detail_info_column', $param);
  }

  public function post_rowname($param = array())
  {
    $param['reg_date'] = $this->global_lib->get_datetime();
    return $this->db->insert('detail_info_rowname', $param);
  }

  public function post_size($param = array())
  {
    $param['reg_date'] = $this->global_lib->get_datetime();
    return $this->db->insert('detail_info_size', $param);
  }

  public function post_style($param = array())
  {
    $param['reg_date'] = $this->global_lib->get_datetime();
    return $this->db->insert('detail_info_style', $param);
  }

  public function get_index($param = array())
  {
    $this->db->where('idx', $param['idx']);
    $query = $this->db->get('detail_info_index');
    return $query->row();
  }

  public function get_column($param = array())
  {
    $this->db->where('category', $param['category']);
    $query = $this->db->get('detail_info_column');
    return $query->row();
  }

  public function get_rowname($param = array())
  {
    $this->db->where('category', $param['category']);
    $query = $this->db->get('detail_info_rowname');
    return $query->row();
  }

  public function get_size($param = array())
  {
    $this->db->where('category', $param['category']);
    $this->db->order_by('idx', 'asc');
    $query = $this->db->get('detail_info_size');
    return $query->result();
  }

  public function get_style($param = array())
  {
    $this->db->where('category', $param['category']);
    $query = $this->db->get('detail_info_style');
    return $query->row();
  }

  /**
   * @param array('category') $param
   * @return bool
   */
  public function delete_category($param = array())
  {
    if (!isset($param['category'])) return false;

    $tables = array(
      'detail_info_index',
      'detail_info_column',
      'detail_info_rowname',
      'detail_info_size',
      'detail_info_style',
    );

    foreach ($tables as $table) {
      $this->db->delete($table, array('category' => $param['category']));
    }
    return true;
  }

}