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
              <li v-can="['byr_view','manage_user_menu']" class="nav-item">
                <router-link to="/blog" class="nav-link">
                  <b-icon icon="house-fill" font-scale="1.2"></b-icon>
                  {{ myLang.new_notice }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['role_menu']">
                <router-link to="/role" class="nav-link">
                  <b-icon icon="person-check-fill" font-scale="1.2"></b-icon>
                  {{ myLang.role_management }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['permission_menu']">
                <router-link to="/permission" class="nav-link">
                  <b-icon icon="person-bounding-box" font-scale="1.2"></b-icon>
                  {{ myLang.permission_management }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['assign_role_to_user_menu']">
                <router-link to="/assign_role_to_user" class="nav-link">
                  <b-icon icon="folder-symlink-fill" font-scale="1.2"></b-icon>
                  {{ myLang.assign_role_to_user }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['assign_permission_to_user_menu']">
                <router-link to="/assign_permission_to_user" class="nav-link">
                  <b-icon icon="unlock-fill" font-scale="1.2"></b-icon>
                  {{ myLang.assign_permission_to_user }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['manage_user_menu']">
                <router-link to="/users" class="nav-link">
                  <b-icon icon="person-circle" font-scale="1.2"></b-icon>
                  {{ myLang.manage_users }}
                </router-link>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item" v-can="['byr_view', 'slr_view']">
          <a
            class="nav-link collapsed"
            href="#byrslrmenu1"
            data-toggle="collapse"
            data-target="#byrslrmenu1"
            ><b-icon icon="grid-fill" font-scale="1.2"></b-icon>
            {{ myLang.management }}</a
          >
          <div class="collapse" id="byrslrmenu1" aria-expanded="false">
            <ul class="flex-column pl-2 nav">
              <li class="nav-item" v-can="['byr_view']">
                <router-link to="/order_list" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.order_list }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['slr_view','order_list']">
                <router-link to="/order_list" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.order_list }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['byr_view']">
                <router-link to="/voucher_setting" class="nav-link">
                  <b-icon icon="tools" font-scale="1.2"></b-icon>
                  {{ myLang.jacos_voucher_setting }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['byr_view']">
                <router-link to="/jacos_management" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.buyer_management }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['manage_user_menu']">
                <router-link to="/scenario_management" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.scenario_management }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['slr_management']">
                <router-link to="/slr_management" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.wholesaler_management }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['order_receive', 'byr_view']">
                <router-link to="/order_receive" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.order_receive }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['order_corrected_receive', 'byr_view']">
                <router-link to="/order_corrected_receive" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.order_corrected_receive }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['return_item_list', 'byr_view']">
                <router-link to="/return_item_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.return_data }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['payment_list', 'byr_view']">
                <router-link to="/payment_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.payment_list }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['invoice_list', 'byr_view']">
                <router-link to="/invoice_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.invoice_data }}
                </router-link>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item" v-can="['byr_view']">
          <a
            class="nav-link collapsed"
            href="#byr_itms_list"
            data-toggle="collapse"
            data-target="#byr_itms_list"
            ><b-icon icon="grid-fill" font-scale="1.2"></b-icon>
            {{ myLang.master_management }}</a
          >
          <div class="collapse" id="byr_itms_list" aria-expanded="false">
            <ul class="flex-column pl-2 nav">
              <li class="nav-item" v-can="['byr_view']">
                <router-link to="/item_master" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.product_management }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['byr_view']">
                <router-link to="/item_category" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.category_management }}
                </router-link>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item" v-can="['byr_view']">
          <a
            class="nav-link collapsed"
            href="#pdf_platform_setting"
            data-toggle="collapse"
            data-target="#pdf_platform_setting"
            ><b-icon icon="grid-fill" font-scale="1.2"></b-icon>
            {{ myLang.pdf_platform }}</a
          >
          <div class="collapse" id="pdf_platform_setting" aria-expanded="false">
            <ul class="flex-column pl-2 nav">
              <li class="nav-item" v-can="['byr_view']">
                <router-link to="/pdf_platform_setting" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.pdf_platform_setting }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['byr_view']">
                <router-link to="/pdf_platform_view" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.pdf_platform_show }}
                </router-link>
              </li>
            </ul>
          </div>
        </li>

        <!-- <li class="nav-item">
          <router-link to="/shipment_list" class="nav-link">
            <i class="material-icons">local_taxi</i>
            {{myLang.shipment_list}}
          </router-link>
        </li>-->
        <!-- <li class="nav-item">
          <a class="nav-link" href="#" @click.prevent="logout">
            <i class="material-icons">power_settings_new</i>
            Logout
          </a>
        </li>-->
      </ul>
    </div>
  </aside>
</template>

<script>
export default {
  name: "sidebar",
  props: ["app"],
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
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
  },
};
</script>