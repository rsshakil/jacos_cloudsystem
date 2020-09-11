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
                                            <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                                            <button class="btn btn-primary">検索</button>

                                            </form>
                                       </div>
                                       <div class="col-6">
                                    <button @click="add_new_company_cmn" class="btn custom_right btn-primary">新規追加</button>

    </div>
    </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">問屋名</th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">問屋コード </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">ステータス </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">ユーザー管理 </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">店舗管理 </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer"> 取引先管理 </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer"> 発注データ </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer"> 詳細</th>
                                </tr>
                                
                            </thead>
                            <tbody>
                               <tr v-for="(slr_list,index) in slr_lists" :key="slr_list.slr_seller_id">
                                    <td>{{index+1}}</td>
                                    <td>{{slr_list.company_name}}</td>
                                    <td>{{slr_list.jcode}}</td>
                                    <td>稼働中</td>
                                    <td><router-link :to="{name:'company_seller_user_list',params:{cmn_company_id:slr_list.cmn_company_id} }" class="btn btn-primary">ユーザー管理</router-link></td>
                                    <td><button class="btn btn-info">店舗管理</button></td>
                                    <td><button class="btn btn-danger">取引先管理</button></td>
                                    <td><button class="btn btn-success">発注データ</button></td>
                                    <td><button @click="edit_slr_data(slr_list)" class="btn btn-primary">詳細</button></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <b-modal
      size="md"
      :hide-backdrop="true"
      title="問屋　新規作成"
      ok-title="新規追加"
      cancel-title="キャンセル"
      @ok.prevent="save_new_slr()"
      v-model="add_cmn_company_modal"
    >
      <!-- <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
      <div class="modal-body">-->
      <div class="panel-body add_item_body" v-can="['company_create']">
            <form>
            <input type="hidden" v-model="form.cmn_company_id">
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">問屋名</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('company_name') }" v-model="form.company_name">
      <has-error :form="form" field="company_name"></has-error>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Jコード</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('jcode') }" v-model="form.jcode">
      <has-error :form="form" field="jcode"></has-error>

    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">郵便番号</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('postal_code') }" v-model="form.postal_code">
      <has-error :form="form" field="postal_code"></has-error>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">住所</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('address') }" v-model="form.address">
      <has-error :form="form" field="address"></has-error>

    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">電話番号</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }" v-model="form.phone">
      <has-error :form="form" field="phone"></has-error>

    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">FAX番号</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('fax') }" v-model="form.fax">
      <has-error :form="form" field="fax"></has-error>

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
        'slr_lists':{},
        'add_cmn_company_modal':false,
        form: new Form({
          cmn_company_id:'',
                    company_name : '',
                    jcode: '',
                    postal_code: '',
                    address: '',
                    phone: '',
                    fax: '',
                })
    };
  },
  methods: {
      add_new_company_cmn(){
        this.form.reset();
          this.add_cmn_company_modal=true;
      },
      edit_slr_data(form_data){
        this.add_cmn_company_modal=true;

                this.form.reset();
                this.form.fill(form_data);
      },
      save_new_slr(){
          console.log('add new');
          this.form.post(this.BASE_URL +'api/slr_company_create')
                .then((data)=>{
                  this.add_cmn_company_modal = false;
                    Fire.$emit('AfterCreatesellerCompany');
                    if(this.form.cmn_company_id!=''){
                      var tittles = 'Company Update success';
                      var msg_text = 'You have successfully updated company';
                    }else{
                      var tittles = 'Company added success';
                      var msg_text = 'You have successfully added company';
                    }
                    Swal.fire({
                        icon: 'success',
                        title: tittles,
                        text: msg_text
                    });
                    console.log(data);
                })
                .catch((error)=>{
                  console.log(error);
                  Swal.fire({
                      icon: 'warning',
                      title: 'Invalid company info',
                      text: 'check company info!'
                  });
                })
      },
       get_all_slr(){
        axios.get(this.BASE_URL +"api/slr_management/"+Globals.user_info_id).then((data) => {
            this.slr_lists = data.data.slr_list;
            console.log(this.slr_lists);
        });
    },
  },

  created() {
      this.get_all_slr();
      Fire.$on("AfterCreatesellerCompany", () => {
        this.get_all_slr();
    });
      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>