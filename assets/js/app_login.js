;(function () {

  var login_form = document.querySelector('.form-signin')
  var username = login_form.querySelector('#input-username')
  var password = login_form.querySelector('#input-password')
  var return_url = login_form.querySelector('#input-return-url')

  var login_callback = function(event) {
    if (!username.value || !password.value) {
      return false
    }

    axios.post(app.url.join('api/user/login'), {
      username: username.value,
      password: password.value,
    }).then(function (response) {
      var result = response.data
      var msg = ''

      switch (result.code) {
        case 1:
          location.href = return_url.value ? app.url.join(return_url.value) : app.url.join('dashboard')
          break
        case 3:
          alert('password가 틀렸습니다.')
          password.focus()
          break
        case 5:
          alert('등록되지 않은 username입니다.')
          username.focus()
          break
        case 6:
          msg = '계정이 정지되었습니다.'
          if (result.data.del_date) {
            msg = msg + ' (' + result.data.del_date + ')'
          }
          alert(msg)
          break
        default:
          alert(result.msg || 'error')
          break
      }
    })
  }

  login_form.addEventListener('submit', app.debounce(login_callback, 300, true))
})()
