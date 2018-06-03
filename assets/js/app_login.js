;(function () {

  // 로그인
  var login_form = document.querySelector('.form-signin')
  login_form.addEventListener('submit', function(event) {
    event.stopPropagation()
    event.preventDefault()

    var username = login_form.querySelector('#input-username')
    var password = login_form.querySelector('#input-password')

    if (!username.value || !password.value) {
      return false
    }

    axios.post(app_config.base_url + '/api/user/login', {
      username: username.value,
      password: password.value,
    }).then(function (response) {
      var result = response.data

      switch (result.code) {
        case 1:
          location.href = app.url.join('dashboard')
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
  })

})()
