<template>
<div>
    <ul class="nav jcs_left_side_bar_menu flex-column">

<!--<li class="nav-item">
          <a
            class="nav-link collapsed"
            href="#slrmenu1"
            data-toggle="collapse"
            data-target="#slrmenu1"
            ><b-icon icon="gear-fill" font-scale="1.2"></b-icon>
            SLR</a>
          <div class="collapse" id="slrmenu1" aria-expanded="false">
            <ul class="flex-column pl-2 nav">

              
              <li class="nav-item" v-can="['order_list']">
                <router-link to="/order_list" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.order_list }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['voucher_setting']">
                <router-link to="/voucher_setting" class="nav-link">
                  <b-icon icon="tools" font-scale="1.2"></b-icon>
                  {{ myLang.jacos_voucher_setting }}
                </router-link>
              </li>
              
              

              <li class="nav-item" v-can="['order_receive']">
                <router-link to="/order_receive" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.order_receive }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['order_corrected_receive']">
                <router-link to="/order_corrected_receive" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.order_corrected_receive }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['return_item_list']">
                <router-link to="/return_item_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.return_data }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['payment_list']">
                <router-link to="/payment_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.payment_list }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['invoice_list']">
                <router-link to="/invoice_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.invoice_data }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['item_master']">
                <router-link to="/item_master" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.product_management }}
                </router-link>
              </li>
              
              </ul>
              </div>
              </li>-->
               <!--add menu here-->
              <li class="nav-item" v-can="['order_list']">
                <router-link to="/order_list" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.order_list }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['voucher_setting']">
                <router-link to="/voucher_setting" class="nav-link">
                  <b-icon icon="tools" font-scale="1.2"></b-icon>
                  {{ myLang.jacos_voucher_setting }}
                </router-link>
              </li>
              
              

              <li class="nav-item" v-can="['order_receive']">
                <router-link to="/order_receive" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.order_receive }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['order_corrected_receive']">
                <router-link to="/order_corrected_receive" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.order_corrected_receive }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['return_item_list']">
                <router-link to="/return_item_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.return_data }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['payment_list']">
                <router-link to="/payment_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.payment_list }}
                </router-link>
              </li>

              <li class="nav-item" v-can="['invoice_list']">
                <router-link to="/invoice_list" class="nav-link">
                  <b-icon icon="card-checklist" font-scale="1.2"></b-icon>
                  {{ myLang.invoice_data }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['item_master']">
                <router-link to="/item_master" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  {{ myLang.product_management }}
                </router-link>
              </li>
              <li class="nav-item" v-can="['invoice_list']">
                <router-link to="/management_setting" class="nav-link">
                  <b-icon icon="receipt" font-scale="1.2"></b-icon>
                  管理
                </router-link>
              </li>
              <!--add menu here-->
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