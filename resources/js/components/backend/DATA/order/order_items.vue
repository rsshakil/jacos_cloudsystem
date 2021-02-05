<template>
  <div>
    <div class="row">
      
      <div class="col-12" style="padding: 10px">
        <table class="table orderTopDetailTable table-bordered" style="width: 100%">
          <tr>
            <td class="cl_custom_color">受信日時</td>
            <td>{{order_item_lists.receive_datetime}}</td>
            <td class="cl_custom_color">取引先</td>
            <td colspan="5">{{order_item_lists.mes_lis_shi_par_sel_code}} {{order_item_lists.mes_lis_shi_par_sel_name}}</td>
          </tr>
          <tr>
            <td class="cl_custom_color">納品日</td>
            <td>{{order_item_lists.mes_lis_shi_tra_dat_delivery_date}}</td>
            <td class="cl_custom_color">部門</td>
            <td>{{order_item_lists.mes_lis_shi_tra_goo_major_category}}</td>
            <td class="cl_custom_color">便</td>
            <td> {{order_item_lists.mes_lis_shi_log_del_delivery_service_code}} {{getbyrjsonValueBykeyName('mes_lis_ord_log_del_delivery_service_code',order_item_lists.mes_lis_shi_log_del_delivery_service_code,'orders')}}</td>
            <td class="cl_custom_color">配送温度区分</td>
            <td>{{order_item_lists.mes_lis_shi_tra_ins_temperature_code}} {{getbyrjsonValueBykeyName('mes_lis_ord_tra_ins_temperature_code',order_item_lists.mes_lis_shi_tra_ins_temperature_code,'orders')}}</td>
          </tr>
        </table>
      </div>
      <div
        class="col-12"
        style="padding: 10px; margin-top: 20px"
      >
        <table class="table orderTopDetailTable table-bordered" style="width: 100%">
          <tr>
            <td class="cl_custom_color">直接納品先コード</td>
            <td>{{order_item_shipment_data_headTable.mes_lis_shi_par_shi_code}}</td>
            <td class="cl_custom_color">最終納品先</td>
            <td>{{order_item_shipment_data_headTable.mes_lis_shi_par_rec_code}} {{order_item_shipment_data_headTable.mes_lis_shi_par_rec_name}}</td>
            <td class="cl_custom_color">伝票番号</td>
            <td>{{order_item_shipment_data_headTable.mes_lis_shi_tra_trade_number}}</td>
          </tr>
          <tr>
            <td class="cl_custom_color">定／特</td>
            <td>{{order_item_shipment_data_headTable.mes_lis_shi_tra_ins_goods_classification_code}} {{getbyrjsonValueBykeyName('mes_lis_ord_tra_ins_goods_classification_code',order_item_shipment_data_headTable.mes_lis_shi_tra_ins_goods_classification_code,'orders')}}</td>
            <td class="cl_custom_color">不定貴区分</td>
            <td>{{order_item_shipment_data_headTable.mes_lis_shi_tra_fre_variable_measure_item_code}} {{getbyrjsonValueBykeyName('mes_lis_ord_tra_fre_variable_measure_item_code',order_item_shipment_data_headTable.mes_lis_shi_tra_fre_variable_measure_item_code,'orders')}}</td>
            <td class="cl_custom_color">発注者</td>
            <td>{{order_item_shipment_data_headTable.mes_lis_buy_name}}</td>
          </tr>
          <tr>
            <td class="cl_custom_color">発注日</td>
            <td>{{order_item_shipment_data_headTable.mes_lis_shi_tra_dat_order_date}}</td>
            <td class="cl_custom_color">伝票区分</td>
            <td>{{order_item_shipment_data_headTable.mes_lis_shi_tra_ins_trade_type_code}} {{getbyrjsonValueBykeyName('mes_lis_ord_tra_ins_trade_type_code',order_item_shipment_data_headTable.mes_lis_shi_tra_ins_trade_type_code,'orders')}}</td>
            <td class="cl_custom_color">出荷状況</td>
            <td>{{order_item_shipment_data_headTable.status}}</td>
          </tr>
          <tr>
            <td class="cl_custom_color">備考</td>
            <td colspan="5">{{order_item_shipment_data_headTable.mes_lis_shi_tra_not_text}}</td>
          </tr>
          <tr>
            <td class="cl_custom_color">税区分・税率</td>
            <td>{{order_item_shipment_data_headTable.mes_lis_shi_tra_tax_tax_type_code}} {{getbyrjsonValueBykeyName('mes_lis_ord_tra_tax_tax_type_code',order_item_shipment_data_headTable.mes_lis_shi_tra_tax_tax_type_code,'orders')}} {{order_item_shipment_data_headTable.mes_lis_shi_tra_tax_tax_rate}} %</td>
            <td class="cl_custom_color_extra">実納品日</td>
            <td colspan="3"><input class="form-control" type="date" v-model="order_item_shipment_data_headTable.mes_lis_shi_tra_dat_revised_delivery_date"></td>
          </tr>
          
        </table>
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
                 産地：{{order_item_detail_list.mes_lis_shi_lin_fre_field_name}}<br></td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_fre_packing_quantity}}</td>
                <td>
                <input type="text" class="form-control" v-model="order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units">
                {{order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units}}</td>
                <td>
                {{order_item_detail_list.mes_lis_shi_lin_qua_unit_of_measure}}  {{getbyrjsonValueBykeyName('mes_lis_ord_lin_qua_unit_of_measure',order_item_detail_list.mes_lis_shi_lin_qua_unit_of_measure,'orders')}}
                </td>
                <td>
                 <input type="text" class="form-control" v-model="order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity">
                {{order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity}}</td>

                <td>{{order_item_detail_list.mes_lis_shi_lin_fre_item_weight * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity}}</td>
                <td>
                 <input type="text" class="form-control" v-model="order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price">
                {{order_item_detail_list.mes_lis_ord_lin_amo_item_net_price_unit_price}}</td>
                <td> {{ order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity}}</td>
                <td>
                 <input type="text" class="form-control" v-model="order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price">
                {{order_item_detail_list.mes_lis_ord_lin_amo_item_selling_price_unit_price}}</td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity}}</td>
                <td>{{order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code}} {{getbyrjsonValueBykeyName('mes_lis_shi_lin_qua_sto_reason_code',order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code,'shipments')}}
                <select v-model="order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code" class="form-control ">
                <option v-for="item in buyer_setting_valuess.shipments.mes_lis_shi_lin_qua_sto_reason_code" :value="Object.keys(item)[0]">{{Object.values(item)[0]}}</option>
                </select>
                <!--<input type="hidden" v-model="totalCostPrice += order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity">
                <input type="hidden" v-model="totalSellingPrice += order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity">-->
                </td>

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
              <th style="text-align:center;">{{totalCostPriceVal}}</th>
              <th style="background:#538ED3;color:#fff;text-align:center;">売価全額<br>合計</th>
              <th style="text-align:center;">{{totalSellingPriceVal}}</th>
              <th></th>
              </tr>
            </tfoot>

          </table>
          <button style="float:right" @click="updateShipmentItemDetails" class="btn btn-lg btn-primary pull-right text-right active">
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
  // props: ["param_data"],
  breadcrumb(){
    return {
    label: this.breadcumbtitle,
    parent: this.parent
  }

  
},
  data() {
    return {
      breadcumbtitle:'受注伝票明細',
      parent: {
        name: 'order_list_detail',
        query: {},
},
      today: new Date().toISOString().slice(0, 10),
      sortKey: "",
      reverse: true,
      order_by: "asc",
      order_detail_lists: {},
      order_item_detail_lists: [],
      order_item_lists: {},
      buyer_setting_valuess:{},
      order_item_shipment_data_headTable: {},
      order_date: "",
      order_detail_list: [],
      show_hide_col_list: [],
      expected_delivery_date: "",
      data_order_voucher_id:'',
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
      byr_buyer_id: null,
    };
  },
  methods: {
    updateShipmentItemDetails(){
      var _this = this;
      console.log("====update======");
      console.log(this.order_item_detail_lists);
      console.log(this.order_item_shipment_data_headTable.mes_lis_shi_tra_dat_revised_delivery_date);
      var order_detailitem = {'items':this.order_item_detail_lists,'updated_date':this.order_item_shipment_data_headTable.mes_lis_shi_tra_dat_revised_delivery_date,'total_cost_price':this.totalCostPriceVal,'total_selling_price':this.totalSellingPriceVal};
      axios({
        method: "POST",
        url: this.BASE_URL + "api/update_shipment_item_details",
        data: order_detailitem,
      })
        .then(function (response) {
          //handle success
          console.log(response);
          _this.alert_icon = "success";
      _this.alert_title = "";
      _this.alert_text = "Shipment item data has been updated";
      _this.sweet_normal_alert();
          Fire.$emit("LoadByrorderItemDetail");
        })
        .catch(function (response) {
          //handle error
          console.log(response);
        });
      console.log("====update======");
    },
    getbuyerJsonSettings(){
            axios.get(this.BASE_URL + "api/buyerJsonSetting/"+this.byr_buyer_id)
            .then(({data}) => {
              this.buyer_setting_valuess = JSON.parse(data.buyer_settings);
              console.log(this.buyer_setting_valuess);
            // this.buyer_settings= this.buyer_settings.orders;
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
          //this.getbuyerJsonSetting();
          console.log(data.order_item_list_detail);
          this.order_item_detail_lists = data.order_item_list_detail;
          this.mes_lis_shi_tot_tot_net_price_total = data.order_item_list_detail[0].mes_lis_shi_tot_tot_net_price_total;
          this.mes_lis_shi_tot_tot_selling_price_total = data.order_item_list_detail[0].mes_lis_shi_tot_tot_selling_price_total;
          this.order_item_lists = data.orderItem;
          this.order_item_shipment_data_headTable = data.order_item_list_detail[0];
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
    this.byr_buyer_id = this.$session.get('byr_buyer_id');
    //this.getbuyerJsonSetting();
    Fire.$emit('byr_has_selected',this.$session.get('byr_buyer_id'));
    Fire.$emit('permission_check_for_buyer',this.$session.get('byr_buyer_id'));
console.log('first');

this.getbuyerJsonSettings();
    // console.log(this.$route.query);
    this.param_data=this.$route.query
    console.log(this.$session.get('voucher_page_query_param'));
    this.parent.query = this.$session.get('voucher_page_query_param');
    // console.log(this.param_data);
    this.loader = Vue.$loading.show();
    this.data_order_voucher_id = this.$route.params.data_order_list_voucher_id;
    console.log(this.$route.params.data_order_list_voucher_id)
    this.get_all_byr_order_item_detail();
    Fire.$on("LoadByrorderItemDetail", () => {
      
      this.get_all_byr_order_item_detail();
    });
    
    // Fire.$emit("voucher_page_query_param");
    this.col_show_hide_setting(this.$route.name);
    
  },
  computed: {
    total_selling_price: function() {
      // this.order_item_detail_lists.forEach(function (order_item_detail_list) {
      //     this.mes_lis_shi_tot_tot_selling_price_total +=order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price
      //   });
      // return this.order_item_detail_lists.reduce(function(a, c){return a + Number((c.mes_lis_shi_lin_amo_item_selling_price) || 0)}, 0)
        // return this.mes_lis_shi_tot_tot_selling_price_total;
    return 0;
    },
    totalCostPriceVal: function() {
      return this.order_item_detail_lists.reduce(function(sum,order_item_detail_list){return  sum+order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;}, 0)

      // return this.order_item_detail_lists.reduce(function (sum,order_item_detail_list) {
      //  return  sum+order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;
      // },0);
      
    },
    totalSellingPriceVal: function() {
      return this.order_item_detail_lists.reduce(function (sumselling,order_item_detail_list) {
       return  sumselling+order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;
      },0);
      
    },
    total_net_price: function() {
      // this.order_item_detail_lists.forEach(function (order_item_detail_list) {
      //     this.mes_lis_shi_tot_tot_net_price_total +=order_item_detail_list.mes_lis_shi_lin_amo_item_net_price
      //   });
      //   return this.mes_lis_shi_tot_tot_net_price_total;
      // return this.order_item_detail_lists.reduce(function(a, c){return a + Number((c.mes_lis_shi_lin_amo_item_net_price) || 0)}, 0)
    return 0;
    },
    total_selling_prices: function() {
      var totoal = 0
      // this.order_item_detail_lists.forEach(function (order_item_detail_list) {
      //     totoal +=order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price
      //   });
        return totoal;
      // return this.order_item_detail_lists.reduce(function(a, c){return a + Number((c.mes_lis_shi_lin_amo_item_selling_price) || 0)}, 0)
        // return this.mes_lis_shi_tot_tot_selling_price_total;
    },
    total_net_prices: function() {
      var totoal = 0;
      // this.order_item_detail_lists.forEach(function (order_item_detail_list) {
      //     totoal +=order_item_detail_list.mes_lis_shi_lin_amo_item_net_price
      //   });
        return totoal;
      //   return this.mes_lis_shi_tot_tot_net_price_total;
      // return this.order_item_detail_lists.reduce(function(a, c){return a + Number((c.mes_lis_shi_lin_amo_item_net_price) || 0)}, 0)
    },
  },
  mounted() {
    console.log('second');
    
    console.log("byr order detail page loaded");
    Fire.$on("voucher_page_query_param", (query_param) => {
      console.log('getparams');
     console.log(query_param);
    });
  },
};
</script>