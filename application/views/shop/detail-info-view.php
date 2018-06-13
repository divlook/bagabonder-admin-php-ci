<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$template = $this->template_lib->layout_parse(@$layout);
echo $template['head'];
echo $template['main']['open'];
?>
  <?= $this->template_lib->header_parse(@$header) ?>

  <style>
    .contents-input-area {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
    }

    .contents-input-area p {
      font-size: 12px;
      color: #999;
    }

    .contents-input-area .contents-input-active p {
      position: absolute;
      top: 0;
      left: 0;
    }

    .contents-input-area .contents-input-static {
      position: absolute;
      left: 0;
      bottom: 30px;
      text-align: center;
      width: 100%;
      line-height: 30px;
    }

    .contents-input-area .contents-input-static p {
      display: inline;
      padding: 0 5px;
    }

    .contents-btn-area {
      overflow: hidden;
      max-width: 400px;
      text-align: center;
    }

    .contents-btn-area button {
      width: 30px;
      height: 30px;
      display: inline-block;
      background-color: #fff;
      color: #000;
      float: left;
      outline: none;
      border: 0;
      letter-spacing: -2px;
    }

    .contents-btn-area button.active {
      background-color: #000;
      color: #fff;
    }
  </style>

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
    <form @submit.prevent="submit" class="needs-validation was-validated mb-5">

      <detail-info-area id="area-default">
        <div class="mb-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text">옷의 분류</label>
            </div>
            <input ref="inputCategory" type="text" class="form-control" placeholder="Category" autocomplete="off" v-model="category" @keyup="category_check" required :disabled="mode === 'view'">
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
                <input type="number" class="form-control" v-model.number="style['input' + key].top" required>
              </div>
              <div class="input-group mb-2 mr-2">
                <div class="input-group-prepend">
                  <label class="input-group-text">left</label>
                </div>
                <input type="number" class="form-control" v-model.number="style['input' + key].left" required>
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

      <detail-info-area id="area-preview">
        <div class="mb-3 form-inline align-items-baseline">
          <div class="input-group mb-2 mr-2">
            <input ref="file" type="file" class="form-control" @change="preview_file" accept="image/*" :required="!image">
            <div class="valid-feedback">
              Good.
            </div>
            <div class="invalid-feedback">
              이미지 파일이 필요합니다. 가로 400px 세로 400px
            </div>
          </div>
          <div class="input-group mb-2">
            <button type="button" class="btn btn-danger" @click="remove_file">삭제</button>
          </div>
        </div>

        <div class="mb-3 position-relative" style="max-width: 400px">
          <img ref="preview" :src="image_src" style="max-height: 400px;max-width: 400px;border: 1px solid rgba(0,0,0,.1)">

          <div class="contents-input-area">
            <div class="contents-input-active">
              <template v-for="key in 10" v-if="input_use >= key">
                <p :key="key" :style="{
                  top: (style['input' + key].top || (key - 1) * 16) + 'px',
                  left: style['input' + key].left + 'px',
                  display: style['input' + key].display || 'block',
                }">
                  {{size[preview.rowname]['input' + key]}}
                </p>
              </template>
            </div>

            <div class="contents-input-static">
              <template v-for="key in 10" v-if="input_use >= key">
                <p :key="key">
                  {{column['input' + key] || 'input-' + key}} {{size[preview.rowname]['input' + key]}}
                </p>
              </template>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <div class="contents-btn-area">
            <template v-for="key in 10" v-if="rows_use >= key">
              <button type="button" :class="{ active: 'rows' + key == preview.rowname }" @click="preview.rowname = 'rows' + key" :key>{{rowname['rows' + key] || 'row-' + key}}</button>
            </template>
          </div>
        </div>
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

      <button class="btn btn-primary" :class="{ 'mr-2': mode !== 'add' }" type="submit">
        <span data-feather="edit-2">{{ mode === 'add' ? '추가하기' : '수정하기' }}</span>
        {{ mode === 'add' ? '추가하기' : '수정하기' }}
      </button>

      <button class="btn btn-danger" type="button" v-if="mode !== 'add'" @click="remove">
        <span data-feather="trash">삭제하기</span>
        삭제하기
      </button>
    </form>
  </div>

  <script src="<?= base_url() . 'assets/js/detail_info.js' ?>"></script>
<?php
echo $template['main']['close'];
echo $template['foot'];
?>