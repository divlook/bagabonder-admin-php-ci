<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
?>
  <?= $this->template_lib->header_parse(@$header) ?>
<?php
echo $template['main']['close'];
echo $template['foot'];
?>