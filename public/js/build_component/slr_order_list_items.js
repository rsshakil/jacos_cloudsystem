(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["slr_order_list_items"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  // props: ["param_data"],
  breadcrumb: function breadcrumb() {
    return {
      label: this.breadcumbtitle,
      parent: this.parent
    };
  },
  data: function data() {
    return {
      breadcumbtitle: "受注伝票明細",
      parent: {
        name: "slr_order_list_details",
        query: {}
      },
      today: new Date().toISOString().slice(0, 10),
      sortKey: "",
      reverse: true,
      order_by: "asc",
      order_detail_lists: {},
      order_detail_list_paginates: {},
      order_item_detail_lists: [],
      order_item_lists: {},
      order_item_shipment_data_headTable: {},
      order_date: "",
      order_detail_list: [],
      show_hide_col_list: [],
      expected_delivery_date: "",
      data_order_voucher_id: "",
      mes_lis_shi_tot_tot_net_price_total: 0,
      mes_lis_shi_tot_tot_selling_price_total: 0,
      totalCostPrice: 0,
      totalSellingPrice: 0,
      status: "",
      // byr_order_id: "",
      edit_order_modal: false,
      selected: [],
      isCheckAll: false,
      form: new Form({}),
      paginate_q: {},
      param_data: [],
      queryData: "",
      byr_buyer_id: null
    };
  },
  beforeCreate: function beforeCreate() {
    if (!this.$session.exists()) {
      this.$router.push("/home");
    }
  },
  methods: {
    get_prev_next_list: function get_prev_next_list() {
      var _this2 = this;

      this.paginate_q.page = 1;
      this.paginate_q.per_page = 1;
      this.paginate_q.order_info = this.$session.get("order_param_data");
      axios.post(this.BASE_URL + "api/order_detail_paginations", this.paginate_q).then(function (_ref) {
        var data = _ref.data;
        _this2.order_detail_list_paginates = data.order_list_detail;
      });
    },
    ball_case_cal: function ball_case_cal(order_item_detail_list, field_type) {
      if (field_type == "ケース") {
        // order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity=order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units*order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity;
        if (order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units > order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units) {
          order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units = order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units;
        }

        order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity = order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units * order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple;
      } else {
        // var calval=order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity/order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity;
        var calval = order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity / order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple;

        if (calval > 0 && calval % 1 === 0) {
          if (calval > order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units) {
            calval = order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units;
            order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity = calval * order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple;
          }

          order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units = calval;
        }
      }

      this.checkUpdateDeliveryStatus();
    },
    checkUpdateDeliveryStatus: function checkUpdateDeliveryStatus() {
      var caseBallQtycheck = [];
      var allIsZero = [];
      var allIsNotZero = [];
      var allIsZeroNotZero = [];
      var totalRows = this.order_item_detail_lists.length;
      this.order_item_detail_lists.forEach(function (order_item_detail_listData) {
        if (order_item_detail_listData.mes_lis_shi_lin_qua_shi_quantity == 0) {
          allIsZero.push(0);
        } else {
          allIsNotZero.push(1);
        }
      });
      this.order_item_shipment_data_headTable.status = "一部未納";

      if (totalRows == allIsZero.length) {
        this.order_item_shipment_data_headTable.status = "未納";
      }

      if (totalRows == allIsNotZero.length) {
        this.order_item_shipment_data_headTable.status = "完納";
      }
    },
    checkValidate: function checkValidate() {
      var _this = this;

      var isValidate = 1;
      this.order_item_detail_lists.forEach(function (value, index) {
        if (value.mes_lis_shi_lin_qua_shi_num_of_order_units != value.mes_lis_shi_lin_qua_ord_num_of_order_units && value.mes_lis_shi_lin_qua_sto_reason_code == "00") {
          _this.alert_icon = "error";
          _this.alert_title = "";
          _this.alert_text = "入力データが不正です。入力値を確認してください。";

          _this.sweet_normal_alert();

          isValidate = 0;
          return isValidate;
        }

        if (value.mes_lis_shi_lin_qua_shi_num_of_order_units == value.mes_lis_shi_lin_qua_ord_num_of_order_units && value.mes_lis_shi_lin_qua_sto_reason_code != "00") {
          _this.alert_icon = "error";
          _this.alert_title = "";
          _this.alert_text = "入力データが不正です。入力値を確認してください。";

          _this.sweet_normal_alert();

          isValidate = 0;
          return isValidate;
        }
      });
      return isValidate;
    },
    checkAll: function checkAll() {
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
    updateCheckall: function updateCheckall() {
      if (this.selected.length == this.order_detail_lists.length) {
        this.isCheckAll = true;
      } else {
        this.isCheckAll = false;
      }
    },
    update_checked_item_list: function update_checked_item_list() {
      var post_data = {
        selected_item: this.selected,
        user_id: Globals.user_info_id
      };
      axios.post(this.BASE_URL + "api/update_byr_order_detail_status", post_data).then(function (_ref2) {
        var data = _ref2.data;
        Fire.$emit("LoadByrorderDetail");
      });
    },
    exec_confirm_qty: function exec_confirm_qty(order_detail, event) {
      if (parseFloat(order_detail.confirm_quantity) > parseFloat(order_detail.order_quantity)) {
        Swal.fire({
          icon: "warning",
          title: "Invalid Confirm Quantity!",
          text: "You can not confrim order more then your order quantity!"
        });
        order_detail.confirm_quantity = order_detail.order_quantity;
      }

      if (event.key == "Enter") {
        event.preventDefault();
      }
    },
    sortBynumeric_valu: function sortBynumeric_valu(sortKey) {
      // this.order_detail_lists.sort((a, b) => a[sortKey] < b[sortKey] ? 1 : -1);
      if (this.order_by == "asc") {
        this.order_by = "desc";
        this.order_detail_lists.sort(function (a, b) {
          return a[sortKey] - b[sortKey];
        });
      } else {
        this.order_by = "asc";
        this.order_detail_lists.sort(function (a, b) {
          return b[sortKey] - a[sortKey];
        });
      }
    },
    sortByja_valu: function sortByja_valu(sortKey) {
      if (this.order_by == "asc") {
        this.order_by = "desc";
        this.order_detail_lists.sort(function (a, b) {
          return a[sortKey].localeCompare(b[sortKey], "ja", {
            ignorePunctuation: true
          });
        });
      } else {
        this.order_by = "asc";
        this.order_detail_lists.sort(function (a, b) {
          return b[sortKey].localeCompare(a[sortKey], "ja", {
            ignorePunctuation: true
          });
        });
      }
    },
    update_shipment_detail: function update_shipment_detail(order_detail) {
      axios({
        method: "POST",
        url: this.BASE_URL + "api/update_shipment_detail",
        data: order_detail
      }).then(function (_ref3) {
        var data = _ref3.data;
        Fire.$emit("LoadByrorderDetail");
      })["catch"](function (response) {});
    },
    //get Table data
    move_next_prev: function move_next_prev(id) {
      this.data_order_voucher_id = id;
      this.get_all_byr_order_item_detail();
    },
    get_all_byr_order_item_detail: function get_all_byr_order_item_detail() {
      var _this3 = this;

      axios.get(this.BASE_URL + "api/order_item_details/" + this.data_order_voucher_id).then(function (_ref4) {
        var data = _ref4.data;
        _this3.order_item_detail_lists = data.order_item_list_detail;
        _this3.mes_lis_shi_tot_tot_net_price_total = data.order_item_list_detail[0].mes_lis_shi_tot_tot_net_price_total;
        _this3.mes_lis_shi_tot_tot_selling_price_total = data.order_item_list_detail[0].mes_lis_shi_tot_tot_selling_price_total;
        _this3.order_item_lists = data.orderItem;
        _this3.order_item_shipment_data_headTable = data.order_item_list_detail[0]; // console.log(this.order_item_shipment_data_headTable);
        // console.log(this.order_item_lists);

        _this3.loader.hide();
      });
    },
    edit_order_detail: function edit_order_detail(order_detail_list) {
      this.edit_order_modal = true;
    }
  },
  created: function created() {
    var _this4 = this;

    // this.byr_buyer_id = this.$session.get("byr_buyer_id");
    // Fire.$emit("byr_has_selected", this.$session.get("byr_buyer_id"));
    // Fire.$emit("permission_check_for_buyer", this.$session.get("byr_buyer_id"));
    this.getbuyerJsonSettingvalue(); // this.param_data = this.$route.query;

    this.loader = Vue.$loading.show();
    this.data_order_voucher_id = this.$route.query.voucher_id;
    this.get_all_byr_order_item_detail();
    Fire.$on("LoadByrorderItemDetail", function () {
      _this4.get_all_byr_order_item_detail();
    });
    this.parent.query = this.$session.get("order_param_data");
    Fire.$emit("loadPageTitle", "受注伝票明細");
    this.get_prev_next_list();
  },
  computed: {
    total_selling_price: function total_selling_price() {
      // this.order_item_detail_lists.forEach(function (order_item_detail_list) {
      //     this.mes_lis_shi_tot_tot_selling_price_total +=order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price
      //   });
      // return this.order_item_detail_lists.reduce(function(a, c){return a + Number((c.mes_lis_shi_lin_amo_item_selling_price) || 0)}, 0)
      // return this.mes_lis_shi_tot_tot_selling_price_total;
      return 0;
    },
    totalCostPriceVal: function totalCostPriceVal() {
      return this.order_item_detail_lists.reduce(function (sum, order_item_detail_list) {
        return sum + order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;
      }, 0); // return this.order_item_detail_lists.reduce(function (sum,order_item_detail_list) {
      //  return  sum+order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;
      // },0);
    },
    totalSellingPriceVal: function totalSellingPriceVal() {
      return this.order_item_detail_lists.reduce(function (sumselling, order_item_detail_list) {
        return sumselling + order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;
      }, 0);
    },
    total_net_price: function total_net_price() {
      // this.order_item_detail_lists.forEach(function (order_item_detail_list) {
      //     this.mes_lis_shi_tot_tot_net_price_total +=order_item_detail_list.mes_lis_shi_lin_amo_item_net_price
      //   });
      //   return this.mes_lis_shi_tot_tot_net_price_total;
      // return this.order_item_detail_lists.reduce(function(a, c){return a + Number((c.mes_lis_shi_lin_amo_item_net_price) || 0)}, 0)
      return 0;
    },
    total_selling_prices: function total_selling_prices() {
      var totoal = 0; // this.order_item_detail_lists.forEach(function (order_item_detail_list) {
      //     totoal +=order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price
      //   });

      return totoal; // return this.order_item_detail_lists.reduce(function(a, c){return a + Number((c.mes_lis_shi_lin_amo_item_selling_price) || 0)}, 0)
      // return this.mes_lis_shi_tot_tot_selling_price_total;
    },
    total_net_prices: function total_net_prices() {
      var totoal = 0; // this.order_item_detail_lists.forEach(function (order_item_detail_list) {
      //     totoal +=order_item_detail_list.mes_lis_shi_lin_amo_item_net_price
      //   });

      return totoal; //   return this.mes_lis_shi_tot_tot_net_price_total;
      // return this.order_item_detail_lists.reduce(function(a, c){return a + Number((c.mes_lis_shi_lin_amo_item_net_price) || 0)}, 0)
    }
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=style&index=0&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=style&index=0&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\ninput[type=number]{\r\n    min-width: 100px;\n}\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=style&index=0&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=style&index=0&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../../../node_modules/css-loader??ref--6-1!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./slr_order_list_items.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=template&id=73659c5c&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=template&id=73659c5c& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-12" }, [
          _c(
            "div",
            {
              staticClass: "col-12",
              staticStyle: {
                background: "#d8e3f0",
                padding: "10px",
                "margin-bottom": "20px"
              }
            },
            [
              _c(
                "table",
                {
                  staticClass: "table orderDetailTable table-bordered",
                  staticStyle: { width: "100%" }
                },
                [
                  _c("tr", [
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("受信日時")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(_vm._s(_vm.order_item_lists.receive_datetime))
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("取引先")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_lists.mes_lis_shi_par_sel_code
                          ) +
                          "\n              " +
                          _vm._s(
                            _vm.order_item_lists.mes_lis_shi_par_sel_name
                          ) +
                          "\n            "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("便")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.getbyrjsonValueBykeyName(
                              "mes_lis_ord_log_del_delivery_service_code",
                              _vm.order_item_lists
                                .mes_lis_shi_log_del_delivery_service_code,
                              "orders"
                            )
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("納品日")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_lists
                              .mes_lis_shi_tra_dat_delivery_date
                          ) +
                          "\n            "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("部門")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_lists
                              .mes_lis_shi_tra_goo_major_category
                          ) +
                          "\n            "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("温度区分")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_lists
                              .mes_lis_shi_tra_ins_temperature_code
                          ) +
                          "\n              " +
                          _vm._s(
                            _vm.getbyrjsonValueBykeyName(
                              "mes_lis_ord_tra_ins_temperature_code",
                              _vm.order_item_lists
                                .mes_lis_shi_tra_ins_temperature_code,
                              "orders"
                            )
                          ) +
                          "\n            "
                      )
                    ])
                  ])
                ]
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }, [
          _c(
            "div",
            {
              staticClass: "col-12",
              staticStyle: {
                background: "#d8e3f0",
                padding: "10px",
                "margin-bottom": "20px"
              }
            },
            [
              _c(
                "table",
                {
                  staticClass: "table orderDetailTable table-bordered",
                  staticStyle: { width: "100%" }
                },
                [
                  _c("tr", [
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("発注日")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_tra_dat_order_date
                          ) +
                          "\n            "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("直接納品先")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_par_shi_code
                          ) +
                          "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_par_shi_name
                          ) +
                          "\n            "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("最終納品先")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_par_rec_code
                          ) +
                          "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_par_rec_name
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("伝票番号")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_tra_trade_number
                          ) +
                          "\n            "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("伝票区分")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_tra_ins_trade_type_code
                          ) +
                          "\n              " +
                          _vm._s(
                            _vm.getbyrjsonValueBykeyName(
                              "mes_lis_ord_tra_ins_trade_type_code",
                              _vm.order_item_shipment_data_headTable
                                .mes_lis_shi_tra_ins_trade_type_code,
                              "orders"
                            )
                          ) +
                          "\n            "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("定／特")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_tra_ins_goods_classification_code
                          ) +
                          "\n              " +
                          _vm._s(
                            _vm.getbyrjsonValueBykeyName(
                              "mes_lis_ord_tra_ins_goods_classification_code",
                              _vm.order_item_shipment_data_headTable
                                .mes_lis_shi_tra_ins_goods_classification_code,
                              "orders"
                            )
                          ) +
                          "\n            "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("不定貴区分")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_tra_fre_variable_measure_item_code
                          ) +
                          "\n              " +
                          _vm._s(
                            _vm.getbyrjsonValueBykeyName(
                              "mes_lis_ord_tra_fre_variable_measure_item_code",
                              _vm.order_item_shipment_data_headTable
                                .mes_lis_shi_tra_fre_variable_measure_item_code,
                              "orders"
                            )
                          ) +
                          "\n            "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("税区分・税率")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_tra_tax_tax_type_code
                          ) +
                          "\n              " +
                          _vm._s(
                            _vm.getbyrjsonValueBykeyName(
                              "mes_lis_ord_tra_tax_tax_type_code",
                              _vm.order_item_shipment_data_headTable
                                .mes_lis_shi_tra_tax_tax_type_code,
                              "orders"
                            )
                          ) +
                          "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_tra_tax_tax_rate
                          ) +
                          "\n              %\n            "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("備考")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_shi_tra_not_text
                          ) +
                          "\n            "
                      )
                    ])
                  ])
                ]
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }, [
          _c(
            "div",
            {
              staticClass: "col-12",
              staticStyle: {
                background: "#d8e3f0",
                padding: "10px",
                "margin-bottom": "20px"
              }
            },
            [
              _c(
                "table",
                {
                  staticClass: "table orderDetailTable table-bordered",
                  staticStyle: { width: "100%" }
                },
                [
                  _c("tr", [
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("出荷状況")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm._v(
                        "\n              " +
                          _vm._s(
                            _vm.order_item_shipment_data_headTable.status
                          ) +
                          "\n            "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color_extra",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("確定状況")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm.order_item_shipment_data_headTable
                        .decision_datetime != null
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_shipment_data_headTable
                                  .decision_datetime
                              )
                            )
                          ])
                        : _c("span", [_vm._v("未確定")])
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "cl_custom_color_extra",
                        attrs: { width: "10%" }
                      },
                      [_vm._v("送信状況")]
                    ),
                    _vm._v(" "),
                    _c("td", { attrs: { width: "15%" } }, [
                      _vm.order_item_shipment_data_headTable.send_datetime !=
                      null
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_shipment_data_headTable
                                  .send_datetime
                              )
                            )
                          ])
                        : _c("span", [_vm._v("未送信")])
                    ])
                  ])
                ]
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }, [
          _c(
            "table",
            {
              staticClass: "table orderDetailTable table-bordered",
              staticStyle: { width: "100%" }
            },
            [
              _c("tr", [
                _c("td", { staticClass: "cl_custom_color_extra" }, [
                  _vm._v("訂正納品日")
                ]),
                _vm._v(" "),
                _c("td", { attrs: { colspan: "3" } }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value:
                          _vm.order_item_shipment_data_headTable
                            .mes_lis_shi_tra_dat_revised_delivery_date,
                        expression:
                          "\n                order_item_shipment_data_headTable.mes_lis_shi_tra_dat_revised_delivery_date\n              "
                      }
                    ],
                    staticClass: "form-control",
                    attrs: {
                      disabled: _vm.is_disabled(
                        _vm.order_item_shipment_data_headTable
                          .decision_datetime == null
                          ? true
                          : false
                      ),
                      type: "date"
                    },
                    domProps: {
                      value:
                        _vm.order_item_shipment_data_headTable
                          .mes_lis_shi_tra_dat_revised_delivery_date
                    },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.order_item_shipment_data_headTable,
                          "mes_lis_shi_tra_dat_revised_delivery_date",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ])
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }, [
          _c("span", { staticClass: "pagi", staticStyle: { width: "100%" } }, [
            _c(
              "ul",
              { staticClass: "list-inline" },
              _vm._l(_vm.order_detail_list_paginates, function(item, index) {
                return _vm.data_order_voucher_id ==
                  item.data_shipment_voucher_id
                  ? _c("li", { key: index }, [
                      index >= 1
                        ? _c("span", [
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-primary",
                                on: {
                                  click: function($event) {
                                    return _vm.move_next_prev(
                                      _vm.order_detail_list_paginates[index - 1]
                                        .data_shipment_voucher_id
                                    )
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                ＜前伝票\n              "
                                )
                              ]
                            )
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      index < _vm.order_detail_list_paginates.length - 1
                        ? _c("span", [
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-primary",
                                on: {
                                  click: function($event) {
                                    return _vm.move_next_prev(
                                      _vm.order_detail_list_paginates[index + 1]
                                        .data_shipment_voucher_id
                                    )
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                次伝票＞\n              "
                                )
                              ]
                            )
                          ])
                        : _vm._e()
                    ])
                  : _vm._e()
              }),
              0
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }, [
          _c("div", {}, [
            _c(
              "table",
              {
                staticClass:
                  "table table-striped table-bordered table-responsive order_item_details_table data_table",
                staticStyle: { "overflow-x": "scroll" }
              },
              [
                _vm._m(0),
                _vm._v(" "),
                _c(
                  "tbody",
                  [
                    _vm._l(_vm.order_item_detail_lists, function(
                      order_item_detail_list,
                      index
                    ) {
                      return _c("tr", { key: index }, [
                        _c("td", [_vm._v(_vm._s(index + 1))]),
                        _vm._v(" "),
                        _c("td", { staticStyle: { "text-align": "left" } }, [
                          _vm._v(
                            "\n                商品コード：" +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_ite_order_item_code
                              )
                          ),
                          _c("br"),
                          _vm._v(
                            "\n                JANコード：\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_ite_gtin.slice(
                                  1
                                )
                              )
                          ),
                          _c("br"),
                          _vm._v(
                            "\n                商品名：" +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_ite_name
                              )
                          ),
                          _c("br"),
                          _vm._v(
                            "\n                規格：" +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_ite_ite_spec
                              )
                          ),
                          _c("br"),
                          _vm._v(
                            "\n                産地：" +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_fre_field_name
                              )
                          ),
                          _c("br")
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple
                              ) +
                              "\n              "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value:
                                  order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units,
                                expression:
                                  "\n                    order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units\n                  "
                              }
                            ],
                            staticClass: "form-control",
                            attrs: {
                              type: "number",
                              disabled: _vm.is_disabled(
                                _vm.order_item_shipment_data_headTable
                                  .decision_datetime == null
                                  ? true
                                  : false
                              ),
                              min: 0,
                              max:
                                order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units
                            },
                            domProps: {
                              value:
                                order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units
                            },
                            on: {
                              keyup: function($event) {
                                return _vm.ball_case_cal(
                                  order_item_detail_list,
                                  "ケース"
                                )
                              },
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  order_item_detail_list,
                                  "mes_lis_shi_lin_qua_shi_num_of_order_units",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units
                              ) +
                              "\n              "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td"),
                        _vm._v(" "),
                        _c("td", [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value:
                                  order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity,
                                expression:
                                  "\n                    order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity\n                  "
                              }
                            ],
                            staticClass: "form-control",
                            attrs: {
                              type: "number",
                              disabled: _vm.is_disabled(
                                _vm.order_item_shipment_data_headTable
                                  .decision_datetime == null
                                  ? true
                                  : false
                              ),
                              min: 0,
                              max:
                                order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity
                            },
                            domProps: {
                              value:
                                order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity
                            },
                            on: {
                              keyup: function($event) {
                                return _vm.ball_case_cal(
                                  order_item_detail_list,
                                  "バラ"
                                )
                              },
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  order_item_detail_list,
                                  "mes_lis_shi_lin_qua_shi_quantity",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity
                              ) +
                              "\n              "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-right" }, [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                _vm._f("priceFormat")(
                                  order_item_detail_list.mes_lis_shi_lin_fre_item_weight *
                                    order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity
                                )
                              ) +
                              "\n              "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-right" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value:
                                  order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price,
                                expression:
                                  "\n                    order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price\n                  "
                              }
                            ],
                            staticClass: "form-control text-right",
                            attrs: {
                              type: "number",
                              disabled: _vm.is_disabled(
                                _vm.order_item_shipment_data_headTable
                                  .decision_datetime == null
                                  ? true
                                  : false
                              ),
                              min: 0,
                              max:
                                order_item_detail_list.mes_lis_ord_lin_amo_item_net_price_unit_price
                            },
                            domProps: {
                              value:
                                order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price
                            },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  order_item_detail_list,
                                  "mes_lis_shi_lin_amo_item_net_price_unit_price",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_ord_lin_amo_item_net_price_unit_price
                              ) +
                              "\n              "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-right" }, [
                          order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price *
                            order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity >
                          0
                            ? _c("span", [
                                _vm._v(
                                  "\n                  " +
                                    _vm._s(
                                      _vm._f("priceFormat")(
                                        order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price *
                                          order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity
                                      )
                                    )
                                )
                              ])
                            : _c("span", [_vm._v("0")])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-right" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value:
                                  order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price,
                                expression:
                                  "\n                    order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price\n                  "
                              }
                            ],
                            staticClass: "form-control text-right",
                            attrs: {
                              type: "number",
                              disabled: _vm.is_disabled(
                                _vm.order_item_shipment_data_headTable
                                  .decision_datetime == null
                                  ? true
                                  : false
                              ),
                              min: 0,
                              max:
                                order_item_detail_list.mes_lis_ord_lin_amo_item_selling_price_unit_price
                            },
                            domProps: {
                              value:
                                order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price
                            },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  order_item_detail_list,
                                  "mes_lis_shi_lin_amo_item_selling_price_unit_price",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_ord_lin_amo_item_selling_price_unit_price
                              ) +
                              "\n              "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-right" }, [
                          order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price *
                            order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity >
                          0
                            ? _c("span", [
                                _vm._v(
                                  _vm._s(
                                    _vm._f("priceFormat")(
                                      order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price *
                                        order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity
                                    )
                                  )
                                )
                              ])
                            : _c("span", [_vm._v("0")])
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units !=
                            order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units &&
                          order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code ==
                            "00"
                            ? _c(
                                "span",
                                {
                                  staticStyle: {
                                    color: "red",
                                    "font-size": "12px"
                                  }
                                },
                                [_vm._v("欠品のため欠品理由が必要です。")]
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units ==
                            order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units &&
                          order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code !=
                            "00"
                            ? _c(
                                "span",
                                {
                                  staticStyle: {
                                    color: "red",
                                    "font-size": "12px"
                                  }
                                },
                                [_vm._v("完納のため欠品理由は不正です。")]
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          _c(
                            "select",
                            {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value:
                                    order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code,
                                  expression:
                                    "\n                    order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code\n                  "
                                }
                              ],
                              staticClass: "form-control",
                              class: [
                                order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units !=
                                  order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units &&
                                order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code ==
                                  "00"
                                  ? "error_found"
                                  : "",
                                order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units ==
                                  order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units &&
                                order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code !=
                                  "00"
                                  ? "error_found"
                                  : ""
                              ],
                              attrs: {
                                disabled: _vm.is_disabled(
                                  _vm.order_item_shipment_data_headTable
                                    .decision_datetime == null
                                    ? true
                                    : false
                                )
                              },
                              on: {
                                change: function($event) {
                                  var $$selectedVal = Array.prototype.filter
                                    .call($event.target.options, function(o) {
                                      return o.selected
                                    })
                                    .map(function(o) {
                                      var val =
                                        "_value" in o ? o._value : o.value
                                      return val
                                    })
                                  _vm.$set(
                                    order_item_detail_list,
                                    "mes_lis_shi_lin_qua_sto_reason_code",
                                    $event.target.multiple
                                      ? $$selectedVal
                                      : $$selectedVal[0]
                                  )
                                }
                              }
                            },
                            _vm._l(
                              _vm.mes_lis_shi_lin_qua_sto_reason_codeList,
                              function(item, i) {
                                return _c(
                                  "option",
                                  { key: i, domProps: { value: i } },
                                  [
                                    _vm._v(
                                      "\n                    " +
                                        _vm._s(item) +
                                        "\n                  "
                                    )
                                  ]
                                )
                              }
                            ),
                            0
                          ),
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code
                              ) +
                              "\n                " +
                              _vm._s(
                                _vm.getbyrjsonValueBykeyName(
                                  "mes_lis_shi_lin_qua_sto_reason_code",
                                  order_item_detail_list.mes_lis_shi_lin_qua_sto_reason_code,
                                  "shipments"
                                )
                              ) +
                              "\n                "
                          )
                        ])
                      ])
                    }),
                    _vm._v(" "),
                    _vm.order_item_detail_lists &&
                    _vm.order_item_detail_lists.length == 0
                      ? _c("tr", [
                          _c(
                            "td",
                            {
                              staticClass: "text-center",
                              attrs: { colspan: "12" }
                            },
                            [_vm._v("データがありません")]
                          )
                        ])
                      : _vm._e()
                  ],
                  2
                ),
                _vm._v(" "),
                _c("tfoot", [
                  _c("tr", [
                    _c("th"),
                    _vm._v(" "),
                    _c("th"),
                    _vm._v(" "),
                    _c("th"),
                    _vm._v(" "),
                    _c("th"),
                    _vm._v(" "),
                    _c("th"),
                    _vm._v(" "),
                    _c("th"),
                    _vm._v(" "),
                    _c("th"),
                    _vm._v(" "),
                    _vm._m(1),
                    _vm._v(" "),
                    _c("th", { staticStyle: { "text-align": "right" } }, [
                      _vm._v(
                        "\n                " +
                          _vm._s(_vm._f("priceFormat")(_vm.totalCostPriceVal)) +
                          "\n              "
                      )
                    ]),
                    _vm._v(" "),
                    _vm._m(2),
                    _vm._v(" "),
                    _c("th", { staticStyle: { "text-align": "right" } }, [
                      _vm._v(
                        "\n                " +
                          _vm._s(
                            _vm._f("priceFormat")(_vm.totalSellingPriceVal)
                          ) +
                          "\n              "
                      )
                    ]),
                    _vm._v(" "),
                    _c("th")
                  ])
                ])
              ]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            size: "lg",
            "hide-backdrop": true,
            title: "発注データ修正",
            "ok-title": "修正",
            "cancel-title": "キャンセル"
          },
          on: {
            ok: function($event) {
              $event.preventDefault()
              return _vm.save_user()
            }
          },
          model: {
            value: _vm.edit_order_modal,
            callback: function($$v) {
              _vm.edit_order_modal = $$v
            },
            expression: "edit_order_modal"
          }
        },
        [
          _c("div", { staticClass: "panel-body add_item_body" }, [
            _c("form", [
              _c("input", {
                attrs: {
                  type: "hidden",
                  name: "vendor_item_id",
                  id: "vendor_item_id",
                  value: ""
                }
              }),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-6" }, [
                  _c("div", { staticClass: "input-group mb-3" }, [
                    _c("div", { staticClass: "input-group-prepend" }, [
                      _c(
                        "span",
                        {
                          staticClass: "input-group-text",
                          attrs: { id: "basic-addon3" }
                        },
                        [_vm._v("伝票番号")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      staticClass: "form-control",
                      attrs: {
                        type: "text",
                        id: "basic-url",
                        "aria-describedby": "basic-addon3"
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "input-group mb-3" }, [
                    _c("div", { staticClass: "input-group-prepend" }, [
                      _c(
                        "span",
                        {
                          staticClass: "input-group-text",
                          attrs: { id: "basic-addon3" }
                        },
                        [_vm._v("発注日")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      staticClass: "form-control",
                      attrs: {
                        type: "text",
                        id: "basic-url",
                        "aria-describedby": "basic-addon3"
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "input-group mb-3" }, [
                    _c("div", { staticClass: "input-group-prepend" }, [
                      _c(
                        "span",
                        {
                          staticClass: "input-group-text",
                          attrs: { id: "basic-addon3" }
                        },
                        [_vm._v("商品名")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      staticClass: "form-control",
                      attrs: {
                        type: "text",
                        id: "basic-url",
                        "aria-describedby": "basic-addon3"
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "input-group mb-3" }, [
                    _c("div", { staticClass: "input-group-prepend" }, [
                      _c(
                        "span",
                        {
                          staticClass: "input-group-text",
                          attrs: { id: "basic-addon3" }
                        },
                        [_vm._v("原価")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      staticClass: "form-control",
                      attrs: {
                        type: "text",
                        id: "basic-url",
                        "aria-describedby": "basic-addon3"
                      }
                    })
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-6" }, [
                  _c("div", { staticClass: "input-group mb-3" }, [
                    _c("div", { staticClass: "input-group-prepend" }, [
                      _c(
                        "span",
                        {
                          staticClass: "input-group-text",
                          attrs: { id: "basic-addon3" }
                        },
                        [_vm._v("JAN")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      staticClass: "form-control",
                      attrs: {
                        type: "text",
                        id: "basic-url",
                        "aria-describedby": "basic-addon3"
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "input-group mb-3" }, [
                    _c("div", { staticClass: "input-group-prepend" }, [
                      _c(
                        "span",
                        {
                          staticClass: "input-group-text",
                          attrs: { id: "basic-addon3" }
                        },
                        [_vm._v("納品日")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      staticClass: "form-control",
                      attrs: {
                        type: "text",
                        id: "basic-url",
                        "aria-describedby": "basic-addon3"
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "input-group mb-3" }, [
                    _c("div", { staticClass: "input-group-prepend" }, [
                      _c(
                        "span",
                        {
                          staticClass: "input-group-text",
                          attrs: { id: "basic-addon3" }
                        },
                        [_vm._v("規格")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      staticClass: "form-control",
                      attrs: {
                        type: "text",
                        id: "basic-url",
                        "aria-describedby": "basic-addon3"
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "input-group mb-3" }, [
                    _c("div", { staticClass: "input-group-prepend" }, [
                      _c(
                        "span",
                        {
                          staticClass: "input-group-text",
                          attrs: { id: "basic-addon3" }
                        },
                        [_vm._v("売価")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("input", {
                      staticClass: "form-control",
                      attrs: {
                        type: "text",
                        id: "basic-url",
                        "aria-describedby": "basic-addon3"
                      }
                    })
                  ])
                ])
              ])
            ])
          ])
        ]
      )
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("No")]),
        _vm._v(" "),
        _c("th", [_vm._v("商品")]),
        _vm._v(" "),
        _c("th", [_vm._v("入数")]),
        _vm._v(" "),
        _c("th", [_vm._v("ケース数")]),
        _vm._v(" "),
        _c("th", [_vm._v("単位")]),
        _vm._v(" "),
        _c("th", [_vm._v("バラ数")]),
        _vm._v(" "),
        _c("th", [_vm._v("重量")]),
        _vm._v(" "),
        _c("th", [_vm._v("原単価")]),
        _vm._v(" "),
        _c("th", [_vm._v("原価金額")]),
        _vm._v(" "),
        _c("th", [_vm._v("売単価")]),
        _vm._v(" "),
        _c("th", [_vm._v("売価金額")]),
        _vm._v(" "),
        _c("th", [_vm._v("欠品理由")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticStyle: {
          background: "#538ed3",
          color: "#fff",
          "text-align": "center"
        }
      },
      [
        _vm._v("\n                原価金額"),
        _c("br"),
        _vm._v("合計\n              ")
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticStyle: {
          background: "#538ed3",
          color: "#fff",
          "text-align": "center"
        }
      },
      [
        _vm._v("\n                売価金額"),
        _c("br"),
        _vm._v("合計\n              ")
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _slr_order_list_items_vue_vue_type_template_id_73659c5c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./slr_order_list_items.vue?vue&type=template&id=73659c5c& */ "./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=template&id=73659c5c&");
/* harmony import */ var _slr_order_list_items_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./slr_order_list_items.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _slr_order_list_items_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./slr_order_list_items.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _slr_order_list_items_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _slr_order_list_items_vue_vue_type_template_id_73659c5c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _slr_order_list_items_vue_vue_type_template_id_73659c5c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./slr_order_list_items.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=style&index=0&lang=css&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=style&index=0&lang=css& ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/style-loader!../../../../../../../node_modules/css-loader??ref--6-1!../../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./slr_order_list_items.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=template&id=73659c5c&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=template&id=73659c5c& ***!
  \****************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_template_id_73659c5c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./slr_order_list_items.vue?vue&type=template&id=73659c5c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/BYR/DATA/ORDER/slr_order_list_items.vue?vue&type=template&id=73659c5c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_template_id_73659c5c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_order_list_items_vue_vue_type_template_id_73659c5c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);