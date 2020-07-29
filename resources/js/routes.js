import Home from './components/backend/home_component.vue'
import Role from './components/backend/role_component.vue'
import permission from './components/backend/permission_component.vue'
import assign_role_model from './components/backend/assign_role_model.vue'
import assign_permission_model from './components/backend/assign_permission_model.vue'
import users from './components/backend/users.vue'
import user_update from './components/backend/user_update.vue'
import password_reset from './components/backend/password_reset.vue'
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
    // { path: '/login', name: 'login', component: login_body },
];