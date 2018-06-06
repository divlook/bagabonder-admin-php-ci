<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
?>
  <form class="form-signin">
    <input type="hidden" id="input-return-url" value="<?= $this->input->get('return_url') ?>">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="input-username" class="sr-only">Username</label>
    <input type="text" id="input-username" class="form-control" placeholder="Username" required autofocus>
    <label for="input-password" class="sr-only">Password</label>
    <input type="password" id="input-password" class="form-control" placeholder="Password" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
  </form>
<?php echo $template['foot']; ?>