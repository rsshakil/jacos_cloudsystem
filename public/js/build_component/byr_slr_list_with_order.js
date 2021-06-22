(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["byr_slr_list_with_order"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      byr_slr_list: "",
      slr_order_list: null
    };
  },
  methods: {
    loadData: function loadData() {
      var _this = this;

      axios.post(this.BASE_URL + "api/get_byr_order_data_by_slr", {
        user_id: this.myLang.user_info_id
      }).then(function (_ref) {
        var data = _ref.data;
        _this.slr_order_list = data.slr_order_info;
      });
    }
  },
  created: function created() {},
  mounted: function mounted() {
    this.loadData();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=template&id=1d61adc0&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=template&id=1d61adc0& ***!
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
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        {
          directives: [
            {
              name: "role",
              rawName: "v-role",
              value: ["Slr", "Byr"],
              expression: "['Slr', 'Byr']"
            }
          ],
          staticClass: "col-12"
        },
        [
          _c(
            "ul",
            { staticClass: "buyer_button_list" },
            _vm._l(_vm.slr_order_list, function(order_item) {
              return _c(
                "li",
                { key: order_item.byr_buyer_id },
                [
                  _c(
                    "b-button",
                    {
                      attrs: { variant: "outline-primary" },
                      on: {
                        click: function($event) {
                          return _vm.buyer_route_change(order_item.byr_buyer_id)
                        }
                      }
                    },
                    [
                      _vm._v(
                        "\n          " +
                          _vm._s(order_item.buyer_name) +
                          "  " +
                          _vm._s(order_item.total_order) +
                          "件\n        "
                      )
                    ]
                  )
                ],
                1
              )
            }),
            0
          )
        ]
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/SLR/byr_slr_list_with_order.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/byr_slr_list_with_order.vue ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _byr_slr_list_with_order_vue_vue_type_template_id_1d61adc0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./byr_slr_list_with_order.vue?vue&type=template&id=1d61adc0& */ "./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=template&id=1d61adc0&");
/* harmony import */ var _byr_slr_list_with_order_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./byr_slr_list_with_order.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _byr_slr_list_with_order_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _byr_slr_list_with_order_vue_vue_type_template_id_1d61adc0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _byr_slr_list_with_order_vue_vue_type_template_id_1d61adc0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/SLR/byr_slr_list_with_order.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_slr_list_with_order_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./byr_slr_list_with_order.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_slr_list_with_order_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=template&id=1d61adc0&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=template&id=1d61adc0& ***!
  \********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_slr_list_with_order_vue_vue_type_template_id_1d61adc0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./byr_slr_list_with_order.vue?vue&type=template&id=1d61adc0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/byr_slr_list_with_order.vue?vue&type=template&id=1d61adc0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_slr_list_with_order_vue_vue_type_template_id_1d61adc0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_slr_list_with_order_vue_vue_type_template_id_1d61adc0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);