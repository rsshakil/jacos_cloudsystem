<template>
  <div class="row" v-can="['byr_view','slr_view']"> 
    <div class="col-12" style="background: #d5dadc; padding: 10px">
      <table class="table table-bordered" style="width: 100%">
        <tr>
          <td style="width: 9%">
            {{ myLang.receive_date }}
          </td>
          <td style="width: 15%">
            <input type="date" class="form-control" v-model="today" />
          </td>
          <td style="width: 9%; text-align: center">
            <b-icon icon="forward" aria-hidden="true" font-scale="1.5"></b-icon>
          </td>
          <td style="width: 15%">
            <input type="date" class="form-control" v-model="today" />
          </td>
          <td style="width: 10%">{{ myLang.customer_code }}</td>
          <td style="width: 17%">
            <input type="text" class="form-control">
            <!-- <select class="form-control">
              <option :value="0">{{ myLang.customer_code }}</option>
            </select> -->
          </td>
          <td style="width: 10%">
            <button class="btn btn-primary" type="button">
              {{ myLang.refer }}
            </button>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>{{ myLang.delivery_date }}</td>
          <td>
            <input type="date" class="form-control" v-model="today" />
          </td>
          <td style="width: 9%; text-align: center">
            <b-icon icon="forward" aria-hidden="true" font-scale="1.5"></b-icon>
          </td>
          <td>
            <input type="date" class="form-control" v-model="today" />
          </td>
          <!-- <td>{{ myLang.shipment }}</td> -->
          <td>Delivery Service Code</td>
          <td>
            <input type="text" class="form-control">
            <!-- <select class="form-control">
              <option :value="0">{{ myLang.shipment }}</option>
            </select> -->
          </td>
          <td>{{ myLang.temperature }}</td>
          <td style="width: 15%">
            <select class="form-control">
              <option :value="0">{{ myLang.temperature }}</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>{{ myLang.confirmation_status }}</td>
          <td>
            <select class="form-control">
              <option :value="0">{{ myLang.confirmation_status }}</option>
            </select>
          </td>
          <!-- <td>{{ myLang.voucher_type }}</td> -->
          <td>Print CNT</td>
          <td>
            <select class="form-control">
              <option :value="0">Print CNT</option>
            </select>
          </td>
          <!-- <td>{{ myLang.printing_status }}</td> -->
          <td>Decission CNT</td>
          <td>
            <select class="form-control">
              <option :value="0">Decission CNT</option>
            </select>
          </td>
          <!-- <td>{{ myLang.confirmation_status }}</td> -->
          <td>Check Datetime</td>
          <td>
            <input type="date" class="form-control" v-model="today" />
            <!-- <select class="form-control">
              <option :value="0">{{ myLang.confirmation_status }}</option>
            </select> -->
          </td>
        </tr>
        <!-- <tr>
                                    <td>{{myLang.voucher_type}}</td>
                                    <td>
                                        <select class="form-control">
                                            <option :value="0">{{myLang.voucher_type}}</option>
                                        </select>
                                    </td>
                                    <td colspan="6"></td>
                                </tr> -->
      </table>
    </div>
    <!-- </div> -->
    <br />
    <!-- <div class="row"> -->
    <div class="col-12" style="text-align: center">
      <button class="btn btn-primary" type="button">{{ myLang.search }}</button>
    </div>
    <!-- </div> -->
    <!-- </div> -->
    <div class="col-12">
      <hr />
    </div>
    <div class="col-12">
      <button class="btn btn-outline-primary" type="button">
        <b-icon icon="download" animation="fade" font-scale="1.2"></b-icon>
        {{ myLang.download }}
      </button>
    </div>
    <div class="col-12">
      <div class="">
        <table class="table table-striped table-bordered data_table">
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
              <th>Major Category</th>
              <th>Delivery Service Code</th>
              <th>Tempareture Code</th>
              <th>CNT</th>
              <th>Decission CNT</th>
              <th>Print CNT</th>
              <th>Check Datetime</th>
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
            <tr
              v-for="(order_list, index) in order_lists"
              :key="order_list.byr_order_id"
            >
              <td>{{ (index + 1) }}</td>
              <!-- <td>{{order_list.receive_date.valueOf() }}</td> -->
              <!-- ,order_receive_date:order_list.receive_date -->
              <td>
                <router-link
                  :to="{
                    name: 'order_list_detail',
                    params: {
                      byr_order_id: order_list.data_order_id,
                      order_receive_date: order_list.receive_datetime.valueOf(),
                    },
                  }"
                  class=""
                  >{{ order_list.receive_datetime }}</router-link
                >
              </td>
              <td>{{order_list.mes_lis_ord_par_sel_code}} {{order_list.mes_lis_ord_par_sel_name}}</td>
              <td>{{order_list.mes_lis_ord_tra_dat_delivery_date}}</td>
              <td>{{order_list.mes_lis_ord_tra_goo_major_category}}</td>
              <td>{{order_list.mes_lis_ord_log_del_delivery_service_code}}</td>
              <td>{{order_list.mes_lis_ord_tra_ins_temperature_code}}</td>
              <td>{{order_list.cnt}}</td>
              <td>{{order_list.decision_cnt}}</td>
              <td>{{order_list.print_cnt}}</td>
              <td>{{order_list.check_datetime}}</td>
              <!-- <td>{{ order_list.company_name }}</td>
              <td>{{ order_list.expected_delivery_date }}</td>
              <td>{{ order_list.category_code }}</td>
              <td>{{ order_list.delivery_service_code }}</td>
              <td>{{ order_list.temperature }}</td>
              <td>{{ order_list.total_voucher_number }}</td>
              <td>{{ order_list.total_confirm_date }}</td>
              <td>{{ order_list.total_print_out_date }}</td>
              <td>{{ order_list.checked_date }}</td> -->
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
      today: new Date().toISOString().slice(0, 10),
      // today:new Date().toLocaleDateString(),
      order_lists: {},
      byr_buyer_lists: {},
      file: "",
      selected_byr: "0",
    };
  },
  methods: {
    //get Table data
    get_all_order() {
      axios
        .get(this.BASE_URL + "api/get_byr_order_list/" + Globals.user_info_id)
        .then(({data}) => {
            console.log(data)
          this.order_lists = data.order_list;
          this.byr_buyer_lists = data.byr_buyer_list;
          this.loader.hide();
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
    this.loader = Vue.$loading.show();
    this.get_all_order();
      Fire.$on("LoadByrorder", () => {
      this.get_all_order();
    });
    console.log("created byr order log");
  },
  mounted() {
    console.log("User page loaded");
  },
};
</script>