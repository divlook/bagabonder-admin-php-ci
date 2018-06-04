# README

바가본더 쇼핑몰 관리페이지

## 설치방법

- `env.ini` 파일 생성

  `env_example.ini` 파일을 참고하여 `env.ini` 파일을 만들어주세요.

  보안상 `env.ini` 파일의 이름과 주소를 변경하는게 좋습니다.

  변경방법은 [Config Guide](#config-guide)에서 `BAGABONDER_ENV_PATH`를 참고하시면 됩니다.

- DB 생성

  `env.ini`에서 입력하신 database를 생성해주세요.

  앱을 실행하면 table은 자동으로 생성됩니다.

- 페이지 접속

  최초 접속시 최고관리자 아이디를 생성하게 됩니다.

## Config Guide

### 환경 변수

  | 이름                 | 기본값                 | 설명                                                                         |
  |---------------------|-----------------------|-----------------------------------------------------------------------------|
  | BAGABONDER_ENV_PATH | `{workspace}/env.ini` | 서버 설정으로 `$_SERVER['BAGABONDER_ENV_PATH']` 설정 파일의 위치를 정할 수 있습니다. |
  | BAGABONDER_ENV      | `development`         | development 또는 testing 또는 production                                      |
  
### env_example.ini

  설정파일의 기본파일입니다. 자세한 설명은 아래 `env.ini`에서 하겠습니다.

### env.ini

  설명 추가 예정
  
### Sidemenu

  사이드 메뉴를 관리합니다. `index.php` 파일에서 `sidemenu`를 검색하세요.
  
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

- Parameter

  | name        | type    | default | description                |
  |:------------|:-------:|:-------:|:---------------------------|
  | use_nav     | boolean | true    | 상단 nav 사용여부             |
  | use_full    | boolean | false   | 레이아웃 사용 안할 때 가운데 정렬 |
  | use_sidebar | boolean | true    | sidebar 사용여부             |
  | use_icon    | boolean | true    | icon 사용여부                |

- Example

  # contorller/Blog.php

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

  # view/blogview.php

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

  | code | msg           | description        |
  |:----:|:--------------|:-------------------|
  | 0    | fail          | 실패                |
  | 1    | success       | 성공                |
  | 2    | required      | 필수 조건으로 인한 실패 |
  | 3    | bad parameter | 잘못된 파라미터       |
  | 4    | overlap       | 중복                |
  | 5    | empty         | 데이터가 없음         |

- Example

  ```json
  {
      "code": 1,
      "msg": "success",
      "data": {},
      "response_time": "0ms"
  }
  ```
