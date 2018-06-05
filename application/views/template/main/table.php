<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
    <tr>
      <th>#</th>
      <?php foreach ($column as $col) { echo '<th>' . $col .'</th>'; } ?>
    </tr>
    </thead>
    <tbody>
      <?php for ($key = 0; $key < $limit; $key++) { ?>
        <?php
        $num = $total - $offset - $key;
        if ($num === 0) break;
        $row = $rows[$key];
        ?>
        <tr>
          <td><?= $num ?></td>
          <?php foreach ($column as $col) { echo '<td>' . ($row->{$col} ? $row->{$col} : '-') .'</td>'; } ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php
if ($use_pagination) {
  echo $this->template_lib->pagination_parse(array(
    'pagination_align' => @$pagination_align,
    'page' => @$page,
    'limit' => @$limit,
    'total' => @$total,
  ));
}
?>