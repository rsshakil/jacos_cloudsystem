<template>
  <div>
    <div class="row">

      <div
        class="col-12"
        style="padding: 10px; margin-top: 20px"
      >
        <table class="table orderTopDetailTable table-bordered" style="width: 100%">
          <tr>
            <td class="cl_custom_color">受信日時</td>
            <td></td>
            <td class="cl_custom_color">取引先</td>
            <td></td>
            <td class="cl_custom_color">計上日</td>
            <td></td>
            <td class="cl_custom_color">部門</td>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td class="cl_custom_color">定／特</td>
            <td></td>
            <td class="cl_custom_color">配送温度区分</td>
            <td></td>
            <td class="cl_custom_color">データ種別</td>
            <td></td>
            <td class="cl_custom_color">直接納品先</td>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td class="cl_custom_color">最終納品先</td>
            <td></td>
            <td class="cl_custom_color">伝票番号</td>
            <td></td>
            <td class="cl_custom_color">定／特</td>
            <td></td>
            <td class="cl_custom_color">不定貫区分</td>
            <td></td>
            <td class="cl_custom_color">発注日</td>
            <td></td>
          </tr>
          <tr>
            <td class="cl_custom_color">発注者</td>
            <td></td>
            <td class="cl_custom_color">伝票区分</td>
            <td></td>
            <td class="cl_custom_color">受領内容</td>
            <td colspan="5"></td>
          </tr>
          <tr>
            <td class="cl_custom_color">備考</td>
            <td></td>
            <td class="cl_custom_color">税区分・税率</td>
            <td colspan="2"></td>
            <td class="cl_custom_color">実納品日</td>
            <td colspan="4"></td>
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
                <th>売価金額</th>
                <th>訂正理由</th>
              </tr>

            </thead>
            <tbody>

              <tr v-for="(order_item_detail_list, index) in order_item_detail_lists" :key="index">
                
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
              <th style="text-align:center;"></th>
              <th style="background:#538ED3;color:#fff;text-align:center;">売価全額<br>合計</th>
              <th style="text-align:center;"></th>
              <th></th>
              </tr>
            </tfoot>

          </table>
          <button style="float:right" class="btn btn-lg btn-primary pull-right text-right active">
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

  data() {
    return {
      sortKey: "",
      reverse: true,
      order_by: "asc",
      order_detail_lists: {},
      order_item_detail_lists: [],
      order_item_shipment_data_headTable: {},
      order_date: "",
      order_detail_list: [],
      show_hide_col_list: [],
      expected_delivery_date: "",
      data_order_voucher_id:'',
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
      data_receive_voucher_id:'',
    };
  },
beforeCreate: function() {
            if (!this.$session.exists()) {
                this.$router.push('/home');
            }
        },
  methods: {
    ball_case_cal(order_item_detail_list,field_type){
      if(field_type=='ケース'){
        order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity=order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units*order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity;
      }else{

        var calval=order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity/order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity;
    if(calval>0 && calval%1===0){
      order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units=calval;
    }
  }
      this.checkUpdateDeliveryStatus();
    },
    checkUpdateDeliveryStatus(){
      var caseBallQtycheck = [];
      var allIsZero = [];
      var allIsNotZero = [];
      var allIsZeroNotZero = [];
      var totalRows = this.order_item_detail_lists.length;
      this.order_item_detail_lists.forEach(function (order_item_detail_listData) {
          if(order_item_detail_listData.mes_lis_shi_lin_qua_shi_quantity==0){
            allIsZero.push(0);
          }else{
            allIsNotZero.push(1);
          }
      });
      this.order_item_shipment_data_headTable.status = '一部未納';
      if(totalRows==allIsZero.length){
        this.order_item_shipment_data_headTable.status='未納';
      }
      if(totalRows==allIsNotZero.length){
        this.order_item_shipment_data_headTable.status='完納';
      }
    },
    
    //get Table data
    get_all_receive_item_detail() {
      var post_data = {
        data_receive_voucher_id:this.data_receive_voucher_id,
        byr_buyer_id : this.byr_buyer_id,
        adm_user_id:Globals.user_info_id,
      };
      axios.post(this.BASE_URL + "api/data_receive_item_detail_list",post_data)
        .then(({data}) => {
          console.log(data.received_item_detail_list);
          this.order_item_detail_lists = data.received_item_detail_list;
          this.order_item_shipment_data_headTable = data.received_item_detail_list[0];
          this.loader.hide();
        });
    },

    
  },

  created() {
    this.byr_buyer_id = this.$session.get('byr_buyer_id');
    Fire.$emit('byr_has_selected',this.$session.get('byr_buyer_id'));
    Fire.$emit('permission_check_for_buyer',this.$session.get('byr_buyer_id'));
    this.loader = Vue.$loading.show();
    this.data_receive_voucher_id = this.$route.params.data_receive_voucher_id;
    console.log(this.$route.params.data_order_list_voucher_id)
    this.get_all_receive_item_detail();
    Fire.$on("LoadByrorderItemDetail", () => {

      this.get_all_receive_item_detail();
    });

  },
  computed: {
    
    
  },
  mounted() {
  },
};
</script>
