(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["order_corrected_receive"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      'order_corrected_receive_lists': {},
      'byr_buyer_lists': {},
      'file': '',
      'selected_byr': '0'
    };
  },
  beforeCreate: function beforeCreate() {
    if (!this.$session.exists()) {
      this.$router.push('/home');
    }
  },
  methods: {
    //get Table data
    get_all_order: function get_all_order() {
      var _this = this;

      axios.get(this.BASE_URL + "api/corrected_receive_list/" + Globals.user_info_id).then(function (_ref) {
        var data = _ref.data;
        _this.order_corrected_receive_lists = data.data.corrected_list;
        _this.byr_buyer_lists = data.data.byr_buyer_list;
      });
    },
    check_byr_order_api: function check_byr_order_api() {
      var formData = new FormData();
      formData.append("up_file", this.file);
      axios({
        method: 'POST',
        url: this.BASE_URL + "api/job_exec/1",
        data: formData,
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(function (_ref2) {
        var data = _ref2.data;
        Fire.$emit('LoadByrorder');
      })["catch"](function (response) {});
    },
    onChangeFileUpload: function onChangeFileUpload() {
      this.file = this.$refs.file.files[0];
      this.check_byr_order_api();
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

    this.get_all_order();
    Fire.$on("LoadByrorder", function () {
      _this2.get_all_order();
    });
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=template&id=1673d748&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=template&id=1673d748& ***!
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
    {
      directives: [
        {
          name: "can",
          rawName: "v-can",
          value: ["slr_view"],
          expression: "['slr_view']"
        }
      ],
      staticClass: "row"
    },
    [
      _c("div", { staticClass: "col-12" }, [
        _c(
          "h4",
          {
            staticClass: "top_title text-center",
            staticStyle: { "margin-top": "10px" }
          },
          [_vm._v(_vm._s(_vm.myLang.corrected_receive_data))]
        )
      ]),
      _vm._v(" "),
      _vm._m(0),
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
                          _c("div", { staticClass: "input-group-prepend" }, [
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-outline-primary",
                                attrs: { type: "button" }
                              },
                              [_vm._v(_vm._s(_vm.myLang.buyer_selection))]
                            )
                          ]),
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
                                _vm._v(_vm._s(_vm.myLang.select_buyer))
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
                                      value: option.cmn_company_id,
                                      selected: _vm.selectedOption(option)
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                " +
                                        _vm._s(option.company_name) +
                                        "\n        "
                                    )
                                  ]
                                )
                              })
                            ],
                            2
                          )
                        ]
                      )
                    ]
                  )
                ]),
                _vm._v(" "),
                _c("tr", [
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v("No")
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.buyer_name))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.receive_date))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.download_date))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.received_data))
                  ])
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                [
                  _vm._l(_vm.order_corrected_receive_lists, function(
                    value,
                    index
                  ) {
                    return _c("tr", { key: value.byr_corrected_receive_id }, [
                      _c("td", [_vm._v(_vm._s(index + 1))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(value.company_name))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(value.receive_date))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(value.download_date))]),
                      _vm._v(" "),
                      _c("td", [
                        _c("button", { staticClass: "btn btn-primary" }, [
                          _vm._v(_vm._s(_vm.myLang.received_data))
                        ])
                      ])
                    ])
                  }),
                  _vm._v(" "),
                  _vm.order_corrected_receive_lists &&
                  _vm.order_corrected_receive_lists.length == 0
                    ? _c("tr", [
                        _c("td", { attrs: { colspan: "5" } }, [
                          _vm._v("データがありません")
                        ])
                      ])
                    : _vm._e()
                ],
                2
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
    return _c("div", { staticClass: "col-12 text-center" }, [_c("label")])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _order_corrected_receive_vue_vue_type_template_id_1673d748___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./order_corrected_receive.vue?vue&type=template&id=1673d748& */ "./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=template&id=1673d748&");
/* harmony import */ var _order_corrected_receive_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./order_corrected_receive.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _order_corrected_receive_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _order_corrected_receive_vue_vue_type_template_id_1673d748___WEBPACK_IMPORTED_MODULE_0__["render"],
  _order_corrected_receive_vue_vue_type_template_id_1673d748___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_order_corrected_receive_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./order_corrected_receive.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_order_corrected_receive_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=template&id=1673d748&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=template&id=1673d748& ***!
  \****************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_order_corrected_receive_vue_vue_type_template_id_1673d748___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./order_corrected_receive.vue?vue&type=template&id=1673d748& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DATA/CRTRCV/order_corrected_receive.vue?vue&type=template&id=1673d748&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_order_corrected_receive_vue_vue_type_template_id_1673d748___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_order_corrected_receive_vue_vue_type_template_id_1673d748___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);