<template>
  <div>
    <div class="row">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">シナリオ管理</h4>
                </div>
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
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">シナリオ名<span id="orderdate_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">小売名 <span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">問屋名 <span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">シナリオ説明 <span id="status_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">シナリオファイルパス <span id="btn1_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">詳細 <span id="btn2_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                            
                                <tr v-for="(value,index) in scenario_lists" :key="value.id">
                                    <td>{{index+1}}</td>   
                                    <td>{{value.name}}</td>
                                    <td>{{value.super_code}}</td>
                                    <td></td>
                                    <td>{{value.description}}</td>
                                    <td>{{value.file_path}}</td>
                                    <td><button class="btn btn-info">詳細</button></td>
                                </tr>
                                
                            </tbody>
                        </table>
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
        'scenario_lists':{},
        'byr_buyer_id':'',
    };
  },
  methods: {
      get_all_scenarios(){
        axios.get(this.BASE_URL +"api/get_scenario_list").then((data) => {
            this.scenario_lists = data.data.scenario_list;
            console.log(this.scenario_lists);
        });
    },
  },

  created() {
      this.get_all_scenarios();
      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>