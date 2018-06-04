;(function () {
  var store = localStorage.getItem('sidebar-active-items')
  var sidebar = document.querySelector('.sidebar')
  var sidebar_nav_items = sidebar.querySelectorAll('.nav-item')
  var store_save = function() {
    localStorage.setItem('sidebar-active-items', JSON.stringify(store))
  }

  store = store ? JSON.parse(store) : {}

  // 클릭이벤트 등록
  sidebar.addEventListener('click', function () {
    event.stopPropagation()
    var target = event.target
    if (target.tagName === 'A' && target.classList.contains('folder')) {
      event.preventDefault()
      var key = target.parentNode.dataset['key']

      target.parentNode.classList.toggle('active')

      if (store[key] && store[key] === 'active') {
        store[key] = null
      } else {
        store[key] = 'active'
      }
    }
    store_save()
    target = null
  })

  // store에 저장된 상태를 적용.
  for (var i = 0, len = sidebar_nav_items.length; i < len; i++) {
    var el = sidebar_nav_items[i]
    if (el.classList.contains('folder')) {
      var key = el.dataset['key']
      if (!store[key]) el.classList.toggle('active')
    }
  }
})()
