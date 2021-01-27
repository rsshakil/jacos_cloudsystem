<template>
  <div>
    <div class="row">
      <div class="col-12" style="padding: 10px">
        <table
          class="table orderTopDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">受信日時</td>
            <td>{{ order_info.receive_datetime }}</td>
            <td class="cl_custom_color">取引先</td>
            <td colspan="5">
             {{ order_info.mes_lis_shi_par_sel_code }}
              {{ order_info.mes_lis_shi_par_sel_name }}
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">納品日</td>
            <td>{{ order_info.mes_lis_shi_tra_dat_delivery_date }}</td>
            <td class="cl_custom_color">部門</td>
            <td>{{ order_info.mes_lis_shi_tra_goo_major_category }}</td>
            <td class="cl_custom_color">便</td>
            <td>{{ order_info.mes_lis_shi_log_del_delivery_service_code }}</td>
            <td class="cl_custom_color">配送温度区分</td>
            <td>{{ order_info.mes_lis_shi_tra_ins_temperature_code }}</td>
          </tr>
        </table>
      </div>
      <div class="col-12" style="background: #d8e3f0; padding: 10px">
        <table
          class="table orderDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">商品コード</td>
            <td>
              <input
                type="text" class="form-control topHeaderInputFieldBtn"/>
              <button @click="deliverySearchForm3" class="btn btn-primary active">参照</button>
            </td>
            <td class="cl_custom_color">JANコード</td>
            <td>
              <input type="text" class="form-control topHeaderInputFieldBtn" />
            </td>
            </tr>
        </table>
      </div>

      <div class="col-12" style="text-align: center">
        <button class="btn btn-primary active srchBtn" type="button">
          {{ myLang.search }}
        </button>
      </div>
      <div class="col-12">
        <br />
        <h4 class="page_custom_title">{{ myLang.search_result }}</h4>
      </div>

      
    </div>
    <hr />
    <div class="row">
      <div class="col-12">
      <p>
              <span class="tableRowsInfo">1〜10 件表示中／全：99件</span>
              <span class="pagi"
                >
              <advanced-laravel-vue-paginate :data="order_detail_lists" 
              :onEachSide="2"
              previousText="<"
              nextText=">"
              alignment="center"
                @paginateTo="get_all_byr_order_detail"/>
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
        <div class="">
          <table
            class="table table-striped table-bordered order_item_details_table"
            style="overflow-x: scroll"
          >
            <thead>
            
              <tr>
                <th>No</th>
                <th>商品コード</th>
                <th>JANコード</th>
                <th>商品名</th>
                <th>規格</th>
                <th>産地</th>
                
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(order_detail_list, index) in order_detail_lists.data"
                :key="index"
              >
                <td>{{ index + 1 }}</td>
                
                <td>
                  {{ order_detail_list.mes_lis_shi_tot_tot_net_price_total }}
                </td>
                <td>{{ order_detail_list.status }}</td>
                <td>{{ order_detail_list.updated_at }}</td>
                <td>{{ order_detail_list.print_datetime }}</td>
                <td>{{ order_detail_list.send_datetime }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-12">
      
      </div>
    </div>
    
    <b-modal
      size="lg"
      :hide-backdrop="true"
      title="商品コード"
      ok-title="検　索"
      cancel-title="閉じる"
      @ok.prevent="update_order_voucher_detail()"
      v-model="order_search_modal3"
    >
      <div class="panel-body">
        <table
          class="table orderTopDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">商品コード（発注用）</td>
            <td><input type="text" class="form-control" v-model="form.deliveryCode"/></td>
            <td class="cl_custom_color">JANコード</td>
            <td>
              <input type="text" class="form-control" v-model="form.deliveryName"/>
            </td>
          </tr>
          
          <tr>
            <td class="cl_custom_color">商品名</td>
            <td colspan="3"><input type="" class="form-control"/></td>
          </tr>
          <tr>
            <td class="cl_custom_color">規格</td>
            <td colspan="3"><input type="" class="form-control"/></td>
          </tr>
          <tr>
            <td class="cl_custom_color">取引先コード</td>
            <td><input type="text" class="form-control" v-model="form.deliveryCode"/></td>
            <td class="cl_custom_color">納品先コード</td>
            <td>
              <input type="text" class="form-control" v-model="form.deliveryName"/>
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">部門</td>
            <td>
            <select class="form-control" v-model="form.deliveryDestnation" style="width: 220px">
              <option value="">全て</option>
                <option :value="item" v-for="item in deliveryDestnationOptionList">{{ item }}</option>
              </select>
            </td>
            <td class="cl_custom_color">不定貴区分</td>
            <td>
              <select class="form-control" v-model="form.deliveryDestnation" style="width: 220px">
              <option value="">全て</option>
                <option :value="item" v-for="item in deliveryDestnationOptionList">{{ item }}</option>
              </select>
            </td>
            
          </tr>
        </table>
      </div>
    </b-modal>
  </div>
</template>
<script>
import AdvancedLaravelVuePaginate from 'advanced-laravel-vue-paginate';
import 'advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css'

export default {
  components: {
        AdvancedLaravelVuePaginate
    },
    breadcrumb(){
    return {
    label: this.breadcumbtitle,
    parent: this.parent
  }

  
},
 
  data() {
    return {
       breadcumbtitle:'受注商品別一覧',
      parent: {
        name: 'order_list_detail',
        query: {},
},
      rows: 100,
      currentPage: 1,
      today: new Date().toISOString().slice(0, 10),
      sortKey: "",
      reverse: true,
      order_by: "asc",
      order_detail_lists: {},
      order_item_lists: {},
      order_info: {},
      order_date: "",
      order_detail_list: [],
      show_hide_col_list: [],
      expected_delivery_date: "",
      status: "",
      order_search_modal3: false,
      selected: [],
      select_field_page_num:0,
      select_field_per_page_num:10,
      isCheckAll: false,
      printingStatusOptionList:['01 定番','02 準特価','03 特売'],
      situationOptionList:['未確定あり','確定済'],
      fixedSpecialOptionList:['未印刷あり','未印刷あり'],
      deliveryDestnationOptionList:['店舗','物流センター'],
      form: new Form({
        printingStatus:'',
        situation:'',
        fixedSpecial:'',
        deliveryDestnation:'',
        deliveryCode:'',
        deliveryDate:'',
        deliveryName:'',
      }),
      param_data: [],
     
    };
  },
  methods: {
    
    deliverySearchForm3(){
      this.order_search_modal3 = true;
    },
    selectNumPage(){
      if(this.select_field_page_num!=0){

        this.get_all_byr_order_detail(this.select_field_page_num);
      }
      
    },
    selectNumPerPage(){
      if(this.select_field_per_page_num!=0){
        Fire.$emit("LoadByrorderDetail");
        // this.get_all_byr_order_detail(this.select_field_page_num);
      }
      
    },
    
    //get Table data
    get_all_byr_order_detail(page = 1) {
      this.param_data['page']=page;
      this.param_data['per_page']=this.select_field_per_page_num;
      this.select_field_page_num = page;
      axios
        .post(this.BASE_URL + "api/order_details", this.param_data)
        .then(({ data }) => {
        console.log(data);
          this.order_detail_lists = data.order_list_detail;
          this.order_info = data.order_info;
          this.order_item_lists = data.orderItem;
          this.loader.hide();
          console.log(this.order_detail_lists);
        });
    },

    col_show_hide_setting(url_slug) {
      console.log(this.show_hide_col_list.length + "col lenght");
      if (this.show_hide_col_list.length == 0) {
        var post_data = {
          url_slug: url_slug,
          user_id: Globals.user_info_id,
        };
        axios
          .post(this.BASE_URL + "api/tblecolsetting", post_data)
          .then((data) => {
            console.log(data);
          });
      }
    },
   
  },

  created() {
    Fire.$emit("byr_has_selected", this.$session.get("byr_buyer_id"));
    Fire.$emit("permission_check_for_buyer", this.$session.get("byr_buyer_id"));
    this.param_data = this.$session.get('voucher_page_query_param');
    this.parent.query = this.$session.get('voucher_page_query_param');
    this.loader = Vue.$loading.show();
    this.data_order_id = this.$route.params.data_order_id;
    this.get_all_byr_order_detail();
    Fire.$on("LoadByrorderDetail", () => {
      this.get_all_byr_order_detail();
    });
    this.col_show_hide_setting(this.$route.name);
  },
  mounted() {
    console.log("byr order item search");
  },
};
</script>