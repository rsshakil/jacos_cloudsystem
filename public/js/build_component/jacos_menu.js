(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["jacos_menu"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {};
  },
  methods: {},
  created: function created() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=template&id=568763df&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=template&id=568763df& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
    _c("ul", { staticClass: "nav jcs_left_side_bar_menu flex-column" }, [
      _c("li", { staticClass: "nav-item" }, [
        _c(
          "a",
          {
            staticClass: "nav-link collapsed",
            attrs: {
              href: "#jacosmenu1",
              "data-toggle": "collapse",
              "data-target": "#jacosmenu1"
            }
          },
          [
            _c("b-icon", { attrs: { icon: "gear-fill", "font-scale": "1.2" } }),
            _vm._v("\r\n            JACOS")
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "collapse",
            attrs: { id: "jacosmenu1", "aria-expanded": "false" }
          },
          [
            _c("ul", { staticClass: "flex-column pl-2 nav" }, [
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "can",
                      rawName: "v-can",
                      value: ["byr_view", "manage_user_menu"],
                      expression: "['byr_view','manage_user_menu']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "router-link",
                    { staticClass: "nav-link", attrs: { to: "/blog" } },
                    [
                      _c("b-icon", {
                        attrs: { icon: "house-fill", "font-scale": "1.2" }
                      }),
                      _vm._v(
                        "\r\n                  " +
                          _vm._s(_vm.myLang.new_notice) +
                          "\r\n                "
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "can",
                      rawName: "v-can",
                      value: ["byr_management"],
                      expression: "['byr_management']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "router-link",
                    {
                      staticClass: "nav-link",
                      attrs: { to: "/byr_management" }
                    },
                    [
                      _c("b-icon", {
                        attrs: { icon: "card-checklist", "font-scale": "1.2" }
                      }),
                      _vm._v(
                        "\r\n                  " +
                          _vm._s(_vm.myLang.buyer_management) +
                          "\r\n                "
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "can",
                      rawName: "v-can",
                      value: ["slr_management"],
                      expression: "['slr_management']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "router-link",
                    {
                      staticClass: "nav-link",
                      attrs: { to: "/slr_management" }
                    },
                    [
                      _c("b-icon", {
                        attrs: { icon: "card-checklist", "font-scale": "1.2" }
                      }),
                      _vm._v(
                        "\r\n                  " +
                          _vm._s(_vm.myLang.wholesaler_management) +
                          "\r\n                "
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "can",
                      rawName: "v-can",
                      value: ["scenario_management"],
                      expression: "['scenario_management']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "router-link",
                    {
                      staticClass: "nav-link",
                      attrs: { to: "/job_management" }
                    },
                    [
                      _c("b-icon", {
                        attrs: { icon: "card-checklist", "font-scale": "1.2" }
                      }),
                      _vm._v(
                        "\r\n                  " +
                          _vm._s(_vm.myLang.job_management) +
                          "\r\n                "
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "can",
                      rawName: "v-can",
                      value: ["scenario_management"],
                      expression: "['scenario_management']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "router-link",
                    {
                      staticClass: "nav-link",
                      attrs: { to: "/scenario_management" }
                    },
                    [
                      _c("b-icon", {
                        attrs: { icon: "card-checklist", "font-scale": "1.2" }
                      }),
                      _vm._v(
                        "\r\n                  " +
                          _vm._s(_vm.myLang.scenario_management) +
                          "\r\n                "
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  directives: [
                    {
                      name: "can",
                      rawName: "v-can",
                      value: ["byr_view"],
                      expression: "['byr_view']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "a",
                    {
                      staticClass: "nav-link collapsed",
                      attrs: {
                        href: "#pdf_platform_setting",
                        "data-toggle": "collapse",
                        "data-target": "#pdf_platform_setting"
                      }
                    },
                    [
                      _c("b-icon", {
                        attrs: { icon: "grid-fill", "font-scale": "1.2" }
                      }),
                      _vm._v(
                        "\r\n            " + _vm._s(_vm.myLang.pdf_platform)
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "collapse",
                      attrs: {
                        id: "pdf_platform_setting",
                        "aria-expanded": "false"
                      }
                    },
                    [
                      _c("ul", { staticClass: "flex-column pl-2 nav" }, [
                        _c(
                          "li",
                          {
                            directives: [
                              {
                                name: "can",
                                rawName: "v-can",
                                value: ["pdf_platform_setting"],
                                expression: "['pdf_platform_setting']"
                              }
                            ],
                            staticClass: "nav-item"
                          },
                          [
                            _c(
                              "router-link",
                              {
                                staticClass: "nav-link",
                                attrs: { to: "/pdf_platform_setting" }
                              },
                              [
                                _c("b-icon", {
                                  attrs: {
                                    icon: "receipt",
                                    "font-scale": "1.2"
                                  }
                                }),
                                _vm._v(
                                  "\r\n                  " +
                                    _vm._s(_vm.myLang.pdf_platform_setting) +
                                    "\r\n                "
                                )
                              ],
                              1
                            )
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "li",
                          {
                            directives: [
                              {
                                name: "can",
                                rawName: "v-can",
                                value: ["pdf_platform_view"],
                                expression: "['pdf_platform_view']"
                              }
                            ],
                            staticClass: "nav-item"
                          },
                          [
                            _c(
                              "router-link",
                              {
                                staticClass: "nav-link",
                                attrs: { to: "/pdf_platform_view" }
                              },
                              [
                                _c("b-icon", {
                                  attrs: {
                                    icon: "receipt",
                                    "font-scale": "1.2"
                                  }
                                }),
                                _vm._v(
                                  "\r\n                  " +
                                    _vm._s(_vm.myLang.pdf_platform_show) +
                                    "\r\n                "
                                )
                              ],
                              1
                            )
                          ],
                          1
                        )
                      ])
                    ]
                  )
                ]
              )
            ])
          ]
        )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/DFLT/MENU/jacos_menu.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/MENU/jacos_menu.vue ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _jacos_menu_vue_vue_type_template_id_568763df___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./jacos_menu.vue?vue&type=template&id=568763df& */ "./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=template&id=568763df&");
/* harmony import */ var _jacos_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./jacos_menu.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _jacos_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _jacos_menu_vue_vue_type_template_id_568763df___WEBPACK_IMPORTED_MODULE_0__["render"],
  _jacos_menu_vue_vue_type_template_id_568763df___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/DFLT/MENU/jacos_menu.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_jacos_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./jacos_menu.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_jacos_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=template&id=568763df&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=template&id=568763df& ***!
  \*************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_jacos_menu_vue_vue_type_template_id_568763df___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./jacos_menu.vue?vue&type=template&id=568763df& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/jacos_menu.vue?vue&type=template&id=568763df&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_jacos_menu_vue_vue_type_template_id_568763df___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_jacos_menu_vue_vue_type_template_id_568763df___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);