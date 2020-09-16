<template>
    <div class="row" v-can="['byr_view']">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">請求一覧</h4>
                </div>
                <div class="col-12 text-center">
                    
      <label>
        <!--<input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()"/>-->
      </label>
                </div>
                <div class="col-12">
                    <div class="">
                        <table class="table table-striped table-bordered data_table">
                            <thead>
                                <tr>
                                    <th colspan="100%" style="border: none;">
                                        <div class="input-group mb-1" style="margin-left: 10px;max-width: 250px; float: left;">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-primary" type="button">小売選択</button>
                                            </div>
                                            <select class="form-control" v-model="selected_byr">
                                            <option :value="0">全小売</option>
                                              <option v-for="(option, index) in byr_buyer_lists" 
                    :key="index" :value="option.cmn_company_id"
                    :selected="selectedOption(option)">
                    {{ option.company_name }}
            </option>
                                            </select>
                                        </div>
                                        <!--<div class="active-pink-3 active-pink-4 mb-1" style="margin-left: 10px;max-width: 100%; float: left;">
                                            <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                                        </div>-->
                                        <button style="float:right" class="btn btn-primary">請求データアップロード</button>
                                        <button style="float:right" class="btn btn-success">伝票一覧・新規請求</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No <span id="id_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">小売名<span id="orderdate_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">請求日時 <span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">請求対象期間<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">請求金額<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">ステータス<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">詳細<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">請求データ<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">請求書<span id="ordertype_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                
                                <tr v-for="(value,index) in invoice_lists" :key="value.byr_invoice_id">
                                    <td>{{index+1}}</td>
                                    <td>{{value.company_name}}</td>
                                    <td>{{value.send_date}}</td>
                                    <td>{{value.start_date}}~{{value.start_date}}</td>
                                    <td>{{value.request_amount}}</td>
                                    <td>{{value.status}}</td>
                                    <td><router-link :to="{name:'invoice_detail',params:{byr_invoice_id:value.byr_invoice_id} }" class="btn btn-info">詳細</router-link></td>
                                    <td><button class="btn btn-success">ダウンロード</button></td>
                                    <td><button class="btn btn-primary">ダウンロード</button></td>
                                   
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
        'invoice_lists':{},
        'byr_buyer_lists':{},
        'file':'',
        'selected_byr':'0',
    };
  },
  methods: {
    //get Table data
    get_all_invoice_list(){
        axios.get(this.BASE_URL +"api/get_all_invoice_list/"+Globals.user_info_id).then((data) => {
            this.invoice_lists = data.data.invoice_list;
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
      this.get_all_invoice_list();
      Fire.$on("LoadByrinvoice", () => {
      this.get_all_invoice_list();
    });
      console.log('created byr order log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>