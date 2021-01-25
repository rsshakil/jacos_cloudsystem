<template>
    <div class="row">
                <div class="col-12">
     <table
          class="table orderTopDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">締日</td>
            <td><input type="text" class="form-control"></td>
            <td class="cl_custom_color">納品日</td>
            <td>
            <input type="text" class="form-control">
            </td>
            <td class="cl_custom_color">納品先</td>
            <td>
            <input type="text" class="form-control">
            </td>
            <td class="cl_custom_color">伝票番号</td>
            <td>
            <input type="text" class="form-control">
            </td>
            
          </tr>
          <tr>
            <td class="cl_custom_color">伝票区分</td>
            <td colspan="7"><input type="text" class="form-control"></td>
            
            
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
                    <div class="">
                        <table
            class="table table-striped table-bordered order_item_details_table" style="overflow-x: scroll">
                            <thead>
                               
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No <span id="id_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer"> 新規請求<span id="orderdate_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">店舗名 <span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">納品日<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">伝票番号<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">合計金額<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">請求日時<span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">明細<span id="ordertype_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                
                                <tr v-for="(value,index) in invoice_detail_lists" :key="value.byr_order_detail_id">
                                    <td>{{index+1}}</td>
                                    <td><input type="checkbox" class="form-control"></td>
                                    <td>{{value.shop_name}}</td>
                                    <!--v-tooltip.html="''+value.expected_delivery_date+'<br>'+value.revised_delivery_date+''"-->
                                    <td v-if="value.revised_delivery_date !== null && value.revised_delivery_date !== ''">{{value.revised_delivery_date}}</td>
                                    <td v-else>{{value.expected_delivery_date}}</td>
                                    <td>{{value.voucher_number}}</td>
                                    <td v-if="value.revised_cost_price !== null && value.revised_cost_price !== 0 && value.revised_cost_price !== ''">{{value.revised_cost_price}}</td>
                                   <td v-else>{{value.cost_price}}</td>
                                    <td>{{value.send_date}}</td>
                                    <td><router-link :to="{name:'voucher_detail',params:{voucher_number:value.voucher_number} }" class="btn btn-info">詳細</router-link></td>
                                   
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
        'selected_byr':'0',
        'byr_shop_lists':{},
        'selected_byr_shop':'0',
        'byr_voucher_lists':{},
        'selected_byr_voucher':'0',
        'file':'',
        'byr_invoice_id':'',   
        'start_date':'',
        'end_date':'',
        'total_price':0,
    };
  },
  methods: {
    //get Table data
    get_all_invoice_detail(){
        axios.get(this.BASE_URL +"api/get_all_invoice_detail_list/"+this.byr_invoice_id).then((data) => {
            this.invoice_detail_lists = data.data.invoice_list;
            this.byr_buyer_lists = data.data.byr_buyer_list;
            this.byr_shop_lists = data.data.shop_list;
            this.byr_voucher_lists = data.data.voucher_list;
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
     
      selectedOption_shop(option) {
      if (this.value) {
        return option.byr_shop_id === this.value.byr_shop_id;
      }
      return false;
    },
      selectedOption_voucher(option) {
      if (this.value) {
        return option.voucher_number === this.value.voucher_number;
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
    Fire.$emit("byr_has_selected", this.$session.get("byr_buyer_id"));
    Fire.$emit("permission_check_for_buyer", this.$session.get("byr_buyer_id"));
    this.byr_invoice_id = this.$route.params.byr_invoice_id;
      this.get_all_invoice_detail();
      Fire.$on("LoadByrinvoice_detail", () => {
      this.get_all_invoice_detail();
    });
      console.log('created byr order log');
  },
  computed: {
    total_price_vl: function(){
      let sum = 0;
      for(let i = 0; i < this.invoice_detail_lists.length; i++){
          var price = (this.invoice_detail_lists[i].revised_cost_price !== null && this.invoice_detail_lists[i].revised_cost_price !== 0 && this.invoice_detail_lists[i].revised_cost_price !== ''?this.invoice_detail_lists[i].revised_cost_price:this.invoice_detail_lists[i].cost_price);
         sum += parseInt(price);
      }

     return sum;
   }
},
  mounted() {
    console.log("User page loaded");
  }
};
</script>