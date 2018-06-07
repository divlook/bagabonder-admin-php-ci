;(function () {

  var btns = document.querySelectorAll('.row-btn-area > a');
  var btn_callback = function (event) {

    var method = 'get'
    var url = ''

    if (this.dataset.event === 'info') {
      location.href = this.attributes.href.value
      return
    }

    if (this.dataset.event === 'ban') {
      method = this.dataset.method || 'post'
      url = 'api/user/ban/' + this.dataset.idx
    }

    if (this.dataset.event === 'delete') {
      method = 'delete'
      url = 'api/user/delete/' + this.dataset.idx

      if (!confirm('삭제한 계정은 복구할 수 없습니다. 삭제하시겠습니까?')) {
        return
      }
    }

    axios({
      method: method,
      url: app.url.join(url),
    }).then(function (response) {
      var result = response.data

      switch (result.code) {
        case 1:
          location.reload()
          break
        default:
          alert('error')
          break
      }
    })
  }

  for (var i = 0, len = btns.length; i < len; i++) {
    btns[i].addEventListener('click', app.debounce(btn_callback, 300, true))
  }
})()