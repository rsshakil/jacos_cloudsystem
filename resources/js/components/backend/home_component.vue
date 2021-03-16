<template>
<div>
    
                <byr_slr_list_with_order></byr_slr_list_with_order>
                <blog_view></blog_view>


           
</div>
</template>

<script>
import page_header_default from './page_header_default'
 import byr_slr_list_with_order from './SLR/byr_slr_list_with_order'
 import blog_view from './blog_view'
    export default {
        components : {
    'page_header_default': page_header_default,
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
                 Fire.$emit("loadPageTitle", "得意先一覧");
            },
        mounted() {
            this.init();
        }
    }
</script>