;(function () {
  'use stict'

  var form = document.querySelector('.form-user');
  var inputs = form.querySelectorAll('input');

  var idx = form.querySelector('#input-idx')
  var auth_idx = form.querySelector('#input-auth-idx')

  var username = form.querySelector('#input-username')
  var username_feedback = form.querySelector('#input-username-feedback')

  var password = form.querySelector('#input-password')
  var password_feedback = form.querySelector('#input-password-feedback')

  var new_password = form.querySelector('#input-new-password')
  var new_password_feedback = form.querySelector('#input-new-password-feedback')

  var new_password_confirm = form.querySelector('#input-new-password-confirm')
  var new_password_feedback_confirm = form.querySelector('#input-new-password-confirm-feedback')

  var level = form.querySelector('#input-level')


  var keydown_callback = function (event) {
    if (event.target.id == 'input-username') {
      axios({
        method: 'get',
        url: app.url.join('api/user/check'),
        params: {
          username: username.value,
        }
      }).then(function (response) {
        var result = response.data

        switch (result.code) {
          case 4:
            username_feedback.innerText = '"' + username.value + '" is overlap.'
            username.classList.add('is-invalid')
            break
          default:
            username.classList.remove('is-invalid')
            username_feedback.innerText = 'Your username is required.'
            break
        }
      })
    }

    if (event.target.id == 'input-new-password' || event.target.id == 'input-new-password-confirm') {
      if (new_password.value) {
        new_password.setAttribute('required', '')
        new_password_confirm.setAttribute('required', '')
      } else {
        new_password.removeAttribute('required')
        new_password_confirm.removeAttribute('required')
      }

      if (new_password.value !== new_password_confirm.value) {
        new_password_confirm.classList.add('is-invalid')
      } else {
        new_password_confirm.classList.remove('is-invalid')
      }
    }
  }


  var submit_callback = function (event) {
    var data = {
      idx: idx.value,
      username: username.value,
      password: password.value,
      auth_idx: auth_idx.value,
      level: level.value,
    }

    if (!idx.value) {
      return false
    }

    if (!password.value) {
      password.focus()
      return false
    }
    if (new_password.value) {
      if (new_password.value !== new_password_confirm.value) {
        new_password_confirm.value = ''
        new_password_confirm.focus()
        return false
      }
      data.new_password = new_password.value
    }

    axios({
      method: 'put',
      url: app.url.join('api/user/info'),
      data: data,
    }).then(function (response) {
      var result = response.data

      switch (result.code) {
        case 1:
          alert('success')
          break
        case 3:
          password.value = ''
          password.focus()
          break
        default:
          alert('error')
          break
      }
    })
  }


  form.addEventListener('keydown', app.debounce(keydown_callback, 300))
  form.addEventListener('submit', app.debounce(submit_callback, 300, true))
})()
