<template>
  <!-- <div> -->
  <!-- Hi -->
  <!-- {{app.user?app.user.name:'Account'}} -->
  <main class="main-content p-0">
    <div class="main-navbar sticky-top bg_custom_color">
      <!-- Main Navbar -->
      <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
        <div class="row" style="margin-right: 0; margin-left: 0; width: 100%">
          <div class="col-2">
            <div class="site_logo">
              <router-link to="/home">
                <img
                id="main-logo"
                class="d-inline-block align-top mr-1"
                style="max-width: 100%; height: 60px"
                :src="BASE_URL + '/public/backend/images/logo/jacos_logo.png'"
                alt="Jacos Dashboard"
              />
              </router-link>
            </div>
          </div>
          <div class="col-4">
            <!--<div class="custom_bredcrubs">
              <Breadcrumbs></Breadcrumbs>
          </div>-->
          </div>
          <!-- @focusout="toggle = false" -->
          
          <div class="col-1 p-0">
            <button
              v-if="company_name != ''"
              @click="toggle = !toggle"
              class="btn btn-default byr_list_show"
            >
              得意先選択
            </button>
           
            <div
              class="top_byr_slr_list" style="display:none"
              v-if="company_name != ''"
              v-show="toggle"
            >
              <table
                class="table b-table custom_slr_byr_top_table table-bordered"
              >
                <thead>
                  <tr>
                    <th>得意先名</th>
                    <th>受注件数</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="buyer in buyer_info_for_saller" :key="buyer.byr_buyer_id">
                    <td>{{buyer.buyer_name}}</td>
                    <td>{{buyer.total_order}}件</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-5 p-0">
            <ul class="navbar-nav top_custom_ul flex-row">
              <li class="nav-item" v-if="company_name != ''">
                <a class="uer_company nav-link top_menu_custom_a">
                  <b-icon icon="grid3x3-gap-fill"></b-icon>
                  {{ company_name }}</a
                >
              </li>

              <li class="nav-item dropdown">
                <a
                  class="nav-link top_menu_custom_a dropdown-toggle text-nowrap px-3"
                  data-toggle="dropdown"
                  href="#"
                  role="button"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <!-- @if(Auth::user()->image) -->
                  <!--
              <img
                class="user-avatar rounded-circle mr-2"
                style="max-height: 46px !important"
                v-if="user_data.user"
                :src="imageSrc()"
                alt
              />-->
                  <!-- <img class="rounded-circle" v-if="user_image" :src="user_image" alt="No image" width="110" /> -->
                  <!-- @endif -->
                  <span class="d-none d-md-inline-block">
                    <b-avatar variant=""></b-avatar>
                    {{ user_data.user ? user_data.user.name : "" }}
                  </span>
                </a>
                <div
                  class="dropdown-menu dropdown-menu-small"
                  style="margin-left: -60px"
                >
                  <!-- @can('personal_profile_view') -->
                  <!-- <a class="dropdown-item"
                            :href="BASE_URL+'/users/1'">
                            <i class="material-icons">&#xE7FD;</i> Profile
              </a>-->
                  <router-link
                    :to="{
                      name: 'users',
                      params: {
                        id: global_user_id,
                        auth_id: global_user_id,
                      },
                    }"
                    class="dropdown-item"
                  >
                    <i class="material-icons">&#xE7FD;</i> Profile
                  </router-link>
                  <!-- @endcan
              @can('personal_password_change')-->
                  <router-link
                    :to="{
                      name: 'password_reset',
                      params: {
                        id: global_user_id,
                        auth_id: global_user_id,
                      },
                    }"
                    class="dropdown-item pc"
                  >
                    <i class="fas fa-edit"></i>
                    {{ myLang.change_password }}
                  </router-link>
                  <!-- <button class="dropdown-item pc" id="auth_user_id">
                            <i class="material-icons">vertical_split</i> Change Password
              </button>-->
                  <!-- @endcan -->
                  <!-- <a class="dropdown-item" href="add-new-post.html">
                    <i class="material-icons">note_add</i> Add New Post
              </a>-->
                  <div class="dropdown-divider"></div>
                  <!-- <a class="dropdown-item text-danger" href="#">
              <i class="material-icons text-danger">&#xE879;</i> Logout </a>-->
                </div>
              </li>
              <li class="nav-item">
                <button
                  class="btn btn-defalut logout_btn text-danger"
                  @click="logout()"
                >
                  Logout
                </button>
              </li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle_backup text-nowrap px-3"
                  href="#"
                  id="navbarDropdown_setting"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span class="h4">
                    <b-icon
                      icon="gear-fill"
                      aria-hidden="true"
                      style="color: #fff"
                    ></b-icon>
                  </span>
                </a>
                <div
                  class="dropdown-menu dropdown-menu-small"
                  aria-labelledby="navbarDropdown_setting"
                >
                  <!-- <a class="dropdown-item csv_output" href="#">CSV出力</a>
              <div class="dropdown-divider"></div>-->
                  <button
                    @click="display_table_col_setting"
                    class="dropdown-item display_item_setting"
                  >
                    表示項目設定
                  </button>
                  <!-- <div class="dropdown-divider"></div>
              <a class="dropdown-item setting_printing" href="#">印刷</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item csv_import_jan" href="#">CSVインポート JAN</a>
              <button class="dropdown-item display_arrow_setting">セル移動</button>-->
                </div>
              </li>

              <li class="nav-item dropdown">
                <a
                  class="nav-link top_menu_custom_a dropdown-toggle text-nowrap px-3"
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span
                    class="flag-icon flag-icon-jp"
                    v-if="local == 'ja'"
                  ></span>
                  <span
                    class="flag-icon flag-icon-us"
                    v-if="local == 'en'"
                  ></span>
                  {{ local == "en" ? "English" : "日本語" }}
                </a>
                <div
                  class="dropdown-menu dropdown-menu-small"
                  aria-labelledby="navbarDropdown"
                >
                  <a class="dropdown-item" :href="BASE_URL + '/language/en'">
                    <span class="flag-icon flag-icon-us"></span>
                    English
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" :href="BASE_URL + '/language/ja'">
                    <span class="flag-icon flag-icon-jp"></span>
                    日本語
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>

        <nav class="nav">
          <a
            href="#"
            class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left"
            data-toggle="collapse"
            data-target=".header-navbar"
            aria-expanded="false"
            aria-controls="header-navbar"
          >
            <i class="material-icons">&#xE5D2;</i>
          </a>
        </nav>
      </nav>
    </div>
    <!-- <b-modal size="lg" :hide-backdrop="true" :title="Management" v-model="table_col_modal">
      <div v-html="permissions_for_col"></div>
    </b-modal>-->
    <!-- / .main-navbar -->
    <b-modal
      id="table_col_setting"
      :hide-backdrop="true"
      ref="table_colShowHide"
      title="表示項目設定"
      cancel-title="キャンセル"
      ok-title="変更"
      @ok.prevent="update_col_setting()"
    >
      <!-- <div v-html="table_col_setting_list"></div> -->
      <table class="table table-bordered table_col_ssettings">
        <thead>
          <th>表示項目名</th>
          <th>表示ON/OFF</th>
        </thead>
        <tbody>
          <tr v-for="table_col in table_col_arry" :key="table_col.header_field">
            <td>{{ table_col.header_text }}</td>
            <td>
              <label class="switch">
                <input
                  @change="handleChange(table_col)"
                  :id="table_col.header_field"
                  type="checkbox"
                  v-model="table_col.header_status"
                />
                <span class="slider round"></span>
              </label>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- <b-form-checkbox-group id="checkbox-group" v-model="selected_columns">
        <ul style="list-style:none;">
          <li v-for="(col_list, index) in col_lists" :key="index">
            <b-form-checkbox :value="col_list.header_field" switch>
              <p class="btn btn-info" style="padding:5px;margin:3px;">{{ col_list.header_text }}</p>
            </b-form-checkbox>
          </li>
        </ul>
      </b-form-checkbox-group>-->
    </b-modal>
  </main>
