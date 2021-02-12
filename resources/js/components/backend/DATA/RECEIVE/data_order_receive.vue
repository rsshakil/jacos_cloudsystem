<template>
  <div class="row">
    <div class="col-12">
      <!-- <h4 class="top_title text-center" style="margin-top:10px;">{{myLang.order_receive_head}}</h4>-->
      <div class="col-12" style="background: #d8e3f0; padding: 10px">
        <table
          class="table orderDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color" style="width: 10%">受信日</td>
            <td style="width: 15%">
              <input
                type="date"
                class="form-control"
                v-model="form.receive_date_from"
              />
            </td>
            <td style="width: 9%; text-align: center">
              <b-icon
                icon="forward"
                aria-hidden="true"
                font-scale="1.5"
              ></b-icon>
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
              <button class="btn btn-primary" type="button">
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
            <td class="cl_custom_color">計上日</td>
            <td>
              <input
                type="date"
                class="form-control"
                v-model="form.delivery_date_from"
              />
            </td>
            <td style="width: 9%; text-align: center">
              <b-icon
                icon="forward"
                aria-hidden="true"
                font-scale="1.5"
              ></b-icon>
            </td>
            <td>
              <input
                type="date"
                class="form-control"
                v-model="form.delivery_date_to"
              />
            </td>
            <!-- <td>{{ myLang.shipment }}</td> -->
            <td class="cl_custom_color">部門</td>
            <td style="width: 10%; text-align: center">
              <select class="form-control">
                <option :value="0">全て</option>
              </select>
              <!-- <input type="text" class="form-control" v-model="form.delivery_service_code"> -->
              <!-- <select class="form-control">
              <option :value="0">{{ myLang.shipment }}</option>
            </select> -->
            </td>
            <td class="cl_custom_color">便</td>
            <td style="width: 15%">
              <select class="form-control">
                <option :value="0">全て</option>
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
            <td class="cl_custom_color" style="width: 10%">配送温度区分</td>
            <td colspan="3">
              <select class="form-control" style="width: 300px">
                <option :value="0">全て</option>
              </select>
            </td>
            <!-- <td>{{ myLang.printing_status }}</td> -->
            <td class="cl_custom_color">データ種別</td>
            <td style="width: 10%; text-align: center" colspan="3">
              <select class="form-control" style="width: 300px">
                <option :value="0">全て</option>
              </select>
            </td>
            <!-- <td>{{ myLang.confirmation_status }}</td> -->
          </tr>
          <tr>
            <td class="cl_custom_color">訂正状況</td>
            <td colspan="3">
              <select class="form-control" style="width: 300px">
                <option :value="0">全て</option>
              </select>
            </td>
            <td class="cl_custom_color">参照状況</td>
            <td colspan="3">
              <select class="form-control" style="width: 300px">
                <option :value="0">全て</option>
              </select>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-12" style="text-align: center">
      <button class="btn btn-primary" type="button" @click="searchOrder()">
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
      <div class="">
        <table class="table table-striped table-bordered order_item_details_table data_table">
          <thead>
            <tr>
              <th style="cursor: pointer">No</th>
              <th style="cursor: pointer">受注日時</th>
              <th style="cursor: pointer">取引先</th>
              <th style="cursor: pointer">計上日</th>
              <th style="cursor: pointer">部門 コード</th>
              <th style="cursor: pointer">便</th>
              <th style="cursor: pointer">配送温度 区分</th>
              <th style="cursor: pointer">データ種別</th>
              <th style="cursor: pointer">伝票枚数</th>
              <th style="cursor: pointer">訂正あり 伝票枚数</th>
              <th style="cursor: pointer">参照状況</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(order_receive_list, index) in order_receive_lists"
              :key="order_receive_list.byr_receive_id"
            >
              <td>{{ index + 1 }}</td>
              <td>{{ order_receive_list.company_name }}</td>
              <td>{{ order_receive_list.receive_date }}</td>
              <td>{{ order_receive_list.download_date }}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
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
      order_receive_lists: {},
      byr_buyer_lists: {},
      file: "",
      selected_byr: "0",
      byr_buyer_id:null,
      form: new Form({
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        receive_date_from: null,
        receive_date_to: null,
        delivery_date_from: null,
        delivery_date_to: null,
        check_datetime: null,
        delivery_service_code: "01",
        temperature: "01",
        print_cnt: "*",
        decission_cnt: "*",
        submit_type: "page_load",
      }),
    };
  },
  methods: {
    //get Table data
    get_all_order() {
      axios.post(this.BASE_URL +"api/data_receive_list",{adm_user_id:Globals.user_info_id,byr_buyer_id:this.byr_buyer_id})
        .then(({data}) => {
            console.log(data);
          this.order_receive_lists = data.received_item_list;
          this.byr_buyer_lists = data.byr_buyer_list;
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
      this.byr_buyer_id=this.$session.get("byr_buyer_id");
      console.log(this.byr_buyer_id)
    this.get_all_order();
    Fire.$on("LoadByrorder", () => {
      this.get_all_order();
    });
    Fire.$emit("byr_has_selected",this.byr_buyer_id);
    Fire.$emit("permission_check_for_buyer", this.byr_buyer_id);
    Fire.$emit("loadPageTitle", "受領受信一覧");
    console.log("created byr order log");
  },
  mounted() {
    console.log("User page loaded");
  },
};
</script>
