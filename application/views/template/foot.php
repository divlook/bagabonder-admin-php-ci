<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <?php if ($layout['use_full'] === false) { ?>
      </div>
    </div>
    <?php } ?>

    <?php if ($layout['use_nav'] || $layout['use_sidebar']) { ?>
    <script src="<?php echo base_url(); ?>assets/js/jquery-slim.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <?php } ?>

    <?php if ($layout['use_vue']) { ?>
      <script src="<?php echo base_url(); ?>assets/js/vue.min.js"></script>
    <?php } ?>

    <script src="<?php echo base_url(); ?>assets/js/axios.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>

    <?php if ($layout['use_sidebar'] === true) { ?>
    <script src="<?php echo base_url(); ?>assets/js/sidebar.js"></script>
    <?php } ?>

    <?php if ($layout['use_nav'] === true) { ?>
    <script src="<?php echo base_url(); ?>assets/js/nav.js"></script>
    <?php } ?>

    <?php if ($layout['has_js'] === true) { ?>
    <script src="<?php echo base_url(); ?>assets/js/app_<?= $layout['js_name'] ?>.js"></script>
    <?php } ?>

    <?php if ($layout['use_icon'] === true) { ?>
      <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
      <script>
        feather.replace()
      </script>
    <?php } ?>

  </body>
</html>
