<template>
<div>

<!--bloog section-->
<blog_view></blog_view>
<!--bloog section-->

</div>

</template>

<script>
import blog_view from './blog_view'
    export default {
        components : {
    'blog_view': blog_view
  },
        data(){
            return {
                home_text:Globals.welcome_text,
                BASE_URL:Globals.base_url,
                activeVal: 'home',
                blog_lists:{},
                single_blog:{},
            }
        },
        methods:{
            get_all_blogs(){
                axios.get(this.BASE_URL +"api/get_all_published_blog_list").then(({data}) => {
                    this.init(data.status);
                    this.blog_lists = data.blog_list;
                });
            },
            get_signle_top_blog(){
                axios.get(this.BASE_URL +"api/get_signle_top_blog").then(({data}) => {
                    this.single_blog = data.blog_list;
                    console.log(this.single_blog.length);
                });
            },
        },
          created() {
      this.get_all_blogs();
      this.get_signle_top_blog();
      Fire.$on("AfterCreateblog", () => {
        this.get_all_blogs();
    });
      console.log('created jacos management log');
  },
        mounted() {
            this.init();
            console.log('Home Component mounted.')
        }
    }
</script>
