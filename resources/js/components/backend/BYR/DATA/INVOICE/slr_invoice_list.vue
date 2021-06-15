<template>
  <div class="row">
    <div class="col-12">
    <div class="col-12" style="background: #d8e3f0; padding: 10px">
     <table
          class="table orderDetailTable cmnWidthTable table-bordered"
          style="width: 100%"
        >
          <tr>
          <td class="cl_custom_color">締日</td>
            <td>
                <div class="input-group">
                    <input type="date" class="form-control" v-model="form.mes_lis_inv_per_begin_date">
                    <div class="input-group-prepend">
                        <span class="input-group-text">~</span>
                    </div>
                    <input type="date" class="form-control" v-model="form.mes_lis_inv_per_end_date">
                </div>
        </td>
            <td class="cl_custom_color">取引先コード</td>
            <td><input type="text" class="form-control topHeaderInputFieldBtn" v-model="form.mes_lis_inv_pay_code">
            <button @click="showAllCustomerCode" class="btn btn-primary active">
                参照
            </button>
            </td>

            <!-- <td class="cl_custom_color">請求書番号</td>
            <td>
            <input type="text" class="form-control" v-model="form.mes_lis_inv_pay_id">
            </td> -->

          </tr>
          <tr>
          <!--
            <td class="cl_custom_color">請求状況</td>
            <td colspan="5">
                <select class="form-control" v-model="form.send_datetime_status">
                <option value="*">全て</option>
                <option :value="item" v-for="(item,i) in send_datetime_status" :key="i">
                  {{ item }}
                </option>
              </select>
            </td>-->
             <td class="cl_custom_color">確定状況</td>
          <td>
            <select class="form-control" v-model="form.decission_cnt">
              <option
                v-for="(dcnt, i) in decission_cnt"
                :key="i"
                :value="Object.keys(dcnt)[0]"
              >
                {{ Object.values(dcnt)[0] }}
              </option>
            </select>
          </td>
          <!-- <td>{{ myLang.confirmation_status }}</td> -->
          <!-- <td class="cl_custom_color">印刷状況</td> -->
          <td class="cl_custom_color">送信状況</td>
          <td>
            <select class="form-control" v-model="form.send_cnt">
             <option
                v-for="(dcnt, i) in send_cnt"
                :key="i"
                :value="Object.keys(dcnt)[0]"
              >
                {{ Object.values(dcnt)[0] }}
              </option>
            </select>
          </td>
          </tr>
        </table>
    </div>
    </div>
    <div class="col-12 text-center">
      <button class="btn btn-primary active srchBtn" type="button" @click="get_all_invoice_list">
          {{ myLang.search }}
        </button>
    </div>
    <div class="col-12">
        <br />
        <h4 class="page_custom_title">{{ myLang.search_result }}</h4>
      </div>
        <div class="col-12 text-center">
         <button class="btn btn-outline-primary" type="button" :disabled="is_disabled(invoice_lists_length>=1?true:false)" @click="invoice_download(1)">
        <b-icon icon="download" animation="fade" font-scale="1.2"></b-icon>
        {{ myLang.download }}
      </button>
    </div>
    <div class="col-12">
            <p>
              <span class="tableRowsInfo">{{ invoice_lists.from }}〜{{ invoice_lists.to }} 件表示中／全：{{ invoice_lists.total }}件</span>
              <span class="pagi"
                >
              <advanced-laravel-vue-paginate :data="invoice_lists"
              :onEachSide="2"
              previousText="<"
              nextText=">"
              alignment="center"
                @paginateTo="get_all_invoice_list"/>
              </span>
              <span class="selectPagi">
                <select class="form-control selectPage" @change="get_all_invoice_list"
                  v-model="form.select_field_per_page_num" >
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
            <button @click="viewInvoicePopup" class="btn btn-primary " style="float:right;">新規請求</button>


            <button class="btn btn-primary" @click="runInvoiceSchedular" style="float:right;margin-right:10px;">締め処理実行</button>
      <div class="">
        <table
            class="table table-striped table-bordered order_item_details_table"
            style="overflow-x: scroll"
          >
          <thead>

            <tr>
              <th>No</th>
              <th class="pointer_class" @click="sorting('mes_lis_inv_per_end_date')">締日 <span class="float-right" :class="iconSet('mes_lis_inv_per_end_date')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_inv_pay_code')">取引先コード <span class="float-right" :class="iconSet('mes_lis_inv_pay_code')"></span></th>
              <th class="pointer_class">伝票　総数</th>
              <th class="pointer_class">未確定　伝票数</th>
              <th class="pointer_class">未送信　伝票数</th>
              <!-- <th class="pointer_class" @click="sorting('mes_lis_inv_pay_id')">請求書番号 <span class="float-right" :class="iconSet('mes_lis_inv_pay_id')"></span></th> -->
              <!-- <th class="pointer_class" @click="sorting('status')">請求状況 <span class="float-right" :class="iconSet('status')"></span></th> -->
              <th class="pointer_class" @click="sorting('mes_lis_inv_lin_det_amo_requested_amount')">請求金額 <span class="float-right" :class="iconSet('mes_lis_inv_lin_det_amo_requested_amount')"></span></th>
            </tr>
          </thead>
          <tbody>
              <!-- {{ i=invoice_lists.from }} -->
            <tr v-for="(value, index) in invoice_lists.data" :key="index">
              <td>{{ invoice_lists.current_page * form.select_field_per_page_num - form.select_field_per_page_num + index + 1 }}</td>
              <td>
                  <router-link
                  :to="{
                    name: 'slr_invoice_details',
                    query: {
                      data_invoice_id: value.data_invoice_id,
                      end_date: value.mes_lis_inv_per_end_date.valueOf(),
                      pay_code: value.mes_lis_inv_pay_code,
                      pay_name: value.mes_lis_inv_pay_name,
                      buy_code: value.mes_lis_buy_code,
                      buy_name: value.mes_lis_buy_name,
                      requested_amount: value.total_amount,
                    },
                  }" class="">{{ value.mes_lis_inv_per_end_date }}</router-link>
                <!-- <router-link :to="{ name: 'invoice_detail', params: { data_invoice_id: value.data_invoice_id }, }" class="btn btn-info">{{ value.mes_lis_inv_per_end_date }}</router-link> -->
              </td>
              <td>{{ value.mes_lis_inv_pay_code }}</td>
              <td>{{ value.cnt }}</td>
              <td>{{ value.decision_cnt }}</td>
              <td>{{ value.send_cnt }}</td>
              <!-- <td>{{ value.mes_lis_inv_pay_id }}</td> -->
              <!-- <td>{{ value.status }}</td> -->
              <td class="text-right">{{value.total_amount | priceFormat }}</td>

            </tr>
            <tr v-if="invoice_lists.data && invoice_lists.data.length==0">
            <td class="text-center" colspan="100%">データがありません</td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>


