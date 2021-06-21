(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["slr_job_list"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'app',
  data: function data() {
    return {
      slr_job_lists: {},
      slr_seller_id: '',
      job_exe_modal: false,
      byr_buyer_id: null
    };
  },
  methods: {
    get_all_slr_job_lists: function get_all_slr_job_lists() {
      var _this = this;

      axios.get(this.BASE_URL + "api/slr_job_list_by_seller_id/" + this.slr_seller_id).then(function (_ref) {
        var data = _ref.data;
        _this.slr_job_lists = data.slr_job_list;
      });
    },
    save_edit_job: function save_edit_job() {},
    job_exe_modal_show: function job_exe_modal_show(value) {
      this.job_exe_modal = true;
    }
  },
  created: function created() {
    this.slr_seller_id = this.$route.query.slr_seller_id;
    this.byr_buyer_id = this.$route.query.byr_buyer_id;
    this.get_all_slr_job_lists();
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=template&id=1b66bf42&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=template&id=1b66bf42& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
            "h4",
            {
              staticClass: "top_title text-center",
              staticStyle: { "margin-top": "10px" }
            },
            [_vm._v(_vm._s(_vm.myLang.super_value_head))]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-3" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-6" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-3" }),
        _vm._v(" "),
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }, [
          _c(
            "button",
            {
              staticClass: "btn pull-right text-right btn-primary",
              staticStyle: { float: "right" }
            },
            [_vm._v(_vm._s(_vm.myLang.add_new))]
          ),
          _vm._v(" "),
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
                        staticStyle: { border: "none", width: "150px" },
                        attrs: { colspan: "100%" }
                      },
                      [
                        _c(
                          "select",
                          {
                            staticClass: "form-control",
                            attrs: { name: "job_status" }
                          },
                          [
                            _c(
                              "option",
                              { attrs: { value: "稼働中", selected: "" } },
                              [_vm._v(_vm._s(_vm.myLang.status_in_operation))]
                            ),
                            _vm._v(" "),
                            _c("option", { attrs: { value: "稼働" } }, [
                              _vm._v(_vm._s(_vm.myLang.status_operation))
                            ])
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
                      _vm._v("Job ID")
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.user_type))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.route))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.scenario))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.schedule_setting))
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.slr_job_lists, function(value, index) {
                    return _c("tr", { key: value.cmn_job_id }, [
                      _c("td", [_vm._v(_vm._s(index + 1))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(value.cmn_job_id))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(value.class))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(value.vector))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(value.name))]),
                      _vm._v(" "),
                      _c("td", [
                        _c(
                          "select",
                          {
                            staticClass: "form-control",
                            attrs: { name: "user_status" }
                          },
                          [
                            _c(
                              "option",
                              { attrs: { value: "稼働中", selected: "" } },
                              [_vm._v(_vm._s(_vm.myLang.status_in_operation))]
                            ),
                            _vm._v(" "),
                            _c("option", { attrs: { value: "稼働" } }, [
                              _vm._v(_vm._s(_vm.myLang.status_operation))
                            ])
                          ]
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-info",
                            on: {
                              click: function($event) {
                                return _vm.job_exe_modal_show(value)
                              }
                            }
                          },
                          [_vm._v(_vm._s(_vm.myLang.schedule_setting))]
                        )
                      ])
                    ])
                  }),
                  0
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
              [_vm._v(_vm._s(_vm.myLang.save_changes))]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            size: "md",
            "hide-backdrop": true,
            title: _vm.myLang.folder_monitoring,
            "ok-title": _vm.myLang.save,
            "cancel-title": _vm.myLang.cancel
          },
          on: {
            ok: function($event) {
              $event.preventDefault()
              return _vm.save_edit_job()
            }
          },
          model: {
            value: _vm.job_exe_modal,
            callback: function($$v) {
              _vm.job_exe_modal = $$v
            },
            expression: "job_exe_modal"
          }
        },
        [
          _c("div", { staticClass: "panel-body add_item_body" }, [
            _c(
              "table",
              { staticClass: "table table-striped table-bordered data_table" },
              [
                _c("thead", [
                  _c("tr", [
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v("Job ID")
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.user_type))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.route))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.scenario))
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("tbody", [
                  _c("tr", [
                    _c("td", [_vm._v("1")]),
                    _vm._v(" "),
                    _c("td", [_vm._v("test")]),
                    _vm._v(" "),
                    _c("td", [_vm._v("発注")]),
                    _vm._v(" "),
                    _c("td", [_vm._v("小売 → Jacos")]),
                    _vm._v(" "),
                    _c("td", [_vm._v("OUK_BMS_ORDER")])
                  ])
                ])
              ]
            ),
            _vm._v(" "),
            _c("form")
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
    return _c("div", { staticClass: "col-12" }, [
      _c(
        "h4",
        {
          staticClass: "top_title text-center",
          staticStyle: { "margin-top": "10px" }
        },
        [_vm._v("株式会社サノテック")]
      ),
      _vm._v(" "),
      _c("p", { staticClass: "text-center" }, [
        _vm._v("問屋コード:00001 取引先コード:00001")
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/SLR/slr_job_list.vue":
/*!**************************************************************!*\
  !*** ./resources/js/components/backend/SLR/slr_job_list.vue ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _slr_job_list_vue_vue_type_template_id_1b66bf42___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./slr_job_list.vue?vue&type=template&id=1b66bf42& */ "./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=template&id=1b66bf42&");
/* harmony import */ var _slr_job_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./slr_job_list.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _slr_job_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _slr_job_list_vue_vue_type_template_id_1b66bf42___WEBPACK_IMPORTED_MODULE_0__["render"],
  _slr_job_list_vue_vue_type_template_id_1b66bf42___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/SLR/slr_job_list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_job_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./slr_job_list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_job_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=template&id=1b66bf42&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=template&id=1b66bf42& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_job_list_vue_vue_type_template_id_1b66bf42___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./slr_job_list.vue?vue&type=template&id=1b66bf42& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/slr_job_list.vue?vue&type=template&id=1b66bf42&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_job_list_vue_vue_type_template_id_1b66bf42___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_job_list_vue_vue_type_template_id_1b66bf42___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);