</template>

<script>
export default {
  name: "navbar",
  props: ["app"],
  data() {
    return {
      local: Globals.local,
      user_data: null,
      company_name: null,
      user_byr_slr_list: [],
      toggle: false,
      // buyer_info_for_saller:[],
      fields: [
        {
          key: "header_1",
          label: "得意先名",
          sortable: false,
        },
        {
          key: "header_2",
          label: "受注件数",
          sortable: false,
        },
      ],
      byrslrlst: [
        { isActive: true, header_1: "イオン", header_2: "500件" },
        { isActive: true, header_1: "イオン", header_2: "500件" },
        { isActive: true, header_1: "イオン", header_2: "500件" },
        { isActive: true, header_1: "イオン", header_2: "500件" },
        { isActive: true, header_1: "イオン", header_2: "500件" },
      ],
      // BASE_URL:BASE_URL,
    };
  },
  methods: {
    imageSrc() {
      return (
        this.BASE_URL +
        "/storage/app/public/backend/images/users/" +
        this.user_data.user.image
      );
    },
    get_user_company_info() {
      axios
        .post(this.BASE_URL + "api/get_user_company_byr_slr_list")
        .then(({data}) => {
          this.company_name = data.user_company_info.company_name;
          this.user_byr_slr_list = data.byr_slr_list;
          // console.log(this.global_user_id)
          // this.buyer_info_for_saller=this.allBuyerInfoBySaller(this.global_user_id)
          
          // console.log(this.buyer_info_for_saller);
          // console.log(this.user_data.user.id);
          
        });
    },
  },
  created() {
    this.get_user_company_info();
    this.user_data = this.app._data;
    // console.log(this.global_user_id)
    this.allBuyerInfoBySaller(this.global_user_id)
    // console.log(this.buyer_info_for_saller);
    // this.allBuyerInfoBySaller(this.user_data.user.id);
  },
};
</script>
<style>
/* .byr_list_show:focus .top_byr_slr_list{
  display: block;
} */
</style>
