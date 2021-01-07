<template>
    <div class="row">
                <div class="col-12" style="background: #D8E3F0; padding: 10px">
                    <!--<h4 class="top_title text-center" style="margin-top:10px;">{{myLang.payment_data}}</h4>-->
                <table class="table orderDetailTable table-bordered" style="width: 100%">
        <tr>
          <td class="cl_custom_color" style="width: 12%">
            請求取引先コード
          </td>
          <td>
            <input type="text" class="form-control" v-model="form.delivery_date_from" />
          </td>
          
          <td class="cl_custom_color" style="width: 10%">受信日</td>
          <td style="width: 10%">
            <input type="date" class="form-control" v-model="form.receive_date_from" />
          </td>
          <td style="width: 9%; text-align: center">
            <b-icon icon="forward" aria-hidden="true" font-scale="1.5"></b-icon>
          </td>
          <td style="width: 10%" colspan="3">
            <input type="date" class="form-control" v-model="form.receive_date_to" />
          </td>
        </tr>
        <tr>
          <td class="cl_custom_color" style="width: 9%">
            発注者
          </td>
          <td>
            <input type="text" class="form-control" v-model="form.delivery_date_from" />
          </td>
          
          <td class="cl_custom_color" style="width: 10%">受信日</td>
          <td style="width: 10%">
            <input type="date" class="form-control" v-model="form.receive_date_from" />
          </td>
          <td style="width: 9%; text-align: center">
            <b-icon icon="forward" aria-hidden="true" font-scale="1.5"></b-icon>
          </td>
          <td style="width: 10%">
            <input type="date" class="form-control" v-model="form.receive_date_to" />
          </td>
          <td class="cl_custom_color" style="width: 9%">
            参照状況
          </td>
          <td>
            <select class="form-control" style="width:150px;">
                                            <option :value="0">全て</option>
                                        </select>
          </td>
        </tr>
        
        
      </table>
                </div>
                 <div class="col-12" style="text-align: center">
      <button class="btn btn-primary" type="button" @click="searchOrder()">{{ myLang.search }}</button>
    </div>

    <div class="col-12 text-center page_c_title_bar text-sm-left mb-0">
            <h4 class="page_custom_title"> 検索結果：一覧</h4>
       <button class="btn btn-outline-primary" type="button">
        <b-icon icon="download" animation="fade" font-scale="1.2"></b-icon>
        {{ myLang.download }}
      </button>
        </div>
                <div class="col-12">
                    <div class="">
                        <table class="table table-striped order_item_details_table table-bordered data_table">
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
                                <tr v-for="(value,index) in payment_lists" :key="value.byr_payment_id">
                                    <td>{{index+1}}</td>
                                    <td>{{value.company_name}}</td>
                                    <td>{{value.receive_date}}</td>
                                    <td>{{value.download_date}}</td>
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
        'payment_lists':{},
        'byr_buyer_lists':{},
        'file':'',
        'selected_byr':'0',
        form: new Form({
        adm_user_id:Globals.user_info_id,
        byr_buyer_id:null,
        receive_date_from:null,
        receive_date_to:null,
        // receive_date_from:new Date().toISOString().slice(0, 10),
        // receive_date_to:new Date().toISOString().slice(0, 10),
        // delivery_date_from:new Date().toISOString().slice(0, 10),
        // delivery_date_to:new Date().toISOString().slice(0, 10),
        delivery_date_from:null,
        delivery_date_to:null,
        check_datetime:null,
        // check_datetime:new Date().toISOString().slice(0, 10),
        delivery_service_code:'01',
        temperature:'01',
        // confirmation_status:1,
        print_cnt:"*",
        decission_cnt:"*",
        submit_type:"page_load"
      }),
    };
  },
  methods: {
    //get Table data
    get_all_order(){
        axios.get(this.BASE_URL +"api/get_byr_payment_list/"+Globals.user_info_id).then((data) => {
            this.payment_lists = data.data.payment_list;
            this.byr_buyer_lists = data.data.byr_buyer_list;
        });
    },
    check_byr_order_api(){
       let formData = new FormData();
    formData.append("up_file", this.file);
    formData.append("email", 'user@jacos.co.jp');
    formData.append("password", 'Qe75ymSr');
        axios({
    method: 'POST',
    url: this.BASE_URL + "api/job_exec/1",
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
    Fire.$emit('byr_has_selected',this.$session.get('byr_buyer_id'));
    Fire.$emit('permission_check_for_buyer',this.$session.get('byr_buyer_id'));
       Fire.$emit('loadPageTitle', '支払受信一覧');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>