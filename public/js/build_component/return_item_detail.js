(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["return_item_detail"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  breadcrumb: function breadcrumb() {
    return {
      label: "返品伝票明細",
      parent: this.parentQ
    };
  },
  data: function data() {
    return {
      parentQ: {
        name: "return_detail",
        query: {}
      },
      sortKey: "",
      reverse: true,
      order_by: "asc",
      order_detail_lists: {},
      return_detail_item_list_paginates: {},
      order_item_lists: {},
      order_item_detail_lists: [],
      order_item_shipment_data_headTable: {},
      mes_lis_acc_lin_qua_rec_reason_codeList: [],
      order_date: "",
      order_detail_list: [],
      buyer_settings: [],
      byr_buyer_lists: {},
      show_hide_col_list: [],
      expected_delivery_date: "",
      data_order_voucher_id: "",
      totalCostPrice: 0,
      totalSellingPrice: 0,
      status: "",
      // byr_order_id: "",
      edit_order_modal: false,
      selected: [],
      isCheckAll: false,
      form: new Form({
        data_return_voucher_id: null,
        byr_buyer_id: null,
        adm_user_id: Globals.user_info_id
      }),
      param_data: [],
      queryData: "",
      byr_buyer_id: null,
      data_return_voucher_id: ""
    };
  },
  beforeCreate: function beforeCreate() {
    if (!this.$session.exists()) {
      this.$router.push("/home");
    }
  },
  methods: {
    ball_case_cal: function ball_case_cal(order_item_detail_list, field_type) {
      if (field_type == "ケース") {
        order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity = order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units * order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity;
      } else {
        var calval = order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity / order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity;

        if (calval > 0 && calval % 1 === 0) {
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
        if (order_item_detail_listData.mes_lis_acc_lin_qua_shi_quantity == 0) {
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
    //get Table data
    get_all_receive_item_detail: function get_all_receive_item_detail() {
      var _this = this;

      axios.post(this.BASE_URL + "api/data_return_item_detail_list", this.form).then(function (_ref) {
        var data = _ref.data;
        _this.order_item_detail_lists = data.return_item_detail_list;
        _this.order_item_shipment_data_headTable = data.return_item_detail_list[0];
        _this.byr_buyer_lists = data.byr_buyer_list;
        _this.buyer_settings = JSON.parse(data.buyer_settings);
        _this.order_item_lists = data.return_item_detail_list[0]; //   this.order_item_lists = data.order_info;

        _this.mes_lis_acc_lin_qua_rec_reason_codeList = _this.buyer_settings.receives.mes_lis_acc_lin_qua_rec_reason_code;

        _this.loader.hide();
      });
    },
    move_next_prev: function move_next_prev(id) {
      this.form.data_return_voucher_id = id;
      this.data_return_voucher_id = id;
      this.get_all_receive_item_detail();
    },
    //get Table data
    get_all_return_item_detail_pagination: function get_all_return_item_detail_pagination() {
      var _this2 = this;

      this.parentQ.query.adm_user_id = Globals.user_info_id;
      this.parentQ.query.byr_buyer_id = this.byr_buyer_id;
      axios.post(this.BASE_URL + "api/data_return_detail_list_pagination", this.parentQ.query).then(function (_ref2) {
        var data = _ref2.data;
        _this2.return_detail_item_list_paginates = data.retrun_detail_list_pagination;
      });
    }
  },
  created: function created() {
    var _this3 = this;

    this.byr_buyer_id = this.$session.get("byr_buyer_id");
    this.form.byr_buyer_id = this.byr_buyer_id;
    Fire.$emit("byr_has_selected", this.byr_buyer_id);
    Fire.$emit("permission_check_for_buyer", this.byr_buyer_id);
    this.getbuyerJsonSettingvalue();
    this.loader = Vue.$loading.show();
    this.data_return_voucher_id = this.$route.query.data_return_voucher_id;
    this.form.data_return_voucher_id = this.$route.query.data_return_voucher_id;
    this.get_all_receive_item_detail();
    Fire.$on("LoadByrorderItemDetail", function () {
      _this3.get_all_receive_item_detail();
    });
    this.parentQ.query = this.$session.get("receive_list_detail_query_param");
    Fire.$emit("loadPageTitle", "返品伝票明細");
    this.get_all_return_item_detail_pagination();
  },
  computed: {
    totalCostPriceVal: function totalCostPriceVal() {
      return this.order_item_detail_lists.reduce(function (sum, order_item_detail_list) {
        return sum + order_item_detail_list.mes_lis_ret_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_ret_lin_qua_shi_quantity;
      }, 0); // return this.order_item_detail_lists.reduce(function (sum,order_item_detail_list) {
      //  return  sum+order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;
      // },0);
    },
    totalSellingPriceVal: function totalSellingPriceVal() {
      return this.order_item_detail_lists.reduce(function (sumselling, order_item_detail_list) {
        return sumselling + order_item_detail_list.mes_lis_ret_lin_amo_item_selling_price_unit_price * order_item_detail_list.mes_lis_ret_lin_qua_shi_quantity;
      }, 0);
    }
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=template&id=5aa9f224&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=template&id=5aa9f224& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("受信日時")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_lists &&
                      Object.keys(_vm.order_item_lists).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(_vm.order_item_lists.receive_datetime)
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("取引先")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_lists &&
                      Object.keys(_vm.order_item_lists).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_lists.mes_lis_ret_par_sel_code
                              ) +
                                "\n                " +
                                _vm._s(
                                  _vm.order_item_lists.mes_lis_ret_par_sel_name
                                )
                            )
                          ])
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("納品日")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_lists &&
                      Object.keys(_vm.order_item_lists).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_lists
                                  .mes_lis_ret_tra_dat_transfer_of_ownership_date
                              )
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("部門")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_lists &&
                      Object.keys(_vm.order_item_lists).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_lists
                                  .mes_lis_ret_tra_goo_major_category
                              )
                            )
                          ])
                        : _vm._e()
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
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("直接納品先")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_shipment_data_headTable &&
                      Object.keys(_vm.order_item_shipment_data_headTable).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_shipment_data_headTable
                                  .mes_lis_ret_par_return_receive_from_code
                              ) +
                                "\n                " +
                                _vm._s(
                                  _vm.order_item_shipment_data_headTable
                                    .mes_lis_ret_par_return_receive_from_name
                                )
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("最終納品先")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_shipment_data_headTable &&
                      Object.keys(_vm.order_item_shipment_data_headTable).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_shipment_data_headTable
                                  .mes_lis_ret_par_return_from_code
                              ) +
                                "\n                " +
                                _vm._s(
                                  _vm.order_item_shipment_data_headTable
                                    .mes_lis_ret_par_return_from_name
                                )
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("伝票番号")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_shipment_data_headTable &&
                      Object.keys(_vm.order_item_shipment_data_headTable).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_shipment_data_headTable
                                  .mes_lis_ret_tra_trade_number
                              )
                            )
                          ])
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("不定貴区分")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_shipment_data_headTable &&
                      Object.keys(_vm.order_item_shipment_data_headTable).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_shipment_data_headTable
                                  .mes_lis_ret_tra_fre_variable_measure_item_code
                              ) +
                                "\n                " +
                                _vm._s(
                                  _vm.getbyrjsonValueBykeyName(
                                    "mes_lis_ord_tra_fre_variable_measure_item_code",
                                    _vm.order_item_shipment_data_headTable
                                      .mes_lis_ret_tra_fre_variable_measure_item_code,
                                    "orders",
                                    _vm.buyer_settings
                                  )
                                )
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("伝票区分")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_shipment_data_headTable &&
                      Object.keys(_vm.order_item_shipment_data_headTable).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_shipment_data_headTable
                                  .mes_lis_ret_tra_ins_trade_type_code
                              ) +
                                "\n                " +
                                _vm._s(
                                  _vm.getbyrjsonValueBykeyName(
                                    "mes_lis_ord_tra_ins_trade_type_code",
                                    _vm.order_item_shipment_data_headTable
                                      .mes_lis_ret_tra_ins_trade_type_code,
                                    "orders",
                                    _vm.buyer_settings
                                  )
                                )
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("税区分・税率")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_shipment_data_headTable &&
                      Object.keys(_vm.order_item_shipment_data_headTable).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_shipment_data_headTable
                                  .mes_lis_ret_tra_tax_tax_type_code
                              ) +
                                "\n                " +
                                _vm._s(
                                  _vm.getbyrjsonValueBykeyName(
                                    "mes_lis_ord_tra_tax_tax_type_code",
                                    _vm.order_item_shipment_data_headTable
                                      .mes_lis_ret_tra_tax_tax_type_code,
                                    "orders",
                                    _vm.buyer_settings
                                  )
                                ) +
                                "\n                " +
                                _vm._s(
                                  _vm.order_item_shipment_data_headTable
                                    .mes_lis_ret_tra_tax_tax_rate
                                ) +
                                "\n                %"
                            )
                          ])
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("備考")
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { colspan: "5" } }, [
                      _vm.order_item_shipment_data_headTable &&
                      Object.keys(_vm.order_item_shipment_data_headTable).length
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_shipment_data_headTable
                                  .mes_lis_ret_tra_not_text
                              )
                            )
                          ])
                        : _vm._e()
                    ])
                  ])
                ]
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", {
          staticClass: "col-12",
          staticStyle: { "text-align": "center" }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }, [
          _c("span", { staticClass: "pagi", staticStyle: { width: "100%" } }, [
            _c(
              "ul",
              { staticClass: "list-inline" },
              _vm._l(_vm.return_detail_item_list_paginates, function(
                item,
                index
              ) {
                return _vm.form.data_return_voucher_id ==
                  item.data_return_voucher_id
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
                                      _vm.return_detail_item_list_paginates[
                                        index - 1
                                      ].data_return_voucher_id
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
                      index < _vm.return_detail_item_list_paginates.length - 1
                        ? _c("span", [
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-primary",
                                on: {
                                  click: function($event) {
                                    return _vm.move_next_prev(
                                      _vm.return_detail_item_list_paginates[
                                        index + 1
                                      ].data_return_voucher_id
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
        _c("div", { staticClass: "col-12" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }, [
          _c(
            "table",
            {
              staticClass:
                "table table-striped table-bordered order_item_details_table",
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
                          "\n              商品コード：" +
                            _vm._s(
                              order_item_detail_list.mes_lis_ret_lin_ite_order_item_code
                            )
                        ),
                        _c("br"),
                        _vm._v("\n              JANコード："),
                        order_item_detail_list.mes_lis_ret_lin_ite_gtin.charAt(
                          0
                        ) == "0"
                          ? _c("span", [
                              _vm._v(
                                "\n              " +
                                  _vm._s(
                                    order_item_detail_list.mes_lis_ret_lin_ite_gtin.slice(
                                      1
                                    )
                                  ) +
                                  "\n              "
                              )
                            ])
                          : _c("span", [
                              _vm._v(
                                "\n              " +
                                  _vm._s(
                                    order_item_detail_list.mes_lis_ret_lin_ite_gtin
                                  ) +
                                  "\n              "
                              )
                            ]),
                        _vm._v(" "),
                        _c("br"),
                        _vm._v(
                          "\n              商品名：" +
                            _vm._s(
                              order_item_detail_list.mes_lis_ret_lin_ite_name
                            )
                        ),
                        _c("br"),
                        _vm._v(
                          "\n              規格：" +
                            _vm._s(
                              order_item_detail_list.mes_lis_ret_lin_ite_ite_spec
                            )
                        ),
                        _c("br"),
                        _vm._v(
                          "\n              産地：" +
                            _vm._s(
                              order_item_detail_list.mes_lis_ret_lin_fre_field_name
                            )
                        ),
                        _c("br")
                      ]),
                      _vm._v(" "),
                      _c("td"),
                      _vm._v(" "),
                      _c("td"),
                      _vm._v(" "),
                      _c("td"),
                      _vm._v(" "),
                      _c("td", [
                        _vm._v(
                          "\n              " +
                            _vm._s(
                              order_item_detail_list.mes_lis_ret_lin_qua_quantity
                            ) +
                            "\n            "
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _vm._v(
                          "\n              " +
                            _vm._s(
                              order_item_detail_list.mes_lis_ret_lin_fre_return_weight
                            ) +
                            "\n            "
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-right" }, [
                        _vm._v(
                          "\n              " +
                            _vm._s(
                              _vm._f("priceFormat")(
                                _vm.zeroShow(
                                  order_item_detail_list.mes_lis_ret_lin_amo_item_net_price_unit_price
                                )
                              )
                            ) +
                            "\n            "
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-right" }, [
                        _vm._v(
                          "\n              " +
                            _vm._s(
                              _vm._f("priceFormat")(
                                _vm.zeroShow(
                                  order_item_detail_list.mes_lis_ret_lin_amo_item_net_price
                                )
                              )
                            ) +
                            "\n            "
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-right" }, [
                        _vm._v(
                          "\n              " +
                            _vm._s(
                              _vm._f("priceFormat")(
                                _vm.zeroShow(
                                  order_item_detail_list.mes_lis_ret_lin_amo_item_selling_price_unit_price
                                )
                              )
                            ) +
                            "\n            "
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-right" }, [
                        _vm._v(
                          "\n              " +
                            _vm._s(
                              _vm._f("priceFormat")(
                                _vm.zeroShow(
                                  order_item_detail_list.mes_lis_ret_lin_amo_item_selling_price
                                )
                              )
                            ) +
                            "\n            "
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
                    _c("span", [
                      _vm._v(
                        _vm._s(
                          _vm._f("priceFormat")(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_ret_tot_tot_net_price_total
                          )
                        )
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _vm._m(2),
                  _vm._v(" "),
                  _c("th", { staticStyle: { "text-align": "right" } }, [
                    _vm._v(
                      "\n              " +
                        _vm._s(
                          _vm._f("priceFormat")(
                            _vm.order_item_shipment_data_headTable
                              .mes_lis_ret_tot_tot_selling_price_total
                          )
                        ) +
                        "\n            "
                    )
                  ])
                ])
              ])
            ]
          )
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
            "cancel-title": "キャンセル",
            "no-enforce-focus": true
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
        _c("th", [_vm._v("売価金額")])
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
        _vm._v("\n              原価金額"),
        _c("br"),
        _vm._v("合計\n            ")
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
        _vm._v("\n              売価金額"),
        _c("br"),
        _vm._v("合計\n            ")
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () { injectStyles.call(this, this.$root.$options.shadowRoot) }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/js/components/backend/DATA/RETURN/return_item_detail.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/backend/DATA/RETURN/return_item_detail.vue ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _return_item_detail_vue_vue_type_template_id_5aa9f224___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./return_item_detail.vue?vue&type=template&id=5aa9f224& */ "./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=template&id=5aa9f224&");
/* harmony import */ var _return_item_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./return_item_detail.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _return_item_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _return_item_detail_vue_vue_type_template_id_5aa9f224___WEBPACK_IMPORTED_MODULE_0__["render"],
  _return_item_detail_vue_vue_type_template_id_5aa9f224___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/DATA/RETURN/return_item_detail.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_return_item_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./return_item_detail.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_return_item_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=template&id=5aa9f224&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=template&id=5aa9f224& ***!
  \***********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_return_item_detail_vue_vue_type_template_id_5aa9f224___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./return_item_detail.vue?vue&type=template&id=5aa9f224& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/RETURN/return_item_detail.vue?vue&type=template&id=5aa9f224&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_return_item_detail_vue_vue_type_template_id_5aa9f224___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_return_item_detail_vue_vue_type_template_id_5aa9f224___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);