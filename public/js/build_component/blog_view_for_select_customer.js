(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["blog_view_for_select_customer"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      home_text: Globals.welcome_text,
      BASE_URL: Globals.base_url,
      activeVal: "home",
      blog_lists: {},
      single_blog: {},
      user_blog: {},
      byr_buyer_id: null
    };
  },
  methods: {
    get_all_blogs: function get_all_blogs() {
      var _this = this;

      axios.get(this.BASE_URL + "api/get_all_published_blog_list").then(function (_ref) {
        var data = _ref.data;
        _this.blog_lists = data.blog_list;
      });
    },
    get_signle_top_blog: function get_signle_top_blog() {
      var _this2 = this;

      axios.get(this.BASE_URL + "api/get_signle_top_blog").then(function (_ref2) {
        var data = _ref2.data;
        _this2.single_blog = data.blog_list;
      });
    },
    get_user_top_blog: function get_user_top_blog() {
      var _this3 = this;

      var byr_buyer_id = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;

      if (byr_buyer_id == null) {
        byr_buyer_id = this.$session.get('byr_buyer_id');
      } // console.log(this.$session.get('byr_buyer_id'));


      if (byr_buyer_id) {
        axios.get(this.BASE_URL + "api/get_user_top_blog_by_byr_id/" + byr_buyer_id).then(function (_ref3) {
          var data = _ref3.data;
          _this3.user_blog = data.blog_list;
        })["catch"](function (error) {
          _this3.user_blog = []; // console.log(error)
        });
      } else {
        this.user_blog = [];
      }
    }
  },
  created: function created() {
    var _this4 = this;

    this.get_all_blogs();
    this.get_signle_top_blog();
    this.get_user_top_blog();
    Fire.$on("AfterCreateblog", function () {
      _this4.get_all_blogs();
    });
    Fire.$on("selectedByuerBlog", function (byr_buyer_id) {
      _this4.get_signle_top_blog();

      _this4.get_user_top_blog(byr_buyer_id);
    }); // this.byr_buyer_id=this.$route.params.byr_buyer_id;
  },
  mounted: function mounted() {},
  route: {
    canReuse: false
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=template&id=21f1437c&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=template&id=21f1437c& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
      _c(
        "b-row",
        {
          directives: [
            {
              name: "can",
              rawName: "v-can",
              value: ["slr_view"],
              expression: "['slr_view']"
            }
          ]
        },
        [
          _vm.user_blog.length != "0"
            ? _c("b-col", [
                _c("h4", { staticClass: "my-3 blog_titles" }, [
                  _c("i", {
                    staticClass: "fas custom_blog_square fa-square-full"
                  }),
                  _vm._v("\n                得意先連絡事項\n              ")
                ]),
                _vm._v(" "),
                _c("div", {
                  staticClass: "blogs_content",
                  domProps: { innerHTML: _vm._s(_vm.user_blog.blog_content) }
                })
              ])
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "b-row",
        [
          _vm.single_blog.length != "0"
            ? _c("b-col", [
                _c("h4", { staticClass: "my-3 blog_titles" }, [
                  _c("i", {
                    staticClass: "fas custom_blog_square fa-square-full"
                  }),
                  _vm._v("\n                ジャコス連絡事項\n              ")
                ]),
                _vm._v(" "),
                _c("div", {
                  staticClass: "blogs_content",
                  domProps: { innerHTML: _vm._s(_vm.single_blog.blog_content) }
                })
              ])
            : _vm._e()
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/SLR/blog_view_for_select_customer.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/blog_view_for_select_customer.vue ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _blog_view_for_select_customer_vue_vue_type_template_id_21f1437c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./blog_view_for_select_customer.vue?vue&type=template&id=21f1437c& */ "./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=template&id=21f1437c&");
/* harmony import */ var _blog_view_for_select_customer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./blog_view_for_select_customer.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _blog_view_for_select_customer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _blog_view_for_select_customer_vue_vue_type_template_id_21f1437c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _blog_view_for_select_customer_vue_vue_type_template_id_21f1437c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/SLR/blog_view_for_select_customer.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_blog_view_for_select_customer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./blog_view_for_select_customer.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_blog_view_for_select_customer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=template&id=21f1437c&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=template&id=21f1437c& ***!
  \**************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_blog_view_for_select_customer_vue_vue_type_template_id_21f1437c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./blog_view_for_select_customer.vue?vue&type=template&id=21f1437c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/blog_view_for_select_customer.vue?vue&type=template&id=21f1437c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_blog_view_for_select_customer_vue_vue_type_template_id_21f1437c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_blog_view_for_select_customer_vue_vue_type_template_id_21f1437c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);