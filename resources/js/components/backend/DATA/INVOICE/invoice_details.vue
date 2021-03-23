<template>
  <div class="row">
  <div class="col-12">
    <div class="col-12" style="background: #d8e3f0;padding: 10px;margin-bottom:20px;">
        <table
          class="table orderDetailTable cmnWidthTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">締日</td>
            <td>{{ param_data.end_date }}</td>
            <td class="cl_custom_color">請求取引先</td>
            <td colspan="5">
              {{ param_data.pay_code }}
              {{ param_data.pay_name }}
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">発注者</td>
            <td>
                {{ param_data.buy_code }}
                {{ param_data.buy_name }}
            </td>
            <td class="cl_custom_color">請求状況</td>
            <td>
                {{ param_data.status }}
            </td>
            <td class="cl_custom_color">請求金額</td>
            <td class="text-right">
                {{ number_format(param_data.requested_amount) }}
            </td>
          </tr>
        </table>
      </div>
      </div>
      
      <div class="col-12">
      <div class="col-12" style="background: #d8e3f0; padding: 10px">
        <table
          class="table orderDetailTable cmnWidthTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">計上日</td>
            <td>
            <div class="input-group">

      <input type="date" class="form-control" v-model="form.from_date">
      <div class="input-group-prepend">
        <span class="input-group-text">~</span>
      </div>
      <input type="date" class="form-control" v-model="form.to_date">
    </div>
            </td>

           <td class="cl_custom_color">部門</td>
          <td>
            <multiselect v-model="form.category_code" :options="byr_buyer_category_lists" label="category_name" track-by="category_code" :searchable="true" :close-on-select="true" :clear-on-select="true" :select-label="''" :deselect-label="''" :selected-label="'選択中'" :preserve-search="true"  placeholder="部門"></multiselect>
          </td>

            <td class="cl_custom_color">計上先</td>
            <!-- @click="deliverySearchForm2" -->
            <td>
              <input type="text" class="form-control topHeaderInputFieldBtn" v-model="form.mes_lis_inv_lin_tra_code" />
              <button class="btn btn-primary active" style="float:left;">
                参照
              </button>
            </td>
          </tr>
          <tr>
           <td class="cl_custom_color">伝票番号</td>
            <td>
              <input type="text" v-model="form.mes_lis_inv_lin_lin_trade_number_reference" class="form-control" />
            </td>
            <td class="cl_custom_color">確定状況</td>
            <td>
              <select class="form-control" v-model="form.decision_datetime_status">
                <option value="*">全て</option>
                <option :value="item" v-for="(item,i) in decision_datetime_status" :key="i">
                  {{ item }}
                </option>
              </select>
            </td>
            <td class="cl_custom_color">送信状況</td>
            <!-- v-model="form.fixedSpecial"send_datetime_status -->
            <td>
              <select class="form-control" v-model="form.send_datetime_status">
                <option value="*">全て</option>
                <option :value="item" v-for="(item,i) in send_datetime_status" :key="i">
                  {{ item }}
                </option>
              </select>
            </td>
          </tr>

        </table>
      </div>
      </div>
      <div class="col-12" style="text-align: center">
        <button class="btn btn-primary active srchBtn" type="button" @click="invoice_details">
          {{ myLang.search }}
        </button>
      </div>
      <div class="col-12">
        <br />
        <h4 class="page_custom_title">{{ myLang.search_result }}</h4>
      </div>

    <div class="col-12">
        <div class="row">
          <div class="col-5">
      <p>
        <span class="tableRowsInfo">{{ invoice_detail_lists.from }}〜{{ invoice_detail_lists.to }} 件表示中／全：{{ invoice_detail_lists.total }}件</span>
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
          </div>
      <div class="col-7">
          <div class="row">
              <div class="col-4" style="padding-left: 0 !important">
                <p class="mb-0">検索結果のダウンロードはこちら</p>
                <!--<b-button
                  class="active"
                  variant="primary"
                  v-on:click="order_download"
                >
                  <b-icon
                    icon="download"
                    animation="fade"
                    font-scale="1.2"
                  ></b-icon>
                  ダウンロード</b-button>-->

                <div class="btn-group">
                  <button
                    type="button"
                    class="btn btn-primary active dropdown-toggle"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <b-icon
                      icon="download"
                      animation="fade"
                      font-scale="1.2"
                    ></b-icon>
                    ダウンロード
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item" @click="invoice_download(1)" type="button"> CSV </button>
                    <!-- <button class="dropdown-item" @click="order_download(2)" type="button"> JCA </button> -->
                  </div>
                </div>
              </div>
              <div class="col-3">
                <!--<p class="mb-0">商品別の更新はこちら</p>
                <router-link
                  to="/order_list/order_list_details/item_search"
                  class="active btn btn-primary"
                >
                  商品別登録</router-link
                >-->
              </div>
              <div class="col-5">
                <!--<b-form inline>
                  <label class="sr-only" for="inline-form-input-name"
                    >各種帳票の印刷はこちら</label
                  >
                  <select class="mb-2 mr-sm-2 mb-sm-0 form-control">
                    <option>選択してください</option>
                  </select>
                 
                </b-form>-->
                 <b-button class="active text-right pull-right" @click="addInvoiceDetail" variant="primary">新規伝票追加</b-button>
              </div>
          </div>
      </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-12">
            <table
          class="table table-striped table-bordered order_item_details_table"
          style="overflow-x: scroll"
        >
          <thead>
              <tr class="first_heading_th">
                <th></th>
                <th>
                  <input
                    @click="checkAll"
                    v-model="isCheckAll"
                    type="checkbox"
                  /> 全選択
                </th>
                <th colspan="9"></th>
              </tr>
            <tr>
              <th>No</th>
              <th>請求</th>
              <th class="pointer_class" @click="sorting('mes_lis_inv_lin_det_transfer_of_ownership_date')">計上日 <span class="float-right" :class="iconSet('mes_lis_inv_lin_det_transfer_of_ownership_date')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_inv_lin_det_goo_major_category')">部門コード <span class="float-right" :class="iconSet('mes_lis_inv_lin_det_goo_major_category')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_inv_lin_tra_code')">納品先 <span class="float-right" :class="iconSet('mes_lis_inv_lin_tra_code')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_inv_lin_lin_trade_number_reference')">伝票番号 <span class="float-right" :class="iconSet('mes_lis_inv_lin_lin_trade_number_reference')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_inv_lin_det_pay_code')">請求内容 <span class="float-right" :class="iconSet('mes_lis_inv_lin_det_pay_code')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_inv_lin_det_balance_carried_code')">請求区分 <span class="float-right" :class="iconSet('mes_lis_inv_lin_det_balance_carried_code')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_inv_lin_det_amo_requested_amount')">請求金額 <span class="float-right" :class="iconSet('mes_lis_inv_lin_det_amo_requested_amount')"></span></th>
              <th class="pointer_class" @click="sorting('send_datetime')">送信日時 <span class="float-right" :class="iconSet('send_datetime')"></span></th>
            <th>詳細</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(value, index) in invoice_detail_lists.data"
              :key="index"
            >
              <td>
                  <!-- {{ index + 1 }} -->
                  {{ invoice_detail_lists.current_page * form.select_field_per_page_num - form.select_field_per_page_num + index +1 }}
             </td>
              <!-- <td><input type="checkbox" class="form-control" /></td> -->
              <!-- <td>{{ value.mes_lis_inv_per_end_date }}</td> -->
              <td>
                  <span v-if="value.decision_datetime != null">
                    <b-button
                      pill
                      variant="info"
                      @click="
                        decissionDateUpdate(
                          value.data_invoice_pay_detail_id
                        )
                      "
                      >済</b-button
                    >
                  </span>
                  <span v-else>
                    <input
                      type="checkbox"
                      v-bind:value="value.data_invoice_pay_detail_id"
                      v-model="selected"
                      @change="updateCheckall()"
                    />
                  </span>
                </td>
              <td>
                {{ value.mes_lis_inv_lin_det_transfer_of_ownership_date }}
              </td>
              <td>
                {{ value.mes_lis_inv_lin_det_goo_major_category }}
              </td>
              <td>
                {{ value.mes_lis_inv_lin_tra_code }} {{value.mes_lis_inv_lin_tra_name}}
                <!-- {{ value.mes_lis_inv_lin_tra_name }} -->
              </td>
              <td>{{ value.mes_lis_inv_lin_lin_trade_number_reference }}</td>
              <td>{{ value.mes_lis_inv_lin_det_pay_code }}</td>
              <td>{{ value.mes_lis_inv_lin_det_balance_carried_code }}</td>
              <td class="text-right">{{ number_format(value.mes_lis_inv_lin_det_amo_requested_amount) }}</td>
              <td>{{ value.send_datetime }}</td>
              <td><button @click="editInvoiceDetail(value)" class="btn btn-primary">Edit</button><button @click="deleteInvoiceDetail(value)" class="btn btn-danger">Delete</button></td>
            </tr>
            <tr v-if="invoice_detail_lists.data && invoice_detail_lists.data.length==0">
                <td class="text-center" colspan="100%">データがありません</td>
            </tr>
          </tbody>
        </table>
        </div>
    </div>
    </div>

    <!-- <div class="col-12">

    </div> -->
    <div class="col-12">
        <div class="row">
          <div class="col-6">
            <div class="pcontent">
              <p>
                ファイルを選択し「アップロード」ボタンをクリックすると、確定済みデータとしてアップロードされます。
              </p>
            </div>
            <div class="pcontentBtom">
              <label for="updateordershipmentcsv" class="btn btn-primary active">
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
                class="btn btn-primary active"
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
            <button class="btn btn-lg btn-primary active" @click="updateDatetimeDecessionfield">
              選択行を伝票確定
            </button>
            <button
              class="btn btn-lg btn-danger active"
              @click="sendInvoiceData"
            >
              確定データ送信
            </button>
          </div>
        </div>
      </div>
      <b-modal
      size="lg"
      :hide-backdrop="true"
      title="請求伝票追加"
      ok-title="追加"
      cancel-title="キャンセル"
      @ok.prevent="update_invoice_detail()"
      v-model="editInvoiceDetailModal"
    >
      <div class="panel-body add_item_body">
        <form>
          <p class="text-center">新規請求伝票を追加できます</p>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">計上日</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" v-model="invoiceDetail.mes_lis_inv_lin_det_transfer_of_ownership_date">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">部門コード</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" v-model="invoiceDetail.mes_lis_inv_lin_det_goo_major_category">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">納品先コード</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" v-model="invoiceDetail.mes_lis_inv_lin_tra_code">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">伝票番号</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" v-model="invoiceDetail.mes_lis_inv_lin_lin_trade_number_reference">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">請求内容</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" v-model="invoiceDetail.mes_lis_inv_lin_det_pay_code">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">請求区分</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" v-model="invoiceDetail.mes_lis_inv_lin_det_balance_carried_code">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">請求金額</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" v-model="invoiceDetail.mes_lis_inv_lin_det_amo_requested_amount">
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
      param_data: [],
      invoice_detail_lists: {},
      byr_voucher_lists: {},
      byr_buyer_category_lists:[],
      editInvoiceDetailModal:false,
      file: "",
      data_invoice_id: "",
      isCheckAll: false,
      selected: [],
      null_selected: [],
      not_null_selected: [],
      date_null:false,
      null_selected_message:false,
      decision_datetime_status: ["未確定あり", "確定済"],
      send_datetime_status: ["未確定あり", "確定済"],
      invoiceDetail:{
        mes_lis_inv_lin_det_transfer_of_ownership_date:'',
        mes_lis_inv_lin_det_transfer_of_ownership_date:'',
        mes_lis_inv_lin_det_goo_major_category:'',
        mes_lis_inv_lin_tra_code:'',
        mes_lis_inv_lin_lin_trade_number_reference:'',
        mes_lis_inv_lin_det_pay_code:'',
        mes_lis_inv_lin_det_balance_carried_code:'',
        mes_lis_inv_lin_det_amo_requested_amount:'',
      },
      form: new Form({
        data_invoice_id: "",
        select_field_per_page_num: 10,
        page: 1,
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        submit_type: "page_load",
        from_date:'',
        to_date:'',
        mes_lis_inv_lin_tra_code:'',
        mes_lis_inv_lin_lin_trade_number_reference:'',
        decision_datetime_status:'*',
        category_code:{category_code:'*',category_name:'全て'},
        send_datetime_status:'*',
        sort_by:'data_invoice_pay_detail_id ',
        sort_type:"ASC",
      }),
    };
  },
  beforeCreate: function () {
    if (!this.$session.exists()) {
      this.$router.push("/home");
    }
  },
  methods: {
    editInvoiceDetail(value){
      this.editInvoiceDetailModal = true;
      this.invoiceDetail = value;
      // this.invoiceDetail.fill(value)
    },
    addInvoiceDetail(value){
      this.editInvoiceDetailModal = true;
      this.invoiceDetail={};
    },
    //get Table data
    invoice_details(page = 1) {
        this.form.page=page;
      axios.post(this.BASE_URL + "api/get_invoice_details_list", this.form)
        .then(({ data }) => {
            this.init(data.status);
            this.invoice_detail_lists = data.invoice_details_list;
                      this.byr_buyer_category_lists = data.byr_buyer_category_list;
          this.byr_buyer_category_lists.unshift({category_code:'*',category_name:'全て'});

        });
    },
    sorting(sorted_field){
          this.form.sort_by=sorted_field;
          this.form.sort_type=this.form.sort_type=="ASC"?"DESC":"ASC";
          this.invoice_details();

      },
    checkAll() {
      this.isCheckAll = !this.isCheckAll;
      this.selected = [];
      this.null_selected = [];
      this.not_null_selected = [];
      if (this.isCheckAll) {
        for (var key in this.invoice_detail_lists.data) {
          if (this.invoice_detail_lists.data[key].decision_datetime) {
            this.not_null_selected.push(
              this.invoice_detail_lists.data[key].data_invoice_pay_detail_id
            );
          } else {
            this.null_selected.push(
              this.invoice_detail_lists.data[key].data_invoice_pay_detail_id
            );
          }
        }
      }

        // console.log(this.form.select_field_per_page_num);
        // console.log(this.null_selected);
        // console.log(this.not_null_selected);
      if (this.null_selected.length <= this.form.select_field_per_page_num && this.null_selected.length != 0) {
        this.date_null = false;
        this.selected = this.null_selected;
        this.null_selected_message = true;
      } else if (this.not_null_selected.length <= this.form.select_field_per_page_num && this.not_null_selected.length != 0) {
        this.date_null = true;
        this.selected = this.not_null_selected;
        this.null_selected_message = false;
      }
      //   console.log(this.selected);
    },
    updateCheckall() {
      // console.log(this.selected)
      if (this.selected.length == this.invoice_detail_lists.data.length) {
        this.isCheckAll = true;
      } else {
        this.isCheckAll = false;
      }
      this.null_selected = this.selected;
      this.null_selected_message = true;
      this.date_null = false;
    },
    decissionDateUpdate(data_invoice_pay_detail_id) {
      if (this.isCheckAll) {
        this.alert_text =
          "対象となる伝票確定を取消しますがよろしいでしょうか。";
        this.selected = this.null_selected.concat(this.not_null_selected);
      } else {
        this.selected.push(data_invoice_pay_detail_id);
        this.alert_text = "伝票確定を取消しますがよろしいでしょうか。";
      }
      this.date_null = true;
      this.null_selected_message = false;
      this.updateDecissionDateTime();
    },
    updateDecissionDateTime() {
      var _this = this;
      this.alert_icon = "warning";
      this.alert_title = "";
      this.yes_btn = "はい";
      this.cancel_btn = "キャンセル";
      this.selectedNum = this.selected.length;
      if (this.selectedNum > 0) {
        this.confirm_sweet().then((result) => {
          if (result.value) {
            // console.log(this.selected);
            //   return 0;
            axios.post(
                this.BASE_URL + "api/update_invoice_decession_datetime",
                { update_id: this.selected, date_null: this.date_null }
              )
              .then(({ data }) => {
                  this.init(data.status);
                _this.alert_icon = "success";
                _this.alert_title = "";
                _this.alert_text =
                  _this.selectedNum + "件の伝票を確定しました。";
                if (!this.null_selected_message) {
                  _this.alert_text = "伝票確定を取消しました。";
                }
                _this.sweet_normal_alert();
                this.invoice_details()
                // Fire.$emit("LoadByrorderDetail",_this.form.page);
                this.selected = [];
                // this.date_null = false;
                this.isCheckAll = false;
                this.null_selected_message = false;
              })
              .catch(function (response) {
                //handle error
                // console.log(response);
              });
          } else {
            this.selected = [];
            this.isCheckAll = false;
            this.null_selected_message = false;
          }
        });
      } else {
        this.null_selected_message = false;
        this.alert_text = "対象となる伝票がありません、再度確認して実行してください。";
        this.sweet_normal_alert();
      }
    },
    updateDatetimeDecessionfield() {
      if (this.null_selected.length > 0) {
        this.alert_text =
          this.selected.length + "件の伝票を確定しますがよろしいでしょうか。";
        this.updateDecissionDateTime();
      } else {
        this.alert_icon = "warning";
        this.alert_title = "";
        this.alert_text = "対象となる伝票がありません、再度確認して実行してください。";
        this.sweet_normal_alert();
      }
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
                    data_count: false,
                  })
                  .then(({ data }) => {
                      this.init(data.status);
                    _this.alert_icon = "success";
                    _this.alert_title = "";
                    _this.alert_text =
                      data.csv_data_count + "件の確定伝票を送信しました。";
                    _this.sweet_normal_alert();
                    Fire.$emit("LoadByrinvoiceDetails",_this.form.page);
                  });
              }
            });
          } else {
            _this.alert_text = "対象となる伝票がありません、再度確認して実行してください。";
            _this.sweet_normal_alert();
          }
        });
    },
    invoice_download(downloadType = 1) {
      //downloadcsvshipment_confirm
      var _this = this;
      axios.post(this.BASE_URL + "api/download_invoice", {
          data_invoice_id: this.form.data_invoice_id,
          downloadType: downloadType,
        })
        .then(({ data }) => {
           this.init(data.status);
           this.downloadFromUrl(data);
        });
    },
    invoiceUpdate(){

    }
  },

  created() {
    Fire.$emit("byr_has_selected", this.$session.get("byr_buyer_id"));
    Fire.$emit("permission_check_for_buyer", this.$session.get("byr_buyer_id"));
    this.param_data = this.$route.query;
    this.form.data_invoice_id = this.param_data.data_invoice_id;
    this.form.byr_buyer_id = this.$session.get("byr_buyer_id");
    this.invoice_details();
    Fire.$on("LoadByrinvoiceDetails", (page=1) => {
      this.invoice_details(page);
    });
    Fire.$emit('loadPageTitle','請求伝票一覧')
  },
  computed: {

  },
  mounted() {
  },
};
</script>