<b-modal
      size="lg"
      :hide-backdrop="true"
      title="新規請求作成"
      ok-title="登録"
      cancel-title="閉じる"
      @ok.prevent="insertInvoice()"
      v-model="invoiceCreateModal"
    >
      <div class="panel-body">
      <p v-if="errors.length">
        <b>次の間違いを正しくしてください:</b>
        <ul>
          <li style="color:red;" v-for="error in errors">{{ error }}</li>
        </ul>
      </p>
        <table
          class="table orderDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">取引先コード</td>
            <td>
                <select class="form-control" v-model="invoiceData.mes_lis_inv_pay_code">
                    <option v-for="(partner_code,i) in partner_codes" :value="partner_code.partner_code" :key="i">{{ partner_code.partner_code }}</option>
                </select>
            </td>
            <!-- <td><input type="text" v-model="invoiceData.mes_lis_inv_pay_code" class="form-control" /></td> -->
            <td class="cl_custom_color">締日</td>
            <td>
                <div class="input-group">

                    <input type="date" v-model="invoiceData.mes_lis_inv_per_begin_date" class="form-control">
                    <div class="input-group-prepend">
                        <span class="input-group-text">~</span>
                    </div>
                    <input type="date" v-model="invoiceData.mes_lis_inv_per_end_date" class="form-control">
                </div>
            </td>
          </tr>
          <!-- <tr>
            <td class="cl_custom_color">請求書番号</td>
            <td colspan="3"><input type="text" v-model="invoiceData.mes_lis_inv_pay_id" class="form-control" /></td>

          </tr> -->

        </table>
      </div>
    </b-modal>

