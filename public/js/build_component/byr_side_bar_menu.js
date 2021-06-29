(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["byr_side_bar_menu"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "sidebar",
  props: ["permissions_by_user"],
  data: function data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content") // permission_by_user:[],

    };
  },
  methods: {},
  created: function created() {// console.log(this.permissions_by_user);
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=template&id=511e39ae&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=template&id=511e39ae& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
      _c(
        "li",
        {
          directives: [
            {
              name: "can",
              rawName: "v-can",
              value: ["byr_view", "slr_view"],
              expression: "['byr_view','slr_view']"
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
                href: "#byrmenu",
                "data-toggle": "collapse",
                "data-target": "#byrmenu"
              }
            },
            [
              _c("b-icon", {
                attrs: { icon: "grid-fill", "font-scale": "1.2" }
              }),
              _vm._v("\n            " + _vm._s(_vm.myLang.buyer_management))
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "collapse",
              attrs: { id: "byrmenu", "aria-expanded": "false" }
            },
            [
              _c(
                "ul",
                { staticClass: "flex-column pl-2 nav" },
                _vm._l(_vm.permissions_by_user, function(permission) {
                  return _c(
                    "li",
                    { key: permission.permission_id, staticClass: "nav-item" },
                    [
                      _c(
                        "router-link",
                        {
                          staticClass: "nav-link",
                          attrs: { to: "/" + permission.permission_name }
                        },
                        [
                          _c("b-icon", {
                            attrs: { icon: "receipt", "font-scale": "1.2" }
                          }),
                          _vm._v(
                            "\n                  " +
                              _vm._s(permission.permission_name) +
                              "\n                "
                          )
                        ],
                        1
                      )
                    ],
                    1
                  )
                }),
                0
              )
            ]
          )
        ]
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _byr_side_bar_menu_vue_vue_type_template_id_511e39ae___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./byr_side_bar_menu.vue?vue&type=template&id=511e39ae& */ "./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=template&id=511e39ae&");
/* harmony import */ var _byr_side_bar_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./byr_side_bar_menu.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _byr_side_bar_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _byr_side_bar_menu_vue_vue_type_template_id_511e39ae___WEBPACK_IMPORTED_MODULE_0__["render"],
  _byr_side_bar_menu_vue_vue_type_template_id_511e39ae___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_side_bar_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./byr_side_bar_menu.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_side_bar_menu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=template&id=511e39ae&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=template&id=511e39ae& ***!
  \********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_side_bar_menu_vue_vue_type_template_id_511e39ae___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./byr_side_bar_menu.vue?vue&type=template&id=511e39ae& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue?vue&type=template&id=511e39ae&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_side_bar_menu_vue_vue_type_template_id_511e39ae___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_side_bar_menu_vue_vue_type_template_id_511e39ae___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);