(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["permission"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/permission_component.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/ADM/permission_component.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      permissions: [],
      // BASE_URL:Globals.base_url,
      form: new Form({
        permission_name: "",
        permission_description: "",
        permission_update_id: "",
        submit_button: Globals.save
      })
    };
  },
  methods: {
    //get Table data
    loadPermissionData: function loadPermissionData() {
      var _this = this;

      axios.get(this.BASE_URL + "api/permission").then(function (_ref) {
        var data = _ref.data;
        _this.permissions = data.permissions;
      })["catch"](function () {});
    },
    //Insert Permission
    SubmitPermission: function SubmitPermission() {
      var _this2 = this;

      this.form.post(this.BASE_URL + "api/permission").then(function (_ref2) {
        var data = _ref2.data;

        if (data.message == 'created') {
          _this2.alert_text = _this2.myLang.permission_setup_completed;

          _this2.loadPermissionData();

          _this2.form.clear();

          _this2.form.reset();
        } else if (data.message == 'duplicated') {
          _this2.alert_text = _this2.myLang.permission_already_exists;
        } else if (data.message == 'updated') {
          _this2.alert_text = _this2.myLang.permission_updated;

          _this2.loadPermissionData();

          _this2.form.clear();

          _this2.form.reset();
        } else if (data.message == 'required') {
          _this2.alert_text = _this2.myLang.permission_name_blank;
        }

        _this2.alert_title = data.title;
        _this2.alert_icon = data.class_name;

        _this2.sweet_normal_alert();
      })["catch"](function () {
        _this2.sweet_advance_alert();
      });
    },
    editPermission: function editPermission(item) {
      this.form.clear();
      this.form.reset();
      this.form.permission_name = item.name;
      this.form.permission_description = item.permission_description;
      this.form.submit_button = Globals.update;
      this.form.permission_update_id = item.id;
      $("html, body").animate({
        scrollTop: 0
      }, "slow");
    },
    //Delete Permoission
    deletePermission: function deletePermission(id) {
      var _this3 = this;

      this.delete_sweet().then(function (result) {
        if (result.value) {
          //Send Request to server
          _this3.form["delete"](_this3.BASE_URL + 'api/permission/' + id).then(function (_ref3) {
            var data = _ref3.data;

            if (data.message == 'deleted') {
              _this3.alert_text = _this3.myLang.permission_deleted;
            } else if (data.message == 'faild') {
              _this3.alert_text = _this3.myLang.permission_not_deleted;
            }

            _this3.alert_icon = data.class_name;
            _this3.alert_title = data.title;

            _this3.sweet_normal_alert();

            _this3.loadPermissionData();
          })["catch"](function () {
            _this3.sweet_advance_alert();
          });
        }
      });
    } //Pagination
    // getResults(page = 1) {
    //   axios.get("api/role?page=" + page).then(response => {
    //     this.tabledata = response.data;
    //   });
    // }

  },
  created: function created() {
    //LoadTableData
    this.loadPermissionData();
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/permission_component.vue?vue&type=template&id=0275e850&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/ADM/permission_component.vue?vue&type=template&id=0275e850& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
              _vm._v(_vm._s(_vm.myLang.permission_management))
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row", attrs: { id: "div" } }, [
        _c(
          "div",
          {
            directives: [
              {
                name: "can",
                rawName: "v-can",
                value: ["permission_create"],
                expression: "['permission_create']"
              }
            ],
            staticClass: "col-lg-4"
          },
          [
            _c("div", { staticClass: "card card-small mb-4" }, [
              _c("div", { staticClass: "card-header border-bottom" }, [
                _c("h6", { staticClass: "m-0" }, [
                  _vm._v(_vm._s(_vm.myLang.manage_permission))
                ])
              ]),
              _vm._v(" "),
              _c("ul", { staticClass: "list-group list-group-flush" }, [
                _c("li", { staticClass: "list-group-item p-3" }, [
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col" }, [
                      _c(
                        "form",
                        {},
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.form.permission_update_id,
                                expression: "form.permission_update_id"
                              }
                            ],
                            attrs: { type: "hidden", value: "" },
                            domProps: { value: _vm.form.permission_update_id },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.form,
                                  "permission_update_id",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("div", { staticClass: "form-row" }, [
                            _c("div", { staticClass: "form-group col-md-12" }, [
                              _c(
                                "label",
                                { attrs: { for: "permission_name" } },
                                [_vm._v(_vm._s(_vm.myLang.permission_name))]
                              ),
                              _vm._v(" "),
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.form.permission_name,
                                    expression: "form.permission_name"
                                  }
                                ],
                                staticClass: "form-control",
                                attrs: {
                                  type: "text",
                                  name: "permission",
                                  id: "permission_name",
                                  placeholder: _vm.myLang.please_permission_name
                                },
                                domProps: { value: _vm.form.permission_name },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.form,
                                      "permission_name",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ])
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "form-row" }, [
                            _c("div", { staticClass: "form-group col-md-12" }, [
                              _c(
                                "label",
                                { attrs: { for: "permission_descr" } },
                                [_vm._v(_vm._s(_vm.myLang.permission_desc))]
                              ),
                              _vm._v(" "),
                              _c("textarea", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.form.permission_description,
                                    expression: "form.permission_description"
                                  }
                                ],
                                staticClass: "form-control",
                                attrs: {
                                  id: "permission_descr",
                                  name: "permission_descr",
                                  placeholder: _vm.myLang.permission_desc,
                                  rows: "5"
                                },
                                domProps: {
                                  value: _vm.form.permission_description
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.form,
                                      "permission_description",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ])
                          ]),
                          _vm._v(" "),
                          _c(
                            "b-button",
                            {
                              attrs: { pill: "", variant: "primary" },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.SubmitPermission()
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
                              _vm._v(" " + _vm._s(_vm.form.submit_button))
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ])
                  ])
                ])
              ])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            directives: [
              {
                name: "can",
                rawName: "v-can",
                value: ["permission_view"],
                expression: "['permission_view']"
              }
            ],
            staticClass: "col-sm-8"
          },
          [
            _c("div", { staticClass: "card card-small mb-4" }, [
              _c("div", { staticClass: "card-header border-bottom" }, [
                _c("h6", { staticClass: "m-0" }, [
                  _vm._v(_vm._s(_vm.myLang.permission_list))
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "card-body p-0 pb-3" }, [
                _c(
                  "table",
                  {
                    staticClass: "table mb-0",
                    attrs: { id: "permission_list_tbl" }
                  },
                  [
                    _c("thead", { staticClass: "bg-light" }, [
                      _c("tr", [
                        _c("th", { staticStyle: { width: "10%" } }, [
                          _vm._v("#")
                        ]),
                        _vm._v(" "),
                        _c("th", { staticStyle: { width: "35%" } }, [
                          _vm._v(_vm._s(_vm.myLang.permission_name))
                        ]),
                        _vm._v(" "),
                        _c("th", { staticStyle: { width: "35%" } }, [
                          _vm._v(_vm._s(_vm.myLang.permission_desc))
                        ]),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticStyle: { width: "20%" },
                            attrs: { colspan: "2" }
                          },
                          [_vm._v(_vm._s(_vm.myLang.permission_action))]
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      _vm._l(_vm.permissions, function(item, i) {
                        return _c("tr", { key: item.id }, [
                          _c("td", [_vm._v(_vm._s(i + 1))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(item.name))]),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(_vm._s(item.permission_description))
                          ]),
                          _vm._v(" "),
                          _c(
                            "td",
                            [
                              _c(
                                "b-button",
                                {
                                  directives: [
                                    {
                                      name: "can",
                                      rawName: "v-can",
                                      value: ["permission_update"],
                                      expression: "['permission_update']"
                                    }
                                  ],
                                  attrs: {
                                    variant: "info",
                                    disabled: _vm.is_disabled(item.is_system)
                                  },
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.editPermission(item)
                                    }
                                  }
                                },
                                [
                                  _c("b-icon", {
                                    attrs: {
                                      icon: "pencil-square",
                                      "font-scale": "1.2"
                                    }
                                  })
                                ],
                                1
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            [
                              _c(
                                "b-button",
                                {
                                  directives: [
                                    {
                                      name: "can",
                                      rawName: "v-can",
                                      value: ["permission_delete"],
                                      expression: "['permission_delete']"
                                    }
                                  ],
                                  attrs: {
                                    variant: "danger",
                                    disabled: _vm.is_disabled(item.is_system)
                                  },
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.deletePermission(item.id)
                                    }
                                  }
                                },
                                [
                                  _c("b-icon", {
                                    attrs: {
                                      icon: "trash-fill",
                                      "font-scale": "1.2"
                                    }
                                  })
                                ],
                                1
                              )
                            ],
                            1
                          )
                        ])
                      }),
                      0
                    )
                  ]
                )
              ])
            ])
          ]
        )
      ])
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

/***/ "./resources/js/components/backend/ADM/permission_component.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/backend/ADM/permission_component.vue ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _permission_component_vue_vue_type_template_id_0275e850___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./permission_component.vue?vue&type=template&id=0275e850& */ "./resources/js/components/backend/ADM/permission_component.vue?vue&type=template&id=0275e850&");
/* harmony import */ var _permission_component_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./permission_component.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/ADM/permission_component.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _permission_component_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _permission_component_vue_vue_type_template_id_0275e850___WEBPACK_IMPORTED_MODULE_0__["render"],
  _permission_component_vue_vue_type_template_id_0275e850___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/ADM/permission_component.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/ADM/permission_component.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/permission_component.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_permission_component_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./permission_component.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/permission_component.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_permission_component_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/ADM/permission_component.vue?vue&type=template&id=0275e850&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/permission_component.vue?vue&type=template&id=0275e850& ***!
  \*****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_permission_component_vue_vue_type_template_id_0275e850___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./permission_component.vue?vue&type=template&id=0275e850& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/permission_component.vue?vue&type=template&id=0275e850&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_permission_component_vue_vue_type_template_id_0275e850___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_permission_component_vue_vue_type_template_id_0275e850___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);