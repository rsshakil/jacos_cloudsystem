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
            <td>
            <span v-if="order_info && order_info.length">
            {{ order_info.receive_datetime }}
            </span>
            </td>
            <td class="cl_custom_color">取引先</td>
            <td colspan="5">
            <span v-if="order_info && order_info.length">
             {{ order_info.mes_lis_shi_par_sel_code }}
              {{ order_info.mes_lis_shi_par_sel_name }}
              </span>
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">納品日</td>
            <td>
            <span v-if="order_info && order_info.length">
            {{ order_info.mes_lis_shi_tra_dat_delivery_date }}
            </span>
            </td>
            <td class="cl_custom_color">部門</td>
            <td>
            <span v-if="order_info && order_info.length">
            {{ order_info.mes_lis_shi_tra_goo_major_category }}
            </span>
            </td>
            <td class="cl_custom_color">便</td>
            <td><span v-if="order_info && order_info.length">{{ order_info.mes_lis_shi_log_del_delivery_service_code }} {{getbyrjsonValueBykeyName('mes_lis_ord_log_del_delivery_service_code',order_info.mes_lis_shi_log_del_delivery_service_code,'orders')}}</span></td>
            <td class="cl_custom_color">配送温度区分</td>
            <td><span v-if="order_info && order_info.length">{{ order_info.mes_lis_shi_tra_ins_temperature_code }} {{getbyrjsonValueBykeyName('mes_lis_ord_tra_ins_temperature_code',order_info.mes_lis_shi_tra_ins_temperature_code,'orders')}}</span></td>
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
              <span class="tableRowsInfo"
                >{{ order_detail_lists.from }}〜{{
                  order_detail_lists.to
                }}
                件表示中／全：{{ order_detail_lists.total }}件</span
              >
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
                <select class="form-control selectPage" @change="selectNumPerPage"
                  v-model="select_field_per_page_num">
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
                <td>
                  {{
                    order_detail_lists.current_page *
                      select_field_per_page_num -
                    select_field_per_page_num +
                    index +
                    1
                  }}
                </td>

                <td><router-link
                    :to="{
                      name: 'item_search_detail',
                      params: {
                        item_id:
                          order_detail_list.mes_lis_shi_lin_ite_supplier_item_code,
                      },
                    }"
                    class=""
                    >
                  {{ order_detail_list.mes_lis_shi_lin_ite_supplier_item_code }}
                  </router-link>
                </td>
                <td>{{ order_detail_list.mes_lis_shi_lin_ite_gtin }}</td>
                <td>{{ order_detail_list.mes_lis_shi_lin_ite_name }}</td>
                <td>{{ order_detail_list.mes_lis_shi_lin_ite_ite_spec }}</td>
                <td>{{ order_detail_list.mes_lis_shi_lin_fre_field_name }}</td>
              </tr>
              <tr v-if="order_detail_lists.data && order_detail_lists.data.length==0">
                <td class="text-center" colspan="6">データがありません</td>
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
      @ok.prevent="searchItemDetail()"
      v-model="order_search_modal3"
    >
      <div class="panel-body">
        <table
          class="table orderTopDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">商品コード（発注用）</td>
            <td><input type="text" class="form-control" v-model="form.mes_lis_shi_lin_ite_supplier_item_code"/></td>
            <td class="cl_custom_color">JANコード</td>
            <td>
              <input type="text" class="form-control" v-model="form.mes_lis_shi_lin_ite_gtin"/>
            </td>
          </tr>

          <tr>
            <td class="cl_custom_color">商品名</td>
            <td colspan="3"><input type="text" v-model="form.mes_lis_shi_lin_ite_name" class="form-control"/></td>
          </tr>
          <tr>
            <td class="cl_custom_color">規格</td>
            <td colspan="3"><input type="text" v-model="form.mes_lis_shi_lin_ite_ite_spec" class="form-control"/></td>
          </tr>
          <tr>
            <td class="cl_custom_color">取引先コード</td>
            <td><input type="text" class="form-control"/></td>
            <td class="cl_custom_color">納品先コード</td>
            <td>
              <input type="text" class="form-control"/>
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
              <select class="form-control" v-model="form.mes_lis_shi_tra_fre_variable_measure_item_code" style="width: 220px">
              <option value="*">全て</option>
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
        name: 'order_list_details',
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
        mes_lis_shi_lin_ite_supplier_item_code:'',
        mes_lis_shi_lin_ite_gtin:'',
        mes_lis_shi_lin_ite_name:'',
        mes_lis_shi_lin_ite_ite_spec:'',
        mes_lis_shi_tra_fre_variable_measure_item_code:'*'
      }),
      param_data: [],

    };
  },
  beforeCreate: function() {
            if (!this.$session.exists()) {
                this.$router.push('/home');
            }
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
      }

    },
    searchItemDetail(){
       Fire.$emit("LoadByrorderDetail");
        this.order_search_modal3 = false;
    },
    //get Table data
    get_all_byr_order_detail(page = 1) {
      this.param_data['page']=page;
      this.param_data['per_page']=this.select_field_per_page_num;
      this.param_data['form_search'] = this.form;
      this.select_field_page_num = page;
      axios
        .post(this.BASE_URL + "api/get_all_shipment_item_by_search", this.param_data)
        .then(({ data }) => {
        this.init(data.status);
          this.order_detail_lists = data.order_list_detail;
          this.order_info = data.order_info;
          this.order_item_lists = data.orderItem;
          this.loader.hide();
        });
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
  },
  mounted() {
  },
};
</script>
