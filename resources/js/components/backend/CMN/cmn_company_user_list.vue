<template>
  <div>
    <div class="row">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">スーパーバリュー</h4>
                </div>
                
                <div class="col-3"></div>
                <div class="col-6">
                    <tabList></tabList>
                </div>
                <div class="col-3"></div>


                <div class="col-12">
                    <div class="">
                       <table class="table table-striped table-bordered data_table">
                            <thead>
                                <tr>
                                    <th colspan="100%" style="border: none;">
                                       <button @click="new_user_create_modal" class="btn pull-right text-right btn-primary" style="float:right">新規追加</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No <span id="id_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">区分<span id="orderdate_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">名前 <span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">メールアドレス <span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">ステータス <span id="status_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">詳細 <span id="btn1_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr v-for="(value,index) in company_user_lists" :key="value.id">
                                    <td>{{index+1}}</td>
                                    <td>一般</td>
                                    <td>{{value.name}}</td>
                                    <td>{{value.email}}</td>
                                    <td><select name="user_status" class="form-control">
                                      <option value="稼働中" selected>稼働中</option>
                                      <option value="稼働">稼働</option>
                                    </select></td>
                                    <td><button class="btn btn-info">詳細</button></td>
                                    
                                </tr>
                                
                            </tbody>
                        </table>
                        <button class="btn btn-danger" style="float:right">変更を保存</button>
                        <button class="btn btn-primary" style="float:right">変更を保存</button>
                    </div>
                </div>
            </div>

          <b-modal
      size="lg"
      :hide-backdrop="true"
      title="Add user"
      ok-title="Save"
      cancel-title="キャンセル"
      @ok.prevent="create_new_user()"
      v-model="user_create_modal"
    >
      <!-- <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
      <div class="modal-body">-->
      <div class="panel-body add_item_body">
        <form>
          <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" v-model="form.name">
      <has-error :form="form" field="name"></has-error>
    </div>
  </div>
   <!--<div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label">Super code</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('super_code') }" v-model="form.super_code">
      <has-error :form="form" field="super_code"></has-error>
    </div>
  </div>-->
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" v-model="form.email">
      <has-error :form="form" field="email"></has-error>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password" v-model="form.password">
      <has-error :form="form" field="password"></has-error>
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
import tabList from '../tabList'
export default {
  name:'app',
components:{
tabList,
},
  data() {
    return {
        'company_user_lists':{},
        'cmn_company_id':'',
        'user_create_modal':false,
        form: new Form({
                    name : '',
                    email: '',
                    password: '',
                    cmn_company_id: '',
                })
    };
  },
  methods: {
       get_all_company_users(){
        axios.get(this.BASE_URL +"api/company_user_list/"+this.cmn_company_id).then((data) => {
            this.company_user_lists = data.data.user_list;
            console.log(this.company_user_lists);
        });
    },
    new_user_create_modal(){
      this.form.reset();
      this.form.cmn_company_id = this.$route.params.cmn_company_id;
      this.user_create_modal = true;
      

    },
    create_new_user(){
      this.form.post(this.BASE_URL +'api/byr_buyer_user_create')
                .then((data)=>{
                  this.user_create_modal = false;
                    Fire.$emit('AfterCreateUser');
                    Swal.fire({
            icon: 'success',
            title: 'User added success',
            text: 'You have successfully added user'
        });
                    console.log(data);
                })
                .catch((error)=>{
                  console.log(error);
                  Swal.fire({
            icon: 'warning',
            title: 'Invalid user info',
            text: 'duplicated email found!'
        });
                })
    },
  },

  created() {
    this.cmn_company_id = this.$route.params.cmn_company_id;
    this.form.cmn_company_id = this.$route.params.cmn_company_id;

      this.get_all_company_users();
      Fire.$on("AfterCreateUser", () => {
        this.get_all_company_users();
    });
      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>