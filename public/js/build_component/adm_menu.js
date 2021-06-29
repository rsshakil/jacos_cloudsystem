(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["adm_menu"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {};
  },
  methods: {},
  created: function created() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=template&id=2848bba5&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=template&id=2848bba5& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
              href: "#admmenu1",
              "data-toggle": "collapse",
              "data-target": "#admmenu1"
            }
          },
          [
            _c("b-icon", { attrs: { icon: "gear-fill", "font-scale": "1.2" } }),
            _vm._v("\n            ADM")
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "collapse",
            attrs: { id: "admmenu1", "aria-expanded": "false" }
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
                      value: ["manage_user_menu"],
                      expression: "['manage_user_menu']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "router-link",
                    { staticClass: "nav-link", attrs: { to: "/users" } },
                    [
                      _c("b-icon", {
                        attrs: { icon: "person-circle", "font-scale": "1.2" }
                      }),
                      _vm._v(
                        "\n                  " +
                          _vm._s(_vm.myLang.manage_users) +
                          "\n                "
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
                      value: ["role_menu"],
                      expression: "['role_menu']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "router-link",
                    { staticClass: "nav-link", attrs: { to: "/role" } },
                    [
                      _c("b-icon", {
                        attrs: {
                          icon: "person-check-fill",
                          "font-scale": "1.2"
                        }
                      }),
                      _vm._v(
                        "\n                  " +
                          _vm._s(_vm.myLang.role_management) +
                          "\n                "
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
                      value: ["permission_menu"],
                      expression: "['permission_menu']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "router-link",
                    { staticClass: "nav-link", attrs: { to: "/permission" } },
                    [
                      _c("b-icon", {
                        attrs: {
                          icon: "person-bounding-box",
                          "font-scale": "1.2"
                        }
                      }),
                      _vm._v(
                        "\n                  " +
                          _vm._s(_vm.myLang.permission_management) +
                          "\n                "
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
                      value: ["assign_role_to_user_menu"],
                      expression: "['assign_role_to_user_menu']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "router-link",
                    {
                      staticClass: "nav-link",
                      attrs: { to: "/assign_role_to_user" }
                    },
                    [
                      _c("b-icon", {
                        attrs: {
                          icon: "folder-symlink-fill",
                          "font-scale": "1.2"
                        }
                      }),
                      _vm._v(
                        "\n                  " +
                          _vm._s(_vm.myLang.assign_role_to_user) +
                          "\n                "
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
                      value: ["assign_permission_to_user_menu"],
                      expression: "['assign_permission_to_user_menu']"
                    }
                  ],
                  staticClass: "nav-item"
                },
                [
                  _c(
                    "router-link",
                    {
                      staticClass: "nav-link",
                      attrs: { to: "/assign_permission_to_user" }
                    },
                    [
                      _c("b-icon", {
                        attrs: { icon: "unlock-fill", "font-scale": "1.2" }
                      }),
                      _vm._v(
                        "\n                  " +
                          _vm._s(_vm.myLang.assign_permission_to_user) +
                          "\n                "
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
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/DFLT/MENU/adm_menu.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/MENU/adm_menu.vue ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _adm_menu_vue_vue_type_template_id_2848bba5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./adm_menu.vue?vue&type=template&id=2848bba5& */ "./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=template&id=2848bba5&");
/* harmony import */ var _adm_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./adm_menu.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _adm_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _adm_menu_vue_vue_type_template_id_2848bba5___WEBPACK_IMPORTED_MODULE_0__["render"],
  _adm_menu_vue_vue_type_template_id_2848bba5___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/DFLT/MENU/adm_menu.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_adm_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./adm_menu.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_adm_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=template&id=2848bba5&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=template&id=2848bba5& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_adm_menu_vue_vue_type_template_id_2848bba5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./adm_menu.vue?vue&type=template&id=2848bba5& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/adm_menu.vue?vue&type=template&id=2848bba5&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_adm_menu_vue_vue_type_template_id_2848bba5___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_adm_menu_vue_vue_type_template_id_2848bba5___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);