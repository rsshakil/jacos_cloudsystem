<template>
  <div>
    <div class="row">
                <div class="col-12">
                    <h4 class="top_title text-center" style="margin-top:10px;">jacos user mangement</h4>
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
                                            <button class="btn btn-primary">Search</button>

                                            </form>
                                       </div>
                                       <div class="col-6">
                                    <button class="btn custom_right btn-primary">Add</button>

    </div>
    </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">No <span id="id_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">受注日時<span id="orderdate_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">納品日 <span id="delivery_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">オンライン/手書き <span id="ordertype_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">ステータス <span id="status_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer">ピッキング表 <span id="btn1_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer"> 数量確定 <span id="btn2_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer"> 伝票データ <span id="btn3_icon"></span></th>
                                    <th class="sorting" data-sorting_type="asc" data-column_name="email" style="cursor: pointer"> 伝票データ <span id="btn3_icon"></span></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
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