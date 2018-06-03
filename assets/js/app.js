;(function () {
    var app = function() {
        this.hello = function () {
            console.log('hello')
            return 'hello'
        }
    }
    window.app = new app()
})()
