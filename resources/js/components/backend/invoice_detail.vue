<template>
    <div class="row" v-can="['byr_view']">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">伝票一覧・新規請求</h4>
                </div>
                <div class="col-12 text-center">
        <div class="row">
          <div class="col"></div>
          <div class="col-3">
            <div class="card mb-4 box-shadow">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">請求対象期間</h4>
              </div>
              <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div>
                  <div class="form-group mb-0">
                    <input
                      type="text"
                      v-model="start_date"
                      name="start_date" style="float:left;width:50%;"
                      class="form-control text-center"
                    />
                    <input
                      type="text"
                      v-model="end_date" style="float:left;width:50%;"
                      name="end_date"
                      class="form-control text-center"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-3">
            <div class="card mb-4 box-shadow">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">請求合計金額</h4>
              </div>
              <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div>
                  <div class="form-group mb-0">
                    <input
                      type="text"
                      v-model="total_price"
                      name="total_price"
                      class="form-control text-center"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col"></div>
        </div>
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
                    :key="index" :value="option.super_code"
                    :selected="selectedOption(option)">
                    {{ option.super_code }}
            </option>
                                            </select>
                                        </div>
                                        <!--<div class="active-pink-3 active-pink-4 mb-1" style="margin-left: 10px;max-width: 100%; float: left;">
                                            <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                                        </div>-->
                                        <button style="float:right" class="btn btn-primary">新規請求</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No <span id="id_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer"><input type="checkbox" class="form-control"> 新規請求<span id="orderdate_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">店舗名 <span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">納品日<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">伝票番号<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">合計金額<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">請求日時<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">明細<span id="ordertype_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                
                                <tr v-for="(value,index) in invoice_detail_lists" :key="value.byr_invoice_detail_id">
                                    <td>{{index+1}}</td>
                                    <td><input type="checkbox" class="form-control"></td>
                                    <td>{{value.shop_name}}</td>
                                    <td>{{value.revised_delivery_date}}</td>
                                    <td>{{value.voucher_number}}</td>
                                    <td>{{value.cost_price}}</td>
                                    <td>{{value.send_date}}</td>
                                    <td><router-link :to="{name:'voucher_detail',params:{byr_voucher_number:value.voucher_number} }" class="btn btn-info">詳細</router-link></td>
                                   
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
        'invoice_detail_lists':{},
        'byr_buyer_lists':{},
        'file':'',
        'byr_invoice_id':'',
        'selected_byr':'0',
        'start_date':'',
        'end_date':'',
        'total_price':'',
    };
  },
  methods: {
    //get Table data
    get_all_invoice_detail(){
        axios.get(this.BASE_URL +"api/get_all_invoice_detail_list/"+this.byr_invoice_id).then((data) => {
            this.invoice_detail_lists = data.data.invoice_list;
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
      selectedOption(option) {
      if (this.value) {
        return option.byr_buyer_id === this.value.byr_buyer_id;
      }
      return false;
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
    this.byr_invoice_id = this.$route.params.byr_invoice_id;
      this.get_all_invoice_detail();
      Fire.$on("LoadByrinvoice_detail", () => {
      this.get_all_invoice_detail();
    });
      console.log('created byr order log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>