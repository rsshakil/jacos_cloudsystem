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
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">Content <span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">ステータス <span id="status_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">Action <span id="btn1_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr v-for="(value,index) in blog_lists" :key="value.cmn_blog_id">
                                    <td>{{index+1}}</td>
                                    <td>{{value.blog_title}}</td>
                                    <td>{{value.feature_img}}</td>
                                    <td>{{value.blog_content}}</td>
                                    <td>{{value.blog_status}}</td>
                                    <td><button class="btn btn-danger">Delete</button> <button class="btn btn-success">Make top</button>  <button class="btn btn-info">Edit</button></td>
                                    
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
    <img class="profile-user-img img-fluid img-circle" :src="getPhoto()" alt="Blog Images">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Content</label>
    <div class="col-sm-10">
     <ckeditor :editor="editor" v-model="form.blog_content" :config="editorConfig"></ckeditor>
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
export default {
  
  data() {
    return {
        'blog_lists':{},
        'blog_create_modal':false,
        editor: ClassicEditor,
        
        editorConfig: {
            // The configuration of the editor.
            language: 'ja'
        },
        form: new Form({
                    blog_title : '',
                    feature_img: '',
                    blog_content: '<p>Write your new here.</p>',
                    cmn_blog_id: '',
                    blog_by:Globals.user_info_id
                    
                })
    };
  },
  methods: {
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
               let photo = (this.form.feature_img.length > 100) ? this.form.feature_img : "blog_images/"+ this.form.feature_img;
                return photo;
            },
       get_all_blogs(){
        axios.get(this.BASE_URL +"api/company_user_list/"+this.cmn_company_id).then((data) => {
            this.blog_lists = data.data.user_list;
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