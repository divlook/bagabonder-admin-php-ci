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

      switch (result.code) {
        case 1:
          location.href = return_url.value ? app.url.join(return_url.value) : app.url.join('dashboard')
          break
        case 3:
          alert('password 틀림')
          password.focus()
          break
        case 5:
          alert('username이 없음')
          username.focus()
          break
        default:
          alert('error')
          break
      }
    })
  }

  login_form.addEventListener('submit', app.debounce(login_callback, 300, true))
})()
