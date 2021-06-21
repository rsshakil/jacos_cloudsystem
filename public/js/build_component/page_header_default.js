(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["page_header_default"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/page_header_default.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/page_header_default.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      page_heading: '<i class="fas fa-wrench custom_wrench"></i> 得意先一覧',
      page_slug_url: ''
    };
  },
  methods: {},
  created: function created() {
    var _this = this;

    this.page_slug_url = this.$route.name;

    if (this.$route.name == 'home') {
      this.page_heading = '得意先一覧';
    } else if (this.$route.name == 'order_list') {
      this.page_heading = '受注受信一覧';
    } else if (this.$route.name == 'receive_list') {
      this.page_heading = '受領受信一覧';
    } else if (this.$route.name == 'payment_list') {
      this.page_heading = '支払受信一覧';
    } else if (this.$route.name == 'payment_detail') {
      this.page_heading = '支払合計';
    } else if (this.$route.name == 'invoice_list') {
      this.page_heading = '請求一覧';
    } else if (this.$route.name == 'invoice_detail') {
      this.page_heading = '請求伝票一覧';
    } else if (this.$route.name == 'item_search') {
      this.page_heading = '受注商品別一覧';
    } else if (this.$route.name == 'item_search_detail') {
      this.page_heading = '受注商品別明細';
    } else if (this.$route.name == 'blog') {
      this.page_heading = 'お知らせ管理';
    }

    Fire.$on("loadPageTitle", function (PageTitle) {
      _this.page_heading = PageTitle;
    });
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/page_header_default.vue?vue&type=template&id=75889549&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/page_header_default.vue?vue&type=template&id=75889549& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticStyle: { clear: "both" } }, [
    _vm.page_slug_url != "selected_buyer"
      ? _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass:
                "col-12 text-center page_c_title_bar text-sm-left mb-0"
            },
            [
              _c("h4", { staticClass: "page_custom_title" }, [
                _c("span", {
                  domProps: { innerHTML: _vm._s(_vm.page_heading) }
                })
              ])
            ]
          )
        ])
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/page_header_default.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/backend/page_header_default.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _page_header_default_vue_vue_type_template_id_75889549___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./page_header_default.vue?vue&type=template&id=75889549& */ "./resources/js/components/backend/page_header_default.vue?vue&type=template&id=75889549&");
/* harmony import */ var _page_header_default_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./page_header_default.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/page_header_default.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _page_header_default_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _page_header_default_vue_vue_type_template_id_75889549___WEBPACK_IMPORTED_MODULE_0__["render"],
  _page_header_default_vue_vue_type_template_id_75889549___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/page_header_default.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/page_header_default.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/backend/page_header_default.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_page_header_default_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./page_header_default.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/page_header_default.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_page_header_default_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/page_header_default.vue?vue&type=template&id=75889549&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/backend/page_header_default.vue?vue&type=template&id=75889549& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_page_header_default_vue_vue_type_template_id_75889549___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./page_header_default.vue?vue&type=template&id=75889549& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/page_header_default.vue?vue&type=template&id=75889549&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_page_header_default_vue_vue_type_template_id_75889549___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_page_header_default_vue_vue_type_template_id_75889549___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);