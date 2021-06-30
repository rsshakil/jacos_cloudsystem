(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["assign_permission_model"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      permissions_by_role: [],
      selected_permissions: [],
      not_matches: [],
      user_id: '',
      submit_button: Globals.save //   })

    };
  },
  methods: {
    //Get user data
    loadUserData: function loadUserData() {
      var _this = this;

      axios.get(this.BASE_URL + "api/all_users_permissions").then(function (_ref) {
        var data = _ref.data;
        _this.all_users = data.users;
      })["catch"](function () {});
    },
    showPermissions: function showPermissions(option) {
      var _this2 = this;

      this.user_id = option.user_id;

      if (this.user_id) {
        axios.get(this.BASE_URL + "api/get_permission_model/" + this.user_id).then(function (_ref2) {
          var data = _ref2.data;
          _this2.not_matches = data.not_matches;
          _this2.selected_permissions = data.permissions_exist_id;
          _this2.permissions_by_role = data.all_permissions_for_user_array;
        })["catch"](function () {});
      }
    },
    //Assign role
    AssignPermissions: function AssignPermissions() {
      var _this3 = this;

      var assign_permission_data = {
        permission: this.selected_permissions,
        user_id: this.user_id
      };
      axios.post(this.BASE_URL + "api/assign_permission_to_user", assign_permission_data).then(function (_ref3) {
        var data = _ref3.data;
        _this3.permissions_by_role = data.all_permissions_for_user_array;

        if (data.message == 'success') {
          _this3.alert_text = _this3.myLang.permission_assigned;
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=template&id=2b8dc3e4&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=template&id=2b8dc3e4& ***!
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
              _vm._v(_vm._s(_vm.myLang.assign_permission_to_user))
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
              value: ["assign_permission_to_user_view"],
              expression: "['assign_permission_to_user_view']"
            }
          ],
          staticClass: "row"
        },
        [
          _c("div", { staticClass: "col-sm-12" }, [
            _c("div", { staticClass: "card card-small mb-4" }, [
              _c("div", { staticClass: "card-header border-bottom" }, [
                _c("h6", { staticClass: "m-0" }, [
                  _vm._v(_vm._s(_vm.myLang.assign_permission_to_user))
                ])
              ]),
              _vm._v(" "),
              _c("ul", { staticClass: "list-group list-group-flush" }, [
                _c("li", { staticClass: "list-group-item p-3" }, [
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col" }, [
                      _c("form", { attrs: { method: "post" } }, [
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
                                    "show-labels": false,
                                    placeholder: _vm.myLang.select_user,
                                    label: "user_name",
                                    "track-by": "user_id"
                                  },
                                  on: {
                                    select: function($event) {
                                      return _vm.showPermissions($event)
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
                        _vm.user_id != ""
                          ? _c("div", { staticClass: "row" }, [
                              _c("div", { staticClass: "col-md-2 col-lg-2" }),
                              _vm._v(" "),
                              _c("div", { staticClass: "col-md-4 col-lg-4" }, [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "select-permission-wrapper my-4"
                                  },
                                  [
                                    _c("h3", [
                                      _vm._v(
                                        _vm._s(_vm.myLang.select_permission)
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _vm.not_matches.length == 0
                                      ? _c("div", [
                                          _vm._v(
                                            "\n\t\t\t\t\t\t\t\t\t\t\t\t\t" +
                                              _vm._s(
                                                _vm.myLang.role_no_select
                                              ) +
                                              "\n\t\t\t\t\t\t\t\t\t\t\t\t"
                                          )
                                        ])
                                      : _c(
                                          "div",
                                          {
                                            staticStyle: {
                                              "margin-left": "-40px"
                                            }
                                          },
                                          [
                                            _vm.user_id != ""
                                              ? _c(
                                                  "b-form-group",
                                                  [
                                                    _c(
                                                      "b-form-checkbox-group",
                                                      {
                                                        attrs: {
                                                          id: "checkbox-group"
                                                        },
                                                        model: {
                                                          value:
                                                            _vm.selected_permissions,
                                                          callback: function(
                                                            $$v
                                                          ) {
                                                            _vm.selected_permissions = $$v
                                                          },
                                                          expression:
                                                            "selected_permissions"
                                                        }
                                                      },
                                                      [
                                                        _c(
                                                          "ul",
                                                          {
                                                            staticStyle: {
                                                              "list-style":
                                                                "none"
                                                            }
                                                          },
                                                          _vm._l(
                                                            _vm.not_matches,
                                                            function(
                                                              not_matche,
                                                              index
                                                            ) {
                                                              return _c(
                                                                "li",
                                                                { key: index },
                                                                [
                                                                  _c(
                                                                    "b-form-checkbox",
                                                                    {
                                                                      attrs: {
                                                                        value:
                                                                          not_matche.id,
                                                                        switch:
                                                                          ""
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "p",
                                                                        {
                                                                          staticClass:
                                                                            "btn btn-info",
                                                                          staticStyle: {
                                                                            padding:
                                                                              "5px",
                                                                            margin:
                                                                              "3px"
                                                                          }
                                                                        },
                                                                        [
                                                                          _vm._v(
                                                                            _vm._s(
                                                                              not_matche.name
                                                                            )
                                                                          )
                                                                        ]
                                                                      )
                                                                    ]
                                                                  )
                                                                ],
                                                                1
                                                              )
                                                            }
                                                          ),
                                                          0
                                                        )
                                                      ]
                                                    )
                                                  ],
                                                  1
                                                )
                                              : _vm._e()
                                          ],
                                          1
                                        ),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      [
                                        _c(
                                          "b-button",
                                          {
                                            directives: [
                                              {
                                                name: "can",
                                                rawName: "v-can",
                                                value: [
                                                  "assign_permission_to_user_update"
                                                ],
                                                expression:
                                                  "['assign_permission_to_user_update']"
                                              }
                                            ],
                                            attrs: {
                                              pill: "",
                                              variant: "primary"
                                            },
                                            on: {
                                              click: function($event) {
                                                $event.preventDefault()
                                                return _vm.AssignPermissions(
                                                  $event
                                                )
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
                                            _vm._v(
                                              " " + _vm._s(_vm.submit_button)
                                            )
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    )
                                  ]
                                )
                              ]),
                              _vm._v(" "),
                              _c("div", { staticClass: "col-md-5 col-lg-5" }, [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "select-permission-wrapper my-4"
                                  },
                                  [
                                    _c("h3", [
                                      _vm._v(
                                        _vm._s(_vm.myLang.previous_permission)
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _vm.permissions_by_role.length != 0
                                      ? _c("div", [
                                          _c(
                                            "ol",
                                            _vm._l(
                                              _vm.permissions_by_role,
                                              function(permission, i) {
                                                return _c(
                                                  "li",
                                                  {
                                                    key: i,
                                                    staticStyle: {
                                                      "margin-top": "3px"
                                                    }
                                                  },
                                                  [
                                                    _c(
                                                      "p",
                                                      {
                                                        staticClass:
                                                          "btn btn-info",
                                                        staticStyle: {
                                                          padding: "5px",
                                                          margin: "0px"
                                                        }
                                                      },
                                                      [
                                                        _vm._v(
                                                          _vm._s(permission)
                                                        )
                                                      ]
                                                    )
                                                  ]
                                                )
                                              }
                                            ),
                                            0
                                          )
                                        ])
                                      : _c("div", [
                                          _vm._v(
                                            "\n                         " +
                                              _vm._s(
                                                _vm.myLang.role_no_select
                                              ) +
                                              "\n                        "
                                          )
                                        ])
                                  ]
                                )
                              ])
                            ])
                          : _vm._e()
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

/***/ "./resources/js/components/backend/ADM/assign_permission_model.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/assign_permission_model.vue ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _assign_permission_model_vue_vue_type_template_id_2b8dc3e4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./assign_permission_model.vue?vue&type=template&id=2b8dc3e4& */ "./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=template&id=2b8dc3e4&");
/* harmony import */ var _assign_permission_model_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./assign_permission_model.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _assign_permission_model_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _assign_permission_model_vue_vue_type_template_id_2b8dc3e4___WEBPACK_IMPORTED_MODULE_0__["render"],
  _assign_permission_model_vue_vue_type_template_id_2b8dc3e4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/ADM/assign_permission_model.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_assign_permission_model_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./assign_permission_model.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_assign_permission_model_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=template&id=2b8dc3e4&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=template&id=2b8dc3e4& ***!
  \********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_assign_permission_model_vue_vue_type_template_id_2b8dc3e4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./assign_permission_model.vue?vue&type=template&id=2b8dc3e4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/assign_permission_model.vue?vue&type=template&id=2b8dc3e4&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_assign_permission_model_vue_vue_type_template_id_2b8dc3e4___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_assign_permission_model_vue_vue_type_template_id_2b8dc3e4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);