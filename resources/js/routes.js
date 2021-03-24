import Home from './components/backend/home_component.vue'
import default_home_page_with_blog from './components/backend/default_home_page_with_blog.vue'
// admin
import Role from './components/backend/ADM/role_component.vue'
import permission from './components/backend/ADM/permission_component.vue'
import assign_role_model from './components/backend/ADM/assign_role_model.vue'
import assign_permission_model from './components/backend/ADM/assign_permission_model.vue'
import users from './components/backend/ADM/users.vue'
import user_update from './components/backend/ADM/user_update.vue'
import password_reset from './components/backend/ADM/password_reset.vue'

// data/order
import order_list from './components/backend/DATA/ORDER/order_list.vue'
import order_vouchers from './components/backend/DATA/ORDER/order_vouchers.vue'
import item_search from './components/backend/DATA/ORDER/item_search.vue'
import order_items from './components/backend/DATA/ORDER/order_items.vue'
import item_search_detail from './components/backend/DATA/ORDER/item_search_detail.vue'

// data/shipment
// data/receive
// data/invoice
// data/payment

// common

import default_parent from './components/backend/default_parent.vue'
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
import data_order_receive from './components/backend/DATA/RECEIVE/data_order_receive.vue'
import receive_detail from './components/backend/DATA/RECEIVE/receive_detail.vue'
import receive_item_detail from './components/backend/DATA/RECEIVE/receive_item_detail.vue'
import order_corrected_receive from './components/backend/DATA/CRTRCV/order_corrected_receive.vue'
import return_item_list from './components/backend/DATA/RETURN/return_item_list.vue'
import payment_list from './components/backend/DATA/PAYMENT/payment_list.vue'
import payment_detail from './components/backend/DATA/PAYMENT/payment_detail.vue'
import payment_item_detail from './components/backend/DATA/PAYMENT/payment_item_detail.vue'

import invoice_list from './components/backend/DATA/INVOICE/invoice_list.vue'
import invoice_details from './components/backend/DATA/INVOICE/invoice_details.vue'
import voucher_detail from './components/backend/voucher_detail.vue'
import pdf_platform_setting from './components/backend/PDF_PLATFORM/pdf_platform_setting.vue'
import pdf_platform_view from './components/backend/PDF_PLATFORM/pdf_platform_view.vue'
import blog from './components/backend/CMN/cmn_blog_list.vue'
import selected_buyer from './components/backend/SLR/selected_byr_page.vue'
import management_setting from './components/backend/CONFIG/management_setting.vue'
import { homedir } from 'os'
// import login_body from './components/login/login_body.vue'

