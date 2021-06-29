(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["App"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/app.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/app.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************/
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
var navbar = function navbar() {
  return __webpack_require__.e(/*! import() | navbar */ "navbar").then(__webpack_require__.bind(null, /*! ./DFLT/navbar */ "./resources/js/components/backend/DFLT/navbar.vue"));
};

var sidebar = function sidebar() {
  return __webpack_require__.e(/*! import() | sidebar */ "sidebar").then(__webpack_require__.bind(null, /*! ./DFLT/side_bar */ "./resources/js/components/backend/DFLT/side_bar.vue"));
};

var projectfooter = function projectfooter() {
  return __webpack_require__.e(/*! import() | projectfooter */ "projectfooter").then(__webpack_require__.bind(null, /*! ./DFLT/footer */ "./resources/js/components/backend/DFLT/footer.vue"));
};

var page_header_default = function page_header_default() {
  return __webpack_require__.e(/*! import() | page_header_default */ "page_header_default").then(__webpack_require__.bind(null, /*! ./page_header_default */ "./resources/js/components/backend/page_header_default.vue"));
}; // import navbar from './DFLT/navbar'
// import sidebar from './DFLT/side_bar'
// import projectfooter from './DFLT/footer'
// import page_header_default from './page_header_default'


/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'app',
  components: {
    navbar: navbar,
    sidebar: sidebar,
    projectfooter: projectfooter,
    page_header_default: page_header_default
  },
  data: function data() {
    return {
      user: null,
      // loading:false,
      initiated: false,
      // BASE_URL:Globals.base_url,
      req: axios.create({
        BASE_URL: this.BASE_URL
      })
    };
  },
  methods: {
    changePasswordModal: function changePasswordModal(user_id, user_name) {
      // this.init_user();
      // this.fieldsEmpty();
      // this.password_modal_title='Change the password for '+user_name;
      this.passwordModalShow = true;
      this.user_update_id = user_id;
    }
  },
  created: function created() {// this.loading=false;
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/app.vue?vue&type=template&id=1885342b&":
/*!**************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/app.vue?vue&type=template&id=1885342b& ***!
  \**************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "container-fluid" }, [
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        { staticClass: "col-md-12 p-0" },
        [_c("navbar", { attrs: { app: this } })],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        { staticClass: "col-md-2 px-0" },
        [_c("sidebar", { attrs: { app: this } })],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-10" }, [
        _c(
          "div",
          {
            staticClass: "stats-small stats-small--1 card card-small",
            staticStyle: { "margin-top": "20px" }
          },
          [
            _c(
              "div",
              { staticClass: "card-body p-3" },
              [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    { staticClass: "col-12 custombredcumbs" },
                    [
                      _c("app-breadcrumbs", {
                        attrs: { container: "nav" },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function(ref) {
                              var to = ref.to
                              var label = ref.label
                              var utils = ref.utils
                              return _c(
                                "h6",
                                {},
                                [
                                  _c(
                                    "router-link",
                                    {
                                      staticClass: "your-custom-class",
                                      attrs: {
                                        to: to,
                                        exact: "",
                                        itemprop: utils && utils.itemprop
                                      }
                                    },
                                    [_vm._v(_vm._s(label))]
                                  ),
                                  _vm._v(" "),
                                  _c("i", { staticClass: "fas fa-angle-right" })
                                ],
                                1
                              )
                            }
                          },
                          {
                            key: "current",
                            fn: function(ref) {
                              var label = ref.label
                              return _c(
                                "span",
                                { staticClass: "custom-current-class" },
                                [_vm._v(_vm._s(label))]
                              )
                            }
                          }
                        ])
                      }),
                      _vm._v(" "),
                      _c("div", {
                        staticClass: "clear-both",
                        staticStyle: { clear: "fix" }
                      }),
                      _vm._v(" "),
                      _c("page_header_default")
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("router-view", { key: _vm.$route.fullPath })
              ],
              1
            )
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "col-md-12",
          staticStyle: { "margin-top": "70px", padding: "0px" }
        },
        [_c("projectfooter")],
        1
      )
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

/***/ "./resources/js/components/backend/app.vue":
/*!*************************************************!*\
  !*** ./resources/js/components/backend/app.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _app_vue_vue_type_template_id_1885342b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app.vue?vue&type=template&id=1885342b& */ "./resources/js/components/backend/app.vue?vue&type=template&id=1885342b&");
/* harmony import */ var _app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./app.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/app.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _app_vue_vue_type_template_id_1885342b___WEBPACK_IMPORTED_MODULE_0__["render"],
  _app_vue_vue_type_template_id_1885342b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/app.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/app.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/components/backend/app.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./app.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/app.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/app.vue?vue&type=template&id=1885342b&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/backend/app.vue?vue&type=template&id=1885342b& ***!
  \********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_app_vue_vue_type_template_id_1885342b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./app.vue?vue&type=template&id=1885342b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/app.vue?vue&type=template&id=1885342b&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_app_vue_vue_type_template_id_1885342b___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_app_vue_vue_type_template_id_1885342b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);