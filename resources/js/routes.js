import Home from './components/backend/home_component.vue'
import Role from './components/backend/role_component.vue'
import permission from './components/backend/permission_component.vue'
import assign_role_model from './components/backend/assign_role_model.vue'
import assign_permission_model from './components/backend/assign_permission_model.vue'
import users from './components/backend/users.vue'
import user_update from './components/backend/user_update.vue'
import password_reset from './components/backend/password_reset.vue'
import order_list from './components/backend/order_list.vue'
import byr_order_detail from './components/backend/byr_order_detail.vue'
import order_details_canvas from './components/backend/order_details_canvas.vue'
import voucher_setting from './components/backend/canvas.vue'
// import login_body from './components/login/login_body.vue'

export const routes = [
    { path: '/', component: Home },
    { path: '/home', component: Home },
    { path: '/role', component: Role },
    { path: '/permission', component: permission },
    { path: '/assign_role_to_user', component: assign_role_model },
    { path: '/assign_permission_to_user', component: assign_permission_model },
    { path: '/users', component: users },
    { path: '/users/:id/:auth_id', name: 'users', component: user_update },
    { path: '/password_reset/:id/:auth_id', name: 'password_reset', component: password_reset },
    { path: '/order_list', component: order_list },
    { path: '/order_list/order_list_detail/:byr_order_id', name: 'order_list_detail', component: byr_order_detail },
    { path: '/order_list/order_details_canvas/:byr_order_id', name: 'order_details_canvas', component: order_details_canvas },

    { path: '/voucher_setting', name: 'voucher_setting', component: voucher_setting },
    // { path: '/login', name: 'login', component: login_body },
];