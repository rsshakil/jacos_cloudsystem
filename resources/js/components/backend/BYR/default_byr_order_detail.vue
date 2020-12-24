<template>
  <div>
    <div class="row">
      <!--<div class="col-12">
        <h2 class="top_title text-center">{{ myLang.quantity_confirmed }}</h2>
      </div>-->
      <!-- <div class="col-12 text-center">
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
      </div> -->
      <div class="col-12" style="padding: 10px">
        <table class="table orderTopDetailTable table-bordered" style="width: 100%">
          <tr>
            <td class="cl_custom_color">受信日時</td>
            <td>{{order_item_lists.receive_datetime}}</td>
            <td class="cl_custom_color">取引先</td>
            <td colspan="5">{{order_item_lists.mes_lis_ord_par_sel_code}} {{order_item_lists.mes_lis_ord_par_sel_name}}</td>
          </tr>
          <tr>
            <td class="cl_custom_color">納品日</td>
            <td>{{order_item_lists.mes_lis_ord_tra_dat_delivery_date}}</td>
            <td class="cl_custom_color">部門</td>
            <td></td>
            <td class="cl_custom_color">便</td>
            <td>{{order_item_lists.mes_lis_ord_tra_goo_major_category}}</td>
            <td class="cl_custom_color">配送温度区分</td>
            <td>{{order_item_lists.mes_lis_ord_tra_ins_temperature_code}}</td>
          </tr>
        </table>
      </div>
     <!-- <div class="col-12">
        {{ myLang.voucher_list }}
        <hr />
      </div>-->
      <div class="col-12" style="background: #D8E3F0; padding: 10px">
        <table class="table orderDetailTable table-bordered" style="width: 100%">
          <tr>
            <td class="cl_custom_color">直接納品先コード</td>
            <td>
              <input type="text" class="form-control topHeaderInputFieldBtn" v-model="today" />
              <button class="btn btn-primary active">参照</button>
            </td>
            <td class="cl_custom_color">最終納品先コード</td>
            <td>
              <input type="text" class="form-control topHeaderInputFieldBtn" />
              <button class="btn btn-primary active">参照</button>
            </td>
            <td class="cl_custom_color">伝票番号</td>
            <td>
              <input type="text" class="form-control" />
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">商品コード</td>
            <td>
              <input type="text" class="form-control topHeaderInputFieldBtn" v-model="today" />
              <button class="btn btn-primary active">参照</button>
            </td>
            <td class="cl_custom_color">定／特</td>
            <td>
              <input type="text" class="form-control" />
            </td>
            <td class="cl_custom_color">確定状況</td>
            <td>
              <input type="text" class="form-control" />
            </td>
            <!--<td class="cl_custom_color">{{ myLang.temperature }}</td>
            <td>
              <input type="text" class="form-control" />
            </td>-->
          </tr>
          <tr>
            <td class="cl_custom_color">印刷状況</td>
            <td colspan="7">
              <select class="form-control" style="width:220px;">
                <option :value="0">{{ myLang.confirmation_status }}</option>
              </select>
            </td>
            
          </tr>
        </table>
      </div>
      <!--<div
        class="col-12"
        style="background: #d5dadc; padding: 10px; margin-top: 20px"
      >
        <table class="table table-bordered" style="width: 100%">
          <tr>
            <td>{{ myLang.direct_delivery_code }}</td>
            <td>
              <input type="search" class="form-control" />
            </td>
            <td>
              <button class="btn btn-primary" type="button">
                {{ myLang.search }}
              </button>
            </td>
            <td>
              {{ myLang.final_delivery_code }}
            </td>
            <td>
              <input type="search" class="form-control" v-model="today" />
            </td>
            <td>
              <button class="btn btn-primary" type="button">
                {{ myLang.search }}
              </button>
            </td>
            <td>
              
            </td>
            <td>
              <input type="search" class="form-control" v-model="today" />
            </td>
          </tr>
          <tr>
            <td>{{ myLang.product_code }}</td>
            <td>
              <input type="search" class="form-control" v-model="today" />
            </td>
            <td>
              <button class="btn btn-primary" type="button">
                {{ myLang.search }}
              </button>
            </td>
            <td>{{ myLang.specific }}</td>
            <td colspan="2">
              <select class="form-control">
                <option :value="0">{{ myLang.specific }}</option>
              </select>
            </td>
            <td>{{ myLang.confirmation_status }}</td>
            <td>
              <select class="form-control">
                <option :value="0">{{ myLang.confirmation_status }}</option>
              </select>
            </td>
          </tr>

          <tr>
            <td>{{ myLang.printing_status }}</td>
            <td>
              <select class="form-control">
                <option :value="0">{{ myLang.printing_status }}</option>
              </select>
            </td>
            <td colspan="6"></td>
          </tr>
        </table>
      </div>
      <br />-->
      <div class="col-12" style="text-align: center">
        <button class="btn btn-primary active srchBtn" type="button">
          {{ myLang.search }}
        </button>
      </div>
      <div class="col-12">
        <br />
        <h4 class="page_custom_title">{{ myLang.search_result }}</h4>
        <!--<hr class="" />-->
      </div>
      <!--<div class="col-12">
        <table class="table table-bordered">
          <tr>
            <td>
              <button type="button">{{ myLang.registrad_by_product }}</button>
            </td>
            <td>
              <select class="form-control">
                <option :value="0">{{ myLang.product_list }}</option>
              </select>
            </td>
            <td>
              <router-link
                :to="{
                  name: 'order_details_canvas',
                  params: { data_order_id: param_data.data_order_id },
                }"
                class="btn btn-info"
              >
                {{ myLang.printing }}
              </router-link>
              <button type="button">{{myLang.printing}}</button> 
            </td>
            <td>
              <button class="btn btn-outline-primary" type="button">
                <b-icon
                  icon="download"
                  animation="fade"
                  font-scale="1.2"
                ></b-icon>
                {{ myLang.download }}
              </button>
            </td>
          </tr>
        </table>
      </div>
      <div class="col-12">
        <table class="table table-bordered">
          <tr>
            <td>
              <input type="file" class="form-control" />
            </td>
            <td>
              <input type="checkbox" class="form-control" />
            </td>
            <td>
              <button class="btn btn-outline-primary" type="button">
                <b-icon
                  icon="download"
                  animation="fade"
                  font-scale="1.2"
                ></b-icon>
                {{ myLang.download }}
              </button>
            </td>
          </tr>
        </table>
      </div>-->
      <div class="col-12">
      <div class="row">
        <div class="col-5">
        <p><span class="tableRowsInfo">1〜5 件表示中／全：100件</span>
         <span class="pagi"><b-pagination v-model="currentPage" :total-rows="rows" size="sm"></b-pagination></span>
         <span class="selectPagi">
         <select class="form-control selectPage">
          <option>表示行数</option>
         </select>
         </span>
         </p>
        </div>
        <div class="col-7">
          <div class="row">
        <div class="col-4" style="padding-left:0!important">
        <p class="mb-0">検索結果のダウンロードはこちら</p>
    <b-button class="active" variant="primary">
     <b-icon
                  icon="download"
                  animation="fade"
                  font-scale="1.2"
                ></b-icon>
    ダウンロード</b-button>
        </div>
        <div class="col-3">
        
        <p class="mb-0">商品別の更新はこちら</p>
    <b-button class="active" variant="primary">
    商品別登録</b-button>
        </div>
        <div class="col-5">
         <b-form inline>
    <label class="sr-only" for="inline-form-input-name">各種帳票の印刷はこちら</label>
    <select class="mb-2 mr-sm-2 mb-sm-0 form-control"
    >
    <option>選択してください</option>
    </select>
    <b-button class="active" variant="primary">印刷</b-button>
  </b-form>
        </div>
        </div>
        </div>
      </div>
      </div>
      <div class="col-12">
        <div class="">
          <!-- <div class="row">
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
          </div> -->
          <table class="table table-striped table-bordered order_item_details_table" style="overflow-x: scroll;">
            <thead>
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
                <!-- <th>{{ myLang.direct_delivery_code }}</th>
                <th>{{ myLang.final_delivery_code }}</th>
                <th>{{ myLang.total_voucher_number }}</th>
                <th>{{ myLang.specific }}</th>
                <th>{{ myLang.total_cost_amount }}</th>
                <th>{{ myLang.shipping_status }}</th>
                <th>{{ myLang.last_modified_date }}</th>
                <th>{{ myLang.confirmation_status }}</th>
                <th>
                  {{ myLang.delivery_statement }}
                  {{ myLang.printing_status }}
                </th>
                <th>{{ myLang.send }}</th> -->
              </tr>
              <!-- <tr>
                <th colspan="100%" style="border: none;">
          
                </th>
              </tr> -->
              <!-- <tr>
                <th style="cursor: pointer"> No </th>
                <th>
                  <input type="checkbox" @click="checkAll()" v-model="isCheckAll" class="form-control check_all" />
                </th>
                
                <th style="cursor: pointer" v-if="show_hide_col_list.includes('order_type')">注文タイプ</th>
                <th style="cursor: pointer;min-width:100px;" @click="sortByja_valu('shop_name_kana')" v-if="show_hide_col_list.includes('shop_name_kana')">
                  店舗名(ｶﾅ)</th>
                <th @click="sortBynumeric_valu('category_code')" v-if="show_hide_col_list.includes('category_code')">
                  分類コード</th>
                <th style="cursor: pointer" @click="sortBynumeric_valu('voucher_category')" v-if="show_hide_col_list.includes('voucher_category')">
                  伝票区分</th>
                <th style="cursor: pointer" @click="sortBynumeric_valu('voucher_number')" v-if="show_hide_col_list.includes('voucher_number')">
                  伝票番号</th>
                <th style="cursor: pointer" v-if="show_hide_col_list.includes('list_number')">
                  明細番号</th>
                <th style="cursor: pointer" v-if="show_hide_col_list.includes('delivery_service_code')">
                  便番号</th>
                <th style="cursor: pointer" @click="sortBynumeric_valu('jan')" v-if="show_hide_col_list.includes('jan')">
                  JAN</th>
                <th style="cursor: pointer;min-width:220px" v-if="show_hide_col_list.includes('item_name')">
                  商品名 </th>
                <th style="cursor: pointer;min-width:220px" v-if="show_hide_col_list.includes('item_name_kana')">
                  商品名かな</th>
                <th style="cursor: pointer" v-if="show_hide_col_list.includes('spec')">
                  規格</th>
                <th style="cursor: pointer" v-if="show_hide_col_list.includes('spec_kana')">
                  規格かな</th>
                <th style="cursor: pointer" v-if="show_hide_col_list.includes('inputs')">
                  入数</th>
                <th style="cursor: pointer" v-if="show_hide_col_list.includes('size')">
                  サイズ</th>
                <th style="cursor: pointer;min-width:80px;" v-if="show_hide_col_list.includes('color')">
                  カラー</th>
                <th style="cursor: pointer;min-width:80px" v-if="show_hide_col_list.includes('order_lot_inputs')">
                  発注単位</th>
                <th style="cursor: pointer;;min-width:100px;" v-if="show_hide_col_list.includes('order_date')">
                  発注日時</th>
                <th style="cursor: pointer;min-width:100px;" v-if="show_hide_col_list.includes('expected_delivery_date')">
                  納品予定日</th>
                <th style="cursor: pointer" v-if="show_hide_col_list.includes('sale_category')">
                  特売区分</th>
                <th style="cursor: pointer" @click="sortBynumeric_valu('cost_unit_price')" v-if="show_hide_col_list.includes('cost_unit_price')">
                  原単価</th>
                <th style="cursor: pointer" @click="sortBynumeric_valu('cost_price')" v-if="show_hide_col_list.includes('cost_price')">
                  原価金額</th>
                <th style="cursor: pointer" v-if="show_hide_col_list.includes('selling_unit_price')">
                  売単価 </th>
                <th style="cursor: pointer" v-if="show_hide_col_list.includes('selling_price')">
                  売価金額</th>
                <th style="cursor: pointer">
                  発注数量 </th>
                <th style="cursor: pointer">
                  納品数量</th>
                <th style="cursor: pointer;min-width:80px;">
                  ステータス</th>
                <th>欠品理由</th>
                <th style="min-width:100px">数量確定</th>
                <th style="min-width:100px">発注データ修正</th>
              </tr> -->
            </thead>
            <tbody>
              <tr v-for="(order_detail_list, index) in order_detail_lists" :key="index">
                <td>{{index+1}}</td>
                <td>{{order_detail_list.decision_datetime}}</td>
                <td>{{order_detail_list.mes_lis_shi_par_shi_code}}</td>
                <td>{{order_detail_list.mes_lis_shi_par_rec_code}} {{order_detail_list.mes_lis_shi_par_rec_name}}</td>
                <td><router-link
                  :to="{
                    name: 'order_item_list_detail',
                    params: { data_order_list_voucher_id: 1 }
                  }"
                  class=""
                  >{{order_detail_list.mes_lis_shi_tra_trade_number}}</router-link></td>
                <td>{{order_detail_list.mes_lis_shi_tra_ins_goods_classification_code}}</td>
                <td>{{order_detail_list.mes_lis_shi_tot_tot_net_price_total}}</td>
                <td>{{order_detail_list.status}}</td>
                <td>{{order_detail_list.updated_at}}</td>
                <td>{{order_detail_list.print_datetime}}</td>
                <td>{{order_detail_list.send_datetime}}</td>
              </tr>
            </tbody>
            <!-- <tbody>
              <tr
                v-for="(order_detail_list, index) in order_detail_lists"
                :key="order_detail_list.byr_order_detail_id"
              >
                <td>{{ index + 1 }}</td>
                <td>
                  <input
                    type="checkbox"
                    v-model="selected"
                    :value="order_detail_list.byr_order_detail_id"
                    @change="updateCheckall()"
                    class="form-control check_item"
                  />
                </td>

                <td v-if="show_hide_col_list.includes('order_type')">
                  {{ order_detail_list.order_type }}
                </td>
                <td v-if="show_hide_col_list.includes('shop_name_kana')">
                  {{ order_detail_list.shop_name_kana }}
                </td>
                <td v-if="show_hide_col_list.includes('category_code')">
                  {{ order_detail_list.category_code }}
                </td>
                <td v-if="show_hide_col_list.includes('voucher_category')">
                  {{ order_detail_list.voucher_category }}
                </td>
                <td v-if="show_hide_col_list.includes('voucher_number')">
                  {{ order_detail_list.voucher_number }}
                </td>
                <td v-if="show_hide_col_list.includes('list_number')">
                  {{ order_detail_list.list_number }}
                </td>
                <td v-if="show_hide_col_list.includes('delivery_service_code')">
                  {{ order_detail_list.delivery_service_code }}
                </td>
                <td v-if="show_hide_col_list.includes('jan')">
                  {{ order_detail_list.jan }}
                </td>
                <td v-if="show_hide_col_list.includes('item_name')">
                  {{ order_detail_list.item_name }}
                </td>
                <td v-if="show_hide_col_list.includes('item_name_kana')">
                  {{ order_detail_list.item_name_kana }}
                </td>
                <td v-if="show_hide_col_list.includes('spec')">
                  {{ order_detail_list.spec }}
                </td>
                <td v-if="show_hide_col_list.includes('spec_kana')">
                  {{ order_detail_list.spec_kana }}
                </td>
                <td v-if="show_hide_col_list.includes('inputs')">
                  {{ order_detail_list.inputs }}
                </td>
                <td v-if="show_hide_col_list.includes('size')">
                  {{ order_detail_list.size }}
                </td>
                <td v-if="show_hide_col_list.includes('color')">
                  {{ order_detail_list.color }}
                </td>
                <td v-if="show_hide_col_list.includes('order_lot_inputs')">
                  {{ order_detail_list.order_lot_inputs }}
                </td>
                <td v-if="show_hide_col_list.includes('order_date')">
                  {{ order_detail_list.order_date }}
                </td>
                <td
                  v-if="show_hide_col_list.includes('expected_delivery_date')"
                >
                  {{ order_detail_list.expected_delivery_date }}
                </td>
                <td v-if="show_hide_col_list.includes('sale_category')">
                  {{ order_detail_list.sale_category }}
                </td>
                <td v-if="show_hide_col_list.includes('cost_unit_price')">
                  {{ order_detail_list.cost_unit_price }}
                </td>
                <td v-if="show_hide_col_list.includes('cost_price')">
                  {{ order_detail_list.cost_price }}
                </td>
                <td v-if="show_hide_col_list.includes('selling_unit_price')">
                  {{ order_detail_list.selling_unit_price }}
                </td>
                <td v-if="show_hide_col_list.includes('selling_price')">
                  {{ order_detail_list.selling_price }}
                </td>
                <td>{{ order_detail_list.order_unit_quantity }}</td>
                <td>
                  <input
                    type="text"
                    class="form_input"
                    v-on:keyup="exec_confirm_qty(order_detail_list, $event)"
                    v-model="order_detail_list.confirm_quantity"
                  />
                </td>

                <td>{{ order_detail_list.status }}</td>
                <td>
                  <input
                    type="text"
                    class="form-control lack_reasons"
                    style="width: 200px"
                    name="lack_r"
                    v-model="order_detail_list.lack_reason"
                  />
                </td>
                <td>
                  <button
                    @click="update_shipment_detail(order_detail_list)"
                    class="btn btn-primary"
                  >
                    確定
                  </button>
                </td>

                <td>
                  <button
                    @click="edit_order_detail(order_detail_list)"
                    class="btn btn-success"
                  >
                    修正
                  </button>
                </td>
              </tr>
            </tbody> -->
          </table>
        </div>

      </div>
      <div class="col-12">
      <div class="row">
        <div class="col-6">
        <div class="pcontent">
        <p>ファイルを選択し「アップロード」ボタンをクリックすると、確定済みデータとしてアップロードされます。</p>
        </div>
        <div class="pcontentBtom">
        <input type="file" class="form-control uploadBtn">
          <button class="btn btn-primary  active" type="button">
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
        <button class="btn btn-lg btn-primary active">選択行を伝票確定</button>
        <button class="btn btn-lg btn-danger active">確定データ送信</button>
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
      <!-- </div>
        </div>
      </div>-->
    </b-modal>
  </div>
