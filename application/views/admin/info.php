<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
echo $this->template_lib->header_parse(@$header);
?>
  <form class="needs-validation form-user" novalidate>
    <input type="hidden" id="input-auth-idx" value="<?= $auth_idx ?>">
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
      <div class="invalid-feedback" id="input-password-feedback">
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
      <input type="password" class="form-control" id="input-new-password-confirm" placeholder="********">
      <div class="invalid-feedback" id="input-new-password-confirm-feedback">
        new-password and new-password-confirm are different
      </div>
    </div>

    <div class="mb-3">
      <label for="input-username">Level</label>
      <select class="form-control" id="input-level"<?= $auth_idx && $auth_idx != $user->idx ? '' : ' disabled' ?>>
        <option value="1"<?= $user->level == 1 ? ' selected' : '' ?>>1</option>
        <option value="2"<?= $user->level == 2 ? ' selected' : '' ?>>2</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="input-username">고유번호 (idx)</label>
      <input type="text" class="form-control" id="input-idx" value="<?= $user->idx ?>" disabled>
    </div>

    <div class="mb-3">
      <label for="input-username">가입한 날짜</label>
      <input type="text" class="form-control" value="<?= $user->reg_date ?>" disabled>
    </div>

    <div class="mb-3">
      <label for="input-username">최근 접속한 날짜</label>
      <input type="text" class="form-control" value="<?= $user->up_date ?>" disabled>
    </div>

    <div class="mb-3">
      <label for="input-username">정지된 날짜</label>
      <input type="text" class="form-control" value="<?= $user->del_date ?>" disabled>
    </div>

    <hr class="mb-4">
    <button class="btn btn-primary" type="submit">
      <span data-feather="edit-2">수정</span>
      Update
    </button>
    <?php if ($auth_idx) { ?>
      <button class="btn btn-action btn-dark" type="button" data-event="ban" data-method="<?= $user->del_date ? 'delete' : 'post' ?>" data-idx="<?= $user->idx ?>">
        <span data-feather="<?= $user->del_date ? 'unlock' : 'lock' ?>">정지</span>
        <?= $user->del_date ? 'Unban' : 'Ban' ?>
      </button>
    <?php } ?>
    <button class="btn btn-action btn-danger" type="button" data-event="delete" data-idx="<?= $user->idx ?>">
      <span data-feather="trash">삭제</span>
      Delete Account
    </button>
  </form>
<?php
echo $template['main']['close'];
echo $template['foot'];
?>