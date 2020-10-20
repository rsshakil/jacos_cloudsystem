<template>
<div class="project-tab">
    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
        <router-link :to="{name:'jacos_management_edit',params:{cmn_company_id:cmn_company_id} }" class="nav-item nav-link">{{myLang.basic_management}}</router-link>
        <router-link :to="{name:'cmn_company_user_list',params:{cmn_company_id:cmn_company_id} }" class="nav-item nav-link">{{myLang.user_management}}</router-link>
        <button class="nav-item nav-link">{{myLang.shop_management}}</button>
        <router-link :to="{name:'cmn_company_partner_list',params:{cmn_company_id:cmn_company_id} }" class="nav-item nav-link">{{myLang.partner_management}}</router-link>
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