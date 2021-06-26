<template>
    <div>
        <ul>
            <li v-for="(product,i) in products" :key="i">{{ product.name }}</li>
        </ul>
        <byr_slr_list_with_order></byr_slr_list_with_order>
        <blog_view></blog_view>
    </div>
</template>

<script>
const page_header_default = () =>
    import ( /* webpackChunkName: "page_header_default" */ './page_header_default')
const byr_slr_list_with_order = () =>
    import ( /* webpackChunkName: "byr_slr_list_with_order" */ './SLR/byr_slr_list_with_order')
const blog_view = () =>
    import ( /* webpackChunkName: "blog_view" */ './blog_view')
    // import page_header_default from './page_header_default'
    // import byr_slr_list_with_order from './SLR/byr_slr_list_with_order'
    // import blog_view from './blog_view'
    export default {
        components : {
            'page_header_default': page_header_default,
            'byr_slr_list_with_order': byr_slr_list_with_order,
            'blog_view': blog_view,
        },
        computed:{
            // products(){
            //     console.log(this.$store.state.orderModule.products)
            //     return this.$store.state.orderModule.products
            // }
            // products: this.store.state.products,
        },
        data(){
            return {
                home_title:'',
                products: this.$store.state.orderModule.products
            }
        },
        methods:{

        },
          created() {
                Fire.$emit('buyer_session_destroy');
                 Fire.$emit("loadPageTitle", "得意先一覧");
                //  this.loading=false;
            },
        mounted() {
            // console.log(this.$store.state.orderModule.products)
        }
    }
</script>
