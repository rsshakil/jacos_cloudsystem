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
                      v-model="order_date"
                      name="order_date"
                      value
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
                      v-model="expected_delivery_date"
                      name="delivery_date"
                      value
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
                <h4 class="my-0 font-weight-normal">ステータス</h4>
              </div>
              <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div>
                  <div class="form-group mb-0">
                    <input
                      type="text"
                      v-model="status"
                      name="delivery_date"
                      value
                      class="form-control text-center"
                    />
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
                  v-if="selected_columns.includes('order_type')"
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
                  v-for="byr_shop in byr_shops"
                  :key="byr_shop.byr_shop_id"
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                  rowspan="2"
                >
                  <span v-if="byr_shop.shop_name==''">{{byr_shop.shop_name_kana}}</span>
                  <span v-else>{{byr_shop.shop_name}}</span>
                  <span id="email_icon"></span>
                </th>

                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                  rowspan="2"
                >
                  ステータス
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
              <tr
                v-for="(order_detail_list,index) in order_detail_lists"
                :key="order_detail_list.byr_order_id"
              >
                <td>{{index+1}}</td>
                <td>
                  <input type="checkbox" class="form-control check_item" />
                </td>
                <td
                  v-if="selected_columns.includes('order_type')"
                >{{order_detail_list.item_name_kana}}</td>
                <td>
                  <input
                    type="text"
                    class="form_input"
                    v-model="order_detail_list.confirm_quantity"
                    readonly
                  />
                  {{order_detail_list.order_quantity}}
                </td>
                <td v-for="byr_shop in byr_shops" :key="byr_shop.byr_shop_id">
                  <input
                    type="text"
                    class="form_input"
                    v-model="order_detail_list.confirm_quantity"
                  />
                  {{order_detail_list.order_quantity}}
                </td>
                <td>{{order_detail_list.status}}</td>
                <td>
                  <button class="btn btn-primary">確定</button>
                </td>
                <td></td>
                <td>
                  <button
                    @click="edit_order_detail(order_detail_list)"
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
    <b-modal
      size="lg"
      :hide-backdrop="true"
      title="発注データ修正"
      ok-title="修正"
      cancel-title="キャンセル"
      @ok.prevent="save_user()"
      v-model="edit_order_modal"
    >
      <!-- <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
      <div class="modal-body">-->
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
      <!-- </div>
        </div>
      </div>-->
    </b-modal>
  </div>
</template>
<script>
export default {
  data() {
    return {
      order_detail_lists: {},
      byr_shops: {},
      order_date: "",
      order_detail_list: [
        {
          header_text: "注文タイプ",
          header_field: "order_type",
          status: true
        },
        {
          header_text: "分類コード",
          header_field: "category_code",
          status: true
        }
      ],
      expected_delivery_date: "",
      status: "",
      byr_order_id: "",
      edit_order_modal: false,
      form: new Form({})
    };
  },
  methods: {
    //get Table data
    get_all_byr_order_detail() {
      axios
        .get(this.BASE_URL + "api/byrorders/" + this.byr_order_id)
        .then(data => {
          this.order_detail_lists = data.data.order_list_detail;
          this.byr_shops = data.data.byr_shops;
          this.order_date = data.data.order_list_detail[0].order_date;
          this.expected_delivery_date =
            data.data.order_list_detail[0].expected_delivery_date;
          this.status = data.data.order_list_detail[0].status;
        });
    },

    edit_order_detail(order_detail_list) {
      this.edit_order_modal = true;
    }
  },

  created() {
    this.byr_order_id = this.$route.params.byr_order_id;
    this.get_all_byr_order_detail();
    this.col_show_hide_setting(this.$route.name);
    console.log("created log");
    console.log(this.byr_order_id);
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>