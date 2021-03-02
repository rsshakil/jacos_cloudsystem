<template>
  <div v-can="['byr_view']">
    <div class="row">
      

      <div class="col-12">

<p>
              <span class="tableRowsInfo"
                >{{ cat_lists.from }}〜{{
                  cat_lists.to
                }}
                件表示中／全：{{ cat_lists.total }}件</span
              >
              <span class="pagi">
                <advanced-laravel-vue-paginate
                  :data="cat_lists"
                  :onEachSide="2"
                  previousText="<"
                  nextText=">"
                  alignment="center"
                  @paginateTo="get_all_cat"
                />
              </span>
              <span class="selectPagi">
                <select
                  @change="selectNumPerPage"
                  v-model="select_field_per_page_num"
                  class="form-control selectPage"
                >
                  <!--<option value="0">表示行数</option>
                  <option v-for="n in order_detail_lists.last_page" :key="n"
                :value="n">{{n}}</option>-->
                  <option value="10">10行</option>
                  <option value="20">20行</option>
                  <option value="50">50行</option>
                  <option value="100">100行</option>
                </select>
              </span>
            </p>


        <div class="">
          <table class="table table-striped table-bordered data_table">
            <thead>
              <tr>
                <th colspan="100%" style="border: none">
                  <div class="row">
                    <div class="col-6">
                      <form class="form-inline">
                        <!--<input class="form-control" type="text" placeholder="Search" aria-label="Search">
                                            <button class="btn btn-primary">検索</button>-->
                      </form>
                    </div>
                    <div class="col-6">
                      <button
                        @click="add_new_category_cmn"
                        class="btn custom_right btn-primary"
                      >
                        新規分類追加
                      </button>
                     
              <label for="insertItemCategory" class="custom-file-upload" style="float:right;margin-right:15px;padding:6px 15px;">
                <b-icon
                  icon="upload"
                  animation="fade"
                  font-scale="1.2"
                ></b-icon>
                アップロード
              </label>
              <input
                type="file"
                @change="insertItemCategory"
                id="insertItemCategory"
                class="form-control uploadBtn"
                style="display: none"
              />
              <!-- <button class="btn btn-primary active" type="button">
                <b-icon
                  icon="upload"
                  animation="fade"
                  font-scale="1.2"
                ></b-icon>
                アップロード
              </button>-->
                    </div>
                  </div>
                </th>
              </tr>
              <tr>
                <th style="cursor: pointer">No</th>
                <th style="cursor: pointer">分類名</th>
                <th style="cursor: pointer">分類コード</th>
                <th style="cursor: pointer">{{ myLang.details }}</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(cat_list, index) in (cat_lists.data)"
                :key="index"
              >
                <td>{{
                    cat_lists.current_page*select_field_per_page_num-select_field_per_page_num+index+1
                  }}</td>
                <td>{{ cat_list.category_name }}</td>
                <td>{{ cat_list.category_code }}</td>
                <td>
                  <button
                    @click="edit_category_data(cat_list)"
                    class="btn btn-primary"
                  >
                    {{ myLang.details }}</button
                  ><button
                    @click="delete_category_data(cat_list)"
                    class="btn btn-danger"
                  >
                    {{ myLang.delete }}
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <b-modal
      size="md"
      :hide-backdrop="true"
      :title="myLang.category_modal_title"
      :ok-title="myLang.add_new"
      :cancel-title="myLang.cancel"
      @ok.prevent="save_new_cat()"
      v-model="add_cmn_cat_modal"
    >
      <!-- <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
      <div class="modal-body">-->
      <div class="panel-body add_item_body">
        <form>
          <input type="hidden" v-model="form.cmn_category_id" />
          <!--<div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">category 名</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" v-model="form.name">
      <has-error :form="form" field="name"></has-error>
    </div>
  </div>-->
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-4 col-form-label">{{
              myLang.category_code
            }}</label>
            <div class="col-sm-8">
              <input
                type="text"
                class="form-control"
                maxlength="3"
                :class="{ 'is-invalid': form.errors.has('category_orign_code') }"
                v-model="form.category_orign_code"
              />
              <has-error :form="form" field="category_orign_code"></has-error>
            </div>
          </div>

          <div class="form-group row">
            <label for="category_name" class="col-sm-4 col-form-label"> 部門名</label>
            <div class="col-sm-8">
              <input
                type="text"
                class="form-control"
                maxlength="8"
                :class="{ 'is-invalid': form.errors.has('category_name') }"
                v-model="form.category_name"
              />
              <has-error :form="form" field="category_name"></has-error>
            </div>
          </div>

          <div class="form-group row">
            <label for="inputPassword" class="col-sm-4 col-form-label">{{
              myLang.select_parent_category
            }}</label>
            <div class="col-sm-8">
              <select
                class="form-control"
                :class="{ 'is-invalid': form.errors.has('parent_id') }"
                v-model="form.parent_id"
              >
                <option v-bind:value="0">{{ myLang.select_category }}</option>
                <option
                  v-for="option in options"
                  v-bind:value="option.cmn_category_id"
                  v-bind:key="option.cmn_category_id"
                >
                  {{ option.category_name }}
                </option>
              </select>
              <has-error :form="form" field="parent_id"></has-error>
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
import AdvancedLaravelVuePaginate from "advanced-laravel-vue-paginate";
import "advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css";

