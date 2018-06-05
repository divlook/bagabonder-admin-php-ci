<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
?>
  <?= $this->template_lib->header_parse(@$header) ?>
  <div class="btn-toolbar mb-2 pt-2 pb-2">
    <div class="btn-group mr-2">
      <button class="btn btn-sm btn-outline-secondary">Share</button>
      <button class="btn btn-sm btn-outline-secondary">Export</button>
    </div>
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
      <span data-feather="calendar"></span>
      This week
    </button>
  </div>
  <?= $this->template_lib->table_parse(@$data) ?>
<?php
echo $template['main']['close'];
echo $template['foot'];
?>