export const routes = [

    {
        path: '/home',
        component: Home,
        name: 'home',
        meta: {
            breadcrumb: {
                label: 'HOME'
            }
        },
    },
    {
        path: '/blog',
        component: blog,
        name: 'blog',
        meta: {
            breadcrumb: {
                label: 'お知らせ'
            }
        },
    },
    {
        path: '/role',
        name: "role",
        component: Role,
        meta: {
            breadcrumb: {
                label: '役割'
            },
        },
    },
    {
        path: '/permission',
        name: 'permission',
        component: permission,
        meta: {
            breadcrumb: {
                label: '許可'
            },
        },
    },
    {
        path: '/assign_role_to_user',
        name: 'assign_role_to_user',
        component: assign_role_model,
        meta: {
            breadcrumb: {
                label: 'ユーザーに役割を割り当てる'
            },
        },
    },
    {
        path: '/assign_permission_to_user',
        name: 'assign_permission_to_user',
        component: assign_permission_model,
        meta: {
            breadcrumb: {
                label: 'ユーザーに権限を割り当てる'
            },
        },
    },
    {
        path: '/users',
        name: 'users',
        component: users,
        meta: {
            breadcrumb: {
                label: 'ユーザー'
            },
        },
    },
    {
        path: '/users/:id/:auth_id',
        name: 'user_update',
        component: user_update,
        meta: {
            breadcrumb: {
                label: 'ユーザーアップデート',
                parent: 'users'
            },
        },
    },
    {
        path: '/password_reset/:id/:auth_id',
        name: 'password_reset',
        component: password_reset,
        meta: {
            breadcrumb: {
                label: 'パスワードのリセット',
                parent: 'users'
            },
        },
    },
    {
        path: '/order_list',
        component: order_list,
        name: 'order_list',
        meta: {
            breadcrumb: {
                label: '受注トップ',
                parent: 'home'
            },
        },
        children: [

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


    {
        path: '/order_list/order_list_details',
        component: order_vouchers,
        name: 'order_list_details',
        meta: {
            // breadcrumb: 'Order detail'
            breadcrumb: {
                label: '受注伝票一覧',
                parent: 'order_list'
            },
        },

    },

    {
        path: '/order_list/order_list_details/item_search',
        component: item_search,
        name: 'item_search',
        meta: {

            breadcrumb: {
                label: '受注商品別一覧',
                parent: 'order_list_details'
            },
        },

    },

    {
        path: '/order_list/order_list_details/item_search/:item_id',
        component: item_search_detail,
        name: 'item_search_detail',
        meta: {

            breadcrumb: {
                label: '受注商品別明細',
                parent: 'item_search'
            },
        },

    },
    {
        path: '/order_list/order_list_details/order_item_list_detail/:data_order_list_voucher_id',
        component: order_items,
        name: 'order_item_list_detail',
        meta: {
            breadcrumb: {
                label: '受注伝票明細',
                parent: 'order_list_details'
            }
        }
    },


    {
        path: '/voucher_setting',
        name: 'voucher_setting',
        component: voucher_setting,
        meta: {

            breadcrumb: {
                label: 'Voucher seting'
            }

        },
    },
    {
        path: '/byr_management',
        component: byr_management,
        name: 'byr_management',
        meta: {

            breadcrumb: {
                label: '小売管理',
            }

        },


    },
    {
        path: '/byr_management/byr_company_user_list/:cmn_company_id',
        component: cmn_company_user_list,
        name: 'byr_company_user_list',
        meta: {
            breadcrumb: {
                label: 'ユーザーリスト管理',
                parent: 'byr_management'
            },
        },
    },

    {
        // path: '/byr_management/byr_company_partner_list/:byr_buyer_id/slr_job_list/:slr_seller_id',
        path: '/byr_management/byr_company_partner_list',
        component: slr_job_list,
        name: 'slr_job_list',
        meta: {
            breadcrumb: {
                label: 'ユーザーリスト管理',
                parent: 'byr_management'
            },
        }
    },
    {
        path: '/partner_list_manage',
        component: cmn_company_partner_list,
        name: 'partner_list_manage',
        meta: {
            breadcrumb: {
                label: 'パートナーリスト',
            },
        },

    },
    {
        path: '/byr_management/partner_list_manage',
        component: cmn_company_partner_list,
        name: 'adm_partner_list_manage',
        meta: {
            breadcrumb: {
                label: 'パートナーリスト',
                parent: 'byr_management'
            },
        },

    },
    {
        path: '/user_list_manage',
        component: cmn_company_user_list,
        name: 'user_list_manage',
        meta: {

            breadcrumb: {
                label: 'ユーザーリスト管理'
            },
        },
    },
    {
        path: '/scenario_management',
        component: scenario_management,
        name: 'scenario_management',
        meta: {
            breadcrumb: {
                label: 'シナリオ管理'
            }
        },
    },
    {
        path: '/job_management',
        component: job_management,
        name: 'job_management',
        meta: {
            breadcrumb: {
                label: '仕事の管理'
            }
        },
    },
    {
        path: '/slr_management',
        component: slr_management,
        name: 'slr_management',
        meta: {
            breadcrumb: {
                label: '問屋管理'
            }
        },
    },
    {
        path: '/slr_management/slr_company_user_list/:cmn_company_id',
        component: cmn_company_user_list,
        name: 'slr_company_user_list',
        meta: {
            breadcrumb: {
                label: '問屋管理'
            }
        },

    },
    {
        path: '/slr_management/slr_company_partner_list/:cmn_company_id',
        component: cmn_company_partner_list,
        name: 'slr_company_partner_list',
        meta: {
            breadcrumb: {
                label: '問屋管理'
            }
        },

    },
    {
        path: '/item_master',
        component: item_master,
        name: 'item_master',
        meta: {
            breadcrumb: {
                label: '商品メンテ'
            }
        },
    },
    {

        path: '/item_category',
        component: item_category,
        name: 'item_category',
        meta: {
            breadcrumb: '分類'
        },

    },

    {
        path: '/order_receive',
        component: data_order_receive,
        name: 'order_receive',
        meta: {
            breadcrumb: {
                label: '受領トップ',
                parent:'home'
            }
        },
    },
    {
        path: '/order_receive/receive_detail/:data_receive_id',
        component: receive_detail,
        name: 'receive_detail',
        meta: {
            breadcrumb: {
                label: '受領伝票一覧',
                parent: 'order_receive'
            }
        },
    },
    {
        path: '/order_receive/receive_detail/receive_item_detail/:data_receive_voucher_id',
        component: receive_item_detail,
        name: 'receive_item_detail',
        meta: {
            breadcrumb: {
                label: '受領伝票一覧',
                parent: 'receive_detail'
            }
        },
    },
    {
        path: '/order_corrected_receive',
        component: order_corrected_receive,
        name: 'order_corrected_receive',
        meta: {
            breadcrumb: {
                label: '受領訂正データ'
            }
        },

    },
    {
        path: '/return_item_list',
        component: return_item_list,
        name: 'return_item_list',
        meta: {
            breadcrumb: {
                label: '返品データ'
            }
        },

    },
    {
        path: '/payment_list',
        component: payment_list,
        name: 'payment_list',
        meta: {
            breadcrumb: {
                label: '支払受信一覧',
                parent:'home'
            }
        }

    },
    {
        path: '/payment_list/payment_detail',
        component: payment_detail,
        name: 'payment_detail',
        meta: {

            breadcrumb: {
                label: '支払合計',
                parent: 'payment_list'
            },
        },

    },
    {
        path: '/payment_list/payment_detail/payment_item_detail',
        component: payment_item_detail,
        name: 'payment_item_detail',
        meta: {

            breadcrumb: {
                label: '取引先別支払明細',
                parent: 'payment_detail'
            },
        },

    },
    {
        path: '/invoice_list',
        component: invoice_list,
        name: 'invoice_list',
        meta: {
            breadcrumb: {
                label: '請求トップ',
                parent:'home'
            }
        },


    },
    {
        path: '/invoice_list/invoice_details',
        component: invoice_details,
        name: 'invoice_details',
        meta: {
            breadcrumb: {
                label: '請求伝票一覧',
                parent: 'invoice_list'
            }
        }
    },
    {
        path: '/invoice_list/voucher_detail/:voucher_number',
        component: voucher_detail,
        name: 'voucher_detail',
        meta: { breadcrumb: '伝票一覧・新規請求' }
    },
    {
        path: '/pdf_platform_setting',
        component: pdf_platform_setting,
        name: 'pdf_platform_setting',
        meta: {
            breadcrumb: {
                label: 'pdfプラットフォーム設定'
            }
        },

    },
    {
        path: '/pdf_platform_view',
        component: pdf_platform_view,
        name: 'pdf_platform_view',
        meta: {
            breadcrumb: {
                label: 'pdfプラットフォーム'
            }
        },

    },
    {
        path: '/home/selected_buyer',
        component: selected_buyer,
        name: 'selected_buyer',
        props: true,

        meta: { breadcrumb: { label: '得意先別HOME', parent: 'home' } },


    },
    {
        path: '/management_setting',
        component: management_setting,
        name: 'management_setting',
        meta: {
            breadcrumb: {
                label: '管理'
            }
        },
    },
    // { path: '/login', name: 'login', component: login_body },
];
