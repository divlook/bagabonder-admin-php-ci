<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<nav aria-label="Page navigation">
  <ul class="pagination <?= $align ?>">
    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
      <a class="page-link" href="<?= $this->template_lib->pagination_link(array('page' => $page - 1)) ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <?php for ($key=1; $key <= $page_max; $key++) { ?>
      <li class="page-item <?= $key == $page ? 'active' : '' ?>">
        <a class="page-link" href="<?= $this->template_lib->pagination_link(array('page' => $key)) ?>"><?= $key ?><?php if ($key == $page) { ?> <span class="sr-only">(current)</span><?php } ?></a>
      </li>
    <?php } ?>

    <li class="page-item <?= $page == $page_max || $limit >= $total ? 'disabled' : '' ?>">
      <a class="page-link" href="<?= $this->template_lib->pagination_link(array('page' => $page + 1)) ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>