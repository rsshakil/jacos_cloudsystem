(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["slr_management"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/slr_management.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/SLR/slr_management.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      slr_lists: {},
      add_cmn_company_modal: false,
      form: new Form({
        cmn_company_id: "",
        company_name: "",
        jcode: "",
        postal_code: "",
        address: "",
        phone: "",
        fax: ""
      })
    };
  },
  methods: {
    add_new_company_cmn: function add_new_company_cmn() {
      this.form.reset();
      this.form.errors.clear();
      this.add_cmn_company_modal = true;
    },
    edit_slr_data: function edit_slr_data(form_data) {
      this.add_cmn_company_modal = true;
      this.form.reset();
      this.form.errors.clear();
      this.form.fill(form_data);
    },
    delete_slr_data: function delete_slr_data(form_data) {
      var _this = this;

      // console.log(form_data)
      // return 0;
      this.delete_sweet().then(function (result) {
        if (result.value) {
          axios.post(_this.BASE_URL + "api/seller_delete", form_data).then(function (_ref) {
            var data = _ref.data;
            console.log(data);
            _this.alert_text = data.message;
            _this.alert_title = data.title;
            _this.alert_icon = data.class_name;

            _this.get_all_slr();

            _this.sweet_normal_alert();
          });
        }
      });
    },
    save_new_slr: function save_new_slr() {
      var _this2 = this;

      this.form.post(this.BASE_URL + "api/slr_company_create").then(function (data) {
        _this2.add_cmn_company_modal = false;
        Fire.$emit("AfterCreatesellerCompany");

        if (_this2.form.cmn_company_id != "") {
          var tittles = "Company Update success";
          var msg_text = "You have successfully updated company";
        } else {
          var tittles = "Company added success";
          var msg_text = "You have successfully added company";
        }

        Swal.fire({
          icon: "success",
          title: tittles,
          text: msg_text
        });
      })["catch"](function (error) {
        Swal.fire({
          icon: "warning",
          title: "Invalid company info",
          text: "check company info!"
        });
      });
    },
    get_all_slr: function get_all_slr() {
      var _this3 = this;

      axios.get(this.BASE_URL + "api/slr_management/" + Globals.user_info_id).then(function (_ref2) {
        var data = _ref2.data;
        _this3.slr_lists = data.slr_list;
      });
    }
  },
  created: function created() {
    var _this4 = this;

    this.get_all_slr();
    Fire.$on("AfterCreatesellerCompany", function () {
      _this4.get_all_slr();
    });
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/slr_management.vue?vue&type=template&id=6a16b0b6&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/SLR/slr_management.vue?vue&type=template&id=6a16b0b6& ***!
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
          value: ["slr_view"],
          expression: "['slr_view']"
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
                  _vm._s(_vm.myLang.saler_management_head) +
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
                                on: { click: _vm.add_new_company_cmn }
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
                      _vm._v(_vm._s(_vm.myLang.wholesaler_name))
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.wholesaler_code))
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
                    ]),
                    _vm._v(" "),
                    _c("th", { staticStyle: { cursor: "pointer" } }, [
                      _vm._v(_vm._s(_vm.myLang.delete))
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.slr_lists, function(slr_list, index) {
                    return _c("tr", { key: slr_list.slr_seller_id }, [
                      _c("td", [_vm._v(_vm._s(index + 1))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(slr_list.company_name))]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(slr_list.jcode))]),
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
                                  name: "slr_company_user_list",
                                  query: {
                                    cmn_company_id: slr_list.cmn_company_id
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
                                  name: "slr_company_partner_list",
                                  query: {
                                    cmn_company_id: slr_list.cmn_company_id
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
                                return _vm.edit_slr_data(slr_list)
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
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-danger",
                            on: {
                              click: function($event) {
                                return _vm.delete_slr_data(slr_list)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                  " +
                                _vm._s(_vm.myLang.delete) +
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
            title: _vm.myLang.wholesaler_modal_title,
            "ok-title": _vm.myLang.add,
            "cancel-title": _vm.myLang.cancel
          },
          on: {
            ok: function($event) {
              $event.preventDefault()
              return _vm.save_new_slr()
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
          _c(
            "div",
            {
              directives: [
                {
                  name: "can",
                  rawName: "v-can",
                  value: ["company_create"],
                  expression: "['company_create']"
                }
              ],
              staticClass: "panel-body add_item_body"
            },
            [
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
                      attrs: { for: "wholesaler_name" }
                    },
                    [_vm._v(_vm._s(_vm.myLang.wholesaler_name))]
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
                        attrs: { type: "text", id: "wholesaler_name" },
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
                      attrs: { for: "wholesaler_code" }
                    },
                    [_vm._v(_vm._s(_vm.myLang.wholesaler_code))]
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
                        attrs: { type: "text", id: "wholesaler_code" },
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
                      attrs: { for: "postal_code" }
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
                        attrs: { type: "text", id: "postal_code" },
                        domProps: { value: _vm.form.postal_code },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.form,
                              "postal_code",
                              $event.target.value
                            )
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
                      attrs: { for: "street" }
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
                        attrs: { type: "text", id: "street" },
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
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    {
                      staticClass: "col-sm-4 col-form-label",
                      attrs: { for: "phone_number" }
                    },
                    [_vm._v(_vm._s(_vm.myLang.phone_number))]
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
                            value: _vm.form.phone,
                            expression: "form.phone"
                          }
                        ],
                        staticClass: "form-control",
                        class: { "is-invalid": _vm.form.errors.has("phone") },
                        attrs: { type: "text", id: "phone_number" },
                        domProps: { value: _vm.form.phone },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(_vm.form, "phone", $event.target.value)
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("has-error", {
                        attrs: { form: _vm.form, field: "phone" }
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
                      attrs: { for: "fax" }
                    },
                    [_vm._v(_vm._s(_vm.myLang.fax))]
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
                            value: _vm.form.fax,
                            expression: "form.fax"
                          }
                        ],
                        staticClass: "form-control",
                        class: { "is-invalid": _vm.form.errors.has("fax") },
                        attrs: { type: "text", id: "fax" },
                        domProps: { value: _vm.form.fax },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(_vm.form, "fax", $event.target.value)
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("has-error", {
                        attrs: { form: _vm.form, field: "fax" }
                      })
                    ],
                    1
                  )
                ])
              ])
            ]
          )
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/backend/SLR/slr_management.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/backend/SLR/slr_management.vue ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _slr_management_vue_vue_type_template_id_6a16b0b6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./slr_management.vue?vue&type=template&id=6a16b0b6& */ "./resources/js/components/backend/SLR/slr_management.vue?vue&type=template&id=6a16b0b6&");
/* harmony import */ var _slr_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./slr_management.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/SLR/slr_management.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _slr_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _slr_management_vue_vue_type_template_id_6a16b0b6___WEBPACK_IMPORTED_MODULE_0__["render"],
  _slr_management_vue_vue_type_template_id_6a16b0b6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/SLR/slr_management.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/SLR/slr_management.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/slr_management.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./slr_management.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/slr_management.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_management_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/SLR/slr_management.vue?vue&type=template&id=6a16b0b6&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/backend/SLR/slr_management.vue?vue&type=template&id=6a16b0b6& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_management_vue_vue_type_template_id_6a16b0b6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./slr_management.vue?vue&type=template&id=6a16b0b6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/SLR/slr_management.vue?vue&type=template&id=6a16b0b6&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_management_vue_vue_type_template_id_6a16b0b6___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_slr_management_vue_vue_type_template_id_6a16b0b6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);