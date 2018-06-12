<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
$add_column = array(
  'etc' => array(
    'render' => function ($row = array()) {
      $render = '<div class="row-btn-area">';
      $render.= '<a href="' . base_url() . 'shop/detail-info/view/' . $row->idx . '" class="text-primary" data-event="info" data-idx="' . $row->idx . '"><i data-feather="edit-2">수정</i></a>';
      $render.= '&nbsp;';
      $render.= '<a href="#" class="text-danger" data-event="delete" data-idx="' . $row->idx . '"><i data-feather="trash">삭제</i></a>';
      $render.= '</div>';
      return $render;
    },
  ),
);
?>
  <?= $this->template_lib->header_parse(@$header) ?>
  <div class="btn-toolbar mb-2 pt-2 pb-2">
    <div class="btn-group mr-2">
      <a class="btn btn-sm btn-outline-secondary" href="detail-info/add">옷의 분류 추가하기</a>
    </div>
  </div>
  <?= $this->template_lib->table_parse(@$data, $add_column) ?>
<?php
echo $template['main']['close'];
echo $template['foot'];
?>