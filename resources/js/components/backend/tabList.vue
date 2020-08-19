<template>
<div class="project-tab">
    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
        <router-link :to="{name:'jacos_management_edit',params:{byr_buyer_id:byr_buyer_id} }" class="nav-item nav-link">基本情報</router-link>
        <router-link :to="{name:'cmn_company_user_list',params:{byr_buyer_id:byr_buyer_id} }" class="nav-item nav-link">ユーザー管理</router-link>
        <button class="nav-item nav-link">店舗管理</button>
        <router-link :to="{name:'cmn_company_partner_list',params:{byr_buyer_id:byr_buyer_id} }" class="nav-item nav-link">取引先管理</router-link>
        <button class="nav-item nav-link">発注データ</button>
    </div>
</div>
</template>
<script>
export default {
  data() {
    return {
      byr_buyer_id: "",
    };
  },
  methods: {
   
  },

  created() {
    this.byr_buyer_id = this.$route.params.byr_buyer_id;
  },
  mounted() {
    console.log("byr order detail page loaded");
  }
};
</script>