<template>
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <br>
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-3">
    


                <page_header_default></page_header_default>
               <!-- <byr_slr_list_with_order></byr_slr_list_with_order>-->
                <blog_view_for_select_customer></blog_view_for_select_customer>


            </div>



        </div>
</div>
</template>

<script>
 import page_header_default from '../page_header_default'
 import byr_slr_list_with_order from '../byr_slr_list_with_order'
 import blog_view_for_select_customer from './blog_view_for_select_customer'
    export default {
        components : {
    'page_header_default': page_header_default,
    'byr_slr_list_with_order': byr_slr_list_with_order,
    'blog_view_for_select_customer': blog_view_for_select_customer,
  },
        data(){
            return {
                home_title:'',
            }
        },
        methods:{
           
        },
          created() {
             Fire.$emit('byr_has_selected');
             console.log('resue dede');
            },
        mounted() {
            this.init();
            console.log('Home Component mounted.')
        },
        route: {
            canReuse: false,
        },
    }
</script>