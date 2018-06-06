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
echo $this->template_lib->table_parse(@$users, array(
  'etc' => array(
    'render' => function ($row = array()) use ($user) {
      $render = '';
      if ($row->idx == $user->idx || $user->level == 1) {
        $render.= '<a href="' . base_url() . 'admin/info' . ($user->level == 1 ? '?idx='. $row->idx : '' ) . '" class="text-primary" data-idx="' . $row->idx . '"><i data-feather="edit-2">수정</i></a>';
        $render.= '&nbsp;';
        $render.= '<a href="#" class="text-danger" data-idx="' . $row->idx . '"><i data-feather="trash">삭제</i></a>';
      }
      return $render;
    },
  ),
));
echo $template['main']['close'];
echo $template['foot'];
?>

