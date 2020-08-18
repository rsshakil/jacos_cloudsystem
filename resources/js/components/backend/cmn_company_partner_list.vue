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
        'company_lists':{},
    };
  },
  methods: {
       get_all_company(){
        axios.get(this.BASE_URL +"api/jacosmanagement").then((data) => {
            this.company_lists = data.data.company_list;
            console.log(this.company_lists);
        });
    },
  },

  created() {
      this.get_all_company();
      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>