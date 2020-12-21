import Home from './components/backend/home_component.vue'
import default_home_page_with_blog from './components/backend/default_home_page_with_blog.vue'
import Role from './components/backend/ADM/role_component.vue'
import permission from './components/backend/ADM/permission_component.vue'
import assign_role_model from './components/backend/ADM/assign_role_model.vue'
import assign_permission_model from './components/backend/ADM/assign_permission_model.vue'
import users from './components/backend/ADM/users.vue'
import user_update from './components/backend/ADM/user_update.vue'
import password_reset from './components/backend/ADM/password_reset.vue'
import default_order_list from './components/backend/default_order_list.vue'
import default_parent from './components/backend/default_parent.vue'
import byr_order_detail from './components/backend/BYR/byr_order_detail.vue'
import order_details_canvas from './components/backend/order_details_canvas.vue'
import voucher_setting from './components/backend/canvas.vue'
import byr_management from './components/backend/SLR/byr_management.vue'
import byr_management_edit from './components/backend/SLR/byr_management_edit.vue'
import cmn_company_user_list from './components/backend/CMN/cmn_company_user_list.vue'
import cmn_company_partner_list from './components/backend/CMN/cmn_company_partner_list.vue'
import scenario_management from './components/backend/JACOS_MANAGEMENT/scenario_management.vue'
import job_management from './components/backend/JACOS_MANAGEMENT/job_management.vue'
import slr_management from './components/backend/SLR/slr_management.vue'
import slr_job_list from './components/backend/SLR/slr_job_list.vue'
// import company_seller_user_list from './components/backend/CMN/cmn_company_seller_user_list.vue'
import item_master from './components/backend/BYR/byr_item_master.vue'
import item_category from './components/backend/BYR/item_category.vue'
import order_receive from './components/backend/order_receive.vue'
import order_corrected_receive from './components/backend/order_corrected_receive.vue'
import return_item_list from './components/backend/return_item_list.vue'
import payment_list from './components/backend/payment_list.vue'
import invoice_list from './components/backend/invoice_list.vue'
import invoice_detail from './components/backend/invoice_detail.vue'
import voucher_detail from './components/backend/voucher_detail.vue'
import pdf_platform_setting from './components/backend/PDF_PLATFORM/pdf_platform_setting.vue'
import pdf_platform_view from './components/backend/PDF_PLATFORM/pdf_platform_view.vue'
import blog from './components/backend/CMN/cmn_blog_list.vue'
import selected_buyer from './components/backend/SLR/selected_byr_page.vue'
// import login_body from './components/login/login_body.vue'

