<template>
  <!-- Main Sidebar -->
  <!-- main-sidebar -->
  <aside class="main-sidebar" style="position: absolute; top: 0px;width:100%">
    <!--<div class="main-navbar">
      <nav
        class="navbar align-items-stretch navbar-light flex-md-nowrap border-bottom p-0"
      >
        <router-link to="/" class="nav-link" style="line-height: 25px">
          <div class="d-table m-auto">
           
            <span class="d-none d-md-inline ml-1">{{ myLang.heading }}</span>
          </div>
        </router-link>
        <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
          <i class="material-icons">&#xE5C4;</i>
        </a>
      </nav>
    </div>-->
  
    <div class="nav-wrapper">

      <ul class="nav jcs_left_side_bar_menu flex-column">
        <li class="nav-item">
          <a
            class="nav-link collapsed"
            href="#dashboardmenu1"
            data-toggle="collapse"
            data-target="#dashboardmenu1"
            ><b-icon icon="gear-fill" font-scale="1.2"></b-icon>
            {{ myLang.dashboard_text }}</a
          >
          <div class="collapse" id="dashboardmenu1" aria-expanded="false">
            <ul class="flex-column pl-2 nav">
              <li class="nav-item">
                <router-link to="/home" class="nav-link">
                  <b-icon icon="house-fill" font-scale="1.2"></b-icon> Home
                </router-link>
              </li>
              
            </ul>
          </div>
        </li>
      </ul>
      <adm_menu v-role="['Super Admin']"></adm_menu>
      <common_menu v-role="['Super Admin']"></common_menu>
      <jacos_menu v-role="['Super Admin']"></jacos_menu>
      <slr_menu v-can="['slr_view']"></slr_menu>
      <byr_menu v-can="['byr_view']"></byr_menu>
      <user_menu v-role="['Super Admin']"></user_menu>
      <others_menu v-role="['Super Admin']"></others_menu>
      <byr_side_bar_menu v-if="permission_menu" :permissions_by_user="permissions_by_user"></byr_side_bar_menu>
    </div>
  </aside>
</template>

<script>
import adm_menu from './MENU/adm_menu'
import common_menu from './MENU/common_menu'
import jacos_menu from './MENU/jacos_menu'
import byr_side_bar_menu from './MENU/byr_side_bar_menu'
import byr_menu from './MENU/byr_menu'
import slr_menu from './MENU/slr_menu'
import others_menu from './MENU/others_menu'
import user_menu from './MENU/user_menu'
export default {
  name: "sidebar",
  props: ["app"],
  components:{
byr_side_bar_menu,
adm_menu,
common_menu,
jacos_menu,
byr_menu,
slr_menu,
others_menu,
user_menu,
},
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
        permissions_by_user:[],
        permission_menu:false,
    };
    
  },
  methods: {
    logout: function () {
      axios
        .post("logout")
        .then((response) => {
          if (response.status === 302 || 401) {
            console.log("logout");
          } else {
            // throw error and go to catch block
          }
        })
        .catch((error) => {});
    },
    allPermissionCheck(byr_id=null){
      axios.post(this.BASE_URL+'api/get_permissions_for_buyer',{byr_id:byr_id}).then(({data})=>{
        this.permissions_by_user=data.permission_array;
        if (this.permissions_by_user.length>0) {
          this.permission_menu= true
        }
        
        // console.log(data);
      })
    }

  },
  created(){
    // this.allPermissionCheck();
    Fire.$on("permission_check_for_buyer", (byr_id) => {
        this.allPermissionCheck(byr_id);
    });
    Fire.$on("buyer_session_destroy", () => {
        this.$session.destroy()
        this.permission_menu= false;
        Fire.$emit('byr_has_selected');
    });
  }
};
</script>