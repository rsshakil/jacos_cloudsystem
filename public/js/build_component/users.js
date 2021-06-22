(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["users"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/users.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/ADM/users.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      // global_user_id:Globals.user_info_id,
      name: '',
      email: '',
      password: '',
      confirm_password: '',
      users: {},
      roles: {},
      permissions: {},
      selected_roles: [],
      selected_permissions: [],
      permissions_for_user: '',
      total_permissions_by_user: 0,
      permission_modal_title: '',
      permissionModalShow: false,
      userModalShow: false,
      password_modal_title: '',
      user_update_id: '' // BASE_URL:Globals.base_url,

    };
  },
  methods: {
    //get Table data
    loadUserData: function loadUserData() {
      var _this = this;

      axios.get(this.BASE_URL + "api/users").then(function (_ref) {
        var data = _ref.data;
        _this.users = data.users;
        _this.roles = data.roles;
        _this.permissions = data.permissions;
      })["catch"](function () {});
    },
    permissionForRole: function permissionForRole(options) {
      var _this2 = this;

      var role_id = [];
      options.forEach(function (element) {
        role_id.push(element.role_id);
      });
      var permission_data = {
        role_id: role_id
      };
      axios.post(this.BASE_URL + "api/get_permission_for_roles", permission_data).then(function (_ref2) {
        var data = _ref2.data;
        // made array unic
        _this2.selected_permissions = Array.from(new Set(data.permission_for_role)); // Or
        // this.selected_permissions = (data.permission_for_role).filter((v, i, a) => a.indexOf(v) === i);
      })["catch"](function () {});
    },
    // User create
    save_user: function save_user() {
      var _this3 = this;

      var role_id = [];

      if (this.name == '' || this.email == '' || this.password == '' || this.confirm_password == '') {
        this.alert_text = "All fields are required";
        this.alert_title = "Required!", this.alert_icon = "warning";
        this.sweet_normal_alert();
        return false;
      }

      if (this.password != this.confirm_password) {
        this.alert_text = "Password not matched";
        this.alert_title = "Required!", this.alert_icon = "error";
        this.sweet_normal_alert();
        return false;
      }

      this.selected_roles.forEach(function (element) {
        role_id.push(element.role_id);
      });
      var user_data = {
        name: this.name,
        email: this.email,
        password: this.password,
        roles: role_id,
        permissions: this.selected_permissions
      };
      axios.post(this.BASE_URL + "api/users", user_data).then(function (_ref3) {
        var data = _ref3.data;

        //   this.sweet_normal_alert();
        if (data.message == 'exists') {
          _this3.alert_text = _this3.myLang.email_already_database;
        } else if (data.message == 'created') {
          _this3.alert_text = _this3.myLang.user_created;

          _this3.loadUserData();

          _this3.fieldsEmpty();

          _this3.userModalShow = false;
        } else if (data.message == 'name_required') {
          _this3.alert_text = _this3.myLang.name_length;
        } else if (data.message == 'email_required') {
          _this3.alert_text = _this3.myLang.email_length;
        } else if (data.message == 'password_required') {
          _this3.alert_text = _this3.myLang.password_length;
        }

        _this3.alert_title = data.title;
        _this3.alert_icon = data.class_name;

        _this3.sweet_normal_alert();
      })["catch"](function () {
        _this3.sweet_advance_alert();
      });
    },
    fieldsEmpty: function fieldsEmpty() {
      this.selected_roles = [];
      this.selected_permissions = [];
      this.name = '';
      this.email = '';
      this.password = '';
      this.confirm_password = '';
    },
    //Delete User
    deleteUser: function deleteUser(id) {
      var _this4 = this;

      this.delete_sweet().then(function (result) {
        if (result.value) {
          //Send Request to server
          axios["delete"](_this4.BASE_URL + 'api/users/' + id).then(function (_ref4) {
            var data = _ref4.data;

            if (data.message = 'deleted') {
              _this4.alert_text = _this4.myLang.user_deleted;
            }

            _this4.alert_title = data.title;
            _this4.alert_icon = data.class_name;

            _this4.sweet_normal_alert();

            _this4.loadUserData();
          })["catch"](function () {
            _this4.sweet_advance_alert();
          });
        }
      });
    },
    permissionView: function permissionView(user_id, user_name) {
      var _this5 = this;

      this.permissionModalShow = true;
      this.permission_modal_title = "Permissions for " + user_name;
      var user_data = {
        user_id: user_id
      };
      axios.post(this.BASE_URL + "api/permissions_by_users", user_data).then(function (_ref5) {
        var data = _ref5.data;
        _this5.total_permissions_by_user = 0;
        _this5.permissions_for_user = '';
        _this5.total_permissions_by_user = data.total_permissions;
        _this5.permissions_for_user = data.permissions_for_user;
      })["catch"](function () {
        _this5.sweet_advance_alert();
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/users.vue?vue&type=template&id=6282dbcd&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/backend/ADM/users.vue?vue&type=template&id=6282dbcd& ***!
  \********************************************************************************************************************************************************************************************************************/
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
              _vm._v(_vm._s(_vm.myLang.manage_users))
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
              value: ["users_view"],
              expression: "['users_view']"
            }
          ],
          staticClass: "row"
        },
        [
          _c("div", { staticClass: "col" }, [
            _c("div", { staticClass: "card card-small mb-4" }, [
              _c("div", { staticClass: "card-header border-bottom" }, [
                _c("h6", { staticClass: "m-0" }, [
                  _vm._v(_vm._s(_vm.myLang.manage_users))
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "card-body p-0 pb-3 text-center" }, [
                _c(
                  "table",
                  { staticClass: "table mb-0", attrs: { id: "user_list_tbl" } },
                  [
                    _c("thead", { staticClass: "bg-light" }, [
                      _c("tr", [
                        _c("th", [_vm._v("#")]),
                        _vm._v(" "),
                        _c("th", [_vm._v(_vm._s(_vm.myLang.name))]),
                        _vm._v(" "),
                        _c("th", [_vm._v(_vm._s(_vm.myLang.email))]),
                        _vm._v(" "),
                        _c(
                          "th",
                          [
                            _c(
                              "b-button",
                              {
                                directives: [
                                  {
                                    name: "b-modal",
                                    rawName: "v-b-modal.modal-lg",
                                    modifiers: { "modal-lg": true }
                                  },
                                  {
                                    name: "can",
                                    rawName: "v-can",
                                    value: ["user_create"],
                                    expression: "['user_create']"
                                  }
                                ],
                                attrs: { variant: "primary" },
                                on: {
                                  click: function($event) {
                                    return _vm.fieldsEmpty()
                                  }
                                }
                              },
                              [
                                _c("b-icon", {
                                  attrs: {
                                    icon: "person-plus-fill",
                                    "font-scale": "1.2"
                                  }
                                }),
                                _vm._v(" "),
                                _c("span", { staticClass: "hide-menu" }, [
                                  _vm._v(" " + _vm._s(_vm.myLang.create_new))
                                ])
                              ],
                              1
                            )
                          ],
                          1
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      _vm._l(_vm.users, function(user, i) {
                        return _c("tr", { key: i }, [
                          _c("td", [_vm._v(_vm._s(i + 1))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(user.name))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(user.email))]),
                          _vm._v(" "),
                          _c(
                            "td",
                            [
                              _c(
                                "router-link",
                                {
                                  directives: [
                                    {
                                      name: "can",
                                      rawName: "v-can",
                                      value: ["user_profile_view"],
                                      expression: "['user_profile_view']"
                                    }
                                  ],
                                  staticClass: "btn btn-info",
                                  attrs: {
                                    to: {
                                      name: "user_update",
                                      params: {
                                        id: user.id,
                                        auth_id: _vm.global_user_id
                                      }
                                    }
                                  }
                                },
                                [
                                  _c("b-icon", {
                                    attrs: {
                                      icon: "eye-fill",
                                      "font-scale": "1.2"
                                    }
                                  }),
                                  _vm._v(" " + _vm._s(_vm.myLang.view))
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "router-link",
                                {
                                  directives: [
                                    {
                                      name: "can",
                                      rawName: "v-can",
                                      value: ["change_password"],
                                      expression: "['change_password']"
                                    }
                                  ],
                                  staticClass: "btn btn-warning",
                                  attrs: {
                                    to: {
                                      name: "password_reset",
                                      params: {
                                        id: user.id,
                                        auth_id: _vm.global_user_id
                                      }
                                    }
                                  }
                                },
                                [
                                  _c("b-icon", {
                                    attrs: {
                                      icon: "pencil-square",
                                      "font-scale": "1.2"
                                    }
                                  }),
                                  _vm._v(
                                    " " + _vm._s(_vm.myLang.change_password)
                                  )
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
                                      value: ["user_permission_view"],
                                      expression: "['user_permission_view']"
                                    }
                                  ],
                                  attrs: { variant: "info" },
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.permissionView(
                                        user.id,
                                        user.name
                                      )
                                    }
                                  }
                                },
                                [
                                  _c("b-icon", {
                                    attrs: {
                                      icon: "view-list",
                                      "font-scale": "1.2"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c("span", { staticClass: "hide-menu" }, [
                                    _vm._v(
                                      " " +
                                        _vm._s(_vm.myLang.permission_view) +
                                        " "
                                    )
                                  ])
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "button",
                                {
                                  directives: [
                                    {
                                      name: "can",
                                      rawName: "v-can",
                                      value: ["user_delete"],
                                      expression: "['user_delete']"
                                    }
                                  ],
                                  staticClass: "btn btn-danger",
                                  attrs: { type: "button" },
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.deleteUser(user.id)
                                    }
                                  }
                                },
                                [
                                  _c("b-icon", {
                                    attrs: {
                                      icon: "trash-fill",
                                      "font-scale": "1.2"
                                    }
                                  }),
                                  _vm._v(" " + _vm._s(_vm.myLang.delete))
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
      ),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            size: "lg",
            "hide-backdrop": true,
            title: _vm.permission_modal_title
          },
          model: {
            value: _vm.permissionModalShow,
            callback: function($$v) {
              _vm.permissionModalShow = $$v
            },
            expression: "permissionModalShow"
          }
        },
        [
          _c("div", [
            _c("h4", [
              _vm._v(
                "Total Permissions: " + _vm._s(_vm.total_permissions_by_user)
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", {
            domProps: { innerHTML: _vm._s(_vm.permissions_for_user) }
          })
        ]
      ),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            id: "modal-lg",
            size: "lg",
            "hide-backdrop": true,
            title: "Create User",
            "ok-title": "Save"
          },
          on: {
            ok: function($event) {
              $event.preventDefault()
              return _vm.save_user()
            }
          },
          model: {
            value: _vm.userModalShow,
            callback: function($$v) {
              _vm.userModalShow = $$v
            },
            expression: "userModalShow"
          }
        },
        [
          _c("form", { attrs: { method: "POST", id: "user_create" } }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-6" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "col-md-12 col-form-label",
                      attrs: { for: "name" }
                    },
                    [_vm._v("Name")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-12" },
                    [
                      _c("b-form-input", {
                        attrs: { type: "text", placeholder: "Name" },
                        model: {
                          value: _vm.name,
                          callback: function($$v) {
                            _vm.name = $$v
                          },
                          expression: "name"
                        }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "col-md-12 col-form-label",
                      attrs: { for: "email" }
                    },
                    [_vm._v("Email")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-12" },
                    [
                      _c("b-form-input", {
                        attrs: { type: "email", placeholder: "Email" },
                        model: {
                          value: _vm.email,
                          callback: function($$v) {
                            _vm.email = $$v
                          },
                          expression: "email"
                        }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "col-md-12 col-form-label",
                      attrs: { for: "password" }
                    },
                    [_vm._v("Password")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-12" },
                    [
                      _c("b-form-input", {
                        attrs: { type: "password", placeholder: "Password" },
                        model: {
                          value: _vm.password,
                          callback: function($$v) {
                            _vm.password = $$v
                          },
                          expression: "password"
                        }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "col-md-12 col-form-label",
                      attrs: { for: "password-confirm" }
                    },
                    [_vm._v("Confirm password")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-12" },
                    [
                      _c("b-form-input", {
                        attrs: {
                          type: "password",
                          placeholder: "Confirm password"
                        },
                        model: {
                          value: _vm.confirm_password,
                          callback: function($$v) {
                            _vm.confirm_password = $$v
                          },
                          expression: "confirm_password"
                        }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-6 ml-auto" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass: "col-md-12 col-form-label",
                      attrs: { for: "roles" }
                    },
                    [_vm._v("Select roles")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-12" },
                    [
                      _c(
                        "multiselect",
                        {
                          attrs: {
                            id: "roles",
                            placeholder: "Search or add roles",
                            label: "role_name",
                            "track-by": "role_id",
                            options: _vm.roles,
                            multiple: true,
                            "close-on-select": true,
                            "clear-on-select": false,
                            "preserve-search": true,
                            "open-direction": "bottom"
                          },
                          on: {
                            input: function($event) {
                              return _vm.permissionForRole($event)
                            }
                          },
                          model: {
                            value: _vm.selected_roles,
                            callback: function($$v) {
                              _vm.selected_roles = $$v
                            },
                            expression: "selected_roles"
                          }
                        },
                        [
                          _c(
                            "span",
                            { attrs: { slot: "noOptions" }, slot: "noOptions" },
                            [_vm._v("候補がありません")]
                          ),
                          _vm._v(" "),
                          _c(
                            "span",
                            { attrs: { slot: "noResult" }, slot: "noResult" },
                            [_vm._v("候補がありません")]
                          )
                        ]
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "form-group" },
                  [
                    _c(
                      "label",
                      {
                        staticClass: "col-md-12 col-form-label",
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
                              value: _vm.selected_permissions,
                              callback: function($$v) {
                                _vm.selected_permissions = $$v
                              },
                              expression: "selected_permissions"
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

/***/ "./resources/js/components/backend/ADM/users.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/backend/ADM/users.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _users_vue_vue_type_template_id_6282dbcd___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./users.vue?vue&type=template&id=6282dbcd& */ "./resources/js/components/backend/ADM/users.vue?vue&type=template&id=6282dbcd&");
/* harmony import */ var _users_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./users.vue?vue&type=script&lang=js& */ "./resources/js/components/backend/ADM/users.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _users_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _users_vue_vue_type_template_id_6282dbcd___WEBPACK_IMPORTED_MODULE_0__["render"],
  _users_vue_vue_type_template_id_6282dbcd___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/backend/ADM/users.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/backend/ADM/users.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/users.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_users_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./users.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/users.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_users_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/backend/ADM/users.vue?vue&type=template&id=6282dbcd&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/backend/ADM/users.vue?vue&type=template&id=6282dbcd& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_users_vue_vue_type_template_id_6282dbcd___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./users.vue?vue&type=template&id=6282dbcd& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/backend/ADM/users.vue?vue&type=template&id=6282dbcd&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_users_vue_vue_type_template_id_6282dbcd___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_users_vue_vue_type_template_id_6282dbcd___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);