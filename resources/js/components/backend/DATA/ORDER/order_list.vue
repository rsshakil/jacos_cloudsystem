<template>
  <div class="row" v-can="['byr_view', 'slr_view']">
    <div class="col-12" style="background: #d8e3f0; padding: 10px">
      <table class="table orderDetailTable table-bordered" style="width: 100%">
        <tr>
          <td class="cl_custom_color" style="width: 9%">
            {{ myLang.receive_date }}
          </td>
          <td style="width: 15%">
            <input
              type="date"
              class="form-control"
              v-model="form.receive_date_from"
            />
          </td>
          <td style="width: 9%; text-align: center">
            <b-icon icon="forward" aria-hidden="true" font-scale="1.5"></b-icon>
          </td>
          <td style="width: 15%">
            <input
              type="date"
              class="form-control"
              v-model="form.receive_date_to"
            />
          </td>
          <td class="cl_custom_color" style="width: 10%">
            {{ myLang.customer_code }}
          </td>
          <td colspan="3" style="width: 17%">
            <input
              type="text"
              class="form-control"
              style="float: left; width: 150px; margin-right: 15px"
            />
            <button @click="showAllCustomerCode" class="btn btn-primary" type="button">
              {{ myLang.refer }}
            </button>
            <!-- <select class="form-control">
              <option :value="0">{{ myLang.customer_code }}</option>
            </select> -->
          </td>
          <!--<td style="width: 10%">
            <button class="btn btn-primary" type="button">
              {{ myLang.refer }}
            </button>
          </td>
          <td></td>-->
        </tr>
        <tr>
          <td class="cl_custom_color">{{ myLang.delivery_date }}</td>
          <td>
            <input
              type="date"
              class="form-control"
              v-model="form.delivery_date_from"
            />
          </td>
          <td style="width: 9%; text-align: center">
            <b-icon icon="forward" aria-hidden="true" font-scale="1.5"></b-icon>
          </td>
          <td>
            <input
              type="date"
              class="form-control"
              v-model="form.delivery_date_to"
            />
          </td>
          <!-- <td>{{ myLang.shipment }}</td> -->
          <td class="cl_custom_color">便</td>
          <td style="width: 10%; text-align: center">
            <select class="form-control" v-model="form.delivery_service_code">
                <option value="*">全て</option>
              <option
                v-for="(dsc, i) in json_delivery_service_code"
                :key="i"

                :value="Object.keys(dsc)[0]"
              >
                {{ Object.values(dsc)[0] }}
              </option>
            </select>
            <!-- <input type="text" class="form-control" v-model="form.delivery_service_code"> -->
            <!-- <select class="form-control">
              <option :value="0">{{ myLang.shipment }}</option>
            </select> -->
          </td>
          <td class="cl_custom_color">{{ myLang.temperature }}</td>
          <td style="width: 15%">
            <select class="form-control" v-model="form.temperature">
            <option value="*">全て</option>
              <option
                v-for="(temp, i) in json_temperature_code"
                :key="i"
                v-if="Object.keys(temp)[0]!=''"
                :value="Object.keys(temp)[0]"
              >
                {{ Object.values(temp)[0] }}
              </option>
            </select>
          </td>
        </tr>
        <tr>
          <!-- <td>{{ myLang.confirmation_status }}</td>
          <td>
            <select class="form-control" v-model="form.confirmation_status">
              <option v-for="(cs, j) in confirmation_status" :key="j" :value="cs.id">{{ cs.name }}</option>
            </select>
          </td> -->
          <!-- <td>{{ myLang.voucher_type }}</td> -->
          <td class="cl_custom_color">部門</td>
          <td>
                                            <multiselect v-model="form.category_code" :options="byr_buyer_category_lists" label="category_name" track-by="category_code" :searchable="true" :close-on-select="true" :clear-on-select="false" :preserve-search="true" placeholder="部門"></multiselect>
            <!--<select class="form-control" v-model="form.byr_category_code">
            <option value="*">全て</option>
            <option :value="categoryData.category_orign_code" v-for="(categoryData,index) in byr_buyer_category_lists" :key="index">{{categoryData.category_orign_code}}| {{categoryData.category_name}}</option>
             </select>-->
          </td>
          <td colspan="2"></td>
          <!-- <td>{{ myLang.printing_status }}</td> -->
          <td class="cl_custom_color">印刷状況</td>
          <td style="width: 10%; text-align: center">
            <select class="form-control" v-model="form.decission_cnt">
              <option
                v-for="(dcnt, i) in decission_cnt"
                :key="i"
                :value="Object.keys(dcnt)[0]"
              >
                {{ Object.values(dcnt)[0] }}
              </option>
              <!-- <option v-for="(pc, j) in decission_cnt" :key="j" :value="pc.name">{{ pc.name }}</option> -->
            </select>
          </td>
          <!-- <td>{{ myLang.confirmation_status }}</td> -->
          <td class="cl_custom_color">確定状況</td>
          <td>

            <select class="form-control" v-model="form.confirmation_status_data">
             <option
                v-for="(dcnt, i) in confirmation_status_list"
                :key="i"
                :value="Object.keys(dcnt)[0]"
              >
                {{ Object.values(dcnt)[0] }}
              </option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="cl_custom_color">参照状況</td>
          <td colspan="7">
            <select class="form-control" v-model="form.check_datetime" style="width: 300px">
              <!--<option :value="0">{{ myLang.voucher_type }}</option>-->
              <option value="*">全て</option>
              <option value="1">未参照</option>
              <option value="2">参照済</option>
            </select>
          </td>
        </tr>
      </table>
    </div>
    <!-- </div> -->
    <br />
    <!-- <div class="row"> -->
    <div class="col-12" style="text-align: center">
      <button class="btn btn-primary" type="button" @click="searchOrder()">
        {{ myLang.search }}
      </button>
    </div>
    <!-- </div> -->
    <!-- </div> -->
    <div class="col-12">
      <hr />
    </div>
    <div class="col-12">
      <button
        class="btn btn-outline-primary"
        type="button"
        @click="orderDownload()"
      >
        <b-icon icon="download" animation="fade" font-scale="1.2"></b-icon>
        {{ myLang.download }}
      </button>
    </div>
    <div class="col-12">
      <div class="">
        <table
          class="table table-striped order_item_details_table table-bordered data_table"
        >
          <thead>
            <!-- <tr>
                                    <th colspan="100%" style="border: none;">
                                        <div class="input-group mb-1" style="margin-left: 10px;max-width: 250px; float: left;">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-primary" type="button">{{myLang.buyer_selection}}</button>
                                            </div>
                                            <select class="form-control" v-model="selected_byr">
                                            <option :value="0">{{myLang.select_buyer}}</option>
                                            <option v-for="(option, index) in byr_buyer_lists"
                                                :key="index" :value="option.cmn_company_id"
                                                :selected="selectedOption(option)">
                                                {{ option.company_name }}
                                            </option>
                                            </select>
                                        </div>
                                    </th>
                                </tr> -->
            <tr>
              <th style="cursor: pointer">No</th>
              <th>{{ myLang.receive_date }}</th>
              <th>{{ myLang.customer_code }}</th>
              <th>{{ myLang.delivery_date }}</th>
              <th>部門 コード</th>
              <th>便</th>
              <th>配達温度区分</th>
              <th>伝票 枚数</th>
              <th>未確定 伝票枚数</th>
              <th>未印刷 伝票枚数</th>
              <th>参照状況</th>
              <!-- <th style="cursor: pointer">{{ myLang.order_date_time }}</th>
              <th style="cursor: pointer">{{ myLang.buyer_name }}</th>
              <th style="cursor: pointer">{{ myLang.delivery_date }}</th>
              <th style="cursor: pointer">{{ myLang.category_code }}</th>
              <th style="cursor: pointer">{{ myLang.shipment }}</th>
              <th style="cursor: pointer">{{ myLang.temperature }}</th>
              <th style="cursor: pointer">{{ myLang.total_voucher_number }}</th>
              <th style="cursor: pointer">{{ myLang.total_confirm_date }}</th>
              <th style="cursor: pointer">{{ myLang.total_print_out_date }}</th>
              <th style="cursor: pointer">{{ myLang.checked_date }}</th> -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="(order_list, index) in order_lists" :key="index">
              <td>{{ index + 1 }}</td>
              <!-- <td>{{order_list.receive_date.valueOf() }}</td> -->
              <!-- ,order_receive_date:order_list.receive_date -->
              <td>
                <router-link
                  :to="{
                    name: 'order_list_details',
                    query: {
                      data_order_id: order_list.data_order_id,
                      delivery_date: order_list.mes_lis_ord_tra_dat_delivery_date.valueOf(),
                      major_category:
                        order_list.mes_lis_ord_tra_goo_major_category,
                      delivery_service_code:
                        order_list.mes_lis_ord_log_del_delivery_service_code,
                      temperature_code:
                        order_list.mes_lis_ord_tra_ins_temperature_code,
                    },
                  }"
                  class=""
                  >{{ order_list.receive_datetime }}</router-link
                >
              </td>
              <td>
                {{ order_list.mes_lis_ord_par_sel_code }}
                {{ order_list.mes_lis_ord_par_sel_name }}
              </td>
              <td>{{ order_list.mes_lis_ord_tra_dat_delivery_date }}</td>
              <td>{{ order_list.mes_lis_ord_tra_goo_major_category }}</td>
              <td>
                {{ order_list.mes_lis_ord_log_del_delivery_service_code }}
                {{
                getbyrjsonValueBykeyName(
                  "mes_lis_ord_log_del_delivery_service_code",
                  order_list.mes_lis_ord_log_del_delivery_service_code,
                  "orders"
                )
              }}
              </td>
              <td>{{ order_list.mes_lis_ord_tra_ins_temperature_code }}
              {{
                getbyrjsonValueBykeyName(
                  "mes_lis_ord_tra_ins_temperature_code",
                  order_list.mes_lis_ord_tra_ins_temperature_code,
                  "orders"
                )
              }}
              </td>
              <td>{{ order_list.cnt }}</td>
              <td>{{ order_list.decision_cnt }}</td>
              <td>{{ order_list.print_cnt }}</td>
              <td>{{ order_list.check_datetime }}</td>
            </tr>
            <tr v-if="order_lists && order_lists.length==0">
            <td colspan="11">データがありません</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

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
      today: new Date().toISOString().slice(0, 10),
      // receive_date:null,
      // today:new Date().toLocaleDateString(),
      order_lists: {},
      byr_buyer_lists: {},
      byr_buyer_category_lists:[],
      file: "",
      selected_byr: "0",
      showAllCustomerCodeListModal:false,
      // temperature:[{id:1,name:"temperature1"},{id:2,name:"temperature2"},{id:3,name:"temperature3"}],
      // confirmation_status:[{id:1,name:"confirmation_status1"},{id:2,name:"confirmation_status2"},{id:3,name:"confirmation_status3"}],
      print_cnt: [{ "*": "全て" }, { "!0": "未印刷あり" }, { 0: "印刷済" }],
      decission_cnt: [{ "*": "全て" }, { "!0": "未確定あり" }, { 0: "確定済" }],
      confirmation_status_list: [{ "*": "全て" }, { "!0": "未確定あり" }, { 0: "確定済" }],
      buyer_settings: null,
      json_temperature_code: [],
      json_delivery_service_code: [],
      form: new Form({
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        receive_date_from: null,
        receive_date_to: null,
        category_code:{category_code:'*',category_name:'全て'},
        // receive_date_from:new Date().toISOString().slice(0, 10),
        // receive_date_to:new Date().toISOString().slice(0, 10),
        // delivery_date_from:new Date().toISOString().slice(0, 10),
        // delivery_date_to:new Date().toISOString().slice(0, 10),
        delivery_date_from: null,
        delivery_date_to: null,
        check_datetime: '*',
        delivery_service_code: "*",
        temperature: "*",
        // confirmation_status:1,
        print_cnt: "*",
        decission_cnt: "*",
        confirmation_status_data: "*",
        decisionDateTime:'*',
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
    showAllCustomerCode(){
      this.showAllCustomerCodeListModal = true;
    },
    get_all_order() {
      this.form.post(this.BASE_URL + "api/get_order_list", this.form)
        .then(({ data }) => {
          this.order_lists = data.order_list;
          this.byr_buyer_lists = data.byr_buyer_list;
          this.byr_buyer_category_lists = data.byr_buyer_category_list;

        //   if ((data.buyer_settings)!=null) {
          this.buyer_settings = JSON.parse(data.buyer_settings);
          this.json_temperature_code = this.buyer_settings.orders.mes_lis_ord_tra_ins_temperature_code;
          this.json_delivery_service_code = this.buyer_settings.orders.mes_lis_ord_log_del_delivery_service_code;
        //   }
          this.byr_buyer_category_lists.unshift({category_code:'*',category_name:'全て'});
          this.loader.hide();
        });
    },
    searchOrder() {
      this.form.submit_type = "search";
      this.get_all_order();
    },
    orderDownload() {
      let formData = new FormData();
      formData.append("scenario_id", 11);
      formData.append("byr_buyer_id", this.$session.get("byr_buyer_id"));
      axios({
        method: "POST",
        url: this.BASE_URL + "api/scenario_exec",
        data: formData,
        headers: { "Content-Type": "multipart/form-data" },
      })
        .then(({data})=> {
          //handle success
          this.init(data.status);
          // const url = window.URL.createObjectURL(new Blob([response.data]));
          const url = data.file_link;
          const link = document.createElement("a");
          link.href = url;

          //レスポンスヘッダからファイル名を取得します
          // const contentDisposition = response.headers["content-disposition"];
          // let fileName = contentDisposition.substring(
          //   contentDisposition.indexOf("filename=") + 9,
          //   contentDisposition.length
          // );
          // //デコードするとスペースが"+"になるのでスペースへ置換します
          // fileName = decodeURI(fileName).replace(/\+/g, " ");
          let fileName = url.match(".+/(.+?)([?#;].*)?$")[1];
          link.setAttribute("download", fileName);
          document.body.appendChild(link);
          link.click();
          Fire.$emit("LoadByrorder");
        })
        .catch(function (response) {
        });
    },
    check_byr_order_api() {
      let formData = new FormData();
      formData.append("up_file", this.file);
      formData.append("email", "user@jacos.co.jp");
      formData.append("password", "Qe75ymSr");
      formData.append("cmn_job_id", 1);
      axios({
        method: "POST",
        url: this.BASE_URL + "api/job_exec",
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
    // this.byr_session_check()
    this.form.byr_buyer_id = this.$session.get("byr_buyer_id");
    // this.today= new Date().toISOString().slice(0, 10);
    this.loader = Vue.$loading.show();
    this.get_all_order();
    Fire.$on("LoadByrorder", () => {
      this.get_all_order();
    });
    Fire.$emit("byr_has_selected", this.$session.get("byr_buyer_id"));
    Fire.$emit("permission_check_for_buyer", this.$session.get("byr_buyer_id"));
    Fire.$emit("loadPageTitle", "発注データ一覧");
  },
  mounted() {
  },
};
</script>
