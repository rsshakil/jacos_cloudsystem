<template>
<div style="clear:both">
<div class="row">
           <div class="col-12 text-center page_c_title_bar text-sm-left mb-0">
            <h4 class="page_custom_title"> <span v-html="page_heading"></span></h4>
       
        </div>
    </div>
</div>

</template>

<script>
    export default {

        data(){
            return {
                page_heading:'<i class="fas fa-wrench custom_wrench"></i> 得意先一覧',
            }
        },
        methods:{
          
        },
          created() {
      if(this.$route.name=='order_list'){
          this.page_heading = '受注受信一覧';
      }else if(this.$route.name=='order_receive'){
          this.page_heading = '受領受信一覧';
      }else if(this.$route.name=='payment_list'){
          this.page_heading = '支払受信一覧';
      }
        Fire.$on("loadPageTitle", (PageTitle) => {
            this.page_heading = PageTitle;
        });
  },
        mounted() {
            this.init();
            console.log('Home Component mounted.')
        }
    }
</script>