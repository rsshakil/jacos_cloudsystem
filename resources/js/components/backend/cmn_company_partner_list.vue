<template>
  <div>
    <div class="row">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">スーパーバリュー</h4>
                </div>
                
                <div class="col-3"></div>
                <div class="col-6">
                    <tabList></tabList>
                </div>
                <div class="col-3"></div>


                <div class="col-12">
                    <div class="">
                       company partner list
                    </div>
                </div>
            </div>
  </div>
</template>
<script>
import tabList from './tabList'

export default {
  name:'app',
components:{
tabList,
},
  data() {
    return {
        'company_partner_lists':{},
        'byr_buyer_id':'',
    };
  },
  methods: {
      get_all_partner_users(){
        axios.get(this.BASE_URL +"api/company_partner_list"+this.byr_buyer_id).then((data) => {
            this.company_partner_lists = data.data.partner_list;
            console.log(this.company_partner_lists);
        });
    },
  },

  created() {
    this.byr_buyer_id = this.$route.params.byr_buyer_id;
      this.get_all_partner_users();
      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>