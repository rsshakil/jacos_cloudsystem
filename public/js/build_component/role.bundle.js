(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["role"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/role_component.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/ADM/role_component.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      role_permissions: {},
      role_permissions_id: {},
      all_permissions: [],
      user_data: null,
      form: new Form({
        role_name: "",
        permissions: [],
        role_description: "",
        role_update_id: "",
        submit_button: Globals.save
      })
    };
  },
  methods: {
    //get Table data
    loadTableData: function loadTableData() {
      var _this = this;

      axios.get(this.BASE_URL + "api/role").then(function (_ref) {
        var data = _ref.data;
        _this.role_permissions = data.role_permissions;
        _this.all_permissions = data.role_permissions[0].all_permissions;
      })["catch"](function () {});
    },
    //Insert role
    SubmitRole: function SubmitRole() {
      var _this2 = this;

      this.form.post(this.BASE_URL + "api/role").then(function (_ref2) {
        var data = _ref2.data;

        // console.log(data);
        if (data.alert_text == 'required') {
          _this2.alert_text = _this2.myLang.role_name_required;
        } else if (data.alert_text == 'updated') {
          _this2.alert_text = _this2.myLang.role_updated;

          _this2.loadTableData();

          _this2.form.clear();

          _this2.form.reset();
        } else if (data.alert_text == 'duplicated') {
          _this2.alert_text = _this2.myLang.role_duplicated;
        } else if (data.alert_text == 'created') {
          _this2.alert_text = _this2.myLang.role_setup_completed;

          _this2.loadTableData();

          _this2.form.clear();

          _this2.form.reset();
        }

        _this2.alert_title = data.title;
        _this2.alert_icon = data.class_name;

        _this2.sweet_normal_alert();
      })["catch"](function () {
        _this2.sweet_advance_alert();
      });
    },
    editRole: function editRole(item) {
      this.form.clear();
      this.form.reset();
      this.form.role_name = item.role_name;
      this.form.role_description = item.role_description;
      this.form.permissions = item.permissions;
      this.form.submit_button = Globals.update;
      this.form.role_update_id = item.role_id; //  window.scrollTo(0,0);

      $("html, body").animate({
        scrollTop: 0
      }, "slow");
    },
    //Delete role
    deleteRole: function deleteRole(id) {
      var _this3 = this;

      this.delete_sweet().then(function (result) {
        if (result.value) {
          //Send Request to server
          _this3.form["delete"](_this3.BASE_URL + 'api/role/' + id).then(function (_ref3) {
            var data = _ref3.data;

            if (data.alert_text == 'success') {
              _this3.alert_text = _this3.myLang.role_deleted;
            } else if (data.alert_text == 'faild') {
              _this3.alert_text = _this3.myLang.role_not_deleted;
            }

            _this3.alert_icon = data.class_name;
            _this3.alert_title = data.title;

            _this3.sweet_normal_alert();

            _this3.loadTableData();
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
    this.loadTableData();
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/role_component.vue?vue&type=template&id=8f998f02&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/ADM/role_component.vue?vue&type=template&id=8f998f02& ***!
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
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "main-content-container container-fluid px-4" }, [
      _c("div", { staticClass: "page-header row no-gutters py-4" }, [
        _c(
          "div",
          { staticClass: "col-12 col-sm-4 text-center text-sm-left mb-0" },
          [
            _c("h3", { staticClass: "page-title" }, [
              _vm._v(_vm._s(_vm.myLang.role_management))
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          {
            directives: [
              {
                name: "can",
                rawName: "v-can",
                value: ["role_create"],
                expression: "['role_create']"
              }
            ],
            staticClass: "col-md-4"
          },
          [
            _c("div", { staticClass: "card card-small mb-4" }, [
              _c("div", { staticClass: "card-header border-bottom" }, [
                _c("h6", { staticClass: "m-0" }, [
                  _vm._v(_vm._s(_vm.myLang.manage_role))
                ])
              ]),
              _vm._v(" "),
              _c("ul", { staticClass: "list-group list-group-flush" }, [
                _c("li", { staticClass: "list-group-item p-3" }, [
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col" }, [
                      _c(
                        "form",
                        { staticClass: "form-horizontal" },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.form.role_update_id,
                                expression: "form.role_update_id"
                              }
                            ],
                            attrs: { type: "hidden", value: "" },
                            domProps: { value: _vm.form.role_update_id },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.form,
                                  "role_update_id",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("div", { staticClass: "form-row" }, [
                            _c(
                              "div",
                              { staticClass: "form-group col-md-12" },
                              [
                                _c("label", { attrs: { for: "role_name" } }, [
                                  _vm._v(_vm._s(_vm.myLang.role_name))
                                ]),
                                _vm._v(" "),
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.form.role_name,
                                      expression: "form.role_name"
                                    }
                                  ],
                                  staticClass: "form-control",
                                  class: {
                                    "is-invalid": _vm.form.errors.has(
                                      "role_name"
                                    )
                                  },
                                  attrs: {
                                    type: "text",
                                    id: "role_name",
                                    placeholder: _vm.myLang.please_role_name
                                  },
                                  domProps: { value: _vm.form.role_name },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.form,
                                        "role_name",
                                        $event.target.value
                                      )
                                    }
                                  }
                                }),
                                _vm._v(" "),
                                _c("has-error", {
                                  attrs: { form: _vm.form, field: "role_name" }
                                })
                              ],
                              1
                            )
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "form-row" }, [
                            _c(
                              "div",
                              { staticClass: "form-group col-md-12" },
                              [
                                _c(
                                  "label",
                                  {
                                    staticClass: "typo__label",
                                    attrs: { for: "permissions" }
                                  },
                                  [_vm._v(_vm._s(_vm.myLang.permission_name))]
                                ),
                                _vm._v(" "),
                                _c("multiselect", {
                                  attrs: {
                                    id: "permissions",
                                    placeholder: _vm.myLang.permission_name,
                                    label: "name",
                                    "track-by": "id",
                                    options: _vm.all_permissions,
                                    multiple: true,
                                    "close-on-select": false,
                                    "clear-on-select": false,
                                    "preserve-search": true,
                                    "open-direction": "bottom"
                                  },
                                  model: {
                                    value: _vm.form.permissions,
                                    callback: function($$v) {
                                      _vm.$set(_vm.form, "permissions", $$v)
                                    },
                                    expression: "form.permissions"
                                  }
                                }),
                                _vm._v(" "),
                                _c("has-error", {
                                  attrs: {
                                    form: _vm.form,
                                    field: "permissions"
                                  }
                                })
                              ],
                              1
                            )
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "form-row" }, [
                            _c(
                              "div",
                              { staticClass: "form-group col-md-12" },
                              [
                                _c(
                                  "label",
                                  { attrs: { for: "role_description" } },
                                  [_vm._v(_vm._s(_vm.myLang.desc))]
                                ),
                                _vm._v(" "),
                                _c("textarea", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.form.role_description,
                                      expression: "form.role_description"
                                    }
                                  ],
                                  staticClass: "form-control",
                                  attrs: {
                                    placeholder: _vm.myLang.role_desc,
                                    rows: "5"
                                  },
                                  domProps: {
                                    value: _vm.form.role_description
                                  },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.form,
                                        "role_description",
                                        $event.target.value
                                      )
                                    }
                                  }
                                }),
                                _vm._v(" "),
                                _c("has-error", {
                                  attrs: {
                                    form: _vm.form,
                                    field: "role_description"
                                  }
                                })
                              ],
                              1
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "b-button",
                            {
                              attrs: {
                                pill: "",
                                variant: "primary",
                                type: "submit"
                              },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.SubmitRole($event)
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
                                " " +
                                  _vm._s(_vm.form.submit_button) +
                                  "\r\n                    "
                              )
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
                value: ["role_view"],
                expression: "['role_view']"
              }
            ],
            staticClass: "col-md-8"
          },
          [
            _c("div", { staticClass: "col", attrs: { id: "role_list_tbl" } }, [
              _c("div", { staticClass: "card card-small mb-8" }, [
                _c("div", { staticClass: "card-header border-bottom" }, [
                  _c("h6", { staticClass: "m-0" }, [
                    _vm._v(_vm._s(_vm.myLang.role_list))
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "card-body p-0 pb-3" }, [
                  _c(
                    "table",
                    { staticClass: "table mb-0", attrs: { id: "role_list" } },
                    [
                      _c("thead", { staticClass: "bg-light" }, [
                        _c("tr", [
                          _c("th", [_vm._v("Sl")]),
                          _vm._v(" "),
                          _c("th", [_vm._v(_vm._s(_vm.myLang.role_name))]),
                          _vm._v(" "),
                          _c("th", [
                            _vm._v(_vm._s(_vm.myLang.role_permission))
                          ]),
                          _vm._v(" "),
                          _c("th", [_vm._v(_vm._s(_vm.myLang.role_action))])
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        _vm._l(_vm.role_permissions, function(item, i) {
                          return _c("tr", { key: item.role_id }, [
                            _c("td", { staticStyle: { width: "5%" } }, [
                              _vm._v(_vm._s(i + 1))
                            ]),
                            _vm._v(" "),
                            _c("td", { staticStyle: { width: "15%" } }, [
                              _vm._v(_vm._s(item.role_name))
                            ]),
                            _vm._v(" "),
                            _c("td", {
                              domProps: {
                                innerHTML: _vm._s(item.role_permissions)
                              }
                            }),
                            _vm._v(" "),
                            _c(
                              "td",
                              { staticStyle: { width: "20%" } },
                              [
                                _c(
                                  "b-button",
                                  {
                                    directives: [
                                      {
                                        name: "can",
                                        rawName: "v-can",
                                        value: ["role_update"],
                                        expression: "['role_update']"
                                      }
                                    ],
                                    attrs: { variant: "info" },
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.editRole(item)
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
                                ),
                                _vm._v(" "),
                                _c(
                                  "b-button",
                                  {
                                    directives: [
                                      {
                                        name: "can",
                                        rawName: "v-can",
                                        value: ["role_delete"],
                                        expression: "['role_delete']"
                                      }
                                    ],
                                    attrs: {
                                      variant: "danger",
                                      disabled: _vm.is_disabled(item.is_system)
                                    },
                                    on: {
                                      click: function($event) {
                                        return _vm.deleteRole(item.role_id)
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

/***/ "./resources/js/components/backend/ADM/role_component.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/backend/ADM/role_component.vue ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _role_component_vue_vue_type_template_id_8f998f02___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./role_component.vue?vue&type=template&id=8f998f02& */ "./resources/js/components/backend/ADM/role_component.vue?vue&type=template&id=8f998f02&");
/* harmony import */ var _role_component_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./role_component.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/ADM/role_component.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _role_component_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _role_component_vue_vue_type_template_id_8f998f02___WEBPACK_IMPORTED_MODULE_0__["render"],
  _role_component_vue_vue_type_template_id_8f998f02___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/ADM/role_component.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/ADM/role_component.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/role_component.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_role_component_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./role_component.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/role_component.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_role_component_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/ADM/role_component.vue?vue&type=template&id=8f998f02&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/role_component.vue?vue&type=template&id=8f998f02& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_role_component_vue_vue_type_template_id_8f998f02___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./role_component.vue?vue&type=template&id=8f998f02& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/role_component.vue?vue&type=template&id=8f998f02&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_role_component_vue_vue_type_template_id_8f998f02___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_role_component_vue_vue_type_template_id_8f998f02___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);