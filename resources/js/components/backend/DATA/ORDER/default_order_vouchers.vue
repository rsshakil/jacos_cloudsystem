<template>
  <div>
    <div class="row">
    <div class="col-12">
      <div class="col-12" style="background: #d8e3f0;padding: 10px;margin-bottom:20px;">
        <table
          class="table orderDetailTable table-bordered"
          style="width: 100%"
        >

          <tr>
            <td width="10%" class="cl_custom_color">受信日時</td>
            <td width="15%"><span v-if="order_info">{{ order_info.receive_datetime }}</span></td>
            <td width="10%" class="cl_custom_color">取引先</td>
            <td width="15%">
            <span v-if="order_info">
              {{ order_info.mes_lis_shi_par_sel_code }}
              {{ order_info.mes_lis_shi_par_sel_name }}
              </span>
            </td>
            <td width="10%" class="cl_custom_color">便</td>
            <td width="15%">
            <span v-if="order_info">
              {{
                getbyrjsonValueBykeyName(
                  "mes_lis_ord_log_del_delivery_service_code",
                  order_info.mes_lis_shi_log_del_delivery_service_code,
                  "orders"
                )
              }}
              </span>
            </td>
          </tr>
          <tr>
            <td width="10%" class="cl_custom_color">納品日</td>
            <td width="15%">
            <span v-if="order_info">
            {{ order_info.mes_lis_shi_tra_dat_delivery_date }}
            </span>
            </td>
            <td width="10%" class="cl_custom_color">部門</td>
            <td width="15%">
            <span v-if="order_info">
            {{ order_info.mes_lis_shi_tra_goo_major_category }}
            </span>
            </td>

            <td width="10%" class="cl_custom_color">温度区分</td>
            <td width="15%">
            <span v-if="order_info">
              {{ order_info.mes_lis_shi_tra_ins_temperature_code }}
              {{
                getbyrjsonValueBykeyName(
                  "mes_lis_ord_tra_ins_temperature_code",
                  order_info.mes_lis_shi_tra_ins_temperature_code,
                  "orders"
                )
              }}
              </span>
            </td>
          </tr>
        </table>
      </div>
      </div>
      <div class="col-12">
      <div class="col-12" style="background: #d8e3f0; padding: 10px">
        <table
          class="table orderDetailTable table-bordered"
          style="width: 100%"
        >
          <tr>
            <td style="width:10%" class="cl_custom_color">直接納品先コード</td>
            <td style="width:15%">
              <input type="text" class="form-control topHeaderInputFieldBtn" />
              <button
                @click="deliverySearchForm1"
                class="btn btn-primary active"
              >
                参照
              </button>
            </td>
            <td style="width:10%" class="cl_custom_color">最終納品先コード</td>
            <td style="width:15%">
              <input type="text" class="form-control topHeaderInputFieldBtn" />
              <button
                @click="deliverySearchForm2"
                class="btn btn-primary active"
              >
                参照
              </button>
            </td>
            <td style="width:10%" class="cl_custom_color">伝票番号</td>
            <td style="width:15%">
              <input
                type="text"
                v-model="form.mes_lis_shi_tra_trade_number"
                class="form-control"
              />
            </td>
          </tr>
          <tr>
            <td style="width:10%" class="cl_custom_color">商品コード</td>
            <td style="width:15%">
              <input type="text" class="form-control topHeaderInputFieldBtn" />
              <button
                @click="deliverySearchForm3"
                class="btn btn-primary active"
              >
                参照
              </button>
            </td>
            <td style="width:10%" class="cl_custom_color">定／特</td>
            <td style="width:15%">
              <select
                class="form-control"
                v-model="form.fixedSpecial"

              >
                <option value="*">全て</option>

                <option
                  v-for="(opt, i) in fixedSpecialOptionList"
                  :key="i"
                  :value="Object.keys(opt)[0]"
                >
                  {{ Object.values(opt)[0] }}
                </option>
              </select>
            </td>
            <td style="width:10%" class="cl_custom_color">確定状況</td>
            <td style="width:15%">
              <select
                class="form-control"
                v-model="form.situation"

              >
                <option value="*">全て</option>
                <option :value="item" v-for="(item,i) in situationOptionList" :key="i">
                  {{ item }}
                </option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="width:10%" class="cl_custom_color">印刷状況</td>
            <td style="width:15%" colspan="7">
              <select
                class="form-control"
                v-model="form.printingStatus"

              >
                <option value="*">全て</option>
                <option :value="item" v-for="(item,i) in printingStatusOptionList" :key="i">
                  {{ item }}
                </option>
              </select>
            </td>
          </tr>
        </table>
      </div>
      </div>

      <div class="col-12" style="text-align: center">
        <button
          @click="get_all_byr_order_detail"
          class="btn btn-primary active srchBtn"
          type="button"
        >
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
              <span class="tableRowsInfo"
                >{{ order_detail_lists.from }}〜{{
                  order_detail_lists.to
                }}
                件表示中／全：{{ order_detail_lists.total }}件</span
              >
              <span class="pagi">
                <advanced-laravel-vue-paginate
                  :data="order_detail_lists"
                  :onEachSide="2"
                  previousText="<"
                  nextText=">"
                  alignment="center"
                  @paginateTo="get_all_byr_order_detail"
                />
              </span>
              <span class="selectPagi">
                <select
                  @change="selectNumPerPage"
                  v-model="select_field_per_page_num"
                  class="form-control selectPage"
                >
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
                <!--<b-button
                  class="active"
                  variant="primary"
                  v-on:click="order_details_download"
                >
                  <b-icon
                    icon="download"
                    animation="fade"
                    font-scale="1.2"
                  ></b-icon>
                  ダウンロード</b-button>-->

                <div class="btn-group">
                  <button
                    type="button"
                    class="btn btn-primary active dropdown-toggle"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <b-icon
                      icon="download"
                      animation="fade"
                      font-scale="1.2"
                    ></b-icon>
                    ダウンロード
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item" @click="order_details_download(1)" type="button" :disabled="is_disabled(order_detail_list_length>=1?true:false)">
                      CSV
                    </button>
                    <button class="dropdown-item" @click="order_details_download(2)" type="button" :disabled="is_disabled(order_detail_list_length>=1?true:false)">
                      JCA
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-3">
                <p class="mb-0">商品別の更新はこちら</p>
                <router-link
                :to="{name: 'item_search',query:item_search_q}" class="active btn btn-primary">
                  商品別登録
                </router-link
                >
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
                <th>
                  <input
                    @click="checkAll"
                    v-model="isCheckAll"
                    type="checkbox"
                  />全選択
                </th>
                <th colspan="9"></th>
              </tr>
              <tr>
                <th>No</th>
                <th>確定</th>
                <th class="pointer_class" @click="sorting('mes_lis_shi_par_shi_code')">直接納品先コード <span class="float-right" :class="iconSet('mes_lis_shi_par_shi_code')"></span></th>
                <th class="pointer_class" @click="sorting('mes_lis_shi_par_rec_code')">最終納品先 <span class="float-right" :class="iconSet('mes_lis_shi_par_rec_code')"></span></th>
                <th class="pointer_class" @click="sorting('mes_lis_shi_tra_trade_number')">伝票番号 <span class="float-right" :class="iconSet('mes_lis_shi_tra_trade_number')"></span></th>
                <th class="pointer_class" @click="sorting('mes_lis_shi_tra_ins_goods_classification_code')">定／特 <span class="float-right" :class="iconSet('mes_lis_shi_tra_ins_goods_classification_code')"></span></th>
                <th class="pointer_class" @click="sorting('mes_lis_shi_tot_tot_net_price_total')">原価金額 合計 <span class="float-right" :class="iconSet('mes_lis_shi_tot_tot_net_price_total')"></span></th>
                <th class="pointer_class" @click="sorting('status')">出荷状況 <span class="float-right" :class="iconSet('status')"></span></th>
                <th class="pointer_class" @click="sorting('updated_at')">最終更新日時 <span class="float-right" :class="iconSet('updated_at')"></span></th>
                <th class="pointer_class" @click="sorting('print_datetime')">納品明細書 印刷状況 <span class="float-right" :class="iconSet('print_datetime')"></span></th>
                <th class="pointer_class" @click="sorting('send_datetime')">送信日時 <span class="float-right" :class="iconSet('send_datetime')"></span></th>
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
                <td>
                  <span v-if="order_detail_list.decision_datetime != null">
                    <b-button pill variant="info" @click="decissionDateUpdate(order_detail_list.data_shipment_voucher_id)" :disabled="is_disabled(!order_detail_list.send_datetime)">
                      済
                    </b-button
                    >
                  </span>
                  <span v-else>
                    <input
                      type="checkbox"
                      v-bind:value="order_detail_list.data_shipment_voucher_id"
                      v-model="selected"
                      @change="updateCheckall()"
                    />
                  </span>
                </td>
                <td>{{ order_detail_list.mes_lis_shi_par_shi_code }}</td>
                <td>
                  {{ order_detail_list.mes_lis_shi_par_rec_code }}
                  {{ order_detail_list.mes_lis_shi_par_rec_name }}
                </td>
                <td>
                  <router-link
                    :to="{
                      name: 'order_item_list_detail',
                      params: {
                        data_order_list_voucher_id:
                          order_detail_list.data_shipment_voucher_id,
                      },
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
                  {{
                    getbyrjsonValueBykeyName(
                      "mes_lis_ord_tra_ins_goods_classification_code",
                      order_detail_list.mes_lis_shi_tra_ins_goods_classification_code,
                      "orders"
                    )
                  }}
                </td>
                <td class="text-right">
                  {{ order_detail_list.mes_lis_shi_tot_tot_net_price_total | priceFormat}}
                </td>
                <td>{{ order_detail_list.status }}</td>
                <td>{{ order_detail_list.updated_at }}</td>
                <td>{{ order_detail_list.print_datetime }}</td>
                <td>{{ order_detail_list.send_datetime }}</td>
              </tr>
               <tr v-if="order_detail_lists.data && order_detail_lists.data.length==0">
                <td class="text-center" colspan="11">データがありません</td>
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
              <label for="updateordershipmentcsv" class="custom-file-upload">
                <b-icon
                  icon="upload"
                  animation="fade"
                  font-scale="1.2"
                ></b-icon>
                アップロード
              </label>
              <input
                type="file"
                @change="shipmentUpdate"
                id="updateordershipmentcsv"
                class="form-control uploadBtn"
                style="display: none"
              />
              <!-- <button class="btn btn-primary active" type="button">
                <b-icon
                  icon="upload"
                  animation="fade"
                  font-scale="1.2"
                ></b-icon>
                アップロード
              </button>-->
            </div>
          </div>
          <div class="col-6 text-right">
            <button
              @click="updateDatetimeDecessionfield"
              class="btn btn-lg btn-primary active"
            >
              選択行を伝票確定
            </button>
            <button
              class="btn btn-lg btn-danger active"
              @click="shipmentConfirm"
            >
              確定データ送信
            </button>
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
          class="table orderTopDetailTable popupListTable table-bordered"
          style="width: 100%"
        >
        <tr>
          <th>NO</th>
          <th>納品先コード</th>
          <th>納品先名</th>
          <th>納品経路</th>
        </tr>
        <tr v-for="(valueItm,index) in order_search_modal1List">
        <td>{{index+1}}</td>
          <td>{{valueItm.mes_lis_shi_par_shi_code}}</td>
          <td>{{valueItm.mes_lis_shi_par_shi_name}}</td>
          <td>{{valueItm.mes_lis_shi_log_del_route_code}}
          {{
                getbyrjsonValueBykeyName(
                  "mes_lis_ord_log_del_route_code",
                  valueItm.mes_lis_shi_log_del_route_code,
                  "orders"
                )
              }}
          </td>
        </tr>
        <!--
          <tr>
            <td class="cl_custom_color">納品先コード</td>
            <td>
              <input
                type="text"
                class="form-control"
                v-model="form.deliveryCode"
              />
            </td>
            <td class="cl_custom_color">納品先名</td>
            <td>
              <input
                type="text"
                class="form-control"
                v-model="form.deliveryName"
              />
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">納品先形態区分</td>
            <td>
              <select
                class="form-control"
                v-model="form.deliveryDestnation"
                style="width: 220px"
              >
                <option value="">全て</option>
                <option :value="item" v-for="(item,i) in deliveryDestnationOptionList" :key="i"
                >
                  {{ item }}
                </option>
              </select>
            </td>
            <td class="cl_custom_color">納品可能日</td>
            <td>
              <input
                type="date"
                class="form-control"
                v-model="form.deliveryDate"
              />
            </td>
          </tr>-->
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
          class="table orderTopDetailTable popupListTable table-bordered"
          style="width: 100%"
        >
