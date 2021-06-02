<template>
<div>
    <ul class="nav jcs_left_side_bar_menu flex-column">

<li class="nav-item">
          <a
            class="nav-link collapsed"
            href="#byrmenu1"
            data-toggle="collapse"
            data-target="#byrmenu1"
            ><b-icon icon="gear-fill" font-scale="1.2"></b-icon>
            BYR</a
          >
          <div class="collapse" id="byrmenu1" aria-expanded="false">
            <ul class="flex-column pl-2 nav">
            <li v-can="['byr_view','manage_user_menu']" class="nav-item">
                <router-link to="/blog" class="nav-link">
                  <b-icon icon="house-fill" font-scale="1.2"></b-icon>
                  {{ myLang.new_notice }}
                </router-link>
              </li>
            <li class="nav-item" v-can="['item_master']">
                <router-link to="/item_master" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.product_management }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['item_category']">
                <router-link to="/item_category" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.category_management }}
                </router-link>
              </li>
              </ul>
              </div>
              </li>

<!--new slr menu for byr-->
<li class="nav-item">
          <a
            class="nav-link collapsed"
            href="#slrDatamenu1"
            data-toggle="collapse"
            data-target="#slrDatamenu1"
            ><b-icon icon="gear-fill" font-scale="1.2"></b-icon>
            問屋データ</a
          >
          <div class="collapse" id="slrDatamenu1" aria-expanded="false">
            <ul class="flex-column pl-2 nav">
            <li class="nav-item" v-can="['byr_view']">
                <router-link to="/order_list" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                 受注・出荷業務
                </router-link>
              </li>
               <li class="nav-item" v-can="['byr_view']">
                <router-link to="/order_receive" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                 受領確認
                </router-link>
              </li>
              <li class="nav-item" v-can="['byr_view']">
                <router-link to="/return_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                 返品確認
                </router-link>
              </li>
             
              <li class="nav-item" v-can="['byr_view']">
                <router-link to="/invoice_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  請求業務
                </router-link>
              </li>
              <li class="nav-item" v-can="['byr_view']">
                <router-link to="/payment_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                支払確認
                </router-link>
              </li>
            </ul>
              </div>
              </li>
<!--new slr menu for byr-->

    </ul>
</div>
</template>
<script>
export default {
  data() {
    return {
     
    };
    
  },
  methods: {
  
  },
  created(){
      
  }
};
</script>