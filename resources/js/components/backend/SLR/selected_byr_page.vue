<template>
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <br>
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-3">


                <!-- <router-view/> -->
                <!--<page_header_default></page_header_default>-->
               <!-- <byr_slr_list_with_order></byr_slr_list_with_order>-->
                <blog_view_for_select_customer></blog_view_for_select_customer>


            </div>



        </div>
</div>
</template>

<script>
 import page_header_default from '../page_header_default'
 import byr_slr_list_with_order from './byr_slr_list_with_order'
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
        // beforeCreate: function() {

        // },
        methods:{
        //    buyer_route_change(byr_buyer_id){
        //      console.log(byr_buyer_id);
        //       this.$router.push({
        //         name: 'selected_buyer',
        //         params: { byr_buyer_id: byr_buyer_id }
        //       })
        //    },
        },
          created() {
            //   router.app.$session.set('buyer_id', this.$route.params.byr_buyer_id);
            // this.$session.start()
            // this.$session.set('byr_buyer_id', this.$route.params.byr_buyer_id)
             this.byr_session_check()
             Fire.$emit('byr_has_selected',this.$session.get('byr_buyer_id'));
             Fire.$emit('permission_check_for_buyer',this.$session.get('byr_buyer_id'));
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