<b-modal
      size="lg"
      :hide-backdrop="true"
      title="取引先コード一覧"
      cancel-title="閉じる"
      v-model="showAllCustomerCodeListModal"
      :hide-footer="true"
    >
      <div class="panel-body add_item_body">

          <div class="row">
  <table class="table table-striped order_item_details_table table-bordered data_table">
          <thead>
            <tr>
              <th style="cursor: pointer">No</th>
              <th>取引先コード</th>
              <th>取引先名</th>
              <th>請求先コード</th>
              <th>請求取引先名</th>
              <th>取引先形態区分</th>

            </tr>
          </thead>
          <tbody>
          <tr v-for="(value,index) in order_customer_code_lists" @click="onRowClicked(value)" :key="index">
          <td>{{index+1}}</td>
          <td>{{value.mes_lis_inv_pay_code}}</td>
          <td>{{value.mes_lis_inv_pay_name}}</td>
          <td>{{value.mes_lis_buy_code}}</td>
          <td>{{value.mes_lis_buy_code}}</td>

          <td></td>
          </tr>
          </tbody>
          </table>





          </div>
      </div>
    </b-modal>

  </div>
</template>
<script>
export default {
  data() {
    return {
      invoice_lists: {},
      invoice_lists_length:0,
      invoice_data_lists:[],
      errors:[],
      byr_buyer_lists: {},
      invoiceCreateModal:false,
      order_customer_code_lists: {},
      showAllCustomerCodeListModal:false,
      send_cnt: [{ "*": "全て" }, { "!0": "未送信あり" }, { 0: "送信済" }],
      decission_cnt: [{ "*": "全て" }, { "!0": "未確定あり" }, { 0: "確定済" }],
      partner_codes:[],
      file: "",
      selected_byr: "0",
      invoiceData:{
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        // mes_lis_inv_pay_id:'',
        mes_lis_inv_pay_code:'',
        mes_lis_inv_per_begin_date:'',
        mes_lis_inv_per_end_date:'',
      },
      send_datetime_status: ["未請求", "請求済","再請求あり"],
      form: new Form({
        select_field_per_page_num:10,
        page:1,
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        mes_lis_inv_pay_code: '',
        send_cnt:'*',
        decission_cnt:'*',
        // mes_lis_inv_pay_id: '',
        mes_lis_inv_per_begin_date:'',
        mes_lis_inv_per_end_date:'',
        send_datetime_status: "*",
        sort_by:'mes_lis_inv_per_end_date ',
        sort_type:"DESC",
        page_title:'invoice_list',
        downloadType:1
      }),
    };
  },
  // beforeCreate: function() {
  //           if (!this.$session.exists()) {
  //               this.$router.push('/home');
  //           }
  //       },
  methods: {
    onRowClicked (item) {
        this.form.mes_lis_inv_pay_code = item.mes_lis_inv_pay_code;
       this.showAllCustomerCodeListModal = false;
    },
    //get Table data
    showAllCustomerCode(){
    let loaders = Vue.$loading.show();
      this.showAllCustomerCodeListModal = true;
      this.form.post(this.BASE_URL + "api/get_invoice_customer_code_list", this.form)
        .then(({ data }) => {
          this.order_customer_code_lists = data.order_customer_code_lists;
          loaders.hide();
        });
    },
    viewInvoicePopup(){
      this.invoiceCreateModal = true;
      this.invoiceData.mes_lis_inv_pay_code=this.partner_codes[0].partner_code;
    },

    //get Table data
    get_all_invoice_list(page = 1) {
        this.form.page=page;
         let loader = Vue.$loading.show();
      axios.post(this.BASE_URL + "api/slr_get_all_invoice_list",this.form)
        .then(({data}) => {
          this.invoice_lists = data.invoice_list;
          this.invoice_lists_length=this.invoice_lists.data.length;
          this.invoice_data_lists = data.invoice_list.data;
          this.byr_buyer_lists = data.byr_buyer_list;
          this.partner_codes = data.partner_codes;
          loader.hide();
        });
    },
    sorting(sorted_field){
          this.form.sort_by=sorted_field;
          this.form.sort_type=this.form.sort_type=="ASC"?"DESC":"ASC";
          this.get_all_invoice_list();

      },
      invoice_download(downloadType = 1) {
      //downloadcsvshipment_confirm
      this.form.downloadType=downloadType
      axios.post(this.BASE_URL + "api/download_invoice", this.form)
        .then(({ data }) => {
           this.init(data.status);
           this.downloadFromUrl(data);
        });
    },
      runInvoiceSchedular() {
            var _this = this;
            this.alert_icon = "warning";
            this.alert_title = "";
            this.alert_text = "締め処理を実行しますが、よろしいでしょうか？";
            this.yes_btn = "はい";
            this.cancel_btn = "キャンセル";
            this.confirm_sweet().then((result) => {
                if (result.value) {
                    axios.post(this.BASE_URL + "api/exec_invoice_schedular", this.form)
                    .then(({ data }) => {
                        // console.log(data);
                        if (data.status==1) {
                            Fire.$emit("LoadByrinvoice");
                            _this.alert_title = "完了";
                            if (data.data.total_success_data==0) {
                                _this.alert_text ='請求対象データがありません';
                            }else{
                                _this.alert_text =data.data.total_success_data+' 伝票を締め処理しました';
                            }
                        }else{
                            _this.alert_text =data.message;
                            _this.alert_title = "Error";
                        }
                        _this.alert_icon = data.data.class;
                        _this.sweet_normal_alert();
                    });
                }
            })
    },
    checkForm: function (e) {
      this.errors = [];
        if(this.invoiceData.mes_lis_inv_pay_code==''){this.errors.push("取引先コード フィールドは必須項目です")}
        if(this.invoiceData.mes_lis_inv_per_begin_date==''){this.errors.push("開始日 フィールドは必須項目です")}
        if(!this.invoiceData.mes_lis_inv_per_end_date){this.errors.push("終了日 フィールドは必須項目です")}

      if (!this.errors.length) {
        return true;
      }
      return false;
    },
    insertInvoice() {
      var _this = this;
      if(this.checkForm()){
      axios
        .post(this.BASE_URL + "api/invoiceInsert",this.invoiceData)
        .then(({data}) => {
         Fire.$emit("LoadByrinvoice");
         _this.alert_icon = "success";
        _this.alert_title = "";
        _this.alert_text =
          "請求データを追加しました。";
        _this.sweet_normal_alert();
        _this.invoiceCreateModal = false;
        });
      }
    },
    // check_byr_order_api() {
    //   let formData = new FormData();
    //   formData.append("up_file", this.file);
    //   formData.append("email", "user@jacos.co.jp");
    //   formData.append("password", "Qe75ymSr");
    //   axios({
    //     method: "POST",
    //     url: this.BASE_URL + "api/job_exec/1",
    //     data: formData,
    //     headers: { "Content-Type": "multipart/form-data" },
    //   })
    //     .then(({data})=> {
    //       Fire.$emit("LoadByrorder");
    //     })
    //     .catch(function (response) {
    //     });
    // },
    // onChangeFileUpload() {
    //   this.file = this.$refs.file.files[0];
    //   this.check_byr_order_api();
    // },

    change(e) {
      const selectedCode = e.target.value;
      const option = this.options.find((option) => {
        return selectedCode === option.byr_buyer_id;
      });
      //   this.$emit("input", option);
    },
  },

  created() {
    Fire.$emit("byr_has_selected", this.$session.get("byr_buyer_id"));
    Fire.$emit("permission_check_for_buyer", this.$session.get("byr_buyer_id"));
    this.invoiceData.byr_buyer_id = this.$session.get("byr_buyer_id");
    this.form.byr_buyer_id = this.$session.get("byr_buyer_id");
    this.get_all_invoice_list();
    Fire.$on("LoadByrinvoice", () => {
      this.get_all_invoice_list();
    });
    Fire.$emit("loadPageTitle", "請求データ一覧");
  },
  mounted() {
  },
   computed: {

    // totalRequestedAmount: function() {
    //   return this.invoice_data_lists.reduce(function (sumAmout,val) {return  sumAmout += parseInt(val.mes_lis_inv_lin_det_amo_requested_amount)},0);

    // },
  },
};
</script>
