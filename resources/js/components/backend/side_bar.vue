<template>
  <!-- Main Sidebar -->
  <!-- main-sidebar -->
<aside class="main-sidebar" style="position:absolute; top:-60px;">
    <div class="main-navbar">
        <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                    <router-link to="/" class="nav-link" style="line-height: 25px;">
                <div class="d-table m-auto">
                    <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25%;"
                        src="/template_vue/public/backend/images/logo/jacos_logo.png"
                        alt="Jacos Dashboard">
                    <span class="d-none d-md-inline ml-1">{{myLang.heading}}</span>
                </div>
            </router-link>
            <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </nav>
    </div>
    <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
        <div class="input-group input-group-seamless ml-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-search"></i>
                </div>
            </div>
            <input class="navbar-search form-control" type="text" placeholder="Search for something..."
                aria-label="Search">
        </div>
    </form>
    <div class="nav-wrapper">
        <ul class="nav flex-column">
            <li class="nav-item" v-can="['dashboard_menu']">
                <router-link to="/home" class="nav-link"><i class="material-icons">home</i> {{myLang.dashboard_text}}</router-link>
            </li>
            <!-- v-if="can('role_menu')" -->
            <li class="nav-item" v-can="['role_menu']">
                <router-link to="/role" class="nav-link"><i class="material-icons">person</i> {{myLang.role_management}}</router-link>
            </li>
            <li class="nav-item" v-can="['permission_menu']">
                <router-link to="/permission" class="nav-link"><i class="material-icons">account_balance</i> {{myLang.permission_management}}</router-link>
            </li>
            <li class="nav-item" v-can="['assign_role_to_user_menu']">
                <router-link to="/assign_role_to_user" class="nav-link"><i class="material-icons">all_inclusive</i> {{myLang.assign_role_to_user}}</router-link>
            </li>
            <li class="nav-item" v-can="['assign_permission_to_user_menu']">
                <router-link to="/assign_permission_to_user" class="nav-link"><i class="material-icons">enhanced_encryption</i> {{myLang.assign_permission_to_user}}</router-link>
            </li>
            <li class="nav-item" v-can="['manage_user_menu']">
                <router-link to="/users" class="nav-link"><i class="material-icons">person</i> {{myLang.manage_users}}</router-link>
            </li>
            
        </ul>
    </div>
</aside>
</template>

<script>
export default {
name: 'sidebar',
props:['app'],
data(){
    return{
    }
}
}
</script>