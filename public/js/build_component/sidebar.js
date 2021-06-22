(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["sidebar"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/side_bar.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DFLT/side_bar.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************/
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
var adm_menu = function adm_menu() {
  return __webpack_require__.e(/*! import() | adm_menu */ "adm_menu").then(__webpack_require__.bind(null, /*! ./MENU/adm_menu */ "./resources/js/components/backend/DFLT/MENU/adm_menu.vue"));
};

var common_menu = function common_menu() {
  return __webpack_require__.e(/*! import() | common_menu */ "common_menu").then(__webpack_require__.bind(null, /*! ./MENU/common_menu */ "./resources/js/components/backend/DFLT/MENU/common_menu.vue"));
};

var jacos_menu = function jacos_menu() {
  return __webpack_require__.e(/*! import() | jacos_menu */ "jacos_menu").then(__webpack_require__.bind(null, /*! ./MENU/jacos_menu */ "./resources/js/components/backend/DFLT/MENU/jacos_menu.vue"));
};

var byr_side_bar_menu = function byr_side_bar_menu() {
  return __webpack_require__.e(/*! import() | byr_side_bar_menu */ "byr_side_bar_menu").then(__webpack_require__.bind(null, /*! ./MENU/byr_side_bar_menu */ "./resources/js/components/backend/DFLT/MENU/byr_side_bar_menu.vue"));
};

var byr_menu = function byr_menu() {
  return __webpack_require__.e(/*! import() | byr_menu */ "byr_menu").then(__webpack_require__.bind(null, /*! ./MENU/byr_menu */ "./resources/js/components/backend/DFLT/MENU/byr_menu.vue"));
};

var slr_menu = function slr_menu() {
  return __webpack_require__.e(/*! import() | slr_menu */ "slr_menu").then(__webpack_require__.bind(null, /*! ./MENU/slr_menu */ "./resources/js/components/backend/DFLT/MENU/slr_menu.vue"));
};

var others_menu = function others_menu() {
  return __webpack_require__.e(/*! import() | others_menu */ "others_menu").then(__webpack_require__.bind(null, /*! ./MENU/others_menu */ "./resources/js/components/backend/DFLT/MENU/others_menu.vue"));
};

var user_menu = function user_menu() {
  return __webpack_require__.e(/*! import() | user_menu */ "user_menu").then(__webpack_require__.bind(null, /*! ./MENU/user_menu */ "./resources/js/components/backend/DFLT/MENU/user_menu.vue"));
}; // import adm_menu from './MENU/adm_menu'
// import common_menu from './MENU/common_menu'
// import jacos_menu from './MENU/jacos_menu'
// import byr_side_bar_menu from './MENU/byr_side_bar_menu'
// import byr_menu from './MENU/byr_menu'
// import slr_menu from './MENU/slr_menu'
// import others_menu from './MENU/others_menu'
// import user_menu from './MENU/user_menu'


/* harmony default export */ __webpack_exports__["default"] = ({
  name: "sidebar",
  props: ["app"],
  components: {
    byr_side_bar_menu: byr_side_bar_menu,
    adm_menu: adm_menu,
    common_menu: common_menu,
    jacos_menu: jacos_menu,
    byr_menu: byr_menu,
    slr_menu: slr_menu,
    others_menu: others_menu,
    user_menu: user_menu
  },
  data: function data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
      permissions_by_user: [],
      permission_menu: false
    };
  },
  methods: {
    logout: function logout() {
      var _this = this;

      axios.post("logout").then(function (response) {
        _this.init(response.status);

        if (response.status === 302 || 401) {} else {// throw error and go to catch block
        }
      })["catch"](function (error) {});
    },
    allPermissionCheck: function allPermissionCheck() {
      var _this2 = this;

      var byr_id = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;

      if (this.$route.name !== 'home') {
        axios.post(this.BASE_URL + 'api/get_permissions_for_buyer', {
          byr_id: byr_id
        }).then(function (_ref) {
          var data = _ref.data;
          _this2.permissions_by_user = data.permission_array;

          if (_this2.permissions_by_user.length > 0) {
            _this2.permission_menu = true;
          }
        });
      }
    }
  },
  created: function created() {
    var _this3 = this;

    // this.allPermissionCheck();
    Fire.$on("permission_check_for_buyer", function (byr_id) {
      _this3.allPermissionCheck(byr_id);
    });
    Fire.$on("buyer_session_destroy", function () {
      _this3.$session.destroy();

      _this3.permission_menu = false;
      Fire.$emit('byr_has_selected');
    });
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/side_bar.vue?vue&type=template&id=a3fe27cc&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/DFLT/side_bar.vue?vue&type=template&id=a3fe27cc& ***!
  \************************************************************************************************************************************************************************************************************************/
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
    "aside",
    {
      staticClass: "main-sidebar custom_sidebar",
      staticStyle: {
        position: "absolute",
        top: "20px",
        width: "94%",
        left: "15px"
      }
    },
    [
      _c(
        "div",
        { staticClass: "nav-wrapper" },
        [
          _c("ul", { staticClass: "nav jcs_left_side_bar_menu flex-column" }, [
            _c(
              "li",
              { staticClass: "nav-item" },
              [
                _c(
                  "router-link",
                  { staticClass: "nav-link", attrs: { to: "/home" } },
                  [
                    _c("b-icon", {
                      attrs: { icon: "house-fill", "font-scale": "1.2" }
                    }),
                    _vm._v(" Home\n        ")
                  ],
                  1
                )
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("adm_menu", {
            directives: [
              {
                name: "role",
                rawName: "v-role",
                value: ["Super Admin"],
                expression: "['Super Admin']"
              }
            ]
          }),
          _vm._v(" "),
          _c("common_menu", {
            directives: [
              {
                name: "role",
                rawName: "v-role",
                value: ["Super Admin"],
                expression: "['Super Admin']"
              }
            ]
          }),
          _vm._v(" "),
          _c("jacos_menu", {
            directives: [
              {
                name: "role",
                rawName: "v-role",
                value: ["Super Admin"],
                expression: "['Super Admin']"
              }
            ]
          }),
          _vm._v(" "),
          _vm.permission_menu
            ? _c("slr_menu", {
                directives: [
                  {
                    name: "can",
                    rawName: "v-can",
                    value: ["slr_view"],
                    expression: "['slr_view']"
                  }
                ],
                attrs: { permissions_by_user: _vm.permissions_by_user }
              })
            : _vm._e(),
          _vm._v(" "),
          _c("byr_menu", {
            directives: [
              {
                name: "can",
                rawName: "v-can",
                value: ["byr_view"],
                expression: "['byr_view']"
              }
            ]
          }),
          _vm._v(" "),
          _c("user_menu", {
            directives: [
              {
                name: "role",
                rawName: "v-role",
                value: ["Super Admin"],
                expression: "['Super Admin']"
              }
            ]
          }),
          _vm._v(" "),
          _c("others_menu", {
            directives: [
              {
                name: "role",
                rawName: "v-role",
                value: ["Super Admin"],
                expression: "['Super Admin']"
              }
            ]
          }),
          _vm._v(" "),
          _vm.permission_menu
            ? _c("byr_side_bar_menu", {
                directives: [
                  {
                    name: "role",
                    rawName: "v-role",
                    value: ["Super Admin"],
                    expression: "['Super Admin']"
                  }
                ],
                attrs: { permissions_by_user: _vm.permissions_by_user }
              })
            : _vm._e()
        ],
        1
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/DFLT/side_bar.vue":
/*!***********************************************************!*\
  !*** ./resources/js/components/backend/DFLT/side_bar.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _side_bar_vue_vue_type_template_id_a3fe27cc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./side_bar.vue?vue&type=template&id=a3fe27cc& */ "./resources/js/components/backend/DFLT/side_bar.vue?vue&type=template&id=a3fe27cc&");
/* harmony import */ var _side_bar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./side_bar.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/DFLT/side_bar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _side_bar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _side_bar_vue_vue_type_template_id_a3fe27cc___WEBPACK_IMPORTED_MODULE_0__["render"],
  _side_bar_vue_vue_type_template_id_a3fe27cc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/DFLT/side_bar.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/DFLT/side_bar.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/side_bar.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_side_bar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./side_bar.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/side_bar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_side_bar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/DFLT/side_bar.vue?vue&type=template&id=a3fe27cc&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/backend/DFLT/side_bar.vue?vue&type=template&id=a3fe27cc& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_side_bar_vue_vue_type_template_id_a3fe27cc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./side_bar.vue?vue&type=template&id=a3fe27cc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/DFLT/side_bar.vue?vue&type=template&id=a3fe27cc&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_side_bar_vue_vue_type_template_id_a3fe27cc___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_side_bar_vue_vue_type_template_id_a3fe27cc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);