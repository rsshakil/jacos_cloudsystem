<template>
  <div>
    <div class="row">

      <div class="col-12">
      <div class="col-12" style="background: #d8e3f0;padding: 10px;margin-bottom:20px;">
        <table class="table orderDetailTable table-bordered" style="width: 100%">
          <tr>
            <td class="cl_custom_color">受信日時</td>
            <td>
            <span v-if="order_item_lists && order_item_lists.length!=0">
            {{ order_item_lists.receive_datetime }}
            </span>
            </td>
            <td class="cl_custom_color">取引先</td>
            <td colspan="5">
            <span v-if="order_item_lists && order_item_lists.length!=0">
            {{ order_item_lists.mes_lis_shi_par_sel_code }}
              {{ order_item_lists.mes_lis_shi_par_sel_name }}
              </span>
              </td>
          </tr>
          <tr>
            <td class="cl_custom_color">納品日</td>
            <td>
            <span v-if="order_item_lists && order_item_lists.length!=0">
            {{ order_item_lists.mes_lis_shi_tra_dat_delivery_date }}
            </span>
            </td>
            <td class="cl_custom_color">部門</td>
            <td>
            <span v-if="order_item_lists && order_item_lists.length!=0">
            {{ order_item_lists.mes_lis_shi_tra_goo_major_category }}
            </span>
            </td>
            <td class="cl_custom_color">便</td>
            <td>
            <span v-if="order_item_lists && order_item_lists.length!=0">
            {{ order_item_lists.mes_lis_shi_log_del_delivery_service_code }} {{getbyrjsonValueBykeyName('mes_lis_ord_log_del_delivery_service_code',order_item_lists.mes_lis_shi_log_del_delivery_service_code,'orders')}}
            </span>
            </td>
            <td class="cl_custom_color">温度区分</td>
            <td><span v-if="order_item_lists && order_item_lists.length!=0">{{ order_item_lists.mes_lis_shi_tra_ins_temperature_code }} {{getbyrjsonValueBykeyName('mes_lis_ord_tra_ins_temperature_code',order_item_lists.mes_lis_shi_tra_ins_temperature_code,'orders')}}</span></td>
          </tr>
          <tr>
            <td class="cl_custom_color">商品コード</td>
            <td><span v-if="order_item_lists && order_item_lists.length!=0">{{ order_item_lists.mes_lis_shi_lin_ite_order_item_code }}</span></td>
            <td class="cl_custom_color">JANコード</td>
            <td colspan="5">
            <span v-if="order_item_lists && order_item_lists.length!=0">
              {{ order_item_lists.mes_lis_shi_lin_ite_gtin }}
              </span>
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">商品名</td>
            <td colspan="7">
            <span v-if="order_item_lists && order_item_lists.length!=0">
            {{order_item_lists.mes_lis_shi_lin_ite_name}}
            </span>
            </td>

          </tr>
          <tr>
            <td class="cl_custom_color">規格名</td>
            <td><span v-if="order_item_lists && order_item_lists.length!=0">{{order_item_lists.mes_lis_shi_lin_ite_ite_spec}}</span></td>
            <td class="cl_custom_color">産地</td>
            <td colspan="5">
            <span v-if="order_item_lists && order_item_lists.length!=0">
              {{order_item_lists.mes_lis_shi_lin_fre_field_name}}
              </span>
            </td>
          </tr>
        </table>
      </div>
      </div>
        <div class="col-12">
      <div class="col-12" style="padding: 10px; margin-bottom: 20px;margin-top: 20px;background:#DEE6F0"
      >
      <p><router-link to="">【一括入力】</router-link>対象行のチェックボックス を選択後、『選択行に一括反映』をクリックすると、入力値を選択行に一括反映します。</p>
        <table class="table orderDetailTable table-bordered" style="width: 100%">
          <tr>
            <td class="cl_custom_color_active">ケース数</td>
            <td><input type="text" class="form-control" v-model="order_item_lists.mes_lis_shi_lin_qua_shi_num_of_order_units" /></td>
            <td class="cl_custom_color_active">バラ数</td>
            <td><input type="text" class="form-control" v-model="order_item_lists.mes_lis_shi_lin_qua_shi_quantity"/></td>
            <td class="cl_custom_color_active">重量</td>
            <td><input type="text" class="form-control" v-model="order_item_lists.mes_lis_shi_lin_fre_order_weight"/></td>
            <td class="cl_custom_color_active">原単価</td>
            <td><input type="text" class="form-control" v-model="order_item_lists.mes_lis_shi_lin_amo_item_net_price_unit_price"/></td>
          </tr>
          <tr>
            <td class="cl_custom_color_active">売単価</td>
            <td><input type="text" class="form-control" v-model="order_item_lists.mes_lis_shi_lin_amo_item_net_price"/></td>
            <td class="cl_custom_color_active">欠品理由</td>
            <td colspan="5">
              <select class="form-control" v-model="order_item_lists.mes_lis_shi_lin_qua_sto_reason_code">
                <option v-for="(item,i) in mes_lis_shi_lin_qua_sto_reason_codeList" :key="i" :value="Object.keys(item)[0]">{{Object.values(item)[0]}}</option>
              </select>
            </td>

          </tr>


        </table>
        <button class="btn btn-primary" @click="updateOrderItemFormData" style="float:right;">選択行に一括反映 -></button>
      </div>
      </div>
      <div class="col-12" style="text-align: center">

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
                <th>伝票番号</th>
                <th>直接 納品先 コード</th>
                <th>最終 納品先 コード</th>
                <th>行</th>
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
                <td>{{order_item_detail_list.mes_lis_shi_tra_trade_number}}</td>
                <td>{{order_item_detail_list.mes_lis_shi_par_shi_code}}</td>

                <td>{{order_item_detail_list.mes_lis_shi_par_rec_code}}</td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_lin_line_number}}</td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_fre_packing_quantity}}</td>
                <td><input type="text" v-model="order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units" class="form-control"/>
                {{order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units}}
                </td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_qua_unit_of_measure}} {{getbyrjsonValueBykeyName('mes_lis_ord_lin_qua_unit_of_measure',order_item_detail_list.mes_lis_shi_lin_qua_unit_of_measure,'orders')}}</td>
                <td><input type="text" v-model="order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity" class="form-control"/>
                            {{order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity}}
                </td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_fre_item_weight * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity}}</td>
                <td class="text-right"><input type="text" v-model="order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price " class="form-control text-right"/>
                    {{order_item_detail_list.mes_lis_ord_lin_amo_item_net_price_unit_price}}
                </td>
                <td class="text-right"><!--{{order_item_detail_list.mes_lis_shi_lin_amo_item_net_price}}-->
                {{ order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity | priceFormat}}
                </td>

                <td class="text-right"><input type="text" v-model="order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price" class="form-control text-right"/>
                    {{order_item_detail_list.mes_lis_ord_lin_amo_item_selling_price_unit_price}}
                </td>
                <td class="text-right"><!--{{order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price}}-->
                {{order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity | priceFormat}}
                </td>
                <td>


                {{order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code}} {{getbyrjsonValueBykeyName('mes_lis_shi_lin_qua_sto_reason_code',order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code,'shipments')}}
                <select v-model="order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code" class="form-control ">
                <option v-for="(item,i) in mes_lis_shi_lin_qua_sto_reason_codeList" :value="Object.keys(item)[0]" :key="i">{{Object.values(item)[0]}}</option>
                </select>


                </td>
              </tr>
              <tr v-if="order_item_detail_lists && order_item_detail_lists.length==0">
            <td class="text-center" colspan="15">データがありません</td>
            </tr>

            </tbody>


          </table>
          <button style="float:right" @click="updateShipmentItemDetails" class="btn btn-primary pull-right text-right active">
              更新
            </button>
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
 breadcrumb () {
  return {
    label: '受注商品別明細',
    parentsList: [
      {
        to: {
          name: 'item_search',
          query:this.item_search_parent_query
        },
        label: '受注商品別一覧',
      },
      {
        to: {
          name: 'order_list_details',
          query: this.orderListdetailQ,
        },
        label: '受注伝票一覧'
      },
      {
        to: {
          name: 'order_list',
        },
        label: '受注受信一覧'
      },
      {
        to: {
          name: 'home',
        },
        label: 'HOME'
      }
    ]
  }
},
  data() {
    return {

      today: new Date().toISOString().slice(0, 10),
      orderListdetailQ:{},
      item_search_parent_query:{},
      sortKey: "",
      reverse: true,
      order_by: "asc",
      order_detail_lists: {},
      order_info: {},
      order_item_detail_lists: {},
      buyer_setting_valuesse: {},
      order_item_lists: [],
      order_item_shipment_data_headTable: {},
      order_date: "",
      order_detail_list: [],
      show_hide_col_list: [],
      expected_delivery_date: "",
      item_id:'',
      mes_lis_shi_tot_tot_net_price_total:0,
      mes_lis_shi_tot_tot_selling_price_total:0,
      totalCostPrice:0,
      totalSellingPrice:0,
      status: "",
      // byr_order_id: "",
      edit_order_modal: false,
      selected: [],
      isCheckAll: false,
      form: new Form({}),
      param_data:[],
      queryData:'',
    };
  },
  beforeCreate: function() {
            if (!this.$session.exists()) {
                this.$router.push('/home');
            }
        },
  methods: {
    updateShipmentItemDetails(){
      var _this = this;
      var order_detailitem = {'items':this.order_item_detail_lists,'updated_date':this.order_item_shipment_data_headTable.mes_lis_shi_tra_dat_revised_delivery_date,'total_cost_price':this.totalCostPriceVal,'total_selling_price':this.totalSellingPriceVal};
      axios({
        method: "POST",
        url: this.BASE_URL + "api/update_shipment_item_details",
        data: order_detailitem,
      })
        .then(({data})=> {
            this.init(data.status);
          _this.alert_icon = "success";
      _this.alert_title = "";
      _this.alert_text = "Shipment item data has been updated";
      _this.sweet_normal_alert();
          Fire.$emit("LoadByrorderItemDetail");
        })
        .catch(function (response) {
        });
    },
    updateOrderItemFormData(){
      var _this = this;
      var order_detailitem = {'items':this.order_item_lists};
      axios({
        method: "POST",
        url: this.BASE_URL + "api/update_shipment_item_detail_form_data",
        data: order_detailitem,
      }).then(({data})=> {
          this.init(data.status);
          _this.alert_icon = "success";
      _this.alert_title = "";
      _this.alert_text = "Shipment item form data has been updated";
      _this.sweet_normal_alert();
          Fire.$emit("LoadByrorderItemDetail");
        })
        .catch(function (response) {
        });
    },
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
        .then(({data}) => {
          this.init(data.status);
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

      axios({
        method: "POST",
        url: this.BASE_URL + "api/update_shipment_detail",
        data: order_detail,
      })
        .then(({data})=> {
          this.init(data.status);
          Fire.$emit("LoadByrorderDetail");
        })
        .catch(function (response) {

        });
    },
    //get Table data
    get_all_byr_order_item_detail() {
      axios.get(this.BASE_URL + "api/shipment_item_detail_search/"+this.item_id)
        .then(({data}) => {

          this.init(data.status);
          this.order_item_detail_lists = data.order_item_list_detail;
          if(data.order_item_list_detail && data.order_item_list_detail.length>0){
            this.mes_lis_shi_tot_tot_net_price_total = data.order_item_list_detail[0].mes_lis_shi_tot_tot_net_price_total;
          this.mes_lis_shi_tot_tot_selling_price_total = data.order_item_list_detail[0].mes_lis_shi_tot_tot_selling_price_total;
          }

          this.order_item_lists = data.orderItem;

          this.order_item_shipment_data_headTable = data.order_item_list_detail[0];
          this.loader.hide();
        });
    },

    edit_order_detail(order_detail_list) {
      this.edit_order_modal = true;
    },
  },

  created() {
    Fire.$emit('byr_has_selected',this.$session.get('byr_buyer_id'));
    Fire.$emit('permission_check_for_buyer',this.$session.get('byr_buyer_id'));

    this.item_id = this.$route.params.item_id;
    this.getbuyerJsonSettingvalue();
    this.get_all_byr_order_item_detail();
    Fire.$on("LoadByrorderItemDetail", () => {
      this.get_all_byr_order_item_detail();
    });
    this.loader = Vue.$loading.show();
    this.item_search_parent_query = this.$session.get('order_item_search_query');
    this.orderListdetailQ = this.$session.get('order_param_data');
  },
  computed: {
    totalCostPriceVal: function() {
      return this.order_item_detail_lists.reduce(function(sum,order_item_detail_list){return  sum+order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;}, 0);

    },
    totalSellingPriceVal: function() {
      return this.order_item_detail_lists.reduce(function (sumselling,order_item_detail_list) {
       return  sumselling+order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;
      },0);

    },
  },
  mounted() {
  },
};
</script>
