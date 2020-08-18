<template>
  <div>
    <div class="row">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">小売管理</h4>
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
                                    <button class="btn custom_right btn-primary">新規追加</button>

    </div>
    </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">小売名</th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">スーパーコード </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">ステータス </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">ユーザー管理 </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">店舗管理 </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer"> 取引先管理 </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer"> 発注データ </th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer"> 詳細</th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>test</td>
                                    <td>OUK</td>
                                    <td>Yes</td>
                                    <td><router-link to="" class="btn btn-primary">ユーザー管理</router-link></td>
                                    <td><button class="btn btn-info">店舗管理</button></td>
                                    <td><button class="btn btn-danger">取引先管理</button></td>
                                    <td><button class="btn btn-success">発注データ</button></td>
                                    <td><button class="btn btn-primary">詳細</button></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>test</td>
                                    <td>OUK</td>
                                    <td>Yes</td>
                                    <td><button class="btn btn-primary">test</button></td>
                                    <td><button class="btn btn-info">test</button></td>
                                    <td><button class="btn btn-danger">test</button></td>
                                    <td><button class="btn btn-success">test</button></td>
                                    <td><button class="btn btn-primary">test</button></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>test</td>
                                    <td>OUK</td>
                                    <td>Yes</td>
                                    <td><button class="btn btn-primary">test</button></td>
                                    <td><button class="btn btn-info">test</button></td>
                                    <td><button class="btn btn-danger">test</button></td>
                                    <td><button class="btn btn-success">test</button></td>
                                    <td><button class="btn btn-primary">test</button></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
        'order_lists':{},
        'byr_buyer_lists':{},
        'file':'',
    };
  },
  methods: {
   
  },

  created() {
      console.log('created log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>