<template>
<div>
<!--bloog section-->
        <div class="row">
            <div class="col-12">
           
                <b-container class="bv-example-row">
                <b-row v-if="single_blog.length!='0'">
    <b-col>
    <div class="text-center">
    <h2>{{myLang.notice_text}}</h2>

    </div>
     </b-col>
     
  </b-row>
  <br>
  <br>
  <b-row>
    <b-col v-if="single_blog.length!='0'">                    

  <h4 class="my-3 blog_titles">{{single_blog.blog_title}}</h4>
  <p class="created_at">Created at @{{ single_blog.created_at | ja_date_time }}</p>
  <b-img :src="BASE_URL+'storage/app/public/backend/images/blog_images/'+single_blog.feature_img" fluid-grow alt="Fluid-grow image"></b-img>
    <div class="blogs_content" v-html="single_blog.blog_content">
    </div>
    </b-col>
  </b-row>
  <br>
  <br>
  <br>
                <b-row>
    <b-col>
    <div class="text-center">
    <h2>{{myLang.previous_notice}}</h2>
    </div>
     </b-col>
     
  </b-row>
  <b-row>
    <b-col cols="6" v-for="(value) in blog_lists" :key="value.cmn_blog_id">                    

  <h4 class="my-3 blog_titles">{{value.blog_title}}</h4>
  <p class="created_at">Created at @ {{ value.created_at | diffForHumans }}</p>
  <b-img :src="BASE_URL+'storage/app/public/backend/images/blog_images/'+value.feature_img" fluid-grow alt="Fluid-grow image"></b-img>
  <div class="blogs_content" v-html="value.blog_content"></div>
  </b-col>
   
  </b-row>
  <br>
  <br>
</b-container>


                </div>
        </div>
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
            }
        },
        methods:{
            get_all_blogs(){
                axios.get(this.BASE_URL +"api/get_all_published_blog_list").then((data) => {
                    this.blog_lists = data.data.blog_list;
                });
            },
            get_signle_top_blog(){
                axios.get(this.BASE_URL +"api/get_signle_top_blog").then((data) => {
                    this.single_blog = data.data.blog_list;
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