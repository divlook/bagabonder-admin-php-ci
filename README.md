# README

바가본더 쇼핑몰 관리페이지

## 설치방법

- `env.ini` 파일 생성

  `env_example.ini` 파일을 참고하여 `env.ini` 파일을 만들어주세요.
    
  `[config]`와 `[database]`만 입력하시면 됩니다.
  
  보안상 `env.ini` 파일의 이름과 주소를 변경하는게 좋습니다.

  변경방법은 `index.php`에서 `APP_ENV`를 참고하시면 됩니다.

- DB 생성

  `env.ini`에서 입력하신 database를 생성해주세요.

  앱을 실행하면 table은 자동으로 생성됩니다.

- 페이지 접속

  최초 접속시 최고관리자 아이디를 생성하게 됩니다.
