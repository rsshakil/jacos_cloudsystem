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
             <div class="input-group mb-3">
                    <input type="date" class="form-control" v-model="form.receive_date_from">
                    <div class="input-group-prepend">
                        <span class="input-group-text">~</span>
                    </div>
                    <input type="date" class="form-control" v-model="form.receive_date_to">
                </div>
             
            </td>
            
            <td class="cl_custom_color" style="width: 10%">
              {{ myLang.customer_code }}
            </td>
            <td style="width: 15%">
              <input
                type="text"
                class="form-control"
                style="float: left; width: 110px; margin-right: 15px"
              />
              <button class="btn btn-primary" style="float:left" type="button">
                {{ myLang.refer }}
              </button>
              
            </td>
           <td style="width: 10%;" class="cl_custom_color">便</td>
            <td style="width: 15%">
              <select class="form-control" v-model="form.delivery_service_code">
                <option :value="0">全て</option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width: 10%;" class="cl_custom_color">計上日</td>
            <td style="width: 15%;">
             <div class="input-group mb-3">
                    <input type="date" class="form-control" v-model="form.wnership_date_from">
                    <div class="input-group-prepend">
                        <span class="input-group-text">~</span>
                    </div>
                    <input type="date" class="form-control" v-model="form.wnership_date_to">
                </div>
             
            </td>
            
            <!-- <td>{{ myLang.shipment }}</td> -->
            <td style="width: 10%;"class="cl_custom_color">部門</td>
            <td style="width: 15%; text-align: center">
                <multiselect v-model="form.category_code" :options="byr_buyer_category_lists" label="category_name" track-by="category_code" :searchable="true" :close-on-select="true" :clear-on-select="false" :preserve-search="true" placeholder="部門"></multiselect>
            </td>
            <td class="cl_custom_color" style="width: 10%">配送温度区分</td>
            <td style="width: 15%;">
              <select class="form-control" v-model="form.temperature_code">
                <option :value="0">全て</option>
              </select>
            </td>
          </tr>
          <tr>
         
            
            <td style="width: 10%;"class="cl_custom_color">データ種別</td>
            <td style="width: 15%; text-align: center">
              <select class="form-control">
                <option :value="0" >全て</option>
              </select>
            </td>
            <td style="width: 10%;" class="cl_custom_color">訂正状況</td>
            <td style="width: 15%;">
              <select class="form-control">
                <option :value="0">全て</option>
              </select>
            </td>
            <td style="width: 10%;"class="cl_custom_color">参照状況</td>
            <td style="width: 15%;">
              <select class="form-control" v-model="form.check_datetime">
                <option :value="0">全て</option>
              </select>
            </td>
          </tr>
          
        </table>
      </div>
    </div>
    <div class="col-12" style="text-align: center">
      <button class="btn btn-primary active srchBtn" type="button" @click="searchReceivedItem">
        {{ myLang.search }}
      </button>
    </div>
    <div class="col-12 text-center page_c_title_bar text-sm-left mb-0">
      <h4 class="page_custom_title">検索結果：一覧</h4>

    </div>
    <div class="col-12 text-center">
         <button class="btn btn-outline-primary" type="button">
        <b-icon icon="download" animation="fade" font-scale="1.2"></b-icon>
        {{ myLang.download }}
      </button>
    </div>
    <div class="col-12">
        <div class="row">
          <div class="col-5">
            <p>
              <span class="tableRowsInfo"
                >{{ received_item_list.from }}〜{{
                  received_item_list.to
                }}
                件表示中／全：{{ received_item_list.total }}件</span
              >
              <span class="pagi">
                <advanced-laravel-vue-paginate
                  :data="received_item_list"
                  :onEachSide="2"
                  previousText="<"
                  nextText=">"
                  alignment="center"
                  @paginateTo="getAllReceivedItem"
                />
              </span>
              <span class="selectPagi">
                <select
                  @change="getAllReceivedItem"
                  v-model="form.select_field_per_page_num"
                  class="form-control selectPage"
                >
                  <option value="10">10行</option>
                  <option value="20">20行</option>
                  <option value="50">50行</option>
                  <option value="100">100行</option>
                </select>
              </span>
            </p>
          </div>
        </div>
      </div>
    <div class="col-12">
      <div class="">
        <table class="table table-striped table-bordered order_item_details_table data_table">
          <thead>
            <tr>
              <th class="pointer_class">No</th>
              <th class="pointer_class" @click="sorting('receive_datetime')">受注日時 <span class="float-right" :class="iconSet('receive_datetime')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_acc_par_sel_code')">取引先 <span class="float-right" :class="iconSet('mes_lis_acc_par_sel_code')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_acc_tra_dat_transfer_of_ownership_date')">計上日 <span class="float-right" :class="iconSet('mes_lis_acc_tra_dat_transfer_of_ownership_date')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_acc_tra_goo_major_category')">部門 コード <span class="float-right" :class="iconSet('mes_lis_acc_tra_goo_major_category')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_acc_log_del_delivery_service_code')">便 <span class="float-right" :class="iconSet('mes_lis_acc_log_del_delivery_service_code')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_acc_tra_ins_temperature_code')">配送温度 区分 <span class="float-right" :class="iconSet('mes_lis_acc_tra_ins_temperature_code')"></span></th>
              <th class="pointer_class" >データ種別</th>
              <th class="pointer_class" >伝票枚数</th>
              <th class="pointer_class" >訂正あり 伝票枚数</th>
              <th class="pointer_class" @click="sorting('check_datetime')">参照状況 <span class="float-right" :class="iconSet('check_datetime')"></span></th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(received_item, index) in received_item_list.data"
              :key="index"
            >
              <td>{{ index + 1 }}</td>
              <td>
              <router-link
                    :to="{
                      name: 'receive_detail',
                      params: {
                        data_receive_id:
                          received_item.data_receive_id,
                      },
                    }"
                    class=""
                    >
              {{ received_item.receive_datetime }}
              </router-link>
              </td>
              <td>{{ received_item.mes_lis_acc_par_sel_code }} {{ received_item.mes_lis_acc_par_sel_name }}</td>
              <td>{{ received_item.mes_lis_acc_tra_dat_transfer_of_ownership_date }}</td>
              <td>{{ received_item.mes_lis_acc_tra_goo_major_category }}</td>
              <td>{{ received_item.mes_lis_acc_log_del_delivery_service_code }}
              {{
                getbyrjsonValueBykeyName(
                  "mes_lis_ord_log_del_delivery_service_code",
                  received_item.mes_lis_acc_log_del_delivery_service_code,
                  "orders",
                  buyer_settings
                )
              }}
              </td>
              <td>
                  {{
                    received_item.mes_lis_acc_tra_ins_temperature_code
                  }}
                  {{
                    getbyrjsonValueBykeyName(
                      "mes_lis_ord_tra_ins_temperature_code",
                      received_item.mes_lis_acc_tra_ins_temperature_code,
                      "orders",buyer_settings
                    )
                  }}
              </td>
              <td></td>
              <td></td>
              <td></td>
              <td>{{ received_item.check_datetime }}</td>
            </tr>
            <tr v-if="received_item_list.data && received_item_list.data.length==0">
                <td colspan="11">データがありません</td>
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
      received_item_list: {},
      byr_buyer_lists: {},
      byr_buyer_category_lists: [],
      byr_buyer_id:null,
      buyer_settings:[],
      form: new Form({
        select_field_per_page_num:10,
        page:1,
        adm_user_id: Globals.user_info_id,
        byr_buyer_id: null,
        receive_date_from: null,
        receive_date_to: null,
        wnership_date_from: null,
        wnership_date_to: null,
        major_category: "01",
        delivery_service_code: "01",
        temperature_code: "01",
        check_datetime: null,
        category_code:{category_code:'*',category_name:'全て'},
        sort_by:'data_receive_id ',
        sort_type:"ASC",
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
    getAllReceivedItem(page = 1) {
        this.form.page=page;
        axios.post(this.BASE_URL +"api/data_receive_list",this.form)
            .then(({data}) => {
                this.init(data.status);
                this.received_item_list = data.received_item_list;
                this.byr_buyer_lists = data.byr_buyer_list;
                this.byr_buyer_category_lists = data.byr_buyer_category_list;
                this.byr_buyer_category_lists.unshift({category_code:'*',category_name:'全て'});
                this.buyer_settings = JSON.parse(data.buyer_settings);

            });
    },
    sorting(sorted_field){
          this.form.sort_by=sorted_field;
          this.form.sort_type=this.form.sort_type=="ASC"?"DESC":"ASC";
          this.getAllReceivedItem();

      },
    searchReceivedItem(){
        this.form.submit_type="search"
        this.getAllReceivedItem();
    }
  },

  created() {
        this.byr_buyer_id=this.$session.get("byr_buyer_id");
        this.form.byr_buyer_id=this.byr_buyer_id;
        this.getAllReceivedItem();
        // Fire.$on("LoadAllReceiveItem", () => {
        //   this.getAllReceivedItem();
        // });
        Fire.$emit("byr_has_selected",this.byr_buyer_id);
        Fire.$emit("permission_check_for_buyer", this.byr_buyer_id);
        Fire.$emit("loadPageTitle", "受領受信一覧");
  },
  mounted() {},
};
</script>
