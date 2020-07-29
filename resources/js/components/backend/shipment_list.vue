<template>
  <div>
    <div class="row">
      <div class="col-12">
        <h2 class="top_title text-center">数量確定</h2>
      </div>
      <div class="col-12 text-center">
        <div class="row">
          <div class="col"></div>
          <div class="col-3">
            <div class="card mb-4 box-shadow">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">発注日</h4>
              </div>
              <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div>
                  <div class="form-group mb-0">
                    <input
                      type="text"
                      name="order_date"
                      value="2020年 7月 2日"
                      class="form-control text-center"
                      id="order_date"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-3">
            <div class="card mb-4 box-shadow">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">納品日</h4>
              </div>
              <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div>
                  <div class="form-group mb-0">
                    <input
                      type="text"
                      name="delivery_date"
                      value="2020年 7月 2日"
                      class="form-control text-center"
                      id="delivery_date"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-3">
            <div class="card mb-4 box-shadow">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">納品日</h4>
              </div>
              <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div>
                  <div class="form-group mb-0">
                    <select class="form-control text-center" id="cell2Input">
                      <option value="1" selected>一部未確定</option>
                      <option value="1">一部未確定</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col"></div>
        </div>
      </div>
      <div class="col-12">
        <div class>
          <div class="row">
            <div class="col-6">
              <button class="btn btn-primary">ピッキング表 出力</button>
              <button class="btn btn-success">すべて確定</button>
              <button class="btn btn-danger">伝票出力</button>
              <button class="btn btn-info">確定送信</button>
            </div>
            <div class="col-6 text-right">
              <button class="btn btn-warning">受注データ 出力</button>
              <button class="btn btn-dark">確定データ 取込</button>
              <a href="index.html" class="btn btn-primary">発注データ一覧へ戻る</a>
            </div>
          </div>
          <table class="table table-striped table-bordered data_table">
            <thead>
              <tr>
                <th colspan="100%" style="border: none;">
                  <select
                    class="form-control"
                    name="data_per_page"
                    id="data_per_page"
                    style="margin-left: -10px;max-width: 100px; float: left;"
                  >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                  </select>

                  <div
                    class="input-group mb-1"
                    style="margin-left: 10px;max-width: 250px; float: left;"
                  >
                    <div class="input-group-prepend">
                      <button class="btn btn-outline-primary" type="button">小売選択</button>
                    </div>
                    <select class="form-control" name>
                      <option value>スパお洗濯</option>
                      <option value="1">スーパーAAA</option>
                      <option value="1">スーパーBBB</option>
                      <option value="1">スーパーCCC</option>
                      <option value="1">スーパーDDD</option>
                    </select>
                  </div>
                  <!-- <div class="active-pink-3 active-pink-4 mb-1" style="margin-left: 10px;max-width: 100%; float: left;">
                                            <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                  </div>-->
                </th>
              </tr>
              <tr>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="id"
                  style="cursor: pointer"
                  rowspan="2"
                >
                  No
                  <span id="id_icon"></span>
                </th>
                <th rowspan="2">
                  <input type="checkbox" class="form-control check_all" />
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                  rowspan="2"
                >
                  商品名
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                >
                  確定合計
                  <span id="total_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                  rowspan="2"
                >
                  渋谷店
                  <span id="email_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                  rowspan="2"
                >
                  横浜店
                  <span id="email_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                  rowspan="2"
                >
                  さいたま店
                  <span id="email_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                  rowspan="2"
                >
                  数量確定
                  <span id="email_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                  rowspan="2"
                >
                  欠品理由
                  <span id="email_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                  rowspan="2"
                >
                  発注データ修正
                  <span id="email_icon"></span>
                </th>
              </tr>
              <tr>
                <th>発注合計</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>
                  <input type="checkbox" class="form-control check_item" />
                </td>
                <td>サントリー朝摘みＯＲ＆サントリー 天然水 ５４０ｍｌ</td>
                <td>
                  <input type="text" class="form_input" value="0" readonly /> 0
                </td>
                <td>
                  <input type="text" class="form_input" value="0" />2
                </td>
                <td>
                  <input type="text" class="form_input" value="0" />1
                </td>
                <td>一部未確定</td>
                <td>
                  <button class="btn btn-primary">確定</button>
                </td>
                <td></td>
                <td>
                  <button
                    data-toggle="modal"
                    data-target="#order_edit_modal"
                    class="btn btn-success"
                  >発注データ修正</button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>
                  <input type="checkbox" class="form-control check_item" />
                </td>
                <td>グリコ ポッキーチョコレート ２袋</td>
                <td>
                  <input type="text" class="form_input" value="0" readonly /> 0
                </td>
                <td>
                  <input type="text" class="form_input" value="0" />2
                </td>
                <td>
                  <input type="text" class="form_input" value="0" />1
                </td>
                <td>一部未確定</td>
                <td>
                  <button class="btn btn-primary">確定</button>
                </td>
                <td>
                  <select class="form-control" name="cause_of">
                    <option>入荷待ち</option>
                    <option>入荷待ち</option>
                    <option>入荷待ち</option>
                  </select>
                </td>
                <td>
                  <button
                    data-toggle="modal"
                    data-target="#order_edit_modal"
                    class="btn btn-success"
                  >発注データ修正</button>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td>
                  <input type="checkbox" class="form-control check_item" />
                </td>
                <td>アサヒ ミンティアＢフレッシュ グレープ ３０粒</td>
                <td>
                  <input type="text" class="form_input" value="0" readonly /> 0
                </td>
                <td>
                  <input type="text" class="form_input" value="0" />2
                </td>
                <td>
                  <input type="text" class="form_input" value="0" />1
                </td>
                <td>一部未確定</td>
                <td>
                  <button class="btn btn-primary">再入力</button>
                </td>
                <td>
                  <button class="btn btn-info">入荷待ち</button>
                </td>
                <td>
                  <button
                    data-toggle="modal"
                    data-target="#order_edit_modal"
                    class="btn btn-success"
                  >発注データ修正</button>
                </td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
          <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
          <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
          <input type="hidden" name="_token" id="token" value />
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="order_edit_modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title v_item_title" id="maker_modal_heading">発注データ修正</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="panel-heading">
            <div id="vendor_message"></div>
            <div class="clearfix"></div>
          </div>
          <div class="modal-body">
            <div class="panel-body add_item_body">
              <form>
                <input type="hidden" name="vendor_item_id" id="vendor_item_id" value />
                <div class="row">
                  <div class="col-6">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">伝票番号</span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="basic-url"
                        aria-describedby="basic-addon3"
                      />
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">発注日</span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="basic-url"
                        aria-describedby="basic-addon3"
                      />
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">商品名</span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="basic-url"
                        aria-describedby="basic-addon3"
                      />
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">原価</span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="basic-url"
                        aria-describedby="basic-addon3"
                      />
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">JAN</span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="basic-url"
                        aria-describedby="basic-addon3"
                      />
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">納品日</span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="basic-url"
                        aria-describedby="basic-addon3"
                      />
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">規格</span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="basic-url"
                        aria-describedby="basic-addon3"
                      />
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">売価</span>
                      </div>
                      <input
                        type="text"
                        class="form-control"
                        id="basic-url"
                        aria-describedby="basic-addon3"
                      />
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer" id="footer">
            <button class="btn btn-primary">修正</button>
            <button data-dismiss="modal" aria-label="Close" class="btn btn-danger">キャンセル</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>