export const routes = [

    {
        path: '/home',
        component: Home,
        meta: {
            breadcrumb: {
                label: 'Home',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: 'Home page'
            }
        },
    },
    { path: '/blog', component: blog },
    { path: '/role', component: Role },
    { path: '/permission', component: permission },
    { path: '/assign_role_to_user', component: assign_role_model },
    { path: '/assign_permission_to_user', component: assign_permission_model },
    { path: '/users', component: users },
    { path: '/users/:id/:auth_id', name: 'users', component: user_update },
    { path: '/password_reset/:id/:auth_id', name: 'password_reset', component: password_reset },
    {
        path: '/order_list',
        component: default_parent,
        meta: {
            breadcrumb: {
                label: '発注データ',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: '受注受信一覧'
            }
        },
        children: [{
                path: '/',
                component: default_order_list,
                name: 'order_list',
            },
            {
                path: '/order_list/order_list_detail',
                component: byr_order_detail,
                name: 'order_list_detail',
                meta: {
                    breadcrumb: 'Order detail'
                }
            },
            {
                path: '/order_list/order_details_canvas/:byr_order_id',
                component: order_details_canvas,
                name: 'order_details_canvas',
                meta: {
                    breadcrumb: 'canvas order'
                }
            }
        ]
    },
    { path: '/voucher_setting', name: 'voucher_setting', component: voucher_setting },
    {
        path: '/byr_management',
        component: default_parent,
        meta: {

            breadcrumb: {
                label: '小売管理',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: '小売管理'
            }

        },
        children: [{
                path: '/',
                component: byr_management,
                name: 'byr_management'
            },
            // {
            //     path: '/byr_management/byr_management_edit/:cmn_company_id',
            //     component: byr_management_edit,
            //     name: 'byr_management_edit',
            //     meta: {
            //         breadcrumb: '基本情報'
            //     }
            // },
            {
                path: '/byr_management/byr_company_user_list/:cmn_company_id',
                component: default_parent,
                // name: 'cmn_company_user_list',
                meta: {
                    breadcrumb: 'ユーザー管理'
                },
                children: [{
                    path: '',
                    component: cmn_company_user_list,
                    name: 'byr_company_user_list'
                }, ]

            },
            {
                path: '/byr_management/byr_company_partner_list/:cmn_company_id',
                component: default_parent,
                // name: 'cmn_company_partner_list',
                meta: {
                    breadcrumb: '取引先管理'
                },
                children: [{
                        path: '',
                        component: cmn_company_partner_list,
                        name: 'byr_company_partner_list'
                    },
                    {
                        path: '/byr_management/byr_company_partner_list/:byr_buyer_id/slr_job_list/:slr_seller_id',
                        component: slr_job_list,
                        name: 'slr_job_list',
                        meta: {
                            breadcrumb: 'job list'
                        }
                    },
                ]
            },
            {
                path: '/partner_list_manage',
                component: cmn_company_partner_list,
                name: 'partner_list_manage',
            },
            {
                path: '/user_list_manage',
                component: cmn_company_user_list,
                name: 'user_list_manage',
            },
        ]

    },
    {
        path: '/scenario_management',
        component: default_parent,
        meta: {
            breadcrumb: {
                label: 'シナリオ管理',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: 'シナリオ管理'
            }
        },
        children: [{
            path: '/',
            component: scenario_management,
            name: 'scenario_management'
        }, ]

    },
    {
        path: '/job_management',
        component: default_parent,
        meta: {
            breadcrumb: {
                label: '仕事の管理',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: '仕事の管理'
            }
        },
        children: [{
            path: '/',
            component: job_management,
            name: 'job_management'
        }, ]

    },
    {
        path: '/slr_management',
        component: default_parent,
        meta: {
            breadcrumb: {
                label: '問屋管理',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: '問屋管理'
            }
        },
        children: [{
                path: '/',
                component: slr_management,
                name: 'slr_management'
            },
            {
                path: '/slr_management/slr_company_user_list/:cmn_company_id',
                component: default_parent,
                meta: {
                    breadcrumb: 'seller user list'
                },
                children: [{
                    path: '/',
                    component: cmn_company_user_list,
                    name: 'slr_company_user_list'
                }, ]
            },
            {
                path: '/slr_management/slr_company_partner_list/:cmn_company_id',
                component: default_parent,
                meta: {
                    breadcrumb: 'seller partner list'
                },
                children: [{
                    path: '/',
                    component: cmn_company_partner_list,
                    name: 'slr_company_partner_list'
                }, ]
            },
        ]

    },
    {
        path: '/item_master',
        component: default_parent,
        meta: {
            breadcrumb: {
                label: '商品メンテ',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: '商品メンテ'
            }
        },
        children: [{
            path: '/',
            component: item_master,
            name: 'item_master'
        }, {
            path: '/item_category',
            component: item_category,
            name: 'item_category',
            meta: {
                breadcrumb: '分類'
            }
        }, ]

    },

    {
        path: '/order_receive',
        component: default_parent,
        meta: {
            breadcrumb: {
                label: '受領データ',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: '受領データ'
            }
        },
        children: [{
            path: '/',
            component: order_receive,
            name: 'order_receive'
        }, ]

    },
    {
        path: '/order_corrected_receive',
        component: default_parent,
        meta: {
            breadcrumb: {
                label: '受領訂正データ',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: '受領訂正データ'
            }
        },
        children: [{
            path: '/',
            component: order_corrected_receive,
            name: 'order_corrected_receive'
        }, ]

    },
    {
        path: '/return_item_list',
        component: default_parent,
        meta: {
            breadcrumb: {
                label: '返品データ',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: '返品データ'
            }
        },
        children: [{
            path: '/',
            component: return_item_list,
            name: 'return_item_list'
        }, ]

    },
    {
        path: '/payment_list',
        component: default_parent,
        meta: {
            breadcrumb: {
                label: '支払データ',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: '支払データ'
            }
        },
        children: [{
            path: '/',
            component: payment_list,
            name: 'payment_list'
        }, ]

    },
    {
        path: '/invoice_list',
        component: default_parent,
        meta: {
            breadcrumb: {
                label: '請求',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: '請求'
            }
        },
        children: [{
            path: '/',
            component: invoice_list,
            name: 'invoice_list'
        }, {
            path: '/invoice_list/invoice_detail/:byr_invoice_id',
            component: invoice_detail,
            name: 'invoice_detail',
            meta: { breadcrumb: '伝票一覧・新規請求' }
        }, {
            path: '/invoice_list/voucher_detail/:voucher_number',
            component: voucher_detail,
            name: 'voucher_detail',
            meta: { breadcrumb: '伝票一覧・新規請求' }
        }]

    },
    {
        path: '/pdf_platform_setting',
        component: pdf_platform_setting,
        meta: {
            breadcrumb: {
                label: 'pdfプラットフォーム設定',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: 'pdfプラットフォーム設定'
            }
        },
        children: []

    },
    {
        path: '/pdf_platform_view',
        component: pdf_platform_view,
        meta: {
            breadcrumb: {
                label: 'pdfプラットフォーム',
                parent: 'Params'
            },
            breadcrumb_title: {
                label: 'pdfプラットフォーム'
            }
        },
        children: []

    },
    {
        path: '/home/selected_buyer',
        component: selected_buyer,
        name: 'selected_buyer',
        props: true,

        // meta: { breadcrumb: 'Selected Buyer' },
        // children: [{
        //         path: '/',
        //         component: selected_buyer,
        //         name: 'selected_buyer'
        //     },
        // {
        //     path: '/slr_management/company_seller_user_list/:cmn_company_id',
        //     component: company_seller_user_list,
        //     name: 'company_seller_user_list',
        //     meta: {
        //         breadcrumb: 'seller user list'
        //     }
        // },
        // ]

    },
    // { path: '/login', name: 'login', component: login_body },
];