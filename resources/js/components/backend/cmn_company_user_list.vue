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
                                       <button class="btn pull-right text-right btn-primary" style="float:right">新規追加</button>
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
  </div>
</template>
<script>
import tabList from './tabList'
export default {
  name:'app',
components:{
tabList,
},
  data() {
    return {
        'company_user_lists':{},
        'byr_buyer_id':'',
    };
  },
  methods: {
       get_all_company_users(){
        axios.get(this.BASE_URL +"api/company_user_list/"+this.byr_buyer_id).then((data) => {
            this.company_user_lists = data.data.user_list;
            console.log(this.company_user_lists);
        });
    },
  },

  created() {
    this.byr_buyer_id = this.$route.params.byr_buyer_id;
      this.get_all_company_users();

      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>