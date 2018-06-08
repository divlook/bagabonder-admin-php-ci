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

}