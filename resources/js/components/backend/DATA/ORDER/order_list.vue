<template>
  <div class="row" v-can="['byr_view', 'slr_view']">
  <div class="col-12">
    <div class="col-12" style="background: #d8e3f0; padding: 10px">
      <table class="table orderDetailTable cmnWidthTable table-bordered" style="width: 100%">
        <tr>
          <td class="cl_custom_color">
           受信日
          </td>
          <td>
            <div class="input-group">
                <input type="date" class="form-control" :value="this.$store.state.orderModule.form.receive_date_from" @change="updateFormValue($event.target.value,'receive_date_from')">
                <div class="input-group-prepend">
                    <span class="input-group-text">~</span>
                </div>
                <input type="date" class="form-control" :value="this.$store.state.orderModule.form.receive_date_to" @change="updateFormValue($event.target.value,'receive_date_to')">
            </div>
          </td>

          <td class="cl_custom_color">
            {{ myLang.customer_code }}
          </td>
          <td>
            <input
              type="text"
              class="form-control" :value="this.$store.state.orderModule.form.mes_lis_ord_par_sel_code" @change="updateFormValue($event.target.value,'mes_lis_ord_par_sel_code')"
              style="float: left; width: 90px; margin-right: 5px"
            />
            <button @click="showAllCustomerCode" class="btn btn-primary" style="float:left;">
              {{ myLang.refer }}
            </button>
          </td>

          <td class="cl_custom_color">便</td>
          <td>
            <select class="form-control" :value="this.$store.state.orderModule.form.delivery_service_code" @change="updateFormValue($event.target.value,'delivery_service_code')">
                <option value="*">全て</option>
              <option
                v-for="(dsc, i) in json_delivery_service_codeList"
                :key="i"

                :value="i"
              >
                {{ dsc}}
              </option>
            </select>

          </td>
        </tr>
        <tr>
          <td class="cl_custom_color">{{ myLang.delivery_date }}</td>
          <td>

            <div class="input-group">
                <input type="date" class="form-control" :value="this.$store.state.orderModule.form.delivery_date_from" @change="updateFormValue($event.target.value,'delivery_date_from')">
                <div class="input-group-prepend">
                    <span class="input-group-text">~</span>
                </div>
                <input type="date" class="form-control" :value="this.$store.state.orderModule.form.delivery_date_to" @change="updateFormValue($event.target.value,'delivery_date_to')">
            </div>
          </td>

          <!-- <td>{{ myLang.shipment }}</td> -->
          <td class="cl_custom_color">部門</td>
          <td>
            <!-- <multiselect v-model="form.category_code" :options="byr_buyer_category_lists" label="category_name" track-by="category_code" :searchable="true" :close-on-select="true" :clear-on-select="true" :select-label="''" :deselect-label="''" :selected-label="'選択中'" :preserve-search="true"  placeholder="部門"> -->
            <multiselect :value="category_code" @select="updateFormValue($event,'category_code')" :options="byr_buyer_category_lists" label="category_name" track-by="category_code" :searchable="true" :close-on-select="true" :clear-on-select="true" :select-label="''" :deselect-label="''" :selected-label="'選択中'" :preserve-search="true"  placeholder="部門">
               <span slot="noOptions">候補がありません</span> <span slot="noResult">候補がありません</span>
            </multiselect>

          </td>
          <td class="cl_custom_color">温度区分</td>
          <td>
            <select class="form-control" :value="this.$store.state.orderModule.form.temperature" @change="updateFormValue($event.target.value,'temperature')">
            <!-- <select class="form-control" v-model="form.temperature"> -->
            <option value="*">全て</option>
              <option
                v-for="(temp, i) in json_temperature_codeList"
                :key="i" v-if="temp!=''" :value="i">
                {{ temp }}
              </option>
            </select>
          </td>
        </tr>
        <tr>
       <td class="cl_custom_color">参照状況</td>
          <td>
            <select class="form-control" :value="this.$store.state.orderModule.form.check_datetime" @change="updateFormValue($event.target.value,'check_datetime')">
              <option value="*">全て</option>
              <option value="1">未参照</option>
              <option value="2">参照済</option>
            </select>
          </td>
          <td class="cl_custom_color">確定状況</td>
          <td>
            <select class="form-control" :value="this.$store.state.orderModule.form.decission_cnt" @change="updateFormValue($event.target.value,'decission_cnt')">
              <option
                v-for="(dcnt, i) in this.$store.state.orderModule.decission_cnt"
                :key="i"
                :value="Object.keys(dcnt)[0]"
              >
                {{ Object.values(dcnt)[0] }}
              </option>
            </select>
          </td>
          <!-- <td>{{ myLang.confirmation_status }}</td> -->
          <!-- <td class="cl_custom_color">印刷状況</td> -->
          <td class="cl_custom_color">送信状況</td>
          <td>
            <select class="form-control" :value="this.$store.state.orderModule.form.send_cnt" @change="updateFormValue($event.target.value,'send_cnt')" >
             <option
                v-for="(dcnt, i) in this.$store.state.orderModule.send_cnt"
                :key="i"
                :value="Object.keys(dcnt)[0]" >
                {{ Object.values(dcnt)[0] }}
              </option>
            </select>
          </td>
        </tr>

      </table>
    </div>
    </div>
    <!-- </div> -->
    <br />
    <!-- <div class="row"> -->
    <div class="col-12" style="text-align: center">
      <button class="btn btn-primary active srchBtn" type="button" @click="get_all_order()">
        {{ myLang.search }}
      </button>
    </div>
    <!-- </div> -->
    <!-- </div> -->
    <div class="col-12 text-center page_c_title_bar text-sm-left mb-0">
      <h4 class="page_custom_title">検索結果：一覧</h4>

    </div>
    <div class="col-12 text-center">
      <button class="btn btn-outline-primary" type="button" @click="orderDownload()" :disabled="is_disabled($store.state.orderModule.order_lists_length>=1?true:false)">
        <b-icon icon="download" animation="fade" font-scale="1.2"></b-icon>
        {{ myLang.download }}
      </button>
    </div>
    <div class="col-12">
    <p>
              <span class="tableRowsInfo">{{ $store.state.orderModule.order_lists.from }}〜{{ $store.state.orderModule.order_lists.to }} 件表示中／全：{{ $store.state.orderModule.order_lists.total }}件</span>
              <span class="pagi">
              <advanced-laravel-vue-paginate :data="$store.state.orderModule.order_lists"
              :onEachSide="2"
              previousText="<"
              nextText=">"
              alignment="center"
                @paginateTo="get_all_order"/>
              </span>
              <span class="selectPagi">
                <select class="form-control selectPage" @change="get_all_order"
                   :value="$store.state.orderModule.form.per_page" >
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
          class="table table-striped order_list_table order_item_details_table table-bordered data_table"
        >
          <thead>
            <tr>
              <th style="cursor: pointer">No</th>
              <th class="pointer_class" @click="sorting('receive_datetime')">{{ myLang.receive_date }} <span class="float-right" :class="iconSet('receive_datetime','orderModule')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_ord_par_sel_code')">{{ myLang.customer_code }} <span class="float-right" :class="iconSet('mes_lis_ord_par_sel_code','orderModule')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_ord_tra_dat_delivery_date')">{{ myLang.delivery_date }} <span class="float-right" :class="iconSet('mes_lis_ord_tra_dat_delivery_date','orderModule')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_ord_tra_goo_major_category')">部門 コード <span class="float-right" :class="iconSet('mes_lis_ord_tra_goo_major_category','orderModule')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_ord_log_del_delivery_service_code')">便 <span class="float-right" :class="iconSet('mes_lis_ord_log_del_delivery_service_code','orderModule')"></span></th>
              <th class="pointer_class" @click="sorting('mes_lis_ord_tra_ins_temperature_code')">温度区分 <span class="float-right" :class="iconSet('mes_lis_ord_tra_ins_temperature_code','orderModule')"></span></th>
              <th class="pointer_class">伝票 枚数</th>
              <th class="pointer_class">未確定 伝票枚数</th>
              <th class="pointer_class">未送信 伝票枚数</th>
              <th class="pointer_class" @click="sorting('check_datetime')">参照状況 <span class="float-right" :class="iconSet('check_datetime','orderModule')"></span></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(order_list, index) in $store.state.orderModule.order_lists.data" :key="index">
              <td>{{ $store.state.orderModule.order_lists.current_page * $store.state.orderModule.form.per_page - $store.state.orderModule.form.per_page + index + 1 }}</td>
              <td>
                <router-link
                  :to="{
                    name: 'order_list_details',
                    query: {
                      data_order_id: order_list.data_order_id,
                      delivery_date: order_list.mes_lis_ord_tra_dat_delivery_date.valueOf(),
                      major_category:
                        order_list.mes_lis_ord_tra_goo_major_category,
                      delivery_service_code:
                        order_list.mes_lis_ord_log_del_delivery_service_code,
                      temperature_code:
                        order_list.mes_lis_ord_tra_ins_temperature_code,
                      sel_code:
                        order_list.mes_lis_ord_par_sel_code,
                    },
                  }"
                  class=""
                  >{{ order_list.receive_datetime }}</router-link
                >
              </td>
              <td>
                {{ order_list.mes_lis_ord_par_sel_code }}
                {{ order_list.mes_lis_ord_par_sel_name }}
              </td>
              <td>{{ order_list.mes_lis_ord_tra_dat_delivery_date }}</td>
              <td>{{ order_list.mes_lis_ord_tra_goo_major_category }}</td>
              <td>

                {{
                getbyrjsonValueBykeyName(
                  "mes_lis_ord_log_del_delivery_service_code",
                  order_list.mes_lis_ord_log_del_delivery_service_code,
                  "orders"
                )
              }}
              </td>
              <td>{{ order_list.mes_lis_ord_tra_ins_temperature_code }}
              {{
                getbyrjsonValueBykeyName(
                  "mes_lis_ord_tra_ins_temperature_code",
                  order_list.mes_lis_ord_tra_ins_temperature_code,
                  "orders"
                )
              }}
              </td>
              <td>{{ order_list.cnt }}</td>
              <td>{{ order_list.decision_cnt }}</td>
              <td>{{ order_list.send_cnt }}</td>
              <td>{{ order_list.check_datetime }}</td>
            </tr>

            <tr v-if="$store.state.orderModule.order_lists.data && $store.state.orderModule.order_lists.data.length==0">
            <td colspan="11">データがありません</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

