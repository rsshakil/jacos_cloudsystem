<template>
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <br>
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-3">
    


                <page_header_default></page_header_default>
                <byr_slr_list_with_order></byr_slr_list_with_order>
                <blog_view></blog_view>


            </div>



        </div>
</div>
</template>

<script>
 import page_header_default from './page_header_default'
 import byr_slr_list_with_order from './byr_slr_list_with_order'
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
            },
        mounted() {
            this.init();
            console.log('Home Component mounted.')
        }
    }
</script>