<template>
  <div>
    <div class="row">
      <div class="col-12">
        <h2 class="top_title text-center">数量確定</h2>
      </div>
      <div class="col-12 text-center">
        <div class="row">
          <div class="col"></div>
          <div class="col-3">
            <div class="card mb-4 box-shadow">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">発注日</h4>
              </div>
              <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div>
                  <div class="form-group mb-0">
                    <input
                      type="text"
                      v-model="order_date"
                      name="order_date"
                      value
                      class="form-control text-center"
                      id="order_date"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-3">
            <div class="card mb-4 box-shadow">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">納品日</h4>
              </div>
              <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div>
                  <div class="form-group mb-0">
                    <input
                      type="text"
                      v-model="expected_delivery_date"
                      name="delivery_date"
                      value
                      class="form-control text-center"
                      id="delivery_date"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-3">
            <div class="card mb-4 box-shadow">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">ステータス</h4>
              </div>
              <div class="card-body p-0 d-flex flex-column justify-content-between">
                <div>
                  <div class="form-group mb-0">
                    <input
                      type="text"
                      v-model="status"
                      name="delivery_date"
                      value
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
      <div class="col-12">
        <div class>
          <div class="row">
            <div class="col-6">
              <button class="btn btn-primary">ピッキング表 出力</button>
              <button class="btn btn-danger" @click="update_checked_item_list">すべて確定</button>
              <router-link :to="{name:'order_details_canvas',params:{byr_order_id:byr_order_id} }" class="btn btn-success">伝票出力</router-link>
              <button class="btn btn-info">確定送信</button>
            </div>
            <div class="col-6 text-right">
              <button class="btn btn-warning">受注データ 出力</button>
              <button class="btn btn-dark">確定データ 取込</button>
              <a href="index.html" class="btn btn-primary">発注データ一覧へ戻る</a>
            </div>
          </div>
          <table class="table table-striped table-bordered data_table">
            <thead>
              <tr>
                <th colspan="100%" style="border: none;">
          
                </th>
              </tr>
              <tr>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="id"
                  style="cursor: pointer"
                  
                >
                  No
                  <span id="id_icon"></span>
                </th>
                <th>
                  <input type="checkbox" @click="checkAll()" v-model="isCheckAll" class="form-control check_all" />
                </th>
                
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"  
                  v-if="show_hide_col_list.includes('order_type')"
                >
                  注文タイプ
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer;min-width:100px;"
                  @click="sortByja_valu('shop_name_kana')"
                   v-if="show_hide_col_list.includes('shop_name_kana')"
                >
                  店舗名(ｶﾅ)
                  <span id="total_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                 @click="sortBynumeric_valu('category_code')"
                  v-if="show_hide_col_list.includes('category_code')"
                >
                  分類コード
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                  @click="sortBynumeric_valu('voucher_category')"
                  v-if="show_hide_col_list.includes('voucher_category')"
                >
                  伝票区分
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                  @click="sortBynumeric_valu('voucher_number')"
                  v-if="show_hide_col_list.includes('voucher_number')"
                >
                  伝票番号
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                  
                  v-if="show_hide_col_list.includes('list_number')"
                >
                  明細番号
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                 
                  v-if="show_hide_col_list.includes('delivery_service_code')"
                >
                  便番号
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                  @click="sortBynumeric_valu('jan')"
                  v-if="show_hide_col_list.includes('jan')"
                >
                  JAN
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer;min-width:220px"
                 
                  v-if="show_hide_col_list.includes('item_name')"
                >
                  商品名
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer;min-width:220px"
                 
                  v-if="show_hide_col_list.includes('item_name_kana')"
                >
                  商品名かな
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                  
                  v-if="show_hide_col_list.includes('spec')"
                >
                  規格
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                 
                  v-if="show_hide_col_list.includes('spec_kana')"
                >
                  規格かな
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                  
                  v-if="show_hide_col_list.includes('inputs')"
                >
                  入数
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                 
                  v-if="show_hide_col_list.includes('size')"
                >
                  サイズ
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer;min-width:80px;"
                  
                  v-if="show_hide_col_list.includes('color')"
                >
                  カラー
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer;min-width:80px"
                  
                  v-if="show_hide_col_list.includes('order_lot_inputs')"
                >
                  発注単位
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer;;min-width:100px;"
                 
                  v-if="show_hide_col_list.includes('order_date')"
                >
                  発注日時
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer;min-width:100px;"
                  
                  v-if="show_hide_col_list.includes('expected_delivery_date')"
                >
                  納品予定日
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                  
                  v-if="show_hide_col_list.includes('sale_category')"
                >
                  特売区分
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                 @click="sortBynumeric_valu('cost_unit_price')"
                  v-if="show_hide_col_list.includes('cost_unit_price')"
                >
                  原単価
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                 @click="sortBynumeric_valu('cost_price')"
                  v-if="show_hide_col_list.includes('cost_price')"
                >
                  原価金額
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                 
                  v-if="show_hide_col_list.includes('selling_unit_price')"
                >
                  売単価
                  <span id="name_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="name"
                  style="cursor: pointer"
                  
                  v-if="show_hide_col_list.includes('selling_price')"
                >
                  売価金額
                  <span id="name_icon"></span>
                </th>
               
                
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                  
                >
                  発注数量
                  <span id="total_icon"></span>
                </th>
                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer"
                  
                >
                  納品数量
                  <span id="total_icon"></span>
                </th>

                <th
                  class="sorting"
                  data-sorting_type="asc"
                  data-column_name="email"
                  style="cursor: pointer;min-width:80px;"
                 
                >
                  ステータス
                  <span id="email_icon"></span>
                </th>
                
                <th>欠品理由</th>
                <th style="min-width:100px">数量確定</th>
                <th style="min-width:100px">発注データ修正</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(order_detail_list,index) in order_detail_lists"
                :key="order_detail_list.byr_order_detail_id"
              >
                <td>{{index+1}}</td>
                <td>
                  <input type="checkbox" v-model="selected" :value="order_detail_list.byr_order_detail_id" @change="updateCheckall()" class="form-control check_item" />
                </td>
                
                <td
                  v-if="show_hide_col_list.includes('order_type')"
                >{{order_detail_list.order_type}}</td>
                <td v-if="show_hide_col_list.includes('shop_name_kana')">{{order_detail_list.shop_name_kana}}</td>
                <td
                  v-if="show_hide_col_list.includes('category_code')"
                >{{order_detail_list.category_code}}</td>
                <td
                  v-if="show_hide_col_list.includes('voucher_category')"
                >{{order_detail_list.voucher_category}}</td>
                <td
                  v-if="show_hide_col_list.includes('voucher_number')"
                >{{order_detail_list.voucher_number}}</td>
                <td
                  v-if="show_hide_col_list.includes('list_number')"
                >{{order_detail_list.list_number}}</td>
                <td
                  v-if="show_hide_col_list.includes('delivery_service_code')"
                >{{order_detail_list.delivery_service_code}}</td>
                <td v-if="show_hide_col_list.includes('jan')">{{order_detail_list.jan}}</td>
                <td
                  v-if="show_hide_col_list.includes('item_name')"
                >{{order_detail_list.item_name}}</td>
                <td
                  v-if="show_hide_col_list.includes('item_name_kana')"
                >{{order_detail_list.item_name_kana}}</td>
                <td v-if="show_hide_col_list.includes('spec')">{{order_detail_list.spec}}</td>
                <td v-if="show_hide_col_list.includes('spec_kana')">{{order_detail_list.spec_kana}}</td>
                <td v-if="show_hide_col_list.includes('inputs')">{{order_detail_list.inputs}}</td>
                <td v-if="show_hide_col_list.includes('size')">{{order_detail_list.size}}</td>
                <td v-if="show_hide_col_list.includes('color')">{{order_detail_list.color}}</td>
                <td
                  v-if="show_hide_col_list.includes('order_lot_inputs')"
                >{{order_detail_list.order_lot_inputs}}</td>
                <td
                  v-if="show_hide_col_list.includes('order_date')"
                >{{order_detail_list.order_date}}</td>
                <td
                  v-if="show_hide_col_list.includes('expected_delivery_date')"
                >{{order_detail_list.expected_delivery_date}}</td>
                <td
                  v-if="show_hide_col_list.includes('sale_category')"
                >{{order_detail_list.sale_category}}</td>
                <td
                  v-if="show_hide_col_list.includes('cost_unit_price')"
                >{{order_detail_list.cost_unit_price}}</td>
                <td
                  v-if="show_hide_col_list.includes('cost_price')"
                >{{order_detail_list.cost_price}}</td>
                <td
                  v-if="show_hide_col_list.includes('selling_unit_price')"
                >{{order_detail_list.selling_unit_price}}</td>
                <td
                  v-if="show_hide_col_list.includes('selling_price')"
                >{{order_detail_list.selling_price}}</td>
                <td>{{order_detail_list.order_unit_quantity}}</td>
                <td>
                  <input
                    type="text"
                    class="form_input" v-on:keyup="exec_confirm_qty(order_detail_list,$event)"
                    v-model="order_detail_list.confirm_quantity"/>
                </td>
                
                <td>{{order_detail_list.status}}</td>
                <td><input type="text" class="form-control lack_reasons" style="width:200px" name="lack_r" v-model="order_detail_list.lack_reason"></td>
                <td>
                  <button @click="update_shipment_detail(order_detail_list)" class="btn btn-primary">確定</button>
                </td>
                
                <td>
                  <button
                    @click="edit_order_detail(order_detail_list)"
                    class="btn btn-success"
                  >修正</button>
                </td>
              </tr>
            </tbody>
          </table>
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
      <!-- <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
      <div class="modal-body">-->
      <div class="panel-body add_item_body">
        <form>
          <input type="hidden" name="vendor_item_id" id="vendor_item_id" value />
          <div class="row">
            <div class="col-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon3">伝票番号</span>
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
      <!-- </div>
        </div>
      </div>-->
    </b-modal>
  </div>
