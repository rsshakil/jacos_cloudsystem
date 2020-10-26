<template>
    <div class="row" v-can="['byr_view']">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">{{myLang.order_data_heading}}</h4>
                </div>
                <!-- <div class="col-12 text-center">
                    
      <label>
        <input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()"/>
      </label>
                </div> -->
                <!-- <div class="col-12"> -->
                    <!-- <div class="row" style="background:#D5DADC; padding:10px"> -->
                        <div class="col-12" style="background:#D5DADC; padding:10px">
                            <table class="table table-bordered" style="width:100%">
                                <tr>
                                    <td>
                                        {{myLang.receive_date}}
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" v-model="today">
                                    </td>
                                    <td> ~ </td>
                                    <td>
                                        <input type="date" class="form-control" v-model="today">
                                    </td>
                                    <td>{{myLang.customer_code}}</td>
                                    <td style="width:30%">
                                        <select class="form-control">
                                            <option :value="0">{{myLang.customer_code}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" type="button">{{myLang.refer}}</button>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{myLang.delivery_date}}</td>
                                    <td>
                                        <input type="date" class="form-control" v-model="today">
                                    </td>
                                    <td> ~ </td>
                                    <td>
                                        <input type="date" class="form-control" v-model="today">
                                    </td>
                                    <td>{{myLang.shipment}}</td>
                                    <td>
                                        <select class="form-control">
                                            <option :value="0">{{myLang.shipment}}</option>
                                        </select>
                                    </td>
                                    <td>{{myLang.temperature}}</td>
                                    <td style="width:35%">
                                        <select class="form-control">
                                            <option :value="0">{{myLang.temperature}}</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{myLang.confirmation_status}}</td>
                                    <td>
                                        <select class="form-control">
                                            <option :value="0">{{myLang.confirmation_status}}</option>
                                        </select>
                                    </td>
                                    <td>{{myLang.voucher_type}}</td>
                                    <td>
                                        <select class="form-control">
                                            <option :value="0">{{myLang.voucher_type}}</option>
                                        </select>
                                    </td>
                                    <td>{{myLang.printing_status}}</td>
                                    <td>
                                        <select class="form-control">
                                            <option :value="0">{{myLang.printing_status}}</option>
                                        </select>
                                    </td>
                                    <td>{{myLang.confirmation_status}}</td>
                                    <td>
                                        <select class="form-control">
                                            <option :value="0">{{myLang.confirmation_status}}</option>
                                        </select>
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
                    <br>
                    <!-- <div class="row"> -->
                        <div class="col-12" style="text-align:center">
                            <button class="btn btn-primary" type="button">{{myLang.search}}</button> 
                        </div>
                    <!-- </div> -->
                <!-- </div> -->
                <div class="col-12">
                    <hr/>
                </div>
                <div class="col-12">
                    <button class="btn btn-outline-primary" type="button">
                        <b-icon icon="download" animation="fade" font-scale="1.2"></b-icon> {{myLang.download}}
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
                                    <th style="cursor: pointer">{{myLang.order_date_time}}</th>
                                    <th style="cursor: pointer">{{myLang.buyer_name}}</th>
                                    <th style="cursor: pointer">{{myLang.delivery_date}}</th>
                                    <th style="cursor: pointer">{{myLang.category_code}}</th>
                                    <th style="cursor: pointer">{{myLang.shipment}}</th>
                                    <th style="cursor: pointer">{{myLang.temperature}}</th>
                                    <th style="cursor: pointer">{{myLang.total_voucher_number}}</th>
                                    <th style="cursor: pointer">{{myLang.total_confirm_date}}</th>
                                    <th style="cursor: pointer">{{myLang.total_print_out_date}}</th>
                                    <th style="cursor: pointer">{{myLang.checked_date}}</th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr v-for="(order_list,index) in order_lists" :key="order_list.byr_order_id">
                                    <td>{{index+1}}</td>
                                    <!-- <td>{{order_list.receive_date.valueOf() }}</td> -->
                                    <!-- ,order_receive_date:order_list.receive_date -->
                                    <td><router-link :to="{name:'order_list_detail',params:{byr_order_id:order_list.byr_order_id,order_receive_date:(order_list.receive_date).valueOf()} }" class="btn btn-primary">{{order_list.receive_date}}</router-link></td>
                                    <td>{{order_list.company_name}}</td>
                                    <td>{{order_list.expected_delivery_date}}</td>
                                    <td>{{order_list.category_code}}</td>
                                    <td>{{order_list.delivery_service_code}}</td>
                                    <td>{{order_list.temperature}}</td>
                                    <td> {{order_list.total_voucher_number}}</td>
                                    <td>{{order_list.total_confirm_date}}</td>
                                    <td>{{order_list.total_print_out_date}}</td>
                                    <td>{{order_list.checked_date}}</td>
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
        today:new Date().toISOString().slice(0, 10),
        // today:new Date().toLocaleDateString(),
        'order_lists':{},
        'byr_buyer_lists':{},
        'file':'',
        'selected_byr':'0',
    };
  },
  methods: {
    //get Table data
    get_all_order(){
        axios.get(this.BASE_URL +"api/get_byr_order_list/"+Globals.user_info_id).then((data) => {
            this.order_lists = data.data.order_list;
            console.log(this.order_lists);
            this.byr_buyer_lists = data.data.byr_buyer_list;
        });
    },
    check_byr_order_api(){
       let formData = new FormData();
    formData.append("up_file", this.file);
    formData.append("email", 'user@jacos.co.jp');
    formData.append("password", 'Qe75ymSr');
    formData.append("cmn_job_id",1);
        axios({
    method: 'POST',
    url: this.BASE_URL + "api/job_exec",
    data: formData,
    headers: {'Content-Type': 'multipart/form-data' }
    })
    .then(function (response) {
        //handle success
        console.log(response);
       Fire.$emit('LoadByrorder');
    })
    .catch(function (response) {
        //handle error
        console.log(response);
    });
    },
    onChangeFileUpload(){
        this.file = this.$refs.file.files[0];
        this.check_byr_order_api();
      },
      
    change(e) {
      const selectedCode = e.target.value;
      const option = this.options.find((option) => {
        return selectedCode === option.byr_buyer_id;
      });
    //   this.$emit("input", option);
    }
  },

  created() {
      this.get_all_order();
      Fire.$on("LoadByrorder", () => {
      this.get_all_order();
    });
      console.log('created byr order log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>