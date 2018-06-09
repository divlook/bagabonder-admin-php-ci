<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
?>
  <?= $this->template_lib->header_parse(@$header) ?>
  <div class="btn-toolbar mb-2 pt-2 pb-2">
    <div class="btn-group mr-2">
      <a class="btn btn-sm btn-outline-secondary" href="detail-info/add">옷의 분류 추가하기</a>
    </div>
  </div>
  <?= $this->template_lib->table_parse(@$data) ?>
<?php
echo $template['main']['close'];
echo $template['foot'];
?>