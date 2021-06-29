(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["scenario_management"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************/
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
// import tabList from "../CMN/tabList";
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'app',
  components: {// tabList,
  },
  data: function data() {
    return {
      'scenario_lists': {},
      'byr_buyer_id': ''
    };
  },
  methods: {
    get_all_scenarios: function get_all_scenarios() {
      var _this = this;

      axios.get(this.BASE_URL + "api/get_scenario_list").then(function (_ref) {
        var data = _ref.data;
        _this.scenario_lists = data.scenario_list;
      });
    }
  },
  created: function created() {
    this.get_all_scenarios();
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=template&id=5f9ae03b&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=template&id=5f9ae03b& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
          [_vm._v(_vm._s(_vm.myLang.scenario_heading))]
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
                      attrs: { colspan: "100%" }
                    },
                    [
                      _c(
                        "button",
                        {
                          staticClass: "btn pull-right text-right btn-primary",
                          staticStyle: { float: "right" }
                        },
                        [_vm._v(_vm._s(_vm.myLang.add_new))]
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
                    _vm._v(_vm._s(_vm.myLang.scenario_name))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.buyer_name))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.wholesaler_name))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.scenario_description))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.scenario_file_path))
                  ]),
                  _vm._v(" "),
                  _c("th", { staticStyle: { cursor: "pointer" } }, [
                    _vm._v(_vm._s(_vm.myLang.details))
                  ])
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.scenario_lists, function(value, index) {
                  return _c("tr", { key: value.id }, [
                    _c("td", [_vm._v(_vm._s(index + 1))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(value.name))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(value.super_code))]),
                    _vm._v(" "),
                    _c("td"),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(value.description))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(value.file_path))]),
                    _vm._v(" "),
                    _c("td", [
                      _c("button", { staticClass: "btn btn-info" }, [
                        _vm._v(_vm._s(_vm.myLang.details))
                      ])
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

/***/ "./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _scenario_management_vue_vue_type_template_id_5f9ae03b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./scenario_management.vue?vue&type=template&id=5f9ae03b& */ "./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=template&id=5f9ae03b&");
/* harmony import */ var _scenario_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scenario_management.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _scenario_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _scenario_management_vue_vue_type_template_id_5f9ae03b___WEBPACK_IMPORTED_MODULE_0__["render"],
  _scenario_management_vue_vue_type_template_id_5f9ae03b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_scenario_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./scenario_management.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_scenario_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=template&id=5f9ae03b&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=template&id=5f9ae03b& ***!
  \*****************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_scenario_management_vue_vue_type_template_id_5f9ae03b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./scenario_management.vue?vue&type=template&id=5f9ae03b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/JACOS_MANAGEMENT/scenario_management.vue?vue&type=template&id=5f9ae03b&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_scenario_management_vue_vue_type_template_id_5f9ae03b___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_scenario_management_vue_vue_type_template_id_5f9ae03b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);