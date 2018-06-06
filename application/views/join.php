<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
?>
  <form class="needs-validation form-user" novalidate="">
    <h1 class="h3 mb-3 font-weight-normal text-center">Please sign up<?= $this->input->get('access_token') ? ' <span id="limiter" class="text-primary">(LIMIT <time>60</time>)</span>' : '' ?></h1>
    <input type="hidden" id="input-access-token" value="<?= $this->input->get('access_token') ?>">
    <input type="hidden" id="input-return-url" value="<?= $this->input->get('return_url') ?>">

    <div class="mb-3">
      <label for="input-username">Username</label>
      <input type="text" class="form-control" id="input-username" placeholder="Username" autocomplete="off" required>
      <div class="invalid-feedback" id="input-username-feedback">
        Your username is required.
      </div>
    </div>

    <div class="mb-3">
      <label for="input-password">Password</label>
      <input type="password" class="form-control" id="input-password" placeholder="********" required>
      <div class="invalid-feedback" id="input-password-feedback">
        Your password is required.
      </div>
    </div>

    <div class="mb-3">
      <label for="input-password-confirm">Password confirm</label>
      <input type="password" class="form-control" id="input-password-confirm" placeholder="********" required>
      <div class="invalid-feedback" id="input-password-confirm-feedback">
        password and password-confirm are different
      </div>
    </div>

    <hr class="mb-4">
    <button class="btn btn-primary btn-lg btn-block" type="submit">Sign up</button>
  </form>
<?php echo $template['foot']; ?>