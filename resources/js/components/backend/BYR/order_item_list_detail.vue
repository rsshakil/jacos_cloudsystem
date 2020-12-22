<template>
  <div>
    <div class="row">
      <div class="col-12">
        <h2 class="top_title text-center">{{ myLang.quantity_confirmed }}</h2>
      </div>
      <!-- <div class="col-12 text-center">
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
      </div> -->
      <div class="col-12">
        {{ myLang.voucher_list }}
        <hr />
      </div>
      <div class="col-12" style="background: #d5dadc; padding: 10px">
        <table class="table table-bordered" style="width: 100%">
          <tr>
            <td>{{ myLang.receive_date }}</td>
            <td>
              <input type="date" class="form-control" v-model="today" />
            </td>
            <td>{{ myLang.customer_name }}</td>
            <td>
              <input type="text" class="form-control" />
            </td>
            <td colspan="4"></td>
          </tr>
          <tr>
            <td>{{ myLang.delivery_date }}</td>
            <td>
              <input type="date" class="form-control" v-model="today" />
            </td>
            <td>{{ myLang.category_code }}</td>
            <td>
              <input type="text" class="form-control" />
            </td>
            <td>{{ myLang.shipment }}</td>
            <td>
              <input type="text" class="form-control" />
            </td>
            <td>{{ myLang.temperature }}</td>
            <td>
              <input type="text" class="form-control" />
            </td>
          </tr>
          <tr>
            <td>{{ myLang.confirmation_status }}</td>
            <td>
              <select class="form-control">
                <option :value="0">{{ myLang.confirmation_status }}</option>
              </select>
            </td>
            <td colspan="6"></td>
          </tr>
        </table>
      </div>
      <div
        class="col-12"
        style="background: #d5dadc; padding: 10px; margin-top: 20px"
      >
        <table class="table table-bordered" style="width: 100%">
          <tr>
            <td>{{ myLang.direct_delivery_code }}</td>
            <td>
              <input type="search" class="form-control" />
            </td>
            <td>
              <button class="btn btn-primary" type="button">
                {{ myLang.search }}
              </button>
            </td>
            <td>
              {{ myLang.final_delivery_code }}
            </td>
            <td>
              <input type="search" class="form-control" v-model="today" />
            </td>
            <td>
              <button class="btn btn-primary" type="button">
                {{ myLang.search }}
              </button>
            </td>
            <td>
              {{ myLang.total_voucher_number }}
              <!--伝票番号-->
            </td>
            <td>
              <input type="search" class="form-control" v-model="today" />
            </td>
          </tr>
          <tr>
            <td>{{ myLang.product_code }}</td>
            <td>
              <input type="search" class="form-control" v-model="today" />
            </td>
            <td>
              <button class="btn btn-primary" type="button">
                {{ myLang.search }}
              </button>
            </td>
            <td>{{ myLang.specific }}</td>
            <td colspan="2">
              <select class="form-control">
                <option :value="0">{{ myLang.specific }}</option>
              </select>
            </td>
            <td>{{ myLang.confirmation_status }}</td>
            <td>
              <select class="form-control">
                <option :value="0">{{ myLang.confirmation_status }}</option>
              </select>
            </td>
          </tr>

          <tr>
            <td>{{ myLang.printing_status }}</td>
            <td>
              <select class="form-control">
                <option :value="0">{{ myLang.printing_status }}</option>
              </select>
            </td>
            <td colspan="6"></td>
          </tr>
        </table>
      </div>
      <div class="col-12" style="text-align: center">
       
      </div>
      <div class="col-12">
        <br />
        {{ myLang.search_result }}
        <hr />
      </div>
      <div class="col-12">
        
      </div>
      <div class="col-12">
      
      </div>
      <div class="col-12">
        <div class="">
          
          <table class="table table-striped table-bordered table-responsive order_item_details_table data_table" style="overflow-x: scroll;">
            <thead>
              <tr>
                <th>No</th>
                <th>商品</th>
                <th>入数</th>
                <th>ケース数</th>
                <th>単位</th>
                <th>バラ数</th>
                <th>重量</th>
                <th>原単価</th>
                <th>原価全額</th>
                <th>売単価</th>
                <th>売価全額</th>
                <th>欠品理由</th>
              </tr>
              
            </thead>
            <tbody>
              <tr v-for="(order_item_detail_list, index) in order_item_detail_lists" :key="index">
                <td>{{index+1}}</td>
                <td style="text-align:left;">
                商品コード：{{order_item_detail_list.mes_lis_shi_lin_ite_order_item_code}}<br>
                 JANコード： {{order_item_detail_list.mes_lis_shi_lin_ite_gtin}}<br>
                 商品名：{{order_item_detail_list.mes_lis_shi_lin_ite_name}}<br>
                 規格：{{order_item_detail_list.mes_lis_shi_lin_ite_ite_spec}}<br>
                 産地：{{order_item_detail_list.mes_lis_shi_lin_fre_field_name}}<br>
                 
                </td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_fre_packing_quantity}}</td>
                <td>
                <input type="text" class="form-control" v-model="order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units">
                {{order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units}}</td>
                <td>
                {{order_item_detail_list.mes_lis_shi_lin_qua_unit_of_measure}}
                </td>
                <td>
                 <input type="text" class="form-control" v-model="order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity">
                {{order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity}}</td>

                <td>{{order_item_detail_list.mes_lis_shi_lin_fre_order_weight}}</td>
                <td>
                 <input type="text" class="form-control" v-model="order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price">
                {{order_item_detail_list.mes_lis_ord_lin_amo_item_net_price_unit_price}}</td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_amo_item_net_price}}</td>
                <td>
                 <input type="text" class="form-control" v-model="order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price">
                {{order_item_detail_list.mes_lis_ord_lin_amo_item_selling_price_unit_price}}</td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price}}</td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code}}</td>
              </tr>
            </tbody>
            <tfoot>
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th style="background:#538ED3;color:#fff;text-align:center;">原価全額<br>合計</th>
              <th style="text-align:center;">16,166</th>
              <th style="background:#538ED3;color:#fff;text-align:center;">売価全額<br>合計</th>
              <th style="text-align:center;">10,640</th>
              <th></th>
              </tr>
            </tfoot>

          </table>
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
      <div class="panel-body add_item_body">
        <form>
          <input
            type="hidden"
            name="vendor_item_id"
            id="vendor_item_id"
            value
          />
          <div class="row">
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3"
                    >伝票番号</span
                  >
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
  // props: ["param_data"],
  data() {
    return {
      today: new Date().toISOString().slice(0, 10),
      sortKey: "",
      reverse: true,
      order_by: "asc",
      order_detail_lists: {},
      order_item_detail_lists: {},
      order_date: "",
      order_detail_list: [],
      show_hide_col_list: [],
      expected_delivery_date: "",
      data_order_voucher_id:'',
      status: "",
      // byr_order_id: "",
      edit_order_modal: false,
      selected: [],
      isCheckAll: false,
      form: new Form({}),
      param_data:[],
    };
  },
  methods: {
    checkAll() {
      this.isCheckAll = !this.isCheckAll;
      this.selected = [];
      var temp_seleted = [];
      if (this.isCheckAll) {
        this.order_detail_lists.forEach(function (order_detail_list) {
          temp_seleted.push(order_detail_list.byr_order_detail_id);
        });
        this.selected = temp_seleted;
      }
    },
    updateCheckall() {
      if (this.selected.length == this.order_detail_lists.length) {
        this.isCheckAll = true;
      } else {
        this.isCheckAll = false;
      }
    },

    update_checked_item_list() {
      var post_data = {
        selected_item: this.selected,
        user_id: Globals.user_info_id,
      };
      axios
        .post(this.BASE_URL + "api/update_byr_order_detail_status", post_data)
        .then((data) => {
          console.log(data);
          Fire.$emit("LoadByrorderDetail");
        });
    },

    exec_confirm_qty(order_detail, event) {
      if (
        parseFloat(order_detail.confirm_quantity) >
        parseFloat(order_detail.order_quantity)
      ) {
        Swal.fire({
          icon: "warning",
          title: "Invalid Confirm Quantity!",
          text: "You can not confrim order more then your order quantity!",
        });
        order_detail.confirm_quantity = order_detail.order_quantity;
      }
      if (event.key == "Enter") {
        event.preventDefault();
        console.log(event.key);
        // event.target.nextElementSibling.focus()
        // console.log(event.target.parent.closest('.lack_reasons'));
      }
    },
    sortBynumeric_valu(sortKey) {
      // this.order_detail_lists.sort((a, b) => a[sortKey] < b[sortKey] ? 1 : -1);
      if (this.order_by == "asc") {
        this.order_by = "desc";
        this.order_detail_lists.sort((a, b) => a[sortKey] - b[sortKey]);
      } else {
        this.order_by = "asc";
        this.order_detail_lists.sort((a, b) => b[sortKey] - a[sortKey]);
      }
    },
    sortByja_valu(sortKey) {
      if (this.order_by == "asc") {
        this.order_by = "desc";
        this.order_detail_lists.sort((a, b) =>
          a[sortKey].localeCompare(b[sortKey], "ja", {
            ignorePunctuation: true,
          })
        );
      } else {
        this.order_by = "asc";
        this.order_detail_lists.sort((a, b) =>
          b[sortKey].localeCompare(a[sortKey], "ja", {
            ignorePunctuation: true,
          })
        );
      }
    },
    update_shipment_detail(order_detail) {
      console.log(order_detail);
      axios({
        method: "POST",
        url: this.BASE_URL + "api/update_shipment_detail",
        data: order_detail,
      })
        .then(function (response) {
          //handle success
          console.log(response);
          Fire.$emit("LoadByrorderDetail");
        })
        .catch(function (response) {
          //handle error
          console.log(response);
        });
    },
    //get Table data
    get_all_byr_order_item_detail() {
      axios.get(this.BASE_URL + "api/order_item_details/"+this.data_order_voucher_id)
        .then(({data}) => {

          console.log(data.order_item_list_detail);
          console.log('datalll');
          this.order_item_detail_lists = data.order_item_list_detail;
          this.loader.hide();
        });
    },

    col_show_hide_setting(url_slug) {
      console.log(this.show_hide_col_list.length + "col lenght");
      if (this.show_hide_col_list.length == 0) {
        var post_data = {
          url_slug: url_slug,
          user_id: Globals.user_info_id,
        };
        axios
          .post(this.BASE_URL + "api/tblecolsetting", post_data)
          .then((data) => {
            console.log(data);
          });
      }
    },
    edit_order_detail(order_detail_list) {
      this.edit_order_modal = true;
    },
  },

  created() {
    Fire.$emit('byr_has_selected',this.$session.get('byr_buyer_id'));
    Fire.$emit('permission_check_for_buyer',this.$session.get('byr_buyer_id'));



    // console.log(this.$route.query);
    this.param_data=this.$route.query
    // console.log(this.param_data);
    this.loader = Vue.$loading.show();
    this.data_order_voucher_id = this.$route.params.data_order_list_voucher_id;
    console.log(this.$route.params.data_order_list_voucher_id)
    this.get_all_byr_order_item_detail();
    Fire.$on("LoadByrorderItemDetail", () => {
      this.get_all_byr_order_item_detail();
    });
    this.col_show_hide_setting(this.$route.name);
    
  },
  mounted() {
    console.log("byr order detail page loaded");
  },
};
</script>