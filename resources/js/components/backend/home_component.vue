<template>
<div>
   
                <byr_slr_list_with_order></byr_slr_list_with_order>
                <blog_view></blog_view>


           
</div>
</template>

<script>
 import byr_slr_list_with_order from './SLR/byr_slr_list_with_order'
 import blog_view from './blog_view'
    export default {
        components : {
    'byr_slr_list_with_order': byr_slr_list_with_order,
    'blog_view': blog_view,
  },
        data(){
            return {
                home_title:'',
            }
        },
        methods:{
           
        },
          created() {
                Fire.$emit('buyer_session_destroy');
            },
        mounted() {
            this.init();
        }
    }
</script>