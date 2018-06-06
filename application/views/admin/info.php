<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
echo $this->template_lib->header_parse(@$header);
?>
  <form class="needs-validation form-user" novalidate="">
    <div class="mb-3">
      <label for="input-username">Username</label>
      <input type="text" class="form-control" id="input-username" placeholder="Username" value="<?= $user->username ?>" required>
      <div class="invalid-feedback" style="width: 100%;">
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
      <label for="input-username">Level</label>
      <input type="text" class="form-control" id="input-level" value="<?= $user->level ?>" readonly>
    </div>

    <div class="mb-3">
      <label for="input-username">고유번호 (idx)</label>
      <input type="text" class="form-control" value="<?= $user->idx ?>" readonly>
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

  <script>
    var form = document.querySelector('.form-user');
    form.addEventListener('submit', function (event) {
      event.stopPropagation()
      event.preventDefault()

      var username = form.querySelector('#input-username').value
      var password = form.querySelector('#input-password').value

      axios({
        method: 'put',
        url: app.url.join('api/user/info'),
        data: {
          username: username,
          password: password,
        }
      }).then(function (response) {
        var result = response.data

        switch (result.code) {
          case 1:
            alert('success')
            break
          default:
            alert('error')
        }
      })
    })
  </script>
<?php
echo $template['main']['close'];
echo $template['foot'];
?>