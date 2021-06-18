(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["voucher_detail"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/voucher_detail.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/voucher_detail.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      'invoice_detail_lists': {},
      'byr_buyer_lists': {},
      'selected_byr': '0',
      'byr_shop_lists': {},
      'selected_byr_shop': '0',
      'byr_voucher_lists': {},
      'selected_byr_voucher': '0',
      'file': '',
      'byr_invoice_id': '',
      'voucher_number': '',
      'start_date': '',
      'end_date': '',
      'total_price': ''
    };
  },
  methods: {
    //get Table data
    get_all_invoice_detail: function get_all_invoice_detail() {
      var _this = this;

      axios.get(this.BASE_URL + "api/get_all_invoice_by_voucher_number/" + this.voucher_number).then(function (_ref) {
        var data = _ref.data;
        _this.invoice_detail_lists = data.invoice_list;
        _this.byr_buyer_lists = data.byr_buyer_list;
        _this.byr_shop_lists = data.shop_list;
        _this.byr_voucher_lists = data.voucher_list;
      });
    },
    check_byr_order_api: function check_byr_order_api() {
      var formData = new FormData();
      formData.append("up_file", this.file);
      formData.append("email", 'user@jacos.co.jp');
      formData.append("password", 'Qe75ymSr');
      axios({
        method: 'POST',
        url: this.BASE_URL + "api/job_exec/1",
        data: formData,
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(function (_ref2) {
        var data = _ref2.data;
        // console.log(response);
        Fire.$emit('LoadByrorder');
      })["catch"](function (response) {});
    },
    onChangeFileUpload: function onChangeFileUpload() {
      this.file = this.$refs.file.files[0];
      this.check_byr_order_api();
    },
    selectedOption: function selectedOption(option) {
      if (this.value) {
        return option.byr_buyer_id === this.value.byr_buyer_id;
      }

      return false;
    },
    selectedOption_shop: function selectedOption_shop(option) {
      if (this.value) {
        return option.byr_shop_id === this.value.byr_shop_id;
      }

      return false;
    },
    selectedOption_voucher: function selectedOption_voucher(option) {
      if (this.value) {
        return option.voucher_number === this.value.voucher_number;
      }

      return false;
    },
    change: function change(e) {
      var selectedCode = e.target.value;
      var option = this.options.find(function (option) {
        return selectedCode === option.byr_buyer_id;
      }); //   this.$emit("input", option);
    }
  },
  created: function created() {
    var _this2 = this;

    this.voucher_number = this.$route.params.voucher_number;
    this.get_all_invoice_detail();
    Fire.$on("LoadByrinvoice_detail", function () {
      _this2.get_all_invoice_detail();
    });
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/voucher_detail.vue?vue&type=template&id=29199d68&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/voucher_detail.vue?vue&type=template&id=29199d68& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
    {
      directives: [
        {
          name: "can",
          rawName: "v-can",
          value: ["byr_view"],
          expression: "['byr_view']"
        }
      ],
      staticClass: "row"
    },
    [
      _vm._m(0),
      _vm._v(" "),
      _vm._m(1),
      _vm._v(" "),
      _vm._m(2),
      _vm._v(" "),
      _c("div", { staticClass: "col-12" }, [
        _c("div", {}, [
          _c(
            "table",
            { staticClass: "table table-striped table-bordered data_table" },
            [
              _c("thead", [
                _c("tr", [
                  _c(
                    "th",
                    {
                      staticStyle: { border: "none" },
                      attrs: { colspan: "100%" }
                    },
                    [
                      _c(
                        "div",
                        {
                          staticClass: "input-group mb-1",
                          staticStyle: {
                            "margin-left": "10px",
                            "max-width": "250px",
                            float: "left"
                          }
                        },
                        [
                          _vm._m(3),
                          _vm._v(" "),
                          _c(
                            "select",
                            {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.selected_byr,
                                  expression: "selected_byr"
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
                                      var val =
                                        "_value" in o ? o._value : o.value
                                      return val
                                    })
                                  _vm.selected_byr = $event.target.multiple
                                    ? $$selectedVal
                                    : $$selectedVal[0]
                                }
                              }
                            },
                            [
                              _c("option", { domProps: { value: 0 } }, [
                                _vm._v("全小売")
                              ]),
                              _vm._v(" "),
                              _vm._l(_vm.byr_buyer_lists, function(
                                option,
                                index
                              ) {
                                return _c(
                                  "option",
                                  {
                                    key: index,
                                    domProps: {
                                      value: option.super_code,
                                      selected: _vm.selectedOption(option)
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                " +
                                        _vm._s(option.super_code) +
                                        "\n        "
                                    )
                                  ]
                                )
                              })
                            ],
                            2
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "input-group mb-1",
                          staticStyle: {
                            "margin-left": "10px",
                            "max-width": "250px",
                            float: "left"
                          }
                        },
                        [
                          _vm._m(4),
                          _vm._v(" "),
                          _c(
                            "select",
                            {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.selected_byr_shop,
                                  expression: "selected_byr_shop"
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
                                      var val =
                                        "_value" in o ? o._value : o.value
                                      return val
                                    })
                                  _vm.selected_byr_shop = $event.target.multiple
                                    ? $$selectedVal
                                    : $$selectedVal[0]
                                }
                              }
                            },
                            [
                              _c("option", { domProps: { value: 0 } }, [
                                _vm._v("全店舗")
                              ]),
                              _vm._v(" "),
                              _vm._l(_vm.byr_shop_lists, function(
                                option,
                                index
                              ) {
                                return _c(
                                  "option",
                                  {
                                    key: index,
                                    domProps: {
                                      value: option.byr_shop_id,
                                      selected: _vm.selectedOption_shop(option)
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                " +
                                        _vm._s(option.shop_name) +
                                        "\n        "
                                    )
                                  ]
                                )
                              })
                            ],
                            2
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "input-group mb-1",
                          staticStyle: {
                            "margin-left": "10px",
                            "max-width": "250px",
                            float: "left"
                          }
                        },
                        [
                          _vm._m(5),
                          _vm._v(" "),
                          _c(
                            "select",
                            {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.selected_byr_voucher,
                                  expression: "selected_byr_voucher"
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
                                      var val =
                                        "_value" in o ? o._value : o.value
                                      return val
                                    })
                                  _vm.selected_byr_voucher = $event.target
                                    .multiple
                                    ? $$selectedVal
                                    : $$selectedVal[0]
                                }
                              }
                            },
                            [
                              _c("option", { domProps: { value: 0 } }, [
                                _vm._v("全伝票")
                              ]),
                              _vm._v(" "),
                              _vm._l(_vm.byr_voucher_lists, function(
                                option,
                                index
                              ) {
                                return _c(
                                  "option",
                                  {
                                    key: index,
                                    domProps: {
                                      value: option.voucher_number,
                                      selected: _vm.selectedOption_voucher(
                                        option
                                      )
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                " +
                                        _vm._s(option.voucher_number) +
                                        "\n        "
                                    )
                                  ]
                                )
                              })
                            ],
                            2
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-primary",
                          staticStyle: { float: "right" }
                        },
                        [_vm._v("新規請求")]
                      )
                    ]
                  )
                ]),
                _vm._v(" "),
                _vm._m(6)
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.invoice_detail_lists, function(value, index) {
                  return _c("tr", { key: value.byr_invoice_detail_id }, [
                    _c("td", [_vm._v(_vm._s(index + 1))]),
                    _vm._v(" "),
                    value.item_name !== null && value.item_name !== ""
                      ? _c("td", [_vm._v(_vm._s(value.item_name))])
                      : _c("td", [_vm._v(_vm._s(value.item_name_kana))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(value.jan))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(value.order_quantity))]),
                    _vm._v(" "),
                    value.confirm_quantity !== null &&
                    value.confirm_quantity !== 0 &&
                    value.confirm_quantity !== ""
                      ? _c(
                          "td",
                          [
                            value.order_quantity != value.confirm_quantity
                              ? _c("b-icon", {
                                  directives: [
                                    {
                                      name: "tooltip",
                                      rawName: "v-tooltip.html",
                                      value:
                                        "Quantity details<br>" +
                                        value.order_quantity +
                                        "<br>" +
                                        value.confirm_quantity +
                                        "",
                                      expression:
                                        "'Quantity details<br>'+value.order_quantity+'<br>'+value.confirm_quantity+''",
                                      modifiers: { html: true }
                                    }
                                  ],
                                  attrs: {
                                    icon: "exclamation-circle-fill",
                                    variant: "warning",
                                    scale: "0.5"
                                  }
                                })
                              : _vm._e(),
                            _vm._v(_vm._s(value.confirm_quantity))
                          ],
                          1
                        )
                      : _c("td", [_vm._v(_vm._s(value.order_quantity))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(value.lack_reason))]),
                    _vm._v(" "),
                    value.revised_cost_unit_price !== null &&
                    value.revised_cost_unit_price !== 0 &&
                    value.revised_cost_unit_price !== ""
                      ? _c("td", [
                          _vm._v(_vm._s(value.revised_cost_unit_price))
                        ])
                      : _c("td", [_vm._v(_vm._s(value.cost_unit_price))]),
                    _vm._v(" "),
                    value.revised_cost_price !== null &&
                    value.revised_cost_price !== 0 &&
                    value.revised_cost_price !== ""
                      ? _c("td", [_vm._v(_vm._s(value.revised_cost_price))])
                      : _c("td", [_vm._v(_vm._s(value.cost_price))])
                  ])
                }),
                0
              )
            ]
          )
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-12" }, [
      _c(
        "h4",
        {
          staticClass: "top_title text-center",
          staticStyle: { "margin-top": "10px" }
        },
        [_vm._v("伝票一覧・新規請求")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-12 text-center" }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-4" }, [
          _c("table", { staticClass: "table table-bordered top_info_table" }, [
            _c("thead", [
              _c("th", [_vm._v("発注日")]),
              _vm._v(" "),
              _c("th", [_vm._v("納品日")]),
              _vm._v(" "),
              _c("th", [_vm._v("請求日")])
            ]),
            _vm._v(" "),
            _c("tbody", [
              _c("tr", [_c("td"), _vm._v(" "), _c("td"), _vm._v(" "), _c("td")])
            ])
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col" })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-12 text-center" }, [_c("label")])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "button",
        { staticClass: "btn btn-outline-primary", attrs: { type: "button" } },
        [_vm._v("小売選択")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "button",
        { staticClass: "btn btn-outline-primary", attrs: { type: "button" } },
        [_vm._v("店舗")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "button",
        { staticClass: "btn btn-outline-primary", attrs: { type: "button" } },
        [_vm._v("伝票番号")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c(
        "th",
        {
          staticClass: "sorting",
          staticStyle: { cursor: "pointer" },
          attrs: { "data-sorting_type": "asc", "data-column_name": "id" }
        },
        [_vm._v("No "), _c("span", { attrs: { id: "id_icon" } })]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "sorting",
          staticStyle: { cursor: "pointer" },
          attrs: { "data-sorting_type": "asc", "data-column_name": "name" }
        },
        [_vm._v("商品名"), _c("span", { attrs: { id: "orderdate_icon" } })]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "sorting",
          staticStyle: { cursor: "pointer" },
          attrs: { "data-sorting_type": "asc", "data-column_name": "email" }
        },
        [_vm._v("JANコード "), _c("span", { attrs: { id: "delivery_icon" } })]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "sorting",
          staticStyle: { cursor: "pointer" },
          attrs: { "data-sorting_type": "asc", "data-column_name": "email" }
        },
        [_vm._v("発注数量"), _c("span", { attrs: { id: "ordertype_icon" } })]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "sorting",
          staticStyle: { cursor: "pointer" },
          attrs: { "data-sorting_type": "asc", "data-column_name": "email" }
        },
        [_vm._v("納品数量"), _c("span", { attrs: { id: "ordertype_icon" } })]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "sorting",
          staticStyle: { cursor: "pointer" },
          attrs: { "data-sorting_type": "asc", "data-column_name": "email" }
        },
        [_vm._v("欠品理由"), _c("span", { attrs: { id: "ordertype_icon" } })]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "sorting",
          staticStyle: { cursor: "pointer" },
          attrs: { "data-sorting_type": "asc", "data-column_name": "email" }
        },
        [_vm._v("単価"), _c("span", { attrs: { id: "ordertype_icon" } })]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "sorting",
          staticStyle: { cursor: "pointer" },
          attrs: { "data-sorting_type": "asc", "data-column_name": "email" }
        },
        [_vm._v("合計金額"), _c("span", { attrs: { id: "ordertype_icon" } })]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/voucher_detail.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/backend/voucher_detail.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _voucher_detail_vue_vue_type_template_id_29199d68___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./voucher_detail.vue?vue&type=template&id=29199d68& */ "./resources/js/components/backend/voucher_detail.vue?vue&type=template&id=29199d68&");
/* harmony import */ var _voucher_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./voucher_detail.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/voucher_detail.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _voucher_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _voucher_detail_vue_vue_type_template_id_29199d68___WEBPACK_IMPORTED_MODULE_0__["render"],
  _voucher_detail_vue_vue_type_template_id_29199d68___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/voucher_detail.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/voucher_detail.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/backend/voucher_detail.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_voucher_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./voucher_detail.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/voucher_detail.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_voucher_detail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/voucher_detail.vue?vue&type=template&id=29199d68&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/backend/voucher_detail.vue?vue&type=template&id=29199d68& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_voucher_detail_vue_vue_type_template_id_29199d68___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./voucher_detail.vue?vue&type=template&id=29199d68& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/voucher_detail.vue?vue&type=template&id=29199d68&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_voucher_detail_vue_vue_type_template_id_29199d68___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_voucher_detail_vue_vue_type_template_id_29199d68___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);