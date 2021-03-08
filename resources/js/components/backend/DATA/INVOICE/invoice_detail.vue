<template>
  <div class="row">
    <div class="col-12">
      <table
        class="table orderTopDetailTable table-bordered"
        style="width: 100%"
      >
        <tr>
          <td class="cl_custom_color">締日</td>
          <td><input type="text" class="form-control" /></td>
          <td class="cl_custom_color">納品日</td>
          <td>
            <input type="text" class="form-control" />
          </td>
          <td class="cl_custom_color">納品先</td>
          <td>
            <input type="text" class="form-control" />
          </td>
          <td class="cl_custom_color">伝票番号</td>
          <td>
            <input type="text" class="form-control" />
          </td>
        </tr>
        <tr>
          <td class="cl_custom_color">伝票区分</td>
          <td colspan="7"><input type="text" class="form-control" /></td>
        </tr>
      </table>
    </div>
    <div class="col-12 text-center">
      <button class="btn btn-primary active srchBtn" type="button">
        {{ myLang.search }}
      </button>
    </div>
    <div class="col-12">
      <br />
      <h4 class="page_custom_title">{{ myLang.search_result }}</h4>
    </div>
    <div class="col-12">
      <p>
        <span class="tableRowsInfo"
          >{{ invoice_detail_lists.from }}〜{{
            invoice_detail_lists.to
          }}
          件表示中／全：{{ invoice_detail_lists.total }}件</span
        >
        <span class="pagi">
          <advanced-laravel-vue-paginate
            :data="invoice_detail_lists"
            :onEachSide="2"
            previousText="<"
            nextText=">"
            alignment="center"
            @paginateTo="invoice_details"
          />
        </span>
        <span class="selectPagi">
          <select
            class="form-control selectPage"
            @change="invoice_details"
            v-model="form.select_field_per_page_num"
          >
            <!--<option value="0">表示行数</option>
                  <option v-for="n in order_detail_lists.last_page" :key="n"
                :value="n">{{n}}</option>-->
            <option value="10">10行</option>
            <option value="20">20行</option>
            <option value="50">50行</option>
            <option value="100">100行</option>
          </select>
        </span>
      </p>
      <div class="">
        <table
          class="table table-striped table-bordered order_item_details_table"
          style="overflow-x: scroll"
        >
          <thead>
            <tr>
              <th>No</th>
              <th><input type="checkbox" class="form-control" @click="checkAll" v-model="isCheckAll" /> 全選択</th>
              <th>締日</th>
              <th>計上日</th>
              <th>計上先</th>
              <th>伝票番号</th>
              <th>請求金額</th>
              <th>伝票区分</th>
              <th>請求区分</th>
              <th>送信日時</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(value, index) in invoice_detail_lists.data"
              :key="index"
            >
              <td>{{ index + 1 }}</td>
              <td><input type="checkbox" class="form-control" /></td>
              <td>{{ value.mes_lis_inv_per_end_date }}</td>
              <td>
                {{ value.mes_lis_inv_lin_det_transfer_of_ownership_date }}
              </td>
              <td>
                {{ value.mes_lis_inv_lin_tra_code }}
                {{ value.mes_lis_inv_lin_tra_name }}
              </td>
              <td>{{ value.mes_lis_inv_lin_lin_trade_number_reference }}</td>
              <td>{{ value.mes_lis_inv_lin_det_amo_requested_amount }}</td>
              <td>{{ value.mes_lis_inv_lin_det_pay_code }}</td>
              <td>{{ value.mes_lis_inv_lin_det_balance_carried_code }}</td>
              <td>{{ value.send_datetime }}</td>
              <!-- <td><router-link :to="{name:'voucher_detail',params:{voucher_number:value.voucher_number} }" class="btn btn-info">詳細</router-link></td> -->
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-12">
        <div class="row">
          <div class="col-6">
            <div class="pcontent">
              <p>
                ファイルを選択し「アップロード」ボタンをクリックすると、確定済みデータとしてアップロードされます。
              </p>
            </div>
            <div class="pcontentBtom">
              <label for="updateordershipmentcsv" class="custom-file-upload">
                <b-icon
                  icon="upload"
                  animation="fade"
                  font-scale="1.2"
                ></b-icon>
                アップロード
              </label>
              <input
                type="file"
                @change="invoiceUpdate"
                id="updateordershipmentcsv"
                class="form-control uploadBtn"
                style="display: none"
              />
              <!-- <button class="btn btn-primary active" type="button">
                <b-icon
                  icon="upload"
                  animation="fade"
                  font-scale="1.2"
                ></b-icon>
                アップロード
              </button>-->
            </div>
          </div>
          <div class="col-6 text-right">
            <!-- <button
              @click="updateDatetimeDecessionfield"
              class="btn btn-lg btn-primary active"
            >
              選択行を伝票確定
            </button> -->
            <button
              class="btn btn-lg btn-danger active"
              @click="sendInvoiceData"
            >
              確定データ送信
            </button>
          </div>
        </div>
      </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      invoice_detail_lists: {},
      byr_voucher_lists: {},
      file: "",
      data_invoice_id: "",
      isCheckAll: false,
      form: new Form({
        data_invoice_id: "",
        select_field_per_page_num: 10,
        page: 1,
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        submit_type: "page_load",
      }),
    };
  },
  beforeCreate: function () {
    if (!this.$session.exists()) {
      this.$router.push("/home");
    }
  },
  methods: {
    //get Table data
    invoice_details(page = 1) {
        this.form.page=page;
      axios.post(this.BASE_URL + "api/get_invoice_details_list", this.form)
        .then(({ data }) => {
            this.init(data.status);
          this.invoice_detail_lists = data.invoice_details_list;
        });
    },
    checkAll() {
      this.isCheckAll = !this.isCheckAll;
    },
    sendInvoiceData() {
      var _this = this;
      this.alert_icon = "warning";
      this.alert_title = "";
      this.yes_btn = "はい";
      this.cancel_btn = "キャンセル";
      axios.post(this.BASE_URL + "api/send_invoice_data", {
          data_invoice_id: this.form.data_invoice_id,
        //   order_info: this.order_info,
          data_count: true,
        }).then(({ data }) => {
            this.init(data.status);
          let csv_data_count = data.csv_data_count;
          if (csv_data_count > 0) {
            _this.alert_text = csv_data_count + "件の伝票を送信しますがよろしいでしょうか。";
            this.confirm_sweet().then((result) => {
              if (result.value) {
                axios.post(this.BASE_URL + "api/send_invoice_data", {
                    data_invoice_id: this.form.data_invoice_id,
                    // order_info: this.order_info,
                    data_count: false,
                  })
                  .then(({ data }) => {
                      this.init(data.status);
                    _this.alert_icon = "success";
                    _this.alert_title = "";
                    _this.alert_text =
                      data.csv_data_count + "件の確定伝票を送信しました。";
                    _this.sweet_normal_alert();
                    Fire.$emit("LoadByrorderDetail",_this.select_field_page_num);
                  });
              }
            });
          } else {
            _this.alert_text = "対象となる伝票がありません、再度確認して実行してください。";
            _this.sweet_normal_alert();
          }
        });
    },
    invoiceUpdate(){

    }
    // check_byr_order_api(){
    //    let formData = new FormData();
    // formData.append("up_file", this.file);
    // formData.append("email", 'user@jacos.co.jp');
    // formData.append("password", 'Qe75ymSr');
    //     axios({
    // method: 'POST',
    // url: this.BASE_URL + "api/job_exec/1",
    // data: formData,
    // headers: {'Content-Type': 'multipart/form-data' }
    // })
    // .then(function (response) {
    //     //handle success
    //     console.log(response);
    //    Fire.$emit('LoadByrorder');
    // })
    // .catch(function (response) {
    //     //handle error
    //     console.log(response);
    // });
    // },
    // onChangeFileUpload(){
    //     this.file = this.$refs.file.files[0];
    //     this.check_byr_order_api();
    //   },

    //   selectedOption_shop(option) {
    //   if (this.value) {
    //     return option.byr_shop_id === this.value.byr_shop_id;
    //   }
    //   return false;
    // },
    //   selectedOption_voucher(option) {
    //   if (this.value) {
    //     return option.voucher_number === this.value.voucher_number;
    //   }
    //   return false;
    // },
    // change(e) {
    //   const selectedCode = e.target.value;
    //   const option = this.options.find((option) => {
    //     return selectedCode === option.byr_buyer_id;
    //   });
    // //   this.$emit("input", option);
    // }
  },

  created() {
    Fire.$emit("byr_has_selected", this.$session.get("byr_buyer_id"));
    Fire.$emit("permission_check_for_buyer", this.$session.get("byr_buyer_id"));
    this.form.data_invoice_id = this.$route.params.data_invoice_id;
    this.invoice_details();
    Fire.$on("LoadByrinvoice_detail", () => {
      this.invoice_details();
    });
  },
  computed: {

  },
  mounted() {
  },
};
</script>
