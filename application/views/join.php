<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
?>
<form class="needs-validation form-user" novalidate="">
    <h1 class="h3 mb-3 font-weight-normal text-center">Please sign up</h1>
    <input type="hidden" id="input-level" value="<?= $this->input->post('level') ?>">
    <input type="hidden" id="input-return-url">

    <div class="mb-3">
        <label for="input-username">Username</label>
        <input type="text" class="form-control" id="input-username" placeholder="Username" required>
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
    <hr class="mb-4">
    <button class="btn btn-primary btn-lg btn-block" type="submit">Sign up</button>
</form>

<script>
    var form = document.querySelector('.form-user');
    form.addEventListener('submit', function (event) {
      event.stopPropagation()
      event.preventDefault()

      var username = form.querySelector('#input-username').value
      var password = form.querySelector('#input-password').value
      var level = form.querySelector('#input-level').value || 2
      var return_url = form.querySelector('#input-return-url').value || '/'

      axios({
        method: 'post',
        url: app.url.join('api/user/join'),
        data: {
          username: username,
          password: password,
          level: level,
        }
      }).then(function (response) {
        var result = response.data

        switch (result.code) {
          case 1:
            location.href = app.url.join(return_url)
            break
          default:
            alert('error')
        }
      })
    })
</script>
<?php echo $template['foot']; ?>