<tr>
          <th>NO</th>
          <th>納品先コード</th>
          <th>納品先名</th>
          <th>納品経路</th>
        </tr>
        <tr v-for="(valueItm,index) in order_search_modal2List">
        <td>{{index+1}}</td>
          <td>{{valueItm.mes_lis_shi_par_shi_code}}</td>
          <td>{{valueItm.mes_lis_shi_par_shi_name}}</td>
          <td>{{valueItm.mes_lis_shi_log_del_route_code}}
          {{
                getbyrjsonValueBykeyName(
                  "mes_lis_ord_log_del_route_code",
                  valueItm.mes_lis_shi_log_del_route_code,
                  "orders"
                )
              }}
          </td>
        </tr>

        <!--
          <tr>
            <td class="cl_custom_color">納品先コード</td>
            <td>
              <input
                type="text"
                class="form-control"
                v-model="form.deliveryCode"
              />
            </td>
            <td class="cl_custom_color">納品先名</td>
            <td>
              <input
                type="text"
                class="form-control"
                v-model="form.deliveryName"
              />
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">納品先形態区分</td>
            <td>
              <select
                class="form-control"
                v-model="form.deliveryDestnation"
                style="width: 220px">
                <option value="">全て</option>
                <option :value="item" v-for="(item,i) in deliveryDestnationOptionList" :key="i">
                  {{ item }}
                </option>
              </select>
            </td>
            <td class="cl_custom_color">納品可能日</td>
            <td>
              <input
                type="date"
                class="form-control"
                v-model="form.deliveryDate"
              />
            </td>
          </tr>-->
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
          class="table orderTopDetailTable popupListTable table-bordered"
          style="width: 100%"
        >

