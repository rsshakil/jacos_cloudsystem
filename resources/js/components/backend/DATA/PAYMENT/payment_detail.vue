<template>
  <div class="row">
    <div class="col-12" style="background: #d8e3f0; padding: 10px">
      <!--<h4 class="top_title text-center" style="margin-top:10px;">{{myLang.payment_data}}</h4>-->
      <table class="table orderDetailTable table-bordered" style="width: 100%">
        <tr>
          <td class="cl_custom_color" >受信日時</td>
          <td>{{payment_detail_header.receive_datetime}}</td>

          <td class="cl_custom_color">請求取引先</td>
          <td>{{payment_detail_header.mes_lis_pay_pay_code}} {{payment_detail_header.mes_lis_pay_pay_name}}</td>

        </tr>
        <tr>
          <td class="cl_custom_color">発注者</td>
          <td>{{payment_detail_header.mes_lis_buy_code}} {{payment_detail_header.mes_lis_buy_name}}
            
          </td>

          <td class="cl_custom_color" >締日</td>
          <td>{{payment_detail_header.mes_lis_pay_per_end_date}}</td>

        </tr>
        <tr>
          <td class="cl_custom_color">支払日</td>
          <td>{{payment_detail_header.mes_lis_pay_lin_det_pay_out_date}}</td>

          <td class="cl_custom_color" >支払金額</td>
          <td class="text-right">{{payment_detail_header.mes_lis_pay_lin_det_amo_payable_amount | priceFormat}}</td>
        </tr>
      </table>
    </div>
    <div class="col-12" style="text-align: right;float:right">
      <button class="btn btn-primary active" type="button">
        支払案内書
      </button>
      <button class="btn btn-primary active" type="button" >
        ダウンロード <b-icon icon="download" animation="fade" font-scale="1.2"></b-icon>
      </button>
    </div>

    <div class="col-12">
      <div class="row">
      <div class="col-12">
      <h4 class="page_custom_title">取引先別支払合計（仕入）</h4>
        <table
          class="table table-striped order_item_details_table table-bordered data_table"
        >
          <thead>
            <tr>
              <th style="cursor: pointer">No</th>
              <th style="cursor: pointer">取引先</th>
              <th style="cursor: pointer">請求書番号</th>
              <th style="cursor: pointer">支払合計金額</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>{{payment_detail_header.mes_lis_pay_pay_gln}} {{payment_detail_header.mes_lis_pay_pay_name}}</td>
              <td><router-link :to="{
                      name: 'payment_item_detail',
                      params: {
                        payment_id:
                          payment_detail_header.data_payment_id,
                      },
                    }">{{payment_detail_header.mes_lis_pay_pay_id}}</router-link></td>
              <td class="text-right">{{paymentdetailTopTable.totalAmount | priceFormat}}</td>
            </tr>
            <tr v-if="payment_detail_header && payment_detail_header.length==0">
            <td class="text-center" colspan="4">データがありません</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-6">
        <h4 class="page_custom_title">支払合計（仕入合計ー相殺合計）</h4>
          <table
          class="table table-striped order_item_details_table table-bordered data_table"
        >
          <thead>
            <tr>
              <th style="cursor: pointer">No</th>
              <th style="cursor: pointer">内容</th>
              <th style="cursor: pointer">金額</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in pdtableleft" :key="index" :style="{ color: item.sumation_type == '2' ? 'red' : '#000' }">
              <td>{{index+1}}</td>
              <td>{{item.p_title}}</td>
              <td class="text-right">{{item.amount | priceFormat}}</td>
            </tr>
             <tr v-if="pdtableleft && pdtableleft.length==0">
            <td class="text-center" colspan="3">データがありません</td>
            </tr>
            <tr>
            <td colspan="2">支払合計金額</td>
            <td class="text-right">{{totalAmountVal | priceFormat}}</td>
            </tr>
          </tbody>
        </table>
        </div>
        <div class="col-6">
        <br>
        <h4 class="page_custom_title">相殺合計（相殺）</h4>
          <table
          class="table table-striped order_item_details_table table-bordered data_table"
        >
          <thead>
            <tr>
              <th style="cursor: pointer">No</th>
              <th style="cursor: pointer">取引先コード</th>
              <th style="cursor: pointer">相殺コード</th>
              <th style="cursor: pointer">相殺名称</th>
              <th style="cursor: pointer">相殺金額</th>
            </tr>
          </thead>
          <tbody>
              <tr v-for="(item,index) in paymentdetailRghtTable" :key="index">
              <td>{{index+1}}</td>
              <td>{{item.mes_lis_pay_pay_code}}</td>
              <td>{{item.mes_lis_pay_lin_det_det_code}}</td>
              <td>{{item.mes_lis_pay_lin_det_det_meaning}}</td>
              <td class="text-right">{{item.mes_lis_pay_lin_det_amo_payable_amount_sum | priceFormat}}</td>
            </tr>
             <tr v-if="paymentdetailRghtTable && paymentdetailRghtTable.length==0">
            <td class="text-center" colspan="5">データがありません</td>
            </tr>
            <tr>
              <td colspan="4">相殺合計金額</td>
              <td class="text-right">{{totalAmountValOffset | priceFormat}}</td>
            </tr>
            
          </tbody>
        </table>
      </div>

      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      payment_detail_header: {},
      byr_buyer_id: null,
      paymentdetailTopTable:{},
      pdtableleft:[],
      paymentdetailRghtTable:[],
      form: new Form({
        select_field_per_page_num: 10,
        page: 1,
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        mes_lis_pay_pay_code: null,
        receive_date_from: null,
        receive_date_to: null,
        mes_lis_buy_name: null,
        mes_lis_pay_per_end_date_from: null,
        mes_lis_pay_per_end_date_to: null,
        check_datetime: null,
        submit_type: "page_load",
        payment_id:'',
      }),
    };
  },
  beforeCreate: function() {
            if (!this.$session.exists()) {
                this.$router.push('/home');
            }
        },
  methods: {
    //get Table data
    getAllPaymentDetails() {
      axios.post(this.BASE_URL + "api/get_payment_detail_list", this.form)
        .then(({ data }) => {
          
          this.payment_detail_header = data.payment_item_header;
          this.paymentdetailTopTable = data.paymentdetailTopTable;
          this.pdtableleft = data.pdtableleft;
          this.paymentdetailRghtTable = data.paymentdetailRghtTable;
          
        });
    },

  },

  created() {
    this.byr_buyer_id = this.$session.get("byr_buyer_id");
    this.form.byr_buyer_id = this.byr_buyer_id;
    this.form.payment_id = this.$route.params.payment_id
    this.getAllPaymentDetails();
    Fire.$emit("byr_has_selected", this.byr_buyer_id);
    Fire.$emit("permission_check_for_buyer", this.byr_buyer_id);
    Fire.$emit("loadPageTitle", "支払合計");
  },
  computed: {
   
    totalAmountVal: function() {
      return this.pdtableleft.reduce(function (sumselling,val) {return  sumselling = (val.sumation_type=='1'?sumselling+val.amount:sumselling-val.amount)},0);

    },
   
    totalAmountValOffset: function() {
      return this.paymentdetailRghtTable.reduce(function (sumselling,val) {return  sumselling += val.mes_lis_pay_lin_det_amo_payable_amount_sum},0);

    },
  },
  mounted() {},
};
</script>
