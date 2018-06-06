;(function () {
  'use stict'

  var form = document.querySelector('.form-user');
  var inputs = form.querySelectorAll('input');
  var idx = form.querySelector('#input-idx')
  var username = form.querySelector('#input-username')
  var username_feedback = form.querySelector('#input-username-feedback')
  var password = form.querySelector('#input-password')
  var new_password = form.querySelector('#input-new-password')
  var new_password_feedback = form.querySelector('#input-new-password-feedback')
  var new_password_confirm = form.querySelector('#input-new-password-confirm')
  var new_password_feedback_confirm = form.querySelector('#input-new-password-confirm-feedback')


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
  }


  var submit_callback = function (event) {
    if (!password.value || !idx.value) {
      return false
    }
    axios({
      method: 'put',
      url: app.url.join('api/user/info'),
      data: {
        idx: idx.value,
        username: username.value,
        password: password.value,
      }
    }).then(function (response) {
      var result = response.data

      switch (result.code) {
        case 1:
          alert('success')
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
