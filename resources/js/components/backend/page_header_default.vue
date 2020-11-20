<template>
<div>
<div class="row">
           <div class="col-12 text-center page_c_title_bar text-sm-left mb-0">
            <h4 class="page_custom_title"><i class="fas fa-wrench custom_warnce"></i> 得意先一覧</h4>
       
        </div>
    </div>
</div>

</template>

<script>
    export default {

        data(){
            return {
                'page_heading':'',
            }
        },
        methods:{
           
        },
          created() {

      console.log('created jacos management log');
  },
        mounted() {
            this.init();
            console.log('Home Component mounted.')
        }
    }
</script>