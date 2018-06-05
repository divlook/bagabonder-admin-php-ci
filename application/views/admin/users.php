<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head']; ?>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
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

  </main>
<?php echo $template['foot']; ?>