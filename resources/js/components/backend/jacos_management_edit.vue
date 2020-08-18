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

                <div class="col-7">
                    <div class="">
                      <form>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">小売名</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="staticEmail" value="スーパーバリュー">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Jコード</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputPassword" value="000001">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">スーパーコード</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputPassword" value="JHG">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">郵便番号</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputPassword" value="141-0021">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">住所</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputPassword" value="東京都品川区上大崎1-2-3">
    </div>
  </div>
</form>
                    </div>
                </div>
                <div class="col-5"></div>
                <div class="col-12">
                    <button class="btn btn-danger" @click="delete_company">削除</button>
                    <button class="btn btn-info" @click="delete_company">キャンセル</button>
                    <button class="btn btn-primary" @click="delete_company">変更を保存</button>
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
        'company_lists':{},
    };
  },
  methods: {
      delete_company(){
          console.log('delected');
      },
       get_all_company(){
        axios.get(this.BASE_URL +"api/jacosmanagement").then((data) => {
            this.company_lists = data.data.company_list;
            console.log(this.company_lists);
        });
    },
  },

  created() {
      this.get_all_company();
      console.log('created jacos management log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>