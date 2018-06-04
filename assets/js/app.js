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
        url.replace(/\/$/, '')
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
