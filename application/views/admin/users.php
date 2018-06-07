<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
echo $this->template_lib->header_parse(@$header);
?>
<div class="btn-toolbar mb-2 pt-2 pb-2">
  <div class="btn-group mr-2">
    <a class="btn btn-sm btn-outline-secondary" href="<?= base_url() ?>join?return_url=admin/users">New Account</a>
  </div>
</div>
<?php

$add_column = array();
if ($user->level == 1) {
  $add_column = array(
    'etc' => array(
      'render' => function ($row = array()) use ($user) {
        $render = '<div class="row-btn-area">';
        $render.= '<a href="' . base_url() . 'admin/info' . ($user->level == 1 ? '?idx='. $row->idx : '' ) . '" class="text-primary" data-event="info" data-idx="' . $row->idx . '"><i data-feather="edit-2">수정</i></a>';
        $render.= '&nbsp;';
        $render.= '<a href="#" class="text-dark" data-event="ban" data-method="' . ($row->del_date ? 'delete' : 'post'). '" data-idx="' . $row->idx . '"><i data-feather="' . ($row->del_date ? 'unlock' : 'lock'). '">정지</i></a>';
        $render.= '&nbsp;';
        $render.= '<a href="#" class="text-danger" data-event="delete" data-idx="' . $row->idx . '"><i data-feather="trash">삭제</i></a>';
        $render.= '</div>';
        return $render;
      },
    ),
  );
}
echo $this->template_lib->table_parse(@$users, $add_column);
echo $template['main']['close'];
echo $template['foot'];
?>

