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

    <?php if ($layout['use_icon'] === true) { ?>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
    <?php } ?>

    <?php if ($layout['has_js'] === true) { ?>
        <script src="<?php echo base_url(); ?>assets/js/<?= $layout['js_name'] ?>.js"></script>
    <?php } ?>

  </body>
</html>
