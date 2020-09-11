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
                                       <button class="btn pull-right text-right btn-primary" style="float:right">新規作成</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No <span id="id_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">問屋名<span id="orderdate_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">問屋コード <span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">取引先コード <span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">ステータス <span id="status_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">詳細 <span id="btn1_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr v-for="(value,index) in company_partner_lists" :key="value.slr_seller_id">
                                    <td>{{index+1}}</td>   
                                    <td>{{value.company_name}}</td>
                                    <td>{{value.jcode}}</td>
                                    <td>{{value.partner_code}}</td>
                                    <td><select name="user_status" v-model="value.is_active" class="form-control">
                                      <option :value="1">稼働中</option>
                                      <option :value="0">稼働</option>
                                    </select></td>
                                    <td><router-link :to="{name:'slr_job_list',params:{slr_seller_id:value.slr_seller_id} }" class="btn btn-info">詳細</router-link></td>
                                    
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
        'company_partner_lists':{},
        'cmn_company_id':'',
    };
  },
  methods: {
      get_all_partner_users(){
        axios.get(this.BASE_URL +"api/company_partner_list/"+this.cmn_company_id).then((data) => {
            this.company_partner_lists = data.data.partner_list;
            console.log(this.company_partner_lists);
        });
    },
  },

  created() {
    this.cmn_company_id = this.$route.params.cmn_company_id;
      this.get_all_partner_users();
      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>