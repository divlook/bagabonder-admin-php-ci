# Development Guilde

- [Config Guide](#config-guide)
- [Template 사용법](#template-사용법)
- [Response Guide](#response-guide)

## Config Guide

### 환경 변수

  | 이름                 | 기본값                 | 설명                                                                         |
  |---------------------|-----------------------|-----------------------------------------------------------------------------|
  | BAGABONDER_ENV_PATH | `{workspace}/env.ini` | 서버 설정으로 `$_SERVER['BAGABONDER_ENV_PATH']` 설정 파일의 위치를 정할 수 있습니다. |
  | BAGABONDER_ENV      | `development`         | development 또는 testing 또는 production                                      |

### env_example.ini

  설정파일의 기본파일입니다. 자세한 설명은 아래 `env.ini`에서 하겠습니다.

### env.ini

> `*` : 입력이 필요한 부분을 표시합니다.

- head

  | name     | type   | description |
  |----------|--------|:------------|
  | company* | string | 회사이름 |
  | title*   | string | `<title>` |

- config

  | name           | type   | description |
  |----------------|--------|:------------|
  | base_url       | string | 기본 url. 입력 안해도 상관없음. |
  | cookie_domain  | string | 쿠키 생성 옵션. |
  | session_expire | number | 세션 유효기간. 기본값 3600(1시간) |
  | date_format    | string | 날짜 표시 형식. [참고사이트](http://php.net/manual/kr/function.date.php) |

- database

  | name      | type    | description |
  |-----------|---------|:------------|
  | use*      | boolean | 사용 안하면 false |
  | port*     | number  | 없으면 null |
  | hostname* | string  |  |
  | username* | string  |  |
  | password* | string  |  |
  | database* | string  |  |
  | dbdriver* | string  | cubrid, ibase, mssql, mysql, mysqli, oci8, odbc, pdo, postgre, sqlite, sqlite3, sqlsrv |

- layout

  > # 패턴 규칙
  >
  > ex) `'/^login|join|admin\/info$/'`
  >
  > 패턴은 정규표현식으로 작성해야하며 `url`의 `path`를 입력해야 합니다.
  >
  > 파일의 이름은 `app_{path}.{css|js}` 형식으로 만들어야 합니다.
  >
  > 파일의 이름에서 `/`는 `_`로 변경해야 합니다.
  >
  > 파일의 위치는 `assets/{css|js}` 입니다.

  | name            | type   | description |
  |-----------------|--------|:------------|
  | has_css_pattern | string | 추가 css 파일이 있을 경우 여기에 패턴을 추가 해야합니다. |
  | has_js_pattern  | string | 추가 javascript 파일이 있을 경우 여기에 패턴을 추가 해야합니다. |

- routes

  | name               | type   | description |
  |--------------------|--------|:------------|
  | default_controller | string | 메인 페이지로 사용할 컨트롤러의 이름. |

- security

  | name | type   | description |
  |------|--------|:------------|
  | salt | string | 암호나 세션을 생성할 때 사용할 임의의 값. 설치 이후에 절대 변경되면 안됩니다. |

- server

  | name           | type     | description |
  |----------------|----------|:------------|
  | BAGABONDER_ENV | string   | 서버에서 설정을 바꿀 수 없을 때 사용. 서버의 설정이 우선으로 적용됨. (development, testing, production) |
  | timezone       | string   |  |
  | SECOND_CONFIG  | string   | `application/config` 폴더 내부에 추가 config를 만들 수 있음. 기본 값 `default` |
  | ALLOW_URLS*    | string[] | CORS를 허용할 URL을 입력 |

### Sidemenu

  사이드 메뉴를 관리합니다. `application/config/{SECOND_CONFIG}/config.php` 파일에서 `sidemenu`를 검색하세요.

  - Example

    ```php
    <?php
    $config['sidemenu'] = array(
      array(
        'name' => 'Dashboard',
        'icon' => 'home',
        'path' => 'dashboard',
      ),
      array(
        'name' => '관리자',
        'path' => 'admin',
        'child' => array(
          array(
            'name' => '관리자 목록',
            'icon' => 'users',
            'path' => 'users',
          ),
        ),
      ),
      array(
        'name' => 'etc',
        'icon' => 'layers',
        'path' => 'etc',
      ),
    );
    ```

  - Type

    # Sidemenu Type

    | 이름    | 타입    | 기본값    | 설명   |
    |--------|--------|----------|:------|
    | name   | string | required | 메뉴명 |
    | icon   | string |          | 값이 있으면 icon을 표시합니다. 아이콘명은 [참고사이트](https://feathericons.com/)를 참고해주세요. `child`가 있으면 강제로 `folder-plus` 나 `folder-minus`가 됩니다. |
    | path   | string | required | `dashboard` 입력시 `{base_url}/dashboard`가 됩니다. |
    | target | string |          | 'blank | _blank | _self | _top | ...' |
    | child  | array  |          | [Sidemenu Child Type](#sidemenu-child-type) |

    # Sidemenu Child Type

    | 이름    | 타입    | 기본값    | 설명   |
    |--------|--------|----------|:------|
    | name   | string | required | 메뉴명 |
    | icon   | string |          | 값이 있으면 icon을 표시합니다. 아이콘명은 [참고사이트](https://feathericons.com/)를 참고해주세요. |
    | path   | string | required | `user` 입력시 `{base_url}/{parent_path}/user`가 됩니다. |
    | target | string |          | 'blank | _blank | _self | _top | ...' |

## Template 사용법

### Parameter

  | name        | type    | default | description                |
  |:------------|:-------:|:-------:|:---------------------------|
  | use_nav     | boolean | true    | 상단 nav 사용여부             |
  | use_full    | boolean | false   | 레이아웃 사용 안할 때 가운데 정렬 |
  | use_sidebar | boolean | true    | sidebar 사용여부             |
  | use_icon    | boolean | true    | icon 사용여부                |
  | use_vue     | boolean | false   | vuejs 사용여부               |

### Example

- contorller/Blog.php

  ```php
  <?php
  class Blog extends CI_Controller {

    public function index()
    {
      $data['layout'] = array(
        'use_nav' => true,
        'use_full' => false,
        'use_sidebar' => true,
        'use_icon' => true,
      );

      $this->load->view('blogview', $data);
    }

  }
  ```

- view/blogview.php

  ```php
  <?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  $template = $this->template_lib->layout_parse(@$layout);
  echo $template['head'];
  ?>
  <div>
    <span>내용</span>
  </div>
  <?php echo $template['foot']; ?>
  ```

### Table Template

#### Type

  | name           | type                      | default  | description                |
  |:---------------|:-------------------------:|:--------:|:---------------------------|
  | page           | number                    | 1        | 현재 페이지 번호. controller에 `GET`으로 전달받음. |
  | use_pagination | boolean                   | true     | 페이지네이션 사용여부 |
  | limit          | number                    | 20       | 현재 페이지에 출력할 게시물의 수 |
  | column         | string[]                  | required | `<th>` |
  | rows           | object[]                  | required |  |
  | total          | number                    | 0        | 게시물의 총합 |
  | col_option     | [col_option](#col_option) |          | column option |
  | add_column     | [add_column](#add_column) |          | 추가 column |

##### col_option

- type

  | name   | type     | default  | description |
  |--------|----------|----------|-------------|
  | name   | string   |          | `<th>`에 들어갈 이름을 바꿔줌. 없으면 `column`명을 그대로 사용 |
  | hidden | boolean  | FALSE    | `display: none` |
  | align  | string   | 'center' | `text-align: center`, enum(left, right) |
  | render | callback |          | [add_column](#add_column)에서 사용하는 옵션. |

- Example

  ```php
  <?php
  $col_option = array(
    'idx' => array(
      'hidden' => TRUE,
    ),
    'reg_date' => array(
      'name' => '가입일',
    ),
    'up_date' => array(
      'hidden' => TRUE,
    ),
  );
  ```

##### add_column

  ```php
  <?php
  $add_column = array(
    'etc' => array(
      'name' => '기타',
      'align' => 'center',
      'render' => function ($row = array()) {
        return '
          <div class="btn-group mr-2">
            <button class="btn btn-sm btn-outline-secondary" data-idx="' . $row->idx . '">Share</button>
            <button class="btn btn-sm btn-outline-secondary" data-idx="' . $row->idx . '">Export</button>
          </div>
        ';
      },
    ),
  );

  $this->template_lib->table_parse(@$table_data, $add_column);
  ```

#### Example

- controllers/Etc.php

  ```php
  <?php
  class Etc extends CI_Controller {
    public function index()
    {
      // fake option
      $page = $this->input->get('page') ? $this->input->get('page') : 1;
      $limit = 20;
      $offset = ($page - 1) * $limit;
      $total = 231;

      $data = array(
        'header' => array(
          'title' => 'Example Page'
        ),
        'data' => array(
          'column' => array('A', 'B', 'C'),
          'rows' => array(),
          'total' => $total,
          'limit' => $limit,
          'use_pagination' => true,
          'pagination_align' => 'center',
        ),
      );

      // fake rows
      for ($i=0;$i<$limit;$i++) {
        $idx = $total - $offset - $i;
        if ($idx === 0) continue;
        $data['data']['rows'][] = (object) array(
          'A' => 'a' . $idx,
          'B' => 'b' . $idx,
          'C' => 'c' . $idx,
        );
      }

      $this->load->view('etc_page_example', $data);
    }
  }
  ```

- views/etc_page_example.php

  ```php
  <?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  $template = $this->template_lib->layout_parse(@$layout);
  echo $template['head'];
  echo $template['main']['open'];
  ?>
    <?= $this->template_lib->header_parse(@$header) ?>
    <div class="btn-toolbar mb-2 pt-2 pb-2">
      <div class="btn-group mr-2">
        <button class="btn btn-sm btn-outline-secondary">Share</button>
        <button class="btn btn-sm btn-outline-secondary">Export</button>
      </div>
      <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
        <span data-feather="calendar"></span>
        This week
      </button>
    </div>
    <?= $this->template_lib->table_parse(@$data) ?>
  <?php
  echo $template['main']['close'];
  echo $template['foot'];
  ?>
  ```

## Response Guide

- Type

  # Response

  | property      | type   | value                       |
  |:--------------|:------:|:----------------------------|
  | code          | number | [Result Code](#result-code) |
  | msg           | string | [Result Code](#result-code) |
  | data          | object | default = {}                |
  | response_time | string | only development            |

  # Result Code

  | code | msg                    | description |
  |:----:|:-----------------------|:------------|
  | 0    | fail                   | 실패 |
  | 1    | success                | 성공 |
  | 2    | required               | 필수 조건으로 인한 실패 |
  | 3    | bad parameter          | 잘못된 파라미터 |
  | 4    | overlap                | 중복 |
  | 5    | empty                  | 데이터가 없음 |
  | 6    | forbidden              | 금지된 |
  | 100  | authentication error   | 인증 에러 |
  | 101  | authentication expired | 만료된 인증 |

- Example

  ```json
  {
      "code": 1,
      "msg": "success",
      "data": {},
      "response_time": "0ms"
  }
  ```
