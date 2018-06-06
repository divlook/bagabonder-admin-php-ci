<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover table-sm">
    <thead>
    <tr>
      <th class="text-center">#</th>
      <?php foreach ($column as $col) {
        $default = array(
          'name' => $col,
          'hidden' => FALSE,
        );
        if (isset($col_option[$col])) {
          $option = $col_option[$col];
          if (isset($option['name']) && $option['name']) $default['name'] = $option['name'];
          if (isset($option['hidden']) && $option['hidden']) $default['hidden'] = $option['hidden'];
        }
        echo '<th class="text-center' . ($default['hidden'] ? ' d-none' : '') . '">' . $default['name'] .'</th>';
      } ?>
      <?php foreach ($add_column as $col => $option) {
        $default = array(
          'name' => $col,
          'hidden' => FALSE,
        );
        if (isset($option['name']) && $option['name']) $default['name'] = $option['name'];
        if (isset($option['hidden']) && $option['hidden']) $default['hidden'] = $option['hidden'];
        echo '<th class="text-center' . ($default['hidden'] ? ' d-none' : '') . '">' . $default['name'] .'</th>';
      } ?>
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
          <th class="text-center"><?= $num ?></th>
          <?php foreach ($column as $col) {
            $default = array(
              'align' => 'center',
              'hidden' => FALSE,
            );
            if (isset($col_option[$col])) {
              $option = $col_option[$col];
              if (isset($option['align']) && $option['align']) $default['align'] = $option['align'];
              if (isset($option['hidden']) && $option['hidden']) $default['hidden'] = $option['hidden'];
            }
            echo '<td class="text-' . $default['align'] . ($default['hidden'] ? ' d-none' : '') . '">' . ($row->{$col} ? $row->{$col} : '-') .'</td>';
          } ?>
          <?php foreach ($add_column as $col => $option) {
            $default = array(
              'align' => 'center',
              'hidden' => FALSE,
              'render' => '-',
            );
            if (isset($option['align']) && $option['align']) $default['align'] = $option['align'];
            if (isset($option['hidden']) && $option['hidden']) $default['hidden'] = $option['hidden'];
            if (isset($option['render'])) $default['render'] = $option['render']($row);
            echo '<td class="text-' . $default['align'] . ($default['hidden'] ? ' d-none' : '') . '">' . $default['render'] .'</td>';
          } ?>
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