<b-modal
      size="lg"
      :hide-backdrop="true"
      title="取引先コード一覧"
      cancel-title="閉じる"
      v-model="showAllCustomerCodeListModal"
      :hide-footer="true"
    >
      <div class="panel-body add_item_body">

          <div class="row">
  <table class="table table-striped order_list_partner_code_modal table-bordered data_table">
          <thead>
            <tr>
              <th style="cursor: pointer">No</th>
              <th>取引先コード</th>
              <th>取引先名</th>
              <th>請求先コード</th>
              <th>請求取引先名</th>
              <th>取引先形態区分</th>

            </tr>
          </thead>
          <tbody>
          <tr v-for="(value,index) in order_customer_code_lists" @click="onRowClicked(value)" :key="index">
          <td>{{index+1}}</td>
          <td>{{value.mes_lis_ord_par_sel_code}}</td>
          <td>{{value.mes_lis_ord_par_sel_name}}</td>
          <td>{{value.mes_lis_ord_par_pay_code}}</td>
          <td>{{value.mes_lis_ord_par_pay_name}}</td>
          <td></td>
          </tr>
          </tbody>
          </table>
          </div>
      </div>
    </b-modal>

  </div>
</template>
<script>
export default {
  data() {
    return {
        category_code:null,
        showAllCustomerCodeListModal:false,
        order_customer_code_lists: {},
    };
  },
  beforeCreate: function() {
            if (!this.$session.exists()) {
                this.$router.push('/home');
            }
        },
  methods: {
    onRowClicked (item) {
        this.updateFormValue (item.mes_lis_ord_par_sel_code,'mes_lis_ord_par_sel_code')
        // this.form.mes_lis_ord_par_sel_code = item.mes_lis_ord_par_sel_code;
       this.showAllCustomerCodeListModal = false;
    },
    //get Table data
    showAllCustomerCode(){
     let loaders = Vue.$loading.show();
      this.showAllCustomerCodeListModal = true;
      axios.post(this.BASE_URL + "api/get_order_customer_code_list", this.$store.state.orderModule.form)
        .then(({ data }) => {
          this.order_customer_code_lists = data.order_customer_code_lists;
         loaders.hide();
        });
    },
    sorting(sorted_field){
        this.updateFormValue (sorted_field,'sort_by','orderModule')
        var sort_type=this.$store.state.orderModule.form.sort_type=="ASC"?"DESC":"ASC";
        this.updateFormValue (sort_type,'sort_type','orderModule')
        var page = this.$store.state.orderModule.form.page
        this.get_all_order(page);

      },
    get_all_order(page=1) {
       this.loader = Vue.$loading.show();

      this.updateFormValue(page, 'page','orderModule')

      axios.post(this.BASE_URL + "api/get_order_list", this.$store.state.orderModule.form)
        .then(({ data }) => {
            this.$store.commit('orderModule/updateFieldValue', { target: 'order_lists', value: data.order_list }, { root: true })
            this.$store.commit('orderModule/updateFieldValue', { target: 'order_lists_length', value: data.order_list.data.length }, { root: true })
            this.$store.commit('orderModule/updateFieldValue', { target: 'page_load', value: 1 }, { root: true })
            this.loader.hide();
        });
    },
    orderDownload(downloadType = 1) {
      //downloadcsvshipment_confirm
      this.loader = Vue.$loading.show();
      this.updateFormValue(downloadType, 'downloadType','orderModule')
      axios.post(this.BASE_URL + "api/downloadcsvshipment_confirm",this.$store.state.orderModule.form)
        .then(({ data }) => {
           this.downloadFromUrl(data);
           this.loader.hide();
        });
    },
  },

  mounted() {
    this.getbuyerJsonSettingvalue();
    this.updateFormValue(this.$session.get("byr_buyer_id"), 'byr_buyer_id','orderModule')
    var page = this.$store.state.orderModule.form.page;
    if (this.$store.state.orderModule.page_load==0) {
       this.get_all_order(page);
    }
    Fire.$on("LoadByrorder", (page) => {
      this.get_all_order(page);
    });
    Fire.$emit("byr_has_selected", this.$session.get("byr_buyer_id"));
    Fire.$emit("permission_check_for_buyer", this.$session.get("byr_buyer_id"));
    Fire.$emit("loadPageTitle", "受注データ一覧");

    this.category_code = this.$store.state.orderModule.form.category_code;
  },
};
</script>
