<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
echo $this->template_lib->header_parse(@$header);
?>
  <form class="needs-validation form-user" novalidate>
    <div class="mb-3">
      <label for="input-username">Username</label>
      <input type="text" class="form-control" id="input-username" placeholder="Username" autocomplete="off" value="<?= $user->username ?>" required>
      <div class="invalid-feedback" id="input-username-feedback">
        Your username is required.
      </div>
    </div>

    <div class="mb-3">
      <label for="input-password">password</label>
      <input type="password" class="form-control" id="input-password" placeholder="********" required>
      <div class="invalid-feedback">
        Your password is required.
      </div>
    </div>

    <div class="mb-3">
      <label for="input-password">new password</label>
      <input type="password" class="form-control" id="input-new-password" placeholder="********">
      <div class="invalid-feedback" id="input-new-password-feedback">
        Your new-password is required.
      </div>
    </div>

    <div class="mb-3">
      <label for="input-password">new password confirm</label>
      <input type="password" class="form-control" id="input-new-password2" placeholder="********">
      <div class="invalid-feedback" id="input-new-password-confirm-feedback">
        Your new-password-confirm is required.
      </div>
    </div>

    <div class="mb-3">
      <label for="input-username">Level</label>
      <input type="text" class="form-control" id="input-level" value="<?= $user->level ?>" readonly>
    </div>

    <div class="mb-3">
      <label for="input-username">고유번호 (idx)</label>
      <input type="text" class="form-control" id="input-idx" value="<?= $user->idx ?>" readonly>
    </div>

    <div class="mb-3">
      <label for="input-username">가입일</label>
      <input type="text" class="form-control" value="<?= $user->reg_date ?>" readonly>
    </div>

    <div class="mb-3">
      <label for="input-username">최근 접속일</label>
      <input type="text" class="form-control" value="<?= $user->up_date ?>" readonly>
    </div>

    <hr class="mb-4">
    <button class="btn btn-primary" type="submit">Update</button>
  </form>
<?php
echo $template['main']['close'];
echo $template['foot'];
?>