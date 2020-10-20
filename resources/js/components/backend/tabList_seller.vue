<template>
<div class="project-tab">
    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
        <!--<button class="nav-item nav-link">基本情報</button>-->
        <router-link :to="{name:'company_seller_user_list',params:{cmn_company_id:cmn_company_id} }" class="nav-item nav-link">{{myLang.user_management}}</router-link>
        <button class="nav-item nav-link">{{myLang.shop_management}}</button>
        <button class="nav-item nav-link">{{myLang.partner_management}}</button>
        <button class="nav-item nav-link">{{myLang.ordering_data}}</button>
    </div>
</div>
</template>
<script>
export default {
  data() {
    return {
      cmn_company_id: "",
    };
  },
  methods: {
   
  },

  created() {
    this.cmn_company_id = this.$route.params.cmn_company_id;
  },
  mounted() {
    console.log("byr order detail page loaded");
  }
};
</script>