</template>
<script>
export default {
  data() {
    return {
      sortKey: '',
      reverse:true,
      order_by:'asc',
      order_detail_lists: {},
      order_date: "",
      order_detail_list: [],
      show_hide_col_list: [],
      expected_delivery_date: "",
      status: "",
      byr_order_id: "",
      edit_order_modal: false,
      selected: [],
      isCheckAll: false,
      form: new Form({})
    };
  },
  methods: {

checkAll(){

      this.isCheckAll = !this.isCheckAll;
      this.selected = [];
      var temp_seleted = [];
      if(this.isCheckAll){
this.order_detail_lists.forEach(function (order_detail_list) {
                        temp_seleted.push(order_detail_list.byr_order_detail_id);
                    });
                    this.selected = temp_seleted;

      }
    },
    updateCheckall(){
      if(this.selected.length == this.order_detail_lists.length){
         this.isCheckAll = true;
      }else{
         this.isCheckAll = false;
      }
    },

update_checked_item_list(){
var post_data = {
          selected_item: this.selected,
          user_id: Globals.user_info_id
        };
        axios
          .post(this.BASE_URL + "api/update_byr_order_detail_status", post_data)
          .then(data => {
            console.log(data);
            Fire.$emit('LoadByrorderDetail');
          });
},

    exec_confirm_qty(order_detail,event){
      if(parseFloat(order_detail.confirm_quantity)>parseFloat(order_detail.order_quantity)){
        Swal.fire({
            icon: 'warning',
            title: 'Invalid Confirm Quantity!',
            text: 'You can not confrim order more then your order quantity!'
        });
                order_detail.confirm_quantity=order_detail.order_quantity
      }
      if(event.key=='Enter'){
        event.preventDefault()
        console.log(event.key);
        // event.target.nextElementSibling.focus()
        // console.log(event.target.parent.closest('.lack_reasons'));
      }
    },
    sortBynumeric_valu(sortKey){
      
      // this.order_detail_lists.sort((a, b) => a[sortKey] < b[sortKey] ? 1 : -1);
      if(this.order_by=='asc'){
        this.order_by='desc';
        this.order_detail_lists.sort((a, b) => a[sortKey]-b[sortKey]);
      }else{
         this.order_by='asc';
        this.order_detail_lists.sort((a, b) => b[sortKey]-a[sortKey]);
      }
      
    },
    sortByja_valu(sortKey){
      if(this.order_by=='asc'){
        this.order_by='desc';
        this.order_detail_lists.sort( (a, b) => a[sortKey].localeCompare(b[sortKey], 'ja', {ignorePunctuation: true}));
      }else{
         this.order_by='asc';
        this.order_detail_lists.sort((a, b) =>  b[sortKey].localeCompare(a[sortKey], 'ja', {ignorePunctuation: true}));
      }
    },
    update_shipment_detail(order_detail){
      console.log(order_detail);
      axios({
    method: 'POST',
    url: this.BASE_URL + "api/update_shipment_detail",
    data: order_detail
    })
    .then(function (response) {
        //handle success
        console.log(response);
       Fire.$emit('LoadByrorderDetail');
    })
    .catch(function (response) {
        //handle error
        console.log(response);
    });
    },
    //get Table data
    get_all_byr_order_detail() {
      axios
        .get(this.BASE_URL + "api/byrorders/" + this.byr_order_id)
        .then(data => {
          console.log(data.data.order_list_detail);
          this.order_detail_lists = data.data.order_list_detail;
          this.show_hide_col_list = data.data.slected_list;
          this.order_date = data.data.order_list_detail[0].order_date;
          this.expected_delivery_date =
            data.data.order_list_detail[0].expected_delivery_date;
          this.status = data.data.order_list_detail[0].status;
        });
    },

    col_show_hide_setting(url_slug) {
      console.log(this.show_hide_col_list.length + "col lenght");
      if (this.show_hide_col_list.length == 0) {
        var post_data = {
          url_slug: url_slug,
          user_id: Globals.user_info_id
        };
        axios
          .post(this.BASE_URL + "api/tblecolsetting", post_data)
          .then(data => {
            console.log(data);
          });
      }
    },
    edit_order_detail(order_detail_list) {
      this.edit_order_modal = true;
    }
  },

  created() {
    this.byr_order_id = this.$route.params.byr_order_id;
    this.get_all_byr_order_detail();
    Fire.$on("LoadByrorderDetail", () => {
      this.get_all_byr_order_detail();
    });
    this.col_show_hide_setting(this.$route.name);
  },
  mounted() {
    console.log("byr order detail page loaded");
  }
};
</script>