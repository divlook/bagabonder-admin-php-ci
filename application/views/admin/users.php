<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
echo $this->template_lib->header_parse(@$header);
echo $this->template_lib->table_parse(@$users, array(
  'etc' => array(
    'render' => function ($row = array()) use ($user) {
      $render = '';
      if ($row->idx == $user->idx) {
        $render.= '<a href="/admin/info" class="text-primary" data-idx="' . $row->idx . '"><i data-feather="edit-2">수정</i></a>';
      }
      if ($user->level == 1) {
        if ($render) $render.= '&nbsp;';
        $render.= '<a href="#" class="text-danger" data-idx="' . $row->idx . '"><i data-feather="trash">삭제</i></a>';
      }
      return $render;
    },
  ),
));
echo $template['main']['close'];
echo $template['foot'];
?>

