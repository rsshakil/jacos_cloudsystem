<template>
  <div>
    <div class="row">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">{{myLang.super_value_head}}</h4>
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
                                       <button class="btn pull-right text-right btn-primary" style="float:right">{{myLang.add_new}}</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="cursor: pointer">No</th>
                                    <th style="cursor: pointer">{{myLang.wholesaler_name}}</th>
                                    <th style="cursor: pointer">{{myLang.wholesaler_code}}</th>
                                    <th style="cursor: pointer">{{myLang.customer_code}}</th>
                                    <th style="cursor: pointer">{{myLang.status}}</th>
                                    <th style="cursor: pointer">{{myLang.details}}</th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr v-for="(value,index) in company_partner_lists" :key="value.slr_seller_id">
                                    <td>{{index+1}}</td>   
                                    <td>{{value.company_name}}</td>
                                    <td>{{value.jcode}}</td>
                                    <td>{{value.partner_code}}</td>
                                    <td><select name="user_status" v-model="value.is_active" class="form-control">
                                      <option :value="1">{{myLang.status_in_operation}}</option>
                                      <option :value="0">{{myLang.status_operation}}</option>
                                    </select></td>
                                    <td><router-link :to="{name:'slr_job_list',params:{slr_seller_id:value.slr_seller_id} }" class="btn btn-info">{{myLang.details}}</router-link></td>
                                    
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