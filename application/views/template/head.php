<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="ko">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="<?php echo base_url(); ?>favicon.ico">

  <title><?= $_ENV['head']['title'] ?></title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <?php if ($layout['use_nav'] === true || $layout['use_sidebar'] === true) { ?>
    <link href="<?php echo base_url(); ?>assets/css/default.css" rel="stylesheet">
  <?php } ?>
  <?php if ($layout['has_css'] === true) { ?>
    <link href="<?php echo base_url(); ?>assets/css/app_<?= $layout['css_name'] ?>.css" rel="stylesheet">
  <?php } ?>

  <script>
    var app_config = {
      base_url: '<?php echo base_url(); ?>'
    }
  </script>

  <?php if ($layout['use_vue']) { ?>
    <script src="<?php echo base_url(); ?>assets/js/vue.min.js"></script>
  <?php } ?>
</head>

<body class="<?= $layout['use_full'] === true ? 'text-center' : '' ?>">
<?php if ($layout['use_nav'] === true) { ?>
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?php echo base_url(); ?>"><?= $_ENV['head']['company'] ?></a>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="<?php echo base_url(); ?>logout?return_url=<?php echo uri_string(); ?>">Sign out</a>
      </li>
    </ul>
  </nav>
<?php } ?>

<?php if ($layout['use_full'] === false) { ?>
  <div class="container-fluid">
    <div class="row">
<?php } ?>

<?php if ($layout['use_sidebar'] === true) { ?>
  <nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
      <ul class="nav flex-column">
        <?php foreach ($this->config->config['sidemenu'] as $key => $row) {
          $parent_uri_string = uri_string();
          if (isset($row['child'])) {
            $child_uri_string = $this->uri->segment(1) . '/' . $this->uri->segment(2);
            $parent_uri_string = $this->uri->segment(1);
          }
          ?>
          <li class="nav-item <?= isset($row['child']) ? 'active folder' : '' ?>" data-key="<?= $key ?>">
            <a class="nav-link <?= $parent_uri_string == $row['path'] ? 'active' : '' ?> <?= isset($row['child']) ? 'folder' : '' ?>" href="<?= isset($row['child']) ? 'javascript:void()' : base_url() . $row['path'] ?>" target="<?= isset($row['target']) ? $row['target'] : false ?>">
              <?php if (isset($row['child'])) { ?>
                <span class="nav-icon off" data-feather="folder-plus"></span>
                <span class="nav-icon on" data-feather="folder-minus"></span>
              <?php } else if (isset($row['icon']) && $row['icon']) { ?>
                <span data-feather="<?= $row['icon'] ?>"></span>
              <?php } ?>
              <?= $row['name'] ?>
              <?php if ($parent_uri_string == $row['path']) { ?>
                <span class="sr-only">(current menu)</span>
              <?php } ?>
            </a>
            <?php if (isset($row['child'])) { ?>
            <ul class="nav flex-column">
              <?php foreach ($row['child'] as $child_key => $child_row) { ?>
                <li class="nav-item">
                  <a class="nav-link <?= $child_uri_string == $row['path'] . '/' . $child_row['path'] ? 'active' : 'text-black-50' ?>" href="<?= base_url(). $row['path'] . '/' . $child_row['path'] ?>" target="<?= isset($child_row['target']) ? $child_row['target'] : false ?>">
                    -
                    <?php if (isset($child_row['icon']) && $child_row['icon']) { ?>
                      <span data-feather="<?= $child_row['icon'] ?>"></span>
                    <?php } ?>
                    <?= $child_row['name'] ?>
                    <?php if ($child_uri_string == $child_row['path']) { ?>
                      <span class="sr-only">(current submenu)</span>
                    <?php } ?>
                  </a>
                </li>
              <?php } ?>
            </ul>
            <?php } ?>
          </li>
        <?php } ?>
      </ul>
    </div>
  </nav>
<?php } ?>