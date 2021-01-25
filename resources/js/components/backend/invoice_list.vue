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
              <span class="tableRowsInfo">1〜10 件表示中／全：10件</span>
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
                <select class="form-control selectPage">
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
              <th style="cursor: pointer">No</th>
              <th style="cursor: pointer">請求日時</th>
              <th style="cursor: pointer">請求取引先コード</th>
              
              <th style="cursor: pointer">発注者</th>
              <th style="cursor: pointer">締日</th>
              <th style="cursor: pointer">請求状況</th>
              <th style="cursor: pointer">請求金額</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(value, index) in invoice_lists"
              :key="value.byr_invoice_id"
            >
              <td>{{ index + 1 }}</td>
              <td>{{ value.company_name }}</td>
              <td>{{ value.send_date }}</td>
              <td>{{ value.start_date }}~{{ value.start_date }}</td>
              <td>{{ value.request_amount }}</td>
              <td>{{ value.status }}</td>
              <td>
                <router-link
                  :to="{
                    name: 'invoice_detail',
                    params: { byr_invoice_id: value.byr_invoice_id },
                  }"
                  class="btn btn-info"
                  >{{ myLang.details }}</router-link
                >
              </td>
              
            </tr>
          </tbody>
        </table>
      </div>
    </div>


<b-modal
      size="lg"
      :hide-backdrop="true"
      title="新規請求作成"
      ok-title="検　索"
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
            <td><input type="text" class="form-control" /></td>
            <td class="cl_custom_color">締日</td>
            <td>
              <div class="input-group mb-3">
      
      <input type="date" class="form-control">
      <div class="input-group-prepend">
        <span class="input-group-text">~</span>
      </div>
      <input type="date" class="form-control">
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
    };
  },
  methods: {
    viewInvoicePopup(){
      this.invoiceCreateModal = true;
    },
    //get Table data
    get_all_invoice_list() {
      axios
        .get(this.BASE_URL + "api/get_all_invoice_list/" + Globals.user_info_id)
        .then((data) => {
          this.invoice_lists = data.data.invoice_list;
          this.byr_buyer_lists = data.data.byr_buyer_list;
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
        .then(function (response) {
          //handle success
          console.log(response);
          Fire.$emit("LoadByrorder");
        })
        .catch(function (response) {
          //handle error
          console.log(response);
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
    console.log("created byr order log");
  },
  mounted() {
    console.log("User page loaded");
  },
};
</script>