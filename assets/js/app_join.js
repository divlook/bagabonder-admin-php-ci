;(function () {
  'use stict'

  var form = document.querySelector('.form-user');
  var inputs = form.querySelectorAll('input');
  var limiter = form.querySelector('#limiter');
  var limiter_time = form.querySelector('time');

  var access_token = form.querySelector('#input-access-token')
  var return_url = form.querySelector('#input-return-url')

  var username = form.querySelector('#input-username')
  var username_feedback = form.querySelector('#input-username-feedback')

  var password = form.querySelector('#input-password')
  var password_feedback = form.querySelector('#input-password-feedback')

  var password_confirm = form.querySelector('#input-password-confirm')
  var password_feedback_confirm = form.querySelector('#input-password-confirm-feedback')

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

    if (event.target.id == 'input-password' || event.target.id == 'input-password-confirm') {
      if (password.value !== password_confirm.value) {
        password_confirm.classList.add('is-invalid')
      } else {
        password_confirm.classList.remove('is-invalid')
      }
    }
  }


  var submit_callback = function (event) {
    var data = {
      username: username.value,
      password: password.value,
    }

    if (access_token.value) {
      data.access_token = access_token.value
    }

    if (!password.value) {
      password.focus()
      return false
    } else if (password.value !== password_confirm.value) {
      password_confirm.value = ''
      password_confirm.focus()
      return false
    }

    axios({
      method: 'post',
      url: app.url.join('api/user/join'),
      data: data,
    }).then(function (response) {
      var result = response.data

      console.log(result)

      switch (result.code) {
        case 1:
          location.href = return_url.value ? app.url.join(return_url.value) : app.url.join('/')
          break
        default:
          alert(result.msg || 'error')
          break
      }
    })
  }

  var limit_count = limiter ? Number(limiter_time.innerText) : 0
  var limit_callback = function () {
    limit_count--
    limiter_time.innerText = limit_count

    switch (limit_count) {
      case 30:
        limiter.classList.remove('text-primary')
        limiter.classList.add('text-warning')
        break
      case 10:
        limiter.classList.remove('text-warning')
        limiter.classList.add('text-danger')
        break
    }
    if (limit_count > 0) {
      setTimeout(limit_callback, 1000)
    }
  }
  if (limiter) limit_callback()


  form.addEventListener('keydown', app.debounce(keydown_callback, 300))
  form.addEventListener('submit', app.debounce(submit_callback, 300, true))
})()
