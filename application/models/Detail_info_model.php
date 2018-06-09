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

}