<template>
  <div>
    <div class="row">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">Blog list</h4>
                </div>
                
             

                <div class="col-12">
                    <div class="">
                       <table class="table table-striped table-bordered data_table">
                            <thead>
                                <tr>
                                    <th colspan="100%" style="border: none;">
                                       <button @click="new_blog_create_modal" class="btn pull-right text-right btn-primary" style="float:right">新規追加</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No <span id="id_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">Title<span id="orderdate_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">feature Image<span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">Update date<span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">Action <span id="btn1_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr v-for="(value,index) in blog_lists" :key="value.cmn_blog_id">
                                    <td>{{index+1}}</td>
                                    <td>{{value.blog_title}}</td>
                                    <td><img :src="BASE_URL+'storage/app/public/backend/images/blog_images/'+value.feature_img" alt="No image" class="img-responsive img-thumbnail" width="150" height="100" style="border: 1px solid gray;"></td>
                                    <td>{{value.updated_at | ja_date_time}}</td>
                                    <td><b-icon v-if="value.blog_status=='published'" v-tooltip.html="'disable this blog user'" font-scale="2" style="cursor:pointer" icon="eye-fill" variant="success" class="custom_blog_font" @click="blog_update_info(value,0)"></b-icon>
                                    <b-icon v-if="value.blog_status=='unpublished'" v-tooltip.html="'enable this blog for user'" font-scale="2" style="cursor:pointer" icon="eye-slash-fill" variant="danger" class="custom_blog_font" @click="blog_update_info(value,1)"></b-icon>
                                    
                                    <b-icon icon="arrow-bar-up" v-tooltip.html="'Make it top Blog'" font-scale="2" style="cursor:pointer" variant="primary" class="custom_blog_font" @click="blog_update_info(value,2)"></b-icon>
                                    <b-icon icon="trash-fill" v-tooltip.html="'Update this top Blog'" font-scale="2" style="cursor:pointer" class="custom_blog_font" @click="blog_update_info(value,3)" variant="danger"></b-icon>
                                    <b-icon icon="file-earmark-code" v-tooltip.html="'Delete this top Blog'" font-scale="2" style="cursor:pointer" variant="success" class="custom_blog_font" @click="blog_update_info(value,4)"></b-icon>
                                    </td>
                                    
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

          <b-modal
      size="lg"
      :hide-backdrop="true"
      title="Blog"
      ok-title="Save"
      cancel-title="キャンセル"
      @ok.prevent="create_new_blog()"
      v-model="blog_create_modal">
      <!-- <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
      <div class="modal-body">-->
      <div class="panel-body add_item_body">
        <form enctype="multipart/form-data">
        <input type="hidden" v-model="form.cmn_blog_id">
          <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label">Title</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('blog_title') }" v-model="form.blog_title">
      <has-error :form="form" field="blog_title"></has-error>
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Feature Image</label>
    <div class="col-sm-10">
      <input type="file" name="feature_img" class="form-control" :class="{ 'is-invalid': form.errors.has('feature_img') }" @change="onUploadFiles" accept="image/jpeg, image/png">
    <has-error :form="form" field="feature_img"></has-error>
    <img v-if="form.feature_img.length>0" class="profile-user-img img-fluid img-circle" :src="getPhoto()" alt="Blog Images">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Content</label>
    <div class="col-sm-10">
     <ckeditor :editor="editor" v-model="form.blog_content" :config="editorConfig" :class="{ 'is-invalid': form.errors.has('blog_content') }"></ckeditor>
    <has-error :form="form" field="blog_content"></has-error>
    </div>
  </div>
        </form>
      </div>
      <!-- </div>
        </div>
      </div>-->
    </b-modal>


  </div>
</template>
<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
// import ClassicEditor from '@ckeditor/ckeditor5-editor-classic';
import '@ckeditor/ckeditor5-build-classic/build/translations/ja';
import UploadAdapter from '../../../UploadAdapter';
// import MediaEmbed from '@ckeditor/ckeditor5-media-embed/src/mediaembed';
export default {
  
  data() {
    return {
        'blog_lists':{},
        'blog_create_modal':false,
        editor: ClassicEditor,
        
        editorConfig: {
            // The configuration of the editor.
            language: 'ja',
            extraPlugins: [ this.uploader ],
            
        },
        form: new Form({
                    blog_title : '',
                    feature_img: '',
                    blog_content: '',
                    cmn_blog_id: '',
                    blog_by:Globals.user_info_id
                    
                })
    };
  },
  methods: {
    uploader(editor)
            {
                editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                    return new UploadAdapter( loader,Globals.base_url + "api/ckeditor_file_up" );
                };
            },
    blog_update_info(blog,action_type){
      if(action_type==4){
        this.blog_create_modal = true;
        this.form.fill(blog);
      }else if(action_type==3){
      this.delete_sweet().then((value)=>{
        console.log(value);
        if(value.isConfirmed){
          this.blog_update(blog,action_type);
        }
      })
      
      }else{
        this.blog_update(blog,action_type);
      }
    },
    blog_update(blog,action_type){
      var post_data = {
                blog: blog,
                action_type: action_type,
            };
            axios.post(
                    this.BASE_URL + "api/update_blog_infos",
                    post_data
                )
                .then(data => {
                    Fire.$emit('AfterCreateblog');
                    if(action_type==0){
                      var alert_icon='warning';
                      var alert_title= 'blog unpublished';
                      var alert_text= 'You have successfully unpublished the blog';
                    }else if(action_type==1){
                      var alert_icon='success';
                      var alert_title= 'blog published';
                      var alert_text= 'You have successfully published the blog';
                    }else if(action_type==2){
                      var alert_icon='success';
                      var alert_title= 'Top Blog';
                      var alert_text= 'You have successfully toped the blog';
                    }else{
                      var alert_icon='success';
                      var alert_title= 'Blog Delete';
                      var alert_text= 'You have successfully delete the blog';
                    }
                    Swal.fire({
                icon: alert_icon,
                title: alert_title,
                text: alert_text
            });
                });
    },
    onUploadFiles(e){
      let file = e.target.files[0];
                let reader = new FileReader();  

                if(file['size'] < 2111775)
                {
                    reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                     this.form.feature_img = reader.result;
                    }              
                     reader.readAsDataURL(file);
                }else{
                    alert('File size can not be bigger than 2 MB')
                }
    },
    getPhoto(){
               let photo = (this.form.feature_img.length > 100) ? this.form.feature_img : this.BASE_URL+'storage/app/public/backend/images/blog_images/'+ this.form.feature_img;
                return photo;
            },
       get_all_blogs(){
        axios.get(this.BASE_URL +"api/get_all_blog_list").then((data) => {
            this.blog_lists = data.data.blog_list;
            console.log(this.blog_lists);
        });
    },
    new_blog_create_modal(){
      this.form.reset();
      this.form.cmn_blog_id ='';
      this.blog_create_modal = true;
      

    },
    create_new_blog(){
      this.form.post(this.BASE_URL +'api/blog_create')
                .then((data)=>{
                  this.blog_create_modal = false;
                    Fire.$emit('AfterCreateblog');
                    Swal.fire({
            icon: 'success',
            title: 'blog added success',
            text: 'You have successfully added blog'
        });
                    console.log(data);
                })
                .catch((error)=>{
                  console.log(error);
                  Swal.fire({
            icon: 'warning',
            title: 'Invalid blog info',
            text: 'please check blog content!'
        });
                })
    },
  },

  created() {
      this.get_all_blogs();
      Fire.$on("AfterCreateblog", () => {
        this.get_all_blogs();
    });
      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>