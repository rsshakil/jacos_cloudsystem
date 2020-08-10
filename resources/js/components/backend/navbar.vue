<template>
<main class="main-content p-0 ">
    <div class="main-navbar sticky-top bg-white">
        <!-- Main Navbar -->
        <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
            <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                <div class="input-group input-group-seamless ml-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        </div>
                    </div>
                    <input class="navbar-search form-control" type="hidden" placeholder="Search for something..."
                        aria-label="Search">
                </div>
            </form>
            <ul class="navbar-nav border-left flex-row ">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-nowrap px-3" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="flag-icon flag-icon-jp" v-if="local=='ja'" ></span> 
                            <span class="flag-icon flag-icon-us" v-if="local=='en'"></span> {{local=='en'?'English':'日本語'}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-small" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" :href="BASE_URL+'language/en'">
                        <span class="flag-icon flag-icon-us"></span> English</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" :href="BASE_URL+'language/ja'"><span
                                class="flag-icon flag-icon-jp"></span> 日本語</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <!-- <img class="user-avatar rounded-circle mr-2" style="max-height: 46px !important;" :src="global_image_path" alt=""> -->
                        <img class="user-avatar rounded-circle mr-2" style="max-height: 46px !important;" v-if="user_data.user" :src="imageSrc(user_data.user.image)" alt="">
                        <span class="d-none d-md-inline-block"> {{(user_data.user)?user_data.user.name:''}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-small" style="">
                        <router-link :to="{ name: 'users', params: { id: global_user_id,auth_id:global_user_id } }" class="dropdown-item"><b-icon icon="person" font-scale="1.2"></b-icon> {{myLang.profile_text}}</router-link>
                        <router-link :to="{ name: 'password_reset', params: { id: global_user_id,auth_id:global_user_id  } }" class="dropdown-item pc"><b-icon icon="pencil-square" font-scale="1.2"></b-icon> {{myLang.change_password}}</router-link>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item text-danger" @click="logout()"> <b-icon icon="box-arrow-right" font-scale="1.2"></b-icon> Logout </button>
                    </div>
                </li>
            </ul>
            <nav class="nav">
                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left"
                    data-toggle="collapse" data-target=".header-navbar" aria-expanded="false"
                    aria-controls="header-navbar">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </nav>
        </nav>
    </div>
    <!-- / .main-navbar -->
</main>
</template>

<script>
export default {
name: 'navbar',
props:['app'],
data(){
    return {
        local:Globals.local,
        user_data:null,
    }
},
methods:{
},
created(){
    this.user_data=this.app._data;
}
}
</script>