<tr>
          <th>NO</th>
          <th>納品先コード</th>
          <th>納品先名</th>
          <th>納品経路</th>
        </tr>
        <tr v-for="(valueItm,index) in order_search_modal3List">
        <td>{{index+1}}</td>
          <td>{{valueItm.mes_lis_shi_par_shi_code}}</td>
          <td>{{valueItm.mes_lis_shi_par_shi_name}}</td>
          <td>{{valueItm.mes_lis_shi_log_del_route_code}}
          {{
                getbyrjsonValueBykeyName(
                  "mes_lis_ord_log_del_route_code",
                  valueItm.mes_lis_shi_log_del_route_code,
                  "orders"
                )
              }}
          </td>
        </tr>

        <!--
          <tr>
            <td class="cl_custom_color">商品コード（発注用）</td>
            <td>
              <input
                type="text"
                class="form-control"
                v-model="form.deliveryCode"
              />
            </td>
            <td class="cl_custom_color">JANコード</td>
            <td>
              <input
                type="text"
                class="form-control"
                v-model="form.deliveryName"
              />
            </td>
          </tr>

          <tr>
            <td class="cl_custom_color">商品名</td>
            <td colspan="3"><input type="" class="form-control" /></td>
          </tr>
          <tr>
            <td class="cl_custom_color">規格</td>
            <td colspan="3"><input type="" class="form-control" /></td>
          </tr>
          <tr>
            <td class="cl_custom_color">取引先コード</td>
            <td>
              <input
                type="text"
                class="form-control"
                v-model="form.deliveryCode"
              />
            </td>
            <td class="cl_custom_color">納品先コード</td>
            <td>
              <input
                type="text"
                class="form-control"
                v-model="form.deliveryName"
              />
            </td>
          </tr>
          <tr>
            <td class="cl_custom_color">部門</td>
            <td>
              <select
                class="form-control"
                v-model="form.deliveryDestnation"
                style="width: 220px"
              >
                <option value="">全て</option>
                <option :value="item" v-for="(item,i) in deliveryDestnationOptionList" :key="i">
                  {{ item }}
                </option>
              </select>
            </td>
            <td class="cl_custom_color">不定貴区分</td>
            <td>
              <select
                class="form-control"
                v-model="form.deliveryDestnation"
                style="width: 220px">
                <option value="">全て</option>
                <option :value="item" v-for="(item,i) in deliveryDestnationOptionList" :key="i">
                  {{ item }}
                </option>
              </select>
            </td>
          </tr>-->
        </table>
      </div>
    </b-modal>
  </div>
