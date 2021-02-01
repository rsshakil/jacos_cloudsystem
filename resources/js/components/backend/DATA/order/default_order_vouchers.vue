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
            <td class="cl_custom_color">直接納品先コード</td>
            <td>
              <input
                type="text"
                class="form-control topHeaderInputFieldBtn"

              />
              <button @click="deliverySearchForm1" class="btn btn-primary active">参照</button>
            </td>
            <td class="cl_custom_color">最終納品先コード</td>
            <td>
              <input type="text" class="form-control topHeaderInputFieldBtn" />
              <button @click="deliverySearchForm2" class="btn btn-primary active">参照</button>
            </td>
            <td class="cl_custom_color">伝票番号</td>
            <td>
              <input type="text" class="form-control" />
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">商品コード</td>
            <td>
              <input
                type="text"
                class="form-control topHeaderInputFieldBtn"

              />
              <button @click="deliverySearchForm3" class="btn btn-primary active">参照</button>
            </td>
            <td class="cl_custom_color">定／特</td>
            <td>
              <select class="form-control" v-model="form.fixedSpecial" style="width: 220px">
                <option value="">全て</option>
                <option :value="item" v-for="item in fixedSpecialOptionList">{{ item }}</option>
              </select>
            </td>
            <td class="cl_custom_color">確定状況</td>
            <td>
              <select class="form-control" v-model="form.situation" style="width: 220px">
              <option value="">全て</option>
                <option :value="item" v-for="item in situationOptionList">{{ item }}</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">印刷状況</td>
            <td colspan="7">
              <select class="form-control" v-model="form.printingStatus" style="width: 220px">
              <option value="">全て</option>
                <option :value="item" v-for="item in printingStatusOptionList">{{ item }}</option>
              </select>
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

      <div class="col-12">
        <div class="row">
          <div class="col-5">
            <p>
              <span class="tableRowsInfo">{{order_detail_lists.from}}〜{{order_detail_lists.to}} 件表示中／全：{{order_detail_lists.total}}件</span>
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
                <select @change="selectNumPerPage" v-model="select_field_per_page_num" class="form-control selectPage">
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
          </div>
          <div class="col-7">
            <div class="row">
              <div class="col-4" style="padding-left: 0 !important">
                <p class="mb-0">検索結果のダウンロードはこちら</p>
                <b-button
                  class="active"
                  variant="primary"
                  v-on:click="order_download"
                >
                  <b-icon
                    icon="download"
                    animation="fade"
                    font-scale="1.2"
                  ></b-icon>
                  ダウンロード</b-button
                >
              </div>
              <div class="col-3">
                <p class="mb-0">商品別の更新はこちら</p>
                <router-link to="/order_list/order_list_detail/item_search" class="active btn btn-primary">
                  商品別登録</router-link>
              </div>
              <div class="col-5">
                <b-form inline>
                  <label class="sr-only" for="inline-form-input-name"
                    >各種帳票の印刷はこちら</label
                  >
                  <select class="mb-2 mr-sm-2 mb-sm-0 form-control">
                    <option>選択してください</option>
                  </select>
                  <b-button class="active" variant="primary">印刷</b-button>
                </b-form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr />
    <div class="row">
      <div class="col-12">
        <div class="">
          <table
            class="table table-striped table-bordered order_item_details_table"
            style="overflow-x: scroll"
          >
            <thead>
            <tr class="first_heading_th">
              <th></th>
              <th><input @click="checkAll" v-model='isCheckAll' type="checkbox">全選択</th>
              <th colspan="9"></th>
            </tr>
              <tr>
                <th>No</th>
                <th>確定</th>
                <th>直接納品先 コード</th>
                <th>最終納品先</th>
                <th>伝票番号</th>
                <th>定／特</th>
                <th>原価金額 合計</th>
                <th>出荷状況</th>
                <th>最終更新日時</th>
                <th>納品明細書 印刷状況</th>
                <th>送信日時</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(order_detail_list, index) in order_detail_lists.data"
                :key="index"
              >
                <td>{{(order_detail_lists.current_page*select_field_per_page_num)-select_field_per_page_num + index+1}}</td>
                <td><span v-if="order_detail_list.decision_datetime!=null">済</span><span v-else><input  type="checkbox" v-bind:value='order_detail_list.data_shipment_voucher_id' v-model='selected' @change='updateCheckall()'></span></td>
                <td>{{ order_detail_list.mes_lis_shi_par_shi_code }}</td>
                <td>
                  {{ order_detail_list.mes_lis_shi_par_rec_code }}
                  {{ order_detail_list.mes_lis_shi_par_rec_name }}
                </td>
                <td>
                  <router-link
                    :to="{
                      name: 'order_item_list_detail',
                      params: { data_order_list_voucher_id: order_detail_list.data_shipment_voucher_id },
                    }"
                    class=""
                    >{{
                      order_detail_list.mes_lis_shi_tra_trade_number
                    }}</router-link
                  >
                </td>
                <td>
                  {{
                    order_detail_list.mes_lis_shi_tra_ins_goods_classification_code
                  }}
                </td>
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
        <div class="row">
          <div class="col-6">
            <div class="pcontent">
              <p>
                ファイルを選択し「アップロード」ボタンをクリックすると、確定済みデータとしてアップロードされます。
              </p>
            </div>
            <div class="pcontentBtom">
              <input type="file" class="form-control uploadBtn" />
              <button class="btn btn-primary active" type="button">
                <b-icon
                  icon="upload"
                  animation="fade"
                  font-scale="1.2"
                ></b-icon>
                アップロード
              </button>
            </div>
          </div>
          <div class="col-6 text-right">
            <button @click="updateDatetimeDecessionfield" class="btn btn-lg btn-primary active">
              選択行を伝票確定
            </button>
            <button class="btn btn-lg btn-danger active" @click="shipmentConfirm">確定データ送信</button>
          </div>
        </div>
      </div>
    </div>
    <b-modal
      size="lg"
      :hide-backdrop="true"
      title="発注データ修正"
      ok-title="修正"
      cancel-title="キャンセル"
      @ok.prevent="save_user()"
      v-model="edit_order_modal"
    >
      <div class="panel-body add_item_body">
        <form>
          <input
            type="hidden"
            name="vendor_item_id"
            id="vendor_item_id"
            value
          />
          <div class="row">
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3"
                    >伝票番号</span
                  >
                </div>
                <input
                  type="text"
                  class="form-control"
                  id="basic-url"
                  aria-describedby="basic-addon3"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">発注日</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  id="basic-url"
                  aria-describedby="basic-addon3"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">商品名</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  id="basic-url"
                  aria-describedby="basic-addon3"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">原価</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  id="basic-url"
                  aria-describedby="basic-addon3"
                />
              </div>
            </div>
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">JAN</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  id="basic-url"
                  aria-describedby="basic-addon3"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">納品日</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  id="basic-url"
                  aria-describedby="basic-addon3"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">規格</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  id="basic-url"
                  aria-describedby="basic-addon3"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">売価</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  id="basic-url"
                  aria-describedby="basic-addon3"
                />
              </div>
            </div>
          </div>
        </form>
      </div>
    </b-modal>
    <b-modal
      size="lg"
      :hide-backdrop="true"
      title="納品先検索"
      ok-title="検　索"
      cancel-title="閉じる"
      @ok.prevent="update_order_voucher_detail()"
      v-model="order_search_modal1"
    >
      <div class="panel-body">
        <table
          class="table orderTopDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">納品先コード</td>
            <td><input type="text" class="form-control" v-model="form.deliveryCode"/></td>
            <td class="cl_custom_color">納品先名</td>
            <td>
              <input type="text" class="form-control" v-model="form.deliveryName"/>
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">納品先形態区分</td>
            <td>
            <select class="form-control" v-model="form.deliveryDestnation" style="width: 220px">
              <option value="">全て</option>
                <option :value="item" v-for="item in deliveryDestnationOptionList">{{ item }}</option>
              </select>
            </td>
            <td class="cl_custom_color">納品可能日</td>
            <td>
              <input type="date" class="form-control" v-model="form.deliveryDate">
            </td>

          </tr>
        </table>
      </div>
    </b-modal>
    <b-modal
      size="lg"
      :hide-backdrop="true"
      title="納品先検索"
      ok-title="検　索"
      cancel-title="閉じる"
      @ok.prevent="update_order_voucher_detail()"
      v-model="order_search_modal2"
    >
      <div class="panel-body">
        <table
          class="table orderTopDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td class="cl_custom_color">納品先コード</td>
            <td><input type="text" class="form-control" v-model="form.deliveryCode"/></td>
            <td class="cl_custom_color">納品先名</td>
            <td>
              <input type="text" class="form-control" v-model="form.deliveryName"/>
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">納品先形態区分</td>
            <td>
            <select class="form-control" v-model="form.deliveryDestnation" style="width: 220px">
              <option value="">全て</option>
                <option :value="item" v-for="item in deliveryDestnationOptionList">{{ item }}</option>
              </select>
            </td>
            <td class="cl_custom_color">納品可能日</td>
            <td>
              <input type="date" class="form-control" v-model="form.deliveryDate">
            </td>

          </tr>
        </table>
      </div>
    </b-modal>
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
  // props: ["param_data"],
  data() {
    return {
      rows: 100,
      currentPage: 1,
      today: new Date().toISOString().slice(0, 10),
      sortKey: "",
      reverse: true,
      order_by: "asc",
      order_detail_lists: {},
      order_info: {},
      order_date: "",
      order_detail_list: [],
      show_hide_col_list: [],
      expected_delivery_date: "",
      status: "",
      // byr_order_id: "",
      edit_order_modal: false,
      order_search_modal1: false,
      order_search_modal2: false,
      order_search_modal3: false,
      selected: [],
      selectedNum:0,
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
      // buyer_settings:null,
    };
  },
  methods: {
    deliverySearchForm1(){
      this.order_search_modal1 = true;
    },
    deliverySearchForm2(){
      this.order_search_modal2 = true;
    },
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
    checkAll() {
      this.isCheckAll = !this.isCheckAll;
      this.selected = [];
      var temp_seleted = [];
      if (this.isCheckAll) {
        for (var key in this.order_detail_lists.data) {
          // console.log(this.order_detail_lists.data[key].data_shipment_voucher_id);
			                  this.selected.push(this.order_detail_lists.data[key].data_shipment_voucher_id);
			                }
        // this.order_detail_lists.data.forEach(function (order_detail_list) {
        //   // temp_seleted.push(order_detail_list.byr_order_detail_id);
        //   console.log(order_detail_list);
        //   this.selected.push(order_detail_list.byr_order_detail_id);
        // });
        // this.selected = temp_seleted;
      }
    },
    updateCheckall() {
      if (this.selected.length == this.order_detail_lists.data.length) {
        this.isCheckAll = true;
      } else {
        this.isCheckAll = false;
      }
    },

    update_checked_item_list() {
      var post_data = {
        selected_item: this.selected,
        user_id: Globals.user_info_id,
      };
      axios
        .post(this.BASE_URL + "api/update_byr_order_detail_status", post_data)
        .then((data) => {
          console.log(data);
          Fire.$emit("LoadByrorderDetail");
        });
    },

    exec_confirm_qty(order_detail, event) {
      if (
        parseFloat(order_detail.confirm_quantity) >
        parseFloat(order_detail.order_quantity)
      ) {
        Swal.fire({
          icon: "warning",
          title: "Invalid Confirm Quantity!",
          text: "You can not confrim order more then your order quantity!",
        });
        order_detail.confirm_quantity = order_detail.order_quantity;
      }
      if (event.key == "Enter") {
        event.preventDefault();
        console.log(event.key);
        // event.target.nextElementSibling.focus()
        // console.log(event.target.parent.closest('.lack_reasons'));
      }
    },
    sortBynumeric_valu(sortKey) {
      // this.order_detail_lists.sort((a, b) => a[sortKey] < b[sortKey] ? 1 : -1);
      if (this.order_by == "asc") {
        this.order_by = "desc";
        this.order_detail_lists.data.sort((a, b) => a[sortKey] - b[sortKey]);
      } else {
        this.order_by = "asc";
        this.order_detail_lists.data.sort((a, b) => b[sortKey] - a[sortKey]);
      }
    },
    sortByja_valu(sortKey) {
      if (this.order_by == "asc") {
        this.order_by = "desc";
        this.order_detail_lists.data.sort((a, b) =>
          a[sortKey].localeCompare(b[sortKey], "ja", {
            ignorePunctuation: true,
          })
        );
      } else {
        this.order_by = "asc";
        this.order_detail_lists.data.sort((a, b) =>
          b[sortKey].localeCompare(a[sortKey], "ja", {
            ignorePunctuation: true,
          })
        );
      }
    },
    update_shipment_detail(order_detail) {
      console.log(order_detail);
      axios({
        method: "POST",
        url: this.BASE_URL + "api/update_shipment_detail",
        data: order_detail,
      })
        .then(function (response) {
          //handle success
          console.log(response);
          Fire.$emit("LoadByrorderDetail");
        })
        .catch(function (response) {
          //handle error
          console.log(response);
        });
    },
    updateDatetimeDecessionfield() {
      this.selectedNum = this.selected.length;
      var _this=this;
      this.alert_icon = "warning";
      this.alert_title = "";
      this.alert_text = this.selectedNum+"件の伝票を確定しますがよろしいでしょうか。";
      this.yes_btn = "はい";
      this.cancel_btn = "キャンセル";
      this.confirm_sweet().then((result) => {
              if (result.value) {
                axios({
                  method: "POST",
                  url: this.BASE_URL + "api/update_shipment_detail_bycurrentdatetime",
                  data: {update_id:this.selected},
                })
                  .then(function (response) {
                    //handle success
                    _this.alert_icon='success';
                    _this.alert_title="";
                    _this.alert_text=_this.selectedNum+"件の伝票を確定しました。";
                    _this.sweet_normal_alert();
                    Fire.$emit("LoadByrorderDetail");

                  })
                  .catch(function (response) {
                    //handle error
                    console.log(response);
                  });
              }
      })
    },
    shipmentConfirm(){
      var _this=this;
      this.alert_icon = "warning";
      this.alert_title = "";
      this.alert_text = _this.selectedNum+"件の伝票を送信しますがよろしいでしょうか。";
      this.yes_btn = "はい";
      this.cancel_btn = "キャンセル";
      this.confirm_sweet().then((result) => {
              if (result.value) {
                axios.post(this.BASE_URL + "api/shipment_confirm",{data_order_id:(this.param_data.data_order_id),order_info:this.order_info}).then(({data})=>{
                //   console.log(data);
                  _this.alert_icon='success';
                    _this.alert_title="";
                    _this.alert_text=data.csv_data_count+"件の確定伝票を送信しました。";
                    _this.sweet_normal_alert();
                })
               }
      })
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
          this.loader.hide();
          console.log(this.order_detail_lists);
          // return 0;
          // // this.order_detail_lists = data.data.order_list_detail;
          // this.show_hide_col_list = data.data.slected_list;
          // this.order_date = data.data.order_list_detail[0].order_date;
          // this.expected_delivery_date =
          //   data.data.order_list_detail[0].expected_delivery_date;
          // this.status = data.data.order_list_detail[0].status;
          // this.loader.hide();
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
    edit_order_detail(order_detail_list) {
      this.edit_order_modal = true;
    },
    // order data download
    order_download() {
      console.log("order_download");
      axios
        .post(this.BASE_URL + "api/scenario_exec", {
          scenario_id: "11",
          email: "user@jacos.co.jp",
          password: "Qe75ymSr",
        })
        .then(({ data }) => {
          console.log(data);
          const url = URL.createObjectURL(new Blob([data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", "file.csv"); //ここらへんは適当に設定する
          document.body.appendChild(link);
          link.click();
          link.revokeObjectURL();
        });
    },
  },

  created() {
    Fire.$emit("byr_has_selected", this.$session.get("byr_buyer_id"));
    Fire.$emit("permission_check_for_buyer", this.$session.get("byr_buyer_id"));
    Fire.$emit("voucher_page_query_param", 'myData');
    this.$session.set('voucher_page_query_param',this.$route.query);
    // console.log(this.$route.query);
    this.param_data = this.$route.query;

    // console.log(this.param_data);
    this.loader = Vue.$loading.show();
    this.data_order_id = this.$route.params.data_order_id;
    this.get_all_byr_order_detail();
    Fire.$on("LoadByrorderDetail", () => {
      this.get_all_byr_order_detail();
    });
    this.col_show_hide_setting(this.$route.name);
  },
  mounted() {
    console.log("byr order detail page loaded");
  },
};
</script>
