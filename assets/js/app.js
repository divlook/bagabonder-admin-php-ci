;(function () {
  'use strict';

  // Example starter JavaScript for disabling form submissions if there are invalid fields
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');

    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);

  var app = function() {
    this.hello = function () {
      console.log('hello')
      return 'hello'
    }
    this.url = {
      join: function () {
        var url = app_config.base_url
        url = url.replace(/\/$/, '')
        for (var i = 0, len = arguments.length; i < len; i++) {
          var path = arguments[i]
          if (!/^\//.test(path)) path = '/' + path
          path = path.replace(/\/$/, '')
          url += path
        }
        return url
      }
    }
    this.debounce = function (fn, delay, event_prevent) {
      var timer = null
      return function() {
        var context = this
        var args = arguments
        var event = args[0]
        if (event && 'preventDefault' in event && event_prevent)
          event.preventDefault()
        if (event && 'stopPropagation' in event)
          event.stopPropagation()
        clearTimeout(timer)
        timer = setTimeout(function() {
          fn.apply(context, args)
        }, delay)
      }
    }
  }
  window.app = new app()
})()
