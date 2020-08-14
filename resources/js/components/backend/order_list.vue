<template>
  <div>
    <div class="row">
                <div class="col-12">
                    <h2 class="top_title text-center">発注データ確認</h2>
                </div>
                <div class="col-12 text-center">
                     <h1>check order_api</h1>
      <label>File
        <input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()"/>
      </label>
        <button v-on:click="submitForm()">Upload</button>
                </div>
                <div class="col-12">
                    <div class="">
                        <table class="table table-striped table-bordered data_table">
                            <thead>
                                <tr>
                                    <th colspan="100%" style="border: none;">
                                        <select class="form-control" name="data_per_page" id="data_per_page" style="margin-left: -10px;max-width: 100px; float: left;">
                                      <option value="5">5</option>
                                      <option value="10">10</option>
                                      <option value="20">20</option>
                                      <option value="50">50</option>
                                      <option value="100">100</option>
                                      <option value="500">500</option>
                                      <option value="1000">1000</option>
                                  </select>

                                        <div class="input-group mb-1" style="margin-left: 10px;max-width: 250px; float: left;">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-primary" type="button">小売選択</button>
                                            </div>
                                            <select class="form-control" name="">
                                              <option value="">スパお洗濯</option>
                                              <option value="1">スーパーAAA</option>
                                              <option value="1">スーパーBBB</option>
                                              <option value="1">スーパーCCC</option>
                                              <option value="1">スーパーDDD</option>
                                            </select>
                                        </div>
                                        <div class="active-pink-3 active-pink-4 mb-1" style="margin-left: 10px;max-width: 100%; float: left;">
                                            <input class="form-control" type="text" placeholder="Search" aria-label="Search">
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
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr v-for="(order_list,index) in order_lists" :key="order_list.byr_order_id">
                                    <td>{{index+1}}</td>
                                    <td>{{order_list.receive_date}}</td>
                                    <td>{{order_list.expected_delivery_date}}</td>
                                    <td>{{order_list.category}}</td>
                                    <td>{{order_list.status}}</td>
                                    <td><button class="btn btn-primary">ピッキング表</button></td>
                                    <!-- <td><a href="confirm_quantity.html" class="btn btn-info">数量確定</a></td> -->
                                    <td>
                                        <router-link :to="{name:'order_list_detail',params:{byr_order_id:order_list.byr_order_id} }" class="btn btn-info">数量確定</router-link>
                                    </td>
                                    <td>
                                    <router-link :to="{name:'order_details_canvas',params:{byr_order_id:order_list.byr_order_id} }" class="btn btn-success">伝票データ</router-link>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
                        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                        <input type="hidden" name="_token" id="token" value="">
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
        'file':'',
    };
  },
  methods: {
    //get Table data
    get_all_order(){
        axios.get("api/byrorders ").then((data) => {
            console.log(data.data.order_list);
            this.order_lists = data.data.order_list;
        });
    },
    check_byr_order_api(){
       let formData = new FormData();
    formData.append("up_file", this.file);
    formData.append("email", 'user@jacos.co.jp');
    formData.append("password", 'Qe75ymSr');
        axios({
    method: 'POST',
    url: this.BASE_URL + "api/scenario_exec/1",
    data: formData,
    headers: {'Content-Type': 'multipart/form-data' }
    })
    .then(function (response) {
        //handle success
        console.log(response);
    })
    .catch(function (response) {
        //handle error
        console.log(response);
    });
    },
    onChangeFileUpload(){
        this.file = this.$refs.file.files[0];
        this.check_byr_order_api();
      }
  },

  created() {
      this.get_all_order();
      console.log('created log');
  },
  mounted() {
    console.log("User page loaded");
  }
};
</script>