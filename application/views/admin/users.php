<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
echo $this->template_lib->header_parse(@$header);
?>
<!-- 버튼 위치 -->
<?php
echo $this->template_lib->table_parse(@$users);
echo $template['main']['close'];
echo $template['foot'];
?>

