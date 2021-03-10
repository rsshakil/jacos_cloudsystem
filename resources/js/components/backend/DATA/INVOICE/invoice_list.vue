<template>
  <div class="row">
    <div class="col-12">
     <table
          class="table orderTopDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">請求取引先コード</td>
            <td><input type="text" class="form-control"></td>
            <td class="cl_custom_color">請求日時</td>
            <td>
            <div class="input-group mb-3">

      <input type="date" class="form-control">
      <div class="input-group-prepend">
        <span class="input-group-text">~</span>
      </div>
      <input type="date" class="form-control">
    </div>
            </td>
            <td class="cl_custom_color">発注者</td>
            <td>
            <select class="form-control" style="width: 220px">
                <option value="">全て</option>

              </select>
            </td>

          </tr>
          <tr>
            <td class="cl_custom_color">締日</td>
            <td colspan="2"><div class="input-group mb-3">

      <input type="date" class="form-control">
      <div class="input-group-prepend">
        <span class="input-group-text">~</span>
      </div>
      <input type="date" class="form-control">
    </div> </td>
            <td class="cl_custom_color">請求状況</td>
            <td colspan="2">
            <select class="form-control" style="width: 220px">
                <option value="">全て</option>
                <option value="未請求">未請求</option>
                <option value="請求済">請求済</option>
                <option value="再請求あり">再請求あり</option>
              </select>
            </td>

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
      <div class="">
        <table
            class="table table-striped table-bordered order_item_details_table"
            style="overflow-x: scroll"
          >
          <thead>

            <tr>
              <th>No</th>
              <th>締日</th>
              <th>請求取引先コード</th>
              <th>発注者</th>
              <th>請求状況</th>
              <th>請求金額</th>
            </tr>
          </thead>
          <tbody>
              <!-- {{ i=invoice_lists.from }} -->
            <tr
              v-for="(value, index) in invoice_lists.data"
              :key="index"
            >
              <td>{{ (index+1) }}</td>
              <td>
                  <router-link
                  :to="{
                    name: 'invoice_details',
                    query: {
                      data_invoice_id: value.data_invoice_id,
                      end_date: value.mes_lis_inv_per_end_date.valueOf(),
                      pay_code: value.mes_lis_inv_pay_code,
                      pay_name: value.mes_lis_inv_pay_name,
                      buy_code: value.mes_lis_buy_code,
                      buy_name: value.mes_lis_buy_name,
                      status: value.status,
                      requested_amount: value.mes_lis_inv_lin_det_amo_requested_amount,
                    },
                  }" class="">{{ value.mes_lis_inv_per_end_date }}</router-link>
                <!-- <router-link :to="{ name: 'invoice_detail', params: { data_invoice_id: value.data_invoice_id }, }" class="btn btn-info">{{ value.mes_lis_inv_per_end_date }}</router-link> -->
              </td>
              <td>{{ value.mes_lis_inv_pay_code }}</td>
              <td>{{ value.mes_lis_buy_name }}</td>
              <td>{{ value.status }}</td>
              <td>{{ value.mes_lis_inv_lin_det_amo_requested_amount }}</td>

            </tr>
            <tr v-if="invoice_lists.data && invoice_lists.data.length==0">
            <td class="text-center" colspan="6">データがありません</td>
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
        <table
          class="table orderTopDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">請求取引先コード</td>
            <td><input type="text" v-model="invoiceData.mes_lis_inv_pay_code" class="form-control" /></td>
            <td class="cl_custom_color">締日</td>
            <td>
              <div class="input-group mb-3">

      <input type="date" v-model="invoiceData.mes_lis_inv_per_begin_date" class="form-control">
      <div class="input-group-prepend">
        <span class="input-group-text">~</span>
      </div>
      <input type="date" v-model="invoiceData.mes_lis_inv_per_end_date" class="form-control">
    </div>
            </td>
          </tr>

        </table>
      </div>
    </b-modal>


  </div>
</template>
<script>
export default {
  data() {
    return {
      invoice_lists: {},
      byr_buyer_lists: {},
      invoiceCreateModal:false,
      file: "",
      selected_byr: "0",
      invoiceData:{
        mes_lis_inv_pay_code:'',
        mes_lis_inv_per_begin_date:'',
        mes_lis_inv_per_end_date:'',
      },
      form: new Form({
        select_field_per_page_num:10,
        page:1,
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        // print_cnt: "*",
        // decission_cnt: "*",
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
    viewInvoicePopup(){
      this.invoiceCreateModal = true;
    },
    //get Table data
    get_all_invoice_list(page = 1) {
        this.form.page=page;
      axios.post(this.BASE_URL + "api/get_all_invoice_list",this.form)
        .then(({data}) => {
            this.init(data.status);
          this.invoice_lists = data.invoice_list;
          this.byr_buyer_lists = data.byr_buyer_list;
        });
    },
    insertInvoice() {
      var _this = this;
      axios
        .post(this.BASE_URL + "api/invoiceInsert",this.invoiceData)
        .then(({data}) => {
            this.init(data.status);
         Fire.$emit("LoadByrinvoice");
         _this.alert_icon = "success";
        _this.alert_title = "";
        _this.alert_text =
          "Invoice insert success";
        _this.sweet_normal_alert();
        _this.invoiceCreateModal = false;
        });
    },
    check_byr_order_api() {
      let formData = new FormData();
      formData.append("up_file", this.file);
      formData.append("email", "user@jacos.co.jp");
      formData.append("password", "Qe75ymSr");
      axios({
        method: "POST",
        url: this.BASE_URL + "api/job_exec/1",
        data: formData,
        headers: { "Content-Type": "multipart/form-data" },
      })
        .then(({data})=> {
          this.init(data.status);
          Fire.$emit("LoadByrorder");
        })
        .catch(function (response) {
        });
    },
    onChangeFileUpload() {
      this.file = this.$refs.file.files[0];
      this.check_byr_order_api();
    },

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
    this.get_all_invoice_list();
    Fire.$on("LoadByrinvoice", () => {
      this.get_all_invoice_list();
    });
  },
  mounted() {
  },
};
</script>
