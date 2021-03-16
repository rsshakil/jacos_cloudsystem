<template>
<div>
<!--bloog section-->
        

<!--user blog-->
  <!--<b-row v-can="['slr_view']">
    <b-col v-if="user_blog.length!='0'">
  <h4 class="my-3 blog_titles"><i class="fas custom_blog_square fa-square-full"></i> {{user_blog.blog_title}}</h4>
    <div class="blogs_content" v-html="user_blog.blog_content">
    </div>
    </b-col>
  </b-row>-->
  <!--user blog end-->
   <!--admin blog-->
  <b-row>
    <b-col v-if="single_blog.length!='0'">

  <h4 class="my-3 blog_titles"><i class="fas custom_blog_square fa-square-full"></i>  ジャコス連絡事項</h4><!--{{single_blog.blog_title}}-->
  <!--<p class="created_at">Created at @{{ single_blog.created_at | ja_date_time }}</p>-->
  <!--<b-img v-if="single_blog.feature_img!='null'" :src="BASE_URL+'storage/app/public/backend/images/blog_images/'+single_blog.feature_img" fluid-grow alt="Fluid-grow image"></b-img>-->
    <div class="blogs_content" v-html="single_blog.blog_content">
    </div>
    </b-col>
  </b-row>
      <!--admin blog end-->
  <!--
  <b-row>
    <b-col cols="12" v-for="(value) in blog_lists" :key="value.cmn_blog_id">

  <h5 class="my-3 blog_titles"><i class="fas custom_blog_square fa-square-full"></i> {{value.blog_title}}</h5>
  <p class="created_at">Created at @ {{ value.created_at | diffForHumans }}</p>-->
  <!--<b-img v-if="value.feature_img!=null" :src="BASE_URL+'storage/app/public/backend/images/blog_images/'+value.feature_img" fluid-grow alt="Fluid-grow image"></b-img>
  <div class="blogs_content" v-html="value.blog_content"></div>
  </b-col>

  </b-row>
-->

</div>

</template>

<script>
    export default {

        data(){
            return {
                home_text:Globals.welcome_text,
                BASE_URL:Globals.base_url,
                activeVal: 'home',
                blog_lists:{},
                single_blog:{},
                user_blog:{},
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
                    this.init(data.status);
                    this.single_blog = data.blog_list;
                });
            },
            get_user_top_blog(){
                axios.get(this.BASE_URL +"api/get_user_top_blog").then(({data}) => {
                    this.init(data.status);
                    this.user_blog = data.blog_list;
                });
            },

        },
          created() {
      this.get_all_blogs();
      this.get_signle_top_blog();
      this.get_user_top_blog();
      Fire.$on("AfterCreateblog", () => {
        this.get_all_blogs();
    });
  },
        mounted() {
            this.init();
        }
    }
</script>
