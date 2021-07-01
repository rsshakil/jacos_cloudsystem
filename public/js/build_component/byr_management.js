(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["byr_management"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/byr_management.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/SLR/byr_management.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      company_lists: {},
      add_cmn_company_modal: false,
      user_create_title: '',
      create_update_button: '',
      editmode: false,
      permissions: [],
      form: new Form({
        cmn_company_id: null,
        // buyer_name: "",
        // buyer_email: "",
        // buyer_password: "",
        company_name: "",
        jcode: "",
        super_code: "",
        postal_code: "",
        address: "",
        selected_permissions: []
      })
    };
  },
  methods: {
    add_new_buyer: function add_new_buyer() {
      var _this = this;

      this.user_create_title = this.myLang.add_new_buyer_title, this.create_update_button = this.myLang.add_new, this.add_cmn_company_modal = true;
      this.editmode = false;
      this.form.reset();
      axios.post(this.BASE_URL + "api/get_permissions_for_buyer", {
        cmn_company_id: null
      }).then(function (_ref) {
        var data = _ref.data;
        _this.permissions = data.permission_array; // console.log(data)
      });
    },
    edit_byr_data: function edit_byr_data(form_data) {
      var _this2 = this;

      // console.log(form_data);
      var cmn_company_id = form_data.cmn_company_id;
      axios.post(this.BASE_URL + "api/get_permissions_for_buyer", {
        cmn_company_id: cmn_company_id
      }).then(function (_ref2) {
        var data = _ref2.data;
        _this2.permissions = data.permission_array;
        var sp_array = [];
        data.selected_permission_array.forEach(function (element) {
          sp_array.push(element.id);
        });
        _this2.form.selected_permissions = sp_array;
      });
      this.user_create_title = "Update Buyer", this.create_update_button = this.myLang.update, this.add_cmn_company_modal = true;
      this.editmode = true;
      this.form.reset();
      this.form.fill(form_data);
    },
    save_new_buyer: function save_new_buyer() {
      var _this3 = this;

      this.form.post(this.BASE_URL + "api/create_buyer").then(function (_ref3) {
        var data = _ref3.data;
        Fire.$emit("AfterCreateCompany");

        if (_this3.form.cmn_company_id != "") {
          _this3.add_cmn_company_modal = false;
          _this3.alert_text = "You have successfully updated buyer";
        } else {
          _this3.add_cmn_company_modal = false;
          _this3.alert_text = "You have successfully added buyer";
        }

        _this3.alert_title = data.title;
        _this3.alert_icon = data.class_name;

        _this3.sweet_normal_alert(); // console.log(data);

      })["catch"](function (error) {
        // console.log(error);
        _this3.alert_title = "Invalid company info";
        _this3.alert_icon = "warning";
        _this3.alert_text = "check company info!";

        _this3.sweet_advance_alert();
      });
    },
    get_all_company: function get_all_company() {
      var _this4 = this;

      axios.get(this.BASE_URL + "api/get_all_company_list/" + Globals.user_info_id).then(function (_ref4) {
        var data = _ref4.data;
        _this4.company_lists = data.companies; // console.log(this.company_lists);
      });
    }
  },
  created: function created() {
    var _this5 = this;

    this.get_all_company();
    Fire.$on("AfterCreateCompany", function () {
      _this5.get_all_company();
    });
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/byr_management.vue?vue&type=template&id=54362cba&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/SLR/byr_management.vue?vue&type=template&id=54362cba& ***!
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
  return _c(
    "div",
    {
      directives: [
        {
          name: "can",
          rawName: "v-can",
          value: ["byr_management"],
          expression: "['byr_management']"
        }
      ]
    },
    [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-12" }, [
          _c(
            "h4",
            {
              staticClass: "top_title text-center",
              staticStyle: { "margin-top": "10px" }
            },
            [
              _vm._v(
                "\n        " +
                  _vm._s(_vm.myLang.buyer_management_head) +
                  "\n      "
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-12" }, [
          _c("div", {}, [
            _c(
              "table",
              { staticClass: "table table-striped table-bordered data_table" },
              [
                _c("thead", [
                  _c("tr", [
                    _c(
                      "th",
                      {
                        staticStyle: { border: "none" },
                        attrs: { colspan: "100%" }
                      },
                      [
                        _c("div", { staticClass: "row" }, [
                          _c("div", { staticClass: "col-6" }, [
                            _c("form", { staticClass: "form-inline" }, [
                              _c("input", {
                                staticClass: "form-control",
                                attrs: {
                                  type: "text",
                                  placeholder: _vm.myLang.search,
                                  "aria-label": "Search"
                                }
                              }),
                              _vm._v(" "),
                              _c("button", { staticClass: "btn btn-primary" }, [
                                _vm._v(
                                  "\n                        " +
                                    _vm._s(_vm.myLang.search) +
                                    "\n                      "
                                )
                              ])
                            ])
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-6" }, [
                            _c(
                              "button",
                              {
                                staticClass: "btn custom_right btn-primary",
                                on: { click: _vm.add_new_buyer }
                              },
                              [
                                _vm._v(
                                  "\n                      " +
                                    _vm._s(_vm.myLang.add_new) +
                                    "\n                    "
                                )
                              ]
                            )
                          ])
                        ])
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("tr", [
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v("No")
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.company_name))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.super_code))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.status))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.user_management))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.shop_management))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.partner_management))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.ordering_data))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.details))
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.company_lists, function(company_list, index) {
                    return _c("tr", { key: company_list.cmn_company_id }, [
                      _c("td", [_vm._v(_vm._s(index + 1))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(company_list.company_name))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(company_list.super_code))]),
                      _vm._v(" "),
                      _c("td", [
                        _vm._v(_vm._s(_vm.myLang.status_in_operation))
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c(
                            "router-link",
                            {
                              staticClass: "btn btn-primary",
                              attrs: {
                                to: {
                                  name: "byr_company_user_list",
                                  query: {
                                    cmn_company_id: company_list.cmn_company_id
                                  }
                                }
                              }
                            },
                            [_vm._v(_vm._s(_vm.myLang.user_management))]
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", [
                        _c("button", { staticClass: "btn btn-info" }, [
                          _vm._v(
                            "\n                  " +
                              _vm._s(_vm.myLang.shop_management) +
                              "\n                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c(
                            "router-link",
                            {
                              staticClass: "btn btn-danger",
                              attrs: {
                                to: {
                                  name: "adm_partner_list_manage", //byr_company_partner_list
                                  query: {
                                    cmn_company_id: company_list.cmn_company_id
                                  }
                                }
                              }
                            },
                            [_vm._v(_vm._s(_vm.myLang.partner_management))]
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("td", [
                        _c("button", { staticClass: "btn btn-success" }, [
                          _vm._v(
                            "\n                  " +
                              _vm._s(_vm.myLang.ordering_data) +
                              "\n                "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-primary",
                            on: {
                              click: function($event) {
                                return _vm.edit_byr_data(company_list)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                  " +
                                _vm._s(_vm.myLang.details) +
                                "\n                "
                            )
                          ]
                        )
                      ])
                    ])
                  }),
                  0
                )
              ]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            size: "md",
            "hide-backdrop": true,
            title: _vm.user_create_title,
            "ok-title": _vm.create_update_button,
            "cancel-title": _vm.myLang.cancel,
            "no-enforce-focus": true
          },
          on: {
            ok: function($event) {
              $event.preventDefault()
              return _vm.save_new_buyer()
            }
          },
          model: {
            value: _vm.add_cmn_company_modal,
            callback: function($$v) {
              _vm.add_cmn_company_modal = $$v
            },
            expression: "add_cmn_company_modal"
          }
        },
        [
          _c("div", { staticClass: "panel-body add_item_body" }, [
            _c("form", [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.form.cmn_company_id,
                    expression: "form.cmn_company_id"
                  }
                ],
                attrs: { type: "hidden" },
                domProps: { value: _vm.form.cmn_company_id },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.form, "cmn_company_id", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-sm-4 col-form-label",
                    attrs: { for: "staticEmail" }
                  },
                  [_vm._v(_vm._s(_vm.myLang.company_name))]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-sm-8" },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.form.company_name,
                          expression: "form.company_name"
                        }
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.has("company_name")
                      },
                      attrs: { type: "text" },
                      domProps: { value: _vm.form.company_name },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.form,
                            "company_name",
                            $event.target.value
                          )
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("has-error", {
                      attrs: { form: _vm.form, field: "company_name" }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-sm-4 col-form-label",
                    attrs: { for: "inputPassword" }
                  },
                  [_vm._v(_vm._s(_vm.myLang.jan_code))]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-sm-8" },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.form.jcode,
                          expression: "form.jcode"
                        }
                      ],
                      staticClass: "form-control",
                      class: { "is-invalid": _vm.form.errors.has("jcode") },
                      attrs: { type: "text" },
                      domProps: { value: _vm.form.jcode },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.form, "jcode", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("has-error", {
                      attrs: { form: _vm.form, field: "jcode" }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-sm-4 col-form-label",
                    attrs: { for: "inputPassword" }
                  },
                  [_vm._v(_vm._s(_vm.myLang.super_code))]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-sm-8" },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.form.super_code,
                          expression: "form.super_code"
                        }
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.has("super_code")
                      },
                      attrs: { type: "text" },
                      domProps: { value: _vm.form.super_code },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.form, "super_code", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("has-error", {
                      attrs: { form: _vm.form, field: "super_code" }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-sm-4 col-form-label",
                    attrs: { for: "inputPassword" }
                  },
                  [_vm._v(_vm._s(_vm.myLang.postal_code))]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-sm-8" },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.form.postal_code,
                          expression: "form.postal_code"
                        }
                      ],
                      staticClass: "form-control",
                      class: {
                        "is-invalid": _vm.form.errors.has("postal_code")
                      },
                      attrs: { type: "text" },
                      domProps: { value: _vm.form.postal_code },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.form, "postal_code", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("has-error", {
                      attrs: { form: _vm.form, field: "postal_code" }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-sm-4 col-form-label",
                    attrs: { for: "inputPassword" }
                  },
                  [_vm._v(_vm._s(_vm.myLang.street))]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-sm-8" },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.form.address,
                          expression: "form.address"
                        }
                      ],
                      staticClass: "form-control",
                      class: { "is-invalid": _vm.form.errors.has("address") },
                      attrs: { type: "text" },
                      domProps: { value: _vm.form.address },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.form, "address", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("has-error", {
                      attrs: { form: _vm.form, field: "address" }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "row form-group" },
                [
                  _c(
                    "label",
                    {
                      staticClass: "col-md-4 col-form-label",
                      attrs: { for: "permission_for_user" }
                    },
                    [_vm._v("Select permissions")]
                  ),
                  _vm._v(" "),
                  _c(
                    "b-form-group",
                    [
                      _c(
                        "b-form-checkbox-group",
                        {
                          attrs: { id: "checkbox-group" },
                          model: {
                            value: _vm.form.selected_permissions,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "selected_permissions", $$v)
                            },
                            expression: "form.selected_permissions"
                          }
                        },
                        _vm._l(_vm.permissions, function(permission, index) {
                          return _c(
                            "b-form-checkbox",
                            {
                              key: index,
                              attrs: {
                                value: permission.permission_id,
                                switch: ""
                              }
                            },
                            [_vm._v(_vm._s(permission.permission_name))]
                          )
                        }),
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ])
          ])
        ]
      )
    ],
    1
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

/***/ "./resources/js/components/backend/SLR/byr_management.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/backend/SLR/byr_management.vue ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _byr_management_vue_vue_type_template_id_54362cba___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./byr_management.vue?vue&type=template&id=54362cba& */ "./resources/js/components/backend/SLR/byr_management.vue?vue&type=template&id=54362cba&");
/* harmony import */ var _byr_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./byr_management.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/SLR/byr_management.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _byr_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _byr_management_vue_vue_type_template_id_54362cba___WEBPACK_IMPORTED_MODULE_0__["render"],
  _byr_management_vue_vue_type_template_id_54362cba___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/SLR/byr_management.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/SLR/byr_management.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/byr_management.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./byr_management.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/byr_management.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/SLR/byr_management.vue?vue&type=template&id=54362cba&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/byr_management.vue?vue&type=template&id=54362cba& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_management_vue_vue_type_template_id_54362cba___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./byr_management.vue?vue&type=template&id=54362cba& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/byr_management.vue?vue&type=template&id=54362cba&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_management_vue_vue_type_template_id_54362cba___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_byr_management_vue_vue_type_template_id_54362cba___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);