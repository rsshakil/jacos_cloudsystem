(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["assign_role_model"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      all_users: [],
      user: '',
      all_roles: {},
      selected_roles: [],
      user_id: '',
      submit_button: Globals.save //   })

    };
  },
  methods: {
    //Get user data
    loadUserData: function loadUserData() {
      var _this = this;

      axios.get(this.BASE_URL + "api/all_users_roles").then(function (_ref) {
        var data = _ref.data;
        _this.all_users = data.users;
        _this.all_roles = data.roles;
      })["catch"](function () {});
    },
    showRoles: function showRoles(option) {
      var _this2 = this;

      this.user_id = option.user_id;

      if (this.user_id) {
        axios.get(this.BASE_URL + "api/get_roles/" + this.user_id).then(function (_ref2) {
          var data = _ref2.data;
          var roles = data.model_data;
          var role_ids = [];

          for (var i = 0; i < roles.length; i++) {
            role_ids.push(roles[i]['role_id']);
            _this2.selected_roles = role_ids;
          }

          role_ids = [];
        })["catch"](function () {});
      }
    },
    //Assign role
    AssignRole: function AssignRole() {
      var _this3 = this;

      var assign_role_data = {
        roles: this.selected_roles,
        user_id: this.user_id
      };
      axios.post(this.BASE_URL + "api/assign_role_to_user", assign_role_data).then(function (_ref3) {
        var data = _ref3.data;

        if (data.message == 'success') {
          _this3.alert_text = _this3.myLang.assign_role_to_user;
        }

        _this3.alert_title = data.title;
        _this3.alert_icon = data.class_name;

        _this3.sweet_normal_alert();
      })["catch"](function () {
        _this3.sweet_advance_alert();
      });
    }
  },
  created: function created() {
    //LoadTableData
    this.loadUserData();
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=template&id=fde13496&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=template&id=fde13496& ***!
  \********************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "main-content-container container-fluid px-4" },
    [
      _c("div", { staticClass: "page-header row no-gutters py-4" }, [
        _c(
          "div",
          { staticClass: "col-12 col-sm-4 text-center text-sm-left mb-0" },
          [
            _c("h3", { staticClass: "page-title" }, [
              _vm._v(_vm._s(_vm.myLang.role_permission_menu))
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "can",
              rawName: "v-can",
              value: ["assign_role_to_user_view"],
              expression: "['assign_role_to_user_view']"
            }
          ],
          staticClass: "row"
        },
        [
          _c("div", { staticClass: "col-sm-12" }, [
            _c("div", { staticClass: "card card-small mb-4" }, [
              _c("div", { staticClass: "card-header border-bottom" }, [
                _c("h6", { staticClass: "m-0" }, [
                  _vm._v(_vm._s(_vm.myLang.assign_role))
                ])
              ]),
              _vm._v(" "),
              _c("ul", { staticClass: "list-group list-group-flush" }, [
                _c("li", { staticClass: "list-group-item p-3" }, [
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col" }, [
                      _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          {
                            staticClass: "col-sm-2 col-form-label",
                            attrs: { for: "inputEmail3" }
                          },
                          [_vm._v(_vm._s(_vm.myLang.user_name))]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-sm-4" },
                          [
                            _c(
                              "multiselect",
                              {
                                attrs: {
                                  options: _vm.all_users,
                                  searchable: true,
                                  "close-on-select": true,
                                  "show-labels": true,
                                  placeholder: _vm.myLang.select_user,
                                  label: "user_name",
                                  "track-by": "user_id"
                                },
                                on: {
                                  select: function($event) {
                                    return _vm.showRoles($event)
                                  }
                                },
                                model: {
                                  value: _vm.user,
                                  callback: function($$v) {
                                    _vm.user = $$v
                                  },
                                  expression: "user"
                                }
                              },
                              [
                                _c(
                                  "span",
                                  {
                                    attrs: { slot: "noOptions" },
                                    slot: "noOptions"
                                  },
                                  [_vm._v("候補がありません")]
                                ),
                                _vm._v(" "),
                                _c(
                                  "span",
                                  {
                                    attrs: { slot: "noResult" },
                                    slot: "noResult"
                                  },
                                  [_vm._v("候補がありません")]
                                )
                              ]
                            )
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          { staticClass: "col-sm-2 col-form-label" },
                          [_vm._v(_vm._s(_vm.myLang.select_role))]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-10" },
                          [
                            _vm.user_id != ""
                              ? _c(
                                  "b-form-group",
                                  [
                                    _c(
                                      "b-form-checkbox-group",
                                      {
                                        attrs: { id: "checkbox-group" },
                                        model: {
                                          value: _vm.selected_roles,
                                          callback: function($$v) {
                                            _vm.selected_roles = $$v
                                          },
                                          expression: "selected_roles"
                                        }
                                      },
                                      _vm._l(_vm.all_roles, function(
                                        role,
                                        index
                                      ) {
                                        return _c(
                                          "b-form-checkbox",
                                          {
                                            key: index,
                                            staticClass:
                                              "btn outline-secondary",
                                            staticStyle: {
                                              margin: "3px",
                                              "line-height": "5px",
                                              height: "25px"
                                            },
                                            attrs: { value: role.role_id }
                                          },
                                          [_vm._v(_vm._s(role.role_name))]
                                        )
                                      }),
                                      1
                                    )
                                  ],
                                  1
                                )
                              : _c("h6", [
                                  _vm._v(_vm._s(_vm.myLang.user_no_select))
                                ])
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "form-group row" }, [
                        _c("label", {
                          staticClass: "col-sm-2 col-form-label",
                          attrs: { for: "inputEmail3" }
                        }),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-sm-4" },
                          [
                            _vm.user_id != ""
                              ? _c(
                                  "b-button",
                                  {
                                    directives: [
                                      {
                                        name: "can",
                                        rawName: "v-can",
                                        value: ["assign_role_to_user_update"],
                                        expression:
                                          "['assign_role_to_user_update']"
                                      }
                                    ],
                                    attrs: { pill: "", variant: "primary" },
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.AssignRole()
                                      }
                                    }
                                  },
                                  [
                                    _c("b-icon", {
                                      attrs: {
                                        icon: "inbox-fill",
                                        "font-scale": "1.2"
                                      }
                                    }),
                                    _vm._v(" " + _vm._s(_vm.submit_button))
                                  ],
                                  1
                                )
                              : _vm._e()
                          ],
                          1
                        )
                      ])
                    ])
                  ])
                ])
              ])
            ])
          ])
        ]
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/ADM/assign_role_model.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/backend/ADM/assign_role_model.vue ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _assign_role_model_vue_vue_type_template_id_fde13496___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./assign_role_model.vue?vue&type=template&id=fde13496& */ "./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=template&id=fde13496&");
/* harmony import */ var _assign_role_model_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./assign_role_model.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _assign_role_model_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _assign_role_model_vue_vue_type_template_id_fde13496___WEBPACK_IMPORTED_MODULE_0__["render"],
  _assign_role_model_vue_vue_type_template_id_fde13496___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/ADM/assign_role_model.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_assign_role_model_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./assign_role_model.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_assign_role_model_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=template&id=fde13496&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=template&id=fde13496& ***!
  \**************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_assign_role_model_vue_vue_type_template_id_fde13496___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./assign_role_model.vue?vue&type=template&id=fde13496& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/assign_role_model.vue?vue&type=template&id=fde13496&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_assign_role_model_vue_vue_type_template_id_fde13496___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_assign_role_model_vue_vue_type_template_id_fde13496___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);