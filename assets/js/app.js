;(function () {
  var app = function() {
    this.hello = function () {
      console.log('hello')
      return 'hello'
    }
    this.url = {
      join: function () {
        var url = app_config.base_url
        for (var i = 0, len = arguments.length; i < len; i++) {
          var path = arguments[i]
          if (!/^\//.test(path)) path = '/' + path
          path.replace(/\/$/, '')
          url += path
        }
        return url
      }
    }
  }
  window.app = new app()
})()
