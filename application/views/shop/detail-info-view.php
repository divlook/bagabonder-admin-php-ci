<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
?>
  <?= $this->template_lib->header_parse(@$header) ?>

  <script type="text/x-template" id="detail-info-nav">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li v-for="(row, key) in nav" class="breadcrumb-item" :class="{ active: current == row.id }" :key="key">
          <a v-if="current != row.id" :href="'#' + row.id" tabindex="-1">{{row.name}}</a>
          <span v-else>{{row.name}}</span>
        </li>
      </ol>
    </nav>
  </script>

  <script type="text/x-template" id="detail-info-area">
    <div :id="id">
      <detail-info-nav :current="id" :nav="nav"></detail-info-nav>
      <h4>{{name}}</h4>
      <p>{{description}}</p>
      <slot></slot>
      <hr class="mb-4 mt-4">
    </div>
  </script>

  <div id="detail-info-form">
    <form @submit.prevent="submit" class="needs-validation was-validated mb-5" novalidate>

      <detail-info-area id="area-default">
        <div class="mb-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text">옷의 분류</label>
            </div>
            <input type="text" class="form-control" placeholder="Category" autocomplete="off" v-model="category" required>
            <div class="invalid-feedback">
              소문자 영문과 특수문자 "_"만 입력할 수 있습니다. (a~z, _)
            </div>
          </div>
        </div>

        <div class="mb-3 form-inline">
          <div class="input-group mr-2">
            <div class="input-group-prepend">
              <label class="input-group-text">옷의 명칭 수</label>
            </div>
            <input type="number" class="form-control" min="1" max="10" v-model.number="input_use" required>
            <div class="valid-feedback">
              Good.
            </div>
            <div class="invalid-feedback">
              1~10 까지 숫자만 입력해주세요.
            </div>
          </div>

          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text">옷의 사이즈 수</label>
            </div>
            <input type="number" class="form-control" min="1" max="10" v-model.number="rows_use" required>
            <div class="valid-feedback">
              Good.
            </div>
            <div class="invalid-feedback">
              1~10 까지 숫자만 입력해주세요.
            </div>
          </div>
        </div>
      </detail-info-area>

      <detail-info-area id="area-column" v-if="input_use > 0">
        <template v-for="key in 10" v-if="input_use >= key">
          <div class="mb-3" :key="key">
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text">{{'input-' + key}}</label>
              </div>
              <input type="text" class="form-control" v-model="column['input' + key]" required>
            </div>
          </div>
        </template>
      </detail-info-area>

      <detail-info-area id="area-rowname" v-if="rows_use > 0">
        <template v-for="key in 10" v-if="rows_use >= key">
          <div class="mb-3" :key="key">
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text">{{'row-' + key}}</label>
              </div>
              <input type="text" class="form-control" v-model="rowname['rows' + key]" required @keyup="upper_obj(rowname, 'rows' + key)">
            </div>
          </div>
        </template>
      </detail-info-area>

      <detail-info-area id="area-size" v-if="input_use > 0 && rows_use > 0">
        <template v-for="row in 10" v-if="rows_use >= row">
          <div class="card mb-3" :key="row">
            <div class="card-header">{{rowname['rows' + row] || '-'}}</div>
            <div class="card-body">
              <template v-for="col in 10" v-if="input_use >= col">
                <div class="input-group" :class="{'mb-3': input_use > col}" :key="col">
                  <div class="input-group-prepend">
                    <label class="input-group-text">{{column['input' + col] || 'size-' + col}}</label>
                  </div>
                  <input type="number" class="form-control" min="1" v-model.number="size['rows' + row]['input' + col]" required>
                </div>
              </template>
            </div>
          </div>
        </template>
      </detail-info-area>

      <detail-info-area id="area-style" v-if="input_use > 0">
        <template v-for="key in 10" v-if="input_use >= key">
          <div class="card mb-3" :key="key">
            <div class="card-header">{{column['input' + key] || 'style-' + key}}</div>
            <div class="card-body form-inline">
              <div class="input-group mb-2 mr-2">
                <div class="input-group-prepend">
                  <label class="input-group-text">top</label>
                </div>
                <input type="text" class="form-control" v-model="style['input' + key].top" required>
              </div>
              <div class="input-group mb-2 mr-2">
                <div class="input-group-prepend">
                  <label class="input-group-text">left</label>
                </div>
                <input type="text" class="form-control" v-model="style['input' + key].left" required>
              </div>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <label class="input-group-text">display</label>
                </div>
                <select class="form-control" v-model="style['input' + key].display" required>
                  <option value="block">block</option>
                  <option value="none">none</option>
                </select>
              </div>
            </div>
          </div>
        </template>
      </detail-info-area>

      <detail-info-area id="area-image" v-if="input_use > 0">
        <img src="http://via.placeholder.com/400x400">
      </detail-info-area>

      <template v-if="reg_date || up_date || del_date">
        <div class="mb-3 form-inline">
          <div class="input-group mr-2 mb-2">
            <div class="input-group-prepend">
              <label class="input-group-text">등록한 날짜</label>
            </div>
            <input type="text" class="form-control" v-model="reg_date" disabled>
          </div>
          <div class="input-group mr-2 mb-2">
            <div class="input-group-prepend">
              <label class="input-group-text">수정한 날짜</label>
            </div>
            <input type="text" class="form-control" v-model="up_date" disabled>
          </div>
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <label class="input-group-text">삭제한 날짜</label>
            </div>
            <input type="text" class="form-control" v-model="del_date" disabled>
          </div>
        </div>
        <hr class="mb-4">
      </template>

      <button class="btn btn-primary" type="submit">
        <span data-feather="edit-2">{{ mode === 'add' ? '추가하기' : '수정하기' }}</span>
        {{ mode === 'add' ? '추가하기' : '수정하기' }}
      </button>
    </form>
  </div>

  <script src="<?= base_url() . 'assets/js/detail_info.js' ?>"></script>
<?php
echo $template['main']['close'];
echo $template['foot'];
?>