</template>
<script>
export default {
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
      order_item_lists:{},
      order_date: "",
      order_detail_list: [],
      show_hide_col_list: [],
      expected_delivery_date: "",
      status: "",
      // byr_order_id: "",
      edit_order_modal: false,
      selected: [],
      isCheckAll: false,
      form: new Form({}),
      param_data:[],
      // buyer_settings:null,
    };
  },
  methods: {
    checkAll() {
      this.isCheckAll = !this.isCheckAll;
      this.selected = [];
      var temp_seleted = [];
      if (this.isCheckAll) {
        this.order_detail_lists.forEach(function (order_detail_list) {
          temp_seleted.push(order_detail_list.byr_order_detail_id);
        });
        this.selected = temp_seleted;
      }
    },
    updateCheckall() {
      if (this.selected.length == this.order_detail_lists.length) {
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
        this.order_detail_lists.sort((a, b) => a[sortKey] - b[sortKey]);
      } else {
        this.order_by = "asc";
        this.order_detail_lists.sort((a, b) => b[sortKey] - a[sortKey]);
      }
    },
    sortByja_valu(sortKey) {
      if (this.order_by == "asc") {
        this.order_by = "desc";
        this.order_detail_lists.sort((a, b) =>
          a[sortKey].localeCompare(b[sortKey], "ja", {
            ignorePunctuation: true,
          })
        );
      } else {
        this.order_by = "asc";
        this.order_detail_lists.sort((a, b) =>
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
    //get Table data
    get_all_byr_order_detail() {
      axios.post(this.BASE_URL + "api/order_details" , this.param_data)
        .then(({data}) => {
          // console.log(data);
          this.order_detail_lists = data.order_list_detail;
          this.order_item_lists = data.orderItem;
          this.loader.hide();
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
  },

  created() {
    
    Fire.$emit('byr_has_selected',this.$session.get('byr_buyer_id'));
    Fire.$emit('permission_check_for_buyer',this.$session.get('byr_buyer_id'));
    // console.log(this.$route.query);
    this.param_data=this.$route.query
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