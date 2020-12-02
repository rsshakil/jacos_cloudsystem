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