</template>
<script>
import AdvancedLaravelVuePaginate from "advanced-laravel-vue-paginate";
import "advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css";

export default {
  components: {
    AdvancedLaravelVuePaginate,
  },
  // props: ["param_data"],
  data() {
    return {
        byr_buyer_id:null,
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
      order_detail_list_length:0,
      show_hide_col_list: [],
      expected_delivery_date: "",
      status: "",
      // byr_order_id: "",
      edit_order_modal: false,
      order_search_modal1: false,
      order_search_modal2: false,
      order_search_modal3: false,
      order_search_modal1List: [],
      order_search_modal2List: [],
      order_search_modal3List: [],
      selected: [],
      selectedNum: 0,
      select_field_page_num: 0,
      select_field_per_page_num: 10,
      isCheckAll: false,
      fixedSpecialOptionList: [
        { "01": "定番" },
        { "02": "準特価" },
        { "03": "特売" },
      ],
      situationOptionList: ["未確定あり", "確定済"],
      printingStatusOptionList: ["未印刷あり", "印刷済"],
      deliveryDestnationOptionList: ["店舗", "物流センター"],
      date_null: false,
      null_selected: [],
      not_null_selected: [],
      null_selected_message: false,
      form: new Form({
        printingStatus: "*",
        situation: "*",
        fixedSpecial: "*",
        deliveryDestnation: "",
        deliveryCode: "",
        deliveryDate: "",
        deliveryName: "",
        mes_lis_shi_tra_trade_number: "",
        sort_by:'data_shipment_voucher_id',
        sort_type:"ASC",
      }),
      param_data: [],
      item_search_q: [],
      // buyer_settings:null,
    };
  },
  methods: {
      sorting(sorted_field){
          this.form.sort_by=sorted_field;
          this.form.sort_type=this.form.sort_type=="ASC"?"DESC":"ASC";
          this.get_all_byr_order_detail();

      },
    deliverySearchForm1() {
      this.order_search_modal1 = true;
      axios.post(this.BASE_URL + "api/get_voucher_detail_popup1", this.$route.query)
        .then(({ data }) => {
            console.log(data);
            this.order_search_modal1List = data.popUpList;
        });
    },
    deliverySearchForm2() {
      this.order_search_modal2 = true;
      axios.post(this.BASE_URL + "api/get_voucher_detail_popup2", this.$route.query)
        .then(({ data }) => {
            console.log(data);
            this.order_search_modal2List = data.popUpList;
        });
    },
    deliverySearchForm3() {
      this.order_search_modal3 = true;
      axios.post(this.BASE_URL + "api/get_voucher_detail_popup3", this.$route.query)
        .then(({ data }) => {
            console.log(data);
            this.order_search_modal3List = data.popUpList;
        });
    },
    selectNumPage() {
      if (this.select_field_page_num != 0) {
        this.get_all_byr_order_detail(this.select_field_page_num);
      }
    },
    selectNumPerPage() {

      if (this.select_field_per_page_num != 0) {
        Fire.$emit("LoadByrorderDetail",this.select_field_page_num);
        // this.get_all_byr_order_detail(this.select_field_page_num);
      }
    },
    checkAll() {
      this.isCheckAll = !this.isCheckAll;
      this.selected = [];
      this.null_selected = [];
      this.not_null_selected = [];

      if (this.isCheckAll) {
        for (var key in this.order_detail_lists.data) {
          //   this.selected.push(
          //     this.order_detail_lists.data[key].data_shipment_voucher_id
          //   );
          if (this.order_detail_lists.data[key].decision_datetime) {
            this.not_null_selected.push(
              this.order_detail_lists.data[key].data_shipment_voucher_id
            );
          } else {
            this.null_selected.push(
              this.order_detail_lists.data[key].data_shipment_voucher_id
            );
          }
        }
      }

      if (
        this.null_selected.length <= this.select_field_per_page_num &&
        this.null_selected.length != 0
      ) {
        this.date_null = false;
        this.selected = this.null_selected;
        this.null_selected_message = true;
      } else if (
        this.not_null_selected.length <= this.select_field_per_page_num &&
        this.not_null_selected.length != 0
      ) {
        this.date_null = true;
        this.selected = this.not_null_selected;
        this.null_selected_message = false;
      }
    },
    updateCheckall() {

      if (this.selected.length == this.order_detail_lists.data.length) {
        this.isCheckAll = true;
      } else {
        this.isCheckAll = false;
      }
      this.null_selected = this.selected;
      this.null_selected_message = true;
      this.date_null = false;
    },

    update_checked_item_list() {
      var post_data = {
        selected_item: this.selected,
        user_id: Globals.user_info_id,
      };
      axios
        .post(this.BASE_URL + "api/update_byr_order_detail_status", post_data)
        .then(({data}) => {
          this.init(data.status);
          Fire.$emit("LoadByrorderDetail",this.select_field_page_num);
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

      axios({
        method: "POST",
        url: this.BASE_URL + "api/update_shipment_detail",
        data: order_detail,
      })
        .then(({data})=> {
          this.init(data.status);
          Fire.$emit("LoadByrorderDetail",this.select_field_page_num);
        })
        .catch(function (response) {

        });
    },
    decissionDateUpdate(data_shipment_voucher_id) {
      if (this.isCheckAll) {
        this.alert_text =
          "対象となる伝票確定を取消しますがよろしいでしょうか。";
        this.selected = this.null_selected.concat(this.not_null_selected);
      } else {
        this.selected.push(data_shipment_voucher_id);
        this.alert_text = "伝票確定を取消しますがよろしいでしょうか。";
      }
      this.date_null = true;
      this.null_selected_message = false;
      this.updateBuyerDecissionDateTime();
    },
    updateDatetimeDecessionfield() {
      if (this.null_selected.length > 0) {
        this.alert_text =
          this.selected.length + "件の伝票を確定しますがよろしいでしょうか。";
        this.updateBuyerDecissionDateTime();
      } else {
        this.alert_icon = "warning";
        this.alert_title = "";
        this.
        this.alert_text =
          "対象となる伝票がありません、再度確認して実行してください。";
          this.confirmButtonText = '完了';
        this.sweet_normal_alert();
      }
    },
    updateBuyerDecissionDateTime() {
      var _this = this;
      this.alert_icon = "warning";
      this.alert_title = "";
      this.yes_btn = "はい";
      this.cancel_btn = "キャンセル";
      this.selectedNum = this.selected.length;
      if (this.selectedNum > 0) {
        this.confirm_sweet().then((result) => {
          if (result.value) {
            axios
              .post(
                this.BASE_URL + "api/update_shipment_detail_bycurrentdatetime",
                { update_id: this.selected, date_null: this.date_null }
              )
              .then(({ data }) => {
                  this.init(data.status);
                _this.alert_icon = "success";
                _this.alert_title = "";
                _this.alert_text =
                  _this.selectedNum + "件の伝票を確定しました。";
                if (!this.null_selected_message) {
                  _this.alert_text = "伝票確定を取消しました。";
                }
                _this.sweet_normal_alert();
                Fire.$emit("LoadByrorderDetail",_this.select_field_page_num);
                this.selected = [];
                // this.date_null = false;
                this.isCheckAll = false;
                this.null_selected_message = false;
              })
              .catch(function (response) {

              });
          } else {
            this.selected = [];
            this.isCheckAll = false;
            this.null_selected_message = false;
          }
        });
      } else {
        this.null_selected_message = false;
        this.alert_text = "対象となる伝票がありません、再度確認して実行してください。";
        this.confirmButtonText = '完了';
        this.sweet_normal_alert();
      }
    },
    shipmentConfirm() {
      var _this = this;
      this.alert_icon = "warning";
      this.alert_title = "";
      this.yes_btn = "はい";
      this.cancel_btn = "キャンセル";
      axios.post(this.BASE_URL + "api/shipment_confirm", {
          data_order_id: this.param_data.data_order_id,
          order_info: this.order_info,
          data_count: true,
        }).then(({ data }) => {
            this.init(data.status);
          let csv_data_count = data.csv_data_count;
          if (csv_data_count > 0) {
            _this.alert_text = csv_data_count + "件の伝票を送信しますがよろしいでしょうか。";
            this.confirm_sweet().then((result) => {
              if (result.value) {

                axios.post(this.BASE_URL + "api/shipment_confirm", {
                    data_order_id: this.param_data.data_order_id,
                    order_info: this.order_info,
                    data_count: false,
                  })
                  .then(({ data }) => {
                      this.init(data.status);
                    _this.alert_icon = "success";
                    _this.alert_title = "";
                    _this.alert_text =
                      data.csv_data_count + "件の確定伝票を送信しました。";
                    _this.sweet_normal_alert();
                    Fire.$emit("LoadByrorderDetail",_this.select_field_page_num);
                  });
              }
            });
          } else {
            _this.alert_text = "対象となる伝票がありません、再度確認して実行してください。";
            _this.confirmButtonText = '完了';
            _this.sweet_normal_alert();
          }
        });
    },
    shipmentUpdate(e) {
      var _this = this;
      this.alert_icon = "warning";
      this.alert_title = "出荷データアップロード";
      this.alert_text = "アップロードファイルで更新してよろしいでしょうか？";
    //   this.alert_text = _this.selectedNum + "件の伝票を送信しますがよろしいでしょうか。";
      this.yes_btn = "はい";
      this.cancel_btn = "キャンセル";
      this.confirm_sweet().then((result) => {
        if (result.value) {
          const formData = new FormData();
          let file = e.target.files[0];

          formData.append("file", file);
          formData.append("byr_buyer_id", _this.byr_buyer_id);
          axios.post(this.BASE_URL + "api/shipment_update", formData)
            .then(({ data }) => {
                this.init(data.status);
                if (data.status==0) {
                    _this.alert_icon = "error";
                }else{
                    _this.alert_icon = "success";
                }
              _this.alert_title = "";
              _this.confirmButtonText = '完了';
              _this.alert_text = '出荷データアップロード';
              _this.sweet_normal_alert();
              e.target.value = '';
            });
        }else{
            e.target.value = '';
        }
      });
    },
    //get Table data
    get_all_byr_order_detail(page = 1) {
      this.param_data["page"] = page;
      this.param_data["per_page"] = this.select_field_per_page_num;
      this.param_data["form_search"] = this.form;
      this.select_field_page_num = page;
      axios
        .post(this.BASE_URL + "api/order_details", this.param_data)
        .then(({ data }) => {
          this.init(data.status);
          this.order_detail_lists = data.order_list_detail;
          this.order_info = data.order_info;
          this.order_detail_list_length=this.order_detail_lists.data.length
          this.$session.set("order_info",this.order_info)
          this.loader.hide();
        });
    },


    edit_order_detail(order_detail_list) {
      this.edit_order_modal = true;
    },
    // order data download
    order_details_download(downloadType = 1) {
      //downloadcsvshipment_confirm
      var _this = this;
    //   this.order_info["form_search"] = this.form;
      axios
        .post(this.BASE_URL + "api/downloadcsvshipment_confirm", {
          data_order_id: this.param_data.data_order_id,
          order_info: this.order_info,
          downloadType: downloadType,
          form_search:this.form,
        })
        .then(({ data }) => {
           this.init(data.status);
            this.downloadFromUrl(data);
        });
    },
  },

  created() {
    // this.byr_session_check()
    this.byr_buyer_id=this.$session.get("byr_buyer_id");
    Fire.$emit("byr_has_selected", this.byr_buyer_id);
    Fire.$emit("permission_check_for_buyer", this.byr_buyer_id);

    this.param_data = this.$route.query;
    this.item_search_q = this.$route.query;
    // console.log(this.param_data);
  this.$session.set("order_param_data",this.param_data)
    this.loader = Vue.$loading.show();
    // this.data_order_id = this.$route.params.data_order_id;
    this.get_all_byr_order_detail();
    Fire.$on("LoadByrorderDetail", (page=1) => {
      this.get_all_byr_order_detail(page);
    });
    Fire.$emit("loadPageTitle", "受注伝票一覧");
  },
  mounted() {
  },
};
</script>
