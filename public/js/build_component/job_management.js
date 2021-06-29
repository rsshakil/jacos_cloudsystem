(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["job_management"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************/
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
// import tabList from "../CMN/tabList";
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'app',
  components: {// tabList,
  },
  data: function data() {
    return {
      'scenario_lists': {},
      'slr_job_lists': {},
      'byr_company_list': [],
      'slr_company_list': [],
      'byr_buyer_id': '',
      form: new Form({
        select_byr_company_id: [],
        select_slr_company_id: []
      })
    };
  },
  methods: {
    get_all_scenarios: function get_all_scenarios() {
      var _this = this;

      axios.get(this.BASE_URL + "api/get_scenario_list").then(function (_ref) {
        var data = _ref.data;
        _this.scenario_lists = data.data.scenario_list;
      });
    },
    get_all_slr_job_lists: function get_all_slr_job_lists() {
      var _this2 = this;

      axios.get(this.BASE_URL + "api/slr_job_list_all").then(function (_ref2) {
        var data = _ref2.data;
        _this2.slr_job_lists = data.job_list;
        _this2.byr_company_list = data.byr_company_list;
        _this2.slr_company_list = data.slr_company_list;
      });
    }
  },
  created: function created() {
    //this.get_all_scenarios();
    this.get_all_slr_job_lists();
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=template&id=0f8605a8&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=template&id=0f8605a8& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", [
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-12" }, [
        _c(
          "h4",
          {
            staticClass: "top_title text-center",
            staticStyle: { "margin-top": "10px" }
          },
          [_vm._v(_vm._s(_vm.myLang.job_management_heading))]
        )
      ]),
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
                      attrs: { colspan: "3" }
                    },
                    [
                      _c(
                        "multiselect",
                        {
                          attrs: {
                            id: "j_code",
                            placeholder: "Company name",
                            label: "company_name",
                            "track-by": "cmn_company_id",
                            options: _vm.slr_company_list,
                            multiple: true,
                            "close-on-select": false,
                            "clear-on-select": false,
                            "preserve-search": true,
                            "open-direction": "bottom"
                          },
                          model: {
                            value: _vm.form.select_byr_company_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "select_byr_company_id", $$v)
                            },
                            expression: "form.select_byr_company_id"
                          }
                        },
                        [
                          _c(
                            "span",
                            { attrs: { slot: "noOptions" }, slot: "noOptions" },
                            [_vm._v("候補がありません")]
                          ),
                          _vm._v(" "),
                          _c(
                            "span",
                            { attrs: { slot: "noResult" }, slot: "noResult" },
                            [_vm._v("候補がありません")]
                          )
                        ]
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticStyle: { border: "none" },
                      attrs: { colspan: "3" }
                    },
                    [
                      _c(
                        "multiselect",
                        {
                          attrs: {
                            id: "super_code",
                            placeholder: "Company name",
                            label: "company_name",
                            "track-by": "cmn_company_id",
                            options: _vm.byr_company_list,
                            multiple: true,
                            "close-on-select": false,
                            "clear-on-select": false,
                            "preserve-search": true,
                            "open-direction": "bottom"
                          },
                          model: {
                            value: _vm.form.select_slr_company_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "select_slr_company_id", $$v)
                            },
                            expression: "form.select_slr_company_id"
                          }
                        },
                        [
                          _c(
                            "span",
                            { attrs: { slot: "noOptions" }, slot: "noOptions" },
                            [_vm._v("候補がありません")]
                          ),
                          _vm._v(" "),
                          _c(
                            "span",
                            { attrs: { slot: "noResult" }, slot: "noResult" },
                            [_vm._v("候補がありません")]
                          )
                        ]
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticStyle: { border: "none" },
                      attrs: { colspan: "2" }
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
                  ),
                  _vm._v(" "),
                  _c("th", {
                    staticStyle: { "border-right": "0", "border-left": "0" },
                    attrs: { colspan: "3" }
                  })
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
                    _vm._v(_vm._s(_vm.myLang.byr_company_name))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.slr_company_name))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.byr_super_code))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.slr_jcode))
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
                  ]),
                  _vm._v(" "),
                  _c("td", [_vm._v("Action")])
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
                    _c("td", [_vm._v(_vm._s(value.byr_company))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(value.slr_company))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(value.super_code))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(value.jcode))]),
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
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
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

/***/ "./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _job_management_vue_vue_type_template_id_0f8605a8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./job_management.vue?vue&type=template&id=0f8605a8& */ "./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=template&id=0f8605a8&");
/* harmony import */ var _job_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./job_management.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _job_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _job_management_vue_vue_type_template_id_0f8605a8___WEBPACK_IMPORTED_MODULE_0__["render"],
  _job_management_vue_vue_type_template_id_0f8605a8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_job_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./job_management.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_job_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=template&id=0f8605a8&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=template&id=0f8605a8& ***!
  \************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_job_management_vue_vue_type_template_id_0f8605a8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./job_management.vue?vue&type=template&id=0f8605a8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/JACOS_MANAGEMENT/job_management.vue?vue&type=template&id=0f8605a8&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_job_management_vue_vue_type_template_id_0f8605a8___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_job_management_vue_vue_type_template_id_0f8605a8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);