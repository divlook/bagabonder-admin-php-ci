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
</head>

<body class="<?= $layout['use_full'] === true ? 'text-center' : '' ?>">
<?php if ($layout['use_nav'] === true) { ?>
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?= $_ENV['head']['company'] ?></a>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="<?php echo base_url(); ?>logout">Sign out</a>
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
        <?php foreach ($this->config->config['sidemenu'] as $key => $row) { ?>
          <li class="nav-item">
            <a class="nav-link <?= uri_string() == $row['path'] ? 'active' : '' ?>" href="<?= base_url() . $row['path'] ?>" target="">
              <?php if (isset($row['icon']) && $row['icon']) { ?>
                <span data-feather="<?= $row['icon'] ?>"></span>
              <?php } ?>
              <?= $row['name'] ?>
              <?php if (uri_string() == $row['path']) { ?>
                <span class="sr-only">(current)</span>
              <?php } ?>
            </a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </nav>
<?php } ?>