<template>
  <div class="row">
    <div class="col-12" style="background: #d8e3f0; padding: 10px">
      <!--<h4 class="top_title text-center" style="margin-top:10px;">{{myLang.payment_data}}</h4>-->
      <table class="table orderDetailTable table-bordered" style="width: 100%">
        <tr>
          <td class="cl_custom_color" style="width: 12%">請求取引先コード</td>
          <td>
            <input
              type="text"
              class="form-control"
              v-model="form.mes_lis_pay_pay_code"
            />
          </td>

          <td class="cl_custom_color" style="width: 10%">受信日</td>
          <td style="width: 10%">
            <input
              type="date"
              class="form-control"
              v-model="form.receive_date_from"
            />
          </td>
          <td style="width: 9%; text-align: center">
            <b-icon icon="forward" aria-hidden="true" font-scale="1.5"></b-icon>
          </td>
          <td style="width: 10%" colspan="3">
            <input
              type="date"
              class="form-control"
              v-model="form.receive_date_to"
            />
          </td>
        </tr>
        <tr>
          <td class="cl_custom_color" style="width: 9%">発注者</td>
          <td>
            <input
              type="text"
              class="form-control"
              v-model="form.mes_lis_buy_name"
            />
          </td>

          <td class="cl_custom_color" style="width: 10%">受信日</td>
          <td style="width: 10%">
            <input
              type="date"
              class="form-control"
              v-model="form.mes_lis_pay_per_end_date_from"
            />
          </td>
          <td style="width: 9%; text-align: center">
            <b-icon icon="forward" aria-hidden="true" font-scale="1.5"></b-icon>
          </td>
          <td style="width: 10%">
            <input
              type="date"
              class="form-control"
              v-model="form.mes_lis_pay_per_end_date_from_to"
            />
          </td>
          <td class="cl_custom_color" style="width: 9%">参照状況</td>
          <td>
              <input type="date" class="form-control" v-model="form.check_datetime" />
          </td>
        </tr>
      </table>
    </div>
    <div class="col-12" style="text-align: center">
      <button class="btn btn-primary" type="button" @click="searchPaymentItem">
        {{ myLang.search }}
      </button>
    </div>

    <div class="col-12 text-center page_c_title_bar text-sm-left mb-0">
      <h4 class="page_custom_title">検索結果：一覧</h4>
      <button class="btn btn-outline-primary" type="button">
        <b-icon icon="download" animation="fade" font-scale="1.2"></b-icon>
        {{ myLang.download }}
      </button>
    </div>
    <div class="col-12">
        <div class="row">
          <div class="col-5">
            <p>
              <span class="tableRowsInfo"
                >{{ payment_lists.from }}〜{{
                  payment_lists.to
                }}
                件表示中／全：{{ payment_lists.total }}件</span
              >
              <span class="pagi">
                <advanced-laravel-vue-paginate
                  :data="payment_lists"
                  :onEachSide="2"
                  previousText="<"
                  nextText=">"
                  alignment="center"
                  @paginateTo="getAllPayments"
                />
              </span>
              <span class="selectPagi">
                <select
                  @change="getAllPayments"
                  v-model="form.select_field_per_page_num"
                  class="form-control selectPage"
                >
                  <option value="10">10行</option>
                  <option value="20">20行</option>
                  <option value="50">50行</option>
                  <option value="100">100行</option>
                </select>
              </span>
            </p>
          </div>
        </div>
      </div>
    <div class="col-12">
      <div class="">
        <table
          class="table table-striped order_item_details_table table-bordered data_table"
        >
          <thead>
            <tr>
              <th style="cursor: pointer">No</th>
              <th style="cursor: pointer">受注日時</th>
              <th style="cursor: pointer">請求取引先コード</th>
              <th style="cursor: pointer">発注者</th>
              <th style="cursor: pointer">締日</th>
              <th style="cursor: pointer">支払日</th>
              <th style="cursor: pointer">支払金額</th>
              <th style="cursor: pointer">参照状況</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(payment, index) in payment_lists.data" :key="index">
              <td>{{ index + 1 }}</td>
              <td><router-link
                    :to="{
                      name: 'payment_detail',
                      params: {
                        payment_id:
                          payment.data_payment_id,
                      },
                    }"
                    class=""
                    >{{ payment.receive_datetime }}
                    </router-link>
                    </td>
              <td>{{ payment.mes_lis_pay_pay_code }}</td>
              <td>{{ payment.mes_lis_buy_name }}</td>
              <td>{{ payment.mes_lis_pay_per_end_date }}</td>
              <td>{{ payment.mes_lis_pay_lin_det_pay_out_date }}</td>
              <td class="text-right">{{ payment.mes_lis_pay_lin_det_amo_payable_amount | priceFormat}}</td>
              <td>{{ payment.check_datetime }}</td>
            </tr>
            <tr v-if="payment_lists.data && payment_lists.data.length==0">
            <td class="text-center" colspan="8">データがありません</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      payment_lists: {},
      byr_buyer_lists: {},
      byr_buyer_id: null,
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
    getAllPayments() {
      axios.post(this.BASE_URL + "api/get_payment_list", this.form)
        .then(({ data }) => {
          this.init(data.status);
          this.payment_lists = data.payment_item_list;
          this.byr_buyer_lists = data.byr_buyer_list;
        });
    },
    searchPaymentItem(){
        this.form.submit_type="search"
        this.getAllPayments();
    },
  },

  created() {
    this.byr_buyer_id = this.$session.get("byr_buyer_id");
    this.form.byr_buyer_id = this.byr_buyer_id;
    this.getAllPayments();
    // Fire.$on("getAllPayments", () => {
    // this.getAllPayments();
    // });
    Fire.$emit("byr_has_selected", this.byr_buyer_id);
    Fire.$emit("permission_check_for_buyer", this.byr_buyer_id);
    Fire.$emit("loadPageTitle", "支払受信一覧");
  },
  mounted() {},
};
</script>
