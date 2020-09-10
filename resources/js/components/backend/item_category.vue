<template>
  <div v-can="['slr_view']">
    <div class="row">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">問屋管理</h4>
                </div>
                
                <div class="col-12">
                    <div class="">
                        <table class="table table-striped table-bordered data_table">
                            <thead>
                                <tr>
                                    <th colspan="100%" style="border: none;">
                                        <div class="row">
                                        <div class="col-6">
                                        <form class="form-inline">
                                            <!--<input class="form-control" type="text" placeholder="Search" aria-label="Search">
                                            <button class="btn btn-primary">検索</button>-->

                                            </form>
                                       </div>
                                       <div class="col-6">
                                    <button @click="add_new_category_cmn" class="btn custom_right btn-primary"> 新規ユーザ追加 </button>

    </div>
    </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">名前</th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">前コード </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer"> 詳細</th>
                                </tr>
                                
                            </thead>
                            <tbody>
                               <tr v-for="(cat_list,index) in cat_lists" :key="cat_list.cmn_category_id">
                                    <td>{{index+1}}</td>
                                    <td>{{cat_list.name}}</td>
                                    <td>{{cat_list.category_code}}</td>
                                    <td><button @click="edit_category_data(cat_list)" class="btn btn-primary">詳細</button><button @click="delete_category_data(cat_list)" class="btn btn-danger">取引先管理</button></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <b-modal
      size="md"
      :hide-backdrop="true"
      title="Category"
      ok-title="新規追加"
      cancel-title="キャンセル"
      @ok.prevent="save_new_cat()"
      v-model="add_cmn_cat_modal"
    >
      <!-- <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
      <div class="modal-body">-->
      <div class="panel-body add_item_body" v-can="['company_create']">
            <form>
            <input type="hidden" v-model="form.cmn_category_id">
  <!--<div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">category 名</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" v-model="form.name">
      <has-error :form="form" field="name"></has-error>
    </div>
  </div>-->
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Category コード</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" maxlength="2" :class="{ 'is-invalid': form.errors.has('category_code') }" v-model="form.category_code">
      <has-error :form="form" field="category_code"></has-error>

    </div>
  </div>
  
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Select Parent</label>
    <div class="col-sm-8">
      <select class="form-control" :class="{ 'is-invalid': form.errors.has('parent_id') }" v-model="form.parent_id">
          <option v-bind:value="0">Select a Category</option>
          <option v-for="option in options" v-bind:value="option.cmn_category_id">
    {{ option.name }}
  </option>
      </select>
      <has-error :form="form" field="parent_id"></has-error>

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
export default {
  data() {
    return {
        'cat_lists':{},
        'add_cmn_cat_modal':false,
        options:[],
        form: new Form({
          cmn_category_id:'',
                    name : '',
                    category_code: '',
                    parent_id: '',
                    adm_user_id:Globals.user_info_id,
                })
    };
  },
  methods: {
      add_new_category_cmn(){
        this.form.reset();
          this.add_cmn_cat_modal=true;
          this.form.parent_id = 0;
      },
      edit_category_data(form_data){
        this.add_cmn_cat_modal=true;

                this.form.reset();
                var cat_code = form_data.category_code;
                if(cat_code.substring(4,6)!='00'){
                  form_data.category_code = cat_code.substring(4,6);
                }else if(cat_code.substring(2,4)!='00'){
                  form_data.category_code = cat_code.substring(2,4);
                }else{
                  form_data.category_code = cat_code.substring(0,2);
                }
                this.form.fill(form_data);
                this.form.parent_id = form_data.parent_id;
      },
      save_new_cat(){
          console.log('add new');
          this.form.adm_user_id = Globals.user_info_id;
          this.form.post(this.BASE_URL +'api/cmn_category_create')
                .then((data)=>{

                    if(data.data.message=='fail'){
                      var tittles = 'Invalid Category';
                      var msg_text = 'please check parent';
                       var icon = 'warning';
                    }else{
                    this.add_cmn_cat_modal = false;
                    Fire.$emit('AfterCreatecat');
                    if(this.form.cmn_category_id!=''){
                      var tittles = 'Category Update success';
                      var msg_text = 'You have successfully updated category';
                       var icon = 'success';
                    }else{
                      var tittles = 'Category added success';
                      var msg_text = 'You have successfully added category';
                      var icon = 'success';
                    }
                    }
                    Swal.fire({
                        icon: icon,
                        title: tittles,
                        text: msg_text
                    });
                    console.log(data);
                })
                .catch((error)=>{
                  console.log(error);
                  Swal.fire({
                      icon: 'warning',
                      title: 'Invalid category info',
                      text: 'check category info!'
                  });
                })
      },
       get_all_cat(){
        axios.get(this.BASE_URL +"api/get_all_cat_list/"+Globals.user_info_id).then((data) => {
            this.cat_lists = data.data.cat_list;
            console.log( this.cat_lists);
            this.options = data.data.cat_list;
        });
    },
  },

  created() {
      this.get_all_cat();
      Fire.$on("AfterCreatecat", () => {
        this.get_all_cat();
    });
      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>