export default {
  components: {
    AdvancedLaravelVuePaginate,
  },
  data() {
    return {
      cat_lists: {},
      add_cmn_cat_modal: false,
      options: [],
      select_field_per_page_num:10,
      select_field_page_num:0,
      form: new Form({
        cmn_category_id: "",
        name: "",
        category_code: "",
        category_name: "",
        category_orign_code: "",
        parent_id: "",
        adm_user_id: Globals.user_info_id,
      }),
    };
  },
  methods: {
    selectNumPerPage() {

      if (this.select_field_per_page_num != 0) {
        Fire.$emit("AfterCreatecat",this.select_field_page_num);
      }
    },
    insertItemCategory(e){
      var _this = this;
      this.alert_icon = "warning";
      this.alert_title = "";
      this.alert_text = "Do you want to upload category csv";
      this.yes_btn = "はい";
      this.cancel_btn = "キャンセル";
      this.confirm_sweet().then((result) => {
        if (result.value) {
          const formData = new FormData();
          let file = e.target.files[0];
          console.log(file);
          this.loader = Vue.$loading.show();
          formData.append("file", file);
          formData.append("adm_user_id", Globals.user_info_id);
          axios
            .post(this.BASE_URL + "api/uploadByrCategoryCsv", formData)
            .then(({ data }) => {
              console.log(data);
              
              _this.alert_icon = "success";
              _this.alert_title = "Inserted";
              _this.alert_text = "Category CSV inserted";
              _this.sweet_normal_alert();

              _this.get_all_cat(_this.select_field_page_num);
              
            });
        }
      });
    },
    add_new_category_cmn() {
      this.form.reset();
      this.add_cmn_cat_modal = true;
      this.form.parent_id = 0;
    },
    edit_category_data(form_data) {
      this.add_cmn_cat_modal = true;

      this.form.reset();
      var cat_code = form_data.category_code;
      if (cat_code.substring(4, 6) != "00") {
        form_data.category_code = cat_code.substring(4, 6);
      } else if (cat_code.substring(2, 4) != "00") {
        form_data.category_code = cat_code.substring(2, 4);
      } else {
        form_data.category_code = cat_code.substring(0, 2);
      }
      this.form.fill(form_data);
      this.form.parent_id = form_data.parent_id;
    },
    save_new_cat() {
      console.log("add new");
      this.form.adm_user_id = Globals.user_info_id;
      this.form
        .post(this.BASE_URL + "api/cmn_category_create")
        .then((data) => {
          if (data.data.message == "fail") {
            var tittles = "Invalid Category";
            var msg_text = "please check parent";
            var icon = "warning";
          } else {
            this.add_cmn_cat_modal = false;
            Fire.$emit("AfterCreatecat",this.select_field_page_num);
            if (this.form.cmn_category_id != "") {
              var tittles = "Category Update success";
              var msg_text = "You have successfully updated category";
              var icon = "success";
            } else {
              var tittles = "Category added success";
              var msg_text = "You have successfully added category";
              var icon = "success";
            }
          }
          Swal.fire({
            icon: icon,
            title: tittles,
            text: msg_text,
          });
          console.log(data);
        })
        .catch((error) => {
          console.log(error);
          Swal.fire({
            icon: "warning",
            title: "Invalid category info",
            text: "check category info!",
          });
        });
    },
    get_all_cat(page = 1) {
      var post_data = {
        adm_user_id:Globals.user_info_id,
        select_field_per_page_num:this.select_field_per_page_num,
        select_field_page_num:page,
        page : page,
      };
      this.select_field_page_num=page;
      axios
        .post(this.BASE_URL + "api/get_all_cat_list",post_data)
        .then(({ data }) => {
          this.cat_lists = data.cat_list;
          this.options = data.allCatForParent;
          this.loader.hide();
        });
    },
  },

  created() {
    Fire.$emit('permission_check_for_buyer',this.$session.get('byr_buyer_id'));
    this.loader = Vue.$loading.show();
    this.get_all_cat();
    Fire.$on("AfterCreatecat", (page=1) => {
      this.get_all_cat(page);
    });
    Fire.$emit("loadPageTitle", "分類管理");
    
  },
  mounted() {
    console.log("User page loaded");
  },
};
</script>