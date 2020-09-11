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
                    <h4 class="top_title text-center" style="margin-top:10px;">株式会社サノテック</h4>
                    <p class="text-center">問屋コード:00001 取引先コード:00001</p>
                </div>

                <div class="col-12">
                                       <button class="btn pull-right text-right btn-primary" style="float:right">新規追加</button>
                    <div class="">
                       <table class="table table-striped table-bordered data_table">
                            <thead>
                                <tr>
                                    <th colspan="100%" style="border: none;width:150px;">
                                    <select name="job_status" class="form-control">
                                      <option value="稼働中" selected>稼働中</option>
                                      <option value="稼働">稼働</option>
                                    </select>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No <span id="id_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">Job ID<span id="orderdate_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">種別 <span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">経路 <span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">シナリオ <span id="status_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">スケジュール設定 <span id="btn1_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr v-for="(value,index) in slr_job_lists" :key="value.cmn_job_id">
                                    <td>{{index+1}}</td>
                                    <td>{{value.cmn_job_id}}</td>
                                    <td>{{value.class}}</td>
                                    <td>{{value.vector}}</td>
                                    <td>{{value.name}}</td>
                                    <td><select name="user_status" class="form-control">
                                      <option value="稼働中" selected>稼働中</option>
                                      <option value="稼働">稼働</option>
                                    </select></td>
                                    <td><button @click="job_exe_modal_show(value)" class="btn btn-info">スケジュール設定</button></td>
                                    
                                </tr>
                                
                            </tbody>
                        </table>
                        <button class="btn btn-primary" style="float:right">変更を保存</button>
                    </div>
                </div>
            </div>
            <b-modal
      size="md"
      :hide-backdrop="true"
      title="フォルダ監視"
      ok-title="保存"
      cancel-title="キャンセル"
      @ok.prevent="save_edit_job()"
      v-model="job_exe_modal"
    >
      <!-- <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
      <div class="modal-body">-->
      <div class="panel-body add_item_body">
        <table class="table table-striped table-bordered data_table">
                            <thead>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">Job ID<span id="orderdate_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">種別 <span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">経路 <span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">シナリオ <span id="status_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>test</td>
                                    <td>発注</td>
                                    <td>小売 → Jacos</td>
                                    <td>OUK_BMS_ORDER</td>
                                </tr>
                                
                            </tbody>
                        </table>
            <form>

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
        'slr_job_lists':{},
        'slr_seller_id':'',
        'job_exe_modal':false,
    };
  },
  methods: {
       get_all_slr_job_lists(){
        axios.get(this.BASE_URL +"api/slr_job_list_by_seller_id/"+this.slr_seller_id).then((data) => {
            this.slr_job_lists = data.data.slr_job_list;
            console.log(this.slr_job_lists);
        });
    },
    save_edit_job(){
      console.log('save job');
    },
    job_exe_modal_show(value){
      this.job_exe_modal = true;
    },
  },

  created() {
    this.slr_seller_id = this.$route.params.slr_seller_id;
      this.get_all_slr_job_lists();

      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>