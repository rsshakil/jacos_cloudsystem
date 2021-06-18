(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["item_search_detail"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  breadcrumb: function breadcrumb() {
    return {
      label: "受注商品別明細",
      parentsList: [{
        to: {
          name: "item_search",
          query: this.item_search_parent_query
        },
        label: "受注商品別一覧"
      }, {
        to: {
          name: "order_list_details",
          query: this.orderListdetailQ
        },
        label: "受注伝票一覧"
      }, {
        to: {
          name: "order_list"
        },
        label: "受注受信一覧"
      }, {
        to: {
          name: "home"
        },
        label: "HOME"
      }]
    };
  },
  data: function data() {
    return {
      today: new Date().toISOString().slice(0, 10),
      orderListdetailQ: {},
      item_search_parent_query: {},
      sortKey: "",
      reverse: true,
      order_by: "asc",
      order_detail_lists: {},
      order_info: {},
      order_item_detail_lists: [],
      buyer_setting_valuesse: {},
      order_item_lists: [],
      order_item_shipment_data_headTable: {},
      order_date: "",
      order_detail_list: [],
      show_hide_col_list: [],
      expected_delivery_date: "",
      item_id: "",
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
      param_data: [],
      queryData: ""
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
        if (order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units > order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units) {
          order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units = order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units;
        }

        order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity = order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units * order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple; //this.order_item_lists.mes_lis_shi_lin_qua_shi_num_of_order_units = order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units;
      } else {
        // var calval=order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity/order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity;
        var calval = order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity / order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple; // if (calval > 0 && calval % 1 === 0) {

        if (calval > order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units) {
          calval = order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units;
          order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity = calval * order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple;
        }

        order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units = calval; //this.order_item_lists.mes_lis_shi_lin_qua_shi_num_of_order_units = calval;
        //}
      } // this.order_item_lists.mes_lis_shi_lin_qua_shi_quantity=order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;
      //this.checkUpdateDeliveryStatus();

    },
    caseBallUpdate: function caseBallUpdate(order_item_detail_list, field_type) {
      if (field_type == "ケース") {
        this.order_item_lists.mes_lis_shi_lin_qua_shi_quantity = order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units * order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple; //  if (
        //     this.order_item_lists.mes_lis_shi_lin_qua_shi_num_of_order_units >
        //     order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units
        //   ) {
        //     this.order_item_lists.mes_lis_shi_lin_qua_shi_num_of_order_units =
        //       order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units;
        //       this.order_item_lists.mes_lis_shi_lin_qua_shi_quantity=order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units*order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple;
        //   }
      } else {
        var calval = order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity / order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple; // if (
        //   calval >
        //   order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units
        // ) {
        //   calval =
        //     order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units;
        //   order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity =
        //     calval * order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple;
        // }

        this.order_item_lists.mes_lis_shi_lin_qua_shi_num_of_order_units = calval;
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
    updateShipmentItemDetails: function updateShipmentItemDetails() {
      var _this = this;

      this.order_item_detail_lists.forEach(function (value, index) {
        if (value.mes_lis_shi_lin_qua_shi_num_of_order_units != value.mes_lis_shi_lin_qua_ord_num_of_order_units && value.mes_lis_shi_lin_qua_sto_reason_code == "00") {
          _this.alert_icon = "error";
          _this.alert_title = "";
          _this.alert_text = "入力データが不正です。入力値を確認してください。";

          _this.sweet_normal_alert();

          return false;
        }

        if (value.mes_lis_shi_lin_qua_shi_num_of_order_units == value.mes_lis_shi_lin_qua_ord_num_of_order_units && value.mes_lis_shi_lin_qua_sto_reason_code != "00") {
          _this.alert_icon = "error";
          _this.alert_title = "";
          _this.alert_text = "入力データが不正です。入力値を確認してください。";

          _this.sweet_normal_alert();

          return false;
        }
      });

      if (this.checkValidate() == false) {
        return false;
      }

      var order_detailitem = {
        items: this.order_item_detail_lists,
        updated_date: this.order_item_shipment_data_headTable.mes_lis_shi_tra_dat_revised_delivery_date,
        total_cost_price: this.totalCostPriceVal,
        total_selling_price: this.totalSellingPriceVal
      };
      axios({
        method: "POST",
        url: this.BASE_URL + "api/update_shipment_item_details",
        data: order_detailitem
      }).then(function (_ref) {
        var data = _ref.data;
        _this.alert_icon = "success";
        _this.alert_title = "";
        _this.alert_text = "入力データを反映させました";

        _this.sweet_normal_alert();

        Fire.$emit("LoadByrorderItemDetail");
      })["catch"](function (response) {});
    },
    updateOrderItemFormData: function updateOrderItemFormData() {
      var _this = this; // this.order_item_detail_lists=[];


      var order_detailitem = {
        items: this.order_item_lists
      }; //this.order_item_detail_lists.push(this.order_item_lists);

      _this.order_item_detail_lists.forEach(function (value, index) {
        if (_this.order_item_lists.mes_lis_shi_lin_qua_shi_num_of_order_units > _this.order_item_detail_lists[index].mes_lis_shi_lin_qua_ord_num_of_order_units) {
          _this.order_item_detail_lists[index].mes_lis_shi_lin_qua_shi_num_of_order_units = _this.order_item_detail_lists[index].mes_lis_shi_lin_qua_ord_num_of_order_units;
        } else {
          _this.order_item_detail_lists[index].mes_lis_shi_lin_qua_shi_num_of_order_units = _this.order_item_lists.mes_lis_shi_lin_qua_shi_num_of_order_units;
        }

        if (_this.order_item_lists.mes_lis_shi_lin_qua_shi_quantity > _this.order_item_detail_lists[index].mes_lis_shi_lin_qua_ord_quantity) {
          _this.order_item_detail_lists[index].mes_lis_shi_lin_qua_shi_quantity = _this.order_item_detail_lists[index].mes_lis_shi_lin_qua_ord_quantity;
        } else {
          _this.order_item_detail_lists[index].mes_lis_shi_lin_qua_shi_quantity = _this.order_item_lists.mes_lis_shi_lin_qua_shi_quantity;
        }

        _this.order_item_detail_lists[index].mes_lis_shi_lin_amo_item_net_price_unit_price = _this.order_item_lists.mes_lis_shi_lin_amo_item_net_price_unit_price;
        _this.order_item_detail_lists[index].mes_lis_shi_lin_amo_item_selling_price_unit_price = _this.order_item_lists.mes_lis_shi_lin_amo_item_selling_price_unit_price;
        _this.order_item_detail_lists[index].mes_lis_shi_lin_qua_sto_reason_code = _this.order_item_lists.mes_lis_shi_lin_qua_sto_reason_code;
      });

      _this.alert_icon = "success";
      _this.alert_title = "";
      _this.alert_text = "入力データを反映させました";

      _this.sweet_normal_alert();
      /*
      axios({
        method: "POST",
        url: this.BASE_URL + "api/update_shipment_item_detail_form_data",
        data: order_detailitem,
      })
        .then(({ data }) => {
          _this.alert_icon = "success";
          _this.alert_title = "";
          _this.alert_text = "入力データを反映させました";
          _this.sweet_normal_alert();
          Fire.$emit("LoadByrorderItemDetail");
        })
        .catch(function (response) {});
        */

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
    get_all_byr_order_item_detail: function get_all_byr_order_item_detail() {
      var _this2 = this;

      axios.post(this.BASE_URL + "api/shipment_item_detail_search", this.$route.query).then(function (_ref4) {
        var data = _ref4.data;
        _this2.order_item_detail_lists = data.order_item_list_detail;

        if (data.order_item_list_detail && data.order_item_list_detail.length > 0) {
          _this2.mes_lis_shi_tot_tot_net_price_total = data.order_item_list_detail[0].mes_lis_shi_tot_tot_net_price_total;
          _this2.mes_lis_shi_tot_tot_selling_price_total = data.order_item_list_detail[0].mes_lis_shi_tot_tot_selling_price_total;
        }

        _this2.order_item_lists = data.orderItem;
        _this2.order_item_shipment_data_headTable = data.order_item_list_detail[0];

        _this2.loader.hide();
      });
    },
    edit_order_detail: function edit_order_detail(order_detail_list) {
      this.edit_order_modal = true;
    }
  },
  created: function created() {
    var _this3 = this;

    Fire.$emit("byr_has_selected", this.$session.get("byr_buyer_id"));
    Fire.$emit("permission_check_for_buyer", this.$session.get("byr_buyer_id"));
    this.getbuyerJsonSettingvalue();
    this.item_id = this.$route.params.item_id;
    this.get_all_byr_order_item_detail();
    Fire.$on("LoadByrorderItemDetail", function () {
      _this3.get_all_byr_order_item_detail();
    });
    this.loader = Vue.$loading.show();
    this.item_search_parent_query = this.$session.get("order_item_search_query");
    this.orderListdetailQ = this.$session.get("order_param_data");
  },
  computed: {
    totalCostPriceVal: function totalCostPriceVal() {
      return this.order_item_detail_lists.reduce(function (sum, order_item_detail_list) {
        return sum + order_item_detail_list.mes_lis_shi_lin_amo_item_net_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;
      }, 0);
    },
    totalSellingPriceVal: function totalSellingPriceVal() {
      return this.order_item_detail_lists.reduce(function (sumselling, order_item_detail_list) {
        return sumselling + order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price * order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity;
      }, 0);
    }
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=template&id=6ad150ec&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=template&id=6ad150ec& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              "\n                " +
                                _vm._s(_vm.order_item_lists.receive_datetime) +
                                "\n              "
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("取引先")
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { colspan: "5" } }, [
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              "\n                " +
                                _vm._s(
                                  _vm.order_item_lists.mes_lis_shi_par_sel_code
                                ) +
                                "\n                " +
                                _vm._s(
                                  _vm.order_item_lists.mes_lis_shi_par_sel_name
                                ) +
                                "\n              "
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
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              "\n                " +
                                _vm._s(
                                  _vm.order_item_lists
                                    .mes_lis_shi_tra_dat_delivery_date
                                ) +
                                "\n              "
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
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              "\n                " +
                                _vm._s(
                                  _vm.order_item_lists
                                    .mes_lis_shi_tra_goo_major_category
                                ) +
                                "\n              "
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("便")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              "\n                " +
                                _vm._s(
                                  _vm.getbyrjsonValueBykeyName(
                                    "mes_lis_ord_log_del_delivery_service_code",
                                    _vm.order_item_lists
                                      .mes_lis_shi_log_del_delivery_service_code,
                                    "orders"
                                  )
                                ) +
                                "\n              "
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("温度区分")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_lists
                                  .mes_lis_shi_tra_ins_temperature_code
                              ) +
                                "\n                " +
                                _vm._s(
                                  _vm.getbyrjsonValueBykeyName(
                                    "mes_lis_ord_tra_ins_temperature_code",
                                    _vm.order_item_lists
                                      .mes_lis_shi_tra_ins_temperature_code,
                                    "orders"
                                  )
                                )
                            )
                          ])
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("商品コード")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_lists
                                  .mes_lis_shi_lin_ite_order_item_code
                              )
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("JANコード")
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { colspan: "5" } }, [
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              "\n                " +
                                _vm._s(
                                  _vm.order_item_lists.mes_lis_shi_lin_ite_gtin
                                ) +
                                "\n              "
                            )
                          ])
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("商品名")
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { colspan: "7" } }, [
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              "\n                " +
                                _vm._s(
                                  _vm.order_item_lists.mes_lis_shi_lin_ite_name
                                ) +
                                "\n              "
                            )
                          ])
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("規格名")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              _vm._s(
                                _vm.order_item_lists
                                  .mes_lis_shi_lin_ite_ite_spec
                              )
                            )
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color" }, [
                      _vm._v("産地")
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { colspan: "5" } }, [
                      _vm.order_item_lists && _vm.order_item_lists.length != 0
                        ? _c("span", [
                            _vm._v(
                              "\n                " +
                                _vm._s(
                                  _vm.order_item_lists
                                    .mes_lis_shi_lin_fre_field_name
                                ) +
                                "\n              "
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
                padding: "10px",
                "margin-bottom": "20px",
                "margin-top": "20px",
                background: "#dee6f0"
              }
            },
            [
              _c(
                "p",
                [
                  _c("router-link", { attrs: { to: "" } }, [
                    _vm._v("【一括入力】")
                  ]),
                  _vm._v(
                    "対象行のチェックボックス\n          を選択後、『選択行に一括反映』をクリックすると、入力値を選択行に一括反映します。\n        "
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "table",
                {
                  staticClass: "table orderDetailTable table-bordered",
                  staticStyle: { width: "100%" }
                },
                [
                  _c("tr", [
                    _c("td", { staticClass: "cl_custom_color_active" }, [
                      _vm._v("ケース数")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value:
                              _vm.order_item_lists
                                .mes_lis_shi_lin_qua_shi_num_of_order_units,
                            expression:
                              "\n                  order_item_lists.mes_lis_shi_lin_qua_shi_num_of_order_units\n                "
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "number", min: 0 },
                        domProps: {
                          value:
                            _vm.order_item_lists
                              .mes_lis_shi_lin_qua_shi_num_of_order_units
                        },
                        on: {
                          change: function($event) {
                            return _vm.caseBallUpdate(
                              _vm.order_item_lists,
                              "ケース"
                            )
                          },
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.order_item_lists,
                              "mes_lis_shi_lin_qua_shi_num_of_order_units",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color_active" }, [
                      _vm._v("バラ数")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value:
                              _vm.order_item_lists
                                .mes_lis_shi_lin_qua_shi_quantity,
                            expression:
                              "order_item_lists.mes_lis_shi_lin_qua_shi_quantity"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: {
                          type: "number",
                          min: 0,
                          step:
                            _vm.order_item_lists
                              .mes_lis_shi_lin_qua_unit_multiple
                        },
                        domProps: {
                          value:
                            _vm.order_item_lists
                              .mes_lis_shi_lin_qua_shi_quantity
                        },
                        on: {
                          change: function($event) {
                            return _vm.caseBallUpdate(
                              _vm.order_item_lists,
                              "バラ"
                            )
                          },
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.order_item_lists,
                              "mes_lis_shi_lin_qua_shi_quantity",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color_active" }, [
                      _vm._v("原単価")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value:
                              _vm.order_item_lists
                                .mes_lis_shi_lin_amo_item_net_price_unit_price,
                            expression:
                              "\n                  order_item_lists.mes_lis_shi_lin_amo_item_net_price_unit_price\n                "
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "number", min: 0 },
                        domProps: {
                          value:
                            _vm.order_item_lists
                              .mes_lis_shi_lin_amo_item_net_price_unit_price
                        },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.order_item_lists,
                              "mes_lis_shi_lin_amo_item_net_price_unit_price",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c("td", { staticClass: "cl_custom_color_active" }, [
                      _vm._v("売単価")
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value:
                              _vm.order_item_lists
                                .mes_lis_shi_lin_amo_item_selling_price_unit_price,
                            expression:
                              "\n                  order_item_lists.mes_lis_shi_lin_amo_item_selling_price_unit_price\n                "
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "number", min: 0 },
                        domProps: {
                          value:
                            _vm.order_item_lists
                              .mes_lis_shi_lin_amo_item_selling_price_unit_price
                        },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.order_item_lists,
                              "mes_lis_shi_lin_amo_item_selling_price_unit_price",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "cl_custom_color_active" }, [
                      _vm._v("欠品理由")
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { colspan: "5" } }, [
                      _c(
                        "select",
                        {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value:
                                _vm.order_item_lists
                                  .mes_lis_shi_lin_qua_sto_reason_code,
                              expression:
                                "order_item_lists.mes_lis_shi_lin_qua_sto_reason_code"
                            }
                          ],
                          staticClass: "form-control",
                          on: {
                            change: function($event) {
                              var $$selectedVal = Array.prototype.filter
                                .call($event.target.options, function(o) {
                                  return o.selected
                                })
                                .map(function(o) {
                                  var val = "_value" in o ? o._value : o.value
                                  return val
                                })
                              _vm.$set(
                                _vm.order_item_lists,
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
                                  "\n                  " +
                                    _vm._s(item) +
                                    "\n                "
                                )
                              ]
                            )
                          }
                        ),
                        0
                      )
                    ])
                  ])
                ]
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-12", staticStyle: { "text-align": "right" } },
          [
            _c(
              "button",
              {
                staticClass: "btn btn-primary",
                staticStyle: { float: "right" },
                on: { click: _vm.updateOrderItemFormData }
              },
              [_vm._v("\n        選択行に一括反映 ->\n      ")]
            )
          ]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }),
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
                        _c("td", [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_tra_trade_number
                              ) +
                              "\n              "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _vm._v(
                            _vm._s(
                              order_item_detail_list.mes_lis_shi_par_shi_code
                            )
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _vm._v(
                            _vm._s(
                              order_item_detail_list.mes_lis_shi_par_rec_code
                            )
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_lin_line_number
                              ) +
                              "\n              "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_fre_packing_quantity
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
                              min: 0,
                              max:
                                order_item_detail_list.mes_lis_shi_lin_qua_ord_num_of_order_units
                            },
                            domProps: {
                              value:
                                order_item_detail_list.mes_lis_shi_lin_qua_shi_num_of_order_units
                            },
                            on: {
                              change: function($event) {
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
                        _c("td", [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_qua_unit_of_measure
                              ) +
                              "\n                " +
                              _vm._s(
                                _vm.getbyrjsonValueBykeyName(
                                  "mes_lis_ord_lin_qua_unit_of_measure",
                                  order_item_detail_list.mes_lis_shi_lin_qua_unit_of_measure,
                                  "orders"
                                )
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
                                  order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity,
                                expression:
                                  "\n                    order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity\n                  "
                              }
                            ],
                            staticClass: "form-control",
                            attrs: {
                              type: "number",
                              min: 0,
                              max:
                                order_item_detail_list.mes_lis_shi_lin_qua_ord_quantity,
                              step:
                                order_item_detail_list.mes_lis_shi_lin_qua_unit_multiple
                            },
                            domProps: {
                              value:
                                order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity
                            },
                            on: {
                              change: function($event) {
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
                        _c("td", [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                order_item_detail_list.mes_lis_shi_lin_fre_item_weight *
                                  order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity
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
                            attrs: { type: "number", min: 0 },
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
                                  "\n                " +
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
                            attrs: { type: "number", min: 0 },
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
                                  "\n                " +
                                    _vm._s(
                                      _vm._f("priceFormat")(
                                        order_item_detail_list.mes_lis_shi_lin_amo_item_selling_price_unit_price *
                                          order_item_detail_list.mes_lis_shi_lin_qua_shi_quantity
                                      )
                                    ) +
                                    "\n                "
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
                            "\n                 " +
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
                              "\n\n              "
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
                              attrs: { colspan: "15" }
                            },
                            [_vm._v("データがありません")]
                          )
                        ])
                      : _vm._e()
                  ],
                  2
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn btn-primary pull-right text-right active",
                staticStyle: { float: "right" },
                on: { click: _vm.updateShipmentItemDetails }
              },
              [_vm._v("\n          更新\n        ")]
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
        _c("th", [_vm._v("伝票番号")]),
        _vm._v(" "),
        _c("th", [_vm._v("直接 納品先 コード")]),
        _vm._v(" "),
        _c("th", [_vm._v("最終 納品先 コード")]),
        _vm._v(" "),
        _c("th", [_vm._v("行")]),
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
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/DATA/ORDER/item_search_detail.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/backend/DATA/ORDER/item_search_detail.vue ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_search_detail_vue_vue_type_template_id_6ad150ec___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item_search_detail.vue?vue&type=template&id=6ad150ec& */ "./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=template&id=6ad150ec&");
/* harmony import */ var _item_search_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item_search_detail.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_search_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_search_detail_vue_vue_type_template_id_6ad150ec___WEBPACK_IMPORTED_MODULE_0__["render"],
  _item_search_detail_vue_vue_type_template_id_6ad150ec___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/DATA/ORDER/item_search_detail.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_search_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./item_search_detail.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_search_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=template&id=6ad150ec&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=template&id=6ad150ec& ***!
  \**********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_search_detail_vue_vue_type_template_id_6ad150ec___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./item_search_detail.vue?vue&type=template&id=6ad150ec& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/ORDER/item_search_detail.vue?vue&type=template&id=6ad150ec&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_search_detail_vue_vue_type_template_id_6ad150ec___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_search_detail_vue_vue_type_template_id_6ad150ec___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);