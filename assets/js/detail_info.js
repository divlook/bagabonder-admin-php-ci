;(function () {
  'use strict'

  Vue.component('detail-info-nav', {
    template: '#detail-info-nav',
    props: {
      current: {
        type: String,
        required: true,
      },
      nav: {
        type: Array,
        required: true,
      }
    },
  })


  Vue.component('detail-info-area', {
    template: '#detail-info-area',
    props: {
      id: {
        type: String,
        required: true,
      },
    },
    data: function () {
      return {
        nav: [
          {
            id: 'area-default',
            name: '기본정보',
            description: '',
          },
          {
            id: 'area-column',
            name: '명칭 이름',
            description: '예) input-1 = 총장, input-2 = 어깨',
          },
          {
            id: 'area-rowname',
            name: '사이즈 이름',
            description: '예) rows-1 = S, rows-2 = M',
          },
          {
            id: 'area-size',
            name: '사이즈 정보',
            description: '사이즈 수치를 입력하시면 됩니다.',
          },
          {
            id: 'area-style',
            name: 'Style',
            description: '',
          },
          {
            id: 'area-preview',
            name: 'Preview',
            description: '',
          },
        ]
      }
    },
    computed: {
      current_data: function () {
        var that = this
        return this.nav.filter(function (el) {
          return el.id === that.id
        })[0] || {}
      },
      name: function () {
        return this.current_data.name
      },
      description: function () {
        return this.current_data.description
      },
    }
  })

  new Vue({
    el: '#detail-info-form',
    data: function () {
      return {
        category: '',
        input_use: 0,
        rows_use: 0,
        column: this.generate_input(10, 'input'),
        rowname: this.generate_input(10, 'rows'),
        size: this.generate_input(10, 'rows', this.generate_input(10, 'input')),
        style: this.generate_input(10, 'input', { top: 0, left: 0, display: 'block' }),
        image: '',
        reg_date: '',
        up_date: '',
        del_date: '',
        preview: {
          rowname: 'rows1',
        }
      }
    },
    computed: {
      mode: function () {
        var path_arr = location.pathname.split('/')
        if (path_arr.length > 3) {
          return path_arr[3]
        }
        return null
      },
    },
    watch: {
      category: function (val) {
        if (typeof val === 'string' && val) {
          if (/[^a-zA-Z_]/.test(val)) {
            this.category = ''
          } else {
            this.category = this.category.toLowerCase()
          }
        }
      },
    },
    methods: {
      generate_input: function (count, name, val) {
        var data = {}
        if (val) val = JSON.parse(JSON.stringify(val))
        for (var i = 1; i <= count; i++) {
          data['' + name + i] = val || null
        }
        return JSON.parse(JSON.stringify(data))
      },
      upper: function (val) {
        if (typeof val === 'string') {
          return val.toUpperCase()
        }
        return val
      },
      upper_obj: function (obj, key) {
        this.$set(obj, key, this.upper(obj[key]))
      },
      submit: function () {
        axios({
          method: 'post',
          url: app.url.join('api/shop/detail-info'),
          data: {
            category: this.category,
            input_use: this.input_use,
            rows_use: this.rows_use,
            column: this.column,
            rowname: this.rowname,
            size: this.size,
            style: this.style,
            image: this.image,
          },
        }).then(function (response) {
          var result = response.data
          console.log(result)
        })
      },
      preview_file: function () {
        var that = this
        var preview = this.$refs.preview
        var file    = this.$refs.file.files[0]
        var reader  = new FileReader()

        if (!/image\/(jpe?g|png|gif)/.test(file.type)) {
          this.remove_file()
        }

        reader.addEventListener("load", function () {
          preview.src = reader.result
          that.$set(that, 'image', reader.result)
        }, false)

        if (file) {
          reader.readAsDataURL(file)
        }
      },
      remove_file: function () {
        this.$refs.preview.src = 'http://via.placeholder.com/400x400/ffffff'
        this.$refs.file.value = ''
        this.$set(this, 'image', '')
      }
    }
  })
})()
