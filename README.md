# README

바가본더 쇼핑몰 관리페이지

- [설치방법](#설치방법)
- [사용법](#사용법)
- [페이지](#페이지)
- [API](#API)
- [DEVELOPMENT GUIDE](./DEVELOPMENT_GUIDE.md)

## 설치방법

- `env.ini` 파일 생성

  `env_example.ini` 파일을 참고하여 `env.ini` 파일을 만들어주세요.

  보안상 `env.ini` 파일의 이름과 주소를 변경하는게 좋습니다.

  변경방법은 [Config Guide](./DEVELOPMENT_GUIDE.md#config-guide)에서 `BAGABONDER_ENV_PATH`를 참고하시면 됩니다.

- DB 생성

  `env.ini`에서 입력하신 database를 생성해주세요.

  관리페이지의 루트 경로로 접속을 시도하면 DB table은 자동으로 생성됩니다. (http://example.com/index.php)

- 아이디 생성

  최초 접속시 최고관리자 아이디를 생성하게 됩니다.

  최고관리자를 만들 수 있는 토큰은 60초간 유효합니다.

  아이디를 생성하지 않고 유효기간이 지나면 자동으로 새로운 토큰을 발급 받지만 계속 가만히 있으면 이 과정이 무한으로 반복되기때문에 아이디를 생성하지 않을거라면 페이지를 종료 해주세요.

- 자세한 내용은 [DEVELOPMENT_GUIDE.md](./DEVELOPMENT_GUIDE.md) 파일을 참고해주세요.

## 사용법

[상품 분류 추가](#상품-분류-추가) 페이지에서 `category`를 추가한 뒤 [상품 분류 정보](#상품-분류-정보) API를 사용하시면 됩니다.

## 페이지

### 상품 분류 추가

- Url : http://example.com/shop/detail-info/add

## API

### 상품 분류 정보

- Method : GET
- Url : api/shop/detail-info-category/{category}
- Response

  ```json
  {
      "code": 1,
      "msg": "success",
      "data": {
          "idx": "1",
          "category": "jumper",
          "input_use": "4",
          "rows_use": "6",
          "image": "cdn/20180613/jumper_210330.png",
          "reg_date": "2018-06-13 20:44:18",
          "up_date": "2018-06-14 12:00:00",
          "del_date": null,
          "column": {
              "input1": "총장",
              ...
          },
          "rowname": {
              "rows1": "S",
              ...
          },
          "size": {
              "rows1": {
                  "input1": "63",
                  ...
              },
              ...
          },
          "style": {
              "input1": "{...}",
              ...
          }
      }
  }
  ```

## Reference

- [Codeigniter](https://codeigniter.com/) @3.1.9
- [Bootstrap](http://getbootstrap.com/) @4.1.1
  - [jQuery](http://jquery.com/) @3.3.1
  - [Theme](http://getbootstrap.com/docs/4.1/examples/dashboard/)
- [Vue](https://vuejs.org/) @2.5.16
- [Axios](https://github.com/axios/axios) @0.18.0
